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
//$invoicecode = create_invoice();


$mpdf = new mPDF('', 'Letter', '', '', 3, 15, 64, 5, 5, 10);
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
            <td style="width: 50%;font-size:22px">ลูกค้า บริษัท ไดกิ อลูมิเนียม อินดัสทรี (ประเทศไทย) จำกัด </td>
            <td style="width: 50%;text-align:right;font-size:22px">เลขที่ ' . $result_seInvoice['INVOICECODE'] . '</td>
       </tr>
       <tr>
            <td style="width: 60%;font-size:22px">สำนักงานใหญ่ ที่อยู่ 700/99 ม.1 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160</td>
            <td style="width: 40%;text-align:right;font-size:22px">วันที่ ' . $result_seduedate['DUEDATE'] . '</td>
       </tr>

    </tbody>
    <br><br>
</table><br>';

$table_begin3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;font-size:25px">';
$thead3 = '<thead>

        <tr style="border:1px solid #000;padding:13px;">

        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 10%;"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 18%;"><b>วันที่</b></td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 16%;"><b>หมายเลข DO</b></td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 15%;"><b>ทะเบียนรถ</b></td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 15%;"><b>พนักงาน</b></td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 30%;"><b>จาก</b></td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 30%;"><b>ถึง</b></td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 8%;"><b>QT.</b></td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 15%;"><b>หน่วยละ</b></td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 20%;"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
    </thead><tbody>';

$i = 1;
$sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBilling = array(
    array('select_pdfvehicletransportdocumentdriver-daiki', SQLSRV_PARAM_IN),
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


    $tbody3 .= '

        <tr style="border:1px solid #000;font-size:26px">
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 10%;font-size:25px">' . $i . '</td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 18%;font-size:25px">' . $result_seBilling['DATEVLIN_103'] . '</td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 16%;font-size:25px">' . $result_seBilling['DOCUMENTCODE'] . '</td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 15%;font-size:25px">' . $result_seBilling['THAINAME'] . '</td>
        <td style="border-right:1px solid #000;padding:13px;text-align:left;width: 15%;font-size:25px">' . $result_seEmployeeehr['FnameT'] . '</td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 30%;font-size:25px">'.$result_seBilling['JOBSTART'].'</td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 30%;font-size:25px">' . $result_seBilling['JOBEND']. '</td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;width: 8%;font-size:25px">1</td>
        <td style="border-right:1px solid #000;padding:13px;text-align:right;width: 15%;font-size:25px">' . number_format($result_seBilling['PRICE'], 2) . '</td>
        <td style="border-right:1px solid #000;padding:13px;text-align:right;width: 20%;font-size:25px">' . number_format($result_seBilling['PRICE'], 2) . '</td>
      </tr>
    ';
    $i++;
    $sumtotal = $sumtotal + $result_seBilling['PRICE'];
}


$tfoot3 = '</tbody><tfoot>
     <tr style="border:1px solid #000;font-size:25px">
        <td style="border-right:1px solid #000;padding:13px;text-align:center;font-size:25px"></td>
        <td style="border-right:1px solid #000;padding:13px;text-align:center;font-size:25px">ยอดรวมสุทธิ</td>
        <td colspan="7" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:25px">' . convert($sumtotal) . '</td>
        <td style="border-right:1px solid #000;padding:13px;text-align:right;font-size:25px">' . number_format($sumtotal, 2) . '</td>

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
$mpdf->WriteHTML($table_begin3);
$mpdf->WriteHTML($thead3);
$mpdf->WriteHTML($tbody3);
$mpdf->WriteHTML($tfoot3);
$mpdf->WriteHTML($table_end3);
$mpdf->WriteHTML($table_footer3);

$mpdf->Output();


sqlsrv_close($conn);
?>
