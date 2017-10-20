<?php

namespace Tapcore\Integration\Client\Api;

use Tapcore\Integration\Client\Buzz\Response;
use Tapcore\Integration\Exception\Exception;

class ApiResponseFactory
{
    /**
     * @param Response $response
     *
     * @return ApiResponse
     * @throws Exception
     */
    public static function createFromResponse(Response $response)
    {
        $apiResponse = new ApiResponse(
            $response->getContent(),
            $response->getExtraHeaders(),
            $response
        );

        return $apiResponse;
    }
}
