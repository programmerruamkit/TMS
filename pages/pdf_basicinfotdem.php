
<?php

require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
//$mpdf = new mPDF();
$mpdf = new mPDF('th', 'A4', '0', '');

// $employee = " AND a.PersonCode = '" . $_GET['employeecode'] . "'";
// $sql_seEmp = "{call megEmployeeEHR_v2(?,?)}";
// $params_seEmp = array(
//     array('select_employee', SQLSRV_PARAM_IN),
//     array($employee, SQLSRV_PARAM_IN)
// );
// $query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
// $result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC);

// $employee1 = " AND a.PersonCode = '" . $_GET['employeecode'] . "'";
// $sql_seLicenDate = "{call megEmployeeEHR_v2(?,?)}";
// $params_seLicenDate = array(
//     array('select_LicenceDate', SQLSRV_PARAM_IN),
//     array($employee1, SQLSRV_PARAM_IN)
// );
// $query_seLicenDate = sqlsrv_query($conn, $sql_seLicenDate, $params_seLicenDate);
// $result_seLicenDate = sqlsrv_fetch_array($query_seLicenDate, SQLSRV_FETCH_ASSOC);



$sql_seEmp = "SELECT a.PersonCode,a.FnameT,a.LnameT,(a.FnameT+' '+a.LnameT) AS nameT, 
      a.FnameE, a.LnameE,(a.FnameE+' '+a.LnameE) AS nameE,a.SexID,
      CONVERT(VARCHAR(11),a.BirthDate, 106) AS 'BirthDate106',
      a.CurrentTel,b.Tel,c.PositionNameT,f.PositionGroup,b.Email,d.Company_Code,d.Company_NameT, d.Company_NameE, 
      a.LevelID,c.PositionNameT,c.PositionNameE,  a.TaxID, a.InitialID, a.PersonPic,
      a.FnameT,a.LnameT ,a.BirthDate,a.StartDate AS 'StartWork' ,
      CONVERT(VARCHAR(11),a.StartDate, 106) AS 'StartDate',
      CONVERT(VARCHAR(11),a.PassDate, 106) AS 'PassDate',	
      a.SexID,c.PositionID,e.SexT,CONVERT(VARCHAR(10),a.BirthDate, 103) AS 'BirthDate103',a.numProof,CONVERT(VARCHAR(10),a.EndDate, 103) AS 'EndDate',
      c.PositionNameOther , b.CarLicenceID,a.CardTel,b.Email,g.MaritalT,g.MaritalE,a.CurrentAddress,h.DistrictT,i.AmphurT,j.ProveNameT,CurrentPostID,l.DegreeID,l.DegreeT
      FROM [203.150.225.30].[TigerE-HR].dbo.PNT_Person a
      INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNT_PersonDetail b ON a.PersonID = b.PersonID 
      INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNM_Position c ON a.PositionID = c.PositionID 
      INNER JOIN [203.150.225.30].[TigerE-HR].dbo.COM_Company d ON a.CompanyID = d.ID_Company
      INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].[PNM_Sex] e ON a.SexID = e.SexID
      INNER JOIN [dbo].[POSITIONEHR] f ON c.PositionID = f.PositionID
      INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].[PNM_Marital] g ON g.MaritalID = b.MaritalID
      INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].[PNM_District] h ON h.DistrictID = a.CurrentDistric
      INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].[PNM_Amphur] i ON i.AmphurID = a.CurrentAmphur
      INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].[PNM_Province] j ON j.ProvID = a.CurrentProvince
      INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].[PNT_Education] k ON k.PersonID = a.PersonID
      INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].[PNM_Degree] l ON l.DegreeID = k.DegreeID
      WHERE 1 = 1 AND a.[EndDate] IS NULL
      AND a.PersonCode NOT IN 
      (SELECT PNT_Person.PersonCode
      FROM [203.150.225.30].[TigerE-HR].[dbo].PNT_Resign 
      INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].PNM_ResignType ON PNT_Resign.ResignTypeID = PNM_ResignType.ResignTypeID 
      LEFT OUTER JOIN [203.150.225.30].[TigerE-HR].[dbo].PNT_Person ON PNT_Resign.PersonID = PNT_Person.PersonID
      WHERE PNM_ResignType.ResignT !='เกษียณอายุ'
      )
      AND a.ResignStatus = '1'
      AND a.ChkDeletePerson = '1'
      AND a.FnameT+' '+a.LnameT NOT IN (SELECT [EMPLOYEENAMEF]+' '+[EMPLOYEENAMEL] FROM [203.150.225.30].[TigerE-HR].[dbo].EMPLOYEEOUT) 
      AND a.PersonCode = '" .$_GET['employeecode']. "'";
