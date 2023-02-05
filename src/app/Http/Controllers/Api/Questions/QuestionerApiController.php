<?php

namespace App\Http\Controllers\Api\Questions;

use App\Http\Requests\Api\Questions\QuestionerParticipantsRequest;
use App\Http\Resources\Questions\QuestionerParticipantResource;
use App\Http\Resources\User\UserAnswerResource;
use App\Models\Basic\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Questions\Questioner;
use Illuminate\Support\Facades\Auth;
use App\Services\Questions\QuestionerService;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Questions\QuestionerResource;
use App\Http\Requests\Api\Questions\QuestionerGetRequest;
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
     *  security={{"sanctum":{}}},
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
     * @param QuestionerGetRequest $questionerGetRequest
     * @return JsonResponse
     */
    public function index(QuestionerGetRequest $questionerGetRequest): JsonResponse
    {
        $userId = $this->request->get('userId') ?? Auth::id();
        $page = ($this->request->query('page')) ?? 1;

        $data = [
            'items' => $this->questionerService->getAll($page, $userId),
            'total' => $this->questionerService->countTotal(),
        ];

        return $this->returnOk(null, ['items' => $data]);
    }

    /**
     * @OA\Get (
     *  path="/api/questioners/{questioner}",
     *  security={{"sanctum":{}}},
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
     * @param Questioner $questioner
     * @param QuestionerGetRequest $questionerGetRequest
     * @return JsonResponse
     */
    public function item(Questioner $questioner, QuestionerGetRequest $questionerGetRequest): JsonResponse
    {
        $userId = $this->request->get('userId') ?? Auth::id();

        $data = $this->questionerService->getItem($questioner, $userId);
        $data = QuestionerResource::make($data);

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

    /**
     * @OA\Get (
     *  path="/api/questioners/{questioner}/participants",
     *  security={{"sanctum":{}}},
     *  summary="List of participated users on a questioner",
     *  description="Gets list of participated users on a questioner",
     *  tags={"Questioner"},
     *
     *  @OA\Parameter(
     *      name="questioner",
     *      in="path",
     *      description="Questioner Id",
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
     * @param QuestionerParticipantsRequest $questionerParticipantsRequest
     * @param Questioner $questioner
     * @return JsonResponse
     */
    public function participants(
        QuestionerParticipantsRequest $questionerParticipantsRequest,
        Questioner $questioner
    ): JsonResponse {
        $page = ($this->request->query('page')) ?? 1;

        $data = [
            'items' => $this->questionerService->getAllParticipants($page, $questioner->getId()),
            'total' => $this->questionerService->countTotalParticipants($questioner->getId()),
        ];

        return $this->returnOk(null, ['items' => $data]);
    }

    /**
     * @OA\Get (
     *  path="/api/questioners/{questioner}/participants/{user}",
     *  security={{"sanctum":{}}},
     *  summary="List of participated users on a questioner",
     *  description="Gets list of participated users on a questioner",
     *  tags={"Questioner"},
     *
     *  @OA\Parameter(
     *      name="questioner",
     *      in="path",
     *      description="Questioner Id",
     *      required=true
     *  ),
     *  @OA\Parameter(
     *      name="user",
     *      in="path",
     *      description="User Id",
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
     * @param User $user
     * @param QuestionerParticipantsRequest $questionerParticipantsRequest
     * @return JsonResponse
     */
    public function participant(
        Questioner $questioner,
        User $user,
        QuestionerParticipantsRequest $questionerParticipantsRequest,
    ): JsonResponse {
        $data = $this->questionerService->getParticipant($questioner->getId(), $user->getId());
        $data = $data ? QuestionerParticipantResource::make($data) : null;

        return $this->returnOk(null, $data ? [$data] : null);
    }

    /**
     * @OA\Get (
     *  path="/api/questioners/{questioner}/answers/{user}",
     *  security={{"sanctum":{}}},
     *  summary="List of answers for users on a questioner",
     *  description="Gets list of answers for a user on a questioner",
     *  tags={"Questioner"},
     *
     *  @OA\Parameter(
     *      name="questioner",
     *      in="path",
     *      description="Questioner Id",
     *      required=true
     *  ),
     *  @OA\Parameter(
     *      name="user",
     *      in="path",
     *      description="User Id",
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
     * @param User $user
     * @param QuestionerParticipantsRequest $questionerParticipantsRequest
     * @return JsonResponse
     */
    public function userAnswers(
        Questioner $questioner,
        User $user,
        QuestionerParticipantsRequest $questionerParticipantsRequest,
    ): JsonResponse {
        $data = $this->questionerService->getUserAnswers($questioner->getId(), $user->getId());
        $data = UserAnswerResource::collection($data);

        return $this->returnOk(null, [$data]);
    }

}
