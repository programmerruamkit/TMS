<?php
ini_set('memory_limit', '-1');
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
//$mpdf = new mPDF();
$mpdf = new mPDF('th', 'A3-L', '0', '');
$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';
$h2 = '<table border="0" width="100%">
        <tr>
            <td rowspan="2" style="text-align: center;"><img src="../images/logo_25.png" width="50" /></td>
            <td colspan="2">บริษัท ร่วมกิจรุ่งเรือง คาร์แคริเออร์ จำกัด 109/1 ม.9 ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190 โทร. 038-589225 FAX 038-086720</td>  
        </tr>
         <tr>
            <td colspan="2">บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต จำกัด 109/1 ม.9 ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190 โทร. 038-589225 FAX 038-086720</td>
            
        </tr>
       
    </table>';
$table_begin = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">';
$tr = '<tr style="border:1px solid #000;padding:4px;">
    <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>ลำดับ</b></td>
    <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>REGION</b></td>
    <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>CLUSTER</b></td>
    <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>DEALERCODE</b></td>
    <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>NAME</b></td>
    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>SR</b></td>
    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>GW</b></td>
    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>BP</b></td>
    <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>OTH</b></td>
    <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>จำนวนวันเดินทาง</b></td>
    <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>เบี้ยเลี้ยงพนักงานขับรถ</b></td>
    <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>ค่าเบี้ยเลี้ยงผู้ติดตาม</b></td>
    <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>ค่าเที่ยว1</b></td>
    <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>ค่าเที่ยว2</b></td>
    <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>ค่าขึ้นสินค้า</b></td>
    <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>ค่าลงสินค้า</b></td>
    <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>ค่าผ่านทาง</b></td>
    <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>ค่าอื่นๆ</b></td>
    <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>รวม</b></td>
  </tr>
  <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>BASE4L</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>BASE8L</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>BASE4L</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>BASE8L</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>BASE4L</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>BASE8L</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>BASE4L</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>BASE8L</b></td>
    </tr>
';
$i = 1;
$condition1 = "";
$sql_seVehicletransportprice = "{call megVehicletransportprice_v2(?,?)}";
$params_seVehicletransportprice = array(
    array('select_vehicletransportprice', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$td = '';
$query_seVehicletransportprice = sqlsrv_query($conn, $sql_seVehicletransportprice, $params_seVehicletransportprice);
while ($result_seVehicletransportprice = sqlsrv_fetch_array($query_seVehicletransportprice, SQLSRV_FETCH_ASSOC)) {

    $td .= '<tr style="border:1px solid #000;padding:4px;">
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$i.'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['REGION'].'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['CLUSTER'].'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['DEALERCODE'].'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['NAME'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['SRBASE4L'].'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['SRBASE8L'].'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['GWBASE4L'].'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['GWBASE8L'].'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['BPBASE4L'].'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['BPBASE8L'].'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['OTHBASE4L'].'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['OTHBASE8L'].'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['C1'].'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['C2'].'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['C3'].'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['C4'].'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['C5'].'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['C6'].'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['C7'].'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['C8'].'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['C9'].'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" >'.$result_seVehicletransportprice['C10'].'</td>
    </tr>';
    $i++;
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

