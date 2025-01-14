
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

// check Area หาค่ามาตรฐานข้อมูลตรวจร่างกาย
$checkArea = substr($_GET['employeecode1'],0,2);

if ($checkArea == '01' || $checkArea == '02' || $checkArea == '07'|| $checkArea == '08'|| $checkArea == '10') {
    $areashow = '(AMT)';
    $sql_seTenkoSTD = "SELECT STD_ID,MAXSYS,MINSYS,MAXDIA,MINDIA,MAXPULSE,MINPULSE,TEMP,OXYGEN,ALCOHOL,REMARK
    FROM STANDARDTENKODATA
    WHERE REMARK ='AMT'";
}else{
    $areashow = '(GW)';
    $sql_seTenkoSTD = "SELECT STD_ID,MAXSYS,MINSYS,MAXDIA,MINDIA,MAXPULSE,MINPULSE,TEMP,OXYGEN,ALCOHOL,REMARK
    FROM STANDARDTENKODATA
    WHERE REMARK ='GW'";
}
$query_seTenkoSTD = sqlsrv_query($conn, $sql_seTenkoSTD, $params_seTenkoSTD);
$result_seTenkoSTD = sqlsrv_fetch_array($query_seTenkoSTD, SQLSRV_FETCH_ASSOC);

$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';


$table1 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
  <tr style=" padding:4px;">
      <th colspan="6" style=" padding:4px;text-align:center;font-size:14px"><b>รายงานข้อมูลการตรวจร่างกาย</b></th>
  </tr>
<br><br><br>
  <tr style=" padding:4px;">
      <th colspan="2" style=" padding:4px;text-align:left;font-size:10px"><b>ฝ่าย : </b> '.$result_seDep['DEPARTMENTNAME'].' </th>
      <th colspan="2" style=" padding:4px;text-align:left;font-size:10px"><b>แผนก : </b> '.$result_seSec['SECTIONNAME'].' </th>
      <th colspan="2" style=" padding:4px;text-align:left;font-size:10px"><b>ระดับพักงาน : </b> '.$result_seEmp['PositionNameT'].' </th>
  </tr>
    </thead>';
    $table1 .= '<tbody>

    <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;" colspan="6"><hr /></td>
    </tr>
    <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;width: 15%;font-size:12px">รหัสพนักงาน</td>
        <td style=" padding:4px;text-align:left;width: 20%;font-size:12px">'.$result_seEmp['PersonCode'].'</td>
        <td colspan="2" rowspan="7" style=" padding:4px;text-align:center;width: 15%"><img width="20%" src="../images/employee/'.$result_seEmp['PersonCode'].'.JPG"></td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;font-size:12px">ชื่อ-สกุล(ไทย)</td>
        <td style=" padding:4px;text-align:left;font-size:12px">'.$result_seEmp['nameT'].'</td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;font-size:12px">ชื่อ-สกุล(อังกฤษ)</td>
        <td style=" padding:4px;text-align:left;font-size:12px">'.$result_seEmp['nameE'].'</td>
      </tr>
      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;font-size:12px">ฝ่าย</td>
        <td style=" padding:4px;text-align:left;font-size:12px">'.$result_seDep['DEPARTMENTNAME'].' </td>
      </tr>



      <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;font-size:12px">แผนก</td>
        <td style=" padding:4px;text-align:left;font-size:12px">'.$result_seSec['SECTIONNAME'].'</td>
      </tr>
       <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;font-size:12px">ระดับพนักงาน</td>
        <td style=" padding:4px;text-align:left;font-size:12px">'.$result_seEmp['PositionNameT'].' </td>
      </tr>
      
      
     
     <tr style=" padding:4px;">
        <td style=" padding:4px;text-align:left;" colspan="6"></td>
    </tr>
    <tr style=" padding:4px;">
    <td style=" padding:4px;text-align:left;" colspan="6"><hr /></td>
  </tr>
</tbody></table>';

$table_header3 = '<table style="width: 100%;">
    <thead>
        
    </thead>
    <tbody>
        

    </tbody>
    <br><br>
</table><br>';

