<?php

declare(strict_types=1);

namespace Twitf\Translation\Gateways;

class Volcengine extends Gateway
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
        $options = [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'source_language' => $params['source_language'] ?: "detect",
                'target_language' => $params['target_language'],
                'text' => $params['text']
            ]
        ];
        $uri = 'https://translate.volcengine.com/crx/translate/v1';
        $result = $this->request('POST', $uri, $options);
        return $result['translation'];
    }
}
