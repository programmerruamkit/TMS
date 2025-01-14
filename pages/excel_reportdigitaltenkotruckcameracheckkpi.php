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

$monthnumeric = '';
$month = '';
$years = $_GET['years'];
$yearsub = substr($years,2);
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
            <th colspan ="14" bgcolor="#CCCCCC" style="text-align: left;border:1px solid #000;padding:4px;" >Truck camera checking result</th>
        </tr>
          <tr>
            <th rowspan="2" colspan="1" style="text-align: center">Topic</th>
            <th colspan="12" style="text-align: center"><?=$years?></th>
            <th rowspan="2"  style="text-align: center">Accumulate</th>
          </tr>
          <tr>
            <td colspan="1" style="text-align: center">Jan'<?=$yearsub?></td>
            <td colspan="1" style="text-align: center">Feb'<?=$yearsub?></td>
            <td colspan="1" style="text-align: center">Mar'<?=$yearsub?></td>
            <td colspan="1" style="text-align: center">Apr'<?=$yearsub?></td>
            <td colspan="1" style="text-align: center">May'<?=$yearsub?></td>
            <td colspan="1" style="text-align: center">Jun'<?=$yearsub?></td>
            <td colspan="1" style="text-align: center">Jul'<?=$yearsub?></td>
            <td colspan="1" style="text-align: center">Aug'<?=$yearsub?></td>
            <td colspan="1" style="text-align: center">Sep'<?=$yearsub?></td>
            <td colspan="1" style="text-align: center">Oct'<?=$yearsub?></td>
            <td colspan="1" style="text-align: center">Nov'<?=$yearsub?></td>
            <td colspan="1" style="text-align: center">Dec'<?=$yearsub?></td>
          </tr>
        </thead>
        <tbody>
          <!-- QueryData -->
          <?php
          $sql_seData1 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='WorkingJan".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Jan' 
              AND REMARK_YEARS ='".$years."') AS 'DATA1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='WorkingFeb".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Feb' 
              AND REMARK_YEARS ='".$years."') AS 'DATA2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='WorkingMar".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Mar' 
              AND REMARK_YEARS ='".$years."') AS 'DATA3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='WorkingApr".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Apr' 
              AND REMARK_YEARS ='".$years."') AS 'DATA4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='WorkingMay".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='May' 
              AND REMARK_YEARS ='".$years."') AS 'DATA5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='WorkingJun".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Jun' 
              AND REMARK_YEARS ='".$years."') AS 'DATA6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='WorkingJul".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Jul' 
              AND REMARK_YEARS ='".$years."') AS 'DATA7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='WorkingAug".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Aug' 
              AND REMARK_YEARS ='".$years."') AS 'DATA8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='WorkingSep".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Sep' 
              AND REMARK_YEARS ='".$years."') AS 'DATA9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='WorkingOct".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Oct' 
              AND REMARK_YEARS ='".$years."') AS 'DATA10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='WorkingNov".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Nov' 
              AND REMARK_YEARS ='".$years."') AS 'DATA11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='WorkingDec".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Dec' 
              AND REMARK_YEARS ='".$years."') AS 'DATA12'";
          $params_seData1  = array();
          $query_seData1 = sqlsrv_query($conn, $sql_seData1, $params_seData1);
          $result_seData1 = sqlsrv_fetch_array($query_seData1, SQLSRV_FETCH_ASSOC);

          $sql_seworkingdayTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA1'  
          FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
          WHERE  REMARK ='Topic' 
          AND SUBSTRING(DATE_PROCESS, 1, 7) ='Working'
          AND REMARK_YEARS ='".$years."'";
          $params_seworkingdayTotal = array();
          $query_seworkingdayTotal  = sqlsrv_query($conn, $sql_seworkingdayTotal, $params_seworkingdayTotal);
          $result_seworkingdayTotal = sqlsrv_fetch_array($query_seworkingdayTotal, SQLSRV_FETCH_ASSOC);

          ?>
            <tr>
              <td style="text-align: center">Working Day</td>
              <td colspan="1" style="text-align: center"><?=$result_seData1['DATA1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData1['DATA2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData1['DATA3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData1['DATA4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData1['DATA5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData1['DATA6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData1['DATA7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData1['DATA8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData1['DATA9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData1['DATA10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData1['DATA11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData1['DATA12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seworkingdayTotal['TOTALDATA1']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
              $sql_seData2 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TotalDriverJan".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Jan' 
              AND REMARK_YEARS ='".$years."') AS 'DATA1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TotalDriverFeb".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Feb' 
              AND REMARK_YEARS ='".$years."') AS 'DATA2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TotalDriverMar".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Mar' 
              AND REMARK_YEARS ='".$years."') AS 'DATA3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TotalDriverApr".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Apr' 
              AND REMARK_YEARS ='".$years."') AS 'DATA4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TotalDriverMay".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='May' 
              AND REMARK_YEARS ='".$years."') AS 'DATA5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TotalDriverJun".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Jun' 
              AND REMARK_YEARS ='".$years."') AS 'DATA6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TotalDriverJul".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Jul' 
              AND REMARK_YEARS ='".$years."') AS 'DATA7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TotalDriverAug".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Aug' 
              AND REMARK_YEARS ='".$years."') AS 'DATA8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TotalDriverSep".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Sep' 
              AND REMARK_YEARS ='".$years."') AS 'DATA9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TotalDriverOct".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Oct' 
              AND REMARK_YEARS ='".$years."') AS 'DATA10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TotalDriverNov".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Nov' 
              AND REMARK_YEARS ='".$years."') AS 'DATA11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TotalDriverDec".$years."' 
              AND REMARK ='Topic' 
              AND REMARK_MONTH ='Dec' 
              AND REMARK_YEARS ='".$years."') AS 'DATA12'";
              $params_seData2  = array();
              $query_seData2 = sqlsrv_query($conn, $sql_seData2, $params_seData2);
              $result_seData2 = sqlsrv_fetch_array($query_seData2, SQLSRV_FETCH_ASSOC);

              $sql_setotaldriverTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA2'  
              FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE  REMARK ='Topic' 
              AND SUBSTRING(DATE_PROCESS, 1, 11) ='TotalDriver'
              AND REMARK_YEARS ='".$years."'";
              $params_setotaldriverTotal = array();
              $query_setotaldriverTotal  = sqlsrv_query($conn, $sql_setotaldriverTotal, $params_setotaldriverTotal);
              $result_setotaldriverTotal = sqlsrv_fetch_array($query_setotaldriverTotal, SQLSRV_FETCH_ASSOC);

              ?>
              <td style="text-align: center">Total Driver</td>
              <td colspan="1" style="text-align: center"><?=$result_seData2['DATA1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData2['DATA2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData2['DATA3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData2['DATA4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData2['DATA5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData2['DATA6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData2['DATA7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData2['DATA8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData2['DATA9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData2['DATA10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData2['DATA11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData2['DATA12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_setotaldriverTotal['TOTALDATA2']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
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

              $sql_seplancheckTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA3'  
              FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE  REMARK ='Topic' 
              AND SUBSTRING(DATE_PROCESS, 1, 9) ='PlanCheck'
              AND REMARK_YEARS ='".$years."'";
              $params_seplancheckTotal = array();
              $query_seplancheckTotal  = sqlsrv_query($conn, $sql_seplancheckTotal, $params_seplancheckTotal);
              $result_seplancheckTotal = sqlsrv_fetch_array($query_seplancheckTotal, SQLSRV_FETCH_ASSOC);

              ?>
              <td style="text-align: center">Plan Checking</td>
              <td colspan="1" style="text-align: center"><?=$result_seData3['DATA1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData3['DATA2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData3['DATA3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData3['DATA4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData3['DATA5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData3['DATA6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData3['DATA7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData3['DATA8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData3['DATA9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData3['DATA10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData3['DATA11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData3['DATA12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seplancheckTotal['TOTALDATA3']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
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

              $sql_seactualcheckTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA4'  
              FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE  REMARK ='Topic' 
              AND SUBSTRING(DATE_PROCESS, 1, 11) ='ActualCheck'
              AND REMARK_YEARS ='".$years."'";
              $params_seactualcheckTotal = array();
              $query_seactualcheckTotal  = sqlsrv_query($conn, $sql_seactualcheckTotal, $params_seactualcheckTotal);
              $result_seactualcheckTotal = sqlsrv_fetch_array($query_seactualcheckTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center">Actual Checking</td>
              <td colspan="1" style="text-align: center"><?=$result_seData4['DATA1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData4['DATA2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData4['DATA3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData4['DATA4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData4['DATA5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData4['DATA6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData4['DATA7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData4['DATA8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData4['DATA9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData4['DATA10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData4['DATA11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData4['DATA12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seactualcheckTotal['TOTALDATA4']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
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

              $sql_sengresultTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA5'  
              FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE  REMARK ='Topic' 
              AND SUBSTRING(DATE_PROCESS, 1, 8) ='NGResult'
              AND REMARK_YEARS ='".$years."'";
              $params_sengresultTotal = array();
              $query_sengresultTotal  = sqlsrv_query($conn, $sql_sengresultTotal, $params_sengresultTotal);
              $result_sengresultTotal = sqlsrv_fetch_array($query_sengresultTotal, SQLSRV_FETCH_ASSOC);

              ?>
              <td style="text-align: center">NG result</td>
              <td colspan="1" style="text-align: center"><?=$result_seData5['DATA1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData5['DATA2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData5['DATA3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData5['DATA4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData5['DATA5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData5['DATA6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData5['DATA7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData5['DATA8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData5['DATA9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData5['DATA10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData5['DATA11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData5['DATA12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_sengresultTotal['TOTALDATA5']?></td>
            </tr>
            
            
            <tr>
              <td  colspan="14"  style="text-align: center;font-size: 20px;height:30px"></td>
            </tr>
            <tr>
       
              <td style="text-align: center;background-color: #F8D18F;"><b>Front Camera</b></td>
              <td colspan="13" style="text-align: center"></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
              $sql_seData6 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeepFrontJan".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Jan' 
              AND REMARK_YEARS ='".$years."') AS 'DATA1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeepFrontFeb".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Feb' 
              AND REMARK_YEARS ='".$years."') AS 'DATA2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeepFrontMar".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Mar' 
              AND REMARK_YEARS ='".$years."') AS 'DATA3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeepFrontApr".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Apr' 
              AND REMARK_YEARS ='".$years."') AS 'DATA4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeepFrontMay".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='May' 
              AND REMARK_YEARS ='".$years."') AS 'DATA5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeepFrontJun".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Jun' 
              AND REMARK_YEARS ='".$years."') AS 'DATA6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeepFrontJul".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Jul' 
              AND REMARK_YEARS ='".$years."') AS 'DATA7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeepFrontAug".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Aug' 
              AND REMARK_YEARS ='".$years."') AS 'DATA8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeepFrontSep".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Sep' 
              AND REMARK_YEARS ='".$years."') AS 'DATA9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeepFrontOct".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Oct' 
              AND REMARK_YEARS ='".$years."') AS 'DATA10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeepFrontNov".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Nov' 
              AND REMARK_YEARS ='".$years."') AS 'DATA11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeepFrontDec".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Dec' 
              AND REMARK_YEARS ='".$years."') AS 'DATA12'";
              $params_seData6  = array();
              $query_seData6 = sqlsrv_query($conn, $sql_seData6, $params_seData6);
              $result_seData6 = sqlsrv_fetch_array($query_seData6, SQLSRV_FETCH_ASSOC);

              $sql_senotkeepfrontTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA6'  
              FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE  REMARK ='FrontCamera' 
              AND SUBSTRING(DATE_PROCESS, 1, 12) ='NotKeepFront'
              AND REMARK_YEARS ='".$years."'";
              $params_senotkeepfrontTotal = array();
              $query_senotkeepfrontTotal  = sqlsrv_query($conn, $sql_senotkeepfrontTotal, $params_senotkeepfrontTotal);
              $result_senotkeepfrontTotal = sqlsrv_fetch_array($query_senotkeepfrontTotal, SQLSRV_FETCH_ASSOC);

              ?>
              <td style="text-align: center;">Not keep safe distance from front vehicle</td>
              <td colspan="1" style="text-align: center"><?=$result_seData6['DATA1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData6['DATA2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData6['DATA3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData6['DATA4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData6['DATA5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData6['DATA6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData6['DATA7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData6['DATA8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData6['DATA9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData6['DATA10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData6['DATA11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData6['DATA12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_senotkeepfrontTotal['TOTALDATA6']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
              $sql_seData7 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='DrivingRightJan".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Jan' 
              AND REMARK_YEARS ='".$years."') AS 'DATA1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='DrivingRightFeb".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Feb' 
              AND REMARK_YEARS ='".$years."') AS 'DATA2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='DrivingRightMar".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Mar' 
              AND REMARK_YEARS ='".$years."') AS 'DATA3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='DrivingRightApr".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Apr' 
              AND REMARK_YEARS ='".$years."') AS 'DATA4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='DrivingRightMay".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='May' 
              AND REMARK_YEARS ='".$years."') AS 'DATA5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='DrivingRightJun".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Jun' 
              AND REMARK_YEARS ='".$years."') AS 'DATA6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='DrivingRightJul".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Jul' 
              AND REMARK_YEARS ='".$years."') AS 'DATA7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='DrivingRightAug".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Aug' 
              AND REMARK_YEARS ='".$years."') AS 'DATA8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='DrivingRightSep".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Sep' 
              AND REMARK_YEARS ='".$years."') AS 'DATA9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='DrivingRightOct".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Oct' 
              AND REMARK_YEARS ='".$years."') AS 'DATA10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='DrivingRightNov".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Nov' 
              AND REMARK_YEARS ='".$years."') AS 'DATA11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='DrivingRightDec".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Dec' 
              AND REMARK_YEARS ='".$years."') AS 'DATA12'";
              $params_seData7  = array();
              $query_seData7 = sqlsrv_query($conn, $sql_seData7, $params_seData7);
              $result_seData7 = sqlsrv_fetch_array($query_seData7, SQLSRV_FETCH_ASSOC);

              
              $sql_seDriverRightTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA7'  
              FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE  REMARK ='FrontCamera' 
              AND SUBSTRING(DATE_PROCESS, 1, 12) ='DrivingRight'
              AND REMARK_YEARS ='".$years."'";
              $params_seDriverRightTotal = array();
              $query_seDriverRightTotal  = sqlsrv_query($conn, $sql_seDriverRightTotal, $params_seDriverRightTotal);
              $result_seDriverRightTotal = sqlsrv_fetch_array($query_seDriverRightTotal, SQLSRV_FETCH_ASSOC);



              ?>
              <td style="text-align: center;">Driving on right lane (ไม่ขวาสุด)</td>
              <td colspan="1" style="text-align: center"><?=$result_seData7['DATA1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData7['DATA2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData7['DATA3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData7['DATA4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData7['DATA5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData7['DATA6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData7['DATA7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData7['DATA8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData7['DATA9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData7['DATA10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData7['DATA11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData7['DATA12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seDriverRightTotal['TOTALDATA7']?></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
              $sql_seData8 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TrafficLightJan".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Jan' 
              AND REMARK_YEARS ='".$years."') AS 'DATA1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TrafficLightFeb".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Feb' 
              AND REMARK_YEARS ='".$years."') AS 'DATA2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TrafficLightMar".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Mar' 
              AND REMARK_YEARS ='".$years."') AS 'DATA3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TrafficLightApr".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Apr' 
              AND REMARK_YEARS ='".$years."') AS 'DATA4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TrafficLightMay".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='May' 
              AND REMARK_YEARS ='".$years."') AS 'DATA5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TrafficLightJun".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Jun' 
              AND REMARK_YEARS ='".$years."') AS 'DATA6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TrafficLightJul".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Jul' 
              AND REMARK_YEARS ='".$years."') AS 'DATA7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TrafficLightAug".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Aug' 
              AND REMARK_YEARS ='".$years."') AS 'DATA8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TrafficLightSep".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Sep' 
              AND REMARK_YEARS ='".$years."') AS 'DATA9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TrafficLightOct".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Oct' 
              AND REMARK_YEARS ='".$years."') AS 'DATA10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TrafficLightNov".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Nov' 
              AND REMARK_YEARS ='".$years."') AS 'DATA11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='TrafficLightDec".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Dec' 
              AND REMARK_YEARS ='".$years."') AS 'DATA12'";
              $params_seData8  = array();
              $query_seData8 = sqlsrv_query($conn, $sql_seData8, $params_seData8);
              $result_seData8 = sqlsrv_fetch_array($query_seData8, SQLSRV_FETCH_ASSOC);

              $sql_seTrafficLightTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA8'  
              FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE  REMARK ='FrontCamera' 
              AND SUBSTRING(DATE_PROCESS, 1, 12) ='TrafficLight'
              AND REMARK_YEARS ='".$years."'";
              $params_seTrafficLightTotal = array();
              $query_seTrafficLightTotal  = sqlsrv_query($conn, $sql_seTrafficLightTotal, $params_seTrafficLightTotal);
              $result_seTrafficLightTotal = sqlsrv_fetch_array($query_seTrafficLightTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center;">Traffic light, Construction area</td>
              <td colspan="1" style="text-align: center"><?=$result_seData8['DATA1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData8['DATA2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData8['DATA3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData8['DATA4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData8['DATA5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData8['DATA6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData8['DATA7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData8['DATA8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData8['DATA9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData8['DATA10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData8['DATA11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData8['DATA12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seTrafficLightTotal['TOTALDATA8']?></td>
            </tr>
           <!-- QueryData -->
           <?php
              $sql_seData9 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='AgainstTrafJan".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Jan' 
              AND REMARK_YEARS ='".$years."') AS 'DATA1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='AgainstTrafFeb".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Feb' 
              AND REMARK_YEARS ='".$years."') AS 'DATA2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='AgainstTrafMar".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Mar' 
              AND REMARK_YEARS ='".$years."') AS 'DATA3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='AgainstTrafApr".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Apr' 
              AND REMARK_YEARS ='".$years."') AS 'DATA4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='AgainstTrafMay".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='May' 
              AND REMARK_YEARS ='".$years."') AS 'DATA5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='AgainstTrafJun".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Jun' 
              AND REMARK_YEARS ='".$years."') AS 'DATA6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='AgainstTrafJul".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Jul' 
              AND REMARK_YEARS ='".$years."') AS 'DATA7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='AgainstTrafAug".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Aug' 
              AND REMARK_YEARS ='".$years."') AS 'DATA8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='AgainstTrafSep".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Sep' 
              AND REMARK_YEARS ='".$years."') AS 'DATA9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='AgainstTrafOct".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Oct' 
              AND REMARK_YEARS ='".$years."') AS 'DATA10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='AgainstTrafNov".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Nov' 
              AND REMARK_YEARS ='".$years."') AS 'DATA11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='AgainstTrafDec".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Dec' 
              AND REMARK_YEARS ='".$years."') AS 'DATA12'";
              $params_seData9  = array();
              $query_seData9 = sqlsrv_query($conn, $sql_seData9, $params_seData9);
              $result_seData9 = sqlsrv_fetch_array($query_seData9, SQLSRV_FETCH_ASSOC);

              $sql_seAgainstTrafTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA8'  
              FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE  REMARK ='FrontCamera' 
              AND SUBSTRING(DATE_PROCESS, 1, 11) ='AgainstTraf'
              AND REMARK_YEARS ='".$years."'";
              $params_seAgainstTrafTotal = array();
              $query_seAgainstTrafTotal  = sqlsrv_query($conn, $sql_seAgainstTrafTotal, $params_seAgainstTrafTotal);
              $result_seAgainstTrafTotal = sqlsrv_fetch_array($query_seAgainstTrafTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center;">Against traffic law/TMT driving rules</td>
              <td colspan="1" style="text-align: center"><?=$result_seData9['DATA1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData9['DATA2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData9['DATA3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData9['DATA4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData9['DATA5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData9['DATA6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData9['DATA7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData9['DATA8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData9['DATA9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData9['DATA10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData9['DATA11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData9['DATA12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seAgainstTrafTotal['TOTALDATA8']?></td>
            </tr>
            <!-- QueryData -->
            <?php
              $sql_seData10 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='RunOnShoulderJan".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Jan' 
              AND REMARK_YEARS ='".$years."') AS 'DATA1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='RunOnShoulderFeb".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Feb' 
              AND REMARK_YEARS ='".$years."') AS 'DATA2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='RunOnShoulderMar".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Mar' 
              AND REMARK_YEARS ='".$years."') AS 'DATA3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='RunOnShoulderApr".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Apr' 
              AND REMARK_YEARS ='".$years."') AS 'DATA4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='RunOnShoulderMay".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='May' 
              AND REMARK_YEARS ='".$years."') AS 'DATA5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='RunOnShoulderJun".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Jun' 
              AND REMARK_YEARS ='".$years."') AS 'DATA6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='RunOnShoulderJul".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Jul' 
              AND REMARK_YEARS ='".$years."') AS 'DATA7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='RunOnShoulderAug".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Aug' 
              AND REMARK_YEARS ='".$years."') AS 'DATA8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='RunOnShoulderSep".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Sep' 
              AND REMARK_YEARS ='".$years."') AS 'DATA9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='RunOnShoulderOct".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Oct' 
              AND REMARK_YEARS ='".$years."') AS 'DATA10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='RunOnShoulderNov".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Nov' 
              AND REMARK_YEARS ='".$years."') AS 'DATA11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='RunOnShoulderDec".$years."' 
              AND REMARK ='FrontCamera' 
              AND REMARK_MONTH ='Dec' 
              AND REMARK_YEARS ='".$years."') AS 'DATA12'";
              $params_seData10  = array();
              $query_seData10 = sqlsrv_query($conn, $sql_seData10, $params_seData10);
              $result_seData10 = sqlsrv_fetch_array($query_seData10, SQLSRV_FETCH_ASSOC);

              $sql_seRunOnShoulderTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA10'  
              FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE  REMARK ='FrontCamera' 
              AND SUBSTRING(DATE_PROCESS, 1, 13) ='RunOnShoulder'
              AND REMARK_YEARS ='".$years."'";
              $params_seRunOnShoulderTotal = array();
              $query_seRunOnShoulderTotal  = sqlsrv_query($conn, $sql_seRunOnShoulderTotal, $params_seRunOnShoulderTotal);
              $result_seRunOnShoulderTotal = sqlsrv_fetch_array($query_seRunOnShoulderTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center;">Run on the shoulder</td>
              <td colspan="1" style="text-align: center"><?=$result_seData10['DATA1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData10['DATA2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData10['DATA3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData10['DATA4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData10['DATA5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData10['DATA6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData10['DATA7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData10['DATA8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData10['DATA9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData10['DATA10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData10['DATA11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData10['DATA12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seRunOnShoulderTotal['TOTALDATA10']?></td>
            </tr>
            <!-- QueryData -->
            <?php
              


              ?>
              <td style="text-align: center;background-color: #F8D18F;"><b>Cabin Camera</b></td>
              <td colspan="13" style="text-align: center"></td>
            </tr>
            <!-- QueryData -->
            <?php
              $sql_seData11 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotFastSBJan".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Jan' 
              AND REMARK_YEARS ='".$years."') AS 'DATA1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotFastSBFeb".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Feb' 
              AND REMARK_YEARS ='".$years."') AS 'DATA2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotFastSBMar".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Mar' 
              AND REMARK_YEARS ='".$years."') AS 'DATA3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotFastSBApr".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Apr' 
              AND REMARK_YEARS ='".$years."') AS 'DATA4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotFastSBMay".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='May' 
              AND REMARK_YEARS ='".$years."') AS 'DATA5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotFastSBJun".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Jun' 
              AND REMARK_YEARS ='".$years."') AS 'DATA6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotFastSBJul".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Jul' 
              AND REMARK_YEARS ='".$years."') AS 'DATA7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotFastSBAug".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Aug' 
              AND REMARK_YEARS ='".$years."') AS 'DATA8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotFastSBSep".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Sep' 
              AND REMARK_YEARS ='".$years."') AS 'DATA9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotFastSBOct".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Oct' 
              AND REMARK_YEARS ='".$years."') AS 'DATA10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotFastSBNov".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Nov' 
              AND REMARK_YEARS ='".$years."') AS 'DATA11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotFastSBDec".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Dec' 
              AND REMARK_YEARS ='".$years."') AS 'DATA12'";
              $params_seData11  = array();
              $query_seData11 = sqlsrv_query($conn, $sql_seData11, $params_seData11);
              $result_seData11 = sqlsrv_fetch_array($query_seData11, SQLSRV_FETCH_ASSOC);

              $sql_seNotFastSBTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA11'  
              FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE  REMARK ='CabinCamera' 
              AND SUBSTRING(DATE_PROCESS, 1, 9) ='NotFastSB'
              AND REMARK_YEARS ='".$years."'";
              $params_seNotFastSBTotal = array();
              $query_seNotFastSBTotal  = sqlsrv_query($conn, $sql_seNotFastSBTotal, $params_seNotFastSBTotal);
              $result_seNotFastSBTotal = sqlsrv_fetch_array($query_seNotFastSBTotal, SQLSRV_FETCH_ASSOC);

              ?>
              <td style="text-align: center;">Not fasten seat belt</td>
              <td colspan="1" style="text-align: center"><?=$result_seData11['DATA1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData11['DATA2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData11['DATA3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData11['DATA4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData11['DATA5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData11['DATA6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData11['DATA7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData11['DATA8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData11['DATA9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData11['DATA10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData11['DATA11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData11['DATA12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seNotFastSBTotal['TOTALDATA11']?></td>
            </tr>
            <!-- QueryData -->
            <?php
              $sql_seData12 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='UseMobileJan".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Jan' 
              AND REMARK_YEARS ='".$years."') AS 'DATA1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='UseMobileFeb".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Feb' 
              AND REMARK_YEARS ='".$years."') AS 'DATA2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='UseMobileMar".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Mar' 
              AND REMARK_YEARS ='".$years."') AS 'DATA3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='UseMobileApr".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Apr' 
              AND REMARK_YEARS ='".$years."') AS 'DATA4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='UseMobileMay".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='May' 
              AND REMARK_YEARS ='".$years."') AS 'DATA5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='UseMobileJun".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Jun' 
              AND REMARK_YEARS ='".$years."') AS 'DATA6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='UseMobileJul".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Jul' 
              AND REMARK_YEARS ='".$years."') AS 'DATA7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='UseMobileAug".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Aug' 
              AND REMARK_YEARS ='".$years."') AS 'DATA8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='UseMobileSep".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Sep' 
              AND REMARK_YEARS ='".$years."') AS 'DATA9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='UseMobileOct".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Oct' 
              AND REMARK_YEARS ='".$years."') AS 'DATA10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='UseMobileNov".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Nov' 
              AND REMARK_YEARS ='".$years."') AS 'DATA11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='UseMobileDec".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Dec' 
              AND REMARK_YEARS ='".$years."') AS 'DATA12'";
              $params_seData12  = array();
              $query_seData12 = sqlsrv_query($conn, $sql_seData12, $params_seData12);
              $result_seData12 = sqlsrv_fetch_array($query_seData12, SQLSRV_FETCH_ASSOC);

              $sql_seUseMobileTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA12'  
              FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE  REMARK ='CabinCamera' 
              AND SUBSTRING(DATE_PROCESS, 1, 9) ='UseMobile'
              AND REMARK_YEARS ='".$years."'";
              $params_seUseMobileTotal = array();
              $query_seUseMobileTotal  = sqlsrv_query($conn, $sql_seUseMobileTotal, $params_seUseMobileTotal);
              $result_seUseMobileTotal = sqlsrv_fetch_array($query_seUseMobileTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center;">Use mobile phone while driving</td>
              <td colspan="1" style="text-align: center"><?=$result_seData12['DATA1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData12['DATA2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData12['DATA3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData12['DATA4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData12['DATA5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData12['DATA6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData12['DATA7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData12['DATA8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData12['DATA9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData12['DATA10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData12['DATA11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData12['DATA12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seUseMobileTotal['TOTALDATA12']?></td>
            </tr>
            <!-- QueryData -->
            <?php
              $sql_seData13 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='FeelDrowsyJan".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Jan' 
              AND REMARK_YEARS ='".$years."') AS 'DATA1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='FeelDrowsyFeb".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Feb' 
              AND REMARK_YEARS ='".$years."') AS 'DATA2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='FeelDrowsyMar".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Mar' 
              AND REMARK_YEARS ='".$years."') AS 'DATA3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='FeelDrowsyApr".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Apr' 
              AND REMARK_YEARS ='".$years."') AS 'DATA4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='FeelDrowsyMay".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='May' 
              AND REMARK_YEARS ='".$years."') AS 'DATA5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='FeelDrowsyJun".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Jun' 
              AND REMARK_YEARS ='".$years."') AS 'DATA6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='FeelDrowsyJul".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Jul' 
              AND REMARK_YEARS ='".$years."') AS 'DATA7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='FeelDrowsyAug".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Aug' 
              AND REMARK_YEARS ='".$years."') AS 'DATA8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='FeelDrowsySep".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Sep' 
              AND REMARK_YEARS ='".$years."') AS 'DATA9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='FeelDrowsyOct".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Oct' 
              AND REMARK_YEARS ='".$years."') AS 'DATA10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='FeelDrowsyNov".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Nov' 
              AND REMARK_YEARS ='".$years."') AS 'DATA11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='FeelDrowsyDec".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Dec' 
              AND REMARK_YEARS ='".$years."') AS 'DATA12'";
              $params_seData13  = array();
              $query_seData13 = sqlsrv_query($conn, $sql_seData13, $params_seData13);
              $result_seData13 = sqlsrv_fetch_array($query_seData13, SQLSRV_FETCH_ASSOC);

              $sql_seFeelDrowsyTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA13'  
              FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE  REMARK ='CabinCamera' 
              AND SUBSTRING(DATE_PROCESS, 1, 10) ='FeelDrowsy'
              AND REMARK_YEARS ='".$years."'";
              $params_seFeelDrowsyTotal = array();
              $query_seFeelDrowsyTotal  = sqlsrv_query($conn, $sql_seFeelDrowsyTotal, $params_seFeelDrowsyTotal);
              $result_seFeelDrowsyTotal = sqlsrv_fetch_array($query_seFeelDrowsyTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center;">Feel drowsy</td>
              <td colspan="1" style="text-align: center"><?=$result_seData13['DATA1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData13['DATA2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData13['DATA3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData13['DATA4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData13['DATA5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData13['DATA6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData13['DATA7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData13['DATA8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData13['DATA9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData13['DATA10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData13['DATA11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData13['DATA12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seFeelDrowsyTotal['TOTALDATA13']?></td>
            </tr>
            <!-- QueryData -->
            <?php
              $sql_seData14 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotConcenJan".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Jan' 
              AND REMARK_YEARS ='".$years."') AS 'DATA1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotConcenFeb".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Feb' 
              AND REMARK_YEARS ='".$years."') AS 'DATA2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotConcenMar".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Mar' 
              AND REMARK_YEARS ='".$years."') AS 'DATA3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotConcenApr".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Apr' 
              AND REMARK_YEARS ='".$years."') AS 'DATA4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotConcenMay".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='May' 
              AND REMARK_YEARS ='".$years."') AS 'DATA5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotConcenJun".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Jun' 
              AND REMARK_YEARS ='".$years."') AS 'DATA6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotConcenJul".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Jul' 
              AND REMARK_YEARS ='".$years."') AS 'DATA7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotConcenAug".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Aug' 
              AND REMARK_YEARS ='".$years."') AS 'DATA8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotConcenSep".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Sep' 
              AND REMARK_YEARS ='".$years."') AS 'DATA9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotConcenOct".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Oct' 
              AND REMARK_YEARS ='".$years."') AS 'DATA10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotConcenNov".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Nov' 
              AND REMARK_YEARS ='".$years."') AS 'DATA11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotConcenDec".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Dec' 
              AND REMARK_YEARS ='".$years."') AS 'DATA12'";
              $params_seData14 = array();
              $query_seData14 = sqlsrv_query($conn, $sql_seData14, $params_seData14);
              $result_seData14 = sqlsrv_fetch_array($query_seData14, SQLSRV_FETCH_ASSOC);

              $sql_seNotConcenTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA14'  
              FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE  REMARK ='CabinCamera' 
              AND SUBSTRING(DATE_PROCESS, 1, 10) ='FeelDrowsy'
              AND REMARK_YEARS ='".$years."'";
              $params_seNotConcenTotal = array();
              $query_seNotConcenTotal  = sqlsrv_query($conn, $sql_seNotConcenTotal, $params_seNotConcenTotal);
              $result_seNotConcenTotal = sqlsrv_fetch_array($query_seNotConcenTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center;">Not concentrate</td>
              <td colspan="1" style="text-align: center"><?=$result_seData14['DATA1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData14['DATA2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData14['DATA3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData14['DATA4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData14['DATA5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData14['DATA6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData14['DATA7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData14['DATA8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData14['DATA9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData14['DATA10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData14['DATA11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData14['DATA12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seNotConcenTotal['TOTALDATA14']?></td>
            </tr>
            <?php
              $sql_seData15 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeep5SJan".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Jan' 
              AND REMARK_YEARS ='".$years."') AS 'DATA1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeep5SFeb".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Feb' 
              AND REMARK_YEARS ='".$years."') AS 'DATA2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeep5SMar".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Mar' 
              AND REMARK_YEARS ='".$years."') AS 'DATA3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeep5SApr".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Apr' 
              AND REMARK_YEARS ='".$years."') AS 'DATA4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeep5SMay".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='May' 
              AND REMARK_YEARS ='".$years."') AS 'DATA5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeep5SJun".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Jun' 
              AND REMARK_YEARS ='".$years."') AS 'DATA6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeep5SJul".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Jul' 
              AND REMARK_YEARS ='".$years."') AS 'DATA7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeep5SAug".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Aug' 
              AND REMARK_YEARS ='".$years."') AS 'DATA8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeep5SSep".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Sep' 
              AND REMARK_YEARS ='".$years."') AS 'DATA9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeep5SOct".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Oct' 
              AND REMARK_YEARS ='".$years."') AS 'DATA10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeep5SNov".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Nov' 
              AND REMARK_YEARS ='".$years."') AS 'DATA11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='NotKeep5SDec".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Dec' 
              AND REMARK_YEARS ='".$years."') AS 'DATA12'";
              $params_seData15  = array();
              $query_seData15 = sqlsrv_query($conn, $sql_seData15, $params_seData15);
              $result_seData15 = sqlsrv_fetch_array($query_seData15, SQLSRV_FETCH_ASSOC);

              $sql_seNotKeep5STotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA15'  
              FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE  REMARK ='CabinCamera' 
              AND SUBSTRING(DATE_PROCESS, 1, 10) ='FeelDrowsy'
              AND REMARK_YEARS ='".$years."'";
              $params_seNotKeep5STotal = array();
              $query_seNotKeep5STotal  = sqlsrv_query($conn, $sql_seNotKeep5STotal, $params_seNotKeep5STotal);
              $result_seNotKeep5STotal = sqlsrv_fetch_array($query_seNotKeep5STotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center;">Not keep 5S in cabin</td>
              <td colspan="1" style="text-align: center"><?=$result_seData15['DATA1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData15['DATA2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData15['DATA3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData15['DATA4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData15['DATA5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData15['DATA6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData15['DATA7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData15['DATA8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData15['DATA9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData15['DATA10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData15['DATA11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData15['DATA12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seNotKeep5STotal['TOTALDATA15']?></td>
            </tr>
            <?php
              $sql_seData16 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='HoldSteeringJan".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Jan' 
              AND REMARK_YEARS ='".$years."') AS 'DATA1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='HoldSteeringFeb".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Feb' 
              AND REMARK_YEARS ='".$years."') AS 'DATA2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='HoldSteeringMar".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Mar' 
              AND REMARK_YEARS ='".$years."') AS 'DATA3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='HoldSteeringApr".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Apr' 
              AND REMARK_YEARS ='".$years."') AS 'DATA4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='HoldSteeringMay".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='May' 
              AND REMARK_YEARS ='".$years."') AS 'DATA5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='HoldSteeringJun".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Jun' 
              AND REMARK_YEARS ='".$years."') AS 'DATA6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='HoldSteeringJul".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Jul' 
              AND REMARK_YEARS ='".$years."') AS 'DATA7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='HoldSteeringAug".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Aug' 
              AND REMARK_YEARS ='".$years."') AS 'DATA8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='HoldSteeringSep".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Sep' 
              AND REMARK_YEARS ='".$years."') AS 'DATA9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='HoldSteeringOct".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Oct' 
              AND REMARK_YEARS ='".$years."') AS 'DATA10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='HoldSteeringNov".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Nov' 
              AND REMARK_YEARS ='".$years."') AS 'DATA11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE DATE_PROCESS ='HoldSteeringDec".$years."' 
              AND REMARK ='CabinCamera' 
              AND REMARK_MONTH ='Dec' 
              AND REMARK_YEARS ='".$years."') AS 'DATA12'";
              $params_seData16  = array();
              $query_seData16 = sqlsrv_query($conn, $sql_seData16, $params_seData16);
              $result_seData16 = sqlsrv_fetch_array($query_seData16, SQLSRV_FETCH_ASSOC);

              $sql_seHoldSteeringTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA16'  
              FROM [dbo].[DIGITALTENKO_TRUCKCAMERACHECK]
              WHERE  REMARK ='CabinCamera' 
              AND SUBSTRING(DATE_PROCESS, 1, 12) ='HoldSteering'
              AND REMARK_YEARS ='".$years."'";
              $params_seHoldSteeringTotal = array();
              $query_seHoldSteeringTotal  = sqlsrv_query($conn, $sql_seHoldSteeringTotal, $params_seHoldSteeringTotal);
              $result_seHoldSteeringTotal = sqlsrv_fetch_array($query_seHoldSteeringTotal, SQLSRV_FETCH_ASSOC);



              ?>
              <td style="text-align: center;">Hold the steering wheel and correct sitting position</td>
              <td colspan="1" style="text-align: center"><?=$result_seData16['DATA1']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData16['DATA2']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData16['DATA3']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData16['DATA4']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData16['DATA5']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData16['DATA6']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData16['DATA7']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData16['DATA8']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData16['DATA9']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData16['DATA10']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData16['DATA11']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seData16['DATA12']?></td>
              <td colspan="1" style="text-align: center"><?=$result_seHoldSteeringTotal['TOTALDATA16']?></td>
            </tr>
            
        </tbody>
      </table>
    </body>
    
</html>
