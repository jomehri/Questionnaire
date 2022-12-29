<?php

namespace App\Http\Controllers\Api\Questions;

use App\Exceptions\Questions\QuestionerWithQuestionsCantBeDeletedException;
use App\Models\Questions\Questioner;
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
     *  path="/api/questioners",
     *  security={{"sanctum":{}}},
     *  summary="Add new questioner",
     *  description="Add new quesioner (highest level of question models)",
     *  tags={"Questioner"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Registers new user",
     *      @OA\JsonContent(
     *          @OA\Property(property="title", type="string",example="پرسشنامه تحلیلی شماره 1", nullable="false"),
     *          @OA\Property(property="slug", type="string",example="porseshnameh_tahlili_shomareh_1", nullable="false"),
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
     * @OA\delete (
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
     * @param Questioner $questioner
     * @return JsonResponse
     * @throws QuestionerWithQuestionsCantBeDeletedException
     */
    public function delete(Questioner $questioner): JsonResponse
    {
        $this->questionerService->delete($questioner);

        return $this->returnOk(null);
    }

}
