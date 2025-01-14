<?php

$page_title = "IT REQUIREMENT";

if (require_once '../../application.php') {
    $eq_id = strtoupper($_POST['eq_id']);
    $o_type = $_POST['type_code'];
    $l_name = $_POST['location_name'];
    $d_name = $_POST['department_name'];
    $c_id = $_POST['c_id'];
    $o_detail = $_POST['order_detail'];
    $addby = $_SESSION['PERSON_ID'];

    if ($_POST['selection'] == 'insert') {
        if ($_SESSION['LEVEL'] >= 1) {
            $o_name = select_once_data($rki->conn, $rki->stmanagement, $rki->tbtype, 'T_NAME', "WHERE STATUS_USE = 1 AND T_CODE = '$o_type'");
            $dt = set_format_date($rki->serverdate);
            $o_code = $o_type . "-" . $dt . "-" . select_max_id($rki->conn, $rki->stmanagement, $rki->tborder, "[ORDER_CODE]", "[ORDER_CODE] LIKE '$o_type-$dt%'");
            $value = "'$o_code', '$eq_id', '$o_name', '$o_type', '$rki->serverdate', '$rki->servertime', '$l_name', '$d_name', '$c_id', '$o_detail', '0', '$addby','0'";
            $condition = "[ORDER_CODE], [EQ_ID],[ORDER_NAME],[ORDER_TYPE],[ORDER_DATE],[ORDER_TIME],[LOCATION_NAME],[DEPARTMENT_NAME],[COMPANY_ID],[ORDER_DETAIL],[ORDER_STATUS],[ADD_BY],[ORDER_CONF]";
            $para = set_stored_para('INSERT', $rki->tborder, $value, $condition);

            if (db_query_stored($rki->conn, $rki->stmanagement, $para)) {
                echo '<script type="text/javascript">window.alert("\nแจ้งซ่อมงาน : ' . $o_name . ' แล้ว!!\nกรุณารอฝ่าย IT ติดต่อกลับ");</script>';
                if ($_FILES['order_file']["name"] != '') {
                    $order_pic = $o_code."-pic.". strtolower(pathinfo($_FILES["order_file"]["name"], PATHINFO_EXTENSION));
                    $value = "[ORDER_PIC] = '$order_pic'";
                    $condition = "[ORDER_CODE] = '$o_code'";
                    $target_dir = "../../FILE/ITRORDER/";
                    $target_file = $target_dir . $order_pic;
                    if (move_uploaded_file($_FILES["order_file"]["tmp_name"], $target_file)) {
                        $para = set_stored_para('UPDATE', $rki->tborder, $value, $condition);
                        if (db_query_stored($rki->conn, $rki->stmanagement, $para)){
                            echo '<script type="text/javascript">window.alert("บันทึกไฟล์แนบแล้ว!!");</script>';
                        }
                    }
                }
            } else {
                echo '<script type="text/javascript">window.alert("ไม่สามารถบันทึกข้อมูลได้!!!");</script>';
            }
            header("refresh: 0; url=/RKAPP/ITR/pages/add_order_data.php");
            exit(0);
        }
    } else if ($_POST['selection'] == 'del') {
        $o_id = $_POST['order_id'];
        $value = "[STATUS_USE] = 0 , [ORDER_STATUS] = 5";
        $condition = "ORDER_ID = $o_id";
        $para = set_stored_para('update', $rki->tborder, $value, $condition);
        if (db_query_stored($rki->conn, $rki->stmanagement, $para)) {
            echo '<script type="text/javascript">window.alert("ยกเลิกข้อมูลเรียบร้อยแล้ว");</script>';
        } else {
            echo '<script type="text/javascript">window.alert("ไม่สามารถลบข้อมูลได้!!!");</script>';
        }
        header("refresh: 0; url=/RKAPP/ITR/pages/show_order_data.php");
        exit(0);
    }
}
?>