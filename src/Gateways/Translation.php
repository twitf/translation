<?php

declare(strict_types=1);

namespace Twitf\Translation\Gateways;

interface Translation
{
    public function translate(): string;
}
