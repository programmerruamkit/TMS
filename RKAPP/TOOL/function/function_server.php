<?php

function cut_date($data, $selection) {
    if ($selection == 'y') {
        $y = substr($data, 0, 4);
        return $y;
    } else if ($selection == 'm') {
        $m = substr($data, 5, 2);
        return $m;
    } else if ($selection == 'd') {
        $d = substr($data, 8, 2);
        return $d;
    } else {
        return 0;
    }
}

function set_format_date($data) {
    $y = substr($data, 0, 2);
    $m = substr($data, 5, 2);
    $d = substr($data, 8, 2);
    return $y . $m . $d;
}

function cover_date($data) {
    $y = substr($data, 0, 4);
    $m = substr($data, 5, 2);
    $d = substr($data, 8, 2);
    return $d . "/" . $m . "/" . $y;
}

function format_datetime($data, $selection) {
    $var_item = 0;

    if ($selection == 'date') {
        $var_item = date_format($data, "Y-m-d");
    } else if ($selection == 'time') {
        $var_item = date_format($data, "H:i:s");
    } else if ($selection == 'datetime') {
        $var_item = date_format($data, "Y-m-d H:i:s");
    }
    
    if($data == null){
        $var_item = "ไม่พบวันที่";
    }

    return $var_item;
}

function cover_string($data) {
    return htmlspecialchars($data);
}

function part_url() {
    return $_SERVER['PHP_SELF'];
}

function encrypt($data) {
    return md5($data);
}

function decrypt($data, $encrypt_data) {
    $var_encrypt = md5($data);

    if ($var_encrypt == $encrypt_data) {
        return $data;
    } else {
        return 0;
    }
}

function set_equipment_code($data) {
    if ($data == "EQPC") {
        return "RK-PC";
    } else if ($data == "EQNB") {
        return "RK-NB";
    } else if ($data == "EQNW") {
        return "RK-NW";
    } else if ($data == "EQPT") {
        return "RK-PT";
    } else if ($data == "EQSW") {
        return "RK-SW";
    }
}

function e_status_name($data) {
    if ($data == 0) {
        return "ยังไม่ได้ใช้งาน";
    } else if ($data == 1) {
        return "ใช้งาน";
    } else if ($data == 2) {
        return "ซ่อม";
    } else if ($data == 3) {
        return "สำรอง";
    } else if ($data == 4) {
        return "เสีย/จำหน่าย";
    } else if ($data == 5) {
        return "รอซ่อม/ยกเลิกใช้งาน";
    }else {
        return "ไม่ทราบ";
    }
}

function order_status_name($data) {
    if ($data == 0) {
        return "รอดำเนินการ";
    } else if ($data == 1) {
        return "กำลังดำเนินการ";
    } else if ($data == 2) {
        return "ดำเนินการเรียบร้อยแล้ว";
    } else if ($data == 3) {
        return "ไม่สามารถดำเนินงานได้";
    } else if ($data == 4) {
        return "เสีย/ซ่อม/รออะไหล่";
    } else if ($data == 5) {
        return "ยกเลิกโดยผู้แจ้ง";
    } else if ($data == 6) {
        return "ยกเลิกโดยเจ้าหน้าที่";
    }  else {
        return "ไม่ทราบ";
    }
}

function page_pagination($data_row, $row, $type){
    $var_type = "";
    if($type != ''){$var_type = "&type=".$type;}
    $page = ceil($data_row / $row);
    echo '<ul class="pagination">';
    for ($i = 1; $i <= $page; $i++) {
        $s = (($row * $i)+1) - $row;
        $e = $row * $i;
        echo '<li><a class="w3-blue-grey" href="?start='.$s.'&end='.$e.$var_type.'"</a>'.$i.'</li>';
    }
    echo '</ul>';
}
?>