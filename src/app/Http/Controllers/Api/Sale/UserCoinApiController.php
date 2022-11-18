<?php

namespace App\Http\Controllers\Api\Sale;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\BaseApiController;
use App\Interfaces\Services\Sale\IUserCoinService;
use App\Http\Requests\Api\Sale\StoreUserCoinPurchaseValidation;


class UserCoinApiController extends BaseApiController
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var IUserCoinService
     */
    private IUserCoinService $userCoinService;

    /**
     * @param Request $request
     * @param IUserCoinService $userCoinService
     */
    public function __construct(Request $request, IUserCoinService $userCoinService)
    {
        $this->request = $request;
        $this->userCoinService = $userCoinService;
    }

    /**
     * @OA\put (
     * path="/api/user/coins/purchase",
     * summary="store new user coin purchase",
     * description="store new user coin purchase",
     * tags={"Coins"},
     * @OA\RequestBody(
     *    required=true,
     *    description="store new user coin purchase",
     *  @OA\JsonContent(
     *      @OA\Property(property="coinName", type="string",example="ABAN"),
     *      @OA\Property(property="amount", type="float",example=3),
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
     * @param StoreUserCoinPurchaseValidation $userCoinPurchaseValidation
     * @return JsonResponse
     */
    public function newPurchase(StoreUserCoinPurchaseValidation $userCoinPurchaseValidation): JsonResponse
    {
        $data = $this->sanitizeStoreData();

        $this->userCoinService->purchaseUserCoin($data);

        return $this->returnOk("purchase success");
    }

    /**
     * @return array
     */
    public function sanitizeStoreData(): array
    {
        return [
            'userId' => 1, // just get the first user, no authentication needed for this task
            'coinName' => $this->request->post('coinName'),
            'amount' => $this->request->post('amount'),
        ];
    }


}
