
<?php

require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
//$mpdf = new mPDF();
$mpdf = new mPDF('th', 'A4', '0', '');

$employee = " AND a.PersonCode = '" . $_GET['employeecode'] . "'";
$sql_seEmp = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmp = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($employee, SQLSRV_PARAM_IN)
);
$query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
$result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC);

$employee1 = " AND a.PersonCode = '" . $_GET['employeecode'] . "'";
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

// ข้อมูลบุคคล ตำบล,อำเภอ,จังหวัด,โรงพยาบาลประกันสังคม
$sql_SeCardliveData = "SELECT  a.PersonCode,a.PersonID,a.CardAddress,a.CardBuilding,a.CardSoi,a.CardRoad,
b.DISTRICT_NAME_TH,c.AMPHUR_NAME_TH,d.PROVINCE_NAME_TH,a.CardPostID,a.HospitalId,e.HOSPITAL_NAME_TH 
FROM EMPLOYEEEHR2 a   
LEFT JOIN DISTRICTS b ON b.DISTRICT_ID  = a.CardDistric
LEFT JOIN AMPHURES  c ON c.AMPHUR_ID    = a.CardAmphur
LEFT JOIN PROVINCES d ON d.PROVINCE_ID  = a.CardProvince
LEFT JOIN HOSPITAL  e ON e.HOSPITAL_ID  = a.HospitalId
WHERE a.PersonCode ='".$_GET['employeecode']."'";
$params_SeCardliveData = array();
$query_SeCardliveData = sqlsrv_query($conn, $sql_SeCardliveData, $params_SeCardliveData);
$result_SeCardliveData = sqlsrv_fetch_array($query_SeCardliveData, SQLSRV_FETCH_ASSOC);

$cardlivedata = ($result_SeCardliveData['CardAddress'].' '.$result_SeCardliveData['CardBuilding'].' '.$result_SeCardliveData['CardSoi']
.' ถ.'.$result_SeCardliveData['CardRoad'].' ต.'.$result_SeCardliveData['DISTRICT_NAME_TH'].'<br> อ.'.$result_SeCardliveData['AMPHUR_NAME_TH'].' จ.'.$result_SeCardliveData['PROVINCE_NAME_TH'].' '.$result_SeCardliveData['CardPostID']);

// ข้อมูลการศึกษา
$sql_SeEducateData = "SELECT b.INSTITUTEID,b.INSTITUTENAMET,c.DEGREEID,c.DEGREET,a.EDUCATEGRADE
FROM EDUCATION a
INNER JOIN INSTITUTE b ON b.INSTITUTEID = a.INSTITUTEID
INNER JOIN DEGREE c ON c.DEGREEID = a.DEGREEID
WHERE PersonID ='".$result_seEmp['PersonID']."'";
$params_SeEducateData = array();
$query_SeEducateData = sqlsrv_query($conn, $sql_SeEducateData, $params_SeEducateData);
$result_SeEducateData = sqlsrv_fetch_array($query_SeEducateData, SQLSRV_FETCH_ASSOC);

//คำนวณหาวันทำงาน อายุงาน
// $datework = $result_seEmp['StartDate'];
// $dateechodatework = date_format($datework,"Y-m-d");

// $birthdaywork = $dateechodatework;      
// $todaywork = date("Y-m-d");   
  

// list($byearwork, $bmonthwork, $bdaywork)= explode("-",$birthdaywork);      
// list($tyearwork, $tmonthwork, $tdaywork)= explode("-",$todaywork);               
  
// $mbirthdaywork = mktime(0, 0, 0, $bmonthwork, $bdaywork, $byearwork); 
// $mnowwork = mktime(0, 0, 0, $tmonthwork, $tdaywork, $tyearwork );
// $magework = ($mnowwork - $mbirthdaywork);

// $u_ywork = date("Y",$magework)-1970;
// $u_mwork = date("m",$magework)-1;
// $u_dwork = date("d",$magework);

///คำนวนหาอายุงาน
$datework = $result_seEmp['StartDate'];

$day =  substr($result_seEmp['StartDate'],0,2);
$month =  substr($result_seEmp['StartDate'],3,2);
$year =  substr($result_seEmp['StartDate'],6);

$datework = $month."/".$day."/".$year;


