<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\User\UserService;
use App\Http\Controllers\Api\BaseApiController;
use App\Exceptions\User\UserPinHasExpiredException;
use App\Exceptions\User\UserPinIsIncorrectException;
use App\Http\Requests\Api\User\UserLoginTokenValidation;
use App\Http\Requests\Api\User\UserLoginPinRequestValidation;
use App\Exceptions\User\UserPreviousPinNotExpiredYetException;
use App\Http\Requests\Api\User\UserRegisterPinRequestValidation;

class UserApiController extends BaseApiController
{

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
     *  path="/api/user/register/request",
     *  summary="Registers new user",
     *  description="Registers new user, a 7 digit pin code will be sent to user's mobile, which will be expired in 2 minutes",
     *  tags={"Authentication"},
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
     * @param UserRegisterPinRequestValidation $registerPinRequestValidation
     * @return JsonResponse
     */
    public function registerRequest(UserRegisterPinRequestValidation $registerPinRequestValidation): JsonResponse
    {
        $data = $this->userService->sanitizeRegisterRequestData($this->request);

        $this->userService->registerRequest($data);

        return $this->returnOk($this->userService->getPinRequestSuccessMessage('register', $data['mobile']));
    }

    /**
     * @OA\post (
     *  path="/api/user/login/request",
     *  summary="Login request for a user",
     *  description="Login request for a user, a 7 digit pin code will be sent to user's mobile, which will be expired in 2 minutes",
     *  tags={"Authentication"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Login request for existing user",
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
     * @param UserLoginPinRequestValidation $loginPinRequestValidation
     * @return JsonResponse
     * @throws UserPreviousPinNotExpiredYetException
     */
    public function loginRequest(UserLoginPinRequestValidation $loginPinRequestValidation): JsonResponse
    {
        $data = $this->userService->sanitizeLoginRequestData($this->request);

        $this->userService->loginRequest($data);

        return $this->returnOk($this->userService->getPinRequestSuccessMessage('login', $data['mobile']));
    }

    /**
     * @OA\post (
     *  path="/api/user/login/token",
     *  summary="Logs user in by pincode",
     *  description="Logs user in by inserting mobile and received pin code, returns generated token",
     *  tags={"Authentication"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Returns user token providing following credentials",
     *      @OA\JsonContent(
     *          @OA\Property(property="mobile", type="string",example="09123456789", nullable="false"),
     *          @OA\Property(property="pin_code", type="string",example="1234567", nullable="false"),
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
     * @param UserLoginTokenValidation $userLoginTokenValidation
     * @return JsonResponse
     * @throws UserPinHasExpiredException
     * @throws UserPinIsIncorrectException
     */
    public function loginToken(UserLoginTokenValidation $userLoginTokenValidation): JsonResponse
    {
        $data = $this->userService->sanitizeLoginTokenData($this->request);

        $token = $this->userService->generateToken($data);

        return $this->returnOk(__("basic/user.validation.loginSuccessful"), ['token' => $token]);
    }

}
