<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['invoicecode'] == "" || $_GET['invoicecode'] == "") {
  $strExcelFileName = "RKSDENSO-THAI_Billing.xls";
} else {
  $strExcelFileName = "RKSDENSO-THAI_Billing" . $_GET['invoicecode'] . ".xls";
}
// $strExcelFileName="Member-All.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");


$sumgmtweight = "";
$sumcusweight = "";
$sumamounttrip = "";
$sumtotal = "";
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $date_now = "";
} else {
    $date_now = $_GET['datestart'] . ' ถึง ' . $_GET['dateend'];
}
$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);


$condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "'";
$condBilling2 = "";

$sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBillings = array(
  array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
  array($condBilling1, SQLSRV_PARAM_IN),
  array($condBilling2, SQLSRV_PARAM_IN)
);
$query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
$result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);

$condInvoice1 = " AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
$condInvoice2 = "";
$sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
$params_seInvoice = array(
  array('select_loginvoice', SQLSRV_PARAM_IN),
  array($condInvoice1, SQLSRV_PARAM_IN),
  array($condInvoice2, SQLSRV_PARAM_IN)
);
$query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
$result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC);


?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

  <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;margin-top:8px;">
  <tbody>
  <tr style="border:1px solid #000;padding:4px;">
  <td colspan="8" align="center">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด<br>สำนักงานใหญ่ เลขที่ 51 ม.4 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี  20160<br>โทร .038 452824-5 โทรสาร .038-210396</td>
  </tr>

  <tr style="border:1px solid #000;padding:4px;">
  <td colspan="8" align="center" style="font-size:16px">ใบส่งของ (DELIVERY BILL)</td>
  </tr>
  <tr style="border:1px solid #000;padding:4px;">
  <td colspan="4"style="width:80%"><b>วันที่ <?=$_GET['startdate']?> - <?=$_GET['enddate']?></b></td>
  <td colspan="4" align="right"><b>เลขที่ <?= $result_seInvoice['INVOICECODE'] ?></b></td>
  </tr>
  <tr style="border:1px solid #000;padding:4px;">
  <td colspan="8" align="center">บริษัท เด็นโซ่ เซลส์ (ประเทศไทย) จำกัด</td>
  </tr>
  <tr style="border:1px solid #000;padding:4px;">
  <td colspan="8" align="center">888 หมู่ 1 ถ.บางนา-ตราด กม.27.5 ต.บางบ่อ อ.บางบ่อ จ.สมุทรปราการ 10560</td>
  </tr>
  <tr style="border:1px solid #000;padding:4px;">
  <td colspan="8" align="center"><b><?=$result_seBillings['JOBSTART']?></b></td>
  </tr>
  </tbody>
  </table>


 <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
  <thead>

  <tr style="border:1px solid #000;padding:4px;">

  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;"><b>ลำดับที่</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>วันที่</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><strong>ทะเบียนรถ</strong></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>พนักงานขับรถ</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>หมายเลขเส้นทาง</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ประเภทรถ</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>จำนวนเงิน(บาท)</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>หมายเหตุ</b></td>
  </tr>
  </thead>
  <tbody>
    <?php
 $i = 1;
 $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
 $params_seBilling = array(
     array('select_pdfvehicletransportdocumentdriver-densothai', SQLSRV_PARAM_IN),
     array($condBilling1, SQLSRV_PARAM_IN),
     array($condBilling2, SQLSRV_PARAM_IN),
     array($condBilling2, SQLSRV_PARAM_IN)
 );



 $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
 while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
     $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "' ";
     $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
     $params_seEmployeeehr = array(
         array('select_employeeehr2', SQLSRV_PARAM_IN),
         array($condEmployeeehr1, SQLSRV_PARAM_IN)
     );
     $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
     $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
     ?>


  <tr style="border:1px solid #000;">
  <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$i?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seBilling['DATEVLIN_103']?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seBilling['THAINAME']?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:left;"><?=$result_seBilling['EMPLOYEENAME1']?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seBilling['ROUTEDESCRIPTION']?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seBilling['TRUCKTYPE']?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=number_format($result_seBilling['ACTUALPRICE'])?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seBilling['JOBEND']?></td>
  </tr>
  <?php

  $i++;
  $sumtotal = $sumtotal + $result_seBilling['ACTUALPRICE'];
  }
   ?>


</tbody>
<tfoot>
  <tr style="border:1px solid #000;">
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">รวม</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">23</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">เที่ยว</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">รวมเป็นเงิน</td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= convert($sumtotal) ?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= number_format($sumtotal) ?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
  </tr>
  </tfoot>
</table>

</body>
</html>
