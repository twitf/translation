<?php

namespace Twitf\Translation\Gateways;

use GuzzleHttp\Exception\GuzzleException;

class BingGateway extends Gateway
{
    protected $uri = "https://www.bing.com/ttranslatev3";

    /**
     * Get gateway name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'bing';
    }

    /**
     * Translate a text
     *
     * @param array $params
     *
     * @throws GuzzleException
     * @return BingGateway
     */
    public function translate(array $params = []): BingGateway
    {
        $config         = $this->getConfig();
        $options        = [
            'headers'     => [
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.54 Safari/537.36',
            ],
            'query'       => [
                'isVertical' => '1',
                'IG'         => $config['IG'],
                'IID'        => $config['IID'] . ".1",
            ],
            'form_params' => [
                "fromLang" => $params['source'] ?? "auto-detect",
                "to"       => $params['target'] ?? "en",
                "text"     => $params['query'],
                "token"    => $config['token'],
                "key"      => $config['key'],
            ],
        ];
        $response       = $this->request('POST', $this->uri, $options, $this->config);
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
        return $this->response[0]['translations'][0]['text'];
    }

    /**
     * Get csrf token
     *
     * @throws GuzzleException
     * @return array
     */
    private function getConfig(): array
    {
        $config   = [];
        $response = $this->request('GET', "https://www.bing.com/translator");
        $content  = $this->formatResponse($response);
        preg_match('/(?<=params_RichTranslateHelper =)[^;]+/', $content, $matches);
        $data            = json_decode(trim($matches[0]), true);
        $config['key']   = $data[0];
        $config['token'] = $data[1];
        preg_match('/(?<=IG:")[^",]+/', $content, $matches);
        $config['IG'] = $matches[0];
        preg_match('/(?<=<div id="rich_tta" data-iid=")[^">]+/', $content, $matches);
        $config['IID'] = $matches[0];
        return $config;
    }

    /**
     * Get Detect Language
     *
     * @return mixed
     */
    public function getDetect()
    {
        return $this->response[0]['detectedLanguage']['language'];
    }
}