
<?php

require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
//$mpdf = new mPDF();
$mpdf = new mPDF('th', 'A4', '0', '');

//หารหัสจากชื่อ
$employee1 = " AND a.PersonCode = '" . $_GET['drivercode'] . "'";
$sql_seEmp1 = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmp1 = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($employee1, SQLSRV_PARAM_IN)
);
$query_seEmp1 = sqlsrv_query($conn, $sql_seEmp1, $params_seEmp1);
$result_seEmp1 = sqlsrv_fetch_array($query_seEmp1, SQLSRV_FETCH_ASSOC);


$employee = " AND a.PersonCode = '".$result_seEmp1['PersonCode']."'";
$sql_seEmp = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmp = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($employee, SQLSRV_PARAM_IN)
);
$query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
$result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC);

$employee1 = " AND a.PersonCode = '".$result_seEmp1['PersonCode']."'";
$sql_seLicenDate = "{call megEmployeeEHR_v2(?,?)}";
$params_seLicenDate = array(
    array('select_LicenceDate', SQLSRV_PARAM_IN),
    array($employee1, SQLSRV_PARAM_IN)
);
$query_seLicenDate = sqlsrv_query($conn, $sql_seLicenDate, $params_seLicenDate);
$result_seLicenDate = sqlsrv_fetch_array($query_seLicenDate, SQLSRV_FETCH_ASSOC);


$sql_seDep = "SELECT DISTINCT b.DEPARTMENTNAME,b.DEPARTMENTCODE,a.SECTIONCODE
FROM [dbo].[ORGANIZATION] a
INNER JOIN [dbo].[DEPARTMENT_NEW] b ON a.DEPARTMENTCODE = b.DEPARTMENTCODE AND a.COMPANYCODE = b.COMPANYCODE
WHERE a.EMPLOYEECODE = '".$result_seEmp1['PersonCode']."' ";
$query_seDep = sqlsrv_query($conn, $sql_seDep, $params_seDep);
$result_seDep = sqlsrv_fetch_array($query_seDep, SQLSRV_FETCH_ASSOC);

$sql_seSecID = "SELECT SECTIONID FROM [dbo].[SECTION_NEW]
WHERE  DEPARTMENTCODE = '".$result_seDep['DEPARTMENTCODE']."'
AND SECTIONCODE ='".$result_seDep['SECTIONCODE']."'";
$query_seSecID = sqlsrv_query($conn, $sql_seSecID, $params_seSecID);
$result_seSecID = sqlsrv_fetch_array($query_seSecID, SQLSRV_FETCH_ASSOC);


$sql_seSec = "SELECT b.SECTIONNAME FROM [dbo].[ORGANIZATION] a
INNER JOIN [dbo].SECTION_NEW b ON a.SECTIONCODE = b.SECTIONCODE
WHERE a.EMPLOYEECODE = '".$result_seEmp1['PersonCode']."'
AND a.DEPARTMENTCODE = '".$result_seDep['DEPARTMENTCODE']."'
AND b.SECTIONCODE ='".$result_seDep['SECTIONCODE']."'
AND b.SECTIONID ='".$result_seSecID['SECTIONID']."'";
$query_seSec = sqlsrv_query($conn, $sql_seSec, $params_seSec);
$result_seSec = sqlsrv_fetch_array($query_seSec, SQLSRV_FETCH_ASSOC);

//คำนวณหาวันทำงาน อายุงาน
$datework = $result_seEmp['StartWork'];
$dateechodatework = date_format($datework,"Y-m-d");

$birthdaywork = $dateechodatework;      
$todaywork = date("Y-m-d");   
  

list($byearwork, $bmonthwork, $bdaywork)= explode("-",$birthdaywork);      
list($tyearwork, $tmonthwork, $tdaywork)= explode("-",$todaywork);               
  
$mbirthdaywork = mktime(0, 0, 0, $bmonthwork, $bdaywork, $byearwork); 
$mnowwork = mktime(0, 0, 0, $tmonthwork, $tdaywork, $tyearwork );
$magework = ($mnowwork - $mbirthdaywork);

$u_ywork = date("Y", $magework)-1970;
$u_mwork = date("m",$magework)-1;
$u_dwork = date("d",$magework);

// $sql_seCountTraining = "SELECT COUNT(Patern_Name) AS 'COUNTTRAINING'
// FROM [203.150.225.30].[TigerE-HR].dbo.TN_Patern__Course a
// INNER JOIN [203.150.225.30].[TigerE-HR].dbo.TN_TrainPerson b ON b.Patern_ID = a.Patern_ID
// INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNT_Person c ON c.PersonID = b.PersonID
// INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNM_Position d ON d.PositionID = c.PositionID
// INNER JOIN [203.150.225.30].[TigerE-HR].dbo.COM_Company e ON e.ID_Company = c.CompanyID
// WHERE c.PersonCode ='".$_GET['employeecode']."'";
// $query_seCountTraining = sqlsrv_query($conn, $sql_seCountTraining, $params_seCountTraining);
// $result_seCountTraining = sqlsrv_fetch_array($query_seCountTraining, SQLSRV_FETCH_ASSOC);

