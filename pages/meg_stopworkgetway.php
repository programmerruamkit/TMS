<!DOCTYPE html>
<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
$condition1 = " AND a.EMPLOYEEID = " . $_GET['employeeid'];
?>
<html lang="en">
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>กลุ่มร่วมกิจรุ่งเรือง</title>
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
        <style>
            .navbar-default {

                border-color: #ffcb0b;
            }
            #page-wrapper {
                border-left: 1px solid #ffcb0b;
            }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

                <?php
                include '../pages/meg_header.php';
                include '../pages/meg_leftmenu.php';
                ?>
            </nav>


            <?php
            $conditionEHR2 = " AND a.PersonCode = '" . $_GET['employeeid'] . "'";
            $sql_seEHR2 = "{call megEmployeeEHR_v2(?,?)}";
            $params_seEHR2 = array(
                array('select_employee', SQLSRV_PARAM_IN),
                array($conditionEHR2, SQLSRV_PARAM_IN)
            );
            $query_seEHR2 = sqlsrv_query($conn, $sql_seEHR2, $params_seEHR2);
            $result_seEHR2 = sqlsrv_fetch_array($query_seEHR2, SQLSRV_FETCH_ASSOC);
            ?>
            <div id="page-wrapper">
                <p>&nbsp;</p>
                <form  name="saveform" id="saveform" method="post">
                    <div id="datade_edit">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <a href="meg_employeewarninggetway.php">จัดการรับแจ้ง</a> / ข้อมูลการรับแจ้ง
                                    </div>
                                    <div class="panel-body">
                                        <div class="row" >
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>กระบวนการหยุด</label>
                                                    <select  class="form-control" id="cb_stopprocess" name="cb_stopprocess">
                                                        <option value="">เลือกกระบวนการหยุด</option>
                                                        <option value="จ่ายงาน">จ่ายงาน</option>
                                                        <option value="เท็งโกะ">เท็งโกะ</option>
                                                        <option value="ขับรถ">ขับรถ</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>เหตุผล</label>
                                                    <select  class="form-control" id="cb_reason" name="cb_reason">
                                                        <option value="">เลือกเหตุผล</option>
                                                        <option value="ง่วง">ง่วง</option>
                                                        <option value="กินยา">กินยา</option>
                                                        <option value="ความดัน">ความดัน</option>
                                                        <option value="เป็นไข้">เป็นไข้</option>
                                                        <option value="ทานข้าว">ทานข้าว</option>
                                                        <option value="ซื้อของ">ซื้อของ</option>
                                                        <option value="เข้าห้องน้ำ">เข้าห้องน้ำ</option>
                                                         <option value="สูบบุหรี่">สูบบุหรี่</option>
                                                          <option value="ตรวจสอบรถ">ตรวจสอบรถ</option>
                                                          <option value="รถเสียระหว่างทาง">รถเสียระหว่างทาง</option>
                                                          <option value="ติดเวลา">ติดเวลา</option>
                                                          <option value="ตรวจสอบรถ">ตรวจสอบรถ</option>
                                                        <option value="อื่นๆ">อื่นๆ</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>จุดจอด</label>
                                                    <input class="form-control"  id="txt_parking" name="txt_parking" >
                                                </div>

                                            </div>

                                        </div>


                                        <div class="row" >
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>เลขทะเบียน</label>
                                                    <input class="form-control" type="text" id="txt_vehicleregisnumber" name="txt_vehicleregisnumber" onchange="chg_vehicleregisnumber(this.value);" onkeypress="chg_vehicleregisnumber(this.value);">

                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>เบอร์รถ/ชื่อรถ</label>
                                                    <input class="form-control"  id="txt_thainamename" name="txt_thainamename"  value="" onchange="chg_thainame(this.value)" onkeypress="chg_thainame(this.value)">

                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ประเภทรถ</label>
                                                    <select  class="form-control" id="cb_cartype" name="cb_cartype">
                                                        <option value="">เลือกประเภทรถ</option>
                                                        <?php
                                                        $sql_seVehicle = "{call megVehicletype_v2(?)}";
                                                        $params_seVehicle = array(
                                                            array('select_vehicletype', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seVehicle = sqlsrv_query($conn, $sql_seVehicle, $params_seVehicle);
                                                        while ($result_seVehicle = sqlsrv_fetch_array($query_seVehicle, SQLSRV_FETCH_ASSOC)) {
                                                            ?>

                                                            <option value="<?= $result_seVehicle['VEHICLETYPECODE'] ?>"><?= $result_seVehicle['VEHICLETYPEDESC'] ?></option>
                                                            <?php
                                                        }
                                                        ?>

                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>สถานะรถ</label>
                                                    <select  class="form-control" id="cb_carstatus" name="cb_carstatus">
                                                        <option value="">เลือกสถานะรถ</option>
                                                        <option value="-">-</option>
                                                        <option value="เปล่า">เปล่า</option>
                                                        <option value="หนัก">หนัก</option>

                                                    </select>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row" >
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>เวลา Tenko</label>
                                                    <input class="form-control"  id="txt_tenkotime" name="txt_tenkotime"  value="">
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>เวลาที่เริ่มหยุด</label>
                                                    <input class="form-control " type="text" id="txt_starttime" name="txt_starttime">
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>เวลาที่หยุดเสร็จ</label>
                                                    <input class="form-control"  id="txt_stoptime" name="txt_stoptime"  value="">
                                                </div>

                                            </div>


                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>วันที่รับเรื่อง</label>
                                                    <input class="form-control dateen" readonly="" style="background-color: #f080802e" id="txt_dateinput" name="txt_dateinput"  value="">
                                                </div>

                                            </div>



                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>เลขใบส่งสินค้า</label>
                                                    <input class="form-control"  id="txt_productnumber" name="txt_productnumber"  value="">
                                                </div>

                                            </div>

                                        </div>

                                        <div class="row" >
                                            <div class="col-lg-6">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="text-align: center;background-color: #f8f8f8;">
                                                        <label>เที่ยวที่ 1</label>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">

                                                        <div class="alert alert-info" style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px;">
                                                            <div class="row" >
                                                                <div class="col-lg-6">

                                                                    <font style="color: red">* </font><label>งานที่รับ</label>
                                                                    <input class="form-control"  id="txt_jobinput" name="txt_jobinput"  value="">


                                                                </div>
                                                                <div class="col-lg-6">

                                                                    <font style="color: red">* </font><label>เวลาที่รับ</label>
                                                                    <input class="form-control"  id="txt_timeinput" name="txt_timeinput"  value="">

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="text-align: center;background-color: #f8f8f8;">
                                                        <label>เที่ยวที่ 2</label>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">

                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                            <div class="row" >
                                                                <div class="col-lg-6">

                                                                    <label>งานที่รับ</label>
                                                                    <input class="form-control"  id="txt_jobinput2" name="txt_jobinput2"  value="">


                                                                </div>
                                                                <div class="col-lg-6">

                                                                    <label>เวลาที่รับ</label>
                                                                    <input class="form-control"  id="txt_timeinput2" name="txt_timeinput2"  value="">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>

                                        </div>



                                        <!-- /.row (nested) -->
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        ข้อมูลพนักงาน
                                    </div>
                                    <div class="panel-body" style="background-color: #f8f8f8">
                                        <div class="row" >
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>ชื่อพนักงาน : <?= $result_seEHR2['nameT'] ?></label>
                                                    <input type="text" style="display: none" class="form-control" id="txt_employeeid" name="txt_employeeid"  value="<?= $result_seEHR2['PersonCode'] ?>">
                                                    <input type="text" style="display: none" class="form-control" id="txt_employeename" name="txt_employeename"  value="<?= $result_seEHR2['nameT'] ?>">
                                                    <input type="text" style="display: none" class="form-control" id="txt_companycode" name="txt_companycode"  value="<?= $result_seEHR2['Company_Code'] ?>">
                                                    <input type="text" style="display: none" class="form-control" id="txt_companyname" name="txt_companyname"  value="<?= $result_seEHR2['Company_NameT'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>อายุ : <?= $result_seEHR2['year'] ?> ปี</label>

                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>อายุงาน : <?= $result_seEHR2['yearwork'] ?> ปี</label>

                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>ตำแหน่ง : <?= $result_seEHR2['PositionNameT'] ?></label>

                                                </div>

                                            </div>
                                        </div>
                                        <!-- /.row (nested) -->
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="button" onclick="save_stopwork('');" name="btnSend" id="btnSend" value="บันทึกข้อมูล" class="btn btn-primary">

                            </div>
                        </div>
                    </div>
                    <div id="datasr_edit"></div>
                    <div class="row" >
                        <div class="col-lg-12">
                            &nbsp;

                        </div>
                    </div>
                    <div class="row">
                        <?php
                        $sql_getDate = "{call megStopwork_v2(?)}";
                        $params_getDate = array(
                            array('select_getdate', SQLSRV_PARAM_IN)
                        );
                        $query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
                        $result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);
                        ?>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>ค้นหาตามช่วงวันที่</label>
                                <input class="form-control dateen"  id="txt_datestart" onchange="datetodate();" readonly="" style="background-color: #f080802e" name="txt_datestart" value="<?= $result_getDate['SYSDATE'] ?>" placeholder="วันที่เริ่มต้น">

                            </div>

                        </div>
                        <div class="col-lg-2">
                            <label>&nbsp;</label>
                            <div class="form-group">
                                <input type="text" class="form-control dateen" id="txt_dateend" readonly="" style="background-color: #f080802e" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE'] ?>">

                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label>&nbsp;</label>
                            <div class="form-group">

                                <button type="button" class="btn btn-default" onclick="select_stopwork();">ค้นหา <li class="fa fa-search"></li></button>&emsp;<button type="button" onclick="excel_stopwork()" class="btn btn-default">Excel <li class="fa fa-file-excel-o"></li></button>
                            </div>

                        </div>

                    </div>   
                    <div class="row" >
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <font style="font-size: 16px"><b>ประวัติการแจ้งหยุดรถของพนักงาน : <?= $result_seEHR2['nameT'] ?></b></font>                            
                                </div>
                                <div class="panel-body">
                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                        <div class="row">


                                            <div class="col-sm-12">
                                                <div id="datade">
                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>รหัสพนักงาน</th>
                                                                <th>ชื่อ-สกุล(พขร.)</th>
                                                                <th>กระบวนการหยุด</th>
                                                                <th>เหตุผล</th>
                                                                <th>ประเภทรถ</th>
                                                                <th>สถานะรถ</th>
                                                                <th>ทะเบียนรถ</th>
                                                                <th>เบอร์รถ/ชื่อรถ</th>
                                                                <th>จุดจอด</th>
                                                                <th>เวลาที่เริ่มหยุด</th>
                                                                <th>เวลาที่หยุดเสร็จ</th>
                                                                <th>เวลา Tenko</th>
                                                                <th>วันที่</th>
                                                                <th>งานที่รับเที่ยวที่ 1</th>
                                                                <th>เวลาที่รับเที่ยวที่ 1</th>
                                                                <th>งานที่รับเที่ยวที่ 2</th>
                                                                <th>เวลาที่รับเที่ยวที่ 2</th>
                                                                <th>เลขใบส่งสินค้า</th>
                                                                <th style="text-align: center">จัดการ</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $condition1 = " AND a.EMPLOYEEID = '" . $_GET['employeeid'] . "'";
                                                            $sql_seStopwork = "{call megStopwork_v2(?,?)}";
                                                            $params_seStopwork = array(
                                                                array('select_stopwork', SQLSRV_PARAM_IN),
                                                                array($condition1, SQLSRV_PARAM_IN)
                                                            );


                                                            $query_seStopwork = sqlsrv_query($conn, $sql_seStopwork, $params_seStopwork);
                                                            while ($result_seStopwork = sqlsrv_fetch_array($query_seStopwork, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr class="odd gradeX">
                                                                    <td><?= $result_seStopwork['EMPLOYEEID'] ?></td>
                                                                    <td><?= $result_seStopwork['EMPLOYEENAME'] ?></td>
                                                                    <td><?= $result_seStopwork['STOPPROCESS'] ?></td>
                                                                    <td><?= $result_seStopwork['REASON'] ?></td>
                                                                    <td><?= $result_seStopwork['VEHICLETYPEDESC'] ?></td>
                                                                    <td><?= $result_seStopwork['CARSTATUS'] ?></td>
                                                                    <td><?= $result_seStopwork['VEHICLEREGISNUMBER'] ?></td>
                                                                    <td><?= $result_seStopwork['THAINAME'] ?></td>
                                                                    <td><?= $result_seStopwork['PARKINGN'] ?></td>
                                                                    <td><?= $result_seStopwork['STARTTIME'] ?></td>
                                                                    <td><?= $result_seStopwork['STOPTIME'] ?></td>
                                                                    <td><?= $result_seStopwork['TENKOTIME'] ?></td>
                                                                    <td><?= $result_seStopwork['DATEINPUT'] ?></td>
                                                                    <td><?= $result_seStopwork['JOBINPUT'] ?></td>
                                                                    <td><?= $result_seStopwork['TIMEINPUT'] ?></td>
                                                                    <td><?= $result_seStopwork['JOBINPUT2'] ?></td>
                                                                    <td><?= $result_seStopwork['TIMEINPUT2'] ?></td>
                                                                    <td><?= $result_seStopwork['PRODUCTNUMBER'] ?></td>
                                                                    <td style="text-align: center">
                                                                        <button onclick="showupdate_stopwork('<?= $result_seStopwork['EMPLOYEESTOPWORKID'] ?>');" title="แก้ไขข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></button>
                                                                        <button onclick="delete_stopwork('<?= $result_seStopwork['EMPLOYEESTOPWORKID'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                                                    </td>

                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>



                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <?php
                                                                $condition1 = " AND EMPLOYEEID = '" . $_GET['employeeid'] . "'";
                                                                $sql_seSumtenkostop = "{call megStopwork_v2(?,?)}";
                                                                $params_seSumtenkostop = array(
                                                                    array('select_sumtotalstop', SQLSRV_PARAM_IN),
                                                                    array($condition1, SQLSRV_PARAM_IN)
                                                                );


                                                                $query_seSumtenkostop = sqlsrv_query($conn, $sql_seSumtenkostop, $params_seSumtenkostop);
                                                                $result_seSumtenkostop = sqlsrv_fetch_array($query_seSumtenkostop, SQLSRV_FETCH_ASSOC);
                                                                ?>
                                                                <td colspan="19"><font style="color: #000000;"> <b>สรุปเวลาในการจอดนอนรวมของพนักงาน : <?= $result_seEHR2['nameT'] ?> เวลา <?= $result_seSumtenkostop['SUMTOTALSTOPSTOP'] ?></b> </font></td>
                                                            </tr>
                                                        </tfoot>

                                                    </table>
                                                </div>
                                                <div id="datasr"></div>

                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


            </div>

        </div>






        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/raphael/raphael.min.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>

        <script src="../dist/js/jszip.min.js"></script>
        <script src="../dist/js/dataTables.buttons.min.js"></script>
        <script src="../dist/js/buttons.html5.min.js"></script>
        <script src="../dist/js/buttons.print.min.js"></script>



        <script src="../dist/js/jquery.autocomplete.js"></script>
        <?php
        $carname = select_carautocomplate('megVehicleinfo_v2', 'select_vehicleinfo','');

        $car = select_vehiclenumberautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', '');
        ?>
        <script type="text/javascript">

                                                                            var txt_vehicleregisnumber = [<?= $car ?>];
                                                                            $(function () {
                                                                                $("#txt_vehicleregisnumber").autocomplete({
                                                                                    source: [txt_vehicleregisnumber]
                                                                                });
                                                                            });


                                                                            var txt_thainamename = [<?= $carname ?>];

                                                                            $(function () {
                                                                                $("#txt_thainamename").autocomplete({
                                                                                    source: [txt_thainamename]
                                                                                });
                                                                            });
        </script>
        <script type="text/javascript">
            function excel_stopwork()
            {
                var employeeid = document.getElementById('txt_employeeid').value;
                var datestart = document.getElementById('txt_datestart').value;
                var dateend = document.getElementById('txt_dateend').value;

                window.location.href = 'excel_stopwork2.php?employeeid=' + employeeid + '&datestart=' + datestart + '&dateend=' + dateend;
            }
            function select_stopwork()
            {
                var employeeid = document.getElementById('txt_employeeid').value;
                var datestart = document.getElementById('txt_datestart').value;
                var dateend = document.getElementById('txt_dateend').value;
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_stopwork", employeeid: employeeid, datestart: datestart, dateend: dateend
                    },
                    success: function (response) {
                        if (response)
                        {
                            document.getElementById("datasr").innerHTML = response;
                            document.getElementById("datade").innerHTML = "";

                            $(document).ready(function () {
                                $('#dataTables-example').DataTable({
                                    responsive: true
                                });
                            });

                        }





                    }
                });

            }
        </script>

        <script>
            function chg_vehicleregisnumber(val)
            {

                //var val = document.getElementById("txt_vehicleregisnumber").value;
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "se_vehicleregisnumber", txt_vehicleregisnumber: val
                    },
                    success: function (response) {
                        if (response)
                        {
                            var data = response.split("|");
                            document.getElementById("txt_thainamename").value = data[0];
                            document.getElementById("cb_cartype").value = data[1];
                        }
                    }
                });

            }
        </script>
        <script>
            function datetodate()
            {
                document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;
            }
            function chg_thainame(val)
            {
                
                //var val = document.getElementById("txt_thainamename").value;
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "se_thainame", txt_thainame: val
                    },
                    success: function (response) {
                        if (response)
                        {
                          
                            var data = response.split("|");
                            document.getElementById("txt_vehicleregisnumber").value = data[0];
                            document.getElementById("cb_cartype").value = data[1];
                        }
                    }
                });

            }
        </script>

        <script type="text/javascript">

            $(function () {

                var srtype = "";
                $('#cb_srtype').on('change', function () {
                    var search = document.getElementById('txt_search').value;
                    if (document.getElementById('cb_srtype').value != "")
                    {
                        srtype = document.getElementById('cb_srtype').value;
                    }

                    $.ajax({
                        url: "meg_searchstopwork.php",
                        type: "post",
                        data: {search: search, srtype: srtype},
                        beforeSend: function () {
                            $(".loading").show();
                        },
                        complete: function () {
                            $(".loading").hide();
                        },
                        success: function (data) {
                            $("#list-data").html(data);
                        }
                    });
                });
                $("#txt_search").on("keyup keypress", function () {
                    var search = document.getElementById('txt_search').value;
                    if (document.getElementById('cb_srtype').value != "")
                    {
                        srtype = document.getElementById('cb_srtype').value;
                    }
                    $.ajax({
                        url: "meg_searchstopwork.php",
                        type: "post",
                        data: {srtype: srtype, search: search},
                        beforeSend: function () {
                            $(".loading").show();
                        },
                        complete: function () {
                            $(".loading").hide();
                        },
                        success: function (data) {
                            $("#list-data").html(data);
                        }
                    });
                });
                $("#btnSearch").click(function () {
                    var search = document.getElementById('txt_search').value;
                    if (document.getElementById('cb_srtype').value != "")
                    {
                        srtype = document.getElementById('cb_srtype').value;
                    }
                    $.ajax({
                        url: "meg_searchstopwork.php",
                        type: "post",
                        data: {search: search, srtype: srtype},
                        beforeSend: function () {
                            $(".loading").show();
                        },
                        complete: function () {
                            $(".loading").hide();
                        },
                        success: function (data) {
                            $("#list-data").html(data);
                        }
                    });
                });
                $("#searchform").on("keyup keypress", function (e) {
                    var code = e.keycode || e.which;
                    if (code == 13) {
                        $("#btnSearch").click();
                        return false;
                    }
                });
            });
        </script>
        <script type="text/javascript">

            function chknull_stopwork()
            {
                if (document.getElementById('cb_stopprocess').value == '')
                {
                    alert('กระบวนการหยุดเป็นค่าว่าง !!!')
                    document.getElementById('cb_stopprocess').focus();
                    return false;
                } else if (document.getElementById('cb_reason').value == '')
                {
                    alert('เหตุผลเป็นค่าว่าง !!!')
                    document.getElementById('cb_reason').focus();
                    return false;
                } else if (document.getElementById('cb_cartype').value == '')
                {
                    alert('ประเถทรถเป็นค่าว่าง !!!')
                    document.getElementById('cb_cartype').focus();
                    return false;
                } else if (document.getElementById('cb_carstatus').value == '')
                {
                    alert('สถานะรถเป็นค่าว่าง !!!')

                    document.getElementById('cb_carstatus').focus();
                    return false;
                } else if (document.getElementById('txt_vehicleregisnumber').value == '')
                {
                    alert('ทะเบียนรถเป็นค่าว่าง !!!')
                    document.getElementById('txt_vehicleregisnumber').focus();
                    return false;
                } else if (document.getElementById('txt_thainamename').value == '')
                {
                    alert('ยี่ห้อรถเป็นค่าว่าง !!!')
                    document.getElementById('txt_thainamename').focus();
                    return false;
                } else if (document.getElementById('txt_parking').value == '')
                {
                    alert('จุดจอดเป็นค่าว่าง !!!')
                    document.getElementById('txt_parking').focus();
                    return false;
                } else if (document.getElementById('txt_starttime').value == '')
                {
                    alert('เวลาที่เริ่มหยุดเป็นค่าว่าง !!!')
                    document.getElementById('txt_starttime').focus();
                    return false;
                } else if (document.getElementById('txt_stoptime').value == '')
                {
                    alert('เวลาที่หยุดเสร็จเป็นค่าว่าง !!!')
                    document.getElementById('txt_stoptime').focus();
                    return false;
                } else if (document.getElementById('txt_tenkotime').value == '')
                {
                    alert('เวลา Tenko ป็นค่าว่าง !!!')
                    document.getElementById('txt_tenkotime').focus();
                    return false;
                } else if (document.getElementById('txt_dateinput').value == '')
                {
                    alert('วันที่ที่รับเป็นค่าว่าง !!!')
                    document.getElementById('txt_dateinput').focus();
                    return false;
                } else if (document.getElementById('txt_timeinput').value == '')
                {
                    alert('เวลาที่รับเป็นค่าว่าง !!!')
                    document.getElementById('txt_timeinput').focus();
                    return false;
                } else if (document.getElementById('txt_jobinput').value == '')
                {
                    alert('งานที่รับเป็นค่าว่าง !!!')
                    document.getElementById('txt_jobinput').focus();

                } else
                {

                    return true;


                }
            }
            function save_stopwork(employeestopworkid)
            {
                var employeestopworkid = employeestopworkid;
                var employeeid = document.getElementById('txt_employeeid').value;
                var employeename = document.getElementById('txt_employeename').value;
                var companycode = document.getElementById('txt_companycode').value;
                var companyname = document.getElementById('txt_companyname').value;
                var stopprocess = document.getElementById('cb_stopprocess').value;
                var reason = document.getElementById('cb_reason').value;
                var cartype = document.getElementById('cb_cartype').value;
                var carstatus = document.getElementById('cb_carstatus').value;
                var vehicleregisnumber = document.getElementById('txt_vehicleregisnumber').value;
                var thainamename = document.getElementById('txt_thainamename').value;
                var parking = document.getElementById('txt_parking').value;
                var starttime = document.getElementById('txt_starttime').value;
                var stoptime = document.getElementById('txt_stoptime').value;
                var tenkotime = document.getElementById('txt_tenkotime').value;
                var dateinput = document.getElementById('txt_dateinput').value;
                var jobinput = document.getElementById('txt_jobinput').value;
                var timeinput = document.getElementById('txt_timeinput').value;
                var jobinput2 = document.getElementById('txt_jobinput2').value;
                var timeinput2 = document.getElementById('txt_timeinput2').value;
                var productnumber = document.getElementById('txt_productnumber').value;

                if (chknull_stopwork())
                {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "save_stopwork", employeestopworkid: employeestopworkid, employeeid: employeeid, employeename: employeename, companycode: companycode, companyname: companyname,
                            stopprocess: stopprocess, reason: reason,
                            cartype: cartype, carstatus: carstatus, vehicleregisnumber: vehicleregisnumber, thainamename: thainamename, parking: parking,
                            starttime: starttime, stoptime: stoptime, tenkotime: tenkotime, dateinput: dateinput, jobinput: jobinput, timeinput: timeinput,
                            jobinput2: jobinput2, timeinput2: timeinput2, productnumber: productnumber
                        },
                        success: function (response) {
                            alert(response);
                            window.location.reload();
                        }
                    });
                }
            }

            function delete_stopwork(val)
            {
                var confirmation = confirm("ต้องการลบข้อมูล ?");

                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_stopwork", employeestopworkid: val
                        },
                        success: function () {
                            alert('ลบข้อมูลเรียบร้อยแล้ว');
                            window.location.reload();


                        }
                    });

                }




            }
            function showupdate_stopwork(val)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "showupdate_stopwork", employeestopworkid: val
                    },
                    success: function (response) {
                        if (response)
                        {
                            document.getElementById("datasr_edit").innerHTML = response;
                            document.getElementById("datade_edit").innerHTML = "";

                        }


                        $('#txt_starttime').datetimepicker({
                            datepicker: false,
                            format: 'H:i',
                            mask: '29:59',
                        });
                        $('#txt_stoptime').datetimepicker({
                            datepicker: false,
                            format: 'H:i',
                            mask: '29:59',
                        });
                        $('#txt_tenkotime').datetimepicker({
                            datepicker: false,
                            format: 'H:i',
                            mask: '29:59',
                        });
                        $('#txt_timeinput').datetimepicker({
                            datepicker: false,
                            format: 'H:i',
                            mask: '29:59',
                        });
                        $('#txt_timeinput2').datetimepicker({
                            datepicker: false,
                            format: 'H:i',
                            mask: '29:59',
                        });
                        $(function () {
                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                            // กรณีใช้แบบ input
                            $(".dateen").datetimepicker({
                                timepicker: false,
                                format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                            });
                        });



                        var txt_vehicleregisnumber = [<?= $car ?>];
                        $(function () {
                            $("#txt_vehicleregisnumber").autocomplete({
                                source: [txt_vehicleregisnumber]
                            });
                        });


                        var txt_thainamename = [<?= $carname ?>];

                        $(function () {
                            $("#txt_thainamename").autocomplete({
                                source: [txt_thainamename]
                            });
                        });

                    }
                });
            }

        </script>


        <script type="text/javascript">

            $('#txt_starttime').datetimepicker({
                datepicker: false,
                format: 'H:i',
                mask: '29:59',
            });
            $('#txt_stoptime').datetimepicker({
                datepicker: false,
                format: 'H:i',
                mask: '29:59',
            });
            $('#txt_tenkotime').datetimepicker({
                datepicker: false,
                format: 'H:i',
                mask: '29:59',
            });
            $('#txt_timeinput').datetimepicker({
                datepicker: false,
                format: 'H:i',
                mask: '29:59',
            });
            $('#txt_timeinput2').datetimepicker({
                datepicker: false,
                format: 'H:i',
                mask: '29:59',
            });
            $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".dateen").datetimepicker({
                    timepicker: false,
                    format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                });
            });
            $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".dateth").datetimepicker({
                    timepicker: false,
                    format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

                    onSelectDate: function (dp, $input) {
                        var yearT = new Date(dp).getFullYear() - 0;
                        var yearTH = yearT + 543;
                        var fulldate = $input.val();
                        var fulldateTH = fulldate.replace(yearT, yearTH);
                        $input.val(fulldateTH);
                    },
                });
                // กรณีใช้กับ input ต้องกำหนดส่วนนี้ด้วยเสมอ เพื่อปรับปีให้เป็น ค.ศ. ก่อนแสดงปฏิทิน
                $(".dateth").on("mouseenter mouseleave", function (e) {
                    var dateValue = $(this).val();
                    if (dateValue != "") {
                        var arr_date = dateValue.split("/"); // ถ้าใช้ตัวแบ่งรูปแบบอื่น ให้เปลี่ยนเป็นตามรูปแบบนั้น
                        // ในที่นี้อยู่ในรูปแบบ 00-00-0000 เป็น d-m-Y  แบ่งด่วย - ดังนั้น ตัวแปรที่เป็นปี จะอยู่ใน array
                        //  ตัวที่สอง arr_date[2] โดยเริ่มนับจาก 0 
                        if (e.type == "mouseenter") {
                            var yearT = arr_date[2] - 543;
                        }
                        if (e.type == "mouseleave") {
                            var yearT = parseInt(arr_date[2]) + 543;
                        }
                        dateValue = dateValue.replace(arr_date[2], yearT);
                        $(this).val(dateValue);
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });
        </script>

    </body>

</html>
<?php
sqlsrv_close($conn);
?>