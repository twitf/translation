<?php

ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');
require_once __DIR__ . '/../vendor/autoload.php';
// // \Twitf\Translation\Translation::sougou()->getInitialState();
// // a = re.search(r"window\.__INITIAL_STATE__=(.*?);", r.text).group(1)
// $str = file_get_contents(__DIR__ ."/sougou.html");
// preg_match('/(?<=__INITIAL_STATE__ = )[^;]+/', $str, $arr);
// $a=json_decode($arr[0],true);
// var_dump($a['common']['CONFIG']);


$sougou = \Twitf\Translation\Translation::sougou()->translate(['source' => 'auto', 'target' => "en", 'query' => "查词好，翻译快！"]);
var_dump($sougou->getDetect());
var_dump($sougou->getTranslation());
die;
