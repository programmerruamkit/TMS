<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$condition2 = "";
$condition3 = "";

if ($_POST['search'] != "") {
    $condition3 = " AND a.VEHICLETYPECODE = '" . $_POST['srtype'] . "' AND (b.VEHICLETYPEDESC LIKE '%" . $_POST['search'] . "%' OR a.VEHICLEREGISNUMBER LIKE '%" . $_POST['search'] . "%') ";
} else {
    if ($_POST['srtype'] != "") {
        $condition2 = " AND a.VEHICLETYPECODE = '" . $_POST['srtype'] . "'";
    }
}
$condition1 = $condition2 . $condition3;
$sql_srCar = "{call megVehicleinfo_v2(?,?)}";
$params_srCar = array(
    array('select_vehicleinfo', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);

$query_srCar = sqlsrv_query($conn, $sql_srCar, $params_srCar);
while ($result_srCar = sqlsrv_fetch_array($query_srCar, SQLSRV_FETCH_ASSOC)) {
    ?>
    <div class="col-lg-3 col-md-3">
        <div class="panel" style="background-color: #FFF;color: #000;border-color:#ccc ">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12" style="text-align: center">
                        <img src="../<?= $result_srCar['VEHICLETYPEIMAGE'] ?>" style="width: 150px;height: 75px;">
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <font style="font-size: 16px;color:#000 ">ทะเบียน : <?= $result_srCar['VEHICLEREGISNUMBER'] ?></font>
                <span class="pull-right"> 
                    <a href="#" role="button" class="btn btn-default btn-circle" data-toggle="popover" title="" data-content="<a href='meg_carinfo.php?type=info&vehicleinfoid=<?= $result_srCar['VEHICLEINFOID'] ?>&meg=edit' class='list-group-item'>ข้อมูลรถ</a><br><a href='meg_carinfo.php?type=history&vehicleinfoid=<?= $result_srCar['VEHICLEINFOID'] ?>&meg=add' class='list-group-item'>ข้อมูลประวัติการเปลี่ยน</a><br><a href='meg_carinfo.php?type=insured&vehicleinfoid=<?= $result_srCar['VEHICLEINFOID'] ?>&meg=add' class='list-group-item'>ข้อมูลประกันภัย</a><br><a href='meg_carinfo.php?type=maintenance&vehicleinfoid=<?= $result_srCar['VEHICLEINFOID'] ?>&meg=add' class='list-group-item'>ข้อมูลซ่อมบำรุง</a><br><a href='meg_carinfo.php?type=repair&vehicleinfoid=<?= $result_srCar['VEHICLEINFOID'] ?>&meg=add' class='list-group-item'>ข้อมูลซ่อมแซม</a><br><a href='meg_carinfo.php?type=tax&vehicleinfoid=<?= $result_srCar['VEHICLEINFOID'] ?>&meg=add' class='list-group-item'>ข้อมูลภาษี</a><br><a href='meg_carinfo.php?type=owner&vehicleinfoid=<?= $result_srCar['VEHICLEINFOID'] ?>&meg=add' class='list-group-item'>ข้อมูลผู้ขับขี่</a><br><a href='meg_carinfo.php?type=purchase&vehicleinfoid=<?= $result_srCar['VEHICLEINFOID'] ?>&meg=add' class='list-group-item'>ข้อมูลการจัดซื้อ</a>"><i class="fa fa-list"></i></a>

                </span>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <?php
}
sqlsrv_close($conn);
?>