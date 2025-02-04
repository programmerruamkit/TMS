<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
<?php
session_start();
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
ini_set('max_execution_time', 300);
// set_time_limit(500);
$conn = connect("RTMS");



$conditionEHR = " AND a.PersonCode='" . $_GET['employeecode'] . "'";
$sql_seEHR = "{call megEmployeeEHR_v2(?,?)}";
$params_seEHR = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($conditionEHR, SQLSRV_PARAM_IN)
);
$query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
$result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);





// CHECK DRIVINGPATTERN ID
$sql_seDrivinpattrenID = "SELECT b.DRIVINGPATTERNGO_ID,d.DRIVINGPATTERNRETURN_ID,a.EMPLOYEECODE1,a.EMPLOYEECODE2,b.PLANID1,b.PLANID2 
FROM VEHICLETRANSPORTPLAN a 
INNER JOIN [dbo].[DRIVINGPATTERN_GO] b ON b.PLANID1 = a.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[DRIVINGPATTERN_RETURN] d ON d.DRIVINGPATTERNRETURN_ID = b.DRIVINGPATTERNRETURN_ID
INNER JOIN VEHICLEINFO c ON c.THAINAME = a.THAINAME
WHERE a.ACTIVESTATUS = '1'
AND c.ACTIVESTATUS ='1'
AND (a.EMPLOYEECODE1 ='".$_GET['employeecode']."' OR a.EMPLOYEECODE2 ='".$_GET['employeecode']."')
AND CONVERT(DATE,a.DATEWORKING,103) = CONVERT(DATE,'".$_GET['datestart']."',103) ";
$params_seDrivinpattrenID = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($conditionEHR, SQLSRV_PARAM_IN)
);
$query_seDrivinpattrenID = sqlsrv_query($conn, $sql_seDrivinpattrenID, $params_seDrivinpattrenID);
$result_seDrivinpattrenID = sqlsrv_fetch_array($query_seDrivinpattrenID, SQLSRV_FETCH_ASSOC);

// CHECK DATA PLAN
$sql_seplandata = "SELECT b.DRIVINGPATTERNGO_ID,d.DRIVINGPATTERNRETURN_ID,a.EMPLOYEECODE1,a.EMPLOYEENAME1,a.EMPLOYEECODE2,a.EMPLOYEENAME2,b.PLANID1,b.PLANID2 
FROM VEHICLETRANSPORTPLAN a 
INNER JOIN [dbo].[DRIVINGPATTERN_GO] b ON b.PLANID1 = a.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[DRIVINGPATTERN_RETURN] d ON d.DRIVINGPATTERNRETURN_ID = b.DRIVINGPATTERNRETURN_ID
INNER JOIN VEHICLEINFO c ON c.THAINAME = a.THAINAME
WHERE a.ACTIVESTATUS = '1'
AND c.ACTIVESTATUS ='1'
AND (a.EMPLOYEECODE1 ='".$_GET['employeecode']."' OR a.EMPLOYEECODE2 ='".$_GET['employeecode']."')
AND CONVERT(DATE,a.DATEWORKING,103) = CONVERT(DATE,'".$_GET['datestart']."',103) ";
$params_seplandata = array();
$query_seplandata = sqlsrv_query($conn, $sql_seplandata, $params_seplandata);
$result_seplandata = sqlsrv_fetch_array($query_seplandata, SQLSRV_FETCH_ASSOC);

// CHECK WORKING AGE EMP1
$sql_seworkingage1 = "SELECT yearw AS 'YEARW',monthw AS 'MONTHW' FROM EMPLOYEEEHR2 WHERE PersonCode ='".$result_seplandata['EMPLOYEECODE1']."' ";
$params_seworkingage1  = array();
$query_seworkingage1   = sqlsrv_query($conn, $sql_seworkingage1, $params_seworkingage1);
$result_seworkingage1  = sqlsrv_fetch_array($query_seworkingage1, SQLSRV_FETCH_ASSOC);

// CHECK WORKING AGE EMP2
$sql_seworkingage2 = "SELECT yearw AS 'YEARW',monthw AS 'MONTHW' FROM EMPLOYEEEHR2 WHERE PersonCode ='".$result_seplandata['EMPLOYEECODE2']."' ";
$params_seworkingage2  = array();
$query_seworkingage2   = sqlsrv_query($conn, $sql_seworkingage2, $params_seworkingage2);
$result_seworkingage2  = sqlsrv_fetch_array($query_seworkingage2, SQLSRV_FETCH_ASSOC);

// $mpdf = new mPDF('th', 'A4-L', '0', '');
$mpdf = new mPDF('th', 'A3-L', '0', '', 5, 5, 5, 5, 5, 5);

