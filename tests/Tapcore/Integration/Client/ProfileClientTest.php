<?php

namespace Tapcore\Integration\Client;

use Tapcore\Integration\Client\Request\TransactionsRequest;
use Tapcore\Integration\Entity\Publisher;
use Tapcore\Integration\Entity\Transaction;
use Tapcore\Integration\Entity\TransactionList;

class ProfileClientTest extends BaseClientTest
{
    public function testGetProfile()
    {
        $client = new ProfileClient($this->adapter);

        $this->adapter
            ->expects($this->once())
            ->method('request')
            ->with('/profile', ['fields' => ['field1','field2']], [], 'GET')
            ->willReturn($this->apiResponse);

        $this->apiResponse
            ->expects($this->once())
            ->method('getData')
            ->willReturn(['id' => 123]);

        $app = $client->getProfile(['field1', 'field2']);

        $this->assertInstanceOf(Publisher::class, $app);
    }

    public function testUpdateProfile()
    {
        $client = new ProfileClient($this->adapter);

        $profile = $this->getMock(Publisher::class);

        $profile->expects($this->once())
            ->method('getName')
            ->willReturn('name');

        $this->adapter
            ->expects($this->once())
            ->method('request')
            ->with('/profile', ['fields' => ['field1','field2']], [
                'name' => 'name',
            ], 'PUT')
            ->willReturn($this->apiResponse);

        $this->apiResponse
            ->expects($this->once())
            ->method('getData')
            ->willReturn(['id' => 123]);

        $profile = $client->updateProfile($profile, ['field1', 'field2']);

        $this->assertInstanceOf(Publisher::class, $profile);
    }

    public function testGetTransactions()
    {
        $client = new ProfileClient($this->adapter);

        $request = $this->getMock(TransactionsRequest::class);

        $request->expects($this->once())->method('getQueryParams')->willReturn([]);
        $request->expects($this->once())->method('getBodyParams')->willReturn([]);

        $this->adapter
            ->expects($this->once())
            ->method('request')
            ->with('/profile/transactions', [], [], 'GET')
            ->willReturn($this->apiResponse);

        $this->apiResponse
            ->expects($this->once())
            ->method('getData')
            ->willReturn([['id' => 123]]);

        $list = $client->getTransactions($request);

        $this->assertInstanceOf(TransactionList::class, $list);
        $this->assertCount(1, $list->getTransactions());
        $this->assertInstanceOf(Transaction::class, $list->getTransactions()[0]);
    }
}
