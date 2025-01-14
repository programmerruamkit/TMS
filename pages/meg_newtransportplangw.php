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

$employee1 = " AND a.PersonCode = '" .$_SESSION["USERNAME"] . "'";
$sql_seEmp1 = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmp1 = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($employee1, SQLSRV_PARAM_IN)
);
$query_seEmp1 = sqlsrv_query($conn, $sql_seEmp1, $params_seEmp1);
$result_seEmp1 = sqlsrv_fetch_array($query_seEmp1, SQLSRV_FETCH_ASSOC);

// วันที่และเวลาปัจจุบัน 
// $CURRENTDATESHOW1 คือเวลาที่แสดงบนหน้าจอ รูปแบบ Y/m/d H:i Ex 2022/11/21 08:58
// $CURRENTDATE1 คือ เวลาตามฟอแมทที่จะนำปคำนวณ รูปแบบ Y-m-dTH:i Ex 2022-11-21T08:58
$CURRENTDATE1 = date("Y-m-d") ."T". date("H:i");
$CURRENTDATESHOW1 = date("Y-m-d") ." ". date("H:i");  

// $sql_seSystime = "{call megGetdate_v2(?)}";
// $params_seSystime = array(
//     array('select_getdate', SQLSRV_PARAM_IN)
// );
// $query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
// $result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);



