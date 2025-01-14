<?php

$page_title = "Logout";
require_once '../../application.php';

$id = '';

if ($_SESSION['LOGIN_STATUS'] == 'true') {
    $id = $_SESSION['PERSON_ID'];
    logout_set($rki->conn, $rki->tblogin, $rki->stmanagement, $id);
}
if ($_SESSION['LOGIN_STATUS'] == '') {
    $id = $_POST['pid'];
    if ($id != '') {
        logout_set($rki->conn, $rki->tblogin, $rki->stmanagement, $id);
    } else {
        echo '<script type="text/javascript">window.alert("ผิดพลาด!! '.$id.'");</script>';
        header("refresh: 0; url=/RKAPP/LOGIN/");
        exit(0);
    }
}

function logout_set($conn, $table, $sto, $id) {
    $para = set_stored_para('update', $table, "L_STATUS = 0", "P_ID = $id");
    $qry = db_query_stored($conn, $sto, $para);
    
    if ($qry != '') {
        $_SESSION['LOGIN_STATUS'] = "";
        $_SESSION['LOGIN_ID'] = "";
        $_SESSION['PERSON_ID'] = "";
        $_SESSION['LEVEL'] = "";
        $_SESSION['PERSON_NAME'] = "";
        $_SESSION['PERSON_LNAME'] = "";
        $_SESSION['TIME_TO_LOGIN'] = "";
        
        session_destroy();
        
        echo '<script type="text/javascript">window.alert("ออกจากระบบ เรียบร้อยแล้ว");</script>';
        header("refresh: 1; url=/RKAPP/LOGIN/");
        exit(0);
    }
}
?>



