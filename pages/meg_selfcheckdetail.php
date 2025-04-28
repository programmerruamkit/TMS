<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
include("../MobileDetect/Mobile_Detect.php");
require_once("../class/meg_function.php");
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

if ($_GET['type'] == "officercheck") {
    $checktype = "เจ้าหน้าที่ตรวจสอบข้อมูล";
}else{
    $checktype = "พนักงานลงข้อมูล";
}
//////////////////////////////////////////////////////

$checkArea = substr($_GET['employeecode'],0,2);

if ($checkArea == '01' || $checkArea == '02' || $checkArea == '07' || $checkArea == '08' ) {
    $areashow = '(AMT)';

    $sql_seTenkoSTD = "SELECT STD_ID,MAXSYS,MINSYS,MAXDIA,MINDIA,MAXPULSE,MINPULSE,TEMP,OXYGEN,ALCOHOL,REMARK
        FROM STANDARDTENKODATA
        WHERE REMARK ='AMT'";
    $query_seTenkoSTD = sqlsrv_query($conn, $sql_seTenkoSTD, $params_seTenkoSTD);
    $result_seTenkoSTD = sqlsrv_fetch_array($query_seTenkoSTD, SQLSRV_FETCH_ASSOC);

    $sql_seComEmpChk = "SELECT Company_Code AS 'COMCHK' 
        FROM EMPLOYEEEHR2 
        WHERE PersonCode ='".$_GET['employeecode']."'";
    $query_seComEmpChk = sqlsrv_query($conn, $sql_seComEmpChk, $params_seComEmpChk);
    $result_seComEmpChk = sqlsrv_fetch_array($query_seComEmpChk, SQLSRV_FETCH_ASSOC);

    //  check ปัญหาสายตาและการสวมแว่นสายตาของ ฝั่ง AMT 
    $sql_seEyeproblem = "SELECT TOP 1 SHORTSIGHT,LONGSIGHT,OBLIQUESIGHT 
    FROM HEALTHHISTORY 
    WHERE CREATEYEAR ='".date("Y")."'
    AND EMPLOYEECODE ='".$_GET['employeecode']."'";
    $query_seEyeproblem = sqlsrv_query($conn, $sql_seEyeproblem, $params_seEyeproblem);
    $result_seEyeproblem = sqlsrv_fetch_array($query_seEyeproblem, SQLSRV_FETCH_ASSOC);
    
    // AMT ใช้ปกติ ไม่มีการเช็คปัญหาสายตาจากระบบ แต่จะแจ้งเตือนตามการตอบของพนักงาน
    if ($result_seEyeproblem['SHORTSIGHT'] == '1' || $result_seEyeproblem['LONGSIGHT'] == '1' || $result_seEyeproblem['OBLIQUESIGHT'] == '1') {
        $eyecheck = '0';
    }else {
        $eyecheck = '0';
    }

}else{
    $areashow = '(GW)';

    $sql_seTenkoSTD = "SELECT STD_ID,MAXSYS,MINSYS,MAXDIA,MINDIA,MAXPULSE,MINPULSE,TEMP,OXYGEN,ALCOHOL,REMARK
        FROM STANDARDTENKODATA
        WHERE REMARK ='GW'";
    $query_seTenkoSTD = sqlsrv_query($conn, $sql_seTenkoSTD, $params_seTenkoSTD);
    $result_seTenkoSTD = sqlsrv_fetch_array($query_seTenkoSTD, SQLSRV_FETCH_ASSOC);

    $sql_seComEmpChk = "SELECT Company_Code AS 'COMCHK' 
        FROM EMPLOYEEEHR2 
        WHERE PersonCode ='".$_GET['employeecode']."'";
    $query_seComEmpChk = sqlsrv_query($conn, $sql_seComEmpChk, $params_seComEmpChk);
    $result_seComEmpChk = sqlsrv_fetch_array($query_seComEmpChk, SQLSRV_FETCH_ASSOC);

    if ($result_seComEmpChk['COMCHK'] == 'RRC') {
        //  สายงาน RRC จะอ้างอิงข้อมูลจาก ข้อมูลสุขภาพประจำปี
        $sql_seEyeproblem = "SELECT TOP 1 SHORTSIGHT,LONGSIGHT,OBLIQUESIGHT 
            FROM HEALTHHISTORY 
            WHERE CREATEYEAR ='".date("Y")."'
            AND EMPLOYEECODE ='".$_GET['employeecode']."'";
        $query_seEyeproblem = sqlsrv_query($conn, $sql_seEyeproblem, $params_seEyeproblem);
        $result_seEyeproblem = sqlsrv_fetch_array($query_seEyeproblem, SQLSRV_FETCH_ASSOC);
        
        if ($result_seEyeproblem['SHORTSIGHT'] == '1' || $result_seEyeproblem['LONGSIGHT'] == '1' || $result_seEyeproblem['OBLIQUESIGHT'] == '1') {
            $eyecheck = '1';
        }else {
            $eyecheck = '0';
        }

    }else{
        // check ปัญหาสายตาและการสวมแว่นสายตาของ TLEP ฝั่ง GW สายงาน RCC,RATC
        $sql_seEyeproblem = "SELECT TOP 1 TLEP_WEARGLASSES
            FROM  [dbo].[SIMULATORHISTORY] 
            WHERE DRIVERCODE = '".$_GET['employeecode']."'
            ORDER BY TLEP_FOLLOWUP DESC";
        $query_seEyeproblem = sqlsrv_query($conn, $sql_seEyeproblem, $params_seEyeproblem);
        $result_seEyeproblem = sqlsrv_fetch_array($query_seEyeproblem, SQLSRV_FETCH_ASSOC);

        if ($result_seEyeproblem['TLEP_WEARGLASSES'] == '1') {
            $eyecheck = '1';
        }else{
            $eyecheck = '0';
        }
    }
    
    
}





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
        <link rel="shortcut icon" href="../images/self_check.ico" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>บันทึกข้อมูลใบแจ้งสุขภาพ</title>

        
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.min.js"></script>
        <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../dist/js/jquery.autocomplete.js"></script> 
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
            #page-wrapper {
                border-left: 1px solid #ffcb0b;
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
            background-color: #02a30f;
            }

            /* On mouse-over, add a grey background color */
            .container:hover input ~ .checkmark {
            background-color: #02a30f;
            }

            /* When the checkbox is checked, add a blue background */
            .container input:checked ~ .checkmark {
            background-color: #02a30f;
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

            /*สีเขียว */
            self1no  > input[type="radio"],self2no  > input[type="radio"]
            ,self3no  > input[type="radio"],self4no  > input[type="radio"]
            ,self5no  > input[type="radio"],self6yes  > input[type="radio"]
            ,selfnormalsleepyes  > input[type="radio"],selfextrasleepyes  > input[type="radio"]
            ,selfdoctorno > input[type="radio"],selfworryno > input[type="radio"]
            ,selfhouseholdyes > input[type="radio"],selfcarryhearingaidno > input[type="radio"]
            /* Tlep และ ข้อมูลจากประวัติสุขภาพ */
            ,selfeyeproblemyes_eyecheck > input[type="radio"],selfeyeglassesyes_eyecheck > input[type="radio"] 
            /* ---------- */
            ,selfeyeproblemno > input[type="radio"],selfeyeglassesno > input[type="radio"]
            ,selfcarryeyeglassesyes > input[type="radio"] {
                display: none;
            }


            self1no  > input[type="radio"] + *::before,self2no  > input[type="radio"] + *::before
            ,self3no  > input[type="radio"] + *::before,self4no  > input[type="radio"] + *::before
            ,self5no  > input[type="radio"] + *::before,self6yes  > input[type="radio"] + *::before
            ,selfnormalsleepyes  > input[type="radio"] + *::before,selfextrasleepyes  > input[type="radio"] + *::before
            ,selfdoctorno  > input[type="radio"] + *::before,selfworryno  > input[type="radio"] + *::before
            ,selfhouseholdyes  > input[type="radio"] + *::before,selfcarryhearingaidno> input[type="radio"] + *::before
            /* Tlep และ ข้อมูลจากประวัติสุขภาพ */
            ,selfeyeproblemyes_eyecheck > input[type="radio"] + *::before,selfeyeglassesyes_eyecheck > input[type="radio"] + *::before
            /* ---------- */
            ,selfeyeproblemno  > input[type="radio"] + *::before,selfeyeglassesno  > input[type="radio"] + *::before
            ,selfcarryeyeglassesyes  > input[type="radio"] + *::before {
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
            /* self1yes > input[type="radio"]:checked + * {
                color: teal;
            } */

            self1no  > input[type="radio"]:checked + *::before,self2no  > input[type="radio"]:checked + *::before
            ,self3no  > input[type="radio"]:checked + *::before,self4no  > input[type="radio"]:checked + *::before
            ,self5no  > input[type="radio"]:checked + *::before,self6yes  > input[type="radio"]:checked + *::before
            ,selfnormalsleepyes  > input[type="radio"]:checked + *::before,selfextrasleepyes  > input[type="radio"]:checked + *::before
            ,selfdoctorno  > input[type="radio"]:checked + *::before,selfworryno  > input[type="radio"]:checked + *::before
            ,selfhouseholdyes  > input[type="radio"]:checked + *::before,selfcarryhearingaidno> input[type="radio"]:checked + *::before
            /* Tlep และ ข้อมูลจากประวัติสุขภาพ */
            ,selfeyeproblemyes_eyecheck > input[type="radio"]:checked + *::before,selfeyeglassesyes_eyecheck > input[type="radio"]:checked + *::before
            /* ---------- */
            ,selfeyeproblemno  > input[type="radio"]:checked + *::before,selfeyeglassesno  > input[type="radio"]:checked + *::before
            ,selfcarryeyeglassesyes  > input[type="radio"]:checked + *::before {
                background: radial-gradient(teal 0%, teal 40%, transparent 50%, transparent);
                border-color: teal;
            }

            
            /* @if <?=$eyecheck == '1'?> {
                selfeyeproblemno  > input[type="radio"]:checked + *::before {
                    background: radial-gradient(blue 0%, blue 40%, transparent 50%, transparent);
                    border-color: blue;
                }
            } @else {
                selfeyeproblemno  > input[type="radio"]:checked + *::before {
                    background: radial-gradient(green 0%, green 40%, transparent 50%, transparent);
                    border-color: green;
                }
            } */


             /*สีแดง  */
            self1yes > input[type="radio"],self2yes > input[type="radio"]
            ,self3yes > input[type="radio"],self4yes > input[type="radio"]
            ,self5yes > input[type="radio"],self6no > input[type="radio"]
            ,selfnormalsleepno > input[type="radio"],selfextrasleepno > input[type="radio"]
            ,selfdoctoryes > input[type="radio"],selfworryyes > input[type="radio"]
            ,selfhouseholdno > input[type="radio"] ,selfcarryhearingaidyes > input[type="radio"]
            /* Tlep และ ข้อมูลจากประวัติสุขภาพ */
            ,selfeyeproblemno_eyecheck > input[type="radio"],selfeyeglassesno_eyecheck > input[type="radio"]
            /* ---------- */
            ,selfeyeproblemyes > input[type="radio"],selfeyeglassesyes > input[type="radio"]
            ,selfcarryeyeglassesno > input[type="radio"] {
                display: none;
            }
            self1yes > input[type="radio"] + *::before,self2yes > input[type="radio"] + *::before
            ,self3yes > input[type="radio"] + *::before,self4yes > input[type="radio"] + *::before
            ,self5yes > input[type="radio"] + *::before,self6no > input[type="radio"] + *::before
            ,selfnormalsleepno > input[type="radio"] + *::before,selfextrasleepno > input[type="radio"] + *::before
            ,selfdoctoryes > input[type="radio"] + *::before,selfworryyes > input[type="radio"] + *::before
            ,selfhouseholdno > input[type="radio"] + *::before,selfcarryhearingaidyes > input[type="radio"] + *::before
            /* Tlep และ ข้อมูลจากประวัติสุขภาพ */
            ,selfeyeproblemno_eyecheck > input[type="radio"] + *::before,selfeyeglassesno_eyecheck > input[type="radio"] + *::before
            /* ---------- */
            ,selfeyeproblemyes > input[type="radio"] + *::before,selfeyeglassesyes > input[type="radio"] + *::before
            ,selfcarryeyeglassesno > input[type="radio"] + *::before {
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
            self1yes > input[type="radio"]:checked + *::before,self2yes > input[type="radio"]:checked + *::before
            ,self3yes > input[type="radio"]:checked + *::before,self4yes > input[type="radio"]:checked + *::before
            ,self5yes > input[type="radio"]:checked + *::before,self6no > input[type="radio"]:checked + *::before
            ,selfnormalsleepno > input[type="radio"]:checked + *::before,selfextrasleepno > input[type="radio"]:checked + *::before
            ,selfdoctoryes > input[type="radio"]:checked + *::before,selfworryyes > input[type="radio"]:checked + *::before
            ,selfhouseholdno > input[type="radio"]:checked + *::before,selfcarryhearingaidyes > input[type="radio"]:checked + *::before
             /* Tlep และ ข้อมูลจากประวัติสุขภาพ */
            ,selfeyeproblemno_eyecheck > input[type="radio"]:checked + *::before,selfeyeglassesno_eyecheck > input[type="radio"]:checked + *::before
            /* ---------- */
            ,selfeyeproblemyes > input[type="radio"]:checked + *::before,selfeyeglassesyes > input[type="radio"]:checked + *::before
            ,selfcarryeyeglassesno > input[type="radio"]:checked + *::before {
                background: radial-gradient(red 0%, red 40%, transparent 50%, transparent);
                border-color: red;
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
            // $sql_sePlandata = "SELECT JOBSTART,JOBEND,VEHICLETRANSPORTPLANID FROM VEHICLETRANSPORTPLAN WHERE JOBNO ='".$_GET['jobno']."'";
            // $params_sePlandata = array();
            // $query_sePlandata = sqlsrv_query($conn, $sql_sePlandata, $params_sePlandata);
            // $result_sePlandata = sqlsrv_fetch_array($query_sePlandata, SQLSRV_FETCH_ASSOC);  
            
            if ($_GET['type'] == 'insert') {
                $sql_seSelfCheck = "SELECT TOP 1 SELFCHECKID,EMPLOYEECODE,EMPLOYEENAME,DATEJOBSTART,DATEWORKING,DATEPRESENT,
                    TIREDYESCHK,TIREDNOCHK,ILLNESSYESCHK,ILLNESSNOCHK,DROWSEYESCHK,DROWSENOCHK,INJURYYESCHK,INJURYNOCHK,
                    TAKEMEDICINEYESCHK,TAKEMEDICINENOCHK,HEALTHYYESCHK,HEALTHYNOCHK,KEYDROPTIME,SLEEPRESTSTART,SLEEPRESTEND,TIMESLEEPREST,
                    SLEEPNORMALSTART,SLEEPNORMALEND,TIMESLEEPNORMAL,SLEEPNORMALYES,SLEEPNORMALNO,
                    SLEEPEXTRASTART,SLEEPEXTRAEND,TIMESLEEPEXTRA,SLEEPEXTRAYES,SLEEPEXTRANO,
                    DISEASE,SEEDOCTORYES,SEEDOCTORNO,DRUGNAME,DRUGTIME,
                    WORRYYES,WORRYNO,HOUSEHOLDYES,HOUSEHOLDNO,TEMPERATURE,SYSVALUE1,SYSVALUE2,SYSVALUE3,
                    DIAVALUE1,DIAVALUE2,DIAVALUE3,EYEPROBLEMYES,EYEPROBLEMNO,EYEGLASSESYES,EYEGLASSESNO,CARRYEYEGLASSESYES,CARRYEYEGLASSESNO,
                    CARRYHEARINGAIDYES,CARRYHEARINGAIDNO,ALCOHOLTYPE,ALCOHOLTIME,ALCOHOLVOLUME,ACTIVESTATUS,CREATEBY,CREATEDATE,CONFIRMEDBY,CONFIRMEDDATE,
                    CONVERT(VARCHAR(15),CONFIRMEDDATE,103) AS 'CFDATE',CONVERT(VARCHAR(5), CONFIRMEDDATE, 108) AS 'CFTIME',
                    CONVERT(VARCHAR(10),CREATEDATE,103) AS 'CREATEDATE',CONVERT(VARCHAR(5), CREATEDATE, 108) AS 'TIMECREATE'
                    FROM DRIVERSELFCHECK WHERE EMPLOYEECODE ='".$_GET['employeecode']."' 
                    AND (CONVERT(VARCHAR(10),CREATEDATE,103) = '".$_GET['datedriverchk']."')
                    AND ACTIVESTATUS ='1'
                    ORDER BY  CONVERT(CHAR(5), CREATEDATE, 108) DESC";
                $params_seSelfCheck = array();
                $query_seSelfCheck = sqlsrv_query($conn, $sql_seSelfCheck, $params_seSelfCheck);
                $result_seSelfCheck = sqlsrv_fetch_array($query_seSelfCheck, SQLSRV_FETCH_ASSOC);

                // เช็คโรคประจำตัว
                if ($result_seSelfCheck['DISEASE'] == '') {
                    $diseaseinsertchk = '-';
                }else {
                    $diseaseinsertchk = $result_seSelfCheck['DISEASE'];
                }

                    // เช็คชื่อยา
                if ($result_seSelfCheck['DRUGNAME'] == '') {
                    $drugnameinsertchk = '-';
                }else {
                    $drugnameinsertchk = $result_seSelfCheck['DRUGNAME'];
                }


                // ประเภทแอลกอฮอล์
                if ($result_seSelfCheck['ALCOHOLTYPE'] == '') {
                    $alcoholtypeinsertchk = '-';
                }else {
                    $alcoholtypeinsertchk = $result_seSelfCheck['ALCOHOLTYPE'];
                }

                // ปริมาณแอลกอฮอล์
                if ($result_seSelfCheck['ALCOHOLVOLUME'] == '') {
                    $alcoholvolumeinsertchk = '0';
                }else {
                    $alcoholvolumeinsertchk = $result_seSelfCheck['ALCOHOLVOLUME'];
                }
                
                
                    // เวลาวางกุญแจสำหรับพขรเช็ค ต้องน้อยกว่าไอดีอันเดิม และเป็นเวลาแรกสุด
                $sql_seKeyDropTime = "SELECT  TOP 1 SELFCHECKID,KEYDROPTIME,EMPLOYEECODE,DATEJOBSTART,DATEWORKING
                    FROM DRIVERSELFCHECK 
                    WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
                    AND CONVERT(DATE,DATEJOBSTART,103) < CONVERT(DATE,'".$_GET['datedriverchk']."',103)
                    AND (DATEWORKING !='' OR DATEPRESENT !='')
                    AND CONFIRMEDBY IS NOT NULL
                    AND ACTIVESTATUS ='1'
                    ORDER BY SELFCHECKID DESC";
                $params_seKeyDropTime = array();
                $query_seKeyDropTime = sqlsrv_query($conn, $sql_seKeyDropTime, $params_seKeyDropTime);
                $result_seKeyDropTime = sqlsrv_fetch_array($query_seKeyDropTime, SQLSRV_FETCH_ASSOC);

                //Query เดิม
                // $sql_seKeyDropTime = "SELECT TOP 1 SELFCHECKID,KEYDROPTIME,EMPLOYEECODE,DATEJOBSTART,DATEWORKING FROM(
                //     SELECT TOP 2 SELFCHECKID,KEYDROPTIME,EMPLOYEECODE,DATEJOBSTART,DATEWORKING FROM DRIVERSELFCHECK WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
                //     ORDER BY SELFCHECKID DESC
                //     )AS c
                //     ORDER BY c.SELFCHECKID ASC";
                // $params_seKeyDropTime = array();
                // $query_seKeyDropTime = sqlsrv_query($conn, $sql_seKeyDropTime, $params_seKeyDropTime);
                // $result_seKeyDropTime = sqlsrv_fetch_array($query_seKeyDropTime, SQLSRV_FETCH_ASSOC);
                
            }else if($_GET['type'] == 'officercheck') {

                // อัพเดทข้อมูลการตรวจร่างกาย ถ้าข้อมูลไม่ถูกต้อง SET ACTIVESTATUS = '0'
                $sql_seUpdateData = "UPDATE DRIVERSELFCHECK 
                    SET ACTIVESTATUS ='0'
                    WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
                    AND (DATEWORKING ='' OR DATEPRESENT ='' OR CONFIRMEDBY IS NULL)
                    AND CONVERT(DATE,DATEJOBSTART,103) < CONVERT(DATE,'".$_GET['datedriverchk']."',103)";
                $params_seUpdateData = array();
                $query_seUpdateData = sqlsrv_query($conn, $sql_seUpdateData, $params_seUpdateData);
                $result_seUpdateData = sqlsrv_fetch_array($query_seUpdateData, SQLSRV_FETCH_ASSOC);

                $sql_seSelfCheck = "SELECT TOP 1 SELFCHECKID,EMPLOYEECODE,EMPLOYEENAME,DATEJOBSTART,DATEWORKING,DATEPRESENT,
                    TIREDYESCHK,TIREDNOCHK,ILLNESSYESCHK,ILLNESSNOCHK,DROWSEYESCHK,DROWSENOCHK,INJURYYESCHK,INJURYNOCHK,
                    TAKEMEDICINEYESCHK,TAKEMEDICINENOCHK,HEALTHYYESCHK,HEALTHYNOCHK,KEYDROPTIME,SLEEPRESTSTART,SLEEPRESTEND,TIMESLEEPREST,
                    SLEEPNORMALSTART,SLEEPNORMALEND,TIMESLEEPNORMAL,SLEEPNORMALYES,SLEEPNORMALNO,
                    SLEEPEXTRASTART,SLEEPEXTRAEND,TIMESLEEPEXTRA,SLEEPEXTRAYES,SLEEPEXTRANO,
                    DISEASE,SEEDOCTORYES,SEEDOCTORNO,DRUGNAME,DRUGTIME,
                    WORRYYES,WORRYNO,HOUSEHOLDYES,HOUSEHOLDNO,TEMPERATURE,SYSVALUE1,SYSVALUE2,SYSVALUE3,
                    DIAVALUE1,DIAVALUE2,DIAVALUE3,EYEPROBLEMYES,EYEPROBLEMNO,EYEGLASSESYES,EYEGLASSESNO,CARRYEYEGLASSESYES,CARRYEYEGLASSESNO,
                    CARRYHEARINGAIDYES,CARRYHEARINGAIDNO,ALCOHOLTYPE,ALCOHOLTIME,ALCOHOLVOLUME,ACTIVESTATUS,CREATEBY,CREATEDATE,CONFIRMEDBY,CONFIRMEDDATE,
                    CONVERT(VARCHAR(15),CONFIRMEDDATE,103) AS 'CFDATE',CONVERT(VARCHAR(5), CONFIRMEDDATE, 108) AS 'CFTIME',
                    CONVERT(VARCHAR(10),CREATEDATE,103) AS 'CREATEDATE',CONVERT(VARCHAR(5), CREATEDATE, 108) AS 'TIMECREATE',
                    CONVERT(VARCHAR(10),CREATEDATE,120) AS 'CREATEDATESHOW'
                    FROM DRIVERSELFCHECK WHERE EMPLOYEECODE ='".$_GET['employeecode']."' 
                    AND SELFCHECKID = '".$_GET['id']."'
                    AND ACTIVESTATUS ='1'
                    ORDER BY  CONVERT(CHAR(5), CREATEDATE, 108) DESC";
                $params_seSelfCheck = array();
                $query_seSelfCheck = sqlsrv_query($conn, $sql_seSelfCheck, $params_seSelfCheck);
                $result_seSelfCheck = sqlsrv_fetch_array($query_seSelfCheck, SQLSRV_FETCH_ASSOC);

                
                // เช็คโรคประจำตัว
                if ($result_seSelfCheck['DISEASE'] == '') {
                    $diseaseinsertchk = '-';
                }else {
                    $diseaseinsertchk = $result_seSelfCheck['DISEASE'];
                }

                    // เช็คชื่อยา
                if ($result_seSelfCheck['DRUGNAME'] == '') {
                    $drugnameinsertchk = '-';
                }else {
                    $drugnameinsertchk = $result_seSelfCheck['DRUGNAME'];
                }


                // ประเภทแอลกอฮอล์
                if ($result_seSelfCheck['ALCOHOLTYPE'] == '') {
                    $alcoholtypeinsertchk = '-';
                }else {
                    $alcoholtypeinsertchk = $result_seSelfCheck['ALCOHOLTYPE'];
                }

                // ปริมาณแอลกอฮอล์
                if ($result_seSelfCheck['ALCOHOLVOLUME'] == '') {
                    $alcoholvolumeinsertchk = '0';
                }else {
                    $alcoholvolumeinsertchk = $result_seSelfCheck['ALCOHOLVOLUME'];
                }

                // $sql_seKeyDropTime = "SELECT TOP 1 SELFCHECKID,KEYDROPTIME,EMPLOYEECODE FROM(
                //     SELECT TOP 2 SELFCHECKID,KEYDROPTIME,EMPLOYEECODE FROM DRIVERSELFCHECK WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
                //     ORDER BY SELFCHECKID DESC
                //     )AS c
                //     ORDER BY c.SELFCHECKID ASC";
                // $params_seKeyDropTime = array();
                // $query_seKeyDropTime = sqlsrv_query($conn, $sql_seKeyDropTime, $params_seKeyDropTime);
                // $result_seKeyDropTime = sqlsrv_fetch_array($query_seKeyDropTime, SQLSRV_FETCH_ASSOC);
                
                    // เวลาวางกุญแจสำหรับเจ้าหน้าที่เช็ค ต้องน้อยกว่าไอดีอันเดิม และเป็นเวลาแรกสุด
                $sql_seKeyDropTime = "SELECT TOP 1 SELFCHECKID,KEYDROPTIME,EMPLOYEECODE FROM DRIVERSELFCHECK WHERE 
                    EMPLOYEECODE ='".$_GET['employeecode']."' AND SELFCHECKID < '".$_GET['id']."'
                    AND ACTIVESTATUS ='1'
                    ORDER BY SELFCHECKID DESC";
                $params_seKeyDropTime = array();
                $query_seKeyDropTime = sqlsrv_query($conn, $sql_seKeyDropTime, $params_seKeyDropTime);
                $result_seKeyDropTime = sqlsrv_fetch_array($query_seKeyDropTime, SQLSRV_FETCH_ASSOC);

            }else {
                $sql_seSelfCheck = "SELECT TOP 1 SELFCHECKID,EMPLOYEECODE,EMPLOYEENAME,DATEJOBSTART,DATEWORKING,DATEPRESENT,
                    TIREDYESCHK,TIREDNOCHK,ILLNESSYESCHK,ILLNESSNOCHK,DROWSEYESCHK,DROWSENOCHK,INJURYYESCHK,INJURYNOCHK,
                    TAKEMEDICINEYESCHK,TAKEMEDICINENOCHK,HEALTHYYESCHK,HEALTHYNOCHK,KEYDROPTIME,SLEEPRESTSTART,SLEEPRESTEND,TIMESLEEPREST,
                    SLEEPNORMALSTART,SLEEPNORMALEND,TIMESLEEPNORMAL,SLEEPNORMALYES,SLEEPNORMALNO,
                    SLEEPEXTRASTART,SLEEPEXTRAEND,TIMESLEEPEXTRA,SLEEPEXTRAYES,SLEEPEXTRANO,
                    DISEASE,SEEDOCTORYES,SEEDOCTORNO,DRUGNAME,DRUGTIME,
                    WORRYYES,WORRYNO,HOUSEHOLDYES,HOUSEHOLDNO,TEMPERATURE,SYSVALUE1,SYSVALUE2,SYSVALUE3,
                    DIAVALUE1,DIAVALUE2,DIAVALUE3,EYEPROBLEMYES,EYEPROBLEMNO,EYEGLASSESYES,EYEGLASSESNO,CARRYEYEGLASSESYES,CARRYEYEGLASSESNO,
                    CARRYHEARINGAIDYES,CARRYHEARINGAIDNO,ALCOHOLTYPE,ALCOHOLTIME,ALCOHOLVOLUME,ACTIVESTATUS,CREATEBY,CREATEDATE,CONFIRMEDBY,CONFIRMEDDATE,
                    CONVERT(VARCHAR(15),CONFIRMEDDATE,103) AS 'CFDATE',CONVERT(VARCHAR(5), CONFIRMEDDATE, 108) AS 'CFTIME',
                    CONVERT(VARCHAR(10),CREATEDATE,103) AS 'CREATEDATE',CONVERT(VARCHAR(5), CREATEDATE, 108) AS 'TIMECREATE',
                    CONVERT(VARCHAR(10),CREATEDATE,120) AS 'CREATEDATESHOW'
                    FROM DRIVERSELFCHECK WHERE EMPLOYEECODE ='".$_GET['employeecode']."' 
                    AND (CONVERT(VARCHAR(10),CREATEDATE,103) = '".$_GET['daterkchk']."')
                    AND ACTIVESTATUS ='1'
                    ORDER BY  CONVERT(CHAR(5), CREATEDATE, 108) DESC";
                $params_seSelfCheck = array();
                $query_seSelfCheck = sqlsrv_query($conn, $sql_seSelfCheck, $params_seSelfCheck);
                $result_seSelfCheck = sqlsrv_fetch_array($query_seSelfCheck, SQLSRV_FETCH_ASSOC);

                // $sql_seKeyDropTime = "SELECT TOP 1 SELFCHECKID,KEYDROPTIME,EMPLOYEECODE FROM(
                //     SELECT TOP 2 SELFCHECKID,KEYDROPTIME,EMPLOYEECODE FROM DRIVERSELFCHECK WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
                //     ORDER BY SELFCHECKID DESC
                //     )AS c
                //     ORDER BY c.SELFCHECKID ASC";
                // $params_seKeyDropTime = array();
                // $query_seKeyDropTime = sqlsrv_query($conn, $sql_seKeyDropTime, $params_seKeyDropTime);
                // $result_seKeyDropTime = sqlsrv_fetch_array($query_seKeyDropTime, SQLSRV_FETCH_ASSOC);
                
                // เวลาวางกุญแจสำหรับเจ้าหน้าที่เช็ค ต้องน้อยกว่าไอดีอันเดิม และเป็นเวลาแรกสุด
                $sql_seKeyDropTime = "SELECT TOP 1 SELFCHECKID,KEYDROPTIME,EMPLOYEECODE FROM DRIVERSELFCHECK WHERE 
                EMPLOYEECODE ='".$_GET['employeecode']."' AND SELFCHECKID < '".$_GET['id']."'
                AND ACTIVESTATUS ='1'
                ORDER BY SELFCHECKID DESC";
                $params_seKeyDropTime = array();
                $query_seKeyDropTime = sqlsrv_query($conn, $sql_seKeyDropTime, $params_seKeyDropTime);
                $result_seKeyDropTime = sqlsrv_fetch_array($query_seKeyDropTime, SQLSRV_FETCH_ASSOC);
            }
            
            
            if ($result_seSelfCheck['TIMESLEEPEXTRA'] == '' || $result_seSelfCheck['TIMESLEEPEXTRA'] == '<br /><b>Warning</b>:  sqlsrv_fetch_array() expects parameter 1 to be resource, boolean given in <b>') {
                $TIMESLEEPEXTRAHOURCHK = '0'; 
                $TIMESLEEPEXTRAMINCHK  = '0';
            }else {
                // $TIMESLEEPEXTRA  = str_replace(":","",substr($result_seSelfCheck['TIMESLEEPEXTRA'],0,6));
                //$TIMESLEEPEXTRA = $result_seSelfCheck['TIMESLEEPEXTRA'];
                //เช็คจำนวนชั่วโมงในการนอน
                $TIMESLEEPEXTRAHOURCHK = substr($result_seSelfCheck['TIMESLEEPEXTRA'],0,2);
                //เช็คจำนวนนาทีในการนอน
                $TIMESLEEPEXTRAMINCHK = substr($result_seSelfCheck['TIMESLEEPEXTRA'],2,3);
                if ($TIMESLEEPEXTRAHOURCHK  == '4:') { //กรณีที่เท่ากับ 4 
                    $TIMESLEEPEXTRAHOURCHK = 'HG4'; //HG4 mean Greater than 4 hour มากกว่า 4 ชม
                }else if ($TIMESLEEPEXTRAHOURCHK > '4') {
                    $TIMESLEEPEXTRAHOURCHK = 'HGG4'; //เลข 4 ขึ้นไปและเลขสองหลัก ex 5, 6, 10
                }
                else {
                    $TIMESLEEPEXTRAHOURCHK = 'HL4'; //HL4 mean Less than 4 hour น้อยกว่า 4 ชม  
                }
            //    //เช็คจำนวนนาทีในการนอน
                $TIMESLEEPEXTRAMINCHK = substr($result_seSelfCheck['TIMESLEEPEXTRA'],2,3);
                if ($TIMESLEEPEXTRAMINCHK >= '30') {
                    $TIMESLEEPEXTRAMINCHK = 'MG3'; //MG3 mean Greater than 30 minute มากกว่า 30นาที
                }else {
                    $TIMESLEEPEXTRAMINCHK = 'ML3'; //ML3 mean Less than 30 minute น้อยกว่า 30นาที   
                }

            }

            //เวลาการนอนปกติ 6 ชั่วโมง
            if ($result_seSelfCheck['TIMESLEEPNORMAL'] == '' || $result_seSelfCheck['TIMESLEEPNORMAL'] == '0:00' || $result_seSelfCheck['TIMESLEEPNORMAL'] == '<br /><b>Warning</b>:  sqlsrv_fetch_array() expects parameter 1 to be resource, boolean given in <b>') {
                $TIMESLEEPNORMAL = '0';
            }else {
                $TIMESLEEPNORMAL = substr($result_seSelfCheck['TIMESLEEPNORMAL'],0,2);
            }

            //เวลาการพักผ่อน 8 ชั่วโมง
            if (($result_seSelfCheck['TIMESLEEPREST'] == '' || $result_seSelfCheck['TIMESLEEPREST'] == '<br /><b>Warning</b>:  sqlsrv_fetch_array() expects parameter 1 to be resource, boolean given in <b>') && ($result_seKeyDropTime['KEYDROPTIME'] == NULL || $result_seKeyDropTime['KEYDROPTIME'] == '') ) {
                $TIMESLEEPREST = '0';
            }else {
                $TIMESLEEPREST = substr($result_seSelfCheck['TIMESLEEPREST'],0,2);
                // echo  $TIMESLEEPREST;
            }


            // echo $TIMESLEEPREST;
            // echo $TIMESLEEPEXTRAHOURCHK;
            // echo '<br>';
            // echo $TIMESLEEPEXTRAMINCHK;

            // echo '<br>';
            // echo $result_seSelfCheck['TIMESLEEPEXTRA'];
            // echo substr($TIMESLEEPNORMAL,0,2) ;
            if ($_GET['type'] == 'insert') {
                $sql_seTenkoData = "SELECT TOP 1 CONVERT(VARCHAR(10),b.CREATEDATE,103) AS 'TENKOCREATEDATE'
                    ,b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                    ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                    ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                    ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                    ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA,b.CREATEDATE
                    FROM  TENKOBEFORE b
                    WHERE b.TENKOMASTERDIRVERCODE  =  '".$_GET['employeecode']."'
                    AND CONVERT(DATE,b.CREATEDATE) =  CONVERT(DATE,GETDATE(),103)  
                    AND ACTIVESTATUS ='1'
                    ORDER BY CREATEDATE DESC";
                $params_seTenkoData = array();
                $query_seTenkoData = sqlsrv_query($conn, $sql_seTenkoData, $params_seTenkoData);
            }else if($_GET['type'] == 'officercheck') {
                $sql_seTenkoData = "SELECT TOP 1 CONVERT(VARCHAR(10),b.CREATEDATE,103) AS 'TENKOCREATEDATE'
                    ,b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                    ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                    ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                    ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                    ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA,b.CREATEDATE
                    FROM  TENKOBEFORE b
                    WHERE b.TENKOMASTERDIRVERCODE  =  '".$_GET['employeecode']."'
                    AND CONVERT(DATE,b.CREATEDATE,103) =  CONVERT(DATE,'".$_GET['daterkchk']."',103)
                    AND (b.TENKOTEMPERATUREDATA IS NOT NULL OR b.TENKOTEMPERATUREDATA !='')  
                    AND ACTIVESTATUS ='1'
                    ORDER BY CREATEDATE DESC";
                $params_seTenkoData = array();
                $query_seTenkoData = sqlsrv_query($conn, $sql_seTenkoData, $params_seTenkoData);
            }else {
                $sql_seTenkoData = "SELECT TOP 1 CONVERT(VARCHAR(10),b.CREATEDATE,103) AS 'TENKOCREATEDATE'
                    ,b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
                    ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
                    ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
                    ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
                    ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA,b.CREATEDATE
                    FROM  TENKOBEFORE b
                    WHERE b.TENKOMASTERDIRVERCODE  =  '".$_GET['employeecode']."'
                    AND CONVERT(DATE,b.CREATEDATE,103) =  CONVERT(DATE,'".$_GET['daterkchk']."',103)
                    AND (b.TENKOTEMPERATUREDATA IS NOT NULL OR b.TENKOTEMPERATUREDATA !='')  
                    AND ACTIVESTATUS ='1'
                    ORDER BY CREATEDATE DESC";
                $params_seTenkoData = array();
                $query_seTenkoData = sqlsrv_query($conn, $sql_seTenkoData, $params_seTenkoData);
            }
            


            $result_seTenkoData = sqlsrv_fetch_array($query_seTenkoData, SQLSRV_FETCH_ASSOC);
        ?>
            <div id="page-wrapper">
                <p>&nbsp;</p>

                <div id="datade_edit">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <!-- <div class="panel-heading" style="background-color: #e7e7e7">
                                <a href='meg_selfcheck.php'>หน้าแรก</a> / บันทึกใบแจ้งสุขภาพ
                                </div> -->
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                <p style="font-size: 20px;text-align: center;"> <b>บันทึกใบแจ้งสุขภาพ(<?=$checktype?>)</b> </p><br>
                                <p style="font-size: 18px;text-align: left;"><b>ชื่อ-นามสกุล: <?=$_GET['employeename']?></b></p>
                                <p style="font-size: 18px;text-align: left;"><b>รหัสพนักงาน: <?=$_GET['employeecode']?></b></p>
                                <p style="font-size: 18px;text-align: left;"><b>วันที่ในการลงข้อมูล: <?=$result_seSelfCheck['CREATEDATE']?></b></p>
                                <?php
                                if ($_GET['type'] == 'check' || $_GET['type'] == 'officercheck') {
                                ?>
                                <p style="font-size: 18px;text-align: left;"><b>Self Check ID: <?=$_GET['id']?></b></p>
                                <?php
                                }else {
                                ?>

                                <?php
                                }
                                ?>
                                </div>
                                <input  class="form-control" type="hidden" id="txt_username" name="txt_username" value="<?=$_SESSION["USERNAME"]?>">
                                <div id="datadef_edit">
                                    <div class="panel-body">
                                        <!-- <div class="row" > -->
                                        <div class="row" >
                                            <div class="col-lg-12" >
                                                <!--ที่วาง code เก่า  -->
                                                <!-- <th>
                                                <b><u>ข้อมูลและรายละเอียดแผนงาน</u></b>
                                                </th>
                                                <br>
                                                <th >
                                                    ชื่อ-นามสกุล: <b><u><?=$_GET['employeename']?></u></b> <br>
                                                    เลขที่งาน: <b><u><?=$_GET['jobno']?></u></b> <br>
                                                    ทะเบียนรถ: <b><u><?= $_GET['thainame']?></u></b><br>
                                                    วันที่เริ่มงาน: <b><u><?= $_GET['date']?></u></b> เวลาเริ่มงาน: <b><u><?= $_GET['time']?></u></b><br>
                                                    ต้นทาง: <b><u><?= $result_sePlandata['JOBSTART']?></u></b><br>
                                                    ปลายทาง: <b><u><?= $result_sePlandata['JOBEND']?></u></b></br>
                                                </th>     -->
                                            </div>
                                            <input type="hidden" name= "txt_datedriverchk" id="txt_datedriverchk" value="<?=$_GET['datedriverchk']?>"></input>
                                            <!-- dateworking คือ daterk ในแผนงาน -->
                                            <input type="hidden" name= "txt_dateworkingchk" id="txt_dateworkingchk" value="<?=$_GET['daterkchk']?>"></input>
                                            <input type="hidden" name= "txt_datepresentchk" id="txt_datepresentchk" value="<?=$_GET['datepresentchk']?>"></input>
                                            <input type="hidden" name= "txt_empname" id="txt_empname" value="<?=$_GET['employeename']?>"></input>
                                            <input type="hidden" name= "txt_empcode" id="txt_empcode" value="<?=$_GET['employeecode']?>"></input>
                                            <input type="hidden" name= "txt_selfchkid" id="txt_selfchkid" value="<?=$result_seSelfCheck['SELFCHECKID']?>"></input>
                                            <input type="hidden" name= "txt_selfsession" id="txt_selfsession" value="<?=$_SESSION["USERNAME"]?>"></input>
                                                
                                        </div>        
                                        <div class ="row"><br></div>
                                        <!-- START ROW1 -->
                                        <div class="row" >
                                            <div class="col-lg-4" >
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #f0c402;">
                                                        <label><font style="font-size: 16px">หัวข้อตรวจสอบความพร้อมของร่างกาย</font></label>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">
                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                            <div class = "row">
                                                                <div class="">
                                                                    <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width: 20%;text-align: center;" >หัวข้อ  </th>
                                                                                    <th style="width: 20%;text-align: center;" >ประเมิน </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <?php
                                                                            $tierdyeschk = ($result_seSelfCheck['TIREDYESCHK'] == '1') ? "checked" : "";
                                                                            $tierdnochk = ($result_seSelfCheck['TIREDNOCHK'] == '1') ? "checked" : "";
                                                                            $illnessyeschk = ($result_seSelfCheck['ILLNESSYESCHK'] == '1') ? "checked" : "";
                                                                            $illnessnochk = ($result_seSelfCheck['ILLNESSNOCHK'] == '1') ? "checked" : "";
                                                                            $drowseyeschk = ($result_seSelfCheck['DROWSEYESCHK'] == '1') ? "checked" : "";
                                                                            $drowsenochk = ($result_seSelfCheck['DROWSENOCHK'] == '1') ? "checked" : "";
                                                                            $injuryyeschk = ($result_seSelfCheck['INJURYYESCHK'] == '1') ? "checked" : "";
                                                                            $injurynochk = ($result_seSelfCheck['INJURYNOCHK'] == '1') ? "checked" : "";
                                                                            $takemedicineyeschk = ($result_seSelfCheck['TAKEMEDICINEYESCHK'] == '1') ? "checked" : "";
                                                                            $takemedicinenochk = ($result_seSelfCheck['TAKEMEDICINENOCHK'] == '1') ? "checked" : "";
                                                                            $healthyyeschk = ($result_seSelfCheck['HEALTHYYESCHK'] == '1') ? "checked" : "";
                                                                            $healthynochk = ($result_seSelfCheck['HEALTHYNOCHK'] == '1') ? "checked" : "";
                                                                            
                                                                            $sleepnormalyes = ($result_seSelfCheck['SLEEPNORMALYES'] == '1') ? "checked" : "";
                                                                            $sleepnormalno = ($result_seSelfCheck['SLEEPNORMALNO'] == '1') ? "checked" : "";
                                                                            
                                                                            $sleepextrayes = ($result_seSelfCheck['SLEEPEXTRAYES'] == '1') ? "checked" : "";
                                                                            $sleepextrano = ($result_seSelfCheck['SLEEPEXTRANO'] == '1') ? "checked" : "";

                                                                            $seedoctoryes = ($result_seSelfCheck['SEEDOCTORYES'] == '1') ? "checked" : "";
                                                                            $seedoctorno =  ($result_seSelfCheck['SEEDOCTORNO'] == '1') ? "checked" : "";
                                                                            
                                                                            $worryyes = ($result_seSelfCheck['WORRYYES'] == '1') ? "checked" : "";
                                                                            $worryno =  ($result_seSelfCheck['WORRYNO'] == '1') ? "checked" : "";
                                                                            $householdyes = ($result_seSelfCheck['HOUSEHOLDYES'] == '1') ? "checked" : "";
                                                                            $householdno =  ($result_seSelfCheck['HOUSEHOLDNO'] == '1') ? "checked" : "";

                                                                            $eyeproblemyes = ($result_seSelfCheck['EYEPROBLEMYES'] == '1') ? "checked" : "";
                                                                            $eyeproblemno =  ($result_seSelfCheck['EYEPROBLEMNO'] == '1') ? "checked" : "";
                                                                            $eyeglassesyes = ($result_seSelfCheck['EYEGLASSESYES'] == '1') ? "checked" : "";
                                                                            $eyeglassesno =  ($result_seSelfCheck['EYEGLASSESNO'] == '1') ? "checked" : "";
                                                                            $carryeyeglassesyes = ($result_seSelfCheck['CARRYEYEGLASSESYES'] == '1') ? "checked" : "";
                                                                            $carryeyeglassesno =  ($result_seSelfCheck['CARRYEYEGLASSESNO'] == '1') ? "checked" : "";
                                                                            $carryhearingaidyes = ($result_seSelfCheck['CARRYHEARINGAIDYES'] == '1') ? "checked" : "";
                                                                            $carryhearingaidno =  ($result_seSelfCheck['CARRYHEARINGAIDNO'] == '1') ? "checked" : "";
                                                                            
                                                                            
                                                                            ?>
                                                                            <tbody>
                                                                                <!-- self check1 -->
                                                                                <form action="">
                                                                                <tr>
                                                                                <td style="width: 20%;text-align: left;">มีอาการเหนื่อยล้า </td>
                                                                                    <td style="width: 20%;text-align: left;"> 
                                                                                    <self1yes>
                                                                                        <input style="height:30px; width:30px; vertical-align: middle;background-color: red" type="radio" id="self1yes" <?= $tierdyeschk ?> name="self1" value="self1yes" >
                                                                                        <label for="self1yes">มี</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    </self1yes>
                                                                                    <self1no>
                                                                                        <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="self1no" <?= $tierdnochk ?> name="self1" value="self1no">
                                                                                        <label for="self1no">ไม่มี</label>
                                                                                    </self1no>    
                                                                                    </td>
                                                                                </tr>
                                                                                <!-- self check2 -->
                                                                                <tr>
                                                                                    <td style="width: 20%;text-align: left;">มีอาการเจ็บป่วย </td>
                                                                                    <td style="width: 20%;text-align: left;"> 
                                                                                    <self2yes>
                                                                                        <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="self2yes" <?= $illnessyeschk ?> name="self2" value="self2yes">
                                                                                        <label for="self2yes">มี</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    <self2yes>
                                                                                    <self2no>  
                                                                                        <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="self2no" <?= $illnessnochk ?> name="self2" value="self2no">
                                                                                        <label for="self2no">ไม่มี</label>
                                                                                    </self2no>     
                                                                                    </td>
                                                                                </tr>
                                                                                <!-- self check3 -->
                                                                                <tr>
                                                                                    <td style="width: 20%;text-align: left;">มีอาการง่วงนอน </td>
                                                                                    <td style="width: 20%;text-align: left;"> 
                                                                                    <self3yes>
                                                                                        <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="self3yes" <?= $drowseyeschk ?> name="self3" value="self3yes" >
                                                                                        <label for="self3yes">มี</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    <self3yes>
                                                                                    <self3no>   
                                                                                        <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="self3no" <?= $drowsenochk ?> name="self3" value="self3no">
                                                                                        <label for="self3no">ไม่มี</label>
                                                                                    <self3no>
                                                                                    </td>
                                                                                </tr>
                                                                                <!-- self check4 -->
                                                                                <tr>
                                                                                    <td style="width: 20%;text-align: left;">มีอาการบาดเจ็บหรือทนต่อการบาดเจ็บ</td>
                                                                                    <td style="width: 20%;text-align: left;"> 
                                                                                    <self4yes>    
                                                                                        <input style="height:30px; width:30px; vertical-align: middle" type="radio" id="self4yes" <?= $injuryyeschk ?> name="self4" value="self4yes">
                                                                                        <label for="self4yes">มี</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    <self4yes>
                                                                                    <self4no>
                                                                                        <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="self4no" <?= $injurynochk ?> name="self4" value="self4no">
                                                                                        <label for="self4no">ไม่มี</label>
                                                                                    <self4no>
                                                                                    </td>
                                                                                </tr>
                                                                                <!-- self check5 -->
                                                                                <tr>
                                                                                    <td style="width: 20%;text-align: left;">มีการทานยาที่ส่งผลต่อการขับขี่</td>
                                                                                    <td style="width: 20%;text-align: left;"> 
                                                                                    <self4yes>    
                                                                                        <input style="height:30px; width:30px; vertical-align: middle" type="radio" id="self5yes" <?= $takemedicineyeschk ?> name="self5" value="self5yes">
                                                                                        <label for="self5yes">มี</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    <self4yes>
                                                                                    <self4no>
                                                                                        <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="self5no" <?= $takemedicinenochk ?> name="self5" value="self5no">
                                                                                        <label for="self5no">ไม่มี</label>
                                                                                    <self4no>
                                                                                    </td>
                                                                                </tr>
                                                                                <!-- self check5 -->
                                                                                <!-- <tr>
                                                                                    <td style="width: 20%;text-align: left;">มีการทานยาที่ส่งผลต่อการขับขี่</td>
                                                                                    <td style="width: 20%;text-align: left;">
                                                                                    <self5yes> 
                                                                                        <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="self5yes" <?= $takemedicineyeschk ?> name="self5" value="self5yes">
                                                                                        <label for="self5yes">มี</label> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    <self5yes>
                                                                                    <self5no>
                                                                                        <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="self5no" <?= $takemedicinenochk ?> name="self5" value="self5no">
                                                                                        <label for="self5no">ไม่มี</label>
                                                                                    <self5no>
                                                                                    </td>
                                                                                </tr> -->
                                                                                <!-- self checkall -->
                                                                                <tr>
                                                                                    <td style="width: 15%;text-align: left;"><b>1.สภาพร่างกาย</b></td>
                                                                                    <td style="width: 25%;text-align: left;">
                                                                                    <self6yes>
                                                                                        <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfallyes" <?= $healthyyeschk ?> name="selfall" value="selfallyes">
                                                                                        <label for="selfallyes">ปกติ</label> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    <self6yes>
                                                                                    <self6no>
                                                                                        <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfallno" <?= $healthynochk ?> name="selfall" value="selfallno">
                                                                                        <label for="selfallno">ไม่ปกติ</label>
                                                                                    <self6no>    
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                </div>  
                                                            </div>  
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                            <!-- END COLUNM1 -->
                                            <!-- START COLUNM3 -->
                                         <div class="col-lg-4" >
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #f0c402;">
                                                        <label><font style="font-size: 16px">ตรวจสอบระยะการพักผ่อน (8 ชั่วโมงขึ้นไป) ระยะเวลาการพักผ่อน</font></label>
                                                    </div>
                                                    
                                                    <div class="panel-body">
                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                            <div class = "row">
                                                                <div class="">
                                                                        <div class="form-group">
                                                                            <label >ช่วงเวลาการพักผ่อน(ระยะเวลาการพักผ่อน)</label><br>
                                                                            <label style="color:red">ในกรณีไม่มีเวลาเลิกงานของวันที่แล้ว ระบบจะใช้เวลาที่เจ้าหน้าที่ลงข้อมูล</label><br>
                                                                            <div class="col-lg-6">
                                                                                <?php
                                                                                if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                                ?>
                                                                                    <label ><u>เวลาเลิกงาน</u></label><br>
                                                                                    <input type="datetime-local" disabled =""  style="height:40px; width:240px;" id="daysleep_reststart" name="daysleep_reststart" value="<?= $result_seKeyDropTime['KEYDROPTIME'] ?>" min="" max="" onchange ="timesleepselfrestcheck('MB');" autocomplete="off">
                                                                                    <!-- <input type="datetime-local" style="height:40px; width:240px;" id="daysleep_reststart" name="daysleep_reststart" value="<?= $result_seSelfCheck['SLEEPRESTSTART'] ?>" min="" max="" onchange ="timesleepselfrestcheck('MB');" autocomplete="off"> -->
                                                                                <?php
                                                                                }else { //สำหรับ PC DESKTOP
                                                                                    
                                                                                    // $yearrest  = substr($result_seSelfCheck['SLEEPRESTEND'],0,4);
                                                                                    // $monthrest = substr($result_seSelfCheck['SLEEPRESTEND'],5,2);
                                                                                    // $dayrest   = substr($result_seSelfCheck['SLEEPRESTEND'],8,2);
                                                                                    // $timerest  = substr($result_seSelfCheck['SLEEPRESTEND'],11);

                                                                                    // $DATERESTSTART1 = str_replace("T"," ",$result_seSelfCheck['SLEEPRESTSTART']);
                                                                                    // $DATERESTSTART = str_replace("-","/",$DATERESTSTART1);

                                                                                    //ดึงข้อมูลเวลาวางกุญแจมาจาก การ TENKO ขากลับ
                                                                                    if ($result_seKeyDropTime['KEYDROPTIME'] == '') {
                                                                                        
                                                                                        $DATERESTSTART1 = str_replace("T"," ",$result_seSelfCheck['SLEEPRESTSTART']);
                                                                                        $DATERESTSTART = str_replace("-","/",$DATERESTSTART1);
                                                                                    }else {
                                                                                        $DATERESTSTART1 = str_replace("T"," ",$result_seKeyDropTime['KEYDROPTIME']);
                                                                                        $DATERESTSTART = str_replace("-","/",$DATERESTSTART1);
                                                                                    }
                                                                                     


                                                                                //    echo "sadsadsd";
                                                                                //    echo $result_seKeyDropTime['KEYDROPTIME'];
                                                                                ?> 
                                                                                <?php
                                                                                if ($_GET['type'] == 'insert') {
                                                                                 ?>
                                                                                 
                                                                                    <label ><u>เวลาเลิกงาน</u></label><br>
                                                                                    <input class="form-control dateen" disabled =""  style="height:40px; width:240px;"  id="daysleep_reststart" name="daysleep_reststart"  value="<?= $DATERESTSTART ?>" min="" max="" autocomplete="off">
                                                                                 <?php
                                                                                }else {
                                                                                 ?>
                                                                                    <!-- แก้ไขได้สำหรับ สิทธื์ check และ officer check -->
                                                                                    <label ><u>เวลาเลิกงาน</u></label><br>
                                                                                    <input class="form-control dateen"   style="height:40px; width:240px;"  id="daysleep_reststart" name="daysleep_reststart"  value="<?= $DATERESTSTART ?>" min="" max="" autocomplete="off">
                                                                                 <?php
                                                                                }
                                                                                ?>
                                                                                    
                                                                                <?php
                                                                                }
                                                                                ?>  
                                                                                
                                                                            </div>


                                                                            <div class="col-lg-6">
                                                                                <?php
                                                                                if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                                ?>
                                                                                    <label ><u>เวลาเริ่มปฏิบัติงาน</u></label><br>
                                                                                    
                                                                                    <?php
                                                                                    // echo  $result_seSelfCheck['SLEEPRESTEND'];
                                                                                    // echo "<br>";
                                                                                    // echo date("Y-m-d") ."T". date("H:i");
                                                                                    // echo "<br>";
                                                                                    $CURRENTDATE = date("Y-m-d") ."T". date("H:i");
                                                                                    // echo $CURRENTDATE;
                                                                                    // เช็คว่าถ้า เวลาเริ่มปฎิบัติงาน = '' คือ ยังไม่มีการลงข้อมูลให้เอาเวลา CURRENTDATE แต่ถ้ามีเวลาเริ่มปฎิบัติงาน ให้ใช้เวลาเริ่มปฎิบัติงาน
                                                                                    if ($result_seSelfCheck['SLEEPRESTEND'] == '') {
                                                                                        // echo "<br>";
                                                                                        // echo "time_null";
                                                                                    ?>
                                                                                        <input type="datetime-local" disabled ="" style="height:40px; width:240px" id="daysleep_restend" name="daysleep_restend" value="<?=  $CURRENTDATE ?>" min="" max=""  autocomplete="off">
                                                                                    <?php
                                                                                    }else{
                                                                                        // echo "<br>";
                                                                                        // echo "time";
                                                                                    ?>
                                                                                        <input type="datetime-local" disabled ="" style="height:40px; width:240px" id="daysleep_restend" name="daysleep_restend" value="<?= $result_seSelfCheck['SLEEPRESTEND'] ?>" min="" max=""  autocomplete="off">
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                    

                                                                                <?php
                                                                                }else { 
                                                                                    //สำหรับ PC DESKTOP
                                                                                    // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                    $DATERESTEND1 = str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                    $DATERESTEND = str_replace("-","/",$DATERESTEND1);

                                                                                    $CURRENTDATE = date("Y-m-d") ."T". date("H:i");
                                                                                    $CURRENTDATESHOW = date("Y/m/d") ." ". date("H:i");
                                                                                ?> 
                                                                                    <label ><u>เวลาเริ่มปฏิบัติงาน</u></label><br>

                                                                                        <?php
                                                                                        // type insert คือพนักงานมาลงข้อมูล
                                                                                        if ($_GET['type'] == 'insert') {
                                                                                        ?>
                                                                                                <?php
                                                                                                // echo $CURRENTDATE;
                                                                                                // เช็คว่าถ้า เวลาเริ่มปฎิบัติงาน = '' คือ ยังไม่มีการลงข้อมูลให้เอาเวลา CURRENTDATE แต่ถ้ามีเวลาเริ่มปฎิบัติงาน ให้ใช้เวลาเริ่มปฎิบัติงาน

                                                                                                if ($DATERESTEND == '') {
                                                                                                    // echo "<br>";
                                                                                                    // echo "time_null";
                                                                                                ?>
                                                                                                    <input class="form-control dateen" disabled ="" style="height:40px; width:240px" id="daysleep_restendshow" name="daysleep_restendshow" value="<?= $CURRENTDATESHOW ?>" min="" max=""  autocomplete="off">
                                                                                                    <input type="hidden" class="form-control dateen" disabled ="" style="height:40px; width:240px" id="daysleep_restend" name="daysleep_restend" value="<?= $CURRENTDATE ?>" min="" max=""  autocomplete="off">
                                                                                                <?php
                                                                                                }else {
                                                                                                    // echo "<br>";
                                                                                                    // echo "time";
                                                                                                ?>
                                                                                                    <input class="form-control dateen" disabled ="" style="height:40px; width:240px" id="daysleep_restend" name="daysleep_restend" value="<?= $DATERESTEND ?>" min="" max=""  autocomplete="off">
                                                                                                <?php
                                                                                                }
                                                                                                ?>
                                                                                        <?php
                                                                                        }else{
                                                                                        ?>
                                                                                            
                                                                                                <?php
                                                                                                // else คือ type check และ officer check สำหรับเจ้าหน้าที่ตรวจสอบข้อมูล
                                                                                                // echo $CURRENTDATE;
                                                                                                // เช็คว่าถ้า เวลาเริ่มปฎิบัติงาน = '' คือ ยังไม่มีการลงข้อมูลให้เอาเวลา CURRENTDATE แต่ถ้ามีเวลาเริ่มปฎิบัติงาน ให้ใช้เวลาเริ่มปฎิบัติงาน

                                                                                                if ($DATERESTEND == '') {
                                                                                                    // echo "<br>";
                                                                                                    // echo "time_null";
                                                                                                    // $CURRENTDATESHOW คือ เวลาที่แสดงบนหน้าจอ format Y/m/d H:i
                                                                                                ?>
                                                                                                    <input class="form-control dateen" disabled ="" style="height:40px; width:240px" id="daysleep_restendshow" name="daysleep_restendshow" value="<?= $CURRENTDATESHOW ?>" min="" max=""  autocomplete="off">
                                                                                                    <input type="hidden" class="form-control dateen"  style="height:40px; width:240px" id="daysleep_restend" name="daysleep_restend" value="<?= $CURRENTDATE ?>" min="" max=""  autocomplete="off">
                                                                                                <?php
                                                                                                }else {
                                                                                                    // echo "<br>";
                                                                                                    // echo "time";
                                                                                                ?>
                                                                                                    <input class="form-control dateen"  style="height:40px; width:240px" id="daysleep_restend" name="daysleep_restend" value="<?= $DATERESTEND ?>" min="" max=""  autocomplete="off">
                                                                                                <?php
                                                                                                }
                                                                                                ?>



                                                                                        <?php
                                                                                        }
                                                                                        
                                                                                        ?>
                                                                                        

                                                                                    
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                                
                                                                            </div>
                                                                            <br><br><br><br>

                                                                            
                                                                            <?php
                                                                            // ปุ่มยืนยันคำนวณเวลา ระยะเวลาการพักผ่อน ของ Mobile
                                                                            if ($checkClient == 'MB') {   
                                                                            ?>  <div class="col-lg-6">
                                                                                    <button type="button" style="height:40px; width:245px" class="btn btn-primary btn-lg" onclick ="timesleepselfrestcheck('MB');">กดยืนยันระยะเวลาการพักผ่อน</button>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <p style="color:red">*กดปุ่มยืนยันทุกครั้งที่มีการแก้ไขเวลา เพื่อคำนวณชั่วโมงการพักผ่อน</p>
                                                                                </div>
                                                                            <?php
                                                                            }else{ 
                                                                                /// ปุ่มยืนยันคำนวณเวลา ระยะเวลาการพักผ่อน ของ PC DESKTOP
                                                                            ?>
                                                                            <div class="col-lg-6">
                                                                                <?php
                                                                                if ($_GET['type'] == 'check' || $_GET['type'] == 'officercheck' ) {
                                                                                ?>
                                                                                    <button type="button" style="height:40px; width:240px" class="btn btn-primary btn-lg" onclick ="timesleepselfrestcheck('DT');">กดยืนยันระยะเวลาการพักผ่อน</button>
                                                                                <?php
                                                                                }else{
                                                                                ?>
                                                                                    <button type="button" style="height:40px; width:240px" class="btn btn-primary btn-lg" onclick ="timesleepselfrestcheck('DT');" >กดยืนยันระยะเวลาการพักผ่อน</button>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                               
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <p style="color:red">*กดปุ่มยืนยันทุกครั้งที่มีการแก้ไขเวลา เพื่อคำนวณชั่วโมงการพักผ่อน</p>
                                                                            </div>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            

                                                                        </div>

                                                                        <br><br>
                                                                        <div class="form-group">
                                                                            <label >ระยะเวลาที่พักผ่อน 8 ชั่วโมงขึ้นไป</label>
                                                                            <?php
                                                                            if ($TIMESLEEPREST == '0') {
                                                                            ?>
                                                                            <input readonly  type="text" class="form-control" id="timesleep_rest" name="timesleep_rest" value= "" autocomplete="off">    
                                                                            <?php
                                                                            }else if ($TIMESLEEPREST >= '8') {
                                                                            ?>
                                                                            <input readonly style="background-color: #94FA67;" type="text" class="form-control" id="timesleep_rest" name="timesleep_rest" value= "<?= $result_seSelfCheck['TIMESLEEPREST'] ?>" autocomplete="off">
                                                                            <?php
                                                                            }else {
                                                                            ?>
                                                                            <input readonly style="background-color: #FA6767;" type="text" class="form-control" id="timesleep_rest" name="timesleep_rest" value= "<?= $result_seSelfCheck['TIMESLEEPREST'] ?>" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <br><br>  
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                               
                                            </div>
                                        <!-- END COLUNM3    -->
                                            <!-- START COLUNM2 -->
                                            <div class="col-lg-4" >
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #f0c402;">
                                                        <label><font style="font-size: 16px;">ตรวจสอบชั่วโมงการนอนหลับ(การนอนปกติ) 6 ชั่วโมงขึ้นไป</font></label>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">
                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                            <div class = "row">
                                                                <div class="">
                                                                    <form class="form-inline">
                                                                        <div class="form-group">
                                                                            <label >ช่วงเวลาของการนอน(ปกติ)</label><br><br>
                                                                            <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                                            <div class="col-lg-6">
                                                                            <?php
                                                                                if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                                ?>
                                                                                    <label ><u>เวลาเริ่มนอน</u></label><br>
                                                                                    <input type="datetime-local"  style="height:40px; width:240px" id="daysleep_normalstart" name="daysleep_normalstart" value="<?= $result_seSelfCheck['SLEEPNORMALSTART'] ?>" min="" max="" onchange ="timesleepselfnormalcheck('MB');" autocomplete="off">
                                                                                <?php
                                                                                }else { //สำหรับ PC DESKTOP

                                                                                    $DATESLEEPNORMALSTART1 = str_replace("T"," ",$result_seSelfCheck['SLEEPNORMALSTART']);
                                                                                    $DATESLEEPNORMALSTART = str_replace("-","/",$DATESLEEPNORMALSTART1);
                                                                                ?> 
                                                                                    <label ><u>เวลาเริ่มนอน</u></label><br>
                                                                                    <input class="form-control dateen"   style="height:40px; width:240px;"  id="daysleep_normalstart" name="daysleep_normalstart"  value="<?= $DATESLEEPNORMALSTART ?>" min="" max="" autocomplete="off">
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                                
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                            <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาตื่นนอน</u></label><br>
                                                                                <input type="datetime-local" style="height:40px; width:240px" id="daysleep_normalend" name="daysleep_normalend" value="<?= $result_seSelfCheck['SLEEPNORMALEND'] ?>" min="" max="" onchange ="timesleepselfnormalcheck('MB');" autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP
                                                                                // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                $DATESLEEPNORMALEND1 = str_replace("T"," ",$result_seSelfCheck['SLEEPNORMALEND']);
                                                                                $DATESLEEPNORMALEND = str_replace("-","/",$DATESLEEPNORMALEND1);
                                                                            ?> 
                                                                                <label ><u>เวลาตื่นนอน</u></label><br>
                                                                                <input class="form-control dateen" style="height:40px; width:240px" id="daysleep_normalend" name="daysleep_normalend" value="<?= $DATESLEEPNORMALEND ?>" min="" max="" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                        <br><br><br>
                                                                        <!-- ปุ่มยืนยันเวลานอนปกติ 6 ชั่วโมง -->
                                                                        <?php
                                                                            if ($checkClient == 'MB') {   
                                                                            ?>
                                                                            
                                                                            <?php
                                                                            }else{ /// ปุ่มยืนยันมีเฉพาะ PC DESKTOP
                                                                            ?>
                                                                            <div class="col-lg-6">
                                                                                <button type="button" style="height:40px; width:240px" class="btn btn-primary btn-lg" onclick ="timesleepselfnormalcheck('DT');" >กดยืนยันเวลานอนปกติ</button>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <p style="color:red">*กดปุ่มยืนยันทุกครั้งที่มีการแก้ไขเวลา เพื่อคำนวณชั่วโมงการนอน(ปกติ)</p>
                                                                            </div>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            <br><br><br>
                                                                        <div class="form-group">
                                                                            
                                                                            <label>ระยะเวลาที่นอน(ปกติ) 6 ชั่วโมงขึ้นไป</label>
                                                                                <?php
                                                                                 // ถ้าเป็นฝั่งเกตเวย์ จะไม่แสดงเวลาที่คำนวณ 
                                                                                 $empchkgw = substr($_GET['employeecode'],0,2);
                                                                                 if ($empchkgw == '04'  || $empchkgw == '09' || $empchkgw == '10') {
                                                                                ?>
                                                                                    <?php
                                                                                    if ($TIMESLEEPNORMAL == '0') {
                                                                                    ?>  
                                                                                        <input readonly style="background-color: #FFFFF;" type="text" class="form-control" id="timeshow_gw" name="timeshow_gw" value= "ยังไม่ได้ลงข้อมูลและกดยืนยันเวลานอนปกติ" autocomplete="off">
                                                                                        <input readonly style="background-color: #FFFFF;display: none;" type="text" class="form-control" id="timesleep_normal" name="timesleep_normal" value= "" autocomplete="off">    
                                                                                    <?php
                                                                                    }else if ($TIMESLEEPNORMAL >= '6') {
                                                                                    ?>  
                                                                                        <?php
                                                                                        if ($_GET['type'] == 'insert') {
                                                                                        ?>  
                                                                                            <input readonly style="background-color: #FFFFF;" type="text" class="form-control" id="timeshow_gw" name="timeshow_gw" value= "กดยืนยันเวลานอนปกติเรียบร้อยแล้ว" autocomplete="off">
                                                                                            <input readonly style="background-color: #FFFFF;display: none;" type="text" class="form-control" id="timesleep_normal" name="timesleep_normal" value= "<?= $result_seSelfCheck['TIMESLEEPNORMAL'] ?>" autocomplete="off">
                                                                                        <?php
                                                                                        }else{
                                                                                        ?>
                                                                                            <input readonly style="background-color: #94FA67;" type="text" class="form-control" id="timesleep_normal" name="timesleep_normal" value= "<?= $result_seSelfCheck['TIMESLEEPNORMAL'] ?>" autocomplete="off">
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                    <!-- <input readonly style="background-color: #94FA67;" type="text" class="form-control" id="timesleep_normal" name="timesleep_normal" value= "<?= $result_seSelfCheck['TIMESLEEPNORMAL'] ?>" autocomplete="off"> -->
                                                                                    <?php
                                                                                    }else {
                                                                                    ?>
                                                                                        <?php
                                                                                        if ($_GET['type'] == 'insert') {
                                                                                        ?>
                                                                                            <input readonly style="background-color: #FFFFF;" type="text" class="form-control" id="timeshow_gw" name="timeshow_gw" value= "กดยืนยันเวลานอนปกติเรียบร้อยแล้ว" autocomplete="off">
                                                                                            <input readonly style="background-color: #FFFFF;display: none;" type="text" class="form-control" id="timesleep_normal" name="timesleep_normal" value= "<?= $result_seSelfCheck['TIMESLEEPNORMAL'] ?>" autocomplete="off">
                                                                                        <?php
                                                                                        }else{
                                                                                        ?>
                                                                                            <input readonly style="background-color: #FA6767;" type="text" class="form-control" id="timesleep_normal" name="timesleep_normal" value= "<?= $result_seSelfCheck['TIMESLEEPNORMAL'] ?>" autocomplete="off">
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                    <!-- <input readonly style="background-color: #FA6767;" type="text" class="form-control" id="timesleep_normal" name="timesleep_normal" value= "<?= $result_seSelfCheck['TIMESLEEPNORMAL'] ?>" autocomplete="off"> -->
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                <?php
                                                                                // else AMT
                                                                                 }else{
                                                                                ?>
                                                                                    <!-- แสดงระยะเวลา ฝั่ง อมตะ จะยังแสดงเวลาที่คำนวณ และ สี -->
                                                                                    <?php
                                                                                    if ($TIMESLEEPNORMAL == '0') {
                                                                                    ?>
                                                                                        <input readonly  type="text" class="form-control" id="timesleep_normal" name="timesleep_normal" value= "" autocomplete="off">    
                                                                                    <?php
                                                                                    }else if ($TIMESLEEPNORMAL >= '6') {
                                                                                    ?>  
                                                                                        <?php
                                                                                        if ($_GET['type'] == 'insert') {
                                                                                        ?>
                                                                                            <input readonly style="background-color: #FFFFF;" type="text" class="form-control" id="timesleep_normal" name="timesleep_normal" value= "<?= $result_seSelfCheck['TIMESLEEPNORMAL'] ?>" autocomplete="off">
                                                                                        <?php
                                                                                        }else{
                                                                                        ?>
                                                                                            <input readonly style="background-color: #94FA67;" type="text" class="form-control" id="timesleep_normal" name="timesleep_normal" value= "<?= $result_seSelfCheck['TIMESLEEPNORMAL'] ?>" autocomplete="off">
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                    <!-- <input readonly style="background-color: #94FA67;" type="text" class="form-control" id="timesleep_normal" name="timesleep_normal" value= "<?= $result_seSelfCheck['TIMESLEEPNORMAL'] ?>" autocomplete="off"> -->
                                                                                    <?php
                                                                                    }else {
                                                                                    ?>
                                                                                        <?php
                                                                                        if ($_GET['type'] == 'insert') {
                                                                                        ?>
                                                                                            <input readonly style="background-color: #FFFFF;" type="text" class="form-control" id="timesleep_normal" name="timesleep_normal" value= "<?= $result_seSelfCheck['TIMESLEEPNORMAL'] ?>" autocomplete="off">
                                                                                        <?php
                                                                                        }else{
                                                                                        ?>
                                                                                            <input readonly style="background-color: #FA6767;" type="text" class="form-control" id="timesleep_normal" name="timesleep_normal" value= "<?= $result_seSelfCheck['TIMESLEEPNORMAL'] ?>" autocomplete="off">
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                    <!-- <input readonly style="background-color: #FA6767;" type="text" class="form-control" id="timesleep_normal" name="timesleep_normal" value= "<?= $result_seSelfCheck['TIMESLEEPNORMAL'] ?>" autocomplete="off"> -->
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                <?php
                                                                                 }
                                                                                ?>
                                                                                    
                                                                            
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class = "row">
                                                                <div class="">
                                                                <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 100%;text-align: center;" >ประเมิน(การนอนปกติ)</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="width: 100%;text-align: center;">
                                                                            <selfnormalsleepyes>
                                                                                <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfnormalsleepyes" <?= $sleepnormalyes ?> name="selfnormalsleep" value="selfnormalsleepyes">
                                                                                <label for="selfnormalsleepyes">หลับสนิท</label> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                            </selfnormalsleepyes>    
                                                                            <selfnormalsleepno>
                                                                                <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfnormalsleepno"  <?= $sleepnormalno ?> name="selfnormalsleep" value="selfnormalsleepno">
                                                                                <label for="selfnormalsleepno">หลับไม่สนิท</label>
                                                                            </selfnormalsleepno>    
                                                                            </td>
                                                                        </tr>
                                                                        
                                                                    </tbody>
                                                                    </table>
                                                                </div>  
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            
                                            </div>
                                         <!-- END COLUNM2 -->   
                                                                                
                                        <!-- START COLUNM3 -->
                                        <div class="col-lg-4" >
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #f0c402;">
                                                        <label><font style="font-size: 16px">การนอนเพิ่ม ของการรับงานวันแรกของกะกลางคืนในทุกๆสัปดาห์</font></label>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">
                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                            <div class = "row">
                                                                <div class="">
                                                                        <div class="form-group">
                                                                            <label >ช่วงเวลาของการนอน(กะกลางคืน)</label><br><br>
                                                                            <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                                           
                                                                            <div class="col-lg-6">
                                                                                <?php
                                                                                if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                                ?>
                                                                                    <label ><u>เวลาเริ่มพักผ่อน(กะกลางคืน)</u></label><br>
                                                                                    <input type="datetime-local" style="height:40px; width:240px;" id="daysleep_extrastart" name="daysleep_extrastart" value="<?= $result_seSelfCheck['SLEEPEXTRASTART'] ?>" min="" max="" onchange ="timesleepselfextracheck('MB');" autocomplete="off">
                                                                                <?php
                                                                                }else { //สำหรับ PC DESKTOP

                                                                                    $DATESLEEPEXTRASTART1 = str_replace("T"," ",$result_seSelfCheck['SLEEPEXTRASTART']);
                                                                                    $DATESLEEPEXTRASTART = str_replace("-","/",$DATESLEEPEXTRASTART1);
                                                                                ?> 
                                                                                    <label ><u>เวลาเริ่มพักผ่อน(กะกลางคืน)</u></label><br>
                                                                                    <input class="form-control dateen" style="height:40px; width:240px;" id="daysleep_extrastart" name="daysleep_extrastart" value="<?= $DATESLEEPEXTRASTART ?>" min="" max="" autocomplete="off">
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                                
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                            <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                                ?>
                                                                                    <label ><u>เวลาตื่นพักผ่อน(กะกลางคืน)</u></label><br>
                                                                                    <input type="datetime-local" style="height:40px; width:240px" id="daysleep_extraend" name="daysleep_extraend" value="<?= $result_seSelfCheck['SLEEPEXTRAEND'] ?>" min="" max="" onchange ="timesleepselfextracheck('MB');" autocomplete="off">
                                                                                <?php
                                                                                }else { //สำหรับ PC DESKTOP
                                                                                    // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                    $DATESLEEPEXTRAEND1 = str_replace("T"," ",$result_seSelfCheck['SLEEPEXTRAEND']);
                                                                                    $DATESLEEPEXTRAEND = str_replace("-","/",$DATESLEEPEXTRAEND1);
                                                                                ?> 
                                                                                    <label ><u>เวลาตื่นพักผ่อน(กะกลางคืน)</u></label><br>
                                                                                    <input class="form-control dateen" style="height:40px; width:240px" id="daysleep_extraend" name="daysleep_extraend" value="<?= $DATESLEEPEXTRAEND ?>" min="" max="" autocomplete="off">
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                                
                                                                            </div>
                                                                            </div>
                                                                            <br><br><br>
                                                                                <!-- ปุ่มยืนยันเวลานอนเพิ่ม  -->
                                                                                <?php
                                                                                if ($checkClient == 'MB') {   
                                                                                ?>
                                                                                
                                                                                <?php
                                                                                }else{ /// ปุ่มยืนยันมีเฉพาะ PC DESKTOP
                                                                                ?>
                                                                                <div class="col-lg-6">
                                                                                    <button type="button" style="height:40px; width:240px" class="btn btn-primary btn-lg" onclick ="timesleepselfextracheck('DT');"  >กดยืนยันเวลานอนเพิ่ม</button>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <p style="color:red">*กดปุ่มยืนยันทุกครั้งที่มีการแก้ไขเวลา เพื่อคำนวณชั่วโมงการนอน(นอนเพิ่ม)</p>
                                                                                </div>
                                                                                <?php
                                                                                }
                                                                                ?> 
                                                                            <br><br><br>
                                                                        <div class="form-group">
                                                                            <label >ระยะเวลาที่นอน(กะกลางคืน) 4 ชั่วโมงครึ่ง ขึ้นไป</label>
                                                                            <?php
                                                                            //echo $result_seSelfCheck['TIMESLEEPEXTRA']; 
                                                                            if ($TIMESLEEPEXTRAHOURCHK == '0') {
                                                                                // echo '1';
                                                                            ?>
                                                                                <input readonly  type="text" class="form-control" id="timesleep_extra" name="timesleep_extra" value= "" autocomplete="off">
                                                                            <?php
                                                                            }else if ($TIMESLEEPEXTRAHOURCHK == 'HG4') { //เช็คชั่วโมง ต้องมากกว่า 4 ชั่วโมง กรณีเท่ากับ 4 
                                                                                // echo '2';
                                                                                if ($TIMESLEEPEXTRAMINCHK == 'MG3') { //เช็คชนาที ต้องมากกว่า 30 นาที กรณีเท่ากับ 4เช็ค นาทีต่อ
                                                                               ?>
                                                                                <input readonly style="background-color: #94FA67;" type="text" class="form-control" id="timesleep_extra" name="timesleep_extra" value= "<?= $result_seSelfCheck['TIMESLEEPEXTRA'] ?>" autocomplete="off">
                                                                               <?php
                                                                                }else {
                                                                                ?>
                                                                                <input readonly style="background-color: #FA6767;" type="text" class="form-control" id="timesleep_extra" name="timesleep_extra" value= "<?= $result_seSelfCheck['TIMESLEEPEXTRA'] ?>" autocomplete="off">
                                                                                <?php
                                                                                }
                                                                            ?>
                                                                                
                                                                            <?php
                                                                            }else if ($TIMESLEEPEXTRAHOURCHK == 'HGG4') { //เช็คชั่วโมง ต้องมากกว่า 4 ชั่วโมง
                                                                                // echo '3';
                                                                            ?>
                                                                                <input readonly style="background-color: #94FA67;" type="text" class="form-control" id="timesleep_extra" name="timesleep_extra" value= "<?= $result_seSelfCheck['TIMESLEEPEXTRA'] ?>" autocomplete="off">
                                                                               
                                                                            <?php
                                                                            }else {
                                                                                // echo '4';
                                                                            ?>
                                                                                <input readonly style="background-color: #FA6767;" type="text" class="form-control" id="timesleep_extra" name="timesleep_extra" value= "<?= $result_seSelfCheck['TIMESLEEPEXTRA'] ?>" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class = "row">
                                                                <div class="">
                                                                <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 100%;text-align: center;" >ประเมิน(การนอนเพิ่ม) <button id="clear" style= "background-color:#FA6767">ล้างข้อมูลประเมิน(การนอนเพิ่ม)</button></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="width: 100%;text-align: center;"> 
                                                                            <selfextrasleepyes>
                                                                                <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfextrasleepyes" <?= $sleepextrayes ?> name="selfextrasleep" value="selfextrasleepyes">
                                                                                <label for="selfextrasleepyes">หลับสนิท</label> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                            </selfextrasleepyes>   
                                                                            <selfextrasleepno>
                                                                                <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfextrasleepno" <?= $sleepextrano ?> name="selfextrasleep" value="selfextrasleepno">
                                                                                <label for="selfextrasleepno">หลับไม่สนิท</label>
                                                                            </selfextrasleepno>    
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                    </table>
                                                                </div>  
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                       
                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                        <!-- END COLUNM3 -->
                                        <!-- START COLUNM4 -->
                                        <div class="col-lg-4" >
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color:#f0c402;">
                                                        <label><font style="font-size: 16px">อาการป่วย</font></label>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">
                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                            <div class = "row">
                                                                <div class="">
                                                                        <div class="form-group">
                                                                            <label>ชื่อโรค</label>
                                                                            <input type="text" class="form-control" id="disease" name="disease" value= "<?= $diseaseinsertchk?>" autocomplete="off">
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <div class="">
                                                                <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 100%;text-align: center;" >พบหมอ </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="width: 100%;text-align: center;">
                                                                            <selfdoctoryes>
                                                                                <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfdoctoryes" <?= $seedoctoryes ?> name="selfdoctor" value="selfdoctoryes">
                                                                                <label for="selfdoctoryes">พบ</label> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                            </selfdoctoryes>
                                                                            <selfdoctorno>
                                                                                <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfdoctorno" <?= $seedoctorno ?> name="selfdoctor" value="selfdoctorno">
                                                                                <label for="selfdoctorno">ไม่พบ</label>
                                                                            </selfdoctorno>   
                                                                            </td>
                                                                        </tr>
                                                                        
                                                                    </tbody>
                                                                    </table>
                                                                </div>  
                                                            </div>
                                                            <div class = "row">
                                                                <div class="">
                                                                        <div class="form-group">
                                                                            <label >ชื่อยา</label>
                                                                            <input type="text" class="form-control" id="drug_name" name="drug_name" value= "<?= $drugnameinsertchk ?>" autocomplete="off">
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <div class="">
                                                                        <div class="form-group">
                                                                            <label >ทานยาเมื่อไหร่</label><br>
                                                                            <!-- <input type="text" class="form-control datetimeen" id="drug_time" name="drug_time" value= "" autocomplete="off"> -->
                                                                            <input type="datetime-local" style="height:40px; width:240px" id="drug_time" name="drug_time" value="<?= $result_seSelfCheck['DRUGTIME']?>" min="" max="">
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                        <!--END COLUNM4  -->
                                        <!-- START COLUNM5 -->
                                        <div class="col-lg-4" >
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #f0c402;">
                                                        <label><font style="font-size: 16px">เรื่องกังวลใจ / การใช้เวลาช่วงพักผ่อน</font></label>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">
                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                            <div class = "row">
                                                                <div class="">
                                                                    <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                        <thead>
                                                                            <br>
                                                                            <tr>
                                                                                <th style="width: 100%;text-align: center;" >เรื่องกังวลใจ</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="width: 100%;text-align: center;"> 
                                                                                <selfworryyes>
                                                                                    <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfworryyes" <?=$worryyes ?> name="selfworry" value="selfworryyes">
                                                                                    <label for="selfworryyes">มี</label> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                </selfworryyes>
                                                                                <selfworryno>
                                                                                    <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfworryno" <?=$worryno ?> name="selfworry" value="selfworryno">
                                                                                    <label for="selfworryno">ไม่มี</label>
                                                                                </selfworryno>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>  
                                                            </div>
                                                            <div class = "row">
                                                                <div class="">
                                                                    <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                        <thead>
                                                                            <br>
                                                                            <tr>
                                                                                <th style="width: 100%;text-align: center;" >การใช้เวลาช่วงพักผ่อน</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="width: 100%;text-align: center;">
                                                                                <selfhouseholdyes>
                                                                                    <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfhouseholdyes" <?=$householdyes ?> name="selfhousehold" value="selfhouseholdyes">
                                                                                    <label for="selfhouseholdyes">บ้าน</label> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                </selfhouseholdyes> 
                                                                                <selfhouseholdno>
                                                                                    <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfhouseholdno" <?=$householdno ?> name="selfhousehold" value="selfhouseholdno">
                                                                                    <label for="selfhouseholdno">นอกบ้าน</label>
                                                                                </selfhouseholdno>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>  
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <br>
                                                            
                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                        <!--END COLUNM5  --> 
                                        <!-- START COLUNM6 -->
                                            <div class="col-lg-4" >
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color:#f0c402;">
                                                        <label><font style="font-size: 16px">อุณภูมิ(°C) / ความดัน (ข้อมูลการตรวจร่างกายโดยเจ้าหน้าที่เท็งโกะ)</font></label>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">
                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                            <div class = "row">
                                                                <div class="">
                                                                        <div class="form-group" >
                                                                            <label style="background-color:#FA6767;"><b>อุณภูมิต่ำกว่า <?=$result_seTenkoSTD['TEMP']?> °C / ความดับค่าบน <?=$result_seTenkoSTD['MINSYS']?>-<?=$result_seTenkoSTD['MAXSYS']?> / ความดันค่าล่าง <?=$result_seTenkoSTD['MINDIA']?>-<?=$result_seTenkoSTD['MAXDIA']?> </b></label>
                                                                            <label style="background-color:#FA6767;"><b>ชีพจร <?=$result_seTenkoSTD['MINPULSE']?>-<?=$result_seTenkoSTD['MAXPULSE']?> / ออกซิเจนในเลือด <?=$result_seTenkoSTD['OXYGEN']?> ขึ้นไป </b></label>
                                                                            
                                                                        </div>
                                                                </div>
                                                            </div>                
                                                            <div class = "row">
                                                                <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label >อุณภูมิ</label>
                                                                            <input type="text" class="form-control" id="temperature" name="temperature" value= "<?= $result_seTenkoData['TENKOTEMPERATUREDATA'] ?>" autocomplete="off" disabled>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label >ความดันบนครั้งที่1</label>
                                                                            <input type="text" class="form-control" id="sys_value1" name="sys_value1" value= "<?= $result_seTenkoData['TENKOPRESSUREDATA_90160'] ?>" autocomplete="off" disabled>
                                                                        </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label >ความดันบนครั้งที่2</label>
                                                                            <input type="text" class="form-control" id="sys_value2" name="sys_value2" value= "<?= $result_seTenkoData['TENKOPRESSUREDATA_90160_2'] ?>" autocomplete="off" disabled>
                                                                        </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label >ความดันบนครั้งที่3</label>
                                                                            <input type="text" class="form-control" id="sys_value3" name="sys_value3" value= "<?= $result_seTenkoData['TENKOPRESSUREDATA_90160_3'] ?>" autocomplete="off" disabled>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label >ความดันล่างครั้งที่1</label>
                                                                            <input type="text" class="form-control" id="dia_value1" name="dia_value1" value= "<?= $result_seTenkoData['TENKOPRESSUREDATA_60100'] ?>" autocomplete="off" disabled>
                                                                        </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label >ความดันล่างครั้งที่2</label>
                                                                            <input type="text" class="form-control" id="dia_value2" name="dia_value2" value= "<?= $result_seTenkoData['TENKOPRESSUREDATA_60100_2'] ?>" autocomplete="off" disabled>
                                                                        </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label >ความดันล่างครั้งที่3</label>
                                                                            <input type="text" class="form-control" id="dia_value3" name="dia_value3" value= "<?= $result_seTenkoData['TENKOPRESSUREDATA_60100_3'] ?>" autocomplete="off" disabled>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label >ชีพจรครั้งที่1</label>
                                                                            <input type="text" class="form-control" id="pulse_value1" name="pulse_value1" value= "<?= $result_seTenkoData['TENKOPRESSUREDATA_60110'] ?>" autocomplete="off" disabled>
                                                                        </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label >ชีพจรครั้งที่2</label>
                                                                            <input type="text" class="form-control" id="pulse_value2" name="pulse_value2" value= "<?= $result_seTenkoData['TENKOPRESSUREDATA_60110_2'] ?>" autocomplete="off" disabled>
                                                                        </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label >ชีพจรครั้งที่3</label>
                                                                            <input type="text" class="form-control" id="pulse_value3" name="pulse_value3" value= "<?= $result_seTenkoData['TENKOPRESSUREDATA_60110_3'] ?>" autocomplete="off" disabled>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label >ออกซิเจนในเลือด</label>
                                                                            <input type="text" class="form-control" id="oxygen_value" name="oxygen_value" value= "<?= $result_seTenkoData['TENKOOXYGENDATA'] ?>" autocomplete="off" disabled>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class = "row">
                                                            <label ></label>
                                                        </div>
                                                        <div class = "row">
                                                            <label ></label>
                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                                 
                                            </div>
                                        <!--END COLUNM6  -->
                                        <!-- START COLUNM7 -->
                                            <div class="col-lg-4" >
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #f0c402;">
                                                        <label><font style="font-size: 16px">ปัญหาสายตา/แว่นสายตา</font></label>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">
                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                            <div class = "row">
                                                                <div class="">
                                                                    <?php
                                                                    // echo $result_seComEmpChk['COMCHK'];
                                                                    // echo $areashow;
                                                                    // if (condition) {
                                                                    //     # code...
                                                                    // }
                                                                    if ($areashow == '(GW)') {
                                                                    ?>
                                                                        <?php
                                                                        if ($result_seComEmpChk['COMCHK'] == 'RCC' || $result_seComEmpChk['COMCHK'] == 'RATC' || $result_seComEmpChk['COMCHK'] == 'RIT') {
                                                                        ?>
                                                                            <div class="form-group" >
                                                                                <label style="">การประเมินปัญหาสายตา TLEP: <u><?=$eyecheck  == '1' ? 'มีปัญหาสายตา' : 'ไม่มีปัญหาสายตา' ?></u></label>
                                                                                <label style="">การประเมินสวมแว่นสายตา TLEP: <u><?=$eyecheck  == '1' ? 'ต้องสวมแว่นสายตา' : 'ไม่ต้องสวมแว่นสายตา' ?></u></label>
                                                                            </div>
                                                                        <?php
                                                                        }else {
                                                                        ?>
                                                                            <!-- GW สายงาน RRC จะประเมินจากข้อมูลตรวจสุขภาพประจำปี -->
                                                                            <div class="form-group" >
                                                                                <label style=""><u>สายงาน RRC ประเมินจากการตรวจสุขภาพประจำปี</u></label>
                                                                                <label style="">การประเมินปัญหาสายตา RRC: <u><?=$eyecheck  == '1' ? 'มีปัญหาสายตา' : 'ไม่มีปัญหาสายตา' ?></u></label>
                                                                                <label style="">การประเมินสวมแว่นสายตา RRC: <u><?=$eyecheck  == '1' ? 'ต้องสวมแว่นสายตา' : 'ไม่ต้องสวมแว่นสายตา' ?></u></label>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                        
                                                                        ?>
                                                                    <?php
                                                                    }else{
                                                                    ?>  
                                                                        <!-- AMT ทุกสายงาน จะไม่แสดงการประเมินค่าสายตา แต่จะแสดงตามการตอบของพนักงาน -->
                                                                        <!-- ถ้าตอบมี จะเป็นสีแดง และ แสดงในหน้า Tenko ว่า NG -->
                                                                        <!-- ถ้าตอบไม่มีจะเป็นสีเขียว และ แสดงในหน้า Tenko ว่า OK -->
                                                                        
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                            </div> 
                                                            <div class = "row">
                                                                <div class="">
                                                                    <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                        <thead>
                                                                            <br>
                                                                            <tr>
                                                                                <th style="width: 100%;text-align: center;" >มีปัญหาสายตา</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            if ($eyecheck == '1') {
                                                                            ?>
                                                                                <!-- eyecheck == '1' คือมีปัญหาสายตาจาก TLEP และ จาก ข้อมูลสุขภาพประจำปี -->
                                                                                <tr>
                                                                                    <td style="width: 100%;text-align: center;"> 
                                                                                    <selfeyeproblemyes_eyecheck>
                                                                                        <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfeyeproblemyes" <?=$eyeproblemyes?> name="selfeyeproblem" value="selfeyeproblemyes">
                                                                                        <label for="selfeyeproblemyes">มี</label> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    </selfeyeproblemyes_eyecheck>
                                                                                    <selfeyeproblemno_eyecheck>
                                                                                        <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfeyeproblemno" <?=$eyeproblemno?> name="selfeyeproblem" value="selfeyeproblemno">
                                                                                        <label for="selfeyeproblemno">ไม่มี</label>
                                                                                    </selfeyeproblemno_eyecheck>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php
                                                                            }else {
                                                                            ?>
                                                                                <tr>
                                                                                    <td style="width: 100%;text-align: center;"> 
                                                                                    <selfeyeproblemyes>
                                                                                        <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfeyeproblemyes" <?=$eyeproblemyes?> name="selfeyeproblem" value="selfeyeproblemyes">
                                                                                        <label for="selfeyeproblemyes">มี</label> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    </selfeyeproblemyes>
                                                                                    <selfeyeproblemno>
                                                                                        <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfeyeproblemno" <?=$eyeproblemno?> name="selfeyeproblem" value="selfeyeproblemno">
                                                                                        <label for="selfeyeproblemno">ไม่มี</label>
                                                                                    </selfeyeproblemno>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </tbody>
                                                                    </table>
                                                                </div>  
                                                            </div>
                                                            <div class = "row">
                                                                <div class="">
                                                                    <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                        <thead>
                                                                            <br>
                                                                            <tr>
                                                                                <th style="width: 100%;text-align: center;" >ส่วมใส่แว่นสายตา</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            if ($eyecheck == '1') {
                                                                            ?>
                                                                                <tr>
                                                                                    <td style="width: 100%;text-align: center;">
                                                                                    <selfeyeglassesyes_eyecheck>
                                                                                        <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfeyeglassesyes" <?=$eyeglassesyes?> name="selfeyeglasses" value="selfeyeglassesyes">
                                                                                        <label for="selfeyeglassesyes">สวม</label> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    </selfeyeglassesyes_eyecheck> 
                                                                                    <selfeyeglassesno_eyecheck>
                                                                                        <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfeyeglassesno" <?=$eyeglassesno?>  name="selfeyeglasses" value="selfeyeglassesno">
                                                                                        <label for="selfeyeglassesno">ไม่สวม</label>
                                                                                    </selfeyeglassesno_eyecheck>
                                                                                    </td>
                                                                                </tr>

                                                                            <?php
                                                                            }else{
                                                                            ?>
                                                                                <tr>
                                                                                    <td style="width: 100%;text-align: center;">
                                                                                    <selfeyeglassesyes>
                                                                                        <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfeyeglassesyes" <?=$eyeglassesyes?> name="selfeyeglasses" value="selfeyeglassesyes">
                                                                                        <label for="selfeyeglassesyes">สวม</label> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    </selfeyeglassesyes> 
                                                                                    <selfeyeglassesno>
                                                                                        <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfeyeglassesno" <?=$eyeglassesno?>  name="selfeyeglasses" value="selfeyeglassesno">
                                                                                        <label for="selfeyeglassesno">ไม่สวม</label>
                                                                                    </selfeyeglassesno>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </tbody>
                                                                    </table>
                                                                </div>  
                                                            </div>
                                                            <div class = "row" style="">
                                                                <div class="">
                                                                    <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                        <thead>
                                                                            <br>
                                                                            <tr>
                                                                                <th style="width: 100%;text-align: center;" >สวมใส่เครื่องช่วยฟัง</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="width: 100%;text-align: center;">
                                                                                <selfcarryhearingaidyes>
                                                                                    <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfcarryhearingaidyes" <?=$carryhearingaidyes?> name="selfcarryhearingaid" value="selfcarryhearingaidyes">
                                                                                    <label for="selfcarryhearingaidyes">สวม</label> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                </selfcarryhearingaidyes> 
                                                                                <selfcarryhearingaidno>
                                                                                    <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfcarryhearingaidno" <?=$carryhearingaidno?>  name="selfcarryhearingaid" value="selfcarryhearingaidno">
                                                                                    <label for="selfcarryhearingaidno">ไม่สวม</label>
                                                                                </selfcarryhearingaidno>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>  
                                                            </div>
                                                            <div class = "row" style="display: none">
                                                                <div class="">
                                                                    <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                        <thead>
                                                                            <br>
                                                                            <tr>
                                                                                <th style="width: 100%;text-align: center;" >พกแว่นสายตามาปฎิบัติงาน</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="width: 100%;text-align: center;">
                                                                                <selfcarryeyeglassesyes>
                                                                                    <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfcarryeyeglassesyes" <?=$carryeyeglassesyes?> name="selfcarryeyeglasses" value="selfcarryeyeglassesyes">
                                                                                    <label for="selfcarryeyeglassesyes">พกแว่นสายตา</label> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                </selfcarryeyeglassesyes> 
                                                                                <selfcarryeyeglassesno>
                                                                                    <input style="height:30px; width:30px; vertical-align: middle;" type="radio" id="selfcarryeyeglassesno" <?=$carryeyeglassesno?>  name="selfcarryeyeglasses" value="selfcarryeyeglassesno">
                                                                                    <label for="selfcarryeyeglassesno">ไม่พกแว่นสายตา</label>
                                                                                </selfcarryeyeglassesno>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>  
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                    <!-- <div class = "row">
                                                        <label ></label>
                                                    </div> -->
                                                    <!-- <div class = "row">
                                                        <label ></label>
                                                    </div> -->
                                                    <!-- <div class = "row">
                                                        <label ></label>
                                                    </div> -->
                                                    <!-- <div class = "row">
                                                        <label ></label>
                                                    </div> -->
                                                    <!-- <div class = "row">
                                                        <label ></label>
                                                    </div> -->
                                                    <!-- <div class = "row">
                                                        <label ></label>
                                                    </div>
                                                    <div class = "row">
                                                        <label ></label>
                                                    </div> -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                        <!--END COLUNM7  -->
                                        <!-- START COLUNM8 -->
                                        <div class="col-lg-4" >
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #f0c402;">
                                                        <label><font style="font-size: 16px">แอลกอฮอล์</font></label>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">
                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                            <div class = "row">
                                                                <div class="">
                                                                        <div class="form-group">
                                                                            <label >ประเภท</label>
                                                                            <input type="text" class="form-control" id="alcohol_type" name="alcohol_type" value= "<?= $alcoholtypeinsertchk ?>" autocomplete="off">
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <div class="">
                                                                        <div class="form-group">
                                                                            <label >เวลาเลิก</label><br>
                                                                            <!-- <input type="text" class="form-control datetimeen" id="alcohol_time" name="alcohol_time" value= "" autocomplete="off"> -->
                                                                            <input type="datetime-local" style="height:35px; width:240px" id="alcohol_time" name="alcohol_time" value="<?= $result_seSelfCheck['ALCOHOLTIME'] ?>" min="" max="">    
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class = "row">
                                                                <div class="">
                                                                        <div class="form-group">
                                                                            <label >ปริมาณ</label>
                                                                            <input type="text" class="form-control" id="alcohol_volume" name="alcohol_volume" value= "<?= $alcoholvolumeinsertchk ?>" autocomplete="off">
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div> 
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div> 
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div> 
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div> 
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                        <!--END COLUNM8  -->
                                        
                                        
                                        <?php 
                                        if ($_GET['type'] == 'check' || $_GET['type'] == 'officercheck' ) {
                                        ?>
                                            <!-- START COLUNM8 -->
                                            <!-- SAVE  DATEWORKING ,DATEPRESENT ลงใน DRIVERSELFCHECK-->
                                            <!-- DATEWORKING ,DATEPRESENT มาจากการกดยืนยันและบันทึกข้อมูล ในหน้าการตรวจสอบของเจ้าหน้าที่ -->
                                            <div class="col-lg-4" >
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #f0c402;">
                                                        <label><font style="font-size: 16px">บันทึกและยืนยันข้อมูล(เจ้าหน้าที่)</font></label>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">
                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                            <div class = "row">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label >ผู้ยืนยันข้อมูล</label>

                                                                        (<?php echo $_GET['officername']?>)
                                                                        <input type="hidden" style="height:35px; width:200px" class="form-control" id="txt_officerconfirmhidden" name="txt_officerconfirmhidden" value= "<?= $_GET['officername'] ?>" autocomplete="off" disabled>
                                                                        <input type="text"   style="height:35px; width:200px" class="form-control" id="txt_officerconfirm" name="txt_officerconfirm" value= "<?=$result_seSelfCheck['CONFIRMEDBY']?>" autocomplete="off" disabled>                    
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label >ยืนยันข้อมูลล่าสุด</label>
                                                                        <input type="text" style="height:35px; width:200px" class="form-control" id="txt_datetimeconfirm" name="txt_datetimeconfirm" value= "<?=$result_seSelfCheck['CFDATE']?>:<?=$result_seSelfCheck['CFTIME']?>" autocomplete="off" disabled>                    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            if ($_SESSION["ROLENAME"] == "ADMIN") {
                                                            ?>
                                                                <div class = "row">
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label >DATEWORKING (ADMIN)</label>
                                                                            <!-- <input style="height:35px; width:200px" class="form-control dateen_admin" readonly=""  onchange="update_dateselfcheck_byadmin('<?=$_GET['id']?>','DATEWORKING',this.value);"  id="txt_dateworkingconfirm" name="txt_dateworkingconfirm" value="<?= $result_seSelfCheck['DATEWORKING']; ?>" placeholder="DATEWORKING"> -->
                                                                            <input type="text"   style="height:35px; width:200px" class="form-control" id="txt_officerconfirm" name="txt_officerconfirm" value= "<?=$result_seSelfCheck['DATEWORKING']?>" autocomplete="off" disabled>                    
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label >DATEPRESENT (ADMIN)</label>
                                                                            <!-- <input style="height:35px; width:200px" class="form-control dateen_admin" readonly="" onchange="update_dateselfcheck_byadmin('<?=$_GET['id']?>','DATEPRESENT',this.value);"  id="txt_datepresentconfirm" name="txt_datepresentconfirm" value="<?= $result_seSelfCheck['DATEPRESENT']; ?>" placeholder="DATEPRESENT"> -->
                                                                            <input type="text" style="height:35px; width:200px" class="form-control"  id="txt_datepresentconfirm" name="txt_datepresentconfirm" value= "<?=$result_seSelfCheck['DATEPRESENT']?>" autocomplete="off" disabled>                    
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                            }else {
                                                            ?>
                                                                <div class = "row">
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label >DATEWORKING</label>
                                                                            <input type="text"   style="height:35px; width:200px" class="form-control" id="txt_dateworkingconfirm" name="txt_dateworkingconfirm" value= "<?=$result_seSelfCheck['DATEWORKING']?>" autocomplete="off" disabled>                    
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label >DATEPRESENT</label>
                                                                            <input type="text" style="height:35px; width:200px" class="form-control" id="txt_datepresentconfirm" name="txt_datepresentconfirm" value= "<?=$result_seSelfCheck['DATEPRESENT']?>" autocomplete="off" disabled>                    
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                            }
                                                            ?>
                                                            
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <p style="color:red;font-size: 16px;">*กดปุ่มยืนยันบันทึกข้อมูลทุกครั้งก่อนออกจากเมนู</p>
                                                            </div>
                                                            <div class = "row">
                                                                <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <input type="button" style="width: 100%;height:80px;font-size: 25px;" onclick="confirm_selfcheck('save','<?=$checkClient?>','<?=$empchkgw?>');" name="btnSend" id="btnSend" value="ยืนยันและบันทึกข้อมูล" class="btn btn-success">
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <!-- <div class = "row">
                                                                <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <input type="button" style="width: 100%;height:80px;font-size: 25px;" onclick="save_selfcheck('save','<?=$checkClient?>');" name="btnSend" id="btnSend" value="บันทึกข้อมูล" class="btn btn-primary">
                                                                        </div>
                                                                </div>
                                                            </div> -->
                                                            
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                            <!--END COLUNM8  -->
                                                        
                                            <!-- START COLUNM9 -->
                                            <div class="col-lg-4" >
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #6fa8dc;">
                                                    <?php
                                                    // $result_seSelfCheck['CREATEDATE']
                                                     $date = $result_seSelfCheck['CREATEDATESHOW'];
                                                    // $date = '15/02/2023';
                                                    // $date = '2023-02-15'; // sunday
                                                    //  echo date("Y-m-d", strtotime('monday this week', strtotime($date))), "\n";   
                                                    //  echo date("Y-m-d", strtotime('sunday this week', strtotime($date))), "\n";
                                                    
                                                     $datestartchk =  date("d/m/Y", strtotime('monday this week',    strtotime($date)));
                                                    
                                                     $dateendchk   =  date("d/m/Y", strtotime('saturday this week',  strtotime($date)));

                                                     if ($checkArea == '01' || $checkArea == '02' || $checkArea == '07' || $checkArea == '08') {
                                                        $sql_seFixStartTimeChk = "SELECT TOP 1 SELFCHECKID,EMPLOYEECODE,CREATEDATE,SLEEPRESTEND,
                                                            SUBSTRING(SLEEPRESTEND, 12, 16) AS 'TIME',
                                                            CONVERT(CHAR(16), DATEADD(HH,-30, REPLACE(SLEEPRESTEND, 'T', ' ')), 121) AS 'DATETIME_START',
                                                            CONVERT(CHAR(16), DATEADD(HH,+30, REPLACE(SLEEPRESTEND, 'T', ' ')), 121) AS 'DATETIME_END',
                                                            CONVERT(CHAR(5), DATEADD(MINUTE,-30, REPLACE(SLEEPRESTEND, 'T', ' ')), 108) AS 'TIME_START',
                                                            CONVERT(CHAR(5), DATEADD(MINUTE,+30, REPLACE(SLEEPRESTEND, 'T', ' ')), 108) AS 'TIME_END',
                                                            ROW_NUMBER() OVER(ORDER BY SLEEPRESTEND ASC)  AS 'ROWCHK'
                                                            FROM DRIVERSELFCHECK 
                                                            WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
                                                            AND CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'".$datestartchk."',103) AND CONVERT(DATE,'".$dateendchk."',103)
                                                            AND ACTIVESTATUS ='1'
                                                            ORDER BY CREATEDATE ASC";
                                                    }else{
                                                        $sql_seFixStartTimeChk = "SELECT TOP 1 SELFCHECKID,EMPLOYEECODE,CREATEDATE,SLEEPRESTEND,
                                                            SUBSTRING(SLEEPRESTEND, 12, 16) AS 'TIME',
                                                            CONVERT(CHAR(16), DATEADD(HH,-2, REPLACE(SLEEPRESTEND, 'T', ' ')), 121) AS 'DATETIME_START',
                                                            CONVERT(CHAR(16), DATEADD(HH,+2, REPLACE(SLEEPRESTEND, 'T', ' ')), 121) AS 'DATETIME_END',
                                                            CONVERT(CHAR(5), DATEADD(HH,-2, REPLACE(SLEEPRESTEND, 'T', ' ')), 108) AS 'TIME_START',
                                                            CONVERT(CHAR(5), DATEADD(HH,+2, REPLACE(SLEEPRESTEND, 'T', ' ')), 108) AS 'TIME_END',
                                                            ROW_NUMBER() OVER(ORDER BY SLEEPRESTEND ASC)  AS 'ROWCHK'
                                                            FROM DRIVERSELFCHECK 
                                                            WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
                                                            AND CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'".$datestartchk."',103) AND CONVERT(DATE,'".$dateendchk."',103)
                                                            AND ACTIVESTATUS ='1'
                                                            ORDER BY CREATEDATE ASC";
                                                    }

                                                    
                                                    $query_seFixStartTimeChk = sqlsrv_query($conn, $sql_seFixStartTimeChk, $params_seFixStartTimeChk);
                                                    $result_seFixStartTimeChk = sqlsrv_fetch_array($query_seFixStartTimeChk, SQLSRV_FETCH_ASSOC);

                                                        $start =  str_replace(" ","T",$result_seFixStartTimeChk['TIME_START']);
                                                    // echo "<br>";
                                                        $end = str_replace(" ","T",$result_seFixStartTimeChk['TIME_END']);
                                                    // echo "<br>";
                                                    // check คือ check เวลาเริ่มต้นสัปดาห์ว่ามากกว่า เที่ยงคืน (00:00)หรือไม่
                                                    // strtotime ของเวลา 00:00 คือ 1711731600 หรือ substr แล้ว เท่ากับ 00
                                                    // $check = strtotime($result_seFixStartTimeChk['TIME']);
                                                    // echo "<br>";
                                                    $check = substr($result_seFixStartTimeChk['TIME'],0,2);

                                                    // echo $check = strtotime('08:41');
                                                    // echo "<br>";
                                                    // echo   $datestart =  str_replace(" ","T",$result_seFixStartTimeChk['DATETIME_START']);
                                                    // echo "<br>";
                                                    // echo   $dateend = str_replace(" ","T",$result_seFixStartTimeChk['DATETIME_END']);
                                                    // echo "<br>";

                                                    ?>
                                                    <label><font style="font-size: 16px">วันที่เริ่มปฎิบัติงาน (<?=  $datestartchk?> - <?=$dateendchk?>)</font></label>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">
                                                        <div class="alert alert-info"  style="background-color: #eeeeee;border-color:#ddd;color: #333;border: 0px solid transparent;font-size:18px">
                                                            <label><font style="font-size: 16px">Fix Start Time (<?=  $result_seFixStartTimeChk['TIME_START']?> - <?=$result_seFixStartTimeChk['TIME_END']?>)</font></label>
                                                            <div class = "row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <div class="panel-body">
                                                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                                                <div id="datadef">
                                                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>ลำดับ</th>
                                                                                                <th>วันที่ และเวลา</th>
                                                                                                
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                        <?php
                                                                                            $i = 1;

                                                                                            if ($checkArea == '01' || $checkArea == '02' || $checkArea == '07') {
                                                                                                // $query_seTimeWorking = sqlsrv_query($conn, $sql_seTimeWorking, $params_seTimeWorking);
                                                                                                // ใช้เวลาของวันที่ TOP 1 มาเป็นเงื่อนไขเช็ค
                                                                                                // ถ้า check คือเวลาของวันที่แรกที่ทำงานของสัปดาห์ มากกว่า 00:00 จะต้อง +0 hrs ของ DATETIME_START และ +24 hrs ไปใน  DATETIME_END 
                                                                                                // 1711731600 คือเวลาเที่ยงคืน 
                                                                                                if ($check == '00') {
                                                                                                    $sql_seTimeWorking = "SELECT SELFCHECKID,EMPLOYEECODE,CREATEDATE,SLEEPRESTEND,
                                                                                                        SUBSTRING(SLEEPRESTEND, 0, 12) AS 'SLEEPDATECHK',
                                                                                                        SUBSTRING(SLEEPRESTEND, 12, 16) AS 'TIME',
                                                                                                        CONVERT(CHAR(10), DATEADD(MINUTE,-30, SUBSTRING(SLEEPRESTEND, 0, 11))+' '+'".$result_seFixStartTimeChk['TIME']."', 121) AS 'DATETIME_START',
                                                                                                        CONVERT(CHAR(10), DATEADD(MINUTE,+30, SUBSTRING(SLEEPRESTEND, 0, 11))+' '+'".$result_seFixStartTimeChk['TIME']."', 121) AS 'DATETIME_END'
                                                                                                        FROM DRIVERSELFCHECK 
                                                                                                        WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
                                                                                                        AND CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'".$datestartchk."',103) AND CONVERT(DATE,'".$dateendchk."',103)
                                                                                                        AND ACTIVESTATUS ='1'
                                                                                                        ORDER BY CREATEDATE ASC";
                                                                                                }else {
                                                                                                    $sql_seTimeWorking = "SELECT SELFCHECKID,EMPLOYEECODE,CREATEDATE,SLEEPRESTEND,
                                                                                                        SUBSTRING(SLEEPRESTEND, 0, 12) AS 'SLEEPDATECHK',
                                                                                                        SUBSTRING(SLEEPRESTEND, 12, 16) AS 'TIME',
                                                                                                        CONVERT(CHAR(10), DATEADD(MINUTE,-30, SUBSTRING(SLEEPRESTEND, 0, 11))+' '+'".$result_seFixStartTimeChk['TIME']."', 121) AS 'DATETIME_START',
                                                                                                        CONVERT(CHAR(10), DATEADD(MINUTE,+30, SUBSTRING(SLEEPRESTEND, 0, 11))+' '+'".$result_seFixStartTimeChk['TIME']."', 121) AS 'DATETIME_END'
                                                                                                        FROM DRIVERSELFCHECK 
                                                                                                        WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
                                                                                                        AND CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'".$datestartchk."',103) AND CONVERT(DATE,'".$dateendchk."',103)
                                                                                                        AND ACTIVESTATUS ='1'
                                                                                                        ORDER BY CREATEDATE ASC";
                                                                                                }
                                                                                            }else {
                                                                                                
                                                                                                // $query_seTimeWorking = sqlsrv_query($conn, $sql_seTimeWorking, $params_seTimeWorking);
                                                                                                // ใช้เวลาของวันที่ TOP 1 มาเป็นเงื่อนไขเช็ค
                                                                                                // ถ้า check คือเวลาของวันที่แรกที่ทำงานของสัปดาห์ มากกว่า 00:00 จะต้อง +0 hrs ของ DATETIME_START และ +24 hrs ไปใน  DATETIME_END 
                                                                                                // 1711731600 คือเวลาเที่ยงคืน 
                                                                                                if ($check == '00') {
                                                                                                    $sql_seTimeWorking = "SELECT SELFCHECKID,EMPLOYEECODE,CREATEDATE,SLEEPRESTEND,
                                                                                                        SUBSTRING(SLEEPRESTEND, 0, 12) AS 'SLEEPDATECHK',
                                                                                                        SUBSTRING(SLEEPRESTEND, 12, 16) AS 'TIME',
                                                                                                        CONVERT(CHAR(10), DATEADD(HH,-0, SUBSTRING(SLEEPRESTEND, 0, 11))+' '+'".$result_seFixStartTimeChk['TIME']."', 121) AS 'DATETIME_START',
                                                                                                        CONVERT(CHAR(10), DATEADD(HH,+24, SUBSTRING(SLEEPRESTEND, 0, 11))+' '+'".$result_seFixStartTimeChk['TIME']."', 121) AS 'DATETIME_END'
                                                                                                        FROM DRIVERSELFCHECK 
                                                                                                        WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
                                                                                                        AND CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'".$datestartchk."',103) AND CONVERT(DATE,'".$dateendchk."',103)
                                                                                                        AND ACTIVESTATUS ='1'
                                                                                                        ORDER BY CREATEDATE ASC";
                                                                                                }else {
                                                                                                    $sql_seTimeWorking = "SELECT SELFCHECKID,EMPLOYEECODE,CREATEDATE,SLEEPRESTEND,
                                                                                                        SUBSTRING(SLEEPRESTEND, 0, 12) AS 'SLEEPDATECHK',
                                                                                                        SUBSTRING(SLEEPRESTEND, 12, 16) AS 'TIME',
                                                                                                        CONVERT(CHAR(10), DATEADD(HH,-2, SUBSTRING(SLEEPRESTEND, 0, 11))+' '+'".$result_seFixStartTimeChk['TIME']."', 121) AS 'DATETIME_START',
                                                                                                        CONVERT(CHAR(10), DATEADD(HH,+2, SUBSTRING(SLEEPRESTEND, 0, 11))+' '+'".$result_seFixStartTimeChk['TIME']."', 121) AS 'DATETIME_END'
                                                                                                        FROM DRIVERSELFCHECK 
                                                                                                        WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
                                                                                                        AND CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'".$datestartchk."',103) AND CONVERT(DATE,'".$dateendchk."',103)
                                                                                                        AND ACTIVESTATUS ='1'
                                                                                                        ORDER BY CREATEDATE ASC";
                                                                                                }
                    
                                                                                            }

                                                                                            $query_seTimeWorking = sqlsrv_query($conn, $sql_seTimeWorking, $params_seTimeWorking);
                                                                                            while ($result_seTimeWorking = sqlsrv_fetch_array($query_seTimeWorking, SQLSRV_FETCH_ASSOC)) {

                                                                                                // echo $startchk = $result_seTimeWorking['SLEEPDATECHK'].$start;
                                                                                                // echo "<br>";
                                                                                                // echo $endchk = $result_seTimeWorking['SLEEPDATECHK'].$end;
                                                                                                // echo "<br>";
                                                                                                // echo $result_seTimeWorking['SLEEPRESTEND'];
                                                                                                // echo "<br>";

                                                                                                $startchk = strtotime($result_seTimeWorking['DATETIME_START']."T".$start);
                                                                                                // echo "<br>";
                                                                                                $endchk = strtotime($result_seTimeWorking['DATETIME_END']."T".$end);
                                                                                                // echo "<br>";
                                                                                                // echo $result_seTimeWorking['SLEEPRESTEND'];
                                                                                                // echo "<br>";
                                                                                                // echo "------------------";
                                                                                                // echo "<br>";

                                                                                                // check คือ ค่า strtotime ของวันที่แรกของการทำงานในสัปดาห์ ที่มากกว่า 00:00
                                                                                                // 1711731600 คือเวลาเที่ยงคืน
                                                                                                // กรณีที่ 1 คือ กรณีที่เวลา ของวันแรกเกิน 00:00 และ จะต้องไม่ใช่วันแรกของสัปดาห์ หรือ top 1 selfcheck of week
                                                                                                if ($check == '00' && ($result_seFixStartTimeChk['SELFCHECKID'] != $result_seTimeWorking['SELFCHECKID'] )) {
                                                                                                    // echo ":L";
                                                                                                    // echo "<br>";
                                                                                                    // echo $result_seTimeWorking['SELFCHECKID'];
                                                                                                    // echo "<br>";

                                                                                                    // check วันที่ลำดับต่อมาว่า เวลามาปฎิบัติงานต้องไม่น้อยกว่า (เร็วกว่า) START TIME และ หรือ ต้องไม่มากกว่า END TIME
                                                                                                    // ถ้า น้อยกว่า หรือ มากกว่า จะเป็นกรณี NG ทันที
                                                                                                    if(strtotime($result_seTimeWorking['SLEEPRESTEND']) < $startchk ||  strtotime($result_seTimeWorking['SLEEPRESTEND']) > $endchk) {
                                                                                                        // ng
                                                                                                        // echo "NG";
                                                                                                        // echo "<br>";
                                                                                                        $trcolor = 'style="background-color: #FA6767"';
                                                                                                    }else {
                                                                                                        
                                                                                                        // ok
                                                                                                        // echo "OK";
                                                                                                        // echo "<br>";
                                                                                                        $trcolor = '';
                                                                                                    }
                                                                                                }else {
                                                                                                    // กรณีต่อมาคือ เคสปกติที่วันที่ปฎิบัติงานในวันแรก ไม่เกิน 00:00 
                                                                                                    // check between วันที่ปฎิบัติงานจะต้อง มากกว่า START TIME และ น้อยกว่า END TIME 
                                                                                                    // ถ้าเข้าเงื่อนไขนี้แสดงว่า ไม่ได้มาก่อน หรือ มาหลัง Fix Start Time จะเป็นกรณี OK ทันที
                                                                                                    if(strtotime($result_seTimeWorking['SLEEPRESTEND']) >= $startchk &&  strtotime($result_seTimeWorking['SLEEPRESTEND']) <= $endchk) {
                                                                                                        // echo ":R";
                                                                                                        // echo "<br>";
                                                                                                        // ok
                                                                                                        // echo "OK";
                                                                                                        // echo "<br>";
                                                                                                        $trcolor = '';
                                                                                                    }else {
                                                                                                        // กรณีต่อมา check ว่าเวลาในการปฎิบัติงานในวันแรก มากกว่า 00:00 หรือไม่
                                                                                                        // และเป็นกรณีข้ามวัน เช่น ทำงานวันที่ 27 (ทำงาน),28(ไม่ได้ทำงาน),29 (ทำงาน)
                                                                                                        if ($check == '00') {
                                                                                                            // echo ":U";
                                                                                                            // echo "<br>";
                                                                                                            // ถ้า เวลาในการปฎิบัติงานในวันแรก มากกว่า 00:00
                                                                                                            // จะเช็คว่า เวลาปฎิบัติงาน น้อยกว่า START DATE หรือไม่ ถ้า น้อยว่า จะ OK ถ้ามากกว่าจะ NG
                                                                                                            // ตัวอย่างเช่น เวลาปฎิบัติงานวันที่ 27= 00:02,28 =(ไม่ได้ทำงาน),29 ='23:00' และ Fix Start Time (GW) คือ 22:02-02:02 
                                                                                                            // ตัวอย่างนี้ เวลาในการปฎิบัติงานในวันแรก จะน้อยกว่า เวลา Start ของ Fix Start Time ตามหลักสากล เวลา 00:02 จะมาก่อน(น้อยกว่า) เวลา 22:02
                                                                                                            if (strtotime($result_seTimeWorking['SLEEPRESTEND']) <= $startchk) {
                                                                                                                // ok
                                                                                                                // echo "OK";
                                                                                                                // echo "<br>";
                                                                                                                $trcolor = '';
                                                                                                            }else{
                                                                                                                // ng
                                                                                                                // echo "NG";
                                                                                                                // echo "<br>";
                                                                                                                $trcolor = 'style="background-color: #FA6767"';
                                                                                                            }
                                                                                                            
                                                                                                        }else {
                                                                                                            // เคสอื่นๆ จะเป็น NG ทั้งหมด
                                                                                                            // echo ":E";
                                                                                                            // echo "<br>";
                                                                                                            // ng
                                                                                                            // echo "NG";
                                                                                                            // echo "<br>";
                                                                                                            $trcolor = 'style="background-color: #FA6767"';
                                                                                                        }
                                                                                                        
                                                                                                    }
                                                                                                }


                                                                                                

                                                                                                $startworkchk = date_create($result_seTimeWorking['SLEEPRESTEND']);
                                                                                                $startwork =  date_format($startworkchk,"d/m/Y H:i");

                                                                                        ?>
                                                                                        <tr <?= $trcolor?> >
                                                                                            <td><?= $i ?></td>
                                                                                            <td><?= $startwork ?></td>
                                                                                        </tr>    
                                                                                        <?php
                                                                                            $i++;
                                                                                        }
                                                                                        ?>
                                                                                        </tbody>

                                                                                    </table>

                                                                                </div>
                                                                                <div id="datasr"></div>
                                                                            </div>


                                                                            <!-- /.panel-body -->
                                                                            </div>           
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                            <!--END COLUNM9  -->

                                            <!-- START COLUNM10-->
                                            <div class="col-lg-4" >
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #7cc859;">
                                                    <?php
                                                    // $result_seSelfCheck['CREATEDATE']
                                                     $datenormal = $result_seSelfCheck['CREATEDATESHOW'];
                                                    // $date = '15/02/2023';
                                                    // $date = '2023-02-15'; // sunday
                                                    //  echo date("Y-m-d", strtotime('monday this week', strtotime($date))), "\n";   
                                                    //  echo date("Y-m-d", strtotime('sunday this week', strtotime($date))), "\n";
                                                    
                                                     $datenormalstartchk =  date("d/m/Y", strtotime('monday this week',    strtotime($datenormal)));
                                                     $datenormalendchk   =  date("d/m/Y", strtotime('saturday this week',  strtotime($datenormal)));

                                                    ?>
                                                    <label><font style="font-size: 16px">ข้อมูลเวลานอนหลับ (<?=  $datenormalstartchk?> - <?=$datenormalendchk?>)</font></label>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">
                                                        <div class="alert alert-info"  style="background-color: #eeeeee;border-color:#ddd;color: #333;border: 0px solid transparent;font-size:16px">
                                                            <div class = "row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <div class="panel-body">
                                                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                                                <div id="datadef">
                                                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>ลำดับ</th>
                                                                                                <th style="text-align: center;">วันที่และเวลา<br> (เริ่มนอน)</th>
                                                                                                <th style="text-align: center;">วันที่และเวลา<br> (ตื่นนอน)</th>
                                                                                                <th style="text-align: center;">รวมเวลา</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                        <?php
                                                                                            
                                                                                            $i = 1;

                                                                                            // $sql_seTimeWorking = "SELECT SELFCHECKID,EMPLOYEECODE,CREATEDATE,REPLACE(SLEEPRESTEND, 'T', '   ') AS 'DATETIME' 
                                                                                            $sql_seTimeNormal = "SELECT SELFCHECKID,EMPLOYEECODE,CREATEDATE,SLEEPNORMALSTART,SLEEPNORMALEND,TIMESLEEPNORMAL
                                                                                            FROM DRIVERSELFCHECK 
                                                                                            WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
                                                                                            AND CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'".$datenormalstartchk."',103) AND CONVERT(DATE,'".$datenormalendchk."',103)
                                                                                            ORDER BY CREATEDATE ASC";

                                                                                            $query_seTimeNormal = sqlsrv_query($conn, $sql_seTimeNormal, $params_seTimeNormal);
                                                                                            while ($result_seTimeNormal = sqlsrv_fetch_array($query_seTimeNormal, SQLSRV_FETCH_ASSOC)) {

                                                                                                $startnormalchk = date_create($result_seTimeNormal['SLEEPNORMALSTART']);
                                                                                                $startnormal    =  date_format($startnormalchk,"d/m/Y H:i");

                                                                                                $endnormalchk = date_create($result_seTimeNormal['SLEEPNORMALEND']);
                                                                                                $endnormal    =  date_format($endnormalchk,"d/m/Y H:i");
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td><?= $i ?></td>
                                                                                            <td><?= $startnormal ?></td>
                                                                                            <td><?= $endnormal ?></td>
                                                                                            <td style="text-align: center;"><?= $result_seTimeNormal['TIMESLEEPNORMAL'] ?></td>
                                                                                        </tr>    
                                                                                        <?php
                                                                                            $i++;
                                                                                        }
                                                                                        ?>
                                                                                        </tbody>

                                                                                    </table>

                                                                                </div>
                                                                                <div id="datasr"></div>
                                                                            </div>


                                                                            <!-- /.panel-body -->
                                                                            </div>           
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        
                                                            
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                            <!--END COLUNM10 -->


                                         <?php
                                        }else {
                                         ?>  
                                            <!-- type insert -->
                                            <!-- START COLUNM8 -->
                                            <!-- SAVE  DATEWORKING ,DATEPRESENT ลงใน DRIVERSELFCHECK-->
                                            <!-- DATEWORKING ,DATEPRESENT มาจากการกดยืนยันและบันทึกข้อมูล ในหน้าการตรวจสอบของเจ้าหน้าที่ -->
                                            <div class="col-lg-4" >
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #f0c402;">
                                                        <label><font style="font-size: 16px">บันทึกข้อมูล(พนักงาน)</font></label>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">
                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                            <div class = "row">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label >ผู้ยืนยันข้อมูล</label>
                                                                        &nbsp;
                                                                        <?php echo $_GET['officername']?>
                                                                        <input type="hidden" style="height:35px; width:200px" class="form-control" id="txt_officerconfirmhidden" name="txt_officerconfirmhidden" value= "<?= $_GET['officername'] ?>" autocomplete="off" disabled>
                                                                        <input type="text"   style="height:35px; width:200px" class="form-control" id="txt_officerconfirm" name="txt_officerconfirm" value= "<?=$result_seSelfCheck['CONFIRMEDBY']?>" autocomplete="off" disabled>                    
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label >ยืนยันข้อมูลล่าสุด</label>
                                                                        <input type="text" style="height:35px; width:200px" class="form-control" id="txt_datetimeconfirm" name="txt_datetimeconfirm" value= "<?=$result_seSelfCheck['CFDATE']?>:<?=$result_seSelfCheck['CFTIME']?>" autocomplete="off" disabled>                    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <p style="color:red;font-size: 16px;">*กดปุ่มบันทึกข้อมูลทุกครั้งก่อนออกจากเมนู</p>
                                                            </div>
                                                            <!-- บันทึกข้อมูล -->
                                                            <div class = "row">
                                                                <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <input type="button" style="width: 100%;height:80px;font-size: 25px;" onclick="save_selfcheck('save','<?=$checkClient?>','<?=$empchkgw?>');" name="btnSend" id="btnSend" value="บันทึกข้อมูล" class="btn btn-primary">
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                            <!--END COLUNM8  -->
                                        <?php
                                        }
                                        ?>
                                        


                                    </div>  


                                        <!-- ยืนยันข้อมูล -->
                                        <!-- <div class = "row">
                                            <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label >ผู้ตรวจสอบ</label>

                                                        <?php echo $_GET['officername']?>
                                                        <input type="hidden" style="height:35px; width:200px" class="form-control" id="txt_officerconfirmhidden" name="txt_officerconfirmhidden" value= "<?= $_GET['officername'] ?>" autocomplete="off" disabled>
                                                        <input type="text" style="height:35px; width:200px" class="form-control" id="txt_officerconfirm" name="txt_officerconfirm" value= "<?=$result_seSelfCheck['CONFIRMEDBY']?>" autocomplete="off" disabled>                    
                                                    </div>
                                            </div>
                                            <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label >ตรวจสอบล่าสุด</label>
                                                        <input type="text" style="height:35px; width:200px" class="form-control" id="txt_datetimeconfirm" name="txt_datetimeconfirm" value= "<?=$result_seSelfCheck['CFDATE']?>:<?=$result_seSelfCheck['CFTIME']?>" autocomplete="off" disabled>                    
                                                    </div>
                                            </div>
                                            </div>
                                        </div> -->

                                        <!-- <div class = "row">
                                            <label ></label>
                                        </div> -->

                                         <!--END ROW      -->
                                         
                                         <!-- SAVE  DATEWORKING ,DATEPRESENT ลงใน DRIVERSELFCHECK-->
                                         <!-- DATEWORKING ,DATEPRESENT มาจากการกดยืนยันและบันทึกข้อมูล ในหน้าการตรวจสอบของเจ้าหน้าที่ -->
                                         <!-- <div class="row">
                                                <div class="col-lg-6">
                                                    <p style="color:red">*กดปุ่มยืนยันข้อมูล และ ปุ่มบันทึกข้อมูลทุกครั้งก่อนออกจากเมนู</p>
                                                </div>
                                                <div class="col-lg-12">
                                                    <?php 
                                                    if ($_GET['type'] == 'check' || $_GET['type'] == 'officercheck' ) {
                                                    ?>
                                                    <input type="button" onclick="confirm_selfcheck();" name="btnSend" id="btnSend" value="ยืนยันข้อมูล" class="btn btn-success">
                                                    <input type="button" onclick="save_selfcheck('save','<?=$checkClient?>');" name="btnSend" id="btnSend" value="บันทึกข้อมูล" class="btn btn-primary">
                                                    
                                                    <?php
                                                    }else {
                                                    ?>
                                                    <input type="button" onclick="save_selfcheck('save','<?=$checkClient?>');" name="btnSend" id="btnSend" value="บันทึกข้อมูล" class="btn btn-primary">
                                                    <?php
                                                    }
                                                    ?>
                                                    
                                                   
                                                    
                                                </div>
                                         </div> -->
                                        <!-- /.row (nested) -->
                                    <!-- </div> -->

                                </div>
                                <div id="datasr_edit"></div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                        <!-- /.col-lg-12 -->
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

        <?php
        // $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeehealth', "");
        
        ?>

        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>
          
        <!-- <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
        <script type="text/javascript">

        

        // $(document).ready(function () {
        //     $('#dataTables-exampleshow').DataTable({
        //         responsive: true,
        //     });
        // });


            // function auto_caltimeformobile(){
            //     var checkClient = document.getElementById('txt_clientchk').value;
            //     timesleepselfrestcheck(checkClient);
            //     // alert(checkClient);
                

            // }
            
            // // run the function
            // var chkautofunc = document.getElementById('txt_autocallchk').value;
            // alert(chkautofunc);
            // if(chkautofunc == '1'){
                
            // }else{
            //     document.getElementById('txt_autocallchk').value = '1';
            //     // auto_caltimeformobile();
            // }
            

            function datetodate()
            {
                document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

            }   
            document.getElementById('clear').onclick = function() {

                var radio = document.querySelector('input[type=radio][name=selfextrasleep]:checked');
                radio.checked = false;
            
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

            function confirm_selfcheck(chkstatus,checkClient,empchkgw)
            {
                    // alert('confirm');
                    var officerconfirm = document.getElementById('txt_officerconfirmhidden').value;
                    var selfcheckid = document.getElementById('txt_selfchkid').value;

                    alert(officerconfirm);
                    alert(selfcheckid);
                    
                    $.ajax({
                    type: 'post',
                    url: 'meg_data2.php',
                    data: {
                        txt_flg: "confirm_selfcheck", selfcheckid: selfcheckid, officerconfirm: officerconfirm
                    },
                    success: function (rs) {
                        // alert("ยืนยันข้อมูลเรียบร้อย");
                        // alert(rs);    
                        // window.location.reload();
                        save_selfcheck(chkstatus,checkClient,empchkgw);
                    }
                });
            }
            //เช็คชั่วโมงการพักผ่อน
            //2021-05-28T20:23
            function timesleepselfrestcheck(checkClient)
            {
                 
                // var startsleepchk = document.getElementById('daysleep_reststart').value;
                // var endsleepchk = document.getElementById('daysleep_restend').value;
                // alert(startsleepchk);
                // alert(endsleepchk);
                // alert("time");

                if (checkClient == 'MB') {
                    var startsleepchk = document.getElementById('daysleep_reststart').value;
                    var endsleepchk = document.getElementById('daysleep_restend').value;
                }else{
                    //START REST
                    var startrestchk = document.getElementById('daysleep_reststart').value;
                    var startrestdata1  = startrestchk.replace(" ","T"); // replave " " เป็น "T"
                    var startrestdata2  = startrestdata1.replace("/","-");
                    var startrestdata3  = startrestdata2.replace("/","-"); // replave "/" เป็น "-"
                    var startsleepchk = startrestdata3;
                    
                    //END REST
                    var endrestchk = document.getElementById('daysleep_restend').value;
                    var endrestdata1  = endrestchk.replace(" ","T"); // replave " " เป็น "T"
                    var endrestdata2  = endrestdata1.replace("/","-");// replave "/" เป็น "-"
                    var endrestdata3  = endrestdata2.replace("/","-");
                    var endsleepchk = endrestdata3;
                    
                    // alert(startsleepchk);
                    // alert(endsleepchk);
                }
           
                $.ajax({
                    type: 'post',
                    url: 'meg_data2.php',
                    data: {
                        txt_flg: "select_resttimeselfcheck", startsleep: startsleepchk, endsleep: endsleepchk
                    },
                    success: function (rs) {
                        // alert(rs);
                        
                        document.getElementById('timesleep_rest').value = rs;
                        save_selfcheckbefore('save',checkClient);
                    }
                });
            
            }

            function  save_keydroptimebyofficer(selfchkid,dsreststartchk,employeecode){
                // alert(selfchkid);
                // alert(dsreststartchk);
                // alert(employeecode);

                $.ajax({
                    type: 'post',
                    url: 'meg_data2.php',
                    data: {
                        txt_flg: "update_keydroptimebyofficer", selfchkid: selfchkid, dsreststartchk: dsreststartchk,employeecode,employeecode
                    },
                    success: function (rs) {
                        // alert(rs);
                        
                        // document.getElementById('timesleep_rest').value = rs;
                        // save_selfcheckbefore('save',checkClient);
                    }
                });
            }
            
            //เช็คชั่วโมงการนอนปกติ
            function timesleepselfnormalcheck(checkClient)
            {
                // var startsleepchk = document.getElementById('daysleep_normalstart').value;
                // var endsleepchk = document.getElementById('daysleep_normalend').value;
                // alert(startsleepchk);
                // alert(endsleepchk);
                if (checkClient == 'MB') {
                    var startsleepchk = document.getElementById('daysleep_normalstart').value;
                    var endsleepchk = document.getElementById('daysleep_normalend').value;
                }else{
                    //START NORMAL
                    var startrestchk = document.getElementById('daysleep_normalstart').value;
                    var startrestdata1  = startrestchk.replace(" ","T"); // replave " " เป็น "T"
                    var startrestdata2  = startrestdata1.replace("/","-");
                    var startrestdata3  = startrestdata2.replace("/","-"); // replave "/" เป็น "-"
                    var startsleepchk = startrestdata3;
                    
                    //END NORMAL
                    var endrestchk = document.getElementById('daysleep_normalend').value;
                    var endrestdata1  = endrestchk.replace(" ","T"); // replave " " เป็น "T"
                    var endrestdata2  = endrestdata1.replace("/","-");// replave "/" เป็น "-"
                    var endrestdata3  = endrestdata2.replace("/","-");
                    var endsleepchk = endrestdata3;
                    // alert('normal');
                    // alert(startsleepchk);
                    // alert(endsleepchk);
                }

                if (startsleepchk == '') {
                    
                    swal.fire({
                        title: "Warning!",
                        text: "ยังไม่ได้ลงข้อมูลเวลาเริ่มนอน(นอนปกติ)",
                        icon: "warning",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });

                }else if(endsleepchk == ''){

                    swal.fire({
                        title: "Warning!",
                        text: "ยังไม่ได้ลงข้อมูลเวลาตื่นนอน(นอนปกติ)",
                        icon: "warning",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });

                }else {

                    // alert('cal normal');
                    
                    $.ajax({
                        type: 'post',
                        url: 'meg_data2.php',
                        data: {
                            txt_flg: "select_resttimeselfcheck", startsleep: startsleepchk, endsleep: endsleepchk
                        },
                        success: function (rs) {
                            
                            // alert(rs);
                            
                            let text = rs;
                            
                            // split เครื่องหมาย : และ เก็บค่านาทีเข้า array
                            let result = text.split(':');
                            let [first,second] = result;
                            // alert(second);
                            
                            // เอาค่าของ array ตำแหน่งที่ 2 มา trim และนับ lenght 
                            let trimtext = second.trim();
                            let chklength = trimtext.length;
                            // alert(chklength);
                    
                        
                            // นับ lenght ของตัวอักษรจากการ trim 
                            // ถ้าตำแหน่งเป็น 1 คือ นาทีเป็น 1 ตำแหน่งเช่่น 0:4,14:4 ให้ replace เครื่องหมาย : เป็น :0
                            if (chklength == '1') {
                                // check len
                                // alert('chklength = 1')  
                                var replacetext = text.replace(":", ":0");
                                // alert(replacetext);

                            }else{
                                // ถ้าตำแหน่ง !=1 ไม่ต้อง replace ค่าของนาที
                                // alert('chklength other')  
                                var replacetext = text;
                                // alert(replacetext); 
                            }

                            // alert(replacetext); 

                            let result1 =  text.substring(0, 2);
                            let replace1 = result1.replace(":", " ");

                            let result2 =  text.substring(3, 5);
                            let replace2 = result2.replace(":", " ");

                            // alert(replace1);
                            // alert(replace2);

                            if (replace1 == 0) {

                                document.getElementById("timesleep_normal").style.backgroundColor = "#94FA67";
                                document.getElementById('timesleep_normal').value = replacetext;
                                // save_timeworking1(selfcheckid,replacetext,'OK');
                                // alert('1');

                            }else if ((replace1 > 0 && replace1 >= 6)) {
                                // alert('2');
                                document.getElementById("timesleep_normal").style.backgroundColor = "#94FA67";
                                document.getElementById('timesleep_normal').value = replacetext;
                                // save_timeworking1(selfcheckid,replacetext,'OK');

                            

                            }else if (replace1 == 6) {
                            

                                // document.getElementById("timeworking1").style.backgroundColor = "#94FA67";
                                // document.getElementById('timeworking1').value = text;
                                // save_timeworking1(selfcheckid,text);

                                if (replace2 <= 0) {
                                    //  #94FA67 สีเขียว
                                    document.getElementById("timesleep_normal").style.backgroundColor = "#94FA67";
                                    document.getElementById('timesleep_normal').value = replacetext;
                                    // save_timeworking1(selfcheckid,replacetext,'OK');
                                    // alert('3');
                                }else{
                                    //  #FA6767 สีเแดง
                                    document.getElementById("timesleep_normal").style.backgroundColor = "#FA6767";
                                    document.getElementById('timesleep_normal').value = replacetext;
                                    // save_timeworking1(selfcheckid,replacetext,'NG');
                                    // alert('4');
                                }
                            

                            }else{
                                //  #FA6767 สีเแดง
                                document.getElementById("timesleep_normal").style.backgroundColor = "#FA6767";
                                document.getElementById('timesleep_normal').value = replacetext;
                                // save_timeworking1(selfcheckid,replacetext,'NG');
                                // alert('5');

                            }

                            // document.getElementById('timesleep_normal').value = rs;
                            
                            // ระบบจะ save selfcheck ด้วย
                            save_selfcheckbefore('save');
                        }
                    });
                }

                


            }
            //เช็คชั่วโมงการนอนเพิ่มเติม
            function timesleepselfextracheck(checkClient)
            {
                // var startsleepchk = document.getElementById('daysleep_extrastart').value;
                // var endsleepchk = document.getElementById('daysleep_extraend').value;
                // alert(startsleepchk);
                // alert(endsleepchk);
                if (checkClient == 'MB') {
                    var startsleepchk = document.getElementById('daysleep_extrastart').value;
                    var endsleepchk = document.getElementById('daysleep_extraend').value;
                }else{
                    //START EXTRA
                    var startrestchk = document.getElementById('daysleep_extrastart').value;
                    var startrestdata1  = startrestchk.replace(" ","T"); // replave " " เป็น "T"
                    var startrestdata2  = startrestdata1.replace("/","-");
                    var startrestdata3  = startrestdata2.replace("/","-"); // replave "/" เป็น "-"
                    var startsleepchk = startrestdata3;
                    
                    //END EXTRA
                    var endrestchk = document.getElementById('daysleep_extraend').value;
                    var endrestdata1  = endrestchk.replace(" ","T"); // replave " " เป็น "T"
                    var endrestdata2  = endrestdata1.replace("/","-");// replave "/" เป็น "-"
                    var endrestdata3  = endrestdata2.replace("/","-");
                    var endsleepchk = endrestdata3;
                    // alert('extra');
                    // alert(startsleepchk);
                    // alert(endsleepchk);
                }

                if (startsleepchk == '') {
                    
                    swal.fire({
                        title: "Warning!",
                        text: "ยังไม่ได้ลงข้อมูลเวลาเริ่มพักผ่อน(กะกลางคืน)",
                        icon: "warning",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });

                }else if(endsleepchk == ''){

                    swal.fire({
                        title: "Warning!",
                        text: "ยังไม่ได้ลงข้อมูลเวลาตื่นพักผ่อน(กะกลางคืน)",
                        icon: "warning",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });

                }else {

                    $.ajax({
                        type: 'post',
                        url: 'meg_data2.php',
                        data: {
                            txt_flg: "select_resttimeselfcheck", startsleep: startsleepchk, endsleep: endsleepchk
                        },
                        success: function (rs) {
                            
                            document.getElementById('timesleep_extra').value = rs;
                            save_selfcheckbefore('save');
                        }
                    });

                }
                
                


            }

            
            // save สำหรับ change สีการนอน
            // save สำหรับ ปุ่มคำนวณเวลา
            function save_selfcheckbefore(chkstatus,checkClient) 
            {
                    
                    // alert(chkstatus);
                    // alert(checkClient);
                    
                    var datejobstart = document.getElementById('txt_datedriverchk').value;
                    var dateworking  = document.getElementById('txt_dateworkingchk').value;
                    var datepresent  = document.getElementById('txt_datepresentchk').value;
                    var employeecode = document.getElementById('txt_empcode').value;
                    var employeename = document.getElementById('txt_empname').value;
                    var sessionid    = document.getElementById('txt_selfsession').value;
                    // alert(datejobstart);
                    // alert(timejobstart);
                    // alert(sessionid);
                    // เช็คการลงข้อมูลคอลัมย์ที่1
                    var self1yeschk = "";
                    var self1nochk = "";
                    var self2yeschk = "";
                    var self2nochk = "";
                    var self3yeschk = "";
                    var self3nochk = "";
                    var self4yeschk = "";
                    var self4nochk = "";
                    var self5yeschk = "";
                    var self5nochk = "";
                    var selfallyeschk = "";
                    var selfallnochk = "";
                    
                    //ประเมิณอาการเหนื่อยล้า
                    if($("#self1yes").is(':checked') || $("#self1no").is(':checked') ){
                        //alert("yes");
                         if($("#self1yes").is(':checked')){
                            self1yeschk = '1';
                            //alert('มีอาการเหนื่อยล้า');
                            //alert(self1yeschk);
                        } else {
                            self1nochk = '1';
                            //alert(self1nochk);
                            //alert('ไม่มีอาการเหนื่อยล้า');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'อาการเหนื่อยล้า'");

                    }
                    
                    //ประเมิณอาการเจ็บป่วย
                    if($("#self2yes").is(':checked') || $("#self2no").is(':checked') ){
                        //alert("yes");
                         if($("#self2yes").is(':checked')){
                            self2yeschk = '1';
                            //alert('มีอาการเจ็บป่วย');
                        } else {
                            self2nochk = '1';
                            //alert('ไม่มีอาการเจ็บป่วย');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'อาการเจ็บป่วย'");

                    }

                    //ประเมิณอาการง่วงนอน
                    if($("#self3yes").is(':checked') || $("#self3no").is(':checked') ){
                        //alert("yes");
                         if($("#self3yes").is(':checked')){
                            self3yeschk = '1';
                            //alert('มีอาการง่วงนอน');
                        } else {
                            self3nochk = '1';
                            //alert('ไม่มีอาการง่วงนอน');
                        }
                    }else{
                       // alert("ยังไม่ได้ประเมิน 'อาการง่วงนอน'");

                    }

                    //ประเมิณอาการบาดเจ็บ
                    if($("#self4yes").is(':checked') || $("#self4no").is(':checked') ){
                        //("yes");
                         if($("#self4yes").is(':checked')){
                            self4yeschk = '1';
                            //('มีอาการบาดเจ็บ');
                            
                        } else {
                            self4nochk = '1';
                            //alert('ไม่มีอาการบาดเจ็บ');
                           
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'อาการบาดเจ็บ'");

                    }

                    //ประเมิณทานยาที่มีผลต่อการขับขี่
                    if($("#self5yes").is(':checked') || $("#self5no").is(':checked') ){
                        //alert("yes");
                         if($("#self5yes").is(':checked')){
                            self5yeschk = '1';
                            //alert('ทานยาที่มีผลต่อการขับขี่');
                            // alert(self5yeschk);
                            // alert('ทานยา');
                        } else {
                            self5nochk = '1';
                            //alert('ไม่ทานยาที่มีผลต่อการขับขี่');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'ทานยาที่มีผลต่อการขับขี่'");

                    }

                    //ประเมิณสภาพร่างกาย
                    if($("#selfallyes").is(':checked') || $("#selfallno").is(':checked') ){
                        //alert("yes");
                         if($("#selfallyes").is(':checked')){
                            selfallyeschk = '1';
                            //alert('สภาพร่างกายปกติ');
                        } else {
                            selfallnochk = '1';
                            //alert('สภาพร่างกายไม่ปกติ');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'สภาพร่างกาย'");

                    }

                    // เช็คการลงข้อมูลคอลัมย์ที่2 เวลาพักผ่อน 8 ชั่วโมง
                    // var dsreststart = document.getElementById('daysleep_reststart').value;
                    // var dsrestend = document.getElementById('daysleep_restend').value;
                    // var tsrest = document.getElementById('timesleep_rest').value;
                    
                    if (checkClient == 'MB') {
                        var dsreststart = document.getElementById('daysleep_reststart').value;
                        var dsrestend = document.getElementById('daysleep_restend').value;
                        var tsrest = document.getElementById('timesleep_rest').value;
                    }else{
                        // alert('else');
                        //START REST
                        var startrestchk = document.getElementById('daysleep_reststart').value;
                        var startrestdata1  = startrestchk.replace(" ","T"); // replave " " เป็น "T"
                        var startrestdata2  = startrestdata1.replace("/","-");
                        var startrestdata3  = startrestdata2.replace("/","-"); // replave "/" เป็น "-"
                        var dsreststart = startrestdata3;
                        
                        //END REST
                        var endrestchk = document.getElementById('daysleep_restend').value;
                        var endrestdata1  = endrestchk.replace(" ","T"); // replave " " เป็น "T"
                        var endrestdata2  = endrestdata1.replace("/","-");// replave "/" เป็น "-"
                        var endrestdata3  = endrestdata2.replace("/","-");
                        var dsrestend = endrestdata3;
                        
                        var tsrest = document.getElementById('timesleep_rest').value;
                        
                        // alert(dsreststart);
                        // alert(dsrestend);
                    }

                    //date rest start
                    if (dsreststart == '') {
                        dsreststartchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาเริ่มพักผ่อน(8 ชั่วโมง)');
                    }else{
                        dsreststartchk = dsreststart;
                        //alert(dsnormalstartchk);
                    }
                    
                    //date rest end
                    if (dsrestend == '') {
                        dsrestendchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาตื่นพักผ่อน(8 ชั่วโมง)');
                    }else{
                        dsrestendchk = dsrestend;
                        //alert(dsrestendchk);
                    }

                    //time sleep rest 
                    if (tsrest == '') {
                        tsrestchk = "";
                        //alert('ยังไม่ได้ลงระยะเวลาที่พักผ่อน(8 ชั่วโมง)');
                    }else{
                        tsrestchk = tsrest;
                        //alert(tsrestchk);
                    }

                    // เช็คการลงข้อมูลคอลัมย์ที่3 เวลาการนอนปกติ
                    // var dsnormalstart = document.getElementById('daysleep_normalstart').value;
                    // var dsnormalend = document.getElementById('daysleep_normalend').value;
                    // var tsnormal = document.getElementById('timesleep_normal').value;
                    var selfsleepnormalyeschk = "";
                    var selfsleepnormalnochk = "";

                    if (checkClient == 'MB') {
                        var dsnormalstart = document.getElementById('daysleep_normalstart').value;
                        var dsnormalend = document.getElementById('daysleep_normalend').value;
                        var tsnormal = document.getElementById('timesleep_normal').value;
                    }else{
                        // alert('else');
                        //START NORMALSLEEP
                        var startnormalchk = document.getElementById('daysleep_normalstart').value;
                        var startnormaldata1  = startnormalchk.replace(" ","T"); // replave " " เป็น "T"
                        var startnormaldata2  = startnormaldata1.replace("/","-");
                        var startnormaldata3  = startnormaldata2.replace("/","-"); // replave "/" เป็น "-"
                        var dsnormalstart = startnormaldata3;
                        
                        //END NORMALSLEEP
                        var endnormalchk = document.getElementById('daysleep_normalend').value;
                        var endnormaldata1  = endnormalchk.replace(" ","T"); // replave " " เป็น "T"
                        var endnormaldata2  = endnormaldata1.replace("/","-");// replave "/" เป็น "-"
                        var endnormaldata3  = endnormaldata2.replace("/","-");
                        var dsnormalend = endnormaldata3;
                        
                        var tsnormal = document.getElementById('timesleep_normal').value;
                        
                        // alert(dsnormalstart);
                        // alert(dsnormalend);
                    }
                    
                    //date normal start
                    if (dsnormalstart == '') {
                        dsnormalstartchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาเริ่มพักผ่อน(ปกติ)');
                    }else{
                        dsnormalstartchk = dsnormalstart;
                        //alert(dsnormalstartchk);
                    }
                    
                    //date normal end
                    if (dsnormalend == '') {
                        dsnormalendchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาตื่นพักผ่อน(ปกติ)');
                    }else{
                        dsnormalendchk = dsnormalend;
                        //alert(dsnormalendchk);
                    }

                    //time sleep normal 
                    if (tsnormal == '') {
                        tsnormalchk = "";
                        //alert('ยังไม่ได้ลงระยะเวลาที่นอน(ปกติ)');
                    }else{
                        tsnormalchk = tsnormal;
                        //alert(tsnormalchk);
                    }

                    //ประเมินการนอนปกติ
                    if($("#selfnormalsleepyes").is(':checked') || $("#selfnormalsleepno").is(':checked') ){
                        //alert("yes");
                         if($("#selfnormalsleepyes").is(':checked')){
                            selfsleepnormalyeschk = '1';
                            //alert('การนอนปกติ(หลับสนิท)');
                        } else {
                            selfsleepnormalnochk = '1';
                            //alert('การนอนปกติ(หลับไม่สนิท)');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'การนอนปกติ'");

                    }

                    // เช็คการลงข้อมูลคอลัมย์ที่3 เวลาการนอนเพิ่มเติม
                    // var dsextrastart = document.getElementById('daysleep_extrastart').value;
                    // var dsextraend = document.getElementById('daysleep_extraend').value;
                    // var tsextra = document.getElementById('timesleep_extra').value;
                    var selfsleepextrayeschk = "";
                    var selfsleepextranochk = "";
                    
                    if (checkClient == 'MB') {
                        var dsextrastart = document.getElementById('daysleep_extrastart').value;
                        var dsextraend = document.getElementById('daysleep_extraend').value;
                        var tsextra = document.getElementById('timesleep_extra').value;
                    }else{
                        // alert('else');
                        //START NORMALSLEEP
                        var startextrachk = document.getElementById('daysleep_extrastart').value;
                        var startextradata1  = startextrachk.replace(" ","T"); // replave " " เป็น "T"
                        var startextradata2  = startextradata1.replace("/","-");
                        var startextradata3  = startextradata2.replace("/","-"); // replave "/" เป็น "-"
                        var dsextrastart = startextradata3;

                        //END NORMALSLEEP
                        var endextrachk = document.getElementById('daysleep_extraend').value;
                        var endextradata1  = endextrachk.replace(" ","T"); // replave " " เป็น "T"
                        var endextradata2  = endextradata1.replace("/","-");// replave "/" เป็น "-"
                        var endextradata3  = endextradata2.replace("/","-");
                        var dsextraend = endextradata3;
                        
                        var tsextra = document.getElementById('timesleep_extra').value;
                        
                        // alert(dsextrastart);
                        // alert(dsextraend);
                    }

                    //date extra start
                    if (dsextrastart == '') {
                        dsextrastartchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาเริ่มพักผ่อน(กะกลางคืน)');
                    }else{
                        dsextrastartchk = dsextrastart;
                        //alert(dsextrastartchk);
                    }
                    
                    //date extra end
                    if (dsextraend == '') {
                        dsextraendchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาตื่นพักผ่อน(กะกลางคืน)');
                    }else{
                        dsextraendchk = dsextraend;
                        //alert(dsextraendchk);
                    }

                    //time sleep extra 
                    if (tsextra == '') {
                        tsextrachk = "";
                        //alert('ยังไม่ได้ลงระยะเวลาที่นอน(กะกลางคืน)');
                    }else{
                        tsextrachk = tsextra;
                        //alert(tsextrachk);
                    }

                    //ประเมินการนอนเพิ่ม
                    if($("#selfextrasleepyes").is(':checked') || $("#selfextrasleepno").is(':checked') ){
                        //alert("yes");
                         if($("#selfextrasleepyes").is(':checked')){
                            selfsleepextrayeschk = '1';
                            //alert('การนอนกะกลางคืน(หลับสนิท)');
                        } else {
                            selfsleepextranochk = '1';
                            //alert('การนอนกะกลางคืน(หลับไม่สนิท)');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'การนอนกะกลางคืน'");

                    }

                    // เช็คการลงข้อมูลคอลัมย์ที่4
                    var disease = document.getElementById('disease').value;
                    var drugname = document.getElementById('drug_name').value;
                    var drugtime = document.getElementById('drug_time').value;
                    var selfdoctoryeschk = "";
                    var selfdoctornochk = "";
                    //อาการป่วย

                    //date extra start
                    if (disease == '') {
                        diseasechk = "";
                        //alert('ยังไม่ได้ลงข้อมูลโรค');
                    }else{
                        diseasechk = disease;
                        //alert(diseasechk);
                    }

                    //ประเมินการพบหมอ
                    if($("#selfdoctoryes").is(':checked') || $("#selfdoctorno").is(':checked') ){
                        //alert("yes");
                         if($("#selfdoctoryes").is(':checked')){
                            selfdoctoryeschk = '1';
                            //alert('พบหมอ');
                        } else {
                            selfdoctornochk = '1';
                            //alert('ไม่ได้พบหมอ');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'พบหมอ'");

                    }

                    //drug name
                    if (drugname == '') {
                        drugnamechk = "";
                        //alert('ยังไม่ได้ลงข้อมูลชื่อยา');
                    }else{
                        drugnamechk = drugname;
                        //alert(drugnamechk);
                    }

                    // //time sleep extra 
                    drugtimechk = drugtime;
                    //alert(drugtimechk);
                    
                    // if (drugtime == '') {
                    //     drugtimechk = "";
                    //     alert('ยังไม่ได้ลงเวลาทานยา');
                    // }else{
                    //     drugtimechk = drugtime;
                    //     alert(drugtimechk);
                    // }

                    
                    // เช็คการลงข้อมูลคอลัมย์ที่5
                    var selfworryyeschk = "";
                    var selfworrynochk = "";
                    var selfhouseholdyeschk = "";
                    var selfhouseholdnochk = "";

                    //ประเมินเรื่องกังวลใจ / การใช้เวลาช่วงพักผ่อน
                    //เรื่องกังวลใจ
                    if($("#selfworryyes").is(':checked') || $("#selfworryno").is(':checked') ){
                        //alert("yes");
                         if($("#selfworryyes").is(':checked')){
                            selfworryyeschk = '1';
                            //alert('มีเรื่องกังวลใจ');
                        } else {
                            selfworrynochk = '1';
                            //alert('ไม่มีเรื่องกังวลใจ');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'เรื่องกังวลใจ'");

                    }
                    // การใช้เวลาช่วงพักผ่อน
                    if($("#selfhouseholdyes").is(':checked') || $("#selfhouseholdno").is(':checked') ){
                       // alert("yes");
                         if($("#selfhouseholdyes").is(':checked')){
                            selfhouseholdyeschk = '1';
                            //alert('ใช้ช่วงเวลาพักผ่อนในบ้าน');
                        } else {
                            selfhouseholdnochk = '1';
                            //alert('ใช้ช่วงเวลาพักผ่อนนอกบ้าน');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'การใช้ช่วงเวลาพักผ่อน'");

                    }

                    // เช็คการลงข้อมูลคอลัมย์ที่6
                    var tempchk = document.getElementById('temperature').value;
                    var syschk1 = document.getElementById('sys_value1').value;
                    var syschk2 = document.getElementById('sys_value2').value;
                    var syschk3 = document.getElementById('sys_value3').value;
                    var diachk1 = document.getElementById('dia_value1').value;
                    var diachk2 = document.getElementById('dia_value2').value;
                    var diachk3 = document.getElementById('dia_value3').value;
                    var pulsechk1 = document.getElementById('pulse_value1').value;
                    var pulsechk2 = document.getElementById('pulse_value2').value;
                    var pulsechk3 = document.getElementById('pulse_value3').value;
                    var oxygenchk = document.getElementById('oxygen_value').value;
                    
                    //ประเมินอุณภูมิ ความดันบน ความดันล่าง
                    
                    // //ประเมินอุณภูมิ 
                    // if (temp == '') {
                    //     tempchk = "";
                    //     alert('ยังไม่ได้ลงข้อมูลอุณภูมิ');
                    // }else{
                    //     tempchk = temp;
                    //     //alert(tempchk);
                    // }

                    // //ความดันบน ความดันล่าง
                    // if (sys == '') {
                    //     syschk = "";
                    //     alert('ยังไม่ได้ลงข้อมูลความดันบน');
                    // }else{
                    //     syschk = sys;
                    //     //alert(syschk);
                    // }

                    // //ความดันล่าง
                    // if (dia == '') {
                    //     diachk = "";
                    //     alert('ยังไม่ได้ลงข้อมูลความดันล่าง');
                    // }else{
                    //     diachk = dia;
                    //     //alert(diachk);
                    // }
                    
                    // เช็คการลงข้อมูลคอลัมย์ที่7
                    var selfeyeproblemyeschk    = "";
                    var selfeyeproblemnochk     = "";
                    var selfeyeglassesyeschk    = "";
                    var selfeyeglassesnochk     = "";
                    var selfcarryeyeglassesyeschk  = "";
                    var selfcarryeyeglassesnochk   = "";
                    var selfcarryhearingaidyeschk  = "";
                    var selfcarryhearingaidnochk   = "";

                    //ปัญหาสายตา/แว่นสายตา
                    //ปัญหาสายตา
                    if($("#selfeyeproblemyes").is(':checked') || $("#selfeyeproblemno").is(':checked') ){
                        //alert("yes");
                         if($("#selfeyeproblemyes").is(':checked')){
                            selfeyeproblemyeschk = '1';
                            //alert(',มีปัญหาสายตา');
                        } else {
                            selfeyeproblemnochk = '1';
                            //alert('ไม่มีปัญหาสายตา');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'ปัญหาสายตา'");

                    }    
                    // แว่นสายตา
                    if($("#selfeyeglassesyes").is(':checked') || $("#selfeyeglassesno").is(':checked') ){
                       // alert("yes");
                         if($("#selfeyeglassesyes").is(':checked')){
                            selfeyeglassesyeschk = '1';
                            //alert('มีแว่นสายตา');
                        } else {
                            selfeyeglassesnochk = '1';
                            //alert('ไม่มีแว่นสายตา');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'แว่นสายตา'");

                    }
                    // พกพาแว่นสายตา
                    if($("#selfcarryeyeglassesyes").is(':checked') || $("#selfcarryeyeglassesno").is(':checked') ){
                       // alert("yes");
                         if($("#selfcarryeyeglassesyes").is(':checked')){
                            selfcarryeyeglassesyeschk = '1';
                            //alert('มีแว่นสายตา');
                        } else {
                            selfcarryeyeglassesnochk = '1';
                            //alert('ไม่มีแว่นสายตา');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'แว่นสายตา'");

                    }
                    // สวมใส่เครื่องช่วยฟัง
                    if($("#selfcarryhearingaidyes").is(':checked') || $("#selfcarryhearingaidno").is(':checked') ){
                       // alert("yes");
                         if($("#selfcarryhearingaidyes").is(':checked')){
                            selfcarryhearingaidyeschk = '1';
                            //alert('มีแว่นสายตา');
                        } else {
                            selfcarryhearingaidnochk = '1';
                            //alert('ไม่มีแว่นสายตา');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'แว่นสายตา'");

                    }
                    
                    // เช็คการลงข้อมูลคอลัมย์ที่8
                    var alcoholtype = document.getElementById('alcohol_type').value;
                    var alcoholtime = document.getElementById('alcohol_time').value;
                    var alcoholvolume = document.getElementById('alcohol_volume').value;
                    //ประเมินแอลกอฮอล์ เวลาเลิก ปริมาณ

                    // alert(alcoholvolume);

                    //ประเมินแอลกอฮอล์ 
                    if (alcoholtype == '') {
                        alcoholtypechk = "";
                        //alert('ยังไม่ได้ลงข้อมูลแอลกอฮอล์');
                    }else{
                        alcoholtypechk = alcoholtype;
                        //alert(alcoholtypechk);
                    }

                    //เวลาเลิก
                    alcoholtimechk = alcoholtime;
                    //alert(alcoholtimechk);
                    // if (alcoholtime == '') {
                    //     alcoholtimechk = "";
                    //     alert('ยังไม่ได้ลงข้อมูลเวลาเลิก');
                    // }else{
                    //     alcoholtimechk = alcoholtime;
                    //     alert(alcoholtimechk);
                    // }

                    //ปริมาณ
                    if (alcoholvolume == '') {
                        alcoholvolumechk = "";
                        // alert('ยังไม่ได้ลงข้อมูลปริมาณแอลกอฮอล์');
                    }else{
                        alcoholvolumechk = alcoholvolume;
                        // alert(alcoholvolumechk);
                    }

                    

                    var selfchkid = document.getElementById('txt_selfchkid').value
                    //save_selfcheckbefore

                    if (selfchkid != '') {
                        // alert('update');
                        
                        $.ajax({
                        type: 'post',
                        url: 'meg_data2.php',
                        data: {
                            
                            txt_flg: "update_selfcheckdetail",
                            id:selfchkid, 
                            employeecode: employeecode,
                            employeename: employeename, 
                            datejobstart: datejobstart,
                            dateworking: dateworking,
                            datepresent: datepresent,
                            tierdyeschk: self1yeschk,
                            tierdnochk: self1nochk,
                            illnessyeschk: self2yeschk,
                            illnessnochk: self2nochk,
                            drowseyeschk: self3yeschk,
                            drowsenochk: self3nochk,
                            injuryyeschk: self4yeschk,
                            injurynochk: self4nochk,
                            takemedicineyeschk: self5yeschk,
                            takemedicinenochk: self5nochk, 
                            healthyyeschk: selfallyeschk, 
                            healthynochk: selfallnochk,
                            sleepreststart: dsreststartchk,
                            sleeprestend: dsrestendchk,
                            timesleeprest: tsrestchk,
                            sleepnormalstart: dsnormalstartchk,
                            sleepnormalend: dsnormalendchk,
                            timesleepnormal: tsnormalchk,
                            sleepnormalyes: selfsleepnormalyeschk,
                            sleepnormalno: selfsleepnormalnochk,
                            sleepextrastart: dsextrastartchk,
                            sleepextraend: dsextraendchk,
                            timesleepextra: tsextrachk,
                            sleepextrayes: selfsleepextrayeschk,
                            sleepextrano: selfsleepextranochk,
                            disease: diseasechk,
                            seedoctoryes: selfdoctoryeschk,
                            seedoctorno: selfdoctornochk,
                            drugname: drugnamechk,
                            drugtime: drugtimechk,
                            worryyes: selfworryyeschk,
                            worryno: selfworrynochk,
                            householdyes: selfhouseholdyeschk,
                            householdno: selfhouseholdnochk,
                            temperature: tempchk,
                            sysvalue1: syschk1,
                            sysvalue2: syschk2,
                            sysvalue3: syschk3,
                            diavalue1: diachk1,
                            diavalue2: diachk2,
                            diavalue3: diachk3,
                            pulsevalue1: pulsechk1,
                            pulsevalue2: pulsechk2,
                            pulsevalue3: pulsechk3,
                            oxygenvalue:oxygenchk,
                            eyeproblemyes: selfeyeproblemyeschk,
                            eyeproblemno: selfeyeproblemnochk,
                            selfeyeglassesyes: selfeyeglassesyeschk,
                            selfeyeglassesno: selfeyeglassesnochk,
                            selfcarryeyeglassesyes: selfcarryeyeglassesyeschk,
                            selfcarryeyeglassesno: selfcarryeyeglassesnochk,
                            selfcarryhearingaidyes:selfcarryhearingaidyeschk,
                            selfcarryhearingaidno:selfcarryhearingaidnochk,
                            alcoholtype: alcoholtypechk,
                            alcoholtime: alcoholtimechk,
                            alcoholvolume: alcoholvolumechk,
                            activestatus: '1',
                            remark: '',
                            createby: employeecode,
                            createdate: '',
                            modifiedby: '',
                            modifieddate: ''



                        },
                        success: function (rs) {
                            
                            //เจ้าหน้าที่กดเปลี่ยนเวลา วางกุญแจในหน้าการดูรายละเอียด
                            save_keydroptimebyofficer(selfchkid,dsreststartchk,employeecode);

                            // alert("แก้ไขข้อมูลเรียบร้อย");

                            swal.fire({
                                title: "Good Job!",
                                text: "แก้ไขข้อมูลเรียบร้อย",
                                icon: "success",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            // alert(rs);   
                            setTimeout(() => {
                                document.location.reload();
                            }, 1200); 
  
                        }
                    });

                    }else{
                        // alert('save');
                        $.ajax({
                        type: 'post',
                        url: 'meg_data2.php',
                        data: {
                            
                            txt_flg: "save_selfcheckdetail",
                            id:'', 
                            employeecode: employeecode,
                            employeename: employeename, 
                            datejobstart: datejobstart,
                            dateworking: dateworking,
                            datepresent: datepresent,
                            tierdyeschk: self1yeschk,
                            tierdnochk: self1nochk,
                            illnessyeschk: self2yeschk,
                            illnessnochk: self2nochk,
                            drowseyeschk: self3yeschk,
                            drowsenochk: self3nochk,
                            injuryyeschk: self4yeschk,
                            injurynochk: self4nochk,
                            takemedicineyeschk: self5yeschk,
                            takemedicinenochk: self5nochk, 
                            healthyyeschk: selfallyeschk, 
                            healthynochk: selfallnochk,
                            sleepreststart: dsreststartchk,
                            sleeprestend: dsrestendchk,
                            timesleeprest: tsrestchk,
                            sleepnormalstart: dsnormalstartchk,
                            sleepnormalend: dsnormalendchk,
                            timesleepnormal: tsnormalchk,
                            sleepnormalyes: selfsleepnormalyeschk,
                            sleepnormalno: selfsleepnormalnochk,
                            sleepextrastart: dsextrastartchk,
                            sleepextraend: dsextraendchk,
                            timesleepextra: tsextrachk,
                            sleepextrayes: selfsleepextrayeschk,
                            sleepextrano: selfsleepextranochk,
                            disease: diseasechk,
                            seedoctoryes: selfdoctoryeschk,
                            seedoctorno: selfdoctornochk,
                            drugname: drugnamechk,
                            drugtime: drugtimechk,
                            worryyes: selfworryyeschk,
                            worryno: selfworrynochk,
                            householdyes: selfhouseholdyeschk,
                            householdno: selfhouseholdnochk,
                            temperature: tempchk,
                            sysvalue1: syschk1,
                            sysvalue2: syschk2,
                            sysvalue3: syschk3,
                            diavalue1: diachk1,
                            diavalue2: diachk2,
                            diavalue3: diachk3,
                            pulsevalue1: pulsechk1,
                            pulsevalue2: pulsechk2,
                            pulsevalue3: pulsechk3,
                            oxygenvalue:oxygenchk,
                            eyeproblemyes: selfeyeproblemyeschk,
                            eyeproblemno: selfeyeproblemnochk,
                            selfeyeglassesyes: selfeyeglassesyeschk,
                            selfeyeglassesno: selfeyeglassesnochk,
                            selfcarryeyeglassesyes: selfcarryeyeglassesyeschk,
                            selfcarryeyeglassesno: selfcarryeyeglassesnochk,
                            selfcarryhearingaidyes: selfcarryhearingaidyeschk,
                            selfcarryhearingaidno: selfcarryhearingaidnochk,
                            alcoholtype: alcoholtypechk,
                            alcoholtime: alcoholtimechk,
                            alcoholvolume: alcoholvolumechk,
                            activestatus: '1',
                            remark: '',
                            createby: '',
                            createdate: '',
                            modifiedby: '',
                            modifieddate: ''



                        },
                        success: function (rs) {
                             
                            // alert("บันทึกข้อมูลเรียบร้อย");
                                swal.fire({
                                    title: "Good Job!",
                                    text: "บันทึกข้อมูลเรียบร้อย",
                                    icon: "success",
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                });
                                // alert(rs);   
                                setTimeout(() => {
                                    document.location.reload();
                                }, 1200);
                        }
                    });

                    }
                   
                    
                   
            }

            function save_selfcheck(chkstatus,checkClient,empchkgw)
            {
                    // alert(chkstatus);
                    // alert(checkClient);
                    //11111
                    var datejobstart = document.getElementById('txt_datedriverchk').value;
                    var dateworking  = document.getElementById('txt_dateworkingchk').value;
                    var datepresent  = document.getElementById('txt_datepresentchk').value;
                    var employeecode = document.getElementById('txt_empcode').value;
                    var employeename = document.getElementById('txt_empname').value;
                    var sessionid    = document.getElementById('txt_selfsession').value;
                    // alert(datejobstart);
                    // alert(timejobstart);
                    // alert(sessionid);
                    // เช็คการลงข้อมูลคอลัมย์ที่1
                    var self1yeschk = "";
                    var self1nochk = "";
                    var self2yeschk = "";
                    var self2nochk = "";
                    var self3yeschk = "";
                    var self3nochk = "";
                    var self4yeschk = "";
                    var self4nochk = "";
                    var self5yeschk = "";
                    var self5nochk = "";
                    var selfallyeschk = "";
                    var selfallnochk = "";
                    
                    //ประเมิณอาการเหนื่อยล้า
                    if($("#self1yes").is(':checked') || $("#self1no").is(':checked') ){
                        //alert("yes");
                         if($("#self1yes").is(':checked')){
                            self1yeschk = '1';
                            //alert('มีอาการเหนื่อยล้า');
                            //alert(self1yeschk);
                        } else {
                            self1nochk = '1';
                            //alert(self1nochk);
                            //alert('ไม่มีอาการเหนื่อยล้า');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'อาการเหนื่อยล้า'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'อาการเหนื่อยล้า'");
                        }
                        

                    }
                    
                    //ประเมิณอาการเจ็บป่วย
                    if($("#self2yes").is(':checked') || $("#self2no").is(':checked') ){
                        //alert("yes");
                         if($("#self2yes").is(':checked')){
                            self2yeschk = '1';
                            //alert('มีอาการเจ็บป่วย');
                        } else {
                            self2nochk = '1';
                            //alert('ไม่มีอาการเจ็บป่วย');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'อาการเจ็บป่วย'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'อาการเจ็บป่วย'");
                        }
                        

                    }

                    //ประเมิณอาการง่วงนอน
                    if($("#self3yes").is(':checked') || $("#self3no").is(':checked') ){
                        //alert("yes");
                         if($("#self3yes").is(':checked')){
                            self3yeschk = '1';
                            //alert('มีอาการง่วงนอน');
                        } else {
                            self3nochk = '1';
                            //alert('ไม่มีอาการง่วงนอน');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'อาการง่วงนอน'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'อาการง่วงนอน'");
                        }
                        
                    }

                    //ประเมิณอาการบาดเจ็บ
                    if($("#self4yes").is(':checked') || $("#self4no").is(':checked') ){
                        //("yes");
                         if($("#self4yes").is(':checked')){
                            self4yeschk = '1';
                            //('มีอาการบาดเจ็บ');
                            
                        } else {
                            self4nochk = '1';
                            //alert('ไม่มีอาการบาดเจ็บ');
                           
                        }
                    }else{
                        
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'อาการบาดเจ็บ'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'อาการบาดเจ็บ'");
                        }
                        

                    }

                    //ประเมิณทานยาที่มีผลต่อการขับขี่
                    if($("#self5yes").is(':checked') || $("#self5no").is(':checked') ){
                        //alert("yes");
                         if($("#self5yes").is(':checked')){
                            self5yeschk = '1';
                            //alert('ทานยาที่มีผลต่อการขับขี่');
                            // alert(self5yeschk);
                            // alert('ทานยา');
                        } else {
                            self5nochk = '1';
                            //alert('ไม่ทานยาที่มีผลต่อการขับขี่');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'ทานยาที่มีผลต่อการขับขี่'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'ทานยาที่มีผลต่อการขับขี่'");
                        }
                        

                    }

                    //ประเมิณสภาพร่างกาย
                    if($("#selfallyes").is(':checked') || $("#selfallno").is(':checked') ){
                        //alert("yes");
                         if($("#selfallyes").is(':checked')){
                            selfallyeschk = '1';
                            //alert('สภาพร่างกายปกติ');
                        } else {
                            selfallnochk = '1';
                            //alert('สภาพร่างกายไม่ปกติ');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'สภาพร่างกาย'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'สภาพร่างกาย'");
                        }
                        

                    }
                    
                    // เช็คการลงข้อมูลคอลัมย์ที่2 เวลาพักผ่อน 8 ชั่วโมง
                    // var dsreststart = document.getElementById('daysleep_reststart').value;
                    // var dsrestend = document.getElementById('daysleep_restend').value;
                    // var tsrest = document.getElementById('timesleep_rest').value;
                    
                    if (checkClient == 'MB') {
                        var dsreststart = document.getElementById('daysleep_reststart').value;
                        var dsrestend = document.getElementById('daysleep_restend').value;
                        var tsrest = document.getElementById('timesleep_rest').value;
                    }else{
                        // alert('else');
                        //START REST
                        var startrestchk = document.getElementById('daysleep_reststart').value;
                        var startrestdata1  = startrestchk.replace(" ","T"); // replave " " เป็น "T"
                        var startrestdata2  = startrestdata1.replace("/","-");
                        var startrestdata3  = startrestdata2.replace("/","-"); // replave "/" เป็น "-"
                        var dsreststart = startrestdata3;
                        
                        //END REST
                        var endrestchk = document.getElementById('daysleep_restend').value;
                        var endrestdata1  = endrestchk.replace(" ","T"); // replave " " เป็น "T"
                        var endrestdata2  = endrestdata1.replace("/","-");// replave "/" เป็น "-"
                        var endrestdata3  = endrestdata2.replace("/","-");
                        var dsrestend = endrestdata3;
                        
                        var tsrest = document.getElementById('timesleep_rest').value;
                        
                        // alert(dsreststart);
                        // alert(dsrestend);
                    }

                    //date rest start
                    if (dsreststart == '') {
                        dsreststartchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาเริ่มพักผ่อน(8 ชั่วโมง)');
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ลงข้อมูลเวลาเลิกงาน");
                        }else{
                            alert("ยังไม่ได้ลงข้อมูลเวลาเลิกงาน");
                        }
                    }else{
                        dsreststartchk = dsreststart;
                        //alert(dsnormalstartchk);
                    }
                    
                    //date rest end
                    if (dsrestend == '') {
                        dsrestendchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาตื่นพักผ่อน(8 ชั่วโมง)');
                    }else{
                        dsrestendchk = dsrestend;
                        //alert(dsrestendchk);
                    }

                    //time sleep rest 
                    if (tsrest == '') {
                        tsrestchk = "";
                        //alert('ยังไม่ได้ลงระยะเวลาที่พักผ่อน(8 ชั่วโมง)');
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ลงระยะเวลาที่พักผ่อน(8 ชั่วโมง)");
                        }else{
                            alert("ยังไม่ได้ลงระยะเวลาที่พักผ่อน(8 ชั่วโมง)");
                        }
                    }else{
                        tsrestchk = tsrest;
                        //alert(tsrestchk);
                    }

                    // เช็คการลงข้อมูลคอลัมย์ที่3 เวลาการนอนปกติ
                    // var dsnormalstart = document.getElementById('daysleep_normalstart').value;
                    // var dsnormalend = document.getElementById('daysleep_normalend').value;
                    // var tsnormal = document.getElementById('timesleep_normal').value;
                    var selfsleepnormalyeschk = "";
                    var selfsleepnormalnochk = "";

                    if (checkClient == 'MB') {
                        var dsnormalstart = document.getElementById('daysleep_normalstart').value;
                        var dsnormalend = document.getElementById('daysleep_normalend').value;
                        var tsnormal = document.getElementById('timesleep_normal').value;
                    }else{
                        // alert('else');
                        //START NORMALSLEEP
                        var startnormalchk = document.getElementById('daysleep_normalstart').value;
                        var startnormaldata1  = startnormalchk.replace(" ","T"); // replave " " เป็น "T"
                        var startnormaldata2  = startnormaldata1.replace("/","-");
                        var startnormaldata3  = startnormaldata2.replace("/","-"); // replave "/" เป็น "-"
                        var dsnormalstart = startnormaldata3;
                        
                        //END NORMALSLEEP
                        var endnormalchk = document.getElementById('daysleep_normalend').value;
                        var endnormaldata1  = endnormalchk.replace(" ","T"); // replave " " เป็น "T"
                        var endnormaldata2  = endnormaldata1.replace("/","-");// replave "/" เป็น "-"
                        var endnormaldata3  = endnormaldata2.replace("/","-");
                        var dsnormalend = endnormaldata3;
                        
                        var tsnormal = document.getElementById('timesleep_normal').value;
                        
                        // alert(dsnormalstart);
                        // alert(dsnormalend);
                    }
                    
                    //date normal start
                    if (dsnormalstart == '') {
                        dsnormalstartchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาเริ่มพักผ่อน(ปกติ)');
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ลงข้อมูลเวลาเริ่มนอน(ปกติ)");
                        }else{
                            alert("ยังไม่ได้ลงข้อมูลเวลาเริ่มนอน(ปกติ)");
                        }
                    }else{
                        dsnormalstartchk = dsnormalstart;
                        //alert(dsnormalstartchk);
                    }
                    
                    //date normal end
                    if (dsnormalend == '') {
                        dsnormalendchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาตื่นพักผ่อน(ปกติ)');
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ลงข้อมูลเวลาตื่นนอน(ปกติ)");
                        }else{
                            alert("ยังไม่ได้ลงข้อมูลเวลาตื่นนอน(ปกติ)");
                        }
                    }else{
                        dsnormalendchk = dsnormalend;
                        //alert(dsnormalendchk);
                    }

                    //time sleep normal 
                    if (tsnormal == '') {
                        tsnormalchk = "";
                        //alert('ยังไม่ได้ลงระยะเวลาที่นอน(ปกติ)');
                    }else{
                        tsnormalchk = tsnormal;
                        //alert(tsnormalchk);
                    }

                    //ประเมินการนอนปกติ
                    if($("#selfnormalsleepyes").is(':checked') || $("#selfnormalsleepno").is(':checked') ){
                        //alert("yes");
                         if($("#selfnormalsleepyes").is(':checked')){
                            selfsleepnormalyeschk = '1';
                            //alert('การนอนปกติ(หลับสนิท)');
                        } else {
                            selfsleepnormalnochk = '1';
                            //alert('การนอนปกติ(หลับไม่สนิท)');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'การนอนปกติ'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'การนอนปกติ'");
                        }
                        //alert("ยังไม่ได้ประเมิน 'การนอนปกติ'");

                    }

                    // เช็คการลงข้อมูลคอลัมย์ที่3 เวลาการนอนเพิ่มเติม
                    // var dsextrastart = document.getElementById('daysleep_extrastart').value;
                    // var dsextraend = document.getElementById('daysleep_extraend').value;
                    // var tsextra = document.getElementById('timesleep_extra').value;
                    var selfsleepextrayeschk = "";
                    var selfsleepextranochk = "";
                    
                    if (checkClient == 'MB') {
                        var dsextrastart = document.getElementById('daysleep_extrastart').value;
                        var dsextraend = document.getElementById('daysleep_extraend').value;
                        var tsextra = document.getElementById('timesleep_extra').value;
                    }else{
                        // alert('else');
                        //START NORMALSLEEP
                        var startextrachk = document.getElementById('daysleep_extrastart').value;
                        var startextradata1  = startextrachk.replace(" ","T"); // replave " " เป็น "T"
                        var startextradata2  = startextradata1.replace("/","-");
                        var startextradata3  = startextradata2.replace("/","-"); // replave "/" เป็น "-"
                        var dsextrastart = startextradata3;

                        //END NORMALSLEEP
                        var endextrachk = document.getElementById('daysleep_extraend').value;
                        var endextradata1  = endextrachk.replace(" ","T"); // replave " " เป็น "T"
                        var endextradata2  = endextradata1.replace("/","-");// replave "/" เป็น "-"
                        var endextradata3  = endextradata2.replace("/","-");
                        var dsextraend = endextradata3;
                        
                        var tsextra = document.getElementById('timesleep_extra').value;
                        
                        // alert(dsextrastart);
                        // alert(dsextraend);
                    }

                    //date extra start
                    if (dsextrastart == '') {
                        dsextrastartchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาเริ่มพักผ่อน(กะกลางคืน)');
                    }else{
                        dsextrastartchk = dsextrastart;
                        //alert(dsextrastartchk);
                    }
                    
                    //date extra end
                    if (dsextraend == '') {
                        dsextraendchk = "";
                        //alert('ยังไม่ได้ลงข้อมูลเวลาตื่นพักผ่อน(กะกลางคืน)');
                    }else{
                        dsextraendchk = dsextraend;
                        //alert(dsextraendchk);
                    }

                    //time sleep extra 
                    if (tsextra == '') {
                        tsextrachk = "";
                        //alert('ยังไม่ได้ลงระยะเวลาที่นอน(กะกลางคืน)');
                    }else{
                        tsextrachk = tsextra;
                        //alert(tsextrachk);
                    }

                    //ประเมินการนอนเพิ่ม
                    if($("#selfextrasleepyes").is(':checked') || $("#selfextrasleepno").is(':checked') ){
                        //alert("yes");
                         if($("#selfextrasleepyes").is(':checked')){
                            selfsleepextrayeschk = '1';
                            //alert('การนอนกะกลางคืน(หลับสนิท)');
                        } else {
                            selfsleepextranochk = '1';
                            //alert('การนอนกะกลางคืน(หลับไม่สนิท)');
                        }
                    }else{
                        //alert("ยังไม่ได้ประเมิน 'การนอนกะกลางคืน'");

                    }

                    // เช็คการลงข้อมูลคอลัมย์ที่4
                    var disease = document.getElementById('disease').value;
                    var drugname = document.getElementById('drug_name').value;
                    var drugtime = document.getElementById('drug_time').value;
                    var selfdoctoryeschk = "";
                    var selfdoctornochk = "";
                    //อาการป่วย

                    //date extra start
                    if (disease == '') {
                        diseasechk = "";
                        //alert('ยังไม่ได้ลงข้อมูลโรค');
                    }else{
                        diseasechk = disease;
                        //alert(diseasechk);
                    }

                    //ประเมินการพบหมอ
                    if($("#selfdoctoryes").is(':checked') || $("#selfdoctorno").is(':checked') ){
                        //alert("yes");
                         if($("#selfdoctoryes").is(':checked')){
                            selfdoctoryeschk = '1';
                            //alert('พบหมอ');
                        } else {
                            selfdoctornochk = '1';
                            //alert('ไม่ได้พบหมอ');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'พบหมอ'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'พบหมอ'");
                        }
                        //alert("ยังไม่ได้ประเมิน 'พบหมอ'");

                    }

                    //drug name
                    if (drugname == '') {
                        drugnamechk = "";
                        //alert('ยังไม่ได้ลงข้อมูลชื่อยา');
                    }else{
                        drugnamechk = drugname;
                        //alert(drugnamechk);
                    }

                    // //time sleep extra 
                    drugtimechk = drugtime;
                    //alert(drugtimechk);
                    
                    // if (drugtime == '') {
                    //     drugtimechk = "";
                    //     alert('ยังไม่ได้ลงเวลาทานยา');
                    // }else{
                    //     drugtimechk = drugtime;
                    //     alert(drugtimechk);
                    // }

                    
                    // เช็คการลงข้อมูลคอลัมย์ที่5
                    var selfworryyeschk = "";
                    var selfworrynochk = "";
                    var selfhouseholdyeschk = "";
                    var selfhouseholdnochk = "";

                    //ประเมินเรื่องกังวลใจ / การใช้เวลาช่วงพักผ่อน
                    //เรื่องกังวลใจ
                    if($("#selfworryyes").is(':checked') || $("#selfworryno").is(':checked') ){
                        //alert("yes");
                         if($("#selfworryyes").is(':checked')){
                            selfworryyeschk = '1';
                            //alert('มีเรื่องกังวลใจ');
                        } else {
                            selfworrynochk = '1';
                            //alert('ไม่มีเรื่องกังวลใจ');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'เรื่องกังวลใจ'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'เรื่องกังวลใจ'");
                        }
                        

                    }
                    // การใช้เวลาช่วงพักผ่อน
                    if($("#selfhouseholdyes").is(':checked') || $("#selfhouseholdno").is(':checked') ){
                       // alert("yes");
                         if($("#selfhouseholdyes").is(':checked')){
                            selfhouseholdyeschk = '1';
                            //alert('ใช้ช่วงเวลาพักผ่อนในบ้าน');
                        } else {
                            selfhouseholdnochk = '1';
                            //alert('ใช้ช่วงเวลาพักผ่อนนอกบ้าน');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'การใช้ช่วงเวลาพักผ่อน'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'การใช้ช่วงเวลาพักผ่อน'");
                        }
                        

                    }

                    // เช็คการลงข้อมูลคอลัมย์ที่6
                    var tempchk = document.getElementById('temperature').value;
                    var syschk1 = document.getElementById('sys_value1').value;
                    var syschk2 = document.getElementById('sys_value2').value;
                    var syschk3 = document.getElementById('sys_value3').value;
                    var diachk1 = document.getElementById('dia_value1').value;
                    var diachk2 = document.getElementById('dia_value2').value;
                    var diachk3 = document.getElementById('dia_value3').value;
                    var pulsechk1 = document.getElementById('pulse_value1').value;
                    var pulsechk2 = document.getElementById('pulse_value2').value;
                    var pulsechk3 = document.getElementById('pulse_value3').value;
                    var oxygenchk = document.getElementById('oxygen_value').value;
                    
                    //ประเมินอุณภูมิ ความดันบน ความดันล่าง
                    
                    // //ประเมินอุณภูมิ 
                    // if (temp == '') {
                    //     tempchk = "";
                    //     alert('ยังไม่ได้ลงข้อมูลอุณภูมิ');
                    // }else{
                    //     tempchk = temp;
                    //     //alert(tempchk);
                    // }

                    // //ความดันบน ความดันล่าง
                    // if (sys == '') {
                    //     syschk = "";
                    //     alert('ยังไม่ได้ลงข้อมูลความดันบน');
                    // }else{
                    //     syschk = sys;
                    //     //alert(syschk);
                    // }

                    // //ความดันล่าง
                    // if (dia == '') {
                    //     diachk = "";
                    //     alert('ยังไม่ได้ลงข้อมูลความดันล่าง');
                    // }else{
                    //     diachk = dia;
                    //     //alert(diachk);
                    // }
                    
                    // เช็คการลงข้อมูลคอลัมย์ที่7
                    var selfeyeproblemyeschk = "";
                    var selfeyeproblemnochk = "";
                    var selfeyeglassesyeschk = "";
                    var selfeyeglassesnochk = "";
                    var selfcarryeyeglassesyeschk = "";
                    var selfcarryeyeglassesnochk = "";
                    var selfcarryhearingaidyeschk = "";
                    var selfcarryhearingaidnochk = "";

                    //ปัญหาสายตา/แว่นสายตา
                    //ปัญหาสายตา
                    if($("#selfeyeproblemyes").is(':checked') || $("#selfeyeproblemno").is(':checked') ){
                        //alert("yes");
                         if($("#selfeyeproblemyes").is(':checked')){
                            selfeyeproblemyeschk = '1';
                            //alert(',มีปัญหาสายตา');
                        } else {
                            selfeyeproblemnochk = '1';
                            //alert('ไม่มีปัญหาสายตา');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'ปัญหาสายตา'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'ปัญหาสายตา'");
                        }
                        

                    }    
                    // แว่นสายตา
                    if($("#selfeyeglassesyes").is(':checked') || $("#selfeyeglassesno").is(':checked') ){
                       // alert("yes");
                         if($("#selfeyeglassesyes").is(':checked')){
                            selfeyeglassesyeschk = '1';
                            //alert('มีแว่นสายตา');
                        } else {
                            selfeyeglassesnochk = '1';
                            //alert('ไม่มีแว่นสายตา');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'สวมใส่แว่นสายตา'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'สวมใส่แว่นสายตา'");
                        }
                        

                    }
                    // สวมใส่เครื่องช่วยฟัง
                    if($("#selfcarryhearingaidyes").is(':checked') || $("#selfcarryhearingaidno").is(':checked') ){
                       // alert("yes");
                         if($("#selfcarryhearingaidyes").is(':checked')){
                            selfcarryhearingaidyeschk = '1';
                            //alert('มีแว่นสายตา');
                        } else {
                            selfcarryhearingaidnochk = '1';
                            //alert('ไม่มีแว่นสายตา');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            alert("ยังไม่ได้ประเมิน 'สวมใส่เครื่องช่วยฟัง'");
                        }else{
                            alert("ยังไม่ได้ประเมิน 'สวมใส่เครื่องช่วยฟัง'");
                        }
                        

                    }
                    // พกพาแว่นสายตา
                    if($("#selfcarryeyeglassesyes").is(':checked') || $("#selfcarryeyeglassesno").is(':checked') ){
                       // alert("yes");
                         if($("#selfcarryeyeglassesyes").is(':checked')){
                            selfcarryeyeglassesyeschk = '1';
                            //alert('มีแว่นสายตา');
                        } else {
                            selfcarryeyeglassesnochk = '1';
                            //alert('ไม่มีแว่นสายตา');
                        }
                    }else{
                        if (empchkgw == '04'  || empchkgw == '09' || empchkgw == '10') {
                            // alert("ยังไม่ได้ประเมิน 'พกแว่นสายตา'");
                        }else{
                            // alert("ยังไม่ได้ประเมิน 'พกแว่นสายตา'");
                        }
                        

                    }
                    

                    // เช็คการลงข้อมูลคอลัมย์ที่8
                    var alcoholtype = document.getElementById('alcohol_type').value;
                    var alcoholtime = document.getElementById('alcohol_time').value;
                    var alcoholvolume = document.getElementById('alcohol_volume').value;
                    //ประเมินแอลกอฮอล์ เวลาเลิก ปริมาณ

                    // alert('alcohol volume')
                    // alert(alcoholvolume);
                    //ประเมินแอลกอฮอล์ 
                    if (alcoholtype == '') {
                        alcoholtypechk = "";
                        //alert('ยังไม่ได้ลงข้อมูลแอลกอฮอล์');
                    }else{
                        alcoholtypechk = alcoholtype;
                        //alert(alcoholtypechk);
                    }

                    //เวลาเลิก
                    alcoholtimechk = alcoholtime;
                    //alert(alcoholtimechk);
                    // if (alcoholtime == '') {
                    //     alcoholtimechk = "";
                    //     alert('ยังไม่ได้ลงข้อมูลเวลาเลิก');
                    // }else{
                    //     alcoholtimechk = alcoholtime;
                    //     alert(alcoholtimechk);
                    // }

                    //ปริมาณ
                    if (alcoholvolume == '') {
                        alcoholvolumechk = "";
                        // alert('ยังไม่ได้ลงข้อมูลปริมาณแอลกอฮอล์');
                    }else{
                        alcoholvolumechk = alcoholvolume;
                        // alert('alcohol volumechk')
                        // alert(alcoholvolumechk);
                    }

                    var selfchkid = document.getElementById('txt_selfchkid').value


                    if (selfchkid != '') {
                        // alert('update');
                        
                        $.ajax({
                        type: 'post',
                        url: 'meg_data2.php',
                        data: {
                            
                            txt_flg: "update_selfcheckdetail",
                            id:selfchkid, 
                            employeecode: employeecode,
                            employeename: employeename, 
                            datejobstart: datejobstart,
                            dateworking: dateworking,
                            datepresent: datepresent,
                            tierdyeschk: self1yeschk,
                            tierdnochk: self1nochk,
                            illnessyeschk: self2yeschk,
                            illnessnochk: self2nochk,
                            drowseyeschk: self3yeschk,
                            drowsenochk: self3nochk,
                            injuryyeschk: self4yeschk,
                            injurynochk: self4nochk,
                            takemedicineyeschk: self5yeschk,
                            takemedicinenochk: self5nochk, 
                            healthyyeschk: selfallyeschk, 
                            healthynochk: selfallnochk,
                            sleepreststart: dsreststartchk,
                            sleeprestend: dsrestendchk,
                            timesleeprest: tsrestchk,
                            sleepnormalstart: dsnormalstartchk,
                            sleepnormalend: dsnormalendchk,
                            timesleepnormal: tsnormalchk,
                            sleepnormalyes: selfsleepnormalyeschk,
                            sleepnormalno: selfsleepnormalnochk,
                            sleepextrastart: dsextrastartchk,
                            sleepextraend: dsextraendchk,
                            timesleepextra: tsextrachk,
                            sleepextrayes: selfsleepextrayeschk,
                            sleepextrano: selfsleepextranochk,
                            disease: diseasechk,
                            seedoctoryes: selfdoctoryeschk,
                            seedoctorno: selfdoctornochk,
                            drugname: drugnamechk,
                            drugtime: drugtimechk,
                            worryyes: selfworryyeschk,
                            worryno: selfworrynochk,
                            householdyes: selfhouseholdyeschk,
                            householdno: selfhouseholdnochk,
                            temperature: tempchk,
                            sysvalue1: syschk1,
                            sysvalue2: syschk2,
                            sysvalue3: syschk3,
                            diavalue1: diachk1,
                            diavalue2: diachk2,
                            diavalue3: diachk3,
                            pulsevalue1: pulsechk1,
                            pulsevalue2: pulsechk2,
                            pulsevalue3: pulsechk3,
                            oxygenvalue:oxygenchk,
                            eyeproblemyes: selfeyeproblemyeschk,
                            eyeproblemno: selfeyeproblemnochk,
                            selfeyeglassesyes: selfeyeglassesyeschk,
                            selfeyeglassesno: selfeyeglassesnochk,
                            selfcarryeyeglassesyes: selfcarryeyeglassesyeschk,
                            selfcarryeyeglassesno: selfcarryeyeglassesnochk,
                            selfcarryhearingaidyes: selfcarryhearingaidyeschk,
                            selfcarryhearingaidno: selfcarryhearingaidnochk,
                            alcoholtype: alcoholtypechk,
                            alcoholtime: alcoholtimechk,
                            alcoholvolume: alcoholvolumechk,
                            activestatus: '1',
                            remark: '',
                            createby: employeecode,
                            createdate: '',
                            modifiedby: sessionid,
                            modifieddate: ''



                        },
                        success: function (rs) {
                            
                            // alert("ยืนยันและแก้ไขข้อมูลเรียบร้อย");
                            commitupdate_selfcheck(selfchkid);
                            swal.fire({
                                title: "Good Job!",
                                text: "ยืนยันและแก้ไขข้อมูลเรียบร้อย",
                                icon: "success",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            // alert(rs);    
                            setTimeout(() => {
                                document.location.reload();
                            }, 1500);
                        }
                    });

                    }else{
                        // alert('save');
                        swal.fire({
                            title: "warning",
                            text: "ไม่มีหมายเลข SelfcheckID !!",
                            icon: "warning",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });

                    }
                   
                    
                   
                }
                function commitupdate_selfcheck(selfchkid){

                    // alert("commit and update selfcheck");

                    var temp = document.getElementById("temperature").value;
                    var sysvalue1 = document.getElementById("sys_value1").value;
                    var sysvalue2 = document.getElementById("sys_value2").value;
                    var sysvalue3 = document.getElementById("sys_value3").value;
                    var diavalue1 = document.getElementById("dia_value1").value;
                    var diavalue2 = document.getElementById("dia_value2").value;
                    var diavalue3 = document.getElementById("dia_value3").value;
                    var pulsevalue1 = document.getElementById("pulse_value1").value;
                    var pulsevalue2 = document.getElementById("pulse_value2").value;
                    var pulsevalue3 = document.getElementById("pulse_value3").value;
                    var oxygenvalue = document.getElementById("oxygen_value").value;
                    var alcoholvalue = document.getElementById("alcohol_volume").value;

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
                    
                    if (selfchkid == '') {
                        // alert("ยังไม่มีการแจ้งสุขภาพตนเองของพนักงาน กรุณาตรวจสอบข้อมูล!!");
                        swal.fire({
                            title: "warning",
                            text: "ยังไม่มีการแจ้งสุขภาพตนเองของพนักงาน กรุณาตรวจสอบข้อมูล!!",
                            icon: "warning",
                        });
                    }else{
                        $.ajax({
                            url: 'meg_data2.php',
                            type: 'POST',
                            data: {
                                txt_flg: "commitupdate_selfcheck", 
                                selfcheckid: selfchkid,
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
                                oxygenvalue: oxygenvalue,
                                alcoholvalue: alcoholvalue
                            },
                            success: function () {

                            }
                        }); 
                    }
                }
            

        </script>






    </body>

</html>
<?php
sqlsrv_close($conn);
?>