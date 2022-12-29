<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class BaseService
{

    /**
     *
     */
    public function __construct()
    {
        $this->perPage = config('settings.per_page');
    }

    /**
     * @param JsonResponse $response
     * @return array|null
     */
    public function getResultData(JsonResponse $response): ?array
    {
        $result = $response->getData(true);

        if (empty($result) || !is_array($result) || !isset($result[0])) {
            return null;
        }

        return $result[0];
    }
}
