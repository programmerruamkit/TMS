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
    $y = substr($data, 2, 2);
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

    if ($data == null) {
        $var_item = "ไม่พบวันที่";
    }

    return $var_item;
}

function cover_tostring($data) {
    return htmlspecialchars($data);
}

function this_path_url() {
    return $_SERVER['PHP_SELF'];
}

function data_encrypt($data) {
    return md5($data);
}

function data_decrypt($data, $encrypt_data) {
    $var_encrypt = md5($data);

    if ($var_encrypt == $encrypt_data) {
        return $data;
    } else {
        return 0;
    }
}

function name_equipment_code($data) {
    if ($data == "EQPC") {
        return "PC";
    } else if ($data == "EQNB") {
        return "NOTEBOOK";
    } else if ($data == "EQNW") {
        return "NETWORK";
    } else if ($data == "EQPT") {
        return "PRINTER";
    } else if ($data == "EQSW") {
        return "SOFTWARE";
    }
}

function equipment_status_name($data) {
    if ($data == 0) {
        return "ยังไม่ได้ใช้งาน";
    } else if ($data == 1) {
        return "ใช้งาน";
    } else if ($data == 2) {
        return "ซ่อม/รอซ่อม";
    } else if ($data == 3) {
        return "สำรอง";
    } else if ($data == 4) {
        return "เสีย/จำหน่าย/ยกเลิกใช้งาน";
    } else {
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
    } else {
        return "ไม่ทราบ";
    }
}

function work_status_name($data) {
    if ($data == 0) {
        return "กำลังดำเนินการ";
    } else if ($data == 1) {
        return "ดำเนินการเรียบร้อยแล้ว";
    } else if ($data == 2) {
        return "เสีย/ยกเลิก";
    } else if ($data == 3) {
        return "ซ่อม/รออะไหล่";
    } else {
        return "ไม่ทราบ";
    }
}

function mail_trigger($from, $to, $type, $text, $title) {
    $mail = new PHPMailer(true);
    $mail->IsHTML(true);
    $mail->IsSMTP();
    $mail->CharSet = "utf-8";
    $mail->SMTPAuth = true; // enable SMTP authentication
    $mail->SMTPSecure = ""; // sets the prefix to the servier
    $mail->Host = "mail.ruamkit.co.th"; // sets GMAIL as the SMTP server
    $mail->Port = 25; // set the SMTP port for the GMAIL server
    $mail->Username = "niti_it@ruamkit.co.th"; // GMAIL username
    $mail->Password = "Ruamkit@1993"; // GMAIL password
    $mail->From = $from; // "name@yourdomain.com";
    //$mail->AddReplyTo = "support@ruamkit.co.th"; // Reply
    $mail->FromName = "ระบบแจ้งเตือนคำร้อง";  // set from Name
    $mail->Subject = "คำร้อง " . $title;
    $mail->Body = $text;
    
    if($to != ''){
        $mail->AddAddress($to, $type); // to Address
    }
    
    //$mail->AddAddress("niti_it@ruamkit.co.th", "Programmer"); // to Address
    $mail->AddAddress("pornthep@ruamkit.co.th", "Admin Manager IT"); // to Address
    $mail->AddAddress("piriya_it@ruamkit.co.th", "IT"); // to Address

    $mail->Send();
}

function day_of_mount($mm, $yy) {
    $num_day = cal_days_in_month(CAL_GREGORIAN, $mm, $yy);
    return $num_day;
}

?>