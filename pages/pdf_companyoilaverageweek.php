<?php

session_start();
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

$condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmployee = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
$result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);

$query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
$result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC);

$mpdf = new mPDF('th', 'A4-L', '0', '');
$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';


$table_begin1 = '
    <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">';

$thead1 = '<thead>
        <tr style="border:1px solid #000;background-color: #ccc" >
          
          
            <td colspan="3" style="border-right:1px solid #000;padding:3px;text-align:left;">
            <b>สรุปค่าเฉลี่ยนำมันวันที่ ' . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ' </b>
            </td>
            <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>จันทร์(' . $_GET['res1'] . ')</b>
            </td>
            <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>อังคาร(' . $_GET['res2'] . ')</b>
            </td>
            <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
           <b>พุธ(' . $_GET['res3'] . ')</b>
            </td>
             <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>พฤหัสบดี(' . $_GET['res4'] . ')</b>
            </td>
             <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>ศุกร์(' . $_GET['res5'] . ')</b>
            </td>
             <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เสาร์(' . $_GET['res6'] . ')</b>
            </td>
             <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>อาทิตย์(' . $_GET['res7'] . ')</b>
            </td>
             <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>รวมสุทธิ</b>
            </td>
            
           
            
          
            
       </tr>
       <tr style="border:1px solid #000;background-color: #ccc" >
          
          
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>ลำดับ</b>
            </td>
           
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>รหัสพนักงาน</b>
            </td>
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>ชื่อ-สกุล</b>
            </td>
             
           
            
             <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินบวก</b>
            </td>
             <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินลบ</b>
            </td>
             <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินบวก</b>
            </td>
             <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินลบ</b>
            </td>
             <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินบวก</b>
            </td>
             <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินลบ</b>
            </td>
             <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินบวก</b>
            </td>
             <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินลบ</b>
            </td>
             <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินบวก</b>
            </td>
             <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินลบ</b>
            </td>
             <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินบวก</b>
            </td>
             <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินลบ</b>
            </td>
             <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินบวก</b>
            </td>
             <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินลบ</b>
            </td>
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินบวก</b>
            </td>
             <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินลบ</b>
            </td>
            
           
          
            
       </tr>
       
       
    </thead><tbody>';
$i = 1;
$sql_seCompoilaverage1 = "SELECT  DISTINCT EMPLOYEECODE1 AS 'EMPLOYEECODE',EMPLOYEENAME1 AS 'EMPLOYEENAME',CUSTOMERCODE FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE CUSTOMERCODE != 'STM' AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CONVERT(DATE,DATEVLIN) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) AND EMPLOYEECODE1 IS NOT NULL
UNION 
SELECT DISTINCT EMPLOYEECODE2 AS 'EMPLOYEECODE',EMPLOYEENAME2 AS 'EMPLOYEENAME',CUSTOMERCODE FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE CUSTOMERCODE != 'STM' AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CONVERT(DATE,DATEVLIN) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) AND EMPLOYEECODE2 IS NOT NULL";

