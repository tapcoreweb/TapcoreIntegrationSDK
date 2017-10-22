<?php

namespace Tapcore\Integration\Entity;

use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function testCreatingFromArray()
    {
        $source = [
            'id' => 123,
            'amount' => '321.43',
            'date_start' => '2017-01-02 12:43:55',
            'date_end' => '2017-01-02 12:43:55',
            'created_at' => '2017-01-02 12:43:55',
            'updated_at' => '2017-01-02 12:43:55',
            'applied_at' => '2017-01-02 12:43:55',
            'cancelled_at' => '2017-01-02 12:43:55',
            'paid' => 'false',
            'publisher' => [
                'id' => 234,
            ],
        ];

        $transaction = Transaction::createFromResponseData($source);

        $this->assertSame($source['id'], $transaction->getId());
        $this->assertSame((float) $source['amount'], $transaction->getAmount());
        $this->assertFalse($transaction->isPaid());
        $this->assertEquals(new \DateTime($source['date_start']), $transaction->getDateStart());
        $this->assertEquals(new \DateTime($source['date_end']), $transaction->getDateEnd());
        $this->assertEquals(new \DateTime($source['created_at']), $transaction->getCreatedAt());
        $this->assertEquals(new \DateTime($source['updated_at']), $transaction->getUpdatedAt());
        $this->assertEquals(new \DateTime($source['applied_at']), $transaction->getAppliedAt());
        $this->assertEquals(new \DateTime($source['cancelled_at']), $transaction->getCancelledAt());
        $this->assertInstanceOf(Publisher::class, $transaction->getPublisher());
        $this->assertSame($source['publisher']['id'], $transaction->getPublisher()->getId());
    }

    public function testNullableValues()
    {
        $transaction = Transaction::createFromResponseData([]);

        $this->assertNull($transaction->getUpdatedAt());
        $this->assertNull($transaction->getAppliedAt());
        $this->assertNull($transaction->getCancelledAt());
        $this->assertNull($transaction->getPublisher());
    }
}
