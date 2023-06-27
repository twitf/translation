<?php

declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use \Twitf\Translation\Translation;

try {
    $text = "Description:
3mm Neoprene Socks: Soft diving scuba surfing swimming socks water sports snorkeling boots, durable and stretchy.
Low Cut Design: Keep warm, nonslip, elastic, and comfortable to wear, and protect your feet from cut, punctures, scratches, and cold water, Can wear with flippers alone
Feature: stitched seams lay flat on the skin, flat seams fit your ankle, preventing sand or other small things coming in.
Diving Accessories: Perfect water sport accessory for protecting your feet from scratch and prick.
Widely Used: Perfect for water sports,beach activities,such as beach volleyball, beach football, snorkeling,scuba diving,swimming,boating, beach, water sports etc.
Specification:
Material: Neoprene
Color: Black
Size Chart:
XS: 35-37
S: 38-39
M: 40-41
L: 42-43
XL: 43-45
Package Includes:
1 Pair Diving Socks
Note:
1. Due to the light and screen difference, the item\\\'s color may be slightly different from the pictures.
2. Please allow 1-3mm differences due to manual measurement.";
    $res=Translation::alibaba()->translate(['target_language' => 'zh', 'text' => $text]);
    var_dump($res);
    $res = Translation::volcengine()->translate(['target_language' => 'zh', 'text' =>$text]);
    var_dump($res);
} catch (\Throwable $e) {
    var_dump($e->getMessage());
}
