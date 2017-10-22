<?php

namespace Tapcore\Integration\Client\Buzz;

use Buzz\Message\RequestInterface;
use PHPUnit\Framework\TestCase;

class FileGetContentsTest extends TestCase
{
    public function testTimeout()
    {
        $object = new FileGetContents(120);
        $this->assertSame(120, $object->getTimeout());
    }

    public function testContextCreation()
    {
        /** @var RequestInterface|\PHPUnit_Framework_MockObject_MockObject $request */
        $request = $this->getMock(RequestInterface::class);

        $request->expects($this->once())->method('getContent')->willReturn('test content');
        $request->expects($this->once())->method('getHeaders')->willReturn([]);
        $request->expects($this->once())->method('getMethod')->willReturn('POST');
        $request->expects($this->once())->method('getProtocolVersion')->willReturn(1.1);

        $object = new FileGetContents(15);
        $object->setIgnoreErrors(false);
        $object->setMaxRedirects(10);
        $object->setVerifyHost(5);
        $object->setVerifyPeer(false);
        $object->setProxy('127.0.0.1:3128');
        $context = $object->getStreamContextArray($request);

        $expected = [
            'http' => [
                'method' => 'POST',
                'header' => "Accept: application/json\r\nContent-Length: 12\r\nConnection: close",
                'content' => 'test content',
                'protocol_version' => 1.1,
                'ignore_errors' => false,
                'follow_location' => true,
                'max_redirects' => 11,
                'timeout' => 15,
                'proxy' => '127.0.0.1:3128',
                'request_fulluri' => true,
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_host' => 5,
            ],
        ];
        $this->assertArrayHasKey('http', $context);
        $this->assertArraySubset($expected['http'], $context['http']);
        $this->assertArrayHasKey('ssl', $context);
        $this->assertArraySubset($expected['ssl'], $context['ssl']);
    }
}
