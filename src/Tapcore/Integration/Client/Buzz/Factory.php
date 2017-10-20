<?php

namespace Tapcore\Integration\Client\Buzz;

use Buzz\Message\Factory\FactoryInterface;
use Buzz\Message\RequestInterface;

class Factory implements FactoryInterface
{
    /**
     * @param string $method
     * @param string $resource
     * @param null $host
     * @return Request
     */
    public function createRequest($method = RequestInterface::METHOD_GET, $resource = '/', $host = null)
    {
        return new Request($method, $resource, $host);
    }

    /**
     * @param string $method
     * @param string $resource
     * @param null $host
     * @return Request
     */
    public function createFormRequest($method = RequestInterface::METHOD_POST, $resource = '/', $host = null)
    {
        return new Request($method, $resource, $host);
    }

    /**
     * @return Response
     */
    public function createResponse()
    {
        return new Response();
    }
}
