<?php
ini_set('memory_limit', '140M');
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
$conn = connect("RTMS");
$condition2 = " AND Company_Code = '" . $_GET['companycode'] . "'";
$sql_seComp = "{call megCompany_v2(?,?)}";
$params_seComp = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condition2, SQLSRV_PARAM_IN)
);
$query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
$result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC);

$strExcelFileName = "รายงานการรายงานตัวช่วงสงกรานต์".$_GET['datestart'] .".xls";

header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");





?>
<style>
    body{
        font-family: "Garuda";
    }
</style>
<table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:center;font-size:24px"><b>รายงานข้อมูลการรายงานสงกรานต์ 2564</b></td>
   </tr>
   <tr>
      <td colspan="6" style="text-align:center;font-size:24px"><b>ประจำวันที่ <?=$_GET['datestart']?></b></td>
   </tr>
</tbody>
</table>

<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
    <thead>
        <tr style="border:1px solid #000;" >
            <td colspan="8" style="border-right:1px solid #000;padding:3px;text-align:left;">
                <b>แผนก Transportation/Safety & Quality</b>
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
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>สายงาน</b>
            </td>

        </tr>

    </thead><tbody>
<?php
$i = 1;
$sumpallet = "";
$sumcompen = "";
$sumall = "";
$sumresult = "";

if ($_GET['area'] == 'amata') {
    $sql_sePlan = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,
        a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT,d.PositionNameT
        FROM [dbo].[ORGANIZATION] a 
        INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
        INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
        INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
        WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE ='03'
        AND a.AREA ='amata'
        AND d.EndDate IS NULL
        ORDER BY d.PositionNameT,a.EMPLOYEECODE ASC";
}else{
    $sql_sePlan = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,
        a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT,d.PositionNameT
        FROM [dbo].[ORGANIZATION] a 
        INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
        INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
        INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
        WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE ='03'
        AND a.AREA ='gateway'
        AND d.EndDate IS NULL
        ORDER BY d.PositionNameT,a.EMPLOYEECODE ASC";
}

$query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {


    $sql_seCheckIN = "SELECT TOP 1 LATIUDE AS 'LAT',LONGITUDE AS 'LONG',[ADDRESS] AS 'ADDRESS',CREATEDATE
                    ,CONVERT(NVARCHAR(10),CONVERT(DATETIME,CREATEDATE),103)+' '+CONVERT(NVARCHAR(5),CONVERT(TIME,CREATEDATE)) AS 'DATE' 
                    FROM [dbo].[NEWYEARCHECKIN]
                    WHERE EMPLOYEECODE ='".$result_sePlan['EMPLOYEECODE']."'
                    AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,'".$_GET['datestart']."',103)
                    ORDER BY CREATEDATE DESC";
    $query_seCheckIN = sqlsrv_query($conn, $sql_seCheckIN, $params_seCheckIN);
    $result_seCheckIN = sqlsrv_fetch_array($query_seCheckIN, SQLSRV_FETCH_ASSOC);




    
    ?>
            <tr style="border:1px solid #000;" >
                
                <?php
                if ($result_seCheckIN['LAT'] == '' && $result_seCheckIN['LONG'] == '' && $result_seCheckIN['ADDRESS'] == '') {
                   ?>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966" ><?= $i ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;background-color: #FF9966" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;background-color: #FF9966" ><?= $result_sePlan['nameT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;background-color: #FF9966" ><?= $result_seCheckIN['LAT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;background-color: #FF9966" ><?= $result_seCheckIN['LONG'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;background-color: #FF9966" ><?= $result_seCheckIN['ADDRESS'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;background-color: #FF9966" ><?= $result_seCheckIN['DATE'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;background-color: #FF9966" ><?= $result_sePlan['PositionNameT'] ?></td>
                   <?php
                }else{
                    ?>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $i ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_seCheckIN['LAT'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_seCheckIN['LONG'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_seCheckIN['ADDRESS'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_seCheckIN['DATE'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['PositionNameT'] ?></td>
                    <?php
                }
                ?>
                
            </tr>


    <?php
    
    $i++;
    
}
?>
    </tbody>


<?php
sqlsrv_close($conn);
?>