// $mpdf = new mPDF('th', 'A4-L', '0', '', ซ้าย, บน, ล่าง, 5, 5, 5);
$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';



      $sql_seData = "SELECT DRIVINGPATTERNGO_ID,DRIVINGPATTERNRETURN_ID,EMPLOYEECODE1,EMPLOYEENAME1,EMPLOYEECODE2,EMPLOYEENAME2,THAINAME_ID,PLANING_ROUTE,ACTUAL_ROUTE,DRIVINGPATTERN_DATE,OFFICERCHECK_GO,
            PLANID1,PLANID2,TNKP_CHECK,TUBON_CHECK,TTHAIYEN_CHECK,TKAN_CHECK,JOBSTARTPLAN,DATESTARTPLAN,
            DRIVERNAME_PLAN_P1,DATESTART_PLAN_P1,PARKINGTIME_PLAN_4HUR_P1,DEPARTURETIME_PLAN_4HUR_P1,LOCATION_PLAN_4HUR_P1,PARKINGTIME_PLAN_2HUR_P1,DEPARTURETIME_PLAN_2HUR_P1,LOCATION_PLAN_2HUR_P1,
            DRIVERNAME_PLAN_P2,DATESTART_PLAN_P2,PARKINGTIME_PLAN_4HUR_P2,DEPARTURETIME_PLAN_4HUR_P2,LOCATION_PLAN_4HUR_P2,PARKINGTIME_PLAN_2HUR_P2,DEPARTURETIME_PLAN_2HUR_P2,LOCATION_PLAN_2HUR_P2,
            DRIVERNAME_PLAN_P3,DATESTART_PLAN_P3,PARKINGTIME_PLAN_4HUR_P3,DEPARTURETIME_PLAN_4HUR_P3,LOCATION_PLAN_4HUR_P3,PARKINGTIME_PLAN_2HUR_P3,DEPARTURETIME_PLAN_2HUR_P3,LOCATION_PLAN_2HUR_P3,
            DRIVERNAME_PLAN_P4,DATESTART_PLAN_P4,PARKINGTIME_PLAN_4HUR_P4,DEPARTURETIME_PLAN_4HUR_P4,LOCATION_PLAN_4HUR_P4,PARKINGTIME_PLAN_2HUR_P4,DEPARTURETIME_PLAN_2HUR_P4,LOCATION_PLAN_2HUR_P4,
            DRIVERNAME_PLAN_P5,DATESTART_PLAN_P5,PARKINGTIME_PLAN_4HUR_P5,DEPARTURETIME_PLAN_4HUR_P5,LOCATION_PLAN_4HUR_P5,PARKINGTIME_PLAN_2HUR_P5,DEPARTURETIME_PLAN_2HUR_P5,LOCATION_PLAN_2HUR_P5,
            DRIVERNAME_PLAN_P6,DATESTART_PLAN_P6,PARKINGTIME_PLAN_4HUR_P6,DEPARTURETIME_PLAN_4HUR_P6,LOCATION_PLAN_4HUR_P6,PARKINGTIME_PLAN_2HUR_P6,DEPARTURETIME_PLAN_2HUR_P6,LOCATION_PLAN_2HUR_P6,
                        
            DEALER1_PLAN,PARKINGTIME_PLAN_DEALER1,DEPARTURETIME_PLAN_DEALER1,SUM_PLAN_DEALER1,
            DEALER2_PLAN,PARKINGTIME_PLAN_DEALER2,DEPARTURETIME_PLAN_DEALER2,SUM_PLAN_DEALER2,
            DEALER3_PLAN,PARKINGTIME_PLAN_DEALER3,DEPARTURETIME_PLAN_DEALER3,SUM_PLAN_DEALER3,
            DEALER4_PLAN,PARKINGTIME_PLAN_DEALER4,DEPARTURETIME_PLAN_DEALER4,SUM_PLAN_DEALER4,
            CREATEBY_PLANGO,CONVERT(VARCHAR(16),CREATEDATE_PLANGO,20) AS 'CREATEDATE_PLANGO',MODIFIEDBY_PLANGO,MODIFIEDDATE_PLANGO,DRIVINGPATTERNGO_STATUS

            JOBSTARTACTUAL,DATESTARTACTUAL,
            DRIVERNAME_ACTUAL_P1,DATESTART_ACTUAL_P1,PARKINGTIME_ACTUAL_4HUR_P1,DEPARTURETIME_ACTUAL_4HUR_P1,LOCATION_ACTUAL_4HUR_P1,PARKINGTIME_ACTUAL_2HUR_P1,DEPARTURETIME_ACTUAL_2HUR_P1,LOCATION_ACTUAL_2HUR_P1,
            LAT_ACTUAL_4HUR_P1,LONG_ACTUAL_4HUR_P1,LAT_ACTUAL_2HUR_P1,LONG_ACTUAL_2HUR_P1,
            DRIVERNAME_ACTUAL_P2,DATESTART_ACTUAL_P2,PARKINGTIME_ACTUAL_4HUR_P2,DEPARTURETIME_ACTUAL_4HUR_P2,LOCATION_ACTUAL_4HUR_P2,PARKINGTIME_ACTUAL_2HUR_P2,DEPARTURETIME_ACTUAL_2HUR_P2,LOCATION_ACTUAL_2HUR_P2,
            LAT_ACTUAL_4HUR_P2,LONG_ACTUAL_4HUR_P2,LAT_ACTUAL_2HUR_P2,LONG_ACTUAL_2HUR_P2,
            DRIVERNAME_ACTUAL_P3,DATESTART_ACTUAL_P3,PARKINGTIME_ACTUAL_4HUR_P3,DEPARTURETIME_ACTUAL_4HUR_P3,LOCATION_ACTUAL_4HUR_P3,PARKINGTIME_ACTUAL_2HUR_P3,DEPARTURETIME_ACTUAL_2HUR_P3,LOCATION_ACTUAL_2HUR_P3,
            LAT_ACTUAL_4HUR_P3,LONG_ACTUAL_4HUR_P3,LAT_ACTUAL_2HUR_P3,LONG_ACTUAL_2HUR_P3,
            DRIVERNAME_ACTUAL_P4,DATESTART_ACTUAL_P4,PARKINGTIME_ACTUAL_4HUR_P4,DEPARTURETIME_ACTUAL_4HUR_P4,LOCATION_ACTUAL_4HUR_P4,PARKINGTIME_ACTUAL_2HUR_P4,DEPARTURETIME_ACTUAL_2HUR_P4,LOCATION_ACTUAL_2HUR_P4,
            LAT_ACTUAL_4HUR_P4,LONG_ACTUAL_4HUR_P4,LAT_ACTUAL_2HUR_P4,LONG_ACTUAL_2HUR_P4,
            DRIVERNAME_ACTUAL_P5,DATESTART_ACTUAL_P5,PARKINGTIME_ACTUAL_4HUR_P5,DEPARTURETIME_ACTUAL_4HUR_P5,LOCATION_ACTUAL_4HUR_P5,PARKINGTIME_ACTUAL_2HUR_P5,DEPARTURETIME_ACTUAL_2HUR_P5,LOCATION_ACTUAL_2HUR_P5,
            LAT_ACTUAL_4HUR_P5,LONG_ACTUAL_4HUR_P5,LAT_ACTUAL_2HUR_P5,LONG_ACTUAL_2HUR_P5,
            DRIVERNAME_ACTUAL_P6,DATESTART_ACTUAL_P6,PARKINGTIME_ACTUAL_4HUR_P6,DEPARTURETIME_ACTUAL_4HUR_P6,LOCATION_ACTUAL_4HUR_P6,PARKINGTIME_ACTUAL_2HUR_P6,DEPARTURETIME_ACTUAL_2HUR_P6,LOCATION_ACTUAL_2HUR_P6,
            LAT_ACTUAL_4HUR_P6,LONG_ACTUAL_4HUR_P6,LAT_ACTUAL_2HUR_P6,LONG_ACTUAL_2HUR_P6,

            DEALER1_ACTUAL,PARKINGTIME_ACTUAL_DEALER1,DEPARTURETIME_ACTUAL_DEALER1,SUM_ACTUAL_DEALER1,
            DEALER2_ACTUAL,PARKINGTIME_ACTUAL_DEALER2,DEPARTURETIME_ACTUAL_DEALER2,SUM_ACTUAL_DEALER2,
            DEALER3_ACTUAL,PARKINGTIME_ACTUAL_DEALER3,DEPARTURETIME_ACTUAL_DEALER3,SUM_ACTUAL_DEALER3,
            DEALER4_ACTUAL,PARKINGTIME_ACTUAL_DEALER4,DEPARTURETIME_ACTUAL_DEALER4,SUM_ACTUAL_DEALER4,
            CREATEBY_ACTUALGO,CREATEDATE_ACTUALGO,MODIFIEDBY_ACTUALGO,MIDIFIEDDATE_ACTUALGO,CONFIRMEDBY_ACTUALGO,CONVERT(VARCHAR,CONFIRMEDDATE_ACTUALGO,20) AS 'CONFIRMEDDATE_ACTUALGO',

            CONFIRMEDBY_P1,CONVERT(VARCHAR,CONFIRMEDDATE_P1,20) AS 'CONFIRMEDDATE_P1',CONFIRMEDBY_P2,CONVERT(VARCHAR,CONFIRMEDDATE_P2,20) AS 'CONFIRMEDDATE_P2',CONFIRMEDBY_P3,CONVERT(VARCHAR,CONFIRMEDDATE_P3,20) AS 'CONFIRMEDDATE_P3',
            CONFIRMEDBY_P4,CONVERT(VARCHAR,CONFIRMEDDATE_P4,20) AS 'CONFIRMEDDATE_P4',CONFIRMEDBY_P5,CONVERT(VARCHAR,CONFIRMEDDATE_P5,20) AS 'CONFIRMEDDATE_P5',CONFIRMEDBY_P6,CONVERT(VARCHAR,CONFIRMEDDATE_P6,20) AS 'CONFIRMEDDATE_P6',
            CONFIRMEDBY_ACTUAL_DEALER,CONVERT(VARCHAR,CONFIRMEDDATE_ACTUAL_DEALER,20) AS 'CONFIRMEDDATE_ACTUAL_DEALER',
            DRIVINGPATTERNGO_STATUS

            
            FROM DRIVINGPATTERN_GO
            WHERE DRIVINGPATTERNGO_ID ='".$result_seDrivinpattrenID['DRIVINGPATTERNGO_ID']."'";
      $params_seData    = array();
      $query_seData     = sqlsrv_query($conn, $sql_seData, $params_seData);
      $result_seData    = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC);



      $currect    = "<img src='../images/ok.png' width='20px' height='20px'>";
      $square     = "<img src='../images/square.png' width='15px' height='15px'>";
      $TNKP       = ($result_seData['TNKP_CHECK'] == "1") ? "<img src='../images/check-square.png' width='20px' height='20px'>" : "<img src='../images/square.png' width='20px' height='20px'>";
      $TUBON      = ($result_seData['TUBON_CHECK'] == "1") ? "<img src='../images/check-square.png' width='20px' height='20px'>" : "<img src='../images/square.png' width='20px' height='20px'>";
      $TTHAIYEN   = ($result_seData['TTHAIYEN_CHECK'] == "1") ? "<img src='../images/check-square.png' width='20px' height='20px'>" : "<img src='../images/square.png' width='20px' height='20px'>";
      $TKAN       = ($result_seData['TKAN_CHECK'] == "1") ? "<img src='../images/check-square.png' width='20px' height='20px'>" : "<img src='../images/square.png' width='20px' height='20px'>";

      

