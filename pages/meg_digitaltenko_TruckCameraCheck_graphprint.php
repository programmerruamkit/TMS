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


$strDate = date("Y/m/d");
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
$yearsub = substr($years,2);

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
                        
                        

                    </div>
                    <!-- /.col-lg-12 -->
                    
                </div>
                <br>
                <!-- START DIV GRAPH EXPORT TO PDF -->

                <div  id="testing" style="text-align: center;">
                                             
                    <div class="panel-heading" style="text-align: center;">
                        <h2 class="page-header"><i class="fa fa-bar-chart-o fa-fw"></i>  
                             KPI Data Graph&nbsp;&nbsp; (Truck Camera Check)&nbsp;&nbsp; Years:&nbsp;<b><?=$years?></b></b>
                            
                        </h2>
                    </div>
                    <!-- กราฟความดันบน-ล่าง -->
                    <div class="panel-body" align="center">
                        <div id="curve_chart" style="width: 100%; height: 500px" ></div>
                    </div>
                            
                        
                </div>
                <!-- END DIV GRAPH EXPORT TO PDF -->
                
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
                                    <form method="post" id="make_pdf" action="create_truckcameracheckkpipdf.php?years='<?=$years?>'"  target="_blank">
                                        <input type="hidden" name="hidden_html" id="hidden_html" ></input>
                                        <button type="button" name="create_truckcameracheckkpipdf" id="create_truckcameracheckkpipdf"   class="btn btn-success btn-lg">Export PDF</button>
                                    </form>
                            </div>
                            <!-- START ROW ความดันค่าบน ค่าล่าง-->
                                <div class="row">
                                    <!-- <div class="col-lg-12" style="text-align:center;">
                                        <h2 class="page-header"><i class="fa fa-bar-chart-o fa-fw"></i>  
                                            กราฟข้อมูล KPI ประจำเดือน:&nbsp;<b><?=DateThai($strDate)?></b></b>
                                            <input type="hidden" id="txt_empcode" name="txt_empcode" value="<?=$_GET['employeecode']?>" ></imput>
                                        </h2>
                                    </div>-->
                                    <div class="col-lg-12">


                                         <?php
                                        
                                        /////////////////QUERY ค้นหาข้อมูล///////////////////////////////////////////////////
                                        //TRUCK ATTEND
                                        $sql_seData4 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='ActualCheckJan".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Jan' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='ActualCheckFeb".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Feb' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='ActualCheckMar".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Mar' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='ActualCheckApr".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Apr' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='ActualCheckMay".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='May' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='ActualCheckJun".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Jun' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='ActualCheckJul".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Jul' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='ActualCheckAug".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Aug' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='ActualCheckSep".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Sep' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='ActualCheckOct".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Oct' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='ActualCheckNov".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Nov' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='ActualCheckDec".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Dec' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                        $params_seData4  = array();
                                        $query_seData4 = sqlsrv_query($conn, $sql_seData4, $params_seData4);
                                        $result_seData4 = sqlsrv_fetch_array($query_seData4, SQLSRV_FETCH_ASSOC);

                                        if ($result_seData4['DATA1'] == '' || $result_seData4['DATA1'] == NULL) {
                                            $ActualCheck1 = '0';
                                        }else{
                                            $ActualCheck1 = $result_seData4['DATA1'];
                                        }

                                        if ($result_seData4['DATA2'] == '' || $result_seData4['DATA2'] == NULL) {
                                            $ActualCheck2 = '0';
                                        }else{
                                            $ActualCheck2 = $result_seData4['DATA2'];
                                        }

                                        if ($result_seData4['DATA3'] == '' || $result_seData4['DATA3'] == NULL) {
                                            $ActualCheck3 = '0';
                                        }else{
                                            $ActualCheck3 = $result_seData4['DATA3'];
                                        }

                                        if ($result_seData4['DATA4'] == '' || $result_seData4['DATA4'] == NULL) {
                                            $ActualCheck4 = '0';
                                        }else{
                                            $ActualCheck4 = $result_seData4['DATA4'];
                                        }

                                        if ($result_seData4['DATA5'] == '' || $result_seData4['DATA5'] == NULL) {
                                            $ActualCheck5 = '0';
                                        }else{
                                            $ActualCheck5 = $result_seData4['DATA5'];
                                        }

                                        if ($result_seData4['DATA6'] == '' || $result_seData4['DATA6'] == NULL) {
                                            $ActualCheck6 = '0';
                                        }else{
                                            $ActualCheck6 = $result_seData4['DATA6'];
                                        }

                                        if ($result_seData4['DATA7'] == '' || $result_seData4['DATA7'] == NULL) {
                                            $ActualCheck7 = '0';
                                        }else{
                                            $ActualCheck7 = $result_seData4['DATA7'];
                                        }

                                        if ($result_seData4['DATA8'] == '' || $result_seData4['DATA8'] == NULL) {
                                            $ActualCheck8 = '0';
                                        }else{
                                            $ActualCheck8 = $result_seData4['DATA8'];
                                        }
                                        if ($result_seData4['DATA9'] == '' || $result_seData4['DATA9'] == NULL) {
                                            $ActualCheck9 = '0';
                                        }else{
                                            $ActualCheck9 = $result_seData4['DATA9'];
                                        }

                                        if ($result_seData4['DATA10'] == '' || $result_seData4['DATA10'] == NULL) {
                                            $ActualCheck10 = '0';
                                        }else{
                                            $ActualCheck10 = $result_seData4['DATA10'];
                                        }

                                        if ($result_seData4['DATA11'] == '' || $result_seData4['DATA11'] == NULL) {
                                            $ActualCheck11 = '0';
                                        }else{
                                            $ActualCheck11 = $result_seData4['DATA11'];
                                        }

                                        if ($result_seData4['DATA12'] == '' || $result_seData4['DATA12'] == NULL) {
                                            $ActualCheck12 = '0';
                                        }else{
                                            $ActualCheck12 = $result_seData4['DATA12'];
                                        }


                                        $sql_seData5 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='NGResultJan".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Jan' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='NGResultFeb".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Feb' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='NGResultMar".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Mar' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='NGResultApr".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Apr' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='NGResultMay".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='May' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='NGResultJun".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Jun' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='NGResultJul".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Jul' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='NGResultAug".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Aug' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='NGResultSep".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Sep' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='NGResultOct".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Oct' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='NGResultNov".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Nov' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='NGResultDec".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Dec' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                        $params_seData5  = array();
                                        $query_seData5 = sqlsrv_query($conn, $sql_seData5, $params_seData5);
                                        $result_seData5 = sqlsrv_fetch_array($query_seData5, SQLSRV_FETCH_ASSOC);

                                        // echo "sadsadsadsadsad";
                                        // echo $result_seData5['DATA1'];

                                        if ($result_seData5['DATA1'] == '' || $result_seData5['DATA1'] == NULL) {
                                            $NGResult1 = '0';
                                        }else{
                                            $NGResult1 = $result_seData5['DATA1'];
                                        }

                                        if ($result_seData5['DATA2'] == '' || $result_seData5['DATA2'] == NULL) {
                                            $NGResult2 = '0';
                                        }else{
                                            $NGResult2 = $result_seData5['DATA2'];
                                        }

                                        if ($result_seData5['DATA3'] == '' || $result_seData5['DATA3'] == NULL) {
                                            $NGResult3 = '0';
                                        }else{
                                            $NGResult3 = $result_seData5['DATA3'];
                                        }

                                        if ($result_seData5['DATA4'] == '' || $result_seData5['DATA4'] == NULL) {
                                            $NGResult4 = '0';
                                        }else{
                                            $NGResult4 = $result_seData5['DATA4'];
                                        }

                                        if ($result_seData5['DATA5'] == '' || $result_seData5['DATA5'] == NULL) {
                                            $NGResult5 = '0';
                                        }else{
                                            $NGResult5 = $result_seData5['DATA5'];
                                        }

                                        if ($result_seData5['DATA6'] == '' || $result_seData5['DATA6'] == NULL) {
                                            $NGResult6 = '0';
                                        }else{
                                            $NGResult6 = $result_seData5['DATA6'];
                                        }

                                        if ($result_seData5['DATA7'] == '' || $result_seData5['DATA7'] == NULL) {
                                            $NGResult7 = '0';
                                        }else{
                                            $NGResult7 = $result_seData5['DATA7'];
                                        }

                                        if ($result_seData5['DATA8'] == '' || $result_seData5['DATA8'] == NULL) {
                                            $NGResult8 = '0';
                                        }else{
                                            $NGResult8 = $result_seData5['DATA8'];
                                        }
                                        if ($result_seData5['DATA9'] == '' || $result_seData5['DATA9'] == NULL) {
                                            $NGResult9 = '0';
                                        }else{
                                            $NGResult9 = $result_seData5['DATA9'];
                                        }

                                        if ($result_seData5['DATA10'] == '' || $result_seData5['DATA10'] == NULL) {
                                            $NGResult10 = '0';
                                        }else{
                                            $NGResult10 = $result_seData5['DATA10'];
                                        }

                                        if ($result_seData5['DATA11'] == '' || $result_seData5['DATA11'] == NULL) {
                                            $NGResult11 = '0';
                                        }else{
                                            $NGResult11 = $result_seData5['DATA11'];
                                        }

                                        if ($result_seData5['DATA12'] == '' || $result_seData5['DATA12'] == NULL) {
                                            $NGResult12 = '0';
                                        }else{
                                            $NGResult12 = $result_seData5['DATA12'];
                                        }



                                        $sql_seData3 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='PlanCheckJan".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Jan' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='PlanCheckFeb".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Feb' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='PlanCheckMar".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Mar' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='PlanCheckApr".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Apr' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='PlanCheckMay".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='May' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='PlanCheckJun".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Jun' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='PlanCheckJul".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Jul' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='PlanCheckAug".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Aug' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='PlanCheckSep".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Sep' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='PlanCheckOct".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Oct' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='PlanCheckNov".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Nov' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
                                            WHERE DATE_PROCESS ='PlanCheckDec".$years."' 
                                            AND REMARK ='Topic' 
                                            AND REMARK_MONTH ='Dec' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                        $params_seData3  = array();
                                        $query_seData3 = sqlsrv_query($conn, $sql_seData3, $params_seData3);
                                        $result_seData3 = sqlsrv_fetch_array($query_seData3, SQLSRV_FETCH_ASSOC);

                                        if ($result_seData3['DATA1'] == '' || $result_seData3['DATA1'] == NULL) {
                                            $PlanCheck1 = '0';
                                        }else{
                                            $PlanCheck1 = $result_seData3['DATA1'];
                                        }

                                        if ($result_seData3['DATA2'] == '' || $result_seData3['DATA2'] == NULL) {
                                            $PlanCheck2 = '0';
                                        }else{
                                            $PlanCheck2 = $result_seData3['DATA2'];
                                        }

                                        if ($result_seData3['DATA3'] == '' || $result_seData3['DATA3'] == NULL) {
                                            $PlanCheck3 = '0';
                                        }else{
                                            $PlanCheck3 = $result_seData3['DATA3'];
                                        }

                                        if ($result_seData3['DATA4'] == '' || $result_seData3['DATA4'] == NULL) {
                                            $PlanCheck4 = '0';
                                        }else{
                                            $PlanCheck4 = $result_seData3['DATA4'];
                                        }

                                        if ($result_seData3['DATA5'] == '' || $result_seData3['DATA5'] == NULL) {
                                            $PlanCheck5 = '0';
                                        }else{
                                            $PlanCheck5 = $result_seData3['DATA5'];
                                        }

                                        if ($result_seData3['DATA6'] == '' || $result_seData3['DATA6'] == NULL) {
                                            $PlanCheck6 = '0';
                                        }else{
                                            $PlanCheck6 = $result_seData3['DATA6'];
                                        }

                                        if ($result_seData3['DATA7'] == '' || $result_seData3['DATA7'] == NULL) {
                                            $PlanCheck7 = '0';
                                        }else{
                                            $PlanCheck7 = $result_seData3['DATA7'];
                                        }

                                        if ($result_seData3['DATA8'] == '' || $result_seData3['DATA8'] == NULL) {
                                            $PlanCheck8 = '0';
                                        }else{
                                            $PlanCheck8 = $result_seData3['DATA8'];
                                        }
                                        if ($result_seData3['DATA9'] == '' || $result_seData3['DATA9'] == NULL) {
                                            $PlanCheck9 = '0';
                                        }else{
                                            $PlanCheck9 = $result_seData3['DATA9'];
                                        }

                                        if ($result_seData3['DATA10'] == '' || $result_seData3['DATA10'] == NULL) {
                                            $PlanCheck10 = '0';
                                        }else{
                                            $PlanCheck10 = $result_seData3['DATA10'];
                                        }

                                        if ($result_seData3['DATA11'] == '' || $result_seData3['DATA11'] == NULL) {
                                            $PlanCheck11 = '0';
                                        }else{
                                            $PlanCheck11 = $result_seData3['DATA11'];
                                        }

                                        if ($result_seData3['DATA12'] == '' || $result_seData3['DATA12'] == NULL) {
                                            $PlanCheck12 = '0';
                                        }else{
                                            $PlanCheck12 = $result_seData3['DATA12'];
                                        }

                                        

                                                     
                                        ?> 
                                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                        <!-- <script type="text/javascript" src="js/jquery.min.js"></script>
                                        <script type="text/javascript" src="js/Chart.min.js"></script> -->
                                        <script type="text/javascript">
                                                google.charts.load('current', {'packages': ['corechart']});
                                                google.charts.setOnLoadCallback(drawChart);

                                                function drawChart() {

                                                var data = google.visualization.arrayToDataTable([
                                                ['Day', 'Actual Checking', 'NG Result', 'Plan Checking'],
                                                ['Jan<?=$yearsub?>',  <?=$ActualCheck1?>, <?=$NGResult1?>,  <?=$PlanCheck1?>],
                                                ['Feb<?=$yearsub?>',  <?=$ActualCheck2?>, <?=$NGResult2?>,  <?=$PlanCheck2?>],
                                                ['Mar<?=$yearsub?>',  <?=$ActualCheck3?>, <?=$NGResult3?>,  <?=$PlanCheck3?>],
                                                ['Apr<?=$yearsub?>',  <?=$ActualCheck4?>, <?=$NGResult4?>,  <?=$PlanCheck4?>],
                                                ['May<?=$yearsub?>',  <?=$ActualCheck5?>, <?=$NGResult5?>,  <?=$PlanCheck5?>],
                                                ['Jun<?=$yearsub?>',  <?=$ActualCheck6?>, <?=$NGResult6?>,  <?=$PlanCheck6?>],
                                                ['Jul<?=$yearsub?>',  <?=$ActualCheck7?>, <?=$NGResult7?>,  <?=$PlanCheck7?>],
                                                ['Aug<?=$yearsub?>',  <?=$ActualCheck8?>, <?=$NGResult8?>,  <?=$PlanCheck8?>],
                                                ['Sep<?=$yearsub?>',  <?=$ActualCheck9?>, <?=$NGResult9?>,  <?=$PlanCheck9?>],
                                                ['Oct<?=$yearsub?>',  <?=$ActualCheck10?>, <?=$NGResult10?>,  <?=$PlanCheck10?>],
                                                ['Nov<?=$yearsub?>',  <?=$ActualCheck11?>, <?=$NGResult11?>,  <?=$PlanCheck11?>],
                                                ['Dec<?=$yearsub?>',  <?=$ActualCheck12?>, <?=$NGResult12?>,  <?=$PlanCheck12?>]

                                                ]);

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
                                                            role: "annotation" }
                                                    ]);

                                                var options = {
                                                title : 'Truck Camera check',
                                                // vAxis: {title: 'Cups'},
                                                hAxis: {title: 'Month'},
                                                seriesType: 'bars',
                                                legend: {position: 'top'},
                                                series: {
                                                    1: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,},
                                                    2: {type: 'line',lineWidth: 5,pointShape:'circle',pointSize: 10,},
                                                    3: {type: 'line',lineWidth: 5,pointShape:'circle',pointSize: 10,}
                                                    },

                                                tooltip: {

                                                },
                                                colors: ['#008f00', '#C90404', '#000000', ]
                                                    
                                                };

                                                // var chart = new google.visualization.ComboChart(document.getElementById('curve_chart'));
                                                // chart.draw(view, options);
                                                
                                                var chart_area = document.getElementById('curve_chart');
                                                var chart = new google.visualization.ComboChart(chart_area);

                                                google.visualization.events.addListener(chart, 'ready', function(){
                                                    chart_area.innerHTML = '<img src="' + chart.getImageURI() + '" class="img-responsive">';
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
            
            
            
            function autoclick() {
                document.getElementById("create_truckcameracheckkpipdf").click(function(){
                $('#hidden_html').val($('#testing').html());
                $('#make_pdf').submit();
                });
                window.close();
            }
            setTimeout(autoclick, 600);

            $(document).ready(function(){
                $('#create_truckcameracheckkpipdf').click(function(){
                $('#hidden_html').val($('#testing').html());
                $('#make_pdf').submit();
                });
            });
           
    </script>

    </body>


</html>