$sql_CalculateWork = "{call megCalculatorDate(?,?)}";
$params_CalculateWork = array(
    array('calculate_work', SQLSRV_PARAM_IN),
    array($datework, SQLSRV_PARAM_IN)
);
$query_CalculateWork = sqlsrv_query($conn, $sql_CalculateWork, $params_CalculateWork);
$result_CalculateWork = sqlsrv_fetch_array($query_CalculateWork, SQLSRV_FETCH_ASSOC);
// echo $result_CalculateWork['RS'];

///คำนวนหาอายุตน

$dayAge =  substr($result_seEmp['BirthDate103'],0,2);
$monthAge =  substr($result_seEmp['BirthDate103'],3,2);
$yearAge =  substr($result_seEmp['BirthDate103'],6);

$dateworkAge = $monthAge."/".$dayAge."/".$yearAge;


$sql_CalculateAge = "{call megCalculatorDate(?,?)}";
$params_CalculateAge = array(
    array('calculate_work', SQLSRV_PARAM_IN),
    array($dateworkAge, SQLSRV_PARAM_IN)
);
$query_CalculateAge = sqlsrv_query($conn, $sql_CalculateAge, $params_CalculateAge);
$result_CalculateAge = sqlsrv_fetch_array($query_CalculateAge, SQLSRV_FETCH_ASSOC);
// echo $result_CalculateAge['RS'];


// $sql_seCountTraining = "SELECT COUNT(Patern_Name) AS 'COUNTTRAINING'
// FROM [203.150.225.30].[TigerE-HR].dbo.TN_Patern__Course a
// INNER JOIN [203.150.225.30].[TigerE-HR].dbo.TN_TrainPerson b ON b.Patern_ID = a.Patern_ID
// INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNT_Person c ON c.PersonID = b.PersonID
// INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNM_Position d ON d.PositionID = c.PositionID
// INNER JOIN [203.150.225.30].[TigerE-HR].dbo.COM_Company e ON e.ID_Company = c.CompanyID
// WHERE c.PersonCode ='".$_GET['employeecode']."'";
// $query_seCountTraining = sqlsrv_query($conn, $sql_seCountTraining, $params_seCountTraining);
// $result_seCountTraining = sqlsrv_fetch_array($query_seCountTraining, SQLSRV_FETCH_ASSOC);

$getemp = $_GET['employeecode'];
$sql_histrain = "SELECT COUNT(COURSESUB_NAMETH) AS 'COUNTTRAINING'
FROM [eTraining].[dbo].HISTORY_TRAINING 
WHERE PersonCode = '".$getemp."'";
$query_histrain = sqlsrv_query($conn, $sql_histrain, $params_histrain);
$result_histrain = sqlsrv_fetch_array($query_histrain, SQLSRV_FETCH_ASSOC);
$HISTCS_CSNT = $result_histrain['COUNTTRAINING'];
$sql_vwhistrain = "SELECT COUNT(TCS_CSNT) AS 'COUNTTRAINING'
FROM [eTraining].[dbo].vwREPORTTRAININGHISTORY 
WHERE PYE_PSC = '".$getemp."'";
$query_vwhistrain = sqlsrv_query($conn, $sql_vwhistrain, $params_vwhistrain);
$result_vwhistrain = sqlsrv_fetch_array($query_vwhistrain, SQLSRV_FETCH_ASSOC);
$VWHISTCS_CSNT = $result_vwhistrain['COUNTTRAINING'];

$CALTCS_CSNT = $HISTCS_CSNT + $VWHISTCS_CSNT;

$currentyear = date("Y");
$sql_seCountHealth = "SELECT  COUNT(ID) AS 'COUNTHEALTH'
FROM [dbo].[HEALTHHISTORY]
WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
AND CREATEYEAR ='".$currentyear."'
AND ACTIVESTATUS ='1'";
$query_seCountHealth = sqlsrv_query($conn, $sql_seCountHealth, $params_seCountHealth);
$result_seCountHealth = sqlsrv_fetch_array($query_seCountHealth, SQLSRV_FETCH_ASSOC);


$sql_seCountHealthLastYear = "SELECT  COUNT(ID) AS 'COUNTHEALTH_LASTYEAR'
FROM [dbo].[HEALTHHISTORY]
WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
AND CREATEYEAR ='".($currentyear-1)."'
AND ACTIVESTATUS ='1'";
$query_seCountHealthLastYear = sqlsrv_query($conn, $sql_seCountHealthLastYear, $params_seCountHealthLastYear);
$result_seCountHealthLastYear = sqlsrv_fetch_array($query_seCountHealthLastYear, SQLSRV_FETCH_ASSOC);

