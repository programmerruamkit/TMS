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

//chk department
if ($_GET['companycode'] == '01' ) {
    $depsec ='บริษัท ร่วมกิจรุ่งเรือง (1993)';
}elseif ($_GET['companycode'] == '02' ) {
    $depsec ='บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส';
}elseif ($_GET['companycode'] == '04' ) {
    $depsec ='บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์';
}elseif ($_GET['companycode'] == '05' ) {
    $depsec ='บริษัท ร่วมกิจ รีไซเคิล แคริเออร์';
}elseif ($_GET['companycode'] == '06' ) {
    $depsec ='บริษัท ร่วมกิจรุ่งเรือง ทรัค ดีเทลส์';
}elseif ($_GET['companycode'] == '07' ) {
    $depsec ='บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์';
}elseif ($_GET['companycode'] == '08' ) {
    $depsec ='บริษัท ร่วมกิจรุ่งเรือง เทรนนิ่ง เซ็นเตอร์';
}elseif ($_GET['companycode'] == '09' ) {
    $depsec ='บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต';
}elseif ($_GET['companycode'] == '10' ) {
    $depsec ='บริษัท ร่วมกิจ ไอที';
}else {
    $depsec ='ทั้งหมด';
}


$strExcelFileName = " รายงานข้อมูลการใช้งานโทรศัพท์รายบริษัท (".$depsec.").xls";

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
      <td colspan="13" style="text-align:center;font-size:24px"><b>รายงานข้อมูลการใช้งานโทรศัพท์ของพนักงาน (รายบริษัท)</b></td>
   </tr>
   <tr>
      <td colspan="13" style="text-align:center;font-size:20px"><b> <?=$depsec?></b></td>
   </tr>
</tbody>
</table>
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
    <thead>
        <tr style="border:1px solid #000;" >
            <td colspan="13" style="border-right:1px solid #000;padding:3px;text-align:left;">
                <b> <?=$depsec?></b>
            </td>
            
        </tr>
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ลำดับ</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>รหัสพนักงาน</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ชื่อ-นามสกุล</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ตำแหน่ง</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>หมายเลขงาน</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วัน/เดือน/ปี</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ใช้งานล่าสุด</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>หยุดใช้งาน</b>
            </td>
            <td rowspan="" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>รวมใช้งาน  <br>(ชั่วโมง)</b>
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

    </thead><tbody>
        <?php
        $i = 1;
        $sumpallet = "";
        $sumcompen = "";
        $sumall = "";
        $sumresult = "";


        if ($_GET['companycode'] == '11') {
            $sql_sePlan = "SELECT nameT,PositionNameT,PersonCode 
            FROM EMPLOYEEEHR2 
            ORDER BY PersonCode ASC";
        }else {
            $sql_sePlan = "SELECT nameT,PositionNameT,PersonCode 
            FROM EMPLOYEEEHR2 
            WHERE  SUBSTRING(PersonCode, 1, 2) ='".$_GET['companycode']."'
            ORDER BY PersonCode ASC";
        }
        $query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
        while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {

            

        
            $sql_seCheckIN = "SELECT b.TELCHECKID,b.SELFCHECKID, a.VEHICLETRANSPORTPLANID,a.TENKOMASTERID,b.EMPLOYEECODE,a.JOBNO,
                CONVERT(VARCHAR(10),a.DATEWORKING,120) AS 'DATEWORKING',
                CONVERT(VARCHAR(16),b.CURRENTUSING_DATE,120) AS 'CURRENTUSINGDATE',
                CONVERT(VARCHAR(16),b.STOPUSING_DATE,120) AS 'STOPUSINGDATE',
                b.ALLTIMENORMAL,b.ALLTIMEUSING,b.ALLTIMESLEEP,b.RANKDRIVER,b.REMARK,
                REPLACE(ALLTIMEUSING, ':', '.') AS 'ALLTIMEUSINGFORMAT'
                FROM VEHICLETRANSPORTPLAN a 
                INNER JOIN DRIVERTELCHECK b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                WHERE b.EMPLOYEECODE ='".$result_sePlan['PersonCode']."'
                AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestartcompany']."',103) AND CONVERT(DATE,'".$_GET['dateendcompany']."',103)
                ORDER BY a.DATEWORKING,b.EMPLOYEECODE ASC";
            $query_seCheckIN = sqlsrv_query($conn, $sql_seCheckIN, $params_seCheckIN);
            $result_seCheckIN = sqlsrv_fetch_array($query_seCheckIN, SQLSRV_FETCH_ASSOC);
    
            //ใส่ สีใน TD ของแต่ละ RANK
            if ($result_seCheckIN['RANKDRIVER'] == 'ER') {
                $tdcolorD1 ="background-color: #349aff";
            }else if ($result_seCheckIN['RANKDRIVER'] == 'A'){
                $tdcolorD1 ="background-color: #ff3434";
            }else if ($result_seCheckIN['RANKDRIVER'] == 'B'){
                $tdcolorD1 ="background-color: #ffad33";
            }else if ($result_seCheckIN['RANKDRIVER'] == 'C'){
                $tdcolorD1 ="background-color: #ffff66";
            }else if ($result_seCheckIN['RANKDRIVER'] == 'D'){
                $tdcolorD1 ="background-color: #5cd65c";
            }else{
                $tdcolorD1 ="background-color: #ffffff";
            }
          
           
            ?>
                    <tr style="border:1px solid #000;" >
                        <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $i ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['PersonCode'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['PositionNameT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_seCheckIN['JOBNO'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_seCheckIN['DATEWORKING'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_seCheckIN['CURRENTUSINGDATE'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_seCheckIN['STOPUSINGDATE'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seCheckIN['ALLTIMEUSING'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seCheckIN['ALLTIMENORMAL'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seCheckIN['ALLTIMESLEEP'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:center;<?= $tdcolorD1?>"><?=$result_seCheckIN['RANKDRIVER']?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_seCheckIN['REMARK']?></td>
                        
                    </tr>

                <?php
                $i++;
            
        }
    ?>

    </tbody>
</table>


<?php
sqlsrv_close($conn);
?>
