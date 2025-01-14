<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$strDate = date("Y/m/d");
function DateThai($strDate)
{
$strMonth= date("n",strtotime($strDate));
$strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$strMonthThai=$strMonthCut[$strMonth];
return "$strMonthThai";
}

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
                <br>
                <!-- START DIV GRAPH EXPORT TO PDF -->

                <div  id="testing">
                                             
                    <div class="col-lg-12" style="text-align:center;">
                        <h2 class="page-header"><i class="fa fa-bar-chart-o fa-fw"></i>  
                            Data Graph Punctuality Annual:&nbsp;<b><?=$years;?></b>
                            <input type="hidden" id="txt_empcode" name="txt_empcode" value="<?=$_GET['employeecode']?>" ></imput>
                        </h2>
                    </div>
                    <!-- กราฟความดันบน-ล่าง -->
                    <div class="panel-body">
                    <h3>1. Departure Time Truck Yard</h3>
                    <div id="chart_yard" style="width: 100%; height: 500px"></div><!-- CHART YARD -->
                    <hr>
                    <h3>2. Arrival Time Supplier</h3>
                    <div id="chart_supplier" style="width: 100%; height: 500px"></div><!-- CHART SUPPLIER -->
                    <hr>
                    <h3>3. Arrival Time Plant</h3>
                    <div id="chart_plant" style="width: 100%; height: 500px"></div><!-- CHART PLANT -->
                    </div>
                            
                    
                </div>
                <!-- END DIV GRAPH EXPORT TO PDF -->
                
                <!-- START ROW1 -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">                          
                                <div class="col-lg-12" style="text-align: center;">   
                                        <form method="post" id="make_pdf" action="meg_digitaltenko_Punctuality_YearGraphPrintCreatePDF.php?month='<?=$month?>'"  target="_blank">
                                            <input type="hidden" name="hidden_html" id="hidden_html" ></input>
                                            <button type="button" name="create_kpipdf" id="create_kpipdf"   class="btn btn-success btn-lg">Export PDF</button>
                                        </form>
                                </div>     
                                <div class="row question-template">
                                    <div class="col-lg-12" style="text-align:center;">
                                        <!-- <h2 class="page-header"><i class="fa fa-bar-chart-o fa-fw"></i>  
                                            กราฟข้อมูล Punctuality ประจำปี:&nbsp;<b><?=DateThai($strDate)?></b>
                                            กราฟข้อมูล Punctuality ประจำปี:&nbsp;<b><?=$years+543?></b>
                                            <input type="hidden" id="txt_empcode" name="txt_empcode" value="<?=$_GET['employeecode']?>" ></imput>
                                        </h2> -->
                                    </div>                           
                                    <div class="col-lg-12">
                                        <?php
                                            // YARD 
                                            // ------------------------------------------------------------------------------------------------------------------
                                            // QUERY YARD_DELAY
                                                $sql_seYARD_DELAY = "SELECT
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '01' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY1',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '02' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY2',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '03' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY3',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '04' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY4',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '05' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY5',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '06' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY6',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '07' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY7',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '08' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY8',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '09' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY9',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '10' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY10',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '11' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY11',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '12' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY12'";
                                                $params_seYARD_DELAY = array();
                                                $query_seYARD_DELAY = sqlsrv_query($conn, $sql_seYARD_DELAY, $params_seYARD_DELAY);
                                                $result_seYARD_DELAY = sqlsrv_fetch_array($query_seYARD_DELAY, SQLSRV_FETCH_ASSOC);
                                                $DYD1=$result_seYARD_DELAY['YARDDELAY1'];$DYD2=$result_seYARD_DELAY['YARDDELAY2'];$DYD3=$result_seYARD_DELAY['YARDDELAY3'];$DYD4=$result_seYARD_DELAY['YARDDELAY4'];
                                                $DYD5=$result_seYARD_DELAY['YARDDELAY5'];$DYD6=$result_seYARD_DELAY['YARDDELAY6'];$DYD7=$result_seYARD_DELAY['YARDDELAY7'];$DYD8=$result_seYARD_DELAY['YARDDELAY8'];
                                                $DYD9=$result_seYARD_DELAY['YARDDELAY9'];$DYD10=$result_seYARD_DELAY['YARDDELAY10'];$DYD11=$result_seYARD_DELAY['YARDDELAY11'];$DYD12=$result_seYARD_DELAY['YARDDELAY12'];
                                               
                                            // QUERY YARD_ADVANCE
                                                $sql_seYARD_ADVANCE = "SELECT
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ADVANCE  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '01' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE1',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ADVANCE  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '02' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE2',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ADVANCE  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '03' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE3',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ADVANCE  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '04' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE4',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ADVANCE  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '05' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE5',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ADVANCE  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '06' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE6',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ADVANCE  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '07' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE7',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ADVANCE  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '08' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE8',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ADVANCE  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '09' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE9',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ADVANCE  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '10' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE10',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ADVANCE  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '11' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE11',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ADVANCE  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '12' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE12'";
                                                $params_seYARD_ADVANCE  = array();
                                                $query_seYARD_ADVANCE = sqlsrv_query($conn, $sql_seYARD_ADVANCE, $params_seYARD_ADVANCE);
                                                $result_seYARD_ADVANCE = sqlsrv_fetch_array($query_seYARD_ADVANCE, SQLSRV_FETCH_ASSOC);
                                                $DYA1=$result_seYARD_ADVANCE['YARDADVANCE1'];$DYA2=$result_seYARD_ADVANCE['YARDADVANCE2'];$DYA3=$result_seYARD_ADVANCE['YARDADVANCE3'];$DYA4=$result_seYARD_ADVANCE['YARDADVANCE4'];
                                                $DYA5=$result_seYARD_ADVANCE['YARDADVANCE5'];$DYA6=$result_seYARD_ADVANCE['YARDADVANCE6'];$DYA7=$result_seYARD_ADVANCE['YARDADVANCE7'];$DYA8=$result_seYARD_ADVANCE['YARDADVANCE8'];
                                                $DYA9=$result_seYARD_ADVANCE['YARDADVANCE9'];$DYA10=$result_seYARD_ADVANCE['YARDADVANCE10'];$DYA11=$result_seYARD_ADVANCE['YARDADVANCE11'];$DYA12=$result_seYARD_ADVANCE['YARDADVANCE12'];

                                            // QUERY YARD_ONTIME
                                                $sql_seYARD_ONTIME = "SELECT
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ONTIME  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '01' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME1',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ONTIME  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '02' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME2',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ONTIME  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '03' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME3',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ONTIME  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '04' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME4',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ONTIME  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '05' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME5',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ONTIME  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '06' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME6',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ONTIME  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '07' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME7',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ONTIME  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '08' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME8',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ONTIME  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '09' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME9',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ONTIME  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '10' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME10',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ONTIME  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '11' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME11',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS YARD_ONTIME  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '12' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME12'";
                                                $params_seYARD_ONTIME  = array();
                                                $query_seYARD_ONTIME = sqlsrv_query($conn, $sql_seYARD_ONTIME, $params_seYARD_ONTIME);
                                                $result_seYARD_ONTIME = sqlsrv_fetch_array($query_seYARD_ONTIME, SQLSRV_FETCH_ASSOC);
                                                $DYOT1=$result_seYARD_ONTIME['YARDONTIME1'];$DYOT2=$result_seYARD_ONTIME['YARDONTIME2'];$DYOT3=$result_seYARD_ONTIME['YARDONTIME3'];$DYOT4=$result_seYARD_ONTIME['YARDONTIME4'];
                                                $DYOT5=$result_seYARD_ONTIME['YARDONTIME5'];$DYOT6=$result_seYARD_ONTIME['YARDONTIME6'];$DYOT7=$result_seYARD_ONTIME['YARDONTIME7'];$DYOT8=$result_seYARD_ONTIME['YARDONTIME8'];
                                                $DYOT9=$result_seYARD_ONTIME['YARDONTIME9'];$DYOT10=$result_seYARD_ONTIME['YARDONTIME10'];$DYOT11=$result_seYARD_ONTIME['YARDONTIME11'];$DYOT12=$result_seYARD_ONTIME['YARDONTIME12'];
                                            
                                            // OPEN CAL YARD DYD+DYA+DYOT
                                                $DYTOTAL1 = $DYD1+$DYA1+$DYOT1;
                                                $DYTOTAL2 = $DYD2+$DYA2+$DYOT2;
                                                $DYTOTAL3 = $DYD3+$DYA3+$DYOT3;
                                                $DYTOTAL4 = $DYD4+$DYA4+$DYOT4;
                                                $DYTOTAL5 = $DYD5+$DYA5+$DYOT5;
                                                $DYTOTAL6 = $DYD6+$DYA6+$DYOT6;
                                                $DYTOTAL7 = $DYD7+$DYA7+$DYOT7;
                                                $DYTOTAL8 = $DYD8+$DYA8+$DYOT8;
                                                $DYTOTAL9 = $DYD9+$DYA9+$DYOT9;
                                                $DYTOTAL10 = $DYD10+$DYA10+$DYOT10;
                                                $DYTOTAL11 = $DYD11+$DYA11+$DYOT11;
                                                $DYTOTAL12 = $DYD12+$DYA12+$DYOT12;

                                            // OPEN CHECK YARD DYD IS NULL
                                                $CALDYD = 0;
                                                if($DYD1 == '0'){$CALDYD1 = '0';}else{$CALDYD1 = number_format((($DYD1*100)/$DYTOTAL1), 2 );}
                                                if($DYD2 == '0'){$CALDYD2 = '0';}else{$CALDYD2 = number_format((($DYD2*100)/$DYTOTAL2), 2 );}
                                                if($DYD3 == '0'){$CALDYD3 = '0';}else{$CALDYD3 = number_format((($DYD3*100)/$DYTOTAL3), 2 );}
                                                if($DYD4 == '0'){$CALDYD4 = '0';}else{$CALDYD4 = number_format((($DYD4*100)/$DYTOTAL4), 2 );}
                                                if($DYD5 == '0'){$CALDYD5 = '0';}else{$CALDYD5 = number_format((($DYD5*100)/$DYTOTAL5), 2 );}
                                                if($DYD6 == '0'){$CALDYD6 = '0';}else{$CALDYD6 = number_format((($DYD6*100)/$DYTOTAL6), 2 );}
                                                if($DYD7 == '0'){$CALDYD7 = '0';}else{$CALDYD7 = number_format((($DYD7*100)/$DYTOTAL7), 2 );}
                                                if($DYD8 == '0'){$CALDYD8 = '0';}else{$CALDYD8 = number_format((($DYD8*100)/$DYTOTAL8), 2 );}
                                                if($DYD9 == '0'){$CALDYD9 = '0';}else{$CALDYD9 = number_format((($DYD9*100)/$DYTOTAL9), 2 );}
                                                if($DYD10 == '0'){$CALDYD10 = '0';}else{$CALDYD10 = number_format((($DYD10*100)/$DYTOTAL10), 2 );}
                                                if($DYD11 == '0'){$CALDYD11 = '0';}else{$CALDYD11 = number_format((($DYD11*100)/$DYTOTAL11), 2 );}
                                                if($DYD12 == '0'){$CALDYD12 = '0';}else{$CALDYD12 = number_format((($DYD12*100)/$DYTOTAL12), 2 );}

                                            // OPEN CHECK YARD DYA IS NULL
                                                $CALDYA = 0;
                                                if($DYA1 == '0'){$CALDYA1 = '0';}else{$CALDYA1 = number_format((($DYA1*100)/$DYTOTAL1), 2 );}
                                                if($DYA2 == '0'){$CALDYA2 = '0';}else{$CALDYA2 = number_format((($DYA2*100)/$DYTOTAL2), 2 );}
                                                if($DYA3 == '0'){$CALDYA3 = '0';}else{$CALDYA3 = number_format((($DYA3*100)/$DYTOTAL3), 2 );}
                                                if($DYA4 == '0'){$CALDYA4 = '0';}else{$CALDYA4 = number_format((($DYA4*100)/$DYTOTAL4), 2 );}
                                                if($DYA5 == '0'){$CALDYA5 = '0';}else{$CALDYA5 = number_format((($DYA5*100)/$DYTOTAL5), 2 );}
                                                if($DYA6 == '0'){$CALDYA6 = '0';}else{$CALDYA6 = number_format((($DYA6*100)/$DYTOTAL6), 2 );}
                                                if($DYA7 == '0'){$CALDYA7 = '0';}else{$CALDYA7 = number_format((($DYA7*100)/$DYTOTAL7), 2 );}
                                                if($DYA8 == '0'){$CALDYA8 = '0';}else{$CALDYA8 = number_format((($DYA8*100)/$DYTOTAL8), 2 );}
                                                if($DYA9 == '0'){$CALDYA9 = '0';}else{$CALDYA9 = number_format((($DYA9*100)/$DYTOTAL9), 2 );}
                                                if($DYA10 == '0'){$CALDYA10 = '0';}else{$CALDYA10 = number_format((($DYA10*100)/$DYTOTAL10), 2 );}
                                                if($DYA11 == '0'){$CALDYA11 = '0';}else{$CALDYA11 = number_format((($DYA11*100)/$DYTOTAL11), 2 );}
                                                if($DYA12 == '0'){$CALDYA12 = '0';}else{$CALDYA12 = number_format((($DYA12*100)/$DYTOTAL12), 2 );}

                                            // OPEN CHECK YARD DYOT IS NULL
                                                $CALDYOT = 0;
                                                if($DYOT1 == '0'){$CALDYOT1 = '0';}else{$CALDYOT1 = number_format((($DYOT1*100)/$DYTOTAL1), 2 );}
                                                if($DYOT2 == '0'){$CALDYOT2 = '0';}else{$CALDYOT2 = number_format((($DYOT2*100)/$DYTOTAL2), 2 );}
                                                if($DYOT3 == '0'){$CALDYOT3 = '0';}else{$CALDYOT3 = number_format((($DYOT3*100)/$DYTOTAL3), 2 );}
                                                if($DYOT4 == '0'){$CALDYOT4 = '0';}else{$CALDYOT4 = number_format((($DYOT4*100)/$DYTOTAL4), 2 );}
                                                if($DYOT5 == '0'){$CALDYOT5 = '0';}else{$CALDYOT5 = number_format((($DYOT5*100)/$DYTOTAL5), 2 );}
                                                if($DYOT6 == '0'){$CALDYOT6 = '0';}else{$CALDYOT6 = number_format((($DYOT6*100)/$DYTOTAL6), 2 );}
                                                if($DYOT7 == '0'){$CALDYOT7 = '0';}else{$CALDYOT7 = number_format((($DYOT7*100)/$DYTOTAL7), 2 );}
                                                if($DYOT8 == '0'){$CALDYOT8 = '0';}else{$CALDYOT8 = number_format((($DYOT8*100)/$DYTOTAL8), 2 );}
                                                if($DYOT9 == '0'){$CALDYOT9 = '0';}else{$CALDYOT9 = number_format((($DYOT9*100)/$DYTOTAL9), 2 );}
                                                if($DYOT10 == '0'){$CALDYOT10 = '0';}else{$CALDYOT10 = number_format((($DYOT10*100)/$DYTOTAL10), 2 );}
                                                if($DYOT11 == '0'){$CALDYOT11 = '0';}else{$CALDYOT11 = number_format((($DYOT11*100)/$DYTOTAL11), 2 );}
                                                if($DYOT12 == '0'){$CALDYOT12 = '0';}else{$CALDYOT12 = number_format((($DYOT12*100)/$DYTOTAL12), 2 );}
                                            // ------------------------------------------------------------------------------------------------------------------
                                            // SUPPLIER 
                                            // ------------------------------------------------------------------------------------------------------------------
                                            // QUERY SUPPLIER_DELAY
                                                $sql_seSUPPLIER_DELAY = "SELECT
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '01' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY1',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '02' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY2',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '03' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY3',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '04' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY4',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '05' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY5',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '06' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY6',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '07' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY7',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '08' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY8',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '09' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY9',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '10' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY10',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '11' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY11',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '12' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY12'";
                                                $params_seSUPPLIER_DELAY = array();
                                                $query_seSUPPLIER_DELAY = sqlsrv_query($conn, $sql_seSUPPLIER_DELAY, $params_seSUPPLIER_DELAY);
                                                $result_seSUPPLIER_DELAY = sqlsrv_fetch_array($query_seSUPPLIER_DELAY, SQLSRV_FETCH_ASSOC);
                                                $DSD1=$result_seSUPPLIER_DELAY['SUPPLIERDELAY1'];$DSD2=$result_seSUPPLIER_DELAY['SUPPLIERDELAY2'];$DSD3=$result_seSUPPLIER_DELAY['SUPPLIERDELAY3'];$DSD4=$result_seSUPPLIER_DELAY['SUPPLIERDELAY4'];
                                                $DSD5=$result_seSUPPLIER_DELAY['SUPPLIERDELAY5'];$DSD6=$result_seSUPPLIER_DELAY['SUPPLIERDELAY6'];$DSD7=$result_seSUPPLIER_DELAY['SUPPLIERDELAY7'];$DSD8=$result_seSUPPLIER_DELAY['SUPPLIERDELAY8'];
                                                $DSD9=$result_seSUPPLIER_DELAY['SUPPLIERDELAY9'];$DSD10=$result_seSUPPLIER_DELAY['SUPPLIERDELAY10'];$DSD11=$result_seSUPPLIER_DELAY['SUPPLIERDELAY11'];$DSD12=$result_seSUPPLIER_DELAY['SUPPLIERDELAY12'];
                                            
                                            // QUERY SUPPLIER_ADVANCE
                                                $sql_seSUPPLIER_ADVANCE = "SELECT
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '01' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE1',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '02' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE2',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '03' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE3',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '04' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE4',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '05' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE5',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '06' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE6',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '07' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE7',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '08' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE8',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '09' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE9',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '10' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE10',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '11' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE11',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '12' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE12'";
                                                $params_seSUPPLIER_ADVANCE  = array();
                                                $query_seSUPPLIER_ADVANCE = sqlsrv_query($conn, $sql_seSUPPLIER_ADVANCE, $params_seSUPPLIER_ADVANCE);
                                                $result_seSUPPLIER_ADVANCE = sqlsrv_fetch_array($query_seSUPPLIER_ADVANCE, SQLSRV_FETCH_ASSOC);
                                                $DSA1=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE1'];$DSA2=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE2'];$DSA3=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE3'];$DSA4=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE4'];
                                                $DSA5=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE5'];$DSA6=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE6'];$DSA7=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE7'];$DSA8=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE8'];
                                                $DSA9=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE9'];$DSA10=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE10'];$DSA11=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE11'];$DSA12=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE12'];

                                            // QUERY SUPPLIER_ONTIME
                                                $sql_seSUPPLIER_ONTIME = "SELECT
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '01' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME1',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '02' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME2',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '03' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME3',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '04' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME4',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '05' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME5',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '06' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME6',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '07' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME7',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '08' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME8',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '09' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME9',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '10' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME10',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '11' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME11',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS SUPPLIER_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '12' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME12'";
                                                $params_seSUPPLIER_ONTIME  = array();
                                                $query_seSUPPLIER_ONTIME = sqlsrv_query($conn, $sql_seSUPPLIER_ONTIME, $params_seSUPPLIER_ONTIME);
                                                $result_seSUPPLIER_ONTIME = sqlsrv_fetch_array($query_seSUPPLIER_ONTIME, SQLSRV_FETCH_ASSOC);
                                                $DSOT1=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME1'];$DSOT2=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME2'];$DSOT3=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME3'];$DSOT4=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME4'];
                                                $DSOT5=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME5'];$DSOT6=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME6'];$DSOT7=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME7'];$DSOT8=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME8'];
                                                $DSOT9=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME9'];$DSOT10=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME10'];$DSOT11=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME11'];$DSOT12=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME12'];
                                            
                                            // OPEN CAL SUPPLIER DYD+DYA+DYOT
                                                $DSTOTAL1 = $DSD1+$DSA1+$DSOT1;
                                                $DSTOTAL2 = $DSD2+$DSA2+$DSOT2;
                                                $DSTOTAL3 = $DSD3+$DSA3+$DSOT3;
                                                $DSTOTAL4 = $DSD4+$DSA4+$DSOT4;
                                                $DSTOTAL5 = $DSD5+$DSA5+$DSOT5;
                                                $DSTOTAL6 = $DSD6+$DSA6+$DSOT6;
                                                $DSTOTAL7 = $DSD7+$DSA7+$DSOT7;
                                                $DSTOTAL8 = $DSD8+$DSA8+$DSOT8;
                                                $DSTOTAL9 = $DSD9+$DSA9+$DSOT9;
                                                $DSTOTAL10 = $DSD10+$DSA10+$DSOT10;
                                                $DSTOTAL11 = $DSD11+$DSA11+$DSOT11;
                                                $DSTOTAL12 = $DSD12+$DSA12+$DSOT12;

                                            // OPEN CHECK SUPPLIER DYD IS NULL
                                                $CALDSD = 0;
                                                if($DSD1 == '0'){$CALDSD1 = '0';}else{$CALDSD1 = number_format((($DSD1*100)/$DSTOTAL1), 2 );}
                                                if($DSD2 == '0'){$CALDSD2 = '0';}else{$CALDSD2 = number_format((($DSD2*100)/$DSTOTAL2), 2 );}
                                                if($DSD3 == '0'){$CALDSD3 = '0';}else{$CALDSD3 = number_format((($DSD3*100)/$DSTOTAL3), 2 );}
                                                if($DSD4 == '0'){$CALDSD4 = '0';}else{$CALDSD4 = number_format((($DSD4*100)/$DSTOTAL4), 2 );}
                                                if($DSD5 == '0'){$CALDSD5 = '0';}else{$CALDSD5 = number_format((($DSD5*100)/$DSTOTAL5), 2 );}
                                                if($DSD6 == '0'){$CALDSD6 = '0';}else{$CALDSD6 = number_format((($DSD6*100)/$DSTOTAL6), 2 );}
                                                if($DSD7 == '0'){$CALDSD7 = '0';}else{$CALDSD7 = number_format((($DSD7*100)/$DSTOTAL7), 2 );}
                                                if($DSD8 == '0'){$CALDSD8 = '0';}else{$CALDSD8 = number_format((($DSD8*100)/$DSTOTAL8), 2 );}
                                                if($DSD9 == '0'){$CALDSD9 = '0';}else{$CALDSD9 = number_format((($DSD9*100)/$DSTOTAL9), 2 );}
                                                if($DSD10 == '0'){$CALDSD10 = '0';}else{$CALDSD10 = number_format((($DSD10*100)/$DSTOTAL10), 2 );}
                                                if($DSD11 == '0'){$CALDSD11 = '0';}else{$CALDSD11 = number_format((($DSD11*100)/$DSTOTAL11), 2 );}
                                                if($DSD12 == '0'){$CALDSD12 = '0';}else{$CALDSD12 = number_format((($DSD12*100)/$DSTOTAL12), 2 );}

                                            // OPEN CHECK SUPPLIER DYA IS NULL
                                                $CALDSA = 0;
                                                if($DSA1 == '0'){$CALDSA1 = '0';}else{$CALDSA1 = number_format((($DSA1*100)/$DSTOTAL1), 2 );}
                                                if($DSA2 == '0'){$CALDSA2 = '0';}else{$CALDSA2 = number_format((($DSA2*100)/$DSTOTAL2), 2 );}
                                                if($DSA3 == '0'){$CALDSA3 = '0';}else{$CALDSA3 = number_format((($DSA3*100)/$DSTOTAL3), 2 );}
                                                if($DSA4 == '0'){$CALDSA4 = '0';}else{$CALDSA4 = number_format((($DSA4*100)/$DSTOTAL4), 2 );}
                                                if($DSA5 == '0'){$CALDSA5 = '0';}else{$CALDSA5 = number_format((($DSA5*100)/$DSTOTAL5), 2 );}
                                                if($DSA6 == '0'){$CALDSA6 = '0';}else{$CALDSA6 = number_format((($DSA6*100)/$DSTOTAL6), 2 );}
                                                if($DSA7 == '0'){$CALDSA7 = '0';}else{$CALDSA7 = number_format((($DSA7*100)/$DSTOTAL7), 2 );}
                                                if($DSA8 == '0'){$CALDSA8 = '0';}else{$CALDSA8 = number_format((($DSA8*100)/$DSTOTAL8), 2 );}
                                                if($DSA9 == '0'){$CALDSA9 = '0';}else{$CALDSA9 = number_format((($DSA9*100)/$DSTOTAL9), 2 );}
                                                if($DSA10 == '0'){$CALDSA10 = '0';}else{$CALDSA10 = number_format((($DSA10*100)/$DSTOTAL10), 2 );}
                                                if($DSA11 == '0'){$CALDSA11 = '0';}else{$CALDSA11 = number_format((($DSA11*100)/$DSTOTAL11), 2 );}
                                                if($DSA12 == '0'){$CALDSA12 = '0';}else{$CALDSA12 = number_format((($DSA12*100)/$DSTOTAL12), 2 );}

                                            // OPEN CHECK SUPPLIER DYOT IS NULL
                                                $CALDSOT = 0;
                                                if($DSOT1 == '0'){$CALDSOT1 = '0';}else{$CALDSOT1 = number_format((($DSOT1*100)/$DSTOTAL1), 2 );}
                                                if($DSOT2 == '0'){$CALDSOT2 = '0';}else{$CALDSOT2 = number_format((($DSOT2*100)/$DSTOTAL2), 2 );}
                                                if($DSOT3 == '0'){$CALDSOT3 = '0';}else{$CALDSOT3 = number_format((($DSOT3*100)/$DSTOTAL3), 2 );}
                                                if($DSOT4 == '0'){$CALDSOT4 = '0';}else{$CALDSOT4 = number_format((($DSOT4*100)/$DSTOTAL4), 2 );}
                                                if($DSOT5 == '0'){$CALDSOT5 = '0';}else{$CALDSOT5 = number_format((($DSOT5*100)/$DSTOTAL5), 2 );}
                                                if($DSOT6 == '0'){$CALDSOT6 = '0';}else{$CALDSOT6 = number_format((($DSOT6*100)/$DSTOTAL6), 2 );}
                                                if($DSOT7 == '0'){$CALDSOT7 = '0';}else{$CALDSOT7 = number_format((($DSOT7*100)/$DSTOTAL7), 2 );}
                                                if($DSOT8 == '0'){$CALDSOT8 = '0';}else{$CALDSOT8 = number_format((($DSOT8*100)/$DSTOTAL8), 2 );}
                                                if($DSOT9 == '0'){$CALDSOT9 = '0';}else{$CALDSOT9 = number_format((($DSOT9*100)/$DSTOTAL9), 2 );}
                                                if($DSOT10 == '0'){$CALDSOT10 = '0';}else{$CALDSOT10 = number_format((($DSOT10*100)/$DSTOTAL10), 2 );}
                                                if($DSOT11 == '0'){$CALDSOT11 = '0';}else{$CALDSOT11 = number_format((($DSOT11*100)/$DSTOTAL11), 2 );}
                                                if($DSOT12 == '0'){$CALDSOT12 = '0';}else{$CALDSOT12 = number_format((($DSOT12*100)/$DSTOTAL12), 2 );}
                                            // ------------------------------------------------------------------------------------------------------------------
                                            // PLANT 
                                            // ------------------------------------------------------------------------------------------------------------------
                                            // QUERY PLANT_DELAY
                                                $sql_sePLANT_DELAY = "SELECT
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '01' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY1',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '02' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY2',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '03' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY3',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '04' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY4',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '05' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY5',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '06' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY6',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '07' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY7',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '08' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY8',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '09' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY9',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '10' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY10',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '11' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY11',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '12' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY12'";
                                                $params_sePLANT_DELAY = array();
                                                $query_sePLANT_DELAY = sqlsrv_query($conn, $sql_sePLANT_DELAY, $params_sePLANT_DELAY);
                                                $result_sePLANT_DELAY = sqlsrv_fetch_array($query_sePLANT_DELAY, SQLSRV_FETCH_ASSOC);
                                                $DPD1=$result_sePLANT_DELAY['PLANTDELAY1'];$DPD2=$result_sePLANT_DELAY['PLANTDELAY2'];$DPD3=$result_sePLANT_DELAY['PLANTDELAY3'];$DPD4=$result_sePLANT_DELAY['PLANTDELAY4'];
                                                $DPD5=$result_sePLANT_DELAY['PLANTDELAY5'];$DPD6=$result_sePLANT_DELAY['PLANTDELAY6'];$DPD7=$result_sePLANT_DELAY['PLANTDELAY7'];$DPD8=$result_sePLANT_DELAY['PLANTDELAY8'];
                                                $DPD9=$result_sePLANT_DELAY['PLANTDELAY9'];$DPD10=$result_sePLANT_DELAY['PLANTDELAY10'];$DPD11=$result_sePLANT_DELAY['PLANTDELAY11'];$DPD12=$result_sePLANT_DELAY['PLANTDELAY12'];
                                            
                                            // QUERY PLANT_ADVANCE
                                                $sql_sePLANT_ADVANCE = "SELECT
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '01' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE1',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '02' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE2',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '03' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE3',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '04' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE4',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '05' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE5',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '06' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE6',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '07' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE7',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '08' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE8',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '09' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE9',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '10' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE10',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '11' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE11',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '12' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE12'";
                                                $params_sePLANT_ADVANCE  = array();
                                                $query_sePLANT_ADVANCE = sqlsrv_query($conn, $sql_sePLANT_ADVANCE, $params_sePLANT_ADVANCE);
                                                $result_sePLANT_ADVANCE = sqlsrv_fetch_array($query_sePLANT_ADVANCE, SQLSRV_FETCH_ASSOC);
                                                $DPA1=$result_sePLANT_ADVANCE['PLANTADVANCE1'];$DPA2=$result_sePLANT_ADVANCE['PLANTADVANCE2'];$DPA3=$result_sePLANT_ADVANCE['PLANTADVANCE3'];$DPA4=$result_sePLANT_ADVANCE['PLANTADVANCE4'];
                                                $DPA5=$result_sePLANT_ADVANCE['PLANTADVANCE5'];$DPA6=$result_sePLANT_ADVANCE['PLANTADVANCE6'];$DPA7=$result_sePLANT_ADVANCE['PLANTADVANCE7'];$DPA8=$result_sePLANT_ADVANCE['PLANTADVANCE8'];
                                                $DPA9=$result_sePLANT_ADVANCE['PLANTADVANCE9'];$DPA10=$result_sePLANT_ADVANCE['PLANTADVANCE10'];$DPA11=$result_sePLANT_ADVANCE['PLANTADVANCE11'];$DPA12=$result_sePLANT_ADVANCE['PLANTADVANCE12'];

                                            // QUERY PLANT_ONTIME
                                                $sql_sePLANT_ONTIME = "SELECT
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '01' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME1',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '02' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME2',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '03' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME3',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '04' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME4',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '05' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME5',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '06' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME6',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '07' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME7',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '08' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME8',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '09' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME9',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '10' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME10',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '11' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME11',
                                                    (SELECT COUNT(MONTH(ROUTE_DATE)) AS PLANT_DELAY  FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE MONTH(ROUTE_DATE) = '12' 
                                                    AND YEAR(ROUTE_DATE) = '$years' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME12'";
                                                $params_sePLANT_ONTIME  = array();
                                                $query_sePLANT_ONTIME = sqlsrv_query($conn, $sql_sePLANT_ONTIME, $params_sePLANT_ONTIME);
                                                $result_sePLANT_ONTIME = sqlsrv_fetch_array($query_sePLANT_ONTIME, SQLSRV_FETCH_ASSOC);
                                                $DPOT1=$result_sePLANT_ONTIME['PLANTONTIME1'];$DPOT2=$result_sePLANT_ONTIME['PLANTONTIME2'];$DPOT3=$result_sePLANT_ONTIME['PLANTONTIME3'];$DPOT4=$result_sePLANT_ONTIME['PLANTONTIME4'];
                                                $DPOT5=$result_sePLANT_ONTIME['PLANTONTIME5'];$DPOT6=$result_sePLANT_ONTIME['PLANTONTIME6'];$DPOT7=$result_sePLANT_ONTIME['PLANTONTIME7'];$DPOT8=$result_sePLANT_ONTIME['PLANTONTIME8'];
                                                $DPOT9=$result_sePLANT_ONTIME['PLANTONTIME9'];$DPOT10=$result_sePLANT_ONTIME['PLANTONTIME10'];$DPOT11=$result_sePLANT_ONTIME['PLANTONTIME11'];$DPOT12=$result_sePLANT_ONTIME['PLANTONTIME12'];
                                            
                                            // OPEN CAL PLANT DYD+DYA+DYOT
                                                $DPTOTAL1 = $DPD1+$DPA1+$DPOT1;
                                                $DPTOTAL2 = $DPD2+$DPA2+$DPOT2;
                                                $DPTOTAL3 = $DPD3+$DPA3+$DPOT3;
                                                $DPTOTAL4 = $DPD4+$DPA4+$DPOT4;
                                                $DPTOTAL5 = $DPD5+$DPA5+$DPOT5;
                                                $DPTOTAL6 = $DPD6+$DPA6+$DPOT6;
                                                $DPTOTAL7 = $DPD7+$DPA7+$DPOT7;
                                                $DPTOTAL8 = $DPD8+$DPA8+$DPOT8;
                                                $DPTOTAL9 = $DPD9+$DPA9+$DPOT9;
                                                $DPTOTAL10 = $DPD10+$DPA10+$DPOT10;
                                                $DPTOTAL11 = $DPD11+$DPA11+$DPOT11;
                                                $DPTOTAL12 = $DPD12+$DPA12+$DPOT12;

                                            // OPEN CHECK PLANT DYD IS NULL
                                                $CALDPD = 0;
                                                if($DPD1 == '0'){$CALDPD1 = '0';}else{$CALDPD1 = number_format((($DPD1*100)/$DPTOTAL1), 2 );}
                                                if($DPD2 == '0'){$CALDPD2 = '0';}else{$CALDPD2 = number_format((($DPD2*100)/$DPTOTAL2), 2 );}
                                                if($DPD3 == '0'){$CALDPD3 = '0';}else{$CALDPD3 = number_format((($DPD3*100)/$DPTOTAL3), 2 );}
                                                if($DPD4 == '0'){$CALDPD4 = '0';}else{$CALDPD4 = number_format((($DPD4*100)/$DPTOTAL4), 2 );}
                                                if($DPD5 == '0'){$CALDPD5 = '0';}else{$CALDPD5 = number_format((($DPD5*100)/$DPTOTAL5), 2 );}
                                                if($DPD6 == '0'){$CALDPD6 = '0';}else{$CALDPD6 = number_format((($DPD6*100)/$DPTOTAL6), 2 );}
                                                if($DPD7 == '0'){$CALDPD7 = '0';}else{$CALDPD7 = number_format((($DPD7*100)/$DPTOTAL7), 2 );}
                                                if($DPD8 == '0'){$CALDPD8 = '0';}else{$CALDPD8 = number_format((($DPD8*100)/$DPTOTAL8), 2 );}
                                                if($DPD9 == '0'){$CALDPD9 = '0';}else{$CALDPD9 = number_format((($DPD9*100)/$DPTOTAL9), 2 );}
                                                if($DPD10 == '0'){$CALDPD10 = '0';}else{$CALDPD10 = number_format((($DPD10*100)/$DPTOTAL10), 2 );}
                                                if($DPD11 == '0'){$CALDPD11 = '0';}else{$CALDPD11 = number_format((($DPD11*100)/$DPTOTAL11), 2 );}
                                                if($DPD12 == '0'){$CALDPD12 = '0';}else{$CALDPD12 = number_format((($DPD12*100)/$DPTOTAL12), 2 );}

                                            // OPEN CHECK PLANT DYA IS NULL
                                                $CALDPA = 0;
                                                if($DPA1 == '0'){$CALDPA1 = '0';}else{$CALDPA1 = number_format((($DPA1*100)/$DPTOTAL1), 2 );}
                                                if($DPA2 == '0'){$CALDPA2 = '0';}else{$CALDPA2 = number_format((($DPA2*100)/$DPTOTAL2), 2 );}
                                                if($DPA3 == '0'){$CALDPA3 = '0';}else{$CALDPA3 = number_format((($DPA3*100)/$DPTOTAL3), 2 );}
                                                if($DPA4 == '0'){$CALDPA4 = '0';}else{$CALDPA4 = number_format((($DPA4*100)/$DPTOTAL4), 2 );}
                                                if($DPA5 == '0'){$CALDPA5 = '0';}else{$CALDPA5 = number_format((($DPA5*100)/$DPTOTAL5), 2 );}
                                                if($DPA6 == '0'){$CALDPA6 = '0';}else{$CALDPA6 = number_format((($DPA6*100)/$DPTOTAL6), 2 );}
                                                if($DPA7 == '0'){$CALDPA7 = '0';}else{$CALDPA7 = number_format((($DPA7*100)/$DPTOTAL7), 2 );}
                                                if($DPA8 == '0'){$CALDPA8 = '0';}else{$CALDPA8 = number_format((($DPA8*100)/$DPTOTAL8), 2 );}
                                                if($DPA9 == '0'){$CALDPA9 = '0';}else{$CALDPA9 = number_format((($DPA9*100)/$DPTOTAL9), 2 );}
                                                if($DPA10 == '0'){$CALDPA10 = '0';}else{$CALDPA10 = number_format((($DPA10*100)/$DPTOTAL10), 2 );}
                                                if($DPA11 == '0'){$CALDPA11 = '0';}else{$CALDPA11 = number_format((($DPA11*100)/$DPTOTAL11), 2 );}
                                                if($DPA12 == '0'){$CALDPA12 = '0';}else{$CALDPA12 = number_format((($DPA12*100)/$DPTOTAL12), 2 );}

                                            // OPEN CHECK PLANT DYOT IS NULL
                                                $CALDPOT = 0;
                                                if($DPOT1 == '0'){$CALDPOT1 = '0';}else{$CALDPOT1 = number_format((($DPOT1*100)/$DPTOTAL1), 2 );}
                                                if($DPOT2 == '0'){$CALDPOT2 = '0';}else{$CALDPOT2 = number_format((($DPOT2*100)/$DPTOTAL2), 2 );}
                                                if($DPOT3 == '0'){$CALDPOT3 = '0';}else{$CALDPOT3 = number_format((($DPOT3*100)/$DPTOTAL3), 2 );}
                                                if($DPOT4 == '0'){$CALDPOT4 = '0';}else{$CALDPOT4 = number_format((($DPOT4*100)/$DPTOTAL4), 2 );}
                                                if($DPOT5 == '0'){$CALDPOT5 = '0';}else{$CALDPOT5 = number_format((($DPOT5*100)/$DPTOTAL5), 2 );}
                                                if($DPOT6 == '0'){$CALDPOT6 = '0';}else{$CALDPOT6 = number_format((($DPOT6*100)/$DPTOTAL6), 2 );}
                                                if($DPOT7 == '0'){$CALDPOT7 = '0';}else{$CALDPOT7 = number_format((($DPOT7*100)/$DPTOTAL7), 2 );}
                                                if($DPOT8 == '0'){$CALDPOT8 = '0';}else{$CALDPOT8 = number_format((($DPOT8*100)/$DPTOTAL8), 2 );}
                                                if($DPOT9 == '0'){$CALDPOT9 = '0';}else{$CALDPOT9 = number_format((($DPOT9*100)/$DPTOTAL9), 2 );}
                                                if($DPOT10 == '0'){$CALDPOT10 = '0';}else{$CALDPOT10 = number_format((($DPOT10*100)/$DPTOTAL10), 2 );}
                                                if($DPOT11 == '0'){$CALDPOT11 = '0';}else{$CALDPOT11 = number_format((($DPOT11*100)/$DPTOTAL11), 2 );}
                                                if($DPOT12 == '0'){$CALDPOT12 = '0';}else{$CALDPOT12 = number_format((($DPOT12*100)/$DPTOTAL12), 2 );}
                                            // ------------------------------------------------------------------------------------------------------------------
                                        ?> 
                                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                        <!-- DATA CHART YARD -->
                                        <script type="text/javascript">
                                            google.charts.load('current', {'packages': ['corechart']});
                                            google.charts.setOnLoadCallback(drawChart1);
                                            function drawChart1() {
                                                var data1 = google.visualization.arrayToDataTable([
                                                    ['Month', 'YARD DELAY %', 'YARD ADVANCE %', 'YARD ONTIME %',],
                                                    ['Jan/<?=$years+543?>',<?=$CALDYD1;?>,<?=$CALDYA1;?>,<?=$CALDYOT1;?>],
                                                    ['Feb/<?=$years+543?>',<?=$CALDYD2;?>,<?=$CALDYA2;?>,<?=$CALDYOT2;?>],
                                                    ['Mar/<?=$years+543?>',<?=$CALDYD3;?>,<?=$CALDYA3;?>,<?=$CALDYOT3;?>],
                                                    ['Apr/<?=$years+543?>',<?=$CALDYD4;?>,<?=$CALDYA4;?>,<?=$CALDYOT4;?>],
                                                    ['May/<?=$years+543?>',<?=$CALDYD5;?>,<?=$CALDYA5;?>,<?=$CALDYOT5;?>],
                                                    ['Jun/<?=$years+543?>',<?=$CALDYD6;?>,<?=$CALDYA6;?>,<?=$CALDYOT6;?>],
                                                    ['Jul/<?=$years+543?>',<?=$CALDYD7;?>,<?=$CALDYA7;?>,<?=$CALDYOT7;?>],
                                                    ['Aug/<?=$years+543?>',<?=$CALDYD8;?>,<?=$CALDYA8;?>,<?=$CALDYOT8;?>],
                                                    ['Sep/<?=$years+543?>',<?=$CALDYD9;?>,<?=$CALDYA9;?>,<?=$CALDYOT9;?>],
                                                    ['Oct/<?=$years+543?>',<?=$CALDYD10;?>,<?=$CALDYA10;?>,<?=$CALDYOT10;?>],
                                                    ['Nov/<?=$years+543?>',<?=$CALDYD11;?>,<?=$CALDYA11;?>,<?=$CALDYOT11;?>],
                                                    ['Dec/<?=$years+543?>',<?=$CALDYD12;?>,<?=$CALDYA12;?>,<?=$CALDYOT12;?>]
                                                ]);
                                                var view1 = new google.visualization.DataView(data1);
                                                view1.setColumns
                                                    ([
                                                        0,
                                                        1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" },
                                                        2,{ calc: "stringify",sourceColumn: 2,type: "string",role: "annotation" },
                                                        3,{ calc: "stringify",sourceColumn: 3,type: "string",role: "annotation" }
                                                    ]);
                                                var options1 = 
                                                    {
                                                        // title : '1. Departure Time Truck Yard',
                                                        title : '',
                                                        annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
                                                        hAxis: {title: 'กราฟข้อมูล Punctuality Truck Yard ประจำปี <?=$years+543?>'},
                                                        legend: {position: 'top'},
                                                        series: {
                                                                0: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,}, // YARD_DELAY
                                                                1: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,}, // YARD_ADVANCE
                                                                2: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,} // YARD_ONTIME
                                                                },
                                                        tooltip: {},
                                                        colors: ['#1E90FF', '#FFD700', '#228B22']
                                                    };
                                                // var chart1 = new google.visualization.ComboChart(document.getElementById('chart_yard'));
                                                // chart1.draw(view1, options1);
                                                var chart_area1 = document.getElementById('chart_yard');
                                                var chart1 = new google.visualization.ComboChart(chart_area1);
                                                google.visualization.events.addListener(chart1, 'ready', function(){
                                                    chart_area1.innerHTML = '<img src="' + chart1.getImageURI() + '" class="img-responsive">';});
                                                chart1.draw(view1, options1);
                                            }
                                        </script>
                                        <!-- DATA CHART SUPPLIER -->
                                        <script type="text/javascript">
                                            google.charts.load('current', {'packages': ['corechart']});
                                            google.charts.setOnLoadCallback(drawChart2);
                                            function drawChart2() {
                                                var data2 = google.visualization.arrayToDataTable([
                                                    ['Month', 'SUPPLIER DELAY %', 'SUPPLIER ADVANCE %', 'SUPPLIER ONTIME %',],
                                                    ['Jan/<?=$years+543?>',<?=$CALDSD1;?>,<?=$CALDSA1;?>,<?=$CALDSOT1;?>],
                                                    ['Feb/<?=$years+543?>',<?=$CALDSD2;?>,<?=$CALDSA2;?>,<?=$CALDSOT2;?>],
                                                    ['Mar/<?=$years+543?>',<?=$CALDSD3;?>,<?=$CALDSA3;?>,<?=$CALDSOT3;?>],
                                                    ['Apr/<?=$years+543?>',<?=$CALDSD4;?>,<?=$CALDSA4;?>,<?=$CALDSOT4;?>],
                                                    ['May/<?=$years+543?>',<?=$CALDSD5;?>,<?=$CALDSA5;?>,<?=$CALDSOT5;?>],
                                                    ['Jun/<?=$years+543?>',<?=$CALDSD6;?>,<?=$CALDSA6;?>,<?=$CALDSOT6;?>],
                                                    ['Jul/<?=$years+543?>',<?=$CALDSD7;?>,<?=$CALDSA7;?>,<?=$CALDSOT7;?>],
                                                    ['Aug/<?=$years+543?>',<?=$CALDSD8;?>,<?=$CALDSA8;?>,<?=$CALDSOT8;?>],
                                                    ['Sep/<?=$years+543?>',<?=$CALDSD9;?>,<?=$CALDSA9;?>,<?=$CALDSOT9;?>],
                                                    ['Oct/<?=$years+543?>',<?=$CALDSD10;?>,<?=$CALDSA10;?>,<?=$CALDSOT10;?>],
                                                    ['Nov/<?=$years+543?>',<?=$CALDSD11;?>,<?=$CALDSA11;?>,<?=$CALDSOT11;?>],
                                                    ['Dec/<?=$years+543?>',<?=$CALDSD12;?>,<?=$CALDSA12;?>,<?=$CALDSOT12;?>]
                                                ]);
                                                var view2 = new google.visualization.DataView(data2);
                                                view2.setColumns
                                                    ([
                                                        0,
                                                        1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" },
                                                        2,{ calc: "stringify",sourceColumn: 2,type: "string",role: "annotation" },
                                                        3,{ calc: "stringify",sourceColumn: 3,type: "string",role: "annotation" }
                                                    ]);
                                                var options2 = 
                                                    {
                                                        // title : '2. Arrival Time Supplier',
                                                        title : '',
                                                        annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
                                                        hAxis: {title: 'กราฟข้อมูล Punctuality Supplier ประจำปี <?=$years+543?>'},
                                                        legend: {position: 'top'},
                                                        series: {
                                                                0: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,}, // SUPPLIER_DELAY
                                                                1: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,}, // SUPPLIER_ADVANCE
                                                                2: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,} // SUPPLIER_ONTIME
                                                                },
                                                        tooltip: {},
                                                        colors: ['#1E90FF', '#FFD700', '#228B22']
                                                    };
                                                // var chart2 = new google.visualization.ComboChart(document.getElementById('chart_supplier'));
                                                // chart2.draw(view2, options2);
                                                var chart_area2 = document.getElementById('chart_supplier');
                                                var chart2 = new google.visualization.ComboChart(chart_area2);
                                                google.visualization.events.addListener(chart2, 'ready', function(){
                                                    chart_area2.innerHTML = '<img src="' + chart2.getImageURI() + '" class="img-responsive">';});
                                                chart2.draw(view2, options2);
                                            }
                                        </script>
                                        <!-- DATA CHART PLANT -->
                                        <script type="text/javascript">
                                            google.charts.load('current', {'packages': ['corechart']});
                                            google.charts.setOnLoadCallback(drawChart3);
                                            function drawChart3() {
                                                var data3 = google.visualization.arrayToDataTable([
                                                    ['Month', 'PLANT DELAY %', 'PLANT ADVANCE %', 'PLANT ONTIME %',],
                                                    ['Jan/<?=$years+543?>',<?=$CALDPD1;?>,<?=$CALDPA1;?>,<?=$CALDPOT1;?>],
                                                    ['Feb/<?=$years+543?>',<?=$CALDPD2;?>,<?=$CALDPA2;?>,<?=$CALDPOT2;?>],
                                                    ['Mar/<?=$years+543?>',<?=$CALDPD3;?>,<?=$CALDPA3;?>,<?=$CALDPOT3;?>],
                                                    ['Apr/<?=$years+543?>',<?=$CALDPD4;?>,<?=$CALDPA4;?>,<?=$CALDPOT4;?>],
                                                    ['May/<?=$years+543?>',<?=$CALDPD5;?>,<?=$CALDPA5;?>,<?=$CALDPOT5;?>],
                                                    ['Jun/<?=$years+543?>',<?=$CALDPD6;?>,<?=$CALDPA6;?>,<?=$CALDPOT6;?>],
                                                    ['Jul/<?=$years+543?>',<?=$CALDPD7;?>,<?=$CALDPA7;?>,<?=$CALDPOT7;?>],
                                                    ['Aug/<?=$years+543?>',<?=$CALDPD8;?>,<?=$CALDPA8;?>,<?=$CALDPOT8;?>],
                                                    ['Sep/<?=$years+543?>',<?=$CALDPD9;?>,<?=$CALDPA9;?>,<?=$CALDPOT9;?>],
                                                    ['Oct/<?=$years+543?>',<?=$CALDPD10;?>,<?=$CALDPA10;?>,<?=$CALDPOT10;?>],
                                                    ['Nov/<?=$years+543?>',<?=$CALDPD11;?>,<?=$CALDPA11;?>,<?=$CALDPOT11;?>],
                                                    ['Dec/<?=$years+543?>',<?=$CALDPD12;?>,<?=$CALDPA12;?>,<?=$CALDPOT12;?>]
                                                ]);
                                                var view3 = new google.visualization.DataView(data3);
                                                view3.setColumns
                                                    ([
                                                        0,
                                                        1,{ calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" },
                                                        2,{ calc: "stringify",sourceColumn: 2,type: "string",role: "annotation" },
                                                        3,{ calc: "stringify",sourceColumn: 3,type: "string",role: "annotation" }
                                                    ]);
                                                var options3 = 
                                                    {
                                                        // title : '3. Arrival Time Plant',
                                                        title : '',
                                                        annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
                                                        hAxis: {title: 'กราฟข้อมูล Punctuality Plant ประจำปี <?=$years+543?>'},
                                                        legend: {position: 'top'},
                                                        series: {
                                                                0: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,}, // PLANT_DELAY
                                                                1: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,}, // PLANT_ADVANCE
                                                                2: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,} // PLANT_ONTIME
                                                                },
                                                        tooltip: {},
                                                        colors: ['#1E90FF', '#FFD700', '#228B22']
                                                    };
                                                // var chart3 = new google.visualization.ComboChart(document.getElementById('chart_plant'));
                                                // chart3.draw(view3, options3);
                                                var chart_area3 = document.getElementById('chart_plant');
                                                var chart3 = new google.visualization.ComboChart(chart_area3);
                                                google.visualization.events.addListener(chart3, 'ready', function(){
                                                    chart_area3.innerHTML = '<img src="' + chart3.getImageURI() + '" class="img-responsive">';});
                                                chart3.draw(view3, options3);
                                            }
                                        </script>
                                        <!-- <h3>1. Departure Time Truck Yard</h3> -->
                                        <!-- <div id="chart_yard" style="width: 100%; height: 500px"></div>CHART YARD -->
                                        <!-- <hr> -->
                                        <!-- <h3>2. Arrival Time Supplier</h3> -->
                                        <!-- <div id="chart_supplier" style="width: 100%; height: 500px"></div>CHART SUPPLIER -->
                                        <!-- <hr> -->
                                        <!-- <h3>3. Arrival Time Plant</h3> -->
                                        <!-- <div id="chart_plant" style="width: 100%; height: 500px"></div>CHART PLANT -->
                                    </div>
                                </div>
                            </div>
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
                window.open('meg_driverdatagraph_check.php?months=' + months + '&employeecode=' + employeecode, '_blank');
            }
            
            function autoclick() {
                document.getElementById("create_kpipdf").click(function(){
                $('#hidden_html').val($('#testing').html());
                $('#make_pdf').submit();
                });
                window.close();
            }
            setTimeout(autoclick, 600);

            $(document).ready(function(){
                $('#create_kpipdf').click(function(){
                $('#hidden_html').val($('#testing').html());
                $('#make_pdf').submit();
                });
            });
           
    </script>

    </body>


</html>
