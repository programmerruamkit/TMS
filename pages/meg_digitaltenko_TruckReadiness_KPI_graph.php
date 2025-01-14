<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");


// $sql_seEmpName = "SELECT  nameT,PersonCode FROM EMPLOYEEEHR2
// WHERE PersonCode ='".$_GET['employeecode']."'";
// $params_seEmpName = array();
// $query_seEmpName = sqlsrv_query($conn, $sql_seEmpName, $params_seEmpName);
// $result_seEmpName = sqlsrv_fetch_array($query_seEmpName, SQLSRV_FETCH_ASSOC);


$strDate = $_GET['month'];
function DateThai($strDate)
{
$strMonth= date("n",strtotime($strDate));
$strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$strMonthThai=$strMonthCut[$strMonth];
return "$strMonthThai";
}

// echo $strDate = date("Y/m/d");
// echo "ThaiCreate.Com Time now : ".DateThai($strDate);
// $month =  date("Y"); // month ส่งให้เลือกเดือน


$monthnumeric = $_GET['monthnumeric'];
$month = $_GET['month'];
$years = $_GET['years'];


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
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="../vendor/jquery/jquery.min.js"></script>

        <style>

            .navbar-default {

                border-color: #ffcb0b;
            }
            #page-wrapper {

                border-left: 1px solid #ffcb0b;
            }
            .sidebar ul li a.active {
                background-color: #ffffff;
            }
            body {

                background-color: #fff;
            }
        </style>
        <style>

        </style>
    </head>

    <body>

        <div id="wrapper">


            <div id="page-wrapper" style="color: #666">
                <div class="row" >
                    <div class="col-lg-12">

                        <h2 class="page-header"><i class="fa fa-bar-chart-o fa-fw"></i>  
                        กราฟข้อมูล KPI </b>
                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row" >
                    <div class="panel-body">
                        <!-- <div class="col-lg-2">
                            <label>ค้นหาข้อมูลกราฟข้อมูลสุขภาพ</label>
                            <select id="select_month" name="select_month" class="form-control" >
                                <option value="">เลือกเดือน</option>
                                <option value="01/01/<?=$month?>">มกราคม</option>
                                <option value="01/02/<?=$month?>">กุมภาพันธ์</option>
                                <option value="01/03/<?=$month?>">มีนาคม</option>
                                <option value="01/04/<?=$month?>">เมษายน</option>
                                <option value="01/05/<?=$month?>">พฤษภาคม</option>
                                <option value="01/06/<?=$month?>">มิถุนายน</option>
                                <option value="01/07/<?=$month?>">กรกฎาคม</option>
                                <option value="01/08/<?=$month?>">สิงหาคม</option>
                                <option value="01/09/<?=$month?>">กันยายน</option>
                                <option value="01/10/<?=$month?>">ตุลาคม</option>
                                <option value="01/11/<?=$month?>">พฤศจิกายน</option>
                                <option value="01/12/<?=$month?>">ธันวาคม</option>
                            </select>
                        </div>
                        <div class="col-lg-1">
                            <label>&nbsp;</label>
                            <div class="form-group">
                                <button type="button" class="btn btn-default" onclick="select_graph();">ค้นหาข้อมูล <li class="fa fa-search"></li></button>
                            </div>

                        </div> -->
                        

                    </div>
                    <!-- /.col-lg-12 -->
                    
                </div>
                <br>
                <!-- START ROW1 -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> กราฟข้อมูลสุขภาพพนักงาน

                            </div> -->
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                            <!-- START ROW ตารางแสดงข้อมูล -->
                            
                            <div class="col-lg-12" style="text-align: center;">
                                <label>&nbsp;</label>
                                <!-- <div class="form-group">
                                    <button type="button" class="btn btn-default" onclick="select_graphtest();">ทดสอบกราฟ <li class="fa fa-search"></li></button>
                                </div> -->
                                <input type="text" display="none"  id="txt_monthnumberic" name="txt_monthnumberic" value="<?=$monthnumeric?>" style="display: none;">
                                <input type="text" display="none" id="txt_month" name="txt_month" value="<?=$month?>" style="display: none;">
                                <input type="text" display="none" id="txt_years" name="txt_years" value="<?=$years?>" style="display: none;">
                                <div style="align: center;">
                                    
                                        <button type="button" name="check_graph" id="check_graph" onclick ="check_graph();" class="btn btn-success btn-lg">Export Graph To PDF</button>
                                    
                                </div>    
                            </div>     

                            <!-- START ROW ความดันค่าบน ค่าล่าง-->
                                <div class="row">
                                    <div class="col-lg-12" style="text-align:center;">
                                        <h2 class="page-header"><i class="fa fa-bar-chart-o fa-fw"></i>  
                                            กราฟข้อมูล KPI ประจำเดือน:&nbsp;<b><?=DateThai($strDate)?></b></b>
                                            <input type="hidden" id="txt_empcode" name="txt_empcode" value="<?=$_GET['employeecode']?>" ></imput>
                                        </h2>
                                    </div>                           
                                    <div class="col-lg-12">


                                         <?php
                                        // ค้นหาวันแรกของเดือนปัจจุบัน
                                        $sql_seDatestart = "SELECT FORMAT (DATEADD(MONTH, DATEDIFF(MONTH, 0, GETDATE()), 0), 'dd/MM/yyyy') AS 'DS'";
                                        $params_seDatestart = array();
                                        $query_seDatestart = sqlsrv_query($conn, $sql_seDatestart, $params_seDatestart);
                                        $result_seDatestart = sqlsrv_fetch_array($query_seDatestart, SQLSRV_FETCH_ASSOC);

                                        $sql_seAdddateweek = "{call megGetdate_v2(?,?)}";
                                        $params_seAdddateweek = array(
                                            array('select_dategraph', SQLSRV_PARAM_IN),
                                            array($result_seDatestart['DS'], SQLSRV_PARAM_IN)
                                        );
                                        $query_seAdddateweek = sqlsrv_query($conn, $sql_seAdddateweek, $params_seAdddateweek);
                                        $result_seAdddateweek = sqlsrv_fetch_array($query_seAdddateweek, SQLSRV_FETCH_ASSOC);
                                        //echo $result_seAdddateweek['D1'] . '|' . $result_seAdddateweek['D2'] . '|' . $result_seAdddateweek['D3'] . '|' . $result_seAdddateweek['D4'] . '|' . $result_seAdddateweek['D5'] . '|' . $result_seAdddateweek['D6'] . '|' . $result_seAdddateweek['D7'];
                                        
                                        /////////////////QUERY ค้นหาข้อมูล///////////////////////////////////////////////////
                                        //TRUCK ATTEND
                                        $sql_setruckatt = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend1',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend2',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend3',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend4',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend5',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend6',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend7',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend8',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend9',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend10',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend11',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend12',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend13',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend14',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend15',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend16',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend17',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend18',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend19',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend20',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend21',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend22',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend23',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend24',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend25',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend26',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend27',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend28',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend29',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend30',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAtt' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttend31'";
                                        $params_setruckatt = array();
                                        $query_setruckatt = sqlsrv_query($conn, $sql_setruckatt, $params_setruckatt);
                                        $result_setruckatt = sqlsrv_fetch_array($query_setruckatt, SQLSRV_FETCH_ASSOC);

                                        if ($result_setruckatt['TruckAttend1'] == '' || $result_setruckatt['TruckAttend1'] == NULL) {
                                            $TruckAttend1 = '0';
                                        }else{
                                            $TruckAttend1 = $result_setruckatt['TruckAttend1'];
                                        }

                                        if ($result_setruckatt['TruckAttend2'] == '' || $result_setruckatt['TruckAttend2'] == NULL) {
                                            $TruckAttend2 = '0';
                                        }else{
                                            $TruckAttend2 = $result_setruckatt['TruckAttend2'];
                                        }

                                        if ($result_setruckatt['TruckAttend3'] == '' || $result_setruckatt['TruckAttend3'] == NULL) {
                                            $TruckAttend3 = '0';
                                        }else{
                                            $TruckAttend3 = $result_setruckatt['TruckAttend3'];
                                        }

                                        if ($result_setruckatt['TruckAttend4'] == '' || $result_setruckatt['TruckAttend4'] == NULL) {
                                            $TruckAttend4 = '0';
                                        }else{
                                            $TruckAttend4 = $result_setruckatt['TruckAttend4'];
                                        }

                                        if ($result_setruckatt['TruckAttend5'] == '' || $result_setruckatt['TruckAttend5'] == NULL) {
                                            $TruckAttend5 = '0';
                                        }else{
                                            $TruckAttend5 = $result_setruckatt['TruckAttend5'];
                                        }

                                        if ($result_setruckatt['TruckAttend6'] == '' || $result_setruckatt['TruckAttend6'] == NULL) {
                                            $TruckAttend6 = '0';
                                        }else{
                                            $TruckAttend6 = $result_setruckatt['TruckAttend6'];
                                        }

                                        if ($result_setruckatt['TruckAttend7'] == '' || $result_setruckatt['TruckAttend7'] == NULL) {
                                            $TruckAttend7 = '0';
                                        }else{
                                            $TruckAttend7 = $result_setruckatt['TruckAttend7'];
                                        }

                                        if ($result_setruckatt['TruckAttend8'] == '' || $result_setruckatt['TruckAttend8'] == NULL) {
                                            $TruckAttend8 = '0';
                                        }else{
                                            $TruckAttend8 = $result_setruckatt['TruckAttend8'];
                                        }

                                        if ($result_setruckatt['TruckAttend9'] == '' || $result_setruckatt['TruckAttend9'] == NULL) {
                                            $TruckAttend9 = '0';
                                        }else{
                                            $TruckAttend9 = $result_setruckatt['TruckAttend9'];
                                        }

                                        if ($result_setruckatt['TruckAttend10'] == '' || $result_setruckatt['TruckAttend10'] == NULL) {
                                            $TruckAttend10 = '0';
                                        }else{
                                            $TruckAttend10 = $result_setruckatt['TruckAttend10'];
                                        }

                                        if ($result_setruckatt['TruckAttend11'] == '' || $result_setruckatt['TruckAttend11'] == NULL) {
                                            $TruckAttend11 = '0';
                                        }else{
                                            $TruckAttend11 = $result_setruckatt['TruckAttend11'];
                                        }

                                        if ($result_setruckatt['TruckAttend12'] == '' || $result_setruckatt['TruckAttend12'] == NULL) {
                                            $TruckAttend12 = '0';
                                        }else{
                                            $TruckAttend12 = $result_setruckatt['TruckAttend12'];
                                        }

                                        if ($result_setruckatt['TruckAttend13'] == '' || $result_setruckatt['TruckAttend13'] == NULL) {
                                            $TruckAttend13 = '0';
                                        }else{
                                            $TruckAttend13 = $result_setruckatt['TruckAttend13'];
                                        }

                                        if ($result_setruckatt['TruckAttend14'] == '' || $result_setruckatt['TruckAttend14'] == NULL) {
                                            $TruckAttend14 = '0';
                                        }else{
                                            $TruckAttend14 = $result_setruckatt['TruckAttend14'];
                                        }

                                        if ($result_setruckatt['TruckAttend15'] == '' || $result_setruckatt['TruckAttend15'] == NULL) {
                                            $TruckAttend15 = '0';
                                        }else{
                                            $TruckAttend15 = $result_setruckatt['TruckAttend15'];
                                        }

                                        if ($result_setruckatt['TruckAttend16'] == '' || $result_setruckatt['TruckAttend16'] == NULL) {
                                            $TruckAttend16 = '0';
                                        }else{
                                            $TruckAttend16 = $result_setruckatt['TruckAttend16'];
                                        }

                                        if ($result_setruckatt['TruckAttend17'] == '' || $result_setruckatt['TruckAttend17'] == NULL) {
                                            $TruckAttend17 = '0';
                                        }else{
                                            $TruckAttend17 = $result_setruckatt['TruckAttend17'];
                                        }

                                        if ($result_setruckatt['TruckAttend18'] == '' || $result_setruckatt['TruckAttend18'] == NULL) {
                                            $TruckAttend18 = '0';
                                        }else{
                                            $TruckAttend18 = $result_setruckatt['TruckAttend18'];
                                        }

                                        if ($result_setruckatt['TruckAttend19'] == '' || $result_setruckatt['TruckAttend19'] == NULL) {
                                            $TruckAttend19 = '0';
                                        }else{
                                            $TruckAttend19 = $result_setruckatt['TruckAttend19'];
                                        }

                                        if ($result_setruckatt['TruckAttend20'] == '' || $result_setruckatt['TruckAttend20'] == NULL) {
                                            $TruckAttend20 = '0';
                                        }else{
                                            $TruckAttend20 = $result_setruckatt['TruckAttend20'];
                                        }

                                        if ($result_setruckatt['TruckAttend21'] == '' || $result_setruckatt['TruckAttend21'] == NULL) {
                                            $TruckAttend21 = '0';
                                        }else{
                                            $TruckAttend21 = $result_setruckatt['TruckAttend21'];
                                        }

                                        if ($result_setruckatt['TruckAttend22'] == '' || $result_setruckatt['TruckAttend22'] == NULL) {
                                            $TruckAttend22 = '0';
                                        }else{
                                            $TruckAttend22 = $result_setruckatt['TruckAttend22'];
                                        }

                                        if ($result_setruckatt['TruckAttend23'] == '' || $result_setruckatt['TruckAttend23'] == NULL) {
                                            $TruckAttend23 = '0';
                                        }else{
                                            $TruckAttend23 = $result_setruckatt['TruckAttend23'];
                                        }

                                        if ($result_setruckatt['TruckAttend24'] == '' || $result_setruckatt['TruckAttend24'] == NULL) {
                                            $TruckAttend24 = '0';
                                        }else{
                                            $TruckAttend24 = $result_setruckatt['TruckAttend24'];
                                        }

                                        if ($result_setruckatt['TruckAttend25'] == '' || $result_setruckatt['TruckAttend25'] == NULL) {
                                            $TruckAttend25 = '0';
                                        }else{
                                            $TruckAttend25 = $result_setruckatt['TruckAttend25'];
                                        }

                                        if ($result_setruckatt['TruckAttend26'] == '' || $result_setruckatt['TruckAttend26'] == NULL) {
                                            $TruckAttend26 = '0';
                                        }else{
                                            $TruckAttend26 = $result_setruckatt['TruckAttend26'];
                                        }

                                        if ($result_setruckatt['TruckAttend27'] == '' || $result_setruckatt['TruckAttend27'] == NULL) {
                                            $TruckAttend27 = '0';
                                        }else{
                                            $TruckAttend27 = $result_setruckatt['TruckAttend27'];
                                        }

                                        if ($result_setruckatt['TruckAttend28'] == '' || $result_setruckatt['TruckAttend28'] == NULL) {
                                            $TruckAttend28 = '0';
                                        }else{
                                            $TruckAttend28 = $result_setruckatt['TruckAttend28'];
                                        }

                                        if ($result_setruckatt['TruckAttend29'] == '' || $result_setruckatt['TruckAttend29'] == NULL) {
                                            $TruckAttend29 = '0';
                                        }else{
                                            $TruckAttend29 = $result_setruckatt['TruckAttend29'];
                                        }

                                        if ($result_setruckatt['TruckAttend30'] == '' || $result_setruckatt['TruckAttend30'] == NULL) {
                                            $TruckAttend30 = '0';
                                        }else{
                                            $TruckAttend30 = $result_setruckatt['TruckAttend30'];
                                        }

                                        if ($result_setruckatt['TruckAttend31'] == '' || $result_setruckatt['TruckAttend31'] == NULL) {
                                            $TruckAttend31 = '0';
                                        }else{
                                            $TruckAttend31 = $result_setruckatt['TruckAttend31'];
                                        }
                                    //////////////////////////////////////////////////////////////////////   
                                        
                                        $sql_setruckok = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK1',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK2',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK3',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK4',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK5',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK6',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK7',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK8',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK9',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK10',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK11',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK12',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK13',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK14',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK15',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK16',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK17',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK18',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK19',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK20',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK21',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK22',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK23',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK24',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK25',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK26',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK27',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK28',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK29',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK30',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckOK' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckOK31'";
                                        $params_setruckok  = array();
                                        $query_setruckok = sqlsrv_query($conn, $sql_setruckok, $params_setruckok);
                                        $result_setruckok = sqlsrv_fetch_array($query_setruckok, SQLSRV_FETCH_ASSOC);

                                        if ($result_setruckok['TruckOK1'] == '' || $result_setruckok['TruckOK1'] == NULL) {
                                            $TruckOK1 = '0';
                                        }else{
                                            $TruckOK1 = $result_setruckok['TruckOK1'];
                                        }

                                        if ($result_setruckok['TruckOK2'] == '' || $result_setruckok['TruckOK2'] == NULL) {
                                            $TruckOK2 = '0';
                                        }else{
                                            $TruckOK2 = $result_setruckok['TruckOK2'];
                                        }

                                        if ($result_setruckok['TruckOK3'] == '' || $result_setruckok['TruckOK3'] == NULL) {
                                            $TruckOK3 = '0';
                                        }else{
                                            $TruckOK3 = $result_setruckok['TruckOK3'];
                                        }

                                        if ($result_setruckok['TruckOK4'] == '' || $result_setruckok['TruckOK4'] == NULL) {
                                            $TruckOK4 = '0';
                                        }else{
                                            $TruckOK4 = $result_setruckok['TruckOK4'];
                                        }

                                        if ($result_setruckok['TruckOK5'] == '' || $result_setruckok['TruckOK5'] == NULL) {
                                            $TruckOK5 = '0';
                                        }else{
                                            $TruckOK5 = $result_setruckok['TruckOK5'];
                                        }

                                        if ($result_setruckok['TruckOK6'] == '' || $result_setruckok['TruckOK6'] == NULL) {
                                            $TruckOK6 = '0';
                                        }else{
                                            $TruckOK6 = $result_setruckok['TruckOK6'];
                                        }

                                        if ($result_setruckok['TruckOK7'] == '' || $result_setruckok['TruckOK7'] == NULL) {
                                            $TruckOK7 = '0';
                                        }else{
                                            $TruckOK7 = $result_setruckok['TruckOK7'];
                                        }

                                        if ($result_setruckok['TruckOK8'] == '' || $result_setruckok['TruckOK8'] == NULL) {
                                            $TruckOK8 = '0';
                                        }else{
                                            $TruckOK8 = $result_setruckok['TruckOK8'];
                                        }

                                        if ($result_setruckok['TruckOK9'] == '' || $result_setruckok['TruckOK9'] == NULL) {
                                            $TruckOK9 = '0';
                                        }else{
                                            $TruckOK9 = $result_setruckok['TruckOK9'];
                                        }

                                        if ($result_setruckok['TruckOK10'] == '' || $result_setruckok['TruckOK10'] == NULL) {
                                            $TruckOK10 = '0';
                                        }else{
                                            $TruckOK10 = $result_setruckok['TruckOK10'];
                                        }

                                        if ($result_setruckok['TruckOK11'] == '' || $result_setruckok['TruckOK11'] == NULL) {
                                            $TruckOK11 = '0';
                                        }else{
                                            $TruckOK11 = $result_setruckok['TruckOK11'];
                                        }

                                        if ($result_setruckok['TruckOK12'] == '' || $result_setruckok['TruckOK12'] == NULL) {
                                            $TruckOK12 = '0';
                                        }else{
                                            $TruckOK12 = $result_setruckok['TruckOK12'];
                                        }

                                        if ($result_setruckok['TruckOK13'] == '' || $result_setruckok['TruckOK13'] == NULL) {
                                            $TruckOK13 = '0';
                                        }else{
                                            $TruckOK13 = $result_setruckok['TruckOK13'];
                                        }

                                        if ($result_setruckok['TruckOK14'] == '' || $result_setruckok['TruckOK14'] == NULL) {
                                            $TruckOK14 = '0';
                                        }else{
                                            $TruckOK14 = $result_setruckok['TruckOK14'];
                                        }

                                        if ($result_setruckok['TruckOK15'] == '' || $result_setruckok['TruckOK15'] == NULL) {
                                            $TruckOK15 = '0';
                                        }else{
                                            $TruckOK15 = $result_setruckok['TruckOK15'];
                                        }

                                        if ($result_setruckok['TruckOK16'] == '' || $result_setruckok['TruckOK16'] == NULL) {
                                            $TruckOK16 = '0';
                                        }else{
                                            $TruckOK16 = $result_setruckok['TruckOK16'];
                                        }

                                        if ($result_setruckok['TruckOK17'] == '' || $result_setruckok['TruckOK17'] == NULL) {
                                            $TruckOK17 = '0';
                                        }else{
                                            $TruckOK17 = $result_setruckok['TruckOK17'];
                                        }

                                        if ($result_setruckok['TruckOK18'] == '' || $result_setruckok['TruckOK18'] == NULL) {
                                            $TruckOK18 = '0';
                                        }else{
                                            $TruckOK18 = $result_setruckok['TruckOK18'];
                                        }

                                        if ($result_setruckok['TruckOK19'] == '' || $result_setruckok['TruckOK19'] == NULL) {
                                            $TruckOK19 = '0';
                                        }else{
                                            $TruckOK19 = $result_setruckok['TruckOK19'];
                                        }

                                        if ($result_setruckok['TruckOK20'] == '' || $result_setruckok['TruckOK20'] == NULL) {
                                            $TruckOK20 = '0';
                                        }else{
                                            $TruckOK20 = $result_setruckok['TruckOK20'];
                                        }

                                        if ($result_setruckok['TruckOK21'] == '' || $result_setruckok['TruckOK21'] == NULL) {
                                            $TruckOK21 = '0';
                                        }else{
                                            $TruckOK21 = $result_setruckok['TruckOK21'];
                                        }

                                        if ($result_setruckok['TruckOK22'] == '' || $result_setruckok['TruckOK22'] == NULL) {
                                            $TruckOK22 = '0';
                                        }else{
                                            $TruckOK22 = $result_setruckok['TruckOK22'];
                                        }

                                        if ($result_setruckok['TruckOK23'] == '' || $result_setruckok['TruckOK23'] == NULL) {
                                            $TruckOK23 = '0';
                                        }else{
                                            $TruckOK23 = $result_setruckok['TruckOK23'];
                                        }

                                        if ($result_setruckok['TruckOK24'] == '' || $result_setruckok['TruckOK24'] == NULL) {
                                            $TruckOK24 = '0';
                                        }else{
                                            $TruckOK24 = $result_setruckok['TruckOK24'];
                                        }

                                        if ($result_setruckok['TruckOK25'] == '' || $result_setruckok['TruckOK25'] == NULL) {
                                            $TruckOK25 = '0';
                                        }else{
                                            $TruckOK25 = $result_setruckok['TruckOK25'];
                                        }

                                        if ($result_setruckok['TruckOK26'] == '' || $result_setruckok['TruckOK26'] == NULL) {
                                            $TruckOK26 = '0';
                                        }else{
                                            $TruckOK26 = $result_setruckok['TruckOK26'];
                                        }

                                        if ($result_setruckok['TruckOK27'] == '' || $result_setruckok['TruckOK27'] == NULL) {
                                            $TruckOK27 = '0';
                                        }else{
                                            $TruckOK27 = $result_setruckok['TruckOK27'];
                                        }

                                        if ($result_setruckok['TruckOK28'] == '' || $result_setruckok['TruckOK28'] == NULL) {
                                            $TruckOK28 = '0';
                                        }else{
                                            $TruckOK28 = $result_setruckok['TruckOK28'];
                                        }

                                        if ($result_setruckok['TruckOK29'] == '' || $result_setruckok['TruckOK29'] == NULL) {
                                            $TruckOK29 = '0';
                                        }else{
                                            $TruckOK29 = $result_setruckok['TruckOK29'];
                                        }

                                        if ($result_setruckok['TruckOK30'] == '' || $result_setruckok['TruckOK30'] == NULL) {
                                            $TruckOK30 = '0';
                                        }else{
                                            $TruckOK30 = $result_setruckok['TruckOK30'];
                                        }

                                        if ($result_setruckok['TruckOK31'] == '' || $result_setruckok['TruckOK31'] == NULL) {
                                            $TruckOK31 = '0';
                                        }else{
                                            $TruckOK31 = $result_setruckok['TruckOK31'];
                                        }
                                    //////////////////////////////////////////////////////////////////////

                                        $sql_seRequirement = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement1',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement2',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement3',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement4',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement5',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement6',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement7',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement8',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement9',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement10',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement11',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement12',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement13',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement14',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement15',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement16',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement17',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement18',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement19',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement20',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement21',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement22',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement23',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement24',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement25',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement26',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement27',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement28',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement29',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement30',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement31'";
                                        $params_seRequirement  = array();
                                        $query_seRequirement = sqlsrv_query($conn, $sql_seRequirement, $params_seRequirement);
                                        $result_seRequirement = sqlsrv_fetch_array($query_seRequirement, SQLSRV_FETCH_ASSOC);

                                        if ($result_seRequirement['Requirement1'] == '' || $result_seRequirement['Requirement1'] == NULL) {
                                            $Requirement1 = '0';
                                        }else{
                                            $Requirement1 = $result_seRequirement['Requirement1'];
                                        }

                                        if ($result_seRequirement['Requirement2'] == '' || $result_seRequirement['Requirement2'] == NULL) {
                                            $Requirement2 = '0';
                                        }else{
                                            $Requirement2 = $result_seRequirement['Requirement2'];
                                        }

                                        if ($result_seRequirement['Requirement3'] == '' || $result_seRequirement['Requirement3'] == NULL) {
                                            $Requirement3 = '0';
                                        }else{
                                            $Requirement3 = $result_seRequirement['Requirement3'];
                                        }

                                        if ($result_seRequirement['Requirement4'] == '' || $result_seRequirement['Requirement4'] == NULL) {
                                            $Requirement4 = '0';
                                        }else{
                                            $Requirement4 = $result_seRequirement['Requirement4'];
                                        }

                                        if ($result_seRequirement['Requirement5'] == '' || $result_seRequirement['Requirement5'] == NULL) {
                                            $Requirement5 = '0';
                                        }else{
                                            $Requirement5 = $result_seRequirement['Requirement5'];
                                        }

                                        if ($result_seRequirement['Requirement6'] == '' || $result_seRequirement['Requirement6'] == NULL) {
                                            $Requirement6 = '0';
                                        }else{
                                            $Requirement6 = $result_seRequirement['Requirement6'];
                                        }

                                        if ($result_seRequirement['Requirement7'] == '' || $result_seRequirement['Requirement7'] == NULL) {
                                            $Requirement7 = '0';
                                        }else{
                                            $Requirement7 = $result_seRequirement['Requirement7'];
                                        }

                                        if ($result_seRequirement['Requirement8'] == '' || $result_seRequirement['Requirement8'] == NULL) {
                                            $Requirement8 = '0';
                                        }else{
                                            $Requirement8 = $result_seRequirement['Requirement8'];
                                        }

                                        if ($result_seRequirement['Requirement9'] == '' || $result_seRequirement['Requirement9'] == NULL) {
                                            $Requirement9 = '0';
                                        }else{
                                            $Requirement9 = $result_seRequirement['Requirement9'];
                                        }

                                        if ($result_seRequirement['Requirement10'] == '' || $result_seRequirement['Requirement10'] == NULL) {
                                            $Requirement10 = '0';
                                        }else{
                                            $Requirement10 = $result_seRequirement['Requirement10'];
                                        }

                                        if ($result_seRequirement['Requirement11'] == '' || $result_seRequirement['Requirement11'] == NULL) {
                                            $Requirement11 = '0';
                                        }else{
                                            $Requirement11 = $result_seRequirement['Requirement11'];
                                        }

                                        if ($result_seRequirement['Requirement12'] == '' || $result_seRequirement['Requirement12'] == NULL) {
                                            $Requirement12 = '0';
                                        }else{
                                            $Requirement12 = $result_seRequirement['Requirement12'];
                                        }

                                        if ($result_seRequirement['Requirement13'] == '' || $result_seRequirement['Requirement13'] == NULL) {
                                            $Requirement13 = '0';
                                        }else{
                                            $Requirement13 = $result_seRequirement['Requirement13'];
                                        }

                                        if ($result_seRequirement['Requirement14'] == '' || $result_seRequirement['Requirement14'] == NULL) {
                                            $Requirement14 = '0';
                                        }else{
                                            $Requirement14 = $result_seRequirement['Requirement14'];
                                        }

                                        if ($result_seRequirement['Requirement15'] == '' || $result_seRequirement['Requirement15'] == NULL) {
                                            $Requirement15 = '0';
                                        }else{
                                            $Requirement15 = $result_seRequirement['Requirement15'];
                                        }

                                        if ($result_seRequirement['Requirement16'] == '' || $result_seRequirement['Requirement16'] == NULL) {
                                            $Requirement16 = '0';
                                        }else{
                                            $Requirement16 = $result_seRequirement['Requirement16'];
                                        }

                                        if ($result_seRequirement['Requirement17'] == '' || $result_seRequirement['Requirement17'] == NULL) {
                                            $Requirement17 = '0';
                                        }else{
                                            $Requirement17 = $result_seRequirement['Requirement17'];
                                        }

                                        if ($result_seRequirement['Requirement18'] == '' || $result_seRequirement['TruckAttper18'] == NULL) {
                                            $Requirement18 = '0';
                                        }else{
                                            $Requirement18 = $result_seRequirement['TruckAttper18'];
                                        }

                                        if ($result_seRequirement['Requirement19'] == '' || $result_seRequirement['Requirement19'] == NULL) {
                                            $Requirement19 = '0';
                                        }else{
                                            $Requirement19 = $result_seRequirement['Requirement19'];
                                        }

                                        if ($result_seRequirement['Requirement20'] == '' || $result_seRequirement['Requirement20'] == NULL) {
                                            $Requirement20 = '0';
                                        }else{
                                            $Requirement20 = $result_seRequirement['Requirement20'];
                                        }

                                        if ($result_seRequirement['Requirement21'] == '' || $result_seRequirement['Requirement21'] == NULL) {
                                            $Requirement21 = '0';
                                        }else{
                                            $Requirement21 = $result_seRequirement['Requirement21'];
                                        }

                                        if ($result_seRequirement['Requirement22'] == '' || $result_seRequirement['Requirement22'] == NULL) {
                                            $Requirement22 = '0';
                                        }else{
                                            $Requirement22 = $result_seRequirement['Requirement22'];
                                        }

                                        if ($result_seRequirement['Requirement23'] == '' || $result_seRequirement['Requirement23'] == NULL) {
                                            $Requirement23 = '0';
                                        }else{
                                            $Requirement23 = $result_seRequirement['Requirement23'];
                                        }

                                        if ($result_seRequirement['Requirement24'] == '' || $result_seRequirement['Requirement24'] == NULL) {
                                            $Requirement24 = '0';
                                        }else{
                                            $Requirement24 = $result_seRequirement['Requirement24'];
                                        }

                                        if ($result_seRequirement['Requirement25'] == '' || $result_seRequirement['Requirement25'] == NULL) {
                                            $Requirement25 = '0';
                                        }else{
                                            $Requirement25 = $result_seRequirement['Requirement25'];
                                        }

                                        if ($result_seRequirement['TruckAttper26'] == '' || $result_seRequirement['TruckAttper26'] == NULL) {
                                            $Requirement26 = '0';
                                        }else{
                                            $Requirement26 = $result_seRequirement['Requirement26'];
                                        }

                                        if ($result_seRequirement['Requirement27'] == '' || $result_seRequirement['Requirement27'] == NULL) {
                                            $Requirement27 = '0';
                                        }else{
                                            $Requirement27 = $result_seRequirement['Requirement27'];
                                        }

                                        if ($result_seRequirement['Requirement28'] == '' || $result_seRequirement['Requirement28'] == NULL) {
                                            $Requirement28 = '0';
                                        }else{
                                            $Requirement28 = $result_seRequirement['Requirement28'];
                                        }

                                        if ($result_seRequirement['Requirement29'] == '' || $result_seRequirement['Requirement29'] == NULL) {
                                            $Requirement29 = '0';
                                        }else{
                                            $Requirement29 = $result_seRequirement['Requirement29'];
                                        }

                                        if ($result_seRequirement['TruckAttper30'] == '' || $result_seRequirement['TruckAttper30'] == NULL) {
                                            $Requirement30 = '0';
                                        }else{
                                            $Requirement30 = $result_seRequirement['TruckAttper30'];
                                        }

                                        if ($result_seRequirement['Requirement31'] == '' || $result_seRequirement['Requirement31'] == NULL) {
                                            $Requirement31 = '0';
                                        }else{
                                            $Requirement31 = $result_seRequirement['Requirement31'];
                                        }
                                    //////////////////////////////////////////////////////////////////////
                                                                
                                        $sql_setotaltruck = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck1',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck2',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck3',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck4',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck5',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck6',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck7',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck8',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck9',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck10',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck11',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck12',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck13',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck14',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck15',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck16',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck17',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck18',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck19',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck20',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck21',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck22',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck23',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck24',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck25',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck26',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck27',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck28',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck29',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck30',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TotalTruck' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalTruck31'";
                                        $params_setotaltruck  = array();
                                        $query_setotaltruck = sqlsrv_query($conn, $sql_setotaltruck, $params_setotaltruck);
                                        $result_setotaltruck = sqlsrv_fetch_array($query_setotaltruck, SQLSRV_FETCH_ASSOC);
                                        
                                        if ($result_setotaltruck['TotalTruck1'] == '' || $result_setotaltruck['TotalTruck1'] == NULL) {
                                            $totaltruck1 = '0';
                                        }else{
                                            $totaltruck1 = $result_setotaltruck['TotalTruck1'];
                                        }

                                        if ($result_setotaltruck['TotalTruck2'] == '' || $result_setotaltruck['TotalTruck2'] == NULL) {
                                            $totaltruck2 = '0';
                                        }else{
                                            $totaltruck2 = $result_setotaltruck['TotalTruck2'];
                                        }

                                        if ($result_setotaltruck['TotalTruck3'] == '' || $result_setotaltruck['TotalTruck3'] == NULL) {
                                            $totaltruck3 = '0';
                                        }else{
                                            $totaltruck3 = $result_setotaltruck['TotalTruck3'];
                                        }

                                        if ($result_setotaltruck['TotalTruck4'] == '' || $result_setotaltruck['TotalTruck4'] == NULL) {
                                            $totaltruck4 = '0';
                                        }else{
                                            $totaltruck4 = $result_setotaltruck['TotalTruck4'];
                                        }

                                        if ($result_setotaltruck['TotalTruck5'] == '' || $result_setotaltruck['TotalTruck5'] == NULL) {
                                            $totaltruck5 = '0';
                                        }else{
                                            $totaltruck5 = $result_setotaltruck['TotalTruck5'];
                                        }

                                        if ($result_setotaltruck['TotalTruck6'] == '' || $result_setotaltruck['TotalTruck6'] == NULL) {
                                            $totaltruck6 = '0';
                                        }else{
                                            $totaltruck6 = $result_setotaltruck['TotalTruck6'];
                                        }

                                        if ($result_setotaltruck['TotalTruck7'] == '' || $result_setotaltruck['TotalTruck7'] == NULL) {
                                            $totaltruck7 = '0';
                                        }else{
                                            $totaltruck7 = $result_setotaltruck['TotalTruck7'];
                                        }

                                        if ($result_setotaltruck['TotalTruck8'] == '' || $result_setotaltruck['TotalTruck8'] == NULL) {
                                            $totaltruck8 = '0';
                                        }else{
                                            $totaltruck8 = $result_setotaltruck['TotalTruck8'];
                                        }

                                        if ($result_setotaltruck['TotalTruck9'] == '' || $result_setotaltruck['TotalTruck9'] == NULL) {
                                            $totaltruck9 = '0';
                                        }else{
                                            $totaltruck9 = $result_setotaltruck['TotalTruck9'];
                                        }

                                        if ($result_setotaltruck['TotalTruck10'] == '' || $result_setotaltruck['TotalTruck10'] == NULL) {
                                            $totaltruck10 = '0';
                                        }else{
                                            $totaltruck10 = $result_setotaltruck['TotalTruck10'];
                                        }

                                        if ($result_setotaltruck['TotalTruck11'] == '' || $result_setotaltruck['TotalTruck11'] == NULL) {
                                            $totaltruck11 = '0';
                                        }else{
                                            $totaltruck11 = $result_setotaltruck['TotalTruck11'];
                                        }

                                        if ($result_setotaltruck['TotalTruck12'] == '' || $result_setotaltruck['TotalTruck12'] == NULL) {
                                            $totaltruck12 = '0';
                                        }else{
                                            $totaltruck12 = $result_setotaltruck['TotalTruck12'];
                                        }

                                        if ($result_setotaltruck['TotalTruck13'] == '' || $result_setotaltruck['TotalTruck13'] == NULL) {
                                            $totaltruck13 = '0';
                                        }else{
                                            $totaltruck13 = $result_setotaltruck['TotalTruck13'];
                                        }

                                        if ($result_setotaltruck['TotalTruck14'] == '' || $result_setotaltruck['TotalTruck14'] == NULL) {
                                            $totaltruck14 = '0';
                                        }else{
                                            $totaltruck14 = $result_setotaltruck['TotalTruck14'];
                                        }

                                        if ($result_setotaltruck['TotalTruck15'] == '' || $result_setotaltruck['TotalTruck15'] == NULL) {
                                            $totaltruck12 = '0';
                                        }else{
                                            $totaltruck12 = $result_setotaltruck['TotalTruck15'];
                                        }

                                        if ($result_setotaltruck['TotalTruck16'] == '' || $result_setotaltruck['TotalTruck16'] == NULL) {
                                            $totaltruck16 = '0';
                                        }else{
                                            $totaltruck16 = $result_setotaltruck['TotalTruck16'];
                                        }

                                        if ($result_setotaltruck['TotalTruck17'] == '' || $result_setotaltruck['TotalTruck17'] == NULL) {
                                            $totaltruck17 = '0';
                                        }else{
                                            $totaltruck17 = $result_setotaltruck['TotalTruck17'];
                                        }

                                        if ($result_setotaltruck['TotalTruck18'] == '' || $result_setotaltruck['TotalTruck18'] == NULL) {
                                            $totaltruck18 = '0';
                                        }else{
                                            $totaltruck18 = $result_setotaltruck['TotalTruck18'];
                                        }

                                        if ($result_setotaltruck['TotalTruck19'] == '' || $result_setotaltruck['TotalTruck19'] == NULL) {
                                            $totaltruck19 = '0';
                                        }else{
                                            $totaltruck19 = $result_setotaltruck['TotalTruck19'];
                                        }

                                        if ($result_setotaltruck['TotalTruck20'] == '' || $result_setotaltruck['TotalTruck20'] == NULL) {
                                            $totaltruck20 = '0';
                                        }else{
                                            $totaltruck20 = $result_setotaltruck['TotalTruck20'];
                                        }

                                        if ($result_setotaltruck['TotalTruck21'] == '' || $result_setotaltruck['TotalTruck21'] == NULL) {
                                            $totaltruck21 = '0';
                                        }else{
                                            $totaltruck21 = $result_setotaltruck['TotalTruck21'];
                                        }

                                        if ($result_setotaltruck['TotalTruck22'] == '' || $result_setotaltruck['TotalTruck22'] == NULL) {
                                            $totaltruck22 = '0';
                                        }else{
                                            $totaltruck22 = $result_setotaltruck['TotalTruck22'];
                                        }

                                        if ($result_setotaltruck['TotalTruck23'] == '' || $result_setotaltruck['TotalTruck23'] == NULL) {
                                            $totaltruck23 = '0';
                                        }else{
                                            $totaltruck23 = $result_setotaltruck['TotalTruck23'];
                                        }

                                        if ($result_setotaltruck['TotalTruck24'] == '' || $result_setotaltruck['TotalTruck24'] == NULL) {
                                            $totaltruck24 = '0';
                                        }else{
                                            $totaltruck24 = $result_setotaltruck['TotalTruck24'];
                                        }

                                        if ($result_setotaltruck['TotalTruck25'] == '' || $result_setotaltruck['TotalTruck25'] == NULL) {
                                            $totaltruck25 = '0';
                                        }else{
                                            $totaltruck25 = $result_setotaltruck['TotalTruck25'];
                                        }

                                        if ($result_setotaltruck['TotalTruck26'] == '' || $result_setotaltruck['TotalTruck26'] == NULL) {
                                            $totaltruck26 = '0';
                                        }else{
                                            $totaltruck26 = $result_setotaltruck['TotalTruck26'];
                                        }

                                        if ($result_setotaltruck['TotalTruck27'] == '' || $result_setotaltruck['TotalTruck27'] == NULL) {
                                            $totaltruck27 = '0';
                                        }else{
                                            $totaltruck27 = $result_setotaltruck['TotalTruck27'];
                                        }

                                        if ($result_setotaltruck['TotalTruck28'] == '' || $result_setotaltruck['TotalTruck28'] == NULL) {
                                            $totaltruck28 = '0';
                                        }else{
                                            $totaltruck28 = $result_setotaltruck['TotalTruck28'];
                                        }

                                        if ($result_setotaltruck['TotalTruck29'] == '' || $result_setotaltruck['TotalTruck29'] == NULL) {
                                            $totaltruck29 = '0';
                                        }else{
                                            $totaltruck29 = $result_setotaltruck['TotalTruck29'];
                                        }

                                        if ($result_setotaltruck['TotalTruck30'] == '' || $result_setotaltruck['TotalTruck30'] == NULL) {
                                            $totaltruck30 = '0';
                                        }else{
                                            $totaltruck30 = $result_setotaltruck['TotalTruck30'];
                                        }

                                        if ($result_setotaltruck['TotalTruck31'] == '' || $result_setruckattper['TotalTruck31'] == NULL) {
                                            $totaltruck31 = '0';
                                        }else{
                                            $totaltruck31 = $result_setotaltruck['TotalTruck31'];
                                        }
                                    //////////////////////////////////////////////////////////////////////


                                        $sql_setruckattper = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper1',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper2',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper3',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper4',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper5',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper6',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper7',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper8',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper9',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper10',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper11',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper12',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper13',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper14',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper15',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper16',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper17',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper18',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper19',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper20',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper21',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper22',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper23',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper24',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper25',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper26',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper27',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper28',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper29',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper30',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
                                            WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                            AND REMARK ='TruckAttper' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TruckAttper31'";
                                        $params_setruckattper  = array();
                                        $query_setruckattper = sqlsrv_query($conn, $sql_setruckattper, $params_setruckattper);
                                        $result_setruckattper = sqlsrv_fetch_array($query_setruckattper, SQLSRV_FETCH_ASSOC);

                                            if ($result_setruckattper['TruckAttper1'] == '' || $result_setruckattper['TruckAttper1'] == NULL) {
                                                $truckattper1 = '0';
                                            }else{
                                                $truckattper1 = $result_setruckattper['TruckAttper1']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper2'] == '' || $result_setruckattper['TruckAttper2'] == NULL) {
                                                $truckattper2 = '0';
                                            }else{
                                                $truckattper2 = $result_setruckattper['TruckAttper2']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper3'] == '' || $result_setruckattper['TruckAttper3'] == NULL) {
                                                $truckattper3 = '0';
                                            }else{
                                                $truckattper3 = $result_setruckattper['TruckAttper3']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper4'] == '' || $result_setruckattper['TruckAttper4'] == NULL) {
                                                $truckattper4 = '0';
                                            }else{
                                                $truckattper4 = $result_setruckattper['TruckAttper4']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper5'] == '' || $result_setruckattper['TruckAttper5'] == NULL) {
                                                $truckattper5 = '0';
                                            }else{
                                                $truckattper5 = $result_setruckattper['TruckAttper5']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper6'] == '' || $result_setruckattper['TruckAttper6'] == NULL) {
                                                $truckattper6 = '0';
                                            }else{
                                                $truckattper6 = $result_setruckattper['TruckAttper6']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper7'] == '' || $result_setruckattper['TruckAttper7'] == NULL) {
                                                $truckattper7 = '0';
                                            }else{
                                                $truckattper7 = $result_setruckattper['TruckAttper7']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper8'] == '' || $result_setruckattper['TruckAttper8'] == NULL) {
                                                $truckattper8 = '0';
                                            }else{
                                                $truckattper8 = $result_setruckattper['TruckAttper8']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper9'] == '' || $result_setruckattper['TruckAttper9'] == NULL) {
                                                $truckattper9 = '0';
                                            }else{
                                                $truckattper9 = $result_setruckattper['TruckAttper9']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper10'] == '' || $result_setruckattper['TruckAttper10'] == NULL) {
                                                $truckattper10 = '0';
                                            }else{
                                                $truckattper10 = $result_setruckattper['TruckAttper10']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper11'] == '' || $result_setruckattper['TruckAttper11'] == NULL) {
                                                $truckattper11 = '0';
                                            }else{
                                                $truckattper11 = $result_setruckattper['TruckAttper11']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper12'] == '' || $result_setruckattper['TruckAttper12'] == NULL) {
                                                $truckattper12 = '0';
                                            }else{
                                                $truckattper12 = $result_setruckattper['TruckAttper12']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper13'] == '' || $result_setruckattper['TruckAttper13'] == NULL) {
                                                $truckattper13 = '0';
                                            }else{
                                                $truckattper13 = $result_setruckattper['TruckAttper13']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper14'] == '' || $result_setruckattper['TruckAttper14'] == NULL) {
                                                $truckattper14 = '0';
                                            }else{
                                                $truckattper14 = $result_setruckattper['TruckAttper14']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper15'] == '' || $result_setruckattper['TruckAttper15'] == NULL) {
                                                $truckattper15 = '0';
                                            }else{
                                                $truckattper15 = $result_setruckattper['TruckAttper15']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper16'] == '' || $result_setruckattper['TruckAttper16'] == NULL) {
                                                $truckattper16 = '0';
                                            }else{
                                                $truckattper16 = $result_setruckattper['TruckAttper16']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper17'] == '' || $result_setruckattper['TruckAttper17'] == NULL) {
                                                $truckattper17 = '0';
                                            }else{
                                                $truckattper17 = $result_setruckattper['TruckAttper17']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper18'] == '' || $result_setruckattper['TruckAttper18'] == NULL) {
                                                $truckattper18 = '0';
                                            }else{
                                                $truckattper18 = $result_setruckattper['TruckAttper18']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper19'] == '' || $result_setruckattper['TruckAttper19'] == NULL) {
                                                $truckattper19 = '0';
                                            }else{
                                                $truckattper19 = $result_setruckattper['TruckAttper19']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper20'] == '' || $result_setruckattper['TruckAttper20'] == NULL) {
                                                $truckattper20 = '0';
                                            }else{
                                                $truckattper20 = $result_setruckattper['TruckAttper20']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper21'] == '' || $result_setruckattper['TruckAttper21'] == NULL) {
                                                $truckattper21 = '0';
                                            }else{
                                                $truckattper21 = $result_setruckattper['TruckAttper21']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper22'] == '' || $result_setruckattper['TruckAttper22'] == NULL) {
                                                $truckattper22 = '0';
                                            }else{
                                                $truckattper22 = $result_setruckattper['TruckAttper22']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper23'] == '' || $result_setruckattper['TruckAttper23'] == NULL) {
                                                $truckattper23 = '0';
                                            }else{
                                                $truckattper23 = $result_setruckattper['TruckAttper23']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper24'] == '' || $result_setruckattper['TruckAttper24'] == NULL) {
                                                $truckattper24 = '0';
                                            }else{
                                                $truckattper24 = $result_setruckattper['TruckAttper24']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper25'] == '' || $result_setruckattper['TruckAttper25'] == NULL) {
                                                $truckattper25 = '0';
                                            }else{
                                                $truckattper25 = $result_setruckattper['TruckAttper25']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper26'] == '' || $result_setruckattper['TruckAttper26'] == NULL) {
                                                $truckattper26 = '0';
                                            }else{
                                                $truckattper26 = $result_setruckattper['TruckAttper26']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper27'] == '' || $result_setruckattper['TruckAttper27'] == NULL) {
                                                $truckattper27 = '0';
                                            }else{
                                                $truckattper27 = $result_setruckattper['TruckAttper27']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper28'] == '' || $result_setruckattper['TruckAttper28'] == NULL) {
                                                $truckattper28 = '0';
                                            }else{
                                                $truckattper28 = $result_setruckattper['TruckAttper28']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper29'] == '' || $result_setruckattper['TruckAttper29'] == NULL) {
                                                $truckattper29 = '0';
                                            }else{
                                                $truckattper29 = $result_setruckattper['TruckAttper29']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper30'] == '' || $result_setruckattper['TruckAttper30'] == NULL) {
                                                $truckattper30 = '0';
                                            }else{
                                                $truckattper30 = $result_setruckattper['TruckAttper30']/10;
                                            }

                                            if ($result_setruckattper['TruckAttper31'] == '' || $result_setruckattper['TruckAttper31'] == NULL) {
                                                $truckattper31 = '0';
                                            }else{
                                                $truckattper31 = $result_setruckattper['TruckAttper31']/10;
                                            }
                                        //////////////////////////////////////////////////////////////////////
                        
                                        //  $SYSAVG = ($SYSDAY1 + $SYSDAY4 + $SYSDAY5 + $SYSDAY6 + $SYSDAY7 
                                        //             + $SYSDAY8 + $SYSDAY9 + $SYSDAY10 + $SYSDAY11 + $SYSDAY12 
                                        //             + $SYSDAY13 + $SYSDAY14 + $SYSDAY15 + $SYSDAY16 + $SYSDAY17
                                        //             + $SYSDAY18 + $SYSDAY19 + $SYSDAY20 + $SYSDAY21 + $SYSDAY22
                                        //             + $SYSDAY23 + $SYSDAY24 + $SYSDAY25 + $SYSDAY26 + $SYSDAY27
                                        //             + $SYSDAY28 + $SYSDAY29 + $SYSDAY30 + $SYSDAY31 )/$result_seCountData['COUNT'];
                     


                                        // $DIAAVG = ($DIADAY1 + $DIADAY4 + $DIADAY5 + $DIADAY6 + $DIADAY7 
                                        //             + $DIADAY8 + $DIADAY9 + $DIADAY10 + $DIADAY11 + $DIADAY12 
                                        //             + $DIADAY13 + $DIADAY14 + $DIADAY15 + $DIADAY16 + $DIADAY17
                                        //             + $DIADAY18 + $DIADAY19 + $DIADAY20 + $DIADAY21 + $DIADAY22
                                        //             + $DIADAY23 + $DIADAY24 + $DIADAY25 + $DIADAY26 + $DIADAY27
                                        //             + $DIADAY28 + $DIADAY29 + $DIADAY30 + $DIADAY31 )/$result_seCountData['COUNT'];


                                        // $TEMPAVG = ($result_seDay1['TENKOTEMPERATUREDATA'] + $result_seDay2['TENKOTEMPERATUREDATA'] +$result_seDay3['TENKOTEMPERATUREDATA'] + $result_seDay4['TENKOTEMPERATUREDATA'] + $result_seDay5['TENKOTEMPERATUREDATA'] 
                                        //             + $result_seDay6['TENKOTEMPERATUREDATA'] + $result_seDay7['TENKOTEMPERATUREDATA'] +$result_seDay8['TENKOTEMPERATUREDATA'] + $result_seDay9['TENKOTEMPERATUREDATA'] + $result_seDay10['TENKOTEMPERATUREDATA']  
                                        //             + $result_seDay11['TENKOTEMPERATUREDATA'] + $result_seDay12['TENKOTEMPERATUREDATA'] +$result_seDay13['TENKOTEMPERATUREDATA'] + $result_seDay14['TENKOTEMPERATUREDATA'] + $result_seDay15['TENKOTEMPERATUREDATA'] 
                                        //             + $result_seDay16['TENKOTEMPERATUREDATA'] + $result_seDay17['TENKOTEMPERATUREDATA'] +$result_seDay18['TENKOTEMPERATUREDATA'] + $result_seDay19['TENKOTEMPERATUREDATA'] + $result_seDay20['TENKOTEMPERATUREDATA'] 
                                        //             + $result_seDay21['TENKOTEMPERATUREDATA'] + $result_seDay22['TENKOTEMPERATUREDATA'] +$result_seDay23['TENKOTEMPERATUREDATA'] + $result_seDay24['TENKOTEMPERATUREDATA'] + $result_seDay25['TENKOTEMPERATUREDATA'] 
                                        //             + $result_seDay26['TENKOTEMPERATUREDATA'] + $result_seDay27['TENKOTEMPERATUREDATA'] +$result_seDay28['TENKOTEMPERATUREDATA'] + $result_seDay29['TENKOTEMPERATUREDATA'] + $result_seDay30['TENKOTEMPERATUREDATA'] 
                                        //             + $result_seDay31['TENKOTEMPERATUREDATA']  )/$result_seCountData['COUNT'];
                                                   
                                        // $ALCOAVG = ($result_seDay1['TENKOALCOHOLDATA'] + $result_seDay2['TENKOALCOHOLDATA'] +$result_seDay3['TENKOALCOHOLDATA'] + $result_seDay4['TENKOALCOHOLDATA'] + $result_seDay5['TENKOALCOHOLDATA'] 
                                        //             + $result_seDay6['TENKOALCOHOLDATA'] + $result_seDay7['TENKOALCOHOLDATA'] +$result_seDay8['TENKOALCOHOLDATA'] + $result_seDay9['TENKOALCOHOLDATA'] + $result_seDay10['TENKOALCOHOLDATA']  
                                        //             + $result_seDay11['TENKOALCOHOLDATA'] + $result_seDay12['TENKOALCOHOLDATA'] +$result_seDay13['TENKOALCOHOLDATA'] + $result_seDay14['TENKOALCOHOLDATA'] + $result_seDay15['TENKOALCOHOLDATA'] 
                                        //             + $result_seDay16['TENKOALCOHOLDATA'] + $result_seDay17['TENKOALCOHOLDATA'] +$result_seDay18['TENKOALCOHOLDATA'] + $result_seDay19['TENKOALCOHOLDATA'] + $result_seDay20['TENKOALCOHOLDATA'] 
                                        //             + $result_seDay21['TENKOALCOHOLDATA'] + $result_seDay22['TENKOALCOHOLDATA'] +$result_seDay23['TENKOALCOHOLDATA'] + $result_seDay24['TENKOALCOHOLDATA'] + $result_seDay25['TENKOALCOHOLDATA'] 
                                        //             + $result_seDay26['TENKOALCOHOLDATA'] + $result_seDay27['TENKOALCOHOLDATA'] +$result_seDay28['TENKOALCOHOLDATA'] + $result_seDay29['TENKOALCOHOLDATA'] + $result_seDay30['TENKOALCOHOLDATA'] 
                                        //             + $result_seDay31['TENKOALCOHOLDATA']  )/$result_seCountData['COUNT'];  
                                                      
                                                    
                                                    
                                        // $PULSEAVG = ($PULSEDAY1 + $PULSEDAY4 + $PULSEDAY5 + $PULSEDAY6 + $PULSEDAY7 
                                        //             + $PULSEDAY8 + $PULSEDAY9 + $PULSEDAY10 + $PULSEDAY11 + $PULSEDAY12 
                                        //             + $PULSEDAY13 + $PULSEDAY14 + $PULSEDAY15 + $PULSEDAY16 + $PULSEDAY17
                                        //             + $PULSEDAY18 + $PULSEDAY19 + $PULSEDAY20 + $PULSEDAY21 + $PULSEDAY22
                                        //             + $PULSEDAY23 + $PULSEDAY24 + $PULSEDAY25 + $PULSEDAY26 + $PULSEDAY27
                                        //             + $PULSEDAY28 + $PULSEDAY29 + $PULSEDAY30 + $PULSEDAY31 )/$result_seCountData['COUNT'];            
                                        
                                        // $OXYGENAVG = ($result_seDay1['TENKOOXYGENDATA'] + $result_seDay2['TENKOOXYGENDATA'] +$result_seDay3['TENKOOXYGENDATA'] + $result_seDay4['TENKOOXYGENDATA'] + $result_seDay5['TENKOOXYGENDATA'] 
                                        //             + $result_seDay6['TENKOOXYGENDATA'] + $result_seDay7['TENKOOXYGENDATA'] +$result_seDay8['TENKOOXYGENDATA'] + $result_seDay9['TENKOOXYGENDATA'] + $result_seDay10['TENKOOXYGENDATA']  
                                        //             + $result_seDay11['TENKOOXYGENDATA'] + $result_seDay12['TENKOOXYGENDATA'] +$result_seDay13['TENKOOXYGENDATA'] + $result_seDay14['TENKOOXYGENDATA'] + $result_seDay15['TENKOOXYGENDATA'] 
                                        //             + $result_seDay16['TENKOOXYGENDATA'] + $result_seDay17['TENKOOXYGENDATA'] +$result_seDay18['TENKOOXYGENDATA'] + $result_seDay19['TENKOOXYGENDATA'] + $result_seDay20['TENKOOXYGENDATA'] 
                                        //             + $result_seDay21['TENKOOXYGENDATA'] + $result_seDay22['TENKOOXYGENDATA'] +$result_seDay23['TENKOOXYGENDATA'] + $result_seDay24['TENKOOXYGENDATA'] + $result_seDay25['TENKOOXYGENDATA'] 
                                        //             + $result_seDay26['TENKOOXYGENDATA'] + $result_seDay27['TENKOOXYGENDATA'] +$result_seDay28['TENKOOXYGENDATA'] + $result_seDay29['TENKOOXYGENDATA'] + $result_seDay30['TENKOOXYGENDATA'] 
                                        //             + $result_seDay31['TENKOOXYGENDATA']  )/$result_seCountData['COUNT'];             
                                        ?> 
                                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                        <!-- <script type="text/javascript" src="js/jquery.min.js"></script>
                                        <script type="text/javascript" src="js/Chart.min.js"></script> -->
                                        <script type="text/javascript">
                                            google.charts.load('current', {'packages': ['corechart']});
                                            google.charts.setOnLoadCallback(drawChart);

                                            function drawChart() {

                                            var data = google.visualization.arrayToDataTable([
                                            ['Day', 'Truck Attend', 'Truck OK', 'Requirement', 'Total Truck', 'Truck Attendance % (10 = 100%)',],
                                            ['01/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend1?>,  <?=$TruckOK1?>,   <?=$Requirement1?>,             <?=$totaltruck1?>,          <?=$truckattper1?>      ],
                                            ['02/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend2?>,  <?=$TruckOK2?>,   <?=$Requirement2?>,             <?=$totaltruck2?>,          <?=$truckattper2?>      ],
                                            ['03/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend3?>,  <?=$TruckOK3?>,   <?=$Requirement3?>,             <?=$totaltruck3?>,          <?=$truckattper3?>      ],
                                            ['04/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend4?>,  <?=$TruckOK4?>,   <?=$Requirement4?>,             <?=$totaltruck4?>,          <?=$truckattper4?>      ],
                                            ['05/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend5?>,  <?=$TruckOK5?>,   <?=$Requirement5?>,             <?=$totaltruck5?>,          <?=$truckattper5?>      ],
                                            ['06/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend6?>,  <?=$TruckOK6?>,   <?=$Requirement6?>,             <?=$totaltruck6?>,          <?=$truckattper6?>      ],
                                            ['07/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend7?>,  <?=$TruckOK7?>,   <?=$Requirement7?>,             <?=$totaltruck7?>,          <?=$truckattper7?>      ],
                                            ['08/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend8?>,  <?=$TruckOK8?>,   <?=$Requirement8?>,             <?=$totaltruck8?>,          <?=$truckattper8?>      ],
                                            ['09/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend9?>,  <?=$TruckOK9?>,   <?=$Requirement9?>,             <?=$totaltruck9?>,          <?=$truckattper9?>      ],
                                            ['10/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend10?>,  <?=$TruckOK10?>,   <?=$Requirement10?>,             <?=$totaltruck10?>,          <?=$truckattper10?>      ],
                                            ['11/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend11?>,  <?=$TruckOK11?>,   <?=$Requirement11?>,             <?=$totaltruck11?>,          <?=$truckattper11?>      ],
                                            ['12/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend12?>,  <?=$TruckOK12?>,   <?=$Requirement12?>,             <?=$totaltruck12?>,          <?=$truckattper12?>      ],
                                            ['13/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend13?>,  <?=$TruckOK13?>,   <?=$Requirement13?>,             <?=$totaltruck13?>,          <?=$truckattper13?>      ],
                                            ['14/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend14?>,  <?=$TruckOK14?>,   <?=$Requirement14?>,             <?=$totaltruck14?>,          <?=$truckattper14?>      ],
                                            ['15/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend15?>,  <?=$TruckOK15?>,   <?=$Requirement15?>,             <?=$totaltruck15?>,          <?=$truckattper15?>      ],
                                            ['16/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend16?>,  <?=$TruckOK16?>,   <?=$Requirement16?>,             <?=$totaltruck16?>,          <?=$truckattper16?>      ],
                                            ['17/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend17?>,  <?=$TruckOK17?>,   <?=$Requirement17?>,             <?=$totaltruck17?>,          <?=$truckattper17?>      ],
                                            ['18/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend18?>,  <?=$TruckOK18?>,   <?=$Requirement18?>,             <?=$totaltruck18?>,          <?=$truckattper18?>      ],
                                            ['19/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend19?>,  <?=$TruckOK19?>,   <?=$Requirement19?>,             <?=$totaltruck19?>,          <?=$truckattper19?>      ],
                                            ['20/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend20?>,  <?=$TruckOK20?>,   <?=$Requirement20?>,             <?=$totaltruck20?>,          <?=$truckattper20?>      ],
                                            ['21/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend21?>,  <?=$TruckOK21?>,   <?=$Requirement21?>,             <?=$totaltruck21?>,          <?=$truckattper21?>      ],
                                            ['22/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend22?>,  <?=$TruckOK22?>,   <?=$Requirement22?>,             <?=$totaltruck22?>,          <?=$truckattper22?>      ],
                                            ['23/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend23?>,  <?=$TruckOK23?>,   <?=$Requirement23?>,             <?=$totaltruck23?>,          <?=$truckattper23?>      ],
                                            ['24/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend24?>,  <?=$TruckOK24?>,   <?=$Requirement24?>,             <?=$totaltruck24?>,          <?=$truckattper24?>      ],
                                            ['25/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend25?>,  <?=$TruckOK25?>,   <?=$Requirement25?>,             <?=$totaltruck25?>,          <?=$truckattper25?>      ],
                                            ['26/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend26?>,  <?=$TruckOK26?>,   <?=$Requirement26?>,             <?=$totaltruck26?>,          <?=$truckattper26?>      ],
                                            ['27/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend27?>,  <?=$TruckOK27?>,   <?=$Requirement27?>,             <?=$totaltruck27?>,          <?=$truckattper27?>      ],
                                            ['28/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend28?>,  <?=$TruckOK28?>,   <?=$Requirement28?>,             <?=$totaltruck28?>,          <?=$truckattper28?>      ],
                                            ['29/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend29?>,  <?=$TruckOK29?>,   <?=$Requirement29?>,             <?=$totaltruck29?>,          <?=$truckattper29?>      ],
                                            ['30/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend30?>,  <?=$TruckOK30?>,   <?=$Requirement30?>,             <?=$totaltruck30?>,          <?=$truckattper30?>      ],
                                            ['31/<?=$monthnumeric?>/<?=$years?>',  <?=$TruckAttend31?>,  <?=$TruckOK31?>,   <?=$Requirement31?>,             <?=$totaltruck31?>,          <?=$truckattper31?>      ]

                                            ]);
                                            
                                            // TESTDATA
                                            // var data = google.visualization.arrayToDataTable([
                                            // ['Day', 'Truck Attend', 'Truck OK', 'Requirement', 'Total Truck', 'Truck Attendance % (10 = 100%)',],
                                            // ['01/<?=$monthnumeric?>/<?=$years?>',   <?=$result_setruckatt['TruckAttend1']?> , <?=$result_setruckok['TruckOK1']?> , <?=$result_seRequirement['Requirement1']?> ,  <?=$result_setotaltruck['TotalTruck1']?> ,        <?=$truckattper1?>     ],
                                            // ['02/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend2']?>,  <?=$result_setruckok['TruckOK2']?>,   0,            0,          0      ]
                                            

                                            // ]);

                                            var view = new google.visualization.DataView(data);
                                            view.setColumns([0, 
                                                1,
                                                { calc: "stringify",
                                                        sourceColumn: 1,
                                                        type: "string",
                                                        role: "annotation" },
                                                2,
                                                { calc: "stringify",
                                                        sourceColumn:2,
                                                        type: "string",
                                                        role: "annotation" },
                                                3,
                                                { calc: "stringify",
                                                        sourceColumn: 3,
                                                        type: "string",
                                                        role: "annotation" },
                                                4, 
                                                { calc: "stringify",
                                                        sourceColumn: 4,
                                                        type: "string",
                                                        role: "annotation" },
                                                5,
                                                { calc: "stringify",
                                                        sourceColumn: 5,
                                                        type: "string",
                                                        role: "annotation" }
                                                ]);

                                            var options = {
                                            title : 'Truck readiness check',
                                            // vAxis: {title: 'Cups'},
                                            hAxis: {title: 'Month'},
                                            seriesType: 'bars',
                                            legend: {position: 'top'},
                                            series: {
                                                2: {type: 'line',lineWidth: 5,pointShape:'circle',pointSize: 10,},
                                                3: {type: 'line',lineWidth: 5,pointShape:'circle',pointSize: 10,},
                                                4: {type: 'line',lineWidth: 5,pointShape:'circle',pointSize: 10,}
                                                },

                                            tooltip: {

                                            },
                                            colors: ['#D2D6D9', '#009E18', '#F74D4D', '#57DEF2','#000000' ]
                                                
                                            };

                                           

                                            var chart_area = document.getElementById('curve_chart');
                                            var chart = new google.visualization.ComboChart(chart_area);

                                            var chart = new google.visualization.ComboChart(document.getElementById('curve_chart'));
                                            chart.draw(view, options);

                                            google.visualization.events.addListener(chart, 'ready', function(){
                                            // chart_area.innerHTML = '<img src="' + chart.getImageURI() + '" class="img-responsive">';
                                            });
                                            chart.draw(view, options);
                                            }
                                            </script>

                                            <div id="curve_chart" style="width: 100%; height: 500px"></div>


                                    </div>
                                    <!-- /.col-lg-8 (nested) -->
                                </div>
                                <!--END ROW ความดันบน ความดันล่าง  -->
                                
                                

                            </div>
                            <!-- /.panel-body -->
                        </div>

                    </div>
                </div>
                <!-- END ROW1 -->

                


                
                

            </div>
        </div>
                                          
        <!-- Bootstrap Core JavaScript -->
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <!-- Metis Menu Plugin JavaScript -->
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <!-- Morris Charts JavaScript -->
        <!-- <script src="../vendor/raphael/raphael.min.js"></script>
        <script src="../vendor/morrisjs/morris.js"></script>                                                     -->
         <!-- Chart.js JavaScript -->
         <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>                                                                            
        <!-- Custom Theme JavaScript -->
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true,
                });
            });
            
            function select_graph()
            {
                var months = document.getElementById('select_month').value;
                var employeecode = document.getElementById('txt_empcode').value;

                // alert(months);
                // alert(employeecode);
                window.open('meg_driverdatagraph_check.php?months=' + months + '&employeecode=' + employeecode, '_blank');

            }
            
            function check_graph()
            {
               var monthnumeric = document.getElementById('txt_monthnumberic').value;
               var month = document.getElementById('txt_month').value;
               var years = document.getElementById('txt_years').value;
                // alert(months);
                // alert(employeecode);
                window.open('meg_digitaltenko_TruckReadiness_graphprint.php?monthnumeric=' + monthnumeric + '&month=' + month+ '&years=' + years, '_blank');

            }
    </script>

    </body>


</html>
