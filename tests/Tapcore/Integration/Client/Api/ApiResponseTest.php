<?php

namespace Tapcore\Integration\Client\Api;

use PHPUnit\Framework\TestCase;
use Tapcore\Integration\Client\Buzz\Response;

class ApiResponseTest extends TestCase
{
    public function testCreating()
    {
        /** @var Response $sourceResponse */
        $sourceResponse = $this->getMock(Response::class);

        /** @var ExtraHeaders $extraHeaders */
        $extraHeaders = $this->getMock(ExtraHeaders::class);

        $response = new ApiResponse(['test' => 'value'], $extraHeaders, $sourceResponse);

        $this->assertArrayHasKey('test', $response->getData());
        $this->assertSame('value', $response->getData()['test']);
        $this->assertSame($extraHeaders, $response->getExtraHeaders());
        $this->assertSame($sourceResponse, $response->getSourceResponse());
    }
}
