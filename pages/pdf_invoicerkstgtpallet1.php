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



if($_GET['transportation2'] != '' )
{
  $condBilling1 = " AND c.COMPANYCODE = '".$_GET['companycode']."' AND c.CUSTOMERCODE = '".$_GET['customercode']."' AND b.JOBSTART = '".$_GET['transportation1'].'+'.$_GET['transportation2']."' ";
  $condBilling2 = " AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103) ";

}
else {
  $condBilling1 = " AND c.COMPANYCODE = '".$_GET['companycode']."' AND c.CUSTOMERCODE = '".$_GET['customercode']."' AND b.JOBSTART='".$_GET['transportation']."' ";
  $condBilling2 = " AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103) ";
}


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

//$invoicecode = create_invoice();

// $mpdf = new mPDF('th', 'A4', '0', '');
$mpdf = new mPDF('', 'A4', '', '', 10, 10, 60, 5, 5, 5);
$style = '
<style>
	body{
		font-family: "Garuda";font-size:12px//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';




$table_header3 = '<table style="width: 110%;">
    <thead>
        <tr>
            <td colspan="48" style="text-align:center;font-size:16px"><b>ใบส่งสินค้า</b></td>
        </tr>

    </thead>

    <tbody><br><br><br>
        <tr>
            <td colspan="48" style="width: 70%;">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO.,LTD.)</td>
       </tr>
       <tr>
            <td colspan="48" style="font-size:14px">สำนักงานใหญ่ เลขที่ 51 ม.4 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี โทรศัพท์ : (038) 452824-5 โทรสาร : (038) 210396</td>
       </tr>
       <tr>
            <td colspan="48" style="font-size:14px" >เลขประจำตัวผู้เสียภาษี : 0105544064899</td>
       </tr>
       <tr>
            <td colspan="48">&nbsp;</td>
       </tr>

       <tr>
            <td colspan="40" style="font-size:14px">ลูกค้า บริษัท โตโยด้า โกเซ (ประเทศไทย) จำกัด  (สำนักงานใหญ่)</td>
            <td colspan="20" style="text-align:right;font-size:14px">เลขที่ ' . $result_seInvoicecode['INVOICECODE'] . '</td>
       </tr>
       <tr>
            <td colspan="40" style="font-size:14px">700/489 ม.4  นิคมอุตสาหกรรมอมตะนคร ต.บ้านเก่า  <br>อ.พานทอง  จ.ชลบุรี </td>
            <td colspan="20" style="text-align:right;font-size:14px">วันที่ ' . $result_getDate['LASTDATE'] . ' เครดิต 30 วัน</td>
       </tr>
       <tr>
            <td colspan="40" style="font-size:14px">เลขประจำตัวผู้เสียภาษี 0105537013231</td>
            <td colspan="20" style="text-align:right;font-size:14px">วันที่ครบกำหนด ' . $result_seduedate['DUEDATE'] . '</td>
       </tr>
    </tbody>
</table>';

$table_begin3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:9px;margin-top:8px;">';
$thead3 = '<thead>

        <tr  style="border:1px solid #000;padding:4px;">
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;"><b>ลำดับ</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;"><b>วันที่</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>หมายเลข DO</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ทะเบียนรถ</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>พนักงาน</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;width: 22%;"><b>จาก</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%"><b>ถึง</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%"><b>QT.</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%"><b>ราคา</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
    </thead><tbody>';

$i = 1;
$sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBilling = array(
    array('select_pdfvehicletransportdocumentdriverpallet-tgt', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN)
);



$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
    $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "' ";
    $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmployeeehr = array(
        array('select_employee', SQLSRV_PARAM_IN),
        array($condEmployeeehr1, SQLSRV_PARAM_IN)
    );
    $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
    $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);

  $tbody3 .= '

      <tr style="border:1px solid #000;">
      <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;">' . $i . '</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;">' . $result_seBilling['DATEVLIN_103'] . '</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">' . $result_seBilling['DOCUMENTCODE_PALLET'] . '</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">' . $result_seBilling['THAINAME'] . '</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">' . $result_seEmployeeehr['FnameT'] . '</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;">' . $result_seBilling['JOBSTART'] . '</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;">' . ($result_seBilling['JOBEND']  == 'INGY' ? 'INGY (Rayong)' : $result_seBilling['JOBEND']) . '</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:right;width: 5%;">1.00</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:right;width: 10%;">' . number_format($result_seBilling['TRIPAMOUNT_PALLET']*10, 2) . '</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:right;width: 15%;">' . number_format($result_seBilling['TRIPAMOUNT_PALLET']*10, 2) . '</td>
    </tr>
  ';
$i++;
  $sumtotal = $sumtotal + ($result_seBilling['TRIPAMOUNT_PALLET']*10);
}





$tfoot3 = '</tbody><tfoot>
     <tr style="border:1px solid #000;">
        <td colspan="9" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . convert($sumtotal) . '</td>

        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:right;"><b>' . number_format($sumtotal, 2) . '</td>

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
   		 <td style="width: 10%;text-align:right">ผู้จัดทำ</td>
            <td style="width: 25%;">........................................</td>
         <td style="width: 10%;text-align:right">ผู้ตรวจสอบ</td>
            <td style="width: 20%;">........................................</td>
            <td style="width: 10%;text-align:right">ผู้อนุมัติ</td>
            <td style="width: 25%;">........................................</td>
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

$mpdf->Output();


sqlsrv_close($conn);
?>
