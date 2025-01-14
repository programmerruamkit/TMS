<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");



$employee = " AND a.PersonCode = '".$_GET['drivercode']."'";
$sql_seEmp = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmp = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($employee, SQLSRV_PARAM_IN)
);
$query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
$result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC);



///คำนวนหาอายุตน
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



///คำนวนหาอายุงาน
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


////////////////////DATE/////////////////////////////////////
$sql_seTenkoDate = "SELECT a.SELFCHECKID,a.EMPLOYEECODE,a.EMPLOYEENAME,a.DATEWORKING,
    REPLACE(a.SLEEPRESTEND, 'T', ' ') AS 'DATETIMESTARTWORKING',
    REPLACE(a.KEYDROPTIME, 'T', ' ') AS 'DATETIMEENDWORKING',
    a.TIMEWORKING,a.TIMEWORKINGSTATUS,b.PositionNameT
    FROM DRIVERSELFCHECK a 
    INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a.EMPLOYEECODE
    WHERE  a.EMPLOYEECODE ='".$_GET['drivercode']."'
    AND CONVERT(DATE,DATEWORKING,103) = CONVERT(DATE,'".$_GET['startdate']."',103) 
    ORDER BY CONVERT(DATE,a.DATEWORKING,103),a.EMPLOYEECODE,b.PositionNameT ASC";
$query_seTenkoDate = sqlsrv_query($conn, $sql_seTenkoDate, $params_seTenkoDate);
$result_seTenkoDate = sqlsrv_fetch_array($query_seTenkoDate, SQLSRV_FETCH_ASSOC);

$sql_seRouteData = "SELECT  JOBNO,JOBSTART,JOBEND,VEHICLEREGISNUMBER1,THAINAME,CONVERT(VARCHAR, DATEWORKING, 103) AS 'DATE' 
  FROM VEHICLETRANSPORTPLAN 
  WHERE CONVERT(DATE,DATEWORKING,103) = CONVERT(DATE,'".$_GET['startdate']."',103)
  AND (EMPLOYEECODE1 ='".$_GET['drivercode']."' OR EMPLOYEECODE2 ='".$_GET['drivercode']."' )
  ORDER BY JOBNO ASC";
$params_seRouteData = array();
$query_seRouteData  = sqlsrv_query($conn, $sql_seRouteData, $params_seRouteData);
$result_seRouteData = sqlsrv_fetch_array($query_seRouteData, SQLSRV_FETCH_ASSOC);


