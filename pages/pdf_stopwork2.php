<?php

require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
$sql_seGetdate = "{call megStopwork(?)}";
$params_seGetdate = array(
    array('se_getdate', SQLSRV_PARAM_IN)
);
$query_seGetdate = sqlsrv_query($conn, $sql_seGetdate, $params_seGetdate);
$result_seGetdate = sqlsrv_fetch_array($query_seGetdate, SQLSRV_FETCH_ASSOC);

$mpdf = new mPDF();
$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';
$title = '<h2 style="text-align:center">เอกสารบันทึกการขอหยุด จากกิจกรรม "ขอบคุณที่หยุด" <br> (Thank you for stop activity record) <br> บันทึกของบริษัท ' . $_GET['comp'] . '</h2>';
$table_begin = '
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">';
$tr = '
    <tr style="border:1px solid #000;padding:4px;">
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="9%">วันที่<br>Date</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="13%">กระบวนการหยุด<br>Process stop</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="13%">เหตุผล<br>Reason</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="5%">เวลาที่เริ่มจอด<br>Start time of stop</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="5%">เวลาที่หยุดเสร็จ<br>Finish time of stop</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="8%">หมายเลขใบส่งสินค้า<br>Delivery note no.</td>
        
    </tr>';
$condition2 = "";
$condition3 = "";
if ($_GET['datestart'] != "" || $_GET['dateend'] != "") {
    $condition2 = " AND ( a.DATEINPUT BETWEEN convert(date, '".$_GET['datestart']."', 103) AND convert(date, '".$_GET['dateend']."', 103))";
}
if ($_GET['comp'] != "") {
    $COMP_IN = str_replace(",", "','", $_GET['comp']);
    $condition3 = " AND a.COMPANYCODE IN ('" . $COMP_IN . "')";
} else {
    $condition3 = " AND a.COMPANYCODE IN ('RATC','RCC','RIT','RKL','RKP','RKR','RKS','RTC','RTD')";
}

$condition1 = $condition2 . $condition3;

$sql_seStopwork = "{call megStopwork_v2(?,?)}";
$params_seStopwork = array(
    array('select_stopwork', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);

$td = '';
$query_seStopwork = sqlsrv_query($conn, $sql_seStopwork, $params_seStopwork);
while ($result_seStopwork = sqlsrv_fetch_array($query_seStopwork, SQLSRV_FETCH_ASSOC)) {

    $td .= '
    <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['DATEINPUT'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['STOPPROCESS'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['REASON'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['STARTTIME'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['STOPTIME'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['PRODUCTNUMBER'] . '</td>
    </tr>';
}
$table_end = '</table>';
$footer = '<h2 style="text-align:center">"หยุด" ไม่โดน (ทำโทษ)</h2>';
$issuedby = '<p style="text-align:right;font-size: 8px">Issued by ' . $_GET['employeename'] . ' / Date ' . $result_seGetdate['ISSUEDDATE'] . '</p>';

$mpdf->WriteHTML($style);
$mpdf->WriteHTML($title);
$mpdf->WriteHTML($table_begin);
$mpdf->WriteHTML($tr);
$mpdf->WriteHTML($td);
$mpdf->WriteHTML($table_end);
$mpdf->WriteHTML($footer);
$mpdf->SetFooter($issuedby);
$mpdf->Output();

sqlsrv_close($conn);
?>

