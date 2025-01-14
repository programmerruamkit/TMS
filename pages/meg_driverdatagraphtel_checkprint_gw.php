<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$sql_seEmpName = "SELECT  nameE,nameT,PersonCode FROM EMPLOYEEEHR2
WHERE PersonCode ='".$_GET['employeecode']."'";
$params_seEmpName = array();
$query_seEmpName = sqlsrv_query($conn, $sql_seEmpName, $params_seEmpName);
$result_seEmpName = sqlsrv_fetch_array($query_seEmpName, SQLSRV_FETCH_ASSOC);

// $strDate = date("Y/m/d");

$date = date_create($_GET['months']); 
$strDate =  date_format($date,"Y/d/m");

function DateThai($strDate)
{
$strMonth= date("n",strtotime($strDate));
$strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$strMonthThai=$strMonthCut[$strMonth];
return $strMonthThai;
}

function DateEng($strDate)
{
$strMonth= date("n",strtotime($strDate));
$strMonthCut = Array("","January","February","March","April","May","June","July","August","September","October","November","December");
$strMonthEng=$strMonthCut[$strMonth];
return $strMonthEng;
}

 
//  echo "ThaiCreate.Com Time now : ".DateThai($strDate);
//  echo "ThaiCreate.Com Time now : ".DateEng($strDate);
//  echo date("Y");

$currentyearshow =  substr($_GET['months'],6,10);

