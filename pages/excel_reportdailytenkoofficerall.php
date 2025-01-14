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
      <td colspan="15" style="text-align:center;font-size:24px"><b>รายงานการตรวจร่างกาย (สำนักงาน)</b></td>
   </tr>
   <tr>
      <td colspan="15" style="text-align:center;font-size:24px"><b>ประจำวันที่ <?=$dateend?></b></td>
   </tr>
   <tr>
      <td colspan="15" style="text-align:center;font-size:24px"><b>เวลา <?=$timestart?> น.(<?=$datestart?>) - <?=$timeend?> น.(<?=$dateend?>)</b></td>
   </tr>
</tbody>
</table>

<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
    <thead>
        <tr style="border:1px solid #000;" >
            <td colspan="15" style="border-right:1px solid #000;padding:3px;text-align:left;">
                <b>รายงานสรุปผลการตรวจร่างกาย </b>
            </td>
        </tr>
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td rowspan="3"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ลำดับ </b>
            </td>
            <td rowspan="3"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>แผนก</b>
            </td>
            <!-- <td rowspan="3"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>จำนวนบุคลากร</b>
            </td> -->

            <td  colspan="6" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ค่าความดัน</b>
            </td>
            <td rowspan="2" colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>อุณหภูมิ
            </td>
            <td rowspan="2" colspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>แอลกอฮอล์</b>
            </td>
            <td rowspan="2" colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ออกซิเจนเลือด</b>
            </td>
            <td rowspan="3"   style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>หมายเหตุ</b>
            </td>
            

        </tr>
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td colspan="2"style="border-right:1px solid #000;padding:3px;text-align:center;"><b>บน</b></td>
            <td colspan="2"style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ล่าง</b></td>
            <td colspan="2"style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ชีพจร</b></td>
        </tr>
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ปกติ</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ผิดปกติ</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ปกติ</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ผิดปกติ</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ปกติ</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ผิดปกติ</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ปกติ</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ผิดปกติ</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ปกติ</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ผิดปกติ</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ปกติ</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ผิดปกติ</b></td>
        </tr>
        

    </thead><tbody>
<?php


//COUNT ACC.
$sql_CountACC = "SELECT COUNT(a.EMPLOYEECODE) AS 'COUNTACC'
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='02' AND c.SECTIONCODE IN ('01','02')
    AND a.AREA = '".$_GET['area']."'";
$query_CountACC = sqlsrv_query($conn, $sql_CountACC, $params_CountACC);
$result_CountACC = sqlsrv_fetch_array($query_CountACC, SQLSRV_FETCH_ASSOC);

$iSYSACCNO = 0;
$iSYSACCIN = 0;
$iDIAACCNO = 0;
$iDIAACCIN = 0;
$iPULSEACCNO = 0;
$iPULSEACCIN = 0;
$iTEMPACCNO = 0;
$iTEMPACCIN = 0;
$iALCOHOLACCNO = 0;
$iALCOHOLACCIN = 0;
$iOXYGENACCNO = 0;
$iOXYGENACCIN = 0;
$i1 =0;
$sql_seDataACC = "SELECT a.EMPLOYEECODE 
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='02' AND c.SECTIONCODE IN ('01','02')
    AND a.AREA = '".$_GET['area']."'";
$query_seDataACC = sqlsrv_query($conn, $sql_seDataACC, $params_seDataACC);
while($result_seDataACC = sqlsrv_fetch_array($query_seDataACC, SQLSRV_FETCH_ASSOC)){


$sql_seTenkoDataACC = "SELECT  TOP 1 TENKOBEFOREID,TENKOMASTERID,TENKOMASTERDIRVERCODE,
    TENKOMASTERDIRVERNAME,TENKOPRESSUREDATA_90160 AS 'SYS',
    TENKOPRESSUREDATA_60100 AS 'DIA',TENKOPRESSUREDATA_60110 AS 'PULSE',
    TENKOTEMPERATUREDATA AS 'TEMP',TENKOALCOHOLDATA AS 'ALCOHOL',
    TENKOOXYGENDATA AS 'OXYGEN'
    FROM [dbo].[TENKOBEFORE] WHERE TENKOMASTERDIRVERCODE ='" . $result_seDataACC['EMPLOYEECODE'] . "'
    AND TENKOPRESSUREDATA_90160 IS NOT NULL
    AND TENKOPRESSUREDATA_60100 IS NOT NULL
    AND TENKOPRESSUREDATA_60110 IS NOT NULL
    AND TENKOTEMPERATUREDATA IS NOT NULL
    AND TENKOALCOHOLDATA IS NOT NULL
    AND TENKOOXYGENDATA IS NOT NULL
    AND CONVERT(DATETIME,CREATEDATE) BETWEEN CONVERT(DATETIME,'" . $_GET['datestart'] . "',103) 
    AND CONVERT(DATETIME,'" . $_GET['dateend'] . "',103)
    ORDER BY CREATEDATE DESC";
$query_seTenkoDataACC  = sqlsrv_query($conn, $sql_seTenkoDataACC , $params_seTenkoDataACC );
$result_seTenkoDataACC  = sqlsrv_fetch_array($query_seTenkoDataACC , SQLSRV_FETCH_ASSOC);
   

    //chk SYS ACC normal
    if (($result_seTenkoDataACC['SYS'] >= '90' && $result_seTenkoDataACC['SYS'] <= '140' ) && ($result_seTenkoDataACC['SYS'] != '' && $result_seTenkoDataACC['SYS'] != '0')) {
        $iSYSACCNO++;
    }else {
        # code...
    }
    //chk SYS ACC innormal
    if (($result_seTenkoDataACC['SYS'] < '90' || $result_seTenkoDataACC['SYS'] > '140') && ($result_seTenkoDataACC['SYS'] != '' && $result_seTenkoDataACC['SYS'] != '0')) {
        $iSYSACCIN++;
    }else {
        # code...
    }
//////////////////////////////////////////////////////////////////////////////////////
    //chk DIA ACC normal
    if (($result_seTenkoDataACC['DIA'] >= '60' && $result_seTenkoDataACC['DIA'] <= '90') && ($result_seTenkoDataACC['DIA'] != '' && $result_seTenkoDataACC['DIA'] != '0')) {
        $iDIAACCNO++;
    }else {
     
    }
    //chk DIA ACC innormal
    if (($result_seTenkoDataACC['DIA'] < '60' || $result_seTenkoDataACC['DIA'] > '90') && ($result_seTenkoDataACC['DIA'] != '' && $result_seTenkoDataACC['DIA'] != '0')) {
        $iDIAACCIN++;
    }else {
     
    }
////////////////////////////////////////////////////////////////////////////////////   
    //chk PULSE ACC normal
    if (($result_seTenkoDataACC['PULSE'] >= '60' && $result_seTenkoDataACC['PULSE'] <= '100') && ($result_seTenkoDataACC['PULSE'] != '' && $result_seTenkoDataACC['PULSE'] != '0')) {
        $iPULSEACCNO++;
    }else {
        # code...
    }
     //chk PULSE ACC innormal
     if (($result_seTenkoDataACC['PULSE'] < '60' || $result_seTenkoDataACC['PULSE'] > '100') && ($result_seTenkoDataACC['PULSE'] != '' && $result_seTenkoDataACC['PULSE'] != '0') ) {
        $iPULSEACCIN++;
    }else {
        # code...
    }

////////////////////////////////////////////////////////////////////////////////////       
    //chk TEMP ACC normal
    if ($result_seTenkoDataACC['TEMP'] < '37' && $result_seTenkoDataACC['TEMP'] != '') {
        $iTEMPACCNO++;
    }else {
        # code...
    }
    //chk TEMP ACC innormal
    if ($result_seTenkoDataACC['TEMP'] > '37' && $result_seTenkoDataACC['TEMP'] != '') {
        $iTEMPACCIN++;
    }else {
        # code...
    }
////////////////////////////////////////////////////////////////////////////////////       
    //chk ALCOHOL ACC normal
    if ($result_seTenkoDataACC['ALCOHOL'] == '0') {
        $iALCOHOLACCNO++;
    }else {
        # code...
    }
    //chk ALCOHOL ACC innormal
    if ($result_seTenkoDataACC['ALCOHOL'] > '0') {
        $iALCOHOLACCIN++;
    }else {
        # code...
    }
////////////////////////////////////////////////////////////////////////////////////       
    //chk OXYGEN ACC normal
    if (($result_seTenkoDataACC['OXYGEN'] >= '96' && $result_seTenkoDataACC['OXYGEN'] <= '100') && ($result_seTenkoDataACC['OXYGEN'] != '' && $result_seTenkoDataACC['OXYGEN'] != '0')) {
        $iOXYGENACCNO++;
    }else {
        # code...
    }
    //chk OXYGEN ACC innormal
    if (($result_seTenkoDataACC['OXYGEN'] < '96' || $result_seTenkoDataACC['OXYGEN'] > '100') && ($result_seTenkoDataACC['OXYGEN'] != '' && $result_seTenkoDataACC['OXYGEN'] != '0')) {
        $iOXYGENACCIN++;
    }else {
        # code...
    }
    
    $i1++;
    
}



//COUNT ADMIN.
$sql_CountADMIN = "SELECT COUNT(a.EMPLOYEECODE) AS 'COUNTADMIN'
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='01' AND c.SECTIONCODE IN ('02')
    AND a.AREA = '".$_GET['area']."'";
$query_CountADMIN = sqlsrv_query($conn, $sql_CountADMIN, $params_CountADMIN);
$result_CountADMIN = sqlsrv_fetch_array($query_CountADMIN, SQLSRV_FETCH_ASSOC);

$iSYSADMINNO = 0;
$iSYSADMININ = 0;
$iDIAADMINNO = 0;
$iDIAADMININ = 0;
$iPULSEADMINNO = 0;
$iPULSEADMININ = 0;
$iTEMPADMINNO = 0;
$iTEMPADMININ = 0;
$iALCOHOLADMINNO = 0;
$iALCOHOLADMININ = 0;
$iOXYGENADMINNO = 0;
$iOXYGENADMININ = 0;
$i2 =0;
$sql_seDataADMIN = "SELECT a.EMPLOYEECODE 
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='01' AND c.SECTIONCODE IN ('02')
    AND a.AREA = '".$_GET['area']."'";
