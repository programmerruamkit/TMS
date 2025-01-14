<?php

$page_title = "REGISTER";
if (require_once '../../application.php') {
    $person_id = $_POST['person_id'];
    $person_card = $_POST['person_card'];
    $person_fname = $_POST['person_fname'];
    $person_lname = $_POST['person_lname'];
    $user_id = $_POST['user_id'];
    $pass_id = $_POST['pass_id'];
    $level = $_POST['level'];
    $position_type = strtoupper($_POST['position_type']);
    $person_sex = $_POST['person_sex'];
    $position_id = $_POST['position_id'];
    $company_id = $_POST['company_id'];

    if ($_POST['selection'] == 'insert') {
        if (re_check_data($rki->conn, $rki->stmanagement, $rki->tbperson, "P_CODE", "WHERE P_CODE = $person_id") == false) {
            $person_value = "'$person_id','$person_fname','$person_lname','$person_sex','$level','$position_id','$company_id'";
            $person_condition = "[P_CODE],[P_FNAME],[P_LNAME],[P_SEX],[P_LEVEL],[POSITION_ID],[COMPANY_ID]";
            $para = set_stored_para('insert', $rki->tbperson, $person_value, $person_condition);
            if (db_query_stored($rki->conn, $rki->stmanagement, $para)) {
                $p_id = select_once_data($rki->conn, $rki->stmanagement, $rki->tbperson, 'P_ID', "WHERE [P_CODE] = $person_id");
                $login_value = "'$p_id','$user_id','$pass_id','$level','$position_type'";
                $login_condition = "[P_ID],[L_USERNAME],[L_PASSWORD],[L_LEVEL],[POSITION_TYPE]";
                $para = set_stored_para('insert', $rki->tblogin, $login_value, $login_condition);
                if (db_query_stored($rki->conn, $rki->stmanagement, $para)) {
                    echo '<script type="text/javascript">window.alert("จัดเก็บ ' . $person_card . ' เรียบร้อยแล้ว!!");</script>';
                } else {
                    echo '<script type="text/javascript">window.alert("ไม่สามารถบันทึกข้อมูลได้!!!");</script>';
                }
                header("refresh: 1; url=/RKAPP/LOGIN/register/add_person_data.php");
                exit(0);
            }
        } else {
            echo '<script type="text/javascript">window.alert("มี ' . $person_card . ' นี้ใระบบแล้ว!!!");</script>';
            header("refresh: 0; url=/RKAPP/LOGIN/register/add_person_data.php");
            exit(0);
        }
    }
}
?>

