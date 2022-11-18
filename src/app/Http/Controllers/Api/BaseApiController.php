<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * @OA\Info(title="AbanTether Task by Ali Jomehri", version="0.1")
 */
class BaseApiController extends Controller
{
    const JSON_RESPONSE_SUCCESS = 'success';
    const JSON_RESPONSE_WARNING = 'warning';
    const JSON_RESPONSE_ERROR = 'error';

    const RETURN_CODE_OK = 200;
    const RETURN_CODE_NOT_FOUND = 404;
    const RETURN_CODE_INVALID = 406;
    const RETURN_CODE_SERVER_ERROR = 500;

    /**
     * @param string $responseStatus
     * @param array|null $data
     * @param string|null $message
     * @return JsonResponse
     */
    private function returnResult(string $responseStatus, ?array $data = [], ?string $message = null): JsonResponse
    {
        return response()->json(
            [
                "status" => self::JSON_RESPONSE_SUCCESS,
                "code" => self::RETURN_CODE_OK,
                "message" => $message,
                "result" => $data,
            ],
            self::RETURN_CODE_OK
        );
    }

    /**
     * @param string|null $message
     * @param mixed|null $data
     * @return JsonResponse
     */
    public function returnOk(?string $message = "", ?array $data = []): JsonResponse
    {
        return $this->returnResult(self::JSON_RESPONSE_SUCCESS, $data, $message);
    }

    /**
     * @param string|null $message
     * @param mixed|null $data
     * @return JsonResponse
     */
    public function returnError(?string $message = "", ?array $data = []): JsonResponse
    {
        return $this->returnResult(self::JSON_RESPONSE_ERROR, $data, $message);
    }

    /**
     * @param string|null $message
     * @param mixed|null $data
     * @return JsonResponse
     */
    public function returnWarning(?string $message = "", ?array $data = []): JsonResponse
    {
        return $this->returnResult(self::JSON_RESPONSE_WARNING, $data, $message);
    }


}
