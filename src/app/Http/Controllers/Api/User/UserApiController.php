<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Basic\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\User\UserService;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\User\UserRoleAddRequest;
use App\Exceptions\User\UserPinHasExpiredException;
use App\Exceptions\User\UserPinIsIncorrectException;
use App\Http\Requests\Api\User\UserRoleRemoveRequest;
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
     * @OA\Post (
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
     * @OA\Post (
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

        // TODO @aliJo return void when sms panel launched
        $result = $this->userService->loginRequest($data);

        return $this->returnOk(
            $this->userService->getPinRequestSuccessMessage('login', $data['mobile']),
            ['token_temp_remove_when_sms_panel_launched' => $result]
        );
    }

    /**
     * @OA\Post (
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

        return $this->returnOk(null, ['token' => $token]);
    }

    /**
     * @OA\get (
     *  path="/api/user/logout",
     *  security={{"sanctum":{}}},
     *  summary="Logs out the user",
     *  description="Logs out the user and removes token",
     *  tags={"Authentication"},
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
     *  @OA\Response(
     *      response=500,
     *      description="bad request",
     *  ),
     * ),
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $this->userService->logout();

        return $this->returnOk(null);
    }

    /**
     * @OA\get (
     *  path="/api/users",
     *  security={{"sanctum":{}}},
     *  summary="List users on admin panel",
     *  description="Lists all users on admin panel",
     *  tags={"User"},
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
     *  @OA\Response(
     *      response=500,
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
            'items' => $this->userService->getAll(),
            'total' => $this->userService->countTotal(),
        ];

        return $this->returnOk(null, ['items' => $data]);
    }

    /**
     * @OA\delete (
     *  path="/api/users/{user}/super-admin",
     *  security={{"sanctum":{}}},
     *  summary="Remove super admin role for a user",
     *  description="Removes super admin role for a user",
     *  tags={"User"},
     *
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
     *  @OA\Response(
     *      response=500,
     *      description="bad request",
     *  ),
     * ),
     *
     * @param UserRoleRemoveRequest $userRoleRemoveRequest
     * @param User $user
     * @return JsonResponse
     */
    public function removeSuperAdmin(UserRoleRemoveRequest $userRoleRemoveRequest, User $user): JsonResponse
    {
        $this->userService->removeSuperAdmin($user);

        return $this->returnOk(null);
    }

    /**
     * @OA\post (
     *  path="/api/users/{user}/super-admin",
     *  security={{"sanctum":{}}},
     *  summary="Add super admin role for a user",
     *  description="Adds super admin role for a user",
     *  tags={"User"},
     *
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
     *  @OA\Response(
     *      response=500,
     *      description="bad request",
     *  ),
     * ),
     *
     * @param UserRoleAddRequest $userRoleAddRequest
     * @param User $user
     * @return JsonResponse
     */
    public function addSuperAdmin(UserRoleAddRequest $userRoleAddRequest, User $user): JsonResponse
    {
        $this->userService->addSuperAdmin($user);

        return $this->returnOk(null);
    }

    /**
     * @OA\get (
     *  path="/api/user/is-admin",
     *  security={{"sanctum":{}}},
     *  summary="User is admin or not",
     *  description="Checks whether the logged in user is admin or not",
     *  tags={"Authentication"},
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
     *  @OA\Response(
     *      response=500,
     *      description="bad request",
     *  ),
     * ),
     *
     * @return JsonResponse
     */
    public function isAdmin(): JsonResponse
    {
        $result = $this->userService->isAdmin();

        return $this->returnOk(null, ['is_admin' => $result]);
    }

}
