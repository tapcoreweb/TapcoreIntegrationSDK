<?php

namespace Tapcore\Integration\Client\Request;

use Buzz\Message\Form\FormUpload;

class WrapApplicationRequest implements RequestInterface
{
    const MODE_AUTO = 'auto';
    const MODE_MANUAL = 'manual';

    /** @var array */
    protected $params = [
        'mode' => self::MODE_AUTO,
        'silent_time' => 86400,
    ];

    /**
     * @param int $silentTime
     *
     * @return $this
     */
    public function setSilentTime($silentTime)
    {
        $this->params['silent_time'] = (int) $silentTime;

        return $this;
    }

    /**
     * @param string $mode
     *
     * @return $this
     */
    public function setMode($mode = self::MODE_AUTO)
    {
        $this->params['mode'] = (string) $mode;

        return $this;
    }

    /**
     * @param string $filePath
     *
     * @return $this
     */
    public function setApkFromFile($filePath)
    {
        $this->params['apk_file'] = new FormUpload($filePath);

        return $this;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setApkFromFileContent($content)
    {
        $this->params['apk_file'] = base64_encode($content);

        return $this;
    }

    /**
     * @param string $filePath
     *
     * @return $this
     */
    public function setKeystoreFromFile($filePath)
    {
        $this->params['keystore_file'] = new FormUpload($filePath);

        return $this;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setKeystoreFromFileContent($content)
    {
        $this->params['keystore_file'] = base64_encode($content);

        return $this;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setKeystorePassword($password)
    {
        $this->params['keystore_password'] = (string) $password;

        return $this;
    }

    /**
     * @param string $alias
     *
     * @return $this
     */
    public function setAlias($alias)
    {
        $this->params['alias'] = (string) $alias;

        return $this;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setAliasPassword($password)
    {
        $this->params['alias_password'] = (string) $password;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getQueryParams()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getBodyParams()
    {
        return $this->params;
    }
}
