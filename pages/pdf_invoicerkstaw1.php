<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
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
    array('select_lastdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);



//
// $condInvoice1 = " AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
// $condInvoice2 = "";
// $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
// $params_seInvoice = array(
//     array('select_loginvoice', SQLSRV_PARAM_IN),
//     array($condInvoice1, SQLSRV_PARAM_IN),
//     array($condInvoice2, SQLSRV_PARAM_IN)
// );
// $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
// $result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC);

$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,INVOICECODE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '".$_GET['invoicecode']."'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);



  $condBilling1 = " AND c.COMPANYCODE = '".$_GET['companycode']."' AND c.CUSTOMERCODE = '".$_GET['customercode']."' ";
  $condBilling2 = " AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) 
                    AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103)
                    AND a.DOCUMENTCODE !='LOAD' ";



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
$last_date = date('d/m/Y',strtotime('last day of this month'));
//$invoicecode = create_invoice();

// $mpdf = new mPDF('th', 'A4', '0', '');
//ซ้าย ขวา body , , HEADER,ล่าง
$mpdf = new mPDF('', 'Letter', '', '', 3, 20, 60, 5, 5, 15);
$style = '
<style>
	body{
		font-family: "angsana";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';




$table_header3 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="2" style="text-align:center;font-size:28px"><b>ใบส่งสินค้า</b></td>

    </thead>
    <br>
    <tbody>
        <tr>
            <td colspan="2" style="font-size:22px">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO.,LTD.)</td>
       </tr>
       <tr>
            <td colspan="2" style="font-size:22px">สำนักงานใหญ่ เลขที่ 51 ม.4 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160 โทรศัพท์ : (038) 452824-5 โทรสาร : (038) 210396</td>
       </tr>
       <tr>
            <td colspan="2" style="font-size:22px">เลขประจำตัวผู้เสียภาษี : 0105544064899</td>
       </tr>
       <tr>
            <td colspan="2">&nbsp;</td>
       </tr>

       <tr>
            <td style="width: 50%;font-size:22px">ลูกค้า บริษัท โตโยต้า ออโต้ เวิคส จำกัด (สำนักงานใหญ่)</td>
            <td style="width: 50%;text-align:right;font-size:22px">เลขที่ ' . $result_seInvoicecode['INVOICECODE'] . '</td>
       </tr>
       <tr>
            <td style="width: 80%;font-size:22px">ที่อยู่ 187 หมู่ 9 ถนนทางรถไฟเก่า ต.เทพารักษ์ อ.เมืองสมุทรปราการ จ.สมุทรปราการ 20160</td>
            <td style="width: 20%;text-align:right;font-size:22px">วันที่ ' .  $last_date . ' เครดิต 30 วัน</td>
       </tr>
       <tr>
            <td style="width: 50%;font-size:22px">เลขประจำตัวผู้เสียภาษี 0115531001656</td>
            <td style="width: 50%;text-align:right;font-size:22px">วันที่ครบกำหนด ' . $result_seduedate['DUEDATE'] . '</td>
       </tr>
    </tbody>
</table>';

$table_begin3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:20px;margin-top:8px;">';
$thead3 = '<thead>

        <tr  style="border:1px solid #000;padding:10px;">
        <td  style="border-right:1px solid #000;padding:10px;text-align:center;width: 5%;"><b>ลำดับ</b></td>
        <td  style="border-right:1px solid #000;padding:10px;text-align:center;width: 10%;"><b>วันที่</b></td>
        <td  style="border-right:1px solid #000;padding:10px;text-align:center;width: 14%;"><b>หมายเลข DO</b></td>
        <td  style="border-right:1px solid #000;padding:10px;text-align:center;width: 15%;"><b>ทะเบียนรถ</b></td>
        <td  style="border-right:1px solid #000;padding:10px;text-align:center;width: 10%;"><b>พนักงาน</b></td>
        <td  style="border-right:1px solid #000;padding:10px;text-align:center;width: 14%;"><b>จาก</b></td>
        <td  style="border-right:1px solid #000;padding:10px;text-align:center;width: 15%"><b>ถึง</b></td>
        <td  style="border-right:1px solid #000;padding:10px;text-align:center;width: 5%"><b>QT.</b></td>
        <td  style="border-right:1px solid #000;padding:10px;text-align:center;width: 10%"><b>ราคา</b></td>
        <td  style="border-right:1px solid #000;padding:10px;text-align:center;width: 16%"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
    </thead><tbody>';

