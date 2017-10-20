<?php

namespace Tapcore\Integration\Client\Request;

class ApplicationsRequest implements RequestInterface
{
    const ORDER_BY_CREATED_AT = 'created_at';
    const ORDER_BY_PACKAGE_NAME = 'package';
    const ORDER_BY_TITLE = 'title';

    /** @var array */
    protected $params = [];

    /** @var string[] */
    protected $fields = [];

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
     * @param string $package
     *
     * @return $this
     */
    public function setPackage($package)
    {
        $this->params['package'] = (string) $package;

        return $this;
    }

    /**
     * @param int $platform
     *
     * @return $this
     */
    public function setPlatform($platform)
    {
        $this->params['platform'] = (int) $platform;

        return $this;
    }

    /**
     * Application’s platform.
     * If not passed then return applications for both platforms,
     * 1 – only Android applications,
     * 2 - only iOS applications
     *
     * @param int|null $active
     *
     * @return $this
     */
    public function setActive($active)
    {
        if (null === $active) {
            $this->params['active'] = null;
            unset($this->params['active']);
        } else {
            $this->params['active'] = $active ? 1 : 0;
        }

        return $this;
    }

    /**
     * Application’s platform.
     * If not passed then return applications for both platforms,
     * 1 – only Android applications,
     * 2 - only iOS applications
     *
     * @param string|null $orderBy
     *
     * @return $this
     */
    public function setOrderBy($orderBy = self::ORDER_BY_CREATED_AT)
    {
        if (null === $orderBy) {
            $this->params['order'] = null;
            unset($this->params['order']);
        } else {
            $this->params['order'] = (string) $orderBy;
        }

        return $this;
    }

    /**
     * @param string $field
     *
     * @return $this
     */
    public function addFieldToFetching($field)
    {
        $this->fields[] = (string) $field;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getQueryParams()
    {
        return array_merge($this->params, [
            'fields' => implode(',', $this->fields),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getBodyParams()
    {
        return [];
    }
}
