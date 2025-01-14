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
//$h2 = '<h2 style="text-align:center">เอกสารบันทึกการขอหยุด จากกิจกรรม "ขอบคุณที่หยุด"</h2>';
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $date_now = "";
} else {
    $date_now = $_GET['datestart'] . ' ถึง ' . $_GET['dateend'];
}
$table_begin = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">';
$tr = '
        <tr style="border:1px solid #000;padding:4px;">
            <td width="10%"  style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            <td  colspan="8"  style="border-right:1px solid #000;padding:4px;text-align:left;">ประจำวันที่ ' . $date_now . '</td>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
            <td width="2%"  style="border-right:1px solid #000;padding:4px;text-align:center;">No</td>
            <td width="10%"  style="border-right:1px solid #000;padding:4px;text-align:center;">DIRVER</td>
            <td width="15%"  style="border-right:1px solid #000;padding:4px;text-align:center;">ISSUE</td>
            <td width="15%"  style="border-right:1px solid #000;padding:4px;text-align:center;">TENKO</td>
            <td width="15%" style="border-right:1px solid #000;padding:4px;text-align:center;">REFORMATION</td>
            <td width="10%"  style="border-right:1px solid #000;padding:4px;text-align:center;">RESPONSIBLEPERSON</td>
            <td width="5%" style="border-right:1px solid #000;padding:4px;text-align:center;">FINISH</td>
            <td width="10%"  style="border-right:1px solid #000;padding:4px;text-align:center;">STATUS</td>
            <td width="8%"  style="border-right:1px solid #000;padding:4px;text-align:center;">REMARK</td>
        </tr>
  ';

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

$sql_seTenko = "{call megTenko_v2(?,?)}";
$params_seTenko = array(
    array('select_tenko', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);

$td = '';
$i = 1;
$query_seTenko = sqlsrv_query($conn, $sql_seTenko, $params_seTenko);
while ($result_seTenko = sqlsrv_fetch_array($query_seTenko, SQLSRV_FETCH_ASSOC)) {

    $td .= '<tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $i . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seTenko['EMPLOYEENAME'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seTenko['ISSUE'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seTenko['TENKO'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seTenko['REFORMATION'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seTenko['RESPONSIBLEPERSON'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seTenko['FINISHDATE'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seTenko['STATUS'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seTenko['REMARK'] . '</td>
           
            
    </tr>';
    $i++;
}
$table_end = '</table>';
$mpdf->WriteHTML($style);
//$mpdf->WriteHTML($h2);
$mpdf->WriteHTML($table_begin);
$mpdf->WriteHTML($tr);
$mpdf->WriteHTML($td);
$mpdf->WriteHTML($table_end);
$mpdf->Output();

sqlsrv_close($conn);
?>

