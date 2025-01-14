<?php

session_start();
session_destroy();
//header("location:../../demo/pages/index.html");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
$condition1 = " AND (a.USERNAME ='" . $_SESSION["USERNAME"] . "' AND a.PASSWORD = '" . $_SESSION["PASSWORD"] . "') AND a.ACTIVESTATUS = 1";
$sql_seLogin = "{call megRoleaccount_v2(?,?)}";
$params_seLogin = array(
    array('select_roleaccount', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seLogin = sqlsrv_query($conn, $sql_seLogin, $params_seLogin);
$result_seLogin = sqlsrv_fetch_array($query_seLogin, SQLSRV_FETCH_ASSOC);


$sql_seLogprocess = "{call megLogprocess_v2(?,?,?,?)}";
$params_seLogprocess = array(
    array('save_logprocess', SQLSRV_PARAM_IN),
    array('Logout', SQLSRV_PARAM_IN),
    array('Logout', SQLSRV_PARAM_IN),
    array($result_seLogin['PersonCode'], SQLSRV_PARAM_IN)
);
$query_seLogprocess = sqlsrv_query($conn, $sql_seLogprocess, $params_seLogprocess);
$result_seLogprocess = sqlsrv_fetch_array($query_seLogprocess, SQLSRV_FETCH_ASSOC);


header("location:meg_login.php");
?>

