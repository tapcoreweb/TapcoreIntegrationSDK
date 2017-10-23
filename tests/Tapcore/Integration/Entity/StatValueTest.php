<?php

namespace Tapcore\Integration\Entity;

use PHPUnit\Framework\TestCase;

class StatValueTest extends TestCase
{
    public function testCreatingFromArray()
    {
        $source = [
            'current_date_time' => '2017-01-02 12:43:55',
            'current_value' => 123.43,
            'previous_date_time' => '2016-12-27 05:14:27',
            'previous_value' => 545.12,
        ];

        $value = StatValue::createFromResponseData($source);

        $this->assertSame($source['current_value'], $value->getCurrentValue());
        $this->assertSame($source['previous_value'], $value->getPreviousValue());
        $this->assertEquals(new \DateTime($source['current_date_time']), $value->getCurrentDatetime());
        $this->assertEquals(new \DateTime($source['previous_date_time']), $value->getPreviousDatetime());
    }
}
