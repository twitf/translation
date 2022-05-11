<?php

namespace Twitf\Translation;

use Exception;
use Twitf\Translation\Contracts\GatewayInterface;
use Twitf\Translation\Gateways\AlibabaGateway;
use Twitf\Translation\Gateways\SougouGateway;

/**
 * @method static AlibabaGateway alibaba(array $config) Alibaba Translation
 * @method static SougouGateway sougou(array $config) Sougou Translation
 */
class Translation
{
    /**
     * @param string $name
     * @param array  $config
     *
     * @throws Exception
     * @return mixed
     */
    public static function make(string $name = "", array $config = [])
    {
        $name = \ucfirst(\str_replace(['-', '_', ''], '', $name));

        $gateway = __NAMESPACE__ . "\\Gateways\\{$name}Gateway";

        if (!\class_exists($gateway) || !\in_array(GatewayInterface::class, \class_implements($gateway))) {
            throw new Exception(\sprintf('Class "%s" is a invalid gateway.', $gateway));
        }

        return new $gateway($config);
    }

    /**
     * Dynamically pass methods to the Gateway.
     *
     * @param $name
     * @param $arguments
     *
     * @throws Exception
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
        return self::make($name, ...$arguments);
    }
}