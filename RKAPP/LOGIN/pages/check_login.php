<?php

$page_title = "Login";
require_once '../../application.php';

if ($_SESSION['LOGIN_STATUS'] == '') {
    $id = $_POST['idlogin'];
    $pass = $_POST['passlogin'];
    $var_condition = "WHERE STATUS_USE = 1 AND L_USERNAME = '$id' AND L_PASSWORD = '$pass'";
    $para = set_stored_para('select', $rki->tblogin, '*', $var_condition);
    $qry = db_query_stored($rki->conn, $rki->stmanagement, $para);

    if ($bag = sqlsrv_fetch_object($qry)) {
        if ($bag->L_STATUS == 0) {
            $para = set_stored_para('update', $rki->tblogin, 'L_STATUS = 1', "L_ID = $bag->L_ID");
            if (db_query_stored($rki->conn, $rki->sto, $para)) {
                $_SESSION['LOGIN_STATUS'] = "true";
                $_SESSION['LOGIN_ID'] = $bag->L_ID;
                $_SESSION['PERSON_ID'] = $bag->P_ID;
                $_SESSION['LEVEL'] = $bag->L_LEVEL;
                $_SESSION['POSITION_TYPE'] = $bag->POSITION_TYPE;
                $_SESSION['TIME_TO_LOGIN'] = date("H:i");

                if ($_SESSION['LOGIN_STATUS'] == "true") {
                    $condition = "WHERE P_ID = " . $bag->P_ID;
                    $item = select_once_data($rki->conn, $rki->stmanagement, $rki->tbperson, 'P_FNAME', $condition);
                    $_SESSION['PERSON_NAME'] = $item;
                    $item = select_once_data($rki->conn, $rki->stmanagement, $rki->tbperson, 'P_LNAME', $condition);
                    $_SESSION['PERSON_LNAME'] = $item;
                    echo '<script type="text/javascript">window.alert("ยินดีต้อนรับ คุณ ' . $_SESSION['PERSON_NAME']." ".$_SESSION['PERSON_LNAME']. '");</script>';
                    header("refresh: 0; url=" . $_SESSION['PAGE_LINK']);
                    exit(0);
                }
            }
        } else {
            echo '<script type="text/javascript">window.alert("USERNAME นี้ กำลังใช้งานอยู่ ต้องการออกจากระบบหรือไม่");</script>';
            include_once 'form_set_logout.php';
        }
    } else {
        echo '<script type="text/javascript">window.alert("Username หรือ Password ผิดพลาด");</script>';
        header("refresh: 0; url=/RKAPP/LOGIN");
        exit(0);
    }
} else {
    header("refresh: 0; url=/RKAPP/LOGIN/pages/logout.php");
    exit(0);
}
?>