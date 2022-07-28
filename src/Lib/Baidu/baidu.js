function a(r) {
    if (Array.isArray(r)) {
        for (var o = 0, t = Array(r.length); o < r.length; o++) t[o] = r[o];
        return t
    }
    return Array.from(r)
}

function n(r, o) {
    for (var t = 0; t < o.length - 2; t += 3) {
        var a = o.charAt(t + 2);
        a = a >= "a" ? a.charCodeAt(0) - 87 : Number(a), a = "+" === o.charAt(t + 1) ? r >>> a : r << a, r = "+" === o.charAt(t) ? r + a & 4294967295 : r ^ a
    }
    return r
}
function e(text, value) {
    /** @type {string} */
    var strDate = value;
    var filem = strDate.split(".");
    /** @type {number} */
    var minDate = Number(filem[0]) || 0;
    /** @type {number} */
    var size_buffer = Number(filem[1]) || 0;
    /** @type {!Array} */
    var temp = [];
    /** @type {number} */
    var tpt = 0;
    /** @type {number} */
    var i = 0;
    for (; i < text.length; i++) {
        var p0 = text.charCodeAt(i);
        if (128 > p0) {
            temp[tpt++] = p0;
        } else {
            if (2048 > p0) {
                /** @type {number} */
                temp[tpt++] = p0 >> 6 | 192;
            } else {
                if (55296 === (64512 & p0) && i + 1 < text.length && 56320 === (64512 & text.charCodeAt(i + 1))) {
                    /** @type {number} */
                    p0 = 65536 + ((1023 & p0) << 10) + (1023 & text.charCodeAt(++i));
                    /** @type {number} */
                    temp[tpt++] = p0 >> 18 | 240;
                    /** @type {number} */
                    temp[tpt++] = p0 >> 12 & 63 | 128;
                } else {
                    /** @type {number} */
                    temp[tpt++] = p0 >> 12 | 224;
                }
                /** @type {number} */
                temp[tpt++] = p0 >> 6 & 63 | 128;
            }
            /** @type {number} */
            temp[tpt++] = 63 & p0 | 128;
        }
    }
    console.log(temp);
    /** @type {number} */
    var t = minDate;
    /** @type {string} */
    var message = "" + String.fromCharCode(43) + String.fromCharCode(45) + String.fromCharCode(97) + ("" + String.fromCharCode(94) + String.fromCharCode(43) + String.fromCharCode(54));
    /** @type {string} */
    var o = "" + String.fromCharCode(43) + String.fromCharCode(45) + String.fromCharCode(51) + ("" + String.fromCharCode(94) + String.fromCharCode(43) + String.fromCharCode(98)) + ("" + String.fromCharCode(43) + String.fromCharCode(45) + String.fromCharCode(102));
    console.log(t,message,o)
    /** @type {number} */
    var b = 0;
    for (; b < temp.length; b++) {
        t = t + temp[b];
        t = n(t, message);
    }
    console.log(t,"TTTT1")
    return t = n(t, o),console.log(t,"TTTT2"), t = t ^ size_buffer, 0 > t && (t = (2147483647 & t) + 2147483648), t = t % 1e6, t.toString() + "." + (t ^ minDate);
}

console.log(e("你好A哈B,哈的", "320305.131321201"))