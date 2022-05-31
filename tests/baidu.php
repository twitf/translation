<?php

$a = preg_replace("/[\x{0080}-\x{00FF}]+/iu", " ", "A ä B");

function charCodeAt(string $str = "", $index = 0)
{
    $char = mb_substr($str, $index, 1, 'UTF-8');
    if (mb_check_encoding($char, 'UTF-8')) {
        $ret = mb_convert_encoding($char, 'UTF-32BE', 'UTF-8');
        return hexdec(bin2hex($ret));
    } else {
        return null;
    }
}

//js里的无符号右移(>>>)
function uright($a, $n): int
{
    $c = 2147483647 >> ($n - 1);
    return $c & ($a >> $n);
}

function a($x)
{
    if (is_array($x)) {
        $y = [count($x)];
        for ($i = 0; $i < count($x); $i++) {
            $y[$i] = $x[$i];
        }
        return $y;
    }
    return (array)$x;
}

function n($a, $o)
{
    for ($s = 0; $s < mb_strlen($o) - 2; $s = $s + 3) {
        $d = substr($o, $s + 2, 1);
        /** @type {number} */
        $d = $d >= "a" ? charCodeAt($d) - 87 : intval($d);
        /** @type {number} */
        $d = "+" === substr($o, $s + 1, 1) ? uright($a, $d) : $a << $d;
        /** @type {number} */
        $a = "+" === substr($o, $s, 1) ? $a + $d & 4294967295 : $a ^ $d;
    }
    return $a;
}

function e($str, $gtk)
{
    $gtkArr = explode(".", $gtk);
    /** @type {number} */
    $l = intval($gtkArr[0]) || 0;
    /** @type {number} */
    $ent = intval($gtkArr[1]) || 0;
    /** @type {!Array} */
    $h = [];
    /** @type {number} */
    $k = 0;
    /** @type {number} */
    for ($index = 0; $index < mb_strlen($str); $index++) {
        $x = charCodeAt($str, $index);
        if (128 > $x) {
            $h[$k++] = $x;
        } else {
            if (2048 > $x) {
                /** @type {number} */
                $h[$k++] = $x >> 6 | 192;
            } else {
                if (
                    55296 === (64512 & $x) &&
                    $index + 1 < mb_strlen($str) &&
                    56320 === (64512 & charCodeAt($str, $index + 1))
                ) {
                    /** @type {number} */
                    $x = 65536 + ((1023 & $x) << 10) + (1023 & charCodeAt($str, ++$index));
                    /** @type {number} */
                    $h[$k++] = $x >> 18 | 240;
                    /** @type {number} */
                    $h[$k++] = $x >> 12 & 63 | 128;
                } else {
                    /** @type {number} */
                    $h[$k++] = $x >> 12 | 224;
                }
                /** @type {number} */
                $h[$k++] = $x >> 6 & 63 | 128;
            }
            /** @type {number} */
            $h[$k++] = 63 & $x | 128;
        }
    }
    var_dump(json_encode($h));
    /** @type {number} */
    $i = $l;
    /** @type {string} */
    $t = '+-a^+6';
    /** @type {string} */
    $o = '+-3^+b+-f';
    /** @type {number} */
    $j = 0;
    for (; $j < count($h); $j++) {
        $i = $i + $h[$j];
        $i = n($i, $t);
    }

    $i = n($i, $o);
    var_dump($i);
    $i = $i ^ $ent;
    0 > $i && ($i = (2147483647 & $i) + 2147483648);
    $i = $i % 1e6;
    return $i . "." . ($i ^ $l);
}
echo e("你好A哈B,哈的", "320305.131321201");