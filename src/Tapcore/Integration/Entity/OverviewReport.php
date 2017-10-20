<?php

namespace Tapcore\Integration\Entity;

use Tapcore\Helpers\ArrayHelper;

class OverviewReport implements EntityInterface
{
    /** @var OverviewValue */
    protected $impressions;

    /** @var OverviewValue */
    protected $clicks;

    /** @var OverviewValue */
    protected $ctr;

    /** @var OverviewValue */
    protected $revenue;

    /** @var OverviewValue */
    protected $ecpm;

    /** @var OverviewValue */
    protected $ecpc;

    /**
     * @return OverviewValue
     */
    public function getImpressions()
    {
        return $this->impressions;
    }

    /**
     * @return OverviewValue
     */
    public function getClicks()
    {
        return $this->clicks;
    }

    /**
     * @return OverviewValue
     */
    public function getCtr()
    {
        return $this->ctr;
    }

    /**
     * @return OverviewValue
     */
    public function getRevenue()
    {
        return $this->revenue;
    }

    /**
     * @return OverviewValue
     */
    public function getEcpm()
    {
        return $this->ecpm;
    }

    /**
     * @return OverviewValue
     */
    public function getEcpc()
    {
        return $this->ecpc;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public static function createFromResponseData(array $data)
    {
        $item = new self();

        $item->impressions = OverviewValue::createFromResponseData((array) ArrayHelper::value($data, 'impressions', []));
        $item->clicks = OverviewValue::createFromResponseData((array) ArrayHelper::value($data, 'clicks', []));
        $item->revenue = OverviewValue::createFromResponseData((array) ArrayHelper::value($data, 'revenue', []));
        $item->ctr = OverviewValue::createFromResponseData((array) ArrayHelper::value($data, 'ctr', []));
        $item->ecpm = OverviewValue::createFromResponseData((array) ArrayHelper::value($data, 'ecpm', []));
        $item->ecpc = OverviewValue::createFromResponseData((array) ArrayHelper::value($data, 'ecpc', []));

        return $item;
    }
}
