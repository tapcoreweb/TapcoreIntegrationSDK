<?php

namespace Tapcore\Integration\Entity;

use PHPUnit\Framework\TestCase;

class ApplicationListTest extends TestCase
{
    public function testGetters()
    {
        $app = new Application();
        $list = new ApplicationList([ $app ], 1, 10, 5);

        $this->assertCount(1, $list->getApplications());
        $this->assertSame($app, $list->getApplications()[0]);
        $this->assertSame(1, $list->getPage());
        $this->assertSame(10, $list->getPageSize());
        $this->assertSame(5, $list->getTotalCount());
    }
}
