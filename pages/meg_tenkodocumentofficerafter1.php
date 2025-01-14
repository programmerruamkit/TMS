<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmployee = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
$result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);

$sql_seSystime = "{call megGetdate_v2(?)}";
$params_seSystime = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
$result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);
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
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        <style>
            .navbar-default {

                border-color: #ffcb0b;
            }
            #page-wrapper {
                border-left: 1px solid #ffcb0b;
            }
            .chat-panel .panel-body {
                height: 100%;
            </style>
        </head>
        <body>
            <input type="text" id="txt_tenkobeforeid" name="txt_tenkobeforeid" style="display: none">

                <div id="wrapper">
                    <!-- Navigation -->
                    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                        <?php
                        include '../pages/meg_header.php';
                        include '../pages/meg_leftmenu.php';
                        ?>
                    </nav>

                    <div id="page-wrapper">








                        <div class="row" >
                            <div class="col-lg-12">

                                <h5 class="page-header">

                                    เอกสารเท็งโกะ


                                </h5>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <?php
                        $sql_seChkemployee = "SELECT b.FnameT AS 'FnameTP',b.LnameT AS 'LnameTP',b.PersonCode AS 'PersonCodeP',b.PersonCode,
                            (b.FnameT +' '+b.LnameT) AS 'nameTP',c.Company_Code,d.PositionGroup FROM dbo.TIMEINOUT a
                            RIGHT JOIN dbo.EMPLOYEEEHR b ON a.PersonCode = b.PersonCode
                            INNER JOIN dbo.COMPANYEHR c on b.CompanyID = c.ID_Company
                            INNER JOIN dbo.POSITIONEHR d ON b.PositionID = d.PositionID
                            AND 1=1  WHERE b.PersonCode = '" . $_GET['employeecode1'] . "'";

                        $query_seChkemployee = sqlsrv_query($conn, $sql_seChkemployee, $params_seChkemployee);
                        $result_seChkemployee = sqlsrv_fetch_array($query_seChkemployee, SQLSRV_FETCH_ASSOC);







                        $conditionTenkomasterofficer = " AND a.TENKOMASTERDIRVERCODE1 = '" . $_GET['employeecode1'] . "' AND  CONVERT(DATE,CREATEDATE) = CONVERT(DATE,GETDATE())";
                        $sql_seTenkomasterofficer = "{call megEdittenkomaster_v2(?,?)}";
                        $params_seTenkomasterofficer = array(
                            array('select_tenkomaster', SQLSRV_PARAM_IN),
                            array($conditionTenkomasterofficer, SQLSRV_PARAM_IN)
                        );
                        $query_seTenkomasterofficer = sqlsrv_query($conn, $sql_seTenkomasterofficer, $params_seTenkomasterofficer);
                        $result_seTenkomasterofficer = sqlsrv_fetch_array($query_seTenkomasterofficer, SQLSRV_FETCH_ASSOC);
                 



                        $conditionTenkobeforeofficer = " AND a.TENKOMASTERID = '" . $result_seTenkomasterofficer['TENKOMASTERID'] . "'";
                        $sql_seTenkobeforeofficer = "{call megEdittenkobefore_v2(?,?,?)}";
                        $params_seTenkobeforeofficer = array(
                            array('select_tenkobefore', SQLSRV_PARAM_IN),
                            array($conditionTenkobeforeofficer, SQLSRV_PARAM_IN),
                            array('', SQLSRV_PARAM_IN)
                        );
                        $query_seTenkobeforeofficer = sqlsrv_query($conn, $sql_seTenkobeforeofficer, $params_seTenkobeforeofficer);
                        $result_seTenkobeforeofficer = sqlsrv_fetch_array($query_seTenkobeforeofficer, SQLSRV_FETCH_ASSOC);

                       

                        $conditionDir1officer = "  AND a.PersonCode = '" . $_GET['employeecode1'] . "'";
                        $sql_seDir1officer = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seDir1officer = array(
                            array('select_employee', SQLSRV_PARAM_IN),
                            array($conditionDir1officer, SQLSRV_PARAM_IN)
                        );
                        $query_seDir1officer = sqlsrv_query($conn, $sql_seDir1officer, $params_seDir1officer);
                        $result_seDir1officer = sqlsrv_fetch_array($query_seDir1officer, SQLSRV_FETCH_ASSOC);

                       
                        
                       
                        $checkofficer11 = ($result_seTenkobeforeofficer['TENKOTEMPERATURECHECK'] == '1') ? "checked" : "";
                        $checkofficer12 = ($result_seTenkobeforeofficer['TENKOPRESSURECHECK'] == '1') ? "checked" : "";
                        $checkofficer13 = ($result_seTenkobeforeofficer['TENKOALCOHOLCHECK'] == '1') ? "checked" : "";
                        $checkofficer14 = ($result_seTenkobeforeofficer['TENKOOXYGENCHECK'] == '1') ? "checked" : "";


                        $rsofficer111 = ($result_seTenkobeforeofficer['TENKOTEMPERATURERESULT'] == '1') ? "checked" : "";
                        $rsofficer121 = ($result_seTenkobeforeofficer['TENKOPRESSURERESULT'] == '1') ? "checked" : "";
                        $rsofficer131 = ($result_seTenkobeforeofficer['TENKOALCOHOLRESULT'] == '1') ? "checked" : "";
                        $rsofficer141 = ($result_seTenkobeforeofficer['TENKOOXYGENRESULT'] == '1') ? "checked" : "";

                        $rsofficer110 = ($result_seTenkobeforeofficer['TENKOTEMPERATURERESULT'] == '0') ? "checked" : "";
                        $rsofficer120 = ($result_seTenkobeforeofficer['TENKOPRESSURERESULT'] == '0') ? "checked" : "";
                        $rsofficer130 = ($result_seTenkobeforeofficer['TENKOALCOHOLRESULT'] == '0') ? "checked" : "";
                        $rsofficer140 = ($result_seTenkobeforeofficer['TENKOOXYGENRESULT'] == '0') ? "checked" : "";


                        $condEmpehr = " AND a.PersonCode = '" . $_GET['employeecode1'] . "'";
                        $sql_seEmpehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmpehr = array(
                            array('select_employee', SQLSRV_PARAM_IN),
                            array($condEmpehr, SQLSRV_PARAM_IN)
                        );
                        $query_seEmpehr = sqlsrv_query($conn, $sql_seEmpehr, $params_seEmpehr);
                        $result_seEmpehr = sqlsrv_fetch_array($query_seEmpehr, SQLSRV_FETCH_ASSOC);

                        $sql_seOfficeresult1 = "{call megEdittenkobefore_v2(?,?,?)}";
                        $params_seOfficeresult1 = array(
                            array('select_beforeresultofficer', SQLSRV_PARAM_IN),
                            array($result_seTenkomasterofficer['TENKOMASTERID'], SQLSRV_PARAM_IN),
                            array($result_seTenkomasterofficer['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
                        );
                        $query_seOfficeresult1 = sqlsrv_query($conn, $sql_seOfficeresult1, $params_seOfficeresult1);
                        $result_seOfficeresult1 = sqlsrv_fetch_array($query_seOfficeresult1, SQLSRV_FETCH_ASSOC);



                        $sql_seOfficecheck1 = "{call megEdittenkobefore_v2(?,?,?)}";
                        $params_seOfficecheck1 = array(
                            array('select_beforecheckofficer', SQLSRV_PARAM_IN),
                            array($result_seTenkomasterofficer['TENKOMASTERID'], SQLSRV_PARAM_IN),
                            array($result_seTenkomasterofficer['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
                        );
                        $query_seOfficecheck1 = sqlsrv_query($conn, $sql_seOfficecheck1, $params_seOfficecheck1);
                        $result_seOfficecheck1 = sqlsrv_fetch_array($query_seOfficecheck1, SQLSRV_FETCH_ASSOC);
                        ?>
                        <div class="row" >

                            <div class="col-lg-6">&nbsp;</div>
                            <div class="col-lg-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <b><?= $result_seEmployee["nameT"] ?></b>
                                    </div>
                                    <div class="panel-body">

                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" style="text-align: center"><input type="button" onclick="commit()" class="btn btn-success" value="Commit"></th>

                                                        </tr>
                                                        <tr>

                                                            <th style="text-align: center;width: 50%">ตรวจสอบ</th>
                                                            <th style="text-align: center;width: 50%">ผลตรวจ</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>


                                                            <td style="text-align: center">


                                                                <?php
                                                                if ($result_seOfficecheck1['TENKOBEFORECHECK'] == "1") {
                                                                    ?>
                                                                    <span class="glyphicon glyphicon-ok" id="icon_officecheckok" style="color: green"></span>
                                                                    <span class="glyphicon glyphicon-remove" id="icon_officecheckno" style="display: none;color: red"></span>
                                                                    <?php
                                                                } else {
                                                                    ?>

                                                                    <span class="glyphicon glyphicon-remove" id="icon_officecheckno" style="color: red"></span>
                                                                    <span class="glyphicon glyphicon-ok" id="icon_officecheckok" style="display: none;color: green"></span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="text-align: center">


                                                                <?php
                                                                if ($result_seOfficeresult1['TENKOBEFORERESULT'] == "1") {
                                                                    ?>
                                                                    <span class="glyphicon glyphicon-ok" id="icon_officeresultok" style="color: green"></span>
                                                                    <span class="glyphicon glyphicon-remove" id="icon_officeresultno" style="display: none;color: red"></span>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <span class="glyphicon glyphicon-remove" id="icon_officeresultno" style="color: red"></span>
                                                                    <span class="glyphicon glyphicon-ok" id="icon_officeresultok" style="display: none;color: green"></span>
                                                                    <?php
                                                                }
                                                                ?></td>

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
                        <div class="row" >
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">

                                        <div class="row" >

                                            <div class="col-lg-6">
                                                เท็งโกะก่อนเริ่มงาน
                                            </div>
                                            <?php
                                            $emp = ($_GET['employeecode1'] != "") ? $_GET['employeecode1'] : $_GET['employeecode2'];
                                            if ($emp != "") {
                                                ?>
                                                <div class="col-lg-6 text-right">
                                                    <a href="pdf_reportemployeeofficer4_1.php?employeecode=<?= $emp ?>&tenkomasterid=<?= $result_seTenkomasterofficer['TENKOMASTERID'] ?>"  target ="_blank" class="btn btn-default">พิมพ์เอกสารเท็งโกะ 1 <li class="fa fa-print"></li></a>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                        </div>

                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <!-- Nav tabs -->


                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <p>&nbsp;</p>

                                            <div class="tab-pane fade in active" id="tenko1">






                                                <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                                    <thead>
                                                        <tr>
                                                            <th  colspan="7" ><font style="color: green">พนักงาน : <?= $result_seEmpehr['nameT'] ?></font></th>
                                                            <th width="65">เจ้าหน้าที่</th>
                                                            <th width="144" ><?= $result_seEmployee["nameT"] ?></th>
                                                            <th width="40">พขร.</th>
                                                            <th width="144" ><?= $result_seEmpehr['nameT'] ?></th>
                                                        </tr>
                                                        <tr>
                                                            <th width="40" rowspan="2"  style="width: 40px;text-align: center">ข้อ</th>
                                                            <th width="280" rowspan="2" style="width: 200px;text-align: center">หัวข้อ</th>
                                                            <th width="92" rowspan="2" style="width: 20px;text-align: center">ช่องตรวจสอบ</th>
                                                            <th colspan="2" rowspan="2" style="width: 400px;text-align: center">เกณฑ์การตัดสิน</th>
                                                            <th colspan="2" style="width: 80px;text-align: center">ผล</th>
                                                            <th colspan="4" style="text-align: center" rowspan="2">รายเอียดและการแนะนำ</th>
                                                        </tr>
                                                        <tr>
                                                            <th width="40" style="width: 40px;text-align: center" >ปกติ</th>
                                                            <th width="49" style="width: 40px;text-align: center" >ผิดปกติ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                        <tr>
                                                            <td style="text-align: center">1</td>
                                                            <td>ตรวจเช็คอุณหภูมิ</td>
                                                            <td style="text-align: center"><input disabled="" <?= $checkofficer11 ?> type="checkbox" id="chk_officer11" name="chk_officer11"  style="transform: scale(2)"/></td>
                                                            <td>ต่ำกว่า 37.5 องศา</td>
                                                            <td><input type="text" class="form-control" id="txt_rsofficer11" name="txt_rsofficer11" value="<?= $result_seTenkobeforeofficer['TENKOTEMPERATUREDATA'] ?>" onchange="edit_tenkobeforetxtofficer1(this.value, 'TENKOTEMPERATUREDATA', '<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>')"></td>
                                                            <td style="text-align: center"><input disabled="" <?= $rsofficer111 ?> type="checkbox"  style="transform: scale(2)" id="chk_rsofficer111" name="chk_rsofficer111" /></td>
                                                            <td style="text-align: center"><input disabled="" <?= $rsofficer110 ?> type="checkbox" style="transform: scale(2)" id="chk_rsofficer110" name="chk_rsofficer110" /></td>
                                                            <td colspan="4"><input type="text" id="txt_remark1" name="txt_remark1" class="form-control" onchange="edit_tenkobeforetxtremarkofficer(this.value, 'TENKOTEMPERATUREREMARK', '<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>')" value="<?= $result_seTenkobeforeofficer['TENKOTEMPERATUREREMARK'] ?>"></td>
                                                        </tr>
                                                        <tr>
                                                            <td rowspan="3" style="text-align: center">2</td>
                                                            <td rowspan="3">วัดความดัน</td>
                                                            <td rowspan="3" style="text-align: center"><input disabled="" <?= $checkofficer12 ?> type="checkbox" id="chk_officer12" name="chk_officer12" style="transform: scale(2)"/></td>
                                                            <td>บน : 90-140</td>
                                                            <td><input type="text" class="form-control" id="txt_rsofficer121" name="txt_rsofficer121" value="<?= $result_seTenkobeforeofficer['TENKOPRESSUREDATA_90160'] ?>" onchange="edit_tenkobeforetxtofficer2(this.value, 'TENKOPRESSUREDATA_90160', '<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>')"></td>

                                                            <td rowspan="3" style="text-align: center"><input disabled="" <?= $rsofficer121 ?> type="checkbox" style="transform: scale(2)" id="chk_rsofficer121" name="chk_rsofficer121" /></td>
                                                            <td rowspan="3" style="text-align: center"><input disabled="" <?= $rsofficer120 ?> type="checkbox" style="transform: scale(2)" id="chk_rsofficer120" name="chk_rsofficer120" /></td>
                                                            <td colspan="4"><input type="text" id="txt_remark2" name="txt_remark2" class="form-control" onchange="edit_tenkobeforetxtremarkofficer(this.value, 'TENKOPRESSUREREMARK', '<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>')" value="<?= $result_seTenkobeforeofficer['TENKOPRESSUREREMARK'] ?>"></td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td>ล่าง : 60-90</td>
                                                            <td><input type="text" class="form-control" id="txt_rsofficer122" name="txt_rsofficer122" value="<?= $result_seTenkobeforeofficer['TENKOPRESSUREDATA_60100'] ?>" onchange="edit_tenkobeforetxtofficer2(this.value, 'TENKOPRESSUREDATA_60100', '<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>')"></td>

                                                        </tr>
                                                         <tr>
                                                            <td>อัตราการเต้นหัวใจ : 60-100</td>
                                                            <td><input type="text" class="form-control" id="txt_rsofficer123" name="txt_rsofficer123" value="<?= $result_seTenkobeforeofficer['TENKOPRESSUREDATA_60110'] ?>" onchange="edit_tenkobeforetxtofficer2(this.value, 'TENKOPRESSUREDATA_60110', '<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>')"></td>

                                                        </tr>
                                                        
                                                        <tr>
                                                            <td style="text-align: center">3</td>
                                                            <td>ตรวจเช็คแอลกอฮอล์</td>
                                                            <td style="text-align: center"><input disabled="" type="checkbox" <?= $checkofficer13 ?> id="chk_officer13" name="chk_officer13"  style="transform: scale(2)"/></td>
                                                            <td>[0]</td>
                                                            <td><input type="text" class="form-control" id="txt_rsofficer13" name="txt_rsofficer13" value="<?= $result_seTenkobeforeofficer['TENKOALCOHOLDATA'] ?>" onchange="edit_tenkobeforetxtofficer4(this.value, 'TENKOALCOHOLDATA', '<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>')"></td>

                                                            <td style="text-align: center"><input disabled="" type="checkbox" <?= $rsofficer131 ?>  style="transform: scale(2)" id="chk_rsofficer131" name="chk_rsofficer131" /></td>
                                                            <td style="text-align: center"><input disabled="" type="checkbox" <?= $rsofficer130 ?>  style="transform: scale(2)" id="chk_rsofficer130" name="chk_rsofficer130" /></td>
                                                            <td colspan="4"><input type="text" id="txt_remark3" name="txt_remark3" class="form-control" onchange="edit_tenkobeforetxtremarkofficer(this.value, 'TENKOALCOHOLREMARK', '<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>')" value="<?= $result_seTenkobeforeofficer['TENKOALCOHOLREMARK'] ?>"></td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: center">4</td>
                                                            <td>ตรวจเช็คออกซิเจนเลือด</td>
                                                            <td style="text-align: center"><input disabled="" <?= $checkofficer14 ?> type="checkbox" id="chk_officer14"  name="chk_officer14"  style="transform: scale(2)"/></td>
                                                            <td></td>
                                                            <td><input type="text" class="form-control" id="txt_rsofficer14" name="txt_rsofficer14" value="<?= $result_seTenkobeforeofficer['TENKOOXYGENDATA'] ?>" onchange="edit_tenkobeforetxtofficer5(this.value, 'TENKOOXYGENDATA', '<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>')"></td>

                                                            <td style="text-align: center"><input disabled="" type="checkbox" <?= $rsofficer141 ?>  style="transform: scale(2)" id="chk_rsofficer141" name="chk_rsofficer141" /></td>
                                                            <td style="text-align: center"><input disabled="" type="checkbox" <?= $rsofficer140 ?>  style="transform: scale(2)" id="chk_rsofficer140" name="chk_rsofficer140" /></td>
                                                            <td colspan="4"><input type="text" id="txt_remark4" name="txt_remark4" class="form-control" onchange="edit_tenkobeforetxtremarkofficer(this.value, 'TENKOOXYGENREMARK', '<?= $result_seTenkobeforeofficer['TENKOBEFOREID'] ?>')" value="<?= $result_seTenkobeforeofficer['TENKOOXYGENREMARK'] ?>"></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>


                                        </div>
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>

                        </div>



                    </div>

                </div>
                <?php
                if ($_GET['companycode'] == 'RCC') {
                    $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', " AND COMPANYCODE = '" . $_GET['companycode'] . "'");
                } else if ($_GET['companycode'] == 'RATC') {
                    $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', " AND COMPANYCODE = '" . $_GET['companycode'] . "'");
                } else {
                    $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', " AND COMPANYCODE = '" . $_GET['companycode'] . "'");
                }
                if ($_GET['companycode'] == 'RRC' || $_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RATC') {
                    $thainame = select_carautocomplate('megVehicleinfo_v2', 'selectcond_vehicleinfo', " AND a.THAINAME != '-' AND (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%'", " OR a.THAINAME LIKE '%ดินแดง%'  OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%'  ", " OR a.THAINAME LIKE '%RP-%' OR a.THAINAME  LIKE '%สวนผึ้ง%' OR a.THAINAME  LIKE '%ด่านช้าง%'", " OR a.ENGNAME LIKE '%Khao Chamao%' OR a.ENGNAME LIKE '%Kerry%' OR a.ENGNAME LIKE '%Chaloem Prakiat%')");
                } else {
                    $thainame = select_vehiclenumberautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', '');
                }
                $jobrccend = select_jobautocomplateendgetway('megVehicletransportprice_v2', 'select_to', '');


                $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employee', " ");
                $cluster = select_clusterautocomplate('megVehicletransportprice_v2', 'select_cluster', '');
                ?>


 <!--<script src="../vendor/jquery/jquery.min.js"></script>-->
                <script src="../vendor/jquery/jquery.min.js"></script>
                <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
                <script src="../vendor/metisMenu/metisMenu.min.js"></script>
                <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
                <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
                <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
                <script src="../dist/js/sb-admin-2.js"></script>
                <script src="../js/jquery.datetimepicker.full.js"></script>
                <script src="../dist/js/jquery.autocomplete.js"></script>
                <script src="../dist/js/bootstrap-select.js"></script>








            </body>

            <script>

                                                                function commit()
                                                                {

                                                                    rs_checkoffice();



                                                                }
                                                                function edit_tenkobeforetxtremarkofficer(editableObj, fieldname, ID)
                                                                {
                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "edit_tenkobeforeofficer1", editableObj: editableObj, ID: ID, fieldname: fieldname
                                                                        },
                                                                        success: function () {
                                                                            
                                                                        }
                                                                    });
                                                                }
                                                                function edit_tenkobeforetxtofficer1(editableObj, fieldname, ID)
                                                                {
                                                                   
                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "edit_tenkobeforeofficer1", editableObj: editableObj, ID: ID, fieldname: fieldname
                                                                        },
                                                                        success: function () {
                                                                            

                                                                        
                                                                            if (document.getElementById("txt_rsofficer11").value != "")
                                                                            {
                                                                                if (document.getElementById("txt_rsofficer11").value < 37.5)
                                                                                {
                                                                                    document.getElementById("chk_rsofficer111").checked = true;
                                                                                    document.getElementById("chk_rsofficer110").checked = false;
                                                                                    edit_tenkobeforechk('1', 'TENKOTEMPERATURERESULT', ID);

                                                                                } else
                                                                                {

                                                                                    document.getElementById("chk_rsofficer110").checked = true;
                                                                                    document.getElementById("chk_rsofficer111").checked = false;
                                                                                    edit_tenkobeforechk('0', 'TENKOTEMPERATURERESULT', ID);
                                                                                }
                                                                                document.getElementById("chk_officer11").checked = true;
                                                                                edit_tenkobeforechk('1', 'TENKOTEMPERATURECHECK', ID);
                                                                            } else
                                                                            {
                                                                                document.getElementById("chk_officer11").checked = false;
                                                                                edit_tenkobeforechk('', 'TENKOTEMPERATURECHECK', ID);
                                                                                document.getElementById("chk_rsofficer110").checked = true;
                                                                                document.getElementById("chk_rsofficer111").checked = false;
                                                                                edit_tenkobeforechk('0', 'TENKOTEMPERATURERESULT', ID);
                                                                            }



                                                                        }
                                                                    });

                                                                }
                                                                function edit_tenkobeforetxtofficer2(editableObj, fieldname, ID)
                                                                {

                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "edit_tenkobeforeofficer1", editableObj: editableObj, ID: ID, fieldname: fieldname
                                                                        },
                                                                        success: function () {
                                                                            if (document.getElementById("txt_rsofficer121").value != "")
                                                                            {
                                                                                if ((document.getElementById("txt_rsofficer121").value > 89 && document.getElementById("txt_rsofficer121").value < 141) && 
                                                                                        (document.getElementById("txt_rsofficer122").value > 59 && document.getElementById("txt_rsofficer122").value < 91) &&
                                                                                        (document.getElementById("txt_rsofficer123").value > 59 && document.getElementById("txt_rsofficer123").value < 101))
                                                                                {

                                                                                    document.getElementById("chk_rsofficer121").checked = true;
                                                                                    document.getElementById("chk_rsofficer120").checked = false;
                                                                                    edit_tenkobeforechk('1', 'TENKOPRESSURERESULT', ID);
                                                                                } else
                                                                                {
                                                                                    document.getElementById("chk_rsofficer120").checked = true;
                                                                                    document.getElementById("chk_rsofficer121").checked = false;
                                                                                    edit_tenkobeforechk('0', 'TENKOPRESSURERESULT', ID);

                                                                                }
                                                                                document.getElementById("chk_officer12").checked = true;
                                                                                edit_tenkobeforechk('1', 'TENKOPRESSURECHECK', ID);
                                                                            } else
                                                                            {
                                                                                document.getElementById("chk_officer12").checked = false;
                                                                                edit_tenkobeforechk('', 'TENKOPRESSURECHECK', ID);
                                                                                document.getElementById("chk_rsofficer120").checked = true;
                                                                                document.getElementById("chk_rsofficer121").checked = false;
                                                                                edit_tenkobeforechk('0', 'TENKOPRESSURERESULT', ID);
                                                                            }

                                                                        }
                                                                    });

                                                                }
                                                                
                                                                
                                                                function edit_tenkobeforetxtofficer4(editableObj, fieldname, ID)
                                                                {

                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "edit_tenkobeforeofficer1", editableObj: editableObj, ID: ID, fieldname: fieldname
                                                                        },
                                                                        success: function () {

                                                                            if (document.getElementById("txt_rsofficer13").value != "")
                                                                            {
                                                                                if (document.getElementById("txt_rsofficer13").value > 0)
                                                                                {
                                                                                    document.getElementById("chk_rsofficer130").checked = true;
                                                                                    document.getElementById("chk_rsofficer131").checked = false;
                                                                                    edit_tenkobeforechk('0', 'TENKOALCOHOLRESULT', ID);
                                                                                } else
                                                                                {
                                                                                    document.getElementById("chk_rsofficer131").checked = true;
                                                                                    document.getElementById("chk_rsofficer130").checked = false;
                                                                                    edit_tenkobeforechk('1', 'TENKOALCOHOLRESULT', ID);
                                                                                }
                                                                                document.getElementById("chk_officer13").checked = true;
                                                                                edit_tenkobeforechk('1', 'TENKOALCOHOLCHECK', ID);
                                                                            } else
                                                                            {
                                                                                document.getElementById("chk_officer13").checked = false;
                                                                                edit_tenkobeforechk('', 'TENKOALCOHOLCHECK', ID);
                                                                                document.getElementById("chk_rsofficer130").checked = true;
                                                                                document.getElementById("chk_rsofficer131").checked = false;
                                                                                edit_tenkobeforechk('0', 'TENKOALCOHOLRESULT', ID);
                                                                            }

                                                                        }
                                                                    });

                                                                }
                                                                function edit_tenkobeforetxtofficer5(editableObj, fieldname, ID)
                                                                {

                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "edit_tenkobeforeofficer1", editableObj: editableObj, ID: ID, fieldname: fieldname
                                                                        },
                                                                        success: function () {

                                                                            if (document.getElementById("txt_rsofficer14").value != "")
                                                                            {
                                                                                if (document.getElementById("txt_rsofficer14").value > 0)
                                                                                {
                                                                                    document.getElementById("chk_rsofficer141").checked = true;
                                                                                    document.getElementById("chk_rsofficer140").checked = false;
                                                                                    edit_tenkobeforechk('1', 'TENKOOXYGENRESULT', ID);
                                                                                } else
                                                                                {
                                                                                    document.getElementById("chk_rsofficer140").checked = true;
                                                                                    document.getElementById("chk_rsofficer141").checked = false;
                                                                                    edit_tenkobeforechk('0', 'TENKOOXYGENRESULT', ID);
                                                                                }
                                                                                document.getElementById("chk_officer14").checked = true;
                                                                                edit_tenkobeforechk('1', 'TENKOOXYGENCHECK', ID);
                                                                            } else
                                                                            {
                                                                                document.getElementById("chk_officer14").checked = false;
                                                                                edit_tenkobeforechk('', 'TENKOOXYGENCHECK', ID);
                                                                                document.getElementById("chk_rsofficer140").checked = true;
                                                                                document.getElementById("chk_rsofficer141").checked = false;
                                                                                edit_tenkobeforechk('0', 'TENKOOXYGENRESULT', ID);
                                                                            }

                                                                        }
                                                                    });

                                                                }
                                                                
                                                                function rs_checkoffice()
                                                                {
                                                                    if (document.getElementById('txt_rsofficer11').value != "" && document.getElementById('txt_rsofficer121').value != "" && document.getElementById('txt_rsofficer122').value != "" && document.getElementById('txt_rsofficer13').value != "" && document.getElementById('txt_rsofficer14').value != "")
                                                                    {
                                                                        if ((document.getElementById('txt_rsofficer11').value > 0 && document.getElementById('txt_rsofficer11').value < 37.5) && 
                                                                                (document.getElementById('txt_rsofficer121').value > 89 && document.getElementById('txt_rsofficer121').value < 141) && 
                                                                                (document.getElementById('txt_rsofficer122').value > 59 && document.getElementById('txt_rsofficer122').value < 91) && 
                                                                                (document.getElementById("txt_rsofficer123").value > 59 && document.getElementById("txt_rsofficer123").value < 101) &&
                                                                                (document.getElementById('txt_rsofficer13').value == 0) && (document.getElementById('txt_rsofficer14').value > 0))
                                                                        {

                                                                            document.getElementById('icon_officecheckok').style.display = "";
                                                                            document.getElementById('icon_officecheckno').style.display = "none";
                                                                            document.getElementById('icon_officeresultok').style.display = "";
                                                                            document.getElementById('icon_officeresultno').style.display = "none";
                                                                        } else
                                                                        {

                                                                            document.getElementById('icon_officecheckok').style.display = "";
                                                                            document.getElementById('icon_officecheckno').style.display = "none";
                                                                            document.getElementById('icon_officeresultok').style.display = "none";
                                                                            document.getElementById('icon_officeresultno').style.display = "";
                                                                        }
                                                                    } else
                                                                    {

                                                                        document.getElementById('icon_officecheckok').style.display = "none";
                                                                        document.getElementById('icon_officecheckno').style.display = "";
                                                                        document.getElementById('icon_officeresultok').style.display = "none";
                                                                        document.getElementById('icon_officeresultno').style.display = "";
                                                                    }



                                                                }
                                                                function edit_tenkobeforechk(editableObj, fieldname, ID)
                                                                {

                                                                    //editTenkobefore('edit_tenkobefore', $result_seTenkobefore['TENKOBEFOREID'], 'TENKORESTDATA', $result_seChktenkorest['TENKORESTDATA']);
                                                                    //editTenkobefore('edit_tenkobefore', $result_seTenkobefore['TENKOBEFOREID'], 'TENKORESTRESULT', 1);




<?php
if ($result_sePlain['COMPANYCODE'] == 'RCC' || $result_sePlain['COMPANYCODE'] == 'RRC' || $result_sePlain['COMPANYCODE'] == 'RATC') {
    ?>
                                                                        $.ajax({
                                                                            url: 'meg_data.php',
                                                                            type: 'POST',
                                                                            data: {
                                                                                txt_flg: "edit_tenkobeforeofficer1", editableObj: '<?= $result_seChktenkorest['TENKORESTDATA'] ?>', ID: '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>', fieldname: 'TENKORESTDATA'
                                                                            },
                                                                            success: function () {



                                                                            }
                                                                        });


                                                                        $.ajax({
                                                                            url: 'meg_data.php',
                                                                            type: 'POST',
                                                                            data: {
                                                                                txt_flg: "edit_tenkobeforeofficer1", editableObj: '1', ID: '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>', fieldname: 'TENKORESTDATA'
                                                                            },
                                                                            success: function () {



                                                                            }
                                                                        });
    <?php
}
?>

                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "edit_tenkobeforeofficer1", editableObj: editableObj, ID: ID, fieldname: fieldname
                                                                        },
                                                                        success: function () {



                                                                        }
                                                                    });
                                                                }

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

            </script>
            <script>
                $(function () {
                    $('[data-toggle="popover"]').popover({
                        html: true,
                        content: function () {
                            return $('#popover-content').html();
                        }
                    });
                }
                )
            </script>
        </html>


        <?php
        sqlsrv_close($conn);
        ?>
