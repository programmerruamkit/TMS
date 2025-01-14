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

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$monthnumeric  = $_POST['monthnumeric']; //เดือนที่เป็นตัวเลช
$month  = $_POST['month']; //เดือนที่เป็นอักษร
$years  = $_POST['years'];
$truckdatachk = $_POST['truckdata'];

    $yearsub = substr($years,2);

if ($truckdatachk == 'Personal') {
    $truckdata = 'Personal issue';
}else if ($truckdatachk == 'External') {
    $truckdata = 'External issue';
}else{
    $truckdata = 'Out of Data';
}

$employee1 = " AND a.PersonCode = '" .$_SESSION["USERNAME"] . "'";
$sql_seEmp1 = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmp1 = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($employee1, SQLSRV_PARAM_IN)
);
$query_seEmp1 = sqlsrv_query($conn, $sql_seEmp1, $params_seEmp1);
$result_seEmp1 = sqlsrv_fetch_array($query_seEmp1, SQLSRV_FETCH_ASSOC);

$sql_seChkDataPlan = "SELECT JOBNO,VEHICLETRANSPORTPLANID,EMPLOYEECODE1,EMPLOYEENAME1,EMPLOYEECODE2,EMPLOYEENAME2,THAINAME,JOBSTART,JOBEND
FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE  CONVERT(DATE,CREATEDATE,103) = CONVERT(DATE,GETDATE(),103)
AND CREATEBY ='".$result_seEmp1['PersonCode']."'";
$params_seChkDataPlan = array();
$query_seChkDataPlan  = sqlsrv_query($conn, $sql_seChkDataPlan, $params_seChkDataPlan);
$result_seChkDataPlan = sqlsrv_fetch_array($query_seChkDataPlan, SQLSRV_FETCH_ASSOC);

$employee2 = " AND a.PersonCode = '" .$result_seChkDataPlan['EMPLOYEECODE2'] . "'";
$sql_seEmp2 = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmp2 = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($employee2, SQLSRV_PARAM_IN)
);
$query_seEmp2 = sqlsrv_query($conn, $sql_seEmp2, $params_seEmp2);
$result_seEmp2 = sqlsrv_fetch_array($query_seEmp2, SQLSRV_FETCH_ASSOC);


$sql_seChkDataPlanGo = "SELECT b.PLANING_ROUTE,b.ACTUAL_ROUTE,b.DRIVINGPATTERN_DATE 
FROM DRIVINGPATTERN_RETURN a
INNER JOIN DRIVINGPATTERN_GO b ON a.DRIVINGPATTERNGO_ID = b.DRIVINGPATTERNGO_ID

WHERE a.DRIVINGPATTERNRETURN_ID ='".$_GET['drivingbackplanid']."'";
$params_seChkDataPlanGo = array();
$query_seChkDataPlanGo  = sqlsrv_query($conn, $sql_seChkDataPlanGo, $params_seChkDataPlanGo);
$result_seChkDataPlanGo = sqlsrv_fetch_array($query_seChkDataPlanGo, SQLSRV_FETCH_ASSOC);