$i = 1;
$sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBilling = array(
    array('select_pdfvehicletransportdocumentdriver-tgt', SQLSRV_PARAM_IN),
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

    $sql_seHoliday = " SELECT HOLIDAY AS 'DATE' FROM [dbo].[BILLING_HOLIDAY] WHERE INVOICECODE ='".$result_seInvoicecode['INVOICECODE']."'
    AND COMPANYCODE='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."' AND JOBEND = 'STM Amatanakorn->TAW Samrong'";
    $params_seHoliday = array();
    $query_seHoliday = sqlsrv_query($conn, $sql_seHoliday, $params_seHoliday);
    $result_seHoliday = sqlsrv_fetch_array($query_seHoliday, SQLSRV_FETCH_ASSOC);


    $holiday = $result_seHoliday['DATE'];
    // $holiday = $result_seHoliday['DATE'];
    $holidaysplit = explode(",", $holiday);


if (($result_seBilling['DATEVLIN_103'] == $holidaysplit[0]) || ($result_seBilling['DATEVLIN_103'] == $holidaysplit[1]) || ($result_seBilling['DATEVLIN_103'] == $holidaysplit[2])) {
  $tbody3 .= '

      <tr style="border:1px solid #000;padding:10px;">
      <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 5%;font-size:20px">' . $i . '</td>
      <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 10%;font-size:20px">' . $result_seBilling['DATEVLIN_103'] . '</td>
      <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 10%;font-size:20px">' . substr($result_seBilling['DOCUMENTCODE'],1,7) . '</td>
      <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 10%;font-size:20px">' . $result_seBilling['THAINAME'] . '</td>
      <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 10%;font-size:20px">' . $result_seEmployeeehr['FnameT'] . '</td>
      <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 20%;font-size:20px">STM Amatanakorn</td>
      <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 15%;font-size:20px">TAW Samrong</td>
      <td style="border-right:1px solid #000;padding:10px;text-align:right;width: 5%;font-size:20px">1.00</td>
      <td style="border-right:1px solid #000;padding:10px;text-align:right;width: 10%;font-size:20px">' . number_format($result_seBilling['PRICE'], 2) . '</td>
      <td style="border-right:1px solid #000;padding:10px;text-align:right;width: 10%;font-size:20px">' . number_format($result_seBilling['PRICE'], 2) . '</td>
    </tr>

    <tr style="border:1px solid #000;padding:17px;">
        <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 10%;font-size:20px"></td>
        <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 25%;font-size:20px">' . $result_seBilling['DATEVLIN_103'] . '</td>
        <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 30%;font-size:20px">' . substr($result_seBilling['DOCUMENTCODE'],1,7) . '</td>
        <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 25%;font-size:20px">' . $result_seBilling['THAINAME'] . '</td>
        <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 25%;font-size:20px">' . $result_seEmployeeehr['FnameT'] . '</td>
        <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 63%;font-size:20px">STM Amatanakorn</td>
        <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 45%;font-size:20px">Holiday</td>
        <td style="border-right:1px solid #000;padding:17px;text-align:right;width: 15%;font-size:20px">1.00</td>
        <td style="border-right:1px solid #000;padding:17px;text-align:right;width: 25%;font-size:20px">1000</td>
        <td style="border-right:1px solid #000;padding:17px;text-align:right;width: 35%;font-size:20px">1000</td>
  </tr>
  ';
  $i++;
  $count ++ ;
  $sumtotalholiday = ($count * 1000);
  $sumtotal1 = $sumtotal1 + $result_seBilling['PRICE'];
}else {
  $tbody3 .= '

      <tr style="border:1px solid #000;padding:10px;">
      <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 5%;font-size:20px">' . $i . '</td>
      <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 10%;font-size:20px">' . $result_seBilling['DATEVLIN_103'] . '</td>
      <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 10%;font-size:20px">' . substr($result_seBilling['DOCUMENTCODE'],1,7) . '</td>
      <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 10%;font-size:20px">' . $result_seBilling['THAINAME'] . '</td>
      <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 10%;font-size:20px">' . $result_seEmployeeehr['FnameT'] . '</td>
      <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 20%;font-size:20px">STM Amatanakorn</td>
      <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 15%;font-size:20px">TAW Samrong</td>
      <td style="border-right:1px solid #000;padding:10px;text-align:right;width: 5%;font-size:20px">1.00</td>
      <td style="border-right:1px solid #000;padding:10px;text-align:right;width: 10%;font-size:20px">' . number_format($result_seBilling['PRICE'], 2) . '</td>
      <td style="border-right:1px solid #000;padding:10px;text-align:right;width: 10%;font-size:20px">' . number_format($result_seBilling['PRICE'], 2) . '</td>
    </tr>
  ';
  $i++;
  $sumtotal2 = $sumtotal2 + $result_seBilling['PRICE'];
}

}





$tfoot3 = '</tbody><tfoot>
     <tr style="border:1px solid #000;">
        <td colspan="9" style="border-right:1px solid #000;padding:10px;text-align:center;"><b>' . convert($sumtotal1+$sumtotal2+$sumtotalholiday) . '</td>

        <td colspan="2" style="border-right:1px solid #000;padding:10px;text-align:right;"><b>' . number_format($sumtotal1+$sumtotal2+$sumtotalholiday, 2) . '</td>

            </tr>
    </tfoot>';


$table_end3 = '</table>';

$table_footer3 = '<table style="width: 100%;">
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
   		 <td style="width: 33%;text-align:left;font-size:20px">ผู้จัดทำ..............................</td>

        <td style="width: 34%;text-align:center;font-size:20px">ผู้ตรวจสอบ..........................</td>

        <td style="width: 33%;text-align:right;font-size:20px">ผู้อนุมัติ..............................</td>

       </tr>



    </tbody>
</table>';





$mpdf->WriteHTML($style);
$mpdf->SetHTMLHeader($table_header3, 'O', true);
// $mpdf->WriteHTML($table_header3);
$mpdf->WriteHTML($table_begin3);
$mpdf->WriteHTML($thead3);
$mpdf->WriteHTML($tbody3);
$mpdf->WriteHTML($tfoot3);
$mpdf->WriteHTML($table_end3);
$mpdf->WriteHTML($table_footer3);
// $mpdf->SetHTMLFooter($table_footer3);

$mpdf->Output();


sqlsrv_close($conn);
?>
