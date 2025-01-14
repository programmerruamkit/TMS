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


// $monthnumeric = $_GET['monthnumeric'];
// $month = $_GET['month'];
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
                                <input type="text" hidden id="txt_monthnumberic" name="txt_monthnumberic" value="<?=$monthnumeric?>">
                                <input type="text" hidden id="txt_month" name="txt_month" value="<?=$month?>">
                                <input type="text" hidden id="txt_years" name="txt_years" value="<?=$years?>">
                                <div style="align: center;">
                                    
                                        <button type="button" name="check_graph" id="check_graph" onclick ="check_graph();" class="btn btn-success btn-lg">Export Graph To PDF</button>
                                    
                                </div>    
                            </div>     

                            <!-- START ROW ความดันค่าบน ค่าล่าง-->
                                <div class="row">
                                    <div class="col-lg-12" style="text-align:center;">
                                        <h2 class="page-header"><i class="fa fa-bar-chart-o fa-fw"></i>  
                                            กราฟข้อมูล KPI ประจำปี:&nbsp;<b><?=$years?></b></b>
                                            <input type="hidden" id="txt_empcode" name="txt_empcode" value="<?=$_GET['employeecode']?>" ></imput>
                                        </h2>
                                    </div>                           
                                    <div class="col-lg-12">


                                         <?php
                                        // ค้นหาวันแรกของเดือนปัจจุบัน
                                        // $sql_seDatestart = "SELECT FORMAT (DATEADD(MONTH, DATEDIFF(MONTH, 0, GETDATE()), 0), 'dd/MM/yyyy') AS 'DS'";
                                        // $params_seDatestart = array();
                                        // $query_seDatestart = sqlsrv_query($conn, $sql_seDatestart, $params_seDatestart);
                                        // $result_seDatestart = sqlsrv_fetch_array($query_seDatestart, SQLSRV_FETCH_ASSOC);

                                        // $sql_seAdddateweek = "{call megGetdate_v2(?,?)}";
                                        // $params_seAdddateweek = array(
                                        //     array('select_dategraph', SQLSRV_PARAM_IN),
                                        //     array($result_seDatestart['DS'], SQLSRV_PARAM_IN)
                                        // );
                                        // $query_seAdddateweek = sqlsrv_query($conn, $sql_seAdddateweek, $params_seAdddateweek);
                                        // $result_seAdddateweek = sqlsrv_fetch_array($query_seAdddateweek, SQLSRV_FETCH_ASSOC);
                                        //echo $result_seAdddateweek['D1'] . '|' . $result_seAdddateweek['D2'] . '|' . $result_seAdddateweek['D3'] . '|' . $result_seAdddateweek['D4'] . '|' . $result_seAdddateweek['D5'] . '|' . $result_seAdddateweek['D6'] . '|' . $result_seAdddateweek['D7'];
                                        
                                        $sql_seDataCheck = "SELECT (SELECT PersonCode  
                                        FROM EMPLOYEEEHR2 
                                        WHERE PersonCode ='0000') AS 'DATA1',
                                        (SELECT PersonCode  
                                        FROM EMPLOYEEEHR2 
                                        WHERE PersonCode ='0000') AS 'DATA2'";
                                        $params_seDataCheck = array();
                                        $query_seDataCheck = sqlsrv_query($conn, $sql_seDataCheck, $params_seDataCheck);
                                        $result_seDataCheck = sqlsrv_fetch_array($query_seDataCheck, SQLSRV_FETCH_ASSOC);
                                        
                                  
                                        /////////////////QUERY ค้นหาข้อมูล///////////////////////////////////////////////////
                                        //Personal

                                        $sql_seData1 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoPerJan".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Jan' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoPerFeb".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Feb' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoPerMar".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Mar' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoPerApr".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Apr' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoPerMay".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='May' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoPerJun".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Jun' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoPerJul".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Jul' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoPerAug".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Aug' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoPerSep".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Sep' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoPerOct".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Oct' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoPerNov".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Nov' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoPerDec".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Dec' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                        $params_seData1  = array();
                                        $query_seData1 = sqlsrv_query($conn, $sql_seData1, $params_seData1);
                                        $result_seData1 = sqlsrv_fetch_array($query_seData1, SQLSRV_FETCH_ASSOC);


                                        $sql_seData2 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayPerJan".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Jan' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayPerFeb".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Feb' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayPerMar".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Mar' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayPerApr".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Apr' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayPerMay".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='May' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayPerJun".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Jun' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayPerJul".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Jul' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayPerAug".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Aug' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayPerSep".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Sep' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayPerOct".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Oct' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayPerNov".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Nov' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayPerDec".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Dec' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                        $params_seData2  = array();
                                        $query_seData2 = sqlsrv_query($conn, $sql_seData2, $params_seData2);
                                        $result_seData2 = sqlsrv_fetch_array($query_seData2, SQLSRV_FETCH_ASSOC);
                                        
                                        $sql_seData3 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AtplantPerJan".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Jan' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AtplantPerFeb".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Feb' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AtplantPerMar".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Mar' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AtplantPerApr".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Apr' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AtplantPerMay".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='May' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AtplantPerJun".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Jun' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AtplantPerJul".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Jul' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AtplantPerAug".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Aug' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AtplantPerSep".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Sep' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AtplantPerOct".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Oct' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AtplantPerNov".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Nov' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AtplantPerDec".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Dec' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                        $params_seData3  = array();
                                        $query_seData3 = sqlsrv_query($conn, $sql_seData3, $params_seData3);
                                        $result_seData3 = sqlsrv_fetch_array($query_seData3, SQLSRV_FETCH_ASSOC);

                                        $sql_seData4 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaPerJan".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Jan' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaPerFeb".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Feb' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaPerMar".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Mar' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaPerApr".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Apr' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaPerMay".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='May' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaPerJun".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Jun' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaPerJul".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Jul' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaPerAug".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Aug' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaPerSep".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Sep' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaPerOct".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Oct' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaPerNov".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Nov' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaPerDec".$years."' 
                                            AND REMARK ='Personal' 
                                            AND REMARK_MONTH ='Dec' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                        $params_seData4  = array();
                                        $query_seData4 = sqlsrv_query($conn, $sql_seData4, $params_seData4);
                                        $result_seData4 = sqlsrv_fetch_array($query_seData4, SQLSRV_FETCH_ASSOC);

                                        $subper1 = $result_seData1['DATA1']+$result_seData2['DATA1']+$result_seData3['DATA1']+$result_seData4['DATA1'];
                                        $subper2 = $result_seData1['DATA2']+$result_seData2['DATA2']+$result_seData3['DATA2']+$result_seData4['DATA2'];
                                        $subper3 = $result_seData1['DATA3']+$result_seData2['DATA3']+$result_seData3['DATA3']+$result_seData4['DATA3'];
                                        $subper4 = $result_seData1['DATA4']+$result_seData2['DATA4']+$result_seData3['DATA4']+$result_seData4['DATA4'];
                                        $subper5 = $result_seData1['DATA5']+$result_seData2['DATA5']+$result_seData3['DATA5']+$result_seData4['DATA5'];
                                        $subper6 = $result_seData1['DATA6']+$result_seData2['DATA6']+$result_seData3['DATA6']+$result_seData4['DATA6'];
                                        $subper7 = $result_seData1['DATA7']+$result_seData2['DATA7']+$result_seData3['DATA7']+$result_seData4['DATA7'];
                                        $subper8 = $result_seData1['DATA8']+$result_seData2['DATA8']+$result_seData3['DATA8']+$result_seData4['DATA8'];
                                        $subper9 = $result_seData1['DATA9']+$result_seData2['DATA9']+$result_seData3['DATA9']+$result_seData4['DATA9'];
                                        $subper10 = $result_seData1['DATA10']+$result_seData2['DATA10']+$result_seData3['DATA10']+$result_seData4['DATA10'];
                                        $subper11 = $result_seData1['DATA11']+$result_seData2['DATA11']+$result_seData3['DATA11']+$result_seData4['DATA11'];
                                        $subper12 = $result_seData1['DATA12']+$result_seData2['DATA12']+$result_seData3['DATA12']+$result_seData4['DATA12'];

                                         //Personal    
                                        
                                        $sql_seData6 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoExtJan".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Jan' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoExtFeb".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Feb' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoExtMar".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Mar' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoExtApr".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Apr' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoExtMay".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='May' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoExtJun".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Jun' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoExtJul".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Jul' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoExtAug".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Aug' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoExtSep".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Sep' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoExtOct".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Oct' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoExtNov".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Nov' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='TenkoExtDec".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Dec' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                        $params_seData6  = array();
                                        $query_seData6 = sqlsrv_query($conn, $sql_seData6, $params_seData6);
                                        $result_seData6 = sqlsrv_fetch_array($query_seData6, SQLSRV_FETCH_ASSOC);
                                        
                                        
                                        $sql_seData7 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayExtJan".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Jan' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayExtFeb".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Feb' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayExtMar".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Mar' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayExtApr".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Apr' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayExtMay".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='May' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayExtJun".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Jun' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayExtJul".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Jul' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayExtAug".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Aug' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayExtSep".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Sep' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayExtOct".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Oct' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayExtNov".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Nov' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='OnthewayExtDec".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Dec' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                        $params_seData7  = array();
                                        $query_seData7 = sqlsrv_query($conn, $sql_seData7, $params_seData7);
                                        $result_seData7 = sqlsrv_fetch_array($query_seData7, SQLSRV_FETCH_ASSOC);   

                                        $sql_seData8 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttplantExtJan".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Jan' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttplantExtFeb".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Feb' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttplantExtMar".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Mar' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttplantExtApr".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Apr' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttplantExtMay".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='May' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttplantExtJun".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Jun' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttplantExtJul".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Jul' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttplantExtAug".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Aug' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttplantExtSep".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Sep' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttplantExtOct".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Oct' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttplantExtNov".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Nov' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttplantExtDec".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Dec' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                        $params_seData8  = array();
                                        $query_seData8 = sqlsrv_query($conn, $sql_seData8, $params_seData8);
                                        $result_seData8 = sqlsrv_fetch_array($query_seData8, SQLSRV_FETCH_ASSOC);    
                                        

                                        $sql_seData9 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaExtJan".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Jan' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA1',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaExtFeb".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Feb' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA2',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaExtMar".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Mar' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA3',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaExtApr".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Apr' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA4',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaExtMay".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='May' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA5',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaExtJun".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Jun' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA6',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaExtJul".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Jul' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA7',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaExtAug".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Aug' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA8',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaExtSep".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Sep' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA9',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaExtOct".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Oct' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA10',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaExtNov".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Nov' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA11',
                                            (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
                                            WHERE DATE_PROCESS ='AttoyotaExtDec".$years."' 
                                            AND REMARK ='External' 
                                            AND REMARK_MONTH ='Dec' 
                                            AND REMARK_YEARS ='".$years."') AS 'DATA12'";
                                        $params_seData9  = array();
                                        $query_seData9 = sqlsrv_query($conn, $sql_seData9, $params_seData9);
                                        $result_seData9 = sqlsrv_fetch_array($query_seData9, SQLSRV_FETCH_ASSOC);

                                        $subext1 = $result_seData6['DATA1']+$result_seData7['DATA1']+$result_seData8['DATA1']+$result_seData9['DATA1'];
                                        $subext2 = $result_seData6['DATA2']+$result_seData7['DATA2']+$result_seData8['DATA2']+$result_seData9['DATA2'];
                                        $subext3 = $result_seData6['DATA3']+$result_seData7['DATA3']+$result_seData8['DATA3']+$result_seData9['DATA3'];
                                        $subext4 = $result_seData6['DATA4']+$result_seData7['DATA4']+$result_seData8['DATA4']+$result_seData9['DATA4'];
                                        $subext5 = $result_seData6['DATA5']+$result_seData7['DATA5']+$result_seData8['DATA5']+$result_seData9['DATA5'];
                                        $subext6 = $result_seData6['DATA6']+$result_seData7['DATA6']+$result_seData8['DATA6']+$result_seData9['DATA6'];
                                        $subext7 = $result_seData6['DATA7']+$result_seData7['DATA7']+$result_seData8['DATA7']+$result_seData9['DATA7'];
                                        $subext8 = $result_seData6['DATA8']+$result_seData7['DATA8']+$result_seData8['DATA8']+$result_seData9['DATA8'];
                                        $subext9 = $result_seData6['DATA9']+$result_seData7['DATA9']+$result_seData8['DATA9']+$result_seData9['DATA9'];
                                        $subext10 = $result_seData6['DATA10']+$result_seData7['DATA10']+$result_seData8['DATA10']+$result_seData9['DATA10'];
                                        $subext11 = $result_seData6['DATA11']+$result_seData7['DATA11']+$result_seData8['DATA11']+$result_seData9['DATA11'];
                                        $subext12 = $result_seData6['DATA12']+$result_seData7['DATA12']+$result_seData8['DATA12']+$result_seData9['DATA12'];

                                        
                                        $subperall = ($subper1+$subper2+$subper3+$subper4+$subper5
                                                    +$subper6+$subper7+$subper8+$subper9+$subper10
                                                    +$subper11+$subper12);

                                        $subextall = ($subext1+$subext2+$subext3+$subext4+$subext5
                                                    +$subext6+$subext7+$subext8+$subext9+$subext10
                                                    +$subext11+$subext12);


                                        ?> 
                                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                        <!-- <script type="text/javascript" src="js/jquery.min.js"></script>
                                        <script type="text/javascript" src="js/Chart.min.js"></script> -->
                                        <script type="text/javascript">
                                            google.charts.load('current', {'packages': ['corechart']});
                                            google.charts.setOnLoadCallback(drawChart);

                                            function drawChart() {

                                            var data = google.visualization.arrayToDataTable([
                                                ['Month', 'Personal issue', 'External issue'],
                                                ['Jan<?=$yearsub?>',  <?=$subper1?>, <?=$subext1?>],
                                                ['Feb<?=$yearsub?>',  <?=$subper2?>, <?=$subext2?>],
                                                ['Mar<?=$yearsub?>',  <?=$subper3?>, <?=$subext3?>],
                                                ['Apr<?=$yearsub?>',  <?=$subper4?>, <?=$subext4?>],
                                                ['May<?=$yearsub?>',  <?=$subper5?>, <?=$subext5?>], 
                                                ['Jun<?=$yearsub?>',  <?=$subper6?>, <?=$subext5?>],
                                                ['Jul<?=$yearsub?>',  <?=$subper7?>, <?=$subext7?>],
                                                ['Aug<?=$yearsub?>',  <?=$subper8?>, <?=$subext8?>],
                                                ['Sep<?=$yearsub?>',  <?=$subper9?>, <?=$subext9?>],
                                                ['Oct<?=$yearsub?>',  <?=$subper10?>, <?=$subext10?>],
                                                ['Nov<?=$yearsub?>',  <?=$subper11?>, <?=$subext11?>],
                                                ['Dec<?=$yearsub?>',  <?=$subper12?>, <?=$subext12?>],
                                                ['Acc', <?=$subperall?>, <?=$subextall?>]
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
                                                        role: "annotation" }
                                                ]);

                                            var options = {
                                            title : 'Stop Call Wait',
                                            // vAxis: {title: 'Cups'},
                                            isStacked: true,
                                            bar: { groupWidth: "90%" },
                                            hAxis: {title: 'Month'},
                                            seriesType: 'bars',
                                            legend: {position: 'top'},
                                            series: {
                                                1: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,},
                                                2: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,}
                                                },

                                            tooltip: {

                                            },
                                            colors: ['#008f00', '#C90404', '#008f00', '#C90404' ]
                                                
                                            };

                                            // var chart = new google.visualization.ComboChart(document.getElementById('curve_chart'));
                                            // chart.draw(view, options);

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
            
           
            
            function check_graph()
            {
            //    var monthnumeric = document.getElementById('txt_monthnumberic').value;
            //    var month = document.getElementById('txt_month').value;
               var years = document.getElementById('txt_years').value;
                // alert(months);
                // alert(employeecode);
                window.open('meg_digitaltenko_StopCallWait_graphprint.php?years=' + years, '_blank');

            }
    </script>

    </body>


</html>
