<?php

ini_set('memory_limit', '140M');
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
ini_set('max_execution_time', 300);
date_default_timezone_set('UTC');
$conn = connect("RTMS");


$sql_seName = "SELECT nameT,PersonCode FROM EMPLOYEEEHR2
WHERE PersonCode ='".$_GET['employeecode']."'";
$params_seName = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condition2, SQLSRV_PARAM_IN)
);
$query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
$result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC);



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

//08.00-11.00
$table_beginmorning1 = '<table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:center;font-size:24px"><b>รายงานตัว ประจำวันที่ ' . $_GET['datestart'] . ' พนักงาน : '.$result_seName['nameT'].'</b></td>
     
   </tr>
   <br><br>
   <tr>
   <td colspan="6" style="text-align:left;font-size:24px"><b>รายงานตัวช่วงเวลา (08.00-11.00)</b></td>
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



$sql_sePlan = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,
        a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT
        FROM [dbo].[ORGANIZATION] a 
        INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
        INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
        INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
        WHERE a.EMPLOYEECODE='".$_GET['employeecode']."'
        ORDER BY a.EMPLOYEECODE ASC";
$query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {
    $sql_seCheckIN = "SELECT TOP 1 LATIUDE AS 'LAT',LONGITUDE AS 'LONG',[ADDRESS] AS 'ADDRESS',CREATEDATE
        ,CONVERT(NVARCHAR(10),CONVERT(DATETIME,CREATEDATE),103)+' '+CONVERT(NVARCHAR(5),CONVERT(TIME,CREATEDATE)) AS 'DATE' 
        FROM [dbo].[NEWYEARCHECKIN]
        WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
        AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,'".$_GET['datestart']."',103)
        AND CONVERT(VARCHAR(5),CONVERT(DATETIME, CREATEDATE, 0), 108) BETWEEN '08:00:00' AND '11:00:00'
        ORDER BY CREATEDATE DESC";
    $query_seCheckIN = sqlsrv_query($conn, $sql_seCheckIN, $params_seCheckIN);
    $result_seCheckIN = sqlsrv_fetch_array($query_seCheckIN, SQLSRV_FETCH_ASSOC);


    if ($result_seCheckIN['LAT'] == '' && $result_seCheckIN['LONG'] == '' && $result_seCheckIN['ADDRESS'] == '') {
        $color = "background-color: #FF9966";
    } else {
        $color = "";
    }
    $tdmorning .= '<tbody>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;' . $color . '" >' . $i . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['EMPLOYEECODE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['nameT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LAT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LONG'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['ADDRESS'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['DATE'] . '</td>
                 </tr>
 </tbody>';



    $i++;
}


$table_endmorning = '</table>';

//11.01-14.00
$table_beginafternoon1 = '<br><table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:left;font-size:24px"><b>รายงานตัวช่วงเวลา (11.01-14.00)</b></td>
   </tr>
 
</tbody>
</table>';

$table_beginafternoon11 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">';
$trafternoon1 = '<thead>
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



$sql_sePlan = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,
        a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT
        FROM [dbo].[ORGANIZATION] a 
        INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
        INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
        INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
        WHERE a.EMPLOYEECODE='".$_GET['employeecode']."'
        ORDER BY a.EMPLOYEECODE ASC";
$query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {
    $sql_seCheckIN = "SELECT TOP 1 LATIUDE AS 'LAT',LONGITUDE AS 'LONG',[ADDRESS] AS 'ADDRESS',CREATEDATE
    ,CONVERT(NVARCHAR(10),CONVERT(DATETIME,CREATEDATE),103)+' '+CONVERT(NVARCHAR(5),CONVERT(TIME,CREATEDATE)) AS 'DATE' 
    FROM [dbo].[NEWYEARCHECKIN]
    WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
    AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,'".$_GET['datestart']."',103)
    AND CONVERT(VARCHAR(5),CONVERT(DATETIME, CREATEDATE, 0), 108) BETWEEN '11:01:00' AND '14:00:00'
    ORDER BY CREATEDATE DESC";
    $query_seCheckIN = sqlsrv_query($conn, $sql_seCheckIN, $params_seCheckIN);
    $result_seCheckIN = sqlsrv_fetch_array($query_seCheckIN, SQLSRV_FETCH_ASSOC);


    if ($result_seCheckIN['LAT'] == '' && $result_seCheckIN['LONG'] == '' && $result_seCheckIN['ADDRESS'] == '') {
        $color = "background-color: #FF9966";
    } else {
        $color = "";
    }
    $tdafternoon1 .= '<tbody>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;' . $color . '" >' . $i . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['EMPLOYEECODE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['nameT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LAT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LONG'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['ADDRESS'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['DATE'] . '</td>
                 </tr>
 </tbody>';



    $i++;
}
$table_endafternoon1 = '</table>';

