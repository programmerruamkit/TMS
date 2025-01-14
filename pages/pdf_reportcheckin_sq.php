<?php

ini_set('memory_limit', '140M');
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
$conn = connect("RTMS");

// $condition2 = " AND Company_Code = '" . $_GET['companycode'] . "'";
// $sql_seComp = "{call megCompany_v2(?,?)}";
// $params_seComp = array(
//     array('select_company', SQLSRV_PARAM_IN),
//     array($condition2, SQLSRV_PARAM_IN)
// );
// $query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
// $result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC);

$mpdf = new mPDF('th', 'A4-L', '0', '');
$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';

$table_beginmorning1 = '<table width="100%" >
<tbody>
   <tr>
      <td colspan="6" style="text-align:center;font-size:24px"><b>รายงานตัวช่วงเทศกาลวันเข้าพรรษา (วันที่ 21 กรกฎาคม 2567 - 28 กรกฎาคม 2567)</b></td>
   </tr>
   <tr>
      <td colspan="6" style="text-align:center;font-size:24px"><b>ประจำวันที่ ' . $_GET['datestart'] . '</b></td>
   </tr>
</tbody>
</table>';

$table_beginmorning2 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">';
$trmorning = '<thead>
        <tr style="border:1px solid #000;" >
            <td colspan="8" style="border-right:1px solid #000;padding:3px;text-align:left;">
                <b>แผนก Transportation/Safety & Quality</b>
            </td>
            
        </tr>
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ลำดับ </b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>รหัสพนักงาน</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ชื่อ-สกุล</b>
            </td>
            <td rowspan="" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ละติจูด</b>
            </td>
            <td rowspan="" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ลองจิจูด
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ที่อยู่ในการเช็คอิน</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วันที่ในการเช็คอิน</b>
            </td>
            <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>สายงาน</b>
            </td>

        </tr>

    </thead>';


$i = 1;
$sumpallet = "";
$sumcompen = "";
$sumall = "";
$sumresult = "";

if ($_GET['area'] == 'amata') {
    $sql_sePlan = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,
        a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT,d.PositionNameT
        FROM [dbo].[ORGANIZATION] a 
        INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
        INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
        INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
        WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE ='03'
        AND a.AREA ='amata'
        AND d.EndDate IS NULL
        ORDER BY d.PositionNameT,a.EMPLOYEECODE ASC";
} else {
    $sql_sePlan = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,
        a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT,d.PositionNameT
        FROM [dbo].[ORGANIZATION] a 
        INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
        INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
        INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
        WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE ='03'
        AND a.AREA ='gateway'
        AND d.EndDate IS NULL
        ORDER BY d.PositionNameT,a.EMPLOYEECODE ASC";
}

$query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {


    $sql_seCheckIN = "SELECT TOP 1 LATIUDE AS 'LAT',LONGITUDE AS 'LONG',[ADDRESS] AS 'ADDRESS',CREATEDATE
                    ,CONVERT(NVARCHAR(10),CONVERT(DATETIME,CREATEDATE),103)+' '+CONVERT(NVARCHAR(5),CONVERT(TIME,CREATEDATE)) AS 'DATE' 
                    FROM [dbo].[NEWYEARCHECKIN]
                    WHERE EMPLOYEECODE ='" . $result_sePlan['EMPLOYEECODE'] . "'
                    AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,'" . $_GET['datestart'] . "',103)
                    --AND CONVERT(VARCHAR(5),CONVERT(DATETIME, CREATEDATE, 0), 108) BETWEEN '05:00:00' AND '12:59:00'
                    ORDER BY CREATEDATE DESC";
    $query_seCheckIN = sqlsrv_query($conn, $sql_seCheckIN, $params_seCheckIN);
    $result_seCheckIN = sqlsrv_fetch_array($query_seCheckIN, SQLSRV_FETCH_ASSOC);


    if ($result_seCheckIN['LAT'] == '' && $result_seCheckIN['LONG'] == '' && $result_seCheckIN['ADDRESS'] == '') {
        $color = "background-color: #FF9966";
    } else {
        $color = "";
    }
    $tdmorning .= '<tbody>
    <tr style="border:1px solid #000;" >
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;' . $color . '" >' . $i . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['EMPLOYEECODE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['nameT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LAT'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LONG'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['ADDRESS'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['DATE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['PositionNameT'] . '</td>
                  </tr>
                  </tbody>';







    $i++;
}
$table_endmorning = '</table>';

// // ช่วงบ่าย
// $table_beginafternoon1 = '<table width="100%" >
// <tbody>
//    <tr>
//       <td colspan="6" style="text-align:center;font-size:24px"><b>รายงานตัววันหยุดนักขัตฤกษ์ (ช่วงบ่าย 13.00-17.00)</b></td>
//    </tr>
//    <tr>
//       <td colspan="6" style="text-align:center;font-size:24px"><b>ประจำวันที่ ' . $_GET['datestart'] . '</b></td>
//    </tr>
// </tbody>
// </table>';

