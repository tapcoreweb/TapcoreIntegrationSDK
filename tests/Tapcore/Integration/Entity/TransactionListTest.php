<?php

namespace Tapcore\Integration\Entity;

use PHPUnit\Framework\TestCase;

class TransactionListTest extends TestCase
{
    public function testGetters()
    {
        $tr = new Transaction();
        $list = new TransactionList([ $tr, $tr ], 1, 10, 5);

        $this->assertCount(2, $list->getTransactions());
        $this->assertSame($tr, $list->getTransactions()[0]);
        $this->assertSame(1, $list->getPage());
        $this->assertSame(10, $list->getPageSize());
        $this->assertSame(5, $list->getTotalCount());
    }
}
