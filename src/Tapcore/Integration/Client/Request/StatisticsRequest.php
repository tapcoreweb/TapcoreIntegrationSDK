<?php

namespace Tapcore\Integration\Client\Request;

use Tapcore\Helpers\ArrayHelper;

class StatisticsRequest implements RequestInterface
{
    const TYPE_IMPRESSIONS = 'impressions';
    const TYPE_REVENUE = 'revenue';
    const TYPE_CTR = 'ctr';
    const TYPE_ECPM = 'ecpm';
    const TYPE_ECPC = 'ecpc';

    protected $params = [];

    /**
     * @param string $type
     */
    public function __construct($type)
    {
        $this->setType($type);
    }

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
     * @param string $type
     *
     * @return $this
     */
    public function setType($type = self::TYPE_REVENUE)
    {
        $this->params['type'] = (string) $type;

        return $this;
    }

    /**
     * @param int[] $apps
     *
     * @return $this
     */
    public function setApplications(array $apps)
    {
        $this->params['apps'] = ArrayHelper::castToIntegersArray($apps);

        return $this;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function addApplication($id)
    {
        $this->params['apps'][] = (int) $id;

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
