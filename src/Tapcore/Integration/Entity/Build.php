<?php

namespace Tapcore\Integration\Entity;

use Tapcore\Helpers\ArrayHelper;

class Build implements EntityInterface
{
    const STATUS_NEW         = 'NEW';
    const STATUS_IN_QUEUE    = 'IN_QUEUE';
    const STATUS_IN_PROGRESS = 'IN_PROGRESS';
    const STATUS_SUCCESS     = 'SUCCESS';
    const STATUS_FAILURE     = 'FAILURE';
    const STATUS_ABORTED     = 'ABORTED';

    const ERROR_ALREADY_INTEGRATED = 1;
    const ERROR_UNKNOWN_PROBLEM    = 2;
    const ERROR_INVALID_APK        = 3;
    const ERROR_INVALID_KEYSTORE   = 4;
    const ERROR_TAPCORE_KEYWORD    = 5;

    const SDK_TYPE_NATIVE   = 'native';
    const SDK_TYPE_UNITY_3D = 'unity3d';

    /** @var int */
    protected $id;

    /** @var string */
    protected $status;

    /** @var int */
    protected $errorCode;

    /** @var \DateTime */
    protected $createdAt;

    /** @var \DateTime */
    protected $updatedAt;

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
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return bool
     */
    public function isFinished()
    {
        return in_array($this->getStatus(), [
            self::STATUS_SUCCESS,
            self::STATUS_ABORTED,
            self::STATUS_FAILURE
        ]);
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->getStatus() === self::STATUS_SUCCESS;
    }

    /**
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
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
     * @param array $data
     *
     * @return $this
     */
    public static function createFromResponseData(array $data)
    {
        $item = new self();

        $item->id = ArrayHelper::valueInt($data, 'id');
        $item->status = ArrayHelper::valueString($data, 'status');
        $item->errorCode = ArrayHelper::valueInt($data, 'error_code');
        $item->createdAt = ArrayHelper::valueDateTime($data, 'created_at');
        $item->updatedAt = ArrayHelper::valueDateTime($data, 'updated_at');

        return $item;
    }
}
