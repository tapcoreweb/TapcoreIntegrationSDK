<?php

namespace Tapcore\Integration\Entity;

class ApplicationList
{
    /** @var Application[] */
    protected $applications;

    /** @var int */
    protected $page;

    /** @var int */
    protected $pageSize;

    /** @var int */
    protected $totalCount;

    /**
     * @param Application[] $applications
     * @param int $page
     * @param int $pageSize
     * @param int $totalCount
     */
    public function __construct(array $applications, $page, $pageSize, $totalCount)
    {
        $this->applications = $applications;
        $this->page = $page;
        $this->pageSize = $pageSize;
        $this->totalCount = $totalCount;
    }

    /**
     * @return Application[]
     */
    public function getApplications()
    {
        return $this->applications;
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
}
