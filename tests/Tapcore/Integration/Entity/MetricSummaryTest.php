<?php

namespace Tapcore\Integration\Entity;

use PHPUnit\Framework\TestCase;

class MetricSummaryTest extends TestCase
{
    public function testCreatingFromArray()
    {
        $source = [
            'today' => 123.43,
            'yesterday' => 545.23,
            'month' => 3232.12
        ];

        $summary = MetricSummary::createFromResponseData($source);

        $this->assertSame($source['today'], $summary->getToday());
        $this->assertSame($source['yesterday'], $summary->getYesterday());
        $this->assertSame($source['month'], $summary->getMonth());
    }
}
