<?php

namespace App\Http\Controllers\Api\Questions;

use App\Http\Requests\Api\Questions\QuestionStoreRequest;
use App\Models\Questions\QuestionGroup;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Questions\QuestionService;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Questions\QuestionGroupStoreRequest;

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
     * @OA\Post (
     *  path="/api/question-groups/{question_group}/questions",
     *  security={{"sanctum":{}}},
     *  summary="Add new question to a question group",
     *  description="Add new question to a question group (connected to several questioners)",
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
     *          @OA\Property(property="type", type="string",example="text", nullable="false"),
     *          @OA\Property(property="description", type="string",example="متن سوال", nullable="false"),
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

}
