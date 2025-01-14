<!DOCTYPE html>
<?php
ob_start();
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");

if (!isset($_SESSION["USERNAME"]) || !isset($_SESSION["PASSWORD"])) {
    header("location:../pages/meg_login.php?data=3");
}

$condition1 = " AND (a.USERNAME ='" . $_SESSION["USERNAME"] . "' AND a.PASSWORD = '" . $_SESSION["PASSWORD"] . "') AND a.ACTIVESTATUS = 1";
$sql_seLogin = "{call megRoleaccount_v2(?,?)}";
$params_seLogin = array(
    array('select_roleaccount', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seLogin = sqlsrv_query($conn, $sql_seLogin, $params_seLogin);
$result_seLogin = sqlsrv_fetch_array($query_seLogin, SQLSRV_FETCH_ASSOC);

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$date1 = $result_getDate['SYSDATE'];
$start = explode("/", $date1);
$startd = $start[0];
$startif = $start[1];        
    if($startif=='01'){
        $selectmonth = "มกราคม";
        $selectmonthstart = "ม.ค.";
    }else if($startif=='02'){
        $selectmonth = "กุมภาพันธ์";
        $selectmonthstart = "ก.พ.";
    }else if($startif=='03'){
        $selectmonth = "มีนาคม";
        $selectmonthstart = "มี.ค.";
    }else if($startif=='04'){
        $selectmonth = "เมษายน";
        $selectmonthstart = "เม.ย.";
    }else if($startif=='05'){
        $selectmonth = "พฤษภาคม";
        $selectmonthstart = "พ.ค.";
    }else if($startif=='06'){
        $selectmonth = "มิถุนายน";
        $selectmonthstart = "มิ.ย.";
    }else if($startif=='07'){
        $selectmonth = "กรกฎาคม";
        $selectmonthstart = "ก.ค.";
    }else if($startif=='08'){
        $selectmonth = "สิงหาคม";
        $selectmonthstart = "ส.ค.";
    }else if($startif=='09'){
        $selectmonth = "กันยายน";
        $selectmonthstart = "ก.ย.";
    }else if($startif=='10'){
        $selectmonth = "ตุลาคม";
        $selectmonthstart = "ต.ค.";
    }else if($startif=='11'){
        $selectmonth = "พฤศจิกายน";
        $selectmonthstart = "พ.ย.";
    }else if($startif=='12'){
        $selectmonth = "ธันวาคม";
        $selectmonthstart = "ธ.ค.";
    }
$start_yen = $start[2];
$start_yth = $start[2]+543;
$start_ymd = $start[2].'-'.$start[1].'-'.$start[0];

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
                width: 100px;
            }
            .nav>li>a {
                position: relative;
                display: block;
                padding: 14px 30px;
            }
            .styled-select.slate select {
                border: 1px solid #ccc;
                font-size: 16px;
                height: 34px;
                width: 150px;
            }
        </style>
    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header" >
                <button type="button"  class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li><a href="meg_logout.php"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</a>
            </ul>
        </nav>        
        <div class="row" >
            <div class="col-lg-12" style="text-align: right">
                <center><h1><u>เบิกเงินค่าเฉลี่ยน้ำมัน (GW)</u></h1></center>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">                        
                        <ul class="nav nav-pills">
                            <li class="active">
                                <a href="#ranking" data-toggle="tab" aria-expanded="true">ข้อมูลการเติมน้ำมันพนักงาน</a>
                            </li>
                            <li>
                                <a href="#searching" data-toggle="tab">รายงานข้อมูลการเติมน้ำมันพนักงาน</a>
                            </li> 
                        </ul>                
                        <div id="overlay">
                            <div class="cv-spinner">
                                <span class="spinner"></span>
                            </div>
                            <style>
                                #overlay{
                                    position: fixed;
                                    top: 0;
                                    z-index: 100;
                                    width: 100%;
                                    height:100%;
                                    display: none;
                                    background: rgba(0,0,0,0.6);
                                }
                                .cv-spinner {
                                    height: 100%;
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                }
                                .spinner {
                                    width: 40px;
                                    height: 40px;
                                    border: 4px #ddd solid;
                                    border-top: 4px #2e93e6 solid;
                                    border-radius: 50%;
                                    animation: sp-anime 0.8s infinite linear;
                                }   
                                @keyframes sp-anime {100% {transform: rotate(360deg);}}
                                .is-hide{display:none;}
                            </style>
                        </div>
                        <div class="tab-content">
                            <div class="row">
                                <div class="col-md-12" >&nbsp;</div>
                            </div>
                            <div class="tab-pane fade active in" id="ranking">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>ช่วงวันที่เริ่มต้น</label>
                                        <input class="form-control dateen" style="background-color: #f080802e"  id="txt_datestartoilcash" name="txt_datestartoilcash" value="<?= $result_seSystime['SYSDATE'] ?>" onchange="datetodateoilcash();" placeholder="วันที่เริ่มต้น" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>ช่วงวันที่สิ้นสุด</label>
                                        <input class="form-control dateen" style="background-color: #f080802e"  id="txt_dateendoilcash" name="txt_dateendoilcash" value="<?= $result_seSystime['SYSDATE'] ?>" placeholder="วันที่สิ้นสุด" autocomplete="off">
                                    </div> 
                                </div>    
                                <div style="float: left;">                                                                        
                                    <div class="form-group">    
                                        <label>&nbsp;</label><br>                                               
                                        <button type="button" class="btn btn-primary btn-md" onclick="select_cashoil();">ค้นหา <li class="fa fa-search"></li></button>
                                    </div>
                                </div>
                                <div style="float: right;">                                                                   
                                    <div class="form-group">    
                                        <label>&nbsp;</label><br>                                               
                                        <button type="button" class="btn btn-warning btn-md" data-toggle="modal" data-target="#calrateoil"><font color="black"><b>เงื่อนไขการคิดค่าเฉลี่ยน้ำมัน</b></font></button>
                                    </div>
                                </div>    
                                
                                <!-- Modal -->
                                <div class="modal fade" id="calrateoil" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <center><u><h3>เงื่อนไขการคิดค่าเฉลี่ยน้ำมัน</h3></u></center>
                                                1.ถ้าชื่อรถ T001 - T004 <br>
                                                &nbsp;&nbsp;&nbsp;- ถ้าเป็นลูกค้า GMT &nbsp;&nbsp;- คิด 4.25 <br>
                                                &nbsp;&nbsp;&nbsp;- ถ้าไม่ใช่ลูกค้า GMT &nbsp;&nbsp;- คิด 5.00 <br>
                                                2.ถ้าชื่อรถ T005 - T009 <br>
                                                &nbsp;&nbsp;&nbsp;- คิด 4.75 <br>
                                                3.ถ้าชื่อรถ G001 - G013 <br>
                                                &nbsp;&nbsp;&nbsp;- ถ้าเป็นรถ 10W &nbsp;&nbsp;- คิด 4.25 <br>
                                                &nbsp;&nbsp;&nbsp;- ถ้าเป็นรถ 22W &nbsp;&nbsp;- คิด 3.00 <br>
                                                4.ถ้าเป็นงานรับกลับ <br>
                                                &nbsp;&nbsp;&nbsp;- คิด 3.75 <br>        
                                                5.ถ้าวิ่ง 1 เที่ยว <br>
                                                &nbsp;&nbsp;&nbsp;- เป็นงาน SH &nbsp;&nbsp;- คิด 4.25 <br>
                                                &nbsp;&nbsp;&nbsp;- เป็นงาน NM &nbsp;&nbsp;- คิด 4.25 <br>
                                                6.ถ้าวิ่ง 2 เที่ยว <br>
                                                &nbsp;&nbsp;&nbsp;- เป็นงาน SH - SH &nbsp;&nbsp;- คิด 3.75 <br>
                                                &nbsp;&nbsp;&nbsp;- เป็นงาน SH - NM &nbsp;&nbsp;- คิด 4.25 <br>
                                                &nbsp;&nbsp;&nbsp;- เป็นงาน NM - SH &nbsp;&nbsp;- คิด 3.75 <br>
                                                &nbsp;&nbsp;&nbsp;- เป็นงาน NM - NM &nbsp;&nbsp;- คิด 4.25 <br>
                                                <br>
                                                ถ้านอกเหนือจากข้อ 1 - 6 <br>
                                                &nbsp;&nbsp;&nbsp;- จะเป็นค่าเฉลี่ยที่ได้กำหนดจากระบบ <br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="data_def">
                                                <center><h3>ข้อมูลประจำวันที่ <?=$start[0].' '.$selectmonthstart.' '.$start_yth;?></h3></center>
                                                <table width="100%" class="table" >
                                                    <thead>
                                                        <tr>
                                                            <?php
                                                            $SQLPRICE = "SELECT DISTINCT OLP.PRICE, OLP.MONTH, OLP.YEAR FROM OILPEICE OLP WHERE OLP.COMPANYCODE IN('RCC','RATC','RRC') AND OLP.[YEAR] = '2023' AND OLP.[MONTH] = '$selectmonth'";
                                                            $QUERYPRICE = sqlsrv_query($conn, $SQLPRICE);
                                                            $RSPRICE = sqlsrv_fetch_array($QUERYPRICE, SQLSRV_FETCH_ASSOC);   
                                                                $PRICE=$RSPRICE["PRICE"]; 
                                                            ?>
                                                            <th colspan="10" style="text-align: right">ราคาน้ำมันเดือน <?=$selectmonth?> = <?=$PRICE?> บาท</th>
                                                            <th colspan="1" style="text-align: left"></th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                <table  style="height: 70px;" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-tablecashoil" role="grid" aria-describedby="dataTables-example_info" >
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center;width: 20px">ลำดับ</th>
                                                            <!-- <th style="text-align: center;width: 120px">สถานะการจ่ายเงิน</th> -->
                                                            <th style="text-align: center;width: 100px">วันที่เติมน้ำมัน</th>
                                                            <th style="text-align: center;width: 80px">เลขบิลน้ำมัน</th>
                                                            <th style="text-align: center;width: 70px">รหัสพนักงาน</th>
                                                            <th style="text-align: center;width: 110px">ชื่อ-สกุล</th>
                                                            <th style="text-align: center;width: 80px">ทะเบียนรถ</th>
                                                            <th style="text-align: center;width: 80px">ชื่อรถ</th>
                                                            <th style="text-align: center;width: 120px">ประเภทรถ</th>
                                                            <th style="text-align: center;width: 150px">ต้นทาง</th>
                                                            <th style="text-align: center;width: 150px">ปลายทาง</th>
                                                            <th style="text-align: center;width: 70px">ไมล์ต้น</th>
                                                            <th style="text-align: center;width: 70px">ไมล์ปลาย</th>
                                                            <th style="text-align: center;width: 60px">ระยะทาง</th>
                                                            <th style="text-align: center;width: 80px">น้ำมันที่ใช้</th>
                                                            <th style="text-align: center;width: 100px">ค่าเฉลี่ยที่ได้</th>
                                                            <th style="text-align: center;width: 120px">ค่าเฉลี่ยที่กำหนด</th>
                                                            <th style="text-align: center;width: 100px">น้ำมันที่กำหนด</th>
                                                            <th style="text-align: center;width: 100px">ส่วนต่างน้ำมัน</th>
                                                            <th style="text-align: center;width: 100px">จำนวนเงินบาท</th>
                                                            <th style="text-align: center;width: 200px">หมายเลขแผน</th>
                                                            <th style="text-align: center;width: 70px">จำนวนเที่ยว</th>
                                                            <th style="text-align: center;width: 70px">ประเภทงาน</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php     
                                                            $stmm = "SELECT DISTINCT *
                                                            FROM TEMP_CHAVGGW WHERE REFUEL = CONVERT(DATE,GETDATE()) ORDER BY OBLNB ASC";
                                                            $querystmm = sqlsrv_query($conn, $stmm );  
                                                            $i = 1;
                                                            $DTP = 0;
                                                            while($objResult = sqlsrv_fetch_array($querystmm)) {       
                                                                $REFUEL=$objResult["REFUEL"];
                                                                $CONREFUEL = explode("-", $REFUEL);
                                                                $RSREFUEL = $CONREFUEL[2].'/'.$CONREFUEL[1].'/'.$CONREFUEL[0];
                                                                if($RSREFUEL!="//"){
                                                                    $RSREFUEL=$RSREFUEL;
                                                                }else{
                                                                    $RSCHKREFUEL="";
                                                                }
                                                                $OBLNB=$objResult["OBLNB"];
                                                                $EMP=$objResult["EMP"];
                                                                $EMPN=$objResult["EMPN"];
                                                                $EMP222=$objResult["EMP222"];
                                                                $EMPN222=$objResult["EMPN222"];
                                                                $VHCRG=$objResult["VHCRG"];
                                                                $VHCTN=$objResult["VHCTN"];
                                                                $VHCTPLAN=$objResult["VHCTPLAN"];
                                                                $JOBSTART=$objResult["JOBSTART"];
                                                                $JOBEND=$objResult["JOBEND"];
                                                                $MST=$objResult["MST"]; 
                                                                $MLE=$objResult["MLE"];
                                                                $DTE=$objResult["DTE"];
                                                                $CALDTE=$MLE-$MST;
                                                                $OAM=$objResult["OAM"];
                                                                $O4=$objResult["O4"];
                                                                
                                                                // $SQLC2IF="SELECT C2IF.EMPLOYEECODE1,STRING_AGG([C2],',') AS [C2] FROM VEHICLETRANSPORTPLAN C2IF  WHERE
                                                                // ( C2IF.EMPLOYEECODE1 = '$EMP' OR C2IF.EMPLOYEECODE2 = '$EMP' ) 
                                                                // AND CONVERT ( VARCHAR ( 10 ), C2IF.DATEWORKING, 20 ) = '$DWK' AND NOT STATUSNUMBER = 'X'
                                                                // GROUP BY C2IF.EMPLOYEECODE1";
                                                                // $QUERYC2IF= sqlsrv_query($conn, $SQLC2IF );  
                                                                // $RESULTC2IF = sqlsrv_fetch_array($QUERYC2IF, SQLSRV_FETCH_ASSOC);
                                                                // $C2IF=$RESULTC2IF["C2"];

                                                                $C2IF=$objResult["C2"];
                                                                if($C2IF==','){
                                                                    $C2='';
                                                                }else if($C2IF==''){
                                                                    $C2='';
                                                                }else{
                                                                    $C2='NOTNULL';
                                                                }
                                                                $C3=$objResult["C3"];
                                                                // $OAVG=$objResult["OAVG"];
                                                                $CALOAVG=$CALDTE/$OAM;
                                                                $OAVG=number_format($CALOAVG, 2);
                                                                
                                                                $DWK=$objResult["DWK"];   
                                                                                                
                                                                // $SQLCHKWORK="SELECT SCPT.EMPLOYEECODE1,STRING_AGG([WORKTYPE],',') AS [CHKWORK] FROM VEHICLETRANSPORTPLAN SCPT  WHERE
                                                                // ( SCPT.EMPLOYEECODE1 = '$EMP' OR SCPT.EMPLOYEECODE2 = '$EMP' ) 
                                                                // AND CONVERT ( VARCHAR ( 10 ), SCPT.DATEWORKING, 20 ) = '$DWK' AND NOT STATUSNUMBER = 'X'
                                                                // GROUP BY SCPT.EMPLOYEECODE1";
                                                                // $QUERYCHKWORK= sqlsrv_query($conn, $SQLCHKWORK );  
                                                                // $RESULTCHKWORK = sqlsrv_fetch_array($QUERYCHKWORK, SQLSRV_FETCH_ASSOC);
                                                                // $CHKWORK=$RESULTCHKWORK["CHKWORK"]; 
                                                                $CHKWORK=$objResult["CHKWORK"]; 
                                                                
                                                                if($CHKWORK==","){$CHKWORKIF="";}else if($CHKWORK==",,"){$CHKWORKIF="";}else if($CHKWORK==",,,"){$CHKWORKIF="";}else if($CHKWORK==",,,,"){$CHKWORKIF="";}else{$CHKWORKIF=$CHKWORK;}
                                                                
                                                                $CHKW = explode(",", $CHKWORK);
                                                                $RSCHKW1 = $CHKW[0];
                                                                $RSCHKW2 = $CHKW[1];
                                                                $RSCHKW3 = $CHKW[2];
                                                                $RSCHKW4 = $CHKW[3];

                                                                $VHCTPPCOM=$objResult["VHCTPPCOM"];
                                                                $VHCTPPCUS=$objResult["VHCTPPCUS"];
                                                                                                            
                                                                // $SQLCHKROUND="SELECT COUNT( VHCTPP.EMPLOYEECODE1 ) COUNTROUNDAMOUT FROM VEHICLETRANSPORTPLAN VHCTPP 
                                                                // WHERE (VHCTPP.EMPLOYEECODE1 = '$EMP' OR VHCTPP.EMPLOYEECODE2 = '$EMP') AND CONVERT ( VARCHAR ( 10 ), VHCTPP.DATEWORKING, 20 ) = '$DWK' AND NOT STATUSNUMBER = 'X'";
                                                                // $QUERYROUND = sqlsrv_query($conn, $SQLCHKROUND );  
                                                                // // while($objResult = sqlsrv_fetch_array($querystmm)) {
                                                                // $RESULTROUND = sqlsrv_fetch_array($QUERYROUND, SQLSRV_FETCH_ASSOC);
                                                                // $CALROUND=$RESULTROUND["COUNTROUNDAMOUT"];
                                                                $CALROUND=$objResult["COUNTROUNDAMOUT"];
                                                                
                                                                if(($VHCTN=='T-001')||($VHCTN=='T-002')||($VHCTN=='T-003')||($VHCTN=='T-004')){     // ชื่อรถ T001 - T004
                                                                    if($VHCTPPCUS=='GMT'){                                                              // ถ้าเป็นลูกค้า GMT
                                                                        $RSCHKWORKAVG='4.25';                                                               // คิด 4.25
                                                                    }else{                                                                              // ถ้าไม่ใช่ลูกค้า GMT
                                                                        $RSCHKWORKAVG='5.00';                                                               // คิด 5.00
                                                                    }                                                                                     
                                                                }else if(($VHCTN=='T-005')||($VHCTN=='T-006')||($VHCTN=='T-007')||($VHCTN=='T-008')||($VHCTN=='T-009')){    // ชื่อรถ T001 - T004
                                                                    $RSCHKWORKAVG='4.75';                                                                                            // คิด 4.75
                                                                }else if(($VHCTN=='G-001')||($VHCTN=='G-002')||($VHCTN=='G-003')||($VHCTN=='G-004')||($VHCTN=='G-005')||
                                                                        ($VHCTN=='G-006')||($VHCTN=='G-007')||($VHCTN=='G-008')||($VHCTN=='G-009')||($VHCTN=='G-010')||
                                                                        ($VHCTN=='G-011')||($VHCTN=='G-012')||($VHCTN=='G-013')){                                           // ชื่อรถ G001 - G0013
                                                                    if($VHCTPLAN=="10W(Dump)"){                                                                                 // ถ้าเป็นรถ 10W
                                                                        $RSCHKWORKAVG='4.25';                                                                                       // คิด 4.25
                                                                    }else if($VHCTPLAN=="22W(Dump)"){                                                                           // ถ้าเป็นรถ 22W
                                                                        $RSCHKWORKAVG='3.00';                                                                                       // คิด 3.00
                                                                    } 
                                                                }else if($C2!=""){                                          // ถ้าเป็นงานรับกลับ
                                                                    $RSCHKWORKAVG='3.75';                                       // คิด 3.75
                                                                }else{
                                                                    if(($CALROUND=='1')){                                   // 1 เที่ยว
                                                                        if($RSCHKW1=='sh'){
                                                                            $RSCHKWORKAVG='4.25';                               // sh = 3.75 // แก้เป็น 4.25 วันที่ 6/9/2023
                                                                        }else if($RSCHKW1=='nm'){
                                                                            $RSCHKWORKAVG='4.25';                               // nm = 4.25 
                                                                        }else{
                                                                            $RSCHKWORKAVG=$objResult["OTG"];                // เรทปกติจากระบบ 
                                                                        }
                                                                    }else if($CALROUND=='2'){                               // 2 เที่ยว                                                                   
                                                                        if(($RSCHKW1=='sh')&&($RSCHKW2=='sh')){ 
                                                                            $RSCHKWORKAVG='3.75';                               // sh-sh = 3.75
                                                                        }else if(($RSCHKW1=='sh')&&($RSCHKW2=='nm')){
                                                                            $RSCHKWORKAVG='4.25';                               // sh-nm = 4.25
                                                                        }else if(($RSCHKW1=='nm')&&($RSCHKW2=='sh')){
                                                                            $RSCHKWORKAVG='3.75';                               // nm-sh = 3.75  
                                                                        }else if(($RSCHKW1=='nm')&&($RSCHKW2=='nm')){
                                                                            $RSCHKWORKAVG='4.25';                               // nm-nm = 4.25                                                                        
                                                                        }else{
                                                                            $RSCHKWORKAVG=$objResult["OTG"]; // เรทปกติจากระบบ                                                                    
                                                                        }
                                                                    }else{
                                                                        $RSCHKWORKAVG=$objResult["OTG"]; // เรทปกติจากระบบ                                                                    
                                                                    }
                                                                }
                                                                
                                                                $OTG=$objResult["OTG"];
                                                                $CALOTG=$CALDTE/$RSCHKWORKAVG;
                                                                $CALDO=$CALOTG-$OAM;
                                                                $DIFFOIL=round($CALDO);                                                           
                                                                $DIFFOIL2=number_format($DIFFOIL, 0);

                                                                
                                                                $EMP=$objResult["EMP"];
                                                                $EMP222=$objResult["EMP222"];
                                                                // echo 'คนที่ 1 '.$EMP.'<br>';
                                                                // echo 'คนที่ 2 '.$EMP222.'<br>';
                                                                if($EMP222==$EMP){
                                                                    $CALPRICE=$DIFFOIL2*$PRICE;
                                                                    // echo 'รหัส 1 ตรงกับรหัส 2 = ส่วนต่าง*ราคา = '.$CALPRICE.'<br>';
                                                                }else if($EMP222!=$EMP){
                                                                    if($EMP222!=""){
                                                                        $CALPRICE=($DIFFOIL2*$PRICE)/2;
                                                                        // echo 'รหัส 1 ไม่ตรงกับรหัส 2 = (ส่วนต่าง*ราคา)/2 = '.$CALPRICE.'<br>';
                                                                    }else{
                                                                        $CALPRICE=$DIFFOIL2*$PRICE;
                                                                        // echo 'รหัส 1 ไม่ตรงกับรหัส 2 แต่ไปคนเดียว = ส่วนต่าง*ราคา = '.$CALPRICE.'<br>';
                                                                    }
                                                                }

                                                                $CONFIRM=$objResult["CONFIRM"];
                                                                $WDOAVG_CREATE_DATE=$objResult["WDOAVG_CREATE_DATE"];
                                                                $WDOAVG_CAD = explode("-", $WDOAVG_CREATE_DATE);
                                                                if($CONFIRM!=""){
                                                                    $RSCAD=$WDOAVG_CAD[2].'/'.$WDOAVG_CAD[1].'/'.$WDOAVG_CAD[0];
                                                                }else{
                                                                    $RSCAD="";
                                                                }
                                                                
                                                                $OILID=$objResult["OILID"];
                                                                $VHCTPPID=$objResult["VHCTPPID"];
                                                                $CNB=$objResult["CNB"];
                                                                $VHCTOIL=$objResult["VHCTOIL"];
                                                                $ENGY=$objResult["ENGY"];
                                                                $WORKTYPE=$objResult["WORKTYPE"];
                                                                $ROUNDAMOUNT=$objResult["ROUNDAMOUNT"];
                                                                $JNOIL=$objResult["JNOIL"];
                                                                $JNPLAN=$objResult["JNPLAN"];                                                                

                                                                $WDOAVG_ID=$objResult["WDOAVG_ID"];      
                                                                if($WDOAVG_ID==""){
                                                                    $RSWDOAVG_ID = 'style="text-align: center;background-color: #F79646"';
                                                                }else if($WDOAVG_ID!=""){
                                                                    $RSWDOAVG_ID = 'style="text-align: center;background-color: #449D44"';
                                                                }
                                                        ?>
                                                        <tr>
                                                            <td style="text-align: center;"><?=$i?></td>
                                                            <!-- <td <?=$RSWDOAVG_ID?>>
                                                                <?php if($WDOAVG_ID==""){ ?> 
                                                                    <a href="javascript:;"
                                                                        data-refuel="<?=$RSREFUEL;?>"
                                                                        data-jnplan="<?=$JNPLAN;?>"
                                                                        data-oblnb="<?=$OBLNB;?>"
                                                                        data-empn="<?=$EMPN;?>"
                                                                        data-vhcrg="<?=$VHCRG;?>"
                                                                        data-jobend="<?=$JOBEND;?>"
                                                                        data-vhcth="<?=$VHCTN;?>"
                                                                        data-oam="<?=$OAM;?>"
                                                                        data-calprice="<?=number_format($CALPRICE, 2);?>"
                                                                        data-mst="<?=$MST;?>"
                                                                        data-mle="<?=$MLE;?>"
                                                                        data-caldte="<?=$CALDTE;?>"
                                                                        data-emp="<?=$EMP;?>"
                                                                        data-vhcttpid="<?=$VHCTPPID;?>"
                                                                        data-oilid="<?=$OILID;?>"
                                                                        data-oavg="<?=$OAVG;?>"
                                                                        data-otg="<?=$OTG;?>"
                                                                        data-calotg="<?=number_format($CALOTG, 2);?>"
                                                                        data-diffoil="<?=number_format($DIFFOIL, 2);?>"
                                                                        data-status="1"
                                                                        data-session="<?=$_SESSION["USERNAME"];?>"
                                                                        data-toggle="modal" data-target="#CONFIRM_APPROVE"><font color="black"><b> รอจ่าย</b></font>
                                                                    </a>  
                                                                <?php }else if($WDOAVG_ID!=""){ ?> 
                                                                    <a href="#" data-toggle="modal" data-target="#DETAILPLANTOTAL_<?=$DTP?>"><font color="black"><b> จ่ายแล้ว</b></font></a>
                                                                <?php } ?>  
                                                            </td> -->
                                                            <td style="text-align: center;"><?=$RSREFUEL?></td>
                                                            <td style="text-align: center;"><?=$OBLNB?></td>
                                                            <td style="text-align: center;"><?=$EMP?></td>
                                                            <td style="text-align: left;"><?=$EMPN?></td>
                                                            <td style="text-align: center;"><?=$VHCRG?></td>
                                                            <td style="text-align: center;"><?=$VHCTN?></td>
                                                            <td style="text-align: center;"><?=$VHCTPLAN?></td>
                                                            <td style="text-align: center;"><?=$JOBSTART?></td>
                                                            <td style="text-align: center;"><?=$JOBEND?></td>
                                                            <td style="text-align: center;"><?=$MST?></td>
                                                            <td style="text-align: center;"><?=$MLE?></td>
                                                            <td style="text-align: center;"><?=$CALDTE?></td>
                                                            <td style="text-align: center;"><?=$OAM?></td>
                                                            <td style="text-align: center;"><?=$OAVG?></td>
                                                            <td style="text-align: center;"><?=$RSCHKWORKAVG?></td>
                                                            <td style="text-align: center;"><?=number_format($CALOTG, 2)?></td>
                                                            <td style="text-align: center;"><?=number_format($DIFFOIL, 2)?></td>
                                                            <td style="text-align: center;"><?=number_format($CALPRICE, 2)?></td>
                                                            <td style="text-align: center;"><?=$JNPLAN?></td>
                                                            <td style="text-align: center;"><?=$CALROUND?></td>
                                                            <td style="text-align: center;"><?=$CHKWORKIF?></td>
                                                        </tr>                                                                
                                                        <div class="modal fade" id="DETAILPLANTOTAL_<?=$DTP?>"><!-- data-backdrop="static" -->
                                                            <div class="modal-dialog modal-dialog-centered modal-md">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">รายละเอียด : <small><?=$JNPLAN?></small></h4>
                                                                    </div>
                                                                    <div class="modal-body">                                                                                
                                                                        <div class="row">
                                                                            <!-- <form name="form1" action="meg_cashoilaverage_save.php" target="_blank" method="post"> -->
                                                                            <form id="fupForm" name="form1" method="post">
                                                                                <div class="col-lg-6">
                                                                                    <p class="col-xl-6 text-muted"><b>วันที่เติมน้ำมัน : <?=$RSREFUEL?></b></p>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <p class="col-xl-6 text-muted"><b>รหัสพนักงาน : <?=$EMP?></b></p>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <p class="col-xl-6 text-muted"><b>เลขบิลน้ำมัน : <?=$OBLNB?></b></p>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <p class="col-xl-6 text-muted"><b>ชื่อ-สกุล : <?=$EMPN?></b></p>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <p class="col-xl-6 text-muted"><b>ทะเบียนรถ : <?=$VHCRG?></b></p>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <p class="col-xl-6 text-muted"><b>งานที่ขนส่ง : <?=$JOBEND?></b></p>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <p class="col-xl-6 text-muted"><b>ชื่อรถ : <?=$VHCTN?></b></p>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <p class="col-xl-6 text-muted"><b>ระยะทาง : <?=$CALDTE?></b></p>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <p class="col-xl-6 text-muted"><b>น้ำมันที่ใช้ : <?=$OAM?></b></p>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <p class="col-xl-6 text-muted"><b>จำนวนเงิน : <?=number_format($CALPRICE, 2)?></b></p>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <p class="col-xl-6 text-muted"><b>ผู้จ่ายเงิน : <?=$CONFIRM?></b></p>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <p class="col-xl-6 text-muted"><b>วันที่จ่ายเงิน : <?=$RSCAD?></b></p>
                                                                                </div>
                                                                            </div>                                                                                    
                                                                            <input type="hidden" name="WDOAVG_OAM" id="WDOAVG_OAM" value="<?=$OAM;?>">
                                                                            <input type="hidden" name="WDOAVG_PRICE" id="WDOAVG_PRICE" value="<?=number_format($CALPRICE, 2);?>">
                                                                            <input type="hidden" name="WDOAVG_DISTANCE" id="WDOAVG_DISTANCE" value="<?=$CALDTE;?>">
                                                                            <input type="hidden" name="WDOAVG_PERSONCODE" id="WDOAVG_PERSONCODE" value="<?=$EMP;?>">
                                                                            <input type="hidden" name="WDOAVG_PLANID" id="WDOAVG_PLANID" value="<?=$VHCTPPID;?>">
                                                                            <input type="hidden" name="WDOAVG_OILTATID" id="WDOAVG_OILTATID" value="<?=$OILID;?>">
                                                                            <input type="hidden" name="WDOAVG_OAVG" id="WDOAVG_OAVG" value="<?=$OAVG;?>">
                                                                            <input type="hidden" name="WDOAVG_OAVGTG" id="WDOAVG_OAVGTG" value="<?=$OTG;?>">
                                                                            <input type="hidden" name="WDOAVG_OILTG" id="WDOAVG_OILTG" value="<?=number_format($CALOTG, 2);?>">
                                                                            <input type="hidden" name="WDOAVG_DIFFOIL" id="WDOAVG_DIFFOIL" value="<?=number_format($DIFFOIL, 2);?>">
                                                                            <input type="hidden" name="WDOAVG_STATUS" id="WDOAVG_STATUS" value="1">
                                                                            <input type="hidden" name="username" id="username" value="<?=$_SESSION["USERNAME"];?>">
                                                                            <center>                               
                                                                                    <div class="col-12">
                                                                                        <!-- <button type="submit" class="btn btn-success btn-md" name="updatejob" onclick="updateoiltatsuno()" value="updatejob" id="butupdate">ยืนยันการจ่ายเงิน</button>&nbsp;&nbsp;&nbsp;&nbsp; -->
                                                                                        <button type="button" class="btn btn-danger btn-md" data-dismiss="modal" onClick="javascript:location.reload();">ยกเลิก</button>
                                                                                    </div>
                                                                            </center>   
                                                                        </form>                                                                             
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php $DTP++; $i++; } ?>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="data_sr"></div>
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                    <!-- /.panel -->
                                </div>
                            </div>
                            <div class="tab-pane" id="searching">
                                <div class="col-lg-12">
                                    <!-- <form action="meg_cashoilaverage_report.php" method="post" target="_blank">
                                        <u><h3>ข้อมูลเบิกเงินค่าเฉลี่ยน้ำมัน (GW)</h3></u><br>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่เริ่มต้น</label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_datestartoilcashreport" name="txt_datestartoilcashreport" value="<?= $result_seSystime['SYSDATE'] ?>" onchange="datetodateoilcashreport();" placeholder="วันที่เริ่มต้น" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่สิ้นสุด</label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_dateendoilcashreport" name="txt_dateendoilcashreport" value="<?= $result_seSystime['SYSDATE'] ?>" placeholder="วันที่สิ้นสุด" autocomplete="off">
                                            </div> 
                                        </div>                                    
                                        <div class="col-lg-3">
                                            <label>สายงาน</label>
                                            <select id="selcustomer2" name="selcustomer2" class="form-control select2" required>
                                                <option value disabled selected>-เลือกสายงาน-</option>
                                                <option value="REPORT1">RCC - (TTT)</option>
                                                <option value="REPORT2">RRC - (BP/GMT/GMT-IB)</option>
                                                <option value="REPORT3">RRC - (TTAST/TTTC)</option>
                                                <option value="REPORT4">RATC - (TTT)</option>
                                            </select>
                                        </div>
                                        <div class="form-group">    
                                            <label>&nbsp;</label><br>                                               
                                            <button type="submit" class="btn btn-success btn-md" name="EXCELCASH" value="EXCELCASH"><b>Excel</b> <li class="fa fa-file-excel-o" ></button>
                                        </div>
                                    </form>    -->
                                    <form action="report_refuelrecord_gw_export.php" method="post" target="_blank">
                                        <u><h3>ข้อมูลประจำวัน</h3></u><br>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่เริ่มต้น</label>
                                                <input class="form-control dateen1" style="background-color: #f080802e"  id="txt_datestartoil" name="txt_datestartoil" value="<?= $result_seSystime['SYSDATE'] ?>" onchange="datetodateoil();" placeholder="วันที่เริ่มต้น" autocomplete="off">
                                            </div>
                                        </div> 
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่สิ้นสุด</label>
                                                <input class="form-control dateen1" style="background-color: #f080802e"  id="txt_dateendoil" name="txt_dateendoil" value="<?= $result_seSystime['SYSDATE'] ?>" placeholder="วันที่สิ้นสุด" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>บริษัท</label>
                                            <select id="selcompany" name="selcompany" class="form-control" onchange ="selcompanyDiv(this)" required>
                                                <option value disabled selected>-เลือกบริษัท-</option>
                                                <!-- <option value="ALL">เลือกทั้งหมด</option> -->
                                                <option value="RRC">RRC | บริษัท ร่วมกิจ รีไซเคิล แคริเออร์</option>
                                                <option value="RATC">RATC | บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต</option>
                                                <option value="RCC">RCC | บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์</option>
                                                <!-- <option value="CENTER">รถส่วนกลาง</option> -->
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>ลูกค้า</label>         
                                            <div id="first" style="display:block">
                                                <select name="selcustomer" id="selcustomer" data-placeholder="เลือกลูกค้า" class="form-control">
                                                    <option value disabled selected>-เลือกลูกค้า-</option>
                                                </select>
                                            </div>
                                            <div id="show_all" style="display:none">
                                                <select name="selcustomer" id="selcustomer" data-placeholder="เลือกลูกค้า" class="form-control">
                                                    <option value="ALL">เลือกทั้งหมด</option>
                                                </select>
                                            </div>
                                            <div id="show_rrc" style="display:none">
                                                <select name="selcustomer" id="selcustomer" data-placeholder="เลือกลูกค้า" class="form-control">
                                                    <option value disabled selected>-เลือกลูกค้า-</option>
                                                    <option value="GMT">GMT</option>
                                                    <option value="TTAST">TTAST</option>
                                                </select>
                                            </div>
                                            <div id="show_ratc" style="display:none">
                                                <select name="selcustomer" id="selcustomer" data-placeholder="เลือกลูกค้า" class="form-control">
                                                    <option value disabled selected>-เลือกลูกค้า-</option>
                                                    <option value="TTT8">TTT (8L)</option>
                                                </select>
                                            </div>
                                            <div id="show_rcc" style="display:none">
                                                <select name="selcustomer" id="selcustomer" data-placeholder="เลือกลูกค้า" class="form-control">
                                                    <option value disabled selected>-เลือกลูกค้า-</option>
                                                    <option value="TTT4">TTT (4L)</option>
                                                    <option value="TTT8">TTT (8L)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-lg-2" > -->
                                            <label>&nbsp;</label><br>
                                            <button type="submit" class="btn btn-success btn-md" name="EXCEL" value="EXCEL"><b>Excel</b> <li class="fa fa-file-excel-o" ></button>
                                            <!-- <a href="report_refuelrecord_export.php" title="Excel" class="btn btn-success" target="_blank"><b>Excel</b> <li class="fa fa-file-excel-o" ></li></a> -->
                                            <!-- &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-danger btn-md" name="PDF" value="PDF"><b>PDF</b> <li class="fa fa-file-pdf-o" ></button> -->
                                            <!-- <a href="report_refuelrecord_pdf.php" title="PDF" class="btn btn-danger" target="_blank"><b>PDF</b> <li class="fa fa-file-pdf-o" ></li></a> -->
                                        <!-- </div> -->
                                    </form>
                                    <form action="report_refuelrecord_gw_export_month.php" method="post" target="_blank">
                                        <hr>
                                        <u><h3>ข้อมูลประจำเดือน</h3></u><br>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่เริ่มต้น <!-- <font color="red"><small>*07:00</small></font> --> </label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_datestartoilmonth" name="txt_datestartoilmonth" value="<?= $result_seSystime['SYSDATE'] ?>" onchange="datetodateoilmonth();" placeholder="วันที่เริ่มต้น" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่สิ้นสุด <!-- <font color="red"><small>*07:00</small></font> --> </label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_dateendoilmonth" name="txt_dateendoilmonth" value="<?= $result_seSystime['SYSDATE'] ?>" placeholder="วันที่สิ้นสุด" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>บริษัท</label>
                                            <select id="selcompany2" name="selcompany2" class="form-control" onchange ="selcompanyDiv2(this)" required>
                                                <option value disabled selected>-เลือกบริษัท-</option>
                                                <option value="RRC">RRC | บริษัท ร่วมกิจ รีไซเคิล แคริเออร์</option>
                                                <option value="RATC">RATC | บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต</option>
                                                <option value="RCC">RCC | บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์</option>
                                            </select>
                                        </div> 
                                        <div class="col-lg-2">
                                            <label>ลูกค้า</label>         
                                            <div id="first2" style="display:block">
                                                <select name="selcustomer2" id="selcustomer2" data-placeholder="เลือกลูกค้า" class="form-control">
                                                    <option value disabled selected>-เลือกลูกค้า-</option>
                                                </select>
                                            </div>
                                            <div id="show_all2" style="display:none">
                                                <select name="selcustomer2" id="selcustomer2" data-placeholder="เลือกลูกค้า" class="form-control">
                                                    <option value="ALL">เลือกทั้งหมด</option>
                                                </select>
                                            </div>
                                            <div id="show_rrc2" style="display:none">
                                                <select name="selcustomer2" id="selcustomer2" data-placeholder="เลือกลูกค้า" class="form-control">
                                                    <option value disabled selected>-เลือกลูกค้า-</option>
                                                    <option value="GMT">GMT</option>
                                                    <option value="TTAST">TTAST</option>
                                                </select>
                                            </div>
                                            <div id="show_ratc2" style="display:none">
                                                <select name="selcustomer2" id="selcustomer2" data-placeholder="เลือกลูกค้า" class="form-control">
                                                    <option value disabled selected>-เลือกลูกค้า-</option>
                                                    <option value="TTT8">TTT (8L)</option>
                                                </select>
                                            </div>
                                            <div id="show_rcc2" style="display:none">
                                                <select name="selcustomer2" id="selcustomer2" data-placeholder="เลือกลูกค้า" class="form-control">
                                                    <option value disabled selected>-เลือกลูกค้า-</option>
                                                    <option value="TTT4">TTT (4L)</option>
                                                    <option value="TTT8">TTT (8L)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">    
                                            <label>&nbsp;</label><br>                                               
                                            <button type="submit" class="btn btn-success btn-md" name="EXCELMONTH" value="EXCELMONTH"><b>Excel</b> <li class="fa fa-file-excel-o" ></button>
                                            <!-- &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-danger btn-md" name="PDFMONTH" value="PDFMONTH"><b>PDF</b> <li class="fa fa-file-pdf-o" ></button> -->
                                        </div>
                                    </form>
                                    <form action="report_refuelrecord_gw_export_vhct.php" method="post" target="_blank">
                                        <hr>
                                        <u><h3>แยกประเภทรถ</h3></u><br>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>วันที่เริ่มต้นแผนวิ่งงาน</label>
                                                <input class="form-control dateen1" style="background-color: #f080802e"  id="txt_datestartoilvhct" name="txt_datestartoilvhct" value="<?= $result_seSystime['SYSDATE'] ?>" onchange="datetodateoilvhct();" placeholder="วันที่เริ่มต้น" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>วันที่สิ้นสุดแผนวิ่งงาน</label>
                                                <input class="form-control dateen1" style="background-color: #f080802e"  id="txt_dateendoilvhct" name="txt_dateendoilvhct" value="<?= $result_seSystime['SYSDATE'] ?>" placeholder="วันที่สิ้นสุด" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group">    
                                            <label>&nbsp;</label><br>                                               
                                            <button type="submit" class="btn btn-success btn-md" name="EXCELVHCT" value="EXCELVHCT"><b>Excel</b> <li class="fa fa-file-excel-o" ></button>
                                            <!-- &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-danger btn-md" name="PDFVHCT" value="PDFVHCT"><b>PDF</b> <li class="fa fa-file-pdf-o" ></button> -->
                                        </div>
                                    </form>                         
                                    <form action="report_refuelrecord_gw_export_outside.php" method="post" target="_blank">
                                        <hr>
                                        <h3><u>ข้อมูลเติมน้ำมันปั๊มนอก</u> <small><font color="red">***ดึงข้อมูลตามวันที่เติมน้ำมัน</font></small></h3><br>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่เริ่มต้น</label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_datestartoiloutside" name="txt_datestartoiloutside" value="<?= $result_seSystime['SYSDATE'] ?>" onchange="datetodateoiloutside();" placeholder="วันที่เริ่มต้น" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่สิ้นสุด</label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_dateendoiloutside" name="txt_dateendoiloutside" value="<?= $result_seSystime['SYSDATE'] ?>" placeholder="วันที่สิ้นสุด" autocomplete="off">
                                            </div> 
                                        </div>
                                        <!-- <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>เลือกเดือน</label>
                                                <?php 
                                                    $mydate=getdate(date("U"));
                                                    $MYYEAR=$mydate["year"];
                                                    $MYIF=$mydate["mon"];
                                                    if($MYIF < 10){
                                                        $MYMONTH='0'.$MYIF;
                                                    }else{
                                                        $MYMONTH=$MYIF;
                                                    }
                                                    $CONVERTYM=$MYYEAR.'-'.$MYMONTH;
                                                ?>
                                                <input class="form-control" type="month" style="background-color: #f080802e"  name="txt_dateoiloutside" value="<?=$CONVERTYM;?>" required>
                                            </div> 
                                        </div> -->
                                        </script>
                                        <!-- <div class="col-lg-2"> -->
                                            <div class="form-group">    
                                                <label>&nbsp;</label><br>                                               
                                                <button type="submit" class="btn btn-success btn-md" name="EXCELOUTSIDE" value="EXCELOUTSIDE"><b>Excel</b> <li class="fa fa-file-excel-o" ></button>
                                            </div>
                                        <!-- </div> -->
                                    </form> 
                                    <form action="report_refuelrecord_gw_export_avgday.php" method="post" target="_blank">
                                        <hr>
                                        <u><h3>สรุปค่าเฉลี่ยน้ำมันรายเดือน</h3></u><br>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่เริ่มต้น</label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_datestartoilmonthavarage" name="txt_datestartoilmonthavarage" value="<?= $result_seSystime['SYSDATE'] ?>" onchange="datetodateoilmonthavarage();" placeholder="วันที่เริ่มต้น" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ช่วงวันที่สิ้นสุด</label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_dateendoilmonthavarage" name="txt_dateendoilmonthavarage" value="<?= $result_seSystime['SYSDATE'] ?>" placeholder="วันที่สิ้นสุด" autocomplete="off">
                                            </div>  
                                        </div>
                                        <div class="col-lg-3">
                                            <label>กลุ่มข้อมูล</label>
                                            <select id="lineofworkmonth" name="lineofworkmonth" class="form-control select2" required>
                                                <option value disabled selected>---เลือกกลุ่มข้อมูล---</option>
                                                <option value="RRC1">RRC | GMT</option>
                                                <option value="RRC2">RRC | TTAST</option>
                                                <option value="RATC1">RATC | TTT(8L)</option>
                                                <option value="RCC1">RCC | TTT(4L)</option>
                                                <option value="RCC2">RCC | TTT(8L)</option>
                                            </select>
                                        </div>        
                                        <div class="form-group">                        
                                                <label>&nbsp;</label><br>                                               
                                                <!-- <button type="button" class="btn btn-primary btn-md" onclick="select_oilmonthavarage();">ค้นหา <li class="fa fa-search"></li></button>
                                                &nbsp;&nbsp;&nbsp;                                              -->
                                                <button type="submit" class="btn btn-success btn-md" name="EXCELDAY" value="EXCELDAY"><li class="fa fa-file-excel-o"></li> <b>Excel ข้อมูลรายวัน</b></button>
                                                &nbsp;&nbsp;&nbsp;                                             
                                                <button type="submit" class="btn btn-success btn-md" name="EXCELMONTH" value="EXCELMONTH"><li class="fa fa-file-excel-o"></li> <b>Excel สรุปข้อมูลรายเดือน</b></button>
                                        </div> 
                                    </form>  
                                </div>
                            </div>
                        </div>
                        <center>
                        <button type="button" class="btn btn-default btn-md" data-dismiss="modal" onClick="javascript:location.reload();">อัพเดท</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL CONFIRM_APPROVE -->
        <div class="modal fade" id="CONFIRM_APPROVE"><!-- data-backdrop="static" -->
            <div class="modal-dialog modal-dialog-centered modal-lg" ><!--  modal-dialog-centered modal-xl -->
                <div class="modal-content">   
                    <div class="modal-header">
                        <h4 class="modal-title">รายละเอียด : <small>
                                        <label id="JNPLAN"></label></small></h4>
                    </div>   
                    <div class="modal-body">                      
                        <form id="CONFIRMAPPROVETAB1">
                            <div class="row">
                                <div class="form-group col-md-12">   
                                    <div class="col-lg-4"><p></p>
                                        <b>รหัสพนักงาน :</b>
                                        <input type="text" class="form-control" name="WDOAVG_PERSONCODE" id="WDOAVG_PERSONCODE" readonly>
                                    </div>            
                                    <div class="col-lg-4"><p></p>
                                        <b>วันที่เติมน้ำมัน :</b>
                                        <input type="text" class="form-control" name="RSREFUEL" id="RSREFUEL" readonly>
                                    </div>
                                    <div class="col-lg-4"><p></p>
                                        <b>เลขบิลน้ำมัน :</b>
                                        <input type="text" class="form-control" name="OBLNB" id="OBLNB" readonly>
                                    </div>
                                    <div class="col-lg-4"><p></p>
                                        <b>ชื่อ-สกุล :</b>
                                        <input type="text" class="form-control" name="EMPN" id="EMPN" readonly>
                                    </div>
                                    <div class="col-lg-4"><p></p>
                                        <b>ทะเบียนรถ :</b>
                                        <input type="text" class="form-control" name="VHCRG" id="VHCRG" readonly>
                                    </div>
                                    <div class="col-lg-4"><p></p>
                                        <b>ชื่อรถ :</b>
                                        <input type="text" class="form-control" name="VHCTN" id="VHCTN" readonly>
                                    </div>
                                    <div class="col-lg-4"><p></p>
                                        <b>งานที่ขนส่ง :</b>
                                        <input type="text" class="form-control" name="JOBEND" id="JOBEND" readonly>
                                    </div>
                                    <div class="col-lg-4"><p></p>
                                        <b>เลขไมล์ต้น :</b>
                                        <input type="text" class="form-control" name="WDOAVG_MST" id="WDOAVG_MST" readonly>
                                    </div>
                                    <div class="col-lg-4"><p></p>
                                        <b>เลขไมล์ปลาย :</b>
                                        <input type="text" class="form-control" name="WDOAVG_MLE" id="WDOAVG_MLE" readonly>
                                    </div>
                                    <div class="col-lg-4"><p></p>
                                        <b>ระยะทาง :</b>
                                        <input type="text" class="form-control" name="WDOAVG_DISTANCE" id="WDOAVG_DISTANCE" readonly>
                                    </div>
                                    <div class="col-lg-4"><p></p>
                                        <b>น้ำมันที่ใช้ :</b>
                                        <input type="text" class="form-control" name="WDOAVG_OAM" id="WDOAVG_OAM" readonly>
                                    </div>
                                    <div class="col-lg-4"><p></p>
                                        <b>จำนวนเงิน :</b>
                                        <input type="text" class="form-control" name="WDOAVG_PRICE" id="WDOAVG_PRICE" readonly>
                                    </div>
                                </div>                        
                                        <input type="hidden" class="form-control" name="WDOAVG_PLANID" id="WDOAVG_PLANID" readonly>
                                        <input type="hidden" class="form-control" name="WDOAVG_OILTATID" id="WDOAVG_OILTATID" readonly>
                                        <input type="hidden" class="form-control" name="WDOAVG_OAVG" id="WDOAVG_OAVG" readonly>
                                        <input type="hidden" class="form-control" name="WDOAVG_OAVGTG" id="WDOAVG_OAVGTG" readonly>
                                        <input type="hidden" class="form-control" name="WDOAVG_OILTG" id="WDOAVG_OILTG" readonly>
                                        <input type="hidden" class="form-control" name="WDOAVG_DIFFOIL" id="WDOAVG_DIFFOIL" readonly>
                                        <input type="hidden" class="form-control" name="WDOAVG_STATUS" id="WDOAVG_STATUS" readonly>
                                        <input type="hidden" class="form-control" name="username" id="username" readonly>
                            </div>
                        <center>
                            <div class="col-12">
                                <button type="submit" class="btn btn-success btn-md" name="updatejob" value="updatejob" id="butupdate">ยืนยันการจ่ายเงิน</button>&nbsp;&nbsp;&nbsp;&nbsp;
                                <button type="button" class="btn btn-danger btn-md" data-dismiss="modal" onClick="javascript:location.reload();">ยกเลิก</button>
                            </div>
                        </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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

    <script>
        function select_cashoil(){
            $(document).ajaxSend(function() {
                $("#overlay").fadeIn(300);　
            });
            $.ajax({
                type: 'post',
                url: 'meg_data2.php',
                data: {
                    txt_flg: "select_cashoil", 
                    datestartoil: document.getElementById('txt_datestartoilcash').value, 
                    dateendoil: document.getElementById('txt_dateendoilcash').value                                                                                                   
                },
                success: function (response) {
                    if (response){
                        document.getElementById("data_sr").innerHTML = response;
                        document.getElementById("data_def").innerHTML = "";
                        setTimeout(function(){$("#overlay").fadeOut(300);},500);
                    }save_logprocess('Cash Oil Avarage', 'Select Cash Oil Avarage', '<?= $result_seLogin['PersonCode'] ?>');
                    $(function () {
                        $('[data-toggle="popover"]').popover({
                            html: true,
                            content: function () {
                                return $('#popover-content').html();
                            }
                        });
                    })
                    $(document).ready(function () {
                        $('#dataTables-tablecashoil').DataTable({
                            order: [[0, "asc"]],
                            scrollX: true
                        });
                    });
                }
            });
        }
        function save_logprocess(category, process, employeecode){
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
        // CONFIRM_APPROVE
        $('#CONFIRM_APPROVE').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
            modal.find('#RSREFUEL').attr("value",div.data('refuel'));
            modal.find('#JNPLAN').text(div.data('jnplan'));
            modal.find('#OBLNB').attr("value",div.data('oblnb'));
            modal.find('#EMPN').attr("value",div.data('empn'));
            modal.find('#VHCRG').attr("value",div.data('vhcrg'));
            modal.find('#JOBEND').attr("value",div.data('jobend'));
            modal.find('#VHCTN').attr("value",div.data('vhcth'));        
            modal.find('#WDOAVG_OAM').attr("value",div.data('oam'));
            modal.find('#WDOAVG_PRICE').attr("value",div.data('calprice'));
            modal.find('#WDOAVG_MST').attr("value",div.data('mst'));
            modal.find('#WDOAVG_MLE').attr("value",div.data('mle'));
            modal.find('#WDOAVG_DISTANCE').attr("value",div.data('caldte'));
            modal.find('#WDOAVG_PERSONCODE').attr("value",div.data('emp'));
            modal.find('#WDOAVG_PLANID').attr("value",div.data('vhcttpid'));
            modal.find('#WDOAVG_OILTATID').attr("value",div.data('oilid'));
            modal.find('#WDOAVG_OAVG').attr("value",div.data('oavg'));    
            modal.find('#WDOAVG_OAVGTG').attr("value",div.data('otg'));   
            modal.find('#WDOAVG_OILTG').attr("value",div.data('calotg'));   
            modal.find('#WDOAVG_DIFFOIL').attr("value",div.data('diffoil'));   
            modal.find('#WDOAVG_STATUS').attr("value",div.data('status'));   
            modal.find('#username').attr("value",div.data('session'));  
        });          
        // CONFIRMAPPROVETAB1
        $(function () {
            $('#CONFIRMAPPROVETAB1').on('submit', function (e) {
                e.preventDefault()
                $.ajax({
                    type: 'POST',
                    url: 'meg_cashoilaverage_save.php',
                    data: $(this).serialize()
                }).done(function (resp, textStatus, jqXHR) {
                    alert("บันทึกข้อมูลเรียบร้อย");
                    location.assign('');
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    alert("Error occured !");
                })
            })
        })     
        function updateoiltatsuno(){	     
            var oam = $('#WDOAVG_OAM').val();
            var price = $('#WDOAVG_PRICE').val();
            var distance = $('#WDOAVG_DISTANCE').val();
            var personcode = $('#WDOAVG_PERSONCODE').val();
            var planid = $('#WDOAVG_PLANID').val();
            var oiltatid = $('#WDOAVG_OILTATID').val();
            var oavg = $('#WDOAVG_OAVG').val();
            var oavgtg = $('#WDOAVG_OAVGTG').val();
            var oiltg = $('#WDOAVG_OILTG').val();
            var diffoil = $('#WDOAVG_DIFFOIL').val();
            var status = $('#WDOAVG_STATUS').val();
            var username = $('#username').val();
            var butupdate = $('#butupdate').val();  
            // alert(personcode);
            $.ajax({
                url: "meg_cashoilaverage_save.php",
                type: "POST",
                data: {
                    planid: planid,
                    oiltatid: oiltatid,
                    personcode: personcode,
                    distance: distance,
                    oam: oam,
                    oavg: oavg,
                    oavgtg: oavgtg,
                    oiltg: oiltg,
                    diffoil: diffoil,
                    price: price,
                    status: status,
                    username: username,
                    butupdate: butupdate			
                },                    
                cache: false,
                success: function(dataResult){
                        alert("บันทึกข้อมูลเรียบร้อย");
                        location.assign('');
                    var dataResult = JSON.parse(dataResult);
                    if(dataResult.statusCode==200){	
                        $('#fupForm').find('input:text').val('');
                        $("#success").show();
                        $('#success').html('Data added successfully !');					
                    }
                    else if(dataResult.statusCode==201){
                        alert("Error occured !");
                    }                                
                }
            });
        }
        function datetodateoilcash(){
            document.getElementById('txt_dateendoilcash').value = document.getElementById('txt_datestartoilcash').value;
        }
        function datetodateoilcashreport(){
            document.getElementById('txt_dateendoilcashreport').value = document.getElementById('txt_datestartoilcashreport').value;
        }
        function datetodateoil(){
            document.getElementById('txt_dateendoil').value = document.getElementById('txt_datestartoil').value;
        }
        function datetodateoilmonth(){
            document.getElementById('txt_dateendoilmonth').value = document.getElementById('txt_datestartoilmonth').value;
        }
        function datetodateoilvhct(){
            document.getElementById('txt_dateendoilvhct').value = document.getElementById('txt_datestartoilvhct').value;
        }
        function datetodateoiloutside(){
            document.getElementById('txt_dateendoiloutside').value = document.getElementById('txt_datestartoiloutside').value;
        }
        $(document).ready(function () {
            $('#dataTables-tablecashoil').DataTable({
                order: [[2, "asc"]],
                scrollX: true
            });
        });
        $(function(){
            var CID_TAB1Object = $('#selcompany');
            var CSID_TAB1Object = $('#selcustomer');
            // on change CCID_TAB1
            CID_TAB1Object.on('change', function(){
                var CCID_TAB1Id = $(this).val();
                CSID_TAB1Object.html('<option value="ALL">เลือกทั้งหมด</option>');
                $.get('report_refuelrecord_customer_get.php?customercode=' + CCID_TAB1Id, function(data){
                    var result = JSON.parse(data);
                    $.each(result, function(index, item){
                        CSID_TAB1Object.append(
                            $('<option></option>').val(item.CUSTOMERCODE).html(item.CUSTOMERCODE)
                        );
                    });
                });
            });
        });
        $(function(){
            var CID_TAB2Object = $('#selcompany2');
            var CSID_TAB2Object = $('#selcustomer2');
            CID_TAB2Object.on('change', function(){
                var CCID_TAB2Id = $(this).val();
                CSID_TAB2Object.html('<option value disabled selected>-เลือกลูกค้า-</option>');
                $.get('report_refuelrecord_customer_get.php?customercode=' + CCID_TAB2Id, function(data){
                    var result = JSON.parse(data);
                    $.each(result, function(index, item){
                        CSID_TAB2Object.append(
                            $('<option></option>').val(item.CUSTOMERCODE).html(item.CUSTOMERCODE)
                        );
                    });
                });
            });
        });
        $(function () {
            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            // กรณีใช้แบบ input
            $(".dateen").datetimepicker({
                timepicker: false,
                format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            });
        });
        $(function () {
            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            // กรณีใช้แบบ input
            $(".dateen1").datetimepicker({
                timepicker: true,
                format: 'd/m/Y H:i', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            });
        });
    </script>
    <script>
        
        function datetodateoil()
        {
            document.getElementById('txt_dateendoil').value = document.getElementById('txt_datestartoil').value;
        }
        $(document).ready(function () {
            $('#dataTables-oiltat').DataTable({
                order: [[2, "asc"]],
                scrollX: true
            });
        });
    </script>




</html>
<?php
sqlsrv_close($conn);
?>
