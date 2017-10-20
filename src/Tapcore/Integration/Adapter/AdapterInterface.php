<?php

namespace Tapcore\Integration\Adapter;

use Buzz\Message\Request;
use Tapcore\Integration\Client\Api\ApiResponse;
use Tapcore\Integration\Client\Buzz\Response;
use Tapcore\Integration\Exception\Exception as SDKException;
use Tapcore\Integration\Exception\InvalidArgumentException;
use Tapcore\Integration\Exception\NotFoundException;

interface AdapterInterface
{
    /**
     * @param string $apiMethod
     * @param array  $queryParams
     * @param array  $fields
     * @param string $method
     *
     * @return ApiResponse
     * @throws InvalidArgumentException
     * @throws NotFoundException
     * @throws SDKException
     */
    public function request($apiMethod, array $queryParams = [], array $fields = [], $method = Request::METHOD_GET);

    /**
     * @param string $apiMethod
     * @param array  $queryParams
     * @param array  $fields
     * @param string $method
     *
     * @return Response
     * @throws InvalidArgumentException
     * @throws NotFoundException
     * @throws SDKException
     */
    public function requestRaw($apiMethod, array $queryParams = [], array $fields = [], $method = Request::METHOD_GET);
}
