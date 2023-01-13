<?php

namespace App\Http\Controllers\Api\Blog;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Blog\BlogService;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Blog\BlogStoreRequest;

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
     *                  @OA\Property(property="body", type="string",example="بدنه پست وبلاگ و سازگار با تگ های <u><b><i>HTML</i></b></u> می باشد
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

}