// echo $currentyearshow;   
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
                    <div class="col-lg-12" hidden>
                            <div class="col-lg-12" style="text-align: center;">
                                <h2 class="page-header"><i class="fa fa-bar-chart-o fa-fw"></i>  
                                    กราฟสรุปรวมข้อมูลสุขภาพพนักงาน ประจำเดือน:&nbsp;<b><?=DateThai($strDate)?></b>&nbsp;&nbsp;พนักงาน:&nbsp;<b><?=$result_seEmpName['nameT']?></b>
                                    <input type="hidden" id="txt_empcode" name="txt_empcode" value="<?=$_GET['employeecode']?>" ></imput>
                            
                                    <label>&nbsp;</label>
                                    <!-- <div class="form-group">
                                        <button type="button" class="btn btn-default" onclick="select_graphtest();">ทดสอบกราฟ <li class="fa fa-search"></li></button>
                                    </div> -->

                                    <!-- <div style="align: right;"> -->
                                        
                                        <form method="post" id="make_pdf" action="create_telpdf.php?empname='<?=$result_seEmpName['nameE']?>'"  target="_blank">
                                            <input type="hidden" name="hidden_html" id="hidden_html" ></input>
                                            <button type="button" name="create_telpdf" id="create_telpdf"   class="btn btn-success btn-lg">Export PDF</button>
                                        </form>
                                    <!-- </div>     -->
                             
                                </h2>
                            </div>
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
                            <?php
                                $i = 1;

                                $sql_seStartDate = "SELECT CONVERT(VARCHAR(25),DATEADD(dd,-(DAY('".$strDate."')-1),'".$strDate."'),103) AS 'STARTDATE'";
                                $params_seStartDate = array();
                                $query_seStartDate = sqlsrv_query($conn, $sql_seStartDate, $params_seStartDate);
                                $result_seStartDate = sqlsrv_fetch_array($query_seStartDate, SQLSRV_FETCH_ASSOC);
                                    
                                $sql_seEndDate = "SELECT CONVERT(VARCHAR(25),DATEADD(dd,-(DAY(DATEADD(mm,1,'".$strDate."'))),DATEADD(mm,1,'".$strDate."')),103) AS 'ENDDATE'";
                                $params_seEndDate = array();
                                $query_seEndDate = sqlsrv_query($conn, $sql_seEndDate, $params_seEndDate);
                                $result_seEndDate = sqlsrv_fetch_array($query_seEndDate, SQLSRV_FETCH_ASSOC);    
                                
                                // echo $result_seStartDate['STARTDATE'];
                                // echo "<br>";
                                // echo $result_seEndDate['ENDDATE'];
                                /////////////////QUERY ค้นหาข้อมูล///////////////////////////////////////////////////
                                //COUNT RANK A
                                $sql_seCountA = "SELECT COUNT(b.TELCHECKID) AS 'COUNT_A'
                                    FROM VEHICLETRANSPORTPLAN a 
                                    INNER JOIN DRIVERTELCHECK b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                                    WHERE b.EMPLOYEECODE ='".$_GET['employeecode']."'
                                    AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'".$result_seStartDate['STARTDATE']."',103) AND CONVERT(DATE,'".$result_seEndDate['ENDDATE']."',103)
                                    AND b.RANKDRIVER ='A'";
                                $params_seCountA = array();
                                $query_seCountA  = sqlsrv_query($conn, $sql_seCountA, $params_seCountA);
                                $result_seCountA = sqlsrv_fetch_array($query_seCountA, SQLSRV_FETCH_ASSOC);
                                
                                $COUNTA = $result_seCountA['COUNT_A'];
                                // echo $COUNTA;

                                //////////////////////////////////////////////////////////////////////
                                //COUNT RANK B
                                $sql_seCountB = "SELECT COUNT(b.TELCHECKID) AS 'COUNT_B'
                                    FROM VEHICLETRANSPORTPLAN a 
                                    INNER JOIN DRIVERTELCHECK b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                                    WHERE b.EMPLOYEECODE ='".$_GET['employeecode']."'
                                    AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'".$result_seStartDate['STARTDATE']."',103) AND CONVERT(DATE,'".$result_seEndDate['ENDDATE']."',103)
                                    AND b.RANKDRIVER ='B'";
                                $params_seCountB = array();
                                $query_seCountB  = sqlsrv_query($conn, $sql_seCountB, $params_seCountB);
                                $result_seCountB = sqlsrv_fetch_array($query_seCountB, SQLSRV_FETCH_ASSOC);
                                
                                $COUNTB = $result_seCountB['COUNT_B'];
                                // echo $COUNTB;
                                    //////////////////////////////////////////////////////////////////////

                                    //COUNT RANK C
                                $sql_seCountC = "SELECT COUNT(b.TELCHECKID) AS 'COUNT_C'
                                FROM VEHICLETRANSPORTPLAN a 
                                INNER JOIN DRIVERTELCHECK b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                                WHERE b.EMPLOYEECODE ='".$_GET['employeecode']."'
                                AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'".$result_seStartDate['STARTDATE']."',103) AND CONVERT(DATE,'".$result_seEndDate['ENDDATE']."',103)
                                AND b.RANKDRIVER ='C'";
                                $params_seCountC = array();
                                $query_seCountC  = sqlsrv_query($conn, $sql_seCountC, $params_seCountC);
                                $result_seCountC = sqlsrv_fetch_array($query_seCountC, SQLSRV_FETCH_ASSOC);

                                $COUNTC = $result_seCountC['COUNT_C'];
                                // echo $COUNTC;
                                //////////////////////////////////////////////////////////////////////

                                //COUNT RANK D
                                $sql_seCountD = "SELECT COUNT(b.TELCHECKID) AS 'COUNT_D'
                                    FROM VEHICLETRANSPORTPLAN a 
                                    INNER JOIN DRIVERTELCHECK b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                                    WHERE b.EMPLOYEECODE ='".$_GET['employeecode']."'
                                    AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'".$result_seStartDate['STARTDATE']."',103) AND CONVERT(DATE,'".$result_seEndDate['ENDDATE']."',103)
                                    AND b.RANKDRIVER ='D'";
                                $params_seCountD = array();
                                $query_seCountD  = sqlsrv_query($conn, $sql_seCountD, $params_seCountD);
                                $result_seCountD = sqlsrv_fetch_array($query_seCountD, SQLSRV_FETCH_ASSOC);
                                
                                $COUNTD = $result_seCountD['COUNT_D'];
                                // echo $COUNTD;
                               
                                                            

                               

                                     
                                ?>

                            <!-- START ROW ความดันค่าบน ค่าล่าง-->
                                                               
                                <div class="row">
                                    <!-- <div class="col-lg-12" style="text-align:center;">
                                        <h2 class="page-header"><i class="fa fa-bar-chart-o fa-fw"></i>  
                                        กราฟข้อมูลค่าความดันค่าบน-ค่าล่างของพนักงาน
                                        </h2>
                                    </div>                            -->
                                    <div class="col-lg-12">


                                        
                                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                        <!-- <script type="text/javascript" src="js/jquery.min.js"></script>
                                        <script type="text/javascript" src="js/Chart.min.js"></script> -->
                                        <script type="text/javascript">

                                                        google.charts.load("current", {packages:['corechart']});
                                                        google.charts.setOnLoadCallback(drawChart);
                                                        
                                                        function drawChart() {
                                                            var data = google.visualization.arrayToDataTable([
                                                                ["Rank", "Count", { role: "style" } ],
                                                                ["Rank A", <?=$COUNTA?>,  "#ff3434"],
                                                                ["Rank B", <?=$COUNTB?>, "#ffad33"],
                                                                ["Rank C", <?=$COUNTC?>, "#ffff66"],
                                                                ["Rank D", <?=$COUNTD?>, "#5cd65c"]
                                                            ]);

                                                            var view = new google.visualization.DataView(data);
                                                            view.setColumns([0, 1,
                                                                            { calc: "stringify",
                                                                                sourceColumn: 1,
                                                                                type: "string",
                                                                                role: "annotation" },
                                                                            2]);

                                                            var options = {
                                                                title: "Employee Cell Phone Use (Rank).",
                                                                // width: 1500,
                                                                // height: 600,
                                                                // bar: {groupWidth: "100%"},
                                                                legend: { position: "none" },
                                                            };

                                                        
                                                        // var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
                                                        // var chart1 = new google.visualization.LineChart(document.getElementById('curve_chart'));
                                                        
                                                        var chart_area = document.getElementById('columnchart_values');
                                                        var chart = new google.visualization.ColumnChart(chart_area);

                                                        google.visualization.events.addListener(chart, 'ready', function(){
                                                            chart_area.innerHTML = '<img src="' + chart.getImageURI() + '" class="img-responsive">';
                                                        });
                                                        chart.draw(view, options);
                                                        // chart1.draw(view, options);
                                                        
                                                    }
                                        </script>
                                        <!-- <div id="curve_chart" style="width: 100%; height: 500px"></div> -->
                                    
                                            
                                            
                                            

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

                <!-- START DIV GRAPH EXPORT TO PDF -->

                <div  id="testing" style="text-align: center;">
                                             
                    <div class="panel-heading" style="text-align: center;">
                        <h1 class="page-header"> 
                            All Data Graph Driver: <b><?=$result_seEmpName['nameE']?></b> Month: <b><?=DateEng($strDate)?>/<?=$currentyearshow?></b>
                        </h1>
                    </div>
                    <!-- กราฟความดันบน-ล่าง -->
                    <div class="panel-body" align="center">
                        <h1 class=""><i class="fa fa-bar-chart-o fa-fw"></i>  
                         Employee Cell Phone Use (Rank).
                        </h1><br>
                        <!-- <font style="font-size: 20px;">Avg.SYS &nbsp;<b><?=number_format($SYSAVG,2)?></b>&nbsp;&nbsp;&nbsp;</font>
                        <font style="font-size: 20px;">Avg.DIA &nbsp;<b><?=number_format($DIAAVG,2)?></b>&nbsp;&nbsp;&nbsp;</font> -->
                    </div>
                    <div class="panel-body" align="center">
                        <div  style="width:100%">
                            <div id="columnchart_values" style="height: 550px" ></div>
                        </div>
                        
                    </div>
                    <!-- ปิดคอลัมกราฟความดันเลือด -->
                    <br>
                </div>
                <!-- END DIV GRAPH EXPORT TO PDF -->


                                                       
                

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
        
                
            //AUTO CLICK FUNCTION PRINT GRAPH
            
            function autoclick() {
                document.getElementById("create_telpdf").click(function(){
                $('#hidden_html').val($('#testing').html());
                $('#make_pdf').submit();
                });
                window.close();
            }
            setTimeout(autoclick, 700);

           

            $(document).ready(function(){
                $('#create_telpdf').click(function(){
                $('#hidden_html').val($('#testing').html());
                $('#make_pdf').submit();
                });
            });

            // $(document).ready(function () {
            //     $('#dataTables-example').DataTable({
            //         responsive: true,
            //     });
            // });
         
           
    </script>

    </body>


</html>
