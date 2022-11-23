<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\BaseApiController;

class UserApiController extends BaseApiController
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @OA\post (
     * path="/api/user/auth/requestPinCode",
     * summary="Requests pin code to be sent to user cell phone",
     * description="Requests pin code to be sent to user cell phone",
     * tags={"User"},
     * @OA\RequestBody(
     *    required=true,
     *    description="generate PIN code and texts user on their cell phone",
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
    public function requestPinCode(): JsonResponse
    {
        $data = $this->sanitizeRequestPinData();

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
        return __('basic/user.notificationSentToYourMobile', ['mobile' => $mobile]);
    }


}
