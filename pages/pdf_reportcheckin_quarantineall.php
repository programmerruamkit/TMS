<?php

ini_set('memory_limit', '140M');
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
ini_set('max_execution_time', 300);
date_default_timezone_set('UTC');
$conn = connect("RTMS");
$condition2 = " AND Company_Code = '" . $_GET['companycode'] . "'";
$sql_seComp = "{call megCompany_v2(?,?)}";
$params_seComp = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condition2, SQLSRV_PARAM_IN)
);
$query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
$result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC);



// //chk department
// if ($_GET['department'] == '01' && $_GET['section'] == '01') {
//     $depsec = 'Administration/Corporate Strategy';
// } elseif ($_GET['department'] == '01' && $_GET['section'] == '02') {
//     $depsec = 'Administration/Administration';
// } elseif ($_GET['department'] == '03' && $_GET['section'] == '01') {
//     $depsec = 'Transportation/Customer Relation Managemet';
// } elseif ($_GET['department'] == '03' && $_GET['section'] == '02') {
//     $depsec = 'Transportation/Maketing and Planning';
// } elseif ($_GET['department'] == '03' && $_GET['section'] == '03') {
//     $depsec = 'Transportation/Safety and Quality';
// } elseif ($_GET['department'] == '04' && $_GET['section'] == '01') {
//     $depsec = 'Affiliate Business/Ruamkit Rungrueng Truck Details';
// } elseif ($_GET['department'] == '04' && $_GET['section'] == '02') {
//     $depsec = 'Affiliate Business/Ruamkit Information Technology';
// } elseif ($_GET['department'] == '04' && $_GET['section'] == '03') {
//     $depsec = 'Affiliate Business/Ruamkit Rungrueng Traning Center';
// } else {
//     $depsec = '';
// }


$mpdf = new mPDF('th', 'A4-L', '0', '');
$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';


$table_beginmorning1 = '<table width="100%" >
<tbody>
    <tr>

      <td colspan="6" style="text-align:center;font-size:24px"><b>รายงานตัว ประจำวันที่ ' . $_GET['datestart'] . '</b></td>
   </tr>
   <br><br><br>
   <tr>
      <td colspan="6" style="text-align:left;font-size:24px"><b>รายงานตัว (ช่วงเวลา 08.00-17.00)</b></td>
      
   </tr>
   
   
</tbody>
</table>';

$table_beginmorning2 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">';
$trmorning = '<thead>
        <tr style="border:1px solid #000;" >
            <td colspan="7" style="border-right:1px solid #000;padding:3px;text-align:left;">
                <b>ข้อมูลการรายงานตัว</b>
            </td>
            
        </tr>
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ลำดับ </b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>รหัสพนักงาน</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ชื่อ-สกุล</b>
            </td>
            <td rowspan="" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ละติจูด</b>
            </td>
            <td rowspan="" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ลองจิจูด
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ที่อยู่ในการเช็คอิน</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วันที่ในการเช็คอิน</b>
            </td>
            

        </tr>

    </thead>
    ';

$i = 1;
$sumpallet = "";
$sumcompen = "";
$sumall = "";
$sumresult = "";


if ($_GET['area'] == 'AMT') {
    $sql_sePlan = "SELECT  LATIUDE AS 'LAT',LONGITUDE AS 'LONG',[ADDRESS] AS 'ADDRESS',CREATEDATE
    ,CONVERT(NVARCHAR(10),CONVERT(DATETIME,CREATEDATE),103)+' '+CONVERT(VARCHAR(5), CREATEDATE, 108) AS 'DATE',EMPLOYEECODE
    FROM [dbo].[NEWYEARCHECKIN]
    WHERE EMPLOYEECODE  IN('011688','020724','021487','060256','070141','070220','070217','080755')
    AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,'".$_GET['datestart']."',103)
    AND CONVERT(VARCHAR(5),CONVERT(DATETIME, CREATEDATE, 0), 108) BETWEEN '08:00:00' AND '17:00:00'
    ORDER BY EMPLOYEECODE,CREATEDATE ASC";
    $query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
}else {
    $sql_sePlan = "SELECT  LATIUDE AS 'LAT',LONGITUDE AS 'LONG',[ADDRESS] AS 'ADDRESS',CREATEDATE
        ,CONVERT(NVARCHAR(10),CONVERT(DATETIME,CREATEDATE),103)+' '+CONVERT(VARCHAR(5), CREATEDATE, 108) AS 'DATE',EMPLOYEECODE
        FROM [dbo].[NEWYEARCHECKIN]
        WHERE EMPLOYEECODE  IN('090298','040479','090056','040896',
        '050107','040634','040763','090280','050099','090199','040789',
        '040721','090015','050039','040559','060179','090341','050115',
        '040745','060248','040836','090252','090004')
        AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,'".$_GET['datestart']."',103)
        AND CONVERT(VARCHAR(5),CONVERT(DATETIME, CREATEDATE, 0), 108) BETWEEN '08:00:00' AND '17:00:00'
        ORDER BY EMPLOYEECODE,CREATEDATE ASC";
    $query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
}


while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {
    $sql_seName = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,
    a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE a.EMPLOYEECODE='".$result_sePlan['EMPLOYEECODE']."'
    ORDER BY a.EMPLOYEECODE ASC";
    $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
    $result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC);


    if ($result_sePlan['LAT'] == '' && $result_sePlan['LONG'] == '' && $result_sePlan['ADDRESS'] == '') {
        $color = "background-color: #FF9966";
    } else {
        $color = "";
    }
    $tdmorning .= '<tbody>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;' . $color . '" >' . $i . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seName['EMPLOYEECODE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seName['nameT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['LAT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['LONG'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['ADDRESS'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['DATE'] . '</td>
                 </tr>
 </tbody>';



    $i++;
}


$table_endmorning = '</table>';


$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_beginmorning1);
$mpdf->WriteHTML($table_beginmorning2);
$mpdf->WriteHTML($trmorning);
$mpdf->WriteHTML($tdmorning);
$mpdf->WriteHTML($table_endmorning);
// $mpdf->AddPage();
// $mpdf->WriteHTML($table_beginafternoon1);
// $mpdf->WriteHTML($table_beginafternoon2);
// $mpdf->WriteHTML($trafternoon);
// $mpdf->WriteHTML($tdafternoon);
// $mpdf->WriteHTML($table_endafternoon);

$mpdf->Output();
sqlsrv_close($conn);
