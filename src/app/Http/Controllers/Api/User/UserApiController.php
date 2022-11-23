<?php

namespace App\Http\Controllers\Api\User;

use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\BaseApiController;

class UserApiController extends BaseApiController
{
    /** @var Request */
    private Request $request;

    /** @var UserService  */
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
     * path="/api/user/register",
     * summary="Registers new user",
     * description="Registers new user",
     * tags={"User"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Registers new user",
     *  @OA\JsonContent(
     *      @OA\Property(property="mobile", type="string",example="09123456789"),
     *  ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="success",
     *    @OA\JsonContent(
     *       @OA\Property(property="sucess", type="string", example="success"),
     *        )
     *     ),
     * )
     *
     * @return JsonResponse
     */
    public function register(): JsonResponse
    {
        $data = $this->sanitizeRequestPinData();

        $this->userService->register($data);

        return $this->returnOk($this->getPinRequestSuccessMessage($data['mobile']));
    }

    /**
     * @return array
     */
    private function sanitizeRequestPinData(): array
    {
        return [
            'mobile' => $this->request->post('mobile'),
        ];
    }

    /**
     * @param $mobile
     * @return string
     */
    private function getPinRequestSuccessMessage($mobile): string
    {
        return __('basic/user.registerSuccess', ['mobile' => $mobile]);
    }


}
