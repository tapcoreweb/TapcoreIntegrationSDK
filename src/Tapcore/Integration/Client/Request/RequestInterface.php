<?php

namespace Tapcore\Integration\Client\Request;

interface RequestInterface
{
    /**
     * @return array
     */
    public function getQueryParams();

    /**
     * @return array
     */
    public function getBodyParams();
}
