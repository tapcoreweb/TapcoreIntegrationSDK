<?php

namespace Tapcore\Integration\Adapter;

use Buzz\Browser;
use Buzz\Util\Url;
use Tapcore\Integration\Client\Buzz\Factory;
use Tapcore\Integration\Client\Buzz\Request;
use Tapcore\Integration\Client\Buzz\Response;
use Tapcore\Integration\Client\Buzz\FileGetContents;
use Tapcore\Integration\Client\Api\ApiResponse;
use Tapcore\Integration\Client\Api\ApiResponseFactory;
use Tapcore\Integration\Exception\AccessDeniedException;
use Tapcore\Integration\Exception\Exception as SDKException;
use Tapcore\Integration\Exception\InvalidArgumentException;
use Tapcore\Integration\Exception\NotFoundException;
use Tapcore\Integration\SDK;

class HttpAdapter implements AdapterInterface
{
    /** @var string */
    protected $urlTemplate = '/{prefix}/{version}/{method}?{params}';

    /** @var string */
    protected $host = "";

    /** @var string */
    protected $authToken;

    /** @var string */
    protected $apiPath = "";

    /** @var Browser */
    protected $browser;

    /**
     * @param string  $host
     * @param string  $apiPathPrefix
     * @param string  $authToken
     * @param Browser $browser
     * @param int     $timeout
     */
    public function __construct(
        $host,
        $apiPathPrefix = "",
        $authToken = "",
        Browser $browser = null,
        $timeout = SDK::DEFAULT_TIMEOUT
    ) {
        $this->host = $this->prepareHost((string) $host);
        $this->apiPath = $this->generateApiPath((string) $apiPathPrefix);
        $this->authToken = $authToken;
        $this->browser = $browser ?: new Browser(new FileGetContents($timeout), new Factory());
    }

    /**
     * {@inheritdoc}
     */
    public function request($apiMethod, array $queryParams = [], array $fields = [], $method = Request::METHOD_GET)
    {
        $response = $this->requestRaw($apiMethod, $queryParams, $fields, $method);

        return $this->parseResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    public function requestRaw($apiMethod, array $queryParams = [], array $fields = [], $method = Request::METHOD_GET)
    {
        $request = $this->createRequest((string) $apiMethod, $queryParams, $fields, (string) $method);

        try {
            /** @var Response $response */
            $response = $this->browser->send($request);
        } catch (\Exception $e) {
            throw new SDKException('Fail to call API method', 0, $e);
        }

        return $response;
    }

    /**
     * @param string $host
     *
     * @return string
     */
    protected function prepareHost($host)
    {
        $host = (new Url((string) $host))->getHost();
        $host = \rtrim((string) $host, '/');

        return $host;
    }

    /**
     * @param string $apiMethod
     * @param array $queryParams
     * @param string[] $fields
     * @param string $method
     *
     * @return Request
     */
    protected function createRequest(
        $apiMethod,
        array $queryParams = [],
        array $fields = [],
        $method = Request::METHOD_GET
    ) {
        $resource = $this->prepareUrl([
            'method' => $apiMethod,
            'params' => $this->prepareQueryParams($queryParams)
        ]);

        /** @var Request $request */
        $request = $this->browser->getMessageFactory()->createRequest($method, $resource, $this->host);
        $request->setFields($fields);

        if (!empty($this->authToken)) {
            $request->setHeaders([
                'Authorization' => "Bearer {$this->authToken}"
            ]);
        }

        return $request;
    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    protected function generateApiPath($prefix = '')
    {
        $prefix = \ltrim(\rtrim($prefix, '/') . '/api', '/');

        $path = \str_replace(['{prefix}', '{version}'], [$prefix, SDK::VERSION], $this->urlTemplate);

        return $path;
    }

    /**
     * @param string[] $urlValues
     *
     * @return string
     */
    protected function prepareUrl(array $urlValues)
    {
        $url = $this->apiPath;

        foreach ($urlValues as $template => $value) {
            $url = \str_replace('{' . $template. '}', \trim($value, '&/'), $url);
        }

        return $url;
    }

    /**
     * @param array $queryParams
     *
     * @return string
     */
    protected function prepareQueryParams(array $queryParams)
    {
        $preparedParams = [];

        foreach ($queryParams as $paramName => $paramValue) {
            if (\in_array($paramValue, [null, ''], true)) {
                continue;
            }
            $preparedParams[$paramName] = $paramValue;
        }

        return \http_build_query($preparedParams);
    }

    /**
     * @param Response $response
     *
     * @return ApiResponse
     * @throws SDKException
     */
    protected function parseResponse(Response $response)
    {
        $statusCode = $response->getStatusCode();

        if ($statusCode >= 400) {
            $responseContent = $response->getContent();

            $message = \is_array($responseContent) && isset($responseContent['message'])
                ? $responseContent['message']
                : 'Undefined error';

            switch ($statusCode) {
                case 400:
                    throw new InvalidArgumentException($message);
                case 401:
                case 403:
                    throw new AccessDeniedException($message);
                case 404:
                    throw new NotFoundException($message);
                default:
                    throw new SDKException($message);
            }
        }

        return ApiResponseFactory::createFromResponse($response);
    }
}
