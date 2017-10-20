<?php

namespace Tapcore\Integration\Entity;

use Tapcore\Helpers\ArrayHelper;

class MetricSummary implements EntityInterface
{
    /** @var int|float */
    protected $today = 0;

    /** @var int|float */
    protected $yesterday = 0;

    /** @var int|float */
    protected $month = 0;

    /**
     * @return float|int
     */
    public function getToday()
    {
        return $this->today;
    }

    /**
     * @return float|int
     */
    public function getYesterday()
    {
        return $this->yesterday;
    }

    /**
     * @return float|int
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public static function createFromResponseData(array $data)
    {
        $item = new self();

        $item->today = ArrayHelper::valueFloat($data, 'today', 0);
        $item->yesterday = ArrayHelper::valueFloat($data, 'yesterday', 0);
        $item->month = ArrayHelper::valueFloat($data, 'month', 0);

        return $item;
    }
}
