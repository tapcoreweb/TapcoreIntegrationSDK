<?php

namespace Tapcore\Integration\Client;

use Tapcore\Integration\Client\Buzz\Request;
use Tapcore\Integration\Client\Request\WrapApplicationRequest;
use Tapcore\Integration\Entity\Application;
use Tapcore\Integration\Entity\Build;
use Tapcore\Integration\Exception\Exception as SDKException;

class BuildClient extends BaseClient
{
    /**
     * @param Application $application
     *
     * @param int $silentTime Silent time in seconds
     * @param string $sdkType Type of SDK. @see Build::SDK_TYPE_* constants
     *
     * @return Build
     * @throws SDKException
     */
    public function startSdkGeneration(Application $application, $silentTime = 86400, $sdkType = Build::SDK_TYPE_NATIVE)
    {
        $response = $this->adapter->request(\sprintf('/applications/%d/sdk', $application->getId()), [], [
            'silent_time' => (int) $silentTime,
            'type' => (string) $sdkType,
        ], Request::METHOD_POST);

        $data = (array) $response->getData();

        return Build::createFromResponseData($data);
    }

    /**
     * @param Application $application
     *
     * @return Build
     * @throws SDKException
     */
    public function getSdkBuild(Application $application)
    {
        $response = $this->adapter->request(\sprintf('/applications/%d/sdk/status', $application->getId()));

        $data = (array) $response->getData();

        return Build::createFromResponseData($data);
    }

    /**
     * @param Application $application
     *
     * @return \SplFileObject
     * @throws SDKException
     */
    public function downloadSdk(Application $application)
    {
        $response = $this->adapter->requestRaw(\sprintf('/applications/%d/sdk', $application->getId()));

        if ($response->getStatusCode() !== 200) {
            throw new SDKException("Build wasn't finished yet");
        }

        $path = tempnam(sys_get_temp_dir(), '');
        @unlink($path);
        $path = "{$path}-tapcore-sdk.zip";

        $file = fopen($path, 'w');
        fwrite($file, $response->getRawContent());
        fclose($file);

        return new \SplFileObject($path);
    }

    /**
     * @param Application $application
     *
     * @param WrapApplicationRequest $request
     *
     * @return Build
     * @throws SDKException
     */
    public function startApplicationWrap(Application $application, WrapApplicationRequest $request)
    {
        $response = $this->adapter->request(
            \sprintf('/applications/%d/wrap',
            $application->getId()),
            $request->getQueryParams(),
            $request->getBodyParams(),
            Request::METHOD_POST
        );

        $data = (array) $response->getData();

        return Build::createFromResponseData($data);
    }

    /**
     * @param Application $application
     *
     * @return Build
     * @throws SDKException
     */
    public function getApplicationWrapBuild(Application $application)
    {
        $response = $this->adapter->request(\sprintf('/applications/%d/wrap/status', $application->getId()));

        $data = (array) $response->getData();

        return Build::createFromResponseData($data);
    }

    /**
     * @param Application $application
     *
     * @return \SplFileObject
     * @throws SDKException
     */
    public function downloadWrappedApk(Application $application)
    {
        $response = $this->adapter->requestRaw(\sprintf('/applications/%d/wrap', $application->getId()));

        if ($response->getStatusCode() !== 200) {
            throw new SDKException("Build wasn't finished yet");
        }

        $path = tempnam(sys_get_temp_dir(), '');
        @unlink($path);
        $path = "{$path}-apk-file.apk";

        $file = fopen($path, 'w');
        fwrite($file, $response->getRawContent());
        fclose($file);

        return new \SplFileObject($path);
    }

    /**
     * @param Application $application
     *
     * @return \SplFileObject
     * @throws SDKException
     */
    public function downloadWrappedApkKeystore(Application $application)
    {
        $response = $this->adapter->requestRaw(\sprintf('/applications/%d/wrap/keystore', $application->getId()));

        if ($response->getStatusCode() !== 200) {
            throw new SDKException("Build wasn't finished yet");
        }

        $path = tempnam(sys_get_temp_dir(), '');
        @unlink($path);
        $path = "{$path}-keystore.zip";

        $file = fopen($path, 'w');
        fwrite($file, $response->getRawContent());
        fclose($file);

        return new \SplFileObject($path);
    }

    /**
     * @param Application $application
     *
     * @return Build
     * @throws SDKException
     */
    public function startGameMakerStudio2CertificateGeneration(Application $application)
    {
        $response = $this->adapter->request(
            \sprintf('/applications/%d/game-maker-cert',
            $application->getId()),
            [],
            [],
            Request::METHOD_POST
        );

        $data = (array) $response->getData();

        return Build::createFromResponseData($data);
    }

    /**
     * @param Application $application
     *
     * @return Build
     * @throws SDKException
     */
    public function getGameMakerStudio2CertificateBuild(Application $application)
    {
        $response = $this->adapter->request(\sprintf('/applications/%d/game-maker-cert/status', $application->getId()));

        $data = (array) $response->getData();

        return Build::createFromResponseData($data);
    }

    /**
     * @param Application $application
     *
     * @return \SplFileObject
     * @throws SDKException
     */
    public function downloadGameMakerStudio2Certificate(Application $application)
    {
        $response = $this->adapter->requestRaw(\sprintf('/applications/%d/game-maker-cert', $application->getId()));

        if ($response->getStatusCode() !== 200) {
            throw new SDKException("Build wasn't finished yet");
        }

        $path = tempnam(sys_get_temp_dir(), '');
        @unlink($path);
        $path = "{$path}-gms2.crt";

        $file = fopen($path, 'w');
        fwrite($file, $response->getRawContent());
        fclose($file);

        return new \SplFileObject($path);
    }
}
