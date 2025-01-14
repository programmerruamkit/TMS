<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['invoicecode'] == "" || $_GET['invoicecode'] == "") {
  $strExcelFileName = "RKSTGT_Billing.xls";
} else {
  $strExcelFileName = "RKSTGT_Billing" . $_GET['invoicecode'] . ".xls";
}
// // $strExcelFileName="Member-All.xls";

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

$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,INVOICECODE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '".$_GET['invoicecode']."'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);

// $sql_getDate = "{call megStopwork_v2(?,?)}";
// $params_getDate = array(
//     array('select_lastdatetgt', SQLSRV_PARAM_IN),
//     array($result_seInvoicecode['BILLINGDATE'], SQLSRV_PARAM_IN)
// );
// $query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
// $result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$date = substr($result_seInvoicecode['BILLINGDATE'],3,10);




$sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBillings = array(
    array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN)
);
$query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
$result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);

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

<table style="width: 110%;">
    <thead>
        <tr>
            <td colspan="12" style="text-align:center;font-size:28px"><b>ใบส่งสินค้า</b></td>
        </tr>

    </thead>

    <tbody><br><br><br>
        <tr>
            <td colspan="11" style="width: 70%;font-size:22px">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO.,LTD.)</td>
       </tr>
       <tr>
            <td colspan="11" style="font-size:22px">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง จังหวัดชลบุรี 20160 โทรศัพท์ : 038-452824-5 โทรสาร : 038-210396</td>
       </tr>
       <tr>
            <td colspan="11" style="font-size:22px" >เลขประจำตัวผู้เสียภาษี : 0105544064899</td>
       </tr>
       <tr>
            <td colspan="11">&nbsp;</td>
       </tr>

       <tr>
            <td colspan="8" style="font-size:22px">ลูกค้า บริษัท ไทยซัมมิท โอโตโมทีฟ จำกัด (สำนักงานใหญ่)</td>
            <td colspan="3" style="text-align:right;font-size:22px">เลขที่ <?= $result_seInvoicecode['INVOICECODE'] ?></td>
       </tr>
       <tr>
            <td colspan="8" style="font-size:22px">ที่อยู่ 4/3, 4/29 หมู่ที่ 1 ถ.บางนา-ตราด กม.16 ต.บางโฉลง อ.บางพลี จ.สมุทรปราการ 10540</td>
            <td colspan="3" style="text-align:right;font-size:22px">วันที่ <?= $result_seduedate['DUEDATE'] ?></td>
       </tr>
       <tr>
            <td colspan="8" style="font-size:22px">เลขประจำตัวผู้เสียภาษี 0105537013231</td>
       </tr>
    </tbody>
</table>

<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">
<thead>

        <tr  style="border:1px solid #000;padding:14px;">
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:24px"><b>ลำดับ</b></td>
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:24px"><b>วันที่</b></td>
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:24px"><b>หมายเลข DO</b></td>
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:24px"><b>ประเภทรถ</b></td>
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:24px"><b>ทะเบียนรถ</b></td>
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:24px"><b>พนักงาน</b></td>
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:24px"><b>จาก</b></td>
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:24px"><b>ถึง</b></td>
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:24px"><b>QT.</b></td>
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:24px"><b>ราคา</b></td>
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:24px"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
    </thead><tbody>
<?php
$i = 1;
$count = 0 ;

$condBilling1 = " AND c.COMPANYCODE = '".$_GET['companycode']."' AND c.CUSTOMERCODE = '".$_GET['customercode']."'";
$condBilling2 = " AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103) ";



$sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBilling = array(
    array('select_pdfvehicletransportdocumentdriver-tgt', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN)
);