$query_seDataADMIN = sqlsrv_query($conn, $sql_seDataADMIN, $params_seDataADMIN);
while($result_seDataADMIN = sqlsrv_fetch_array($query_seDataADMIN, SQLSRV_FETCH_ASSOC)){


$sql_seTenkoDataADMIN = "SELECT  TOP 1 TENKOBEFOREID,TENKOMASTERID,TENKOMASTERDIRVERCODE,
        TENKOMASTERDIRVERNAME,TENKOPRESSUREDATA_90160 AS 'SYS',
        TENKOPRESSUREDATA_60100 AS 'DIA',TENKOPRESSUREDATA_60110 AS 'PULSE',
        TENKOTEMPERATUREDATA AS 'TEMP',TENKOALCOHOLDATA AS 'ALCOHOL',
        TENKOOXYGENDATA AS 'OXYGEN'
    FROM [dbo].[TENKOBEFORE] WHERE TENKOMASTERDIRVERCODE ='" . $result_seDataADMIN['EMPLOYEECODE'] . "'
    AND TENKOPRESSUREDATA_90160 IS NOT NULL
    AND TENKOPRESSUREDATA_60100 IS NOT NULL
    AND TENKOPRESSUREDATA_60110 IS NOT NULL
    AND TENKOTEMPERATUREDATA IS NOT NULL
    AND TENKOALCOHOLDATA IS NOT NULL
    AND TENKOOXYGENDATA IS NOT NULL
    AND CONVERT(DATETIME,CREATEDATE) BETWEEN CONVERT(DATETIME,'" . $_GET['datestart'] . "',103) 
    AND CONVERT(DATETIME,'" . $_GET['dateend'] . "',103)
    ORDER BY CREATEDATE DESC";
$query_seTenkoDataADMIN  = sqlsrv_query($conn, $sql_seTenkoDataADMIN , $params_seTenkoDataADMIN);
$result_seTenkoDataADMIN  = sqlsrv_fetch_array($query_seTenkoDataADMIN , SQLSRV_FETCH_ASSOC);
    
    
    //chk SYS ADMIN normal
    if (($result_seTenkoDataADMIN['SYS'] >= '90' && $result_seTenkoDataADMIN['SYS'] <= '140' ) && ($result_seTenkoDataADMIN['SYS'] != '' && $result_seTenkoDataADMIN['SYS'] != '0')) {
        $iSYSADMINNO++;
    }else {
        # code...
    }
    //chk SYS ADMIN innormal
    if (($result_seTenkoDataADMIN['SYS'] < '90' || $result_seTenkoDataADMIN['SYS'] > '140') && ($result_seTenkoDataADMIN['SYS'] != '' && $result_seTenkoDataADMIN['SYS'] != '0')) {
        $iSYSADMININ++;
    }else {
        # code...
    }
//////////////////////////////////////////////////////////////////////////////////////
    //chk DIA ADMIN normal
    if (($result_seTenkoDataADMIN['DIA'] >= '60' && $result_seTenkoDataADMIN['DIA'] <= '90') && ($result_seTenkoDataADMIN['DIA'] != '' && $result_seTenkoDataADMIN['DIA'] != '0')) {
        $iDIAADMINNO++;
    }else {
     
    }
    //chk DIA ADMIN innormal
    if (($result_seTenkoDataADMIN['DIA'] < '60' || $result_seTenkoDataADMIN['DIA'] > '90') && ($result_seTenkoDataADMIN['DIA'] != '' && $result_seTenkoDataADMIN['DIA'] != '0')) {
        $iDIAADMININ++;
    }else {
     
    }
////////////////////////////////////////////////////////////////////////////////////   
    //chk PULSE ADMIN normal
    if (($result_seTenkoDataADMIN['PULSE'] >= '60' && $result_seTenkoDataADMIN['PULSE'] <= '100') && ($result_seTenkoDataADMIN['PULSE'] != '' && $result_seTenkoDataADMIN['PULSE'] != '0')) {
        $iPULSEADMINNO++;
    }else {
        # code...
    }
     //chk PULSE ADMIN innormal
     if (($result_seTenkoDataADMIN['PULSE'] < '60' || $result_seTenkoDataADMIN['PULSE'] > '100') && ($result_seTenkoDataADMIN['PULSE'] != '' && $result_seTenkoDataADMIN['PULSE'] != '0') ) {
        $iPULSEADMININ++;
    }else {
        # code...
    }

////////////////////////////////////////////////////////////////////////////////////       
    //chk TEMP ADMIN normal
    if ($result_seTenkoDataADMIN['TEMP'] < '37' && $result_seTenkoDataADMIN['TEMP'] != '') {
        $iTEMPADMINNO++;
    }else {
        # code...
    }
    //chk TEMP ADMIN innormal
    if ($result_seTenkoDataADMIN['TEMP'] > '37' && $result_seTenkoDataADMIN['TEMP'] != '') {
        $iTEMPADMININ++;
    }else {
        # code...
    }
////////////////////////////////////////////////////////////////////////////////////       
    //chk ALCOHOL ADMIN normal
    if ($result_seTenkoDataADMIN['ALCOHOL'] == '0') {
        $iALCOHOLADMINNO++;
    }else {
        # code...
    }
    //chk ALCOHOL ADMIN innormal
    if ($result_seTenkoDataADMIN['ALCOHOL'] > '0') {
        $iALCOHOLADMININ++;
    }else {
        # code...
    }
////////////////////////////////////////////////////////////////////////////////////       
    //chk OXYGEN ADMIN normal
    if (($result_seTenkoDataADMIN['OXYGEN'] >= '96' && $result_seTenkoDataADMIN['OXYGEN'] <= '100') && ($result_seTenkoDataADMIN['OXYGEN'] != '' && $result_seTenkoDataADMIN['OXYGEN'] != '0')) {
        $iOXYGENADMINNO++;
    }else {
        # code...
    }
    //chk OXYGEN ADMIN innormal
    if (($result_seTenkoDataADMIN['OXYGEN'] < '96' || $result_seTenkoDataADMIN['OXYGEN'] > '100') && ($result_seTenkoDataADMIN['OXYGEN'] != '' && $result_seTenkoDataADMIN['OXYGEN'] != '0')) {
        $iOXYGENADMININ++;
    }else {
        # code...
    }

    $i2++;
    
}


//COUNT Corp.
$sql_CountCORP = "SELECT COUNT(a.EMPLOYEECODE) AS 'COUNTCORP'
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='01' AND c.SECTIONCODE IN ('01')
    AND a.AREA = '".$_GET['area']."'";
$query_CountCORP = sqlsrv_query($conn, $sql_CountCORP, $params_CountCORP);
$result_CountCORP = sqlsrv_fetch_array($query_CountCORP, SQLSRV_FETCH_ASSOC);

$iSYSCORPNO = 0;
$iSYSCORPIN = 0;
$iDIACORPNO = 0;
$iDIACORPIN = 0;
$iPULSECORPNO = 0;
$iPULSECORPIN = 0;
$iTEMPCORPNO = 0;
$iTEMPCORPIN = 0;
$iALCOHOLCORPNO = 0;
$iALCOHOLCORPIN = 0;
$iOXYGENCORPNO = 0;
$iOXYGENCORPIN = 0;
$i3 =0;
$sql_seDataCORP = "SELECT a.EMPLOYEECODE 
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='01' AND c.SECTIONCODE IN ('01')
    AND a.AREA = '".$_GET['area']."'";
$query_seDataCORP = sqlsrv_query($conn, $sql_seDataCORP, $params_seDataCORP);
while($result_seDataCORP = sqlsrv_fetch_array($query_seDataCORP, SQLSRV_FETCH_ASSOC)){


$sql_seTenkoDataCORP = "SELECT  TOP 1 TENKOBEFOREID,TENKOMASTERID,TENKOMASTERDIRVERCODE,
    TENKOMASTERDIRVERNAME,TENKOPRESSUREDATA_90160 AS 'SYS',
    TENKOPRESSUREDATA_60100 AS 'DIA',TENKOPRESSUREDATA_60110 AS 'PULSE',
    TENKOTEMPERATUREDATA AS 'TEMP',TENKOALCOHOLDATA AS 'ALCOHOL',
    TENKOOXYGENDATA AS 'OXYGEN'
    FROM [dbo].[TENKOBEFORE] WHERE TENKOMASTERDIRVERCODE ='" . $result_seDataCORP['EMPLOYEECODE'] . "'
    AND TENKOPRESSUREDATA_90160 IS NOT NULL
    AND TENKOPRESSUREDATA_60100 IS NOT NULL
    AND TENKOPRESSUREDATA_60110 IS NOT NULL
    AND TENKOTEMPERATUREDATA IS NOT NULL
    AND TENKOALCOHOLDATA IS NOT NULL
    AND TENKOOXYGENDATA IS NOT NULL
    AND CONVERT(DATETIME,CREATEDATE) BETWEEN CONVERT(DATETIME,'" . $_GET['datestart'] . "',103) 
    AND CONVERT(DATETIME,'" . $_GET['dateend'] . "',103)
    ORDER BY CREATEDATE DESC";
$query_seTenkoDataCORP  = sqlsrv_query($conn, $sql_seTenkoDataCORP , $params_seTenkoDataCORP);
$result_seTenkoDataCORP = sqlsrv_fetch_array($query_seTenkoDataCORP , SQLSRV_FETCH_ASSOC);
    
    
    //chk SYS CORP normal
    if (($result_seTenkoDataCORP['SYS'] >= '90' && $result_seTenkoDataCORP['SYS'] <= '140' ) && ($result_seTenkoDataCORP['SYS'] != '' && $result_seTenkoDataCORP['SYS'] != '0')) {
        $iSYSCORPNO++;
    }else {
        # code...
    }
    //chk SYS CORP innormal
    if (($result_seTenkoDataCORP['SYS'] < '90' || $result_seTenkoDataCORP['SYS'] > '140') && ($result_seTenkoDataCORP['SYS'] != '' && $result_seTenkoDataCORP['SYS'] != '0')) {
        $iSYSCORPIN++;
    }else {
        # code...
    }
//////////////////////////////////////////////////////////////////////////////////////
    //chk DIA CORP normal
    if (($result_seTenkoDataCORP['DIA'] >= '60' && $result_seTenkoDataCORP['DIA'] <= '90') && ($result_seTenkoDataCORP['DIA'] != '' && $result_seTenkoDataCORP['DIA'] != '0')) {
        $iDIACORPNO++;
    }else {
     
    }
    //chk DIA CORP innormal
    if (($result_seTenkoDataCORP['DIA'] < '60' || $result_seTenkoDataCORP['DIA'] > '90') && ($result_seTenkoDataCORP['DIA'] != '' && $result_seTenkoDataCORP['DIA'] != '0')) {
        $iDIACORPIN++;
    }else {
     
    }
////////////////////////////////////////////////////////////////////////////////////   
    //chk PULSE CORP normal
    if (($result_seTenkoDataCORP['PULSE'] >= '60' && $result_seTenkoDataCORP['PULSE'] <= '100') && ($result_seTenkoDataCORP['PULSE'] != '' && $result_seTenkoDataCORP['PULSE'] != '0')) {
        $iPULSECORPNO++;
    }else {
        # code...
    }
     //chk PULSE CORP innormal
     if (($result_seTenkoDataCORP['PULSE'] < '60' || $result_seTenkoDataCORP['PULSE'] > '100') && ($result_seTenkoDataCORP['PULSE'] != '' && $result_seTenkoDataCORP['PULSE'] != '0') ) {
        $iPULSECORPIN++;
    }else {
        # code...
    }

////////////////////////////////////////////////////////////////////////////////////       
    //chk TEMP CORP normal
    if ($result_seTenkoDataCORP['TEMP'] < '37' && $result_seTenkoDataCORP['TEMP'] != '') {
        $iTEMPCORPNO++;
    }else {
        # code...
    }
    //chk TEMP CORP innormal
    if ($result_seTenkoDataCORP['TEMP'] > '37' && $result_seTenkoDataCORP['TEMP'] != '') {
        $iTEMPCORPIN++;
    }else {
        # code...
    }
////////////////////////////////////////////////////////////////////////////////////       
    //chk ALCOHOL CORP normal
    if ($result_seTenkoDataCORP['ALCOHOL'] == '0') {
        $iALCOHOLCORPNO++;
    }else {
        # code...
    }
    //chk ALCOHOL CORP innormal
    if ($result_seTenkoDataCORP['ALCOHOL'] > '0') {
        $iALCOHOLCORPIN++;
    }else {
        # code...
    }
////////////////////////////////////////////////////////////////////////////////////       
    //chk OXYGEN CORP normal
    if (($result_seTenkoDataCORP['OXYGEN'] >= '96' && $result_seTenkoDataCORP['OXYGEN'] <= '100') && ($result_seTenkoDataCORP['OXYGEN'] != '' && $result_seTenkoDataCORP['OXYGEN'] != '0')) {
        $iOXYGENCORPNO++;
    }else {
        # code...
    }
    //chk OXYGEN CORP innormal
    if (($result_seTenkoDataCORP['OXYGEN'] < '96' || $result_seTenkoDataCORP['OXYGEN'] > '100') && ($result_seTenkoDataCORP['OXYGEN'] != '' && $result_seTenkoDataCORP['OXYGEN'] != '0')) {
        $iOXYGENCORPIN++;
    }else {
        # code...
    }
    
    $i3++;
    
}

