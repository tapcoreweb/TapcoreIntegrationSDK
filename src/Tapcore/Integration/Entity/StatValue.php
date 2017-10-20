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
