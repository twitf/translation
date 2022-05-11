<?php

namespace Twitf\Translation\Gateways;

use GuzzleHttp\Exception\GuzzleException;
use Twitf\Translation\Contracts\GatewayInterface;
use GuzzleHttp\HandlerStack;

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
//client: "pc"
//exchange: false
//fr: "browser_pc_medical"
//from: "auto"
//needQc: 1
//s: "8c7c4644dce0b3af8b180512ab94207d"
//text: "你"
//to: "en"
//uuid: "54554eab-a0d7-4b4c-91d6-9f2efb8f0945"
//
//
//                                            "from": m,
//                                        "to": h,
//                                        "text": p,
//                                        "client": "pc",
//                                        "fr": I,
//                                        "needQc": v,
//                                        "s": D,
//                                        "uuid": E,
//                                        "exchange": S
//
//D = K.a.cal("".concat(m).concat(h).concat(p).concat(k)),
        $options = [
            'headers' => [
                'user-agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.54 Safari/537.36',
            ],
            'json' => [
                "from" => "auto",
                "to" => "en",
                "text" => $params['query'],
                "client" => "pc",
                "fr" => "browser_pc_medical",
                "needQc" => "",
                "s" => "",
                "uuid" => "",
                "exchange" => "false"
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
    private function getInitialState(): array
    {
        $content= $this->formatResponse($this->request('GET', $this->uri));
//        SecretCode
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