// $table_beginafternoon2 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">';
// $trafternoon = '<thead>
//         <tr style="border:1px solid #000;" >
//             <td colspan="8" style="border-right:1px solid #000;padding:3px;text-align:left;">
//                 <b>แผนก Transportation/Safety & Quality</b>
//             </td>
            
//         </tr>
//         <tr style="border:1px solid #000;background-color: #ccc" >
//             <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
//                 <b>ลำดับ </b>
//             </td>
//             <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
//                 <b>รหัสพนักงาน</b>
//             </td>
//             <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
//                 <b>ชื่อ-สกุล</b>
//             </td>
//             <td rowspan="" style="border-right:1px solid #000;padding:3px;text-align:center;">
//                 <b>ละติจูด</b>
//             </td>
//             <td rowspan="" style="border-right:1px solid #000;padding:3px;text-align:center;">
//                 <b>ลองจิจูด
//             </td>
//             <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
//                 <b>ที่อยู่ในการเช็คอิน</b>
//             </td>
//             <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
//                 <b>วันที่ในการเช็คอิน</b>
//             </td>
//             <td rowspan=""  style="border-right:1px solid #000;padding:3px;text-align:center;">
//                 <b>สายงาน</b>
//             </td>

//         </tr>

//     </thead>';


// $i = 1;
// $sumpallet = "";
// $sumcompen = "";
// $sumall = "";
// $sumresult = "";

// if ($_GET['area'] == 'amata') {
//     $sql_sePlan = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,
//         a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT,d.PositionNameT
//         FROM [dbo].[ORGANIZATION] a 
//         INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
//         INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
//         INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
//         WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE ='03'
//         AND a.AREA ='amata'
//         AND d.EndDate IS NULL
//         ORDER BY d.PositionNameT,a.EMPLOYEECODE ASC";
// } else {
//     $sql_sePlan = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,
//         a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT,d.PositionNameT
//         FROM [dbo].[ORGANIZATION] a 
//         INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
//         INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
//         INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
//         WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE ='03'
//         AND a.AREA ='gateway'
//         AND d.EndDate IS NULL
//         ORDER BY d.PositionNameT,a.EMPLOYEECODE ASC";
// }

// $query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
// while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {


//     $sql_seCheckIN = "SELECT TOP 1 LATIUDE AS 'LAT',LONGITUDE AS 'LONG',[ADDRESS] AS 'ADDRESS',CREATEDATE
//                     ,CONVERT(NVARCHAR(10),CONVERT(DATETIME,CREATEDATE),103)+' '+CONVERT(NVARCHAR(5),CONVERT(TIME,CREATEDATE)) AS 'DATE' 
//                     FROM [dbo].[NEWYEARCHECKIN]
//                     WHERE EMPLOYEECODE ='" . $result_sePlan['EMPLOYEECODE'] . "'
//                     AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,'" . $_GET['datestart'] . "',103)
//                     AND CONVERT(VARCHAR(5),CONVERT(DATETIME, CREATEDATE, 0), 108) BETWEEN '13:00:00' AND '18:00:00'
//                     ORDER BY CREATEDATE DESC";
//     $query_seCheckIN = sqlsrv_query($conn, $sql_seCheckIN, $params_seCheckIN);
//     $result_seCheckIN = sqlsrv_fetch_array($query_seCheckIN, SQLSRV_FETCH_ASSOC);


//     if ($result_seCheckIN['LAT'] == '' && $result_seCheckIN['LONG'] == '' && $result_seCheckIN['ADDRESS'] == '') {
//         $color = "background-color: #FF9966";
//     } else {
//         $color = "";
//     }
//     $tdafternoon .= '<tbody>
//     <tr style="border:1px solid #000;" >
//                     <td style="border-right:1px solid #000;padding:3px;text-align:center;' . $color . '" >' . $i . '</td>
//                     <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['EMPLOYEECODE'] . '</td>
//                     <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['nameT'] . '</td>
//                     <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LAT'] . '</td>
//                     <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['LONG'] . '</td>
//                     <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['ADDRESS'] . '</td>
//                     <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_seCheckIN['DATE'] . '</td>
//                     <td style="border-right:1px solid #000;padding:3px;text-align:left;' . $color . '" >' . $result_sePlan['PositionNameT'] . '</td>
//                   </tr>
//                   </tbody>';







//     $i++;
// }




// $table_endafternoon = '</table>';


$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_beginmorning1);
$mpdf->WriteHTML($table_beginmorning2);
$mpdf->WriteHTML($trmorning);
$mpdf->WriteHTML($tdmorning);
$mpdf->WriteHTML($table_endmorning);
// $mpdf->AddPage();
// $mpdf->WriteHTML($table_beginafternoon1);
// $mpdf->WriteHTML($table_beginafternoon2);
// $mpdf->WriteHTML($trafternoon);
// $mpdf->WriteHTML($tdafternoon);
// $mpdf->WriteHTML($table_endafternoon);
$mpdf->Output();



sqlsrv_close($conn);


