<?php

//ini_set('display_errors', 'on');
//ini_set('display_startup_errors', 'on');
require_once __DIR__ . '/../vendor/autoload.php';

use Twitf\Translation\Gateways\SougouGateway;
use Twitf\Translation\Translation;

try {
    $alibaba = Translation::sougou(['timeout' => 5])->translate(['query' => '你好是大数据的卡上肯定就撒娇的 ']);
    var_dump($alibaba->getDetect());
    var_dump($alibaba->getTranslation());
    die;
} catch (\Throwable $e) {
    var_dump($e->getMessage(), $e->getFile(), $e->getLine());
}