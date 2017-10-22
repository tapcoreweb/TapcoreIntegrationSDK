<?php

namespace Tapcore\Integration\Entity;

use PHPUnit\Framework\TestCase;

class OverviewReportTest extends TestCase
{
    public function testCreatingFromArray()
    {
        $report = OverviewReport::createFromResponseData([]);

        $this->assertInstanceOf(OverviewValue::class, $report->getImpressions());
        $this->assertInstanceOf(OverviewValue::class, $report->getClicks());
        $this->assertInstanceOf(OverviewValue::class, $report->getRevenue());
        $this->assertInstanceOf(OverviewValue::class, $report->getCtr());
        $this->assertInstanceOf(OverviewValue::class, $report->getEcpc());
        $this->assertInstanceOf(OverviewValue::class, $report->getEcpm());
    }
}
