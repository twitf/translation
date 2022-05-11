<?php

namespace Twitf\Translation\Contracts;

use GuzzleHttp\HandlerStack;
use Overtrue\EasySms\Support\Config;

/**
 * Class GatewayInterface.
 */
interface GatewayInterface
{
    /**
     * Get gateway name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Translate a text
     *
     * @param array $params
     */
    public function translate(array $params = []);
}
