<?php
ini_set('memory_limit', '140M');
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
ini_set('max_execution_time', 300);
date_default_timezone_set('UTC');

$conn = connect("RTMS");
// $condition2 = " AND PersonCode = '" . $_GET['drivercode'] . "'";
// $sql_seComp = "{call megEmployeeEHR_v2(?,?)}";
// $params_seComp = array(
//     array('select_employeeehr2', SQLSRV_PARAM_IN),
//     array($condition2, SQLSRV_PARAM_IN)
// );
// $query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
// $result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC);

$sql_seComp = "SELECT DISTINCT PositionNameT  AS 'PositionName',PositionID AS 'PositionID' FROM EMPLOYEEEHR2
WHERE 1=1 AND PositionID ='" . $_GET['position'] . "'
ORDER BY PositionNameT ASC";
$params_seComp = array();
$query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
$result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC);

//chk podition
if ($_GET['position'] == '000') {
    $position = 'ตำแหน่งพนักงานทั้งหมด';
}else{
    $position = $result_seComp['PositionName'];
}


$strExcelFileName = " รายงานข้อมูลใบขับขี่ (".$position .").xls";

header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");






?>
<style>
    body{
        font-family: "Garuda";
    }
</style>
<!-- ช่วงเช้า -->
<table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:center;font-size:24px"><b>รายงานข้อมูลใบขับขี่</b></td>
   </tr>
   <tr>
      <td colspan="6" style="text-align:center;font-size:20px"><b> <?=$depsec?></b></td>
   </tr>
</tbody>
</table>
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
    <thead>
        <tr style="border:1px solid #000;" >
            <td colspan="7" style="border-right:1px solid #000;padding:3px;text-align:left;">
                <b> <?=$depsec?></b>
            </td>
            
        </tr>
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>รหัสพนักงาน</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ชื่อพนักงาน</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ชื่อพนักงาน</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ตำแหน่ง</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>เลขที่ใบขับขี่</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วันที่ออกบัตร</b>
            </td>
            <td rowspan="" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วันที่หมดอายุ</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วันที่ปัจจุบัน</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ระยะเวลา(เดือน)</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>หมายเหตุ</b>
            </td>

        </tr>

    </thead><tbody>
        <?php
        $i = 1;
        $sumpallet = "";
        $sumcompen = "";
        $sumall = "";
        $sumresult = "";


        if ($_GET['position'] == '000') {
            $sql_sePlan = "SELECT a.PersonID,a.PersonCode,a.nameT,a.PositionID,a.PositionNameT,a.CarLicenceID,
                FORMAT (b.ExpireCar_Start, 'dd/MM/yyyy') 'STARTDATE',
                FORMAT (b.ExpireCar_End, 'dd/MM/yyyy') AS 'ENDDATE' ,
                DATEDIFF(month, FORMAT (b.ExpireCar_End, 'yyyy/MM/dd '), FORMAT (GETDATE(), 'yyyy/MM/dd ')) AS 'MONTHDIFF'
                FROM [dbo].[EMPLOYEEEHR2] a
                INNER JOIN [dbo].[EMPLOYEEDETAILEHR] b ON a.PersonID = b.PersonID
                ORDER BY a.PositionNameT,a.PersonCode ASC";
        }else {
            $sql_sePlan = "SELECT a.PersonID,a.PersonCode,a.nameT,a.PositionID,a.PositionNameT,a.CarLicenceID,
                FORMAT (b.ExpireCar_Start, 'dd/MM/yyyy') 'STARTDATE',
                FORMAT (b.ExpireCar_End, 'dd/MM/yyyy') AS 'ENDDATE' ,
                DATEDIFF(month, FORMAT (b.ExpireCar_End, 'yyyy/MM/dd '), FORMAT (GETDATE(), 'yyyy/MM/dd ')) AS 'MONTHDIFF'
                FROM [dbo].[EMPLOYEEEHR2] a
                INNER JOIN [dbo].[EMPLOYEEDETAILEHR] b ON a.PersonID = b.PersonID
                WHERE  a.PositionID ='".$_GET['position']."'
                ORDER BY a.PositionNameT,a.PersonCode ASC";
        }
        $query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
        while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {

    
        // echo $result_seCarData1['MONTHDIFF'];
        // echo '|';
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

        
    // $sql_seCheckIN = "SELECT TOP 1 LATIUDE AS 'LAT',LONGITUDE AS 'LONG',CREATEDATE
    //                 FROM [dbo].[NEWYEARCHECKIN]
    //                 WHERE EMPLOYEECODE ='".$result_sePlan['EMPLOYEECODE']."'
    //                 AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,'".$_GET['datestart']."',103)
    //                 ORDER BY CREATEDATE DESC";
    // $query_seCheckIN = sqlsrv_query($conn, $sql_seCheckIN, $params_seCheckIN);
    // $result_seCheckIN = sqlsrv_fetch_array($query_seCheckIN, SQLSRV_FETCH_ASSOC);
   
      
    ?>
            <tr style="border:1px solid #000;<?= $trcolor?>" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $i ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['PersonCode']?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT']?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_sePlan['PositionNameT']?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_sePlan['CarLicenceID'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['STARTDATE'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['ENDDATE'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $currentday ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;<?= $licensechk1?>" ><?= $monthdif ?> </td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?=$remark ?></td>
                  
            </tr>

        <?php
        $i++;
        
        }
    ?>

    </tbody>
