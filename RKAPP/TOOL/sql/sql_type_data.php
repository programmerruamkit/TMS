<?php

$page_title = "BACK OFFICE";

if (require_once '../../application.php') {
    if ($_SESSION['LEVEL'] == 9) {
        $t_id = $_POST['type_id'];
        $code = strtoupper($_POST['type_code']);
        $name = $_POST['type_name'];
        $addby = $_SESSION['PERSON_NAME'];

        $value = "T_CODE";
        $condition = "WHERE T_CODE = '$code'";

        if ($_POST['selection'] == 'insert') {
            if (re_check_data($rki->conn, $rki->stmanagement, $rki->tbtype, $value, $condition) == false) {
                $value = "'$code', '$name', '$addby'";
                $condition = "[T_CODE], [T_NAME], [ADD_BY]";
                $para = set_stored_para('insert', $rki->tbtype, $value, $condition);
                if (db_query_stored($rki->conn, $rki->stmanagement, $para)) {
                    echo '<script type="text/javascript">window.alert("เพิ่มข้อมูล \nCODE : ' . strtoupper($_POST['type_code']) . '\n NAME : ' . $_POST['type_name'] . '\nแล้ว!!");</script>';
                } else {
                    echo '<script type="text/javascript">window.alert("ไม่สามารถเพิ่มข้อมูลได้!!!");</script>';
                }
                header("refresh: 0; url=/RKAPP/BACKOFFICE/TYPE/edit_type_data.php");
                exit(0);
            } else {
                echo '<script type="text/javascript">window.alert("มี CODE : ' . strtoupper($_POST['type_code']) . ' ในระบบแล้ว!!!");</script>';
                header("refresh: 0; url=/RKAPP/BACKOFFICE/TYPE/edit_type_data.php");
                exit(0);
            }
        } else if ($_POST['selection'] == 'update') {
            if (re_check_data($rki->conn, $rki->stmanagement, $rki->tbtype, $value, $condition) == true) {
                $value = "SET T_CODE = '$code', T_NAME = '$name', ADD_BY = '$addby'";
                $condition = "T_ID = $t_id";
                $para = set_stored_para('update', $rki->tbtype, $value, $condition);
                if (db_query_stored($rki->conn, $rki->stmanagement, $para)) {
                    echo '<script type="text/javascript">window.alert("แก้ไขข้อมูล \nCODE : ' . strtoupper($_POST['type_code']) . '\n NAME : ' . $_POST['type_name'] . '\nแล้ว!!");</script>';
                } else {
                    echo '<script type="text/javascript">window.alert("ไม่สามารถแก้ไขข้อมูล \nCODE : ' . strtoupper($_POST['type_code']) . '\n NAME : ' . $_POST['type_name'] . '\nได้!!!");</script>';
                }
                header("refresh: 0; url=/RKAPP/BACKOFFICE/TYPE/edit_type_data.php");
                exit(0);
            } else {
                echo '<script type="text/javascript">window.alert("ไม่พบข้อมูล!!!");</script>';
                header("refresh: 0; url=/RKAPP/BACKOFFICE/TYPE/edit_type_data.php");
                exit(0);
            }
        } else if ($_POST['selection'] == 'del') {
            $value = "";
            $condition = "T_ID = $t_id";
            $para = set_stored_para('update', $rki->tbtype, $value, $condition);
            if (db_query_stored($rki->conn, $rki->stmanagement, $para)) {
                echo '<script type="text/javascript">window.alert("ลบข้อมูล CODE : ' . strtoupper($_POST['type_code']) . ' NAME : ' . $_POST['type_name'] . ' แล้ว!!");</script>';
                header("refresh: 0; url=/RKAPP/BACKOFFICE/TYPE/edit_type_data.php");
                exit(0);
            }
        }
    }
}
?>

