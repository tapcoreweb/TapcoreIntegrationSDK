<?php

namespace Tapcore\Helpers;

use PHPUnit\Framework\TestCase;

class ArrayHelperTest extends TestCase
{
    public function testGetNotExistsValue()
    {
        $stdClass = new \stdClass();
        $this->assertNull(ArrayHelper::value([], 'test'));
        $this->assertSame($stdClass, ArrayHelper::value([], 'test', $stdClass));

        $this->assertNull(ArrayHelper::valueFloat([], 'test'));
        $this->assertSame(12.2, ArrayHelper::valueFloat([], 'test', 12.2));

        $now = new \DateTime();
        $this->assertNull(ArrayHelper::valueDateTime([], 'test'));
        $this->assertSame($now, ArrayHelper::valueDateTime([], 'test', $now));

        $now->setTime(0, 0, 0);
        $this->assertNull(ArrayHelper::valueDate([], 'test'));
        $this->assertSame($now, ArrayHelper::valueDate([], 'test', $now));

        $this->assertNull(ArrayHelper::valueBool([], 'test'));
        $this->assertSame(true, ArrayHelper::valueBool([], 'test', true));
        $this->assertSame(false, ArrayHelper::valueBool([], 'test', false));

        $this->assertNull(ArrayHelper::valueInt([], 'test'));
        $this->assertSame(123, ArrayHelper::valueInt([], 'test', 123));

        $this->assertNull(ArrayHelper::valueString([], 'test'));
        $this->assertSame('foo', ArrayHelper::valueString([], 'test', 'foo'));

        $this->assertNull(ArrayHelper::valueDateTimeFromFormat([], 'test', 'Y-m-d H:i:s'));
        $this->assertSame($now, ArrayHelper::valueDateTimeFromFormat([], 'test', 'Y-m-d H:i:s', $now));
    }

    public function getValueCases()
    {
        $stdClass = new \stdClass();

        return [
            'std class' => [[ 'test' => $stdClass ], 'value', $stdClass],

            'integer' => [ ['test' => 123], 'valueInt', 123 ],
            'integer with type casting from string' => [ ['test' => '123'], 'valueInt', 123 ],
            'integer with type casting from float' => [ ['test' => 123.0], 'valueInt', 123 ],

            'float' => [ ['test' => 2.5], 'valueFloat', 2.5 ],
            'float with type casting from string' => [ ['test' => '2.5'], 'valueFloat', 2.5 ],
            'float with type casting from int' => [ ['test' => 12], 'valueFloat', 12.0 ],

            'string' => [ ['test' => 'string'], 'valueString', 'string' ],
            'string with type casting from int' => [ ['test' => 55], 'valueString', '55' ],
            'string with type casting from float' => [ ['test' => 12.1], 'valueString', '12.1' ],

            'bool (false)' => [ ['test' => false], 'valueBool', false ],
            'bool (true)' => [ ['test' => true], 'valueBool', true ],
            'bool with type casting from "false" string' => [ ['test' => 'false'], 'valueBool', false ],
            'bool with type casting from "true" string' => [ ['test' => 'true'], 'valueBool', true ],
            'bool with type casting from int (1)' => [ ['test' => 1], 'valueBool', true ],
            'bool with type casting from int (0)' => [ ['test' => 0], 'valueBool', false ],

            'date' => [ ['test' => '2017-02-03'], 'valueDate', new \DateTime('2017-02-03 00:00:00'), false ],
            'datetime' => [ ['test' => '2017-02-03 05:12:55'], 'valueDatetime', new \DateTime('2017-02-03 05:12:55'), false ],
        ];
    }

    /**
     * @dataProvider getValueCases
     *
     * @param array $data
     * @param string $method
     * @param mixed $expectedValue
     * @param bool $strict
     */
    public function testGetValue(array $data, $method, $expectedValue, $strict = false)
    {
        $actualValue = ArrayHelper::{$method}($data, 'test');

        if ($strict) {
            $this->assertSame($expectedValue, $actualValue);
        } else {
            $this->assertEquals($expectedValue, $actualValue);
        }
    }

    public function testCastToIntegersArray()
    {
        $sourceArray = ['123', '345', 234, 12.0];
        $expectedArray = [123, 345, 234, 12];

        $this->assertSame($expectedArray, ArrayHelper::castToIntegersArray($sourceArray));
    }

    public function testCastToFloatsArray()
    {
        $sourceArray = ['123', '345', 234, 12.0];
        $expectedArray = [123.0, 345.0, 234.0, 12.0];

        $this->assertSame($expectedArray, ArrayHelper::castToFloatsArray($sourceArray));
    }

    public function testCastToStringsArray()
    {
        $sourceArray = ['123', '345', 234, 12.0, 25.1];
        $expectedArray = ['123', '345', '234', '12', '25.1'];

        $this->assertSame($expectedArray, ArrayHelper::castToStringsArray($sourceArray));
    }
}
