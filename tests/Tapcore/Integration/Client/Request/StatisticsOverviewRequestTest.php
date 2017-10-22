<?php

namespace Tapcore\Integration\Client\Request;

use PHPUnit\Framework\TestCase;

class StatisticsOverviewRequestTest extends TestCase
{
    public function testCorrectRequest()
    {
        $data = [
            'date_start' => '2017-01-02 12:23:56',
            'date_end' => '2017-02-03 05:14:37',
        ];

        $request = (new StatisticsOverviewRequest())
            ->setDateStart(new \DateTime($data['date_start']))
            ->setDateEnd(new \DateTime($data['date_end']))
            ->setApplications([1])
            ->addApplication(2);

        $this->assertArraySubset([
            'date_start' => $data['date_start'],
            'date_end' => $data['date_end'],
            'apps' => [1, 2],
        ], $request->getQueryParams());

        $this->assertEquals([], $request->getBodyParams());
    }
}
