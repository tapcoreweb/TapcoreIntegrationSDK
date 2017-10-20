<?php

namespace Tapcore\Integration\Entity;

class TransactionList
{
    /** @var Transaction[] */
    protected $transactions;

    /** @var int */
    protected $page;

    /** @var int */
    protected $pageSize;

    /** @var int */
    protected $totalCount;

    /**
     * @param TransactionList[] $transactions
     * @param int $page
     * @param int $pageSize
     * @param int $totalCount
     */
    public function __construct(array $transactions, $page, $pageSize, $totalCount)
    {
        $this->transactions = $transactions;
        $this->page = $page;
        $this->pageSize = $pageSize;
        $this->totalCount = $totalCount;
    }

    /**
     * @return Transaction[]
     */
    public function getTransactions()
    {
        return $this->transactions;
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
