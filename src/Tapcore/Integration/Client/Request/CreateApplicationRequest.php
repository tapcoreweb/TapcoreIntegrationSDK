<?php

namespace Tapcore\Integration\Client\Request;

use Buzz\Message\Form\FormUpload;
use Tapcore\Integration\Entity\Application;

class CreateApplicationRequest implements RequestInterface
{
    /** @var array */
    protected $params = [
        'platform' => Application::PLATFORM_ANDROID,
        'active' => 1
    ];

    /** @var string[] */
    protected $fields = [];

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->params['title'] = (string) $title;

        return $this;
    }

    /**
     * @param string $package
     *
     * @return $this
     */
    public function setPackage($package)
    {
        $this->params['package'] = (string) $package;

        return $this;
    }

    /**
     * @param string $filePath
     *
     * @return $this
     */
    public function setLogoFromFile($filePath)
    {
        $this->params['logo_file'] = new FormUpload($filePath);

        return $this;
    }

    /**
     * @param string $content
     * @param string $name
     *
     * @return $this
     */
    public function setLogoFromFileContent($content, $name)
    {
        $this->params['logo_file'] = base64_encode($content);
        $this->params['logo_name'] = (string) $name;

        return $this;
    }

    /**
     * @param string $link
     *
     * @return $this
     */
    public function setLogoFromUrl($link)
    {
        $this->params['logo_url'] = (string) $link;

        return $this;
    }

    /**
     * @param int $platform @see Application::PLATFORM_* constants
     *
     * @return $this
     */
    public function setPlatform($platform)
    {
        $this->params['platform'] = (int) $platform;

        return $this;
    }

    /**
     * @param bool $active
     *
     * @return $this
     */
    public function setActive($active)
    {
        $this->params['active'] = $active ? 1 : 0;

        return $this;
    }

    /**
     * @param string $field
     *
     * @return $this
     */
    public function addFieldToFetching($field)
    {
        $this->fields[] = (string) $field;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getQueryParams()
    {
        return [
            'fields' => implode(',', $this->fields),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getBodyParams()
    {
        return $this->params;
    }
}
