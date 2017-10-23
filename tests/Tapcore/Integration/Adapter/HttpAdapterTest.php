<?php

namespace Tapcore\Integration\Adapter;

use Buzz\Browser;
use Buzz\Message\Factory\FactoryInterface;
use PHPUnit\Framework\TestCase;
use Tapcore\Integration\Client\Api\ApiResponse;
use Tapcore\Integration\Client\Api\ExtraHeaders;
use Tapcore\Integration\Client\Buzz\Request;
use Tapcore\Integration\Client\Buzz\Response;
use Tapcore\Integration\Exception\AccessDeniedException;
use Tapcore\Integration\Exception\Exception;
use Tapcore\Integration\Exception\InvalidArgumentException;
use Tapcore\Integration\Exception\NotFoundException;

class HttpAdapterTest extends TestCase
{
    /** @var Browser|\PHPUnit_Framework_MockObject_MockObject */
    protected $browser;

    /** @var FactoryInterface|\PHPUnit_Framework_MockObject_MockObject */
    protected $messageFactory;

    /** @var Request|\PHPUnit_Framework_MockObject_MockObject */
    protected $request;

    /** @var Response|\PHPUnit_Framework_MockObject_MockObject */
    protected $response;

    /** @var ExtraHeaders|\PHPUnit_Framework_MockObject_MockObject */
    protected $extraHeaders;

    /** @var HttpAdapter */
    protected $adapter;

    protected function setUp()
    {
        $this->browser = $this->getMock(Browser::class);

        $this->messageFactory = $this->getMock(FactoryInterface::class);

        $this->request = $this->getMock(Request::class);

        $this->response = $this->getMock(Response::class);

        $this->extraHeaders = $this->getMock(ExtraHeaders::class);
    }

    public function testCorrectRequestRaw()
    {
        $this->browser
            ->expects($this->once())
            ->method('send')
            ->willReturn($this->response);

        $response = $this->makeRequest();

        $this->assertSame($this->response, $response);
    }

    public function testRequestWithException()
    {
        $this->browser
            ->expects($this->once())
            ->method('send')
            ->willThrowException(new \Exception());

        $this->setExpectedException(Exception::class);

        $response = $this->makeRequest();

        $this->assertSame($this->response, $response);
    }

    public function testRequestParsing()
    {
        $this->browser
            ->expects($this->once())
            ->method('send')
            ->willReturn($this->response);

        $this->response
            ->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);

        $this->response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn([]);

        $this->response
            ->expects($this->once())
            ->method('getExtraHeaders')
            ->willReturn($this->extraHeaders);

        /** @var ApiResponse $response */
        $response = $this->makeRequest(false);

        $this->assertInstanceOf(ApiResponse::class, $response);
        $this->assertSame($this->extraHeaders, $response->getExtraHeaders());
        $this->assertSame($this->response, $response->getSourceResponse());
        $this->assertEquals([], $response->getData());
    }

    public function statsCodesProvider()
    {
        return [
            'bad request' => [ 400, InvalidArgumentException::class ],
            'auth required' => [ 401, AccessDeniedException::class ],
            'access denied' => [ 403, AccessDeniedException::class ],
            'not found' => [ 404, NotFoundException::class ],
            'server error' => [ 500, Exception::class ],
        ];
    }

    /**
     * @dataProvider statsCodesProvider
     *
     * @param int $code
     * @param string $exception
     */
    public function testAccessDeniedResponse($code, $exception)
    {
        $this->browser
            ->expects($this->once())
            ->method('send')
            ->willReturn($this->response);

        $this->response
            ->expects($this->once())
            ->method('getStatusCode')
            ->willReturn($code);

        $this->response
            ->expects($this->once())
            ->method('getContent')
            ->willReturn(['message' => 'error']);

        $this->setExpectedException($exception, 'error');

        $this->makeRequest(false);
    }

    protected function makeRequest($isRawRequest = true)
    {
        $adapter = new HttpAdapter(
            'www.unit-tests.com',
            '/prefix',
            'auth token',
            $this->browser,
            10
        );

        $this->browser
            ->expects($this->once())
            ->method('getMessageFactory')
            ->willReturn($this->messageFactory);

        $this->messageFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('POST', '/prefix/api/1.0/test?foo=bar', 'http://www.unit-tests.com')
            ->willReturn($this->request);

        $this->request
            ->expects($this->once())
            ->method('setFields')
            ->with(['test' => 123]);

        $this->request
            ->expects($this->once())
            ->method('setHeaders')
            ->with(['Authorization' => 'Bearer auth token']);

        $method = $isRawRequest ? 'requestRaw' : 'request';

        return $adapter->{$method}(
            '/test',
            ['foo' => 'bar', 'bar' => null],
            ['test' => 123],
            Request::METHOD_POST
        );
    }
}
