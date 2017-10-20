<?php

namespace Tapcore\Integration\Client\Request;

use Tapcore\Helpers\ArrayHelper;

class MetricSummaryRequest implements RequestInterface
{
    const TYPE_IMPRESSIONS = 'impressions';
    const TYPE_REVENUE = 'revenue';
    const TYPE_CTR = 'ctr';
    const TYPE_ECPM = 'ecpm';
    const TYPE_ECPC = 'ecpc';
    const TYPE_LTV = 'ltv';
    const TYPE_CHURN = 'churn';

    protected $params = [];

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type = self::TYPE_REVENUE)
    {
        $this->params['type'] = (string) $type;

        return $this;
    }

    /**
     * @param int[] $apps
     *
     * @return $this
     */
    public function setApplications(array $apps)
    {
        $this->params['apps'] = ArrayHelper::castToIntegersArray($apps);

        return $this;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function addApplication($id)
    {
        $this->params['apps'][] = (int) $id;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getQueryParams()
    {
        return $this->params;
    }

    /**
     * @inheritdoc
     */
    public function getBodyParams()
    {
        return [];
    }
}
