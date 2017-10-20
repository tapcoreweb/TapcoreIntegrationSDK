<?php

namespace Tapcore\Integration\Entity;

use Tapcore\Helpers\ArrayHelper;

class OverviewValue implements EntityInterface
{
    /** @var int|float */
    protected $current;

    /** @var int|float */
    protected $previous;

    /** @var float[] */
    protected $interpolatedPoints = [];

    /**
     * @return float|int
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @return float|int
     */
    public function getPrevious()
    {
        return $this->previous;
    }

    /**
     * @return float[]
     */
    public function getInterpolatedPoints()
    {
        return $this->interpolatedPoints;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public static function createFromResponseData(array $data)
    {
        $item = new self();

        $item->current = ArrayHelper::valueFloat($data, 'current', 0);
        $item->previous = ArrayHelper::valueFloat($data, 'previous', 0);
        $item->interpolatedPoints = (array) ArrayHelper::value($data, 'points', []);
        $item->interpolatedPoints = ArrayHelper::castToFloatsArray($item->interpolatedPoints);

        return $item;
    }
}
