<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['invoicecode'] == "" || $_GET['invoicecode'] == "") {
  $strExcelFileName = "RKSGMT_Billing.xls";
} else {
  $strExcelFileName = "RKSGMT_Billing" . $_GET['invoicecode'] . ".xls";
}

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

$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,DULYDATE,INVOICECODE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '".$_GET['invoicecode']."'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);


?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="10" style="text-align:center;font-size:28px"><b>ใบส่งสินค้า</b></td>
    </thead>
    <tbody>
      <tr>
            <td colspan="10" style="font-size:24px">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICE CO.,LTD.)</td>
       </tr>
       <tr>
            <td colspan="10" style="font-size:24px">สำนักงานใหญ่ เลขที่ 51 ม.4 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี โทรศัพท์ : (038) 452824-5 โทรสาร : (038) 210396</td>
       </tr>
       <tr>
            <td colspan="10" style="font-size:24px">เลขประจำตัวผู้เสียภาษี : 0105544064899</td>
       </tr>
       <tr>
            <td colspan="10">&nbsp;</td>
       </tr>


       <tr>
            <td colspan="5" style="font-size:26px">ลูกค้า บริษัท กรีน เมทัลส์ (ประเทศไทย) จำกัด</td>
            <td colspan="5" style="text-align:right;font-size:26px">เลขที่ <?= $result_seInvoicecode['INVOICECODE'] ?></td>
        </tr>
        <tr>
            <td colspan="5" style="font-size:26px">สาขาที่ 00001 เลขที่ 219/18 หมู่ที่ 6  นิคมฯปิ่นทอง 3 ต.บ่อวิน อ.ศรีราชา จ.ชลบุรี 20230</td>
            <td colspan="5" style="text-align:right;font-size:26px">วันที่ <?= $result_seInvoicecode['DULYDATE'] ?></td>
        </tr>
        <tr>
            <td colspan="10" style="font-size:26px">เลขประจำตัวผู้เสียภาษี  0245548000991</td>
        </tr>
    </tbody>
</table>

<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">
<thead>

        <tr style="border:1px solid #000;padding:6px;">

        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 10%;"><font style="font-size: 24px"><b>ลำดับ</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 20%;"><font style="font-size: 24px"><b>วันที่</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 15%;"><font style="font-size: 24px"><b>หมายเลข DO</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 15%;"><font style="font-size: 24px"><b>ทะเบียนรถ</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 15%;"><font style="font-size: 24px"><b>พนักงาน</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 28%;"><font style="font-size: 24px"><b>จาก</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 30%;"><font style="font-size: 24px"><b>ถึง</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 10%;"><font style="font-size: 24px"><b>QT.</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 15%;"><font style="font-size: 24px"><b>ราคา</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 15%;"><font style="font-size: 24px"><b>จำนวนเงิน</b></font></td>
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



    $sql_seHoliday = "SELECT HOLIDAY AS 'DATE' FROM [dbo].[BILLING_HOLIDAY] WHERE INVOICECODE ='".$result_seInvoicecode['INVOICECODE']."'
    AND COMPANYCODE='RKS' AND CUSTOMERCODE = 'GMT'";
    $params_seHoliday = array();
    $query_seHoliday = sqlsrv_query($conn, $sql_seHoliday, $params_seHoliday);
    $result_seHoliday = sqlsrv_fetch_array($query_seHoliday, SQLSRV_FETCH_ASSOC);

    


    $holiday = $result_seHoliday['DATE'];
    // $holiday = $result_seHoliday['DATE'];
    $holidaysplit = explode(",", $holiday);

    if (($result_seBilling['DATE_VLIN'] == $holidaysplit[0]) || ($result_seBilling['DATE_VLIN'] == $holidaysplit[1]) || ($result_seBilling['DATE_VLIN'] == $holidaysplit[2]) || ($result_seBilling['DATE_VLIN'] == $holidaysplit[3]) || ($result_seBilling['DATE_VLIN'] == $holidaysplit[4])) {
?>
          

      <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><?= $i ?></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><?= $result_seBilling['DATE_VLIN'] ?></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><?= (substr($result_seBilling['DOCUMENTCODE'],0,3) == 'S17' ? ' ' : $result_seBilling['DOCUMENTCODE'] )  ?></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><?= $result_seBilling['THAINAME'] ?></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><?= $result_seEmployeeehr['FnameT'] ?></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><?= $result_seBilling['JOBSTART'] ?></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><?= $result_seBilling['JOBEND'] ?></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">1.00</font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px"><?= number_format($result_seBilling['PRICE'], 2) ?></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px"><?= number_format($result_seBilling['PRICE'], 2) ?></font></td>
      </tr>
        <tr style="border:1px solid #000;">
          <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"></td>
          <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><?= $result_seBilling['DATE_VLIN'] ?>?></font></td>
          <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><?= (substr($result_seBilling['DOCUMENTCODE'],0,3) == 'S17' ? ' ' : $result_seBilling['DOCUMENTCODE'] ) ?><br>Holiday</td>
          <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><?= $result_seBilling['THAINAME'] ?></font></td>
          <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><?= $result_seEmployeeehr['FnameT'] ?></font></td>
          <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><?= $result_seBilling['JOBSTART'] ?></font></td>
          <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><?= $result_seBilling['JOBEND'] ?></font></td>
          <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">1.00</font></td>
          <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">1,000.00</font></td>
          <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">1,000.00</font></td>
        </tr>
      <?php
      $i++;
      $count ++ ;
      $sumtotalholiday = ($count * 1000);
      $sumtotal1 = $sumtotal1 + $result_seBilling['PRICE'];

    }else {
    ?>

        <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px"><?= $i ?></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px"><?= $result_seBilling['DATE_VLIN'] ?></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px"><?= (substr($result_seBilling['DOCUMENTCODE'],0,3) == 'L17' ? ' ' : $result_seBilling['DOCUMENTCODE'] )  ?></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px"><?= $result_seBilling['THAINAME'] ?></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px"><?= $result_seEmployeeehr['FnameT'] ?></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px"><?= $result_seBilling['JOBSTART'] ?></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px"><?= $result_seBilling['JOBEND'] ?></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">1.00</font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px"><?= number_format($result_seBilling['PRICE'], 2) ?></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px"><?= number_format($result_seBilling['PRICE'], 2) ?></font></td>
    </tr>
    <?php
    $i++;
    $sumtotal2 = $sumtotal2 + $result_seBilling['PRICE'];
}

  }////end while
?>



</tbody><tfoot>
     <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><b>ยอดรวมสุทธิ</b></font></td>
        <td colspan="7" style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><b><?=  convert($sumtotal1+$sumtotal2+$sumtotalholiday) ?></b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px"><b><?= number_format($sumtotal1+$sumtotal2+$sumtotalholiday, 2) ?></b></font></td>

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
   		 <td colspan="4" style="text-align:left;font-size:20px">ผู้จัดทำ..............................</td>

         <td colspan="3" style="text-align:center;font-size:20px">ผู้ตรวจสอบ..........................</td>

         <td colspan="4" style="text-align:right;font-size:20px">ผู้อนุมัติ..............................</td>

       </tr>



    </tbody>
</table>






</body>
</html>
