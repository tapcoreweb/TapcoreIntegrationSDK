<?php

namespace Tapcore\Integration\Client\Request;

use PHPUnit\Framework\TestCase;

class WrapApplicationRequestTest extends TestCase
{
    public function testCorrectRequest()
    {
        $data = [
            'silent_time' => 1243,
            'mode' => WrapApplicationRequest::MODE_MANUAL,
            'keystore_password' => 'password for keystore',
            'alias' => 'alias name',
            'alias_password' => 'password for alias',
        ];

        $request = (new WrapApplicationRequest())
            ->setSilentTime($data['silent_time'])
            ->setMode($data['mode'])
            ->setKeystorePassword($data['keystore_password'])
            ->setAlias($data['alias'])
            ->setAliasPassword($data['alias_password']);

        $this->assertArraySubset([], $request->getQueryParams());
        $this->assertEquals($data, $request->getBodyParams());
    }

    public function testApkFromFile()
    {
        $path = '/path/to/file';

        $request = (new WrapApplicationRequest())
            ->setApkFromFile($path);

        $body = $request->getBodyParams();
        $this->assertArrayHasKey('apk_file', $body);
        $this->assertEquals($path, $body['apk_file']->getFile());
    }

    public function testApkFromFileContent()
    {
        $content = 'test file content';

        $request = (new WrapApplicationRequest())
            ->setApkFromFileContent($content);

        $body = $request->getBodyParams();

        $this->assertArrayHasKey('apk_file', $body);
        $this->assertEquals(base64_encode($content), $body['apk_file']);
    }

    public function testKeystoreFromFile()
    {
        $path = '/path/to/file';

        $request = (new WrapApplicationRequest())
            ->setKeystoreFromFile($path);

        $body = $request->getBodyParams();
        $this->assertArrayHasKey('keystore_file', $body);
        $this->assertEquals($path, $body['keystore_file']->getFile());
    }

    public function testKeystoreFromFileContent()
    {
        $content = 'test file content';

        $request = (new WrapApplicationRequest())
            ->setKeystoreFromFileContent($content);

        $body = $request->getBodyParams();

        $this->assertArrayHasKey('keystore_file', $body);
        $this->assertEquals(base64_encode($content), $body['keystore_file']);
    }
}
