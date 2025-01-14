<!DOCTYPE html>
<?php
ob_start();
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");

$sql_seSystime = "{call megGetdate_v2(?)}";
$params_seSystime = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
$result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);

$employee1 = $_GET['employeecode1'];
$employee2 = $_GET['employeecode2'];
$conditionEHR = " AND a.PersonID ='" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEHR = "{call megEmployeeEHR_v2(?,?)}";
$params_seEHR = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($conditionEHR, SQLSRV_PARAM_IN)
);
$query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
$result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);

$conditionEHR1 = " AND a.Personcode ='" . $employee1 . "'";
$sql_seEHR1 = "{call megEmployeeEHR_v2(?,?)}";
$params_seEHR1 = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($conditionEHR1, SQLSRV_PARAM_IN)
);
$query_seEHR1 = sqlsrv_query($conn, $sql_seEHR1, $params_seEHR1);
$result_seEHR1 = sqlsrv_fetch_array($query_seEHR1, SQLSRV_FETCH_ASSOC);

if ($_GET['vehicletransportplanid'] != "") {
    $condition2_1 = " AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "'";
    $condition2_2 = " AND (a.EMPLOYEECODE1 ='" . $employee1 . "' OR a.EMPLOYEECODE2 ='" . $employee1 . "')";
    $condition2_3 = "";
} else {
    if ($employee1 != '') {
        $condition2_1 = " AND (a.EMPLOYEECODE1 ='" . $employee1 . "' OR a.EMPLOYEECODE2 ='" . $employee1 . "')";
    } else {
        $condition2_1 = '';
    }
    $condition2_2 = " AND (CONVERT(DATE,a.DATEPRESENT) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103))";
    $condition2_3 = "";
}
$sql_seVehicletransportplan2 = "{call megVehicletransportplan_v2(?,?,?,?)}";
$params_seVehicletransportplan2 = array(
    array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
    array($condition2_1, SQLSRV_PARAM_IN),
    array($condition2_2, SQLSRV_PARAM_IN),
    array($condition2_3, SQLSRV_PARAM_IN)
);
$query_seVehicletransportplan2 = sqlsrv_query($conn, $sql_seVehicletransportplan2, $params_seVehicletransportplan2);
$result_seVehicletransportplan2 = sqlsrv_fetch_array($query_seVehicletransportplan2, SQLSRV_FETCH_ASSOC);


$employeecode = "";
$employeename = "";
$vehicletransportplan = $result_seVehicletransportplan2['VEHICLETRANSPORTPLANID'];
$companycode = $result_seVehicletransportplan2['COMPANYCODE'];
$datevlin = $result_seVehicletransportplan2['DATEVLIN'];
$jobend = $result_seVehicletransportplan2['JOBNO'];

$E1 = "";
if ($result_seEHR['PersonCode'] == $result_seVehicletransportplan2['EMPLOYEECODE1']) {
    $E1 = $result_seVehicletransportplan2['E1'];
} else {
    $E1 = $result_seVehicletransportplan2['E2'];
}
$E3 = $result_seVehicletransportplan2['E3'];
$E4 = $result_seVehicletransportplan2['E4'];
$C1 = $result_seVehicletransportplan2['C1'];
$C2 = $result_seVehicletransportplan2['C2'];
$C3 = $result_seVehicletransportplan2['C3'];
$C4 = $result_seVehicletransportplan2['C4'];
$C5 = $result_seVehicletransportplan2['C5'];
$C6 = $result_seVehicletransportplan2['C6'];
$C9 = $result_seVehicletransportplan2['C9'];


if ($_GET['vehicletransportplanid'] != "") {
    if ($result_seEHR1['PersonCode'] == $result_seVehicletransportplan2['EMPLOYEECODE1']) {
        $employeecode = $result_seVehicletransportplan2['EMPLOYEECODE1'];
        $employeename = $result_seVehicletransportplan2['EMPLOYEENAME1'];
    } else {
        $employeecode = $result_seVehicletransportplan2['EMPLOYEECODE2'];
        $employeename = $result_seVehicletransportplan2['EMPLOYEENAME2'];
    }
} else {
    if ($result_seEHR['PersonCode'] == $result_seVehicletransportplan2['EMPLOYEECODE1']) {
        $employeecode = $result_seVehicletransportplan2['EMPLOYEECODE1'];
        $employeename = $result_seVehicletransportplan2['EMPLOYEENAME1'];
    } else {
        $employeecode = $result_seVehicletransportplan2['EMPLOYEECODE2'];
        $employeename = $result_seVehicletransportplan2['EMPLOYEENAME2'];
    }
}



$condition_doc = " AND VEHICLETRANSPORTPLANID ='" . $vehicletransportplan . "'";
$sql_seDoc = "{call megVehicletransportdocument_v2(?,?)}";
$params_seDoc = array(
    array('select_vehicletransportdocument', SQLSRV_PARAM_IN),
    array($condition_doc, SQLSRV_PARAM_IN)
);
$query_seDoc = sqlsrv_query($conn, $sql_seDoc, $params_seDoc);
$result_seDoc = sqlsrv_fetch_array($query_seDoc, SQLSRV_FETCH_ASSOC);

$condMileage = " AND VEHICLEREGISNUMBER ='" . $result_seVehicletransportplan2['VEHICLEREGISNUMBER1'] . "'";
$sql_seMileage = "{call megMileage_v2(?,?)}";
$params_seMileage = array(
    array('select_maxmileage', SQLSRV_PARAM_IN),
    array($condMileage, SQLSRV_PARAM_IN)
);
$query_seMileage = sqlsrv_query($conn, $sql_seMileage, $params_seMileage);
$result_seMileage = sqlsrv_fetch_array($query_seMileage, SQLSRV_FETCH_ASSOC);


$condcompany = " AND Company_Code ='" . $companycode . "'";
$sql_seCompany = "{call megCompanyEHR_v2(?,?)}";
$params_seCompany = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condcompany, SQLSRV_PARAM_IN)
);
$query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
$result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);


$sql_seCountholiday = "{call megHolidayEHR_v2(?,?,?,?)}";
$params_seCountholiday = array(
    array('count_holiday', SQLSRV_PARAM_IN),
    array($vehicletransportplan, SQLSRV_PARAM_IN),
    array($result_seCompany['ID_Company'], SQLSRV_PARAM_IN),
    array($datevlin, SQLSRV_PARAM_IN),
);
$query_seCountholiday = sqlsrv_query($conn, $sql_seCountholiday, $params_seCountholiday);
$result_seCountholiday = sqlsrv_fetch_array($query_seCountholiday, SQLSRV_FETCH_ASSOC);

$sql_seStartholiday = "{call megHolidayEHR_v2(?,?,?,?)}";
$params_seStartholiday = array(
    array('start_holidaywork', SQLSRV_PARAM_IN),
    array($vehicletransportplan, SQLSRV_PARAM_IN),
    array($result_seCompany['ID_Company'], SQLSRV_PARAM_IN),
    array($datevlin, SQLSRV_PARAM_IN),
);
$query_seStartholiday = sqlsrv_query($conn, $sql_seStartholiday, $params_seStartholiday);
$result_seStartholiday = sqlsrv_fetch_array($query_seStartholiday, SQLSRV_FETCH_ASSOC);



$sql_seBefore13holiday = "{call megHolidayEHR_v2(?,?,?,?)}";
$params_seBefore13holiday = array(
    array('return_before13', SQLSRV_PARAM_IN),
    array($vehicletransportplan, SQLSRV_PARAM_IN),
    array($result_seCompany['ID_Company'], SQLSRV_PARAM_IN),
    array($datevlin, SQLSRV_PARAM_IN),
);
$query_seBefore13holiday = sqlsrv_query($conn, $sql_seBefore13holiday, $params_seBefore13holiday);
$result_seBefore13holiday = sqlsrv_fetch_array($query_seBefore13holiday, SQLSRV_FETCH_ASSOC);

