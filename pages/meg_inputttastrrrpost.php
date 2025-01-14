<!DOCTYPE html>
<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");


if ($_POST['dateinput'] == '') {
    echo "dateinput is null";
} else if ($_POST['employeecode'] == '') {
    echo "employeecode is null";
} else if ($_POST['vehiclenumber'] == '') {
    echo "vehiclenumber is null";
} else if ($_POST['vehicletype'] == '') {
    echo "vehicletype is null";
} else if ($_POST['jobstart'] == '') {
    echo "jobstart is null";
} else if ($_POST['jobend'] == '') {
    echo "jobend is null";
} else if ($_POST['zone'] == '') {
    echo "zone is null";
} else if ($_POST['documentnumber'] == '') {
    echo "documentnumber is null";
} else if ($_POST['weightin'] == '') {
    echo "weightin is null";
} else {
    $rs = insInputttastrrr('save_inputrkrttast', '', '', '', $_POST['dateinput'], $_POST['employeecode'], $_POST['vehiclenumber'], $_POST['vehicletype'], $_POST['jobstart'], $_POST['jobend'], $_POST['zone'], $_POST['documentnumber'], $_POST['weightin'], $_POST['remark'],'post');
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

sqlsrv_close($conn);
?>