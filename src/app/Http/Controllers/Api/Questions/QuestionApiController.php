<?php

namespace App\Http\Controllers\Api\Questions;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Questions\Question;
use Illuminate\Support\Facades\Auth;
use App\Models\Questions\QuestionGroup;
use App\Services\Questions\QuestionService;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Questions\QuestionResource;
use App\Http\Requests\Api\Questions\QuestionGetRequest;
use App\Http\Requests\Api\Questions\QuestionStoreRequest;
use App\Http\Requests\Api\Questions\QuestionUpdateRequest;
use App\Http\Requests\Api\Questions\QuestionDeleteRequest;

class QuestionApiController extends BaseApiController
{

    /**
     * @param Request $request
     * @param QuestionService $questionService
     */
    public function __construct(Request $request, QuestionService $questionService)
    {
        $this->request = $request;
        $this->questionService = $questionService;
    }

    /**
     * @OA\Get (
     *  path="/api/question-groups/{question_group}/questions",
     *  summary="Get all questions for a question group",
     *  description="Gets all questions for a question group",
     *  tags={"Question"},
     *
     *  @OA\Parameter(
     *      name="question_group",
     *      in="path",
     *      description="Question Group Id",
     *      required=true
     *  ),
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
     * @param QuestionGroup $questionGroup
     * @return JsonResponse
     */
    public function index(QuestionGroup $questionGroup): JsonResponse
    {
        $page = ($this->request->query('page')) ?? 1;

        $data = [
            'items' => $this->questionService->getAll($questionGroup, $page),
            'total' => $this->questionService->countTotal($questionGroup),
        ];

        return $this->returnOk(null, ['items' => $data]);
    }

    /**
     * @OA\Get (
     *  path="/api/question-groups/{question_group}/questions/{question}",
     *  security={{"sanctum":{}}},
     *  summary="Get all questions for a question group",
     *  description="Gets all questions for a question group",
     *  tags={"Question"},
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
     *  @OA\Parameter(
     *      name="userId",
     *      in="query",
     *      description="User Id",
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
     * @param QuestionGetRequest $questionGetRequest
     * @param QuestionGroup $questionGroup
     * @param Question $question
     * @param Request $request
     * @return JsonResponse
     */
    public function item(QuestionGroup $questionGroup, Question $question, Request $request, QuestionGetRequest $questionGetRequest): JsonResponse
    {
        $userId = $request->get('userId') ?? Auth::id();

        $result = $this->questionService->loadQuestionWithAnswer($question, $userId);
        $data = QuestionResource::make($result);

        return $this->returnOk(null, [$data]);
    }

    /**
     * @OA\Post (
     *  path="/api/question-groups/{question_group}/questions",
     *  security={{"sanctum":{}}},
     *  summary="Add new question to a question group",
     *  description="Add new question to a question group",
     *  tags={"Question"},
     *  @OA\Parameter(
     *      name="question_group",
     *      in="path",
     *      description="Question Group Id",
     *      required=true
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Add new question to a question group",
     *      @OA\JsonContent(
     *          @OA\Property(property="title", type="string",example="عنوان سوال", nullable="false"),
     *          @OA\Property(property="type", type="string",example="multiple-choice", nullable="false"),
     *          @OA\Property(property="options", type="object", nullable="true",
     *                   @OA\Property(property="0", type="string",example="بله درست است"),
     *                   @OA\Property(property="1", type="string",example="خیر درست نیست"),
     *                   @OA\Property(property="2", type="string",example="گزینه ۱ و ۲"),
     *                   @OA\Property(property="3", type="string",example="هیچکدام"),
     *          ),
     *          @OA\Property(property="description", type="string",example="متن سوال", nullable="false"),
     *          @OA\Property(property="is_required", type="bool",example="true", nullable="true"),
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
     * @param QuestionStoreRequest $questionStoreRequest
     * @param QuestionGroup $questionGroup
     *
     * @return JsonResponse
     */
    public function store(QuestionStoreRequest $questionStoreRequest, QuestionGroup $questionGroup): JsonResponse
    {
        $data = $this->questionService->sanitizeStoreRequestData($this->request);

        $this->questionService->store($questionGroup, $data);

        return $this->returnOk(null);
    }

    /**
     * @OA\Post (
     *  path="/api/question-groups/{question_group}/questions/{question}",
     *  security={{"sanctum":{}}},
     *  summary="Updates a question",
     *  description="Updates a question on a question group",
     *  tags={"Question"},
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
     *      description="Add new question to a question group",
     *      @OA\JsonContent(
     *          @OA\Property(property="title", type="string",example="عنوان سوال", nullable="false"),
     *          @OA\Property(property="type", type="string",example="text", nullable="false"),
     *          @OA\Property(property="description", type="string",example="متن سوال", nullable="false"),
     *          @OA\Property(property="is_required", type="bool",example="true", nullable="true"),
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
     * @param QuestionUpdateRequest $questionUpdateRequest
     * @param QuestionGroup $questionGroup
     * @param Question $question
     * @return JsonResponse
     */
    public function update(
        QuestionUpdateRequest $questionUpdateRequest,
        QuestionGroup $questionGroup,
        Question $question
    ): JsonResponse {
        $data = $this->questionService->sanitizeStoreRequestData($this->request);

        $this->questionService->update($question, $data);

        return $this->returnOk(null);
    }

    /**
     * @OA\Delete (
     *  path="/api/question-groups/{question_group}/questions/{question}",
     *  security={{"sanctum":{}}},
     *  summary="Deletes a question",
     *  description="Deletes a question on a question group",
     *  tags={"Question"},
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
     * @param QuestionDeleteRequest $questionDeleteRequest
     * @param QuestionGroup $questionGroup
     * @param Question $question
     * @return JsonResponse
     */
    public function delete(
        QuestionDeleteRequest $questionDeleteRequest,
        QuestionGroup $questionGroup,
        Question $question
    ): JsonResponse {
        $this->questionService->delete($question);

        return $this->returnOk(null);
    }

}
