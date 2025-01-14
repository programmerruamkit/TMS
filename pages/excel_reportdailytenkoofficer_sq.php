<?php
ini_set('memory_limit', '140M');
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
ini_set('max_execution_time', 300);

$conn = connect("RTMS");
$condition2 = " AND Company_Code = '" . $_GET['companycode'] . "'";
$sql_seComp = "{call megCompany_v2(?,?)}";
$params_seComp = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condition2, SQLSRV_PARAM_IN)
);
$query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
$result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC);

$strExcelFileName = "รายงานการตรวจร่างกายเจ้าหน้าที่".$_GET['datestart'] .".xls";

header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

$datestart =  substr($_GET['datestart'],0,10);
$dateend=  substr($_GET['dateend'],0,10);
$timestart=  substr($_GET['datestart'],11,16);
$timeend=  substr($_GET['dateend'],11,16);




?>
<style>
    body{
        font-family: "Garuda";
    }
</style>
<table width="100%" >
<tbody>
   <tr>
      <td colspan="11" style="text-align:center;font-size:24px"><b>รายงานการตรวจร่างกาย (สำนักงาน)</b></td>
   </tr>
   <tr>
      <td colspan="11" style="text-align:center;font-size:24px"><b>ประจำวันที่ <?=$dateend?></b></td>
   </tr>
   <tr>
      <td colspan="11" style="text-align:center;font-size:24px"><b>เวลา <?=$timestart?> น.(<?=$datestart?>) - <?=$timeend?> น.(<?=$dateend?>)</b></td>
   </tr>
</tbody>
</table>

<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
    <thead>
        <tr style="border:1px solid #000;" >
            <td colspan="11" style="border-right:1px solid #000;padding:3px;text-align:left;">
                <b>แผนก Transportation/Safety & Quality</b>
            </td>
            
        </tr>
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ลำดับ </b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>รหัสพนักงาน</b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ชื่อ-สกุล</b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ตำแหน่ง</b>
            </td>

            <td  colspan="3" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ค่าความดัน</b>
            </td>
            <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>อุณหภูมิ
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>แอลกอฮอล์</b>
            </td>
            <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ออกซิเจนเลือด</b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>หมายเหตุ</b>
            </td>
            

        </tr>
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>บน</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ล่าง</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ชีพจร</b></td>
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
        a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT
        FROM [dbo].[ORGANIZATION] a 
        INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
        INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
        INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
        WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE ='03'
        AND a.EMPLOYEECODE IN ('010074','011553','011671','011679','011683','070245','020355',
            '020476','020583','020607','020724','021398','021419','021426','021446',
            '021468','021469','021485','021487','070001','070106','070135','070221','070102')";
}else{
    $sql_sePlan = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,
        a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT
        FROM [dbo].[ORGANIZATION] a 
        INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
        INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
        INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
        WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE ='03'
        AND a.EMPLOYEECODE IN ('040619','040659','040816','040844','040868','040875','040885','040886','040887',
            '040890','090008','090034','090092','090101','090201','090255','090318','090325','090339','090341',
            '090342','040895')";
}