$params_seEmp = array();
$query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
$result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC);

if ($result_seEmp['DegreeT'] == 'ม.3') {
  $degree = 'Grade 9';
}else if ($result_seEmp['DegreeT'] == 'ม.6') {
  $degree = 'Grade 12';
}else if ($result_seEmp['DegreeT'] == 'ปวช.') {
  $degree = 'Vocational Certificate';
}else if ($result_seEmp['DegreeT'] == 'ปวส.') {
  $degree = 'High Vocational Certificate';
}else if ($result_seEmp['DegreeT'] == 'ปริญญาตรี') {
  $degree = 'B.A. (Bachelor of Arts)';
}else {
  $degree = '';
}

//คำนวณหาวันเกิด
$date = $result_seEmp['BirthDate'];
$dateecho = date_format($date,"Y-m-d");

$birthday = $dateecho;      
$today = date("Y-m-d");   
  

list($byear, $bmonth, $bday)= explode("-",$birthday);      
list($tyear, $tmonth, $tday)= explode("-",$today);               
  
$mbirthday = mktime(0, 0, 0, $bmonth, $bday, $byear); 
$mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear );
$mage = ($mnow - $mbirthday);

$u_y = date("Y", $mage)-1970;
$u_m = date("m",$mage)-1;
$u_d = date("d",$mage)-4;

// echo"<br><br>$u_y   ปี    $u_m เดือน      $u_d  วัน<br><br>";

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
$u_dwork = date("d",$magework)-5;


$sql_seDep = "SELECT DISTINCT b.DEPARTMENTNAME,b.DEPARTMENTCODE,a.SECTIONCODE
FROM [dbo].[ORGANIZATION] a
INNER JOIN [dbo].[DEPARTMENT_NEW] b ON a.DEPARTMENTCODE = b.DEPARTMENTCODE
WHERE a.EMPLOYEECODE = '".$_GET['employeecode']."' ";
$query_seDep = sqlsrv_query($conn, $sql_seDep, $params_seDep);
$result_seDep = sqlsrv_fetch_array($query_seDep, SQLSRV_FETCH_ASSOC);

$sql_seSecID = "SELECT SECTIONID FROM [dbo].[SECTION_NEW]
WHERE  DEPARTMENTCODE = '".$result_seDep['DEPARTMENTCODE']."'
AND SECTIONCODE ='".$result_seDep['SECTIONCODE']."'";
$query_seSecID = sqlsrv_query($conn, $sql_seSecID, $params_seSecID);
$result_seSecID = sqlsrv_fetch_array($query_seSecID, SQLSRV_FETCH_ASSOC);


$sql_seSec = "SELECT b.SECTIONNAME FROM [dbo].[ORGANIZATION] a
INNER JOIN [dbo].SECTION_NEW b ON a.SECTIONCODE = b.SECTIONCODE
WHERE a.EMPLOYEECODE = '".$_GET['employeecode']."'
AND a.DEPARTMENTCODE = '".$result_seDep['DEPARTMENTCODE']."'
AND b.SECTIONCODE ='".$result_seDep['SECTIONCODE']."'
AND b.SECTIONID ='".$result_seSecID['SECTIONID']."'";
$query_seSec = sqlsrv_query($conn, $sql_seSec, $params_seSec);
$result_seSec = sqlsrv_fetch_array($query_seSec, SQLSRV_FETCH_ASSOC);

$sql_seMarital = "SELECT MaritalT,MaritalE  FROM [203.150.225.30].[TigerE-HR].[dbo].[PNM_Marital]
                  WHERE  ";
$query_seMarital = sqlsrv_query($conn, $sql_seMarital, $params_seMarital);
$result_seMarital = sqlsrv_fetch_array($query_seMarital, SQLSRV_FETCH_ASSOC);

$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';