$sql_seAfter13holiday = "{call megHolidayEHR_v2(?,?,?,?)}";
$params_seAfter13holiday = array(
    array('return_after13', SQLSRV_PARAM_IN),
    array($vehicletransportplan, SQLSRV_PARAM_IN),
    array($result_seCompany['ID_Company'], SQLSRV_PARAM_IN),
    array($datevlin, SQLSRV_PARAM_IN),
);
$query_seAfter13holiday = sqlsrv_query($conn, $sql_seAfter13holiday, $params_seAfter13holiday);
$result_seAfter13holiday = sqlsrv_fetch_array($query_seAfter13holiday, SQLSRV_FETCH_ASSOC);
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>กลุ่มร่วมกิจรุ่งเรือง</title>
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
        <!--<link href="../dist/css/sb-admin-2.css" rel="stylesheet">-->
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        <style>
            .navbar-default {

                border-color: #ffcb0b;
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

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

                    <div class="navbar-header" >
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.html"><font style="color: #666"><img src="../images/logo.png" height="30"> <strong>กลุ่มร่วมกิจรุ่งเรือง</strong></font></a> 
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
                <div class="modal fade" id="modal_dirverdocrrc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document" style="width: 80%">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <h5 class="modal-title" id="title_copydiagram"><b>ค่าเที่ยวพนักงาน</b></h5>
                                    </div>

                                </div>
                            </div> 
                            <div class="modal-body">

                                <div id="dirverdocrrcsr"></div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal_dirverdocrcc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document" style="width: 80%">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <h5 class="modal-title" id="title_copydiagram"><b>ค่าเที่ยวพนักงาน</b></h5>
                                    </div>

                                </div>
                            </div> 
                            <div class="modal-body">

                                <div id="dirverdocrccsr"></div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal_addweight" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document" style="width: 80%">
                        <div class="modal-content" >
                            <div class="modal-header">
                                <h5 class="modal-title" id="title"><b>บัตรชั่ง</b></h5>
                            </div>
                            <div class="modal-body">
                                <?php
                                $condiWeigh = " AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "'";
                                $sql_seWeigh = "{call megVehicleweigh_v2(?,?)}";
                                $params_seWeigh = array(
                                    array('select_vehicleweigh', SQLSRV_PARAM_IN),
                                    array($condiWeigh, SQLSRV_PARAM_IN)
                                );
                                $query_seWeigh = sqlsrv_query($conn, $sql_seWeigh, $params_seWeigh);
                                $result_seWeigh = sqlsrv_fetch_array($query_seWeigh, SQLSRV_FETCH_ASSOC);
                                ?>

                                <div class="row" >
                                    <div class="col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                บัตรชั่ง
                                            </div>
                                            <!-- /.panel-heading -->
                                            <div class="panel-body">
                                                <div class="row" >
                                                    <div class="col-lg-3">
                                                        <label>เลือกลูกค้า :</label><br>
                                                        <select  id="cb_customer" name="cb_customer" class="form-control">
                                                            <?php
                                                            $condCustomer = $_POST['cluster'];
                                                            $sql_seCustomer = "{call megCustomer_v2(?,?)}";
                                                            $params_seCustomer = array(
                                                                array('select_customer', SQLSRV_PARAM_IN),
                                                                array('', SQLSRV_PARAM_IN)
                                                            );
                                                            $query_seCustomer = sqlsrv_query($conn, $sql_seCustomer, $params_seCustomer);
                                                            while ($result_seCustomer = sqlsrv_fetch_array($query_seCustomer, SQLSRV_FETCH_ASSOC)) {
                                                                $selected = "";
                                                                if ($result_seWeigh['CUSTOMECODE'] == $result_seCustomer['CUSTOMERCODE']) {
                                                                    $selected = "selected";
                                                                }
                                                                ?>
                                                                <option value="">เลือกลูกค้า</option>
                                                                <option value="<?= $result_seCustomer['CUSTOMERCODE'] ?>" <?= $selected ?>><?= $result_seCustomer['NAMETH'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label>บัตรชั่งเลขที่ :</label><br>
                                                        <input type="text"  name="txt_weighcardnumber"  id="txt_weighcardnumber" class="form-control"  value="<?= $result_seWeigh['WEIGHNUMBER'] ?>">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label>ทะเบียน :</label><br>
                                                        <?= $result_seWeigh['VEHICLEREGISNUMBER'] ?>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label>ประเภทสินค้า :</label><br>
                                                        <?= $result_seWeigh['PRODUCTTYPE'] ?>
                                                    </div>
                                                </div>
                                                <div class="row" >&nbsp;</div>
                                                <div class="row" >
                                                    <div class="col-lg-6">
                                                        <label>บริษัทที่ติดต่อ :</label><br>
                                                        <input type="text"  name="txt_connectcompany"  id="txt_connectcompany" class="form-control"  value="<?= $result_seWeigh['COMPANYCONTACT'] ?>">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>สินค้า :</label><br>
                                                        <input type="text"  name="txt_productname"  id="txt_productname" class="form-control"  value="<?= $result_seWeigh['PRODUCTNAME'] ?>">
                                                    </div>

                                                </div>
                                                <div class="row" >&nbsp;</div>
                                                <div class="row" >
                                                    <div class="col-lg-6">
                                                        <div class="panel panel-primary">
                                                            <div class="panel-heading">
                                                                <b>รถเข้า</b>
                                                            </div>
                                                            <div class="panel-body">

                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <table class="table table-striped table-bordered table-hover">
                                                                            <thead>

                                                                                <tr>

                                                                                    <th style="text-align: center;width: 50%"><font style="color: red">* </font> วันชั่งเข้า</th>
                                                                                    <th style="text-align: center;width: 50%"><font style="color: red">* </font> น้ำหนักชั่งเข้า</th>


                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>


                                                                                    <td style="text-align: center"> 
                                                                                        <input type="text"  name="txt_weighdatein"  id="txt_weighdatein" class="form-control datedef"  value="<?= $result_seWeigh['WEIGHDATEIN'] ?>">
                                                                                    </td>
                                                                                    <td style="text-align: center">
                                                                                        <input type="text"  name="txt_weighin1"  id="txt_weighin1" class="form-control"  value="<?= $result_seWeigh['WEIGHIN1'] ?>">
                                                                                    </td>

                                                                                </tr>


                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                            </div>



                                                        </div>
                                                        <!-- /.col-lg-4 -->
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="panel panel-primary">
                                                            <div class="panel-heading">
                                                                <b>รถออก</b>
                                                            </div>
                                                            <div class="panel-body">

                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <table class="table table-striped table-bordered table-hover">
                                                                            <thead>

                                                                                <tr>

                                                                                    <th style="text-align: center;width: 25%"> วันชั่งออก</th>
                                                                                    <th style="text-align: center;width: 25%"> น้ำหนักชั่งเข้า</th>
                                                                                    <th style="text-align: center;width: 25%"> น้ำหนักชั่งออก</th>
                                                                                    <th style="text-align: center;width: 25%"> น้ำหนักสุทธิ</th>


                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>


                                                                                    <td style="text-align: center"> 
                                                                                        <input type="text"  name="txt_weighdateout"  id="txt_weighdateout" class="form-control datedef"  value="<?= $result_seWeigh['WEIGHDATEOUT'] ?>">
                                                                                    </td>
                                                                                    <td style="text-align: center">
                                                                                        <input type="text"  name="txt_weighin2"  id="txt_weighin2" class="form-control"  value="<?= $result_seWeigh['WEIGHIN2'] ?>">
                                                                                    </td>
                                                                                    <td style="text-align: center"> 
                                                                                        <input type="text"  name="txt_weighout"  id="txt_weighout" class="form-control"  value="<?= $result_seWeigh['WEIGHOUT'] ?>">
                                                                                    </td>
                                                                                    <td style="text-align: center">
                                                                                        <input type="text"  name="txt_weighsum"  id="txt_weighsum" class="form-control"  value="<?= $result_seWeigh['WEIGHSUM'] ?>">
                                                                                    </td>

                                                                                </tr>


                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                            </div>



                                                        </div>
                                                        <!-- /.col-lg-4 -->
                                                    </div>
                                                </div>
                                                <!-- /.table-responsive -->
                                            </div>
                                            <!-- /.panel-body -->
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button"  onclick="save_vehicleweigh()" class="btn btn-primary">บันทึกข้อมูล</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal fade" id="modal_adddn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document" style="width: 80%">
                        <div id="datadef_actual"></div>
                        <div id="datasr_actual"></div>

                    </div>
                </div>

                <?php
                if ($_GET['type'] == 'transportplan') {
                    ?>

                    <div class="row"> 
                        &nbsp;</div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <?= $result_seEHR['nameT'] ?>
                                        </div>

                                        <?php
                                        if ($_SESSION["ROLENAME"] != "DRIVER") {
                                            ?>
                                            <div class="col-lg-1 text-right">
                                                <font style="color: red">* </font><label>พนักงาน :</label>

                                            </div>
                                            <div class="col-lg-2 text-right">

                                                <input type="text"  name="txt_employeename" id="txt_employeename" class="form-control">
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="col-lg-1 text-right">
                                                &nbsp;
                                            </div>
                                            <div class="col-lg-2 text-right">
                                                <input type="text"  name="txt_employeename" id="txt_employeename" value="<?= $result_seEHR['nameT'] ?>" class="form-control" style="display: none">
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div class="col-lg-2 text-right">
                                            <input type="text" name="txt_datestart"  readonly="" id="txt_datestart" onchange="datetodate();"  class="form-control datedef" value="<?= $result_seSystime['SYSDATE'] ?>">
                                        </div>
                                        <div class="col-lg-2 text-right">
                                            <input type="text" name="txt_dateend"  readonly="" id="txt_dateend" class="form-control datedef" value="<?= $result_seSystime['SYSDATE'] ?>">
                                        </div>
                                        <div class="col-lg-1 text-right">
                                            <button type="button" class="btn btn-default" onclick="select_compensation();">ค้นหา <li class="fa fa-search"></li></button>

                                        </div>

                                        <div class="col-lg-1 text-right">
                                            <a href="#" onclick="pdf_compensation1();" class="btn btn-default">ค่าตอบแทน <li class="fa fa-print"></li></a>

                                            <!--<a href="#" onclick="pdf_compensation2();" class="btn btn-default">ค่าอื่นๆ <li class="fa fa-print"></li></a>-->
                                        </div>
                                    </div>
                                </div>


                                <div class="panel-body">
                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                        <div class="row">

                                            <div class="col-sm-12">
                                                <div id="data_def">

                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                    <thead>
                                                        <tr role="row">
                                                            <th>รหัสพนักงาน</th>
                                                            <th>ชื่อ-นามสกุล</th>
                                                            <th>วันที่</th>
                                                            <th>เลข JOB</th>
                                                            <th>ค่าเที่ยว</th>
                                                            <th>ค่า OT</th>
                                                            <th>ค่าอาหาร</th>
                                                            <!--<th>ทำงานวันหยุด(กลับก่อน 13:00)</th>
                                                            <th>ทำงานวันหยุด(กลับหลัง 13:00)</th>-->
                                                            <th>รายได้รวม</th>
                                                            <th style="text-align: center;">ข้อมูลย่อย</th></tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        if ($_SESSION["ROLENAME"] != "ADMIN") {

                                                            if ($result_seEHR['PersonCode'] == $result_seVehicletransportplan2['EMPLOYEECODE1']) {
                                                                $condition1 = " AND (a.EMPLOYEECODE1 ='" . $result_seEHR['PersonCode'] . "') ";
                                                                $condition2 = " AND (CONVERT(DATE,a.DATEPRESENT) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103))";
                                                                $condition3 = "";

                                                                $sql_seVehicletransportplan1 = "{call megVehicletransportplan_v2(?,?,?,?)}";
                                                                $params_seVehicletransportplan1 = array(
                                                                    array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                                    array($condition1, SQLSRV_PARAM_IN),
                                                                    array($condition2, SQLSRV_PARAM_IN),
                                                                    array($condition3, SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seVehicletransportplan1 = sqlsrv_query($conn, $sql_seVehicletransportplan1, $params_seVehicletransportplan1);
                                                                while ($result_seVehicletransportplan1 = sqlsrv_fetch_array($query_seVehicletransportplan1, SQLSRV_FETCH_ASSOC)) {



                                                                    $condcompany = " AND Company_Code ='" . $result_seVehicletransportplan1['COMPANYCODE'] . "'";
                                                                    $sql_seCompany = "{call megCompanyEHR_v2(?,?)}";
                                                                    $params_seCompany = array(
                                                                        array('select_company', SQLSRV_PARAM_IN),
                                                                        array($condcompany, SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
                                                                    $result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);



                                                                    $sql_seCountholiday = "{call megHolidayEHR_v2(?,?,?,?)}";
                                                                    $params_seCountholiday = array(
                                                                        array('count_holiday', SQLSRV_PARAM_IN),
                                                                        array($result_seVehicletransportplan1['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                                                                        array($result_seCompany['ID_Company'], SQLSRV_PARAM_IN),
                                                                        array($result_seVehicletransportplan1['DATEVLIN'], SQLSRV_PARAM_IN),
                                                                    );
                                                                    $query_seCountholiday = sqlsrv_query($conn, $sql_seCountholiday, $params_seCountholiday);
                                                                    $result_seCountholiday = sqlsrv_fetch_array($query_seCountholiday, SQLSRV_FETCH_ASSOC);

                                                                    $sql_seStartholiday = "{call megHolidayEHR_v2(?,?,?,?)}";
                                                                    $params_seStartholiday = array(
                                                                        array('start_holidaywork', SQLSRV_PARAM_IN),
                                                                        array($result_seVehicletransportplan1['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                                                                        array($result_seCompany['ID_Company'], SQLSRV_PARAM_IN),
                                                                        array($result_seVehicletransportplan1['DATEVLIN'], SQLSRV_PARAM_IN),
                                                                    );
                                                                    $query_seStartholiday = sqlsrv_query($conn, $sql_seStartholiday, $params_seStartholiday);
                                                                    $result_seStartholiday = sqlsrv_fetch_array($query_seStartholiday, SQLSRV_FETCH_ASSOC);



                                                                    $sql_seBefore13holiday = "{call megHolidayEHR_v2(?,?,?,?)}";
                                                                    $params_seBefore13holiday = array(
                                                                        array('return_before13', SQLSRV_PARAM_IN),
                                                                        array($result_seVehicletransportplan1['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                                                                        array($result_seCompany['ID_Company'], SQLSRV_PARAM_IN),
                                                                        array($result_seVehicletransportplan1['DATEVLIN'], SQLSRV_PARAM_IN),
                                                                    );
                                                                    $query_seBefore13holiday = sqlsrv_query($conn, $sql_seBefore13holiday, $params_seBefore13holiday);
                                                                    $result_seBefore13holiday = sqlsrv_fetch_array($query_seBefore13holiday, SQLSRV_FETCH_ASSOC);

                                                                    $sql_seAfter13holiday = "{call megHolidayEHR_v2(?,?,?,?)}";
                                                                    $params_seAfter13holiday = array(
                                                                        array('return_after13', SQLSRV_PARAM_IN),
                                                                        array($result_seVehicletransportplan1['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                                                                        array($result_seCompany['ID_Company'], SQLSRV_PARAM_IN),
                                                                        array($result_seVehicletransportplan1['DATEVLIN'], SQLSRV_PARAM_IN),
                                                                    );
                                                                    $query_seAfter13holiday = sqlsrv_query($conn, $sql_seAfter13holiday, $params_seAfter13holiday);
                                                                    $result_seAfter13holiday = sqlsrv_fetch_array($query_seAfter13holiday, SQLSRV_FETCH_ASSOC);

                                                                    $conditionDN = " AND VEHICLETRANSPORTPLANID ='" . $result_seVehicletransportplan1['VEHICLETRANSPORTPLANID'] . "'";
                                                                    $sql_seDN = "{call megEditvehicletransportdocument_v2(?,?)}";
                                                                    $params_seDN = array(
                                                                        array('select_vehicletransportdocument', SQLSRV_PARAM_IN),
                                                                        array($conditionDN, SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_seDN = sqlsrv_query($conn, $sql_seDN, $params_seDN);
                                                                    $result_seDN = sqlsrv_fetch_array($query_seDN, SQLSRV_FETCH_ASSOC);
                                                                    $rsot = ($result_seDN['WARKINGSTOPINCOME'] == "" ? 1 : $result_seDN['WARKINGSTOPINCOME']);

                                                                    $sumincome = "";
                                                                    $ot = "";
                                                                    $befor13 = "";
                                                                    $affter13 = "";
                                                                    if ($result_seStartholiday['HOLIDAYWORK'] != '0') {
                                                                        $ot = (($result_seVehicletransportplan1['E1'] * $rsot) * 1.5) - $result_seVehicletransportplan1['E1'];
                                                                        if ($result_seBefore13holiday['HOLIDAYWORK'] != '0') {
                                                                            $sumincome = ($E1 + $ot + $C9 + $C5);
                                                                            $befor13 = $C5;
                                                                            $affter13 = "";
                                                                        } else if ($result_seAfter13holiday['HOLIDAYWORK'] != '0') {
                                                                            $sumincome = ($E1 + $ot + $C9 + $C6);
                                                                            $befor13 = "";
                                                                            $affter13 = $C6;
                                                                        }
                                                                    } else {
                                                                        //$sumincome = ($E1 + $C6 + $C9) * $rsot;
                                                                        //$ot = ($result_seVehicletransportplan1['E1'] * $rsot) - $result_seVehicletransportplan1['E1'];
                                                                        $ot = ($result_seVehicletransportplan1['E1'] - $result_seVehicletransportplan1['E1']);
                                                                        $sumincome = ($E1 + $C9);
                                                                    }
                                                                    ?>
                                                                    <tr class="gradeX odd" role="row">
                                                                        <td><?= $result_seVehicletransportplan1['EMPLOYEECODE1'] ?></td>
                                                                        <td><?= $result_seVehicletransportplan1['EMPLOYEENAME1'] ?></td>
                                                                        <td><?= $result_seVehicletransportplan1['DATEPRESENT'] ?></td>
                                                                        <td><?= $result_seVehicletransportplan1['JOBNO'] ?></td>
                                                                        <td><?= $result_seVehicletransportplan1['E1'] ?></td>
                                                                        <td><?= $ot ?></td>
                                                                        <td><?= $result_seVehicletransportplan1['C9'] ?></td>
                                                                        <!--<td><?//= $befor13 ?></td>
                                                                        <td><?//= $affter13 ?></td>-->
                                                                        <td><?= $sumincome ?></td>
                                                                        <td style="text-align: center">

                                                                                <div class="btn-group">
                                                                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                                        <i class="fa fa-chevron-down"></i>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu slidedown">

                                                                                        <li>
                                                                                            <?php
                                                                                            if ($result_seVehicletransportplan1['COMPANYCODE'] == 'RRC') {
                                                                                                ?>
                                                                                                <a href="#" onclick="dirverdocaddrrc('<?= $result_seVehicletransportplan1['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seVehicletransportplan1['COMPANYCODE'] ?>', '<?= $result_seVehicletransportplan1['EMPLOYEECODE1'] ?>', '<?= $result_seVehicletransportplan1['EMPLOYEENAME1'] ?>')" data-toggle="modal"  data-target="#modal_dirverdocrrc">เพิ่มค่าตอบแทน</a>
                                                                                                <?php
                                                                                            } else if ($result_seVehicletransportplan1['COMPANYCODE'] == 'RCC') {
                                                                                                ?>
                                                                                                <a href="#" onclick="dirverdocaddrcc('<?= $result_seVehicletransportplan1['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seVehicletransportplan1['COMPANYCODE'] ?>', '<?= $result_seVehicletransportplan1['EMPLOYEECODE1'] ?>', '<?= $result_seVehicletransportplan1['EMPLOYEENAME1'] ?>')" data-toggle="modal"  data-target="#modal_dirverdocrcc">เพิ่มค่าตอบแทน</a>
                                                                                                <?php
                                                                                            } else {
                                                                                                ?>
                                                                                                <a href="#">เพิ่มค่าตอบแทน</a>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </li>





                                                                                    </ul>
                                                                                </div>



                                                                            </td>


                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($result_seEHR['PersonCode'] == $result_seVehicletransportplan2['EMPLOYEECODE2']) {


                                                                    $condition12 = " AND (a.EMPLOYEECODE2 ='" . $result_seEHR['PersonCode'] . "') ";
                                                                    $condition22 = " AND (CONVERT(DATE,a.DATEPRESENT) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103))";
                                                                    $condition23 = "";
                                                                    $sql_seVehicletransportplan12 = "{call megVehicletransportplan_v2(?,?,?,?)}";
                                                                    $params_seVehicletransportplan12 = array(
                                                                        array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                                        array($condition12, SQLSRV_PARAM_IN),
                                                                        array($condition22, SQLSRV_PARAM_IN),
                                                                        array($condition23, SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_seVehicletransportplan12 = sqlsrv_query($conn, $sql_seVehicletransportplan12, $params_seVehicletransportplan12);
                                                                    while ($result_seVehicletransportplan12 = sqlsrv_fetch_array($query_seVehicletransportplan12, SQLSRV_FETCH_ASSOC)) {



                                                                        $E12 = $result_seVehicletransportplan12['E1'];
                                                                        $E32 = $result_seVehicletransportplan12['E3'];
                                                                        $E42 = $result_seVehicletransportplan12['E4'];
                                                                        $C12 = $result_seVehicletransportplan12['C1'];
                                                                        $C22 = $result_seVehicletransportplan12['C2'];
                                                                        $C32 = $result_seVehicletransportplan12['C3'];
                                                                        $C42 = $result_seVehicletransportplan12['C4'];
                                                                        $C52 = $result_seVehicletransportplan12['C5'];
                                                                        $C62 = $result_seVehicletransportplan12['C6'];
                                                                        $C92 = $result_seVehicletransportplan12['C9'];

                                                                        $condcompany2 = " AND Company_Code ='" . $result_seVehicletransportplan12['COMPANYCODE'] . "'";
                                                                        $sql_seCompany2 = "{call megCompanyEHR_v2(?,?)}";
                                                                        $params_seCompany2 = array(
                                                                            array('select_company', SQLSRV_PARAM_IN),
                                                                            array($condcompany2, SQLSRV_PARAM_IN)
                                                                        );
                                                                        $query_seCompany2 = sqlsrv_query($conn, $sql_seCompany2, $params_seCompany2);
                                                                        $result_seCompany2 = sqlsrv_fetch_array($query_seCompany2, SQLSRV_FETCH_ASSOC);



                                                                        $sql_seCountholiday2 = "{call megHolidayEHR_v2(?,?,?,?)}";
                                                                        $params_seCountholiday2 = array(
                                                                            array('count_holiday', SQLSRV_PARAM_IN),
                                                                            array($result_seVehicletransportplan12['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                                                                            array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                                                                            array($result_seVehicletransportplan12['DATEVLIN'], SQLSRV_PARAM_IN),
                                                                        );
                                                                        $query_seCountholiday2 = sqlsrv_query($conn, $sql_seCountholiday2, $params_seCountholiday2);
                                                                        $result_seCountholiday2 = sqlsrv_fetch_array($query_seCountholiday2, SQLSRV_FETCH_ASSOC);

                                                                        $sql_seStartholiday2 = "{call megHolidayEHR_v2(?,?,?,?)}";
                                                                        $params_seStartholiday2 = array(
                                                                            array('start_holidaywork', SQLSRV_PARAM_IN),
                                                                            array($result_seVehicletransportplan12['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                                                                            array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                                                                            array($result_seVehicletransportplan12['DATEVLIN'], SQLSRV_PARAM_IN),
                                                                        );
                                                                        $query_seStartholiday2 = sqlsrv_query($conn, $sql_seStartholiday2, $params_seStartholiday2);
                                                                        $result_seStartholiday2 = sqlsrv_fetch_array($query_seStartholiday2, SQLSRV_FETCH_ASSOC);



                                                                        $sql_seBefore13holiday2 = "{call megHolidayEHR_v2(?,?,?,?)}";
                                                                        $params_seBefore13holiday2 = array(
                                                                            array('return_before13', SQLSRV_PARAM_IN),
                                                                            array($result_seVehicletransportplan12['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                                                                            array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                                                                            array($result_seVehicletransportplan12['DATEVLIN'], SQLSRV_PARAM_IN),
                                                                        );
                                                                        $query_seBefore13holiday2 = sqlsrv_query($conn, $sql_seBefore13holiday2, $params_seBefore13holiday2);
                                                                        $result_seBefore13holiday2 = sqlsrv_fetch_array($query_seBefore13holiday2, SQLSRV_FETCH_ASSOC);

                                                                        $sql_seAfter13holiday2 = "{call megHolidayEHR_v2(?,?,?,?)}";
                                                                        $params_seAfter13holiday2 = array(
                                                                            array('return_after13', SQLSRV_PARAM_IN),
                                                                            array($result_seVehicletransportplan12['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                                                                            array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                                                                            array($result_seVehicletransportplan12['DATEVLIN'], SQLSRV_PARAM_IN),
                                                                        );
                                                                        $query_seAfter13holiday2 = sqlsrv_query($conn, $sql_seAfter13holiday2, $params_seAfter13holiday2);
                                                                        $result_seAfter13holiday2 = sqlsrv_fetch_array($query_seAfter13holiday2, SQLSRV_FETCH_ASSOC);


                                                                        $conditionDN2 = " AND VEHICLETRANSPORTPLANID ='" . $result_seVehicletransportplan12['VEHICLETRANSPORTPLANID'] . "'";
                                                                        $sql_seDN2 = "{call megEditvehicletransportdocument_v2(?,?)}";
                                                                        $params_seDN2 = array(
                                                                            array('select_vehicletransportdocument', SQLSRV_PARAM_IN),
                                                                            array($conditionDN2, SQLSRV_PARAM_IN)
                                                                        );
                                                                        $query_seDN2 = sqlsrv_query($conn, $sql_seDN2, $params_seDN2);
                                                                        $result_seDN2 = sqlsrv_fetch_array($query_seDN2, SQLSRV_FETCH_ASSOC);

                                                                        $sumincome2 = "";
                                                                        $ot2 = "";
                                                                        $befor13 = "";
                                                                        $affter13 = "";
                                                                        $rsot2 = ($result_seDN2['WARKINGSTOPINCOME'] == "" ? 1 : $result_seDN2['WARKINGSTOPINCOME']);
                                                                        if ($result_seStartholiday2['HOLIDAYWORK'] != '0') {
                                                                            $ot2 = (($result_seVehicletransportplan12['E1'] * $rsot2) * 1.5) - $result_seVehicletransportplan12['E1'];
                                                                            if ($result_seBefore13holiday2['HOLIDAYWORK'] != '0') {
                                                                                $sumincome2 = ($E12 + $ot2 + $C92 + $C52);
                                                                                $befor13 = $C52;
                                                                                $affter13 = "";
                                                                            } else if ($result_seAfter13holiday2['HOLIDAYWORK'] != '0') {
                                                                                $sumincome2 = ($E12 + $ot2 + $C92 + $C62);
                                                                                $befor13 = "";
                                                                                $affter13 = $C62;
                                                                            }
                                                                        } else {
                                                                            //$sumincome = ($E1 + $C6 + $C9) * $rsot;
                                                                            $sumincome2 = ($E12 + $C92);
                                                                            //$ot = ($result_seVehicletransportplan1['E1']*$rsot)-$result_seVehicletransportplan1['E1'];
                                                                            $ot2 = ($result_seVehicletransportplan12['E1'] - $result_seVehicletransportplan12['E1']);
                                                                        }
                                                                        ?>



                                                                        <tr class="gradeX odd" role="row">
                                                                            <td><?= $result_seVehicletransportplan12['EMPLOYEECODE2'] ?></td>
                                                                            <td><?= $result_seVehicletransportplan12['EMPLOYEENAME2'] ?></td>
                                                                            <td><?= $result_seVehicletransportplan12['DATEPRESENT'] ?></td>
                                                                            <td><?= $result_seVehicletransportplan12['JOBNO'] ?></td>
                                                                            <td><?= $result_seVehicletransportplan12['E1'] ?></td>
                                                                            <td><?= $ot2 ?></td>
                                                                            <td><?= $result_seVehicletransportplan12['C9'] ?></td>
                                                                            <!--<td><?//= $befor13 ?></td>
                                                                            <td><?//= $affter13 ?></td>-->
                                                                            <td><?= $sumincome2 ?></td>
                                                                            <td style="text-align: center">

                                                                                <div class="btn-group">
                                                                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                                        <i class="fa fa-chevron-down"></i>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu slidedown">

                                                                                        <li>
                                                                                            <a href="meg_employee5.php?type=compdirver&vehicletransportplanid=<?= $result_seVehicletransportplan12['VEHICLETRANSPORTPLANID'] ?>&employeecode=<?= $result_seVehicletransportplan12['EMPLOYEECODE2'] ?>">จัดการข้อมูล</a>
                                                                                        </li>


                                                                                    </ul>
                                                                                </div>


                                                                            </td>


                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                            } else {
                                                                $condition12 = " AND (CONVERT(DATE,a.DATEPRESENT) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103))";
                                                                $condition22 = "";
                                                                $condition23 = "";
                                                                $sql_seVehicletransportplan12 = "{call megVehicletransportplan_v2(?,?,?,?)}";
                                                                $params_seVehicletransportplan12 = array(
                                                                    array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                                    array($condition12, SQLSRV_PARAM_IN),
                                                                    array($condition22, SQLSRV_PARAM_IN),
                                                                    array($condition23, SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seVehicletransportplan12 = sqlsrv_query($conn, $sql_seVehicletransportplan12, $params_seVehicletransportplan12);
                                                                while ($result_seVehicletransportplan12 = sqlsrv_fetch_array($query_seVehicletransportplan12, SQLSRV_FETCH_ASSOC)) {



                                                                    $E12 = $result_seVehicletransportplan12['E1'];
                                                                    $E32 = $result_seVehicletransportplan12['E3'];
                                                                    $E42 = $result_seVehicletransportplan12['E4'];
                                                                    $C12 = $result_seVehicletransportplan12['C1'];
                                                                    $C22 = $result_seVehicletransportplan12['C2'];
                                                                    $C32 = $result_seVehicletransportplan12['C3'];
                                                                    $C42 = $result_seVehicletransportplan12['C4'];
                                                                    $C52 = $result_seVehicletransportplan12['C5'];
                                                                    $C62 = $result_seVehicletransportplan12['C6'];
                                                                    $C92 = $result_seVehicletransportplan12['C9'];

                                                                    $condcompany2 = " AND Company_Code ='" . $result_seVehicletransportplan12['COMPANYCODE'] . "'";
                                                                    $sql_seCompany2 = "{call megCompanyEHR_v2(?,?)}";
                                                                    $params_seCompany2 = array(
                                                                        array('select_company', SQLSRV_PARAM_IN),
                                                                        array($condcompany2, SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_seCompany2 = sqlsrv_query($conn, $sql_seCompany2, $params_seCompany2);
                                                                    $result_seCompany2 = sqlsrv_fetch_array($query_seCompany2, SQLSRV_FETCH_ASSOC);



                                                                    $sql_seCountholiday2 = "{call megHolidayEHR_v2(?,?,?,?)}";
                                                                    $params_seCountholiday2 = array(
                                                                        array('count_holiday', SQLSRV_PARAM_IN),
                                                                        array($result_seVehicletransportplan12['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                                                                        array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                                                                        array($result_seVehicletransportplan12['DATEVLIN'], SQLSRV_PARAM_IN),
                                                                    );
                                                                    $query_seCountholiday2 = sqlsrv_query($conn, $sql_seCountholiday2, $params_seCountholiday2);
                                                                    $result_seCountholiday2 = sqlsrv_fetch_array($query_seCountholiday2, SQLSRV_FETCH_ASSOC);

                                                                    $sql_seStartholiday2 = "{call megHolidayEHR_v2(?,?,?,?)}";
                                                                    $params_seStartholiday2 = array(
                                                                        array('start_holidaywork', SQLSRV_PARAM_IN),
                                                                        array($result_seVehicletransportplan12['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                                                                        array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                                                                        array($result_seVehicletransportplan12['DATEVLIN'], SQLSRV_PARAM_IN),
                                                                    );
                                                                    $query_seStartholiday2 = sqlsrv_query($conn, $sql_seStartholiday2, $params_seStartholiday2);
                                                                    $result_seStartholiday2 = sqlsrv_fetch_array($query_seStartholiday2, SQLSRV_FETCH_ASSOC);



                                                                    $sql_seBefore13holiday2 = "{call megHolidayEHR_v2(?,?,?,?)}";
                                                                    $params_seBefore13holiday2 = array(
                                                                        array('return_before13', SQLSRV_PARAM_IN),
                                                                        array($result_seVehicletransportplan12['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                                                                        array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                                                                        array($result_seVehicletransportplan12['DATEVLIN'], SQLSRV_PARAM_IN),
                                                                    );
                                                                    $query_seBefore13holiday2 = sqlsrv_query($conn, $sql_seBefore13holiday2, $params_seBefore13holiday2);
                                                                    $result_seBefore13holiday2 = sqlsrv_fetch_array($query_seBefore13holiday2, SQLSRV_FETCH_ASSOC);

                                                                    $sql_seAfter13holiday2 = "{call megHolidayEHR_v2(?,?,?,?)}";
                                                                    $params_seAfter13holiday2 = array(
                                                                        array('return_after13', SQLSRV_PARAM_IN),
                                                                        array($result_seVehicletransportplan12['VEHICLETRANSPORTPLANID'], SQLSRV_PARAM_IN),
                                                                        array($result_seCompany2['ID_Company'], SQLSRV_PARAM_IN),
                                                                        array($result_seVehicletransportplan12['DATEVLIN'], SQLSRV_PARAM_IN),
                                                                    );
                                                                    $query_seAfter13holiday2 = sqlsrv_query($conn, $sql_seAfter13holiday2, $params_seAfter13holiday2);
                                                                    $result_seAfter13holiday2 = sqlsrv_fetch_array($query_seAfter13holiday2, SQLSRV_FETCH_ASSOC);


                                                                    $conditionDN2 = " AND VEHICLETRANSPORTPLANID ='" . $result_seVehicletransportplan12['VEHICLETRANSPORTPLANID'] . "'";
                                                                    $sql_seDN2 = "{call megEditvehicletransportdocument_v2(?,?)}";
                                                                    $params_seDN2 = array(
                                                                        array('select_vehicletransportdocument', SQLSRV_PARAM_IN),
                                                                        array($conditionDN2, SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_seDN2 = sqlsrv_query($conn, $sql_seDN2, $params_seDN2);
                                                                    $result_seDN2 = sqlsrv_fetch_array($query_seDN2, SQLSRV_FETCH_ASSOC);

                                                                    $sumincome2 = "";
                                                                    $ot2 = "";
                                                                    $befor13 = "";
                                                                    $affter13 = "";
                                                                    $rsot2 = ($result_seDN2['WARKINGSTOPINCOME'] == "" ? 1 : $result_seDN2['WARKINGSTOPINCOME']);
                                                                    if ($result_seStartholiday2['HOLIDAYWORK'] != '0') {
                                                                        $ot2 = (($result_seVehicletransportplan12['E1'] * $rsot2) * 1.5) - $result_seVehicletransportplan12['E1'];
                                                                        if ($result_seBefore13holiday2['HOLIDAYWORK'] != '0') {
                                                                            $sumincome2 = ($E12 + $ot2 + $C92 + $C52);
                                                                            $befor13 = $C52;
                                                                            $affter13 = "";
                                                                        } else if ($result_seAfter13holiday2['HOLIDAYWORK'] != '0') {
                                                                            $sumincome2 = ($E12 + $ot2 + $C92 + $C62);
                                                                            $befor13 = "";
                                                                            $affter13 = $C62;
                                                                        }
                                                                    } else {
                                                                        //$sumincome = ($E1 + $C6 + $C9) * $rsot;
                                                                        $sumincome2 = ($E12 + $C92);
                                                                        //$ot = ($result_seVehicletransportplan1['E1']*$rsot)-$result_seVehicletransportplan1['E1'];
                                                                        $ot2 = ($result_seVehicletransportplan12['E1'] - $result_seVehicletransportplan12['E1']);
                                                                    }
                                                                    ?>




                                                                    <?php
                                                                    if ($result_seVehicletransportplan12['EMPLOYEECODE1'] != "") {
                                                                        ?>
                                                                        <tr class="gradeX odd" role="row">
                                                                            <td><?= $result_seVehicletransportplan12['EMPLOYEECODE1'] ?></td>
                                                                            <td><?= $result_seVehicletransportplan12['EMPLOYEENAME1'] ?></td>
                                                                            <td><?= $result_seVehicletransportplan12['DATEPRESENT'] ?></td>
                                                                            <td><?= $result_seVehicletransportplan12['JOBNO'] ?></td>
                                                                            <td><?= $result_seVehicletransportplan12['E1'] ?></td>
                                                                            <td><?= $ot2 ?></td>
                                                                            <td><?= $result_seVehicletransportplan12['C9'] ?></td>
                                                                            <!--<td><?//= $befor13 ?></td>
                                                                            <td><?//= $affter13 ?></td>-->
                                                                            <td><?= $sumincome2 ?></td>
                                                                            <td style="text-align: center">

                                                                                <div class="btn-group">
                                                                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                                        <i class="fa fa-chevron-down"></i>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu slidedown">

                                                                                        <li>
                                                                                            <?php
                                                                                            if ($result_seVehicletransportplan12['COMPANYCODE'] == 'RRC') {
                                                                                                ?>
                                                                                                <a href="#" onclick="dirverdocaddrrc('<?= $result_seVehicletransportplan12['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seVehicletransportplan12['COMPANYCODE'] ?>', '<?= $result_seVehicletransportplan12['EMPLOYEECODE1'] ?>', '<?= $result_seVehicletransportplan12['EMPLOYEENAME1'] ?>')" data-toggle="modal"  data-target="#modal_dirverdocrrc">เพิ่มค่าตอบแทน</a>
                                                                                                <?php
                                                                                            } else if ($result_seVehicletransportplan12['COMPANYCODE'] == 'RCC') {
                                                                                                ?>
                                                                                                <a href="#" onclick="dirverdocaddrcc('<?= $result_seVehicletransportplan12['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seVehicletransportplan12['COMPANYCODE'] ?>', '<?= $result_seVehicletransportplan12['EMPLOYEECODE1'] ?>', '<?= $result_seVehicletransportplan12['EMPLOYEENAME1'] ?>')" data-toggle="modal"  data-target="#modal_dirverdocrcc">เพิ่มค่าตอบแทน</a>
                                                                                                <?php
                                                                                            } else {
                                                                                                ?>
                                                                                                <a href="#">เพิ่มค่าตอบแทน</a>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </li>





                                                                                    </ul>
                                                                                </div>


                                                                            </td>


                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    if ($result_seVehicletransportplan12['EMPLOYEECODE2'] != "") {
                                                                        ?>
                                                                        <tr class="gradeX odd" role="row">
                                                                            <td><?= $result_seVehicletransportplan12['EMPLOYEECODE2'] ?></td>
                                                                            <td><?= $result_seVehicletransportplan12['EMPLOYEENAME2'] ?></td>
                                                                            <td><?= $result_seVehicletransportplan12['DATEPRESENT'] ?></td>
                                                                            <td><?= $result_seVehicletransportplan12['JOBNO'] ?></td>
                                                                            <td><?= $result_seVehicletransportplan12['E1'] ?></td>
                                                                            <td><?= $ot2 ?></td>
                                                                            <td><?= $result_seVehicletransportplan12['C9'] ?></td>
                                                                            <!--<td><?//= $befor13 ?></td>
                                                                            <td><?//= $affter13 ?></td>-->
                                                                            <td><?= $sumincome2 ?></td>
                                                                            <td style="text-align: center">

                                                                                <div class="btn-group">
                                                                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                                        <i class="fa fa-chevron-down"></i>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu slidedown">

                                                                                        <li>
                                                                                            <?php
                                                                                            if ($result_seVehicletransportplan12['COMPANYCODE'] == 'RRC') {
                                                                                                ?>
                                                                                                <a href="#" onclick="dirverdocaddrrc('<?= $result_seVehicletransportplan12['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seVehicletransportplan12['COMPANYCODE'] ?>', '<?= $result_seVehicletransportplan12['EMPLOYEECODE1'] ?>', '<?= $result_seVehicletransportplan12['EMPLOYEENAME1'] ?>')" data-toggle="modal"  data-target="#modal_dirverdocrrc">เพิ่มค่าตอบแทน</a>
                                                                                                <?php
                                                                                            } else if ($result_seVehicletransportplan12['COMPANYCODE'] == 'RCC') {
                                                                                                ?>
                                                                                                <a href="#" onclick="dirverdocaddrcc('<?= $result_seVehicletransportplan12['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seVehicletransportplan12['COMPANYCODE'] ?>', '<?= $result_seVehicletransportplan12['EMPLOYEECODE1'] ?>', '<?= $result_seVehicletransportplan12['EMPLOYEENAME1'] ?>')" data-toggle="modal"  data-target="#modal_dirverdocrcc">เพิ่มค่าตอบแทน</a>
                                                                                                <?php
                                                                                            } else {
                                                                                                ?>
                                                                                                <a href="#">เพิ่มค่าตอบแทน</a>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </li>





                                                                                    </ul>
                                                                                </div>


                                                                            </td>


                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div id="data_sr">

                                                </div>


                                            </div>
                                            <!-- /.panel-body -->
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } else if ($_GET['type'] == 'compensation') {

                    if (substr($jobend, 0, 3) == 'RRC') {

                        $condVehicledocumentrrc = " AND VEHICLETRANSPORTPLANID ='" . $_GET['vehicletransportplanid'] . "' AND DRIVERCODE ='" . $_GET['employeecode'] . "'";
                        $sql_seVehicledocumentrrc = "{call megVehicletransportdocumentrrc_v2(?,?)}";
                        $params_seVehicledocumentrrc = array(
                            array('select_vehicletransportdocumentrrc', SQLSRV_PARAM_IN),
                            array($condVehicledocumentrrc, SQLSRV_PARAM_IN)
                        );
                        $query_seVehicledocumentrrc = sqlsrv_query($conn, $sql_seVehicledocumentrrc, $params_seVehicledocumentrrc);
                        $result_seVehicledocumentrrc = sqlsrv_fetch_array($query_seVehicledocumentrrc, SQLSRV_FETCH_ASSOC);




                        $checkprojectttast = ($result_seVehicledocumentrrc['PROJECTNAME'] == 'TTAST') ? "checked" : "";
                        $checkprojectother = ($result_seVehicledocumentrrc['PROJECTNAME'] != 'TTAST') ? "checked" : "";
                        $checkcompanysab = ($result_seVehicledocumentrrc['COMPANYNAME'] == 'SAB') ? "checked" : "";
                        $checkcompanyynp = ($result_seVehicledocumentrrc['COMPANYNAME'] == 'YNP') ? "checked" : "";
                        $checkcompanych = ($result_seVehicledocumentrrc['COMPANYNAME'] == 'CH') ? "checked" : "";
                        $checkcompanytoy = ($result_seVehicledocumentrrc['COMPANYNAME'] == 'TOY') ? "checked" : "";
                        $checkcompanyhino = ($result_seVehicledocumentrrc['COMPANYNAME'] == 'HINO') ? "checked" : "";
                        $checkcompanyotc = ($result_seVehicledocumentrrc['COMPANYNAME'] == 'OTC') ? "checked" : "";
                        $checkcompanytsa = ($result_seVehicledocumentrrc['COMPANYNAME'] == 'TSA') ? "checked" : "";
                        $checkcompanyother = ($result_seVehicledocumentrrc['COMPANYNAME'] == 'SAB' || $result_seVehicledocumentrrc['COMPANYNAME'] == 'YNP' || $result_seVehicledocumentrrc['COMPANYNAME'] == 'CH' || $result_seVehicledocumentrrc['COMPANYNAME'] == 'TOY' || $result_seVehicledocumentrrc['COMPANYNAME'] == 'HINO' || $result_seVehicledocumentrrc['COMPANYNAME'] == 'OTC' || $result_seVehicledocumentrrc['COMPANYNAME'] == 'TSA') ? "" : "checked";
                        $checkworkingd = ($result_seVehicledocumentrrc['WORKING'] == 'D') ? "checked" : "";
                        $checkworkingn = ($result_seVehicledocumentrrc['WORKING'] == 'N') ? "checked" : "";
                        $checkuniformcompany = ($result_seVehicledocumentrrc['UNIFORMCOMPANYDATA'] == 'แต่งกายด้วยชุดฟอร์มของบริษัทฯ') ? "checked" : "";
                        $checkuniformsafety = ($result_seVehicledocumentrrc['UNIFORMSAFETYDATA'] == 'ใส่อุปกรณ์เซฟตี้ทุกครั้งขณะปฏิบัติงาน') ? "checked" : "";
                        $checkvehicle = ($result_seVehicledocumentrrc['VEHICLEDATA'] == 'ตรวจเช็คสภาพความพร้อมของรถก่อนใช้งาน') ? "checked" : "";
                        $checkregularity = ($result_seVehicledocumentrrc['REGULARITYDATA'] == 'ปฏิบัติตามกฏระเบียบของลูกค้าอย่างเคร่งครัด') ? "checked" : "";
                        $checkconditionok1 = ($result_seVehicledocumentrrc['BEGIN_CONDITION1'] == '1') ? "checked" : "";
                        $checkconditionno1 = ($result_seVehicledocumentrrc['BEGIN_CONDITION1'] == '0') ? "checked" : "";
                        $checkconditionok2 = ($result_seVehicledocumentrrc['BEGIN_CONDITION2'] == '1') ? "checked" : "";
                        $checkconditionno2 = ($result_seVehicledocumentrrc['BEGIN_CONDITION2'] == '0') ? "checked" : "";
                        $checkconditionok3 = ($result_seVehicledocumentrrc['BEGIN_CONDITION3'] == '1') ? "checked" : "";
                        $checkconditionno3 = ($result_seVehicledocumentrrc['BEGIN_CONDITION3'] == '0') ? "checked" : "";
                        $checkconditionok4 = ($result_seVehicledocumentrrc['BEGIN_CONDITION4'] == '1') ? "checked" : "";
                        $checkconditionno4 = ($result_seVehicledocumentrrc['BEGIN_CONDITION4'] == '0') ? "checked" : "";
                        $checkconditionok5 = ($result_seVehicledocumentrrc['BEGIN_CONDITION5'] == '1') ? "checked" : "";
                        $checkconditionno5 = ($result_seVehicledocumentrrc['BEGIN_CONDITION5'] == '0') ? "checked" : "";
                        $checkconditionok6 = ($result_seVehicledocumentrrc['BEGIN_CONDITION6'] == '1') ? "checked" : "";
                        $checkconditionno6 = ($result_seVehicledocumentrrc['BEGIN_CONDITION6'] == '0') ? "checked" : "";
                        $checkconditionok7 = ($result_seVehicledocumentrrc['BEGIN_CONDITION7'] == '1') ? "checked" : "";
                        $checkconditionno7 = ($result_seVehicledocumentrrc['BEGIN_CONDITION7'] == '0') ? "checked" : "";
                        $checkconditionok8 = ($result_seVehicledocumentrrc['BEGIN_CONDITION8'] == '1') ? "checked" : "";
                        $checkconditionno8 = ($result_seVehicledocumentrrc['BEGIN_CONDITION8'] == '0') ? "checked" : "";
                        $checkconditionok9 = ($result_seVehicledocumentrrc['BEGIN_CONDITION9'] == '1') ? "checked" : "";
                        $checkconditionno9 = ($result_seVehicledocumentrrc['BEGIN_CONDITION9'] == '0') ? "checked" : "";
                        $checkconditionok10 = ($result_seVehicledocumentrrc['BEGIN_CONDITION10'] == '1') ? "checked" : "";
                        $checkconditionno10 = ($result_seVehicledocumentrrc['BEGIN_CONDITION10'] == '0') ? "checked" : "";
                        $checkconditionok11 = ($result_seVehicledocumentrrc['BEGIN_CONDITION11'] == '1') ? "checked" : "";
                        $checkconditionno11 = ($result_seVehicledocumentrrc['BEGIN_CONDITION11'] == '0') ? "checked" : "";
                        $checkconditionok12 = ($result_seVehicledocumentrrc['BEGIN_CONDITION12'] == '1') ? "checked" : "";
                        $checkconditionno12 = ($result_seVehicledocumentrrc['BEGIN_CONDITION12'] == '0') ? "checked" : "";
                        $checkconditionok13 = ($result_seVehicledocumentrrc['BEGIN_CONDITION13'] == '1') ? "checked" : "";
                        $checkconditionno13 = ($result_seVehicledocumentrrc['BEGIN_CONDITION13'] == '0') ? "checked" : "";
                        $checkconditionok14 = ($result_seVehicledocumentrrc['BEGIN_CONDITION14'] == '1') ? "checked" : "";
                        $checkconditionno14 = ($result_seVehicledocumentrrc['BEGIN_CONDITION14'] == '0') ? "checked" : "";
                        $checkconditionok15 = ($result_seVehicledocumentrrc['BEGIN_CONDITION15'] == '1') ? "checked" : "";
                        $checkconditionno15 = ($result_seVehicledocumentrrc['BEGIN_CONDITION15'] == '0') ? "checked" : "";
                        ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">

                                        <a href="meg_employee5.php?type=transportplan">รายการวิ่งงาน</a> / <?= $jobend ?></div>


                                    <div class="panel-body">
                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <?php
                                                    if ($_SESSION["ROLENAME"] != "DRIVER") {
                                                        ?>

                                                        <?php
                                                    } else {
                                                        ?>
                                                        <li><?= $result_seEHR['Company_NameT'] ?> / <?= $result_seEHR['Company_NameE'] ?></li>
                                                        <?php
                                                    }
                                                    ?>


                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 text-left"><br>ชื่อ...<?= $employeename ?>...รหัส...<?= $employeecode ?>...</div>
                                                <div class="col-sm-6" align="right">

                                                    <button  type="button" class="btn btn-default btn-circle" data-toggle="modal" data-target="#modal_addweight" >เพิ่มบัตรชั่ง <p class="fa fa-truck"></p></button>
                                                </div>
                                            </div>
                                            <div class="row">&nbsp;</div>
                                            <div class="row">

                                                <div class="col-sm-12">
                                                    <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
                                                    <thead>

                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><img src="../images/logo.png" height="30"></th>
                                                            <th colspan="5"  style="border-right:1px solid #000;padding:4px;text-align:center;">TRANSPORT GOODS TIME FOR TTAST</th>
                                                            <th colspan="10"  style="border-right:1px solid #000;padding:4px;text-align:center;">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด / 109 / 1 ม.9 ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190 Tel : 038-589225 Fax : 038-086720</th>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;" >
                                                            <th  bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;"><input  type="checkbox" <?= $checkprojectttast ?> id="chk_projectttast"  onchange="chk_projectttast()" disabled=""/>
                                                                Project :</th>
                                                            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">
                                                                TTAST</th>
                                                            <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" <?= $checkprojectother ?> id="chk_projectother" disabled=""  />
                                                                Other :</th>
                                                            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;" >
                                                                <input type="text" id="txt_projectother" class="form-control" value="<?= ($result_seVehicledocumentrrc['PROJECTNAME'] == "TTAST") ? "" : $result_seVehicledocumentrrc['PROJECTNAME']; ?>" onchange="txt_projectother(this.value)" disabled="">
                                                            </th>
                                                            <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">การทำงาน</th>
                                                            <th colspan="4" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">พขร.</th>
                                                            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ทะเบียน</th>
                                                            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">วัน-เดือน-ปี</th>
                                                            <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">JOBNO</th>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <th colspan="4"  style="border-right:1px solid #000;padding:4px;text-align:left;">
                                                                <input type="checkbox" <?= $checkcompanysab ?> id="chk_compsab" onchange="chk_compsab()" disabled=""/>
                                                                SAB &nbsp;
                                                                <input type="checkbox" <?= $checkcompanyynp ?> id="chk_compynp"  onchange="chk_compynp()" disabled=""/>
                                                                YNP &nbsp;
                                                                <input type="checkbox" <?= $checkcompanych ?> id="chk_compch" onchange="chk_compch()" disabled=""/>
                                                                CH &nbsp;
                                                                <input type="checkbox" <?= $checkcompanytoy ?> id="chk_comptoy" onchange="chk_comptoy()" disabled=""/>
                                                                TOY &nbsp;
                                                                <input type="checkbox" <?= $checkcompanyhino ?> id="chk_comphino" onchange="chk_comphino()" disabled=""/>
                                                                HINO &nbsp;
                                                                <input type="checkbox" <?= $checkcompanyotc ?> id="chk_compotc" onchange="chk_compotc()" disabled=""/>
                                                                OTC &nbsp;
                                                                <input type="checkbox" <?= $checkcompanytsa ?> id="chk_comptsa" onchange="chk_comptsa()" disabled=""/>
                                                                TSA &nbsp;
                                                                <input type="checkbox" <?= $checkcompanyother ?> id="chk_compother"  disabled=""/>
                                                                อื่นๆ</th>
                                                            <th colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">
                                                                <input type="text" id="txt_companyother" class="form-control"  value="<?=
                                                                ($result_seVehicledocumentrrc['COMPANYNAME'] == "SAB" || $result_seVehicledocumentrrc['COMPANYNAME'] == "YNP" || $result_seVehicledocumentrrc['COMPANYNAME'] == "CH" || $result_seVehicledocumentrrc['COMPANYNAME'] == "TOY" || $result_seVehicledocumentrrc['COMPANYNAME'] == "HINO" || $result_seVehicledocumentrrc['COMPANYNAME'] == "OTC" || $result_seVehicledocumentrrc['COMPANYNAME'] == "TSA"
                                                                ) ? "" : $result_seVehicledocumentrrc['COMPANYNAME'];
                                                                ?>" onchange="txt_companyother(this.value)" disabled="">

                                                            </th>

                                                            <th  style="border-right:1px solid #000;padding:4px;text-align:center;">

                                                                <input type="checkbox" <?= $checkworkingd ?> id="chk_workd" onchange="chk_workd()" disabled=""/>
                                                                D&nbsp;
                                                                <input type="checkbox" <?= $checkworkingn ?> id="chk_workn" onchange="chk_workn()" disabled=""/>
                                                                N</th>
                                                            <th colspan="4"  style="border-right:1px solid #000;padding:4px;text-align:center;">นาย <?= $employeename ?></th>
                                                            <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seVehicletransportplan2['VEHICLEREGISNUMBER1'] ?></th>
                                                            <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seVehicledocumentrrc['WORKINGDATE'] ?></th>
                                                            <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seVehicletransportplan2['JOBNO'] ?></th>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <th  style="border-right:1px solid #000;padding:4px;text-align:center;">
                                                                <input type="checkbox" id="chk_uniformcompany" onchange="chk_uniformcompany()" <?= $checkuniformcompany ?> disabled=""/>        
                                                            </th>
                                                            <th colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:left;">แต่งกายด้วยชุดฟอร์มของบริษัทฯ</th>
                                                            <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_uniformsafety" <?= $checkuniformsafety ?> onchange="chk_uniformsafety()" disabled="" /></th>
                                                            <th colspan="4"  style="border-right:1px solid #000;padding:4px;text-align:left;">ใส่อุปกรณ์เซฟตี้ทุกครั้งขณะปฏิบัติงาน</th>
                                                            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมล์ก่อนออก</th>
                                                            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมล์เสร็จ</th>
                                                            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">น้ำมัน (ลิตร)</th>
                                                            <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">รวม (กม)</th>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_vehicle" <?= $checkuniformsafety ?> onchange="chk_vehicle()" disabled="" /></th>
                                                            <th colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คสภาพความพร้อมของรถก่อนใช้งาน</th>
                                                            <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_regularity" onchange="chk_regularity()" <?= $checkregularity ?> disabled="" /></th>
                                                            <th colspan="4"  style="border-right:1px solid #000;padding:4px;text-align:left;">ปฏิบัติตามกฏระเบียบของลูกค้าอย่างเคร่งครัด</th>
                                                            <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;" contenteditable="" onkeyup="txt_mileagein(this)" ><?= $result_seMileage['MAXMILEAGENUMBER'] ?></th>
                                                            <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;" contenteditable="" onkeyup="txt_mileageout(this)"></th>
                                                            <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;">-</th>
                                                            <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><div id="kmsum"></div></th>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <th colspan="11"  style="border-right:1px solid #000;padding:4px;text-align:center;">ต้นทาง</th>
                                                            <th colspan="5"  style="border-right:1px solid #000;padding:4px;text-align:center;">ปลายทาง</th>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <th width="5%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ที่</th>
                                                            <th width="10%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมค์ต้นทาง</th>
                                                            <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เวลา</th>
                                                            <th width="5%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ลำดับ</th>
                                                            <th width="5%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขที่เอกสาร</th>
                                                            <th width="5%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">น้ำหนัก</th>
                                                            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">สภาพ</th>
                                                            <th width="10%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซนต์ลูกค้าต้นทาง</th>
                                                            <th width="10%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมค์ปลายทาง</th>
                                                            <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เวลา</th>
                                                            <th width="10%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซนต์ลูกค้าปลายทาง</th>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เข้า</th>
                                                            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ขึ้นสินค้า</th>
                                                            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ออก</th>
                                                            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">OK</th>
                                                            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">NO</th>
                                                            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เข้า</th>
                                                            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ลงสินค้า</th>
                                                            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ออก</th>
                                                        </tr>
                                                    </thead> 
                                                    <tbody>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"><?= $result_seMileage['MAXMILEAGENUMBER'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEIN1', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEIN1'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEINPRODUCT1', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT1'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEOUT1', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEOUT1'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_DOCUMENTNUMBER1', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER1'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_WEIGHT1', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_WEIGHT1'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok1" <?= $checkconditionok1 ?> onchange="chk_conditionok1()" /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno1" <?= $checkconditionno1 ?> onchange="chk_conditionno1()"/></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_CUSTOMER1', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_CUSTOMER1'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_MILES1', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_MILES1'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEIN1', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEIN1'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEINPRODUCT1', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEINPRODUCT1'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEOUT1', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEOUT1'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_CUSTOMER1', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_CUSTOMER1'] ?></td>

                                                        </tr><tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEIN2', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEIN2'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEINPRODUCT2', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT2'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEOUT2', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEOUT2'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_DOCUMENTNUMBER2', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER2'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_WEIGHT2', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_WEIGHT2'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok2" <?= $checkconditionok2 ?> onchange="chk_conditionok2()" /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno2" <?= $checkconditionno2 ?> onchange="chk_conditionno2()"/></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_CUSTOMER2', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_CUSTOMER2'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_MILES2', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_MILES2'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEIN2', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEIN2'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEINPRODUCT2', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEINPRODUCT2'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEOUT2', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEOUT2'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_CUSTOMER2', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_CUSTOMER2'] ?></td>
                                                        </tr><tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEIN3', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEIN3'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEINPRODUCT3', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT3'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEOUT3', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEOUT3'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_DOCUMENTNUMBER3', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER3'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_WEIGHT3', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_WEIGHT3'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok3" <?= $checkconditionok3 ?> onchange="chk_conditionok3()" /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno3" <?= $checkconditionno3 ?> onchange="chk_conditionno3()"/></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_CUSTOMER3', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_CUSTOMER3'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_MILES3', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_MILES3'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEIN3', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEIN3'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEINPRODUCT3', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEINPRODUCT3'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEOUT3', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEOUT3'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_CUSTOMER3', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_CUSTOMER3'] ?></td>
                                                        </tr><tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">4</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEIN4', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEIN4'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEINPRODUCT4', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT4'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEOUT4', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEOUT4'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">4</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_DOCUMENTNUMBER4', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER4'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_WEIGHT4', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_WEIGHT4'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok4" <?= $checkconditionok4 ?> onchange="chk_conditionok4()" /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno4" <?= $checkconditionno4 ?> onchange="chk_conditionno4()"/></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_CUSTOMER4', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_CUSTOMER4'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_MILES4', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_MILES4'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEIN4', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEIN4'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEINPRODUCT4', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEINPRODUCT4'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEOUT4', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEOUT4'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_CUSTOMER4', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_CUSTOMER4'] ?></td>
                                                        </tr><tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">5</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEIN5', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEIN5'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEINPRODUCT5', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT5'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEOUT5', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEOUT5'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">5</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_DOCUMENTNUMBER5', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER5'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_WEIGHT5', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_WEIGHT5'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok5" <?= $checkconditionok5 ?> onchange="chk_conditionok5()" /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno5" <?= $checkconditionno5 ?> onchange="chk_conditionno5()"/></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_CUSTOMER5', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_CUSTOMER5'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_MILES5', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_MILES5'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEIN5', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEIN5'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEINPRODUCT5', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEINPRODUCT5'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEOUT5', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEOUT5'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_CUSTOMER5', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_CUSTOMER5'] ?></td>
                                                        </tr><tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">6</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEIN6', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEIN6'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEINPRODUCT6', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT6'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEOUT6', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEOUT6'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">6</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_DOCUMENTNUMBER6', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER6'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_WEIGHT6', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_WEIGHT6'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok6" <?= $checkconditionok6 ?> onchange="chk_conditionok6()" /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno6" <?= $checkconditionno6 ?> onchange="chk_conditionno6()"/></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_CUSTOMER6', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_CUSTOMER6'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_MILES6', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_MILES6'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEIN6', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEIN6'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEINPRODUCT6', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEINPRODUCT6'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEOUT6', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEOUT6'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_CUSTOMER6', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_CUSTOMER6'] ?></td>
                                                        </tr><tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">7</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEIN7', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEIN7'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEINPRODUCT7', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT7'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEOUT7', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEOUT7'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">7</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_DOCUMENTNUMBER7', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER7'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_WEIGHT7', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_WEIGHT7'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok7" <?= $checkconditionok7 ?> onchange="chk_conditionok7()" /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno7" <?= $checkconditionno7 ?> onchange="chk_conditionno7()"/></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_CUSTOMER7', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_CUSTOMER7'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_MILES7', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_MILES7'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEIN7', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEIN7'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEINPRODUCT7', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEINPRODUCT7'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEOUT7', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEOUT7'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_CUSTOMER7', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_CUSTOMER7'] ?></td>
                                                        </tr><tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">8</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEIN8', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEIN8'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEINPRODUCT8', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT8'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEOUT8', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEOUT8'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">8</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_DOCUMENTNUMBER8', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER8'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_WEIGHT1', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_WEIGHT8'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok8" <?= $checkconditionok8 ?> onchange="chk_conditionok8()" /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno8" <?= $checkconditionno8 ?> onchange="chk_conditionno8()"/></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_CUSTOMER8', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_CUSTOMER8'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_MILES8', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_MILES8'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEIN8', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEIN8'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEINPRODUCT8', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEINPRODUCT8'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEOUT8', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEOUT8'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_CUSTOMER8', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_CUSTOMER8'] ?></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">9</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEIN9', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEIN9'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEINPRODUCT9', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT9'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEOUT9', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEOUT9'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">9</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_DOCUMENTNUMBER9', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER9'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_WEIGHT9', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_WEIGHT9'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok9" <?= $checkconditionok9 ?> onchange="chk_conditionok9()" /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno9" <?= $checkconditionno9 ?> onchange="chk_conditionno9()"/></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_CUSTOMER9', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_CUSTOMER9'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_MILES9', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_MILES9'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEIN9', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEIN9'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEINPRODUCT9', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEINPRODUCT9'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEOUT9', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEOUT9'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_CUSTOMER9', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_CUSTOMER9'] ?></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">10</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEIN10', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEIN10'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEINPRODUCT10', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT10'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEOUT10', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEOUT10'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">10</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_DOCUMENTNUMBER10', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER10'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_WEIGHT10', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_WEIGHT10'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok10" <?= $checkconditionok10 ?> onchange="chk_conditionok10()" /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno10" <?= $checkconditionno10 ?> onchange="chk_conditionno10()"/></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_CUSTOMER10', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_CUSTOMER10'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_MILES10', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_MILES10'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEIN10', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEIN10'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEINPRODUCT10', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEINPRODUCT10'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEOUT10', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEOUT10'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_CUSTOMER10', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_CUSTOMER10'] ?></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">11</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEIN11', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEIN11'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEINPRODUCT11', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT11'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEOUT11', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEOUT11'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">11</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_DOCUMENTNUMBER11', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER11'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_WEIGHT11', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_WEIGHT11'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok11" <?= $checkconditionok11 ?> onchange="chk_conditionok11()" /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno11" <?= $checkconditionno11 ?> onchange="chk_conditionno11()"/></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_CUSTOMER11', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_CUSTOMER11'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_MILES11', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_MILES11'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEIN11', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEIN11'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEINPRODUCT11', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEINPRODUCT11'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEOUT11', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEOUT11'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_CUSTOMER11', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_CUSTOMER11'] ?></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">12</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEIN12', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEIN12'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEINPRODUCT12', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT12'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEOUT12', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEOUT12'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">12</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_DOCUMENTNUMBER12', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER12'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_WEIGHT12', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_WEIGHT12'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok12" <?= $checkconditionok12 ?> onchange="chk_conditionok12()" /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno12" <?= $checkconditionno12 ?> onchange="chk_conditionno12()"/></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_CUSTOMER12', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_CUSTOMER12'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_MILES12', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_MILES12'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEIN12', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEIN12'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEINPRODUCT12', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEINPRODUCT12'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEOUT12', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEOUT12'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_CUSTOMER12', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_CUSTOMER12'] ?></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">13</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEIN13', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEIN13'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEINPRODUCT13', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT13'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEOUT13', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEOUT13'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">13</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_DOCUMENTNUMBER13', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER13'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_WEIGHT13', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_WEIGHT13'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok13" <?= $checkconditionok13 ?> onchange="chk_conditionok13()" /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno13" <?= $checkconditionno13 ?> onchange="chk_conditionno13()"/></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_CUSTOMER13', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_CUSTOMER13'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_MILES13', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_MILES13'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEIN13', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEIN13'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEINPRODUCT13', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEINPRODUCT13'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEOUT13', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEOUT13'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_CUSTOMER13', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_CUSTOMER13'] ?></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">14</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEIN14', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEIN14'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEINPRODUCT14', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT14'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEOUT14', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEOUT14'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">14</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_DOCUMENTNUMBER14', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER14'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_WEIGHT14', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_WEIGHT14'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok14" <?= $checkconditionok14 ?> onchange="chk_conditionok14()" /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno14" <?= $checkconditionno14 ?> onchange="chk_conditionno14()"/></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_CUSTOMER14', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_CUSTOMER14'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_MILES14', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_MILES14'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEIN14', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEIN14'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEINPRODUCT14', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEINPRODUCT14'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEOUT14', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEOUT14'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_CUSTOMER14', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_CUSTOMER14'] ?></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">15</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEIN15', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEIN15'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEINPRODUCT15', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEINPRODUCT15'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_TIMEOUT15', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_TIMEOUT15'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">15</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_DOCUMENTNUMBER15', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_DOCUMENTNUMBER15'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_WEIGHT15', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_WEIGHT15'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok15" <?= $checkconditionok15 ?> onchange="chk_conditionok15()" /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno15" <?= $checkconditionno15 ?> onchange="chk_conditionno15()"/></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'BEGIN_CUSTOMER15', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['BEGIN_CUSTOMER15'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_MILES15', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_MILES15'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEIN15', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEIN15'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEINPRODUCT15', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEINPRODUCT15'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_TIMEOUT15', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_TIMEOUT15'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'END_CUSTOMER15', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['END_CUSTOMER15'] ?></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" ></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" ></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" ></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">รวม</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" ></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" ><div id="sum_weight"><?= $result_seVehicledocumentrrc['BEGIN_SUMWEIGHT'] ?></div></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;" ></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;" ></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" ></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" ></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" ></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" ></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" ></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" ></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">DO</td>
                                                            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'DO', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['DO'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;" ></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;" ></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" ></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" ></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" ></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" ></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" ></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;" ></td>
                                                        </tr>
                                                    </tbody>

                                                    <tfoot>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td colspan="16" style="border-right:1px solid #000;padding:4px;text-align:left;">&nbsp;</td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ปัญหา :</b></td>
                                                            <td colspan="7" style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'REMARK', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocumentrrc['REMARK'] ?></td>
                                                            <td colspan="3" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;">พนักงานขับรถ</td>
                                                            <td colspan="2" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;">Checked By</td>
                                                            <td colspan="3" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;">Approved By</td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td colspan="8" style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">นาย <?= $employeename ?></td>
                                                            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">คุณ <?= $result_seEHR['nameT'] ?></td>
                                                            <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">คุณ <?= $result_seEHR['nameT'] ?></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td colspan="8" style="border-right:1px solid #000;padding:4px;text-align:left;">&nbsp;</td>
                                                            <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seSystime['SYSDATE'] ?></td>
                                                            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seSystime['SYSDATE'] ?></td>
                                                            <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seSystime['SYSDATE'] ?></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <?php
                } else {
                    ?>
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">

                                        <a href="meg_employee5.php?type=transportplan">รายการวิ่งงาน</a> / <?= $jobend ?></div>
                                    <!-- /.panel-heading -->

                                    <div class="panel-body">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <?php
                                                if ($_SESSION["ROLENAME"] != "DRIVER") {
                                                    ?>

                                                    <?php
                                                } else {
                                                    ?>
                                                    <li><?= $result_seEHR['Company_NameT'] ?> / <?= $result_seEHR['Company_NameE'] ?></li>
                                                    <?php
                                                }
                                                ?>


                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8 text-left"><br>ชื่อ...<?= $employeename ?>...รหัส...<?= $employeecode ?>...</div>
                                            <div class="col-lg-4 text-right"><button type="button" class="btn btn-default btn-circle" data-toggle="modal" data-target="#modal_adddn" onclick="showupdate_vehicletransportactual('<?= $_GET['vehicletransportplanid'] ?>')">กำหนดวันที่ / เวลาปฎิบัติงานจริง <p class="fa fa-truck"></p></button></div>
                                        </div>
                                        <div class="row">&nbsp;</div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                                    <table class="table table-striped table-bordered table-hover" >
                                                        <thead>
                                                            <tr>

                                                                <th style="text-align: right">เลขทริป : </th>
                                                                <?php
                                                                if ($_SESSION["ROLENAME"] != "DRIVER") {
                                                                    ?>
                                                                    <th colspan="8">
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                    <th colspan="7">
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                    <input type="text" class="form-control" id="txt_tripnumber" value="<?= $result_seDoc['TRIPNUMBER'] ?>"> <font style="color: red">* </font></th>

                                                            </tr>

                                                            <tr>

                                                                <th>ต้นทาง</th>
                                                                <th>CLUSTER</th>
                                                                <th>ปลายทาง</th>
                                                                <th>เบอร์รถ</th>
                                                                <?php
                                                                if ($_SESSION["ROLENAME"] != "DRIVER") {
                                                                    ?>
                                                                    <th>พขร 1</th>
                                                                    <th>พขร 2</th>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <th>วิ่งคู่กลับ</th>
                                                                    <?php
                                                                }
                                                                ?>

                                                                <th>จำนวนรถใหม่(คัน)</th>
                                                                <th>เลข DN</th>
                                                                <th style="text-align: center" >เลือกวิ่งงาน</th>





                                                            </tr>

                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 0;
                                                            $condition1 = " AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "'";
                                                            $sql_seVehicletransportplan3 = "{call megVehicletransportplan_v2(?,?,?,?)}";
                                                            $params_seVehicletransportplan3 = array(
                                                                array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                                array($condition1, SQLSRV_PARAM_IN),
                                                                array('', SQLSRV_PARAM_IN),
                                                                array('', SQLSRV_PARAM_IN)
                                                            );
                                                            $query_seVehicletransportplan3 = sqlsrv_query($conn, $sql_seVehicletransportplan3, $params_seVehicletransportplan3);
                                                            while ($result_seVehicletransportplan3 = sqlsrv_fetch_array($query_seVehicletransportplan3, SQLSRV_FETCH_ASSOC)) {

                                                                $conditionJobend = " AND VEHICLETRANSPORTPLANID ='" . $result_seVehicletransportplan3['VEHICLETRANSPORTPLANID'] . "'";
                                                                $sql_seJobend = "{call megVehicletransportjobendtemp_v2(?,?)}";
                                                                $params_seJobend = array(
                                                                    array('select_vehicletransportjobendtemp', SQLSRV_PARAM_IN),
                                                                    array($conditionJobend, SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seJobend = sqlsrv_query($conn, $sql_seJobend, $params_seJobend);
                                                                while ($result_seJobend = sqlsrv_fetch_array($query_seJobend, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?= $result_seVehicletransportplan3['JOBSTART'] ?></td>
                                                                        <td>
                                                                            <select class="form-control"  id="cb_cluster" name="cb_cluster" onchange="select_compensationcluster(this.value,<?= $i ?>, '<?= $result_seJobend['VEHICLETRANSPORTJOBENDTEMPID'] ?>')" >

                                                                                <?php
                                                                                $sql_seCluster = "{call megVehicletransportprice_v2(?,?)}";
                                                                                $params_seCluster = array(
                                                                                    array('select_cluster', SQLSRV_PARAM_IN),
                                                                                    array('', SQLSRV_PARAM_IN)
                                                                                );
                                                                                $query_seCluster = sqlsrv_query($conn, $sql_seCluster, $params_seCluster);
                                                                                while ($result_seCluster = sqlsrv_fetch_array($query_seCluster, SQLSRV_FETCH_ASSOC)) {
                                                                                    $select = "";
                                                                                    if ($result_seVehicletransportplan3['CLUSTER'] == $result_seCluster['CLUSTER']) {
                                                                                        $select = "SELECTED";
                                                                                    }
                                                                                    ?>
                                                                                    <option value = "<?= $result_seCluster['CLUSTER'] ?>" <?= $select ?>><?= $result_seCluster['CLUSTER'] ?></option> 
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </td>
                                                                        <td>   
                                                                            <div id="def_jobend<?= $i ?>">
                                                                                <select class="form-control"  id="cb_jobend" name="cb_jobend" onchange="update_compensationjobend(this.value)">

                                                                                    <?php
                                                                                    $condition = " AND VEHICLETRANSPORTPLANID ='" . $result_seJobend['VEHICLETRANSPORTPLANID'] . "'";
                                                                                    $sql_seJobend1 = "{call megVehicletransportjobendtemp_v2(?,?)}";
                                                                                    $params_seJobend1 = array(
                                                                                        array('select_vehicletransportjobendtemp', SQLSRV_PARAM_IN),
                                                                                        array($condition, SQLSRV_PARAM_IN)
                                                                                    );
                                                                                    $query_seJobend1 = sqlsrv_query($conn, $sql_seJobend1, $params_seJobend1);
                                                                                    while ($result_seJobend1 = sqlsrv_fetch_array($query_seJobend1, SQLSRV_FETCH_ASSOC)) {
                                                                                        $select = "";
                                                                                        if ($result_seJobend['JOBEND'] == $result_seJobend1['JOBEND']) {
                                                                                            $select = "SELECTED";
                                                                                        }
                                                                                        ?>
                                                                                        <option value = "<?= $result_seJobend1['JOBEND'] ?>" <?= $select ?>><?= $result_seJobend1['JOBEND'] ?></option> 
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                            <div id="sr_jobend<?= $i ?>">

                                                                            </div>

                                                                        </td>

                                                                        <td><?= $result_seVehicletransportplan3['THAINAME'] ?></td>
                                                                        <?php
                                                                        if ($_SESSION["ROLENAME"] != "DRIVER") {
                                                                            ?>
                                                                            <td><?= $result_seVehicletransportplan3['EMPLOYEENAME1'] ?></td>
                                                                            <td><?= $result_seVehicletransportplan3['EMPLOYEENAME2'] ?></td>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <td><?= $result_seVehicletransportplan3['EMPLOYEENAME2'] ?></td>
                                                                            <?php
                                                                        }
                                                                        ?>

                                                                        <td contenteditable="true" onkeyup="edit_vehicletransportjobendtempinner(this, 'AMOUNT', '<?= $result_seJobend['VEHICLETRANSPORTJOBENDTEMPID'] ?>')"><?= $result_seJobend['AMOUNT'] ?></td>
                                                                        <td contenteditable="true" onkeyup="edit_vehicletransportjobendtempinner(this, 'DN', '<?= $result_seJobend['VEHICLETRANSPORTJOBENDTEMPID'] ?>')"><?= $result_seJobend['DN'] ?></td>

                                                                        <td style="text-align: center">
                                                                            <?php
                                                                            if ($result_seJobend['ACTIVESTATUS'] == "1") {
                                                                                ?>
                                                                                <input checked="" type="checkbox" id="<?= $result_seJobend['VEHICLETRANSPORTJOBENDTEMPID'] ?>"  class="form-control" style="transform: scale(2)" onchange="edit_chkvehicletransportjobendtemp('1', 'ACTIVESTATUS', '<?= $result_seJobend['VEHICLETRANSPORTJOBENDTEMPID'] ?>')">

                                                                                <?php
                                                                            } else {
                                                                                ?>
                                                                                <input  type="checkbox" id="<?= $result_seJobend['VEHICLETRANSPORTJOBENDTEMPID'] ?>"  class="form-control" style="transform: scale(2)" onchange="edit_chkvehicletransportjobendtemp('0', 'ACTIVESTATUS', '<?= $result_seJobend['VEHICLETRANSPORTJOBENDTEMPID'] ?>')">
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </td>


                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                            }
                                                            ?>

                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" >
                                            <div class="col-lg-6">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">

                                                        ค่าใช้จ่ายดำเนินการ</div>

                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body" style="height: 350px">
                                                        <table class="table table-striped table-bordered table-hover" >

                                                            <tbody>

                                                                <tr>
                                                                    <td style="text-align: center;width: 15%" rowspan="2">ค่าใช้จ่ายดำเนินการ</td>
                                                                    <td style="width: 25%">ทางด่วน (บาท) : </td>
                                                                    <td style="width: 25%">ค่าซ่อม (บาท) : </td>
                                                                    <td style="width: 25%">อื่นๆ (บาท) : </td>
                                                                </tr>
                                                                <tr>

                                                                    <td> <input type="text" class="form-control"  id="txt_expresswaycosts" onKeyUp="if (isNaN(this.value)) {
                                                                                        alert('กรุณากรอกตัวเลข');
                                                                                        this.value = '';
                                                                                    }" value="<?= $C2 ?>"></td>
                                                                    <td ><input type="text" class="form-control" id="txt_repaircosts" onKeyUp="if (isNaN(this.value)) {
                                                                                        alert('กรุณากรอกตัวเลข');
                                                                                        this.value = '';
                                                                                    }" value=""></td>
                                                                    <td ><input type="text" class="form-control" id="txt_othercosts" onKeyUp="if (isNaN(this.value)) {
                                                                                        alert('กรุณากรอกตัวเลข');
                                                                                        this.value = '';
                                                                                    }"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align: center">หมายเหตุ
                                                                    </td>
                                                                    <td colspan="3" ><input type="text" class="form-control" id="txt_remarkcosts">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align: center">ผู้อนุมัติ
                                                                    </td>
                                                                    <td colspan="3" >&nbsp;
                                                                    </td>

                                                                </tr>


                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="col-lg-6">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">

                                                        รายได้ (กรณีทำงานวันหยุด)</div>
                                                    <!-- /.panel-heading -->

                                                    <div class="panel-body" style="height: 350px">
                                                        <table class="table table-striped table-bordered table-hover" >
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="4" >รายได้วันที่ : <?= $result_seVehicletransportplan2['DATE_PRESENT'] ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align: center;width: 25%">รถ 4 Load วิ่งมากว่า 3 Deler</th>
                                                                    <th style="text-align: center;width: 25%">รถ 8 Load วิ่งมากว่า 4 Deler</th>
                                                                    <th style="text-align: center;width: 25%">รถ 4 Load วิ่งมากว่า 1 Job</th>
                                                                    <th style="text-align: center;width: 25%">รถ 4 Load (Metro) ค่าเที่ยวน้อยกว่า 300 บาท</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <?php
                                                                    $condi4L3DL = $result_seVehicletransportplan2['DATE_RETURNACTUAL'];
                                                                    $sql_se4L3DL = "{call megVehicletransportprice_v2(?,?)}";
                                                                    $params_se4L3DL = array(
                                                                        array('select_4L3DL', SQLSRV_PARAM_IN),
                                                                        array($condi4L3DL, SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_se4L3DL = sqlsrv_query($conn, $sql_se4L3DL, $params_se4L3DL);
                                                                    $result_se4L3DL = sqlsrv_fetch_array($query_se4L3DL, SQLSRV_FETCH_ASSOC);

                                                                    $condi8L4DL = $result_seVehicletransportplan2['DATE_RETURNACTUAL'];
                                                                    $sql_se8L4DL = "{call megVehicletransportprice_v2(?,?)}";
                                                                    $params_se8L4DL = array(
                                                                        array('select_8L4DL', SQLSRV_PARAM_IN),
                                                                        array($condi8L4DL, SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_se8L4DL = sqlsrv_query($conn, $sql_se8L4DL, $params_se8L4DL);
                                                                    $result_se8L4DL = sqlsrv_fetch_array($query_se8L4DL, SQLSRV_FETCH_ASSOC);

                                                                    $condi4L1JOB = $result_seVehicletransportplan2['DATE_RETURNACTUAL'];
                                                                    $sql_se4L1JOB = "{call megVehicletransportprice_v2(?,?)}";
                                                                    $params_se4L1JOB = array(
                                                                        array('select_4L1JOB', SQLSRV_PARAM_IN),
                                                                        array($condi4L1JOB, SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_se4L1JOB = sqlsrv_query($conn, $sql_se4L1JOB, $params_se4L1JOB);
                                                                    $result_se4L1JOB = sqlsrv_fetch_array($query_se4L1JOB, SQLSRV_FETCH_ASSOC);

                                                                    $condi4L300 = $result_seVehicletransportplan2['DATE_RETURNACTUAL'];
                                                                    $sql_se4L300 = "{call megVehicletransportprice_v2(?,?)}";
                                                                    $params_se4L300 = array(
                                                                        array('select_4L300', SQLSRV_PARAM_IN),
                                                                        array($condi4L3DL, SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_se4L300 = sqlsrv_query($conn, $sql_se4L300, $params_se4L300);
                                                                    $result_se4L300 = sqlsrv_fetch_array($query_se4L300, SQLSRV_FETCH_ASSOC);
                                                                    ?>
                                                                    <td style="text-align: center;"><?= $result_se4L300['CHKDATA'] ?> บาท</td>
                                                                <td style="text-align: center;"><?= $result_se8L4DL['CHKDATA'] ?> บาท</td>
                                                                <td style="text-align: center;"><?= $result_se4L1JOB['CHKDATA'] ?> บาท</td>
                                                                <td style="text-align: center;"><?= $result_se4L300['CHKDATA'] ?> บาท</td>
                                                            </tr>



                                                        </tbody>
                                                    </table>
                                                    <table class="table table-striped table-bordered table-hover" >
                                                        <thead>

                                                            <tr>
                                                                <th colspan="2" >ค่าเที่ยว : <?= $E1 ?></th>


                                                                <th colspan="2" style="text-align: center">กลับมาวันหยุด</th>
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align: center;width: 25%">ทำงานวันหยุด(วัน)</th>
                                                                    <th style="text-align: center;width: 25%">เริ่มงานวันหยุด</th>
                                                                    <th style="text-align: center;width: 25%">ก่อน 13:00</th>
                                                                    <th style="text-align: center;width: 25%">หลัง 13:00</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><input type="text" class="form-control" onkeyup="calculator_compensation()" id="txt_workingstop" value="<?= $result_seCountholiday['HOLIDAYWORK'] ?>"></td>
                                                                    <td style="text-align: center">
                                                                        <?php
                                                                        if ($result_seStartholiday['HOLIDAYWORK'] == '0') {
                                                                            ?>
                                                                            <input type="checkbox"  disabled=""  id="chk_startstop" value="<?= ($E1 * $C4) - $E1 ?>" style="transform: scale(2)" onchange="calculator_compensation()">
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <input type="checkbox" checked="" disabled=""   id="chk_startstop" value="<?= ($E1 * $C4) - $E1 ?>" style="transform: scale(2)" onchange="calculator_compensation()">
                                                                            <?php
                                                                        }
                                                                        ?>

                                                                    </td>

                                                                    <td style="text-align: center">
                                                                        <?php
                                                                        if ($result_seCountholiday['HOLIDAYWORK'] == '0') {
                                                                            ?>
                                                                            <input type='radio' disabled=""  name="chk_13"  id="chk_Before13" value="<?= $C5 ?>" style="transform: scale(2)" onchange="calculator_compensation()">
                                                                            <?php
                                                                        } else {
                                                                            if ($result_seBefore13holiday['HOLIDAYWORK'] == '0') {
                                                                                ?>
                                                                                <input type='radio'  name="chk_13"  id="chk_Before13" value="<?= $C5 ?>" style="transform: scale(2)" onchange="calculator_compensation()">
                                                                                <?php
                                                                            } else {
                                                                                ?>
                                                                                <input type='radio' checked=""  name="chk_13"  id="chk_Before13" value="<?= $C5 ?>" style="transform: scale(2)" onchange="calculator_compensation()">
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>


                                                                    </td>
                                                                    <td style = "text-align: center">
                                                                        <?php
                                                                        if ($result_seCountholiday['HOLIDAYWORK'] == '0') {
                                                                            ?>
                                                                            <input type="radio" disabled="" name = "chk_13" id = "chk_after13" value = "<?= $C6 ?>" style = "transform: scale(2)" onchange = "calculator_compensation()">
                                                                            <?php
                                                                        } else {

                                                                            if ($result_seAfter13holiday['HOLIDAYWORK'] == '0') {
                                                                                ?>
                                                                                <input type="radio" name = "chk_13" id = "chk_after13" value = "<?= $C6 ?>" style = "transform: scale(2)" onchange = "calculator_compensation()">
                                                                                <?php
                                                                            } else {
                                                                                ?>
                                                                                <input type="radio" checked="" name = "chk_13" id = "chk_after13" value = "<?= $C6 ?>" style = "transform: scale(2)" onchange = "calculator_compensation()">
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>


                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan = "4">
                                                                        รวม : <label id = "lbl_totalincome"></label>
                                                                    </td>


                                                                </tr>


                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class = "row">
                                            <div class = "col-lg-12 text-right">
                                                <input type = "button" onclick = "save_vehicletransportdocument();" name = "btnSend" id = "btnSend" value = "บันทึกข้อมูล" class = "btn btn-primary">
                                            </div>
                                        </div>

                                    </div>
                                    <!--/.panel-body -->
                                </div>
                                <!--/.panel -->
                            </div>
                        </div>




                        <?php
                    }
                } else if ($_GET['type'] == 'tenkocompensation') {

                    if (substr($jobend, 0, 3) == 'RRC') {

                        $condVehicledocument = " AND a.VEHICLETRANSPORTPLANID ='" . $_GET['vehicletransportplanid'] . "'";
                        $sql_seVehicledocument = "{call megVehicletransportplan_v2(?,?,?)}";
                        $params_seVehicledocument = array(
                            array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                            array($condVehicledocument, SQLSRV_PARAM_IN),
                            array('', SQLSRV_PARAM_IN)
                        );
                        $query_seVehicledocument = sqlsrv_query($conn, $sql_seVehicledocument, $params_seVehicledocument);
                        $result_seVehicledocument = sqlsrv_fetch_array($query_seVehicledocument, SQLSRV_FETCH_ASSOC);
                        ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <a href="pdf_transportrrc.php?vehicletransportplanid=<?= $_GET['vehicletransportplanid'] ?>"  target ="_blank" class="btn btn-default">พิมพ์เอกสาร TRANSPORT <li class="fa fa-print"></li></a>
                                    </div>


                                    <div class="panel-body">
                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <?php
                                                    if ($_SESSION["ROLENAME"] != "DRIVER") {
                                                        ?>

                                                        <?php
                                                    } else {
                                                        ?>
                                                        <li><?= $result_seEHR['Company_NameT'] ?> / <?= $result_seEHR['Company_NameE'] ?></li>
                                                        <?php
                                                    }
                                                    ?>


                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 text-left"><br>ชื่อ...<?= $employeename ?>...รหัส...<?= $employeecode ?>...</div>
                                                <div class="col-sm-6" align="right">

                                                    <input class="btn btn-default" type="button" style="background-color: #ffffff;border:solid 1px #000" id="btn_srquotation" name="btn_srquotation" value=""> * ช่องสำหรับแก้ไขข้อมูล
                                                </div>
                                            </div>
                                            <div class="row">&nbsp;</div>
                                            <div class="row">

                                                <div class="col-sm-12">
                                                    <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
                                                    <thead>

                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><img src="../images/logo.png" height="30"></th>
                                                            <th colspan="5"  style="border-right:1px solid #000;padding:4px;text-align:center;">TRANSPORT GOODS TIME FOR TTAST</th>
                                                            <th colspan="10"  style="border-right:1px solid #000;padding:4px;text-align:center;">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด / 109 / 1 ม.9 ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190 Tel : 038-589225 Fax : 038-086720</th>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <th  bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">
                                                                <!--<input type="checkbox" <?//= $checkprojectttast ?> id="chk_projectttast"  onchange="chk_projectttast()"/>-->
                                                                ต้นทาง
                                                            </th>
                                                            <th colspan="5" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">
                                                                <?= $result_seVehicledocument['JOBSTART'] ?>
                                                            </th>

                                                            <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">การทำงาน</th>
                                                            <th colspan="4" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">พขร.</th>
                                                            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ทะเบียน</th>
                                                            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">วัน-เดือน-ปี</th>
                                                            <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">JOBNO</th>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <th  bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">
                                                                <!--<input type="checkbox" <?//= $checkprojectttast ?> id="chk_projectttast"  onchange="chk_projectttast()"/>-->
                                                                ปลายทาง
                                                            </th>
                                                            <th colspan="5" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">
                                                                <?= $result_seVehicledocument['JOBEND'] ?>
                                                            </th>

                                                            <th  style="border-right:1px solid #000;padding:4px;text-align:center;">

                                                                <input type="checkbox" <?= $checkworkingd ?> id="chk_workd" onchange="chk_workd()"/>
                                                                D&nbsp;
                                                                <input type="checkbox" <?= $checkworkingn ?> id="chk_workn" onchange="chk_workn()"/>
                                                                N</th>
                                                            <th colspan="4"  style="border-right:1px solid #000;padding:4px;text-align:center;">นาย <?= $employeename ?></th>
                                                            <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seVehicletransportplan2['VEHICLEREGISNUMBER1'] ?></th>
                                                            <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seVehicledocument['WORKINGDATE'] ?></th>
                                                            <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seVehicletransportplan2['JOBNO'] ?></th>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <th  style="border-right:1px solid #000;padding:4px;text-align:center;">
                                                                <input type="checkbox" id="chk_uniformcompany" onchange="chk_uniformcompany()" <?= $checkuniformcompany ?> />        
                                                            </th>
                                                            <th colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:left;">แต่งกายด้วยชุดฟอร์มของบริษัทฯ</th>
                                                            <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_uniformsafety" <?= $checkuniformsafety ?> onchange="chk_uniformsafety()"/></th>
                                                            <th colspan="4"  style="border-right:1px solid #000;padding:4px;text-align:left;">ใส่อุปกรณ์เซฟตี้ทุกครั้งขณะปฏิบัติงาน</th>
                                                            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมล์ก่อนออก</th>
                                                            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมล์เสร็จ</th>
                                                            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">น้ำมัน (ลิตร)</th>
                                                            <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">รวม (กม)</th>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_vehicle" <?= $checkuniformsafety ?> onchange="chk_vehicle()"/></th>
                                                            <th colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คสภาพความพร้อมของรถก่อนใช้งาน</th>
                                                            <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_regularity" onchange="chk_regularity()" <?= $checkregularity ?> /></th>
                                                            <th colspan="4"  style="border-right:1px solid #000;padding:4px;text-align:left;">ปฏิบัติตามกฏระเบียบของลูกค้าอย่างเคร่งครัด</th>
                                                            <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;" contenteditable="" onkeyup="txt_mileagein(this)" ><?= $result_seMileage['MAXMILEAGENUMBER'] ?></th>
                                                            <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;" contenteditable="" onkeyup="txt_mileageout(this)"></th>
                                                            <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;">-</th>
                                                            <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><div id="kmsum"></div></th>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <th colspan="11"  style="border-right:1px solid #000;padding:4px;text-align:center;">ต้นทาง</th>
                                                            <th colspan="5"  style="border-right:1px solid #000;padding:4px;text-align:center;">ปลายทาง</th>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <th width="5%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ที่</th>
                                                            <th width="10%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมค์ต้นทาง</th>
                                                            <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เวลา</th>
                                                            <th width="5%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ลำดับ</th>
                                                            <th width="5%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขที่เอกสาร</th>
                                                            <th width="5%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">น้ำหนัก</th>
                                                            <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">สภาพ</th>
                                                            <th width="10%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซนต์ลูกค้าต้นทาง</th>
                                                            <th width="10%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมค์ปลายทาง</th>
                                                            <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เวลา</th>
                                                            <th width="10%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ลายเซนต์ลูกค้าปลายทาง</th>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เข้า</th>
                                                            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ขึ้นสินค้า</th>
                                                            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ออก</th>
                                                            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">OK</th>
                                                            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">NG</th>
                                                            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เข้า</th>
                                                            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ลงสินค้า</th>
                                                            <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ออก</th>
                                                        </tr>
                                                    </thead> 
                                                    <tbody>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"><?= $result_seMileage['MAXMILEAGENUMBER'] ?></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionok1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionno1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">2</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionok1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionno1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">3</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionok1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionno1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">4</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">4</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionok1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionno1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">5</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">5</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionok1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionno1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">6</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">6</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionok1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionno1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">7</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">7</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionok1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionno1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">8</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">8</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionok1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionno1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">9</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">9</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionok1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionno1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">10</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">10</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionok1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionno1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">11</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">11</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionok1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionno1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">12</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">12</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionok1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionno1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">13</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">13</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionok1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionno1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">14</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">14</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionok1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionno1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">15</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">15</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionok1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionno1"  /></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                        </tr>
                                                    </tbody>

                                                    <tfoot>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td colspan="16" style="border-right:1px solid #000;padding:4px;text-align:left;">&nbsp;</td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ปัญหา :</b></td>
                                                            <td colspan="7" style="border-right:1px solid #000;padding:4px;text-align:left;" contenteditable="" onkeyup="editinner_vehicletransportdocument(this, 'REMARK', '<?= $_GET['vehicletransportplanid'] ?>')"><?= $result_seVehicledocument['REMARK'] ?></td>
                                                            <td colspan="3" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;">พนักงานขับรถ</td>
                                                            <td colspan="2" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;">Checked By</td>
                                                            <td colspan="3" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;">Approved By</td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td colspan="8" style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                            <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">นาย <?= $employeename ?></td>
                                                            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">คุณ <?= $result_seEHR['nameT'] ?></td>
                                                            <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">คุณ <?= $result_seEHR['nameT'] ?></td>
                                                        </tr>
                                                        <tr style="border:1px solid #000;padding:4px;">
                                                            <td colspan="8" style="border-right:1px solid #000;padding:4px;text-align:left;">&nbsp;</td>
                                                            <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seSystime['SYSDATE'] ?></td>
                                                            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seSystime['SYSDATE'] ?></td>
                                                            <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seSystime['SYSDATE'] ?></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <?php
                }
            }
            ?>

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
            <script src="../dist/js/bootstrap-select.js"></script>
        </body>

        <?php
        $job = select_jobautocomplate('megVehicletransportprice_v2', 'select_vehicletransportprice', '');
        $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeeehr2', " AND d.Company_Code IN ('RCC','RATC','RRC')");
//$thainame = select_carautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', " AND a.THAINAME != '-' AND ((a.THAINAME  LIKE '%R-%' OR a.THAINAME  LIKE '%RA-%' OR a.THAINAME  LIKE '%RP-%' OR a.THAINAME  LIKE '%ดินแดง%'  OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%'  OR a.THAINAME  LIKE '%ด่านช้าง%'  OR a.THAINAME  LIKE '%สวนผึ้ง%') OR (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%' OR a.ENGNAME  LIKE '%RP-%' OR a.ENGNAME LIKE '%ดินแดง%'  OR a.ENGNAME LIKE '%อุทัยธานี%'  OR a.ENGNAME LIKE '%คลองเขื่อน%'  OR a.ENGNAME LIKE '%ด่านช้าง%'  OR a.ENGNAME LIKE '%สวนผึ้ง%'))");
//$vehiclenumber = select_vehiclenumberautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', " AND a.THAINAME != '-' AND ((a.THAINAME  LIKE '%R-%' OR a.THAINAME  LIKE '%RA-%' OR a.THAINAME  LIKE '%RP-%' OR a.THAINAME  LIKE '%ดินแดง%'  OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%'  OR a.THAINAME  LIKE '%ด่านช้าง%'  OR a.THAINAME  LIKE '%สวนผึ้ง%') OR (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%' OR a.ENGNAME  LIKE '%RP-%' OR a.ENGNAME LIKE '%ดินแดง%'  OR a.ENGNAME LIKE '%อุทัยธานี%'  OR a.ENGNAME LIKE '%คลองเขื่อน%'  OR a.ENGNAME LIKE '%ด่านช้าง%'  OR a.ENGNAME LIKE '%สวนผึ้ง%'))");
        $cluster = select_clusterautocomplate('megVehicletransportprice_v2', 'select_cluster', '');
        ?>
        <script>
                                                                function copy_vehicletransportdocumentdriver(condition1, vehicletransportplanid, companycode, employeecode, employeename)
                                                                {
                                                                    $.ajax({
                                                                        type: 'post',
                                                                        url: 'meg_data.php',
                                                                        data: {
                                                                            txt_flg: "copy_vehicletransportdocumentdriver", condition1: condition1
                                                                        },
                                                                        success: function (rs) {
                                                                            alert(rs);
                                                                            dirverdocaddrrc(vehicletransportplanid, companycode, employeecode, employeename);
                                                                        }
                                                                    });
                                                                }
                                                                function dirverdocaddrrc(vehicletransportplanid, companycode, employeecode, employeename)
                                                                {

                                                                    $.ajax({
                                                                        type: 'post',
                                                                        url: 'meg_data.php',
                                                                        data: {
                                                                            txt_flg: "select_modaldirverdocaddrrc", vehicletransportplanid: vehicletransportplanid, companycode: companycode, employeecode: employeecode, employeename: employeename
                                                                        },
                                                                        success: function (response) {
                                                                            if (response)
                                                                            {
                                                                                document.getElementById("dirverdocrrcsr").innerHTML = response;
                                                                            }
                                                                        }
                                                                    });


                                                                }
                                                                function dirverdocaddrcc(vehicletransportplanid, companycode, employeecode, employeename)
                                                                {

                                                                    $.ajax({
                                                                        type: 'post',
                                                                        url: 'meg_data.php',
                                                                        data: {
                                                                            txt_flg: "select_modaldirverdocaddrcc", vehicletransportplanid: vehicletransportplanid, companycode: companycode, employeecode: employeecode, employeename: employeename
                                                                        },
                                                                        success: function (response) {
                                                                            if (response)
                                                                            {
                                                                                document.getElementById("dirverdocrccsr").innerHTML = response;
                                                                            }
                                                                        }
                                                                    });


                                                                }
                                                                function dirverdoceditrrc(vehicletransportplanid, companycode, employeecode, employeename)
                                                                {

                                                                    $.ajax({
                                                                        type: 'post',
                                                                        url: 'meg_data.php',
                                                                        data: {
                                                                            txt_flg: "select_modaldirverdoceditrrc", vehicletransportplanid: vehicletransportplanid, companycode: companycode, employeecode: employeecode, employeename: employeename
                                                                        },
                                                                        success: function (response) {
                                                                            if (response)
                                                                            {
                                                                                document.getElementById("dirverdocrrcsr").innerHTML = response;
                                                                            }
                                                                        }
                                                                    });


                                                                }
                                                                function save_vehicleweigh()
                                                                {

                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "save_vehicleweigh",
                                                                            vehicleweighid: '',
                                                                            vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>',
                                                                            customercode: document.getElementById("cb_customer").value,
                                                                            weighnumber: document.getElementById("txt_weighcardnumber").value,
                                                                            vehicleregisnumber: '<?= $result_seVehicletransportplan2['VEHICLEREGISNUMBER1'] ?>',
                                                                            producttype: '-',
                                                                            companycontact: document.getElementById("txt_connectcompany").value,
                                                                            productname: document.getElementById("txt_productname").value,
                                                                            weighdatein: document.getElementById("txt_weighdatein").value,
                                                                            weighin1: document.getElementById("txt_weighin1").value,
                                                                            weighdateout: document.getElementById("txt_weighdateout").value,
                                                                            weighin2: document.getElementById("txt_weighin2").value,
                                                                            weighout: document.getElementById("txt_weighout").value,
                                                                            weighsum: document.getElementById("txt_weighsum").value,
                                                                            remark: ''
                                                                        },
                                                                        success: function (rs) {
                                                                            alert(rs);
                                                                            window.location.reload();
                                                                        }
                                                                    });
                                                                }
                                                                function datetodate()
                                                                {
                                                                    document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

                                                                }


                                                                function editinner_vehicletransportdocumentdriver(editableObj, fieldname, ID)
                                                                {


                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "edit_vehicletransportdocumentdriver", editableObj: editableObj.innerHTML, ID: ID, fieldname: fieldname
                                                                        },
                                                                        success: function () {

                                                                        }
                                                                    });


                                                                }
                                                                function editinner_vehicletransportdocument(editableObj, fieldname, ID)
                                                                {


                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "edit_vehicletransportdocument", editableObj: editableObj.innerHTML, ID: ID, fieldname: fieldname
                                                                        },
                                                                        success: function () {

                                                                        }
                                                                    });


                                                                }
                                                                function edit_vehicletransportdocument(editableObj, fieldname, ID)
                                                                {


                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "edit_vehicletransportdocument", editableObj: editableObj, ID: ID, fieldname: fieldname
                                                                        },
                                                                        success: function () {
                                                                        }
                                                                    });
                                                                }
                                                                function txt_mileagein(data)
                                                                {

                                                                    save_mileage(data, 'MILEAGESTART', '<?= $result_seVehicletransportplan2['VEHICLEREGISNUMBER1'] ?>', '<?= $result_seVehicletransportplan2['JOBNO'] ?>')
                                                                }
                                                                function txt_mileageout(data)
                                                                {

                                                                    edit_vehicletransportdocument(document.getElementById('kmsum').innerHTML = data.innerHTML - '<?= $result_seMileage['MAXMILEAGENUMBER'] ?>', 'KMSUM', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                    save_mileage(data, 'MILEAGEEND', '<?= $result_seVehicletransportplan2['VEHICLEREGISNUMBER1'] ?>', '<?= $result_seVehicletransportplan2['JOBNO'] ?>')
                                                                }
                                                                function txt_companyother(data)
                                                                {
                                                                    if (document.getElementById('txt_companyother').value != "")
                                                                    {
                                                                        document.getElementById('chk_compother').checked = true;
                                                                        document.getElementById('chk_compsab').checked = false;
                                                                        document.getElementById('chk_compynp').checked = false;
                                                                        document.getElementById('chk_compch').checked = false;
                                                                        document.getElementById('chk_comptoy').checked = false;
                                                                        document.getElementById('chk_comphino').checked = false;
                                                                        document.getElementById('chk_compotc').checked = false;
                                                                        document.getElementById('chk_comptsa').checked = false;
                                                                    }
                                                                    edit_vehicletransportdocument(data, 'COMPANYNAME', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function txt_projectother(data)
                                                                {
                                                                    if (document.getElementById('txt_projectother').value != "")
                                                                    {
                                                                        document.getElementById('chk_projectttast').checked = false;
                                                                        document.getElementById('chk_projectother').checked = true;
                                                                    }
                                                                    edit_vehicletransportdocument(data, 'PROJECTNAME', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionok1()
                                                                {

                                                                    document.getElementById('chk_conditionok1').checked = true;
                                                                    document.getElementById('chk_conditionno1').checked = false;
                                                                    edit_vehicletransportdocument('1', 'BEGIN_CONDITION1', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionok2()
                                                                {

                                                                    document.getElementById('chk_conditionok2').checked = true;
                                                                    document.getElementById('chk_conditionno2').checked = false;
                                                                    edit_vehicletransportdocument('1', 'BEGIN_CONDITION2', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionok3()
                                                                {

                                                                    document.getElementById('chk_conditionok3').checked = true;
                                                                    document.getElementById('chk_conditionno3').checked = false;
                                                                    edit_vehicletransportdocument('1', 'BEGIN_CONDITION3', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionok4()
                                                                {

                                                                    document.getElementById('chk_conditionok4').checked = true;
                                                                    document.getElementById('chk_conditionno4').checked = false;
                                                                    edit_vehicletransportdocument('1', 'BEGIN_CONDITION4', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionok5()
                                                                {

                                                                    document.getElementById('chk_conditionok5').checked = true;
                                                                    document.getElementById('chk_conditionno5').checked = false;
                                                                    edit_vehicletransportdocument('1', 'BEGIN_CONDITION5', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionok6()
                                                                {

                                                                    document.getElementById('chk_conditionok6').checked = true;
                                                                    document.getElementById('chk_conditionno6').checked = false;
                                                                    edit_vehicletransportdocument('1', 'BEGIN_CONDITION6', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionok7()
                                                                {

                                                                    document.getElementById('chk_conditionok7').checked = true;
                                                                    document.getElementById('chk_conditionno7').checked = false;
                                                                    edit_vehicletransportdocument('1', 'BEGIN_CONDITION7', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionok8()
                                                                {

                                                                    document.getElementById('chk_conditionok8').checked = true;
                                                                    document.getElementById('chk_conditionno8').checked = false;
                                                                    edit_vehicletransportdocument('1', 'BEGIN_CONDITION8', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionok9()
                                                                {

                                                                    document.getElementById('chk_conditionok9').checked = true;
                                                                    document.getElementById('chk_conditionno9').checked = false;
                                                                    edit_vehicletransportdocument('1', 'BEGIN_CONDITION9', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionok10()
                                                                {

                                                                    document.getElementById('chk_conditionok10').checked = true;
                                                                    document.getElementById('chk_conditionno10').checked = false;
                                                                    edit_vehicletransportdocument('1', 'BEGIN_CONDITION10', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionok11()
                                                                {

                                                                    document.getElementById('chk_conditionok11').checked = true;
                                                                    document.getElementById('chk_conditionno11').checked = false;
                                                                    edit_vehicletransportdocument('1', 'BEGIN_CONDITION11', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionok12()
                                                                {

                                                                    document.getElementById('chk_conditionok12').checked = true;
                                                                    document.getElementById('chk_conditionno12').checked = false;
                                                                    edit_vehicletransportdocument('1', 'BEGIN_CONDITION12', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionok13()
                                                                {

                                                                    document.getElementById('chk_conditionok13').checked = true;
                                                                    document.getElementById('chk_conditionno13').checked = false;
                                                                    edit_vehicletransportdocument('1', 'BEGIN_CONDITION13', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionok14()
                                                                {

                                                                    document.getElementById('chk_conditionok14').checked = true;
                                                                    document.getElementById('chk_conditionno14').checked = false;
                                                                    edit_vehicletransportdocument('1', 'BEGIN_CONDITION14', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionok15()
                                                                {

                                                                    document.getElementById('chk_conditionok15').checked = true;
                                                                    document.getElementById('chk_conditionno15').checked = false;
                                                                    edit_vehicletransportdocument('1', 'BEGIN_CONDITION15', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionno1()
                                                                {

                                                                    document.getElementById('chk_conditionno1').checked = true;
                                                                    document.getElementById('chk_conditionok1').checked = false;
                                                                    edit_vehicletransportdocument('0', 'BEGIN_CONDITION1', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionno2()
                                                                {

                                                                    document.getElementById('chk_conditionno2').checked = true;
                                                                    document.getElementById('chk_conditionok2').checked = false;
                                                                    edit_vehicletransportdocument('0', 'BEGIN_CONDITION2', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionno3()
                                                                {

                                                                    document.getElementById('chk_conditionno3').checked = true;
                                                                    document.getElementById('chk_conditionok3').checked = false;
                                                                    edit_vehicletransportdocument('0', 'BEGIN_CONDITION3', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionno4()
                                                                {

                                                                    document.getElementById('chk_conditionno4').checked = true;
                                                                    document.getElementById('chk_conditionok4').checked = false;
                                                                    edit_vehicletransportdocument('0', 'BEGIN_CONDITION4', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionno5()
                                                                {

                                                                    document.getElementById('chk_conditionno5').checked = true;
                                                                    document.getElementById('chk_conditionok5').checked = false;
                                                                    edit_vehicletransportdocument('0', 'BEGIN_CONDITION5', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionno6()
                                                                {

                                                                    document.getElementById('chk_conditionno6').checked = true;
                                                                    document.getElementById('chk_conditionok6').checked = false;
                                                                    edit_vehicletransportdocument('0', 'BEGIN_CONDITION6', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionno7()
                                                                {

                                                                    document.getElementById('chk_conditionno7').checked = true;
                                                                    document.getElementById('chk_conditionok7').checked = false;
                                                                    edit_vehicletransportdocument('0', 'BEGIN_CONDITION7', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionno8()
                                                                {

                                                                    document.getElementById('chk_conditionno8').checked = true;
                                                                    document.getElementById('chk_conditionok8').checked = false;
                                                                    edit_vehicletransportdocument('0', 'BEGIN_CONDITION8', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionno9()
                                                                {

                                                                    document.getElementById('chk_conditionno9').checked = true;
                                                                    document.getElementById('chk_conditionok9').checked = false;
                                                                    edit_vehicletransportdocument('0', 'BEGIN_CONDITION9', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionno10()
                                                                {

                                                                    document.getElementById('chk_conditionno10').checked = true;
                                                                    document.getElementById('chk_conditionok10').checked = false;
                                                                    edit_vehicletransportdocument('0', 'BEGIN_CONDITION10', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionno11()
                                                                {

                                                                    document.getElementById('chk_conditionno11').checked = true;
                                                                    document.getElementById('chk_conditionok11').checked = false;
                                                                    edit_vehicletransportdocument('0', 'BEGIN_CONDITION11', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionno12()
                                                                {

                                                                    document.getElementById('chk_conditionno12').checked = true;
                                                                    document.getElementById('chk_conditionok12').checked = false;
                                                                    edit_vehicletransportdocument('0', 'BEGIN_CONDITION12', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionno13()
                                                                {

                                                                    document.getElementById('chk_conditionno13').checked = true;
                                                                    document.getElementById('chk_conditionok13').checked = false;
                                                                    edit_vehicletransportdocument('0', 'BEGIN_CONDITION13', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionno14()
                                                                {

                                                                    document.getElementById('chk_conditionno14').checked = true;
                                                                    document.getElementById('chk_conditionok14').checked = false;
                                                                    edit_vehicletransportdocument('0', 'BEGIN_CONDITION14', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_conditionno15()
                                                                {

                                                                    document.getElementById('chk_conditionno15').checked = true;
                                                                    document.getElementById('chk_conditionok15').checked = false;
                                                                    edit_vehicletransportdocument('0', 'BEGIN_CONDITION15', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_projectttast()
                                                                {
                                                                    document.getElementById('txt_projectother').value = "";
                                                                    document.getElementById('chk_projectttast').checked = true;
                                                                    document.getElementById('chk_projectother').checked = false;
                                                                    edit_vehicletransportdocument('TTAST', 'PROJECTNAME', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }

                                                                function chk_compsab()
                                                                {
                                                                    document.getElementById('txt_companyother').value = "";
                                                                    document.getElementById('chk_compsab').checked = true;

                                                                    document.getElementById('chk_compynp').checked = false;
                                                                    document.getElementById('chk_compch').checked = false;
                                                                    document.getElementById('chk_comptoy').checked = false;
                                                                    document.getElementById('chk_comphino').checked = false;
                                                                    document.getElementById('chk_compotc').checked = false;
                                                                    document.getElementById('chk_comptsa').checked = false;
                                                                    document.getElementById('chk_compother').checked = false;
                                                                    edit_vehicletransportdocument('SAB', 'COMPANYNAME', '<?= $_GET['vehicletransportplanid'] ?>');


                                                                }
                                                                function chk_compynp()
                                                                {
                                                                    document.getElementById('txt_companyother').value = "";
                                                                    document.getElementById('chk_compsab').checked = false;

                                                                    document.getElementById('chk_compynp').checked = true;
                                                                    document.getElementById('chk_compch').checked = false;
                                                                    document.getElementById('chk_comptoy').checked = false;
                                                                    document.getElementById('chk_comphino').checked = false;
                                                                    document.getElementById('chk_compotc').checked = false;
                                                                    document.getElementById('chk_comptsa').checked = false;
                                                                    document.getElementById('chk_compother').checked = false;
                                                                    edit_vehicletransportdocument('YNP', 'COMPANYNAME', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_compch()
                                                                {
                                                                    document.getElementById('txt_companyother').value = "";
                                                                    document.getElementById('chk_compsab').checked = false;

                                                                    document.getElementById('chk_compynp').checked = false;
                                                                    document.getElementById('chk_compch').checked = true;
                                                                    document.getElementById('chk_comptoy').checked = false;
                                                                    document.getElementById('chk_comphino').checked = false;
                                                                    document.getElementById('chk_compotc').checked = false;
                                                                    document.getElementById('chk_comptsa').checked = false;
                                                                    document.getElementById('chk_compother').checked = false;
                                                                    edit_vehicletransportdocument('CH', 'COMPANYNAME', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_comptoy()
                                                                {
                                                                    document.getElementById('txt_companyother').value = "";
                                                                    document.getElementById('chk_compsab').checked = false;

                                                                    document.getElementById('chk_compynp').checked = false;
                                                                    document.getElementById('chk_compch').checked = false;
                                                                    document.getElementById('chk_comptoy').checked = true;
                                                                    document.getElementById('chk_comphino').checked = false;
                                                                    document.getElementById('chk_compotc').checked = false;
                                                                    document.getElementById('chk_comptsa').checked = false;
                                                                    document.getElementById('chk_compother').checked = false;
                                                                    edit_vehicletransportdocument('TOY', 'COMPANYNAME', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_comphino()
                                                                {
                                                                    document.getElementById('txt_companyother').value = "";
                                                                    document.getElementById('chk_compsab').checked = false;

                                                                    document.getElementById('chk_compynp').checked = false;
                                                                    document.getElementById('chk_compch').checked = false;
                                                                    document.getElementById('chk_comptoy').checked = false;
                                                                    document.getElementById('chk_comphino').checked = true;
                                                                    document.getElementById('chk_compotc').checked = false;
                                                                    document.getElementById('chk_comptsa').checked = false;
                                                                    document.getElementById('chk_compother').checked = false;
                                                                    edit_vehicletransportdocument('HINO', 'COMPANYNAME', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_compotc()
                                                                {
                                                                    document.getElementById('txt_companyother').value = "";
                                                                    document.getElementById('chk_compsab').checked = false;

                                                                    document.getElementById('chk_compynp').checked = false;
                                                                    document.getElementById('chk_compch').checked = false;
                                                                    document.getElementById('chk_comptoy').checked = false;
                                                                    document.getElementById('chk_comphino').checked = false;
                                                                    document.getElementById('chk_compotc').checked = true;
                                                                    document.getElementById('chk_comptsa').checked = false;
                                                                    document.getElementById('chk_compother').checked = false;
                                                                    edit_vehicletransportdocument('OTC', 'COMPANYNAME', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_comptsa()
                                                                {
                                                                    document.getElementById('txt_companyother').value = "";
                                                                    document.getElementById('chk_compsab').checked = false;

                                                                    document.getElementById('chk_compynp').checked = false;
                                                                    document.getElementById('chk_compch').checked = false;
                                                                    document.getElementById('chk_comptoy').checked = false;
                                                                    document.getElementById('chk_comphino').checked = false;
                                                                    document.getElementById('chk_compotc').checked = false;
                                                                    document.getElementById('chk_comptsa').checked = true;
                                                                    document.getElementById('chk_compother').checked = false;
                                                                    edit_vehicletransportdocument('TSA', 'COMPANYNAME', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }

                                                                function chk_workd()
                                                                {
                                                                    document.getElementById('chk_workd').checked = true;
                                                                    document.getElementById('chk_workn').checked = false;
                                                                    edit_vehicletransportdocument('D', 'WORKING', '<?= $_GET['vehicletransportplanid'] ?>');

                                                                }
                                                                function chk_workn()
                                                                {
                                                                    document.getElementById('chk_workd').checked = false;
                                                                    document.getElementById('chk_workn').checked = true;
                                                                    edit_vehicletransportdocument('N', 'WORKING', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_uniformcompany()
                                                                {

                                                                    document.getElementById('chk_uniformcompany').checked = true;
                                                                    edit_vehicletransportdocument('แต่งกายด้วยชุดฟอร์มของบริษัทฯ', 'UNIFORMCOMPANYDATA', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_uniformsafety()
                                                                {

                                                                    document.getElementById('chk_uniformsafety').checked = true;
                                                                    edit_vehicletransportdocument('ใส่อุปกรณ์เซฟตี้ทุกครั้งขณะปฏิบัติงาน', 'UNIFORMSAFETYDATA', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_vehicle()
                                                                {

                                                                    document.getElementById('chk_vehicle').checked = true;
                                                                    edit_vehicletransportdocument('ตรวจเช็คสภาพความพร้อมของรถก่อนใช้งาน', 'VEHICLEDATA', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }
                                                                function chk_regularity()
                                                                {

                                                                    document.getElementById('chk_regularity').checked = true;
                                                                    edit_vehicletransportdocument('ปฏิบัติตามกฏระเบียบของลูกค้าอย่างเคร่งครัด', 'REGULARITYDATA', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                }


                                                                function pdf_compensation1()
                                                                {
                                                                    var emp = document.getElementById('txt_employeename').value;
                                                                    var datestart = document.getElementById('txt_datestart').value;
                                                                    var dateend = document.getElementById('txt_dateend').value;

                                                                    window.open('pdf_compensation1.php?emp=' + emp + '&datestart=' + datestart + '&dateend=' + dateend, '_blank');


                                                                }
                                                                function pdf_compensation2()
                                                                {
                                                                    var emp = document.getElementById('txt_employeename').value;
                                                                    var datestart = document.getElementById('txt_datestart').value;
                                                                    var dateend = document.getElementById('txt_dateend').value;

                                                                    window.open('pdf_compensation2.php?emp=' + emp + '&datestart=' + datestart + '&dateend=' + dateend, '_blank');


                                                                }

                                                                var txt_employeename = [<?= $emp ?>];
                                                                $("#txt_employeename").autocomplete({
                                                                    source: [txt_employeename]
                                                                });
                                                                function save_mileagevalue(editableObj, mileagetype, vehicleregisternumber1, jobno)
                                                                {

                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "save_mileage", mileageid: '', vehicleregisternumber1: vehicleregisternumber1, jobno: jobno, editableObj: editableObj, mileagetype: mileagetype
                                                                        },
                                                                        success: function () {

                                                                        }
                                                                    });
                                                                }
                                                                function save_mileage(editableObj, mileagetype, vehicleregisternumber1, jobno)
                                                                {

                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "save_mileage", mileageid: '', vehicleregisternumber1: vehicleregisternumber1, jobno: jobno, editableObj: editableObj.innerHTML, mileagetype: mileagetype
                                                                        },
                                                                        success: function () {

                                                                        }
                                                                    });
                                                                }
                                                                function edit_vehicletransportplanactual(editableObj, fieldname)
                                                                {
                                                                    var vehicletransportplanid = '<?= $_GET['vehicletransportplanid'] ?>';

                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "edit_datevehicletransportplan", editableObj: editableObj, ID: vehicletransportplanid, fieldname: fieldname
                                                                        },
                                                                        success: function () {

                                                                        }
                                                                    });
                                                                }

                                                                function showupdate_vehicletransportactual(vehicletransportplanid)
                                                                {

                                                                    $.ajax({
                                                                        type: 'post',
                                                                        url: 'meg_data.php',
                                                                        data: {
                                                                            txt_flg: "select_vehicletransportactual", vehicletransportplanid: vehicletransportplanid
                                                                        },
                                                                        success: function (response) {
                                                                            if (response)
                                                                            {

                                                                                document.getElementById("datasr_actual").innerHTML = response;
                                                                                document.getElementById("datadef_actual").innerHTML = "";

                                                                                $(function () {
                                                                                    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                    // กรณีใช้แบบ input
                                                                                    $(".datetimeen").datetimepicker({
                                                                                        timepicker: true,
                                                                                        dateformat: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                                                                                        lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                        timeFormat: "HH:mm"

                                                                                    }
                                                                                    );
                                                                                });

                                                                            }

                                                                        }
                                                                    });
                                                                }




                                                                function select_compensationcluster(cluster, num, tempjobendid)
                                                                {

                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "select_compensationcluster", cluster: cluster, tempjobendid: tempjobendid
                                                                        },
                                                                        success: function (rs) {

                                                                            document.getElementById("def_jobend" + num).innerHTML = "";
                                                                            document.getElementById("sr_jobend" + num).innerHTML = rs;
                                                                            update_compensationcluster(cluster);
                                                                        }
                                                                    });

                                                                }
                                                                function update_compensationcluster(editableObj)
                                                                {


                                                                    update_vehicletransportplan(editableObj, 'CLUSTER', '<?= $_GET['vehicletransportplanid'] ?>');


                                                                }
                                                                function update_compensationjobend(jobend)
                                                                {


                                                                    edit_vehicletransportjobendtemp(jobend, 'JOBEND', document.getElementById("tempjobendid").value);



                                                                }
                                                                function edit_vehicletransportjobendtemp(editableObj, fieldname, ID1)
                                                                {


                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "edit_vehicletransportjobendtemp", editableObj: editableObj, ID1: ID1, fieldname: fieldname
                                                                        },
                                                                        success: function () {
                                                                            // alert(rs);
                                                                            //window.location.reload();
                                                                        }
                                                                    });



                                                                }

                                                                function update_vehicletransportplan(editableObj, fieldname, ID1)
                                                                {

                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "edit_vehicletransportplan", editableObj: editableObj, ID: ID1, fieldname: fieldname
                                                                        },
                                                                        success: function () {


                                                                            //window.location.reload();
                                                                        }
                                                                    });

                                                                }




                                                                function edit_vehicletransportjobendtempinner(editableObj, fieldname, ID1)
                                                                {


                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "edit_vehicletransportjobendtemp", editableObj: editableObj.innerHTML, ID1: ID1, fieldname: fieldname
                                                                        },
                                                                        success: function () {

                                                                            //window.location.reload();
                                                                        }
                                                                    });



                                                                }

                                                                function edit_chkvehicletransportjobendtemp(editableObj, fieldname, ID1)
                                                                {

                                                                    if (document.getElementById(ID1).checked == true) {


                                                                        $.ajax({
                                                                            url: 'meg_data.php',
                                                                            type: 'POST',
                                                                            data: {
                                                                                txt_flg: "edit_vehicletransportjobendtemp", editableObj: '1', ID1: ID1, fieldname: fieldname
                                                                            },
                                                                            success: function () {

                                                                                //window.location.reload();
                                                                            }
                                                                        });

                                                                    } else
                                                                    {
                                                                        $.ajax({
                                                                            url: 'meg_data.php',
                                                                            type: 'POST',
                                                                            data: {
                                                                                txt_flg: "edit_vehicletransportjobendtemp", editableObj: '0', ID1: ID1, fieldname: fieldname
                                                                            },
                                                                            success: function () {

                                                                                //window.location.reload();
                                                                            }
                                                                        });
                                                                    }


                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "edit_vehicletransportplantemp", vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>'
                                                                        },
                                                                        success: function () {


                                                                            window.location.reload();
                                                                        }
                                                                    });



                                                                }


                                                                function edit_vehicletransportdocument(editableObj, fieldname, ID)
                                                                {

                                                                    var dataedit = editableObj.innerHTML;
                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "edit_vehicletransportdocument", editableObj: dataedit, ID: ID, fieldname: fieldname
                                                                        },
                                                                        success: function () {

                                                                        }
                                                                    });
                                                                }
                                                                function checknull_compensation()
                                                                {
                                                                    {

                                                                        if (document.getElementById("txt_tripnumber").value == "")
                                                                        {
                                                                            alert("เลขทริป เป็นค่าว่าง !!!");
                                                                            return false;
                                                                        } else
                                                                        {
                                                                            return true;
                                                                        }
                                                                    }
                                                                }
                                                                function save_vehicletransportdocument()
                                                                {
                                                                    var chkstartstop, chkBefore13, chkafter13;
                                                                    if (document.getElementById("chk_startstop").checked == true) {
                                                                        chkstartstop = document.getElementById("chk_startstop").value;
                                                                    } else
                                                                    {
                                                                        chkstartstop = '';
                                                                    }
                                                                    if (document.getElementById("chk_Before13").checked == true) {
                                                                        chkBefore13 = document.getElementById("chk_Before13").value;
                                                                    } else
                                                                    {
                                                                        chkBefore13 = '';
                                                                    }
                                                                    if (document.getElementById("chk_after13").checked == true) {
                                                                        chkafter13 = document.getElementById("chk_after13").value;

                                                                    } else
                                                                    {
                                                                        chkafter13 = '';
                                                                    }
                                                                    if (checknull_compensation()) {
                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "save_vehicletransportdocument",
                                                                                vehicletransportdocumentid: '',
                                                                                vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>',
                                                                                documenttype: '',
                                                                                tripnumber: document.getElementById("txt_tripnumber").value,
                                                                                amount: '',
                                                                                unit: '',
                                                                                startstopincome: chkstartstop,
                                                                                workingstopincome: document.getElementById("txt_workingstop").value,
                                                                                befor13income: chkBefore13,
                                                                                affore13income: chkafter13,
                                                                                income: '<?= $E1 ?>',
                                                                                totalincome: document.getElementById("lbl_totalincome").value,
                                                                                expresswaycosts: document.getElementById("txt_expresswaycosts").value,
                                                                                repaircosts: document.getElementById("txt_repaircosts").value,
                                                                                othercosts: document.getElementById("txt_othercosts").value,
                                                                                remarkcosts: document.getElementById("txt_remarkcosts").value,
                                                                                approverscosts: '',
                                                                                activestatus: '1',
                                                                                remark: ''
                                                                            },
                                                                            success: function (rs) {

                                                                                alert(rs);
                                                                                window.location.reload();

                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                                if ('<?= $_GET['type'] ?>' == 'compensation' && '<?= substr($jobend, 0, 3) ?>' != 'RRC')
                                                                {

                                                                    calculator_compensation();
                                                                }

                                                                function calculator_compensation()
                                                                {
                                                                    var E1 = ('<?= $E1 ?>' != "") ? parseFloat('<?= $E1 ?>') : 0;
                                                                    var C5 = ('<?= $C5 ?>' != "") ? parseFloat('<?= $C5 ?>') : 0;
                                                                    var C6 = ('<?= $C6 ?>' != "") ? parseFloat('<?= $C6 ?>') : 0;
                                                                    var C9 = ('<?= $C9 ?>' != "") ? parseFloat('<?= $C9 ?>') : 0;
                                                                    var OT = "";
                                                                    var workingstop = document.getElementById("txt_workingstop").value;
                                                                    if (document.getElementById("txt_workingstop").value != "")
                                                                    {
                                                                        OT = ((E1 * parseFloat(workingstop)) * 1.5) - E1
                                                                        if (document.getElementById("txt_workingstop").value != "0")
                                                                        {

                                                                            if (chk_Before13.checked == true) {
                                                                                document.getElementById("lbl_totalincome").innerHTML = (E1 + C5 + C9 + OT);
                                                                                document.getElementById("chk_after13").checked = false;
                                                                            } else if (chk_after13.checked == true) {

                                                                                document.getElementById("lbl_totalincome").innerHTML = (E1 + C6 + C9 + OT);
                                                                                document.getElementById("chk_Before13").checked = false;
                                                                            }
                                                                            //document.getElementById("chk_startstop").checked = false;
                                                                        }
                                                                        /*else if (chk_startstop.checked == true) {
                                                                         
                                                                         if (chk_Before13.checked == true) {
                                                                         document.getElementById("lbl_totalincome").innerHTML = (parseFloat('<?//= $E1 ?>') + parseFloat('<?//= $C5 ?>')) + (parseFloat('<?//= $E1 ?>') * parseFloat('<?//= $C4 ?>'));
                                                                         document.getElementById("chk_after13").checked = false;
                                                                         } else if (chk_after13.checked == true) {
                                                                         
                                                                         document.getElementById("lbl_totalincome").innerHTML = (parseFloat('<?//= $E1 ?>') + parseFloat('<?//= $C6 ?>')) + (parseFloat('<?//= $E1 ?>') * parseFloat('<?//= $C4 ?>'));
                                                                         document.getElementById("chk_Before13").checked = false;
                                                                         }
                                                                         
                                                                         //document.getElementById("txt_workingstop").value = "0";
                                                                         } */
                                                                        else
                                                                        {

                                                                            if (chk_Before13.checked == true) {

                                                                                document.getElementById("lbl_totalincome").innerHTML = (E1 + C5 + C9 + OT);
                                                                                document.getElementById("chk_after13").checked = false;
                                                                            } else if (chk_after13.checked == true) {
                                                                                document.getElementById("lbl_totalincome").innerHTML = (E1 + C6 + C9 + OT);
                                                                                document.getElementById("chk_Before13").checked = false;
                                                                            } else
                                                                            {
                                                                                document.getElementById("txt_workingstop").value = "0";
                                                                                document.getElementById("lbl_totalincome").innerHTML = E1 + C9;
                                                                            }
                                                                        }
                                                                    } else
                                                                    {

                                                                        document.getElementById("txt_workingstop").value = "0";
                                                                        document.getElementById("lbl_totalincome").innerHTML = E1 + C9;
                                                                    }

                                                                }

                                                                function select_compensation()
                                                                {

                                                                    //var employeename = "";
                                                                    //if ('<?//= $_SESSION["ROLENAME"] ?>' == 'DRIVER')
                                                                    //{
                                                                    //    employeename = "";
                                                                    //} else
                                                                    //{
                                                                    //   employeename = document.getElementById('txt_employeename').value;
                                                                    //}
                                                                    $.ajax({
                                                                        type: 'post',
                                                                        url: 'meg_data.php',
                                                                        data: {
                                                                            txt_flg: "select_compensation", datestart: document.getElementById('txt_datestart').value, dateend: document.getElementById('txt_dateend').value, employeename: ''
                                                                        },
                                                                        success: function (response) {
                                                                            if (response)
                                                                            {

                                                                                document.getElementById("data_sr").innerHTML = response;
                                                                                document.getElementById("data_def").innerHTML = "";
                                                                            }
                                                                            $(function () {
                                                                                $('[data-toggle="popover"]').popover({
                                                                                    html: true,
                                                                                    content: function () {
                                                                                        return $('#popover-content').html();
                                                                                    }
                                                                                });
                                                                            })
                                                                            $(document).ready(function () {
                                                                                $('#dataTables-example').DataTable({
                                                                                    responsive: true
                                                                                });
                                                                            });

                                                                        }
                                                                    });
                                                                }
                                                                function datetodate()
                                                                {
                                                                    document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;


                                                                }
                                                                $(function () {

                                                                    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                    // กรณีใช้แบบ input
                                                                    $(".datedef").datetimepicker({
                                                                        timepicker: false,
                                                                        format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                                                                        lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

                                                                    });
                                                                });
        </script>

        <script>
            $(function () {
                $('[data-toggle="popover"]').popover({
                    html: true,
                    content: function () {
                        return $('#popover-content').html();
                    }
                });
            })


        </script>
        <script>

            $("#cb_compjobend").html('cb_compjobend').selectpicker('refresh');
            $('.selectpicker').on('changed.bs.select', function () {
                //document.getElementById('txt_copydiagramjobend').value = $(this).val();

            });


        </script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            }
            );
        </script>




    </html>
    <?php
    sqlsrv_close($conn);
    ?>