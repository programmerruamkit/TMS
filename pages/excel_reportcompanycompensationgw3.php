<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");
$sumtotal = "";



$sql_getDate = "{call megGetdate_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$date = substr($_GET['datestart'], 3, 10);

$strExcelFileName = "รายงานค่าเที่ยว(บริษัท)ประจำเดือน" . $_GET['datestart'] . ".xls";


$companyth = 'บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด';
$companyen = 'Ruamkit Recycle Carrier Co., Ltd.';



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
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    </head>
    <body>
        <?= $companyth ?><br><?= $companyen ?>
        <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">

            <thead>
                <tr style="border:1px solid #000;background-color: #ccc">
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="57"><b>ค่าเที่ยวสายงาน GMT/TTAST</b></td>
                </tr>
                <tr style="border:1px solid #000;background-color: #ccc" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="57"><b>วันที่ <?= $_GET['datestart'] ?>  ถึง <?= $_GET['dateend'] ?></b></td>
                </tr>
                <tr style="border:1px solid #000;background-color: #ccc" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" rowspan="4"><b>NO.</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" rowspan="4"><b>รหัส</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" rowspan="4"><b>รายชื่อพนักงาน</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="18"><b>GMT</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="18"><b>TTAST</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="18"><b>TOTAL</b></td>


                </tr>

                <tr style="border:1px solid #000;background-color: #ccc" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="9"><b>จำนวนเที่ยว</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="9"><b>ค่าเที่ยว</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="9"><b>จำนวนเที่ยว</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="9"><b>ค่าเที่ยว</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="9"><b>จำนวนเที่ยว</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="9"><b>ค่าเที่ยว</b></td>
                </tr>
                <tr style="border:1px solid #000;background-color: #ccc" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3"><b>Extra</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3"><b>Nomal</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3"><b>Total</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3"><b>Extra</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3"><b>Nomal</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3"><b>Total</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3"><b>Extra</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3"><b>Nomal</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3"><b>Total</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3"><b>Extra</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3"><b>Nomal</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3"><b>Total</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3"><b>Extra</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3"><b>Nomal</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3"><b>Total</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3"><b>Extra</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3"><b>Nomal</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3"><b>Total</b></td>

                </tr>
                <tr style="border:1px solid #000;background-color: #ccc" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>1-10/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>11-20/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>21-<?= $result_getDate['ENDMONTH'] ?>/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>1-10/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>11-20/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>21-<?= $result_getDate['ENDMONTH'] ?>/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>1-10/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>11-20/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>21-<?= $result_getDate['ENDMONTH'] ?>/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>1-10/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>11-20/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>21-<?= $result_getDate['ENDMONTH'] ?>/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>1-10/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>11-20/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>21-<?= $result_getDate['ENDMONTH'] ?>/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>1-10/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>11-20/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>21-<?= $result_getDate['ENDMONTH'] ?>/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>1-10/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>11-20/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>21-<?= $result_getDate['ENDMONTH'] ?>/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>1-10/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>11-20/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>21-<?= $result_getDate['ENDMONTH'] ?>/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>1-10/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>11-20/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>21-<?= $result_getDate['ENDMONTH'] ?>/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>1-10/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>11-20/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>21-<?= $result_getDate['ENDMONTH'] ?>/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>1-10/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>11-20/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>21-<?= $result_getDate['ENDMONTH'] ?>/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>1-10/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>11-20/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>21-<?= $result_getDate['ENDMONTH'] ?>/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>1-10/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>11-20/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>21-<?= $result_getDate['ENDMONTH'] ?>/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>1-10/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>11-20/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>21-<?= $result_getDate['ENDMONTH'] ?>/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>1-10/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>11-20/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>21-<?= $result_getDate['ENDMONTH'] ?>/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>1-10/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>11-20/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>21-<?= $result_getDate['ENDMONTH'] ?>/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>1-10/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>11-20/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>21-<?= $result_getDate['ENDMONTH'] ?>/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>1-10/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>11-20/<?= $date ?></b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b>21-<?= $result_getDate['ENDMONTH'] ?>/<?= $date ?></b></td>



                </tr>


            </thead><tbody>
                <?php
                $i = 1;
                /* $sql_seEmp = "SELECT a.PersonCode ,a.FnameT+' '+a.LnameT AS 'FLnameT' FROM [203.150.225.30].[TigerE-HR].[dbo].[PNT_Person] a
                  INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].[COM_Company] b on a.CompanyID = b.ID_Company
                  WHERE 1=1 AND a.FnameT != 'ทดสอบ' AND a.PersonCode NOT IN
                  (SELECT PNT_Person.PersonCode
                  FROM [203.150.225.30].[TigerE-HR].[dbo].PNT_Resign
                  INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].PNM_ResignType ON PNT_Resign.ResignTypeID = PNM_ResignType.ResignTypeID
                  LEFT OUTER JOIN [203.150.225.30].[TigerE-HR].[dbo].PNT_Person ON PNT_Resign.PersonID = PNT_Person.PersonID
                  WHERE PNM_ResignType.ResignT !='เกษียณอายุ'
                  )
                  AND a.ResignStatus = '1'
                  AND a.ChkDeletePerson = '1'
                  AND a.FnameT+' '+a.LnameT NOT IN (SELECT [EMPLOYEENAMEF]+' '+[EMPLOYEENAMEL] FROM [203.150.225.30].[TigerE-HR].[dbo].EMPLOYEEOUT)
                  AND a.EndDate IS NULL AND b.Company_Code = '" . $_GET['companycode'] . "'"; */
                $sql_seEmp = "SELECT EMPLOYEECODE1,EMPLOYEENAME1 FROM (
                SELECT EMPLOYEECODE1,EMPLOYEENAME1 FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                AND (EMPLOYEECODE1 != '')
                GROUP BY EMPLOYEECODE1,EMPLOYEENAME1 
                UNION
                SELECT EMPLOYEECODE2,EMPLOYEENAME2 FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                AND (EMPLOYEECODE2 != '')
                GROUP BY EMPLOYEECODE2,EMPLOYEENAME2 )
                AS A GROUP BY EMPLOYEECODE1,EMPLOYEENAME1";
                $params_seEmp = array();
                //$result_getDate['ENDMONTH']
                //$date
                $query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
                while ($result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC)) {
                    $sql_seCntgmt1E110 = "SELECT COUNT(EMPLOYEECODE1) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'01/" . $date . "',103) AND CONVERT(DATE,'10/" . $date . "',103) 
                    AND (EMPLOYEECODE1 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'GMT'";
                    $params_seCntgmt1E110 = array();
                    $query_seCntgmt1E110 = sqlsrv_query($conn, $sql_seCntgmt1E110, $params_seCntgmt1E110);
                    $result_seCntgmt1E110 = sqlsrv_fetch_array($query_seCntgmt1E110, SQLSRV_FETCH_ASSOC);

                    $sql_seCntgmt1E120 = "SELECT COUNT(EMPLOYEECODE1) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'11/" . $date . "',103) AND CONVERT(DATE,'20/" . $date . "',103) 
                    AND (EMPLOYEECODE1 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'GMT'";
                    $params_seCntgmt1E120 = array();
                    $query_seCntgmt1E120 = sqlsrv_query($conn, $sql_seCntgmt1E120, $params_seCntgmt1E120);
                    $result_seCntgmt1E120 = sqlsrv_fetch_array($query_seCntgmt1E120, SQLSRV_FETCH_ASSOC);

                    $sql_seCntgmt1E130 = "SELECT COUNT(EMPLOYEECODE1) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'21/" . $date . "',103) AND CONVERT(DATE,'" . $result_getDate['ENDMONTH'] . '/' . $date . "',103) 
                    AND (EMPLOYEECODE1 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'GMT'";
                    $params_seCntgmt1E130 = array();
                    $query_seCntgmt1E130 = sqlsrv_query($conn, $sql_seCntgmt1E130, $params_seCntgmt1E130);
                    $result_seCntgmt1E130 = sqlsrv_fetch_array($query_seCntgmt1E130, SQLSRV_FETCH_ASSOC);

                    $sql_seCntgmt1E210 = "SELECT COUNT(EMPLOYEECODE2) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'01/" . $date . "',103) AND CONVERT(DATE,'10/" . $date . "',103) 
                    AND (EMPLOYEECODE2 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'GMT'";
                    $params_seCntgmt1E210 = array();
                    $query_seCntgmt1E210 = sqlsrv_query($conn, $sql_seCntgmt1E210, $params_seCntgmt1E210);
                    $result_seCntgmt1E210 = sqlsrv_fetch_array($query_seCntgmt1E210, SQLSRV_FETCH_ASSOC);

                    $sql_seCntgmt1E220 = "SELECT COUNT(EMPLOYEECODE2) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'11/" . $date . "',103) AND CONVERT(DATE,'20/" . $date . "',103) 
                    AND (EMPLOYEECODE2 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'GMT'";
                    $params_seCntgmt1E220 = array();
                    $query_seCntgmt1E220 = sqlsrv_query($conn, $sql_seCntgmt1E220, $params_seCntgmt1E220);
                    $result_seCntgmt1E220 = sqlsrv_fetch_array($query_seCntgmt1E220, SQLSRV_FETCH_ASSOC);

                    $sql_seCntgmt1E230 = "SELECT COUNT(EMPLOYEECODE2) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'21/" . $date . "',103) AND CONVERT(DATE,'" . $result_getDate['ENDMONTH'] . '/' . $date . "',103) 
                    AND (EMPLOYEECODE2 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'GMT'";
                    $params_seCntgmt1E230 = array();
                    $query_seCntgmt1E230 = sqlsrv_query($conn, $sql_seCntgmt1E230, $params_seCntgmt1E230);
                    $result_seCntgmt1E230 = sqlsrv_fetch_array($query_seCntgmt1E230, SQLSRV_FETCH_ASSOC);

                    /////////////////

                    $sql_seSumgmt1E110 = "SELECT SUM(CONVERT(INT,E1)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'01/" . $date . "',103) AND CONVERT(DATE,'10/" . $date . "',103) 
                    AND (EMPLOYEECODE1 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'GMT'";
                    $params_seSumgmt1E110 = array();
                    $query_seSumgmt1E110 = sqlsrv_query($conn, $sql_seSumgmt1E110, $params_seSumgmt1E110);
                    $result_seSumgmt1E110 = sqlsrv_fetch_array($query_seSumgmt1E110, SQLSRV_FETCH_ASSOC);

                    $sql_seSumgmt1E120 = "SELECT SUM(CONVERT(INT,E1)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'11/" . $date . "',103) AND CONVERT(DATE,'20/" . $date . "',103) 
                    AND (EMPLOYEECODE1 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'GMT'";
                    $params_seSumgmt1E120 = array();
                    $query_seSumgmt1E120 = sqlsrv_query($conn, $sql_seSumgmt1E120, $params_seSumgmt1E120);
                    $result_seSumgmt1E120 = sqlsrv_fetch_array($query_seSumgmt1E120, SQLSRV_FETCH_ASSOC);

                    $sql_seSumgmt1E130 = "SELECT SUM(CONVERT(INT,E1)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'21/" . $date . "',103) AND CONVERT(DATE,'" . $result_getDate['ENDMONTH'] . '/' . $date . "',103) 
                    AND (EMPLOYEECODE1 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'GMT'";
                    $params_seSumgmt1E130 = array();
                    $query_seSumgmt1E130 = sqlsrv_query($conn, $sql_seSumgmt1E130, $params_seSumgmt1E130);
                    $result_seSumgmt1E130 = sqlsrv_fetch_array($query_seSumgmt1E130, SQLSRV_FETCH_ASSOC);

                    $sql_seSumgmt1E210 = "SELECT SUM(CONVERT(INT,E2)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'01/" . $date . "',103) AND CONVERT(DATE,'10/" . $date . "',103) 
                    AND (EMPLOYEECODE2 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'GMT'";
                    $params_seSumgmt1E210 = array();
                    $query_seSumgmt1E210 = sqlsrv_query($conn, $sql_seSumgmt1E210, $params_seSumgmt1E210);
                    $result_seSumgmt1E210 = sqlsrv_fetch_array($query_seSumgmt1E210, SQLSRV_FETCH_ASSOC);

                    $sql_seSumgmt1E220 = "SELECT SUM(CONVERT(INT,E2)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'11/" . $date . "',103) AND CONVERT(DATE,'20/" . $date . "',103) 
                    AND (EMPLOYEECODE2 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'GMT'";
                    $params_seSumgmt1E220 = array();
                    $query_seSumgmt1E220 = sqlsrv_query($conn, $sql_seSumgmt1E220, $params_seSumgmt1E220);
                    $result_seSumgmt1E220 = sqlsrv_fetch_array($query_seSumgmt1E220, SQLSRV_FETCH_ASSOC);

                    $sql_seSumgmt1E230 = "SELECT SUM(CONVERT(INT,E2)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'21/" . $date . "',103) AND CONVERT(DATE,'" . $result_getDate['ENDMONTH'] . '/' . $date . "',103) 
                    AND (EMPLOYEECODE2 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'GMT'";
                    $params_seSumgmt1E230 = array();
                    $query_seSumgmt1E230 = sqlsrv_query($conn, $sql_seSumgmt1E230, $params_seSumgmt1E230);
                    $result_seSumgmt1E230 = sqlsrv_fetch_array($query_seSumgmt1E230, SQLSRV_FETCH_ASSOC);

                    ////
                    
                    $sql_seCntttast1E110 = "SELECT COUNT(EMPLOYEECODE1) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'01/" . $date . "',103) AND CONVERT(DATE,'10/" . $date . "',103) 
                    AND (EMPLOYEECODE1 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'TTAST'";
                    $params_seCntttast1E110 = array();
                    $query_seCntttast1E110 = sqlsrv_query($conn, $sql_seCntttast1E110, $params_seCntttast1E110);
                    $result_seCntttast1E110 = sqlsrv_fetch_array($query_seCntttast1E110, SQLSRV_FETCH_ASSOC);

                    $sql_seCntttast1E120 = "SELECT COUNT(EMPLOYEECODE1) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'11/" . $date . "',103) AND CONVERT(DATE,'20/" . $date . "',103) 
                    AND (EMPLOYEECODE1 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'TTAST'";
                    $params_seCntttast1E120 = array();
                    $query_seCntttast1E120 = sqlsrv_query($conn, $sql_seCntttast1E120, $params_seCntttast1E120);
                    $result_seCntttast1E120 = sqlsrv_fetch_array($query_seCntttast1E120, SQLSRV_FETCH_ASSOC);

                    $sql_seCntttast1E130 = "SELECT COUNT(EMPLOYEECODE1) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'21/" . $date . "',103) AND CONVERT(DATE,'" . $result_getDate['ENDMONTH'] . '/' . $date . "',103) 
                    AND (EMPLOYEECODE1 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'TTAST'";
                    $params_seCntttast1E130 = array();
                    $query_seCntttast1E130 = sqlsrv_query($conn, $sql_seCntttast1E130, $params_seCntttast1E130);
                    $result_seCntttast1E130 = sqlsrv_fetch_array($query_seCntttast1E130, SQLSRV_FETCH_ASSOC);

                    $sql_seCntttast1E210 = "SELECT COUNT(EMPLOYEECODE2) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'01/" . $date . "',103) AND CONVERT(DATE,'10/" . $date . "',103) 
                    AND (EMPLOYEECODE2 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'TTAST'";
                    $params_seCntttast1E210 = array();
                    $query_seCntttast1E210 = sqlsrv_query($conn, $sql_seCntttast1E210, $params_seCntttast1E210);
                    $result_seCntttast1E210 = sqlsrv_fetch_array($query_seCntttast1E210, SQLSRV_FETCH_ASSOC);

                    $sql_seCntttast1E220 = "SELECT COUNT(EMPLOYEECODE2) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'11/" . $date . "',103) AND CONVERT(DATE,'20/" . $date . "',103) 
                    AND (EMPLOYEECODE2 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'TTAST'";
                    $params_seCntttast1E220 = array();
                    $query_seCntttast1E220 = sqlsrv_query($conn, $sql_seCntttast1E220, $params_seCntttast1E220);
                    $result_seCntttast1E220 = sqlsrv_fetch_array($query_seCntttast1E220, SQLSRV_FETCH_ASSOC);

                    $sql_seCntttast1E230 = "SELECT COUNT(EMPLOYEECODE2) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'21/" . $date . "',103) AND CONVERT(DATE,'" . $result_getDate['ENDMONTH'] . '/' . $date . "',103) 
                    AND (EMPLOYEECODE2 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'TTAST'";
                    $params_seCntttast1E230 = array();
                    $query_seCntttast1E230 = sqlsrv_query($conn, $sql_seCntttast1E230, $params_seCntttast1E230);
                    $result_seCntttast1E230 = sqlsrv_fetch_array($query_seCntttast1E230, SQLSRV_FETCH_ASSOC);

                    /////////////////

                    $sql_seSumttast1E110 = "SELECT SUM(CONVERT(INT,E1)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'01/" . $date . "',103) AND CONVERT(DATE,'10/" . $date . "',103) 
                    AND (EMPLOYEECODE1 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'TTAST'";
                    $params_seSumttast1E110 = array();
                    $query_seSumttast1E110 = sqlsrv_query($conn, $sql_seSumttast1E110, $params_seSumttast1E110);
                    $result_seSumttast1E110 = sqlsrv_fetch_array($query_seSumttast1E110, SQLSRV_FETCH_ASSOC);

                    $sql_seSumttast1E120 = "SELECT SUM(CONVERT(INT,E1)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'11/" . $date . "',103) AND CONVERT(DATE,'20/" . $date . "',103) 
                    AND (EMPLOYEECODE1 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'TTAST'";
                    $params_seSumttast1E120 = array();
                    $query_seSumttast1E120 = sqlsrv_query($conn, $sql_seSumttast1E120, $params_seSumttast1E120);
                    $result_seSumttast1E120 = sqlsrv_fetch_array($query_seSumttast1E120, SQLSRV_FETCH_ASSOC);

                    $sql_seSumttast1E130 = "SELECT SUM(CONVERT(INT,E1)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'21/" . $date . "',103) AND CONVERT(DATE,'" . $result_getDate['ENDMONTH'] . '/' . $date . "',103) 
                    AND (EMPLOYEECODE1 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'TTAST'";
                    $params_seSumttast1E130 = array();
                    $query_seSumttast1E130 = sqlsrv_query($conn, $sql_seSumttast1E130, $params_seSumttast1E130);
                    $result_seSumttast1E130 = sqlsrv_fetch_array($query_seSumttast1E130, SQLSRV_FETCH_ASSOC);

                    $sql_seSumttast1E210 = "SELECT SUM(CONVERT(INT,E2)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'01/" . $date . "',103) AND CONVERT(DATE,'10/" . $date . "',103) 
                    AND (EMPLOYEECODE2 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'TTAST'";
                    $params_seSumttast1E210 = array();
                    $query_seSumttast1E210 = sqlsrv_query($conn, $sql_seSumttast1E210, $params_seSumttast1E210);
                    $result_seSumttast1E210 = sqlsrv_fetch_array($query_seSumttast1E210, SQLSRV_FETCH_ASSOC);

                    $sql_seSumttast1E220 = "SELECT SUM(CONVERT(INT,E2)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'11/" . $date . "',103) AND CONVERT(DATE,'20/" . $date . "',103) 
                    AND (EMPLOYEECODE2 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'TTAST'";
                    $params_seSumttast1E220 = array();
                    $query_seSumttast1E220 = sqlsrv_query($conn, $sql_seSumttast1E220, $params_seSumttast1E220);
                    $result_seSumttast1E220 = sqlsrv_fetch_array($query_seSumttast1E220, SQLSRV_FETCH_ASSOC);

                    $sql_seSumttast1E230 = "SELECT SUM(CONVERT(INT,E2)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'21/" . $date . "',103) AND CONVERT(DATE,'" . $result_getDate['ENDMONTH'] . '/' . $date . "',103) 
                    AND (EMPLOYEECODE2 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'TTAST'";
                    $params_seSumttast1E230 = array();
                    $query_seSumttast1E230 = sqlsrv_query($conn, $sql_seSumttast1E230, $params_seSumttast1E230);
                    $result_seSumttast1E230 = sqlsrv_fetch_array($query_seSumttast1E230, SQLSRV_FETCH_ASSOC);
                    //$sql_seCnt2E1 = "SELECT SUM(CONVERT(INT,E1)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    //AND CONVERT(DATE,DATEDEALERIN,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                    //AND (EMPLOYEECODE1 = '" . $result_seEmp['EMPLOYEECODE1'] . "' ) AND CUSTOMERCODE = 'GMT'";
                    //$params_seCnt2E1 = array();
                    //$query_seCnt2E1 = sqlsrv_query($conn, $sql_seCnt2E1, $params_seCnt2E1);
                    //$result_seCnt2E1 = sqlsrv_fetch_array($query_seCnt2E1, SQLSRV_FETCH_ASSOC);
                    ?>


                    <tr style="border:1px solid #000;" >

                        <td style="border-right:1px solid #000;padding:3px;text-align:center;"><?= $i ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seEmp['EMPLOYEECODE1'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seEmp['EMPLOYEENAME1'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCntgmt1E110['CNT'] + $result_seCntgmt1E210['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCntgmt1E120['CNT'] + $result_seCntgmt1E220['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCntgmt1E130['CNT'] + $result_seCntgmt1E230['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCntgmt1E110['CNT'] + $result_seCntgmt1E210['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCntgmt1E120['CNT'] + $result_seCntgmt1E220['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCntgmt1E130['CNT'] + $result_seCntgmt1E230['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seSumgmt1E110['CNT'] + $result_seSumgmt1E210['CNT']) ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seSumgmt1E120['CNT'] + $result_seSumgmt1E220['CNT']) ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seSumgmt1E130['CNT'] + $result_seSumgmt1E230['CNT']) ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seSumgmt1E110['CNT'] + $result_seSumgmt1E210['CNT']) ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seSumgmt1E120['CNT'] + $result_seSumgmt1E220['CNT']) ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seSumgmt1E130['CNT'] + $result_seSumgmt1E230['CNT']) ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCntttast1E110['CNT'] + $result_seCntttast1E210['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCntttast1E120['CNT'] + $result_seCntttast1E220['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCntttast1E130['CNT'] + $result_seCntttast1E230['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCntttast1E110['CNT'] + $result_seCntttast1E210['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCntttast1E120['CNT'] + $result_seCntttast1E220['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCntttast1E130['CNT'] + $result_seCntttast1E230['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seSumttast1E110['CNT'] + $result_seSumttast1E210['CNT']) ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seSumttast1E120['CNT'] + $result_seSumttast1E220['CNT']) ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seSumttast1E130['CNT'] + $result_seSumttast1E230['CNT']) ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seSumttast1E110['CNT'] + $result_seSumttast1E210['CNT']) ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seSumttast1E120['CNT'] + $result_seSumttast1E220['CNT']) ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seSumttast1E130['CNT'] + $result_seSumttast1E230['CNT']) ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCntgmt1E110['CNT'] + $result_seCntgmt1E210['CNT']+$result_seCntttast1E110['CNT'] + $result_seCntttast1E210['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCntgmt1E120['CNT'] + $result_seCntgmt1E220['CNT']+$result_seCntttast1E120['CNT'] + $result_seCntttast1E220['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCntgmt1E130['CNT'] + $result_seCntgmt1E230['CNT']+$result_seCntttast1E130['CNT'] + $result_seCntttast1E230['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCntgmt1E110['CNT'] + $result_seCntgmt1E210['CNT']+$result_seCntttast1E110['CNT'] + $result_seCntttast1E210['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCntgmt1E120['CNT'] + $result_seCntgmt1E220['CNT']+$result_seCntttast1E120['CNT'] + $result_seCntttast1E220['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCntgmt1E130['CNT'] + $result_seCntgmt1E230['CNT']+$result_seCntttast1E130['CNT'] + $result_seCntttast1E230['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seSumttast1E110['CNT'] + $result_seSumttast1E210['CNT']+$result_seSumttast1E110['CNT'] + $result_seSumttast1E210['CNT']) ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seSumttast1E120['CNT'] + $result_seSumttast1E220['CNT']+$result_seSumttast1E120['CNT'] + $result_seSumttast1E220['CNT']) ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seSumttast1E130['CNT'] + $result_seSumttast1E230['CNT']+$result_seSumttast1E130['CNT'] + $result_seSumttast1E230['CNT']) ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seSumttast1E110['CNT'] + $result_seSumttast1E210['CNT']+$result_seSumttast1E110['CNT'] + $result_seSumttast1E210['CNT']) ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seSumttast1E120['CNT'] + $result_seSumttast1E220['CNT']+$result_seSumttast1E120['CNT'] + $result_seSumttast1E220['CNT']) ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seSumttast1E130['CNT'] + $result_seSumttast1E230['CNT']+$result_seSumttast1E130['CNT'] + $result_seSumttast1E230['CNT']) ?></td>



                    </tr>

                    <?php
                    $i++;
                    $CNTSUMGMT110 = $CNTSUMGMT110 + ($result_seCntgmt1E110['CNT'] + $result_seCntgmt1E210['CNT']);
                    $CNTSUMGMT120 = $CNTSUMGMT120 + ($result_seCntgmt1E120['CNT'] + $result_seCntgmt1E220['CNT']);
                    $CNTSUMGMT130 = $CNTSUMGMT130 + ($result_seCntgmt1E130['CNT'] + $result_seCntgmt1E230['CNT']);
                    $CNTSUMGMT140 = $CNTSUMGMT140 + ($result_seSumgmt1E110['CNT'] + $result_seSumgmt1E210['CNT']);
                    $CNTSUMGMT150 = $CNTSUMGMT150 + ($result_seSumgmt1E120['CNT'] + $result_seSumgmt1E220['CNT']);
                    $CNTSUMGMT160 = $CNTSUMGMT160 + ($result_seSumgmt1E130['CNT'] + $result_seSumgmt1E230['CNT']);
                    $CNTSUMTTAST110 = $CNTSUMTTAST110 + ($result_seCntttast1E110['CNT'] + $result_seCntttast1E210['CNT']);
                    $CNTSUMTTAST120 = $CNTSUMTTAST120 + ($result_seCntttast1E120['CNT'] + $result_seCntttast1E220['CNT']);
                    $CNTSUMTTAST130 = $CNTSUMTTAST130 + ($result_seCntttast1E130['CNT'] + $result_seCntttast1E230['CNT']);
                    $CNTSUMTTAST140 = $CNTSUMTTAST140 + ($result_seSumttast1E110['CNT'] + $result_seSumttast1E210['CNT']);
                    $CNTSUMTTAST150 = $CNTSUMTTAST150 + ($result_seSumttast1E120['CNT'] + $result_seSumttast1E220['CNT']);
                    $CNTSUMTTAST160 = $CNTSUMTTAST160 + ($result_seSumttast1E130['CNT'] + $result_seSumttast1E230['CNT']);
                    $CNTSUMTOTAL110 = $CNTSUMTOTAL110 + ($result_seCntgmt1E110['CNT'] + $result_seCntgmt1E210['CNT']+$result_seCntttast1E110['CNT'] + $result_seCntttast1E210['CNT']);
                    $CNTSUMTOTAL120 = $CNTSUMTOTAL120 + ($result_seCntgmt1E120['CNT'] + $result_seCntgmt1E220['CNT']+$result_seCntttast1E120['CNT'] + $result_seCntttast1E220['CNT']);
                    $CNTSUMTOTAL130 = $CNTSUMTOTAL130 + ($result_seCntgmt1E130['CNT'] + $result_seCntgmt1E230['CNT']+$result_seCntttast1E130['CNT'] + $result_seCntttast1E230['CNT']);
                    $CNTSUMTOTAL140 = $CNTSUMTOTAL140 + ($result_seSumgmt1E110['CNT'] + $result_seSumgmt1E210['CNT']+$result_seSumttast1E110['CNT'] + $result_seSumttast1E210['CNT']);
                    $CNTSUMTOTAL150 = $CNTSUMTOTAL150 + ($result_seSumgmt1E120['CNT'] + $result_seSumgmt1E220['CNT']+$result_seSumttast1E120['CNT'] + $result_seSumttast1E220['CNT']);
                    $CNTSUMTOTAL160 = $CNTSUMTOTAL160 + ($result_seSumgmt1E130['CNT'] + $result_seSumgmt1E230['CNT']+$result_seSumttast1E130['CNT'] + $result_seSumttast1E230['CNT']);
                }
                ?>
                <tr style="border:1px solid #000;" >

                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3">รวม</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMGMT110) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMGMT120) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMGMT130) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMGMT110) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMGMT120) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMGMT130) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMGMT140) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMGMT150) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMGMT160) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMGMT140) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMGMT150) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMGMT160) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTTAST110) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTTAST120) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTTAST130) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTTAST110) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTTAST120) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTTAST130) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTTAST140) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTTAST150) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTTAST160) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTTAST140) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTTAST150) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTTAST160) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTOTAL110) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTOTAL120) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTOTAL130) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTOTAL110) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTOTAL120) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTOTAL130) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;">0</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTOTAL140) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTOTAL150) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTOTAL160) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTOTAL140) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTOTAL150) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUMTOTAL160) ?></td>
                    
                   

                </tr>

            </tbody>
        </table>


        <br><br><br><br>

        <table style="width: 50%;border:1px solid #000">
            <tbody>
                <tr style="border:1px solid #000;">

                    <td style="border:1px solid #000;padding:3px;text-align:center;" >ISSUE BY:</td>
                    <td style="border:1px solid #000;padding:3px;text-align:center;" >CHECK BY:</td>
                    <td style="border:1px solid #000;padding:3px;text-align:center;" >APPROVEBY:</td>
                </tr>
                <tr style="border:1px solid #000;height: 50px">
                    <td style="border:1px solid #000;padding:3px;text-align:center;" ></td>
                    <td style="border:1px solid #000;padding:3px;text-align:center;" ></td>
                    <td style="border:1px solid #000;padding:3px;text-align:center;" ></td>
                </tr>

                <tr style="border:1px solid #000;">
                    <td style="border:1px solid #000;padding:3px;text-align:center;" >(นางสาวพุทธิดา เสาวนา)<br>เจ้าหน้าที่การตลาดและ<br>วางแผนปฎิบัติการ</td>
                    <td style="border:1px solid #000;padding:3px;text-align:center;" >(นางสาวปรารถนา สุขพราย)<br>ผจก.แผนกการตลาดและ<br>การวางแผนปฎิบัติการ</td>
                    <td style="border:1px solid #000;padding:3px;text-align:center;" >(นายรัฐวุฒิ นิยมสุข)<br>รองผู้อำนวยการฝ่าย</td>
                </tr>

            </tbody>
        </table>

    </body>
</html>
