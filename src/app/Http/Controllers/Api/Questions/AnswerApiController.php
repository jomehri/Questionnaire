<?php

namespace App\Http\Controllers\Api\Questions;

use App\Http\Requests\Api\Answer\UserAnswerStoreRequest;
use App\Models\Questions\Question;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Questions\QuestionGroup;
use App\Services\Questions\AnswerService;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Questions\QuestionStoreRequest;

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
     *  path="/api/questions/{question}/answer",
     *  security={{"sanctum":{}}},
     *  summary="Add/Update question answer",
     *  description="Adds a new answer or update an existing answer on a question",
     *  tags={"Answer"},
     *
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
     * @param Question $question
     * @return JsonResponse
     */
    public function store(UserAnswerStoreRequest $userAnswerStoreRequest, Question $question): JsonResponse
    {
        $data = $this->answerService->sanitizeStoreRequestData($this->request);

        $this->answerService->store($question, $data);

        return $this->returnOk(null);
    }

}
