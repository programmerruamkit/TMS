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

$mpdf = new mPDF('th', 'A4', '0', '');
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
          
          
            <td colspan="6" style="border-right:1px solid #000;padding:3px;text-align:left;">
            <b>สรุปค่าเฉลี่ยนำมันประจำวันที่ ' . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ' </b>
            </td>
            <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>รวมสุทธิ</b>
            </td>
            <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>ยอดที่จ่ายจริง</b>
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
            <b>จำนวนเที่ยว</b>
            </td>
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>กิโลเมตร</b>
            </td>
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>ลูกค้า</b>
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
$sql_seCompoilaverage1 = "
                 SELECT DISTINCT THAINAME AS 'VEHICLEREGISNUMBER',CONVERT(NVARCHAR(10),DATEVLIN,103) AS 'JOBNODATE',JOBNO FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE SUBSTRING(JOBNO,1,3) = '" . $_GET['companycode'] . "' 
AND CONVERT(DATE,DATEVLIN,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) AND CUSTOMERCODE != 'STM'";

$query_seCompoilaverage1 = sqlsrv_query($conn, $sql_seCompoilaverage1, $params_seCompoilaverage1);
while ($result_seCompoilaverage1 = sqlsrv_fetch_array($query_seCompoilaverage1, SQLSRV_FETCH_ASSOC)) {
    $sql_seCompoilaverage2 = "SELECT DISTINCT a.JOBNO,(SELECT MILEAGENUMBER FROM [dbo].[MILEAGE]
WHERE VEHICLEREGISNUMBER = '" . $result_seCompoilaverage1['VEHICLEREGISNUMBER'] . "'
AND CONVERT(DATE,SUBSTRING(JOBNO, 5, 6),103) = CONVERT(DATE,'" . $result_seCompoilaverage1['JOBNODATE'] . "',103)
AND CREATEDATE =
(SELECT TOP 1 CREATEDATE FROM [dbo].[MILEAGE] WHERE JOBNO = '".$result_seCompoilaverage1['JOBNO']."' AND VEHICLEREGISNUMBER = '" . $result_seCompoilaverage1['VEHICLEREGISNUMBER'] . "' AND CONVERT(DATE,SUBSTRING(JOBNO, 5, 6),103) = CONVERT(DATE,'" . $result_seCompoilaverage1['JOBNODATE'] . "',103) AND MILEAGETYPE = 'MILEAGESTART' ORDER BY CREATEDATE DESC)
AND MILEAGETYPE = 'MILEAGESTART'
) AS 'MILEAGESTART',
(SELECT MILEAGENUMBER FROM [dbo].[MILEAGE]
WHERE VEHICLEREGISNUMBER = '" . $result_seCompoilaverage1['VEHICLEREGISNUMBER'] . "'
AND CONVERT(DATE,SUBSTRING(JOBNO, 5, 6),103) = CONVERT(DATE,'" . $result_seCompoilaverage1['JOBNODATE'] . "',103)
AND CREATEDATE =
(SELECT TOP 1 CREATEDATE FROM [dbo].[MILEAGE] WHERE JOBNO = '".$result_seCompoilaverage1['JOBNO']."' AND VEHICLEREGISNUMBER = '" . $result_seCompoilaverage1['VEHICLEREGISNUMBER'] . "' AND CONVERT(DATE,SUBSTRING(JOBNO, 5, 6),103) = CONVERT(DATE,'" . $result_seCompoilaverage1['JOBNODATE'] . "',103) AND MILEAGETYPE = 'MILEAGEEND' ORDER BY CREATEDATE DESC)
AND MILEAGETYPE = 'MILEAGEEND'
) AS 'MILEAGEEND',
((SELECT MILEAGENUMBER FROM [dbo].[MILEAGE]
WHERE VEHICLEREGISNUMBER = '" . $result_seCompoilaverage1['VEHICLEREGISNUMBER'] . "'
AND CONVERT(DATE,SUBSTRING(JOBNO, 5, 6),103) = CONVERT(DATE,'" . $result_seCompoilaverage1['JOBNODATE'] . "',103)
AND CREATEDATE =
(SELECT TOP 1 CREATEDATE FROM [dbo].[MILEAGE] WHERE JOBNO = '".$result_seCompoilaverage1['JOBNO']."' AND VEHICLEREGISNUMBER = '" . $result_seCompoilaverage1['VEHICLEREGISNUMBER'] . "' AND CONVERT(DATE,SUBSTRING(JOBNO, 5, 6),103) = CONVERT(DATE,'" . $result_seCompoilaverage1['JOBNODATE'] . "',103) AND MILEAGETYPE = 'MILEAGEEND' ORDER BY CREATEDATE DESC)
AND MILEAGETYPE = 'MILEAGEEND')
-
(SELECT MILEAGENUMBER FROM [dbo].[MILEAGE]
WHERE VEHICLEREGISNUMBER = '" . $result_seCompoilaverage1['VEHICLEREGISNUMBER'] . "'
AND CONVERT(DATE,SUBSTRING(JOBNO, 5, 6),103) = CONVERT(DATE,'" . $result_seCompoilaverage1['JOBNODATE'] . "',103)
AND CREATEDATE =
(SELECT TOP 1 CREATEDATE FROM [dbo].[MILEAGE] WHERE JOBNO = '".$result_seCompoilaverage1['JOBNO']."' AND VEHICLEREGISNUMBER = '" . $result_seCompoilaverage1['VEHICLEREGISNUMBER'] . "' AND CONVERT(DATE,SUBSTRING(JOBNO, 5, 6),103) = CONVERT(DATE,'" . $result_seCompoilaverage1['JOBNODATE'] . "',103) AND MILEAGETYPE = 'MILEAGESTART' ORDER BY CREATEDATE DESC)
AND MILEAGETYPE = 'MILEAGESTART')
)
AS 'KM'
FROM [dbo].[MILEAGE] a WHERE VEHICLEREGISNUMBER = '" . $result_seCompoilaverage1['VEHICLEREGISNUMBER'] . "' AND CONVERT(DATE,SUBSTRING(JOBNO, 5, 6),103) = CONVERT(DATE,'" . $result_seCompoilaverage1['JOBNODATE'] . "',103)";
    $query_seCompoilaverage2 = sqlsrv_query($conn, $sql_seCompoilaverage2, $params_seCompoilaverage2);
    $result_seCompoilaverage2 = sqlsrv_fetch_array($query_seCompoilaverage2, SQLSRV_FETCH_ASSOC);




    $sql_seCompoilaverage6 = "SELECT COUNT(*) AS 'CNT' FROM (
            SELECT  TOP 1 JOBSTART,JOBEND,EMPLOYEECODE1 AS 'EMPLOYEECODE',EMPLOYEENAME1 AS 'EMPLOYEENAME',CUSTOMERCODE FROM [dbo].[VEHICLETRANSPORTPLAN] 
            WHERE JOBNO = '" . $result_seCompoilaverage1['JOBNO'] . "' AND EMPLOYEECODE1 IS NOT NULL
            UNION 
            SELECT TOP 1 JOBSTART,JOBEND,EMPLOYEECODE2 AS 'EMPLOYEECODE',EMPLOYEENAME2 AS 'EMPLOYEENAME',CUSTOMERCODE FROM [dbo].[VEHICLETRANSPORTPLAN] 
            WHERE JOBNO = '" . $result_seCompoilaverage1['JOBNO'] . "' AND EMPLOYEECODE2 IS NOT NULL
            ) AS a";
    $query_seCompoilaverage6 = sqlsrv_query($conn, $sql_seCompoilaverage6, $params_seCompoilaverage6);
    $result_seCompoilaverage6 = sqlsrv_fetch_array($query_seCompoilaverage6, SQLSRV_FETCH_ASSOC);


    $sql_seCompoilaverage3 = "
                   SELECT  TOP 1 JOBSTART,JOBEND,EMPLOYEECODE1 AS 'EMPLOYEECODE',EMPLOYEENAME1 AS 'EMPLOYEENAME',CUSTOMERCODE,O4 FROM [dbo].[VEHICLETRANSPORTPLAN] 
                   WHERE JOBNO = '" . $result_seCompoilaverage1['JOBNO'] . "' AND EMPLOYEECODE1 IS NOT NULL 