// แผนขาไป
$table_begin_goplan = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size: 10px;">';

    $tr_goplan = '<thead>
     <tr style="border:1px solid #000;" >
         <td colspan="80" style="padding:3px;border-right:1px solid #000;text-align:left;font-size: 12px;"><h4>เอกสารรูปแบบการวิ่งงาน (Driving Pattern) หน้า 1</h4></td>
         <td colspan="10" style="padding:3px;border-right:1px solid #000;text-align:left;font-size: 12px;"><h4>เบอร์รถ</h4></td>
         <td colspan="20" style="padding:3px;border-right:1px solid #000;text-align:left;font-size: 12px;"><h4>'.str_replace("(4L)","",$result_seData['THAINAME_ID']).'</h4></td>
         <td colspan="20" style="padding:3px;border-right:1px solid #000;text-align:left;font-size: 12px;"><h4>รูทงานตามแผน</h4></td>
         <td colspan="20" style="padding:3px;border-right:1px solid #000;text-align:left;font-size: 12px;"><h4>'.$result_seData['PLANING_ROUTE'].'</h4></td>
         <td colspan="20" style="padding:3px;border-right:1px solid #000;text-align:left;font-size: 12px;"><h4>รูทงานวิ่งจริง</h4></td>
         <td colspan="20" style="padding:3px;border-right:1px solid #000;text-align:left;font-size: 12px;"><h4>'.$result_seData['ACTUAL_ROUTE'].'</h4></td>
         <td colspan="20" style="padding:3px;border-right:1px solid #000;text-align:left;font-size: 12px;"><h4>วัน/เดือน/ปี</h4></td>
         <td colspan="30" style="padding:3px;border-right:1px solid #000;text-align:left;font-size: 12px;"><h4>'.$result_seData['CREATEDATE_PLANGO'].'</h4></td>
     </tr>

      <tr style="border:1px solid #000;padding:1px;" >
         <td colspan="80" style="font-size: 12px;border-right:5px">
               <b><u>วัตถุประสงค์</u></b>
               <br><br>
               <b>&nbsp;&nbsp;1.การขับขี่ต่อเนื่องต้องไม่เกิน 4 ชม. และต้องพักอย่างน้อย 30 นาที</b>
               <br><br>
               <b>&nbsp;&nbsp;2.สามารถขับขี่ได้ 6 ชม. ต้องเปลี่ยนมือ</b>
               <br><br>
               <b>&nbsp;&nbsp;3.หากพบสิ่งผิดปกติให้ หยุด เรียก รอ</b>
               <br><br>
               <b>&nbsp;&nbsp;4.ง่วงไม่ฝืนขับ</b>
               <br><br>
               <b>&nbsp;&nbsp;5.ปรับสลักเป็น 4x2 หรือต่ำกว่า ก่อนไปยัง ดีลเลอร์ ที่มีปัญหาเรื่องความสูง </b>
               <br>&nbsp;<b>(ทำเครื่องหมาย '.$currect.' ในช่อง '.$square .' เพื่อยืนยันว่ามีการปรับแล้ว)</b>
               <br><br>
               <b>&nbsp;&nbsp;&nbsp;<p>โตโยต้า นครพิงค์ '.$TNKP .'&nbsp;&nbsp;&nbsp;โตโยต้า อุบลราชธานี '.$TUBON .'&nbsp;&nbsp;&nbsp;โตโยต้า อุบลราชธานี '.$TTHAIYEN .'&nbsp;&nbsp;&nbsp;โตโยต้า อุบลราชธานี '.$TKAN .'</p></b>
               
         </td>
         <td colspan="80" style="font-size: 12px;border:1px solid #000;padding:1px;">
               <b><u>วิธีการ</u></b>
               <br><br>
               <b>&nbsp;<u>ขั้นตอนเท็งโกะเริ่มงาน :</u> ให้ พขร.และผู้ควบคุมร่วมกันวางแผนการวิ่งงานทั้งขาไปและขากลับ</b>
               <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <b>และให้ พขร. แบ่งหน้าที่ว่าใครจะเป็น นาย A และ B</b>
               <br><br>
               <b>&nbsp;<u>ขั้นตอนเท็งโกะเลิกงาน :</u> ให้ พขร.ลงบันทึกการขับขี่จริงพร้อมยื่นให้เจ้าหน้าที่เท็งโกะ</b>
               <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <b>ตรวจสอบการวิ่งงานจริง</b>
               <br><br><br><br><br><br><br><br>
         </td>
         <td colspan="80" style="font-size: 12px;border-right:1px solid #000;padding:1px;">
               
               <b><u>โปรดลงชื่อรับทราบในขั้นตอนการทำเท็งโกะเริ่มงาน</u></b>
               <br><br>
               <b>&nbsp;<u>นาย A :</u> รหัสพนักงาน&nbsp;&nbsp;=> '.$result_seplandata['EMPLOYEECODE1'].'</b>
               <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <b>ชื่อ-นามสกุล&nbsp;&nbsp;=> '.$result_seplandata['EMPLOYEENAME1'].'</b>
               <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <b>อายุงาน&nbsp;&nbsp;=> '.$result_seworkingage1['YEARW'].' ปี&nbsp;&nbsp;'.$result_seworkingage1['MONTHW'].' เดือน</b>
               <br><br><br><br>
               <b>&nbsp;<u>นาย B :</u> รหัสพนักงาน&nbsp;&nbsp;=> '.$result_seplandata['EMPLOYEECODE1'].'</b>
               <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <b>ชื่อ-นามสกุล&nbsp;&nbsp;=> '.$result_seplandata['EMPLOYEENAME2'].' </b>
               <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <b>อายุงาน&nbsp;&nbsp;=> '.$result_seworkingage2['YEARW'].' ปี&nbsp;&nbsp;'.$result_seworkingage2['MONTHW'].' เดือน</b>
               <br><br><br>
         </td>
      </tr>
      
      
       <tr style="border:1px solid #000;" >
         <td colspan="240" style="border-right:1px solid #000;padding:2px;text-align:right;font-size: 12px;">
                ผู้ตรวจแผนขาไป : ' . $result_seData['CONFIRMEDBY_ACTUALGO'] . '  
         </td> 
       </tr>
       <tr style="border:1px solid #000;" >
         <td colspan="240" style="border-right:1px solid #000;padding:5px;text-align:right;font-size: 12px;background-color: #ccc"></td> 
       </tr>
       <tr style="border:1px solid #000;" >
         <td colspan="100" style="border-right:1px solid #000;padding:2px;text-align:center;font-size: 12px;"><b>แผนขาไป</b></td> 
         <td colspan="25" style="border-right:1px solid #000;padding:2px;text-align:center;font-size: 12px;"><b>ออกเดินทางจาก</b></td> 
         <td colspan="25" style="border-right:1px solid #000;padding:2px;text-align:center;font-size: 12px;"><b>'.$result_seData['JOBSTARTPLAN'].'</b></td>
         <td colspan="25" style="border-right:1px solid #000;padding:2px;text-align:center;font-size: 12px;"><b>เวลา</b></td> 
         <td colspan="65" style="border-right:1px solid #000;padding:2px;text-align:center;font-size: 12px;"><b>'.str_replace("T"," ",$result_seData['DATESTARTPLAN']).'</b></td>  
       </tr>
    </thead>';


