<?php

namespace Tapcore\Integration\Client\Api;

use PHPUnit\Framework\TestCase;

class ExtraHeadersTest extends TestCase
{
    public function testCreation()
    {
        $source = [
            'X-Page' => 5,
            'X-Page-Size' => 12,
            'X-Total-Count' => 832,
            'X-Api-Token' => 'test token string'
        ];
        $headers = new ExtraHeaders($source);

        $this->assertSame($source['X-Page'], $headers->getPage());
        $this->assertSame($source['X-Page-Size'], $headers->getPageSize());
        $this->assertSame($source['X-Total-Count'], $headers->getTotalCount());
        $this->assertSame($source['X-Api-Token'], $headers->getApiToken());

        $this->assertCount(4, $headers->toArray());
        $this->assertArraySubset($source, $headers->toArray());
    }
}
