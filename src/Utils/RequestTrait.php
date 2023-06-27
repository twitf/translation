<?php

declare(strict_types=1);

namespace Twitf\Translation\Utils;

use GuzzleHttp\Client;

trait RequestTrait
{
    public function request(string $method = "POST", string $uri = "", array $options = [])
    {
        $client = new Client();
        $response = $client->request($method, $uri, $options);
        if ($response->getStatusCode() != 200) {
            throw new \Exception($response->getBody()->getContents(), $response->getStatusCode());
        }
        return json_decode($response->getBody()->getContents(), true);
    }
}