//14.01-17.00
$table_beginafternoon2 = '<br><table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:left;font-size:24px"><b>รายงานตัวช่วงเวลา (14.01-17.00)</b></td>
   </tr>
 
</tbody>
</table>';

$table_beginafternoon21 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">';
$trafternoon2 = '<thead>
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



$sql_sePlan = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,
        a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT
        FROM [dbo].[ORGANIZATION] a 
        INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
        INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
        INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
        WHERE a.EMPLOYEECODE='".$_GET['employeecode']."'
        ORDER BY a.EMPLOYEECODE ASC";
$query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {
    $sql_seCheckIN = "SELECT TOP 1 LATIUDE AS 'LAT',LONGITUDE AS 'LONG',[ADDRESS] AS 'ADDRESS',CREATEDATE
    ,CONVERT(NVARCHAR(10),CONVERT(DATETIME,CREATEDATE),103)+' '+CONVERT(NVARCHAR(5),CONVERT(TIME,CREATEDATE)) AS 'DATE' 
    FROM [dbo].[NEWYEARCHECKIN]
    WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
    AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,'".$_GET['datestart']."',103)
    AND CONVERT(VARCHAR(5),CONVERT(DATETIME, CREATEDATE, 0), 108) BETWEEN '14:01:00' AND '17:00:00'
    ORDER BY CREATEDATE DESC";
    $query_seCheckIN = sqlsrv_query($conn, $sql_seCheckIN, $params_seCheckIN);
    $result_seCheckIN = sqlsrv_fetch_array($query_seCheckIN, SQLSRV_FETCH_ASSOC);


    if ($result_seCheckIN['LAT'] == '' && $result_seCheckIN['LONG'] == '' && $result_seCheckIN['ADDRESS'] == '') {
        $color = "background-color: #FF9966";
    } else {
        $color = "";
    }
    $tdafternoon2 .= '<tbody>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;' . $color . '" >' . $i . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['EMPLOYEECODE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['nameT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LAT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LONG'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['ADDRESS'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['DATE'] . '</td>
                 </tr>
 </tbody>';



    $i++;
}
$table_endafternoon2 = '</table>';

//11.01-12.00
$table_beginafternoon3 = '<br><table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:left;font-size:24px"><b>รายงานตัวช่วงเวลา (11.01-12.00)</b></td>
   </tr>
 
</tbody>
</table>';

$table_beginafternoon31 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">';
$trafternoon3 = '<thead>
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



$sql_sePlan = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,
        a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT
        FROM [dbo].[ORGANIZATION] a 
        INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
        INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
        INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
        WHERE a.EMPLOYEECODE='".$_GET['employeecode']."'
        ORDER BY a.EMPLOYEECODE ASC";
$query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {
    $sql_seCheckIN = "SELECT TOP 1 LATIUDE AS 'LAT',LONGITUDE AS 'LONG',[ADDRESS] AS 'ADDRESS',CREATEDATE
    ,CONVERT(NVARCHAR(10),CONVERT(DATETIME,CREATEDATE),103)+' '+CONVERT(NVARCHAR(5),CONVERT(TIME,CREATEDATE)) AS 'DATE' 
    FROM [dbo].[NEWYEARCHECKIN]
    WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
    AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,'".$_GET['datestart']."',103)
    AND CONVERT(VARCHAR(5),CONVERT(DATETIME, CREATEDATE, 0), 108) BETWEEN '11:01:00' AND '12:00:00'
    ORDER BY CREATEDATE DESC";
    $query_seCheckIN = sqlsrv_query($conn, $sql_seCheckIN, $params_seCheckIN);
    $result_seCheckIN = sqlsrv_fetch_array($query_seCheckIN, SQLSRV_FETCH_ASSOC);


    if ($result_seCheckIN['LAT'] == '' && $result_seCheckIN['LONG'] == '' && $result_seCheckIN['ADDRESS'] == '') {
        $color = "background-color: #FF9966";
    } else {
        $color = "";
    }
    $tdafternoon3 .= '<tbody>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;' . $color . '" >' . $i . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['EMPLOYEECODE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['nameT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LAT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LONG'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['ADDRESS'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['DATE'] . '</td>
                 </tr>
 </tbody>';



    $i++;
}
$table_endafternoon3 = '</table>';

//12.01-13.00
$table_beginafternoon4 = '<br><table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:left;font-size:24px"><b>รายงานตัวช่วงเวลา (12.01-13.00)</b></td>
   </tr>
 
