<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['invoicecode'] == "" || $_GET['invoicecode'] == "") {
  $strExcelFileName = "RKSTMT_Billing.xls";
} else {
  $strExcelFileName = "RKSTMT_Billing" . $_GET['invoicecode'] . ".xls";
}

header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");


$condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "'  ";
$condBilling2 = "";
$condBilling3 = "";

$sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seBillings = array(
  array('select_pdfvehicletransportdocumentdriver-tmt', SQLSRV_PARAM_IN),
  array($condBilling1, SQLSRV_PARAM_IN),
  array($condBilling2, SQLSRV_PARAM_IN),
  array($condBilling3, SQLSRV_PARAM_IN)
);
$query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
$result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);

$sql_seMinvldate = "SELECT CONVERT(VARCHAR(10), MIN(VLINDATE), 103) AS 'MINDATEVLIN_103'
FROM [dbo].[LOGINVOICE]
WHERE 1 = 1 AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
$query_seMinvldate = sqlsrv_query($conn, $sql_seMinvldate, $params_seMinvldate);
$result_seMinvldate = sqlsrv_fetch_array($query_seMinvldate, SQLSRV_FETCH_ASSOC);

$sql_seMaxvldate = "SELECT CONVERT(VARCHAR(10), MAX(VLINDATE), 103) AS 'MAXDATEVLIN_103'
FROM [dbo].[LOGINVOICE]
WHERE 1 = 1 AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
$query_seMaxvldate = sqlsrv_query($conn, $sql_seMaxvldate, $params_seMaxvldate);
$result_seMaxvldate = sqlsrv_fetch_array($query_seMaxvldate, SQLSRV_FETCH_ASSOC);
?>

<style>
body{
  font-family: "Garuda";font-size:12px;
}
</style>



<table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
  <tbody>
    <tr style="border:1px solid #000;padding:4px;" >
      <td colspan="10" align="center"><b>DETAILS FOR TRIPS OF STM to TMT Samrong (ENGINE)</b></td>
    </tr>
    <tr style="border:1px solid #000;padding:4px;" >
      <td colspan="10" align="center"><b><u>(MONTH)</u> : <?= $result_seMinvldate['MINDATEVLIN_103'] ?> - <?= $result_seMaxvldate['MAXDATEVLIN_103'] ?></b></td>
    </tr>
  </tbody>
</table>

<table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
  <td colspan="10" align="center"></td>
</table>

<table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
  <tr>
    <td>
      <table id="bg-table" style="border-collapse: collapse;font-size:12;margin-top:8px;">
        <thead>
          <tr style="border:1px solid #000;padding:4px;">
            <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;">TOYOTA MOTOR THAILAND</td>
          </tr>
        </thead>
        <tbody>
          <tr style="border:1px solid #000;">
            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" >PATS LOGISTICS</td>
            <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;" >S 5</td>
          </tr>
          <tr style="border:1px solid #000;">
            <td colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
            <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
          </tr>
        </tbody>
      </table>
    </td>

    <td colspan="1" ></td>

    <td>
      <table id="bg-table"   style="border-collapse: collapse;font-size:12;margin-top:8px;">
        <thead>
          <tr style="border:1px solid #000;padding:4px;">
            <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">RUAMKIT RUNGRUENG SERVICES CO.,LTD.</td>
          </tr>
        </thead>
        <tbody>
          <tr style="border:1px solid #000;">
            <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">Issued By</td>
          </tr>
          <tr style="border:1px solid #000;">
            <td colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;" ><br><br><br><br></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;" ><br><br><br><br></td>
          </tr>
        </tbody>
      </table>
    </td>
  </tr>
</table>

<table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
  <td colspan="10" align="center"></td>
</table>


