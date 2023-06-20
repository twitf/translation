<?php

declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use \Twitf\Translation\Translation;

try {
    Translation::alibaba()->translate();
} catch (\Throwable $e) {
    var_dump($e->getMessage());
}
