<?php
ini_set('memory_limit', '140M');
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
ini_set('max_execution_time', 300);
date_default_timezone_set('UTC');
$conn = connect("RTMS");


$strExcelFileName = "รายงายข้อมูลแรงค์ของพนักงาน.xls";

header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

//chk department
// if ($_GET['department'] == '01' && $_GET['section'] == '01') {
//     $depsec ='Administration/Corporate Strategy';
// }elseif ($_GET['department'] == '01' && $_GET['section'] == '02') {
//     $depsec ='Administration/Administration';
// }elseif ($_GET['department'] == '03' && $_GET['section'] == '01') {
//     $depsec ='Transportation/Customer Relation Managemet';
// }elseif ($_GET['department'] == '03' && $_GET['section'] == '02') {
//     $depsec ='Transportation/Maketing and Planning';
// }elseif ($_GET['department'] == '03' && $_GET['section'] == '03') {
//     $depsec ='Transportation/Safety and Quality';
// }elseif ($_GET['department'] == '04' && $_GET['section'] == '01') {
//     $depsec ='Affiliate Business/Ruamkit Rungrueng Truck Details';
// }elseif ($_GET['department'] == '04' && $_GET['section'] == '02') {
//     $depsec ='Affiliate Business/Ruamkit Information Technology';
// }elseif ($_GET['department'] == '04' && $_GET['section'] == '03') {
//     $depsec ='Affiliate Business/Ruamkit Rungrueng Traning Center';
// }else {
//     $depsec ='';
// }

if ($_GET['yearsendrank'] != '') {
    $year = $_GET['yearstartrank']."-".$_GET['yearsendrank'];
}else {
    $year = $_GET['yearstartrank'];
}


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
      <td colspan="17" style="border-right:1px solid #000;text-align:center;font-size:24px"><b>ผลการประเมินโครงการเกรด A เดือน <?=$_GET['monththai']?> ปี (<?=$year?>)</b></td>
   </tr>
   <!-- <tr>
      <td colspan="6" style="text-align:center;font-size:24px"><b>ประจำวันที่ <?=$_GET['datestart']?></b></td>
   </tr> -->
