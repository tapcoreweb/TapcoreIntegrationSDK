<?php

namespace Tapcore\Integration\Entity;

use PHPUnit\Framework\TestCase;

class PublisherTest extends TestCase
{
    public function testCreatingFromArray()
    {
        $source = [
            'id' => 123,
            'name' => 'name123',
            'email' => 'email@example.com',
            'type' => 'local',
            'created_at' => '2017-01-02 12:34:57',
            'updated_at' => '2017-10-14 13:21:42',
            'api_token' => 'token123',
            'money' => [
                'balance' => 432.12
            ],
        ];

        $publisher = Publisher::createFromResponseData($source);

        $this->assertSame($source['id'], $publisher->getId());
        $this->assertSame($source['name'], $publisher->getName());
        $this->assertSame($source['email'], $publisher->getEmail());
        $this->assertSame($source['type'], $publisher->getType());
        $this->assertSame($source['api_token'], $publisher->getApiToken());
        $this->assertEquals(new \DateTime($source['created_at']), $publisher->getCreatedAt());
        $this->assertEquals(new \DateTime($source['updated_at']), $publisher->getUpdatedAt());
        $this->assertInstanceOf(MoneySummary::class, $publisher->getMoney());
    }

    public function testSetName()
    {
        $publisher = new Publisher();
        $publisher->setName('test name');

        $this->assertSame('test name', $publisher->getName());
    }
}