$query_seCompoilaverage1 = sqlsrv_query($conn, $sql_seCompoilaverage1, $params_seCompoilaverage1);
while ($result_seCompoilaverage1 = sqlsrv_fetch_array($query_seCompoilaverage1, SQLSRV_FETCH_ASSOC)) {
    $sql_seCompoilaverage21_p = "SELECT SUM(CONVERT(DECIMAL,C3)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE CONVERT(DATE,DATEVLIN,103) = CONVERT(DATE,'" . $_GET['res1'] . "',103) 
AND (EMPLOYEECODE1 = '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "' OR EMPLOYEECODE2= '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "') AND CONVERT(DECIMAL,C3) >= 0";
    $query_seCompoilaverage21_p = sqlsrv_query($conn, $sql_seCompoilaverage21_p, $params_seCompoilaverage21_p);
    $result_seCompoilaverage21_p = sqlsrv_fetch_array($query_seCompoilaverage21_p, SQLSRV_FETCH_ASSOC);
    $sql_seCompoilaverage21_n = "SELECT SUM(CONVERT(DECIMAL,C3)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE CONVERT(DATE,DATEVLIN,103) = CONVERT(DATE,'" . $_GET['res1'] . "',103)
AND (EMPLOYEECODE1 = '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "' OR EMPLOYEECODE2= '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "') AND CONVERT(DECIMAL,C3) < 0";
    $query_seCompoilaverage21_n = sqlsrv_query($conn, $sql_seCompoilaverage21_n, $params_seCompoilaverage21_n);
    $result_seCompoilaverage21_n = sqlsrv_fetch_array($query_seCompoilaverage21_n, SQLSRV_FETCH_ASSOC);

    $sql_seCompoilaverage22_p = "SELECT SUM(CONVERT(DECIMAL,C3)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE CONVERT(DATE,DATEVLIN,103) = CONVERT(DATE,'" . $_GET['res2'] . "',103) 
AND (EMPLOYEECODE1 = '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "' OR EMPLOYEECODE2= '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "') AND CONVERT(DECIMAL,C3) >= 0";
    $query_seCompoilaverage22_p = sqlsrv_query($conn, $sql_seCompoilaverage22_p, $params_seCompoilaverage22_p);
    $result_seCompoilaverage22_p = sqlsrv_fetch_array($query_seCompoilaverage22_p, SQLSRV_FETCH_ASSOC);
    $sql_seCompoilaverage22_n = "SELECT SUM(CONVERT(DECIMAL,C3)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE CONVERT(DATE,DATEVLIN,103) = CONVERT(DATE,'" . $_GET['res2'] . "',103)
AND (EMPLOYEECODE1 = '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "' OR EMPLOYEECODE2= '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "') AND CONVERT(DECIMAL,C3) < 0";
    $query_seCompoilaverage22_n = sqlsrv_query($conn, $sql_seCompoilaverage22_n, $params_seCompoilaverage22_n);
    $result_seCompoilaverage22_n = sqlsrv_fetch_array($query_seCompoilaverage22_n, SQLSRV_FETCH_ASSOC);

    $sql_seCompoilaverage23_p = "SELECT SUM(CONVERT(DECIMAL,C3)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE CONVERT(DATE,DATEVLIN,103) = CONVERT(DATE,'" . $_GET['res3'] . "',103) 
AND (EMPLOYEECODE1 = '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "' OR EMPLOYEECODE2= '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "') AND CONVERT(DECIMAL,C3) >= 0";
    $query_seCompoilaverage23_p = sqlsrv_query($conn, $sql_seCompoilaverage23_p, $params_seCompoilaverage23_p);
    $result_seCompoilaverage23_p = sqlsrv_fetch_array($query_seCompoilaverage23_p, SQLSRV_FETCH_ASSOC);
    $sql_seCompoilaverage23_n = "SELECT SUM(CONVERT(DECIMAL,C3)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE CONVERT(DATE,DATEVLIN,103) = CONVERT(DATE,'" . $_GET['res3'] . "',103)
AND (EMPLOYEECODE1 = '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "' OR EMPLOYEECODE2= '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "') AND CONVERT(DECIMAL,C3) < 0";
    $query_seCompoilaverage23_n = sqlsrv_query($conn, $sql_seCompoilaverage23_n, $params_seCompoilaverage23_n);
    $result_seCompoilaverage23_n = sqlsrv_fetch_array($query_seCompoilaverage23_n, SQLSRV_FETCH_ASSOC);

    $sql_seCompoilaverage24_p = "SELECT SUM(CONVERT(DECIMAL,C3)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE CONVERT(DATE,DATEVLIN,103) = CONVERT(DATE,'" . $_GET['res4'] . "',103) 
AND (EMPLOYEECODE1 = '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "' OR EMPLOYEECODE2= '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "') AND CONVERT(DECIMAL,C3) >= 0";
    $query_seCompoilaverage24_p = sqlsrv_query($conn, $sql_seCompoilaverage24_p, $params_seCompoilaverage24_p);
    $result_seCompoilaverage24_p = sqlsrv_fetch_array($query_seCompoilaverage24_p, SQLSRV_FETCH_ASSOC);
    $sql_seCompoilaverage24_n = "SELECT SUM(CONVERT(DECIMAL,C3)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE CONVERT(DATE,DATEVLIN,103) = CONVERT(DATE,'" . $_GET['res4'] . "',103)
AND (EMPLOYEECODE1 = '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "' OR EMPLOYEECODE2= '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "') AND CONVERT(DECIMAL,C3) < 0";
    $query_seCompoilaverage24_n = sqlsrv_query($conn, $sql_seCompoilaverage24_n, $params_seCompoilaverage24_n);
    $result_seCompoilaverage24_n = sqlsrv_fetch_array($query_seCompoilaverage24_n, SQLSRV_FETCH_ASSOC);

    $sql_seCompoilaverage25_p = "SELECT SUM(CONVERT(DECIMAL,C3)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE CONVERT(DATE,DATEVLIN,103) = CONVERT(DATE,'" . $_GET['res5'] . "',103) 
AND (EMPLOYEECODE1 = '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "' OR EMPLOYEECODE2= '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "') AND CONVERT(DECIMAL,C3) >= 0";
    $query_seCompoilaverage25_p = sqlsrv_query($conn, $sql_seCompoilaverage25_p, $params_seCompoilaverage25_p);
    $result_seCompoilaverage25_p = sqlsrv_fetch_array($query_seCompoilaverage25_p, SQLSRV_FETCH_ASSOC);
    $sql_seCompoilaverage25_n = "SELECT SUM(CONVERT(DECIMAL,C3)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE CONVERT(DATE,DATEVLIN,103) = CONVERT(DATE,'" . $_GET['res5'] . "',103)
AND (EMPLOYEECODE1 = '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "' OR EMPLOYEECODE2= '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "') AND CONVERT(DECIMAL,C3) < 0";
    $query_seCompoilaverage25_n = sqlsrv_query($conn, $sql_seCompoilaverage25_n, $params_seCompoilaverage25_n);
    $result_seCompoilaverage25_n = sqlsrv_fetch_array($query_seCompoilaverage25_n, SQLSRV_FETCH_ASSOC);

    $sql_seCompoilaverage26_p = "SELECT SUM(CONVERT(DECIMAL,C3)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE CONVERT(DATE,DATEVLIN,103) = CONVERT(DATE,'" . $_GET['res6'] . "',103) 
AND (EMPLOYEECODE1 = '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "' OR EMPLOYEECODE2= '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "') AND CONVERT(DECIMAL,C3) >= 0";
    $query_seCompoilaverage26_p = sqlsrv_query($conn, $sql_seCompoilaverage26_p, $params_seCompoilaverage26_p);
    $result_seCompoilaverage26_p = sqlsrv_fetch_array($query_seCompoilaverage26_p, SQLSRV_FETCH_ASSOC);
    $sql_seCompoilaverage26_n = "SELECT SUM(CONVERT(DECIMAL,C3)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE CONVERT(DATE,DATEVLIN,103) = CONVERT(DATE,'" . $_GET['res6'] . "',103)
AND (EMPLOYEECODE1 = '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "' OR EMPLOYEECODE2= '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "') AND CONVERT(DECIMAL,C3) < 0";
    $query_seCompoilaverage26_n = sqlsrv_query($conn, $sql_seCompoilaverage26_n, $params_seCompoilaverage26_n);
    $result_seCompoilaverage26_n = sqlsrv_fetch_array($query_seCompoilaverage26_n, SQLSRV_FETCH_ASSOC);

    $sql_seCompoilaverage27_p = "SELECT SUM(CONVERT(DECIMAL,C3)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE CONVERT(DATE,DATEVLIN,103) = CONVERT(DATE,'" . $_GET['res7'] . "',103) 
AND (EMPLOYEECODE1 = '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "' OR EMPLOYEECODE2= '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "') AND CONVERT(DECIMAL,C3) >= 0";
    $query_seCompoilaverage27_p = sqlsrv_query($conn, $sql_seCompoilaverage27_p, $params_seCompoilaverage27_p);
    $result_seCompoilaverage27_p = sqlsrv_fetch_array($query_seCompoilaverage27_p, SQLSRV_FETCH_ASSOC);
    $sql_seCompoilaverage27_n = "SELECT SUM(CONVERT(DECIMAL,C3)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE CONVERT(DATE,DATEVLIN,103) = CONVERT(DATE,'" . $_GET['res7'] . "',103)
AND (EMPLOYEECODE1 = '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "' OR EMPLOYEECODE2= '" . $result_seCompoilaverage1['EMPLOYEECODE'] . "') AND CONVERT(DECIMAL,C3) < 0";
    $query_seCompoilaverage27_n = sqlsrv_query($conn, $sql_seCompoilaverage27_n, $params_seCompoilaverage27_n);
    $result_seCompoilaverage27_n = sqlsrv_fetch_array($query_seCompoilaverage27_n, SQLSRV_FETCH_ASSOC);

    $tr1 .= '
        <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $i . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . $result_seCompoilaverage1['EMPLOYEECODE'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . $result_seCompoilaverage1['EMPLOYEENAME'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seCompoilaverage21_p['CNT']) . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seCompoilaverage21_n['CNT']) . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seCompoilaverage22_p['CNT']) . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seCompoilaverage22_n['CNT']) . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seCompoilaverage23_p['CNT']) . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seCompoilaverage23_n['CNT']) . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seCompoilaverage24_p['CNT']) . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seCompoilaverage24_n['CNT']) . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seCompoilaverage25_p['CNT']) . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seCompoilaverage25_n['CNT']) . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seCompoilaverage26_p['CNT']) . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seCompoilaverage26_n['CNT']) . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seCompoilaverage27_p['CNT']) . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seCompoilaverage27_n['CNT']) . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . (number_format((int) $result_seCompoilaverage21_p['CNT'] + (int) $result_seCompoilaverage22_p['CNT'] + (int) $result_seCompoilaverage23_p['CNT'] + (int) $result_seCompoilaverage24_p['CNT'] + (int) $result_seCompoilaverage25_p['CNT'] + (int) $result_seCompoilaverage26_p['CNT'] + (int) $result_seCompoilaverage27_p['CNT'])) . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . (number_format((int) $result_seCompoilaverage21_n['CNT'] + (int) $result_seCompoilaverage22_n['CNT'] + (int) $result_seCompoilaverage23_n['CNT'] + (int) $result_seCompoilaverage24_n['CNT'] + (int) $result_seCompoilaverage25_n['CNT'] + (int) $result_seCompoilaverage26_n['CNT'] + (int) $result_seCompoilaverage27_n['CNT'])) . '</td>
            </tr>';
    $i++;
}

$tfooot1 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;" >
            <td style="border-right:1px solid #000;padding:3px;text-align:right;" colspan="3"><b>รวม</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>-</b></td>
            
            
       </tr>
       <tr style="border:1px solid #000;" >
            <td style="border-right:1px solid #000;padding:3px;text-align:right;" colspan="3"><b>ยอดรวมทั้งสิ้น</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="2"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="2"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="2"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="2"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="2"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="2"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="2"><b>-</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="2"><b>-</b></td>
            
       </tr>
    </tfoot>';
$table_end1 = '</table>';



$mpdf->WriteHTML($style);


$mpdf->WriteHTML($table_begin1);
$mpdf->WriteHTML($thead1);
$mpdf->WriteHTML($tr1);
$mpdf->WriteHTML($tfooot1);
$mpdf->WriteHTML($table_end1);

$mpdf->Output();

sqlsrv_close($conn);
?>