$i = 1;



      $td_goplan .= '<tbody>
         <tr style="border:1px solid #000;" >
            <td colspan="240" style="border-right:1px solid #000;padding:5px;text-align:right;font-size: 12px;background-color: #ccc"></td> 
         </tr>
         <tr>
            <td colspan="60" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ข่วงที่1) : '.$result_seData['DRIVERNAME_PLAN_P1'].'</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seData['DATESTART_PLAN_P1']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_4HUR_P1']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_4HUR_P1']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_PLAN_4HUR_P1'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_2HUR_P1']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_2HUR_P1']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_PLAN_2HUR_P1'].'</b>
            </td>
            <td colspan="65" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ข่วงที่2) : '.$result_seData['DRIVERNAME_PLAN_P2'].'</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seData['DATESTART_PLAN_P2']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_4HUR_P2']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_4HUR_P2']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_PLAN_4HUR_P2'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_2HUR_P2']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_2HUR_P2']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_PLAN_2HUR_P2'].'</b>
            </td>
            <td colspan="120" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ข่วงที่3) : '.$result_seData['DRIVERNAME_PLAN_P3'].'</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seData['DATESTART_PLAN_P3']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_4HUR_P3']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_4HUR_P3']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_PLAN_4HUR_P3'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_2HUR_P3']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_2HUR_P3']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_PLAN_2HUR_P3'].'</b>
            </td>
         </tr>
         <tr>
            <td colspan="60" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ข่วงที่4) :</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seData['DATESTART_PLAN_P4']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_4HUR_P4']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_4HUR_P4']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_PLAN_4HUR_P4'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_2HUR_P4']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_2HUR_P4']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_PLAN_2HUR_P4'].'</b>
            </td>
            <td colspan="65" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ข่วงที่5) :</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seData['DATESTART_PLAN_P5']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_4HUR_P5']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_4HUR_P5']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_PLAN_4HUR_P5'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_2HUR_P5']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_2HUR_P5']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_PLAN_2HUR_P5'].'</b>
            </td>
            <td colspan="120" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ข่วงที่6) :</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seData['DATESTART_PLAN_P6']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_4HUR_P6']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_4HUR_P6']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_PLAN_4HUR_P6'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_2HUR_P6']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_2HUR_P6']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_PLAN_2HUR_P6'].'</b>
            </td>
         </tr>
         <tr>
            <td colspan="60" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>โหลดรถลง :</u></b>
                  <br><br>
                  <b><u>ดีลเลอร์ 1 : '.$result_seData['DEALER1_PLAN'].'</u></b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_DEALER1']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_DEALER1']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>รวม&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['SUM_PLAN_DEALER1']).'</b>
                  <br><br>
                  <b><u>ดีลเลอร์ 2 : '.$result_seData['DEALER2_PLAN'].'</u></b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_DEALER2']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_DEALER2']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>รวม&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['SUM_PLAN_DEALER2']).'</b>
            </td>
            <td colspan="65" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>โหลดรถลง :</u></b>
                  <br><br>
                  <b><u>ดีลเลอร์ 3 : '.$result_seData['DEALER3_PLAN'].'</u></b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_DEALER3']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_DEALER3']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>รวม&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['SUM_PLAN_DEALER3']).'</b>
                  <br><br>
                  <b><u>ดีลเลอร์ 4 : '.$result_seData['DEALER4_PLAN'].'</u></b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_PLAN_DEALER4']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_PLAN_DEALER4']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>รวม&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['SUM_PLAN_DEALER4']).'</b>
            </td>
            <td colspan="120" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                 
            </td>
         </tr>
       </tbody>';


$table_end_goplan = '
   <tfoot>
      <tr style="border:1px solid #000;" >
         <td colspan="240" style="border-right:1px solid #000;padding:5px;text-align:right;font-size: 12px;background-color: #ccc"></td> 
       </tr>
   </tfoot>
