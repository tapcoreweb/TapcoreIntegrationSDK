<?php

namespace Tapcore\Integration\Entity;

interface EntityInterface
{
    /**
     * @param array $data
     *
     * @return EntityInterface
     */
    public static function createFromResponseData(array $data);
}