//COUNT CRM.
$sql_CountCRM = "SELECT COUNT(a.EMPLOYEECODE) AS 'COUNTCRM'
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE IN ('01')
    AND a.AREA = '".$_GET['area']."'";
$query_CountCRM = sqlsrv_query($conn, $sql_CountCRM, $params_CountCRM);
$result_CountCRM = sqlsrv_fetch_array($query_CountCRM, SQLSRV_FETCH_ASSOC);

$iSYSCRMNO = 0;
$iSYSCRMIN = 0;
$iDIACRMNO = 0;
$iDIACRMIN = 0;
$iPULSECRMNO = 0;
$iPULSECRMIN = 0;
$iTEMPCRMNO = 0;
$iTEMPCRMIN = 0;
$iALCOHOLCRMNO = 0;
$iALCOHOLCRMIN = 0;
$iOXYGENCRMNO = 0;
$iOXYGENCRMIN = 0;
$i4 =0;
$sql_seDataCRM = "SELECT a.EMPLOYEECODE 
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE IN ('01')
    AND a.AREA = '".$_GET['area']."'";
$query_seDataCRM = sqlsrv_query($conn, $sql_seDataCRM, $params_seDataCRM);
while($result_seDataCRM = sqlsrv_fetch_array($query_seDataCRM, SQLSRV_FETCH_ASSOC)){


$sql_seTenkoDataCRM = "SELECT  TOP 1 TENKOBEFOREID,TENKOMASTERID,TENKOMASTERDIRVERCODE,
        TENKOMASTERDIRVERNAME,TENKOPRESSUREDATA_90160 AS 'SYS',
        TENKOPRESSUREDATA_60100 AS 'DIA',TENKOPRESSUREDATA_60110 AS 'PULSE',
        TENKOTEMPERATUREDATA AS 'TEMP',TENKOALCOHOLDATA AS 'ALCOHOL',
        TENKOOXYGENDATA AS 'OXYGEN'
    FROM [dbo].[TENKOBEFORE] WHERE TENKOMASTERDIRVERCODE ='" . $result_seDataCRM['EMPLOYEECODE'] . "'
    AND TENKOPRESSUREDATA_90160 IS NOT NULL
    AND TENKOPRESSUREDATA_60100 IS NOT NULL
    AND TENKOPRESSUREDATA_60110 IS NOT NULL
    AND TENKOTEMPERATUREDATA IS NOT NULL
    AND TENKOALCOHOLDATA IS NOT NULL
    AND TENKOOXYGENDATA IS NOT NULL
    AND CONVERT(DATETIME,CREATEDATE) BETWEEN CONVERT(DATETIME,'" . $_GET['datestart'] . "',103) 
    AND CONVERT(DATETIME,'" . $_GET['dateend'] . "',103)
    ORDER BY CREATEDATE DESC";
$query_seTenkoDataCRM  = sqlsrv_query($conn, $sql_seTenkoDataCRM , $params_seTenkoDataCRM);
$result_seTenkoDataCRM  = sqlsrv_fetch_array($query_seTenkoDataCRM , SQLSRV_FETCH_ASSOC);
   
    
    //chk SYS CRM normal
    if (($result_seTenkoDataCRM['SYS'] >= '90' && $result_seTenkoDataCRM['SYS'] <= '140' ) && ($result_seTenkoDataCRM['SYS'] != '' && $result_seTenkoDataCRM['SYS'] != '0')) {
        $iSYSCRMNO++;
    }else {
        # code...
    }
    //chk SYS CRM innormal
    if (($result_seTenkoDataCRM['SYS'] < '90' || $result_seTenkoDataCRM['SYS'] > '140') && ($result_seTenkoDataCRM['SYS'] != '' && $result_seTenkoDataCRM['SYS'] != '0')) {
        $iSYSCRMIN++;
    }else {
        # code...
    }
//////////////////////////////////////////////////////////////////////////////////////
    //chk DIA CRM normal
    if (($result_seTenkoDataCRM['DIA'] >= '60' && $result_seTenkoDataCRM['DIA'] <= '90') && ($result_seTenkoDataCRM['DIA'] != '' && $result_seTenkoDataCRM['DIA'] != '0')) {
        $iDIACRMNO++;
    }else {
     
    }
    //chk DIA CRM innormal
    if (($result_seTenkoDataCRM['DIA'] < '60' || $result_seTenkoDataCRM['DIA'] > '90') && ($result_seTenkoDataCRM['DIA'] != '' && $result_seTenkoDataCRM['DIA'] != '0')) {
        $iDIACRMIN++;
    }else {
     
    }
////////////////////////////////////////////////////////////////////////////////////   
    //chk PULSE CRM normal
    if (($result_seTenkoDataCRM['PULSE'] >= '60' && $result_seTenkoDataCRM['PULSE'] <= '100') && ($result_seTenkoDataCRM['PULSE'] != '' && $result_seTenkoDataCRM['PULSE'] != '0')) {
        $iPULSECRMNO++;
    }else {
        # code...
    }
     //chk PULSE CRM innormal
     if (($result_seTenkoDataCRM['PULSE'] < '60' || $result_seTenkoDataCRM['PULSE'] > '100') && ($result_seTenkoDataCRM['PULSE'] != '' && $result_seTenkoDataCRM['PULSE'] != '0') ) {
        $iPULSECRMIN++;
    }else {
        # code...
    }

////////////////////////////////////////////////////////////////////////////////////       
    //chk TEMP CRM normal
    if ($result_seTenkoDataCRM['TEMP'] < '37' && $result_seTenkoDataCRM['TEMP'] != '') {
        $iTEMPCRMNO++;
    }else {
        # code...
    }
    //chk TEMP CRM innormal
    if ($result_seTenkoDataCRM['TEMP'] > '37' && $result_seTenkoDataCRM['TEMP'] != '') {
        $iTEMPCRMIN++;
    }else {
        # code...
    }
////////////////////////////////////////////////////////////////////////////////////       
    //chk ALCOHOL CRM normal
    if ($result_seTenkoDataCRM['ALCOHOL'] == '0') {
        $iALCOHOLCRMNO++;
    }else {
        # code...
    }
    //chk ALCOHOL CRM innormal
    if ($result_seTenkoDataCRM['ALCOHOL'] > '0') {
        $iALCOHOLCRMIN++;
    }else {
        # code...
    }
////////////////////////////////////////////////////////////////////////////////////       
    //chk OXYGEN CRM normal
    if (($result_seTenkoDataCRM['OXYGEN'] >= '96' && $result_seTenkoDataCRM['OXYGEN'] <= '100') && ($result_seTenkoDataCRM['OXYGEN'] != '' && $result_seTenkoDataCRM['OXYGEN'] != '0')) {
        $iOXYGENCRMNO++;
    }else {
        # code...
    }
    //chk OXYGEN CRM innormal
    if (($result_seTenkoDataCRM['OXYGEN'] < '96' || $result_seTenkoDataCRM['OXYGEN'] > '100') && ($result_seTenkoDataCRM['OXYGEN'] != '' && $result_seTenkoDataCRM['OXYGEN'] != '0')) {
        $iOXYGENCRMIN++;
    }else {
        # code...
    }
   
    $i4++;
    
}

//COUNT MK/PL.
$sql_CountMKPL = "SELECT COUNT(a.EMPLOYEECODE) AS 'COUNTMKPL'
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE IN ('02')
    AND a.AREA = '".$_GET['area']."'";
$query_CountMKPL = sqlsrv_query($conn, $sql_CountMKPL, $params_CountMKPL);
$result_CountMKPL = sqlsrv_fetch_array($query_CountMKPL, SQLSRV_FETCH_ASSOC);

$iSYSMKPLNO = 0;
$iSYSMKPLIN = 0;
$iDIAMKPLNO = 0;
$iDIAMKPLIN = 0;
$iPULSEMKPLNO = 0;
$iPULSEMKPLIN = 0;
$iTEMPMKPLNO = 0;
$iTEMPMKPLIN = 0;
$iALCOHOLMKPLNO = 0;
$iALCOHOLMKPLIN = 0;
$iOXYGENMKPLNO = 0;
$iOXYGENMKPLIN = 0;
$i5 =0;
$sql_seDataMKPL = "SELECT a.EMPLOYEECODE 
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE IN ('02')
    AND a.AREA = '".$_GET['area']."'";
