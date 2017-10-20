<?php

namespace Tapcore\Integration\Client\Request;

class TransactionsRequest implements RequestInterface
{
    protected $params = [];

    /**
     * @param \DateTime $datetime
     *
     * @return $this
     */
    public function setDateStart(\DateTime $datetime)
    {
        $this->params['date_start'] = $datetime->format('Y-m-d H:i:s');

        return $this;
    }

    /**
     * @param \DateTime $datetime
     *
     * @return $this
     */
    public function setDateEnd(\DateTime $datetime)
    {
        $this->params['date_end'] = $datetime->format('Y-m-d H:i:s');

        return $this;
    }

    /**
     * @param int $page
     *
     * @return $this
     */
    public function setPage($page)
    {
        $this->params['page'] = (int) $page;

        return $this;
    }

    /**
     * @param int $pageSize
     *
     * @return $this
     */
    public function setPageSize($pageSize)
    {
        $this->params['page_size'] = (int) $pageSize;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getQueryParams()
    {
        return $this->params;
    }

    /**
     * @inheritdoc
     */
    public function getBodyParams()
    {
        return [];
    }
}
