<?php

ini_set('memory_limit', '140M');
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
ini_set('max_execution_time', 300);
date_default_timezone_set('UTC');
$conn = connect("RTMS");
$condition2 = " AND PersonCode = '" . $_GET['drivercode'] . "'";
$sql_seComp = "{call megEmployeeEHR_v2(?,?)}";
$params_seComp = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($condition2, SQLSRV_PARAM_IN)
);
$query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
$result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC);




$mpdf = new mPDF('', 'A4-L', '', '', 3, 3, 10, 15, 10, 15);
// $mpdf = new mPDF('th', 'A4-L', '0', '');
$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';


$table_beginmorning1 = '<table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:center;font-size:24px"><b>รายงานข้อมูลใบขับขี่</b></td>
   </tr>
   <tr>
      <td colspan="6" style="text-align:center;font-size:20px"><b>พนักงาน '.$result_seComp['nameT'].' ('.$result_seComp['PositionNameT'].')</b></td>
   </tr>
</tbody>
</table>';

$table_beginmorning2 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">';
$trmorning = '<thead>
        <tr style="border:1px solid #000;" >
            <td colspan="7" style="border-right:1px solid #000;padding:3px;text-align:left;">
                <b>ข้อมูลใบขับขี่ของพนักงาน</b>
            </td>
            
        </tr>
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ลำดับ </b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>เลขที่ใบขับขี่ </b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วันที่ออกบัตร</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วันที่หมดอายุ</b>
            </td>
            <td rowspan="" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วันที่ปัจจุบัน</b>
            </td>
            <td rowspan="" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ระยะเวลา(เดือน)</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>หมายเหตุ</b>
            </td>
            

        </tr>

    </thead>
    ';

$i = 1;
$sumpallet = "";
$sumcompen = "";
$sumall = "";
$sumresult = "";



$sql_sePlan = "SELECT a.PersonID,a.nameT,a.CarLicenceID,
    FORMAT (b.ExpireCar_Start, 'dd/MM/yyyy') 'STARTDATE',
    FORMAT (b.ExpireCar_End, 'dd/MM/yyyy') AS 'ENDDATE' ,
    DATEDIFF(month, FORMAT (b.ExpireCar_End, 'yyyy/MM/dd '), FORMAT (GETDATE(), 'yyyy/MM/dd ')) AS 'MONTHDIFF'
    FROM [dbo].[EMPLOYEEEHR2] a
    INNER JOIN [dbo].[EMPLOYEEDETAILEHR] b ON a.PersonID = b.PersonID
    WHERE PersonCode ='".$_GET['drivercode']."'";
$query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {
   

    // // echo $result_seCarData1['MONTHDIFF'];
    // // echo '|';
    if ($result_sePlan['ENDDATE'] == NULL) {
        if ($result_sePlan['CarLicenceID'] == NULL || $result_sePlan['CarLicenceID'] == '') {
            $licensechk1 = "";
            $remark ="ไม่มีข้อมูลใบขับขี่";
            $monthdif ="";
            $currentday = "";
            $trcolor ="";
        }else{
            $licensechk1 = "";
            $remark ="";
            $monthdif ="";
            $currentday = "";
            $trcolor ="";
        }
    }else{ 
        if ($result_sePlan['MONTHDIFF'] == '-3') {
            // echo '1';
            $licensechk1 = "background-color: #f6ff54";
            $remark = "ใบขับขี่จะหมดอายุภายในอีก 3 เดือน";
            $monthdif = $result_sePlan['MONTHDIFF'] .' '.'เดือน';
            $currentday = date("d/m/Y");
            $trcolor ="";
        }else if($result_sePlan['MONTHDIFF'] == '-2'){
            // echo '2';
            $licensechk1 = "background-color: #ff9e54";
            $remark = "ใบขับขี่จะหมดอายุภายในอีก 2 เดือน";
            $monthdif = $result_sePlan['MONTHDIFF'] .' '.'เดือน';
            $currentday = date("d/m/Y");
            $trcolor ="";
        }else if($result_sePlan['MONTHDIFF'] == '-1'){
            
            // echo '1';
            $licensechk1 = "background-color: #ff5454";
            $remark = "ใบขับขี่จะหมดอายุภายในอีก 1 เดือน";
            $monthdif = $result_sePlan['MONTHDIFF'] .' '.'เดือน';
            $currentday = date("d/m/Y");
            $trcolor ="";
        }else if( $result_sePlan['MONTHDIFF'] >= '0'){
            
            // echo '1';
            $licensechk1 = "background-color: #ff5454";
            $remark = "ใบขับขี่หมดอายุแล้ว";
            $monthdif = $result_sePlan['MONTHDIFF'] .' '.'เดือน';
            $currentday = date("d/m/Y");
            $trcolor ="background-color: #ff5454";
        }else{
            // echo '0';
            // ปกติ สีเขียว
            $licensechk1 = "background-color: #94FA67";
            $remark = "ใบขับขี่ยังไม่ถึงวันหมดอายุ หรือ มากกว่า 3 เดือน";
            $monthdif = $result_sePlan['MONTHDIFF'] .' '.'เดือน';
            $currentday = date("d/m/Y");
            $trcolor ="";
            
        }
    }

    $tdmorning .= '<tbody>
                <tr style="border:1px solid #000;' . $trcolor . '" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $i . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" >' . $result_sePlan['CarLicenceID']. '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" >' . $result_sePlan['STARTDATE']  . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" >' . $result_sePlan['ENDDATE']  . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" >' . $currentday . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $licensechk1 . '" >' . $monthdif . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;">'.$remark  .'</td>
                 </tr>
 </tbody>';



    $i++;
}


$table_endmorning = '</table>';



$table_endafternoon = '</table>';

$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_beginmorning1);
$mpdf->WriteHTML($table_beginmorning2);
$mpdf->WriteHTML($trmorning);
$mpdf->WriteHTML($tdmorning);
$mpdf->WriteHTML($table_endmorning);

$mpdf->Output();
sqlsrv_close($conn);