</tbody>
</table>';

$table_beginafternoon41 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">';
$trafternoon4 = '<thead>
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



$sql_sePlan = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,
        a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT
        FROM [dbo].[ORGANIZATION] a 
        INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
        INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
        INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
        WHERE a.EMPLOYEECODE='".$_GET['employeecode']."'
        ORDER BY a.EMPLOYEECODE ASC";
$query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {
    $sql_seCheckIN = "SELECT TOP 1 LATIUDE AS 'LAT',LONGITUDE AS 'LONG',[ADDRESS] AS 'ADDRESS',CREATEDATE
    ,CONVERT(NVARCHAR(10),CONVERT(DATETIME,CREATEDATE),103)+' '+CONVERT(NVARCHAR(5),CONVERT(TIME,CREATEDATE)) AS 'DATE' 
    FROM [dbo].[NEWYEARCHECKIN]
    WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
    AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,'".$_GET['datestart']."',103)
    AND CONVERT(VARCHAR(5),CONVERT(DATETIME, CREATEDATE, 0), 108) BETWEEN '12:01:00' AND '13:00:00'
    ORDER BY CREATEDATE DESC";
    $query_seCheckIN = sqlsrv_query($conn, $sql_seCheckIN, $params_seCheckIN);
    $result_seCheckIN = sqlsrv_fetch_array($query_seCheckIN, SQLSRV_FETCH_ASSOC);


    if ($result_seCheckIN['LAT'] == '' && $result_seCheckIN['LONG'] == '' && $result_seCheckIN['ADDRESS'] == '') {
        $color = "background-color: #FF9966";
    } else {
        $color = "";
    }
    $tdafternoon4 .= '<tbody>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;' . $color . '" >' . $i . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['EMPLOYEECODE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['nameT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LAT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LONG'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['ADDRESS'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['DATE'] . '</td>
                 </tr>
 </tbody>';



    $i++;
}
$table_endafternoon4 = '</table>';

//13.01-14.00
$table_beginafternoon5 = '<br><table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:left;font-size:24px"><b>รายงานตัวช่วงเวลา (13.01-14.00)</b></td>
   </tr>
 
</tbody>
</table>';

$table_beginafternoon51 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">';
$trafternoon5 = '<thead>
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



$sql_sePlan = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,
        a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT
        FROM [dbo].[ORGANIZATION] a 
        INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
        INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
        INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
        WHERE a.EMPLOYEECODE='".$_GET['employeecode']."'
        ORDER BY a.EMPLOYEECODE ASC";
$query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {
    $sql_seCheckIN = "SELECT TOP 1 LATIUDE AS 'LAT',LONGITUDE AS 'LONG',[ADDRESS] AS 'ADDRESS',CREATEDATE
    ,CONVERT(NVARCHAR(10),CONVERT(DATETIME,CREATEDATE),103)+' '+CONVERT(NVARCHAR(5),CONVERT(TIME,CREATEDATE)) AS 'DATE' 
    FROM [dbo].[NEWYEARCHECKIN]
    WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
    AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,'".$_GET['datestart']."',103)
    AND CONVERT(VARCHAR(5),CONVERT(DATETIME, CREATEDATE, 0), 108) BETWEEN '13:01:00' AND '14:00:00'
    ORDER BY CREATEDATE DESC";
    $query_seCheckIN = sqlsrv_query($conn, $sql_seCheckIN, $params_seCheckIN);
    $result_seCheckIN = sqlsrv_fetch_array($query_seCheckIN, SQLSRV_FETCH_ASSOC);


    if ($result_seCheckIN['LAT'] == '' && $result_seCheckIN['LONG'] == '' && $result_seCheckIN['ADDRESS'] == '') {
        $color = "background-color: #FF9966";
    } else {
        $color = "";
    }
    $tdafternoon5 .= '<tbody>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;' . $color . '" >' . $i . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['EMPLOYEECODE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['nameT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LAT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LONG'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['ADDRESS'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['DATE'] . '</td>
                 </tr>
 </tbody>';



    $i++;
}
$table_endafternoon5 = '</table>';

//14.01-15.00
$table_beginafternoon6 = '<br><table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:left;font-size:24px"><b>รายงานตัวช่วงเวลา (14.01-15.00)</b></td>
   </tr>
 
</tbody>
</table>';

$table_beginafternoon61 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">';
$trafternoon6 = '<thead>
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



