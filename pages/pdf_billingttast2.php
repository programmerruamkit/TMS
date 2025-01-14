<?php

require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
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

$condBilling1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)";
$condBilling2 = " AND a.COMPANYCODE = 'RRC' AND a.CUSTOMERCODE = 'TTAST'";
$sql_seBillings = "{call megVehicletransportplan_v2(?,?,?,?)}";
$params_seBillings = array(
    array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
$result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);

$mpdf = new mPDF('th', 'A4', '0', '');
$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';
$table_header = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="2" style="text-align:center"><b>ใบส่งสินค้า</b></td>
    </thead>
    <tbody>
        <tr>
            <td colspan="2">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด (RUAMKIT RECYCLE CARRIER CO.,LTD.)</td>
       </tr>
       <tr>
            <td colspan="2">สำนักงานใหญ่ 104 ซอยบางนา-ตราด 14 แขวงบางนา เขตบางนา กรุงเทพมหานคร</td>
       </tr>
       <tr>
            <td colspan="2">สำนักงานสาขา 109/1 หมู่ที่ 9 ตำบลหัวสำโรง อำเภอแปลงยาว จังหวัดฉะเชิงเทรา</td>
       </tr>
       <tr>
            <td colspan="2">&nbsp;</td>
       </tr>
       <tr>
            <td style="width: 50%;">เลขประจำตัวผู้เสียภาษี 0105551065951</td>
            <td style="width: 50%;text-align:right">เลขที่ IV-' . $result_seBillings['JOBNO'] . '</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;">&nbsp;</td>
       </tr>
       <tr>
            <td style="width: 50%;">ลูกค้า บริษัท ทีที ออโตโมทีฟ สตีล (ไทยแลนด์) จำกัด</td>
            <td style="width: 50%;text-align:right">วันที่ ' . $result_getDate['SYSDATE'] . '</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;">ที่อยู่ 256 หมู่ที่ 7 นิคมอุตสาหกรรมเกตเวย์ซิตี้ ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;">ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190</td>
       </tr>
    </tbody>
</table>';

$table_begin = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">';
$thead = '<thead>
 
         <tr style="border:1px solid #000;">
                                                        <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;"><b>ลำดับ</th>
                                                        <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;">วันที่</th>
                                                        <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;">หมายเลข DO</th>
                                                        <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;">ทะเบียนรถ</th>
                                                        <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">พนักงาน</th>
                                                        <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;">จาก</th>
                                                        <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;">ถึง</th>
                                                        <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">จำนวนแพ็ค/เที่ยว</th>
                                                        <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">น้ำหนักรวม/เที่ยว</th>
                                                        <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;">QT.</th>
                                                        <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">หน่วยละ</th>
                                                       <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">จำนวนเงิน(บาท)</th>
                                                    </tr>
    </thead><tbody>';

$i = 1;

$sql_seBilling = "{call megVehicletransportplan_v2(?,?,?,?)}";
$params_seBilling = array(
    array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);



$condTotal1 = " AND CONVERT(DATE,DATEVLIN) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)";
$condTotal2 = " AND COMPANYCODE = 'RRC' AND CUSTOMERCODE = 'TTAST'";
$sql_seTotal = "{call megVehicletransportplan_v2(?,?,?)}";
$params_seTotal = array(
    array('select_sumtotal', SQLSRV_PARAM_IN),
    array($condTotal1, SQLSRV_PARAM_IN),
    array($condTotal2, SQLSRV_PARAM_IN)
);
$query_seTotal = sqlsrv_query($conn, $sql_seTotal, $params_seTotal);
$result_seTotal = sqlsrv_fetch_array($query_seTotal, SQLSRV_FETCH_ASSOC);