$query_seDataMKPL = sqlsrv_query($conn, $sql_seDataMKPL, $params_seDataMKPL);
while($result_seDataMKPL = sqlsrv_fetch_array($query_seDataMKPL, SQLSRV_FETCH_ASSOC)){


$sql_seTenkoDataMKPL = "SELECT  TOP 1 TENKOBEFOREID,TENKOMASTERID,TENKOMASTERDIRVERCODE,
    TENKOMASTERDIRVERNAME,TENKOPRESSUREDATA_90160 AS 'SYS',
    TENKOPRESSUREDATA_60100 AS 'DIA',TENKOPRESSUREDATA_60110 AS 'PULSE',
    TENKOTEMPERATUREDATA AS 'TEMP',TENKOALCOHOLDATA AS 'ALCOHOL',
    TENKOOXYGENDATA AS 'OXYGEN'
    FROM [dbo].[TENKOBEFORE] WHERE TENKOMASTERDIRVERCODE ='" . $result_seDataMKPL['EMPLOYEECODE'] . "'
    AND TENKOPRESSUREDATA_90160 IS NOT NULL
    AND TENKOPRESSUREDATA_60100 IS NOT NULL
    AND TENKOPRESSUREDATA_60110 IS NOT NULL
    AND TENKOTEMPERATUREDATA IS NOT NULL
    AND TENKOALCOHOLDATA IS NOT NULL
    AND TENKOOXYGENDATA IS NOT NULL
    AND CONVERT(DATETIME,CREATEDATE) BETWEEN CONVERT(DATETIME,'" . $_GET['datestart'] . "',103) 
    AND CONVERT(DATETIME,'" . $_GET['dateend'] . "',103)
    ORDER BY CREATEDATE DESC";
$query_seTenkoDataMKPL  = sqlsrv_query($conn, $sql_seTenkoDataMKPL , $params_seTenkoDataMKPL);
$result_seTenkoDataMKPL  = sqlsrv_fetch_array($query_seTenkoDataMKPL , SQLSRV_FETCH_ASSOC);
    
    
    //chk SYS MKPL normal
    if (($result_seTenkoDataMKPL['SYS'] >= '90' && $result_seTenkoDataMKPL['SYS'] <= '140' ) && ($result_seTenkoDataMKPL['SYS'] != '' && $result_seTenkoDataMKPL['SYS'] != '0')) {
        $iSYSMKPLNO++;
    }else {
        # code...
    }
    //chk SYS MKPL innormal
    if (($result_seTenkoDataMKPL['SYS'] < '90' || $result_seTenkoDataMKPL['SYS'] > '140') && ($result_seTenkoDataMKPL['SYS'] != '' && $result_seTenkoDataMKPL['SYS'] != '0')) {
        $iSYSMKPLIN++;
    }else {
        # code...
    }
//////////////////////////////////////////////////////////////////////////////////////
    //chk DIA MKPL normal
    if (($result_seTenkoDataMKPL['DIA'] >= '60' && $result_seTenkoDataMKPL['DIA'] <= '90') && ($result_seTenkoDataMKPL['DIA'] != '' && $result_seTenkoDataMKPL['DIA'] != '0')) {
        $iDIAMKPLNO++;
    }else {
     
    }
    //chk DIA MKPL innormal
    if (($result_seTenkoDataMKPL['DIA'] < '60' || $result_seTenkoDataMKPL['DIA'] > '90') && ($result_seTenkoDataMKPL['DIA'] != '' && $result_seTenkoDataMKPL['DIA'] != '0')) {
        $iDIAMKPLIN++;
    }else {
     
    }
////////////////////////////////////////////////////////////////////////////////////   
    //chk PULSE MKPL normal
    if (($result_seTenkoDataMKPL['PULSE'] >= '60' && $result_seTenkoDataMKPL['PULSE'] <= '100') && ($result_seTenkoDataMKPL['PULSE'] != '' && $result_seTenkoDataMKPL['PULSE'] != '0')) {
        $iPULSEMKPLNO++;
    }else {
        # code...
    }
     //chk PULSE MKPL innormal
     if (($result_seTenkoDataMKPL['PULSE'] < '60' || $result_seTenkoDataMKPL['PULSE'] > '100') && ($result_seTenkoDataMKPL['PULSE'] != '' && $result_seTenkoDataMKPL['PULSE'] != '0') ) {
        $iPULSEMKPLIN++;
    }else {
        # code...
    }

////////////////////////////////////////////////////////////////////////////////////       
    //chk TEMP MKPL normal
    if ($result_seTenkoDataMKPL['TEMP'] < '37' && $result_seTenkoDataMKPL['TEMP'] != '') {
        $iTEMPMKPLNO++;
    }else {
        # code...
    }
    //chk TEMP MKPL innormal
    if ($result_seTenkoDataMKPL['TEMP'] > '37' && $result_seTenkoDataMKPL['TEMP'] != '') {
        $iTEMPMKPLIN++;
    }else {
        # code...
    }
////////////////////////////////////////////////////////////////////////////////////       
    //chk ALCOHOL MKPL normal
    if ($result_seTenkoDataMKPL['ALCOHOL'] == '0') {
        $iALCOHOLMKPLNO++;
    }else {
        # code...
    }
    //chk ALCOHOL MKPL innormal
    if ($result_seTenkoDataMKPL['ALCOHOL'] > '0') {
        $iALCOHOLMKPLIN++;
    }else {
        # code...
    }
////////////////////////////////////////////////////////////////////////////////////       
    //chk OXYGEN MKPL normal
    if (($result_seTenkoDataMKPL['OXYGEN'] >= '96' && $result_seTenkoDataMKPL['OXYGEN'] <= '100') && ($result_seTenkoDataMKPL['OXYGEN'] != '' && $result_seTenkoDataMKPL['OXYGEN'] != '0')) {
        $iOXYGENMKPLNO++;
    }else {
        # code...
    }
    //chk OXYGEN MKPL innormal
    if (($result_seTenkoDataMKPL['OXYGEN'] < '96' || $result_seTenkoDataMKPL['OXYGEN'] > '100') && ($result_seTenkoDataMKPL['OXYGEN'] != '' && $result_seTenkoDataMKPL['OXYGEN'] != '0')) {
        $iOXYGENMKPLIN++;
    }else {
        # code...
    }
    
    $i5++;
    
}

//COUNT SQ
if ($_GET['area'] == 'amata') {
    $sql_CountSQ = "SELECT COUNT(a.EMPLOYEECODE) AS 'COUNTSQ'
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE IN ('03')
    AND a.EMPLOYEECODE IN ('010074','011553','011671','011679','011683','020319','020355',
            '020476','020583','020607','020724','021398','021419','021426','021446',
            '021468','021469','021485','021487','070001','070106','070135','070221','070102')";
}else{
    $sql_CountSQ = "SELECT COUNT(a.EMPLOYEECODE) AS 'COUNTSQ'
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE IN ('03')
    AND a.EMPLOYEECODE IN ('040619','040659','040816','040844','040868','040875','040885','040886','040887',
            '040890','090008','090034','090092','090101','090201','090255','090318','090325','090339','090341',
            '090342')";
}

$query_CountSQ = sqlsrv_query($conn, $sql_CountSQ, $params_CountSQ);
$result_CountSQ = sqlsrv_fetch_array($query_CountSQ, SQLSRV_FETCH_ASSOC);

$iSYSSQNO = 0;
$iSYSSQIN = 0;
$iDIASQNO = 0;
$iDIASQIN = 0;
$iPULSESQNO = 0;
$iPULSESQIN = 0;
$iTEMPSQNO = 0;
$iTEMPSQIN = 0;
$iALCOHOLSQNO = 0;
$iALCOHOLSQIN = 0;
$iOXYGENSQNO = 0;
$iOXYGENSQIN = 0;
$i6 =0;

if ($_GET['area'] == 'amata') {
    $sql_seDataSQ = "SELECT a.EMPLOYEECODE 
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE IN ('03')
    AND a.EMPLOYEECODE IN ('010074','011553','011671','011679','011683','020319','020355',
            '020476','020583','020607','020724','021398','021419','021426','021446',
            '021468','021469','021485','021487','070001','070106','070135','070221','070102')";
}else {
    $sql_seDataSQ = "SELECT a.EMPLOYEECODE 
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE IN ('03')
    AND a.EMPLOYEECODE IN ('040619','040659','040816','040844','040868','040875','040885','040886','040887',
            '040890','090008','090034','090092','090101','090201','090255','090318','090325','090339','090341',
            '090342')";
}

