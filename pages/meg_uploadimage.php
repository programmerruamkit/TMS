<?php

$vehicletransportplanid = $_POST['vehicletransportplanid'];
$employeecode1 = $_POST['employeecode1'];
$employeecode2 = $_POST['employeecode2'];
$file = $_FILES['pix'];
$place2place = "../upload_imagemap";

if ($employeecode1 != "") {

    if (@copy($file[tmp_name], "$place2place/" . $vehicletransportplanid . $employeecode1.".jpg")) {
        header("Location: meg_tenkodocument.php?vehicletransportplanid=$vehicletransportplanid&employeecode1=$employeecode1");
    } else {
        echo "เกิดข้อผิดพลาด";
    }
} else {

    if (@copy($file[tmp_name], "$place2place/" . $vehicletransportplanid . $employeecode2)) {
        header("Location: meg_tenkodocument.php?vehicletransportplanid=$vehicletransportplanid&employeecode2=$employeecode2");
    } else {
        echo "เกิดข้อผิดพลาด";
    }
}
?>