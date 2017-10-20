<?php

namespace Tapcore\Integration\Entity;

use Tapcore\Helpers\ArrayHelper;

class Publisher implements EntityInterface
{
    /** Persistence API Token */
    const FIELDS_API_TOKEN = 'Publisher.apiToken';

    /** Detailed current balance */
    const FIELDS_MONEY = 'Publisher.money';

    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $email;

    /** @var string */
    protected $type;

    /** @var \DateTime */
    protected $createdAt;

    /** @var \DateTime */
    protected $updatedAt;

    /** @var string|null */
    protected $apiToken;

    /** @var MoneySummary|null */
    protected $money;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * @return null|string
     */
    public function getApiToken()
    {
        return $this->apiToken;
    }

    /**
     * @return MoneySummary|null
     */
    public function getMoney()
    {
        return $this->money;
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
        $item->name = ArrayHelper::valueString($data, 'name');
        $item->email = ArrayHelper::valueString($data, 'email');
        $item->type = ArrayHelper::valueString($data, 'type');
        $item->apiToken = ArrayHelper::valueString($data, 'api_token');
        $item->createdAt = ArrayHelper::valueDateTime($data, 'created_at');
        $item->updatedAt = ArrayHelper::valueDateTime($data, 'updated_at');

        $money = (array) ArrayHelper::value($data, 'money', []);
        if (!empty($money)) {
            $item->money = MoneySummary::createFromResponseData($money);
        }

        return $item;
    }
}
