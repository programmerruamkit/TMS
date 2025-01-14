<?php

$page_title = "EQUIPMENT";

if (require_once '../../application.php') {
    $e_id = $_POST['e_id'];
    $e_type = $_POST['type_code'];
    $e_code = set_equipment_code($e_type);
    $eq_id = strtoupper($_POST['eq_id']);
    $e_name = $_POST['e_name'];
    $e_come = $_POST['e_come'];
    $e_detail = $_POST['e_detail'];
    $e_warranty = $_POST['e_warranty'];
    $warranty_end = cut_date($e_come, "y") + $e_warranty . "-" . cut_date($e_come, "m") . "-" . cut_date($e_come, "d");
    $addby = $_SESSION['PERSON_NAME'];

    if ($eq_id != '') {
        $value = "[EQ_ID]";
        $condition = "WHERE EQ_ID = '$eq_id'";
        $check = re_check_data($rki->conn, $rki->stmanagement, $rki->tbequipment, $value, $condition);
    } else {
        $check = false;
    }

    $value = "E_CODE";
    $condition = "WHERE E_CODE = '$e_code'";

    if ($_POST['selection'] == 'insert') {
        if ($_SESSION['LEVEL'] >= 2) {
            if (re_check_data($rki->conn, $rki->stmanagement, $rki->tbequipment, $value, $condition) == false && $check == false) {
                $e_code .= select_max_id($rki->conn, $rki->stmanagement, $rki->tbequipment, "[E_CODE]", "E_TYPE LIKE '$e_type%'");
                $value = "'$e_code', '$eq_id', '$e_name', '$e_type', '$e_come', '$e_detail', '$e_warranty', '$warranty_end', '$addby'";
                $condition = "[E_CODE],[EQ_ID],[E_NAME],[E_TYPE],[E_COME],[E_DETAIL],[E_WARRANTY],[E_WARRANTY_END],[ADD_BY]";
                $para = set_stored_para('insert', $rki->tbequipment, $value, $condition);

                if (db_query_stored($rki->conn, $rki->stmanagement, $para)) {
                    echo '<script type="text/javascript">window.alert("เพิ่มข้อมูล \nรหัส : ' . $e_code . '\nชื่ออุปกรณ์ : ' . $e_name . '\nแล้ว!!");</script>';
                } else {
                    echo '<script type="text/javascript">window.alert("ไม่สามารถบันทึกข้อมูลได้!!!");</script>';
                }
                header("refresh: 0; url=/RKAPP/EQU/pages/add_equipment_data.php");
                exit(0);
            } else {
                echo '<script type="text/javascript">window.alert("มีข้อมูล \nCODE : ' . $e_code . '\n NAME : ' . $e_name . '\nในระบบแล้ว!!!");</script>';
                header("refresh: 0; url=/RKAPP/EQU/pages/add_equipment_data.php");
                exit(0);
            }
        }
    } else if ($_POST['selection'] == 'update') {
        if ($_SESSION['LEVEL'] >= 3) {
            $value = "[EQ_ID] = '$eq_id', [E_NAME] = '$e_name', [E_TYPE] = '$e_type', [E_COME] = '$e_come', [E_DETAIL] = '$e_detail', [E_WARRANTY] = '$e_warranty', [E_WARRANTY_END] = '$warranty_end', [ADD_BY] = '$addby'";
            $condition = "E_ID = $e_id";
            $para = set_stored_para('update', $rki->tbequipment, $value, $condition);
            if (db_query_stored($rki->conn, $rki->stmanagement, $para)) {
                echo '<script type="text/javascript">window.alert("แก้ไขข้อมูล \nรหัสเครื่อง : ' . $eq_id . '\nชื่ออุปกรณ์ : ' . $e_name . '\nแล้ว!!");</script>';
            } else {
                echo '<script type="text/javascript">window.alert("ไม่สามารถแก้ไขข้อมูลได้!!!");</script>';
            }
            header("refresh: 0; url=/RKAPP/EQU/pages/edit_equipment_data.php");
            exit(0);
        }
    } else if ($_POST['selection'] == 'store') {
        if ($_SESSION['LEVEL'] >= 2) {
            $e_status = $_POST['e_status'];
            $location_name = $_POST['location_name'];
            $department_name = $_POST['department_name'];
            $e_remark = $_POST['e_remark'];
            $value = "[E_STATUS] = '$e_status', [E_REMARK] = '$e_remark', [LOCATION_NAME] = '$location_name', [DEPARTMENT_NAME] = '$department_name'";
            $condition = "[E_ID] = $e_id";
            $para = set_stored_para('update', $rki->tbequipment, $value, $condition);
            if (db_query_stored($rki->conn, $rki->stmanagement, $para)) {
                echo '<script type="text/javascript">window.alert("บันทึกข้อมูล เรียบร้อยแล้ว!!");</script>';
            } else {
                echo '<script type="text/javascript">window.alert("ไม่สามารถบันทึกข้อมูลได้!!!");</script>';
            }
            header("refresh: 0; url=/RKAPP/EQU/pages/store_management_equipment.php");
            exit(0);
        }
    } else if ($_POST['selection'] == 'del' || $_GET['selection'] == 'del') {
        if ($_SESSION['LEVEL'] == 9) {
            if ($_GET['data'] != '') {
                $e_id = $_GET['data'];
            }
            $value = "";
            $condition = "E_ID = $e_id";
            $para = set_stored_para('delete', $rki->tbequipment, $value, $condition);
            if (db_query_stored($rki->conn, $rki->stmanagement, $para)) {
                echo '<script type="text/javascript">window.alert("ลบข้อมูล \nรหัสเครื่อง : ' . $eq_id . '\nชื่ออุปกรณ์ : ' . $e_name . '\nแล้ว!!");</script>';
            } else {
                echo '<script type="text/javascript">window.alert("ไม่สามารถลบมูลได้!!!");</script>';
            }
            header("refresh: 0; url=/RKAPP/EQU/pages/edit_equipment_data.php");
            exit(0);
        }
    }
}
?>