if ($result_seEmp['MaritalID'] = '1') {
    $status = 'โสด';
}else if($result_seEmp['MaritalID'] = '2'){
    $status = 'สมรส';
}else if($result_seEmp['MaritalID'] = '3'){
    $status = 'หย่า';
}else{
    $status = 'หม้าย';
}


// $sql_seHopital = "SELECT a.HospitalId,b.HospitalNameT  
// FROM [203.150.225.30].[TigerE-HR].dbo.PNT_Person a
// INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNM_Hospital b ON b.HospitalId = a.HospitalId
// WHERE a.PersonCode ='".$_GET['employeecode']."'";
// $query_seHopital = sqlsrv_query($conn, $sql_seHopital, $params_seHopital);
// $result_seHopital = sqlsrv_fetch_array($query_seHopital, SQLSRV_FETCH_ASSOC);


$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';


$table1 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
<tr style=" padding:4px;">
     <th colspan="6" style=" padding:4px;text-align:center;"><b>' . $result_seEmp['Company_NameT'] . ' </b></th>
    </tr>
    <tr style=" padding:4px;">
     <th colspan="6" style=" padding:4px;text-align:center;"><b>รายงานข้อมูลพนักงาน</b></th>
    </tr>
    <tr style=" padding:4px;">
     <th colspan="2" style=" padding:4px;text-align:left;"><b>ฝ่าย : </b> '.$result_seDep['DEPARTMENTNAME'].' </th>
     <th colspan="2" style=" padding:4px;text-align:left;"><b>แผนก : </b> '.$result_seSec['SECTIONNAME'].' </th>
     <th colspan="2" style=" padding:4px;text-align:left;"><b>ระดับพนักงาน : </b> '.$result_seEmp['PositionNameT'].' </th>
    </tr>
    </thead>';
    $table1 .= '<tbody>

    <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;" colspan="6"><hr /></td>
    </tr>
    <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;width: 15%">รหัสพนักงาน</td>
        <td style=" padding:4px;text-align:left;width: 20%">'.$result_seEmp['PersonCode'].'</td>
        <td style=" padding:4px;text-align:left;width: 15%">เพศ</td>
        <td style=" padding:4px;text-align:left;width: 20%">'.$result_seEmp['SexT'].'</td>
        <td colspan="2" rowspan="7" style=" padding:4px;text-align:center;width: 15%"><img width="20%" src="../images/employee/'.$result_seEmp['PersonCode'].'.JPG"></td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">ชื่อ-สกุล(ไทย)</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['nameT'].'</td>
        <td style=" padding:4px;text-align:left;">สถานภาพ</td>
        <td style=" padding:4px;text-align:left;">'.$status.'</td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">ชื่อ-สกุล(อังกฤษ)</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['nameE'].'</td>
        <td style=" padding:4px;text-align:left;">วันเกิด</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['BirthDate103'].'</td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">ฝ่าย</td>
        <td style=" padding:4px;text-align:left;">'.$result_seDep['DEPARTMENTNAME'].' </td>
        <td style=" padding:4px;text-align:left;">อายุ(ปี/เดือน/วัน)</td>
        <td style=" padding:4px;text-align:left;">'.$result_CalculateAge['RS'].' </td>
      </tr>



      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">แผนก</td>
        <td style=" padding:4px;text-align:left;">'.$result_seSec['SECTIONNAME'].'</td>
        <td style=" padding:4px;text-align:left;">วันที่เริ่มงาน</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['StartDate'].'</td>
      </tr>
       <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">ระดับพนักงาน</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['PositionNameT'].' </td>
        <td style=" padding:4px;text-align:left;">วันที่บรรจุ</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['PassDate'].'</td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">ตำแหน่ง</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['PositionNameOther'].'</td>
        <td style=" padding:4px;text-align:left;">จำนวนวันทดลองงาน</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['numProof'].'</td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">เลขที่บัตรประชาชน</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['TaxID'].'</td>
        <td style=" padding:4px;text-align:left;">อายุงาน(ปี/เดือน/วัน)</td>
        <td style=" padding:4px;text-align:left;">'.$result_CalculateWork['RS'].' </td>
      </tr>

      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;">เลขที่ประกันสังคม</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['TaxID'].'</td>
        <td style=" padding:4px;text-align:left;">วันที่ลาออก</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['EndDate'].'</td>
        <td style=" padding:4px;text-align:left;">เลขที่บัตรผู้เสียภาษี</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['TaxID'].'</td>
      </tr>
       <tr style="#000;padding:4px;">
        <td style=" padding:4px;text-align:left;">เลขที่ใบขับขี่</td>
        <td style=" padding:4px;text-align:left;">'.$result_seEmp['CarLicenceID'].'</td>
        <td style=" padding:4px;text-align:left;">รพ.ประกันสังคม</td>
        <td style=" padding:4px;text-align:left;">'.$result_SeCardliveData['HOSPITAL_NAME_TH'].'</td>
      </tr>
       <tr style="#000;padding:4px;">
        <td style=" padding:4px;text-align:left;">วันอนุญาต</td>
        <td style=" padding:4px;text-align:left;">'.$result_seLicenDate['StartDate'].'</td>
      </tr>
       <tr style="#000;padding:4px;">
        <td style=" padding:4px;text-align:left;">วันสิ้นอายุ</td>
        <td style=" padding:4px;text-align:left;">'.$result_seLicenDate['EndDate'].'</td>
      </tr>
       <tr style="#000;padding:4px;">
        <td style=" padding:4px;text-align:left;">ที่อยู่ตามบัตรประชาชน</td>
        <td style=" padding:4px;text-align:left;">'.$cardlivedata.'</td>
      </tr>
       <tr style="padding:4px;">
        <td style=" padding:4px;text-align:left;">ระดับการศึกษา</td>
        <td style=" padding:4px;text-align:left;">'.$result_SeEducateData['DEGREET'].'</td>
        <td style=" padding:4px;text-align:left;"></td>
        <td style=" padding:4px;text-align:left;"></td>
      </tr>
      <tr style="padding:4px;">
        <td style=" padding:4px;text-align:left;"></td>
        <td style=" padding:4px;text-align:left;"></td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;" colspan="6"><hr /></td>
    </tr>
     <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;" colspan="6"></td>
    </tr>
