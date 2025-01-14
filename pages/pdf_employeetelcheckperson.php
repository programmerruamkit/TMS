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




$mpdf = new mPDF('', 'A4', '', '', 3, 3, 10, 15, 10, 15);
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
      <td colspan="6" style="text-align:center;font-size:18px"><b>รายงานข้อมูลการใช้งานโทรศัพท์ของพนักงาน (รายบุคคล)</b></td>
   </tr>
   <tr>
      <td colspan="6" style="text-align:center;font-size:16px">ชื่อ-นามสกุล: '.$result_seComp['nameT'].' | รหัสพนักงาน: '.$result_seComp['PersonCode'].' | ตำแหน่ง: '.$result_seComp['PositionNameT'].'</td>
   </tr>
</tbody>
</table>';

$table_beginmorning2 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;">';
$trmorning = '<thead>
        <tr style="border:1px solid #000;" >
            <td colspan="10" style="border-right:1px solid #000;padding:3px;text-align:left;">
                <b>ข้อมูลการใช้งานโทรศัพท์</b>
            </td>
            
        </tr>
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ลำดับ </b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>หมายเลขงาน</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วัน/เดือน/ปี </b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ใช้งานล่าสุด</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>หยุดใช้งาน</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>รวมใช้งาน <br>(ชั่วโมง)</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>เวลานอน <br>(ชั่วโมง)</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>เวลานอนจริง <br>(ชั่วโมง)</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>เกณฑ์ที่ได้</b>
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



$sql_sePlan = "SELECT b.TELCHECKID,b.SELFCHECKID, a.VEHICLETRANSPORTPLANID,a.TENKOMASTERID,a.JOBNO,
    CONVERT(VARCHAR(10),a.DATEWORKING,120) AS 'DATEWORKING',
    CONVERT(VARCHAR(16),b.CURRENTUSING_DATE,120) AS 'CURRENTUSINGDATE',
    CONVERT(VARCHAR(16),b.STOPUSING_DATE,120) AS 'STOPUSINGDATE',
    b.ALLTIMENORMAL,b.ALLTIMEUSING,b.ALLTIMESLEEP,b.RANKDRIVER,b.REMARK,
    REPLACE(ALLTIMEUSING, ':', '.') AS 'ALLTIMEUSINGFORMAT'
    FROM VEHICLETRANSPORTPLAN a 
    INNER JOIN DRIVERTELCHECK b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
    WHERE b.EMPLOYEECODE ='" . $_GET['drivercode'] . "'
    AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestartperson'] . "',103) AND CONVERT(DATE,'" . $_GET['dateendperson'] . "',103)
    ORDER BY a.DATEWORKING ASC";
$query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {
   

    // // echo $result_seCarData1['MONTHDIFF'];
    // // echo '|';
    //ใส่ สีใน TD ของแต่ละ RANK

    if ($result_sePlan['RANKDRIVER'] == 'ER') {
        $tdcolorD1 ="background-color: #349aff";
    }else if ($result_sePlan['RANKDRIVER'] == 'A'){
        $tdcolorD1 ="background-color: #ff3434";
    }else if ($result_sePlan['RANKDRIVER'] == 'B'){
        $tdcolorD1 ="background-color: #ffad33";
    }else if ($result_sePlan['RANKDRIVER'] == 'C'){
        $tdcolorD1 ="background-color: #ffff66";
    }else if ($result_sePlan['RANKDRIVER'] == 'D'){
        $tdcolorD1 ="background-color: #5cd65c";
    }else{
        $tdcolorD1 ="background-color: #ffffff";
    }

    $tdmorning .= '<tbody>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $i . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" >' . $result_sePlan['JOBNO']. '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" >' . $result_sePlan['DATEWORKING']  . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" >' . $result_sePlan['CURRENTUSINGDATE']  . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" >' . $result_sePlan['STOPUSINGDATE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_sePlan['ALLTIMEUSING'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_sePlan['ALLTIMENORMAL'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_sePlan['ALLTIMESLEEP'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;' . $tdcolorD1 . '" >' . $result_sePlan['RANKDRIVER'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;">'.$result_sePlan['REMARK'].'</td>
                 </tr>
    </tbody>';



    $i++;
    $ALLTIMEUSING = $ALLTIMEUSING +  $result_sePlan['ALLTIMEUSINGFORMAT'];

}

    $tdmorning .= '<tfoot>
        <tr style="border:1px solid #000;' . $trcolor . '" >
            <td colspan="5" style="border-right:1px solid #000;padding:3px;text-align:right;background-color: #dedede" >เวลาเฉลี่ย</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" >'.number_format($ALLTIMEUSING/($i-1),2).'</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
        </tr>
    </tfoot>';

$table_endmorning = '</table>';





$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_beginmorning1);
$mpdf->WriteHTML($table_beginmorning2);
$mpdf->WriteHTML($trmorning);
$mpdf->WriteHTML($tdmorning);
$mpdf->WriteHTML($table_endmorning);

$mpdf->Output();
sqlsrv_close($conn);