</table>';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// วิ่งจริงขาไป
$table_begin_goactual = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size: 10px;">';

    $tr_goactual = '<thead>
       <tr style="border:1px solid #000;" >
         <td colspan="240" style="border-right:1px solid #000;padding:5px;text-align:right;font-size: 12px;background-color: #ccc"></td> 
       </tr>
       <tr style="border:1px solid #000;" >
         <td colspan="100" style="border-right:1px solid #000;padding:2px;text-align:center;font-size: 12px;"><b>วิ่งจริงขาไป</b></td> 
         <td colspan="25" style="border-right:1px solid #000;padding:2px;text-align:center;font-size: 12px;"><b>ออกเดินทางจาก</b></td> 
         <td colspan="25" style="border-right:1px solid #000;padding:2px;text-align:center;font-size: 12px;"><b>RRR</b></td>
         <td colspan="25" style="border-right:1px solid #000;padding:2px;text-align:center;font-size: 12px;"><b>เวลา</b></td> 
         <td colspan="65" style="border-right:1px solid #000;padding:2px;text-align:center;font-size: 12px;"><b>17/01/2025 17:40</b></td>  
       </tr>
    </thead>';


      $td_goactual .= '<tbody>
         <tr style="border:1px solid #000;" >
            <td colspan="240" style="border-right:1px solid #000;padding:5px;text-align:right;font-size: 12px;background-color: #ccc"></td> 
         </tr>
         <tr>
            <td colspan="55" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ข่วงที่1) : '.$result_seData['DRIVERNAME_ACTUAL_P1'].'</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seData['DATESTART_ACTUAL_P1']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_4HUR_P1']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_4HUR_P1']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_ACTUAL_4HUR_P1'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_2HUR_P1']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_2HUR_P1']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_ACTUAL_2HUR_P1'].'</b>
            </td>
            <td colspan="65" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ข่วงที่2) :</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seData['DATESTART_ACTUAL_P2']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_4HUR_P2']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_4HUR_P2']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_ACTUAL_4HUR_P2'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_2HUR_P2']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_2HUR_P2']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_ACTUAL_2HUR_P2'].'</b>
            </td>
            <td colspan="120" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ข่วงที่3) :</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seData['DATESTART_ACTUAL_P3']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_4HUR_P3']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_4HUR_P3']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_ACTUAL_4HUR_P3'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_2HUR_P3']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_2HUR_P3']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_ACTUAL_2HUR_P3'].'</b>
            </td>
         </tr>
         <tr>
            <td colspan="55" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ข่วงที่4) :</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seData['DATESTART_ACTUAL_P4']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_4HUR_P4']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_4HUR_P4']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_ACTUAL_4HUR_P4'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_2HUR_P4']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_2HUR_P4']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_ACTUAL_2HUR_P4'].'</b>
            </td>
            <td colspan="65" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ข่วงที่5) :</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seData['DATESTART_ACTUAL_P5']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_4HUR_P5']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_4HUR_P5']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_ACTUAL_4HUR_P5'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_2HUR_P5']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_2HUR_P5']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_ACTUAL_2HUR_P5'].'</b>
            </td>
            <td colspan="120" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ข่วงที่6) :</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seData['DATESTART_ACTUAL_P6']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_4HUR_P6']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_4HUR_P6']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_ACTUAL_4HUR_P6'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_2HUR_P6']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_2HUR_P6']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seData['LOCATION_ACTUAL_2HUR_P6'].'</b>
            </td>
         </tr>
         <tr>
            <td colspan="55" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>โหลดรถลง :</u></b>
                  <br><br>
                  <b><u>ดีลเลอร์ 1 : '.$result_seData['DEALER1_ACTUAL'].'</u></b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_DEALER1']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_DEALER1']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>รวม&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['SUM_ACTUAL_DEALER1']).'</b>
                  <br><br>
                  <b><u>ดีลเลอร์ 2 : '.$result_seData['DEALER2_ACTUAL'].'</u></b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_DEALER2']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_DEALER2']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>รวม&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['SUM_ACTUAL_DEALER2']).'</b>
            </td>
            <td colspan="65" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>โหลดรถลง :</u></b>
                  <br><br>
                  <b><u>ดีลเลอร์ 3 : '.$result_seData['DEALER3_ACTUAL'].'</u></b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_DEALER3']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_DEALER3']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>รวม&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['SUM_ACTUAL_DEALER3']).'</b>
                  <br><br>
                  <b><u>ดีลเลอร์ 4 : '.$result_seData['DEALER4_ACTUAL'].'</u></b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['PARKINGTIME_ACTUAL_DEALER4']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['DEPARTURETIME_ACTUAL_DEALER4']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>รวม&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seData['SUM_ACTUAL_DEALER4']).'</b>
            </td>
            <td colspan="120" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                 
            </td>
         </tr>
       </tbody>';


$table_end_goactual = '
   <tfoot>
      <tr style="border:1px solid #000;" >
         <td colspan="240" style="border-right:1px solid #000;padding:5px;text-align:right;font-size: 12px;background-color: #ccc"></td> 
       </tr>
   </tfoot>
