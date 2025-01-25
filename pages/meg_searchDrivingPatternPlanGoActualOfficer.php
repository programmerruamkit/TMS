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



$employeechk = " AND a.PersonCode = '" .$_SESSION["USERNAME"] . "'";
$sql_seEmpchk = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmpchk = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($employeechk, SQLSRV_PARAM_IN)
);
$query_seEmpchk = sqlsrv_query($conn, $sql_seEmpchk, $params_seEmpchk);
$result_seEmpchk = sqlsrv_fetch_array($query_seEmpchk, SQLSRV_FETCH_ASSOC);


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
        <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">


        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        
        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.min.js"></script>
        <!-- <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet"> -->

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
        <!-- <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet"> -->
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
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
                bottom: 5500px;
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
            <div class="col-lg-12" style="font-size: 30px;text-align: center;"><b>ลงข้อมูลวิ่งจริงขาไปสำหรับเจ้าหน้าที่</b></div>
            <!-- <div class="col-lg-4" style="font-size: 30px;text-align: center;">วันที่: <?=date("d-m-Y")?></div>
            <div class="col-lg-4" style="font-size: 30px;text-align: center;">ชื่อ-นามสกุล: <?=$result_seEmp1['nameT']?></div>
            <div class="col-lg-4" style="font-size: 30px;text-align: center;">รหัสพนักงาน: <?=$result_seEmp1['PersonCode']?></div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12" style="font-size: 30px;text-align: center;">เอกสารรูปแบบการวิ่งงาน Officer (Driving Pattern)</div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12" style="text-align: center;">
                <b style="font-size: 18px"></b>
                &nbsp;<button class="button" style="width:15%;font-size: 20px;background-color: #93f786;border:solid 2px;color:black" onclick="backpage('GoBack')">กลับหน้าหลัก</button>
            
            </div> -->
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">&nbsp;</div>
        </div>
        <?php

        $sql_seData = "SELECT DRIVINGPATTERNGO_ID,DRIVINGPATTERNRETURN_ID,EMPLOYEECODE1,EMPLOYEENAME1,EMPLOYEECODE2,EMPLOYEENAME2,THAINAME_ID,PLANING_ROUTE,ACTUAL_ROUTE,DRIVINGPATTERN_DATE,OFFICERCHECK_GO,
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
            CREATEBY_PLANGO,CREATEDATE_PLANGO,MODIFIEDBY_PLANGO,MODIFIEDDATE_PLANGO,DRIVINGPATTERNGO_STATUS

            JOBSTARTACTUAL,DATESTARTACTUAL,
            DRIVERNAME_ACTUAL_P1,DATESTART_ACTUAL_P1,PARKINGTIME_ACTUAL_4HUR_P1,DEPARTURETIME_ACTUAL_4HUR_P1,LOCATION_ACTUAL_4HUR_P1,PARKINGTIME_ACTUAL_2HUR_P1,DEPARTURETIME_ACTUAL_2HUR_P1,LOCATION_ACTUAL_2HUR_P1,
            DRIVERNAME_ACTUAL_P2,DATESTART_ACTUAL_P2,PARKINGTIME_ACTUAL_4HUR_P2,DEPARTURETIME_ACTUAL_4HUR_P2,LOCATION_ACTUAL_4HUR_P2,PARKINGTIME_ACTUAL_2HUR_P2,DEPARTURETIME_ACTUAL_2HUR_P2,LOCATION_ACTUAL_2HUR_P2,
            DRIVERNAME_ACTUAL_P3,DATESTART_ACTUAL_P3,PARKINGTIME_ACTUAL_4HUR_P3,DEPARTURETIME_ACTUAL_4HUR_P3,LOCATION_ACTUAL_4HUR_P3,PARKINGTIME_ACTUAL_2HUR_P3,DEPARTURETIME_ACTUAL_2HUR_P3,LOCATION_ACTUAL_2HUR_P3,
            DRIVERNAME_ACTUAL_P4,DATESTART_ACTUAL_P4,PARKINGTIME_ACTUAL_4HUR_P4,DEPARTURETIME_ACTUAL_4HUR_P4,LOCATION_ACTUAL_4HUR_P4,PARKINGTIME_ACTUAL_2HUR_P4,DEPARTURETIME_ACTUAL_2HUR_P4,LOCATION_ACTUAL_2HUR_P4,
            DRIVERNAME_ACTUAL_P5,DATESTART_ACTUAL_P5,PARKINGTIME_ACTUAL_4HUR_P5,DEPARTURETIME_ACTUAL_4HUR_P5,LOCATION_ACTUAL_4HUR_P5,PARKINGTIME_ACTUAL_2HUR_P5,DEPARTURETIME_ACTUAL_2HUR_P5,LOCATION_ACTUAL_2HUR_P5,
            DRIVERNAME_ACTUAL_P6,DATESTART_ACTUAL_P6,PARKINGTIME_ACTUAL_4HUR_P6,DEPARTURETIME_ACTUAL_4HUR_P6,LOCATION_ACTUAL_4HUR_P6,PARKINGTIME_ACTUAL_2HUR_P6,DEPARTURETIME_ACTUAL_2HUR_P6,LOCATION_ACTUAL_2HUR_P6,
                                    
            DEALER1_ACTUAL,PARKINGTIME_ACTUAL_DEALER1,DEPARTURETIME_ACTUAL_DEALER1,SUM_ACTUAL_DEALER1,
            DEALER2_ACTUAL,PARKINGTIME_ACTUAL_DEALER2,DEPARTURETIME_ACTUAL_DEALER2,SUM_ACTUAL_DEALER2,
            DEALER3_ACTUAL,PARKINGTIME_ACTUAL_DEALER3,DEPARTURETIME_ACTUAL_DEALER3,SUM_ACTUAL_DEALER3,
            DEALER4_ACTUAL,PARKINGTIME_ACTUAL_DEALER4,DEPARTURETIME_ACTUAL_DEALER4,SUM_ACTUAL_DEALER4,
            CREATEBY_ACTUALGO,CREATEDATE_ACTUALGO,MODIFIEDBY_ACTUALGO,MIDIFIEDDATE_ACTUALGO,CONFIRMEDBY_ACTUALGO,CONVERT(VARCHAR,CONFIRMEDDATE_ACTUALGO,20) AS 'CONFIRMEDDATE_ACTUALGO',

            CONFIRMEDBY_P1,CONVERT(VARCHAR,CONFIRMEDDATE_P1,20) AS 'CONFIRMEDDATE_P1',CONFIRMEDBY_P2,CONVERT(VARCHAR,CONFIRMEDDATE_P2,20) AS 'CONFIRMEDDATE_P2',CONFIRMEDBY_P3,CONVERT(VARCHAR,CONFIRMEDDATE_P3,20) AS 'CONFIRMEDDATE_P3',
            CONFIRMEDBY_P4,CONVERT(VARCHAR,CONFIRMEDDATE_P4,20) AS 'CONFIRMEDDATE_P4',CONFIRMEDBY_P5,CONVERT(VARCHAR,CONFIRMEDDATE_P5,20) AS 'CONFIRMEDDATE_P5',CONFIRMEDBY_P6,CONVERT(VARCHAR,CONFIRMEDDATE_P6,20) AS 'CONFIRMEDDATE_P6',
            CONFIRMEDBY_ACTUAL_DEALER,CONVERT(VARCHAR,CONFIRMEDDATE_ACTUAL_DEALER,20) AS 'CONFIRMEDDATE_ACTUAL_DEALER',
            DRIVINGPATTERNGO_STATUS

            
            FROM DRIVINGPATTERN_GO 
            WHERE DRIVINGPATTERNGO_ID ='".$_GET['drivinggoplanid']."'";
        $params_seData = array();
        $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
        $result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC);       



        $tnkpchk     = ($result_seData['TNKP_CHECK'] == '1') ? "checked" : "";
        $tubonchk    = ($result_seData['TUBON_CHECK'] == '1') ? "checked" : "";
        $tthaiyenchk = ($result_seData['TTHAIYEN_CHECK'] == '1') ? "checked" : "";
        $tkanchk     = ($result_seData['TKAN_CHECK'] == '1') ? "checked" : "";
            
        if ($result_seData['DRIVINGPATTERNGO_STATUS'] == 'inprogess') {
            $bgcolor ="background-color: #f5f2a6";
        }else{
            $bgcolor ="background-color: #ffffff";
        }

        $employee1 = " AND a.PersonCode = '" .$result_seData['EMPLOYEECODE1'] . "'";
        $sql_seEmp1 = "{call megEmployeeEHR_v2(?,?)}";
        $params_seEmp1 = array(
            array('select_employeeehr2', SQLSRV_PARAM_IN),
            array($employee1, SQLSRV_PARAM_IN)
        );
        $query_seEmp1 = sqlsrv_query($conn, $sql_seEmp1, $params_seEmp1);
        $result_seEmp1 = sqlsrv_fetch_array($query_seEmp1, SQLSRV_FETCH_ASSOC);

        $employee2 = " AND a.PersonCode = '" .$result_seData['EMPLOYEECODE2'] . "'";
        $sql_seEmp2 = "{call megEmployeeEHR_v2(?,?)}";
        $params_seEmp2 = array(
            array('select_employeeehr2', SQLSRV_PARAM_IN),
            array($employee2, SQLSRV_PARAM_IN)
        );
        $query_seEmp2 = sqlsrv_query($conn, $sql_seEmp2, $params_seEmp2);
        $result_seEmp2 = sqlsrv_fetch_array($query_seEmp2, SQLSRV_FETCH_ASSOC);



        


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
                                <select  disabled="" id="txt_thainame" name="txt_thainame" class="selectpicker form-control" data-container="body" value="" data-live-search="true" title="" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                    <option  value="<?=$result_seData['THAINAME_ID']?>" ><?=$result_seData['THAINAME_ID']?></option>
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
                            </div>
                            <div class="col-lg-2" style="background-color: #e7e7e7">
                                <label style="font-size: 16px;">รูทงานตามแผน:</label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font>
                                <input type="text" class="form-control" type="hidden" id="txt_planningroute" name="txt_planningroute" value="<?=$result_seData['PLANING_ROUTE']?>" disabled="">
                            </div>
                            <div class="col-lg-2" style="background-color: #e7e7e7">
                                <label style="font-size: 16px;">รูทงานวิ่งจริง:</label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font>
                                <input type="text" class="form-control" type="hidden" id="txt_actualroute" name="txt_actualroute" value="<?=$result_seData['ACTUAL_ROUTE']?>" disabled="">
                            </div>
                            <div class="form-group">
                                <!-- <label >ช่วงเวลาของการนอน(ปกติ)</label><br><br> -->
                                <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                <div class="col-lg-2">
                                    <?php
                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                    ?>
                                        <label style="font-size: 16px;" ><u>วัน/เดือน/ปี</u></label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font><br>
                                        <input type="datetime-local"  style="height:35px; width:315px;" id="txt_drivingdate" name="txt_drivingdate" value="<?= $result_seData['DRIVINGPATTERN_DATE'] ?>" min="" max=""  autocomplete="off" disabled="">
                                    <?php
                                    }else { //สำหรับ PC DESKTOP

                                        $DRIVINGPATTERNDATECHK = str_replace("T"," ",$result_seData['DRIVINGPATTERN_DATE']);
                                        $DRIVINGPATTERNDATE = str_replace("-","/",$DRIVINGPATTERNDATECHK);
                                    ?> 
                                        <label style="font-size: 16px;" ><u>วัน/เดือน/ปี</u></label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font><br>
                                        <input class="form-control dateen"   style=""  id="txt_drivingdate" name="txt_drivingdate"  value="<?= $DRIVINGPATTERNDATE ?>" min="" max="" autocomplete="off" disabled="">
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
                                <p>5. ปรับสลักเป็น 4x2 หรือต่ำกว่า ก่อนไปยังดีลเลอร์ ที่มีปัญหาเรื่องความสูง<br>(ทำเครื่องหมาย ✔ ในช่อง ☐ เพื่อยืนยันว่ามีการปรับแล้ว) </p>
                                <p> โตโยต้า นครพิงค์     <input style="height:30px; width:30px; vertical-align: middle;background-color: red" type="checkbox" id="chk_tnkp" <?= $tnkpchk ?> name="chk_tnkp" value="" disabled="">
                                    &nbsp;&nbsp;&nbsp;
                                    โตโยต้า อุบลราชธานี  <input style="height:30px; width:30px; vertical-align: middle;background-color: red" type="checkbox" id="chk_tubon" <?= $tubonchk ?> name="chk_tubon" value="" disabled="">
                                </p>
                                <p> โตโยต้า ไทยเย็น     <input style="height:30px; width:30px; vertical-align: middle;background-color: red" type="checkbox" id="chk_tthaiyen" <?= $tthaiyenchk ?> name="chk_tthaiyen" value="" disabled="">
                                    &nbsp;&nbsp;&nbsp;
                                    โตโยต้า กาญจนบุรี &nbsp;&nbsp;&nbsp; <input style="height:30px; width:30px; vertical-align: middle;background-color: red" type="checkbox" id="chk_tkan" <?= $tkanchk ?> name="chk_tkan" value="" disabled="">
                                </p>
                                <!-- <label style="font-size: 20px;">แผนวิ่งงาน ขาไป:</label> -->
                            </div> 
                            <div class="col-lg-4 panel-body" style="text-align: left;background-color: #e7e7e7;">
                                <p><b><u>วีธีการ</u></b></p>
                                <p><u>ขั้นตอนเท็งโกะเริ่มงาน :</u> ให้ พขร. และผู้ควบคุมร่วมกันวางแผนวิ่งงานทราขาไปและ<br>ขากลับและให้ พขร. แบ่งหน้าที่ว่าใครเป็นนายA และนาย B<p></p>
                                <p><u>ขั้นตอนเท็งโกะเลิกงาน :</u> ให้ พขร. ลงบันทึกการขับขี่จริงพร้อมยื่นให้เจ้าหน้าที่เท็งโกะ<br>ตรวจสอบการวิ่งงานจริง<p></p>
                                <p><u>Driving Pattern :</u> แผนขาไป/วิ่งจริงขาไป</p>
                                <p><u>Jobno:</u> <?=$result_seData['PLANID1']?><p></p>
                                <!-- <label style="font-size: 20px;">แผนวิ่งงาน ขาไป:</label> -->
                                
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
                                        <td  id ="txt_tlepidemp1"><?=$result_seData['EMPLOYEECODE1']?></td>
                                    </tr>
                                    <tr>
                                        <td>ชื่อ-นามสกุล</td>
                                        <td id ="txt_empname1"><?=$result_seData['EMPLOYEENAME1']?></td>
                                    </tr>
                                    <tr>
                                        <td>อายุงาน</td>
                                        <td><?=$result_seEmp1['yearw']?> ปี / <?=$result_seEmp1['monthw']?> เดือน / <?=$result_seEmp1['dayw']?> วัน</td>
                                    </tr>
                                    <tr>
                                        <td rowspan="3"><b>นาย B</b></td>
                                        <td>รหัสพนักงาน</td>
                                        <td id ="txt_tlepidemp2"><?=$result_seData['EMPLOYEECODE2']?></td>
                                    </tr>
                                    <tr>
                                        <td>ชื่อ-นามสกุล</td>
                                        <td id ="txt_empname2"><?=$result_seData['EMPLOYEENAME2']?></td>
                                    </tr>
                                    <tr>
                                        <td>อายุงาน</td>
                                        <td><?=$result_seEmp2['yearw']?> ปี / <?=$result_seEmp2['monthw']?> เดือน / <?=$result_seEmp2['dayw']?> วัน</td>
                                    </tr>
                                    <tr>
                                        <td><b>ผู้ตรวจแผนขาไป</b></td>
                                        <td colspan="2" id ="txt_officerapprovego"><?=$result_seEmp1['nameT']?></td>
                                    </tr>
                                </table>
                            </div> 
                            <br><br><br>
                            <!-- <div class="panel-body" style= "text-align: center;">
                                <br><br>
                                <label style="font-size: 20px;">แผนวิ่งงาน ขาไป:</label>
                            </div>    -->
                            <div class="col-lg-6" style="background-color: #e7e7e7">
                                <p style="font-size: 26px;text-align: center;"><b><u>แผนขาไป</u></b></p>
                            </div> 
                            <div class="col-lg-6" style="background-color: #e7e7e7">
                                <p style="font-size: 26px;text-align: center;"><b><u>วิ่งจริงขาไป</u></b></p>
                            </div> 
                            <div class="col-lg-3" style="background-color: #e7e7e7">
                                <label style="font-size: 16px;">ออกเดินทางจาก (แผน):</label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font>
                                <input type="text" class="form-control" type="hidden" id="txt_jobstartplango" name="txt_jobstartplango" value="RRR" disabled="">
                            </div>            
                            <div class="form-group">
                                <!-- <label >ช่วงเวลาของการนอน(ปกติ)</label><br><br> -->
                                <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                <div class="col-lg-3">
                                    <?php
                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                    ?>
                                        <label style="font-size: 16px;" ><u>วันที่/เวลา</u></label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font><br>
                                        <input type="datetime-local"  style="height:35px; width:315px;" id="txt_datestartplango" name="txt_datestartplango" value="<?= $result_seData['DATESTARTPLAN'] ?>" min="" max=""  autocomplete="off" disabled="">
                                    <?php
                                    }else { //สำหรับ PC DESKTOP

                                        $DATESTARTPLANCHK   = str_replace("T"," ",$result_seData['DATESTARTPLAN']);
                                        $DATESTARTPLAN      = str_replace("-","/",$DATESTARTPLANCHK);
                                    ?> 
                                        <label style="font-size: 16px;" ><u>วันที่/เวลา (แผน)</u></label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font><br>
                                        <input class="form-control dateen"   style=""  id="txt_datestartplango" name="txt_datestartplango"  value="<?= $DATESTARTPLAN ?>" min="" max="" autocomplete="off" disabled="">
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>     
                            <div class="col-lg-3" style="background-color: #e7e7e7">
                                <label style="font-size: 16px;">ออกเดินทางจาก (วิ่งจริง):</label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font>
                                <input type="text" class="form-control" type="hidden" id="txt_jobstartactual" name="txt_jobstartactual" value="RRR" disabled="">
                            </div>            
                            <div class="form-group">
                                <!-- <label >ช่วงเวลาของการนอน(ปกติ)</label><br><br> -->
                                <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                <div class="col-lg-3">
                                    <?php
                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                    ?>
                                        <label style="font-size: 16px;" ><u>วันที่/เวลา</u></label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font><br>
                                        <input type="datetime-local"  style="height:35px; width:315px;" id="txt_datestartactual" name="txt_datestartactual" value="<?= $result_seData['DATESTARTACTUAL'] ?>" min="" max=""  autocomplete="off">
                                    <?php
                                    }else { //สำหรับ PC DESKTOP

                                        $DATESTARTACTUALCHK = str_replace("T"," ",$result_seData['DATESTARTACTUAL']);
                                        $DATESTARTACTUAL = str_replace("-","/",$DATESTARTACTUALCHK);
                                    ?> 
                                        <label style="font-size: 16px;" ><u>วันที่/เวลา (วิ่งจริง)</u></label>&nbsp;&nbsp;<font style="color: red;font-size: 18px;"><b>*</b></font><br>
                                        <input class="form-control dateen"   style=""  id="txt_datestartactual" name="txt_datestartactual"  value="<?= $DATESTARTACTUAL ?>" min="" max="" autocomplete="off">
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>  
                            <div class = "row">
                                <label ></label>
                            </div>
                    <input  class="form-control" type="hidden" id="txt_username" name="txt_username" value="<?= $result_seEmpchk["nameT"]?>">
                   
                    <div id="datadef_edit">
                        <div class="panel-body">
                            <!-- <div class="row" > -->
                            <div class="row" >
                                <div class="col-lg-12" >   
                            </div>        
                            <div class ="row"></div>
                            <!-- START ROW1 -->
                            <div class="row" >
                                <div class="col-lg-6" >
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color: #f0c402;">
                                            <label><font style="font-size: 16px;">แผนขาไป (ช่วงที่1)</font></label>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                <div class="col-lg-6">
                                                    <label style="font-size: 16px;">ชื่อผู้ขับ:</label>
                                                    <select   id="txt_drivernameplan_p1" name="txt_drivernameplan_p1" class="selectpicker form-control" value="" data-container="body" data-live-search="true" title="" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                        <option hidden value="<?= $result_seData['DRIVERNAME_PLAN_P1'] ?>"><?= $result_seData['DRIVERNAME_PLAN_P1'] ?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME1'] ?>"><?= $result_seData['EMPLOYEENAME1'] ?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME2'] ?>"><?= $result_seData['EMPLOYEENAME2'] ?></option>
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
                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_datestartplan_p1" name="txt_datestartplan_p1" value="<?= $result_seData['DATESTART_PLAN_P1'] ?>" min="" max=""  autocomplete="off">
                                                    <?php
                                                    }else { //สำหรับ PC DESKTOP

                                                        $DATESTARTPLAN_P1CHK = str_replace("T"," ",$result_seData['DATESTART_PLAN_P1']);
                                                        $DATESTARTPLAN_P1 = str_replace("-","/",$DATESTARTPLAN_P1CHK);
                                                    ?> 
                                                        <br>
                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_datestartplan_p1" name="txt_datestartplan_p1"  value="<?= $DATESTARTPLAN_P1 ?>" min="" max="" autocomplete="off">
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class = "row" style="height:80px;"></div>
                                                <div class = "row">
                                                    <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 100%;text-align: center;background-color: #e7e7e7">ระยะเวลาการขับรถ 4 ชั่วโมง</th>
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_4hur_p1" name="txt_parkingtime_plan_4hur_p1" value="<?= $result_seData['PARKINGTIME_PLAN_4HUR_P1'] ?>" min="" max=""  onchange ="parkingtime_plan_4hrs_p1('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_PLAN_4HUR_P1CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_4HUR_P1']);
                                                                        $PARKINGTIME_PLAN_4HUR_P1 = str_replace("-","/",$PARKINGTIME_PLAN_4HUR_P1CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_4hur_p1" name="txt_parkingtime_plan_4hur_p1"  value="<?= $PARKINGTIME_PLAN_4HUR_P1 ?>" min="" max="" onchange ="parkingtime_plan_4hrs_p1('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p1" name="txt_departuretime_plan_4hur_p1" value="<?= $result_seData['DEPARTURETIME_PLAN_4HUR_P1'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_PLAN_4HUR_P1CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_4HUR_P1']);
                                                                        $DEPARTURETIME_PLAN_4HUR_P1 = str_replace("-","/",$DEPARTURETIME_PLAN_4HUR_P1CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p1" name="txt_departuretime_plan_4hur_p1" value="<?= $DEPARTURETIME_PLAN_4HUR_P1 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px;width:240px" id="txt_location_plan_4hur_p1" name="txt_location_plan_4hur_p1" value="<?= $result_seData['LOCATION_PLAN_4HUR_P1'] ?>" min="" max=""  autocomplete="off">
                                                                </div>    
                                                            </div>
                                                        </form>
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_2hur_p1" name="txt_parkingtime_plan_2hur_p1" value="<?= $result_seData['PARKINGTIME_PLAN_2HUR_P1'] ?>" min="" max=""  onchange ="parkingtime_plan_2hrs_p1('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_PLAN_2HUR_P1CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_2HUR_P1']);
                                                                        $PARKINGTIME_PLAN_2HUR_P1 = str_replace("-","/",$PARKINGTIME_PLAN_2HUR_P1CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_2hur_p1" name="txt_parkingtime_plan_2hur_p1"  value="<?= $PARKINGTIME_PLAN_2HUR_P1 ?>" min="" max="" onchange ="parkingtime_plan_2hrs_p1('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p1" name="txt_departuretime_plan_2hur_p1" value="<?= $result_seData['DEPARTURETIME_PLAN_2HUR_P1'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_PLAN_2HUR_P1CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_2HUR_P1']);
                                                                        $DEPARTURETIME_PLAN_2HUR_P1 = str_replace("-","/",$DEPARTURETIME_PLAN_2HUR_P1CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p1" name="txt_departuretime_plan_2hur_p1" value="<?= $DEPARTURETIME_PLAN_2HUR_P1 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px;width:240px" id="txt_location_plan_2hur_p1" name="txt_location_plan_2hur_p1" value="<?= $result_seData['LOCATION_PLAN_2HUR_P1'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <label ></label>
                                                </div>
                                                <div class = "row">
                                                    <label ></label>
                                                </div>
                                                <div class = "row" style="height:90px;">
                                                    <label ></label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END COLUNM1 -->  


                                <!-- START COLUNM2 -->
                                <div class="col-lg-6" >
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color: #02c719;">
                                            <label><font style="font-size: 16px;">วิ่งจริงขาไป (ช่วงที่1)</font></label>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                <div class="col-lg-6">
                                                    <label style="font-size: 16px;">ชื่อผู้ขับ:</label>
                                                    <select   id="txt_drivernameactual_p1" name="txt_drivernameactual_p1" class="selectpicker form-control" data-container="body" data-live-search="true" title="" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                        <option value="<?=$result_seData['DRIVERNAME_ACTUAL_P1']?>"><?=$result_seData['DRIVERNAME_ACTUAL_P1']?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME1'] ?>"><?= $result_seData['EMPLOYEENAME1'] ?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME2'] ?>"><?= $result_seData['EMPLOYEENAME2'] ?></option>
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
                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_datestartactual_p1" name="txt_datestartactual_p1" value="<?= $result_seData['DATESTART_ACTUAL_P1'] ?>" min="" max=""  autocomplete="off">
                                                    <?php
                                                    }else { //สำหรับ PC DESKTOP

                                                        $DATESTART_ACTUAL_P1CHK = str_replace("T"," ",$result_seData['DATESTART_ACTUAL_P1']);
                                                        $DATESTART_ACTUAL_P1 = str_replace("-","/",$DATESTART_ACTUAL_P1CHK);
                                                    ?> 
                                                        <br>
                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_datestartactual_p1" name="txt_datestartactual_p1"  value="<?= $DATESTART_ACTUAL_P1 ?>" min="" max="" autocomplete="off">
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_actual_4hur_p1" name="txt_parkingtime_actual_4hur_p1" value="<?= $result_seData['PARKINGTIME_ACTUAL_4HUR_P1']?>" min="" max=""  onchange ="parkingtime_actual_4hrs_p1('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_ACTUAL_4HUR_P1CHK = str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_4HUR_P1']);
                                                                        $PARKINGTIME_ACTUAL_4HUR_P1 = str_replace("-","/",$PARKINGTIME_ACTUAL_4HUR_P1CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_actual_4hur_p1" name="txt_parkingtime_actual_4hur_p1"  value="<?= $PARKINGTIME_ACTUAL_4HUR_P1 ?>" min="" max="" onchange ="parkingtime_actual_4hrs_p1('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_actual_4hur_p1" name="txt_departuretime_actual_4hur_p1" value="<?= $result_seData['DEPARTURETIME_ACTUAL_4HUR_P1'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_ACTUAL_4HUR_P1CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_4HUR_P1']);
                                                                        $DEPARTURETIME_ACTUAL_4HUR_P1 = str_replace("-","/",$DEPARTURETIME_ACTUAL_4HUR_P1CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_actual_4hur_p1" name="txt_departuretime_actual_4hur_p1" value="<?= $DEPARTURETIME_ACTUAL_4HUR_P1 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px;width:240px" id="txt_location_actual_4hur_p1" name="txt_location_actual_4hur_p1" value="<?= $result_seData['LOCATION_ACTUAL_4HUR_P1'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_actual_2hur_p1" name="txt_parkingtime_actual_2hur_p1" value="<?= $result_seData['PARKINGTIME_ACTUAL_2HUR_P1'] ?>" min="" max=""  onchange ="parkingtime_actual_2hrs_p1('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_ACTUAL_2HUR_P1CHK = str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_2HUR_P1']);
                                                                        $PARKINGTIME_ACTUAL_2HUR_P1 = str_replace("-","/",$PARKINGTIME_ACTUAL_2HUR_P1CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_actual_2hur_p1" txt_parkingtime_actual_2hur_p1="daysleep_normalstart"  value="<?= $PARKINGTIME_ACTUAL_2HUR_P1 ?>" min="" max="" onchange ="parkingtime_actual_2hrs_p1('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_actual_2hur_p1" name="txt_departuretime_actual_2hur_p1" value="<?= $result_seData['PARKINGTIME_ACTUAL_2HUR_P1'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_ACTUAL_2HUR_P1CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_2HUR_P1']);
                                                                        $DEPARTURETIME_ACTUAL_2HUR_P1 = str_replace("-","/",$DEPARTURETIME_ACTUAL_2HUR_P1CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_actual_2hur_p1" name="txt_departuretime_actual_2hur_p1" value="<?= $DEPARTURETIME_ACTUAL_2HUR_P1 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px;width:240px" id="txt_location_actual_2hur_p1" name="txt_location_actual_2hur_p1" value="<?= $result_seData['LOCATION_ACTUAL_2HUR_P1'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <label ></label>
                                                </div>
                                                <div class = "row">
                                                    <form class="form-inline">
                                                        <div class="form-group">
                                                            <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                            <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                            <div class="col-lg-4">
                                                                <label ><br><br></label>
                                                                <button type="button" style="height:70px;" class="btn btn-primary btn-lg" onclick ="confirmdatap1('<?=$checkClient?>','CONP1');">กดยืนยันข้อมูล(ช่วงที่1)</button>   
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label ><u>ผู้ยืนยันข้อมูล</u></label><br>
                                                                <input disabled="" class="form-control" type="text" style="height:40px; width:240px" id="txt_confirm_p1" name="txt_confirm_p1" value="<?= $result_seData['CONFIRMEDBY_P1'] ?>" min="" max=""  autocomplete="off">
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label ><u>เวลายืนยันข้อมูล</u></label><br>
                                                                <input disabled="" class="form-control" type="text"  style="height:40px;width:240px" id="txt_dateconfirm_p1" name="txt_dateconfirm_p1" value="<?= substr($result_seData['CONFIRMEDDATE_P1'],0,16) ?>" min="" max=""  autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </form>
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
                                <div class="col-lg-6" >
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color: #f0c402;">
                                            <label><font style="font-size: 16px;">แผนขาไป (ช่วงที่2)</font></label>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                <div class="col-lg-6">
                                                    <label style="font-size: 16px;">ชื่อผู้ขับ:</label>
                                                    <select   id="txt_drivernameplan_p2" name="txt_drivernameplan_p2" class="selectpicker form-control" value="" data-container="body" data-live-search="true" title="" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                        <option hidden value="<?= $result_seData['DRIVERNAME_PLAN_P2'] ?>"><?= $result_seData['DRIVERNAME_PLAN_P2'] ?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME1'] ?>"><?= $result_seData['EMPLOYEENAME1'] ?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME2'] ?>"><?= $result_seData['EMPLOYEENAME2'] ?></option>
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
                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_datestartplan_p2" name="txt_datestartplan_p2" value="<?= $result_seData['DATESTART_PLAN_P2'] ?>" min="" max=""  autocomplete="off">
                                                    <?php
                                                    }else { //สำหรับ PC DESKTOP

                                                        $DATESTARTPLAN_P2CHK = str_replace("T"," ",$result_seData['DATESTART_PLAN_P2']);
                                                        $DATESTARTPLAN_P2 = str_replace("-","/",$DATESTARTPLAN_P2CHK);
                                                    ?> 
                                                        <br>
                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_datestartplan_p2" name="txt_datestartplan_p2"  value="<?= $DATESTARTPLAN_P2 ?>" min="" max="" autocomplete="off">
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_4hur_p2" name="txt_parkingtime_plan_4hur_p2" value="<?= $result_seData['PARKINGTIME_PLAN_4HUR_P2'] ?>" min="" max=""  onchange ="parkingtime_plan_4hrs_p2('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_PLAN_4HUR_P2CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_4HUR_P2']);
                                                                        $PARKINGTIME_PLAN_4HUR_P2 = str_replace("-","/",$PARKINGTIME_PLAN_4HUR_P2CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_4hur_p2" name="txt_parkingtime_plan_4hur_p2"  value="<?= $PARKINGTIME_PLAN_4HUR_P2 ?>" min="" max="" onchange ="parkingtime_plan_4hrs_p2('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p2" name="txt_departuretime_plan_4hur_p2" value="<?= $result_seData['DEPARTURETIME_PLAN_4HUR_P2'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_PLAN_4HUR_P2CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_4HUR_P2']);
                                                                        $DEPARTURETIME_PLAN_4HUR_P2 = str_replace("-","/",$DEPARTURETIME_PLAN_4HUR_P2CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p2" name="txt_departuretime_plan_4hur_p2" value="<?= $DEPARTURETIME_PLAN_4HUR_P2 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px;width:240px" id="txt_location_plan_4hur_p2" name="txt_location_plan_4hur_p2" value="<?= $result_seData['LOCATION_PLAN_4HUR_P2'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_2hur_p2" name="txt_parkingtime_plan_2hur_p2" value="<?= $result_seData['PARKINGTIME_PLAN_2HUR_P2'] ?>" min="" max=""  onchange ="parkingtime_plan_2hrs_p2('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_PLAN_2HUR_P2CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_2HUR_P2']);
                                                                        $PARKINGTIME_PLAN_2HUR_P2 = str_replace("-","/",$PARKINGTIME_PLAN_2HUR_P2CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_2hur_p2" name="txt_parkingtime_plan_2hur_p2"  value="<?= $PARKINGTIME_PLAN_2HUR_P2 ?>" min="" max="" onchange ="parkingtime_plan_2hrs_p2('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p2" name="txt_departuretime_plan_2hur_p2" value="<?= $result_seData['DEPARTURETIME_PLAN_2HUR_P2'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_PLAN_2HUR_P2CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_2HUR_P2']);
                                                                        $DEPARTURETIME_PLAN_2HUR_P2 = str_replace("-","/",$DEPARTURETIME_PLAN_2HUR_P2CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p2" name="txt_departuretime_plan_2hur_p2" value="<?= $DEPARTURETIME_PLAN_2HUR_P2 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px;width:240px" id="txt_location_plan_2hur_p2" name="txt_location_plan_2hur_p2" value="<?= $result_seData['LOCATION_PLAN_2HUR_P2'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <label ></label>
                                                </div>
                                                <div class = "row">
                                                    <label ></label>
                                                </div>
                                                <div class = "row" style="height:90px;">
                                                    <label ></label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END COLUNM3 -->

                                <!-- START COLUNM4 -->
                                <div class="col-lg-6" >
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color: #02c719;">
                                            <label><font style="font-size: 16px;">วิ่งจริงขาไป (ช่วงที่2)</font></label>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                <div class="col-lg-6">
                                                    <label style="font-size: 16px;">ชื่อผู้ขับ:</label>
                                                    <select   id="txt_drivernameactual_p2" name="txt_drivernameactual_p2" class="selectpicker form-control" data-container="body" data-live-search="true" title="" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                        <option hidden value="<?=$result_seData['DRIVERNAME_ACTUAL_P2']?>"><?=$result_seData['DRIVERNAME_ACTUAL_P2']?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME1'] ?>"><?= $result_seData['EMPLOYEENAME1'] ?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME2'] ?>"><?= $result_seData['EMPLOYEENAME2'] ?></option>
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
                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_datestartactual_p2" name="txt_datestartactual_p2" value="<?= $result_seData['DATESTART_ACTUAL_P2'] ?>" min="" max=""  autocomplete="off">
                                                    <?php
                                                    }else { //สำหรับ PC DESKTOP

                                                        $DATESTART_ACTUAL_P2CHK = str_replace("T"," ",$result_seData['DATESTART_ACTUAL_P2']);
                                                        $DATESTART_ACTUAL_P2 = str_replace("-","/",$DATESTART_ACTUAL_P2CHK);
                                                    ?> 
                                                        <br>
                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_datestartactual_p2" name="txt_datestartactual_p2"  value="<?= $DATESTART_ACTUAL_P2 ?>" min="" max="" autocomplete="off">
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_actual_4hur_p2" name="txt_parkingtime_actual_4hur_p2" value="<?= $result_seData['PARKINGTIME_ACTUAL_4HUR_P2'] ?>" min="" max=""  onchange ="parkingtime_actual_4hrs_p2('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_ACTUAL_4HUR_P2CHK = str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_4HUR_P2']);
                                                                        $PARKINGTIME_ACTUAL_4HUR_P2 = str_replace("-","/",$PARKINGTIME_ACTUAL_4HUR_P2CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_actual_4hur_p2" name="txt_parkingtime_actual_4hur_p2"  value="<?= $PARKINGTIME_ACTUAL_4HUR_P2 ?>" min="" max="" onchange ="parkingtime_actual_4hrs_p2('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_actual_4hur_p2" name="txt_departuretime_actual_4hur_p2" value="<?= $result_seData['DEPARTURETIME_ACTUAL_4HUR_P2'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_ACTUAL_4HUR_P2CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_4HUR_P2']);
                                                                        $DEPARTURETIME_ACTUAL_4HUR_P2 = str_replace("-","/",$DEPARTURETIME_ACTUAL_4HUR_P2CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_actual_4hur_p2" name="txt_departuretime_actual_4hur_p2" value="<?= $DEPARTURETIME_ACTUAL_4HUR_P2 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_actual_4hur_p2" name="txt_location_actual_4hur_p2" value="<?= $result_seData['LOCATION_ACTUAL_4HUR_P2'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_actual_2hur_p2" name="txt_parkingtime_actual_2hur_p2" value="<?= $result_seData['PARKINGTIME_ACTUAL_2HUR_P2'] ?>" min="" max=""  onchange ="parkingtime_actual_2hrs_p2('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_ACTUAL_2HUR_P2CHK = str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_2HUR_P2']);
                                                                        $PARKINGTIME_ACTUAL_2HUR_P2 = str_replace("-","/",$PARKINGTIME_ACTUAL_2HUR_P2CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_actual_2hur_p2" name="txt_parkingtime_actual_2hur_p2"  value="<?= $PARKINGTIME_ACTUAL_2HUR_P2 ?>" min="" max="" onchange ="parkingtime_actual_2hrs_p2('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_actual_2hur_p2" name="txt_departuretime_actual_2hur_p2" value="<?= $result_seData['DEPARTURETIME_ACTUAL_2HUR_P2'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_ACTUAL_2HUR_P2CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_2HUR_P2']);
                                                                        $DEPARTURETIME_ACTUAL_2HUR_P2 = str_replace("-","/",$DEPARTURETIME_ACTUAL_2HUR_P2CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_actual_2hur_p2" name="txt_departuretime_actual_2hur_p2" value="<?= $DEPARTURETIME_ACTUAL_2HUR_P2 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_actual_2hur_p2" name="txt_location_actual_2hur_p2" value="<?= $result_seData['LOCATION_ACTUAL_2HUR_P2'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                            
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <label ></label>
                                                </div>
                                                <div class = "row">
                                                    <form class="form-inline">
                                                        <div class="form-group">
                                                            <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                            <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                            <div class="col-lg-4">
                                                                <label ><br><br></label>
                                                                <button type="button" style="height:70px;" class="btn btn-primary btn-lg" onclick ="confirmdatap2('<?=$checkClient?>');">กดยืนยันข้อมูล(ช่วงที่2)</button>   
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label ><u>ผู้ยืนยันข้อมูล</u></label><br>
                                                                <input disabled="" class="form-control" type="text" style="height:40px; width:240px" id="txt_confirm_p2" name="txt_confirm_p2" value="<?= $result_seData['CONFIRMEDBY_P2'] ?>" min="" max=""  autocomplete="off">
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label ><u>เวลายืนยันข้อมูล</u></label><br>
                                                                <input disabled="" class="form-control" type="text"  style="height:40px;width:240px" id="txt_dateconfirm_p2" name="txt_dateconfirm_p2" value="<?= substr($result_seData['CONFIRMEDDATE_P2'],0,16) ?>" min="" max=""  autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </form>
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
                                <div class="col-lg-6" >
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color: #f0c402;">
                                            <label><font style="font-size: 16px;">แผนขาไป (ช่วงที่3)</font></label>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                <div class="col-lg-6">
                                                    <label style="font-size: 16px;">ชื่อผู้ขับ:</label>
                                                    <select   id="txt_drivernameplan_p3" name="txt_drivernameplan_p3" class="selectpicker form-control" value="" data-container="body" data-live-search="true" title="" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                        <option hidden value="<?= $result_seData['DRIVERNAME_PLAN_P3'] ?>"><?= $result_seData['DRIVERNAME_PLAN_P3'] ?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME1'] ?>"><?= $result_seData['EMPLOYEENAME1'] ?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME2'] ?>"><?= $result_seData['EMPLOYEENAME2'] ?></option>
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
                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_datestartplan_p3" name="txt_datestartplan_p3" value="<?= $result_seData['DATESTART_PLAN_P3'] ?>" min="" max=""  autocomplete="off">
                                                    <?php
                                                    }else { //สำหรับ PC DESKTOP

                                                        $DATESTART_PLAN_P3CHK = str_replace("T"," ",$result_seData['DATESTART_PLAN_P3']);
                                                        $DATESTART_PLAN_P3 = str_replace("-","/",$DATESTART_PLAN_P3CHK);
                                                    ?> 
                                                        <br>
                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_datestartplan_p3" name="txt_datestartplan_p3"  value="<?= $DATESTART_PLAN_P3 ?>" min="" max="" autocomplete="off">
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_4hur_p3" name="txt_parkingtime_plan_4hur_p3" value="<?= $result_seData['PARKINGTIME_PLAN_4HUR_P3'] ?>" min="" max=""  onchange ="parkingtime_plan_4hrs_p3('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_PLAN_4HUR_P3CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_4HUR_P3']);
                                                                        $PARKINGTIME_PLAN_4HUR_P3 = str_replace("-","/",$PARKINGTIME_PLAN_4HUR_P3CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_4hur_p3" name="txt_parkingtime_plan_4hur_p3"  value="<?= $PARKINGTIME_PLAN_4HUR_P3 ?>" min="" max=""  onchange ="parkingtime_plan_4hrs_p3('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p3" name="txt_departuretime_plan_4hur_p3" value="<?= $result_seData['DEPARTURETIME_PLAN_4HUR_P3'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_PLAN_4HUR_P3CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_4HUR_P3']);
                                                                        $DEPARTURETIME_PLAN_4HUR_P3 = str_replace("-","/",$DEPARTURETIME_PLAN_4HUR_P3CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p3" name="txt_departuretime_plan_4hur_p3" value="<?= $DEPARTURETIME_PLAN_4HUR_P3 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_plan_4hur_p3" name="txt_location_plan_4hur_p3" value="<?= $result_seData['LOCATION_PLAN_4HUR_P3'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_2hur_p3" name="txt_parkingtime_plan_2hur_p3" value="<?= $result_seData['PARKINGTIME_PLAN_2HUR_P3'] ?>" min="" max=""  onchange ="parkingtime_plan_2hrs_p3('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_PLAN_2HUR_P3CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_2HUR_P3']);
                                                                        $PARKINGTIME_PLAN_2HUR_P3 = str_replace("-","/",$PARKINGTIME_PLAN_2HUR_P3CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_2hur_p3" name="txt_parkingtime_plan_2hur_p3"  value="<?= $PARKINGTIME_PLAN_2HUR_P3 ?>" min="" max="" onchange ="parkingtime_plan_2hrs_p3('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p3" name="txt_departuretime_plan_2hur_p3" value="<?= $result_seData['DEPARTURETIME_PLAN_2HUR_P3'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_PLAN_2HUR_P3CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_2HUR_P3']);
                                                                        $DEPARTURETIME_PLAN_2HUR_P3 = str_replace("-","/",$DEPARTURETIME_PLAN_2HUR_P3CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p3" name="txt_departuretime_plan_2hur_p3" value="<?= $DEPARTURETIME_PLAN_2HUR_P3 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_plan_2hur_p3" name="txt_location_plan_2hur_p3" value="<?= $result_seData['LOCATION_PLAN_2HUR_P3'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <label ></label>
                                                </div>
                                                <div class = "row">
                                                    <label ></label>
                                                </div>
                                                <div class = "row" style="height:90px;">
                                                    <label ></label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--END COLUNM5  --> 

                                <!-- START COLUNM6 -->
                                <div class="col-lg-6" >
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color: #02c719;">
                                            <label><font style="font-size: 16px;">วิ่งจริงขาไป (ช่วงที่3)</font></label>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                <div class="col-lg-6">
                                                    <label style="font-size: 16px;">ชื่อผู้ขับ:</label>
                                                    <select   id="txt_drivernameactual_p3" name="txt_drivernameactual_p3" class="selectpicker form-control" data-container="body" data-live-search="true" title="" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                        <option hidden value="<?=$result_seData['DRIVERNAME_ACTUAL_P3']?>"><?=$result_seData['DRIVERNAME_ACTUAL_P3']?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME1'] ?>"><?= $result_seData['EMPLOYEENAME1'] ?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME2'] ?>"><?= $result_seData['EMPLOYEENAME2'] ?></option>
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
                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_datestartactual_p3" name="txt_datestartactual_p3" value="<?= $result_seData['DATESTART_ACTUAL_P3'] ?>" min="" max=""  autocomplete="off">
                                                    <?php
                                                    }else { //สำหรับ PC DESKTOP

                                                        $DATESTART_ACTUAL_P3CHK = str_replace("T"," ",$result_seData['DATESTART_ACTUAL_P3']);
                                                        $DATESTART_ACTUAL_P3 = str_replace("-","/",$DATESTART_ACTUAL_P3CHK);
                                                    ?> 
                                                        <br>
                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_datestartactual_p3" name="txt_datestartactual_p3"  value="<?= $DATESTART_ACTUAL_P3 ?>" min="" max="" autocomplete="off">
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_actual_4hur_p3" name="txt_parkingtime_actual_4hur_p3" value="<?= $result_seData['PARKINGTIME_ACTUAL_4HUR_P3'] ?>" min="" max=""  onchange ="parkingtime_actual_4hrs_p3('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_ACTUAL_4HUR_P3CHK = str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_4HUR_P3']);
                                                                        $PARKINGTIME_ACTUAL_4HUR_P3 = str_replace("-","/",$PARKINGTIME_ACTUAL_4HUR_P3CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_actual_4hur_p3" name="txt_parkingtime_actual_4hur_p3"  value="<?= $PARKINGTIME_ACTUAL_4HUR_P3 ?>" min="" max="" onchange ="parkingtime_actual_4hrs_p3('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_actual_4hur_p3" name="txt_departuretime_actual_4hur_p3" value="<?= $result_seData['PARKINGTIME_ACTUAL_4HUR_P3'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_ACTUAL_4HUR_P3CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_4HUR_P3']);
                                                                        $DEPARTURETIME_ACTUAL_4HUR_P3 = str_replace("-","/",$DEPARTURETIME_ACTUAL_4HUR_P3CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_actual_4hur_p3" name="txt_departuretime_actual_4hur_p3" value="<?= $DEPARTURETIME_ACTUAL_4HUR_P3 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_actual_4hur_p3" name="txt_location_actual_4hur_p3" value="<?= $result_seData['LOCATION_PLAN_4HUR_P3'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_actual_2hur_p3" name="txt_parkingtime_actual_2hur_p3" value="<?= $result_seData['PARKINGTIME_ACTUAL_2HUR_P3'] ?>" min="" max=""  onchange ="parkingtime_actual_2hrs_p3('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_ACTUAL_2HUR_P3CHK = str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_2HUR_P3']);
                                                                        $PARKINGTIME_ACTUAL_2HUR_P3 = str_replace("-","/",$PARKINGTIME_ACTUAL_2HUR_P3CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_actual_2hur_p3" name="txt_parkingtime_actual_2hur_p3"  value="<?= $PARKINGTIME_ACTUAL_2HUR_P3 ?>" min="" max="" onchange ="parkingtime_actual_2hrs_p3('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_actual_2hur_p3" name="txt_departuretime_actual_2hur_p3" value="<?= $result_seData['DEPARTURETIME_ACTUAL_2HUR_P3'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_ACTUAL_2HUR_P3CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_2HUR_P3']);
                                                                        $DEPARTURETIME_ACTUAL_2HUR_P3 = str_replace("-","/",$DEPARTURETIME_ACTUAL_2HUR_P3CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_actual_2hur_p3" name="txt_departuretime_actual_2hur_p3" value="<?= $DEPARTURETIME_ACTUAL_2HUR_P3 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_actual_2hur_p3" name="txt_location_actual_2hur_p3" value="<?= $result_seData['LOCATION_ACTUAL_2HUR_P3'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <label ></label>
                                                </div>
                                                <div class = "row">
                                                    <form class="form-inline">
                                                        <div class="form-group">
                                                            <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                            <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                            <div class="col-lg-4">
                                                                <label ><br><br></label>
                                                                <button type="button" style="height:70px;" class="btn btn-primary btn-lg" onclick ="confirmdatap3('<?=$checkClient?>');">กดยืนยันข้อมูล(ช่วงที่3)</button>   
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label ><u>ผู้ยืนยันข้อมูล</u></label><br>
                                                                <input disabled="" class="form-control" type="text" style="height:40px; width:240px" id="txt_confirm_p3" name="txt_confirm_p3" value="<?= $result_seData['CONFIRMEDBY_P3'] ?>" min="" max=""  autocomplete="off">
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label ><u>เวลายืนยันข้อมูล</u></label><br>
                                                                <input disabled="" class="form-control" type="text"  style="height:40px;width:240px" id="txt_dateconfirm_p3" name="txt_dateconfirm_p3" value="<?= substr($result_seData['CONFIRMEDDATE_P3'],0,16) ?>" min="" max=""  autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </form>
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
                                <div class="col-lg-6" >
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color: #f0c402;">
                                            <label><font style="font-size: 16px;">แผนขาไป (ช่วงที่4)</font></label>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                <div class="col-lg-6">
                                                    <label style="font-size: 16px;">ชื่อผู้ขับ:</label>
                                                    <select   id="txt_drivernameplan_p4" name="txt_drivernameplan_p4" class="selectpicker form-control" value="" data-container="body" data-live-search="true" title="" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                        <option hidden value="<?= $result_seData['DRIVERNAME_PLAN_P4'] ?>"><?= $result_seData['DRIVERNAME_PLAN_P4'] ?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME1'] ?>"><?= $result_seData['EMPLOYEENAME1'] ?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME2'] ?>"><?= $result_seData['EMPLOYEENAME2'] ?></option>
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
                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_datestartplan_p4" name="txt_datestartplan_p4" value="<?= $result_seData['DATESTART_PLAN_P4'] ?>" min="" max=""  autocomplete="off">
                                                    <?php
                                                    }else { //สำหรับ PC DESKTOP

                                                        $DATESTART_PLAN_P4CHK = str_replace("T"," ",$result_seData['DATESTART_PLAN_P4']);
                                                        $DATESTART_PLAN_P4 = str_replace("-","/",$DATESTART_PLAN_P4CHK);
                                                    ?> 
                                                        <br>
                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_datestartplan_p4" name="txt_datestartplan_p4"  value="<?= $DATESTART_PLAN_P4 ?>" min="" max="" autocomplete="off">
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_4hur_p4" name="txt_parkingtime_plan_4hur_p4" value="<?= $result_seData['PARKINGTIME_PLAN_4HUR_P4'] ?>" min="" max=""  onchange ="parkingtime_plan_4hrs_p4('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_PLAN_4HUR_P4CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_4HUR_P4']);
                                                                        $PARKINGTIME_PLAN_4HUR_P4 = str_replace("-","/",$PARKINGTIME_PLAN_4HUR_P4CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_4hur_p4" name="txt_parkingtime_plan_4hur_p4"  value="<?= $PARKINGTIME_PLAN_4HUR_P4 ?>" min="" max="" onchange ="parkingtime_plan_4hrs_p4('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p4" name="txt_departuretime_plan_4hur_p4" value="<?= $result_seData['DEPARTURETIME_PLAN_4HUR_P4'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_PLAN_4HUR_P4CHK = str_replace("T"," ", $result_seData['DEPARTURETIME_PLAN_4HUR_P4']);
                                                                        $DEPARTURETIME_PLAN_4HUR_P4 = str_replace("-","/",$DEPARTURETIME_PLAN_4HUR_P4CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p4" name="txt_departuretime_plan_4hur_p4" value="<?= $DEPARTURETIME_PLAN_4HUR_P4 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_plan_4hur_p4" name="txt_location_plan_4hur_p4" value="<?= $result_seData['LOCATION_PLAN_4HUR_P4'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_2hur_p4" name="txt_parkingtime_plan_2hur_p4" value="<?= $result_seData['PARKINGTIME_PLAN_2HUR_P4'] ?>" min="" max=""  onchange ="parkingtime_plan_2hrs_p4('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_PLAN_2HUR_P4CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_2HUR_P4']);
                                                                        $PARKINGTIME_PLAN_2HUR_P4 = str_replace("-","/",$PARKINGTIME_PLAN_2HUR_P4CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_2hur_p4" name="txt_parkingtime_plan_2hur_p4"  value="<?= $PARKINGTIME_PLAN_2HUR_P4 ?>" min="" max="" onchange ="parkingtime_plan_2hrs_p4('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p4" name="txt_departuretime_plan_2hur_p4" value="<?= $result_seData['DEPARTURETIME_PLAN_2HUR_P4'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_PLAN_2HUR_P4CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_2HUR_P4']);
                                                                        $DEPARTURETIME_PLAN_2HUR_P4 = str_replace("-","/",$DEPARTURETIME_PLAN_2HUR_P4CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p4" name="txt_departuretime_plan_2hur_p4" value="<?= $DEPARTURETIME_PLAN_2HUR_P4 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_plan_2hur_p4" name="txt_location_plan_2hur_p4" value="<?= $result_seData['LOCATION_PLAN_2HUR_P4'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <label ></label>
                                                </div>
                                                <div class = "row">
                                                    <label ></label>
                                                </div>
                                                <div class = "row" style="height:90px;">
                                                    <label ></label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>                                   
                                <!-- END COLUNM7 -->

                                <!-- START COLUNM8 -->
                                <div class="col-lg-6" >
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color: #02c719;">
                                            <label><font style="font-size: 16px;">วิ่งจริงขาไป (ช่วงที่4)</font></label>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                <div class="col-lg-6">
                                                    <label style="font-size: 16px;">ชื่อผู้ขับ:</label>
                                                    <select   id="txt_drivernameactual_p4" name="txt_drivernameactual_p4" class="selectpicker form-control" data-container="body" data-live-search="true" title="" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                        <option hidden value="<?=$result_seData['DRIVERNAME_ACTUAL_P4']?>"><?=$result_seData['DRIVERNAME_ACTUAL_P4']?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME1'] ?>"><?= $result_seData['EMPLOYEENAME1'] ?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME2'] ?>"><?= $result_seData['EMPLOYEENAME2'] ?></option>
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
                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_datestartactual_p4" name="txt_datestartactual_p4" value="<?= $result_seData['DATESTART_ACTUAL_P4'] ?>" min="" max=""  autocomplete="off">
                                                    <?php
                                                    }else { //สำหรับ PC DESKTOP

                                                        $DATESTART_ACTUAL_P4CHK = str_replace("T"," ",$result_seData['DATESTART_ACTUAL_P4']);
                                                        $DATESTART_ACTUAL_P4 = str_replace("-","/",$DATESTART_ACTUAL_P4CHK);
                                                    ?> 
                                                        <br>
                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_datestartactual_p4" name="txt_datestartactual_p4"  value="<?= $DATESTART_ACTUAL_P4 ?>" min="" max="" autocomplete="off">
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_actual_4hur_p4" name="txt_parkingtime_actual_4hur_p4" value="<?= $result_seData['PARKINGTIME_ACTUAL_4HUR_P4'] ?>" min="" max=""  onchange ="parkingtime_actual_4hrs_p4('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_ACTUAL_4HUR_P4CHK = str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_4HUR_P4']);
                                                                        $PARKINGTIME_ACTUAL_4HUR_P4 = str_replace("-","/",$PARKINGTIME_ACTUAL_4HUR_P4CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_actual_4hur_p4" name="txt_parkingtime_actual_4hur_p4"  value="<?= $PARKINGTIME_ACTUAL_4HUR_P4 ?>" min="" max="" onchange ="parkingtime_actual_4hrs_p4('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_actual_4hur_p4" name="txt_departuretime_actual_4hur_p4" value="<?= $result_seData['DEPARTURETIME_ACTUAL_4HUR_P4'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_ACTUAL_4HUR_P4CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_4HUR_P4']);
                                                                        $DEPARTURETIME_ACTUAL_4HUR_P4 = str_replace("-","/",$DEPARTURETIME_ACTUAL_4HUR_P4CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_actual_4hur_p4" name="txt_departuretime_actual_4hur_p4" value="<?= $DEPARTURETIME_ACTUAL_4HUR_P4 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_actual_4hur_p4" name="txt_location_actual_4hur_p4" value="<?= $result_seData['LOCATION_ACTUAL_4HUR_P4'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_actual_2hur_p4" name="txt_parkingtime_actual_2hur_p4" value="<?= $result_seData['PARKINGTIME_ACTUAL_2HUR_P4'] ?>" min="" max=""  onchange ="parkingtime_actual_2hrs_p4('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_ACTUAL_2HUR_P4CHK = str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_2HUR_P4']);
                                                                        $PARKINGTIME_ACTUAL_2HUR_P4 = str_replace("-","/",$PARKINGTIME_ACTUAL_2HUR_P4CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_actual_2hur_p4" name="txt_parkingtime_actual_2hur_p4"  value="<?= $PARKINGTIME_ACTUAL_2HUR_P4 ?>" min="" max="" onchange ="parkingtime_actual_2hrs_p4('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_actual_2hur_p4" name="txt_departuretime_actual_2hur_p4" value="<?= $result_seData['DEPARTURETIME_ACTUAL_2HUR_P4'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_ACTUAL_2HUR_P4CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_2HUR_P4']);
                                                                        $DEPARTURETIME_ACTUAL_2HUR_P4 = str_replace("-","/",$DEPARTURETIME_ACTUAL_2HUR_P4CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_actual_2hur_p4" name="txt_departuretime_actual_2hur_p4" value="<?= $DEPARTURETIME_ACTUAL_2HUR_P4 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_actual_2hur_p4" name="txt_location_actual_2hur_p4" value="<?= $result_seData['LOCATION_ACTUAL_2HUR_P4'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <label ></label>
                                                </div>
                                                <div class = "row">
                                                    <form class="form-inline">
                                                        <div class="form-group">
                                                            <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                            <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                            <div class="col-lg-4">
                                                                <label ><br><br></label>
                                                                <button type="button" style="height:70px;" class="btn btn-primary btn-lg" onclick ="confirmdatap4('<?=$checkClient?>');">กดยืนยันข้อมูล(ช่วงที่4)</button>   
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label ><u>ผู้ยืนยันข้อมูล</u></label><br>
                                                                <input disabled="" class="form-control" type="text" style="height:40px; width:240px" id="txt_confirm_p4" name="txt_confirm_p4" value="<?= $result_seData['CONFIRMEDBY_P4'] ?>" min="" max=""  autocomplete="off">
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label ><u>เวลายืนยันข้อมูล</u></label><br>
                                                                <input disabled="" class="form-control" type="text"  style="height:40px;width:240px" id="txt_dateconfirm_p4" name="txt_dateconfirm_p4" value="<?= substr($result_seData['CONFIRMEDDATE_P4'],0,16) ?>" min="" max=""  autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </form>
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
                                <!-- END COLUNM8 -->
                                <div class="col-lg-6" >
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color: #f0c402;">
                                            <label><font style="font-size: 16px;">แผนขาไป (ช่วงที่5)</font></label>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                <div class="col-lg-6">
                                                    <label style="font-size: 16px;">ชื่อผู้ขับ:</label>
                                                    <select   id="txt_drivernameplan_p5" name="txt_drivernameplan_p5" class="selectpicker form-control" value="" data-container="body" data-live-search="true" title="" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                        <option hidden value="<?= $result_seData['DRIVERNAME_PLAN_P5'] ?>"><?= $result_seData['DRIVERNAME_PLAN_P5'] ?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME1'] ?>"><?= $result_seData['EMPLOYEENAME1'] ?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME2'] ?>"><?= $result_seData['EMPLOYEENAME2'] ?></option>
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
                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_datestartplan_p5" name="txt_datestartplan_p5" value="<?= $result_seData['DATESTART_PLAN_P5'] ?>" min="" max=""  autocomplete="off">
                                                    <?php
                                                    }else { //สำหรับ PC DESKTOP

                                                        $DATESTART_PLAN_P5CHK = str_replace("T"," ",$result_seData['DATESTART_PLAN_P5']);
                                                        $DATESTART_PLAN_P5 = str_replace("-","/",$DATESTART_PLAN_P5CHK);
                                                    ?> 
                                                        <br>
                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_datestartplan_p5" name="txt_datestartplan_p5"  value="<?= $DATESTART_PLAN_P5 ?>" min="" max="" autocomplete="off">
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_4hur_p5" name="txt_parkingtime_plan_4hur_p5" value="<?= $result_seData['PARKINGTIME_PLAN_4HUR_P5'] ?>" min="" max=""  onchange ="parkingtime_plan_4hrs_p5('MB');"  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_PLAN_4HUR_P5CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_4HUR_P5']);
                                                                        $PARKINGTIME_PLAN_4HUR_P5 = str_replace("-","/",$PARKINGTIME_PLAN_4HUR_P5CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_4hur_p5" name="txt_parkingtime_plan_4hur_p5"  value="<?= $PARKINGTIME_PLAN_4HUR_P5 ?>" min="" max="" onchange ="parkingtime_plan_4hrs_p5('DT');"  autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p5" name="txt_departuretime_plan_4hur_p5" value="<?= $result_seData['DEPARTURETIME_PLAN_4HUR_P5'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_PLAN_4HUR_P5CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_4HUR_P5']);
                                                                        $DEPARTURETIME_PLAN_4HUR_P5 = str_replace("-","/",$DEPARTURETIME_PLAN_4HUR_P5CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p5" name="txt_departuretime_plan_4hur_p5" value="<?= $DEPARTURETIME_PLAN_4HUR_P5 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_plan_4hur_p5" name="txt_location_plan_4hur_p5" value="<?= $result_seData['LOCATION_PLAN_4HUR_P5'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_2hur_p5" name="txt_parkingtime_plan_2hur_p5" value="<?= $result_seData['PARKINGTIME_PLAN_2HUR_P5'] ?>" min="" max=""  onchange ="parkingtime_plan_2hrs_p5('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_PLAN_2HUR_P5CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_2HUR_P5']);
                                                                        $PARKINGTIME_PLAN_2HUR_P5 = str_replace("-","/",$PARKINGTIME_PLAN_2HUR_P5CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_2hur_p5" name="txt_parkingtime_plan_2hur_p5"  value="<?= $PARKINGTIME_PLAN_2HUR_P5 ?>" min="" max="" onchange ="parkingtime_plan_2hrs_p5('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p5" name="txt_departuretime_plan_2hur_p5" value="<?= $result_seData['DEPARTURETIME_PLAN_2HUR_P5'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_PLAN_2HUR_P5CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_2HUR_P5']);
                                                                        $DEPARTURETIME_PLAN_2HUR_P5 = str_replace("-","/",$DEPARTURETIME_PLAN_2HUR_P5CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p5" name="txt_departuretime_plan_2hur_p5" value="<?= $DEPARTURETIME_PLAN_2HUR_P5 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_plan_2hur_p5" name="txt_location_plan_2hur_p5" value="<?= $result_seData['LOCATION_PLAN_2HUR_P5'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <label ></label>
                                                </div>
                                                <div class = "row">
                                                    <label ></label>
                                                </div>
                                                <div class = "row" style="height:90px;">
                                                    <label ></label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>                                    
                                <!-- START COLUNM9 -->
                                <div class="col-lg-6" >
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color: #02c719;">
                                            <label><font style="font-size: 16px;">วิ่งจริงขาไป (ช่วงที่5)</font></label>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                <div class="col-lg-6">
                                                    <label style="font-size: 16px;">ชื่อผู้ขับ:</label>
                                                    <select   id="txt_drivernameactual_p5" name="txt_drivernameactual_p5" class="selectpicker form-control" data-container="body" data-live-search="true" title="" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                        <option hidden value="<?=$result_seData['DRIVERNAME_ACTUAL_P5']?>"><?=$result_seData['DRIVERNAME_ACTUAL_P5']?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME1'] ?>"><?= $result_seData['EMPLOYEENAME1'] ?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME2'] ?>"><?= $result_seData['EMPLOYEENAME2'] ?></option>
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
                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_datestartactual_p5" name="txt_datestartactual_p5" value="<?= $result_seData['DATESTART_ACTUAL_P5'] ?>" min="" max=""  autocomplete="off">
                                                    <?php
                                                    }else { //สำหรับ PC DESKTOP

                                                        $DATESTART_ACTUAL_P5CHK = str_replace("T"," ",$result_seData['DATESTART_ACTUAL_P5']);
                                                        $DATESTART_ACTUAL_P5 = str_replace("-","/",$DATESTART_ACTUAL_P5CHK);
                                                    ?> 
                                                        <br>
                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_datestartactual_p5" name="txt_datestartactual_p5"  value="<?= $DATESTART_ACTUAL_P5 ?>" min="" max="" autocomplete="off">
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_actual_4hur_p5" name="txt_parkingtime_actual_4hur_p5" value="<?= $result_seData['PARKINGTIME_ACTUAL_4HUR_P5'] ?>" min="" max=""  onchange ="parkingtime_actual_4hrs_p5('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_ACTUAL_4HUR_P5CHK = str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_4HUR_P5']);
                                                                        $PARKINGTIME_ACTUAL_4HUR_P5 = str_replace("-","/",$PARKINGTIME_ACTUAL_4HUR_P5CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_actual_4hur_p5" name="txt_parkingtime_actual_4hur_p5"  value="<?= $PARKINGTIME_ACTUAL_4HUR_P5 ?>" min="" max="" onchange ="parkingtime_actual_4hrs_p5('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_actual_4hur_p5" name="txt_departuretime_actual_4hur_p5" value="<?= $result_seData['DEPARTURETIME_ACTUAL_4HUR_P5'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_ACTUAL_4HUR_P5CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_4HUR_P5']);
                                                                        $DEPARTURETIME_ACTUAL_4HUR_P5 = str_replace("-","/",$DEPARTURETIME_ACTUAL_4HUR_P5CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_actual_4hur_p5" name="txt_departuretime_actual_4hur_p5" value="<?= $DEPARTURETIME_ACTUAL_4HUR_P5 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_actual_4hur_p5" name="txt_location_actual_4hur_p5" value="<?= $result_seData['LOCATION_ACTUAL_4HUR_P5'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_actual_2hur_p5" name="txt_parkingtime_actual_2hur_p5" value="<?= $result_seData['PARKINGTIME_ACTUAL_2HUR_P5'] ?>" min="" max=""  onchange ="parkingtime_actual_2hrs_p5('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_ACTUAL_2HUR_P5CHK = str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_2HUR_P5']);
                                                                        $PARKINGTIME_ACTUAL_2HUR_P5 = str_replace("-","/",$PARKINGTIME_ACTUAL_2HUR_P5CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_actual_2hur_p5" name="txt_parkingtime_actual_2hur_p5"  value="<?= $PARKINGTIME_ACTUAL_2HUR_P5 ?>" min="" max="" onchange ="parkingtime_actual_2hrs_p5('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_actual_2hur_p5" name="txt_departuretime_actual_2hur_p5" value="<?= $result_seData['DEPARTURETIME_ACTUAL_2HUR_P5'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_ACTUAL_2HUR_P5CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_2HUR_P5']);
                                                                        $DEPARTURETIME_ACTUAL_2HUR_P5 = str_replace("-","/",$DEPARTURETIME_ACTUAL_2HUR_P5CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_actual_2hur_p5" name="txt_departuretime_actual_2hur_p5" value="<?= $DEPARTURETIME_ACTUAL_2HUR_P5 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_actual_2hur_p5" name="txt_location_actual_2hur_p5" value="<?= $result_seData['LOCATION_ACTUAL_2HUR_P5'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <label ></label>
                                                </div>
                                                <div class = "row">
                                                    <form class="form-inline">
                                                        <div class="form-group">
                                                            <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                            <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                            <div class="col-lg-4">
                                                                <label ><br><br></label>
                                                                <button type="button" style="height:70px;" class="btn btn-primary btn-lg" onclick ="confirmdatap5('<?=$checkClient?>');">กดยืนยันข้อมูล(ช่วงที่5)</button>   
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label ><u>ผู้ยืนยันข้อมูล</u></label><br>
                                                                <input disabled="" class="form-control" type="text" style="height:40px; width:240px" id="txt_confirm_p5" name="txt_confirm_p5" value="<?= $result_seData['CONFIRMEDBY_P5'] ?>" min="" max=""  autocomplete="off">
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label ><u>เวลายืนยันข้อมูล</u></label><br>
                                                                <input disabled="" class="form-control" type="text"  style="height:40px;width:240px" id="txt_dateconfirm_p5" name="txt_dateconfirm_p5" value="<?= substr($result_seData['CONFIRMEDDATE_P5'],0,16) ?>" min="" max=""  autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </form>
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
                                <!-- END COLUNM9 -->

                                <!-- START COLUNM10 -->
                                <div class="col-lg-6" >
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color: #f0c402;">
                                            <label><font style="font-size: 16px;">แผนขาไป (ช่วงที่6)</font></label>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                <div class="col-lg-6">
                                                    <label style="font-size: 16px;">ชื่อผู้ขับ:</label>
                                                    <select   id="txt_drivernameplan_p6" name="txt_drivernameplan_p6" class="selectpicker form-control" value="" data-container="body" data-live-search="true" title="" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                        <option hidden value="<?= $result_seData['DRIVERNAME_PLAN_P6'] ?>"><?= $result_seData['DRIVERNAME_PLAN_P6'] ?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME1'] ?>"><?= $result_seData['EMPLOYEENAME1'] ?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME2'] ?>"><?= $result_seData['EMPLOYEENAME2'] ?></option>
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
                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_datestartplan_p6" name="txt_datestartplan_p6" value="<?= $result_seData['DATESTART_PLAN_P6'] ?>" min="" max=""  autocomplete="off">
                                                    <?php
                                                    }else { //สำหรับ PC DESKTOP

                                                        $DATESTART_PLAN_P6CHK = str_replace("T"," ",$result_seData['DATESTART_PLAN_P6']);
                                                        $DATESTART_PLAN_P6 = str_replace("-","/",$DATESTART_PLAN_P6CHK);
                                                    ?> 
                                                        <br>
                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_datestartplan_p6" name="txt_datestartplan_p6"  value="<?= $DATESTART_PLAN_P6 ?>" min="" max="" autocomplete="off">
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_4hur_p6" name="txt_parkingtime_plan_4hur_p6" value="<?= $result_seData['PARKINGTIME_PLAN_4HUR_P6'] ?>" min="" max=""  onchange ="parkingtime_plan_4hrs_p6('MB');" autocomplete="off"> autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_PLAN_4HUR_P6CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_4HUR_P6']);
                                                                        $PARKINGTIME_PLAN_4HUR_P6 = str_replace("-","/",$PARKINGTIME_PLAN_4HUR_P6CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_4hur_p6" name="txt_parkingtime_plan_4hur_p6"  value="<?= $PARKINGTIME_PLAN_4HUR_P6 ?>" min="" max="" onchange ="parkingtime_plan_4hrs_p6('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p6" name="txt_departuretime_plan_4hur_p6" value="<?= $result_seData['DEPARTURETIME_PLAN_4HUR_P6'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_PLAN_4HUR_P6CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_4HUR_P6']);
                                                                        $DEPARTURETIME_PLAN_4HUR_P6 = str_replace("-","/",$DEPARTURETIME_PLAN_4HUR_P6CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_4hur_p6" name="txt_departuretime_plan_4hur_p6" value="<?= $DEPARTURETIME_PLAN_4HUR_P6 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_plan_4hur_p6" name="txt_location_plan_4hur_p6" value="<?= $result_seData['LOCATION_PLAN_4HUR_P6'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_plan_2hur_p6" name="txt_parkingtime_plan_2hur_p6" value="<?= $result_seData['PARKINGTIME_PLAN_2HUR_P6'] ?>" min="" max=""  onchange ="parkingtime_plan_2hrs_p6('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_PLAN_2HUR_P6CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_2HUR_P6']);
                                                                        $PARKINGTIME_PLAN_2HUR_P6 = str_replace("-","/",$PARKINGTIME_PLAN_2HUR_P6CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_plan_2hur_p6" name="txt_parkingtime_plan_2hur_p6"  value="<?= $PARKINGTIME_PLAN_2HUR_P6 ?>" min="" max="" onchange ="parkingtime_plan_2hrs_p6('DT');"  autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p6" name="txt_departuretime_plan_2hur_p6" value="<?= $result_seData['DEPARTURETIME_PLAN_2HUR_P6'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_PLAN_2HUR_P6CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_2HUR_P6']);
                                                                        $DEPARTURETIME_PLAN_2HUR_P6 = str_replace("-","/",$DEPARTURETIME_PLAN_2HUR_P6CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_plan_2hur_p6" name="txt_departuretime_plan_2hur_p6" value="<?= $DEPARTURETIME_PLAN_2HUR_P6 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_plan_2hur_p6" name="txt_location_plan_2hur_p6" value="<?= $result_seData['LOCATION_PLAN_2HUR_P6'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <label ></label>
                                                </div>
                                                <div class = "row">
                                                    <label ></label>
                                                </div>
                                                <div class = "row" style="height:90px;">
                                                    <label ></label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>                                   
                                <!-- END COLUNM10 -->

                                <!-- START COLUNM11 -->
                                <div class="col-lg-6" >
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color: #02c719;">
                                            <label><font style="font-size: 16px;">วิ่งจริงขาไป (ช่วงที่6)</font></label>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                <div class="col-lg-6">
                                                    <label style="font-size: 16px;">ชื่อผู้ขับ:</label>
                                                    <select   id="txt_drivernameactual_p6" name="txt_drivernameactual_p6" class="selectpicker form-control" data-container="body" data-live-search="true" title="" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                        <option hidden value="<?=$result_seData['DRIVERNAME_ACTUAL_P6']?>"><?=$result_seData['DRIVERNAME_ACTUAL_P6']?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME1'] ?>"><?= $result_seData['EMPLOYEENAME1'] ?></option>
                                                        <option value="<?= $result_seData['EMPLOYEENAME2'] ?>"><?= $result_seData['EMPLOYEENAME2'] ?></option>
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
                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_datestartactual_p6" name="txt_datestartactual_p6" value="<?= $result_seData['DATESTART_ACTUAL_P6'] ?>" min="" max=""  autocomplete="off">
                                                    <?php
                                                    }else { //สำหรับ PC DESKTOP

                                                        $DATESTART_ACTUAL_P6CHK = str_replace("T"," ",$result_seData['DATESTART_ACTUAL_P6']);
                                                        $DATESTART_ACTUAL_P6 = str_replace("-","/",$DATESTART_ACTUAL_P6CHK);
                                                    ?> 
                                                        <br>
                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_datestartactual_p6" name="txt_datestartactual_p6"  value="<?= $DATESTART_ACTUAL_P6 ?>" min="" max="" autocomplete="off">
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_actual_4hur_p6" name="txt_parkingtime_actual_4hur_p6" value="<?= $result_seData['PARKINGTIME_ACTUAL_4HUR_P6'] ?>" min="" max=""  onchange ="parkingtime_actual_4hrs_p6('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_ACTUAL_4HUR_P6CHK = str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_4HUR_P6']);
                                                                        $PARKINGTIME_ACTUAL_4HUR_P6 = str_replace("-","/",$PARKINGTIME_ACTUAL_4HUR_P6CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_actual_4hur_p6" name="txt_parkingtime_actual_4hur_p6"  value="<?= $PARKINGTIME_ACTUAL_4HUR_P6 ?>" min="" max="" onchange ="parkingtime_actual_4hrs_p6('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_actual_4hur_p6" name="txt_departuretime_actual_4hur_p6" value="<?= $result_seData['DEPARTURETIME_ACTUAL_4HUR_P6'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_ACTUAL_4HUR_P6CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_4HUR_P6']);
                                                                        $DEPARTURETIME_ACTUAL_4HUR_P6 = str_replace("-","/",$DEPARTURETIME_ACTUAL_4HUR_P6CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_actual_4hur_p6" name="txt_departuretime_actual_4hur_p6" value="<?= $DEPARTURETIME_ACTUAL_4HUR_P6 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_actual_4hur_p6" name="txt_location_actual_4hur_p6" value="<?= $result_seData['LOCATION_ACTUAL_4HUR_P6'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
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
                                                                <div class="col-lg-4">
                                                                <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtime_actual_2hur_p6" name="txt_parkingtime_actual_2hur_p6" value="<?= $result_seData['PARKINGTIME_ACTUAL_2HUR_P6'] ?>" min="" max=""  onchange ="parkingtime_actual_2hrs_p6('MB');" autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP

                                                                        $PARKINGTIME_ACTUAL_2HUR_P6CHK = str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_2HUR_P6']);
                                                                        $PARKINGTIME_ACTUAL_2HUR_P6 = str_replace("-","/",$PARKINGTIME_ACTUAL_2HUR_P6CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาจอด</u></label><br>
                                                                        <input class="form-control dateen"   style="height:40px; width:240px;"  id="txt_parkingtime_actual_2hur_p6" name="txt_parkingtime_actual_2hur_p6"  value="<?= $PARKINGTIME_ACTUAL_2HUR_P6 ?>" min="" max="" onchange ="parkingtime_actual_2hrs_p6('DT');" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <?php
                                                                    if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                    ?>
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretime_actual_2hur_p6" name="txt_departuretime_actual_2hur_p6" value="<?= $result_seData['DEPARTURETIME_ACTUAL_2HUR_P6'] ?>" min="" max=""  autocomplete="off">
                                                                    <?php
                                                                    }else { //สำหรับ PC DESKTOP
                                                                        // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                        $DEPARTURETIME_ACTUAL_2HUR_P6CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_2HUR_P6']);
                                                                        $DEPARTURETIME_ACTUAL_2HUR_P6 = str_replace("-","/",$DEPARTURETIME_ACTUAL_2HUR_P6CHK);
                                                                    ?> 
                                                                        <label ><u>เวลาออก</u></label><br>
                                                                        <input class="form-control dateen" style="height:40px; width:240px" id="txt_departuretime_actual_2hur_p6" name="txt_departuretime_actual_2hur_p6" value="<?= $DEPARTURETIME_ACTUAL_2HUR_P6 ?>" min="" max="" autocomplete="off">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label ><u>สถานที่</u></label><br>
                                                                    <input class="form-control" type="text"  style="height:40px; width:240px" id="txt_location_actual_2hur_p6" name="txt_location_actual_2hur_p6" value="<?= $result_seData['LOCATION_ACTUAL_2HUR_P6'] ?>" min="" max=""  autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <label ></label>
                                                </div>
                                                <div class = "row">
                                                    <form class="form-inline">
                                                        <div class="form-group">
                                                            <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                            <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                            <div class="col-lg-4">
                                                                <label ><br><br></label>
                                                                <button type="button" style="height:70px;" class="btn btn-primary btn-lg" onclick ="confirmdatap6('<?=$checkClient?>');">กดยืนยันข้อมูล(ช่วงที่6)</button>   
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label ><u>ผู้ยืนยันข้อมูล</u></label><br>
                                                                <input disabled="" class="form-control" type="text" style="height:40px; width:240px" id="txt_confirm_p6" name="txt_confirm_p6" value="<?= $result_seData['CONFIRMEDBY_P6'] ?>" min="" max=""  autocomplete="off">
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label ><u>เวลายืนยันข้อมูล</u></label><br>
                                                                <input disabled="" class="form-control" type="text"  style="height:40px;width:240px" id="txt_dateconfirm_p6" name="txt_dateconfirm_p6" value="<?= substr($result_seData['CONFIRMEDDATE_P6'],0,16) ?>" min="" max=""  autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </form>
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
                                <!-- END COLUNM11 -->


                                <!-- START COLUNM7 -->
                                <div class="col-lg-6" >
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color: #f0c402;">
                                            <label><font style="font-size: 16px;">โหลดรถลง(แผนขาไป)</font></label>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                <div class = "row">
                                                    <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 100%;text-align: center;background-color: #e7e7e7" >ดีเลอร์ 1</th>
                                                            </tr>
                                                        </thead>
                                                    </table>  
                                                </div>
                                                <div class = "row">
                                                    <div class="form-group">
                                                        <div class="col-lg-6">
                                                            <label ><u>สถานที่</u></label><br>
                                                            <input class="form-control" type="text"  style="height:35px; width:360px" id="txt_dealer1plan" name="txt_dealer1plan" value="<?= $result_seData['DEALER1_PLAN'] ?>" min="" max=""  autocomplete="off">
                                                        </div>
                                                       
                                                        <div class="col-lg-6">
                                                            <label ><u>รวมเวลา</u></label><br>
                                                            <input disabled="" class="form-control" type="text"  style="" id="txt_sumtimedealer1plan" name="txt_sumtimedealer1plan" value="<?= $result_seData['SUM_PLAN_DEALER1'] ?>" min="" max=""  autocomplete="off">
                                                        </div>  
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class="">
                                                        <div class="form-group">
                                                            <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                            <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                            <div class="col-lg-6">
                                                            <?php
                                                                if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                ?>
                                                                    <label ><u>เวลาจอด</u></label><br>
                                                                    <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtimedealer1plan" name="txt_parkingtimedealer1plan" value="<?= $result_seData['PARKINGTIME_PLAN_DEALER1'] ?>" min="" max=""  autocomplete="off">
                                                                <?php
                                                                }else { //สำหรับ PC DESKTOP

                                                                    $PARKINGTIME_PLAN_DEALER1CHK  = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_DEALER1']);
                                                                    $PARKINGTIME_PLAN_DEALER1 = str_replace("-","/",$PARKINGTIME_PLAN_DEALER1CHK);
                                                                ?> 
                                                                    <label ><u>เวลาจอด</u></label><br>
                                                                    <input class="form-control dateen"   style=""  id="txt_parkingtimedealer1plan" name="txt_parkingtimedealer1plan"  value="<?= $PARKINGTIME_PLAN_DEALER1 ?>" min="" max="" autocomplete="off">
                                                                <?php
                                                                }
                                                                ?>
                                                                
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <?php
                                                                if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                ?>
                                                                    <label ><u>เวลาออก</u></label><br>
                                                                    <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretimedealer1plan" name="txt_departuretimedealer1plan" value="<?= $result_seData['DEPARTURETIME_PLAN_DEALER1'] ?>" min="" max=""  autocomplete="off">
                                                                <?php
                                                                }else { //สำหรับ PC DESKTOP
                                                                    // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                    $DEPARTURETIME_PLAN_DEALER1CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_DEALER1']);
                                                                    $DEPARTURETIME_PLAN_DEALER1 = str_replace("-","/",$DEPARTURETIME_PLAN_DEALER1CHK);
                                                                ?> 
                                                                    <label ><u>เวลาออก</u></label><br>
                                                                    <input class="form-control dateen" style="" id="txt_departuretimedealer1plan" name="txt_departuretimedealer1plan" value="<?= $DEPARTURETIME_PLAN_DEALER1 ?>" min="" max="" autocomplete="off">
                                                                <?php
                                                                }
                                                                ?>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <br>
                                                    <div class="col-lg-4">
                                                        <button type="button" style="" class="btn btn-primary btn-lg" onclick ="timedealer1plancheck('<?=$checkClient?>');">กดคำนวณระยะเวลาการจอดรถ</button>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <p style="color:red">*กดปุ่มคำนวณทุกครั้งที่มีการแก้ไขเวลา เพื่อคำนวณชั่วโมงการจอดรถ</p>
                                                    </div>
                                                </div>
                                                <!-- /////////////////////////////////////////////////////////////////////////////// -->
                                                <br>
                                                <div class = "row">
                                                    <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 100%;text-align: center;background-color: #e7e7e7" >ดีเลอร์ 2</th>
                                                            </tr>
                                                        </thead>
                                                    </table>  
                                                </div>
                                                <div class = "row">
                                                    <div class="form-group">
                                                        <div class="col-lg-6">
                                                            <label ><u>สถานที่</u></label><br>
                                                            <input class="form-control" type="text"  style="height:35px; width:360px" id="txt_dealer2plan" name="txt_dealer2plan" value="<?= $result_seData['DEALER2_PLAN'] ?>" min="" max=""  autocomplete="off">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label ><u>รวมเวลา</u></label><br>
                                                            <input disabled="" class="form-control" type="text"  style="" id="txt_sumtimedealer2plan" name="txt_sumtimedealer2plan" value="<?= $result_seData['SUM_PLAN_DEALER2'] ?>" min="" max=""  autocomplete="off">
                                                        </div>  
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class="">
                                                        <div class="form-group">
                                                            <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                            <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                            <div class="col-lg-6">
                                                            <?php
                                                                if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                ?>
                                                                    <label ><u>เวลาจอด</u></label><br>
                                                                    <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtimedealer2plan" name="txt_parkingtimedealer2plan" value="<?= $result_seData['PARKINGTIME_PLAN_DEALER2'] ?>" min="" max=""  autocomplete="off">
                                                                <?php
                                                                }else { //สำหรับ PC DESKTOP

                                                                    $PARKINGTIME_PLAN_DEALER2CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_DEALER2']);
                                                                    $PARKINGTIME_PLAN_DEALER2 = str_replace("-","/",$PARKINGTIME_PLAN_DEALER2CHK);
                                                                ?> 
                                                                    <label ><u>เวลาจอด</u></label><br>
                                                                    <input class="form-control dateen"   style=""  id="txt_parkingtimedealer2plan" name="txt_parkingtimedealer2plan"  value="<?= $PARKINGTIME_PLAN_DEALER2 ?>" min="" max="" autocomplete="off">
                                                                <?php
                                                                }
                                                                ?>
                                                                
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <?php
                                                                if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                ?>
                                                                    <label ><u>เวลาออก</u></label><br>
                                                                    <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretimedealer2plan" name="txt_departuretimedealer2plan" value="<?= $result_seData['DEPARTURETIME_PLAN_DEALER2'] ?>" min="" max=""  autocomplete="off">
                                                                <?php
                                                                }else { //สำหรับ PC DESKTOP
                                                                    // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                    $DEPARTURETIME_PLAN_DEALER2CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_DEALER2']);
                                                                    $DEPARTURETIME_PLAN_DEALER2 = str_replace("-","/",$DEPARTURETIME_PLAN_DEALER2CHK);
                                                                ?> 
                                                                    <label ><u>เวลาออก</u></label><br>
                                                                    <input class="form-control dateen" style="" id="txt_departuretimedealer2plan" name="txt_departuretimedealer2plan" value="<?= $DEPARTURETIME_PLAN_DEALER2 ?>" min="" max="" autocomplete="off">
                                                                <?php
                                                                }
                                                                ?>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <br>
                                                    <div class="col-lg-4">
                                                        <button type="button" style="" class="btn btn-primary btn-lg" onclick ="timedealer2plancheck('<?=$checkClient?>');">กดคำนวณระยะเวลาการจอดรถ</button>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <p style="color:red">*กดปุ่มคำนวณทุกครั้งที่มีการแก้ไขเวลา เพื่อคำนวณชั่วโมงการจอดรถ</p>
                                                    </div>
                                                </div>
                                                <!-- /////////////////////////////////////////////////////////////////////////////// -->
                                                <br>
                                                <div class = "row">
                                                    <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 100%;text-align: center;background-color: #e7e7e7" >ดีเลอร์ 3</th>
                                                            </tr>
                                                        </thead>
                                                    </table>  
                                                </div>
                                                <div class = "row">
                                                    <div class="form-group">
                                                        <div class="col-lg-6">
                                                            <label ><u>สถานที่</u></label><br>
                                                            <input class="form-control" type="text"  style="height:35px; width:360px" id="txt_dealer3plan" name="txt_dealer3plan" value="<?= $result_seData['DEALER3_PLAN'] ?>" min="" max=""  autocomplete="off">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label ><u>รวมเวลา</u></label><br>
                                                            <input disabled="" class="form-control" type="text"  style="" id="txt_sumtimedealer3plan" name="txt_sumtimedealer3plan" value="<?= $result_seData['SUM_PLAN_DEALER3'] ?>" min="" max=""  autocomplete="off">
                                                        </div>  
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class="">
                                                        <div class="form-group">
                                                            <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                            <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                            <div class="col-lg-6">
                                                            <?php
                                                                if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                ?>
                                                                    <label ><u>เวลาจอด</u></label><br>
                                                                    <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtimedealer3plan" name="txt_parkingtimedealer3plan" value="<?= $result_seData['PARKINGTIME_PLAN_DEALER3'] ?>" min="" max=""  autocomplete="off">
                                                                <?php
                                                                }else { //สำหรับ PC DESKTOP

                                                                    $PARKINGTIME_PLAN_DEALER3CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_DEALER3']);
                                                                    $PARKINGTIME_PLAN_DEALER3 = str_replace("-","/",$PARKINGTIME_PLAN_DEALER3CHK);
                                                                ?> 
                                                                    <label ><u>เวลาจอด</u></label><br>
                                                                    <input class="form-control dateen"   style=""  id="txt_parkingtimedealer3plan" name="txt_parkingtimedealer3plan"  value="<?= $PARKINGTIME_PLAN_DEALER3 ?>" min="" max="" autocomplete="off">
                                                                <?php
                                                                }
                                                                ?>
                                                                
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <?php
                                                                if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                ?>
                                                                    <label ><u>เวลาออก</u></label><br>
                                                                    <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretimedealer3plan" name="txt_departuretimedealer3plan" value="<?= $result_seData['DEPARTURETIME_PLAN_DEALER3'] ?>" min="" max=""  autocomplete="off">
                                                                <?php
                                                                }else { //สำหรับ PC DESKTOP
                                                                    // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                    $DEPARTURETIME_PLAN_DEALER3CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_DEALER3']);
                                                                    $DEPARTURETIME_PLAN_DEALER3 = str_replace("-","/",$DEPARTURETIME_PLAN_DEALER3CHK);
                                                                ?> 
                                                                    <label ><u>เวลาออก</u></label><br>
                                                                    <input class="form-control dateen" style="" id="txt_departuretimedealer3plan" name="txt_departuretimedealer3plan" value="<?= $DEPARTURETIME_PLAN_DEALER3 ?>" min="" max="" autocomplete="off">
                                                                <?php
                                                                }
                                                                ?>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <br>
                                                    <div class="col-lg-4">
                                                        <button type="button" style="" class="btn btn-primary btn-lg" onclick ="timedealer3plancheck('<?=$checkClient?>');">กดคำนวณระยะเวลาการจอดรถ</button>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <p style="color:red">*กดปุ่มคำนวณทุกครั้งที่มีการแก้ไขเวลา เพื่อคำนวณชั่วโมงการจอดรถ</p>
                                                    </div>
                                                </div>
                                                <!-- /////////////////////////////////////////////////////////////////////////////// -->
                                                <br>
                                                <div class = "row">
                                                    <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 100%;text-align: center;background-color: #e7e7e7" >ดีเลอร์ 4</th>
                                                            </tr>
                                                        </thead>
                                                    </table>  
                                                </div>
                                                <div class = "row">
                                                    <div class="form-group">
                                                        <div class="col-lg-6">
                                                            <label ><u>สถานที่</u></label><br>
                                                            <input class="form-control" type="text"  style="height:35px; width:360px" id="txt_dealer4plan" name="txt_dealer4plan" value="<?= $result_seData['DEALER4_PLAN'] ?>" min="" max=""  autocomplete="off">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label ><u>รวมเวลา</u></label><br>
                                                            <input disabled="" class="form-control" type="text"  style="" id="txt_sumtimedealer4plan" name="txt_sumtimedealer4plan" value="<?= $result_seData['SUM_PLAN_DEALER4'] ?>" min="" max=""  autocomplete="off">
                                                        </div>  
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class="">
                                                        <div class="form-group">
                                                            <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                            <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                            <div class="col-lg-6">
                                                            <?php
                                                                if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                ?>
                                                                    <label ><u>เวลาจอด</u></label><br>
                                                                    <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtimedealer4plan" name="txt_parkingtimedealer4plan" value="<?= $result_seData['PARKINGTIME_PLAN_DEALER4'] ?>" min="" max=""  autocomplete="off">
                                                                <?php
                                                                }else { //สำหรับ PC DESKTOP

                                                                    $PARKINGTIME_PLAN_DEALER4CHK = str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_DEALER4']);
                                                                    $PARKINGTIME_PLAN_DEALER4 = str_replace("-","/",$PARKINGTIME_PLAN_DEALER4CHK);
                                                                ?> 
                                                                    <label ><u>เวลาจอด</u></label><br>
                                                                    <input class="form-control dateen"   style=""  id="txt_parkingtimedealer4plan" name="txt_parkingtimedealer4plan"  value="<?= $PARKINGTIME_PLAN_DEALER4 ?>" min="" max="" autocomplete="off">
                                                                <?php
                                                                }
                                                                ?>
                                                                
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <?php
                                                                if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                ?>
                                                                    <label ><u>เวลาออก</u></label><br>
                                                                    <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretimedealer4plan" name="txt_departuretimedealer4plan" value="<?= $result_seData['DEPARTURETIME_PLAN_DEALER4'] ?>" min="" max=""  autocomplete="off">
                                                                <?php
                                                                }else { //สำหรับ PC DESKTOP
                                                                    // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                    $DEPARTURETIME_PLAN_DEALER4CHK = str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_DEALER4']);
                                                                    $DEPARTURETIME_PLAN_DEALER4 = str_replace("-","/",$DEPARTURETIME_PLAN_DEALER4CHK);
                                                                ?> 
                                                                    <label ><u>เวลาออก</u></label><br>
                                                                    <input class="form-control dateen" style="" id="txt_departuretimedealer4plan" name="txt_departuretimedealer4plan" value="<?= $DEPARTURETIME_PLAN_DEALER4 ?>" min="" max="" autocomplete="off">
                                                                <?php
                                                                }
                                                                ?>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class = "row">
                                                    <br>
                                                    <div class="col-lg-4">
                                                        <button type="button" style="" class="btn btn-primary btn-lg" onclick ="timedealer4plancheck('<?=$checkClient?>');">กดคำนวณระยะเวลาการจอดรถ</button>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <p style="color:red">*กดปุ่มคำนวณทุกครั้งที่มีการแก้ไขเวลา เพื่อคำนวณชั่วโมงการจอดรถ</p>
                                                    </div>
                                                </div>                  
                                                <!-- /////////////////////////////////////////////////////////////////////////////// -->
                                                <div class = "row" style="height:85px;">
                                                    <label ></label>
                                                </div>                
                                            </div>
                                        </div>
                                    </div>
                                </div>   
                                <!--END COLUNM7  -->

                                <!-- START COLUNM8 -->
                                <div class="col-lg-6" >
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color: #02c719;">
                                            <label><font style="font-size: 16px;">โหลดรถลง(วิ่งจริงขาไป)</font></label>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                <div class = "row">
                                                    <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 100%;text-align: center;background-color: #e7e7e7" >ดีเลอร์ 1</th>
                                                            </tr>
                                                        </thead>
                                                    </table>  
                                                </div>
                                                <div class = "row">
                                                    <div class="form-group">
                                                        <div class="col-lg-6">
                                                            <label ><u>สถานที่</u></label><br>
                                                            <input class="form-control" type="text"  style="" id="txt_dealer1actual" name="txt_dealer1actual" value="<?= $result_seData['DEALER1_ACTUAL'] ?>" min="" max=""  autocomplete="off">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label ><u>รวมเวลา</u></label><br>
                                                            <input disabled="" class="form-control" type="text"  style="" id="txt_sumtimedealer1actual" name="txt_sumtimedealer1actual" value="<?= $result_seData['SUM_ACTUAL_DEALER1'] ?>" min="" max=""  autocomplete="off">
                                                        </div>  
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class="">
                                                        <div class="form-group">
                                                            <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                            <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                            <div class="col-lg-6">
                                                            <?php
                                                                if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                ?>
                                                                    <label ><u>เวลาจอด</u></label><br>
                                                                    <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtimedealer1actual" name="txt_parkingtimedealer1actual" value="<?= $result_seData['PARKINGTIME_ACTUAL_DEALER1'] ?>" min="" max=""  autocomplete="off">
                                                                <?php
                                                                }else { //สำหรับ PC DESKTOP

                                                                    $PARKINGTIME_ACTUAL_DEALER1CHK  = str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_DEALER1']);
                                                                    $PARKINGTIME_ACTUAL_DEALER1 = str_replace("-","/",$PARKINGTIME_ACTUAL_DEALER1CHK);
                                                                ?> 
                                                                    <label ><u>เวลาจอด</u></label><br>
                                                                    <input class="form-control dateen"   style=""  id="txt_parkingtimedealer1actual" name="txt_parkingtimedealer1actual"  value="<?= $PARKINGTIME_ACTUAL_DEALER1 ?>" min="" max="" autocomplete="off">
                                                                <?php
                                                                }
                                                                ?>
                                                                
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <?php
                                                                if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                ?>
                                                                    <label ><u>เวลาออก</u></label><br>
                                                                    <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretimedealer1actual" name="txt_departuretimedealer1actual" value="<?= $result_seData['DEPARTURETIME_ACTUAL_DEALER1'] ?>" min="" max=""  autocomplete="off">
                                                                <?php
                                                                }else { //สำหรับ PC DESKTOP
                                                                    // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                    $DEPARTURETIME_ACTUAL_DEALER1CHK  = str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_DEALER1']);
                                                                    $DEPARTURETIME_ACTUAL_DEALER1 = str_replace("-","/",$DEPARTURETIME_ACTUAL_DEALER1CHK);
                                                                ?> 
                                                                    <label ><u>เวลาออก</u></label><br>
                                                                    <input class="form-control dateen" style="" id="txt_departuretimedealer1actual" name="txt_departuretimedealer1actual" value="<?= $DEPARTURETIME_ACTUAL_DEALER1 ?>" min="" max="" autocomplete="off">
                                                                <?php
                                                                }
                                                                ?>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <br>
                                                    <div class="col-lg-4">
                                                        <button type="button" style="" class="btn btn-primary btn-lg" onclick ="timedealer1actualcheck('<?=$checkClient?>');">กดคำนวณระยะเวลาการจอดรถ</button>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <p style="color:red">*กดปุ่มคำนวณทุกครั้งที่มีการแก้ไขเวลา เพื่อคำนวณชั่วโมงการจอดรถ</p>
                                                    </div>
                                                </div>
                                                <!-- /////////////////////////////////////////////////////////////////////////////// -->
                                                <br>
                                                <div class = "row">
                                                    <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 100%;text-align: center;background-color: #e7e7e7" >ดีเลอร์ 2</th>
                                                            </tr>
                                                        </thead>
                                                    </table>  
                                                </div>
                                                <div class = "row">
                                                    <div class="form-group">
                                                        <div class="col-lg-6">
                                                            <label ><u>สถานที่</u></label><br>
                                                            <input class="form-control" type="text"  style="" id="txt_dealer2actual" name="txt_dealer2actual" value="<?= $result_seData['DEALER2_ACTUAL'] ?>" min="" max=""  autocomplete="off">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label ><u>รวมเวลา</u></label><br>
                                                            <input disabled="" class="form-control" type="text"  style="" id="txt_sumtimedealer2actual" name="txt_sumtimedealer2actual" value="<?= $result_seData['SUM_ACTUAL_DEALER2'] ?>" min="" max=""  autocomplete="off">
                                                        </div>  
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class="">
                                                        <div class="form-group">
                                                            <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                            <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                            <div class="col-lg-6">
                                                            <?php
                                                                if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                ?>
                                                                    <label ><u>เวลาจอด</u></label><br>
                                                                    <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtimedealer2actual" name="txt_parkingtimedealer2actual" value="<?= $result_seData['PARKINGTIME_ACTUAL_DEALER2'] ?>" min="" max=""  autocomplete="off">
                                                                <?php
                                                                }else { //สำหรับ PC DESKTOP

                                                                    $PARKINGTIME_ACTUAL_DEALER2CHK  = str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_DEALER2']);
                                                                    $PARKINGTIME_ACTUAL_DEALER2 = str_replace("-","/",$PARKINGTIME_ACTUAL_DEALER2CHK);
                                                                ?> 
                                                                    <label ><u>เวลาจอด</u></label><br>
                                                                    <input class="form-control dateen"   style=""  id="txt_parkingtimedealer2actual" name="txt_parkingtimedealer2actual"  value="<?= $PARKINGTIME_ACTUAL_DEALER2 ?>" min="" max="" autocomplete="off">
                                                                <?php
                                                                }
                                                                ?>
                                                                
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <?php
                                                                if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                ?>
                                                                    <label ><u>เวลาออก</u></label><br>
                                                                    <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretimedealer2actual" name="txt_departuretimedealer2actual" value="<?= $result_seData['DEPARTURETIME_ACTUAL_DEALER2'] ?>" min="" max=""  autocomplete="off">
                                                                <?php
                                                                }else { //สำหรับ PC DESKTOP
                                                                    // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                    $DEPARTURETIME_ACTUAL_DEALER2CHK  = str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_DEALER2']);
                                                                    $DEPARTURETIME_ACTUAL_DEALER2 = str_replace("-","/",$DEPARTURETIME_ACTUAL_DEALER2CHK);
                                                                ?> 
                                                                    <label ><u>เวลาออก</u></label><br>
                                                                    <input class="form-control dateen" style="" id="txt_departuretimedealer2actual" name="txt_departuretimedealer2actual" value="<?= $DEPARTURETIME_ACTUAL_DEALER2 ?>" min="" max="" autocomplete="off">
                                                                <?php
                                                                }
                                                                ?>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <br>
                                                    <div class="col-lg-4">
                                                        <button type="button" style="" class="btn btn-primary btn-lg" onclick ="timedealer2actualcheck('<?=$checkClient?>');">กดคำนวณระยะเวลาการจอดรถ</button>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <p style="color:red">*กดปุ่มคำนวณทุกครั้งที่มีการแก้ไขเวลา เพื่อคำนวณชั่วโมงการจอดรถ</p>
                                                    </div>
                                                </div>
                                                <!-- /////////////////////////////////////////////////////////////////////////////// -->
                                                <br>
                                                <div class = "row">
                                                    <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 100%;text-align: center;background-color: #e7e7e7" >ดีเลอร์ 3</th>
                                                            </tr>
                                                        </thead>
                                                    </table>  
                                                </div>
                                                <div class = "row">
                                                    <div class="form-group">
                                                        <div class="col-lg-6">
                                                            <label ><u>สถานที่</u></label><br>
                                                            <input class="form-control" type="text"  style="" id="txt_dealer3actual" name="txt_dealer3actual" value="<?= $result_seData['DEALER3_ACTUAL'] ?>" min="" max=""  autocomplete="off">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label ><u>รวมเวลา</u></label><br>
                                                            <input disabled="" class="form-control" type="text"  style="" id="txt_sumtimedealer3actual" name="txt_sumtimedealer3actual" value="<?= $result_seData['SUM_ACTUAL_DEALER3'] ?>" min="" max=""  autocomplete="off">
                                                        </div>  
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class="">
                                                        <div class="form-group">
                                                            <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                            <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                            <div class="col-lg-6">
                                                            <?php
                                                                if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                ?>
                                                                    <label ><u>เวลาจอด</u></label><br>
                                                                    <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtimedealer3actual" name="txt_parkingtimedealer3actual" value="<?= $result_seData['PARKINGTIME_ACTUAL_DEALER3'] ?>" min="" max=""  autocomplete="off">
                                                                <?php
                                                                }else { //สำหรับ PC DESKTOP

                                                                    $PARKINGTIME_ACTUAL_DEALER3CHK  = str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_DEALER3']);
                                                                    $PARKINGTIME_ACTUAL_DEALER3 = str_replace("-","/",$PARKINGTIME_ACTUAL_DEALER3CHK);
                                                                ?> 
                                                                    <label ><u>เวลาจอด</u></label><br>
                                                                    <input class="form-control dateen"   style=""  id="txt_parkingtimedealer3actual" name="txt_parkingtimedealer3actual"  value="<?= $PARKINGTIME_ACTUAL_DEALER3 ?>" min="" max="" autocomplete="off">
                                                                <?php
                                                                }
                                                                ?>
                                                                
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <?php
                                                                if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                ?>
                                                                    <label ><u>เวลาออก</u></label><br>
                                                                    <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretimedealer3actual" name="txt_departuretimedealer3actual" value="<?= $result_seData['DEPARTURETIME_ACTUAL_DEALER3'] ?>" min="" max=""  autocomplete="off">
                                                                <?php
                                                                }else { //สำหรับ PC DESKTOP
                                                                    // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                    $DEPARTURETIME_ACTUAL_DEALER3CHK  = str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_DEALER3']);
                                                                    $DEPARTURETIME_ACTUAL_DEALER3 = str_replace("-","/",$DEPARTURETIME_ACTUAL_DEALER3CHK);
                                                                ?> 
                                                                    <label ><u>เวลาออก</u></label><br>
                                                                    <input class="form-control dateen" style="" id="txt_departuretimedealer3actual" name="txt_departuretimedealer3actual" value="<?= $DEPARTURETIME_ACTUAL_DEALER3 ?>" min="" max="" autocomplete="off">
                                                                <?php
                                                                }
                                                                ?>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <br>
                                                    <div class="col-lg-4">
                                                        <button type="button" style="" class="btn btn-primary btn-lg" onclick ="timedealer3actualcheck('<?=$checkClient?>');">กดคำนวณระยะเวลาการจอดรถ</button>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <p style="color:red">*กดปุ่มคำนวณทุกครั้งที่มีการแก้ไขเวลา เพื่อคำนวณชั่วโมงการจอดรถ</p>
                                                    </div>
                                                </div>
                                                <!-- /////////////////////////////////////////////////////////////////////////////// -->
                                                <br>
                                                <div class = "row">
                                                    <table style="background-color: #e7e7e7"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 100%;text-align: center;background-color: #e7e7e7" >ดีเลอร์ 4</th>
                                                            </tr>
                                                        </thead>
                                                    </table>  
                                                </div>
                                                <div class = "row">
                                                    <div class="form-group">
                                                        <div class="col-lg-6">
                                                            <label ><u>สถานที่</u></label><br>
                                                            <input class="form-control" type="text"  style="" id="txt_dealer4actual" name="txt_dealer4actual" value="<?= $result_seData['DEALER4_ACTUAL'] ?>" min="" max=""  autocomplete="off">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label ><u>รวมเวลา</u></label><br>
                                                            <input disabled="" class="form-control" type="text"  style="" id="txt_sumtimedealer4actual" name="txt_sumtimedealer4actual" value="<?= $result_seData['SUM_ACTUAL_DEALER4'] ?>" min="" max=""  autocomplete="off">
                                                        </div>  
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class="">
                                                        <div class="form-group">
                                                            <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                            <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                            <div class="col-lg-6">
                                                            <?php
                                                                if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                ?>
                                                                    <label ><u>เวลาจอด</u></label><br>
                                                                    <input type="datetime-local"  style="height:40px; width:240px" id="txt_parkingtimedealer4actual" name="txt_parkingtimedealer4actual" value="<?= $result_seData['PARKINGTIME_ACTUAL_DEALER4'] ?>" min="" max=""  autocomplete="off">
                                                                <?php
                                                                }else { //สำหรับ PC DESKTOP

                                                                    $PARKINGTIME_ACTUAL_DEALER4CHK  = str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_DEALER4']);
                                                                    $PARKINGTIME_ACTUAL_DEALER4 = str_replace("-","/",$PARKINGTIME_ACTUAL_DEALER4CHK);
                                                                ?> 
                                                                    <label ><u>เวลาจอด</u></label><br>
                                                                    <input class="form-control dateen"   style=""  id="txt_parkingtimedealer4actual" name="txt_parkingtimedealer4actual"  value="<?= $PARKINGTIME_ACTUAL_DEALER4 ?>" min="" max="" autocomplete="off">
                                                                <?php
                                                                }
                                                                ?>
                                                                
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <?php
                                                                if ($checkClient == 'MB') { //สำหรับมือถือ
                                                                ?>
                                                                    <label ><u>เวลาออก</u></label><br>
                                                                    <input type="datetime-local" style="height:40px; width:240px" id="txt_departuretimedealer4actual" name="txt_departuretimedealer4actual" value="<?= $result_seData['DEPARTURETIME_ACTUAL_DEALER4'] ?>" min="" max=""  autocomplete="off">
                                                                <?php
                                                                }else { //สำหรับ PC DESKTOP
                                                                    // echo str_replace("T"," ",$result_seSelfCheck['SLEEPRESTEND']);
                                                                    $DEPARTURETIME_ACTUAL_DEALER4CHK  = str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_DEALER4']);
                                                                    $DEPARTURETIME_ACTUAL_DEALER4 = str_replace("-","/",$DEPARTURETIME_ACTUAL_DEALER4CHK);
                                                                ?> 
                                                                    <label ><u>เวลาออก</u></label><br>
                                                                    <input class="form-control dateen" style="" id="txt_departuretimedealer4actual" name="txt_departuretimedealer4actual" value="<?= $DEPARTURETIME_ACTUAL_DEALER4 ?>" min="" max="" autocomplete="off">
                                                                <?php
                                                                }
                                                                ?>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class = "row">
                                                    <br>
                                                    <div class="col-lg-4">
                                                        <button type="button" style="" class="btn btn-primary btn-lg" onclick ="timedealer4actualcheck('<?=$checkClient?>');">กดยืนยันระยะเวลาการจอดรถ</button>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <p style="color:red">*กดปุ่มคำนวณทุกครั้งที่มีการแก้ไขเวลา เพื่อคำนวณชั่วโมงการจอดรถ</p>
                                                    </div>
                                                </div>  
                                                <div class = "row">
                                                    <label ></label>
                                                </div>
                                                <div class = "row" style="">
                                                    <form class="form-inline">
                                                        <div class="form-group">
                                                            <!-- <label >ระยะเวลาการขับรถ 4 ชั่วโมง</label><br> -->
                                                            <!-- <input type="text" class="form-control" data-toggle="modal"  data-target="#modal_tenkosleepnormal" id="daysleep_normal" name="daysleep_normal" value= "" autocomplete="off"> -->
                                                            <div class="col-lg-4">
                                                                <label ><br><br></label>
                                                                <button type="button" style="height:70px" class="btn btn-primary btn-lg" onclick ="confirmdataactualload('<?=$checkClient?>','chkallload');">กดยืนยันข้อมูลโหลดรถลง</button>   
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label ><u>ผู้ยืนยันข้อมูล</u></label><br>
                                                                <input disabled="" class="form-control" type="text" style="height:40px; width:240px" id="txt_confirm_actualload" name="txt_confirm_actualload" value="<?= $result_seData['CONFIRMEDBY_ACTUAL_DEALER'] ?>" min="" max=""  autocomplete="off">
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label ><u>เวลายืนยันข้อมูล</u></label><br>
                                                                <input disabled="" class="form-control" type="text"  style="height:40px;width:240px" id="txt_dateconfirm_actualload" name="txt_dateconfirm_actualload" value="<?= substr($result_seData['CONFIRMEDDATE_ACTUAL_DEALER'],0,16) ?>" min="" max=""  autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>             
                                                <!-- /////////////////////////////////////////////////////////////////////////////// -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--END COLUNM8  -->
                            
                            
                            
                                <!-- type insert -->
                                <!-- START COLUNM8 -->
                                <!-- SAVE  DATEWORKING ,DATEPRESENT ลงใน DRIVERSELFCHECK-->
                                <!-- DATEWORKING ,DATEPRESENT มาจากการกดยืนยันและบันทึกข้อมูล ในหน้าการตรวจสอบของเจ้าหน้าที่ -->
                                <div class="col-lg-4" >
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color: #f0c402;">
                                            <label><font style="font-size: 16px">ยืนยันข้อมูลขาไปทั้งหมด(เจ้าหน้าที่)</font></label>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                <div class = "row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label >ผู้ยืนยันข้อมูล</label>
                                                            &nbsp;
                                                            
                                                            <input type="hidden" style="height:35px; width:200px" class="form-control" id="txt_officerconfirmhidden" name="txt_officerconfirmhidden" value= "<?= $_GET['officername'] ?>" autocomplete="off" disabled>
                                                            <input type="text"   style="height:35px; width:200px" class="form-control" id="txt_officerconfirm" name="txt_officerconfirm" value= "<?=$result_seData['CONFIRMEDBY_ACTUALGO']?>" autocomplete="off" disabled>                    
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label >ยืนยันข้อมูลล่าสุด</label>
                                                            <!-- <input type="text" style="height:35px; width:200px" class="form-control" id="txt_datetimeconfirm" name="txt_datetimeconfirm" value= "<?= substr($result_seData['CONFIRMEDDATE_ACTUALGO'],0,16) ?>" autocomplete="off" disabled>                     -->
                                                            <input disabled="" class="form-control" type="text"  style="height:35px;width:200px" id="txt_datetimeofficerconfirm" name="txt_datetimeofficerconfirm" value="<?= substr($result_seData['CONFIRMEDDATE_ACTUALGO'],0,16) ?>" min="" max=""  autocomplete="off">
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
                                                                <input type="button" style="width: 100%;height:80px;font-size: 25px;" onclick="confirm_actual_go('<?=$checkClient?>');" name="btnSend" id="btnSend" value="ยืนยันข้อมูลขาไปทั้งหมด" class="btn btn-primary">
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

         <!-- this will show our spinner -->
        <!-- <div  id="loading" class="center" >
            <p><img style="" src="../images/Truckload5.gif" /></p>
        </div>                                                         -->

        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>

        <!-- <script src="../dist/js/jszip.min.js"></script> -->
        <script src="../dist/js/bootstrap-select.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>   


        <!-- <script src="../vendor/jquery/jquery.min.js"></script> -->
        <!-- <script src="../js/jquery.datetimepicker.full.js"></script> -->
        <!-- <script src="../js/bootstrap-datepicker.min.js"></script> -->
        <!-- <script src="../js/bootstrap-datepicker.th.min.js"></script> -->
        <!-- <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script> -->
        <!-- <script type="text/javascript" src="js/jquery.form.min.js"></script> -->
        <!-- <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script> -->
        <!-- <script type="text/javascript" src="../dist/js/jquery.autocomplete.js"></script>  -->
        <!-- <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
        <script src="../dist/js/bootstrap-select.js"></script>
        <?php
        $dealer = select_dealerautocomplate('megDrivingPatternDriver', 'select_dealer', '','','','','','');
        ?>
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

        // START TIMECHECK P1
        function parkingtime_plan_4hrs_p1(checkClient){

            if (checkClient == 'MB') {
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk3  = document.getElementById('txt_parkingtime_plan_4hur_p1').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
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
                    txt_flg: "cal_parkingtime_plan_4hrs_p1",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_4hur_p1').value = rs; 
                }
            }); 

        }

        function parkingtime_plan_2hrs_p1(checkClient){

            if (checkClient == 'MB') {
                
                var pakingtimechk3  = document.getElementById('txt_parkingtime_plan_2hur_p1').value;

            }else{
            // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_2hur_p1').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);  
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_2hrs_p1",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_2hur_p1').value = rs; 
                }
            }); 

        }
        // END TIMECHECK P1
        // START TIMECHECK P2
        function parkingtime_plan_4hrs_p2(checkClient){

            if (checkClient == 'MB') {

                var pakingtimechk3  = document.getElementById('txt_parkingtime_plan_4hur_p2').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_4hur_p2').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);    
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_4hrs_p2",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_4hur_p2').value = rs; 
                }
            }); 

        }

        function parkingtime_plan_2hrs_p2(checkClient){

            if (checkClient == 'MB') {
                
                var pakingtimechk3  = document.getElementById('txt_parkingtime_plan_2hur_p2').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_2hur_p2').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);  
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_2hrs_p2",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_2hur_p2').value = rs; 
                }
            }); 

        }
        // END TIMECHECK P2
        // START TIMECHECK P3
        function parkingtime_plan_4hrs_p3(checkClient){

            if (checkClient == 'MB') {
                
                var pakingtimechk3  = document.getElementById('txt_parkingtime_plan_4hur_p3').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_4hur_p3').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);    
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_4hrs_p3",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_4hur_p3').value = rs; 
                }
            }); 

        }

        function parkingtime_plan_2hrs_p3(checkClient){

            if (checkClient == 'MB') {
                
                var pakingtimechk3   = document.getElementById('txt_parkingtime_plan_2hur_p3').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_2hur_p3').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_2hrs_p3",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_2hur_p3').value = rs; 
                }
            }); 

        }
        // END TIMECHECK P3
        // START TIMECHECK P4
        function parkingtime_plan_4hrs_p4(checkClient){

            if (checkClient == 'MB') {
                
                var pakingtimechk3  = document.getElementById('txt_parkingtime_plan_4hur_p4').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_4hur_p4').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_4hrs_p4",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_4hur_p4').value = rs; 
                }
            }); 

        }

        function parkingtime_plan_2hrs_p4(checkClient){

            if (checkClient == 'MB') {
                
                var pakingtimechk3  = document.getElementById('txt_parkingtime_plan_2hur_p4').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_2hur_p4').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_2hrs_p4",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_2hur_p4').value = rs; 
                }
            }); 

        }
        // END TIMECHECK P4
        // START TIMECHECK P5
        function parkingtime_plan_4hrs_p5(checkClient){

            if (checkClient == 'MB') {
                
                var pakingtimechk3  = document.getElementById('txt_parkingtime_plan_4hur_p5').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_4hur_p5').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_4hrs_p5",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_4hur_p5').value = rs; 
                }
            });     

        }

        function parkingtime_plan_2hrs_p5(checkClient){

            if (checkClient == 'MB') {
                
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_2hur_p5').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_2hur_p5').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);  
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_2hrs_p5",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_2hur_p5').value = rs; 
                }
            }); 

        }
        // END TIMECHECK P5
        // START TIMECHECK P6
        function parkingtime_plan_4hrs_p6(checkClient){

            if (checkClient == 'MB') {
                
                var pakingtimechk3   = document.getElementById('txt_parkingtime_plan_4hur_p6').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_4hur_p6').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_4hrs_p6",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_4hur_p6').value = rs; 
                }
            }); 

        }
        function parkingtime_plan_2hrs_p6(checkClient){

            if (checkClient == 'MB') {

                var pakingtimechk3   = document.getElementById('txt_parkingtime_plan_2hur_p6').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_plan_2hur_p6').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);    
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_plan_2hrs_p6",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_plan_2hur_p6').value = rs; 
                }
            }); 

        }
        // END TIMECHECK P6     
        
        // START TIME DEALER1 PLAN
        function timedealer1plancheck(checkClient){
            
            // var startsleepchk = document.getElementById('daysleep_reststart').value;
            // var endsleepchk = document.getElementById('daysleep_restend').value;
            // alert(startsleepchk);
            // alert(endsleepchk);
            // alert(checkClient);

            if (checkClient == 'MB') {
                var parkingtimechk   = document.getElementById('txt_parkingtimedealer1plan').value;
                var departuretimechk = document.getElementById('txt_departuretimedealer1plan').value;
            }else{
                //START REST
                var parkingtimechk0  = document.getElementById('txt_parkingtimedealer1plan').value;
                var parkingtimechk1  = parkingtimechk0.replace(" ","T"); // replave " " เป็น "T"
                var parkingtimechk2  = parkingtimechk1.replace("/","-");
                var parkingtimechk3  = parkingtimechk2.replace("/","-"); // replave "/" เป็น "-"
                var parkingtimechk   = parkingtimechk3;
                
                //END REST
                var departuretimechk0  = document.getElementById('txt_departuretimedealer1plan').value;
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
                    txt_flg: "select_timedealer", parkingtimechk: parkingtimechk, departuretimechk: departuretimechk
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
                    document.getElementById('txt_sumtimedealer1plan').value = replacetext;
                
                }
            });

        }
        // END TIMEDEALER1 PLAN

        // START TIME DEALER2 PLAN
        function timedealer2plancheck(checkClient){
            
            // var startsleepchk = document.getElementById('daysleep_reststart').value;
            // var endsleepchk = document.getElementById('daysleep_restend').value;
            // alert(startsleepchk);
            // alert(endsleepchk);
            // alert(checkClient);

            if (checkClient == 'MB') {
                var parkingtimechk   = document.getElementById('txt_parkingtimedealer2plan').value;
                var departuretimechk = document.getElementById('txt_departuretimedealer2plan').value;
            }else{
                //START REST
                var parkingtimechk0  = document.getElementById('txt_parkingtimedealer2plan').value;
                var parkingtimechk1  = parkingtimechk0.replace(" ","T"); // replave " " เป็น "T"
                var parkingtimechk2  = parkingtimechk1.replace("/","-");
                var parkingtimechk3  = parkingtimechk2.replace("/","-"); // replave "/" เป็น "-"
                var parkingtimechk   = parkingtimechk3;
                
                //END REST
                var departuretimechk0  = document.getElementById('txt_departuretimedealer2plan').value;
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
                    txt_flg: "select_timedealer", parkingtimechk: parkingtimechk, departuretimechk: departuretimechk
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
                    document.getElementById('txt_sumtimedealer2plan').value = replacetext;
                
                }
            });

        }
        // END TIMEDEALER2 PLAN

        // START TIME DEALER3 PLAN
        function timedealer3plancheck(checkClient){
            
            // var startsleepchk = document.getElementById('daysleep_reststart').value;
            // var endsleepchk = document.getElementById('daysleep_restend').value;
            // alert(startsleepchk);
            // alert(endsleepchk);
            // alert(checkClient);

            if (checkClient == 'MB') {
                var parkingtimechk   = document.getElementById('txt_parkingtimedealer3plan').value;
                var departuretimechk = document.getElementById('txt_departuretimedealer3plan').value;
            }else{
                //START REST
                var parkingtimechk0  = document.getElementById('txt_parkingtimedealer3plan').value;
                var parkingtimechk1  = parkingtimechk0.replace(" ","T"); // replave " " เป็น "T"
                var parkingtimechk2  = parkingtimechk1.replace("/","-");
                var parkingtimechk3  = parkingtimechk2.replace("/","-"); // replave "/" เป็น "-"
                var parkingtimechk   = parkingtimechk3;
                
                //END REST
                var departuretimechk0  = document.getElementById('txt_departuretimedealer3plan').value;
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
                    txt_flg: "select_timedealer", parkingtimechk: parkingtimechk, departuretimechk: departuretimechk
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
                    document.getElementById('txt_sumtimedealer3plan').value = replacetext;
                
                }
            });

        }
        // END TIMEDEALER3 PLAN
        
        // START TIME DEALER4 PLAN
        function timedealer4plancheck(checkClient){
            
            // var startsleepchk = document.getElementById('daysleep_reststart').value;
            // var endsleepchk = document.getElementById('daysleep_restend').value;
            // alert(startsleepchk);
            // alert(endsleepchk);
            // alert(checkClient);

            if (checkClient == 'MB') {
                var parkingtimechk   = document.getElementById('txt_parkingtimedealer4plan').value;
                var departuretimechk = document.getElementById('txt_departuretimedealer4plan').value;
            }else{
                //START REST
                var parkingtimechk0  = document.getElementById('txt_parkingtimedealer4plan').value;
                var parkingtimechk1  = parkingtimechk0.replace(" ","T"); // replave " " เป็น "T"
                var parkingtimechk2  = parkingtimechk1.replace("/","-");
                var parkingtimechk3  = parkingtimechk2.replace("/","-"); // replave "/" เป็น "-"
                var parkingtimechk   = parkingtimechk3;
                
                //END REST
                var departuretimechk0  = document.getElementById('txt_departuretimedealer4plan').value;
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
                    txt_flg: "select_timedealer", parkingtimechk: parkingtimechk, departuretimechk: departuretimechk
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
                    document.getElementById('txt_sumtimedealer4plan').value = replacetext;
                
                }
            });

        }
        // END TIMEDEALER4 PLAN

        //////////////////////////////////////////////////////////////////////////////////////
        // START TIMECHECK ACTUAL P1
        function parkingtime_actual_4hrs_p1(checkClient){

        if (checkClient == 'MB') {
            // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
            var pakingtimechk3  = document.getElementById('txt_parkingtime_actual_4hur_p1').value;

        }else{
            // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
            var pakingtimechk   = document.getElementById('txt_parkingtime_actual_4hur_p1').value;
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
                txt_flg: "cal_parkingtime_actual_4hrs_p1",
                startdatetimechk:pakingtimechk3,
            },
            success: function (rs) {
                // alert(rs);
                document.getElementById('txt_departuretime_actual_4hur_p1').value = rs; 
            }
        }); 

        }

        function parkingtime_actual_2hrs_p1(checkClient){

        if (checkClient == 'MB') {
            
            var pakingtimechk3  = document.getElementById('txt_parkingtime_actual_2hur_p1').value;

        }else{
        // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
            var pakingtimechk   = document.getElementById('txt_parkingtime_actual_2hur_p1').value;
            var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
            var pakingtimechk2  = pakingtimechk1.replace("/","-");
            var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
            // alert(pakingtimechk3);  
        }



        $.ajax({
            type: 'post',
            url: 'meg_data_drivingpattern_driver.php',
            data: {
                txt_flg: "cal_parkingtime_actual_2hrs_p1",
                startdatetimechk:pakingtimechk3,
            },
            success: function (rs) {
                // alert(rs);
                document.getElementById('txt_departuretime_actual_2hur_p1').value = rs; 
            }
        }); 

        }
        // END TIMECHECK P1
        // START TIMECHECK P2
        function parkingtime_actual_4hrs_p2(checkClient){

        if (checkClient == 'MB') {

            var pakingtimechk3  = document.getElementById('txt_parkingtime_actual_4hur_p2').value;

        }else{
            // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
            var pakingtimechk   = document.getElementById('txt_parkingtime_actual_4hur_p2').value;
            var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
            var pakingtimechk2  = pakingtimechk1.replace("/","-");
            var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
            // alert(pakingtimechk3);    
        }



        $.ajax({
            type: 'post',
            url: 'meg_data_drivingpattern_driver.php',
            data: {
                txt_flg: "cal_parkingtime_actual_4hrs_p2",
                startdatetimechk:pakingtimechk3,
            },
            success: function (rs) {
                // alert(rs);
                document.getElementById('txt_departuretime_actual_4hur_p2').value = rs; 
            }
        }); 

        }

        function parkingtime_actual_2hrs_p2(checkClient){

        if (checkClient == 'MB') {
            
            var pakingtimechk3  = document.getElementById('txt_parkingtime_actual_2hur_p2').value;

        }else{
            // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
            var pakingtimechk   = document.getElementById('txt_parkingtime_actual_2hur_p2').value;
            var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
            var pakingtimechk2  = pakingtimechk1.replace("/","-");
            var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
            // alert(pakingtimechk3);  
        }



        $.ajax({
            type: 'post',
            url: 'meg_data_drivingpattern_driver.php',
            data: {
                txt_flg: "cal_parkingtime_actual_2hrs_p2",
                startdatetimechk:pakingtimechk3,
            },
            success: function (rs) {
                // alert(rs);
                document.getElementById('txt_departuretime_actual_2hur_p2').value = rs; 
            }
        }); 

        }
        // END TIMECHECK P2
        // START TIMECHECK P3
        function parkingtime_actual_4hrs_p3(checkClient){

        if (checkClient == 'MB') {
            
            var pakingtimechk3  = document.getElementById('txt_parkingtime_actual_4hur_p3').value;

        }else{
            // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
            var pakingtimechk   = document.getElementById('txt_parkingtime_actual_4hur_p3').value;
            var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
            var pakingtimechk2  = pakingtimechk1.replace("/","-");
            var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
            // alert(pakingtimechk3);    
        }



        $.ajax({
            type: 'post',
            url: 'meg_data_drivingpattern_driver.php',
            data: {
                txt_flg: "cal_parkingtime_actual_4hrs_p3",
                startdatetimechk:pakingtimechk3,
            },
            success: function (rs) {
                // alert(rs);
                document.getElementById('txt_departuretime_actual_4hur_p3').value = rs; 
            }
        }); 

        }

        function parkingtime_actual_2hrs_p3(checkClient){

        if (checkClient == 'MB') {
            
            var pakingtimechk3   = document.getElementById('txt_parkingtime_actual_2hur_p3').value;

        }else{
            // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
            var pakingtimechk   = document.getElementById('txt_parkingtime_actual_2hur_p3').value;
            var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
            var pakingtimechk2  = pakingtimechk1.replace("/","-");
            var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
            // alert(pakingtimechk3);
        }



        $.ajax({
            type: 'post',
            url: 'meg_data_drivingpattern_driver.php',
            data: {
                txt_flg: "cal_parkingtime_actual_2hrs_p3",
                startdatetimechk:pakingtimechk3,
            },
            success: function (rs) {
                // alert(rs);
                document.getElementById('txt_departuretime_actual_2hur_p3').value = rs; 
            }
        }); 

        }
        // END TIMECHECK P3
        // START TIMECHECK P4
        function parkingtime_actual_4hrs_p4(checkClient){

        if (checkClient == 'MB') {
            
            var pakingtimechk3  = document.getElementById('txt_parkingtime_actual_4hur_p4').value;

        }else{
            // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
            var pakingtimechk   = document.getElementById('txt_parkingtime_actual_4hur_p4').value;
            var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
            var pakingtimechk2  = pakingtimechk1.replace("/","-");
            var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
            // alert(pakingtimechk3);
        }



        $.ajax({
            type: 'post',
            url: 'meg_data_drivingpattern_driver.php',
            data: {
                txt_flg: "cal_parkingtime_actual_4hrs_p4",
                startdatetimechk:pakingtimechk3,
            },
            success: function (rs) {
                // alert(rs);
                document.getElementById('txt_departuretime_actual_4hur_p4').value = rs; 
            }
        }); 

        }

        function parkingtime_actual_2hrs_p4(checkClient){

        if (checkClient == 'MB') {
            
            var pakingtimechk3  = document.getElementById('txt_parkingtime_actual_2hur_p4').value;

        }else{
            // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
            var pakingtimechk   = document.getElementById('txt_parkingtime_actual_2hur_p4').value;
            var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
            var pakingtimechk2  = pakingtimechk1.replace("/","-");
            var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
            // alert(pakingtimechk3);
        }



        $.ajax({
            type: 'post',
            url: 'meg_data_drivingpattern_driver.php',
            data: {
                txt_flg: "cal_parkingtime_actual_2hrs_p4",
                startdatetimechk:pakingtimechk3,
            },
            success: function (rs) {
                // alert(rs);
                document.getElementById('txt_departuretime_actual_2hur_p4').value = rs; 
            }
        }); 

        }
        // END TIMECHECK P4
        // START TIMECHECK P5
        function parkingtime_actual_4hrs_p5(checkClient){

            if (checkClient == 'MB') {
                
                var pakingtimechk3  = document.getElementById('txt_parkingtime_actual_4hur_p5').value;

            }else{
                // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
                var pakingtimechk   = document.getElementById('txt_parkingtime_actual_4hur_p5').value;
                var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
                var pakingtimechk2  = pakingtimechk1.replace("/","-");
                var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
                // alert(pakingtimechk3);
            }



            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "cal_parkingtime_actual_4hrs_p5",
                    startdatetimechk:pakingtimechk3,
                },
                success: function (rs) {
                    // alert(rs);
                    document.getElementById('txt_departuretime_actual_4hur_p5').value = rs; 
                }
            });     

        }

        function parkingtime_actual_2hrs_p5(checkClient){

        if (checkClient == 'MB') {
            
            var pakingtimechk   = document.getElementById('txt_parkingtime_actual_2hur_p5').value;

        }else{
            // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
            var pakingtimechk   = document.getElementById('txt_parkingtime_actual_2hur_p5').value;
            var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
            var pakingtimechk2  = pakingtimechk1.replace("/","-");
            var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
            // alert(pakingtimechk3);  
        }



        $.ajax({
            type: 'post',
            url: 'meg_data_drivingpattern_driver.php',
            data: {
                txt_flg: "cal_parkingtime_actual_2hrs_p5",
                startdatetimechk:pakingtimechk3,
            },
            success: function (rs) {
                // alert(rs);
                document.getElementById('txt_departuretime_actual_2hur_p5').value = rs; 
            }
        }); 

        }
        // END TIMECHECK P5
        // START TIMECHECK P6
        function parkingtime_actual_4hrs_p6(checkClient){

        if (checkClient == 'MB') {
            
            var pakingtimechk3   = document.getElementById('txt_parkingtime_actual_4hur_p6').value;

        }else{
            // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
            var pakingtimechk   = document.getElementById('txt_parkingtime_actual_4hur_p6').value;
            var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
            var pakingtimechk2  = pakingtimechk1.replace("/","-");
            var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
            // alert(pakingtimechk3);
        }



        $.ajax({
            type: 'post',
            url: 'meg_data_drivingpattern_driver.php',
            data: {
                txt_flg: "cal_parkingtime_actual_4hrs_p6",
                startdatetimechk:pakingtimechk3,
            },
            success: function (rs) {
                // alert(rs);
                document.getElementById('txt_departuretime_actual_4hur_p6').value = rs; 
            }
        }); 

        }
        function parkingtime_actual_2hrs_p6(checkClient){

        if (checkClient == 'MB') {

            var pakingtimechk3   = document.getElementById('txt_parkingtime_actual_2hur_p6').value;

        }else{
            // var startsleepchk = document.getElementById('txt_parkingtime_plan_4hur_p1').value;
            var pakingtimechk   = document.getElementById('txt_parkingtime_actual_2hur_p6').value;
            var pakingtimechk1  = pakingtimechk.replace("T"," "); // replace "T" เป็น " "
            var pakingtimechk2  = pakingtimechk1.replace("/","-");
            var pakingtimechk3  = pakingtimechk2.replace("/","-"); 
            // alert(pakingtimechk3);    
        }



        $.ajax({
            type: 'post',
            url: 'meg_data_drivingpattern_driver.php',
            data: {
                txt_flg: "cal_parkingtime_actual_2hrs_p6",
                startdatetimechk:pakingtimechk3,
            },
            success: function (rs) {
                // alert(rs);
                document.getElementById('txt_departuretime_actual_2hur_p6').value = rs; 
            }
        }); 

        }
        // END TIMECHECK ACTUAL P6     

        // START TIME DEALER1 ACTUAL
        function timedealer1actualcheck(checkClient){
            
            // var startsleepchk = document.getElementById('daysleep_reststart').value;
            // var endsleepchk = document.getElementById('daysleep_restend').value;
            // alert(startsleepchk);
            // alert(endsleepchk);
            // alert(checkClient);

            if (checkClient == 'MB') {
                var parkingtimechk   = document.getElementById('txt_parkingtimedealer1actual').value;
                var departuretimechk = document.getElementById('txt_departuretimedealer1actual').value;
            }else{
                //START REST
                var parkingtimechk0  = document.getElementById('txt_parkingtimedealer1actual').value;
                var parkingtimechk1  = parkingtimechk0.replace(" ","T"); // replave " " เป็น "T"
                var parkingtimechk2  = parkingtimechk1.replace("/","-");
                var parkingtimechk3  = parkingtimechk2.replace("/","-"); // replave "/" เป็น "-"
                var parkingtimechk   = parkingtimechk3;
                
                //END REST
                var departuretimechk0  = document.getElementById('txt_departuretimedealer1actual').value;
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
                    txt_flg: "select_timedealeractual", parkingtimechk: parkingtimechk, departuretimechk: departuretimechk
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
                    document.getElementById('txt_sumtimedealer1actual').value = replacetext;
                
                }
            });

        }
        // END TIMEDEALER1 ACTUAL

        // START TIME DEALER2 ACTUAL
        function timedealer2actualcheck(checkClient){
            
            // var startsleepchk = document.getElementById('daysleep_reststart').value;
            // var endsleepchk = document.getElementById('daysleep_restend').value;
            // alert(startsleepchk);
            // alert(endsleepchk);
            // alert(checkClient);

            if (checkClient == 'MB') {
                var parkingtimechk   = document.getElementById('txt_parkingtimedealer2actual').value;
                var departuretimechk = document.getElementById('txt_departuretimedealer2actual').value;
            }else{
                //START REST
                var parkingtimechk0  = document.getElementById('txt_parkingtimedealer2actual').value;
                var parkingtimechk1  = parkingtimechk0.replace(" ","T"); // replave " " เป็น "T"
                var parkingtimechk2  = parkingtimechk1.replace("/","-");
                var parkingtimechk3  = parkingtimechk2.replace("/","-"); // replave "/" เป็น "-"
                var parkingtimechk   = parkingtimechk3;
                
                //END REST
                var departuretimechk0  = document.getElementById('txt_departuretimedealer2actual').value;
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
                    txt_flg: "select_timedealeractual", parkingtimechk: parkingtimechk, departuretimechk: departuretimechk
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
                    document.getElementById('txt_sumtimedealer2actual').value = replacetext;
                
                }
            });

        }
        // END TIMEDEALER2 ACTUAL

        // START TIME DEALER3 ACTUAL
        function timedealer3actualcheck(checkClient){
            
            // var startsleepchk = document.getElementById('daysleep_reststart').value;
            // var endsleepchk = document.getElementById('daysleep_restend').value;
            // alert(startsleepchk);
            // alert(endsleepchk);
            // alert(checkClient);

            if (checkClient == 'MB') {
                var parkingtimechk   = document.getElementById('txt_parkingtimedealer3actual').value;
                var departuretimechk = document.getElementById('txt_departuretimedealer3actual').value;
            }else{
                //START REST
                var parkingtimechk0  = document.getElementById('txt_parkingtimedealer3actual').value;
                var parkingtimechk1  = parkingtimechk0.replace(" ","T"); // replave " " เป็น "T"
                var parkingtimechk2  = parkingtimechk1.replace("/","-");
                var parkingtimechk3  = parkingtimechk2.replace("/","-"); // replave "/" เป็น "-"
                var parkingtimechk   = parkingtimechk3;
                
                //END REST
                var departuretimechk0  = document.getElementById('txt_departuretimedealer3actual').value;
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
                    txt_flg: "select_timedealeractual", parkingtimechk: parkingtimechk, departuretimechk: departuretimechk
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
                    document.getElementById('txt_sumtimedealer3actual').value = replacetext;
                
                }
            });

        }
        // END TIMEDEALER3 ACTUAL
        
        // START TIME DEALER4 ACTUAL
        function timedealer4actualcheck(checkClient){
            
            // var startsleepchk = document.getElementById('daysleep_reststart').value;
            // var endsleepchk = document.getElementById('daysleep_restend').value;
            // alert(startsleepchk);
            // alert(endsleepchk);
            // alert(checkClient);

            if (checkClient == 'MB') {
                var parkingtimechk   = document.getElementById('txt_parkingtimedealer4actual').value;
                var departuretimechk = document.getElementById('txt_departuretimedealer4actual').value;
            }else{
                //START REST
                var parkingtimechk0  = document.getElementById('txt_parkingtimedealer4actual').value;
                var parkingtimechk1  = parkingtimechk0.replace(" ","T"); // replave " " เป็น "T"
                var parkingtimechk2  = parkingtimechk1.replace("/","-");
                var parkingtimechk3  = parkingtimechk2.replace("/","-"); // replave "/" เป็น "-"
                var parkingtimechk   = parkingtimechk3;
                
                //END REST
                var departuretimechk0  = document.getElementById('txt_departuretimedealer4actual').value;
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
                    txt_flg: "select_timedealeractual", parkingtimechk: parkingtimechk, departuretimechk: departuretimechk
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
                    document.getElementById('txt_sumtimedealer4actual').value = replacetext;
                
                }
            });

        }
        // END TIMEDEALER4 ACTUAL


        // FUNCTION สำหรับปุ่ม ยืนยันข้อมูล P1
        
        function confirmdatap1(checkClient,chkp1){

            var confirmby   = $("#txt_username").val();
            var drivingpatterngoid = '<?=$_GET['drivinggoplanid']?>';

            // alert(drivingpatterngoid);
            // alert(checkClient);

            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "save_confirm_p1",
                    employeecode:'',
                    condition1:drivingpatterngoid ,
                    condition2:confirmby ,
                    condition3:'',
                    condition4:'',
                    condition5:'',
                },
                success: function (rs) {
                    // alert(chkid);
                    // select_searchDrivingPattern(checkdata,chkid,employeecode)

                    // alert(rs);
                    // swal.fire({
                    //     title: "Success!",
                    //     text: "ลงข้อมูลช่วงที่ 1 เรียบร้อย !!!",
                    //     icon: "success",
                    //     showConfirmButton: true,
                    //     allowOutsideClick: false,
                    // });

                    let text = rs;
                    const myArray = text.split("|");
 
                    
                    // alert(replacetext); 
                    document.getElementById('txt_confirm_p1').value = myArray[0]; 
                    document.getElementById('txt_dateconfirm_p1').value = myArray[1]; 

                    save_actualp1(drivingpatterngoid,checkClient,chkp1);

                }
            }); 
        }
        function save_actualp1(checkGoId,checkClient,chkp1) {
            
            // alert('actual save P1');
            
            // Parameter ของ PLAN
            var drivingpatterngoid   = checkGoId;
            var jobstartplan         = $("#txt_jobstartplango").val();
            var drivernamep1         = $("#txt_drivernameplan_p1").val();
            var location4hurp1       = $("#txt_location_plan_4hur_p1").val();
            var location2hurp1       = $("#txt_location_plan_2hur_p1").val();
    

            // วันที่/เวลา (แผน)
            if (checkClient == 'MB') {
                var datestartplan = $("#txt_datestartplango").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartplanchk     = $("#txt_datestartplango").val();
                var datestartplan1chk    = datestartplanchk.replace(" ","T"); // replave " " เป็น "T"
                var datestartplanp2chk   = datestartplan1chk.replaceAll("/","-");
                // var drivingdate3      = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartplan      = datestartplanp2chk;
                
            }

            // วันที่/เวลา เริ่มขับ P1
            if (checkClient == 'MB') {
                var datestartplanp1 = $("#txt_datestartplan_p1").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartplanp1chk  = $("#txt_datestartplan_p1").val();
                var datestartplanp11    = datestartplanp1chk.replace(" ","T"); // replave " " เป็น "T"
                var datestartplanp12    = datestartplanp11.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartplanp1     = datestartplanp12;
                
            }

            // วันที่/เวลาจอด 4 hurs P1
            if (checkClient == 'MB') {
                var parkngtime_plan_4hurs_p1 = $("#txt_parkingtime_plan_4hur_p1").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_4hurs_p1chk     = $("#txt_parkingtime_plan_4hur_p1").val();
                var parkngtime_plan_4hurs_p11       = parkngtime_plan_4hurs_p1chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_4hurs_p12       = parkngtime_plan_4hurs_p11.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_4hurs_p1        = parkngtime_plan_4hurs_p12;
                
            }


            // วันที่/เวลาออก 4 hurs P1
            if (checkClient == 'MB') {
                var departuretime_plan_4hurs_p1 = $("#txt_departuretime_plan_4hur_p1").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_4hurs_p1chk     = $("#txt_departuretime_plan_4hur_p1").val();
                var departuretime_plan_4hurs_p11       = departuretime_plan_4hurs_p1chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_4hurs_p12       = departuretime_plan_4hurs_p11.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_4hurs_p1        = departuretime_plan_4hurs_p12;
                
            }

            // วันที่/เวลาจอด 2 hurs P1
            if (checkClient == 'MB') {
                var parkngtime_plan_2hurs_p1 = $("#txt_parkingtime_plan_2hur_p1").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_2hurs_p1chk     = $("#txt_parkingtime_plan_2hur_p1").val();
                var parkngtime_plan_2hurs_p11       = parkngtime_plan_2hurs_p1chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_2hurs_p12       = parkngtime_plan_2hurs_p11.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_2hurs_p1        = parkngtime_plan_2hurs_p12;
                
            }


            // วันที่/เวลาออก 2 hurs P1
            if (checkClient == 'MB') {
                var departuretime_plan_2hurs_p1 = $("#txt_departuretime_plan_2hur_p1").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_2hurs_p1chk     = $("#txt_departuretime_plan_2hur_p1").val();
                var departuretime_plan_2hurs_p11       = departuretime_plan_2hurs_p1chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_2hurs_p12       = departuretime_plan_2hurs_p11.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_2hurs_p1        = departuretime_plan_2hurs_p12;
                
            }
            /////////////////////////////////////////////////////////////////////
            
            // Parameter ของ ACTUAL
            
            var jobstartactual              = $("#txt_jobstartactual").val();
            var drivernameactualp1          = $("#txt_drivernameactual_p1").val();
            var location4huractualp1        = $("#txt_location_actual_4hur_p1").val();
            var location2huractualp1        = $("#txt_location_actual_2hur_p1").val();
    

            // วันที่/เวลา (วิ่งจริง)
            if (checkClient == 'MB') {
                var datestartactual = $("#txt_datestartactual").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartactualchk     = $("#txt_datestartactual").val();
                var datestartactual1chk    = datestartactualchk.replace(" ","T"); // replave " " เป็น "T"
                var datestartactualp2chk   = datestartactual1chk.replaceAll("/","-");
                // var drivingdate3        = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartactual        = datestartactualp2chk;
                
            }

            // วันที่/เวลา เริ่มขับ P1 ACTUAL
            if (checkClient == 'MB') {
                var datestartactualp1 = $("#txt_datestartactual_p1").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartactualp1chk  = $("#txt_datestartactual_p1").val();
                var datestartactualp11    = datestartactualp1chk.replace(" ","T"); // replave " " เป็น "T"
                var datestartactualp12    = datestartactualp11.replaceAll("/","-");
                // var drivingdate3       = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartactualp1     = datestartactualp12;
                
            }

            // วันที่/เวลาจอด 4 hurs P1 ACTUAL
            if (checkClient == 'MB') {
                var parkngtime_actual_4hurs_p1 = $("#txt_parkingtime_actual_4hur_p1").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_actual_4hurs_p1chk     = $("#txt_parkingtime_actual_4hur_p1").val();
                var parkngtime_actual_4hurs_p11       = parkngtime_actual_4hurs_p1chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_actual_4hurs_p12       = parkngtime_actual_4hurs_p11.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_actual_4hurs_p1        = parkngtime_actual_4hurs_p12;
                
            }


            // วันที่/เวลาออก 4 hurs P1 ACTUAL
            if (checkClient == 'MB') {
                var departuretime_actual_4hurs_p1 = $("#txt_departuretime_actual_4hur_p1").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_actual_4hurs_p1chk     = $("#txt_departuretime_actual_4hur_p1").val();
                var departuretime_actual_4hurs_p11       = departuretime_actual_4hurs_p1chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_actual_4hurs_p12       = departuretime_actual_4hurs_p11.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_actual_4hurs_p1        = departuretime_actual_4hurs_p12;
                
            }

            // วันที่/เวลาจอด 2 hurs P1 ACTUAL
            if (checkClient == 'MB') {
                var parkngtime_actual_2hurs_p1 = $("#txt_parkingtime_actual_2hur_p1").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_actual_2hurs_p1chk     = $("#txt_parkingtime_actual_2hur_p1").val();
                var parkngtime_actual_2hurs_p11       = parkngtime_actual_2hurs_p1chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_actual_2hurs_p12       = parkngtime_actual_2hurs_p11.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_actual_2hurs_p1        = parkngtime_actual_2hurs_p12;
                
            }


            // วันที่/เวลาออก 2 hurs P1 ACTUAL
            if (checkClient == 'MB') {
                var departuretime_actual_2hurs_p1 = $("#txt_departuretime_actual_2hur_p1").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_actual_2hurs_p1chk     = $("#txt_departuretime_actual_2hur_p1").val();
                var departuretime_actual_2hurs_p11       = departuretime_actual_2hurs_p1chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_actual_2hurs_p12       = departuretime_actual_2hurs_p11.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_actual_2hurs_p1        = departuretime_actual_2hurs_p12;
                
            }
            /////////////////////////////////////////////////////////////////////////////////////


            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "save_actualp1",
                    drivingpatterngoid:drivingpatterngoid,

                    condition1:jobstartplan,
                    condition2:datestartplan,
                    condition3:drivernamep1,
                    condition4:datestartplanp1,
                    condition5:parkngtime_plan_4hurs_p1,
                    condition6:departuretime_plan_4hurs_p1,
                    condition7:location4hurp1,
                    condition8:parkngtime_plan_2hurs_p1,
                    condition9:departuretime_plan_2hurs_p1,
                    condition10:location2hurp1,

                    condition11:jobstartactual,
                    condition12:datestartactual,
                    condition13:drivernameactualp1,
                    condition14:datestartactualp1,
                    condition15:parkngtime_actual_4hurs_p1,
                    condition16:departuretime_actual_4hurs_p1,
                    condition17:location4huractualp1,
                    condition18:parkngtime_actual_2hurs_p1,
                    condition19:departuretime_actual_2hurs_p1,
                    condition20:location2huractualp1,

                    condition21:'',
                    condition22:'',
                    condition23:'',
                    condition24:'',
                    condition25:'',
                    condition26:'',
                    condition27:'',
                    condition28:'',
                    condition29:'',
                    condition30:'',

                    condition31:'',
                    condition32:''
                },
                success: function (rs) {
                    // alert(chkid);
                    // select_searchDrivingPattern(checkdata,chkid,employeecode)

                    // alert(rs);
                    if (chkp1 == 'CONALL') {
                        // swal.fire({
                        //     title: "Success!",
                        //     text: "ยืนยันข้อมูลขาไปทั้งหมด เรียบร้อย !!!",
                        //     icon: "success",
                        //     showConfirmButton: true,
                        //     allowOutsideClick: false,
                        // });    
                    }else{
                        swal.fire({
                            title: "Success!",
                            text: "ยืนยันข้อมูล (ช่วงที่1) เรียบร้อย !!!",
                            icon: "success",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    }
                    

                    
                }
            });
        }

        ////////////////////////////////////////////////////////////////////////////////////////////

        // FUNCTION สำหรับปุ่มยืนยันข้อมูล P2
        function confirmdatap2(checkClient,chkp2){

            var confirmby   = $("#txt_username").val();
            var drivingpatterngoid = '<?=$_GET['drivinggoplanid']?>';

            // alert(drivingpatterngoid);
            // alert(confirmby);

            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "save_confirm_p2",
                    employeecode:'',
                    condition1:drivingpatterngoid ,
                    condition2:confirmby ,
                    condition3:'',
                    condition4:'',
                    condition5:'',
                },
                success: function (rs) {
                    // alert(chkid);
                    // select_searchDrivingPattern(checkdata,chkid,employeecode)

                    // alert(rs);
                    // swal.fire({
                    //     title: "Success!",
                    //     text: "ลงข้อมูลช่วงที่ 2 เรียบร้อย !!!",
                    //     icon: "success",
                    //     showConfirmButton: true,
                    //     allowOutsideClick: false,
                    // });

                    let text = rs;
                    const myArray = text.split("|");

                    
                    // alert(replacetext); 
                    document.getElementById('txt_confirm_p2').value = myArray[0]; 
                    document.getElementById('txt_dateconfirm_p2').value = myArray[1]; 

                    save_actualp2(drivingpatterngoid,checkClient,chkp2);
                }
            }); 
        }
        function save_actualp2(checkGoId,checkClient,chkp2) {
            
            // alert('actual save P2');
            
            // Parameter ของ PLAN
            var drivingpatterngoid   = checkGoId;
            var jobstartplan         = '';
            var drivernamep2         = $("#txt_drivernameplan_p2").val();
            var location4hurp2       = $("#txt_location_plan_4hur_p2").val();
            var location2hurp2       = $("#txt_location_plan_2hur_p2").val();
    

            // วันที่/เวลา (แผน)
            var datestartplan = '';
           

            // วันที่/เวลา เริ่มขับ P2
            if (checkClient == 'MB') {
                var datestartplanp2 = $("#txt_datestartplan_p2").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartplanp2chk  = $("#txt_datestartplan_p2").val();
                var datestartplanp21    = datestartplanp2chk.replace(" ","T"); // replave " " เป็น "T"
                var datestartplanp22    = datestartplanp21.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartplanp2     = datestartplanp22;
                
            }

            // วันที่/เวลาจอด 4 hurs P2
            if (checkClient == 'MB') {
                var parkngtime_plan_4hurs_p2 = $("#txt_parkingtime_plan_4hur_p2").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_4hurs_p2chk     = $("#txt_parkingtime_plan_4hur_p2").val();
                var parkngtime_plan_4hurs_p21       = parkngtime_plan_4hurs_p2chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_4hurs_p22       = parkngtime_plan_4hurs_p21.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_4hurs_p2        = parkngtime_plan_4hurs_p22;
                
            }


            // วันที่/เวลาออก 4 hurs P2
            if (checkClient == 'MB') {
                var departuretime_plan_4hurs_p2 = $("#txt_departuretime_plan_4hur_p2").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_4hurs_p2chk     = $("#txt_departuretime_plan_4hur_p2").val();
                var departuretime_plan_4hurs_p21       = departuretime_plan_4hurs_p2chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_4hurs_p22       = departuretime_plan_4hurs_p21.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_4hurs_p2        = departuretime_plan_4hurs_p22;
                
            }

            // วันที่/เวลาจอด 2 hurs P2
            if (checkClient == 'MB') {
                var parkngtime_plan_2hurs_p2 = $("#txt_parkingtime_plan_2hur_p2").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_2hurs_p2chk     = $("#txt_parkingtime_plan_2hur_p2").val();
                var parkngtime_plan_2hurs_p21       = parkngtime_plan_2hurs_p2chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_2hurs_p22       = parkngtime_plan_2hurs_p21.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_2hurs_p2        = parkngtime_plan_2hurs_p22;
                
            }


            // วันที่/เวลาออก 2 hurs P2
            if (checkClient == 'MB') {
                var departuretime_plan_2hurs_p2 = $("#txt_departuretime_plan_2hur_p2").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_2hurs_p2chk     = $("#txt_departuretime_plan_2hur_p2").val();
                var departuretime_plan_2hurs_p21       = departuretime_plan_2hurs_p2chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_2hurs_p22       = departuretime_plan_2hurs_p21.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_2hurs_p2        = departuretime_plan_2hurs_p22;
                
            }
            /////////////////////////////////////////////////////////////////////
            
            // Parameter ของ ACTUAL
            
            var jobstartactual              = '';
            var drivernameactualp2          = $("#txt_drivernameactual_p2").val();
            var location4huractualp2        = $("#txt_location_actual_4hur_p2").val();
            var location2huractualp2        = $("#txt_location_actual_2hur_p2").val();
    

            // วันที่/เวลา (วิ่งจริง)
            
                var datestartactual = '';
            

            // วันที่/เวลา เริ่มขับ P2 ACTUAL
            if (checkClient == 'MB') {
                var datestartactualp2 = $("#txt_datestartactual_p2").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartactualp2chk  = $("#txt_datestartactual_p2").val();
                var datestartactualp21    = datestartactualp2chk.replace(" ","T"); // replave " " เป็น "T"
                var datestartactualp22    = datestartactualp21.replaceAll("/","-");
                // var drivingdate3       = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartactualp2     = datestartactualp22;
                
            }

            // วันที่/เวลาจอด 4 hurs P2 ACTUAL
            if (checkClient == 'MB') {
                var parkngtime_actual_4hurs_p2 = $("#txt_parkingtime_actual_4hur_p2").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_actual_4hurs_p2chk     = $("#txt_parkingtime_actual_4hur_p2").val();
                var parkngtime_actual_4hurs_p21       = parkngtime_actual_4hurs_p2chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_actual_4hurs_p22       = parkngtime_actual_4hurs_p21.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_actual_4hurs_p2        = parkngtime_actual_4hurs_p22;
                
            }


            // วันที่/เวลาออก 4 hurs P2 ACTUAL
            if (checkClient == 'MB') {
                var departuretime_actual_4hurs_p2 = $("#txt_departuretime_actual_4hur_p2").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_actual_4hurs_p2chk     = $("#txt_departuretime_actual_4hur_p2").val();
                var departuretime_actual_4hurs_p21       = departuretime_actual_4hurs_p2chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_actual_4hurs_p22       = departuretime_actual_4hurs_p21.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_actual_4hurs_p2        = departuretime_actual_4hurs_p22;
                
            }

            // วันที่/เวลาจอด 2 hurs P2 ACTUAL
            if (checkClient == 'MB') {
                var parkngtime_actual_2hurs_p2 = $("#txt_parkingtime_actual_2hur_p2").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_actual_2hurs_p2chk     = $("#txt_parkingtime_actual_2hur_p2").val();
                var parkngtime_actual_2hurs_p21       = parkngtime_actual_2hurs_p2chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_actual_2hurs_p22       = parkngtime_actual_2hurs_p21.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_actual_2hurs_p2        = parkngtime_actual_2hurs_p22;
                
            }


            // วันที่/เวลาออก 2 hurs P2 ACTUAL
            if (checkClient == 'MB') {
                var departuretime_actual_2hurs_p2 = $("#txt_departuretime_actual_2hur_p2").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_actual_2hurs_p2chk     = $("#txt_departuretime_actual_2hur_p2").val();
                var departuretime_actual_2hurs_p21       = departuretime_actual_2hurs_p2chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_actual_2hurs_p22       = departuretime_actual_2hurs_p21.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_actual_2hurs_p2        = departuretime_actual_2hurs_p22;
                
            }
            /////////////////////////////////////////////////////////////////////////////////////


            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "save_actualp2",
                    drivingpatterngoid:drivingpatterngoid,

                    condition1:'',
                    condition2:'',
                    condition3:drivernamep2,
                    condition4:datestartplanp2,
                    condition5:parkngtime_plan_4hurs_p2,
                    condition6:departuretime_plan_4hurs_p2,
                    condition7:location4hurp2,
                    condition8:parkngtime_plan_2hurs_p2,
                    condition9:departuretime_plan_2hurs_p2,
                    condition10:location2hurp2,

                    condition11:'',
                    condition12:'',
                    condition13:drivernameactualp2,
                    condition14:datestartactualp2,
                    condition15:parkngtime_actual_4hurs_p2,
                    condition16:departuretime_actual_4hurs_p2,
                    condition17:location4huractualp2,
                    condition18:parkngtime_actual_2hurs_p2,
                    condition19:departuretime_actual_2hurs_p2,
                    condition20:location2huractualp2,

                    condition21:'',
                    condition22:'',
                    condition23:'',
                    condition24:'',
                    condition25:'',
                    condition26:'',
                    condition27:'',
                    condition28:'',
                    condition29:'',
                    condition30:'',

                    condition31:'',
                    condition32:''
                },
                success: function (rs) {
                    // alert(chkid);
                    // select_searchDrivingPattern(checkdata,chkid,employeecode)

                    // alert(rs);

                    if (chkp2 == 'CONALL') {
                        // swal.fire({
                        //     title: "Success!",
                        //     text: "ยืนยันข้อมูลขาไปทั้งหมด เรียบร้อย !!!",
                        //     icon: "success",
                        //     showConfirmButton: true,
                        //     allowOutsideClick: false,
                        // });    
                    }else{
                        swal.fire({
                            title: "Success!",
                            text: "ยืนยันข้อมูล (ช่วงที่2) เรียบร้อย !!!",
                            icon: "success",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    }

                    

                    
                }
            });
        }
        ////////////////////////////////////////////////////////////////////////////////////////////


        function confirmdatap3(checkClient,chkp3){

            var confirmby   = $("#txt_username").val();
            var drivingpatterngoid = '<?=$_GET['drivinggoplanid']?>';

            // alert(drivingpatterngoid);
            // alert(confirmby);

            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "save_confirm_p3",
                    employeecode:'',
                    condition1:drivingpatterngoid ,
                    condition2:confirmby ,
                    condition3:'',
                    condition4:'',
                    condition5:'',
                },
                success: function (rs) {
                    // alert(chkid);
                    // select_searchDrivingPattern(checkdata,chkid,employeecode)

                    // alert(rs);
                    // swal.fire({
                    //     title: "Success!",
                    //     text: "ลงข้อมูลช่วงที่ 3 เรียบร้อย !!!",
                    //     icon: "success",
                    //     showConfirmButton: true,
                    //     allowOutsideClick: false,
                    // });

                    let text = rs;
                    const myArray = text.split("|");

                    
                    // alert(replacetext); 
                    document.getElementById('txt_confirm_p3').value = myArray[0]; 
                    document.getElementById('txt_dateconfirm_p3').value = myArray[1]; 
                    
                    save_actualp3(drivingpatterngoid,checkClient,chkp3);
                }
            }); 
        }
        function save_actualp3(checkGoId,checkClient,chkp3) {
            
            // alert('actual save P3');
            
            // Parameter ของ PLAN
            var drivingpatterngoid   = checkGoId;
            var jobstartplan         = '';
            var drivernamep3         = $("#txt_drivernameplan_p3").val();
            var location4hurp3       = $("#txt_location_plan_4hur_p3").val();
            var location2hurp3       = $("#txt_location_plan_2hur_p3").val();
    

            // วันที่/เวลา (แผน)
            var datestartplan = '';
           

            // วันที่/เวลา เริ่มขับ P2
            if (checkClient == 'MB') {
                var datestartplanp3 = $("#txt_datestartplan_p3").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartplanp3chk  = $("#txt_datestartplan_p3").val();
                var datestartplanp31    = datestartplanp3chk.replace(" ","T"); // replave " " เป็น "T"
                var datestartplanp32    = datestartplanp31.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartplanp3     = datestartplanp32;
                
            }

            // วันที่/เวลาจอด 4 hurs P3
            if (checkClient == 'MB') {
                var parkngtime_plan_4hurs_p3 = $("#txt_parkingtime_plan_4hur_p3").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_4hurs_p3chk     = $("#txt_parkingtime_plan_4hur_p3").val();
                var parkngtime_plan_4hurs_p31       = parkngtime_plan_4hurs_p3chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_4hurs_p32       = parkngtime_plan_4hurs_p31.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_4hurs_p3        = parkngtime_plan_4hurs_p32;
                
            }


            // วันที่/เวลาออก 4 hurs P3
            if (checkClient == 'MB') {
                var departuretime_plan_4hurs_p3 = $("#txt_departuretime_plan_4hur_p3").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_4hurs_p3chk     = $("#txt_departuretime_plan_4hur_p3").val();
                var departuretime_plan_4hurs_p31       = departuretime_plan_4hurs_p3chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_4hurs_p32       = departuretime_plan_4hurs_p31.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_4hurs_p3        = departuretime_plan_4hurs_p32;
                
            }

            // วันที่/เวลาจอด 2 hurs P3
            if (checkClient == 'MB') {
                var parkngtime_plan_2hurs_p3 = $("#txt_parkingtime_plan_2hur_p3").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_2hurs_p3chk     = $("#txt_parkingtime_plan_2hur_p3").val();
                var parkngtime_plan_2hurs_p31       = parkngtime_plan_2hurs_p3chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_2hurs_p32       = parkngtime_plan_2hurs_p31.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_2hurs_p3        = parkngtime_plan_2hurs_p32;
                
            }


            // วันที่/เวลาออก 2 hurs P3
            if (checkClient == 'MB') {
                var departuretime_plan_2hurs_p3 = $("#txt_departuretime_plan_2hur_p3").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_2hurs_p3chk     = $("#txt_departuretime_plan_2hur_p3").val();
                var departuretime_plan_2hurs_p31       = departuretime_plan_2hurs_p3chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_2hurs_p32       = departuretime_plan_2hurs_p31.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_2hurs_p3        = departuretime_plan_2hurs_p32;
                
            }
            /////////////////////////////////////////////////////////////////////
            
            // Parameter ของ ACTUAL
            
            var jobstartactual              = '';
            var drivernameactualp3          = $("#txt_drivernameactual_p3").val();
            var location4huractualp3        = $("#txt_location_actual_4hur_p3").val();
            var location2huractualp3        = $("#txt_location_actual_2hur_p3").val();
    

            // วันที่/เวลา (วิ่งจริง)
            
                var datestartactual = '';
            

            // วันที่/เวลา เริ่มขับ P2 ACTUAL
            if (checkClient == 'MB') {
                var datestartactualp3 = $("#txt_datestartactual_p3").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartactualp3chk  = $("#txt_datestartactual_p3").val();
                var datestartactualp31    = datestartactualp3chk.replace(" ","T"); // replave " " เป็น "T"
                var datestartactualp32    = datestartactualp31.replaceAll("/","-");
                // var drivingdate3       = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartactualp3     = datestartactualp32;
                
            }

            // วันที่/เวลาจอด 4 hurs P3 ACTUAL
            if (checkClient == 'MB') {
                var parkngtime_actual_4hurs_p3 = $("#txt_parkingtime_actual_4hur_p3").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_actual_4hurs_p3chk     = $("#txt_parkingtime_actual_4hur_p3").val();
                var parkngtime_actual_4hurs_p31       = parkngtime_actual_4hurs_p3chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_actual_4hurs_p32       = parkngtime_actual_4hurs_p31.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_actual_4hurs_p3        = parkngtime_actual_4hurs_p32;
                
            }


            // วันที่/เวลาออก 4 hurs P3 ACTUAL
            if (checkClient == 'MB') {
                var departuretime_actual_4hurs_p3 = $("#txt_departuretime_actual_4hur_p3").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_actual_4hurs_p3chk     = $("#txt_departuretime_actual_4hur_p3").val();
                var departuretime_actual_4hurs_p31       = departuretime_actual_4hurs_p3chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_actual_4hurs_p32       = departuretime_actual_4hurs_p31.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_actual_4hurs_p3        = departuretime_actual_4hurs_p32;
                
            }

            // วันที่/เวลาจอด 2 hurs P3 ACTUAL
            if (checkClient == 'MB') {
                var parkngtime_actual_2hurs_p3 = $("#txt_parkingtime_actual_2hur_p3").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_actual_2hurs_p3chk     = $("#txt_parkingtime_actual_2hur_p3").val();
                var parkngtime_actual_2hurs_p31       = parkngtime_actual_2hurs_p3chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_actual_2hurs_p32       = parkngtime_actual_2hurs_p31.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_actual_2hurs_p3        = parkngtime_actual_2hurs_p32;
                
            }


            // วันที่/เวลาออก 2 hurs P3 ACTUAL
            if (checkClient == 'MB') {
                var departuretime_actual_2hurs_p3 = $("#txt_departuretime_actual_2hur_p3").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_actual_2hurs_p3chk     = $("#txt_departuretime_actual_2hur_p3").val();
                var departuretime_actual_2hurs_p31       = departuretime_actual_2hurs_p3chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_actual_2hurs_p32       = departuretime_actual_2hurs_p31.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_actual_2hurs_p3        = departuretime_actual_2hurs_p32;
                
            }
            /////////////////////////////////////////////////////////////////////////////////////


            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "save_actualp3",
                    drivingpatterngoid:drivingpatterngoid,

                    condition1:'',
                    condition2:'',
                    condition3:drivernamep3,
                    condition4:datestartplanp3,
                    condition5:parkngtime_plan_4hurs_p3,
                    condition6:departuretime_plan_4hurs_p3,
                    condition7:location4hurp3,
                    condition8:parkngtime_plan_2hurs_p3,
                    condition9:departuretime_plan_2hurs_p3,
                    condition10:location2hurp3,

                    condition11:'',
                    condition12:'',
                    condition13:drivernameactualp3,
                    condition14:datestartactualp3,
                    condition15:parkngtime_actual_4hurs_p3,
                    condition16:departuretime_actual_4hurs_p3,
                    condition17:location4huractualp3,
                    condition18:parkngtime_actual_2hurs_p3,
                    condition19:departuretime_actual_2hurs_p3,
                    condition20:location2huractualp3,

                    condition21:'',
                    condition22:'',
                    condition23:'',
                    condition24:'',
                    condition25:'',
                    condition26:'',
                    condition27:'',
                    condition28:'',
                    condition29:'',
                    condition30:'',

                    condition31:'',
                    condition32:''
                },
                success: function (rs) {
                    // alert(chkid);
                    // select_searchDrivingPattern(checkdata,chkid,employeecode)

                    // alert(rs);

                    if (chkp3 == 'CONALL') {
                        // swal.fire({
                        //     title: "Success!",
                        //     text: "ยืนยันข้อมูลขาไปทั้งหมด เรียบร้อย !!!",
                        //     icon: "success",
                        //     showConfirmButton: true,
                        //     allowOutsideClick: false,
                        // });    
                    }else{
                        swal.fire({
                            title: "Success!",
                            text: "ยืนยันข้อมูล (ช่วงที่3) เรียบร้อย !!!",
                            icon: "success",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    }

                    
                }
            });
        }
        /////////////////////////////////////////////////////////////////////////

        function confirmdatap4(checkClient,chkp4){

            var confirmby   = $("#txt_username").val();
            var drivingpatterngoid = '<?=$_GET['drivinggoplanid']?>';

            // alert(drivingpatterngoid);
            // alert(confirmby);

            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "save_confirm_p4",
                    employeecode:'',
                    condition1:drivingpatterngoid ,
                    condition2:confirmby ,
                    condition3:'',
                    condition4:'',
                    condition5:'',
                },
                success: function (rs) {
                    // alert(chkid);
                    // select_searchDrivingPattern(checkdata,chkid,employeecode)

                    // alert(rs);
                    // swal.fire({
                    //     title: "Success!",
                    //     text: "ลงข้อมูลช่วงที่ 4 เรียบร้อย !!!",
                    //     icon: "success",
                    //     showConfirmButton: true,
                    //     allowOutsideClick: false,
                    // });

                    let text = rs;
                    const myArray = text.split("|");

                    
                    // alert(replacetext); 
                    document.getElementById('txt_confirm_p4').value = myArray[0]; 
                    document.getElementById('txt_dateconfirm_p4').value = myArray[1]; 

                    save_actualp4(drivingpatterngoid,checkClient,chkp4);    
                }
            }); 
        }

        function save_actualp4(checkGoId,checkClient,chkp4) {
            
            // alert('actual save P4');
            
            // Parameter ของ PLAN
            var drivingpatterngoid   = checkGoId;
            var jobstartplan         = '';
            var drivernamep4         = $("#txt_drivernameplan_p4").val();
            var location4hurp4       = $("#txt_location_plan_4hur_p4").val();
            var location2hurp4       = $("#txt_location_plan_2hur_p4").val();
    

            // วันที่/เวลา (แผน)
            var datestartplan = '';
           

            // วันที่/เวลา เริ่มขับ P4
            if (checkClient == 'MB') {
                var datestartplanp4 = $("#txt_datestartplan_p4").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartplanp4chk  = $("#txt_datestartplan_p4").val();
                var datestartplanp41    = datestartplanp4chk.replace(" ","T"); // replave " " เป็น "T"
                var datestartplanp42    = datestartplanp41.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartplanp4     = datestartplanp42;
                
            }

            // วันที่/เวลาจอด 4 hurs P4
            if (checkClient == 'MB') {
                var parkngtime_plan_4hurs_p4 = $("#txt_parkingtime_plan_4hur_p4").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_4hurs_p4chk     = $("#txt_parkingtime_plan_4hur_p4").val();
                var parkngtime_plan_4hurs_p41       = parkngtime_plan_4hurs_p4chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_4hurs_p42       = parkngtime_plan_4hurs_p41.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_4hurs_p4        = parkngtime_plan_4hurs_p42;
                
            }


            // วันที่/เวลาออก 4 hurs P4
            if (checkClient == 'MB') {
                var departuretime_plan_4hurs_p4 = $("#txt_departuretime_plan_4hur_p4").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_4hurs_p4chk     = $("#txt_departuretime_plan_4hur_p4").val();
                var departuretime_plan_4hurs_p41       = departuretime_plan_4hurs_p4chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_4hurs_p42       = departuretime_plan_4hurs_p41.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_4hurs_p4        = departuretime_plan_4hurs_p42;
                
            }

            // วันที่/เวลาจอด 2 hurs P4
            if (checkClient == 'MB') {
                var parkngtime_plan_2hurs_p4 = $("#txt_parkingtime_plan_2hur_p4").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_2hurs_p4chk     = $("#txt_parkingtime_plan_2hur_p4").val();
                var parkngtime_plan_2hurs_p41       = parkngtime_plan_2hurs_p4chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_2hurs_p42       = parkngtime_plan_2hurs_p41.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_2hurs_p4        = parkngtime_plan_2hurs_p42;
                
            }


            // วันที่/เวลาออก 2 hurs P4
            if (checkClient == 'MB') {
                var departuretime_plan_2hurs_p4 = $("#txt_departuretime_plan_2hur_p4").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_2hurs_p4chk     = $("#txt_departuretime_plan_2hur_p4").val();
                var departuretime_plan_2hurs_p41       = departuretime_plan_2hurs_p4chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_2hurs_p42       = departuretime_plan_2hurs_p41.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_2hurs_p4        = departuretime_plan_2hurs_p42;
                
            }
            /////////////////////////////////////////////////////////////////////
            
            // Parameter ของ ACTUAL
            
            var jobstartactual              = '';
            var drivernameactualp4          = $("#txt_drivernameactual_p4").val();
            var location4huractualp4        = $("#txt_location_actual_4hur_p4").val();
            var location2huractualp4        = $("#txt_location_actual_2hur_p4").val();
    

            // วันที่/เวลา (วิ่งจริง)
            
                var datestartactual = '';
            

            // วันที่/เวลา เริ่มขับ P4 ACTUAL
            if (checkClient == 'MB') {
                var datestartactualp4 = $("#txt_datestartactual_p4").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartactualp4chk  = $("#txt_datestartactual_p4").val();
                var datestartactualp41    = datestartactualp4chk.replace(" ","T"); // replave " " เป็น "T"
                var datestartactualp42    = datestartactualp41.replaceAll("/","-");
                // var drivingdate3       = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartactualp4     = datestartactualp42;
                
            }

            // วันที่/เวลาจอด 4 hurs P4 ACTUAL
            if (checkClient == 'MB') {
                var parkngtime_actual_4hurs_p4 = $("#txt_parkingtime_actual_4hur_p4").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_actual_4hurs_p4chk     = $("#txt_parkingtime_actual_4hur_p4").val();
                var parkngtime_actual_4hurs_p41       = parkngtime_actual_4hurs_p4chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_actual_4hurs_p42       = parkngtime_actual_4hurs_p41.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_actual_4hurs_p4        = parkngtime_actual_4hurs_p42;
                
            }


            // วันที่/เวลาออก 4 hurs P4 ACTUAL
            if (checkClient == 'MB') {
                var departuretime_actual_4hurs_p4 = $("#txt_departuretime_actual_4hur_p4").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_actual_4hurs_p4chk     = $("#txt_departuretime_actual_4hur_p4").val();
                var departuretime_actual_4hurs_p41       = departuretime_actual_4hurs_p4chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_actual_4hurs_p42       = departuretime_actual_4hurs_p41.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_actual_4hurs_p4        = departuretime_actual_4hurs_p42;
                
            }

            // วันที่/เวลาจอด 2 hurs P4 ACTUAL
            if (checkClient == 'MB') {
                var parkngtime_actual_2hurs_p4 = $("#txt_parkingtime_actual_2hur_p4").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_actual_2hurs_p4chk     = $("#txt_parkingtime_actual_2hur_p4").val();
                var parkngtime_actual_2hurs_p41       = parkngtime_actual_2hurs_p4chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_actual_2hurs_p42       = parkngtime_actual_2hurs_p41.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_actual_2hurs_p4        = parkngtime_actual_2hurs_p42;
                
            }


            // วันที่/เวลาออก 2 hurs P4 ACTUAL
            if (checkClient == 'MB') {
                var departuretime_actual_2hurs_p4 = $("#txt_departuretime_actual_2hur_p4").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_actual_2hurs_p4chk     = $("#txt_departuretime_actual_2hur_p4").val();
                var departuretime_actual_2hurs_p41       = departuretime_actual_2hurs_p4chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_actual_2hurs_p42       = departuretime_actual_2hurs_p41.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_actual_2hurs_p4        = departuretime_actual_2hurs_p42;
                
            }
            /////////////////////////////////////////////////////////////////////////////////////


            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "save_actualp4",
                    drivingpatterngoid:drivingpatterngoid,

                    condition1:'',
                    condition2:'',
                    condition3:drivernamep4,
                    condition4:datestartplanp4,
                    condition5:parkngtime_plan_4hurs_p4,
                    condition6:departuretime_plan_4hurs_p4,
                    condition7:location4hurp4,
                    condition8:parkngtime_plan_2hurs_p4,
                    condition9:departuretime_plan_2hurs_p4,
                    condition10:location2hurp4,

                    condition11:'',
                    condition12:'',
                    condition13:drivernameactualp4,
                    condition14:datestartactualp4,
                    condition15:parkngtime_actual_4hurs_p4,
                    condition16:departuretime_actual_4hurs_p4,
                    condition17:location4huractualp4,
                    condition18:parkngtime_actual_2hurs_p4,
                    condition19:departuretime_actual_2hurs_p4,
                    condition20:location2huractualp4,

                    condition21:'',
                    condition22:'',
                    condition23:'',
                    condition24:'',
                    condition25:'',
                    condition26:'',
                    condition27:'',
                    condition28:'',
                    condition29:'',
                    condition30:'',
                    condition31:'',
                    condition32:''
                },
                success: function (rs) {
                    // alert(chkid);
                    // select_searchDrivingPattern(checkdata,chkid,employeecode)

                    // alert(rs);

                    if (chkp4 == 'CONALL') {
                        // swal.fire({
                        //     title: "Success!",
                        //     text: "ยืนยันข้อมูลขาไปทั้งหมด เรียบร้อย !!!",
                        //     icon: "success",
                        //     showConfirmButton: true,
                        //     allowOutsideClick: false,
                        // });    
                    }else{
                        swal.fire({
                            title: "Success!",
                            text: "ยืนยันข้อมูล (ช่วงที่4) เรียบร้อย !!!",
                            icon: "success",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    }

                    
                }
            });
        }
        /////////////////////////////////////////////////////////////////////////

        function confirmdatap5(checkClient,chkp5){

            var confirmby   = $("#txt_username").val();
            var drivingpatterngoid = '<?=$_GET['drivinggoplanid']?>';

            // alert(drivingpatterngoid);
            // alert(confirmby);

            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "save_confirm_p5",
                    employeecode:'',
                    condition1:drivingpatterngoid ,
                    condition2:confirmby ,
                    condition3:'',
                    condition4:'',
                    condition5:'',
                },
                success: function (rs) {
                    // alert(chkid);
                    // select_searchDrivingPattern(checkdata,chkid,employeecode)

                    // alert(rs);
                    // swal.fire({
                    //     title: "Success!",
                    //     text: "ลงข้อมูลช่วงที่ 5 เรียบร้อย !!!",
                    //     icon: "success",
                    //     showConfirmButton: true,
                    //     allowOutsideClick: false,
                    // });

                    let text = rs;
                    const myArray = text.split("|");

                    
                    // alert(replacetext); 
                    document.getElementById('txt_confirm_p5').value = myArray[0]; 
                    document.getElementById('txt_dateconfirm_p5').value = myArray[1]; 

                    save_actualp5(drivingpatterngoid,checkClient,chkp5);
                }
            }); 
        }

        function save_actualp5(checkGoId,checkClient,chkp5) {
            
            // alert('actual save P5');
            
            // Parameter ของ PLAN
            var drivingpatterngoid   = checkGoId;
            var jobstartplan         = '';
            var drivernamep5         = $("#txt_drivernameplan_p5").val();
            var location4hurp5       = $("#txt_location_plan_4hur_p5").val();
            var location2hurp5       = $("#txt_location_plan_2hur_p5").val();
    

            // วันที่/เวลา (แผน)
            var datestartplan = '';
           

            // วันที่/เวลา เริ่มขับ P5
            if (checkClient == 'MB') {
                var datestartplanp5 = $("#txt_datestartplan_p5").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartplanp5chk  = $("#txt_datestartplan_p5").val();
                var datestartplanp51    = datestartplanp5chk.replace(" ","T"); // replave " " เป็น "T"
                var datestartplanp52    = datestartplanp51.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartplanp5     = datestartplanp52;
                
            }

            // วันที่/เวลาจอด 4 hurs P5
            if (checkClient == 'MB') {
                var parkngtime_plan_4hurs_p5 = $("#txt_parkingtime_plan_4hur_p5").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_4hurs_p5chk     = $("#txt_parkingtime_plan_4hur_p5").val();
                var parkngtime_plan_4hurs_p51       = parkngtime_plan_4hurs_p5chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_4hurs_p52       = parkngtime_plan_4hurs_p51.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_4hurs_p5        = parkngtime_plan_4hurs_p52;
                
            }


            // วันที่/เวลาออก 4 hurs P5
            if (checkClient == 'MB') {
                var departuretime_plan_4hurs_p5 = $("#txt_departuretime_plan_4hur_p5").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_4hurs_p5chk     = $("#txt_departuretime_plan_4hur_p5").val();
                var departuretime_plan_4hurs_p51       = departuretime_plan_4hurs_p5chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_4hurs_p52       = departuretime_plan_4hurs_p51.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_4hurs_p5        = departuretime_plan_4hurs_p52;
                
            }

            // วันที่/เวลาจอด 2 hurs P5
            if (checkClient == 'MB') {
                var parkngtime_plan_2hurs_p5 = $("#txt_parkingtime_plan_2hur_p5").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_2hurs_p5chk     = $("#txt_parkingtime_plan_2hur_p5").val();
                var parkngtime_plan_2hurs_p51       = parkngtime_plan_2hurs_p5chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_2hurs_p52       = parkngtime_plan_2hurs_p51.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_2hurs_p5        = parkngtime_plan_2hurs_p52;
                
            }


            // วันที่/เวลาออก 2 hurs P5
            if (checkClient == 'MB') {
                var departuretime_plan_2hurs_p5 = $("#txt_departuretime_plan_2hur_p5").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_2hurs_p5chk     = $("#txt_departuretime_plan_2hur_p5").val();
                var departuretime_plan_2hurs_p51       = departuretime_plan_2hurs_p5chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_2hurs_p52       = departuretime_plan_2hurs_p51.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_2hurs_p5        = departuretime_plan_2hurs_p52;
                
            }
            /////////////////////////////////////////////////////////////////////
            
            // Parameter ของ ACTUAL
            
            var jobstartactual              = '';
            var drivernameactualp5          = $("#txt_drivernameactual_p5").val();
            var location4huractualp5        = $("#txt_location_actual_4hur_p5").val();
            var location2huractualp5        = $("#txt_location_actual_2hur_p5").val();
    

            // วันที่/เวลา (วิ่งจริง)
            
                var datestartactual = '';
            

            // วันที่/เวลา เริ่มขับ P4 ACTUAL
            if (checkClient == 'MB') {
                var datestartactualp5 = $("#txt_datestartactual_p5").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartactualp5chk  = $("#txt_datestartactual_p5").val();
                var datestartactualp51    = datestartactualp5chk.replace(" ","T"); // replave " " เป็น "T"
                var datestartactualp52    = datestartactualp51.replaceAll("/","-");
                // var drivingdate3       = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartactualp5     = datestartactualp52;
                
            }

            // วันที่/เวลาจอด 4 hurs P5 ACTUAL
            if (checkClient == 'MB') {
                var parkngtime_actual_4hurs_p5 = $("#txt_parkingtime_actual_4hur_p5").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_actual_4hurs_p5chk     = $("#txt_parkingtime_actual_4hur_p5").val();
                var parkngtime_actual_4hurs_p51       = parkngtime_actual_4hurs_p5chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_actual_4hurs_p52       = parkngtime_actual_4hurs_p51.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_actual_4hurs_p5        = parkngtime_actual_4hurs_p52;
                
            }


            // วันที่/เวลาออก 4 hurs P5 ACTUAL
            if (checkClient == 'MB') {
                var departuretime_actual_4hurs_p5 = $("#txt_departuretime_actual_4hur_p5").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_actual_4hurs_p5chk     = $("#txt_departuretime_actual_4hur_p5").val();
                var departuretime_actual_4hurs_p51       = departuretime_actual_4hurs_p5chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_actual_4hurs_p52       = departuretime_actual_4hurs_p51.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_actual_4hurs_p5        = departuretime_actual_4hurs_p52;
                
            }

            // วันที่/เวลาจอด 2 hurs P5 ACTUAL
            if (checkClient == 'MB') {
                var parkngtime_actual_2hurs_p5 = $("#txt_parkingtime_actual_2hur_p5").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_actual_2hurs_p5chk     = $("#txt_parkingtime_actual_2hur_p5").val();
                var parkngtime_actual_2hurs_p51       = parkngtime_actual_2hurs_p5chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_actual_2hurs_p52       = parkngtime_actual_2hurs_p51.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_actual_2hurs_p5        = parkngtime_actual_2hurs_p52;
                
            }


            // วันที่/เวลาออก 2 hurs P5 ACTUAL
            if (checkClient == 'MB') {
                var departuretime_actual_2hurs_p5 = $("#txt_departuretime_actual_2hur_p5").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_actual_2hurs_p5chk     = $("#txt_departuretime_actual_2hur_p5").val();
                var departuretime_actual_2hurs_p51       = departuretime_actual_2hurs_p5chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_actual_2hurs_p52       = departuretime_actual_2hurs_p51.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_actual_2hurs_p5        = departuretime_actual_2hurs_p52;
                
            }
            /////////////////////////////////////////////////////////////////////////////////////


            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "save_actualp5",
                    drivingpatterngoid:drivingpatterngoid,

                    condition1:'',
                    condition2:'',
                    condition3:drivernamep5,
                    condition4:datestartplanp5,
                    condition5:parkngtime_plan_4hurs_p5,
                    condition6:departuretime_plan_4hurs_p5,
                    condition7:location4hurp5,
                    condition8:parkngtime_plan_2hurs_p5,
                    condition9:departuretime_plan_2hurs_p5,
                    condition10:location2hurp5,

                    condition11:'',
                    condition12:'',
                    condition13:drivernameactualp5,
                    condition14:datestartactualp5,
                    condition15:parkngtime_actual_4hurs_p5,
                    condition16:departuretime_actual_4hurs_p5,
                    condition17:location4huractualp5,
                    condition18:parkngtime_actual_2hurs_p5,
                    condition19:departuretime_actual_2hurs_p5,
                    condition20:location2huractualp5,

                    condition21:'',
                    condition22:'',
                    condition23:'',
                    condition24:'',
                    condition25:'',
                    condition26:'',
                    condition27:'',
                    condition28:'',
                    condition29:'',
                    condition30:'',

                    condition31:'',
                    condition32:''

                },
                success: function (rs) {
                    // alert(chkid);
                    // select_searchDrivingPattern(checkdata,chkid,employeecode)

                    // alert(rs);

                    if (chkp5 == 'CONALL') {
                        // swal.fire({
                        //     title: "Success!",
                        //     text: "ยืนยันข้อมูลขาไปทั้งหมด เรียบร้อย !!!",
                        //     icon: "success",
                        //     showConfirmButton: true,
                        //     allowOutsideClick: false,
                        // });    
                    }else{
                        swal.fire({
                            title: "Success!",
                            text: "ยืนยันข้อมูล (ช่วงที่5) เรียบร้อย !!!",
                            icon: "success",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    }
                    

                    
                }
            });
        }

        /////////////////////////////////////////////////////////////////////////
        function confirmdatap6(checkClient,chkp6){

            var confirmby   = $("#txt_username").val();
            var drivingpatterngoid = '<?=$_GET['drivinggoplanid']?>';

            // alert(drivingpatterngoid);
            // alert(confirmby);

            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "save_confirm_p6",
                    employeecode:'',
                    condition1:drivingpatterngoid ,
                    condition2:confirmby ,
                    condition3:'',
                    condition4:'',
                    condition5:'',
                },
                success: function (rs) {
                    // alert(chkid);
                    // select_searchDrivingPattern(checkdata,chkid,employeecode)

                    // alert(rs);
                    // swal.fire({
                    //     title: "Success!",
                    //     text: "ลงข้อมูลช่วงที่ 6 เรียบร้อย !!!",
                    //     icon: "success",
                    //     showConfirmButton: true,
                    //     allowOutsideClick: false,
                    // });

                    let text = rs;
                    const myArray = text.split("|");

                    
                    // alert(replacetext); 
                    document.getElementById('txt_confirm_p6').value = myArray[0]; 
                    document.getElementById('txt_dateconfirm_p6').value = myArray[1]; 

                    save_actualp6(drivingpatterngoid,checkClient,chkp6);
                }
            }); 
        }

        function save_actualp6(checkGoId,checkClient,chkp6) {
            
            // alert('actual save P6');
            
            // Parameter ของ PLAN
            var drivingpatterngoid   = checkGoId;
            var jobstartplan         = '';
            var drivernamep6         = $("#txt_drivernameplan_p6").val();
            var location4hurp6       = $("#txt_location_plan_4hur_p6").val();
            var location2hurp6       = $("#txt_location_plan_2hur_p6").val();
    

            // วันที่/เวลา (แผน)
            var datestartplan = '';
           

            // วันที่/เวลา เริ่มขับ P6
            if (checkClient == 'MB') {
                var datestartplanp6 = $("#txt_datestartplan_p6").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartplanp6chk  = $("#txt_datestartplan_p6").val();
                var datestartplanp61    = datestartplanp6chk.replace(" ","T"); // replave " " เป็น "T"
                var datestartplanp62    = datestartplanp61.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartplanp6     = datestartplanp62;
                
            }

            // วันที่/เวลาจอด 4 hurs P6
            if (checkClient == 'MB') {
                var parkngtime_plan_4hurs_p6 = $("#txt_parkingtime_plan_4hur_p6").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_4hurs_p6chk     = $("#txt_parkingtime_plan_4hur_p6").val();
                var parkngtime_plan_4hurs_p61       = parkngtime_plan_4hurs_p6chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_4hurs_p62       = parkngtime_plan_4hurs_p61.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_4hurs_p6        = parkngtime_plan_4hurs_p62;
                
            }


            // วันที่/เวลาออก 4 hurs P6
            if (checkClient == 'MB') {
                var departuretime_plan_4hurs_p6 = $("#txt_departuretime_plan_4hur_p6").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_4hurs_p6chk     = $("#txt_departuretime_plan_4hur_p6").val();
                var departuretime_plan_4hurs_p61       = departuretime_plan_4hurs_p6chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_4hurs_p62       = departuretime_plan_4hurs_p61.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_4hurs_p6        = departuretime_plan_4hurs_p62;
                
            }

            // วันที่/เวลาจอด 2 hurs P6
            if (checkClient == 'MB') {
                var parkngtime_plan_2hurs_p6 = $("#txt_parkingtime_plan_2hur_p6").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_plan_2hurs_p6chk     = $("#txt_parkingtime_plan_2hur_p6").val();
                var parkngtime_plan_2hurs_p61       = parkngtime_plan_2hurs_p6chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_plan_2hurs_p62       = parkngtime_plan_2hurs_p61.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_plan_2hurs_p6        = parkngtime_plan_2hurs_p62;
                
            }


            // วันที่/เวลาออก 2 hurs P6
            if (checkClient == 'MB') {
                var departuretime_plan_2hurs_p6 = $("#txt_departuretime_plan_2hur_p6").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_plan_2hurs_p6chk     = $("#txt_departuretime_plan_2hur_p6").val();
                var departuretime_plan_2hurs_p61       = departuretime_plan_2hurs_p6chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_plan_2hurs_p62       = departuretime_plan_2hurs_p61.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_plan_2hurs_p6        = departuretime_plan_2hurs_p62;
                
            }
            /////////////////////////////////////////////////////////////////////
            
            // Parameter ของ ACTUAL
            
            var jobstartactual              = '';
            var drivernameactualp6          = $("#txt_drivernameactual_p6").val();
            var location4huractualp6        = $("#txt_location_actual_4hur_p6").val();
            var location2huractualp6        = $("#txt_location_actual_2hur_p6").val();
    

            // วันที่/เวลา (วิ่งจริง)
            
                var datestartactual = '';
            

            // วันที่/เวลา เริ่มขับ P6 ACTUAL
            if (checkClient == 'MB') {
                var datestartactualp6 = $("#txt_datestartactual_p6").val();
                
            }else{
                // alert('else');
                //START REST
                var datestartactualp6chk  = $("#txt_datestartactual_p6").val();
                var datestartactualp61    = datestartactualp6chk.replace(" ","T"); // replave " " เป็น "T"
                var datestartactualp62    = datestartactualp61.replaceAll("/","-");
                // var drivingdate3       = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var datestartactualp6     = datestartactualp62;
                
            }

            // วันที่/เวลาจอด 4 hurs P6 ACTUAL
            if (checkClient == 'MB') {
                var parkngtime_actual_4hurs_p6 = $("#txt_parkingtime_actual_4hur_p6").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_actual_4hurs_p6chk     = $("#txt_parkingtime_actual_4hur_p6").val();
                var parkngtime_actual_4hurs_p61       = parkngtime_actual_4hurs_p6chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_actual_4hurs_p62       = parkngtime_actual_4hurs_p61.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_actual_4hurs_p6        = parkngtime_actual_4hurs_p62;
                
            }


            // วันที่/เวลาออก 4 hurs P6 ACTUAL
            if (checkClient == 'MB') {
                var departuretime_actual_4hurs_p6 = $("#txt_departuretime_actual_4hur_p6").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_actual_4hurs_p6chk     = $("#txt_departuretime_actual_4hur_p6").val();
                var departuretime_actual_4hurs_p61       = departuretime_actual_4hurs_p6chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_actual_4hurs_p62       = departuretime_actual_4hurs_p61.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_actual_4hurs_p6        = departuretime_actual_4hurs_p62;
                
            }

            // วันที่/เวลาจอด 2 hurs P6 ACTUAL
            if (checkClient == 'MB') {
                var parkngtime_actual_2hurs_p6 = $("#txt_parkingtime_actual_2hur_p6").val();
                
            }else{
                // alert('else');
                //START REST
                var parkngtime_actual_2hurs_p6chk     = $("#txt_parkingtime_actual_2hur_p6").val();
                var parkngtime_actual_2hurs_p61       = parkngtime_actual_2hurs_p6chk.replace(" ","T"); // replave " " เป็น "T"
                var parkngtime_actual_2hurs_p62       = parkngtime_actual_2hurs_p61.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkngtime_actual_2hurs_p6        = parkngtime_actual_2hurs_p62;
                
            }


            // วันที่/เวลาออก 2 hurs P6 ACTUAL
            if (checkClient == 'MB') {
                var departuretime_actual_2hurs_p6 = $("#txt_departuretime_actual_2hur_p6").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretime_actual_2hurs_p6chk     = $("#txt_departuretime_actual_2hur_p6").val();
                var departuretime_actual_2hurs_p61       = departuretime_actual_2hurs_p6chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretime_actual_2hurs_p62       = departuretime_actual_2hurs_p61.replaceAll("/","-");
                // var drivingdate3                 = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretime_actual_2hurs_p6        = departuretime_actual_2hurs_p62;
                
            }
            /////////////////////////////////////////////////////////////////////////////////////


            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "save_actualp6",
                    drivingpatterngoid:drivingpatterngoid,

                    condition1:'',
                    condition2:'',
                    condition3:drivernamep6,
                    condition4:datestartplanp6,
                    condition5:parkngtime_plan_4hurs_p6,
                    condition6:departuretime_plan_4hurs_p6,
                    condition7:location4hurp6,
                    condition8:parkngtime_plan_2hurs_p6,
                    condition9:departuretime_plan_2hurs_p6,
                    condition10:location2hurp6,

                    condition11:'',
                    condition12:'',
                    condition13:drivernameactualp6,
                    condition14:datestartactualp6,
                    condition15:parkngtime_actual_4hurs_p6,
                    condition16:departuretime_actual_4hurs_p6,
                    condition17:location4huractualp6,
                    condition18:parkngtime_actual_2hurs_p6,
                    condition19:departuretime_actual_2hurs_p6,
                    condition20:location2huractualp6,

                    condition21:'',
                    condition22:'',
                    condition23:'',
                    condition24:'',
                    condition25:'',
                    condition26:'',
                    condition27:'',
                    condition28:'',
                    condition29:'',
                    condition30:'',

                    condition31:'',
                    condition32:''
                },
                success: function (rs) {
                    // alert(chkid);
                    // select_searchDrivingPattern(checkdata,chkid,employeecode)

                    // alert(rs);
                    if (chkp6 == 'CONALL') {
                        // swal.fire({
                        //     title: "Success!",
                        //     text: "ยืนยันข้อมูลขาไปทั้งหมด เรียบร้อย !!!",
                        //     icon: "success",
                        //     showConfirmButton: true,
                        //     allowOutsideClick: false,
                        // });    
                    }else{
                        swal.fire({
                            title: "Success!",
                            text: "ยืนยันข้อมูล (ช่วงที่6) เรียบร้อย !!!",
                            icon: "success",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    }
                    

                    
                }
            });
        }
        ////////////////////////////////////////////////////////////////////////////////

        function confirmdataactualload(checkClient,chkallload){

            var confirmby   = $("#txt_username").val();
            var drivingpatterngoid = '<?=$_GET['drivinggoplanid']?>';

            // alert(drivingpatterngoid);
            // alert(confirmby);

            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "save_confirm_actualload",
                    employeecode:'',
                    condition1:drivingpatterngoid ,
                    condition2:confirmby ,
                    condition3:'',
                    condition4:'',
                    condition5:'',
                },
                success: function (rs) {
                    // alert(chkid);
                    // select_searchDrivingPattern(checkdata,chkid,employeecode)

                    // alert(rs);
                    
                    swal.fire({
                        title: "Success!",
                        text: "ลงข้อมูลโหลดรถลง เรียบร้อย !!!",
                        icon: "success",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });

                    let text = rs;
                    const myArray = text.split("|");

                    
                    // alert(replacetext); 
                    document.getElementById('txt_confirm_actualload').value = myArray[0]; 
                    document.getElementById('txt_dateconfirm_actualload').value = myArray[1]; 

                    save_actualload(drivingpatterngoid,checkClient,chkallload);
                }
            }); 
        }
        function save_actualload(checkGoId,checkClient,chkallload) {
            
            // alert('actual save actual load');
            
            // Parameter ของ PLAN
            var drivingpatterngoid   = checkGoId;

            ///////////////////////////////////////////////////////////////////
            // DEALER 1
            var dealer1plan          = $("#txt_dealer1plan").val();
            var sumtimeplandealer1   = $("#txt_sumtimedealer1plan").val();
            
            // วันที่/เวลา PLAN DEALER 1
            if (checkClient == 'MB') {
                var parkingtimeplandealer1 = $("#txt_parkingtimedealer1plan").val();
                
            }else{
                // alert('else');
                //START REST
                var parkingtimeplandealer1chk  = $("#txt_parkingtimedealer1plan").val();
                var parkingtimeplandealer11    = parkingtimeplandealer1chk.replace(" ","T"); // replave " " เป็น "T"
                var parkingtimeplandealer12    = parkingtimeplandealer11.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkingtimeplandealer1     = parkingtimeplandealer12;
                
            }

            if (checkClient == 'MB') {
                var departuretimeplandealer1 = $("#txt_departuretimedealer1plan").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretimeplandealer1chk     = $("#txt_departuretimedealer1plan").val();
                var departuretimeplandealer11chk    = departuretimeplandealer1chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretimeplandealer12chk    = departuretimeplandealer11chk.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretimeplandealer1        = departuretimeplandealer12chk;
                
            }
            //////////////////////////////////////////////////////////////////////////////////////////
            // วันที่/เวลา ACTUAL DEALER 1

            var dealer1actual           = $("#txt_dealer1actual").val();
            var sumtimeactualdealer1      = $("#txt_sumtimedealer1actual").val();
            
            // วันที่/เวลา ACTUAL DEALER 1
            if (checkClient == 'MB') {
                var parkingtimeactualdealer1 = $("#txt_parkingtimedealer1actual").val();
                
            }else{
                // alert('else');
                //START REST
                var parkingtimeactualdealer1chk  = $("#txt_parkingtimedealer1actual").val();
                var parkingtimeactualdealer11    = parkingtimeactualdealer1chk.replace(" ","T"); // replave " " เป็น "T"
                var parkingtimeactualdealer12    = parkingtimeactualdealer11.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkingtimeactualdealer1     = parkingtimeactualdealer12;
                
            }

            if (checkClient == 'MB') {
                var departuretimeactualdealer1 = $("#txt_departuretimedealer1actual").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretimeactualdealer1chk     = $("#txt_departuretimedealer1actual").val();
                var departuretimeactualdealer11chk    = departuretimeactualdealer1chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretimeactualdealer12chk    = departuretimeactualdealer11chk.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretimeactualdealer1        = departuretimeactualdealer12chk;
                
            }
            //////////////////////////////////////////////////////////////////////////////////////////////
            // DEALER 2
            var dealer2plan          = $("#txt_dealer2plan").val();
            var sumtimeplandealer2   = $("#txt_sumtimedealer2plan").val();
            
            // วันที่/เวลา PLAN DEALER 2
            if (checkClient == 'MB') {
                var parkingtimeplandealer2 = $("#txt_parkingtimedealer2plan").val();
                
            }else{
                // alert('else');
                //START REST
                var parkingtimeplandealer2chk  = $("#txt_parkingtimedealer2plan").val();
                var parkingtimeplandealer21    = parkingtimeplandealer2chk.replace(" ","T"); // replave " " เป็น "T"
                var parkingtimeplandealer22    = parkingtimeplandealer21.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkingtimeplandealer2     = parkingtimeplandealer22;
                
            }

            if (checkClient == 'MB') {
                var departuretimeplandealer2 = $("#txt_departuretimedealer2plan").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretimeplandealer2chk     = $("#txt_departuretimedealer2plan").val();
                var departuretimeplandealer21chk    = departuretimeplandealer2chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretimeplandealer22chk    = departuretimeplandealer21chk.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretimeplandealer2        = departuretimeplandealer22chk;
                
            }
            //////////////////////////////////////////////////////////////////////////////////////////
             // วันที่/เวลา ACTUAL DEALER 2

            var dealer2actual           = $("#txt_dealer2actual").val();
            var sumtimeactualdealer2      = $("#txt_sumtimedealer2actual").val();
            
            // วันที่/เวลา ACTUAL DEALER 2
            if (checkClient == 'MB') {
                var parkingtimeactualdealer2 = $("#txt_parkingtimedealer2actual").val();
                
            }else{
                // alert('else');
                //START REST
                var parkingtimeactualdealer2chk  = $("#txt_parkingtimedealer2actual").val();
                var parkingtimeactualdealer21    = parkingtimeactualdealer2chk.replace(" ","T"); // replave " " เป็น "T"
                var parkingtimeactualdealer22    = parkingtimeactualdealer21.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkingtimeactualdealer2     = parkingtimeactualdealer22;
                
            }

            if (checkClient == 'MB') {
                var departuretimeactualdealer2 = $("#txt_departuretimedealer2actual").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretimeactualdealer2chk     = $("#txt_departuretimedealer2actual").val();
                var departuretimeactualdealer21chk    = departuretimeactualdealer2chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretimeactualdealer22chk    = departuretimeactualdealer21chk.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretimeactualdealer2        = departuretimeactualdealer22chk;
                
            }
            //////////////////////////////////////////////////////////////////////////////////////////////
            // DEALER 3
            var dealer3plan          = $("#txt_dealer3plan").val();
            var sumtimeplandealer3   = $("#txt_sumtimedealer3plan").val();
            
            /////////////////////////////////////////////////////////////////////////////////////////////
            // วันที่/เวลา PLAN DEALER 3
            if (checkClient == 'MB') {
                var parkingtimeplandealer3 = $("#txt_parkingtimedealer3plan").val();
                
            }else{
                // alert('else');
                //START REST
                var parkingtimeplandealer3chk  = $("#txt_parkingtimedealer3plan").val();
                var parkingtimeplandealer31    = parkingtimeplandealer3chk.replace(" ","T"); // replave " " เป็น "T"
                var parkingtimeplandealer32    = parkingtimeplandealer31.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkingtimeplandealer3     = parkingtimeplandealer32;
                
            }

            if (checkClient == 'MB') {
                var departuretimeplandealer3 = $("#txt_departuretimedealer3plan").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretimeplandealer3chk     = $("#txt_departuretimedealer3plan").val();
                var departuretimeplandealer31chk    = departuretimeplandealer3chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretimeplandealer32chk    = departuretimeplandealer31chk.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretimeplandealer3        = departuretimeplandealer32chk;
                
            }
            //////////////////////////////////////////////////////////////////////////////////////////
             // วันที่/เวลา ACTUAL DEALER 3

            var dealer3actual           = $("#txt_dealer3actual").val();
            var sumtimeactualdealer3      = $("#txt_sumtimedealer3actual").val();
            
            // วันที่/เวลา ACTUAL DEALER 3
            if (checkClient == 'MB') {
                var parkingtimeactualdealer3 = $("#txt_parkingtimedealer3actual").val();
                
            }else{
                // alert('else');
                //START REST
                var parkingtimeactualdealer3chk  = $("#txt_parkingtimedealer3actual").val();
                var parkingtimeactualdealer31    = parkingtimeactualdealer3chk.replace(" ","T"); // replave " " เป็น "T"
                var parkingtimeactualdealer32    = parkingtimeactualdealer31.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkingtimeactualdealer3     = parkingtimeactualdealer32;
                
            }

            if (checkClient == 'MB') {
                var departuretimeactualdealer3 = $("#txt_departuretimedealer3actual").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretimeactualdealer3chk     = $("#txt_departuretimedealer3actual").val();
                var departuretimeactualdealer31chk    = departuretimeactualdealer3chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretimeactualdealer32chk    = departuretimeactualdealer31chk.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretimeactualdealer3        = departuretimeactualdealer32chk;
                
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////
            // DEALER 4
            var dealer4plan          = $("#txt_dealer4plan").val();
            var sumtimeplandealer4   = $("#txt_sumtimedealer4plan").val();
            
            /////////////////////////////////////////////////////////////////////////////

            // วันที่/เวลา PLAN DEALER 4
            if (checkClient == 'MB') {
                var parkingtimeplandealer4 = $("#txt_parkingtimedealer4plan").val();
                
            }else{
                // alert('else');
                //START REST
                var parkingtimeplandealer4chk  = $("#txt_parkingtimedealer4plan").val();
                var parkingtimeplandealer41    = parkingtimeplandealer4chk.replace(" ","T"); // replave " " เป็น "T"
                var parkingtimeplandealer42    = parkingtimeplandealer41.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkingtimeplandealer4     = parkingtimeplandealer42;
                
            }

            if (checkClient == 'MB') {
                var departuretimeplandealer4 = $("#txt_departuretimedealer4plan").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretimeplandealer4chk     = $("#txt_departuretimedealer4plan").val();
                var departuretimeplandealer41chk    = departuretimeplandealer4chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretimeplandealer42chk    = departuretimeplandealer41chk.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretimeplandealer4        = departuretimeplandealer42chk;
                
            }
            ///////////////////////////////////////////////////////////////////////////////////////////

            // วันที่/เวลา ACTUAL DEALER 4

            var dealer4actual           = $("#txt_dealer4actual").val();
            var sumtimeactualdealer4      = $("#txt_sumtimedealer4actual").val();
            
            // วันที่/เวลา ACTUAL DEALER 4
            if (checkClient == 'MB') {
                var parkingtimeactualdealer4 = $("#txt_parkingtimedealer4actual").val();
                
            }else{
                // alert('else');
                //START REST
                var parkingtimeactualdealer4chk  = $("#txt_parkingtimedealer4actual").val();
                var parkingtimeactualdealer41    = parkingtimeactualdealer4chk.replace(" ","T"); // replave " " เป็น "T"
                var parkingtimeactualdealer42    = parkingtimeactualdealer41.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var parkingtimeactualdealer4     = parkingtimeactualdealer42;
                
            }

            if (checkClient == 'MB') {
                var departuretimeactualdealer4 = $("#txt_departuretimedealer4actual").val();
                
            }else{
                // alert('else');
                //START REST
                var departuretimeactualdealer4chk     = $("#txt_departuretimedealer4actual").val();
                var departuretimeactualdealer41chk    = departuretimeactualdealer4chk.replace(" ","T"); // replave " " เป็น "T"
                var departuretimeactualdealer42chk    = departuretimeactualdealer41chk.replaceAll("/","-");
                // var drivingdate3     = drivingdate2.replace("/","-"); // replave "/" เป็น "-"
                var departuretimeactualdealer4        = departuretimeactualdealer42chk;
                
            }
            //////////////////////////////////////////////////////////////////////////////////////////////


            $.ajax({
                type: 'post',
                url: 'meg_data_drivingpattern_driver.php',
                data: {
                    txt_flg: "save_actualload",
                    drivingpatterngoid:drivingpatterngoid,

                    condition1:dealer1plan,
                    condition2:sumtimeplandealer1,
                    condition3:parkingtimeplandealer1,
                    condition4:departuretimeplandealer1,
                    condition5:dealer1actual,
                    condition6:sumtimeactualdealer1,
                    condition7:parkingtimeactualdealer1,
                    condition8:departuretimeactualdealer1,

                    condition9:dealer2plan,
                    condition10:sumtimeplandealer2,
                    condition11:parkingtimeplandealer2,
                    condition12:departuretimeplandealer2,
                    condition13:dealer2actual,
                    condition14:sumtimeactualdealer2,
                    condition15:parkingtimeactualdealer2,
                    condition16:departuretimeactualdealer2,
                    
                    condition17:dealer3plan,
                    condition18:sumtimeplandealer3,
                    condition19:parkingtimeplandealer3,
                    condition20:departuretimeplandealer3,
                    condition21:dealer3actual,
                    condition22:sumtimeactualdealer3,
                    condition23:parkingtimeactualdealer3,
                    condition24:departuretimeactualdealer3,

                    condition25:dealer4plan,
                    condition26:sumtimeplandealer4,
                    condition27:parkingtimeplandealer4,
                    condition28:departuretimeplandealer4,
                    condition29:dealer4actual,
                    condition30:sumtimeactualdealer4,
                    condition31:parkingtimeactualdealer4,
                    condition32:departuretimeactualdealer4
                },
                success: function (rs) {
                    // alert(chkid);
                    // select_searchDrivingPattern(checkdata,chkid,employeecode)

                    // alert(rs);

                    // swal.fire({
                    //     title: "Success!",
                    //     text: "ลงข้อมูลโหลดรถลง เรียบร้อย !!!",
                    //     icon: "success",
                    //     showConfirmButton: true,
                    //     allowOutsideClick: false,
                    // });
                    if (chkallload == 'CONALL') {
                        // swal.fire({
                        //     title: "Success!",
                        //     text: "ยืนยันข้อมูลขาไปทั้งหมด เรียบร้อย !!!",
                        //     icon: "success",
                        //     showConfirmButton: true,
                        //     allowOutsideClick: false,
                        // });    
                    }else{
                        swal.fire({
                            title: "Success!",
                            text: "ยืนยันข้อมูลขาไปทั้งหมด เรียบร้อย !!!",
                            icon: "success",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        }); 
                    }
                    
                }
            });
        }
        function confirm_actual_go(checkClient){

            var confirmby   = $("#txt_username").val();
            var drivingpatterngoid = '<?=$_GET['drivinggoplanid']?>';

            // alert(drivingpatterngoid);
            // alert(confirmby);

            // if ($("#txt_confirm_p1").val() == '' || $("#txt_dateconfirm_p1").val() == '') {
                
            //     swal.fire({
            //         title: "Warning!",
            //         text: "กรุณาตรวจสอบการยืนยันข้อมูล (ช่วงที่1)",
            //         icon: "warning",
            //         showConfirmButton: true,
            //         allowOutsideClick: false,
            //     });

            // }else if(($("#txt_drivernameplan_p2").val() != '') && ($("#txt_confirm_p2").val() == '' || $("#txt_dateconfirm_p2").val() == '')){
            //     swal.fire({
            //         title: "Warning!",
            //         text: "กรุณาตรวจสอบการยืนยันข้อมูล (ช่วงที่2)",
            //         icon: "warning",
            //         showConfirmButton: true,
            //         allowOutsideClick: false,
            //     });
            // }else if(($("#txt_drivernameplan_p3").val() != '') && ($("#txt_confirm_p3").val() == '' || $("#txt_dateconfirm_p3").val() == '')){
            //     swal.fire({
            //         title: "Warning!",
            //         text: "กรุณาตรวจสอบการยืนยันข้อมูล (ช่วงที่3)",
            //         icon: "warning",
            //         showConfirmButton: true,
            //         allowOutsideClick: false,
            //     });
            // }else if(($("#txt_drivernameplan_p4").val() != '') && ($("#txt_confirm_p4").val() == '' || $("#txt_dateconfirm_p4").val() == '')){
            //     swal.fire({
            //         title: "Warning!",
            //         text: "กรุณาตรวจสอบการยืนยันข้อมูล (ช่วงที่4)",
            //         icon: "warning",
            //         showConfirmButton: true,
            //         allowOutsideClick: false,
            //     });
            // }else if(($("#txt_drivernameplan_p5").val() != '') && ($("#txt_confirm_p5").val() == '' || $("#txt_dateconfirm_p5").val() == '')){
            //     swal.fire({
            //         title: "Warning!",
            //         text: "กรุณาตรวจสอบการยืนยันข้อมูล (ช่วงที่5)",
            //         icon: "warning",
            //         showConfirmButton: true,
            //         allowOutsideClick: false,
            //     });
            // }else if(($("#txt_drivernameplan_p6").val() != '') && ($("#txt_confirm_p6").val() == '' || $("#txt_dateconfirm_p6").val() == '')){
            //     swal.fire({
            //         title: "Warning!",
            //         text: "กรุณาตรวจสอบการยืนยันข้อมูล (ช่วงที่6)",
            //         icon: "warning",
            //         showConfirmButton: true,
            //         allowOutsideClick: false,
            //     });
            // }else if($("#txt_confirm_actualload").val() == '' || $("#txt_dateconfirm_actualload").val() == ''){
            //     swal.fire({
            //         title: "Warning!",
            //         text: "กรุณาตรวจสอบการยืนยันข้อมูล (โหลดรถลง)",
            //         icon: "warning",
            //         showConfirmButton: true,
            //         allowOutsideClick: false,
            //     });
            
            //     // Dealer1
            // }else if($("#txt_dealer1plan").val() != '' && $("#txt_sumtimedealer1plan").val() == ''){
            //     swal.fire({
            //         title: "Warning!",
            //         text: "กรุณาตรวจสอบการคำนวณเวลาแผนขาไป (ดีลเลอร์ 1)",
            //         icon: "warning",
            //         showConfirmButton: true,
            //         allowOutsideClick: false,
            //     });
            // }else if($("#txt_dealer1actual").val() != '' && $("#txt_sumtimedealer1actual").val() == ''){
            //     swal.fire({
            //         title: "Warning!",
            //         text: "กรุณาตรวจสอบการคำนวณเวลาวิ่งจริงขาไป (ดีลเลอร์ 1)",
            //         icon: "warning",
            //         showConfirmButton: true,
            //         allowOutsideClick: false,
            //     });

            //     //Dealer2
            // }else if($("#txt_dealer2plan").val() != '' && $("#txt_sumtimedealerlan").val() == ''){
            //     swal.fire({
            //         title: "Warning!",
            //         text: "กรุณาตรวจสอบการคำนวณเวลาแผนขาไป (ดีลเลอร์ 2",
            //         icon: "warning",
            //         showConfirmButton: true,
            //         allowOutsideClick: false,
            //     });
            // }else if($("#txt_dealer2actual").val() != '' && $("#txt_sumtimedealer2actual").val() == ''){
            //     swal.fire({
            //         title: "Warning!",
            //         text: "กรุณาตรวจสอบการคำนวณเวลาวิ่งจริงขาไป (ดีลเลอร์ 2)",
            //         icon: "warning",
            //         showConfirmButton: true,
            //         allowOutsideClick: false,
            //     });

            //     // Dealer3
            // }else if($("#txt_dealer3plan").val() != '' && $("#txt_sumtimedealer3lan").val() == ''){
            //     swal.fire({
            //         title: "Warning!",
            //         text: "กรุณาตรวจสอบการคำนวณเวลาแผนขาไป (ดีลเลอร์ 2",
            //         icon: "warning",
            //         showConfirmButton: true,
            //         allowOutsideClick: false,
            //     });
            // }else if($("#txt_dealer3actual").val() != '' && $("#txt_sumtimedealer3actual").val() == ''){
            //     swal.fire({
            //         title: "Warning!",
            //         text: "กรุณาตรวจสอบการคำนวณเวลาวิ่งจริงขาไป (ดีลเลอร์ 3)",
            //         icon: "warning",
            //         showConfirmButton: true,
            //         allowOutsideClick: false,
            //     });

            //     // Dealer4
            // }else if($("#txt_dealer4plan").val() != '' && $("#txt_sumtimedealer4lan").val() == ''){
            //     swal.fire({
            //         title: "Warning!",
            //         text: "กรุณาตรวจสอบการคำนวณเวลาแผนขาไป (ดีลเลอร์ 4",
            //         icon: "warning",
            //         showConfirmButton: true,
            //         allowOutsideClick: false,
            //     });
            // }else if($("#txt_dealer4actual").val() != '' && $("#txt_sumtimedealer4actual").val() == ''){
            //     swal.fire({
            //         title: "Warning!",
            //         text: "กรุณาตรวจสอบการคำนวณเวลาวิ่งจริงขาไป (ดีลเลอร์ 4)",
            //         icon: "warning",
            //         showConfirmButton: true,
            //         allowOutsideClick: false,
            //     });


            // }else{
                
                    $.ajax({
                        type: 'post',
                        url: 'meg_data_drivingpattern_driver.php',
                        data: {
                            txt_flg: "confirm_actual_go",
                            employeecode:'',
                            condition1:drivingpatterngoid ,
                            condition2:confirmby,
                            condition3:'',
                            condition4:'',
                            condition5:'',
                        },
                        success: function (rs) {
                            // alert(chkid);
                            // select_searchDrivingPattern(checkdata,chkid,employeecode)

                            // alert(rs);

                            // swal.fire({
                            //     title: "Success!",
                            //     text: "ลงข้อมูลโหลดรถลง เรียบร้อย !!!",
                            //     icon: "success",
                            //     showConfirmButton: true,
                            //     allowOutsideClick: false,
                            // });

                            let text = rs;
                            const myArray = text.split("|");

                            
                            
                            // alert(replacetext); 
                            document.getElementById('txt_officerconfirm').value = myArray[0]; 
                            document.getElementById('txt_datetimeofficerconfirm').value = myArray[1]; 

                            
                        }
                    }); 

                    // P1
                    if (($("#txt_drivernameplan_p1").val() != '') && ($("#txt_drivernameactual_p1").val() != '')) {
                        // alert('P1');

                        confirmdatap1('<?=$checkClient?>','CONALL');
                    }else if (($("#txt_drivernameplan_p1").val() != '') && ($("#txt_drivernameactual_p1").val() == '')){
                        swal.fire({
                            title: "Warning!",
                            text: "กรุณาตรวจสอบข้อมูลช่วงที่ 1",
                            icon: "warning",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    }else{
                        
                    }

                    // P2
                    if (($("#txt_drivernameplan_p2").val() != '') && ($("#txt_drivernameactual_p2").val() != '')) {
                        // alert('P2');

                        confirmdatap2('<?=$checkClient?>','CONALL');
                    }else if (($("#txt_drivernameplan_p2").val() != '') && ($("#txt_drivernameactual_p2").val() == '')){
                        swal.fire({
                            title: "Warning!",
                            text: "กรุณาตรวจสอบข้อมูลช่วงที่ 2",
                            icon: "warning",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    }else{
                        
                    }

                    // P3
                    if (($("#txt_drivernameplan_p3").val() != '') && ($("#txt_drivernameactual_p3").val() != '')) {
                        // alert('P3');

                        confirmdatap3('<?=$checkClient?>','CONALL');
                    }else if (($("#txt_drivernameplan_p3").val() != '') && ($("#txt_drivernameactual_p3").val() == '')){
                        swal.fire({
                            title: "Warning!",
                            text: "กรุณาตรวจสอบข้อมูลช่วงที่ 3",
                            icon: "warning",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    }else{
                        
                    }

                    // P4
                    if (($("#txt_drivernameplan_p4").val() != '') && ($("#txt_drivernameactual_p4").val() != '')) {
                        // alert('P4');

                        confirmdatap4('<?=$checkClient?>','CONALL');
                    }else if (($("#txt_drivernameplan_p4").val() != '') && ($("#txt_drivernameactual_p4").val() == '')){
                        swal.fire({
                            title: "Warning!",
                            text: "กรุณาตรวจสอบข้อมูลช่วงที่ 4",
                            icon: "warning",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    }else{
                        
                    }

                    // P5
                    if (($("#txt_drivernameplan_p5").val() != '') && ($("#txt_drivernameactual_p5").val() != '')) {
                        // alert('P5');

                        confirmdatap5('<?=$checkClient?>','CONALL');
                    }else if (($("#txt_drivernameplan_p5").val() != '') && ($("#txt_drivernameactual_p5").val() == '')){
                        swal.fire({
                            title: "Warning!",
                            text: "กรุณาตรวจสอบข้อมูลช่วงที่ 5",
                            icon: "warning",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    }else{
                        
                    }

                    // P6
                    if (($("#txt_drivernameplan_p6").val() != '') && ($("#txt_drivernameactual_p6").val() != '')) {
                        // alert('p6');

                        confirmdatap6('<?=$checkClient?>','CONALL');
                    }else if (($("#txt_drivernameplan_p6").val() != '') && ($("#txt_drivernameactual_p6").val() == '')){
                        swal.fire({
                            title: "Warning!",
                            text: "กรุณาตรวจสอบข้อมูลช่วงที่ 6",
                            icon: "warning",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    }else{
                        // swal.fire({
                        //     title: "Success!",
                        //     text: "ยืนยันข้อมูลขาไปทั้งหมด เรียบร้อย !!!",
                        //     icon: "success",
                        //     showConfirmButton: true,
                        //     allowOutsideClick: false,
                        // });   
                    }

                    // ALL LOAD
                    if (($("#txt_dealer1plan").val() != '') && ($("#txt_dealer1actual").val() != '')) {
                        // alert('p6');

                        confirmdataactualload('<?=$checkClient?>','CONALL');
                    }else if (($("#txt_dealer1plan").val() != '') && ($("#txt_dealer1actual").val() == '')){
                        swal.fire({
                            title: "Warning!",
                            text: "กรุณาตรวจสอบข้อมูลโหลดรถลง(วิ่งจริงขาไป)",
                            icon: "warning",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    }else{
                        swal.fire({
                            title: "Success!",
                            text: "ยืนยันข้อมูลขาไปทั้งหมด เรียบร้อย !!!",
                            icon: "success",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });   
                    }
            // }

            
        }

        // Auto Complete dealer plan
        var txt_dealer1plan = [<?= $dealer ?>];
        $("#txt_dealer1plan").autocomplete({
            source: [txt_dealer1plan]
        });
        
        var txt_dealer2plan = [<?= $dealer ?>];
        $("#txt_dealer2plan").autocomplete({
            source: [txt_dealer2plan]
        });

        var txt_dealer3plan = [<?= $dealer ?>];
        $("#txt_dealer3plan").autocomplete({
            source: [txt_dealer3plan]
        });

        var txt_dealer4plan = [<?= $dealer ?>];
        $("#txt_dealer4plan").autocomplete({
            source: [txt_dealer4plan]
        });

        // Auto Complete dealer actual
        var txt_dealer1actual = [<?= $dealer ?>];
        $("#txt_dealer1actual").autocomplete({
            source: [txt_dealer1actual]
        });
        
        var txt_dealer2actual = [<?= $dealer ?>];
        $("#txt_dealer2actual").autocomplete({
            source: [txt_dealer2actual]
        });

        var txt_dealer3actual = [<?= $dealer ?>];
        $("#txt_dealer3actual").autocomplete({
            source: [txt_dealer3actual]
        });

        var txt_dealer4actual = [<?= $dealer ?>];
        $("#txt_dealer4actual").autocomplete({
            source: [txt_dealer4actual]
        });

        // function showLoading() {
        //     $("#loading").show();
        
        // }

        // function hideLoading() {
        //     $("#loading").hide();
        // }
        
        // function winLoad(callback) {
        //     $("#loading").show();
        //     if (document.readyState === 'complete') {
        //         callback();
                
        //     } else {
        //         window.addEventListener("load", callback);
        //     }
        // }

        // winLoad(function() {
        // console.log('Window is loaded');
        // });
        </script>
    </body>
</html>
        