$sql_sePlan = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,
        a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT
        FROM [dbo].[ORGANIZATION] a 
        INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
        INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
        INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
        WHERE a.EMPLOYEECODE='".$_GET['employeecode']."'
        ORDER BY a.EMPLOYEECODE ASC";
$query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {
    $sql_seCheckIN = "SELECT TOP 1 LATIUDE AS 'LAT',LONGITUDE AS 'LONG',[ADDRESS] AS 'ADDRESS',CREATEDATE
    ,CONVERT(NVARCHAR(10),CONVERT(DATETIME,CREATEDATE),103)+' '+CONVERT(NVARCHAR(5),CONVERT(TIME,CREATEDATE)) AS 'DATE' 
    FROM [dbo].[NEWYEARCHECKIN]
    WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
    AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,'".$_GET['datestart']."',103)
    AND CONVERT(VARCHAR(5),CONVERT(DATETIME, CREATEDATE, 0), 108) BETWEEN '14:01:00' AND '15:00:00'
    ORDER BY CREATEDATE DESC";
    $query_seCheckIN = sqlsrv_query($conn, $sql_seCheckIN, $params_seCheckIN);
    $result_seCheckIN = sqlsrv_fetch_array($query_seCheckIN, SQLSRV_FETCH_ASSOC);


    if ($result_seCheckIN['LAT'] == '' && $result_seCheckIN['LONG'] == '' && $result_seCheckIN['ADDRESS'] == '') {
        $color = "background-color: #FF9966";
    } else {
        $color = "";
    }
    $tdafternoon6 .= '<tbody>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;' . $color . '" >' . $i . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['EMPLOYEECODE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['nameT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LAT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LONG'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['ADDRESS'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['DATE'] . '</td>
                 </tr>
 </tbody>';



    $i++;
}
$table_endafternoon6 = '</table>';

//15.01-16.00
$table_beginafternoon7 = '<br><table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:left;font-size:24px"><b>รายงานตัวช่วงเวลา (15.01-16.00)</b></td>
   </tr>
 
</tbody>
</table>';

$table_beginafternoon71 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">';
$trafternoon7 = '<thead>
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



$sql_sePlan = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,
        a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT
        FROM [dbo].[ORGANIZATION] a 
        INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
        INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
        INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
        WHERE a.EMPLOYEECODE='".$_GET['employeecode']."'
        ORDER BY a.EMPLOYEECODE ASC";
$query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {
    $sql_seCheckIN = "SELECT TOP 1 LATIUDE AS 'LAT',LONGITUDE AS 'LONG',[ADDRESS] AS 'ADDRESS',CREATEDATE
    ,CONVERT(NVARCHAR(10),CONVERT(DATETIME,CREATEDATE),103)+' '+CONVERT(NVARCHAR(5),CONVERT(TIME,CREATEDATE)) AS 'DATE' 
    FROM [dbo].[NEWYEARCHECKIN]
    WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
    AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,'".$_GET['datestart']."',103)
    AND CONVERT(VARCHAR(5),CONVERT(DATETIME, CREATEDATE, 0), 108) BETWEEN '15:01:00' AND '16:00:00'
    ORDER BY CREATEDATE DESC";
    $query_seCheckIN = sqlsrv_query($conn, $sql_seCheckIN, $params_seCheckIN);
    $result_seCheckIN = sqlsrv_fetch_array($query_seCheckIN, SQLSRV_FETCH_ASSOC);


    if ($result_seCheckIN['LAT'] == '' && $result_seCheckIN['LONG'] == '' && $result_seCheckIN['ADDRESS'] == '') {
        $color = "background-color: #FF9966";
    } else {
        $color = "";
    }
    $tdafternoon7 .= '<tbody>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;' . $color . '" >' . $i . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['EMPLOYEECODE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['nameT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LAT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LONG'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['ADDRESS'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['DATE'] . '</td>
                 </tr>
 </tbody>';



    $i++;
}
$table_endafternoon7 = '</table>';

//16.01-17.00
$table_beginafternoon8 = '<br><table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:left;font-size:24px"><b>รายงานตัวช่วงเวลา (16.01-17.00)</b></td>
   </tr>
 
</tbody>
</table>';

$table_beginafternoon81 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">';
$trafternoon8 = '<thead>
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



$sql_sePlan = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,
        a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT
        FROM [dbo].[ORGANIZATION] a 
        INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
        INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
        INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
        WHERE a.EMPLOYEECODE='".$_GET['employeecode']."'
        ORDER BY a.EMPLOYEECODE ASC";