</table>';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$sql_seDataBack = "SELECT DRIVINGPATTERNGO_ID,DRIVINGPATTERNRETURN_ID,EMPLOYEECODE1,EMPLOYEENAME1,EMPLOYEECODE2,EMPLOYEENAME2,THAINAME_ID,PLANING_ROUTE,ACTUAL_ROUTE,DRIVINGPATTERN_DATE,OFFICERCHECK_RETURN,
            PLANID1,PLANID2,TNKP_CHECK,TUBON_CHECK,TTHAIYEN_CHECK,TKAN_CHECK,JOBSTARTPLAN,DATESTARTPLAN,
            DRIVERNAME_PLAN_P1,DATESTART_PLAN_P1,PARKINGTIME_PLAN_4HUR_P1,DEPARTURETIME_PLAN_4HUR_P1,LOCATION_PLAN_4HUR_P1,PARKINGTIME_PLAN_2HUR_P1,DEPARTURETIME_PLAN_2HUR_P1,LOCATION_PLAN_2HUR_P1,
            DRIVERNAME_PLAN_P2,DATESTART_PLAN_P2,PARKINGTIME_PLAN_4HUR_P2,DEPARTURETIME_PLAN_4HUR_P2,LOCATION_PLAN_4HUR_P2,PARKINGTIME_PLAN_2HUR_P2,DEPARTURETIME_PLAN_2HUR_P2,LOCATION_PLAN_2HUR_P2,
            DRIVERNAME_PLAN_P3,DATESTART_PLAN_P3,PARKINGTIME_PLAN_4HUR_P3,DEPARTURETIME_PLAN_4HUR_P3,LOCATION_PLAN_4HUR_P3,PARKINGTIME_PLAN_2HUR_P3,DEPARTURETIME_PLAN_2HUR_P3,LOCATION_PLAN_2HUR_P3,
            DRIVERNAME_PLAN_P4,DATESTART_PLAN_P4,PARKINGTIME_PLAN_4HUR_P4,DEPARTURETIME_PLAN_4HUR_P4,LOCATION_PLAN_4HUR_P4,PARKINGTIME_PLAN_2HUR_P4,DEPARTURETIME_PLAN_2HUR_P4,LOCATION_PLAN_2HUR_P4,
            DRIVERNAME_PLAN_P5,DATESTART_PLAN_P5,PARKINGTIME_PLAN_4HUR_P5,DEPARTURETIME_PLAN_4HUR_P5,LOCATION_PLAN_4HUR_P5,PARKINGTIME_PLAN_2HUR_P5,DEPARTURETIME_PLAN_2HUR_P5,LOCATION_PLAN_2HUR_P5,
            DRIVERNAME_PLAN_P6,DATESTART_PLAN_P6,PARKINGTIME_PLAN_4HUR_P6,DEPARTURETIME_PLAN_4HUR_P6,LOCATION_PLAN_4HUR_P6,PARKINGTIME_PLAN_2HUR_P6,DEPARTURETIME_PLAN_2HUR_P6,LOCATION_PLAN_2HUR_P6,
                                    
            DEALER1_PLAN,PARKINGTIME_PLAN_DEALER1,DEPARTURETIME_PLAN_DEALER1,SUM_PLAN_DEALER1,
            DEALER2_PLAN,PARKINGTIME_PLAN_DEALER2,DEPARTURETIME_PLAN_DEALER2,SUM_PLAN_DEALER2,
            DEALER3_PLAN,PARKINGTIME_PLAN_DEALER3,DEPARTURETIME_PLAN_DEALER3,SUM_PLAN_DEALER3,
            DEALER4_PLAN,PARKINGTIME_PLAN_DEALER4,DEPARTURETIME_PLAN_DEALER4,SUM_PLAN_DEALER4,
            CREATEBY_PLANRETURN,CONVERT(VARCHAR(16),CREATEDATE_PLANRETURN,20) AS 'CREATEDATE_PLANRETURN',MODIFIEDBY_PLANRETURN,MODIFIEDDATE_PLANRETURN,

            JOBSTARTACTUAL,DATESTARTACTUAL,
            DRIVERNAME_ACTUAL_P1,DATESTART_ACTUAL_P1,PARKINGTIME_ACTUAL_4HUR_P1,DEPARTURETIME_ACTUAL_4HUR_P1,LOCATION_ACTUAL_4HUR_P1,PARKINGTIME_ACTUAL_2HUR_P1,DEPARTURETIME_ACTUAL_2HUR_P1,LOCATION_ACTUAL_2HUR_P1,
            DRIVERNAME_ACTUAL_P2,DATESTART_ACTUAL_P2,PARKINGTIME_ACTUAL_4HUR_P2,DEPARTURETIME_ACTUAL_4HUR_P2,LOCATION_ACTUAL_4HUR_P2,PARKINGTIME_ACTUAL_2HUR_P2,DEPARTURETIME_ACTUAL_2HUR_P2,LOCATION_ACTUAL_2HUR_P2,
            DRIVERNAME_ACTUAL_P3,DATESTART_ACTUAL_P3,PARKINGTIME_ACTUAL_4HUR_P3,DEPARTURETIME_ACTUAL_4HUR_P3,LOCATION_ACTUAL_4HUR_P3,PARKINGTIME_ACTUAL_2HUR_P3,DEPARTURETIME_ACTUAL_2HUR_P3,LOCATION_ACTUAL_2HUR_P3,
            DRIVERNAME_ACTUAL_P4,DATESTART_ACTUAL_P4,PARKINGTIME_ACTUAL_4HUR_P4,DEPARTURETIME_ACTUAL_4HUR_P4,LOCATION_ACTUAL_4HUR_P4,PARKINGTIME_ACTUAL_2HUR_P4,DEPARTURETIME_ACTUAL_2HUR_P4,LOCATION_ACTUAL_2HUR_P4,
            DRIVERNAME_ACTUAL_P5,DATESTART_ACTUAL_P5,PARKINGTIME_ACTUAL_4HUR_P5,DEPARTURETIME_ACTUAL_4HUR_P5,LOCATION_ACTUAL_4HUR_P5,PARKINGTIME_ACTUAL_2HUR_P5,DEPARTURETIME_ACTUAL_2HUR_P5,LOCATION_ACTUAL_2HUR_P5,
            DRIVERNAME_ACTUAL_P6,DATESTART_ACTUAL_P6,PARKINGTIME_ACTUAL_4HUR_P6,DEPARTURETIME_ACTUAL_4HUR_P6,LOCATION_ACTUAL_4HUR_P6,PARKINGTIME_ACTUAL_2HUR_P6,DEPARTURETIME_ACTUAL_2HUR_P6,LOCATION_ACTUAL_2HUR_P6,
                                                
            DEALER1_ACTUAL,PARKINGTIME_ACTUAL_DEALER1,DEPARTURETIME_ACTUAL_DEALER1,SUM_ACTUAL_DEALER1,
            DEALER2_ACTUAL,PARKINGTIME_ACTUAL_DEALER2,DEPARTURETIME_ACTUAL_DEALER2,SUM_ACTUAL_DEALER2,
            DEALER3_ACTUAL,PARKINGTIME_ACTUAL_DEALER3,DEPARTURETIME_ACTUAL_DEALER3,SUM_ACTUAL_DEALER3,
            DEALER4_ACTUAL,PARKINGTIME_ACTUAL_DEALER4,DEPARTURETIME_ACTUAL_DEALER4,SUM_ACTUAL_DEALER4,
            CREATEBY_ACTUALRETURN,CREATEDATE_ACTUALRETURN,MODIFIEDBY_ACTUALRETURN,MIDIFIEDDATE_ACTUALRETURN,CONFIRMEDBY_ACTUALRETURN,CONVERT(VARCHAR,CONFIRMEDDATE_ACTUALRETURN,20) AS 'CONFIRMEDDATE_ACTUALRETURN',

            CONFIRMEDBY_P1,CONVERT(VARCHAR,CONFIRMEDDATE_P1,20) AS 'CONFIRMEDDATE_P1',CONFIRMEDBY_P2,CONVERT(VARCHAR,CONFIRMEDDATE_P2,20) AS 'CONFIRMEDDATE_P2',CONFIRMEDBY_P3,CONVERT(VARCHAR,CONFIRMEDDATE_P3,20) AS 'CONFIRMEDDATE_P3',
            CONFIRMEDBY_P4,CONVERT(VARCHAR,CONFIRMEDDATE_P4,20) AS 'CONFIRMEDDATE_P4',CONFIRMEDBY_P5,CONVERT(VARCHAR,CONFIRMEDDATE_P5,20) AS 'CONFIRMEDDATE_P5',CONFIRMEDBY_P6,CONVERT(VARCHAR,CONFIRMEDDATE_P6,20) AS 'CONFIRMEDDATE_P6',
            CONFIRMEDBY_ACTUAL_DEALER,CONVERT(VARCHAR,CONFIRMEDDATE_ACTUAL_DEALER,20) AS 'CONFIRMEDDATE_ACTUAL_DEALER',
            DRIVINGPATTERNRETURN_STATUS

                        
            FROM [dbo].[DRIVINGPATTERN_RETURN] 
            WHERE DRIVINGPATTERNRETURN_ID ='".$result_seDrivinpattrenID['DRIVINGPATTERNRETURN_ID']."'";
      $params_seDataBack    = array();
      $query_seDataBack     = sqlsrv_query($conn, $sql_seDataBack, $params_seDataBack);
      $result_seDataBack    = sqlsrv_fetch_array($query_seDataBack, SQLSRV_FETCH_ASSOC);

