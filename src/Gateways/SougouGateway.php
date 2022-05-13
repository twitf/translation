<?php

namespace Twitf\Translation\Gateways;

use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\GuzzleException;
use Twitf\Translation\Contracts\GatewayInterface;

class SougouGateway extends Gateway
{
    protected $uri    = "https://fanyi.sogou.com/api/transpc/text/result";
    private   $cookie = [];

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
        $config = $this->getCommonConfig();
        $options = [
            'cookies' => CookieJar::fromArray($this->formatCookie(), "fanyi.souogu.com"),
            'headers' => [
                'Cookie'     => $this->formatCookie(true),
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.54 Safari/537.36',
            ],
            'json'    => [
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
        var_dump($this->response);
        return $this;
    }

    /**
     * Get Translate Text
     *
     * @return mixed
     */
    public function getTranslation()
    {
        return $this->response['data']['translate']['dit'];
    }

    /**
     * Get csrf token
     *
     * @throws GuzzleException
     * @return array
     */
    private function getCommonConfig(): array
    {
        $response     = $this->request('GET', "https://fanyi.sogou.com");
        $this->cookie = $response->getHeader('Set-Cookie');
        $content      = $this->formatResponse($response);
        preg_match('/(?<=__INITIAL_STATE__=)[^;]+/', $content, $matches);
        $initialState = json_decode($matches[0], true);
        return $initialState['common']['CONFIG'];
    }

    public function formatCookie(bool $isStr = false)
    {
        $cookieArray = [];
        $cookieStr   = [];
        foreach ($this->cookie as $cookie) {
            $tempCookie = explode(';', $cookie);
            [$key, $value] = explode('=', $tempCookie[0]);
            $cookieArray[trim($key)] = trim($value);
            $cookieStr[]             = trim($key) . '=' . trim($value);
        }
        if ($isStr) {
            $arr=[
                'SUV=1650513461987408',
                'SMYUV=1650513461988228',
                'UM_distinctid=1804a44c2e8912-0dd2c2a7686497-142e1e05-1fa400-1804a44c2ea134c',
                'SGINPUT_UPSCREEN=1652273179777',
            ];
            return 'SUV=1650513461987408; SMYUV=1650513461988228; UM_distinctid=1804a44c2e8912-0dd2c2a7686497-142e1e05-1fa400-1804a44c2ea134c; ABTEST=0|1652273178|v17; SNUID=9A6DE3117573A8CEA59423D676BFF650; SUID=EC1B9567D756A00A00000000627BB01A; wuid=1652273178588; translate.sess=eb69d232-b6a8-4ef5-bd78-e94028611e81; SGINPUT_UPSCREEN=1652273179777; IPLOC=CN6101; FUV=779fc722f54eeaff882f908311a8a699';
            return implode('; ', array_merge($arr, $cookieStr));
        }
        return $cookieArray;
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
        return $this->response['data']['detect']['detect'];
    }
}