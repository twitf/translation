<?php

declare(strict_types=1);

namespace Twitf\Translation\Gateway;


class Alibaba implements Translation
{
    public function translate(array $config = []): string
    {
        var_dump($config);
       return "阿里翻译";
    }
}