$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
    $condDoctran = " AND VEHICLETRANSPORTPLANID = '" . $result_seBilling['VEHICLETRANSPORTPLANID'] . "'";
    $sql_seDoctran = "{call megVehicletransportdocumentrrc_v2(?,?)}";
    $params_seDoctran = array(
        array('select_vehicletransportdocumentrrc', SQLSRV_PARAM_IN),
        array($condDoctran, SQLSRV_PARAM_IN)
    );
    $query_seDoctran = sqlsrv_query($conn, $sql_seDoctran, $params_seDoctran);
    $result_seDoctran = sqlsrv_fetch_array($query_seDoctran, SQLSRV_FETCH_ASSOC);

    $condCounttrip1 = " AND CONVERT(DATE,DATEVLIN) = CONVERT(DATE,GETDATE())";
    $condCounttrip2 = " AND a.COMPANYCODE = 'RRC' AND a.CUSTOMERCODE = 'TTAST'";
    $sql_seCounttrip = "{call megVehicletransportdocumentrrc_v2(?,?,?)}";
    $params_seCounttrip = array(
        array('select_counttrip', SQLSRV_PARAM_IN),
        array($condCounttrip1, SQLSRV_PARAM_IN),
        array($condCounttrip2, SQLSRV_PARAM_IN)
    );
    $query_seCounttrip = sqlsrv_query($conn, $sql_seCounttrip, $params_seCounttrip);
    $result_seCounttrip = sqlsrv_fetch_array($query_seCounttrip, SQLSRV_FETCH_ASSOC);

    $condCountweight1 = " AND CONVERT(DATE,DATEVLIN) = CONVERT(DATE,GETDATE())";
    $condCountweight2 = " AND a.COMPANYCODE = 'RRC' AND a.CUSTOMERCODE = 'TTAST'";
    $sql_seCountweight = "{call megVehicletransportdocumentrrc_v2(?,?,?)}";
    $params_seCountweight = array(
        array('select_countweight', SQLSRV_PARAM_IN),
        array($condCountweight1, SQLSRV_PARAM_IN),
        array($condCountweight2, SQLSRV_PARAM_IN)
    );
    $query_seCountweight = sqlsrv_query($conn, $sql_seCountweight, $params_seCountweight);
    $result_seCountweight = sqlsrv_fetch_array($query_seCountweight, SQLSRV_FETCH_ASSOC);

    $tbody = '<tr style="border:1px solid #000;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $i . '</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['DATE_VLIN'] . '</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seDoctran['DO'] . '</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['VEHICLEREGISNUMBER1'] . '</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['EMPLOYEENAME1'] . '</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['JOBSTART'] . '</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['JOBEND'] . '</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCounttrip['counttrip'] . '</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCountweight['countweight'] . '</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">1</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['ACTUALPRICE'] . '</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['ACTUALPRICE'] . '</td>
                                                        </tr>
    ';
    $i++;
}

$tfoot = '</tbody> <tfoot>
                                                    <tr style="border:1px solid #000;">
                                                        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>รวม</b></td>
                                                        <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCounttrip['counttrip'] . '</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCountweight['countweight'] . '</td>
                                                        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                    </tr>
                                                    <tr style="border:1px solid #000;">
                                                        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ยอดสุทธิ</b></td>
                                                        <td colspan="9" style="border-right:1px solid #000;padding:4px;text-align:center;">' . convert($result_seTotal['SUMTOTAL']) . '</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTotal['SUMTOTAL'] . '</td>
                                                    </tr>
                                                </tfoot>';


$table_end = '</table>';

$table_footer = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
    <tbody>
       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>
       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>
      
       <tr>
   		 <td style="width: 15%;text-align:right">ผู้จัดทำ</td>
            <td style="width: 35%;">........................................</td>
         <td style="width: 15%;text-align:right">ผู้ตรวจสอบ</td>
            <td style="width: 35%;">........................................</td>
       </tr>
       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>
       <tr>
   		 <td style="width: 15%;text-align:right">ผู้อนุมัติ</td>
            <td style="width: 35%;">........................................</td>
            <td style="width: 15%;text-align:right">ผู้รับสินค้า</td>
            <td style="width: 35%;">........................................</td>
       </tr>
       
    </tbody>
</table>';

$mpdf->WriteHTML($table_header);
$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_begin);
$mpdf->WriteHTML($thead);
$mpdf->WriteHTML($tbody);
$mpdf->WriteHTML($tfoot);
$mpdf->WriteHTML($table_end);
$mpdf->WriteHTML($table_footer);
$mpdf->Output();

sqlsrv_close($conn);
?>

