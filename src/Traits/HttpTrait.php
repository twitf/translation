<?php

namespace Twitf\Translation\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

trait HttpTrait
{
    /**
     * Get a Guzzle Client
     *
     * @param array $options
     *
     * @return Client
     */
    protected function getClient(array $options = []): Client
    {
        return new Client($options);
    }

    /**
     * Send the request
     *
     * @param string $method
     * @param string $uri
     * @param array  $options
     * @param array  $config
     *
     * @throws GuzzleException
     * @return ResponseInterface
     */
    public function request(string $method = "", string $uri = "", array $options = [], array $config = []
    ): ResponseInterface {
        return $this->getClient($config)->request($method, $uri, $options);
    }

    /**
     * Convert response contents to array.
     *
     * @param ResponseInterface $response
     *
     * @return array|string
     */
    protected function formatResponse(ResponseInterface $response)
    {
        $contentType = $response->getHeaderLine('Content-Type');
        $contents    = $response->getBody()->getContents();
        if (stripos($contentType, 'json') !== false) {
            return json_decode($contents, true);
        }
        if (stripos($contentType, 'xml') !== false) {
            return json_decode(json_encode(simplexml_load_string($contents)), true);
        }
        return $contents;
    }
}