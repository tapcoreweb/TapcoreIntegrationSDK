<?php

namespace Tapcore\Integration\Client;

use Tapcore\Integration\Client\Request\MetricSummaryRequest;
use Tapcore\Integration\Client\Request\StatisticsOverviewRequest;
use Tapcore\Integration\Client\Request\StatisticsRequest;
use Tapcore\Integration\Entity\MetricSummary;
use Tapcore\Integration\Entity\OverviewReport;
use Tapcore\Integration\Entity\StatValue;

class ReportingClientTest extends BaseClientTest
{
    public function testGetStatistics()
    {
        $client = new ReportingClient($this->adapter);

        $request = $this->getMockBuilder(StatisticsRequest::class)->disableOriginalConstructor()->getMock();

        $request->expects($this->once())->method('getQueryParams')->willReturn([123]);
        $request->expects($this->once())->method('getBodyParams')->willReturn([234]);

        $this->adapter
            ->expects($this->once())
            ->method('request')
            ->with('/statistics', [123], [234], 'GET')
            ->willReturn($this->apiResponse);

        $this->apiResponse
            ->expects($this->once())
            ->method('getData')
            ->willReturn([[]]);

        $stat = $client->getStatistics($request);

        $this->assertCount(1, $stat);
        $this->assertInstanceOf(StatValue::class, $stat[0]);
    }

    public function testGetStatisticsOverview()
    {
        $client = new ReportingClient($this->adapter);

        $request = $this->getMock(StatisticsOverviewRequest::class);

        $request->expects($this->once())->method('getQueryParams')->willReturn([123]);
        $request->expects($this->once())->method('getBodyParams')->willReturn([234]);

        $this->adapter
            ->expects($this->once())
            ->method('request')
            ->with('/statistics/total', [123], [234], 'GET')
            ->willReturn($this->apiResponse);

        $this->apiResponse
            ->expects($this->once())
            ->method('getData')
            ->willReturn([]);

        $overview = $client->getStatisticsOverview($request);

        $this->assertInstanceOf(OverviewReport::class, $overview);
    }

    public function testGetStatisticsMetricSummary()
    {
        $client = new ReportingClient($this->adapter);

        $request = $this->getMockBuilder(MetricSummaryRequest::class)->disableOriginalConstructor()->getMock();

        $request->expects($this->once())->method('getQueryParams')->willReturn([123]);
        $request->expects($this->once())->method('getBodyParams')->willReturn([234]);

        $this->adapter
            ->expects($this->once())
            ->method('request')
            ->with('/statistics/metrics', [123], [234], 'GET')
            ->willReturn($this->apiResponse);

        $this->apiResponse
            ->expects($this->once())
            ->method('getData')
            ->willReturn([]);

        $overview = $client->getStatisticsMetricSummary($request);

        $this->assertInstanceOf(MetricSummary::class, $overview);
    }
}