// แผนขากลับ
$table_begin_backplan = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size: 10px;">';

    $tr_backplan = '<thead>
     <tr style="border:1px solid #000;" >
         <td colspan="80" style="padding:3px;border-right:1px solid #000;text-align:left;font-size: 12px;"><h4>เอกสารรูปแบบการวิ่งงาน (Driving Pattern) หน้า 2</h4></td>
         <td colspan="160" style="padding:3px;border-right:1px solid #000;text-align:left;font-size: 12px;"></td>

      <tr style="border:1px solid #000;padding:1px;" >
         <td colspan="80" style="font-size: 12px;border-right:5px">
               <b><u>วัตถุประสงค์</u></b>
               <br><br>
               <b>&nbsp;&nbsp;1.การขับขี่ต่อเนื่องต้องไม่เกิน 4 ชม. และต้องพักอย่างน้อย 30 นาที</b>
               <br><br>
               <b>&nbsp;&nbsp;2.สามารถขับขี่ได้ 6 ชม. ต้องเปลี่ยนมือ</b>
               <br><br>
               <b>&nbsp;&nbsp;3.หากพบสิ่งผิดปกติให้ หยุด เรียก รอ</b>
               <br><br>
               <b>&nbsp;&nbsp;4.ง่วงไม่ฝืนขับ</b>
               <br><br>
         </td>
         <td colspan="80" style="font-size: 12px;border:1px solid #000;padding:1px;">
               <b><u>วิธีการ</u></b>
               <br><br>
               <b>&nbsp;<u>ขั้นตอนเท็งโกะเริ่มงาน :</u> ให้ พขร.และผู้ควบคุมร่วมกันวางแผนการวิ่งงานทั้งขาไปและขากลับ</b>
               <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <b>และให้ พขร. แบ่งหน้าที่ว่าใครจะเป็น นาย A และ B</b>
               <br><br>
               <b>&nbsp;<u>ขั้นตอนเท็งโกะเลิกงาน :</u> ให้ พขร.ลงบันทึกการขับขี่จริงพร้อมยื่นให้เจ้าหน้าที่เท็งโกะ</b>
               <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <b>ตรวจสอบการวิ่งงานจริง</b>
               <br><br><br><br><br><br><br><br>
         </td>
         <td colspan="80" style="font-size: 12px;border-right:1px solid #000;padding:1px;">
               
               
         </td>
      </tr>
      
      
       <tr style="border:1px solid #000;" >
         <td colspan="240" style="border-right:1px solid #000;padding:2px;text-align:right;font-size: 12px;">
                ผู้ตรวจแผนขากลับ : ' . $result_seDataBack['CONFIRMEDBY_ACTUALRETURN'] . '    
         </td> 
       </tr>
       <tr style="border:1px solid #000;" >
         <td colspan="240" style="border-right:1px solid #000;padding:5px;text-align:right;font-size: 12px;background-color: #ccc"></td> 
       </tr>
       <tr style="border:1px solid #000;" >
         <td colspan="100" style="border-right:1px solid #000;padding:2px;text-align:center;font-size: 12px;"><b>แผนขากลับ</b></td> 
         <td colspan="25" style="border-right:1px solid #000;padding:2px;text-align:center;font-size: 12px;"><b>ออกเดินทางจาก</b></td> 
         <td colspan="25" style="border-right:1px solid #000;padding:2px;text-align:center;font-size: 12px;"><b>RRR</b></td>
         <td colspan="25" style="border-right:1px solid #000;padding:2px;text-align:center;font-size: 12px;"><b>เวลา</b></td> 
         <td colspan="65" style="border-right:1px solid #000;padding:2px;text-align:center;font-size: 12px;"><b>17/01/2025 17:40</b></td>  
       </tr>
    </thead>';


$i = 1;


      $td_backplan .= '<tbody>
         <tr style="border:1px solid #000;" >
            <td colspan="240" style="border-right:1px solid #000;padding:5px;text-align:right;font-size: 12px;background-color: #ccc"></td> 
         </tr>
         <tr>
            <td colspan="60" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ข่วงที่1) : '.$result_seDataBack['DRIVERNAME_PLAN_P1'].'</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seDataBack['DATESTART_PLAN_P1']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_PLAN_4HUR_P1']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_PLAN_4HUR_P1']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_PLAN_4HUR_P1'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_PLAN_2HUR_P1']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_PLAN_2HUR_P1']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_PLAN_2HUR_P1'].'</b>
                  
            </td>
            <td colspan="65" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ช่วงที่2) :</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seDataBack['DATESTART_PLAN_P2']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_PLAN_4HUR_P2']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_PLAN_4HUR_P2']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_PLAN_4HUR_P2'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_PLAN_2HUR_P2']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_PLAN_2HUR_P2']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_PLAN_2HUR_P2'].'</b>
            </td>
            <td colspan="115" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ช่วงที่3) :</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seDataBack['DATESTART_PLAN_P3']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_PLAN_4HUR_P3']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_PLAN_4HUR_P3']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_PLAN_4HUR_P3'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_PLAN_2HUR_P3']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_PLAN_2HUR_P3']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_PLAN_2HUR_P3'].'</b>
            </td>
         </tr>
         <tr>
            <td colspan="60" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ช่วงที่4) :</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seDataBack['DATESTART_PLAN_P4']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_PLAN_4HUR_P4']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_PLAN_4HUR_P4']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_PLAN_4HUR_P4'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_PLAN_2HUR_P4']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_PLAN_2HUR_P4']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_PLAN_2HUR_P4'].'</b>
            </td>
            <td colspan="65" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ช่วงที่5) :</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seDataBack['DATESTART_PLAN_P5']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_PLAN_4HUR_P5']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_PLAN_4HUR_P5']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_PLAN_4HUR_P5'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_PLAN_2HUR_P5']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_PLAN_2HUR_P5']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_PLAN_2HUR_P5'].'</b>
            </td>
            <td colspan="115" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ช่วงที่6) :</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seDataBack['DATESTART_PLAN_P6']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_PLAN_4HUR_P6']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_PLAN_4HUR_P6']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_PLAN_4HUR_P6'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_PLAN_2HUR_P6']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_PLAN_2HUR_P6']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_PLAN_2HUR_P6'].'</b>
            </td>
         </tr>
         <tr>
            <td colspan="60" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ปลายทาง/โหลดรถลง</u></b>
                  <br><br>
                  <b><u>สถานที่ : '.$result_seDataBack['DEALER1_PLAN'].'</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.$result_seDataBack['PARKINGTIME_PLAN_DEALER1'].'</b>
                  <br><br>
                  <b><u>VL : '.$result_seDataBack['DEALER2_PLAN'].'</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.$result_seDataBack['PARKINGTIME_PLAN_DEALER2'].'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.$result_seDataBack['DEPARTURETIME_PLAN_DEALER2'].'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>รวม&nbsp;&nbsp;=> '.$result_seDataBack['SUM_PLAN_DEALER2'].'</b>
            </td>
            <td colspan="65" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  
            </td>
            <td colspan="115" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                 
            </td>
         </tr>
       </tbody>';


