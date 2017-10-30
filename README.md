# Tapcore Integration SDK

API Specification: https://alpha.my.tapcore.com/api/1.0/specification

## Installation

The recommended way to install Tapcore Integration SDK is through [Composer](http://getcomposer.org).

```bash
curl -sS https://getcomposer.org/installer | php
```

Then, run the Composer command to install the latest version:

```bash
composer.phar require tapcore/integration-sdk
```

## Examples

### Profile Client
```php
$adapter = new HttpAdapter('https://alpha.my.tapcore.com', '', '... your token here ...');
$client = new ProfileClient($adapter);

// Get profile info
$profile = $client->getProfile([ Publisher::FIELDS_MONEY ]);

// Update profile name
$profile->setName('My New Name');
$profile = $client->updateProfile($profile, [ Publisher::FIELDS_MONEY ]);

// Get billing transactions for Aug of 2017
$request = (new TransactionsRequest())
    ->setDateStart(new \DateTime('2017-08-01 00:00:00'))
    ->setDateEnd(new \DateTime('2017-08-30 23:59:59')); 
$transactions = $client->getTransactions($request);

```

### Applications Client
```php
$adapter = new HttpAdapter('https://alpha.my.tapcore.com', '', '... your token here ...');
$client = new ApplicationClient($adapter);

// Search app by package name
$request = (new ApplicationsRequest())
    ->setPackage('com.my.favorite.application');
$apps = $client->getApplications($request);

// Get application by ID
$app = $client->getApplication(123);

// Create application
$request = (new CreateApplicationRequest())
    ->setTitle('My New Application')
    ->setPackage('com.my.new_application')
    ->setPlatform(Application::PLATFORM_ANDROID)
    ->setActive(true)
    ->setLogoFromUrl('http://......png');
$app = $client->createApplication($request);

// Update application
$app->setActive(false);
$client->updateApplication($app);
```

### Reporting Client
```php
$adapter = new HttpAdapter('https://alpha.my.tapcore.com', '', '... your token here ...');
$client = new ReportingClient($adapter);

// Get impressions for Aug of 2017
$request = (new StatisticsRequest(StatisticsRequest::TYPE_IMPRESSIONS))
    ->setDateStart(new \DateTime('2017-08-01 00:00:00'))
    ->setDateEnd(new \DateTime('2017-08-30 23:59:59'));
$report = $client->getStatistics($request);

// Get overview metrics for Aug of 2017
$request = (new StatisticsOverviewRequest())
    ->setDateStart(new \DateTime('2017-08-01 00:00:00'))
    ->setDateEnd(new \DateTime('2017-08-30 23:59:59'));
$report = $client->getStatisticsOverview($request);

// Get impressions summary report
$request = (new MetricSummaryRequest(MetricSummaryRequest::TYPE_IMPRESSIONS));
$report = $client->getStatisticsMetricSummary($request);
```

### Build Client
```php
$adapter = new HttpAdapter('https://alpha.my.tapcore.com', '', '... your token here ...');
$client = new BuildClient($adapter);

$app = ... get app from ApplicationClient 

// Start SDK generation build for native application
$build = $client->startSdkGeneration($app, 86400, Build::SDK_TYPE_NATIVE);

// Start SDK generation build for Unity3D application
$build = $client->startSdkGeneration($app, 86400, Build::SDK_TYPE_UNITY_3D);

// Get status of current SDK generation build (last)
$build = $client->getSdkBuild($app);

// Download SDK (works fine only if build was successfully finished)
// Method will return SplFileObject with SDK zip archive
$file = $client->downloadSdk($app);

// Start GMS2 Certificate generation build
$build = $client->startGameMakerStudio2CertificateGeneration($app);

// Get status of current GMS2 certificate generation build (last)
$build = $client->getGameMakerStudio2CertificateBuild($app);

// Download GMS2 certificate (works fine only if build was successfully finished)
// Method will return SplFileObject with certificate
$file = $client->downloadGameMakerStudio2Certificate($app);

// Start automatically wrapping for APKfile
$request = (new WrapApplicationRequest())
    ->setMode(WrapApplicationRequest::MODE_AUTO)
    ->setSilentTime(86400)
    ->setApkFromFile('/path/to/file.apk');
$build = $client->startApplicationWrap($app, $request);

// Get status of current APK wrapping build (last)
$build = $client->getgetApplicationWrapBuild($app);

// Download wrapped APK file (works fine only if build was successfully finished)
// Method will return SplFileObject with APK file with integrated TapcoreSDK
$file = $client->downloadWrappedApk($app);

// Download keystore archive for wrapped APK file (works fine only if build was successfully finished)
// Method will return SplFileObject for archive with keystore info 
$file = $client->downloadWrappedApkKeystore($app);
```
