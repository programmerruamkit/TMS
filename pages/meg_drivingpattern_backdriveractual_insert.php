<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
include("../MobileDetect/Mobile_Detect.php");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");

$detect = new Mobile_Detect();

// Check for any mobile device.
if ($detect->isMobile()){
   // mobile content
   $checkClient = 'MB';
}
else {
   // other content for desktops
   $checkClient = 'DT';
}
/////////////////////////////////////////////////////
$employee1 = " AND a.PersonCode = '" .$_SESSION["USERNAME"] . "'";
$sql_seEmp1 = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmp1 = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($employee1, SQLSRV_PARAM_IN)
);
$query_seEmp1 = sqlsrv_query($conn, $sql_seEmp1, $params_seEmp1);
$result_seEmp1 = sqlsrv_fetch_array($query_seEmp1, SQLSRV_FETCH_ASSOC);

//////////////////////////////////////////////////////

if ($_GET['type'] == "officercheck") {
    $checktype = "เจ้าหน้าที่ตรวจสอบข้อมูล";
}else{
    $checktype = "พนักงานลงข้อมูล";
}
//////////////////////////////////////////////////////

$checkArea = substr($_GET['employeecode'],0,2);


$employee1 = " AND a.PersonCode = '" .$_SESSION["USERNAME"] . "'";
$sql_seEmp1 = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmp1 = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($employee1, SQLSRV_PARAM_IN)
);
$query_seEmp1 = sqlsrv_query($conn, $sql_seEmp1, $params_seEmp1);
$result_seEmp1 = sqlsrv_fetch_array($query_seEmp1, SQLSRV_FETCH_ASSOC);



// echo $result_seComEmpChk['COMCHK'];
// echo "<br>";
// echo date("Y");
// echo "TLEP_EYE:";
// echo $eyecheck;

//  check ปัญหาสายตาและการสวมแว่นสายตาของ ฝั่ง AMT และ RRC (GW)
// $sql_seEyeproblem = "SELECT TOP 1 TLEP_WEARGLASSES
// FROM  [dbo].[SIMULATORHISTORY] 
// WHERE DRIVERCODE = '".$_GET['employeecode']."'
// ORDER BY TLEP_FOLLOWUP DESC";
// $query_seHealthhistory = sqlsrv_query($conn, $sql_seTlepWearglasses, $params_seTlepWearglasses);
// $result_seHealthhistory = sqlsrv_fetch_array($query_seTlepWearglasses, SQLSRV_FETCH_ASSOC);


