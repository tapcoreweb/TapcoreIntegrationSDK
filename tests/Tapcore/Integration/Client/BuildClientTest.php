<?php

namespace Tapcore\Integration\Client;

use Tapcore\Integration\Client\Request\WrapApplicationRequest;
use Tapcore\Integration\Entity\Application;
use Tapcore\Integration\Entity\Build;

class BuildClientTest extends BaseClientTest
{
    public function testStartSdkGeneration()
    {
        $client = new BuildClient($this->adapter);

        $app = $this->getMock(Application::class);
        $app->expects($this->once())
            ->method('getId')
            ->willReturn(123);

        $this->adapter
            ->expects($this->once())
            ->method('request')
            ->with(
                '/applications/123/sdk',
                [],
                ['silent_time' => 234, 'type' => Build::SDK_TYPE_UNITY_3D],
                'POST'
            )
            ->willReturn($this->apiResponse);

        $this->apiResponse
            ->expects($this->once())
            ->method('getData')
            ->willReturn([]);

        $build = $client->startSdkGeneration($app, 234, Build::SDK_TYPE_UNITY_3D);
        $this->assertInstanceOf(Build::class, $build);
    }

    public function testGetSdkBuild()
    {
        $client = new BuildClient($this->adapter);

        $app = $this->getMock(Application::class);
        $app->expects($this->once())
            ->method('getId')
            ->willReturn(123);

        $this->adapter
            ->expects($this->once())
            ->method('request')
            ->with('/applications/123/sdk/status', [], [], 'GET')
            ->willReturn($this->apiResponse);

        $this->apiResponse
            ->expects($this->once())
            ->method('getData')
            ->willReturn([]);

        $build = $client->getSdkBuild($app);
        $this->assertInstanceOf(Build::class, $build);
    }

    public function testStartGms2Generation()
    {
        $client = new BuildClient($this->adapter);

        $app = $this->getMock(Application::class);
        $app->expects($this->once())
            ->method('getId')
            ->willReturn(123);

        $this->adapter
            ->expects($this->once())
            ->method('request')
            ->with(
                '/applications/123/game-maker-cert',
                [],
                [],
                'POST'
            )
            ->willReturn($this->apiResponse);

        $this->apiResponse
            ->expects($this->once())
            ->method('getData')
            ->willReturn([]);

        $build = $client->startGameMakerStudio2CertificateGeneration($app);
        $this->assertInstanceOf(Build::class, $build);
    }

    public function testGetGms2Build()
    {
        $client = new BuildClient($this->adapter);

        $app = $this->getMock(Application::class);
        $app->expects($this->once())
            ->method('getId')
            ->willReturn(123);

        $this->adapter
            ->expects($this->once())
            ->method('request')
            ->with('/applications/123/game-maker-cert/status', [], [], 'GET')
            ->willReturn($this->apiResponse);

        $this->apiResponse
            ->expects($this->once())
            ->method('getData')
            ->willReturn([]);

        $build = $client->getGameMakerStudio2CertificateBuild($app);
        $this->assertInstanceOf(Build::class, $build);
    }

    public function testStartApplicationWrapping()
    {
        $client = new BuildClient($this->adapter);

        $app = $this->getMock(Application::class);
        $app->expects($this->once())
            ->method('getId')
            ->willReturn(123);

        $request = $this->getMock(WrapApplicationRequest::class);
        $request->expects($this->once())->method('getQueryParams')->willReturn([123]);
        $request->expects($this->once())->method('getBodyParams')->willReturn([234]);

        $this->adapter
            ->expects($this->once())
            ->method('request')
            ->with('/applications/123/wrap', [123], [234], 'POST')
            ->willReturn($this->apiResponse);

        $this->apiResponse
            ->expects($this->once())
            ->method('getData')
            ->willReturn([['id' => 123]]);

        $build = $client->startApplicationWrap($app, $request);

        $this->assertInstanceOf(Build::class, $build);
    }

    public function testGetWrapBuild()
    {
        $client = new BuildClient($this->adapter);

        $app = $this->getMock(Application::class);
        $app->expects($this->once())
            ->method('getId')
            ->willReturn(123);

        $this->adapter
            ->expects($this->once())
            ->method('request')
            ->with('/applications/123/wrap/status', [], [], 'GET')
            ->willReturn($this->apiResponse);

        $this->apiResponse
            ->expects($this->once())
            ->method('getData')
            ->willReturn([]);

        $build = $client->getApplicationWrapBuild($app);
        $this->assertInstanceOf(Build::class, $build);
    }
}
