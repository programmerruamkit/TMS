<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงาน Tenko_TruckredinessKPI.xls";
} else {
    $strExcelFileName = "รายงาน Tenko_TruckredinessKPI" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
}


  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: inline; filename=\"$strExcelFileName\"");

$monthnumeric = $_GET['monthnumeric'];
$month = $_GET['month'];
$years = $_GET['years'];

?>
<html>
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
      <table border="1" width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
        <thead>
        <tr>
            <th colspan ="33" bgcolor="#CCCCCC" style="text-align: left;border:1px solid #000;padding:4px;" >Truck readiness check</th>
        </tr>
          <tr>
            <th rowspan="2" colspan="1" style="text-align: center">Topic</th>
            <th colspan="31" style="text-align: center">Daily</th>
            <th rowspan="2"  style="text-align: center">Accumulate</th>
          </tr>
          <tr>
            <td colspan="1" style="text-align: center"><b>1</b></td>
            <td colspan="1" style="text-align: center"><b>2</b></td>
            <td colspan="1" style="text-align: center"><b>3</b></td>
            <td colspan="1" style="text-align: center"><b>4</b></td>
            <td colspan="1" style="text-align: center"><b>5</b></td>
            <td colspan="1" style="text-align: center"><b>6</b></td>
            <td colspan="1" style="text-align: center"><b>7</b></td>
            <td colspan="1" style="text-align: center"><b>8</b></td>
            <td colspan="1" style="text-align: center"><b>9</b></td>
            <td colspan="1" style="text-align: center"><b>10</b></td>
            <td colspan="1" style="text-align: center"><b>11</b></td>
            <td colspan="1" style="text-align: center"><b>12</b></td>
            <td colspan="1" style="text-align: center"><b>13</b></td>
            <td colspan="1" style="text-align: center"><b>14</b></td>
            <td colspan="1" style="text-align: center"><b>15</b></td>
            <td colspan="1" style="text-align: center"><b>16</b></td>
            <td colspan="1" style="text-align: center"><b>17</b></td>
            <td colspan="1" style="text-align: center"><b>18</b></td>
            <td colspan="1" style="text-align: center"><b>19</b></td>
            <td colspan="1" style="text-align: center"><b>20</b></td>
            <td colspan="1" style="text-align: center"><b>21</b></td>
            <td colspan="1" style="text-align: center"><b>22</b></td>
            <td colspan="1" style="text-align: center"><b>23</b></td>
            <td colspan="1" style="text-align: center"><b>24</b></td>
            <td colspan="1" style="text-align: center"><b>25</b></td>
            <td colspan="1" style="text-align: center"><b>26</b></td>
            <td colspan="1" style="text-align: center"><b>27</b></td>
            <td colspan="1" style="text-align: center"><b>28</b></td>
            <td colspan="1" style="text-align: center"><b>29</b></td>
            <td colspan="1" style="text-align: center"><b>30</b></td>
            <td colspan="1" style="text-align: center"><b>31</b></td>


          </tr>
        </thead>
        <tbody>
          <!-- QueryData -->
          <?php
          // $sql_sedriveratt1 = "SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
          // WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
          // AND REMARK ='TotalTruck' 
          // AND REMARK_MONTH ='".$month."' 
          // AND REMARK_YEARS ='".$years."'";
          // $params_sedriveratt1 = array();
          // $query_sedriveratt1 = sqlsrv_query($conn, $sql_sedriveratt1, $params_sedriveratt1);
          // $result_sedriveratt1 = sqlsrv_fetch_array($query_sedriveratt1, SQLSRV_FETCH_ASSOC);

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
          $params_setotaltruck = array();
          $query_setotaltruck = sqlsrv_query($conn, $sql_setotaltruck, $params_setotaltruck);
          $result_setotaltruck = sqlsrv_fetch_array($query_setotaltruck, SQLSRV_FETCH_ASSOC);

          $sql_setotaltruckTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'DriverAttTotalValue'  
          FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
          WHERE REMARK ='TotalTruck' 
          AND REMARK_MONTH ='".$month."' 
          AND REMARK_YEARS ='".$years."'";
          $params_setotaltruckTotal = array();
          $query_setotaltruckTotal  = sqlsrv_query($conn, $sql_setotaltruckTotal, $params_setotaltruckTotal);
          $result_setotaltruckTotal = sqlsrv_fetch_array($query_setotaltruckTotal, SQLSRV_FETCH_ASSOC);

          ?>
            <tr>
              <td style="text-align: center">Total Truck</td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruck['TotalTruck31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaltruckTotal['DriverAttTotalValue']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
              $sql_sesparetruck = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck12',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck13',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck14',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck15',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck16',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck17',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck18',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck19',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck20',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck21',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck22',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck23',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck24',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck25',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck26',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck27',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck28',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck29',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck30',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareTruck31'";
              $params_sesparetruck  = array();
              $query_sesparetruck = sqlsrv_query($conn, $sql_sesparetruck, $params_sesparetruck);
              $result_sesparetruck = sqlsrv_fetch_array($query_sesparetruck, SQLSRV_FETCH_ASSOC);

              $sql_sesparetruckTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'SpareTruckTotalValue'  
              FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE REMARK ='SpareTruck' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_sesparetruckTotal = array();
              $query_sesparetruckTotal  = sqlsrv_query($conn, $sql_sesparetruckTotal, $params_sesparetruckTotal);
              $result_sesparetruckTotal = sqlsrv_fetch_array($query_sesparetruckTotal, SQLSRV_FETCH_ASSOC);

              ?>
              <td style="text-align: center">Spare Truck</td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruck['SpareTruck31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sesparetruckTotal['SpareTruckTotalValue']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
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

              $sql_serequirementTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'RequirementTotalValue'  
              FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE REMARK ='Requirement' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_serequirementTotal = array();
              $query_serequirementTotal  = sqlsrv_query($conn, $sql_serequirementTotal, $params_serequirementTotal);
              $result_serequirementTotal = sqlsrv_fetch_array($query_serequirementTotal, SQLSRV_FETCH_ASSOC);


              ?>  
              <td style="text-align: center">Requirement</td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRequirement['Requirement31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_serequirementTotal['RequirementTotalValue']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
              $sql_setruckatt = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt12',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt13',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt14',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt15',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt16',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt17',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt18',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt19',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt20',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt21',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt22',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt23',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt24',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt25',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt26',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt27',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt28',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt29',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt30',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckAtt31'";
              $params_setruckatt  = array();
              $query_setruckatt = sqlsrv_query($conn, $sql_setruckatt, $params_setruckatt);
              $result_setruckatt = sqlsrv_fetch_array($query_setruckatt, SQLSRV_FETCH_ASSOC);


              $sql_setruckattTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TruckAttTotalValue'  
              FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE REMARK ='TruckAtt' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_setruckattTotal = array();
              $query_setruckattTotal  = sqlsrv_query($conn, $sql_setruckattTotal, $params_setruckattTotal);
              $result_setruckattTotal = sqlsrv_fetch_array($query_setruckattTotal, SQLSRV_FETCH_ASSOC);

           

              ?>
              <td style="text-align: center">Truck attend</td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckatt['TruckAtt31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattTotal['TruckAttTotalValue']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
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

              $sql_setruckattperTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TruckAttperTotalValue'  
              FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE REMARK ='TruckAttper' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_setruckattperTotal = array();
              $query_setruckattperTotal  = sqlsrv_query($conn, $sql_setruckattperTotal, $params_setruckattperTotal);
              $result_setruckattperTotal = sqlsrv_fetch_array($query_setruckattperTotal, SQLSRV_FETCH_ASSOC);

              ?>
              <td style="text-align: center">Truck attendance %</td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattper['TruckAttper31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setruckattperTotal['TruckAttperTotalValue']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
              $sql_seTruckOK = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
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
              $params_seTruckOK  = array();
              $query_seTruckOK = sqlsrv_query($conn, $sql_seTruckOK, $params_seTruckOK);
              $result_seTruckOK = sqlsrv_fetch_array($query_seTruckOK, SQLSRV_FETCH_ASSOC);

              $sql_seTruckOKTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TruckOKTotalValue'  
              FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE REMARK ='TruckOK' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seTruckOKTotal = array();
              $query_seTruckOKTotal  = sqlsrv_query($conn, $sql_seTruckOKTotal, $params_seTruckOKTotal);
              $result_seTruckOKTotal = sqlsrv_fetch_array($query_seTruckOKTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center">Truck OK</td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOK['TruckOK31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckOKTotal['TruckOKTotalValue']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
              $sql_seTruckNG = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG12',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG13',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG14',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG15',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG16',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG17',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG18',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG19',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG20',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG21',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG22',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG23',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG24',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG25',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG26',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG27',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG28',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG29',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG30',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TruckNG31'";
              $params_seTruckNG = array();
              $query_seTruckNG = sqlsrv_query($conn, $sql_seTruckNG, $params_seTruckNG);
              $result_seTruckNG = sqlsrv_fetch_array($query_seTruckNG, SQLSRV_FETCH_ASSOC);

              $sql_seTruckNGTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'Truck_NGTotalValue'  
              FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE REMARK ='Truck_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seTruckNGTotal = array();
              $query_seTruckNGTotal  = sqlsrv_query($conn, $sql_seTruckNGTotal, $params_seTruckNGTotal);
              $result_seTruckNGTotal = sqlsrv_fetch_array($query_seTruckNGTotal, SQLSRV_FETCH_ASSOC);

              
              ?>
              <td style="text-align: center;background-color: #F8D18F;">NG</td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNG['TruckNG31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTruckNGTotal['Truck_NGTotalValue']?></td>
            </tr>
            <tr>
              <td  colspan="1"  style="text-align: center;font-size: 20px">&#129095;</td>
              <td  colspan="32" style="text-align: left;"></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
              $sql_seWheelandTcon = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon12',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon13',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon14',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon15',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon16',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon17',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon18',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon19',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon20',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon21',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon22',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon23',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon24',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon25',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon26',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon27',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon28',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon29',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon30',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WheelandTcon31'";
              $params_seWheelandTcon = array();
              $query_seWheelandTcon = sqlsrv_query($conn, $sql_seWheelandTcon, $params_seWheelandTcon);
              $result_seWheelandTcon = sqlsrv_fetch_array($query_seWheelandTcon, SQLSRV_FETCH_ASSOC);

              $sql_seWheelandTconTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'WheelandTconTotalValue'  
              FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE REMARK ='WheelandTcon' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seWheelandTconTotal = array();
              $query_seWheelandTconTotal  = sqlsrv_query($conn, $sql_seWheelandTconTotal, $params_seWheelandTconTotal);
              $result_seWheelandTconTotal = sqlsrv_fetch_array($query_seWheelandTconTotal, SQLSRV_FETCH_ASSOC);

              ?>
              <td style="text-align: center;background-color: #F8D18F;">Wheel & tire condition</td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTcon['WheelandTcon31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWheelandTconTotal['WheelandTconTotalValue']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
              $sql_seSpareWheel = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel12',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel13',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel14',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel15',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel16',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel17',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel18',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel19',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel20',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel21',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel22',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel23',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel24',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel25',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel26',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel27',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel28',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel29',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel30',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SpareWheel31'";
              $params_seSpareWheel = array();
              $query_seSpareWheel = sqlsrv_query($conn, $sql_seSpareWheel, $params_seSpareWheel);
              $result_seSpareWheel = sqlsrv_fetch_array($query_seSpareWheel, SQLSRV_FETCH_ASSOC);

              $sql_seSpareWheelTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'SpareWheelTotalValue'  
              FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE REMARK ='SpareWheel' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seSpareWheelTotal = array();
              $query_seSpareWheelTotal  = sqlsrv_query($conn, $sql_seSpareWheelTotal, $params_seSpareWheelTotal);
              $result_seSpareWheelTotal = sqlsrv_fetch_array($query_seSpareWheelTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center;background-color: #F8D18F;">Spare wheel</td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheel['SpareWheel31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSpareWheelTotal['SpareWheelTotalValue']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
              $sql_seWarningLight = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight12',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight13',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight14',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight15',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight16',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight17',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight18',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight19',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight20',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight21',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight22',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight23',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight24',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight25',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight26',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight27',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight28',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight29',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight30',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WarningLight31'";
              $params_seWarningLight = array();
              $query_seWarningLight = sqlsrv_query($conn, $sql_seWarningLight, $params_seWarningLight);
              $result_seWarningLight = sqlsrv_fetch_array($query_seWarningLight, SQLSRV_FETCH_ASSOC);

              $sql_seWarningLightTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'WarningLightTotalValue'  
              FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE REMARK ='WarningLight' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seWarningLightTotal = array();
              $query_seWarningLightTotal  = sqlsrv_query($conn, $sql_seWarningLightTotal, $params_seWarningLightTotal);
              $result_seWarningLightTotal = sqlsrv_fetch_array($query_seWarningLightTotal, SQLSRV_FETCH_ASSOC);



              ?>
              <td style="text-align: center;background-color: #F8D18F;">Warning light at dashboard</td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLight['WarningLight31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWarningLightTotal['WarningLightTotalValue']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
              $sql_seDrainWater = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater12',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater13',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater14',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater15',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater16',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater17',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater18',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater19',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater20',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater21',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater22',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater23',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater24',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater25',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater26',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater27',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater28',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater29',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater30',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'DrainWater31'";
              $params_seDrainWater = array();
              $query_seDrainWater = sqlsrv_query($conn, $sql_seDrainWater, $params_seDrainWater);
              $result_seDrainWater = sqlsrv_fetch_array($query_seDrainWater, SQLSRV_FETCH_ASSOC);

              $sql_seDrainWaterTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'DrainWaterTotalValue'  
              FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE REMARK ='DrainWater' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seDrainWaterTotal = array();
              $query_seDrainWaterTotal  = sqlsrv_query($conn, $sql_seDrainWaterTotal, $params_seDrainWaterTotal);
              $result_seDrainWaterTotal = sqlsrv_fetch_array($query_seDrainWaterTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center;background-color: #F8D18F;">Drain water from air tank</td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWater['DrainWater31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDrainWaterTotal['DrainWaterTotalValue']?></td>
            </tr>
           <!-- QueryData -->
           <?php
              $sql_seSafetyEqup = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup12',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup13',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup14',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup15',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup16',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup17',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup18',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup19',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup20',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup21',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup22',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup23',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup24',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup25',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup26',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup27',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup28',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup29',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup30',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'SafetyEqup31'";
              $params_seSafetyEqup = array();
              $query_seSafetyEqup = sqlsrv_query($conn, $sql_seSafetyEqup, $params_seSafetyEqup);
              $result_seSafetyEqup = sqlsrv_fetch_array($query_seSafetyEqup, SQLSRV_FETCH_ASSOC);

              $sql_seSafetyEqupTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'SafetyEqupTotalValue'  
              FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE REMARK ='SafetyEqup' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seSafetyEqupTotal = array();
              $query_seSafetyEqupTotal  = sqlsrv_query($conn, $sql_seSafetyEqupTotal, $params_seSafetyEqupTotal);
              $result_seSafetyEqupTotal = sqlsrv_fetch_array($query_seSafetyEqupTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center;background-color: #F8D18F;">Safety equipment</td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqup['SafetyEqup31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seSafetyEqupTotal['SafetyEqupTotalValue']?></td>
            </tr>
            <!-- QueryData -->
            <?php
              $sql_seEngineNoise = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise12',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise13',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise14',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise15',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise16',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise17',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise18',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise19',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise20',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise21',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise22',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise23',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise24',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise25',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise26',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise27',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise28',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise29',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise30',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'EngineNoise31'";
              $params_seEngineNoise = array();
              $query_seEngineNoise = sqlsrv_query($conn, $sql_seEngineNoise, $params_seEngineNoise);
              $result_seEngineNoise = sqlsrv_fetch_array($query_seEngineNoise, SQLSRV_FETCH_ASSOC);

              $sql_seEngineNoiseTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'EngineNoiseTotalValue'  
              FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE REMARK ='EngineNoise' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seEngineNoiseTotal = array();
              $query_seEngineNoiseTotal  = sqlsrv_query($conn, $sql_seEngineNoiseTotal, $params_seEngineNoiseTotal);
              $result_seEngineNoiseTotal = sqlsrv_fetch_array($query_seEngineNoiseTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center;background-color: #F8D18F;">Engine noise</td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoise['EngineNoise31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seEngineNoiseTotal['EngineNoiseTotalValue']?></td>
            </tr>
            <!-- QueryData -->
            <?php
              $sql_seBrakeSystem = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem12',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem13',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem14',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem15',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem16',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem17',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem18',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem19',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem20',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem21',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem22',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem23',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem24',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem25',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem26',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem27',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem28',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem29',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem30',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'BrakeSystem31'";
              $params_seBrakeSystem = array();
              $query_seBrakeSystem = sqlsrv_query($conn, $sql_seBrakeSystem, $params_seBrakeSystem);
              $result_seBrakeSystem = sqlsrv_fetch_array($query_seBrakeSystem, SQLSRV_FETCH_ASSOC);

              $sql_seBrakeSystemTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'BrakeSystemTotalValue'  
              FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE REMARK ='BrakeSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seBrakeSystemTotal = array();
              $query_seBrakeSystemTotal  = sqlsrv_query($conn, $sql_seBrakeSystemTotal, $params_seBrakeSystemTotal);
              $result_seBrakeSystemTotal = sqlsrv_fetch_array($query_seBrakeSystemTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center;background-color: #F8D18F;">Brake system (handbrake and brake pedal)</td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystem['BrakeSystem31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBrakeSystemTotal['BrakeSystemTotalValue']?></td>
            </tr>
            <!-- QueryData -->
            <?php
              $sql_seLightingSystem = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem12',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem13',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem14',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem15',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem16',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem17',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem18',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem19',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem20',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem21',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem22',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem23',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem24',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem25',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem26',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem27',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem28',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem29',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem30',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'LightingSystem31'";
              $params_seLightingSystem = array();
              $query_seLightingSystem = sqlsrv_query($conn, $sql_seLightingSystem, $params_seLightingSystem);
              $result_seLightingSystem = sqlsrv_fetch_array($query_seLightingSystem, SQLSRV_FETCH_ASSOC);

              $sql_seLightingSystemTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'LightingSystemTotalValue'  
              FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE REMARK ='LightingSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seLightingSystemTotal = array();
              $query_seLightingSystemTotal  = sqlsrv_query($conn, $sql_seLightingSystemTotal, $params_seLightingSystemTotal);
              $result_seLightingSystemTotal = sqlsrv_fetch_array($query_seLightingSystemTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center;background-color: #F8D18F;">Lighting system</td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystem['LightingSystem31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seLightingSystemTotal['LightingSystemTotalValue']?></td>
            </tr>
            <!-- QueryData -->
            <?php
              $sql_seWiperSystem = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem12',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem13',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem14',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem15',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem16',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem17',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem18',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem19',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem20',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem21',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem22',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem23',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem24',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem25',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem26',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem27',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem28',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem29',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem30',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'WiperSystem31'";
              $params_seWiperSystem = array();
              $query_seWiperSystem = sqlsrv_query($conn, $sql_seWiperSystem, $params_seWiperSystem);
              $result_seWiperSystem = sqlsrv_fetch_array($query_seWiperSystem, SQLSRV_FETCH_ASSOC);

              $sql_seWiperSystemTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'WiperSystemTotalValue'  
              FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE REMARK ='WiperSystem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seWiperSystemTotal = array();
              $query_seWiperSystemTotal  = sqlsrv_query($conn, $sql_seWiperSystemTotal, $params_seWiperSystemTotal);
              $result_seWiperSystemTotal = sqlsrv_fetch_array($query_seWiperSystemTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center;background-color: #F8D18F;">Wiper system</td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystem['WiperSystem31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seWiperSystemTotal['WiperSystemTotalValue']?></td>
            </tr>
            <!-- QueryData -->
            <?php
              $sql_seAirHose = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose12',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose13',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose14',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose15',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose16',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose17',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose18',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose19',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose20',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose21',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose22',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose23',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose24',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose25',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose26',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose27',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose28',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose29',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose30',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AirHose31'";
              $params_seAirHose = array();
              $query_seAirHose = sqlsrv_query($conn, $sql_seAirHose, $params_seAirHose);
              $result_seAirHose = sqlsrv_fetch_array($query_seAirHose, SQLSRV_FETCH_ASSOC);

              $sql_seAirHoseTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'AirHoseTotalValue'  
              FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE REMARK ='AirHose' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seAirHoseTotal = array();
              $query_seAirHoseTotal  = sqlsrv_query($conn, $sql_seAirHoseTotal, $params_seAirHoseTotal);
              $result_seAirHoseTotal = sqlsrv_fetch_array($query_seAirHoseTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center;background-color: #F8D18F;">Air hose for semi-trailer</td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHose['AirHose31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAirHoseTotal['AirHoseTotalValue']?></td>
            </tr>
            <!-- QueryData -->
            <?php
              $sql_seCamera = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera12',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera13',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera14',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera15',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera16',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera17',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera18',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera19',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera20',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera21',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera22',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera23',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera24',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera25',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera26',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera27',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera28',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera29',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera30',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Camera31'";
              $params_seCamera = array();
              $query_seCamera = sqlsrv_query($conn, $sql_seCamera, $params_seCamera);
              $result_seCamera = sqlsrv_fetch_array($query_seCamera, SQLSRV_FETCH_ASSOC);

              $sql_seCameraTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'CameraTotalValue'  
              FROM [dbo].[DIGITALTENKO_TRUCKREADINESS]
              WHERE REMARK ='Camera' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seCameraTotal = array();
              $query_seCameraTotal  = sqlsrv_query($conn, $sql_seCameraTotal, $params_seCameraTotal);
              $result_seCameraTotal = sqlsrv_fetch_array($query_seCameraTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center;background-color: #F8D18F;">Camera</td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCamera['Camera31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seCameraTotal['CameraTotalValue']?></td>
            </tr>
        </tbody>
      </table>
    </body>
    
</html>
