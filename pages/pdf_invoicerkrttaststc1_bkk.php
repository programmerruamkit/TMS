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


$condBilling1 = " AND c.COMPANYCODE = '".$_GET['companycode']."' AND c.CUSTOMERCODE = '".$_GET['customercode']."'";
$condBilling2 = " AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103) ";

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
<td colspan="2" style="text-align:center;font-size:18px;"><b>รายงานสรุปรายการวางบิลลูกค้า</b></td>

</thead>
<tbody>
<tr>
<td colspan="2" style="text-align:center;font-size:12px;"><b>' . $date_now . ' (ค่าขนส่งปกติ)</b></td>
</tr>

<tr>
<td colspan="2">&nbsp;</td>
</tr>

</tbody>
</table>';



$i = 1;
$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '".$_GET['invoicecode']."'";

$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);


$sql_seBilling1 = "SELECT DISTINCT a.BILLINGDATE,a.INVOICECODE,'1' AS 'NUMBER',b.JOBSTART,b.JOBEND,d.LOCATION ,d.[PRICE] AS 'PRICETON',
CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CASE
WHEN b.REMARK = 'Charge 7' THEN 7000
WHEN b.REMARK = 'Charge 10' THEN 10000
ELSE CONVERT(INT,b.WEIGHTIN)
END) / 1000) * d.[PRICE]) AS 'PRICE',


CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CASE
WHEN b.REMARK = 'Charge 7' THEN 7000
WHEN b.REMARK = 'Charge 10' THEN 10000
ELSE CONVERT(INT,b.WEIGHTIN)
END) / 1000) * d.[PRICE]) AS 'PRICEAC',

b.REMARK,a.BILLING
FROM [dbo].[LOGINVOICE] a
INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] d ON b.[VEHICLETRANSPORTPRICEID] = d.[VEHICLETRANSPORTPRICEID]
WHERE c.COMPANYCODE = '".$_GET['companycode']."' AND c.CUSTOMERCODE = '".$_GET['customercode']."'
AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103) ";

$query_seBilling1 = sqlsrv_query($conn, $sql_seBilling1, $params_seBilling1);
while ($result_seBilling1 = sqlsrv_fetch_array($query_seBilling1, SQLSRV_FETCH_ASSOC)) {

    $sql_seBilling2 = "SELECT SUM(CONVERT(DECIMAL(10,3),WEIGHTIN)/1000) AS 'WEIGHTIN' FROM [VEHICLETRANSPORTDOCUMENTDIRVER] b
    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
    WHERE c.COMPANYCODE = '".$_GET['companycode']."' AND c.CUSTOMERCODE = '".$_GET['customercode']."'
    AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103)
    AND b.JOBSTART = '".$result_seBilling1['JOBSTART']."' AND b.JOBEND = '".$result_seBilling1['JOBEND']."'  ";
    $query_seBilling2 = sqlsrv_query($conn, $sql_seBilling2, $params_seBilling2);
    $result_seBilling2 = sqlsrv_fetch_array($query_seBilling2, SQLSRV_FETCH_ASSOC);

    $table_begin1 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">';
    $thead1 = '<thead>
  <tr>
  <td colspan="10" style="text-align:left;font-size:16px;"><b>หมายเลขบัญชี :' . $result_seBilling1['INVOICECODE'] . ' </b></td>
  </tr>
  <tr style="border:1px solid #000;padding:4px;">

  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>วันที่ใบแจ้งหนี้</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ใบแจ้งหนี้</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ประเภทรถ</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>จาก</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ถึง</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;"><b>Zone</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ปริมาณ(ตัน)</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>อัตรา(บาท/ตัน)</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ราคา(บาท)</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ราคาจริง(บาท)</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ผลต่าง</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>หมายเหตุ</b></td>
  </tr>
  </thead><tbody>';

$priceac=number_format($result_seBilling2['WEIGHTIN'],3)*$result_seBilling1['PRICETON'];

    $tbody1 .= '

  <tr style="border:1px solid #000;">
  <td style="border-right:1px solid #000;padding:5px;text-align:center;">' . $result_seBilling1['BILLINGDATE'] . '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:center;">' . $result_seBilling1['INVOICECODE'] . '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:center;">10 W</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:center;">STC Amatanakorn</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:center;">' . $result_seBilling1['JOBEND'] . '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:center;">' . $result_seBilling1['LOCATION'] . '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:right;">' . number_format($result_seBilling2['WEIGHTIN'],3) . '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:right;">' . $result_seBilling1['PRICETON'] . '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:right;">' . number_format($result_seBilling1['PRICE'], 2) . '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:right;">' .number_format((number_format($result_seBilling2['WEIGHTIN'],3))*($result_seBilling1['PRICETON']),2). '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:right;">'.strtr(number_format(($result_seBilling1['PRICE'])-($result_seBilling2['WEIGHTIN']*$result_seBilling1['PRICETON']),2),'-',' ').'  </td>
  <td style="border-right:1px solid #000;padding:5px;text-align:center;">' . $result_seBilling1['REMARK'] . '</td>
  </tr>';
    $i++;
    $sumtotalton = $sumtotalton + $result_seBilling2['WEIGHTIN'];
    $sumtotalprice = $sumtotalprice + $result_seBilling1['PRICE'];
}

$tfoot1 = '</tbody><tfoot>
<tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>รวม<b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;"><b>' .number_format( $sumtotalton,3) . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
<td style="border-right:1px solid #000;padding:5px;text-align:right;"><b>' . number_format($sumtotalprice, 2) . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
</tr>
</tfoot>';


$table_end1 = '</table>';

$table_footer1 = '<table style="width: 100%;">
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
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////



$mpdf->WriteHTML($style);

$mpdf->WriteHTML($table_header1);
$mpdf->WriteHTML($table_begin1);
$mpdf->WriteHTML($thead1);
$mpdf->WriteHTML($tbody1);
$mpdf->WriteHTML($tfoot1);
$mpdf->WriteHTML($table_end1);
$mpdf->WriteHTML($table_footer1);

$mpdf->Output();


sqlsrv_close($conn);
?>
