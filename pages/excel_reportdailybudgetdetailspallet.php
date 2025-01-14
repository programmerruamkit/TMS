<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
error_reporting(E_ERROR | E_PARSE);
$conn = connect("RTMS");

    $strExcelFileName = "รายงานปิดงบประมาณรายวัน(Details)วันที่" . $_GET['datestart'] . ".xls";


  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
  header("Pragma:no-cache");
?>
<html>
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
      <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
          <thead>
              <tr>
                  <th >NO</th>
                  <th >JOBNO</th>
                  <th >TRUCK NO</th>
                  <th >DRIVER</th>
                  <th >COMPANY</th>
                  <th >CUSTOMER</th>
                  <th >JOBEND</th>
                  <th >AMOUNT</th>
                  <th >SALEPRICE</th>
              </tr>
          </thead>
          <tbody>
              <?php
              $i = 1;
              $tripamount = 0;
              $SUMSALEPRICESTM = 0;
              $SUMWORKINCENSTM = 0;
              // $SUMFUELLITSTM = 0;
              // $SUMFUELBATHSTM = 0;
              $SUMFUELINCENSTM = 0;
              $condiReporttransport1 = " AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)";
              $condiReporttransport2 = " AND a.COMPANYCODE = '" . $_GET['companycode'] . "' AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'";
              $condiReporttransport3 = " AND b.STATUSNUMBER != '0' AND a.EMPLOYEENAME1 != 'ทดสอบ ทดสอบ' AND a.DOCUMENTCODE_PALLET IS NOT NULL AND a.DOCUMENTCODE_PALLET != ''";
              $sql_seReporttransport = "{call megVehicletransportplan_v2(?,?,?,?)}";
              $params_seReporttransport = array(
                  array('select_reportdailybudgetpallet', SQLSRV_PARAM_IN),
                  array($condiReporttransport1, SQLSRV_PARAM_IN),
                  array($condiReporttransport2, SQLSRV_PARAM_IN),
                  array($condiReporttransport3, SQLSRV_PARAM_IN)
              );
              $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport, $params_seReporttransport);
              while ($result_seReporttransport = sqlsrv_fetch_array($query_seReporttransport, SQLSRV_FETCH_ASSOC)) {

                  $ACTUALPRICE  = $result_seReporttransport['TRIPAMOUNT_PALLET'] *10;

                  ?>

                  <tr>
                      <td style="text-align: center"><label  style="width: 100px"><?= $i ?></label></td>
                      <td ><label  style="width: 200px"><?= $result_seReporttransport['JOBNO'] ?></label></td>
                      <td ><label  style="width: 200px"><?= $result_seReporttransport['THAINAME'] ?></label></td>
                      <td ><label  style="width: 200px"><?= $result_seReporttransport['EMPLOYEENAME1'] ?></label></td>
                      <td ><label  style="width: 200px"><?= $result_seReporttransport['COMPANYCODE'] ?></label></td>
                      <td ><label  style="width: 200px"><?= $result_seReporttransport['CUSTOMERCODE'] ?></label></td>
                      <td ><label  style="width: 200px"><?= $result_seReporttransport['JOBEND'] ?></label></td>
                      <td ><label  style="width: 200px"><?= $result_seReporttransport['TRIPAMOUNT_PALLET'] ?></label></td>
                      <td ><label  style="width: 200px"><?=number_format($ACTUALPRICE,2) ?></td><!-- TOTAL -->
                  </tr>
                  <?php
                  $i++;
                  $AMOUNT = $AMOUNT + $result_seReporttransport['TRIPAMOUNT_PALLET'];
                  $SUMACTUALPRICE = $SUMACTUALPRICE+$ACTUALPRICE;
                  } //END LOOP WHILE


                  ?>
          </tbody>

          <!-- //////////////////////////////FOOTER/////////////////////////////////////////// -->
            <tfoot>
              <tr>
                  <!-- SUM TRIP AMOUNT-->
                  <td colspan="2"><label  style="width: 200px;"><u></u></label></td>
                   <!-- SUM WEIGHTINTON-->
                  <td ><label  style="width: 200px;"><u></u></label></td>

                  <td ><label  style="width: 200px;"><u></u></label></td>

                  <td ><label  style="width: 200px;"><u></u></label></td>

                  <td ><label  style="width: 200px;"><u></u></label></td>
                  <td ><label  style="width: 200px;"></label></td>
                  <td ><label  style="width: 200px;background-color: #2fbc50"><?=number_format($AMOUNT,2)?></label></td>
                  <td ><label  style="width: 200px;background-color: #2fbc50"><?=number_format($SUMACTUALPRICE,2)?></label></td>
          </tfoot>

      </table>
    </body>
</html>