$query_seDataSQ = sqlsrv_query($conn, $sql_seDataSQ, $params_seDataSQ);
while($result_seDataSQ = sqlsrv_fetch_array($query_seDataSQ, SQLSRV_FETCH_ASSOC)){


$sql_seTenkoDataSQ = "SELECT  TOP 1 TENKOBEFOREID,TENKOMASTERID,TENKOMASTERDIRVERCODE,
    TENKOMASTERDIRVERNAME,TENKOPRESSUREDATA_90160 AS 'SYS',
    TENKOPRESSUREDATA_60100 AS 'DIA',TENKOPRESSUREDATA_60110 AS 'PULSE',
    TENKOTEMPERATUREDATA AS 'TEMP',TENKOALCOHOLDATA AS 'ALCOHOL',
    TENKOOXYGENDATA AS 'OXYGEN'
    FROM [dbo].[TENKOBEFORE] WHERE TENKOMASTERDIRVERCODE ='" . $result_seDataSQ['EMPLOYEECODE'] . "'
    AND TENKOPRESSUREDATA_90160 IS NOT NULL
    AND TENKOPRESSUREDATA_60100 IS NOT NULL
    AND TENKOPRESSUREDATA_60110 IS NOT NULL
    AND TENKOTEMPERATUREDATA IS NOT NULL
    AND TENKOALCOHOLDATA IS NOT NULL
    AND TENKOOXYGENDATA IS NOT NULL
    AND CONVERT(DATETIME,CREATEDATE) BETWEEN CONVERT(DATETIME,'" . $_GET['datestart'] . "',103) 
    AND CONVERT(DATETIME,'" . $_GET['dateend'] . "',103)
    ORDER BY CREATEDATE DESC";
$query_seTenkoDataSQ  = sqlsrv_query($conn, $sql_seTenkoDataSQ , $params_seTenkoDataSQ);
$result_seTenkoDataSQ  = sqlsrv_fetch_array($query_seTenkoDataSQ , SQLSRV_FETCH_ASSOC);
    
    
    //chk SYS MKPL normal
    if (($result_seTenkoDataSQ['SYS'] >= '90' && $result_seTenkoDataSQ['SYS'] <= '140' ) && ($result_seTenkoDataSQ['SYS'] != '' && $result_seTenkoDataSQ['SYS'] != '0')) {
        $iSYSSQNO++;
    }else {
        # code...
    }
    //chk SYS MKPL innormal
    if (($result_seTenkoDataSQ['SYS'] < '90' || $result_seTenkoDataSQ['SYS'] > '140') && ($result_seTenkoDataSQ['SYS'] != '' && $result_seTenkoDataSQ['SYS'] != '0')) {
        $iSYSSQIN++;
    }else {
        # code...
    }
//////////////////////////////////////////////////////////////////////////////////////
    //chk DIA MKPL normal
    if (($result_seTenkoDataSQ['DIA'] >= '60' && $result_seTenkoDataSQ['DIA'] <= '90') && ($result_seTenkoDataSQ['DIA'] != '' && $result_seTenkoDataSQ['DIA'] != '0')) {
        $iDIASQNO++;
    }else {
     
    }
    //chk DIA MKPL innormal
    if (($result_seTenkoDataSQ['DIA'] < '60' || $result_seTenkoDataSQ['DIA'] > '90') && ($result_seTenkoDataSQ['DIA'] != '' && $result_seTenkoDataSQ['DIA'] != '0')) {
        $iDIASQIN++;
    }else {
     
    }
////////////////////////////////////////////////////////////////////////////////////   
    //chk PULSE MKPL normal
    if (($result_seTenkoDataSQ['PULSE'] >= '60' && $result_seTenkoDataSQ['PULSE'] <= '100') && ($result_seTenkoDataSQ['PULSE'] != '' && $result_seTenkoDataSQ['PULSE'] != '0')) {
        $iPULSESQNO++;
    }else {
        # code...
    }
     //chk PULSE MKPL innormal
     if (($result_seTenkoDataSQ['PULSE'] < '60' || $result_seTenkoDataSQ['PULSE'] > '100') && ($result_seTenkoDataSQ['PULSE'] != '' && $result_seTenkoDataSQ['PULSE'] != '0') ) {
        $iPULSESQIN++;
    }else {
        # code...
    }

////////////////////////////////////////////////////////////////////////////////////       
    //chk TEMP MKPL normal
    if ($result_seTenkoDataSQ['TEMP'] < '37' && $result_seTenkoDataSQ['TEMP'] != '') {
        $iTEMPSQNO++;
    }else {
        # code...
    }
    //chk TEMP MKPL innormal
    if ($result_seTenkoDataSQ['TEMP'] > '37' && $result_seTenkoDataSQ['TEMP'] != '') {
        $iTEMPSQIN++;
    }else {
        # code...
    }
////////////////////////////////////////////////////////////////////////////////////       
    //chk ALCOHOL MKPL normal
    if ($result_seTenkoDataSQ['ALCOHOL'] == '0') {
        $iALCOHOLSQNO++;
    }else {
        # code...
    }
    //chk ALCOHOL MKPL innormal
    if ($result_seTenkoDataSQ['ALCOHOL'] > '0') {
        $iALCOHOLSQIN++;
    }else {
        # code...
    }
////////////////////////////////////////////////////////////////////////////////////       
    //chk OXYGEN MKPL normal
    if (($result_seTenkoDataSQ['OXYGEN'] >= '96' && $result_seTenkoDataSQ['OXYGEN'] <= '100') && ($result_seTenkoDataSQ['OXYGEN'] != '' && $result_seTenkoDataSQ['OXYGEN'] != '0')) {
        $iOXYGENSQNO++;
    }else {
        # code...
    }
    //chk OXYGEN MKPL innormal
    if (($result_seTenkoDataSQ['OXYGEN'] < '96' || $result_seTenkoDataSQ['OXYGEN'] > '100') && ($result_seTenkoDataSQ['OXYGEN'] != '' && $result_seTenkoDataSQ['OXYGEN'] != '0')) {
        $iOXYGENSQIN++;
    }else {
        # code...
    }
    
    $i6++;
    
}

