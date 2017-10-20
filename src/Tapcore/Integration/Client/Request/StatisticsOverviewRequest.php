<?php

namespace Tapcore\Integration\Client\Request;

use Tapcore\Helpers\ArrayHelper;

class StatisticsOverviewRequest implements RequestInterface
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
