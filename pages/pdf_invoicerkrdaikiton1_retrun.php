<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
$sumgmtweight = "";
$sumcusweight = "";
$sumamounttrip = "";
$sumtotal = "";
if ($_GET['startdate'] == "" || $_GET['enddate'] == "") {
    $date_now = "";
} else {
    $date_now = $_GET['startdate'] . '-' . $_GET['enddate'];
}

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$condBilling1_s1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condBilling2_s1 = " AND b.REMARK = 'ไม่คิดขั้นต่ำ' AND c.C8 = 'return'";
$sql_seBilling_s1 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBilling_s1 = array(
    array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
    array($condBilling1_s1, SQLSRV_PARAM_IN),
    array($condBilling2_s1, SQLSRV_PARAM_IN)
);
$query_seBilling_s1 = sqlsrv_query($conn, $sql_seBilling_s1, $params_seBilling_s1);
$result_seBilling_s1 = sqlsrv_fetch_array($query_seBilling_s1, SQLSRV_FETCH_ASSOC);

$condBilling1_s2 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condBilling2_s2 = " AND b.REMARK = 'Charge 12' AND c.C8 = 'return'";
$sql_seBilling_s2 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBilling_s2 = array(
    array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
    array($condBilling1_s2, SQLSRV_PARAM_IN),
    array($condBilling2_s2, SQLSRV_PARAM_IN)
);
$query_seBilling_s2 = sqlsrv_query($conn, $sql_seBilling_s2, $params_seBilling_s2);
$result_seBilling_s2 = sqlsrv_fetch_array($query_seBilling_s2, SQLSRV_FETCH_ASSOC);




//$invoicecode = create_invoice();

$mpdf = new mPDF('th', 'A4', '0', '');
$style = '
<style>
body{
  font-family: "Garuda";font-size:12px//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
}									

</style>';



$table_header1 = '<table style="width: 100%;">
<thead>
<tr>
<td colspan="2" style="text-align:center;font-size:18px;"><b>เอกสารแนบโหลดสินค้าค้างเพื่อจัดส่งในวันถัดไป</b></td>

</thead>
<tbody>


<tr>
<td colspan="2">&nbsp;</td>
</tr>

</tbody>
</table>';


$table_begin1 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">';
$thead1 = '<thead>
  <tr>
  <td colspan="5" style="text-align:left;font-size:16px;"><b>หมายเลขบัญชี :- </b></td>
  <td colspan="5" style="text-align:right;font-size:16px;"><b>ใบแจ้งหนี้ : '.$_GET['invoicecode'].' </b></td>
  </tr>
  <tr style="border:1px solid #000;padding:4px;">

  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;"><b>ลำดับ</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>วันที่</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>หมายเลข DO</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>หมายเลขรถ</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>พนักงาน</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>จาก</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ถึง</b></td>
  
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>QT</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>หน่วยละ</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>จำนวนเงิน</b></td>
  
  
  </tr>
  </thead><tbody>';
$condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condBilling2 = " AND b.REMARK = 'ไม่คิดขั้นต่ำ' AND c.C8 = 'return'";
$sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBilling = array(
    array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN)
);


$i = 1;
$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
    $tbody1 .= '
        
  <tr style="border:1px solid #000;">
  <td style="border-right:1px solid #000;padding:5px;text-align:center;">' . $i . '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:left;">' . $result_seBilling['PAYMENTDATEDDMMYY'] . '</td>
       <td style="border-right:1px solid #000;padding:5px;text-align:left;">' . $result_seBilling['DOCUMENTCODE'] . '</td>
           
  <td style="border-right:1px solid #000;padding:5px;text-align:left;">' . $result_seBilling['EMPLOYEENAME1'] . '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:left;">' . $result_seBilling['THAINAME'] . '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:left;">' . $result_seBilling['JOBSTART'] . '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:left;">' . $result_seBilling['JOBEND'] . '</td>
 <td style="border-right:1px solid #000;padding:5px;text-align:left;">1</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:left;">' . $result_seBilling['PRICE'] . '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:left;">' . $result_seBilling['ACTUALPRICE'] . '</td>
  
  </tr>';
    $i++;
    $rs3 = $rs3+$result_seBilling['WEIGHTINTON'];
    $rs4 = $rs4+$result_seBilling['ACTUALPRICE'];
}

$tfoot1 = '</tbody><tfoot>
<tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ยอดรวมสุทธิ<b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="7"></td>td>
<td style="border-right:1px solid #000;padding:4px;text-align:left;">'.$rs4.'</td>

</tr>
</tfoot>';


$table_end1 = '</table>';

$table_footer1 = '<table style="width: 100%;">
<tbody>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
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

/////////////////////////////////////////////////////////


$mpdf->WriteHTML($style);
if($result_seBilling_s1['DOCUMENTCODE'] != '')
{
$mpdf->WriteHTML($table_header1);
$mpdf->WriteHTML($table_begin1);
$mpdf->WriteHTML($thead1);
$mpdf->WriteHTML($tbody1);
$mpdf->WriteHTML($tfoot1);
$mpdf->WriteHTML($table_end1);
$mpdf->WriteHTML($table_footer1);
}

$mpdf->Output();


sqlsrv_close($conn);
?>
