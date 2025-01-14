
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

$condTenko0 = " AND a.VEHICLETRANSPORTPLANID = '".$_GET['vehicletransportplanid']."' ";
$sql_seTenko0 = "{call megEdittenkomaster_v2(?,?)}";
$params_seTenko0 = array(
    array('select_tenkomaster', SQLSRV_PARAM_IN),
    array($condTenko0, SQLSRV_PARAM_IN)
);
$query_seTenko0 = sqlsrv_query($conn, $sql_seTenko0, $params_seTenko0);
$result_seTenko0 = sqlsrv_fetch_array($query_seTenko0, SQLSRV_FETCH_ASSOC);

$condTenko1 = " AND a.TENKOMASTERDIRVERCODE = '".$result_seTenko0['TENKOMASTERDIRVERCODE1']."' ";
$sql_seTenko1 = "{call megEdittenkomaster_v2(?,?)}";
$params_seTenko1 = array(
    array('select_tenkosummary', SQLSRV_PARAM_IN),
    array($condTenko1, SQLSRV_PARAM_IN)
);
$query_seTenko1 = sqlsrv_query($conn, $sql_seTenko1, $params_seTenko1);
$result_seTenko1 = sqlsrv_fetch_array($query_seTenko1, SQLSRV_FETCH_ASSOC);

$TENKOPRESSURERESULT1 = ($result_seTenko1['TENKOPRESSURERESULT']=="1")?"Y":"N";
$TENKOTEMPERATURERESULT1 = ($result_seTenko1['TENKOTEMPERATURERESULT']=="1")?"Y":"N";
$TENKOALCOHOLRESULT_BEFORE1 = ($result_seTenko1['TENKOALCOHOLRESULT_BEFORE']=="1")?"Y":"N"; 
$TENKORESTRESULT1 = ($result_seTenko1['TENKORESTRESULT']=="1")?"Y":"N"; 
$TENKOOXYGENRESULT1  = ($result_seTenko1['TENKOOXYGENRESULT']=="1")?"Y":"N"; 



$condTenko2 = " AND a.TENKOMASTERDIRVERCODE = '".$result_seTenko0['TENKOMASTERDIRVERCODE2']."'";
$sql_seTenko2 = "{call megEdittenkomaster_v2(?,?)}";
$params_seTenko2 = array(
    array('select_tenkosummary', SQLSRV_PARAM_IN),
    array($condTenko2, SQLSRV_PARAM_IN)
);
$query_seTenko2 = sqlsrv_query($conn, $sql_seTenko2, $params_seTenko2);
$result_seTenko2 = sqlsrv_fetch_array($query_seTenko2, SQLSRV_FETCH_ASSOC);


$TENKOPRESSURERESULT2 = ($result_seTenko2['TENKOPRESSURERESULT']=="1")?"Y":"N";
$TENKOTEMPERATURERESULT2 = ($result_seTenko2['TENKOTEMPERATURERESULT']=="1")?"Y":"N";
$TENKOALCOHOLRESULT_BEFORE2 = ($result_seTenko2['TENKOALCOHOLRESULT_BEFORE']=="1")?"Y":"N"; 
$TENKORESTRESULT2 = ($result_seTenko2['TENKORESTRESULT']=="1")?"Y":"N"; 
$TENKOOXYGENRESULT2  = ($result_seTenko2['TENKOOXYGENRESULT']=="1")?"Y":"N"; 

