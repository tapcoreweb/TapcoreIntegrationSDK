<?php

namespace Tapcore\Integration\Entity;

use Buzz\Message\Form\FormUpload;
use Tapcore\Helpers\ArrayHelper;

class Application implements EntityInterface
{
    /** Publisher info */
    const FIELDS_PUBLISHER = 'Application.publisher';

    /** SDK build info */
    const FIELDS_SDK_BUILD = 'Application.sdkBuild';

    /** APK wrap info */
    const FIELDS_APK_BUILD = 'Application.apkBuild';

    /** Game Maker Studio 2 certificate build info */
    const FIELDS_GMS2_BUILD = 'Application.gms2Build';

    /** Extended info about application */
    const FIELDS_EXTENDED = 'Application.extended';

    const PLATFORM_ANDROID = 1;
    const PLATFORM_IOS = 2;

    /** @var int */
    protected $id;

    /** @var string */
    protected $code;

    /** @var string */
    protected $title;

    /** @var string */
    protected $name;

    /** @var string */
    protected $package;

    /** @var int */
    protected $platform;

    /** @var string */
    protected $image;

    /** @var string */
    protected $logo;

    /** @var bool */
    protected $active;

    /** @var Publisher|null */
    protected $publisher;

    /** @var string|null */
    protected $uid;

    /** @var string|null */
    protected $onMarket;

    /** @var \DateTime|null */
    protected $createdAt;

    /** @var \DateTime|null */
    protected $updatedAt;

    /** @var bool|null */
    protected $googlePlayInstall;

    /** @var bool|null */
    protected $silent;

    /** @var bool|null */
    protected $mediator;

    /** @var bool|null */
    protected $checkMultiPiracy;

    /** @var bool|null */
    protected $launchSpotsOnlyInPiratedApps;

    /** @var bool|null */
    protected $sdkInitialized;

    /** @var \DateTime|null */
    protected $sdkInitializedAt;

    /** @var Build|null */
    protected $sdkBuild;

    /** @var Build|null */
    protected $apkBuild;

    /** @var Build|null */
    protected $gms2Build;

    /**
     * @var array
     */
    protected $updateParams = [];

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = (string) $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @param string $package
     *
     * @return $this
     */
    public function setPackage($package)
    {
        $this->package = (string) $package;

        return $this;
    }

    /**
     * @return int
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param int $platform @see Application::PLATFORM_* constants
     *
     * @return $this
     */
    public function setPlatform($platform)
    {
        $this->platform = (int) $platform;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $filePath
     *
     * @return $this
     */
    public function setLogoFromFile($filePath)
    {
        $this->updateParams['logo_file'] = new FormUpload($filePath);

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
        $this->updateParams['logo_file'] = base64_encode($content);
        $this->updateParams['logo_name'] = (string) $name;

        return $this;
    }

    /**
     * @param string $link
     *
     * @return $this
     */
    public function setLogoFromUrl($link)
    {
        $this->updateParams['logo_url'] = (string) $link;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $flag
     *
     * @return $this
     */
    public function setActive($flag)
    {
        $this->active = (bool) $flag;

        return $this;
    }

    /**
     * @return null|Publisher
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @return null|string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @return null|string
     */
    public function getOnMarket()
    {
        return $this->onMarket;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return bool|null
     */
    public function isGooglePlayInstall()
    {
        return $this->googlePlayInstall;
    }

    /**
     * @return bool|null
     */
    public function isSilent()
    {
        return $this->silent;
    }

    /**
     * @return bool|null
     */
    public function isMediator()
    {
        return $this->mediator;
    }

    /**
     * @return bool|null
     */
    public function isCheckMultiPiracy()
    {
        return $this->checkMultiPiracy;
    }

    /**
     * @return bool|null
     */
    public function isLaunchSpotsOnlyInPiratedApps()
    {
        return $this->launchSpotsOnlyInPiratedApps;
    }

    /**
     * @return bool|null
     */
    public function isSdkInitialized()
    {
        return $this->sdkInitialized;
    }

    /**
     * @return \DateTime|null
     */
    public function getSdkInitializedAt()
    {
        return $this->sdkInitializedAt;
    }

    /**
     * @return null|Build
     */
    public function getSdkBuild()
    {
        return $this->sdkBuild;
    }

    /**
     * @return null|Build
     */
    public function getApkBuild()
    {
        return $this->apkBuild;
    }

    /**
     * @return null|Build
     */
    public function getGms2Build()
    {
        return $this->gms2Build;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public static function createFromResponseData(array $data)
    {
        $item = new self();

        $item->id = ArrayHelper::valueInt($data, 'id');
        $item->code = ArrayHelper::valueString($data, 'code');
        $item->title = ArrayHelper::valueString($data, 'title');
        $item->name = ArrayHelper::valueString($data, 'name');
        $item->package = ArrayHelper::valueString($data, 'package');
        $item->platform = ArrayHelper::valueInt($data, 'platform');
        $item->image = ArrayHelper::valueString($data, 'image');
        $item->logo = ArrayHelper::valueString($data, 'logo');
        $item->active = ArrayHelper::valueBool($data, 'active');
        $item->uid = ArrayHelper::valueString($data, 'uid');
        $item->onMarket = ArrayHelper::valueString($data, 'on_market');
        $item->createdAt = ArrayHelper::valueDateTime($data, 'created_at');
        $item->updatedAt = ArrayHelper::valueString($data, 'updated_at');
        $item->googlePlayInstall = ArrayHelper::valueString($data, 'google_play_install');
        $item->silent = ArrayHelper::valueBool($data, 'silent');
        $item->mediator = ArrayHelper::valueBool($data, 'mediator');
        $item->checkMultiPiracy = ArrayHelper::valueBool($data, 'check_multi_piracy');
        $item->launchSpotsOnlyInPiratedApps = ArrayHelper::valueBool($data, 'launch_spots_only_in_pirated_apps');
        $item->sdkInitialized = ArrayHelper::valueBool($data, 'sdk_initialized');
        $item->sdkInitializedAt = ArrayHelper::valueDateTime($data, 'sdk_initialized_at');
        $item->createdAt = ArrayHelper::valueDateTime($data, 'created_at');
        $item->updatedAt = ArrayHelper::valueDateTime($data, 'updated_at');

        $publisher = (array) ArrayHelper::value($data, 'publisher', []);
        if (!empty($publisher)) {
            $item->publisher = Publisher::createFromResponseData($publisher);
        }

        $sdkBuild = (array) ArrayHelper::value($data, 'sdk_build', []);
        if (!empty($sdkBuild)) {
            $item->sdkBuild = Build::createFromResponseData($sdkBuild);
        }

        $apkBuild = (array) ArrayHelper::value($data, 'apk_build', []);
        if (!empty($apkBuild)) {
            $item->apkBuild = Build::createFromResponseData($apkBuild);
        }

        $gms2Build = (array) ArrayHelper::value($data, 'gms2_build', []);
        if (!empty($gms2Build)) {
            $item->gms2Build = Build::createFromResponseData($gms2Build);
        }

        return $item;
    }

    /**
     * @return array
     */
    public function getUpdateParams()
    {
        return $this->updateParams;
    }
}