$table_begin3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;font-size:10px">';
$thead3 = '<thead>

      <tr style="border:1px solid #000;padding:13px;">
        <td rowspan="2" style="border-right:1px solid #000;padding:13px;text-align:center;width: 15%;background-color:#ccc"><b>วันที่</b></td>
        <td colspan="6" style="border-right:1px solid #000;padding:13px;text-align:center;width: 10%;background-color:#ccc"><b>ค่าความดัน</b></td>
        <td rowspan="2" style="border-right:1px solid #000;padding:13px;text-align:center;width: 15%;background-color:#ccc"><b>อุณหภูมิ</b></td>
        <td rowspan="2" style="border-right:1px solid #000;padding:13px;text-align:center;width: 15%;background-color:#ccc"><b>แอลกอฮอล์</b></td>
        <td rowspan="2" style="border-right:1px solid #000;padding:13px;text-align:center;width: 15%;background-color:#ccc"><b>ออกซิเจนเลือด</b></td>
        <td rowspan="2" style="border-right:1px solid #000;padding:13px;text-align:center;width: 15%;background-color:#ccc"><b>หมายเหตุ</b></td>
      </tr>
      <tr style="border:1px solid #000;padding:13px;">
        <td colspan="2" style="border-right:1px solid #000;padding:13px;text-align:center;width: 10%;background-color:#ccc"><b>บน</b></td>
        <td colspan="2" style="border-right:1px solid #000;padding:13px;text-align:center;width: 10%;background-color:#ccc"><b>ล่าง</b></td>
        <td colspan="2" style="border-right:1px solid #000;padding:13px;text-align:center;width: 10%;background-color:#ccc"><b>ชีพจร</b></td>
      </tr>
    </thead><tbody>';

$i = 1;

// $sql_seCount = "SELECT  COUNT( b.TENKOMASTERID) AS 'COUNT'
// FROM  TENKOBEFORE b
// WHERE b.TENKOMASTERDIRVERCODE='".$_GET['employeecode']."'
// AND TENKOBEFOREGREETCHECK IS NULL
// AND CONVERT(DATE,b.CREATEDATE) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103) ";
// $params_seCount = array();
// $query_seCount = sqlsrv_query($conn, $sql_seCount, $params_seCount);
// $result_seCount = sqlsrv_fetch_array($query_seCount, SQLSRV_FETCH_ASSOC);



$conditionDir1officer = "  AND a.PersonCode = '" . $_GET['employeecode'] . "'";
$sql_seDir1officer = "{call megEmployeeEHR_v2(?,?)}";
$params_seDir1officer = array(
array('select_employeeehr2', SQLSRV_PARAM_IN),
array($conditionDir1officer, SQLSRV_PARAM_IN)
);
$query_seDir1officer = sqlsrv_query($conn, $sql_seDir1officer, $params_seDir1officer);
$result_seDir1officer = sqlsrv_fetch_array($query_seDir1officer, SQLSRV_FETCH_ASSOC);

$sql_seCount = "SELECT COUNT(LABOTRONDATAID) AS 'COUNT'
FROM LABOTRONWEBSERVICEDATA 
WHERE CARDNUMBER='".$result_seDir1officer['TaxID']."'
AND CONVERT(DATE,CREATEDATE) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103) ";
$params_seCount = array();
$query_seCount = sqlsrv_query($conn, $sql_seCount, $params_seCount);
$result_seCount = sqlsrv_fetch_array($query_seCount, SQLSRV_FETCH_ASSOC);


