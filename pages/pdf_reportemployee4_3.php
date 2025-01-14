
<?php

require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
//$mpdf = new mPDF();
$mpdf = new mPDF('th', 'A4', '0', '');
$employee = ($_GET['employee'] != "") ? " AND a.TENKOMASTERDIRVERNAME = '".$_GET['employee']."'":"";
$area  = ($_GET['area'] == 'amata') ? " AND c.Company_Code IN ('RKS','RKR','RKL')":" AND c.Company_Code IN ('RATC','RCC','RRC')";
$condiTenkobefore = " AND CONVERT(DATE,a.CREATEDATE) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)".$employee.$area;
$sql_seTenkobrfore = "{call megEdittenkobefore_v2(?,?,?)}";
$params_seTenkobrfore = array(
    array('select_tenkobefore', SQLSRV_PARAM_IN),
    array($condiTenkobefore, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seTenkobrfore = sqlsrv_query($conn, $sql_seTenkobrfore, $params_seTenkobrfore);

    $style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';


    $table_1 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
<tr style="border:1px solid #000;padding:4px;">
     <th colspan="8" style="border-right:1px solid #000;padding:4px;text-align:left;"><b>รายงานเอกสารเท็งโกะประจำวันที่ '.$_GET['datestart'].'-'.$_GET['dateend'].'</b></th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
     <th width="20%" style="border-right:1px solid #000;padding:4px;text-align:center;">รหัสพนักงาน</th>
        <th width="20%" style="border-right:1px solid #000;padding:4px;text-align:center;">ชื่อ-นามสกุล</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">ความดันบน</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">ความดันล่าง</th>
        <th width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">แอลกอฮอล์</th>
        <th  width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">ออกซิเจน</th>
        <th  width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">อุณหภูมิ</th>
        <th  width="10%" style="border-right:1px solid #000;padding:4px;text-align:center;">ตารางพักผ่อน</th>
    </tr>
    </thead> 
    <tbody>';
    while ($result_seTenkobrfore = sqlsrv_fetch_array($query_seTenkobrfore, SQLSRV_FETCH_ASSOC)) {
        
    
    $table_1 .= '<tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">'.$result_seTenkobrfore['TENKOMASTERDIRVERCODE'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">'.$result_seTenkobrfore['TENKOMASTERDIRVERNAME'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">'.$result_seTenkobrfore['TENKOPRESSUREDATA_90160'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">'.$result_seTenkobrfore['TENKOPRESSUREDATA_60100'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">'.$result_seTenkobrfore['TENKOALCOHOLDATA'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">'.$result_seTenkobrfore['TENKOOXYGENDATA'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">'.$result_seTenkobrfore['TENKOTEMPERATUREDATA'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">'.$result_seTenkobrfore['TENKORESTDATA'].'</td>

      </tr>';
    }
    
    $table_1 .='</tbody></table>';


    $mpdf->WriteHTML($style);
    $mpdf->WriteHTML($table_1);


    $mpdf->Output();

    sqlsrv_close($conn);
    ?>