<table id="bg-table" style="border-collapse: collapse;font-size:10;margin-top:8px;font-size:12;">
  <thead>
    <tr style="border:1px solid #000;padding:4px;">
      <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>DATE</b></td>
      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ROUTE</b></td>
      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>6 Wheels</b></td>
      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>10 Wheels</b></td>
      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Extra Truck</b></td>
      <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>TOTAL</b></td>
    </tr>
  </thead><tbody>

    <?php
    $i = 1;


    $condPrice6w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '6W'";
    $condPrice6w2 = "";
    $sql_sePrice6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
    $params_sePrice6w = array(
      array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
      array($condPrice6w1, SQLSRV_PARAM_IN),
      array($condPrice6w2, SQLSRV_PARAM_IN)
    );
    $query_sePrice6w = sqlsrv_query($conn, $sql_sePrice6w, $params_sePrice6w);
    $result_sePrice6w = sqlsrv_fetch_array($query_sePrice6w, SQLSRV_FETCH_ASSOC);

    $condPrice10w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '10W'";
    $condPrice10w2 = "";
    $sql_sePrice10w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
    $params_sePrice10w = array(
      array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
      array($condPrice10w1, SQLSRV_PARAM_IN),
      array($condPrice10w2, SQLSRV_PARAM_IN)
    );
    $query_sePrice10w = sqlsrv_query($conn, $sql_sePrice10w, $params_sePrice10w);
    $result_sePrice10w = sqlsrv_fetch_array($query_sePrice10w, SQLSRV_FETCH_ASSOC);




    $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
    $params_seBilling = array(
      array('select_pdfvehicletransportdocumentdriver-tmt', SQLSRV_PARAM_IN),
      array($condBilling1, SQLSRV_PARAM_IN),
      array($condBilling2, SQLSRV_PARAM_IN),
      array($condBilling3, SQLSRV_PARAM_IN)
    );



    $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
    while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

      $condCnt11 = " AND CONVERT(DATE,a.DATEVLIN) = CONVERT(DATE,'" . $result_seBilling['DATEVLIN10'] . "')";
      $condCnt12 = " AND a.JOBSTART = '" . $result_seBilling['JOBSTART'] . "' AND a.ACTIVESTATUS = '1'";
      $condCnt13 = " AND a.STATUSNUMBER != '0' AND a.STATUSNUMBER != 'X' AND b.DOCUMENTCODE != ''";

      $sql_seCnt1 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
      $params_seCnt1 = array(
        array('select_count6wheels', SQLSRV_PARAM_IN),
        array($condCnt11, SQLSRV_PARAM_IN),
        array($condCnt12, SQLSRV_PARAM_IN),
        array($condCnt13, SQLSRV_PARAM_IN)
      );
      $query_seCnt1 = sqlsrv_query($conn, $sql_seCnt1, $params_seCnt1);
      $result_seCnt1 = sqlsrv_fetch_array($query_seCnt1, SQLSRV_FETCH_ASSOC);

      $sql_seCnt2 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
      $params_seCnt2 = array(
        array('select_count10wheels', SQLSRV_PARAM_IN),
        array($condCnt11, SQLSRV_PARAM_IN),
        array($condCnt12, SQLSRV_PARAM_IN),
        array($condCnt13, SQLSRV_PARAM_IN)
      );
      $query_seCnt2 = sqlsrv_query($conn, $sql_seCnt2, $params_seCnt2);
      $result_seCnt2 = sqlsrv_fetch_array($query_seCnt2, SQLSRV_FETCH_ASSOC);


      ?>


      <tr style="border:1px solid #000;">
        <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=  $result_seBilling['DATEVLIN10']  ?></td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling['TRANSPORTATION'] ?></td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seCnt1['count6wheels'] ?></td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seCnt2['count10wheels'] ?></td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= ($result_seCnt1['count6wheels'] + $result_seCnt2['count10wheels']) ?></td>


      </tr>
      <?php
      $i++;

      $sum6w = $sum6w + $result_seCnt1['count6wheels'];
      $sum10w = $sum10w + $result_seCnt2['count10wheels'];
    }

    ?>


  </tbody>
  <tfoot>
    <tr style="border:1px solid #000;">
      <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
      <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
    </tr>
    <tr style="border:1px solid #000;">
      <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
      <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
    </tr>
    <tr style="border:1px solid #000;">
      <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:left;"><b>Total Trip</b></td>
      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= $sum6w ?></b></td>
      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= $sum10w ?></b></td>
      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>0</b></td>
      <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= ($sum6w + $sum10w) ?></b></td>

    </tr>

    <tr style="border:1px solid #000;">
      <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:left;"><b>Cost 6 Wheels/Trip</b></td>
      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= $sum6w ?></b></td>
      <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= number_format($result_sePrice6w['ACTUALPRICE']) ?></b></td>
      <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= number_format(($sum6w * $result_sePrice6w['ACTUALPRICE'])) ?></b></td>

    </tr>
    <tr style="border:1px solid #000;">
      <td  colspan="3" style="border-right:1px solid #000;padding:4px;text-align:left;" ><b>Amount</b></td>
      <td  colspan="7" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b><?= number_format(($sum6w * $result_sePrice6w['ACTUALPRICE'])) ?></td>

      </tr>
      <tr style="border:1px solid #000;">
        <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:left;" ><b>Cost 10 Wheels/Trip</b></td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= $sum10w ?></b></td>
        <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b><?= number_format($result_sePrice10w['ACTUALPRICE']) ?></b></td>
        <td colspan="1" dropzone=""style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= number_format(($sum10w * $result_sePrice10w['ACTUALPRICE'])) ?></b></td>

      </tr>
      <tr style="border:1px solid #000;">
        <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:left;" ><b>Amount</b></td>
        <td colspan="7" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b><?= number_format(($sum10w * $result_sePrice10w['ACTUALPRICE'])) ?></b></td>
      </tr>
      <tr style="border:1px solid #000;">
        <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:left;" ><b>Total Amount</b></td>
        <td colspan="7" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b><?= number_format(($sum6w * $result_sePrice6w['ACTUALPRICE']) + ($sum10w * $result_sePrice10w['ACTUALPRICE'])) ?></b></td>
      </tr>

    </tfoot>
  </table>
  <table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
    <td colspan="10" align="center"></td>
  </table>
  <table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
    <td colspan="10" align="center"></td>
  </table>

  <!-- /////////////////////////////////////WEEK 1 //////////////////////////////////////////-->
  <?php
  $sql_seWeek1 = "SELECT DISTINCT BILLINGDATE,PAYMENTDATE FROM LOGINVOICE WHERE REMARK = 1 AND INVOICECODE = RTRIM('" . $_GET['invoicecode'] . "')";
  $query_seWeek1 = sqlsrv_query($conn, $sql_seWeek1, $params_seWeek1);
  $result_seWeek1 = sqlsrv_fetch_array($query_seWeek1, SQLSRV_FETCH_ASSOC);

  if ($result_seWeek1['BILLINGDATE'] != '') {

    ?>


    <table id="bg-table"  style="border-collapse: collapse;font-size:16;margin-top:8px;">
      <tbody>
        <tr style="border:1px solid #000;padding:4px;" >
          <td colspan="10" align="center"><b>DETAILS FOR TRIPS OF STM to TMT Samrong (ENGINE)</b></td>
        </tr>
        <tr style="border:1px solid #000;padding:4px;" >
          <td colspan="10" align="center"><b>(WEEK) : <?= $result_seWeek1['BILLINGDATE'] ?> - <?= $result_seWeek1['PAYMENTDATE'] ?></b></td>
        </tr>
      </tbody>
    </table>

    <table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
      <td colspan="10" align="center"></td>
    </table>

    <table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
      <tr>
        <td>
          <table id="bg-table" style="border-collapse: collapse;font-size:12;margin-top:8px;">
            <thead>
              <tr style="border:1px solid #000;padding:4px;">
                <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;">TOYOTA MOTOR THAILAND</td>
              </tr>
            </thead>
            <tbody>
              <tr style="border:1px solid #000;">
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" >PATS LOGISTICS</td>
                <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;" >S 5</td>
              </tr>
              <tr style="border:1px solid #000;">
                <td colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
                <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
              </tr>
            </tbody>
          </table>
        </td>

        <td colspan="1" ></td>

        <td>
          <table id="bg-table"   style="border-collapse: collapse;font-size:12;margin-top:8px;">
            <thead>
              <tr style="border:1px solid #000;padding:4px;">
                <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">RUAMKIT RUNGRUENG SERVICES CO.,LTD.</td>
              </tr>
            </thead>
            <tbody>
              <tr style="border:1px solid #000;">
                <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">Issued By</td>
              </tr>
              <tr style="border:1px solid #000;">
                <td colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;" ><br><br><br><br></td>
                <td colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;" ><br><br><br><br></td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </table>


      <table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
        <td colspan="10" align="center"></td>
      </table>

      <table id="bg-table"  style="border-collapse: collapse;font-size:10;margin-top:8px;font-size:12;">
        <thead>
          <tr style="border:1px solid #000;padding:4px;">
            <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>DATE</b></td>
            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ROUTE</b></td>
            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>6 Wheels</b></td>
            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>10 Wheels</b></td>
            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Extra Truck</b></td>
            <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>TOTAL</b></td>
          </tr>
        </thead><tbody>

          <?php
          $i = 1;


          $condPrice6w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '6W'";
          $condPrice6w2 = "";
          $sql_sePrice6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
          $params_sePrice6w = array(
            array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
            array($condPrice6w1, SQLSRV_PARAM_IN),
            array($condPrice6w2, SQLSRV_PARAM_IN)
          );
          $query_sePrice6w = sqlsrv_query($conn, $sql_sePrice6w, $params_sePrice6w);
          $result_sePrice6w = sqlsrv_fetch_array($query_sePrice6w, SQLSRV_FETCH_ASSOC);

          $condPrice10w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '10W'";
          $condPrice10w2 = "";
          $sql_sePrice10w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
          $params_sePrice10w = array(
            array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
            array($condPrice10w1, SQLSRV_PARAM_IN),
            array($condPrice10w2, SQLSRV_PARAM_IN)
          );
          $query_sePrice10w = sqlsrv_query($conn, $sql_sePrice10w, $params_sePrice10w);
          $result_sePrice10w = sqlsrv_fetch_array($query_sePrice10w, SQLSRV_FETCH_ASSOC);




          $condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
          $condBilling2 = " AND a.BILLINGDATE = '" . $result_seWeek1['BILLINGDATE'] . "' AND a.PAYMENTDATE = '" . $result_seWeek1['PAYMENTDATE'] . "'";
          $condBilling3 = "";
          $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
          $params_seBilling = array(
            array('select_pdfvehicletransportdocumentdriver-tmt', SQLSRV_PARAM_IN),
            array($condBilling1, SQLSRV_PARAM_IN),
            array($condBilling2, SQLSRV_PARAM_IN),
            array($condBilling3, SQLSRV_PARAM_IN)
          );



          $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
          while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

            $condCnt11 = " AND CONVERT(DATE,a.DATEVLIN) = CONVERT(DATE,'" . $result_seBilling['DATEVLIN10'] . "')";
            $condCnt12 = " AND a.JOBSTART = '" . $result_seBilling['JOBSTART'] . "' AND a.ACTIVESTATUS = '1'";
            $condCnt13 = " AND a.STATUSNUMBER != '0' AND a.STATUSNUMBER != 'X' AND b.DOCUMENTCODE != ''";

            $sql_seCnt1 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
            $params_seCnt1 = array(
              array('select_count6wheels', SQLSRV_PARAM_IN),
              array($condCnt11, SQLSRV_PARAM_IN),
              array($condCnt12, SQLSRV_PARAM_IN),
              array($condCnt13, SQLSRV_PARAM_IN)
            );
            $query_seCnt1 = sqlsrv_query($conn, $sql_seCnt1, $params_seCnt1);
            $result_seCnt1 = sqlsrv_fetch_array($query_seCnt1, SQLSRV_FETCH_ASSOC);

            $sql_seCnt2 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
            $params_seCnt2 = array(
              array('select_count10wheels', SQLSRV_PARAM_IN),
              array($condCnt11, SQLSRV_PARAM_IN),
              array($condCnt12, SQLSRV_PARAM_IN),
              array($condCnt13, SQLSRV_PARAM_IN)
            );
            $query_seCnt2 = sqlsrv_query($conn, $sql_seCnt2, $params_seCnt2);
            $result_seCnt2 = sqlsrv_fetch_array($query_seCnt2, SQLSRV_FETCH_ASSOC);
            ?>

            <tr style="border:1px solid #000;">
              <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling['DATEVLIN10'] ?></td>
              <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling['TRANSPORTATION'] ?></td>
              <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seCnt1['count6wheels'] ?></td>
              <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seCnt2['count10wheels'] ?></td>
              <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
              <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= ($result_seCnt1['count6wheels'] + $result_seCnt2['count10wheels']) ?></td>
            </tr>

            <?php
            $i++;

            $sum6w1 = $sum6w1 + $result_seCnt1['count6wheels'];
            $sum10w1 = $sum10w1 + $result_seCnt2['count10wheels'];
          }

          ?>



        </tbody>
        <tfoot>
          <tr style="border:1px solid #000;">
            <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
            <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
          </tr>
          <tr style="border:1px solid #000;">
            <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
            <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
          </tr>
          <tr style="border:1px solid #000;">
            <td colspan="3"style="border-right:1px solid #000;padding:4px;text-align:left;"><b>Total Trip</b></td>
            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= $sum6w1 ?></b></td>
            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= $sum10w1 ?></b></td>
            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>0</b></td>
            <td colspan="1"style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= ($sum6w1 + $sum10w1) ?></b></td>

          </tr>



        </tfoot>
      </table>

        <!-- /////////////////////////////////////WEEK 2 //////////////////////////////////////////-->
      <?php
    }


    $sql_seWeek2 = "SELECT DISTINCT BILLINGDATE,PAYMENTDATE FROM LOGINVOICE WHERE REMARK = 2 AND INVOICECODE = RTRIM('" . $_GET['invoicecode'] . "')";
    $query_seWeek2 = sqlsrv_query($conn, $sql_seWeek2, $params_seWeek2);
    $result_seWeek2 = sqlsrv_fetch_array($query_seWeek2, SQLSRV_FETCH_ASSOC);
    if ($result_seWeek2['BILLINGDATE'] != '') {

      ?>

      <table id="bg-table"  style="border-collapse: collapse;font-size:16;margin-top:8px;">
        <tbody>
          <tr style="border:1px solid #000;padding:4px;" >
            <td colspan="10" align="center"><b>DETAILS FOR TRIPS OF STM to TMT Samrong (ENGINE)</b></td>
          </tr>
          <tr style="border:1px solid #000;padding:4px;" >
            <td colspan="10" align="center"><b>(WEEK) : <?= $result_seWeek1['BILLINGDATE'] ?> - <?= $result_seWeek1['PAYMENTDATE'] ?></b></td>
          </tr>
        </tbody>
      </table>

      <table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
        <td colspan="10" align="center"></td>
      </table>

      <table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
        <tr>
          <td>
            <table id="bg-table" style="border-collapse: collapse;font-size:12;margin-top:8px;">
              <thead>
                <tr style="border:1px solid #000;padding:4px;">
                  <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;">TOYOTA MOTOR THAILAND</td>
                </tr>
              </thead>
              <tbody>
                <tr style="border:1px solid #000;">
                  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" >PATS LOGISTICS</td>
                  <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;" >S 5</td>
                </tr>
                <tr style="border:1px solid #000;">
                  <td colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
                  <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
                </tr>
              </tbody>
            </table>
          </td>

          <td colspan="1" ></td>

          <td>
            <table id="bg-table"   style="border-collapse: collapse;font-size:12;margin-top:8px;">
              <thead>
                <tr style="border:1px solid #000;padding:4px;">
                  <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">RUAMKIT RUNGRUENG SERVICES CO.,LTD.</td>
                </tr>
              </thead>
              <tbody>
                <tr style="border:1px solid #000;">
                  <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">Issued By</td>
                </tr>
                <tr style="border:1px solid #000;">
                  <td colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;" ><br><br><br><br></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;" ><br><br><br><br></td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </table>


        <table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
          <td colspan="10" align="center"></td>
        </table>

        <table id="bg-table"  style="border-collapse: collapse;font-size:10;margin-top:8px;font-size:12;">
          <thead>
            <tr style="border:1px solid #000;padding:4px;">
              <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>DATE</b></td>
              <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ROUTE</b></td>
              <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>6 Wheels</b></td>
              <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>10 Wheels</b></td>
              <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Extra Truck</b></td>
              <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>TOTAL</b></td>
            </tr>
          </thead><tbody>

            <?php
            $i = 1;


            $condPrice6w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '6W'";
            $condPrice6w2 = "";
            $sql_sePrice6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
            $params_sePrice6w = array(
              array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
              array($condPrice6w1, SQLSRV_PARAM_IN),
              array($condPrice6w2, SQLSRV_PARAM_IN)
            );
            $query_sePrice6w = sqlsrv_query($conn, $sql_sePrice6w, $params_sePrice6w);
            $result_sePrice6w = sqlsrv_fetch_array($query_sePrice6w, SQLSRV_FETCH_ASSOC);

            $condPrice10w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '10W'";
            $condPrice10w2 = "";
            $sql_sePrice10w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
            $params_sePrice10w = array(
              array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
              array($condPrice10w1, SQLSRV_PARAM_IN),
              array($condPrice10w2, SQLSRV_PARAM_IN)
            );
            $query_sePrice10w = sqlsrv_query($conn, $sql_sePrice10w, $params_sePrice10w);
            $result_sePrice10w = sqlsrv_fetch_array($query_sePrice10w, SQLSRV_FETCH_ASSOC);



            $condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
            $condBilling2 = " AND a.BILLINGDATE = '" . $result_seWeek2['BILLINGDATE'] . "' AND a.PAYMENTDATE = '" . $result_seWeek2['PAYMENTDATE'] . "'";
            $condBilling3 = "";
            $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
            $params_seBilling = array(
              array('select_pdfvehicletransportdocumentdriver-tmt', SQLSRV_PARAM_IN),
              array($condBilling1, SQLSRV_PARAM_IN),
              array($condBilling2, SQLSRV_PARAM_IN),
              array($condBilling3, SQLSRV_PARAM_IN)
            );



            $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
            while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

              $condCnt11 = " AND CONVERT(DATE,a.DATEVLIN) = CONVERT(DATE,'" . $result_seBilling['DATEVLIN10'] . "')";
              $condCnt12 = " AND a.JOBSTART = '" . $result_seBilling['JOBSTART'] . "' ";

              $sql_seCnt1 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
              $params_seCnt1 = array(
                array('select_count6wheels', SQLSRV_PARAM_IN),
                array($condCnt11, SQLSRV_PARAM_IN),
                array($condCnt12, SQLSRV_PARAM_IN),
                array('', SQLSRV_PARAM_IN)
              );
              $query_seCnt1 = sqlsrv_query($conn, $sql_seCnt1, $params_seCnt1);
              $result_seCnt1 = sqlsrv_fetch_array($query_seCnt1, SQLSRV_FETCH_ASSOC);

              $sql_seCnt2 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
              $params_seCnt2 = array(
                array('select_count10wheels', SQLSRV_PARAM_IN),
                array($condCnt11, SQLSRV_PARAM_IN),
                array($condCnt12, SQLSRV_PARAM_IN),
                array($condCnt13, SQLSRV_PARAM_IN)
              );
              $query_seCnt2 = sqlsrv_query($conn, $sql_seCnt2, $params_seCnt2);
              $result_seCnt2 = sqlsrv_fetch_array($query_seCnt2, SQLSRV_FETCH_ASSOC);
              ?>



              <tr style="border:1px solid #000;">
                <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling['DATEVLIN10'] ?></td>
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling['TRANSPORTATION'] ?></td>
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seCnt1['count6wheels'] ?></td>
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seCnt2['count10wheels'] ?></td>
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= ($result_seCnt1['count6wheels'] + $result_seCnt2['count10wheels']) ?></td>
              </tr>

              <?php
              $i++;

              $sum6w2 = $sum6w2 + $result_seCnt1['count6wheels'];
              $sum10w2 = $sum10w2 + $result_seCnt2['count10wheels'];
            }
            ?>


          </tbody>
          <tfoot>
            <tr style="border:1px solid #000;">
              <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
              <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
              <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
              <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
              <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
              <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
            </tr>
            <tr style="border:1px solid #000;">
              <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
              <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
              <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
              <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
              <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
              <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
            </tr>
            <tr style="border:1px solid #000;">
              <td colspan="3"style="border-right:1px solid #000;padding:4px;text-align:left;"><b>Total Trip</b></td>
              <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= $sum6w1 ?></b></td>
              <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= $sum10w1 ?></b></td>
              <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>0</b></td>
              <td colspan="1"style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= ($sum6w1 + $sum10w1) ?></b></td>

            </tr>



          </tfoot>
        </table>

  <!-- /////////////////////////////////////WEEK 3 //////////////////////////////////////////-->

        <?php
      }

      $sql_seWeek3 = "SELECT DISTINCT BILLINGDATE,PAYMENTDATE FROM LOGINVOICE WHERE REMARK = 3 AND INVOICECODE = RTRIM('" . $_GET['invoicecode'] . "')";
      $query_seWeek3 = sqlsrv_query($conn, $sql_seWeek3, $params_seWeek3);
      $result_seWeek3 = sqlsrv_fetch_array($query_seWeek3, SQLSRV_FETCH_ASSOC);
      if ($result_seWeek3['BILLINGDATE'] != '') {
        ?>


        <table id="bg-table"  style="border-collapse: collapse;font-size:16;margin-top:8px;">
          <tbody>
            <tr style="border:1px solid #000;padding:4px;" >
              <td colspan="10" align="center"><b>DETAILS FOR TRIPS OF STM to TMT Samrong (ENGINE)</b></td>
            </tr>
            <tr style="border:1px solid #000;padding:4px;" >
              <td colspan="10" align="center"><b>(WEEK) : <?= $result_seWeek1['BILLINGDATE'] ?> - <?= $result_seWeek1['PAYMENTDATE'] ?></b></td>
            </tr>
          </tbody>
        </table>

        <table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
          <td colspan="10" align="center"></td>
        </table>

        <table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
          <tr>
            <td>
              <table id="bg-table" style="border-collapse: collapse;font-size:12;margin-top:8px;">
                <thead>
                  <tr style="border:1px solid #000;padding:4px;">
                    <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;">TOYOTA MOTOR THAILAND</td>
                  </tr>
                </thead>
                <tbody>
                  <tr style="border:1px solid #000;">
                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" >PATS LOGISTICS</td>
                    <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;" >S 5</td>
                  </tr>
                  <tr style="border:1px solid #000;">
                    <td colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
                    <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
                  </tr>
                </tbody>
              </table>
            </td>

            <td colspan="1" ></td>

            <td>
              <table id="bg-table"   style="border-collapse: collapse;font-size:12;margin-top:8px;">
                <thead>
                  <tr style="border:1px solid #000;padding:4px;">
                    <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">RUAMKIT RUNGRUENG SERVICES CO.,LTD.</td>
                  </tr>
                </thead>
                <tbody>
                  <tr style="border:1px solid #000;">
                    <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">Issued By</td>
                  </tr>
                  <tr style="border:1px solid #000;">
                    <td colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;" ><br><br><br><br></td>
                    <td colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;" ><br><br><br><br></td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
        </table>


          <table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
            <td colspan="10" align="center"></td>
          </table>

          <table id="bg-table"  style="border-collapse: collapse;font-size:10;margin-top:8px;font-size:12;">
            <thead>
              <tr style="border:1px solid #000;padding:4px;">
                <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>DATE</b></td>
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ROUTE</b></td>
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>6 Wheels</b></td>
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>10 Wheels</b></td>
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Extra Truck</b></td>
                <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>TOTAL</b></td>
              </tr>
            </thead><tbody>
              <?php
              $i = 1;


              $condPrice6w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '6W'";
              $condPrice6w2 = "";
              $sql_sePrice6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
              $params_sePrice6w = array(
                array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
                array($condPrice6w1, SQLSRV_PARAM_IN),
                array($condPrice6w2, SQLSRV_PARAM_IN)
              );
              $query_sePrice6w = sqlsrv_query($conn, $sql_sePrice6w, $params_sePrice6w);
              $result_sePrice6w = sqlsrv_fetch_array($query_sePrice6w, SQLSRV_FETCH_ASSOC);

              $condPrice10w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '10W'";
              $condPrice10w2 = "";
              $sql_sePrice10w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
              $params_sePrice10w = array(
                array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
                array($condPrice10w1, SQLSRV_PARAM_IN),
                array($condPrice10w2, SQLSRV_PARAM_IN)
              );
              $query_sePrice10w = sqlsrv_query($conn, $sql_sePrice10w, $params_sePrice10w);
              $result_sePrice10w = sqlsrv_fetch_array($query_sePrice10w, SQLSRV_FETCH_ASSOC);



              $condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
              $condBilling2 = " AND a.BILLINGDATE = '" . $result_seWeek3['BILLINGDATE'] . "' AND a.PAYMENTDATE = '" . $result_seWeek3['PAYMENTDATE'] . "'";
              $condBilling3 = "";
              $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
              $params_seBilling = array(
                array('select_pdfvehicletransportdocumentdriver-tmt', SQLSRV_PARAM_IN),
                array($condBilling1, SQLSRV_PARAM_IN),
                array($condBilling2, SQLSRV_PARAM_IN),
                array($condBilling3, SQLSRV_PARAM_IN)
              );



              $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
              while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

                $condCnt11 = " AND CONVERT(DATE,a.DATEVLIN) = CONVERT(DATE,'" . $result_seBilling['DATEVLIN10'] . "')";
                $condCnt12 = " AND a.JOBSTART = '" . $result_seBilling['JOBSTART'] . "' ";

                $sql_seCnt1 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
                $params_seCnt1 = array(
                  array('select_count6wheels', SQLSRV_PARAM_IN),
                  array($condCnt11, SQLSRV_PARAM_IN),
                  array($condCnt12, SQLSRV_PARAM_IN),
                  array('', SQLSRV_PARAM_IN)
                );
                $query_seCnt1 = sqlsrv_query($conn, $sql_seCnt1, $params_seCnt1);
                $result_seCnt1 = sqlsrv_fetch_array($query_seCnt1, SQLSRV_FETCH_ASSOC);

                $sql_seCnt2 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
                $params_seCnt2 = array(
                  array('select_count10wheels', SQLSRV_PARAM_IN),
                  array($condCnt11, SQLSRV_PARAM_IN),
                  array($condCnt12, SQLSRV_PARAM_IN),
                  array($condCnt13, SQLSRV_PARAM_IN)
                );
                $query_seCnt2 = sqlsrv_query($conn, $sql_seCnt2, $params_seCnt2);
                $result_seCnt2 = sqlsrv_fetch_array($query_seCnt2, SQLSRV_FETCH_ASSOC);
                ?>



                <tr style="border:1px solid #000;">
                  <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling['DATEVLIN10'] ?></td>
                  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling['TRANSPORTATION'] ?></td>
                  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seCnt1['count6wheels'] ?></td>
                  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seCnt2['count10wheels'] ?></td>
                  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                  <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= ($result_seCnt1['count6wheels'] + $result_seCnt2['count10wheels']) ?></td>
                </tr>

                <?php
                $i++;

                $sum6w3 = $sum6w3 + $result_seCnt1['count6wheels'];
                $sum10w3 = $sum10w3 + $result_seCnt2['count10wheels'];
              }
              ?>



            </tbody>
            <tfoot>
              <tr style="border:1px solid #000;">
                <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
              </tr>
              <tr style="border:1px solid #000;">
                <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
              </tr>
              <tr style="border:1px solid #000;">
                <td colspan="3"style="border-right:1px solid #000;padding:4px;text-align:left;"><b>Total Trip</b></td>
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= $sum6w1 ?></b></td>
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= $sum10w1 ?></b></td>
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>0</b></td>
                <td colspan="1"style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= ($sum6w1 + $sum10w1) ?></b></td>

              </tr>



            </tfoot>
          </table>

            <!-- /////////////////////////////////////WEEK 4 //////////////////////////////////////////-->

          <?php
        }
        $sql_seWeek4 = "SELECT DISTINCT BILLINGDATE,PAYMENTDATE FROM LOGINVOICE WHERE REMARK = 4 AND INVOICECODE = RTRIM('" . $_GET['invoicecode'] . "')";
        $query_seWeek4 = sqlsrv_query($conn, $sql_seWeek4, $params_seWeek4);
        $result_seWeek4 = sqlsrv_fetch_array($query_seWeek4, SQLSRV_FETCH_ASSOC);
        if ($result_seWeek4['BILLINGDATE'] != '') {
          ?>


          <table id="bg-table"  style="border-collapse: collapse;font-size:16;margin-top:8px;">
            <tbody>
              <tr style="border:1px solid #000;padding:4px;" >
                <td colspan="10" align="center"><b>DETAILS FOR TRIPS OF STM to TMT Samrong (ENGINE)</b></td>
              </tr>
              <tr style="border:1px solid #000;padding:4px;" >
                <td colspan="10" align="center"><b>(WEEK) : <?= $result_seWeek1['BILLINGDATE'] ?> - <?= $result_seWeek1['PAYMENTDATE'] ?></b></td>
              </tr>
            </tbody>
          </table>

          <table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
            <td colspan="10" align="center"></td>
          </table>

          <table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
            <tr>
              <td>
                <table id="bg-table" style="border-collapse: collapse;font-size:12;margin-top:8px;">
                  <thead>
                    <tr style="border:1px solid #000;padding:4px;">
                      <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;">TOYOTA MOTOR THAILAND</td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr style="border:1px solid #000;">
                      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" >PATS LOGISTICS</td>
                      <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;" >S 5</td>
                    </tr>
                    <tr style="border:1px solid #000;">
                      <td colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
                      <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
                    </tr>
                  </tbody>
                </table>
              </td>

              <td colspan="1" ></td>

              <td>
                <table id="bg-table"   style="border-collapse: collapse;font-size:12;margin-top:8px;">
                  <thead>
                    <tr style="border:1px solid #000;padding:4px;">
                      <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">RUAMKIT RUNGRUENG SERVICES CO.,LTD.</td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr style="border:1px solid #000;">
                      <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">Issued By</td>
                    </tr>
                    <tr style="border:1px solid #000;">
                      <td colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;" ><br><br><br><br></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;" ><br><br><br><br></td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </table>


            <table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
              <td colspan="10" align="center"></td>
            </table>

            <table id="bg-table"  style="border-collapse: collapse;font-size:10;margin-top:8px;font-size:12;">
              <thead>
                <tr style="border:1px solid #000;padding:4px;">
                  <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>DATE</b></td>
                  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ROUTE</b></td>
                  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>6 Wheels</b></td>
                  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>10 Wheels</b></td>
                  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Extra Truck</b></td>
                  <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>TOTAL</b></td>
                </tr>
              </thead><tbody>
                <?php
                $i = 1;


                $condPrice6w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '6W'";
                $condPrice6w2 = "";
                $sql_sePrice6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                $params_sePrice6w = array(
                  array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
                  array($condPrice6w1, SQLSRV_PARAM_IN),
                  array($condPrice6w2, SQLSRV_PARAM_IN)
                );
                $query_sePrice6w = sqlsrv_query($conn, $sql_sePrice6w, $params_sePrice6w);
                $result_sePrice6w = sqlsrv_fetch_array($query_sePrice6w, SQLSRV_FETCH_ASSOC);

                $condPrice10w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '10W'";
                $condPrice10w2 = "";
                $sql_sePrice10w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                $params_sePrice10w = array(
                  array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
                  array($condPrice10w1, SQLSRV_PARAM_IN),
                  array($condPrice10w2, SQLSRV_PARAM_IN)
                );
                $query_sePrice10w = sqlsrv_query($conn, $sql_sePrice10w, $params_sePrice10w);
                $result_sePrice10w = sqlsrv_fetch_array($query_sePrice10w, SQLSRV_FETCH_ASSOC);



                $condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
                $condBilling2 = " AND a.BILLINGDATE = '" . $result_seWeek4['BILLINGDATE'] . "' AND a.PAYMENTDATE = '" . $result_seWeek4['PAYMENTDATE'] . "'";
                $condBilling3 = "";
                $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
                $params_seBilling = array(
                  array('select_pdfvehicletransportdocumentdriver-tmt', SQLSRV_PARAM_IN),
                  array($condBilling1, SQLSRV_PARAM_IN),
                  array($condBilling2, SQLSRV_PARAM_IN),
                  array($condBilling3, SQLSRV_PARAM_IN)
                );



                $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

                  $condCnt11 = " AND CONVERT(DATE,a.DATEVLIN) = CONVERT(DATE,'" . $result_seBilling['DATEVLIN10'] . "')";
                  $condCnt12 = " AND a.JOBSTART = '" . $result_seBilling['JOBSTART'] . "' ";

                  $sql_seCnt1 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
                  $params_seCnt1 = array(
                    array('select_count6wheels', SQLSRV_PARAM_IN),
                    array($condCnt11, SQLSRV_PARAM_IN),
                    array($condCnt12, SQLSRV_PARAM_IN),
                    array('', SQLSRV_PARAM_IN)
                  );
                  $query_seCnt1 = sqlsrv_query($conn, $sql_seCnt1, $params_seCnt1);
                  $result_seCnt1 = sqlsrv_fetch_array($query_seCnt1, SQLSRV_FETCH_ASSOC);

                  $sql_seCnt2 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
                  $params_seCnt2 = array(
                    array('select_count10wheels', SQLSRV_PARAM_IN),
                    array($condCnt11, SQLSRV_PARAM_IN),
                    array($condCnt12, SQLSRV_PARAM_IN),
                    array($condCnt13, SQLSRV_PARAM_IN)
                  );
                  $query_seCnt2 = sqlsrv_query($conn, $sql_seCnt2, $params_seCnt2);
                  $result_seCnt2 = sqlsrv_fetch_array($query_seCnt2, SQLSRV_FETCH_ASSOC);
                  ?>

                  <tr style="border:1px solid #000;">
                    <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling['DATEVLIN10'] ?></td>
                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling['TRANSPORTATION'] ?></td>
                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seCnt1['count6wheels'] ?></td>
                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seCnt2['count10wheels'] ?></td>
                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= ($result_seCnt1['count6wheels'] + $result_seCnt2['count10wheels']) ?></td>
                  </tr>

                  <?php
                  $i++;

                  $sum6w4 = $sum6w4 + $result_seCnt1['count6wheels'];
                  $sum10w4 = $sum10w4 + $result_seCnt2['count10wheels'];
                }
                ?>



              </tbody>
              <tfoot>
                <tr style="border:1px solid #000;">
                  <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                  <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                </tr>
                <tr style="border:1px solid #000;">
                  <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                  <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                </tr>
                <tr style="border:1px solid #000;">
                  <td colspan="3"style="border-right:1px solid #000;padding:4px;text-align:left;"><b>Total Trip</b></td>
                  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= $sum6w1 ?></b></td>
                  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= $sum10w1 ?></b></td>
                  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>0</b></td>
                  <td colspan="1"style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= ($sum6w1 + $sum10w1) ?></b></td>

                </tr>



              </tfoot>
            </table>

              <!-- /////////////////////////////////////WEEK 5 //////////////////////////////////////////-->

            <?php
          }
          $sql_seWeek5 = "SELECT DISTINCT BILLINGDATE,PAYMENTDATE FROM LOGINVOICE WHERE REMARK = 5 AND INVOICECODE = RTRIM('" . $_GET['invoicecode'] . "')";
          $query_seWeek5 = sqlsrv_query($conn, $sql_seWeek5, $params_seWeek5);
          $result_seWeek5 = sqlsrv_fetch_array($query_seWeek5, SQLSRV_FETCH_ASSOC);
          if ($result_seWeek5['BILLINGDATE'] != '') {
            ?>


            <table id="bg-table"  style="border-collapse: collapse;font-size:16;margin-top:8px;">
              <tbody>
                <tr style="border:1px solid #000;padding:4px;" >
                  <td colspan="10" align="center"><b>DETAILS FOR TRIPS OF STM to TMT Samrong (ENGINE)</b></td>
                </tr>
                <tr style="border:1px solid #000;padding:4px;" >
                  <td colspan="10" align="center"><b>(WEEK) : <?= $result_seWeek1['BILLINGDATE'] ?> - <?= $result_seWeek1['PAYMENTDATE'] ?></b></td>
                </tr>
              </tbody>
            </table>

            <table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
              <td colspan="10" align="center"></td>
            </table>

            <table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
              <tr>
                <td>
                  <table id="bg-table" style="border-collapse: collapse;font-size:12;margin-top:8px;">
                    <thead>
                      <tr style="border:1px solid #000;padding:4px;">
                        <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;">TOYOTA MOTOR THAILAND</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr style="border:1px solid #000;">
                        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" >PATS LOGISTICS</td>
                        <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;" >S 5</td>
                      </tr>
                      <tr style="border:1px solid #000;">
                        <td colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
                        <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
                      </tr>
                    </tbody>
                  </table>
                </td>

                <td colspan="1" ></td>

                <td>
                  <table id="bg-table"   style="border-collapse: collapse;font-size:12;margin-top:8px;">
                    <thead>
                      <tr style="border:1px solid #000;padding:4px;">
                        <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">RUAMKIT RUNGRUENG SERVICES CO.,LTD.</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr style="border:1px solid #000;">
                        <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">Issued By</td>
                      </tr>
                      <tr style="border:1px solid #000;">
                        <td colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;" ><br><br><br><br></td>
                        <td colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;" ><br><br><br><br></td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </table>


              <table id="bg-table" style="border-collapse: collapse;font-size:16;margin-top:8px;">
                <td colspan="10" align="center"></td>
              </table>

              <table id="bg-table"  style="border-collapse: collapse;font-size:10;margin-top:8px;font-size:12;">
                <thead>
                  <tr style="border:1px solid #000;padding:4px;">
                    <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>DATE</b></td>
                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ROUTE</b></td>
                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>6 Wheels</b></td>
                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>10 Wheels</b></td>
                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Extra Truck</b></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>TOTAL</b></td>
                  </tr>
                </thead><tbody>
                  <?php
                  $i = 1;


                  $condPrice6w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '6W'";
                  $condPrice6w2 = "";
                  $sql_sePrice6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                  $params_sePrice6w = array(
                    array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
                    array($condPrice6w1, SQLSRV_PARAM_IN),
                    array($condPrice6w2, SQLSRV_PARAM_IN)
                  );
                  $query_sePrice6w = sqlsrv_query($conn, $sql_sePrice6w, $params_sePrice6w);
                  $result_sePrice6w = sqlsrv_fetch_array($query_sePrice6w, SQLSRV_FETCH_ASSOC);

                  $condPrice10w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '10W'";
                  $condPrice10w2 = "";
                  $sql_sePrice10w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                  $params_sePrice10w = array(
                    array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
                    array($condPrice10w1, SQLSRV_PARAM_IN),
                    array($condPrice10w2, SQLSRV_PARAM_IN)
                  );
                  $query_sePrice10w = sqlsrv_query($conn, $sql_sePrice10w, $params_sePrice10w);
                  $result_sePrice10w = sqlsrv_fetch_array($query_sePrice10w, SQLSRV_FETCH_ASSOC);



                  $condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
                  $condBilling2 = " AND a.BILLINGDATE = '" . $result_seWeek5['BILLINGDATE'] . "' AND a.PAYMENTDATE = '" . $result_seWeek5['PAYMENTDATE'] . "'";
                  $condBilling3 = "";
                  $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
                  $params_seBilling = array(
                    array('select_pdfvehicletransportdocumentdriver-tmt', SQLSRV_PARAM_IN),
                    array($condBilling1, SQLSRV_PARAM_IN),
                    array($condBilling2, SQLSRV_PARAM_IN),
                    array($condBilling3, SQLSRV_PARAM_IN)
                  );



                  $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                  while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

                    $condCnt11 = " AND CONVERT(DATE,a.DATEVLIN) = CONVERT(DATE,'" . $result_seBilling['DATEVLIN10'] . "')";
                    $condCnt12 = " AND a.JOBSTART = '" . $result_seBilling['JOBSTART'] . "' ";

                    $sql_seCnt1 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
                    $params_seCnt1 = array(
                      array('select_count6wheels', SQLSRV_PARAM_IN),
                      array($condCnt11, SQLSRV_PARAM_IN),
                      array($condCnt12, SQLSRV_PARAM_IN),
                      array('', SQLSRV_PARAM_IN)
                    );
                    $query_seCnt1 = sqlsrv_query($conn, $sql_seCnt1, $params_seCnt1);
                    $result_seCnt1 = sqlsrv_fetch_array($query_seCnt1, SQLSRV_FETCH_ASSOC);

                    $sql_seCnt2 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
                    $params_seCnt2 = array(
                      array('select_count10wheels', SQLSRV_PARAM_IN),
                      array($condCnt11, SQLSRV_PARAM_IN),
                      array($condCnt12, SQLSRV_PARAM_IN),
                      array($condCnt13, SQLSRV_PARAM_IN)
                    );
                    $query_seCnt2 = sqlsrv_query($conn, $sql_seCnt2, $params_seCnt2);
                    $result_seCnt2 = sqlsrv_fetch_array($query_seCnt2, SQLSRV_FETCH_ASSOC);
                    ?>

                    <tr style="border:1px solid #000;">
                      <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling['DATEVLIN10'] ?></td>
                      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling['TRANSPORTATION'] ?></td>
                      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seCnt1['count6wheels'] ?></td>
                      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seCnt2['count10wheels'] ?></td>
                      <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                      <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= ($result_seCnt1['count6wheels'] + $result_seCnt2['count10wheels']) ?></td>
                    </tr>

                    <?php
                    $i++;

                    $sum6w5 = $sum6w5 + $result_seCnt1['count6wheels'];
                    $sum10w5 = $sum10w5 + $result_seCnt2['count10wheels'];
                  }
                  ?>



                </tbody>
                <tfoot>
                  <tr style="border:1px solid #000;">
                    <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                  </tr>
                  <tr style="border:1px solid #000;">
                    <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                  </tr>
                  <tr style="border:1px solid #000;">
                    <td colspan="3"style="border-right:1px solid #000;padding:4px;text-align:left;"><b>Total Trip</b></td>
                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= $sum6w1 ?></b></td>
                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= $sum10w1 ?></b></td>
                    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>0</b></td>
                    <td colspan="1"style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= ($sum6w1 + $sum10w1) ?></b></td>

                  </tr>



                </tfoot>
              </table>
              <?php
            }
            ?>
          </body>
          </html>
