<?php

namespace Twitf\Translation\Gateways;


use Psr\Http\Message\ResponseInterface;
use Twitf\Translation\Contracts\GatewayInterface;
use Twitf\Translation\Traits\HttpTrait;

/**
 * Class Gateway.
 */
abstract class Gateway implements GatewayInterface
{
    use HttpTrait;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var ResponseInterface
     */
    public $response;

    /**
     * @var float
     */
    protected $timeout;

    /**
     * @var string
     */
    protected $uri;

    /**
     * Gateway constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }
}
