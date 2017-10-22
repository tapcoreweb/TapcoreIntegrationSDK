<?php

namespace Tapcore\Integration\Entity;

use PHPUnit\Framework\TestCase;

class OverviewValueTest extends TestCase
{
    public function testCreatingFromArray()
    {
        $source = [
            'current' => 123.43,
            'previous' => 545.12,
            'points' => [11, '12', 54.1],
        ];

        $value = OverviewValue::createFromResponseData($source);

        $this->assertSame($source['current'], $value->getCurrent());
        $this->assertSame($source['previous'], $value->getPrevious());

        $points = $value->getInterpolatedPoints();
        $this->assertCount(3, $points);
        $this->assertSame(11.0, $points[0]);
        $this->assertSame(12.0, $points[1]);
        $this->assertSame(54.1, $points[2]);
    }
}
