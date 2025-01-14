<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงาน Tenko Detail.xls";
} else {
    $strExcelFileName = "รายงาน Tenko Detail" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
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
            <th colspan ="33" bgcolor="#CCCCCC" style="text-align: left;border:1px solid #000;padding:4px;" >Tenko process checking result</th>
        </tr>
          <tr>
            <th rowspan="2"  style="text-align: center">Topic</th>
            <th colspan="31" style="text-align: center">Daily</th>
            <th rowspan="2"  style="text-align: center">Accumulate</th>
          </tr>
          <tr>
            <td colspan="1" style="text-align: center">1</td>
            <td colspan="1" style="text-align: center">2</td>
            <td colspan="1" style="text-align: center">3</td>
            <td colspan="1" style="text-align: center">4</td>
            <td colspan="1" style="text-align: center">5</td>
            <td colspan="1" style="text-align: center">6</td>
            <td colspan="1" style="text-align: center">7</td>
            <td colspan="1" style="text-align: center">8</td>
            <td colspan="1" style="text-align: center">9</td>
            <td colspan="1" style="text-align: center">10</td>
            <td colspan="1" style="text-align: center">11</td>
            <td colspan="1" style="text-align: center">12</td>
            <td colspan="1" style="text-align: center">13</td>
            <td colspan="1" style="text-align: center">14</td>
            <td colspan="1" style="text-align: center">15</td>
            <td colspan="1" style="text-align: center">16</td>
            <td colspan="1" style="text-align: center">17</td>
            <td colspan="1" style="text-align: center">18</td>
            <td colspan="1" style="text-align: center">19</td>
            <td colspan="1" style="text-align: center">20</td>
            <td colspan="1" style="text-align: center">21</td>
            <td colspan="1" style="text-align: center">22</td>
            <td colspan="1" style="text-align: center">23</td>
            <td colspan="1" style="text-align: center">24</td>
            <td colspan="1" style="text-align: center">25</td>
            <td colspan="1" style="text-align: center">26</td>
            <td colspan="1" style="text-align: center">27</td>
            <td colspan="1" style="text-align: center">28</td>
            <td colspan="1" style="text-align: center">29</td>
            <td colspan="1" style="text-align: center">30</td>
            <td colspan="1" style="text-align: center">31</td>
          </tr>
        </thead>
        <tbody>
          <!-- QueryData -->
          <?php
          // $sql_sedriveratt1 = "SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
          // WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
          // AND REMARK ='Driver_Attend' 
          // AND REMARK_MONTH ='".$month."' 
          // AND REMARK_YEARS ='".$years."'";
          // $params_sedriveratt1 = array();
          // $query_sedriveratt1 = sqlsrv_query($conn, $sql_sedriveratt1, $params_sedriveratt1);
          // $result_sedriveratt1 = sqlsrv_fetch_array($query_sedriveratt1, SQLSRV_FETCH_ASSOC);

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

          $sql_sedriverattTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'DriverAttTotalValue'  
          FROM DIGITALTENKO_KPI
          WHERE REMARK ='Driver_Attend' 
          AND REMARK_MONTH ='".$month."' 
          AND REMARK_YEARS ='".$years."'";
          $params_sedriverattTotal = array();
          $query_sedriverattTotal  = sqlsrv_query($conn, $sql_sedriverattTotal, $params_sedriverattTotal);
          $result_sedriverattTotal = sqlsrv_fetch_array($query_sedriverattTotal, SQLSRV_FETCH_ASSOC);

          ?>
            <tr>
              <td style="text-align: center">Driver attend</td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriveratt['DriverAtten31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattTotal['DriverAttTotalValue']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
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

              $sql_seokdriverTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'OkDriverTotalValue'  
              FROM DIGITALTENKO_KPI
              WHERE REMARK ='OK_Driver' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seokdriverTotal = array();
              $query_seokdriverTotal  = sqlsrv_query($conn, $sql_seokdriverTotal, $params_seokdriverTotal);
              $result_seokdriverTotal = sqlsrv_fetch_array($query_seokdriverTotal, SQLSRV_FETCH_ASSOC);

              ?>
              <td style="text-align: center">OK Driver</td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriver['OkDriver31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seokdriverTotal['OkDriverTotalValue']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
              $sql_sedriverattper = "SELECT (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per1',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per2',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per3',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per4',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per5',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per6',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per7',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per8',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per9',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per10',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per11',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per12',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per13',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per14',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per15',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per16',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per17',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per18',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per19',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per20',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per21',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per22',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per23',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per24',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per25',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per26',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per27',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per28',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per29',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per30',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Driver_Attend_Per31'";
              $params_sedriverattper  = array();
              $query_sedriverattper = sqlsrv_query($conn, $sql_sedriverattper, $params_sedriverattper);
              $result_sedriverattper = sqlsrv_fetch_array($query_sedriverattper, SQLSRV_FETCH_ASSOC);

              $sql_sedriverattperTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'Driver_Attend_PerTotalValue'  
              FROM DIGITALTENKO_KPI
              WHERE REMARK ='Driver_Attend_Per' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_sedriverattperTotal = array();
              $query_sedriverattperTotal  = sqlsrv_query($conn, $sql_sedriverattperTotal, $params_sedriverattperTotal);
              $result_sedriverattperTotal = sqlsrv_fetch_array($query_sedriverattperTotal, SQLSRV_FETCH_ASSOC);

              //คิดเปอเซ็นของ Driver attendance%
              $c = ($result_sedriverattperTotal['Driver_Attend_PerTotalValue'] / 3100);
              $d = (round(($c*100)*100)/100);

              // echo $d;
              ?>
              <td style="text-align: center">Driver attendance %</td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sedriverattper['Driver_Attend_Per30']?></td>
              <td colspan="1" style="text-align: center"><?=$d?>%</td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
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

              $sql_setotaldriverTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TotalDriverTotalValue'  
              FROM DIGITALTENKO_KPI
              WHERE REMARK ='Total_Driver' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_setotaldriverTotal = array();
              $query_setotaldriverTotal  = sqlsrv_query($conn, $sql_setotaldriverTotal, $params_setotaldriverTotal);
              $result_setotaldriverTotal = sqlsrv_fetch_array($query_setotaldriverTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center">Total Driver</td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriver['TotalDriver31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriverTotal['TotalDriverTotalValue']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
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

              $sql_seRequirementTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'RequirementTotalValue'  
              FROM DIGITALTENKO_KPI
              WHERE REMARK ='Requirement' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seRequirementTotal = array();
              $query_seRequirementTotal  = sqlsrv_query($conn, $sql_seRequirementTotal, $params_seRequirementTotal);
              $result_seRequirementTotal = sqlsrv_fetch_array($query_seRequirementTotal, SQLSRV_FETCH_ASSOC);

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
              <td colspan="1" style="text-align: center"><?=$result_seRequirementTotal['RequirementTotalValue']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
              $sql_seAbsenceLeave = "SELECT (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave1',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave2',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave3',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave4',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave5',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave6',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave7',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave8',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave9',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave10',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave11',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave12',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave13',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave14',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave15',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave16',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave17',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave18',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave19',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave20',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave21',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave22',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave23',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave24',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave25',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave26',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave27',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave28',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave29',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave30',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'AbsenceLeave31'";
              $params_seAbsenceLeave  = array();
              $query_seAbsenceLeave = sqlsrv_query($conn, $sql_seAbsenceLeave, $params_seAbsenceLeave);
              $result_seAbsenceLeave = sqlsrv_fetch_array($query_seAbsenceLeave, SQLSRV_FETCH_ASSOC);

              $sql_seAbsenceLeaveTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'AbsenceLeaveTotalValue'  
              FROM DIGITALTENKO_KPI
              WHERE REMARK ='AbsenceLeave' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seAbsenceLeaveTotal = array();
              $query_seAbsenceLeaveTotal  = sqlsrv_query($conn, $sql_seAbsenceLeaveTotal, $params_seAbsenceLeaveTotal);
              $result_seAbsenceLeaveTotal = sqlsrv_fetch_array($query_seAbsenceLeaveTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center">Absence/Leave</td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeave['AbsenceLeave31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAbsenceLeaveTotal['AbsenceLeaveTotalValue']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
              $sql_seTenkoNG = "SELECT (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG1',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG2',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG3',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG4',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG5',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG6',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG7',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG8',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG9',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG10',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG11',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG12',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG13',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG14',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG15',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG16',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG17',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG18',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG19',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG20',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG21',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG22',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG23',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG24',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG25',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG26',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG27',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG28',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG29',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG30',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'TenkoNG31'";
              $params_seTenkoNG = array();
              $query_seTenkoNG = sqlsrv_query($conn, $sql_seTenkoNG, $params_seTenkoNG);
              $result_seTenkoNG = sqlsrv_fetch_array($query_seTenkoNG, SQLSRV_FETCH_ASSOC);

              $sql_seTenkoNGTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'Tenko_NGTotalValue'  
              FROM DIGITALTENKO_KPI
              WHERE REMARK ='Tenko_NG' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seTenkoNGTotal = array();
              $query_seTenkoNGTotal  = sqlsrv_query($conn, $sql_seTenkoNGTotal, $params_seTenkoNGTotal);
              $result_seTenkoNGTotal = sqlsrv_fetch_array($query_seTenkoNGTotal, SQLSRV_FETCH_ASSOC);

              
              ?>
              <td style="text-align: center;background-color: #F8D18F;">Tenko : NG</td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNG['TenkoNG31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTenkoNGTotal['Tenko_NGTotalValue']?></td>
            </tr>
            <tr>
              <td  colspan="1"  style="text-align: center;font-size: 20px">&#129095;</td>
              <td  colspan="32" style="text-align: left;"></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
              $sql_seBloodPressure = "SELECT (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure1',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure2',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure3',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure4',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure5',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure6',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure7',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure8',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure9',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure10',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure11',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure12',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure13',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure14',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure15',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure16',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure17',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure18',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure19',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure20',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure21',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure22',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure23',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure24',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure25',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure26',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure27',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure28',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure29',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure30',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Blood_Pressure31'";
              $params_seBloodPressure = array();
              $query_seBloodPressure = sqlsrv_query($conn, $sql_seBloodPressure, $params_seBloodPressure);
              $result_seBloodPressure = sqlsrv_fetch_array($query_seBloodPressure, SQLSRV_FETCH_ASSOC);

              $sql_seBloodPressureTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'BloodPressureTotalValue'  
              FROM DIGITALTENKO_KPI
              WHERE REMARK ='Blood_Pressure' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seBloodPressureTotal = array();
              $query_seBloodPressureTotal  = sqlsrv_query($conn, $sql_seBloodPressureTotal, $params_seBloodPressureTotal);
              $result_seBloodPressureTotal = sqlsrv_fetch_array($query_seBloodPressureTotal, SQLSRV_FETCH_ASSOC);

              ?>
              <td style="text-align: center;background-color: #F8D18F;">Blood pressure</td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressure['Blood_Pressure31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seBloodPressureTotal['BloodPressureTotalValue']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
              $sql_seAlcohol = "SELECT (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol1',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol2',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol3',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol4',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol5',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol6',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol7',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol8',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol9',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol10',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol11',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol12',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol13',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol14',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol15',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol16',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol17',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol18',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol19',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol20',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol21',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol22',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol23',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol24',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol25',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol26',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol27',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol28',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol29',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol30',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Alcohol31'";
              $params_seAlcohol = array();
              $query_seAlcohol = sqlsrv_query($conn, $sql_seAlcohol, $params_seAlcohol);
              $result_seAlcohol = sqlsrv_fetch_array($query_seAlcohol, SQLSRV_FETCH_ASSOC);

              $sql_seAlcoholTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'AlcoholTotalValue'  
              FROM DIGITALTENKO_KPI
              WHERE REMARK ='Alcohol' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seAlcoholTotal = array();
              $query_seAlcoholTotal  = sqlsrv_query($conn, $sql_seAlcoholTotal, $params_seAlcoholTotal);
              $result_seAlcoholTotal = sqlsrv_fetch_array($query_seAlcoholTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center;background-color: #F8D18F;">Alcohol</td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcohol['Alcohol31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAlcoholTotal['AlcoholTotalValue']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
              $sql_seResttime = "SELECT (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime1',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime2',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime3',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime4',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime5',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime6',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime7',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime8',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime9',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime10',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime11',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime12',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime13',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime14',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime15',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime16',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime17',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime18',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime19',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime20',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime21',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime22',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime23',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime24',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime25',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime26',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime27',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime28',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime29',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime30',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'Resttime31'";
              $params_seResttime = array();
              $query_seResttime = sqlsrv_query($conn, $sql_seResttime, $params_seResttime);
              $result_seResttime = sqlsrv_fetch_array($query_seResttime, SQLSRV_FETCH_ASSOC);

              $sql_seResttimeTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'Resttime_6hrsTotalValue'  
              FROM DIGITALTENKO_KPI
              WHERE REMARK ='Resttime_6hrs' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seResttimeTotal = array();
              $query_seResttimeTotal  = sqlsrv_query($conn, $sql_seResttimeTotal, $params_seResttimeTotal);
              $result_seResttimeTotal = sqlsrv_fetch_array($query_seResttimeTotal, SQLSRV_FETCH_ASSOC);



              ?>
              <td style="text-align: center;background-color: #F8D18F;">Rest time < 6 hrs.</td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttime['Resttime31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seResttimeTotal['Resttime_6hrsTotalValue']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
              $sql_seHealthproblem = "SELECT (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='01/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem1',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='02/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem2',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='03/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem3',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='04/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem4',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='05/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem5',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='06/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem6',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='07/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem7',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='08/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem8',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='09/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem9',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='10/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem10',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='11/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem11',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='12/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem12',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='13/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem13',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='14/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem14',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='15/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem15',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='16/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem16',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='17/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem17',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='18/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem18',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='19/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem19',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='20/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem20',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='21/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem21',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='22/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem22',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='23/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem23',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='24/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem24',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='25/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem25',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='26/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem26',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='27/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem27',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='28/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem28',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='29/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem29',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='30/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem30',
              (SELECT DATA_PROCESS FROM DIGITALTENKO_KPI
              WHERE DATE_PROCESS ='31/".$monthnumeric."/".$years."' 
              AND REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."') AS 'HealthProblem31'";
              $params_seHealthproblem = array();
              $query_seHealthproblem = sqlsrv_query($conn, $sql_seHealthproblem, $params_seHealthproblem);
              $result_seHealthproblem = sqlsrv_fetch_array($query_seHealthproblem, SQLSRV_FETCH_ASSOC);

              $sql_seHealthproblemTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'Health_ProblemTotalValue'  
              FROM DIGITALTENKO_KPI
              WHERE REMARK ='Health_Problem' 
              AND REMARK_MONTH ='".$month."' 
              AND REMARK_YEARS ='".$years."'";
              $params_seHealthproblemTotal = array();
              $query_seHealthproblemTotal  = sqlsrv_query($conn, $sql_seHealthproblemTotal, $params_seHealthproblemTotal);
              $result_seHealthproblemTotal = sqlsrv_fetch_array($query_seHealthproblemTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center;background-color: #F8D18F;">Health problem</td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem13']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem14']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem15']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem16']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem17']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem18']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem19']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem20']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem21']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem22']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem23']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem24']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem25']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem26']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem27']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem28']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem29']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem30']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblem['HealthProblem31']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHealthproblemTotal['Health_ProblemTotalValue']?></td>
            </tr>
           
        </tbody>
      </table>
    </body>
    
</html>
