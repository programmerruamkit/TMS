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
                <!-- START DIV GRAPH EXPORT TO PDF -->

                <div  id="testing" style="text-align: center;">
                                             
                    <div class="panel-heading" style="text-align: center;">
                        <h2 class="page-header"><i class="fa fa-bar-chart-o fa-fw"></i>  
                             KPI Data Graph Month:&nbsp;<b><?=$month?></b></b>
                            
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
                                    <form method="post" id="make_pdf" action="create_truckreadinesskpipdf.php?month='<?=$month?>'"  target="_blank">
                                        <input type="hidden" name="hidden_html" id="hidden_html" ></input>
                                        <button type="button" name="create_truckreadinesskpipdf" id="create_truckreadinesskpipdf"   class="btn btn-success btn-lg">Export PDF</button>
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
                                                ['01/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend1']?>,  <?=$result_setruckok['TruckOK1']?>,   <?=$result_seRequirement['Requirement1']?>,             <?=$result_setotaltruck['TotalTruck1']?>,          <?=$truckattper1?>      ],
                                                ['02/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend2']?>,  <?=$result_setruckok['TruckOK2']?>,   <?=$result_seRequirement['Requirement2']?>,             <?=$result_setotaltruck['TotalTruck2']?>,          <?=$truckattper2?>      ],
                                                ['03/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend3']?>,  <?=$result_setruckok['TruckOK3']?>,   <?=$result_seRequirement['Requirement3']?>,             <?=$result_setotaltruck['TotalTruck3']?>,          <?=$truckattper3?>      ],
                                                ['04/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend4']?>,  <?=$result_setruckok['TruckOK4']?>,   <?=$result_seRequirement['Requirement4']?>,             <?=$result_setotaltruck['TotalTruck4']?>,          <?=$truckattper4?>      ],
                                                ['05/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend5']?>,  <?=$result_setruckok['TruckOK5']?>,   <?=$result_seRequirement['Requirement5']?>,             <?=$result_setotaltruck['TotalTruck5']?>,          <?=$truckattper5?>      ],
                                                ['06/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend6']?>,  <?=$result_setruckok['TruckOK6']?>,   <?=$result_seRequirement['Requirement6']?>,             <?=$result_setotaltruck['TotalTruck6']?>,          <?=$truckattper6?>      ],
                                                ['07/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend7']?>,  <?=$result_setruckok['TruckOK7']?>,   <?=$result_seRequirement['Requirement7']?>,             <?=$result_setotaltruck['TotalTruck7']?>,          <?=$truckattper7?>      ],
                                                ['08/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend8']?>,  <?=$result_setruckok['TruckOK8']?>,   <?=$result_seRequirement['Requirement8']?>,             <?=$result_setotaltruck['TotalTruck8']?>,          <?=$truckattper8?>      ],
                                                ['09/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend9']?>,  <?=$result_setruckok['TruckOK9']?>,   <?=$result_seRequirement['Requirement9']?>,             <?=$result_setotaltruck['TotalTruck9']?>,          <?=$truckattper9?>      ],
                                                ['10/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend10']?>,  <?=$result_setruckok['TruckOK10']?>,   <?=$result_seRequirement['Requirement10']?>,             <?=$result_setotaltruck['TotalTruck10']?>,          <?=$truckattper10?>      ],
                                                ['11/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend11']?>,  <?=$result_setruckok['TruckOK11']?>,   <?=$result_seRequirement['Requirement11']?>,             <?=$result_setotaltruck['TotalTruck11']?>,          <?=$truckattper11?>      ],
                                                ['12/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend12']?>,  <?=$result_setruckok['TruckOK12']?>,   <?=$result_seRequirement['Requirement12']?>,             <?=$result_setotaltruck['TotalTruck12']?>,          <?=$truckattper12?>      ],
                                                ['13/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend13']?>,  <?=$result_setruckok['TruckOK13']?>,   <?=$result_seRequirement['Requirement13']?>,             <?=$result_setotaltruck['TotalTruck13']?>,          <?=$truckattper13?>      ],
                                                ['14/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend14']?>,  <?=$result_setruckok['TruckOK14']?>,   <?=$result_seRequirement['Requirement14']?>,             <?=$result_setotaltruck['TotalTruck14']?>,          <?=$truckattper14?>      ],
                                                ['15/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend15']?>,  <?=$result_setruckok['TruckOK15']?>,   <?=$result_seRequirement['Requirement15']?>,             <?=$result_setotaltruck['TotalTruck15']?>,          <?=$truckattper15?>      ],
                                                ['16/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend16']?>,  <?=$result_setruckok['TruckOK16']?>,   <?=$result_seRequirement['Requirement16']?>,             <?=$result_setotaltruck['TotalTruck16']?>,          <?=$truckattper16?>      ],
                                                ['17/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend17']?>,  <?=$result_setruckok['TruckOK17']?>,   <?=$result_seRequirement['Requirement17']?>,             <?=$result_setotaltruck['TotalTruck17']?>,          <?=$truckattper17?>      ],
                                                ['18/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend18']?>,  <?=$result_setruckok['TruckOK18']?>,   <?=$result_seRequirement['Requirement18']?>,             <?=$result_setotaltruck['TotalTruck18']?>,          <?=$truckattper18?>      ],
                                                ['19/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend19']?>,  <?=$result_setruckok['TruckOK19']?>,   <?=$result_seRequirement['Requirement19']?>,             <?=$result_setotaltruck['TotalTruck19']?>,          <?=$truckattper19?>      ],
                                                ['20/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend20']?>,  <?=$result_setruckok['TruckOK20']?>,   <?=$result_seRequirement['Requirement20']?>,             <?=$result_setotaltruck['TotalTruck20']?>,          <?=$truckattper20?>      ],
                                                ['21/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend21']?>,  <?=$result_setruckok['TruckOK21']?>,   <?=$result_seRequirement['Requirement21']?>,             <?=$result_setotaltruck['TotalTruck21']?>,          <?=$truckattper21?>      ],
                                                ['22/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend22']?>,  <?=$result_setruckok['TruckOK22']?>,   <?=$result_seRequirement['Requirement22']?>,             <?=$result_setotaltruck['TotalTruck22']?>,          <?=$truckattper22?>      ],
                                                ['23/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend23']?>,  <?=$result_setruckok['TruckOK23']?>,   <?=$result_seRequirement['Requirement23']?>,             <?=$result_setotaltruck['TotalTruck23']?>,          <?=$truckattper23?>      ],
                                                ['24/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend24']?>,  <?=$result_setruckok['TruckOK24']?>,   <?=$result_seRequirement['Requirement24']?>,             <?=$result_setotaltruck['TotalTruck24']?>,          <?=$truckattper24?>      ],
                                                ['25/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend25']?>,  <?=$result_setruckok['TruckOK25']?>,   <?=$result_seRequirement['Requirement25']?>,             <?=$result_setotaltruck['TotalTruck25']?>,          <?=$truckattper25?>      ],
                                                ['26/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend26']?>,  <?=$result_setruckok['TruckOK26']?>,   <?=$result_seRequirement['Requirement26']?>,             <?=$result_setotaltruck['TotalTruck26']?>,          <?=$truckattper26?>      ],
                                                ['27/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend27']?>,  <?=$result_setruckok['TruckOK27']?>,   <?=$result_seRequirement['Requirement27']?>,             <?=$result_setotaltruck['TotalTruck27']?>,          <?=$truckattper27?>      ],
                                                ['28/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend28']?>,  <?=$result_setruckok['TruckOK28']?>,   <?=$result_seRequirement['Requirement28']?>,             <?=$result_setotaltruck['TotalTruck28']?>,          <?=$truckattper28?>      ],
                                                ['29/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend29']?>,  <?=$result_setruckok['TruckOK29']?>,   <?=$result_seRequirement['Requirement29']?>,             <?=$result_setotaltruck['TotalTruck29']?>,          <?=$truckattper29?>      ],
                                                ['30/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend30']?>,  <?=$result_setruckok['TruckOK30']?>,   <?=$result_seRequirement['Requirement30']?>,             <?=$result_setotaltruck['TotalTruck30']?>,          <?=$truckattper30?>      ],
                                                ['31/<?=$monthnumeric?>/<?=$years?>',  <?=$result_setruckatt['TruckAttend31']?>,  <?=$result_setruckok['TruckOK31']?>,   <?=$result_seRequirement['Requirement31']?>,             <?=$result_setotaltruck['TotalTruck31']?>,          <?=$truckattper31?>      ]

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
            
            function select_graph()
            {
                var months = document.getElementById('select_month').value;
                var employeecode = document.getElementById('txt_empcode').value;

                // alert(months);
                // alert(employeecode);
                window.open('meg_driverdatagraph_check.php?months=' + months + '&employeecode=' + employeecode, '_blank');

            }
            
            function autoclick() {
                document.getElementById("create_truckreadinesskpipdf").click(function(){
                $('#hidden_html').val($('#testing').html());
                $('#make_pdf').submit();
                });
                window.close();
            }
            setTimeout(autoclick, 600);

            $(document).ready(function(){
                $('#create_truckreadinesskpipdf').click(function(){
                $('#hidden_html').val($('#testing').html());
                $('#make_pdf').submit();
                });
            });
           
    </script>

    </body>


</html>