if ($_GET['area'] == 'amata') {
    //COUNT RTD AMT
    $sql_CountRTDAMT = "SELECT COUNT(a.EMPLOYEECODE) AS 'COUNTRTDAMT'
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='04' AND c.SECTIONCODE IN ('01')
    AND a.AREA = 'amata'";
    $query_CountRTDAMT = sqlsrv_query($conn, $sql_CountRTDAMT, $params_CountRTDAMT);
    $result_CountRTDAMT = sqlsrv_fetch_array($query_CountRTDAMT, SQLSRV_FETCH_ASSOC);

    $iSYSRTDAMTNO = 0;
    $iSYSRTDAMTIN = 0;
    $iDIARTDAMTNO = 0;
    $iDIARTDAMTIN = 0;
    $iPULSERTDAMTNO = 0;
    $iPULSERTDAMTIN = 0;
    $iTEMPRTDAMTNO = 0;
    $iTEMPRTDAMTIN = 0;
    $iALCOHOLRTDAMTNO = 0;
    $iALCOHOLRTDAMTIN = 0;
    $iOXYGENRTDAMTNO = 0;
    $iOXYGENRTDAMTIN = 0;
    $i7 =0;
    $sql_seDataRTDAMT = "SELECT a.EMPLOYEECODE 
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='04' AND c.SECTIONCODE IN ('01')
    AND a.AREA = 'amata'";
    $query_seDataRTDAMT = sqlsrv_query($conn, $sql_seDataRTDAMT, $params_seDataRTDAMT);
    while($result_seDataRTDAMT = sqlsrv_fetch_array($query_seDataRTDAMT, SQLSRV_FETCH_ASSOC)){


    $sql_seTenkoDataRTDAMT = "SELECT  TOP 1 TENKOBEFOREID,TENKOMASTERID,TENKOMASTERDIRVERCODE,
        TENKOMASTERDIRVERNAME,TENKOPRESSUREDATA_90160 AS 'SYS',
        TENKOPRESSUREDATA_60100 AS 'DIA',TENKOPRESSUREDATA_60110 AS 'PULSE',
        TENKOTEMPERATUREDATA AS 'TEMP',TENKOALCOHOLDATA AS 'ALCOHOL',
        TENKOOXYGENDATA AS 'OXYGEN'
        FROM [dbo].[TENKOBEFORE] WHERE TENKOMASTERDIRVERCODE ='" . $result_seDataRTDAMT['EMPLOYEECODE'] . "'
        AND TENKOPRESSUREDATA_90160 IS NOT NULL
        AND TENKOPRESSUREDATA_60100 IS NOT NULL
        AND TENKOPRESSUREDATA_60110 IS NOT NULL
        AND TENKOTEMPERATUREDATA IS NOT NULL
        AND TENKOALCOHOLDATA IS NOT NULL
        AND TENKOOXYGENDATA IS NOT NULL
        AND CONVERT(DATETIME,CREATEDATE) BETWEEN CONVERT(DATETIME,'" . $_GET['datestart'] . "',103) 
        AND CONVERT(DATETIME,'" . $_GET['dateend'] . "',103)
        ORDER BY CREATEDATE DESC";
    $query_seTenkoDataRTDAMT  = sqlsrv_query($conn, $sql_seTenkoDataRTDAMT , $params_seTenkoDataRTDAMT);
    $result_seTenkoDataRTDAMT  = sqlsrv_fetch_array($query_seTenkoDataRTDAMT , SQLSRV_FETCH_ASSOC);


    //chk SYS MKPL normal
    if (($result_seTenkoDataRTDAMT['SYS'] >= '90' && $result_seTenkoDataRTDAMT['SYS'] <= '140' ) && ($result_seTenkoDataRTDAMT['SYS'] != '' && $result_seTenkoDataRTDAMT['SYS'] != '0')) {
        $iSYSRTDAMTNO++;
    }else {
        # code...
    }
    //chk SYS MKPL innormal
    if (($result_seTenkoDataRTDAMT['SYS'] < '90' || $result_seTenkoDataRTDAMT['SYS'] > '140') && ($result_seTenkoDataRTDAMT['SYS'] != '' && $result_seTenkoDataRTDAMT['SYS'] != '0')) {
        $iSYSRTDAMTIN++;
    }else {
        # code...
    }
    //////////////////////////////////////////////////////////////////////////////////////
    //chk DIA MKPL normal
    if (($result_seTenkoDataRTDAMT['DIA'] >= '60' && $result_seTenkoDataRTDAMT['DIA'] <= '90') && ($result_seTenkoDataRTDAMT['DIA'] != '' && $result_seTenkoDataRTDAMT['DIA'] != '0')) {
        $iDIARTDAMTNO++;
    }else {
    
    }
    //chk DIA MKPL innormal
    if (($result_seTenkoDataRTDAMT['DIA'] < '60' || $result_seTenkoDataRTDAMT['DIA'] > '90') && ($result_seTenkoDataRTDAMT['DIA'] != '' && $result_seTenkoDataRTDAMT['DIA'] != '0')) {
        $iDIARTDAMTIN++;
    }else {
    
    }
    ////////////////////////////////////////////////////////////////////////////////////   
    //chk PULSE MKPL normal
    if (($result_seTenkoDataRTDAMT['PULSE'] >= '60' && $result_seTenkoDataRTDAMT['PULSE'] <= '100') && ($result_seTenkoDataRTDAMT['PULSE'] != '' && $result_seTenkoDataRTDAMT['PULSE'] != '0')) {
        $iPULSERTDAMTNO++;
    }else {
        # code...
    }
    //chk PULSE MKPL innormal
    if (($result_seTenkoDataRTDAMT['PULSE'] < '60' || $result_seTenkoDataRTDAMT['PULSE'] > '100') && ($result_seTenkoDataRTDAMT['PULSE'] != '' && $result_seTenkoDataRTDAMT['PULSE'] != '0') ) {
        $iPULSERTDAMTIN++;
    }else {
        # code...
    }

    ////////////////////////////////////////////////////////////////////////////////////       
    //chk TEMP MKPL normal
    if ($result_seTenkoDataRTDAMT['TEMP'] < '37' && $result_seTenkoDataRTDAMT['TEMP'] != '') {
        $iTEMPRTDAMTNO++;
    }else {
        # code...
    }
    //chk TEMP MKPL innormal
    if ($result_seTenkoDataRTDAMT['TEMP'] > '37' && $result_seTenkoDataRTDAMT['TEMP'] != '') {
        $iTEMPRTDAMTIN++;
    }else {
        # code...
    }
    ////////////////////////////////////////////////////////////////////////////////////       
    //chk ALCOHOL MKPL normal
    if ($result_seTenkoDataRTDAMT['ALCOHOL'] == '0') {
        $iALCOHOLRTDAMTNO++;
    }else {
        # code...
    }
    //chk ALCOHOL MKPL innormal
    if ($result_seTenkoDataRTDAMT['ALCOHOL'] > '0') {
        $iALCOHOLRTDAMTIN++;
    }else {
        # code...
    }
    ////////////////////////////////////////////////////////////////////////////////////       
    //chk OXYGEN MKPL normal
    if (($result_seTenkoDataRTDAMT['OXYGEN'] >= '96' && $result_seTenkoDataRTDAMT['OXYGEN'] <= '100') && ($result_seTenkoDataRTDAMT['OXYGEN'] != '' && $result_seTenkoDataRTDAMT['OXYGEN'] != '0')) {
        $iOXYGENRTDAMTNO++;
    }else {
        # code...
    }
    //chk OXYGEN MKPL innormal
    if (($result_seTenkoDataRTDAMT['OXYGEN'] < '96' || $result_seTenkoDataRTDAMT['OXYGEN'] > '100') && ($result_seTenkoDataRTDAMT['OXYGEN'] != '' && $result_seTenkoDataRTDAMT['OXYGEN'] != '0')) {
        $iOXYGENRTDAMTIN++;
    }else {
        # code...
    }

    $i7++;

    }
}else {
    //COUNT RTD GW
    $sql_CountRTDGW = "SELECT COUNT(a.EMPLOYEECODE) AS 'COUNTRTDGW'
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='04' AND c.SECTIONCODE IN ('01')
    AND a.AREA = 'gateway'";
    $query_CountRTDGW  = sqlsrv_query($conn, $sql_CountRTDGW , $params_CountRTDGW);
    $result_CountRTDGW  = sqlsrv_fetch_array($query_CountRTDGW , SQLSRV_FETCH_ASSOC);

    $iSYSRTDGWNO = 0;
    $iSYSRTDGWIN = 0;
    $iDIARTDGWNO = 0;
    $iDIARTDGWIN = 0;
    $iPULSERTDGWNO = 0;
    $iPULSERTDGWIN = 0;
    $iTEMPRTDGWNO = 0;
    $iTEMPRTDGWIN = 0;
    $iALCOHOLRTDGWNO = 0;
    $iALCOHOLRTDGWIN = 0;
    $iOXYGENRTDGWNO = 0;
    $iOXYGENRTDGWIN = 0;
    $i10 =0;
    $sql_seDataRTDGW = "SELECT a.EMPLOYEECODE 
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='04' AND c.SECTIONCODE IN ('01')
    AND a.AREA ='gateway'";
    $query_seDataRTDGW = sqlsrv_query($conn, $sql_seDataRTDGW, $params_seDataRTDGW);
    while($result_seDataRTDGW = sqlsrv_fetch_array($query_seDataRTDGW, SQLSRV_FETCH_ASSOC)){


    $sql_seTenkoDataRTDGW = "SELECT  TOP 1 TENKOBEFOREID,TENKOMASTERID,TENKOMASTERDIRVERCODE,
        TENKOMASTERDIRVERNAME,TENKOPRESSUREDATA_90160 AS 'SYS',
        TENKOPRESSUREDATA_60100 AS 'DIA',TENKOPRESSUREDATA_60110 AS 'PULSE',
        TENKOTEMPERATUREDATA AS 'TEMP',TENKOALCOHOLDATA AS 'ALCOHOL',
        TENKOOXYGENDATA AS 'OXYGEN'
        FROM [dbo].[TENKOBEFORE] WHERE TENKOMASTERDIRVERCODE ='" . $result_seDataRTDGW['EMPLOYEECODE'] . "'
        AND TENKOPRESSUREDATA_90160 IS NOT NULL
        AND TENKOPRESSUREDATA_60100 IS NOT NULL
        AND TENKOPRESSUREDATA_60110 IS NOT NULL
        AND TENKOTEMPERATUREDATA IS NOT NULL
        AND TENKOALCOHOLDATA IS NOT NULL
        AND TENKOOXYGENDATA IS NOT NULL
        AND CONVERT(DATETIME,CREATEDATE) BETWEEN CONVERT(DATETIME,'" . $_GET['datestart'] . "',103) 
        AND CONVERT(DATETIME,'" . $_GET['dateend'] . "',103)
        ORDER BY CREATEDATE DESC";
    $query_seTenkoDataRTDGW  = sqlsrv_query($conn, $sql_seTenkoDataRTDGW , $params_seTenkoDataRTDGW);
    $result_seTenkoDataRTDGW  = sqlsrv_fetch_array($query_seTenkoDataRTDGW , SQLSRV_FETCH_ASSOC);


    //chk SYS MKPL normal
    if (($result_seTenkoDataRTDGW['SYS'] >= '90' && $result_seTenkoDataRTDGW['SYS'] <= '140' ) && ($result_seTenkoDataRTDGW['SYS'] != '' && $result_seTenkoDataRTDGW['SYS'] != '0')) {
        $iSYSRTDGWNO++;
    }else {
        # code...
    }
    //chk SYS MKPL innormal
    if (($result_seTenkoDataRTDGW['SYS'] < '90' || $result_seTenkoDataRTDGW['SYS'] > '140') && ($result_seTenkoDataRTDGW['SYS'] != '' && $result_seTenkoDataRTDGW['SYS'] != '0')) {
        $iSYSRTDGWIN++;
    }else {
        # code...
    }
    //////////////////////////////////////////////////////////////////////////////////////
    //chk DIA MKPL normal
    if (($result_seTenkoDataRTDGW['DIA'] >= '60' && $result_seTenkoDataRTDGW['DIA'] <= '90') && ($result_seTenkoDataRTDGW['DIA'] != '' && $result_seTenkoDataRTDGW['DIA'] != '0')) {
        $iDIARTDGWNO++;
    }else {
    
    }
    //chk DIA MKPL innormal
    if (($result_seTenkoDataRTDGW['DIA'] < '60' || $result_seTenkoDataRTDGW['DIA'] > '90') && ($result_seTenkoDataRTDGW['DIA'] != '' && $result_seTenkoDataRTDGW['DIA'] != '0')) {
        $iDIARTDGWIN++;
    }else {
    
    }
    ////////////////////////////////////////////////////////////////////////////////////   
    //chk PULSE MKPL normal
    if (($result_seTenkoDataRTDGW['PULSE'] >= '60' && $result_seTenkoDataRTDGW['PULSE'] <= '100') && ($result_seTenkoDataRTDGW['PULSE'] != '' && $result_seTenkoDataRTDGW['PULSE'] != '0')) {
        $iPULSERTDGWNO++;
    }else {
        # code...
    }
    //chk PULSE MKPL innormal
    if (($result_seTenkoDataRTDGW['PULSE'] < '60' || $result_seTenkoDataRTDGW['PULSE'] > '100') && ($result_seTenkoDataRTDGW['PULSE'] != '' && $result_seTenkoDataRTDGW['PULSE'] != '0') ) {
        $iPULSERTDGWIN++;
    }else {
        # code...
    }

    ////////////////////////////////////////////////////////////////////////////////////       
    //chk TEMP MKPL normal
    if ($result_seTenkoDataRTDGW['TEMP'] < '37' && $result_seTenkoDataRTDGW['TEMP'] != '') {
        $iTEMPRTDGWNO++;
    }else {
        # code...
    }
    //chk TEMP MKPL innormal
    if ($result_seTenkoDataRTDGW['TEMP'] > '37' && $result_seTenkoDataRTDGW['TEMP'] != '') {
        $iTEMPRTDGWIN++;
    }else {
        # code...
    }
    ////////////////////////////////////////////////////////////////////////////////////       
    //chk ALCOHOL MKPL normal
    if ($result_seTenkoDataRTDGW['ALCOHOL'] == '0') {
        $iALCOHOLRTDGWNO++;
    }else {
        # code...
    }
    //chk ALCOHOL MKPL innormal
    if ($result_seTenkoDataRTDGW['ALCOHOL'] > '0') {
        $iALCOHOLRTDGWIN++;
    }else {
        # code...
    }
    ////////////////////////////////////////////////////////////////////////////////////       
    //chk OXYGEN MKPL normal
    if (($result_seTenkoDataRTDGW['OXYGEN'] >= '96' && $result_seTenkoDataRTDGW['OXYGEN'] <= '100') && ($result_seTenkoDataRTDGW['OXYGEN'] != '' && $result_seTenkoDataRTDGW['OXYGEN'] != '0')) {
        $iOXYGENRTDGWNO++;
    }else {
        # code...
    }
    //chk OXYGEN MKPL innormal
    if (($result_seTenkoDataRTDGW['OXYGEN'] < '96' || $result_seTenkoDataRTDGW['OXYGEN'] > '100') && ($result_seTenkoDataRTDGW['OXYGEN'] != '' && $result_seTenkoDataRTDGW['OXYGEN'] != '0')) {
        $iOXYGENRTDGWIN++;
    }else {
        # code...
    }

    $i10++;

    }
}



//COUNT RTC
$sql_CountRTC = "SELECT COUNT(a.EMPLOYEECODE) AS 'COUNTRTC'
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='04' AND c.SECTIONCODE IN ('03')
    AND a.AREA = '".$_GET['area']."'";
$query_CountRTC = sqlsrv_query($conn, $sql_CountRTC, $params_CountRTC);
$result_CountRTC = sqlsrv_fetch_array($query_CountRTC, SQLSRV_FETCH_ASSOC);

$iSYSRTCNO = 0;
$iSYSRTCIN = 0;
$iDIARTCNO = 0;
$iDIARTCIN = 0;
$iPULSERTCNO = 0;
$iPULSERTCIN = 0;
$iTEMPRTCNO = 0;
$iTEMPRTCIN = 0;
$iALCOHOLRTCNO = 0;
$iALCOHOLRTCIN = 0;
$iOXYGENRTCNO = 0;
$iOXYGENRTCIN = 0;
$i8 =0;
$sql_seDataRTC = "SELECT a.EMPLOYEECODE 
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='04' AND c.SECTIONCODE IN ('03')
    AND a.AREA = '".$_GET['area']."'";
