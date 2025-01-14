function conf_send_data() {
    var r;
    r = confirm("คุณต้องการ ทำรายการนี้ ใช่หรือไม่?");
    if (r == true) {
        return true;
    } else {
        return false;
    }
}

function conf_logout() {
    var r = confirm("ต้องการออกจากระบบ \n ใช่ หรือ ไม่");
    if (r == true) {
        return true;
    } else {
        return false;
    }
}

function auto_format(data, selection) {
    if (selection = "id") {
        var pattern = new String("_-____-_____-_-__");
        var pattern_ex = new String("-");
    } else if (selection = "tel") {
        var pattern = new String("__-____-____");
        var pattern_ex = new String("-");
    }
    var returnText = new String("");
    var data_len = data.value.length;
    var obj_len = data_len - 1;
    for (i = 0; i < pattern.length; i++) {
        if (obj_len == i && pattern.charAt(i + 1) == pattern_ex) {
            returnText += data.value + pattern_ex;
            data.value = returnText;
        }
    }
    if (data_len >= pattern.length) {
        data.value = data.value.substr(0, pattern.length);
    }
}

function str_upper(id, data) {
    document.getElementById(id).value = data.toUpperCase();
}