$currentyear = date("Y");
$sql_seCountAccident = "SELECT  COUNT(ACCI_ID) AS 'COUNTACCI'
FROM [dbo].[ACCIDENTHISTORY]
WHERE DRIVERCODE ='".$_GET['drivercode']."'";
$query_seCountAccident = sqlsrv_query($conn, $sql_seCountAccident, $params_seCountAccident);
$result_seCountAccident = sqlsrv_fetch_array($query_seCountAccident, SQLSRV_FETCH_ASSOC);



$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';


$table1 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10px;margin-top:8px;">
<thead>
<tr style=" padding:4px;">
     <th colspan="6" style=" padding:4px;text-align:center;font-size:15px"><b>' . $result_seEmp['Company_NameT'] . '</b></th>
    </tr>
    <tr style=" padding:4px;">
     <th colspan="6" style=" padding:4px;text-align:center;font-size:13px"><b>รายงานข้อมูลพนักงาน</b></th>
    </tr>
    <tr style=" padding:4px;">
     <th colspan="2" style=" padding:4px;text-align:left;"><b>ฝ่าย : </b> '.$result_seDep['DEPARTMENTNAME'].' </th>
     <th colspan="2" style=" padding:4px;text-align:left;"><b>แผนก : </b> '.$result_seSec['SECTIONNAME'].' </th>
     <th colspan="2" style=" padding:4px;text-align:left;"><b>ระดับพักงาน : </b> '.$result_seEmp['PositionNameT'].' </th>
    </tr>
    </thead>';
    $table1 .= '<tbody>

    <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;" colspan="6"><hr /></td>
    </tr>
    <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;width: 15%">รหัสพนักงาน</td>
        <td style=" padding:4px;text-align:left;width: 20%">'.$result_seEmp['PersonCode'].'</td>
        <td style=" padding:4px;text-align:left;width: 15%">รหัสบัตรรูด</td>
        <td style=" padding:4px;text-align:left;width: 20%">'.$result_seEmp['PersonCode'].'</td>
        <td colspan="2" rowspan="7" style=" padding:4px;text-align:center;width: 15%"><img width="20%" src="../images/employee/'.$result_seEmp['PersonCode'].'.JPG"></td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">ชื่อ-สกุล(ไทย)</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['nameT'].'</td>
        <td style=" padding:4px;text-align:left;">เพศ</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['SexT'].'</td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">ชื่อ-สกุล(อังกฤษ)</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['nameE'].'</td>
        <td style=" padding:4px;text-align:left;">สถานภาพ</td>
        <td style=" padding:4px;text-align:left;">-</td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">ฝ่าย</td>
        <td style=" padding:4px;text-align:left;">'.$result_seDep['DEPARTMENTNAME'].' </td>
        <td style=" padding:4px;text-align:left;">วันเกิด</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['BirthDate103'].'</td>
      </tr>



      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">แผนก</td>
        <td style=" padding:4px;text-align:left;">'.$result_seSec['SECTIONNAME'].'</td>
        <td style=" padding:4px;text-align:left;">อายุ(ปี/เดือน/วัน)</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['yearb'].' ปี / '.$result_seEmp['monthb'].' เดือน / '.$result_seEmp['dayb'].' วัน</td>
      </tr>
       <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">ระดับพนักงาน</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['PositionNameT'].' </td>
        <td style=" padding:4px;text-align:left;">วันที่เริ่มงาน</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['StartDate'].'</td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">ตำแหน่ง</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['PositionNameOther'].'</td>
        <td style=" padding:4px;text-align:left;">วันที่บรรจุ</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['PassDate'].'</td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">เลขที่ใบขับขี่</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['CarLicenceID'].'</td>
        <td style=" padding:4px;text-align:left;">อายุงาน(ปี/เดือน/วัน)</td>
        <td style=" padding:4px;text-align:left;">'.$u_ywork.' ปี / '.$u_mwork.' เดือน / '.$u_dwork.' วัน</td>
        <td style=" padding:4px;text-align:left;"></td>
        <td style=" padding:4px;text-align:left;"></td>
      </tr>

      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;"></td>
        <td style=" padding:4px;text-align:left;"></td>
        <td style=" padding:4px;text-align:left;"></td>
        <td style=" padding:4px;text-align:left;"></td>
        <td style=" padding:4px;text-align:left;"></td>
        <td style=" padding:4px;text-align:left;"></td>
      </tr>
      <tr style="padding:4px;">
        <td style=" padding:4px;text-align:left;">วันอนุญาต</td>
        <td style=" padding:4px;text-align:left;">'.$result_seLicenDate['StartDate'].'</td>
      </tr>
      <tr style="padding:4px;">
        <td style=" padding:4px;text-align:left;">วันสิ้นอายุ</td>
        <td style=" padding:4px;text-align:left;">'.$result_seLicenDate['EndDate'].'</td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;" colspan="6"><hr /></td>
    </tr>
     <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;" colspan="6"></td>
    </tr>
