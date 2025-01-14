$(document).ready(function () {
    $('#table_display').DataTable({
        responsive: true
    });
});

function conf_send_data(selection) {
    var r;
    if (selection == 'update') {
        r = confirm("คุณต้องการ แก้ไข ข้อมูล ใช่หรือไม่?");
    } else if (selection == 'del') {
        r = confirm("คุณต้องการ ลบ ข้อมูล ใช่หรือไม่?");
    } else {
        r = confirm("คุณต้องการ บันทึก ข้อมูล ใช่หรือไม่?");
    }
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

function display_change(display, type, data, page) {
    var xhttp = new XMLHttpRequest();
    pages = "";
    if (data != '') {
        pages = page + "?data=" + data + "&type=" + type;
        xhttp.open("GET", pages, false);
        xhttp.send();
        document.getElementById(display).innerHTML = xhttp.responseText;
    }
}

function search_data(display, selection, type, data, page) {
    var xhttp = new XMLHttpRequest();
    pages = "";
    if (selection == 'select') {

    } else {
        if (type == '') {
            type = '%'
        } else {
            type = '%' + type + '%'
        }
        if (data == '') {
            data = '%'
        } else {
            data = '%' + data + '%'
        }
    }

    if (pages = page + "?name=" + data + "&type=" + type + "&selection=" + selection) {
        xhttp.open("GET", pages, false);
        xhttp.send();
        document.getElementById(display).innerHTML = xhttp.responseText;
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

function to_upper_str(id, data) {
    document.getElementById(id).value = data.toUpperCase();
}

function set_ekey(tkey) {
    document.getElementById("ecode").value = "RK-" + tkey;
}

function set_okey(tkey, date) {
    document.getElementById("ocode").value = "O-" + tkey + "-" + date + "-";
}
