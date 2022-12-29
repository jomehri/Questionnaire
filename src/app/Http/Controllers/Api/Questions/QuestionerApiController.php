<?php

namespace App\Http\Controllers\Api\Questions;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Questions\QuestionerService;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Questions\QuestionerStoreRequest;

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
     * @OA\post (
     *  path="/api/questioner",
     *  security={{"sanctum":{}}},
     *  summary="Add new questioner",
     *  description="Add new quesioner (highest level of question models)",
     *  tags={"Questioner"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Registers new user",
     *      @OA\JsonContent(
     *          @OA\Property(property="title", type="string",example="پرسشنامه تحلیلی شماره 1", nullable="false"),
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

}
