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


$conditionEHR = " AND a.PersonID ='" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEHR = "{call megEmployeeEHR_v2(?,?)}";
$params_seEHR = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($conditionEHR, SQLSRV_PARAM_IN)
);
$query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
$result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);


$condcompany = " AND Company_Code ='" . $companycode . "'";
$sql_seCompany = "{call megCompanyEHR_v2(?,?)}";
$params_seCompany = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condcompany, SQLSRV_PARAM_IN)
);
$query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
$result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);

$condition = " AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "'";
$sql_seVehicletransportplan = "{call megVehicletransportplan_v2(?,?,?,?)}";
$params_seVehicletransportplan = array(
    array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
    array($condition, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seVehicletransportplan = sqlsrv_query($conn, $sql_seVehicletransportplan, $params_seVehicletransportplan);
$result_seVehicletransportplan = sqlsrv_fetch_array($query_seVehicletransportplan, SQLSRV_FETCH_ASSOC);


$condMileage = " AND  VEHICLEREGISNUMBER ='" . $result_seVehicletransportplan['VEHICLEREGISNUMBER1'] . "'";
$sql_seMileage = "{call megMileage_v2(?,?)}";
$params_seMileage = array(
    array('select_maxmileage', SQLSRV_PARAM_IN),
    array($condMileage, SQLSRV_PARAM_IN)
);
$query_seMileage = sqlsrv_query($conn, $sql_seMileage, $params_seMileage);
$result_seMileage = sqlsrv_fetch_array($query_seMileage, SQLSRV_FETCH_ASSOC);

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
                <?php
                if ($result_seVehicletransportplan['COMPANYCODE'] == 'RRC') {
                    if ($result_seVehicletransportplan['CUSTOMERCODE'] == 'TTAST') {
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7" align="right">
                                    <a href="pdf_transportttastrrc.php?vehicletransportplanid=<?= $_GET['vehicletransportplanid'] ?>"  target ="_blank" class="btn btn-default">พิมพ์เอกสาร TRANSPORT <li class="fa fa-print"></li></a>
                                </div>


                                <div class="panel-body">
                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">


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
                                                            <?= $result_seVehicletransportplan['JOBSTART'] ?>
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
                                                            <?= $result_seVehicletransportplan['JOBEND'] ?>
                                                        </th>

                                                        <th  style="border-right:1px solid #000;padding:4px;text-align:center;">

                                                            <input disabled=""  type="checkbox" <?= $checkworkingd ?> id="chk_workd" onchange="chk_workd()"/>
                                                            D&nbsp;
                                                            <input disabled="" type="checkbox" <?= $checkworkingn ?> id="chk_workn" onchange="chk_workn()"/>
                                                            N</th>
                                                        <th colspan="4"  style="border-right:1px solid #000;padding:4px;text-align:left;">1.<?= $result_seVehicletransportplan['EMPLOYEENAME1']?> <?php if($result_seVehicletransportplan['EMPLOYEENAME2']!=""){ echo '2.'.$result_seVehicletransportplan['EMPLOYEENAME2']; } ?></th>
                                                        <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seVehicletransportplan['VEHICLEREGISNUMBER1'] ?></th>
                                                        <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seVehicletransportplan['DATE_VLIN'] ?></th>
                                                        <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seVehicletransportplan['JOBNO'] ?></th>
                                                    </tr>
                                                    <tr style="border:1px solid #000;padding:4px;">
                                                        <th  style="border-right:1px solid #000;padding:4px;text-align:center;">
                                                            <input disabled="" type="checkbox" id="chk_uniformcompany" checked="" />
                                                        </th>
                                                        <th colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:left;">แต่งกายด้วยชุดฟอร์มของบริษัทฯ</th>
                                                        <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><input checked="" disabled="" type="checkbox" id="chk_uniformsafety" /></th>
                                                        <th colspan="4"  style="border-right:1px solid #000;padding:4px;text-align:left;">ใส่อุปกรณ์เซฟตี้ทุกครั้งขณะปฏิบัติงาน</th>
                                                        <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมล์ก่อนออก</th>
                                                        <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมล์เสร็จ</th>
                                                        <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">น้ำมัน (ลิตร)</th>
                                                        <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">รวม (กม)</th>
                                                    </tr>
                                                    <tr style="border:1px solid #000;padding:4px;">
                                                        <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><input checked="" disabled="" type="checkbox" id="chk_vehicle" /></th>
                                                        <th colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คสภาพความพร้อมของรถก่อนใช้งาน</th>
                                                        <th  style="border-right:1px solid #000;padding:4px;text-align:center;"><input checked="" disabled="" type="checkbox" id="chk_regularity"  /></th>
                                                        <th colspan="4"  style="border-right:1px solid #000;padding:4px;text-align:left;">ปฏิบัติตามกฏระเบียบของลูกค้าอย่างเคร่งครัด</th>
                                                        <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seMileage['MAXMILEAGENUMBER'] ?></th>
                                                        <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;"></th>
                                                        <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;">-</th>
                                                        <th  style="border-right:1px solid #000;padding:4px;text-align:center;"></th>
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
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionok1"  /></td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionno1"  /></td>
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
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionok1"  /></td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionno1"  /></td>
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
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionok1"  /></td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionno1"  /></td>
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
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionok1"  /></td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionno1"  /></td>
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
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionok1"  /></td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionno1"  /></td>
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
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionok1"  /></td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionno1"  /></td>
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
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionok1"  /></td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionno1"  /></td>
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
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionok1"  /></td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionno1"  /></td>
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
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionok1"  /></td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionno1"  /></td>
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
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionok1"  /></td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionno1"  /></td>
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
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionok1"  /></td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionno1"  /></td>
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
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionok1"  /></td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionno1"  /></td>
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
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionok1"  /></td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionno1"  /></td>
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
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionok1"  /></td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionno1"  /></td>
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
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionok1"  /></td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input disabled="" type="checkbox" id="chk_conditionno1"  /></td>
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
                                                        <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">1.<?= $result_seVehicletransportplan['EMPLOYEENAME1']?> <?php if($result_seVehicletransportplan['EMPLOYEENAME2']!=""){ echo '2.'.$result_seVehicletransportplan['EMPLOYEENAME2']; } ?></td>
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
                    else
                    {
                        ?>
            <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7" align="right">
                                    <a href="pdf_transportgmtrrc.php?vehicletransportplanid=<?= $_GET['vehicletransportplanid'] ?>"  target ="_blank" class="btn btn-default">พิมพ์เอกสาร TRANSPORT <li class="fa fa-print"></li></a>
                                </div>


                                <div class="panel-body">
                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">


                                        <div class="row">&nbsp;</div>
                                        <div class="row">

                                            <div class="col-sm-12">

                                                <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
                                                <thead>

                                                    <tr style="border:1px solid #000;padding:4px;">
                                                        <th colspan="12"  style="border-right:1px solid #000;padding:4px;text-align:center;">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด / RUAMKIT RECYCLE CARRIER CO.,LTD.</th>
                                                    </tr>
                                                     <tr style="border:1px solid #000;padding:4px;">
                                                        <th colspan="12"  style="border-right:1px solid #000;padding:4px;text-align:center;">เอกสารควบคุมการจัดส่ง / DELIVERY CONTROL DOCUMENT</th>
                                                    </tr>
                                                     <tr style="border:1px solid #000;padding:4px;">
                                                        <th colspan="12"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขประจำตัวผู้เสียภาษี 0105551065951 สาขาที่ 00001 ที่อยู่ 109/1 ม.9 ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190</th>
                                                    </tr>

                                                    <tr style="border:1px solid #000;padding:4px;">
                                                        <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">พนักงานขับรถ / DRIVER</th>
                                                        <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ทะเบียนรถ / NO.</th>

                                                        <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เดียว/S</th>
                                                        <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">พ่วง/F</th>
                                                        <th colspan="4" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">วันรับสินค้า/LOADING : <b><?=$result_seVehicletransportplan['DATE_VLIN'];?></b></th>
                                                    </tr>
                                                    <tr style="border:1px solid #000;padding:4px;">
                                                        <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;"><b><?php echo '1.'.$result_seVehicletransportplan['EMPLOYEENAME1'];if($result_seVehicletransportplan['EMPLOYEENAME2'] != ''){ echo ' / 2.'.$result_seVehicletransportplan['EMPLOYEENAME2'];}?></b></th>
                                                        <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;"><b><?=$result_seVehicletransportplan['VEHICLEREGISNUMBER1']?></b></th>
                                                        <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</th>
                                                        <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</th>
                                                        <th colspan="4" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">วันส่งสินค้า/UNLOADING : <b><?=$result_seVehicletransportplan['DATERETURN'];?></b></th>
                                                    </tr>
                                                    <tr style="border:1px solid #000;padding:4px;">
                                                        <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">รับสินค้าจาก : <b><?=$result_seVehicletransportplan['JOBSTART']?></b> ส่งลูกค้า : <b><?=$result_seVehicletransportplan['JOBEND']?></b></th>
                                                        <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">ชนิดเหล็ก : <b><?=$result_seVehicletransportplan['MATERIALTYPE']?></b></th>
                                                        <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">บัตรชั่งเลขที่ : </th>
                                                        <th colspan="4" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">เลข JOB : <b><?=$result_seVehicletransportplan['JOBNO']?></b></th>
                                                    </tr>
                                                    <tr style="border:1px solid #000;padding:4px;">
                                                        <th colspan="5" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ข้อมูลปฎิบัติงาน / OPERATION DATA</th>
                                                        <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">น้ำหนัก / WEIGHT</th>
                                                        <th colspan="4" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ผู้ตรวจสอบ / CHECKER</th>
                                                    </tr>
                                                    <tr style="border:1px solid #000;padding:4px;">
                                                        <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">สถานที่</th>
                                                        <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เข้า</th>
                                                        <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ออก</th>
                                                        <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมค์</th>
                                                        <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เข้า</th>
                                                        <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ออก</th>
                                                        <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">สุทธิ</th>
                                                        <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ต้นทาง</th>
                                                        <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ปลายทาง</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr style="border:1px solid #000;padding:4px;">
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%">&nbsp;</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%">&nbsp;</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%">&nbsp;</td>
                                                        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%">&nbsp;</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%">&nbsp;</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%">&nbsp;</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%">&nbsp;</td>
                                                        <td colspan="2" rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%">&nbsp;</td>
                                                        <td colspan="2" rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%">&nbsp;</td>
                                                    </tr>
                                                    <tr style="border:1px solid #000;padding:4px;">
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                    </tr>
                                                    <tr style="border:1px solid #000;padding:4px;">
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                    </tr>
                                                    <tr style="border:1px solid #000;padding:4px;">
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                    </tr>
                                                </tbody>

                                                <tfoot>
                                                     <tr style="border:1px solid #000;padding:4px;">
                                                        <td bgcolor="#CCCCCC" colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;">สรุปการปฎิบัติงาน</td>
                                                        <td bgcolor="#CCCCCC" colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;">เจ้าหน้าที่ควบคุม</td>
                                                    </tr>
                                                    <tr style="border:1px solid #000;padding:4px;">
                                                        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ระยะทาง(กิโลเมตร)</td>
                                                        <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                        <td colspan="6" rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                    </tr>
                                                    <tr style="border:1px solid #000;padding:4px;">
                                                        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">น้ำมัน(ลิตร)</td>
                                                        <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                    </tr>
                                                    <tr style="border:1px solid #000;padding:4px;">
                                                        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ค่าเฉลี่ย(กิโลเมตร/ลิตร)</td>
                                                        <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
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


            <?php
            if ($result_seVehicletransportplan['COMPANYCODE'] == 'RKS') {
                if ($result_seVehicletransportplan['CUSTOMERCODE'] == 'TGT'||$result_seVehicletransportplan['CUSTOMERCODE'] == 'TMT'||$result_seVehicletransportplan['CUSTOMERCODE'] == 'DENSO-THAI'||$result_seVehicletransportplan['CUSTOMERCODE'] == 'STM'||$result_seVehicletransportplan['CUSTOMERCODE'] == 'TAW'||$result_seVehicletransportplan['CUSTOMERCODE'] == 'DAIKI') {
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7" align="right">
                                <a href="pdf_transportvantruck.php?vehicletransportplanid=<?= $_GET['vehicletransportplanid'] ?>"  target ="_blank" class="btn btn-default">พิมพ์เอกสาร TRANSPORT <li class="fa fa-print"></li></a>

                            </div>


                            <div class="panel-body">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">


                                    <div class="row">&nbsp;</div>
                                    <div class="row">

                                        <div class="col-sm-12">
                                            <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
                                            <thead>

                                                  <tr style="border:1px solid #000;padding:2px;">
                                                      <th colspan="1"  style="padding:2px;text-align:center;"><img src="../images/logo.png" height="30"></th>
                                                      <th colspan="7"  style="padding:2px;text-align:left;font-size:15;">TRANSPORT GOODS TIME FOR  VAN TRUCK</th>
                                                      <th colspan="16"  style="border-right:1px solid #000;padding:2px;text-align:right;font-size:12;">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด / 51 ม.4 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160 Tel : 038-452824-5 Fax : 038-452826</th>

                                                  </tr>
                                                <tr style="border:1px solid #000;padding:4px;">
                                                    <th  colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">
                                                        <!--<input type="checkbox" <?//= $checkprojectttast ?> id="chk_projectttast"  onchange="chk_projectttast()"/>-->
                                                        ต้นทาง
                                                    </th>
                                                    <th colspan="6" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">
                                                        <?= $result_seVehicletransportplan['JOBSTART'] ?>
                                                    </th>
                                                    <th colspan="1" bgcolor="#CCCCCC"  style="padding:4px;text-align:left;">
                                                        JOBNO
                                                    </th>
                                                    <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">
                                                      :   <?= $result_seVehicletransportplan['JOBNO'] ?>
                                                    </th>

                                                    <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">การทำงาน</th>
                                                    <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">พขร.</th>
                                                    <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ผช. พขร.</th>
                                                    <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">รอบที่</th>
                                                    <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">วัน-เดือน-ปี</th>

                                                </tr>
                                                <tr style="border:1px solid #000;padding:4px;">
                                                    <th  colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">
                                                        <!--<input type="checkbox" <?//= $checkprojectttast ?> id="chk_projectttast"  onchange="chk_projectttast()"/>-->
                                                        ปลายทาง
                                                    </th>
                                                    <th colspan="10" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">
                                                        <?= $result_seVehicletransportplan['JOBEND'] ?>
                                                    </th>

                                                    <th  colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;">

                                                        <input disabled=""  type="checkbox" <?= $checkworkingd ?> id="chk_workd" onchange="chk_workd()"/>
                                                        D&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input disabled="" type="checkbox" <?= $checkworkingn ?> id="chk_workn" onchange="chk_workn()"/>
                                                        N</th>
                                                    <th colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:left;"><?php if($result_seVehicletransportplan['EMPLOYEENAME1'] !=""){ echo "1.",$result_seVehicletransportplan['EMPLOYEENAME1']; } ?></th>
                                                    <th colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:left;"><?php if($result_seVehicletransportplan['EMPLOYEENAME2'] !=""){ echo "2.",$result_seVehicletransportplan['EMPLOYEENAME2']; } ?></th>
                                                    <th colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></th>
                                                    <th colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seVehicletransportplan['DATE_VLIN'] ?></th>

                                                </tr>
                                                <tr style="border:1px solid #000;padding:4px;">
                                                    <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">
                                                        <input disabled="" type="checkbox" id="chk_uniformcompany" />
                                                    </th>
                                                    <th colspan="5"  style="border-right:1px solid #000;padding:4px;text-align:left;">แต่งกายด้วยชุดฟอร์มของบริษัทฯ</th>
                                                    <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><input  disabled="" type="checkbox" id="chk_uniformsafety" /></th>
                                                    <th colspan="5"  style="border-right:1px solid #000;padding:4px;text-align:left;">ใส่อุปกรณ์เซฟตี้ทุกครั้งขณะปฏิบัติงาน</th>
                                                    <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ทะเบียนรถ</th>
                                                    <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมล์ก่อนออก</th>
                                                    <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมล์เสร็จ</th>
                                                    <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">น้ำมัน (ลิตร)</th>
                                                    <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">รวม (กม)</th>
                                                </tr>
                                                <tr style="border:1px solid #000;padding:4px;">
                                                    <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><input  disabled="" type="checkbox" id="chk_vehicle" /></th>
                                                    <th colspan="5"  style="border-right:1px solid #000;padding:4px;text-align:left;">ตรวจเช็คสภาพความพร้อมของรถก่อนใช้งาน</th>
                                                    <th colspan="6"  style="border-right:1px solid #000;padding:4px;text-align:left;"></th>
                                                    <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seVehicletransportplan['THAINAME']?></th>
                                                    <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;"></th>
                                                    <th colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;"></th>
                                                    <th colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;">-</th>
                                                    <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;"></th>
                                                </tr>
                                                <tr style="border:1px solid #000;padding:4px;">
                                                    <th colspan="12" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;">ต้นทาง</th>
                                                    <th colspan="12" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;">ปลายทาง</th>
                                                </tr>
                                                <tr style="border:1px solid #000;padding:4px;">
                                                    <th width="3%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ที่</th>
                                        						<th width="5%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">สถานที่</th>
                                                    <th width="8%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมค์</th>
                                                    <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เวลา</th>
                                                    <th width="6%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขที่เอกสาร</th>
                                                    <th width="4%" colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">จำนวน</th>
                                                    <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">สภาพ</th>
                                                    <th width="7%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ลูกค้าลงชื่อ</th>
                                        						<th width="5%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">สถานที่</th>
                                                    <th width="8%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมค์</th>
                                                    <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เวลา</th>
                                                    <th width="6%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขที่เอกสาร</th>
                                                    <th width="4%" colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">จำนวน</th>
                                                    <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">สภาพ</th>
                                                    <th width="7%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ลูกค้าลงชื่อ</th>
                                        						<th width="7%" rowspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">หมายเหตุ</th>
                                                </tr>
                                                <tr style="border:1px solid #000;padding:4px;">
                                                    <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เข้า</th>
                                                    <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ขึ้นสินค้า</th>
                                                    <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ออก</th>
                                        						<th width="3%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">Pallet</th>
                                                    <th width="3%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">Box</th>
                                                    <th width="3%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">OK</th>
                                                    <th width="3%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">NG</th>

                                        						<th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เข้า</th>
                                                    <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ขึ้นสินค้า</th>
                                                    <th width="5%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ออก</th>
                                        						<th width="3%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">Pallet</th>
                                                    <th width="3%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">Box</th>
                                                    <th width="3%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">OK</th>
                                                    <th width="3%" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">NG</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr style="border:1px solid #000;padding:4px;">
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;">RK</td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                        						<td bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                    <td bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"><input type="checkbox" id="chk_conditionok1"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"><input type="checkbox" id="chk_conditionno1"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>

                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ><input type="checkbox" id="chk_conditionok2"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ><input type="checkbox" id="chk_conditionno2"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                </tr>

                                        				<tr style="border:1px solid #000;padding:4px;">
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ><input type="checkbox" id="chk_conditionok3"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ><input type="checkbox" id="chk_conditionno3"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionok4"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><input type="checkbox" id="chk_conditionno4" /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                </tr>


                                        				<tr style="border:1px solid #000;padding:4px;">
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok5"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno5" /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok6"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno6"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                </tr>


                                        				<tr style="border:1px solid #000;padding:4px;">
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok7"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno7" /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok8"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno8"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                </tr>


                                        				<tr style="border:1px solid #000;padding:4px;">
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok9"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno9"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok10"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno10"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                </tr>


                                        				<tr style="border:1px solid #000;padding:4px;">
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok11"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno11"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok12"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno12" /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                </tr>


                                        				<tr style="border:1px solid #000;padding:4px;">
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok13"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno13"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok14"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno14"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                </tr>


                                        				<tr style="border:1px solid #000;padding:4px;">
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok15"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno15"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok16"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno16"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                </tr>


                                        				<tr style="border:1px solid #000;padding:4px;">
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok17"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno17"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok18"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno18"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                </tr>


                                        				<tr style="border:1px solid #000;padding:4px;">
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok19"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno19"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok20"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno20" /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                </tr>


                                        				<tr style="border:1px solid #000;padding:4px;">
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok21"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno21"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok22"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno22"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                </tr>

                                        				<tr style="border:1px solid #000;padding:4px;">
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok23"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno23"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok24"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno24"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                </tr>

                                        				<tr style="border:1px solid #000;padding:4px;">
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok25"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno25"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok26"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno26"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                </tr>

                                        				<tr style="border:1px solid #000;padding:4px;">
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok27"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno27"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok28"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno28"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                </tr>


                                        				<tr style="border:1px solid #000;padding:4px;">
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok29"   /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno29"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>

                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  >RK</td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionok30"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"  ><input type="checkbox" id="chk_conditionno30"  /></td>
                                                    <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                        						<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"  ></td>
                                                </tr>


                                            </tbody>

                                            <tfoot>
                                                <tr bgcolor="#CCCCCC" style="border:1px solid #000;padding:4px;">
                                                    <td colspan="24" style="border-right:1px solid #000;padding:4px;text-align:left;">หมายเหตุ :<i>
                                                    เมื่อท่านได้ลงลายนิ้วมือชื่อในเอกสารนี้แล้ว เอกสารนี้สามารถยืนยันได้ว่าท่านได้รับสินค้าครบถ้วนสมบูรณ์ถูกต้องตามเอกสารนี้แล้ว</i>
                                                     </td>
                                                </tr>
                                                <tr style="border:1px solid #000;padding:4px;">
                                                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;"><b><u>ปัญหา :</u></b></td>
                                                    <td colspan="12" style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                                    <td colspan="3" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;">พนักงานขับรถ</td>
                                                    <td colspan="4" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;">Checked By</td>
                                                    <td colspan="3" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;">Approved By</td>
                                                </tr>
                                                <tr style="border-left:1px solid #000;border-right:1px solid #000;padding:4px;">
                                                    <td colspan="14" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;">นาย <?=$result_seVehicletransportplan['EMPLOYEENAME1']?></td>
                                                    <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;">คุณ <?=$result_seEHR['nameT']?></td>
                                                    <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;">คุณ <?=$result_seEHR['nameT']?></td>
                                                </tr>
                                                <tr style="border:1px solid #000;padding:4px;">
                                                    <td colspan="14" style="border-right:1px solid #000;padding:4px;text-align:left;">&nbsp;</td>
                                                    <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"><?=$result_seSystime['SYSDATE']?></td>
                                                    <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"><?=$result_seSystime['SYSDATE']?></td>
                                                    <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"><?=$result_seSystime['SYSDATE']?></td>
                                                </tr>
                                                <tr style="border:1px solid #000;padding:4px;">
                                                    <td colspan="24" style="border-right:1px solid #000;padding:2px;text-align:left;font-size:8;"><b>&nbsp;FM-OPS-RKS14/08 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; แก้ไขครัั้งที่ : 00 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; มีผลบังคับใช้ :1-2-54</b></td>
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
                else
                {
                    ?>

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
        $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeeehr2', " AND d.Company_Code IN ('RCC','RATC','RRC','RKS')");
//$thainame = select_carautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', " AND a.THAINAME != '-' AND ((a.THAINAME  LIKE '%R-%' OR a.THAINAME  LIKE '%RA-%' OR a.THAINAME  LIKE '%RP-%' OR a.THAINAME  LIKE '%ดินแดง%'  OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%'  OR a.THAINAME  LIKE '%ด่านช้าง%'  OR a.THAINAME  LIKE '%สวนผึ้ง%') OR (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%' OR a.ENGNAME  LIKE '%RP-%' OR a.ENGNAME LIKE '%ดินแดง%'  OR a.ENGNAME LIKE '%อุทัยธานี%'  OR a.ENGNAME LIKE '%คลองเขื่อน%'  OR a.ENGNAME LIKE '%ด่านช้าง%'  OR a.ENGNAME LIKE '%สวนผึ้ง%'))");
//$vehiclenumber = select_vehiclenumberautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', " AND a.THAINAME != '-' AND ((a.THAINAME  LIKE '%R-%' OR a.THAINAME  LIKE '%RA-%' OR a.THAINAME  LIKE '%RP-%' OR a.THAINAME  LIKE '%ดินแดง%'  OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%'  OR a.THAINAME  LIKE '%ด่านช้าง%'  OR a.THAINAME  LIKE '%สวนผึ้ง%') OR (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%' OR a.ENGNAME  LIKE '%RP-%' OR a.ENGNAME LIKE '%ดินแดง%'  OR a.ENGNAME LIKE '%อุทัยธานี%'  OR a.ENGNAME LIKE '%คลองเขื่อน%'  OR a.ENGNAME LIKE '%ด่านช้าง%'  OR a.ENGNAME LIKE '%สวนผึ้ง%'))");
        $cluster = select_clusterautocomplate('megVehicletransportprice_v2', 'select_cluster', '');
        ?>




    </html>
    <?php
    sqlsrv_close($conn);
    ?>
