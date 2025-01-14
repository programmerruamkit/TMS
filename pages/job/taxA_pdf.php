<?php
ob_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");

$mpdf = new mPDF();
$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';
$title = '<h2 style="text-align:center">รายงานแจ้งเตือนหมดอายุข้อมูลภาษี</h2>';
$table_begin = '
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">';
$tr = '
    <tr style="border:1px solid #000;padding:4px;">
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="15%">วันที่เริ่มเสียภาษี</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="15%">วันที่หมดอายุ</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%">ราคา (ราคา)</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%">ค่าธรรมเนียม</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="15%">ผู้ดำเนินการ</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="25%">สถานที่</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%">เหลือ(วัน)</td>
        
    </tr>';
$sql_seWarning = "{call megVehicletax_v2(?)}";
$params_seWarning = array(
    array('get_vehicletaxA', SQLSRV_PARAM_IN)
);
$query_seWarning = sqlsrv_query($conn, $sql_seWarning, $params_seWarning);
while ($result_seWarning = sqlsrv_fetch_array($query_seWarning, SQLSRV_FETCH_ASSOC)) {

    $td .= '                          
            <tr style="border:1px solid #000;">
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['TAXDATE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['EXPIREDDATE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['PRICE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['SERVICEFEE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['WHOPROCESS'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['PLACE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['WARNINGDAY'] . '</td>
            </tr>';
}
$table_end = '</table>';
$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);
$filename = '../pdffile/' . '0102_' . $result_getDate['GETDATE'] . '_unsuccess.pdf';
$mpdf->WriteHTML($style);
$mpdf->WriteHTML($title);
$mpdf->WriteHTML($table_begin);
$mpdf->WriteHTML($tr);
$mpdf->WriteHTML($td);
$mpdf->WriteHTML($table_end);
$mpdf->Output($filename);
sqlsrv_close($conn);
?>
<script langauge="javascript">
    window.open('', '_self');
    self.close();
</script>