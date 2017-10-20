<?php

namespace Tapcore\Integration\Client;

use Buzz\Message\Request;
use Tapcore\Integration\Client\Request\TransactionsRequest;
use Tapcore\Integration\Entity\Publisher;
use Tapcore\Integration\Entity\Transaction;
use Tapcore\Integration\Entity\TransactionList;
use Tapcore\Integration\Exception\Exception as SDKException;

class ProfileClient extends BaseClient
{
    /**
     * @param string[] $fields Additional fields for fetching. See constants Publisher::FIELDS_*
     *
     * @return Publisher
     * @throws SDKException
     */
    public function getProfile(array $fields = [])
    {
        $response = $this->adapter->request('/profile', ['fields' => $fields]);

        $data = (array) $response->getData();

        return Publisher::createFromResponseData($data);
    }

    /**
     * @param Publisher $profile
     * @param string[] $fields Additional fields for fetching. See constants Publisher::FIELDS_*
     *
     * @return Publisher
     * @throws SDKException
     */
    public function updateProfile(Publisher $profile, array $fields = [])
    {
        $response = $this->adapter->request('/profile', ['fields' => $fields], [
            'name' => $profile->getName(),
        ], Request::METHOD_PUT);

        $data = (array) $response->getData();

        return Publisher::createFromResponseData($data);
    }

    /**
     * @param TransactionsRequest|null $request
     *
     * @return TransactionList
     * @throws SDKException
     */
    public function getTransactions(TransactionsRequest $request = null)
    {
        if (null === $request) {
            $request = new TransactionsRequest();
        }

        $response = $this->adapter->request(
            '/profile/transactions',
            $request->getQueryParams(),
            $request->getBodyParams()
        );

        $data = (array) $response->getData();

        $transactions = [];

        foreach ($data as $item) {
            $transactions[] = Transaction::createFromResponseData((array) $item);
        }

        return new TransactionList(
            $transactions,
            $response->getExtraHeaders()->getPage(),
            $response->getExtraHeaders()->getPageSize(),
            $response->getExtraHeaders()->getTotalCount()
        );
    }
}
