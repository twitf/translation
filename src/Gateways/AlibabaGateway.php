<?php

namespace Twitf\Translation\Gateways;

use GuzzleHttp\Exception\GuzzleException;
use Twitf\Translation\Contracts\GatewayInterface;
use GuzzleHttp\HandlerStack;

class AlibabaGateway extends Gateway
{
    protected $uri = "https://translate.alibaba.com/api/translate/text";
    private $csrfUri = "https://translate.alibaba.com/api/translate/csrftoken";

    /**
     * Get gateway name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'alibaba';
    }

    /**
     * Translate a text
     *
     * @param array $params
     *
     * @return AlibabaGateway
     * @throws GuzzleException
     */
    public function translate(array $params = []): AlibabaGateway
    {
        $csrf = $this->getCsrf();
        $options = [
            'headers' => [
                $csrf['headerName'] => $csrf['token'],
                'user-agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.54 Safari/537.36',
            ],
            'multipart' => [
                ['name' => 'srcLang', 'contents' => $params['source'] ?? 'auto',],
                ['name' => 'tgtLang', 'contents' => $params['target'] ?? 'en'],
                ['name' => 'domain', 'contents' => 'general'],
                ['name' => 'query', 'contents' => $params['query']],
                ['name' => $csrf['parameterName'], 'contents' => $csrf['token']],
            ],
        ];
        $response = $this->request('POST', $this->uri, $options, $this->config);
        $this->response = $this->formatResponse($response);
        return $this;
    }

    /**
     * Get Translate Text
     *
     * @return mixed
     */
    public function getTranslation()
    {
        return $this->response['data']['translateText'];
    }

    /**
     * Get csrf token
     *
     * @return array
     * @throws GuzzleException
     */
    private function getCsrf(): array
    {
        return $this->formatResponse($this->request('GET', $this->csrfUri));
    }

    /**
     * Get Detect Language
     *
     * @return mixed
     */
    public function getDetect()
    {
        return $this->response['data']['detectLanguage'];
    }
}