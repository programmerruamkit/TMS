<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงาน StopCallWait_KPI.xls";
} else {
    $strExcelFileName = "รายงาน StopCallWait_KPI" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
}


  // header("Content-Type: application/vnd.ms-excel");
  // header("Content-Disposition: inline; filename=\"$strExcelFileName\"");

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
            <th colspan ="14" bgcolor="#CCCCCC" style="text-align: left;border:1px solid #000;padding:4px;" >STOP-CALL-WAIT</th>
        </tr>
          <tr>
            <th rowspan="2" colspan="1" style="text-align: center;font-size: 35px;">RKS</th>
            <th colspan="12" style="text-align: center">STOP-CALL-WAIT Result <?=$years?></th>
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

          $sql_seworkingdayTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA1'  
          FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
          WHERE  REMARK ='Personal' 
          AND SUBSTRING(DATE_PROCESS, 1, 8) ='TenkoPer'
          AND REMARK_YEARS ='".$years."'";
          $params_seworkingdayTotal = array();
          $query_seworkingdayTotal  = sqlsrv_query($conn, $sql_seworkingdayTotal, $params_seworkingdayTotal);
          $result_seworkingdayTotal = sqlsrv_fetch_array($query_seworkingdayTotal, SQLSRV_FETCH_ASSOC);

          ?>
            <tr>
              <td style="text-align: center;background-color: #F8D18F;"><b>Personal issue</b></td>
              <td colspan="13" style="text-align: center"></td>
            </tr>
            <tr>
              <td style="text-align: center">Tenko</td>
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

              $sql_setotaldriverTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA2'  
              FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
              WHERE  REMARK ='Personal' 
              AND SUBSTRING(DATE_PROCESS, 1, 11) ='OnthewayPer'
              AND REMARK_YEARS ='".$years."'";
              $params_setotaldriverTotal = array();
              $query_setotaldriverTotal  = sqlsrv_query($conn, $sql_setotaldriverTotal, $params_setotaldriverTotal);
              $result_setotaldriverTotal = sqlsrv_fetch_array($query_setotaldriverTotal, SQLSRV_FETCH_ASSOC);

              ?>
              <td style="text-align: center">On the way</td>
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

              $sql_seplancheckTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA3'  
              FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
              WHERE  REMARK ='Personal' 
              AND SUBSTRING(DATE_PROCESS, 1, 10) ='AtplantPer'
              AND REMARK_YEARS ='".$years."'";
              $params_seplancheckTotal = array();
              $query_seplancheckTotal  = sqlsrv_query($conn, $sql_seplancheckTotal, $params_seplancheckTotal);
              $result_seplancheckTotal = sqlsrv_fetch_array($query_seplancheckTotal, SQLSRV_FETCH_ASSOC);

              ?>
              <td style="text-align: center">at Supplier plant</td>
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

              $sql_seactualcheckTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA4'  
              FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
              WHERE  REMARK ='Personal' 
              AND SUBSTRING(DATE_PROCESS, 1, 11) ='AttoyotaPer'
              AND REMARK_YEARS ='".$years."'";
              $params_seactualcheckTotal = array();
              $query_seactualcheckTotal  = sqlsrv_query($conn, $sql_seactualcheckTotal, $params_seactualcheckTotal);
              $result_seactualcheckTotal = sqlsrv_fetch_array($query_seactualcheckTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center">at TOYOTA</td>
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


              $subperall = $subper1+$subper2+$subper3+$subper4+$subper5
              +$subper6+$subper7+$subper8+$subper9+$subper10+$subper11+$subper12;

              ?>
              <td bgcolor="#CCCCCC" style="text-align: center">Subtotal</td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subper1?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subper2?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subper3?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subper4?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subper5?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subper6?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subper7?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subper8?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subper9?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subper10?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subper11?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subper12?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subperall?></td>
            </tr>
            
            <tr>
              <td style="text-align: center;background-color: #F8D18F;"><b>External issue</b></td>
              <td colspan="13" style="text-align: center"></td>
            </tr>
            <tr>
              <!-- QueryData -->
              <?php
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

              $sql_senotkeepfrontTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA6'  
              FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
              WHERE  REMARK ='External' 
              AND SUBSTRING(DATE_PROCESS, 1, 8) ='TenkoExt'
              AND REMARK_YEARS ='".$years."'";
              $params_senotkeepfrontTotal = array();
              $query_senotkeepfrontTotal  = sqlsrv_query($conn, $sql_senotkeepfrontTotal, $params_senotkeepfrontTotal);
              $result_senotkeepfrontTotal = sqlsrv_fetch_array($query_senotkeepfrontTotal, SQLSRV_FETCH_ASSOC);

              ?>
              <td style="text-align: center;">Tenko</td>
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

              
              $sql_seDriverRightTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA7'  
              FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
              WHERE  REMARK ='External' 
              AND SUBSTRING(DATE_PROCESS, 1, 11) ='OnthewayExt'
              AND REMARK_YEARS ='".$years."'";
              $params_seDriverRightTotal = array();
              $query_seDriverRightTotal  = sqlsrv_query($conn, $sql_seDriverRightTotal, $params_seDriverRightTotal);
              $result_seDriverRightTotal = sqlsrv_fetch_array($query_seDriverRightTotal, SQLSRV_FETCH_ASSOC);



              ?>
              <td style="text-align: center;">On the way</td>
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

              $sql_seAttoyotaPerTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA8'  
              FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
              WHERE  REMARK ='External' 
              AND SUBSTRING(DATE_PROCESS, 1, 11) ='AttplantExt'
              AND REMARK_YEARS ='".$years."'";
              $params_seAttoyotaPerTotal = array();
              $query_seAttoyotaPerTotal  = sqlsrv_query($conn, $sql_seAttoyotaPerTotal, $params_seAttoyotaPerTotal);
              $result_seAttoyotaPerTotal = sqlsrv_fetch_array($query_seAttoyotaPerTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center;">at Supplier plant</td>
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
              <td colspan="1" style="text-align: center"><?=$result_seAttoyotaPerTotal['TOTALDATA8']?></td>
            </tr>
           <!-- QueryData -->
           <tr>
              <?php
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

              $sql_seAgainstTrafTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA8'  
              FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
              WHERE  REMARK ='External' 
              AND SUBSTRING(DATE_PROCESS, 1, 11) ='AttoyotaExt'
              AND REMARK_YEARS ='".$years."'";
              $params_seAgainstTrafTotal = array();
              $query_seAgainstTrafTotal  = sqlsrv_query($conn, $sql_seAgainstTrafTotal, $params_seAgainstTrafTotal);
              $result_seAgainstTrafTotal = sqlsrv_fetch_array($query_seAgainstTrafTotal, SQLSRV_FETCH_ASSOC);


              ?>
              <td style="text-align: center;">at TOYOTA</td>
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
            <tr>
             <?php
              $sql_seData10 = "SELECT (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
              WHERE DATE_PROCESS ='SubtotalExtJan".$years."' 
              AND REMARK ='External' 
              AND REMARK_MONTH ='Jan' 
              AND REMARK_YEARS ='".$years."') AS 'DATA1',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
              WHERE DATE_PROCESS ='SubtotalExtFeb".$years."' 
              AND REMARK ='External' 
              AND REMARK_MONTH ='Feb' 
              AND REMARK_YEARS ='".$years."') AS 'DATA2',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
              WHERE DATE_PROCESS ='SubtotalExtMar".$years."' 
              AND REMARK ='External' 
              AND REMARK_MONTH ='Mar' 
              AND REMARK_YEARS ='".$years."') AS 'DATA3',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
              WHERE DATE_PROCESS ='SubtotalExtApr".$years."' 
              AND REMARK ='External' 
              AND REMARK_MONTH ='Apr' 
              AND REMARK_YEARS ='".$years."') AS 'DATA4',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
              WHERE DATE_PROCESS ='SubtotalExtMay".$years."' 
              AND REMARK ='External' 
              AND REMARK_MONTH ='May' 
              AND REMARK_YEARS ='".$years."') AS 'DATA5',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
              WHERE DATE_PROCESS ='SubtotalExtJun".$years."' 
              AND REMARK ='External' 
              AND REMARK_MONTH ='Jun' 
              AND REMARK_YEARS ='".$years."') AS 'DATA6',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
              WHERE DATE_PROCESS ='SubtotalExtJul".$years."' 
              AND REMARK ='External' 
              AND REMARK_MONTH ='Jul' 
              AND REMARK_YEARS ='".$years."') AS 'DATA7',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
              WHERE DATE_PROCESS ='SubtotalExtAug".$years."' 
              AND REMARK ='External' 
              AND REMARK_MONTH ='Aug' 
              AND REMARK_YEARS ='".$years."') AS 'DATA8',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
              WHERE DATE_PROCESS ='SubtotalExtSep".$years."' 
              AND REMARK ='External' 
              AND REMARK_MONTH ='Sep' 
              AND REMARK_YEARS ='".$years."') AS 'DATA9',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
              WHERE DATE_PROCESS ='SubtotalExtOct".$years."' 
              AND REMARK ='External' 
              AND REMARK_MONTH ='Oct' 
              AND REMARK_YEARS ='".$years."') AS 'DATA10',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
              WHERE DATE_PROCESS ='SubtotalExtNov".$years."' 
              AND REMARK ='External' 
              AND REMARK_MONTH ='Nov' 
              AND REMARK_YEARS ='".$years."') AS 'DATA11',
              (SELECT DATA_PROCESS FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
              WHERE DATE_PROCESS ='SubtotalExtDec".$years."' 
              AND REMARK ='External' 
              AND REMARK_MONTH ='Dec' 
              AND REMARK_YEARS ='".$years."') AS 'DATA12'";
              $params_seData10  = array();
              $query_seData10 = sqlsrv_query($conn, $sql_seData10, $params_seData10);
              $result_seData10 = sqlsrv_fetch_array($query_seData10, SQLSRV_FETCH_ASSOC);

              $sql_seSubExtTotal = "SELECT SUM(CAST(DATA_PROCESS AS INT)) AS 'TOTALDATA10'  
              FROM [dbo].[DIGITALTENKO_STOPCALLWAIT]
              WHERE  REMARK ='External' 
              AND SUBSTRING(DATE_PROCESS, 1, 11) ='SubtotalExt'
              AND REMARK_YEARS ='".$years."'";
              $params_seSubExtTotal = array();
              $query_seSubExtTotal  = sqlsrv_query($conn, $sql_seSubExtTotal, $params_seSubExtTotal);
              $result_seSubExtTotal = sqlsrv_fetch_array($query_seSubExtTotal, SQLSRV_FETCH_ASSOC);

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


              $subextall = $subext1+$subext2+$subext3+$subext4+$subext5
              +$subext6+$subext7+$subext8+$subext9+$subext10+$subext11+$subext12;

              ?>
              <td bgcolor="#CCCCCC" style="text-align: center;">Subtotal</td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subext1?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subext2?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subext3?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subext4?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subext5?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subext6?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subext7?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subext8?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subext9?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subext10?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subext11?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subext12?></td>
              <td bgcolor="#CCCCCC" colspan="1" style="text-align: center"><?=$subextall?></td>
            </tr>
            <!-- QueryData -->
            
            
        </tbody>
      </table>
    </body>
    
</html>
