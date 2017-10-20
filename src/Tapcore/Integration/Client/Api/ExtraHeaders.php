<?php

namespace Tapcore\Integration\Client\Api;

use Tapcore\Integration\Exception\Exception;

class ExtraHeaders
{
    const HEADER_PAGE_NUM    = 'X-Page';
    const HEADER_PAGE_SIZE   = 'X-Page-Size';
    const HEADER_TOTAL_COUNT = 'X-Total-Count';
    const HEADER_API_TOKEN   = 'X-Api-Token';

    /** @var array */
    public static $extraHeaders = [
        self::HEADER_TOTAL_COUNT,
        self::HEADER_PAGE_NUM,
        self::HEADER_PAGE_SIZE,
        self::HEADER_API_TOKEN,
    ];

    /** @var int */
    protected $page = 0;

    /** @var int */
    protected $pageSize = 0;

    /** @var int */
    protected $totalCount = 0;

    /** @var string|null */
    protected $apiToken;

    /** @var array */
    protected static $headersToExtrasMap = [
        self::HEADER_PAGE_NUM => 'page',
        self::HEADER_PAGE_SIZE => 'pageSize',
        self::HEADER_TOTAL_COUNT => 'totalCount',
        self::HEADER_API_TOKEN => 'apiToken'
    ];

    /**
     * @param array $extras
     * @throws Exception
     */
    public function __construct(array $extras = [])
    {
        foreach ($extras as $extraName => $extraValue) {
            if (!isset(self::$headersToExtrasMap[$extraName])) {
                throw new Exception("Unknown extra '{$extraName}'.");
            }

            $setter = 'set' . ucfirst(self::$headersToExtrasMap[$extraName]);
            $this->$setter($extraValue);
        }
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * @return string|null
     */
    public function getApiToken()
    {
        return $this->apiToken;
    }

    /**
     * @param int $page
     * @return $this
     */
    public function setPage($page)
    {
        $this->page = (int) $page;

        return $this;
    }

    /**
     * @param int $pageSize
     * @return $this
     */
    public function setPageSize($pageSize)
    {
        $this->pageSize = (int) $pageSize;

        return $this;
    }

    /**
     * @param int $totalCount
     * @return $this
     */
    public function setTotalCount($totalCount)
    {
        $this->totalCount = (int) $totalCount;

        return $this;
    }

    /**
     * @param null|string $apiToken
     *
     * @return ExtraHeaders
     */
    public function setApiToken($apiToken)
    {
        $this->apiToken = null !== $apiToken ? (string) $apiToken : null;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $headers = [];
        foreach (self::$headersToExtrasMap as $header => $attribute) {
            $headers[$header] = $this->{$attribute};
        }

        return $headers;
    }
}
