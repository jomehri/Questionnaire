<?php

namespace App\Http\Controllers\Api\Profile;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Profile\ProfileService;
use App\Http\Controllers\Api\BaseApiController;

class ProfileApiController extends BaseApiController
{

    /**
     * @param Request $request
     * @param ProfileService $profileService
     */
    public function __construct(Request $request, ProfileService $profileService)
    {
        $this->request = $request;
        $this->profileService = $profileService;
    }

    /**
     * @OA\get (
     *  path="/api/profile/general",
     *  security={{"sanctum":{}}},
     *  summary="General profile details",
     *  description="General profile detils for logged in user",
     *  tags={"Profile"},
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
    public function general(): JsonResponse
    {
        $data = $this->profileService->getUserDetails();

        return $this->returnOk(null, ['items' => $data]);
    }

}
