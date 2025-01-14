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


$strExcelFileName = "รายงานค่าเที่ยว(บริษัท)ประจำเดือน" . $_GET['datestart'] . ".xls";


$companyth = ($_GET['companycode'] == 'RCC') ? 'บริษัท  ร่วมกิจรุ่งเรือง คาร์ แคริเออร์  จำกัด' : 'บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต จำกัด';
$companyen = ($_GET['companycode'] == 'RCC') ? 'Ruamkit Rungrueng Car Carrier Co., Ltd.' : 'Ruamkit  Automotive Transport Co., Ltd.';
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
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="11"><b>ค่าเที่ยว 3/4 LOADS TTT</b></td>
                </tr>
                <tr style="border:1px solid #000;background-color: #ccc" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="11"><b>วันที่  01/<?= $_GET['datestart'] ?>  ถึง <?= $result_getDate['ENDMONTH'] ?>/<?= $_GET['datestart'] ?></b></td>
                </tr>
                <tr style="border:1px solid #000;background-color: #ccc" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" rowspan="2"><b>NO.</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" rowspan="2"><b>รหัส</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" rowspan="2"><b>รายชื่อพนักงาน</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="2"><b>1-10/06/2563</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="2"><b>11-20/06/2563</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="2"><b>21-<?= $result_getDate['ENDMONTH'] ?>/06/2563</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="2"><b>รวม</b></td>

                </tr>

                <tr style="border:1px solid #000;background-color: #ccc" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>จำนวนเที่ยว</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ค่าเที่ยว</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>จำนวนเที่ยว</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ค่าเที่ยว</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>จำนวนเที่ยว</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ค่าเที่ยว</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>จำนวนเที่ยว</b></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ค่าเที่ยว</b></td>
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
                AND CONVERT(DATE,DATERK,103) BETWEEN CONVERT(DATE,'01/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $result_getDate['ENDMONTH'] . "/" . $_GET['datestart'] . "',103) 
                AND (EMPLOYEECODE1 != '')
                GROUP BY EMPLOYEECODE1,EMPLOYEENAME1 
                UNION
                SELECT EMPLOYEECODE2,EMPLOYEENAME2 FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                AND CONVERT(DATE,DATERK,103) BETWEEN CONVERT(DATE,'01/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $result_getDate['ENDMONTH'] . "/" . $_GET['datestart'] . "',103) 
                AND (EMPLOYEECODE2 != '')
                GROUP BY EMPLOYEECODE2,EMPLOYEENAME2 )
                AS A GROUP BY EMPLOYEECODE1,EMPLOYEENAME1";
                $params_seEmp = array();
                $query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
                while ($result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC)) {
                    $sql_seCnt1E1 = "SELECT COUNT(EMPLOYEECODE1) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATERK,103) BETWEEN CONVERT(DATE,'01/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'10/" . $_GET['datestart'] . "',103) 
                    AND (EMPLOYEECODE1 = '" . $result_seEmp['EMPLOYEECODE1'] . "' )";
                    $params_seCnt1E1 = array();
                    $query_seCnt1E1 = sqlsrv_query($conn, $sql_seCnt1E1, $params_seCnt1E1);
                    $result_seCnt1E1 = sqlsrv_fetch_array($query_seCnt1E1, SQLSRV_FETCH_ASSOC);

                    $sql_seCnt1E2 = "SELECT COUNT(EMPLOYEECODE2) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATERK,103) BETWEEN CONVERT(DATE,'01/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'10/" . $_GET['datestart'] . "',103) 
                    AND (EMPLOYEECODE2 = '" . $result_seEmp['EMPLOYEECODE1'] . "')";
                    $params_seCnt1E2 = array();
                    $query_seCnt1E2 = sqlsrv_query($conn, $sql_seCnt1E2, $params_seCnt1E2);
                    $result_seCnt1E2 = sqlsrv_fetch_array($query_seCnt1E2, SQLSRV_FETCH_ASSOC);

                    $sql_seCnt2E1 = "SELECT SUM(CONVERT(INT,E1)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATERK,103) BETWEEN CONVERT(DATE,'01/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'10/" . $_GET['datestart'] . "',103) 
                    AND (EMPLOYEECODE1 = '" . $result_seEmp['EMPLOYEECODE1'] . "' )";
                    $params_seCnt2E1 = array();
                    $query_seCnt2E1 = sqlsrv_query($conn, $sql_seCnt2E1, $params_seCnt2E1);
                    $result_seCnt2E1 = sqlsrv_fetch_array($query_seCnt2E1, SQLSRV_FETCH_ASSOC);

                    $sql_seCnt2E2 = "SELECT SUM(CONVERT(INT,E2)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATERK,103) BETWEEN CONVERT(DATE,'01/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'10/" . $_GET['datestart'] . "',103) 
                    AND (EMPLOYEECODE2 = '" . $result_seEmp['EMPLOYEECODE1'] . "')";
                    $params_seCnt2E2 = array();
                    $query_seCnt2E2 = sqlsrv_query($conn, $sql_seCnt2E2, $params_seCnt2E2);
                    $result_seCnt2E2 = sqlsrv_fetch_array($query_seCnt2E2, SQLSRV_FETCH_ASSOC);
                    /////////////////////
                    $sql_seCnt3E1 = "SELECT COUNT(EMPLOYEECODE1) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATERK,103) BETWEEN CONVERT(DATE,'11/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'20/" . $_GET['datestart'] . "',103) 
                    AND (EMPLOYEECODE1 = '" . $result_seEmp['EMPLOYEECODE1'] . "' )";
                    $params_seCnt3E1 = array();
                    $query_seCnt3E1 = sqlsrv_query($conn, $sql_seCnt3E1, $params_seCnt3E1);
                    $result_seCnt3E1 = sqlsrv_fetch_array($query_seCnt3E1, SQLSRV_FETCH_ASSOC);

                    $sql_seCnt3E2 = "SELECT COUNT(EMPLOYEECODE2) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATERK,103) BETWEEN CONVERT(DATE,'11/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'20/" . $_GET['datestart'] . "',103) 
                    AND (EMPLOYEECODE2 = '" . $result_seEmp['EMPLOYEECODE1'] . "')";
                    $params_seCnt3E2 = array();
                    $query_seCnt3E2 = sqlsrv_query($conn, $sql_seCnt3E2, $params_seCnt3E2);
                    $result_seCnt3E2 = sqlsrv_fetch_array($query_seCnt3E2, SQLSRV_FETCH_ASSOC);

                    $sql_seCnt4E1 = "SELECT SUM(CONVERT(INT,E1)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATERK,103) BETWEEN CONVERT(DATE,'11/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'20/" . $_GET['datestart'] . "',103) 
                    AND (EMPLOYEECODE1 = '" . $result_seEmp['EMPLOYEECODE1'] . "' )";
                    $params_seCnt4E1 = array();
                    $query_seCnt4E1 = sqlsrv_query($conn, $sql_seCnt4E1, $params_seCnt4E1);
                    $result_seCnt4E1 = sqlsrv_fetch_array($query_seCnt4E1, SQLSRV_FETCH_ASSOC);

                    $sql_seCnt4E2 = "SELECT SUM(CONVERT(INT,E2)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATERK,103) BETWEEN CONVERT(DATE,'11/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'20/" . $_GET['datestart'] . "',103) 
                    AND (EMPLOYEECODE2 = '" . $result_seEmp['EMPLOYEECODE1'] . "')";
                    $params_seCnt4E2 = array();
                    $query_seCnt4E2 = sqlsrv_query($conn, $sql_seCnt4E2, $params_seCnt4E2);
                    $result_seCnt4E2 = sqlsrv_fetch_array($query_seCnt4E2, SQLSRV_FETCH_ASSOC);
                    /////////////////////
                    $sql_seCnt5E1 = "SELECT COUNT(EMPLOYEECODE1) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATERK,103) BETWEEN CONVERT(DATE,'21/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $result_getDate['ENDMONTH'] . "/" . $_GET['datestart'] . "',103) 
                    AND (EMPLOYEECODE1 = '" . $result_seEmp['EMPLOYEECODE1'] . "' )";
                    $params_seCnt5E1 = array();
                    $query_seCnt5E1 = sqlsrv_query($conn, $sql_seCnt5E1, $params_seCnt5E1);
                    $result_seCnt5E1 = sqlsrv_fetch_array($query_seCnt5E1, SQLSRV_FETCH_ASSOC);

                    $sql_seCnt5E2 = "SELECT COUNT(EMPLOYEECODE2) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATERK,103) BETWEEN CONVERT(DATE,'21/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $result_getDate['ENDMONTH'] . "/" . $_GET['datestart'] . "',103) 
                    AND (EMPLOYEECODE2 = '" . $result_seEmp['EMPLOYEECODE1'] . "')";
                    $params_seCnt5E2 = array();
                    $query_seCnt5E2 = sqlsrv_query($conn, $sql_seCnt5E2, $params_seCnt5E2);
                    $result_seCnt5E2 = sqlsrv_fetch_array($query_seCnt5E2, SQLSRV_FETCH_ASSOC);

                    $sql_seCnt6E1 = "SELECT SUM(CONVERT(INT,E1)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATERK,103) BETWEEN CONVERT(DATE,'21/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $result_getDate['ENDMONTH'] . "/" . $_GET['datestart'] . "',103) 
                    AND (EMPLOYEECODE1 = '" . $result_seEmp['EMPLOYEECODE1'] . "' )";
                    $params_seCnt6E1 = array();
                    $query_seCnt6E1 = sqlsrv_query($conn, $sql_seCnt6E1, $params_seCnt6E1);
                    $result_seCnt6E1 = sqlsrv_fetch_array($query_seCnt6E1, SQLSRV_FETCH_ASSOC);

                    $sql_seCnt6E2 = "SELECT SUM(CONVERT(INT,E2)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1 AND COMPANYCODE = '" . $_GET['companycode'] . "'
                    AND CONVERT(DATE,DATERK,103) BETWEEN CONVERT(DATE,'21/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $result_getDate['ENDMONTH'] . "/" . $_GET['datestart'] . "',103) 
                    AND (EMPLOYEECODE2 = '" . $result_seEmp['EMPLOYEECODE1'] . "')";
                    $params_seCnt6E2 = array();
                    $query_seCnt6E2 = sqlsrv_query($conn, $sql_seCnt6E2, $params_seCnt6E2);
                    $result_seCnt6E2 = sqlsrv_fetch_array($query_seCnt6E2, SQLSRV_FETCH_ASSOC);
                    ?>

                    <tr style="border:1px solid #000;" >

                        <td style="border-right:1px solid #000;padding:3px;text-align:center;"><?= $i ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seEmp['EMPLOYEECODE1'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seEmp['EMPLOYEENAME1'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCnt1E1['CNT'] + $result_seCnt1E2['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seCnt2E1['CNT'] + $result_seCnt2E2['CNT']) ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCnt3E1['CNT'] + $result_seCnt3E2['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seCnt4E1['CNT'] + $result_seCnt4E2['CNT']) ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCnt5E1['CNT'] + $result_seCnt5E2['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seCnt6E1['CNT'] + $result_seCnt6E2['CNT']) ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $result_seCnt1E1['CNT'] + $result_seCnt1E2['CNT'] + $result_seCnt3E1['CNT'] + $result_seCnt3E2['CNT'] + $result_seCnt5E1['CNT'] + $result_seCnt5E2['CNT'] ?></td>
                        <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($result_seCnt2E1['CNT'] + $result_seCnt2E2['CNT'] + $result_seCnt4E1['CNT'] + $result_seCnt4E2['CNT'] + $result_seCnt6E1['CNT'] + $result_seCnt6E2['CNT']) ?></td>

                    </tr>

    <?php
    $i++;
    $CNTSUM1 = $CNTSUM1 + ($result_seCnt1E1['CNT'] + $result_seCnt1E2['CNT']);
    $CNTSUM2 = $CNTSUM2 + ($result_seCnt2E1['CNT'] + $result_seCnt2E2['CNT']);
    $CNTSUM3 = $CNTSUM3 + ($result_seCnt3E1['CNT'] + $result_seCnt3E2['CNT']);
    $CNTSUM4 = $CNTSUM4 + ($result_seCnt4E1['CNT'] + $result_seCnt4E2['CNT']);
    $CNTSUM5 = $CNTSUM5 + ($result_seCnt5E1['CNT'] + $result_seCnt5E2['CNT']);
    $CNTSUM6 = $CNTSUM6 + ($result_seCnt6E1['CNT'] + $result_seCnt6E2['CNT']);
    $CNTSUM7 = $CNTSUM7 + ($result_seCnt1E1['CNT'] + $result_seCnt1E2['CNT'] + $result_seCnt3E1['CNT'] + $result_seCnt3E2['CNT'] + $result_seCnt5E1['CNT'] + $result_seCnt5E2['CNT']);
    $CNTSUM8 = $CNTSUM8 + ($result_seCnt2E1['CNT'] + $result_seCnt2E2['CNT'] + $result_seCnt4E1['CNT'] + $result_seCnt4E2['CNT'] + $result_seCnt6E1['CNT'] + $result_seCnt6E2['CNT']);
}
?>
                <tr style="border:1px solid #000;" >

                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3">รวม</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $CNTSUM1 ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUM2) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $CNTSUM3 ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUM4) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $CNTSUM5 ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUM6) ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= $CNTSUM7 ?></td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format($CNTSUM8) ?></td>

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
                    <td style="border:1px solid #000;padding:3px;text-align:center;" >(นางสาวอรชร อินทศรี)<br>เจ้าหน้าที่การตลาดและ<br>วางแผนปฎิบัติการ</td>
                    <td style="border:1px solid #000;padding:3px;text-align:center;" >(นางสาวปรารถนา สุขพราย)<br>ผจก.แผนกการตลาดและ<br>การวางแผนปฎิบัติการ</td>
                    <td style="border:1px solid #000;padding:3px;text-align:center;" >(นายรัฐวุฒิ นิยมสุข)<br>รองผู้อำนวยการฝ่าย</td>
                </tr>

            </tbody>
        </table>

    </body>
</html>
