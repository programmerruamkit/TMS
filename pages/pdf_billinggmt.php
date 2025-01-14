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
$condBilling2 = " AND a.COMPANYCODE = 'RRC' AND a.CUSTOMERCODE = 'GMT' AND a.MATERIALTYPE = '" . $_GET['materialtype'] . "'";
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
            <td style="width: 50%;">ลูกค้า บจก.กรีน เมทัลส์(ประเทศไทย)</td>
            <td style="width: 50%;text-align:right">วันที่ ' . $result_getDate['SYSDATE'] . '</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;">ที่อยู่ 254 หมู่ 7 นิคมอุตสาหกรรมเกตเวย์ชิตี้</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;">ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190</td>
       </tr>
    </tbody>
</table>';

$table_begin = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">';
$thead = '<thead>
 
        <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;"><b>No.</b></td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>D / M /Y</b></td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>Driver</b></td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Truck No.</b></td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Delivery</b></td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Weight (Tons)</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Price</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Total</b></td>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>From</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>To</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>GMT weight</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>CUS weight</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Baht/Trips</b></td>
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



$condTotal1 = " AND CONVERT(DATE,DATEVLIN) = CONVERT(DATE,GETDATE())";
$condTotal2 = " AND COMPANYCODE = 'RRC' AND CUSTOMERCODE = 'BP' AND MATERIALTYPE = '".$_GET['materialtype']."'";
$sql_seTotal = "{call megVehicletransportplan_v2(?,?,?)}";
$params_seTotal = array(
    array('select_sumtotal', SQLSRV_PARAM_IN),
    array($condTotal1, SQLSRV_PARAM_IN),
    array($condTotal2, SQLSRV_PARAM_IN)
);
$query_seTotal = sqlsrv_query($conn, $sql_seTotal, $params_seTotal);
$result_seTotal = sqlsrv_fetch_array($query_seTotal, SQLSRV_FETCH_ASSOC);

$condWeighin = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE())";
$sql_seWeighin = "{call megVehicleweigh_v2(?,?)}";
$params_seWeighin = array(
    array('select_sumweighin', SQLSRV_PARAM_IN),
    array($condWeighin, SQLSRV_PARAM_IN)
);
$query_seWeighin = sqlsrv_query($conn, $sql_seWeighin, $params_seWeighin);
$result_seWeighin = sqlsrv_fetch_array($query_seWeighin, SQLSRV_FETCH_ASSOC);

$condWeighout = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE())";
$sql_seWeighout = "{call megVehicleweigh_v2(?,?)}";
$params_seWeighout = array(
    array('select_sumweighout', SQLSRV_PARAM_IN),
    array($condWeighout, SQLSRV_PARAM_IN)
);
$query_seWeighout = sqlsrv_query($conn, $sql_seWeighout, $params_seWeighout);
$result_seWeighout = sqlsrv_fetch_array($query_seWeighout, SQLSRV_FETCH_ASSOC);


$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
    $condWeigh = " AND a.VEHICLETRANSPORTPLANID = '" . $result_seBilling['VEHICLETRANSPORTPLANID'] . "'";
    $sql_seWeigh = "{call megVehicleweigh_v2(?,?)}";
    $params_seWeigh = array(
        array('select_vehicleweigh', SQLSRV_PARAM_IN),
        array($condWeigh, SQLSRV_PARAM_IN)
    );
    $query_seWeigh = sqlsrv_query($conn, $sql_seWeigh, $params_seWeigh);
    $result_seWeigh = sqlsrv_fetch_array($query_seWeigh, SQLSRV_FETCH_ASSOC);
    $tbody = '
         
        <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $i . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['DATE_VLIN'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['EMPLOYEENAME1'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['VEHICLEREGISNUMBER1'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['JOBSTART'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['JOBEND'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seWeigh['WEIGHIN1'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seWeigh['WEIGHSUM'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['ACTUALPRICE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['ACTUALPRICE'] . '</td>
      </tr>
    ';
}
$tfoot = '</tbody><tfoot>
     <tr style="border:1px solid #000;">
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;">PRODUCT : ' . $result_seBillings['MATERIALTYPE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seWeighin['SUMWEIGHIN'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seWeighout['WEIGHSUM'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTotal['SUMTOTAL'] . '</td>
    </tfoot>';
$i++;

$table_end = '</table>';

$table_footer = '<table style="width: 100%;">
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

