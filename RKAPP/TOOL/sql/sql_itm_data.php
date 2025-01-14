<?php

$page_title = "IT MANAGEMENT";

if (require_once '../../application.php') {
    $o_id = $_POST['order_id'];
    $eq_id = $_POST['eq_id'];

    if ($_POST['selection'] == 'del') {
        $remark = $_POST['work_remark'];
        $work_by = $_SESSION['PERSON_ID'];
        $value = "'$eq_id','$o_id','$work_by','$remark','$rki->serverdate','$rki->servertime','$rki->serverdate','$rki->servertime','6','0'";
        $condition = "[EQ_ID],[ORDER_ID],[WORK_BY],[WORK_REMARK],[WORK_START_DATE],[WORK_START_TIME],[WORK_END_DATE],[WORK_END_TIME],[WORK_STATUS],[STATUS_USE]";
        $para = set_stored_para('insert', $rki->tbwork, $value, $condition);
        if (db_query_stored($rki->conn, $rki->stmanagement, $para)) {
            $value = "[STATUS_USE] = 0 , [ORDER_STATUS] = 7";
            $condition = "ORDER_ID = $o_id";
            $para = set_stored_para('update', $rki->tborder, $value, $condition);
            if (db_query_stored($rki->conn, $rki->stmanagement, $para)) {
                echo '<script type="text/javascript">window.alert("ยกเลิกข้อมูลเรียบร้อยแล้ว!!");</script>';
            } else {
                echo '<script type="text/javascript">window.alert("ไม่สามารถยกเลิกข้อมูลได้!!!");</script>';
            }
            header("refresh: 0; url=/RKAPP/ITM/pages/show_order_data.php");
            exit(0);
        } else {
            echo '<script type="text/javascript">window.alert("ข้อมูลผิดพลาด!!!");</script>';    
        }
        header("refresh: 0; url=/RKAPP/ITM/pages/show_order_data.php");
            exit(0);
    } else if ($_POST['selection'] == 'insert') {
        $work_by = $_POST['add_by'];
        $value = "'$eq_id','$o_id','$work_by','$rki->serverdate','$rki->servertime','1'";
        $condition = "[EQ_ID],[ORDER_ID],[WORK_BY],[WORK_START_DATE],[WORK_START_TIME],[WORK_STATUS]";
        $para = set_stored_para('insert', $rki->tbwork, $value, $condition);
        if (db_query_stored($rki->conn, $rki->stmanagement, $para)) {
            $value = "[ORDER_STATUS] = 1";
            $condition = "ORDER_ID = $o_id";
            $para = set_stored_para('update', $rki->tborder, $value, $condition);
            if (db_query_stored($rki->conn, $rki->stmanagement, $para)) {
                echo '<script type="text/javascript">window.alert("รับคำร้องเรียบร้อยแล้ว!!");</script>';
            } else {
                echo '<script type="text/javascript">window.alert("ไม่สามารถรับคำร้องได้!!!");</script>';
            }
            header("refresh: 0; url=/RKAPP/ITM/pages/show_order_data.php");
            exit(0);
        } else {
            echo '<script type="text/javascript">window.alert("ข้อมูลผิดพลาด!!!");</script>';
        }
        header("refresh: 0; url=/RKAPP/ITM/pages/show_order_data.php");
        exit(0);
    } else if ($_POST['selection'] == 'update') {
        $o_id = $_POST['order_id'];
        $o_st = $_POST['order_status'];
        $remark = $_POST['work_remark'];
        $value = "[WORK_REMARK] = '$remark', [WORK_END_DATE] = '$rki->serverdate', [WORK_END_TIME] = '$rki->servertime', [WORK_STATUS] = '$o_st', [STATUS_USE] = 0";
        $condition = "[ORDER_ID] = $o_id";
        $para = set_stored_para('UPDATE', $rki->tbwork, $value, $condition);
        if (db_query_stored($rki->conn, $rki->stmanagement, $para)) {
            $value = "[STATUS_USE] = 0 , [ORDER_STATUS] = $o_st";
            $condition = "ORDER_ID = $o_id";
            $para = set_stored_para('update', $rki->tborder, $value, $condition);
            if (db_query_stored($rki->conn, $rki->stmanagement, $para)) {
                echo '<script type="text/javascript">window.alert("บันทึกงานเรียบร้อยแล้ว!!");</script>';
                header("refresh: 0; url=/RKAPP/ITM/pages/show_work_data.php");
                exit(0);
            }
        }
    }
}
?>
