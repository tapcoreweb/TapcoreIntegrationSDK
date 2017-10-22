<?php

namespace Tapcore\Integration\Entity;

use PHPUnit\Framework\TestCase;

class MoneySummaryTest extends TestCase
{
    public function testCreatingFromArray()
    {
        $source = [
            'balance' => 123.43,
            'total_paid' => 545.23,
            'total_earn' => 3232.12,
            'on_hold' => 655.65,
        ];

        $summary = MoneySummary::createFromResponseData($source);

        $this->assertSame($source['balance'], $summary->getBalance());
        $this->assertSame($source['total_paid'], $summary->getTotalPaid());
        $this->assertSame($source['total_earn'], $summary->getTotalEarn());
        $this->assertSame($source['on_hold'], $summary->getOnHold());
    }
}
