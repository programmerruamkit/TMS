<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
require("../PHPMailer-5.1.0/class.phpmailer.php");

$sql_getDate = "{call megGetdate_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$strExcelFileName = "Report".$result_getDate['GETDATE']."_ARTC.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");
?>
<style>
    input.largerCheckbox {
        width: 20px;
        height: 20px;
    }
</style>

<!-- ////////////////////////////////////////////////10W/STC///////////////////////////////////////////////// -->

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <br>
        <table   style="border-collapse: collapse;margin-top:8px;font-size:10px" width="100%"  >
            <thead>
                <tr>

                    <th colspan="7" style="border-top:1px solid #000;font-size:14px;border:1px solid #000;padding:6px;text-align:center">
                        <b>สรุปรายงานตัวปฎิบัติงานวันที่ <?= $result_getDate['GETDATE'] ?> - <?= $result_getDate['GETDATE'] ?> (Affiliate Business)(Ruamkit Rungrueng Traning Center)</b> 

                    </th>

                </tr>
               <tr>

                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" rowspan="2" >ลำดับ</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" rowspan="2" >แผนก</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" colspan="5" >รายการ</th>



                </tr>
                <tr>

                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center">ทั้งหมด</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center">สมบูรณ์</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center">จังหวัดไม่ตรง</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center">เวลาไม่ตรง</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center">ยังไม่รายงานตัว</th>

                </tr>


            </thead>
            <tbody>
               <?php
             
               

                    

                    $sql_seSumary1 = " SELECT COUNT(*) AS 'CNT' FROM (