$query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {


    $sql_seTenkoData = "SELECT  TOP 1 TENKOBEFOREID,TENKOMASTERID,TENKOMASTERDIRVERCODE,
                TENKOMASTERDIRVERNAME,TENKOPRESSUREDATA_90160 AS 'SYS',
                TENKOPRESSUREDATA_60100 AS 'DIA',TENKOPRESSUREDATA_60110 AS 'PULSE',
                TENKOTEMPERATUREDATA AS 'TEMP',TENKOALCOHOLDATA AS 'ALCOHOL',
                TENKOOXYGENDATA AS 'OXYGEN'
                FROM [dbo].[TENKOBEFORE] WHERE TENKOMASTERDIRVERCODE ='" . $result_sePlan['EMPLOYEECODE'] . "'
                AND TENKOPRESSUREDATA_90160 IS NOT NULL
                AND TENKOPRESSUREDATA_60100 IS NOT NULL
                AND TENKOPRESSUREDATA_60110 IS NOT NULL
                AND TENKOTEMPERATUREDATA IS NOT NULL
                AND TENKOALCOHOLDATA IS NOT NULL
                AND TENKOOXYGENDATA IS NOT NULL
                AND CONVERT(DATETIME,CREATEDATE) BETWEEN CONVERT(DATETIME,'" . $_GET['datestart'] . "',103) 
                AND CONVERT(DATETIME,'" . $_GET['dateend'] . "',103)
                ORDER BY CREATEDATE DESC";
    $query_seTenkoData = sqlsrv_query($conn, $sql_seTenkoData, $params_seTenkoData);
    $result_seTenkoData = sqlsrv_fetch_array($query_seTenkoData, SQLSRV_FETCH_ASSOC);

    


    $sql_sePosId = "SELECT PositionID AS 'POSID'  FROM EMPLOYEEEHR2 WHERE PersonCode = '" . $result_sePlan['EMPLOYEECODE'] . "'";
    $query_sePosId = sqlsrv_query($conn, $sql_sePosId, $params_sePosId);
    $result_sePosId = sqlsrv_fetch_array($query_sePosId, SQLSRV_FETCH_ASSOC);

    $sql_sePosName = "SELECT PositionNameT AS 'POSNAME'  FROM EMPLOYEEEHR2 WHERE PositionID ='" . $result_sePosId ['POSID'] . "'";
    $query_sePosName = sqlsrv_query($conn, $sql_sePosName, $params_sePosName);
    $result_sePosName = sqlsrv_fetch_array($query_sePosName, SQLSRV_FETCH_ASSOC);

    
    ?>
            <tr style="border:1px solid #000;" >
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $i ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePosName['POSNAME'] ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_seTenkoData['SYS'] ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_seTenkoData['DIA'] ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_seTenkoData['PULSE']  ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_seTenkoData['TEMP'] ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_seTenkoData['ALCOHOL'] ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seTenkoData['OXYGEN'] ?></td>
                <?php
                if (($result_seTenkoData['SYS'] < '90' || $result_seTenkoData['SYS'] > '140') && ( $result_seTenkoData['SYS'] != '' && $result_seTenkoData['SYS'] != '0')) {
                ?>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;background-color: #FF9966">ความดันค่าบนผิดปกติวัดค่าได้&nbsp;&nbsp;<b>(<?=$result_seTenkoData['SYS']?>)</b></td>    
                <?php
                }else {
                    if (($result_seTenkoData['DIA'] < '60' || $result_seTenkoData['DIA'] > '90') && ( $result_seTenkoData['DIA'] != '' && $result_seTenkoData['DIA'] != '0')) {
                    ?>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;background-color: #FF9966">ความดันค่าล่างผิดปกติวัดค่าได้&nbsp;&nbsp;<b>(<?=$result_seTenkoData['DIA']?>)</b></td>    
                    <?php
                    }else {
                    ?>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"></td>
                    <?php
                    }
                    ?>

                <?php    
                }
                ?>
            </tr>


    <?php
    
    $i++;
    $sumpallet = $sumpallet + ($result_sePlanpallet15['CNTPALLET'] + $result_sePlanpallet30['CNTPALLET']);
    $sumcompen = $sumcompen + ($CompAll15 + $CompAll30);
    $sumall = $sumall + (($result_sePlanpallet15['CNTPALLET'] + $result_sePlanpallet30['CNTPALLET']) + ($CompAll15 + $CompAll30));
}
?>
    </tbody>
</table>
<br>
    <table>
    <b>*หมายเหตุ</b><br>
    <b>-ค่าความดัน</b><br>
    <b>&nbsp;&nbsp;-ค่าบน : 90-140</b><br>
    <b>&nbsp;&nbsp;-ค่าล่าง : 60-90</b><br>    
    <b>&nbsp;&nbsp;-อัตตราการเต้นของหัวใจ : 60-100 ครั้ง</b><br>
    <b style="color:blue;"><u>-อุณหภูมิ : ไม่เกิน 37.0 องศาเซลเซียส</u></b><br>
    <b style="color:blue;"><u>-ค่าออกซิเจนในเลือด : 98-100%</u></b> <br>    
    <b>-แอลกอฮอล์ :0 มิลลิกรัมเปอเซ็นต์</b>
    </table>
    


<?php
sqlsrv_close($conn);
?>
