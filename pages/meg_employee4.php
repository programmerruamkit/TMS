<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");

Update_Time_Data('update'); // อัพเดทฐานข้อมูล ทุกครั้งที่เปิดหน้านี้

$condEmp = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEmp = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmp = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($condEmp, SQLSRV_PARAM_IN)
);
$query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
$result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC);
?>
<html lang="en">
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
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
            .popover-content {
                padding: 10px 10px;
                width: 200px;
            }
            .nav>li>a {
                position: relative;
                display: block;
                padding: 14px 30px;
            </style>
        </head>
        <body>
            <div id="wrapper">
                <!-- Navigation -->
                <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <?php
                    if (!isset($_SESSION["USERNAME"]) || !isset($_SESSION["PASSWORD"])) {
                        header("location:meg_login.php?data=" . $_GET['data']);
                    }
                    ?>
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="index.php"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">

                                    <li><a href="meg_logout.php"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>



                    <div class="row">

                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" >

                                    <div class="row">&nbsp;</div>
                                    <div class="row">

                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 2%">&nbsp;</td>
                                                <td style="width: 10%">

                                                    <select class="form-control"  id="cb_typetenko" name="cb_typetenko" >
                                                        <option value="เท็งโก๊ะก่อนเริ่มงาน">เท็งโก๊ะ ก่อนเริ่มงาน</option>
                                                        <option value="เท็งโก๊ะระหว่างทาง/หลังเลิกงาน">เท็งโก๊ะ ระหว่างทาง/หลังเลิกงาน</option>

                                                    </select>

                                                </td>
                                                <td style="width: 2%">&nbsp;</td>
                                                <td style="width: 10%">

                                                    <select class="form-control"  id="cb_srtype" name="cb_srtype" >
                                                        <option value="-">เลือกบริษัท</option>
                                                        <?php
                                                        $area = "";
                                                        if ($_GET['area'] == 'amata') {
                                                            $area = " AND Company_Code IN ('RKS','RKR','RKL','RIT','RTD','RTC','RKB')";
                                                        } else if ($_GET['area'] == 'gateway') {
                                                            $area = " AND Company_Code IN ('RATC','RCC','RRC')";
                                                        }

                                                        $sql_seComp = "{call megCompany_v2(?,?)}";
                                                        $params_seComp = array(
                                                            array('select_company', SQLSRV_PARAM_IN),
                                                            array($area, SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
                                                        while ($result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC)) {
                                                            ?>
                                                            <option value = "<?= $result_seComp['Company_Code'] ?>"><?= $result_seComp['Company_NameT'] ?></option> 
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>

                                                </td>
                                                <td style="width: 2%">&nbsp;</td>
                                                <td style="width: 20%">

                                                    <input type="text"  name="txt_search"  id="txt_search" class="form-control" >

                                                </td>
                                                <td style="width: 2%">&nbsp;</td>
                                                <td style="width: 15%">
                                                    <label>พนักงานขับรถ</label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="rdo_position" id="rdo_dirver" value="dirver" checked="" >&nbsp;
                                                    </label>
                                                    <label>เจ้าหน้าที่</label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="rdo_position" id="rdo_officer" value="officer" >&nbsp;
                                                    </label>

                                                </td>
                                                <td >
                                                    
                                                    <label class="radio-inline">
                                                        <input type="button" class="form-control" name="btn_sr" id="btn_sr" value="ค้นหา" checked="" onclick="select_employee2()">
                                                    </label>
                                                    

                                                </td>

                                            </tr>
                                        </table>

                                    </div>

                                </div>


                                <div class="panel-body">
                                    <div class="col-md-6">
                                        <a href="index.html">หน้าหลัก</a> / พนักงาน / <a href="report_employee4.php">รายงาน</a>
                                    </div>
                                    <div class="row" id="loading">

                                    </div>
                                    <div class="row" id="list-data">
                                        <div class="col-md-6 text-right">&nbsp;</div>
                                        <div class="col-md-6 text-right">

                                            <?php
                                            $sql_seCountnot = "{call megTimeattendanceEHR_v2(?,?)}";
                                            $params_seCountnot = array(
                                                array('select_countnotemployeeinout1', SQLSRV_PARAM_IN),
                                                array('RKB', SQLSRV_PARAM_IN)
                                            );
                                            $query_seCountnot = sqlsrv_query($conn, $sql_seCountnot, $params_seCountnot);
                                            $result_seCountnot = sqlsrv_fetch_array($query_seCountnot, SQLSRV_FETCH_ASSOC);
                                            $result_seCountnot['AMOUNT'];

                                            $sql_seCount = "{call megTimeattendanceEHR_v2(?,?)}";
                                            $params_seCount = array(
                                                array('select_countemployeeinout1', SQLSRV_PARAM_IN),
                                                array('RKB', SQLSRV_PARAM_IN)
                                            );
                                            $query_seCount = sqlsrv_query($conn, $sql_seCount, $params_seCount);
                                            $result_seCount = sqlsrv_fetch_array($query_seCount, SQLSRV_FETCH_ASSOC);
                                            $result_seCount['AMOUNT'];

                                            $sql_seCountlate = "{call megTimeattendanceEHR_v2(?,?)}";
                                            $params_seCountlate = array(
                                                array('select_countlateemployeeinout', SQLSRV_PARAM_IN),
                                                array('RKB', SQLSRV_PARAM_IN)
                                            );
                                            $query_seCountlate = sqlsrv_query($conn, $sql_seCountlate, $params_seCountlate);
                                            $result_seCountlate = sqlsrv_fetch_array($query_seCountlate, SQLSRV_FETCH_ASSOC);
                                            $result_seCountlate['AMOUNT'];
                                            ?>
                                            <input class="btn btn-default" type="button" style="background-color: white;border:solid 2px #999;color: #999" id="btn_srquotation" name="btn_srquotation" value="ยังไม่มา (<?= $result_seCountnot['AMOUNT'] ?>)">&emsp;
                                            <input class="btn btn-default" type="button" style="background-color: white;border:solid 2px blue;color: blue" id="btn_srquotation" name="btn_srquotation" value="ปรกติ (<?= $result_seCount['AMOUNT'] ?>)">&emsp;
                                            <input class="btn btn-default" type="button" style="background-color: white;border:solid 2px red;color: red" id="btn_srquotation" name="btn_srquotation" value="สาย (0)">

                                        </div>
                                        <div class="col-md-12">&nbsp;</div>
                                        <?php
                                        $sql_updEmployee = "{call megTimeattendanceEHR_v2(?)}";
                                        $params_updEmployee = array(
                                            array('update_employee', SQLSRV_PARAM_IN)
                                        );
                                        $query_updEmployee = sqlsrv_query($conn, $sql_updEmployee, $params_updEmployee);


                                        $condition1 = " AND c.Company_Code = 'RKB'";
                                        $condition2 = " AND d.PositionGroup = 'พนักงาน'";
                                        $sql_seEmployee = "{call megTimeattendanceEHR_v2(?,?,?)}";
                                        $params_seEmployee = array(
                                            array('select_employeeinout', SQLSRV_PARAM_IN),
                                            array($condition1, SQLSRV_PARAM_IN),
                                            array($condition2, SQLSRV_PARAM_IN)
                                        );
                                        $query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
                                        while ($result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC)) {
                                            if ($result_seEmployee['VEHICLETRANSPORTPLANID'] != "") {

                                                $conditionTenkomaster = " AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "'";
                                                $sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
                                                $params_seTenkomaster = array(
                                                    array('select_tenkomaster', SQLSRV_PARAM_IN),
                                                    array($conditionTenkomaster, SQLSRV_PARAM_IN)
                                                );
                                                $query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
                                                $result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);

                                                if ($result_seTenkomaster['TENKOMASTERDIRVERCODE1'] == $result_seEmployee['PersonCode']) {
                                                    $sql_seBeforecheck1 = "{call megEdittenkobefore_v2(?,?,?)}";
                                                    $params_seBeforecheck1 = array(
                                                        array('select_beforecheck', SQLSRV_PARAM_IN),
                                                        array($result_seTenkomaster['TENKOMASTERID'], SQLSRV_PARAM_IN),
                                                        array($result_seTenkomaster['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seBeforecheck1 = sqlsrv_query($conn, $sql_seBeforecheck1, $params_seBeforecheck1);
                                                    $result_seBeforecheck1 = sqlsrv_fetch_array($query_seBeforecheck1, SQLSRV_FETCH_ASSOC);

                                                    $sql_seBeforeresult1 = "{call megEdittenkobefore_v2(?,?,?)}";
                                                    $params_seBeforeresult1 = array(
                                                        array('select_beforeresult', SQLSRV_PARAM_IN),
                                                        array($result_seTenkomaster['TENKOMASTERID'], SQLSRV_PARAM_IN),
                                                        array($result_seTenkomaster['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seBeforeresult1 = sqlsrv_query($conn, $sql_seBeforeresult1, $params_seBeforeresult1);
                                                    $result_seBeforeresult1 = sqlsrv_fetch_array($query_seBeforeresult1, SQLSRV_FETCH_ASSOC);
                                                }
                                                if ($result_seTenkomaster['TENKOMASTERDIRVERCODE2'] == $result_seEmployee['PersonCode']) {
                                                    $sql_seBeforecheck2 = "{call megEdittenkobefore_v2(?,?,?)}";
                                                    $params_seBeforecheck2 = array(
                                                        array('select_beforecheck', SQLSRV_PARAM_IN),
                                                        array($result_seTenkomaster['TENKOMASTERID'], SQLSRV_PARAM_IN),
                                                        array($result_seTenkomaster['TENKOMASTERDIRVERCODE2'], SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seBeforecheck2 = sqlsrv_query($conn, $sql_seBeforecheck2, $params_seBeforecheck2);
                                                    $result_seBeforecheck2 = sqlsrv_fetch_array($query_seBeforecheck2, SQLSRV_FETCH_ASSOC);

                                                    $sql_seBeforeresult2 = "{call megEdittenkobefore_v2(?,?,?)}";
                                                    $params_seBeforeresult2 = array(
                                                        array('select_beforeresult', SQLSRV_PARAM_IN),
                                                        array($result_seTenkomaster['TENKOMASTERID'], SQLSRV_PARAM_IN),
                                                        array($result_seTenkomaster['TENKOMASTERDIRVERCODE2'], SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seBeforeresult2 = sqlsrv_query($conn, $sql_seBeforeresult2, $params_seBeforeresult2);
                                                    $result_seBeforeresult2 = sqlsrv_fetch_array($query_seBeforeresult2, SQLSRV_FETCH_ASSOC);
                                                }
                                            } else {
                                                $conditionTenkomaster = " AND a.TENKOMASTERDIRVERCODE1 = '" . $result_seEmployee['PersonCode'] . "'";
                                                $sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
                                                $params_seTenkomaster = array(
                                                    array('select_tenkomaster', SQLSRV_PARAM_IN),
                                                    array($conditionTenkomaster, SQLSRV_PARAM_IN)
                                                );
                                                $query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
                                                $result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);

                                                $sql_seBeforecheck1 = "{call megEdittenkobefore_v2(?,?,?)}";
                                                $params_seBeforecheck1 = array(
                                                    array('select_beforecheckofficer', SQLSRV_PARAM_IN),
                                                    array($result_seTenkomaster['TENKOMASTERID'], SQLSRV_PARAM_IN),
                                                    array($result_seTenkomaster['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
                                                );
                                                $query_seBeforecheck1 = sqlsrv_query($conn, $sql_seBeforecheck1, $params_seBeforecheck1);
                                                $result_seBeforecheck1 = sqlsrv_fetch_array($query_seBeforecheck1, SQLSRV_FETCH_ASSOC);

                                                $sql_seBeforeresult1 = "{call megEdittenkobefore_v2(?,?,?)}";
                                                $params_seBeforeresult1 = array(
                                                    array('select_beforeresultofficer', SQLSRV_PARAM_IN),
                                                    array($result_seTenkomaster['TENKOMASTERID'], SQLSRV_PARAM_IN),
                                                    array($result_seTenkomaster['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
                                                );
                                                $query_seBeforeresult1 = sqlsrv_query($conn, $sql_seBeforeresult1, $params_seBeforeresult1);
                                                $result_seBeforeresult1 = sqlsrv_fetch_array($query_seBeforeresult1, SQLSRV_FETCH_ASSOC);
                                            }
                                            ?>
                                            <div class="col-lg-3">
                                                <div class="panel" style="background-color: #FFF;;

                                                <?php
                                                if ($result_seEmployee['ST'] == 'OK' || $result_seEmployee['ST'] == 'Late') {
                                                    ?>
                                                    color: blue;
                                                    border-color:blue;
                                                    <?php
                                                } else {
                                                    ?>
                                                    color: #999;
                                                    border-color: #999;
                                                    <?php
                                                }
                                                ?>                         

                                                ">
                                                <div class="panel-heading">
                                                    <div class="row">

                                                        <div class="col-lg-2 text-center">
                                                            <!--<img src="../tmlspictures/employees/<?//= $result_srEmp['PersonCode'] ?>.jpg" style="width: 60px;height: 60px;"><font style="font-size: 10px"><?//= $result_seEmp['nameT'] ?></font>-->
                                                            <img src="../images/employee/<?= $result_seEmployee['PersonCodeP'] ?>.jpg" style="width: 80px;height: 80px;">
                                                        </div>
                                                        <div class="col-lg-5 text-center">
                                                            <div class="row">
                                                                <div class="huge" style="text-align: right"> <font style="font-size: 16px">เวลาเข้างานวันนี้</font></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="huge" style="text-align: right"> <font style="font-size: 16px">สถานะการตรวจร่างกาย</font></div>
                                                                </div>
                                                                <?php
                                                                if ($result_seEmployee['VEHICLETRANSPORTPLANID'] != "") {
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="huge" style="text-align: right">   <?php
                                                            if ($result_seEmployee['DATEPRESENT_ACTUAL'] == "") {
                                                                        ?>
                                                                                <img src="../images/warning.gif" width="30"> 
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                            <font style="font-size: 16px;color: green">มีแผนงานวิ่ง</font></div>
                                                                    </div>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="huge">&nbsp;</div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>

                                                            </div>
                                                            <div class="col-lg-5 text-center">
                                                                <div class="row">

                                                                    <div class="huge" style="text-align: right"> <font style="font-size: 16px"><?= $result_seEmployee['TimeInout'] ?> นาที&emsp;</font></div>

                                                                </div>
                                                                <div class="row">
                                                                    <?php
                                                                    if ($result_seBeforecheck1['TENKOBEFORECHECK'] != '0') {

                                                                        if ($result_seBeforeresult1['TENKOBEFORERESULT'] == '0') {
                                                                            ?>
                                                                            <div class="huge" style="text-align: right"><font style="font-size: 16px"><span class="glyphicon glyphicon-remove"></span>&emsp;</font></div>

                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <div class="huge" style="text-align: right"><font style="font-size: 16px"><span class="glyphicon glyphicon-ok"></span>&emsp;</font></div>
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <div class="huge" style="text-align: right"><font style="font-size: 16px"><span class="glyphicon glyphicon-minus"></span>&emsp;</font></div>
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                </div>
                                                                <?php
                                                                if ($result_seEmployee['VEHICLETRANSPORTPLANID'] != "") {
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="huge" style="text-align: right"> <font style="font-size: 16px;color: green"><?= $result_seEmployee['TIMEVLIN'] ?> นาที&emsp;</font></div>
                                                                    </div>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="huge">&nbsp;</div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>


                                                        </div>
                                                    </div>
                                                    <div class="panel-footer" style="height: 50px">
                                                        <span class="pull-left"><font style="font-size: 16px"><?= $result_seEmployee['nameTP'] ?> (<?= $result_seEmployee['PersonCodeP'] ?>)</font></span>

                                                        <?php
                                                        if ($result_seEmployee['TimeInout'] != "") {
                                                            ?>
                                                            <span class="pull-right"> 
                                                                <?php
                                                                if ($result_seEmployee['VEHICLETRANSPORTPLANID'] == "") {
                                                                    ?>
                                                                    <div class="btn-group pull-right">
                                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                            <i class="fa fa-chevron-down"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu slidedown">
                                                                            <li>
                                                                                <a href="#" >
                                                                                    รายงานตัวตรวจร่างกาย
                                                                                </a>
                                                                            </li>
                                                                            <li class="divider"></li>
                                                                            <li>
                                                                                <a href="#" >
                                                                                    ตรวจสอบเวลาเข้างาน
                                                                                </a>
                                                                            </li>

                                                                        </ul>
                                                                    </div>

                                                                    <?php
                                                                } else {
                                                                    ?>

                                                                    <div class="btn-group pull-right">
                                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                            <i class="fa fa-chevron-down"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu slidedown">
                                                                            <li>
                                                                                <a href="#">
                                                                                    รายงานตัวตรวจร่างกาย
                                                                                </a>
                                                                            </li>
                                                                            <li class="divider"></li>
                                                                            <li>
                                                                                <a href="#" >
                                                                                    ตรวจสอบเวลาเข้างาน
                                                                                </a>
                                                                            </li>

                                                                        </ul>
                                                                    </div>


                                                                    <?php
                                                                }
                                                                ?>
                                                            </span>
                                                            <?php
                                                        }
                                                        ?>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>

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

            </div>

            <!-- Modal -->
            <?php $nowdt = date("Y-m-d"); ?>
            <div id="modalData" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-lg-6"><h3 id="pname_display"></h3></div>
                                <div class="col-lg-3 text-right">
                                    <label for="ds1">จาก วันที่</label><input type="text" class="form-control dateen" id='ds1' name='ds1' value="<?= $nowdt; ?>" onchange="reloadPage(pID.value, pName.value, ds1.value, ds2.value)">
                                </div>
                                <div class="col-lg-3 text-right">
                                    <label for="ds2">ถึง วันที่</label><input type="text" class="form-control dateen" id='ds2' name='ds2' value="<?= $nowdt; ?>" onchange="reloadPage(pID.value, pName.value, ds1.value, ds2.value)">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body" id="ModalDisplay">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="CloseWindows()">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Modal-->

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

        </body>
        <script type="text/javascript">

                                function save_tenkomasterofficer(employeecode1, tenkomasterid)
                                {

                                    $.ajax({
                                        type: 'post',
                                        url: 'meg_data.php',
                                        data: {
                                            txt_flg: "save_tenkomasterofficer", tenkomasterid: '', vehicletransportplanid: employeecode1, changeka: '',
                                            remark1: '', remark2: '', status: '1', officer: '<?= $result_seEmp["nameT"] ?>'



                                        },
                                        success: function () {


                                            window.open('meg_tenkodocument.php?employeecode1=' + employeecode1 + '&companycode=' + document.getElementById("cb_srtype").value + '&tenkomasterid=' + tenkomasterid, '_blank');

                                        }
                                    });

                                }


                                function select_historysr()
                                {
                                    //var historydatestart = document.getElementById("txt_historydatestart").value;
                                    //var historydateend = document.getElementById("txt_historydateend").value;
                                    // var employeecode = document.getElementById("txt_employeecode").value;

                                    /*$.ajax({
                                     type: 'post',
                                     url: 'meg_data.php',
                                     data: {
                                     txt_flg: "select_employeeinout", employeecode: employeecode, historydatestart: historydatestart, historydateend: historydateend
                                     },
                                     success: function (response) {
                                     if (response)
                                     {
                                     document.getElementById("datadef").innerHTML = "";
                                     document.getElementById("datasr").innerHTML = response;
                                     }
                                     }
                                     });
                                     */

                                }
                                function select_history(employeecode, employeename)
                                {

                                    document.getElementById("title_history").innerHTML = '<b>ประวัติเข้า-ออก พขร. : ' + employeename + ' (' + employeecode + ')</b>';
                                }
                                function select_employee2()
                                {
                                  
                                    var positiondirver = '';

                                    if (document.getElementById("rdo_dirver").checked == true)
                                    {
                                        positiondirver = '1';
                                    } else
                                    {
                                        positiondirver = '';
                                    }

                                   
                                    var typetenko = document.getElementById("cb_typetenko").value;
                                    var srtype = document.getElementById("cb_srtype").value;
                                    var search = document.getElementById("txt_search").value;
                                    $.ajax({
                                        type: 'post',
                                        url: 'meg_searchemployee4.php',
                                        data: {
                                            srtype: srtype, search: search, positiondirver: positiondirver, typetenko: typetenko
                                        },
                                        success: function (response) {
                                            if (response)
                                            {
                                             
                                                document.getElementById("list-data").innerHTML = "";
                                                document.getElementById("loading").innerHTML = response;
                                                $('[data-toggle="popover"]').popover({
                                                    html: true,
                                                    content: function () {
                                                        return $('#popover-content').html();
                                                    }
                                                });
                                            }



                                        }
                                    });

                                }
        </script> <script>
                                    $(function () {
                                        $('[data-toggle="popover"]').popover({
                                        html: true,
                                            content: function () {
                                        return $('#popover-content').html();
                                    }
                                });
                                })

                                $(function () {
                                        $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                        // กรณีใช้แบบ input
                                $(".dateen").datetimepicker({
                                        timepicker: false,
                                        format: 'Y-m-d', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                                lang: 'th'

                                });
                                });
                                                        <!--คำสั่งการทำงานของระบบตรวจสอบเวลาเข้างาน-->
                                                function loadModal(pid, pname, sec) {
                                        var xhttp = new XMLHttpRequest();
                                        if (sec == 1){
                                xhttp.open("GET", "report_time_data.php?PID=" + pid + "&PNAME=" + pname + "&dateCheck=1", false);
                                                            }else{
                      xhttp.open("GET", "report_time_data.php", false);
                                                }
                                                xhttp.send();
                                                document.getElementById("ModalDisplay").innerHTML = xhttp.responseText;
                                                document.getElementById("pname_display").innerHTML = "คุณ " + pname + " (" + pid + ")";
        }

        function reloadPage(pid, pname, ds1, ds2) {
          var xhttp = new XMLHttpRequest();
          xhttp.open("GET", "report_time_data.php?PID=" + pid + "&PNAME=" + pname + "&Date1=" + ds1 + "&Date2=" + ds2 + "&dateCheck=0", false);
          xhttp.send();
          document.getElementById("ds1").values = ds1;
          document.getElementById("ds2").values = ds2;
  
          document.getElementById("ModalDisplay").innerHTML = xhttp.responseText;
        }

        function CloseWindows() {
            document.getElementById("ds1").values = '';
            document.getElementById("ds2").values = '';
        }
        </script>

    </html>

    <?php
    sqlsrv_close($conn);
    ?>