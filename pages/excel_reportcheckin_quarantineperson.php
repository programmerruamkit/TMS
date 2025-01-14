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


$sql_seName = "SELECT nameT,PersonCode FROM EMPLOYEEEHR2
WHERE PersonCode ='".$_GET['employeecode']."'";
$params_seName = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condition2, SQLSRV_PARAM_IN)
);
$query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
$result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC);

$strExcelFileName = "รายงานข้อมูลกักตัว(บุคคล) ".$result_seName['nameT']." วันที่่".$_GET['datestart'] .".xls";




header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");






?>

<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>

<!-- //08.00-09.00 -->
<table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:center;font-size:24px"><b>รายงานตัว ประจำวันที่ <?= $_GET['datestart'] ?> พนักงาน : <?= $result_seName['nameT']?></b></td>

   </tr>
   <br><br>
   <tr>
   <td colspan="6" style="text-align:left;font-size:24px"><b>รายงานตัวช่วงเวลา (08.00-11.00)</b></td>
   </tr>

</tbody>
</table>

<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
<thead>
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
<?php

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
    ?>
    <tbody>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;<?= $color ?>" ><?= $i ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_sePlan['nameT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['LAT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['LONG'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['ADDRESS'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['DATE'] ?></td>
                 </tr>
 </tbody>

<?php

    $i++;
}
?>

</table>

<!-- //09.01-10.00 -->
<br><table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:left;font-size:24px"><b>รายงานตัวช่วงเวลา (11.01-14.00)</b></td>
   </tr>

</tbody>
</table>

<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
<thead>
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
 <?php

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
    ?>
<tbody>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;<?= $color ?>" ><?=  $i ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?=  $color ?>" ><?=  $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?=  $color ?>" ><?=  $result_sePlan['nameT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?=  $color ?>" ><?=  $result_seCheckIN['LAT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?=  $color ?>" ><?=  $result_seCheckIN['LONG'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?=  $color ?>" ><?=  $result_seCheckIN['ADDRESS'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?=  $color ?>" ><?=  $result_seCheckIN['DATE'] ?></td>
                 </tr>
 </tbody>


<?php
    $i++;
}
?>
</table>

<!-- //10.01-11.00 -->
<br><table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:left;font-size:24px"><b>รายงานตัวช่วงเวลา (14.01-17.00)</b></td>
   </tr>

</tbody>
</table>

<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
<thead>
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
<?php

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
    ?>
<tbody>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;<?= $color ?>" ><?= $i ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_sePlan['nameT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['LAT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['LONG'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['ADDRESS'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['DATE'] ?></td>
                 </tr>
 </tbody>


<?php
    $i++;
}
?>
</table>

<!-- //11.01-12.00 -->
<!-- <br><table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:left;font-size:24px"><b>รายงานตัวช่วงเวลา (11.01-12.00)</b></td>
   </tr>

</tbody>
</table>

<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
<thead>
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
<?php

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
    ?>
 <tbody>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;<?= $color ?>" ><?= $i ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_sePlan['nameT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['LAT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['LONG'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['ADDRESS'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['DATE'] ?></td>
                 </tr>
 </tbody>

<?php

    $i++;
}
?>
</table> -->

<!-- //12.01-13.00 -->
<!-- <br><table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:left;font-size:24px"><b>รายงานตัวช่วงเวลา (12.01-13.00)</b></td>
   </tr>

</tbody>
</table>

<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
<thead>
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
<?php

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
    ?>
  <tbody>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;<?= $color ?>" ><?= $i ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_sePlan['nameT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['LAT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['LONG'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['ADDRESS'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['DATE'] ?></td>
                 </tr>
 </tbody>

<?php

    $i++;
}
?>
</table> -->

<!-- //13.01-14.00 -->
<!-- <br><table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:left;font-size:24px"><b>รายงานตัวช่วงเวลา (13.01-14.00)</b></td>
   </tr>

</tbody>
</table>

<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
<thead>
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
<?php

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
    ?>
 <tbody>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;<?= $color ?>" ><?= $i ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_sePlan['nameT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['LAT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['LONG'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['ADDRESS'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['DATE'] ?></td>
                 </tr>
 </tbody>


<?php
    $i++;
}
?>
</table> -->

<!-- //14.01-15.00 -->
<!-- <br><table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:left;font-size:24px"><b>รายงานตัวช่วงเวลา (14.01-15.00)</b></td>
   </tr>

</tbody>
</table>

<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
<thead>
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
<?php
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
    ?>
<tbody>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;<?= $color ?>" ><?= $i ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_sePlan['nameT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['LAT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['LONG'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['ADDRESS'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['DATE'] ?></td>
                 </tr>
 </tbody>


<?php
    $i++;
}
?>
</table> -->

<!-- //15.01-16.00 -->
<!-- <br><table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:left;font-size:24px"><b>รายงานตัวช่วงเวลา (15.01-16.00)</b></td>
   </tr>

</tbody>
</table>

<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
 <thead>
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
  <?php

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
?>
    <tbody>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;<?= $color ?>" ><?= $i ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_sePlan['nameT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['LAT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['LONG'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['ADDRESS'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['DATE'] ?></td>
                 </tr>
 </tbody>

<?php
    $i++;
}
?>
</table> -->

<!-- //16.01-17.00 -->
<!-- <br><table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:left;font-size:24px"><b>รายงานตัวช่วงเวลา (16.01-17.00)</b></td>
   </tr>

</tbody>
</table>

<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
<thead>
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
<?php

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
?>
    <tbody>
                <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;<?= $color ?>" ><?= $i ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_sePlan['nameT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['LAT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['LONG'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['ADDRESS'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $color ?>" ><?= $result_seCheckIN['DATE'] ?></td>
                 </tr>
 </tbody>


<?php
    $i++;
}
?>
</table> -->
<?php
sqlsrv_close($conn);
?>
