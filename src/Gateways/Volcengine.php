<?php

declare(strict_types=1);

namespace Twitf\Translation\Gateways;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;


class Volcengine implements Translation
{
    /**
     *
     *
     * @param array $params
     * @return string
     * @throws GuzzleException
     * @author  史强 <qshi@suntekcorps.com>
     * @date    2023/6/21 13:43
     */
    public function translate(array $params = []): string
    {
        $client  = new Client();
        $options = [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'source_language' => $params['source_language'] ?: "detect",
                'target_language' => $params['target_language'],
                'text' => $params['text']
            ]
        ];
        $uri     = 'https://translate.volcengine.com/crx/translate/v1';
        $res     = $client->request('POST', $uri, $options);
        $result  = json_decode($res->getBody()->getContents(), true);
        return $result['translation'];
    }
}
