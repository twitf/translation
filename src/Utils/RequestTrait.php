<?php

declare(strict_types=1);

namespace Twitf\Translation\Utils;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

trait RequestTrait
{
    public function request(string $method = "POST", string $uri = "", array $options = [])
    {
        $client = new Client();
        $response = $client->request($method, $uri, $options);
        if ($response->getStatusCode() != 200) {
            throw new \Exception($response->getBody()->getContents(), $response->getStatusCode());
        }
        $content = $response->getBody()->getContents();
        return json_decode($content, true);
    }

    public function getCookie(string $uri = ""): CookieJar
    {
        // 创建 CookieJar 对象来管理 Cookie
        $cookieJar = new CookieJar();
        $this->request("GET", $uri, ['cookies' => $cookieJar]);
        return $cookieJar;
    }
}
