<?php
require_once("../class/meg_function.php");
error_reporting(0);
date_default_timezone_set("Asia/Bangkok");
$nowdt = date("Y-m-d"); //ดึงเวลาจาก Server ได้ในตัว

$dateCheck = $_GET['dateCheck'];
if ($dateCheck == 1) {
    $dateSelect1 = $nowdt;
    $dateSelect2 = $nowdt;
} else {
    $dateSelect1 = $_GET['Date1'];
    $dateSelect2 = $_GET['Date2'];
}

$data = select_time_data('select', $_GET['PID'], $dateSelect1, $dateSelect2);
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!-- Modal content-->
<div class="modal-body">
    <input type="hidden" id="pID" name="pID" value="<?=$_GET['PID'];?>">
    <input type="hidden" id="pName" name="pName" value="<?=$_GET['PNAME'];?>">

    <div class="panel-body">
    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
            <thead>
                <tr>
                    <td>ลำดับ</td><td>เวลา</td><td>วันที่</td><td>สถานะเข้างาน</td>
                </tr>
            </thead>
            <tbody>
                <?php echo $data;?>
            </tbody>
        </table>
    </div>
    </div>
</div>

