<?php

namespace Tapcore\Integration\Entity;

use Tapcore\Helpers\ArrayHelper;

class Transaction implements EntityInterface
{
    /** @var int */
    protected $id;

    /** @var float */
    protected $amount;

    /** @var \DateTime */
    protected $dateStart;

    /** @var \DateTime */
    protected $dateEnd;

    /** @var \DateTime */
    protected $createdAt;

    /** @var \DateTime */
    protected $updatedAt;

    /** @var \DateTime */
    protected $appliedAt;

    /** @var \DateTime */
    protected $cancelledAt;

    /** @var bool */
    protected $paid;

    /** @var Publisher|null */
    protected $publisher;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getAppliedAt()
    {
        return $this->appliedAt;
    }

    /**
     * @return \DateTime
     */
    public function getCancelledAt()
    {
        return $this->cancelledAt;
    }

    /**
     * @return bool
     */
    public function isPaid()
    {
        return $this->paid;
    }

    /**
     * @return null|Publisher
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public static function createFromResponseData(array $data)
    {
        $item = new self();

        $item->id = ArrayHelper::valueInt($data, 'id');
        $item->amount = ArrayHelper::valueFloat($data, 'amount');
        $item->dateStart = ArrayHelper::valueDateTime($data, 'date_start');
        $item->dateEnd = ArrayHelper::valueDateTime($data, 'date_end');
        $item->createdAt = ArrayHelper::valueDateTime($data, 'created_at');
        $item->updatedAt = ArrayHelper::valueDateTime($data, 'updated_at');
        $item->appliedAt = ArrayHelper::valueDateTime($data, 'applied_at');
        $item->cancelledAt = ArrayHelper::valueDateTime($data, 'cancelled_at');
        $item->paid = ArrayHelper::valueBool($data, 'paid');

        $publisher = (array) ArrayHelper::value($data, 'publisher', []);
        if (!empty($publisher)) {
            $item->publisher = Publisher::createFromResponseData($publisher);
        }

        return $item;
    }
}
