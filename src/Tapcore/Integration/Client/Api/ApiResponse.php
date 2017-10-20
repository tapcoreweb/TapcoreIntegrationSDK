<?php

namespace Tapcore\Integration\Client\Api;

use Tapcore\Integration\Client\Buzz\Response;

class ApiResponse
{
    /** @var ExtraHeaders */
    protected $extraHeaders = null;

    /** @var mixed */
    protected $data;

    /** @var null|Response */
    protected $sourceResponse;

    /**
     * ApiData constructor.
     *
     * @param mixed $data
     * @param ExtraHeaders|null $extraHeaders
     * @param Response|null $sourceResponse
     */
    public function __construct($data, ExtraHeaders $extraHeaders = null, Response $sourceResponse = null)
    {
        $this->data = $data;
        $this->extraHeaders = $extraHeaders;

        $this->sourceResponse = $sourceResponse;
    }

    /**
     * @return ExtraHeaders|null
     */
    public function getExtraHeaders()
    {
        return $this->extraHeaders;
    }

    /**
     * @return null|Response
     */
    public function getSourceResponse()
    {
        return $this->sourceResponse;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}