?>
<html lang="en">
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>ลงข้อมูลแผนขากลับ</title>

        
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
            #page-wrapper {
                border-left: 1px solid #ffcb0b;
            }
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

        <div class="row" id="list-data">
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12" style="font-size: 30px;text-align: center;">ลงข้อมูลแผนขากลับ</div>
            <div class="col-lg-4" style="font-size: 30px;text-align: center;">วันที่: <b><?=date("d-m-Y")?></b></div>
            <div class="col-lg-4" style="font-size: 30px;text-align: center;">ชื่อ-นามสกุล: <b><?=$result_seEmp1['nameT']?></b></div>
            <div class="col-lg-4" style="font-size: 30px;text-align: center;">รหัสพนักงาน: <b><?=$result_seEmp1['PersonCode']?></b></div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12" style="font-size: 30px;text-align: center;">เอกสารรูปแบบการวิ่งงาน Driver (Driving Pattern)</div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12" style="text-align: center;">
                <b style="font-size: 18px"></b>
                &nbsp;<button class="button" style="width:30%;font-size: 20px;background-color: #93f786;border:solid 2px;color:black" onclick="backpage('GoBack')">กลับหน้าหลัก</button>
                <!-- &nbsp;<button class="button" style="width:25%;font-size: 25px;background-color: #93f786;border:solid 2px;color:black" onclick="select_searchDrivingPattern('BackPlan')">แผนงานขากลับ</button> -->
            </div>
            <div class="col-lg-12">&nbsp;</div>
        </div>
        <?php

        $sql_seData = "SELECT DRIVINGPATTERNGO_ID,DRIVINGPATTERNRETURN_ID,EMPLOYEECODE1,EMPLOYEENAME1,EMPLOYEECODE2,EMPLOYEENAME2,THAINAME_ID,PLANING_ROUTE,ACTUAL_ROUTE,DRIVINGPATTERN_DATE,OFFICERCHECK_RETURN,
            PLANID1,PLANID2,TNKP_CHECK,TUBON_CHECK,TTHAIYEN_CHECK,TKAN_CHECK,JOBSTARTPLAN,DATESTARTPLAN,
            DRIVERNAME_PLAN_P1,DATESTART_PLAN_P1,PARKINGTIME_PLAN_4HUR_P1,DEPARTURETIME_PLAN_4HUR_P1,LOCATION_PLAN_4HUR_P1,PARKINGTIME_PLAN_2HUR_P1,DEPARTURETIME_PLAN_2HUR_P1,LOCATION_PLAN_2HUR_P1,
            DRIVERNAME_PLAN_P2,DATESTART_PLAN_P2,PARKINGTIME_PLAN_4HUR_P2,DEPARTURETIME_PLAN_4HUR_P2,LOCATION_PLAN_4HUR_P2,PARKINGTIME_PLAN_2HUR_P2,DEPARTURETIME_PLAN_2HUR_P2,LOCATION_PLAN_2HUR_P2,
            DRIVERNAME_PLAN_P3,DATESTART_PLAN_P3,PARKINGTIME_PLAN_4HUR_P3,DEPARTURETIME_PLAN_4HUR_P3,LOCATION_PLAN_4HUR_P3,PARKINGTIME_PLAN_2HUR_P3,DEPARTURETIME_PLAN_2HUR_P3,LOCATION_PLAN_2HUR_P3,
            DRIVERNAME_PLAN_P4,DATESTART_PLAN_P4,PARKINGTIME_PLAN_4HUR_P4,DEPARTURETIME_PLAN_4HUR_P4,LOCATION_PLAN_4HUR_P4,PARKINGTIME_PLAN_2HUR_P4,DEPARTURETIME_PLAN_2HUR_P4,LOCATION_PLAN_2HUR_P4,
            DRIVERNAME_PLAN_P5,DATESTART_PLAN_P5,PARKINGTIME_PLAN_4HUR_P5,DEPARTURETIME_PLAN_4HUR_P5,LOCATION_PLAN_4HUR_P5,PARKINGTIME_PLAN_2HUR_P5,DEPARTURETIME_PLAN_2HUR_P5,LOCATION_PLAN_2HUR_P5,
            DRIVERNAME_PLAN_P6,DATESTART_PLAN_P6,PARKINGTIME_PLAN_4HUR_P6,DEPARTURETIME_PLAN_4HUR_P6,LOCATION_PLAN_4HUR_P6,PARKINGTIME_PLAN_2HUR_P6,DEPARTURETIME_PLAN_2HUR_P6,LOCATION_PLAN_2HUR_P6,
                        
            DEALER1_PLAN,PARKINGTIME_PLAN_DEALER1,DEPARTURETIME_PLAN_DEALER1,SUM_PLAN_DEALER1,
            DEALER2_PLAN,PARKINGTIME_PLAN_DEALER2,DEPARTURETIME_PLAN_DEALER2,SUM_PLAN_DEALER2,
            DEALER3_PLAN,PARKINGTIME_PLAN_DEALER3,DEPARTURETIME_PLAN_DEALER3,SUM_PLAN_DEALER3,
            DEALER4_PLAN,PARKINGTIME_PLAN_DEALER4,DEPARTURETIME_PLAN_DEALER4,SUM_PLAN_DEALER4,
            CREATEBY_PLANRETURN,CREATEDATE_PLANRETURN,MODIFIEDBY_PLANRETURN,MODIFIEDDATE_PLANRETURN,DRIVINGPATTERNRETURN_STATUS

            FROM DRIVINGPATTERN_RETURN 
            WHERE DRIVINGPATTERNRETURN_ID ='".$_GET['drivingbackplanid']."' ";
        $params_seData = array();
        $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
        $result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC);       



            
        if ($result_seData['DRIVINGPATTERNRETURN_STATUS'] == 'inprogess') {
            $bgcolor ="background-color: #f5f2a6";
        }else{
            $bgcolor ="background-color: #ffffff";
        }

        
        ?>    
              


        <!-- START -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <!-- <div class="panel-heading" style="background-color: #e7e7e7">
                    <a href='meg_selfcheck.php'>หน้าแรก</a> / บันทึกใบแจ้งสุขภาพ
                    </div> -->
                        <div class="panel-body col-lg-12"   style="background-color: #e7e7e7;border-color:#ddd;color: #333;" >
                            <div class="col-lg-3" style="background-color: #e7e7e7;border-color:#ddd;color: #333;text-align: center;font-size: 20px"><b>เอกสารรูปแบบการวิ่งงาน</b> <br><b>(Driving Pattern)</b></div>
                            <div class="col-lg-2" style="background-color: #e7e7e7">
                                <label style="font-size: 16px;">เบอร์รถ:</label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font>
                                <input   id="txt_thainame" name="txt_thainame" class="form-control" value ="<?=$result_seChkDataPlan['THAINAME']?>" disabled=""></input>
                            </div>
                            <div class="col-lg-2" style="background-color: #e7e7e7">
                                <label style="font-size: 16px;">รูทงานตามแผน:</label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font>
                                <input type="text" class="form-control" type="hidden" id="txt_planningroute" name="txt_planningroute" value="<?=$result_seChkDataPlanGo['PLANING_ROUTE']?>" disabled="">
                            </div>
                            <div class="col-lg-2" style="background-color: #e7e7e7">
                                <label style="font-size: 16px;">รูทงานวิ่งจริง:</label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font>
                                <input type="text" class="form-control" type="hidden" id="txt_actualroute" name="txt_actualroute" value="<?=$result_seChkDataPlanGo['ACTUAL_ROUTE']?>" disabled="">
                            </div>
                            <div class="form-group">
                                <!-- <label >ช่วงเวลาของการนอน(ปกติ)</label><br><br> -->
                                <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                <div class="col-lg-2" >
                                    <?php
                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                    ?>
                                        <label style="font-size: 16px;" ><u>วัน/เดือน/ปี</u></label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font><br>
                                        <input type="datetime-local"  style="height:35px; width:315px;" id="txt_drivingdate" name="txt_drivingdate" value="<?=$result_seChkDataPlanGo['DRIVINGPATTERN_DATE']?>" min="" max=""  autocomplete="off" disabled="">
                                    <?php
                                    }else { //สำหรับ PC DESKTOP

                                        $DRIVINGPATTERN_DATECHK = str_replace("T"," ",$result_seChkDataPlanGo['DRIVINGPATTERN_DATE']);
                                        $DRIVINGPATTERN_DATE = str_replace("-","/",$DRIVINGPATTERN_DATECHK);
                                    ?> 
                                        <label style="font-size: 16px;" ><u>วัน/เดือน/ปี</u></label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font><br>
                                        <input class="form-control dateen"   style=""  id="txt_drivingdate" name="txt_drivingdate"  value="<?=$DRIVINGPATTERN_DATE?>" min="" max="" autocomplete="off" disabled="">
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-4 panel-body" style="text-align: left;background-color: #e7e7e7;">
                                <p><b><u>วัตถุประสงค์</u></b></p>
                                <p>1. การขับขี่ต่อเนื่องต้องไม่เกิน 4 ชม. และต้องพักผ่อนอย่างน้อย 30 นาที</p>
                                <p>2. สามารถขับขี่ได้ถึง 6 ชม. ต้องเปลี่ยนมือ</p>
                                <p>3. หากพบสิ่งผิดปกติให้ หยุด เรียก รอ</p>
                                <p>4. ง่วงไม่ฝืนขับ</p>
                                <!-- <label style="font-size: 20px;">แผนวิ่งงาน ขาไป:</label> -->
                            </div> 
                            <div class="col-lg-4 panel-body" style="text-align: left;background-color: #e7e7e7;">
                                <p><b><u>วีธีการ</u></b></p>
                                <p><u>ขั้นตอนเท็งโกะเริ่มงาน :</u> ให้ พขร. และผู้ควบคุมร่วมกันวางแผนวิ่งงานทราขาไปและ<br>ขากลับและให้ พขร. แบ่งหน้าที่ว่าใครเป็นนายA และนาย B<p></p>
                                <p><u>ขั้นตอนเท็งโกะเลิกงาน :</u> ให้ พขร. ลงบันทึกการขับขี่จริงพร้อมยื่นให้เจ้าหน้าที่เท็งโกะ<br>ตรวจสอบการวิ่งงานจริง<p></p>
                                <!-- <label style="font-size: 20px;">แผนวิ่งงาน ขาไป:</label> -->
                                <p><u>Driving Pattern :</u> แผนขาไป<p></p>
                                <p><u>Jobno:</u> <?=$result_seChkDataPlan['JOBNO']?> (<?=$result_seChkDataPlan['VEHICLETRANSPORTPLANID']?>)<p></p>
                                
                            </div> 
                            <div class="col-lg-4 panel-body" style="text-align: left;background-color: #e7e7e7;">
                                <p><b><u>วัตถุประสงค์</u></b></p>
                                <!-- <label style="font-size: 20px;">แผนวิ่งงาน ขาไป:</label> -->
                                <table style="border: 5px solid #dddddd;">
                                    <tr>
                                        <td colspan ="3" style="text-align: center">โปรดลงชื่อรับทราบในขึ้นตอนการทำเท็งโกะเริ่มงาน</td>
                                    </tr>
                                    <tr>
                                        <td rowspan="3" ><b>นาย A</b></ธ>
                                        <td>รหัสพนักงาน</td>
                                        <td  id ="txt_tlepidemp1_back"><?=$result_seChkDataPlan['EMPLOYEECODE1']?></td>
                                    </tr>
                                    <tr>
                                        <td>ชื่อ-นามสกุล</td>
                                        <td id ="txt_empname1_back"><?=$result_seChkDataPlan['EMPLOYEENAME1']?></td>
                                    </tr>
                                    <tr>
                                        <td>อายุงาน</td>
                                        <td><?=$result_seEmp1['yearw']?> ปี / <?=$result_seEmp1['monthw']?> เดือน / <?=$result_seEmp1['dayw']?> วัน</td>
                                    </tr>
                                    <tr>
                                        <td rowspan="3"><b>นาย B</b></td>
                                        <td>รหัสพนักงาน</td>
                                        <td id ="txt_tlepidemp2_back"><?=$result_seChkDataPlan['EMPLOYEECODE2']?></td>
                                    </tr>
                                    <tr>
                                        <td>ชื่อ-นามสกุล</td>
                                        <td id ="txt_empname2_back"><?=$result_seChkDataPlan['EMPLOYEENAME2']?></td>
                                    </tr>
                                    <tr>
                                        <td>อายุงาน</td>
                                        <td><?=$result_seEmp2['yearw']?> ปี / <?=$result_seEmp2['monthw']?> เดือน / <?=$result_seEmp2['dayw']?> วัน</td>
                                    </tr>
                                    <tr>
                                        <td><b>ผู้ตรวจแผนขากลับ</b></td>
                                        <td colspan="2" id ="txt_officerapproveback"><?=$result_seEmp1['nameT']?></td>
                                    </tr>
                                </table>
                            </div> 
                            <br><br><br>
                            <!-- <div class="panel-body" style= "text-align: center;">
                                <br><br>
                                <label style="font-size: 20px;">แผนวิ่งงาน ขาไป:</label>
                            </div>    -->
                            <div class="col-lg-12" style="background-color: #e7e7e7">
                                <p style="font-size: 26px;text-align: center;"><b><u>แผนขากลับ หมายเลขไอดี :<?=$_GET['drivingbackplanid']?></u></b></p>
                                <input type="hidden" class="form-control" id="txt_backplanid" name="txt_backplanid" value="<?=$_GET['drivingbackplanid']?>" disabled="">
                            </div> 
                            <div class="col-lg-2" style="background-color: #e7e7e7">
                                <label style="font-size: 16px;">ออกเดินทางจาก:</label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font>
                                <input type="text" class="form-control" type="hidden" id="txt_jobstartplanback" name="txt_jobstartplanback" value="<?=$result_seData['JOBSTARTPLAN']?>" >
                            </div>            
                            <div class="form-group">
                                <!-- <label >ช่วงเวลาของการนอน(ปกติ)</label><br><br> -->
                                <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                <div class="col-lg-2">
                                    <?php
                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                    ?>
                                        <label style="font-size: 16px;" ><u>วันที่/เวลาออกเดินทาง</u></label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font><br>
                                        <input type="datetime-local"  style="height:35px; width:315px;" id="txt_datestartplanback" name="txt_datestartplanback" value="<?= $result_seData['DATESTARTPLAN'] ?>" min="" max=""  autocomplete="off">
                                    <?php
                                    }else { //สำหรับ PC DESKTOP

                                        $DATESTARTPLANCHK = str_replace("T"," ",$result_seData['DATESTARTPLAN']);
                                        $DATESTARTPLAN = str_replace("-","/",$DATESTARTPLANCHK);
                                    ?> 
                                        <label style="font-size: 16px;" ><u>วันที่/เวลาออกเดินทาง</u></label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font><br>
                                        <input class="form-control dateen"   style=""  id="txt_datestartplanback" name="txt_datestartplanback"  value="<?= $DATESTARTPLAN ?>" min="" max="" autocomplete="off">
                                    <?php
                                    }
                                    ?>
                                </div>
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
                                        <!-- <input type="hidden" name= "txt_datedriverchk" id="txt_datedriverchk" value="<?=$_GET['datedriverchk']?>"></input>
                                        <input type="hidden" name= "txt_dateworkingchk" id="txt_dateworkingchk" value="<?=$_GET['daterkchk']?>"></input>
                                        <input type="hidden" name= "txt_datepresentchk" id="txt_datepresentchk" value="<?=$_GET['datepresentchk']?>"></input>
                                        <input type="hidden" name= "txt_empname" id="txt_empname" value="<?=$_GET['employeename']?>"></input>
                                        <input type="hidden" name= "txt_empcode" id="txt_empcode" value="<?=$_GET['employeecode']?>"></input>
                                        <input type="hidden" name= "txt_selfchkid" id="txt_selfchkid" value="<?=$result_seSelfCheck['SELFCHECKID']?>"></input>
                                        <input type="hidden" name= "txt_selfsession" id="txt_selfsession" value="<?=$_SESSION["USERNAME"]?>"></input> -->
                                            
                                    </div>        
                                    <div class ="row"><br></div>
                                    <!-- START ROW1 -->
                                    <div class="row" >
                                        <div class="col-lg-4" >
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #f0c402;">
                                                    <label><font style="font-size: 16px;">แผนขากลับ (ช่วงที่1)</font></label>
                                                </div>
                                                <!-- /.panel-heading -->
                                                <div class="panel-body">
                                                    <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                        <div class="col-lg-6">
                                                            <label style="font-size: 16px;">ชื่อผู้ขับ:</label>
                                                            <select   id="txt_drivernameplan_p1_back" name="txt_drivernameplan_p1_back" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก เบอร์รถ..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                <option hidden value="<?=$result_seData['DRIVERNAME_PLAN_P1']?>"><?=$result_seData['DRIVERNAME_PLAN_P1']?></option>
                                                                <option value="<?= $result_seChkDataPlan['EMPLOYEENAME1'] ?>"><?= $result_seChkDataPlan['EMPLOYEENAME1'] ?></option>
                                                                <option value="<?= $result_seChkDataPlan['EMPLOYEENAME2'] ?>"><?= $result_seChkDataPlan['EMPLOYEENAME2'] ?></option>
                                                            </select>
                                                        </div>
                                                        <!-- <label >ช่วงเวลาของการนอน(ปกติ)</label><br><br> -->
                                                        <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                        <div class="col-lg-6">
                                                            <label ><u>เวลาเริ่มขับ</u></label>
                                                            <?php
                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                            ?>
                                                                <br>
                                                                <input type="datetime-local"  style="height:40px; width:240px" id="txt_datestartplan_p1_back" name="txt_datestartplan_p1_back" value="<?= $result_seData['DATESTART_PLAN_P1'] ?>" min="" max="" autocomplete="off">
                                                            <?php
                                                            }else { //สำหรับ PC DESKTOP

                                                                $DATESTART_PLAN_P1CHK = str_replace("T"," ",$result_seData['DATESTART_PLAN_P1']);
                                                                $DATESTART_PLAN_P1 = str_replace("-","/",$DATESTART_PLAN_P1CHK);
                                                            ?> 
                                                                <br>
                                                                <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_datestartplan_p1_back" name="txt_datestartplan_p1_back"  value="<?= $DATESTART_PLAN_P1 ?>" min="" max="" autocomplete="off">
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class = "row" style="height:80px;">
                                                            
                                                        </div>
                                                        <div class = "row">
                                                            <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 100%;text-align: center;background-color: #e7e7e7" >ระยะเวลาการขับรถ 4 ชั่วโมง</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>  
                                                        </div>
                                                        <div class = "row">
                                                            <div class="">
                                                                <form class="form-inline">
                                                                    <div class="form-group">
                                                                        <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                                        <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                                        <div class="col-lg-6">
                                                                        <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_4hur_p1_back" name="txt_parkingtime_plan_4hur_p1_back" value="<?=$result_seData['PARKINGTIME_PLAN_4HUR_P1']?>" min="" max="" onchange ="parkingtime_plan_4hrs_p1_back('MB');" autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP

                                                                                $PARKINGTIME_PLAN_4HUR_P1CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_4HUR_P1']);
                                                                                $PARKINGTIME_PLAN_4HUR_P1 = str_replace("-","/",$PARKINGTIME_PLAN_4HUR_P1CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_4hur_p1_back" name="txt_parkingtime_plan_4hur_p1_back"  value="<?= $PARKINGTIME_PLAN_4HUR_P1 ?>" min="" max="" onchange ="parkingtime_plan_4hrs_p1_back('DT');" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p1_back" name="txt_departuretime_plan_4hur_p1_back" value="<?= $result_seData['DEPARTURETIME_PLAN_4HUR_P1'] ?>" min="" max=""  autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP
                                                                                // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                $DEPARTURETIME_PLAN_4HUR_P1CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_4HUR_P1']);
                                                                                $DEPARTURETIME_PLAN_4HUR_P1 = str_replace("-","/",$DEPARTURETIME_PLAN_4HUR_P1CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p1_back" name="txt_departuretime_plan_4hur_p1_back" value="<?= $DEPARTURETIME_PLAN_4HUR_P1 ?>" min="" max="" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class = "row">
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_plan_4hur_p1_back" name="txt_location_plan_4hur_p1_back" value="<?= $result_seData['LOCATION_PLAN_4HUR_P1'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class = "row">
                                                            <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 100%;text-align: center;background-color: #e7e7e7" >ระยะเวลาการขับรถ 2 ชั่วโมง</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>  
                                                        </div>
                                                        <div class = "row">
                                                            <div class="">
                                                                <form class="form-inline">
                                                                    <div class="form-group">
                                                                        <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                                        <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                                        <div class="col-lg-6">
                                                                        <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_2hur_p1_back" name="txt_parkingtime_plan_2hur_p1_back" value="<?= $result_seData['PARKINGTIME_PLAN_2HUR_P1'] ?>" min="" max="" onchange ="parkingtime_plan_2hrs_p1_back('DT');" autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP

                                                                                $PARKINGTIME_PLAN_2HUR_P1CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_2HUR_P1']);
                                                                                $PARKINGTIME_PLAN_2HUR_P1 = str_replace("-","/",$PARKINGTIME_PLAN_2HUR_P1CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_2hur_p1_back" name="txt_parkingtime_plan_2hur_p1_back"  value="<?= $PARKINGTIME_PLAN_2HUR_P1 ?>" min="" max="" onchange ="parkingtime_plan_2hrs_p1_back('DT');" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p1_back" name="txt_departuretime_plan_2hur_p1_back" value="<?= $result_seData['DEPARTURETIME_PLAN_2HUR_P1'] ?>" min="" max=""  autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP
                                                                                // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                $DEPARTURETIME_PLAN_2HUR_P1CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_2HUR_P1']);
                                                                                $DEPARTURETIME_PLAN_2HUR_P1 = str_replace("-","/",$DEPARTURETIME_PLAN_2HUR_P1CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p1_back" name="txt_departuretime_plan_2hur_p1_back" value="<?= $DEPARTURETIME_PLAN_2HUR_P1 ?>" min="" max="" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class = "row">
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_plan_2hur_p1_back" name="txt_location_plan_2hur_p1_back" value="<?= $result_seData['LOCATION_PLAN_2HUR_P1'] ?>" min="" max="" autocomplete="off">
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
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END COLUNM1 -->  


                                        <!-- START COLUNM2 -->
                                        <div class="col-lg-4" >
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #f0c402;">
                                                    <label><font style="font-size: 16px;">แผนขากลับ (ช่วงที่2)</font></label>
                                                </div>
                                                <!-- /.panel-heading -->
                                                <div class="panel-body">
                                                    <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                        <div class="col-lg-6">
                                                            <label style="font-size: 16px;">ชื่อผู้ขับ:</label>
                                                            <select   id="txt_drivernameplan_p2_back" name="txt_drivernameplan_p2_back" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก เบอร์รถ..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                <option hidden value="<?=$result_seData['DRIVERNAME_PLAN_P2']?>"><?=$result_seData['DRIVERNAME_PLAN_P2']?></option>
                                                                <option value="<?= $result_seChkDataPlan['EMPLOYEENAME1'] ?>"><?= $result_seChkDataPlan['EMPLOYEENAME1'] ?></option>
                                                                <option value="<?= $result_seChkDataPlan['EMPLOYEENAME2'] ?>"><?= $result_seChkDataPlan['EMPLOYEENAME2'] ?></option>
                                                            </select>
                                                        </div>
                                                        <!-- <label >ช่วงเวลาของการนอน(ปกติ)</label><br><br> -->
                                                        <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                        <div class="col-lg-6">
                                                            <label ><u>เวลาเริ่มขับ</u></label>
                                                            <?php
                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                            ?>
                                                                <br>
                                                                <input type="datetime-local"  style="height:40px; width:240px" id="txt_datestartplan_p2_back" name="txt_datestartplan_p2_back" value="<?= $result_seData['DATESTART_PLAN_P2'] ?>" min="" max=""  autocomplete="off">
                                                            <?php
                                                            }else { //สำหรับ PC DESKTOP

                                                                $DATESTART_PLAN_P2CHK = str_replace("T"," ",$result_seData['DATESTART_PLAN_P2']);
                                                                $DATESTART_PLAN_P2 = str_replace("-","/",$DATESTART_PLAN_P2CHK);
                                                            ?> 
                                                                <br>
                                                                <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_datestartplan_p2_back" name="txt_datestartplan_p2_back"  value="<?= $DATESTART_PLAN_P2 ?>" min="" max="" autocomplete="off">
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class = "row" style="height:80px;">
                                                            
                                                        </div>
                                                        <div class = "row">
                                                            <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 100%;text-align: center;background-color: #e7e7e7" >ระยะเวลาการขับรถ 4 ชั่วโมง</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>  
                                                        </div>
                                                        <div class = "row">
                                                            <div class="">
                                                                <form class="form-inline">
                                                                    <div class="form-group">
                                                                        <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                                        <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                                        <div class="col-lg-6">
                                                                        <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_4hur_p2_back" name="txt_parkingtime_plan_4hur_p2_back" value="<?= $result_seData['PARKINGTIME_PLAN_4HUR_P2'] ?>" min="" max="" onchange ="parkingtime_plan_4hrs_p2_back('MB');" autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP

                                                                                $PARKINGTIME_PLAN_4HUR_P2CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_4HUR_P2']);
                                                                                $PARKINGTIME_PLAN_4HUR_P2 = str_replace("-","/",$PARKINGTIME_PLAN_4HUR_P2CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_4hur_p2_back" name="txt_parkingtime_plan_4hur_p2_back"  value="<?=$PARKINGTIME_PLAN_4HUR_P2?>" min="" max="" onchange ="parkingtime_plan_4hrs_p2_back('DT');" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p2_back" name="txt_departuretime_plan_4hur_p2_back" value="<?= $result_seData['DEPARTURETIME_PLAN_4HUR_P2'] ?>" min="" max=""  autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP
                                                                                // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                $DEPARTURETIME_PLAN_4HUR_P2CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_4HUR_P2']);
                                                                                $DEPARTURETIME_PLAN_4HUR_P2 = str_replace("-","/",$DEPARTURETIME_PLAN_4HUR_P2CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p2_back" name="txt_departuretime_plan_4hur_p2_back" value="<?= $DEPARTURETIME_PLAN_4HUR_P2 ?>" min="" max="" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class = "row">
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_plan_4hur_p2_back" name="txt_location_plan_4hur_p2_back" value="<?= $result_seData['LOCATION_PLAN_4HUR_P2'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class = "row">
                                                            <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 100%;text-align: center;background-color: #e7e7e7" >ระยะเวลาการขับรถ 2 ชั่วโมง</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>  
                                                        </div>
                                                        <div class = "row">
                                                            <div class="">
                                                                <form class="form-inline">
                                                                    <div class="form-group">
                                                                        <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                                        <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                                        <div class="col-lg-6">
                                                                        <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_2hur_p2_back" name="txt_parkingtime_plan_2hur_p2_back" value="<?= $result_seData['PARKINGTIME_PLAN_2HUR_P2'] ?>" min="" max=""  onchange ="parkingtime_plan_2hrs_p2_back('MB');" autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP

                                                                                $PARKINGTIME_PLAN_2HUR_P2CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_2HUR_P2']);
                                                                                $PARKINGTIME_PLAN_2HUR_P2 = str_replace("-","/",$PARKINGTIME_PLAN_2HUR_P2CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_2hur_p2_back" name="txt_parkingtime_plan_2hur_p2_back"  value="<?= $PARKINGTIME_PLAN_2HUR_P2 ?>" min="" max="" onchange ="parkingtime_plan_2hrs_p2_back('DT');" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p2_back" name="txt_departuretime_plan_2hur_p2_back" value="<?= $result_seData['DEPARTURETIME_PLAN_2HUR_P2'] ?>" min="" max=""  autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP
                                                                                // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                $DEPARTURETIME_PLAN_2HUR_P2CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_2HUR_P2']);
                                                                                $DEPARTURETIME_PLAN_2HUR_P2 = str_replace("-","/",$DEPARTURETIME_PLAN_2HUR_P2CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p2_back" name="txt_departuretime_plan_2hur_p2_back" value="<?= $DEPARTURETIME_PLAN_2HUR_P2 ?>" min="" max="" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class = "row">
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_plan_2hur_p2_back" name="txt_location_plan_2hur_p2_back" value="<?= $result_seData['LOCATION_PLAN_2HUR_P2'] ?>" min="" max="" autocomplete="off">
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
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END COLUNM2 -->   
                                                                                
                                        <!-- START COLUNM3 -->
                                        <div class="col-lg-4" >
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #f0c402;">
                                                    <label><font style="font-size: 16px;">แผนขากลับ (ช่วงที่3)</font></label>
                                                </div>
                                                <!-- /.panel-heading -->
                                                <div class="panel-body">
                                                    <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                        <div class="col-lg-6">
                                                            <label style="font-size: 16px;">ชื่อผู้ขับ:</label>
                                                            <select   id="txt_drivernameplan_p3_back" name="txt_drivernameplan_p3_back" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก เบอร์รถ..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                <option hidden value="<?=$result_seData['DRIVERNAME_PLAN_P3']?>"><?=$result_seData['DRIVERNAME_PLAN_P3']?></option>
                                                                <option value="<?= $result_seChkDataPlan['EMPLOYEENAME1'] ?>"><?= $result_seChkDataPlan['EMPLOYEENAME1'] ?></option>
                                                                <option value="<?= $result_seChkDataPlan['EMPLOYEENAME2'] ?>"><?= $result_seChkDataPlan['EMPLOYEENAME2'] ?></option>
                                                            </select>
                                                        </div>
                                                        <!-- <label >ช่วงเวลาของการนอน(ปกติ)</label><br><br> -->
                                                        <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                        <div class="col-lg-6">
                                                            <label ><u>เวลาเริ่มขับ</u></label>
                                                            <?php
                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                            ?>
                                                                <br>
                                                                <input type="datetime-local"  style="height:40px; width:240px" id="txt_datestartplan_p3_back" name="txt_datestartplan_p3_back" value="<?= $result_seData['DATESTART_PLAN_P3'] ?>" min="" max="" autocomplete="off">
                                                            <?php
                                                            }else { //สำหรับ PC DESKTOP

                                                                $DATESTART_PLAN_P3CHK = str_replace("T"," ",$result_seData['DATESTART_PLAN_P3']);
                                                                $DATESTART_PLAN_P3 = str_replace("-","/",$DATESTART_PLAN_P3CHK);
                                                            ?> 
                                                                <br>
                                                                <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_datestartplan_p3_back" name="txt_datestartplan_p3_back"  value="<?= $DATESTART_PLAN_P3 ?>" min="" max="" autocomplete="off">
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class = "row" style="height:80px;">
                                                            
                                                        </div>
                                                        <div class = "row">
                                                            <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 100%;text-align: center;background-color: #e7e7e7" >ระยะเวลาการขับรถ 4 ชั่วโมง</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>  
                                                        </div>
                                                        <div class = "row">
                                                            <div class="">
                                                                <form class="form-inline">
                                                                    <div class="form-group">
                                                                        <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                                        <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                                        <div class="col-lg-6">
                                                                        <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_4hur_p3_back" name="txt_parkingtime_plan_4hur_p3_back" value="<?= $result_seData['PARKINGTIME_PLAN_4HUR_P3'] ?>" min="" max="" onchange ="parkingtime_plan_4hrs_p3_back('MB');" autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP

                                                                                $PARKINGTIME_PLAN_4HUR_P3CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_4HUR_P3']);
                                                                                $PARKINGTIME_PLAN_4HUR_P3 = str_replace("-","/",$PARKINGTIME_PLAN_4HUR_P3CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_4hur_p3_back" name="txt_parkingtime_plan_4hur_p3_back"  value="<?= $PARKINGTIME_PLAN_4HUR_P3 ?>" min="" max="" onchange ="parkingtime_plan_4hrs_p3_back('DT');" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p3_back" name="txt_departuretime_plan_4hur_p3_back" value="<?= $result_seData['DEPARTURETIME_PLAN_4HUR_P3'] ?>" min="" max=""  autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP
                                                                                // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                $DEPARTURETIME_PLAN_4HUR_P3CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_4HUR_P3']);
                                                                                $DEPARTURETIME_PLAN_4HUR_P3 = str_replace("-","/",$DEPARTURETIME_PLAN_4HUR_P3CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p3_back" name="txt_departuretime_plan_4hur_p3_back" value="<?= $DEPARTURETIME_PLAN_4HUR_P3 ?>" min="" max="" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class = "row">
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_plan_4hur_p3_back" name="txt_location_plan_4hur_p3_back" value="<?= $result_seData['LOCATION_PLAN_4HUR_P3'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class = "row">
                                                            <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 100%;text-align: center;background-color: #e7e7e7" >ระยะเวลาการขับรถ 2 ชั่วโมง</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>  
                                                        </div>
                                                        <div class = "row">
                                                            <div class="">
                                                                <form class="form-inline">
                                                                    <div class="form-group">
                                                                        <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                                        <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                                        <div class="col-lg-6">
                                                                        <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_2hur_p3_back" name="txt_parkingtime_plan_2hur_p3_back" value="<?= $result_seData['PARKINGTIME_PLAN_2HUR_P3'] ?>" min="" max=""  onchange ="parkingtime_plan_2hrs_p3_back('MB');" autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP

                                                                                $PARKINGTIME_PLAN_2HUR_P3CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_2HUR_P3']);
                                                                                $PARKINGTIME_PLAN_2HUR_P3 = str_replace("-","/",$PARKINGTIME_PLAN_2HUR_P3CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_2hur_p3_back" name="txt_parkingtime_plan_2hur_p3_back"  value="<?= $PARKINGTIME_PLAN_2HUR_P3 ?>" min="" max="" onchange ="parkingtime_plan_2hrs_p3_back('DT');" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p3_back" name="txt_departuretime_plan_2hur_p3_back" value="<?= $result_seData['DEPARTURETIME_PLAN_2HUR_P3'] ?>" min="" max="" onchange ="" autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP
                                                                                // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                $DEPARTURETIME_PLAN_2HUR_P3CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_2HUR_P3']);
                                                                                $DEPARTURETIME_PLAN_2HUR_P3 = str_replace("-","/",$DEPARTURETIME_PLAN_2HUR_P3CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p3_back" name="txt_departuretime_plan_2hur_p3_back" value="<?= $DEPARTURETIME_PLAN_2HUR_P3 ?>" min="" max="" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class = "row">
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_plan_2hur_p3_back" name="txt_location_plan_2hur_p3_back" value="<?= $result_seData['LOCATION_PLAN_2HUR_P3'] ?>" min="" max="" autocomplete="off">
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
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END COLUNM3 -->

                                        <!-- START COLUNM4 -->
                                        <div class="col-lg-4" >
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #f0c402;">
                                                    <label><font style="font-size: 16px;">แผนขากลับ (ช่วงที่4)</font></label>
                                                </div>
                                                <!-- /.panel-heading -->
                                                <div class="panel-body">
                                                    <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                        <div class="col-lg-6">
                                                            <label style="font-size: 16px;">ชื่อผู้ขับ:</label>
                                                            <select   id="txt_drivernameplan_p4_back" name="txt_drivernameplan_p4_back" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก เบอร์รถ..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                <option hidden value="<?=$result_seData['DRIVERNAME_PLAN_P4']?>"><?=$result_seData['DRIVERNAME_PLAN_P4']?></option>
                                                                <option value="<?= $result_seChkDataPlan['EMPLOYEENAME1'] ?>"><?= $result_seChkDataPlan['EMPLOYEENAME1'] ?></option>
                                                                <option value="<?= $result_seChkDataPlan['EMPLOYEENAME2'] ?>"><?= $result_seChkDataPlan['EMPLOYEENAME2'] ?></option>
                                                            </select>
                                                        </div>
                                                        <!-- <label >ช่วงเวลาของการนอน(ปกติ)</label><br><br> -->
                                                        <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                        <div class="col-lg-6">
                                                            <label ><u>เวลาเริ่มขับ</u></label>
                                                            <?php
                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                            ?>
                                                                <br>
                                                                <input type="datetime-local"  style="height:40px; width:240px" id="txt_datestartplan_p4_back" name="txt_datestartplan_p4_back" value="<?= $result_seData['DATESTART_PLAN_P4'] ?>" min="" max=""  autocomplete="off">
                                                            <?php
                                                            }else { //สำหรับ PC DESKTOP

                                                                $DATESTART_PLAN_P4CHK = str_replace("T"," ",$result_seData['DATESTART_PLAN_P4']);
                                                                $DATESTART_PLAN_P4 = str_replace("-","/",$DATESTART_PLAN_P4CHK);
                                                            ?> 
                                                                <br>
                                                                <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_datestartplan_p4_back" name="txt_datestartplan_p4_back"  value="<?= $DATESTART_PLAN_P4 ?>" min="" max="" autocomplete="off">
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class = "row" style="height:80px;">
                                                            
                                                        </div>
                                                        <div class = "row">
                                                            <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 100%;text-align: center;background-color: #e7e7e7" >ระยะเวลาการขับรถ 4 ชั่วโมง</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>  
                                                        </div>
                                                        <div class = "row">
                                                            <div class="">
                                                                <form class="form-inline">
                                                                    <div class="form-group">
                                                                        <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                                        <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                                        <div class="col-lg-6">
                                                                        <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_4hur_p4_back" name="txt_parkingtime_plan_4hur_p4_back" value="<?= $result_seData['PARKINGTIME_PLAN_4HUR_P4'] ?>" min="" max="" onchange ="parkingtime_plan_4hrs_p4_back('MB');" autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP

                                                                                $PARKINGTIME_PLAN_4HUR_P4CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_4HUR_P4']);
                                                                                $PARKINGTIME_PLAN_4HUR_P4 = str_replace("-","/",$PARKINGTIME_PLAN_4HUR_P4CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_4hur_p4_back" name="txt_parkingtime_plan_4hur_p4_back"  value="<?= $PARKINGTIME_PLAN_4HUR_P4 ?>" min="" max="" onchange ="parkingtime_plan_4hrs_p4_back('DT');" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p4_back" name="txt_departuretime_plan_4hur_p4_back" value="<?= $result_seData['DEPARTURETIME_PLAN_4HUR_P4'] ?>" min="" max=""  autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP
                                                                                // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                $DEPARTURETIME_PLAN_4HUR_P4CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_4HUR_P4']);
                                                                                $DEPARTURETIME_PLAN_4HUR_P4 = str_replace("-","/",$DEPARTURETIME_PLAN_4HUR_P4CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p4_back" name="txt_departuretime_plan_4hur_p4_back" value="<?= $DEPARTURETIME_PLAN_4HUR_P4 ?>" min="" max="" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class = "row">
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_plan_4hur_p4_back" name="txt_location_plan_4hur_p4_back" value="<?= $result_seData['LOCATION_PLAN_4HUR_P4'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class = "row">
                                                            <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 100%;text-align: center;background-color: #e7e7e7" >ระยะเวลาการขับรถ 2 ชั่วโมง</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>  
                                                        </div>
                                                        <div class = "row">
                                                            <div class="">
                                                                <form class="form-inline">
                                                                    <div class="form-group">
                                                                        <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                                        <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                                        <div class="col-lg-6">
                                                                        <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_2hur_p4_back" name="txt_parkingtime_plan_2hur_p4_back" value="<?= $result_seData['PARKINGTIME_PLAN_2HUR_P4'] ?>" min="" max=""  onchange ="parkingtime_plan_2hrs_p4_back('MB');" autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP

                                                                                $PARKINGTIME_PLAN_2HUR_P4CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_2HUR_P4']);
                                                                                $PARKINGTIME_PLAN_2HUR_P4 = str_replace("-","/",$PARKINGTIME_PLAN_2HUR_P4CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_2hur_p4_back" name="txt_parkingtime_plan_2hur_p4_back"  value="<?= $PARKINGTIME_PLAN_2HUR_P4 ?>" min="" max="" onchange ="parkingtime_plan_2hrs_p4_back('DT');" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p4_back" name="txt_departuretime_plan_2hur_p4_back" value="<?= $result_seData['DEPARTURETIME_PLAN_2HUR_P4'] ?>" min="" max=""  autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP
                                                                                // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                $DEPARTURETIME_PLAN_2HUR_P4CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_2HUR_P4']);
                                                                                $DEPARTURETIME_PLAN_2HUR_P4 = str_replace("-","/",$DEPARTURETIME_PLAN_2HUR_P4CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p4_back" name="txt_departuretime_plan_2hur_p4_back" value="<?= $DEPARTURETIME_PLAN_2HUR_P4 ?>" min="" max="" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class = "row">
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_plan_2hur_p4_back" name="txt_location_plan_2hur_p4_back" value="<?= $result_seData['LOCATION_PLAN_2HUR_P4'] ?>" min="" max=""  autocomplete="off">
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
                                                </div>
                                            </div>
                                        </div>   
                                        <!--END COLUNM4  -->
                                        <!-- START COLUNM5 -->
                                        <div class="col-lg-4" >
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #f0c402;">
                                                    <label><font style="font-size: 16px;">แผนขากลับ (ช่วงที่5)</font></label>
                                                </div>
                                                <!-- /.panel-heading -->
                                                <div class="panel-body">
                                                    <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                        <div class="col-lg-6">
                                                            <label style="font-size: 16px;">ชื่อผู้ขับ:</label>
                                                            <select   id="txt_drivernameplan_p5_back" name="txt_drivernameplan_p5_back" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก เบอร์รถ..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                <option hidden value="<?=$result_seData['DRIVERNAME_PLAN_P5']?>"><?=$result_seData['DRIVERNAME_PLAN_P5']?></option>
                                                                <option value="<?= $result_seChkDataPlan['EMPLOYEENAME1'] ?>"><?= $result_seChkDataPlan['EMPLOYEENAME1'] ?></option>
                                                                <option value="<?= $result_seChkDataPlan['EMPLOYEENAME2'] ?>"><?= $result_seChkDataPlan['EMPLOYEENAME2'] ?></option>
                                                            </select>
                                                        </div>
                                                        <!-- <label >ช่วงเวลาของการนอน(ปกติ)</label><br><br> -->
                                                        <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                        <div class="col-lg-6">
                                                            <label ><u>เวลาเริ่มขับ</u></label>
                                                            <?php
                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                            ?>
                                                                <br>
                                                                <input type="datetime-local"  style="height:40px; width:240px" id="txt_datestartplan_p5_back" name="txt_datestartplan_p5_back" value="<?= $result_seData['DATESTART_PLAN_P5'] ?>" min="" max=""  autocomplete="off">
                                                            <?php
                                                            }else { //สำหรับ PC DESKTOP

                                                                $DATESTART_PLAN_P5CHK = str_replace("T"," ",$result_seData['DATESTART_PLAN_P5']);
                                                                $DATESTART_PLAN_P5 = str_replace("-","/",$DATESTART_PLAN_P5CHK);
                                                            ?> 
                                                                <br>
                                                                <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_datestartplan_p5_back" name="txt_datestartplan_p5_back"  value="<?= $DATESTART_PLAN_P5 ?>" min="" max="" autocomplete="off">
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class = "row" style="height:80px;">
                                                            
                                                        </div>
                                                        <div class = "row">
                                                            <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 100%;text-align: center;background-color: #e7e7e7" >ระยะเวลาการขับรถ 4 ชั่วโมง</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>  
                                                        </div>
                                                        <div class = "row">
                                                            <div class="">
                                                                <form class="form-inline">
                                                                    <div class="form-group">
                                                                        <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                                        <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                                        <div class="col-lg-6">
                                                                        <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_4hur_p5_back" name="txt_parkingtime_plan_4hur_p5_back" value="<?= $result_seData['PARKINGTIME_PLAN_4HUR_P5'] ?>" min="" max=""  onchange ="parkingtime_plan_4hrs_p5_back('MB');" autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP

                                                                                $PARKINGTIME_PLAN_4HUR_P5CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_4HUR_P5']);
                                                                                $PARKINGTIME_PLAN_4HUR_P5 = str_replace("-","/",$PARKINGTIME_PLAN_4HUR_P5CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_4hur_p5_back" name="txt_parkingtime_plan_4hur_p5_back"  value="<?= $PARKINGTIME_PLAN_4HUR_P5 ?>" min="" max="" onchange ="parkingtime_plan_4hrs_p5_back('DT');" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p5_back" name="txt_departuretime_plan_4hur_p_back5" value="<?= $result_seData['DEPARTURETIME_PLAN_4HUR_P5'] ?>" min="" max=""  autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP
                                                                                // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                $DEPARTURETIME_PLAN_4HUR_P5CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_4HUR_P5']);
                                                                                $DEPARTURETIME_PLAN_4HUR_P5 = str_replace("-","/",$DEPARTURETIME_PLAN_4HUR_P5CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p5_back" name="txt_departuretime_plan_4hur_p5_back" value="<?= $DEPARTURETIME_PLAN_4HUR_P5 ?>" min="" max="" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class = "row">
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_plan_4hur_p5_back" name="txt_location_plan_4hur_p5_back" value="<?= $result_seData['LOCATION_PLAN_4HUR_P5'] ?>" min="" max="" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class = "row">
                                                            <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 100%;text-align: center;background-color: #e7e7e7" >ระยะเวลาการขับรถ 2 ชั่วโมง</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>  
                                                        </div>
                                                        <div class = "row">
                                                            <div class="">
                                                                <form class="form-inline">
                                                                    <div class="form-group">
                                                                        <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                                        <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                                        <div class="col-lg-6">
                                                                        <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_2hur_p5_back" name="txt_parkingtime_plan_2hur_p5_back" value="<?= $result_seData['PARKINGTIME_PLAN_2HUR_P5'] ?>" min="" max=""  onchange ="parkingtime_plan_2hrs_p5_back('MB');" autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP

                                                                                $PARKINGTIME_PLAN_2HUR_P5CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_2HUR_P5']);
                                                                                $PARKINGTIME_PLAN_2HUR_P5 = str_replace("-","/",$PARKINGTIME_PLAN_2HUR_P5CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_2hur_p5_back" name="txt_parkingtime_plan_2hur_p5_back"  value="<?= $PARKINGTIME_PLAN_2HUR_P5 ?>" min="" max="" onchange ="parkingtime_plan_2hrs_p5_back('DT');" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p5_back" name="txt_departuretime_plan_2hur_p5_back" value="<?= $result_seData['DEPARTURETIME_PLAN_2HUR_P5'] ?>" min="" max=""  autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP
                                                                                // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                $DEPARTURETIME_PLAN_2HUR_P5CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_2HUR_P5']);
                                                                                $DEPARTURETIME_PLAN_2HUR_P5 = str_replace("-","/",$DEPARTURETIME_PLAN_2HUR_P5CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p5_back" name="txt_departuretime_plan_2hur_p5_back" value="<?= $DEPARTURETIME_PLAN_2HUR_P5 ?>" min="" max="" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class = "row">
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_plan_2hur_p5_back" name="txt_location_plan_2hur_p5_back" value="<?= $result_seData['LOCATION_PLAN_2HUR_P5'] ?>" min="" max=""  autocomplete="off">
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
                                                </div>
                                            </div>
                                        </div>
                                        <!--END COLUNM5  --> 

                                        <!-- START COLUNM6 -->
                                        <div class="col-lg-4" >
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #f0c402;">
                                                    <label><font style="font-size: 16px;">แผนขากลับ (ช่วงที่6)</font></label>
                                                </div>
                                                <!-- /.panel-heading -->
                                                <div class="panel-body">
                                                    <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                        <div class="col-lg-6">
                                                            <label style="font-size: 16px;">ชื่อผู้ขับ:</label>
                                                            <select   id="txt_drivernameplan_p6_back" name="txt_drivernameplan_p6_back" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก เบอร์รถ..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                <option hidden value="<?=$result_seData['DRIVERNAME_PLAN_P6']?>"><?=$result_seData['DRIVERNAME_PLAN_P6']?></option>
                                                                <option value="<?= $result_seChkDataPlan['EMPLOYEENAME1'] ?>"><?= $result_seChkDataPlan['EMPLOYEENAME1'] ?></option>
                                                                <option value="<?= $result_seChkDataPlan['EMPLOYEENAME2'] ?>"><?= $result_seChkDataPlan['EMPLOYEENAME2'] ?></option>
                                                            </select>
                                                        </div>
                                                        <!-- <label >ช่วงเวลาของการนอน(ปกติ)</label><br><br> -->
                                                        <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                        <div class="col-lg-6">
                                                            <label ><u>เวลาเริ่มขับ</u></label>
                                                            <?php
                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                            ?>
                                                                <br>
                                                                <input type="datetime-local"  style="height:40px; width:240px" id="txt_datestartplan_p6_back" name="txt_datestartplan_p6_back" value="<?= $result_seData['DATESTART_PLAN_P6'] ?>" min="" max=""  autocomplete="off">
                                                            <?php
                                                            }else { //สำหรับ PC DESKTOP

                                                                $DATESTART_PLAN_P6CHK = str_replace("T"," ",$result_seData['DATESTART_PLAN_P6']);
                                                                $DATESTART_PLAN_P6 = str_replace("-","/",$DATESTART_PLAN_P6CHK);
                                                            ?> 
                                                                <br>
                                                                <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_datestartplan_p6_back" name="txt_datestartplan_p6_back"  value="<?= $DATESTART_PLAN_P6 ?>" min="" max="" autocomplete="off">
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class = "row" style="height:80px;">
                                                            
                                                        </div>
                                                        <div class = "row">
                                                            <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 100%;text-align: center;background-color: #e7e7e7" >ระยะเวลาการขับรถ 4 ชั่วโมง</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>  
                                                        </div>
                                                        <div class = "row">
                                                            <div class="">
                                                                <form class="form-inline">
                                                                    <div class="form-group">
                                                                        <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                                        <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                                        <div class="col-lg-6">
                                                                        <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_4hur_p6_back" name="txt_parkingtime_plan_4hur_p6_back" value="<?= $result_seData['PARKINGTIME_PLAN_4HUR_P6'] ?>" min="" max=""  onchange ="parkingtime_plan_4hrs_p6_back('MB');" autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP

                                                                                $PARKINGTIME_PLAN_4HUR_P6CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_4HUR_P6']);
                                                                                $PARKINGTIME_PLAN_4HUR_P6 = str_replace("-","/",$PARKINGTIME_PLAN_4HUR_P6CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_4hur_p6_back" name="txt_parkingtime_plan_4hur_p6_back"  value="<?= $PARKINGTIME_PLAN_4HUR_P6 ?>" min="" max="" onchange ="parkingtime_plan_4hrs_p6_back('DT');" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p6_back" name="txt_departuretime_plan_4hur_p6_back" value="<?= $result_seData['DEPARTURETIME_PLAN_4HUR_P6'] ?>" min="" max=""  autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP
                                                                                // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                $DEPARTURETIME_PLAN_4HUR_P6CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_4HUR_P6']);
                                                                                $DEPARTURETIME_PLAN_4HUR_P6 = str_replace("-","/",$DEPARTURETIME_PLAN_4HUR_P6CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p6_back" name="txt_departuretime_plan_4hur_p6_back" value="<?= $DEPARTURETIME_PLAN_4HUR_P6 ?>" min="" max="" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class = "row">
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_plan_4hur_p6_back" name="txt_location_plan_4hur_p6_back" value="<?= $result_seData['LOCATION_PLAN_4HUR_P6'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class = "row">
                                                            <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 100%;text-align: center;background-color: #e7e7e7" >ระยะเวลาการขับรถ 2 ชั่วโมง</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>  
                                                        </div>
                                                        <div class = "row">
                                                            <div class="">
                                                                <form class="form-inline">
                                                                    <div class="form-group">
                                                                        <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                                        <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                                        <div class="col-lg-6">
                                                                        <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_2hur_p6_back" name="txt_parkingtime_plan_2hur_p6_back" value="<?= $result_seData['PARKINGTIME_PLAN_2HUR_P6'] ?>" min="" max=""  onchange ="parkingtime_plan_2hrs_p6_back('MB');" autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP

                                                                                $PARKINGTIME_PLAN_2HUR_P6CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_2HUR_P6']);
                                                                                $PARKINGTIME_PLAN_2HUR_P6 = str_replace("-","/",$PARKINGTIME_PLAN_2HUR_P6CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_2hur_p6_back" name="txt_parkingtime_plan_2hur_p6_back"  value="<?= $PARKINGTIME_PLAN_2HUR_P6 ?>" min="" max="" onchange ="parkingtime_plan_2hrs_p6_back('DT');" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p6_back" name="txt_departuretime_plan_2hur_p6_back" value="<?= $result_seData['DEPARTURETIME_PLAN_2HUR_P6'] ?>" min="" max="" autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP
                                                                                // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                $DEPARTURETIME_PLAN_2HUR_P6CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_2HUR_P6']);
                                                                                $DEPARTURETIME_PLAN_2HUR_P6 = str_replace("-","/",$DEPARTURETIME_PLAN_2HUR_P6CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p6_back" name="txt_departuretime_plan_2hur_p6_back" value="<?= $DEPARTURETIME_PLAN_2HUR_P6 ?>" min="" max="" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class = "row">
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_plan_2hur_p6_back" name="txt_location_plan_2hur_p6_back" value="<?= $result_seData['LOCATION_PLAN_2HUR_P6'] ?>" min="" max=""  autocomplete="off">
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
                                                </div>
                                            </div>
                                        </div>
                                        <!--END COLUNM6  -->

                                        <!-- START COLUNM7 -->
                                        <div class="col-lg-4" >
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #f0c402;">
                                                    <label><font style="font-size: 16px;">ปลายทาง/โหลดรถลง</font></label>
                                                </div>
                                                <!-- /.panel-heading -->
                                                <div class="panel-body">
                                                    <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                        <div class = "row">
                                                            <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 100%;text-align: center;background-color: #e7e7e7" >บริษัท (แผนขากลับ)</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>  
                                                        </div>
                                                        <div class = "row">
                                                            <div class="form-group">
                                                                <div class="col-lg-6">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input disabled="" class="form-control" type="text"  style="height:40px; width:240px" id="txt_locationplanfinish" name="txt_locationplanfinish" value="RRR" min="" max=""  autocomplete="off">
                                                                </div> 
                                                                <div class="">
                                                                    <div class="form-group">
                                                                        <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                                        <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                                        <div class="col-lg-6">
                                                                        <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtimeplanfinish" name="txt_parkingtimeplanfinish" value="  " min="" max=""  autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP

                                                                                $PARKINGTIME_PLAN_DEALER1CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_DEALER1']);
                                                                                $PARKINGTIME_PLAN_DEALER1 = str_replace("-","/",$PARKINGTIME_PLAN_DEALER1CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtimeplanfinish" name="txt_parkingtimeplanfinish"  value="<?= $PARKINGTIME_PLAN_DEALER1 ?>" min="" max="" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>           

                                                            </div>
                                                                            
                                                        </div>
                                                        <!-- /////////////////////////////////////////////////////////////////////////////// -->
                                                        <br>
                                                        <div class = "row">
                                                            <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 100%;text-align: center;background-color: #e7e7e7" >VL</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>  
                                                        </div>
                                                        <div class = "row">
                                                            <div class="form-group">
                                                                <div class="col-lg-6">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_locationplanvlfinish" name="txt_locationplanvlfinish" value="<?= $result_seData['DEALER2_PLAN'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label ><u>รวมเวลา</u></label><br>
                                                                    <input disabled="" class="form-control" type="text"  style="height:40px; width:240px" id="txt_sumtimeplanvlfinish" name="txt_sumtimeplanvlfinish" value="<?= $result_seData['SUM_PLAN_DEALER2'] ?>" min="" max=""  autocomplete="off">
                                                                </div>  
                                                            </div>
                                                        </div>
                                                        <div class = "row">
                                                            <div class="">
                                                                <form class="form-inline">
                                                                    <div class="form-group">
                                                                        <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                                        <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                                        <div class="col-lg-6">
                                                                        <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtimeplanvlfinish" name="txt_parkingtimeplanvlfinish" value="<?= $result_seData['PARKINGTIME_PLAN_DEALER2'] ?>" min="" max=""  autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP

                                                                                $PARKINGTIME_PLAN_DEALER2CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_DEALER2']);
                                                                                $PARKINGTIME_PLAN_DEALER2 = str_replace("-","/",$PARKINGTIME_PLAN_DEALER2CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาจอด</u></label><br>
                                                                                <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtimeplanvlfinish" name="txt_parkingtimeplanvlfinish"  value="<?= $PARKINGTIME_PLAN_DEALER2 ?>" min="" max="" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <?php
                                                                            if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                            ?>
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input type="datetime-local" style="height:40px; width:240px" id="txt_departurevtimeplanvlfinish" name="txt_departurevtimeplanvlfinish" value="<?= $result_seData['PARKINGTIME_PLAN_DEALER2'] ?>" min="" max=""  autocomplete="off">
                                                                            <?php
                                                                            }else { //สำหรับ PC DESKTOP
                                                                                // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                                $PARKINGTIME_PLAN_DEALER2CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_DEALER2']);
                                                                                $PARKINGTIME_PLAN_DEALER2 = str_replace("-","/",$PARKINGTIME_PLAN_DEALER2CHK);
                                                                            ?> 
                                                                                <label ><u>เวลาออก</u></label><br>
                                                                                <input class="form-control dateen" style="height:40px; width:240px" id="txt_departurevtimeplanvlfinish" name="txt_departurevtimeplanvlfinish" value="<?= $PARKINGTIME_PLAN_DEALER2 ?>" min="" max="" autocomplete="off">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class = "row">
                                                            <br>
                                                            <div class="col-lg-6">
                                                                <button type="button" style="" class="btn btn-primary btn-lg" onclick ="timevlcheck('<?=$checkClient?>');">กดยืนยันระยะเวลาการจอดรถ</button>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <p style="color:red">*กดปุ่มยืนยันทุกครั้งที่มีการแก้ไขเวลา เพื่อคำนวณชั่วโมงการจอดรถ</p>
                                                            </div>
                                                        </div>
                                                        <!-- /////////////////////////////////////////////////////////////////////////////// -->
                                                         
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
                                        <!--END COLUNM7  -->

                                        <!-- START COLUNM8 -->
                                        
                                        <!--END COLUNM8  -->
                                    
                                    
                                    
                                        <!-- type insert -->
                                        <!-- START COLUNM8 -->
                                        <!-- SAVE  DATEWORKING ,DATEPRESENT ลงใน DRIVERSELFCHECK-->
                                        <!-- DATEWORKING ,DATEPRESENT มาจากการกดยืนยันและบันทึกข้อมูล ในหน้าการตรวจสอบของเจ้าหน้าที่ -->
                                        <div class="col-lg-4" >
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #f0c402;">
                                                    <label><font style="font-size: 16px">บันทึกข้อมูลแผนขากลับ(พนักงาน)</font></label>
                                                </div>
                                                <!-- /.panel-heading -->
                                                <div class="panel-body">
                                                    <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                        <div class = "row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label >สถานะเอกสารรูปแบบการวิ่งงาน</label>
                                                                    &nbsp;
                                                                    <input type="text"   style="height:35px; width:200px;<?=$bgcolor?>" class="form-control" id="txt_officerconfirm" name="txt_officerconfirm" value= "<?=$result_seData['DRIVINGPATTERNRETURN_STATUS']?>" autocomplete="off" disabled>                    
                                                                </div>
                                                            </div>
                                                            <!-- <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label >บันทึกข้อมูลล่าสุด</label>
                                                                    <input type="text" style="height:35px; width:200px" class="form-control" id="txt_datetimeconfirm" name="txt_datetimeconfirm" value= "<?=$result_seSelfCheck['CFDATE']?>:<?=$result_seSelfCheck['CFTIME']?>" autocomplete="off" disabled>                    
                                                                </div>
                                                            </div> -->
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
                                                                        <input type="button" style="width: 100%;height:80px;font-size: 25px;" onclick="save_DriverPatternPlanReturn('save','<?=$checkClient?>','<?=$empchkgw?>');" name="btnSend" id="btnSend" value="บันทึกข้อมูลแผนขากลับ" class="btn btn-primary">
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
                                                </div>
                                                <!-- .panel-body -->
                                            </div>
                                            <!-- /.panel -->
                                        </div>
                                        <!--END COLUNM8  -->
                                    
                                </div>  
                            </div>
                    <div id="datasr_edit"></div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div> 
        <!-- END -->



        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>
        <script src="../js/bootstrap-datepicker.min.js"></script>
        <script src="../js/bootstrap-datepicker.th.min.js"></script>
        <!-- <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
        <script type="text/javascript">
            
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

        // Function กลับหน้าหลัก
        function backpage(){
            Swal.fire({
                title: "ต้องการกลับหน้าหลัก?",
                text: "",
                html: '<div style="text-align: center;font-size: 25px;"><b>หากกดกลับหน้าหลักจะไม่สามารถแก้ไขข้อมูลได้</b><br><b>กรุณาตรวจสอบข้อมูลให้ครบถ้วนก่อนกลับหน้าหลัก</b></div>',
                icon: "warning",
                width: 800,
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ตกลง",
                cancelButtonText: "ยกเลิก"
            }).then((result) => {

                if (result.isConfirmed) {
                    window.close();
                    // Swal.fire({
                    // title: "Deleted!",
                    // text: "Your file has been deleted.",
                    // icon: "success"
                    // });
                }

            });
            
        }
        // START FUNCTION RETURN PLAN
        // START TIMECHECK P1
        function parkingtime_plan_4hrs_p1_back(checkClient) {

            if (checkClient == 'MB') {
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk3  = document.getElementById('txt_parkingtime_plan_4hur_p1_back').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_4hur_p1_back').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);
            }

            // alert(pakingtimechk3);

            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_4hrs_p1_back",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_4hur_p1_back').value = rs; 
                }
            }); 

        }
        function parkingtime_plan_2hrs_p1_back(checkClient) {

            if (checkClient == 'MB') {
                
                var pakingtimechk3  = document.getElementById('txt_parkingtime_plan_2hur_p1_back').value;

            }else{
            // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_2hur_p1_back').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);  
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_2hrs_p1_back",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_2hur_p1_back').value = rs; 
                }
            }); 

        }
        // END TIMECHECK P1
        // START TIMECHECK P2
        function parkingtime_plan_4hrs_p2_back(checkClient) {

            if (checkClient == 'MB') {

                var pakingtimechk3  = document.getElementById('txt_parkingtime_plan_4hur_p2_back').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_4hur_p2_back').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);    
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_4hrs_p2_back",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_4hur_p2_back').value = rs; 
                }
            }); 

        }
        function parkingtime_plan_2hrs_p2_back(checkClient) {

            if (checkClient == 'MB') {
                
                var pakingtimechk3  = document.getElementById('txt_parkingtime_plan_2hur_p2_back').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_2hur_p2_back').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);  
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_2hrs_p2_back",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_2hur_p2_back').value = rs; 
                }
            }); 

        }
        // END TIMECHECK P2
        // START TIMECHECK P3
        function parkingtime_plan_4hrs_p3_back(checkClient) {

            if (checkClient == 'MB') {
                
                var pakingtimechk3  = document.getElementById('txt_parkingtime_plan_4hur_p3_back').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_4hur_p3_back').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);    
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_4hrs_p3_back",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_4hur_p3_back').value = rs; 
                }
            }); 

        }
        function parkingtime_plan_2hrs_p3_back(checkClient) {

            if (checkClient == 'MB') {
                
                var pakingtimechk3   = document.getElementById('txt_parkingtime_plan_2hur_p3_back').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_2hur_p3_back').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_2hrs_p3_back",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_2hur_p3_back').value = rs; 
                }
            }); 

        }
        // END TIMECHECK P3
        // START TIMECHECK P4
        function parkingtime_plan_4hrs_p4_back(checkClient) {

            if (checkClient == 'MB') {
                
                var pakingtimechk3  = document.getElementById('txt_parkingtime_plan_4hur_p4_back').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_4hur_p4_back').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_4hrs_p4_back",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_4hur_p4_back').value = rs; 
                }
            }); 

        }
        function parkingtime_plan_2hrs_p4_back(checkClient) {

            if (checkClient == 'MB') {
                
                var pakingtimechk3  = document.getElementById('txt_parkingtime_plan_2hur_p4_back').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_2hur_p4_back').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_2hrs_p4_back",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_2hur_p4_back').value = rs; 
                }
            }); 

        }
        // END TIMECHECK P4
        // START TIMECHECK P5
        function parkingtime_plan_4hrs_p5_back(checkClient) {

            if (checkClient == 'MB') {
                
                var pakingtimechk3  = document.getElementById('txt_parkingtime_plan_4hur_p5_back').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_4hur_p5_back').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_4hrs_p5_back",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_4hur_p5_back').value = rs; 
                }
            }); 

        }
        function parkingtime_plan_2hrs_p5_back(checkClient) {

            if (checkClient == 'MB') {
                
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_2hur_p5_back').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_2hur_p5_back').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);  
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_2hrs_p5_back",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_2hur_p5_back').value = rs; 
                }
            }); 

        }
        // END TIMECHECK P5
        // START TIMECHECK P6
        function parkingtime_plan_4hrs_p6_back(checkClient) {

            if (checkClient == 'MB') {
                
                var pakingtimechk3   = document.getElementById('txt_parkingtime_plan_4hur_p6_back').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_4hur_p6_back').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_4hrs_p6_back",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_4hur_p6_back').value = rs; 
                }
            }); 

        }
        function parkingtime_plan_2hrs_p6_back(checkClient) {

            if (checkClient == 'MB') {

                var pakingtimechk3   = document.getElementById('txt_parkingtime_plan_2hur_p6_back').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_2hur_p6_back').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);    
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_2hrs_p6_back",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_2hur_p6_back').value = rs; 
                }
            }); 

        }
        // START TIME VL
        function timevlcheck(checkClient){
            
            // var startsleepchk = document.getElementById('daysleep_reststart').value;
            // var endsleepchk = document.getElementById('daysleep_restend').value;
            // alert(startsleepchk);
            // alert(endsleepchk);
            // alert(checkClient);

            if (checkClient == 'MB') {
                var parkingtimechk   = document.getElementById('txt_parkingtimeplanvlfinish').value;
                var departuretimechk = document.getElementById('txt_departurevtimeplanvlfinish').value;
            }else{
                //START REST
                var parkingtimechk0  = document.getElementById('txt_parkingtimeplanvlfinish').value;
                var parkingtimechk1  = parkingtimechk0.replace(" ","T"); // replave " " เป็น "T"
                var parkingtimechk2  = parkingtimechk1.replace("/","-");
                var parkingtimechk3  = parkingtimechk2.replace("/","-"); // replave "/" เป็น "-"
                var parkingtimechk   = parkingtimechk3;
                
                //END REST
                var departuretimechk0  = document.getElementById('txt_departurevtimeplanvlfinish').value;
                var departuretimechk1  = departuretimechk0.replace(" ","T"); // replave " " เป็น "T"
                var departuretimechk2  = departuretimechk1.replace("/","-");// replave "/" เป็น "-"
                var departuretimechk3  = departuretimechk2.replace("/","-");
                var departuretimechk   = departuretimechk3;
                
                // alert(startsleepchk);
                // alert(endsleepchk);
            }

            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "select_timevl", parkingtimechk: parkingtimechk, departuretimechk: departuretimechk
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
                    document.getElementById('txt_sumtimeplanvlfinish').value = replacetext;
                
                }
            });

        }
        // END TIME VL
        // END FUNCTION RETURN PLAN

        // FUNCTION SAVE DATA
        function  save_DriverPatternPlanReturn(statuschk,checkClient) {

            var drivingplanbackid = $("#txt_backplanid").val();
            var employeecode1   = $("#txt_tlepidemp1_back").text();
            var employeename1   = $("#txt_empname1_back").text();
            var employeecode2   = $("#txt_tlepidemp2_back").text();
            var employeename2   = $("#txt_empname2_back").text();
            var thainame        = document.getElementById('txt_thainame').value;
            var planningroute   = document.getElementById('txt_planningroute').value;
            var actualroute     = document.getElementById('txt_actualroute').value;
            var drivingdate     = document.getElementById('txt_drivingdate').value;
            var officercheck    = $("#txt_officerapproveback").text();
            var planid1         = '<?=$result_seChkDataPlan['VEHICLETRANSPORTPLANID']?>';
            var planid2         = "";

            // driving pattern date
            if (checkClient == 'MB') {
                var drivingdate = document.getElementById('txt_drivingdate').value;
                
            }else{
                // alert('else');
                //START REST
                var drivingdatechk  = document.getElementById('txt_drivingdate').value;
                var drivingdate1    = drivingdatechk.replace(" ","T"); // replave " " เป็น "T"
                var drivingdate2    = drivingdate1.replaceAll("/","-");
                // var drivingdate3    = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var drivingdate     = drivingdate2;
                
            }
            // alert(drivingdate);

            // // check โตโยต้า นครพิงค์
            // if($("#chk_tnkp").is(':checked')){
            //     tnkp_check = '1';
            // } else {
            //     tnkp_check = '0';
            // }
            // // check โตโยต้า อุบล
            // if($("#chk_tubon").is(':checked')){
            //     tubon_check = '1';
            // } else {
            //     tubon_check = '0';
            // }
            // // check โตโยต้า ไทยเย็น
            // if($("#chk_tthaiyen").is(':checked')){
            //     tthaiyen_check = '1';
            // } else {
            //     tthaiyen_check = '0';
            // }
            // // check โตโยต้า กาญจนบุรี
            // if($("#chk_tkan").is(':checked')){
            //     tkan_check = '1';
            // } else {
            //     tkan_check = '0';
            // }

            var jobstartplan = $("#txt_jobstartplanback").val();

            // วันที่/เวลาออกเดินทางกลับ
            if (checkClient == 'MB') {
                var datestartplan = $("#txt_datestartplanback").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartplanchk    = $("#txt_datestartplanback").val();
                var datestartplan1      = datestartplanchk.replace(" ","T"); // replave " " เป็น "T"
                var datestartplan2      = datestartplan1.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartplan       = datestartplan2;
                
            }

            // alert(datestartplan);


            // PLAN P1 ///////////////////////////////////////////
            var drivernamep1         = $("#txt_drivernameplan_p1_back").val();
            var location4hurp1       = $("#txt_location_plan_4hur_p1_back").val();
            var location2hurp1       = $("#txt_location_plan_2hur_p1_back").val();

            // วันที่/เวลา เริ่มขับ P1
            if (checkClient == 'MB') {
                var datestartplanp1 = $("#txt_datestartplan_p1_back").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartplanp1chk  = $("#txt_datestartplan_p1_back").val();
                var datestartplanp11    = datestartplanp1chk.replace(" ","T"); // replave " " เป็น "T"
                var datestartplanp12    = datestartplanp11.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartplanp1     = datestartplanp12;
                
            }

            // วันที่/เวลาจอด 4 hurs P1
            if (checkClient == 'MB') {
                var parkngtime_plan_4hurs_p1 = $("#txt_parkingtime_plan_4hur_p1_back").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_4hurs_p1chk     = $("#txt_parkingtime_plan_4hur_p1_back").val();
                var parkngtime_plan_4hurs_p11       = parkngtime_plan_4hurs_p1chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_4hurs_p12       = parkngtime_plan_4hurs_p11.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_4hurs_p1        = parkngtime_plan_4hurs_p12;
                
            }


            // วันที่/เวลาออก 4 hurs P1
            if (checkClient == 'MB') {
                var departuretime_plan_4hurs_p1 = $("#txt_departuretime_plan_4hur_p1_back").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_4hurs_p1chk     = $("#txt_departuretime_plan_4hur_p1_back").val();
                var departuretime_plan_4hurs_p11       = departuretime_plan_4hurs_p1chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_4hurs_p12       = departuretime_plan_4hurs_p11.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_4hurs_p1        = departuretime_plan_4hurs_p12;
                
            }

            // วันที่/เวลาจอด 2 hurs P1
            if (checkClient == 'MB') {
                var parkngtime_plan_2hurs_p1 = $("#txt_parkingtime_plan_2hur_p1_back").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_2hurs_p1chk     = $("#txt_parkingtime_plan_2hur_p1_back").val();
                var parkngtime_plan_2hurs_p11       = parkngtime_plan_2hurs_p1chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_2hurs_p12       = parkngtime_plan_2hurs_p11.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_2hurs_p1        = parkngtime_plan_2hurs_p12;
                
            }


            // วันที่/เวลาออก 2 hurs P1
            if (checkClient == 'MB') {
                var departuretime_plan_2hurs_p1 = $("#txt_departuretime_plan_2hur_p1_back").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_2hurs_p1chk     = $("#txt_departuretime_plan_2hur_p1_back").val();
                var departuretime_plan_2hurs_p11       = departuretime_plan_2hurs_p1chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_2hurs_p12       = departuretime_plan_2hurs_p11.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_2hurs_p1        = departuretime_plan_2hurs_p12;
                
            }
            ////////////////////////////////////////////////////////////////////////////////////////////

            // PLAN P2 ///////////////////////////////////////////
            var drivernamep2         = $("#txt_drivernameplan_p2_back").val();
            var location4hurp2       = $("#txt_location_plan_4hur_p2_back").val();
            var location2hurp2       = $("#txt_location_plan_2hur_p2_back").val();

            // วันที่/เวลา เริ่มขับ P1
            if (checkClient == 'MB') {
                var datestartplanp2 = $("#txt_datestartplan_p2_back").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartplanp2chk  = $("#txt_datestartplan_p2_back").val();
                var datestartplanp21    = datestartplanp2chk.replace(" ","T"); // replave " " เป็น "T"
                var datestartplanp22    = datestartplanp21.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartplanp2     = datestartplanp22;
                
            }

            // วันที่/เวลาจอด 4 hurs P2
            if (checkClient == 'MB') {
                var parkngtime_plan_4hurs_p2 = $("#txt_parkingtime_plan_4hur_p2_back").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_4hurs_p2chk     = $("#txt_parkingtime_plan_4hur_p2_back").val();
                var parkngtime_plan_4hurs_p21       = parkngtime_plan_4hurs_p2chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_4hurs_p22       = parkngtime_plan_4hurs_p21.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_4hurs_p2        = parkngtime_plan_4hurs_p22;
                
            }


            // วันที่/เวลาออก 4 hurs P2
            if (checkClient == 'MB') {
                var departuretime_plan_4hurs_p2 = $("#txt_departuretime_plan_4hur_p2_back").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_4hurs_p2chk     = $("#txt_departuretime_plan_4hur_p2_back").val();
                var departuretime_plan_4hurs_p21       = departuretime_plan_4hurs_p2chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_4hurs_p22       = departuretime_plan_4hurs_p21.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_4hurs_p2        = departuretime_plan_4hurs_p22;
                
            }

            // วันที่/เวลาจอด 2 hurs P2
            if (checkClient == 'MB') {
                var parkngtime_plan_2hurs_p2 = $("#txt_parkingtime_plan_2hur_p2_back").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_2hurs_p2chk     = $("#txt_parkingtime_plan_2hur_p2_back").val();
                var parkngtime_plan_2hurs_p21       = parkngtime_plan_2hurs_p2chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_2hurs_p22       = parkngtime_plan_2hurs_p21.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_2hurs_p2        = parkngtime_plan_2hurs_p22;
                
            }


            // วันที่/เวลาออก 2 hurs P2
            if (checkClient == 'MB') {
                var departuretime_plan_2hurs_p2 = $("#txt_departuretime_plan_2hur_p2_back").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_2hurs_p2chk     = $("#txt_departuretime_plan_2hur_p2_back").val();
                var departuretime_plan_2hurs_p21       = departuretime_plan_2hurs_p2chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_2hurs_p22       = departuretime_plan_2hurs_p21.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_2hurs_p2        = departuretime_plan_2hurs_p22;
                
            }
            ////////////////////////////////////////////////////////////////////////////////////////////

            // PLAN P3 ///////////////////////////////////////////
            var drivernamep3         = $("#txt_drivernameplan_p3_back").val();
            var location4hurp3       = $("#txt_location_plan_4hur_p3_back").val();
            var location2hurp3       = $("#txt_location_plan_2hur_p3_back").val();

            // วันที่/เวลา เริ่มขับ P3
            if (checkClient == 'MB') {
                var datestartplanp3 = $("#txt_datestartplan_p3_back").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartplanp3chk  = $("#txt_datestartplan_p3_back").val();
                var datestartplanp31    = datestartplanp3chk.replace(" ","T"); // replave " " เป็น "T"
                var datestartplanp32    = datestartplanp31.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartplanp3     = datestartplanp32;
                
            }

            // วันที่/เวลาจอด 4 hurs P3
            if (checkClient == 'MB') {
                var parkngtime_plan_4hurs_p3 = $("#txt_parkingtime_plan_4hur_p3_back").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_4hurs_p3chk     = $("#txt_parkingtime_plan_4hur_p3_back").val();
                var parkngtime_plan_4hurs_p31       = parkngtime_plan_4hurs_p3chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_4hurs_p32       = parkngtime_plan_4hurs_p31.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_4hurs_p3        = parkngtime_plan_4hurs_p32;
                
            }


            // วันที่/เวลาออก 4 hurs P3
            if (checkClient == 'MB') {
                var departuretime_plan_4hurs_p3 = $("#txt_departuretime_plan_4hur_p3_back").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_4hurs_p3chk     = $("#txt_departuretime_plan_4hur_p3_back").val();
                var departuretime_plan_4hurs_p31       = departuretime_plan_4hurs_p3chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_4hurs_p32       = departuretime_plan_4hurs_p31.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_4hurs_p3        = departuretime_plan_4hurs_p32;
                
            }

            // วันที่/เวลาจอด 2 hurs P3
            if (checkClient == 'MB') {
                var parkngtime_plan_2hurs_p3 = $("#txt_parkingtime_plan_2hur_p3_back").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_2hurs_p3chk     = $("#txt_parkingtime_plan_2hur_p3_back").val();
                var parkngtime_plan_2hurs_p31       = parkngtime_plan_2hurs_p3chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_2hurs_p32       = parkngtime_plan_2hurs_p31.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_2hurs_p3        = parkngtime_plan_2hurs_p32;
                
            }


            // วันที่/เวลาออก 2 hurs P3
            if (checkClient == 'MB') {
                var departuretime_plan_2hurs_p3 = $("#txt_departuretime_plan_2hur_p3_back").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_2hurs_p3chk     = $("#txt_departuretime_plan_2hur_p3_back").val();
                var departuretime_plan_2hurs_p31       = departuretime_plan_2hurs_p3chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_2hurs_p32       = departuretime_plan_2hurs_p31.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_2hurs_p3        = departuretime_plan_2hurs_p32;
                
            }
            ////////////////////////////////////////////////////////////////////////////////////////////

            // PLAN P4 ///////////////////////////////////////////
            var drivernamep4         = $("#txt_drivernameplan_p4_back").val();
            var location4hurp4       = $("#txt_location_plan_4hur_p4_back").val();
            var location2hurp4       = $("#txt_location_plan_2hur_p4_back").val();

            // วันที่/เวลา เริ่มขับ P3
            if (checkClient == 'MB') {
                var datestartplanp4 = $("#txt_datestartplan_p4_back").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartplanp4chk  = $("#txt_datestartplan_p4_back").val();
                var datestartplanp41    = datestartplanp4chk.replace(" ","T"); // replave " " เป็น "T"
                var datestartplanp42    = datestartplanp41.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartplanp4     = datestartplanp42;
                
            }

            // วันที่/เวลาจอด 4 hurs P4
            if (checkClient == 'MB') {
                var parkngtime_plan_4hurs_p4 = $("#txt_parkingtime_plan_4hur_p4_back").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_4hurs_p4chk     = $("#txt_parkingtime_plan_4hur_p4_back").val();
                var parkngtime_plan_4hurs_p41       = parkngtime_plan_4hurs_p4chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_4hurs_p42       = parkngtime_plan_4hurs_p41.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_4hurs_p4        = parkngtime_plan_4hurs_p42;
                
            }


            // วันที่/เวลาออก 4 hurs P4
            if (checkClient == 'MB') {
                var departuretime_plan_4hurs_p4 = $("#txt_departuretime_plan_4hur_p4_back").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_4hurs_p4chk     = $("#txt_departuretime_plan_4hur_p4_back").val();
                var departuretime_plan_4hurs_p41       = departuretime_plan_4hurs_p4chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_4hurs_p42       = departuretime_plan_4hurs_p41.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_4hurs_p4        = departuretime_plan_4hurs_p42;
                
            }

            // วันที่/เวลาจอด 2 hurs P4
            if (checkClient == 'MB') {
                var parkngtime_plan_2hurs_p4 = $("#txt_parkingtime_plan_2hur_p4_back").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_2hurs_p4chk     = $("#txt_parkingtime_plan_2hur_p4_back").val();
                var parkngtime_plan_2hurs_p41       = parkngtime_plan_2hurs_p4chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_2hurs_p42       = parkngtime_plan_2hurs_p41.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_2hurs_p4        = parkngtime_plan_2hurs_p42;
                
            }


            // วันที่/เวลาออก 2 hurs P4
            if (checkClient == 'MB') {
                var departuretime_plan_2hurs_p4 = $("#txt_departuretime_plan_2hur_p4_back").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_2hurs_p4chk     = $("#txt_departuretime_plan_2hur_p4_back").val();
                var departuretime_plan_2hurs_p41       = departuretime_plan_2hurs_p4chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_2hurs_p42       = departuretime_plan_2hurs_p41.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_2hurs_p4        = departuretime_plan_2hurs_p42;
                
            }
            ////////////////////////////////////////////////////////////////////////////////////////////

            // PLAN P5 ///////////////////////////////////////////
            var drivernamep5         = $("#txt_drivernameplan_p5_back").val();
            var location4hurp5       = $("#txt_location_plan_4hur_p5_back").val();
            var location2hurp5       = $("#txt_location_plan_2hur_p5_back").val();

            // วันที่/เวลา เริ่มขับ P5
            if (checkClient == 'MB') {
                var datestartplanp5 = $("#txt_datestartplan_p5_back").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartplanp5chk  = $("#txt_datestartplan_p5_back").val();
                var datestartplanp51    = datestartplanp5chk.replace(" ","T"); // replave " " เป็น "T"
                var datestartplanp52    = datestartplanp51.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartplanp5     = datestartplanp52;
                
            }

            // วันที่/เวลาจอด 4 hurs P5
            if (checkClient == 'MB') {
                var parkngtime_plan_4hurs_p5 = $("#txt_parkingtime_plan_4hur_p5_back").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_4hurs_p5chk     = $("#txt_parkingtime_plan_4hur_p5_back").val();
                var parkngtime_plan_4hurs_p51       = parkngtime_plan_4hurs_p5chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_4hurs_p52       = parkngtime_plan_4hurs_p51.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_4hurs_p5        = parkngtime_plan_4hurs_p52;
                
            }


            // วันที่/เวลาออก 4 hurs P5
            if (checkClient == 'MB') {
                var departuretime_plan_4hurs_p5 = $("#txt_departuretime_plan_4hur_p5_back").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_4hurs_p5chk     = $("#txt_departuretime_plan_4hur_p5_back").val();
                var departuretime_plan_4hurs_p51       = departuretime_plan_4hurs_p5chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_4hurs_p52       = departuretime_plan_4hurs_p51.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_4hurs_p5        = departuretime_plan_4hurs_p52;
                
            }

            // วันที่/เวลาจอด 2 hurs P5
            if (checkClient == 'MB') {
                var parkngtime_plan_2hurs_p5 = $("#txt_parkingtime_plan_2hur_p5_back").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_2hurs_p5chk     = $("#txt_parkingtime_plan_2hur_p5_back").val();
                var parkngtime_plan_2hurs_p51       = parkngtime_plan_2hurs_p5chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_2hurs_p52       = parkngtime_plan_2hurs_p51.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_2hurs_p5        = parkngtime_plan_2hurs_p52;
                
            }


            // วันที่/เวลาออก 2 hurs P5
            if (checkClient == 'MB') {
                var departuretime_plan_2hurs_p5 = $("#txt_departuretime_plan_2hur_p5_back").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_2hurs_p5chk     = $("#txt_departuretime_plan_2hur_p5_back").val();
                var departuretime_plan_2hurs_p51       = departuretime_plan_2hurs_p5chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_2hurs_p52       = departuretime_plan_2hurs_p51.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_2hurs_p5        = departuretime_plan_2hurs_p52;
                
            }
            ////////////////////////////////////////////////////////////////////////////////////////////

            // PLAN P6 ///////////////////////////////////////////
            var drivernamep6         = $("#txt_drivernameplan_p6_back").val();
            var location4hurp6       = $("#txt_location_plan_4hur_p6_back").val();
            var location2hurp6       = $("#txt_location_plan_2hur_p6_back").val();

            // วันที่/เวลา เริ่มขับ P6
            if (checkClient == 'MB') {
                var datestartplanp6 = $("#txt_datestartplan_p6_back").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartplanp6chk  = $("#txt_datestartplan_p6_back").val();
                var datestartplanp61    = datestartplanp6chk.replace(" ","T"); // replave " " เป็น "T"
                var datestartplanp62    = datestartplanp61.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartplanp6     = datestartplanp62;
                
            }

            // วันที่/เวลาจอด 4 hurs P6
            if (checkClient == 'MB') {
                var parkngtime_plan_4hurs_p6 = $("#txt_parkingtime_plan_4hur_p6_back").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_4hurs_p6chk     = $("#txt_parkingtime_plan_4hur_p6_back").val();
                var parkngtime_plan_4hurs_p61       = parkngtime_plan_4hurs_p6chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_4hurs_p62       = parkngtime_plan_4hurs_p61.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_4hurs_p6        = parkngtime_plan_4hurs_p62;
                
            }


            // วันที่/เวลาออก 4 hurs P6
            if (checkClient == 'MB') {
                var departuretime_plan_4hurs_p6 = $("#txt_departuretime_plan_4hur_p6_back").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_4hurs_p6chk     = $("#txt_departuretime_plan_4hur_p6_back").val();
                var departuretime_plan_4hurs_p61       = departuretime_plan_4hurs_p6chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_4hurs_p62       = departuretime_plan_4hurs_p61.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_4hurs_p6        = departuretime_plan_4hurs_p62;
                
            }

            // วันที่/เวลาจอด 2 hurs P6
            if (checkClient == 'MB') {
                var parkngtime_plan_2hurs_p6 = $("#txt_parkingtime_plan_2hur_p6_back").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_2hurs_p6chk     = $("#txt_parkingtime_plan_2hur_p6_back").val();
                var parkngtime_plan_2hurs_p61       = parkngtime_plan_2hurs_p6chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_2hurs_p62       = parkngtime_plan_2hurs_p61.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_2hurs_p6        = parkngtime_plan_2hurs_p62;
                
            }


            // วันที่/เวลาออก 2 hurs P6
            if (checkClient == 'MB') {
                var departuretime_plan_2hurs_p6 = $("#txt_departuretime_plan_2hur_p6_back").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_2hurs_p6chk     = $("#txt_departuretime_plan_2hur_p6_back").val();
                var departuretime_plan_2hurs_p61       = departuretime_plan_2hurs_p6chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_2hurs_p62       = departuretime_plan_2hurs_p61.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_2hurs_p6        = departuretime_plan_2hurs_p62;
                
            }
            ////////////////////////////////////////////////////////////////////////////////////////////
            // โหลดรถลง Dealer1
            // แผนงานขากลับ ช่องบริษัทแผนขากลับใช้ช่องของ Dealer1
            
            // ช่องบริษัท สถานที่ แผนขากลับ
            var dealer1plan = $("#txt_locationplanfinish").val();
            var sumtimedealer1 = '';

            // Parking Time Dealer1
            if (checkClient == 'MB') {
                var parkingtime_plan_dealer1 = $("#txt_parkingtimeplanfinish").val();
                
            }else{
                // alert('else');
                //START REST
                var parkingtime_plan_dealer1chk    = $("#txt_parkingtimeplanfinish").val();
                var parkingtime_plan_dealer1chk1   = parkingtime_plan_dealer1chk.replace(" ","T"); // replave " " เป็น "T"
                var parkingtime_plan_dealer1chk2   = parkingtime_plan_dealer1chk1.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkingtime_plan_dealer1       = parkingtime_plan_dealer1chk2;
                
            }

            // ช่องบริษัท เวลาจอด แผนขากลับ
            if (checkClient == 'MB') {
                var departuretime_plan_dealer1 = ''
                
            }else{
                var departuretime_plan_dealer1 = ''
                
            }
            //////////////////////////////////////////////////////////////////////////////
            // โหลดรถลง Dealer2
            // สถานที่แผนงานขากลับ ช่อง VL แผนขากลับใช้ช่องของ Dealer2
            var dealer2plan = $("#txt_locationplanvlfinish").val();
            var sumtimedealer2 = $("#txt_sumtimeplanvlfinish").val();

            // Parking Time Dealer2
             // แผนงานขากลับ ช่องเวลาจอดของ VL ใช้ช่องของ Dealer2
            if (checkClient == 'MB') {
                var parkingtime_plan_dealer2 = $("#txt_parkingtimeplanvlfinish").val();
                
            }else{
                // alert('else');
                //START REST
                var parkingtime_plan_dealer2chk    = $("#txt_parkingtimeplanvlfinish").val();
                var parkingtime_plan_dealer2chk1   = parkingtime_plan_dealer2chk.replace(" ","T"); // replave " " เป็น "T"
                var parkingtime_plan_dealer2chk2   = parkingtime_plan_dealer2chk1.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkingtime_plan_dealer2       = parkingtime_plan_dealer2chk2;
                
            }

            // Parking Time Dealer2
             // แผนงานขากลับ ช่องเวลาออก ของVL ใช้ช่องของ Dealer2
            if (checkClient == 'MB') {
                var departuretime_plan_dealer2 = $("#txt_departurevtimeplanvlfinish").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_dealer2chk    = $("#txt_departurevtimeplanvlfinish").val();
                var departuretime_plan_dealer2chk1   = departuretime_plan_dealer2chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_dealer2chk2   = departuretime_plan_dealer2chk1.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_dealer2       = departuretime_plan_dealer2chk2;
                
            }
            //////////////////////////////////////////////////////////////////////////////
            // โหลดรถลง Dealer3

            var dealer3plan = '';
            var sumtimedealer3 = '';

            // Parking Time Dealer1
            if (checkClient == 'MB') {
                var parkingtime_plan_dealer3 = '';
                
            }else{
                // alert('else');
                var parkingtime_plan_dealer3 = '';
                
            }

            // Departure Time Dealer3
            if (checkClient == 'MB') {
                var departuretime_plan_dealer3 = '';
                
            }else{
                // alert('else');
                var departuretime_plan_dealer3 = '';
                
            }
            //////////////////////////////////////////////////////////////////////////////
            // โหลดรถลง Dealer4

            var dealer4plan = '';
            var sumtimedealer4 = '';

            // Parking Time Dealer4
            if (checkClient == 'MB') {
                var parkingtime_plan_dealer4 = '';
                
            }else{
                // alert('else');
                var parkingtime_plan_dealer4 = '';
                
            }

            // Departure Time Dealer4
            if (checkClient == 'MB') {
                var departuretime_plan_dealer4 = '';
                
            }else{
                // alert('else');
                var departuretime_plan_dealer4 = '';
                
            }

            var createby = '<?=$result_seEmp1['PersonCode']?>';
            //////////////////////////////////////////////////////////////////////////////
           
            
            // 11111
            // function การเตือนการลงข้อมูล
            if (thainame == '') {
                swal.fire({
                    title: "Warning!",
                    text: "ยังไม่ได้ลงข้อมูล เบอร์รถ",
                    icon: "warning",
                    showConfirmButton: true,
                    allowOutsideClick: false,
                });
            }else if(planningroute == ''){
                swal.fire({
                    title: "Warning!",
                    text: "ยังไม่ได้ลงข้อมูล รูทงานตามแผน",
                    icon: "warning",
                    showConfirmButton: true,
                    allowOutsideClick: false,
                });
            }else if(actualroute == ''){
                swal.fire({
                    title: "Warning!",
                    text: "ยังไม่ได้ลงข้อมูล รูทงานวิ่งจริง",
                    icon: "warning",
                    showConfirmButton: true,
                    allowOutsideClick: false,
                });
            }else if(drivingdate == ''){
                swal.fire({
                    title: "Warning!",
                    text: "ยังไม่ได้ลงข้อมูล วันที่หัวกระดาษ",
                    icon: "warning",
                    showConfirmButton: true,
                    allowOutsideClick: false,
                });
            }else if(datestartplan == ''){
                swal.fire({
                    title: "Warning!",
                    text: "ยังไม่ได้ลงข้อมูล วันที่ออกเดินทาง",
                    icon: "warning",
                    showConfirmButton: true,
                    allowOutsideClick: false,
                });
            }else if(drivernamep1 == ''){
                swal.fire({
                    title: "Warning!",
                    text: "ยังไม่ได้ลงข้อมูล ชื่อผู้ขับ (ช่วงที่1)",
                    icon: "warning",
                    showConfirmButton: true,
                    allowOutsideClick: false,
                });
            }else if(parkingtime_plan_dealer1 == ''){
                swal.fire({
                    title: "Warning!",
                    text: "ยังไม่ได้ลงข้อมูลเวลาจอดที่บริษัท",
                    icon: "warning",
                    showConfirmButton: true,
                    allowOutsideClick: false,
                });
            }else if((parkingtime_plan_dealer2 != '' && departuretime_plan_dealer2 != '') && (sumtimedealer2 == '')){
                swal.fire({
                    title: "Warning!",
                    text: "ยังไม่ได้กดคำนวณเวลา VL",
                    icon: "warning",
                    showConfirmButton: true,
                    allowOutsideClick: false,
                });
            }else{

                if (drivingplanbackid != '') {
                    // alert('update');
                    
                    // COUNT ALL 89
                    $.ajax({
                        type: 'post',
                        url: 'meg_data_drivingpattern_driver.php',
                        data: {
                            
                            // COUNT 10
                            txt_flg: "save_drivingpatternplanback",
                            drivingplanbackid:drivingplanbackid, 
                            employeecode1: employeecode1,
                            employeename1: employeename1, 
                            employeecode2: employeecode2,
                            employeename2: employeename2,
                            thainame: thainame,
                            planningroute: planningroute,
                            actualroute: actualroute,
                            officercheck: officercheck,

                            // COUNT 9
                            planid1: planid1,
                            planid2: planid2,
                            drivingdate: drivingdate,
                            tnkp_check:'',
                            tubon_check: '',
                            tthaiyen_check: '',
                            tkan_check: '',
                            jobstartplan: jobstartplan, 
                            datestartplan: datestartplan,

                            // PLAN P1 COUNT 8
                            drivernamep1: drivernamep1,
                            datestartplanp1: datestartplanp1,
                            parkngtime_plan_4hurs_p1: parkngtime_plan_4hurs_p1,
                            departuretime_plan_4hurs_p1: departuretime_plan_4hurs_p1,
                            location4hurp1: location4hurp1,
                            parkngtime_plan_2hurs_p1: parkngtime_plan_2hurs_p1,
                            departuretime_plan_2hurs_p1: departuretime_plan_2hurs_p1,
                            location2hurp1: location2hurp1,
                            
                            // PLAN P2 COUNT 8
                            drivernamep2: drivernamep2,
                            datestartplanp2: datestartplanp2,
                            parkngtime_plan_4hurs_p2: parkngtime_plan_4hurs_p2,
                            departuretime_plan_4hurs_p2: departuretime_plan_4hurs_p2,
                            location4hurp2: location4hurp2,
                            parkngtime_plan_2hurs_p2: parkngtime_plan_2hurs_p2,
                            departuretime_plan_2hurs_p2: departuretime_plan_2hurs_p2,
                            location2hurp2: location2hurp2,

                            // PLAN P3 COUNT 8
                            drivernamep3: drivernamep3,
                            datestartplanp3: datestartplanp3,
                            parkngtime_plan_4hurs_p3: parkngtime_plan_4hurs_p3,
                            departuretime_plan_4hurs_p3: departuretime_plan_4hurs_p3,
                            location4hurp3: location4hurp3,
                            parkngtime_plan_2hurs_p3: parkngtime_plan_2hurs_p3,
                            departuretime_plan_2hurs_p3: departuretime_plan_2hurs_p3,
                            location2hurp3: location2hurp3,
                        
                            // PLAN P4 COUNT 8
                            drivernamep4: drivernamep4,
                            datestartplanp4: datestartplanp4,
                            parkngtime_plan_4hurs_p4: parkngtime_plan_4hurs_p4,
                            departuretime_plan_4hurs_p4: departuretime_plan_4hurs_p4,
                            location4hurp4: location4hurp4,
                            parkngtime_plan_2hurs_p4: parkngtime_plan_2hurs_p4,
                            departuretime_plan_2hurs_p4: departuretime_plan_2hurs_p4,
                            location2hurp4: location2hurp4,

                            // PLAN P5 COUNT 8
                            drivernamep5: drivernamep5,
                            datestartplanp5: datestartplanp5,
                            parkngtime_plan_4hurs_p5: parkngtime_plan_4hurs_p5,
                            departuretime_plan_4hurs_p5: departuretime_plan_4hurs_p5,
                            location4hurp5: location4hurp5,
                            parkngtime_plan_2hurs_p5: parkngtime_plan_2hurs_p5,
                            departuretime_plan_2hurs_p5: departuretime_plan_2hurs_p5,
                            location2hurp5: location2hurp5,

                            // PLAN P6 COUNT 8
                            drivernamep6: drivernamep6,
                            datestartplanp6: datestartplanp6,
                            parkngtime_plan_4hurs_p6: parkngtime_plan_4hurs_p6,
                            departuretime_plan_4hurs_p6: departuretime_plan_4hurs_p6,
                            location4hurp6: location4hurp6,
                            parkngtime_plan_2hurs_p6: parkngtime_plan_2hurs_p6,
                            departuretime_plan_2hurs_p6: departuretime_plan_2hurs_p6,
                            location2hurp6: location2hurp6,

                            // DEALER 1 COUNT 4
                            dealer1plan: dealer1plan,
                            sumtimedealer1: sumtimedealer1,
                            parkingtime_plan_dealer1: parkingtime_plan_dealer1,
                            departuretime_plan_dealer1: departuretime_plan_dealer1,

                            // DEALER 2 COUNT 4
                            dealer2plan: dealer2plan,
                            sumtimedealer2: sumtimedealer2,
                            parkingtime_plan_dealer2: parkingtime_plan_dealer2,
                            departuretime_plan_dealer2: departuretime_plan_dealer2,

                            // DEALER 3 COUNT 4
                            dealer3plan: dealer3plan,
                            sumtimedealer3: sumtimedealer3,
                            parkingtime_plan_dealer3: parkingtime_plan_dealer3,
                            departuretime_plan_dealer3: departuretime_plan_dealer3,

                            // DEALER 4 COUNT 4
                            dealer4plan: dealer4plan,
                            sumtimedealer4: sumtimedealer4,
                            parkingtime_plan_dealer4: parkingtime_plan_dealer4,
                            departuretime_plan_dealer4: departuretime_plan_dealer4,

                            // COUNT 6
                            createby: '',
                            createdate: '',
                            modifiedby: employeecode1,
                            modifieddate: '',
                            confirmedby: '',
                            confirmeddate: ''



                        },
                        success: function (rs) {
                            
                            // alert("ยืนยันและแก้ไขข้อมูลเรียบร้อย");
                            // commitupdate_selfcheck(selfchkid);
                            swal.fire({
                                title: "Good Job!",
                                text: "ยืนยันและบันทึกข้อมูลเรียบร้อย",
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
        
        }

        </script>
    </body>
</html>
        