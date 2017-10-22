<?php

namespace Tapcore\Integration\Client\Request;

use PHPUnit\Framework\TestCase;
use Tapcore\Integration\Entity\Application;

class ApplicationRequestTest extends TestCase
{
    public function testCorrectRequest()
    {
        $expectedQuery = [
            'page' => 10,
            'page_size' => 20,
            'active' => 1,
            'package' => 'com.package.test',
            'platform' => Application::PLATFORM_IOS,
            'order' => ApplicationsRequest::ORDER_BY_PACKAGE_NAME,
            'fields' => Application::FIELDS_SDK_BUILD . ',' . Application::FIELDS_PUBLISHER,
        ];

        $request = (new ApplicationsRequest())
            ->setPage($expectedQuery['page'])
            ->setPageSize($expectedQuery['page_size'])
            ->setActive($expectedQuery['active'])
            ->setPackage($expectedQuery['package'])
            ->setPlatform($expectedQuery['platform'])
            ->setOrderBy($expectedQuery['order'])
            ->addFieldToFetching(Application::FIELDS_SDK_BUILD)
            ->addFieldToFetching(Application::FIELDS_PUBLISHER);

        $this->assertArraySubset($expectedQuery, $request->getQueryParams());
        $this->assertEquals([], $request->getBodyParams());
    }
}
