<?php

session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("class/meg_function.php");
$conn = connect("RTMS");

try {
    if ($_POST['txt_flg'] == "del_drivingadmin") {
    $rs = insDrivingadmin(
                'del_drivingadmin', $_POST['ID']);
        switch ($rs) {
            case 'complete': {
                    echo "บันทึกข้อมูลเรียบร้อย...";
                }
                break;
            case 'error': {
                    echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล !!!";
                }
                break;
            default : {
                    echo $rs;
                }
                break;
        }  
    }
    if ($_POST['txt_flg'] == "save_drivingadmin") {
    $rs = insDrivingadmin(
                'save_drivingadmin', $_POST['ID'],$_POST['fieldname'], $_POST['editableObj']);
        switch ($rs) {
            case 'complete': {
                    echo "บันทึกข้อมูลเรียบร้อย...";
                }
                break;
            case 'error': {
                    echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล !!!";
                }
                break;
            default : {
                    echo $rs;
                }
                break;
        }  
    }
        
    if ($_POST['txt_flg'] == "save_driverregister") {
        $rs = insDriverregister('save_driverregister', $_POST['condition1'], $_POST['driverregister_fname'], $_POST['driverregister_lname'],$_POST['driverregister_age'], $_POST['driverregister_education'], $_POST['driverregister_position'], $_POST['driverregister_email'], $_POST['driverregister_tel'], $_POST['driverregister_company'], $_POST['driverregister_businesstype'], $_POST['driverregister_businesstypetext'], $_POST['driverregister_history'], $_POST['driverregister_historytext'], $_POST['activestatus'], $_POST['remark']);
        switch ($rs) {
            case 'complete': {
                    echo "บันทึกข้อมูลเรียบร้อย...";
                }
                break;
            case 'error': {
                    echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล !!!";
                }
                break;
            default : {
                    echo $rs;
                }
                break;
        }
    }
} catch (Exception $ex) {
    echo $rs;
}

sqlsrv_close($conn);
?>