?>
<html lang="en">
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>เอกสารรูปแบบการวิ่งงาน</title>

        
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.min.js"></script>
        <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../dist/js/jquery.autocomplete.js"></script> 
        <link href="../js/bootstrap-datepicker.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
        <!-- <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet"> -->
        <style>
            .navbar-default {

                border-color: #ffcb0b;
            }
            /* #page-wrapper {
                border-left: 1px solid #ffcb0b;
            }
            .popover-content {
                padding: 10px 10px;
                width: 200px;
            } */

            #loading {
                display:none;   
                opacity: 0.5;
                /* border-radius: 50%; */
                /* border-top: 12px ; */
                width: 10px;
                left: 50px;
                right: 850px;
                top:10px;
                bottom: 350px;
                height: 10px;
                
                /* animation: spin 1s linear infinite; */
            }
            
            .center {
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                margin: auto;
            }

            .swal2-popup {
                font-size: 16px !important;
                padding: 17px;
                border: 1px solid #F0E1A1;
                display: block;
                margin: 22px;
                text-align: center;
                color: #61534e;
            }
            
            
            .button {
            display: inline-block;
            padding: 15px 25px;
            font-size: 24px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
            }

            .button:hover {background-color: #3e8e41}

            .button:active {
            background-color: #3e8e41;
            box-shadow: 0 5px #666;
            transform: translateY(10px);
            }

            .button1 {
            display: inline-block;
            padding: 15px 25px;
            font-size: 20px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #4c8baf;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
            }

            .button1:hover {background-color: #4c8baf}

            .button1:active {
            background-color: #3e568e;
            box-shadow: 0 5px #999;
            transform: translateY(10px);
            }
            /*Self2yes css  */
            /* self2yes > input[type="radio"] {
                display: none;
            }
            self2yes > input[type="radio"] + *::before {
                content: "";
                display: inline-block;
                vertical-align: bottom;
                width: 3rem;
                height: 3rem;
                margin-right: 0.3rem;
                border-radius: 50%;
                border-style: solid;
                border-width: 0.1rem;
                border-color: gray;
            }
            self2yes > input[type="radio"]:checked + *::before {
                background: radial-gradient(teal 0%, teal 40%, transparent 50%, transparent);
                border-color: teal;
            } */

            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            td, th {
                border: 1px solid #000000;
                text-align: left;
                padding: 8px;
            }

            /* tr:nth-child(even) {
                background-color: #dddddd;
            } */

        </style>
    </head>
    <body>

        <!-- <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header" >
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
        </nav> -->
        <?php

            $sql_seData = "SELECT DRIVINGPATTERNGO_ID,DRIVINGPATTERNRETURN_ID,EMPLOYEECODE1,EMPLOYEENAME1,EMPLOYEECODE2,EMPLOYEENAME2,THAINAME_ID,PLANING_ROUTE,ACTUAL_ROUTE,DRIVINGPATTERN_DATE,OFFICERCHECK_RETURN,
                PLANID1,PLANID2,
                
                PARKINGTIME_PLAN_4HUR_P1,CONVERT(CHAR(16), DATEADD(MINUTE,+15,REPLACE(PARKINGTIME_PLAN_4HUR_P1, 'T', ' ')), 121)  AS 'TIME4HURP15P1', 
                PARKINGTIME_PLAN_2HUR_P1,CONVERT(CHAR(16), DATEADD(MINUTE,+15,REPLACE(PARKINGTIME_PLAN_2HUR_P1, 'T', ' ')), 121)  AS 'TIME2HURP15P1',
                CONFIRMEDBY_P1,CONVERT(VARCHAR,CONFIRMEDDATE_P1,20) AS 'CONFIRMEDDATE_P1',STATUS_UNLOCK_P1,

                PARKINGTIME_PLAN_4HUR_P2,CONVERT(CHAR(16), DATEADD(MINUTE,+15,REPLACE(PARKINGTIME_PLAN_4HUR_P2, 'T', ' ')), 121)  AS 'TIME4HURP15P2', 
                PARKINGTIME_PLAN_2HUR_P2,CONVERT(CHAR(16), DATEADD(MINUTE,+15,REPLACE(PARKINGTIME_PLAN_2HUR_P2, 'T', ' ')), 121)  AS 'TIME2HURP15P2',
                CONFIRMEDBY_P2,CONVERT(VARCHAR,CONFIRMEDDATE_P2,20) AS 'CONFIRMEDDATE_P2',STATUS_UNLOCK_P2,

                PARKINGTIME_PLAN_4HUR_P3,CONVERT(CHAR(16), DATEADD(MINUTE,+15,REPLACE(PARKINGTIME_PLAN_4HUR_P3, 'T', ' ')), 121)  AS 'TIME4HURP15P3', 
                PARKINGTIME_PLAN_2HUR_P3,CONVERT(CHAR(16), DATEADD(MINUTE,+15,REPLACE(PARKINGTIME_PLAN_2HUR_P3, 'T', ' ')), 121)  AS 'TIME2HURP15P3',
                CONFIRMEDBY_P3,CONVERT(VARCHAR,CONFIRMEDDATE_P3,20) AS 'CONFIRMEDDATE_P3',STATUS_UNLOCK_P3,

                PARKINGTIME_PLAN_4HUR_P4,CONVERT(CHAR(16), DATEADD(MINUTE,+15,REPLACE(PARKINGTIME_PLAN_4HUR_P4, 'T', ' ')), 121)  AS 'TIME4HURP15P4', 
                PARKINGTIME_PLAN_2HUR_P4,CONVERT(CHAR(16), DATEADD(MINUTE,+15,REPLACE(PARKINGTIME_PLAN_2HUR_P4, 'T', ' ')), 121)  AS 'TIME2HURP15P4',
                CONFIRMEDBY_P4,CONVERT(VARCHAR,CONFIRMEDDATE_P4,20) AS 'CONFIRMEDDATE_P4',STATUS_UNLOCK_P4,

                PARKINGTIME_PLAN_4HUR_P5,CONVERT(CHAR(16), DATEADD(MINUTE,+15,REPLACE(PARKINGTIME_PLAN_4HUR_P5, 'T', ' ')), 121)  AS 'TIME4HURP15P5', 
                PARKINGTIME_PLAN_2HUR_P5,CONVERT(CHAR(16), DATEADD(MINUTE,+15,REPLACE(PARKINGTIME_PLAN_2HUR_P5, 'T', ' ')), 121)  AS 'TIME2HURP15P5',
                CONFIRMEDBY_P5,CONVERT(VARCHAR,CONFIRMEDDATE_P5,20) AS 'CONFIRMEDDATE_P5',STATUS_UNLOCK_P5,

                PARKINGTIME_PLAN_4HUR_P6,CONVERT(CHAR(16), DATEADD(MINUTE,+15,REPLACE(PARKINGTIME_PLAN_4HUR_P6, 'T', ' ')), 121)  AS 'TIME4HURP15P6', 
                PARKINGTIME_PLAN_2HUR_P6,CONVERT(CHAR(16), DATEADD(MINUTE,+15,REPLACE(PARKINGTIME_PLAN_2HUR_P6, 'T', ' ')), 121)  AS 'TIME2HURP15P6',
                CONFIRMEDBY_P6,CONVERT(VARCHAR,CONFIRMEDDATE_P6,20) AS 'CONFIRMEDDATE_P6',STATUS_UNLOCK_P6,

                CONFIRMEDBY_ACTUAL_DEALER,CONVERT(VARCHAR,CONFIRMEDDATE_ACTUAL_DEALER,20) AS 'CONFIRMEDDATE_ACTUAL_DEALER',
                DRIVINGPATTERNRETURN_STATUS


                FROM DRIVINGPATTERN_RETURN 
                WHERE DRIVINGPATTERNRETURN_ID ='".$_GET['drivingbackplanid']."'";
            $params_seData = array();
            $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
            $result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC);

            // แสดงสีข้อมูล P1
            if ($result_seData['CONFIRMEDBY_P1'] == '' || $result_seData['CONFIRMEDDATE_P1'] == '') {
                $colorp1 = 'background-color: #e6e6e6';
            }else{
                $colorp1 = 'background-color: #93f786';
            }
            // แสดงสีข้อมูล P2
            if ($result_seData['CONFIRMEDBY_P2'] == '' || $result_seData['CONFIRMEDDATE_P2'] == '') {
                $colorp2 = 'background-color: #e6e6e6';
            }else{
                $colorp2 = 'background-color: #93f786';
            }
            // แสดงสีข้อมูล P3
            if ($result_seData['CONFIRMEDBY_P3'] == '' || $result_seData['CONFIRMEDDATE_P3'] == '') {
                $colorp3 = 'background-color: #e6e6e6';
            }else{
                $colorp3 = 'background-color: #93f786';
            }
            // แสดงสีข้อมูล P4
            if ($result_seData['CONFIRMEDBY_P4'] == '' || $result_seData['CONFIRMEDDATE_P4'] == '') {
                $colorp4 = 'background-color: #e6e6e6';
            }else{
                $colorp4 = 'background-color: #93f786';
            }
            // แสดงสีข้อมูล P5
            if ($result_seData['CONFIRMEDBY_P5'] == '' || $result_seData['CONFIRMEDDATE_P5'] == '') {
                $colorp5 = 'background-color: #e6e6e6';
            }else{
                $colorp5 = 'background-color: #93f786';
            }
            // แสดงสีข้อมูล P6
            if ($result_seData['CONFIRMEDBY_P6'] == '' || $result_seData['CONFIRMEDDATE_P6'] == '') {
                $colorp6 = 'background-color: #e6e6e6';
            }else{
                $colorp6 = 'background-color: #93f786';
            }
            // แสดงสีข้อมูล ALL LOAD
            if ($result_seData['CONFIRMEDBY_ACTUAL_DEALER'] == '' || $result_seData['CONFIRMEDDATE_ACTUAL_DEALER'] == '') {
                $colorallload = 'background-color: #e6e6e6';
            }else{
                $colorallload = 'background-color: #93f786';
            }
            /////////////////////////////////////////////////////////////////////////////

            // FEEDBACK จากพนักงานลงข้อมูล อาจจะมีการลงข้อมูลที่ช้ากว่าแผนงาน จึงไม่ได้ล็อคเวลา 25/01/2025
            // จากเดิม CHECK ใน ELSE จะเป็น NO เสมอ

            // CHECK การลงข้อมูล P1
            if ($result_seData['PARKINGTIME_PLAN_4HUR_P1'] != '') {
                //CHECKTIME P1 
                $start4hurp1chk   = strtotime($result_seData['PARKINGTIME_PLAN_4HUR_P1']);
                $end4hurp1chk     = strtotime($result_seData['TIME4HURP15P1']);
                $current4hurp1    = strtotime(date('Y-m-d H:i'));
                if (($current4hurp1 >= $start4hurp1chk) && ($current4hurp1 <= $end4hurp1chk)) {
                      $CHK4HURP1 = 'YES';
                    // $CHKDIS = 'disabled=""';
                }else{
                    $CHK4HURP1 = 'YES';
                    //   $CHK4HURP1 = 'NO';
                    // $CHKDIS = 'disabled=""';
                }
            }else{
                $CHK4HURP1 = 'YES';
                //   $CHK4HURP1 = 'NO';
                // $CHKDIS = 'disabled=""';
            }
                
            // CHECK การลงข้อมูล P1
            if ($result_seData['PARKINGTIME_PLAN_2HUR_P1'] != '') {
                //CHECKTIME P1 
                $start2hurp1chk   = strtotime($result_seData['PARKINGTIME_PLAN_2HUR_P1']);
                $end2hurp1chk     = strtotime($result_seData['TIME2HURP15P1']);
                $current2hurp1    = strtotime(date('Y-m-d H:i'));
                if (($current2hurp1 >= $start2hurp1chk) && ($current2hurp1 <= $end2hurp1chk)) {
                      $CHK2HURP1 = 'YES';
                    // $CHKDIS = 'disabled=""';
                }else{
                    $CHK2HURP1 = 'YES';
                    //   $CHK2HURP1 = 'NO';
                    // $CHKDIS = 'disabled=""';
                }
            }else{
                $CHK2HURP1 = 'YES';
                //   $CHK2HURP1 = 'NO';
                // $CHKDIS = 'disabled=""';
            }
            ///////////////////////////////////////////////////////////////////////////////////

            // CHECK การลงข้อมูล P2
            if ($result_seData['PARKINGTIME_PLAN_4HUR_P2'] != '') {
                //CHECKTIME P2 
                $start4hurp2chk   = strtotime($result_seData['PARKINGTIME_PLAN_4HUR_P2']);
                $end4hurp2chk     = strtotime($result_seData['TIME4HURP15P2']);
                $current4hurp2    = strtotime(date('Y-m-d H:i'));
                if (($current4hurp2 >= $start4hurp2chk) && ($current4hurp2 <= $end4hurp2chk)) {
                      $CHK4HURP2 = 'YES';
                    // $CHKDIS = 'disabled=""';
                }else{
                    $CHK4HURP2 = 'YES';
                    //   $CHK4HURP2 = 'NO';
                    // $CHKDIS = 'disabled=""';
                }
            }else{
                $CHK4HURP2 = 'NO';
                //   $CHK4HURP2 = 'NO';
                // $CHKDIS = 'disabled=""';
            }
                
            // CHECK การลงข้อมูล P2
            if ($result_seData['PARKINGTIME_PLAN_2HUR_P2'] != '') {
                //CHECKTIME P2 
                $start2hurp2chk   = strtotime($result_seData['PARKINGTIME_PLAN_2HUR_P2']);
                $end2hurp2chk     = strtotime($result_seData['TIME2HURP15P2']);
                $current2hurp2    = strtotime(date('Y-m-d H:i'));
                if (($current2hurp2 >= $start2hurp2chk) && ($current2hurp2 <= $end2hurp2chk)) {
                      $CHK2HURP2 = 'YES';
                    // $CHKDIS = 'disabled=""';
                }else{
                    $CHK2HURP2 = 'YES';
                    //   $CHK2HURP2 = 'NO';
                    // $CHKDIS = 'disabled=""';
                }
            }else{
                $CHK2HURP2 = 'YES';
                //   $CHK2HURP2 = 'NO';
                // $CHKDIS = 'disabled=""';
            }
            ///////////////////////////////////////////////////////////////////////////////////
            
            // CHECK การลงข้อมูล P3
            if ($result_seData['PARKINGTIME_PLAN_4HUR_P3'] != '') {
                //CHECKTIME P3 
                $start4hurp3chk   = strtotime($result_seData['PARKINGTIME_PLAN_4HUR_P3']);
                $end4hurp3chk     = strtotime($result_seData['TIME4HURP15P3']);
                $current4hurp3    = strtotime(date('Y-m-d H:i'));
                if (($current4hurp3 >= $start4hurp3chk) && ($current4hurp3 <= $end4hurp3chk)) {
                      $CHK4HURP3 = 'YES';
                    // $CHKDIS = 'disabled=""';
                }else{
                    $CHK4HURP3 = 'YES';
                    //   $CHK4HURP3 = 'NO';
                    // $CHKDIS = 'disabled=""';
                }
            }else{
                $CHK4HURP3 = 'YES';
                //   $CHK4HURP3 = 'NO';
                // $CHKDIS = 'disabled=""';
            }
                
            // CHECK การลงข้อมูล P3
            if ($result_seData['PARKINGTIME_PLAN_2HUR_P3'] != '') {
                //CHECKTIME P2 
                $start2hurp3chk   = strtotime($result_seData['PARKINGTIME_PLAN_2HUR_P3']);
                $end2hurp3chk     = strtotime($result_seData['TIME2HURP15P3']);
                $current2hurp3   = strtotime(date('Y-m-d H:i'));
                if (($current2hurp3 >= $start2hurp3chk) && ($current2hurp3 <= $end2hurp3chk)) {
                      $CHK2HURP3 = 'YES';
                    // $CHKDIS = 'disabled=""';
                }else{
                    $CHK2HURP3 = 'YES';
                    //   $CHK2HURP3 = 'NO';
                    // $CHKDIS = 'disabled=""';
                }
            }else{
                $CHK2HURP3 = 'YES';
                //   $CHK2HURP3 = 'NO';
                // $CHKDIS = 'disabled=""';
            }
            ///////////////////////////////////////////////////////////////////////////////////
            
            // CHECK การลงข้อมูล P4
            if ($result_seData['PARKINGTIME_PLAN_4HUR_P4'] != '') {
                //CHECKTIME P4 
                $start4hurp4chk   = strtotime($result_seData['PARKINGTIME_PLAN_4HUR_P4']);
                $end4hurp4chk     = strtotime($result_seData['TIME4HURP15P4']);
                $current4hurp4    = strtotime(date('Y-m-d H:i'));
                if (($current4hurp4 >= $start4hurp4chk) && ($current4hurp4 <= $end4hurp4chk)) {
                      $CHK4HURP4 = 'YES';
                    // $CHKDIS = 'disabled=""';
                }else{
                    $CHK4HURP4 = 'YES';
                    //   $CHK4HURP4 = 'NO';
                    // $CHKDIS = 'disabled=""';
                }
            }else{
                $CHK4HURP4 = 'YES';
                //   $CHK4HURP4 = 'NO'$CHK4HURP4 = 'YES';;
                // $CHKDIS = 'disabled=""';
            }
                
            // CHECK การลงข้อมูล P4
            if ($result_seData['PARKINGTIME_PLAN_2HUR_P4'] != '') {
                //CHECKTIME P4 
                $start2hurp4chk   = strtotime($result_seData['PARKINGTIME_PLAN_2HUR_P4']);
                $end2hurp4chk     = strtotime($result_seData['TIME2HURP15P4']);
                $current2hurp4   = strtotime(date('Y-m-d H:i'));
                if (($current2hurp4 >= $start2hurp4chk) && ($current2hurp4 <= $end2hurp4chk)) {
                      $CHK2HURP4 = 'YES';
                    // $CHKDIS = 'disabled=""';
                }else{
                    $CHK2HURP4 = 'YES';
                    //   $CHK2HURP4 = 'NO';
                    // $CHKDIS = 'disabled=""';
                }
            }else{
                $CHK2HURP4 = 'YES';
                //   $CHK2HURP4 = 'NO';
                // $CHKDIS = 'disabled=""';
            }
            ///////////////////////////////////////////////////////////////////////////////////        

            // CHECK การลงข้อมูล P5
            if ($result_seData['PARKINGTIME_PLAN_4HUR_P5'] != '') {
                //CHECKTIME P5 
                $start4hurp5chk   = strtotime($result_seData['PARKINGTIME_PLAN_4HUR_P5']);
                $end4hurp5chk     = strtotime($result_seData['TIME4HURP15P5']);
                $current4hurp5    = strtotime(date('Y-m-d H:i'));
                if (($current4hurp5 >= $start4hurp5chk) && ($current4hurp5 <= $end4hurp5chk)) {
                      $CHK4HURP5 = 'YES';
                    // $CHKDIS = 'disabled=""';
                }else{
                    $CHK4HURP5 = 'YES';
                    //   $CHK4HURP5 = 'NO';
                    // $CHKDIS = 'disabled=""';
                }
            }else{
                $CHK4HURP5 = 'YES';
                //   $CHK4HURP5 = 'NO';
                // $CHKDIS = 'disabled=""';
            }
                
            // CHECK การลงข้อมูล P5
            if ($result_seData['PARKINGTIME_PLAN_2HUR_P5'] != '') {
                //CHECKTIME P5 
                $start2hurp5chk   = strtotime($result_seData['PARKINGTIME_PLAN_2HUR_P5']);
                $end2hurp5chk     = strtotime($result_seData['TIME2HURP15P5']);
                $current2hurp5    = strtotime(date('Y-m-d H:i'));
                if (($current2hurp5 >= $start2hurp5chk) && ($current2hurp5 <= $end2hurp5chk)) {
                      $CHK2HURP5 = 'YES';
                    // $CHKDIS = 'disabled=""';
                }else{
                    $CHK2HURP5 = 'YES';
                    //   $CHK2HURP5 = 'NO';
                    // $CHKDIS = 'disabled=""';
                }
            }else{
                $CHK2HURP5 = 'YES';
                //   $CHK2HURP5 = 'NO';
                // $CHKDIS = 'disabled=""';
            }
            ///////////////////////////////////////////////////////////////////////////////////        

            // CHECK การลงข้อมูล P6
            if ($result_seData['PARKINGTIME_PLAN_4HUR_P6'] != '') {
                //CHECKTIME P6 
                $start4hurp6chk   = strtotime($result_seData['PARKINGTIME_PLAN_4HUR_P6']);
                $end4hurp6chk     = strtotime($result_seData['TIME4HURP15P6']);
                $current4hurp6    = strtotime(date('Y-m-d H:i'));
                if (($current4hurp6 >= $start4hurp6chk) && ($current4hurp6 <= $end4hurp6chk)) {
                      $CHK4HURP6 = 'YES';
                    // $CHKDIS = 'disabled=""';
                }else{
                    $CHK4HURP6 = 'YES';
                    //   $CHK4HURP6 = 'NO';
                    // $CHKDIS = 'disabled=""';
                }
            }else{
                $CHK4HURP6 = 'YES';
                //   $CHK4HURP6 = 'NO';
                // $CHKDIS = 'disabled=""';
            }
                
            // CHECK การลงข้อมูล P6
            if ($result_seData['PARKINGTIME_PLAN_2HUR_P6'] != '') {
                //CHECKTIME P6
                $start2hurp6chk   = strtotime($result_seData['PARKINGTIME_PLAN_2HUR_P6']);
                $end2hurp6chk     = strtotime($result_seData['TIME2HURP15P6']);
                $current2hurp6    = strtotime(date('Y-m-d H:i'));
                if (($current2hurp6 >= $start2hurp6chk) && ($current2hurp6 <= $end2hurp6chk)) {
                      $CHK2HURP6 = 'YES';
                    // $CHKDIS = 'disabled=""';
                }else{
                    $CHK2HURP6 = 'YES';
                    //   $CHK2HURP6 = 'NO';
                    // $CHKDIS = 'disabled=""';
                }
            }else{
                $CHK2HURP6 = 'YES';
                //   $CHK2HURP6 = 'NO';
                // $CHKDIS = 'disabled=""';
            }
            ///////////////////////////////////////////////////////////////////////////////////        

        ?>    
        
            <div id="page-wrapper">
                <p>&nbsp;</p>

                <div id="datade_edit">
                    <div class="row" id="list-data">
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12" style="font-size: 18px;text-align: center;">เอกสารรูปแบบการวิ่งงาน Actual (Driving Pattern)</div>
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-4"  style="font-size: 16px;text-align: center;">วันที่: <b><?=date("d-m-Y")?></b></div>
                        <div class="col-lg-4"  style="font-size: 16px;text-align: center;">ชื่อ-นามสกุล:<b> <?=$result_seEmp1['nameT']?></b> </div>
                        <div class="col-lg-4"  style="font-size: 16px;text-align: center;">รหัสพนักงาน:<b> <?=$result_seEmp1['PersonCode']?></b> </div>
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12" style="font-size: 18px;text-align: center;">หมายเลขไอดี: <?=$_GET['drivingbackplanid']?></div>
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12" style="font-size: 20px;text-align: center;"><b>วิ่งจริงขากลับ</b></div>
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12" style="text-align: center;">
                            <b style="font-size: 16px"></b>
                            &nbsp;<button class="button" style="width:45%;font-size: 18px;border:solid 2px;color:black;<?=$colorp1?>;" onclick="select_searchDrivingPattern('BackActual','1','<?=$CHK4HURP1?>','<?=$CHK2HURP1?>')">ลงข้อมูล ช่วงที่1</button>
                        </div>
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12" style="text-align: center;">
                            <b style="font-size: 16px"></b>
                            &nbsp;<button class="button" style="width:45%;font-size: 18px;border:solid 2px;color:black;<?=$colorp2?>;" onclick="select_searchDrivingPattern('BackActual','2','<?=$CHK4HURP2?>','<?=$CHK2HURP2?>')">ลงข้อมูล ช่วงที่2</button>
                        </div>
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12" style="text-align: center;">
                            <b style="font-size: 16px"></b>
                            &nbsp;<button class="button" style="width:45%;font-size: 18px;border:solid 2px;color:black;<?=$colorp3?>;" onclick="select_searchDrivingPattern('BackActual','3','<?=$CHK4HURP3?>','<?=$CHK2HURP3?>')">ลงข้อมูล ช่วงที่3</button>
                        </div>
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12" style="text-align: center;">
                            <b style="font-size: 16px"></b>
                            &nbsp;<button class="button" style="width:45%;font-size: 18px;border:solid 2px;color:black;<?=$colorp4?>;" onclick="select_searchDrivingPattern('BackActual','4','<?=$CHK4HURP4?>','<?=$CHK2HURP4?>')">ลงข้อมูล ช่วงที่4</button>
                        </div>
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12" style="text-align: center;">
                            <b style="font-size: 16px"></b>
                            &nbsp;<button class="button" style="width:45%;font-size: 18px;border:solid 2px;color:black;<?=$colorp5?>;" onclick="select_searchDrivingPattern('BackActual','5','<?=$CHK4HURP5?>','<?=$CHK2HURP5?>')">ลงข้อมูล ช่วงที่5</button>
                        </div>
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12" style="text-align: center;">
                            <b style="font-size: 16px"></b>
                            &nbsp;<button class="button" style="width:45%;font-size: 18px;border:solid 2px;color:black;<?=$colorp6?>;" onclick="select_searchDrivingPattern('BackActual','6','<?=$CHK4HURP6?>','<?=$CHK2HURP6?>')">ลงข้อมูล ช่วงที่6</button>
                        </div>
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12" style="text-align: center;">
                            <b style="font-size: 16px"></b>
                            &nbsp;<button class="button" style="width:45%;font-size: 18px;border:solid 2px;color:black;<?=$colorallload?>;" onclick="select_searchDrivingPattern('BackActual','load','YES','YES')">ลงข้อมูล<br>โหลดรถลง</button>
                        </div>
                        <div class="col-lg-12">&nbsp;</div>
                    </div>

                </div>
                <div id="datasr_edit">
                </div>
                <div class="row" >
                    <div class="col-lg-12">
                        &nbsp;
                    </div>
                </div>
            </div>
        </div>
            
        <!-- Modal sleepnormal -->
        <!-- <div class="modal fade" id="modal_tenkosleepnormal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="">
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
                                <input type="text" autocomplete="off"   class="form-control datetimeen" id="txt_startsleepnormal" name="txt_startsleepnormal">

                            </div>
                            <div class="col-lg-6">
                                <label>เวลาตื่นพักผ่อน  </label>
                                <input type="text" autocomplete="off"   class="form-control datetimeen" id="txt_endsleepnormal" name="txt_endsleepnormal">

                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="save_timenormalsleep()">บันทึก</button>
                    </div>




                </div>
            </div>
        </div> -->

        
        <!-- this will show our spinner -->
        <!-- <div  id="loading" class="center" >
            <p><img style="" src="../images/Truckload5.gif" /></p>
        </div> -->
        
        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>
        <script src="../js/bootstrap-datepicker.min.js"></script>
        <script src="../js/bootstrap-datepicker.th.min.js"></script>
        <!-- <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
        <script type="text/javascript">

        

        
            function select_searchDrivingPattern(checkdata,checksection,chkstatus4hur,chkstatus2hur)
            {
                // alert(checkdata);
                // showLoading();
                var drivinggoplanid     = '<?=$_GET['drivinggoplanid']?>';
                var drivingbackplanid   = '<?=$_GET['drivingbackplanid']?>';
                
                if (checkdata == 'BackActual') {

                    if (chkstatus4hur == 'YES' || chkstatus2hur == 'YES') {
                        // alert('P1');
                        // alert('Go Actual officer')
                        window.open('meg_searchDrivingPatternPlanBackActualDriverInsert.php?drivingbackplanid=' + drivingbackplanid+'&checksection='+ checksection, '_blank');
                        window.location.reload();
                    }else{
                        if ((checksection == '1') && ('<?=$result_seData['STATUS_UNLOCK_P1']?>' == 'YES')) {
                            
                            window.open('meg_searchDrivingPatternPlanBackActualDriverInsert.php?drivingbackplanid=' + drivingbackplanid+'&checksection='+ checksection, '_blank');
                            window.location.reload();

                        }else if ((checksection == '2') && ('<?=$result_seData['STATUS_UNLOCK_P2']?>' == 'YES')){
                            
                            window.open('meg_searchDrivingPatternPlanBackActualDriverInsert.php?drivingbackplanid=' + drivingbackplanid+'&checksection='+ checksection, '_blank');
                            window.location.reload();

                        }else if ((checksection == '3') && ('<?=$result_seData['STATUS_UNLOCK_P3']?>' == 'YES')){
                            
                            window.open('meg_searchDrivingPatternPlanBackActualDriverInsert.php?drivingbackplanid=' + drivingbackplanid+'&checksection='+ checksection, '_blank');
                            window.location.reload();

                        }else if ((checksection == '4') && ('<?=$result_seData['STATUS_UNLOCK_P4']?>' == 'YES')){
                            
                            window.open('meg_searchDrivingPatternPlanBackActualDriverInsert.php?drivingbackplanid=' + drivingbackplanid+'&checksection='+ checksection, '_blank');
                            window.location.reload();

                        }else if ((checksection == '5') && ('<?=$result_seData['STATUS_UNLOCK_P5']?>' == 'YES')){
                            
                            window.open('meg_searchDrivingPatternPlanBackActualDriverInsert.php?drivingbackplanid=' + drivingbackplanid+'&checksection='+ checksection, '_blank');
                            window.location.reload();

                        }else if ((checksection == '6') && ('<?=$result_seData['STATUS_UNLOCK_P6']?>' == 'YES')){
                            
                            window.open('meg_searchDrivingPatternPlanBackActualDriverInsert.php?drivingbackplanid=' + drivingbackplanid+'&checksection='+ checksection, '_blank');
                            window.location.reload();

                        }else{
                        swal.fire({
                                title: "Warning!",
                                html: '<div style="text-align: center;"> ไม่สามารถดำเนินการได้เนื่องจากเลยเวลา และ<br>ยังไม่ได้ปลดล็อคแผนจากเจ้าหน้าที่</div>',
                                // text: "ไม่สามารถลงเวลาได้เนื่องจากเลยเวลาที่วางแผนไว้ 10 นาที",
                                icon: "warning",
                                showConfirmButton: true,
                                allowOutsideClick: false,
                            });
                        }
                        // swal.fire({
                        //     title: "Warning!",
                        //     html: '<div style="text-align: center;"> ไม่สามารถลงเวลาได้เนื่องจาก<br>เลยเวลาที่วางแผนไว้หรือยังไม่ถึงเวลา</div>',
                        //     // text: "ไม่สามารถลงเวลาได้เนื่องจากเลยเวลาที่วางแผนไว้ 10 นาที",
                        //     icon: "warning",
                        //     showConfirmButton: true,
                        //     allowOutsideClick: false,
                        // });
                    }
                    // alert('Go Actual officer')
                    // window.open('meg_searchDrivingPatternPlanGoActualDriverInsert.php?drivinggoplanid=' + drivinggoplanid+'&checksection='+ checksection, '_blank');
                    // window.location.reload();


                }else{
                    // alert('Back Actual officer')
                    // window.open('meg_searchDrivingPatternPlanBackActualOfficer.php?drivingbackplanid=' + drivingbackplanid, '_blank');
                    // window.location.reload();

                }
                
                
                
                

            }                                        
            
            
            $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".dateen").datetimepicker({
                    timepicker: true,
                    dateformat: 'Y-m-d' , // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                    timeFormat: "HH:mm"

                }
                );
            });

            $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".dateen_admin").datetimepicker({
                    timepicker: false,
                    format: 'd/m/Y' , // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                    lang: 'th' // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                    // timeFormat: "HH:mm"

                }
                );
            });

           
           

        </script>






    </body>

</html>
<?php
sqlsrv_close($conn);
?>