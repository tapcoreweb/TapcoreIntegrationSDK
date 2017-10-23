<?php

namespace Tapcore\Integration\Client;

use PHPUnit\Framework\TestCase;
use Tapcore\Integration\Adapter\AdapterInterface;
use Tapcore\Integration\Client\Api\ApiResponse;
use Tapcore\Integration\Client\Api\ExtraHeaders;

abstract class BaseClientTest extends TestCase
{
    /** @var AdapterInterface|\PHPUnit_Framework_MockObject_MockObject */
    protected $adapter;

    /** @var ApiResponse|\PHPUnit_Framework_MockObject_MockObject */
    protected $apiResponse;

    /** @var ExtraHeaders|\PHPUnit_Framework_MockObject_MockObject */
    protected $extraHeaders;

    protected function setUp()
    {
        $this->adapter = $this->getMock(AdapterInterface::class);
        $this->extraHeaders = $this->getMock(ExtraHeaders::class);
        $this->apiResponse = $this->getMockBuilder(ApiResponse::class)->disableOriginalConstructor()->getMock();
        $this->apiResponse->expects($this->any())->method('getExtraHeaders')->willReturn($this->extraHeaders);
    }
}