$table1 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
<tr style=" padding:4px;">
     <th colspan="6" style=" padding:4px;text-align:center;font-size:10px"><b>' .$result_seEmp['Company_NameT']. '</b></th>
    </tr>
    <tr style=" padding:4px;">
     <th colspan="6" style=" padding:4px;text-align:center;font-size:10px"><b>รายงานข้อมูลพนักงาน</b></th>
    </tr>
    <tr style=" padding:4px;">
     <th colspan="2" style=" padding:4px;text-align:left;font-size:10px"><b>ฝ่าย : </b> '.$result_seDep['DEPARTMENTNAME'].' </th>
     <th colspan="2" style=" padding:4px;text-align:left;font-size:10px"><b>แผนก : </b> '.$result_seSec['SECTIONNAME'].' </th>
     <th colspan="2" style=" padding:4px;text-align:left;font-size:10px"><b>ระดับพักงาน : </b> '.$result_seEmp['PositionGroup'].' </th>
    </tr>
    </thead>';
    $table1 .= '<tbody>

    <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;" colspan="10"><hr /></td>
    </tr>
    <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;font-size:10px;width: 15%">EmployeeCode :</td>
        <td style=" padding:4px;text-align:left;font-size:10px;width: 20%">'.$result_seEmp['PersonCode'].'</td>
        <td style=" padding:4px;text-align:left;font-size:10px;">Company :</td>
        <td style=" padding:4px;text-align:left;font-size:10px;">'.$result_seEmp['Company_NameE'].'</td>  
        <td colspan="2" rowspan="7" style=" padding:4px;text-align:center;width: 15%"><img width="20%" src="../images/employee/'.$result_seEmp['PersonCode'].'.JPG"></td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;font-size:10px">DriverName(Thai) :</td>
        <td style=" padding:4px;text-align:left;font-size:10px">'.$result_seEmp['nameT'].'</td>
        <td style=" padding:4px;text-align:left;font-size:10px">Sub-Contract :</td>
        <td style=" padding:4px;text-align:left;font-size:10px">-</td>  
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;font-size:10px">DriverName(Eng) :</td>
        <td style=" padding:4px;text-align:left;font-size:10px">'.$result_seEmp['nameE'].'</td>
        <td style=" padding:4px;text-align:left;font-size:10px">1st Working Date :</td>
        <td style=" padding:4px;text-align:left;font-size:10px">'.$result_seEmp['StartDate'].'</td>    
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;font-size:10px">Sex :</td>
        <td style=" padding:4px;text-align:left;font-size:10px">'.$result_seEmp['SexT'].'</td>
        <td style=" padding:4px;text-align:left;font-size:10px">Working Experience :</td>
        <td style=" padding:4px;text-align:left;font-size:10px">'.$u_ywork.' Y / '.$u_mwork.' M / '.$u_dwork.' D</td>  
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;font-size:10px">Date of Birth :</td>
        <td style=" padding:4px;text-align:left;font-size:10px">'.$result_seEmp['BirthDate106'].'</td>
        <td style=" padding:4px;text-align:left;font-size:10px">Position :</td>
        <td style=" padding:4px;text-align:left;font-size:10px">'.$result_seEmp['PositionNameT'].'</td> 
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;font-size:10px">Age :</td>
        <td style=" padding:4px;text-align:left;font-size:10px">'.$u_y.' Y / '.$u_m.' M / '.$u_d.' D</td>
        <td style=" padding:4px;text-align:left;font-size:10px">Education :</td>
        <td style=" padding:4px;text-align:left;font-size:10px">'.$result_seEmp['DegreeT'].' / '.$degree.'</td>   
      </tr>
      
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;font-size:10px">Status :</td>
        <td style=" padding:4px;text-align:left;font-size:10px">'.$result_seEmp['MaritalT'].'/'.$result_seEmp['MaritalE'].'</td>
        <td style=" padding:4px;text-align:left;font-size:10px">Current Address :</td>
        <td style=" padding:4px;text-align:left;font-size:10px">'.$result_seEmp['CurrentAddress'].' อ.'.$result_seEmp['AmphurT'].' ต.'.$result_seEmp['DistrictT'].'<br>จ.'.$result_seEmp['ProveNameT'].' '.$result_seEmp['CurrentPostID'].'</td>   
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;font-size:10px"></td>
        <td style=" padding:4px;text-align:left;font-size:10px"></td>  
        <td style=" padding:4px;text-align:left;font-size:10px">Truck license ID :</td>
        <td style=" padding:4px;text-align:left;font-size:10px">'.$result_seEmp['CarLicenceID'].'</td>  
      </tr>
      
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;" colspan="6"><hr /></td>
    </tr>
     <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;" colspan="6"></td>
    </tr>
</tbody></table>';


$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table1);


$mpdf->Output();

sqlsrv_close($conn);
?>
