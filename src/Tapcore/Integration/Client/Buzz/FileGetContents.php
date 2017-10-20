<?php

namespace Tapcore\Integration\Client\Buzz;

use Buzz\Client\FileGetContents as BaseFileGetContents;
use Buzz\Message\RequestInterface;

class FileGetContents extends BaseFileGetContents
{
    public function __construct($timeout = 60)
    {
        $this->setTimeout($timeout);
    }

    /**
     * @inheritdoc
     */
    public function getStreamContextArray(RequestInterface $request)
    {
        $content = $request->getContent();
        $headers = $request->getHeaders();

        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Length: ' . \strlen($content);
        $headers[] = 'Connection: close';

        $options = array(
            'http' => array(
                // values from the request
                'method'           => $request->getMethod(),
                'header'           => implode("\r\n", $headers),
                'content'          => $content,
                'protocol_version' => $request->getProtocolVersion(),

                // values from the current client
                'ignore_errors'    => $this->getIgnoreErrors(),
                'follow_location'  => $this->getMaxRedirects() > 0,
                'max_redirects'    => $this->getMaxRedirects() + 1,
                'timeout'          => $this->getTimeout(),
            ),
            'ssl' => array(
                'verify_peer'      => $this->getVerifyPeer(),
                'verify_host'      => $this->getVerifyHost(),
            ),
        );

        if ($this->proxy) {
            $options['http']['proxy'] = $this->proxy;
            $options['http']['request_fulluri'] = true;
        }

        return $options;
    }
}
