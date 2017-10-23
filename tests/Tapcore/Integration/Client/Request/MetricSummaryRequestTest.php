<?php

namespace Tapcore\Integration\Client\Request;

use PHPUnit\Framework\TestCase;

class MetricSummaryRequestTest extends TestCase
{
    public function testCorrectRequest()
    {
        $request = (new MetricSummaryRequest(MetricSummaryRequest::TYPE_IMPRESSIONS))
            ->setApplications([1])
            ->addApplication(2);

        $this->assertArraySubset([
            'type' => MetricSummaryRequest::TYPE_IMPRESSIONS,
            'apps' => [1, 2],
        ], $request->getQueryParams());

        $this->assertEquals([], $request->getBodyParams());
    }
}
