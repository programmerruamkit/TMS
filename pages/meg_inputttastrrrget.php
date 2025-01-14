<!DOCTYPE html>
<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

if ($_GET['dateinput'] == '') {
    echo "dateinput is null";
} else if ($_GET['employeecode'] == '') {
    echo "employeecode is null";
} else if ($_GET['vehiclenumber'] == '') {
    echo "vehiclenumber is null";
} else if ($_GET['vehicletype'] == '') {
    echo "vehicletype is null";
} else if ($_GET['jobstart'] == '') {
    echo "jobstart is null";
} else if ($_GET['jobend'] == '') {
    echo "jobend is null";
} else if ($_GET['zone'] == '') {
    echo "zone is null";
} else if ($_GET['documentnumber'] == '') {
    echo "documentnumber is null";
} else if ($_GET['weightin'] == '') {
    echo "weightin is null";
} else {
    $rs = insInputttastrrr('save_inputrkrttast', '', '', '', $_GET['dateinput'], $_GET['employeecode'], $_GET['vehiclenumber'], $_GET['vehicletype'], $_GET['jobstart'], $_GET['jobend'], $_GET['zone'], $_GET['documentnumber'], $_GET['weightin'], $_GET['remark'], 'get');
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