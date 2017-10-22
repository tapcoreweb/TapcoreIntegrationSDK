<?php

namespace Tapcore\Integration\Client\Buzz;

use PHPUnit\Framework\TestCase;
use Tapcore\Integration\Client\Api\ExtraHeaders;
use Tapcore\Integration\Exception\Exception;

class ResponseTest extends TestCase
{
    /**
     * @throws \Tapcore\Integration\Exception\Exception
     */
    public function testGetContent()
    {
        $response = new Response();
        $response->setContent('{"test": true}');

        $content = $response->getContent();
        $this->assertArrayHasKey('test', $content);
        $this->assertTrue($content['test']);
    }

    /**
     * @throws Exception
     */
    public function testIncorrectJson()
    {
        $response = new Response();
        $response->setContent('{invalid json}');

        $this->setExpectedException(Exception::class);

        $response->getContent();
    }

    public function testGettingRawContent()
    {
        $content = '{"test": true}';

        $response = new Response();
        $response->setContent($content);

        $this->assertSame($content, $response->getRawContent());
    }

    public function testGetHeaders()
    {
        $source = [
            'X-Page' => 5,
            'X-Page-Size' => 10,
            'X-Total-Count' => 50,
            'X-Api-Token' => 'test api key',
        ];

        $response = new Response();
        $response->setHeaders($source);
        $headers = $response->getExtraHeaders();
        $this->assertInstanceOf(ExtraHeaders::class, $headers);
        $this->assertSame($source['X-Page'], $headers->getPage());
        $this->assertSame($source['X-Page-Size'], $headers->getPageSize());
        $this->assertSame($source['X-Total-Count'], $headers->getTotalCount());
        $this->assertSame($source['X-Api-Token'], $headers->getApiToken());
    }
}