$sql_seSelfCheckData = "SELECT DRIVER_TEMPERATURE,DRIVER_SYS,DRIVER_DIA,DRIVER_PULSE,DRIVER_OXYGEN,DRIVER_ALCOHOL,CREATEBY, CONVERT(VARCHAR(10),CREATEDATE,103) AS 'CREATEDATE'
FROM LABOTRONWEBSERVICEDATA 
WHERE CARDNUMBER='".$result_seDir1officer['TaxID']."'
AND CONVERT(DATE,CREATEDATE) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103) 
ORDER BY CREATEDATE DESC";
$params_seSelfCheckData = array();
$query_seSelfCheckData = sqlsrv_query($conn, $sql_seSelfCheckData, $params_seSelfCheckData);
while ($result_seSelfCheckData = sqlsrv_fetch_array($query_seSelfCheckData, SQLSRV_FETCH_ASSOC)) {

    //SYS ค่าความดันบน
    $SYS = $result_seSelfCheckData['DRIVER_SYS'] ; 
    /////////////////////////////////////////////////////////////////
    //DIA ค่าความดันล่าง
    $DIA = $result_seSelfCheckData['DRIVER_DIA'] ; 
    /////////////////////////////////////////////////////////////////  
    //PULSE อัตราเต้นหัวใจ
    $PULSE = $result_seSelfCheckData['DRIVER_PULSE'] ;
    //////////////////////////////////////////////////////////////////////

    // SYS ค่าความดันบน
  //   if($result_seSelfCheckData['DRIVER_SYS'] > $result_seTenkoSTD['MAXSYS']){
  //     if ($result_seSelfCheckData['DRIVER_SYS'] > $result_seTenkoSTD['MAXSYS']) {
  //         if ($result_seSelfCheckData['DRIVER_SYS'] > $result_seTenkoSTD['MAXSYS']) {
  //             $SYS = '0'; // ความดันบนครั้งที่ 3 เกิน
  //         }else {
  //             $SYS = $result_seSelfCheckData['DRIVER_SYS'];
  //         }
          
  //     }else {
  //         $SYS = $result_seSelfCheckData['DRIVER_SYS'];
  //     }
      
  // }else{
  //         $SYS = $result_seSelfCheckData['DRIVER_SYS'] ; 
          
  // }
/////////////////////////////////////////////////////////////////
  //DIA ค่าความดันล่าง
  // if($result_seSelfCheckData['DRIVER_DIA'] > $result_seTenkoSTD['MAXDIA']){
  //     if ($result_seSelfCheckData['DRIVER_DIA'] > $result_seTenkoSTD['MAXDIA']) {
  //         if ($result_seSelfCheckData['DRIVER_DIA'] > $result_seTenkoSTD['MAXDIA']) {
  //             $DIA = '0'; // ความดันล่างครั้งที่ 3 เกิน
  //         }else {
  //             $DIA = $result_seSelfCheckData['DRIVER_DIA'];
  //         }
          
  //     }else {
  //         $DIA = $result_seSelfCheckData['DRIVER_DIA'];
  //     }
      
  // }else{
  //         $DIA = $result_seSelfCheckData['DRIVER_DIA'] ; 
  // }
/////////////////////////////////////////////////////////////////  
  //PULSEDAY1
  // if($result_seSelfCheckData['DRIVER_PULSE'] > $result_seTenkoSTD['MAXPULSE'] || $result_seSelfCheckData['DRIVER_PULSE'] < $result_seTenkoSTD['MINPULSE']){
  //     if ($result_seSelfCheckData['DRIVER_PULSE'] > $result_seTenkoSTD['MAXPULSE']  || $result_seSelfCheckData['DRIVER_PULSE'] < $result_seTenkoSTD['MINPULSE']) {
  //         if ($result_seSelfCheckData['DRIVER_PULSE'] > $result_seTenkoSTD['MAXPULSE'] || $result_seSelfCheckData['DRIVER_PULSE'] < $result_seTenkoSTD['MINPULSE']) {
  //             $PULSE = ''; // ความอัตตราเต้นหัวใจครั้งที่ 3 เกิน
  //         }else {
  //             $PULSE = $result_seSelfCheckData['DRIVER_PULSE'];
  //         }
          
  //     }else {
  //         $PULSE = $result_seSelfCheckData['DRIVER_PULSE'];
  //     }
      
  // }else{
  //         $PULSE = $result_seSelfCheckData['DRIVER_PULSE'] ; 
  // }
  //////////////////////////////////////////////////////////////////////


    $tbody3 .= '

        <tr style="border:1px solid #000;font-size:10px">
        <td colspan="1" style="border-right:1px solid #000;padding:13px;text-align:center;font-size:10px">' . $result_seSelfCheckData['CREATEDATE'] . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:13px;text-align:center;font-size:10px">' . $SYS . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:13px;text-align:center;font-size:10px">' . $DIA . '</td>
        <td colspan="2" style="border-right:1px solid #000;padding:13px;text-align:center;font-size:10px">' . $PULSE . '</td>
        <td colspan="1" style="border-right:1px solid #000;padding:13px;text-align:center;font-size:10px">' . $result_seSelfCheckData['DRIVER_TEMPERATURE'] . '</td>
        <td colspan="1" style="border-right:1px solid #000;padding:13px;text-align:center;font-size:10px">' . $result_seSelfCheckData['DRIVER_ALCOHOL'] . '</td>
        <td colspan="1" style="border-right:1px solid #000;padding:13px;text-align:center;font-size:10px">' . $result_seSelfCheckData['DRIVER_OXYGEN'] . '</td>
        <td colspan="1" style="border-right:1px solid #000;padding:13px;text-align:center;font-size:10px"></td>
        
      
      </tr>
    ';
    $i++;
    $SYSAVG = $SYSAVG + $SYS;
    $DIAAVG = $DIAAVG + $DIA;
    $PULSEAVG = $PULSEAVG + $PULSE;
    $TEMPAVG = $TEMPAVG + $result_seSelfCheckData['DRIVER_TEMPERATURE'];
    $ALCOAVG = $ALCOAVG + $result_seSelfCheckData['DRIVER_ALCOHOL'];
    $OXYGENAVG = $OXYGENAVG + $result_seSelfCheckData['DRIVER_OXYGEN'];
}


