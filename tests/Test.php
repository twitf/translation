<?php

declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use \Twitf\Translation\Translation;

try {
    $res=Translation::alibaba()->translate(['target_language' => 'zh', 'text' => "how old are you"]);
    var_dump($res);
    $res = Translation::volcengine()->translate(['target_language' => 'zh', 'text' => "how old are you"]);
    var_dump($res);
} catch (\Throwable $e) {
    var_dump($e->getMessage());
}