</tbody>
</table>
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
    <thead>
            <tr style="border:1px solid #000;background-color: #ccc" >
                <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>ลำดับ </b>
                </td>
                <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>รหัสพนักงาน</b>
                </td>
                <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>ชื่อพนักงาน</b>
                </td>
                <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>ตำแหน่ง/สายงาน</b>
                </td>
                <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>ปีในการประเมิน</b>
                </td>
                <td  colspan="5"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>แผนกคุณภาพและความปลอดภัย</b>
                </td>
                <td  colspan="1"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>แผนกการตลาดและวางแผน</b>
                </td>
                <td  colspan="1"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>แผนกซ่อมบำรุง</b>
                </td>
                <td  colspan="3"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>แผนกบุคคล</b>
                </td>
                <td  rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>รวม</b>
                </td>
                <td  rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>เกรด</b>
                </td>
            </tr>
    
            <tr style="border:1px solid #000;background-color: #ccc" >
                
                <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>อุบัติเหตุรถบรรทุก</b>
                </td>
                <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>อุบัติเหตุสินค้าเสียหาย</b>
                </td>
                <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>ตรวจสอบการทำงาน</b>
                </td>
                <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>พฤติกรรมการขับขี่</b>
                </td>
                <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>การปฎิบัติงานพนักงานขับรถ</b>
                </td>
                <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>ข้อร้องเรียนจากลูกค้า</b>
                </td>
                <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>รถบรรทุกพร้อมใช้</b>
                </td>
                <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>ปฏิบัติตามระเบียบบริษัทฯ</b>
                </td>
                <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>การเข้าร่วมประชุม/กิจกรรม</b>
                </td>
                <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>การมาทำงาน</b>
                </td>
            </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;

        // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
        // $condiReporttransport2 = "";
        // $condiReporttransport3 = "";
        if ($_GET['type'] == 'person') {

            $sql_seRankData = "SELECT a.RANKID,a.DRIVERCODE,a.DRIVERNAME,b.PositionNameT,a.MONTHTH,a.YEARRANK,
                a.ACCIDENTTRUCK,a.ACCIDENTPRODUCT,a.WORKCHECKING,a.DRIVERBEHAVIOR,a.OPERATIONDRIVER,
                a.COMPAINFROMCUS,a.TRUCKREADY,
                a.COMPANYREGULATION,a.ATTENDANCE,a.COMINGTOWORK,
                a.ALLPOINT,a.RANKING
                FROM DRIVERRANKING a
                INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a. DRIVERCODE
                WHERE a.DRIVERCODE = '".$_GET['drivercode']."'
                AND a.MONTHENG ='".$_GET['montheng']."'
                AND a.YEARRANK BETWEEN '".$_GET['yearstartrank']."' AND '".$_GET['yearsendrank']."'
                ORDER BY a.YEARRANK,b.PositionNameT,a.DRIVERCODE ASC";
            $params_seRankData = array();
            $query_seRankData = sqlsrv_query($conn, $sql_seRankData, $params_seRankData);
       
        }else if ($_GET['type'] == 'company') {
            if ($_GET['company'] == '00') {
                $sql_seRankData = "SELECT a.DRIVERCODE,a.DRIVERNAME,b.PositionNameT,a.MONTHTH,a.YEARRANK,
                    a.ACCIDENTTRUCK,a.ACCIDENTPRODUCT,a.WORKCHECKING,a.DRIVERBEHAVIOR,a.OPERATIONDRIVER,
                    a.COMPAINFROMCUS,a.TRUCKREADY,
                    a.COMPANYREGULATION,a.ATTENDANCE,a.COMINGTOWORK,
                    a.ALLPOINT,a.RANKING
                    FROM DRIVERRANKING a
                    INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a. DRIVERCODE
                    WHERE a.MONTHENG ='".$_GET['montheng']."'
                    AND a.YEARRANK BETWEEN '".$_GET['yearstartrank']."' AND '".$_GET['yearsendrank']."'
                    ORDER BY a.YEARRANK,b.PositionNameT,a.DRIVERCODE ASC";
                $params_seRankData = array();
                $query_seRankData = sqlsrv_query($conn, $sql_seRankData, $params_seRankData);
            }else {
                $sql_seRankData = "SELECT a.DRIVERCODE,a.DRIVERNAME,b.PositionNameT,a.MONTHTH,a.YEARRANK,
                    a.ACCIDENTTRUCK,a.ACCIDENTPRODUCT,a.WORKCHECKING,a.DRIVERBEHAVIOR,a.OPERATIONDRIVER,
                    a.COMPAINFROMCUS,a.TRUCKREADY,
                    a.COMPANYREGULATION,a.ATTENDANCE,a.COMINGTOWORK,
                    a.ALLPOINT,a.RANKING
                    FROM DRIVERRANKING a
                    INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a. DRIVERCODE
                    WHERE SUBSTRING(a.DRIVERCODE, 1, 2) ='".$_GET['company']."'
                    AND a.MONTHENG ='".$_GET['montheng']."'
                    AND a.YEARRANK BETWEEN '".$_GET['yearstartrank']."' AND '".$_GET['yearsendrank']."'
                    ORDER BY a.YEARRANK,b.PositionNameT,a.DRIVERCODE ASC";
                $params_seRankData = array();
                $query_seRankData = sqlsrv_query($conn, $sql_seRankData, $params_seRankData);
            }
            

        }else if ($_GET['type'] == 'position') {
            if ($_GET['position'] == '000') {
                $sql_seRankData = "SELECT a.DRIVERCODE,a.DRIVERNAME,b.PositionNameT,a.MONTHTH,a.YEARRANK,
                    a.ACCIDENTTRUCK,a.ACCIDENTPRODUCT,a.WORKCHECKING,a.DRIVERBEHAVIOR,a.OPERATIONDRIVER,
                    a.COMPAINFROMCUS,a.TRUCKREADY,
                    a.COMPANYREGULATION,a.ATTENDANCE,a.COMINGTOWORK,
                    a.ALLPOINT,a.RANKING
                    FROM DRIVERRANKING a
                    INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a. DRIVERCODE
                    WHERE a.MONTHENG ='".$_GET['montheng']."'
                    AND a.YEARRANK BETWEEN '".$_GET['yearstartrank']."' AND '".$_GET['yearsendrank']."'
                    ORDER BY a.YEARRANK,b.PositionNameT,a.DRIVERCODE ASC";
                $params_seRankData = array();
                $query_seRankData = sqlsrv_query($conn, $sql_seRankData, $params_seRankData);
            }else{
                $sql_seRankData = "SELECT a.DRIVERCODE,a.DRIVERNAME,b.PositionNameT,a.MONTHTH,a.YEARRANK,
                    a.ACCIDENTTRUCK,a.ACCIDENTPRODUCT,a.WORKCHECKING,a.DRIVERBEHAVIOR,a.OPERATIONDRIVER,
                    a.COMPAINFROMCUS,a.TRUCKREADY,
                    a.COMPANYREGULATION,a.ATTENDANCE,a.COMINGTOWORK,
                    a.ALLPOINT,a.RANKING
                    FROM DRIVERRANKING a
                    INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a. DRIVERCODE
                    WHERE b.PositionNameT ='".$_GET['position']."'
                    AND a.MONTHENG ='".$_GET['montheng']."'
                    AND a.YEARRANK BETWEEN '".$_GET['yearstartrank']."' AND '".$_GET['yearsendrank']."'
                    ORDER BY a.YEARRANK,b.PositionNameT ASC";
                $params_seRankData = array();
                $query_seRankData = sqlsrv_query($conn, $sql_seRankData, $params_seRankData);
            }
            

        }else{

        }
        
        while ($result_seRankData = sqlsrv_fetch_array($query_seRankData, SQLSRV_FETCH_ASSOC)) {

      
    ?>
            <tr style="border:1px solid #000;">
                <td style="text-align: center"><?= $i ?></td>
                <td style="text-align: center"><?= $result_seRankData['DRIVERCODE'] ?></td>
                <td style="text-align: center"><?= $result_seRankData['DRIVERNAME'] ?></td>
                <td style="text-align: center"><?= $result_seRankData['PositionNameT'] ?></td>
                <td style="text-align: center"><?= $result_seRankData['YEARRANK'] ?></td>
                <td style="text-align: center"><?= $result_seRankData['ACCIDENTTRUCK'] ?></td>
                <td style="text-align: center"><?= $result_seRankData['ACCIDENTPRODUCT'] ?></td>
                <td style="text-align: center"><?= $result_seRankData['WORKCHECKING'] ?></td>
                <td style="text-align: center"><?= $result_seRankData['DRIVERBEHAVIOR'] ?></td>
                <td style="text-align: center"><?= $result_seRankData['OPERATIONDRIVER'] ?></td>
                <td style="text-align: center"><?= $result_seRankData['COMPAINFROMCUS'] ?></td>
                <td style="text-align: center"><?= $result_seRankData['TRUCKREADY'] ?></td>
                <td style="text-align: center"><?= $result_seRankData['COMPANYREGULATION'] ?></td>
                <td style="text-align: center"><?= $result_seRankData['ATTENDANCE'] ?></td>
                <td style="text-align: center"><?= $result_seRankData['COMINGTOWORK'] ?></td>
                <td style="text-align: center"><?= $result_seRankData['ALLPOINT'] ?></td>
                <td style="text-align: center"><?= $result_seRankData['RANKING'] ?></td>
                
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