SELECT DISTINCT c.FnameT+' '+c.LnameT AS 'FLnameT' FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE 1=1
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '01' AND b.[SECTIONCODE] = '02' AND b.AREA = 'amata'
) AS A";
                    $query_seSumary1 = sqlsrv_query($conn, $sql_seSumary1, $params_seSumary1);
                    $result_seSumary1 = sqlsrv_fetch_array($query_seSumary1, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumary2 = " SELECT COUNT(*) AS 'CNT' FROM (
SELECT DISTINCT c.FnameT+' '+c.LnameT AS 'FLnameT' FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE 1=1
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '01' AND b.[SECTIONCODE] = '01' AND b.AREA = 'amata'
) AS A";
                    $query_seSumary2 = sqlsrv_query($conn, $sql_seSumary2, $params_seSumary2);
                    $result_seSumary2 = sqlsrv_fetch_array($query_seSumary2, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumary3 = " SELECT COUNT(*) AS 'CNT' FROM (
SELECT DISTINCT c.FnameT+' '+c.LnameT AS 'FLnameT' FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE 1=1
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '03' AND b.[SECTIONCODE] = '01' AND b.AREA = 'amata'
) AS A";
                    $query_seSumary3 = sqlsrv_query($conn, $sql_seSumary3, $params_seSumary3);
                    $result_seSumary3 = sqlsrv_fetch_array($query_seSumary3, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumary4 = " SELECT COUNT(*) AS 'CNT' FROM (
SELECT DISTINCT c.FnameT+' '+c.LnameT AS 'FLnameT' FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE 1=1
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '04' AND b.[SECTIONCODE] = '01' AND b.AREA = 'amata'
) AS A";
                    $query_seSumary4 = sqlsrv_query($conn, $sql_seSumary4, $params_seSumary4);
                    $result_seSumary4 = sqlsrv_fetch_array($query_seSumary4, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumary5 = " SELECT COUNT(*) AS 'CNT' FROM (
SELECT DISTINCT c.FnameT+' '+c.LnameT AS 'FLnameT' FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE 1=1
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '02' AND b.[SECTIONCODE] = '01' AND b.AREA = 'amata'
) AS A";
                    $query_seSumary5 = sqlsrv_query($conn, $sql_seSumary5, $params_seSumary5);
                    $result_seSumary5 = sqlsrv_fetch_array($query_seSumary5, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumary6 = " SELECT COUNT(*) AS 'CNT' FROM (
SELECT DISTINCT c.FnameT+' '+c.LnameT AS 'FLnameT' FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE 1=1
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '02' AND b.[SECTIONCODE] = '02' AND b.AREA = 'amata'
) AS A";
                    $query_seSumary6 = sqlsrv_query($conn, $sql_seSumary6, $params_seSumary6);
                    $result_seSumary6 = sqlsrv_fetch_array($query_seSumary6, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumary7 = " SELECT COUNT(*) AS 'CNT' FROM (
SELECT DISTINCT c.FnameT+' '+c.LnameT AS 'FLnameT' FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE 1=1
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '03' AND b.[SECTIONCODE] = '02' AND b.AREA = 'amata'
) AS A";
                    $query_seSumary7 = sqlsrv_query($conn, $sql_seSumary7, $params_seSumary7);
                    $result_seSumary7 = sqlsrv_fetch_array($query_seSumary7, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumary8 = " SELECT COUNT(*) AS 'CNT' FROM (
SELECT DISTINCT c.FnameT+' '+c.LnameT AS 'FLnameT' FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE 1=1
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '04' AND b.[SECTIONCODE] = '02' AND b.AREA = 'amata'
) AS A";
                    $query_seSumary8 = sqlsrv_query($conn, $sql_seSumary8, $params_seSumary8);
                    $result_seSumary8 = sqlsrv_fetch_array($query_seSumary8, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumary9 = " SELECT COUNT(*) AS 'CNT' FROM (
SELECT DISTINCT c.FnameT+' '+c.LnameT AS 'FLnameT' FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE 1=1
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '04' AND b.[SECTIONCODE] = '03' AND b.AREA = 'amata'
) AS A";
                    $query_seSumary9 = sqlsrv_query($conn, $sql_seSumary9, $params_seSumary9);
                    $result_seSumary9 = sqlsrv_fetch_array($query_seSumary9, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seSumary10 = " SELECT COUNT(*) AS 'CNT' FROM (
SELECT DISTINCT c.FnameT+' '+c.LnameT AS 'FLnameT' FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE 1=1
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '03' AND b.[SECTIONCODE] = '03' AND b.AREA = 'amata'
) AS A";
                    $query_seSumary10 = sqlsrv_query($conn, $sql_seSumary10, $params_seSumary10);
                    $result_seSumary10 = sqlsrv_fetch_array($query_seSumary10, SQLSRV_FETCH_ASSOC);
                    
                    
                    
                    $sql_seSumarysus1 = "SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '0'
                        
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '01' AND b.[SECTIONCODE] = '02' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarysus1 = sqlsrv_query($conn, $sql_seSumarysus1, $params_seSumarysus1);
                    $result_seSumarysus1 = sqlsrv_fetch_array($query_seSumarysus1, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumarysus2 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '0'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '01' AND b.[SECTIONCODE] = '01' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarysus2 = sqlsrv_query($conn, $sql_seSumarysus2, $params_seSumarysus2);
                    $result_seSumarysus2 = sqlsrv_fetch_array($query_seSumarysus2, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumarysus3 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '0'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '03' AND b.[SECTIONCODE] = '01' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarysus3 = sqlsrv_query($conn, $sql_seSumarysus3, $params_seSumarysus3);
                    $result_seSumarysus3 = sqlsrv_fetch_array($query_seSumarysus3, SQLSRV_FETCH_ASSOC);
                    
                                         $sql_seSumarysus4 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '0'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '04' AND b.[SECTIONCODE] = '01' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarysus4 = sqlsrv_query($conn, $sql_seSumarysus4, $params_seSumarysus4);
                    $result_seSumarysus4 = sqlsrv_fetch_array($query_seSumarysus4, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumarysus5 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '0'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '02' AND b.[SECTIONCODE] = '01' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarysus5 = sqlsrv_query($conn, $sql_seSumarysus5, $params_seSumarysus5);
                    $result_seSumarysus5 = sqlsrv_fetch_array($query_seSumarysus5, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumarysus6 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '0'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '02' AND b.[SECTIONCODE] = '02' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarysus6 = sqlsrv_query($conn, $sql_seSumarysus6, $params_seSumarysus6);
                    $result_seSumarysus6 = sqlsrv_fetch_array($query_seSumarysus6, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumarysus7 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '0'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '03' AND b.[SECTIONCODE] = '02' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarysus7 = sqlsrv_query($conn, $sql_seSumarysus7, $params_seSumarysus7);
                    $result_seSumarysus7 = sqlsrv_fetch_array($query_seSumarysus7, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumarysus8 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '0'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '04' AND b.[SECTIONCODE] = '02' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarysus8 = sqlsrv_query($conn, $sql_seSumarysus8, $params_seSumarysus8);
                    $result_seSumarysus8 = sqlsrv_fetch_array($query_seSumarysus8, SQLSRV_FETCH_ASSOC);
                    
                                         $sql_seSumarysus9 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '0'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '04' AND b.[SECTIONCODE] = '03' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarysus9 = sqlsrv_query($conn, $sql_seSumarysus9, $params_seSumarysus9);
                    $result_seSumarysus9 = sqlsrv_fetch_array($query_seSumarysus9, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seSumarysus10 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '0'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '03' AND b.[SECTIONCODE] = '03' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarysus10 = sqlsrv_query($conn, $sql_seSumarysus10, $params_seSumarysus10);
                    $result_seSumarysus10 = sqlsrv_fetch_array($query_seSumarysus10, SQLSRV_FETCH_ASSOC);
                    
                    
                    
                  

                    $sql_seSumarypro1 = "SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '2'
                        
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '01' AND b.[SECTIONCODE] = '02' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarypro1 = sqlsrv_query($conn, $sql_seSumarypro1, $params_seSumarypro1);
                    $result_seSumarypro1 = sqlsrv_fetch_array($query_seSumarypro1, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumarypro2 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '2'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '01' AND b.[SECTIONCODE] = '01' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarypro2 = sqlsrv_query($conn, $sql_seSumarypro2, $params_seSumarypro2);
                    $result_seSumarypro2 = sqlsrv_fetch_array($query_seSumarypro2, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumarypro3 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '2'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '03' AND b.[SECTIONCODE] = '01' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarypro3 = sqlsrv_query($conn, $sql_seSumarypro3, $params_seSumarypro3);
                    $result_seSumarypro3 = sqlsrv_fetch_array($query_seSumarypro3, SQLSRV_FETCH_ASSOC);
                    
                                         $sql_seSumarypro4 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '2'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '04' AND b.[SECTIONCODE] = '01' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarypro4 = sqlsrv_query($conn, $sql_seSumarypro4, $params_seSumarypro4);
                    $result_seSumarypro4 = sqlsrv_fetch_array($query_seSumarypro4, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumarypro5 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '2'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '02' AND b.[SECTIONCODE] = '01' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarypro5 = sqlsrv_query($conn, $sql_seSumarypro5, $params_seSumarypro5);
                    $result_seSumarypro5 = sqlsrv_fetch_array($query_seSumarypro5, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumarypro6 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '2'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '02' AND b.[SECTIONCODE] = '02' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarypro6 = sqlsrv_query($conn, $sql_seSumarypro6, $params_seSumarypro6);
                    $result_seSumarypro6 = sqlsrv_fetch_array($query_seSumarypro6, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumarypro7 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '2'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '03' AND b.[SECTIONCODE] = '02' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarypro7 = sqlsrv_query($conn, $sql_seSumarypro7, $params_seSumarypro7);
                    $result_seSumarypro7 = sqlsrv_fetch_array($query_seSumarypro7, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumarypro8 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '2'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '04' AND b.[SECTIONCODE] = '02' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarypro8 = sqlsrv_query($conn, $sql_seSumarypro8, $params_seSumarypro8);
                    $result_seSumarypro8 = sqlsrv_fetch_array($query_seSumarypro8, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumarypro9 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '2'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '04' AND b.[SECTIONCODE] = '03' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarypro9 = sqlsrv_query($conn, $sql_seSumarypro9, $params_seSumarypro9);
                    $result_seSumarypro9 = sqlsrv_fetch_array($query_seSumarypro9, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seSumarypro10 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '2'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '03' AND b.[SECTIONCODE] = '03' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarypro10 = sqlsrv_query($conn, $sql_seSumarypro10, $params_seSumarypro10);
                    $result_seSumarypro10 = sqlsrv_fetch_array($query_seSumarypro10, SQLSRV_FETCH_ASSOC);
                    
                    
                   

                    $sql_seSumarytime1 = "SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '1'
                        
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '01' AND b.[SECTIONCODE] = '02' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarytime1 = sqlsrv_query($conn, $sql_seSumarytime1, $params_seSumarytime1);
                    $result_seSumarytime1 = sqlsrv_fetch_array($query_seSumarytime1, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumarytime2 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '1'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '01' AND b.[SECTIONCODE] = '01' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarytime2 = sqlsrv_query($conn, $sql_seSumarytime2, $params_seSumarytime2);
                    $result_seSumarytime2 = sqlsrv_fetch_array($query_seSumarytime2, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumarytime3 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '1'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '03' AND b.[SECTIONCODE] = '01' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarytime3 = sqlsrv_query($conn, $sql_seSumarytime3, $params_seSumarytime3);
                    $result_seSumarytime3 = sqlsrv_fetch_array($query_seSumarytime3, SQLSRV_FETCH_ASSOC);
                    
                                         $sql_seSumarytime4 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '1'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '04' AND b.[SECTIONCODE] = '01' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarytime4 = sqlsrv_query($conn, $sql_seSumarytime4, $params_seSumarytime4);
                    $result_seSumarytime4 = sqlsrv_fetch_array($query_seSumarytime4, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumarytime5 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '1'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '02' AND b.[SECTIONCODE] = '01' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarytime5 = sqlsrv_query($conn, $sql_seSumarytime5, $params_seSumarytime5);
                    $result_seSumarytime5 = sqlsrv_fetch_array($query_seSumarytime5, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumarytime6 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '1'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '02' AND b.[SECTIONCODE] = '02' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarytime6 = sqlsrv_query($conn, $sql_seSumarytime6, $params_seSumarytime6);
                    $result_seSumarytime6 = sqlsrv_fetch_array($query_seSumarytime6, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumarytime7 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '1'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '03' AND b.[SECTIONCODE] = '02' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarytime7 = sqlsrv_query($conn, $sql_seSumarytime7, $params_seSumarytime7);
                    $result_seSumarytime7 = sqlsrv_fetch_array($query_seSumarytime7, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumarytime8 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '1'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '04' AND b.[SECTIONCODE] = '02' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarytime8 = sqlsrv_query($conn, $sql_seSumarytime8, $params_seSumarytime8);
                    $result_seSumarytime8 = sqlsrv_fetch_array($query_seSumarytime8, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumarytime9 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '1'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '04' AND b.[SECTIONCODE] = '03' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarytime9 = sqlsrv_query($conn, $sql_seSumarytime9, $params_seSumarytime9);
                    $result_seSumarytime9 = sqlsrv_fetch_array($query_seSumarytime9, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seSumarytime10 = " SELECT COUNT(*) AS 'CNT' FROM (SELECT  DISTINCT a.EMPLOYEECODE FROM [dbo].[WORKCHECKIN] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE  a.REMARK = '1'
AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) 
AND b.[DEPARTMENTCODE] = '03' AND b.[SECTIONCODE] = '03' AND b.AREA = 'amata' ) AS A";
                    $query_seSumarytime10 = sqlsrv_query($conn, $sql_seSumarytime10, $params_seSumarytime10);
                    $result_seSumarytime10 = sqlsrv_fetch_array($query_seSumarytime10, SQLSRV_FETCH_ASSOC);
                    
                    
                    
                    
                    $sql_seSumaryemployeeno1 = "SELECT COUNT(*) AS 'CNT' FROM [dbo].[ORGANIZATION] WHERE EMPLOYEECODE NOT IN 
(SELECT EMPLOYEECODE FROM [dbo].[WORKCHECKIN] WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103))
AND [DEPARTMENTCODE] = '01' AND [SECTIONCODE] = '02' AND AREA = 'amata' ";
                    $query_seSumaryemployeeno1 = sqlsrv_query($conn, $sql_seSumaryemployeeno1, $params_seSumaryemployeeno1);
                    $result_seSumaryemployeeno1 = sqlsrv_fetch_array($query_seSumaryemployeeno1, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumaryemployeeno2 = " SELECT COUNT(*) AS 'CNT' FROM [dbo].[ORGANIZATION] WHERE EMPLOYEECODE NOT IN 
(SELECT EMPLOYEECODE FROM [dbo].[WORKCHECKIN] WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103))
AND [DEPARTMENTCODE] = '01' AND [SECTIONCODE] = '01' AND AREA = 'amata' ";
                    $query_seSumaryemployeeno2 = sqlsrv_query($conn, $sql_seSumaryemployeeno2, $params_seSumaryemployeeno2);
                    $result_seSumaryemployeeno2 = sqlsrv_fetch_array($query_seSumaryemployeeno2, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumaryemployeeno3 = " SELECT COUNT(*) AS 'CNT' FROM [dbo].[ORGANIZATION] WHERE EMPLOYEECODE NOT IN 
(SELECT EMPLOYEECODE FROM [dbo].[WORKCHECKIN] WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103))
AND [DEPARTMENTCODE] = '03' AND [SECTIONCODE] = '01' AND AREA = 'amata' ";
                    $query_seSumaryemployeeno3 = sqlsrv_query($conn, $sql_seSumaryemployeeno3, $params_seSumaryemployeeno3);
                    $result_seSumaryemployeeno3 = sqlsrv_fetch_array($query_seSumaryemployeeno3, SQLSRV_FETCH_ASSOC);
                    
                                         $sql_seSumaryemployeeno4 = " SELECT COUNT(*) AS 'CNT' FROM [dbo].[ORGANIZATION] WHERE EMPLOYEECODE NOT IN 
(SELECT EMPLOYEECODE FROM [dbo].[WORKCHECKIN] WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103))
AND [DEPARTMENTCODE] = '04' AND [SECTIONCODE] = '01' AND AREA = 'amata' ";
                    $query_seSumaryemployeeno4 = sqlsrv_query($conn, $sql_seSumaryemployeeno4, $params_seSumaryemployeeno4);
                    $result_seSumaryemployeeno4 = sqlsrv_fetch_array($query_seSumaryemployeeno4, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumaryemployeeno5 = " SELECT COUNT(*) AS 'CNT' FROM [dbo].[ORGANIZATION] WHERE EMPLOYEECODE NOT IN 
(SELECT EMPLOYEECODE FROM [dbo].[WORKCHECKIN] WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103))
AND [DEPARTMENTCODE] = '02' AND [SECTIONCODE] = '01' AND AREA = 'amata' ";
                    $query_seSumaryemployeeno5 = sqlsrv_query($conn, $sql_seSumaryemployeeno5, $params_seSumaryemployeeno5);
                    $result_seSumaryemployeeno5 = sqlsrv_fetch_array($query_seSumaryemployeeno5, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumaryemployeeno6 = " SELECT COUNT(*) AS 'CNT' FROM [dbo].[ORGANIZATION] WHERE EMPLOYEECODE NOT IN 
(SELECT EMPLOYEECODE FROM [dbo].[WORKCHECKIN] WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103))
AND [DEPARTMENTCODE] = '02' AND [SECTIONCODE] = '02' AND AREA = 'amata' ";
                    $query_seSumaryemployeeno6 = sqlsrv_query($conn, $sql_seSumaryemployeeno6, $params_seSumaryemployeeno6);
                    $result_seSumaryemployeeno6 = sqlsrv_fetch_array($query_seSumaryemployeeno6, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumaryemployeeno7 = " SELECT COUNT(*) AS 'CNT' FROM [dbo].[ORGANIZATION] WHERE EMPLOYEECODE NOT IN 
(SELECT EMPLOYEECODE FROM [dbo].[WORKCHECKIN] WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103))
AND [DEPARTMENTCODE] = '03' AND [SECTIONCODE] = '02' AND AREA = 'amata' ";
                    $query_seSumaryemployeeno7 = sqlsrv_query($conn, $sql_seSumaryemployeeno7, $params_seSumaryemployeeno7);
                    $result_seSumaryemployeeno7 = sqlsrv_fetch_array($query_seSumaryemployeeno7, SQLSRV_FETCH_ASSOC);
                    
                                        $sql_seSumaryemployeeno8 = " SELECT COUNT(*) AS 'CNT' FROM [dbo].[ORGANIZATION] WHERE EMPLOYEECODE NOT IN 
(SELECT EMPLOYEECODE FROM [dbo].[WORKCHECKIN] WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103))
AND [DEPARTMENTCODE] = '04' AND [SECTIONCODE] = '02' AND AREA = 'amata' ";
                    $query_seSumaryemployeeno8 = sqlsrv_query($conn, $sql_seSumaryemployeeno8, $params_seSumaryemployeeno8);
                    $result_seSumaryemployeeno8 = sqlsrv_fetch_array($query_seSumaryemployeeno8, SQLSRV_FETCH_ASSOC);
                    
                                         $sql_seSumaryemployeeno9 = " SELECT COUNT(*) AS 'CNT' FROM [dbo].[ORGANIZATION] WHERE EMPLOYEECODE NOT IN 
(SELECT EMPLOYEECODE FROM [dbo].[WORKCHECKIN] WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103))
AND [DEPARTMENTCODE] = '04' AND [SECTIONCODE] = '03' AND AREA = 'amata'";
                    $query_seSumaryemployeeno9 = sqlsrv_query($conn, $sql_seSumaryemployeeno9, $params_seSumaryemployeeno9);
                    $result_seSumaryemployeeno9 = sqlsrv_fetch_array($query_seSumaryemployeeno9, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seSumaryemployeeno10 = " SELECT COUNT(*) AS 'CNT' FROM [dbo].[ORGANIZATION] WHERE EMPLOYEECODE NOT IN 
(SELECT EMPLOYEECODE FROM [dbo].[WORKCHECKIN] WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103))
AND [DEPARTMENTCODE] = '03' AND [SECTIONCODE] = '03' AND AREA = 'amata' ";
                    $query_seSumaryemployeeno10 = sqlsrv_query($conn, $sql_seSumaryemployeeno10, $params_seSumaryemployeeno10);
                    $result_seSumaryemployeeno10 = sqlsrv_fetch_array($query_seSumaryemployeeno10, SQLSRV_FETCH_ASSOC);

                    ?>
                
                <tr >
                    <td style="border:1px solid #000;padding:4px;text-align: center" >1</td>
                    <td style="border:1px solid #000;padding:4px;text-align: left" >Ruamkit Rungrueng Traning Center</td>
                    <td style="border:1px solid #000;padding:4px;text-align: left" ><?= $result_seSumary9['CNT'] + $result_seSumaryemployeeno9['CNT'] ?></td>
                    <td style="border:1px solid #000;padding:4px;text-align: left" ><?= $result_seSumarysus9['CNT'] ?></td>
                    <td style="border:1px solid #000;padding:4px;text-align: left" ><?= $result_seSumarypro9['CNT'] ?></td>
                    <td style="border:1px solid #000;padding:4px;text-align: left" ><?= $result_seSumarytime9['CNT'] ?></td>
                    <td style="border:1px solid #000;padding:4px;text-align: left" ><?= $result_seSumaryemployeeno9['CNT'] ?></td>
                </tr>
               



            </tbody>

        </table>
        <br>
        <table   style="border-collapse: collapse;margin-top:8px;font-size:10px" width="100%"  >
            <thead>
                <tr>

                    <th colspan="14" style="border-top:1px solid #000;font-size:14px;border:1px solid #000;padding:6px;text-align:center">
                        <b>รายงานตัวปฎิบัติงานประจำวันที่ <?= $result_getDate['GETDATE'] ?> ถึงวันที่ <?= $result_getDate['GETDATE'] ?> (Affiliate Business)(Ruamkit Rungrueng Traning Center)</b> 

                    </th>

                </tr>
                <tr>

                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" rowspan="2" rowspan="2">ลำดับ</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" rowspan="2" rowspan="2">สายงาน</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" rowspan="2" rowspan="2">รหัสพนักงาน</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" rowspan="2" rowspan="2">ชื่อ-นามสกุล</th>

                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" rowspan="2" rowspan="2">สาเหตุ</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" rowspan="2" rowspan="2">วันที่</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" rowspan="2" rowspan="2">เวลา (ช่วงเวลา)</th>
                    <!--<th rowspan="2">ที่อยู่ (แผนที่)</th>
                    <th rowspan="2">ที่อยู่ (ปัจจุบัน)</th>-->
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" colspan="3">ที่อยู่ (ปัจจุบัน)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center"><< ระยะห่าง (ก.ม) >></th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" colspan="3">ที่อยู่ (แผนที่)</th>

                </tr>
                <tr>

                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center">ตำบล</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center">อำเภอ</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center">จังหวัด</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center">&nbsp;</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center">ตำบล</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center">อำเภอ</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center">จังหวัด</th>

                </tr>


            </thead>
            <tbody>
                <?php
                $i = 1;
                $condWorkcheckin1 = " AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103) AND CONVERT(DATE,'" . $result_getDate['GETDATE'] . "',103)";
                $condWorkcheckin2 = " AND c.DEPARTMENTCODE = '04' AND c.[SECTIONCODE] = '03'";











                $sql_seWorkcheckin = "{call megWorkcheckin_v2(?,?,?,?)}";
                $params_seWorkcheckin = array(
                    array('select_workcheckin', SQLSRV_PARAM_IN),
                    array($condWorkcheckin2, SQLSRV_PARAM_IN),
                    array($condWorkcheckin1, SQLSRV_PARAM_IN),
                    array(" AND c.AREA = 'amata'", SQLSRV_PARAM_IN)
                );
                $query_seWorkcheckin = sqlsrv_query($conn, $sql_seWorkcheckin, $params_seWorkcheckin);
                while ($result_seWorkcheckin = sqlsrv_fetch_array($query_seWorkcheckin, SQLSRV_FETCH_ASSOC)) {
                    /* $sql_seAddress = "SELECT 
                      CONCAT(CASE WHEN a.CurrentAddress = '-' THEN '' ELSE a.CurrentAddress END,
                      CASE WHEN a.CurrentBuilding = '-' THEN '' ELSE a.CurrentBuilding END,
                      CASE WHEN a.CurrentSoi = '-' THEN '' ELSE 'ซ.'+a.CurrentSoi END,
                      CASE WHEN a.CurrentRoad = '-' THEN '' ELSE 'ถนน'+a.CurrentRoad END,
                      CASE WHEN b.DistrictT = '-' THEN '' ELSE 'ต.'+b.DistrictT END,
                      CASE WHEN c.[AmphurT] = '-' THEN '' ELSE 'อ.'+c.[AmphurT] END,
                      CASE WHEN d.ProveNameT = '-' THEN '' ELSE 'จ.'+d.ProveNameT END,
                      CASE WHEN a.CurrentPostID = '-' THEN '' ELSE a.CurrentPostID END) AS 'ADDRESS'
                      FROM [203.150.225.30].[TigerE-HR].[dbo].[PNT_Person] a
                      INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].[PNM_District] b ON a.CurrentDistric = b.[DistrictID]
                      INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].[PNM_Amphur] c ON a.CurrentAmphur = c.[AmphurID]
                      INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].[PNM_Province] d ON a.CurrentProvince = d.[ProvID]
                      WHERE a.[PersonCode] = '" . $result_seWorkcheckin['EMPLOYEECODE'] . "'"; */



                    $sql_seWorkcheckintime = "SELECT COUNT(*) AS 'CHKTIME' FROM [dbo].[WORKCHECKIN]
                                                                            WHERE CONVERT(DATE,'" . $result_seWorkcheckin['CREATEDATE1'] . "',103) = CONVERT(DATE,CREATEDATE)
                                                                            AND WORKCHECKINID = '" . $result_seWorkcheckin['WORKCHECKINID'] . "'
                                                                            AND
                                                                            (CONVERT(NVARCHAR,CONVERT(DATETIME,'" . $result_seWorkcheckin['CREATEDATE1'] . "'),108) BETWEEN CONVERT(DATETIME,'13:00:00',108) AND CONVERT(DATETIME,'14:00:00',108))";
                    $params_seWorkcheckintime = array(
                        array('select_workcheckin', SQLSRV_PARAM_IN),
                        array($result_getDate['GETDATE'], SQLSRV_PARAM_IN)
                    );
                    $query_seWorkcheckintime = sqlsrv_query($conn, $sql_seWorkcheckintime, $params_seWorkcheckintime);
                    $result_seWorkcheckintime = sqlsrv_fetch_array($query_seWorkcheckintime, SQLSRV_FETCH_ASSOC);
                    $chkcolor = ($result_seWorkcheckintime['CHKTIME'] == '0') ? " style='color: red' " : "";





                    $sql_seAddress = "SELECT[EMPLOYEECODEMASTER],[LATIUDEMASTER],[LONGITUDEMASTER],[MAPADDRESSMASTER],RIGHT(MAPADDRESSMASTER,1) AS 'CHKEN' FROM [dbo].[WORKCHECKINMASTER] WHERE [EMPLOYEECODEMASTER] = '" . $result_seWorkcheckin['EMPLOYEECODE'] . "'";
                    $query_seAddress = sqlsrv_query($conn, $sql_seAddress, $params_seAddress);
                    $result_seAddress = sqlsrv_fetch_array($query_seAddress, SQLSRV_FETCH_ASSOC);
                    if (preg_match('/^[a-z]+$/i', $result_seAddress['CHKEN'])) {
                        $sql_seTambonmaster = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('" . $result_seAddress['MAPADDRESSMASTER'] . "',',')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('" . $result_seAddress['MAPADDRESSMASTER'] . "',','))-3";
                        $query_seTambonmaster = sqlsrv_query($conn, $sql_seTambonmaster, $params_seTambonmaster);
                        $result_seTambonmaster = sqlsrv_fetch_array($query_seTambonmaster, SQLSRV_FETCH_ASSOC);
                        $rsTambonmaster = $result_seTambonmaster['VALUE'];

                        $sql_seAmphurmaster = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('" . $result_seAddress['MAPADDRESSMASTER'] . "',',')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('" . $result_seAddress['MAPADDRESSMASTER'] . "',','))-2";
                        $query_seAmphurmaster = sqlsrv_query($conn, $sql_seAmphurmaster, $params_seAmphurmaster);
                        $result_seAmphurmaster = sqlsrv_fetch_array($query_seAmphurmaster, SQLSRV_FETCH_ASSOC);

                        $rsAmphurmaster = $result_seAmphurmaster['VALUE'];

                        $sql_seProvincemaster = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('" . $result_seAddress['MAPADDRESSMASTER'] . "',',')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('" . $result_seAddress['MAPADDRESSMASTER'] . "',','))-1";
                        $query_seProvincemaster = sqlsrv_query($conn, $sql_seProvincemaster, $params_seProvincemaster);
                        $result_seProvincemaster = sqlsrv_fetch_array($query_seProvincemaster, SQLSRV_FETCH_ASSOC);
                        $rsProvincemaster = $result_seProvincemaster['VALUE'];
                    } else {
                        $sql_seTambonmaster = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('" . $result_seAddress['MAPADDRESSMASTER'] . "',' ')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('" . $result_seAddress['MAPADDRESSMASTER'] . "',' '))-4";
                        $query_seTambonmaster = sqlsrv_query($conn, $sql_seTambonmaster, $params_seTambonmaster);
                        $result_seTambonmaster = sqlsrv_fetch_array($query_seTambonmaster, SQLSRV_FETCH_ASSOC);
                        $rsTambonmaster = $result_seTambonmaster['VALUE'];
                        $sql_seAmphurmaster = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('" . $result_seAddress['MAPADDRESSMASTER'] . "',' ')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('" . $result_seAddress['MAPADDRESSMASTER'] . "',' '))-3";
                        $query_seAmphurmaster = sqlsrv_query($conn, $sql_seAmphurmaster, $params_seAmphurmaster);
                        $result_seAmphurmaster = sqlsrv_fetch_array($query_seAmphurmaster, SQLSRV_FETCH_ASSOC);
                        $rsAmphurmaster = $result_seAmphurmaster['VALUE'];
                        $sql_seProvincemaster = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('" . $result_seAddress['MAPADDRESSMASTER'] . "',' ')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('" . $result_seAddress['MAPADDRESSMASTER'] . "',' '))-2";
                        $query_seProvincemaster = sqlsrv_query($conn, $sql_seProvincemaster, $params_seProvincemaster);
                        $result_seProvincemaster = sqlsrv_fetch_array($query_seProvincemaster, SQLSRV_FETCH_ASSOC);
                        $rsProvincemaster = $result_seProvincemaster['VALUE'];
                    }



                    if (preg_match('/^[a-z]+$/i', $result_seWorkcheckin['CHKEN'])) {
                        $sql_seTambon = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('" . $result_seWorkcheckin['MAPADDRESS'] . "',',')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('" . $result_seWorkcheckin['MAPADDRESS'] . "',','))-3";
                        $query_seTambon = sqlsrv_query($conn, $sql_seTambon, $params_seTambon);
                        $result_seTambon = sqlsrv_fetch_array($query_seTambon, SQLSRV_FETCH_ASSOC);
                        $rsTambon = $result_seTambon['VALUE'];


                        $sql_seAmphur = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('" . $result_seWorkcheckin['MAPADDRESS'] . "',',')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('" . $result_seWorkcheckin['MAPADDRESS'] . "',','))-2";
                        $query_seAmphur = sqlsrv_query($conn, $sql_seAmphur, $params_seAmphur);
                        $result_seAmphur = sqlsrv_fetch_array($query_seAmphur, SQLSRV_FETCH_ASSOC);
                        $rsAmphur = $result_seAmphur['VALUE'];



                        $sql_seProvince = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('" . $result_seWorkcheckin['MAPADDRESS'] . "',',')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('" . $result_seWorkcheckin['MAPADDRESS'] . "',','))-1";
                        $query_seProvince = sqlsrv_query($conn, $sql_seProvince, $params_seProvince);
                        $result_seProvince = sqlsrv_fetch_array($query_seProvince, SQLSRV_FETCH_ASSOC);
                        $rsProvince = $result_seProvince['VALUE'];
                    } else {
                        $sql_seTambon = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('" . $result_seWorkcheckin['MAPADDRESS'] . "',' ')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('" . $result_seWorkcheckin['MAPADDRESS'] . "',' '))-4";
                        $query_seTambon = sqlsrv_query($conn, $sql_seTambon, $params_seTambon);
                        $result_seTambon = sqlsrv_fetch_array($query_seTambon, SQLSRV_FETCH_ASSOC);
                        $rsTambon = $result_seTambon['VALUE'];


                        $sql_seAmphur = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('" . $result_seWorkcheckin['MAPADDRESS'] . "',' ')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('" . $result_seWorkcheckin['MAPADDRESS'] . "',' '))-3";
                        $query_seAmphur = sqlsrv_query($conn, $sql_seAmphur, $params_seAmphur);
                        $result_seAmphur = sqlsrv_fetch_array($query_seAmphur, SQLSRV_FETCH_ASSOC);
                        $rsAmphur = $result_seAmphur['VALUE'];



                        $sql_seProvince = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('" . $result_seWorkcheckin['MAPADDRESS'] . "',' ')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('" . $result_seWorkcheckin['MAPADDRESS'] . "',' '))-2";
                        $query_seProvince = sqlsrv_query($conn, $sql_seProvince, $params_seProvince);
                        $result_seProvince = sqlsrv_fetch_array($query_seProvince, SQLSRV_FETCH_ASSOC);
                        $rsProvince = $result_seProvince['VALUE'];
                    }


                    $chkcolort = ($result_seTambonmaster['VALUE'] == $result_seTambon['VALUE']) ? " style='color: green' " : " style='color: #ffd500'";
                    $chkcolora = ($result_seAmphurmaster['VALUE'] == $result_seAmphur['VALUE']) ? " style='color: green' " : " style='color: #ff9c00'";
                    $chkcolorp = ($result_seProvincemaster['VALUE'] == $result_seProvince['VALUE']) ? " style='color: green' " : " style='color: #ff5c00'";



                    $sql_seCat = "SELECT b.PositionNameT FROM [RTMS].[dbo].[EMPLOYEEEHR] a INNER JOIN [dbo].[POSITIONEHR] b ON a.PositionID = b.PositionID WHERE a.PersonCode = '" . $result_seWorkcheckin['EMPLOYEECODE'] . "'";

                    $query_seCat = sqlsrv_query($conn, $sql_seCat, $params_seCat);
                    $result_seCat = sqlsrv_fetch_array($query_seCat, SQLSRV_FETCH_ASSOC);
                    ?>

                    <tr <?= $chkcolor ?>>
                        <td style="border:1px solid #000;padding:4px;text-align: center"  ><?= $i ?></td>

                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seCat['PositionNameT'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seWorkcheckin['EMPLOYEECODE'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seWorkcheckin['FLNAME'] ?> (<?= $result_seWorkcheckin['CurrentTel'] ?>)</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seWorkcheckin['BEFOREACTIVITY'] ?></td>


                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seWorkcheckin['CREATEDATE'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seWorkcheckin['CREATETIME'] ?> <u>(<?= $result_seWorkcheckin['CREATETIME1'] ?>)</u></td>
                        <!--<td ><?//= $result_seWorkcheckin['MAPADDRESS'] ?></td>
                        <td ><?//= $result_seAddress['MAPADDRESSMASTER'] ?></td>-->
                        <td style="border:1px solid #000;padding:4px;text-align: left" <?= $chkcolort ?>><?= $rsTambonmaster ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left" <?= $chkcolora ?>><?= $rsAmphurmaster ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left" <?= $chkcolorp ?>><?= $rsProvincemaster ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: center"><?= haversineGreatCircleDistance($result_seAddress['LATIUDEMASTER'], $result_seAddress['LONGITUDEMASTER'], $result_seWorkcheckin['LATIUDE'], $result_seWorkcheckin['LONGITUDE']) ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"<?= $chkcolort ?>><?= $rsTambon ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"<?= $chkcolora ?>><?= $rsAmphur ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"<?= $chkcolorp ?>><?= $rsProvince ?></td>

                    </tr>
                    <?php
                    $rs = $rs . str_replace(',', "','", $emp . ',' . $result_seWorkcheckin['EMPLOYEECODE']);
                    $i++;
                }
                ?>
                <?php
                //echo );




                $y = $i;

                $sql_seEmployeenotcheckin = "SELECT a.CurrentTel,a.PersonCode,a.FnameT+' '+a.LnameT AS 'FLnameT' FROM [dbo].[EMPLOYEEEHR] a
        INNER JOIN [dbo].[ORGANIZATION] b ON a.PersonCode = b.EMPLOYEECODE
        WHERE 1=1
        AND a.PersonCode NOT IN('" . substr($rs, 3, strlen($rs)) . "')
       AND  b.AREA = 'amata' AND b.DEPARTMENTCODE = '04' AND b.[SECTIONCODE] = '03' AND b.DEPARTMENTCODE !='' AND b.[SECTIONCODE] !=''";

                $query_seEmployeenotcheckin = sqlsrv_query($conn, $sql_seEmployeenotcheckin, $params_seEmployeenotcheckin);
                while ($result_seEmployeenotcheckin = sqlsrv_fetch_array($query_seEmployeenotcheckin, SQLSRV_FETCH_ASSOC)) {
                    ?>
                    <tr style='color: #CCCCCC'>
                        <td style="border:1px solid #000;padding:4px;text-align: center"><?= $y ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seEmployeenotcheckin['PersonCode'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seEmployeenotcheckin['FLnameT'] ?> (<?= $result_seWorkcheckin['CurrentTel'] ?>)</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>


                                                                                                                             <!--<td style="text-align: center"><a href="#" data-toggle="modal" onclick="send_data('<?//=$result_seWorkcheckin['EMPLOYEECODE']?>','<?//=$result_seWorkcheckin['FLNAME']?>','<?//=$result_seWorkcheckin['CREATEDATE']?>','<?//=$result_seWorkcheckin['CREATETIME']?>','<?//=$result_seWorkcheckin['LATIUDE']?>','<?//=$result_seWorkcheckin['LONGITUDE']?>')"  data-target="#modal_selectline" class="btn btn-success"><b>@LINE</b></a></td>-->
                        <td style="border:1px solid #000;padding:4px;text-align: center">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: center">-</td>



                    </tr>
                    <?php
                    $y++;
                }
                ?>

            </tbody>

        </table>
    </body>
</html>
<script langauge="javascript">
    window.open('', '_self');
    self.close();
</script>