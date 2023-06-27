<?php

declare(strict_types=1);

namespace Twitf\Translation\Gateways;

use Twitf\Translation\Utils\RequestTrait;

abstract class Gateway implements Translation
{
    use RequestTrait;
}
