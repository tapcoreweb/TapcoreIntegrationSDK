<?php

namespace Tapcore\Integration\Client;

use Tapcore\Integration\Client\Request\ApplicationsRequest;
use Tapcore\Integration\Client\Request\CreateApplicationRequest;
use Tapcore\Integration\Entity\Application;
use Tapcore\Integration\Entity\ApplicationList;

class ApplicationClientTest extends BaseClientTest
{
    public function testGetApplications()
    {
        $client = new ApplicationClient($this->adapter);

        $request = $this->getMock(ApplicationsRequest::class);

        $request->expects($this->once())->method('getQueryParams')->willReturn([]);
        $request->expects($this->once())->method('getBodyParams')->willReturn([]);

        $this->adapter
            ->expects($this->once())
            ->method('request')
            ->with('/applications', [], [], 'GET')
            ->willReturn($this->apiResponse);

        $this->apiResponse
            ->expects($this->once())
            ->method('getData')
            ->willReturn([['id' => 123]]);

        $list = $client->getApplications($request);

        $this->assertInstanceOf(ApplicationList::class, $list);
        $this->assertCount(1, $list->getApplications());
        $this->assertInstanceOf(Application::class, $list->getApplications()[0]);
    }

    public function testGetApplication()
    {
        $client = new ApplicationClient($this->adapter);

        $this->adapter
            ->expects($this->once())
            ->method('request')
            ->with('/applications/123', ['fields' => 'field1,field2'], [], 'GET')
            ->willReturn($this->apiResponse);

        $this->apiResponse
            ->expects($this->once())
            ->method('getData')
            ->willReturn(['id' => 123]);

        $app = $client->getApplication(123, ['field1', 'field2']);

        $this->assertInstanceOf(Application::class, $app);
    }

    public function testCreateApplication()
    {
        $client = new ApplicationClient($this->adapter);

        $request = $this->getMock(CreateApplicationRequest::class);

        $request->expects($this->once())->method('getQueryParams')->willReturn([123]);
        $request->expects($this->once())->method('getBodyParams')->willReturn([234]);

        $this->adapter
            ->expects($this->once())
            ->method('request')
            ->with('/applications', [123], [234], 'POST')
            ->willReturn($this->apiResponse);

        $this->apiResponse
            ->expects($this->once())
            ->method('getData')
            ->willReturn(['id' => 123]);

        $app = $client->createApplication($request);

        $this->assertInstanceOf(Application::class, $app);
    }

    public function testUpdateApplication()
    {
        $client = new ApplicationClient($this->adapter);

        $app = $this->getMock(Application::class);

        $app->expects($this->once())
            ->method('getId')
            ->willReturn(123);

        $app->expects($this->once())
            ->method('getTitle')
            ->willReturn('title');

        $app->expects($this->once())
            ->method('getPackage')
            ->willReturn('package');

        $app->expects($this->once())
            ->method('getPlatform')
            ->willReturn(1);

        $app->expects($this->once())
            ->method('isActive')
            ->willReturn(false);

        $app->expects($this->once())
            ->method('getUpdateParams')
            ->willReturn([]);

        $this->adapter
            ->expects($this->once())
            ->method('request')
            ->with('/applications/123', ['fields' => 'field1,field2'], [
                'title' => 'title',
                'package' => 'package',
                'platform' => 1,
                'active' => 0
            ], 'PUT')
            ->willReturn($this->apiResponse);

        $this->apiResponse
            ->expects($this->once())
            ->method('getData')
            ->willReturn(['id' => 123]);

        $app = $client->updateApplication($app, ['field1', 'field2']);

        $this->assertInstanceOf(Application::class, $app);
    }
}
