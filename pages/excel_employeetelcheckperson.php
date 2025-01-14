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


$strExcelFileName = " รายงานข้อมูลการใช้งานโทรศัพท์รายบุคคล (".$_GET['drivercode'] .").xls";

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
      <td colspan="10" style="text-align:center;font-size:24px"><b>รายงานข้อมูลการใช้งานโทรศัพท์ของพนักงาน (รายบุคคล)</b></td>
   </tr>
   <tr>
      <td colspan="10" style="text-align:center;font-size:20px">ชื่อ-นามสกุล: <?=$result_seComp['nameT']?> | รหัสพนักงาน: <?=$result_seComp['PersonCode']?> | ตำแหน่ง: <?=$result_seComp['PositionNameT']?></td>
   </tr>
</tbody>
</table>
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
    <thead>
        <tr style="border:1px solid #000;" >
            <td colspan="10" style="border-right:1px solid #000;padding:3px;text-align:left;">
                <b>ข้อมูลการใช้งานโทรศัพท์</b>
            </td>
            
        </tr>
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ลำดับ</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>หมายเลขงาน</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วัน/เดือน/ปี</b>
            </td>
            <td rowspan="" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ใช้งานล่าสุด</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>หยุดใช้งาน</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>รวมใช้งาน (ชั่วโมง)</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>เวลานอน (ชั่วโมง)</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>เวลานอนจริง (ชั่วโมง)</b>
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

        
       
    // $sql_seCheckIN = "SELECT TOP 1 LATIUDE AS 'LAT',LONGITUDE AS 'LONG',CREATEDATE
    //                 FROM [dbo].[NEWYEARCHECKIN]
    //                 WHERE EMPLOYEECODE ='".$result_sePlan['EMPLOYEECODE']."'
    //                 AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,'".$_GET['datestart']."',103)
    //                 ORDER BY CREATEDATE DESC";
    // $query_seCheckIN = sqlsrv_query($conn, $sql_seCheckIN, $params_seCheckIN);
    // $result_seCheckIN = sqlsrv_fetch_array($query_seCheckIN, SQLSRV_FETCH_ASSOC);
   
      
    ?>
            <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $i ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['JOBNO'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['DATEWORKING'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['CURRENTUSINGDATE'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['STOPUSINGDATE'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_sePlan['ALLTIMEUSING'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_sePlan['ALLTIMENORMAL'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_sePlan['ALLTIMESLEEP'] ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;<?= $tdcolorD1?>"><?=$result_sePlan['RANKDRIVER']?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_sePlan['REMARK']?></td>
                 
            </tr>


        <?php
        $i++;
        $ALLTIMEUSING = $ALLTIMEUSING +  $result_sePlan['ALLTIMEUSINGFORMAT'];
        }
    ?>  
             <tr>
                <th colspan="5" style="border:1px solid #000;padding:3px;text-align: right;background-color: #dedede">เวลาเฉลี่ย</th>
                <td style="border:1px solid #000;padding:3px;text-align: center"><?=number_format($ALLTIMEUSING/($i-1),2)?></td>
                <td style="border:1px solid #000;padding:3px;text-align: center"></td>
                <td style="border:1px solid #000;padding:3px;text-align: center"></td>
                <td style="border:1px solid #000;padding:3px;text-align: center"></td>
                <td style="border:1px solid #000;padding:3px;text-align: center"></td>
            <tr>
    </tbody>
</table>


<?php
sqlsrv_close($conn);
?>
