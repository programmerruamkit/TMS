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
                                        //DRIVER ATTEND
                                        $sql_sedriveratt = "SELECT (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten1',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten2',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten3',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten4',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten5',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten6',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten7',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten8',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten9',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten10',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten11',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten12',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten13',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten14',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten15',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten16',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten17',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten18',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten19',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten20',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten21',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten22',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten23',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten24',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten25',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten26',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten27',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten28',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten29',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten30',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Driver_Attend' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'DriverAtten31'";
                                        $params_sedriveratt = array();
                                        $query_sedriveratt = sqlsrv_query($conn, $sql_sedriveratt, $params_sedriveratt);
                                        $result_sedriveratt = sqlsrv_fetch_array($query_sedriveratt, SQLSRV_FETCH_ASSOC);
                                        
                                        $sql_seokdriver = "SELECT (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver1',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver2',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver3',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver4',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver5',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver6',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver7',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver8',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver9',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver10',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver11',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver12',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver13',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver14',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver15',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver16',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver17',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver18',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver19',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver20',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver21',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver22',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver23',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver24',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver25',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver26',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver27',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver28',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver29',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver30',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                            AND REMARK ='OK_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'OkDriver31'";
                                        $params_seokdriver  = array();
                                        $query_seokdriver = sqlsrv_query($conn, $sql_seokdriver, $params_seokdriver);
                                        $result_seokdriver = sqlsrv_fetch_array($query_seokdriver, SQLSRV_FETCH_ASSOC);

                                        $sql_seRequirement = "SELECT (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement1',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement2',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement3',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement4',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement5',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement6',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement7',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement8',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement9',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement10',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement11',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement12',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement13',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement14',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement15',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement16',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement17',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement18',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement19',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement20',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement21',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement22',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement23',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement24',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement25',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement26',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement27',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement28',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement29',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement30',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Requirement' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'Requirement31'";
                                        $params_seRequirement  = array();
                                        $query_seRequirement = sqlsrv_query($conn, $sql_seRequirement, $params_seRequirement);
                                        $result_seRequirement = sqlsrv_fetch_array($query_seRequirement, SQLSRV_FETCH_ASSOC);
                                                                
                                        $sql_setotaldriver = "SELECT (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver1',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver2',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver3',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver4',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver5',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver6',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver7',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver8',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver9',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver10',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver11',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver12',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver13',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver14',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver15',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver16',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver17',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver18',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver19',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver20',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver21',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver22',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver23',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver24',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver25',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver26',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver27',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver28',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver29',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver30',
                                            (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                            WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                            AND REMARK ='Total_Driver' 
                                            AND REMARK_MONTH ='".$month."' 
                                            AND REMARK_YEARS ='".$years."') AS 'TotalDriver31'";
                                        $params_setotaldriver  = array();
                                        $query_setotaldriver = sqlsrv_query($conn, $sql_setotaldriver, $params_setotaldriver);
                                        $result_setotaldriver = sqlsrv_fetch_array($query_setotaldriver, SQLSRV_FETCH_ASSOC);

                                        $sql_sedriverattper = "SELECT (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper1',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper2',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper3',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper4',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper5',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper6',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper7',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper8',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper9',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper10',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper11',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper12',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper13',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper14',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper15',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper16',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper17',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper18',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper19',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper20',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper21',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper22',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper23',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper24',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper25',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper26',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper27',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper28',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper29',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper30',
                                                                (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
                                                                WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
                                                                AND REMARK ='Driver_Attend_Per' 
                                                                AND REMARK_MONTH ='".$month."' 
                                                                AND REMARK_YEARS ='".$years."') AS 'Driverattper31'";
                                                                $params_sedriverattper  = array();
                                                                $query_sedriverattper = sqlsrv_query($conn, $sql_sedriverattper, $params_sedriverattper);
                                                                $result_sedriverattper = sqlsrv_fetch_array($query_sedriverattper, SQLSRV_FETCH_ASSOC);

                                                                if ($result_sedriverattper['Driverattper1'] == '' || $result_sedriverattper['Driverattper1'] == NULL) {
                                                                   $driverattper1 = '0';
                                                                }else{
                                                                   $driverattper1 = $result_sedriverattper['Driverattper1'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper2'] == '' || $result_sedriverattper['Driverattper2'] == NULL) {
                                                                   $driverattper2 = '0';
                                                                }else{
                                                                   $driverattper2 = $result_sedriverattper['Driverattper2'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper3'] == '' || $result_sedriverattper['Driverattper3'] == NULL) {
                                                                    $driverattper3 = '0';
                                                                }else{
                                                                    $driverattper3 = $result_sedriverattper['Driverattper3'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper4'] == '' || $result_sedriverattper['Driverattper4'] == NULL) {
                                                                    $driverattper4 = '0';
                                                                }else{
                                                                    $driverattper4 = $result_sedriverattper['Driverattper4'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper5'] == '' || $result_sedriverattper['Driverattper5'] == NULL) {
                                                                    $driverattper5 = '0';
                                                                }else{
                                                                    $driverattper5 = $result_sedriverattper['Driverattper5'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper6'] == '' || $result_sedriverattper['Driverattper6'] == NULL) {
                                                                    $driverattper6 = '0';
                                                                }else{
                                                                    $driverattper6 = $result_sedriverattper['Driverattper6'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper7'] == '' || $result_sedriverattper['Driverattper7'] == NULL) {
                                                                    $driverattper7 = '0';
                                                                }else{
                                                                    $driverattper7 = $result_sedriverattper['Driverattper7'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper8'] == '' || $result_sedriverattper['Driverattper8'] == NULL) {
                                                                    $driverattper8 = '0';
                                                                }else{
                                                                    $driverattper8 = $result_sedriverattper['Driverattper8'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper9'] == '' || $result_sedriverattper['Driverattper9'] == NULL) {
                                                                    $driverattper9 = '0';
                                                                }else{
                                                                    $driverattper9 = $result_sedriverattper['Driverattper9'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper10'] == '' || $result_sedriverattper['Driverattper10'] == NULL) {
                                                                    $driverattper10 = '0';
                                                                }else{
                                                                    $driverattper10 = $result_sedriverattper['Driverattper10'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper11'] == '' || $result_sedriverattper['Driverattper11'] == NULL) {
                                                                    $driverattper11 = '0';
                                                                }else{
                                                                    $driverattper11 = $result_sedriverattper['Driverattper11'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper12'] == '' || $result_sedriverattper['Driverattper12'] == NULL) {
                                                                    $driverattper12 = '0';
                                                                }else{
                                                                    $driverattper12 = $result_sedriverattper['Driverattper12'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper13'] == '' || $result_sedriverattper['Driverattper13'] == NULL) {
                                                                    $driverattper13 = '0';
                                                                }else{
                                                                    $driverattper13 = $result_sedriverattper['Driverattper13'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper14'] == '' || $result_sedriverattper['Driverattper14'] == NULL) {
                                                                    $driverattper14 = '0';
                                                                }else{
                                                                    $driverattper14 = $result_sedriverattper['Driverattper14'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper15'] == '' || $result_sedriverattper['Driverattper15'] == NULL) {
                                                                    $driverattper15 = '0';
                                                                }else{
                                                                    $driverattper15 = $result_sedriverattper['Driverattper15'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper16'] == '' || $result_sedriverattper['Driverattper16'] == NULL) {
                                                                    $driverattper16 = '0';
                                                                }else{
                                                                    $driverattper16 = $result_sedriverattper['Driverattper16'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper17'] == '' || $result_sedriverattper['Driverattper17'] == NULL) {
                                                                    $driverattper17 = '0';
                                                                }else{
                                                                    $driverattper17 = $result_sedriverattper['Driverattper17'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper18'] == '' || $result_sedriverattper['Driverattper18'] == NULL) {
                                                                    $driverattper18 = '0';
                                                                }else{
                                                                    $driverattper18 = $result_sedriverattper['Driverattper18'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper19'] == '' || $result_sedriverattper['Driverattper19'] == NULL) {
                                                                    $driverattper19 = '0';
                                                                }else{
                                                                    $driverattper19 = $result_sedriverattper['Driverattper19'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper20'] == '' || $result_sedriverattper['Driverattper20'] == NULL) {
                                                                    $driverattper20 = '0';
                                                                }else{
                                                                    $driverattper20 = $result_sedriverattper['Driverattper20'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper21'] == '' || $result_sedriverattper['Driverattper21'] == NULL) {
                                                                    $driverattper21 = '0';
                                                                }else{
                                                                    $driverattper21 = $result_sedriverattper['Driverattper21'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper22'] == '' || $result_sedriverattper['Driverattper22'] == NULL) {
                                                                    $driverattper22 = '0';
                                                                }else{
                                                                    $driverattper22 = $result_sedriverattper['Driverattper22'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper23'] == '' || $result_sedriverattper['Driverattper23'] == NULL) {
                                                                    $driverattper23 = '0';
                                                                }else{
                                                                    $driverattper23 = $result_sedriverattper['Driverattper23'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper24'] == '' || $result_sedriverattper['Driverattper24'] == NULL) {
                                                                    $driverattper24 = '0';
                                                                }else{
                                                                    $driverattper24 = $result_sedriverattper['Driverattper24'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper25'] == '' || $result_sedriverattper['Driverattper25'] == NULL) {
                                                                    $driverattper25 = '0';
                                                                }else{
                                                                    $driverattper25 = $result_sedriverattper['Driverattper25'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper26'] == '' || $result_sedriverattper['Driverattper26'] == NULL) {
                                                                    $driverattper26 = '0';
                                                                }else{
                                                                    $driverattper26 = $result_sedriverattper['Driverattper26'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper27'] == '' || $result_sedriverattper['Driverattper27'] == NULL) {
                                                                    $driverattper27 = '0';
                                                                }else{
                                                                    $driverattper27 = $result_sedriverattper['Driverattper27'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper28'] == '' || $result_sedriverattper['Driverattper28'] == NULL) {
                                                                    $driverattper28 = '0';
                                                                }else{
                                                                    $driverattper28 = $result_sedriverattper['Driverattper28'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper29'] == '' || $result_sedriverattper['Driverattper29'] == NULL) {
                                                                    $driverattper29 = '0';
                                                                }else{
                                                                    $driverattper29 = $result_sedriverattper['Driverattper29'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper30'] == '' || $result_sedriverattper['Driverattper30'] == NULL) {
                                                                    $driverattper30 = '0';
                                                                }else{
                                                                    $driverattper30 = $result_sedriverattper['Driverattper30'];
                                                                }

                                                                if ($result_sedriverattper['Driverattper31'] == '' || $result_sedriverattper['Driverattper31'] == NULL) {
                                                                    $driverattper31 = '0';
                                                                }else{
                                                                    $driverattper31 = $result_sedriverattper['Driverattper31'];
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
                                                ['Day', 'Driver attend', 'Ok Driver', 'Requirement', 'Total Driver', 'Driver attend %',],
                                                ['01/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten1']?>,  <?=$result_seokdriver['OkDriver1']?>,   <?=$result_seRequirement['Requirement1']?>,             <?=$result_setotaldriver['TotalDriver1']?>,          <?=$driverattper1?>      ],
                                                ['02/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten2']?>,  <?=$result_seokdriver['OkDriver2']?>,   <?=$result_seRequirement['Requirement2']?>,             <?=$result_setotaldriver['TotalDriver2']?>,          <?=$driverattper2?>      ],
                                                ['03/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten3']?>,  <?=$result_seokdriver['OkDriver3']?>,   <?=$result_seRequirement['Requirement3']?>,             <?=$result_setotaldriver['TotalDriver3']?>,          <?=$driverattper3?>      ],
                                                ['04/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten4']?>,  <?=$result_seokdriver['OkDriver4']?>,   <?=$result_seRequirement['Requirement4']?>,             <?=$result_setotaldriver['TotalDriver4']?>,          <?=$driverattper4?>      ],
                                                ['05/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten5']?>,  <?=$result_seokdriver['OkDriver5']?>,   <?=$result_seRequirement['Requirement5']?>,             <?=$result_setotaldriver['TotalDriver5']?>,          <?=$driverattper5?>      ],
                                                ['06/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten6']?>,  <?=$result_seokdriver['OkDriver6']?>,   <?=$result_seRequirement['Requirement6']?>,             <?=$result_setotaldriver['TotalDriver6']?>,          <?=$driverattper6?>      ],
                                                ['07/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten7']?>,  <?=$result_seokdriver['OkDriver7']?>,   <?=$result_seRequirement['Requirement7']?>,             <?=$result_setotaldriver['TotalDriver7']?>,          <?=$driverattper7?>      ],
                                                ['08/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten8']?>,  <?=$result_seokdriver['OkDriver8']?>,   <?=$result_seRequirement['Requirement8']?>,             <?=$result_setotaldriver['TotalDriver8']?>,          <?=$driverattper8?>      ],
                                                ['09/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten9']?>,  <?=$result_seokdriver['OkDriver9']?>,   <?=$result_seRequirement['Requirement9']?>,             <?=$result_setotaldriver['TotalDriver9']?>,          <?=$driverattper9?>      ],
                                                ['10/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten10']?>,  <?=$result_seokdriver['OkDriver10']?>,   <?=$result_seRequirement['Requirement10']?>,             <?=$result_setotaldriver['TotalDriver10']?>,          <?=$driverattper10?>      ],
                                                ['11/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten11']?>,  <?=$result_seokdriver['OkDriver11']?>,   <?=$result_seRequirement['Requirement11']?>,             <?=$result_setotaldriver['TotalDriver11']?>,          <?=$driverattper11?>      ],
                                                ['12/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten12']?>,  <?=$result_seokdriver['OkDriver12']?>,   <?=$result_seRequirement['Requirement12']?>,             <?=$result_setotaldriver['TotalDriver12']?>,          <?=$driverattper12?>      ],
                                                ['13/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten13']?>,  <?=$result_seokdriver['OkDriver13']?>,   <?=$result_seRequirement['Requirement13']?>,             <?=$result_setotaldriver['TotalDriver13']?>,          <?=$driverattper13?>      ],
                                                ['14/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten14']?>,  <?=$result_seokdriver['OkDriver14']?>,   <?=$result_seRequirement['Requirement14']?>,             <?=$result_setotaldriver['TotalDriver14']?>,          <?=$driverattper14?>      ],
                                                ['15/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten15']?>,  <?=$result_seokdriver['OkDriver15']?>,   <?=$result_seRequirement['Requirement15']?>,             <?=$result_setotaldriver['TotalDriver15']?>,          <?=$driverattper15?>      ],
                                                ['16/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten16']?>,  <?=$result_seokdriver['OkDriver16']?>,   <?=$result_seRequirement['Requirement16']?>,             <?=$result_setotaldriver['TotalDriver16']?>,          <?=$driverattper16?>      ],
                                                ['17/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten17']?>,  <?=$result_seokdriver['OkDriver17']?>,   <?=$result_seRequirement['Requirement17']?>,             <?=$result_setotaldriver['TotalDriver17']?>,          <?=$driverattper17?>      ],
                                                ['18/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten18']?>,  <?=$result_seokdriver['OkDriver18']?>,   <?=$result_seRequirement['Requirement18']?>,             <?=$result_setotaldriver['TotalDriver18']?>,          <?=$driverattper18?>      ],
                                                ['19/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten19']?>,  <?=$result_seokdriver['OkDriver19']?>,   <?=$result_seRequirement['Requirement19']?>,             <?=$result_setotaldriver['TotalDriver19']?>,          <?=$driverattper19?>      ],
                                                ['20/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten20']?>,  <?=$result_seokdriver['OkDriver20']?>,   <?=$result_seRequirement['Requirement20']?>,             <?=$result_setotaldriver['TotalDriver20']?>,          <?=$driverattper20?>      ],
                                                ['21/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten21']?>,  <?=$result_seokdriver['OkDriver21']?>,   <?=$result_seRequirement['Requirement21']?>,             <?=$result_setotaldriver['TotalDriver21']?>,          <?=$driverattper21?>      ],
                                                ['22/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten22']?>,  <?=$result_seokdriver['OkDriver22']?>,   <?=$result_seRequirement['Requirement22']?>,             <?=$result_setotaldriver['TotalDriver22']?>,          <?=$driverattper22?>      ],
                                                ['23/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten23']?>,  <?=$result_seokdriver['OkDriver23']?>,   <?=$result_seRequirement['Requirement23']?>,             <?=$result_setotaldriver['TotalDriver23']?>,          <?=$driverattper23?>      ],
                                                ['24/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten24']?>,  <?=$result_seokdriver['OkDriver24']?>,   <?=$result_seRequirement['Requirement24']?>,             <?=$result_setotaldriver['TotalDriver24']?>,          <?=$driverattper24?>      ],
                                                ['25/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten25']?>,  <?=$result_seokdriver['OkDriver25']?>,   <?=$result_seRequirement['Requirement25']?>,             <?=$result_setotaldriver['TotalDriver25']?>,          <?=$driverattper25?>      ],
                                                ['26/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten26']?>,  <?=$result_seokdriver['OkDriver26']?>,   <?=$result_seRequirement['Requirement26']?>,             <?=$result_setotaldriver['TotalDriver26']?>,          <?=$driverattper26?>      ],
                                                ['27/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten27']?>,  <?=$result_seokdriver['OkDriver27']?>,   <?=$result_seRequirement['Requirement27']?>,             <?=$result_setotaldriver['TotalDriver27']?>,          <?=$driverattper27?>      ],
                                                ['28/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten28']?>,  <?=$result_seokdriver['OkDriver28']?>,   <?=$result_seRequirement['Requirement28']?>,             <?=$result_setotaldriver['TotalDriver28']?>,          <?=$driverattper28?>      ],
                                                ['29/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten29']?>,  <?=$result_seokdriver['OkDriver29']?>,   <?=$result_seRequirement['Requirement29']?>,             <?=$result_setotaldriver['TotalDriver29']?>,          <?=$driverattper29?>      ],
                                                ['30/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten30']?>,  <?=$result_seokdriver['OkDriver30']?>,   <?=$result_seRequirement['Requirement30']?>,             <?=$result_setotaldriver['TotalDriver30']?>,          <?=$driverattper30?>      ],
                                                ['31/<?=$monthnumeric?>/<?=$years?>',  <?=$result_sedriveratt['DriverAtten31']?>,  <?=$result_seokdriver['OkDriver31']?>,   <?=$result_seRequirement['Requirement31']?>,             <?=$result_setotaldriver['TotalDriver31']?>,          <?=$driverattper31?>      ]

                                                ]);
                                                
                                                

                                                var view = new google.visualization.DataView(data);
                                                view.setColumns([
                                                        0,
                                                        
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
                                                title : 'Tenko process checking result',
                                                // vAxis: {title: 'Cups'},
                                                hAxis: {title: 'Month'},
                                                // seriesType: 'bars',
                                                legend: {position: 'top'},
                                                series: {
                                                        0: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,},
                                                        1: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,},
                                                        2: {type: 'line',lineWidth: 5,pointShape:'circle',pointSize: 10,},
                                                        3: {type: 'line',lineWidth: 5,pointShape:'circle',pointSize: 10,},
                                                        4: {type: 'line',lineWidth: 5,pointShape:'circle',pointSize: 10,}
                                                        },
                                                
                                                tooltip: {

                                                },
                                                colors: ['#D2D6D9', '#009E18', '#F74D4D', '#57DEF2','#000000' ]
                                                        
                                                };

                                                var chart = new google.visualization.ComboChart(document.getElementById('curve_chart'));
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
                window.open('meg_digitaltenko_KPI_graphprint.php?monthnumeric=' + monthnumeric + '&month=' + month+ '&years=' + years, '_blank');

            }
    </script>

    </body>


</html>