$mpdf = new mPDF('', 'A4', 5, '', 5, 5, 30, 5, 5, 3);
$style = '
<style>
	body{
		font-family: "angsana";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';

  $table_header3 = '<table style="width: 100%;">
      <thead>
          <tr>
              <td colspan="48" style="text-align:center;font-size:28px"><u><b>รายงานการทำงานเกิน 14 ชั่วโมง</b></u></td>
              <td colspan="4"  style="text-align:center"><img src="../images/logonew.png"></td>
              </tr>

      </thead>
  </table>';
  $table_header4 = '<table style="width: 100%;">

  <tbody>
      <tr>
          <td colspan="48" style="font-size:18px">DATE :.................................<b>' . $result_seRouteData['DATE'] .'</b>.............................................</td>
    </tr>
    <tr>
          <td colspan="60" style="font-size:18px">RE :......<b>การทำงานเกิน 14 ชั่วโมง</b>.......................................................</td>
    </tr>
    <tr>
          <td colspan="48" style="font-size:18px" >ชื่อ-สกุล...............<b>'.$result_seEmp['nameT'].'</b>......................อายุ(ตน)...........<b>'.$result_CalculateAge['RS'].'</b>..............อายุ(งาน).............<b>'.$result_CalculateWork['RS'].'</b>..............</td>
    </tr>
    <tr>
          <td colspan="48" style="font-size:18px" >เท็งโกะเริ่มงานเวลา/วันที่......<b>'.$result_seTenkoDate['DATETIMESTARTWORKING'].'</b>......เท็งโกะเลิกงานเวลา/วันที่.......<b>'.$result_seTenkoDate['DATETIMEENDWORKING'].'</b>......รวมระยะเวลาทำงาน.......<b>'.$result_seTenkoDate['TIMEWORKING'].'</b>........(ชั่วโมง)</td>
    </tr>
    <tr>
          <td colspan="48">&nbsp;</td>
    </tr>
  </tbody>
</table><br><br>';
  $table_begin3 = '<table   style="border-collapse: collapse;margin-top:8px;font-size:20px" width="100%">';
  $thead3 = '<thead>
          <tr>
            <td colspan="4" style="text-align:left;font-size:22px"><b>แผนการทำงาน</b></td>
          </tr>
            <tr>
              <td  width="10%"   style="border:1px solid #000;padding:4px;text-align:center">ลำดับ</td>
              <td  width="15%"   style="border:1px solid #000;padding:4px;text-align:center">รหัสแจ้งสุขภาพ</td>
              <td  width="20%"   style="border:1px solid #000;padding:4px;text-align:center">เลขที่งาน</td>
              <td  width="20%"   style="border:1px solid #000;padding:4px;text-align:center">ต้นทาง</td>
              <td  width="20%"   style="border:1px solid #000;padding:4px;text-align:center">ปลายทาง</td>
              <td  width="20%"   style="border:1px solid #000;padding:4px;text-align:center">ทะเบียนรถ/ชื่อรถ</td>
              <td  width="15%"   style="border:1px solid #000;padding:4px;text-align:center">เวลาเริ่มงาน</td>
              <td  width="15%"   style="border:1px solid #000;padding:4px;text-align:center">เวลาเลิกงาน</td>
              <td  width="15%"   style="border:1px solid #000;padding:4px;text-align:center">รวมเวลาปฎิบัติงาน</td>
            </tr>
      </thead><tbody>';
 
  

      $i = 1;
     
        $sql_seRoute = "SELECT  JOBNO,JOBSTART,JOBEND,VEHICLEREGISNUMBER1,THAINAME FROM VEHICLETRANSPORTPLAN 
          WHERE CONVERT(DATE,DATEWORKING,103) = CONVERT(DATE,'".$_GET['startdate']."',103)
          AND (EMPLOYEECODE1 ='".$_GET['drivercode']."' OR EMPLOYEECODE2 ='".$_GET['drivercode']."' )
          ORDER BY JOBNO ASC";
        $params_seRoute = array();
        $query_seRoute = sqlsrv_query($conn, $sql_seRoute, $params_seRoute);
      while ($result_seRoute = sqlsrv_fetch_array($query_seRoute, SQLSRV_FETCH_ASSOC)) {

      // if(){

      // }else{

      // }
      /////////คิดชาท10,ชาท7,ไม่คิดขั้นต่ำ
      // $sql_seID = "SELECT  DISTINCT REMARK, REMARKHEAD,JOBEND,VEHICLETRANSPORTPLANID FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER]
      //              WHERE VEHICLETRANSPORTPLANID = '".$result_seBilling['PLANID']."'
      //              AND  JOBEND ='".$result_seBilling['JOBEND']."'";
      // $params_seID = array();
      // $query_seID = sqlsrv_query($conn, $sql_seID, $params_seID);
      // $result_seID = sqlsrv_fetch_array($query_seID, SQLSRV_FETCH_ASSOC);

      // ///////////////LOCATION/////////////
        $sql_seData = "SELECT a.SELFCHECKID,a.EMPLOYEECODE,a.EMPLOYEENAME,a.DATEWORKING,
          REPLACE(a.SLEEPRESTEND, 'T', ' ') AS 'DATETIMESTARTWORKING',
          REPLACE(a.KEYDROPTIME, 'T', ' ') AS 'DATETIMEENDWORKING',
          a.TIMEWORKING,a.TIMEWORKINGSTATUS,b.PositionNameT,
          a.TIMEWORKINGDATANG1,a.TIMEWORKINGDATANG2,a.TIMEWORKINGDATANG3,
          a.TIMEWORKINGDATANG4,a.TIMEWORKINGDATANG5,a.TIMEWORKINGDATANG6
          FROM DRIVERSELFCHECK a 
          INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a.EMPLOYEECODE
          WHERE  a.EMPLOYEECODE ='".$_GET['drivercode']."'
          AND CONVERT(DATE,DATEWORKING,103) = CONVERT(DATE,'".$_GET['startdate']."',103) 
          ORDER BY CONVERT(DATE,a.DATEWORKING,103),a.EMPLOYEECODE,b.PositionNameT ASC";
        $query_seData = sqlsrv_query($conn, $sql_seData, $params_seseData);
        $result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC);

             

      $tbody3 .= '<tr>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:19px">'.$i.'</td>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:19px">'.$result_seData['SELFCHECKID'].'</td>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:19px">'.$result_seRoute['JOBNO'].'</td>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:19px">'.$result_seRoute['JOBSTART'].'</td>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:19px">'.$result_seRoute['JOBEND'].'</td>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:19px">'.$result_seRoute['VEHICLEREGISNUMBER1'].' ('.$result_seRoute['THAINAME'].')</td>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:19px">'.$result_seData['DATETIMESTARTWORKING'].'</td>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:19px">'.$result_seData['DATETIMEENDWORKING'].'</td>
      <td     style="border:1px solid #000;padding:4px;text-align:center;font-size:19px">'.$result_seData['TIMEWORKING'].'</td>
      </tr>';
      $i++;
  }






  $table_end3 = '</table><br>';
  $tbody4 .= '<table style="width: 100%;">
  <tbody>
      <tr>
          <td colspan="60" style="font-size:18px"><b>สาเหตุเนื่องมาจาก:</b></td>
    </tr>
    <tr>
          <td colspan="60" style="font-size:18px">1. '.$result_seData['TIMEWORKINGDATANG1'].'</td>
    </tr>
    <tr>
          <td colspan="60" style="font-size:18px">2. '.$result_seData['TIMEWORKINGDATANG2'].'</td>
    </tr>
     <tr>
          <td colspan="60" style="font-size:18px">3. '.$result_seData['TIMEWORKINGDATANG3'].'</td>
    </tr>
     <tr>
          <td colspan="60" style="font-size:18px">4. '.$result_seData['TIMEWORKINGDATANG4'].'</td>
    </tr>
     <tr>
          <td colspan="60" style="font-size:18px">5. '.$result_seData['TIMEWORKINGDATANG5'].'</td>
    </tr>
     <tr>
          <td colspan="60" style="font-size:18px">6. '.$result_seData['TIMEWORKINGDATANG6'].'</td>
    </tr>
    <tr>
          <td colspan="60">&nbsp;</td>
    </tr>
    <tr>
          <td colspan="60" style="font-size:18px"><b>หมายเหตุ:</b> 1. เอกสารแนบ GPS (การทำงานของพนักงาน)...............................................................................................................................</td>
    </tr>
    <tr>
          <td colspan="60">&nbsp;</td>
    </tr>
  </tbody>
