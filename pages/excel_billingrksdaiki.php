<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['invoicecode'] == "" || $_GET['invoicecode'] == "") {
  $strExcelFileName = "RKSDAIKI_Billing.xls";
} else {
  $strExcelFileName = "RKSDAIKI_Billing" . $_GET['invoicecode'] . ".xls";
}
// $strExcelFileName="Member-All.xls";

header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

$sumgmtweight = "";
$sumcusweight = "";
$sumamounttrip = "";
$sumtotal = "";

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

$condduedate1 = " AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
$condduedate2 = "";
$sql_seduedate = "{call megLoginvoice_v2(?,?,?)}";
$params_seduedate = array(
    array('select_duedate', SQLSRV_PARAM_IN),
    array($condduedate1, SQLSRV_PARAM_IN),
    array($condduedate2, SQLSRV_PARAM_IN)
);
$query_seduedate = sqlsrv_query($conn, $sql_seduedate, $params_seduedate);
$result_seduedate = sqlsrv_fetch_array($query_seduedate, SQLSRV_FETCH_ASSOC);

?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
  <table id="bg-table" width="300px" style="border-collapse: collapse;font-size:10px;margin-top:8px;">
      <thead>
          <tr>
              <td colspan="10" style="text-align:center;font-size:20px"><b>ใบส่งสินค้า</b></td>
              <br><br><br><br><br>
      </thead>
      <tr>
           <td colspan="10" >&nbsp;</td>
      </tr>
      <tbody>
          <tr>
              <td colspan="10" style="font-size:18px">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO.,LTD.)</td>
         </tr>
         <tr>
              <td colspan="10" style="font-size:18px">สำนักงานใหญ่ เลขที่ 51 ม.4 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี โทรศัพท์ : (038) 452824-5 โทรสาร : (038) 210396</td>
         </tr>
         <tr>
              <td colspan="10" style="font-size:18px">เลขประจำตัวผู้เสียภาษี : 0105544064899</td>
         </tr>
         <tr>
              <td colspan="10" >&nbsp;</td>
         </tr>

         <tr>
              <td colspan="5" style="font-size:18px">ลูกค้า บริษัท ไดกิ อลูมิเนียม อินดัสทรี (ประเทศไทย) จำกัด </td>
              <td colspan="5" style="text-align:right;font-size:18px">เลขที่ <?= $result_seInvoice['INVOICECODE'] ?></td>
         </tr>
         <tr>
              <td colspan="5" style="font-size:18px">สำนักงานใหญ่ ที่อยู่ 700/99 ม.1 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160</td>
              <td colspan="5" style="text-align:right;font-size:18px">วันที่ <?= $result_seduedate['DUEDATE'] ?></td>
         </tr>

      </tbody>
      <br><br>
  </table><br>

<table id="bg-table" style="font-size:10px;margin-top:8px;">
<thead>

        <tr  style="border:1px solid #000;padding:4px;">
          <td  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:16px;"><b>ลำดับที่</b></td>
          <td  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:16px;"><b>วันที่</b></td>
          <td  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:16px;"><b>หมายเลข DO</b></td>
          <td  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:16px;"><b>ทะเบียนรถ</b></td>
          <td  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:16px;"><b>พนักงาน</b></td>
          <td  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:16px;"><b>จาก</b></td>
          <td  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:16px;"><b>ถึง</b></td>
          <td  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:16px;"><b>QT.</b></td>
          <td  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:16px;"><b>หน่วยละ</b></td>
          <td  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:16px;"><b>จำนวนเงิน(บาท)</b></td>
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





<tr style="border:1px solid #000;font-size:26px">
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 10%;font-size:25px"><?= $i ?></td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 18%;font-size:25px"><?= $result_seBilling['DATEVLIN_103'] ?></td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 16%;font-size:25px"><?= $result_seBilling['DOCUMENTCODE'] ?></td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 15%;font-size:25px"><?= $result_seBilling['THAINAME'] ?></td>
        <td style="border-right:1px solid #000;padding:13px;text-align:left;width: 15%;font-size:25px"><?= $result_seEmployeeehr['FnameT'] ?></td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 30%;font-size:25px"><?= $result_seBilling['JOBSTART']?></td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 30%;font-size:25px"><?= $result_seBilling['JOBEND']?></td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 8%;font-size:25px">1</td>
        <td style="border-right:1px solid #000;padding:13px;text-align:right;width: 15%;font-size:25px"><?= number_format($result_seBilling['PRICE'], 2) ?></td>
        <td style="border-right:1px solid #000;padding:13px;text-align:right;width: 20%;font-size:25px"><?= number_format($result_seBilling['PRICE'], 2) ?></td>
      </tr>
    <?php
    $i++;
    $sumtotal = $sumtotal + $result_seBilling['PRICE'];
  }
     ?>

</tbody>



</table>
<table id="bg-table"  style="border-collapse: collapse;font-size:10px;margin-top:8px;">
  <tfoot>
         <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px;">ยอดรวมสุทธิ</td>
            <td colspan="7" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px;"><?= convert($sumtotal) ?></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:18px;"><?= number_format($sumtotal, 2) ?></td>

                </tr>
        </tfoot>

</table>

<table id="bg-table"  style="border-collapse: collapse;font-size:10px;margin-top:8px;">
      <tbody>
         <tr>
     		 <td colspan="10" >&nbsp;</td>
         </tr>
         <tr>
     		 <td colspan="10" >&nbsp;</td>
         </tr>

       </tbody>
 </table>

 <table id="bg-table"  style="border-collapse: collapse;font-size:16px;margin-top:8px;">
       <tbody>
         <tr>
             <td colspan="3" style="text-align:right;;font-size:16px">ผู้จัดทำ.......................................</td>
             <td colspan="3" style="text-align:right;font-size:16px">ผู้ตรวจสอบ.......................................</td>
             <td colspan="3" style="text-align:right;font-size:16px">ผู้อนุมัติ.......................................</td>
             <td colspan="1" style="text-align:left;font-size:16px"></td>
             <!-- <td colspan="1" style="">........................................</td>
             <td colspan="2" style="text-align:right;font-size:16px">ผู้ตรวจสอบ</td>
             <td colspan="1" style="">........................................</td>
             <td colspan="4" style="text-align:right;font-size:16px">ผู้อนุมัติ..................................</td> -->

         </tr>
        </tbody>
  </table>





</body>
</html>