$query_seDataRTC = sqlsrv_query($conn, $sql_seDataRTC, $params_seDataRTC);
while($result_seDataRTC = sqlsrv_fetch_array($query_seDataRTC, SQLSRV_FETCH_ASSOC)){


$sql_seTenkoDataRTC = "SELECT  TOP 1 TENKOBEFOREID,TENKOMASTERID,TENKOMASTERDIRVERCODE,
        TENKOMASTERDIRVERNAME,TENKOPRESSUREDATA_90160 AS 'SYS',
        TENKOPRESSUREDATA_60100 AS 'DIA',TENKOPRESSUREDATA_60110 AS 'PULSE',
        TENKOTEMPERATUREDATA AS 'TEMP',TENKOALCOHOLDATA AS 'ALCOHOL',
        TENKOOXYGENDATA AS 'OXYGEN'
        FROM [dbo].[TENKOBEFORE] WHERE TENKOMASTERDIRVERCODE ='" . $result_seDataRTC['EMPLOYEECODE'] . "'
        AND TENKOPRESSUREDATA_90160 IS NOT NULL
        AND TENKOPRESSUREDATA_60100 IS NOT NULL
        AND TENKOPRESSUREDATA_60110 IS NOT NULL
        AND TENKOTEMPERATUREDATA IS NOT NULL
        AND TENKOALCOHOLDATA IS NOT NULL
        AND TENKOOXYGENDATA IS NOT NULL
        AND CONVERT(DATETIME,CREATEDATE) BETWEEN CONVERT(DATETIME,'" . $_GET['datestart'] . "',103) 
        AND CONVERT(DATETIME,'" . $_GET['dateend'] . "',103)
        ORDER BY CREATEDATE DESC";
$query_seTenkoDataRTC  = sqlsrv_query($conn, $sql_seTenkoDataRTC, $params_seTenkoDataRTC);
$result_seTenkoDataRTC  = sqlsrv_fetch_array($query_seTenkoDataRTC , SQLSRV_FETCH_ASSOC);
    
    
    //chk SYS MKPL normal
    if (($result_seTenkoDataRTC['SYS'] >= '90' && $result_seTenkoDataRTC['SYS'] <= '140' ) && ($result_seTenkoDataRTC['SYS'] != '' && $result_seTenkoDataRTC['SYS'] != '0')) {
        $iSYSRTCNO++;
    }else {
        # code...
    }
    //chk SYS MKPL innormal
    if (($result_seTenkoDataRTC['SYS'] < '90' || $result_seTenkoDataRTC['SYS'] > '140') && ($result_seTenkoDataRTC['SYS'] != '' && $result_seTenkoDataRTC['SYS'] != '0')) {
        $iSYSRTCIN++;
    }else {
        # code...
    }
//////////////////////////////////////////////////////////////////////////////////////
    //chk DIA MKPL normal
    if (($result_seTenkoDataRTC['DIA'] >= '60' && $result_seTenkoDataRTC['DIA'] <= '90') && ($result_seTenkoDataRTC['DIA'] != '' && $result_seTenkoDataRTC['DIA'] != '0')) {
        $iDIARTCNO++;
    }else {
     
    }
    //chk DIA MKPL innormal
    if (($result_seTenkoDataRTC['DIA'] < '60' || $result_seTenkoDataRTC['DIA'] > '90') && ($result_seTenkoDataRTC['DIA'] != '' && $result_seTenkoDataRTC['DIA'] != '0')) {
        $iDIARTCIN++;
    }else {
     
    }
////////////////////////////////////////////////////////////////////////////////////   
    //chk PULSE MKPL normal
    if (($result_seTenkoDataRTC['PULSE'] >= '60' && $result_seTenkoDataRTC['PULSE'] <= '100') && ($result_seTenkoDataRTC['PULSE'] != '' && $result_seTenkoDataRTC['PULSE'] != '0')) {
        $iPULSERTCNO++;
    }else {
        # code...
    }
     //chk PULSE MKPL innormal
     if (($result_seTenkoDataRTC['PULSE'] < '60' || $result_seTenkoDataRTC['PULSE'] > '100') && ($result_seTenkoDataRTC['PULSE'] != '' && $result_seTenkoDataRTC['PULSE'] != '0') ) {
        $iPULSERTCIN++;
    }else {
        # code...
    }

////////////////////////////////////////////////////////////////////////////////////       
    //chk TEMP MKPL normal
    if ($result_seTenkoDataRTC['TEMP'] < '37' && $result_seTenkoDataRTC['TEMP'] != '') {
        $iTEMPRTCNO++;
    }else {
        # code...
    }
    //chk TEMP MKPL innormal
    if ($result_seTenkoDataRTC['TEMP'] > '37' && $result_seTenkoDataRTC['TEMP'] != '') {
        $iTEMPRTCIN++;
    }else {
        # code...
    }
////////////////////////////////////////////////////////////////////////////////////       
    //chk ALCOHOL MKPL normal
    if ($result_seTenkoDataRTC['ALCOHOL'] == '0') {
        $iALCOHOLRTCNO++;
    }else {
        # code...
    }
    //chk ALCOHOL MKPL innormal
    if ($result_seTenkoDataRTC['ALCOHOL'] > '0') {
        $iALCOHOLRTCIN++;
    }else {
        # code...
    }
////////////////////////////////////////////////////////////////////////////////////       
    //chk OXYGEN MKPL normal
    if (($result_seTenkoDataRTC['OXYGEN'] >= '96' && $result_seTenkoDataRTC['OXYGEN'] <= '100') && ($result_seTenkoDataRTC['OXYGEN'] != '' && $result_seTenkoDataRTC['OXYGEN'] != '0')) {
        $iOXYGENRTCNO++;
    }else {
        # code...
    }
    //chk OXYGEN MKPL innormal
    if (($result_seTenkoDataRTC['OXYGEN'] < '96' || $result_seTenkoDataRTC['OXYGEN'] > '100') && ($result_seTenkoDataRTC['OXYGEN'] != '' && $result_seTenkoDataRTC['OXYGEN'] != '0')) {
        $iOXYGENRTCIN++;
    }else {
        # code...
    }
    
    $i8++;
    
}
//COUNT RIT
$sql_CountRIT = "SELECT COUNT(a.EMPLOYEECODE) AS 'COUNTRIT'
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='04' AND c.SECTIONCODE IN ('02')
    AND a.AREA = '".$_GET['area']."'";
$query_CountRIT = sqlsrv_query($conn, $sql_CountRIT, $params_CountRIT);
$result_CountRIT = sqlsrv_fetch_array($query_CountRIT, SQLSRV_FETCH_ASSOC);

$iSYSRITNO = 0;
$iSYSRITIN = 0;
$iDIARITNO = 0;
$iDIARITIN  = 0;
$iPULSERITNO = 0;
$iPULSERITIN  = 0;
$iTEMPRITNO = 0;
$iTEMPRITIN  = 0;
$iALCOHOLRITNO = 0;
$iALCOHOLRITIN  = 0;
$iOXYGENRITNO = 0;
$iOXYGENRITIN  = 0;
$i9 =0;
$sql_seDataRIT = "SELECT a.EMPLOYEECODE 
    FROM [dbo].[ORGANIZATION] a 
    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
    WHERE b.DEPARTMENTCODE ='04' AND c.SECTIONCODE IN ('02')
    AND a.AREA = '".$_GET['area']."'";