</tbody></table>';
// ////////////////////////////////////////////////////////////////////////////////////////////////////
// ประวัติสุขภาพ
if ($result_seCountAccident['COUNTACCI'] > 0) {
  $table_header2 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="48" style="text-align:center;font-size:16px"><b>ข้อมูลอุบัติเหตุปี&#160;'.$_GET['yearstart'].' ถึง&#160; '.$_GET['yearend'].' </b></td>
        </tr>

    </thead>
</table>';
}else {
  $table_header2 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="48" style="text-align:center;font-size:16px"><b>ยังไม่มีข้อมูลอุบัติเหตุปี&#160;'.$_GET['yearstart'].' ถึง&#160; '.$_GET['yearend'].'</b></td>
        </tr>

    </thead>
</table>';
}


$table_begin2 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:10px;">';
$thead2 = '<thead>
      <tr  style="border:1px solid #000;padding:16px;">
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 15%;font-size:22px"><b>ลำดับ</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 30%;font-size:22px"><b>วันที่และเวลา</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 35%;font-size:22px"><b>สถานที่เกิดอุบัติเหตุ</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 35%;font-size:22px"><b>ปัญหาของอุบัติเหตุ</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 30%;font-size:22px"><b>MAN</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 30%;font-size:22px"><b>METHOD</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 30%;font-size:22px"><b>MECHINE</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 30%;font-size:22px"><b>ENVIRONMENT</b></td>
        
      </tr>
    </thead><tbody>';
    $iAccident = 1;
    
    $sql_seAccidentData = "SELECT DRIVERNAME,YEARS,CONVERT(VARCHAR(10),DATETIMEACCIDENT,103) AS 'DATE',
        CONVERT(VARCHAR(5),CONVERT(DATETIME, DATETIMEACCIDENT, 0), 108) AS 'TIME',
        DATETIMEACCIDENT,LOCATIONACCIDENT,PROBLEMACCIDENT,
        DETAILMAN,DETAILMETHOD,DETAILMECHINE,DETAILENVIRONMENT,REMARK,TYPEACCIDENT
        FROM ACCIDENTHISTORY
        WHERE DRIVERCODE = '".$_GET['drivercode']."'
        AND YEARS BETWEEN '".$_GET['yearstart']."' AND '".$_GET['yearend']."'
        ORDER BY YEARS,DATETIMEACCIDENT ASC";
    $params_seAccidentData = array();
    $query_seAccidentData = sqlsrv_query($conn, $sql_seAccidentData, $params_seAccidentData);
    while ($result_seAccidentData = sqlsrv_fetch_array($query_seAccidentData, SQLSRV_FETCH_ASSOC)) {
        // echo $result_sedataHealth['DIABETES'] == '0' ? 'UNCHECK'  : 'CHECK';
        $tbody2 .= '
        <tr style="border:1px solid #000;padding:16px;">
          <td style="border-right:1px solid #000;padding:16px;text-align:center;width: 15%;font-size:20px">'.$iAccident.'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 30%;font-size:20px">'.$result_seAccidentData['DATE'].' '.$result_seAccidentData['TIME'].'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 35%;font-size:20px">'.$result_seAccidentData['LOCATIONACCIDENT'].'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 35%;font-size:20px">'.$result_seAccidentData['PROBLEMACCIDENT'].'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 30%;font-size:20px">'.$result_seAccidentData['DETAILMAN'].'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 30%;font-size:20px">'.$result_seAccidentData['DETAILMETHOD'].'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 30%;font-size:20px">'.$result_seAccidentData['DETAILMECHINE'].'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 30%;font-size:20px">'.$result_seAccidentData['DETAILENVIRONMENT'].'</td>
          
        </tr>
        ';
      
      $iAccident++;
    }

$table_end2 = '</table>';


// ////////////////////////////////////////////////////////////////////////////////////////////////////
// // Training Data
// if ($result_seCountTraining['COUNTTRAINING'] > 0) {
//   $table_header3 = '<table style="width: 100%;">
//     <thead>
//         <tr>
//             <td colspan="48" style="text-align:center;font-size:16px"><b>Training Data</b></td>
//         </tr>

//     </thead>
// </table>';
// }else {
//   $table_header3 = '<table style="width: 100%;">
//     <thead>
//         <tr>
//             <td colspan="48" style="text-align:center;font-size:16px"><b>ยังไม่มีประวัติฝึกอบรม</b></td>
//         </tr>

