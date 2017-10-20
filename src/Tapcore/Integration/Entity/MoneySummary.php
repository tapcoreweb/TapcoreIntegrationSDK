<?php

namespace Tapcore\Integration\Entity;

use Tapcore\Helpers\ArrayHelper;

class MoneySummary implements EntityInterface
{
    /** @var float */
    protected $balance;

    /** @var float */
    protected $totalPaid;

    /** @var float */
    protected $totalEarn;

    /** @var float */
    protected $onHold;

    /**
     * @return float
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @return float
     */
    public function getTotalPaid()
    {
        return $this->totalPaid;
    }

    /**
     * @return float
     */
    public function getTotalEarn()
    {
        return $this->totalEarn;
    }

    /**
     * @return float
     */
    public function getOnHold()
    {
        return $this->onHold;
    }

    /**
     * @inheritdoc
     *
     * @return $this
     */
    public static function createFromResponseData(array $data)
    {
        $item = new self();

        $item->balance = ArrayHelper::valueFloat($data, 'balance');
        $item->totalPaid = ArrayHelper::valueFloat($data, 'total_paid');
        $item->totalEarn = ArrayHelper::valueFloat($data, 'total_earn');
        $item->onHold = ArrayHelper::valueFloat($data, 'on_hold');

        return $item;
    }
}
