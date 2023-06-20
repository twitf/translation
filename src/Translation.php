<?php

declare(strict_types=1);

namespace Twitf\Translation;

/**
 * @method static \Twitf\Translation\Gateway\Alibaba alibaba(array $config = [])
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
        $value       = str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $name)));
        $application = __NAMESPACE__ . '\\Gateway\\' . $value;
        if (!class_exists($application)) {
            throw new \Exception(sprintf("Class '%s' does not exist.", $application));
        }
        return new $application($config);
    }

    /**
     * Dynamically pass methods to the application.
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