UNION 
SELECT TOP 1 JOBSTART,JOBEND,EMPLOYEECODE2 AS 'EMPLOYEECODE',EMPLOYEENAME2 AS 'EMPLOYEENAME',CUSTOMERCODE,O4 FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE JOBNO = '" . $result_seCompoilaverage1['JOBNO'] . "' AND EMPLOYEECODE2 IS NOT NULL";



    $query_seCompoilaverage3 = sqlsrv_query($conn, $sql_seCompoilaverage3, $params_seCompoilaverage3);
    while ($result_seCompoilaverage3 = sqlsrv_fetch_array($query_seCompoilaverage3, SQLSRV_FETCH_ASSOC)) {

        $sql_seCompoilaverage4 = "
                   SELECT COUNT(*) AS 'CNT' FROM (SELECT DISTINCT THAINAME FROM [dbo].[VEHICLETRANSPORTPLAN]
WHERE CONVERT(DATE,DATEVLIN,103) = CONVERT(DATE,'" . $result_seCompoilaverage1['JOBNODATE'] . "',103)
AND THAINAME = '" . $result_seCompoilaverage1['VEHICLEREGISNUMBER'] . "' AND (EMPLOYEECODE1 = '" . $result_seCompoilaverage3['EMPLOYEECODE'] . "' OR EMPLOYEECODE2 = '" . $result_seCompoilaverage3['EMPLOYEECODE'] . "')) AS A";
        $query_seCompoilaverage4 = sqlsrv_query($conn, $sql_seCompoilaverage4, $params_seCompoilaverage4);
        $result_seCompoilaverage4 = sqlsrv_fetch_array($query_seCompoilaverage4, SQLSRV_FETCH_ASSOC);


        $sql_seCompoilaverage51 = "SELECT SUM(CONVERT(DECIMAL,C3)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE CONVERT(DATE,DATEVLIN) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
AND (EMPLOYEECODE1 = '" . $result_seCompoilaverage3['EMPLOYEECODE'] . "' OR EMPLOYEECODE2= '" . $result_seCompoilaverage3['EMPLOYEECODE'] . "') AND CONVERT(DECIMAL,C3) >= 0";
        $query_seCompoilaverage51 = sqlsrv_query($conn, $sql_seCompoilaverage51, $params_seCompoilaverage51);
        $result_seCompoilaverage51 = sqlsrv_fetch_array($query_seCompoilaverage51, SQLSRV_FETCH_ASSOC);
        $sql_seCompoilaverage52 = "SELECT SUM(CONVERT(DECIMAL,C3)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] 
WHERE CONVERT(DATE,DATEVLIN) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
AND (EMPLOYEECODE1 = '" . $result_seCompoilaverage3['EMPLOYEECODE'] . "' OR EMPLOYEECODE2= '" . $result_seCompoilaverage3['EMPLOYEECODE'] . "') AND CONVERT(DECIMAL,C3) < 0";
        $query_seCompoilaverage52 = sqlsrv_query($conn, $sql_seCompoilaverage52, $params_seCompoilaverage52);
        $result_seCompoilaverage52 = sqlsrv_fetch_array($query_seCompoilaverage52, SQLSRV_FETCH_ASSOC);
        
        
        if ($result_seCompoilaverage3['O4'] != '') {
            $resultseCompoilaverage51 = number_format($result_seCompoilaverage51['CNT'] / $result_seCompoilaverage6['CNT']);
            $resultseCompoilaverage52 = number_format($result_seCompoilaverage52['CNT'] / $result_seCompoilaverage6['CNT']);
            $sumresultseCompoilaverage = number_format((($result_seCompoilaverage51['CNT'] / $result_seCompoilaverage6['CNT']) - (($result_seCompoilaverage52['CNT'] / $result_seCompoilaverage6['CNT']) * -1)));
            $km = number_format($result_seCompoilaverage2['KM']);
        } else {
            $resultseCompoilaverage51 = "";
            $resultseCompoilaverage52 = "";
            $sumresultseCompoilaverage = "";
            $km = "";
        }


        $tr1 .= '
        <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $i . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . $result_seCompoilaverage3['EMPLOYEECODE'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . $result_seCompoilaverage3['EMPLOYEENAME'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . $result_seCompoilaverage4['CNT'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . $km . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . $result_seCompoilaverage3['CUSTOMERCODE'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . $resultseCompoilaverage51 . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . $resultseCompoilaverage52 . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . $sumresultseCompoilaverage . '</td>
        </tr>';
        $i++;
        $rscompoilaverage51 = $rscompoilaverage51 + ($result_seCompoilaverage51['CNT'] / $result_seCompoilaverage6['CNT']);
        $rscompoilaverage52 = $rscompoilaverage52 + ($result_seCompoilaverage52['CNT'] / $result_seCompoilaverage6['CNT']);
        $rscompoilaverage53 = $rscompoilaverage53 + (($result_seCompoilaverage51['CNT'] / $result_seCompoilaverage6['CNT']) - (($result_seCompoilaverage52['CNT'] / $result_seCompoilaverage6['CNT']) * -1));
    }
}
$tfooot1 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;" >
            <td style="border-right:1px solid #000;padding:3px;text-align:right;" colspan="6"><b>รวม</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>' . number_format($rscompoilaverage51) . '</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>' . number_format($rscompoilaverage52) . '</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>' . number_format($rscompoilaverage53) . '</b></td>
            
       </tr>
       <tr style="border:1px solid #000;" >
            <td style="border-right:1px solid #000;padding:3px;text-align:right;" colspan="6"><b>ยอดรวมทั้งสิ้น</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="2"><b>' . (number_format($rscompoilaverage51 - ($rscompoilaverage52 * -1))) . '</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>' . number_format($rscompoilaverage53) . '</b></td>
            
       </tr>
    </tfoot>';
$table_end1 = '</table>';




$table_begin = '
    <table style="width: 100%;font-size:18;">
    <thead>
        <tr>
            <td style="text-align:center"><b>บริษัท ' . $result_seComp['Company_NameT'] . ' จำกัด</b></td>
        </tr>
        <tr>
            <td style="text-align:center"><b>สรุปยอดเบิกค่าเฉลี่ยน้ำมัน วันที่ ' . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . '</b></td>
        </tr>
    </thead>
    
</table>
<br>
        <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16;">';

$tr = '<thead>
    
       <tr style="border:1px solid #000;background-color: #ccc" >
          
          
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>ลำดับ</b>
            </td>
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>บริษัท</b>
            </td>
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>จำนวนเงินเบิก</b>
            </td>
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>รวมยอดติดลบ</b>
            </td>
          
            
       </tr>
       
       
    </thead>';

$td .= '<tbody>
    <tr style="border:1px solid #000;" >
            <td style="border-right:1px solid #000;padding:3px;text-align:center;">1</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $result_seComp['Company_NameT'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . number_format(($rscompoilaverage51 - ($rscompoilaverage52 * -1))) . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . number_format($rscompoilaverage53) . '</td>
            
       </tr>
    </tbody>
    <tfoot>
    <tr style="border:1px solid #000;" >
            <td style="border-right:1px solid #000;padding:3px;text-align:right;" colspan="2"><b>รวมสุทธิ</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>' . number_format(($rscompoilaverage51 - ($rscompoilaverage52 * -1))) . '</b></td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>' . number_format($rscompoilaverage53) . '</b></td>
            
       </tr>
    </tfoot>';


$table_end = '</table>
    <br><br><br><br>
    <table width="100%" style="border-collapse: collapse;margin-top:8px;">
<tbody>
<tr >
        <td style="padding:4px;text-align:center;width:30%"><br />........................................<br /><br />(คุณ ' . $result_seEmployee['nameT'] . ') <br /><br />ผู้จัดทำ<br /><br />........../........../..........</td>
        <td style="padding:4px;text-align:center;width:30%"><br />........................................<br /><br />คุณ อุสาห์ ทองใบ<br /><br />ผู้ตรวจสอบ<br /><br />........../........../..........</td>
        <td style="padding:4px;text-align:center;width:30%"><br />........................................<br /><br />คุณนรินทร์ พิลึก<br /><br />ผู้ตรวจสอบ<br /><br />........../........../..........</td>
        <td style="padding:4px;text-align:center;width:35%"><br />........................................<br /><br />คุณอรัณย์ ศรีสุรรณ<br /><br />ผู้อนุมัติ<br /><br />........../........../..........</td>
    </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>';


$mpdf->WriteHTML($style);


$mpdf->WriteHTML($table_begin1);
$mpdf->WriteHTML($thead1);
$mpdf->WriteHTML($tr1);
$mpdf->WriteHTML($tfooot1);
$mpdf->WriteHTML($table_end1);
$mpdf->AddPage();
$mpdf->WriteHTML($table_begin);
$mpdf->WriteHTML($tr);
$mpdf->WriteHTML($td);
$mpdf->WriteHTML($table_end);

$mpdf->Output();

sqlsrv_close($conn);
?>

