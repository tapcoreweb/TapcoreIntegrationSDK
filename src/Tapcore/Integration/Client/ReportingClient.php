<?php

namespace Tapcore\Integration\Client;

use Tapcore\Integration\Client\Request\MetricSummaryRequest;
use Tapcore\Integration\Client\Request\StatisticsOverviewRequest;
use Tapcore\Integration\Client\Request\StatisticsRequest;
use Tapcore\Integration\Entity\MetricSummary;
use Tapcore\Integration\Entity\OverviewReport;
use Tapcore\Integration\Entity\StatValue;
use Tapcore\Integration\Exception\Exception as SDKException;

class ReportingClient extends BaseClient
{
    /**
     * @param StatisticsRequest $request
     *
     * @return StatValue[]
     * @throws SDKException
     */
    public function getStatistics(StatisticsRequest $request)
    {
        $response = $this->adapter->request(
            '/statistics',
            $request->getQueryParams(),
            $request->getBodyParams()
        );

        $data = (array) $response->getData();

        $result = [];

        foreach ($data as $item) {
            $result[] = StatValue::createFromResponseData((array) $item);
        }

        return $result;
    }

    /**
     * @param StatisticsOverviewRequest $request
     *
     * @return OverviewReport
     * @throws SDKException
     */
    public function getStatisticsOverview(StatisticsOverviewRequest $request)
    {
        $response = $this->adapter->request(
            '/statistics/total',
            $request->getQueryParams(),
            $request->getBodyParams()
        );

        $data = (array) $response->getData();

        return OverviewReport::createFromResponseData((array) $data);
    }

    /**
     * @param MetricSummaryRequest $request
     *
     * @return MetricSummary
     * @throws SDKException
     */
    public function getStatisticsMetricSummary(MetricSummaryRequest $request)
    {
        $response = $this->adapter->request(
            '/statistics/metrics',
            $request->getQueryParams(),
            $request->getBodyParams()
        );

        $data = (array) $response->getData();

        return MetricSummary::createFromResponseData((array) $data);
    }
}
