<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$monthnumeric  = $_POST['monthnumeric']; //เดือนที่เป็นตัวเลช
$month  = $_POST['month']; //เดือนที่เป็นอักษร
$years  = $_POST['years'];
$truckdatachk = $_POST['truckdata'];

if ($truckdatachk == 'FeedbackDriver') {
    $truckdata = 'Punctuality';
}
?>
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">

        <style>
            .table-scroll {
                overflow-x: scroll;
                overflow-y: visible;
                padding-bottom: 5px;
                width: 98%;
            }
        </style>

        <div class="col-lg-12">
            <b style="font-size: 18px"></b>
            &nbsp;<button class="button" style="width:20%;font-size: 18px;background-color: #93f786;border:solid 2px;color:black" onclick="select_DigitalTenkoKPI('FeedbackDriver')">ค้นหาข้อมูล Punctuality</button>
        </div>
        <div class="col-lg-12">&nbsp;</div>
        <div class="col-lg-12">&nbsp;</div>


        <?php
        if ($truckdatachk == 'FeedbackDriver') {
        ?>
        

        <!-- START Punctuality -->
        <div class="row" >
            <div class="col-lg-12" >
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #ffc400;">
                        <label><font style="font-size: 20px"><b><u><?=$truckdata?></u></b>&nbsp;&nbsp;Month:</font> <font style="font-size: 20px"><b><u><?= $month ?></u></b>&nbsp;<b><u><?= $years ?></u></b></font></label>
                    </div>
                    <div class="panel-body">
                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                            <div class = "row">                                
                                <!-- //Punctuality Row1  -->
                                <h3><b>1. Departure time truck yard</b></h3>
                                <div class="scol-lg-2">
                                    <div class="table-scroll">
                                        <table class="table table-striped table-hover dataTable no-footer dtr-inline" id="dataTables-example6" role="grid" aria-describedby="dataTables-example_info" >
                                            <thead style="border:1px solid black;">
                                                <tr>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>No.</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>Date</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>1</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>2</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>3</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>4</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>5</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>6</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>7</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>8</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>9</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>10</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>11</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>12</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>13</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>14</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>15</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>16</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>17</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>18</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>19</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>20</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>21</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>22</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>23</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>24</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>25</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>26</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>27</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>28</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>29</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>30</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>31</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>Total</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Delay -->
                                                <tr>
                                                    <!-- QueryData Delay-->
                                                    <?php
                                                        $sql_seYARD_DELAY = "SELECT
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '01/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE1',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '02/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE2',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '03/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE3',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '04/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE4',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '05/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE5',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '06/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE6',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '07/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE7',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '08/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE8',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '09/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE9',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '10/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE10',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '11/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE11',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '12/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE12',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '13/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE13',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '14/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE14',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '15/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE15',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '16/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE16',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '17/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE17',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '18/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE18',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '19/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE19',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '20/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE20',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '21/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE21',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '22/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE22',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '23/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE23',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '24/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE24',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '25/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE25',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '26/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE26',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '27/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE27',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '28/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE28',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '29/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE29',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '30/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE30',
                                                        (SELECT COUNT (*) AS YARD_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '31/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Delay%') AS 'DATE31'";
                                                        $params_seYARD_DELAY  = array();
                                                        $query_seYARD_DELAY = sqlsrv_query($conn, $sql_seYARD_DELAY, $params_seYARD_DELAY);
                                                        $result_seYARD_DELAY = sqlsrv_fetch_array($query_seYARD_DELAY, SQLSRV_FETCH_ASSOC);
                                                        $DYD1=$result_seYARD_DELAY['DATE1'];$DYD2=$result_seYARD_DELAY['DATE2'];$DYD3=$result_seYARD_DELAY['DATE3'];$DYD4=$result_seYARD_DELAY['DATE4'];$DYD5=$result_seYARD_DELAY['DATE5'];$DYD6=$result_seYARD_DELAY['DATE6'];$DYD7=$result_seYARD_DELAY['DATE7'];$DYD8=$result_seYARD_DELAY['DATE8'];
                                                        $DYD9=$result_seYARD_DELAY['DATE9'];$DYD10=$result_seYARD_DELAY['DATE10'];$DYD11=$result_seYARD_DELAY['DATE11'];$DYD12=$result_seYARD_DELAY['DATE12'];$DYD13=$result_seYARD_DELAY['DATE13'];$DYD14=$result_seYARD_DELAY['DATE14'];$DYD15=$result_seYARD_DELAY['DATE15'];$DYD16=$result_seYARD_DELAY['DATE16'];
                                                        $DYD17=$result_seYARD_DELAY['DATE17'];$DYD18=$result_seYARD_DELAY['DATE18'];$DYD19=$result_seYARD_DELAY['DATE19'];$DYD20=$result_seYARD_DELAY['DATE20'];$DYD21=$result_seYARD_DELAY['DATE21'];$DYD22=$result_seYARD_DELAY['DATE22'];$DYD23=$result_seYARD_DELAY['DATE23'];$DYD24=$result_seYARD_DELAY['DATE24'];
                                                        $DYD25=$result_seYARD_DELAY['DATE25'];$DYD26=$result_seYARD_DELAY['DATE26'];$DYD27=$result_seYARD_DELAY['DATE27'];$DYD28=$result_seYARD_DELAY['DATE28'];$DYD29=$result_seYARD_DELAY['DATE29'];$DYD30=$result_seYARD_DELAY['DATE30'];$DYD31=$result_seYARD_DELAY['DATE31'];
                                                        $SUMYARD_DELAY = $DYD1 + $DYD2 + $DYD3 + $DYD4 + $DYD5 + $DYD6 + $DYD7 + $DYD8 + $DYD9 + $DYD10 + $DYD11 + $DYD12 + $DYD13 + $DYD14 + $DYD15 + $DYD16 + $DYD17 + $DYD18 + $DYD19 + $DYD20 + $DYD21 + $DYD22 + $DYD23 + $DYD24 + $DYD25 + $DYD26 + $DYD27 + $DYD28 + $DYD29 + $DYD30 + $DYD31;
                                                    ?>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><b>1</b></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: left;background-color: #c1e8ff"><b>Delay</b></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE1'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE2'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE3'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE4'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE5'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE6'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE7'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE8'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE9'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE10'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE11'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE12'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE13'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE14'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE15'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE16'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE17'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE18'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE19'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE20'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE21'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE22'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE23'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE24'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE25'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE26'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE27'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE28'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE29'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE30'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seYARD_DELAY['DATE31'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #ffbcee"><b><?=$SUMYARD_DELAY;?></b></td>
                                                </tr>
                                                <!-- Advance -->
                                                <tr>
                                                    <!-- QueryData Advance-->
                                                    <?php
                                                        $sql_seYARD_ADVANCE = "SELECT
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '01/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE1',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '02/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE2',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '03/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE3',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '04/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE4',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '05/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE5',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '06/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE6',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '07/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE7',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '08/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE8',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '09/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE9',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '10/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE10',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '11/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE11',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '12/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE12',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '13/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE13',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '14/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE14',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '15/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE15',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '16/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE16',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '17/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE17',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '18/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE18',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '19/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE19',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '20/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE20',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '21/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE21',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '22/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE22',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '23/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE23',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '24/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE24',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '25/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE25',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '26/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE26',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '27/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE27',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '28/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE28',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '29/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE29',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '30/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE30',
                                                        (SELECT COUNT (*) AS YARD_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '31/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%Advance%') AS 'DATE31'";
                                                        $params_seYARD_ADVANCE  = array();
                                                        $query_seYARD_ADVANCE = sqlsrv_query($conn, $sql_seYARD_ADVANCE, $params_seYARD_ADVANCE);
                                                        $result_seYARD_ADVANCE = sqlsrv_fetch_array($query_seYARD_ADVANCE, SQLSRV_FETCH_ASSOC);
                                                        $DYA1=$result_seYARD_ADVANCE['DATE1'];$DYA2=$result_seYARD_ADVANCE['DATE2'];$DYA3=$result_seYARD_ADVANCE['DATE3'];$DYA4=$result_seYARD_ADVANCE['DATE4'];$DYA5=$result_seYARD_ADVANCE['DATE5'];$DYA6=$result_seYARD_ADVANCE['DATE6'];$DYA7=$result_seYARD_ADVANCE['DATE7'];$DYA8=$result_seYARD_ADVANCE['DATE8'];
                                                        $DYA9=$result_seYARD_ADVANCE['DATE9'];$DYA10=$result_seYARD_ADVANCE['DATE10'];$DYA11=$result_seYARD_ADVANCE['DATE11'];$DYA12=$result_seYARD_ADVANCE['DATE12'];$DYA13=$result_seYARD_ADVANCE['DATE13'];$DYA14=$result_seYARD_ADVANCE['DATE14'];$DYA15=$result_seYARD_ADVANCE['DATE15'];$DYA16=$result_seYARD_ADVANCE['DATE16'];
                                                        $DYA17=$result_seYARD_ADVANCE['DATE17'];$DYA18=$result_seYARD_ADVANCE['DATE18'];$DYA19=$result_seYARD_ADVANCE['DATE19'];$DYA20=$result_seYARD_ADVANCE['DATE20'];$DYA21=$result_seYARD_ADVANCE['DATE21'];$DYA22=$result_seYARD_ADVANCE['DATE22'];$DYA23=$result_seYARD_ADVANCE['DATE23'];$DYA24=$result_seYARD_ADVANCE['DATE24'];
                                                        $DYA25=$result_seYARD_ADVANCE['DATE25'];$DYA26=$result_seYARD_ADVANCE['DATE26'];$DYA27=$result_seYARD_ADVANCE['DATE27'];$DYA28=$result_seYARD_ADVANCE['DATE28'];$DYA29=$result_seYARD_ADVANCE['DATE29'];$DYA30=$result_seYARD_ADVANCE['DATE30'];$DYA31=$result_seYARD_ADVANCE['DATE31'];
                                                        $SUMYARD_ADVANCE = $DYA1 + $DYA2 + $DYA3 + $DYA4 + $DYA5 + $DYA6 + $DYA7 + $DYA8 + $DYA9 + $DYA10 + $DYA11 + $DYA12 + $DYA13 + $DYA14 + $DYA15 + $DYA16 + $DYA17 + $DYA18 + $DYA19 + $DYA20 + $DYA21 + $DYA22 + $DYA23 + $DYA24 + $DYA25 + $DYA26 + $DYA27 + $DYA28 + $DYA29 + $DYA30 + $DYA31;
                                                    ?>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><b>2</b></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: left;background-color: #fff0aa"><b>Advance</b></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE1'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE2'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE3'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE4'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE5'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE6'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE7'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE8'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE9'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE10'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE11'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE12'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE13'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE14'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE15'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE16'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE17'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE18'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE19'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE20'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE21'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE22'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE23'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE24'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE25'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE26'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE27'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE28'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE29'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE30'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seYARD_ADVANCE['DATE31'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #ffbcee"><b><?=$SUMYARD_ADVANCE;?></b></td>
                                                </tr>
                                                <!-- On time -->
                                                <tr>
                                                    <!-- QueryData On time -->
                                                    <?php
                                                        $sql_seYARD_ONTIME = "SELECT
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '01/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE1',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '02/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE2',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '03/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE3',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '04/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE4',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '05/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE5',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '06/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE6',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '07/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE7',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '08/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE8',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '09/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE9',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '10/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE10',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '11/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE11',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '12/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE12',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '13/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE13',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '14/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE14',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '15/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE15',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '16/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE16',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '17/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE17',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '18/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE18',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '19/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE19',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '20/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE20',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '21/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE21',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '22/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE22',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '23/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE23',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '24/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE24',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '25/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE25',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '26/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE26',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '27/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE27',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '28/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE28',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '29/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE29',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '30/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE30',
                                                        (SELECT COUNT (*) AS YARD_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '31/".$monthnumeric."/".$years."'
                                                        AND HOP = 'YARD' AND PUNC_OF_DEPARTURE LIKE '%On Time%') AS 'DATE31'";
                                                        $params_seYARD_ONTIME  = array();
                                                        $query_seYARD_ONTIME = sqlsrv_query($conn, $sql_seYARD_ONTIME, $params_seYARD_ONTIME);
                                                        $result_seYARD_ONTIME = sqlsrv_fetch_array($query_seYARD_ONTIME, SQLSRV_FETCH_ASSOC);
                                                        $DYOT1=$result_seYARD_ONTIME['DATE1'];$DYOT2=$result_seYARD_ONTIME['DATE2'];$DYOT3=$result_seYARD_ONTIME['DATE3'];$DYOT4=$result_seYARD_ONTIME['DATE4'];$DYOT5=$result_seYARD_ONTIME['DATE5'];$DYOT6=$result_seYARD_ONTIME['DATE6'];$DYOT7=$result_seYARD_ONTIME['DATE7'];$DYOT8=$result_seYARD_ONTIME['DATE8'];
                                                        $DYOT9=$result_seYARD_ONTIME['DATE9'];$DYOT10=$result_seYARD_ONTIME['DATE10'];$DYOT11=$result_seYARD_ONTIME['DATE11'];$DYOT12=$result_seYARD_ONTIME['DATE12'];$DYOT13=$result_seYARD_ONTIME['DATE13'];$DYOT14=$result_seYARD_ONTIME['DATE14'];$DYOT15=$result_seYARD_ONTIME['DATE15'];$DYOT16=$result_seYARD_ONTIME['DATE16'];
                                                        $DYOT17=$result_seYARD_ONTIME['DATE17'];$DYOT18=$result_seYARD_ONTIME['DATE18'];$DYOT19=$result_seYARD_ONTIME['DATE19'];$DYOT20=$result_seYARD_ONTIME['DATE20'];$DYOT21=$result_seYARD_ONTIME['DATE21'];$DYOT22=$result_seYARD_ONTIME['DATE22'];$DYOT23=$result_seYARD_ONTIME['DATE23'];$DYOT24=$result_seYARD_ONTIME['DATE24'];
                                                        $DYOT25=$result_seYARD_ONTIME['DATE25'];$DYOT26=$result_seYARD_ONTIME['DATE26'];$DYOT27=$result_seYARD_ONTIME['DATE27'];$DYOT28=$result_seYARD_ONTIME['DATE28'];$DYOT29=$result_seYARD_ONTIME['DATE29'];$DYOT30=$result_seYARD_ONTIME['DATE30'];$DYOT31=$result_seYARD_ONTIME['DATE31'];
                                                        $SUMYARD_ONTIME = $DYOT1 + $DYOT2 + $DYOT3 + $DYOT4 + $DYOT5 + $DYOT6 + $DYOT7 + $DYOT8 + $DYOT9 + $DYOT10 + $DYOT11 + $DYOT12 + $DYOT13 + $DYOT14 + $DYOT15 + $DYOT16 + $DYOT17 + $DYOT18 + $DYOT19 + $DYOT20 + $DYOT21 + $DYOT22 + $DYOT23 + $DYOT24 + $DYOT25 + $DYOT26 + $DYOT27 + $DYOT28 + $DYOT29 + $DYOT30 + $DYOT31;
                                                    ?>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><b>3</b></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: left;background-color: #acffaa"><b>On time</b></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE1'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE2'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE3'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE4'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE5'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE6'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE7'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE8'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE9'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE10'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE11'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE12'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE13'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE14'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE15'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE16'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE17'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE18'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE19'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE20'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE21'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE22'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE23'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE24'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE25'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE26'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE27'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE28'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE29'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE30'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seYARD_ONTIME['DATE31'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #ffbcee"><b><?=$SUMYARD_ONTIME;?></b></td>
                                                </tr>
                                                <!-- Sum Total -->
                                                <tr>
                                                    <?php 
                                                        $SUMYARDTOTAL = $SUMYARD_ADVANCE + $SUMYARD_DELAY + $SUMYARD_ONTIME;
                                                    ?>
                                                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                                    <td style="border:1px solid black;font-size: 16px;text-align: center;background-color: #bfbfbf"><b>รวม</b></td>
                                                    <td style="border:1px solid black;font-size: 16px;text-align: center;background-color: #bfbfbf"><b><?=$SUMYARDTOTAL;?></b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- //Punctuality Row2  -->
                                <h3><b>2. Arrival time supplier</b></h3>
                                <div class="scol-lg-2">
                                    <div class="table-scroll">
                                        <table width="100%" class="table table-striped table-hover dataTable no-footer dtr-inline" id="dataTables-example6" role="grid" aria-describedby="dataTables-example_info" >
                                            <thead style="border:1px solid black;">
                                                <tr>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>No.</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>Date</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>1</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>2</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>3</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>4</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>5</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>6</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>7</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>8</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>9</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>10</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>11</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>12</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>13</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>14</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>15</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>16</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>17</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>18</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>19</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>20</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>21</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>22</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>23</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>24</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>25</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>26</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>27</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>28</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>29</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>30</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>31</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>Total</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Delay -->
                                                <tr>
                                                    <!-- QueryData Delay-->
                                                    <?php
                                                        $sql_seSUPPLIER_DELAY = "SELECT
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '01/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE1',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '02/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE2',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '03/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE3',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '04/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE4',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '05/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE5',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '06/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE6',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '07/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE7',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '08/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE8',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '09/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE9',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '10/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE10',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '11/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE11',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '12/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE12',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '13/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE13',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '14/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE14',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '15/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE15',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '16/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE16',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '17/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE17',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '18/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE18',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '19/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE19',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '20/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE20',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '21/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE21',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '22/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE22',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '23/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE23',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '24/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE24',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '25/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE25',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '26/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE26',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '27/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE27',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '28/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE28',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '29/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE29',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '30/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE30',
                                                        (SELECT COUNT (*) AS SUPPLIER_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '31/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE31'";
                                                        $params_seSUPPLIER_DELAY  = array();
                                                        $query_seSUPPLIER_DELAY = sqlsrv_query($conn, $sql_seSUPPLIER_DELAY, $params_seSUPPLIER_DELAY);
                                                        $result_seSUPPLIER_DELAY = sqlsrv_fetch_array($query_seSUPPLIER_DELAY, SQLSRV_FETCH_ASSOC);
                                                        $DSD1=$result_seSUPPLIER_DELAY['DATE1'];$DSD2=$result_seSUPPLIER_DELAY['DATE2'];$DSD3=$result_seSUPPLIER_DELAY['DATE3'];$DSD4=$result_seSUPPLIER_DELAY['DATE4'];$DSD5=$result_seSUPPLIER_DELAY['DATE5'];$DSD6=$result_seSUPPLIER_DELAY['DATE6'];$DSD7=$result_seSUPPLIER_DELAY['DATE7'];$DSD8=$result_seSUPPLIER_DELAY['DATE8'];
                                                        $DSD9=$result_seSUPPLIER_DELAY['DATE9'];$DSD10=$result_seSUPPLIER_DELAY['DATE10'];$DSD11=$result_seSUPPLIER_DELAY['DATE11'];$DSD12=$result_seSUPPLIER_DELAY['DATE12'];$DSD13=$result_seSUPPLIER_DELAY['DATE13'];$DSD14=$result_seSUPPLIER_DELAY['DATE14'];$DSD15=$result_seSUPPLIER_DELAY['DATE15'];$DSD16=$result_seSUPPLIER_DELAY['DATE16'];
                                                        $DSD17=$result_seSUPPLIER_DELAY['DATE17'];$DSD18=$result_seSUPPLIER_DELAY['DATE18'];$DSD19=$result_seSUPPLIER_DELAY['DATE19'];$DSD20=$result_seSUPPLIER_DELAY['DATE20'];$DSD21=$result_seSUPPLIER_DELAY['DATE21'];$DSD22=$result_seSUPPLIER_DELAY['DATE22'];$DSD23=$result_seSUPPLIER_DELAY['DATE23'];$DSD24=$result_seSUPPLIER_DELAY['DATE24'];
                                                        $DSD25=$result_seSUPPLIER_DELAY['DATE25'];$DSD26=$result_seSUPPLIER_DELAY['DATE26'];$DSD27=$result_seSUPPLIER_DELAY['DATE27'];$DSD28=$result_seSUPPLIER_DELAY['DATE28'];$DSD29=$result_seSUPPLIER_DELAY['DATE29'];$DSD30=$result_seSUPPLIER_DELAY['DATE30'];$DSD31=$result_seSUPPLIER_DELAY['DATE31'];
                                                        $SUMSUPPLIER_DELAY = $DSD1 + $DSD2 + $DSD3 + $DSD4 + $DSD5 + $DSD6 + $DSD7 + $DSD8 + $DSD9 + $DSD10 + $DSD11 + $DSD12 + $DSD13 + $DSD14 + $DSD15 + $DSD16 + $DSD17 + $DSD18 + $DSD19 + $DSD20 + $DSD21 + $DSD22 + $DSD23 + $DSD24 + $DSD25 + $DSD26 + $DSD27 + $DSD28 + $DSD29 + $DSD30 + $DSD31;
                                                    ?>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><b>1</b></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: left;background-color: #c1e8ff"><b>Delay</b></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE1'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE2'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE3'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE4'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE5'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE6'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE7'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE8'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE9'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE10'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE11'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE12'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE13'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE14'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE15'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE16'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE17'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE18'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE19'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE20'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE21'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE22'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE23'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE24'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE25'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE26'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE27'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE28'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE29'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE30'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_seSUPPLIER_DELAY['DATE31'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #ffbcee"><b><?=$SUMSUPPLIER_DELAY;?></b></td>
                                                </tr>
                                                <!-- Advance -->
                                                <tr>
                                                    <!-- QueryData Advance-->
                                                    <?php
                                                        $sql_seSUPPLIER_ADVANCE = "SELECT
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '01/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE1',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '02/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE2',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '03/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE3',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '04/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE4',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '05/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE5',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '06/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE6',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '07/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE7',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '08/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE8',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '09/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE9',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '10/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE10',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '11/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE11',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '12/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE12',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '13/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE13',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '14/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE14',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '15/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE15',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '16/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE16',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '17/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE17',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '18/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE18',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '19/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE19',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '20/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE20',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '21/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE21',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '22/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE22',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '23/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE23',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '24/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE24',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '25/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE25',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '26/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE26',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '27/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE27',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '28/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE28',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '29/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE29',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '30/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE30',
                                                        (SELECT COUNT (*) AS SUPPLIER_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '31/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE31'";
                                                        $params_seSUPPLIER_ADVANCE  = array();
                                                        $query_seSUPPLIER_ADVANCE = sqlsrv_query($conn, $sql_seSUPPLIER_ADVANCE, $params_seSUPPLIER_ADVANCE);
                                                        $result_seSUPPLIER_ADVANCE = sqlsrv_fetch_array($query_seSUPPLIER_ADVANCE, SQLSRV_FETCH_ASSOC);
                                                        $DPA1=$result_seSUPPLIER_ADVANCE['DATE1'];$DPA2=$result_seSUPPLIER_ADVANCE['DATE2'];$DPA3=$result_seSUPPLIER_ADVANCE['DATE3'];$DPA4=$result_seSUPPLIER_ADVANCE['DATE4'];$DPA5=$result_seSUPPLIER_ADVANCE['DATE5'];$DPA6=$result_seSUPPLIER_ADVANCE['DATE6'];$DPA7=$result_seSUPPLIER_ADVANCE['DATE7'];$DPA8=$result_seSUPPLIER_ADVANCE['DATE8'];
                                                        $DPA9=$result_seSUPPLIER_ADVANCE['DATE9'];$DPA10=$result_seSUPPLIER_ADVANCE['DATE10'];$DPA11=$result_seSUPPLIER_ADVANCE['DATE11'];$DPA12=$result_seSUPPLIER_ADVANCE['DATE12'];$DPA13=$result_seSUPPLIER_ADVANCE['DATE13'];$DPA14=$result_seSUPPLIER_ADVANCE['DATE14'];$DPA15=$result_seSUPPLIER_ADVANCE['DATE15'];$DPA16=$result_seSUPPLIER_ADVANCE['DATE16'];
                                                        $DPA17=$result_seSUPPLIER_ADVANCE['DATE17'];$DPA18=$result_seSUPPLIER_ADVANCE['DATE18'];$DPA19=$result_seSUPPLIER_ADVANCE['DATE19'];$DPA20=$result_seSUPPLIER_ADVANCE['DATE20'];$DPA21=$result_seSUPPLIER_ADVANCE['DATE21'];$DPA22=$result_seSUPPLIER_ADVANCE['DATE22'];$DPA23=$result_seSUPPLIER_ADVANCE['DATE23'];$DPA24=$result_seSUPPLIER_ADVANCE['DATE24'];
                                                        $DPA25=$result_seSUPPLIER_ADVANCE['DATE25'];$DPA26=$result_seSUPPLIER_ADVANCE['DATE26'];$DPA27=$result_seSUPPLIER_ADVANCE['DATE27'];$DPA28=$result_seSUPPLIER_ADVANCE['DATE28'];$DPA29=$result_seSUPPLIER_ADVANCE['DATE29'];$DPA30=$result_seSUPPLIER_ADVANCE['DATE30'];$DPA31=$result_seSUPPLIER_ADVANCE['DATE31'];
                                                        $SUMSUPPLIER_ADVANCE = $DPA1 + $DPA2 + $DPA3 + $DPA4 + $DPA5 + $DPA6 + $DPA7 + $DPA8 + $DPA9 + $DPA10 + $DPA11 + $DPA12 + $DPA13 + $DPA14 + $DPA15 + $DPA16 + $DPA17 + $DPA18 + $DPA19 + $DPA20 + $DPA21 + $DPA22 + $DPA23 + $DPA24 + $DPA25 + $DPA26 + $DPA27 + $DPA28 + $DPA29 + $DPA30 + $DPA31;
                                                    ?>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><b>2</b></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: left;background-color: #fff0aa"><b>Advance</b></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE1'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE2'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE3'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE4'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE5'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE6'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE7'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE8'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE9'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE10'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE11'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE12'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE13'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE14'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE15'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE16'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE17'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE18'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE19'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE20'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE21'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE22'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE23'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE24'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE25'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE26'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE27'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE28'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE29'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE30'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_seSUPPLIER_ADVANCE['DATE31'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #ffbcee"><b><?=$SUMSUPPLIER_ADVANCE;?></b></td>
                                                </tr>
                                                <!-- On time -->
                                                <tr>
                                                    <!-- QueryData On time -->
                                                    <?php
                                                        $sql_seSUPPLIER_ONTIME = "SELECT
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '01/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE1',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '02/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE2',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '03/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE3',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '04/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE4',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '05/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE5',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '06/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE6',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '07/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE7',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '08/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE8',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '09/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE9',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '10/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE10',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '11/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE11',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '12/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE12',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '13/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE13',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '14/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE14',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '15/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE15',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '16/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE16',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '17/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE17',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '18/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE18',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '19/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE19',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '20/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE20',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '21/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE21',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '22/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE22',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '23/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE23',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '24/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE24',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '25/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE25',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '26/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE26',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '27/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE27',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '28/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE28',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '29/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE29',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '30/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE30',
                                                        (SELECT COUNT (*) AS SUPPLIER_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '31/".$monthnumeric."/".$years."'
                                                        AND HOP = 'SUPPLIER' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE31'";
                                                        $params_seSUPPLIER_ONTIME  = array();
                                                        $query_seSUPPLIER_ONTIME = sqlsrv_query($conn, $sql_seSUPPLIER_ONTIME, $params_seSUPPLIER_ONTIME);
                                                        $result_seSUPPLIER_ONTIME = sqlsrv_fetch_array($query_seSUPPLIER_ONTIME, SQLSRV_FETCH_ASSOC);
                                                        $DSOT1=$result_seSUPPLIER_ONTIME['DATE1'];$DSOT2=$result_seSUPPLIER_ONTIME['DATE2'];$DSOT3=$result_seSUPPLIER_ONTIME['DATE3'];$DSOT4=$result_seSUPPLIER_ONTIME['DATE4'];$DSOT5=$result_seSUPPLIER_ONTIME['DATE5'];$DSOT6=$result_seSUPPLIER_ONTIME['DATE6'];$DSOT7=$result_seSUPPLIER_ONTIME['DATE7'];$DSOT8=$result_seSUPPLIER_ONTIME['DATE8'];
                                                        $DSOT9=$result_seSUPPLIER_ONTIME['DATE9'];$DSOT10=$result_seSUPPLIER_ONTIME['DATE10'];$DSOT11=$result_seSUPPLIER_ONTIME['DATE11'];$DSOT12=$result_seSUPPLIER_ONTIME['DATE12'];$DSOT13=$result_seSUPPLIER_ONTIME['DATE13'];$DSOT14=$result_seSUPPLIER_ONTIME['DATE14'];$DSOT15=$result_seSUPPLIER_ONTIME['DATE15'];$DSOT16=$result_seSUPPLIER_ONTIME['DATE16'];
                                                        $DSOT17=$result_seSUPPLIER_ONTIME['DATE17'];$DSOT18=$result_seSUPPLIER_ONTIME['DATE18'];$DSOT19=$result_seSUPPLIER_ONTIME['DATE19'];$DSOT20=$result_seSUPPLIER_ONTIME['DATE20'];$DSOT21=$result_seSUPPLIER_ONTIME['DATE21'];$DSOT22=$result_seSUPPLIER_ONTIME['DATE22'];$DSOT23=$result_seSUPPLIER_ONTIME['DATE23'];$DSOT24=$result_seSUPPLIER_ONTIME['DATE24'];
                                                        $DSOT25=$result_seSUPPLIER_ONTIME['DATE25'];$DSOT26=$result_seSUPPLIER_ONTIME['DATE26'];$DSOT27=$result_seSUPPLIER_ONTIME['DATE27'];$DSOT28=$result_seSUPPLIER_ONTIME['DATE28'];$DSOT29=$result_seSUPPLIER_ONTIME['DATE29'];$DSOT30=$result_seSUPPLIER_ONTIME['DATE30'];$DSOT31=$result_seSUPPLIER_ONTIME['DATE31'];
                                                        $SUMSUPPLIER_ONTIME = $DSOT1 + $DSOT2 + $DSOT3 + $DSOT4 + $DSOT5 + $DSOT6 + $DSOT7 + $DSOT8 + $DSOT9 + $DSOT10 + $DSOT11 + $DSOT12 + $DSOT13 + $DSOT14 + $DSOT15 + $DSOT16 + $DSOT17 + $DSOT18 + $DSOT19 + $DSOT20 + $DSOT21 + $DSOT22 + $DSOT23 + $DSOT24 + $DSOT25 + $DSOT26 + $DSOT27 + $DSOT28 + $DSOT29 + $DSOT30 + $DSOT31;
                                                    ?>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><b>3</b></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: left;background-color: #acffaa"><b>On time</b></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE1'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE2'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE3'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE4'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE5'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE6'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE7'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE8'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE9'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE10'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE11'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE12'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE13'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE14'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE15'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE16'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE17'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE18'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE19'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE20'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE21'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE22'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE23'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE24'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE25'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE26'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE27'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE28'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE29'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE30'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_seSUPPLIER_ONTIME['DATE31'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #ffbcee"><b><?=$SUMSUPPLIER_ONTIME;?></b></td>
                                                </tr>
                                                <!-- Sum Total -->
                                                <tr>
                                                    <?php 
                                                        $SUMSUPPLIERTOTAL = $SUMSUPPLIER_ADVANCE + $SUMSUPPLIER_DELAY + $SUMSUPPLIER_ONTIME;
                                                    ?>
                                                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                                    <td style="border:1px solid black;font-size: 16px;text-align: center;background-color: #bfbfbf"><b>รวม</b></td>
                                                    <td style="border:1px solid black;font-size: 16px;text-align: center;background-color: #bfbfbf"><b><?=$SUMSUPPLIERTOTAL;?></b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- //Punctuality Row3  -->
                                <h3><b>3. Arrival time Plant</b></h3>
                                <div class="scol-lg-2">
                                    <div class="table-scroll">
                                        <table width="100%" class="table table-striped table-hover dataTable no-footer dtr-inline" id="dataTables-example6" role="grid" aria-describedby="dataTables-example_info" >
                                            <thead style="border:1px solid black;">
                                                <tr>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>No.</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>Date</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>1</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>2</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>3</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>4</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>5</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>6</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>7</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>8</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>9</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>10</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>11</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>12</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>13</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>14</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>15</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>16</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>17</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>18</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>19</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>20</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>21</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>22</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>23</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>24</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>25</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>26</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>27</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>28</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>29</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>30</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>31</b></th>
                                                    <th style="text-align: center;border:1px solid black;background-color: #bfbfbf"><b>Total</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Delay -->
                                                <tr>
                                                    <!-- QueryData Delay-->
                                                    <?php
                                                        $sql_sePLANT_DELAY = "SELECT
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '01/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE1',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '02/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE2',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '03/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE3',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '04/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE4',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '05/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE5',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '06/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE6',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '07/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE7',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '08/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE8',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '09/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE9',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '10/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE10',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '11/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE11',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '12/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE12',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '13/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE13',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '14/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE14',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '15/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE15',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '16/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE16',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '17/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE17',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '18/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE18',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '19/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE19',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '20/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE20',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '21/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE21',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '22/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE22',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '23/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE23',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '24/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE24',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '25/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE25',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '26/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE26',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '27/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE27',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '28/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE28',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '29/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE29',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '30/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE30',
                                                        (SELECT COUNT (*) AS PLANT_DELAY FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '31/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Delay%') AS 'DATE31'";
                                                        $params_sePLANT_DELAY  = array();
                                                        $query_sePLANT_DELAY = sqlsrv_query($conn, $sql_sePLANT_DELAY, $params_sePLANT_DELAY);
                                                        $result_sePLANT_DELAY = sqlsrv_fetch_array($query_sePLANT_DELAY, SQLSRV_FETCH_ASSOC);
                                                        $DPD1=$result_sePLANT_DELAY['DATE1'];$DPD2=$result_sePLANT_DELAY['DATE2'];$DPD3=$result_sePLANT_DELAY['DATE3'];$DPD4=$result_sePLANT_DELAY['DATE4'];$DPD5=$result_sePLANT_DELAY['DATE5'];$DPD6=$result_sePLANT_DELAY['DATE6'];$DPD7=$result_sePLANT_DELAY['DATE7'];$DPD8=$result_sePLANT_DELAY['DATE8'];
                                                        $DPD9=$result_sePLANT_DELAY['DATE9'];$DPD10=$result_sePLANT_DELAY['DATE10'];$DPD11=$result_sePLANT_DELAY['DATE11'];$DPD12=$result_sePLANT_DELAY['DATE12'];$DPD13=$result_sePLANT_DELAY['DATE13'];$DPD14=$result_sePLANT_DELAY['DATE14'];$DPD15=$result_sePLANT_DELAY['DATE15'];$DPD16=$result_sePLANT_DELAY['DATE16'];
                                                        $DPD17=$result_sePLANT_DELAY['DATE17'];$DPD18=$result_sePLANT_DELAY['DATE18'];$DPD19=$result_sePLANT_DELAY['DATE19'];$DPD20=$result_sePLANT_DELAY['DATE20'];$DPD21=$result_sePLANT_DELAY['DATE21'];$DPD22=$result_sePLANT_DELAY['DATE22'];$DPD23=$result_sePLANT_DELAY['DATE23'];$DPD24=$result_sePLANT_DELAY['DATE24'];
                                                        $DPD25=$result_sePLANT_DELAY['DATE25'];$DPD26=$result_sePLANT_DELAY['DATE26'];$DPD27=$result_sePLANT_DELAY['DATE27'];$DPD28=$result_sePLANT_DELAY['DATE28'];$DPD29=$result_sePLANT_DELAY['DATE29'];$DPD30=$result_sePLANT_DELAY['DATE30'];$DPD31=$result_sePLANT_DELAY['DATE31'];
                                                        $SUMPLANT_DELAY = $DPD1 + $DPD2 + $DPD3 + $DPD4 + $DPD5 + $DPD6 + $DPD7 + $DPD8 + $DPD9 + $DPD10 + $DPD11 + $DPD12 + $DPD13 + $DPD14 + $DPD15 + $DPD16 + $DPD17 + $DPD18 + $DPD19 + $DPD20 + $DPD21 + $DPD22 + $DPD23 + $DPD24 + $DPD25 + $DPD26 + $DPD27 + $DPD28 + $DPD29 + $DPD30 + $DPD31;
                                                    ?>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><b>1</b></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: left;background-color: #c1e8ff"><b>Delay</b></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE1'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE2'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE3'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE4'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE5'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE6'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE7'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE8'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE9'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE10'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE11'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE12'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE13'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE14'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE15'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE16'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE17'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE18'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE19'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE20'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE21'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE22'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE23'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE24'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE25'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE26'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE27'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE28'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE29'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE30'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #c1e8ff"><?=$result_sePLANT_DELAY['DATE31'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #ffbcee"><b><?=$SUMPLANT_DELAY;?></b></td>
                                                </tr>
                                                <!-- Advance -->
                                                <tr>
                                                    <!-- QueryData Advance-->
                                                    <?php
                                                        $sql_sePLANT_ADVANCE = "SELECT
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '01/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE1',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '02/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE2',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '03/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE3',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '04/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE4',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '05/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE5',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '06/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE6',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '07/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE7',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '08/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE8',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '09/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE9',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '10/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE10',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '11/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE11',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '12/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE12',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '13/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE13',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '14/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE14',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '15/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE15',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '16/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE16',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '17/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE17',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '18/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE18',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '19/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE19',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '20/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE20',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '21/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE21',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '22/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE22',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '23/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE23',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '24/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE24',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '25/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE25',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '26/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE26',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '27/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE27',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '28/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE28',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '29/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE29',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '30/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE30',
                                                        (SELECT COUNT (*) AS PLANT_ADVANCE FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '31/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%Advance%') AS 'DATE31'";
                                                        $params_sePLANT_ADVANCE  = array();
                                                        $query_sePLANT_ADVANCE = sqlsrv_query($conn, $sql_sePLANT_ADVANCE, $params_sePLANT_ADVANCE);
                                                        $result_sePLANT_ADVANCE = sqlsrv_fetch_array($query_sePLANT_ADVANCE, SQLSRV_FETCH_ASSOC);
                                                        $DPA1=$result_sePLANT_ADVANCE['DATE1'];$DPA2=$result_sePLANT_ADVANCE['DATE2'];$DPA3=$result_sePLANT_ADVANCE['DATE3'];$DPA4=$result_sePLANT_ADVANCE['DATE4'];$DPA5=$result_sePLANT_ADVANCE['DATE5'];$DPA6=$result_sePLANT_ADVANCE['DATE6'];$DPA7=$result_sePLANT_ADVANCE['DATE7'];$DPA8=$result_sePLANT_ADVANCE['DATE8'];
                                                        $DPA9=$result_sePLANT_ADVANCE['DATE9'];$DPA10=$result_sePLANT_ADVANCE['DATE10'];$DPA11=$result_sePLANT_ADVANCE['DATE11'];$DPA12=$result_sePLANT_ADVANCE['DATE12'];$DPA13=$result_sePLANT_ADVANCE['DATE13'];$DPA14=$result_sePLANT_ADVANCE['DATE14'];$DPA15=$result_sePLANT_ADVANCE['DATE15'];$DPA16=$result_sePLANT_ADVANCE['DATE16'];
                                                        $DPA17=$result_sePLANT_ADVANCE['DATE17'];$DPA18=$result_sePLANT_ADVANCE['DATE18'];$DPA19=$result_sePLANT_ADVANCE['DATE19'];$DPA20=$result_sePLANT_ADVANCE['DATE20'];$DPA21=$result_sePLANT_ADVANCE['DATE21'];$DPA22=$result_sePLANT_ADVANCE['DATE22'];$DPA23=$result_sePLANT_ADVANCE['DATE23'];$DPA24=$result_sePLANT_ADVANCE['DATE24'];
                                                        $DPA25=$result_sePLANT_ADVANCE['DATE25'];$DPA26=$result_sePLANT_ADVANCE['DATE26'];$DPA27=$result_sePLANT_ADVANCE['DATE27'];$DPA28=$result_sePLANT_ADVANCE['DATE28'];$DPA29=$result_sePLANT_ADVANCE['DATE29'];$DPA30=$result_sePLANT_ADVANCE['DATE30'];$DPA31=$result_sePLANT_ADVANCE['DATE31'];
                                                        $SUMPLANT_ADVANCE = $DPA1 + $DPA2 + $DPA3 + $DPA4 + $DPA5 + $DPA6 + $DPA7 + $DPA8 + $DPA9 + $DPA10 + $DPA11 + $DPA12 + $DPA13 + $DPA14 + $DPA15 + $DPA16 + $DPA17 + $DPA18 + $DPA19 + $DPA20 + $DPA21 + $DPA22 + $DPA23 + $DPA24 + $DPA25 + $DPA26 + $DPA27 + $DPA28 + $DPA29 + $DPA30 + $DPA31;
                                                    ?>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><b>2</b></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: left;background-color: #fff0aa"><b>Advance</b></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE1'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE2'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE3'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE4'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE5'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE6'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE7'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE8'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE9'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE10'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE11'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE12'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE13'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE14'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE15'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE16'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE17'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE18'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE19'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE20'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE21'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE22'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE23'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE24'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE25'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE26'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE27'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE28'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE29'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE30'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #fff0aa"><?=$result_sePLANT_ADVANCE['DATE31'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #ffbcee"><b><?=$SUMPLANT_ADVANCE;?></b></td>
                                                </tr>
                                                <!-- On time -->
                                                <tr>
                                                    <!-- QueryData On time -->
                                                    <?php
                                                        $sql_sePLANT_ONTIME = "SELECT
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '01/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE1',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '02/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE2',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '03/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE3',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '04/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE4',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '05/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE5',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '06/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE6',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '07/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE7',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '08/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE8',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '09/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE9',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '10/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE10',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '11/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE11',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '12/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE12',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '13/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE13',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '14/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE14',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '15/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE15',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '16/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE16',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '17/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE17',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '18/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE18',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '19/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE19',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '20/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE20',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '21/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE21',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '22/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE22',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '23/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE23',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '24/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE24',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '25/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE25',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '26/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE26',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '27/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE27',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '28/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE28',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '29/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE29',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '30/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE30',
                                                        (SELECT COUNT (*) AS PLANT_ONTIME FROM vwDIGITALTENKO_FEEDBACKDRIVER WHERE CON_ROUTE_DATE = '31/".$monthnumeric."/".$years."'
                                                        AND HOP = 'PLANT' AND PUNC_OF_ARRIVAL LIKE '%On Time%') AS 'DATE31'";
                                                        $params_sePLANT_ONTIME  = array();
                                                        $query_sePLANT_ONTIME = sqlsrv_query($conn, $sql_sePLANT_ONTIME, $params_sePLANT_ONTIME);
                                                        $result_sePLANT_ONTIME = sqlsrv_fetch_array($query_sePLANT_ONTIME, SQLSRV_FETCH_ASSOC);
                                                        $DPOT1=$result_sePLANT_ONTIME['DATE1'];$DPOT2=$result_sePLANT_ONTIME['DATE2'];$DPOT3=$result_sePLANT_ONTIME['DATE3'];$DPOT4=$result_sePLANT_ONTIME['DATE4'];$DPOT5=$result_sePLANT_ONTIME['DATE5'];$DPOT6=$result_sePLANT_ONTIME['DATE6'];$DPOT7=$result_sePLANT_ONTIME['DATE7'];$DPOT8=$result_sePLANT_ONTIME['DATE8'];
                                                        $DPOT9=$result_sePLANT_ONTIME['DATE9'];$DPOT10=$result_sePLANT_ONTIME['DATE10'];$DPOT11=$result_sePLANT_ONTIME['DATE11'];$DPOT12=$result_sePLANT_ONTIME['DATE12'];$DPOT13=$result_sePLANT_ONTIME['DATE13'];$DPOT14=$result_sePLANT_ONTIME['DATE14'];$DPOT15=$result_sePLANT_ONTIME['DATE15'];$DPOT16=$result_sePLANT_ONTIME['DATE16'];
                                                        $DPOT17=$result_sePLANT_ONTIME['DATE17'];$DPOT18=$result_sePLANT_ONTIME['DATE18'];$DPOT19=$result_sePLANT_ONTIME['DATE19'];$DPOT20=$result_sePLANT_ONTIME['DATE20'];$DPOT21=$result_sePLANT_ONTIME['DATE21'];$DPOT22=$result_sePLANT_ONTIME['DATE22'];$DPOT23=$result_sePLANT_ONTIME['DATE23'];$DPOT24=$result_sePLANT_ONTIME['DATE24'];
                                                        $DPOT25=$result_sePLANT_ONTIME['DATE25'];$DPOT26=$result_sePLANT_ONTIME['DATE26'];$DPOT27=$result_sePLANT_ONTIME['DATE27'];$DPOT28=$result_sePLANT_ONTIME['DATE28'];$DPOT29=$result_sePLANT_ONTIME['DATE29'];$DPOT30=$result_sePLANT_ONTIME['DATE30'];$DPOT31=$result_sePLANT_ONTIME['DATE31'];
                                                        $SUMPLANT_ONTIME = $DPOT1 + $DPOT2 + $DPOT3 + $DPOT4 + $DPOT5 + $DPOT6 + $DPOT7 + $DPOT8 + $DPOT9 + $DPOT10 + $DPOT11 + $DPOT12 + $DPOT13 + $DPOT14 + $DPOT15 + $DPOT16 + $DPOT17 + $DPOT18 + $DPOT19 + $DPOT20 + $DPOT21 + $DPOT22 + $DPOT23 + $DPOT24 + $DPOT25 + $DPOT26 + $DPOT27 + $DPOT28 + $DPOT29 + $DPOT30 + $DPOT31;
                                                    ?>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><b>3</b></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: left;background-color: #acffaa"><b>On time</b></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE1'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE2'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE3'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE4'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE5'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE6'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE7'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE8'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE9'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE10'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE11'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE12'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE13'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE14'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE15'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE16'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE17'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE18'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE19'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE20'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE21'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE22'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE23'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE24'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE25'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE26'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE27'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE28'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE29'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE30'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #acffaa"><?=$result_sePLANT_ONTIME['DATE31'];?></td>
                                                    <td style="border:1px solid black;font-size: 14px;text-align: center;background-color: #ffbcee"><b><?=$SUMPLANT_ONTIME;?></b></td>
                                                </tr>
                                                <!-- Sum Total -->
                                                <tr>
                                                    <?php 
                                                        $SUMPLANTTOTAL = $SUMPLANT_ADVANCE + $SUMPLANT_DELAY + $SUMPLANT_ONTIME;
                                                    ?>
                                                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                                    <td style="border:1px solid black;font-size: 16px;text-align: center;background-color: #bfbfbf"><b>รวม</b></td>
                                                    <td style="border:1px solid black;font-size: 16px;text-align: center;background-color: #bfbfbf"><b><?=$SUMPLANTTOTAL;?></b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <!-- /.panel -->
            </div>
        </div>
        <!-- END ROW2 OK Driver -->        

        <?php
        }
        ?>

        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>
        <script src="../dist/js/bootstrap-select.js"></script>

        <?php
        
        $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeeehr2', " ");
        ?>

        <script type="text/javascript">
            
            $(document).ready(function () {
                $('#dataTables-example6').DataTable({
                    responsive: true,
                });
            });

        var txt_copydiagramemployeename1 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename1").autocomplete({
            source: [txt_copydiagramemployeename1]
        });

        </script>
        <!-- <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>
        
        <script src="../js/bootstrap-datepicker.min.js"></script>
        <script src="../js/bootstrap-datepicker.th.min.js"></script> -->

        