<?php

namespace App\Http\Controllers\Api\Questions;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Questions\Questioner;
use App\Services\Questions\QuestionerService;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Questions\QuestionerResource;
use App\Http\Requests\Api\Questions\QuestionerStoreRequest;
use App\Http\Requests\Api\Questions\QuestionerDeleteRequest;
use App\Http\Requests\Api\Questions\QuestionerUpdateRequest;

class QuestionerApiController extends BaseApiController
{

    /**
     * @param Request $request
     * @param QuestionerService $questionerService
     */
    public function __construct(Request $request, QuestionerService $questionerService)
    {
        $this->request = $request;
        $this->questionerService = $questionerService;
    }

    /**
     * @OA\Get (
     *  path="/api/questioners",
     *  summary="Get all questioners",
     *  description="Gets all questioners",
     *  tags={"Questioner"},
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
            'items' => $this->questionerService->getAll($page),
            'total' => $this->questionerService->countTotal(),
        ];

        return $this->returnOk(null, ['items' => $data]);
    }

    /**
     * @OA\Get (
     *  path="/api/questioners/{questioner}",
     *  summary="Get a single questioner",
     *  description="Gets a single questioner",
     *  tags={"Questioner"},
     *
     *  @OA\Parameter(
     *      name="questioner",
     *      in="path",
     *      description="Questioner Id",
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
     * @param Questioner $questioner
     * @return JsonResponse
     */
    public function item(Questioner $questioner): JsonResponse
    {
        $data = QuestionerResource::make($questioner);

        return $this->returnOk(null, [$data]);
    }

    /**
     * @OA\Post (
     *  path="/api/questioners",
     *  security={{"sanctum":{}}},
     *  summary="Add new questioner",
     *  description="Add new quesioner (highest level of question models)",
     *  tags={"Questioner"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Add new questioner",
     *      @OA\JsonContent(
     *          @OA\Property(property="title", type="string",example="پرسشنامه تحلیلی شماره 1", nullable="false"),
     *          @OA\Property(property="slug", type="string",example="porseshnameh_tahlili_shomareh_1", nullable="false"),
     *          @OA\Property(property="price", type="int",example="250000", nullable="true"),
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
     * @param QuestionerStoreRequest $questionerStoreRequest
     * @return JsonResponse
     */
    public function store(QuestionerStoreRequest $questionerStoreRequest): JsonResponse
    {
        $data = $this->questionerService->sanitizeStoreRequestData($this->request);

        $this->questionerService->store($data);

        return $this->returnOk(null);
    }

    /**
     * @OA\Post (
     *  path="/api/questioners/{questioner}",
     *  security={{"sanctum":{}}},
     *  summary="Update a questioner",
     *  description="Update a quesioner",
     *  tags={"Questioner"},
     *
     *  @OA\Parameter(
     *      name="questioner",
     *      in="path",
     *      description="Questioner Id",
     *      required=true
     *  ),
     *
     *  @OA\RequestBody(
     *      required=true,
     *      description="Update a quesioner",
     *      @OA\JsonContent(
     *          @OA\Property(property="title", type="string",example="پرسشنامه تحلیلی شماره 2", nullable="true"),
     *          @OA\Property(property="slug", type="string",example="porseshnameh_tahlili_shomareh_2", nullable="true"),
     *          @OA\Property(property="price", type="int",example="250000", nullable="true"),
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
     * @param QuestionerUpdateRequest $questionerUpdateRequest
     * @param Questioner $questioner
     * @return JsonResponse
     */
    public function update(QuestionerUpdateRequest $questionerUpdateRequest, Questioner $questioner): JsonResponse
    {
        $data = $this->questionerService->sanitizeStoreRequestData($this->request);

        $this->questionerService->update($questioner, $data);

        return $this->returnOk(null);
    }

    /**
     * @OA\Delete (
     *  path="/api/questioners/{questioner}/delete",
     *  security={{"sanctum":{}}},
     *  summary="Delete a questioner",
     *  description="Deletes a questioner",
     *  tags={"Questioner"},
     *
     *  @OA\Parameter(
     *      name="questioner",
     *      in="path",
     *      description="Questioner Id",
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
     * @param QuestionerDeleteRequest $questionerDeleteRequest
     * @param Questioner $questioner
     * @return JsonResponse
     */
    public function delete(QuestionerDeleteRequest $questionerDeleteRequest, Questioner $questioner): JsonResponse
    {
        $this->questionerService->delete($questioner);

        return $this->returnOk(null);
    }

}
