<?php

namespace Tapcore\Integration\Client\Buzz;

use Buzz\Message\RequestInterface;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    /** @var Factory */
    protected $factory;

    protected function setUp()
    {
        $this->factory = new Factory();
    }

    public function testRequestCreation()
    {
        $request = $this->factory->createRequest(RequestInterface::METHOD_HEAD, '/test', 'google.com');
        $this->assertInstanceOf(Request::class, $request);
        $this->assertSame(RequestInterface::METHOD_HEAD, $request->getMethod());
        $this->assertSame('/test', $request->getResource());
        $this->assertSame('google.com', $request->getHost());
    }

    public function testFormRequestCreation()
    {
        $request = $this->factory->createFormRequest(RequestInterface::METHOD_HEAD, '/test', 'google.com');
        $this->assertInstanceOf(Request::class, $request);
        $this->assertSame(RequestInterface::METHOD_HEAD, $request->getMethod());
        $this->assertSame('/test', $request->getResource());
        $this->assertSame('google.com', $request->getHost());
    }

    public function testResponseCreation()
    {
        $response = $this->factory->createResponse();
        $this->assertInstanceOf(Response::class, $response);
    }
}
