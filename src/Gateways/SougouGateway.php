<?php

namespace Twitf\Translation\Gateways;

use GuzzleHttp\Exception\GuzzleException;
use Twitf\Translation\Contracts\GatewayInterface;

class SougouGateway extends Gateway
{
    protected $uri = "https://fanyi.sogou.com/api/transpc/text/result";

    /**
     * Get gateway name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'sougou';
    }

    /**
     * Translate a text
     *
     * @param array $params
     *
     * @throws GuzzleException
     * @return SougouGateway
     */
    public function translate(array $params = []): SougouGateway
    {
        $config         = $this->getCommonConfig();
        $options        = [
            'headers' => [
                'User-Agent'   => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.54 Safari/537.36',
            ],
            'json' => [
                "from"     => $params['source'] ?? "auto",
                "to"       => $params['target'] ?? "en",
                "text"     => $params['query'],
                "client"   => "pc",
                "fr"       => "browser_pc",
                "needQc"   => 1,
                "s"        => $this->getSign($config, $params),
                "uuid"     => $config['uuid'],
                "exchange" => false,
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
        return $this->response;
    }

    /**
     * Get csrf token
     *
     * @throws GuzzleException
     * @return array
     */
    private function getCommonConfig(): array
    {
        $response = $this->request('GET', $this->uri);
        $content  = $this->formatResponse($response);
        preg_match('/(?<=__INITIAL_STATE__=)[^;]+/', $content, $matches);
        $initialState = json_decode($matches[0], true);
        return $initialState['common']['CONFIG'];
    }

    private function getSign(array $config = [], array $params = []): string
    {
        $reText = $params['source'] . $params['target'] . $params['query'] . $config['secretCode'];
        return md5($reText);
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