</tbody></table>';

// ////////////////////////////////////////////////////////////////////////////////////////////////////

// ประวัติสุขภาพ ย้อนหลัง 1 ปี
if ($result_seCountHealthLastYear['COUNTHEALTH_LASTYEAR'] > 0) {
  $table_header2lastyear = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="48" style="text-align:center;font-size:16px"><b>ข้อมูลประวัติสุขภาพปี&#160;'.($currentyear-1).'</b></td>
        </tr>

    </thead>
</table>';
}else {
  $table_header2lastyear = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="48" style="text-align:center;font-size:16px"><b>ยังไม่มีข้อมูลประวัติสุขภาพปี&#160;'.($currentyear-1).'</b></td>
        </tr>

    </thead>
</table>';
}


$table_begin2lastyear = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead2lastyear = '<thead>
      <tr  style="border:1px solid #000;padding:8px;background-color:#A69D9D">
        <td colspan = "4"   style="border-right:1px solid #000;padding:8px;text-align:center;font-size:12px"><b>สายตาสั้น</b></td>
        <td colspan = "4"   style="border-right:1px solid #000;padding:8px;text-align:center;font-size:12px"><b>สายตายาว</b></td>
        <td colspan = "4"   style="border-right:1px solid #000;padding:8px;text-align:center;font-size:12px"><b>สายตาเอียง</b></td>
      </tr>
    </thead><tbody>';
    $ihealthlastyear = 1;
    
    $sql_sedataHealthlastyear = "SELECT  TOP 1 ID,DIABETES,HIGHTBLOODPRESSURE,LOWBLOODPRESSURE,
      HEARTDISEASE, EPILEPPSY, BRAINSURGERY, SHORTSIGHT,SHORTSIGHT_R,SHORTSIGHT_L,LONGSIGHT,LONGSIGHT_R,LONGSIGHT_L,
      OBLIQUESIGHT,OBLIQUESIGHT_R,OBLIQUESIGHT_L,COLORBLIND_OK,COLORBLIND_NG,OTHERDISEASE1,OTHERDISEASE2,OTHERDISEASE3,
      OTHERDISEASE4,OTHERDISEASE5,OTHERDISEASE6,CREATEDATE,CREATEYEAR
      FROM [dbo].[HEALTHHISTORY]
      WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
      AND CREATEYEAR ='".($currentyear-1)."'
      AND ACTIVESTATUS ='1'
      ORDER BY CREATEDATE DESC";
    $params_sedataHealthlastyear = array();
    $query_sedataHealthlastyear = sqlsrv_query($conn, $sql_sedataHealthlastyear, $params_sedataHealthlastyearlastyear);
    while ($result_sedataHealthlastyear = sqlsrv_fetch_array($query_sedataHealthlastyear, SQLSRV_FETCH_ASSOC)) {
        // echo $result_sedataHealth['DIABETES'] == '0' ? 'UNCHECK'  : 'CHECK';
        $tbody2lastyear .= '
        <tr style="border:1px solid #000;padding:10px;background-color:#A69D9D">
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">R(ข้างขวา)</td>
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">L(ข้างซ้าย)</td>
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">R(ข้างขวา)</td>
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">L(ข้างซ้าย)</td>
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">R(ข้างขวา)</td>
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">L(ข้างซ้าย)</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">'.$result_sedataHealthlastyear['SHORTSIGHT_R'].'</td>
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">'.$result_sedataHealthlastyear['SHORTSIGHT_L'].'</td>
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">'.$result_sedataHealthlastyear['LONGSIGHT_R'].'</td>
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">'.$result_sedataHealthlastyear['LONGSIGHT_L'].'</td>
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">'.$result_sedataHealthlastyear['OBLIQUESIGHT_R'].'</td>
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">'.$result_sedataHealthlastyear['OBLIQUESIGHT_L'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;background-color:#A69D9D">
          <td colspan = "8" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">5 โรคเสี่ยง</td>
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">โรคอื่นๆ</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">1.โรคเบาหวาน</td>
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.($result_sedataHealthlastyear['DIABETES']  == '0' ? 'ไม่มีโรค' : 'มีโรค').'</td>
          // โรคอื่นๆ
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.$result_sedataHealthlastyear['OTHERDISEASE1'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">2.โรคความดันโลหิตสูง</td>
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.($result_sedataHealthlastyear['HIGHTBLOODPRESSURE']  == '0' ? 'ไม่มีโรค' : 'มีโรค').'</td>
          // โรคอื่นๆ
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.$result_sedataHealthlastyear['OTHERDISEASE2'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">3.โรคความดันโลหิตต่ำ</td>
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.($result_sedataHealthlastyear['LOWBLOODPRESSURE']  == '0' ? 'ไม่มีโรค' : 'มีโรค').'</td>
          // โรคอื่นๆ
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.$result_sedataHealthlastyear['OTHERDISEASE3'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">4.โรคหัวใจ</td>
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.($result_sedataHealth['HEARTDISEASE']  == '0' ? 'ไม่มีโรค' : 'มีโรค').'</td>
          // โรคอื่นๆ
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.$result_sedataHealthlastyear['OTHERDISEASE4'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">5.โรคลมชัก/ลมบ้าหมู</td>
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.($result_sedataHealthlastyear['EPILEPPSY']  == '0' ? 'ไม่มีโรค' : 'มีโรค').'</td>
          // โรคอื่นๆ
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.$result_sedataHealthlastyear['OTHERDISEASE5'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">6.ผ่าตัดสมอง</td>
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.($result_sedataHealthlastyear['BRAINSURGERY']  == '0' ? 'ไม่มีโรค' : 'มีโรค').'</td>
          // โรคอื่นๆ
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.$result_sedataHealthlastyear['OTHERDISEASE6'].'</td>
        </tr>
        ';
      
      $i++;
    }

$table_end2lastyear = '</table>';

// ////////////////////////////////////////////////////////////////////////////////////////////////////
// ประวัติสุขภาพ
if ($result_seCountHealth['COUNTHEALTH'] > 0) {
  $table_header2 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="48" style="text-align:center;font-size:16px"><b>ข้อมูลประวัติสุขภาพปี&#160;'.$currentyear.'</b></td>
        </tr>

    </thead>
</table>';
}else {
  $table_header2 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="48" style="text-align:center;font-size:16px"><b>ยังไม่มีข้อมูลประวัติสุขภาพปี&#160;'.$currentyear.'</b></td>
        </tr>

    </thead>
</table>';
}


$table_begin2 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead2 = '<thead>
      <tr  style="border:1px solid #000;padding:8px;background-color:#A69D9D">
        <td colspan = "4"   style="border-right:1px solid #000;padding:8px;text-align:center;font-size:12px"><b>สายตาสั้น</b></td>
        <td colspan = "4"   style="border-right:1px solid #000;padding:8px;text-align:center;font-size:12px"><b>สายตายาว</b></td>
        <td colspan = "4"   style="border-right:1px solid #000;padding:8px;text-align:center;font-size:12px"><b>สายตาเอียง</b></td>
      </tr>
    </thead><tbody>';
    $ihealth = 1;
    
    $sql_sedataHealth = "SELECT  TOP 1 ID,DIABETES,HIGHTBLOODPRESSURE,LOWBLOODPRESSURE,
      HEARTDISEASE, EPILEPPSY, BRAINSURGERY, SHORTSIGHT,SHORTSIGHT_R,SHORTSIGHT_L,LONGSIGHT,LONGSIGHT_R,LONGSIGHT_L,
      OBLIQUESIGHT,OBLIQUESIGHT_R,OBLIQUESIGHT_L,COLORBLIND_OK,COLORBLIND_NG,OTHERDISEASE1,OTHERDISEASE2,OTHERDISEASE3,
      OTHERDISEASE4,OTHERDISEASE5,OTHERDISEASE6,CREATEDATE,CREATEYEAR
      FROM [dbo].[HEALTHHISTORY]
      WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
      AND CREATEYEAR ='".$currentyear."'
      AND ACTIVESTATUS ='1'
      ORDER BY CREATEDATE DESC";
    $params_sedataHealth = array();
    $query_sedataHealth = sqlsrv_query($conn, $sql_sedataHealth, $params_sedataHealth);
    while ($result_sedataHealth = sqlsrv_fetch_array($query_sedataHealth, SQLSRV_FETCH_ASSOC)) {
        // echo $result_sedataHealth['DIABETES'] == '0' ? 'UNCHECK'  : 'CHECK';
        $tbody2 .= '
        <tr style="border:1px solid #000;padding:10px;background-color:#A69D9D">
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">R(ข้างขวา)</td>
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">L(ข้างซ้าย)</td>
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">R(ข้างขวา)</td>
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">L(ข้างซ้าย)</td>
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">R(ข้างขวา)</td>
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">L(ข้างซ้าย)</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">'.$result_sedataHealth['SHORTSIGHT_R'].'</td>
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">'.$result_sedataHealth['SHORTSIGHT_L'].'</td>
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">'.$result_sedataHealth['LONGSIGHT_R'].'</td>
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">'.$result_sedataHealth['LONGSIGHT_L'].'</td>
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">'.$result_sedataHealth['OBLIQUESIGHT_R'].'</td>
          <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">'.$result_sedataHealth['OBLIQUESIGHT_L'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;background-color:#A69D9D">
          <td colspan = "8" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">5 โรคเสี่ยง</td>
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">โรคอื่นๆ</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">1.โรคเบาหวาน</td>
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.($result_sedataHealth['DIABETES']  == '0' ? 'ไม่มีโรค' : 'มีโรค').'</td>
          // โรคอื่นๆ
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.$result_sedataHealth['OTHERDISEASE1'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">2.โรคความดันโลหิตสูง</td>
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.($result_sedataHealth['HIGHTBLOODPRESSURE']  == '0' ? 'ไม่มีโรค' : 'มีโรค').'</td>
          // โรคอื่นๆ
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.$result_sedataHealth['OTHERDISEASE2'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">3.โรคความดันโลหิตต่ำ</td>
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.($result_sedataHealth['LOWBLOODPRESSURE']  == '0' ? 'ไม่มีโรค' : 'มีโรค').'</td>
          // โรคอื่นๆ
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.$result_sedataHealth['OTHERDISEASE3'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">4.โรคหัวใจ</td>
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.($result_sedataHealth['HEARTDISEASE']  == '0' ? 'ไม่มีโรค' : 'มีโรค').'</td>
          // โรคอื่นๆ
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.$result_sedataHealth['OTHERDISEASE4'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">5.โรคลมชัก/ลมบ้าหมู</td>
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.($result_sedataHealth['EPILEPPSY']  == '0' ? 'ไม่มีโรค' : 'มีโรค').'</td>
          // โรคอื่นๆ
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.$result_sedataHealth['OTHERDISEASE5'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">6.ผ่าตัดสมอง</td>
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.($result_sedataHealth['BRAINSURGERY']  == '0' ? 'ไม่มีโรค' : 'มีโรค').'</td>
          // โรคอื่นๆ
          <td colspan = "4" style="border-right:1px solid #000;padding:10px;text-align:left;font-size:14px">'.$result_sedataHealth['OTHERDISEASE6'].'</td>
        </tr>
        ';
      
      $i++;
    }

$table_end2 = '</table>';

////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////
// Training Data
// if ($result_seCountTraining["COUNTTRAINING"]  > 0) {
if ($CALTCS_CSNT  > 0) {
  $table_header3 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="48" style="text-align:center;font-size:16px"><b>Training Data</b></td>
        </tr>

    </thead>
</table>';
}else {
  $table_header3 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="48" style="text-align:center;font-size:16px"><b>ยังไม่มีประวัติฝึกอบรม</b></td>
        </tr>

    </thead>
</table>';
}


$table_begin3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead3 = '<thead>

      <tr  style="border:1px solid #000;padding:8px;">
        <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 5%;font-size:12px"><b>ลำดับ</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 20%;font-size:12px"><b>วันที่เริ่มอบรม</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 20%;font-size:12px"><b>วันที่สิ้งสุดอบรม</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 30%;font-size:12px"><b>หัวข้อการอบรม</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 30%;font-size:12px"><b>รายละเอียดเพิ่มเติม</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 25%;font-size:12px"><b>ชั่วโมงการอบรม</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 30%;font-size:12px"><b>ผู้ฝึกอบรม</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 30%;font-size:12px"><b>หมายเหตุ</b></td>
      </tr>
    </thead><tbody>';
    $i = 1;
    
    // $sql_sedata = "SELECT e.Company_NameT, b.PersonID, 
    // c.PersonCode, d.PositionNameT, 
    // c.FnameT, c.LnameT,a.Patern_Name,a.Patern_descrition, 
    // a.Patern_Budget,a.Patern_Hour,
    // b.pretest_point, b.posttest_point,g.Professor_NameT,
    // a.Patern_Date,CONVERT(VARCHAR(10), a.Patern_Date, 103)  AS 'PATTERNDATE', 
    // a.Patern_End,CONVERT(VARCHAR(10), a.Patern_End, 103)  AS 'PATTERNEND'
    // FROM [203.150.225.30].[TigerE-HR].dbo.TN_Patern__Course a
    // INNER JOIN [203.150.225.30].[TigerE-HR].dbo.TN_TrainPerson b ON b.Patern_ID = a.Patern_ID
    // INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNT_Person c ON c.PersonID = b.PersonID
    // INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNM_Position d ON d.PositionID = c.PositionID
    // INNER JOIN [203.150.225.30].[TigerE-HR].dbo.COM_Company e ON e.ID_Company = c.CompanyID
    // INNER JOIN [203.150.225.30].[TigerE-HR].dbo.TN_Patern_Professor f ON f.Patern_ID = a.Patern_ID
    // INNER JOIN [203.150.225.30].[TigerE-HR].dbo.TN_Professor g ON g.Professor_ID = f.Professor_ID
    // WHERE c.PersonCode ='".$_GET['employeecode']."'
    // ORDER BY  a.Patern_Date DESC";
    // $params_sedata = array();
    
    $employeecode = $_GET['employeecode'];
    $sql_sedata = "SELECT DISTINCT
          H.PersonCode COLLATE Thai_CI_AI,
          H.COURSE_NAMETH COLLATE Thai_CI_AI TC_CN,
          H.COURSESUB_NAMETH COLLATE Thai_CI_AI Patern_Name,
          H.COURSE_PRICE_PER_PERSON COLLATE Thai_CI_AI Patern_Budget,
          H.HOURxDAYS COLLATE Thai_CI_AI Patern_Hour,
          H.COURSE_DATESTART COLLATE Thai_CI_AI PY_CDS,
          SUBSTRING ( COURSE_DATESTART COLLATE Thai_CI_AI, 9, 10 ) AS PY_CDSSUB,
          H.COURSE_DATEEND COLLATE Thai_CI_AI PY_CDE,
          SUBSTRING ( COURSE_DATEEND COLLATE Thai_CI_AI, 9, 10 ) AS PY_CDESUB,
          H.TEACHER COLLATE Thai_CI_AI Professor_NameT , H.REMARK COLLATE Thai_CI_AI REMARK
    FROM [eTraining].[dbo].HISTORY_TRAINING H WHERE H.PersonCode = '".$employeecode."'
  UNION ALL
    SELECT
      VH.PYE_PSC,VH.TC_CN,VH.TCS_CSNT,VH.TCS_CPPPS + VH.TC_CPPPS CPPPS,VH.PY_HXD,
      VH.PY_CDS,SUBSTRING (PY_CDS, 9, 10) AS PY_CDSSUB,VH.PY_CDE,
      SUBSTRING (PY_CDE, 9, 10) AS PY_CDESUB,VH.EMP3_COMCODE + '/' + VH.EMP3_FNT TEACHER,VH.RGTTSRM
    FROM [eTraining].[dbo].vwREPORTTRAININGHISTORY VH WHERE VH.PYE_PSC = '".$employeecode."' ORDER BY PY_CDS ASC";
    $params_sedata = array();
    
    
    
    $query_sedata = sqlsrv_query($conn, $sql_sedata, $params_sedata);
    while ($result_sedata = sqlsrv_fetch_array($query_sedata, SQLSRV_FETCH_ASSOC)) {
 
      
      $PATTERNDATE =$result_sedata['PY_CDS'];
      $PATTERNEND =$result_sedata['PY_CDE'];

      $DSSUB = explode("-", $PATTERNDATE);
      $PY_CDSSUB=$DSSUB[2].'/'.$DSSUB[1].'/'.$DSSUB[0];
      $DESUB = explode("-", $PATTERNEND);
      $PY_CDESUB=$DESUB[2].'/'.$DESUB[1].'/'.$DESUB[0];
	  
        $tbody3 .= '
        <tr style="border:1px solid #000;padding:10px;">
          <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 10%;font-size:16px">'.$i.'</td>
          <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 10%;font-size:16px">'.$PY_CDSSUB.'</td>
          <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 10%;font-size:16px">'.$PY_CDESUB.'</td>
          <td style="border-right:1px solid #000;padding:10px;text-align:left;width: 70%;font-size:16px">'.$result_sedata['Patern_Name'].'</td>
          <td style="border-right:1px solid #000;padding:10px;text-align:left;width: 20%;font-size:16px">'.$result_sedata['Patern_descrition'].'</td>
          <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 5%;font-size:16px">'.$result_sedata['Patern_Hour'].'</td>
          <td style="border-right:1px solid #000;padding:10px;text-align:left;width: 5%;font-size:16px">'.$result_sedata['Professor_NameT'].'</td>
          <td style="border-right:1px solid #000;padding:10px;text-align:left;width: 5%;font-size:16px">'.$result_sedata['REMARK'].'</td>
        </tr>';
      
      $i++;
    }

$table_end3 = '</table>';
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table1);

//  helthhistory Data Last Year
if ($result_seCountHealthLastYear['COUNTHEALTH_LASTYEAR'] > 0) {
  $mpdf->WriteHTML($table_header2lastyear);
  $mpdf->WriteHTML($table_begin2lastyear);
  $mpdf->WriteHTML($thead2lastyear);
  $mpdf->WriteHTML($tbody2lastyear);
  $mpdf->WriteHTML($table_end2lastyear);
  // $mpdf->Output();
}else {
  $mpdf->WriteHTML($table_header2);
  // $mpdf->Output();
}

$mpdf->AddPage();
//  helthhistory Data
if ($result_seCountHealth['COUNTHEALTH'] > 0) {
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
$mpdf->AddPage();
// if ($result_seCountTraining["COUNTTRAINING"]  > 0) {
if ($CALTCS_CSNT  > 0) {
  $mpdf->WriteHTML($table_header3);
  $mpdf->WriteHTML($table_begin3);
  $mpdf->WriteHTML($thead3);
  $mpdf->WriteHTML($tbody3);
  $mpdf->WriteHTML($table_end3);
  // $mpdf->Output();
}else {
  $mpdf->WriteHTML($table_header3);
  // $mpdf->WriteHTML($table_begin3);
  // $mpdf->WriteHTML($thead3);
  // $mpdf->Output();
}

$mpdf->Output();

sqlsrv_close($conn);
?>
