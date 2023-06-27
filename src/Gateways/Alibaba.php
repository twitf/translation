<?php

declare(strict_types=1);

namespace Twitf\Translation\Gateways;

class Alibaba extends Gateway
{
    private array $cookie = [];

    public function translate(array $params = []): string
    {
        $cookie = $this->getCookie("https://translate.alibaba.com/");
        $csrfToken = $this->getCsrfToken();
        $options = [
            'cookies' => $cookie,
            'headers' => [
                $csrfToken['headerName'] => $csrfToken['token'],
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0',
                'Origin' => 'https://translate.alibaba.com',
                'Referer' => 'https://translate.alibaba.com'
            ],
            'multipart' => [
                ['name' => 'srcLang', 'contents' => $params['source_language'] ?: "auto"],
                ['name' => 'tgtLang', 'contents' => $params['target_language']],
                ['name' => 'domain', 'contents' => $params['domain'] ?: "general"],
                ['name' => 'query', 'contents' => $params['text']],
                ['name' => $csrfToken['parameterName'], 'contents' => $csrfToken['token']]
            ]
        ];
        $result = $this->request(uri: "https://translate.alibaba.com/api/translate/text", options: $options);
        return $result['data']['translateText'];
    }

    private function getCsrfToken()
    {
        $options = [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0',
            ],
        ];
        return $this->request("GET", "https://translate.alibaba.com/api/translate/csrftoken", $options);
    }
}
