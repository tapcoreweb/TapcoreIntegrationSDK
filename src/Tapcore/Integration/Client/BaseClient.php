<?php

namespace Tapcore\Integration\Client;

use Tapcore\Integration\Adapter\AdapterInterface;

abstract class BaseClient
{
    /** @var AdapterInterface */
    protected $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }
}
