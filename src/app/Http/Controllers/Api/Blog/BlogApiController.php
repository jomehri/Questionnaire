<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Requests\Api\Blog\BlogDeleteRequest;
use App\Http\Resources\Blog\BlogItemResource;
use App\Models\Blog\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Blog\BlogService;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Blog\BlogStoreRequest;
use App\Http\Requests\Api\Blog\BlogUpdateRequest;

class BlogApiController extends BaseApiController
{

    /**
     * @param Request $request
     * @param BlogService $blogService
     */
    public function __construct(Request $request, BlogService $blogService)
    {
        $this->request = $request;
        $this->blogService = $blogService;
    }

    /**
     * @OA\Post (
     *  path="/api/blogs",
     *  security={{"sanctum":{}}},
     *  summary="Add new blog post",
     *  description="Adds a new blog post",
     *  tags={"Blog"},
     *
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      description="Image to upload",
     *                      property="image",
     *                      type="file",
     *                  ),
     *                  @OA\Property(property="title", type="string",example="عنوان پست شماره ۱ وبلاگ", nullable="false"),
     *                  @OA\Property(property="slug", type="string",example="آدرس_پست_وبلاگ_شماره_۱", nullable="false"),
     *                  @OA\Property(property="body", type="string", format="textarea",example="بدنه پست وبلاگ و سازگار با تگ های <u><b><i>HTML</i></b></u> می باشد
     * بدنه پست وبلاگ و سازگار با تگ های <u><b><i>HTML</i></b></u> می باشدبدنه پست وبلاگ و سازگار با تگ های <u><b><i>HTML</i></b></u> می باشد
     *     بدنه پست وبلاگ و سازگار با تگ های <u><b><i>HTML</i></b></u> می باشدبدنه پست وبلاگ و سازگار با تگ های <u><b><i>HTML</i></b></u> می باشد"),
     *                  required={"image", "title", "slug", "body"},
     *             ),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="success",
     *      @OA\JsonContent(
     *          @OA\Property(property="sucess", type="string", example="success"),
     *      )
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="bad request",
     *  ),
     * ),
     *
     * @param BlogStoreRequest $blogStoreRequest
     * @return JsonResponse
     */
    public function store(BlogStoreRequest $blogStoreRequest): JsonResponse
    {
        $data = $this->blogService->sanitizeStoreRequestData($this->request);

        $this->blogService->store($data);

        return $this->returnOk(null);
    }

    /**
     * @OA\Post (
     *  path="/api/blogs/{blog}",
     *  security={{"sanctum":{}}},
     *  summary="Update a blog post",
     *  description="Updates a blog post",
     *  tags={"Blog"},
     *
     *  @OA\Parameter(
     *      name="blog",
     *      in="path",
     *      description="Blog Post Id",
     *      required=true
     *  ),
     *
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      description="Image to upload",
     *                      property="image",
     *                      type="file",
     *                  ),
     *                  @OA\Property(property="title", type="string",example="عنوان پست شماره ۱ وبلاگ", nullable="false"),
     *                  @OA\Property(property="slug", type="string",example="آدرس_پست_وبلاگ_شماره_۱", nullable="false"),
     *                  @OA\Property(property="body", type="string", format="textarea",example="بدنه پست وبلاگ و سازگار با تگ های <u><b><i>HTML</i></b></u> می باشد
     * بدنه پست وبلاگ و سازگار با تگ های <u><b><i>HTML</i></b></u> می باشدبدنه پست وبلاگ و سازگار با تگ های <u><b><i>HTML</i></b></u> می باشد
     *     بدنه پست وبلاگ و سازگار با تگ های <u><b><i>HTML</i></b></u> می باشدبدنه پست وبلاگ و سازگار با تگ های <u><b><i>HTML</i></b></u> می باشد"),
     *             ),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="success",
     *      @OA\JsonContent(
     *          @OA\Property(property="sucess", type="string", example="success"),
     *      )
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="bad request",
     *  ),
     * ),
     *
     * @param BlogUpdateRequest $blogUpdateRequest
     * @param Blog $blog
     * @return JsonResponse
     */
    public function update(BlogUpdateRequest $blogUpdateRequest, Blog $blog): JsonResponse
    {
        $data = $this->blogService->sanitizeStoreRequestData($this->request);

        $this->blogService->update($blog, $data);

        return $this->returnOk(null);
    }

    /**
     * @OA\Get (
     *  path="/api/blogs",
     *  summary="Get blog posts",
     *  description="Gets all blog posts by pagination",
     *  tags={"Blog"},
     *
     *  @OA\Parameter(
     *      name="page",
     *      in="query",
     *      description="Page Number",
     *      required=false
     *  ),
     *
     *  @OA\Response(
     *      response=200,
     *      description="success",
     *      @OA\JsonContent(
     *          @OA\Property(property="sucess", type="string", example="success"),
     *      )
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="bad request",
     *  ),
     * ),
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $page = ($this->request->query('page')) ?? 1;

        $data = [
            'items' => $this->blogService->getAll($page),
            'total' => $this->blogService->countTotal(),
        ];

        return $this->returnOk(null, ['items' => $data]);
    }

    /**
     * @OA\Get (
     *  path="/api/blogs/{blog}",
     *  summary="Get a blog post",
     *  description="Gets a blog post by its id",
     *  tags={"Blog"},
     *
     *  @OA\Parameter(
     *      name="blog",
     *      in="path",
     *      description="Blog Post Id",
     *      required=true
     *  ),
     *
     *  @OA\Response(
     *      response=200,
     *      description="success",
     *      @OA\JsonContent(
     *          @OA\Property(property="sucess", type="string", example="success"),
     *      )
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="bad request",
     *  ),
     * ),
     *
     * @param Blog $blog
     * @return JsonResponse
     */
    public function item(Blog $blog): JsonResponse
    {
        $data = BlogItemResource::make($blog);

        return $this->returnOk(null, [$data]);
    }

    /**
     * @OA\Delete (
     *  path="/api/blogs/{blog}",
     *  security={{"sanctum":{}}},
     *  summary="Delete a blog post",
     *  description="Deletes a blog post by its id",
     *  tags={"Blog"},
     *
     *  @OA\Parameter(
     *      name="blog",
     *      in="path",
     *      description="Blog Post Id",
     *      required=true
     *  ),
     *
     *  @OA\Response(
     *      response=200,
     *      description="success",
     *      @OA\JsonContent(
     *          @OA\Property(property="sucess", type="string", example="success"),
     *      )
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="bad request",
     *  ),
     * ),
     *
     * @param BlogDeleteRequest $blogDeleteRequest
     * @param Blog $blog
     * @return JsonResponse
     */
    public function delete(BlogDeleteRequest $blogDeleteRequest, Blog $blog): JsonResponse
    {
        $this->blogService->delete($blog);

        return $this->returnOk(null);
    }

}
