<?php

namespace App\Http\Controllers\Api\Sale;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Sale\SaleService;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Sale\AddToCartRequest;
use App\Http\Requests\Api\Sale\RemoveFromCartRequest;

class SaleApiController extends BaseApiController
{

    /**
     * @param Request $request
     * @param SaleService $saleService
     */
    public function __construct(Request $request, SaleService $saleService)
    {
        $this->request = $request;
        $this->saleService = $saleService;
    }

    /**
     * @OA\Post (
     *  path="/api/sales/addToCart",
     *  security={{"sanctum":{}}},
     *  summary="Add new questioner to user's cart",
     *  description="Adds a new questioner to user's cart",
     *  tags={"Sale"},
     *
     *  @OA\RequestBody(
     *      required=true,
     *      description="Adds a new questioner to user's cart",
     *      @OA\JsonContent(
     *          @OA\Property(property="questioner_id", example="1"),
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
     * @param AddToCartRequest $addToCartRequest
     * @return JsonResponse
     */
    public function addToCart(AddToCartRequest $addToCartRequest): JsonResponse
    {
        $data = $this->saleService->sanitizeStoreRequestData($this->request);

        $this->saleService->addToCart($data);

        $cartDetails = $this->saleService->getCurrentCartDetails();

        return $this->returnOk(null, [$cartDetails]);
    }

    /**
     * @OA\Delete (
     *  path="/api/sales/removeFromCart/orderItem/{order_item_id}",
     *  security={{"sanctum":{}}},
     *  summary="Remove an orderItem from user's cart",
     *  description="Removes an orderItem from user's cart",
     *  tags={"Sale"},
     *
     *  @OA\Parameter(
     *      name="order_item_id",
     *      in="path",
     *      description="Order Item Id",
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
     * @param RemoveFromCartRequest $removeFromCartRequest
     * @param int $order_item_id
     * @return JsonResponse
     */
    public function removeFromCart(RemoveFromCartRequest $removeFromCartRequest, int $order_item_id): JsonResponse
    {
        $this->saleService->removeFromCart($order_item_id);

        $cartDetails = $this->saleService->getCurrentCartDetails();

        return $this->returnOk(null, [$cartDetails]);
    }

    /**
     * @OA\Get (
     *  path="/api/sales/currentCart",
     *  security={{"sanctum":{}}},
     *  summary="Get user's cart",
     *  description="Gets user's active cart",
     *  tags={"Sale"},
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
     * @return JsonResponse
     */
    public function getCurrentCart(): JsonResponse
    {
        $cartDetails = $this->saleService->getCurrentCartDetails();

        return $this->returnOk(null, $cartDetails ? [$cartDetails] : null);
    }

    /**
     * @OA\Get (
     *  path="/api/sales/myOrders",
     *  security={{"sanctum":{}}},
     *  summary="Get user's orders",
     *  description="Gets current user's orders history",
     *  tags={"Sale"},
     *
     *  @OA\Parameter(
     *      name="page",
     *      in="query",
     *      description="Page Number",
     *      required=false
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
     * @return JsonResponse
     */
    public function getMyOrders(): JsonResponse
    {
        $page = ($this->request->query('page')) ?? 1;

        $data = [
            'items' => $this->saleService->getMyOrders($page),
            'total' => $this->saleService->countMyOrders(),
        ];

        return $this->returnOk(null, ['items' => $data]);
    }

}
