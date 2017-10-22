<?php

namespace Tapcore\Integration\Entity;

use Tapcore\Helpers\ArrayHelper;

class StatValue implements EntityInterface
{
    /** @var \DateTime */
    protected $currentDatetime;

    /** @var \DateTime */
    protected $previousDatetime;

    /** @var int|float */
    protected $currentValue = 0;

    /** @var int|float */
    protected $previousValue = 0;

    /**
     * @return \DateTime
     */
    public function getCurrentDatetime()
    {
        return $this->currentDatetime;
    }

    /**
     * @return \DateTime
     */
    public function getPreviousDatetime()
    {
        return $this->previousDatetime;
    }

    /**
     * @return float|int
     */
    public function getCurrentValue()
    {
        return $this->currentValue;
    }

    /**
     * @return float|int
     */
    public function getPreviousValue()
    {
        return $this->previousValue;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public static function createFromResponseData(array $data)
    {
        $item = new self();

        $item->currentDatetime = ArrayHelper::valueDateTime($data, 'current_date_time');
        $item->previousDatetime = ArrayHelper::valueDateTime($data, 'previous_date_time');
        $item->currentValue = ArrayHelper::valueFloat($data, 'current_value', 0);
        $item->previousValue = ArrayHelper::valueFloat($data, 'previous_value', 0);

        return $item;
    }
}
