<?php
ob_start();
session_start();
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
date_default_timezone_set("Asia/Bangkok");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");
//$mpdf = new mPDF();
$mpdf = new mPDF('th', 'A4-L', '0', '');
$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';

$condition1 = " AND VEHICLETRANSPORTPLANID ='" . $_GET['vehicletransportplanid'] . "'";
$condition2 = "";
$condition3 = "";

$sql_seVehicletransportplan = "{call megVehicletransportplan_v2(?,?,?,?)}";
$params_seVehicletransportplan = array(
    array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN),
    array($condition2, SQLSRV_PARAM_IN),
    array($condition3, SQLSRV_PARAM_IN)
);
$query_seVehicletransportplan = sqlsrv_query($conn, $sql_seVehicletransportplan, $params_seVehicletransportplan);
$result_seVehicletransportplan = sqlsrv_fetch_array($query_seVehicletransportplan, SQLSRV_FETCH_ASSOC);
$employee2 = ($result_seVehicletransportplan['EMPLOYEENAME2'] != '') ? ' / 2.' . $result_seVehicletransportplan['EMPLOYEENAME2'] : '';


$table = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
                                                <thead>

                                                    <tr style="border:1px solid #000;padding:4px;">
                                                        <th colspan="12"  style="border-right:1px solid #000;padding:4px;text-align:center;">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด / RUAMKIT RECYCLE CARRIER CO.,LTD.</th>
                                                    </tr>
                                                     <tr style="border:1px solid #000;padding:4px;">
                                                        <th colspan="12"  style="border-right:1px solid #000;padding:4px;text-align:center;">เอกสารควบคุมการจัดส่ง / DELIVERY CONTROL DOCUMENT</th>
                                                    </tr>
                                                     <tr style="border:1px solid #000;padding:4px;">
                                                        <th colspan="12"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขประจำตัวผู้เสียภาษี 0105551065951 สาขาที่ 00001 ที่อยู่ 109/1 ม.9 ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190</th>
                                                    </tr>
                                                   
                                                    <tr style="border:1px solid #000;padding:4px;">
                                                        <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">พนักงานขับรถ / DRIVER</th>
                                                        <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ทะเบียนรถ / NO.</th>
                                                      
                                                        <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เดียว/S</th>
                                                        <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">พ่วง/F</th>
                                                        <th colspan="4" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">วันรับสินค้า/LOADING : <b>' . $result_seVehicletransportplan['DATE_VLIN'] . '</b></th>
                                                    </tr>
                                                    <tr style="border:1px solid #000;padding:4px;">
                                                        <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;"><b>' . '1.' . $result_seVehicletransportplan['EMPLOYEENAME1'] . $employee2 . '</b></th>
                                                        <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;"><b>' . $result_seVehicletransportplan['VEHICLEREGISNUMBER1'] . '</b></th>
                                                        <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</th>
                                                        <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</th>
                                                        <th colspan="4" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">วันส่งสินค้า/UNLOADING : <b>' . $result_seVehicletransportplan['DATERETURN'] . '</b></th>
                                                    </tr>
                                                    <tr style="border:1px solid #000;padding:4px;">
                                                        <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">รับสินค้าจาก : <b>' . $result_seVehicletransportplan['JOBSTART'] . '</b> ส่งลูกค้า : <b>' . $result_seVehicletransportplan['JOBEND'] . '</b></th>
                                                        <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">ชนิดเหล็ก : <b>' . $result_seVehicletransportplan['MATERIALTYPE'] . '</b></th>
                                                        <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">บัตรชั่งเลขที่ : </th>
                                                        <th colspan="4" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:left;">เลข JOB : <b>' . $result_seVehicletransportplan['JOBNO'].'
</b></th>
</tr>
<tr style="border:1px solid #000;padding:4px;">
    <th colspan="5" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ข้อมูลปฎิบัติงาน / OPERATION DATA</th>
    <th colspan="3" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">น้ำหนัก / WEIGHT</th>
    <th colspan="4" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ผู้ตรวจสอบ / CHECKER</th>
</tr>
<tr style="border:1px solid #000;padding:4px;">
    <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">สถานที่</th>
    <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เข้า</th>
    <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ออก</th>
    <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เลขไมค์</th>
    <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">เข้า</th>
    <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ออก</th>
    <th bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">สุทธิ</th>
    <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ต้นทาง</th>
    <th colspan="2" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;">ปลายทาง</th>
</tr>
</thead> 
<tbody>
    <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%">&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%">&nbsp;</td>
        <td colspan="2" rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%">&nbsp;</td>
        <td colspan="2" rowspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%">&nbsp;</td>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
    </tr>
</tbody>

<tfoot>
    <tr style="border:1px solid #000;padding:4px;">
        <td bgcolor="#CCCCCC" colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;">สรุปการปฎิบัติงาน</td>
        <td bgcolor="#CCCCCC" colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;">เจ้าหน้าที่ควบคุม</td>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ระยะทาง(กิโลเมตร)</td>
        <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
        <td colspan="6" rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">น้ำมัน(ลิตร)</td>
        <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:left;">ค่าเฉลี่ย(กิโลเมตร/ลิตร)</td>
        <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
    </tr>
</tfoot>
</table>';


$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table);
$mpdf->Output();
sqlsrv_close($conn);
?>

