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
            <th colspan ="7" bgcolor="#CCCCCC" style="text-align: left;border:1px solid #000;padding:4px;" >TENKO NG /Absence/Leave/Sick Record</th>
        </tr>
          <tr>
            <th rowspan="2" style="text-align: center">DATE</th>
            <th rowspan="2" style="text-align: center">DRIVER NAME</th>
            <th colspan="3" style="text-align: center">DETAIL</th>
            <th rowspan="2" style="text-align: center">CAUSE</th>
            <th rowspan="2" style="text-align: center">ACTION</th>
          </tr>
          <tr>
            <td colspan="1" style="text-align: center">TenkoNG</td>
            <td colspan="1" style="text-align: center">Annual leave</td>
            <td colspan="1" style="text-align: center">Sick leave</td>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;

          $sql_seTenkoNG = "SELECT TENKONG_ID,DATE_PROCESS,DRIVERNAME,TENKONG
          ,ANNUALLEAVE,SICKLEAVE,CAUSE_DATA,ACTION_DATA 
          FROM DIGITALTENKO_TENKONG
          WHERE DATE_PROCESS BETWEEN '".$_GET['datestart']."' AND '".$_GET['dateend']."'
          ORDER BY DATE_PROCESS ASC";
          // ORDER BY a.JOBSTART,b.DATEWORKING ASC
          $query_seTenkoNG = sqlsrv_query($conn, $sql_seTenkoNG, $params_seTenkoNG);
          while ($result_seTenkoNG = sqlsrv_fetch_array($query_seTenkoNG, SQLSRV_FETCH_ASSOC)) {

            ?>

            <tr>
              <td style="text-align: center"><?=$result_seTenkoNG['DATE_PROCESS']?></td>
              <td style="text-align: center"><?=$result_seTenkoNG['DRIVERNAME']?></td>
               <!--TENKONG -->
              <?php
              if ($result_seTenkoNG['TENKONG'] == '1') {
              ?>  
                  <!-- เครื่องหมายถูก -->
                  <td style="border:1px solid #000;padding:4px;text-align:center;font-size:14px;font-weight:bold;">&#10004;</td>
              <?php
              }else{
              ?>
                  <!-- เครื่องหมายผิด -->
                  <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;">&#120;</td>
              <?php
              }
              ?>
              
              <!--ANNUALLEAVE -->
              <?php
              if ($result_seTenkoNG['ANNUALLEAVE'] == '1') {
              ?>  
                  <!-- เครื่องหมายถูก -->
                  <td style="border:1px solid #000;padding:4px;text-align:center;font-size:14px;font-weight:bold;">&#10004;</td>
              <?php
              }else{
              ?>
                  <!-- เครื่องหมายผิด -->
                  <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;">&#120;</td>
              <?php
              }
              ?>

              <!--SICKLEAVE -->
              <?php
              if ($result_seTenkoNG['SICKLEAVE'] == '1') {
              ?>  
                  <!-- เครื่องหมายถูก -->
                  <td style="border:1px solid #000;padding:4px;text-align:center;font-size:14px;font-weight:bold;">&#10004;</td>
              <?php
              }else{
              ?>
                  <!-- เครื่องหมายผิด -->
                  <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;">&#120;</td>
              <?php
              }
              ?>
              <td style="text-align: center"><?=$result_seTenkoNG['CAUSE_DATA']?></td>
              <td style="text-align: center"><?=$result_seTenkoNG['ACTION_DATA']?></td>
            </tr>
            
            <?php
            $i++;
          }
          ?>
        
        </tbody>
      </table>
    </body>
    
</html>