</table>';


$table_footer3 = '<table style="width: 100%;">
  <tbody>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td style="width: 50%;text-align:center;font-size:20px">(................................)</td>
      <td style="width: 50%;text-align:center;font-size:20px">(................................)</td>
    </tr>
    <tr>
      <td style="width: 50%;text-align:center;font-size:20px">........../.........../...........</td>
      <td style="width: 50%;text-align:center;font-size:20px">........../.........../...........</td>
    </tr>
    <tr>
      <td style="width: 50%;text-align:center;font-size:20px">พนักงานขับรถ</td>
      <td style="width: 50%;text-align:center;font-size:20px">เจ้าหน้าที่ Tenko</td>
    </tr>
  </tbody>
</table>';
  $table_footer4 = '<table style="width: 100%;font-size:20px">
        <tbody>
        <tr>
        <td colspan="4">FM-SQ-07/01 &nbsp;&nbsp;&nbsp; แก้ไขครั้งที่: 00&nbsp;&nbsp;&nbsp;มีผลบังคับใช้: 06-01-63</td>
        </tr>
        </tbody>
    </table>';
  







$mpdf->WriteHTML($style);
$mpdf->SetHTMLHeader($table_header3, 'O', true);
$mpdf->WriteHTML($table_header4, 'O', true);
$mpdf->WriteHTML($table_begin3);
$mpdf->WriteHTML($thead3);
$mpdf->WriteHTML($tbody3);
$mpdf->WriteHTML($table_end3);
$mpdf->WriteHTML($tbody4);
// $mpdf->WriteHTML($table_footer3);
$mpdf->WriteHTML($table_footer3);
$mpdf->SetHTMLFooter($table_footer4);
$mpdf->Output();


sqlsrv_close($conn);
?>