// $condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
// $sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
// $params_seEmployee = array(
//     array('select_employeeehr2', SQLSRV_PARAM_IN),
//     array($condition1, SQLSRV_PARAM_IN)
// );
// $query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
// $result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);


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
        <!-- <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet"> -->
        <!--<link href="../dist/css/sb-admin-2.css" rel="stylesheet">-->
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        <link href="../js/bootstrap-datepicker.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
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
            
            .swal2-popup {
                font-size: 16px !important;
                padding: 17px;
                border: 1px solid #F0E1A1;
                display: block;
                margin: 22px;
                text-align: center;
                color: #61534e;
            }
            /* Thick red border */
            hr.hr1 {
                border: 2px solid gray;
                /* border-radius: 5px; */
            }
            
        </style>
    </head>
    <body>

        <div id="wrapper">
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
                <!-- เช็คกรณี session close จะ redirect ให้ไป Login ใหม่ -->
                <?php
                    if ($_SESSION["USERNAME"] != "") {
                        ?>
                            <?php
                             $empchk = substr($_SESSION['USERNAME'],0,2);
                            //  echo $empchk;
                             if ($empchk =='01' || $empchk =='02' || $empchk =='07' || $empchk =='06') {
                            ?>
                                 <script>
                                    swal.fire({
                                        title: 'Warning!',
                                        text: 'ไม่มีสิทธิ์ใช้งานเมนูนี้ !!',
                                        icon: 'warning',
                                        showConfirmButton: false,
                                    });
                                    setTimeout(() => {
                                        // document.location.reload();
                                        window.location.href = 'index.php';
                                    }, 1100);
                                    // alert('Session Close');
                                    // window.location.href = 'meg_login.php';
                                    //window.close();
                                </script>
                            <?php
                             }else{
                            ?>

                            <?php
                             }
                            ?>

                        <?php
                    } else {
                        ?>
                        <script>
                            
                            swal.fire({
                                title: 'Warning!',
                                text: 'Session Close',
                                icon: 'warning',
                                showConfirmButton: false,
                            });
                            setTimeout(() => {
                                // document.location.reload();
                                window.location.href = 'meg_login.php';
                            }, 1100);
                            // alert('Session Close');
                            // window.location.href = 'meg_login.php';
                            //window.close();
                        </script>
                        
                        <?php
                    }
                ?>
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
           

            <div id="page-wrapper">
                
                <!-- <input disabled="" class="form-control" style="display:none"  placeholder="currenttime"      type="text" id="txt_copydiagramdateinput" name="txt_copydiagramdateinput" value="<?= $result_seSystime['SYSTIME'] ?>"    > -->
                <input disabled="" class="form-control" style="display:none"  placeholder="companycode"      type="text" id="txt_copydiagramcompany"   name="txt_copydiagramcompany"   maxlength="500" value="<?= $_GET['companycode'] ?>" >
                <input disabled="" class="form-control" style="display:none"  placeholder="customercode"     type="text" id="txt_copydiagramcustomer"  name="txt_copydiagramcustomer"  maxlength="500" value="<?= $_GET['customercode'] ?>" >
                <input disabled="" class="form-control" style="display:none"  placeholder="load"             type="text" id="txt_load" name="txt_load" maxlength="500" value="" >
                <input disabled="" class="form-control" style="display:none"  placeholder="current datetime" type="text" id="txt_currentdate" name="txt_currentdate" maxlength="500" value="<?= date("H:i:s") ?>" >

                <div id="datade_edit">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                <a href='index.php'>หน้าแรก</a> / เพิ่มข้อมูลแผนการวิ่งงาน(ปกติ)
                                </div>
                                <input  class="form-control" type="hidden" id="txt_username" name="txt_username" value="<?=$_SESSION["USERNAME"]?>">
                                <div id="datadef_edit">
                                    <div class="panel-body">
                                        <!-- START ROW1 -->
                                        <div class="row" >
                                            <!-- START COLUMN1 -->
                                            <div class="col-lg-12" >
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #f0c402;text-align: left;">
                                                        <label><font style="font-size: 16px;">ลงข้อมูลแผนงาน <br>พนักงานขับรถ: (<?=$result_seEmp1['nameT']?>)</font></label>
                                                    </div>
                                                    <input  class="form-control" style="display: none" type="text" id="txt_username" name="txt_username" value="<?=$_SESSION["USERNAME"]?>">
                                                    <div class="panel-body">
                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                            <!-- START ROW1 -->
                                                            <div class = "row">
                                                                <div class="">
                                                                    <div class="form-group" >
                                                                        <!-- <div class="col-lg-12" style="text-align: center;" >
                                                                            <label style="font-size: 20px;"><font color="black">เลือกลักษณะแผนงาน</font></label><br><br>
                                                                            <input type="checkbox"   <?=$rsgroup1AD1?> class="group1D1" onchange="edit_telAD1('1', '2')"  style="transform: scale(3)" id="chk_rsnm" name="chk_rsnm" />&nbsp;&nbsp;&nbsp;&nbsp;<b><font style="font-size: 20px;">[NM]</font></b>
                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                            <input type="checkbox"  <?=$rsgroup1AD1?> class="group1D1" onchange="edit_telAD1('1', '2')"  style="transform: scale(3)" id="chk_rssh" name="chk_rssh" />&nbsp;&nbsp;&nbsp;&nbsp;<b><font style="font-size: 20px;">[SH]</font></b>
                                                                            <br><br><br><br>
                                                                        </div> -->
                                                                        <div class="col-lg-12" style="text-align: left;" >
                                                                            <label style="font-size: 16px;"><font color="red">เครื่องหมาย ( * ) หมายถึง ข้อมูลจำเป็นที่ต้องลงข้อมูล</font></label>
                                                                        </div>
                                                                        
                                                                        <!-- <div class="col-lg-2">
                                                                            <label style="font-size: 16px;">พขร.(2) :</label>
                                                                            <div class="dropdown bootstrap-select show-tick form-control">
                                                                                <select   id="txt_drivercode2" name="txt_drivercode2" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พขร.(2)..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                    <?php
                                                                                    // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                                                                    $sql_seName = "{call megEmployeeEHR_v2(?,?)}";
                                                                                    $params_seName = array(
                                                                                        array('select_employeeehr2', SQLSRV_PARAM_IN),
                                                                                        array('', SQLSRV_PARAM_IN)
                                                                                    );
                                                                                    $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
                                                                                    while ($result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC)) {
                                                                                        ?>
                                                                                        <option value="<?= $result_seName['nameT'] ?>"><?= $result_seName['nameT'] ?> (<?= $result_seName['PersonCode'] ?>)</option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div> -->
                                                                        <div class="col-lg-2" hidden>
                                                                            <label style="font-size: 16px;">ผู้ควบคุม :</label>
                                                                            <div class="dropdown bootstrap-select show-tick form-control">
                                                                                <select   id="txt_controller" name="txt_controller" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ผู้ควบคุม..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                    <?php
                                                                                    // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                                                                    $sql_seName = "{call megEmployeeEHR_v2(?,?)}";
                                                                                    $params_seName = array(
                                                                                        array('select_employeeehr2', SQLSRV_PARAM_IN),
                                                                                        array('', SQLSRV_PARAM_IN)
                                                                                    );
                                                                                    $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
                                                                                    while ($result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC)) {
                                                                                        ?>
                                                                                        <option value="<?= $result_seName['nameT'] ?>"><?= $result_seName['nameT'] ?> (<?= $result_seName['PersonCode'] ?>)</option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                                <!-- <input class="form-control" style="display: none"   id="txt_controller" name="txt_controller" maxlength="500" value="" > -->
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            <?php
                                                                            if ($checkClient == 'MB' || $checkClient == 'DT') { //สำหรับมือถือ
                                                                                ?>
                                                                                <label style="font-size: 16px;">วันที่และเวลารายงานตัว</label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font><br>
                                                                                <input disabled="" type="datetime-local" my-date="" my-date-format="DD/MM/YYYY, hh:mm:ss" style="height:33px; width:300px" id="txt_datepresent" name="txt_datepresent" value="<?=$CURRENTDATESHOW1?>" min="" max=""   autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP
                                                                                // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                // $DATERESTEND1 = str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                // $DATERESTEND = str_replace("-","/",$DATERESTEND1);
                                                                            ?> 
                                                                                <label style="font-size: 16px;">วันที่และเวลาวิ่งงาน</label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font><br>
                                                                                <input  disabled="" class="form-control dateen" style="height:33px; width:300px" id="txt_datepresent" name="txt_datepresent" value="<?=$CURRENTDATESHOW1?>" min="" max=""  autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            <?php
                                                                            if ($checkClient == 'MB' || $checkClient == 'DT') { //สำหรับมือถือ
                                                                                ?>
                                                                                <label style="font-size: 16px;">วันที่และเวลารับงานตามไดอะแกรม</label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font><br>
                                                                                <input type="datetime-local" my-date="" my-date-format="DD/MM/YYYY, hh:mm:ss" style="height:33px; width:300px" id="txt_datetenko" name="txt_datetenko" value="<?=$CURRENTDATESHOW1?>" min="" max=""   autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP
                                                                                // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                // $DATERESTEND1 = str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                // $DATERESTEND = str_replace("-","/",$DATERESTEND1);
                                                                            ?> 
                                                                                <label style="font-size: 16px;">วันที่และเวลารับงานตามไดอะแกรม</label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font><br>
                                                                                <input class="form-control dateen" style="height:33px; width:300px" id="txt_datetenko" name="txt_datetenko" value="<?=$CURRENTDATESHOW1?>" min="" max=""  autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                        <div class="col-lg-2">
                                                                            <label style="font-size: 16px;">เบอร์รถ:</label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font>
                                                                            <div class="dropdown bootstrap-select show-tick form-control">
                                                                                <select   id="txt_thainame" name="txt_thainame" onchange="select_thainame()" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก เบอร์รถ..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                    <!-- <?php
                                                                                    // ปรับเงื่อนไขเลือกทะเบียน หัวพ่วงแทนการเลือกทะเบียนหางพ่วง
                                                                                    // $condithainame1 = " AND a.THAINAME != '-' AND (a.ENGNAME  LIKE 'R-%' OR a.ENGNAME  LIKE 'RA-%') AND a.ENGNAME NOT LIKE '%(4L)%' ORDER BY a.ENGNAME ASC";
                                                                                    $condithainame1 = " AND a.THAINAME != '-' 
                                                                                                        AND a.THAINAME != '--' 
                                                                                                        AND a.REGISTYPE = 'ทะเบียนหัว' 
                                                                                                        AND (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%') 
                                                                                                        ORDER BY THAINAME,VEHICLEINFOID ASC ";
                                                                                    
                                                                                    $sql_seThainame = "{call megVehicleinfo_v2(?,?,?,?,?)}";
                                                                                    $params_seThainame = array(
                                                                                        array('selectcond_vehicleinfo', SQLSRV_PARAM_IN),
                                                                                        array($condithainame1, SQLSRV_PARAM_IN),
                                                                                        array('', SQLSRV_PARAM_IN),
                                                                                        array('', SQLSRV_PARAM_IN),
                                                                                        array('', SQLSRV_PARAM_IN)
                                                                                    );
                                                                                    $query_seThainame = sqlsrv_query($conn, $sql_seThainame, $params_seThainame);
                                                                                    while ($result_seThainame = sqlsrv_fetch_array($query_seThainame, SQLSRV_FETCH_ASSOC)) {
                                                                                        // echo $result_seThainame['ENGNAME'];
                                                                                        ?>
                                                                                        <option value="<?= $result_seThainame['ENGNAME'] ?>"><?= str_replace("(4L)","",$result_seThainame['ENGNAME']); ?></option>
                                                                                        <?php
                                                                                    }
                                                                                    ?> -->

                                                                                    <?php
                                                                                    $sql_seThainame = "SELECT a.VEHICLEINFOID, a.VEHICLEREGISNUMBER, a.THAINAME,a.REGISTYPE,AFFCUSTOMER
                                                                                            FROM VEHICLEINFO a
                                                                                            WHERE a.ACTIVESTATUS = 1
                                                                                            AND a.THAINAME != '-' 
                                                                                            AND a.THAINAME != '--'
                                                                                            AND a.REGISTYPE = 'ทะเบียนหัว'
                                                                                            AND (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%')
                                                                                            AND a.AFFCUSTOMER ='TTT'
                                                                                            ORDER BY THAINAME,VEHICLEINFOID ASC";
                                                                                    $params_seThainame = array();
                                                                                    $query_seThainame = sqlsrv_query($conn, $sql_seThainame, $params_seThainame);
                                                                                    while ($result_seThainame = sqlsrv_fetch_array($query_seThainame, SQLSRV_FETCH_ASSOC)) {
                                                                                        ?>
                                                                                        <option value="<?= $result_seThainame['THAINAME'] ?>"><?= str_replace("(4L)","",$result_seThainame['THAINAME']); ?></option>
                                                                                        
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                                <input class="form-control" style="display: none"   id="txt_thainame" name="txt_thainame" maxlength="500" value="" >
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <!-- END ROW1 -->
                                                            <hr class="hr1">
                                                            <!-- START ROW2 -->
                                                            <div class = "row">
                                                                <div class="">
                                                                    <div class="form-group" >
                                                                        <div class="col-lg-12" style="text-align: left;" >
                                                                            <label style="font-size: 16px;"><font color="black"><u>รอบวิ่งงานที่1</u></font></label><br><br>
                                                                        </div>
                                                                        <div class="col-lg-2">
                                                                            <label style="font-size: 16px;">พขร.(1) :</label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font>
                                                                            <div class="dropdown bootstrap-select show-tick form-control">
                                                                                <!-- <select   id="txt_drivercode1_job1" name="txt_drivercode1_job1" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พขร.(1)..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                    
                                                                                    <?php
                                                                                    // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                                                                    $sql_seName = "{call megEmployeeEHR_v2(?,?)}";
                                                                                    $params_seName = array(
                                                                                        array('select_employeeehr2', SQLSRV_PARAM_IN),
                                                                                        array('', SQLSRV_PARAM_IN)
                                                                                    );
                                                                                    $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
                                                                                    while ($result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC)) {
                                                                                        ?>
                                                                                        <option value="<?= $result_seName['nameT'] ?>"><?= $result_seName['nameT'] ?> (<?= $result_seName['PersonCode'] ?>)</option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select> -->
                                                                                <input disabled="" class="form-control" type="text" style=""   id="txt_drivercode1_job1" name="txt_drivercode1_job1" maxlength="500" value="<?=$result_seEmp1['nameT']?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2">
                                                                            <label style="font-size: 16px;">พขร.(2) :</label><font style="color: red;font-size: 14px;"><b>ลงข้อมูลกรณีมี พขร.(2)</b></font>
                                                                            <div class="dropdown bootstrap-select show-tick form-control">
                                                                                <select   id="txt_drivercode2_job1" name="txt_drivercode2_job1" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พขร.(2)..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                    <?php
                                                                                    // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                                                                    $sql_seName = "{call megEmployeeEHR_v2(?,?)}";
                                                                                    $params_seName = array(
                                                                                        array('select_employeeehr2', SQLSRV_PARAM_IN),
                                                                                        array('', SQLSRV_PARAM_IN)
                                                                                    );
                                                                                    $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
                                                                                    while ($result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC)) {
                                                                                        ?>
                                                                                        <option value="<?= $result_seName['nameT'] ?>"><?= $result_seName['nameT'] ?> (<?= $result_seName['PersonCode'] ?>)</option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                                <!-- <input class="form-control" style="display: none"   id="txt_drivercode2" name="txt_drivercode2" maxlength="500" value="" > -->
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3" style="text-align: center;" >
                                                                            <input disabled="" class="form-control" style="display:none"  id="txt_worktype1" name="txt_worktype1" maxlength="500" value="" >
                                                                            <label style="font-size: 16px;"><font color="black">ประเภทงาน</font></label><br><br>
                                                                            <input type="checkbox"  <?=$rsnmround1?>  class="chk_rsnmround1"  onchange="edit_rscheckboxround1('nm')"  style="transform: scale(3)" id="chk_rsnmround1" name="chk_rsnmround1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><font style="font-size: 16px;">[ดีลเลอร์]</font></b>
                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                            <input type="checkbox"  <?=$rsshround1?>  class="chk_rsshround1"  onchange="edit_rscheckboxround1('sh')"  style="transform: scale(3)" id="chk_rsshround1" name="chk_rsshround1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><font style="font-size: 16px;">[SH]</font></b>
                                                                        </div><br>
                                                                        <div class="col-lg-2">
                                                                            <label style="font-size: 16px;">ต้นทาง:</label>&nbsp;&nbsp;<font style="color: red;font-size: 16px;"><b>*</b></font>
                                                                            <div class="dropdown bootstrap-select show-tick form-control" >
                                                                                <select   multiple="multiple" id="txt_jobstart_round1" name="txt_jobstart_round1" onchange="check_jobstart1()" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ต้นทาง รอบวิ่งงานที่ 1..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" value="">
                                                                                    <?php
                                                                                    // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                                                                    $sql_seJobstartRound1 = "{call megJobstartrccratc_v2(?,?)}";
                                                                                    $params_seJobstartRound1 = array(
                                                                                        array('select_jobstart', SQLSRV_PARAM_IN),
                                                                                        array('', SQLSRV_PARAM_IN)
                                                                                    );
                                                                                    $query_seJobstartRound1 = sqlsrv_query($conn, $sql_seJobstartRound1, $params_seJobstartRound1);
                                                                                    while ($result_seJobstartRound1 = sqlsrv_fetch_array($query_seJobstartRound1, SQLSRV_FETCH_ASSOC)) {
                                                                                        ?>
                                                                                        <option value="<?= $result_seJobstartRound1['JOBSTART'] ?>"><?= $result_seJobstartRound1['JOBSTART'] ?></option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                                <input type="text" class="form-control" style="display:none"   id="txt_jobstart_round1_chk" name="txt_jobstart_round1_chk" maxlength="500" value="" >
                                                                            </div>
                                                                            <div class="col-lg-3" style="text-align: center;" >
                                                                                
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <div class="col-lg-2">
                                                                            <label style="font-size: 16px;">ปลายทาง :</label>
                                                                            <div id="data_copydiagramclusterdef1">
                                                                                <div class="dropdown bootstrap-select show-tick form-control" onclick="check_jobtype1()">
                                                                                    <select  data-size="5" multiple="" id="cb_copydiagramcluster1" name="cb_copydiagramcluster1" class="selectpicker_round1 form-control"  data-container="body" data-live-search="true" title="เลือก คลัสเตอร์ รอบวิ่งงานที่ 1..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                    </select>
                                                                                    <input class="form-control" style=""   id="txt_cluster_round1" name="txt_cluster_round1" maxlength="200" value="" >
                                                                                    <div class="dropdown-menu open" role="combobox">
                                                                                        <div class="bs-searchbox">
                                                                                            <input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
                                                                                        <div class="bs-actionsbox">
                                                                                            <div class="btn-group btn-group-sm btn-block">
                                                                                                <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
                                                                                                <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="inner open" role="listbox" aria-expanded="false" tabindex="-1">
                                                                                            <ul class="dropdown-menu inner "></ul>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div id="data_copydiagramclustersr1"></div>
                                                                        </div>
                                                                        <div class="col-lg-3" style="text-align: center;" >
                                                                            <input disabled="" style="display:none" type="text" name="txt_copydiagramjobno_round1" id="txt_copydiagramjobno_round1" class="form-control"  value="">
                                                                        </div>
                                                                    </div>       
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <!-- END ROW2 -->
                                                            <hr class="hr1">
                                                            <!-- START ROW3 -->
                                                            <div class = "row">
                                                                <div class="">
                                                                    <div class="form-group" >
                                                                        <div class="col-lg-12" style="text-align: left;" >
                                                                            <label style="font-size: 16px;"><font color="black"><u>รอบวิ่งงานที่2</u></font></label><br><br>
                                                                        </div>
                                                                        <div class="col-lg-2">
                                                                            <label style="font-size: 16px;">พขร.(1) :</label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font>
                                                                            <div class="dropdown bootstrap-select show-tick form-control">
                                                                                <!-- <select   id="txt_drivercode1_job2" name="txt_drivercode1_job2" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พขร.(1)..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                    
                                                                                    <?php
                                                                                    // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                                                                    $sql_seName = "{call megEmployeeEHR_v2(?,?)}";
                                                                                    $params_seName = array(
                                                                                        array('select_employeeehr2', SQLSRV_PARAM_IN),
                                                                                        array('', SQLSRV_PARAM_IN)
                                                                                    );
                                                                                    $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
                                                                                    while ($result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC)) {
                                                                                        ?>
                                                                                        <option value="<?= $result_seName['nameT'] ?>"><?= $result_seName['nameT'] ?> (<?= $result_seName['PersonCode'] ?>)</option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select> -->
                                                                                <input  disabled="" class="form-control" style=""   id="txt_drivercode1_job2" name="txt_drivercode1_job2" maxlength="500" value="<?=$result_seEmp1['nameT']?>" >
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2">
                                                                            <label style="font-size: 16px;">พขร.(2) :</label><font style="color: red;font-size: 14px;"><b>ลงข้อมูลกรณีมี พขร.(2)</b></font>
                                                                            <div class="dropdown bootstrap-select show-tick form-control">
                                                                                <select   id="txt_drivercode2_job2" name="txt_drivercode2_job2" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พขร.(2)..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                    <?php
                                                                                    // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                                                                    $sql_seName = "{call megEmployeeEHR_v2(?,?)}";
                                                                                    $params_seName = array(
                                                                                        array('select_employeeehr2', SQLSRV_PARAM_IN),
                                                                                        array('', SQLSRV_PARAM_IN)
                                                                                    );
                                                                                    $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
                                                                                    while ($result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC)) {
                                                                                        ?>
                                                                                        <option value="<?= $result_seName['nameT'] ?>"><?= $result_seName['nameT'] ?> (<?= $result_seName['PersonCode'] ?>)</option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                                <!-- <input class="form-control" style="display: none"   id="txt_drivercode2" name="txt_drivercode2" maxlength="500" value="" > -->
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3" style="text-align: center;" >
                                                                            <input disabled="" class="form-control" style="display:none"  id="txt_worktype2" name="txt_worktype2" maxlength="500" value="" >
                                                                            <label style="font-size: 16px;"><font color="black">ประเภทงาน</font></label><br><br>
                                                                            <input type="checkbox"   <?=$rsgroup1AD1?>  class="chk_rsnmround2" onchange="edit_rscheckboxround2('nm')"  style="transform: scale(3)" id="chk_rsnmround2" name="chk_rsnmround2" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><font style="font-size: 16px;">[ดีลเลอร์]</font></b>
                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                            <input type="checkbox"  <?=$rsgroup1AD1?>   class="chk_rsshround2" onchange="edit_rscheckboxround2('sh')"  style="transform: scale(3)" id="chk_rsshround2" name="chk_rsshround2" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><font style="font-size: 16px;">[SH]</font></b>
                                                                        </div><br>
                                                                        <div class="col-lg-2">
                                                                            <label style="font-size: 16px;">ต้นทาง:</label>&nbsp;&nbsp;<font style="color: red;font-size: 16px;"><b>*</b></font>
                                                                            <div class="dropdown bootstrap-select show-tick form-control" >
                                                                                <select  multiple="multiple" id="txt_jobstart_round2" name="txt_jobstart_round2" onchange="check_jobstart2()"  class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ต้นทาง รอบวิ่งงานที่ 2..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                    <?php
                                                                                    // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                                                                    $sql_seJobstartRound2 = "{call megJobstartrccratc_v2(?,?)}";
                                                                                    $params_seJobstartRound2 = array(
                                                                                        array('select_jobstart', SQLSRV_PARAM_IN),
                                                                                        array('', SQLSRV_PARAM_IN)
                                                                                    );
                                                                                    $query_seJobstartRound2 = sqlsrv_query($conn, $sql_seJobstartRound2, $params_seJobstartRound2);
                                                                                    while ($result_seJobstartRound2 = sqlsrv_fetch_array($query_seJobstartRound2, SQLSRV_FETCH_ASSOC)) {
                                                                                        ?>
                                                                                        <option value="<?= $result_seJobstartRound2['JOBSTART'] ?>"><?= $result_seJobstartRound2['JOBSTART'] ?></option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                                <input type="text" class="form-control" style="display:none"   id="txt_jobstart_round2_chk" name="txt_jobstart_round2_chk" maxlength="500" value="" >
                                                                            </div>
                                                                            <div class="col-lg-3" style="text-align: center;" >
                                                                                
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <div class="col-lg-2">
                                                                            <label style="font-size: 16px;">ปลายทาง :</label>
                                                                            <div id="data_copydiagramclusterdef2">
                                                                                <div class="dropdown bootstrap-select show-tick form-control" onclick="check_jobtype2()">
                                                                                    <select  data-size="5" multiple="" id="cb_copydiagramcluster2" name="cb_copydiagramcluster2" class="selectpicker_round2 form-control"  data-container="body" data-live-search="true" title="เลือก คลัสเตอร์ รอบวิ่งงานที่ 2..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                    </select>
                                                                                    <input class="form-control" style=""   id="txt_cluster_round2" name="txt_cluster_round2" maxlength="200" value="" >
                                                                                    <div class="dropdown-menu open" role="combobox">
                                                                                        <div class="bs-searchbox">
                                                                                            <input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
                                                                                        <div class="bs-actionsbox">
                                                                                            <div class="btn-group btn-group-sm btn-block">
                                                                                                <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
                                                                                                <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="inner open" role="listbox" aria-expanded="false" tabindex="-1">
                                                                                            <ul class="dropdown-menu inner "></ul>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div id="data_copydiagramclustersr2"></div>
                                                                        </div>
                                                                        <div class="col-lg-3" style="text-align: center;" >
                                                                            <input disabled="" style="display:none" type="text" name="txt_copydiagramjobno_round2" id="txt_copydiagramjobno_round2" class="form-control"  value="">
                                                                        </div>
                                                                    </div>       
                                                                </div>
                                                            </div>
                                                            <br>

                                                            <hr class="hr1">
                                                            <!-- END ROW5 -->
                                                            <div class = "row">
                                                                <label ></label>
                                                            </div>
                                                            <div class = "row">
                                                                <div class="col-lg-12" style="text-align: center;">
                                                                    <label ><font style="color: red;font-size: 14px;text-align: center;"><b>ตรวจสอบข้อมูลให้ถูกต้องก่อนบันทึกข้อมูล</b></font></label>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12" style="text-align: center;">
                                                                    <input type="button" class="button" style="height:60px; width:250px" onclick="save_copydiagram('<?=$checkClient?>');" name="btnSend" id="btnSend" value="บันทึกข้อมูลแผนงาน" class="btn btn-success">
                                                                    <!-- <input type="button" style="width: 150px;height:100px" data-confirm ="กรุณากด 'ตกลง' เพื่อยืนยันการบันทึกข้อมูล?" name="btnSend" id="btnSend" value="บันทึกข้อมูล" class="btn btn-primary"> -->
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
                                                    
                                                </div>
                                               
                                            </div>
                                            <!-- END COLUMN1 -->
                                          
                                        </div>
                                        <!-- END ROW1 -->

                                    </div>

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

    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
    <!-- <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script> -->
    <script src="../dist/js/sb-admin-2.js"></script>
    <script src="../js/jquery.datetimepicker.full.js"></script>
    <script src="../dist/js/jquery.autocomplete.js"></script>
    <script src="../dist/js/bootstrap-select.js"></script>
    <script src="../js/bootstrap-datepicker.min.js"></script>
    <script src="../js/bootstrap-datepicker.th.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

        <script type="text/javascript">

            $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".dateen").datetimepicker({
                    timepicker: true,
                    dateformat: 'Y-m-d' , // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                    timeFormat: "HH:MM"

                }
                );
            });

            $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".dateonly").datetimepicker({
                    timepicker: false,
                    format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                });
            });
            
            // function session_chk() {
            //     alert('SESSION CLOSE');
            // }
            function select_thainame(){
               
                let thainame = $("#txt_thainame").val();
                let check = thainame.substring(0, 2);
                
                // alert(check);

                if (check =='R-') {
                    // กรณีเลือกรถ RCC
                    document.getElementById('txt_copydiagramcompany').value = 'RCC';
                    document.getElementById('txt_copydiagramcustomer').value = 'TTT';
                }else{
                    // กรณีเลือกรถ RATC
                    document.getElementById('txt_copydiagramcompany').value = 'RATC';
                    document.getElementById('txt_copydiagramcustomer').value = 'TTT';
                }

                // check load ของแต่ละชื่อรถ
                let check_load = thainame.includes("R-4") || thainame.includes("(4L)") || thainame.includes("RA-4");
                // alert(check_load);
                if (check_load == true) {
                    // alert("4 load"); 
                    document.getElementById('txt_load').value = '4';
                }else{
                    // alert('8 load'); 
                    document.getElementById('txt_load').value = '8';
                }
                // $('.selectpicker').on('changed.bs.select', function () {
                //     document.getElementById('txt_thainame').value = $(this).val();
                   
                // });

                
            }
            
            // get vlaue form check multiple job.1
            function check_jobstart1() {
                
                var options = document.getElementById('txt_jobstart_round1').selectedOptions;
                var values = Array.from(options).map(({ value }) => value);
                
                document.getElementById('txt_jobstart_round1_chk').value = values;
                // alert(values);
            }
            // get vlaue form check multiple job.2
            function check_jobstart2() {
                
                var options = document.getElementById('txt_jobstart_round2').selectedOptions;
                var values = Array.from(options).map(({ value }) => value);
                
                document.getElementById('txt_jobstart_round2_chk').value = values;
                // alert(values);
            }
            // get vlaue form check multiple job.3
            function check_jobstart3() {
                
                var options = document.getElementById('txt_jobstart_round3').selectedOptions;
                var values = Array.from(options).map(({ value }) => value);
                
                document.getElementById('txt_jobstart_round3_chk').value = values;
                // alert(values);
            }
            // get vlaue form check multiple job.4
            function check_jobstart4() {
                
                var options = document.getElementById('txt_jobstart_round4').selectedOptions;
                var values = Array.from(options).map(({ value }) => value);
                
                document.getElementById('txt_jobstart_round4_chk').value = values;
                // alert(values);
            }
            ////////////////////////////////////////////////////////////////////////

            // เงื่อนไขการลงข้อมูลรอบวิ่งงานที่1
            // function เช็คการกด checkbox รอบวิ่งงานที่ 1
            function edit_rscheckboxround1(checkround){
                // alert(checkround);
                if (checkround == 'nm') {
                    document.getElementById('chk_rsshround1').checked  = false;
                    document.getElementById('chk_rsnmround1').disabled = true;
                    document.getElementById('chk_rsshround1').disabled = false;
                    document.getElementById('txt_worktype1').value     = 'nm';
                }else if(checkround == 'sh'){
                    document.getElementById('chk_rsnmround1').checked  = false;
                    document.getElementById('chk_rsshround1').disabled = true;
                    document.getElementById('chk_rsnmround1').disabled = false;
                    document.getElementById('txt_worktype1').value     = 'sh';
                }else{
                    
                }

                select_cluster1(checkround);
            }
            
            function check_jobtype1(){
                // alert('check1');
                let checkBox1nm = document.getElementById("chk_rsnmround1");
                let checkBox1sh = document.getElementById("chk_rsshround1");

                worktype = 'nm';    
                if (checkBox1nm.checked == true){
                    // alert('ยังไม่เลือกประเภทงาน');
                    select_cluster1('nm');
                }else if (checkBox1sh.checked == true){
                    select_cluster1('sh');
                }else{
                    swal.fire({
                        title: "Warning!",
                        text: "ยังไม่ได้เลือกประเภทงาน แผนที่1 !!",
                        icon: "warning",
                        showConfirmButton: true,
                    });
                }

                
            }
            function select_cluster1(checkround)
            {

                // var copydiagramthainame = document.getElementById("txt_copydiagramthainame").value;
                //var copydiagramjobstart = document.getElementById("txt_copydiagramjobstart").value;
                // var companycode = document.getElementById("txt_copydiagramcompany").value;
                // var customercode = document.getElementById("txt_copydiagramcustomer").value;
                
                var worktype      = checkround;
                var companycode   = 'RCC_RATC';
                var customercode  = 'TTT';
                // alert(worktype);
                // alert(companycode);
                // alert(customercode);

                
                $.ajax({
                    type: 'post',
                    url: 'meg_data_transportplan_newrccratc.php',
                    data: {
                        txt_flg: "show_copydiagramcluster1", worktype: worktype, companycode: companycode, customercode: customercode
                                // txt_flg: "show_copydiagramjobend", cluster: document.getElementById('txt_copydiagramcluster').value, copydiagramthainame: copydiagramthainame
                    },
                    success: function (rs) {

                        document.getElementById("data_copydiagramclustersr1").innerHTML = rs;
                        document.getElementById("data_copydiagramclusterdef1").innerHTML = "";

                        $("#cb_copydiagramcluster1").html(rs).selectpicker('refresh');
                        $('.selectpicker_round1').on('changed.bs.select', function () {
                            document.getElementById('txt_cluster_round1').value = $(this).val();

                        });
                        
                        
                        // create_jobno('job1');

                    }
                });

                
            }
            /////////////////////////////////////////////////////////////////////////

            // เงื่อนไขการลงข้อมูลรอบวิ่งงานที่2
            // function เช็คการกด checkbox รอบวิ่งงานที่ 2
            function edit_rscheckboxround2(checkround){
                // alert("Round2 Checked");
                if (checkround == 'nm') {
                    document.getElementById('chk_rsshround2').checked  = false;
                    document.getElementById('chk_rsnmround2').disabled = true;
                    document.getElementById('chk_rsshround2').disabled = false;
                    document.getElementById('txt_worktype2').value     = 'nm';
                }else if(checkround == 'sh'){
                    document.getElementById('chk_rsnmround2').checked  = false;
                    document.getElementById('chk_rsshround2').disabled = true;
                    document.getElementById('chk_rsnmround2').disabled = false;
                    document.getElementById('txt_worktype2').value     = 'sh';
                }else{
                    
                }

                select_cluster2(checkround);
            }
            
            function check_jobtype2(){
                let checkBox2nm = document.getElementById("chk_rsnmround2");
                let checkBox2sh = document.getElementById("chk_rsshround2");

                if (checkBox2nm.checked == true){
                    // alert('ยังไม่เลือกประเภทงาน');
                    select_cluster2('nm');
                }else if (checkBox2sh.checked == true){
                    select_cluster2('sh');
                }else{
                    swal.fire({
                        title: "Warning!",
                        text: "ยังไม่ได้เลือกประเภทงาน แผนที่2 !!",
                        icon: "warning",
                        showConfirmButton: true,
                    });
                }
            }
            function select_cluster2(checkround)
            {

                // var copydiagramthainame = document.getElementById("txt_copydiagramthainame").value;
                //var copydiagramjobstart = document.getElementById("txt_copydiagramjobstart").value;
                // var companycode = document.getElementById("txt_copydiagramcompany").value;
                // var customercode = document.getElementById("txt_copydiagramcustomer").value;
                
                var worktype      = checkround;
                var companycode   = 'RCC_RATC';
                var customercode  = 'TTT';
                // alert(worktype);
                // alert(companycode);
                // alert(customercode);

                $.ajax({
                    type: 'post',
                    url: 'meg_data_transportplan_newrccratc.php',
                    data: {
                        txt_flg: "show_copydiagramcluster2", worktype: worktype, companycode: companycode, customercode: customercode
                                // txt_flg: "show_copydiagramjobend", cluster: document.getElementById('txt_copydiagramcluster').value, copydiagramthainame: copydiagramthainame
                    },
                    success: function (rs) {

                        document.getElementById("data_copydiagramclustersr2").innerHTML = rs;
                        document.getElementById("data_copydiagramclusterdef2").innerHTML = "";

                        $("#cb_copydiagramcluster2").html(rs).selectpicker('refresh');
                        $('.selectpicker_round2').on('changed.bs.select', function () {
                            document.getElementById('txt_cluster_round2').value = $(this).val();

                        });


                    }
                });
            }
            ////////////////////////////////////////////////////////////////////////////

            // เงื่อนไขการลงข้อมูลรอบวิ่งงานที่3 
            // function เช็คการกด checkbox รอบวิ่งงานที่ 3
            function edit_rscheckboxround3(checkround){
                // alert("Round3 Checked");
                if (checkround == 'nm') {
                    document.getElementById('chk_rsshround3').checked  = false;
                    document.getElementById('chk_rsnmround3').disabled = true;
                    document.getElementById('chk_rsshround3').disabled = false;
                    document.getElementById('txt_worktype3').value     = 'nm';
                }else if(checkround == 'sh'){
                    document.getElementById('chk_rsnmround3').checked  = false;
                    document.getElementById('chk_rsshround3').disabled = true;
                    document.getElementById('chk_rsnmround3').disabled = false;
                    document.getElementById('txt_worktype3').value     = 'sh';
                }else{
                    
                }

                select_cluster3(checkround);
            }
            
            function check_jobtype3(){
                let checkBox3nm = document.getElementById("chk_rsnmround3");
                let checkBox3sh = document.getElementById("chk_rsshround3");

                if (checkBox3nm.checked == true){
                    // alert('ยังไม่เลือกประเภทงาน');
                    select_cluster3('nm');
                }else if (checkBox3sh.checked == true){
                    select_cluster3('sh');
                }else{
                    swal.fire({
                        title: "Warning!",
                        text: "ยังไม่ได้เลือกประเภทงาน แผนที่3 !!",
                        icon: "warning",
                        showConfirmButton: true,
                    });
                }
            }
            function select_cluster3(checkround)
            {

                // var copydiagramthainame = document.getElementById("txt_copydiagramthainame").value;
                //var copydiagramjobstart = document.getElementById("txt_copydiagramjobstart").value;
                // var companycode = document.getElementById("txt_copydiagramcompany").value;
                // var customercode = document.getElementById("txt_copydiagramcustomer").value;
                
                var worktype      = checkround;
                var companycode   = 'RCC_RATC';
                var customercode  = 'TTT';
                // alert(worktype);
                // alert(companycode);
                // alert(customercode);

                $.ajax({
                    type: 'post',
                    url: 'meg_data_transportplan_newrccratc.php',
                    data: {
                        txt_flg: "show_copydiagramcluster3", worktype: worktype, companycode: companycode, customercode: customercode
                                // txt_flg: "show_copydiagramjobend", cluster: document.getElementById('txt_copydiagramcluster').value, copydiagramthainame: copydiagramthainame
                    },
                    success: function (rs) {

                        document.getElementById("data_copydiagramclustersr3").innerHTML = rs;
                        document.getElementById("data_copydiagramclusterdef3").innerHTML = "";

                        $("#cb_copydiagramcluster3").html(rs).selectpicker('refresh');
                        $('.selectpicker_round3').on('changed.bs.select', function () {
                            document.getElementById('txt_cluster_round3').value = $(this).val();

                        });


                    }
                });
            }
            ///////////////////////////////////////////////////////////////////////////////////////

            // เงื่อนไขการลงข้อมูลรอบวิ่งงานที่4
            // function เช็คการกด checkbox รอบวิ่งงานที่ 4
            function edit_rscheckboxround4(checkround){
                // alert("Round1 Checked");
                if (checkround == 'nm') {
                    document.getElementById('chk_rsshround4').checked  = false;
                    document.getElementById('chk_rsnmround4').disabled = true;
                    document.getElementById('chk_rsshround4').disabled = false;
                    document.getElementById('txt_worktype4').value     = 'nm';
                }else if(checkround == 'sh'){
                    document.getElementById('chk_rsnmround4').checked  = false;
                    document.getElementById('chk_rsshround4').disabled = true;
                    document.getElementById('chk_rsnmround4').disabled = false;
                    document.getElementById('txt_worktype4').value     = 'sh';
                }else{
                    
                }

                select_cluster4(checkround);
            }
            
            function check_jobtype4(){
                let checkBox4nm = document.getElementById("chk_rsnmround4");
                let checkBox4sh = document.getElementById("chk_rsshround4");

                if (checkBox4nm.checked == true){
                    // alert('ยังไม่เลือกประเภทงาน');
                    select_cluster4('nm');
                }else if (checkBox4sh.checked == true){
                    select_cluster4('sh');
                }else{
                    swal.fire({
                        title: "Warning!",
                        text: "ยังไม่ได้เลือกประเภทงาน แผนที่4 !!",
                        icon: "warning",
                        showConfirmButton: true,
                    });
                }
            }
            function select_cluster4(checkround)
            {

                // var copydiagramthainame = document.getElementById("txt_copydiagramthainame").value;
                //var copydiagramjobstart = document.getElementById("txt_copydiagramjobstart").value;
                // var companycode = document.getElementById("txt_copydiagramcompany").value;
                // var customercode = document.getElementById("txt_copydiagramcustomer").value;
                
                var worktype      = checkround;
                var companycode   = 'RCC_RATC';
                var customercode  = 'TTT';
                // alert(worktype);
                // alert(companycode);
                // alert(customercode);

                $.ajax({
                    type: 'post',
                    url: 'meg_data_transportplan_newrccratc.php',
                    data: {
                        txt_flg: "show_copydiagramcluster4", worktype: worktype, companycode: companycode, customercode: customercode
                                // txt_flg: "show_copydiagramjobend", cluster: document.getElementById('txt_copydiagramcluster').value, copydiagramthainame: copydiagramthainame
                    },
                    success: function (rs) {

                        document.getElementById("data_copydiagramclustersr4").innerHTML = rs;
                        document.getElementById("data_copydiagramclusterdef4").innerHTML = "";

                        $("#cb_copydiagramcluster4").html(rs).selectpicker('refresh');
                        $('.selectpicker_round4').on('changed.bs.select', function () {
                            document.getElementById('txt_cluster_round4').value = $(this).val();

                        });


                    }
                });
            }
            ///////////////////////////////////////////////////////////////////////////////////////

            // function การสร้าง JOBNO
            function create_jobno(typejob,jobstart)
            {
                // alert(typejob);
                // เช็คทะเบียนรถ ต้องไม่เป็นค่าว่าง เพื่อที่จะไป Generate Jobno โดยใช้รหัสบริษัทตาม ชื่อรถ R- = RCC , RAT = RATC
                let thainame_chk = $("#txt_thainame").val();
                let companycode = $("#txt_copydiagramcompany").val();
                
                // jobdate format DD/MM/YYYY example 11/09/2023
                let jobdate_chk = $("#txt_datetenko").val();
                let result = jobdate_chk.substring(0, 10);

                // result1 คือวัน Format DD Ex 11
                let result1 = result.substring(8, 10);
                
                // result2 คือเดือน Format MM Ex 09
                let result2 = result.substring(5, 7);

                // result3 คือปี Format YYYY Ex 2023
                let result3 = result.substring(0, 4);

                //วันที่สำหรับส่งเข้า Generate Jobno
                let jobdate = result1+"/"+result2+"/"+result3;

                // alert(typejob);
                // alert(companycode);
                // alert(jobdate_chk);
                // alert(jobdate);



                if (thainame_chk == '') {

                    swal.fire({
                        title: "Warning!",
                        text: "ยังไม่ได้เลือกชื่อรถ !!",
                        icon: "warning",
                        showConfirmButton: true,
                    });

                }else{

                    $.ajax({
                        type: 'post',
                        url: 'meg_data_transportplan_newrccratc.php',
                        data: {
                            txt_flg: "create_jobno", companycode: companycode, jobdate: jobdate
                        },
                        success: function (rs) {
                            // alert(rs);
                            if (typejob == 'job1')
                            {
                                if ($("#txt_jobstart_round1_chk").val() == '') {
                                    swal.fire({
                                        title: "Warning!",
                                        text: "ยังไม่ได้เลือกต้นทาง Job.1 !!",
                                        icon: "warning",
                                        showConfirmButton: true,
                                    });
                                }else{
                                    document.getElementById("txt_copydiagramjobno_round1").value = rs;
                                }
                                
                                
                            }
                            if (typejob == 'job2')
                            {
                                if ($("#txt_jobstart_round2_chk").val() == '') {
                                    swal.fire({
                                        title: "Warning!",
                                        text: "ยังไม่ได้เลือกต้นทาง Job.2 !!",
                                        icon: "warning",
                                        showConfirmButton: true,
                                    });
                                }else{
                                    document.getElementById("txt_copydiagramjobno_round2").value = rs;
                                }
                                
                                
                            }
                            if (typejob == 'job3')
                            {
                                if ($("#txt_jobstart_round3_chk").val() == '') {
                                    swal.fire({
                                        title: "Warning!",
                                        text: "ยังไม่ได้เลือกต้นทาง Job.3 !!",
                                        icon: "warning",
                                        showConfirmButton: true,
                                    });
                                }else{
                                    document.getElementById("txt_copydiagramjobno_round3").value = rs;
                                }
                                
                                
                            }
                            if (typejob == 'job4')
                            {
                                if ($("#txt_jobstart_round4_chk").val() == '') {
                                    swal.fire({
                                        title: "Warning!",
                                        text: "ยังไม่ได้เลือกต้นทาง Job.4 !!",
                                        icon: "warning",
                                        showConfirmButton: true,
                                    });
                                }else{
                                    document.getElementById("txt_copydiagramjobno_round4").value = rs;
                                }
                                
                                
                            }
                        }
                    });
                }
                
            } 
            function checknull_copydiagramnn1()
            {
                // alert("round1");    
                // alert(document.getElementById("txt_cluster_round1").value);

                    if (document.getElementById("txt_datetenko").value == "")
                    {
                        // alert("วันที่และเวลาวิ่งงาน เป็นค่าว่าง !!!");
                        swal.fire({
                            title: "Warning!",
                            text: "วันที่และเวลาวิ่งงาน เป็นค่าว่าง !!!",
                            icon: "warning",
                            showConfirmButton: true,
                        });
                        return false;
                    } else if (document.getElementById("txt_drivercode1_job1").value == "")
                    {
                        // alert("พนักงาน (1) เป็นค่าว่าง !!!");
                        swal.fire({
                            title: "Warning!",
                            text: "พนักงาน (1) แผนที่(1) เป็นค่าว่าง !!!",
                            icon: "warning",
                            showConfirmButton: true,
                        });
                        return false;
                    } else if (document.getElementById("txt_thainame").value == "")
                    {
                        // alert("ชื่อรถ เป็นค่าว่าง !!!");
                        swal.fire({
                            title: "Warning!",
                            text: "ชื่อรถ เป็นค่าว่าง !!!",
                            icon: "warning",
                            showConfirmButton: true,
                        });
                        return false;
                    } else if (document.getElementById("txt_jobstart_round1_chk").value == "")
                    {
                        // alert("ต้องลงข้อมูลแผนงานที่ 1 ก่อนเท่านั้น !!!");
                        swal.fire({
                            title: "Warning!",
                            text: "ยังไม่ได้ลงข้อมูล ต้นทางแผนงานที่(1) !!!",
                            icon: "warning",
                            showConfirmButton: true,
                        });
                        return false;
                    } else if (document.getElementById("txt_cluster_round1").value == "")
                    {
                        // alert("ต้องลงข้อมูลแผนงานที่ 1 ก่อนเท่านั้น !!!");
                        swal.fire({
                            title: "Warning!",
                            text: "ยังไม่ได้ลงข้อมูล ปลายทางแผนงานที่(1) !!!",
                            icon: "warning",
                            showConfirmButton: true,
                        });
                        return false;
                    } else
                    {
                        // alert('11');
                        checknull_copydiagramnn2();
                        return true;
                        
                    }

            }        
            function checknull_copydiagramnn2()
            {
                // alert("round2");
                // alert(document.getElementById("txt_cluster_round1").value);

                if ($('#chk_rsnmround2').is(':checked') || $('#chk_rsshround2').is(':checked')) {
                    // alert("round21");

                    if (document.getElementById("txt_jobstart_round2_chk").value == "")
                    {
                        // alert("round22");
                        // alert("ต้องลงข้อมูลแผนงานที่ 1 ก่อนเท่านั้น !!!");
                        swal.fire({
                            title: "Warning!",
                            text: "ยังไม่ได้ลงข้อมูล ต้นทางแผนงานที่(2) !!!",
                            icon: "warning",
                            showConfirmButton: true,
                        });
                        return false;
                    } else if (document.getElementById("txt_cluster_round2").value == "")
                    {
                        // alert("ต้องลงข้อมูลแผนงานที่ 1 ก่อนเท่านั้น !!!");
                        swal.fire({
                            title: "Warning!",
                            text: "ยังไม่ได้ลงข้อมูล ปลายทางแผนงานที่(2) !!!",
                            icon: "warning",
                            showConfirmButton: true,
                        });
                        return false;
                    } else
                    {
                        // alert("round24");   
                        return true;
                    }

                }else{
                    // alert("round23");
                    return true;

                }
                    

            }      
            
            function save_copydiagram()
            {
                /////start n1/////
                
                let employeename1_job1 = $('#txt_drivercode1_job1').val();
                let employeename1_job2 = $('#txt_drivercode1_job2').val();
                let employeename1_job3 = $('#txt_drivercode1_job3').val();
                let employeename1_job4 = $('#txt_drivercode1_job4').val();

                let employeename2_job1 = $('#txt_drivercode2_job1').val();
                let employeename2_job2 = $('#txt_drivercode2_job2').val();
                let employeename2_job3 = $('#txt_drivercode2_job3').val();
                let employeename2_job4 = $('#txt_drivercode2_job4').val();
                let employeename3 = $('#txt_controller').val();
                let thainame = $('#txt_thainame').val();
                let dateworking_chk  = $('#txt_datetenko').val();
                let dateworking  = dateworking_chk.substring(11,16);
                let currentdate  = $('#txt_currentdate').val();
                let companycode  = $('#txt_copydiagramcompany').val();
                let customercode = $('#txt_copydiagramcustomer').val();
                let load  = $('#txt_load').val();
                let carrytype = 'trip';

                // datepresent format YYYY/MM/DD example 2023/10/03
                let datepresent_chk = $("#txt_datepresent").val();
                let result = datepresent_chk.substring(0, 16);

                // result1 คือวัน Format DD Ex 11
                let result1 = result.substring(8, 10);
                
                // result2 คือเดือน Format MM Ex 09
                let result2 = result.substring(5, 7);

                // result3 คือปี Format YYYY Ex 2023
                let result3 = result.substring(0, 4);

                // result4 คือ เวลา Format H:i Ex 10:00
                let result4 = result.substring(11, 16);

                //วันที่สำหรับส่ง parameter
                let datepresent = result3+"/"+result2+"/"+result1+" "+result4;

                // alert(employeename1_job1);
                // alert(datepresent_chk);
                // alert(datepresent);
                // alert(employeename1);
                // alert(employeename2);
                // alert(employeename3);
                // alert(thainame);
                // alert(dateworking); 
                // alert(currentdate);
                // alert(companycode);
                // alert(customercode);
                // alert(load);
                // alert("job1")
                // alert(document.getElementById("txt_jobstart_round1").value);
                // alert(document.getElementById("txt_cluster_round1").value);
                // alert("job2")
                // alert(document.getElementById("txt_jobstart_round2").value);
                // alert(document.getElementById("txt_cluster_round2").value);
                // alert("job3")
                // alert(document.getElementById("txt_jobstart_round3").value);
                // alert(document.getElementById("txt_cluster_round3").value);
                // alert("job4")
                // alert(document.getElementById("txt_jobstart_round4").value);
                // alert(document.getElementById("txt_cluster_round4").value);
                
                // check if true
                if (checknull_copydiagramnn1() && checknull_copydiagramnn2()) {

                    // เพิ่มแผนงาน รอบวิ่งงานที่1 
                    // เช็คการลงข้อมูลจาก เลข job และ คลัสเตอร์
                    if ($('#txt_copydiagramjobno_round1').val() != '') {
                        // alert("JOB NO.1");
                        //๋JOB NO.1
                            $.ajax({
                                type: 'post',
                                url: 'meg_data_transportplan_newrccratc.php',
                                data: {
                                    txt_flg: "save_copydiagramvehicletransportplan",
                                    VEHICLETRANSPORTPLANID: '',
                                    STARTDATE: '',
                                    ENDDATE: '',
                                    CUSTOMERCODE: customercode,
                                    COMPANYCODE: companycode,
                                    THAINAME: thainame,
                                    JOBSTART: document.getElementById("txt_jobstart_round1_chk").value,
                                    CLUSTER: document.getElementById("txt_cluster_round1").value,
                                    JOBEND: document.getElementById("txt_cluster_round1").value,
                                    EMPLOYEENAME1: employeename1_job1,
                                    EMPLOYEENAME2: employeename2_job1,
                                    EMPLOYEENAME3: employeename3,
                                    JOBNO: document.getElementById("txt_copydiagramjobno_round1").value,
                                    DATEINPUT: '',
                                    DATERK: dateworking,
                                    DATEPRESENT: datepresent,
                                    DATEWORKING: dateworking,
                                    DATEVLIN:  '',
                                    DATEVLOUT: '',
                                    DATEDEALERIN: '',
                                    DATERETURN: '',
                                    VEHICLETYPE: '',
                                    MATERIALTYPE: '',
                                    GORETURN: '',
                                    WORKTYPE: document.getElementById("txt_worktype1").value,
                                    LOAD: load,
                                    ROUTE: '',
                                    UNIT: '',
                                    ROUNDAMOUNT: '1',
                                    DN: '',
                                    CARRYTYPE: carrytype,
                                    THAINAME2: '',
                                    BILLING: '',
                                    CREATEBY: '<?= $result_seEmp1["PersonCode"] ?>'
                                },
                                success: function (rs) {
                                    // save_logprocess('Driver', 'SaveJob.1 NewPlaning', '<?= $result_seEmployee["PersonCode"] ?>');
                                    // alert(rs);
                                    // swal.fire({
                                    //     title: "Good Job!",
                                    //     text: "บันทึกข้อมูล Job.1 เรียบร้อย",
                                    //     showConfirmButton: true,
                                    //     icon: "success"
                                    // });
                                }
                            });

                    }else{
                        // alert('ข้อมูลไม่ครบถ้วน Job No.1');
                        swal.fire({
                            title: "warning",
                            text: "ข้อมูลไม่ครบถ้วน Job No.1 !!",
                            icon: "warning",
                            showConfirmButton: true
                        });
                    }
                    //////////////////////////////////////////////////////////////////////////////
                    
                    // เพิ่มแผนงาน รอบวิ่งงานที่2
                    // เช็คการลงข้อมูลจาก เลข job และ คลัสเตอร์
                    if ($('#txt_copydiagramjobno_round2').val() != '') {
                        // alert("JOB NO.2");
                        //๋JOB NO.2

                        $.ajax({
                            type: 'post',
                            url: 'meg_data_transportplan_newrccratc.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: '',
                                STARTDATE: '',
                                ENDDATE: '',
                                CUSTOMERCODE: customercode,
                                COMPANYCODE: companycode,
                                THAINAME: thainame,
                                JOBSTART: document.getElementById("txt_jobstart_round2_chk").value,
                                CLUSTER: document.getElementById("txt_cluster_round2").value,
                                JOBEND: document.getElementById("txt_cluster_round2").value,
                                EMPLOYEENAME1: employeename1_job2,
                                EMPLOYEENAME2: employeename2_job2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobno_round2").value,
                                DATEINPUT: '',
                                DATERK: dateworking,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: '',
                                DATEVLOUT: '',
                                DATEDEALERIN: '',
                                DATERETURN: '',
                                VEHICLETYPE: '',
                                MATERIALTYPE: '',
                                GORETURN: '',
                                WORKTYPE: document.getElementById("txt_worktype2").value,
                                LOAD: load,
                                ROUTE: '',
                                UNIT: '',
                                ROUNDAMOUNT: '2',
                                DN: '',
                                CARRYTYPE: carrytype,
                                THAINAME2: '',
                                BILLING: '',
                                CREATEBY: '<?= $result_seEmp1["PersonCode"] ?>'

                            },
                            success: function (rs) {
                                // save_logprocess('Driver', 'SaveJob.2 NewPlaning', '<?= $result_seEmployee['PersonCode'] ?>');
                                // alert(rs);
                                // swal.fire({
                                //     title: "Good Job!",
                                //     text: "บันทึกข้อมูล Job.2 เรียบร้อย",
                                //     showConfirmButton: true,
                                //     icon: "success"
                                // });
                            }
                        });
                    }else{
                        // alert('ข้อมูลไม่ครบถ้วน Job No.2');
                        // swal.fire({
                        //     title: "warning",
                        //     text: "ข้อมูลไม่ครบถ้วน Job No.2 !!",
                        //     icon: "warning",
                        //     showConfirmButton: true
                        // });
                    }
                     //////////////////////////////////////////////////////////////////////////////
                    
                    // // เพิ่มแผนงาน รอบวิ่งงานที่3
                    // // เช็คการลงข้อมูลจาก เลข job และ คลัสเตอร์
                    // if ($('#txt_copydiagramjobno_round3').val() != '') {
                    //     // alert("JOB NO.3");
                    //     //๋JOB NO.3
                    //     $.ajax({
                    //         type: 'post',
                    //         url: 'meg_data_transportplan_newrccratc.php',
                    //         data: {
                    //             txt_flg: "save_copydiagramvehicletransportplan",
                    //             VEHICLETRANSPORTPLANID: '',
                    //             STARTDATE: '',
                    //             ENDDATE: '',
                    //             CUSTOMERCODE: customercode,
                    //             COMPANYCODE: companycode,
                    //             THAINAME: thainame,
                    //             JOBSTART: document.getElementById("txt_jobstart_round3_chk").value,
                    //             CLUSTER: document.getElementById("txt_cluster_round3").value,
                    //             JOBEND: document.getElementById("txt_cluster_round3").value,
                    //             EMPLOYEENAME1: employeename1_job3,
                    //             EMPLOYEENAME2: employeename2_job3,
                    //             EMPLOYEENAME3: employeename3,
                    //             JOBNO: document.getElementById("txt_copydiagramjobno_round3").value,
                    //             DATEINPUT: '',
                    //             DATERK: dateworking,
                    //             DATEPRESENT: datepresent,
                    //             DATEWORKING: dateworking,
                    //             DATEVLIN: '',
                    //             DATEVLOUT: '',
                    //             DATEDEALERIN: '',
                    //             DATERETURN: '',
                    //             VEHICLETYPE: '',
                    //             MATERIALTYPE: '',
                    //             GORETURN: '',
                    //             WORKTYPE: document.getElementById("txt_worktype3").value,
                    //             LOAD: load,
                    //             ROUTE: '',
                    //             UNIT: '',
                    //             ROUNDAMOUNT: '3',
                    //             DN: '',
                    //             CARRYTYPE: carrytype,
                    //             THAINAME2: '',
                    //             BILLING: '',
                    //             CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                    //         },
                    //         success: function (rs) {
                    //             // save_logprocess('Driver', 'SaveJob.3 NewPlaning', '<?= $result_seEmployee['PersonCode'] ?>');
                    //             // alert(rs);
                    //             // swal.fire({
                    //             //     title: "Good Job!",
                    //             //     text: "บันทึกข้อมูล Job.3 เรียบร้อย",
                    //             //     showConfirmButton: true,
                    //             //     icon: "success"
                    //             // });
                    //         }
                    //     });
                    // }else{
                    //     // alert('ข้อมูลไม่ครบถ้วน Job No.3');  
                    //     // swal.fire({
                    //     //     title: "warning",
                    //     //     text: "ข้อมูลไม่ครบถ้วน Job No.3 !!",
                    //     //     icon: "warning",
                    //     //     showConfirmButton: true
                    //     // }); 
                    // }
                    /////////////////////////////////////////////////////////////////////////////

                    // // เพิ่มแผนงาน รอบวิ่งงานที่4
                    // // เช็คการลงข้อมูลจาก เลข job และ คลัสเตอร์
                    // if ($('#txt_copydiagramjobno_round4').val() != '') {
                    //     // alert("JOB NO.4");
                    //     //๋JOB NO.4
                    //     $.ajax({
                    //         type: 'post',
                    //         url: 'meg_data_transportplan_newrccratc.php',
                    //         data: {
                    //             txt_flg: "save_copydiagramvehicletransportplan",
                    //             VEHICLETRANSPORTPLANID: '',
                    //             STARTDATE: '',
                    //             ENDDATE: '',
                    //             CUSTOMERCODE: customercode,
                    //             COMPANYCODE: companycode,
                    //             THAINAME: thainame,
                    //             JOBSTART: document.getElementById("txt_jobstart_round4_chk").value,
                    //             CLUSTER: document.getElementById("txt_cluster_round4").value,
                    //             JOBEND: document.getElementById("txt_cluster_round4").value,
                    //             EMPLOYEENAME1: employeename1_job4,
                    //             EMPLOYEENAME2: employeename2_job4,
                    //             EMPLOYEENAME3: employeename3,
                    //             JOBNO: document.getElementById("txt_copydiagramjobno_round4").value,
                    //             DATEINPUT: '',
                    //             DATERK: dateworking,
                    //             DATEPRESENT: datepresent,
                    //             DATEWORKING: dateworking,
                    //             DATEVLIN: '',
                    //             DATEVLOUT: '',
                    //             DATEDEALERIN: '',
                    //             DATERETURN: '',
                    //             VEHICLETYPE: '',
                    //             MATERIALTYPE: '',
                    //             GORETURN: '',
                    //             WORKTYPE: document.getElementById("txt_worktype4").value,
                    //             LOAD: load,
                    //             ROUTE: '',
                    //             UNIT: '',
                    //             ROUNDAMOUNT: '4',
                    //             DN: '',
                    //             CARRYTYPE: carrytype,
                    //             THAINAME2: '',
                    //             BILLING: '',
                    //             CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                    //         },
                    //         success: function (rs) {
                    //             // save_logprocess('Driver', 'SaveJob.4 NewPlaning', '<?= $result_seEmployee['PersonCode'] ?>');
                    //             // alert(rs);
                    //             // swal.fire({
                    //             //     title: "Good Job!",
                    //             //     text: "บันทึกข้อมูล Job.4 เรียบร้อย",
                    //             //     showConfirmButton: true,
                    //             //     icon: "success"
                    //             // });
                    //         }
                    //     });

                    // }else{
                    //     // alert('ข้อมูลไม่ครบถ้วน Job No.4');
                    //     // swal.fire({
                    //     //     title: "warning",
                    //     //     text: "ข้อมูลไม่ครบถ้วน Job No.4 !!",
                    //     //     icon: "warning",
                    //     //     showConfirmButton: true
                    //     // });   
                        
                    // }

                    
                    // alert('บันทึกข้อมูล JOB เรียบร้อย');
                    swal.fire({
                        title: "Good Job!",
                        text: "ยืนยันและบันทึกข้อมูลทั้งหมดเรียบร้อย",
                        showConfirmButton: false,
                        icon: "success",
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                    // delay reload current page   
                    setTimeout(() => {
                        document.location.reload();
                    }, 1100);

                }
                // end check if true
            }
            // function save_logprocess(category, process, employeecode)
            // {
            //     $.ajax({
            //         url: 'meg_data.php',
            //         type: 'POST',
            //         data: {
            //             txt_flg: "save_logprocess", category: category, process: process, employeecode: employeecode
            //         },
            //         success: function () {


            //         }
            //     });
            // }
            
            

        </script>






    </body>

</html>
<?php
sqlsrv_close($conn);
?>