
<?php

require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
//$mpdf = new mPDF();
$mpdf = new mPDF('th', 'A4', '0', '');

//หารหัสจากชื่อ
$employee1 = " AND a.nameT = '" . $_GET['drivername'] . "'";
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

//COUNT ACCIDENT
$sql_seCountAccident = "SELECT  COUNT(ACCI_ID) AS 'COUNTACCI'
FROM [dbo].[ACCIDENTHISTORY]
WHERE DRIVERCODE ='".$result_seEmp1['PersonCode']."'";
$query_seCountAccident = sqlsrv_query($conn, $sql_seCountAccident, $params_seCountAccident);
$result_seCountAccident = sqlsrv_fetch_array($query_seCountAccident, SQLSRV_FETCH_ASSOC);

//COUNT ROUTE HISTORY
$sql_seCountRoute = "SELECT COUNT(VEHICLETRANSPORTPLANID) AS 'COUNTPLAN'
FROM  [dbo].[VEHICLETRANSPORTPLAN] 
WHERE (EMPLOYEECODE1 ='".$_GET['employeecode']."' OR EMPLOYEECODE2 ='".$_GET['employeecode']."')
AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestartroute']."',103) AND CONVERT(DATE,'".$_GET['dateendroute']."',103)";
$query_seCountRoute = sqlsrv_query($conn, $sql_seCountRoute, $params_seCountRoute);
$result_seCountRoute = sqlsrv_fetch_array($query_seCountRoute, SQLSRV_FETCH_ASSOC);


//COUNT HEALTHHISTORY
$currentyear = date("Y");
$sql_seCountHealth = "SELECT  COUNT(ID) AS 'COUNTHEALTH'
FROM [dbo].[HEALTHHISTORY]
WHERE EMPLOYEECODE ='".$result_seEmp1['PersonCode']."'
AND CREATEYEAR ='".$currentyear."'
AND ACTIVESTATUS ='1'";
$query_seCountHealth = sqlsrv_query($conn, $sql_seCountHealth, $params_seCountHealth);
$result_seCountHealth = sqlsrv_fetch_array($query_seCountHealth, SQLSRV_FETCH_ASSOC);

//COUNT TRANNING
$sql_seCountTrain = "SELECT  COUNT(a.Patern_ID) AS 'COUNTTRANING'
FROM [203.150.225.30].[TigerE-HR].dbo.TN_Patern__Course a
INNER JOIN [203.150.225.30].[TigerE-HR].dbo.TN_TrainPerson b ON b.Patern_ID = a.Patern_ID
INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNT_Person c ON c.PersonID = b.PersonID
WHERE c.PersonCode ='".$result_seEmp1['PersonCode']."'
AND YEAR(a.Patern_Date) BETWEEN '".$_GET['yeartrainstart']."' AND '".$_GET['yeartrainend']."'";
$query_seCountTrain  = sqlsrv_query($conn, $sql_seCountTrain, $params_seCountTrain);
$result_seCountTrain = sqlsrv_fetch_array($query_seCountTrain, SQLSRV_FETCH_ASSOC);

//COUNT TENKO HISTORY
//sub str เอาแค่เดือนกับปี 
$date =  substr($_GET['datetenko'],2,8);

//เช็ควันสุดท้ายของเดือนที่เลือก
$dateendchk = str_replace("/","-",$_GET['datetenko']);
$ChkMonth = date("t", strtotime($dateendchk));

$sql_seCountTenko = "SELECT COUNT(b.TENKOMASTERID) AS 'COUNTTENKO'
FROM  TENKOBEFORE b
WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
AND CONVERT(DATE,b.CREATEDATE) BETWEEN CONVERT(DATE,'01".$date."',103) AND CONVERT(DATE,'".$ChkMonth.$date."',103)";
$query_seCountTenko = sqlsrv_query($conn, $sql_seCountTenko, $params_seCountTenko);
$result_seCountTenko = sqlsrv_fetch_array($query_seCountTenko, SQLSRV_FETCH_ASSOC);

$firstdate = '01'.$date;

$sql_seAdddateweek = "{call megGetdate_v2(?,?)}";
$params_seAdddateweek = array(
    array('select_dategraph', SQLSRV_PARAM_IN),
    array($firstdate, SQLSRV_PARAM_IN)
);
$query_seAdddateweek = sqlsrv_query($conn, $sql_seAdddateweek, $params_seAdddateweek);
$result_seAdddateweek = sqlsrv_fetch_array($query_seAdddateweek, SQLSRV_FETCH_ASSOC);
//echo $result_seAdddateweek['D1'] . '|' . $result_seAdddateweek['D2'] . '|' . $result_seAdddateweek['D3'] . '|' . $result_seAdddateweek['D4'] . '|' . $result_seAdddateweek['D5'] . '|' . $result_seAdddateweek['D6'] . '|' . $result_seAdddateweek['D7'];