//     </thead>
// </table>';
// }


// $table_begin3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">';
// $thead3 = '<thead>

//       <tr  style="border:1px solid #000;padding:8px;">
//         <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 10%;font-size:12px"><b>ลำดับ</b></td>
//         <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 25%;font-size:12px"><b>วันที่อบรม</b></td>
//         <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 30%;font-size:12px"><b>หัวข้อการอบรม</b></td>
//         <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 30%;font-size:12px"><b>รายละเอียดเพิ่มเติม</b></td>
//         <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 30%;font-size:12px"><b>ชั่วโมงการอบรม</b></td>
//         <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 30%;font-size:12px"><b>ผู้ฝึกอบรม</b></td>
//       </tr>
//     </thead><tbody>';
//     $i = 1;
    
//     $sql_sedata = "SELECT e.Company_NameT, b.PersonID, 
//     c.PersonCode, d.PositionNameT, 
//     c.FnameT, c.LnameT,a.Patern_Name,a.Patern_descrition, 
//     a.Patern_Budget,a.Patern_Hour,
//     b.pretest_point, b.posttest_point,g.Professor_NameT,
//     a.Patern_Date,CONVERT(VARCHAR(10), a.Patern_Date, 103)  AS 'PATTERNDATE', 
//     a.Patern_End,CONVERT(VARCHAR(10), a.Patern_End, 103)  AS 'PATTERNEND'
//     FROM [203.150.225.30].[TigerE-HR].dbo.TN_Patern__Course a
//     INNER JOIN [203.150.225.30].[TigerE-HR].dbo.TN_TrainPerson b ON b.Patern_ID = a.Patern_ID
//     INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNT_Person c ON c.PersonID = b.PersonID
//     INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNM_Position d ON d.PositionID = c.PositionID
//     INNER JOIN [203.150.225.30].[TigerE-HR].dbo.COM_Company e ON e.ID_Company = c.CompanyID
//     INNER JOIN [203.150.225.30].[TigerE-HR].dbo.TN_Patern_Professor f ON f.Patern_ID = a.Patern_ID
//     INNER JOIN [203.150.225.30].[TigerE-HR].dbo.TN_Professor g ON g.Professor_ID = f.Professor_ID
//     WHERE c.PersonCode ='".$_GET['employeecode']."'
//     ORDER BY  a.Patern_Date ASC";
//     $params_sedata = array();
    
    
    
//     $query_sedata = sqlsrv_query($conn, $sql_sedata, $params_sedata);
//     while ($result_sedata = sqlsrv_fetch_array($query_sedata, SQLSRV_FETCH_ASSOC)) {
      
//         $tbody3 .= '
//         <tr style="border:1px solid #000;padding:10px;">
//           <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 10%;font-size:16px">'.$i.'</td>
//           <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 10%;font-size:16px">'.$result_sedata['PATTERNDATE'].'</td>
//           <td style="border-right:1px solid #000;padding:10px;text-align:left;width: 70%;font-size:16px">'.$result_sedata['Patern_Name'].'</td>
//           <td style="border-right:1px solid #000;padding:10px;text-align:left;width: 20%;font-size:16px">'.$result_sedata['Patern_descrition'].'</td>
//           <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 5%;font-size:16px">'.$result_sedata['Patern_Hour'].'</td>
//           <td style="border-right:1px solid #000;padding:10px;text-align:left;width: 5%;font-size:16px">'.$result_sedata['Professor_NameT'].'</td>
//         </tr>';
      
//       $i++;
//     }

// $table_end3 = '</table>';




$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table1);

if ($result_seCountAccident['COUNTACCI'] > 0) {
    $mpdf->WriteHTML($table_header2);
    $mpdf->WriteHTML($table_begin2);
    $mpdf->WriteHTML($thead2);
    $mpdf->WriteHTML($tbody2);
    $mpdf->WriteHTML($table_end2);
    // $mpdf->Output();
}else {
    $mpdf->WriteHTML($table_header2);
    // $mpdf->Output();
}


// Training Data
// $mpdf->AddPage();
// if ($result_seCountTraining['COUNTTRAINING'] > 0) {
//   $mpdf->WriteHTML($table_header3);
//   $mpdf->WriteHTML($table_begin3);
//   $mpdf->WriteHTML($thead3);
//   $mpdf->WriteHTML($tbody3);
//   $mpdf->WriteHTML($table_end3);
//   // $mpdf->Output();
// }else {
//   $mpdf->WriteHTML($table_header3);
//   // $mpdf->WriteHTML($table_begin3);
//   // $mpdf->WriteHTML($thead3);
//   // $mpdf->Output();
// }

$mpdf->Output();


sqlsrv_close($conn);
?>