$query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {
    $sql_seCheckIN = "SELECT TOP 1 LATIUDE AS 'LAT',LONGITUDE AS 'LONG',[ADDRESS] AS 'ADDRESS',CREATEDATE
    ,CONVERT(NVARCHAR(10),CONVERT(DATETIME,CREATEDATE),103)+' '+CONVERT(NVARCHAR(5),CONVERT(TIME,CREATEDATE)) AS 'DATE' 
    FROM [dbo].[NEWYEARCHECKIN]
    WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
    AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,'".$_GET['datestart']."',103)
    AND CONVERT(VARCHAR(5),CONVERT(DATETIME, CREATEDATE, 0), 108) BETWEEN '16:01:00' AND '17:00:00'
    ORDER BY CREATEDATE DESC";
    $query_seCheckIN = sqlsrv_query($conn, $sql_seCheckIN, $params_seCheckIN);
    $result_seCheckIN = sqlsrv_fetch_array($query_seCheckIN, SQLSRV_FETCH_ASSOC);


    if ($result_seCheckIN['LAT'] == '' && $result_seCheckIN['LONG'] == '' && $result_seCheckIN['ADDRESS'] == '') {
        $color = "background-color: #FF9966";
    } else {
        $color = "";
    }
    $tdafternoon8 .= '<tbody>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;' . $color . '" >' . $i . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['EMPLOYEECODE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['nameT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LAT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LONG'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['ADDRESS'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['DATE'] . '</td>
                 </tr>
 </tbody>';



    $i++;
}
$table_endafternoon8 = '</table>';

//08.00-09.00
$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_beginmorning1);
$mpdf->WriteHTML($table_beginmorning2);
$mpdf->WriteHTML($trmorning);
$mpdf->WriteHTML($tdmorning);
$mpdf->WriteHTML($table_endmorning);
// $mpdf->AddPage();

//09.01-10.00
$mpdf->WriteHTML($table_beginafternoon1);
$mpdf->WriteHTML($table_beginafternoon11);
$mpdf->WriteHTML($trafternoon1);
$mpdf->WriteHTML($tdafternoon1);
$mpdf->WriteHTML($table_endafternoon1);

//10.01-11.00
$mpdf->WriteHTML($table_beginafternoon2);
$mpdf->WriteHTML($table_beginafternoon21);
$mpdf->WriteHTML($trafternoon2);
$mpdf->WriteHTML($tdafternoon2);
$mpdf->WriteHTML($table_endafternoon2);

// //11.01-12.00
// $mpdf->WriteHTML($table_beginafternoon3);
// $mpdf->WriteHTML($table_beginafternoon31);
// $mpdf->WriteHTML($trafternoon3);
// $mpdf->WriteHTML($tdafternoon3);
// $mpdf->WriteHTML($table_endafternoon3);
// $mpdf->AddPage();

// //12.01-13.00
// $mpdf->WriteHTML($table_beginafternoon4);
// $mpdf->WriteHTML($table_beginafternoon41);
// $mpdf->WriteHTML($trafternoon4);
// $mpdf->WriteHTML($tdafternoon4);
// $mpdf->WriteHTML($table_endafternoon4);

// //13.01-14.00
// $mpdf->WriteHTML($table_beginafternoon5);
// $mpdf->WriteHTML($table_beginafternoon51);
// $mpdf->WriteHTML($trafternoon5);
// $mpdf->WriteHTML($tdafternoon5);
// $mpdf->WriteHTML($table_endafternoon5);

// //14.01-15.00
// $mpdf->WriteHTML($table_beginafternoon6);
// $mpdf->WriteHTML($table_beginafternoon61);
// $mpdf->WriteHTML($trafternoon6);
// $mpdf->WriteHTML($tdafternoon6);
// $mpdf->WriteHTML($table_endafternoon6);

// //15.01-16.00
// $mpdf->WriteHTML($table_beginafternoon7);
// $mpdf->WriteHTML($table_beginafternoon71);
// $mpdf->WriteHTML($trafternoon7);
// $mpdf->WriteHTML($tdafternoon7);
// $mpdf->WriteHTML($table_endafternoon7);

// //16.01-17.00
// $mpdf->WriteHTML($table_beginafternoon8);
// $mpdf->WriteHTML($table_beginafternoon81);
// $mpdf->WriteHTML($trafternoon8);
// $mpdf->WriteHTML($tdafternoon8);
// $mpdf->WriteHTML($table_endafternoon8);

// $mpdf->WriteHTML($table_beginafternoon9);
// $mpdf->WriteHTML($table_beginafternoon91);
// $mpdf->WriteHTML($trafternoon9);
// $mpdf->WriteHTML($tdafternoon9);
// $mpdf->WriteHTML($table_endafternoon9);
$mpdf->Output();
sqlsrv_close($conn);
