<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['invoicecode'] == "" || $_GET['invoicecode'] == "") {
  $strExcelFileName = "RKLTKT_Billing.xls";
} else {
  $strExcelFileName = "RKLTKT_Billing" . $_GET['invoicecode'] . ".xls";
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
  $date_now = $_GET['datestart'] ?> ถึง <?= $_GET['dateend'];
}
$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
  array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);


$condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
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

  <table style="width: 100%;">
    <thead>
      <tr>
        <td colspan="9" style="text-align:center"><b>ใบส่งสินค้า</b></td>
      </thead>
      <tbody>
        <tr>
          <td colspan="9">บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์ จำกัด (RUAMKIT RUNGRUENG LOGISTICS CO., LTD.)</td>
        </tr>
        <tr>
          <td colspan="9">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง จังหวัดชลบุรี 20160</td>
        </tr>
        <tr>
          <td colspan="9">โทรศัพท์ : 038-452824-5 โทรสาร : 038-210396</td>
        </tr>


        <tr>
          <td colspan="9">&nbsp;</td>
        </tr>


        <tr>
          <td colspan="5"style="width: 50%;">ลูกค้า บริษัท ทาเคเบะ (ไทยแลนด์) จำกัด (สำนักงานใหญ่)  </td>
          <td colspan="4"style="width: 50%;text-align:right">เลขที่ <?= $result_seInvoice['INVOICECODE'] ?></td>
        </tr>
        <tr>
          <td colspan="5"style="width: 50%;">ที่อยู่ 700/742 หมู่ 1 ตำบลพานทอง อำเภอพานทอง จังหวัดชลบุรี 20160    </td>
          <td colspan="4"style="width: 50%;text-align:right">วันที่ <?= $result_getDate['SYSDATE'] ?></td>
        </tr>

        <tr>
          <td colspan="5"style="width: 50%;">เลขประจำตัวผู้เสียภาษี  0105548105689</td>
          <td colspan="4"style="width: 50%;text-align:right">&nbsp;</td>
        </tr>
      </tbody>
    </table>

    <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
      <thead>

        <tr style="border:1px solid #000;padding:4px;">

          <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;"><b>ลำดับที่</b></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>วันที่</b></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>หมายเลข DO</b></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ทะเบียนรถ</b></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>พนักงาน</b></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 25%;"><b>เส้นทาง</b></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;"><b>QT.</b></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ราคา</b></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>จำนวนเงิน(บาท)</b></td>
        </tr>
      </thead><tbody>
        <?php
        $i = 1;
        $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
        $params_seBilling = array(
          array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
          array($condBilling1, SQLSRV_PARAM_IN),
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
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $i ?></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"><?= $result_seBilling['DATEVLIN_103'] ?></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"><?= $result_seBilling['PURCHASEORDER'] ?></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"><?= $result_seBilling['THAINAME'] ?></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"><?= $result_seBilling['EMPLOYEENAME1'] ?></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:left;"><?= $result_seBilling['JOBSTART'] ?></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:right;">1.00</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:right;"><?= number_format($result_seBilling['ACTUALPRICE'], 2) ?></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:right;"><?= number_format($result_seBilling['ACTUALPRICE'], 2) ?></td>
          </tr>
          <?php
          $i++;
          $sumtotal = $sumtotal + $result_seBilling['ACTUALPRICE'];
        }
        ?>



      </tbody><tfoot>
        <tr style="border:1px solid #000;">
          <td colspan="7" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= convert($sumtotal) ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;">รวมสุทธิ</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:right;"><?= number_format($sumtotal, 2) ?></td>

        </tr>
      </tfoot>


    </table>

    <table style="width: 100%;">
      <tbody>
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>

        <tr>
          <td style="width: 10%;text-align:right">ผู้จัดทำ</td>
          <td style="width: 25%;">........................................</td>
          <td style="width: 10%;text-align:right">ผู้ตรวจสอบ</td>
          <td style="width: 20%;">........................................</td>
          <td style="width: 10%;text-align:right">ผู้อนุมัติ</td>
          <td style="width: 25%;">........................................</td>
        </tr>



      </tbody>
    </table>
  </body>
  </html>