$table_end_backplan = '
   <tfoot>
      <tr style="border:1px solid #000;" >
         <td colspan="240" style="border-right:1px solid #000;padding:5px;text-align:right;font-size: 12px;background-color: #ccc"></td> 
       </tr>
   </tfoot>
</table>';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// วิ่งจริงขากลับ
$table_begin_backactual = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size: 10px;">';

    $tr_backactual = '<thead>
       <tr style="border:1px solid #000;" >
         <td colspan="240" style="border-right:1px solid #000;padding:5px;text-align:right;font-size: 12px;background-color: #ccc"></td> 
       </tr>
       <tr style="border:1px solid #000;" >
         <td colspan="100" style="border-right:1px solid #000;padding:2px;text-align:center;font-size: 12px;"><b>วิ่งจริงขากลับ</b></td> 
         <td colspan="25" style="border-right:1px solid #000;padding:2px;text-align:center;font-size: 12px;"><b>ออกเดินทางจาก</b></td> 
         <td colspan="25" style="border-right:1px solid #000;padding:2px;text-align:center;font-size: 12px;"><b>RRR</b></td>
         <td colspan="25" style="border-right:1px solid #000;padding:2px;text-align:center;font-size: 12px;"><b>เวลา</b></td> 
         <td colspan="65" style="border-right:1px solid #000;padding:2px;text-align:center;font-size: 12px;"><b>17/01/2025 17:40</b></td>  
       </tr>
    </thead>';


      $td_backactual .= '<tbody>
         <tr style="border:1px solid #000;" >
            <td colspan="240" style="border-right:1px solid #000;padding:5px;text-align:right;font-size: 12px;background-color: #ccc"></td> 
         </tr>
         <tr>
            <td colspan="60" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ช่วงที่1) :</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seDataBack['DATESTART_ACTUAL_P1']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_ACTUAL_4HUR_P1']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_ACTUAL_4HUR_P1']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_ACTUAL_4HUR_P1'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_ACTUAL_2HUR_P1']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_ACTUAL_2HUR_P1']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_ACTUAL_2HUR_P1'].'</b>
                  
            </td>
            <td colspan="60" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ช่วงที่2) :</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seDataBack['DATESTART_ACTUAL_P2']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_ACTUAL_4HUR_P2']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_ACTUAL_4HUR_P2']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_ACTUAL_4HUR_P2'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_ACTUAL_2HUR_P2']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_ACTUAL_2HUR_P2']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_ACTUAL_2HUR_P2'].'</b>
            </td>
            <td colspan="120" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ช่วงที่3) :</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seDataBack['DATESTART_ACTUAL_P3']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_ACTUAL_4HUR_P3']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_ACTUAL_4HUR_P3']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_ACTUAL_4HUR_P3'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_ACTUAL_2HUR_P3']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_ACTUAL_2HUR_P3']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_ACTUAL_2HUR_P3'].'</b>
            </td>
         </tr>
         <tr>
            <td colspan="60" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ช่วงที่4) :</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seDataBack['DATESTART_ACTUAL_P4']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_ACTUAL_4HUR_P4']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_ACTUAL_4HUR_P4']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_ACTUAL_4HUR_P3'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_ACTUAL_2HUR_P4']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_ACTUAL_2HUR_P4']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_ACTUAL_2HUR_P4'].'</b>
            </td>
            <td colspan="60" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ช่วงที่5) :</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seDataBack['DATESTART_ACTUAL_P5']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_PLAN_ACTUAL_P5']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_PLAN_ACTUAL_P5']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_ACTUAL_4HUR_P5'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_ACTUAL_2HUR_P5']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_ACTUAL_2HUR_P5']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_ACTUAL_2HUR_P5'].'</b>
            </td>
            <td colspan="120" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ชื่อผู้ขับ (ช่วงที่6) :</u></b>
                  <br><br>
                  <b><u>เวลาเริ่มขับ : '.str_replace("T"," ",$result_seDataBack['DATESTART_ACTUAL_P6']).'</u></b>
                  <br><br>
                  <b><u>4 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_ACTUAL_4HUR_P6']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_ACTUAL_4HUR_P6']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_ACTUAL_4HUR_P6'].'</b>
                  <br><br>
                  <b><u>2 ชั่วโมง :</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['PARKINGTIME_ACTUAL_2HUR_P6']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.str_replace("T"," ",$result_seDataBack['DEPARTURETIME_ACTUAL_2HUR_P6']).'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>สถานที่&nbsp;&nbsp;=> '.$result_seDataBack['LOCATION_ACTUAL_2HUR_P6'].'</b>
            </td>
         </tr>
         <tr>
            <td colspan="60" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  <br>
                  <b><u>ปลายทาง/โหลดรถลง</u></b>
                  <br><br>
                  <b><u>สถานที่ : '.$result_seDataBack['DEALER1_ACTUAL'].'</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.$result_seDataBack['PARKINGTIME_ACTUAL_DEALER1'].'</b>
                  <br><br>
                  <b><u>VL : '.$result_seDataBack['DEALER2_ACTUAL'].'</u> </b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาจอด&nbsp;&nbsp;=> '.$result_seDataBack['PARKINGTIME_ACTUAL_DEALER2'].'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>เวลาออก&nbsp;&nbsp;=> '.$result_seDataBack['DEPARTURETIME_ACTUAL_DEALER2'].'</b>
                  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>รวม&nbsp;&nbsp;=> '.$result_seDataBack['SUM_ACTUAL_DEALER2'].'</b>
            </td>
            <td colspan="60" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                  
            </td>
            <td colspan="120" style="border:1px solid #000;padding:2px;text-align;left;font-size: 12px;">
                 
            </td>
         </tr>
       </tbody>';


$table_end_backactual = '
   <tfoot>
      <tr style="border:1px solid #000;" >
         <td colspan="240" style="border-right:1px solid #000;padding:5px;text-align:right;font-size: 12px;background-color: #ccc"></td> 
       </tr>
   </tfoot>
</table>';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



$mpdf->WriteHTML($style);
// แผนขาไป
$mpdf->WriteHTML($table_begin_goplan);
$mpdf->WriteHTML($tr_goplan);
$mpdf->WriteHTML($td_goplan);
$mpdf->WriteHTML($table_end_goplan);

$mpdf->AddPage();

// วิ่งจริงขาไป
$mpdf->WriteHTML($table_begin_goactual);
$mpdf->WriteHTML($tr_goactual);
$mpdf->WriteHTML($td_goactual);
$mpdf->WriteHTML($table_end_goactual);

$mpdf->AddPage();

// แผนขากลับ
$mpdf->WriteHTML($table_begin_backplan);
$mpdf->WriteHTML($tr_backplan);
$mpdf->WriteHTML($td_backplan);
$mpdf->WriteHTML($table_end_backplan);

$mpdf->AddPage();

// วิ่งจริงขากลับ
$mpdf->WriteHTML($table_begin_backactual);
$mpdf->WriteHTML($tr_backactual);
$mpdf->WriteHTML($td_backactual);
$mpdf->WriteHTML($table_end_backactual);

$mpdf->Output();

sqlsrv_close($conn);
?>