$table_1 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
    <tr style="border:1px solid #000;padding:4px;">
     <th width="3%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">'.$_GET['vehicletransportplanid'].'</th>
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">วันที่ตรวจ</th>
      <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">รหัสพนักงาน</th>
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ชื่อ-นามสกุล</th>
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">อายุคน</th>
        <th width="5%" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">อายุงาน</th>
        <th width="5%"  rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">ชม.<br>พักผ่อน</th>
        <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">ความดันโลหิต</th>
      <th colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</th>
        <th colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">แอลกอฮอล์</th>
        <th colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</th>
        <th colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
     <th width="5%" style="border-right:1px solid #000;padding:4px;text-align:center;">ค่าบน</th>
        <th width="5%" style="border-right:1px solid #000;padding:4px;text-align:center;">ค่าล่าง</th>
        <th width="3%" style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th width="5%" style="border-right:1px solid #000;padding:4px;text-align:center;">ชีพจร</th>
        <th width="3%" style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th width="5%" style="border-right:1px solid #000;padding:4px;text-align:center;">อุณหภูมิ</th>
        <th width="3%" style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th width="5%" style="border-right:1px solid #000;padding:4px;text-align:center;">ก่อน</th>
        <th width="3%" style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th width="5%" style="border-right:1px solid #000;padding:4px;text-align:center;">หลัง</th>
        <th width="5%" style="border-right:1px solid #000;padding:4px;text-align:center;">REST</th>
        <th width="3%" style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th width="5%" style="border-right:1px solid #000;padding:4px;text-align:center;">H2O</th>
        <th width="3%" style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</th>
        <th width="7%" style="border-right:1px solid #000;padding:4px;text-align:center;">สรุปผล</th>
    </tr>
    </thead> 
    <tbody>
    
    <tr style="border:1px solid #000;padding:4px;">
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko1['TENKOMASTERID'].'</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko1['DATEINPUT_F1'].'</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko1['TENKOMASTERDIRVERCODE'].'</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko1['TENKOMASTERDIRVERNAME'].'</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko1['year'].'</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko1['startdate'].'</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">มาตฐาน =></td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">< 160</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">> 90</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</th>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">< 38</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">[0]</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">[0]</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">> 8</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">H2O</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">สรุปผล</td>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
     <td colspan="3" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
     <td colspan="3" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko1['TENKORESTDATA'].'</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko1['TENKOPRESSUREDATA_90160'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko1['TENKOPRESSUREDATA_60100'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$TENKOPRESSURERESULT1.'</th>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko1['TENKOTEMPERATUREDATA'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$TENKOTEMPERATURERESULT1.'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko1['TENKOALCOHOLDATA_BEFORE'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$TENKOALCOHOLRESULT_BEFORE1.'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko1['TENKOALCOHOLDATA_AFTER'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko1['TENKORESTDATA'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$TENKORESTRESULT1.'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko1['TENKOOXYGENDATA'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$TENKOOXYGENRESULT1.'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko2['TENKOMASTERID'].'</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko2['DATEINPUT_F1'].'</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko2['TENKOMASTERDIRVERCODE'].'</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko2['TENKOMASTERDIRVERNAME'].'</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko2['year'].'</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko2['startdate'].'</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">มาตฐาน =></td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">< 160</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">> 90</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</th>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">< 38</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">[0]</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">[0]</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">ผล</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">> 8</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">H2O</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">สรุปผล</td>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
     <td colspan="3" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
     <td colspan="3" rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko2['TENKORESTDATA'].'</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko2['TENKOPRESSUREDATA_90160'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko2['TENKOPRESSUREDATA_60100'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$TENKOPRESSURERESULT2.'</th>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko2['TENKOTEMPERATUREDATA'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$TENKOTEMPERATURERESULT2.'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko2['TENKOALCOHOLDATA_BEFORE'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$TENKOALCOHOLRESULT_BEFORE2.'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko2['TENKOALCOHOLDATA_AFTER'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko2['TENKORESTDATA'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$TENKORESTRESULT2.'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seTenko2['TENKOOXYGENDATA'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$TENKOOXYGENRESULT2.'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
    </tr>
  </tbody></table>
    <table id="bg-table" width="20%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
    <tr style="border:1px solid #000;padding:4px;">
     <th width="33%" style="border-right:1px solid #000;padding:4px;text-align:center;">ครั้ง</th>
        <th width="33%" style="border-right:1px solid #000;padding:4px;text-align:center;">ผ่าน</th>
      <th width="33%" style="border-right:1px solid #000;padding:4px;text-align:center;">ไม่ผ่าน</th>
    </tr>
    </thead> 
    <tbody>
    <tr style="border:1px solid #000;padding:4px;">
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">ค่าบน</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">ค่าบน</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;">ค่าบน</td>
     </tr>
    </tbody></table>


';



$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_1);

$mpdf->Output();

sqlsrv_close($conn);
?>

