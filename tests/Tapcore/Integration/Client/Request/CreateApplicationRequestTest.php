<?php

namespace Tapcore\Integration\Client\Request;

use PHPUnit\Framework\TestCase;
use Tapcore\Integration\Entity\Application;

class CreateApplicationRequestTest extends TestCase
{
    public function testCorrectRequest()
    {
        $data = [
            'title' => 'Test Application',
            'package' => 'com.test.package',
            'platform' => Application::PLATFORM_IOS,
            'active' => 1,
        ];

        $request = (new CreateApplicationRequest())
            ->setTitle($data['title'])
            ->setPackage($data['package'])
            ->setPlatform($data['platform'])
            ->setActive($data['active'])
            ->addFieldToFetching(Application::FIELDS_SDK_BUILD)
            ->addFieldToFetching(Application::FIELDS_PUBLISHER);

        $this->assertArraySubset([
            'fields' => Application::FIELDS_SDK_BUILD . ',' . Application::FIELDS_PUBLISHER
        ], $request->getQueryParams());
        $this->assertEquals($data, $request->getBodyParams());
    }

    public function testSetLogoFromFile()
    {
        $path = '/path/to/file';

        $request = (new CreateApplicationRequest())
            ->setLogoFromFile($path);

        $body = $request->getBodyParams();
        $this->assertArrayHasKey('logo_file', $body);
        $this->assertEquals($path, $body['logo_file']->getFile());
    }

    public function testSetLogoFromUrl()
    {
        $url = 'http://example.com/path/to/file';

        $request = (new CreateApplicationRequest())
            ->setLogoFromUrl($url);

        $body = $request->getBodyParams();
        $this->assertArrayHasKey('logo_url', $body);
        $this->assertEquals($url, $body['logo_url']);
    }

    public function testSetLogoFromFileContent()
    {
        $content = 'test file content';
        $name = 'test.name';

        $request = (new CreateApplicationRequest())
            ->setLogoFromFileContent($content, $name);

        $body = $request->getBodyParams();

        $this->assertArrayHasKey('logo_file', $body);
        $this->assertEquals(base64_encode($content), $body['logo_file']);

        $this->assertArrayHasKey('logo_name', $body);
        $this->assertEquals($name, $body['logo_name']);
    }
}