$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
    
    $condEmployeeehr1 = " AND a.PersonCode = '" . $result_seBilling['EMPLOYEECODE1'] . "' ";
    $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmployeeehr = array(
        array('select_employeeehr2', SQLSRV_PARAM_IN),
        array($condEmployeeehr1, SQLSRV_PARAM_IN)
    );
    $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
    $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);


    $sql_seHoliday = "SELECT HOLIDAY AS 'DATE' FROM [dbo].[BILLING_HOLIDAY] WHERE INVOICECODE ='".$result_seInvoicecode['INVOICECODE']."'
    AND COMPANYCODE='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'";
    $params_seHoliday = array();
    $query_seHoliday = sqlsrv_query($conn, $sql_seHoliday, $params_seHoliday);
    $result_seHoliday = sqlsrv_fetch_array($query_seHoliday, SQLSRV_FETCH_ASSOC);;


    $holiday = $result_seHoliday['DATE'];
    // $holiday = $result_seHoliday['DATE'];
    $holidaysplit = explode(",", $holiday);


      if (($result_seBilling['DATEVLIN_103'] == $holidaysplit[0]) || ($result_seBilling['DATEVLIN_103'] == $holidaysplit[1]) || ($result_seBilling['DATEVLIN_103'] == $holidaysplit[2]) || ($result_seBilling['DATEVLIN_103'] == $holidaysplit[3]) || ($result_seBilling['DATEVLIN_103'] == $holidaysplit[4])) {
      ?>

        <tr style="border:1px solid #000;padding:17px;">
        <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:24px"><?= $i ?></td>
        <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:24px"><?= $result_seBilling['DATEVLIN_103'] ?></td>
        <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:24px"><?= $result_seBilling['DOCUMENTCODE'] ?></td>
        <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 25%;font-size:24px"><?= ($result_seBilling['VEHICLETYPE']  == '6 ล้อ(ตู้)' ? '6W' : $result_seBilling['VEHICLETYPE']) ?></td>
        <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:24px"><?= $result_seBilling['THAINAME'] ?></td>
        <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:24px"><?= $result_seEmployeeehr['FnameT'] ?></td>
        <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:24px"><?= $result_seBilling['JOBSTART'] ?></td>
        <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:24px"><?= $result_seBilling['JOBEND'] ?></td>
        <td style="border-right:1px solid #000;padding:17px;text-align:right;font-size:24px">1.00</td>
        <td style="border-right:1px solid #000;padding:17px;text-align:right;font-size:24px"><?= number_format($result_seBilling['PRICE'], 2) ?></td>
        <td style="border-right:1px solid #000;padding:17px;text-align:right;font-size:24px"><?= number_format($result_seBilling['PRICE'], 2) ?></td>
      </tr>
      <tr style="border:1px solid #000;padding:17px;">
          <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:24px"></td>
          <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:24px"><?= $result_seBilling['DATEVLIN_103'] ?></td>
          <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:24px"><?= $result_seBilling['DOCUMENTCODE']?></td>
          <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 25%;font-size:24px"><?= ($result_seBilling['VEHICLETYPE']  == '6 ล้อ(ตู้)' ? '6W' : $result_seBilling['VEHICLETYPE']) ?></td>
          <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:24px"><?= $result_seBilling['THAINAME'] ?></td>
          <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:24px"><?= $result_seEmployeeehr['FnameT'] ?></td>
          <td colspan="2" style="border-right:1px solid #000;padding:17px;text-align:center;font-size:24px">Holiday</td>
          <td style="border-right:1px solid #000;padding:17px;text-align:right;font-size:24px">1.00</td>
          <td style="border-right:1px solid #000;padding:17px;text-align:right;font-size:24px">1,000.00</td>
          <td style="border-right:1px solid #000;padding:17px;text-align:right;font-size:24px">1,000.00</td>
    </tr>
<?php
        $i++;
        $count ++ ;
        $sumtotalholiday = ($count * 1000);
        $sumtotal1 = $sumtotal1 + $result_seBilling['PRICE'];
      }else {
    ?>

          <tr style="border:1px solid #000;padding:17px;">
            <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:24px"><?= $i ?></td>
            <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:24px"><?= $result_seBilling['DATEVLIN_103'] ?></td>
            <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:24px"><?= $result_seBilling['DOCUMENTCODE'] ?></td>
            <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 25%;font-size:24px"><?= ($result_seBilling['VEHICLETYPE']  == '6 ล้อ(ตู้)' ? '6W' : $result_seBilling['VEHICLETYPE']) ?></td>
            <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:24px"><?= $result_seBilling['THAINAME'] ?></td>
            <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:24px"><?= $result_seEmployeeehr['FnameT'] ?></td>
            <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:24px"><?= $result_seBilling['JOBSTART'] ?></td>
            <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:24px"><?= $result_seBilling['JOBEND'] ?></td>
            <td style="border-right:1px solid #000;padding:17px;text-align:right;font-size:24px">1.00</td>
            <td style="border-right:1px solid #000;padding:17px;text-align:right;font-size:24px"><?= number_format($result_seBilling['PRICE'], 2) ?></td>
            <td style="border-right:1px solid #000;padding:17px;text-align:right;font-size:24px"><?= number_format($result_seBilling['PRICE'], 2) ?></td>
          </tr>
<?php
        $i++;
        $sumtotal2 = $sumtotal2 + $result_seBilling['PRICE'];
      }





}///main while

?>


</tbody><tfoot>
     <tr style="border:1px solid #000;">
        <td  colspan="10" style="border-right:1px solid #000;padding:11px;text-align:center;font-size:24px"><b><?= convert($sumtotal1+$sumtotal2+$sumtotalholiday) ?></td>

        <td  colspan="1" style="border-right:1px solid #000;padding:11px;text-align:right;font-size:24px"><b><?= number_format($sumtotal1+$sumtotal2+$sumtotalholiday, 2) ?></td>

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
   		  <td colspan="3" style="text-align:left;font-size:20px">ผู้จัดทำ..............................</td>

        <td colspan="3" style="text-align:center;font-size:20px">ผู้ตรวจสอบ..........................</td>

        <td colspan="3" style="text-align:right;font-size:20px">ผู้อนุมัติ..............................</td>

       </tr>



    </tbody>
    </table>
  </body>
  </html>
