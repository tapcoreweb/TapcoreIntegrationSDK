<?php

namespace Tapcore\Integration\Client\Request;

use PHPUnit\Framework\TestCase;

class TransactionsRequestTest extends TestCase
{
    public function testCorrectRequest()
    {
        $data = [
            'date_start' => '2017-01-02 12:23:56',
            'date_end' => '2017-02-03 05:14:37',
            'page' => 3,
            'page_size' => 10,
        ];

        $request = (new TransactionsRequest())
            ->setDateStart(new \DateTime($data['date_start']))
            ->setDateEnd(new \DateTime($data['date_end']))
            ->setPage($data['page'])
            ->setPageSize($data['page_size']);

        $this->assertArraySubset($data, $request->getQueryParams());

        $this->assertEquals([], $request->getBodyParams());
    }
}
