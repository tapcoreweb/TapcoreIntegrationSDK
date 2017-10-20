<?php

namespace Tapcore\Integration\Entity;

use Buzz\Message\Form\FormUpload;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    public function testCreatingFromArray()
    {
        $source = [
            'id' => 123,
            'code' => 'code123',
            'title' => 'title123',
            'name' => 'name123',
            'package' => 'package123',
            'platform' => 2,
            'image' => '/path/to/image',
            'logo' => '/path/to/image',
            'active' => true,
            'publisher' => [
                'id' => 234,
                'name' => 'publisher'
            ],
            'uid' => 'uid123',
            'on_market' => 'onMarket123',
            'created_at' => '2017-02-03 12:23:34',
            'updated_at' => '2017-03-04 13:43:54',
            'google_play_install' => false,
            'silent' => true,
            'mediator' => false,
            'check_multi_piracy' => false,
            'launch_spots_only_in_pirated_apps' => true,
            'sdk_initialized' => true,
            'sdk_initialized_at' => '2017-04-05 08:15:23',
            'sdk_build' => [
                'id' => 345
            ],
            'apk_build' => [
                'id' => 345
            ],
            'gms2_build' => [
                'id' => 345
            ],
        ];

        $app = Application::createFromResponseData($source);

        $this->assertSame($source['id'], $app->getId());
        $this->assertSame($source['code'], $app->getCode());
        $this->assertSame($source['title'], $app->getTitle());
        $this->assertSame($source['name'], $app->getName());
        $this->assertSame($source['package'], $app->getPackage());
        $this->assertSame($source['platform'], $app->getPlatform());
        $this->assertSame($source['image'], $app->getImage());
        $this->assertSame($source['logo'], $app->getLogo());
        $this->assertSame($source['active'], $app->isActive());
        $this->assertInstanceOf(Publisher::class, $app->getPublisher());
        $this->assertSame($source['uid'], $app->getUid());
        $this->assertSame($source['on_market'], $app->getOnMarket());
        $this->assertEquals(new \DateTime($source['created_at']), $app->getCreatedAt());
        $this->assertEquals(new \DateTime($source['updated_at']), $app->getUpdatedAt());
        $this->assertSame($source['google_play_install'], $app->isGooglePlayInstall());
        $this->assertSame($source['silent'], $app->isSilent());
        $this->assertSame($source['mediator'], $app->isMediator());
        $this->assertSame($source['check_multi_piracy'], $app->isCheckMultiPiracy());
        $this->assertSame($source['launch_spots_only_in_pirated_apps'], $app->isLaunchSpotsOnlyInPiratedApps());
        $this->assertSame($source['sdk_initialized'], $app->isSdkInitialized());
        $this->assertEquals(new \DateTime($source['sdk_initialized_at']), $app->getSdkInitializedAt());
        $this->assertInstanceOf(Build::class, $app->getSdkBuild());
        $this->assertSame($source['sdk_build']['id'], $app->getSdkBuild()->getId());
        $this->assertInstanceOf(Build::class, $app->getApkBuild());
        $this->assertSame($source['apk_build']['id'], $app->getApkBuild()->getId());
        $this->assertInstanceOf(Build::class, $app->getGms2Build());
        $this->assertSame($source['gms2_build']['id'], $app->getGms2Build()->getId());
    }

    public function testApplicationSetters()
    {
        $app = new Application();

        $app->setActive(true);
        $this->assertTrue($app->isActive());

        $app->setPlatform(Application::PLATFORM_ANDROID);
        $this->assertSame(Application::PLATFORM_ANDROID, $app->getPlatform());

        $app->setPackage('test');
        $this->assertSame('test', $app->getPackage());

        $app->setTitle('foo bar');
        $this->assertSame('foo bar', $app->getTitle());
    }

    public function testSetApplicationLogoFromUrl()
    {
        $app = new Application();

        $url = 'http://url.com/logo.png';
        $app->setLogoFromUrl($url);

        $this->assertEquals(['logo_url' => $url], $app->getUpdateParams());
    }

    public function testSetApplicationLogoFromFile()
    {
        $app = new Application();

        $path = '/path/to/logo.png';
        $app->setLogoFromFile($path);

        $params = $app->getUpdateParams();

        $this->assertArrayHasKey('logo_file', $params);
        $this->assertInstanceOf(FormUpload::class, $params['logo_file']);
        $this->assertSame($path, $params['logo_file']->getFile());
    }

    public function testSetApplicationLogoFromFileContent()
    {
        $app = new Application();

        $content = 'file content';
        $name = 'file name';
        $app->setLogoFromFileContent($content, $name);

        $params = $app->getUpdateParams();

        $this->assertArrayHasKey('logo_file', $params);
        $this->assertSame(base64_encode($content), $params['logo_file']);

        $this->assertArrayHasKey('logo_name', $params);
        $this->assertSame($name, $params['logo_name']);
    }
}
