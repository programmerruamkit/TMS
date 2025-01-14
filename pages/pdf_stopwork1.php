<?php

require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
//$mpdf = new mPDF();
$mpdf = new mPDF('th', 'A4-L', '0', '');
$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';
$h2 = '<h2 style="text-align:center">เอกสารบันทึกการขอหยุด จากกิจกรรม "ขอบคุณที่หยุด"</h2>';
$table_begin = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">';
$tr = '<tr style="border:1px solid #000;padding:4px;">
        <td width="6%" rowspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;">วันที่</td>
        <td width="5%" rowspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;">กระบวนการหยุด</td>
        <td width="5%" rowspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;">เหตุผล</td>
        <td width="10%" rowspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;">ชื่อ-สกุล (พขร.)</td>
        <td width="4%" rowspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;">อายุ</td>
        <td width="4%" rowspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;">อายุงาน</td>
        <td width="5%" rowspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;">Trailer No.s</td>
        <td width="5%" rowspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;">ประเภทรถ</td>
        <td width="5%" rowspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;">สถานะรถ</td>
        <td width="5%" rowspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;">ทะเบียนรถ</td>
        <td width="5%" rowspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;">จุดจอด</td>
        <td width="5%" rowspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;">เวลาที่เริ่มหยุด</td>
        <td width="5%" rowspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;">เวลาที่หยุดเสร็จ</td>
        <td width="5%" rowspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;">เวลา Tenko</td>
        <td colspan="4"  style="border-right:1px solid #000;padding:4px;text-align:center;">งานที่รับ/เวลา</td>
        <td width="6%" rowspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;">หมายเลขใบส่งสินค้า</td>
        
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <td width="10%" colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;">เที่ยวที่ 1</td>
        <td width="10%" colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:center;">เที่ยวที่ 12        </td>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <td width="5%" style="border-right:1px solid #000;padding:4px;text-align:center;" >งาน</td>
        <td width="5%" style="border-right:1px solid #000;padding:4px;text-align:center;" >เวลา</td>
        <td width="5%" style="border-right:1px solid #000;padding:4px;text-align:center;" >งาน</td>
        <td width="5%" style="border-right:1px solid #000;padding:4px;text-align:center;" >เวลา</td>
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

    
    
    $td .= '<tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['DATEINPUT'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['STOPPROCESS'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['REASON'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['EMPLOYEENAME'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['year'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['yearwork'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['THAINAME'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['VEHICLETYPEDESC'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['CARSTATUS'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['VEHICLEREGISNUMBER'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['PARKINGN'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['STARTTIME'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['STOPTIME'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['TENKOTIME'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['JOBINPUT'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['TIMEINPUT'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['JOBINPUT2'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['TIMEINPUT2'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seStopwork['PRODUCTNUMBER'] . '</td>
    </tr>';
}
$table_end = '</table>';
$mpdf->WriteHTML($style);
$mpdf->WriteHTML($h2);
$mpdf->WriteHTML($table_begin);
$mpdf->WriteHTML($tr);
$mpdf->WriteHTML($td);
$mpdf->WriteHTML($table_end);
$mpdf->Output();

sqlsrv_close($conn);
?>

