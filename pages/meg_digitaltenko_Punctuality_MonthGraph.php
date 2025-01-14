<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$strDate = $_GET['month'];
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
                background-color: #fff;
            }
            body {
                background-color: #fff;
            }
        </style>
    </head>

    <body>
        <div id="wrapper">
            <div id="page-wrapper" style="color: #666">
                <!-- START ROW1 -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">                            
                                <div class="col-lg-12" style="text-align: center;">
                                    <label>&nbsp;</label>
                                    <input type="text" hidden id="txt_monthnumberic" name="txt_monthnumberic" value="<?=$monthnumeric?>">
                                    <input type="text" hidden id="txt_month" name="txt_month" value="<?=$month?>">
                                    <input type="text" hidden id="txt_years" name="txt_years" value="<?=$years?>">
                                    <div style="align: center;">                                    
                                            <button type="button" name="export_month_graph_punctual_pdf" id="export_month_graph_punctual_pdf" onclick ="export_month_graph_punctual_pdf();" class="btn btn-success btn-lg">Export Graph To PDF</button>
                                    </div>    
                                </div>     
                                <div class="row question-template">
                                    <div class="col-lg-12" style="text-align:center;">
                                        <h2 class="page-header"><i class="fa fa-bar-chart-o fa-fw"></i>  
                                            กราฟข้อมูล Punctuality ประจำเดือน <b><?=DateThai($strDate)?> <?=$years+543?></b>
                                            <!-- กราฟข้อมูล Punctuality ประจำปี:&nbsp;<b><?=$years+543?></b> -->
                                            <input type="hidden" id="txt_empcode" name="txt_empcode" value="<?=$_GET['employeecode']?>" ></imput>
                                        </h2>
                                    </div>                           
                                    <div class="col-lg-12">
                                        <?php
                                            // YARD 
                                            // ------------------------------------------------------------------------------------------------------------------
                                            // QUERY YARD_DELAY
                                                $sql_seYARD_DELAY = "SELECT
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '01/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY1',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '02/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY2',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '03/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY3',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '04/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY4',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '05/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY5',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '06/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY6',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '07/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY7',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '08/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY8',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '09/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY9',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '10/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY10',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '11/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY11',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '12/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY12',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '13/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY13',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '14/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY14',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '15/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY15',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '16/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY16',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '17/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY17',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '18/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY18',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '19/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY19',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '20/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY20',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '21/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY21',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '22/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY22',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '23/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY23',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '24/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY24',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '25/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY25',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '26/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY26',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '27/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY27',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '28/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY28',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '29/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY29',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '30/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY30',
                                                    (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '31/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'YARDDELAY31'";
                                                $params_seYARD_DELAY = array();
                                                $query_seYARD_DELAY = sqlsrv_query($conn, $sql_seYARD_DELAY, $params_seYARD_DELAY);
                                                $result_seYARD_DELAY = sqlsrv_fetch_array($query_seYARD_DELAY, SQLSRV_FETCH_ASSOC);
                                                $DYD1=$result_seYARD_DELAY['YARDDELAY1'];$DYD2=$result_seYARD_DELAY['YARDDELAY2'];$DYD3=$result_seYARD_DELAY['YARDDELAY3'];$DYD4=$result_seYARD_DELAY['YARDDELAY4'];$DYD5=$result_seYARD_DELAY['YARDDELAY5'];$DYD6=$result_seYARD_DELAY['YARDDELAY6'];$DYD7=$result_seYARD_DELAY['YARDDELAY7'];$DYD8=$result_seYARD_DELAY['YARDDELAY8'];
                                                $DYD9=$result_seYARD_DELAY['YARDDELAY9'];$DYD10=$result_seYARD_DELAY['YARDDELAY10'];$DYD11=$result_seYARD_DELAY['YARDDELAY11'];$DYD12=$result_seYARD_DELAY['YARDDELAY12'];$DYD13=$result_seYARD_DELAY['YARDDELAY13'];$DYD14=$result_seYARD_DELAY['YARDDELAY14'];$DYD15=$result_seYARD_DELAY['YARDDELAY15'];$DYD16=$result_seYARD_DELAY['YARDDELAY16'];
                                                $DYD17=$result_seYARD_DELAY['YARDDELAY17'];$DYD18=$result_seYARD_DELAY['YARDDELAY18'];$DYD19=$result_seYARD_DELAY['YARDDELAY19'];$DYD20=$result_seYARD_DELAY['YARDDELAY20'];$DYD21=$result_seYARD_DELAY['YARDDELAY21'];$DYD22=$result_seYARD_DELAY['YARDDELAY22'];$DYD23=$result_seYARD_DELAY['YARDDELAY23'];$DYD24=$result_seYARD_DELAY['YARDDELAY24'];
                                                $DYD25=$result_seYARD_DELAY['YARDDELAY25'];$DYD26=$result_seYARD_DELAY['YARDDELAY26'];$DYD27=$result_seYARD_DELAY['YARDDELAY27'];$DYD28=$result_seYARD_DELAY['YARDDELAY28'];$DYD29=$result_seYARD_DELAY['YARDDELAY29'];$DYD30=$result_seYARD_DELAY['YARDDELAY30'];$DYD31=$result_seYARD_DELAY['YARDDELAY31'];
                                                                                               
                                            // QUERY YARD_ADVANCE
                                                $sql_seYARD_ADVANCE = "SELECT
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '01/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE1',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '02/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE2',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '03/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE3',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '04/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE4',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '05/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE5',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '06/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE6',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '07/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE7',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '08/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE8',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '09/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE9',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '10/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE10',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '11/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE11',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '12/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE12',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '13/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE13',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '14/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE14',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '15/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE15',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '16/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE16',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '17/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE17',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '18/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE18',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '19/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE19',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '20/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE20',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '21/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE21',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '22/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE22',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '23/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE23',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '24/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE24',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '25/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE25',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '26/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE26',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '27/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE27',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '28/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE28',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '29/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE29',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '30/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE30',
                                                    (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '31/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'YARDADVANCE31'";
                                                $params_seYARD_ADVANCE  = array();
                                                $query_seYARD_ADVANCE = sqlsrv_query($conn, $sql_seYARD_ADVANCE, $params_seYARD_ADVANCE);
                                                $result_seYARD_ADVANCE = sqlsrv_fetch_array($query_seYARD_ADVANCE, SQLSRV_FETCH_ASSOC);
                                                $DYA1=$result_seYARD_ADVANCE['YARDADVANCE1'];$DYA2=$result_seYARD_ADVANCE['YARDADVANCE2'];$DYA3=$result_seYARD_ADVANCE['YARDADVANCE3'];$DYA4=$result_seYARD_ADVANCE['YARDADVANCE4'];$DYA5=$result_seYARD_ADVANCE['YARDADVANCE5'];$DYA6=$result_seYARD_ADVANCE['YARDADVANCE6'];$DYA7=$result_seYARD_ADVANCE['YARDADVANCE7'];$DYA8=$result_seYARD_ADVANCE['YARDADVANCE8'];
                                                $DYA9=$result_seYARD_ADVANCE['YARDADVANCE9'];$DYA10=$result_seYARD_ADVANCE['YARDADVANCE10'];$DYA11=$result_seYARD_ADVANCE['YARDADVANCE11'];$DYA12=$result_seYARD_ADVANCE['YARDADVANCE12'];$DYA13=$result_seYARD_ADVANCE['YARDADVANCE13'];$DYA14=$result_seYARD_ADVANCE['YARDADVANCE14'];$DYA15=$result_seYARD_ADVANCE['YARDADVANCE15'];$DYA16=$result_seYARD_ADVANCE['YARDADVANCE16'];
                                                $DYA17=$result_seYARD_ADVANCE['YARDADVANCE17'];$DYA18=$result_seYARD_ADVANCE['YARDADVANCE18'];$DYA19=$result_seYARD_ADVANCE['YARDADVANCE19'];$DYA20=$result_seYARD_ADVANCE['YARDADVANCE20'];$DYA21=$result_seYARD_ADVANCE['YARDADVANCE21'];$DYA22=$result_seYARD_ADVANCE['YARDADVANCE22'];$DYA23=$result_seYARD_ADVANCE['YARDADVANCE23'];$DYA24=$result_seYARD_ADVANCE['YARDADVANCE24'];
                                                $DYA25=$result_seYARD_ADVANCE['YARDADVANCE25'];$DYA26=$result_seYARD_ADVANCE['YARDADVANCE26'];$DYA27=$result_seYARD_ADVANCE['YARDADVANCE27'];$DYA28=$result_seYARD_ADVANCE['YARDADVANCE28'];$DYA29=$result_seYARD_ADVANCE['YARDADVANCE29'];$DYA30=$result_seYARD_ADVANCE['YARDADVANCE30'];$DYA31=$result_seYARD_ADVANCE['YARDADVANCE31'];
                                                
                                            // QUERY YARD_ONTIME
                                                $sql_seYARD_ONTIME = "SELECT
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '01/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME1',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '02/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME2',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '03/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME3',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '04/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME4',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '05/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME5',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '06/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME6',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '07/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME7',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '08/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME8',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '09/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME9',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '10/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME10',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '11/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME11',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '12/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME12',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '13/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME13',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '14/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME14',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '15/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME15',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '16/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME16',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '17/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME17',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '18/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME18',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '19/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME19',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '20/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME20',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '21/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME21',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '22/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME22',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '23/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME23',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '24/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME24',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '25/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME25',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '26/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME26',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '27/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME27',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '28/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME28',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '29/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME29',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '30/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME30',
                                                    (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '31/".$monthnumeric."/".$years."' AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'YARDONTIME31'";
                                                $params_seYARD_ONTIME  = array();
                                                $query_seYARD_ONTIME = sqlsrv_query($conn, $sql_seYARD_ONTIME, $params_seYARD_ONTIME);
                                                $result_seYARD_ONTIME = sqlsrv_fetch_array($query_seYARD_ONTIME, SQLSRV_FETCH_ASSOC);
                                                $DYOT1=$result_seYARD_ONTIME['YARDONTIME1'];$DYOT2=$result_seYARD_ONTIME['YARDONTIME2'];$DYOT3=$result_seYARD_ONTIME['YARDONTIME3'];$DYOT4=$result_seYARD_ONTIME['YARDONTIME4'];$DYOT5=$result_seYARD_ONTIME['YARDONTIME5'];$DYOT6=$result_seYARD_ONTIME['YARDONTIME6'];$DYOT7=$result_seYARD_ONTIME['YARDONTIME7'];$DYOT8=$result_seYARD_ONTIME['YARDONTIME8'];
                                                $DYOT9=$result_seYARD_ONTIME['YARDONTIME9'];$DYOT10=$result_seYARD_ONTIME['YARDONTIME10'];$DYOT11=$result_seYARD_ONTIME['YARDONTIME11'];$DYOT12=$result_seYARD_ONTIME['YARDONTIME12'];$DYOT13=$result_seYARD_ONTIME['YARDONTIME13'];$DYOT14=$result_seYARD_ONTIME['YARDONTIME14'];$DYOT15=$result_seYARD_ONTIME['YARDONTIME15'];$DYOT16=$result_seYARD_ONTIME['YARDONTIME16'];
                                                $DYOT17=$result_seYARD_ONTIME['YARDONTIME17'];$DYOT18=$result_seYARD_ONTIME['YARDONTIME18'];$DYOT19=$result_seYARD_ONTIME['YARDONTIME19'];$DYOT20=$result_seYARD_ONTIME['YARDONTIME20'];$DYOT21=$result_seYARD_ONTIME['YARDONTIME21'];$DYOT22=$result_seYARD_ONTIME['YARDONTIME22'];$DYOT23=$result_seYARD_ONTIME['YARDONTIME23'];$DYOT24=$result_seYARD_ONTIME['YARDONTIME24'];
                                                $DYOT25=$result_seYARD_ONTIME['YARDONTIME25'];$DYOT26=$result_seYARD_ONTIME['YARDONTIME26'];$DYOT27=$result_seYARD_ONTIME['YARDONTIME27'];$DYOT28=$result_seYARD_ONTIME['YARDONTIME28'];$DYOT29=$result_seYARD_ONTIME['YARDONTIME29'];$DYOT30=$result_seYARD_ONTIME['YARDONTIME30'];$DYOT31=$result_seYARD_ONTIME['YARDONTIME31'];
                                                
                                            
                                            // OPEN CAL YARD_DELAY WEEK 1-5
                                                $DYDWEEK1 = $DYD1+$DYD2+$DYD3;
                                                $DYDWEEK2 = $DYD4+$DYD5+$DYD6+$DYD7+$DYD8+$DYD9+$DYD10;
                                                $DYDWEEK3 = $DYD11+$DYD12+$DYD13+$DYD14+$DYD15+$DYD16+$DYD17;
                                                $DYDWEEK4 = $DYD18+$DYD19+$DYD20+$DYD21+$DYD22+$DYD23+$DYD24;
                                                $DYDWEEK5 = $DYD25+$DYD26+$DYD27+$DYD28+$DYD29+$DYD30+$DYD31;
                                            // OPEN CAL YARD_ADVANCE WEEK 1-5
                                                $DYAWEEK1 = $DYA1+$DYA2+$DYA3;
                                                $DYAWEEK2 = $DYA4+$DYA5+$DYA6+$DYA7+$DYA8+$DYA9+$DYA10;
                                                $DYAWEEK3 = $DYA11+$DYA12+$DYA13+$DYA14+$DYA15+$DYA16+$DYA17;
                                                $DYAWEEK4 = $DYA18+$DYA19+$DYA20+$DYA21+$DYA22+$DYA23+$DYA24;
                                                $DYAWEEK5 = $DYA25+$DYA26+$DYA27+$DYA28+$DYA29+$DYA30+$DYA31;
                                            // OPEN CAL YARD_ONTIME WEEK 1-5
                                                $DYOTWEEK1 = $DYOT1+$DYOT2+$DYOT3;
                                                $DYOTWEEK2 = $DYOT4+$DYOT5+$DYOT6+$DYOT7+$DYOT8+$DYOT9+$DYOT10;
                                                $DYOTWEEK3 = $DYOT11+$DYOT12+$DYOT13+$DYOT14+$DYOT15+$DYOT16+$DYOT17;
                                                $DYOTWEEK4 = $DYOT18+$DYOT19+$DYOT20+$DYOT21+$DYOT22+$DYOT23+$DYOT24;
                                                $DYOTWEEK5 = $DYOT25+$DYOT26+$DYOT27+$DYOT28+$DYOT29+$DYOT30+$DYOT31;
                                            
                                            // OPEN CAL YARD DYD+DYA+DYOT
                                                $DYTOTAL1 = $DYDWEEK1+$DYAWEEK1+$DYOTWEEK1;
                                                $DYTOTAL2 = $DYDWEEK2+$DYAWEEK2+$DYOTWEEK2;
                                                $DYTOTAL3 = $DYDWEEK3+$DYAWEEK3+$DYOTWEEK3;
                                                $DYTOTAL4 = $DYDWEEK4+$DYAWEEK4+$DYOTWEEK4;
                                                $DYTOTAL5 = $DYDWEEK5+$DYAWEEK5+$DYOTWEEK5;

                                            // OPEN CHECK YARD DYD IS NULL
                                                $CALDYD = 0;
                                                if($DYDWEEK1 == '0'){$CALDYD1 = '0';}else{$CALDYD1 = number_format((($DYDWEEK1*100)/$DYTOTAL1), 2 );}
                                                if($DYDWEEK2 == '0'){$CALDYD2 = '0';}else{$CALDYD2 = number_format((($DYDWEEK2*100)/$DYTOTAL2), 2 );}
                                                if($DYDWEEK3 == '0'){$CALDYD3 = '0';}else{$CALDYD3 = number_format((($DYDWEEK3*100)/$DYTOTAL3), 2 );}
                                                if($DYDWEEK4 == '0'){$CALDYD4 = '0';}else{$CALDYD4 = number_format((($DYDWEEK4*100)/$DYTOTAL4), 2 );}
                                                if($DYDWEEK5 == '0'){$CALDYD5 = '0';}else{$CALDYD5 = number_format((($DYDWEEK5*100)/$DYTOTAL5), 2 );}

                                            // OPEN CHECK YARD DYA IS NULL
                                                $CALDYA = 0;
                                                if($DYAWEEK1 == '0'){$CALDYA1 = '0';}else{$CALDYA1 = number_format((($DYAWEEK1*100)/$DYTOTAL1), 2 );}
                                                if($DYAWEEK2 == '0'){$CALDYA2 = '0';}else{$CALDYA2 = number_format((($DYAWEEK2*100)/$DYTOTAL2), 2 );}
                                                if($DYAWEEK3 == '0'){$CALDYA3 = '0';}else{$CALDYA3 = number_format((($DYAWEEK3*100)/$DYTOTAL3), 2 );}
                                                if($DYAWEEK4 == '0'){$CALDYA4 = '0';}else{$CALDYA4 = number_format((($DYAWEEK4*100)/$DYTOTAL4), 2 );}
                                                if($DYAWEEK5 == '0'){$CALDYA5 = '0';}else{$CALDYA5 = number_format((($DYAWEEK5*100)/$DYTOTAL5), 2 );}

                                            // OPEN CHECK YARD DYOT IS NULL
                                                $CALDYOT = 0;
                                                if($DYOTWEEK1 == '0'){$CALDYOT1 = '0';}else{$CALDYOT1 = number_format((($DYOTWEEK1*100)/$DYTOTAL1), 2 );}
                                                if($DYOTWEEK2 == '0'){$CALDYOT2 = '0';}else{$CALDYOT2 = number_format((($DYOTWEEK2*100)/$DYTOTAL2), 2 );}
                                                if($DYOTWEEK3 == '0'){$CALDYOT3 = '0';}else{$CALDYOT3 = number_format((($DYOTWEEK3*100)/$DYTOTAL3), 2 );}
                                                if($DYOTWEEK4 == '0'){$CALDYOT4 = '0';}else{$CALDYOT4 = number_format((($DYOTWEEK4*100)/$DYTOTAL4), 2 );}
                                                if($DYOTWEEK5 == '0'){$CALDYOT5 = '0';}else{$CALDYOT5 = number_format((($DYOTWEEK5*100)/$DYTOTAL5), 2 );}
                                            // ------------------------------------------------------------------------------------------------------------------
                                            // SUPPLIER 
                                            // ------------------------------------------------------------------------------------------------------------------
                                            // QUERY SUPPLIER_DELAY
                                                $sql_seSUPPLIER_DELAY = "SELECT
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '01/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY1',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '02/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY2',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '03/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY3',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '04/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY4',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '05/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY5',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '06/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY6',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '07/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY7',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '08/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY8',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '09/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY9',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '10/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY10',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '11/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY11',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '12/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY12',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '13/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY13',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '14/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY14',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '15/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY15',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '16/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY16',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '17/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY17',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '18/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY18',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '19/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY19',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '20/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY20',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '21/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY21',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '22/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY22',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '23/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY23',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '24/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY24',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '25/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY25',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '26/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY26',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '27/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY27',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '28/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY28',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '29/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY29',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '30/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY30',
                                                    (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '31/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'SUPPLIERDELAY31'";
                                                $params_seSUPPLIER_DELAY = array();
                                                $query_seSUPPLIER_DELAY = sqlsrv_query($conn, $sql_seSUPPLIER_DELAY, $params_seSUPPLIER_DELAY);
                                                $result_seSUPPLIER_DELAY = sqlsrv_fetch_array($query_seSUPPLIER_DELAY, SQLSRV_FETCH_ASSOC);
                                                $DSD1=$result_seSUPPLIER_DELAY['SUPPLIERDELAY1'];$DSD2=$result_seSUPPLIER_DELAY['SUPPLIERDELAY2'];$DSD3=$result_seSUPPLIER_DELAY['SUPPLIERDELAY3'];$DSD4=$result_seSUPPLIER_DELAY['SUPPLIERDELAY4'];$DSD5=$result_seSUPPLIER_DELAY['SUPPLIERDELAY5'];$DSD6=$result_seSUPPLIER_DELAY['SUPPLIERDELAY6'];$DSD7=$result_seSUPPLIER_DELAY['SUPPLIERDELAY7'];$DSD8=$result_seSUPPLIER_DELAY['SUPPLIERDELAY8'];
                                                $DSD9=$result_seSUPPLIER_DELAY['SUPPLIERDELAY9'];$DSD10=$result_seSUPPLIER_DELAY['SUPPLIERDELAY10'];$DSD11=$result_seSUPPLIER_DELAY['SUPPLIERDELAY11'];$DSD12=$result_seSUPPLIER_DELAY['SUPPLIERDELAY12'];$DSD13=$result_seSUPPLIER_DELAY['SUPPLIERDELAY13'];$DSD14=$result_seSUPPLIER_DELAY['SUPPLIERDELAY14'];$DSD15=$result_seSUPPLIER_DELAY['SUPPLIERDELAY15'];$DSD16=$result_seSUPPLIER_DELAY['SUPPLIERDELAY16'];
                                                $DSD17=$result_seSUPPLIER_DELAY['SUPPLIERDELAY17'];$DSD18=$result_seSUPPLIER_DELAY['SUPPLIERDELAY18'];$DSD19=$result_seSUPPLIER_DELAY['SUPPLIERDELAY19'];$DSD20=$result_seSUPPLIER_DELAY['SUPPLIERDELAY20'];$DSD21=$result_seSUPPLIER_DELAY['SUPPLIERDELAY21'];$DSD22=$result_seSUPPLIER_DELAY['SUPPLIERDELAY22'];$DSD23=$result_seSUPPLIER_DELAY['SUPPLIERDELAY23'];$DSD24=$result_seSUPPLIER_DELAY['SUPPLIERDELAY24'];
                                                $DSD25=$result_seSUPPLIER_DELAY['SUPPLIERDELAY25'];$DSD26=$result_seSUPPLIER_DELAY['SUPPLIERDELAY26'];$DSD27=$result_seSUPPLIER_DELAY['SUPPLIERDELAY27'];$DSD28=$result_seSUPPLIER_DELAY['SUPPLIERDELAY28'];$DSD29=$result_seSUPPLIER_DELAY['SUPPLIERDELAY29'];$DSD30=$result_seSUPPLIER_DELAY['SUPPLIERDELAY30'];$DSD31=$result_seSUPPLIER_DELAY['SUPPLIERDELAY31'];
                                                                                            
                                            // QUERY SUPPLIER_ADVANCE
                                                $sql_seSUPPLIER_ADVANCE = "SELECT
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '01/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE1',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '02/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE2',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '03/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE3',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '04/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE4',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '05/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE5',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '06/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE6',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '07/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE7',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '08/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE8',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '09/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE9',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '10/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE10',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '11/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE11',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '12/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE12',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '13/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE13',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '14/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE14',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '15/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE15',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '16/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE16',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '17/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE17',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '18/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE18',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '19/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE19',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '20/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE20',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '21/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE21',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '22/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE22',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '23/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE23',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '24/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE24',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '25/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE25',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '26/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE26',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '27/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE27',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '28/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE28',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '29/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE29',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '30/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE30',
                                                    (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '31/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'SUPPLIERADVANCE31'";
                                                $params_seSUPPLIER_ADVANCE  = array();
                                                $query_seSUPPLIER_ADVANCE = sqlsrv_query($conn, $sql_seSUPPLIER_ADVANCE, $params_seSUPPLIER_ADVANCE);
                                                $result_seSUPPLIER_ADVANCE = sqlsrv_fetch_array($query_seSUPPLIER_ADVANCE, SQLSRV_FETCH_ASSOC);
                                                $DSA1=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE1'];$DSA2=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE2'];$DSA3=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE3'];$DSA4=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE4'];$DSA5=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE5'];$DSA6=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE6'];$DSA7=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE7'];$DSA8=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE8'];
                                                $DSA9=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE9'];$DSA10=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE10'];$DSA11=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE11'];$DSA12=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE12'];$DSA13=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE13'];$DSA14=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE14'];$DSA15=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE15'];$DSA16=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE16'];
                                                $DSA17=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE17'];$DSA18=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE18'];$DSA19=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE19'];$DSA20=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE20'];$DSA21=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE21'];$DSA22=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE22'];$DSA23=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE23'];$DSA24=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE24'];
                                                $DSA25=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE25'];$DSA26=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE26'];$DSA27=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE27'];$DSA28=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE28'];$DSA29=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE29'];$DSA30=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE30'];$DSA31=$result_seSUPPLIER_ADVANCE['SUPPLIERADVANCE31'];
                                                
                                            // QUERY SUPPLIER_ONTIME
                                                $sql_seSUPPLIER_ONTIME = "SELECT
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '01/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME1',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '02/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME2',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '03/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME3',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '04/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME4',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '05/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME5',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '06/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME6',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '07/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME7',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '08/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME8',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '09/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME9',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '10/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME10',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '11/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME11',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '12/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME12',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '13/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME13',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '14/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME14',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '15/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME15',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '16/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME16',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '17/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME17',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '18/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME18',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '19/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME19',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '20/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME20',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '21/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME21',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '22/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME22',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '23/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME23',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '24/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME24',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '25/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME25',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '26/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME26',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '27/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME27',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '28/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME28',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '29/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME29',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '30/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME30',
                                                    (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '31/".$monthnumeric."/".$years."' AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'SUPPLIERONTIME31'";
                                                $params_seSUPPLIER_ONTIME  = array();
                                                $query_seSUPPLIER_ONTIME = sqlsrv_query($conn, $sql_seSUPPLIER_ONTIME, $params_seSUPPLIER_ONTIME);
                                                $result_seSUPPLIER_ONTIME = sqlsrv_fetch_array($query_seSUPPLIER_ONTIME, SQLSRV_FETCH_ASSOC);
                                                $DSOT1=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME1'];$DSOT2=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME2'];$DSOT3=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME3'];$DSOT4=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME4'];$DSOT5=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME5'];$DSOT6=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME6'];$DSOT7=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME7'];$DSOT8=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME8'];
                                                $DSOT9=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME9'];$DSOT10=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME10'];$DSOT11=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME11'];$DSOT12=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME12'];$DSOT13=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME13'];$DSOT14=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME14'];$DSOT15=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME15'];$DSOT16=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME16'];
                                                $DSOT17=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME17'];$DSOT18=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME18'];$DSOT19=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME19'];$DSOT20=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME20'];$DSOT21=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME21'];$DSOT22=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME22'];$DSOT23=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME23'];$DSOT24=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME24'];
                                                $DSOT25=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME25'];$DSOT26=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME26'];$DSOT27=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME27'];$DSOT28=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME28'];$DSOT29=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME29'];$DSOT30=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME30'];$DSOT31=$result_seSUPPLIER_ONTIME['SUPPLIERONTIME31'];
                                                
                                            
                                            // OPEN CAL SUPPLIER_DELAY WEEK 1-5
                                                $DSDWEEK1 = $DSD1+$DSD2+$DSD3;
                                                $DSDWEEK2 = $DSD4+$DSD5+$DSD6+$DSD7+$DSD8+$DSD9+$DSD10;
                                                $DSDWEEK3 = $DSD11+$DSD12+$DSD13+$DSD14+$DSD15+$DSD16+$DSD17;
                                                $DSDWEEK4 = $DSD18+$DSD19+$DSD20+$DSD21+$DSD22+$DSD23+$DSD24;
                                                $DSDWEEK5 = $DSD25+$DSD26+$DSD27+$DSD28+$DSD29+$DSD30+$DSD31;
                                            // OPEN CAL SUPPLIER_ADVANCE WEEK 1-5
                                                $DSAWEEK1 = $DSA1+$DSA2+$DSA3;
                                                $DSAWEEK2 = $DSA4+$DSA5+$DSA6+$DSA7+$DSA8+$DSA9+$DSA10;
                                                $DSAWEEK3 = $DSA11+$DSA12+$DSA13+$DSA14+$DSA15+$DSA16+$DSA17;
                                                $DSAWEEK4 = $DSA18+$DSA19+$DSA20+$DSA21+$DSA22+$DSA23+$DSA24;
                                                $DSAWEEK5 = $DSA25+$DSA26+$DSA27+$DSA28+$DSA29+$DSA30+$DSA31;
                                            // OPEN CAL SUPPLIER_ONTIME WEEK 1-5
                                                $DSOTWEEK1 = $DSOT1+$DSOT2+$DSOT3;
                                                $DSOTWEEK2 = $DSOT4+$DSOT5+$DSOT6+$DSOT7+$DSOT8+$DSOT9+$DSOT10;
                                                $DSOTWEEK3 = $DSOT11+$DSOT12+$DSOT13+$DSOT14+$DSOT15+$DSOT16+$DSOT17;
                                                $DSOTWEEK4 = $DSOT18+$DSOT19+$DSOT20+$DSOT21+$DSOT22+$DSOT23+$DSOT24;
                                                $DSOTWEEK5 = $DSOT25+$DSOT26+$DSOT27+$DSOT28+$DSOT29+$DSOT30+$DSOT31;
                                            
                                            // OPEN CAL SUPPLIER DSD+DSA+DSOT
                                                $DSTOTAL1 = $DSDWEEK1+$DSAWEEK1+$DSOTWEEK1;
                                                $DSTOTAL2 = $DSDWEEK2+$DSAWEEK2+$DSOTWEEK2;
                                                $DSTOTAL3 = $DSDWEEK3+$DSAWEEK3+$DSOTWEEK3;
                                                $DSTOTAL4 = $DSDWEEK4+$DSAWEEK4+$DSOTWEEK4;
                                                $DSTOTAL5 = $DSDWEEK5+$DSAWEEK5+$DSOTWEEK5;

                                            // OPEN CHECK SUPPLIER DSD IS NULL
                                                $CALDSD = 0;
                                                if($DSDWEEK1 == '0'){$CALDSD1 = '0';}else{$CALDSD1 = number_format((($DSDWEEK1*100)/$DSTOTAL1), 2 );}
                                                if($DSDWEEK2 == '0'){$CALDSD2 = '0';}else{$CALDSD2 = number_format((($DSDWEEK2*100)/$DSTOTAL2), 2 );}
                                                if($DSDWEEK3 == '0'){$CALDSD3 = '0';}else{$CALDSD3 = number_format((($DSDWEEK3*100)/$DSTOTAL3), 2 );}
                                                if($DSDWEEK4 == '0'){$CALDSD4 = '0';}else{$CALDSD4 = number_format((($DSDWEEK4*100)/$DSTOTAL4), 2 );}
                                                if($DSDWEEK5 == '0'){$CALDSD5 = '0';}else{$CALDSD5 = number_format((($DSDWEEK5*100)/$DSTOTAL5), 2 );}

                                            // OPEN CHECK SUPPLIER DSA IS NULL
                                                $CALDSA = 0;
                                                if($DSAWEEK1 == '0'){$CALDSA1 = '0';}else{$CALDSA1 = number_format((($DSAWEEK1*100)/$DSTOTAL1), 2 );}
                                                if($DSAWEEK2 == '0'){$CALDSA2 = '0';}else{$CALDSA2 = number_format((($DSAWEEK2*100)/$DSTOTAL2), 2 );}
                                                if($DSAWEEK3 == '0'){$CALDSA3 = '0';}else{$CALDSA3 = number_format((($DSAWEEK3*100)/$DSTOTAL3), 2 );}
                                                if($DSAWEEK4 == '0'){$CALDSA4 = '0';}else{$CALDSA4 = number_format((($DSAWEEK4*100)/$DSTOTAL4), 2 );}
                                                if($DSAWEEK5 == '0'){$CALDSA5 = '0';}else{$CALDSA5 = number_format((($DSAWEEK5*100)/$DSTOTAL5), 2 );}

                                            // OPEN CHECK SUPPLIER DSOT IS NULL
                                                $CALDSOT = 0;
                                                if($DSOTWEEK1 == '0'){$CALDSOT1 = '0';}else{$CALDSOT1 = number_format((($DSOTWEEK1*100)/$DSTOTAL1), 2 );}
                                                if($DSOTWEEK2 == '0'){$CALDSOT2 = '0';}else{$CALDSOT2 = number_format((($DSOTWEEK2*100)/$DSTOTAL2), 2 );}
                                                if($DSOTWEEK3 == '0'){$CALDSOT3 = '0';}else{$CALDSOT3 = number_format((($DSOTWEEK3*100)/$DSTOTAL3), 2 );}
                                                if($DSOTWEEK4 == '0'){$CALDSOT4 = '0';}else{$CALDSOT4 = number_format((($DSOTWEEK4*100)/$DSTOTAL4), 2 );}
                                                if($DSOTWEEK5 == '0'){$CALDSOT5 = '0';}else{$CALDSOT5 = number_format((($DSOTWEEK5*100)/$DSTOTAL5), 2 );}
                                            // ------------------------------------------------------------------------------------------------------------------
                                            // PLANT 
                                            // ------------------------------------------------------------------------------------------------------------------
                                            // QUERY PLANT_DELAY
                                                $sql_sePLANT_DELAY = "SELECT
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '01/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY1',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '02/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY2',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '03/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY3',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '04/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY4',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '05/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY5',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '06/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY6',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '07/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY7',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '08/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY8',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '09/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY9',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '10/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY10',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '11/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY11',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '12/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY12',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '13/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY13',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '14/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY14',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '15/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY15',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '16/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY16',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '17/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY17',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '18/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY18',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '19/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY19',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '20/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY20',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '21/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY21',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '22/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY22',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '23/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY23',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '24/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY24',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '25/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY25',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '26/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY26',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '27/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY27',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '28/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY28',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '29/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY29',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '30/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY30',
                                                    (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '31/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'PLANTDELAY31'";
                                                $params_sePLANT_DELAY = array();
                                                $query_sePLANT_DELAY = sqlsrv_query($conn, $sql_sePLANT_DELAY, $params_sePLANT_DELAY);
                                                $result_sePLANT_DELAY = sqlsrv_fetch_array($query_sePLANT_DELAY, SQLSRV_FETCH_ASSOC);
                                                $DPD1=$result_sePLANT_DELAY['PLANTDELAY1'];$DPD2=$result_sePLANT_DELAY['PLANTDELAY2'];$DPD3=$result_sePLANT_DELAY['PLANTDELAY3'];$DPD4=$result_sePLANT_DELAY['PLANTDELAY4'];$DPD5=$result_sePLANT_DELAY['PLANTDELAY5'];$DPD6=$result_sePLANT_DELAY['PLANTDELAY6'];$DPD7=$result_sePLANT_DELAY['PLANTDELAY7'];$DPD8=$result_sePLANT_DELAY['PLANTDELAY8'];
                                                $DPD9=$result_sePLANT_DELAY['PLANTDELAY9'];$DPD10=$result_sePLANT_DELAY['PLANTDELAY10'];$DPD11=$result_sePLANT_DELAY['PLANTDELAY11'];$DPD12=$result_sePLANT_DELAY['PLANTDELAY12'];$DPD13=$result_sePLANT_DELAY['PLANTDELAY13'];$DPD14=$result_sePLANT_DELAY['PLANTDELAY14'];$DPD15=$result_sePLANT_DELAY['PLANTDELAY15'];$DPD16=$result_sePLANT_DELAY['PLANTDELAY16'];
                                                $DPD17=$result_sePLANT_DELAY['PLANTDELAY17'];$DPD18=$result_sePLANT_DELAY['PLANTDELAY18'];$DPD19=$result_sePLANT_DELAY['PLANTDELAY19'];$DPD20=$result_sePLANT_DELAY['PLANTDELAY20'];$DPD21=$result_sePLANT_DELAY['PLANTDELAY21'];$DPD22=$result_sePLANT_DELAY['PLANTDELAY22'];$DPD23=$result_sePLANT_DELAY['PLANTDELAY23'];$DPD24=$result_sePLANT_DELAY['PLANTDELAY24'];
                                                $DPD25=$result_sePLANT_DELAY['PLANTDELAY25'];$DPD26=$result_sePLANT_DELAY['PLANTDELAY26'];$DPD27=$result_sePLANT_DELAY['PLANTDELAY27'];$DPD28=$result_sePLANT_DELAY['PLANTDELAY28'];$DPD29=$result_sePLANT_DELAY['PLANTDELAY29'];$DPD30=$result_sePLANT_DELAY['PLANTDELAY30'];$DPD31=$result_sePLANT_DELAY['PLANTDELAY31'];
                                                                                            
                                            // QUERY PLANT_ADVANCE
                                                $sql_sePLANT_ADVANCE = "SELECT
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '01/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE1',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '02/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE2',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '03/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE3',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '04/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE4',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '05/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE5',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '06/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE6',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '07/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE7',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '08/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE8',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '09/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE9',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '10/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE10',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '11/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE11',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '12/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE12',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '13/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE13',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '14/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE14',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '15/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE15',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '16/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE16',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '17/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE17',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '18/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE18',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '19/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE19',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '20/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE20',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '21/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE21',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '22/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE22',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '23/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE23',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '24/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE24',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '25/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE25',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '26/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE26',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '27/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE27',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '28/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE28',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '29/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE29',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '30/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE30',
                                                    (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '31/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'PLANTADVANCE31'";
                                                $params_sePLANT_ADVANCE  = array();
                                                $query_sePLANT_ADVANCE = sqlsrv_query($conn, $sql_sePLANT_ADVANCE, $params_sePLANT_ADVANCE);
                                                $result_sePLANT_ADVANCE = sqlsrv_fetch_array($query_sePLANT_ADVANCE, SQLSRV_FETCH_ASSOC);
                                                $DPA1=$result_sePLANT_ADVANCE['PLANTADVANCE1'];$DPA2=$result_sePLANT_ADVANCE['PLANTADVANCE2'];$DPA3=$result_sePLANT_ADVANCE['PLANTADVANCE3'];$DPA4=$result_sePLANT_ADVANCE['PLANTADVANCE4'];$DPA5=$result_sePLANT_ADVANCE['PLANTADVANCE5'];$DPA6=$result_sePLANT_ADVANCE['PLANTADVANCE6'];$DPA7=$result_sePLANT_ADVANCE['PLANTADVANCE7'];$DPA8=$result_sePLANT_ADVANCE['PLANTADVANCE8'];
                                                $DPA9=$result_sePLANT_ADVANCE['PLANTADVANCE9'];$DPA10=$result_sePLANT_ADVANCE['PLANTADVANCE10'];$DPA11=$result_sePLANT_ADVANCE['PLANTADVANCE11'];$DPA12=$result_sePLANT_ADVANCE['PLANTADVANCE12'];$DPA13=$result_sePLANT_ADVANCE['PLANTADVANCE13'];$DPA14=$result_sePLANT_ADVANCE['PLANTADVANCE14'];$DPA15=$result_sePLANT_ADVANCE['PLANTADVANCE15'];$DPA16=$result_sePLANT_ADVANCE['PLANTADVANCE16'];
                                                $DPA17=$result_sePLANT_ADVANCE['PLANTADVANCE17'];$DPA18=$result_sePLANT_ADVANCE['PLANTADVANCE18'];$DPA19=$result_sePLANT_ADVANCE['PLANTADVANCE19'];$DPA20=$result_sePLANT_ADVANCE['PLANTADVANCE20'];$DPA21=$result_sePLANT_ADVANCE['PLANTADVANCE21'];$DPA22=$result_sePLANT_ADVANCE['PLANTADVANCE22'];$DPA23=$result_sePLANT_ADVANCE['PLANTADVANCE23'];$DPA24=$result_sePLANT_ADVANCE['PLANTADVANCE24'];
                                                $DPA25=$result_sePLANT_ADVANCE['PLANTADVANCE25'];$DPA26=$result_sePLANT_ADVANCE['PLANTADVANCE26'];$DPA27=$result_sePLANT_ADVANCE['PLANTADVANCE27'];$DPA28=$result_sePLANT_ADVANCE['PLANTADVANCE28'];$DPA29=$result_sePLANT_ADVANCE['PLANTADVANCE29'];$DPA30=$result_sePLANT_ADVANCE['PLANTADVANCE30'];$DPA31=$result_sePLANT_ADVANCE['PLANTADVANCE31'];
                                                
                                            // QUERY PLANT_ONTIME
                                                $sql_sePLANT_ONTIME = "SELECT
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '01/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME1',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '02/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME2',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '03/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME3',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '04/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME4',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '05/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME5',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '06/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME6',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '07/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME7',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '08/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME8',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '09/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME9',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '10/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME10',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '11/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME11',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '12/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME12',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '13/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME13',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '14/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME14',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '15/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME15',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '16/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME16',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '17/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME17',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '18/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME18',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '19/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME19',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '20/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME20',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '21/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME21',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '22/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME22',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '23/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME23',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '24/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME24',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '25/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME25',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '26/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME26',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '27/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME27',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '28/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME28',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '29/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME29',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '30/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME30',
                                                    (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '31/".$monthnumeric."/".$years."' AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'PLANTONTIME31'";
                                                $params_sePLANT_ONTIME  = array();
                                                $query_sePLANT_ONTIME = sqlsrv_query($conn, $sql_sePLANT_ONTIME, $params_sePLANT_ONTIME);
                                                $result_sePLANT_ONTIME = sqlsrv_fetch_array($query_sePLANT_ONTIME, SQLSRV_FETCH_ASSOC);
                                                $DPOT1=$result_sePLANT_ONTIME['PLANTONTIME1'];$DPOT2=$result_sePLANT_ONTIME['PLANTONTIME2'];$DPOT3=$result_sePLANT_ONTIME['PLANTONTIME3'];$DPOT4=$result_sePLANT_ONTIME['PLANTONTIME4'];$DPOT5=$result_sePLANT_ONTIME['PLANTONTIME5'];$DPOT6=$result_sePLANT_ONTIME['PLANTONTIME6'];$DPOT7=$result_sePLANT_ONTIME['PLANTONTIME7'];$DPOT8=$result_sePLANT_ONTIME['PLANTONTIME8'];
                                                $DPOT9=$result_sePLANT_ONTIME['PLANTONTIME9'];$DPOT10=$result_sePLANT_ONTIME['PLANTONTIME10'];$DPOT11=$result_sePLANT_ONTIME['PLANTONTIME11'];$DPOT12=$result_sePLANT_ONTIME['PLANTONTIME12'];$DPOT13=$result_sePLANT_ONTIME['PLANTONTIME13'];$DPOT14=$result_sePLANT_ONTIME['PLANTONTIME14'];$DPOT15=$result_sePLANT_ONTIME['PLANTONTIME15'];$DPOT16=$result_sePLANT_ONTIME['PLANTONTIME16'];
                                                $DPOT17=$result_sePLANT_ONTIME['PLANTONTIME17'];$DPOT18=$result_sePLANT_ONTIME['PLANTONTIME18'];$DPOT19=$result_sePLANT_ONTIME['PLANTONTIME19'];$DPOT20=$result_sePLANT_ONTIME['PLANTONTIME20'];$DPOT21=$result_sePLANT_ONTIME['PLANTONTIME21'];$DPOT22=$result_sePLANT_ONTIME['PLANTONTIME22'];$DPOT23=$result_sePLANT_ONTIME['PLANTONTIME23'];$DPOT24=$result_sePLANT_ONTIME['PLANTONTIME24'];
                                                $DPOT25=$result_sePLANT_ONTIME['PLANTONTIME25'];$DPOT26=$result_sePLANT_ONTIME['PLANTONTIME26'];$DPOT27=$result_sePLANT_ONTIME['PLANTONTIME27'];$DPOT28=$result_sePLANT_ONTIME['PLANTONTIME28'];$DPOT29=$result_sePLANT_ONTIME['PLANTONTIME29'];$DPOT30=$result_sePLANT_ONTIME['PLANTONTIME30'];$DPOT31=$result_sePLANT_ONTIME['PLANTONTIME31'];
                                                
                                            
                                            // OPEN CAL PLANT_DELAY WEEK 1-5
                                                $DPDWEEK1 = $DPD1+$DPD2+$DPD3;
                                                $DPDWEEK2 = $DPD4+$DPD5+$DPD6+$DPD7+$DPD8+$DPD9+$DPD10;
                                                $DPDWEEK3 = $DPD11+$DPD12+$DPD13+$DPD14+$DPD15+$DPD16+$DPD17;
                                                $DPDWEEK4 = $DPD18+$DPD19+$DPD20+$DPD21+$DPD22+$DPD23+$DPD24;
                                                $DPDWEEK5 = $DPD25+$DPD26+$DPD27+$DPD28+$DPD29+$DPD30+$DPD31;
                                            // OPEN CAL PLANT_ADVANCE WEEK 1-5
                                                $DPAWEEK1 = $DPA1+$DPA2+$DPA3;
                                                $DPAWEEK2 = $DPA4+$DPA5+$DPA6+$DPA7+$DPA8+$DPA9+$DPA10;
                                                $DPAWEEK3 = $DPA11+$DPA12+$DPA13+$DPA14+$DPA15+$DPA16+$DPA17;
                                                $DPAWEEK4 = $DPA18+$DPA19+$DPA20+$DPA21+$DPA22+$DPA23+$DPA24;
                                                $DPAWEEK5 = $DPA25+$DPA26+$DPA27+$DPA28+$DPA29+$DPA30+$DPA31;
                                            // OPEN CAL PLANT_ONTIME WEEK 1-5
                                                $DPOTWEEK1 = $DPOT1+$DPOT2+$DPOT3;
                                                $DPOTWEEK2 = $DPOT4+$DPOT5+$DPOT6+$DPOT7+$DPOT8+$DPOT9+$DPOT10;
                                                $DPOTWEEK3 = $DPOT11+$DPOT12+$DPOT13+$DPOT14+$DPOT15+$DPOT16+$DPOT17;
                                                $DPOTWEEK4 = $DPOT18+$DPOT19+$DPOT20+$DPOT21+$DPOT22+$DPOT23+$DPOT24;
                                                $DPOTWEEK5 = $DPOT25+$DPOT26+$DPOT27+$DPOT28+$DPOT29+$DPOT30+$DPOT31;
                                            
                                            // OPEN CAL PLANT DPD+DPA+DPOT
                                                $DPTOTAL1 = $DPDWEEK1+$DPAWEEK1+$DPOTWEEK1;
                                                $DPTOTAL2 = $DPDWEEK2+$DPAWEEK2+$DPOTWEEK2;
                                                $DPTOTAL3 = $DPDWEEK3+$DPAWEEK3+$DPOTWEEK3;
                                                $DPTOTAL4 = $DPDWEEK4+$DPAWEEK4+$DPOTWEEK4;
                                                $DPTOTAL5 = $DPDWEEK5+$DPAWEEK5+$DPOTWEEK5;

                                            // OPEN CHECK PLANT DPD IS NULL
                                                $CALDPD = 0;
                                                if($DPDWEEK1 == '0'){$CALDPD1 = '0';}else{$CALDPD1 = number_format((($DPDWEEK1*100)/$DPTOTAL1), 2 );}
                                                if($DPDWEEK2 == '0'){$CALDPD2 = '0';}else{$CALDPD2 = number_format((($DPDWEEK2*100)/$DPTOTAL2), 2 );}
                                                if($DPDWEEK3 == '0'){$CALDPD3 = '0';}else{$CALDPD3 = number_format((($DPDWEEK3*100)/$DPTOTAL3), 2 );}
                                                if($DPDWEEK4 == '0'){$CALDPD4 = '0';}else{$CALDPD4 = number_format((($DPDWEEK4*100)/$DPTOTAL4), 2 );}
                                                if($DPDWEEK5 == '0'){$CALDPD5 = '0';}else{$CALDPD5 = number_format((($DPDWEEK5*100)/$DPTOTAL5), 2 );}

                                            // OPEN CHECK PLANT DPA IS NULL
                                                $CALDPA = 0;
                                                if($DPAWEEK1 == '0'){$CALDPA1 = '0';}else{$CALDPA1 = number_format((($DPAWEEK1*100)/$DPTOTAL1), 2 );}
                                                if($DPAWEEK2 == '0'){$CALDPA2 = '0';}else{$CALDPA2 = number_format((($DPAWEEK2*100)/$DPTOTAL2), 2 );}
                                                if($DPAWEEK3 == '0'){$CALDPA3 = '0';}else{$CALDPA3 = number_format((($DPAWEEK3*100)/$DPTOTAL3), 2 );}
                                                if($DPAWEEK4 == '0'){$CALDPA4 = '0';}else{$CALDPA4 = number_format((($DPAWEEK4*100)/$DPTOTAL4), 2 );}
                                                if($DPAWEEK5 == '0'){$CALDPA5 = '0';}else{$CALDPA5 = number_format((($DPAWEEK5*100)/$DPTOTAL5), 2 );}

                                            // OPEN CHECK PLANT DPOT IS NULL
                                                $CALDPOT = 0;
                                                if($DPOTWEEK1 == '0'){$CALDPOT1 = '0';}else{$CALDPOT1 = number_format((($DPOTWEEK1*100)/$DPTOTAL1), 2 );}
                                                if($DPOTWEEK2 == '0'){$CALDPOT2 = '0';}else{$CALDPOT2 = number_format((($DPOTWEEK2*100)/$DPTOTAL2), 2 );}
                                                if($DPOTWEEK3 == '0'){$CALDPOT3 = '0';}else{$CALDPOT3 = number_format((($DPOTWEEK3*100)/$DPTOTAL3), 2 );}
                                                if($DPOTWEEK4 == '0'){$CALDPOT4 = '0';}else{$CALDPOT4 = number_format((($DPOTWEEK4*100)/$DPTOTAL4), 2 );}
                                                if($DPOTWEEK5 == '0'){$CALDPOT5 = '0';}else{$CALDPOT5 = number_format((($DPOTWEEK5*100)/$DPTOTAL5), 2 );}
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
                                                    ['Week 1',<?=$CALDYD1;?>,<?=$CALDYA1;?>,<?=$CALDYOT1;?>],
                                                    ['Week 2',<?=$CALDYD2;?>,<?=$CALDYA2;?>,<?=$CALDYOT2;?>],
                                                    ['Week 3',<?=$CALDYD3;?>,<?=$CALDYA3;?>,<?=$CALDYOT3;?>],
                                                    ['Week 4',<?=$CALDYD4;?>,<?=$CALDYA4;?>,<?=$CALDYOT4;?>],
                                                    ['Week 5',<?=$CALDYD5;?>,<?=$CALDYA5;?>,<?=$CALDYOT5;?>]
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
                                                        hAxis: {title: 'กราฟข้อมูล Punctuality Truck Yard ประจำเดือน <?=DateThai($strDate)?> <?=$years+543?>'},
                                                        legend: {position: 'top'},
                                                        series: {
                                                                0: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,}, // YARD_DELAY
                                                                1: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,}, // YARD_ADVANCE
                                                                2: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,} // YARD_ONTIME
                                                                },
                                                        tooltip: {},
                                                        colors: ['#1E90FF', '#FFD700', '#228B22']
                                                    };
                                                var chart1 = new google.visualization.ComboChart(document.getElementById('chart_yard'));
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
                                                    ['Week 1',<?=$CALDSD1;?>,<?=$CALDSA1;?>,<?=$CALDSOT1;?>],
                                                    ['Week 2',<?=$CALDSD2;?>,<?=$CALDSA2;?>,<?=$CALDSOT2;?>],
                                                    ['Week 3',<?=$CALDSD3;?>,<?=$CALDSA3;?>,<?=$CALDSOT3;?>],
                                                    ['Week 4',<?=$CALDSD4;?>,<?=$CALDSA4;?>,<?=$CALDSOT4;?>],
                                                    ['Week 5',<?=$CALDSD5;?>,<?=$CALDSA5;?>,<?=$CALDSOT5;?>]
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
                                                        hAxis: {title: 'กราฟข้อมูล Punctuality Supplier ประจำเดือน <?=DateThai($strDate)?> <?=$years+543?>'},
                                                        legend: {position: 'top'},
                                                        series: {
                                                                0: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,}, // SUPPLIER_DELAY
                                                                1: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,}, // SUPPLIER_ADVANCE
                                                                2: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,} // SUPPLIER_ONTIME
                                                                },
                                                        tooltip: {},
                                                        colors: ['#1E90FF', '#FFD700', '#228B22']
                                                    };
                                                var chart2 = new google.visualization.ComboChart(document.getElementById('chart_supplier'));
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
                                                    ['Week 1',<?=$CALDPD1;?>,<?=$CALDPA1;?>,<?=$CALDPOT1;?>],
                                                    ['Week 2',<?=$CALDPD2;?>,<?=$CALDPA2;?>,<?=$CALDPOT2;?>],
                                                    ['Week 3',<?=$CALDPD3;?>,<?=$CALDPA3;?>,<?=$CALDPOT3;?>],
                                                    ['Week 4',<?=$CALDPD4;?>,<?=$CALDPA4;?>,<?=$CALDPOT4;?>],
                                                    ['Week 5',<?=$CALDPD5;?>,<?=$CALDPA5;?>,<?=$CALDPOT5;?>]
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
                                                        hAxis: {title: 'กราฟข้อมูล Punctuality Plant ประจำเดือน <?=DateThai($strDate)?> <?=$years+543?>'},
                                                        legend: {position: 'top'},
                                                        series: {
                                                                0: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,}, // PLANT_DELAY
                                                                1: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,}, // PLANT_ADVANCE
                                                                2: {type: 'bars',lineWidth: 5,pointShape:'circle',pointSize: 10,} // PLANT_ONTIME
                                                                },
                                                        tooltip: {},
                                                        colors: ['#1E90FF', '#FFD700', '#228B22']
                                                    };
                                                var chart3 = new google.visualization.ComboChart(document.getElementById('chart_plant'));
                                                chart3.draw(view3, options3);
                                            }
                                        </script>
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
            function export_month_graph_punctual_pdf()
            {
               var monthnumeric = document.getElementById('txt_monthnumberic').value;
               var month = document.getElementById('txt_month').value;
               var years = document.getElementById('txt_years').value;
                // alert(months);
                // alert(employeecode);
                window.open('meg_digitaltenko_Punctuality_MonthGraphPrint.php?monthnumeric=' + monthnumeric + '&month=' + month+ '&years=' + years, '_blank');
            }
    </script>

    </body>


</html>
