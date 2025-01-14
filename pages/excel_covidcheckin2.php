<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);





$strExcelFileName = "รายงานตัวโควิด-19" . $_GET['datestart'] . "ถึงวันที่" . $_GET['dateend'] . ".xls";
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

        <table   style="border-collapse: collapse;margin-top:8px;font-size:10px" width="100%"  >
            <thead>
                <tr>

                    <th colspan="44" style="border-top:1px solid #000;font-size:14px;border:1px solid #000;padding:6px;text-align:center">
                        <b>สรุปรายงานตัวโควิด-19 ตั้งแต่วันที่ <?=$_GET['datestart']?> ถึงวันที่ <?=$_GET['dateend']?> (วิทวัส คำจันดี)</b>
                        
                    </th>

                </tr>
                <tr>

                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ลำดับ</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >วันที่</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >รหัสพนักงาน</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ชื่อ-นามสกุล</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >เวลารายงานตัว(1)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ตำแหน่งที่(1)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >เวลารายงานตัว(2)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ตำแหน่งที่(2)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >เวลารายงานตัว(3)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ตำแหน่งที่(3)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >เวลารายงานตัว(4)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ตำแหน่งที่(4)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >เวลารายงานตัว(5)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ตำแหน่งที่(5)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >เวลารายงานตัว(6)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ตำแหน่งที่(6)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >เวลารายงานตัว(7)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ตำแหน่งที่(7)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >เวลารายงานตัว(8)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ตำแหน่งที่(8)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >เวลารายงานตัว(9)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ตำแหน่งที่(9)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >เวลารายงานตัว(10)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ตำแหน่งที่(10)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >เวลารายงานตัว(11)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ตำแหน่งที่(11)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >เวลารายงานตัว(12)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ตำแหน่งที่(12)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >เวลารายงานตัว(13)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ตำแหน่งที่(13)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >เวลารายงานตัว(14)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ตำแหน่งที่(14)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >เวลารายงานตัว(15)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ตำแหน่งที่(15)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >เวลารายงานตัว(16)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ตำแหน่งที่(16)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >เวลารายงานตัว(17)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ตำแหน่งที่(17)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >เวลารายงานตัว(18)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ตำแหน่งที่(18)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >เวลารายงานตัว(19)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ตำแหน่งที่(19)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >เวลารายงานตัว(20)</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" >ตำแหน่งที่(20)</th>



                </tr>


            </thead>
            <tbody>
                <?php
                $i = 1;

                 $sql_seData1 = "SELECT DISTINCT a.[EMPLOYEECODE], 
