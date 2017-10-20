<?php

namespace Tapcore\Integration\Client\Buzz;

use Buzz\Message\Response as BuzzResponse;
use Tapcore\Integration\Client\Api\ExtraHeaders;
use Tapcore\Integration\Exception\Exception;

class Response extends BuzzResponse
{
    /** @var null|mixed */
    protected $parsedContent = null;

    /**
     * @return ExtraHeaders
     */
    public function getExtraHeaders()
    {
        $extra = [];
        foreach (ExtraHeaders::$extraHeaders as $headerName) {
            $header = $this->getHeader($headerName, false);
            if (is_array($header) && !empty($header)) {
                $extra[$headerName] = $header[0];
            }
        }

        return new ExtraHeaders($extra);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function getContent()
    {
        if (null === $this->parsedContent) {
            $this->parsedContent = @\json_decode($this->getRawContent(), true);
            if (\json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Invalid JSON: " . \json_last_error_msg());
            }
        }

        return $this->parsedContent;
    }

    /**
     * @return string
     */
    public function getRawContent()
    {
        return parent::getContent();
    }
}
