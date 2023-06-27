<?php

declare(strict_types=1);

namespace Twitf\Translation;

/**
 * @method static \Twitf\Translation\Gateways\Alibaba alibaba(array $config = [])
 * @method static \Twitf\Translation\Gateways\Alibaba volcengine(array $config = [])
 */
class Translation
{
    /**
     * @param $name
     * @param array $config
     * @return mixed
     * @throws \Exception
     */
    public static function make($name, $config = [])
    {
        $value   = str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $name)));
        $gateway = __NAMESPACE__ . '\\Gateways\\' . $value;
        if (!class_exists($gateway)) {
            throw new \Exception(sprintf("Class '%s' does not exist.", $gateway));
        }
        return new $gateway($config);
    }

    /**
     *
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
        return self::make($name, ...$arguments);
    }
}