CONVERT(NVARCHAR(10),a.CREATEDATE,103) AS 'CREATEDATE',c.FnameT+' '+c.LnameT AS 'nameFL'
FROM [dbo].[COVIDCHECKIN] a 
INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode
WHERE 1=1 AND c.FnameT+' '+c.LnameT = '".$_GET['employeecode']."'
AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) between '" . $_GET['datestart'] . "' and '" . $_GET['dateend'] . "'";
                $params_seData1 = array();
                $query_seData1 = sqlsrv_query($conn, $sql_seData1, $params_seData1);
                while ($result_seData1 = sqlsrv_fetch_array($query_seData1, SQLSRV_FETCH_ASSOC)) {
                    
                    $sql_seData1_1 = "SELECT *
                    FROM
                        (
                            SELECT
                                ROW_NUMBER () OVER (ORDER BY [COVIDCHECKINID]) AS RowNum,CONVERT(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATETIME', a.[ADDRESS]
                            FROM
                                [COVIDCHECKIN] a
                                    WHERE a.[EMPLOYEECODE] = '".$result_seData1['EMPLOYEECODE']."' AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) = '" . $result_seData1['CREATEDATE'] . "'
                        ) A
                    WHERE
                        RowNum = 1";
                    $params_seData1_1 = array();
                    $query_seData1_1 = sqlsrv_query($conn, $sql_seData1_1, $params_seData1_1);
                    $result_seData1_1 = sqlsrv_fetch_array($query_seData1_1, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seData1_2 = "SELECT *
                    FROM
                        (
                            SELECT
                                ROW_NUMBER () OVER (ORDER BY [COVIDCHECKINID]) AS RowNum,CONVERT(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATETIME', a.[ADDRESS]
                            FROM
                                [COVIDCHECKIN] a
                                    WHERE a.[EMPLOYEECODE] = '".$result_seData1['EMPLOYEECODE']."' AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) = '" . $result_seData1['CREATEDATE'] . "'
                        ) A
                    WHERE
                        RowNum = 2";
                    $params_seData1_2 = array();
                    $query_seData1_2 = sqlsrv_query($conn, $sql_seData1_2, $params_seData1_2);
                    $result_seData1_2 = sqlsrv_fetch_array($query_seData1_2, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seData1_3 = "SELECT *
                    FROM
                        (
                            SELECT
                                ROW_NUMBER () OVER (ORDER BY [COVIDCHECKINID]) AS RowNum,CONVERT(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATETIME', a.[ADDRESS]
                            FROM
                                [COVIDCHECKIN] a
                                    WHERE a.[EMPLOYEECODE] = '".$result_seData1['EMPLOYEECODE']."' AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) = '" . $result_seData1['CREATEDATE'] . "'
                        ) A
                    WHERE
                        RowNum = 3";
                    $params_seData1_3 = array();
                    $query_seData1_3 = sqlsrv_query($conn, $sql_seData1_3, $params_seData1_3);
                    $result_seData1_3 = sqlsrv_fetch_array($query_seData1_3, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seData1_4 = "SELECT *
                    FROM
                        (
                            SELECT
                                ROW_NUMBER () OVER (ORDER BY [COVIDCHECKINID]) AS RowNum,CONVERT(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATETIME', a.[ADDRESS]
                            FROM
                                [COVIDCHECKIN] a
                                    WHERE a.[EMPLOYEECODE] = '".$result_seData1['EMPLOYEECODE']."' AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) = '" . $result_seData1['CREATEDATE'] . "'
                        ) A
                    WHERE
                        RowNum = 4";
                    $params_seData1_4 = array();
                    $query_seData1_4 = sqlsrv_query($conn, $sql_seData1_4, $params_seData1_4);
                    $result_seData1_4 = sqlsrv_fetch_array($query_seData1_4, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seData1_5 = "SELECT *
                    FROM
                        (
                            SELECT
                                ROW_NUMBER () OVER (ORDER BY [COVIDCHECKINID]) AS RowNum,CONVERT(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATETIME', a.[ADDRESS]
                            FROM
                                [COVIDCHECKIN] a
                                    WHERE a.[EMPLOYEECODE] = '".$result_seData1['EMPLOYEECODE']."' AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) = '" . $result_seData1['CREATEDATE'] . "'
                        ) A
                    WHERE
                        RowNum = 5";
                    $params_seData1_5 = array();
                    $query_seData1_5 = sqlsrv_query($conn, $sql_seData1_5, $params_seData1_5);
                    $result_seData1_5 = sqlsrv_fetch_array($query_seData1_5, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seData1_6 = "SELECT *
                    FROM
                        (
                            SELECT
                                ROW_NUMBER () OVER (ORDER BY [COVIDCHECKINID]) AS RowNum,CONVERT(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATETIME', a.[ADDRESS]
                            FROM
                                [COVIDCHECKIN] a
                                    WHERE a.[EMPLOYEECODE] = '".$result_seData1['EMPLOYEECODE']."' AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) = '" . $result_seData1['CREATEDATE'] . "'
                        ) A
                    WHERE
                        RowNum = 6";
                    $params_seData1_6 = array();
                    $query_seData1_6 = sqlsrv_query($conn, $sql_seData1_6, $params_seData1_6);
                    $result_seData1_6 = sqlsrv_fetch_array($query_seData1_6, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seData1_7 = "SELECT *
                    FROM
                        (
                            SELECT
                                ROW_NUMBER () OVER (ORDER BY [COVIDCHECKINID]) AS RowNum,CONVERT(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATETIME', a.[ADDRESS]
                            FROM
                                [COVIDCHECKIN] a
                                    WHERE a.[EMPLOYEECODE] = '".$result_seData1['EMPLOYEECODE']."' AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) = '" . $result_seData1['CREATEDATE'] . "'
                        ) A
                    WHERE
                        RowNum = 7";
                    $params_seData1_7 = array();
                    $query_seData1_7 = sqlsrv_query($conn, $sql_seData1_7, $params_seData1_7);
                    $result_seData1_7 = sqlsrv_fetch_array($query_seData1_7, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seData1_8 = "SELECT *
                    FROM
                        (
                            SELECT
                                ROW_NUMBER () OVER (ORDER BY [COVIDCHECKINID]) AS RowNum,CONVERT(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATETIME', a.[ADDRESS]
                            FROM
                                [COVIDCHECKIN] a
                                    WHERE a.[EMPLOYEECODE] = '".$result_seData1['EMPLOYEECODE']."' AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) = '" . $result_seData1['CREATEDATE'] . "'
                        ) A
                    WHERE
                        RowNum = 8";
                    $params_seData1_8 = array();
                    $query_seData1_8 = sqlsrv_query($conn, $sql_seData1_8, $params_seData1_8);
                    $result_seData1_8 = sqlsrv_fetch_array($query_seData1_8, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seData1_9 = "SELECT *
                    FROM
                        (
                            SELECT
                                ROW_NUMBER () OVER (ORDER BY [COVIDCHECKINID]) AS RowNum,CONVERT(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATETIME', a.[ADDRESS]
                            FROM
                                [COVIDCHECKIN] a
                                    WHERE a.[EMPLOYEECODE] = '".$result_seData1['EMPLOYEECODE']."' AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) = '" . $result_seData1['CREATEDATE'] . "'
                        ) A
                    WHERE
                        RowNum = 9";
                    $params_seData1_9 = array();
                    $query_seData1_9 = sqlsrv_query($conn, $sql_seData1_9, $params_seData1_9);
                    $result_seData1_9 = sqlsrv_fetch_array($query_seData1_9, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seData1_10 = "SELECT *
                    FROM
                        (
                            SELECT
                                ROW_NUMBER () OVER (ORDER BY [COVIDCHECKINID]) AS RowNum,CONVERT(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATETIME', a.[ADDRESS]
                            FROM
                                [COVIDCHECKIN] a
                                    WHERE a.[EMPLOYEECODE] = '".$result_seData1['EMPLOYEECODE']."' AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) = '" . $result_seData1['CREATEDATE'] . "'
                        ) A
                    WHERE
                        RowNum = 10";
                    $params_seData1_10 = array();
                    $query_seData1_10 = sqlsrv_query($conn, $sql_seData1_10, $params_seData1_10);
                    $result_seData1_10 = sqlsrv_fetch_array($query_seData1_10, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seData1_11 = "SELECT *
                    FROM
                        (
                            SELECT
                                ROW_NUMBER () OVER (ORDER BY [COVIDCHECKINID]) AS RowNum,CONVERT(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATETIME', a.[ADDRESS]
                            FROM
                                [COVIDCHECKIN] a
                                    WHERE a.[EMPLOYEECODE] = '".$result_seData1['EMPLOYEECODE']."' AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) = '" . $result_seData1['CREATEDATE'] . "'
                        ) A
                    WHERE
                        RowNum = 11";
                    $params_seData1_11 = array();
                    $query_seData1_11 = sqlsrv_query($conn, $sql_seData1_11, $params_seData1_11);
                    $result_seData1_11 = sqlsrv_fetch_array($query_seData1_11, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seData1_12 = "SELECT *
                    FROM
                        (
                            SELECT
                                ROW_NUMBER () OVER (ORDER BY [COVIDCHECKINID]) AS RowNum,CONVERT(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATETIME', a.[ADDRESS]
                            FROM
                                [COVIDCHECKIN] a
                                    WHERE a.[EMPLOYEECODE] = '".$result_seData1['EMPLOYEECODE']."' AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) = '" . $result_seData1['CREATEDATE'] . "'
                        ) A
                    WHERE
                        RowNum = 12";
                    $params_seData1_12 = array();
                    $query_seData1_12 = sqlsrv_query($conn, $sql_seData1_12, $params_seData1_12);
                    $result_seData1_12 = sqlsrv_fetch_array($query_seData1_12, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seData1_13 = "SELECT *
                    FROM
                        (
                            SELECT
                                ROW_NUMBER () OVER (ORDER BY [COVIDCHECKINID]) AS RowNum,CONVERT(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATETIME', a.[ADDRESS]
                            FROM
                                [COVIDCHECKIN] a
                                    WHERE a.[EMPLOYEECODE] = '".$result_seData1['EMPLOYEECODE']."' AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) = '" . $result_seData1['CREATEDATE'] . "'
                        ) A
                    WHERE
                        RowNum = 13";
                    $params_seData1_13 = array();
                    $query_seData1_13 = sqlsrv_query($conn, $sql_seData1_13, $params_seData1_13);
                    $result_seData1_13 = sqlsrv_fetch_array($query_seData1_13, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seData1_14 = "SELECT *
                    FROM
                        (
                            SELECT
                                ROW_NUMBER () OVER (ORDER BY [COVIDCHECKINID]) AS RowNum,CONVERT(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATETIME', a.[ADDRESS]
                            FROM
                                [COVIDCHECKIN] a
                                    WHERE a.[EMPLOYEECODE] = '".$result_seData1['EMPLOYEECODE']."' AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) = '" . $result_seData1['CREATEDATE'] . "'
                        ) A
                    WHERE
                        RowNum = 14";
                    $params_seData1_14 = array();
                    $query_seData1_14 = sqlsrv_query($conn, $sql_seData1_14, $params_seData1_14);
                    $result_seData1_14 = sqlsrv_fetch_array($query_seData1_14, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seData1_15 = "SELECT *
                    FROM
                        (
                            SELECT
                                ROW_NUMBER () OVER (ORDER BY [COVIDCHECKINID]) AS RowNum,CONVERT(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATETIME', a.[ADDRESS]
                            FROM
                                [COVIDCHECKIN] a
                                    WHERE a.[EMPLOYEECODE] = '".$result_seData1['EMPLOYEECODE']."' AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) = '" . $result_seData1['CREATEDATE'] . "'
                        ) A
                    WHERE
                        RowNum = 15";
                    $params_seData1_15 = array();
                    $query_seData1_15 = sqlsrv_query($conn, $sql_seData1_15, $params_seData1_15);
                    $result_seData1_15 = sqlsrv_fetch_array($query_seData1_15, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seData1_16 = "SELECT *
                    FROM
                        (
                            SELECT
                                ROW_NUMBER () OVER (ORDER BY [COVIDCHECKINID]) AS RowNum,CONVERT(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATETIME', a.[ADDRESS]
                            FROM
                                [COVIDCHECKIN] a
                                    WHERE a.[EMPLOYEECODE] = '".$result_seData1['EMPLOYEECODE']."' AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) = '" . $result_seData1['CREATEDATE'] . "'
                        ) A
                    WHERE
                        RowNum = 16";
                    $params_seData1_16 = array();
                    $query_seData1_16 = sqlsrv_query($conn, $sql_seData1_16, $params_seData1_16);
                    $result_seData1_16 = sqlsrv_fetch_array($query_seData1_16, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seData1_17 = "SELECT *
                    FROM
                        (
                            SELECT
                                ROW_NUMBER () OVER (ORDER BY [COVIDCHECKINID]) AS RowNum,CONVERT(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATETIME', a.[ADDRESS]
                            FROM
                                [COVIDCHECKIN] a
                                    WHERE a.[EMPLOYEECODE] = '".$result_seData1['EMPLOYEECODE']."' AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) = '" . $result_seData1['CREATEDATE'] . "'
                        ) A
                    WHERE
                        RowNum = 17";
                    $params_seData1_17 = array();
                    $query_seData1_17 = sqlsrv_query($conn, $sql_seData1_17, $params_seData1_17);
                    $result_seData1_17 = sqlsrv_fetch_array($query_seData1_17, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seData1_18 = "SELECT *
                    FROM
                        (
                            SELECT
                                ROW_NUMBER () OVER (ORDER BY [COVIDCHECKINID]) AS RowNum,CONVERT(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATETIME', a.[ADDRESS]
                            FROM
                                [COVIDCHECKIN] a
                                    WHERE a.[EMPLOYEECODE] = '".$result_seData1['EMPLOYEECODE']."' AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) = '" . $result_seData1['CREATEDATE'] . "'
                        ) A
                    WHERE
                        RowNum = 18";
                    $params_seData1_18 = array();
                    $query_seData1_18 = sqlsrv_query($conn, $sql_seData1_18, $params_seData1_18);
                    $result_seData1_18 = sqlsrv_fetch_array($query_seData1_18, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seData1_19 = "SELECT *
                    FROM
                        (
                            SELECT
                                ROW_NUMBER () OVER (ORDER BY [COVIDCHECKINID]) AS RowNum,CONVERT(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATETIME', a.[ADDRESS]
                            FROM
                                [COVIDCHECKIN] a
                                    WHERE a.[EMPLOYEECODE] = '".$result_seData1['EMPLOYEECODE']."' AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) = '" . $result_seData1['CREATEDATE'] . "'
                        ) A
                    WHERE
                        RowNum = 19";
                    $params_seData1_19 = array();
                    $query_seData1_19 = sqlsrv_query($conn, $sql_seData1_19, $params_seData1_19);
                    $result_seData1_19 = sqlsrv_fetch_array($query_seData1_19, SQLSRV_FETCH_ASSOC);
                    
                    $sql_seData1_20 = "SELECT *
                    FROM
                        (
                            SELECT
                                ROW_NUMBER () OVER (ORDER BY [COVIDCHECKINID]) AS RowNum,CONVERT(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATETIME', a.[ADDRESS]
                            FROM
                                [COVIDCHECKIN] a
                                    WHERE a.[EMPLOYEECODE] = '".$result_seData1['EMPLOYEECODE']."' AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) = '" . $result_seData1['CREATEDATE'] . "'
                        ) A
                    WHERE
                        RowNum = 20";
                    $params_seData1_20 = array();
                    $query_seData1_20 = sqlsrv_query($conn, $sql_seData1_20, $params_seData1_20);
                    $result_seData1_20 = sqlsrv_fetch_array($query_seData1_20, SQLSRV_FETCH_ASSOC);
                    if ($result_seData1['CREATEDATE'] == '') {
                        $color = " style='color: red' ";
                    } else {
                        $color = " style='color: black' ";
                    }
                    ?>

                    <tr <?= $color ?>>
                        <td style="border:1px solid #000;padding:4px;text-align: center"><?= $i ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1['CREATEDATE'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1['EMPLOYEECODE'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1['nameFL'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_1['CREATETIME'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_1['ADDRESS'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_2['CREATETIME'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_2['ADDRESS'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_3['CREATETIME'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_3['ADDRESS'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_4['CREATETIME'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_4['ADDRESS'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_5['CREATETIME'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_5['ADDRESS'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_6['CREATETIME'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_6['ADDRESS'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_7['CREATETIME'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_7['ADDRESS'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_8['CREATETIME'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_8['ADDRESS'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_9['CREATETIME'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_9['ADDRESS'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_10['CREATETIME'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_10['ADDRESS'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_11['CREATETIME'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_11['ADDRESS'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_12['CREATETIME'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_12['ADDRESS'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_13['CREATETIME'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_13['ADDRESS'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_14['CREATETIME'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_14['ADDRESS'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_15['CREATETIME'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_15['ADDRESS'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_16['CREATETIME'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_16['ADDRESS'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_17['CREATETIME'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_17['ADDRESS'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_18['CREATETIME'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_18['ADDRESS'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_19['CREATETIME'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_19['ADDRESS'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_20['CREATETIME'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData1_20['ADDRESS'] ?></td>

                    </tr>

                    <?php
                    $i++;
                }

                $i2 = $i;

                 $sql_seData2 = "SELECT a.PersonCode,a.FnameT+' '+a.LnameT AS 'FLnameT' FROM [dbo].[EMPLOYEEEHR] a
INNER JOIN [dbo].[ORGANIZATION] b ON a.PersonCode = b.EMPLOYEECODE
WHERE 1=1
AND a.FnameT+' '+a.LnameT = '".$_GET['employeecode']."'
AND a.PersonCode NOT IN (
(SELECT DISTINCT  a.[EMPLOYEECODE] FROM [dbo].[COVIDCHECKIN] a INNER JOIN [dbo].[ORGANIZATION] b ON a.EMPLOYEECODE = b.EMPLOYEECODE 
INNER JOIN [dbo].[EMPLOYEEEHR] c ON a.EMPLOYEECODE = c.PersonCode 
WHERE 1=1 
AND CONVERT(NVARCHAR(10),a.CREATEDATE,103) between '" . $_GET['datestart'] . "' and '" . $_GET['dateend'] . "'))";
                $params_seData2 = array();
                $query_seData2 = sqlsrv_query($conn, $sql_seData2, $params_seData2);
                while ($result_seData2 = sqlsrv_fetch_array($query_seData2, SQLSRV_FETCH_ASSOC)) {
                    ?>
                    <tr style="color: red">
                        <td style="border:1px solid #000;padding:4px;text-align: center"><?= $i2 ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData2['PersonCode'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left"><?= $result_seData2['FLnameT'] ?></td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>
                        <td style="border:1px solid #000;padding:4px;text-align: left">-</td>

                    </tr>
                    <?php
                    $i2++;
                }
                ?>



            </tbody>

        </table>
    </body>
</html>
