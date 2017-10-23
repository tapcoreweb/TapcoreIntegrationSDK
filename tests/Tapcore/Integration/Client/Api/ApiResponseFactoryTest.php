<?php

namespace Tapcore\Integration\Client\Api;

use PHPUnit\Framework\TestCase;
use Tapcore\Integration\Client\Buzz\Response;

class ApiResponseFactoryTest extends TestCase
{
    /**
     * @throws \Tapcore\Integration\Exception\Exception
     */
    public function testCreateFromResponse()
    {
        $extraHeaders = $this->getMock(ExtraHeaders::class);

        /** @var Response|\PHPUnit_Framework_MockObject_MockObject $response */
        $response = $this->getMock(Response::class);
        $response->expects($this->once())->method('getContent')->willReturn([123]);
        $response->expects($this->once())->method('getExtraHeaders')->willReturn($extraHeaders);

        $apiResponse = ApiResponseFactory::createFromResponse($response);
        $this->assertInstanceOf(ApiResponse::class, $apiResponse);
        $this->assertSame($extraHeaders, $apiResponse->getExtraHeaders());
        $this->assertCount(1, $apiResponse->getData());
        $this->assertSame(123, $apiResponse->getData()[0]);
        $this->assertSame($response, $apiResponse->getSourceResponse());
    }
}
