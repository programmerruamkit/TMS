<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$condition1 = " AND (a.USERNAME ='" . $_SESSION["USERNAME"] . "' AND a.PASSWORD = '" . $_SESSION["PASSWORD"] . "') AND a.ACTIVESTATUS = 1";
$sql_seLogin = "{call megRoleaccount_v2(?,?)}";
$params_seLogin = array(
    array('select_roleaccount', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seLogin = sqlsrv_query($conn, $sql_seLogin, $params_seLogin);
$result_seLogin = sqlsrv_fetch_array($query_seLogin, SQLSRV_FETCH_ASSOC);

// $sql_seSystime = "{call megGetdate_v2(?)}";
// $params_seSystime = array(
//     array('select_getdate', SQLSRV_PARAM_IN)
// );
// $query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
// $result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);


$conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "'";
$sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
$params_sePlain = array(
    array('select_vehicletransportplan', SQLSRV_PARAM_IN),
    array($conditionPlain, SQLSRV_PARAM_IN)
);
$query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
$result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);


// $conditionDir1 = ($_GET['vehicletransportplanid'] != "") ? " AND a.PersonCode = '" . $result_sePlain["EMPLOYEECODE1"] . "'" : " AND a.PersonCode = '" . $_GET["employeecode1"] . "'";
// //$conditionDir1 = "  AND a.PersonCode = '" . $result_sePlain["EMPLOYEECODE1"] . "'";
// //$conditionDir1 = "  AND a.PersonCode = '" . $_GET["employeecode1"] . "'";

// $sql_seDir1 = "{call megEmployeeEHR_v2(?,?)}";
// $params_seDir1 = array(
//     array('select_employee', SQLSRV_PARAM_IN),
//     array($conditionDir1, SQLSRV_PARAM_IN)
// );
// $query_seDir1 = sqlsrv_query($conn, $sql_seDir1, $params_seDir1);
// $result_seDir1 = sqlsrv_fetch_array($query_seDir1, SQLSRV_FETCH_ASSOC);


// $conditionDir2 = "  AND a.PersonCode = '" . $result_sePlain["EMPLOYEECODE2"] . "'";
// $sql_seDir2 = "{call megEmployeeEHR_v2(?,?)}";
// $params_seDir2 = array(
//     array('select_employee', SQLSRV_PARAM_IN),
//     array($conditionDir2, SQLSRV_PARAM_IN)
// );
// $query_seDir2 = sqlsrv_query($conn, $sql_seDir2, $params_seDir2);
// $result_seDir2 = sqlsrv_fetch_array($query_seDir2, SQLSRV_FETCH_ASSOC);



$condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmployee = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
$result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);

$empcode = ($_GET['employeecode1'] != "") ? $_GET['employeecode1'] : $_GET['employeecode2'];
$condition2 = "  AND a.PersonCode = '" . $empcode . "'";
$sql_seEmployee2 = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmployee2 = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($condition2, SQLSRV_PARAM_IN)
);
$query_seEmployee2 = sqlsrv_query($conn, $sql_seEmployee2, $params_seEmployee2);
$result_seEmployee2 = sqlsrv_fetch_array($query_seEmployee2, SQLSRV_FETCH_ASSOC);


$conditionTenkomaster_temp = " AND VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "'";
$sql_seTenkomaster_temp = "{call megVehicletransportplan_v2(?,?,?,?)}";
$params_seTenkomaster_temp = array(
    array('select_vehicletransporttenko', SQLSRV_PARAM_IN),
    array($conditionTenkomaster_temp, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seTenkomaster_temp = sqlsrv_query($conn, $sql_seTenkomaster_temp, $params_seTenkomaster_temp);
$result_seTenkomaster_temp = sqlsrv_fetch_array($query_seTenkomaster_temp, SQLSRV_FETCH_ASSOC);


$conditionTenkobefore1 = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND a.TENKOMASTERDIRVERCODE = '" . $_GET['employeecode1'] . "'";
$sql_seTenkobefore1 = "{call megEdittenkobefore_v2(?,?,?)}";
$params_seTenkobefore1 = array(
    array('select_tenkobefore', SQLSRV_PARAM_IN),
    array($conditionTenkobefore1, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seTenkobefore1 = sqlsrv_query($conn, $sql_seTenkobefore1, $params_seTenkobefore1);
$result_seTenkobefore1 = sqlsrv_fetch_array($query_seTenkobefore1, SQLSRV_FETCH_ASSOC);


$conditionTenkobefore2 = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND a.TENKOMASTERDIRVERCODE = '" . $_GET['employeecode2'] . "'";
$sql_seTenkobefore2 = "{call megEdittenkobefore_v2(?,?,?)}";
$params_seTenkobefore2 = array(
    array('select_tenkobefore', SQLSRV_PARAM_IN),
    array($conditionTenkobefore2, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seTenkobefore2 = sqlsrv_query($conn, $sql_seTenkobefore2, $params_seTenkobefore2);
$result_seTenkobefore2 = sqlsrv_fetch_array($query_seTenkobefore2, SQLSRV_FETCH_ASSOC);


$conditionTenkomaster = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "'";
$sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
$params_seTenkomaster = array(
    array('select_tenkomaster', SQLSRV_PARAM_IN),
    array($conditionTenkomaster, SQLSRV_PARAM_IN)
);
$query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
$result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);


$condition1 = ($_SESSION["EMPLOYEEID"] != "") ? " AND a.EMPLOYEEID = '" . $_SESSION["EMPLOYEEID"] . "'" : "";
//$condition1 = ($_SESSION["EMPLOYEEID"] != "") ? " AND a.EMPLOYEEID = 238" : "";
$sql_sePremissions = "{call megRoleaccount_v2(?,?)}";
$params_sePremissions = array(
    array('select_permissions', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_sePremissions = sqlsrv_query($conn, $sql_sePremissions, $params_sePremissions);
$result_sePremissions = sqlsrv_fetch_array($query_sePremissions, SQLSRV_FETCH_ASSOC);


$sql_checkSexT = "SELECT SexT AS 'SexT' FROM EMPLOYEEEHR2 WHERE PersonCode ='" . $empcode . "'";
$params_checkSexT = array();
$query_checkSexT = sqlsrv_query($conn, $sql_checkSexT, $params_checkSexT);
$result_checkSexT = sqlsrv_fetch_array($query_checkSexT, SQLSRV_FETCH_ASSOC);

if ($result_checkSexT['SexT'] == 'หญิง') {
    $sex = 'นางสาว';
}else{
    $sex = 'นาย';
}
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

         <!-- Zoom CSS -->
         <link rel="stylesheet" type="text/css" href="css/zoom.css">

        <style>
            .navbar-default {

                border-color: #ffcb0b;
            }
            #page-wrapper {
                border-left: 1px solid #ffcb0b;
            }
            .chat-panel .panel-body {
                height: 100%;
            }

            .container {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            }

            /* Hide the browser's default checkbox */
            .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
            }

            /* Create a custom checkbox */
            .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #8e8e8e;
            }

            /* On mouse-over, add a grey background color */
            .container:hover input ~ .checkmark {
            background-color: #ccc;
            }

            /* When the checkbox is checked, add a blue background */
            .container input:checked ~ .checkmark {
            background-color: #05ad16;
            }

            /* Create the checkmark/indicator (hidden when not checked) */
            .checkmark:after {
            content: "";
            position: absolute;
            display: none;
            }

            /* Show the checkmark when checked */
            .container input:checked ~ .checkmark:after {
            display: block;
            }

            /* Style the checkmark/indicator */
            .container .checkmark:after {
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
            }
/* 
            .blink-bg{
                color: #fff;
                padding: 10px;
                width: 200px;
                height: 40px;
                display: inline-block;
                border-radius: 5px;
                animation: blinkingBackground 2s infinite;
            }
            @keyframes blinkingBackground{
                0%		{ background-color: #f70505;}
                25%		{ background-color: #f53636;}
                50%		{ background-color: #ff6666;}
                75%		{ background-color: #f70505;}
                100%	{ background-color: #f53636;}
            } */
            </style>
    </head>
    <body>
        <div class="modal fade" id="modal_history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 40%">
                <div class="modal-content" >
                    <?php
                    if ($_GET['employeecode1'] != "") {
                        $sql_seHistory = "SELECT ID, EMPLOYEECODE, HEALTHISSUE, SUGGESTION, COMMENT FROM [dbo].[EMPLOYEEHEALTH] WHERE 1 = 1  AND EMPLOYEECODE = '" . $_GET['employeecode1'] . "'";
                        $query_seHistory = sqlsrv_query($conn, $sql_seHistory, $params_seHistory);
                        $result_seHistory = sqlsrv_fetch_array($query_seHistory, SQLSRV_FETCH_ASSOC);
                    } else if ($_GET['employeecode2'] != "") {
                        $sql_seHistory = "SELECT ID, EMPLOYEECODE, HEALTHISSUE, SUGGESTION, COMMENT FROM [dbo].[EMPLOYEEHEALTH] WHERE 1 = 1  AND EMPLOYEECODE = '" . $_GET['employeecode2'] . "'";
                        $query_seHistory = sqlsrv_query($conn, $sql_seHistory, $params_seHistory);
                        $result_seHistory = sqlsrv_fetch_array($query_seHistory, SQLSRV_FETCH_ASSOC);
                    }
                    ?>

                    <div class="modal-header" style="font-size: 36px">
                        <div class="row">
                            <div class="col-lg-12">
                                <b>ประวัติสุขภาพ : <?= $result_seHistory['EMPLOYEECODE'] ?></b>
                            </div>

                        </div>
                    </div>
                    <div class="modal-body" style="font-size: 24px">




                        <div class="row" >
                            <div class="col-lg-12">
                                <b>โรคประจำตัว</b> : <?= $result_seHistory['HEALTHISSUE'] ?>
                            </div>
                            <div class="col-lg-12">
                                <b>คำแนะนำ</b> : <?= $result_seHistory['SUGGESTION'] ?>
                            </div>
                            <div class="col-lg-12">
                                <b>หมายเหตุ</b> : <?= $result_seHistory['COMMENT'] ?>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                    </div>





                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_tenkorestremark" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 40%">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-5">
                                <h5 class="modal-title" ><b>ช่วงเวลาการพักผ่อน</b></h5>
                            </div>

                        </div>
                    </div>
                    <div class="modal-body">




                        <div class="row">
                            <div class="col-lg-6">
                                <label>เวลาเริ่มพักผ่อน  </label>
                                <input type="text" autocomplete="off"   class="form-control datetimeen" id="txt_startrest" name="txt_startrest">

                            </div>
                            <div class="col-lg-6">
                                <label>เวลาตื่นพักผ่อน  </label>
                                <input type="text" autocomplete="off"   class="form-control datetimeen" id="txt_endrest" name="txt_endrest">

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="save_tenkorestremark()">บันทึก</button>
                    </div>





                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_tenkosleeptimeremark" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 40%">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-5">
                                <h5 class="modal-title" ><b>ช่วงเวลาการนอน</b></h5>
                            </div>

                        </div>
                    </div>
                    <div class="modal-body">




                        <div class="row">
                            <div class="col-lg-6">
                                <label>เวลาเริ่มนอน  </label>
                                <input type="text" autocomplete="off"   class="form-control datetimeen" id="txt_startsleep" name="txt_startsleep">

                            </div>
                            <div class="col-lg-6">
                                <label>เวลาตื่นนอน  </label>
                                <input type="text" autocomplete="off"   class="form-control datetimeen" id="txt_endsleep" name="txt_endsleep">

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="save_tenkosleeptimeremark()">บันทึก</button>
                    </div>





                </div>
            </div>
        </div>
        <!-- modal แสดงข้อมูล Simulator และ Accident TenkoNG -->
        <div class="modal fade" id="myModalinsert" role="dialog">
            <div class="modal-dialog" style="width: 1500px; height: 170px;">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><b>ข้อมูล Simulator และ Accident</b></h4>
                </div>
                        <div class="modal-body">
                        <input type="text" hidden id="txt_month" name="txt_month" value="<?=$month?>"></input>
                        <input type="text" hidden id="txt_years" name="txt_years" value="<?=$years?>"></input>        

                        </div> <!-- END Modal body-->

                        <div class="panel-body">
                        <!-- Nav tabs -->
                        <!-- <ul class="nav nav-pills">
                            <li class="active">
                                <a href="#tap_kpi1" data-toggle="tab" aria-expanded="true">บันทึกข้อมูล Tenko NG</a>
                            </li>
                            <li>
                                <a href="#tap_kpi2" data-toggle="tab">แก้ไขข้อมูล Tenko NG</a>
                            </li>

                        </ul> -->
                        <?php
                            if ($_GET['employeecode1'] != "") {
                                $sql_seSimuData = "SELECT TOP 1 DRIVERCODE,DRIVERNAME,YEARSSIMU,TLEP_FIRSTDATE,TLEP_FOLLOWUP,SIMUDATA,CREATEBY,CREATEDATE
                                    FROM  [dbo].[SIMULATORHISTORY] 
                                    WHERE DRIVERCODE = '".$_GET['employeecode1']."'
                                    ORDER BY TLEP_FOLLOWUP ASC
                                    --AND YEARSSIMU =  YEAR(GETDATE())";
                                $params_seSimuData = array();
                                $query_seSimuData  = sqlsrv_query($conn, $sql_seSimuData , $params_seSimuData);
                                $result_seSimuData  = sqlsrv_fetch_array($query_seSimuData , SQLSRV_FETCH_ASSOC);
                                
                                $sql_seEmp = "SELECT  BirthDate103,StartDate FROM EMPLOYEEEHR2
                                    WHERE PersonCode ='".$_GET['employeecode1']."'";
                                $params_seEmp = array();
                                $query_seEmp  = sqlsrv_query($conn, $sql_seEmp , $params_seEmp);
                                $result_seEmp  = sqlsrv_fetch_array($query_seEmp , SQLSRV_FETCH_ASSOC);
                                

                                ///คำนวนหาอายุงาน
                                // $datework = $result_seEmp['StartDate'];

                                $day =  substr($result_seEmp['StartDate'],0,2);
                                $month =  substr($result_seEmp['StartDate'],3,2);
                                $year =  substr($result_seEmp['StartDate'],6);

                                $datework = $month."/".$day."/".$year;


                                $sql_CalculateWork = "{call megCalculatorDate(?,?)}";
                                $params_CalculateWork = array(
                                    array('calculate_work', SQLSRV_PARAM_IN),
                                    array($datework, SQLSRV_PARAM_IN)
                                );
                                $query_CalculateWork = sqlsrv_query($conn, $sql_CalculateWork, $params_CalculateWork);
                                $result_CalculateWork = sqlsrv_fetch_array($query_CalculateWork, SQLSRV_FETCH_ASSOC);
                                // echo $result_CalculateWork['RS'];

                                ///คำนวนหาอายุตน

                                $dayAge =  substr($result_seEmp['BirthDate103'],0,2);
                                $monthAge =  substr($result_seEmp['BirthDate103'],3,2);
                                $yearAge =  substr($result_seEmp['BirthDate103'],6);

                                $dateworkAge = $monthAge."/".$dayAge."/".$yearAge;


                                $sql_CalculateAge = "{call megCalculatorDate(?,?)}";
                                $params_CalculateAge = array(
                                    array('calculate_work', SQLSRV_PARAM_IN),
                                    array($dateworkAge, SQLSRV_PARAM_IN)
                                );
                                $query_CalculateAge = sqlsrv_query($conn, $sql_CalculateAge, $params_CalculateAge);
                                $result_CalculateAge = sqlsrv_fetch_array($query_CalculateAge, SQLSRV_FETCH_ASSOC);
                                // echo $result_CalculateAge['RS'];

                                // $sql_seDriverAge = "SELECT BirthDate103,[yearb],monthb,dayb FROM EMPLOYEEEHR2
                                //     WHERE PersonCode ='".$_GET['employeecode1']."'";
                                // $params_seDriverAge = array();
                                // $query_seDriverAge  = sqlsrv_query($conn, $sql_seDriverAge , $params_seDriverAge);
                                // $result_seDriverAge  = sqlsrv_fetch_array($query_seDriverAge , SQLSRV_FETCH_ASSOC);

                                // $sql_seWorkAge = "SELECT StartDate,PassDate,StartWork,[yearw],monthw,dayw FROM EMPLOYEEEHR2
                                //     WHERE PersonCode ='".$_GET['employeecode1']."'";
                                // $params_seWorkAge = array();
                                // $query_seWorkAge  = sqlsrv_query($conn, $sql_seWorkAge , $params_seWorkAge);
                                // $result_seWorkAge  = sqlsrv_fetch_array($query_seWorkAge , SQLSRV_FETCH_ASSOC);

                                // //หาระยะเวลา กี่วัน กี่เดือน จากการทำ TLEP FOLLOW UP รูปแบบข้อมูล Y-m-d
                                // $followup_date = $result_seSimuData['TLEP_FOLLOWUP'];      
                                // $today = date("Y-m-d");   //จุดต้องเปลี่ยน

                                // // echo "<br>";
                                // // echo $today;
                                // // echo "<br>";

                                // list($byear, $bmonth, $bday)= explode("-",$followup_date);       
                                // list($tyear, $tmonth, $tday)= explode("-",$today);               

                                // $mfollowup_date = mktime(0, 0, 0, $bmonth, $bday, $byear); 
                                // $mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear );
                                // $mage = ($mnow - $mfollowup_date);

                                // // echo "วันเกิด $followup_date"."<br>\n";

                                // // echo "วันที่ปัจจุบัน $today"."<br>\n";

                                // // echo "รับค่า $mage"."<br>\n";

                                // $u_y = date("Y", $mage)-1970;
                                // $u_m = date("m",$mage);
                                // $u_d = date("d",$mage)-1;
                                
                                // $sql_seTlepY = "SELECT DATEDIFF(year,'".$result_seSimuData['TLEP_FOLLOWUP']."', GETDATE()) AS 'YEARDIFF'
                                //     FROM  [dbo].[SIMULATORHISTORY] 
                                //     WHERE DRIVERCODE = '".$_GET['employeecode1']."'
                                //     --AND YEARSSIMU =  YEAR(GETDATE())";
                                // $params_seTlepY = array();
                                // $query_seTlepY  = sqlsrv_query($conn, $sql_seTlepY , $params_seTlepY);
                                // $result_seTlepY  = sqlsrv_fetch_array($query_seTlepY , SQLSRV_FETCH_ASSOC);

                                // $sql_seTlepM = "SELECT DATEDIFF(month,'".$result_seSimuData['TLEP_FOLLOWUP']."', GETDATE()) AS 'MONTHDIFF'
                                //     FROM  [dbo].[SIMULATORHISTORY] 
                                //     WHERE DRIVERCODE = '".$_GET['employeecode1']."'
                                //     --AND YEARSSIMU =  YEAR(GETDATE())";
                                // $params_seTlepM = array();
                                // $query_seTlepM  = sqlsrv_query($conn, $sql_seTlepM , $params_seTlepM);
                                // $result_seTlepM  = sqlsrv_fetch_array($query_seTlepM , SQLSRV_FETCH_ASSOC);

                            } else if ($_GET['employeecode2'] != "") {
                                $sql_seSimuData = "SELECT TOP 1 DRIVERCODE,DRIVERNAME,YEARSSIMU,TLEP_FIRSTDATE,TLEP_FOLLOWUP,SIMUDATA,CREATEBY,CREATEDATE
                                    FROM  [dbo].[SIMULATORHISTORY] 
                                    WHERE DRIVERCODE = '".$_GET['employeecode2']."'
                                    ORDER BY TLEP_FOLLOWUP ASC
                                    --AND YEARSSIMU =  YEAR(GETDATE())";
                                $params_seSimuData = array();
                                $query_seSimuData  = sqlsrv_query($conn, $sql_seSimuData , $params_seSimuData);
                                $result_seSimuData  = sqlsrv_fetch_array($query_seSimuData , SQLSRV_FETCH_ASSOC);

                                // $sql_seDriverAge = "SELECT BirthDate103,[yearb],monthb,dayb FROM EMPLOYEEEHR2
                                //     WHERE PersonCode ='".$_GET['employeecode2']."'";
                                // $params_seDriverAge = array();
                                // $query_seDriverAge  = sqlsrv_query($conn, $sql_seDriverAge , $params_seDriverAge);
                                // $result_seDriverAge  = sqlsrv_fetch_array($query_seDriverAge , SQLSRV_FETCH_ASSOC);
                                
                                // $sql_seWorkAge = "SELECT StartDate,PassDate,StartWork,[yearw],monthw,dayw FROM EMPLOYEEEHR2
                                //     WHERE PersonCode ='".$_GET['employeecode2']."'";
                                // $params_seWorkAge = array();
                                // $query_seWorkAge  = sqlsrv_query($conn, $sql_seWorkAge , $params_seWorkAge);
                                // $result_seWorkAge  = sqlsrv_fetch_array($query_seWorkAge , SQLSRV_FETCH_ASSOC);

                                $sql_seEmp = "SELECT  BirthDate103,StartDate FROM EMPLOYEEEHR2
                                    WHERE PersonCode ='".$_GET['employeecode2']."'";
                                $params_seEmp = array();
                                $query_seEmp  = sqlsrv_query($conn, $sql_seEmp , $params_seEmp);
                                $result_seEmp  = sqlsrv_fetch_array($query_seEmp , SQLSRV_FETCH_ASSOC);
                                

                                ///คำนวนหาอายุงาน
                                // $datework = $result_seEmp['StartDate'];

                                $day =  substr($result_seEmp['StartDate'],0,2);
                                $month =  substr($result_seEmp['StartDate'],3,2);
                                $year =  substr($result_seEmp['StartDate'],6);

                                $datework = $month."/".$day."/".$year;


                                $sql_CalculateWork = "{call megCalculatorDate(?,?)}";
                                $params_CalculateWork = array(
                                    array('calculate_work', SQLSRV_PARAM_IN),
                                    array($datework, SQLSRV_PARAM_IN)
                                );
                                $query_CalculateWork = sqlsrv_query($conn, $sql_CalculateWork, $params_CalculateWork);
                                $result_CalculateWork = sqlsrv_fetch_array($query_CalculateWork, SQLSRV_FETCH_ASSOC);
                                // echo $result_CalculateWork['RS'];

                                ///คำนวนหาอายุตน

                                $dayAge =  substr($result_seEmp['BirthDate103'],0,2);
                                $monthAge =  substr($result_seEmp['BirthDate103'],3,2);
                                $yearAge =  substr($result_seEmp['BirthDate103'],6);

                                $dateworkAge = $monthAge."/".$dayAge."/".$yearAge;


                                $sql_CalculateAge = "{call megCalculatorDate(?,?)}";
                                $params_CalculateAge = array(
                                    array('calculate_work', SQLSRV_PARAM_IN),
                                    array($dateworkAge, SQLSRV_PARAM_IN)
                                );
                                $query_CalculateAge = sqlsrv_query($conn, $sql_CalculateAge, $params_CalculateAge);
                                $result_CalculateAge = sqlsrv_fetch_array($query_CalculateAge, SQLSRV_FETCH_ASSOC);
                                // echo $result_CalculateAge['RS'];

                                //   //หาระยะเวลา กี่วัน กี่เดือน จากการทำ TLEP FOLLOW UP รูปแบบข้อมูล Y-m-d
                                // $followup_date = $result_seSimuData['TLEP_FOLLOWUP'];      
                                // $today = date("Y-m-d");   //จุดต้องเปลี่ยน

                                // // echo "<br>";
                                // // echo $today;
                                // // echo "<br>";

                                // list($byear, $bmonth, $bday)= explode("-",$followup_date);       
                                // list($tyear, $tmonth, $tday)= explode("-",$today);               

                                // $mfollowup_date = mktime(0, 0, 0, $bmonth, $bday, $byear); 
                                // $mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear );
                                // $mage = ($mnow - $mfollowup_date);

                                // // echo "วันเกิด $followup_date"."<br>\n";

                                // // echo "วันที่ปัจจุบัน $today"."<br>\n";

                                // // echo "รับค่า $mage"."<br>\n";

                                // $u_y = date("Y", $mage)-1970;
                                // $u_m = date("m",$mage);
                                // $u_d = date("d",$mage)-1;
                                
                                

                            }
                            
        
                        ?>
                        <table style="width:80%;border:1px solid black;">
                            <tr>
                                <th colspan ="27" style="background-color: #bfbfbf;border:1px solid black;text-align: center;font-size: 18px;">ข้อมูล Simulator</th>
                                <?php
                                   if ($_GET['employeecode1'] != "") {
                                ?>
                                    <th colspan ="4" rowspan="8" style="border:1px solid black;text-align: center;font-size: 18px;width:140px;"><img width="100%"   src="../images/employee/<?= $_GET['employeecode1'] ?>.JPG"></th>
                                <?php

                                    } else if ($_GET['employeecode2'] != "") {
                                ?>
                                    <th colspan ="4" rowspan="8" style="border:1px solid black;text-align: center;font-size: 18px;width:140px;"><img width="100%" src="../images/employee/<?= $_GET['employeecode2'] ?>.JPG"></th>
                                <?php  
                                    }

                                ?>
                                
                            </tr>
                            <tr>
                                <td colspan ="3" style="border:1px solid black;font-size: 16px;background-color: #bfbfbf;"> &nbsp;<b>รหัสพนักงาน</b></td>
                                <td colspan ="4" style="border:1px solid black;">&nbsp; <?=$result_seEmployee2['PersonCode']?></td>
                                <td colspan ="3" style="border:1px solid black;font-size: 16px;background-color: #bfbfbf;">&nbsp;<b>ชื่อพนักงาน</b></td>
                                <td colspan ="4" style="border:1px solid black;">&nbsp; <?=$result_seEmployee2['nameT']?></td>
                                <td colspan ="3" style="border:1px solid black;font-size: 16px;background-color: #bfbfbf;">&nbsp;<b>อายุตน</b></td>
                                <td colspan ="4" style="border:1px solid black;">&nbsp; <?= $result_CalculateAge['RS']?></td>
                                <td colspan ="3" style="border:1px solid black;font-size: 16px;background-color: #bfbfbf;">&nbsp;<b>อายุงาน</b></td>
                                <td colspan ="3" style="border:1px solid black;">&nbsp; <?= $result_CalculateWork['RS']?></td>
                                
                            </tr>
                            <tr>
                            <td colspan ="3" style="border:1px solid black;font-size: 16px;background-color: #bfbfbf;">&nbsp;<b>วันที่ TLEP ครั้งแรก</b></td>
                                <td colspan ="4" style="border:1px solid black;">&nbsp; <?= $result_seSimuData['TLEP_FIRSTDATE'] ?></td>
                                <td colspan ="3" style="border:1px solid black;font-size: 16px;background-color: #bfbfbf;">&nbsp;<b>TLEP Follow Up</b></td>
                                <td colspan ="4" style="border:1px solid black;">&nbsp; <?= $result_seSimuData['TLEP_FOLLOWUP'] ?></td>
                                <td colspan ="3" style="border:1px solid black;font-size: 16px;background-color: #bfbfbf;">&nbsp;<b>T-LEP Years</b></td>
                                <td colspan ="10" style="border:1px solid black;">&nbsp;  <?= $u_y ?> Year <?= $u_m ?> Month</td>
                            </tr>
                            <tr>
                                <td colspan ="3" style="border:1px solid black;font-size: 16px;background-color: #bfbfbf;">&nbsp;<b>Driving Simulator</b></td>
                                <td colspan ="24" style="border:1px solid black;">&nbsp;  <?= $result_seSimuData['SIMUDATA'] ?></td>
                            </tr>
                            <tr>
                                <td colspan ="21" style="font-size: 16px;">&nbsp;<b></b></td>
                            </tr>
                            <tr>
                                <td colspan ="21" style="font-size: 16px;">&nbsp;<b></b></td>
                            </tr>
                            <tr>
                                <td colspan ="21" style="font-size: 16px;">&nbsp;<b></b></td>
                            </tr>
                            <tr>
                                <td colspan ="21" style="font-size: 16px;">&nbsp;<b></b></td>
                            </tr>
                        </table>
                        
                        <div class="tab-content">
                         
                            <!-- //////////////////ข้อมูลอุบัติเหตุของพนักงาน////////////////////////////// -->
                            <div class="tab-pane fade active in" id="tap_kpi1">
                            <p id="demo"></p>
                                <br><br>
                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example3" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;font-size:14px">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;background-color: #bfbfbf;">วันที่เวลาที่เกิดอุบัติเหตุ</th>
                                            <th style="text-align: center;background-color: #bfbfbf;">สถานที่เกิดอุบัติเหตุ</th>
                                            <th style="text-align: center;background-color: #bfbfbf;">ปัญหาของอุบัติเหตุ</th>
                                            <th style="text-align: center;background-color: #bfbfbf;">MAN</th>
                                            <th style="text-align: center;width:10px;height:30px;background-color: #bfbfbf;">METHOD</th>
                                            <th style="text-align: center;width:10px;height:30px;background-color: #bfbfbf;">MECHINE</th>
                                            <th style="text-align: center;width:10px;height:30px;background-color: #bfbfbf;">ENVIRONMENT</th>
                                            <th style="text-align: center;width:10px;height:30px;background-color: #bfbfbf;">หมายเหตุ</th>
                                            <th style="text-align: center;width:10px;height:30px;background-color: #bfbfbf;">ประเภทของอุบัติเหตุ</th>
                                           
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;

                                         
                                            if ($_GET['employeecode1'] != "") {
                                                $sql_seAccidentData = "SELECT ACCI_ID,DRIVERNAME,DRIVERCODE,YEARS,CONVERT(VARCHAR(10),DATETIMEACCIDENT,103) AS 'DATE',
                                                    CONVERT(VARCHAR(5),CONVERT(DATETIME, DATETIMEACCIDENT, 0), 108) AS 'TIME',
                                                    DATETIMEACCIDENT,LOCATIONACCIDENT,PROBLEMACCIDENT,
                                                    DETAILMAN,DETAILMETHOD,DETAILMECHINE,DETAILENVIRONMENT,REMARK,TYPEACCIDENT
                                                    FROM ACCIDENTHISTORY
                                                    WHERE DRIVERCODE = '".$_GET['employeecode1']."'
                                                    ORDER BY YEARS,DATETIMEACCIDENT ASC";
                                                $params_seAccidentData = array();
                                                $query_seAccidentData = sqlsrv_query($conn, $sql_seAccidentData, $params_seAccidentData);

                                            } else if ($_GET['employeecode2'] != "") {
                                                $sql_seAccidentData = "SELECT ACCI_ID,DRIVERNAME,DRIVERCODE,YEARS,CONVERT(VARCHAR(10),DATETIMEACCIDENT,103) AS 'DATE',
                                                    CONVERT(VARCHAR(5),CONVERT(DATETIME, DATETIMEACCIDENT, 0), 108) AS 'TIME',
                                                    DATETIMEACCIDENT,LOCATIONACCIDENT,PROBLEMACCIDENT,
                                                    DETAILMAN,DETAILMETHOD,DETAILMECHINE,DETAILENVIRONMENT,REMARK,TYPEACCIDENT
                                                    FROM ACCIDENTHISTORY
                                                    WHERE DRIVERCODE = '".$_GET['employeecode2']."'
                                                    ORDER BY YEARS,DATETIMEACCIDENT ASC";
                                                $params_seAccidentData = array();
                                                $query_seAccidentData = sqlsrv_query($conn, $sql_seAccidentData, $params_seAccidentData);    
                                            }
                                            while ($result_seAccidentData = sqlsrv_fetch_array($query_seAccidentData, SQLSRV_FETCH_ASSOC)) {
                                                ?>
                                                <tr>
                                                    <td><?= $result_seAccidentData['DATE'] ?> <?=$result_seAccidentData['TIME']?></td>
                                                    <td><?= $result_seAccidentData['LOCATIONACCIDENT'] ?></td>
                                                    <td><?= $result_seAccidentData['PROBLEMACCIDENT'] ?></td>
                                                    <td><?= $result_seAccidentData['DETAILMAN'] ?></td>
                                                    <td><?= $result_seAccidentData['DETAILMETHOD'] ?></td>
                                                    <td><?= $result_seAccidentData['DETAILMECHINE'] ?></td>
                                                    <td><?= $result_seAccidentData['DETAILENVIRONMENT'] ?></td>
                                                    <td><?= $result_seAccidentData['REMARK'] ?></td>
                                                    <td><?= $result_seAccidentData['TYPEACCIDENT'] ?></td>
                                                </tr>
                                                <?php
                                                $i++;

                                                
                                            }
                                            ?>
                                        </tbody>
                                </table>    
                                    

                                <!-- <div class="row">&nbsp;</div>
                                <div class="row">&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <button type="button" class="btn btn-primary" onclick="select_companyoilaverageday()">EXCELDAY <i class="fa fa-file-excel-o"></i></button>
                                    </div>
                                </div> -->

                            </div>
                            
                            
                            <!-- ////////////////////ข้อมูลค่าเฉลี่ยน้ำมันรายวัน/เดือน////////////////////// -->
                            


                        </div>
                    </div>
                    <div class="modal-footer">                                            
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>

            </div>
          </div>
        </div>

        <!-- Modal FeedBack Driver -->
        

        <!-- Modal FeedBack  -->
        <div class="modal fade" id="myModalFeedback" role="dialog">
            <div class="modal-dialog" style="width: 1500px; height: 170px;">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><b>Feedback Driver TEST</b></h4>
                </div>
                        <div class="modal-body">
                        <?php

                        $sql_seMonth = "SELECT FORMAT(GETDATE(),'MMMM') AS 'MONTH'";
                        $params_seMonth  = array();
                        $query_seMonth   = sqlsrv_query($conn, $sql_seMonth , $params_seMonth);
                        $result_seMonth  = sqlsrv_fetch_array($query_seMonth , SQLSRV_FETCH_ASSOC);
                                        
                        $sql_seYears = "SELECT YEAR(GETDATE()) AS 'YEARS'";
                        $params_seYears  = array();
                        $query_seYears   = sqlsrv_query($conn, $sql_seYears , $params_seYears);
                        $result_seYears  = sqlsrv_fetch_array($query_seYears , SQLSRV_FETCH_ASSOC);

                        $sql_seSafetyTheme = "SELECT SAFETYDATA AS 'SAFETYTHEME' FROM SAFETYFOCUSTHEME 
                        WHERE  MONTHENG ='".$result_seMonth['MONTH']."' AND YEARTHEME ='".$result_seYears['YEARS']."'";
                        $params_seSafetyTheme  = array();
                        $query_seSafetyTheme   = sqlsrv_query($conn, $sql_seSafetyTheme , $params_seSafetyTheme);
                        $result_seSafetyTheme  = sqlsrv_fetch_array($query_seSafetyTheme , SQLSRV_FETCH_ASSOC);

                        ?>
                        <input type="text"  id="txt_month" hidden name="txt_month" value="<?=$result_seMonth['MONTH']?>"></input>
                        <input type="text"  id="txt_years" hidden name="txt_years" value="<?=$result_seYears['YEARS']?>"></input>
                        <h4 class="modal-title"><b>Safety Focus Theme (<?=$result_seMonth['MONTH']?><?=$result_seYears['YEARS']?>) &nbsp; </b><font style="color:red;font-size: 20px">"<?=$result_seSafetyTheme['SAFETYTHEME']?>"</font></h4>
                       
                        </div> <!-- END Modal body-->

                        <div class="panel-body">
                        <!-- Nav tabs -->
                        <!-- <ul class="nav nav-pills">
                            <li class="active">
                                <a href="#tap_kpi1" data-toggle="tab" aria-expanded="true">บันทึกข้อมูล Tenko NG</a>
                            </li>
                            <li>
                                <a href="#tap_kpi2" data-toggle="tab">แก้ไขข้อมูล Tenko NG</a>
                            </li>

                        </ul> -->
                        <?php
                            
        
                        ?>
                        
                        <!-- คะแนนประจำวัน -->
                        <div class="tab-content">
                            <h4>ชื่อพนักงาน: <?=$result_seEmployee2['nameT']?> &nbsp;(<?=$result_seEmployee2['PersonCode']?>)</h4> 
                            <div id="data_score"></div>
                                <div style="text-align: center;">
                                <?php
                                // echo  $result_CheckPointEmp['DATE'];
                                ?>
                                        <?php

                                        if ($_GET['employeecode1'] != "") {

                                            $empcheck = $_GET['employeecode1'];
                                            // เช็ควันที่ 
                                            $sql_DateCheck = "SELECT CONVERT(VARCHAR,DATERK,23) AS 'DATECHECK'
                                            FROM VEHICLETRANSPORTPLAN	
                                            WHERE VEHICLETRANSPORTPLANID ='".$_GET['vehicletransportplanid']."'";
                                            $params_DateCheck = array();
                                            $query_DateCheck = sqlsrv_query($conn, $sql_DateCheck , $params_DateCheck);
                                            $result_DateCheck = sqlsrv_fetch_array($query_DateCheck , SQLSRV_FETCH_ASSOC);

                                            // echo  $result_DateCheck['DATECHECK'];
                                            // echo  '<br>';
                                            

                                            // ข้อมูลแผนงาน
                                            $sql_CheckPlan = "SELECT  TOP 1 JOBNO,VEHICLETRANSPORTPLANID,TENKOMASTERID,CONVERT(VARCHAR,DATEWORKING,103) AS 'DATE'
                                            ,JOBSTART,JOBEND,CONVERT(VARCHAR(16),DATEWORKING,120) AS 'DATETIMESTART',
                                            CONVERT(VARCHAR(16),DATERETURN,120) AS 'DATETIMEEND',
                                            CONVERT(VARCHAR(5),DATEWORKING,108) AS 'TIMESTART',
                                            CONVERT(VARCHAR(5),DATERETURN,108) AS 'TIMEEND',
                                            THAINAME AS 'THAINAME',
                                            O4 AS 'OIL', TENKOMASTERID AS 'TENKOMASTERID'
                                            FROM VEHICLETRANSPORTPLAN 
                                            WHERE (EMPLOYEECODE1 ='".$_GET['employeecode1']."' OR EMPLOYEECODE2 ='".$_GET['employeecode1']."')
                                            AND (TENKOMASTERID != '' OR TENKOMASTERID IS NOT NULL)
                                            AND STATUSNUMBER !='O'
                                            AND (O4 IS NOT NULL OR O4 !='' )
                                            AND CONVERT(DATE,DATEWORKING,103) < '".$result_DateCheck['DATECHECK']."'
                                            ORDER BY CONVERT(DATE,DATEWORKING,103) DESC";
                                            $params_CheckPlan = array();
                                            $query_CheckPlan = sqlsrv_query($conn, $sql_CheckPlan, $params_CheckPlan);
                                            $result_CheckPlan = sqlsrv_fetch_array($query_CheckPlan, SQLSRV_FETCH_ASSOC);

                                               
                                            // echo $result_CheckPlan['TENKOMASTERID'];


                                            // echo $result_CheckPlan['JOBNO'];

                                            // เลขไมล์ต้น
                                            $sql_CheckMileageStart = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGESTART' FROM MILEAGE 
                                            WHERE JOBNO ='".$result_CheckPlan['JOBNO']."'
                                            AND MILEAGETYPE ='MILEAGESTART'
                                            ORDER BY CREATEDATE DESC";
                                            $params_CheckMileageStart = array();
                                            $query_CheckMileageStart = sqlsrv_query($conn, $sql_CheckMileageStart, $params_CheckMileageStart);
                                            $result_CheckMileageStart = sqlsrv_fetch_array($query_CheckMileageStart, SQLSRV_FETCH_ASSOC);

                                            // เลขไมล์ปลาย
                                            $sql_CheckMileageEnd = "SELECT TOP 1 MILEAGENUMBER AS 'MELEAGEEND' FROM MILEAGE 
                                            WHERE JOBNO ='".$result_CheckPlan['JOBNO']."'
                                            AND MILEAGETYPE ='MILEAGEEND'
                                            ORDER BY CREATEDATE DESC";
                                            $params_CheckMileageEnd = array();
                                            $query_CheckMileageEnd = sqlsrv_query($conn, $sql_CheckMileageEnd, $params_CheckMileageEnd);
                                            $result_CheckMileageEnd = sqlsrv_fetch_array($query_CheckMileageEnd, SQLSRV_FETCH_ASSOC);

                                            $mileage = ($result_CheckMileageEnd['MELEAGEEND'] - $result_CheckMileageStart['MILEAGESTART']);


                                            $sql_CheckPointEmp = "SELECT TENKOGPSSPEEDOVERAMOUNT,TENKOGPSBRAKEAMOUNT,TENKOGPSSPEEDMACHINEAMOUNT,
                                            TENKOGPSOUTLINEAMOUNT,TENKOGPSCONTINUOUSAMOUNT,GRADEDRIVER ,POINTDRIVER
                                            FROM TENKOGPS WHERE TENKOMASTERID ='".$result_CheckPlan['TENKOMASTERID']."'
                                            AND TENKOMASTERDIRVERCODE ='".$_GET['employeecode1']."'";
                                            $params_CheckPointEmp = array();
                                            $query_CheckPointEmp = sqlsrv_query($conn, $sql_CheckPointEmp, $params_CheckPointEmp);
                                            $result_CheckPointEmp = sqlsrv_fetch_array($query_CheckPointEmp, SQLSRV_FETCH_ASSOC);

                                            // echo $result_CheckPointEmp['GRADE'];
                                            // echo 'sdasdsdsd';
                                        }else if ($_GET['employeecode2'] != "") {
                                            
                                            echo $empcheck = $_GET['employeecode2'];

                                            // เช็ควันที่ 
                                            $sql_DateCheck = "SELECT CONVERT(VARCHAR,DATERK,23) AS 'DATECHECK'
                                            FROM VEHICLETRANSPORTPLAN	
                                            WHERE VEHICLETRANSPORTPLANID ='".$_GET['vehicletransportplanid']."'";
                                            $params_DateCheck = array();
                                            $query_DateCheck = sqlsrv_query($conn, $sql_DateCheck , $params_DateCheck);
                                            $result_DateCheck = sqlsrv_fetch_array($query_DateCheck , SQLSRV_FETCH_ASSOC);

                                            // echo  $result_DateCheck['DATECHECK'];
                                            // echo  '<br>';
                                         

                                            // ข้อมูลแผนงาน
                                            $sql_CheckPlan = "SELECT  TOP 1 JOBNO,VEHICLETRANSPORTPLANID,TENKOMASTERID,CONVERT(VARCHAR,DATEWORKING,103) AS 'DATE'
                                            ,JOBSTART,JOBEND,CONVERT(VARCHAR(16),DATEWORKING,120) AS 'DATETIMESTART',
                                            CONVERT(VARCHAR(16),DATERETURN,120) AS 'DATETIMEEND',
                                            CONVERT(VARCHAR(5),DATEWORKING,108) AS 'TIMESTART',
                                            CONVERT(VARCHAR(5),DATERETURN,108) AS 'TIMEEND',
                                            THAINAME AS 'THAINAME',
                                            O4 AS 'OIL', TENKOMASTERID AS 'TENKOMASTERID'
                                            FROM VEHICLETRANSPORTPLAN 
                                            WHERE (EMPLOYEECODE1 ='".$_GET['employeecode1']."' OR EMPLOYEECODE2 ='".$_GET['employeecode2']."')
                                            AND (TENKOMASTERID != '' OR TENKOMASTERID IS NOT NULL)
                                            AND STATUSNUMBER !='O'
                                            AND (O4 IS NOT NULL OR O4 !='' )
                                            AND CONVERT(DATE,DATEWORKING,103) < '".$result_DateCheck['DATECHECK']."'
                                            ORDER BY CONVERT(DATE,DATEWORKING,103) DESC";
                                            $params_CheckPlan = array();
                                            $query_CheckPlan = sqlsrv_query($conn, $sql_CheckPlan, $params_CheckPlan);
                                            $result_CheckPlan = sqlsrv_fetch_array($query_CheckPlan, SQLSRV_FETCH_ASSOC);

                                               


                                            // echo $result_CheckPlan['JOBNO'];

                                            // เลขไมล์ต้น
                                            $sql_CheckMileageStart = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGESTART' FROM MILEAGE 
                                            WHERE JOBNO ='".$result_CheckPlan['JOBNO']."'
                                            AND MILEAGETYPE ='MILEAGESTART'
                                            ORDER BY CREATEDATE DESC";
                                            $params_CheckMileageStart = array();
                                            $query_CheckMileageStart = sqlsrv_query($conn, $sql_CheckMileageStart, $params_CheckMileageStart);
                                            $result_CheckMileageStart = sqlsrv_fetch_array($query_CheckMileageStart, SQLSRV_FETCH_ASSOC);

                                            // เลขไมล์ปลาย
                                            $sql_CheckMileageEnd = "SELECT TOP 1 MILEAGENUMBER AS 'MELEAGEEND' FROM MILEAGE 
                                            WHERE JOBNO ='".$result_CheckPlan['JOBNO']."'
                                            AND MILEAGETYPE ='MILEAGEEND'
                                            ORDER BY CREATEDATE DESC";
                                            $params_CheckMileageEnd = array();
                                            $query_CheckMileageEnd = sqlsrv_query($conn, $sql_CheckMileageEnd, $params_CheckMileageEnd);
                                            $result_CheckMileageEnd = sqlsrv_fetch_array($query_CheckMileageEnd, SQLSRV_FETCH_ASSOC);

                                            $mileage = ($result_CheckMileageEnd['MELEAGEEND'] - $result_CheckMileageStart['MILEAGESTART']);   
                                        
                                            $sql_CheckPointEmp = "SELECT TENKOGPSSPEEDOVERAMOUNT,TENKOGPSBRAKEAMOUNT,TENKOGPSSPEEDMACHINEAMOUNT,
                                            TENKOGPSOUTLINEAMOUNT,TENKOGPSCONTINUOUSAMOUNT,GRADEDRIVER,POINTDRIVER
                                            FROM TENKOGPS WHERE TENKOMASTERID ='".$result_CheckPlan['TENKOMASTERID']."'
                                            AND TENKOMASTERDIRVERCODE ='".$_GET['employeecode2']."'";
                                            $params_CheckPointEmp = array();
                                            $query_CheckPointEmp = sqlsrv_query($conn, $sql_CheckPointEmp, $params_CheckPointEmp);
                                            $result_CheckPointEmp = sqlsrv_fetch_array($query_CheckPointEmp, SQLSRV_FETCH_ASSOC);



                                        }else{
                                            # code...
                                        }
                                      

                                    ?>
                                     
                                    <table style="width:500px;border: 1px solid black;border-collapse: collapse;">
                                        <tr>
                                            <th colspan = "8" style="border: 1px solid black;background-color: #e8e6e6;border-collapse: collapse;padding: 5px;text-align: center">คะแนนการขับขี่ประจำวัน (<?=$result_seEmployee2['nameT']?>) วันที่วิ่งงานล่าสุด <?= $result_CheckPlan['DATE'] ?>
                                            <!-- <br>&nbsp;&nbsp;<button onclick="check_pointemp1('<?=$result_seTenkomaster_temp['TENKOMASTERID']?>','<?=$_GET['employeecode1']?>');" >คำนวณ พขร.1</button> <font color="red">*กดคำนวณทุกครั้งเพื่อคำนวณคะแนน และบันทึกข้อมูล</font></th>  -->
                                        </tr>
                                        <tr>
                                            
                                            <th colspan = "4" style="width:100px;border: 1px solid black;background-color: #e8e6e6;border-collapse: collapse;padding: 5px;text-align: center;">การประเมินผล</th>
                                            <th colspan = "4" style="width:100px;border: 1px solid black;background-color: #e8e6e6;border-collapse: collapse;padding: 5px;text-align: center;">คะแนนที่ได้</th>
                                        </tr>
                                        <div id="data_pointemp1sr"></div>
                                        <tr>
                                            <th colspan = "4" style="width:100px;border: 1px solid black;background-color: #e8e6e6;border-collapse: collapse;padding: 5px;text-align: center;"><input disabled="" style="text-align: center;" type="text" value="<?= $result_CheckPointEmp['GRADEDRIVER'] ?>" style=""></th>
                                            <th colspan = "4" style="width:100px;border: 1px solid black;background-color: #e8e6e6;border-collapse: collapse;padding: 5px;text-align: center;"><input disabled="" style="text-align: center;" type="text" value="<?= $result_CheckPointEmp['POINTDRIVER'] ?>" style=""></th>
                                            
                                           
                                        </tr>
                                    </table>
                            </div> 
                            <div class = "row">
                                <label ></label>
                            </div>
                            <div id="data_score"></div>
                                <div style="text-align: center;">
                                        <?php

                                        
                                      

                                        ?>
                                     
                                <table style="width:80%;border:1px solid black;">
                                    <tr>
                                        <th colspan ="4" style="background-color: #bfbfbf;border:1px solid black;text-align: center;font-size: 18px;">ข้อมูลการวิ่งงานล่าสุด &nbsp;<b>เลขที่งาน(<?=$result_CheckPlan['JOBNO']?>)</th>
                                        <?php
                                        if ($_GET['employeecode1'] != "") {
                                        ?>
                                            <th colspan ="2" rowspan="7" style="border:1px solid black;text-align: center;font-size: 18px;"><img width="200" height="300"   src="../images/employee/<?= $_GET['employeecode1'] ?>.JPG"></th>
                                        <?php

                                            } else {
                                                // echo $_GET['employeecode2'];
                                        ?>
                                        
                                            <th colspan ="2" rowspan="7" style="border:1px solid black;text-align: center;font-size: 18px;"><img width="200" height="300"   src="../images/employee/<?= $_GET['employeecode2'] ?>.JPG"></th>
                                        <?php  
                                            }

                                        ?>
                                        
                                    </tr>
                                    <tr>
                                        <td style="border:1px solid black;font-size: 16px;background-color: #bfbfbf;text-align: left"> &nbsp;<b>วันที่วิ่งงานล่าสุด</b></td>
                                        <td colspan ="2" style="border:1px solid black;text-align: left">&nbsp; <?=  $result_CheckPlan['DATE'] ?> </b></td>
                                        
                                    </tr>
                                    <tr>
                                        <td  style="border:1px solid black;font-size: 16px;background-color: #bfbfbf;text-align: left">&nbsp;<b>รูทวิ่งงาน</b></td>
                                        <td colspan ="2" style="border:1px solid black;text-align: left">&nbsp; <?=  $result_CheckPlan['JOBSTART'] ?></td>
                                    </tr>
                                    <tr>
                                        <td  style="border:1px solid black;font-size: 16px;background-color: #bfbfbf;text-align: left">&nbsp;<b>เวลา</b></td>
                                        <td colspan ="2" style="border:1px solid black;text-align: left">&nbsp;  <?= $result_CheckPlan['TIMESTART'] ?> - <?= $result_CheckPlan['TIMEEND'] ?></td>
                                    </tr>
                                    <tr>
                                        <td  style="border:1px solid black;font-size: 16px;background-color: #bfbfbf;text-align: left">&nbsp;<b>ทะเบียนรถ</b></td>
                                        <td colspan ="2" style="border:1px solid black;text-align: left">&nbsp;  <?= $result_CheckPlan['THAINAME'] ?></td>
                                    </tr>
                                    <tr>
                                        <td  style="border:1px solid black;font-size: 16px;background-color: #bfbfbf;text-align: left">&nbsp;<b>ระยะทาง</b></td>
                                        <td colspan ="2" style="border:1px solid black;text-align: left">&nbsp;  <?= $mileage ?></td>
                                    </tr>
                                    <tr>
                                        <td  style="border:1px solid black;font-size: 16px;background-color: #bfbfbf;text-align: left">&nbsp;<b>น้ำมัน(ลิตร)</b></td>
                                        <td colspan ="2" style="border:1px solid black;text-align: left">&nbsp;  <?= $result_CheckPlan['OIL'] ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan ="4" style="font-size: 16px;">&nbsp;<b></b></td>
                                    </tr>
                                    <tr>
                                        <td colspan ="4" style="font-size: 16px;">&nbsp;<b></b></td>
                                    </tr>
                                    
                                </table>
                            </div>
                            <div class = "row">
                                <label ></label>
                            </div>
                            <!-- 5 โรคเสี่ยงและโรคอื่นๆ -->
                            <div id="data_score"></div>
                                <div style="text-align: center;">
                                        <?php

                                        if ($_GET['employeecode1'] != "") {

                                            $sql_sehealthhis = "SELECT  TOP 1 ID,DIABETES,HIGHTBLOODPRESSURE,LOWBLOODPRESSURE,
                                                HEARTDISEASE, EPILEPPSY, BRAINSURGERY, SHORTSIGHT,SHORTSIGHT_R,SHORTSIGHT_L,LONGSIGHT,LONGSIGHT_R,LONGSIGHT_L,
                                                OBLIQUESIGHT,OBLIQUESIGHT_R,OBLIQUESIGHT_L,COLORBLIND_OK,COLORBLIND_NG,OTHERDISEASE1,OTHERDISEASE2,OTHERDISEASE3,
                                                OTHERDISEASE4,OTHERDISEASE5,OTHERDISEASE6,CREATEDATE
                                                FROM [dbo].[HEALTHHISTORY]
                                                WHERE EMPLOYEECODE ='" . $_GET['employeecode1'] . "'
                                                AND CREATEYEAR ='" . $result_seYears['YEARS'] . "'
                                                AND ACTIVESTATUS ='1'
                                                ORDER BY CREATEDATE DESC";
                                            $params_sehealthhis = array();
                                            $query_sehealthhis  = sqlsrv_query($conn, $sql_sehealthhis, $params_sehealthhis);
                                            $result_sehealthhis = sqlsrv_fetch_array($query_sehealthhis, SQLSRV_FETCH_ASSOC);

                                         
                                            // 5 โรคเสี่ยง
                                            if ($result_sehealthhis['DIABETES'] == '1' || $result_sehealthhis['HIGHTBLOODPRESSURE'] == '1' || $result_sehealthhis['LOWBLOODPRESSURE'] == '1'
                                            || $result_sehealthhis['HEARTDISEASE'] == '1' || $result_sehealthhis['EPILEPPSY'] == '1' || $result_sehealthhis['BRAINSURGERY'] == '1') {
                                                $fiverisk = 'YES';
                                            }else {
                                                $fiverisk = 'NO';
                                            }
                                            //เช็คโรคเบาหวาน
                                            if ($result_sehealthhis['DIABETES'] == '1') {
                                                $disease1 = 'โรคเบาหวาน';
                                            }else{
                                                $disease1 = ' ';
                                            }
                                            //เช็คโรคความดันโลหิตสูง
                                            if ($result_sehealthhis['HIGHTBLOODPRESSURE'] == '1') {
                                                $disease2 = 'โรคความดันโลหิตสูง';
                                            }else{
                                                $disease2 = ' ';
                                            }
                                            //เช็คโรคความดันโลหิตต่ำ
                                            if ($result_sehealthhis['LOWBLOODPRESSURE'] == '1') {
                                                $disease3 = 'โรคความดันโลหิตต่ำ';
                                            }else{
                                                $disease3 = ' ';
                                            }
                                            //เช็คโรคหัวใจ
                                            if ($result_sehealthhis['HEARTDISEASE'] == '1') {
                                                $disease4 = 'โรคหัวใจ';
                                            }else{
                                                $disease4 = ' ';
                                            }
                                            //เช็คลมชัก/ลมบ้าหมู
                                            if ($result_sehealthhis['EPILEPPSY'] == '1') {
                                                $disease5 = 'ลมชัก/ลมบ้าหมู';
                                            }else{
                                                $disease5 = ' ';
                                            }
                                            //เช็คผ่าตัดสมอง
                                            if ($result_sehealthhis['BRAINSURGERY'] == '1') {
                                                $disease6 = 'ผ่าตัดสมอง';
                                            }else{
                                                $disease6 = ' ';
                                            }




                                            // โรคอื่นๆ
                                            if (($result_sehealthhis['OTHERDISEASE1'] == NULL ||  $result_sehealthhis['OTHERDISEASE1'] == '') && 
                                            ($result_sehealthhis['OTHERDISEASE2'] == NULL ||  $result_sehealthhis['OTHERDISEASE2'] == '') &&
                                            ($result_sehealthhis['OTHERDISEASE3'] == NULL ||  $result_sehealthhis['OTHERDISEASE3'] == '') &&
                                            ($result_sehealthhis['OTHERDISEASE4'] == NULL ||  $result_sehealthhis['OTHERDISEASE4'] == '') &&
                                            ($result_sehealthhis['OTHERDISEASE5'] == NULL ||  $result_sehealthhis['OTHERDISEASE5'] == '') ) {
                                                $otherdisease = 'NO';
                                            }else {
                                                $otherdisease = 'YES';
                                            }

                                            // echo $result_sehealthhis['OTHERDISEASE1'];
                                            // echo $otherdisease;
                                            // echo '111111';
                                        } else if ($_GET['employeecode2'] != "") {

                                            $sql_sehealthhis = "SELECT  TOP 1 ID,DIABETES,HIGHTBLOODPRESSURE,LOWBLOODPRESSURE,
                                                HEARTDISEASE, EPILEPPSY, BRAINSURGERY, SHORTSIGHT,SHORTSIGHT_R,SHORTSIGHT_L,LONGSIGHT,LONGSIGHT_R,LONGSIGHT_L,
                                                OBLIQUESIGHT,OBLIQUESIGHT_R,OBLIQUESIGHT_L,COLORBLIND_OK,COLORBLIND_NG,OTHERDISEASE1,OTHERDISEASE2,OTHERDISEASE3,
                                                OTHERDISEASE4,OTHERDISEASE5,OTHERDISEASE6,CREATEDATE
                                                FROM [dbo].[HEALTHHISTORY]
                                                WHERE EMPLOYEECODE ='" . $_GET['employeecode2'] . "'
                                                AND CREATEYEAR ='" . $result_seYears['YEARS'] . "'
                                                AND ACTIVESTATUS ='1'
                                                ORDER BY CREATEDATE DESC";
                                            $params_sehealthhis = array();
                                            $query_sehealthhis  = sqlsrv_query($conn, $sql_sehealthhis, $params_sehealthhis);
                                            $result_sehealthhis = sqlsrv_fetch_array($query_sehealthhis, SQLSRV_FETCH_ASSOC);

                                            // 5 โรคเสี่ยง
                                            if ($result_sehealthhis['DIABETES'] == '1' || $result_sehealthhis['HIGHTBLOODPRESSURE'] == '1' || $result_sehealthhis['LOWBLOODPRESSURE'] == '1'
                                            || $result_sehealthhis['HEARTDISEASE'] == '1' || $result_sehealthhis['EPILEPPSY'] == '1' || $result_sehealthhis['BRAINSURGERY'] == '1') {
                                                $fiverisk = 'YES';
                                            }else {
                                                $fiverisk = 'NO';
                                            }

                                            // 5 โรคเสี่ยง
                                            if ($result_sehealthhis['DIABETES'] == '1' || $result_sehealthhis['HIGHTBLOODPRESSURE'] == '1' || $result_sehealthhis['LOWBLOODPRESSURE'] == '1'
                                            || $result_sehealthhis['HEARTDISEASE'] == '1' || $result_sehealthhis['EPILEPPSY'] == '1' || $result_sehealthhis['BRAINSURGERY'] == '1') {
                                                $fiverisk = 'YES';
                                            }else {
                                                $fiverisk = 'NO';
                                            }
                                            //เช็คโรคเบาหวาน
                                            if ($result_sehealthhis['DIABETES'] == '1') {
                                                $disease1 = 'โรคเบาหวาน';
                                            }else{
                                                $disease1 = ' ';
                                            }
                                            //เช็คโรคความดันโลหิตสูง
                                            if ($result_sehealthhis['HIGHTBLOODPRESSURE'] == '1') {
                                                $disease2 = 'โรคความดันโลหิตสูง';
                                            }else{
                                                $disease2 = ' ';
                                            }
                                            //เช็คโรคความดันโลหิตต่ำ
                                            if ($result_sehealthhis['LOWBLOODPRESSURE'] == '1') {
                                                $disease3 = 'โรคความดันโลหิตต่ำ';
                                            }else{
                                                $disease3 = ' ';
                                            }
                                            //เช็คโรคหัวใจ
                                            if ($result_sehealthhis['HEARTDISEASE'] == '1') {
                                                $disease4 = 'โรคหัวใจ';
                                            }else{
                                                $disease4 = ' ';
                                            }
                                            //เช็คลมชัก/ลมบ้าหมู
                                            if ($result_sehealthhis['EPILEPPSY'] == '1') {
                                                $disease5 = 'ลมชัก/ลมบ้าหมู';
                                            }else{
                                                $disease5 = ' ';
                                            }
                                            //เช็คผ่าตัดสมอง
                                            if ($result_sehealthhis['BRAINSURGERY'] == '1') {
                                                $disease6 = 'ผ่าตัดสมอง';
                                            }else{
                                                $disease6 = ' ';
                                            }
                                            
                                            // โรคอื่นๆ
                                            if (($result_sehealthhis['OTHERDISEASE1'] == NULL ||  $result_sehealthhis['OTHERDISEASE1'] == '') || 
                                            ($result_sehealthhis['OTHERDISEASE2'] == NULL ||  $result_sehealthhis['OTHERDISEASE2'] == '') ||
                                            ($result_sehealthhis['OTHERDISEASE3'] == NULL ||  $result_sehealthhis['OTHERDISEASE3'] == '') ||
                                            ($result_sehealthhis['OTHERDISEASE4'] == NULL ||  $result_sehealthhis['OTHERDISEASE4'] == '') ||
                                            ($result_sehealthhis['OTHERDISEASE5'] == NULL ||  $result_sehealthhis['OTHERDISEASE5'] == '') ) {
                                                $otherdisease = 'NO';
                                            }else {
                                                $otherdisease = 'YES';
                                            }

                                           
                                        }

                                      

                                        ?>
                                     
                                <table style="width:100%;border:1px solid black;">
                                    <thead>
                                        <tr>
                                          
                                            <th rowspan ="2"    colspan="1" style="text-align: center;border:1px solid black;background-color: #bfbfbf">Health Record</th>
                                            <th colspan ="2"    style="text-align: center;border:1px solid black;background-color: #bfbfbf">Result</th>
                                            <th rowspan ="2"    colspan ="1" style="text-align: center;background-color: #bfbfbf;border:1px solid black">Detail</th>
                                            <th rowspan ="2"    colspan ="1" style="text-align: center;background-color: #bfbfbf;border:1px solid black"></th>
                                        </tr>
                                        <tr>

                                            <th colspan ="1"  style="text-align: center;background-color: #bfbfbf;border:1px solid black">OK</th>
                                            <th colspan ="1"  style="text-align: center;background-color: #bfbfbf;border:1px solid black">NG</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: left">&nbsp;<b>Diseases history (5 risk diseases)</b></td>
                                            <?php
                                            if ($fiverisk == 'YES') { //NG
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center"></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #E44411;"><b>&#10006;</b></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 13px;text-align: left"><?=$disease1?>,<?=$disease2?>,<?=$disease3?> <br><?=$disease4?>,<?=$disease5?>,<?=$disease6?></td>
                                            <?php
                                            }else { // OK
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #68E411;"><b>&#10004;</b></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center"></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: left"></td>
                                            <?php
                                            }
                                            ?>
                                            
                                            
                                            <td colspan ="1" rowspan ="2" style="border:1px solid black;font-size: 16px;text-align: center"><button type="button" style= "height:40px;width:150px" class="btn btn-primary btn-md" name="myBtn" id ="myBtn" onclick="healthdata('<?=$result_seEmployee2['nameT']?>','<?=$result_seYears['YEARS']?>')">รายละเอียด</button></td>
                                            
                                        </tr>
                                        <tr>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: left">&nbsp;<b>Other diseases</b></td>
                                            <?php
                                            if ($otherdisease == 'YES') { //NG
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center"></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #E44411;"><b>&#10006;</b></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 13px;text-align: left"><?=$result_sehealthhis['OTHERDISEASE1']?>,<?=$result_sehealthhis['OTHERDISEASE2']?>,<?=$result_sehealthhis['OTHERDISEASE3']?>,<?=$result_sehealthhis['OTHERDISEASE4']?>,<?=$result_sehealthhis['OTHERDISEASE5']?>,<?=$result_sehealthhis['OTHERDISEASE6']?></td>
                                            <?php
                                            }else { // OK
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #68E411;"><b>&#10004;</b></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center"></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: left"></td>
                                            <?php
                                            }
                                            ?>
                                        
                                            <!-- <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: center"><button type="button" style= "height:40px;width:150px" class="btn btn-primary btn-md" name="myBtn" id ="myBtn" onclick="otherriskdata()" >รายละเอียด โรคอื่นๆ</button></td> -->
                                        </tr>
                                        <!-- <tr>
                                            <td colspan ="6" style="font-size: 16px;">&nbsp;<b></b></td>
                                        </tr>   -->
                                    </tbody>
                                    
                                </table>
                            </div>
                            <div class = "row">
                                <label ></label>
                            </div>
                            <!-- Tenko Result -->
                            <div id="data_score"></div>
                                <div style="text-align: center;">
                                        <?php

                                        $sql_CheckTenko = "SELECT TENKOTEMPERATUREDATA AS 'TEMP',TENKOPRESSUREDATA_90160 AS 'SYS',
                                        TENKOPRESSUREDATA_60100 AS 'DIA',TENKOPRESSUREDATA_60110 AS 'HEARTRATE',
                                        TENKOALCOHOLDATA AS 'ALCOHOL', TENKOOXYGENDATA AS 'OXYGEN'
                                        FROM TENKOBEFORE WHERE TENKOMASTERID ='".$result_CheckPlan['TENKOMASTERID']."'";
                                        $params_CheckTenko = array();
                                        $query_CheckTenko = sqlsrv_query($conn, $sql_CheckTenko, $params_CheckTenko);
                                        $result_CheckTenko = sqlsrv_fetch_array($query_CheckTenko, SQLSRV_FETCH_ASSOC);

                                        // echo $result_CheckTenko['TEMP'];

                                        // ความดัน
                                        if ($result_CheckTenko['SYS'] >= '90' && $result_CheckTenko['SYS'] <= '140') {
                                            $bloodpresure = 'YES';
                                        }else {
                                            $bloodpresure = 'NO';
                                        }

                                        // แอลกอฮอล์
                                        if ($result_CheckTenko['ALCOHOL'] == '0') {
                                            $alcohol = 'YES';
                                        }else {
                                            $alcohol = 'NO';
                                        }

                                        // อุณหภูมิ
                                        if ($result_CheckTenko['TEMP'] < '37' && $result_CheckTenko['TEMP'] != '') {
                                            $temp = 'YES';
                                        }else {
                                            $temp = 'NO';
                                        }
                                        
                                        // อัตตราเต้นของหัวใจ
                                        if ($result_CheckTenko['HEARTRATE'] >= '60' && $result_CheckTenko['HEARTRATE'] <= '100' ) {
                                            $heartrate = 'YES';
                                        }else {
                                            $heartrate = 'NO';
                                        }

                                         // ออกซิเจน
                                        if ($result_CheckTenko['OXYGEN'] >= '98' ) {
                                            $oxygen = 'YES';
                                        }else {
                                            $oxygen = 'NO';
                                        }

                                       
                                        // echo $bloodpresure;
                                        // echo $alcohol;
                                        // echo $temp;
                                        // echo $heartrate;
                                        // echo $oxygen;
                                        ?>
                                     
                                <table style="width:100%;border:1px solid black;">
                                    <thead style="border:1px solid black;">
                                        <tr>
                                          
                                            <th rowspan ="2"    colspan ="1" style="text-align: center;border:1px solid black;background-color: #bfbfbf">Tenko Result</th>
                                            <th colspan ="2"    style ="text-align: center;border:1px solid black;background-color: #bfbfbf">Result</th>
                                            <th rowspan ="2"    colspan ="1" style="text-align: center;border:1px solid black;background-color: #bfbfbf">Detail</th>
                                            <th rowspan ="2"    colspan ="1" style="text-align: center;background-color: #bfbfbf;border:1px solid black"></th>
                                        </tr>
                                        <tr>

                                            <th colspan ="1"   style="text-align: center;border:1px solid black;background-color: #bfbfbf">OK</th>
                                            <th colspan ="1"   style="text-align: center;border:1px solid black;background-color: #bfbfbf">NG</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: left">&nbsp;<b>Blood Presure</b></td>
                                            <?php
                                            if ($bloodpresure == 'YES') { //OK
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #68E411;"><b>&#10004;</b></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: left"></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: left">ความดันบน <b><?=$result_CheckTenko['SYS']?></b>,ความดันล่าง <b><?=$result_CheckTenko['DIA']?></td>
                                            <?php
                                            }else { // NG
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center"></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #E44411;"><b>&#10006;</b></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: left">ความดันบน <b><?=$result_CheckTenko['SYS']?></b>,ความดันล่าง <b><?=$result_CheckTenko['DIA']?></td>
                                            <?php
                                            }
                                            ?>
                                           
                                            
                                        </tr>
                                        <tr>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: left">&nbsp;<b>% Alcohol</b></td>
                                            <?php
                                            if ($alcohol == 'YES') { //OK
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #68E411;"><b>&#10004;</b></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: left"></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: left">แอลกอฮอล์ <b><?=$result_CheckTenko['ALCOHOL']?></b></td>
                                            <?php
                                            }else { // NG
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center"></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #E44411;"><b>&#10006;</b></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: left">แอลกอฮอล์ <b><?=$result_CheckTenko['ALCOHOL']?></b></td>
                                            <?php
                                            }
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: center"></td>
                                        </tr>
                                        <tr>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: left">&nbsp;<b>อุณหภูมิ</b></td>
                                            <?php
                                            if ($temp == 'YES') { //OK
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #68E411;"><b>&#10004;</b></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center"></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: left">อุณหภูมิ <b><?=$result_CheckTenko['TEMP']?></b></td>
                                            <?php
                                            }else { // NG
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center"></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #E44411;"><b>&#10006;</b></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: left">อุณหภูมิ <b><?=$result_CheckTenko['TEMP']?></b></td>
                                            <?php
                                            }
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;height:40px;width:300px;text-align: center"></td>
                                        </tr>
                                        <tr>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: left">&nbsp;<b>อัตราการเต้นของหัวใจ</b></td>
                                            <?php
                                            if ($heartrate == 'YES') { //OK
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #68E411;"><b>&#10004;</b></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center"></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: left">อัตราการเต้นของหัวใจ <b><?=$result_CheckTenko['HEARTRATE']?></b></td>
                                            <?php
                                            }else { // NG
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center"></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #E44411;"><b>&#10006;</b></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: left">อัตราการเต้นของหัวใจ <b><?=$result_CheckTenko['HEARTRATE']?></b></td>
                                            <?php
                                            }
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: center"></td>
                                        </tr>
                                        <tr>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: left">&nbsp;<b>ออกซิเจนในเลือด</b></td>
                                            <?php
                                            if ($oxygen == 'YES') { //OK
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #68E411;"><b>&#10004;</b></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: left"></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: left">ออกซิเจนในเลือด <b><?=$result_CheckTenko['OXYGEN']?></b></td>
                                            <?php
                                            }else { // NG
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center"></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #E44411;"><b>&#10006;</b></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: left">ออกซิเจนในเลือด <b><?=$result_CheckTenko['OXYGEN']?></b></td>
                                            <?php
                                            }
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: center"></td>
                                        </tr>
                                        <!-- <tr>
                                            <td colspan ="6" style="font-size: 16px;">&nbsp;<b></b></td>
                                        </tr>   -->
                                    </tbody>
                                    
                                </table>
                            </div>
                            <div class = "row">
                                <label ></label>
                            </div>
                            <!-- KPI Result -->
                            <div id="data_score"></div>
                                <div style="text-align: center;">
                                        <?php

                                      
                                        if ($_GET['employeecode1'] != "") {

                                            $sql_CountTruckCheck = "SELECT COUNT(TRUCKCAMCHECKID) AS 'TRUCKCOUNT' FROM TRUCKCAMERACHECK
                                            WHERE DRIVERCODE ='".$_GET['employeecode1']."'
                                            AND YEARSTRUCKCAMCHECK ='".$result_seYears['YEARS']."'";
                                            $params_CountTruckCheck = array();
                                            $query_CountTruckCheck  = sqlsrv_query($conn, $sql_CountTruckCheck, $params_CountTruckCheck);
                                            $result_CountTruckCheck = sqlsrv_fetch_array($query_CountTruckCheck, SQLSRV_FETCH_ASSOC);
                                        
                                            if ($result_CountTruckCheck['TRUCKCOUNT'] >= '1') {
                                                $TruckCheck = 'NG';
                                            }else {
                                                $TruckCheck = 'OK';
                                            }
                                            // echo $WorkingCheck;
                                            
                                            $sql_CountAccident = "SELECT COUNT(ACCI_ID) AS 'ACCICOUNT' FROM ACCIDENTHISTORY  
                                            WHERE DRIVERCODE ='".$_GET['employeecode1']."'
                                            AND YEARS ='".$result_seYears['YEARS']."'";
                                            $params_CountAccident = array();
                                            $query_CountAccident  = sqlsrv_query($conn, $sql_CountAccident, $params_CountAccident);
                                            $result_CountAccident = sqlsrv_fetch_array($query_CountAccident, SQLSRV_FETCH_ASSOC);
                                        
                                            if ($result_CountAccident['ACCICOUNT'] >= '1') {
                                                $AcciCheck = 'NG';
                                            }else {
                                                $AcciCheck = 'OK';
                                            }
                                            // echo $AcciCheck;
                                            
                                            $sql_WorkingIssue = "SELECT COUNT(WORKINGISSUEID) AS 'WORKINGCOUNT' FROM WORKINGISSUE
                                            WHERE DRIVERCODE ='".$_GET['employeecode1']."'
                                            AND YEARSWORKINGISSUECHECK ='".$result_seYears['YEARS']."'";
                                            $params_WorkingIssue = array();
                                            $query_WorkingIssue  = sqlsrv_query($conn, $sql_WorkingIssue, $params_WorkingIssue);
                                            $result_WorkingIssue = sqlsrv_fetch_array($query_WorkingIssue, SQLSRV_FETCH_ASSOC);
                                        
                                            if ($result_WorkingIssue['WORKINGCOUNT'] >= '1') {
                                                $WorkingCheck = 'NG';
                                            }else {
                                                $WorkingCheck = 'OK';
                                            }
                                            // echo $WorkingCheck;

                                            

                                        }else if ($_GET['employeecode2'] != "") {

                                            $sql_CountTruckCheck = "SELECT COUNT(TRUCKCAMCHECKID) AS 'TRUCKCOUNT' FROM TRUCKCAMERACHECK
                                            WHERE DRIVERCODE ='".$_GET['employeecode2']."'
                                            AND YEARSTRUCKCAMCHECK ='".$result_seYears['YEARS']."'";
                                            $params_CountTruckCheck = array();
                                            $query_CountTruckCheck  = sqlsrv_query($conn, $sql_CountTruckCheck, $params_CountTruckCheck);
                                            $result_CountTruckCheck = sqlsrv_fetch_array($query_CountTruckCheck, SQLSRV_FETCH_ASSOC);
                                        
                                            if ($result_CountTruckCheck['TRUCKCOUNT'] >= '1') {
                                                $TruckCheck = 'NG';
                                            }else {
                                                $TruckCheck = 'OK';
                                            }
                                            // echo $WorkingCheck;
                                            
                                            $sql_CountAccident = "SELECT COUNT(ACCI_ID) AS 'ACCICOUNT' FROM ACCIDENTHISTORY  
                                            WHERE DRIVERCODE ='".$_GET['employeecode2']."'
                                            AND YEARS ='".$result_seYears['YEARS']."'";
                                            $params_CountAccident = array();
                                            $query_CountAccident  = sqlsrv_query($conn, $sql_CountAccident, $params_CountAccident);
                                            $result_CountAccident = sqlsrv_fetch_array($query_CountAccident, SQLSRV_FETCH_ASSOC);
                                        
                                            if ($result_CountAccident['ACCICOUNT'] >= '1') {
                                                $AcciCheck = 'NG';
                                            }else {
                                                $AcciCheck = 'OK';
                                            }
                                            // echo $AcciCheck;
                                            
                                            $sql_WorkingIssue = "SELECT COUNT(WORKINGISSUEID) AS 'WORKINGCOUNT' FROM WORKINGISSUE
                                            WHERE DRIVERCODE ='".$_GET['employeecode2']."'
                                            AND YEARSWORKINGISSUECHECK ='".$result_seYears['YEARS']."'";
                                            $params_WorkingIssue = array();
                                            $query_WorkingIssue  = sqlsrv_query($conn, $sql_WorkingIssue, $params_WorkingIssue);
                                            $result_WorkingIssue = sqlsrv_fetch_array($query_WorkingIssue, SQLSRV_FETCH_ASSOC);
                                        
                                            if ($result_WorkingIssue['WORKINGCOUNT'] >= '1') {
                                                $WorkingCheck = 'NG';
                                            }else {
                                                $WorkingCheck = 'OK';
                                            }
                                            // echo $WorkingCheck;


                                        }else{
                                            # code...
                                        }

                                        ?>
                                     
                                <table style="width:100%;border:1px solid black;">
                                    <thead style="border:1px solid black;">
                                        <tr>
                                          
                                            <th rowspan ="2"  colspan="1" style="text-align: center;border:1px solid black;background-color: #bfbfbf">KPI Result</th>
                                            <th colspan ="2"  style="text-align: center;border:1px solid black;background-color: #bfbfbf">Result</th>
                                            <th rowspan ="2"  colspan ="1" style="text-align: center;border:1px solid black;background-color: #bfbfbf">Detail</th>
                                            <th rowspan ="2"  colspan ="1" style="text-align: center;border:1px solid black;background-color: #bfbfbf"></th>
                                        </tr>
                                        <tr>

                                            <th colspan ="1"  style="text-align: center;border:1px solid black;background-color: #bfbfbf">OK</th>
                                            <th colspan ="1"  style="text-align: center;border:1px solid black;background-color: #bfbfbf">NG</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: left">&nbsp;<b>Truck Camera Check</b></td>
                                            <?php
                                            if ($TruckCheck == 'OK') { //OK คือไม่มีข้อมูล Truvk Camera
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #68E411;"><b>&#10004;</b></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center"></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: left">ไม่มีข้อมูลการตรวจสอบรถผิดปกติประจำปี:&nbsp;<b><?=$result_seYears['YEARS']?> </b></td>
                                            <?php
                                            }else { // OK
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: left"></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #E44411;"><b>&#10006;</b></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: left">มีข้อมูลการตรวจสอบรถผิดปกติประจำปี:&nbsp;<b><?=$result_seYears['YEARS']?></b> &nbsp;&nbsp;จำนวน:&nbsp;<b><?=$result_CountTruckCheck['TRUCKCOUNT']?></b>&nbsp;ครั้ง</b></td>
                                            <?php
                                            }
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: center"><button type="button" style= "height:40px;width:150px" class="btn btn-primary btn-md" name="myBtn" id ="myBtn" onclick="truckcamera('<?=$empcheck?>','<?=$result_seYears['YEARS']?>','<?=$result_seYears['YEARS']?>')">รายละเอียด Truck</button></td>
                                            
                                        </tr>
                                        <tr>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: left">&nbsp;<b>Acident History</b></td>
                                            <?php
                                            if ($AcciCheck == 'OK') { //NO คือไม่มีข้อมูลอุบัติเหตุ
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #68E411;"><b>&#10004;</b></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center"></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: left">ไม่มีข้อมูลอุบัติเหตุประจำปี:&nbsp;<b><?=$result_seYears['YEARS']?> </b></td>
                                            <?php
                                            }else { // OK
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: left"></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #E44411;"><b>&#10006;</b></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: left">มีอุบัติเหตุประจำปี:&nbsp;<b><?=$result_seYears['YEARS']?></b> &nbsp;&nbsp;จำนวน:&nbsp;<b><?=$result_CountAccident['ACCICOUNT']?></b>&nbsp;ครั้ง</b></td>
                                            <?php
                                            }
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: center"><button type="button" style= "height:40px;width:150px" class="btn btn-primary btn-md" name="myBtn" id ="myBtn" onclick="acidentdata('<?=$empcheck?>','<?=$result_seYears['YEARS']?>','<?=$result_seYears['YEARS']?>')">รายละเอียด Acident</button></td>
                                        </tr>
                                        <tr>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: left">&nbsp;<b>Working Issue</b></td>
                                            <?php
                                            if ($WorkingCheck == 'OK') { //NO คือไม่มีข้อมูลอุบัติเหตุ
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #68E411;"><b>&#10004;</b></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center"></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: left">ไม่มีข้อมูลปัญหาการทำงานประจำปี:&nbsp;<b><?=$result_seYears['YEARS']?></b></td>
                                            <?php
                                            }else { // OK
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: left"></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 18px;text-align: center;background-color: #E44411;"><b>&#10006;</b></td>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: left">มีข้อมูลปัญหาการทำงานประจำปี:&nbsp;<b><?=$result_seYears['YEARS']?></b>&nbsp;&nbsp;จำนวน:&nbsp;<b><?=$result_WorkingIssue['WORKINGCOUNT']?></b>&nbsp;ครั้ง</b></td>
                                            <?php
                                            }
                                            ?>
                                            <td colspan ="1" style="border:1px solid black;font-size: 16px;text-align: center"><button type="button" style= "height:40px;width:150px" class="btn btn-primary btn-md" name="myBtn" id ="myBtn" onclick="workingissuedata('<?=$empcheck?>','<?=$result_seYears['YEARS']?>','<?=$result_seYears['YEARS']?>')">รายละเอียด Working</button></td>
                                        </tr>
                                        <!-- <tr>
                                            <td colspan ="6" style="font-size: 16px;">&nbsp;<b></b></td>
                                        </tr>   -->
                                    </tbody>
                                    
                                </table>
                            </div>
                            <div class = "row">
                                <label ></label>
                            </div>
                           <!-- Punctuality -->
                            <h2><u>Punctuality</u></h2>
                            <div class="col-lg-12">
                                <div style="text-align: center;">
                                    <?php
                                        $dateyesterday = date('Y/m/d',strtotime("-1 day"));
                                        $GETEMP = $_GET['employeecode1'];
                                        $stmt_feedbackdriver = "SELECT * FROM DIGITALTENKO_FEEDBACKDRIVER TKFBD LEFT JOIN EMPLOYEEEHR2 EMP ON EMP.nameE = TKFBD.Driver_name WHERE NOT Hop IS NULL AND PersonCode = '$GETEMP' AND ROUTE_DATE = '$dateyesterday'";
                                        $query_feedbackdriver = sqlsrv_query($conn, $stmt_feedbackdriver);
                                    ?>
                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example6" role="grid" aria-describedby="dataTables-example_info" >
                                        <thead style="border:1px solid black;">
                                            <tr>
                                                <th style="text-align: center;border:1px solid black;background-color: #bfbfbf">RUN SEQ</th>
                                                <th style="text-align: center;border:1px solid black;background-color: #bfbfbf">HOP</th>
                                                <th style="text-align: center;border:1px solid black;background-color: #bfbfbf">LOCATION</th>
                                                <th style="text-align: center;border:1px solid black;background-color: #bfbfbf">PLAN ARRIVAL</th>
                                                <th style="text-align: center;border:1px solid black;background-color: #bfbfbf">PLAN DEPARTURE</th>
                                                <th style="text-align: center;border:1px solid black;background-color: #bfbfbf">OPERATION TIME PLAN</th>
                                                <th style="text-align: center;border:1px solid black;background-color: #bfbfbf">ACTUAL ARRIVAL</th>
                                                <th style="text-align: center;border:1px solid black;background-color: #bfbfbf">ACTUAL DEPARTURE</th>
                                                <th style="text-align: center;border:1px solid black;background-color: #bfbfbf">OPERATION TIME ACTUAL</th>
                                                <th style="text-align: center;border:1px solid black;background-color: #bfbfbf">TYPE</th>
                                                <th style="text-align: center;border:1px solid black;background-color: #bfbfbf">PUNC OF ARRIVAL</th>
                                                <th style="text-align: center;border:1px solid black;background-color: #bfbfbf">PUNC OF DEPARTURE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($result_feedbackdriver = sqlsrv_fetch_array($query_feedbackdriver, SQLSRV_FETCH_ASSOC)) { ?>
                                            <tr>
                                                <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff8e0">&nbsp;<b><?php echo $result_feedbackdriver["RUN_SEQ"];?></b></td>
                                                <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff8e0">&nbsp;<b><?php echo $result_feedbackdriver["HOP"];?></b></td>
                                                <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff8e0">&nbsp;<b><?php echo $result_feedbackdriver["LOCATION"];?></b></td>
                                                <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #e0eaff">&nbsp;<b><?php echo $result_feedbackdriver["PLAN_ARRIVAL"];?></b></td>
                                                <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #e0eaff">&nbsp;<b><?php echo $result_feedbackdriver["PLAN_DEPARTURE"];?></b></td>
                                                <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #e0eaff">&nbsp;<b><?php echo $result_feedbackdriver["OPERATION_TIME_PLAN"];?></b></td>
                                                <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #e2ffe0">&nbsp;<b><?php echo $result_feedbackdriver["ACTUAL_ARRIVAL"];?></b></td>
                                                <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #e2ffe0">&nbsp;<b><?php echo $result_feedbackdriver["ACTUAL_DEPARTURE"];?></b></td>
                                                <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #e2ffe0">&nbsp;<b><?php echo $result_feedbackdriver["OPERATION_TIME_ACTUAL"];?></b></td>
                                                <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #ffe8e0">&nbsp;<b><?php echo $result_feedbackdriver["TYPE"];?></b></td>
                                                <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #ffe8e0">&nbsp;<b><?php echo $result_feedbackdriver["PUNC_OF_ARRIVAL"];?></b></td>
                                                <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #ffe8e0">&nbsp;<b><?php echo $result_feedbackdriver["PUNC_OF_DEPARTURE"];?></b></td>
                                            </tr>
                                            <!-- <tr>
                                                <td colspan ="6" style="font-size: 16px;">&nbsp;<b></b></td>
                                            </tr>   -->
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        
                        </div>
                        
                    </div>
                    <div class="modal-footer">                                            
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>

            </div>
          </div>
        </div>
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">

            <div class="navbar-header" >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../pages/index.php"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <font style="color:#337ab7 "><?= $result_seEmployee['nameT'] ?></font>
                </li>
                <li class="dropdown">
                    <?php
                    if ($_SESSION["ROLENAME"] != "") {
                        ?>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <?= $_SESSION["ROLENAME"] ?>
                        </a>
                        <?php
                    } else {
                        ?>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            เลือกสิทธิ์เข้าใช้งาน <i class="fa fa-caret-down"></i>
                        </a>
                        <?php
                    }
                    ?>
                    <ul class="dropdown-menu dropdown-user">
                        <?php
                        $query_sePremissions3 = sqlsrv_query($conn, $sql_sePremissions, $params_sePremissions);
                        while ($result_sePremissions3 = sqlsrv_fetch_array($query_sePremissions3, SQLSRV_FETCH_ASSOC)) {
                            ?>
                            <li><a href="" onclick="create_premissions('<?= $result_sePremissions3['ROLEID'] ?>');"><i class="fa fa-user fa-fw"></i> <?= $result_sePremissions3['ROLENAME'] ?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>

                <!-- <li>
                    <font style="color:#337ab7 "><?= $result_sePremissions["NAME"] ?></font>
                </li> -->
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







        <div class="row" >
            <div class="col-lg-12">

                <h5 class="page-header">

                    เอกสารเท็งโกะ
                    

                </h5>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <?php
        if ($_GET['vehicletransportplanid'] != '') {
            ?>
            <div class="row">
                <div class="col-lg-7">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background-color: #e7e7e7">
                            <?php
                            echo 'เลขที่เท็งโกะ : ' . $result_seTenkomaster_temp['TENKOMASTERID'];
                            ?>
                            &emsp;<!--<input type="checkbox" id="chk_dayone" name="chk_dayone" style="transform: scale(2)">&emsp;: <font style="color: red"><u><i> กรณี "เท็งโกะเลิกงาน->เท็งโกะเริ่มงาน" ในวันเดียวกัน</u></i></font>-->
                            
                        </div>
                        <div class="panel-body">

                            <div class="row" >

                                <?php
                                $sql_seBeforeresult1 = "{call megEdittenkobefore_v2(?,?,?)}";
                                $params_seBeforeresult1 = array(
                                    array('select_beforeresult', SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
                                );
                                $query_seBeforeresult1 = sqlsrv_query($conn, $sql_seBeforeresult1, $params_seBeforeresult1);
                                $result_seBeforeresult1 = sqlsrv_fetch_array($query_seBeforeresult1, SQLSRV_FETCH_ASSOC);


                                $sql_seBeforeresult2 = "{call megEdittenkobefore_v2(?,?,?)}";
                                $params_seBeforeresult2 = array(
                                    array('select_beforeresult', SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE2'], SQLSRV_PARAM_IN)
                                );
                                $query_seBeforeresult2 = sqlsrv_query($conn, $sql_seBeforeresult2, $params_seBeforeresult2);
                                $result_seBeforeresult2 = sqlsrv_fetch_array($query_seBeforeresult2, SQLSRV_FETCH_ASSOC);


                                $sql_seBeforecheck1 = "{call megEdittenkobefore_v2(?,?,?)}";
                                $params_seBeforecheck1 = array(
                                    array('select_beforecheck', SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
                                );
                                $query_seBeforecheck1 = sqlsrv_query($conn, $sql_seBeforecheck1, $params_seBeforecheck1);
                                $result_seBeforecheck1 = sqlsrv_fetch_array($query_seBeforecheck1, SQLSRV_FETCH_ASSOC);



                                $sql_seBeforecheck2 = "{call megEdittenkobefore_v2(?,?,?)}";
                                $params_seBeforecheck2 = array(
                                    array('select_beforecheck', SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE2'], SQLSRV_PARAM_IN)
                                );
                                $query_seBeforecheck2 = sqlsrv_query($conn, $sql_seBeforecheck2, $params_seBeforecheck2);
                                $result_seBeforecheck2 = sqlsrv_fetch_array($query_seBeforecheck2, SQLSRV_FETCH_ASSOC);



                                $sql_seTransportresult1 = "{call megEdittenkotransport_v2(?,?,?,?,?)}";
                                $params_seTransportresult1 = array(
                                    array('select_transportresultnew', SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN),
                                    array('', SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster["DATEINPUT_F1"], SQLSRV_PARAM_IN)
                                );
                                $query_seTransportresult1 = sqlsrv_query($conn, $sql_seTransportresult1, $params_seTransportresult1);
                                $result_seTransportresult1 = sqlsrv_fetch_array($query_seTransportresult1, SQLSRV_FETCH_ASSOC);





                                $sql_seTransportresult2 = "{call megEdittenkotransport_v2(?,?,?,?,?)}";
                                $params_seTransportresult2 = array(
                                    array('select_transportresultnew', SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE2'], SQLSRV_PARAM_IN),
                                    array('', SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster["DATEINPUT_F1"], SQLSRV_PARAM_IN)
                                );
                                $query_seTransportresult2 = sqlsrv_query($conn, $sql_seTransportresult2, $params_seTransportresult2);
                                $result_seTransportresult2 = sqlsrv_fetch_array($query_seTransportresult2, SQLSRV_FETCH_ASSOC);


                                $sql_seTransportcheck1 = "{call megEdittenkotransport_v2(?,?,?)}";
                                $params_seTransportcheck1 = array(
                                    array('select_transportcheck', SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
                                );
                                $query_seTransportcheck1 = sqlsrv_query($conn, $sql_seTransportcheck1, $params_seTransportcheck1);
                                $result_seTransportcheck1 = sqlsrv_fetch_array($query_seTransportcheck1, SQLSRV_FETCH_ASSOC);



                                $sql_seTransportcheck2 = "{call megEdittenkotransport_v2(?,?,?)}";
                                $params_seTransportcheck2 = array(
                                    array('select_transportcheck', SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE2'], SQLSRV_PARAM_IN)
                                );
                                $query_seTransportcheck2 = sqlsrv_query($conn, $sql_seTransportcheck2, $params_seTransportcheck2);
                                $result_seTransportcheck2 = sqlsrv_fetch_array($query_seTransportcheck2, SQLSRV_FETCH_ASSOC);


                                $sql_seAfterresult1 = "{call megEdittenkoafter_v2(?,?,?)}";
                                $params_seAfterresult1 = array(
                                    array('select_afterresult', SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
                                );
                                $query_seAfterresult1 = sqlsrv_query($conn, $sql_seAfterresult1, $params_seAfterresult1);
                                $result_seAfterresult1 = sqlsrv_fetch_array($query_seAfterresult1, SQLSRV_FETCH_ASSOC);


                                $sql_seAfterresult2 = "{call megEdittenkoafter_v2(?,?,?)}";
                                $params_seAfterresult2 = array(
                                    array('select_afterresult', SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE2'], SQLSRV_PARAM_IN)
                                );
                                $query_seAfterresult2 = sqlsrv_query($conn, $sql_seAfterresult2, $params_seAfterresult2);
                                $result_seAfterresult2 = sqlsrv_fetch_array($query_seAfterresult2, SQLSRV_FETCH_ASSOC);


                                $sql_seAftercheck1 = "{call megEdittenkoafter_v2(?,?,?)}";
                                $params_seAftercheck1 = array(
                                    array('select_aftercheck', SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
                                );
                                $query_seAftercheck1 = sqlsrv_query($conn, $sql_seAftercheck1, $params_seAftercheck1);
                                $result_seAftercheck1 = sqlsrv_fetch_array($query_seAftercheck1, SQLSRV_FETCH_ASSOC);


                                $sql_seAftercheck2 = "{call megEdittenkoafter_v2(?,?,?)}";
                                $params_seAftercheck2 = array(
                                    array('select_aftercheck', SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
                                    array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE2'], SQLSRV_PARAM_IN)
                                );
                                $query_seAftercheck2 = sqlsrv_query($conn, $sql_seAftercheck2, $params_seAftercheck2);
                                $result_seAftercheck2 = sqlsrv_fetch_array($query_seAftercheck2, SQLSRV_FETCH_ASSOC);
                                ?>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>เปลี่ยนกะ</label>
                                        <select class="form-control" id="cb_changeka" name="cb_changeka">
                                            <?php
                                            switch ($result_seTenkomaster['TENKOMASTERKA']) {
                                                case 'เปลี่ยนกะกลางวัน': {
                                                        ?>
                                                        <option value = "" >ไม่เปลี่ยนกะ</option>
                                                        <option value = "เปลี่ยนกะกลางวัน" selected="">เปลี่ยนกะกลางวัน</option>
                                                        <option value = "เปลี่ยนกะกลางคืน" >เปลี่ยนกะกลางคืน</option>

                                                        <?php
                                                    }
                                                    break;
                                                case 'เปลี่ยนกะกลางคืน': {
                                                        ?>
                                                        <option value = "" >ไม่เปลี่ยนกะ</option>
                                                        <option value = "เปลี่ยนกะกลางวัน" >เปลี่ยนกะกลางวัน</option>
                                                        <option value = "เปลี่ยนกะกลางคืน" selected="">เปลี่ยนกะกลางคืน</option>

                                                        <?php
                                                    }
                                                    break;


                                                default : {
                                                        ?>
                                                        <option value = "" >ไม่เปลี่ยนกะ</option>
                                                        <option value = "เปลี่ยนกะกลางวัน" >เปลี่ยนกะกลางวัน</option>
                                                        <option value = "เปลี่ยนกะกลางคืน" >เปลี่ยนกะกลางคืน</option>

                                                        <?php
                                                    }
                                                    break;
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>



                                <div class = "col-lg-3">
                                    <div class = "form-group">
                                        <label>สถานะ</label>

                                        <select  class="form-control" id="cb_status" name="cb_status">

                                            <?php
                                            $selected = "SELECTED";

                                            switch ($result_seTenkomaster['ACTIVESTATUS']) {
                                                case '1': {
                                                        ?>
                                                        <option value = "0" >ไม่ใช้งาน</option>
                                                        <option value = "1" <?= $selected ?>>ใช้งาน</option>
                                                        <?php
                                                    }
                                                    break;
                                                case '0': {
                                                        ?>
                                                        <option value = "0" <?= $selected ?>>ไม่ใช้งาน</option>
                                                        <option value="1" >ใช้งาน</option>
                                                        <?php
                                                    }
                                                    break;

                                                default : {
                                                        ?>
                                                        <option value="1" >ใช้งาน</option>
                                                        <option value = "0">ไม่ใช้งาน</option>

                                                        <?php
                                                    }
                                                    break;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>เป้าหมายการวิ่งงานวันนี้</label>
                                        <div class="dropdown bootstrap-select show-tick form-control">
                                            <?php
                                            $chktarget1 = ($result_seTenkomaster['TENKOTARGET1'] == '1') ? "checked" : "";
                                            $chktarget2 = ($result_seTenkomaster['TENKOTARGET2'] == '1') ? "checked" : "";
                                            $chktarget3 = ($result_seTenkomaster['TENKOTARGET3'] == '1') ? "checked" : "";
                                            $chktarget4 = ($result_seTenkomaster['TENKOTARGET4'] == '1') ? "checked" : "";
                                            $chktarget5 = ($result_seTenkomaster['TENKOTARGET5'] == '1') ? "checked" : "";
                                            $chktarget6 = ($result_seTenkomaster['TENKOTARGET6'] == '1') ? "checked" : "";
                                            $chktarget7 = ($result_seTenkomaster['TENKOTARGET7'] == '1') ? "checked" : "";
                                            ?>
                                            <input type="checkbox" id="chk_target1" <?= $chktarget1 ?>> -ขับเว้นระยะห่าง 3 วิ <br>
                                            <input type="checkbox" id="chk_target2" <?= $chktarget2 ?>> -ควบคุมพวงมาลัยให้คงที่ <br>
                                            <input type="checkbox" id="chk_target3" <?= $chktarget3 ?>> -ให้ใช้ความเร็วต่ำขณะผ่านที่ชุมชน <br>
                                            <input type="checkbox" id="chk_target4" <?= $chktarget4 ?>> -ง่วงไม่ฝืนขับ <br>
                                            <input type="checkbox" id="chk_target5" <?= $chktarget5 ?>> -ปฎิบัติงานตามขั้นตอน <br>
                                            <input type="checkbox" id="chk_target6" <?= $chktarget6 ?>> -ขับขี่ตามกฎจราจร <br>
                                            <input type="checkbox" id="chk_target7" <?= $chktarget7 ?>> -พบสิ่งผิดปกติให้ หยุด-เรียก-รอ <br>


                                        </div>
                                    </div>
                                </div>


                            </div>


                            <div class="row" >
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>รายละเอียดงาน (เท็งโกะก่อนเริ่มงาน ข้อ 12.)</label><label></label>
                                        <textarea class="form-control" autocomplete="off" rows="4" id="txt_remark1" name="txt_remark1" ><?= $result_seTenkomaster['TENKOMASTERREMARKBEFORE'] ?></textarea>

                                    </div>
                                </div>




                            </div>




                            <!-- /.row (nested) -->
                        </div>
                        <div class="panel-footer">
                        <th  colspan="7" >
                            <?php
                            
                            // echo "ทดสอบ";

                           
                            // echo concatenate();
                            // echo $_SERVER['SERVER_SOFTWARE'];
                            // echo "<br>";
                            // echo $_SERVER['SERVER_NAME'];
                            // echo "<br>";
                            // echo $_SERVER['HTTP_HOST'];
                            // echo "<br>";
                            // echo $_SERVER['HTTP_REFERER'];
                            // echo "<br>";
                            // echo $_SERVER['HTTP_USER_AGENT'];
                            // echo "<br>";
                            // echo $_SERVER['SCRIPT_NAME'];


                            ?>
                            <!-- <input type="button" onclick="commitchk('<?=$result_seSelfCheck1['SELFCHECKID']?>')" id="commit_chk" name="commit_chk" class="btn btn-success" value=" "> <font style="color: green"></font> -->
                        </th>
                            <input type="button" onclick="save_tenkomasterdriver('<?= $result_seTenkomaster_temp['TENKOMASTERID'] ?>');" name="btnSend" id="btnSend" value="บันทึกข้อมูล" class="btn btn-primary">


                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-5">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            เลขที่ JOB : <?= $result_sePlain['JOBNO'] ?>
                        </div>
                        <div class="panel-body">
                            <div class="row" >
                                <div class="col-lg-12">
                                    <table  style="width: 100%">
                                        <tr>
                                            <td style="width: 50%">
                                                <label>ต้นทาง : <?= $result_sePlain['JOBSTART'] ?></label>
                                            </td>
                                            <!--<td rowspan="3" style="text-align: right">
                                            <?php
                                            //if ($_GET['employeecode1'] != "") {
                                            ?>
                                                    <img style="width: 20%" src="../images/employee/<?//= $result_sePlain['EMPLOYEECODE1'] ?>.jpg">
                                            <?php
                                            //} else if ($_GET['employeecode2'] != "") {
                                            ?>
                                                    <img style="width: 20%" src="../images/employee/<?//= $result_sePlain['EMPLOYEECODE2'] ?>.jpg">
                                            <?php
                                            //}
                                            ?>
                                            </td>
                                            -->
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>โซน : <?= $result_sePlain['CLUSTER'] ?></label>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                <label>ปลายทาง : <?= $result_sePlain['JOBEND'] ?></label>
                                            </td>

                                        </tr>
                                    </table>
                                </div>
                            </div>



                            <div class="row" >
                                <div class="col-lg-12">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center"><!--<input type="button" onclick="commit()" class="btn btn-success" value="Commit">--></th>
                                                <th colspan="2" style="text-align: center">ก่อนเริ่มงาน</th>
                                                <th colspan="2" style="text-align: center">ระหว่างทาง</th>
                                                <th colspan="2" style="text-align: center">เลิกงาน</th>
                                            </tr>
                                            <tr>

                                                <th style="text-align: center">พขร.</th>
                                                <th style="text-align: center">ตรวจสอบ</th>
                                                <th style="text-align: center">ผลตรวจ</th>
                                                <th style="text-align: center">ตรวจสอบ</th>
                                                <th style="text-align: center">ผลตรวจ</th>
                                                <th style="text-align: center">ตรวจสอบ</th>
                                                <th style="text-align: center">ผลตรวจ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <?php
                                                if ($result_sePlain['COMPANYCODE'] == 'RRC' || $result_sePlain['COMPANYCODE'] == 'RCC' || $result_sePlain['COMPANYCODE'] == 'RATC') {
                                                    ?>
                                                    <td><a href="#" onclick="save_tenkomastergw('<?= $_GET['vehicletransportplanid'] ?>', '<?= $result_seTenkomaster_temp['TENKOMASTERDIRVERCODE1'] ?>', '1')"><?= $result_sePlain['EMPLOYEENAME1'] ?>(1)</a></td>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <td><a href="#" onclick="save_tenkomasteramt('<?= $_GET['vehicletransportplanid'] ?>', '', '<?= $result_seTenkomaster_temp['TENKOMASTERDIRVERCODE1'] ?>', '1')"><?= $result_sePlain['EMPLOYEENAME1'] ?>(1)</a></td>
                                                    <?php
                                                }
                                                ?>

                                                <td style="text-align: center">

                                                    <?php
                                                    if ($result_seBeforecheck1['TENKOBEFORECHECK'] == "1") {
                                                        ?>
                                                        <span class="glyphicon glyphicon-ok" id="icon_beforecheckok1" style="color: green"></span>
                                                        <span class="glyphicon glyphicon-remove" id="icon_beforecheckno1" style="display: none;color: red"></span>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <span class="glyphicon glyphicon-remove" id="icon_beforecheckno1" style="color: red"></span>
                                                        <span class="glyphicon glyphicon-ok" id="icon_beforecheckok1" style="display: none;color: green"></span>
                                                        <?php
                                                    }
                                                    ?></td>
                                                <td style="text-align: center">


                                                    <?php
                                                    if ($result_seBeforeresult1['TENKOBEFORERESULT'] == "1") {
                                                        ?>
                                                        <span class="glyphicon glyphicon-ok" id="icon_beforeresultok1" style="color: green"></span>
                                                        <span class="glyphicon glyphicon-remove" id="icon_beforeresultno1" style="display: none;color: red"></span>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <span class="glyphicon glyphicon-remove" id="icon_beforeresultno1" style="color: red"></span>
                                                        <span class="glyphicon glyphicon-ok" id="icon_beforeresultok1" style="display: none;color: green"></span>
                                                        <?php
                                                    }
                                                    ?></td><td style="text-align: center">

                                                    <?php
                                                    if ($result_seTransportcheck1['TENKOTRANSPORTCHECK'] == "1") {
                                                        ?>
                                                        <span class="glyphicon glyphicon-ok" id="icon_transportcheckok1" style="color: green"></span>
                                                        <span class="glyphicon glyphicon-remove" id="icon_transportcheckno1" style="display: none;color: red"></span>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <span class="glyphicon glyphicon-remove" id="icon_transportcheckno1" style="color: red"></span>
                                                        <span class="glyphicon glyphicon-ok" id="icon_transportcheckok1" style="display: none;color: green"></span>
                                                        <?php
                                                    }
                                                    ?></td>
                                                <td style="text-align: center">
                                                    <?php
                                                    // echo $result_seTransportresult1['TENKOTRANSPORTRESULT'];
                                                    if ($result_seTransportresult1['TENKOTRANSPORTRESULT'] == '1') {
                                                        ?>
                                                        <span class="glyphicon glyphicon-ok" id="icon_transportrsok1" style="color: green"></span>
                                                        <span class="glyphicon glyphicon-remove" id="icon_transportrsno1" style="display: none;color: red"></span>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <span class="glyphicon glyphicon-remove" id="icon_transportrsno1" style="color: red"></span>
                                                        <span class="glyphicon glyphicon-ok" id="icon_transportrsok1" style="display: none;color: green"></span>

                                                        <?php
                                                    }
                                                    ?></td>
                                                <td style="text-align: center">

                                                    <?php
                                                    if ($result_seAftercheck1['TENKOAFTERCHECK'] == "1") {
                                                        ?>
                                                        <span class="glyphicon glyphicon-ok" id="icon_afftercheckok1" style="color: green"></span>
                                                        <span class="glyphicon glyphicon-remove" id="icon_afftercheckno1" style="display: none;color: red"></span>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <span class="glyphicon glyphicon-remove" id="icon_afftercheckno1" style="color: red"></span>
                                                        <span class="glyphicon glyphicon-ok" id="icon_afftercheckok1" style="display: none;color: green"></span>
                                                        <?php
                                                    }
                                                    ?></td>
                                                <td style="text-align: center">


                                                    <?php
                                                    if ($result_seAfterresult1['TENKOAFTERRESULT'] == "1") {
                                                        ?>
                                                        <span class="glyphicon glyphicon-ok" id="icon_affterresultok1" style="color: green"></span>
                                                        <span class="glyphicon glyphicon-remove" id="icon_affterresultno1" style="display: none;color: red"></span>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <span class="glyphicon glyphicon-remove" id="icon_affterresultno1" style="color: red"></span>
                                                        <span class="glyphicon glyphicon-ok" id="icon_affterresultok1" style="display: none;color: green"></span>
                                                        <?php
                                                    }
                                                    ?></td>
                                            </tr>
                                            <?php
                                            if ($result_sePlain['EMPLOYEENAME2'] != "") { /// พขร คนที่ 2
                                                ?>
                                                <tr>
                                                    <?php
                                                    if ($result_sePlain['COMPANYCODE'] == 'RRC' || $result_sePlain['COMPANYCODE'] == 'RCC' || $result_sePlain['COMPANYCODE'] == 'RATC') {
                                                        ?>
                                                        <td><a href="#" onclick="save_tenkomastergw('<?= $_GET['vehicletransportplanid'] ?>', '<?= $result_seTenkomaster_temp['TENKOMASTERDIRVERCODE2'] ?>', '2')"><?= $result_sePlain['EMPLOYEENAME2'] ?>(2)</a></td>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <td><a href="#" onclick="save_tenkomasteramt('<?= $_GET['vehicletransportplanid'] ?>', '', '<?= $result_seTenkomaster_temp['TENKOMASTERDIRVERCODE2'] ?>', '2')"><?= $result_sePlain['EMPLOYEENAME2'] ?>(2)</a></td>
                                                        <?php
                                                    }
                                                    ?>
                                                    <td style="text-align: center"><?php
                                                        if ($result_seBeforecheck2['TENKOBEFORECHECK'] == "1") {
                                                            ?>
                                                            <span class="glyphicon glyphicon-ok" id="icon_beforecheckok2" style="color: green"></span>
                                                            <span class="glyphicon glyphicon-remove" id="icon_beforecheckno2" style="display: none;color: red"></span>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <span class="glyphicon glyphicon-remove" id="icon_beforecheckno2" style="color: red"></span>
                                                            <span class="glyphicon glyphicon-ok" id="icon_beforecheckok2" style="display: none;color: green"></span>
                                                            <?php
                                                        }
                                                        ?></td>
                                                    <td style="text-align: center"><?php
                                                        if ($result_seBeforeresult2['TENKOBEFORERESULT'] == "1") {
                                                            ?>
                                                            <span class="glyphicon glyphicon-ok" id="icon_beforeresultok2" style="color: green"></span>
                                                            <span class="glyphicon glyphicon-remove" id="icon_beforeresultno2" style="display: none;color: red"></span>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <span class="glyphicon glyphicon-remove" id="icon_beforeresultno2" style="color: red"></span>
                                                            <span class="glyphicon glyphicon-ok" id="icon_beforeresultok2" style="display: none;color: green"></span>
                                                            <?php
                                                        }
                                                        ?></td>
                                                    <td style="text-align: center">
                                                        <?php
                                                        if ($result_seTransportcheck2['TENKOTRANSPORTCHECK'] == "1") {
                                                            ?>
                                                            <span class="glyphicon glyphicon-ok" id="icon_transportcheckok2" style="color: green"></span>
                                                            <span class="glyphicon glyphicon-remove" id="icon_transportcheckno2" style="display: none;color: red"></span>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <span class="glyphicon glyphicon-remove" id="icon_transportcheckno2" style="color: red"></span>
                                                            <span class="glyphicon glyphicon-ok" id="icon_transportcheckok2" style="display: none;color: green"></span>
                                                            <?php
                                                        }
                                                        ?></td>
                                                    <td style="text-align: center"><?php
                                                        if ($result_seTransportresult2['TENKOTRANSPORTRESULT'] == '1') {
                                                            ?>

                                                            <span class="glyphicon glyphicon-ok" id="icon_transportrsok2" style="color: green"></span>
                                                            <span class="glyphicon glyphicon-remove" id="icon_transportrsno2" style="display: none;color: red"></span>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <span class="glyphicon glyphicon-remove" id="icon_transportrsno2" style="color: red"></span>
                                                            <span class="glyphicon glyphicon-ok" id="icon_transportrsok2" style="display: none;color: green"></span>

                                                            <?php
                                                        }
                                                        ?></td>

                                                    <td style="text-align: center"><?php
                                                        if ($result_seAftercheck2['TENKOAFTERCHECK'] == "1") {
                                                            ?>
                                                            <span class="glyphicon glyphicon-ok" id="icon_afftercheckok2" style="color: green"></span>
                                                            <span class="glyphicon glyphicon-remove" id="icon_afftercheckno2" style="display: none;color: red"></span>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <span class="glyphicon glyphicon-remove" id="icon_afftercheckno2" style="color: red"></span>
                                                            <span class="glyphicon glyphicon-ok" id="icon_afftercheckok2" style="display: none;color: green"></span>
                                                            <?php
                                                        }
                                                        ?></td>
                                                    <td style="text-align: center"><?php
                                                        if ($result_seAfterresult2['TENKOAFTERRESULT'] == "1") {
                                                            ?>
                                                            <span class="glyphicon glyphicon-ok" id="icon_affterresultok2" style="color: green"></span>
                                                            <span class="glyphicon glyphicon-remove" id="icon_affterresultno2" style="display: none;color: red"></span>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <span class="glyphicon glyphicon-remove" id="icon_affterresultno2" style="color: red"></span>
                                                            <span class="glyphicon glyphicon-ok" id="icon_affterresultok2" style="display: none;color: green"></span>
                                                            <?php
                                                        }
                                                        ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
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
                    &nbsp;

                </div>
            </div>


            <div class="row" >
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <div class="row" >
                                <div class="col-lg-2">
                                    ตารางตรวจเท็งโกะ
                                </div>
                                <!-- <?php
                                $emp = ($_GET['employeecode1'] != "") ? $_GET['employeecode1'] : $_GET['employeecode2'];
                                if ($emp != "") {
                                    ?>


                                    <div class="col-lg-10 text-right">

                                    &nbsp;&nbsp;<a href="pdf_reportemployee4_1.php?employeecode=<?= $emp ?>&tenkomasterid=<?= $result_seTenkomaster_temp['TENKOMASTERID'] ?>&vehicletransportplanid=<?= $_GET['vehicletransportplanid'] ?>&selfcheckid=<?= $result_seSelfCheck1['SELFCHECKID'] ?>"  target ="_blank" class="btn btn-default">พิมพ์เอกสารเท็งโกะ พขร.1 <li class="fa fa-print"></li></a>&nbsp;&nbsp;
                                    </div>
                                    <?php
                                }
                                ?> -->
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills">


                                <li class="active"><a href="#tenko1" data-toggle="tab">เท็งโกะก่อนเริ่มงาน</a></li>
                                <li><a href="#tenko2" onclick="select_tenko2()" data-toggle="tab">เท็งโกะระหว่างทาง</a>



                                </li>
                                <?php
                                if (($result_sePlain['STATUSNUMBER'] != '1' || $result_sePlain['STATUS'] == 'แผนงานเปิดงาน') ||
                                        ($result_sePlain['STATUSNUMBER'] != '2' || $result_sePlain['STATUS'] == 'แผนงานปิดงาน') ||
                                        ($result_sePlain['STATUSNUMBER'] != 'T' || $result_sePlain['STATUS'] == 'แผนงานรอปิดงาน')) {
                                    ?>
                                    <li><a href="#tenko3" onclick="select_tenko3()" data-toggle="tab">เท็งโกะเลิกงาน</a>
                                        <?php
                                    } else {
                                        ?>
                                    <li><a href="#" data-toggle="tab">เท็งโกะเลิกงาน</a>
                                        <?php
                                    }
                                    ?>

                                </li>
                                <li><a href="#tenko4" onclick="select_tenko4()" data-toggle="tab">จุดเสี่ยงระหว่างเส้นทางขนส่ง</a>
                                </li>
                                <li><a href="#tenko5" onclick="select_tenko5()" data-toggle="tab">แผนที่</a>
                                </li>
                                <li><a href="#tenko6" onclick="select_tenko6()" data-toggle="tab">ตรวจสอบการฝ่าฝืนระบบ GPS</a>
                                </li>



                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <p>&nbsp;</p>
                                <?php
                                if ($_GET['employeecode1'] != "") {

                                    $sql_seChktenkorest = "SELECT DATEDIFF(HOUR,
                                                                        (SELECT TOP 1 MODIFIEDDATE FROM [dbo].[TENKOAFTER] WHERE [TENKOMASTERDIRVERCODE] = '" . $_GET['employeecode1'] . "' ORDER BY [MODIFIEDDATE]  DESC)
                                                                        ,(SELECT GETDATE()))  AS 'TENKORESTDATA'";
                                    $query_seChktenkorest = sqlsrv_query($conn, $sql_seChktenkorest, $params_seChktenkorest);
                                    $result_seChktenkorest = sqlsrv_fetch_array($query_seChktenkorest, SQLSRV_FETCH_ASSOC);
                                    //edit_tenkobeforetxt1($result_seChktenkorest['TENKORESTDATA'], 'TENKORESTDATA', $result_seTenkobefore['TENKOBEFOREID']);
                                    //editTenkobefore('edit_tenkobefore', $result_seTenkobefore['TENKOBEFOREID'], 'TENKORESTDATA', $result_seChktenkorest['TENKORESTDATA']);
                                    //editTenkobefore('edit_tenkobefore', $result_seTenkobefore['TENKOBEFOREID'], 'TENKORESTRESULT', 1);
                                    $RS_TENKORESTDATA = ($result_seChktenkorest['TENKORESTDATA'] > 24) ? '24' : $result_seChktenkorest['TENKORESTDATA'];


                                    $sql_seTenkorest = "{call megEdittenkobefore_v2(?,?)}";
                                    $params_seTenkorest = array(
                                        array('select_tenkorest', SQLSRV_PARAM_IN),
                                        array($employeecode1, SQLSRV_PARAM_IN)
                                    );
                                    $query_seTenkorest = sqlsrv_query($conn, $sql_seTenkorest, $params_seTenkorest);
                                    $result_seTenkorest = sqlsrv_fetch_array($query_seTenkorest, SQLSRV_FETCH_ASSOC);
                                    ?>

                                    <div class="tab-pane fade in active" id="tenko1">


                                        <?php
                                        $conditionTenkobefore = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND a.TENKOMASTERDIRVERCODE = '" . $_GET['employeecode1'] . "'";
                                        $sql_seTenkobefore = "{call megEdittenkobefore_v2(?,?,?)}";
                                        $params_seTenkobefore = array(
                                            array('select_tenkobefore', SQLSRV_PARAM_IN),
                                            array($conditionTenkobefore, SQLSRV_PARAM_IN),
                                            array('', SQLSRV_PARAM_IN)
                                        );
                                        $query_seTenkobefore = sqlsrv_query($conn, $sql_seTenkobefore, $params_seTenkobefore);
                                        $result_seTenkobefore = sqlsrv_fetch_array($query_seTenkobefore, SQLSRV_FETCH_ASSOC);


                                        $conditionTenkoafters = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode1'] . "'";
                                        $sql_seTenkoafters = "{call megEdittenkoafter_v2(?,?,?)}";
                                        $params_seTenkoafters = array(
                                            array('select_tenkoafter', SQLSRV_PARAM_IN),
                                            array($conditionTenkoafters, SQLSRV_PARAM_IN),
                                            array('', SQLSRV_PARAM_IN)
                                        );
                                        $query_seTenkoafters = sqlsrv_query($conn, $sql_seTenkoafters, $params_seTenkoafters);
                                        $result_seTenkoafters = sqlsrv_fetch_array($query_seTenkoafters, SQLSRV_FETCH_ASSOC);

                                        $sql_seTenkobeforerest = "SELECT DATEDIFF(HOUR,CONVERT(DATETIME,'" . $result_seTenkoafters['CREATEDATE'] . "',103),CONVERT(DATETIME,GETDATE())) AS AMOUNTREST FROM [dbo].[TENKOAFTER]
                                                    WHERE TENKOMASTERDIRVERCODE = '" . $result_seTenkobefore['TENKOMASTERDIRVERCODE'] . "'
                                                    AND TENKOAFTERID = (SELECT MAX(TENKOAFTERID) FROM [dbo].[TENKOAFTER] WHERE TENKOMASTERDIRVERCODE = '" . $result_seTenkobefore['TENKOMASTERDIRVERCODE'] . "')";
                                        $query_seTenkobeforerest = sqlsrv_query($conn, $sql_seTenkobeforerest, $params_seTenkobeforerest);
                                        $result_seTenkobeforerest = sqlsrv_fetch_array($query_seTenkobeforerest, SQLSRV_FETCH_ASSOC);

                                        $YEAR = date("Y");
                                        $sql_sehealth = "SELECT  TOP 1 ID,SHORTSIGHT,SHORTSIGHT_R,SHORTSIGHT_L
                                                    ,LONGSIGHT,LONGSIGHT_R,LONGSIGHT_L
                                                    ,OBLIQUESIGHT,OBLIQUESIGHT_R,OBLIQUESIGHT_L,CREATEYEAR
                                                    FROM [dbo].[HEALTHHISTORY]
                                                    WHERE EMPLOYEECODE ='" . $_GET['employeecode1'] . "'
                                                    AND CREATEYEAR ='" . $YEAR . "'
                                                    AND ACTIVESTATUS ='1'
                                                    ORDER BY CREATEDATE DESC";
                                        $params_sehealth = array();
                                        $query_sehealth = sqlsrv_query($conn, $sql_sehealth, $params_sehealth);
                                        $result_sehealth = sqlsrv_fetch_array($query_sehealth, SQLSRV_FETCH_ASSOC);    

                                        // ข้อมูลใบขับขี่คนที่1
                                        $sql_seCarData1 = "SELECT a.PersonID,a.nameT,a.CarLicenceID,
                                        FORMAT (b.ExpireCar_Start, 'dd/MM/yyyy') 'STARTDATE',
                                        FORMAT (b.ExpireCar_End, 'dd/MM/yyyy') AS 'ENDDATE' ,
                                        DATEDIFF(month, FORMAT (b.ExpireCar_End, 'yyyy/MM/dd '), FORMAT (GETDATE(), 'yyyy/MM/dd ')) AS 'MONTHDIFF'
                                        FROM [dbo].[EMPLOYEEEHR2] a
                                        INNER JOIN [dbo].[EMPLOYEEDETAILEHR] b ON a.PersonID = b.PersonID
                                        WHERE PersonCode ='".$_GET['employeecode1']."'";
                                        $query_seCarData1 = sqlsrv_query($conn, $sql_seCarData1, $params_seCarData1);
                                        $result_seCarData1 = sqlsrv_fetch_array($query_seCarData1, SQLSRV_FETCH_ASSOC);
                                        
                                        // echo $result_seCarData1['MONTHDIFF'];
                                        // echo '|';
                                        if ($result_seCarData1['MONTHDIFF'] == '-3') {
                                            // echo '1';
                                            $licensechk1 = "background-color: #f6ff54";
                                        }else if($result_seCarData1['MONTHDIFF'] == '-2'){
                                            // echo '2';
                                            $licensechk1 = "background-color: #ff9e54";
                                        }else if($result_seCarData1['MONTHDIFF'] == '-1' || $result_seCarData1['MONTHDIFF'] >= '0'){
                                            // echo '1';
                                            $licensechk1 = "background-color: #ff5454";
                                        }else{
                                            // echo '0';
                                            // ปกติ สีเขียว
                                            $licensechk1 = "background-color: #94FA67";
                                           
                                            
                                        }


                                        //เปลี่ยนปี ค.ศ เป็น พ.ศ วันที่ออกบัตรพนักงานคนที่1
                                        if ($result_seCarData1['STARTDATE'] == NULL) {
                                            $year11start =  '';
                                            $year12start =  '';
                                        }else {
                                            $year11start =  substr($result_seCarData1['STARTDATE'],0,6);
                                            $year12start =  substr($result_seCarData1['STARTDATE'],6,10)+543;
                                        }
                                        //เปลี่ยนปี ค.ศ เป็น พ.ศ วันที่หมดอายุพนักงานคนที่1
                                        if ($result_seCarData1['ENDDATE'] == NULL) {
                                            $year11end =  '';
                                            $year12end =  '';
                                        }else {
                                            $year11end =  substr($result_seCarData1['ENDDATE'],0,6);
                                            $year12end =  substr($result_seCarData1['ENDDATE'],6,10)+543;
                                        }
                                        
                                        // echo $year11start;
                                        // echo "<br>";
                                        // echo $year12start;



                                        // ข้อมูลวันที่รายงานตัวและวันที่ทำงานคนที่1 เพื่อเช็ค Self Check
                                        // DATEWORKING ใน SELFCHECK คือ DATERK ในแผน
                                        $sql_seDateSelfCheck1 = "SELECT CONVERT(VARCHAR(10),DATERK,103) AS 'DATERK',
                                        CONVERT(VARCHAR(10),DATEPRESENT,103)  AS 'DATEPRESENT'
                                        FROM VEHICLETRANSPORTPLAN
                                        WHERE VEHICLETRANSPORTPLANID ='".$_GET['vehicletransportplanid']."'";
                                        $query_seDateSelfCheck1 = sqlsrv_query($conn, $sql_seDateSelfCheck1, $params_seDateSelfCheck1);
                                        $result_seDateSelfCheck1 = sqlsrv_fetch_array($query_seDateSelfCheck1, SQLSRV_FETCH_ASSOC);
                                        
                                        // echo $result_seDateSelfCheck1['DATEWORKING'];
                                        // echo "<br>";
                                        // echo $result_seDateSelfCheck1['DATEPRESENT'];

                                        $dateself1 = date("d/m/Y"); //วันที่ปัจจุบันพนักงานคนที่1

                                        //SELF CHECKคนที่1
                                        $sql_seSelfCheck1 = "SELECT TOP 1 SELFCHECKID,SLEEPRESTSTART,SLEEPRESTEND,TIMESLEEPREST,
                                        SLEEPNORMALSTART,SLEEPNORMALEND,TIMESLEEPNORMAL,SLEEPEXTRASTART,SLEEPEXTRAEND,TIMESLEEPEXTRA,KEYDROPTIME,TIMEWORKING
                                        FROM DRIVERSELFCHECK WHERE EMPLOYEECODE ='".$_GET['employeecode1']."' 
                                        AND (CONVERT(VARCHAR(10),CREATEDATE,103) ='".$result_seDateSelfCheck1['DATERK']."' 
                                        OR CONVERT(VARCHAR(10),CREATEDATE,103) ='".$result_seDateSelfCheck1['DATEPRESENT']."')
                                        ORDER BY  CONVERT(CHAR(5), CREATEDATE, 108) DESC";
                                        $query_seSelfCheck1 = sqlsrv_query($conn, $sql_seSelfCheck1, $params_seSelfCheck1);
                                        $result_seSelfCheck1 = sqlsrv_fetch_array($query_seSelfCheck1, SQLSRV_FETCH_ASSOC);


                                        // $x = "Geeks";
                                        // $y = "for";
                                        // $z = "Geeks";
                                        // $a = 5;
                                        // $b = 10;
                                        
                                        // function concatenate() {
                                        //     // Using global keyword
                                        //     global $x, $y, $z;
                                        //     return $x.$y.$z;
                                        // }
                                        // echo concatenate();
                                        


                                        
                                        //เช็คจำนวนชั่วโมงในการนอน 4.5 ชั่วโมง
                                        if ($result_seSelfCheck1['TIMESLEEPEXTRA'] == '' || $result_seSelfCheck1['TIMESLEEPEXTRA'] == '<br /><b>Warning</b>:  sqlsrv_fetch_array() expects parameter 1 to be resource, boolean given in <b>') {
                                            $TIMESLEEPEXTRAHOURCHK1 = '0'; 
                                            $TIMESLEEPEXTRAMINCHK1  = '0';
                                        }else {
                                            // $TIMESLEEPEXTRA  = str_replace(":","",substr($result_seSelfCheck['TIMESLEEPEXTRA'],0,6));
                                            //$TIMESLEEPEXTRA = $result_seSelfCheck['TIMESLEEPEXTRA'];
                                            //เช็คจำนวนชั่วโมงในการนอน 
                                            $TIMESLEEPEXTRAHOURCHK1 = substr($result_seSelfCheck1['TIMESLEEPEXTRA'],0,2);
                                            //เช็คจำนวนนาทีในการนอน
                                            $TIMESLEEPEXTRAMINCHK1 = substr($result_seSelfCheck1['TIMESLEEPEXTRA'],2,3);
                                           if ($TIMESLEEPEXTRAHOURCHK1  == '4:') { //กรณีที่เท่ากับ 4 
                                                $TIMESLEEPEXTRAHOURCHK1 = 'HG4'; //HG4 mean Greater than 4 hour มากกว่า 4 ชม
                                           }else if ($TIMESLEEPEXTRAHOURCHK1 > '4') {
                                                $TIMESLEEPEXTRAHOURCHK1 = 'HGG4'; //เลข 4 ขึ้นไปและเลขสองหลัก ex 5, 6, 10
                                           }
                                           else {
                                                $TIMESLEEPEXTRAHOURCHK1 = 'HL4'; //HL4 mean Less than 4 hour น้อยกว่า 4 ชม  
                                           }
                                           //เช็คจำนวนนาทีในการนอน
                                           $TIMESLEEPEXTRAMINCHK1 = substr($result_seSelfCheck1['TIMESLEEPEXTRA'],2,3);
                                           if ($TIMESLEEPEXTRAMINCHK1 >= '30') {
                                                $TIMESLEEPEXTRAMINCHK1 = 'MG3'; //MG3 mean Greater than 30 minute มากกว่า 30นาที
                                           }else {
                                                $TIMESLEEPEXTRAMINCHK1 = 'ML3'; //ML3 mean Less than 30 minute น้อยกว่า 30นาที   
                                           }

                                        }   


                                        //เวลาการพักผ่อน 8 ชั่วโมง
                                        if ($result_seSelfCheck1['TIMESLEEPREST'] == '' || $result_seSelfCheck1['TIMESLEEPREST'] == '<br /><b>Warning</b>:  sqlsrv_fetch_array() expects parameter 1 to be resource, boolean given in <b>') {
                                            $TIMESLEEPREST1 = '0';
                                        }else {
                                            $TIMESLEEPREST1 = substr($result_seSelfCheck1['TIMESLEEPREST'],0,2);
                                        }

                                        //เวลาการนอนปกติ 6 ชั่วโมง
                                        if ($result_seSelfCheck1['TIMESLEEPNORMAL'] == '' || $result_seSelfCheck1['TIMESLEEPNORMAL'] == '<br /><b>Warning</b>:  sqlsrv_fetch_array() expects parameter 1 to be resource, boolean given in <b>') {
                                            $TIMESLEEPNORMAL1 = '0';
                                        }else {
                                            $TIMESLEEPNORMAL1 = substr($result_seSelfCheck1['TIMESLEEPNORMAL'],0,2);
                                        }
                                        
                                        // echo $TIMESLEEPNORMAL1;


                                        $check11 = ($result_seTenkobefore['TENKOBEFOREGREETCHECK'] == '1') ? "checked" : "";
                                        $check12 = ($result_seTenkobefore['TENKOUNIFORMCHECK'] == '1') ? "checked" : "";
                                        $check13 = ($result_seTenkobefore['TENKOBODYCHECK'] == '1') ? "checked" : "";
                                        //if ($result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKL' || $result_sePlain['COMPANYCODE'] == 'RKS') {
                                        $check14 = ($result_seTenkobefore['TENKORESTCHECK'] == '1' || $result_seTenkobefore['TENKORESTDATA'] > 7) ? "checked" : "";
                                        $rs141 = ($result_seTenkobefore['TENKORESTDATA'] > 7) ? "checked" : "";
                                        $rs140 = ($result_seTenkobefore['TENKORESTDATA'] < 8) ? "checked" : "";
                                        //}
                                        //else
                                        //{
                                        //    $check14 = ($result_seTenkobefore['TENKORESTCHECK'] == '1' || $RS_TENKORESTDATA > 7) ? "checked" : "";
                                        //    $rs141 = ($RS_TENKORESTDATA > 7) ? "checked" : "";
                                        //    $rs140 = ($RS_TENKORESTDATA < 8) ? "checked" : "";
                                        //}

                                        $check15 = ($result_seTenkobefore['TENKOSLEEPTIMECHECK'] == '1') ? "checked" : "";
                                        $check16 = ($result_seTenkobefore['TENKOTEMPERATURECHECK'] == '1') ? "checked" : "";
                                        $check17 = ($result_seTenkobefore['TENKOPRESSURECHECK'] == '1') ? "checked" : "";
                                        $check18 = ($result_seTenkobefore['TENKOALCOHOLCHECK'] == '1') ? "checked" : "";
                                        $check19 = ($result_seTenkobefore['TENKOWORRYCHECK'] == '1') ? "checked" : "";
                                        $check110 = ($result_seTenkobefore['TENKODAILYTRAILERCHECK'] == '1') ? "checked" : "";
                                        $check111 = ($result_seTenkobefore['TENKOCARRYCHECK'] == '1') ? "checked" : "";
                                        $check112 = ($result_seTenkobefore['TENKOJOBDETAILCHECK'] == '1') ? "checked" : "";
                                        $check113 = ($result_seTenkobefore['TENKOLOADINFORMCHECK'] == '1') ? "checked" : "";
                                        $check114 = ($result_seTenkobefore['TENKOAIRINFORMCHECK'] == '1') ? "checked" : "";
                                        $check115 = ($result_seTenkobefore['TENKOYOKOTENCHECK'] == '1') ? "checked" : "";
                                        $check116 = ($result_seTenkobefore['TENKOCHIMOLATORCHECK'] == '1') ? "checked" : "";
                                        $check117 = ($result_seTenkobefore['TENKOTRANSPORTCHECK'] == '1') ? "checked" : "";
                                        $check118 = ($result_seTenkobefore['TENKOAFTERGREETCHECK'] == '1') ? "checked" : "";
                                        $check119 = ($result_seTenkobefore['TENKOOXYGENCHECK'] == '1') ? "checked" : "";
                                        
                                        //เช็คค่าสายตาพนักงานคนที่1
                                        $checkshortsight = ($result_seTenkobefore['TENKOSHORTSIGHTCHECK'] == '1') ? "checked" : "";
                                        $checklongsight = ($result_seTenkobefore['TENKOLONGSIGHTCHECK'] == '1') ? "checked" : "";    
                                        $checkobliquesight =($result_seTenkobefore['TENKOOBLIQUESIGHTCHECK'] == '1') ? "checked" : ""; 
                                        //เช็คปกติ
                                        $rsshortsightok = ($result_seTenkobefore['TENKOSHORTSIGHTRESULT'] == '1') ? "checked" : "";
                                        $rslongsightok = ($result_seTenkobefore['TENKOLONGSIGHTRESULT'] == '1') ? "checked" : "";
                                        $rsobliquesightok = ($result_seTenkobefore['TENKOOBLIQUESIGHTRESULT'] == '1') ? "checked" : "";        
                                        //เช็คไม่ปกติ
                                        $rsshortsightng = ($result_seTenkobefore['TENKOSHORTSIGHTRESULT'] == '0' || $result_seTenkobefore['TENKOSHORTSIGHTRESULT'] == '') ? "checked" : "";
                                        $rslongsightng = ($result_seTenkobefore['TENKOLONGSIGHTRESULT'] == '0' || $result_seTenkobefore['TENKOLONGSIGHTRESULT'] == '') ? "checked" : "";
                                        $rsobliquesightng = ($result_seTenkobefore['TENKOOBLIQUESIGHTRESULT'] == '0' || $result_seTenkobefore['TENKOOBLIQUESIGHTRESULT'] == '') ? "checked" : "";   



                                        $rs111 = ($result_seTenkobefore['TENKOBEFOREGREETRESULT'] == '1') ? "checked" : "";
                                        $rs121 = ($result_seTenkobefore['TENKOUNIFORMRESULT'] == '1') ? "checked" : "";
                                        $rs131 = ($result_seTenkobefore['TENKOBODYRESULT'] == '1') ? "checked" : "";

                                        $rs151 = ($result_seTenkobefore['TENKOSLEEPTIMERESULT'] == '1') ? "checked" : "";
                                        $rs161 = ($result_seTenkobefore['TENKOTEMPERATURERESULT'] == '1') ? "checked" : "";
                                        $rs171 = ($result_seTenkobefore['TENKOPRESSURERESULT'] == '1') ? "checked" : "";
                                        $rs181 = ($result_seTenkobefore['TENKOALCOHOLRESULT'] == '1') ? "checked" : "";
                                        $rs191 = ($result_seTenkobefore['TENKOWORRYRESULT'] == '1') ? "checked" : "";
                                        $rs1101 = ($result_seTenkobefore['TENKODAILYTRAILERRESULT'] == '1') ? "checked" : "";
                                        $rs1111 = ($result_seTenkobefore['TENKOCARRYRESULT'] == '1') ? "checked" : "";
                                        $rs1121 = ($result_seTenkobefore['TENKOJOBDETAILRESULT'] == '1') ? "checked" : "";
                                        $rs1131 = ($result_seTenkobefore['TENKOLOADINFORMRESULT'] == '1') ? "checked" : "";
                                        $rs1141 = ($result_seTenkobefore['TENKOAIRINFORMRESULT'] == '1') ? "checked" : "";
                                        $rs1151 = ($result_seTenkobefore['TENKOYOKOTENRESULT'] == '1') ? "checked" : "";
                                        $rs1161 = ($result_seTenkobefore['TENKOCHIMOLATORRESULT'] == '1') ? "checked" : "";
                                        $rs1171 = ($result_seTenkobefore['TENKOTRANSPORTRESULT'] == '1') ? "checked" : "";
                                        $rs1181 = ($result_seTenkobefore['TENKOAFTERGREETRESULT'] == '1') ? "checked" : "";
                                        $rs1191 = ($result_seTenkobefore['TENKOOXYGENRESULT'] == '1') ? "checked" : "";

                                        $rs110 = ($result_seTenkobefore['TENKOBEFOREGREETRESULT'] == '0' || $result_seTenkobefore['TENKOBEFOREGREETRESULT'] == '') ? "checked" : "";
                                        $rs120 = ($result_seTenkobefore['TENKOUNIFORMRESULT'] == '0' || $result_seTenkobefore['TENKOUNIFORMRESULT'] == '') ? "checked" : "";
                                        $rs130 = ($result_seTenkobefore['TENKOBODYRESULT'] == '0' || $result_seTenkobefore['TENKOBODYRESULT'] == '') ? "checked" : "";


                                        $rs150 = ($result_seTenkobefore['TENKOSLEEPTIMERESULT'] == '0' || $result_seTenkobefore['TENKOSLEEPTIMERESULT'] == '') ? "checked" : "";
                                        $rs160 = ($result_seTenkobefore['TENKOTEMPERATURERESULT'] == '0' || $result_seTenkobefore['TENKOTEMPERATURERESULT'] == '') ? "checked" : "";
                                        $rs170 = ($result_seTenkobefore['TENKOPRESSURERESULT'] == '0' || $result_seTenkobefore['TENKOPRESSURERESULT'] == '') ? "checked" : "";
                                        $rs180 = ($result_seTenkobefore['TENKOALCOHOLRESULT'] == '0' || $result_seTenkobefore['TENKOALCOHOLRESULT'] == '') ? "checked" : "";
                                        $rs190 = ($result_seTenkobefore['TENKOWORRYRESULT'] == '0' || $result_seTenkobefore['TENKOWORRYRESULT'] == '') ? "checked" : "";
                                        $rs1100 = ($result_seTenkobefore['TENKODAILYTRAILERRESULT'] == '0' || $result_seTenkobefore['TENKODAILYTRAILERRESULT'] == '') ? "checked" : "";
                                        $rs1110 = ($result_seTenkobefore['TENKOCARRYRESULT'] == '0' || $result_seTenkobefore['TENKOCARRYRESULT'] == '') ? "checked" : "";
                                        $rs1120 = ($result_seTenkobefore['TENKOJOBDETAILRESULT'] == '0' || $result_seTenkobefore['TENKOJOBDETAILRESULT'] == '') ? "checked" : "";
                                        $rs1130 = ($result_seTenkobefore['TENKOLOADINFORMRESULT'] == '0' || $result_seTenkobefore['TENKOLOADINFORMRESULT'] == '') ? "checked" : "";
                                        $rs1140 = ($result_seTenkobefore['TENKOAIRINFORMRESULT'] == '0' || $result_seTenkobefore['TENKOAIRINFORMRESULT'] == '') ? "checked" : "";
                                        $rs1150 = ($result_seTenkobefore['TENKOYOKOTENRESULT'] == '0' || $result_seTenkobefore['TENKOYOKOTENRESULT'] == '') ? "checked" : "";
                                        $rs1160 = ($result_seTenkobefore['TENKOCHIMOLATORRESULT'] == '0' || $result_seTenkobefore['TENKOCHIMOLATORRESULT'] == '') ? "checked" : "";
                                        $rs1170 = ($result_seTenkobefore['TENKOTRANSPORTRESULT'] == '0' || $result_seTenkobefore['TENKOTRANSPORTRESULT'] == '') ? "checked" : "";
                                        $rs1180 = ($result_seTenkobefore['TENKOAFTERGREETRESULT'] == '0' || $result_seTenkobefore['TENKOAFTERGREETRESULT'] == '') ? "checked" : "";
                                        $rs1190 = ($result_seTenkobefore['TENKOOXYGENRESULT'] == '0' || $result_seTenkobefore['TENKOOXYGENRESULT'] == '') ? "checked" : "";
                                        ?>
                                        <!-- ใบขับขี่และ Self Check พขร1 -->
                                        
                                            
                                     
                                            
                                       
                                        <table style="border: 1px solid black;border-collapse: collapse;">
                                            <tr>
                                                <th colspan = "25" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: left"><font style="color: black;font-size: 20px;">พนักงานขับรถ : <?=$sex?>  <?= $result_sePlain['EMPLOYEENAME1'] ?></font></th>
                                            </tr>
                                            <tr>
                                                <th colspan = "4" rowspan="4" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: center"><img  style="padding:4px;text-align:center;height: 200px;width: 200px;" src="../images/employee/<?=$_GET['employeecode1']?>.JPG" data-action="zoom" alt="Pic_Driver1" ></th>
                                                <th colspan = "6" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: center">ตรวจสอบปัญหาสายตา<font style="color:#ff0808"> *ตัวหนังสือมีสีแดง หมายถึงมีปัญหาสายตา เจ้าหน้าที่ต้องเน้นย้ำ และตรวจสอบแว่นสายตาของพนักงาน </font></th>
                                                <th colspan = "8" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: center">ข้อมูลวันหมดอายุใบขับขี่ พขร.1</th> 
                                                <th colspan = "4" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: center">ตรวจสอบ พขร.1</th>
                                                <th colspan = "4" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: center">เอกสารเท็งโก๊ะ พขร.1</th>  
                                            </tr>
                                            <tr>
                                                <!-- สายตาสั้น -->
                                                <?php
                                                if ($result_sehealth['SHORTSIGHT'] == '1') {
                                                   ?>
                                                      <th colspan = "2" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center;color:red">สายตาสั้น</th>   
                                                   <?php
                                                }else{
                                                    ?>
                                                        <th colspan = "2" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center">สายตาสั้น</th> 
                                                    <?php
                                                }
                                                ?>
                                                <!-- สายตายาว -->
                                               <?php
                                                if ($result_sehealth['LONGSIGHT'] == '1') {
                                                   ?>
                                                      <th colspan = "2" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center;color:red">สายตายาว</th>   
                                                   <?php
                                                }else{
                                                    ?>
                                                        <th colspan = "2" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center">สายตายาว</th> 
                                                    <?php
                                                }
                                                ?>
                                                <!-- สายตาเอียง -->
                                                    <?php
                                                if ($result_sehealth['OBLIQUESIGHT'] == '1') {
                                                   ?>
                                                      <th colspan = "2" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center;color:red">สายตาเอียง</th>   
                                                   <?php
                                                }else{
                                                    ?>
                                                        <th colspan = "2" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center">สายตาเอียง</th> 
                                                    <?php
                                                }
                                                ?>
                                                    <th colspan = "4" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: left">เลขที่ใบขับขี่</th>
                                                    <th colspan = "4" style="width:160px;border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left"><?=$result_seCarData1['CarLicenceID']?></th>
                                                    <?php
                                                    if ($result_seSelfCheck1['SELFCHECKID'] == '') {
                                                    ?>
                                                        <th colspan = "4" style="width:160px;border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left"><input type="button" onclick="function warning(){alert('ไม่สามารถดูข้อมูลได้เนื่องจากพนักงานยังไม่ได้ทำการแจ้งสุขภาพตนเอง!!!')};warning();" name="btnSend" id="btnSend" value="ดูข้อมูลการ Self Check" class="btn btn-primary"></th>
                                                    <?php
                                                    }else {
                                                    ?>
                                                        <th colspan = "4" style="width:160px;border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left"><input type="button" onclick="se_selfcheck('<?=$result_seSelfCheck1['SELFCHECKID']?>','<?= $result_seEmployee2['nameT'] ?>','<?= $_GET['employeecode1'] ?>','<?=$dateself1?>','<?=$result_seDateSelfCheck1['DATERK'] ?>','<?=$result_seDateSelfCheck1['DATEPRESENT'] ?>','<?= $result_seEmployee['nameT']?>');" name="btnSend" id="btnSend" value="ดูข้อมูลการ Self Check" class="btn btn-primary"></th>
                                                    <?php
                                                    }
                                                    ?>
                                                    
                                                    <?php
                                                    $emp = ($_GET['employeecode1'] != "") ? $_GET['employeecode1'] : $_GET['employeecode2'];
                                                    if ($emp != "") {
                                                        ?>


                                                        <div class="col-lg-10 text-right">

                                                        <th colspan = "4" style="width:160px;background-color: coral;border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left"><a href="pdf_reportemployee4_1.php?employeecode=<?= $emp ?>&tenkomasterid=<?= $result_seTenkomaster_temp['TENKOMASTERID'] ?>&vehicletransportplanid=<?= $_GET['vehicletransportplanid'] ?>&selfcheckid=<?= $result_seSelfCheck1['SELFCHECKID'] ?>"  target ="_blank" class="btn btn-default">พิมพ์เอกสารเท็งโกะ พขร.1<li class="fa fa-print"></li></a></th> 
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;border-collapse: collapse;background-color: #c9c9c9;text-align: center;padding: 5px">R(ข้างขวา)</td>
                                                <td style="border: 1px solid black;border-collapse: collapse;background-color: #c9c9c9;text-align: center;padding: 5px">L(ข้างซ้าย)</td>
                                                <td style="border: 1px solid black;border-collapse: collapse;background-color: #c9c9c9;text-align: center;padding: 5px">R(ข้างขวา)</td>
                                                <td style="border: 1px solid black;border-collapse: collapse;background-color: #c9c9c9;text-align: center;padding: 5px">L(ข้างซ้าย)</td>
                                                <td style="border: 1px solid black;border-collapse: collapse;background-color: #c9c9c9;text-align: center;padding: 5px">R(ข้างขวา)</td>
                                                <td style="border: 1px solid black;border-collapse: collapse;background-color: #c9c9c9;text-align: center;padding: 5px">L(ข้างซ้าย)</td>
                                                 <!--ใบขับขี่  -->
                                                <td colspan = "4" style="border: 1px solid black;border-collapse: collapse;background-color: #c9c9c9;text-align: left;padding: 5px"><b>วันออกบัตร</b></td>
                                                
                                                <td colspan = "4" style="border: 1px solid black;border-collapse: collapse;text-align: left;padding: 5px" ><b><?=$year11start?><?=$year12start?></b></td>
                                                <td colspan = "4" style="border: 1px solid black;border-collapse: collapse;text-align: left;padding: 5px"><b>SelfCheckID: <?=$result_seSelfCheck1['SELFCHECKID']?></b></td>
                                                
                                                <!-- เอกสาร Tenko -->
                                                <td colspan = "4" style="border: 1px solid black;border-collapse: collapse;text-align: center;padding: 5px"><button type="button" class="btn btn-primary btn-md" name="myBtn" id ="myBtn" data-toggle="modal" data-target="#myModalinsert">ข้อมูล Simulator พขร.1</button></td>
                                                
                                            </tr>
                                            <tr>
                                          
                                                <td style="border: 1px solid black;border-collapse: collapse;text-align: center;padding: 5px"><?=$result_sehealth['SHORTSIGHT_R']?></td>
                                                <td style="border: 1px solid black;border-collapse: collapse;text-align: center;padding: 5px"><?=$result_sehealth['SHORTSIGHT_L']?></td>
                                                <td style="border: 1px solid black;border-collapse: collapse;text-align: center;padding: 5px"><?=$result_sehealth['LONGSIGHT_R']?></td>
                                                <td style="border: 1px solid black;border-collapse: collapse;text-align: center;padding: 5px"><?=$result_sehealth['LONGSIGHT_L']?></td>
                                                <td style="border: 1px solid black;border-collapse: collapse;text-align: center;padding: 5px"><?=$result_sehealth['OBLIQUESIGHT_R']?></td>
                                                <td style="border: 1px solid black;border-collapse: collapse;text-align: center;padding: 5px"><?=$result_sehealth['OBLIQUESIGHT_L']?></td>
                                                <!--ใบขับขี่  -->
                                                <td colspan = "4" style="border: 1px solid black;border-collapse: collapse;background-color: #c9c9c9;text-align: left;padding: 5px"><b>วันหมดอายุ</b></td>
                                                <td colspan = "4" style="border: 1px solid black;border-collapse: collapse;text-align: left;padding: 5px;<?= $licensechk1?>"><b><?=$year11end?><?=$year12end?></b></td>
                                                <!-- <td colspan = "4" style="border: 1px solid black;border-collapse: collapse;text-align: left;padding: 5px;<?= $licensechk1?>"   onclick="inserttimeworkingdata('<?=$_GET['employeecode1']?>','<?= $result_sePlain['EMPLOYEENAME1'] ?>','<?=$result_seSelfCheck1['SELFCHECKID']?>')"><b><?=$year11end?><?=$year12end?></b></td> -->
                                                <!-- กราฟสุขภาพ -->
                                                
                                                <td colspan = "4" style="border: 1px solid black;border-collapse: collapse;text-align: left;padding: 5px"><b><input style="width:160px;" type="button" onclick="se_graphdatacheck('<?= $_GET['employeecode1'] ?>');" name="btnSend" id="btnSend" value="ดูกราฟข้อมูลสุขภาพ" class="btn btn-primary"></b></td>
                                                <!-- เอกสารเท็งโกะ -->
                                                <td colspan = "4" style="border: 1px solid black;border-collapse: collapse;text-align: center;padding: 5px"><button type="button" class="btn btn-primary btn-md" name="myBtn" id ="myBtn" data-toggle="modal" data-target="#myModalFeedback">ข้อมูล Feedback พขร.1</button></td>
                                                    
                                            </tr>
                                            
                                            
                                            
                                            

                                        </table>     
                                                    
                                        <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                            <thead>
                                            
                                                <tr>


                                                    <th  colspan="7" ><input type="button" onclick="commit_1('<?=$result_seSelfCheck1['SELFCHECKID']?>')" class="btn btn-success" value="Commit1_Before"> </th>
                                                    

                                                    <th width="65">เจ้าหน้าที่</th>
                                                    <th width="144" ><?= $result_seEmployee["nameT"] ?></th>
                                                    <th width="40">พขร.</th>
                                                    <th width="144" ><?= $result_sePlain['EMPLOYEENAME1'] ?></th>
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
                                                    <td>การทักทายก่อนเริ่มเท็งโกะ</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check11 ?>  id="chk_11" name="chk_11"  style="transform: scale(2)"/></td>
                                                    <td colspan="2" >ทักทายอย่างมีชีวิตชีวา</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs111 ?> style="transform: scale(2)" id="chk_rs111" name="chk_rs111" onchange="edit_rs111()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs110 ?> style="transform: scale(2)" id="chk_rs110" name="chk_rs110" onchange="edit_rs110()"/></td>
                                                    <td colspan="4" ><input type="text" id="txt_remark11" name="txt_remark11" class="form-control" value="<?= $result_seTenkobefore['TENKOBEFOREGREETREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">2</td>
                                                    <td>ตรวจเซ็คยูนิฟอร์ม</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check12 ?> id="chk_12" name="chk_12"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">สวมชุดที่สะอาด ไม่ใส่เครื่องประดับที่อาจทำให้เกิดรอย</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs121 ?> style="transform: scale(2)" id="chk_rs121" name="chk_rs121" onchange="edit_rs121()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs120 ?> style="transform: scale(2)" id="chk_rs120" name="chk_rs120" onchange="edit_rs120()"/></td>
                                                    <td colspan="4"  ><input type="text" id="txt_remark12" name="txt_remark12" class="form-control" value="<?= $result_seTenkobefore['TENKOUNIFORMREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">3</td>
                                                    <td>ตรวจสอบสภาพร่างกาย</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check13 ?> id="chk_13" name="chk_13"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">สุขภาพร่างกายแข็งแรงดี</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs131 ?> style="transform: scale(2)" id="chk_rs131" name="chk_rs131" onchange="edit_rs131()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs130 ?> style="transform: scale(2)" id="chk_rs130" name="chk_rs130" onchange="edit_rs130()"/></td>
                                                    <td colspan="4"  ><input type="text" id="txt_remark13" name="txt_remark13" class="form-control" value="<?= $result_seTenkobefore['TENKOBODYREMARK'] ?>"></td>
                                                </tr>

                                                <tr>
                                                    <!-- ตรวจสอบระยะการพักผ่อนคนที่1 -->
                                                    <td style="text-align: center">4</td>
                                                    <td>ตรวจสอบระยะการพักผ่อน</td>
                                                    <!-- <td style="text-align: center"><input type="checkbox"  <?= $check14 ?> id="chk_14" name="chk_14"  style="transform: scale(2)"/></td> -->
                                                    <?php
                                                    if ($TIMESLEEPREST1 == '0') {
                                                    ?>
                                                    <td style="text-align: center"><input type="checkbox" disabled=""  id="chk_14" name="chk_14"  style="transform: scale(2)"/></td>    
                                                    <?php
                                                    }else {
                                                    ?>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" checked  id="chk_14" name="chk_14"  style="transform: scale(2)"/></td>
                                                    <?php
                                                    }
                                                    ?>

                                                    <td>ตั้งแต่ 8 ชั่วโมง <b>พขร.1</b></td>
                                                    <td>
                                                        <label>ชั่วโมงการพักผ่อน</label>
                                                        <?php
                                                        if ($TIMESLEEPREST1 == '0') {
                                                        ?>
                                                        <input type="text" readonly="" class="form-control"  id="txt_rs14" name="txt_rs14" value="" ></td>    
                                                        <?php
                                                        }else if ($TIMESLEEPREST1 >= '8') {
                                                        ?>
                                                        <input type="text" readonly="" style="background-color: #94FA67;" class="form-control"  id="txt_rs14" name="txt_rs14" value="<?= $result_seSelfCheck1['TIMESLEEPREST'] ?>" ></td>
                                                        <?php
                                                        }else {
                                                        ?>
                                                        <input type="text" readonly="" style="background-color: #FA6767;" class="form-control"  id="txt_rs14" name="txt_rs14" value="<?= $result_seSelfCheck1['TIMESLEEPREST'] ?>" ></td>
                                                        <?php
                                                        }
                                                        ?>
                                                        

                                                        <?php 
                                                        if (($result_seSelfCheck1['SLEEPRESTSTART'] == '' || $result_seSelfCheck1['SLEEPRESTSTART'] == '<br /><b>Warning</b>:  sqlsrv_fetch_array() expects parameter 1 to be resource, boolean given in <b>' || 
                                                            $result_seSelfCheck1['SLEEPRESTEND'] == ''   || $result_seSelfCheck1['SLEEPRESTEND'] == '<br /><b>Warning</b>:  sqlsrv_fetch_array() expects parameter 1 to be resource, boolean given in <b>') || ($TIMESLEEPREST1 <'8')  ) {
                                                        ?>
                                                        <td style="text-align: center"><input disabled="" type="checkbox"         style="transform: scale(2)" id="chk_rs141" name="chk_rs141" onchange="edit_rs141()"/></td>
                                                        <td style="text-align: center"><input disabled="" type="checkbox" checked style="transform: scale(2)" id="chk_rs140" name="chk_rs140" onchange="edit_rs140()"/></td>
                                                        <?php
                                                        }else {
                                                        ?>
                                                        <td style="text-align: center"><input disabled="" type="checkbox" checked style="transform: scale(2)" id="chk_rs141" name="chk_rs141" onchange="edit_rs141()"/></td>
                                                        <td style="text-align: center"><input disabled="" type="checkbox"         style="transform: scale(2)" id="chk_rs140" name="chk_rs140" onchange="edit_rs140()"/></td>
                                                        <?php
                                                        }
                                                        ?>
                                                     </td>   
                                                    <td colspan="2" >
                                                        <!-- พักผ่อน 8 ชั่วโมงคนที่1 -->
                                                        <label>เวลาเริ่มพักผ่อน(8 ชั่วโมง)</label>
                                                        <input disabled="" type="datetime-local" id="txt_remark14" name="txt_remark14" class="form-control" value="<?= $result_seSelfCheck1['SLEEPRESTSTART'] ?>" style="">
                                                        <!-- <input type="button"  data-toggle="modal"  data-target="#modal_tenkorestremark" id="btn_remark14" name="btn_remark14" class="btn btn-default" value="<?= $result_seTenkobefore['TENKORESTREMARK'] ?>"> -->
                                                    </td>
                                                    <td colspan="2" >
                                                        <!--  พักผ่อน 8 ชั่วโมงคนที่1 -->
                                                        <label>เวลาตื่นพักผ่อน(8 ชั่วโมง)</label>
                                                        <input disabled="" type="datetime-local" id="txt_remark14" name="txt_remark14" class="form-control" value="<?= $result_seSelfCheck1['SLEEPRESTEND'] ?>" style="">
                                                        <!-- <input type="button"  data-toggle="modal"  data-target="#modal_tenkorestremark" id="btn_remark14" name="btn_remark14" class="btn btn-default" value="<?= $result_seTenkobefore['TENKORESTREMARK'] ?>"> -->
                                                    </td>   
                                                </tr>
                                                <tr>    
                                                    <td rowspan="2" style="text-align: center">5</td>
                                                    <td rowspan="2">ตรวจสอบชั่วโมงการนอนหลับ</td>
                                                    <?php
                                                    if ($TIMESLEEPNORMAL1 == '0') {
                                                    ?>
                                                    <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox"  id="chk_15" name="chk_15"  style="transform: scale(2)"/></td>    
                                                    <?php
                                                    }else {
                                                    ?>
                                                    <td rowspan="2" style="text-align: center"><input disabled="" checked type="checkbox"  id="chk_15" name="chk_15"  style="transform: scale(2)"/></td>
                                                    <?php
                                                    }
                                                    ?>
                                                    <!-- <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox" <?= $check15 ?> id="chk_15" name="chk_15"  style="transform: scale(2)"/>15</td> -->
                                                    <td>การนอนปกติ ตั้งแต่ 6 ชั่วโมงขึ้นไป <b>พขร.1</b></td>
                                                    <!--<td><input type="text"
                                                               onKeyUp="if (isNaN(this.value)) {
                                                                           alert('กรุณากรอกตัวเลข');
                                                                           this.value = '0';
                                                                       } else {
                                                                           edit_tenkobeforetxt2(this.value, 'TENKOSLEEPTIMEDATA_AFTER6H', '<?//= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                       }"
                                                               class="form-control" id="txt_rs151" name="txt_rs151" value="<?//= $result_seTenkobefore['TENKOSLEEPTIMEDATA_AFTER6H'] ?>"></td>-->
                                                    <td>
                                                        <label>ชั่วโมงการนอน</label>
                                                        
                                                        <?php
                                                        if ($TIMESLEEPNORMAL1 == '0') {
                                                        ?>
                                                        <input readonly="" type="text" class="form-control" id="txt_rs151" name="txt_rs151" value=""></td>    
                                                        <?php
                                                        }else if ($TIMESLEEPNORMAL1 >= '6') {
                                                        ?>
                                                        <input readonly="" style="background-color: #94FA67;" type="text" class="form-control" id="txt_rs151" name="txt_rs151" value="<?= $result_seSelfCheck1['TIMESLEEPNORMAL'] ?>"></td>
                                                        <?php
                                                        }else {
                                                        ?>
                                                        <input readonly="" style="background-color: #FA6767;" type="text" class="form-control" id="txt_rs151" name="txt_rs151" value="<?= $result_seSelfCheck1['TIMESLEEPNORMAL'] ?>"></td>
                                                        <?php
                                                        }
                                                        ?>
                                                        
                                                        <?php 
                                                            if (($result_seSelfCheck1['SLEEPNORMALSTART'] == '' || $result_seSelfCheck1['SLEEPNORMALSTART'] == '<br /><b>Warning</b>:  sqlsrv_fetch_array() expects parameter 1 to be resource, boolean given in <b>' || 
                                                                $result_seSelfCheck1['SLEEPNORMALEND'] == ''   || $result_seSelfCheck1['SLEEPNORMALEND'] == '<br /><b>Warning</b>:  sqlsrv_fetch_array() expects parameter 1 to be resource, boolean given in <b>') || ($TIMESLEEPNORMAL1 <'6')   ) {
                                                            ?>
                                                            <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox"         style="transform: scale(2)" id="chk_rs151" name="chk_rs151" onchange="edit_rs151()"/></td>
                                                            <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox" checked style="transform: scale(2)" id="chk_rs150" name="chk_rs150" onchange="edit_rs150()"/></td>
                                                            <?php
                                                            }else {
                                                            ?>
                                                            <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox" checked style="transform: scale(2)" id="chk_rs151" name="chk_rs151" onchange="edit_rs151()"/></td>
                                                            <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox"         style="transform: scale(2)" id="chk_rs150" name="chk_rs150" onchange="edit_rs150()"/></td>
                                                            <?php
                                                            }
                                                            ?>
                                                    


                                                    
                                                    
                                                        <!--<td colspan="4" rowspan="2" contenteditable="true" onkeyup="edit_tenkobefore(this, 'TENKOSLEEPTIMEREMARK', '<?//= $result_seTenkobefore['TENKOBEFOREID'] ?>')"><?//= $result_seTenkobefore['TENKOSLEEPTIMEREMARK'] ?></td>-->
                                                    
                                                        <td colspan="2" rowspan="2">
                                                            <!-- นอน 6 ชั่วโมงคนที่1 -->
                                                            <label>เวลาเริ่มนอน(6 ชั่วโมง)</label>
                                                            <input disabled="" type="datetime-local" id="txt_remark15" name="txt_remark15" class="form-control" value="<?= $result_seSelfCheck1['SLEEPNORMALSTART'] ?>" style="">
                                                            <!-- <input type="button"  data-toggle="modal"  data-target="#modal_tenkosleeptimeremark" id="btn_remark15" name="btn_remark15" class="btn btn-default" value="<?= $result_seTenkobefore['TENKOSLEEPTIMEREMARK'] ?>"> -->
                                                            <!-- นอน 4 ชั่วโมงครึ่งคนที่1 -->
                                                            <label>เวลาเริ่มนอนเพิ่ม(4 ชั่วโมงครึ่ง)</label>
                                                            <input disabled="" type="datetime-local" id="txt_remark15" name="txt_remark15" class="form-control" value="<?= $result_seSelfCheck1['SLEEPEXTRASTART'] ?>" style="">
                                                        </td>
                                                        <td colspan="2"rowspan="2">
                                                            <!-- นอน 6 ชั่วโมงคนที่1 -->
                                                            <label>เวลาตื่นนอน(6 ชั่วโมง)</label>
                                                            <input disabled="" type="datetime-local" id="txt_remark15" name="txt_remark15" class="form-control" value="<?= $result_seSelfCheck1['SLEEPNORMALEND'] ?>" style="">
                                                            <!-- <input type="button"  data-toggle="modal"  data-target="#modal_tenkosleeptimeremark" id="btn_remark15" name="btn_remark15" class="btn btn-default" value="<?= $result_seTenkobefore['TENKOSLEEPTIMEREMARK'] ?>"> -->
                                                            <!-- นอน 4 ชั่วโมงครึ่งคนที่1 -->
                                                            <label>เวลาตื่นนอน(4 ชั่วโมงครึ่ง)</label>
                                                            <input disabled="" type="datetime-local" id="txt_remark15" name="txt_remark15" class="form-control" value="<?= $result_seSelfCheck1['SLEEPEXTRAEND'] ?>" style="">
                                                         </td> 
                                                           
                                                     </td>        
                                                </tr>


                                                <tr>
                                                    <td>การนอนเพิ่ม (กะกลางคืน) ตั้งแต่ 4.5 ชั่วโมงขึ้นไป <b>พขร.1</b></td>

                                                    <!-- <td><input type="text" class="form-control" id="txt_rs152" name="txt_rs152"
                                                               onKeyUp="if (isNaN(this.value)) {
                                                                           alert('กรุณากรอกตัวเลข');
                                                                           this.value = '0';
                                                                       } else {
                                                                           edit_tenkobeforetxt3()
                                                                       }"
                                                               value="<?= $result_seTenkobefore['TENKOSLEEPTIMEDATA_ADD45H'] ?>"></td> -->
                                                               
                                                    <td>
                                                        <?php
                                                        //echo $result_seSelfCheck['TIMESLEEPEXTRA']; 
                                                        if ($TIMESLEEPEXTRAHOURCHK1 == '0') {
                                                            // echo '1';
                                                        ?>
                                                            <input readonly  type="text" class="form-control" id="txt_rs152" name="txt_rs152". value= "" autocomplete="off">
                                                        <?php
                                                        }else if ($TIMESLEEPEXTRAHOURCHK1 == 'HG4') { //เช็คชั่วโมง ต้องมากกว่า 4 ชั่วโมง กรณีเท่ากับ 4 
                                                            // echo '2';
                                                            if ($TIMESLEEPEXTRAMINCHK1 == 'MG3') { //เช็คชนาที ต้องมากกว่า 30 นาที กรณีเท่ากับ 4เช็ค นาทีต่อ
                                                            ?>
                                                            <input readonly style="background-color: #94FA67;" type="text" class="form-control" id="txt_rs152" name="txt_rs152" value="<?= $result_seSelfCheck1['TIMESLEEPEXTRA'] ?>">
                                                            
                                                            <?php
                                                            }else {
                                                            ?>
                                                            <input readonly style="background-color: #FA6767;" type="text" class="form-control" id="txt_rs152" name="txt_rs152"value="<?= $result_seSelfCheck1['TIMESLEEPEXTRA'] ?>">
                                                            
                                                            <?php
                                                            }
                                                        ?>
                                                            
                                                        <?php
                                                        }else if ($TIMESLEEPEXTRAHOURCHK1 == 'HGG4') { //เช็คชั่วโมง ต้องมากกว่า 4 ชั่วโมง
                                                            // echo '3';
                                                        ?>
                                                            <input readonly style="background-color: #94FA67;" type="text" class="form-control" id="txt_rs152" name="txt_rs152"value="<?= $result_seSelfCheck1['TIMESLEEPEXTRA'] ?>">
                                                            
                                                        <?php
                                                        }else {
                                                            // echo '4';
                                                        ?>
                                                            <input readonly style="background-color: #FA6767;" type="text" class="form-control" id="txt_rs152" name="txt_rs152"value="<?= $result_seSelfCheck1['TIMESLEEPEXTRA'] ?>">
                                                        <?php
                                                        }
                                                        ?>
                                                    
                                                    </td>
                                                    
                                                </tr>
                                                <tr>
                                                
                                                </tr>


                                                <?php
                                                if ($result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKL' || $result_sePlain['COMPANYCODE'] == 'RRC' || $result_sePlain['COMPANYCODE'] == 'RCC' || $result_sePlain['COMPANYCODE'] == 'RATC') {
                                                    ?>
                                                    <tr>
                                                        <td style="text-align: center">6</td>
                                                        <td>ตรวจเช็คอุณหภูมิ1</td>
                                                        <td style="text-align: center"><input disabled="" type="checkbox" id="chk_16" <?= $check16 ?> name="chk_16"  style="transform: scale(2)"/></td>
                                                        <td>ต่ำกว่า 37 องศา</td>
                                                        <td><input type="text" class="form-control" id="txt_rs16" name="txt_rs16" value="<?= $result_seTenkobefore['TENKOTEMPERATUREDATA'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '0';
                                                                           } else {
                                                                               edit_tenkobeforetxt4(this.value, 'TENKOTEMPERATUREDATA', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                               update_selfcheck(this.value, 'TEMPERATURE', '<?= $result_seSelfCheck1['SELFCHECKID'] ?>')
                                                                           }"
                                                                    
                                                                   ></td>
                                                        <td style="text-align: center"><input disabled="" type="checkbox" <?= $rs161 ?> style="transform: scale(2)" id="chk_rs161" name="chk_rs161" onchange="edit_rs161()"/></td>
                                                        <td style="text-align: center"><input disabled="" type="checkbox" <?= $rs160 ?> style="transform: scale(2)" id="chk_rs160" name="chk_rs160" onchange="edit_rs160()"/></td>
                                                        <td colspan="4"  ><input type="text" id="txt_remark16" name="txt_remark16" class="form-control" value="<?= $result_seTenkobefore['TENKOTEMPERATUREREMARK'] ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="3" style="text-align: center">7</td>
                                                        <td rowspan="3">วัดความดัน</td>
                                                        <td rowspan="3" style="text-align: center"><input disabled="" type="checkbox" <?= $check17 ?> id="chk_17" name="chk_17"  style="transform: scale(2)"/></td>
                                                        <td>บน : 90-150</td>
                                                        <td><input type="text" class="form-control" id="txt_rs171" name="txt_rs171" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_90160'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt5()
                                                                               update_selfcheck(this.value, 'SYSVALUE1', '<?= $result_seSelfCheck1['SELFCHECKID'] ?>')
                                                                           }"
                                                                   ><input type="text" class="form-control" id="txt_rs171_2" name="txt_rs171_2" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_90160_2'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt5_2(this.value, 'TENKOPRESSUREDATA_90160_2', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                               update_selfcheck(this.value, 'SYSVALUE2', '<?= $result_seSelfCheck1['SELFCHECKID'] ?>')
                                                                           }"
                                                                   ><input type="text" class="form-control" id="txt_rs171_3" name="txt_rs171_3" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_90160_3'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt5_3(this.value, 'TENKOPRESSUREDATA_90160_3', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                               update_selfcheck(this.value, 'SYSVALUE3', '<?= $result_seSelfCheck1['SELFCHECKID'] ?>')
                                                                           }"
                                                                   ></td>
                                                        <td rowspan="3" style="text-align: center"><input disabled="" type="checkbox" <?= $rs171 ?> style="transform: scale(2)" id="chk_rs171" name="chk_rs171" onchange="edit_rs171()"/></td>
                                                        <td rowspan="3" style="text-align: center"><input disabled="" type="checkbox" <?= $rs170 ?> style="transform: scale(2)" id="chk_rs170" name="chk_rs170" onchange="edit_rs170()"/></td>
                                                        <td colspan="4" rowspan="2" ><input type="text" id="txt_remark17" name="txt_remark17" class="form-control" value="<?= $result_seTenkobefore['TENKOPRESSUREREMARK'] ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>ล่าง : 60-95</td>
                                                        <td><input type="text" class="form-control" id="txt_rs172" name="txt_rs172" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60100'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt6()
                                                                               update_selfcheck(this.value, 'DIAVALUE1', '<?= $result_seSelfCheck1['SELFCHECKID'] ?>')
                                                                           }"
                                                                   ><input type="text" class="form-control" id="txt_rs172_2" name="txt_rs172_2" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60100_2'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt6_2()
                                                                               update_selfcheck(this.value, 'DIAVALUE2', '<?= $result_seSelfCheck1['SELFCHECKID'] ?>')
                                                                           }"
                                                                   ><input type="text" class="form-control" id="txt_rs172_3" name="txt_rs172_3" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60100_3'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt6_3()
                                                                               update_selfcheck(this.value, 'DIAVALUE3', '<?= $result_seSelfCheck1['SELFCHECKID'] ?>')
                                                                           }"
                                                                   ></td>

                                                    </tr>
                                                    <tr>
                                                    <!-- พขรคนที่1 -->
                                                        <td>อัตราการเต้นหัวใจ : 60-100 ครั้ง</td>
                                                        <td><input type="text" class="form-control" id="txt_rs173" name="txt_rs173" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60110'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt20()
                                                                               update_selfcheck(this.value, 'PULSEVALUE1', '<?= $result_seSelfCheck1['SELFCHECKID'] ?>')
                                                                           }"
                                                                   ><input type="text" class="form-control" id="txt_rs173_2" name="txt_rs173_2" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60110_2'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt20_2()
                                                                               update_selfcheck(this.value, 'PULSEVALUE2', '<?= $result_seSelfCheck1['SELFCHECKID'] ?>')
                                                                           }"
                                                                   ><input type="text" class="form-control" id="txt_rs173_3" name="txt_rs173_3" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60110_3'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt20_3()
                                                                               update_selfcheck(this.value, 'PULSEVALUE3', '<?= $result_seSelfCheck1['SELFCHECKID'] ?>')
                                                                           }"
                                                                   ></td>

                                                    </tr>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <!-- <tr>
                                                        <td style="text-align: center">6</td>
                                                        <td>ตรวจเช็คอุณหภูมิ</td>
                                                        <td style="text-align: center"><input disabled="" type="checkbox" id="chk_16" <?= $check16 ?> name="chk_16"  style="transform: scale(2)"/></td>
                                                        <td>ต่ำกว่า 37 องศา</td>
                                                        <td><input type="text" class="form-control" id="txt_rs16" name="txt_rs16" value="<?= $result_seTenkobefore['TENKOTEMPERATUREDATA'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '0';
                                                                           } else {
                                                                               edit_tenkobeforetxt4(this.value, 'TENKOTEMPERATUREDATA', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                           }"
                                                                   ></td>
                                                        <td style="text-align: center"><input disabled="" type="checkbox" <?= $rs161 ?> style="transform: scale(2)" id="chk_rs161" name="chk_rs161" onchange="edit_rs161()"/></td>
                                                        <td style="text-align: center"><input disabled="" type="checkbox" <?= $rs160 ?> style="transform: scale(2)" id="chk_rs160" name="chk_rs160" onchange="edit_rs160()"/></td>
                                                        <td colspan="4" ><input type="text" id="txt_remark16" name="txt_remark16" class="form-control" value="<?= $result_seTenkobefore['TENKOTEMPERATUREREMARK'] ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" style="text-align: center">7</td>
                                                        <td rowspan="2">วัดความดัน</td>
                                                        <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox" <?= $check17 ?> id="chk_17" name="chk_17" style="transform: scale(2)"/></td>
                                                        <td>บน : 90-150</td>
                                                        <td><input type="text" class="form-control" id="txt_rs171" name="txt_rs171" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_90160'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt5(this.value, 'TENKOPRESSUREDATA_90160', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                           }"
                                                                   ><input type="text" class="form-control" id="txt_rs171_2" name="txt_rs171_2" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_90160_2'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt5_2(this.value, 'TENKOPRESSUREDATA_90160_2', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                           }"
                                                                   ><input type="text" class="form-control" id="txt_rs171_3" name="txt_rs171_3" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_90160_3'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt5_3(this.value, 'TENKOPRESSUREDATA_90160_3', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                           }"
                                                                   ></td>
                                                        <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox" <?= $rs171 ?> style="transform: scale(2)" id="chk_rs171" name="chk_rs171" onchange="edit_rs171()"/></td>
                                                        <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox" <?= $rs170 ?> style="transform: scale(2)" id="chk_rs170" name="chk_rs170" onchange="edit_rs170()"/></td>
                                                        <td colspan="4" rowspan="2" onkeyup="edit_tenkobefore(this, 'TENKOPRESSUREREMARK', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')"><input type="text" id="txt_remark17" name="txt_remark17" class="form-control" value="<?= $result_seTenkobefore['TENKOPRESSUREREMARK'] ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>ล่าง : 60-95</td>
                                                        <td><input type="text" class="form-control" id="txt_rs172" name="txt_rs172" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60100'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt6(this.value, 'TENKOPRESSUREDATA_60100', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                           }"
                                                                   ><input type="text" class="form-control" id="txt_rs172_2" name="txt_rs172_2" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60100_2'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt6_2(this.value, 'TENKOPRESSUREDATA_60100_2', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                           }"
                                                                   ><input type="text" class="form-control" id="txt_rs172_3" name="txt_rs172_3" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60100_3'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt6_3(this.value, 'TENKOPRESSUREDATA_60100_3', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                           }"
                                                                   >
                                                            <input type="text" style="display: none" id="txt_rs173" name="txt_rs173">
                                                            <input type="text" style="display: none" id="txt_rs173_2" name="txt_rs173">
                                                            <input type="text" style="display: none" id="txt_rs173_3" name="txt_rs173">
                                                        </td>

                                                    </tr> -->

                                                    <?php
                                                }
                                                ?>
                                                <tr>
                                                    <td style="text-align: center">8</td>
                                                    <td>ตรวจเช็คแอลกอฮอล์</td>
                                                    <td style="text-align: center"><input disabled="" type="checkbox" id="chk_18" <?= $check18 ?> name="chk_18"  style="transform: scale(2)"/></td>
                                                    <td>[0]</td>
                                                    <td><input type="text" class="form-control" id="txt_rs18" name="txt_rs18" value="<?= $result_seTenkobefore['TENKOALCOHOLDATA'] ?>"
                                                               onKeyUp="if (isNaN(this.value)) {
                                                                           alert('กรุณากรอกตัวเลข');
                                                                           this.value = '0';
                                                                       } else {
                                                                           edit_tenkobeforetxt7(this.value, 'TENKOALCOHOLDATA', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                       }"
                                                               ></td>

                                                    <td style="text-align: center"><input disabled="" type="checkbox" <?= $rs181 ?> style="transform: scale(2)" id="chk_rs181" name="chk_rs181" onchange="edit_rs181()"/></td>
                                                    <td style="text-align: center"><input disabled="" type="checkbox" <?= $rs180 ?> style="transform: scale(2)" id="chk_rs180" name="chk_rs180" onchange="edit_rs180()"/></td>
                                                    <td colspan="4"   ><input type="text" id="txt_remark18" name="txt_remark18" class="form-control" value="<?= $result_seTenkobefore['TENKOALCOHOLREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">9</td>
                                                    <td>สอบถามเรื่องกังวลใจ</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check19 ?> id="chk_19" name="chk_19"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">ไม่มีเรื่องกังวลใจ</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs191 ?> style="transform: scale(2)" id="chk_rs191" name="chk_rs191" onchange="edit_rs191()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs190 ?> style="transform: scale(2)" id="chk_rs190" name="chk_rs190" onchange="edit_rs190()"/></td>
                                                    <td colspan="4"   ><input type="text" id="txt_remark19" name="txt_remark19" class="form-control" value="<?= $result_seTenkobefore['TENKOWORRYREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">10</td>
                                                    <td>ใบตรวจเทรลเลอร์ประจำวัน</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check110 ?> id="chk_110" name="chk_110"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">ไม่มีหัวข้อผิดปกติ</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs1101 ?> style="transform: scale(2)" id="chk_rs1101" name="chk_rs1101" onchange="edit_rs1101()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1100 ?> style="transform: scale(2)" id="chk_rs1100" name="chk_rs1100" onchange="edit_rs1100()"/></td>
                                                    <td colspan="4"  ><input type="text" id="txt_remark110" name="txt_remark110" class="form-control" value="<?= $result_seTenkobefore['TENKODAILYTRAILERREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">11</td>
                                                    <td>ตรวจสอบของที่พกพา</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check111 ?> id="chk_111" name="chk_111" style="transform: scale(2)"/></td>
                                                    <td colspan="2">ใบอนุญาติ (ขับขี่),ใบอนุญาติ (ผู้รับเหมา),ใบอนุญาติ (โฟล์คลิฟท์),ใบอนุญาติ (TLEP),ใบอนุญาติ (Trailer),โทรศัพท์,สายสมอลทอร์ค
                                                    </td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs1111 ?> style="transform: scale(2)" id="chk_rs1111" name="chk_rs1111" onchange="edit_rs1111()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1110 ?> style="transform: scale(2)" id="chk_rs1110" name="chk_rs1110" onchange="edit_rs1110()"/></td>
                                                    <td colspan="4"   ><input type="text" id="txt_remark111" name="txt_remark111" class="form-control" value="<?= $result_seTenkobefore['TENKOCARRYREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">12</td>
                                                    <td>ตรวจสอบรายละเอียดการทำงาน</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check112 ?> id="chk_112" name="chk_112"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">เข้าใจเส้นทาง,จุดพักรถ,รูปแบบการขับขี่,ความสำคัญในการส่งรถ</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs1121 ?> style="transform: scale(2)" id="chk_rs1121" name="chk_rs1121" onchange="edit_rs1121()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1120 ?> style="transform: scale(2)" id="chk_rs1120" name="chk_rs1120" onchange="edit_rs1120()"/></td>
                                                    <td colspan="4"  ><input type="text" id="txt_remark112" name="txt_remark112" class="form-control" value="<?= $result_seTenkobefore['TENKOJOBDETAILREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">13</td>
                                                    <td>แจ้งสภาพถนน</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check113 ?> id="chk_113" name="chk_113"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">เข้าใจเนื้อหาที่แจ้ง</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs1131 ?> style="transform: scale(2)" id="chk_rs1131" name="chk_rs1131" onchange="edit_rs1131()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1130 ?> style="transform: scale(2)" id="chk_rs1130" name="chk_rs1130" onchange="edit_rs1130()"/></td>
                                                    <td colspan="4"   ><input type="text" id="txt_remark113" name="txt_remark113" class="form-control" value="<?= $result_seTenkobefore['TENKOLOADINFORMREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">14</td>
                                                    <td>แจ้งสภาพอากาศ</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check114 ?> id="chk_114" name="chk_114"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">เข้าใจเนื้อหาที่แจ้ง</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs1141 ?> style="transform: scale(2)" id="chk_rs1141" name="chk_rs1141" onchange="edit_rs1141()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1140 ?> style="transform: scale(2)" id="chk_rs1140" name="chk_rs1140" onchange="edit_rs1140()"/></td>
                                                    <td colspan="4"   ><input type="text" id="txt_remark114" name="txt_remark114" class="form-control" value="<?= $result_seTenkobefore['TENKOAIRINFORMREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">15</td>
                                                    <td>แจ้งเรื่องโยโกะเด็น</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check115 ?> id="chk_115" name="chk_115"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">เข้าใจเนื้อหาที่แจ้ง</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs1151 ?> style="transform: scale(2)" id="chk_rs1151" name="chk_rs1151" onchange="edit_rs1151()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1150 ?> style="transform: scale(2)" id="chk_rs1150" name="chk_rs1150" onchange="edit_rs1150()"/></td>
                                                    <td colspan="4"   ><input type="text" id="txt_remark115" name="txt_remark115" class="form-control" value="<?= $result_seTenkobefore['TENKOYOKOTENREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">16</td>
                                                    <td>ตรวจสอบเป้าหมายการขับขี่จากเครื่องชิมูเลเตอร์</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check116 ?> id="chk_116" name="chk_116"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">ตรวจสอบกันทั้งสองฝ่าย</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs1161 ?> style="transform: scale(2)" id="chk_rs1161" name="chk_rs1161" onchange="edit_rs1161()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1160 ?> style="transform: scale(2)" id="chk_rs1160" name="chk_rs1160" onchange="edit_rs1160()"/></td>
                                                    <td colspan="4" ><input type="text" id="txt_remark116" name="txt_remark116" class="form-control" value="<?= $result_seTenkobefore['TENKOCHIMOLATORREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">17</td>
                                                    <td>สามารถวิ่งงานได้หรือไม่</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check117 ?> id="chk_117" name="chk_117" style="transform: scale(2)"/></td>
                                                    <td colspan="2">ไม่มีข้อบกพร่องต่อการวิ่งงาน</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs1171 ?> style="transform: scale(2)" id="chk_rs1171" name="chk_rs1171" onchange="edit_rs1171()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1170 ?> style="transform: scale(2)" id="chk_rs1170" name="chk_rs1170" onchange="edit_rs1170()"/></td>
                                                    <td colspan="4" ><input type="text" id="txt_remark117" name="txt_remark117" class="form-control" value="<?= $result_seTenkobefore['TENKOTRANSPORTREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">18</td>
                                                    <td>การทักทายหลังทำเท็งโกะเสร็จ</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check118 ?> id="chk_118" name="chk_118"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">ทักทายอย่างมีชีวิตชีวา</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs1181 ?> style="transform: scale(2)" id="chk_rs1181" name="chk_rs1181" onchange="edit_rs1181()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1180 ?> style="transform: scale(2)" id="chk_rs1180" name="chk_rs1180" onchange="edit_rs1180()"/></td>
                                                    <td colspan="4" ><input type="text" id="txt_remark118" name="txt_remark118" class="form-control" value="<?= $result_seTenkobefore['TENKOAFTERGREETREMARK'] ?>"></td>
                                                </tr>
                                                                       
                                                <tr>
                                                    <td rowspan="1" style="text-align: center">***</td>
                                                    <td rowspan="1">ตรวจเช็คออกซิเจนเลือด</td>
                                                    <td rowspan="1" style="text-align: center"><input disabled="" type="checkbox" <?= $check119 ?> id="chk_119" name="chk_119"  style="transform: scale(2)"/></td>
                                                    <td>ออกซิเจนในเลือดตั้งแต่ 98%</td>
                                                    <td><input type="text"
                                                               onKeyUp="if (isNaN(this.value)) {
                                                                           alert('กรุณากรอกตัวเลข');
                                                                           this.value = '0';
                                                                       } else {
                                                                           edit_tenkobeforetxt8(this.value, 'TENKOOXYGENDATA', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                           update_selfcheck(this.value, 'OXYGENVALUE', '<?= $result_seSelfCheck1['SELFCHECKID'] ?>')
                                                                       }"
                                                               class="form-control" id="txt_rs19" name="txt_rs19" value="<?= $result_seTenkobefore['TENKOOXYGENDATA'] ?>"></td>
                                                    <td rowspan="1" style="text-align: center"><input disabled="" type="checkbox" <?= $rs1191 ?> style="transform: scale(2)" id="chk_rs1191" name="chk_rs1191" onchange="edit_rs1191()"/></td>
                                                    <td rowspan="1" style="text-align: center"><input disabled="" type="checkbox" <?= $rs1190 ?> style="transform: scale(2)" id="chk_rs1190" name="chk_rs1190" onchange="edit_rs1190()"/></td>
                                                    <td colspan="4" rowspan="2"  ><input type="text" id="txt_remark119" name="txt_remark119" class="form-control" value="<?= $result_seTenkobefore['TENKOOXYGENREMARK'] ?>"></td>
                                                    
                                                </tr>
                                                <!-- สายตาพนักงานคนที่1 -->
                                                <tr>
                                                    <td colspan="12" style="text-align: center;background-color: #e7e7e7;font-size: 15px;">ตรวจสอบปัญหาสุขภาพสายตาพนักงานคนที่1 :<font style="color:red"> *หากตัวหนังสือมีสีแดง หมายถึงมีปัญหาสุขภาพ เจ้าหน้าที่ต้องเน้นย้ำ และตรวจสอบแว่นสายตาของพนักงาน </font></td>
                                                    <input  class="form-control" type="hidden" id="txt_employeecode" name="txt_employeecode" value="<?=$_GET['employeecode1']?>">
                                                </tr>                        
                                                <tr>
                                                    <td colspan="1" style="text-align: center">1</td>
                                                    <?php
                                                    if ($result_sehealth['SHORTSIGHT'] == '1') {
                                                      ?>
                                                        <td><font style="color:red"> สายตาสั้น </font></td>
                                                      <?php  
                                                    }else{
                                                        ?>
                                                        <td>สายตาสั้น</td>
                                                        <?php
                                                    }
                                                    ?>
                                                    
                                                    <td style="text-align: center"><input type="checkbox" <?= $checkshortsight ?> id="chk_shortsight" name="chk_shortsight"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
                                                    <td style="text-align: center"><input type="checkbox" <?=$rsshortsightok?> style="transform: scale(2)" id="chk_rsshortsightok" name="chk_rsshortsightok" onchange="edit_rsshortsightok()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled=""  <?=$rsshortsightng?> style="transform: scale(2)" id="chk_rsshortsightng" name="chk_rsshortsightng" onchange="edit_rsshortsightng()"/></td>

                                                    <td colspan="4" ><input type="text" id="txt_shortsightremark" name="txt_shortsightremark" class="form-control" value="<?= $result_seTenkobefore['TENKOSHORTSIGHTREMARK'] ?>"></td>
                                                </tr>                       
                                                <tr>
                                                    <td colspan="1" style="text-align: center">2</td>
                                                    <?php
                                                    if ($result_sehealth['LONGSIGHT'] == '1') {
                                                      ?>
                                                        <td><font style="color:red"> สายตายาว </font></td>
                                                      <?php  
                                                    }else{
                                                        ?>
                                                        <td>สายตายาว</td>
                                                        <?php
                                                    }
                                                    ?>
                                                    <td style="text-align: center"><input type="checkbox" <?= $checklongsight ?> id="chk_longsight" name="chk_longsight"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
                                                    <td style="text-align: center"><input type="checkbox"  <?=$rslongsightok?> style="transform: scale(2)" id="chk_rslongsightok" name="chk_rslongsightok" onchange="edit_rslongsightok()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?=$rslongsightng?> style="transform: scale(2)" id="chk_rslongsightng" name="chk_rslongsightng" onchange="edit_rslongsightng()"/></td>

                                                    <td colspan="4" ><input type="text" id="txt_longsightremark" name="txt_longsightremark" class="form-control" value="<?= $result_seTenkobefore['TENKOLONGSIGHTREMARK'] ?>"></td>
                                                </tr>                       
                                                <tr>
                                                    <td colspan="1" style="text-align: center">3</td>
                                                    <?php
                                                    if ($result_sehealth['OBLIQUESIGHT'] == '1') {
                                                      ?>
                                                        <td><font style="color:red"> สายตาเอียง </font></td>
                                                      <?php  
                                                    }else{
                                                        ?>
                                                        <td>สายตาเอียง</td>
                                                        <?php
                                                    }
                                                    ?>
                                                    <td style="text-align: center"><input type="checkbox" <?= $checkobliquesight ?> id="chk_obliquesight" name="chk_obliquesight"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
                                                    <td style="text-align: center"><input type="checkbox"  <?=$rsobliquesightok?> style="transform: scale(2)" id="chk_rsobliquesightok" name="chk_rsobliquesightok" onchange="edit_rsobliquesightok()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?=$rsobliquesightng?> style="transform: scale(2)" id="chk_rsobliquesightng" name="chk_rsobliquesightng" onchange="edit_rsobliquesightng()"/></td>

                                                    <td colspan="4" ><input type="text" id="txt_obliquesightremark" name="txt_obliquesightremark" class="form-control" value="<?= $result_seTenkobefore['TENKOOBLIQUESIGHTREMARK'] ?>"></td>
                                                </tr>                       


                                            </tbody>
                                            <!--<tfoot>
                                                <tr>
                                                    <td>
                                                        <input type="button" class="btn btn-primary" onclick="before_checknull()" value="ตรวจสอบ">
                                                    </td>

                                                </tr>
                                            </tfoot>
                                            -->
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="tenko2">
                                        <div id="data_tenko2emp1sr"></div>
                                    </div>
                                    <div class="tab-pane fade" id="tenko3">
                                            <table style="border: 1px solid black;border-collapse: collapse;">
                                                <tr>
                                                    <th colspan = "18" style="border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center">ลงข้อมูลเวลาวางกุญแจ หรือ เวลาพักผ่อน สำหรับพนักงานคนที่1<font style="color:red">  </font></th>  
                                                    <!-- <th colspan = "8" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: center">ข้อมูลวันหมดอายุใบขับขี่ พขร.2</th> 
                                                    <th colspan = "4" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: center">ตรวจสอบ พขร.2</th>
                                                    <th colspan = "4" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: center">เอกสารเท็งโก๊ะ พขร.2</th> -->
                                                </tr>
                                                <tr>
                                                    <?php

                                                    $KEYDROPTIME1 = str_replace("T"," ",$result_seSelfCheck1['KEYDROPTIME']);
                                                    $KEYDROPTIMEDATA1 = str_replace("-","/",$KEYDROPTIME1);
                                                     //เวลาการพักผ่อน 8 ชั่วโมง
                                                    $SLEEPRESTEND1 = str_replace("T"," ",$result_seSelfCheck1['SLEEPRESTEND']);
                                                    $SLEEPRESTENDDATA1 = str_replace("-","/",$SLEEPRESTEND1);

                                                   
                                                    // เวลาการทำงาน น้อยกว่า 14 ชั่วโมง
                                                    if (($result_seSelfCheck1['TIMEWORKING'] == '' || $result_seSelfCheck1['TIMEWORKING'] == '<br /><b>Warning</b>:  sqlsrv_fetch_array() expects parameter 1 to be resource, boolean given in <b>') ) {
                                                        $TIMEWORKING11 = '0';
                                                        $TIMEWORKING12 = '0';
                                                    }else {
                                                        // เช็คชั่วโมง < 14
                                                        $TIMEWORKINGCHK11 = substr($result_seSelfCheck1['TIMEWORKING'],0,2);
                                                        $TIMEWORKING11 = str_replace(":"," ",$TIMEWORKINGCHK11);

                                                        // เช็คนาที < 1
                                                        $TIMEWORKINGCHK12 = substr($result_seSelfCheck1['TIMEWORKING'],3,5);
                                                        $TIMEWORKING12 = str_replace(":"," ",$TIMEWORKINGCHK12);
                                                    }

                                                    // echo $TIMEWORKING11;
                                                    // echo "<br>";
                                                    // echo $TIMEWORKING12;
                                                    // echo $KEYDROPTIMEDATA1;
                                                    // echo $SLEEPRESTENDDATA1;
                                                   
                                                    ?>
                                                    <td colspan = "4" style="width:160px;border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left"><label ><u>เวลาเริ่มปฏิบัติงาน</u></label><br>
                                                    <input disabled class="form-control daysleep_restend"  style="height:40px; width:240px;9background-color: #c9c9c;" id="daysleep_restend1" name="daysleep_restend1" value="<?= $SLEEPRESTENDDATA1 ?>" min="" max="" autocomplete="off"></td>
                                                    
                                                    <td colspan = "4" style="width:160px;border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left"><label ><u>เวลาเลิกงาน</u></label><br>
                                                    <input class="form-control dateenkeydroptime" onchange ="save_keydroptime1();" style="height:40px; width:240px;9background-color: #c9c9c;" id="keydroptime1" name="keydroptime1" value="<?= $KEYDROPTIMEDATA1 ?>" min="" max="" autocomplete="off"></td>
                                                    
                                                    <td colspan = "4" style="width:160px;border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left"><label ><u>รวมเวลา</u></label><br>
                                                    
                                                    <?php
                                                    if ($TIMEWORKING11 == 0) {
                                                    ?>
                                                    <input readonly  style="background-color: #94FA67;"  type="text" class="form-control" id="timeworking1" name="timeworking1" value= "<?= $result_seSelfCheck1['TIMEWORKING'] ?>" autocomplete="off">    
                                                    <?php
                                                    }else if ($TIMEWORKING11 > 0  && $TIMEWORKING11 < 14) {
                                                    ?>
                                                    <input readonly style="background-color: #94FA67;"  type="text" class="form-control" id="timeworking1" name="timeworking1" value= "<?= $result_seSelfCheck1['TIMEWORKING'] ?>" autocomplete="off">
                                                    <?php
                                                    }else if ($TIMEWORKING11 == 14 ) {
                                                        if ($TIMEWORKING12 <= 0) {
                                                        ?>
                                                            <input readonly style="background-color: #94FA67;"  type="text" class="form-control" id="timeworking1" name="timeworking1" value= "<?= $result_seSelfCheck1['TIMEWORKING'] ?>" autocomplete="off">
                                                        <?php
                                                            }else {
                                                        ?>  
                                                            <input readonly style="background-color: #FA6767;"  type="text" class="form-control" id="timeworking1" name="timeworking1" value= "<?= $result_seSelfCheck1['TIMEWORKING'] ?>" autocomplete="off">
                                                        <?php
                                                            }
                                                        ?>
                                                    
                                                    <?php
                                                    }else {
                                                    ?>
                                                    <input readonly style="background-color: #FA6767;"  type="text" class="form-control" id="timeworking1" name="timeworking1" value= "<?= $result_seSelfCheck1['TIMEWORKING'] ?>" autocomplete="off">
                                                    <?php
                                                    }
                                                    ?>

                                                    <td colspan = "5" style="width:160px;border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left" ><label ><u>ลงสาเหตุทำงานเกิน</u></label><br>
                                                    <button type="button" style= "height:35px;width:150px" class="btn btn-primary btn-md" name="myBtn" id ="myBtn" onclick="inserttimeworkingdata('<?=$_GET['employeecode1']?>','<?= $result_sePlain['EMPLOYEENAME1'] ?>','<?=$result_seSelfCheck1['SELFCHECKID']?>')">ลงข้อมูล</button>

                                                    <td colspan = "4" style="width:160px;border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left" ><label ><u>SelfCheckID:<?= $result_seSelfCheck1['SELFCHECKID'] ?></u></label><br>
                                                    <input type="hidden" class="form-control"  disabled = "" style="height:40px; width:240px;" id="keydrop_selfcheckid1" name="keydrop_selfcheckid1" value="<?= $result_seSelfCheck1['SELFCHECKID'] ?>" min="" max="" autocomplete="off">
        
                                                    <input type="button" onclick="se_selfcheck('<?=$result_seSelfCheck1['SELFCHECKID']?>','<?= $result_seEmployee2['nameT'] ?>','<?= $_GET['employeecode1'] ?>','<?=$dateself1?>','<?=$result_seDateSelfCheck1['DATERK'] ?>','<?=$result_seDateSelfCheck1['DATEPRESENT'] ?>','<?= $result_seEmployee['nameT']?>');" name="btnSend" id="btnSend" value="ดูข้อมูลการ Self Check" class="btn btn-primary"></td>
                                                     
                                                </tr>
                                            </table>     
                                            <br><br>
                                        <div id="data_tenko3emp1sr"></div>
                                    </div>
                                    <div class="tab-pane fade" id="tenko4">    
                                        <?php
                                        if ($result_sePlain['COMPANYCODE'] == 'RRC' || $result_sePlain['COMPANYCODE'] == 'RCC' || $result_sePlain['COMPANYCODE'] == 'RATC') {
                                            ?>
                                            <div id="data_tenko4emp1sr-1"></div>
                                            <?php
                                        } else if ($result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKL') {
                                            ?>
                                            <div id="data_tenko4emp1sr-2"></div>
                                            <?php
                                        }
                                        ?>

                                    </div>

                                    <div class="tab-pane fade" id="tenko5">
                                        <div id="data_tenko5emp1sr"></div>
                                    </div>
                                    <div class="tab-pane fade" id="tenko6">
                                        <div id="data_tenko6emp1sr"></div>
                                            <div style="text-align: center;">
                                                    <?php
                                                    $sql_CheckPointEmp1 = "SELECT TENKOGPSSPEEDOVERAMOUNT,TENKOGPSBRAKEAMOUNT,TENKOGPSSPEEDMACHINEAMOUNT,
                                                    TENKOGPSOUTLINEAMOUNT,TENKOGPSCONTINUOUSAMOUNT,GRADEDRIVER,POINTDRIVER,
                                                    CONVERT(VARCHAR(16), CALCLICKDATE, 120) AS 'CALCLICKDATE'
                                                    FROM TENKOGPS WHERE TENKOMASTERID ='".$result_seTenkomaster_temp['TENKOMASTERID']."'
                                                    AND TENKOMASTERDIRVERCODE ='".$_GET['employeecode1']."'";
                                                    $params_CheckPointEmp1 = array();
                                                    $query_CheckPointEmp1 = sqlsrv_query($conn, $sql_CheckPointEmp1, $params_CheckPointEmp1);
                                                    $result_CheckPointEmp1 = sqlsrv_fetch_array($query_CheckPointEmp1, SQLSRV_FETCH_ASSOC);

                                                    // echo $result_CheckPointEmp1['CALCLICKDATE'];
                                                    
                                                    //	ความเร็วเกินกำหนด
                                                    if ($result_CheckPointEmp1['TENKOGPSSPEEDOVERAMOUNT'] == '' || $result_CheckPointEmp1['TENKOGPSSPEEDOVERAMOUNT'] == NULL || $result_CheckPointEmp1['TENKOGPSSPEEDOVERAMOUNT'] == '-') {
                                                        $speedoverpointEmp1 = '100';
                                                    }else {
                                                        $speedoverpointEmp1 = $result_CheckPointEmp1['TENKOGPSSPEEDOVERAMOUNT'];
                                                    }
                                                    
                                                    // 	เบรคกระทันหัน
                                                    if ($result_CheckPointEmp1['TENKOGPSBRAKEAMOUNT'] == '' || $result_CheckPointEmp1['TENKOGPSBRAKEAMOUNT'] == NULL || $result_CheckPointEmp1['TENKOGPSSPEEDOVERAMOUNT'] == '-') {
                                                        $gpsbrakepointEmp1 = '100';
                                                    }else {
                                                        $gpsbrakepointEmp1 = $result_CheckPointEmp1['TENKOGPSBRAKEAMOUNT'];
                                                    }
                                                    
                                                    // รอบเครื่องเกินกำหนด
                                                    if ($result_CheckPointEmp1['TENKOGPSSPEEDMACHINEAMOUNT'] == '' || $result_CheckPointEmp1['TENKOGPSSPEEDMACHINEAMOUNT'] == NULL || $result_CheckPointEmp1['TENKOGPSSPEEDOVERAMOUNT'] == '-') {
                                                        $speedmechinepointEmp1 = '100';
                                                    }else {
                                                        $speedmechinepointEmp1 = $result_CheckPointEmp1['TENKOGPSSPEEDMACHINEAMOUNT'];
                                                    }
                                                    
                                                    //	วิ่งนอกเส้นทาง
                                                    if ($result_CheckPointEmp1['TENKOGPSOUTLINEAMOUNT'] == '' || $result_CheckPointEmp1['TENKOGPSOUTLINEAMOUNT'] == NULL || $result_CheckPointEmp1['TENKOGPSSPEEDOVERAMOUNT'] == '-') {
                                                        $outlinepointEmp1 = '100';
                                                    }else {
                                                        $outlinepointEmp1 = $result_CheckPointEmp1['TENKOGPSOUTLINEAMOUNT'];
                                                    }
                                                    
                                                    //	ขับรถต่อเนื่อง 4 ชม.
                                                    if ($result_CheckPointEmp1['TENKOGPSCONTINUOUSAMOUNT'] == '' || $result_CheckPointEmp1['TENKOGPSCONTINUOUSAMOUNT'] == NULL || $result_CheckPointEmp1['TENKOGPSSPEEDOVERAMOUNT'] == '-') {
                                                        $continuepointEmp1 = '100';
                                                    }else {
                                                        $continuepointEmp1 = $result_CheckPointEmp1['TENKOGPSCONTINUOUSAMOUNT'];
                                                    }

                                                    $maxpointEmp1 = 100;
                                                    $sumpointEmp1 = ($speedoverpointEmp1+$gpsbrakepointEmp1+$speedmechinepointEmp1+$outlinepointEmp1+$continuepointEmp1)*2;
                                                    
                                                
                                                    if($sumpointEmp1 == '1000'){
                                                        $allpointEmp1 = 'ไม่มีผลคะแนน';
                                                    }else {
                                                        $allpointEmp1 = ($maxpointEmp1)-($sumpointEmp1);
                                                    }

                                                    

                                                    if ($allpointEmp1 == '100') {
                                                        $gradeEmp1 = 'A';
                                                    }else if(($allpointEmp1 >= '80') && ($allpointEmp1 <= '99')){
                                                        $gradeEmp1 = 'B';
                                                    }else if(($allpointEmp1 >= '60') && ($allpointEmp1 <= '79')){
                                                        $gradeEmp1 = 'C';
                                                    }else if(($allpointEmp1 >= '40') && ($allpointEmp1 <= '59')){
                                                        $gradeEmp1 = 'D';
                                                    }else if(($allpointEmp1 >= '0') && ($allpointEmp1 <= '39')){
                                                        $gradeEmp1 = 'E';
                                                    }else {
                                                        $gradeEmp1 = 'ไม่มีผลการประเมิน';
                                                    }



                                                ?>
                                                <table style="width:500px;border: 1px solid black;border-collapse: collapse;">
                                                    <tr>
                                                        <th colspan = "8" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: center">คะแนนการขับขี่ประจำวัน พขร.1 
                                                            <br>&nbsp;&nbsp;<button onclick="check_pointemp1('<?=$result_seTenkomaster_temp['TENKOMASTERID']?>','<?=$_GET['employeecode1']?>','emp1');" >คำนวณ พขร.1</button><font color="red">*กดคำนวณทุกครั้งเพื่อคำนวณคะแนน และบันทึกข้อมูล</font>
                                                        </th> 
                                                    </tr>
                                                    <tr>
                                                        <th colspan = "8" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: left">กดคำนวณครั้งล่าสุด:&nbsp;<?=$result_CheckPointEmp1['CALCLICKDATE']?>
                                                        </th> 
                                                    </tr>
                                                    <tr>
                                                        <!-- สายตาสั้น -->
                                                        <th colspan = "4" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center;">การประเมินผล</th>
                                                        <th colspan = "4" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center;">คะแนนที่ได้</th>
                                                    </tr>
                                                    <div id="data_pointemp2sr"></div>
                                                    <tr>
                                                        <th colspan = "4" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center;"><input disabled="" style="text-align: center;" type="text" name="txt_gradeshowemp1" id="txt_gradeshowemp1" value="<?= $gradeEmp1 ?>" style=""></th>
                                                        <th colspan = "4" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center;"><input disabled="" style="text-align: center;" type="text" name="txt_pointshowemp1" id="txt_pointshowemp1" value="<?= $allpointEmp1 ?>" style=""></th>
                                                        
                                                        <input type="text" name="txt_gradesaveemp2" id="txt_gradesaveemp1" value="" style="display:none">
                                                        <input type="text" name="txt_pointsaveemp2" id="txt_pointsaveemp1" value="" style="display:none">
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                } else if ($_GET['employeecode2'] != "") {

                                    $sql_seChktenkorest = "SELECT DATEDIFF(HOUR,
                                                                        (SELECT TOP 1 MODIFIEDDATE FROM [dbo].[TENKOAFTER] WHERE [TENKOMASTERDIRVERCODE] = '" . $_GET['employeecode2'] . "' ORDER BY [MODIFIEDDATE]  DESC)
                                                                        ,(SELECT GETDATE()))  AS 'TENKORESTDATA'";
                                    $query_seChktenkorest = sqlsrv_query($conn, $sql_seChktenkorest, $params_seChktenkorest);
                                    $result_seChktenkorest = sqlsrv_fetch_array($query_seChktenkorest, SQLSRV_FETCH_ASSOC);
                                    //edit_tenkobeforetxt1($result_seChktenkorest['TENKORESTDATA'], 'TENKORESTDATA', $result_seTenkobefore['TENKOBEFOREID']);
                                    //editTenkobefore('edit_tenkobefore', $result_seTenkobefore['TENKOBEFOREID'], 'TENKORESTDATA', $result_seChktenkorest['TENKORESTDATA']);
                                    //editTenkobefore('edit_tenkobefore', $result_seTenkobefore['TENKOBEFOREID'], 'TENKORESTRESULT', 1);
                                    $RS_TENKORESTDATA = ($result_seChktenkorest['TENKORESTDATA'] > 24) ? '24' : $result_seChktenkorest['TENKORESTDATA'];


                                    $sql_seTenkorest = "{call megEdittenkobefore_v2(?,?)}";
                                    $params_seTenkorest = array(
                                        array('select_tenkorest', SQLSRV_PARAM_IN),
                                        array($employeecode2, SQLSRV_PARAM_IN)
                                    );
                                    $query_seTenkorest = sqlsrv_query($conn, $sql_seTenkorest, $params_seTenkorest);
                                    $result_seTenkorest = sqlsrv_fetch_array($query_seTenkorest, SQLSRV_FETCH_ASSOC);
                                    ?>

                                    <div class="tab-pane fade in active" id="tenko1">


                                        <?php
                                        $conditionTenkobefore = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND a.TENKOMASTERDIRVERCODE = '" . $_GET['employeecode2'] . "'";
                                        $sql_seTenkobefore = "{call megEdittenkobefore_v2(?,?,?)}";
                                        $params_seTenkobefore = array(
                                            array('select_tenkobefore', SQLSRV_PARAM_IN),
                                            array($conditionTenkobefore, SQLSRV_PARAM_IN),
                                            array('', SQLSRV_PARAM_IN)
                                        );
                                        $query_seTenkobefore = sqlsrv_query($conn, $sql_seTenkobefore, $params_seTenkobefore);
                                        $result_seTenkobefore = sqlsrv_fetch_array($query_seTenkobefore, SQLSRV_FETCH_ASSOC);


                                        $conditionTenkoafters = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode2'] . "'";
                                        $sql_seTenkoafters = "{call megEdittenkoafter_v2(?,?,?)}";
                                        $params_seTenkoafters = array(
                                            array('select_tenkoafter', SQLSRV_PARAM_IN),
                                            array($conditionTenkoafters, SQLSRV_PARAM_IN),
                                            array('', SQLSRV_PARAM_IN)
                                        );
                                        $query_seTenkoafters = sqlsrv_query($conn, $sql_seTenkoafters, $params_seTenkoafters);
                                        $result_seTenkoafters = sqlsrv_fetch_array($query_seTenkoafters, SQLSRV_FETCH_ASSOC);

                                        $sql_seTenkobeforerest = "SELECT DATEDIFF(HOUR,CONVERT(DATETIME,'" . $result_seTenkoafters['CREATEDATE'] . "',103),CONVERT(DATETIME,GETDATE())) AS AMOUNTREST FROM [dbo].[TENKOAFTER]
                                                    WHERE TENKOMASTERDIRVERCODE = '" . $result_seTenkobefore['TENKOMASTERDIRVERCODE'] . "'
                                                    AND TENKOAFTERID = (SELECT MAX(TENKOAFTERID) FROM [dbo].[TENKOAFTER] WHERE TENKOMASTERDIRVERCODE = '" . $result_seTenkobefore['TENKOMASTERDIRVERCODE'] . "')";
                                        $query_seTenkobeforerest = sqlsrv_query($conn, $sql_seTenkobeforerest, $params_seTenkobeforerest);
                                        $result_seTenkobeforerest = sqlsrv_fetch_array($query_seTenkobeforerest, SQLSRV_FETCH_ASSOC);

                                        
                                        $YEAR = date("Y");
                                        $sql_sehealth = "SELECT  TOP 1 ID,SHORTSIGHT,SHORTSIGHT_R,SHORTSIGHT_L
                                                    ,LONGSIGHT,LONGSIGHT_R,LONGSIGHT_L
                                                    ,OBLIQUESIGHT,OBLIQUESIGHT_R,OBLIQUESIGHT_L,CREATEYEAR
                                                    FROM [dbo].[HEALTHHISTORY]
                                                    WHERE EMPLOYEECODE ='" . $_GET['employeecode2'] . "'
                                                    AND CREATEYEAR ='" . $YEAR . "'
                                                    AND ACTIVESTATUS ='1'
                                                    ORDER BY CREATEDATE DESC";
                                        $params_sehealth = array();
                                        $query_sehealth = sqlsrv_query($conn, $sql_sehealth, $params_sehealth);
                                        $result_sehealth = sqlsrv_fetch_array($query_sehealth, SQLSRV_FETCH_ASSOC);    

                                        // ข้อมูลใบขับขี่คนที่2
                                        $sql_seCarData2 = "SELECT a.PersonID,a.nameT,a.CarLicenceID,
                                        FORMAT (b.ExpireCar_Start, 'dd/MM/yyyy') 'STARTDATE',
                                        FORMAT (b.ExpireCar_End, 'dd/MM/yyyy') AS 'ENDDATE',
                                        DATEDIFF(month, FORMAT (b.ExpireCar_End, 'yyyy/MM/dd '), FORMAT (GETDATE(), 'yyyy/MM/dd ')) AS 'MONTHDIFF'
                                        FROM [dbo].[EMPLOYEEEHR2] a
                                        INNER JOIN [dbo].[EMPLOYEEDETAILEHR] b ON a.PersonID = b.PersonID
                                        WHERE PersonCode ='".$_GET['employeecode2']."'";
                                        $query_seCarData2 = sqlsrv_query($conn, $sql_seCarData2, $params_seCarData2);
                                        $result_seCarData2 = sqlsrv_fetch_array($query_seCarData2, SQLSRV_FETCH_ASSOC);    
                                        

                                        // echo $result_seCarData2['MONTHDIFF'];
                                        // echo '|';
                                        if ($result_seCarData2['MONTHDIFF'] == '-3') {
                                            // echo '1';
                                            $licensechk2 = "background-color: #f6ff54";
                                        }else if($result_seCarData2['MONTHDIFF'] == '-2'){
                                            // echo '2';
                                            $licensechk2 = "background-color: #ff9e54";
                                        }else if($result_seCarData2['MONTHDIFF'] == '-1' || $result_seCarData2['MONTHDIFF'] >= '0'){
                                            // echo '1';
                                            $licensechk2 = "background-color: #ff5454";
                                        }else{
                                            // echo '0';
                                            // ปกติ สีเขียว
                                            $licensechk2 = "background-color: #94FA67";
                                           
                                            
                                        }

                                        //เปลี่ยนปี ค.ศ เป็น พ.ศ วันที่ออกบัตรพนักงานคนที่2
                                        if ($result_seCarData2['STARTDATE'] == NULL) {
                                            $year21start =  '';
                                            $year22start =  '';
                                        }else {
                                            $year21start =  substr($result_seCarData2['STARTDATE'],0,6);
                                            $year22start =  substr($result_seCarData2['STARTDATE'],6,10)+543;
                                        }
                                        //เปลี่ยนปี ค.ศ เป็น พ.ศ วันที่หมดอายุพนักงานคนที่2
                                        if ($result_seCarData2['ENDDATE'] == NULL) {
                                            $year21end =  '';
                                            $year22end =  '';
                                        }else {
                                            $year21end =  substr($result_seCarData2['ENDDATE'],0,6);
                                            $year22end =  substr($result_seCarData2['ENDDATE'],6,10)+543;
                                        }

                                         // ข้อมูลวันที่รายงานตัวและวันที่ทำงานคนที่1 เพื่อเช็ค Self Check
                                        //  DATE WORKING ใน SELFCHECK คือ DATERK ในแผน
                                        $sql_seDateSelfCheck2 = "SELECT CONVERT(VARCHAR(10),DATERK,103) AS 'DATERK',
                                        CONVERT(VARCHAR(10),DATEPRESENT,103)  AS 'DATEPRESENT'
                                        FROM VEHICLETRANSPORTPLAN
                                        WHERE VEHICLETRANSPORTPLANID ='".$_GET['vehicletransportplanid']."'";
                                        $query_seDateSelfCheck2 = sqlsrv_query($conn, $sql_seDateSelfCheck2, $params_seDateSelfCheck2);
                                        $result_seDateSelfCheck2 = sqlsrv_fetch_array($query_seDateSelfCheck2, SQLSRV_FETCH_ASSOC);
                                        
                                        // echo $result_seDateSelfCheck2['DATEWORKING'];
                                        // echo "<br>";
                                        // echo $result_seDateSelfCheck2['DATEPRESENT'];

                                        $dateself2 = date("d/m/Y"); //วันที่ปัจจุบันพนักงานคนที่2

                                        //SELF CHECKคนที่2
                                        $sql_seSelfCheck2 = "SELECT TOP 1 SELFCHECKID,SLEEPRESTSTART,SLEEPRESTEND,TIMESLEEPREST,
                                        SLEEPNORMALSTART,SLEEPNORMALEND,TIMESLEEPNORMAL,SLEEPEXTRASTART,SLEEPEXTRAEND,TIMESLEEPEXTRA,KEYDROPTIME,TIMEWORKING
                                        FROM DRIVERSELFCHECK WHERE EMPLOYEECODE ='".$_GET['employeecode2']."' 
                                        AND (CONVERT(VARCHAR(10),CREATEDATE,103) ='".$result_seDateSelfCheck2['DATERK']."' 
                                        OR CONVERT(VARCHAR(10),CREATEDATE,103) ='".$result_seDateSelfCheck2['DATEPRESENT']."')
                                        ORDER BY  CONVERT(CHAR(5), CREATEDATE, 108) DESC";
                                        $query_seSelfCheck2 = sqlsrv_query($conn, $sql_seSelfCheck2, $params_seSelfCheck2);
                                        $result_seSelfCheck2 = sqlsrv_fetch_array($query_seSelfCheck2, SQLSRV_FETCH_ASSOC);

                                        //เช็คจำนวนชั่วโมงในการนอน 4.5 ชั่วโมง
                                        if ($result_seSelfCheck2['TIMESLEEPEXTRA'] == '' || $result_seSelfCheck2['TIMESLEEPEXTRA'] == '<br /><b>Warning</b>:  sqlsrv_fetch_array() expects parameter 1 to be resource, boolean given in <b>') {
                                            $TIMESLEEPEXTRAHOURCHK2 = '0'; 
                                            $TIMESLEEPEXTRAMINCHK2  = '0';
                                        }else {
                                            // $TIMESLEEPEXTRA  = str_replace(":","",substr($result_seSelfCheck['TIMESLEEPEXTRA'],0,6));
                                            //$TIMESLEEPEXTRA = $result_seSelfCheck['TIMESLEEPEXTRA'];
                                            //เช็คจำนวนชั่วโมงในการนอน 
                                            $TIMESLEEPEXTRAHOURCHK2 = substr($result_seSelfCheck2['TIMESLEEPEXTRA'],0,2);
                                            //เช็คจำนวนนาทีในการนอน
                                            $TIMESLEEPEXTRAMINCHK1 = substr($result_seSelfCheck2['TIMESLEEPEXTRA'],2,3);
                                           if ($TIMESLEEPEXTRAHOURCHK2  == '4:') { //กรณีที่เท่ากับ 4 
                                                $TIMESLEEPEXTRAHOURCHK2 = 'HG4'; //HG4 mean Greater than 4 hour มากกว่า 4 ชม
                                           }else if ($TIMESLEEPEXTRAHOURCHK2 > '4') {
                                                $TIMESLEEPEXTRAHOURCHK2 = 'HGG4'; //เลข 4 ขึ้นไปและเลขสองหลัก ex 5, 6, 10
                                           }
                                           else {
                                                $TIMESLEEPEXTRAHOURCHK2 = 'HL4'; //HL4 mean Less than 4 hour น้อยกว่า 4 ชม  
                                           }
                                           //เช็คจำนวนนาทีในการนอน
                                           $TIMESLEEPEXTRAMINCHK2 = substr($result_seSelfCheck2['TIMESLEEPEXTRA'],2,3);
                                           if ($TIMESLEEPEXTRAMINCHK2 >= '30') {
                                                $TIMESLEEPEXTRAMINCHK2 = 'MG3'; //MG3 mean Greater than 30 minute มากกว่า 30นาที
                                           }else {
                                                $TIMESLEEPEXTRAMINCHK2 = 'ML3'; //ML3 mean Less than 30 minute น้อยกว่า 30นาที   
                                           }

                                        }

                                        //เวลาการพักผ่อน 8 ชั่วโมง
                                        if ($result_seSelfCheck2['TIMESLEEPREST'] == '' || $result_seSelfCheck2['TIMESLEEPREST'] == '<br /><b>Warning</b>:  sqlsrv_fetch_array() expects parameter 1 to be resource, boolean given in <b>') {
                                            $TIMESLEEPREST2 = '0';
                                        }else {
                                            $TIMESLEEPREST2 = substr($result_seSelfCheck2['TIMESLEEPREST'],0,2);
                                        }

                                        //เวลาการนอนปกติ 6 ชั่วโมง
                                        if ($result_seSelfCheck2['TIMESLEEPNORMAL'] == '' || $result_seSelfCheck2['TIMESLEEPNORMAL'] == '<br /><b>Warning</b>:  sqlsrv_fetch_array() expects parameter 1 to be resource, boolean given in <b>') {
                                            $TIMESLEEPNORMAL2 = '0';
                                        }else {
                                            $TIMESLEEPNORMAL2 = substr($result_seSelfCheck2['TIMESLEEPNORMAL'],0,2);
                                        }
                                        
                                        // echo $TIMESLEEPNORMAL2;

                                        $check11 = ($result_seTenkobefore['TENKOBEFOREGREETCHECK'] == '1') ? "checked" : "";
                                        $check12 = ($result_seTenkobefore['TENKOUNIFORMCHECK'] == '1') ? "checked" : "";
                                        $check13 = ($result_seTenkobefore['TENKOBODYCHECK'] == '1') ? "checked" : "";
                                        //if ($result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKL' || $result_sePlain['COMPANYCODE'] == 'RKS') {
                                        $check14 = ($result_seTenkobefore['TENKORESTCHECK'] == '1' || $result_seTenkobefore['TENKORESTDATA'] > 7) ? "checked" : "";
                                        $rs141 = ($result_seTenkobefore['TENKORESTDATA'] > 7) ? "checked" : "";
                                        $rs140 = ($result_seTenkobefore['TENKORESTDATA'] < 8) ? "checked" : "";
                                        //}
                                        //else
                                        //{
                                        //    $check14 = ($result_seTenkobefore['TENKORESTCHECK'] == '1' || $RS_TENKORESTDATA > 7) ? "checked" : "";
                                        //    $rs141 = ($RS_TENKORESTDATA > 7) ? "checked" : "";
                                        //    $rs140 = ($RS_TENKORESTDATA < 8) ? "checked" : "";
                                        //}
                                        $check15 = ($result_seTenkobefore['TENKOSLEEPTIMECHECK'] == '1') ? "checked" : "";
                                        $check16 = ($result_seTenkobefore['TENKOTEMPERATURECHECK'] == '1') ? "checked" : "";
                                        $check17 = ($result_seTenkobefore['TENKOPRESSURECHECK'] == '1') ? "checked" : "";
                                        $check18 = ($result_seTenkobefore['TENKOALCOHOLCHECK'] == '1') ? "checked" : "";
                                        $check19 = ($result_seTenkobefore['TENKOWORRYCHECK'] == '1') ? "checked" : "";
                                        $check110 = ($result_seTenkobefore['TENKODAILYTRAILERCHECK'] == '1') ? "checked" : "";
                                        $check111 = ($result_seTenkobefore['TENKOCARRYCHECK'] == '1') ? "checked" : "";
                                        $check112 = ($result_seTenkobefore['TENKOJOBDETAILCHECK'] == '1') ? "checked" : "";
                                        $check113 = ($result_seTenkobefore['TENKOLOADINFORMCHECK'] == '1') ? "checked" : "";
                                        $check114 = ($result_seTenkobefore['TENKOAIRINFORMCHECK'] == '1') ? "checked" : "";
                                        $check115 = ($result_seTenkobefore['TENKOYOKOTENCHECK'] == '1') ? "checked" : "";
                                        $check116 = ($result_seTenkobefore['TENKOCHIMOLATORCHECK'] == '1') ? "checked" : "";
                                        $check117 = ($result_seTenkobefore['TENKOTRANSPORTCHECK'] == '1') ? "checked" : "";
                                        $check118 = ($result_seTenkobefore['TENKOAFTERGREETCHECK'] == '1') ? "checked" : "";
                                        $check119 = ($result_seTenkobefore['TENKOOXYGENCHECK'] == '1') ? "checked" : "";
                                        
                                        //เช็คค่าสายตาพนักงานคนที่2
                                        $checkshortsight = ($result_seTenkobefore['TENKOSHORTSIGHTCHECK'] == '1') ? "checked" : "";
                                        $checklongsight = ($result_seTenkobefore['TENKOLONGSIGHTCHECK'] == '1') ? "checked" : "";    
                                        $checkobliquesight =($result_seTenkobefore['TENKOOBLIQUESIGHTCHECK'] == '1') ? "checked" : ""; 
                                        //เช็คปกติ
                                        $rsshortsightok = ($result_seTenkobefore['TENKOSHORTSIGHTRESULT'] == '1') ? "checked" : "";
                                        $rslongsightok = ($result_seTenkobefore['TENKOLONGSIGHTRESULT'] == '1') ? "checked" : "";
                                        $rsobliquesightok = ($result_seTenkobefore['TENKOOBLIQUESIGHTRESULT'] == '1') ? "checked" : "";        
                                        //เช็คไม่ปกติ
                                        $rsshortsightng = ($result_seTenkobefore['TENKOSHORTSIGHTRESULT'] == '0' || $result_seTenkobefore['TENKOSHORTSIGHTRESULT'] == '') ? "checked" : "";
                                        $rslongsightng = ($result_seTenkobefore['TENKOLONGSIGHTRESULT'] == '0' || $result_seTenkobefore['TENKOLONGSIGHTRESULT'] == '') ? "checked" : "";
                                        $rsobliquesightng = ($result_seTenkobefore['TENKOOBLIQUESIGHTRESULT'] == '0' || $result_seTenkobefore['TENKOOBLIQUESIGHTRESULT'] == '') ? "checked" : "";   
    
                                            



                                        $rs111 = ($result_seTenkobefore['TENKOBEFOREGREETRESULT'] == '1') ? "checked" : "";
                                        $rs121 = ($result_seTenkobefore['TENKOUNIFORMRESULT'] == '1') ? "checked" : "";
                                        $rs131 = ($result_seTenkobefore['TENKOBODYRESULT'] == '1') ? "checked" : "";
                                        $rs151 = ($result_seTenkobefore['TENKOSLEEPTIMERESULT'] == '1') ? "checked" : "";
                                        $rs161 = ($result_seTenkobefore['TENKOTEMPERATURERESULT'] == '1') ? "checked" : "";
                                        $rs171 = ($result_seTenkobefore['TENKOPRESSURERESULT'] == '1') ? "checked" : "";
                                        $rs181 = ($result_seTenkobefore['TENKOALCOHOLRESULT'] == '1') ? "checked" : "";
                                        $rs191 = ($result_seTenkobefore['TENKOWORRYRESULT'] == '1') ? "checked" : "";
                                        $rs1101 = ($result_seTenkobefore['TENKODAILYTRAILERRESULT'] == '1') ? "checked" : "";
                                        $rs1111 = ($result_seTenkobefore['TENKOCARRYRESULT'] == '1') ? "checked" : "";
                                        $rs1121 = ($result_seTenkobefore['TENKOJOBDETAILRESULT'] == '1') ? "checked" : "";
                                        $rs1131 = ($result_seTenkobefore['TENKOLOADINFORMRESULT'] == '1') ? "checked" : "";
                                        $rs1141 = ($result_seTenkobefore['TENKOAIRINFORMRESULT'] == '1') ? "checked" : "";
                                        $rs1151 = ($result_seTenkobefore['TENKOYOKOTENRESULT'] == '1') ? "checked" : "";
                                        $rs1161 = ($result_seTenkobefore['TENKOCHIMOLATORRESULT'] == '1') ? "checked" : "";
                                        $rs1171 = ($result_seTenkobefore['TENKOTRANSPORTRESULT'] == '1') ? "checked" : "";
                                        $rs1181 = ($result_seTenkobefore['TENKOAFTERGREETRESULT'] == '1') ? "checked" : "";
                                        $rs1191 = ($result_seTenkobefore['TENKOOXYGENRESULT'] == '1') ? "checked" : "";

                                        $rs110 = ($result_seTenkobefore['TENKOBEFOREGREETRESULT'] == '0' || $result_seTenkobefore['TENKOBEFOREGREETRESULT'] == '') ? "checked" : "";
                                        $rs120 = ($result_seTenkobefore['TENKOUNIFORMRESULT'] == '0' || $result_seTenkobefore['TENKOUNIFORMRESULT'] == '') ? "checked" : "";
                                        $rs130 = ($result_seTenkobefore['TENKOBODYRESULT'] == '0' || $result_seTenkobefore['TENKOBODYRESULT'] == '') ? "checked" : "";


                                        $rs150 = ($result_seTenkobefore['TENKOSLEEPTIMERESULT'] == '0' || $result_seTenkobefore['TENKOSLEEPTIMERESULT'] == '') ? "checked" : "";
                                        $rs160 = ($result_seTenkobefore['TENKOTEMPERATURERESULT'] == '0' || $result_seTenkobefore['TENKOTEMPERATURERESULT'] == '') ? "checked" : "";
                                        $rs170 = ($result_seTenkobefore['TENKOPRESSURERESULT'] == '0' || $result_seTenkobefore['TENKOPRESSURERESULT'] == '') ? "checked" : "";
                                        $rs180 = ($result_seTenkobefore['TENKOALCOHOLRESULT'] == '0' || $result_seTenkobefore['TENKOALCOHOLRESULT'] == '') ? "checked" : "";
                                        $rs190 = ($result_seTenkobefore['TENKOWORRYRESULT'] == '0' || $result_seTenkobefore['TENKOWORRYRESULT'] == '') ? "checked" : "";
                                        $rs1100 = ($result_seTenkobefore['TENKODAILYTRAILERRESULT'] == '0' || $result_seTenkobefore['TENKODAILYTRAILERRESULT'] == '') ? "checked" : "";
                                        $rs1110 = ($result_seTenkobefore['TENKOCARRYRESULT'] == '0' || $result_seTenkobefore['TENKOCARRYRESULT'] == '') ? "checked" : "";
                                        $rs1120 = ($result_seTenkobefore['TENKOJOBDETAILRESULT'] == '0' || $result_seTenkobefore['TENKOJOBDETAILRESULT'] == '') ? "checked" : "";
                                        $rs1130 = ($result_seTenkobefore['TENKOLOADINFORMRESULT'] == '0' || $result_seTenkobefore['TENKOLOADINFORMRESULT'] == '') ? "checked" : "";
                                        $rs1140 = ($result_seTenkobefore['TENKOAIRINFORMRESULT'] == '0' || $result_seTenkobefore['TENKOAIRINFORMRESULT'] == '') ? "checked" : "";
                                        $rs1150 = ($result_seTenkobefore['TENKOYOKOTENRESULT'] == '0' || $result_seTenkobefore['TENKOYOKOTENRESULT'] == '') ? "checked" : "";
                                        $rs1160 = ($result_seTenkobefore['TENKOCHIMOLATORRESULT'] == '0' || $result_seTenkobefore['TENKOCHIMOLATORRESULT'] == '') ? "checked" : "";
                                        $rs1170 = ($result_seTenkobefore['TENKOTRANSPORTRESULT'] == '0' || $result_seTenkobefore['TENKOTRANSPORTRESULT'] == '') ? "checked" : "";
                                        $rs1180 = ($result_seTenkobefore['TENKOAFTERGREETRESULT'] == '0' || $result_seTenkobefore['TENKOAFTERGREETRESULT'] == '') ? "checked" : "";
                                        $rs1190 = ($result_seTenkobefore['TENKOOXYGENRESULT'] == '0' || $result_seTenkobefore['TENKOOXYGENRESULT'] == '') ? "checked" : "";
                                        ?>
                                        <!-- ใบขับขี่และ Self Check พขร2 -->
                                        <table style="border: 1px solid black;border-collapse: collapse;">
                                            <tr>
                                                <th colspan = "25" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: left"><font style="color: black;font-size: 20px;">พนักงานขับรถ : <?=$sex?>  <?= $result_sePlain['EMPLOYEENAME2'] ?></font></th>
                                            </tr>
                                            <tr>
                                                <th colspan = "4" rowspan="4" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: center"><img  style="padding:4px;text-align:center;height: 200px;width: 200px;" src="../images/employee/<?=$_GET['employeecode2']?>.JPG" data-action="zoom" alt="Pic_Driver1" ></th>
                                                <th colspan = "6" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: center">ตรวจสอบปัญหาสายตา<font style="color:#ff0808"> *ตัวหนังสือมีสีแดง หมายถึงมีปัญหาสายตา เจ้าหน้าที่ต้องเน้นย้ำ และตรวจสอบแว่นสายตาของพนักงาน </font></th>  
                                                <th colspan = "8" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: center">ข้อมูลวันหมดอายุใบขับขี่ พขร.2</th> 
                                                <th colspan = "4" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: center">ตรวจสอบ พขร.2</th>
                                                <th colspan = "4" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: center">เอกสารเท็งโก๊ะ พขร.2</th>
                                            </tr>
                                            <tr>
                                                <!-- สายตาสั้น -->
                                                <?php
                                                if ($result_sehealth['SHORTSIGHT'] == '1') {
                                                   ?>
                                                      <th colspan = "2" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center;color:red">สายตาสั้น</th>   
                                                   <?php
                                                }else{
                                                    ?>
                                                        <th colspan = "2" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center">สายตาสั้น</th> 
                                                    <?php
                                                }
                                                ?>
                                                <!-- สายตายาว -->
                                               <?php
                                                if ($result_sehealth['LONGSIGHT'] == '1') {
                                                   ?>
                                                      <th colspan = "2" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center;color:red">สายตายาว</th>   
                                                   <?php
                                                }else{
                                                    ?>
                                                        <th colspan = "2" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center">สายตายาว</th> 
                                                    <?php
                                                }
                                                ?>
                                                <!-- สายตาเอียง -->
                                                    <?php
                                                if ($result_sehealth['OBLIQUESIGHT'] == '1') {
                                                   ?>
                                                      <th colspan = "2" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center;color:red">สายตาเอียง</th>   
                                                   <?php
                                                }else{
                                                    ?>
                                                        <th colspan = "2" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center">สายตาเอียง</th> 
                                                    <?php
                                                }
                                                ?>

                                                    <th colspan = "4" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: left">เลขที่ใบขับขี่</th>
                                                    <th colspan = "4" style="width:160px;border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left"><?=$result_seCarData2['CarLicenceID']?></th>
                                                    <?php
                                                    if ($result_seSelfCheck2['SELFCHECKID'] == '') {
                                                    ?>
                                                        <th colspan = "4" style="width:160px;border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left"><input type="button" onclick="function warning(){alert('ไม่สามารถดูข้อมูลได้เนื่องจากพนักงานยังไม่ได้ทำการแจ้งสุขภาพตนเอง!!!')};warning();" name="btnSend" id="btnSend" value="ดูข้อมูลการ Self Check" class="btn btn-primary"></th>
                                                    <?php
                                                    }else {
                                                    ?>
                                                        <th colspan = "4" style="width:160px;border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left"><input type="button" onclick="se_selfcheck('<?=$result_seSelfCheck2['SELFCHECKID']?>','<?= $result_seEmployee2['nameT'] ?>','<?= $_GET['employeecode2'] ?>','<?=$dateself2?>','<?=$result_seDateSelfCheck2['DATERK']?>','<?=$result_seDateSelfCheck2['DATEPRESENT']?>','<?= $result_seEmployee['nameT']?>');" name="btnSend" id="btnSend" value="ดูข้อมูลการ Self Check" class="btn btn-primary"></th>
                                                    <?php
                                                    }
                                                    ?>
                                                    
                                                    <?php
                                                    $emp = ($_GET['employeecode1'] != "") ? $_GET['employeecode1'] : $_GET['employeecode2'];
                                                    if ($emp != "") {
                                                        ?>
                                                        <div class="col-lg-10 text-right">

                                                        <th colspan = "4" style="width:160px;background-color: coral;border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left"><a href="pdf_reportemployee4_1.php?employeecode=<?= $emp ?>&tenkomasterid=<?= $result_seTenkomaster_temp['TENKOMASTERID'] ?>&vehicletransportplanid=<?= $_GET['vehicletransportplanid'] ?>&selfcheckid=<?= $result_seSelfCheck2['SELFCHECKID'] ?>"  target ="_blank" class="btn btn-default">พิมพ์เอกสารเท็งโกะ พขร.2<li class="fa fa-print"></li></a></th> 
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;border-collapse: collapse;background-color: #c9c9c9;text-align: center;padding: 5px">R(ข้างขวา)</td>
                                                <td style="border: 1px solid black;border-collapse: collapse;background-color: #c9c9c9;text-align: center;padding: 5px">L(ข้างซ้าย)</td>
                                                <td style="border: 1px solid black;border-collapse: collapse;background-color: #c9c9c9;text-align: center;padding: 5px">R(ข้างขวา)</td>
                                                <td style="border: 1px solid black;border-collapse: collapse;background-color: #c9c9c9;text-align: center;padding: 5px">L(ข้างซ้าย)</td>
                                                <td style="border: 1px solid black;border-collapse: collapse;background-color: #c9c9c9;text-align: center;padding: 5px">R(ข้างขวา)</td>
                                                <td style="border: 1px solid black;border-collapse: collapse;background-color: #c9c9c9;text-align: center;padding: 5px">L(ข้างซ้าย)</td>
                                                <!--ใบขับขี่  -->
                                                <td colspan = "4" style="border: 1px solid black;border-collapse: collapse;background-color: #c9c9c9;text-align: left;padding: 5px"><b>วันออกบัตร</b></td>
                                                <td colspan = "4" style="border: 1px solid black;border-collapse: collapse;text-align: left;padding: 5px"><b><?=$year21start?><?=$year22start?></b></td>
                                                <td colspan = "4" style="border: 1px solid black;border-collapse: collapse;text-align: left;padding: 5px"><b>SelfCheckID: <?=$result_seSelfCheck2['SELFCHECKID']?></b></td>
                                                <!-- เอกสารเท็งโกะ -->
                                                <td colspan = "4" style="border: 1px solid black;border-collapse: collapse;text-align: center;padding: 5px"><button type="button" class="btn btn-primary btn-md" name="myBtn" id ="myBtn" data-toggle="modal" data-target="#myModalinsert"  >ข้อมูล Simulator พขร.2</button></td>
                                            
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;border-collapse: collapse;text-align: center;padding: 5px"><?=$result_sehealth['SHORTSIGHT_R']?></td>
                                                <td style="border: 1px solid black;border-collapse: collapse;text-align: center;padding: 5px"><?=$result_sehealth['SHORTSIGHT_L']?></td>
                                                <td style="border: 1px solid black;border-collapse: collapse;text-align: center;padding: 5px"><?=$result_sehealth['LONGSIGHT_R']?></td>
                                                <td style="border: 1px solid black;border-collapse: collapse;text-align: center;padding: 5px"><?=$result_sehealth['LONGSIGHT_L']?></td>
                                                <td style="border: 1px solid black;border-collapse: collapse;text-align: center;padding: 5px"><?=$result_sehealth['OBLIQUESIGHT_R']?></td>
                                                <td style="border: 1px solid black;border-collapse: collapse;text-align: center;padding: 5px"><?=$result_sehealth['OBLIQUESIGHT_L']?></td>
                                                <!--ใบขับขี่  -->
                                                <td colspan = "4" style="border: 1px solid black;border-collapse: collapse;background-color: #c9c9c9;text-align: left;padding: 5px"><b>วันหมดอายุ</b></td>
                                                <td colspan = "4" style="border: 1px solid black;border-collapse: collapse;text-align: left;padding: 5px;<?= $licensechk2?>" ><b><?=$year21end?><?=$year22end?></b></td>
                                                <td style="width:160px;border: 1px solid black;border-collapse: collapse;text-align: left;padding: 5px"><b><input style="width:160px;" type="button" onclick="se_graphdatacheck('<?= $_GET['employeecode2'] ?>');" name="btnSend" id="btnSend" value="ดูกราฟข้อมูลสุขภาพ" class="btn btn-primary"></b></td>
                                                <!-- เอกสารเท็งโกะ -->
                                                <td colspan = "4" style="border: 1px solid black;border-collapse: collapse;text-align: center;padding: 5px"><button type="button" class="btn btn-primary btn-md" name="myBtn" id ="myBtn" data-toggle="modal" data-target="#myModalFeedback">ข้อมูล Feedback พขร.2</button></td>
                                            </tr>
                                        </table>    
                                        <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                            <thead>
                                                <tr>

                                                    <th  colspan="7" ><input type="button" onclick="commit_1('<?=$result_seSelfCheck2['SELFCHECKID']?>')" class="btn btn-success" value="Commit2_Before"> </th>

                                                    <!-- <th  colspan="7" ><input type="button" onclick="commit_1('<?=$result_seSelfCheck2['SELFCHECKID']?>')" class="btn btn-success" value="Commit2_Before"> <font style="color: green">พนักงานขับรถ : <?=$sex?> <?= $result_sePlain['EMPLOYEENAME2'] ?></font></th> -->


                                                    <th width="65">เจ้าหน้าที่</th>
                                                    <th width="144" ><?= $result_seEmployee["nameT"] ?></th>
                                                    <th width="40">พขร.</th>
                                                    <th width="144" ><?= $result_sePlain['EMPLOYEENAME2'] ?></th>
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
                                                    <td>การทักทายก่อนเริ่มเท็งโกะ</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check11 ?>  id="chk_11" name="chk_11"  style="transform: scale(2)"/></td>
                                                    <td colspan="2" >ทักทายอย่างมีชีวิตชีวา</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs111 ?> style="transform: scale(2)" id="chk_rs111" name="chk_rs111" onchange="edit_rs111()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs110 ?> style="transform: scale(2)" id="chk_rs110" name="chk_rs110" onchange="edit_rs110()"/></td>
                                                    <td colspan="4" ><input type="text" id="txt_remark11" name="txt_remark11" class="form-control" value="<?= $result_seTenkobefore['TENKOBEFOREGREETREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">2</td>
                                                    <td>ตรวจเซ็คยูนิฟอร์ม</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check12 ?> id="chk_12" name="chk_12"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">สวมชุดที่สะอาด ไม่ใส่เครื่องประดับที่อาจทำให้เกิดรอย</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs121 ?> style="transform: scale(2)" id="chk_rs121" name="chk_rs121" onchange="edit_rs121()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs120 ?> style="transform: scale(2)" id="chk_rs120" name="chk_rs120" onchange="edit_rs120()"/></td>
                                                    <td colspan="4"  ><input type="text" id="txt_remark12" name="txt_remark12" class="form-control" value="<?= $result_seTenkobefore['TENKOUNIFORMREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">3</td>
                                                    <td>ตรวจสอบสภาพร่างกาย</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check13 ?> id="chk_13" name="chk_13"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">สุขภาพร่างกายแข็งแรงดี</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs131 ?> style="transform: scale(2)" id="chk_rs131" name="chk_rs131" onchange="edit_rs131()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs130 ?> style="transform: scale(2)" id="chk_rs130" name="chk_rs130" onchange="edit_rs130()"/></td>
                                                    <td colspan="4"  ><input type="text" id="txt_remark13" name="txt_remark13" class="form-control" value="<?= $result_seTenkobefore['TENKOBODYREMARK'] ?>"></td>
                                                </tr>

                                                <tr>
                                                    <!-- ตรวจสอบระยะการพักผ่อนคนที่2 -->
                                                    <td style="text-align: center">4</td>
                                                    <td>ตรวจสอบระยะการพักผ่อน</td>
                                                    <!-- <td style="text-align: center"><input type="checkbox"  <?= $check14 ?> id="chk_14" name="chk_14"  style="transform: scale(2)"/></td> -->
                                                    <?php
                                                    if ($TIMESLEEPREST2 == '0') {
                                                    ?>
                                                    <td style="text-align: center"><input type="checkbox" disabled=""  id="chk_14" name="chk_14"  style="transform: scale(2)"/></td>    
                                                    <?php
                                                    }else {
                                                    ?>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" checked  id="chk_14" name="chk_14"  style="transform: scale(2)"/></td>
                                                    <?php
                                                    }
                                                    ?>

                                                    <td>ตั้งแต่ 8 ชั่วโมง <b>พขร.2</b></td>
                                                    <td>
                                                        <label>ชั่วโมงการพักผ่อน</label>
                                                        <?php
                                                        if ($TIMESLEEPREST2 == '0') {
                                                        ?>
                                                        <input type="text" readonly="" class="form-control"  id="txt_rs14" name="txt_rs14" value="" ></td>    
                                                        <?php
                                                        }else if ($TIMESLEEPREST2 >= '8') {
                                                        ?>
                                                        <input type="text" readonly="" style="background-color: #94FA67;" class="form-control"  id="txt_rs14" name="txt_rs14" value="<?= $result_seSelfCheck2['TIMESLEEPREST'] ?>" ></td>
                                                        <?php
                                                        }else {
                                                        ?>
                                                        <input type="text" readonly="" style="background-color: #FA6767;" class="form-control"  id="txt_rs14" name="txt_rs14" value="<?= $result_seSelfCheck2['TIMESLEEPREST'] ?>" ></td>
                                                        <?php
                                                        }
                                                        ?>

                                                        <?php 
                                                        if (($result_seSelfCheck2['SLEEPRESTSTART'] == '' || $result_seSelfCheck2['SLEEPRESTSTART'] == '<br /><b>Warning</b>:  sqlsrv_fetch_array() expects parameter 1 to be resource, boolean given in <b>' || 
                                                            $result_seSelfCheck2['SLEEPRESTEND'] == ''   || $result_seSelfCheck2['SLEEPRESTEND'] == '<br /><b>Warning</b>:  sqlsrv_fetch_array() expects parameter 1 to be resource, boolean given in <b>') || ($TIMESLEEPREST2 <'8')  ) {
                                                        ?>
                                                        <td style="text-align: center"><input disabled="" type="checkbox"         style="transform: scale(2)" id="chk_rs141" name="chk_rs141" onchange="edit_rs141()"/></td>
                                                        <td style="text-align: center"><input disabled="" type="checkbox" checked style="transform: scale(2)" id="chk_rs140" name="chk_rs140" onchange="edit_rs140()"/></td>
                                                        <?php
                                                        }else {
                                                        ?>
                                                        <td style="text-align: center"><input disabled="" type="checkbox" checked style="transform: scale(2)" id="chk_rs141" name="chk_rs141" onchange="edit_rs141()"/></td>
                                                        <td style="text-align: center"><input disabled="" type="checkbox"         style="transform: scale(2)" id="chk_rs140" name="chk_rs140" onchange="edit_rs140()"/></td>
                                                        <?php
                                                        }
                                                        ?>
                                                     </td>   
                                                    <td colspan="2" >
                                                        <!-- พักผ่อน 8 ชั่วโมงคนที่2 -->
                                                        <label>เวลาเริ่มพักผ่อน(8 ชั่วโมง)</label>
                                                        <input disabled="" type="datetime-local" id="txt_remark14" name="txt_remark14" class="form-control" value="<?= $result_seSelfCheck2['SLEEPRESTSTART'] ?>" style="">
                                                        <!-- <input type="button"  data-toggle="modal"  data-target="#modal_tenkorestremark" id="btn_remark14" name="btn_remark14" class="btn btn-default" value="<?= $result_seTenkobefore['TENKORESTREMARK'] ?>"> -->
                                                    </td>
                                                    <td colspan="2" >
                                                        <!--  พักผ่อน 8 ชั่วโมงคนที่2 -->
                                                        <label>เวลาตื่นพักผ่อน(8 ชั่วโมง)</label>
                                                        <input disabled="" type="datetime-local" id="txt_remark14" name="txt_remark14" class="form-control" value="<?= $result_seSelfCheck2['SLEEPRESTEND'] ?>" style="">
                                                        <!-- <input type="button"  data-toggle="modal"  data-target="#modal_tenkorestremark" id="btn_remark14" name="btn_remark14" class="btn btn-default" value="<?= $result_seTenkobefore['TENKORESTREMARK'] ?>"> -->
                                                    </td>   
                                                </tr>
                                                <tr>    
                                                    <td rowspan="2" style="text-align: center">5</td>
                                                    <td rowspan="2">ตรวจสอบชั่วโมงการนอนหลับ2</td>
                                                    <!-- <td style="text-align: center"><input type="checkbox"  <?= $check14 ?> id="chk_14" name="chk_14"  style="transform: scale(2)"/></td> -->
                                                    <?php
                                                    if ($TIMESLEEPNORMAL2 == '0') {
                                                    ?>
                                                    <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox"  id="chk_15" name="chk_15"  style="transform: scale(2)"/></td>    
                                                    <?php
                                                    }else {
                                                    ?>
                                                    <td rowspan="2" style="text-align: center"><input disabled="" checked type="checkbox"  id="chk_15" name="chk_15"  style="transform: scale(2)"/></td>
                                                    <?php
                                                    }
                                                    ?>
                                                    
                                                    <td>การนอนปกติ ตั้งแต่ 6 ชั่วโมงขึ้นไป <b>พขร.2</b></td>
                                                    <!--<td><input type="text"
                                                               onKeyUp="if (isNaN(this.value)) {
                                                                           alert('กรุณากรอกตัวเลข');
                                                                           this.value = '0';
                                                                       } else {
                                                                           edit_tenkobeforetxt2(this.value, 'TENKOSLEEPTIMEDATA_AFTER6H', '<?//= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                       }"
                                                               class="form-control" id="txt_rs151" name="txt_rs151" value="<?//= $result_seTenkobefore['TENKOSLEEPTIMEDATA_AFTER6H'] ?>"></td>-->
                                                    <td>
                                                        <label>ชั่วโมงการนอน</label>
                                                        <!-- <input readonly="" type="text" class="form-control" id="txt_rs151" name="txt_rs151" value="<?= $result_seSelfCheck2['TIMESLEEPNORMAL'] ?>"></td> -->
                                                        <?php
                                                        if ($TIMESLEEPNORMAL2 == '0') {
                                                        ?>
                                                        <input readonly="" type="text" class="form-control" id="txt_rs151" name="txt_rs151" value=""></td>    
                                                        <?php
                                                        }else if ($TIMESLEEPNORMAL2 >= '6') {
                                                        ?>
                                                        <input readonly="" style="background-color: #94FA67;" type="text" class="form-control" id="txt_rs151" name="txt_rs151" value="<?= $result_seSelfCheck2['TIMESLEEPNORMAL'] ?>"></td>
                                                        <?php
                                                        }else {
                                                        ?>
                                                        <input readonly="" style="background-color: #FA6767;" type="text" class="form-control" id="txt_rs151" name="txt_rs151" value="<?= $result_seSelfCheck2['TIMESLEEPNORMAL'] ?>"></td>
                                                        <?php
                                                        }
                                                        ?>
                                                        
                                                        <?php 
                                                            if (($result_seSelfCheck2['SLEEPNORMALSTART'] == '' || $result_seSelfCheck2['SLEEPNORMALSTART'] == '<br /><b>Warning</b>:  sqlsrv_fetch_array() expects parameter 1 to be resource, boolean given in <b>' || 
                                                                $result_seSelfCheck2['SLEEPNORMALEND'] == ''   || $result_seSelfCheck2['SLEEPNORMALEND'] == '<br /><b>Warning</b>:  sqlsrv_fetch_array() expects parameter 1 to be resource, boolean given in <b>') || ($TIMESLEEPNORMAL2 <'6')   ) {
                                                            ?>
                                                            <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox"         style="transform: scale(2)" id="chk_rs151" name="chk_rs151" onchange="edit_rs151()"/></td>
                                                            <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox" checked style="transform: scale(2)" id="chk_rs150" name="chk_rs150" onchange="edit_rs150()"/></td>
                                                            <?php
                                                            }else {
                                                            ?>
                                                            <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox" checked style="transform: scale(2)" id="chk_rs151" name="chk_rs151" onchange="edit_rs151()"/></td>
                                                            <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox"         style="transform: scale(2)" id="chk_rs150" name="chk_rs150" onchange="edit_rs150()"/></td>
                                                            <?php
                                                            }
                                                            ?>
                                                    


                                                    
                                                    
                                                        <!--<td colspan="4" rowspan="2" contenteditable="true" onkeyup="edit_tenkobefore(this, 'TENKOSLEEPTIMEREMARK', '<?//= $result_seTenkobefore['TENKOBEFOREID'] ?>')"><?//= $result_seTenkobefore['TENKOSLEEPTIMEREMARK'] ?></td>-->
                                                    
                                                        <td colspan="2" rowspan="2">
                                                            <!-- นอน 6 ชั่วโมงคนที่2 -->
                                                            <label>เวลาเริ่มนอน(6 ชั่วโมง)</label>
                                                            <input disabled="" type="datetime-local" id="txt_remark15" name="txt_remark15" class="form-control" value="<?= $result_seSelfCheck2['SLEEPNORMALSTART'] ?>" style="">
                                                        <!-- <input type="button"  data-toggle="modal"  data-target="#modal_tenkosleeptimeremark" id="btn_remark15" name="btn_remark15" class="btn btn-default" value="<?= $result_seTenkobefore['TENKOSLEEPTIMEREMARK'] ?>"> -->
                                                            <!-- นอน 4 ชั่วโมงครึ่งคนที่2 -->
                                                            <label>เวลาเริ่มนอนเพิ่ม(4 ชั่วโมงครึ่ง)</label>
                                                            <input disabled="" type="datetime-local" id="txt_remark15" name="txt_remark15" class="form-control" value="<?= $result_seSelfCheck2['SLEEPEXTRASTART'] ?>" style="">
                                                        </td>
                                                        <td colspan="2"rowspan="2">
                                                            <!-- นอน 6 ชั่วโมงคนที่2 -->
                                                            <label>เวลาตื่นนอน(6 ชั่วโมง)</label>
                                                            <input disabled="" type="datetime-local" id="txt_remark15" name="txt_remark15" class="form-control" value="<?= $result_seSelfCheck2['SLEEPNORMALEND'] ?>" style="">
                                                        <!-- <input type="button"  data-toggle="modal"  data-target="#modal_tenkosleeptimeremark" id="btn_remark15" name="btn_remark15" class="btn btn-default" value="<?= $result_seTenkobefore['TENKOSLEEPTIMEREMARK'] ?>"> -->
                                                            <!-- นอน 4 ชั่วโมงครึ่งคนที่2 -->
                                                            <label>เวลาตื่นนอน(4 ชั่วโมงครึ่ง)</label>
                                                            <input disabled="" type="datetime-local" id="txt_remark15" name="txt_remark15" class="form-control" value="<?= $result_seSelfCheck2['SLEEPEXTRAEND'] ?>" style="">
                                                         </td>   
                                                     </td>        
                                                </tr>


                                                <tr>
                                                    <td>การนอนเพิ่ม (กะกลางคืน) ตั้งแต่ 4.5 ชั่วโมงขึ้นไป <b>พขร.2</b></td>

                                                    <!-- <td><input type="text" class="form-control" id="txt_rs152" name="txt_rs152"
                                                               onKeyUp="if (isNaN(this.value)) {
                                                                           alert('กรุณากรอกตัวเลข');
                                                                           this.value = '0';
                                                                       } else {
                                                                           edit_tenkobeforetxt3()
                                                                       }"
                                                               value="<?= $result_seTenkobefore['TENKOSLEEPTIMEDATA_ADD45H'] ?>"></td> -->

                                                               <td>
                                                        <?php
                                                        //echo $result_seSelfCheck['TIMESLEEPEXTRA']; 
                                                        if ($TIMESLEEPEXTRAHOURCHK2 == '0') {
                                                            // echo '1';
                                                        ?>
                                                            <input readonly  type="text" class="form-control" id="txt_rs152" name="txt_rs152" value= "" autocomplete="off">
                                                        <?php
                                                        }else if ($TIMESLEEPEXTRAHOURCHK2 == 'HG4') { //เช็คชั่วโมง ต้องมากกว่า 4 ชั่วโมง กรณีเท่ากับ 4 
                                                            // echo '2';
                                                            if ($TIMESLEEPEXTRAMINCHK2 == 'MG3') { //เช็คชนาที ต้องมากกว่า 30 นาที กรณีเท่ากับ 4เช็ค นาทีต่อ
                                                            ?>
                                                            <input readonly style="background-color: #94FA67;" type="text" class="form-control" id="txt_rs152" name="txt_rs152"value="<?= $result_seSelfCheck2['TIMESLEEPEXTRA'] ?>">
                                                            
                                                            <?php
                                                            }else {
                                                            ?>
                                                            <input readonly style="background-color: #FA6767;" type="text" class="form-control" id="txt_rs152" name="txt_rs152"value="<?= $result_seSelfCheck2['TIMESLEEPEXTRA'] ?>">
                                                            
                                                            <?php
                                                            }
                                                        ?>
                                                            
                                                        <?php
                                                        }else if ($TIMESLEEPEXTRAHOURCHK2 == 'HGG4') { //เช็คชั่วโมง ต้องมากกว่า 4 ชั่วโมง
                                                            // echo '3';
                                                        ?>
                                                            <input readonly style="background-color: #94FA67;" type="text" class="form-control" id="txt_rs152" name="txt_rs152"value="<?= $result_seSelfCheck2['TIMESLEEPEXTRA'] ?>">
                                                            
                                                        <?php
                                                        }else {
                                                            // echo '4';
                                                        ?>
                                                            <input readonly style="background-color: #FA6767;" type="text" class="form-control" id="txt_rs152" name="txt_rs152"value="<?= $result_seSelfCheck2['TIMESLEEPEXTRA'] ?>">
                                                        <?php
                                                        }
                                                        ?>
                                                    
                                                    </td>            
                                                </tr>


                                                <?php
                                                // พขร.คนที่2
                                                if ($result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKL' || $result_sePlain['COMPANYCODE'] == 'RCC' || $result_sePlain['COMPANYCODE'] == 'RRC' || $result_sePlain['COMPANYCODE'] == 'RATC') {
                                                    ?>
                                                    <tr>
                                                        <td style="text-align: center">6</td>
                                                        <td>ตรวจเช็คอุณหภูมิ2</td>
                                                        <td style="text-align: center"><input disabled="" type="checkbox" id="chk_16" <?= $check16 ?> name="chk_16"  style="transform: scale(2)"/></td>
                                                        <td>ต่ำกว่า 37 องศา</td>
                                                        <td><input type="text" class="form-control" id="txt_rs16" name="txt_rs16" value="<?= $result_seTenkobefore['TENKOTEMPERATUREDATA'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '0';
                                                                           } else {
                                                                               edit_tenkobeforetxt4(this.value, 'TENKOTEMPERATUREDATA', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                               update_selfcheck(this.value, 'TEMPERATURE', '<?= $result_seSelfCheck2['SELFCHECKID'] ?>')
                                                                           }"
                                                                   
                                                                   ></td>
                                                        <td style="text-align: center"><input disabled="" type="checkbox" <?= $rs161 ?> style="transform: scale(2)" id="chk_rs161" name="chk_rs161" onchange="edit_rs161()"/></td>
                                                        <td style="text-align: center"><input disabled="" type="checkbox" <?= $rs160 ?> style="transform: scale(2)" id="chk_rs160" name="chk_rs160" onchange="edit_rs160()"/></td>
                                                        <td colspan="4"  ><input type="text" id="txt_remark16" name="txt_remark16" class="form-control" value="<?= $result_seTenkobefore['TENKOTEMPERATUREREMARK'] ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="3" style="text-align: center">7</td>
                                                        <td rowspan="3">วัดความดัน</td>
                                                        <td rowspan="3" style="text-align: center"><input disabled="" type="checkbox" <?= $check17 ?> id="chk_17" name="chk_17"  style="transform: scale(2)"/></td>
                                                        <td>บน : 90-150</td>
                                                        <td><input type="text" class="form-control" id="txt_rs171" name="txt_rs171" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_90160'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt5()
                                                                               update_selfcheck(this.value, 'SYSVALUE1', '<?= $result_seSelfCheck2['SELFCHECKID'] ?>')
                                                                           }"
                                                                   ><input type="text" class="form-control" id="txt_rs171_2" name="txt_rs171_2" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_90160_2'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt5_2(this.value, 'TENKOPRESSUREDATA_90160_2', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                               update_selfcheck(this.value, 'SYSVALUE2', '<?= $result_seSelfCheck2['SELFCHECKID'] ?>')
                                                                           }"
                                                                   ><input type="text" class="form-control" id="txt_rs171_3" name="txt_rs171_3" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_90160_3'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt5_3(this.value, 'TENKOPRESSUREDATA_90160_3', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                               update_selfcheck(this.value, 'SYSVALUE3', '<?= $result_seSelfCheck2['SELFCHECKID'] ?>')
                                                                           }"
                                                                   ></td>
                                                        <td rowspan="3" style="text-align: center"><input disabled="" type="checkbox" <?= $rs171 ?> style="transform: scale(2)" id="chk_rs171" name="chk_rs171" onchange="edit_rs171()"/></td>
                                                        <td rowspan="3" style="text-align: center"><input disabled="" type="checkbox" <?= $rs170 ?> style="transform: scale(2)" id="chk_rs170" name="chk_rs170" onchange="edit_rs170()"/></td>
                                                        <td colspan="4" rowspan="2" ><input type="text" id="txt_remark17" name="txt_remark17" class="form-control" value="<?= $result_seTenkobefore['TENKOPRESSUREREMARK'] ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>ล่าง : 60-95</td>
                                                        <td><input type="text" class="form-control" id="txt_rs172" name="txt_rs172" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60100'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt6()
                                                                               update_selfcheck(this.value, 'DIAVALUE1', '<?= $result_seSelfCheck2['SELFCHECKID'] ?>')
                                                                           }"
                                                                   ><input type="text" class="form-control" id="txt_rs172_2" name="txt_rs172_2" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60100_2'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt6_2()
                                                                               update_selfcheck(this.value, 'DIAVALUE2', '<?= $result_seSelfCheck2['SELFCHECKID'] ?>')
                                                                           }"
                                                                   ><input type="text" class="form-control" id="txt_rs172_3" name="txt_rs172_3" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60100_3'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt6_3()
                                                                               update_selfcheck(this.value, 'DIAVALUE3', '<?= $result_seSelfCheck2['SELFCHECKID'] ?>')
                                                                           }"
                                                                   ></td>

                                                    </tr>
                                                    <tr>
                                                    <!-- พขรคนที่2 -->
                                                        <td>อัตราการเต้นหัวใจ : 60-100 ครั้ง</td>
                                                        <td><input type="text" class="form-control" id="txt_rs173" name="txt_rs173" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60110'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt20()
                                                                               update_selfcheck(this.value, 'PULSEVALUE1', '<?= $result_seSelfCheck2['SELFCHECKID'] ?>')
                                                                           }"
                                                                   ><input type="text" class="form-control" id="txt_rs173_2" name="txt_rs173_2" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60110_2'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt20_2()
                                                                               update_selfcheck(this.value, 'PULSEVALUE2', '<?= $result_seSelfCheck2['SELFCHECKID'] ?>')
                                                                           }"
                                                                   ><input type="text" class="form-control" id="txt_rs173_3" name="txt_rs173_3" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60110_3'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt20_3()
                                                                               update_selfcheck(this.value, 'PULSEVALUE3', '<?= $result_seSelfCheck2['SELFCHECKID'] ?>')
                                                                           }"
                                                                   ></td>

                                                    </tr>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <!-- <tr>
                                                        <td style="text-align: center">6</td>
                                                        <td>ตรวจเช็คอุณหภูมิ</td>
                                                        <td style="text-align: center"><input disabled="" type="checkbox" id="chk_16" <?= $check16 ?> name="chk_16"  style="transform: scale(2)"/></td>
                                                        <td>ต่ำกว่า 37 องศา</td>
                                                        <td><input type="text" class="form-control" id="txt_rs16" name="txt_rs16" value="<?= $result_seTenkobefore['TENKOTEMPERATUREDATA'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '0';
                                                                           } else {
                                                                               edit_tenkobeforetxt4(this.value, 'TENKOTEMPERATUREDATA', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                           }"
                                                                   ></td>
                                                        <td style="text-align: center"><input disabled="" type="checkbox" <?= $rs161 ?> style="transform: scale(2)" id="chk_rs161" name="chk_rs161" onchange="edit_rs161()"/></td>
                                                        <td style="text-align: center"><input disabled="" type="checkbox" <?= $rs160 ?> style="transform: scale(2)" id="chk_rs160" name="chk_rs160" onchange="edit_rs160()"/></td>
                                                        <td colspan="4" ><input type="text" id="txt_remark16" name="txt_remark16" class="form-control" value="<?= $result_seTenkobefore['TENKOTEMPERATUREREMARK'] ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" style="text-align: center">7</td>
                                                        <td rowspan="2">วัดความดัน</td>
                                                        <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox" <?= $check17 ?> id="chk_17" name="chk_17" style="transform: scale(2)"/></td>
                                                        <td>บน : 90-150</td>
                                                        <td><input type="text" class="form-control" id="txt_rs171" name="txt_rs171" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_90160'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt5(this.value, 'TENKOPRESSUREDATA_90160', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                           }"
                                                                   ><input type="text" class="form-control" id="txt_rs171_2" name="txt_rs171_2" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_90160_2'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt5_2(this.value, 'TENKOPRESSUREDATA_90160_2', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                           }"
                                                                   ><input type="text" class="form-control" id="txt_rs171_3" name="txt_rs171_3" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_90160_3'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt5_3(this.value, 'TENKOPRESSUREDATA_90160_3', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                           }"
                                                                   ></td>
                                                        <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox" <?= $rs171 ?> style="transform: scale(2)" id="chk_rs171" name="chk_rs171" onchange="edit_rs171()"/></td>
                                                        <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox" <?= $rs170 ?> style="transform: scale(2)" id="chk_rs170" name="chk_rs170" onchange="edit_rs170()"/></td>
                                                        <td colspan="4" rowspan="2" onkeyup="edit_tenkobefore(this, 'TENKOPRESSUREREMARK', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')"><input type="text" id="txt_remark17" name="txt_remark17" class="form-control" value="<?= $result_seTenkobefore['TENKOPRESSUREREMARK'] ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>ล่าง : 60-95</td>
                                                        <td><input type="text" class="form-control" id="txt_rs172" name="txt_rs172" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60100'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt6(this.value, 'TENKOPRESSUREDATA_60100', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                           }"
                                                                   ><input type="text" class="form-control" id="txt_rs172_2" name="txt_rs172_2" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60100_2'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt6_2(this.value, 'TENKOPRESSUREDATA_60100_2', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                           }"
                                                                   ><input type="text" class="form-control" id="txt_rs172_3" name="txt_rs172_3" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60100_3'] ?>"
                                                                   onKeyUp="if (isNaN(this.value)) {
                                                                               alert('กรุณากรอกตัวเลข');
                                                                               this.value = '';
                                                                           } else {
                                                                               edit_tenkobeforetxt6_3(this.value, 'TENKOPRESSUREDATA_60100_3', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                           }"
                                                                   >
                                                            <input type="text" style="display: none" id="txt_rs173" name="txt_rs173">
                                                            <input type="text" style="display: none" id="txt_rs173_2" name="txt_rs173">
                                                            <input type="text" style="display: none" id="txt_rs173_3" name="txt_rs173">
                                                        </td>

                                                    </tr> -->

                                                    <?php
                                                }
                                                ?>
                                                <tr>
                                                    <td style="text-align: center">8</td>
                                                    <td>ตรวจเช็คแอลกอฮอล์</td>
                                                    <td style="text-align: center"><input disabled="" type="checkbox" id="chk_18" <?= $check18 ?> name="chk_18"  style="transform: scale(2)"/></td>
                                                    <td>[0]</td>
                                                    <td><input type="text" class="form-control" id="txt_rs18" name="txt_rs18" value="<?= $result_seTenkobefore['TENKOALCOHOLDATA'] ?>"
                                                               onKeyUp="if (isNaN(this.value)) {
                                                                           alert('กรุณากรอกตัวเลข');
                                                                           this.value = '0';
                                                                       } else {
                                                                           edit_tenkobeforetxt7(this.value, 'TENKOALCOHOLDATA', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                       }"
                                                               ></td>

                                                    <td style="text-align: center"><input disabled="" type="checkbox" <?= $rs181 ?> style="transform: scale(2)" id="chk_rs181" name="chk_rs181" onchange="edit_rs181()"/></td>
                                                    <td style="text-align: center"><input disabled="" type="checkbox" <?= $rs180 ?> style="transform: scale(2)" id="chk_rs180" name="chk_rs180" onchange="edit_rs180()"/></td>
                                                    <td colspan="4"   ><input type="text" id="txt_remark18" name="txt_remark18" class="form-control" value="<?= $result_seTenkobefore['TENKOALCOHOLREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">9</td>
                                                    <td>สอบถามเรื่องกังวลใจ</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check19 ?> id="chk_19" name="chk_19"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">ไม่มีเรื่องกังวลใจ</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs191 ?> style="transform: scale(2)" id="chk_rs191" name="chk_rs191" onchange="edit_rs191()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs190 ?> style="transform: scale(2)" id="chk_rs190" name="chk_rs190" onchange="edit_rs190()"/></td>
                                                    <td colspan="4"   ><input type="text" id="txt_remark19" name="txt_remark19" class="form-control" value="<?= $result_seTenkobefore['TENKOWORRYREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">10</td>
                                                    <td>ใบตรวจเทรลเลอร์ประจำวัน</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check110 ?> id="chk_110" name="chk_110"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">ไม่มีหัวข้อผิดปกติ</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs1101 ?> style="transform: scale(2)" id="chk_rs1101" name="chk_rs1101" onchange="edit_rs1101()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1100 ?> style="transform: scale(2)" id="chk_rs1100" name="chk_rs1100" onchange="edit_rs1100()"/></td>
                                                    <td colspan="4"  ><input type="text" id="txt_remark110" name="txt_remark110" class="form-control" value="<?= $result_seTenkobefore['TENKODAILYTRAILERREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">11</td>
                                                    <td>ตรวจสอบของที่พกพา</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check111 ?> id="chk_111" name="chk_111" style="transform: scale(2)"/></td>
                                                    <td colspan="2">ใบอนุญาติขับขี่,ใบอนุญาติ (ผู้รับเหมา),ใบอนุญาติ (โฟล์คลิฟท์),ใบอนุญาติ (TLEP),ใบอนุญาติ (Trailer),โทรศัพท์,สายสมอลทอร์ค</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs1111 ?> style="transform: scale(2)" id="chk_rs1111" name="chk_rs1111" onchange="edit_rs1111()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1110 ?> style="transform: scale(2)" id="chk_rs1110" name="chk_rs1110" onchange="edit_rs1110()"/></td>
                                                    <td colspan="4"   ><input type="text" id="txt_remark111" name="txt_remark111" class="form-control" value="<?= $result_seTenkobefore['TENKOCARRYREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">12</td>
                                                    <td>ตรวจสอบรายละเอียดการทำงาน</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check112 ?> id="chk_112" name="chk_112"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">เข้าใจเส้นทาง,จุดพักรถ,รูปแบบการขับขี่,ความสำคัญในการส่งรถ</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs1121 ?> style="transform: scale(2)" id="chk_rs1121" name="chk_rs1121" onchange="edit_rs1121()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1120 ?> style="transform: scale(2)" id="chk_rs1120" name="chk_rs1120" onchange="edit_rs1120()"/></td>
                                                    <td colspan="4"  ><input type="text" id="txt_remark112" name="txt_remark112" class="form-control" value="<?= $result_seTenkobefore['TENKOJOBDETAILREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">13</td>
                                                    <td>แจ้งสภาพถนน</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check113 ?> id="chk_113" name="chk_113"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">เข้าใจเนื้อหาที่แจ้ง</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs1131 ?> style="transform: scale(2)" id="chk_rs1131" name="chk_rs1131" onchange="edit_rs1131()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1130 ?> style="transform: scale(2)" id="chk_rs1130" name="chk_rs1130" onchange="edit_rs1130()"/></td>
                                                    <td colspan="4"   ><input type="text" id="txt_remark113" name="txt_remark113" class="form-control" value="<?= $result_seTenkobefore['TENKOLOADINFORMREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">14</td>
                                                    <td>แจ้งสภาพอากาศ</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check114 ?> id="chk_114" name="chk_114"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">เข้าใจเนื้อหาที่แจ้ง</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs1141 ?> style="transform: scale(2)" id="chk_rs1141" name="chk_rs1141" onchange="edit_rs1141()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1140 ?> style="transform: scale(2)" id="chk_rs1140" name="chk_rs1140" onchange="edit_rs1140()"/></td>
                                                    <td colspan="4"   ><input type="text" id="txt_remark114" name="txt_remark114" class="form-control" value="<?= $result_seTenkobefore['TENKOAIRINFORMREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">15</td>
                                                    <td>แจ้งเรื่องโยโกะเด็น</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check115 ?> id="chk_115" name="chk_115"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">เข้าใจเนื้อหาที่แจ้ง</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs1151 ?> style="transform: scale(2)" id="chk_rs1151" name="chk_rs1151" onchange="edit_rs1151()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1150 ?> style="transform: scale(2)" id="chk_rs1150" name="chk_rs1150" onchange="edit_rs1150()"/></td>
                                                    <td colspan="4"   ><input type="text" id="txt_remark115" name="txt_remark115" class="form-control" value="<?= $result_seTenkobefore['TENKOYOKOTENREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">16</td>
                                                    <td>ตรวจสอบเป้าหมายการขับขี่จากเครื่องชิมูเลเตอร์</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check116 ?> id="chk_116" name="chk_116"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">ตรวจสอบกันทั้งสองฝ่าย</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs1161 ?> style="transform: scale(2)" id="chk_rs1161" name="chk_rs1161" onchange="edit_rs1161()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1160 ?> style="transform: scale(2)" id="chk_rs1160" name="chk_rs1160" onchange="edit_rs1160()"/></td>
                                                    <td colspan="4" ><input type="text" id="txt_remark116" name="txt_remark116" class="form-control" value="<?= $result_seTenkobefore['TENKOCHIMOLATORREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">17</td>
                                                    <td>สามารถวิ่งงานได้หรือไม่</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check117 ?> id="chk_117" name="chk_117" style="transform: scale(2)"/></td>
                                                    <td colspan="2">ไม่มีข้อบกพร่องต่อการวิ่งงาน</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs1171 ?> style="transform: scale(2)" id="chk_rs1171" name="chk_rs1171" onchange="edit_rs1171()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1170 ?> style="transform: scale(2)" id="chk_rs1170" name="chk_rs1170" onchange="edit_rs1170()"/></td>
                                                    <td colspan="4" ><input type="text" id="txt_remark117" name="txt_remark117" class="form-control" value="<?= $result_seTenkobefore['TENKOTRANSPORTREMARK'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center">18</td>
                                                    <td>การทักทายหลังทำเท็งโกะเสร็จ</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $check118 ?> id="chk_118" name="chk_118"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">ทักทายอย่างมีชีวิตชีวา</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rs1181 ?> style="transform: scale(2)" id="chk_rs1181" name="chk_rs1181" onchange="edit_rs1181()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1180 ?> style="transform: scale(2)" id="chk_rs1180" name="chk_rs1180" onchange="edit_rs1180()"/></td>
                                                    <td colspan="4" ><input type="text" id="txt_remark118" name="txt_remark118" class="form-control" value="<?= $result_seTenkobefore['TENKOAFTERGREETREMARK'] ?>"></td>
                                                </tr>

                                                <tr>
                                                    <td rowspan="1" style="text-align: center">***</td>
                                                    <td rowspan="1">ตรวจเช็คออกซิเจนเลือด</td>
                                                    <td rowspan="1" style="text-align: center"><input disabled="" type="checkbox" <?= $check119 ?> id="chk_119" name="chk_119"  style="transform: scale(2)"/></td>
                                                    <td>ออกซิเจนในเลือดตั้งแต่ 98%</td>
                                                    <td><input type="text"
                                                               onKeyUp="if (isNaN(this.value)) {
                                                                           alert('กรุณากรอกตัวเลข');
                                                                           this.value = '0';
                                                                       } else {
                                                                           edit_tenkobeforetxt8(this.value, 'TENKOOXYGENDATA', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                           update_selfcheck(this.value, 'OXYGENVALUE', '<?= $result_seSelfCheck2['SELFCHECKID'] ?>')
                                                                       }"
                                                               class="form-control" id="txt_rs19" name="txt_rs19" value="<?= $result_seTenkobefore['TENKOOXYGENDATA'] ?>"></td>
                                                    <td rowspan="1" style="text-align: center"><input disabled="" type="checkbox" <?= $rs1191 ?> style="transform: scale(2)" id="chk_rs1191" name="chk_rs1191" onchange="edit_rs1191()"/></td>
                                                    <td rowspan="1" style="text-align: center"><input disabled="" type="checkbox" <?= $rs1190 ?> style="transform: scale(2)" id="chk_rs1190" name="chk_rs1190" onchange="edit_rs1190()"/></td>
                                                    <td colspan="4" rowspan="2"  ><input type="text" id="txt_remark119" name="txt_remark119" class="form-control" value="<?= $result_seTenkobefore['TENKOOXYGENREMARK'] ?>"></td>

                                                </tr>
                                                <!-- สายตาพนักงานคนที่2 -->
                                                <tr>
                                                    <td colspan="12" style="text-align: center;background-color: #e7e7e7;font-size: 15px;">ตรวจสอบปัญหาสุขภาพสายตาพนักงานคนที่2 :<font style="color:red"> *หากตัวหนังสือมีสีแดง หมายถึงมีปัญหาสุขภาพ เจ้าหน้าที่ต้องเน้นย้ำ และตรวจสอบแว่นสายตาของพนักงาน </font></td>
                                                    <input  class="form-control" type="hidden" id="txt_employeecode" name="txt_employeecode" value="<?=$_GET['employeecode2']?>">
                                                </tr>                      
                                                <tr>
                                                    <td colspan="1" style="text-align: center">1</td>
                                                    <?php
                                                    if ($result_sehealth['SHORTSIGHT'] == '1') {
                                                      ?>
                                                        <td><font style="color:red"> สายตาสั้น </font></td>
                                                      <?php  
                                                    }else{
                                                        ?>
                                                        <td>สายตาสั้น</td>
                                                        <?php
                                                    }
                                                    ?>
                                                    <td style="text-align: center"><input type="checkbox" <?= $checkshortsight ?> id="chk_shortsight" name="chk_shortsight"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
                                                    <td style="text-align: center"><input type="checkbox"  <?= $rsshortsightok ?> style="transform: scale(2)" id="chk_rsshortsightok" name="chk_rsshortsightok" onchange="edit_rsshortsightok()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rsshortsightng ?>  style="transform: scale(2)" id="chk_rsshortsightng" name="chk_rsshortsightng" onchange="edit_rsshortsightng()"/></td>

                                                    <td colspan="4" ><input type="text" id="txt_shortsightremark" name="txt_shortsightremark" class="form-control" value="<?= $result_seTenkobefore['TENKOAFTERGREETREMARK'] ?>"></td>
                                                </tr>                       
                                                <tr>
                                                    <td colspan="1" style="text-align: center">2</td>
                                                    <?php
                                                    if ($result_sehealth['LONGSIGHT'] == '1') {
                                                      ?>
                                                        <td><font style="color:red"> สายตายาว </font></td>
                                                      <?php  
                                                    }else{
                                                        ?>
                                                        <td>สายตายาว</td>
                                                        <?php
                                                    }
                                                    ?>
                                                    <td style="text-align: center"><input type="checkbox" <?= $checklongsight ?> id="chk_longsight" name="chk_longsight"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rslongsightok ?> style="transform: scale(2)" id="chk_rslongsightok" name="chk_rslongsightok" onchange="edit_rslongsightok()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rslongsightng ?> style="transform: scale(2)" id="chk_rslongsightng" name="chk_rslongsightng" onchange="edit_rslongsightng()"/></td>

                                                    <td colspan="4" ><input type="text" id="txt_longsightremark" name="txt_longsightremark" class="form-control" value="<?= $result_seTenkobefore['TENKOAFTERGREETREMARK'] ?>"></td>
                                                </tr>                       
                                                <tr>
                                                    <td colspan="1" style="text-align: center">3</td>
                                                    <?php
                                                    if ($result_sehealth['OBLIQUESIGHT'] == '1') {
                                                      ?>
                                                        <td><font style="color:red"> สายตาเอียง </font></td>
                                                      <?php  
                                                    }else{
                                                        ?>
                                                        <td>สายตาเอียง</td>
                                                        <?php
                                                    }
                                                    ?>
                                                    <td style="text-align: center"><input type="checkbox" <?= $checkobliquesight ?> id="chk_obliquesight" name="chk_obliquesight"  style="transform: scale(2)"/></td>
                                                    <td colspan="2">พนักงานพกแว่นสายตามาปฏิบัติงาน</td>
                                                    <td style="text-align: center"><input type="checkbox" <?= $rsobliquesightok ?> style="transform: scale(2)" id="chk_rsobliquesightok" name="chk_rsobliquesightok" onchange="edit_rsobliquesightok()"/></td>
                                                    <td style="text-align: center"><input type="checkbox" disabled="" <?= $rsobliquesightng ?> style="transform: scale(2)" id="chk_rsobliquesightng" name="chk_rsobliquesightng" onchange="edit_rsobliquesightng()"/></td>

                                                    <td colspan="4" ><input type="text" id="txt_obliquesightremark" name="txt_obliquesightremark" class="form-control" value="<?= $result_seTenkobefore['TENKOAFTERGREETREMARK'] ?>"></td>
                                                </tr>                        


                                            </tbody>
                                            <!--<tfoot>
                                                <tr>
                                                    <td>
                                                        <input type="button" class="btn btn-primary" onclick="before_checknull()" value="ตรวจสอบ">
                                                    </td>

                                                </tr>
                                            </tfoot>
                                            -->
                                        </table>
                                    </div>

                                    <div class="tab-pane fade" id="tenko2">
                                        <div id="data_tenko2emp2sr"></div>
                                    </div>
                                    <div class="tab-pane fade" id="tenko3">
                                            <table style="border: 1px solid black;border-collapse: collapse;">
                                                <tr>
                                                    <th colspan = "14" style="border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center">ลงข้อมูลเวลาวางกุญแจ หรือ เวลาพักผ่อน สำหรับพนักงานคนที่2<font style="color:red">  </font></th>  
                                                    <!-- <th colspan = "8" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: center">ข้อมูลวันหมดอายุใบขับขี่ พขร.2</th> 
                                                    <th colspan = "4" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: center">ตรวจสอบ พขร.2</th>
                                                    <th colspan = "4" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: center">เอกสารเท็งโก๊ะ พขร.2</th> -->
                                                </tr>
                                                <tr>
                                                    <?php

                                                    $KEYDROPTIME2 = str_replace("T"," ",$result_seSelfCheck2['KEYDROPTIME']);
                                                    $KEYDROPTIMEDATA2 = str_replace("-","/",$KEYDROPTIME2);
                                                     //เวลาการพักผ่อน 8 ชั่วโมง
                                                    $SLEEPRESTEND2 = str_replace("T"," ",$result_seSelfCheck2['SLEEPRESTEND']);
                                                    $SLEEPRESTENDDATA2 = str_replace("-","/",$SLEEPRESTEND2);

                                                   
                                                    // เวลาการทำงาน น้อยกว่า 14 ชั่วโมง
                                                    if (($result_seSelfCheck2['TIMEWORKING'] == '' || $result_seSelfCheck2['TIMEWORKING'] == '<br /><b>Warning</b>:  sqlsrv_fetch_array() expects parameter 1 to be resource, boolean given in <b>') ) {
                                                        $TIMEWORKING21 = '0';
                                                        $TIMEWORKING22 = '0';
                                                    }else {
                                                        // เช็คชั่วโมง < 14
                                                        $TIMEWORKINGCHK21 = substr($result_seSelfCheck2['TIMEWORKING'],0,2);
                                                        $TIMEWORKING21 = str_replace(":"," ",$TIMEWORKINGCHK21);

                                                        // เช็คนาที < 1
                                                        $TIMEWORKINGCHK22 = substr($result_seSelfCheck2['TIMEWORKING'],3,5);
                                                        $TIMEWORKING22 = str_replace(":"," ",$TIMEWORKINGCHK22);
                                                    }

                                                    // echo $TIMEWORKING21;
                                                    // echo "<br>";
                                                    // echo $TIMEWORKING22;
                                                    // echo $KEYDROPTIMEDATA1;
                                                    // echo $SLEEPRESTENDDATA1;
                                                   
                                                    ?>
                                                    <td colspan = "4" style="width:160px;border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left"><label ><u>เวลาเริ่มปฏิบัติงาน</u></label><br>
                                                    <input disabled class="form-control daysleep_restend"  style="height:40px; width:240px;9background-color: #c9c9c;" id="daysleep_restend2" name="daysleep_restend2" value="<?= $SLEEPRESTENDDATA2 ?>" min="" max="" autocomplete="off"></td>
                                                    
                                                    <td colspan = "4" style="width:160px;border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left"><label ><u>เวลาเลิกงาน</u></label><br>
                                                    <input class="form-control dateenkeydroptime" onchange ="save_keydroptime2();" style="height:40px; width:240px;9background-color: #c9c9c;" id="keydroptime2" name="keydroptime2" value="<?= $KEYDROPTIMEDATA2 ?>" min="" max="" autocomplete="off"></td>
                                                    
                                                    <td colspan = "4" style="width:160px;border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left"><label ><u>รวมเวลา</u></label><br>
                                                    
                                                    <?php
                                                    if ($TIMEWORKING21 == 0) {
                                                    ?>
                                                    <input readonly   style="background-color: #94FA67;"  type="text" class="form-control" id="timeworking2" name="timeworking2" value= "<?= $result_seSelfCheck2['TIMEWORKING'] ?>" autocomplete="off">    
                                                    <?php
                                                    }else if ($TIMEWORKING21 > 0 &&  $TIMEWORKING21 <14) {
                                                    ?>
                                                    <input readonly style="background-color: #94FA67;"  type="text" class="form-control" id="timeworking2" name="timeworking2" value= "<?= $result_seSelfCheck2['TIMEWORKING'] ?>" autocomplete="off">
                                                    <?php
                                                    }else if ($TIMEWORKING21 == 14) {

                                                        if ($TIMEWORKING22 <= 0) {
                                                     ?>
                                                         <input readonly style="background-color: #94FA67;"  type="text" class="form-control" id="timeworking2" name="timeworking2" value= "<?= $result_seSelfCheck2['TIMEWORKING'] ?>" autocomplete="off">
                                                     <?php
                                                        }else {
                                                     ?>
                                                        <input readonly style="background-color: #FA6767;"  type="text" class="form-control" id="timeworking2" name="timeworking2" value= "<?= $result_seSelfCheck2['TIMEWORKING'] ?>" autocomplete="off">
                                                     <?php
                                                        }
                                                     ?>
                                                
                                                   
                                                    <?php
                                                    }else {
                                                    ?>
                                                    <input readonly style="background-color: #FA6767;"  type="text" class="form-control" id="timeworking2" name="timeworking2" value= "<?= $result_seSelfCheck2['TIMEWORKING'] ?>" autocomplete="off">
                                                    <?php
                                                    }
                                                    ?>

                                                    <td colspan = "5" style="width:160px;border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left" ><label ><u>ลงสาเหตุทำงานเกิน</u></label><br>
                                                    <button type="button" style= "height:35px;width:150px" class="btn btn-primary btn-md" name="myBtn" id ="myBtn" onclick="inserttimeworkingdata('<?=$_GET['employeecode2']?>','<?= $result_sePlain['EMPLOYEENAME2'] ?>','<?=$result_seSelfCheck2['SELFCHECKID']?>')">ลงข้อมูล</button>

                                                    <td colspan = "4" style="width:160px;border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left" ><label ><u>SelfCheckID:<?= $result_seSelfCheck2['SELFCHECKID'] ?></u></label><br>
                                                    <input type="hidden" class="form-control"  disabled = "" style="height:40px; width:240px;" id="keydrop_selfcheckid2" name="keydrop_selfcheckid2" value="<?= $result_seSelfCheck2['SELFCHECKID'] ?>" min="" max="" autocomplete="off">
                                                    
                                                    <input type="button" onclick="se_selfcheck('<?=$result_seSelfCheck2['SELFCHECKID']?>','<?= $result_seEmployee2['nameT'] ?>','<?= $_GET['employeecode2'] ?>','<?=$dateself2?>','<?=$result_seDateSelfCheck2['DATERK'] ?>','<?=$result_seDateSelfCheck2['DATEPRESENT'] ?>','<?= $result_seEmployee['nameT']?>');" name="btnSend" id="btnSend" value="ดูข้อมูลการ Self Check" class="btn btn-primary"></td>
                                                     
                                                </tr>
                                            </table>     
                                            <br><br>           
                                        <div id="data_tenko3emp2sr"></div>
                                    </div>
                                    <div class="tab-pane fade" id="tenko4">    
                                        <?php
                                        if ($result_sePlain['COMPANYCODE'] == 'RRC' || $result_sePlain['COMPANYCODE'] == 'RCC' || $result_sePlain['COMPANYCODE'] == 'RATC') {
                                            ?>
                                            <div id="data_tenko4emp2sr-1"></div>
                                            <?php
                                        } else if ($result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKL') {
                                            ?>
                                            <div id="data_tenko4emp2sr-2"></div>
                                            <?php
                                        }
                                        ?>

                                    </div>

                                    <div class="tab-pane fade" id="tenko5">
                                        <div id="data_tenko5emp2sr"></div>
                                    </div>
                                    <div class="tab-pane fade" id="tenko6">
                                        <div id="data_tenko6emp2sr"></div>
                                            <div style="text-align: center;">
                                                <?php
                                                    $sql_CheckPointEmp2 = "SELECT TENKOGPSSPEEDOVERAMOUNT,TENKOGPSBRAKEAMOUNT,TENKOGPSSPEEDMACHINEAMOUNT,
                                                    TENKOGPSOUTLINEAMOUNT,TENKOGPSCONTINUOUSAMOUNT,GRADEDRIVER,POINTDRIVER,
                                                    CONVERT(VARCHAR(16), CALCLICKDATE, 120) AS 'CALCLICKDATE'
                                                    FROM TENKOGPS WHERE TENKOMASTERID ='".$result_seTenkomaster_temp['TENKOMASTERID']."'
                                                    AND TENKOMASTERDIRVERCODE ='".$_GET['employeecode2']."'";
                                                    $params_CheckPointEmp2 = array();
                                                    $query_CheckPointEmp2 = sqlsrv_query($conn, $sql_CheckPointEmp2, $params_CheckPointEmp2);
                                                    $result_CheckPointEmp2 = sqlsrv_fetch_array($query_CheckPointEmp2, SQLSRV_FETCH_ASSOC);

                                            
                                                    //	ความเร็วเกินกำหนด
                                                    if ($result_CheckPointEmp2['TENKOGPSSPEEDOVERAMOUNT'] == '' || $result_CheckPointEmp2['TENKOGPSSPEEDOVERAMOUNT'] == NULL || $result_CheckPointEmp2['TENKOGPSSPEEDOVERAMOUNT'] == '-') {
                                                        $speedoverpointEmp2 = '100';
                                                    }else {
                                                        $speedoverpointEmp2 = $result_CheckPointEmp2['TENKOGPSSPEEDOVERAMOUNT'];
                                                    }
                                                    
                                                    // 	เบรคกระทันหัน
                                                    if ($result_CheckPointEmp2['TENKOGPSBRAKEAMOUNT'] == '' || $result_CheckPointEmp2['TENKOGPSBRAKEAMOUNT'] == NULL || $result_CheckPointEmp2['TENKOGPSSPEEDOVERAMOUNT'] == '-') {
                                                        $gpsbrakepointEmp2 = '100';
                                                    }else {
                                                        $gpsbrakepointEmp2 = $result_CheckPointEmp2['TENKOGPSBRAKEAMOUNT'];
                                                    }
                                                    
                                                    // รอบเครื่องเกินกำหนด
                                                    if ($result_CheckPointEmp2['TENKOGPSSPEEDMACHINEAMOUNT'] == '' || $result_CheckPointEmp2['TENKOGPSSPEEDMACHINEAMOUNT'] == NULL || $result_CheckPointEmp2['TENKOGPSSPEEDOVERAMOUNT'] == '-') {
                                                        $speedmechinepointEmp2 = '100';
                                                    }else {
                                                        $speedmechinepointEmp2 = $result_CheckPointEmp2['TENKOGPSSPEEDMACHINEAMOUNT'];
                                                    }
                                                    
                                                    //	วิ่งนอกเส้นทาง
                                                    if ($result_CheckPointEmp2['TENKOGPSOUTLINEAMOUNT'] == '' || $result_CheckPointEmp2['TENKOGPSOUTLINEAMOUNT'] == NULL || $result_CheckPointEmp2['TENKOGPSSPEEDOVERAMOUNT'] == '-') {
                                                        $outlinepointEmp2 = '100';
                                                    }else {
                                                        $outlinepointEmp2 = $result_CheckPointEmp2['TENKOGPSOUTLINEAMOUNT'];
                                                    }
                                                    
                                                    //	ขับรถต่อเนื่อง 4 ชม.
                                                    if ($result_CheckPointEmp2['TENKOGPSCONTINUOUSAMOUNT'] == '' || $result_CheckPointEmp2['TENKOGPSCONTINUOUSAMOUNT'] == NULL || $result_CheckPointEmp2['TENKOGPSSPEEDOVERAMOUNT'] == '-') {
                                                        $continuepointEmp2 = '100';
                                                    }else {
                                                        $continuepointEmp2 = $result_CheckPointEmp2['TENKOGPSCONTINUOUSAMOUNT'];
                                                    }

                                                    $maxpointEmp2 = 100;
                                                    $sumpointEmp2 = ($speedoverpointEmp2+$gpsbrakepointEmp2+$speedmechinepointEmp2+$outlinepointEmp2+$continuepointEmp2)*2;
                                                    
                                                
                                                    if($sumpointEmp2 == '1000'){
                                                        $allpointEmp2 = 'ไม่มีผลคะแนน';
                                                    }else {
                                                        $allpointEmp2 = ($maxpointEmp2)-($sumpointEmp2);
                                                    }

                                                    

                                                    if ($allpointEmp2 == '100') {
                                                        $gradeEmp2 = 'A';
                                                    }else if(($allpointEmp2 >= '80') && ($allpointEmp2 <= '99')){
                                                        $gradeEmp2 = 'B';
                                                    }else if(($allpointEmp2 >= '60') && ($allpointEmp2 <= '79')){
                                                        $gradeEmp2 = 'C';
                                                    }else if(($allpointEmp2 >= '40') && ($allpointEmp2 <= '59')){
                                                        $gradeEmp2 = 'D';
                                                    }else if(($allpointEmp2 >= '0') && ($allpointEmp2 <= '39')){
                                                        $gradeEmp2 = 'E';
                                                    }else {
                                                        $gradeEmp2 = 'ไม่มีผลการประเมิน';
                                                    }



                                                ?>
                                                <table style="width:500px;border: 1px solid black;border-collapse: collapse;">
                                                    <tr>
                                                        <th colspan = "8" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: center">คะแนนการขับขี่ประจำวัน พขร.2 
                                                        <br>&nbsp;&nbsp;<button onclick="check_pointemp2('<?=$result_seTenkomaster_temp['TENKOMASTERID']?>','<?=$_GET['employeecode2']?>','emp2');" >คำนวณ พขร.2</button><font color="red">*กดคำนวณทุกครั้งเพื่อคำนวณคะแนน และบันทึกข้อมูล</font></th> 
                                                    </tr>
                                                    <tr>
                                                        <th colspan = "8" style="border: 1px solid black;background-color: #a3a3a3;border-collapse: collapse;padding: 5px;text-align: left">กดคำนวณครั้งล่าสุด:&nbsp;<?=$result_CheckPointEmp2['CALCLICKDATE']?>
                                                        </th> 
                                                    </tr>
                                                    <tr>
                                                        <!-- สายตาสั้น -->
                                                        <th colspan = "4" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center;">การประเมินผล</th>
                                                        <th colspan = "4" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center;">คะแนนที่ได้</th>
                                                    </tr>
                                                    <div id="data_pointemp2sr"></div>
                                                    <tr>
                                                        <th colspan = "4" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center;"><input disabled="" style="text-align: center;" type="text" name="txt_gradeshowemp2" id="txt_gradeshowemp2" value="<?= $gradeEmp2 ?>" style=""></th>
                                                        <th colspan = "4" style="width:100px;border: 1px solid black;background-color: #c9c9c9;border-collapse: collapse;padding: 5px;text-align: center;"><input disabled="" style="text-align: center;" type="text" name="txt_pointshowemp2" id="txt_pointshowemp2" value="<?= $allpointEmp2 ?>" style=""></th>
                                                        
                                                        <input type="text" name="txt_gradesaveemp2" id="txt_gradesaveemp2" value="" style="display:none">
                                                        <input type="text" name="txt_pointsaveemp2" id="txt_pointsaveemp2" value="" style="display:none">
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>









                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>

            </div>
            <?php
        }
        ?>


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

        <!-- Zoom Js -->
        <script src="js/zoom.js"></script>

    </body>

    <script>        
                                                 function inserttimeworkingdata(employeecode,employeename,selfcheckid) {
                                                    // alert("เพิ่มข้อมูล");
                                                    // alert(createyear);
                                                    // window.open('report_digitaltenkoshowhealthhistory.php?employeename=' + employeename + '&createyear='+createyear, '_blank');
                                                    window.open('report_inserttimeworkingng.php?employeecode=' + employeecode+ '&employeename='+employeename + '&selfcheckid='+selfcheckid, '_blank', 
                                                    "toolbar=yes,scrollbars=yes,resizable=yes,top=70,left=400,width=700,height=650");
                                                }


                                                function healthdata(employeename,createyear) {
                                                    // alert(employeename);
                                                    // alert(createyear);
                                                    // window.open('report_digitaltenkoshowhealthhistory.php?employeename=' + employeename + '&createyear='+createyear, '_blank');
                                                    window.open('report_showhealthhistorydigitaltenko.php?employeename=' + employeename + '&createyear='+createyear, '_blank', 
                                                    "toolbar=yes,scrollbars=yes,resizable=yes,top=25,left=400,width=700,height=700");
                                                }

                                                function truckcamera(employeecode,yearstart,yearend) {
                                                    // alert(employeename);
                                                    // alert(createyear);
                                                    window.open('report_showtruckcameracheckdigitaltenko.php?employeecode=' + employeecode + '&yearstart='+yearstart+ '&yearend='+yearend, '_blank', 
                                                    "toolbar=yes,scrollbars=yes,resizable=yes,top=25,left=250,width=1000,height=700");
                                                    // window.open('report_digitaltenkoshowhealthhistory.php?employeename=' + employeename + '&createyear='+createyear, '_blank', 
                                                    // "toolbar=yes,scrollbars=yes,resizable=yes,top=25,left=400,width=700,height=700");
                                                }

                                                function acidentdata(employeecode,yearstart,yearend) {
                                                    // alert(employeename);
                                                    // alert(createyear);
                                                    window.open('report_showaccidenthistorydigitaltenko.php?employeecode=' + employeecode + '&yearstart='+yearstart+ '&yearend='+yearend, '_blank', 
                                                    "toolbar=yes,scrollbars=yes,resizable=yes,top=25,left=100,width=1300,height=700");
                                                    // window.open('report_digitaltenkoshowhealthhistory.php?employeename=' + employeename + '&createyear='+createyear, '_blank', 
                                                    // "toolbar=yes,scrollbars=yes,resizable=yes,top=25,left=400,width=700,height=700");
                                                }

                                                function workingissuedata(employeecode,yearstart,yearend) {
                                                    // alert(employeename);
                                                    // alert(createyear);
                                                    window.open('report_showworkingissuedigitaltenko.php?employeecode=' + employeecode + '&yearstart='+yearstart+ '&yearend='+yearend, '_blank', 
                                                    "toolbar=yes,scrollbars=yes,resizable=yes,top=25,left=250,width=1000,height=700");
                                                    // window.open('report_digitaltenkoshowhealthhistory.php?employeename=' + employeename + '&createyear='+createyear, '_blank', 
                                                    // "toolbar=yes,scrollbars=yes,resizable=yes,top=25,left=400,width=700,height=700");
                                                }
                                                $(document).ready(function () {
                                                    $('#dataTables-example3').DataTable({
                                                        responsive: true,
                                                    });
                                                });
                                                $(document).ready(function () {
                                                    $('#dataTables-example4').DataTable({
                                                        responsive: true,
                                                    });
                                                });
                                                $(document).ready(function () {
                                                    $('#dataTables-example5').DataTable({
                                                        responsive: true,
                                                    });
                                                });
                                                $(document).ready(function () {
                                                    $('#dataTables-example6').DataTable({
                                                        responsive: true,
                                                    });
                                                });
                                                function se_selfcheck(id,employeename,employeecode,datedriverchk,daterkchk,datepresent,officername){
                                                    // alert(employeename);
                                                    // alert(employeecode);
                                                    // alert(datedriverchk);
                                                    // alert(dateworking);
                                                    // alert(datepresent);
                                                    // alert(officername);

                                                    $type = 'officercheck';
                                                    window.open('meg_selfcheckdetail.php?id=' + id +'&employeecode=' + employeecode+'&employeename='+employeename+'&datedriverchk='+datedriverchk+'&daterkchk='+daterkchk+'&datepresentchk='+datepresent+'&type='+$type+'&officername='+officername, '_blank');
                                                }
                                                
                                                function se_graphdatacheck(employeecode){
                                                    // alert(employeename);
                                                    // alert(employeecode);
                                                    // alert(date);
                                                    
                                                    window.open('meg_driverdatagraph.php?employeecode=' + employeecode, '_blank');
                                                }
                                                
                                                function select_tenko2()
                                                {
                                                    <?php
                                                    if ($_GET['employeecode1'] != '') {
                                                        ?>
                                                        $.ajax({
                                                            url: 'meg_data2.php',
                                                            type: 'POST',
                                                            data: {
                                                                txt_flg: "select_tenko2emp1", vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', employeecode1: '<?= $_GET['employeecode1'] ?>'
                                                            },
                                                            success: function (rs) {
                                                                document.getElementById("data_tenko2emp1sr").innerHTML = rs;
                                                                $(function () {
                                                                    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ. // กรณีใช้แบบ input
                                                                    $(".timeen").datetimepicker({
                                                                        datepicker: false,
                                                                        format: 'H:i',
                                                                        //mask: '29:59',
                                                                        lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                    });
                                                                });
                                                            }
                                                        });
                                                        <?php
                                                    } else {
                                                        ?>
                                                        $.ajax({
                                                            url: 'meg_data2.php',
                                                            type: 'POST',
                                                            data: {
                                                                txt_flg: "select_tenko2emp2", vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', employeecode2: '<?= $_GET['employeecode2'] ?>'
                                                            },
                                                            success: function (rs) {
                                                                document.getElementById("data_tenko2emp2sr").innerHTML = rs;
                                                                $(function () {
                                                                    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ. // กรณีใช้แบบ input
                                                                    $(".timeen").datetimepicker({
                                                                        datepicker: false,
                                                                        format: 'H:i',
                                                                        //mask: '29:59',
                                                                        lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                    });
                                                                });
                                                            }
                                                        });
    <?php
}
?>

                                                }
                                                function select_tenko3()
                                                {
                                                    <?php
                                                    if ($_GET['employeecode1'] != '') {
                                                        ?>
                                                        $.ajax({
                                                            url: 'meg_data2.php',
                                                            type: 'POST',
                                                            data: {
                                                                txt_flg: "select_tenko3emp1", vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', employeecode1: '<?= $_GET['employeecode1'] ?>'
                                                            },
                                                            success: function (rs) {
                                                                document.getElementById("data_tenko3emp1sr").innerHTML = rs;

                                                            }
                                                        });
                                                        <?php
                                                    } else {
                                                        ?>
                                                        $.ajax({
                                                            url: 'meg_data2.php',
                                                            type: 'POST',
                                                            data: {
                                                                txt_flg: "select_tenko3emp2", vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', employeecode2: '<?= $_GET['employeecode2'] ?>'
                                                            },
                                                            success: function (rs) {
                                                                document.getElementById("data_tenko3emp2sr").innerHTML = rs;

                                                            }
                                                        });
                                                        <?php
                                                    }
                                                    ?>

                                                }



                                                function select_tenko4()
                                                {


                                                    <?php
                                                    if ($_GET['employeecode1'] != '') {
                                                        if ($result_sePlain['COMPANYCODE'] == 'RRC' || $result_sePlain['COMPANYCODE'] == 'RCC' || $result_sePlain['COMPANYCODE'] == 'RATC') {
                                                            ?>
                                                            $.ajax({
                                                                url: 'meg_data2.php',
                                                                type: 'POST',
                                                                data: {
                                                                    txt_flg: "select_tenko4emp1-1", vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', employeecode1: '<?= $_GET['employeecode1'] ?>'
                                                                },
                                                                success: function (rs) {
                                                                    document.getElementById("data_tenko4emp1sr-1").innerHTML = rs;

                                                                }
                                                            });




                                                        <?php
                                                    } else if ($result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKL') {
                                                        ?>


                                                            $.ajax({
                                                                url: 'meg_data2.php',
                                                                type: 'POST',
                                                                data: {
                                                                    txt_flg: "select_tenko4emp1-2", vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', employeecode1: '<?= $_GET['employeecode1'] ?>'
                                                                },
                                                                success: function (rs) {
                                                                    document.getElementById("data_tenko4emp1sr-2").innerHTML = rs;

                                                                }
                                                            });

        <?php
    }
} else {
    if ($result_sePlain['COMPANYCODE'] == 'RRC' || $result_sePlain['COMPANYCODE'] == 'RCC' || $result_sePlain['COMPANYCODE'] == 'RATC') {
        ?>
                                                            $.ajax({
                                                                url: 'meg_data2.php',
                                                                type: 'POST',
                                                                data: {
                                                                    txt_flg: "select_tenko4emp2-1", vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', employeecode2: '<?= $_GET['employeecode2'] ?>'
                                                                },
                                                                success: function (rs) {
                                                                    document.getElementById("data_tenko4emp2sr-1").innerHTML = rs;

                                                                }
                                                            });




        <?php
    } else if ($result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKL') {
        ?>


                                                            $.ajax({
                                                                url: 'meg_data2.php',
                                                                type: 'POST',
                                                                data: {
                                                                    txt_flg: "select_tenko4emp2-2", vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', employeecode2: '<?= $_GET['employeecode2'] ?>'
                                                                },
                                                                success: function (rs) {
                                                                    document.getElementById("data_tenko4emp2sr-2").innerHTML = rs;

                                                                }
                                                            });

        <?php
    }
}
?>




                                                }
                                                function select_tenko5()
                                                {
<?php
if ($_GET['employeecode1'] != '') {
    ?>
                                                        $.ajax({
                                                            url: 'meg_data2.php',
                                                            type: 'POST',
                                                            data: {
                                                                txt_flg: "select_tenko5emp1", vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', employeecode1: '<?= $_GET['employeecode1'] ?>'
                                                            },
                                                            success: function (rs) {
                                                                document.getElementById("data_tenko5emp1sr").innerHTML = rs;

                                                            }
                                                        });
    <?php
} else {
    ?>
                                                        $.ajax({
                                                            url: 'meg_data2.php',
                                                            type: 'POST',
                                                            data: {
                                                                txt_flg: "select_tenko5emp2", vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', employeecode2: '<?= $_GET['employeecode2'] ?>'
                                                            },
                                                            success: function (rs) {
                                                                document.getElementById("data_tenko5emp2sr").innerHTML = rs;

                                                            }
                                                        });
    <?php
}
?>

                                                }
                                                function select_tenko6()
                                                {
                                            <?php
                                            if ($_GET['employeecode1'] != '') {
                                                ?>
                                                            $.ajax({
                                                            url: 'meg_data2.php',
                                                            type: 'POST',
                                                            data: {
                                                                txt_flg: "select_tenko6emp1", vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', employeecode1: '<?= $_GET['employeecode1'] ?>'
                                                            },
                                                            success: function (rs) {
                                                                document.getElementById("data_tenko6emp1sr").innerHTML = rs;

                                                            }
                                                        });
                                                        <?php
                                                    } else {
                                                        ?>
                                                        $.ajax({
                                                            url: 'meg_data2.php',
                                                            type: 'POST',
                                                            data: {
                                                                txt_flg: "select_tenko6emp2", vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', employeecode2: '<?= $_GET['employeecode2'] ?>'
                                                            },
                                                            success: function (rs) {
                                                                document.getElementById("data_tenko6emp2sr").innerHTML = rs;

                                                            }
                                                        });
    <?php
}
?>

                                                }







                                                function save_tenkomastergw(vehicletransportplanid, employeecode, statusemp)
                                                {


                                                    if (statusemp == '1')
                                                    {
                                                        window.location.href = 'meg_tenkodocument1.php?vehicletransportplanid=' + vehicletransportplanid + '&employeecode1=' + employeecode;
                                                    } else
                                                    {
                                                        window.location.href = 'meg_tenkodocument1.php?vehicletransportplanid=' + vehicletransportplanid + '&employeecode2=' + employeecode;
                                                    }




                                                }
                                                function save_tenkomasteramt(vehicletransportplanid, tenkostatus, employeecode, statusemp)
                                                {

                                                    if (statusemp == '1')
                                                    {
                                                        window.location.href = 'meg_tenkodocument1.php?vehicletransportplanid=' + vehicletransportplanid + '&employeecode1=' + employeecode;
                                                    } else
                                                    {
                                                        window.location.href = 'meg_tenkodocument1.php?vehicletransportplanid=' + vehicletransportplanid + '&employeecode2=' + employeecode;
                                                    }







                                                }

                                                $(function () {
                                                    $("#overlay").fadeOut();
                                                    $(".main-contain").removeClass("main-contain");


                                                });


                                                function save_tenkorestremark()
                                                {
                                                    var employeecode = '';
                                                    if ('<?= $_GET['employeecode1'] ?>' != '')
                                                    {
                                                        employeecode = '<?= $result_seTenkobefore1['TENKOBEFOREID'] ?>';
                                                    } else
                                                    {
                                                        employeecode = '<?= $result_seTenkobefore2['TENKOBEFOREID'] ?>';
                                                    }
                                                    
                                                    $.ajax({
                                                        type: 'post',
                                                        url: 'meg_data.php',
                                                        data: {
                                                            txt_flg: "select_resttime2", startrest: document.getElementById('txt_startrest').value, endrest: document.getElementById('txt_endrest').value
                                                        },
                                                        success: function (rs) {



                                                            document.getElementById('txt_rs14').value = rs;
                                                            if (document.getElementById("txt_rs14").value != "")
                                                            {

                                                                if (document.getElementById("txt_rs14").value.substring(0, 2) < 8)
                                                                {
                                                                    document.getElementById("chk_rs140").checked = true;
                                                                    document.getElementById("chk_rs141").checked = false;
                                                                } else
                                                                {
                                                                    document.getElementById("chk_rs141").checked = true;
                                                                    document.getElementById("chk_rs140").checked = false;
                                                                }


                                                                document.getElementById("chk_14").checked = true;
                                                            } else
                                                            {
                                                                document.getElementById("chk_14").checked = false;
                                                                document.getElementById("chk_rs140").checked = true;
                                                                document.getElementById("chk_rs141").checked = false;
                                                            }




                                                            $.ajax({
                                                                url: 'meg_data.php',
                                                                type: 'POST',
                                                                data: {
                                                                    txt_flg: "edit_tenkobefore", editableObj: document.getElementById('txt_startrest').value + ' : ' + document.getElementById('txt_endrest').value, ID: employeecode, fieldname: 'TENKORESTREMARK'
                                                                },
                                                                success: function () {

                                                                    document.getElementById('txt_remark14').value = document.getElementById('txt_startrest').value + ' : ' + document.getElementById('txt_endrest').value;
                                                                    document.getElementById('btn_remark14').value = document.getElementById('txt_startrest').value + ' : ' + document.getElementById('txt_endrest').value;
                                                                }
                                                            });
                                                        }
                                                    });
                                                }
                                                function save_tenkosleeptimeremark()
                                                {
                                                    var employeecode = '';
                                                    if ('<?= $_GET['employeecode1'] ?>' != '')
                                                    {
                                                        employeecode = '<?= $result_seTenkobefore1['TENKOBEFOREID'] ?>';
                                                    } else
                                                    {
                                                        employeecode = '<?= $result_seTenkobefore2['TENKOBEFOREID'] ?>';
                                                    }
                                                    $.ajax({
                                                        type: 'post',
                                                        url: 'meg_data.php',
                                                        data: {
                                                            txt_flg: "select_resttime", startsleep: document.getElementById('txt_startsleep').value, endsleep: document.getElementById('txt_endsleep').value
                                                        },
                                                        success: function (rs) {



                                                            document.getElementById('txt_rs151').value = rs;
                                                            if (document.getElementById("txt_rs151").value != "")
                                                            {

                                                                if (document.getElementById("txt_rs151").value.substring(0, 2) < 6)
                                                                {
                                                                    document.getElementById("chk_rs150").checked = true;
                                                                    document.getElementById("chk_rs151").checked = false;
                                                                } else
                                                                {
                                                                    document.getElementById("chk_rs151").checked = true;
                                                                    document.getElementById("chk_rs150").checked = false;
                                                                }


                                                                document.getElementById("chk_15").checked = true;
                                                            } else
                                                            {
                                                                document.getElementById("chk_15").checked = false;
                                                                document.getElementById("chk_rs150").checked = true;
                                                                document.getElementById("chk_rs151").checked = false;
                                                            }




                                                            $.ajax({
                                                                url: 'meg_data.php',
                                                                type: 'POST',
                                                                data: {
                                                                    txt_flg: "edit_tenkobefore", editableObj: document.getElementById('txt_startsleep').value + ' : ' + document.getElementById('txt_endsleep').value, ID: employeecode, fieldname: 'TENKOSLEEPTIMEREMARK'
                                                                },
                                                                success: function () {

                                                                    document.getElementById('txt_remark15').value = document.getElementById('txt_startsleep').value + ' : ' + document.getElementById('txt_endsleep').value;
                                                                    document.getElementById('btn_remark15').value = document.getElementById('txt_startsleep').value + ' : ' + document.getElementById('txt_endsleep').value;
                                                                }
                                                            });
                                                        }
                                                    });
                                                }
                                                function commit2()
                                                {

                                                    if ('<?= $_GET['employeecode1'] ?>' != "")
                                                    {
                                                        rs_checkdirverbefore1();
                                                        rs_resultdirverbefore1();

                                                        //rs_checkdirvertransport1();
                                                        //rs_rsdirvertransport1();

                                                        //rs_checkdirveraffter1();
                                                        //rs_resultdirveraffter1();

                                                    } else
                                                    {
                                                        rs_checkdirverbefore2();
                                                        rs_resultdirverbefore2();

                                                        //rs_checkdirvertransport2();
                                                        //rs_rsdirvertransport2();

                                                        //rs_checkdirveraffter2();
                                                        //rs_resultdirveraffter2();

                                                    }






                                                }
                                                function commit_1(selfcheckid)
                                                {
                                                    // alert(selfcheckid);
                                                    if ('<?= $_GET['employeecode1'] ?>' != "")
                                                    {
                                                        // alert('1');
                                                        rs_checkdirverbefore1();
                                                        rs_resultdirverbefore1();

                                                      

                                                    } else
                                                    {
                                                        // alert('2');
                                                        rs_checkdirverbefore2();
                                                        rs_resultdirverbefore2();



                                                    }

                                                    commitupdate_selfcheck(selfcheckid);
                                                    save_logprocess('Tenko', 'Commit', '<?= $result_seLogin['PersonCode'] ?>');
                                                    alert('commit เรียบร้อยแล้ว');



                                                }
                                                
                                                function commit_2(tenkomasterid,tenkotransportid,dateday,actualtenkoby)
                                                {
                                                    // commit_2 คือ function การกด commit ในหน้าการทำเท็งโก๊ะระหว่างทาง จาก Meg_data2
                                                    // alert('commit2');
                                                    if ('<?= $_GET['employeecode1'] ?>' != "")
                                                    {


                                                        rs_checkdirvertransport1();
                                                        rs_rsdirvertransport1();
                                                        save_datetenkotransport(tenkomasterid,tenkotransportid,dateday,actualtenkoby);

                                                    } else
                                                    {


                                                        rs_checkdirvertransport2();
                                                        rs_rsdirvertransport2();
                                                        save_datetenkotransport(tenkomasterid,tenkotransportid,dateday,actualtenkoby);


                                                    }

                                                    save_logprocess('Tenko', 'Commit', '<?= $result_seLogin['PersonCode'] ?>');




                                                }
                                                function save_datetenkotransport(tenkomasterid,tenkotransportid,dateday,actualtenkoby){
                                                    // alert(tenkomasterid);
                                                    // alert(tenkotransportid);
                                                    // alert(dateday);
                                                    // alert(actualtenkoby);

                                                    $.ajax({
                                                        url: 'meg_data2.php',
                                                        type: 'POST',
                                                        data: {
                                                            txt_flg: "save_actualdate_tenkotransport", tenkomasterid: tenkomasterid, tenkotransportid: tenkotransportid,actualtenkoby: actualtenkoby
                                                        },
                                                        success: function (rs) {
                                                            // alert(rs);
                                                            alert("commit เรียบร้อยแล้ว");

                                                        }
                                                    });

                                                }
                                                function commit_3(tenkomasterid,tenkoafterid,actualtenkoby)
                                                {

                                                    if ('<?= $_GET['employeecode1'] ?>' != "")
                                                    {


                                                        rs_checkdirveraffter1();
                                                        rs_resultdirveraffter1();
                                                        save_datetenkoafter(tenkomasterid,tenkoafterid,actualtenkoby);
                                                    } else
                                                    {


                                                        rs_checkdirveraffter2();
                                                        rs_resultdirveraffter2();
                                                        save_datetenkoafter(tenkomasterid,tenkoafterid,actualtenkoby);
                                                    }

                                                    save_logprocess('Tenko', 'Commit', '<?= $result_seLogin['PersonCode'] ?>');

                                                }
                                                function save_datetenkoafter(tenkomasterid,tenkoafterid,actualtenkoby){

                                                    // alert(tenkomasterid);
                                                    // alert(tenkoafterid);
                                                    // alert(actualtenkoby);

                                                    $.ajax({
                                                        url: 'meg_data2.php',
                                                        type: 'POST',
                                                        data: {
                                                            txt_flg: "save_actualdate_tenkoafter", tenkomasterid: tenkomasterid, tenkoafterid: tenkoafterid,actualtenkoby: actualtenkoby
                                                        },
                                                        success: function (rs) {
                                                            // alert(rs);
                                                            alert("commit เรียบร้อยแล้ว");

                                                        }
                                                    });

                                                }
                                                function save_logprocess(category, process, employeecode)
                                                {
                                                    $.ajax({
                                                        url: 'meg_data.php',
                                                        type: 'POST',
                                                        data: {
                                                            txt_flg: "save_logprocess", category: category, process: process, employeecode: employeecode
                                                        },
                                                        success: function () {


                                                        }
                                                    });
                                                }
                                                function select_cluster()
                                                {
                                                    $('.selectpicker').on('changed.bs.select', function () {
                                                        document.getElementById('txt_copydiagramcluster').value = $(this).val();
                                                        select_jobend();
                                                    });
                                                }
                                                function select_clusterskb()
                                                {
                                                    $('.selectpicker').on('changed.bs.select', function () {
                                                        document.getElementById('txt_copydiagramclusterskb').value = $(this).val();
                                                        select_jobendskb();
                                                    });
                                                }
                                                function select_jobend()
                                                {

                                                    var copydiagramthainame = document.getElementById("txt_copydiagramthainame").value;
                                                    var copydiagramjobstart = document.getElementById("cb_copydiagramjobstart").value;
                                                    $.ajax({
                                                        type: 'post',
                                                        url: 'meg_data.php',
                                                        data: {
                                                            txt_flg: "show_copydiagramjobend", cluster: document.getElementById('txt_copydiagramcluster').value, copydiagramthainame: copydiagramthainame, copydiagramjobstart: copydiagramjobstart
                                                        },
                                                        success: function (rs) {

                                                            document.getElementById("data_copydiagramjobendsr").innerHTML = rs;
                                                            document.getElementById("data_copydiagramjobenddef").innerHTML = "";
                                                            $("#cb_copydiagramjobend").html(rs).selectpicker('refresh');
                                                            $('.selectpicker').on('changed.bs.select', function () {
                                                                document.getElementById('txt_copydiagramjobend').value = $(this).val();
                                                            });
                                                        }
                                                    });
                                                }
                                                function select_jobendskb()
                                                {

                                                    var copydiagramthainameskb = document.getElementById("txt_copydiagramthainameskb").value;
                                                    var copydiagramjobstartskb = document.getElementById("cb_copydiagramjobstartskb").value;
                                                    $.ajax({
                                                        type: 'post',
                                                        url: 'meg_data.php',
                                                        data: {
                                                            txt_flg: "show_copydiagramjobendskb", cluster: document.getElementById('txt_copydiagramclusterskb').value, copydiagramthainameskb: copydiagramthainameskb, copydiagramjobstartskb: copydiagramjobstartskb
                                                        },
                                                        success: function (rs) {

                                                            document.getElementById("data_copydiagramjobendskbsr").innerHTML = rs;
                                                            document.getElementById("data_copydiagramjobendskbdef").innerHTML = "";
                                                            $("#cb_copydiagramjobendskb").html(rs).selectpicker('refresh');
                                                            $('.selectpicker').on('changed.bs.select', function () {
                                                                document.getElementById('txt_copydiagramjobendskb').value = $(this).val();
                                                            });
                                                        }
                                                    });
                                                }
                                                var txt_copydiagramjobstart = [<?= $job ?>];
                                                $("#txt_copydiagramjobstart").autocomplete({
                                                    source: [txt_copydiagramjobstart]
                                                });
                                                var txt_copydiagramjobstartskb = [<?= $job ?>];
                                                $("#txt_copydiagramjobstartskb").autocomplete({
                                                    source: [txt_copydiagramjobstartskb]
                                                });
                                                var txt_copydiagramthainame = [<?= $thainame ?>];
                                                $("#txt_copydiagramthainame").autocomplete({
                                                    source: [txt_copydiagramthainame]
                                                });
                                                var txt_copydiagramthainameskb = [<?= $thainame ?>];
                                                $("#txt_copydiagramthainameskb").autocomplete({
                                                    source: [txt_copydiagramthainameskb]
                                                });
                                                var txt_copydiagramthainamedenso = [<?= $thainame ?>];
                                                $("#txt_copydiagramthainamedenso").autocomplete({
                                                    source: [txt_copydiagramthainamedenso]
                                                });
                                                //if ('<?//= $result_seTenkobeforerest['AMOUNTREST'] ?>' < 8 || '<?//= $result_seTenkobeforerest['AMOUNTREST'] ?>' > 1000)
                                                //{
                                                //document.getElementById('chk_rs141').checked = false;
                                                //document.getElementById('chk_rs140').checked = true;
                                                //document.getElementById('txt_rs14').value = '0';
                                                //}
                                                //else
                                                //{
                                                //document.getElementById('chk_rs141').checked = true;
                                                //document.getElementById('chk_rs140').checked = false;
                                                //}


                                                function edit_chkvehicletransportjobendtemp(ID1, editableObj, fieldname, vehicletransportplanid)
                                                {

                                                    if (document.getElementById(ID1).checked == true) {


                                                        $.ajax({
                                                            url: 'meg_data.php',
                                                            type: 'POST',
                                                            data: {
                                                                txt_flg: "edit_vehicletransportjobendtemp", ID1: ID1, fieldname: fieldname, editableObj: '1', vehicletransportplanid: vehicletransportplanid
                                                            },
                                                            success: function () {

                                                                //alert(rs);
                                                            }
                                                        });
                                                    } else
                                                    {
                                                        $.ajax({
                                                            url: 'meg_data.php',
                                                            type: 'POST',
                                                            data: {
                                                                txt_flg: "edit_vehicletransportjobendtemp", ID1: ID1, fieldname: fieldname, editableObj: '0', vehicletransportplanid: vehicletransportplanid
                                                            },
                                                            success: function () {

                                                                //window.location.reload();
                                                            }
                                                        });
                                                    }



                                                }
                                                function select_remark2()
                                                {
                                                    $('.selectpicker').on('changed.bs.select', function () {
                                                        document.getElementById('txt_remark2').value = $(this).val();
                                                    });
                                                }

                                                /* function before_checknull()
                                                 {
                                                 if( chk_11.checked == false)
                                                 {
                                                 alert('กรุณาตรวจสอบ การทักทายก่อนเริ่มเท็งโกะ');
                                                 document.getElementById('chk_11').focus();
                                                 }
                                                 else if( chk_12.checked == false)
                                                 {
                                                 alert('กรุณาตรวจสอบ ตรวจเซ็คยูนิฟอร์ม');
                                                 document.getElementById('chk_12').focus();
                                                 }
                                                 else if( chk_13.checked == false)
                                                 {
                                                 alert('กรุณาตรวจสอบ ตรวจสอบสภาพร่างกาย');
                                                 document.getElementById('chk_13').focus();
                                                 }
                                                 else if(document.getElementById('txt_rs14').value == '')
                                                 {
                                                 alert('กรุณาตรวจสอบ ตรวจสอบระยะการพักผ่อน');
                                                 document.getElementById('ตั้งแต่ 8 ชั่วโมง').focus();
                                                 }
                                                 
                                                 
                                                 else if(document.getElementById('txt_rs151').value == '')
                                                 {
                                                 alert('กรุณาตรวจสอบ การนอนปกติ ตั้งแต่ 6 ชั่วโมงขึ้นไป');
                                                 document.getElementById('txt_rs151').focus();
                                                 }
                                                 else if(document.getElementById('txt_rs152').value == '')
                                                 {
                                                 alert('กรุณาตรวจสอบ การนอนเพิ่ม (กะกลางคืน) ตั้งแต่ 4.5 ชั่วโมงขึ้นไป');
                                                 document.getElementById('txt_rs152').focus();
                                                 }
                                                 
                                                 
                                                 else if(document.getElementById('txt_rs16').value == '')
                                                 {
                                                 alert('กรุณาตรวจสอบ ต่ำกว่า 37 องศา');
                                                 document.getElementById('txt_rs16').focus();
                                                 }
                                                 
                                                 if(document.getElementById('txt_rs171').value == '')
                                                 {
                                                 alert('กรุณาตรวจสอบ บน : 90-150');
                                                 document.getElementById('txt_rs171').focus();
                                                 }
                                                 else if(document.getElementById('txt_rs172').value == '')
                                                 {
                                                 alert('กรุณาตรวจสอบ ล่าง : 60-100');
                                                 document.getElementById('txt_rs172').focus();
                                                 }
                                                 
                                                 
                                                 else if(document.getElementById('txt_rs18').value == '')
                                                 {
                                                 alert('กรุณาตรวจสอบ ตรวจเช็คแอลกอฮอล์');
                                                 document.getElementById('txt_rs18').focus();
                                                 }
                                                 else if( chk_19.checked == false)
                                                 {
                                                 alert('กรุณาตรวจสอบ สอบถามเรื่องกังวลใจ');
                                                 document.getElementById('chk_19').focus();
                                                 }
                                                 else if( chk_110.checked == false)
                                                 {
                                                 alert('กรุณาตรวจสอบ ใบตรวจเทรลเลอร์ประจำวัน');
                                                 document.getElementById('chk_110').focus();
                                                 }
                                                 else if( chk_111.checked == false)
                                                 {
                                                 alert('กรุณาตรวจสอบ ตรวจสอบของที่พกพา');
                                                 document.getElementById('chk_111').focus();
                                                 }else if( chk_112.checked == false)
                                                 {
                                                 alert('กรุณาตรวจสอบ ตรวจสอบรายละเอียดการทำงาน');
                                                 document.getElementById('chk_112').focus();
                                                 }
                                                 else if( chk_113.checked == false)
                                                 {
                                                 alert('กรุณาตรวจสอบ แจ้งสภาพถนน');
                                                 document.getElementById('chk_113').focus();
                                                 }
                                                 else if( chk_114.checked == false)
                                                 {
                                                 alert('กรุณาตรวจสอบ แจ้งสภาพอากาศ');
                                                 document.getElementById('chk_114').focus();
                                                 }
                                                 else if( chk_115.checked == false)
                                                 {
                                                 alert('กรุณาตรวจสอบ แจ้งเรื่องโยโกะเด็น');
                                                 document.getElementById('chk_115').focus();
                                                 }
                                                 else if( chk_116.checked == false)
                                                 {
                                                 alert('กรุณาตรวจสอบ ตรวจสอบเป้าหมายการขับขี่จากเครื่องชิมูเลเตอร์');
                                                 document.getElementById('chk_116').focus();
                                                 }
                                                 else if( chk_117.checked == false)
                                                 {
                                                 alert('กรุณาตรวจสอบ สามารถวิ่งงานได้หรือไม่');
                                                 document.getElementById('chk_117').focus();
                                                 }
                                                 else if( chk_118.checked == false)
                                                 {
                                                 alert('กรุณาตรวจสอบ การทักทายหลังทำเท็งโกะเสร็จ');
                                                 document.getElementById('chk_118').focus();
                                                 }
                                                 else if(document.getElementById('txt_rs19').value == '')
                                                 {
                                                 alert('กรุณาตรวจสอบ ตรวจเช็คออกซิเจนเลือด');
                                                 document.getElementById('txt_rs19').focus();
                                                 }
                                                 
                                                 
                                                 
                                                 else if(chk_rs111.checked == false && chk_rs110.checked == false)
                                                 {
                                                 alert('ผลตรวจการทักทายก่อนเริ่มเท็งโกะ');
                                                 }
                                                 else if(chk_rs121.checked == false && chk_rs120.checked == false)
                                                 {
                                                 alert('ผลตรวจเซ็คยูนิฟอร์ม');
                                                 }
                                                 else if(chk_rs131.checked == false && chk_rs130.checked == false)
                                                 {
                                                 alert('ผลตรวจสอบสภาพร่างกาย');
                                                 }
                                                 else if(chk_rs141.checked == false && chk_rs140.checked == false)
                                                 {
                                                 alert('ผลตรวจสอบระยะการพักผ่อน');
                                                 }
                                                 else if(chk_rs151.checked == false && chk_rs150.checked == false)
                                                 {
                                                 alert('ผลตรวจสอบชั่วโมงการนอนหลับ');
                                                 else if(chk_rs161.checked == false && chk_rs160.checked == false)
                                                 {
                                                 alert('ผลตรวจเช็คอุณหภูมิ');
                                                 }
                                                 else if(chk_rs171.checked == false && chk_rs170.checked == false)
                                                 {
                                                 alert('ผลตรวจวัดความดัน');
                                                 }
                                                 else if(chk_rs181.checked == false && chk_rs180.checked == false)
                                                 {
                                                 alert('ผลตรวจเช็คแอลกอฮอล์');
                                                 }
                                                 else if(chk_rs191.checked == false && chk_rs190.checked == false)
                                                 {
                                                 alert('ผลตรวจสอบถามเรื่องกังวลใจ');
                                                 }
                                                 else if(chk_rs1101.checked == false && chk_rs1100.checked == false)
                                                 {
                                                 alert('ผลตรวจใบตรวจเทรลเลอร์ประจำวัน');
                                                 }
                                                 else if(chk_rs1111.checked == false && chk_rs1110.checked == false)
                                                 {
                                                 alert('ผลตรวจสอบของที่พกพา');
                                                 }
                                                 else if(chk_rs1121.checked == false && chk_rs1120.checked == false)
                                                 {
                                                 alert('ผลตรวจสอบรายละเอียดการทำงาน');
                                                 }
                                                 else if(chk_rs1131.checked == false && chk_rs1130.checked == false)
                                                 {
                                                 alert('ผลตรวจแจ้งสภาพถนน');
                                                 }
                                                 else if(chk_rs1141.checked == false && chk_rs1140.checked == false)
                                                 {
                                                 alert('ผลตรวจแจ้งสภาพอากาศ');
                                                 }
                                                 else if(chk_rs1151.checked == false && chk_rs1150.checked == false)
                                                 {
                                                 alert('ผลตรวจแจ้งเรื่องโยโกะเด็น');
                                                 }
                                                 else if(chk_rs1161.checked == false && chk_rs1160.checked == false)
                                                 {
                                                 alert('ผลตรวจสอบเป้าหมายการขับขี่จากเครื่องชิมูเลเตอร์');
                                                 }
                                                 else if(chk_rs1171.checked == false && chk_rs1170.checked == false)
                                                 {
                                                 alert('ผลตรวจสามารถวิ่งงานได้หรือไม่');
                                                 }
                                                 else if(chk_rs1181.checked == false && chk_rs1180.checked == false)
                                                 {
                                                 alert('ผลตรวจการทักทายหลังทำเท็งโกะเสร็จ');
                                                 }
                                                 else if(chk_rs1191.checked == false && chk_rs1190.checked == false)
                                                 {
                                                 alert('ผลตรวจเช็คออกซิเจนเลือด');
                                                 }
                                                 
                                                 
                                                 
                                                 
                                                 
                                                 
                                                 }
                                                 */


                                                $(function () {
                                                    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ. // กรณีใช้แบบ input
                                                    $(".timeen").datetimepicker({
                                                        datepicker: false,
                                                        format: 'H:i',
                                                        //mask: '29:59',
                                                        lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                    });
                                                });
                                                function rs_checkdirverbefore1()
                                                {
                                                    //  alert('IF1');   
                                                    if (
                                                            chk_11.checked == true
                                                            && chk_12.checked == true
                                                            && chk_13.checked == true
                                                            && document.getElementById('txt_rs14').value != ""
                                                            && document.getElementById('txt_rs151').value != ""
                                                            && document.getElementById('txt_rs16').value != ""
                                                            && document.getElementById('txt_rs171').value != ""
                                                            && document.getElementById('txt_rs172').value != ""
                                                            && document.getElementById('txt_rs18').value != ""
                                                            && chk_19.checked == true
                                                            && chk_110.checked == true
                                                            && chk_111.checked == true
                                                            && chk_112.checked == true
                                                            && chk_113.checked == true
                                                            && chk_114.checked == true
                                                            && chk_115.checked == true
                                                            && chk_116.checked == true
                                                            && chk_117.checked == true
                                                            && chk_118.checked == true
                                                            && chk_shortsight.checked == true
                                                            && chk_longsight.checked == true
                                                            && chk_obliquesight.checked == true
                                                            && document.getElementById('txt_rs19').value != ""
                                                            )
                                                    {

                                                        document.getElementById('icon_beforecheckok1').style.display = "";
                                                        document.getElementById('icon_beforecheckno1').style.display = "none";
                                                        if ('<?= $result_sePlain['STATUSNUMBER'] ?>' == 'O' || '<?= $result_sePlain['STATUS'] ?>' == 'แผนงานยังไม่ถึงเวลารายงาน' || '<?= $result_sePlain['STATUSNUMBER'] ?>' == 'L' || '<?= $result_sePlain['STATUS'] ?>' == 'แผนงานเลยเวลารายงานตัว')
                                                        {
                                                            // alert('IF');
                                                            edit_vehicletransportplan('แผนงานตรวจร่างกายเรียบร้อย', 'STATUS', '<?= $_GET['vehicletransportplanid'] ?>');
                                                            edit_vehicletransportplan('P', 'STATUSNUMBER', '<?= $_GET['vehicletransportplanid'] ?>');
                                                        }
                                                    } else
                                                    {

                                                        document.getElementById('icon_beforecheckok1').style.display = "none";
                                                        document.getElementById('icon_beforecheckno1').style.display = "";
                                                        if ('<?= $result_sePlain['STATUSNUMBER'] ?>' == 'O' || '<?= $result_sePlain['STATUS'] ?>' == 'แผนงานยังไม่ถึงเวลารายงาน' || '<?= $result_sePlain['STATUSNUMBER'] ?>' == 'L' || '<?= $result_sePlain['STATUS'] ?>' == 'แผนงานเลยเวลารายงานตัว')
                                                        {
                                                            // alert('else');
                                                            edit_vehicletransportplan('แผนงานยังไม่ถึงเวลารายงาน', 'STATUS', '<?= $_GET['vehicletransportplanid'] ?>');
                                                            edit_vehicletransportplan('O', 'STATUSNUMBER', '<?= $_GET['vehicletransportplanid'] ?>');
                                                        }
                                                    }



                                                }

                                                function edit_vehicletransportplan(editableObj, fieldname, ID)
                                                {
                                                    // alert(editableObj);
                                                    // alert(fieldname);
                                                    // alert(ID);
                                                    
                                                    $.ajax({
                                                        url: 'meg_data.php',
                                                        type: 'POST',
                                                        data: {
                                                            txt_flg: "edit_vehicletransportplan", editableObj: editableObj, ID: ID, fieldname: fieldname
                                                        },
                                                        success: function () {

                                                        }
                                                    });
                                                }
                                                function rs_checkdirverbefore2()
                                                {
                                                    if (
                                                            chk_11.checked == true
                                                            && chk_12.checked == true
                                                            && chk_13.checked == true
                                                            && document.getElementById('txt_rs14').value != ""
                                                            && document.getElementById('txt_rs151').value != ""
                                                            && document.getElementById('txt_rs16').value != ""
                                                            && document.getElementById('txt_rs171').value != ""
                                                            && document.getElementById('txt_rs172').value != ""
                                                            && document.getElementById('txt_rs18').value != ""
                                                            && chk_19.checked == true
                                                            && chk_110.checked == true
                                                            && chk_111.checked == true
                                                            && chk_112.checked == true
                                                            && chk_113.checked == true
                                                            && chk_114.checked == true
                                                            && chk_115.checked == true
                                                            && chk_116.checked == true
                                                            && chk_117.checked == true
                                                            && chk_118.checked == true
                                                            && chk_shortsight.checked == true
                                                            && chk_longsight.checked == true
                                                            && chk_obliquesight.checked == true
                                                            && document.getElementById('txt_rs19').value != ""
                                                            )
                                                    {
                                                        document.getElementById('icon_beforecheckok2').style.display = "";
                                                        document.getElementById('icon_beforecheckno2').style.display = "none";
                                                        if ('<?= $result_sePlain['STATUSNUMBER'] ?>' == 'O' || '<?= $result_sePlain['STATUS'] ?>' == 'แผนงานยังไม่ถึงเวลารายงาน' || '<?= $result_sePlain['STATUSNUMBER'] ?>' == 'L' || '<?= $result_sePlain['STATUS'] ?>' == 'แผนงานเลยเวลารายงานตัว')
                                                        {
                                                            edit_vehicletransportplan('แผนงานตรวจร่างกายเรียบร้อย', 'STATUS', '<?= $_GET['vehicletransportplanid'] ?>');
                                                            edit_vehicletransportplan('P', 'STATUSNUMBER', '<?= $_GET['vehicletransportplanid'] ?>');
                                                        }
                                                    } else
                                                    {
                                                        document.getElementById('icon_beforecheckok2').style.display = "none";
                                                        document.getElementById('icon_beforecheckno2').style.display = "";
                                                        if ('<?= $result_sePlain['STATUSNUMBER'] ?>' == 'O' || '<?= $result_sePlain['STATUS'] ?>' == 'แผนงานยังไม่ถึงเวลารายงาน' || '<?= $result_sePlain['STATUSNUMBER'] ?>' == 'L' || '<?= $result_sePlain['STATUS'] ?>' == 'แผนงานเลยเวลารายงานตัว')
                                                        {

                                                            edit_vehicletransportplan('แผนงานยังไม่ถึงเวลารายงาน', 'STATUS', '<?= $_GET['vehicletransportplanid'] ?>');
                                                            edit_vehicletransportplan('O', 'STATUSNUMBER', '<?= $_GET['vehicletransportplanid'] ?>');
                                                        }
                                                    }



                                                }

                                                function rs_resultdirverbefore1()
                                                {
                                                <?php
                                                if ($result_sePlain['COMPANYCODE'] == 'RRC' || $result_sePlain['COMPANYCODE'] == 'RCC' || $result_sePlain['COMPANYCODE'] == 'RATC') {
                                                    $txtrs171_2 = '150';
                                                    $txtrs172_2 = '95';
                                                } else {
                                                    $txtrs171_2 = '150';
                                                    $txtrs172_2 = '95';
                                                }
                                                ?>
                                                    var rs = document.getElementById('txt_rs14').value.split(":");
                                                    
                                                    if (
                                                            chk_rs111.checked == true
                                                            && chk_rs121.checked == true
                                                            && chk_rs131.checked == true

                                                            && rs[0] > 7
                                                            && document.getElementById('txt_rs16').value <= 37
                                                            && (document.getElementById('txt_rs171').value >= 90 && document.getElementById('txt_rs171').value <= <?= $txtrs171_2 ?>)
                                                            && (document.getElementById('txt_rs172').value >= 60 && document.getElementById('txt_rs172').value <= <?= $txtrs172_2 ?>)

                                                            && document.getElementById('txt_rs18').value == 0
                                                            && chk_rs191.checked == true
                                                            && chk_rs1101.checked == true
                                                            && chk_rs1111.checked == true
                                                            && chk_rs1121.checked == true
                                                            && chk_rs1131.checked == true
                                                            && chk_rs1141.checked == true
                                                            && chk_rs1151.checked == true
                                                            && chk_rs1161.checked == true
                                                            && chk_rs1171.checked == true
                                                            && chk_rs1181.checked == true
                                                            && chk_rsshortsightok.checked == true
                                                            && chk_rslongsightok.checked == true
                                                            && chk_rsobliquesightok.checked == true
                                                            && document.getElementById('txt_rs19').value != ""
                                                            )
                                                    {
                                                        
                                                        document.getElementById('icon_beforeresultok1').style.display = "";
                                                        document.getElementById('icon_beforeresultno1').style.display = "none";
                                                        if ('<?= $result_sePlain['STATUSNUMBER'] ?>' == 'O' || '<?= $result_sePlain['STATUS'] ?>' == 'แผนงานยังไม่ถึงเวลารายงาน' || '<?= $result_sePlain['STATUSNUMBER'] ?>' == 'L' || '<?= $result_sePlain['STATUS'] ?>' == 'แผนงานเลยเวลารายงานตัว')
                                                        {
                                                            edit_vehicletransportplan('แผนงานตรวจร่างกายเรียบร้อย', 'STATUS', '<?= $_GET['vehicletransportplanid'] ?>');
                                                            edit_vehicletransportplan('P', 'STATUSNUMBER', '<?= $_GET['vehicletransportplanid'] ?>');
                                                        }


                                                    } else
                                                    {

                                                        document.getElementById('icon_beforeresultok1').style.display = "none";
                                                        document.getElementById('icon_beforeresultno1').style.display = "";
                                                        if ('<?= $result_sePlain['STATUSNUMBER'] ?>' == 'O' || '<?= $result_sePlain['STATUS'] ?>' == 'แผนงานยังไม่ถึงเวลารายงาน' || '<?= $result_sePlain['STATUSNUMBER'] ?>' == 'L' || '<?= $result_sePlain['STATUS'] ?>' == 'แผนงานเลยเวลารายงานตัว')
                                                        {
                                                            edit_vehicletransportplan('แผนงานยังไม่ถึงเวลารายงาน', 'STATUS', '<?= $_GET['vehicletransportplanid'] ?>');
                                                            edit_vehicletransportplan('O', 'STATUSNUMBER', '<?= $_GET['vehicletransportplanid'] ?>');
                                                        }
                                                    }
                                                }
                                                function rs_resultdirverbefore2()
                                                {
                                                <?php
                                                if ($result_sePlain['COMPANYCODE'] == 'RRC' || $result_sePlain['COMPANYCODE'] == 'RCC' || $result_sePlain['COMPANYCODE'] == 'RATC') {
                                                    $txtrs171_2 = '150';
                                                    $txtrs172_2 = '95';
                                                } else {
                                                    $txtrs171_2 = '150';
                                                    $txtrs172_2 = '95';
                                                }
                                                ?>
                                                    var rs = document.getElementById('txt_rs14').value.split(":");
                                                    if (
                                                            chk_rs111.checked == true
                                                            && chk_rs121.checked == true
                                                            && chk_rs131.checked == true
                                                            && rs[0] > 7
                                                            //&& document.getElementById('txt_rs151').value >= 6
                                                            && document.getElementById('txt_rs16').value <= 37
                                                            && (document.getElementById('txt_rs171').value >= 90 && document.getElementById('txt_rs171').value <= <?= $txtrs171_2 ?>)
                                                            && (document.getElementById('txt_rs172').value >= 60 && document.getElementById('txt_rs172').value <= <?= $txtrs172_2 ?>)
                                                            && document.getElementById('txt_rs18').value == 0
                                                            && chk_rs191.checked == true
                                                            && chk_rs1101.checked == true
                                                            && chk_rs1111.checked == true
                                                            && chk_rs1121.checked == true
                                                            && chk_rs1131.checked == true
                                                            && chk_rs1141.checked == true
                                                            && chk_rs1151.checked == true
                                                            && chk_rs1161.checked == true
                                                            && chk_rs1171.checked == true
                                                            && chk_rs1181.checked == true
                                                            && chk_rsshortsightok.checked == true
                                                            && chk_rslongsightok.checked == true
                                                            && chk_rsobliquesightok.checked == true
                                                            && document.getElementById('txt_rs19').value != ""
                                                            )
                                                    {


                                                        document.getElementById('icon_beforeresultok2').style.display = "";
                                                        document.getElementById('icon_beforeresultno2').style.display = "none";
                                                        if ('<?= $result_sePlain['STATUSNUMBER'] ?>' == 'O' || '<?= $result_sePlain['STATUS'] ?>' == 'แผนงานยังไม่ถึงเวลารายงาน' || '<?= $result_sePlain['STATUSNUMBER'] ?>' == 'L' || '<?= $result_sePlain['STATUS'] ?>' == 'แผนงานเลยเวลารายงานตัว')
                                                        {
                                                            edit_vehicletransportplan('แผนงานตรวจร่างกายเรียบร้อย', 'STATUS', '<?= $_GET['vehicletransportplanid'] ?>');
                                                            edit_vehicletransportplan('P', 'STATUSNUMBER', '<?= $_GET['vehicletransportplanid'] ?>');
                                                        }
                                                    } else
                                                    {
                                                        document.getElementById('icon_beforeresultok2').style.display = "none";
                                                        document.getElementById('icon_beforeresultno2').style.display = "";
                                                        if ('<?= $result_sePlain['STATUSNUMBER'] ?>' == 'O' || '<?= $result_sePlain['STATUS'] ?>' == 'แผนงานยังไม่ถึงเวลารายงาน' || '<?= $result_sePlain['STATUSNUMBER'] ?>' == 'L' || '<?= $result_sePlain['STATUS'] ?>' == 'แผนงานเลยเวลารายงานตัว')
                                                        {
                                                            edit_vehicletransportplan('แผนงานยังไม่ถึงเวลารายงาน', 'STATUS', '<?= $_GET['vehicletransportplanid'] ?>');
                                                            edit_vehicletransportplan('O', 'STATUSNUMBER', '<?= $_GET['vehicletransportplanid'] ?>');
                                                        }
                                                    }
                                                }

                                                function rs_checkdirvertransport1()
                                                {
                                                    if (chk_1d1.checked == true && chk_2d1.checked == true && chk_3d1.checked == true && chk_4d1.checked == true && chk_5d1.checked == true && chk_6d1.checked == true && chk_7d1.checked == true)
                                                    {

                                                        edit_vehicletransportplan('แผนงานรอปิดงาน', 'STATUS', '<?= $_GET['vehicletransportplanid'] ?>');
                                                        edit_vehicletransportplan('T', 'STATUSNUMBER', '<?= $_GET['vehicletransportplanid'] ?>');
                                                        document.getElementById('icon_transportcheckok1').style.display = "";
                                                        document.getElementById('icon_transportcheckno1').style.display = "none";
                                                    } else
                                                    {

                                                        //edit_vehicletransportplan('แผนงานเปิดงาน', 'STATUS', '<?= $_GET['vehicletransportplanid'] ?>');
                                                        //edit_vehicletransportplan('1', 'STATUSNUMBER', '<?= $_GET['vehicletransportplanid'] ?>');
                                                        document.getElementById('icon_transportcheckok1').style.display = "none";
                                                        document.getElementById('icon_transportcheckno1').style.display = "";
                                                    }
                                                }
                                                function rs_checkdirvertransport2()
                                                {
                                                    if (
                                                            chk_1d1.checked == true
                                                            && chk_2d1.checked == true
                                                            && chk_3d1.checked == true
                                                            && chk_4d1.checked == true
                                                            && chk_5d1.checked == true
                                                            && chk_6d1.checked == true
                                                            && chk_7d1.checked == true

                                                            )
                                                    {
                                                        //edit_vehicletransportplan('แผนงานรอปิดงาน', 'STATUS', '<?= $_GET['vehicletransportplanid'] ?>');
                                                        //edit_vehicletransportplan('T', 'STATUSNUMBER', '<?= $_GET['vehicletransportplanid'] ?>');
                                                        document.getElementById('icon_transportcheckok2').style.display = "";
                                                        document.getElementById('icon_transportcheckno2').style.display = "none";
                                                    } else
                                                    {
                                                        edit_vehicletransportplan('แผนงานเปิดงาน', 'STATUS', '<?= $_GET['vehicletransportplanid'] ?>');
                                                        edit_vehicletransportplan('1', 'STATUSNUMBER', '<?= $_GET['vehicletransportplanid'] ?>');
                                                        document.getElementById('icon_transportcheckok2').style.display = "none";
                                                        document.getElementById('icon_transportcheckno2').style.display = "";
                                                    }
                                                }
                                                function rs_checkdirveraffter1()
                                                {
                                                    if (
                                                            chk_31.checked == true
                                                            && chk_32.checked == true
                                                            && chk_33.checked == true
                                                            && chk_34.checked == true
                                                            && chk_35.checked == true
                                                            && chk_36.checked == true
                                                            && chk_37.checked == true
                                                            && chk_38.checked == true
                                                            && chk_39.checked == true
                                                            && chk_310.checked == true
                                                            && chk_311.checked == true
                                                            && chk_312.checked == true
                                                            && chk_313.checked == true


                                                            )
                                                    {

                                                        document.getElementById('icon_afftercheckok1').style.display = "";
                                                        document.getElementById('icon_afftercheckno1').style.display = "none";
                                                    } else
                                                    {

                                                        document.getElementById('icon_afftercheckok1').style.display = "none";
                                                        document.getElementById('icon_afftercheckno1').style.display = "";
                                                    }
                                                }
                                                function rs_checkdirveraffter2()
                                                {
                                                    if (
                                                            chk_31.checked == true
                                                            && chk_32.checked == true
                                                            && chk_33.checked == true
                                                            && chk_34.checked == true
                                                            && chk_35.checked == true
                                                            && chk_36.checked == true
                                                            && chk_37.checked == true
                                                            && chk_38.checked == true
                                                            && chk_39.checked == true
                                                            && chk_310.checked == true
                                                            && chk_311.checked == true
                                                            && chk_312.checked == true
                                                            && chk_313.checked == true

                                                            )
                                                    {

                                                        document.getElementById('icon_afftercheckok2').style.display = "";
                                                        document.getElementById('icon_afftercheckno2').style.display = "none";
                                                    } else
                                                    {

                                                        document.getElementById('icon_afftercheckok2').style.display = "none";
                                                        document.getElementById('icon_afftercheckno2').style.display = "";
                                                    }
                                                }


                                                function rs_resultdirveraffter1()
                                                {
                                                    if (
                                                            chk_rs311.checked == true
                                                            && chk_rs321.checked == true
                                                            && chk_rs331.checked == true
                                                            && chk_rs341.checked == true
                                                            && chk_rs351.checked == true
                                                            && chk_rs361.checked == true
                                                            && chk_rs371.checked == true
                                                            && chk_rs381.checked == true
                                                            && chk_rs391.checked == true
                                                            && chk_rs3101.checked == true
                                                            && chk_rs3111.checked == true
                                                            && chk_rs3121.checked == true
                                                            && chk_rs3131.checked == true

                                                            )
                                                    {

                                                        document.getElementById('icon_affterresultok1').style.display = "";
                                                        document.getElementById('icon_affterresultno1').style.display = "none";
                                                    } else
                                                    {

                                                        document.getElementById('icon_affterresultok1').style.display = "none";
                                                        document.getElementById('icon_affterresultno1').style.display = "";
                                                    }
                                                }
                                                function rs_resultdirveraffter2()
                                                {
                                                    if (
                                                            chk_rs311.checked == true
                                                            && chk_rs321.checked == true
                                                            && chk_rs331.checked == true
                                                            && chk_rs341.checked == true
                                                            && chk_rs351.checked == true
                                                            && chk_rs361.checked == true
                                                            && chk_rs371.checked == true
                                                            && chk_rs381.checked == true
                                                            && chk_rs391.checked == true
                                                            && chk_rs3101.checked == true
                                                            && chk_rs3111.checked == true
                                                            && chk_rs3121.checked == true
                                                            && chk_rs3131.checked == true

                                                            )
                                                    {

                                                        document.getElementById('icon_affterresultok2').style.display = "";
                                                        document.getElementById('icon_affterresultno2').style.display = "none";
                                                    } else
                                                    {

                                                        document.getElementById('icon_affterresultok2').style.display = "none";
                                                        document.getElementById('icon_affterresultno2').style.display = "";
                                                    }
                                                }

                                                function edit_vehicletransportplanactualpresent(ID)
                                                {

                                                    $.ajax({
                                                        url: 'meg_data.php',
                                                        type: 'POST',
                                                        data: {
                                                            txt_flg: "edit_vehicletransportplan", ID: ID, fieldname: 'DATEPRESENT', editableObj: 'GETDATE()'
                                                        },
                                                        success: function () {


                                                        }
                                                    });
                                                }
                                                function update_vehicletransportplanjob(rootno, statusnumber)
                                                {
                                                    //edit_vehicletransportplanactualpresent(rootno);
                                                    $.ajax({
                                                        type: 'post',
                                                        url: 'meg_data.php',
                                                        data: {
                                                            txt_flg: "edit_vehicletransportplanjob", rootno: rootno, statusnumber: statusnumber
                                                        },
                                                        success: function () {

                                                            window.location.href = "report_customertenko.php";
                                                        }
                                                    });
                                                }


                                                function edit_rs411(fieldname, ID) {
                                                    if (chk_rs411.checked == true)
                                                    {
                                                        edit_tenkoriskychk('1', fieldname, ID);
                                                        document.getElementById('chk_rs410').checked = false;
                                                        document.getElementById('chk_rs411').disabled = true;
                                                        document.getElementById('chk_rs410').disabled = false;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs411').disabled = false;
                                                        document.getElementById('chk_rs410').disabled = true;
                                                    }

                                                }
                                                function edit_rs421(fieldname, ID) {
                                                    if (chk_rs421.checked == true)
                                                    {
                                                        edit_tenkoriskychk('1', fieldname, ID);
                                                        document.getElementById('chk_rs420').checked = false;
                                                        document.getElementById('chk_rs421').disabled = true;
                                                        document.getElementById('chk_rs420').disabled = false;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs421').disabled = false;
                                                        document.getElementById('chk_rs420').disabled = true;
                                                    }

                                                }
                                                function edit_rs431(fieldname, ID) {
                                                    if (chk_rs431.checked == true)
                                                    {
                                                        edit_tenkoriskychk('1', fieldname, ID);
                                                        document.getElementById('chk_rs430').checked = false;
                                                        document.getElementById('chk_rs431').disabled = true;
                                                        document.getElementById('chk_rs430').disabled = false;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs431').disabled = false;
                                                        document.getElementById('chk_rs430').disabled = true;
                                                    }

                                                }
                                                function edit_rs441(fieldname, ID) {
                                                    if (chk_rs441.checked == true)
                                                    {
                                                        edit_tenkoriskychk('1', fieldname, ID);
                                                        document.getElementById('chk_rs440').checked = false;
                                                        document.getElementById('chk_rs441').disabled = true;
                                                        document.getElementById('chk_rs440').disabled = false;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs441').disabled = false;
                                                        document.getElementById('chk_rs440').disabled = true;
                                                    }

                                                }
                                                function edit_rs451(fieldname, ID) {
                                                    if (chk_rs451.checked == true)
                                                    {
                                                        edit_tenkoriskychk('1', fieldname, ID);
                                                        document.getElementById('chk_rs450').checked = false;
                                                        document.getElementById('chk_rs451').disabled = true;
                                                        document.getElementById('chk_rs450').disabled = false;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs451').disabled = false;
                                                        document.getElementById('chk_rs450').disabled = true;
                                                    }

                                                }
                                                function edit_rs451_h(fieldname, ID) {
                                                    if (chk_rs451_h.checked == true)
                                                    {
                                                        edit_tenkoriskychk('1', fieldname, ID);
                                                        document.getElementById('chk_rs450_h').checked = false;
                                                        document.getElementById('chk_rs451_h').disabled = true;
                                                        document.getElementById('chk_rs450_h').disabled = false;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs451_h').disabled = false;
                                                        document.getElementById('chk_rs450_h').disabled = true;
                                                    }

                                                }
                                                function edit_rs461(fieldname, ID) {
                                                    if (chk_rs461.checked == true)
                                                    {
                                                        edit_tenkoriskychk('1', fieldname, ID);
                                                        document.getElementById('chk_rs460').checked = false;
                                                        document.getElementById('chk_rs461').disabled = true;
                                                        document.getElementById('chk_rs460').disabled = false;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs461').disabled = false;
                                                        document.getElementById('chk_rs460').disabled = true;
                                                    }

                                                }
                                                function edit_rs461_h(fieldname, ID) {
                                                    if (chk_rs461_h.checked == true)
                                                    {
                                                        edit_tenkoriskychk('1', fieldname, ID);
                                                        document.getElementById('chk_rs460_h').checked = false;
                                                        document.getElementById('chk_rs461_h').disabled = true;
                                                        document.getElementById('chk_rs460_h').disabled = false;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs461_h').disabled = false;
                                                        document.getElementById('chk_rs460_h').disabled = true;
                                                    }

                                                }
                                                function edit_rs471(fieldname, ID) {
                                                    if (chk_rs471.checked == true)
                                                    {
                                                        edit_tenkoriskychk('1', fieldname, ID);
                                                        document.getElementById('chk_rs470').checked = false;
                                                        document.getElementById('chk_rs471').disabled = true;
                                                        document.getElementById('chk_rs470').disabled = false;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs471').disabled = false;
                                                        document.getElementById('chk_rs470').disabled = true;
                                                    }

                                                }
                                                function edit_rs471_h(fieldname, ID) {
                                                    if (chk_rs471_h.checked == true)
                                                    {
                                                        edit_tenkoriskychk('1', fieldname, ID);
                                                        document.getElementById('chk_rs470_h').checked = false;
                                                        document.getElementById('chk_rs471_h').disabled = true;
                                                        document.getElementById('chk_rs470_h').disabled = false;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs471_h').disabled = false;
                                                        document.getElementById('chk_rs470_h').disabled = true;
                                                    }

                                                }
                                                function edit_rs481(fieldname, ID) {
                                                    if (chk_rs481.checked == true)
                                                    {
                                                        edit_tenkoriskychk('1', fieldname, ID);
                                                        document.getElementById('chk_rs480').checked = false;
                                                        document.getElementById('chk_rs481').disabled = true;
                                                        document.getElementById('chk_rs480').disabled = false;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs481').disabled = false;
                                                        document.getElementById('chk_rs480').disabled = true;
                                                    }

                                                }
                                                function edit_rs491(fieldname, ID) {
                                                    if (chk_rs491.checked == true)
                                                    {
                                                        edit_tenkoriskychk('1', fieldname, ID);
                                                        document.getElementById('chk_rs490').checked = false;
                                                        document.getElementById('chk_rs491').disabled = true;
                                                        document.getElementById('chk_rs490').disabled = false;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs491').disabled = false;
                                                        document.getElementById('chk_rs490').disabled = true;
                                                    }

                                                }
                                                function edit_rs4101(fieldname, ID) {
                                                    if (chk_rs4101.checked == true)
                                                    {
                                                        edit_tenkoriskychk('1', fieldname, ID);
                                                        document.getElementById('chk_rs4100').checked = false;
                                                        document.getElementById('chk_rs4101').disabled = true;
                                                        document.getElementById('chk_rs4100').disabled = false;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs4101').disabled = false;
                                                        document.getElementById('chk_rs4100').disabled = true;
                                                    }

                                                }
                                                function edit_rs410(fieldname, ID) {
                                                    if (chk_rs410.checked == true)
                                                    {
                                                        edit_tenkoriskychk('0', fieldname, ID);
                                                        document.getElementById('chk_rs411').checked = false;
                                                        document.getElementById('chk_rs411').disabled = false;
                                                        document.getElementById('chk_rs410').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs411').disabled = true;
                                                        document.getElementById('chk_rs410').disabled = false;
                                                    }

                                                }
                                                function edit_rs420(fieldname, ID) {
                                                    if (chk_rs420.checked == true)
                                                    {
                                                        edit_tenkoriskychk('0', fieldname, ID);
                                                        document.getElementById('chk_rs421').checked = false;
                                                        document.getElementById('chk_rs421').disabled = false;
                                                        document.getElementById('chk_rs420').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs421').disabled = true;
                                                        document.getElementById('chk_rs420').disabled = false;
                                                    }

                                                }
                                                function edit_rs430(fieldname, ID) {
                                                    if (chk_rs430.checked == true)
                                                    {
                                                        edit_tenkoriskychk('0', fieldname, ID);
                                                        document.getElementById('chk_rs431').checked = false;
                                                        document.getElementById('chk_rs431').disabled = false;
                                                        document.getElementById('chk_rs430').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs431').disabled = true;
                                                        document.getElementById('chk_rs430').disabled = false;
                                                    }

                                                }
                                                function edit_rs440(fieldname, ID) {
                                                    if (chk_rs440.checked == true)
                                                    {
                                                        edit_tenkoriskychk('0', fieldname, ID);
                                                        document.getElementById('chk_rs441').checked = false;
                                                        document.getElementById('chk_rs441').disabled = false;
                                                        document.getElementById('chk_rs440').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs441').disabled = true;
                                                        document.getElementById('chk_rs440').disabled = false;
                                                    }

                                                }
                                                function edit_rs450(fieldname, ID) {
                                                    if (chk_rs450.checked == true)
                                                    {
                                                        edit_tenkoriskychk('0', fieldname, ID);
                                                        document.getElementById('chk_rs451').checked = false;
                                                        document.getElementById('chk_rs451').disabled = false;
                                                        document.getElementById('chk_rs450').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs451').disabled = true;
                                                        document.getElementById('chk_rs450').disabled = false;
                                                    }

                                                }
                                                function edit_rs450_h(fieldname, ID) {
                                                    if (chk_rs450_h.checked == true)
                                                    {
                                                        edit_tenkoriskychk('0', fieldname, ID);
                                                        document.getElementById('chk_rs451_h').checked = false;
                                                        document.getElementById('chk_rs451_h').disabled = false;
                                                        document.getElementById('chk_rs450_h').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs451_h').disabled = true;
                                                        document.getElementById('chk_rs450_h').disabled = false;
                                                    }

                                                }
                                                function edit_rs460(fieldname, ID) {
                                                    if (chk_rs460.checked == true)
                                                    {
                                                        edit_tenkoriskychk('0', fieldname, ID);
                                                        document.getElementById('chk_rs461').checked = false;
                                                        document.getElementById('chk_rs461').disabled = false;
                                                        document.getElementById('chk_rs460').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs461').disabled = true;
                                                        document.getElementById('chk_rs460').disabled = false;
                                                    }

                                                }
                                                function edit_rs460_h(fieldname, ID) {
                                                    if (chk_rs460_h.checked == true)
                                                    {
                                                        edit_tenkoriskychk('0', fieldname, ID);
                                                        document.getElementById('chk_rs461_h').checked = false;
                                                        document.getElementById('chk_rs461_h').disabled = false;
                                                        document.getElementById('chk_rs460_h').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs461_h').disabled = true;
                                                        document.getElementById('chk_rs460_h').disabled = false;
                                                    }

                                                }
                                                function edit_rs470(fieldname, ID) {
                                                    if (chk_rs470.checked == true)
                                                    {
                                                        edit_tenkoriskychk('0', fieldname, ID);
                                                        document.getElementById('chk_rs471').checked = false;
                                                        document.getElementById('chk_rs471').disabled = false;
                                                        document.getElementById('chk_rs470').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs471').disabled = true;
                                                        document.getElementById('chk_rs470').disabled = false;
                                                    }

                                                }
                                                function edit_rs470_h(fieldname, ID) {
                                                    if (chk_rs470_h.checked == true)
                                                    {
                                                        edit_tenkoriskychk('0', fieldname, ID);
                                                        document.getElementById('chk_rs471_h').checked = false;
                                                        document.getElementById('chk_rs471_h').disabled = false;
                                                        document.getElementById('chk_rs470_h').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs471_h').disabled = true;
                                                        document.getElementById('chk_rs470_h').disabled = false;
                                                    }

                                                }
                                                function edit_rs480(fieldname, ID) {
                                                    if (chk_rs480.checked == true)
                                                    {
                                                        edit_tenkoriskychk('0', fieldname, ID);
                                                        document.getElementById('chk_rs481').checked = false;
                                                        document.getElementById('chk_rs481').disabled = false;
                                                        document.getElementById('chk_rs480').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs481').disabled = true;
                                                        document.getElementById('chk_rs480').disabled = false;
                                                    }

                                                }
                                                function edit_rs490(fieldname, ID) {
                                                    if (chk_rs490.checked == true)
                                                    {
                                                        edit_tenkoriskychk('0', fieldname, ID);
                                                        document.getElementById('chk_rs491').checked = false;
                                                        document.getElementById('chk_rs491').disabled = false;
                                                        document.getElementById('chk_rs490').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs491').disabled = true;
                                                        document.getElementById('chk_rs490').disabled = false;
                                                    }

                                                }
                                                function edit_rs4100(fieldname, ID) {
                                                    if (chk_rs4100.checked == true)
                                                    {
                                                        edit_tenkoriskychk('0', fieldname, ID);
                                                        document.getElementById('chk_rs4101').checked = false;
                                                        document.getElementById('chk_rs4101').disabled = false;
                                                        document.getElementById('chk_rs4100').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoriskychk('', fieldname, ID);
                                                        document.getElementById('chk_rs4101').disabled = true;
                                                        document.getElementById('chk_rs4100').disabled = false;
                                                    }

                                                }








                                                function edit_rs311(fieldname, ID) {
                                                    if (chk_rs311.checked == true)
                                                    {

                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                        document.getElementById('chk_rs310').checked = false;
                                                        document.getElementById('chk_rs310').disabled = false;
                                                        document.getElementById('chk_rs311').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs310').disabled = true;
                                                        document.getElementById('chk_rs311').disabled = false;
                                                    }


                                                }

                                                function edit_rs321(fieldname, ID) {
                                                    if (chk_rs321.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                        document.getElementById('chk_rs320').checked = false;
                                                        document.getElementById('chk_rs320').disabled = false;
                                                        document.getElementById('chk_rs321').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs320').disabled = true;
                                                        document.getElementById('chk_rs321').disabled = false;
                                                    }

                                                }
                                                function edit_rs331(fieldname, ID) {
                                                    if (chk_rs331.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                        document.getElementById('chk_rs330').checked = false;
                                                        document.getElementById('chk_rs330').disabled = false;
                                                        document.getElementById('chk_rs331').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs330').disabled = true;
                                                        document.getElementById('chk_rs331').disabled = false;
                                                    }

                                                }
                                                function edit_rs341(fieldname, ID) {
                                                    if (chk_rs341.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                        document.getElementById('chk_rs340').checked = false;
                                                        document.getElementById('chk_rs340').disabled = false;
                                                        document.getElementById('chk_rs341').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs340').disabled = true;
                                                        document.getElementById('chk_rs341').disabled = false;
                                                    }

                                                }
                                                function edit_rs351(fieldname, ID) {
                                                    if (chk_rs351.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                        document.getElementById('chk_rs350').checked = false;
                                                        document.getElementById('chk_rs350').disabled = false;
                                                        document.getElementById('chk_rs351').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs350').disabled = true;
                                                        document.getElementById('chk_rs351').disabled = false;
                                                    }

                                                }
                                                function edit_rs361(fieldname, ID) {
                                                    if (chk_rs361.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                        document.getElementById('chk_rs360').checked = false;
                                                        document.getElementById('chk_rs360').disabled = false;
                                                        document.getElementById('chk_rs361').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs360').disabled = true;
                                                        document.getElementById('chk_rs361').disabled = false;
                                                    }

                                                }
                                                function edit_rs371(fieldname, ID) {
                                                    if (chk_rs371.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                        document.getElementById('chk_rs370').checked = false;
                                                        document.getElementById('chk_rs370').disabled = false;
                                                        document.getElementById('chk_rs371').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs370').disabled = true;
                                                        document.getElementById('chk_rs371').disabled = false;
                                                    }

                                                }
                                                function edit_rs381(fieldname, ID) {
                                                    if (chk_rs381.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                        document.getElementById('chk_rs380').checked = false;
                                                        document.getElementById('chk_rs380').disabled = false;
                                                        document.getElementById('chk_rs381').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs380').disabled = true;
                                                        document.getElementById('chk_rs381').disabled = false;
                                                    }

                                                }
                                                function edit_rs391(fieldname, ID) {
                                                    if (chk_rs391.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                        document.getElementById('chk_rs390').checked = false;
                                                        document.getElementById('chk_rs390').disabled = false;
                                                        document.getElementById('chk_rs391').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs390').disabled = true;
                                                        document.getElementById('chk_rs391').disabled = false;
                                                    }

                                                }
                                                function edit_rs3101(fieldname, ID) {
                                                    if (chk_rs3101.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                        document.getElementById('chk_rs3100').checked = false;
                                                        document.getElementById('chk_rs3100').disabled = false;
                                                        document.getElementById('chk_rs3101').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs3100').disabled = true;
                                                        document.getElementById('chk_rs3101').disabled = false;
                                                    }

                                                }
                                                function edit_rs3111(fieldname, ID) {
                                                    if (chk_rs3111.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                        document.getElementById('chk_rs3110').checked = false;
                                                        document.getElementById('chk_rs3110').disabled = false;
                                                        document.getElementById('chk_rs3111').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs3110').disabled = true;
                                                        document.getElementById('chk_rs3111').disabled = false;
                                                    }

                                                }
                                                function edit_rs3121(fieldname, ID) {
                                                    if (chk_rs3121.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                        document.getElementById('chk_rs3120').checked = false;
                                                        document.getElementById('chk_rs3120').disabled = false;
                                                        document.getElementById('chk_rs3121').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs3120').disabled = true;
                                                        document.getElementById('chk_rs3121').disabled = false;
                                                    }

                                                }
                                                function edit_rs3131(fieldname, ID) {
                                                    if (chk_rs3131.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                        document.getElementById('chk_rs3130').checked = false;
                                                        document.getElementById('chk_rs3130').disabled = false;
                                                        document.getElementById('chk_rs3131').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs3130').disabled = true;
                                                        document.getElementById('chk_rs3131').disabled = false;
                                                    }

                                                }



                                                function edit_rs310(fieldname, ID) {
                                                    if (chk_rs310.checked == true)
                                                    {
                                                        edit_tenkoafterchk('0', fieldname, ID);
                                                        document.getElementById('chk_rs311').checked = false;
                                                        document.getElementById('chk_rs311').disabled = false;
                                                        document.getElementById('chk_rs310').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs311').disabled = true;
                                                        document.getElementById('chk_rs310').disabled = false;
                                                    }

                                                }

                                                function edit_rs320(fieldname, ID) {
                                                    if (chk_rs320.checked == true)
                                                    {
                                                        edit_tenkoafterchk('0', fieldname, ID);
                                                        document.getElementById('chk_rs321').checked = false;
                                                        document.getElementById('chk_rs321').disabled = false;
                                                        document.getElementById('chk_rs320').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs321').disabled = true;
                                                        document.getElementById('chk_rs320').disabled = false;
                                                    }

                                                }
                                                function edit_rs330(fieldname, ID) {
                                                    if (chk_rs330.checked == true)
                                                    {
                                                        edit_tenkoafterchk('0', fieldname, ID);
                                                        document.getElementById('chk_rs331').checked = false;
                                                        document.getElementById('chk_rs331').disabled = false;
                                                        document.getElementById('chk_rs330').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs331').disabled = true;
                                                        document.getElementById('chk_rs330').disabled = false;
                                                    }

                                                }
                                                function edit_rs340(fieldname, ID) {
                                                    if (chk_rs340.checked == true)
                                                    {
                                                        edit_tenkoafterchk('0', fieldname, ID);
                                                        document.getElementById('chk_rs341').checked = false;
                                                        document.getElementById('chk_rs341').disabled = false;
                                                        document.getElementById('chk_rs340').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs341').disabled = true;
                                                        document.getElementById('chk_rs340').disabled = false;
                                                    }

                                                }
                                                function edit_rs350(fieldname, ID) {
                                                    if (chk_rs350.checked == true)
                                                    {
                                                        edit_tenkoafterchk('0', fieldname, ID);
                                                        document.getElementById('chk_rs351').checked = false;
                                                        document.getElementById('chk_rs351').disabled = false;
                                                        document.getElementById('chk_rs350').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs351').disabled = true;
                                                        document.getElementById('chk_rs350').disabled = false;
                                                    }

                                                }
                                                function edit_rs360(fieldname, ID) {
                                                    if (chk_rs360.checked == true)
                                                    {
                                                        edit_tenkoafterchk('0', fieldname, ID);
                                                        document.getElementById('chk_rs361').checked = false;
                                                        document.getElementById('chk_rs361').disabled = false;
                                                        document.getElementById('chk_rs360').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs361').disabled = true;
                                                        document.getElementById('chk_rs360').disabled = false;
                                                    }

                                                }
                                                function edit_rs370(fieldname, ID) {
                                                    if (chk_rs370.checked == true)
                                                    {
                                                        edit_tenkoafterchk('0', fieldname, ID);
                                                        document.getElementById('chk_rs371').checked = false;
                                                        document.getElementById('chk_rs371').disabled = false;
                                                        document.getElementById('chk_rs370').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs371').disabled = true;
                                                        document.getElementById('chk_rs370').disabled = false;
                                                    }

                                                }
                                                function edit_rs380(fieldname, ID) {
                                                    if (chk_rs380.checked == true)
                                                    {
                                                        edit_tenkoafterchk('0', fieldname, ID);
                                                        document.getElementById('chk_rs381').checked = false;
                                                        document.getElementById('chk_rs381').disabled = false;
                                                        document.getElementById('chk_rs380').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs381').disabled = true;
                                                        document.getElementById('chk_rs380').disabled = false;
                                                    }

                                                }
                                                function edit_rs390(fieldname, ID) {
                                                    if (chk_rs390.checked == true)
                                                    {
                                                        edit_tenkoafterchk('0', fieldname, ID);
                                                        document.getElementById('chk_rs391').checked = false;
                                                        document.getElementById('chk_rs391').disabled = false;
                                                        document.getElementById('chk_rs390').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs391').disabled = true;
                                                        document.getElementById('chk_rs390').disabled = false;
                                                    }

                                                }
                                                function edit_rs3100(fieldname, ID) {
                                                    if (chk_rs3100.checked == true)
                                                    {
                                                        edit_tenkoafterchk('0', fieldname, ID);
                                                        document.getElementById('chk_rs3101').checked = false;
                                                        document.getElementById('chk_rs3101').disabled = false;
                                                        document.getElementById('chk_rs3100').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs3101').disabled = true;
                                                        document.getElementById('chk_rs3100').disabled = false;
                                                    }

                                                }
                                                function edit_rs3110(fieldname, ID) {
                                                    if (chk_rs3110.checked == true)
                                                    {
                                                        edit_tenkoafterchk('0', fieldname, ID);
                                                        document.getElementById('chk_rs3111').checked = false;
                                                        document.getElementById('chk_rs3111').disabled = false;
                                                        document.getElementById('chk_rs3110').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs3111').disabled = true;
                                                        document.getElementById('chk_rs3110').disabled = false;
                                                    }

                                                }
                                                function edit_rs3120(fieldname, ID) {
                                                    if (chk_rs3120.checked == true)
                                                    {
                                                        edit_tenkoafterchk('0', fieldname, ID);
                                                        document.getElementById('chk_rs3121').checked = false;
                                                        document.getElementById('chk_rs3121').disabled = false;
                                                        document.getElementById('chk_rs3120').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs3121').disabled = true;
                                                        document.getElementById('chk_rs3120').disabled = false;
                                                    }

                                                }
                                                function edit_rs3130(fieldname, ID) {
                                                    if (chk_rs3130.checked == true)
                                                    {
                                                        edit_tenkoafterchk('0', fieldname, ID);
                                                        document.getElementById('chk_rs3131').checked = false;
                                                        document.getElementById('chk_rs3131').disabled = false;
                                                        document.getElementById('chk_rs3130').disabled = true;
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                        document.getElementById('chk_rs3131').disabled = true;
                                                        document.getElementById('chk_rs3130').disabled = false;
                                                    }

                                                }

                                                function edit_check31(fieldname, ID) {
                                                    if (chk_31.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                    }


                                                }
                                                function edit_check32(fieldname, ID) {
                                                    if (chk_32.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                    }


                                                }
                                                function edit_check33(fieldname, ID) {
                                                    if (chk_33.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                    }


                                                }
                                                function edit_check34(fieldname, ID) {
                                                    if (chk_34.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                    }


                                                }
                                                function edit_check35(fieldname, ID) {
                                                    if (chk_35.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                    }


                                                }
                                                function edit_check36(fieldname, ID) {
                                                    if (chk_36.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                    }


                                                }
                                                function edit_check37(fieldname, ID) {
                                                    if (chk_37.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                    }


                                                }
                                                function edit_check38(fieldname, ID) {
                                                    if (chk_38.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                    }


                                                }
                                                function edit_check39(fieldname, ID) {
                                                    if (chk_39.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                    }


                                                }
                                                function edit_check310(fieldname, ID) {
                                                    if (chk_310.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                    }


                                                }
                                                function edit_check311(fieldname, ID) {
                                                    if (chk_311.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                    }


                                                }
                                                function edit_check312(fieldname, ID) {
                                                    if (chk_312.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                    }

                                                }
                                                function edit_check313(fieldname, ID) {
                                                    if (chk_313.checked == true)
                                                    {
                                                        edit_tenkoafterchk('1', fieldname, ID);
                                                    } else
                                                    {
                                                        edit_tenkoafterchk('', fieldname, ID);
                                                    }


                                                }


                                                function edit_check1d1(fieldname, ID, tenkotransportdate) {
                                                    if (chk_1d1.checked == true)
                                                    {

                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check2d1(fieldname, ID, tenkotransportdate) {
                                                    if (chk_2d1.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }


                                                }
                                                function edit_check3d1(fieldname, ID, tenkotransportdate) {
                                                    if (chk_3d1.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check4d1(fieldname, ID, tenkotransportdate) {
                                                    if (chk_4d1.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check5d1(fieldname, ID, tenkotransportdate) {
                                                    if (chk_5d1.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check6d1(fieldname, ID, tenkotransportdate) {
                                                    if (chk_6d1.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check7d1(fieldname, ID, tenkotransportdate) {
                                                    if (chk_7d1.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }


                                                }


                                                function edit_check1d2(fieldname, ID, tenkotransportdate) {
                                                    if (chk_1d2.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check2d2(fieldname, ID, tenkotransportdate) {
                                                    if (chk_2d2.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }


                                                }
                                                function edit_check3d2(fieldname, ID, tenkotransportdate) {
                                                    if (chk_3d2.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check4d2(fieldname, ID, tenkotransportdate) {
                                                    if (chk_4d2.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check5d2(fieldname, ID, tenkotransportdate) {
                                                    if (chk_5d2.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check6d2(fieldname, ID, tenkotransportdate) {
                                                    if (chk_6d2.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check7d2(fieldname, ID, tenkotransportdate) {
                                                    if (chk_7d2.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }


                                                }



                                                function edit_check1d3(fieldname, ID, tenkotransportdate) {
                                                    if (chk_1d3.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check2d3(fieldname, ID, tenkotransportdate) {
                                                    if (chk_2d3.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }


                                                }
                                                function edit_check3d3(fieldname, ID, tenkotransportdate) {
                                                    if (chk_3d3.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check4d3(fieldname, ID, tenkotransportdate) {
                                                    if (chk_4d3.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check5d3(fieldname, ID, tenkotransportdate) {
                                                    if (chk_5d3.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check6d3(fieldname, ID, tenkotransportdate) {
                                                    if (chk_6d3.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check7d3(fieldname, ID, tenkotransportdate) {
                                                    if (chk_7d3.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }


                                                }





                                                function edit_check1d4(fieldname, ID, tenkotransportdate) {
                                                    if (chk_1d4.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check2d4(fieldname, ID, tenkotransportdate) {
                                                    if (chk_2d4.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }


                                                }
                                                function edit_check3d4(fieldname, ID, tenkotransportdate) {
                                                    if (chk_3d4.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check4d4(fieldname, ID, tenkotransportdate) {
                                                    if (chk_4d4.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check5d4(fieldname, ID, tenkotransportdate) {
                                                    if (chk_5d4.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check6d4(fieldname, ID, tenkotransportdate) {
                                                    if (chk_6d4.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check7d4(fieldname, ID, tenkotransportdate) {
                                                    if (chk_7d4.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }


                                                }






                                                function edit_check1d5(fieldname, ID, tenkotransportdate) {
                                                    if (chk_1d5.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check2d5(fieldname, ID, tenkotransportdate) {
                                                    if (chk_2d5.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }


                                                }
                                                function edit_check3d5(fieldname, ID, tenkotransportdate) {
                                                    if (chk_3d5.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check4d5(fieldname, ID, tenkotransportdate) {
                                                    if (chk_4d5.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check5d5(fieldname, ID, tenkotransportdate) {
                                                    if (chk_5d5.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check6d5(fieldname, ID, tenkotransportdate) {
                                                    if (chk_6d5.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }

                                                }
                                                function edit_check7d5(fieldname, ID, tenkotransportdate) {
                                                    if (chk_7d5.checked == true)
                                                    {
                                                        edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                    } else
                                                    {
                                                        edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                    }


                                                }






                                                function edit_rs110() {

                                                    if (chk_rs110.checked == true)
                                                    {

                                                        document.getElementById('chk_rs111').checked = false;
                                                        document.getElementById('chk_rs110').disabled = true;
                                                        document.getElementById('chk_rs111').disabled = false;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs110').disabled = false;
                                                        document.getElementById('chk_rs111').disabled = true;
                                                    }

                                                }
                                                function edit_rs120() {
                                                    if (chk_rs120.checked == true)
                                                    {

                                                        document.getElementById('chk_rs121').checked = false;
                                                        document.getElementById('chk_rs120').disabled = true;
                                                        document.getElementById('chk_rs121').disabled = false;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs121').disabled = true;
                                                        document.getElementById('chk_rs120').disabled = false;
                                                    }

                                                }
                                                function edit_rs130() {
                                                    if (chk_rs130.checked == true)
                                                    {

                                                        document.getElementById('chk_rs131').checked = false;
                                                        document.getElementById('chk_rs130').disabled = true;
                                                        document.getElementById('chk_rs131').disabled = false;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs131').disabled = true;
                                                        document.getElementById('chk_rs130').disabled = false;
                                                    }

                                                }
                                                function edit_rs140() {
                                                    if (chk_rs140.checked == true)
                                                    {

                                                        document.getElementById('chk_rs141').checked = false;
                                                        document.getElementById('chk_rs140').disabled = true;
                                                        document.getElementById('chk_rs141').disabled = false;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs141').disabled = true;
                                                        document.getElementById('chk_rs140').disabled = false;
                                                    }

                                                }
                                                function edit_rs150() {
                                                    if (chk_rs150.checked == true)
                                                    {

                                                        document.getElementById('chk_rs151').checked = false;
                                                        document.getElementById('chk_rs150').disabled = true;
                                                        document.getElementById('chk_rs151').disabled = false;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs151').disabled = true;
                                                        document.getElementById('chk_rs150').disabled = false;
                                                    }

                                                }
                                                function edit_rs160() {
                                                    if (chk_rs160.checked == true)
                                                    {

                                                        document.getElementById('chk_rs161').checked = false;
                                                        document.getElementById('chk_rs160').disabled = true;
                                                        document.getElementById('chk_rs161').disabled = false;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs161').disabled = true;
                                                        document.getElementById('chk_rs160').disabled = false;
                                                    }

                                                }
                                                function edit_rs170() {
                                                    if (chk_rs170.checked == true)
                                                    {

                                                        document.getElementById('chk_rs171').checked = false;
                                                        document.getElementById('chk_rs170').disabled = true;
                                                        document.getElementById('chk_rs171').disabled = false;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs171').disabled = true;
                                                        document.getElementById('chk_rs170').disabled = false;
                                                    }

                                                }
                                                function edit_rs180() {
                                                    if (chk_rs180.checked == true)
                                                    {

                                                        document.getElementById('chk_rs181').checked = false;
                                                        document.getElementById('chk_rs180').disabled = true;
                                                        document.getElementById('chk_rs181').disabled = false;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs181').disabled = true;
                                                        document.getElementById('chk_rs180').disabled = false;
                                                    }

                                                }
                                                function edit_rs190() {
                                                    if (chk_rs190.checked == true)
                                                    {

                                                        document.getElementById('chk_rs191').checked = false;
                                                        document.getElementById('chk_rs190').disabled = true;
                                                        document.getElementById('chk_rs191').disabled = false;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs191').disabled = true;
                                                        document.getElementById('chk_rs190').disabled = false;
                                                    }

                                                }
                                                function edit_rs1100() {
                                                    if (chk_rs1100.checked == true)
                                                    {

                                                        document.getElementById('chk_rs1101').checked = false;
                                                        document.getElementById('chk_rs1100').disabled = true;
                                                        document.getElementById('chk_rs1101').disabled = false;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs1101').disabled = true;
                                                        document.getElementById('chk_rs1100').disabled = false;
                                                    }

                                                }
                                                function edit_rs1110() {
                                                    if (chk_rs1110.checked == true)
                                                    {

                                                        document.getElementById('chk_rs1111').checked = false;
                                                        document.getElementById('chk_rs1110').disabled = true;
                                                        document.getElementById('chk_rs1111').disabled = false;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs1111').disabled = true;
                                                        document.getElementById('chk_rs1110').disabled = false;
                                                    }

                                                }
                                                function edit_rs1120() {
                                                    if (chk_rs1120.checked == true)
                                                    {

                                                        document.getElementById('chk_rs1121').checked = false;
                                                        document.getElementById('chk_rs1120').disabled = true;
                                                        document.getElementById('chk_rs1121').disabled = false;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs1121').disabled = true;
                                                        document.getElementById('chk_rs1120').disabled = false;
                                                    }

                                                }
                                                function edit_rs1130() {
                                                    if (chk_rs1130.checked == true)
                                                    {

                                                        document.getElementById('chk_rs1131').checked = false;
                                                        document.getElementById('chk_rs1130').disabled = true;
                                                        document.getElementById('chk_rs1131').disabled = false;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs1131').disabled = true;
                                                        document.getElementById('chk_rs1130').disabled = false;
                                                    }

                                                }
                                                function edit_rs1140() {
                                                    if (chk_rs1140.checked == true)
                                                    {

                                                        document.getElementById('chk_rs1141').checked = false;
                                                        document.getElementById('chk_rs1140').disabled = true;
                                                        document.getElementById('chk_rs1141').disabled = false;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs1141').disabled = true;
                                                        document.getElementById('chk_rs1140').disabled = false;
                                                    }

                                                }
                                                function edit_rs1150() {
                                                    if (chk_rs1150.checked == true)
                                                    {

                                                        document.getElementById('chk_rs1151').checked = false;
                                                        document.getElementById('chk_rs1150').disabled = true;
                                                        document.getElementById('chk_rs1151').disabled = false;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs1151').disabled = true;
                                                        document.getElementById('chk_rs1150').disabled = false;
                                                    }

                                                }
                                                function edit_rs1160() {
                                                    if (chk_rs1160.checked == true)
                                                    {

                                                        document.getElementById('chk_rs1161').checked = false;
                                                        document.getElementById('chk_rs1160').disabled = true;
                                                        document.getElementById('chk_rs1161').disabled = false;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs1161').disabled = true;
                                                        document.getElementById('chk_rs1160').disabled = false;
                                                    }

                                                }
                                                function edit_rs1170() {
                                                    if (chk_rs1170.checked == true)
                                                    {

                                                        document.getElementById('chk_rs1171').checked = false;
                                                        document.getElementById('chk_rs1170').disabled = true;
                                                        document.getElementById('chk_rs1171').disabled = false;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs1171').disabled = true;
                                                        document.getElementById('chk_rs1170').disabled = false;
                                                    }

                                                }
                                                function edit_rs1180() {
                                                    if (chk_rs1180.checked == true)
                                                    {

                                                        document.getElementById('chk_rs1181').checked = false;
                                                        document.getElementById('chk_rs1180').disabled = true;
                                                        document.getElementById('chk_rs1181').disabled = false;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs1181').disabled = true;
                                                        document.getElementById('chk_rs1180').disabled = false;
                                                    }


                                                }
                                                function edit_rs1190() {
                                                    if (chk_rs1190.checked == true)
                                                    {

                                                        document.getElementById('chk_rs1191').checked = false;
                                                        document.getElementById('chk_rs1190').disabled = true;
                                                        document.getElementById('chk_rs1191').disabled = false;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs1191').disabled = true;
                                                        document.getElementById('chk_rs1190').disabled = false;
                                                    }


                                                }
                                                function edit_rs111() {
                                                    if (chk_rs111.checked == true)
                                                    {


                                                        document.getElementById('chk_rs110').checked = false;
                                                        document.getElementById('chk_rs110').disabled = false;
                                                        document.getElementById('chk_rs111').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs110').disabled = true;
                                                        document.getElementById('chk_rs111').disabled = false;
                                                    }


                                                }
                                                function edit_rs121() {
                                                    if (chk_rs121.checked == true)
                                                    {

                                                        document.getElementById('chk_rs120').checked = false;
                                                        document.getElementById('chk_rs120').disabled = false;
                                                        document.getElementById('chk_rs121').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs120').disabled = true;
                                                        document.getElementById('chk_rs121').disabled = false;
                                                    }

                                                }
                                                function edit_rs131() {
                                                    if (chk_rs131.checked == true)
                                                    {

                                                        document.getElementById('chk_rs130').checked = false;
                                                        document.getElementById('chk_rs130').disabled = false;
                                                        document.getElementById('chk_rs131').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs130').disabled = true;
                                                        document.getElementById('chk_rs131').disabled = false;
                                                    }

                                                }
                                                function edit_rs141() {
                                                    if (chk_rs141.checked == true)
                                                    {

                                                        document.getElementById('chk_rs140').checked = false;
                                                        document.getElementById('chk_rs140').disabled = false;
                                                        document.getElementById('chk_rs141').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs140').disabled = true;
                                                        document.getElementById('chk_rs141').disabled = false;
                                                    }

                                                }
                                                function edit_rs151() {
                                                    if (chk_rs151.checked == true)
                                                    {

                                                        document.getElementById('chk_rs150').checked = false;
                                                        document.getElementById('chk_rs150').disabled = false;
                                                        document.getElementById('chk_rs151').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs150').disabled = true;
                                                        document.getElementById('chk_rs151').disabled = false;
                                                    }

                                                }
                                                function edit_rs161() {
                                                    if (chk_rs161.checked == true)
                                                    {

                                                        document.getElementById('chk_rs160').checked = false;
                                                        document.getElementById('chk_rs160').disabled = false;
                                                        document.getElementById('chk_rs161').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs160').disabled = true;
                                                        document.getElementById('chk_rs161').disabled = false;
                                                    }

                                                }
                                                function edit_rs171() {
                                                    if (chk_rs171.checked == true)
                                                    {

                                                        document.getElementById('chk_rs170').checked = false;
                                                        document.getElementById('chk_rs170').disabled = false;
                                                        document.getElementById('chk_rs171').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs170').disabled = true;
                                                        document.getElementById('chk_rs171').disabled = false;
                                                    }

                                                }
                                                function edit_rs181() {
                                                    if (chk_rs181.checked == true)
                                                    {

                                                        document.getElementById('chk_rs180').checked = false;
                                                        document.getElementById('chk_rs180').disabled = false;
                                                        document.getElementById('chk_rs181').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs180').disabled = true;
                                                        document.getElementById('chk_rs181').disabled = false;
                                                    }

                                                }
                                                function edit_rs191() {
                                                    if (chk_rs191.checked == true)
                                                    {

                                                        document.getElementById('chk_rs190').checked = false;
                                                        document.getElementById('chk_rs190').disabled = false;
                                                        document.getElementById('chk_rs191').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs190').disabled = true;
                                                        document.getElementById('chk_rs191').disabled = false;
                                                    }

                                                }
                                                function edit_rs1101() {
                                                    if (chk_rs1101.checked == true)
                                                    {

                                                        document.getElementById('chk_rs1100').checked = false;
                                                        document.getElementById('chk_rs1100').disabled = false;
                                                        document.getElementById('chk_rs1101').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs1100').disabled = true;
                                                        document.getElementById('chk_rs1101').disabled = false;
                                                    }

                                                }
                                                function edit_rs1111() {
                                                    if (chk_rs1111.checked == true)
                                                    {

                                                        document.getElementById('chk_rs1110').checked = false;
                                                        document.getElementById('chk_rs1110').disabled = false;
                                                        document.getElementById('chk_rs1111').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs1110').disabled = true;
                                                        document.getElementById('chk_rs1111').disabled = false;
                                                    }

                                                }
                                                function edit_rs1121() {
                                                    if (chk_rs1121.checked == true)
                                                    {

                                                        document.getElementById('chk_rs1120').checked = false;
                                                        document.getElementById('chk_rs1120').disabled = false;
                                                        document.getElementById('chk_rs1121').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs1120').disabled = true;
                                                        document.getElementById('chk_rs1121').disabled = false;
                                                    }

                                                }
                                                function edit_rs1131() {
                                                    if (chk_rs1131.checked == true)
                                                    {

                                                        document.getElementById('chk_rs1130').checked = false;
                                                        document.getElementById('chk_rs1130').disabled = false;
                                                        document.getElementById('chk_rs1131').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs1130').disabled = true;
                                                        document.getElementById('chk_rs1131').disabled = false;
                                                    }

                                                }
                                                function edit_rs1141() {
                                                    if (chk_rs1141.checked == true)
                                                    {

                                                        document.getElementById('chk_rs1140').checked = false;
                                                        document.getElementById('chk_rs1140').disabled = false;
                                                        document.getElementById('chk_rs1141').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs1140').disabled = true;
                                                        document.getElementById('chk_rs1141').disabled = false;
                                                    }

                                                }
                                                function edit_rs1151() {
                                                    if (chk_rs1151.checked == true)
                                                    {

                                                        document.getElementById('chk_rs1150').checked = false;
                                                        document.getElementById('chk_rs1150').disabled = false;
                                                        document.getElementById('chk_rs1151').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs1150').disabled = true;
                                                        document.getElementById('chk_rs1151').disabled = false;
                                                    }

                                                }
                                                function edit_rs1161() {
                                                    if (chk_rs1161.checked == true)
                                                    {

                                                        document.getElementById('chk_rs1160').checked = false;
                                                        document.getElementById('chk_rs1160').disabled = false;
                                                        document.getElementById('chk_rs1161').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs1160').disabled = true;
                                                        document.getElementById('chk_rs1161').disabled = false;
                                                    }

                                                }
                                                function edit_rs1171() {
                                                    if (chk_rs1171.checked == true)
                                                    {

                                                        document.getElementById('chk_rs1170').checked = false;
                                                        document.getElementById('chk_rs1170').disabled = false;
                                                        document.getElementById('chk_rs1171').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs1170').disabled = true;
                                                        document.getElementById('chk_rs1171').disabled = false;
                                                    }

                                                }
                                                function edit_rs1181() {
                                                    if (chk_rs1181.checked == true)
                                                    {

                                                        document.getElementById('chk_rs1180').checked = false;
                                                        document.getElementById('chk_rs1180').disabled = false;
                                                        document.getElementById('chk_rs1181').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs1180').disabled = true;
                                                        document.getElementById('chk_rs1181').disabled = false;
                                                    }


                                                }
                                                function edit_rs1191() {
                                                    if (chk_rs1191.checked == true)
                                                    {

                                                        document.getElementById('chk_rs1190').checked = false;
                                                        document.getElementById('chk_rs1190').disabled = false;
                                                        document.getElementById('chk_rs1191').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rs1190').disabled = true;
                                                        document.getElementById('chk_rs1191').disabled = false;
                                                    }


                                                }

                                                function edit_rsshortsightok() {
                                                    if (chk_rsshortsightok.checked == true)
                                                    {

                                                        document.getElementById('chk_rsshortsightng').checked = false;
                                                        document.getElementById('chk_rsshortsightng').disabled = false;
                                                        document.getElementById('chk_rsshortsightok').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rsshortsightng').disabled = true;
                                                        document.getElementById('chk_rsshortsightok').disabled = false;
                                                    }


                                                }

                                                function edit_rsshortsightng() {
                                                    if (chk_rsshortsightng.checked == true)
                                                    {

                                                        document.getElementById('chk_rsshortsightok').checked = false;
                                                        document.getElementById('chk_rsshortsightok').disabled = false;
                                                        document.getElementById('chk_rsshortsightng').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rsshortsightok').disabled = true;
                                                        document.getElementById('chk_rsshortsightng').disabled = false;
                                                    }


                                                }

                                                function edit_rslongsightok() {
                                                    if (chk_rslongsightok.checked == true)
                                                    {

                                                        document.getElementById('chk_rslongsightng').checked = false;
                                                        document.getElementById('chk_rslongsightng').disabled = false;
                                                        document.getElementById('chk_rslongsightok').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rslongsightng').disabled = true;
                                                        document.getElementById('chk_rslongsightok').disabled = false;
                                                    }


                                                }

                                                function edit_rslongsightng() {
                                                    if (chk_rslongsightng.checked == true)
                                                    {

                                                        document.getElementById('chk_rslongsightok').checked = false;
                                                        document.getElementById('chk_rslongsightok').disabled = false;
                                                        document.getElementById('chk_rslongsightng').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rslongsightok').disabled = true;
                                                        document.getElementById('chk_rslongsightng').disabled = false;
                                                    }


                                                }

                                                function edit_rsobliquesightok() {
                                                    if (chk_rsobliquesightok.checked == true)
                                                    {

                                                        document.getElementById('chk_rsobliquesightng').checked = false;
                                                        document.getElementById('chk_rsobliquesightng').disabled = false;
                                                        document.getElementById('chk_rsobliquesightok').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rsobliquesightng').disabled = true;
                                                        document.getElementById('chk_rsobliquesightok').disabled = false;
                                                    }


                                                }

                                                function edit_rsobliquesightng() {
                                                    if (chk_rsobliquesightng.checked == true)
                                                    {

                                                        document.getElementById('chk_rsobliquesightok').checked = false;
                                                        document.getElementById('chk_rsobliquesightok').disabled = false;
                                                        document.getElementById('chk_rsobliquesightng').disabled = true;
                                                    } else
                                                    {

                                                        document.getElementById('chk_rsobliquesightok').disabled = true;
                                                        document.getElementById('chk_rsobliquesightng').disabled = false;
                                                    }


                                                }
    </script>

    <script>
        $(function () {
            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            // กรณีใช้แบบ input
            $(".dateen").datetimepicker({
                timepicker: false,
                format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


            });
            
            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            // กรณีใช้แบบ input
            $(".dateenkeydroptime").datetimepicker({
                timepicker: true,
                dateformat: 'Y-m-d' , // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                timeFormat: "HH:mm"


            });

            
        });

        function save_keydroptime1(){
            // alert('keydroptime1');
            var selfcheckid = document.getElementById('keydrop_selfcheckid1').value;
            var keydroptimechk = document.getElementById('keydroptime1').value;
            var keydroptimedata1  = keydroptimechk.replace(" ","T"); // replave " " เป็น "T"
            var keydroptimedata2  = keydroptimedata1.replace("/","-");
            var keydroptimedata3  = keydroptimedata2.replace("/","-"); // replave "/" เป็น "-"
            var keydroptime = keydroptimedata3;
            
            // alert(keydroptime);
            // alert(selfcheckid);

            $.ajax({
                url: 'meg_data2.php',
                type: 'POST',
                data: {
                    txt_flg: "save_keydroptime", ID: selfcheckid, fieldname: 'KEYDROPTIME', editableObj: keydroptime
                },
                success: function () {
                    
                    cal_timeworking1(selfcheckid,keydroptime);
                }
            });
        }
        function cal_timeworking1(selfcheckid,keydroptime){
            // alert('คำนวณเวลาทำงานของพนักงานคนที่ 1');
            // เวลาวางกุญแจ - เวลาเริ่มปฎิบัติงาน
            // คำนวณแล้วบันทึกข้อมูล

            var selfcheckid = document.getElementById('keydrop_selfcheckid1').value;
            var daysleeprestendchk = document.getElementById('daysleep_restend1').value; //day sleeprestend = เวลาเริ่มปฎิบัติงาน
            var daysleeprestenddata1  = daysleeprestendchk.replace(" ","T"); // replave " " เป็น "T"
            var daysleeprestenddata2  = daysleeprestenddata1.replace("/","-");
            var daysleeprestend3  = daysleeprestenddata2.replace("/","-"); // replave "/" เป็น "-"
            var daysleeprestend = daysleeprestend3;

            // alert(selfcheckid);
            // alert(daysleeprestend);
            // alert(keydroptime);

            $.ajax({
                type: 'post',
                url: 'meg_data2.php',
                data: {
                    txt_flg: "select_resttimeselfcheck", startsleep: daysleeprestend, endsleep: keydroptime
                },
                success: function (rs) {
                    // alert(rs);
                    
                    let text = rs;

                    let result1 =  text.substring(0, 2);
                    let replace1 = result1.replace(":", " ");

                    let result2 =  text.substring(3, 5);
                    let replace2 = result2.replace(":", " ");

                    // alert(replace1);
                    // alert(replace2);

                    if (replace1 == 0) {

                        document.getElementById("timeworking1").style.backgroundColor = "#94FA67";
                        document.getElementById('timeworking1').value = text;
                        save_timeworking1(selfcheckid,text,'OK');
                        // alert('1');

                    }else if ((replace1 > 0 && replace1 < 14)) {
                        // alert('2');
                        document.getElementById("timeworking1").style.backgroundColor = "#94FA67";
                        document.getElementById('timeworking1').value = text;
                        save_timeworking1(selfcheckid,text,'OK');

                      

                    }else if (replace1 == 14) {
                      

                        // document.getElementById("timeworking1").style.backgroundColor = "#94FA67";
                        // document.getElementById('timeworking1').value = text;
                        // save_timeworking1(selfcheckid,text);

                        if (replace2 <= 0) {
                             //  #94FA67 สีเขียว
                            document.getElementById("timeworking1").style.backgroundColor = "#94FA67";
                            document.getElementById('timeworking1').value = text;
                            save_timeworking1(selfcheckid,text,'OK');
                            // alert('3');
                        }else{
                            //  #FA6767 สีเแดง
                            document.getElementById("timeworking1").style.backgroundColor = "#FA6767";
                            document.getElementById('timeworking1').value = text;
                            save_timeworking1(selfcheckid,text,'NG');
                            // alert('4');
                        }
                       

                    }else{
                        //  #FA6767 สีเแดง
                        document.getElementById("timeworking1").style.backgroundColor = "#FA6767";
                        document.getElementById('timeworking1').value = text;
                        save_timeworking1(selfcheckid,text,'NG');
                        // alert('5');

                    }
                    

                    // save_timeworking1(selfcheckid,rs);
                }
            });


        }
        function save_timeworking1(selfcheckid,text,status){
            // alert('คำนวณเวลาทำงานของพนักงานคนที่ 1');
            // เวลาวางกุญแจ - เวลาเริ่มปฎิบัติงาน
            //save_timeworking ใช้ร่วมกัน

            // alert(rs);
            // alert(status);

            $.ajax({
                type: 'post',
                url: 'meg_data2.php',
                data: {
                    txt_flg: "save_timeworking", selfcheckid: selfcheckid, value: text,status: status
                },
                success: function (rs) {
                    // alert('sdsads');
                    
                    // window.location.reload();
                    
                }
            });


        }

        function save_keydroptime2(){
            // alert('keydroptime2');
            var selfcheckid = document.getElementById('keydrop_selfcheckid2').value;
            var keydroptimechk = document.getElementById('keydroptime2').value;
            var keydroptimedata1  = keydroptimechk.replace(" ","T"); // replave " " เป็น "T"
            var keydroptimedata2  = keydroptimedata1.replace("/","-");
            var keydroptimedata3  = keydroptimedata2.replace("/","-"); // replave "/" เป็น "-"
            var keydroptime = keydroptimedata3;
            
            // alert(keydroptime);
            // alert(selfcheckid);

            $.ajax({
                url: 'meg_data2.php',
                type: 'POST',
                data: {
                    txt_flg: "save_keydroptime", ID: selfcheckid, fieldname: 'KEYDROPTIME', editableObj: keydroptime
                },
                success: function () {

                    cal_timeworking2(selfcheckid,keydroptime);
                }
            });
        }
        function cal_timeworking2(selfcheckid,keydroptime){
            // alert('คำนวณเวลาทำงานของพนักงานคนที่ 1');
            // เวลาวางกุญแจ - เวลาเริ่มปฎิบัติงาน
            // คำนวณแล้วบันทึกข้อมูล

            var selfcheckid = document.getElementById('keydrop_selfcheckid2').value;
            var daysleeprestendchk = document.getElementById('daysleep_restend2').value; //day sleeprestend = เวลาเริ่มปฎิบัติงาน
            var daysleeprestenddata1  = daysleeprestendchk.replace(" ","T"); // replave " " เป็น "T"
            var daysleeprestenddata2  = daysleeprestenddata1.replace("/","-");
            var daysleeprestend3  = daysleeprestenddata2.replace("/","-"); // replave "/" เป็น "-"
            var daysleeprestend = daysleeprestend3;

            // alert(selfcheckid);
            // alert(daysleeprestend);
            // alert(keydroptime);

            $.ajax({
                type: 'post',
                url: 'meg_data2.php',
                data: {
                    txt_flg: "select_resttimeselfcheck", startsleep: daysleeprestend, endsleep: keydroptime
                },
                success: function (rs) {
                    // alert(rs);
                
                    let text = rs;

                    let result1 =  text.substring(0, 2);
                    let replace1 = result1.replace(":", " ");

                    let result2 =  text.substring(3, 5);
                    let replace2 = result2.replace(":", " ");

                    // alert(replace1);
                    // alert(replace2);

                    if (replace1 == 0) {

                    document.getElementById("timeworking2").style.backgroundColor = "#94FA67";
                    document.getElementById('timeworking2').value = text;
                    save_timeworking2(selfcheckid,text,'OK');
                    // alert('1');

                    }else if ((replace1 > 0 && replace1 < 14)) {
                    // alert('2');
                    document.getElementById("timeworking2").style.backgroundColor = "#94FA67";
                    document.getElementById('timeworking2').value = text;
                    save_timeworking2(selfcheckid,text,'OK');



                    }else if (replace1 == 14) {


                    // document.getElementById("timeworking1").style.backgroundColor = "#94FA67";
                    // document.getElementById('timeworking1').value = text;
                    // save_timeworking1(selfcheckid,text);

                    if (replace2 <= 0) {
                        //  #94FA67 สีเขียว
                        document.getElementById("timeworking2").style.backgroundColor = "#94FA67";
                        document.getElementById('timeworking2').value = text;
                        save_timeworking2(selfcheckid,text,'OK');
                        // alert('3');
                    }else{
                        //  #FA6767 สีเแดง
                        document.getElementById("timeworking2").style.backgroundColor = "#FA6767";
                        document.getElementById('timeworking2').value = text;
                        save_timeworking2(selfcheckid,text,'NG');
                        // alert('4');
                    }


                    }else{
                    //  #FA6767 สีเแดง
                    document.getElementById("timeworking2").style.backgroundColor = "#FA6767";
                    document.getElementById('timeworking2').value = text;
                    save_timeworking2(selfcheckid,text,'NG');
                    // alert('5');

                    }
                    

                    // save_timeworking1(selfcheckid,rs);
                }
            });


        }
        function save_timeworking2(selfcheckid,text,status){
            // alert('คำนวณเวลาทำงานของพนักงานคนที่ 1');
            // เวลาวางกุญแจ - เวลาเริ่มปฎิบัติงาน
            //save_timeworking ใช้ร่วมกัน

            // alert(rs);

            $.ajax({
                type: 'post',
                url: 'meg_data2.php',
                data: {
                    txt_flg: "save_timeworking", selfcheckid: selfcheckid, value: text,status: status
                },
                success: function (rs) {
                    // alert('sdsads');
                    
                    // window.location.reload();
                }
            });


        }
    </script>
    <script>
        function edit_tenkoriskychk(editableObj, fieldname, ID)
        {
            save_logprocess('Tenko', 'Save Tenkorisky', '<?= $result_seLogin['PersonCode'] ?>');
            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "edit_tenkorisky", editableObj: editableObj, ID: ID, fieldname: fieldname
                },
                success: function () {

                }
            });
        }
        function edit_tenkoafterchk(editableObj, fieldname, ID)
        {
            save_logprocess('Tenko', 'Save Tenkoafter', '<?= $result_seLogin['PersonCode'] ?>');
            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "edit_tenkoafter", editableObj: editableObj, ID: ID, fieldname: fieldname
                },
                success: function () {

                }
            });
        }
        function rs_rsdirvertransport1()
        {
            // alert('rs drivertrans1')
       

            // check1
            if(document.getElementById("TXT_TENKOLOADRESTRESULT0").value == 'x' || document.getElementById("TXT_TENKOLOADRESTRESULT0").value == '' 
            || document.getElementById("TXT_TENKOLOADRESTRESULT1").value == 'x' || document.getElementById("TXT_TENKOLOADRESTRESULT1").value == ''
            || document.getElementById("TXT_TENKOLOADRESTRESULT2").value == 'x' || document.getElementById("TXT_TENKOLOADRESTRESULT2").value == ''
            || document.getElementById("TXT_TENKOLOADRESTRESULT3").value == 'x' || document.getElementById("TXT_TENKOLOADRESTRESULT3").value == ''
            || document.getElementById("TXT_TENKOLOADRESTRESULT4").value == 'x' || document.getElementById("TXT_TENKOLOADRESTRESULT4").value == ''
            || document.getElementById("TXT_TENKOLOADRESTRESULT5").value == 'x' || document.getElementById("TXT_TENKOLOADRESTRESULT5").value == ''
            || document.getElementById("TXT_TENKOLOADRESTRESULT6").value == 'x' || document.getElementById("TXT_TENKOLOADRESTRESULT6").value == '')
            {
                var check1 = '0';
                // alert(check1); 
            }else{
                var check1 = '1';
                // alert(check1); 
            }

            // check2
            if(document.getElementById("TXT_TENKOBODYSLEEPYRESULT0").value == 'x' || document.getElementById("TXT_TENKOBODYSLEEPYRESULT0").value == ''
             || document.getElementById("TXT_TENKOBODYSLEEPYRESULT1").value == 'x' || document.getElementById("TXT_TENKOBODYSLEEPYRESULT1").value == ''
             || document.getElementById("TXT_TENKOBODYSLEEPYRESULT2").value == 'x' || document.getElementById("TXT_TENKOBODYSLEEPYRESULT2").value == ''
             || document.getElementById("TXT_TENKOBODYSLEEPYRESULT3").value == 'x' || document.getElementById("TXT_TENKOBODYSLEEPYRESULT3").value == ''
             || document.getElementById("TXT_TENKOBODYSLEEPYRESULT4").value == 'x' || document.getElementById("TXT_TENKOBODYSLEEPYRESULT4").value == ''
             || document.getElementById("TXT_TENKOBODYSLEEPYRESULT5").value == 'x' || document.getElementById("TXT_TENKOBODYSLEEPYRESULT5").value == ''
             || document.getElementById("TXT_TENKOBODYSLEEPYRESULT6").value == 'x' || document.getElementById("TXT_TENKOBODYSLEEPYRESULT6").value == '')
             {
                var check2 = '0';
                // alert(check2);
            }else{
                var check2 = '1';
                // alert(check2);
            }

            // check3
            if( document.getElementById("TXT_TENKOCARNEWRESULT0").value == 'x' || document.getElementById("TXT_TENKOCARNEWRESULT0").value == ''
             || document.getElementById("TXT_TENKOCARNEWRESULT1").value == 'x' || document.getElementById("TXT_TENKOCARNEWRESULT1").value == ''
             || document.getElementById("TXT_TENKOCARNEWRESULT2").value == 'x' || document.getElementById("TXT_TENKOCARNEWRESULT2").value == ''
             || document.getElementById("TXT_TENKOCARNEWRESULT3").value == 'x' || document.getElementById("TXT_TENKOCARNEWRESULT3").value == ''
             || document.getElementById("TXT_TENKOCARNEWRESULT4").value == 'x' || document.getElementById("TXT_TENKOCARNEWRESULT4").value == ''
             || document.getElementById("TXT_TENKOCARNEWRESULT5").value == 'x' || document.getElementById("TXT_TENKOCARNEWRESULT5").value == ''
             || document.getElementById("TXT_TENKOCARNEWRESULT6").value == 'x' || document.getElementById("TXT_TENKOCARNEWRESULT6").value == '')
             {
                var check3 = '0';
                // alert(check3);
            }else{
                var check3 = '1';
                // alert(check3);
            }

            // check4
            if( document.getElementById("TXT_TENKOTRAILERRESULT0").value == 'x' || document.getElementById("TXT_TENKOTRAILERRESULT0").value == ''
             || document.getElementById("TXT_TENKOTRAILERRESULT1").value == 'x' || document.getElementById("TXT_TENKOTRAILERRESULT1").value == ''
             || document.getElementById("TXT_TENKOTRAILERRESULT2").value == 'x' || document.getElementById("TXT_TENKOTRAILERRESULT2").value == ''
             || document.getElementById("TXT_TENKOTRAILERRESULT3").value == 'x' || document.getElementById("TXT_TENKOTRAILERRESULT3").value == ''
             || document.getElementById("TXT_TENKOTRAILERRESULT4").value == 'x' || document.getElementById("TXT_TENKOTRAILERRESULT4").value == '' 
             || document.getElementById("TXT_TENKOTRAILERRESULT5").value == 'x' || document.getElementById("TXT_TENKOTRAILERRESULT5").value == ''
             || document.getElementById("TXT_TENKOTRAILERRESULT6").value == 'x' || document.getElementById("TXT_TENKOTRAILERRESULT6").value == '')
             {
                var check4 = '0';
                // alert(check4);
            }else{
                var check4 = '1';
                // alert(check4);
            }

            // check5
            if(document.getElementById("TXT_TENKOROADRESULT0").value == 'x' || document.getElementById("TXT_TENKOROADRESULT0").value == ''
             || document.getElementById("TXT_TENKOROADRESULT1").value == 'x' || document.getElementById("TXT_TENKOROADRESULT1").value == ''
             || document.getElementById("TXT_TENKOROADRESULT2").value == 'x' || document.getElementById("TXT_TENKOROADRESULT2").value == ''
             || document.getElementById("TXT_TENKOROADRESULT3").value == 'x' || document.getElementById("TXT_TENKOROADRESULT3").value == ''
             || document.getElementById("TXT_TENKOROADRESULT4").value == 'x' || document.getElementById("TXT_TENKOROADRESULT4").value == ''
             || document.getElementById("TXT_TENKOROADRESULT5").value == 'x' || document.getElementById("TXT_TENKOROADRESULT5").value == ''
             || document.getElementById("TXT_TENKOROADRESULT6").value == 'x' || document.getElementById("TXT_TENKOROADRESULT6").value == '')
             {
                var check5 = '0';
                // alert(check5);
            }else{
                var check5 = '1';
                // alert(check5);
            }

            // check6
            if(document.getElementById("TXT_TENKOAIRRESULT0").value == 'x' || document.getElementById("TXT_TENKOAIRRESULT0").value == ''
             || document.getElementById("TXT_TENKOAIRRESULT1").value == 'x' || document.getElementById("TXT_TENKOAIRRESULT1").value == ''
             || document.getElementById("TXT_TENKOAIRRESULT2").value == 'x' || document.getElementById("TXT_TENKOAIRRESULT2").value == ''
             || document.getElementById("TXT_TENKOAIRRESULT3").value == 'x' || document.getElementById("TXT_TENKOAIRRESULT3").value == ''
             || document.getElementById("TXT_TENKOAIRRESULT4").value == 'x' || document.getElementById("TXT_TENKOAIRRESULT4").value == ''
             || document.getElementById("TXT_TENKOAIRRESULT5").value == 'x' || document.getElementById("TXT_TENKOAIRRESULT5").value == ''
             || document.getElementById("TXT_TENKOAIRRESULT6").value == 'x' || document.getElementById("TXT_TENKOAIRRESULT6").value == '')
             {
                var check6 = '0';
                // alert(check6);
            }else{
                var check6 = '1';
                // alert(check6);
            }

            // check7
            if( document.getElementById("TXT_TENKOSLEEPYRESULT0").value == 'x' || document.getElementById("TXT_TENKOSLEEPYRESULT0").value == ''
             || document.getElementById("TXT_TENKOSLEEPYRESULT1").value == 'x' || document.getElementById("TXT_TENKOSLEEPYRESULT1").value == ''
             || document.getElementById("TXT_TENKOSLEEPYRESULT2").value == 'x' || document.getElementById("TXT_TENKOSLEEPYRESULT2").value == ''
             || document.getElementById("TXT_TENKOSLEEPYRESULT3").value == 'x' || document.getElementById("TXT_TENKOSLEEPYRESULT3").value == ''
             || document.getElementById("TXT_TENKOSLEEPYRESULT4").value == 'x' || document.getElementById("TXT_TENKOSLEEPYRESULT4").value == ''
             || document.getElementById("TXT_TENKOSLEEPYRESULT5").value == 'x' || document.getElementById("TXT_TENKOSLEEPYRESULT5").value == ''
             || document.getElementById("TXT_TENKOSLEEPYRESULT6").value == 'x' || document.getElementById("TXT_TENKOSLEEPYRESULT6").value == '')
             {
                var check7 = '0';
                // alert(check7);
            }else{
                var check7 = '1';
                // alert(check7);
            }


            if (check1 == '1' || check2 == '1' || check3 == '1' || check4 == '1' || check5 == '1' || check6 == '1' || check7 == '1' ) {
                // alert('ถูก');
                document.getElementById('icon_transportrsno1').style.display = "none";
                document.getElementById('icon_transportrsok1').style.display = "";    
            }else{
                // alert('กากบาท');
                document.getElementById('icon_transportrsno1').style.display = "";
                document.getElementById('icon_transportrsok1').style.display = "none";
            }
            
        }

        function rs_rsdirvertransport2()
        {
            // alert('rs drivertrans2')
            

            // check1
            if(document.getElementById("TXT_TENKOLOADRESTRESULT0").value == 'x' || document.getElementById("TXT_TENKOLOADRESTRESULT0").value == '' 
            || document.getElementById("TXT_TENKOLOADRESTRESULT1").value == 'x' || document.getElementById("TXT_TENKOLOADRESTRESULT1").value == ''
            || document.getElementById("TXT_TENKOLOADRESTRESULT2").value == 'x' || document.getElementById("TXT_TENKOLOADRESTRESULT2").value == ''
            || document.getElementById("TXT_TENKOLOADRESTRESULT3").value == 'x' || document.getElementById("TXT_TENKOLOADRESTRESULT3").value == ''
            || document.getElementById("TXT_TENKOLOADRESTRESULT4").value == 'x' || document.getElementById("TXT_TENKOLOADRESTRESULT4").value == ''
            || document.getElementById("TXT_TENKOLOADRESTRESULT5").value == 'x' || document.getElementById("TXT_TENKOLOADRESTRESULT5").value == ''
            || document.getElementById("TXT_TENKOLOADRESTRESULT6").value == 'x' || document.getElementById("TXT_TENKOLOADRESTRESULT6").value == '')
            {
                var check1 = '0';
                // alert(check1); 
            }else{
                var check1 = '1';
                // alert(check1); 
            }

            // check2
            if(document.getElementById("TXT_TENKOBODYSLEEPYRESULT0").value == 'x' || document.getElementById("TXT_TENKOBODYSLEEPYRESULT0").value == ''
             || document.getElementById("TXT_TENKOBODYSLEEPYRESULT1").value == 'x' || document.getElementById("TXT_TENKOBODYSLEEPYRESULT1").value == ''
             || document.getElementById("TXT_TENKOBODYSLEEPYRESULT2").value == 'x' || document.getElementById("TXT_TENKOBODYSLEEPYRESULT2").value == ''
             || document.getElementById("TXT_TENKOBODYSLEEPYRESULT3").value == 'x' || document.getElementById("TXT_TENKOBODYSLEEPYRESULT3").value == ''
             || document.getElementById("TXT_TENKOBODYSLEEPYRESULT4").value == 'x' || document.getElementById("TXT_TENKOBODYSLEEPYRESULT4").value == ''
             || document.getElementById("TXT_TENKOBODYSLEEPYRESULT5").value == 'x' || document.getElementById("TXT_TENKOBODYSLEEPYRESULT5").value == ''
             || document.getElementById("TXT_TENKOBODYSLEEPYRESULT6").value == 'x' || document.getElementById("TXT_TENKOBODYSLEEPYRESULT6").value == '')
             {
                var check2 = '0';
                // alert(check2);
            }else{
                var check2 = '1';
                // alert(check2);
            }

            // check3
            if( document.getElementById("TXT_TENKOCARNEWRESULT0").value == 'x' || document.getElementById("TXT_TENKOCARNEWRESULT0").value == ''
             || document.getElementById("TXT_TENKOCARNEWRESULT1").value == 'x' || document.getElementById("TXT_TENKOCARNEWRESULT1").value == ''
             || document.getElementById("TXT_TENKOCARNEWRESULT2").value == 'x' || document.getElementById("TXT_TENKOCARNEWRESULT2").value == ''
             || document.getElementById("TXT_TENKOCARNEWRESULT3").value == 'x' || document.getElementById("TXT_TENKOCARNEWRESULT3").value == ''
             || document.getElementById("TXT_TENKOCARNEWRESULT4").value == 'x' || document.getElementById("TXT_TENKOCARNEWRESULT4").value == ''
             || document.getElementById("TXT_TENKOCARNEWRESULT5").value == 'x' || document.getElementById("TXT_TENKOCARNEWRESULT5").value == ''
             || document.getElementById("TXT_TENKOCARNEWRESULT6").value == 'x' || document.getElementById("TXT_TENKOCARNEWRESULT6").value == '')
             {
                var check3 = '0';
                // alert(check3);
            }else{
                var check3 = '1';
                // alert(check3);
            }

            // check4
            if( document.getElementById("TXT_TENKOTRAILERRESULT0").value == 'x' || document.getElementById("TXT_TENKOTRAILERRESULT0").value == ''
             || document.getElementById("TXT_TENKOTRAILERRESULT1").value == 'x' || document.getElementById("TXT_TENKOTRAILERRESULT1").value == ''
             || document.getElementById("TXT_TENKOTRAILERRESULT2").value == 'x' || document.getElementById("TXT_TENKOTRAILERRESULT2").value == ''
             || document.getElementById("TXT_TENKOTRAILERRESULT3").value == 'x' || document.getElementById("TXT_TENKOTRAILERRESULT3").value == ''
             || document.getElementById("TXT_TENKOTRAILERRESULT4").value == 'x' || document.getElementById("TXT_TENKOTRAILERRESULT4").value == '' 
             || document.getElementById("TXT_TENKOTRAILERRESULT5").value == 'x' || document.getElementById("TXT_TENKOTRAILERRESULT5").value == ''
             || document.getElementById("TXT_TENKOTRAILERRESULT6").value == 'x' || document.getElementById("TXT_TENKOTRAILERRESULT6").value == '')
             {
                var check4 = '0';
                // alert(check4);
            }else{
                var check4 = '1';
                // alert(check4);
            }

            // check5
            if(document.getElementById("TXT_TENKOROADRESULT0").value == 'x' || document.getElementById("TXT_TENKOROADRESULT0").value == ''
             || document.getElementById("TXT_TENKOROADRESULT1").value == 'x' || document.getElementById("TXT_TENKOROADRESULT1").value == ''
             || document.getElementById("TXT_TENKOROADRESULT2").value == 'x' || document.getElementById("TXT_TENKOROADRESULT2").value == ''
             || document.getElementById("TXT_TENKOROADRESULT3").value == 'x' || document.getElementById("TXT_TENKOROADRESULT3").value == ''
             || document.getElementById("TXT_TENKOROADRESULT4").value == 'x' || document.getElementById("TXT_TENKOROADRESULT4").value == ''
             || document.getElementById("TXT_TENKOROADRESULT5").value == 'x' || document.getElementById("TXT_TENKOROADRESULT5").value == ''
             || document.getElementById("TXT_TENKOROADRESULT6").value == 'x' || document.getElementById("TXT_TENKOROADRESULT6").value == '')
             {
                var check5 = '0';
                // alert(check5);
            }else{
                var check5 = '1';
                // alert(check5);
            }

            // check6
            if(document.getElementById("TXT_TENKOAIRRESULT0").value == 'x' || document.getElementById("TXT_TENKOAIRRESULT0").value == ''
             || document.getElementById("TXT_TENKOAIRRESULT1").value == 'x' || document.getElementById("TXT_TENKOAIRRESULT1").value == ''
             || document.getElementById("TXT_TENKOAIRRESULT2").value == 'x' || document.getElementById("TXT_TENKOAIRRESULT2").value == ''
             || document.getElementById("TXT_TENKOAIRRESULT3").value == 'x' || document.getElementById("TXT_TENKOAIRRESULT3").value == ''
             || document.getElementById("TXT_TENKOAIRRESULT4").value == 'x' || document.getElementById("TXT_TENKOAIRRESULT4").value == ''
             || document.getElementById("TXT_TENKOAIRRESULT5").value == 'x' || document.getElementById("TXT_TENKOAIRRESULT5").value == ''
             || document.getElementById("TXT_TENKOAIRRESULT6").value == 'x' || document.getElementById("TXT_TENKOAIRRESULT6").value == '')
             {
                var check6 = '0';
                // alert(check6);
            }else{
                var check6 = '1';
                // alert(check6);
            }

            // check7
            if( document.getElementById("TXT_TENKOSLEEPYRESULT0").value == 'x' || document.getElementById("TXT_TENKOSLEEPYRESULT0").value == ''
             || document.getElementById("TXT_TENKOSLEEPYRESULT1").value == 'x' || document.getElementById("TXT_TENKOSLEEPYRESULT1").value == ''
             || document.getElementById("TXT_TENKOSLEEPYRESULT2").value == 'x' || document.getElementById("TXT_TENKOSLEEPYRESULT2").value == ''
             || document.getElementById("TXT_TENKOSLEEPYRESULT3").value == 'x' || document.getElementById("TXT_TENKOSLEEPYRESULT3").value == ''
             || document.getElementById("TXT_TENKOSLEEPYRESULT4").value == 'x' || document.getElementById("TXT_TENKOSLEEPYRESULT4").value == ''
             || document.getElementById("TXT_TENKOSLEEPYRESULT5").value == 'x' || document.getElementById("TXT_TENKOSLEEPYRESULT5").value == ''
             || document.getElementById("TXT_TENKOSLEEPYRESULT6").value == 'x' || document.getElementById("TXT_TENKOSLEEPYRESULT6").value == '')
             {
                var check7 = '0';
                // alert(check7);
            }else{
                var check7 = '1';
                // alert(check7);
            }


            if (check1 == '1' || check2 == '1' || check3 == '1' || check4 == '1' || check5 == '1' || check6 == '1' || check7 == '1' ) {
                // alert('ถูก');
                document.getElementById('icon_transportrsno2').style.display = "none";
                document.getElementById('icon_transportrsok2').style.display = "";    
            }else{
                // alert('กากบาท');
                document.getElementById('icon_transportrsno2').style.display = "";
                document.getElementById('icon_transportrsok2').style.display = "none";
            }


            // if (
            //         document.getElementById("TXT_TENKOLOADRESTRESULT0").value == 'x'
            //         || document.getElementById("TXT_TENKOLOADRESTRESULT1").value == 'x'
            //         || document.getElementById("TXT_TENKOLOADRESTRESULT2").value == 'x'
            //         || document.getElementById("TXT_TENKOLOADRESTRESULT3").value == 'x'
            //         || document.getElementById("TXT_TENKOLOADRESTRESULT4").value == 'x'
            //         || document.getElementById("TXT_TENKOLOADRESTRESULT5").value == 'x'
            //         || document.getElementById("TXT_TENKOLOADRESTRESULT6").value == 'x'
            //         || document.getElementById("TXT_TENKOBODYSLEEPYRESULT0").value == 'x'
            //         || document.getElementById("TXT_TENKOBODYSLEEPYRESULT1").value == 'x'
            //         || document.getElementById("TXT_TENKOBODYSLEEPYRESULT2").value == 'x'
            //         || document.getElementById("TXT_TENKOBODYSLEEPYRESULT3").value == 'x'
            //         || document.getElementById("TXT_TENKOBODYSLEEPYRESULT4").value == 'x'
            //         || document.getElementById("TXT_TENKOBODYSLEEPYRESULT5").value == 'x'
            //         || document.getElementById("TXT_TENKOBODYSLEEPYRESULT6").value == 'x'
            //         || document.getElementById("TXT_TENKOCARNEWRESULT0").value == 'x'
            //         || document.getElementById("TXT_TENKOCARNEWRESULT1").value == 'x'
            //         || document.getElementById("TXT_TENKOCARNEWRESULT2").value == 'x'
            //         || document.getElementById("TXT_TENKOCARNEWRESULT3").value == 'x'
            //         || document.getElementById("TXT_TENKOCARNEWRESULT4").value == 'x'
            //         || document.getElementById("TXT_TENKOCARNEWRESULT5").value == 'x'
            //         || document.getElementById("TXT_TENKOCARNEWRESULT6").value == 'x'
            //         || document.getElementById("TXT_TENKOTRAILERRESULT0").value == 'x'
            //         || document.getElementById("TXT_TENKOTRAILERRESULT1").value == 'x'
            //         || document.getElementById("TXT_TENKOTRAILERRESULT2").value == 'x'
            //         || document.getElementById("TXT_TENKOTRAILERRESULT3").value == 'x'
            //         || document.getElementById("TXT_TENKOTRAILERRESULT4").value == 'x'
            //         || document.getElementById("TXT_TENKOTRAILERRESULT5").value == 'x'
            //         || document.getElementById("TXT_TENKOTRAILERRESULT6").value == 'x'
            //         || document.getElementById("TXT_TENKOROADRESULT0").value == 'x'
            //         || document.getElementById("TXT_TENKOROADRESULT1").value == 'x'
            //         || document.getElementById("TXT_TENKOROADRESULT2").value == 'x'
            //         || document.getElementById("TXT_TENKOROADRESULT3").value == 'x'
            //         || document.getElementById("TXT_TENKOROADRESULT4").value == 'x'
            //         || document.getElementById("TXT_TENKOROADRESULT5").value == 'x'
            //         || document.getElementById("TXT_TENKOROADRESULT6").value == 'x'
            //         || document.getElementById("TXT_TENKOAIRRESULT0").value == 'x'
            //         || document.getElementById("TXT_TENKOAIRRESULT1").value == 'x'
            //         || document.getElementById("TXT_TENKOAIRRESULT2").value == 'x'
            //         || document.getElementById("TXT_TENKOAIRRESULT3").value == 'x'
            //         || document.getElementById("TXT_TENKOAIRRESULT4").value == 'x'
            //         || document.getElementById("TXT_TENKOAIRRESULT5").value == 'x'
            //         || document.getElementById("TXT_TENKOAIRRESULT6").value == 'x'
            //         || document.getElementById("TXT_TENKOSLEEPYRESULT0").value == 'x'
            //         || document.getElementById("TXT_TENKOSLEEPYRESULT1").value == 'x'
            //         || document.getElementById("TXT_TENKOSLEEPYRESULT2").value == 'x'
            //         || document.getElementById("TXT_TENKOSLEEPYRESULT3").value == 'x'
            //         || document.getElementById("TXT_TENKOSLEEPYRESULT4").value == 'x'
            //         || document.getElementById("TXT_TENKOSLEEPYRESULT5").value == 'x'
            //         || document.getElementById("TXT_TENKOSLEEPYRESULT6").value == 'x'


            //         )
            // {

            //     document.getElementById('icon_transportrsno2').style.display = "";
            //     document.getElementById('icon_transportrsok2').style.display = "none";
            // } else
            // {

            //     document.getElementById('icon_transportrsno2').style.display = "none";
            //     document.getElementById('icon_transportrsok2').style.display = "";
            // }
        }

        function edit_tenkobeforetxt1()
        {
            if (document.getElementById("txt_rs14").value != "")
            {
                if (document.getElementById("txt_rs14").value.substring(0, 2) < 8)
                {
                    document.getElementById("chk_rs140").checked = true;
                    document.getElementById("chk_rs141").checked = false;
                } else
                {
                    document.getElementById("chk_rs141").checked = true;
                    document.getElementById("chk_rs140").checked = false;
                }
                document.getElementById("chk_14").checked = true;
            } else
            {
                document.getElementById("chk_14").checked = false;
                document.getElementById("chk_rs140").checked = true;
                document.getElementById("chk_rs141").checked = false;
            }

        }
        function edit_tenkobeforetxt2()
        {


            if (document.getElementById("txt_rs151").value != "")
            {
                if (document.getElementById("cb_changeka").value != "")
                {

                    if (document.getElementById("txt_rs151").value < 6)
                    {
                        document.getElementById("chk_rs150").checked = true;
                        document.getElementById("chk_rs151").checked = false;
                    } else
                    {
                        document.getElementById("chk_rs151").checked = true;
                        document.getElementById("chk_rs150").checked = false;
                    }
                } else
                {
                    if (document.getElementById("txt_rs151").value < 6)
                    {

                        document.getElementById("chk_rs150").checked = true;
                        document.getElementById("chk_rs151").checked = false;
                    } else
                    {

                        document.getElementById("chk_rs151").checked = true;
                        document.getElementById("chk_rs150").checked = false;
                    }
                }

                document.getElementById("chk_15").checked = true;
            } else
            {
                document.getElementById("chk_15").checked = false;
                document.getElementById("chk_rs150").checked = true;
                document.getElementById("chk_rs151").checked = false;
            }



        }
        function edit_tenkobeforetxt3()
        {



            // if (document.getElementById("txt_rs152").value != '')
            // {


            //     if (document.getElementById("txt_rs152").value.substring(0, 2) > 4)
            //     {

            //         document.getElementById("chk_rs151").checked = true;
            //         document.getElementById("chk_rs150").checked = false;
            //     } else
            //     {
            //         if (document.getElementById("txt_rs152").value.substring(0, 2) != '0')
            //         {
            //             document.getElementById("chk_rs151").checked = false;
            //             document.getElementById("chk_rs150").checked = true;
            //         } else
            //         {

            //             document.getElementById("chk_rs151").checked = true;
            //             document.getElementById("chk_rs150").checked = false;
            //         }
            //     }
            //     document.getElementById("chk_15").checked = true;
            // } else
            // {
            //     document.getElementById("chk_15").checked = false;
            //     document.getElementById("chk_rs150").checked = true;
            //     document.getElementById("chk_rs151").checked = false;
            // }




        }

        // onchange and update data to selfcheck
        function update_selfcheck(editableObj,fieldname,selfcheckid){
            // alert('onchange update selfcheck');
            // alert(editableObj);
            // alert(fieldname);
            // alert(selfcheckid);

            $.ajax({
                url: 'meg_data2.php',
                type: 'POST',
                data: {
                    txt_flg: "update_selfcheck", editableObj: editableObj, fieldname: fieldname, selfcheckid: selfcheckid
                },
                success: function () {

                }
            }); 
            
        }
        function commitupdate_selfcheck(selfcheckid){

            // alert("commit and update selfcheck");
            
            var temp = document.getElementById("txt_rs16").value;
            var sysvalue1 = document.getElementById("txt_rs171").value;
            var sysvalue2 = document.getElementById("txt_rs171_2").value;
            var sysvalue3 = document.getElementById("txt_rs171_3").value;
            var diavalue1 = document.getElementById("txt_rs172").value;
            var diavalue2 = document.getElementById("txt_rs172_2").value;
            var diavalue3 = document.getElementById("txt_rs172_3").value;
            var pulsevalue1 = document.getElementById("txt_rs173").value;
            var pulsevalue2 = document.getElementById("txt_rs173_2").value;
            var pulsevalue3 = document.getElementById("txt_rs173_3").value;
            var oxygenvalue = document.getElementById("txt_rs19").value;

            // alert(selfcheckid);
            // alert(temp);
            // alert(sysvalue1);
            // alert(sysvalue2);
            // alert(sysvalue3);
            // alert(diavalue1);
            // alert(diavalue2);
            // alert(diavalue3);
            // alert(pulsevalue1);
            // alert(pulsevalue2);
            // alert(pulsevalue3);
            // alert(oxygenvalue);
            
            if (selfcheckid == '') {
                alert("ยังไม่มีการแจ้งสุขภาพตนเองของพนักงาน กรุณาตรวจสอบข้อมูล!!");
            }else{
                $.ajax({
                    url: 'meg_data2.php',
                    type: 'POST',
                    data: {
                        txt_flg: "commitupdate_selfcheck", 
                        selfcheckid: selfcheckid,
                        temp: temp, 
                        sysvalue1: sysvalue1, 
                        sysvalue2: sysvalue2,
                        sysvalue3: sysvalue3,
                        diavalue1: diavalue1,
                        diavalue2: diavalue2,
                        diavalue3: diavalue3,
                        pulsevalue1: pulsevalue1,
                        pulsevalue2: pulsevalue2,
                        pulsevalue3: pulsevalue3,
                        oxygenvalue: oxygenvalue
                        
                    },
                    success: function () {

                    }
                }); 
            }
            
            
        }
        function edit_tenkobeforetxt4()
        {
            // alert('tenkobefore4');


            if (document.getElementById("txt_rs16").value != "")
            {
<?php
if ($result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKL') {
    ?>
                    if (document.getElementById("txt_rs16").value > 37.0)
                    {
                        document.getElementById("chk_rs160").checked = true;
                        document.getElementById("chk_rs161").checked = false;
                    } else
                    {
                        document.getElementById("chk_rs161").checked = true;
                        document.getElementById("chk_rs160").checked = false;
                    }
    <?php
} else {
    ?>
                    if (document.getElementById("txt_rs16").value > 37.0)
                    {
                        document.getElementById("chk_rs160").checked = true;
                        document.getElementById("chk_rs161").checked = false;
                    } else
                    {
                        document.getElementById("chk_rs161").checked = true;
                        document.getElementById("chk_rs160").checked = false;
                    }
    <?php
}
?>
                document.getElementById("chk_16").checked = true;
            } else
            {
                document.getElementById("chk_16").checked = false;
                document.getElementById("chk_rs160").checked = true;
                document.getElementById("chk_rs161").checked = false;
            }





        }
        function edit_tenkobeforetxt5()
        {






            if (document.getElementById("txt_rs171").value != "")
            {
<?php
if ($result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKL') {
    ?>
                    if ((document.getElementById("txt_rs171").value >= 90 && document.getElementById("txt_rs171").value <= 150 && document.getElementById("txt_rs172").value >= 60 && document.getElementById("txt_rs172").value <= 95) && (document.getElementById('txt_rs173').value >= 60 && document.getElementById('txt_rs173').value <= 100))
                    {

                        document.getElementById("chk_rs170").checked = false;
                        document.getElementById("chk_rs171").checked = true;
                    } else
                    {

                        document.getElementById("chk_rs171").checked = false;
                        document.getElementById("chk_rs170").checked = true;
                    }
    <?php
} else {
    ?>
                    if ((document.getElementById("txt_rs171").value >= 90 && document.getElementById("txt_rs171").value <= 150 && document.getElementById("txt_rs172").value >= 60 && document.getElementById("txt_rs172").value <= 95))
                    {

                        document.getElementById("chk_rs170").checked = false;
                        document.getElementById("chk_rs171").checked = true;
                    } else
                    {

                        document.getElementById("chk_rs171").checked = false;
                        document.getElementById("chk_rs170").checked = true;
                    }
    <?php
}
?>
                document.getElementById("chk_17").checked = true;
            } else
            {
                document.getElementById("chk_17").checked = false;
                document.getElementById("chk_rs170").checked = true;
                document.getElementById("chk_rs171").checked = false;
            }



        }
        function edit_tenkobeforetxt5_2()
        {




            if (document.getElementById("txt_rs171_2").value != "")
            {
                <?php
                if ($result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKL') {
                    ?>
                    if ((document.getElementById("txt_rs171_2").value >= 90 && document.getElementById("txt_rs171_2").value <= 150 && document.getElementById("txt_rs172_2").value >= 60 && document.getElementById("txt_rs172_2").value <= 95) && (document.getElementById('txt_rs173_2').value >= 60 && document.getElementById('txt_rs173_2').value <= 100))
                    {

                        document.getElementById("chk_rs170").checked = false;
                        document.getElementById("chk_rs171").checked = true;
                    } else
                    {

                        document.getElementById("chk_rs171").checked = false;
                        document.getElementById("chk_rs170").checked = true;
                    }
                <?php
                } else {
                ?>
                    if ((document.getElementById("txt_rs171_2").value >= 90 && document.getElementById("txt_rs171_2").value <= 150 && document.getElementById("txt_rs172_2").value >= 60 && document.getElementById("txt_rs172_2").value <= 95))
                    {

                        document.getElementById("chk_rs170").checked = false;
                        document.getElementById("chk_rs171").checked = true;
                    } else
                    {

                        document.getElementById("chk_rs171").checked = false;
                        document.getElementById("chk_rs170").checked = true;
                    }
                <?php
                }
                ?>
                document.getElementById("chk_17").checked = true;
            } else
            {
                document.getElementById("chk_17").checked = false;
                document.getElementById("chk_rs170").checked = true;
                document.getElementById("chk_rs171").checked = false;
            }



        }
        function edit_tenkobeforetxt5_3()
        {



<?php
if ($result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKL') {
    ?>


                if (document.getElementById("txt_rs171_3").value != "")
                {

                    if ((document.getElementById("txt_rs171_2").value >= 90 && document.getElementById("txt_rs171_2").value <= 150 && document.getElementById("txt_rs172_2").value >= 60 && document.getElementById("txt_rs172_2").value <= 95) && (document.getElementById('txt_rs173_2').value >= 60 && document.getElementById('txt_rs173_2').value <= 100))
                    {

                        document.getElementById("chk_rs170").checked = false;
                        document.getElementById("chk_rs171").checked = true;
                    } else
                    {

                        document.getElementById("chk_rs171").checked = false;
                        document.getElementById("chk_rs170").checked = true;
                    }
                    document.getElementById("chk_17").checked = true;
                } else
                {
                    document.getElementById("chk_17").checked = false;
                    document.getElementById("chk_rs170").checked = true;
                    document.getElementById("chk_rs171").checked = false;
                }

    <?php
} else {
    ?>
                if (document.getElementById("txt_rs171_3").value != "")
                {

                    if ((document.getElementById("txt_rs171_2").value >= 90 && document.getElementById("txt_rs171_2").value <= 150 && document.getElementById("txt_rs172_2").value >= 60 && document.getElementById("txt_rs172_2").value <= 95))
                    {

                        document.getElementById("chk_rs170").checked = false;
                        document.getElementById("chk_rs171").checked = true;
                    } else
                    {

                        document.getElementById("chk_rs171").checked = false;
                        document.getElementById("chk_rs170").checked = true;
                    }
                    document.getElementById("chk_17").checked = true;
                } else
                {
                    document.getElementById("chk_17").checked = false;
                    document.getElementById("chk_rs170").checked = true;
                    document.getElementById("chk_rs171").checked = false;
                }
    <?php
}
?>

        }
        function edit_tenkobeforetxt6()
        {


            if (document.getElementById("txt_rs172").value != "")
            {
<?php
if ($result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKL') {
    ?>
                    if ((document.getElementById("txt_rs171").value >= 90 && document.getElementById("txt_rs171").value <= 150) && (document.getElementById("txt_rs172").value >= 60 && document.getElementById("txt_rs172").value <= 95) && (document.getElementById('txt_rs173').value >= 60 && document.getElementById('txt_rs173').value <= 100))
                    {
                        document.getElementById("chk_rs170").checked = false;
                        document.getElementById("chk_rs171").checked = true;
                    } else
                    {
                        document.getElementById("chk_rs171").checked = false;
                        document.getElementById("chk_rs170").checked = true;
                    }
    <?php
} else {
    ?>
                    if ((document.getElementById("txt_rs171").value >= 90 && document.getElementById("txt_rs171").value <= 150) && (document.getElementById("txt_rs172").value >= 60 && document.getElementById("txt_rs172").value <= 95))
                    {
                        document.getElementById("chk_rs170").checked = false;
                        document.getElementById("chk_rs171").checked = true;
                    } else
                    {
                        document.getElementById("chk_rs171").checked = false;
                        document.getElementById("chk_rs170").checked = true;
                    }
    <?php
}
?>
                document.getElementById("chk_17").checked = true;
            } else
            {
                document.getElementById("chk_17").checked = false;
                document.getElementById("chk_rs170").checked = true;
                document.getElementById("chk_rs171").checked = false;
            }




        }
        function edit_tenkobeforetxt6_2()
        {




            if (document.getElementById("txt_rs171_2").value != "")
            {
<?php
if ($result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKL') {
    ?>
                    if ((document.getElementById("txt_rs171_2").value >= 90 && document.getElementById("txt_rs171_2").value <= 150 && document.getElementById("txt_rs172_2").value >= 60 && document.getElementById("txt_rs172_2").value <= 95) && (document.getElementById('txt_rs173_2').value >= 60 && document.getElementById('txt_rs173_2').value <= 100))
                    {

                        document.getElementById("chk_rs170").checked = false;
                        document.getElementById("chk_rs171").checked = true;
                    } else
                    {

                        document.getElementById("chk_rs171").checked = false;
                        document.getElementById("chk_rs170").checked = true;
                    }
    <?php
} else {
    ?>
                    if ((document.getElementById("txt_rs171_2").value >= 90 && document.getElementById("txt_rs171_2").value <= 150 && document.getElementById("txt_rs172_2").value >= 60 && document.getElementById("txt_rs172_2").value <= 95))
                    {

                        document.getElementById("chk_rs170").checked = false;
                        document.getElementById("chk_rs171").checked = true;
                    } else
                    {

                        document.getElementById("chk_rs171").checked = false;
                        document.getElementById("chk_rs170").checked = true;
                    }
    <?php
}
?>
                document.getElementById("chk_17").checked = true;
            } else
            {
                document.getElementById("chk_17").checked = false;
                document.getElementById("chk_rs170").checked = true;
                document.getElementById("chk_rs171").checked = false;
            }



        }
        function edit_tenkobeforetxt6_3()
        {




            if (document.getElementById("txt_rs171_3").value != "")
            {

                if ((document.getElementById("txt_rs171_3").value >= 90 && document.getElementById("txt_rs171_3").value <= 150 && document.getElementById("txt_rs172_3").value >= 60 && document.getElementById("txt_rs172_3").value <= 95) && (document.getElementById('txt_rs173_3').value >= 60 && document.getElementById('txt_rs173_3').value <= 100))
                {

                    document.getElementById("chk_rs170").checked = false;
                    document.getElementById("chk_rs171").checked = true;
                } else
                {

                    document.getElementById("chk_rs171").checked = false;
                    document.getElementById("chk_rs170").checked = true;
                }
                document.getElementById("chk_17").checked = true;
            } else
            {
                document.getElementById("chk_17").checked = false;
                document.getElementById("chk_rs170").checked = true;
                document.getElementById("chk_rs171").checked = false;
            }


        }
        function edit_tenkobeforetxt20()
        {



            if (document.getElementById("txt_rs172").value != "")
            {

                if ((document.getElementById("txt_rs171").value >= 90 && document.getElementById("txt_rs171").value <= 150) && (document.getElementById("txt_rs172").value >= 60 && document.getElementById("txt_rs172").value <= 95) && (document.getElementById('txt_rs173').value >= 60 && document.getElementById('txt_rs173').value <= 100))
                {
                    document.getElementById("chk_rs170").checked = false;
                    document.getElementById("chk_rs171").checked = true;
                } else
                {
                    document.getElementById("chk_rs171").checked = false;
                    document.getElementById("chk_rs170").checked = true;
                }
                document.getElementById("chk_17").checked = true;
            } else
            {
                document.getElementById("chk_17").checked = false;
                document.getElementById("chk_rs170").checked = true;
                document.getElementById("chk_rs171").checked = false;
            }




        }
        function edit_tenkobeforetxt20_2()
        {



            if (document.getElementById("txt_rs171_2").value != "")
            {

                if ((document.getElementById("txt_rs171_2").value >= 90 && document.getElementById("txt_rs171_2").value <= 150 && document.getElementById("txt_rs172_2").value >= 60 && document.getElementById("txt_rs172_2").value <= 95) && (document.getElementById('txt_rs173_2').value >= 60 && document.getElementById('txt_rs173_2').value <= 100))
                {

                    document.getElementById("chk_rs170").checked = false;
                    document.getElementById("chk_rs171").checked = true;
                } else
                {

                    document.getElementById("chk_rs171").checked = false;
                    document.getElementById("chk_rs170").checked = true;
                }
                document.getElementById("chk_17").checked = true;
            } else
            {
                document.getElementById("chk_17").checked = false;
                document.getElementById("chk_rs170").checked = true;
                document.getElementById("chk_rs171").checked = false;
            }


        }
        function edit_tenkobeforetxt20_3()
        {



            if (document.getElementById("txt_rs171_3").value != "")
            {

                if ((document.getElementById("txt_rs171_2").value >= 90 && document.getElementById("txt_rs171_2").value <= 150 && document.getElementById("txt_rs172_2").value >= 60 && document.getElementById("txt_rs172_2").value <= 95) && (document.getElementById('txt_rs173_2').value >= 60 && document.getElementById('txt_rs173_2').value <= 100))
                {

                    document.getElementById("chk_rs170").checked = false;
                    document.getElementById("chk_rs171").checked = true;
                } else
                {

                    document.getElementById("chk_rs171").checked = false;
                    document.getElementById("chk_rs170").checked = true;
                }
                document.getElementById("chk_17").checked = true;
            } else
            {
                document.getElementById("chk_17").checked = false;
                document.getElementById("chk_rs170").checked = true;
                document.getElementById("chk_rs171").checked = false;
            }



        }
        function edit_tenkobeforetxt7()
        {


            if (document.getElementById("txt_rs18").value != "")
            {
                if (document.getElementById("txt_rs18").value != '0')
                {
                    document.getElementById("chk_rs180").checked = true;
                    document.getElementById("chk_rs181").checked = false;
                } else
                {
                    document.getElementById("chk_rs181").checked = true;
                    document.getElementById("chk_rs180").checked = false;
                }
                document.getElementById("chk_18").checked = true;
            } else
            {
                document.getElementById("chk_18").checked = false;
                document.getElementById("chk_rs180").checked = true;
                document.getElementById("chk_rs181").checked = false;
            }



        }
        function edit_tenkobeforetxt8()
        {


            if (document.getElementById("txt_rs19").value != "")
            {
                if (document.getElementById("txt_rs19").value >= 98 && document.getElementById("txt_rs19").value < 100)
                {

                    document.getElementById("chk_rs1191").checked = true;
                    document.getElementById("chk_rs1190").checked = false;
                    document.getElementById("chk_119").checked = true;
                }
            } else
            {

                document.getElementById("chk_119").checked = false;
                document.getElementById("chk_rs1190").checked = true;
                document.getElementById("chk_rs1191").checked = false;
            }




        }




        function edit_tenkogps(editableObj, fieldname, ID)
        {
            // alert("edit_tenkogps");
            // alert(editableObj);
            // alert(fieldname);
            // alert(ID);

            save_logprocess('Tenko', 'Save Tenkogps', '<?= $result_seLogin['PersonCode'] ?>');
            // var dataedit = editableObj.innerHTML;
            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "edit_tenkogps", editableObj: editableObj, ID: ID, fieldname: fieldname
                },
                success: function () {

                }
            }); 
            
            // check_point(tenkomasterid);
        }
        //insert point and grade
        function update_tenkogpsGradePoint(tenkomasterid,employeecode,check){

        // alert(tenkomasterid);
        // alert(employeecode);
        // alert(check);
        

        if (check == 'emp1') {
            grade = document.getElementById("txt_gradesaveemp1").value;
            point = document.getElementById("txt_pointsaveemp1").value;
        
        }else{
            grade = document.getElementById("txt_gradesaveemp2").value;
            point = document.getElementById("txt_pointsaveemp2").value;
            
        }
            $.ajax({
                url: 'meg_data2.php',
                type: 'POST',
                data: {
                    txt_flg: "update_tenkogpsGradePoint",
                    grade: grade,
                    point: point,
                    tenkomasterid: tenkomasterid,
                    tenkomasterdrivercode: employeecode
                },
                success: function (rs) {

                    // alert(rs);

                    // commit2();
                    alert('บันทึกข้อมูลเกรดและคะแนน เรียบร้อย');
                    // window.location.reload();


                    }
                });


        }
        function check_pointemp1(tenkomasterid,employeecode){
            // alert(tenkomasterid);
            // alert(employeecode);
            // alert('check point emp1');
            $.ajax({
                url: 'meg_data2.php',
                type: 'POST',
                data: {
                    txt_flg: "check_gpspointemp1", tenkomasterid: tenkomasterid,employeecode: employeecode
                },
                success: function (rs) {
                    document.getElementById("data_pointemp1sr").innerHTML = rs;
                    document.getElementById("txt_gradeshowemp1").value = document.getElementById("txt_gradeemp1").value;
                    document.getElementById("txt_pointshowemp1").value = document.getElementById("txt_pointemp1").value;

                    document.getElementById("txt_gradesaveemp1").value = document.getElementById("txt_gradeemp1").value;
                    document.getElementById("txt_pointsaveemp1").value = document.getElementById("txt_pointemp1").value;
                    
                    update_tenkogpsGradePoint(tenkomasterid,employeecode,'emp1');
                }
            }); 
        }
        
      
        function check_pointemp2(tenkomasterid,employeecode){
            // alert(tenkomasterid);
            // alert(employeecode);
            // alert('check point emp2');
            $.ajax({
                url: 'meg_data2.php',
                type: 'POST',
                data: {
                    txt_flg: "check_gpspointemp2", tenkomasterid: tenkomasterid,employeecode: employeecode
                },
                success: function (rs) {
                    document.getElementById("data_pointemp2sr").innerHTML = rs;
                    document.getElementById("txt_gradeshowemp2").value = document.getElementById("txt_gradeemp2").value;
                    document.getElementById("txt_pointshowemp2").value = document.getElementById("txt_pointemp2").value;

                    document.getElementById("txt_gradesaveemp2").value = document.getElementById("txt_gradeemp2").value;
                    document.getElementById("txt_pointsaveemp2").value = document.getElementById("txt_pointemp2").value;
                    
                    update_tenkogpsGradePoint(tenkomasterid,employeecode,'emp2');
                }
            }); 
        }

        
        function edit_tenkorisky(editableObj, fieldname, ID)
        {
            save_logprocess('Tenko', 'Save Tenkorisky', '<?= $result_seLogin['PersonCode'] ?>');
            var dataedit = editableObj.innerHTML;
            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "edit_tenkorisky", editableObj: dataedit, ID: ID, fieldname: fieldname
                },
                success: function () {

                }
            });
        }
        function edit_tenkoafter(editableObj, fieldname, ID)
        {
            save_logprocess('Tenko', 'Save Tenkoafter', '<?= $result_seLogin['PersonCode'] ?>');
            var dataedit = editableObj.innerHTML;
            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "edit_tenkoafter", editableObj: dataedit, ID: ID, fieldname: fieldname
                },
                success: function () {

                }
            });
        }


        function edit_tenkotransportchk(editableObj, fieldname, ID, tenkotransportdate)
        {

            save_logprocess('Tenko', 'Save Tenkotransport', '<?= $result_seLogin['PersonCode'] ?>');
            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "edit_tenkotransport", editableObj: editableObj, ID: ID, fieldname: fieldname, tenkotransportdate: tenkotransportdate, updateby: '<?= $result_seEmployee["PersonCode"] ?>'
                },
                success: function () {


                }
            });
        }
        function edit_tenkotransporttime(editableObj, fieldname, ID, tenkotransportdate)
        {
            save_logprocess('Tenko', 'Save Tenkotransport', '<?= $result_seLogin['PersonCode'] ?>');
            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "edit_tenkotransport", editableObj: editableObj, ID: ID, fieldname: fieldname, tenkotransportdate: tenkotransportdate, updateby: '<?= $result_seEmployee["PersonCode"] ?>'
                },
                success: function () {

                }
            });
        }
        function edit_tenkotransport(editableObj, fieldname, ID, tenkotransportdate)
        {
            save_logprocess('Tenko', 'Save Tenkotransport', '<?= $result_seLogin['PersonCode'] ?>');
            
            // var dataedit = editableObj.innerHTML;
            // alert(editableObj);
            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "edit_tenkotransport", editableObj: editableObj, ID: ID, fieldname: fieldname, tenkotransportdate: tenkotransportdate, updateby: '<?= $result_seEmployee["PersonCode"] ?>'
                },
                success: function () {

                }
            });
        }

        function editvalue_tenkotransport(editableObj, fieldname, ID, tenkotransportdate)
        {
            save_logprocess('Tenko', 'Save Tenkotransport', '<?= $result_seLogin['PersonCode'] ?>');
            //  alert(editableObj);
            //  alert(fieldname);
            //  alert(ID);
            //  alert(tenkotransportdate); 

            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "edit_tenkotransport", editableObj: editableObj, ID: ID, fieldname: fieldname, tenkotransportdate: tenkotransportdate, updateby: '<?= $result_seEmployee["PersonCode"] ?>'
                },
                success: function () {


                }
            });
        }
        function save_tenkomasterdriver(tenkomasterid)
        {

            var vehicleregisnumber = "";
            var jobstart = "";
            var jobend1 = "";
            var jobend2 = "";
            var dayone = "";
            var target1 = "";
            var target2 = "";
            var target3 = "";
            var target4 = "";
            var target5 = "";
            var target6 = "";
            var target7 = "";
            var vehicletransportplanid = '<?= $_GET['vehicletransportplanid'] ?>';
            var changeka = document.getElementById('cb_changeka').value;
            var status = document.getElementById('cb_status').value;
            var remark1 = document.getElementById('txt_remark1').value;
            //var remark2 = document.getElementById('txt_remark2').value;








            //if (chk_dayone.checked == true) {
            //    dayone = "1";
            //}
            if (chk_target1.checked == true) {
                target1 = "1";
            } else
            {
                target1 = "0";
            }
            if (chk_target2.checked == true) {
                target2 = "1";
            } else
            {
                target2 = "0";
            }
            if (chk_target3.checked == true) {
                target3 = "1";
            } else
            {
                target3 = "0";
            }
            if (chk_target4.checked == true) {
                target4 = "1";
            } else
            {
                target4 = "0";
            }
            if (chk_target5.checked == true) {
                target5 = "1";
            } else
            {
                target5 = "0";
            }
            if (chk_target6.checked == true) {
                target6 = "1";
            } else
            {
                target6 = "0";
            }
            if (chk_target7.checked == true) {
                target7 = "1";
            } else
            {
                target7 = "0";
            }



            if(tenkomasterid == '' || tenkomasterid == 'NULL'){
                alert('ไม่มีเลขที่ tenko กรุณาตรวจสอบข้อมูล หรือ แจ้งเจ้าหน้าที่');
            }else{
                // alert('test');
                    $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "update_tenkomasterdriver",
                        tenkomasterid: tenkomasterid,
                        vehicletransportplanid: vehicletransportplanid,
                        changeka: changeka,
                        status: status,
                        remark1: remark1,
                        remark2: '',
                        vehicleregisnumber: vehicleregisnumber,
                        jobstart: jobstart,
                        jobend1: jobend1,
                        jobend2: jobend2,
                        dayone: dayone,
                        target1: target1,
                        target2: target2,
                        target3: target3,
                        target4: target4,
                        target5: target5,
                        target6: target6,
                        target7: target7

                    },
                    success: function (response) {
                        if ('<?= $_GET['employeecode1'] ?>' != '' || '<?= $_GET['employeecode2'] ?>' != '')
                        {
                            edit_tenkobefore2();
                            save_HealthForTenko(tenkomasterid);
                            alert('บันทึกข้อมูลเรียบร้อย');
                        } else
                        {
                            alert('ไม่มีรหัสพนักงาน กรุณาตรวจสอบข้อมูล!!!');
                            window.location.reload();

                        }

                    }
                });
            } //end else
        }


        function edit_tenkobefore2()
        {
            save_logprocess('Tenko', 'Save Tenkomasterandbefore', '<?= $result_seLogin['PersonCode'] ?>');
            var TENKOBEFOREGREETCHECK = (chk_11.checked == true) ? '1' : '';
            var TENKOUNIFORMCHECK = (chk_12.checked == true) ? '1' : '';
            var TENKOBODYCHECK = (chk_13.checked == true) ? '1' : '';
            var TENKORESTCHECK = (chk_14.checked == true) ? '1' : '';
            var TENKOSLEEPTIMECHECK = (chk_15.checked == true) ? '1' : '';
            var TENKOTEMPERATURECHECK = (chk_16.checked == true) ? '1' : '';
            var TENKOPRESSURECHECK = (chk_17.checked == true) ? '1' : '';
            var TENKOALCOHOLCHECK = (chk_18.checked == true) ? '1' : '';
            var TENKOWORRYCHECK = (chk_19.checked == true) ? '1' : '';
            var TENKODAILYTRAILERCHECK = (chk_110.checked == true) ? '1' : '';
            var TENKOCARRYCHECK = (chk_111.checked == true) ? '1' : '';
            var TENKOJOBDETAILCHECK = (chk_112.checked == true) ? '1' : '';
            var TENKOLOADINFORMCHECK = (chk_113.checked == true) ? '1' : '';
            var TENKOAIRINFORMCHECK = (chk_114.checked == true) ? '1' : '';
            var TENKOYOKOTENCHECK = (chk_115.checked == true) ? '1' : '';
            var TENKOCHIMOLATORCHECK = (chk_116.checked == true) ? '1' : '';
            var TENKOTRANSPORTCHECK = (chk_117.checked == true) ? '1' : '';
            var TENKOAFTERGREETCHECK = (chk_118.checked == true) ? '1' : '';
            var TENKOOXYGENCHECK = (chk_119.checked == true) ? '1' : '';
            var TENKOBEFOREGREETRESULT = (chk_rs111.checked == true) ? '1' : '';
            var TENKOUNIFORMRESULT = (chk_rs121.checked == true) ? '1' : '';
            var TENKOBODYRESULT = (chk_rs131.checked == true) ? '1' : '';
            var TENKORESTRESULT = (chk_rs141.checked == true) ? '1' : '';
            var TENKOSLEEPTIMERESULT = (chk_rs151.checked == true) ? '1' : '';
            var TENKOTEMPERATURERESULT = (chk_rs161.checked == true) ? '1' : '';
            var TENKOPRESSURERESULT = (chk_rs171.checked == true) ? '1' : '';
            var TENKOALCOHOLRESULT = (chk_rs181.checked == true) ? '1' : '';
            var TENKOWORRYRESULT = (chk_rs191.checked == true) ? '1' : '';
            var TENKODAILYTRAILERRESULT = (chk_rs1101.checked == true) ? '1' : '';
            var TENKOCARRYRESULT = (chk_rs1111.checked == true) ? '1' : '';
            var TENKOJOBDETAILRESULT = (chk_rs1121.checked == true) ? '1' : '';
            var TENKOLOADINFORMRESULT = (chk_rs1131.checked == true) ? '1' : '';
            var TENKOAIRINFORMRESULT = (chk_rs1141.checked == true) ? '1' : '';
            var TENKOYOKOTENRESULT = (chk_rs1151.checked == true) ? '1' : '';
            var TENKOCHIMOLATORRESULT = (chk_rs1161.checked == true) ? '1' : '';
            var TENKOTRANSPORTRESULT = (chk_rs1171.checked == true) ? '1' : '';
            var TENKOAFTERGREETRESULT = (chk_rs1181.checked == true) ? '1' : '';
            var TENKOOXYGENRESULT = (chk_rs1191.checked == true) ? '1' : '';
            var TENKOBEFOREGREETREMARK = document.getElementById('txt_remark11').value;
            var TENKOUNIFORMREMARK = document.getElementById('txt_remark12').value;
            var TENKOBODYREMARK = document.getElementById('txt_remark13').value;
            var TENKORESTREMARK = document.getElementById('txt_remark14').value;
            var TENKOSLEEPTIMEREMARK = document.getElementById('txt_remark15').value;
            var TENKOTEMPERATUREREMARK = document.getElementById('txt_remark16').value;
            var TENKOPRESSUREREMARK = document.getElementById('txt_remark17').value;
            var TENKOALCOHOLREMARK = document.getElementById('txt_remark18').value;
            var TENKOWORRYREMARK = document.getElementById('txt_remark19').value;
            var TENKODAILYTRAILERREMARK = document.getElementById('txt_remark110').value;
            var TENKOCARRYREMARK = document.getElementById('txt_remark111').value;
            var TENKOJOBDETAILREMARK = document.getElementById('txt_remark112').value;
            var TENKOLOADINFORMREMARK = document.getElementById('txt_remark113').value;
            var TENKOAIRINFORMREMARK = document.getElementById('txt_remark114').value;
            var TENKOYOKOTENREMARK = document.getElementById('txt_remark115').value;
            var TENKOCHIMOLATORREMARK = document.getElementById('txt_remark116').value;
            var TENKOTRANSPORTREMARK = document.getElementById('txt_remark117').value;
            var TENKOAFTERGREETREMARK = document.getElementById('txt_remark118').value;
            var TENKOOXYGENREMARK = document.getElementById('txt_remark119').value;
            var TENKORESTDATA = document.getElementById('txt_rs14').value;
            var TENKOSLEEPTIMEDATA_AFTER6H = document.getElementById('txt_rs151').value;
            var TENKOSLEEPTIMEDATA_ADD45H = document.getElementById('txt_rs152').value;
            var TENKOTEMPERATUREDATA = document.getElementById('txt_rs16').value;
            var TENKOPRESSUREDATA_90160 = document.getElementById('txt_rs171').value;
            var TENKOPRESSUREDATA_90160_2 = document.getElementById('txt_rs171_2').value;
            var TENKOPRESSUREDATA_90160_3 = document.getElementById('txt_rs171_3').value;
            var TENKOPRESSUREDATA_60100 = document.getElementById('txt_rs172').value;
            var TENKOPRESSUREDATA_60100_2 = document.getElementById('txt_rs172_2').value;
            var TENKOPRESSUREDATA_60100_3 = document.getElementById('txt_rs172_3').value;
            var TENKOPRESSUREDATA_60110 = document.getElementById('txt_rs173').value;
            var TENKOPRESSUREDATA_60110_2 = document.getElementById('txt_rs173_2').value;
            var TENKOPRESSUREDATA_60110_3 = document.getElementById('txt_rs173_3').value;
            var TENKOALCOHOLDATA = document.getElementById('txt_rs18').value;
            var TENKOOXYGENDATA = document.getElementById('txt_rs19').value;
            var employeecode = '';
            if ('<?= $_GET['employeecode1'] ?>' != '')
            {
                employeecode = '<?= $result_seTenkobefore1['TENKOBEFOREID'] ?>';
            } else
            {
                employeecode = '<?= $result_seTenkobefore2['TENKOBEFOREID'] ?>';

            }

            var tenkomasterid = '';
            if (employeecode == '')
            {
                tenkomasterid = '<?= $result_seTenkomaster_temp['TENKOMASTERID'] ?>';
            } else
            {
                tenkomasterid = employeecode;
            }

            // alert(employeecode);
            // alert(tenkomasterid);

            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "edit_tenkobefore2",
                    ID: tenkomasterid,
                    TENKOBEFOREGREETCHECK: TENKOBEFOREGREETCHECK,
                    TENKOUNIFORMCHECK: TENKOUNIFORMCHECK,
                    TENKOBODYCHECK: TENKOBODYCHECK,
                    TENKORESTCHECK: TENKORESTCHECK,
                    TENKOSLEEPTIMECHECK: TENKOSLEEPTIMECHECK,
                    TENKOTEMPERATURECHECK: TENKOTEMPERATURECHECK,
                    TENKOPRESSURECHECK: TENKOPRESSURECHECK,
                    TENKOALCOHOLCHECK: TENKOALCOHOLCHECK,
                    TENKOWORRYCHECK: TENKOWORRYCHECK,
                    TENKODAILYTRAILERCHECK: TENKODAILYTRAILERCHECK,
                    TENKOCARRYCHECK: TENKOCARRYCHECK,
                    TENKOJOBDETAILCHECK: TENKOJOBDETAILCHECK,
                    TENKOLOADINFORMCHECK: TENKOLOADINFORMCHECK,
                    TENKOAIRINFORMCHECK: TENKOAIRINFORMCHECK,
                    TENKOYOKOTENCHECK: TENKOYOKOTENCHECK,
                    TENKOCHIMOLATORCHECK: TENKOCHIMOLATORCHECK,
                    TENKOTRANSPORTCHECK: TENKOTRANSPORTCHECK,
                    TENKOAFTERGREETCHECK: TENKOAFTERGREETCHECK,
                    TENKOOXYGENCHECK: TENKOOXYGENCHECK,
                    TENKOBEFOREGREETRESULT: TENKOBEFOREGREETRESULT,
                    TENKOUNIFORMRESULT: TENKOUNIFORMRESULT,
                    TENKOBODYRESULT: TENKOBODYRESULT,
                    TENKORESTRESULT: TENKORESTRESULT,
                    TENKOSLEEPTIMERESULT: TENKOSLEEPTIMERESULT,
                    TENKOTEMPERATURERESULT: TENKOTEMPERATURERESULT,
                    TENKOPRESSURERESULT: TENKOPRESSURERESULT,
                    TENKOALCOHOLRESULT: TENKOALCOHOLRESULT,
                    TENKOWORRYRESULT: TENKOWORRYRESULT,
                    TENKODAILYTRAILERRESULT: TENKODAILYTRAILERRESULT,
                    TENKOCARRYRESULT: TENKOCARRYRESULT,
                    TENKOJOBDETAILRESULT: TENKOJOBDETAILRESULT,
                    TENKOLOADINFORMRESULT: TENKOLOADINFORMRESULT,
                    TENKOAIRINFORMRESULT: TENKOAIRINFORMRESULT,
                    TENKOYOKOTENRESULT: TENKOYOKOTENRESULT,
                    TENKOCHIMOLATORRESULT: TENKOCHIMOLATORRESULT,
                    TENKOTRANSPORTRESULT: TENKOTRANSPORTRESULT,
                    TENKOAFTERGREETRESULT: TENKOAFTERGREETRESULT,
                    TENKOOXYGENRESULT: TENKOOXYGENRESULT,
                    TENKOBEFOREGREETREMARK: TENKOBEFOREGREETREMARK,
                    TENKOUNIFORMREMARK: TENKOUNIFORMREMARK,
                    TENKOBODYREMARK: TENKOBODYREMARK,
                    TENKORESTREMARK: TENKORESTREMARK,
                    TENKOSLEEPTIMEREMARK: TENKOSLEEPTIMEREMARK,
                    TENKOTEMPERATUREREMARK: TENKOTEMPERATUREREMARK,
                    TENKOPRESSUREREMARK: TENKOPRESSUREREMARK,
                    TENKOALCOHOLREMARK: TENKOALCOHOLREMARK,
                    TENKOWORRYREMARK: TENKOWORRYREMARK,
                    TENKODAILYTRAILERREMARK: TENKODAILYTRAILERREMARK,
                    TENKOCARRYREMARK: TENKOCARRYREMARK,
                    TENKOJOBDETAILREMARK: TENKOJOBDETAILREMARK,
                    TENKOLOADINFORMREMARK: TENKOLOADINFORMREMARK,
                    TENKOAIRINFORMREMARK: TENKOAIRINFORMREMARK,
                    TENKOYOKOTENREMARK: TENKOYOKOTENREMARK,
                    TENKOCHIMOLATORREMARK: TENKOCHIMOLATORREMARK,
                    TENKOTRANSPORTREMARK: TENKOTRANSPORTREMARK,
                    TENKOAFTERGREETREMARK: TENKOAFTERGREETREMARK,
                    TENKOOXYGENREMARK: TENKOOXYGENREMARK,
                    TENKORESTDATA: TENKORESTDATA,
                    TENKOSLEEPTIMEDATA_AFTER6H: TENKOSLEEPTIMEDATA_AFTER6H,
                    TENKOSLEEPTIMEDATA_ADD45H: TENKOSLEEPTIMEDATA_ADD45H,
                    TENKOTEMPERATUREDATA: TENKOTEMPERATUREDATA,
                    TENKOPRESSUREDATA_90160: TENKOPRESSUREDATA_90160,
                    TENKOPRESSUREDATA_90160_2: TENKOPRESSUREDATA_90160_2,
                    TENKOPRESSUREDATA_90160_3: TENKOPRESSUREDATA_90160_3,
                    TENKOPRESSUREDATA_60100: TENKOPRESSUREDATA_60100,
                    TENKOPRESSUREDATA_60100_2: TENKOPRESSUREDATA_60100_2,
                    TENKOPRESSUREDATA_60100_3: TENKOPRESSUREDATA_60100_3,
                    TENKOPRESSUREDATA_60110: TENKOPRESSUREDATA_60110,
                    TENKOPRESSUREDATA_60110_2: TENKOPRESSUREDATA_60110_2,
                    TENKOPRESSUREDATA_60110_3: TENKOPRESSUREDATA_60110_3,
                    TENKOALCOHOLDATA: TENKOALCOHOLDATA,
                    TENKOOXYGENDATA: TENKOOXYGENDATA,
                    TENKOMASTERDIRVERCODE: '<?= $empcode ?>',
                    TENKOMASTERDIRVERNAME: '<?= $result_seEmployee2['nameT'] ?>'
                },
                success: function (rs) {

                    //window.location.reload();
                  
                    commit2();
                    // alert(rs);


                }
            });
        }

        function save_HealthForTenko(tenkomasterid)
        {
            // alert('SAVE HEALTH');
            // alert(tenkomasterid);
            // save_logprocess('Tenko', 'Save HealthForTenko', '<?= $result_seLogin['PersonCode'] ?>');
            


            var TENKOSHORTSIGHTCHECK = (chk_shortsight.checked == true) ? '1' : '';
            var TENKOSHORTSIGHTRESULT = (chk_rsshortsightok.checked == true) ? '1' : '';
            var TENKOSHORTSIGHTREMARK = document.getElementById('txt_shortsightremark').value;

            var TENKOLONGSIGHTCHECK = (chk_longsight.checked == true) ? '1' : '';
            var TENKOLONGSIGHTRESULT = (chk_rslongsightok.checked == true) ? '1' : '';
            var TENKOLONGSIGHTREMARK = document.getElementById('txt_longsightremark').value;

            var TENKOOBLIQUESIGHTCHECK = (chk_obliquesight.checked == true) ? '1' : '';
            var TENKOOBLIQUESIGHTRESULT = (chk_rsobliquesightok.checked == true) ? '1' : '';
            var TENKOOBLIQUESIGHTREMARK = document.getElementById('txt_obliquesightremark').value;

            var TENKOMASTERDIRVERCODE = document.getElementById('txt_employeecode').value;
            
            // alert(TENKOSHORTSIGHTRESULT);


            $.ajax({
                url: 'meg_data2.php',
                type: 'POST',
                data: {
                    txt_flg: "save_healthfortenko",
                    TENKOMASTERID: tenkomasterid,
                    TENKOMASTERDIRVERCODE:TENKOMASTERDIRVERCODE,
                    TENKOSHORTSIGHTCHECK: TENKOSHORTSIGHTCHECK,
                    TENKOSHORTSIGHTRESULT: TENKOSHORTSIGHTRESULT,
                    TENKOSHORTSIGHTREMARK: TENKOSHORTSIGHTREMARK,
                    TENKOLONGSIGHTCHECK: TENKOLONGSIGHTCHECK,
                    TENKOLONGSIGHTRESULT: TENKOLONGSIGHTRESULT,
                    TENKOLONGSIGHTREMARK: TENKOLONGSIGHTREMARK,
                    TENKOOBLIQUESIGHTCHECK: TENKOOBLIQUESIGHTCHECK,
                    TENKOOBLIQUESIGHTRESULT: TENKOOBLIQUESIGHTRESULT,
                    TENKOOBLIQUESIGHTREMARK: TENKOOBLIQUESIGHTREMARK
                },
                success: function (rs) {

                    //window.location.reload();

                    // commit2();
                    // alert(rs);


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
