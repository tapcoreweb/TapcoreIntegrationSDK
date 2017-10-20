<?php

namespace Tapcore\Integration\Client;

use Tapcore\Integration\Client\Buzz\Request;
use Tapcore\Integration\Client\Request\ApplicationsRequest;
use Tapcore\Integration\Client\Request\CreateApplicationRequest;
use Tapcore\Integration\Entity\Application;
use Tapcore\Integration\Entity\ApplicationList;
use Tapcore\Integration\Exception\Exception as SDKException;

class ApplicationClient extends BaseClient
{
    /**
     * @param ApplicationsRequest|null $request
     *
     * @return ApplicationList
     * @throws SDKException
     */
    public function getApplications(ApplicationsRequest $request = null)
    {
        if (null === $request) {
            $request = new ApplicationsRequest();
        }

        $response = $this->adapter->request(
            '/applications',
            $request->getQueryParams(),
            $request->getBodyParams()
        );

        $data = (array) $response->getData();

        $applications = [];

        foreach ($data as $item) {
            $applications[] = Application::createFromResponseData((array) $item);
        }

        return new ApplicationList(
            $applications,
            $response->getExtraHeaders()->getPage(),
            $response->getExtraHeaders()->getPageSize(),
            $response->getExtraHeaders()->getTotalCount()
        );
    }

    /**
     * @param int $id
     * @param array $fields
     *
     * @return Application
     * @throws SDKException
     */
    public function getApplication($id, array $fields = [])
    {
        $response = $this->adapter->request(\sprintf('/applications/%d', $id), [
            'fields' => implode(',', $fields)
        ]);

        $data = (array) $response->getData();

        return Application::createFromResponseData((array) $data);
    }

    /**
     * @param CreateApplicationRequest $request
     *
     * @return Application
     * @throws SDKException
     */
    public function createApplication(CreateApplicationRequest $request)
    {
        $response = $this->adapter->request(
            '/applications',
            $request->getQueryParams(),
            $request->getBodyParams(),
            Request::METHOD_POST
        );

        $data = (array) $response->getData();

        return Application::createFromResponseData((array) $data);
    }

    /**
     * @param Application $application
     *
     * @param array $fields
     *
     * @return Application
     * @throws SDKException
     */
    public function updateApplication(Application $application, array $fields = [])
    {
        $body = array_merge($application->getUpdateParams(), [
            'title' => $application->getTitle(),
            'package' => $application->getPackage(),
            'platform' => $application->getPlatform(),
            'active' => $application->isActive() ? 1 : 0,
        ]);

        $response = $this->adapter->request(
            \sprintf('/applications/%d', $application->getId()),
            ['fields' => implode(',', $fields)],
            $body,
            Request::METHOD_PUT
        );

        $data = (array) $response->getData();

        return Application::createFromResponseData((array) $data);
    }
}