if ($ChkMonth == '28') { //chk เดือนที่มี 28 วัน
  // echo "28";
   /////////////////QUERY ค้นหาข้อมูล///////////////////////////////////////////////////
  //DAY1
  $sql_seDay1 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D1']."',103)";
  $params_seDay1 = array();
  $query_seDay1 = sqlsrv_query($conn, $sql_seDay1, $params_seDay1);
  $result_seDay1 = sqlsrv_fetch_array($query_seDay1, SQLSRV_FETCH_ASSOC);
  // SYSDAY1
  if($result_seDay1['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay1['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay1['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY1 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY1 = $result_seDay1['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY1 = $result_seDay1['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY1 = $result_seDay1['TENKOPRESSUREDATA_90160'] ; 
          
  }
  //DIADAY1
  if($result_seDay1['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay1['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay1['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY1 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY1 = $result_seDay1['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY1 = $result_seDay1['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY1 = $result_seDay1['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY1
  if($result_seDay1['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay1['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay1['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay1['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay1['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay1['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY1 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY1 = $result_seDay1['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY1 = $result_seDay1['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY1 = $result_seDay1['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY2
  $sql_seDay2 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D2']."',103)";
  $params_seDay2 = array();
  $query_seDay2 = sqlsrv_query($conn, $sql_seDay2, $params_seDay2);
  $result_seDay2 = sqlsrv_fetch_array($query_seDay2, SQLSRV_FETCH_ASSOC);
  // SYSDAY2
  if($result_seDay2['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay2['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay2['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY2 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY2 = $result_seDay2['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY2 = $result_seDay2['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY2 = $result_seDay2['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY2
  if($result_seDay2['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay2['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay2['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY2 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY2 = $result_seDay2['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY2 = $result_seDay2['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY2 = $result_seDay2['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY2
  if($result_seDay2['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay2['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay2['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay2['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay2['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay2['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY2 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY2 = $result_seDay2['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY2 = $result_seDay2['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY2 = $result_seDay2['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY3
  $sql_seDay3 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D3']."',103)";
  $params_seDay3 = array();
  $query_seDay3 = sqlsrv_query($conn, $sql_seDay3, $params_seDay3);
  $result_seDay3 = sqlsrv_fetch_array($query_seDay3, SQLSRV_FETCH_ASSOC);
  // SYSDAY3
  if($result_seDay3['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay3['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay3['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY3 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY3 = $result_seDay3['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY3 = $result_seDay3['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY3 = $result_seDay3['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY3
  if($result_seDay3['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay3['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay3['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY3 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY3 = $result_seDay3['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY3 = $result_seDay3['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY3 = $result_seDay3['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY3
  if($result_seDay3['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay3['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay3['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay3['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay3['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay3['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY3 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY3 = $result_seDay3['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY3 = $result_seDay3['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY3 = $result_seDay3['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY4
  $sql_seDay4 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D4']."',103)";
  $params_seDay4 = array();
  $query_seDay4 = sqlsrv_query($conn, $sql_seDay4, $params_seDay4);
  $result_seDay4 = sqlsrv_fetch_array($query_seDay4, SQLSRV_FETCH_ASSOC);
  // SYSDAY4
  if($result_seDay4['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay4['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay4['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY4 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY4 = $result_seDay4['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY4 = $result_seDay4['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY4 = $result_seDay4['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY4
  if($result_seDay4['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay4['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay4['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY4 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY4 = $result_seDay4['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY4 = $result_seDay4['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY4 = $result_seDay4['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY4
  if($result_seDay4['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay4['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay4['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay4['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay4['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay4['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY4 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY4 = $result_seDay4['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY4 = $result_seDay4['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY4 = $result_seDay4['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY5
  $sql_seDay5 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D5']."',103)";
  $params_seDay5 = array();
  $query_seDay5 = sqlsrv_query($conn, $sql_seDay5, $params_seDay5);
  $result_seDay5 = sqlsrv_fetch_array($query_seDay5, SQLSRV_FETCH_ASSOC);
  // SYSDAY5
  if($result_seDay5['TENKOPRESSUREDATA_90160'] >= '140'){
      if ($result_seDay5['TENKOPRESSUREDATA_90160_2'] >= '140' ) {
          if ($result_seDay5['TENKOPRESSUREDATA_90160_3'] >= '140') {
              $SYSDAY5 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY5 = $result_seDay5['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY5 = $result_seDay5['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY5 = $result_seDay5['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY5
  if($result_seDay5['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay5['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay5['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY5 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY5 = $result_seDay5['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY5 = $result_seDay5['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY5 = $result_seDay5['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY5
  if($result_seDay5['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay5['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay5['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay5['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay5['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay5['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY5 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY5 = $result_seDay5['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY5 = $result_seDay5['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY5 = $result_seDay5['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY6
  $sql_seDay6 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D6']."',103)";
  $params_seDay6 = array();
  $query_seDay6 = sqlsrv_query($conn, $sql_seDay6, $params_seDay2);
  $result_seDay6 = sqlsrv_fetch_array($query_seDay6, SQLSRV_FETCH_ASSOC);
  // SYSDAY6
  if($result_seDay6['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay6['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay6['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY6 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY6 = $result_seDay6['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY6 = $result_seDay6['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY6 = $result_seDay6['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY6
  if($result_seDay6['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay6['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay6['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY6 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY6 = $result_seDay6['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY6 = $result_seDay6['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY6 = $result_seDay6['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY6
  if($result_seDay6['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay6['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay6['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay6['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay6['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay6['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY6 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY6 = $result_seDay6['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY6 = $result_seDay6['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY6 = $result_seDay6['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY7
  $sql_seDay7 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D7']."',103)";
  $params_seDay7 = array();
  $query_seDay7 = sqlsrv_query($conn, $sql_seDay7, $params_seDay7);
  $result_seDay7 = sqlsrv_fetch_array($query_seDay7, SQLSRV_FETCH_ASSOC);
  // SYSDAY7
  if($result_seDay7['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay7['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay7['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY7 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY7 = $result_seDay7['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY7 = $result_seDay7['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY7 = $result_seDay7['TENKOPRESSUREDATA_90160']; 
  }
  //DIADAY7
  if($result_seDay7['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay7['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay7['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY7 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY7 = $result_seDay7['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY7 = $result_seDay7['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY7 = $result_seDay7['TENKOPRESSUREDATA_60100'] ; 
          // $DIADAY71 = $result_seDay7['TENKOPRESSUREDATA_60100'] ; 
          // if ($DIADAY71 == '') {
          //     $DIADAY7 = '0';
          // }else {
          //     $DIADAY7 = $DIADAY71;
          // }
  }
  //PULSEDAY7
  if($result_seDay7['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay7['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay7['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay7['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay7['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay7['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY7 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY7 = $result_seDay7['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY7 = $result_seDay7['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY7 = $result_seDay7['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY8
  $sql_seDay8 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D8']."',103)";
  $params_seDay8 = array();
  $query_seDay8 = sqlsrv_query($conn, $sql_seDay8, $params_seDay8);
  $result_seDay8 = sqlsrv_fetch_array($query_seDay8, SQLSRV_FETCH_ASSOC);
  // SYSDAY2
  if($result_seDay8['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay8['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay8['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY8 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY8 = $result_seDay8['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY8 = $result_seDay8['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY8 = $result_seDay8['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY8
  if($result_seDay8['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay8['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay8['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY8 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY8 = $result_seDay8['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY8 = $result_seDay8['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY8 = $result_seDay8['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY8
  if($result_seDay8['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay8['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay8['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay8['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay8['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay8['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY8 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY8 = $result_seDay8['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY8 = $result_seDay8['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY8 = $result_seDay8['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY9
  $sql_seDay9 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D9']."',103)";
  $params_seDay9 = array();
  $query_seDay9 = sqlsrv_query($conn, $sql_seDay9, $params_seDay9);
  $result_seDay9 = sqlsrv_fetch_array($query_seDay9, SQLSRV_FETCH_ASSOC);
  // SYSDAY9
  if($result_seDay9['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay9['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay9['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY9 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY9 = $result_seDay9['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY9 = $result_seDay9['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY9 = $result_seDay9['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY9
  if($result_seDay9['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay9['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay9['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY9 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY9 = $result_seDay9['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY9 = $result_seDay9['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY9 = $result_seDay9['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY9
  if($result_seDay9['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay9['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay9['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay9['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay9['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay9['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY9 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY9 = $result_seDay9['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY9 = $result_seDay9['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY9 = $result_seDay9['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY10
  $sql_seDay10 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D10']."',103)";
  $params_seDay10 = array();
  $query_seDay10 = sqlsrv_query($conn, $sql_seDay10, $params_seDay10);
  $result_seDay10 = sqlsrv_fetch_array($query_seDay10, SQLSRV_FETCH_ASSOC);
  // SYSDAY10
  if($result_seDay10['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay10['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay10['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY10 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY10 = $result_seDay10['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY10 = $result_seDay10['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY10 = $result_seDay10['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY10
  if($result_seDay10['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay10['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay10['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY10 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY10 = $result_seDay10['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY10 = $result_seDay10['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY10 = $result_seDay10['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY10
  if($result_seDay10['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay10['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay10['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay10['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay10['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay10['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY10 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY10 = $result_seDay10['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY10 = $result_seDay10['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY10 = $result_seDay10['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY11
  $sql_seDay11 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D11']."',103)";
  $params_seDay11 = array();
  $query_seDay11 = sqlsrv_query($conn, $sql_seDay11, $params_seDay11);
  $result_seDay11 = sqlsrv_fetch_array($query_seDay11, SQLSRV_FETCH_ASSOC);
  // SYSDAY11
  if($result_seDay11['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay11['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay11['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY11 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY11 = $result_seDay11['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY11 = $result_seDay11['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY11 = $result_seDay11['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY11
  if($result_seDay11['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay11['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay11['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY11 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY11 = $result_seDay11['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY11 = $result_seDay11['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY11 = $result_seDay11['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY11
  if($result_seDay11['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay11['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay11['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay11['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay11['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay11['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY11 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY11 = $result_seDay11['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY11 = $result_seDay11['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY11 = $result_seDay11['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY12
  $sql_seDay12 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D12']."',103)";
  $params_seDay12 = array();
  $query_seDay12 = sqlsrv_query($conn, $sql_seDay12, $params_seDay12);
  $result_seDay12 = sqlsrv_fetch_array($query_seDay12, SQLSRV_FETCH_ASSOC);
  // SYSDAY2
  if($result_seDay12['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay12['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay12['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY2 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY12 = $result_seDay12['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY12 = $result_seDay12['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY12 = $result_seDay12['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY12
  if($result_seDay12['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay12['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay12['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY12 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY12 = $result_seDay12['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY12 = $result_seDay12['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY12 = $result_seDay12['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY12
  if($result_seDay12['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay12['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay12['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay12['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay12['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay12['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY12 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY12 = $result_seDay12['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY12 = $result_seDay12['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY12 = $result_seDay12['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY13
  $sql_seDay13 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D13']."',103)";
  $params_seDay13 = array();
  $query_seDay13 = sqlsrv_query($conn, $sql_seDay13, $params_seDay13);
  $result_seDay13 = sqlsrv_fetch_array($query_seDay13, SQLSRV_FETCH_ASSOC);
  // SYSDAY13
  if($result_seDay13['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay13['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay13['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY13 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY13 = $result_seDay13['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY13 = $result_seDay13['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY13 = $result_seDay13['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY13
  if($result_seDay13['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay13['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay13['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY13 = ''; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY13 = $result_seDay13['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY13 = $result_seDay13['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY13 = $result_seDay13['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY13
  if($result_seDay13['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay13['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay13['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay13['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay13['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay13['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY13 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY13 = $result_seDay13['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY13 = $result_seDay13['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY13 = $result_seDay13['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY14
  $sql_seDay14 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D14']."',103)";
  $params_seDay14 = array();
  $query_seDay14 = sqlsrv_query($conn, $sql_seDay14, $params_seDay14);
  $result_seDay14 = sqlsrv_fetch_array($query_seDay14, SQLSRV_FETCH_ASSOC);
  // SYSDAY14
  if($result_seDay14['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay14['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay14['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY14 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY14 = $result_seDay14['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY14 = $result_seDay14['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY14 = $result_seDay14['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY14
  if($result_seDay14['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay14['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay14['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY14 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY14 = $result_seDay14['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY14 = $result_seDay14['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY14 = $result_seDay14['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY14
  if($result_seDay14['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay14['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay14['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay14['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay14['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay14['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY14 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY14 = $result_seDay14['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY14 = $result_seDay14['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY14 = $result_seDay14['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY15
  $sql_seDay15 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D15']."',103)";
  $params_seDay15 = array();
  $query_seDay15 = sqlsrv_query($conn, $sql_seDay15, $params_seDay15);
  $result_seDay15 = sqlsrv_fetch_array($query_seDay15, SQLSRV_FETCH_ASSOC);
  // SYSDAY15
  if($result_seDay15['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay15['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay15['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY15 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY15 = $result_seDay15['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY15 = $result_seDay15['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY15 = $result_seDay15['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY15
  if($result_seDay15['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay15['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay15['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY15 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY15 = $result_seDay15['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY15 = $result_seDay15['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY15 = $result_seDay15['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY15
  if($result_seDay15['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay15['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay15['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay15['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay15['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay15['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY15 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY15 = $result_seDay15['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY15 = $result_seDay15['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY15 = $result_seDay15['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY16
  $sql_seDay16 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D16']."',103)";
  $params_seDay16 = array();
  $query_seDay16 = sqlsrv_query($conn, $sql_seDay16, $params_seDay16);
  $result_seDay16 = sqlsrv_fetch_array($query_seDay16, SQLSRV_FETCH_ASSOC);
  // SYSDAY16
  if($result_seDay16['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay16['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay16['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY16 = ''; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY16 = $result_seDay16['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY16 = $result_seDay16['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY16 = $result_seDay16['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY16
  if($result_seDay16['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay16['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay16['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY16 = ''; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY16 = $result_seDay16['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY16 = $result_seDay16['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY16 = $result_seDay16['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY16
  if($result_seDay16['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay16['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay16['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay16['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay16['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay16['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY16 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY16 = $result_seDay16['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY16 = $result_seDay16['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY16 = $result_seDay16['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY17
  $sql_seDay17 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D17']."',103)";
  $params_seDay17 = array();
  $query_seDay17 = sqlsrv_query($conn, $sql_seDay17, $params_seDay17);
  $result_seDay17 = sqlsrv_fetch_array($query_seDay17, SQLSRV_FETCH_ASSOC);
  // SYSDAY17
  if($result_seDay17['TENKOPRESSUREDATA_90160'] >= '140'){
      if ($result_seDay17['TENKOPRESSUREDATA_90160_2'] >= '140' ) {
          if ($result_seDay17['TENKOPRESSUREDATA_90160_3'] >= '140') {
              $SYSDAY17 = ''; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY17 = $result_seDay17['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY17 = $result_seDay17['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY17 = $result_seDay17['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY17
  if($result_seDay17['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay17['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay17['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY17 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY17 = $result_seDay17['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY17 = $result_seDay17['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY17 = $result_seDay17['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY17
  if($result_seDay17['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay17['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay17['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay17['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay17['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay17['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY17 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY17 = $result_seDay17['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY17 = $result_seDay17['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY17 = $result_seDay17['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY18
  $sql_seDay18 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D18']."',103)";
  $params_seDay18 = array();
  $query_seDay18 = sqlsrv_query($conn, $sql_seDay18, $params_seDay18);
  $result_seDay18 = sqlsrv_fetch_array($query_seDay18, SQLSRV_FETCH_ASSOC);
  // SYSDAY18
  if($result_seDay18['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay18['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay18['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY18 = ''; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY18 = $result_seDay18['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY18 = $result_seDay18['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY18 = $result_seDay18['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY18
  if($result_seDay18['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay18['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay18['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY18 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY18 = $result_seDay18['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY18 = $result_seDay18['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY18 = $result_seDay18['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY18
  if($result_seDay18['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay18['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay18['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay18['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay18['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay18['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY18 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY18 = $result_seDay18['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY18 = $result_seDay18['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY18 = $result_seDay18['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY19
  $sql_seDay19 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D19']."',103)";
  $params_seDay19 = array();
  $query_seDay19 = sqlsrv_query($conn, $sql_seDay19, $params_seDay19);
  $result_seDay19 = sqlsrv_fetch_array($query_seDay19, SQLSRV_FETCH_ASSOC);
  // SYSDAY19
  if($result_seDay19['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay19['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay19['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY19 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY19 = $result_seDay19['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY19 = $result_seDay19['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY19 = $result_seDay19['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY19
  if($result_seDay19['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay19['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay19['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY19 = ''; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY19 = $result_seDay19['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY19 = $result_seDay19['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY19 = $result_seDay19['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY19
  if($result_seDay19['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay19['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay19['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay19['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay19['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay19['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY19 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY19 = $result_seDay19['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY19 = $result_seDay19['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY19 = $result_seDay19['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY20
  $sql_seDay20 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D20']."',103)";
  $params_seDay20 = array();
  $query_seDay20 = sqlsrv_query($conn, $sql_seDay20, $params_seDay20);
  $result_seDay20 = sqlsrv_fetch_array($query_seDay20, SQLSRV_FETCH_ASSOC);
  // SYSDAY20
  if($result_seDay20['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay20['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay20['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY20 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY20 = $result_seDay20['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY20 = $result_seDay20['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY20 = $result_seDay20['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY20
  if($result_seDay20['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay20['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay20['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY20 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY20 = $result_seDay20['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY20 = $result_seDay20['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY20 = $result_seDay20['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY20
  if($result_seDay20['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay20['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay20['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay20['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay20['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay20['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY20 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY20 = $result_seDay20['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY20 = $result_seDay20['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY20 = $result_seDay20['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY21
  $sql_seDay21 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D21']."',103)";
  $params_seDay21 = array();
  $query_seDay21 = sqlsrv_query($conn, $sql_seDay21, $params_seDay21);
  $result_seDay21 = sqlsrv_fetch_array($query_seDay21, SQLSRV_FETCH_ASSOC);
  // SYSDAY21
  if($result_seDay21['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay21['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay21['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY21 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY21 = $result_seDay21['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY21 = $result_seDay21['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY21 = $result_seDay21['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY21
  if($result_seDay21['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay21['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay21['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY21 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY21 = $result_seDay21['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY21 = $result_seDay21['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY21 = $result_seDay21['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY21
  if($result_seDay21['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay21['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay21['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay21['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay21['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay21['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY21 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY21 = $result_seDay21['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY21 = $result_seDay21['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY21 = $result_seDay21['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY22
  $sql_seDay22 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D22']."',103)";
  $params_seDay22 = array();
  $query_seDay22 = sqlsrv_query($conn, $sql_seDay22, $params_seDay22);
  $result_seDay22 = sqlsrv_fetch_array($query_seDay22, SQLSRV_FETCH_ASSOC);
  // SYSDAY22
  if($result_seDay22['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay22['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay22['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY22 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY22 = $result_seDay22['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY22 = $result_seDay22['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY22 = $result_seDay22['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY22
  if($result_seDay22['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay22['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay22['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY22 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY22 = $result_seDay22['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY22 = $result_seDay22['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY22 = $result_seDay22['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY22
  if($result_seDay22['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay22['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay22['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay22['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay22['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay22['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY22 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY22 = $result_seDay22['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY22 = $result_seDay22['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY22 = $result_seDay22['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY23
  $sql_seDay23 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D23']."',103)";
  $params_seDay23 = array();
  $query_seDay23 = sqlsrv_query($conn, $sql_seDay23, $params_seDay23);
  $result_seDay23 = sqlsrv_fetch_array($query_seDay23, SQLSRV_FETCH_ASSOC);
  // SYSDAY2
  if($result_seDay23['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay23['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay23['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY23 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY23 = $result_seDay23['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY23 = $result_seDay23['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY23 = $result_seDay23['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY23
  if($result_seDay23['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay23['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay23['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY23 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY23 = $result_seDay23['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY23 = $result_seDay23['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY23 = $result_seDay23['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY23
  if($result_seDay23['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay23['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay23['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay23['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay23['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay23['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY23 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY23 = $result_seDay23['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY23 = $result_seDay23['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY23 = $result_seDay23['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY24
  $sql_seDay24 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D24']."',103)";
  $params_seDay24 = array();
  $query_seDay24 = sqlsrv_query($conn, $sql_seDay24, $params_seDay24);
  $result_seDay24 = sqlsrv_fetch_array($query_seDay24, SQLSRV_FETCH_ASSOC);
  // SYSDAY24
  if($result_seDay24['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay24['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay24['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY24 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY24 = $result_seDay24['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY24 = $result_seDay24['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY24 = $result_seDay24['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY24
  if($result_seDay24['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay24['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay24['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY24 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY24 = $result_seDay24['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY24 = $result_seDay24['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY24 = $result_seDay24['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY24
  if($result_seDay24['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay24['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay24['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay24['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay24['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay24['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY24 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY24 = $result_seDay24['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY24 = $result_seDay24['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY24 = $result_seDay24['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY25
  $sql_seDay25 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D25']."',103)";
  $params_seDay25 = array();
  $query_seDay25 = sqlsrv_query($conn, $sql_seDay25, $params_seDay25);
  $result_seDay25 = sqlsrv_fetch_array($query_seDay25, SQLSRV_FETCH_ASSOC);
  // SYSDAY25
  if($result_seDay25['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay25['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay25['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY25 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY25 = $result_seDay25['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY25 = $result_seDay25['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY25 = $result_seDay25['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY2
  if($result_seDay25['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay25['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay25['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY25 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY25 = $result_seDay25['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY25 = $result_seDay25['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY25 = $result_seDay25['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY25
  if($result_seDay25['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay25['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay25['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay25['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay25['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay25['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY25 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY25 = $result_seDay25['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY25 = $result_seDay25['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY25 = $result_seDay25['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY26
  $sql_seDay26 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D26']."',103)";
  $params_seDay26 = array();
  $query_seDay26 = sqlsrv_query($conn, $sql_seDay26, $params_seDay26);
  $result_seDay26 = sqlsrv_fetch_array($query_seDay26, SQLSRV_FETCH_ASSOC);
  // SYSDAY26
  if($result_seDay26['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay26['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay26['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY26 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY26 = $result_seDay26['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY26 = $result_seDay26['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY26 = $result_seDay26['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY26
  if($result_seDay26['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay26['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay26['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY26 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY26 = $result_seDay26['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY26 = $result_seDay26['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY26 = $result_seDay26['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY26
  if($result_seDay26['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay26['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay26['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay26['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay26['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay26['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY26 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY26 = $result_seDay26['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY26 = $result_seDay26['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY26 = $result_seDay26['TENKOPRESSUREDATA_60110'] ; 
  }

  //////////////////////////////////////////////////////////////////////

  //DAY27
  $sql_seDay27 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D27']."',103)";
  $params_seDay27 = array();
  $query_seDay27 = sqlsrv_query($conn, $sql_seDay27, $params_seDay27);
  $result_seDay27 = sqlsrv_fetch_array($query_seDay27, SQLSRV_FETCH_ASSOC);
  // SYSDAY27
  if($result_seDay27['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay27['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay27['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY27 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY27 = $result_seDay27['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY27 = $result_seDay27['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY27 = $result_seDay27['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY27
  if($result_seDay27['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay27['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay27['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY27 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY27 = $result_seDay27['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY27 = $result_seDay27['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY27 = $result_seDay27['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY27
  if($result_seDay27['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay27['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay27['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay27['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay27['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay27['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY27 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY27 = $result_seDay27['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY27 = $result_seDay27['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY27 = $result_seDay27['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////

  //DAY28
  $sql_seDay28 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D28']."',103)";
  $params_seDay28 = array();
  $query_seDay28 = sqlsrv_query($conn, $sql_seDay28, $params_seDay28);
  $result_seDay28 = sqlsrv_fetch_array($query_seDay28, SQLSRV_FETCH_ASSOC);
  // SYSDAY28
  if($result_seDay28['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay28['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay28['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY28 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY28 = $result_seDay28['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY28 = $result_seDay28['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY28 = $result_seDay28['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY28
  if($result_seDay28['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay28['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay28['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY28 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY28 = $result_seDay28['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY28 = $result_seDay28['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY28 = $result_seDay28['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY28
  if($result_seDay28['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay28['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay28['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay28['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay28['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay28['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY28 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY28 = $result_seDay28['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY28 = $result_seDay28['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY28 = $result_seDay28['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  
}else if($ChkMonth == '29') { //chk เดือนที่มี 29 วัน
  // echo "29";
  /////////////////QUERY ค้นหาข้อมูล///////////////////////////////////////////////////
  //DAY1
  $sql_seDay1 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D1']."',103)";
  $params_seDay1 = array();
  $query_seDay1 = sqlsrv_query($conn, $sql_seDay1, $params_seDay1);
  $result_seDay1 = sqlsrv_fetch_array($query_seDay1, SQLSRV_FETCH_ASSOC);
  // SYSDAY1
  if($result_seDay1['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay1['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay1['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY1 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY1 = $result_seDay1['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY1 = $result_seDay1['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY1 = $result_seDay1['TENKOPRESSUREDATA_90160'] ; 
          
  }
  //DIADAY1
  if($result_seDay1['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay1['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay1['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY1 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY1 = $result_seDay1['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY1 = $result_seDay1['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY1 = $result_seDay1['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY1
  if($result_seDay1['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay1['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay1['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay1['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay1['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay1['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY1 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY1 = $result_seDay1['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY1 = $result_seDay1['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY1 = $result_seDay1['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY2
  $sql_seDay2 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D2']."',103)";
  $params_seDay2 = array();
  $query_seDay2 = sqlsrv_query($conn, $sql_seDay2, $params_seDay2);
  $result_seDay2 = sqlsrv_fetch_array($query_seDay2, SQLSRV_FETCH_ASSOC);
  // SYSDAY2
  if($result_seDay2['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay2['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay2['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY2 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY2 = $result_seDay2['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY2 = $result_seDay2['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY2 = $result_seDay2['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY2
  if($result_seDay2['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay2['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay2['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY2 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY2 = $result_seDay2['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY2 = $result_seDay2['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY2 = $result_seDay2['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY2
  if($result_seDay2['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay2['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay2['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay2['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay2['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay2['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY2 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY2 = $result_seDay2['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY2 = $result_seDay2['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY2 = $result_seDay2['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY3
  $sql_seDay3 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D3']."',103)";
  $params_seDay3 = array();
  $query_seDay3 = sqlsrv_query($conn, $sql_seDay3, $params_seDay3);
  $result_seDay3 = sqlsrv_fetch_array($query_seDay3, SQLSRV_FETCH_ASSOC);
  // SYSDAY3
  if($result_seDay3['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay3['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay3['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY3 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY3 = $result_seDay3['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY3 = $result_seDay3['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY3 = $result_seDay3['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY3
  if($result_seDay3['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay3['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay3['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY3 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY3 = $result_seDay3['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY3 = $result_seDay3['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY3 = $result_seDay3['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY3
  if($result_seDay3['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay3['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay3['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay3['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay3['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay3['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY3 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY3 = $result_seDay3['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY3 = $result_seDay3['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY3 = $result_seDay3['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY4
  $sql_seDay4 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D4']."',103)";
  $params_seDay4 = array();
  $query_seDay4 = sqlsrv_query($conn, $sql_seDay4, $params_seDay4);
  $result_seDay4 = sqlsrv_fetch_array($query_seDay4, SQLSRV_FETCH_ASSOC);
  // SYSDAY4
  if($result_seDay4['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay4['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay4['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY4 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY4 = $result_seDay4['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY4 = $result_seDay4['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY4 = $result_seDay4['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY4
  if($result_seDay4['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay4['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay4['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY4 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY4 = $result_seDay4['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY4 = $result_seDay4['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY4 = $result_seDay4['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY4
  if($result_seDay4['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay4['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay4['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay4['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay4['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay4['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY4 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY4 = $result_seDay4['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY4 = $result_seDay4['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY4 = $result_seDay4['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY5
  $sql_seDay5 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D5']."',103)";
  $params_seDay5 = array();
  $query_seDay5 = sqlsrv_query($conn, $sql_seDay5, $params_seDay5);
  $result_seDay5 = sqlsrv_fetch_array($query_seDay5, SQLSRV_FETCH_ASSOC);
  // SYSDAY5
  if($result_seDay5['TENKOPRESSUREDATA_90160'] >= '140'){
      if ($result_seDay5['TENKOPRESSUREDATA_90160_2'] >= '140' ) {
          if ($result_seDay5['TENKOPRESSUREDATA_90160_3'] >= '140') {
              $SYSDAY5 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY5 = $result_seDay5['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY5 = $result_seDay5['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY5 = $result_seDay5['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY5
  if($result_seDay5['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay5['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay5['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY5 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY5 = $result_seDay5['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY5 = $result_seDay5['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY5 = $result_seDay5['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY5
  if($result_seDay5['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay5['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay5['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay5['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay5['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay5['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY5 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY5 = $result_seDay5['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY5 = $result_seDay5['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY5 = $result_seDay5['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY6
  $sql_seDay6 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D6']."',103)";
  $params_seDay6 = array();
  $query_seDay6 = sqlsrv_query($conn, $sql_seDay6, $params_seDay2);
  $result_seDay6 = sqlsrv_fetch_array($query_seDay6, SQLSRV_FETCH_ASSOC);
  // SYSDAY6
  if($result_seDay6['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay6['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay6['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY6 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY6 = $result_seDay6['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY6 = $result_seDay6['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY6 = $result_seDay6['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY6
  if($result_seDay6['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay6['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay6['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY6 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY6 = $result_seDay6['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY6 = $result_seDay6['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY6 = $result_seDay6['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY6
  if($result_seDay6['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay6['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay6['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay6['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay6['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay6['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY6 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY6 = $result_seDay6['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY6 = $result_seDay6['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY6 = $result_seDay6['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY7
  $sql_seDay7 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D7']."',103)";
  $params_seDay7 = array();
  $query_seDay7 = sqlsrv_query($conn, $sql_seDay7, $params_seDay7);
  $result_seDay7 = sqlsrv_fetch_array($query_seDay7, SQLSRV_FETCH_ASSOC);
  // SYSDAY7
  if($result_seDay7['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay7['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay7['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY7 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY7 = $result_seDay7['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY7 = $result_seDay7['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY7 = $result_seDay7['TENKOPRESSUREDATA_90160']; 
  }
  //DIADAY7
  if($result_seDay7['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay7['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay7['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY7 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY7 = $result_seDay7['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY7 = $result_seDay7['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY7 = $result_seDay7['TENKOPRESSUREDATA_60100'] ; 
          // $DIADAY71 = $result_seDay7['TENKOPRESSUREDATA_60100'] ; 
          // if ($DIADAY71 == '') {
          //     $DIADAY7 = '0';
          // }else {
          //     $DIADAY7 = $DIADAY71;
          // }
  }
  //PULSEDAY7
  if($result_seDay7['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay7['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay7['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay7['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay7['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay7['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY7 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY7 = $result_seDay7['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY7 = $result_seDay7['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY7 = $result_seDay7['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY8
  $sql_seDay8 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D8']."',103)";
  $params_seDay8 = array();
  $query_seDay8 = sqlsrv_query($conn, $sql_seDay8, $params_seDay8);
  $result_seDay8 = sqlsrv_fetch_array($query_seDay8, SQLSRV_FETCH_ASSOC);
  // SYSDAY2
  if($result_seDay8['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay8['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay8['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY8 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY8 = $result_seDay8['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY8 = $result_seDay8['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY8 = $result_seDay8['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY8
  if($result_seDay8['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay8['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay8['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY8 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY8 = $result_seDay8['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY8 = $result_seDay8['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY8 = $result_seDay8['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY8
  if($result_seDay8['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay8['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay8['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay8['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay8['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay8['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY8 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY8 = $result_seDay8['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY8 = $result_seDay8['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY8 = $result_seDay8['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY9
  $sql_seDay9 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D9']."',103)";
  $params_seDay9 = array();
  $query_seDay9 = sqlsrv_query($conn, $sql_seDay9, $params_seDay9);
  $result_seDay9 = sqlsrv_fetch_array($query_seDay9, SQLSRV_FETCH_ASSOC);
  // SYSDAY9
  if($result_seDay9['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay9['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay9['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY9 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY9 = $result_seDay9['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY9 = $result_seDay9['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY9 = $result_seDay9['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY9
  if($result_seDay9['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay9['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay9['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY9 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY9 = $result_seDay9['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY9 = $result_seDay9['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY9 = $result_seDay9['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY9
  if($result_seDay9['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay9['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay9['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay9['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay9['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay9['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY9 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY9 = $result_seDay9['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY9 = $result_seDay9['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY9 = $result_seDay9['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY10
  $sql_seDay10 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D10']."',103)";
  $params_seDay10 = array();
  $query_seDay10 = sqlsrv_query($conn, $sql_seDay10, $params_seDay10);
  $result_seDay10 = sqlsrv_fetch_array($query_seDay10, SQLSRV_FETCH_ASSOC);
  // SYSDAY10
  if($result_seDay10['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay10['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay10['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY10 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY10 = $result_seDay10['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY10 = $result_seDay10['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY10 = $result_seDay10['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY10
  if($result_seDay10['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay10['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay10['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY10 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY10 = $result_seDay10['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY10 = $result_seDay10['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY10 = $result_seDay10['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY10
  if($result_seDay10['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay10['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay10['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay10['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay10['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay10['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY10 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY10 = $result_seDay10['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY10 = $result_seDay10['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY10 = $result_seDay10['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY11
  $sql_seDay11 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D11']."',103)";
  $params_seDay11 = array();
  $query_seDay11 = sqlsrv_query($conn, $sql_seDay11, $params_seDay11);
  $result_seDay11 = sqlsrv_fetch_array($query_seDay11, SQLSRV_FETCH_ASSOC);
  // SYSDAY11
  if($result_seDay11['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay11['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay11['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY11 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY11 = $result_seDay11['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY11 = $result_seDay11['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY11 = $result_seDay11['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY11
  if($result_seDay11['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay11['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay11['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY11 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY11 = $result_seDay11['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY11 = $result_seDay11['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY11 = $result_seDay11['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY11
  if($result_seDay11['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay11['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay11['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay11['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay11['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay11['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY11 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY11 = $result_seDay11['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY11 = $result_seDay11['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY11 = $result_seDay11['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY12
  $sql_seDay12 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D12']."',103)";
  $params_seDay12 = array();
  $query_seDay12 = sqlsrv_query($conn, $sql_seDay12, $params_seDay12);
  $result_seDay12 = sqlsrv_fetch_array($query_seDay12, SQLSRV_FETCH_ASSOC);
  // SYSDAY2
  if($result_seDay12['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay12['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay12['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY2 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY12 = $result_seDay12['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY12 = $result_seDay12['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY12 = $result_seDay12['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY12
  if($result_seDay12['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay12['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay12['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY12 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY12 = $result_seDay12['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY12 = $result_seDay12['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY12 = $result_seDay12['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY12
  if($result_seDay12['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay12['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay12['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay12['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay12['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay12['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY12 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY12 = $result_seDay12['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY12 = $result_seDay12['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY12 = $result_seDay12['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY13
  $sql_seDay13 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D13']."',103)";
  $params_seDay13 = array();
  $query_seDay13 = sqlsrv_query($conn, $sql_seDay13, $params_seDay13);
  $result_seDay13 = sqlsrv_fetch_array($query_seDay13, SQLSRV_FETCH_ASSOC);
  // SYSDAY13
  if($result_seDay13['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay13['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay13['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY13 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY13 = $result_seDay13['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY13 = $result_seDay13['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY13 = $result_seDay13['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY13
  if($result_seDay13['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay13['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay13['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY13 = ''; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY13 = $result_seDay13['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY13 = $result_seDay13['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY13 = $result_seDay13['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY13
  if($result_seDay13['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay13['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay13['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay13['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay13['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay13['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY13 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY13 = $result_seDay13['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY13 = $result_seDay13['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY13 = $result_seDay13['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY14
  $sql_seDay14 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D14']."',103)";
  $params_seDay14 = array();
  $query_seDay14 = sqlsrv_query($conn, $sql_seDay14, $params_seDay14);
  $result_seDay14 = sqlsrv_fetch_array($query_seDay14, SQLSRV_FETCH_ASSOC);
  // SYSDAY14
  if($result_seDay14['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay14['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay14['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY14 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY14 = $result_seDay14['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY14 = $result_seDay14['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY14 = $result_seDay14['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY14
  if($result_seDay14['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay14['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay14['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY14 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY14 = $result_seDay14['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY14 = $result_seDay14['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY14 = $result_seDay14['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY14
  if($result_seDay14['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay14['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay14['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay14['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay14['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay14['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY14 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY14 = $result_seDay14['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY14 = $result_seDay14['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY14 = $result_seDay14['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY15
  $sql_seDay15 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D15']."',103)";
  $params_seDay15 = array();
  $query_seDay15 = sqlsrv_query($conn, $sql_seDay15, $params_seDay15);
  $result_seDay15 = sqlsrv_fetch_array($query_seDay15, SQLSRV_FETCH_ASSOC);
  // SYSDAY15
  if($result_seDay15['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay15['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay15['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY15 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY15 = $result_seDay15['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY15 = $result_seDay15['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY15 = $result_seDay15['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY15
  if($result_seDay15['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay15['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay15['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY15 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY15 = $result_seDay15['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY15 = $result_seDay15['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY15 = $result_seDay15['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY15
  if($result_seDay15['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay15['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay15['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay15['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay15['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay15['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY15 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY15 = $result_seDay15['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY15 = $result_seDay15['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY15 = $result_seDay15['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY16
  $sql_seDay16 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D16']."',103)";
  $params_seDay16 = array();
  $query_seDay16 = sqlsrv_query($conn, $sql_seDay16, $params_seDay16);
  $result_seDay16 = sqlsrv_fetch_array($query_seDay16, SQLSRV_FETCH_ASSOC);
  // SYSDAY16
  if($result_seDay16['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay16['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay16['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY16 = ''; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY16 = $result_seDay16['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY16 = $result_seDay16['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY16 = $result_seDay16['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY16
  if($result_seDay16['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay16['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay16['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY16 = ''; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY16 = $result_seDay16['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY16 = $result_seDay16['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY16 = $result_seDay16['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY16
  if($result_seDay16['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay16['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay16['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay16['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay16['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay16['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY16 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY16 = $result_seDay16['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY16 = $result_seDay16['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY16 = $result_seDay16['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY17
  $sql_seDay17 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D17']."',103)";
  $params_seDay17 = array();
  $query_seDay17 = sqlsrv_query($conn, $sql_seDay17, $params_seDay17);
  $result_seDay17 = sqlsrv_fetch_array($query_seDay17, SQLSRV_FETCH_ASSOC);
  // SYSDAY17
  if($result_seDay17['TENKOPRESSUREDATA_90160'] >= '140'){
      if ($result_seDay17['TENKOPRESSUREDATA_90160_2'] >= '140' ) {
          if ($result_seDay17['TENKOPRESSUREDATA_90160_3'] >= '140') {
              $SYSDAY17 = ''; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY17 = $result_seDay17['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY17 = $result_seDay17['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY17 = $result_seDay17['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY17
  if($result_seDay17['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay17['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay17['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY17 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY17 = $result_seDay17['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY17 = $result_seDay17['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY17 = $result_seDay17['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY17
  if($result_seDay17['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay17['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay17['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay17['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay17['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay17['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY17 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY17 = $result_seDay17['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY17 = $result_seDay17['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY17 = $result_seDay17['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY18
  $sql_seDay18 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D18']."',103)";
  $params_seDay18 = array();
  $query_seDay18 = sqlsrv_query($conn, $sql_seDay18, $params_seDay18);
  $result_seDay18 = sqlsrv_fetch_array($query_seDay18, SQLSRV_FETCH_ASSOC);
  // SYSDAY18
  if($result_seDay18['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay18['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay18['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY18 = ''; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY18 = $result_seDay18['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY18 = $result_seDay18['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY18 = $result_seDay18['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY18
  if($result_seDay18['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay18['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay18['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY18 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY18 = $result_seDay18['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY18 = $result_seDay18['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY18 = $result_seDay18['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY18
  if($result_seDay18['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay18['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay18['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay18['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay18['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay18['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY18 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY18 = $result_seDay18['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY18 = $result_seDay18['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY18 = $result_seDay18['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY19
  $sql_seDay19 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D19']."',103)";
  $params_seDay19 = array();
  $query_seDay19 = sqlsrv_query($conn, $sql_seDay19, $params_seDay19);
  $result_seDay19 = sqlsrv_fetch_array($query_seDay19, SQLSRV_FETCH_ASSOC);
  // SYSDAY19
  if($result_seDay19['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay19['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay19['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY19 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY19 = $result_seDay19['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY19 = $result_seDay19['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY19 = $result_seDay19['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY19
  if($result_seDay19['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay19['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay19['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY19 = ''; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY19 = $result_seDay19['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY19 = $result_seDay19['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY19 = $result_seDay19['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY19
  if($result_seDay19['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay19['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay19['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay19['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay19['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay19['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY19 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY19 = $result_seDay19['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY19 = $result_seDay19['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY19 = $result_seDay19['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY20
  $sql_seDay20 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D20']."',103)";
  $params_seDay20 = array();
  $query_seDay20 = sqlsrv_query($conn, $sql_seDay20, $params_seDay20);
  $result_seDay20 = sqlsrv_fetch_array($query_seDay20, SQLSRV_FETCH_ASSOC);
  // SYSDAY20
  if($result_seDay20['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay20['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay20['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY20 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY20 = $result_seDay20['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY20 = $result_seDay20['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY20 = $result_seDay20['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY20
  if($result_seDay20['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay20['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay20['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY20 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY20 = $result_seDay20['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY20 = $result_seDay20['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY20 = $result_seDay20['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY20
  if($result_seDay20['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay20['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay20['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay20['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay20['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay20['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY20 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY20 = $result_seDay20['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY20 = $result_seDay20['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY20 = $result_seDay20['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY21
  $sql_seDay21 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D21']."',103)";
  $params_seDay21 = array();
  $query_seDay21 = sqlsrv_query($conn, $sql_seDay21, $params_seDay21);
  $result_seDay21 = sqlsrv_fetch_array($query_seDay21, SQLSRV_FETCH_ASSOC);
  // SYSDAY21
  if($result_seDay21['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay21['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay21['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY21 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY21 = $result_seDay21['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY21 = $result_seDay21['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY21 = $result_seDay21['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY21
  if($result_seDay21['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay21['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay21['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY21 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY21 = $result_seDay21['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY21 = $result_seDay21['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY21 = $result_seDay21['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY21
  if($result_seDay21['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay21['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay21['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay21['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay21['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay21['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY21 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY21 = $result_seDay21['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY21 = $result_seDay21['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY21 = $result_seDay21['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY22
  $sql_seDay22 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D22']."',103)";
  $params_seDay22 = array();
  $query_seDay22 = sqlsrv_query($conn, $sql_seDay22, $params_seDay22);
  $result_seDay22 = sqlsrv_fetch_array($query_seDay22, SQLSRV_FETCH_ASSOC);
  // SYSDAY22
  if($result_seDay22['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay22['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay22['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY22 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY22 = $result_seDay22['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY22 = $result_seDay22['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY22 = $result_seDay22['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY22
  if($result_seDay22['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay22['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay22['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY22 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY22 = $result_seDay22['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY22 = $result_seDay22['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY22 = $result_seDay22['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY22
  if($result_seDay22['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay22['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay22['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay22['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay22['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay22['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY22 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY22 = $result_seDay22['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY22 = $result_seDay22['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY22 = $result_seDay22['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY23
  $sql_seDay23 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D23']."',103)";
  $params_seDay23 = array();
  $query_seDay23 = sqlsrv_query($conn, $sql_seDay23, $params_seDay23);
  $result_seDay23 = sqlsrv_fetch_array($query_seDay23, SQLSRV_FETCH_ASSOC);
  // SYSDAY2
  if($result_seDay23['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay23['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay23['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY23 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY23 = $result_seDay23['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY23 = $result_seDay23['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY23 = $result_seDay23['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY23
  if($result_seDay23['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay23['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay23['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY23 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY23 = $result_seDay23['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY23 = $result_seDay23['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY23 = $result_seDay23['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY23
  if($result_seDay23['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay23['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay23['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay23['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay23['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay23['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY23 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY23 = $result_seDay23['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY23 = $result_seDay23['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY23 = $result_seDay23['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY24
  $sql_seDay24 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D24']."',103)";
  $params_seDay24 = array();
  $query_seDay24 = sqlsrv_query($conn, $sql_seDay24, $params_seDay24);
  $result_seDay24 = sqlsrv_fetch_array($query_seDay24, SQLSRV_FETCH_ASSOC);
  // SYSDAY24
  if($result_seDay24['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay24['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay24['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY24 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY24 = $result_seDay24['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY24 = $result_seDay24['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY24 = $result_seDay24['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY24
  if($result_seDay24['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay24['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay24['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY24 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY24 = $result_seDay24['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY24 = $result_seDay24['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY24 = $result_seDay24['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY24
  if($result_seDay24['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay24['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay24['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay24['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay24['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay24['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY24 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY24 = $result_seDay24['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY24 = $result_seDay24['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY24 = $result_seDay24['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY25
  $sql_seDay25 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D25']."',103)";
  $params_seDay25 = array();
  $query_seDay25 = sqlsrv_query($conn, $sql_seDay25, $params_seDay25);
  $result_seDay25 = sqlsrv_fetch_array($query_seDay25, SQLSRV_FETCH_ASSOC);
  // SYSDAY25
  if($result_seDay25['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay25['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay25['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY25 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY25 = $result_seDay25['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY25 = $result_seDay25['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY25 = $result_seDay25['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY2
  if($result_seDay25['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay25['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay25['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY25 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY25 = $result_seDay25['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY25 = $result_seDay25['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY25 = $result_seDay25['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY25
  if($result_seDay25['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay25['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay25['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay25['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay25['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay25['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY25 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY25 = $result_seDay25['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY25 = $result_seDay25['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY25 = $result_seDay25['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY26
  $sql_seDay26 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D26']."',103)";
  $params_seDay26 = array();
  $query_seDay26 = sqlsrv_query($conn, $sql_seDay26, $params_seDay26);
  $result_seDay26 = sqlsrv_fetch_array($query_seDay26, SQLSRV_FETCH_ASSOC);
  // SYSDAY26
  if($result_seDay26['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay26['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay26['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY26 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY26 = $result_seDay26['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY26 = $result_seDay26['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY26 = $result_seDay26['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY26
  if($result_seDay26['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay26['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay26['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY26 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY26 = $result_seDay26['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY26 = $result_seDay26['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY26 = $result_seDay26['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY26
  if($result_seDay26['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay26['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay26['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay26['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay26['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay26['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY26 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY26 = $result_seDay26['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY26 = $result_seDay26['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY26 = $result_seDay26['TENKOPRESSUREDATA_60110'] ; 
  }

  //////////////////////////////////////////////////////////////////////

  //DAY27
  $sql_seDay27 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D27']."',103)";
  $params_seDay27 = array();
  $query_seDay27 = sqlsrv_query($conn, $sql_seDay27, $params_seDay27);
  $result_seDay27 = sqlsrv_fetch_array($query_seDay27, SQLSRV_FETCH_ASSOC);
  // SYSDAY27
  if($result_seDay27['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay27['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay27['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY27 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY27 = $result_seDay27['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY27 = $result_seDay27['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY27 = $result_seDay27['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY27
  if($result_seDay27['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay27['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay27['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY27 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY27 = $result_seDay27['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY27 = $result_seDay27['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY27 = $result_seDay27['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY27
  if($result_seDay27['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay27['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay27['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay27['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay27['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay27['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY27 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY27 = $result_seDay27['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY27 = $result_seDay27['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY27 = $result_seDay27['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////

  //DAY28
  $sql_seDay28 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D28']."',103)";
  $params_seDay28 = array();
  $query_seDay28 = sqlsrv_query($conn, $sql_seDay28, $params_seDay28);
  $result_seDay28 = sqlsrv_fetch_array($query_seDay28, SQLSRV_FETCH_ASSOC);
  // SYSDAY28
  if($result_seDay28['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay28['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay28['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY28 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY28 = $result_seDay28['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY28 = $result_seDay28['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY28 = $result_seDay28['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY28
  if($result_seDay28['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay28['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay28['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY28 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY28 = $result_seDay28['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY28 = $result_seDay28['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY28 = $result_seDay28['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY28
  if($result_seDay28['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay28['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay28['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay28['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay28['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay28['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY28 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY28 = $result_seDay28['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY28 = $result_seDay28['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY28 = $result_seDay28['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY29
  $sql_seDay29 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D29']."',103)";
  $params_seDay29 = array();
  $query_seDay29 = sqlsrv_query($conn, $sql_seDay29, $params_seDay29);
  $result_seDay29 = sqlsrv_fetch_array($query_seDay29, SQLSRV_FETCH_ASSOC);
  // SYSDAY29
  if($result_seDay29['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay29['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay29['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY29 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY29 = $result_seDay29['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY29 = $result_seDay29['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY29 = $result_seDay29['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY29
  if($result_seDay29['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay29['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay29['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY29 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY29 = $result_seDay29['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY29 = $result_seDay29['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY29 = $result_seDay29['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY29
  if($result_seDay29['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay29['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay29['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay29['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay29['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay29['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY29 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY29 = $result_seDay29['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY29 = $result_seDay29['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY29 = $result_seDay29['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  
}else if($ChkMonth == '30') { //chk เดือนที่มี 31 วัน
  // echo "30";
  /////////////////QUERY ค้นหาข้อมูล///////////////////////////////////////////////////
  //DAY1
  $sql_seDay1 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D1']."',103)";
  $params_seDay1 = array();
  $query_seDay1 = sqlsrv_query($conn, $sql_seDay1, $params_seDay1);
  $result_seDay1 = sqlsrv_fetch_array($query_seDay1, SQLSRV_FETCH_ASSOC);
  // SYSDAY1
  if($result_seDay1['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay1['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay1['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY1 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY1 = $result_seDay1['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY1 = $result_seDay1['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY1 = $result_seDay1['TENKOPRESSUREDATA_90160'] ; 
          
  }
  //DIADAY1
  if($result_seDay1['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay1['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay1['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY1 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY1 = $result_seDay1['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY1 = $result_seDay1['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY1 = $result_seDay1['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY1
  if($result_seDay1['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay1['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay1['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay1['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay1['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay1['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY1 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY1 = $result_seDay1['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY1 = $result_seDay1['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY1 = $result_seDay1['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY2
  $sql_seDay2 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D2']."',103)";
  $params_seDay2 = array();
  $query_seDay2 = sqlsrv_query($conn, $sql_seDay2, $params_seDay2);
  $result_seDay2 = sqlsrv_fetch_array($query_seDay2, SQLSRV_FETCH_ASSOC);
  // SYSDAY2
  if($result_seDay2['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay2['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay2['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY2 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY2 = $result_seDay2['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY2 = $result_seDay2['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY2 = $result_seDay2['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY2
  if($result_seDay2['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay2['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay2['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY2 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY2 = $result_seDay2['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY2 = $result_seDay2['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY2 = $result_seDay2['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY2
  if($result_seDay2['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay2['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay2['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay2['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay2['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay2['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY2 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY2 = $result_seDay2['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY2 = $result_seDay2['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY2 = $result_seDay2['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY3
  $sql_seDay3 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D3']."',103)";
  $params_seDay3 = array();
  $query_seDay3 = sqlsrv_query($conn, $sql_seDay3, $params_seDay3);
  $result_seDay3 = sqlsrv_fetch_array($query_seDay3, SQLSRV_FETCH_ASSOC);
  // SYSDAY3
  if($result_seDay3['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay3['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay3['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY3 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY3 = $result_seDay3['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY3 = $result_seDay3['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY3 = $result_seDay3['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY3
  if($result_seDay3['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay3['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay3['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY3 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY3 = $result_seDay3['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY3 = $result_seDay3['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY3 = $result_seDay3['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY3
  if($result_seDay3['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay3['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay3['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay3['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay3['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay3['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY3 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY3 = $result_seDay3['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY3 = $result_seDay3['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY3 = $result_seDay3['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY4
  $sql_seDay4 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D4']."',103)";
  $params_seDay4 = array();
  $query_seDay4 = sqlsrv_query($conn, $sql_seDay4, $params_seDay4);
  $result_seDay4 = sqlsrv_fetch_array($query_seDay4, SQLSRV_FETCH_ASSOC);
  // SYSDAY4
  if($result_seDay4['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay4['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay4['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY4 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY4 = $result_seDay4['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY4 = $result_seDay4['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY4 = $result_seDay4['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY4
  if($result_seDay4['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay4['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay4['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY4 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY4 = $result_seDay4['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY4 = $result_seDay4['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY4 = $result_seDay4['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY4
  if($result_seDay4['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay4['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay4['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay4['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay4['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay4['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY4 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY4 = $result_seDay4['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY4 = $result_seDay4['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY4 = $result_seDay4['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY5
  $sql_seDay5 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D5']."',103)";
  $params_seDay5 = array();
  $query_seDay5 = sqlsrv_query($conn, $sql_seDay5, $params_seDay5);
  $result_seDay5 = sqlsrv_fetch_array($query_seDay5, SQLSRV_FETCH_ASSOC);
  // SYSDAY5
  if($result_seDay5['TENKOPRESSUREDATA_90160'] >= '140'){
      if ($result_seDay5['TENKOPRESSUREDATA_90160_2'] >= '140' ) {
          if ($result_seDay5['TENKOPRESSUREDATA_90160_3'] >= '140') {
              $SYSDAY5 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY5 = $result_seDay5['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY5 = $result_seDay5['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY5 = $result_seDay5['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY5
  if($result_seDay5['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay5['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay5['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY5 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY5 = $result_seDay5['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY5 = $result_seDay5['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY5 = $result_seDay5['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY5
  if($result_seDay5['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay5['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay5['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay5['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay5['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay5['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY5 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY5 = $result_seDay5['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY5 = $result_seDay5['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY5 = $result_seDay5['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY6
  $sql_seDay6 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D6']."',103)";
  $params_seDay6 = array();
  $query_seDay6 = sqlsrv_query($conn, $sql_seDay6, $params_seDay2);
  $result_seDay6 = sqlsrv_fetch_array($query_seDay6, SQLSRV_FETCH_ASSOC);
  // SYSDAY6
  if($result_seDay6['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay6['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay6['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY6 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY6 = $result_seDay6['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY6 = $result_seDay6['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY6 = $result_seDay6['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY6
  if($result_seDay6['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay6['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay6['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY6 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY6 = $result_seDay6['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY6 = $result_seDay6['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY6 = $result_seDay6['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY6
  if($result_seDay6['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay6['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay6['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay6['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay6['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay6['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY6 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY6 = $result_seDay6['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY6 = $result_seDay6['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY6 = $result_seDay6['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY7
  $sql_seDay7 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D7']."',103)";
  $params_seDay7 = array();
  $query_seDay7 = sqlsrv_query($conn, $sql_seDay7, $params_seDay7);
  $result_seDay7 = sqlsrv_fetch_array($query_seDay7, SQLSRV_FETCH_ASSOC);
  // SYSDAY7
  if($result_seDay7['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay7['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay7['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY7 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY7 = $result_seDay7['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY7 = $result_seDay7['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY7 = $result_seDay7['TENKOPRESSUREDATA_90160']; 
  }
  //DIADAY7
  if($result_seDay7['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay7['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay7['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY7 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY7 = $result_seDay7['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY7 = $result_seDay7['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY7 = $result_seDay7['TENKOPRESSUREDATA_60100'] ; 
          // $DIADAY71 = $result_seDay7['TENKOPRESSUREDATA_60100'] ; 
          // if ($DIADAY71 == '') {
          //     $DIADAY7 = '0';
          // }else {
          //     $DIADAY7 = $DIADAY71;
          // }
  }
  //PULSEDAY7
  if($result_seDay7['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay7['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay7['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay7['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay7['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay7['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY7 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY7 = $result_seDay7['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY7 = $result_seDay7['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY7 = $result_seDay7['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY8
  $sql_seDay8 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D8']."',103)";
  $params_seDay8 = array();
  $query_seDay8 = sqlsrv_query($conn, $sql_seDay8, $params_seDay8);
  $result_seDay8 = sqlsrv_fetch_array($query_seDay8, SQLSRV_FETCH_ASSOC);
  // SYSDAY2
  if($result_seDay8['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay8['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay8['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY8 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY8 = $result_seDay8['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY8 = $result_seDay8['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY8 = $result_seDay8['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY8
  if($result_seDay8['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay8['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay8['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY8 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY8 = $result_seDay8['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY8 = $result_seDay8['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY8 = $result_seDay8['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY8
  if($result_seDay8['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay8['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay8['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay8['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay8['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay8['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY8 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY8 = $result_seDay8['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY8 = $result_seDay8['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY8 = $result_seDay8['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY9
  $sql_seDay9 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D9']."',103)";
  $params_seDay9 = array();
  $query_seDay9 = sqlsrv_query($conn, $sql_seDay9, $params_seDay9);
  $result_seDay9 = sqlsrv_fetch_array($query_seDay9, SQLSRV_FETCH_ASSOC);
  // SYSDAY9
  if($result_seDay9['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay9['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay9['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY9 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY9 = $result_seDay9['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY9 = $result_seDay9['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY9 = $result_seDay9['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY9
  if($result_seDay9['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay9['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay9['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY9 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY9 = $result_seDay9['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY9 = $result_seDay9['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY9 = $result_seDay9['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY9
  if($result_seDay9['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay9['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay9['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay9['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay9['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay9['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY9 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY9 = $result_seDay9['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY9 = $result_seDay9['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY9 = $result_seDay9['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY10
  $sql_seDay10 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D10']."',103)";
  $params_seDay10 = array();
  $query_seDay10 = sqlsrv_query($conn, $sql_seDay10, $params_seDay10);
  $result_seDay10 = sqlsrv_fetch_array($query_seDay10, SQLSRV_FETCH_ASSOC);
  // SYSDAY10
  if($result_seDay10['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay10['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay10['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY10 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY10 = $result_seDay10['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY10 = $result_seDay10['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY10 = $result_seDay10['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY10
  if($result_seDay10['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay10['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay10['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY10 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY10 = $result_seDay10['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY10 = $result_seDay10['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY10 = $result_seDay10['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY10
  if($result_seDay10['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay10['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay10['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay10['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay10['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay10['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY10 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY10 = $result_seDay10['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY10 = $result_seDay10['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY10 = $result_seDay10['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY11
  $sql_seDay11 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D11']."',103)";
  $params_seDay11 = array();
  $query_seDay11 = sqlsrv_query($conn, $sql_seDay11, $params_seDay11);
  $result_seDay11 = sqlsrv_fetch_array($query_seDay11, SQLSRV_FETCH_ASSOC);
  // SYSDAY11
  if($result_seDay11['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay11['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay11['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY11 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY11 = $result_seDay11['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY11 = $result_seDay11['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY11 = $result_seDay11['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY11
  if($result_seDay11['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay11['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay11['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY11 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY11 = $result_seDay11['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY11 = $result_seDay11['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY11 = $result_seDay11['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY11
  if($result_seDay11['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay11['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay11['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay11['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay11['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay11['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY11 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY11 = $result_seDay11['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY11 = $result_seDay11['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY11 = $result_seDay11['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY12
  $sql_seDay12 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D12']."',103)";
  $params_seDay12 = array();
  $query_seDay12 = sqlsrv_query($conn, $sql_seDay12, $params_seDay12);
  $result_seDay12 = sqlsrv_fetch_array($query_seDay12, SQLSRV_FETCH_ASSOC);
  // SYSDAY2
  if($result_seDay12['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay12['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay12['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY2 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY12 = $result_seDay12['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY12 = $result_seDay12['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY12 = $result_seDay12['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY12
  if($result_seDay12['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay12['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay12['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY12 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY12 = $result_seDay12['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY12 = $result_seDay12['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY12 = $result_seDay12['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY12
  if($result_seDay12['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay12['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay12['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay12['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay12['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay12['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY12 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY12 = $result_seDay12['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY12 = $result_seDay12['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY12 = $result_seDay12['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY13
  $sql_seDay13 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D13']."',103)";
  $params_seDay13 = array();
  $query_seDay13 = sqlsrv_query($conn, $sql_seDay13, $params_seDay13);
  $result_seDay13 = sqlsrv_fetch_array($query_seDay13, SQLSRV_FETCH_ASSOC);
  // SYSDAY13
  if($result_seDay13['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay13['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay13['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY13 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY13 = $result_seDay13['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY13 = $result_seDay13['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY13 = $result_seDay13['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY13
  if($result_seDay13['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay13['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay13['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY13 = ''; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY13 = $result_seDay13['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY13 = $result_seDay13['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY13 = $result_seDay13['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY13
  if($result_seDay13['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay13['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay13['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay13['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay13['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay13['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY13 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY13 = $result_seDay13['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY13 = $result_seDay13['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY13 = $result_seDay13['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY14
  $sql_seDay14 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D14']."',103)";
  $params_seDay14 = array();
  $query_seDay14 = sqlsrv_query($conn, $sql_seDay14, $params_seDay14);
  $result_seDay14 = sqlsrv_fetch_array($query_seDay14, SQLSRV_FETCH_ASSOC);
  // SYSDAY14
  if($result_seDay14['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay14['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay14['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY14 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY14 = $result_seDay14['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY14 = $result_seDay14['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY14 = $result_seDay14['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY14
  if($result_seDay14['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay14['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay14['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY14 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY14 = $result_seDay14['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY14 = $result_seDay14['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY14 = $result_seDay14['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY14
  if($result_seDay14['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay14['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay14['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay14['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay14['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay14['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY14 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY14 = $result_seDay14['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY14 = $result_seDay14['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY14 = $result_seDay14['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY15
  $sql_seDay15 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D15']."',103)";
  $params_seDay15 = array();
  $query_seDay15 = sqlsrv_query($conn, $sql_seDay15, $params_seDay15);
  $result_seDay15 = sqlsrv_fetch_array($query_seDay15, SQLSRV_FETCH_ASSOC);
  // SYSDAY15
  if($result_seDay15['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay15['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay15['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY15 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY15 = $result_seDay15['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY15 = $result_seDay15['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY15 = $result_seDay15['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY15
  if($result_seDay15['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay15['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay15['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY15 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY15 = $result_seDay15['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY15 = $result_seDay15['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY15 = $result_seDay15['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY15
  if($result_seDay15['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay15['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay15['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay15['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay15['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay15['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY15 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY15 = $result_seDay15['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY15 = $result_seDay15['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY15 = $result_seDay15['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY16
  $sql_seDay16 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D16']."',103)";
  $params_seDay16 = array();
  $query_seDay16 = sqlsrv_query($conn, $sql_seDay16, $params_seDay16);
  $result_seDay16 = sqlsrv_fetch_array($query_seDay16, SQLSRV_FETCH_ASSOC);
  // SYSDAY16
  if($result_seDay16['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay16['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay16['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY16 = ''; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY16 = $result_seDay16['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY16 = $result_seDay16['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY16 = $result_seDay16['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY16
  if($result_seDay16['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay16['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay16['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY16 = ''; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY16 = $result_seDay16['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY16 = $result_seDay16['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY16 = $result_seDay16['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY16
  if($result_seDay16['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay16['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay16['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay16['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay16['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay16['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY16 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY16 = $result_seDay16['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY16 = $result_seDay16['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY16 = $result_seDay16['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY17
  $sql_seDay17 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D17']."',103)";
  $params_seDay17 = array();
  $query_seDay17 = sqlsrv_query($conn, $sql_seDay17, $params_seDay17);
  $result_seDay17 = sqlsrv_fetch_array($query_seDay17, SQLSRV_FETCH_ASSOC);
  // SYSDAY17
  if($result_seDay17['TENKOPRESSUREDATA_90160'] >= '140'){
      if ($result_seDay17['TENKOPRESSUREDATA_90160_2'] >= '140' ) {
          if ($result_seDay17['TENKOPRESSUREDATA_90160_3'] >= '140') {
              $SYSDAY17 = ''; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY17 = $result_seDay17['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY17 = $result_seDay17['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY17 = $result_seDay17['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY17
  if($result_seDay17['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay17['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay17['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY17 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY17 = $result_seDay17['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY17 = $result_seDay17['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY17 = $result_seDay17['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY17
  if($result_seDay17['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay17['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay17['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay17['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay17['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay17['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY17 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY17 = $result_seDay17['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY17 = $result_seDay17['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY17 = $result_seDay17['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY18
  $sql_seDay18 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D18']."',103)";
  $params_seDay18 = array();
  $query_seDay18 = sqlsrv_query($conn, $sql_seDay18, $params_seDay18);
  $result_seDay18 = sqlsrv_fetch_array($query_seDay18, SQLSRV_FETCH_ASSOC);
  // SYSDAY18
  if($result_seDay18['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay18['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay18['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY18 = ''; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY18 = $result_seDay18['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY18 = $result_seDay18['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY18 = $result_seDay18['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY18
  if($result_seDay18['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay18['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay18['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY18 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY18 = $result_seDay18['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY18 = $result_seDay18['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY18 = $result_seDay18['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY18
  if($result_seDay18['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay18['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay18['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay18['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay18['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay18['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY18 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY18 = $result_seDay18['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY18 = $result_seDay18['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY18 = $result_seDay18['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY19
  $sql_seDay19 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D19']."',103)";
  $params_seDay19 = array();
  $query_seDay19 = sqlsrv_query($conn, $sql_seDay19, $params_seDay19);
  $result_seDay19 = sqlsrv_fetch_array($query_seDay19, SQLSRV_FETCH_ASSOC);
  // SYSDAY19
  if($result_seDay19['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay19['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay19['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY19 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY19 = $result_seDay19['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY19 = $result_seDay19['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY19 = $result_seDay19['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY19
  if($result_seDay19['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay19['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay19['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY19 = ''; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY19 = $result_seDay19['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY19 = $result_seDay19['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY19 = $result_seDay19['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY19
  if($result_seDay19['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay19['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay19['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay19['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay19['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay19['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY19 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY19 = $result_seDay19['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY19 = $result_seDay19['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY19 = $result_seDay19['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY20
  $sql_seDay20 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D20']."',103)";
  $params_seDay20 = array();
  $query_seDay20 = sqlsrv_query($conn, $sql_seDay20, $params_seDay20);
  $result_seDay20 = sqlsrv_fetch_array($query_seDay20, SQLSRV_FETCH_ASSOC);
  // SYSDAY20
  if($result_seDay20['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay20['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay20['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY20 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY20 = $result_seDay20['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY20 = $result_seDay20['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY20 = $result_seDay20['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY20
  if($result_seDay20['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay20['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay20['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY20 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY20 = $result_seDay20['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY20 = $result_seDay20['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY20 = $result_seDay20['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY20
  if($result_seDay20['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay20['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay20['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay20['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay20['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay20['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY20 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY20 = $result_seDay20['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY20 = $result_seDay20['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY20 = $result_seDay20['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY21
  $sql_seDay21 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D21']."',103)";
  $params_seDay21 = array();
  $query_seDay21 = sqlsrv_query($conn, $sql_seDay21, $params_seDay21);
  $result_seDay21 = sqlsrv_fetch_array($query_seDay21, SQLSRV_FETCH_ASSOC);
  // SYSDAY21
  if($result_seDay21['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay21['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay21['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY21 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY21 = $result_seDay21['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY21 = $result_seDay21['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY21 = $result_seDay21['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY21
  if($result_seDay21['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay21['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay21['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY21 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY21 = $result_seDay21['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY21 = $result_seDay21['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY21 = $result_seDay21['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY21
  if($result_seDay21['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay21['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay21['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay21['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay21['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay21['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY21 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY21 = $result_seDay21['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY21 = $result_seDay21['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY21 = $result_seDay21['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY22
  $sql_seDay22 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D22']."',103)";
  $params_seDay22 = array();
  $query_seDay22 = sqlsrv_query($conn, $sql_seDay22, $params_seDay22);
  $result_seDay22 = sqlsrv_fetch_array($query_seDay22, SQLSRV_FETCH_ASSOC);
  // SYSDAY22
  if($result_seDay22['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay22['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay22['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY22 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY22 = $result_seDay22['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY22 = $result_seDay22['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY22 = $result_seDay22['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY22
  if($result_seDay22['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay22['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay22['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY22 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY22 = $result_seDay22['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY22 = $result_seDay22['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY22 = $result_seDay22['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY22
  if($result_seDay22['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay22['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay22['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay22['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay22['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay22['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY22 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY22 = $result_seDay22['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY22 = $result_seDay22['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY22 = $result_seDay22['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY23
  $sql_seDay23 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D23']."',103)";
  $params_seDay23 = array();
  $query_seDay23 = sqlsrv_query($conn, $sql_seDay23, $params_seDay23);
  $result_seDay23 = sqlsrv_fetch_array($query_seDay23, SQLSRV_FETCH_ASSOC);
  // SYSDAY2
  if($result_seDay23['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay23['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay23['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY23 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY23 = $result_seDay23['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY23 = $result_seDay23['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY23 = $result_seDay23['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY23
  if($result_seDay23['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay23['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay23['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY23 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY23 = $result_seDay23['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY23 = $result_seDay23['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY23 = $result_seDay23['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY23
  if($result_seDay23['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay23['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay23['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay23['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay23['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay23['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY23 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY23 = $result_seDay23['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY23 = $result_seDay23['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY23 = $result_seDay23['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY24
  $sql_seDay24 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D24']."',103)";
  $params_seDay24 = array();
  $query_seDay24 = sqlsrv_query($conn, $sql_seDay24, $params_seDay24);
  $result_seDay24 = sqlsrv_fetch_array($query_seDay24, SQLSRV_FETCH_ASSOC);
  // SYSDAY24
  if($result_seDay24['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay24['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay24['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY24 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY24 = $result_seDay24['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY24 = $result_seDay24['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY24 = $result_seDay24['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY24
  if($result_seDay24['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay24['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay24['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY24 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY24 = $result_seDay24['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY24 = $result_seDay24['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY24 = $result_seDay24['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY24
  if($result_seDay24['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay24['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay24['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay24['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay24['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay24['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY24 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY24 = $result_seDay24['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY24 = $result_seDay24['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY24 = $result_seDay24['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY25
  $sql_seDay25 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D25']."',103)";
  $params_seDay25 = array();
  $query_seDay25 = sqlsrv_query($conn, $sql_seDay25, $params_seDay25);
  $result_seDay25 = sqlsrv_fetch_array($query_seDay25, SQLSRV_FETCH_ASSOC);
  // SYSDAY25
  if($result_seDay25['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay25['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay25['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY25 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY25 = $result_seDay25['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY25 = $result_seDay25['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY25 = $result_seDay25['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY2
  if($result_seDay25['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay25['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay25['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY25 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY25 = $result_seDay25['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY25 = $result_seDay25['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY25 = $result_seDay25['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY25
  if($result_seDay25['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay25['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay25['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay25['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay25['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay25['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY25 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY25 = $result_seDay25['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY25 = $result_seDay25['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY25 = $result_seDay25['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY26
  $sql_seDay26 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D26']."',103)";
  $params_seDay26 = array();
  $query_seDay26 = sqlsrv_query($conn, $sql_seDay26, $params_seDay26);
  $result_seDay26 = sqlsrv_fetch_array($query_seDay26, SQLSRV_FETCH_ASSOC);
  // SYSDAY26
  if($result_seDay26['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay26['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay26['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY26 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY26 = $result_seDay26['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY26 = $result_seDay26['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY26 = $result_seDay26['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY26
  if($result_seDay26['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay26['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay26['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY26 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY26 = $result_seDay26['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY26 = $result_seDay26['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY26 = $result_seDay26['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY26
  if($result_seDay26['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay26['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay26['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay26['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay26['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay26['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY26 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY26 = $result_seDay26['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY26 = $result_seDay26['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY26 = $result_seDay26['TENKOPRESSUREDATA_60110'] ; 
  }

  //////////////////////////////////////////////////////////////////////

  //DAY27
  $sql_seDay27 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D27']."',103)";
  $params_seDay27 = array();
  $query_seDay27 = sqlsrv_query($conn, $sql_seDay27, $params_seDay27);
  $result_seDay27 = sqlsrv_fetch_array($query_seDay27, SQLSRV_FETCH_ASSOC);
  // SYSDAY27
  if($result_seDay27['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay27['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay27['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY27 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY27 = $result_seDay27['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY27 = $result_seDay27['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY27 = $result_seDay27['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY27
  if($result_seDay27['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay27['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay27['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY27 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY27 = $result_seDay27['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY27 = $result_seDay27['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY27 = $result_seDay27['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY27
  if($result_seDay27['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay27['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay27['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay27['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay27['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay27['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY27 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY27 = $result_seDay27['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY27 = $result_seDay27['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY27 = $result_seDay27['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////

  //DAY28
  $sql_seDay28 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D28']."',103)";
  $params_seDay28 = array();
  $query_seDay28 = sqlsrv_query($conn, $sql_seDay28, $params_seDay28);
  $result_seDay28 = sqlsrv_fetch_array($query_seDay28, SQLSRV_FETCH_ASSOC);
  // SYSDAY28
  if($result_seDay28['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay28['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay28['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY28 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY28 = $result_seDay28['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY28 = $result_seDay28['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY28 = $result_seDay28['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY28
  if($result_seDay28['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay28['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay28['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY28 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY28 = $result_seDay28['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY28 = $result_seDay28['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY28 = $result_seDay28['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY28
  if($result_seDay28['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay28['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay28['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay28['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay28['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay28['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY28 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY28 = $result_seDay28['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY28 = $result_seDay28['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY28 = $result_seDay28['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY29
  $sql_seDay29 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D29']."',103)";
  $params_seDay29 = array();
  $query_seDay29 = sqlsrv_query($conn, $sql_seDay29, $params_seDay29);
  $result_seDay29 = sqlsrv_fetch_array($query_seDay29, SQLSRV_FETCH_ASSOC);
  // SYSDAY29
  if($result_seDay29['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay29['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay29['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY29 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY29 = $result_seDay29['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY29 = $result_seDay29['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY29 = $result_seDay29['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY29
  if($result_seDay29['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay29['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay29['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY29 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY29 = $result_seDay29['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY29 = $result_seDay29['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY29 = $result_seDay29['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY29
  if($result_seDay29['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay29['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay29['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay29['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay29['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay29['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY29 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY29 = $result_seDay29['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY29 = $result_seDay29['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY29 = $result_seDay29['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY30
  $sql_seDay30 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D30']."',103)";
  $params_seDay30 = array();
  $query_seDay30 = sqlsrv_query($conn, $sql_seDay30, $params_seDay30);
  $result_seDay30 = sqlsrv_fetch_array($query_seDay30, SQLSRV_FETCH_ASSOC);
  // SYSDAY30
  if($result_seDay30['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay30['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay30['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY30 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY30 = $result_seDay30['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY30 = $result_seDay30['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY30 = $result_seDay30['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY30
  if($result_seDay30['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay30['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay30['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY30 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY30 = $result_seDay30['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY30 = $result_seDay30['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY30 = $result_seDay30['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY30
  if($result_seDay30['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay30['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay30['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay30['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay30['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay30['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY30 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY30 = $result_seDay30['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY30 = $result_seDay30['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY30 = $result_seDay30['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
}else if($ChkMonth == '31') { //chk เดือนที่มี 31 วัน
  // echo "31";
  /////////////////QUERY ค้นหาข้อมูล///////////////////////////////////////////////////
  //DAY1
  $sql_seDay1 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D1']."',103)";
  $params_seDay1 = array();
  $query_seDay1 = sqlsrv_query($conn, $sql_seDay1, $params_seDay1);
  $result_seDay1 = sqlsrv_fetch_array($query_seDay1, SQLSRV_FETCH_ASSOC);
  // SYSDAY1
  if($result_seDay1['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay1['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay1['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY1 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY1 = $result_seDay1['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY1 = $result_seDay1['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY1 = $result_seDay1['TENKOPRESSUREDATA_90160'] ; 
          
  }
  //DIADAY1
  if($result_seDay1['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay1['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay1['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY1 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY1 = $result_seDay1['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY1 = $result_seDay1['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY1 = $result_seDay1['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY1
  if($result_seDay1['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay1['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay1['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay1['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay1['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay1['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY1 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY1 = $result_seDay1['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY1 = $result_seDay1['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY1 = $result_seDay1['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY2
  $sql_seDay2 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D2']."',103)";
  $params_seDay2 = array();
  $query_seDay2 = sqlsrv_query($conn, $sql_seDay2, $params_seDay2);
  $result_seDay2 = sqlsrv_fetch_array($query_seDay2, SQLSRV_FETCH_ASSOC);
  // SYSDAY2
  if($result_seDay2['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay2['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay2['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY2 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY2 = $result_seDay2['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY2 = $result_seDay2['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY2 = $result_seDay2['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY2
  if($result_seDay2['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay2['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay2['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY2 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY2 = $result_seDay2['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY2 = $result_seDay2['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY2 = $result_seDay2['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY2
  if($result_seDay2['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay2['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay2['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay2['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay2['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay2['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY2 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY2 = $result_seDay2['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY2 = $result_seDay2['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY2 = $result_seDay2['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY3
  $sql_seDay3 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D3']."',103)";
  $params_seDay3 = array();
  $query_seDay3 = sqlsrv_query($conn, $sql_seDay3, $params_seDay3);
  $result_seDay3 = sqlsrv_fetch_array($query_seDay3, SQLSRV_FETCH_ASSOC);
  // SYSDAY3
  if($result_seDay3['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay3['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay3['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY3 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY3 = $result_seDay3['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY3 = $result_seDay3['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY3 = $result_seDay3['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY3
  if($result_seDay3['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay3['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay3['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY3 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY3 = $result_seDay3['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY3 = $result_seDay3['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY3 = $result_seDay3['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY3
  if($result_seDay3['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay3['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay3['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay3['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay3['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay3['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY3 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY3 = $result_seDay3['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY3 = $result_seDay3['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY3 = $result_seDay3['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY4
  $sql_seDay4 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D4']."',103)";
  $params_seDay4 = array();
  $query_seDay4 = sqlsrv_query($conn, $sql_seDay4, $params_seDay4);
  $result_seDay4 = sqlsrv_fetch_array($query_seDay4, SQLSRV_FETCH_ASSOC);
  // SYSDAY4
  if($result_seDay4['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay4['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay4['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY4 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY4 = $result_seDay4['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY4 = $result_seDay4['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY4 = $result_seDay4['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY4
  if($result_seDay4['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay4['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay4['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY4 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY4 = $result_seDay4['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY4 = $result_seDay4['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY4 = $result_seDay4['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY4
  if($result_seDay4['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay4['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay4['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay4['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay4['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay4['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY4 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY4 = $result_seDay4['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY4 = $result_seDay4['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY4 = $result_seDay4['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY5
  $sql_seDay5 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D5']."',103)";
  $params_seDay5 = array();
  $query_seDay5 = sqlsrv_query($conn, $sql_seDay5, $params_seDay5);
  $result_seDay5 = sqlsrv_fetch_array($query_seDay5, SQLSRV_FETCH_ASSOC);
  // SYSDAY5
  if($result_seDay5['TENKOPRESSUREDATA_90160'] >= '140'){
      if ($result_seDay5['TENKOPRESSUREDATA_90160_2'] >= '140' ) {
          if ($result_seDay5['TENKOPRESSUREDATA_90160_3'] >= '140') {
              $SYSDAY5 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY5 = $result_seDay5['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY5 = $result_seDay5['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY5 = $result_seDay5['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY5
  if($result_seDay5['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay5['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay5['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY5 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY5 = $result_seDay5['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY5 = $result_seDay5['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY5 = $result_seDay5['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY5
  if($result_seDay5['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay5['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay5['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay5['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay5['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay5['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY5 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY5 = $result_seDay5['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY5 = $result_seDay5['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY5 = $result_seDay5['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY6
  $sql_seDay6 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D6']."',103)";
  $params_seDay6 = array();
  $query_seDay6 = sqlsrv_query($conn, $sql_seDay6, $params_seDay2);
  $result_seDay6 = sqlsrv_fetch_array($query_seDay6, SQLSRV_FETCH_ASSOC);
  // SYSDAY6
  if($result_seDay6['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay6['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay6['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY6 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY6 = $result_seDay6['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY6 = $result_seDay6['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY6 = $result_seDay6['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY6
  if($result_seDay6['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay6['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay6['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY6 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY6 = $result_seDay6['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY6 = $result_seDay6['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY6 = $result_seDay6['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY6
  if($result_seDay6['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay6['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay6['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay6['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay6['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay6['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY6 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY6 = $result_seDay6['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY6 = $result_seDay6['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY6 = $result_seDay6['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY7
  $sql_seDay7 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D7']."',103)";
  $params_seDay7 = array();
  $query_seDay7 = sqlsrv_query($conn, $sql_seDay7, $params_seDay7);
  $result_seDay7 = sqlsrv_fetch_array($query_seDay7, SQLSRV_FETCH_ASSOC);
  // SYSDAY7
  if($result_seDay7['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay7['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay7['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY7 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY7 = $result_seDay7['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY7 = $result_seDay7['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY7 = $result_seDay7['TENKOPRESSUREDATA_90160']; 
  }
  //DIADAY7
  if($result_seDay7['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay7['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay7['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY7 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY7 = $result_seDay7['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY7 = $result_seDay7['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY7 = $result_seDay7['TENKOPRESSUREDATA_60100'] ; 
          // $DIADAY71 = $result_seDay7['TENKOPRESSUREDATA_60100'] ; 
          // if ($DIADAY71 == '') {
          //     $DIADAY7 = '0';
          // }else {
          //     $DIADAY7 = $DIADAY71;
          // }
  }
  //PULSEDAY7
  if($result_seDay7['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay7['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay7['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay7['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay7['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay7['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY7 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY7 = $result_seDay7['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY7 = $result_seDay7['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY7 = $result_seDay7['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY8
  $sql_seDay8 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D8']."',103)";
  $params_seDay8 = array();
  $query_seDay8 = sqlsrv_query($conn, $sql_seDay8, $params_seDay8);
  $result_seDay8 = sqlsrv_fetch_array($query_seDay8, SQLSRV_FETCH_ASSOC);
  // SYSDAY2
  if($result_seDay8['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay8['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay8['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY8 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY8 = $result_seDay8['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY8 = $result_seDay8['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY8 = $result_seDay8['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY8
  if($result_seDay8['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay8['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay8['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY8 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY8 = $result_seDay8['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY8 = $result_seDay8['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY8 = $result_seDay8['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY8
  if($result_seDay8['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay8['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay8['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay8['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay8['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay8['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY8 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY8 = $result_seDay8['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY8 = $result_seDay8['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY8 = $result_seDay8['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY9
  $sql_seDay9 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D9']."',103)";
  $params_seDay9 = array();
  $query_seDay9 = sqlsrv_query($conn, $sql_seDay9, $params_seDay9);
  $result_seDay9 = sqlsrv_fetch_array($query_seDay9, SQLSRV_FETCH_ASSOC);
  // SYSDAY9
  if($result_seDay9['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay9['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay9['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY9 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY9 = $result_seDay9['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY9 = $result_seDay9['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY9 = $result_seDay9['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY9
  if($result_seDay9['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay9['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay9['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY9 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY9 = $result_seDay9['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY9 = $result_seDay9['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY9 = $result_seDay9['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY9
  if($result_seDay9['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay9['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay9['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay9['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay9['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay9['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY9 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY9 = $result_seDay9['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY9 = $result_seDay9['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY9 = $result_seDay9['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY10
  $sql_seDay10 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D10']."',103)";
  $params_seDay10 = array();
  $query_seDay10 = sqlsrv_query($conn, $sql_seDay10, $params_seDay10);
  $result_seDay10 = sqlsrv_fetch_array($query_seDay10, SQLSRV_FETCH_ASSOC);
  // SYSDAY10
  if($result_seDay10['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay10['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay10['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY10 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY10 = $result_seDay10['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY10 = $result_seDay10['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY10 = $result_seDay10['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY10
  if($result_seDay10['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay10['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay10['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY10 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY10 = $result_seDay10['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY10 = $result_seDay10['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY10 = $result_seDay10['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY10
  if($result_seDay10['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay10['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay10['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay10['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay10['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay10['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY10 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY10 = $result_seDay10['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY10 = $result_seDay10['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY10 = $result_seDay10['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY11
  $sql_seDay11 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D11']."',103)";
  $params_seDay11 = array();
  $query_seDay11 = sqlsrv_query($conn, $sql_seDay11, $params_seDay11);
  $result_seDay11 = sqlsrv_fetch_array($query_seDay11, SQLSRV_FETCH_ASSOC);
  // SYSDAY11
  if($result_seDay11['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay11['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay11['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY11 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY11 = $result_seDay11['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY11 = $result_seDay11['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY11 = $result_seDay11['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY11
  if($result_seDay11['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay11['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay11['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY11 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY11 = $result_seDay11['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY11 = $result_seDay11['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY11 = $result_seDay11['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY11
  if($result_seDay11['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay11['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay11['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay11['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay11['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay11['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY11 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY11 = $result_seDay11['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY11 = $result_seDay11['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY11 = $result_seDay11['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY12
  $sql_seDay12 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D12']."',103)";
  $params_seDay12 = array();
  $query_seDay12 = sqlsrv_query($conn, $sql_seDay12, $params_seDay12);
  $result_seDay12 = sqlsrv_fetch_array($query_seDay12, SQLSRV_FETCH_ASSOC);
  // SYSDAY2
  if($result_seDay12['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay12['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay12['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY2 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY12 = $result_seDay12['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY12 = $result_seDay12['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY12 = $result_seDay12['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY12
  if($result_seDay12['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay12['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay12['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY12 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY12 = $result_seDay12['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY12 = $result_seDay12['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY12 = $result_seDay12['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY12
  if($result_seDay12['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay12['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay12['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay12['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay12['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay12['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY12 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY12 = $result_seDay12['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY12 = $result_seDay12['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY12 = $result_seDay12['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY13
  $sql_seDay13 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D13']."',103)";
  $params_seDay13 = array();
  $query_seDay13 = sqlsrv_query($conn, $sql_seDay13, $params_seDay13);
  $result_seDay13 = sqlsrv_fetch_array($query_seDay13, SQLSRV_FETCH_ASSOC);
  // SYSDAY13
  if($result_seDay13['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay13['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay13['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY13 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY13 = $result_seDay13['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY13 = $result_seDay13['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY13 = $result_seDay13['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY13
  if($result_seDay13['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay13['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay13['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY13 = ''; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY13 = $result_seDay13['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY13 = $result_seDay13['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY13 = $result_seDay13['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY13
  if($result_seDay13['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay13['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay13['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay13['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay13['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay13['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY13 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY13 = $result_seDay13['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY13 = $result_seDay13['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY13 = $result_seDay13['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY14
  $sql_seDay14 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D14']."',103)";
  $params_seDay14 = array();
  $query_seDay14 = sqlsrv_query($conn, $sql_seDay14, $params_seDay14);
  $result_seDay14 = sqlsrv_fetch_array($query_seDay14, SQLSRV_FETCH_ASSOC);
  // SYSDAY14
  if($result_seDay14['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay14['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay14['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY14 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY14 = $result_seDay14['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY14 = $result_seDay14['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY14 = $result_seDay14['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY14
  if($result_seDay14['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay14['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay14['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY14 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY14 = $result_seDay14['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY14 = $result_seDay14['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY14 = $result_seDay14['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY14
  if($result_seDay14['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay14['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay14['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay14['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay14['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay14['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY14 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY14 = $result_seDay14['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY14 = $result_seDay14['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY14 = $result_seDay14['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY15
  $sql_seDay15 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D15']."',103)";
  $params_seDay15 = array();
  $query_seDay15 = sqlsrv_query($conn, $sql_seDay15, $params_seDay15);
  $result_seDay15 = sqlsrv_fetch_array($query_seDay15, SQLSRV_FETCH_ASSOC);
  // SYSDAY15
  if($result_seDay15['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay15['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay15['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY15 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY15 = $result_seDay15['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY15 = $result_seDay15['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY15 = $result_seDay15['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY15
  if($result_seDay15['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay15['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay15['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY15 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY15 = $result_seDay15['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY15 = $result_seDay15['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY15 = $result_seDay15['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY15
  if($result_seDay15['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay15['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay15['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay15['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay15['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay15['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY15 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY15 = $result_seDay15['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY15 = $result_seDay15['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY15 = $result_seDay15['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY16
  $sql_seDay16 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D16']."',103)";
  $params_seDay16 = array();
  $query_seDay16 = sqlsrv_query($conn, $sql_seDay16, $params_seDay16);
  $result_seDay16 = sqlsrv_fetch_array($query_seDay16, SQLSRV_FETCH_ASSOC);
  // SYSDAY16
  if($result_seDay16['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay16['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay16['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY16 = ''; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY16 = $result_seDay16['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY16 = $result_seDay16['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY16 = $result_seDay16['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY16
  if($result_seDay16['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay16['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay16['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY16 = ''; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY16 = $result_seDay16['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY16 = $result_seDay16['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY16 = $result_seDay16['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY16
  if($result_seDay16['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay16['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay16['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay16['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay16['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay16['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY16 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY16 = $result_seDay16['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY16 = $result_seDay16['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY16 = $result_seDay16['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY17
  $sql_seDay17 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D17']."',103)";
  $params_seDay17 = array();
  $query_seDay17 = sqlsrv_query($conn, $sql_seDay17, $params_seDay17);
  $result_seDay17 = sqlsrv_fetch_array($query_seDay17, SQLSRV_FETCH_ASSOC);
  // SYSDAY17
  if($result_seDay17['TENKOPRESSUREDATA_90160'] >= '140'){
      if ($result_seDay17['TENKOPRESSUREDATA_90160_2'] >= '140' ) {
          if ($result_seDay17['TENKOPRESSUREDATA_90160_3'] >= '140') {
              $SYSDAY17 = ''; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY17 = $result_seDay17['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY17 = $result_seDay17['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY17 = $result_seDay17['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY17
  if($result_seDay17['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay17['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay17['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY17 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY17 = $result_seDay17['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY17 = $result_seDay17['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY17 = $result_seDay17['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY17
  if($result_seDay17['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay17['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay17['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay17['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay17['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay17['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY17 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY17 = $result_seDay17['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY17 = $result_seDay17['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY17 = $result_seDay17['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY18
  $sql_seDay18 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D18']."',103)";
  $params_seDay18 = array();
  $query_seDay18 = sqlsrv_query($conn, $sql_seDay18, $params_seDay18);
  $result_seDay18 = sqlsrv_fetch_array($query_seDay18, SQLSRV_FETCH_ASSOC);
  // SYSDAY18
  if($result_seDay18['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay18['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay18['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY18 = ''; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY18 = $result_seDay18['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY18 = $result_seDay18['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY18 = $result_seDay18['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY18
  if($result_seDay18['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay18['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay18['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY18 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY18 = $result_seDay18['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY18 = $result_seDay18['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY18 = $result_seDay18['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY18
  if($result_seDay18['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay18['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay18['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay18['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay18['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay18['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY18 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY18 = $result_seDay18['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY18 = $result_seDay18['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY18 = $result_seDay18['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY19
  $sql_seDay19 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D19']."',103)";
  $params_seDay19 = array();
  $query_seDay19 = sqlsrv_query($conn, $sql_seDay19, $params_seDay19);
  $result_seDay19 = sqlsrv_fetch_array($query_seDay19, SQLSRV_FETCH_ASSOC);
  // SYSDAY19
  if($result_seDay19['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay19['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay19['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY19 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY19 = $result_seDay19['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY19 = $result_seDay19['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY19 = $result_seDay19['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY19
  if($result_seDay19['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay19['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay19['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY19 = ''; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY19 = $result_seDay19['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY19 = $result_seDay19['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY19 = $result_seDay19['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY19
  if($result_seDay19['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay19['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay19['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay19['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay19['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay19['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY19 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY19 = $result_seDay19['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY19 = $result_seDay19['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY19 = $result_seDay19['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY20
  $sql_seDay20 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D20']."',103)";
  $params_seDay20 = array();
  $query_seDay20 = sqlsrv_query($conn, $sql_seDay20, $params_seDay20);
  $result_seDay20 = sqlsrv_fetch_array($query_seDay20, SQLSRV_FETCH_ASSOC);
  // SYSDAY20
  if($result_seDay20['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay20['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay20['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY20 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY20 = $result_seDay20['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY20 = $result_seDay20['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY20 = $result_seDay20['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY20
  if($result_seDay20['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay20['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay20['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY20 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY20 = $result_seDay20['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY20 = $result_seDay20['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY20 = $result_seDay20['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY20
  if($result_seDay20['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay20['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay20['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay20['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay20['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay20['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY20 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY20 = $result_seDay20['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY20 = $result_seDay20['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY20 = $result_seDay20['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY21
  $sql_seDay21 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D21']."',103)";
  $params_seDay21 = array();
  $query_seDay21 = sqlsrv_query($conn, $sql_seDay21, $params_seDay21);
  $result_seDay21 = sqlsrv_fetch_array($query_seDay21, SQLSRV_FETCH_ASSOC);
  // SYSDAY21
  if($result_seDay21['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay21['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay21['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY21 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY21 = $result_seDay21['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY21 = $result_seDay21['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY21 = $result_seDay21['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY21
  if($result_seDay21['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay21['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay21['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY21 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY21 = $result_seDay21['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY21 = $result_seDay21['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY21 = $result_seDay21['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY21
  if($result_seDay21['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay21['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay21['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay21['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay21['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay21['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY21 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY21 = $result_seDay21['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY21 = $result_seDay21['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY21 = $result_seDay21['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY22
  $sql_seDay22 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D22']."',103)";
  $params_seDay22 = array();
  $query_seDay22 = sqlsrv_query($conn, $sql_seDay22, $params_seDay22);
  $result_seDay22 = sqlsrv_fetch_array($query_seDay22, SQLSRV_FETCH_ASSOC);
  // SYSDAY22
  if($result_seDay22['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay22['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay22['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY22 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY22 = $result_seDay22['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY22 = $result_seDay22['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY22 = $result_seDay22['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY22
  if($result_seDay22['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay22['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay22['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY22 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY22 = $result_seDay22['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY22 = $result_seDay22['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY22 = $result_seDay22['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY22
  if($result_seDay22['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay22['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay22['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay22['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay22['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay22['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY22 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY22 = $result_seDay22['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY22 = $result_seDay22['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY22 = $result_seDay22['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY23
  $sql_seDay23 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D23']."',103)";
  $params_seDay23 = array();
  $query_seDay23 = sqlsrv_query($conn, $sql_seDay23, $params_seDay23);
  $result_seDay23 = sqlsrv_fetch_array($query_seDay23, SQLSRV_FETCH_ASSOC);
  // SYSDAY2
  if($result_seDay23['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay23['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay23['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY23 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY23 = $result_seDay23['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY23 = $result_seDay23['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY23 = $result_seDay23['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY23
  if($result_seDay23['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay23['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay23['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY23 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY23 = $result_seDay23['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY23 = $result_seDay23['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY23 = $result_seDay23['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY23
  if($result_seDay23['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay23['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay23['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay23['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay23['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay23['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY23 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY23 = $result_seDay23['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY23 = $result_seDay23['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY23 = $result_seDay23['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY24
  $sql_seDay24 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D24']."',103)";
  $params_seDay24 = array();
  $query_seDay24 = sqlsrv_query($conn, $sql_seDay24, $params_seDay24);
  $result_seDay24 = sqlsrv_fetch_array($query_seDay24, SQLSRV_FETCH_ASSOC);
  // SYSDAY24
  if($result_seDay24['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay24['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay24['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY24 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY24 = $result_seDay24['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY24 = $result_seDay24['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY24 = $result_seDay24['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY24
  if($result_seDay24['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay24['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay24['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY24 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY24 = $result_seDay24['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY24 = $result_seDay24['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY24 = $result_seDay24['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY24
  if($result_seDay24['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay24['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay24['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay24['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay24['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay24['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY24 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY24 = $result_seDay24['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY24 = $result_seDay24['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY24 = $result_seDay24['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY25
  $sql_seDay25 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D25']."',103)";
  $params_seDay25 = array();
  $query_seDay25 = sqlsrv_query($conn, $sql_seDay25, $params_seDay25);
  $result_seDay25 = sqlsrv_fetch_array($query_seDay25, SQLSRV_FETCH_ASSOC);
  // SYSDAY25
  if($result_seDay25['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay25['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay25['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY25 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY25 = $result_seDay25['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY25 = $result_seDay25['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY25 = $result_seDay25['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY2
  if($result_seDay25['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay25['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay25['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY25 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY25 = $result_seDay25['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY25 = $result_seDay25['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY25 = $result_seDay25['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY25
  if($result_seDay25['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay25['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay25['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay25['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay25['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay25['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY25 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY25 = $result_seDay25['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY25 = $result_seDay25['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY25 = $result_seDay25['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY26
  $sql_seDay26 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D26']."',103)";
  $params_seDay26 = array();
  $query_seDay26 = sqlsrv_query($conn, $sql_seDay26, $params_seDay26);
  $result_seDay26 = sqlsrv_fetch_array($query_seDay26, SQLSRV_FETCH_ASSOC);
  // SYSDAY26
  if($result_seDay26['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay26['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay26['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY26 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY26 = $result_seDay26['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY26 = $result_seDay26['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY26 = $result_seDay26['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY26
  if($result_seDay26['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay26['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay26['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY26 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY26 = $result_seDay26['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY26 = $result_seDay26['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY26 = $result_seDay26['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY26
  if($result_seDay26['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay26['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay26['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay26['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay26['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay26['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY26 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY26 = $result_seDay26['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY26 = $result_seDay26['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY26 = $result_seDay26['TENKOPRESSUREDATA_60110'] ; 
  }

  //////////////////////////////////////////////////////////////////////

  //DAY27
  $sql_seDay27 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D27']."',103)";
  $params_seDay27 = array();
  $query_seDay27 = sqlsrv_query($conn, $sql_seDay27, $params_seDay27);
  $result_seDay27 = sqlsrv_fetch_array($query_seDay27, SQLSRV_FETCH_ASSOC);
  // SYSDAY27
  if($result_seDay27['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay27['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay27['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY27 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY27 = $result_seDay27['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY27 = $result_seDay27['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY27 = $result_seDay27['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY27
  if($result_seDay27['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay27['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay27['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY27 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY27 = $result_seDay27['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY27 = $result_seDay27['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY27 = $result_seDay27['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY27
  if($result_seDay27['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay27['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay27['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay27['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay27['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay27['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY27 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY27 = $result_seDay27['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY27 = $result_seDay27['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY27 = $result_seDay27['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////

  //DAY28
  $sql_seDay28 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D28']."',103)";
  $params_seDay28 = array();
  $query_seDay28 = sqlsrv_query($conn, $sql_seDay28, $params_seDay28);
  $result_seDay28 = sqlsrv_fetch_array($query_seDay28, SQLSRV_FETCH_ASSOC);
  // SYSDAY28
  if($result_seDay28['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay28['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay28['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY28 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY28 = $result_seDay28['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY28 = $result_seDay28['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY28 = $result_seDay28['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY28
  if($result_seDay28['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay28['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay28['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY28 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY28 = $result_seDay28['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY28 = $result_seDay28['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY28 = $result_seDay28['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY28
  if($result_seDay28['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay28['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay28['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay28['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay28['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay28['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY28 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY28 = $result_seDay28['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY28 = $result_seDay28['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY28 = $result_seDay28['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY29
  $sql_seDay29 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D29']."',103)";
  $params_seDay29 = array();
  $query_seDay29 = sqlsrv_query($conn, $sql_seDay29, $params_seDay29);
  $result_seDay29 = sqlsrv_fetch_array($query_seDay29, SQLSRV_FETCH_ASSOC);
  // SYSDAY29
  if($result_seDay29['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay29['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay29['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY29 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY29 = $result_seDay29['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY29 = $result_seDay29['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY29 = $result_seDay29['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY29
  if($result_seDay29['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay29['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay29['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY29 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY29 = $result_seDay29['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY29 = $result_seDay29['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY29 = $result_seDay29['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY29
  if($result_seDay29['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay29['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay29['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay29['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay29['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay29['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY29 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY29 = $result_seDay29['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY29 = $result_seDay29['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY29 = $result_seDay29['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
  //DAY30
  $sql_seDay30 = "SELECT
  b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
  ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
  ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
  ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
  ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
  FROM  TENKOBEFORE b
  WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
  AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D30']."',103)";
  $params_seDay30 = array();
  $query_seDay30 = sqlsrv_query($conn, $sql_seDay30, $params_seDay30);
  $result_seDay30 = sqlsrv_fetch_array($query_seDay30, SQLSRV_FETCH_ASSOC);
  // SYSDAY30
  if($result_seDay30['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay30['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay30['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY30 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY30 = $result_seDay30['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY30 = $result_seDay30['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY30 = $result_seDay30['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY30
  if($result_seDay30['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay30['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay30['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY30 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY30 = $result_seDay30['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY30 = $result_seDay30['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY30 = $result_seDay30['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY30
  if($result_seDay30['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay30['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay30['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay30['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay30['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay30['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY30 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY30 = $result_seDay30['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY30 = $result_seDay30['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY30 = $result_seDay30['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////

  //DAY31
  $sql_seDay31 = "SELECT
      b.CREATEDATE AS 'TENKOCREATEDATE',b.TENKOMASTERID,b.TENKOTEMPERATUREDATA
      ,b.TENKOPRESSUREDATA_90160,b.TENKOPRESSUREDATA_90160_2,b.TENKOPRESSUREDATA_90160_3
      ,b.TENKOPRESSUREDATA_60100,b.TENKOPRESSUREDATA_60100_2,b.TENKOPRESSUREDATA_60100_3
      ,b.TENKOPRESSUREDATA_60110,b.TENKOPRESSUREDATA_60110_2,b.TENKOPRESSUREDATA_60110_3
      ,b.TENKOALCOHOLDATA,b.TENKOOXYGENDATA
      FROM  TENKOBEFORE b
      WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
      AND CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,'".$result_seAdddateweek['D31']."',103)";
  $params_seDay31 = array();
  $query_seDay31 = sqlsrv_query($conn, $sql_seDay31, $params_seDay31);
  $result_seDay31 = sqlsrv_fetch_array($query_seDay31, SQLSRV_FETCH_ASSOC);
  // SYSDAY31
  if($result_seDay31['TENKOPRESSUREDATA_90160'] > '140'){
      if ($result_seDay31['TENKOPRESSUREDATA_90160_2'] > '140' ) {
          if ($result_seDay31['TENKOPRESSUREDATA_90160_3'] > '140') {
              $SYSDAY31 = '0'; // ความดันบนครั้งที่ 3 เกิน
          }else {
              $SYSDAY31 = $result_seDay31['TENKOPRESSUREDATA_90160_3'];
          }
          
      }else {
          $SYSDAY31 = $result_seDay31['TENKOPRESSUREDATA_90160_2'];
      }
      
  }else{
          $SYSDAY31 = $result_seDay31['TENKOPRESSUREDATA_90160'] ; 
  }
  //DIADAY31
  if($result_seDay31['TENKOPRESSUREDATA_60100'] > '90'){
      if ($result_seDay31['TENKOPRESSUREDATA_60100_2'] > '90' ) {
          if ($result_seDay31['TENKOPRESSUREDATA_60100_3'] > '90') {
              $DIADAY31 = '0'; // ความดันล่างครั้งที่ 3 เกิน
          }else {
              $DIADAY31 = $result_seDay31['TENKOPRESSUREDATA_60100_3'];
          }
          
      }else {
          $DIADAY31 = $result_seDay31['TENKOPRESSUREDATA_60100_2'];
      }
      
  }else{
          $DIADAY31 = $result_seDay31['TENKOPRESSUREDATA_60100'] ; 
  }
  //PULSEDAY31
  if($result_seDay31['TENKOPRESSUREDATA_60110'] > '100' || $result_seDay31['TENKOPRESSUREDATA_60110'] < '60'){
      if ($result_seDay31['TENKOPRESSUREDATA_60110_2'] > '100'  || $result_seDay31['TENKOPRESSUREDATA_60110_2'] < '60' ) {
          if ($result_seDay31['TENKOPRESSUREDATA_60110_3'] > '100' || $result_seDay31['TENKOPRESSUREDATA_60110_3'] < '60') {
              $PULSEDAY31 = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
          }else {
              $PULSEDAY31 = $result_seDay31['TENKOPRESSUREDATA_60110_3'];
          }
          
      }else {
          $PULSEDAY31 = $result_seDay31['TENKOPRESSUREDATA_60110_2'];
      }
      
  }else{
          $PULSEDAY31 = $result_seDay31['TENKOPRESSUREDATA_60110'] ; 
  }
  //////////////////////////////////////////////////////////////////////
}
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
// ประวัติผลคะแนนการวิ่งงาน
    $table_header11 = '<table style="width: 100%;">
      <thead>
          <tr>
              <td colspan="48" style="text-align:center;font-size:16px"><b>คะแนนการขับขี่ประจำวัน&#160;'.date("d/m/Y").'</b></td>
          </tr>
  
      </thead>
  </table>';
  
  
  
  $table_begin11 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">';
  $thead11 = '<thead>
        <tr  style="border:1px solid #000;padding:8px;background-color:#A69D9D">
          <td colspan = "4"   style="border-right:1px solid #000;padding:8px;text-align:center;font-size:14px"><b>คะแนนการขับขี่ประจำวัน</b></td>
        </tr>
      </thead><tbody>';
      $igrade = 1;
      
      $sql_setenkomasterid = "SELECT DISTINCT TENKOMASTERID,EMPLOYEECODE1,EMPLOYEECODE2,EMPLOYEENAME1,EMPLOYEENAME2
        FROM  VEHICLETRANSPORTPLAN 
        WHERE CONVERT(DATE,DATEWORKING,103) = CONVERT(DATE,'".date("d/m/Y")."',103)
        AND (EMPLOYEECODE1 ='".$result_seEmp1['PersonCode']."' OR EMPLOYEECODE2 ='".$result_seEmp1['PersonCode']."')";
      $params_setenkomasterid = array();
      $query_setenkomasterid = sqlsrv_query($conn, $sql_setenkomasterid, $params_setenkomasterid);
      $result_setenkomasterid = sqlsrv_fetch_array($query_setenkomasterid, SQLSRV_FETCH_ASSOC);

      $sql_segrade = "SELECT TENKOMASTERID,GRADEDRIVER,POINTDRIVER 
      FROM TENKOGPS 
      WHERE  TENKOMASTERDIRVERCODE ='".$result_seEmp1['PersonCode']."' AND TENKOMASTERID ='".$result_setenkomasterid['TENKOMASTERID']."'";
      $params_segrade = array();
      $query_segrade = sqlsrv_query($conn, $sql_segrade, $params_segrade);
      $result_segrade = sqlsrv_fetch_array($query_segrade, SQLSRV_FETCH_ASSOC);

        // แสดงเกรด
        if ($result_segrade['GRADEDRIVER'] == '' || $result_segrade['GRADEDRIVER'] == NULL) {
            $grade = 'ไม่มีผลการประเมิน';
        }else {
            $grade = $result_segrade['GRADEDRIVER'];
        }

        // แสดงคะแนน
        if ($result_segrade['POINTDRIVER'] == '' || $result_segrade['POINTDRIVER'] == NULL) {
            $point = 'ไม่มีผลคะแนน';
        }else {
            $point = $result_segrade['POINTDRIVER'];
        }

          // echo $result_sedataHealth['DIABETES'] == '0' ? 'UNCHECK'  : 'CHECK';
          $tbody11 .= '
          <tr style="border:1px solid #000;padding:10px;background-color:#A69D9D">
            <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">การประเมินผล</td>
            <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">คะแนนที่ได้</td>
          </tr>
          <tr style="border:1px solid #000;padding:10px;">
            <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">'.$grade.'</td>
            <td colspan = "2" style="border-right:1px solid #000;padding:10px;text-align:center;font-size:14px">'.$point.'</td>
          </tr>
          ';
        
   
      
  
  $table_end11 = '</table>';
  // ////////////////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////////////////////////////////////////////////////////////////////////////////////
// ประวัติสุขภาพ
if ($result_seCountHealth['COUNTHEALTH'] > 0) {
  $table_header2 = '<br><table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="48" style="text-align:center;font-size:16px"><b>ข้อมูลประวัติสุขภาพปี&#160;'.$currentyear.'</b></td>
        </tr>

    </thead>
</table>';
}else {
  $table_header2 = '<br><table style="width: 100%;">
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
      WHERE EMPLOYEECODE ='".$result_seEmp1['PersonCode']."'
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
// ////////////////////////////////////////////////////////////////////////////////////////////////////
// ประวัติ Tenko History
if ($result_seCountTenko['COUNTTENKO'] > 0) {
  $table_header3 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="48" style="text-align:center;font-size:16px"><b>TENKO History</b></td>
        </tr>

    </thead>
</table>';
}else {
  $table_header3 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="48" style="text-align:center;font-size:16px"><b>ไม่มีข้อมูล TENKO History</b></td>
        </tr>

    </thead>
</table>';
}


$table_begin3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead3 = '<thead>
      <tr  style="border:1px solid #000;padding:8px;background-color:#A69D9D  ">
        <td  colspan="7" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:12px"><b>Health Check</b></td>
      </tr>
    </thead><tbody>';
    
        // echo $result_sedataHealth['DIABETES'] == '0' ? 'UNCHECK'  : 'CHECK';
        $tbody3 .= '
        ///////////////////////////////////////////// วันที่1-10////////////////////////////////////////////////////
        <tr style="border:1px solid #000;padding:10px;background-color:#A69D9D">
          <td  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px;width:15%">วันที่</td>
          <td  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px;width:20%">ความดันค่าบน</td>
          <td  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px;width:20%">ความดันค่าล่าง</td>
          <td  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px;width:10%">อุณหภูมิ</td>
          <td  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px;width:20%">แอลกอฮอล์</td>
          <td  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px;width:20%">อัตราเต้นของหัวใจ</td>
          <td  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px;width:20%">ออกซิเจนในเลือด</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D1'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY1.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY1.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay1['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay1['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY1.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay1['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D2'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY2.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY2.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay2['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay2['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY2.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay2['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D3'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY3.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY3.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay3['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay3['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY3.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay3['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D4'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY4.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY4.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay4['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay4['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY4.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay4['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D5'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY5.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY5.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay5['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay5['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY5.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay5['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D6'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY6.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY6.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay6['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay6['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY6.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay6['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D7'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY7.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY7.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay7['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay7['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY7.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay7['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D8'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY8.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY8.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay8['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay8['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY8.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay8['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D9'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY9.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY9.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay9['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay9['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY9.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay9['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D10'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY10.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY10.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay10['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay10['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY10.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay10['TENKOOXYGENDATA'].'</td>
        </tr>
        //////////////////////////////////////// วันที่11-20//////////////////////////////////////////////
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D11'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY11.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY11.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay11['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay11['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY11.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay11['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D12'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY12.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY12.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay12['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay12['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY12.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay12['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D13'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY13.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY13.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay13['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay13['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY13.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay13['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D14'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY14.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY14.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay14['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay14['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY14.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay14['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D15'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY15.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY15.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay15['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay15['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY15.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay15['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D16'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY16.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY16.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay16['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay16['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY16.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay16['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D17'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY17.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY17.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay17['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay17['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY17.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay17['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D18'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY18.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY18.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay18['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay18['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY18.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay18['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D19'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY19.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY19.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay19['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay19['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY19.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay19['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D20'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY20.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY20.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay20['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay20['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY20.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay20['TENKOOXYGENDATA'].'</td>
        </tr>
        ////////////////////////////////////////// วันที่20-31////////////////////////////////////////////
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D21'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY21.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY21.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay21['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay21['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY21.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay21['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D22'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY22.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY22.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay22['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay22['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY22.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay22['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D23'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY23.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY23.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay23['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay23['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY23.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay23['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D24'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY24.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY24.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay24['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay24['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY24.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay24['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D25'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY25.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY25.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay25['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay25['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY25.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay25['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D26'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY26.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY26.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay26['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay26['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY26.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay26['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D27'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY27.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY27.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay27['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay27['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY27.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay27['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D28'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY28.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY28.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay28['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay28['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY28.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay28['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D29'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY29.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY29.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay29['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay29['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY29.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay29['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D30'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY30.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY30.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay30['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay30['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY30.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay30['TENKOOXYGENDATA'].'</td>
        </tr>
        <tr style="border:1px solid #000;padding:10px;">
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seAdddateweek['D31'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$SYSDAY31.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$DIADAY31.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay31['TENKOTEMPERATUREDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay31['TENKOALCOHOLDATA'].'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$PULSEDAY31.'</td>
          <td   style="border-right:1px solid #000;padding:10px;text-align:center;font-size:12px">'.$result_seDay31['TENKOOXYGENDATA'].'</td>
        </tr>
        ';
      
    

$table_end3 = '</table>';
// ////////////////////////////////////////////////////////////////////////////////////////////////////
// ประวัติการวิ่งงาน
if ($result_seCountRoute['COUNTPLAN'] > 0) {
  $table_header4 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="48" style="text-align:center;font-size:16px"><b>ข้อมูลการวิ่งงานวันที่&#160;'.$_GET['datestartroute'].' ถึง&#160; '.$_GET['dateendroute'].' </b></td>
        </tr>

    </thead>
</table>';
}else {
  $table_header4 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="48" style="text-align:center;font-size:16px"><b>ยังไม่มีข้อมูลการวิ่งงานวันที่&#160;'.$_GET['datestartroute'].' ถึง&#160; '.$_GET['dateendroute'].'</b></td>
        </tr>

    </thead>
</table>';
}


$table_begin4 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead4 = '<thead>
      <tr  style="border:1px solid #000;padding:8px;">
        <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 10%;font-size:11px;background-color:#A69D9D"><b>ลำดับ</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 30%;font-size:11px;background-color:#A69D9D"><b>วันที่วิ่งงาน</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 40%;font-size:11px;background-color:#A69D9D"><b>แผนวิ่งงาน</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 30%;font-size:11px;background-color:#A69D9D"><b>รอบวิ่งงาน</b></td>
       
      </tr>
    </thead><tbody>';
    $iRoute = 1;
    
    $sql_seRouteData = "SELECT CONVERT(VARCHAR(10),DATEWORKING,103) AS 'DATEWORKING',JOBSTART,JOBEND,ROUNDAMOUNT
      FROM  [dbo].[VEHICLETRANSPORTPLAN] 
      WHERE (EMPLOYEECODE1 ='".$_GET['employeecode']."' OR EMPLOYEECODE2 ='".$_GET['employeecode']."')
      AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestartroute']."',103) AND CONVERT(DATE,'".$_GET['dateendroute']."',103)
      ORDER BY DATEWORKING,ROUNDAMOUNT ASC";
    $params_seRouteData = array();
    $query_seRouteData = sqlsrv_query($conn, $sql_seRouteData, $params_seRouteData);
    while ($result_seRouteData = sqlsrv_fetch_array($query_seRouteData, SQLSRV_FETCH_ASSOC)) {
        // echo $result_sedataHealth['DIABETES'] == '0' ? 'UNCHECK'  : 'CHECK';
        $tbody4 .= '
        <tr style="border:1px solid #000;padding:10px;">
          <td style="border-right:1px solid #000;padding:10px;text-align:left;width: 10%;font-size:11px">'.$iRoute.'</td>
          <td style="border-right:1px solid #000;padding:10px;text-align:left;width: 30%;font-size:11px">'.$result_seRouteData['DATEWORKING'].'</td>
          <td style="border-right:1px solid #000;padding:10px;text-align:left;width: 40%;font-size:11px">'.$result_seRouteData['JOBSTART'].'</td>
          <td style="border-right:1px solid #000;padding:10px;text-align:left;width: 30%;font-size:11px">'.$result_seRouteData['ROUNDAMOUNT'].'</td>
          
        </tr>
        ';
      
      $iRoute++;
    }

$table_end4 = '</table>';


// ////////////////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////////////////////////////////////////////////////////////////////////////////////
// ประวัติอุบัติเหตุ
if ($result_seCountAccident['COUNTACCI'] > 0) {
  $table_header5 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="48" style="text-align:center;font-size:16px"><b>ข้อมูลอุบัติเหตุปี&#160;'.$_GET['yearstart'].' ถึง&#160; '.$_GET['yearend'].' </b></td>
        </tr>

    </thead>
</table>';
}else {
  $table_header5 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="48" style="text-align:center;font-size:16px"><b>ยังไม่มีข้อมูลอุบัติเหตุปี&#160;'.$_GET['yearstart'].' ถึง&#160; '.$_GET['yearend'].'</b></td>
        </tr>

    </thead>
</table>';
}


$table_begin5 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:10px;">';
$thead5 = '<thead>
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
        WHERE DRIVERNAME = '".$_GET['drivername']."'
        AND YEARS BETWEEN '".$_GET['yearstart']."' AND '".$_GET['yearend']."'
        ORDER BY YEARS,DATETIMEACCIDENT ASC";
    $params_seAccidentData = array();
    $query_seAccidentData = sqlsrv_query($conn, $sql_seAccidentData, $params_seAccidentData);
    while ($result_seAccidentData = sqlsrv_fetch_array($query_seAccidentData, SQLSRV_FETCH_ASSOC)) {
        // echo $result_sedataHealth['DIABETES'] == '0' ? 'UNCHECK'  : 'CHECK';
        $tbody5 .= '
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

$table_end5 = '</table>';


// ////////////////////////////////////////////////////////////////////////////////////////////////////
// ประวัติการอบรม
if ($result_seCountTrain['COUNTTRANING'] > 0) {
    $table_header6 = '<table style="width: 100%;">
      <thead>
          <tr>
              <td colspan="48" style="text-align:center;font-size:16px"><b>ข้อมูลการอบรมปี&#160;'.$_GET['yeartrainstart'].' ถึง&#160; '.$_GET['yeartrainend'].' </b></td>
          </tr>
  
      </thead>
  </table>';
  }else {
    $table_header6 = '<table style="width: 100%;">
      <thead>
          <tr>
              <td colspan="48" style="text-align:center;font-size:16px"><b>ยังไม่มีข้อมูลการอบรมปี&#160;'.$_GET['yeartrainstart'].' ถึง&#160; '.$_GET['yeartrainend'].'</b></td>
          </tr>
  
      </thead>
  </table>';
  }
  
  
  $table_begin6 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:10px;">';
  $thead6 = '<thead>
        <tr  style="border:1px solid #000;padding:16px;">
          <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 15%;font-size:22px"><b>ลำดับ</b></td>
          <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 25%;font-size:22px"><b>วันที่อบรม</b></td>
          <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 45%;font-size:22px"><b>หัวข้อการอบรม</b></td>
          <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 35%;font-size:22px"><b>รายละเอียดเพิ่มเติม</b></td>
          <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 30%;font-size:22px"><b>ชั่วโมงการอบรม</b></td>
          <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 30%;font-size:22px"><b>ผู้ฝึกอบรม</b></td>
          
        </tr>
      </thead><tbody>';
      $iTrain = 1;
      
      $sql_seTrainData = "SELECT a.Patern_ID,e.Company_NameT, b.PersonID, 
      c.PersonCode, d.PositionNameT, 
      c.FnameT, c.LnameT,a.Patern_Name,a.Patern_descrition, 
      a.Patern_Budget,a.Patern_Hour,
      b.pretest_point, b.posttest_point,g.Professor_NameT,
      a.Patern_Date,CONVERT(VARCHAR(10), a.Patern_Date, 103)  AS 'PATTERNDATE', 
      a.Patern_End,CONVERT(VARCHAR(10), a.Patern_End, 103)  AS 'PATTERNEND'
      
      FROM [203.150.225.30].[TigerE-HR].dbo.TN_Patern__Course a
      INNER JOIN [203.150.225.30].[TigerE-HR].dbo.TN_TrainPerson b ON b.Patern_ID = a.Patern_ID
      INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNT_Person c ON c.PersonID = b.PersonID
      INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNM_Position d ON d.PositionID = c.PositionID
      INNER JOIN [203.150.225.30].[TigerE-HR].dbo.COM_Company e ON e.ID_Company = c.CompanyID
      INNER JOIN [203.150.225.30].[TigerE-HR].dbo.TN_Patern_Professor f ON f.Patern_ID = a.Patern_ID
      INNER JOIN [203.150.225.30].[TigerE-HR].dbo.TN_Professor g ON g.Professor_ID = f.Professor_ID
      WHERE c.PersonCode ='".$_GET['employeecode']."'
      AND YEAR(a.Patern_Date) BETWEEN '".$_GET['yeartrainstart']."' AND '".$_GET['yeartrainend']."'
      AND (a.Patern_Name LIKE '%Re-training%' OR a.Patern_Name LIKE '%KYT%' OR a.Patern_Name LIKE '%safety focus theme%')
      ORDER BY  a.Patern_Date,a.Patern_Name ASC";
      $params_seTrainData = array();
      $query_seTrainData = sqlsrv_query($conn, $sql_seTrainData, $params_seTrainData);
      while ($result_seTrainData = sqlsrv_fetch_array($query_seTrainData, SQLSRV_FETCH_ASSOC)) {
//           // echo $result_sedataHealth['DIABETES'] == '0' ? 'UNCHECK'  : 'CHECK';
          $tbody6 .= '
          <tr style="border:1px solid #000;padding:16px;">
            <td style="border-right:1px solid #000;padding:16px;text-align:center;width: 15%;font-size:20px">'.$iTrain.'</td>
            <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 25%;font-size:20px">'.$result_seTrainData['PATTERNDATE'].'</td>
            <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 45%;font-size:20px">'.$result_seTrainData['Patern_Name'].'</td>
            <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 35%;font-size:20px">'.$result_seTrainData['Patern_descrition'].'</td>
            <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 30%;font-size:20px">'.$result_seTrainData['Patern_Hour'].'</td>
            <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 30%;font-size:20px">'.$result_seTrainData['Professor_NameT'].'</td>
            
          </tr>
          ';
        
        $iTrain++;
      }
  
  $table_end6 = '</table>';




$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table1);

$mpdf->WriteHTML($table_header11);
$mpdf->WriteHTML($table_begin11);
$mpdf->WriteHTML($thead11);
$mpdf->WriteHTML($tbody11);
$mpdf->WriteHTML($table_end11);

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

// Tenko Data
$mpdf->AddPage();
if ($result_seCountTenko['COUNTTENKO'] > 0) {
    $mpdf->WriteHTML($table_header3);
    $mpdf->WriteHTML($table_begin3);
    $mpdf->WriteHTML($thead3);
    $mpdf->WriteHTML($tbody3);
    $mpdf->WriteHTML($table_end3);
    // $mpdf->Output();
}else {
    $mpdf->WriteHTML($table_header3);
    // $mpdf->Output();
}

// Route History Data
$mpdf->AddPage();
if ($result_seCountRoute['COUNTPLAN'] > 0) {
    $mpdf->WriteHTML($table_header4);
    $mpdf->WriteHTML($table_begin4);
    $mpdf->WriteHTML($thead4);
    $mpdf->WriteHTML($tbody4);
    $mpdf->WriteHTML($table_end4);
    // $mpdf->Output();
}else {
    $mpdf->WriteHTML($table_header4);
    // $mpdf->Output();
}


// Accident Data
$mpdf->AddPage();
if ($result_seCountAccident['COUNTACCI'] > 0) {
    $mpdf->WriteHTML($table_header5);
    $mpdf->WriteHTML($table_begin5);
    $mpdf->WriteHTML($thead5);
    $mpdf->WriteHTML($tbody5);
    $mpdf->WriteHTML($table_end5);
    // $mpdf->Output();
}else {
    $mpdf->WriteHTML($table_header5);
    // $mpdf->Output();
}


// Training Data
$mpdf->AddPage();
if ($result_seCountTrain['COUNTTRANING'] > 0) {
    $mpdf->WriteHTML($table_header6);
    $mpdf->WriteHTML($table_begin6);
    $mpdf->WriteHTML($thead6);
    $mpdf->WriteHTML($tbody6);
    $mpdf->WriteHTML($table_end6);
    // $mpdf->Output();
}else {
    $mpdf->WriteHTML($table_header6);
}

$mpdf->Output();


sqlsrv_close($conn);
?>
