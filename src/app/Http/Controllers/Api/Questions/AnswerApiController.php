<?php

namespace App\Http\Controllers\Api\Questions;

use App\Http\Requests\Api\Answer\UserAnswerFinishRequest;
use App\Models\Questions\Questioner;
use App\Models\Questions\QuestionGroup;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Questions\Question;
use App\Services\Questions\AnswerService;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Answer\UserAnswerStoreRequest;

class AnswerApiController extends BaseApiController
{

    /**
     * @param Request $request
     * @param AnswerService $answerService
     */
    public function __construct(Request $request, AnswerService $answerService)
    {
        $this->request = $request;
        $this->answerService = $answerService;
    }

    /**
     * @OA\Post (
     *  path="/api/question-groups/{question_group}/questions/{question}/answer",
     *  security={{"sanctum":{}}},
     *  summary="Add/Update question answer",
     *  description="Adds a new answer or update an existing answer on a question",
     *  tags={"Answer"},
     *
     *  @OA\Parameter(
     *      name="question_group",
     *      in="path",
     *      description="Question Group Id",
     *      required=true
     *  ),
     *  @OA\Parameter(
     *      name="question",
     *      in="path",
     *      description="Question Id",
     *      required=true
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Adds a new answer or update an existing answer on a question",
     *      @OA\JsonContent(
     *          @OA\Property(property="answer", type="string",example="پاسخ به سوال", nullable="false"),
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
     * @param UserAnswerStoreRequest $userAnswerStoreRequest
     * @param QuestionGroup $questionGroup
     * @param Question $question
     * @return JsonResponse
     */
    public function store(
        UserAnswerStoreRequest $userAnswerStoreRequest,
        QuestionGroup $questionGroup,
        Question $question
    ): JsonResponse {
        $data = $this->answerService->sanitizeStoreRequestData($this->request);

        $this->answerService->store($question, $data);

        return $this->returnOk(null);
    }

    /**
     * @OA\Get (
     *  path="/api/questioners/{questioner}/finish",
     *  security={{"sanctum":{}}},
     *  summary="Finish answering a questioner",
     *  description="Finish answering a questioner and mark it as completed",
     *  tags={"Answer"},
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
     * @param UserAnswerFinishRequest $userAnswerFinishRequest
     * @param Questioner $questioner
     * @return JsonResponse
     */
    public function finish(UserAnswerFinishRequest $userAnswerFinishRequest, Questioner $questioner): JsonResponse
    {
        $this->answerService->finish($questioner);

        return $this->returnOk(null);
    }

}