</table>

<!-- ช่วงบ่าย -->

<!-- <table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:center;font-size:24px"><b>รายงานตัววันหยุดนักขัตฤกษ์ (ช่วงบ่าย 13.00-17.00)</b></td>
   </tr>
   <tr>
      <td colspan="6" style="text-align:center;font-size:24px"><b>ประจำวันที่ <?=$_GET['datestart']?></b></td>
   </tr>
</tbody>
</table>

<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
    <thead>
        <tr style="border:1px solid #000;" >
            <td colspan="7" style="border-right:1px solid #000;padding:3px;text-align:left;">
                <b>แผนก <?=$depsec?></b>
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

    </thead><tbody>
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
                WHERE b.DEPARTMENTCODE ='" . $_GET['department'] ."' AND c.SECTIONCODE ='" . $_GET['section'] ."'
                AND a.AREA ='".$_GET['area']."'
                AND d.EndDate IS NULL
                ORDER BY a.EMPLOYEECODE ASC";
        $query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
        while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {

    
 
    // $sql_seCheckIN = "SELECT TOP 1 LATIUDE AS 'LAT',LONGITUDE AS 'LONG',CREATEDATE
    //                 FROM [dbo].[NEWYEARCHECKIN]
    //                 WHERE EMPLOYEECODE ='".$result_sePlan['EMPLOYEECODE']."'
    //                 AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,'".$_GET['datestart']."',103)
    //                 ORDER BY CREATEDATE DESC";
    // $query_seCheckIN = sqlsrv_query($conn, $sql_seCheckIN, $params_seCheckIN);
    // $result_seCheckIN = sqlsrv_fetch_array($query_seCheckIN, SQLSRV_FETCH_ASSOC);
    $sql_seCheckIN = "SELECT  TOP 1 LATIUDE AS 'LAT',LONGITUDE AS 'LONG',[ADDRESS] AS 'ADDRESS',CREATEDATE
                    ,CONVERT(NVARCHAR(10),CONVERT(DATETIME,CREATEDATE),103)+' '+CONVERT(NVARCHAR(5),CONVERT(TIME,CREATEDATE)) AS 'DATE' 
                    FROM [dbo].[NEWYEARCHECKIN]
                    WHERE EMPLOYEECODE ='".$result_sePlan['EMPLOYEECODE']."'
                    AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,'".$_GET['datestart']."',103)
                    AND CONVERT(VARCHAR(5),CONVERT(DATETIME, CREATEDATE, 0), 108) BETWEEN '13:00:00' AND '18:00:00'
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
                    <?php
                }
                ?>
                
                
            </tr>


        <?php
        $i++;
        
        }
    ?>
    </tbody>
</table> -->
<?php
sqlsrv_close($conn);
?>