$tfoot3 = '</tbody><tfoot>
     <tr style="border:1px solid #000;font-size:10px">
        <td colspan="1" style="border-right:1px solid #000;padding:13px;text-align:center;font-size:10px;background-color:#ccc"><b>ค่าเฉลี่ย</b></td>
        <td colspan="2" style="border-right:1px solid #000;padding:13px;text-align:center;font-size:10px;background-color:#ccc"><b>' . ($SYSAVG/$result_seCount['COUNT']) . '</b></td>
        <td colspan="2" style="border-right:1px solid #000;padding:13px;text-align:center;font-size:10px;background-color:#ccc"><b>' . ($DIAAVG/$result_seCount['COUNT']) . '</b></td>
        <td colspan="2" style="border-right:1px solid #000;padding:13px;text-align:center;font-size:10px;background-color:#ccc"><b>' . ($PULSEAVG/$result_seCount['COUNT']) . '</b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:13px;text-align:center;font-size:10px;background-color:#ccc"><b>' . ($TEMPAVG/$result_seCount['COUNT']) . '</b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:13px;text-align:center;font-size:10px;background-color:#ccc"><b>' . ($ALCOAVG/$result_seCount['COUNT']) . '</b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:13px;text-align:center;font-size:10px;background-color:#ccc"><b>' . ($OXYGENAVG/$result_seCount['COUNT']) . '</b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:13px;text-align:center;font-size:10px;background-color:#ccc"><b></b></td>

      </tr>
    </tfoot>';


$table_end3 = '</table>';

// $table_footer3 = '<table style="width: 100%;">
//     <tbody>
//     <tr>
//     <td colspan="4">&nbsp;</td>
//     </tr>
//     <tr>
//     <td colspan="4">&nbsp;</td>
//     </tr>
//     <tr>
//     <td colspan="4">&nbsp;</td>
//     </tr>
//     <tr>
//     <td colspan="4">&nbsp;</td>
//     </tr>

//     <tr>
//     <td style="width: 33%;text-align:left;font-size:20px">ผู้จัดทำ..............................</td>

//      <td style="width: 34%;text-align:center;font-size:20px">ผู้ตรวจสอบ..........................</td>

//      <td style="width: 33%;text-align:right;font-size:20px">ผู้อนุมัติ..............................</td>

//     </tr>



//     </tbody>
// </table>';


$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table1);

$mpdf->SetHTMLHeader($table_header3, 'O', true);
$mpdf->WriteHTML($table_begin3);
$mpdf->WriteHTML($thead3);
$mpdf->WriteHTML($tbody3);
$mpdf->WriteHTML($tfoot3);
$mpdf->WriteHTML($table_end3);
// $mpdf->WriteHTML($table_footer3);

$mpdf->Output();

sqlsrv_close($conn);
?>
