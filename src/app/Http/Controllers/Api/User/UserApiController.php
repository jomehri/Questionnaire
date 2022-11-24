<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\User\UserService;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\User\UserLoginValidation;
use App\Http\Requests\Api\User\UserRegisterValidation;
use App\Exceptions\User\UserPreviousPinNotExpiredYetException;

class UserApiController extends BaseApiController
{
    /** @var Request */
    private Request $request;

    /** @var UserService */
    private UserService $userService;

    /**
     * @param Request $request
     * @param UserService $userService
     */
    public function __construct(Request $request, UserService $userService)
    {
        $this->request = $request;
        $this->userService = $userService;
    }

    /**
     * @OA\post (
     *  path="/api/user/register",
     *  summary="Registers new user",
     *  description="Registers new user, a 7 digit pin code will be sent to user's mobile, which will be expired in 2 minutes",
     *  tags={"User"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Registers new user",
     *      @OA\JsonContent(
     *          @OA\Property(property="first_name", type="string",example="دوا", nullable="true"),
     *          @OA\Property(property="last_name", type="string",example="لیپا", nullable="true"),
     *          @OA\Property(property="mobile", type="string",example="09123456789", nullable="false"),
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
     * @param UserRegisterValidation $userRegisterValidation
     * @return JsonResponse
     */
    public function register(UserRegisterValidation $userRegisterValidation): JsonResponse
    {
        $data = $this->userService->sanitizeRegisterRequestData($this->request);

        $this->userService->register($data);

        return $this->returnOk($this->userService->getPinRequestSuccessMessage($data['mobile']));
    }

    /**
     * @OA\post (
     *  path="/api/user/login",
     *  summary="Login request for a user",
     *  description="Login request for a user, a 7 digit pin code will be sent to user's mobile, which will be expired in 2 minutes",
     *  tags={"User"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Registers new user",
     *      @OA\JsonContent(
     *          @OA\Property(property="mobile", type="string",example="09123456789", nullable="false"),
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
     *  @OA\Response(
     *      response=500,
     *      description="bad request",
     *  ),
     * ),
     *
     * @param UserLoginValidation $userRegisterValidation
     * @return JsonResponse
     * @throws UserPreviousPinNotExpiredYetException
     */
    public function login(UserLoginValidation $userRegisterValidation): JsonResponse
    {
        $data = $this->userService->sanitizeLoginRequestData($this->request);

        $this->userService->login($data);

        return $this->returnOk($this->userService->getPinRequestSuccessMessage($data['mobile']));
    }

}
