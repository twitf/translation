<?php
ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');
require_once __DIR__ . '/../vendor/autoload.php';



//
// $str = file_get_contents(__DIR__ ."/bing.html");
// preg_match('/(?<=params_RichTranslateHelper = )[^;]+/', $str, $arr);
// $a=json_decode($arr[0],true);
// var_dump($a);die;

// $str = file_get_contents(__DIR__ ."/bing.html");
// preg_match('/(?<=<div id="rich_tta" data-iid=")[^">]+/', $str, $arr);
// var_dump($arr);die;


// $js=<<<JS
// {
//     Region: "CN",
//     Lang: "zh-CN",
//     ST: (typeof si_ST !== 'undefined' ? si_ST : new Date),
//     Mkt: "zh-CN",
//     RevIpCC: "hk",
//     RTL: false,
//     Ver: "21",
//     IG: "2B78166189AF4ADD8D41EF203986A8D2",
//     EventID: "BD8E6449937C48D9A6A292B3E14E1F5C",
//     V: "translator",
//     P: "translator",
//     DA: "PUSE01",
//     SUIH: "8ML9D6n6VDRFfI2u7DEOog",
//     adc: "b_ad",
//     EF: {
//         cookss: 1,
//         bmcov: 1,
//         crossdomainfix: 1,
//         bmasynctrigger: 1,
//         chevroncheckmousemove: 1
//     },
//     gpUrl: "\/fd\/ls\/GLinkPing.aspx?"
// }
// JS;
//  preg_match('/(?<=IG: ")[^",]+/', $js, $arr);
// var_dump($arr);die;

$sougou = \Twitf\Translation\Translation::bing()->translate(['target' => "en", 'query' => "你真是个人才啊"]);
var_dump($sougou->getDetect());
var_dump($sougou->getTranslation());
die;