$query_seDataRIT = sqlsrv_query($conn, $sql_seDataRIT, $params_seDataRIT);
while($result_seDataRIT = sqlsrv_fetch_array($query_seDataRIT, SQLSRV_FETCH_ASSOC)){


$sql_seTenkoDataRIT = "SELECT  TOP 1 TENKOBEFOREID,TENKOMASTERID,TENKOMASTERDIRVERCODE,
        TENKOMASTERDIRVERNAME,TENKOPRESSUREDATA_90160 AS 'SYS',
        TENKOPRESSUREDATA_60100 AS 'DIA',TENKOPRESSUREDATA_60110 AS 'PULSE',
        TENKOTEMPERATUREDATA AS 'TEMP',TENKOALCOHOLDATA AS 'ALCOHOL',
        TENKOOXYGENDATA AS 'OXYGEN'
        FROM [dbo].[TENKOBEFORE] WHERE TENKOMASTERDIRVERCODE ='" . $result_seDataRIT['EMPLOYEECODE'] . "'
        AND TENKOPRESSUREDATA_90160 IS NOT NULL
        AND TENKOPRESSUREDATA_60100 IS NOT NULL
        AND TENKOPRESSUREDATA_60110 IS NOT NULL
        AND TENKOTEMPERATUREDATA IS NOT NULL
        AND TENKOALCOHOLDATA IS NOT NULL
        AND TENKOOXYGENDATA IS NOT NULL
        AND CONVERT(DATETIME,CREATEDATE) BETWEEN CONVERT(DATETIME,'" . $_GET['datestart'] . "',103) 
        AND CONVERT(DATETIME,'" . $_GET['dateend'] . "',103)
        ORDER BY CREATEDATE DESC";
$query_seTenkoDataRIT  = sqlsrv_query($conn, $sql_seTenkoDataRIT, $params_seTenkoDataRIT);
$result_seTenkoDataRIT  = sqlsrv_fetch_array($query_seTenkoDataRIT , SQLSRV_FETCH_ASSOC);
    
    
    //chk SYS MKPL normal
    if (($result_seTenkoDataRIT['SYS'] >= '90' && $result_seTenkoDataRIT['SYS'] <= '140' ) && ($result_seTenkoDataRIT['SYS'] != '' && $result_seTenkoDataRIT['SYS'] != '0')) {
        $iSYSRITNO++;
    }else {
        # code...
    }
    //chk SYS MKPL innormal
    if (($result_seTenkoDataRIT['SYS'] < '90' || $result_seTenkoDataRIT['SYS'] > '140') && ($result_seTenkoDataRIT['SYS'] != '' && $result_seTenkoDataRIT['SYS'] != '0')) {
        $iSYSRITIN++;
    }else {
        # code...
    }
//////////////////////////////////////////////////////////////////////////////////////
    //chk DIA MKPL normal
    if (($result_seTenkoDataRIT['DIA'] >= '60' && $result_seTenkoDataRIT['DIA'] <= '90') && ($result_seTenkoDataRIT['DIA'] != '' && $result_seTenkoDataRIT['DIA'] != '0')) {
        $iDIARITNO++;
    }else {
     
    }
    //chk DIA MKPL innormal
    if (($result_seTenkoDataRIT['DIA'] < '60' || $result_seTenkoDataRIT['DIA'] > '90') && ($result_seTenkoDataRIT['DIA'] != '' && $result_seTenkoDataRIT['DIA'] != '0')) {
        $iDIARITIN++;
    }else {
     
    }
////////////////////////////////////////////////////////////////////////////////////   
    //chk PULSE MKPL normal
    if (($result_seTenkoDataRIT['PULSE'] >= '60' && $result_seTenkoDataRIT['PULSE'] <= '100') && ($result_seTenkoDataRIT['PULSE'] != '' && $result_seTenkoDataRIT['PULSE'] != '0')) {
        $iPULSERITNO++;
    }else {
        # code...
    }
     //chk PULSE MKPL innormal
     if (($result_seTenkoDataRIT['PULSE'] < '60' || $result_seTenkoDataRIT['PULSE'] > '100') && ($result_seTenkoDataRIT['PULSE'] != '' && $result_seTenkoDataRIT['PULSE'] != '0') ) {
        $iPULSERITIN++;
    }else {
        # code...
    }

////////////////////////////////////////////////////////////////////////////////////       
    //chk TEMP MKPL normal
    if ($result_seTenkoDataRIT['TEMP'] < '37' && $result_seTenkoDataRIT['TEMP'] != '') {
        $iTEMPRITNO++;
    }else {
        # code...
    }
    //chk TEMP MKPL innormal
    if ($result_seTenkoDataRIT['TEMP'] > '37' && $result_seTenkoDataRIT['TEMP'] != '') {
        $iTEMPRITIN++;
    }else {
        # code...
    }
////////////////////////////////////////////////////////////////////////////////////       
    //chk ALCOHOL MKPL normal
    if ($result_seTenkoDataRIT['ALCOHOL'] == '0') {
        $iALCOHOLRITNO++;
    }else {
        # code...
    }
    //chk ALCOHOL MKPL innormal
    if ($result_seTenkoDataRIT['ALCOHOL'] > '0') {
        $iALCOHOLRITIN++;
    }else {
        # code...
    }
////////////////////////////////////////////////////////////////////////////////////       
    //chk OXYGEN MKPL normal
    if (($result_seTenkoDataRIT['OXYGEN'] >= '96' && $result_seTenkoDataRIT['OXYGEN'] <= '100') && ($result_seTenkoDataRIT['OXYGEN'] != '' && $result_seTenkoDataRIT['OXYGEN'] != '0')) {
        $iOXYGENRITNO++;
    }else {
        # code...
    }
    //chk OXYGEN MKPL innormal
    if (($result_seTenkoDataRIT['OXYGEN'] < '96' || $result_seTenkoDataRIT['OXYGEN'] > '100') && ($result_seTenkoDataRIT['OXYGEN'] != '' && $result_seTenkoDataRIT['OXYGEN'] != '0')) {
        $iOXYGENRITIN++;
    }else {
        # code...
    }
    
    $i8++;
    
}

    $sql_seTenkoData = "SELECT TOP 1 TENKOBEFOREID,TENKOMASTERID,TENKOMASTERDIRVERCODE,
                TENKOMASTERDIRVERNAME,TENKOPRESSUREDATA_90160 AS 'SYS',
                TENKOPRESSUREDATA_60100 AS 'DIA',TENKOPRESSUREDATA_60110 AS 'PULSE',
                TENKOTEMPERATUREDATA AS 'TEMP',TENKOALCOHOLDATA AS 'ALCOHOL',
                TENKOOXYGENDATA AS 'OXYGEN'
                FROM [dbo].[TENKOBEFORE] WHERE TENKOMASTERDIRVERCODE ='" . $result_sePlan['EMPLOYEECODE'] . "'
                AND CONVERT(DATETIME,CREATEDATE) BETWEEN CONVERT(DATETIME,'" . $_GET['datestart'] . "',103)  
                AND CONVERT(DATETIME,'" . $_GET['dateend'] . "',103)
                ORDER BY CREATEDATE DESC";
    $query_seTenkoData = sqlsrv_query($conn, $sql_seTenkoData, $params_seTenkoData);
    $result_seTenkoData = sqlsrv_fetch_array($query_seTenkoData, SQLSRV_FETCH_ASSOC);

    if ( $result_seTenkoData['SYS'] > '140' && $result_seTenkoData['SYS'] !='') {
            $bloodpressure = 'ความดันสูงกว่าปกติวัดค่าได้'."".$result_seTenkoData['SYS'];
    }else {
        if ($result_seTenkoData['DIA'] > '90' && $result_seTenkoData['DIA'] !='') {
            $bloodpressure = 'ความดันต่ำกว่าปกติวัดค่าได้'."".$result_seTenkoData['DIA'];
        }else {
            
        }
    
    } 


   

    
    ?>


            <!-- ACC Section  -->
            <tr style="border:1px solid #000;" >
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">1</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;">ACC.</td>
                <!-- <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_CountACC['COUNTACC']?></td> -->
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iSYSACCNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iSYSACCIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iDIAACCNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iDIAACCIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iPULSEACCNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iPULSEACCIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iTEMPACCNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iTEMPACCIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iALCOHOLACCNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iALCOHOLACCIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iOXYGENACCNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iOXYGENACCIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;"></td>
            </tr>
            <!-- Admin Section  -->
            <tr style="border:1px solid #000;" >
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">2</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;" >Admin.</td>
                <!-- <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_CountADMIN['COUNTADMIN']?></td> -->
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66" ><?=$iSYSADMINNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966" ><?=$iSYSADMININ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66" ><?=$iDIAADMINNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966" ><?=$iDIAADMININ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66" ><?=$iPULSEADMINNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966" ><?=$iPULSEADMININ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iTEMPADMINNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iTEMPADMININ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iALCOHOLADMINNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iALCOHOLADMININ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iOXYGENADMINNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iOXYGENADMININ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;"></td>
            </tr>
            <!-- Corp Section  -->
            <tr style="border:1px solid #000;" >
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">3</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;" >Corp.</td>
                <!-- <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_CountCORP['COUNTCORP']?></td> -->
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66" ><?=$iSYSCORPNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966" ><?=$iSYSCORPIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66" ><?=$iDIACORPNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966" ><?=$iDIACORPIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66" ><?=$iPULSECORPNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966" ><?=$iPULSECORPIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iTEMPCORPNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iTEMPCORPIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iALCOHOLCORPNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iALCOHOLCORPIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iOXYGENCORPNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iOXYGENCORPIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;"></td>
            </tr>
            <!-- CRM Section  -->
            <tr style="border:1px solid #000;" >
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">4</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;" >CRM.</td>
                <!-- <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_CountCRM['COUNTCRM']?></td> -->
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66" ><?=$iSYSCRMNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966" ><?=$iSYSCRMIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66" ><?=$iDIACRMNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966" ><?=$iDIACRMIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66" ><?=$iPULSECRMNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966" ><?=$iPULSECRMIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iTEMPCRMNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iTEMPCRMIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iALCOHOLCRMNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iALCOHOLCRMIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iOXYGENCRMNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iOXYGENCRMIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;"></td>
            </tr>
            <!-- MK/PL Section  -->
            <tr style="border:1px solid #000;" >
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">5</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;">MK/PL.</td>
                <!-- <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_CountMKPL['COUNTMKPL']?></td> -->
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iSYSMKPLNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iSYSMKPLIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iDIAMKPLNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iDIAMKPLIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iPULSEMKPLNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iPULSEMKPLIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iTEMPMKPLNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iTEMPMKPLIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iALCOHOLMKPLNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iALCOHOLMKPLIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iOXYGENMKPLNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iOXYGENMKPLIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;"></td>
            </tr>
            <!-- SQ Section  -->
            <tr style="border:1px solid #000;" >
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">6</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;" >SQ.</td>
                <!-- <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_CountSQ['COUNTSQ']?></td> -->
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iSYSSQNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iSYSSQIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iDIASQNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iDIASQIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iPULSESQNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iPULSESQIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iTEMPSQNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iTEMPSQIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iALCOHOLSQNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iALCOHOLSQIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iOXYGENSQNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iOXYGENSQIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;"></td>
            </tr>
            <?php
            if($_GET['area'] == 'amata'){
            ?>
            <!-- RTD AMT Section  -->
            <tr style="border:1px solid #000;" >
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">7</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;" >RTD.</td>
                <!-- <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_CountRTDAMT['COUNTRTDAMT']?></td> -->
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iSYSRTDAMTNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iSYSRTDAMTIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iDIARTDAMTNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iDIARTDAMTIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iPULSERTDAMTNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iPULSERTDAMTIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iTEMPRTDAMTNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iTEMPRTDAMTIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iALCOHOLRTDAMTNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iALCOHOLRTDAMTIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iOXYGENRTDAMTNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iOXYGENRTDAMTIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;"></td>
            </tr>
            <!-- RTC Section  -->
            <tr style="border:1px solid #000;" >
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">8</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;">RTC.</td>
                <!-- <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_CountRTC['COUNTRTC']?></td> -->
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iSYSRTCNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iSYSRTCIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iDIARTCNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iDIARTCIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iPULSERTCNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iPULSERTCIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iTEMPRTCNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iTEMPRTCIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iALCOHOLRTCNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iALCOHOLRTCIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iOXYGENRTCNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iOXYGENRTCIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;"></td>
            </tr>
            <!-- RIT Section  -->
            <tr style="border:1px solid #000;" >
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">9</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;" >RIT.</td>
                <!-- <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_CountRIT['COUNTRIT']?></td> -->
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iSYSRITNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iSYSRITIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iDIARITNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iDIARITIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iPULSERITNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iPULSERITIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iTEMPRITNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iTEMPRITIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iALCOHOLRITNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iALCOHOLRITIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iOXYGENRITNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iOXYGENRITIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;"></td>
        
            </tr>
            <?php
            }else {
            ?>
             <!-- RTD GW Section  -->
            <tr style="border:1px solid #000;" >
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">7</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;">RTD(GW).</td>
                <!-- <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_CountRTDAMT['COUNTRTDGW']?></td> -->
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iSYSRTDGWNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iSYSRTDGWIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iDIARTDGWNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iDIARTDGWIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iPULSERTDGWNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iPULSERTDGWIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iTEMPRTDGWNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iTEMPRTDGWIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iALCOHOLRTDGWNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iALCOHOLRTDGWIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iOXYGENRTDGWNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iOXYGENRTDGWIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;"></td>
            </tr>   
            <!-- RTC Section  -->
            <tr style="border:1px solid #000;" >
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">8</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;">RTC.</td>
                <!-- <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_CountRTC['COUNTRTC']?></td> -->
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iSYSRTCNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iSYSRTCIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iDIARTCNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iDIARTCIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iPULSERTCNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iPULSERTCIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iTEMPRTCNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iTEMPRTCIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iALCOHOLRTCNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iALCOHOLRTCIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iOXYGENRTCNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iOXYGENRTCIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;"></td>
            </tr>
            <!-- RIT Section  -->
            <tr style="border:1px solid #000;" >
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">9</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;" >RIT.</td>
                <!-- <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?=$result_CountRIT['COUNTRIT']?></td> -->
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iSYSRITNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iSYSRITIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iDIARITNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iDIARITIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iPULSERITNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iPULSERITIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iTEMPRITNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iTEMPRITIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iALCOHOLRITNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iALCOHOLRITIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #33CC66"><?=$iOXYGENRITNO?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;background-color: #FF9966"><?=$iOXYGENRITIN?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;"></td>
        
            </tr>
            
            <?php
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
