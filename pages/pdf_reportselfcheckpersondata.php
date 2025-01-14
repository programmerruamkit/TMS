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

// $sql_seDep = "SELECT DISTINCT b.DEPARTMENTNAME FROM [dbo].[ORGANIZATION] a
//       INNER JOIN [dbo].[DEPARTMENT_NEW] b ON a.DEPARTMENTCODE = b.DEPARTMENTCODE
//       WHERE a.EMPLOYEECODE = '" . $result_seEHR['PersonCode'] . "'";
// $params_seDep = array(
//     array('', SQLSRV_PARAM_IN),
//     array('', SQLSRV_PARAM_IN)
// );
// $query_seDep = sqlsrv_query($conn, $sql_seDep, $params_seDep);
// $result_seDep = sqlsrv_fetch_array($query_seDep, SQLSRV_FETCH_ASSOC);

// $sql_seGetdate = "SELECT '01/" . $_GET['datestart'] . "' AS 'datestart',
//                     CONVERT(VARCHAR, (SELECT DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,CONVERT(DATE,'01/" . $_GET['datestart'] . "',103))+1,0))), 103) AS 'dateend'";

// $query_seGetdate = sqlsrv_query($conn, $sql_seGetdate, $params_seGetdate);
// $result_seGetdate = sqlsrv_fetch_array($query_seGetdate, SQLSRV_FETCH_ASSOC);

$date = date_create($_GET['months']); 
$strDate =  date_format($date,"Y/d/m");

$stryear =  date_format($date,"Y");
$strmonthchk =  substr($_GET['months'],3,2);

function DateThai($strDate)
{
$strMonth= date("n",strtotime($strDate));
$strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$strMonthThai=$strMonthCut[$strMonth];
return "$strMonthThai";
}


$empchk = substr($_GET['employeecode'],0,2);

if ($empchk == '01' || $empchk == '02' || $empchk == '07' || $empchk == '10') {
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

// $sql_sethainame = "SELECT THAINAME  AS 'THAINAME'
//          FROM [dbo].[VEHICLETRANSPORTPLAN]
//          WHERE CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'" . $result_seGetdate['datestart'] . "',103) AND CONVERT(DATE,'" . $result_seGetdate['dateend'] . "',103)
//          AND (EMPLOYEECODE1 = '" . $_GET['employeecode'] . "' OR EMPLOYEECODE2 = '" . $_GET['employeecode'] . "')
//          AND (VEHICLETRANSPORTPRICEID IS NOT NULL AND VEHICLETRANSPORTPRICEID != '')
//          AND (JOBSTART IS NOT NULL AND JOBSTART != '')
//          AND (DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !='')ORDER BY DATEDEALERIN ASC";

// $query_sethainame = sqlsrv_query($conn, $sql_sethainame, $params_sethainame);
// $result_sethainame = sqlsrv_fetch_array($query_sethainame, SQLSRV_FETCH_ASSOC);



// $mpdf = new mPDF('th', 'A4-L', '0', '');
$mpdf = new mPDF('th', 'A3-L', '0', '', 5, 5, 5, 5, 5, 5);
// $mpdf = new mPDF('th', 'A4-L', '0', '', ซ้าย, บน, ล่าง, 5, 5, 5);
$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';

$table_begin = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;">';

    $trrkl = '<thead>
     <tr style="border:1px solid #000;" >
            <td colspan="20" style="padding:3px;text-align:left;">
                <img src="../images/logonew.png">
            </td>
            <td colspan="181" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 30px;">
                <b>ใบแจ้งสุขภาพตนเอง</b>
            </td>
       </tr>

      <tr style="border:1px solid #000;" >
            <td colspan="201" style="border-right:1px solid #000;padding:3px;text-align;left;font-size: 12px;">
                <b>สรุปข้อมูลใบแจ้งสุขภาพตนเอง</b>
            </td>
       </tr>
       
       <tr style="border:1px solid #000;" >
         <td colspan="139" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
                รหัส : ' . $result_seEHR['PersonCode'] . ' | ชื่อ : ' . $result_seEHR['FnameT'] . ' ' . $result_seEHR['LnameT'] . '  |  ตำแหน่ง : ' . $result_seEHR['PositionNameT'] . ' |  
         </td>
         <td colspan="62" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
                <b>เดือน/ปี : ' . DateThai($strDate) . ' '.$stryear .'</b>
         </td>   
       </tr>
       
       <tr style="border:1px solid #000;background-color: #ccc" >
           <td rowspan="2"  colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ลำดับ</b>
            </td>
            <td rowspan="2" colspan="16" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>วันที่
               <br>เวลาเริ่มงาน</b>
            </td>
            <td  colspan="10" style="border-right:1px solid #000;padding:3px;text-align:left;">
               <b>
               หัวข้อตรวจสอบสภาวะความพร้อม
               <br>1.มีอาการเหนื่อยล้า
               <br>2.มีอาการเจ็บป่วย
               <br>3.มีอาการง่วงนอน
               <br>4.มีอาการเจ็บหรือทนต่อการเจ็บปวด
               <br>5.ทานยาที่ส่งผลต่อการขับขี่
               </b>
            </td>
            <td rowspan="2" colspan="10" style="border-right:1px solid #000;padding:3px;text-align:center;font-size:11px;">
               <b>
               1
               <br>สภาพ
               <br>ร่างกาย
               </b>
            </td>
              <td rowspan="2" colspan="8" style="border-right:1px solid #000;padding:3px;text-align:center;font-size:11px;">
               <b>
               2
               <br>การนอนปกติ               
               </b>
            </td>
            <td rowspan="2" colspan="12" style="border-right:1px solid #000;padding:3px;text-align:left;font-size:11px;">
               <b>
               การนอนเพิ่มของ
               <br>การรับงานวันแรก
               <br>ของกะกลางคืน
               <br>ในทุกๆสัปดาห์
               </b>
            </td>
            <td rowspan="2" colspan="16"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>
               3
               <br>อาการป่วย
               </b>
            </td>
            <td rowspan="2" colspan="6"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>
               4
               <br>เรื่องกังวลใจ
               </b>
            </td>
            <td rowspan="2" colspan="5"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>
               5
               <br>การใช้ช่วงเวลาพักผ่อน
               </b>
            </td>
            <td rowspan="2" colspan="14" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>
               6
               <br>ปัญหาด้านสายตา และการได้ยิน
               </b>
            </td>
            
            <td rowspan="2" colspan="12" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ลงชื่อ<br>พนักงาน</b>
            </td>
            <td rowspan="2" colspan="6" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>
               อุณหภูมิ
               <br> องศาเซลเซียส
               </b>
            </td>
            <td colspan="8"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>
               8
               <br>ความดัน
               </b>
            </td>
             <td colspan="14"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>
               9
               <br>แอลกอฮอล์
               </b>
            </td>
            <td rowspan="2" colspan="30"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ลงชื่อ<br>ผู้ควบคุม</b>
            </td>
             <td rowspan="2"  colspan="16" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 10px;">
               <b>
               วันที่
               <br>เวลาเลิกงาน</b>
            </td>
             <td rowspan="2"  colspan="16" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>หมายเหตุ</b>
            </td> 
       </tr>

      

      <tr style="border:1px solid #000;background-color: #ccc" >
         <td  colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>1</b>
         </td>
         <td  colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>2</b>
         </td>
         <td  colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>3</b>
         </td>
         <td  colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>4</b>
         </td>
         <td  colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>5</b>
         </td>
         <td  colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 8px;">
            <b>ค่า<br>บน</b>
         </td>
         <td  colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 8px;">
            <b>ค่า<br>ล่าง</b>
         </td>
         <td colspan="6" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 8px;">
            <b>ประเภท</b>
         </td>
         <td colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 8px;">
            <b>เวลา</b>
         </td>
         <td colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 8px;">
            <b>ปริมาณ</b>
         </td>
      </tr>
    </thead>';


$i = 1;


      $sql_seComp = "SELECT * FROM DRIVERSELFCHECK 
      WHERE EMPLOYEECODE ='".$_GET['employeecode']."'
      AND SUBSTRING(DATEWORKING, 4, 2) ='".$strmonthchk."'
      AND SUBSTRING(DATEWORKING,  7, 7) ='".$stryear."'
      AND (CONFIRMEDBY IS NOT NULL OR CONFIRMEDBY != '')
      ORDER BY DATEWORKING ASC";
      $query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
      while ($result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC)) {

      // $sql_seChkdoc = "SELECT [DOCUMENTCODE] FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] WHERE VEHICLETRANSPORTPLANID = '" . $result_seComp['VEHICLETRANSPORTPLANID'] . "'";
      // $query_seChkdoc = sqlsrv_query($conn, $sql_seChkdoc, $params_seChkdoc);
      // $result_seChkdoc = sqlsrv_fetch_array($query_seChkdoc, SQLSRV_FETCH_ASSOC);
      
            // เวลาเริ่มปฎิบัติงาน  
            // เวลาวางกุญแจสำหรับพขรเช็ค ต้องน้อยกว่าไอดีอันเดิม และเป็นเวลาแรกสุด
            // $sql_seKeyDropTime = "SELECT TOP 1 SELFCHECKID,KEYDROPTIME,EMPLOYEECODE 
            //       FROM DRIVERSELFCHECK 
            //       WHERE  EMPLOYEECODE ='".$_GET['employeecode']."' AND SELFCHECKID < '".$result_seComp['SELFCHECKID']."'
            //       ORDER BY SELFCHECKID DESC";
            // $params_seKeyDropTime = array();
            // $query_seKeyDropTime = sqlsrv_query($conn, $sql_seKeyDropTime, $params_seKeyDropTime);
            // $result_seKeyDropTime = sqlsrv_fetch_array($query_seKeyDropTime, SQLSRV_FETCH_ASSOC);

            $sql_seKeyDropTime = "SELECT TOP 1 SELFCHECKID,SLEEPRESTEND,EMPLOYEECODE 
                  FROM DRIVERSELFCHECK 
                  WHERE  EMPLOYEECODE ='".$_GET['employeecode']."' AND SELFCHECKID = '".$result_seComp['SELFCHECKID']."'
                  ORDER BY SELFCHECKID DESC";
            $query_seKeyDropTime = sqlsrv_query($conn, $sql_seKeyDropTime, $params_seKeyDropTime);
            $result_seKeyDropTime = sqlsrv_fetch_array($query_seKeyDropTime, SQLSRV_FETCH_ASSOC);


            if ($result_seKeyDropTime['SLEEPRESTEND'] != '') {
               $startworkchk = date_create($result_seKeyDropTime['SLEEPRESTEND']);
               $startwork =  date_format($startworkchk,"d/m/Y H:i");
            }else{
               $startwork = '';
            }


            //มีอาการเหนื่อยล้า
            if ($result_seComp['TIREDYESCHK'] == '1') {
               $tiredyyes = "background-color: #ccc";
            }else{
               $tiredyyes = " ";
            }

            if ($result_seComp['TIREDNOCHK'] == '1') {
               $tiredyno = "background-color: #ccc";
            }else{
               $tiredyno = " ";
            }
            ///////////////////////////////////////////
            
            // มีอาการเจ็บป่วย
            if ($result_seComp['ILLNESSYESCHK'] == '1') {
               $illnessyes = "background-color: #ccc";
            } else {
               $illnessyes = " ";
            }

            if ($result_seComp['ILLNESSNOCHK'] == '1') {
               $illnessno = "background-color: #ccc";
            } else {
               $illnessno  = " ";
            }
            ///////////////////////////////////////////

            // มีอาการง่วงนอน
            if ($result_seComp['DROWSEYESCHK'] == '1') {
               $drowseyes = "background-color: #ccc";
            } else {
               $drowseyes = " ";
            }

            if ($result_seComp['DROWSENOCHK'] == '1') {
               $drowseno = "background-color: #ccc";
            } else {
               $drowseno = " ";
            }
             ///////////////////////////////////////////

            // มีอาการบาดเจ็บหรือทนต่อการบาดเจ็บ
            if ($result_seComp['INJURYYESCHK'] == '1') {
               $injuryyes = "background-color: #ccc";
            } else {
               $injuryyes = " ";
            }

            if ($result_seComp['INJURYNOCHK'] == '1') {
               $injuryno = "background-color: #ccc";
            } else {
               $injuryno = " ";
            }
            ///////////////////////////////////////////

            // มีการทานยาที่ส่งผลต่อการขับขี่
            if ($result_seComp['TAKEMEDICINEYESCHK'] == '1') {
               $takemedicineyes = "background-color: #ccc";
            } else {
               $takemedicineyes = " ";
            }

            if ($result_seComp['TAKEMEDICINENOCHK'] == '1') {
               $takemedicineno = "background-color: #ccc";
            } else {
               $takemedicineno = " ";
            }
            /////////////////////////////////////////////

            // 1.สภาพร่างกาย
            if ($result_seComp['HEALTHYYESCHK'] == '1') {
               $healthyyes = "background-color: #ccc";
            } else {
               $healthyyes = " ";
            }
            
            if ($result_seComp['HEALTHYNOCHK'] == '1') {
               $healthyno = "background-color: #ccc";
            } else {
               $healthyno = " ";
            }
            /////////////////////////////////////////

            // เวลานอนปกติ
            // $sleepnormalstart = $result_seChkdoc['TIMESLEEPNORMAL'];
            if ($result_seComp['SLEEPNORMALSTART'] != '') {
               $sleepnormalstartchk = date_create($result_seComp['SLEEPNORMALSTART']);
               $sleepnormalstart =  date_format($sleepnormalstartchk,"d/m/Y H:i");
            }else{
               $sleepnormalstart = '-';
            }

            if ($result_seComp['SLEEPNORMALEND'] != '') {
               $sleepnormalendchk = date_create($result_seComp['SLEEPNORMALEND']);
               $sleepnormalend = date_format($sleepnormalendchk,"d/m/Y H:i");
            }else{
               $sleepnormalend = '-';
            }

            $timesleepnormal = $result_seComp['TIMESLEEPNORMAL'];

            //ประเมิน(การนอนปกติ)
            if ($result_seComp['SLEEPNORMALYES'] == '1') {
               $sleepnormalyes = "background-color: #ccc";
            } else {
               $sleepnormalyes = " ";
            }

            if ($result_seComp['SLEEPNORMALNO'] == '1') {
               $sleepnormalno = "background-color: #ccc";
            } else {
               $sleepnormalno = " ";
            }
            //////////////////////////////////////////

            // การนอนเพิ่ม ของการรับงานวันแรกของกะกลางคืนในทุกๆสัปดาห์
            if ($result_seComp['SLEEPEXTRASTART'] != '') {
               $sleepextrastartchk = date_create($result_seComp['SLEEPEXTRASTART']);
               $sleepextrastart =  date_format($sleepextrastartchk,"d/m/Y H:i");
            }else{
               $sleepextrastart = '-';
            }

            if ($result_seComp['SLEEPEXTRAEND'] != '') {
               $sleepextraendchk = date_create($result_seComp['SLEEPEXTRAEND']);
               $sleepextraend = date_format($sleepextraendchk,"d/m/Y H:i");
            }else{
               $sleepextraend = '-';
            }
            

            $timesleepextra = $result_seComp['TIMESLEEPEXTRA'];

            //ประเมิน(การนอนเพิ่ม)
            // หลับสนิท
            if ($result_seComp['SLEEPEXTRAYES'] == '1') {
               $sleepextrayes = "background-color: #ccc";
            } else {
               $sleepextrayes = " ";
            }
            // หลับไม่สนิท
            if ($result_seComp['SLEEPEXTRANO'] == '1') {
               $sleepextrano = "background-color: #ccc";
            } else {
               $sleepextrano = " ";
            }



            // ชื่อโรค
            $disease = $result_seComp['DISEASE'];

            // พบหมอ
            if ($result_seComp['SEEDOCTORYES'] == '1') {
               $seedoctor = "พบ";
               $seedoctorcolor = "background-color: #ccc";
            } else {
               $seedoctor = "ไม่พบ";
               $seedoctorcolor = "background-color: #ccc";
            }

            // ชื่อยา
            $drugname = $result_seComp['DRUGNAME'];

            // ทานยาเมื่อไหร่
            if ($result_seComp['DRUGTIME'] != '') {
               $drugtimechk = date_create($result_seComp['DRUGTIME']);
               $drugtime =  date_format($drugtimechk,"d/m/Y H:i");
            }else{
               $drugtime = '-';
            }
            
            // เรื่องกังวลใจ
            if ($result_seComp['WORRYYES'] == '1') {
               $worryyes = "background-color: #ccc";
            } else {
               $worryyes = " ";
            }

            if ($result_seComp['WORRYNO'] == '1') {
               $worryno = "background-color: #ccc";
            } else {
               $worryno = " ";
            }

            ////////////////////////////////////////////
            //  การใช้เวลาช่วงพักผ่อน บ้าน/นอกบ้าน
            if ($result_seComp['HOUSEHOLDYES'] == '1') {
               $householdyes = "background-color: #ccc";
            } else {
               $householdyes = " ";
            }

            //  การใช้เวลาช่วงพักผ่อน บ้าน/นอกบ้าน
            if ($result_seComp['HOUSEHOLDNO'] == '1') {
               $householdno = "background-color: #ccc";
            } else {
               $householdno = " ";
            }


            ///////////////////////////////////////////
            //  ปัญหาสายตา
            if ($result_seComp['EYEPROBLEMYES'] == '1') {
               $eyeproblemyes = "background-color: #ccc";
            } else {
               $eyeproblemyes = " ";
            }

            if ($result_seComp['EYEPROBLEMNO'] == '1') {
               $eyeproblemno = "background-color: #ccc";
            } else {
               $eyeproblemno = " ";
            }
            ////////////////////////////////////////////

            //  สวมแว่นสายตา
            if ($result_seComp['EYEGLASSESYES'] == '1') {
               $carryeyeglassesyes = "background-color: #ccc";
            } else {
               $carryeyeglassesyes = " ";
            }

            if ($result_seComp['EYEGLASSESNO'] == '1') {
               $carryeyeglassesno = "background-color: #ccc";
            } else {
               $carryeyeglassesno = " ";
            }
            /////////////////////////////////////////////////

            //  สวมเครื่องช่วยฟัง
            if ($result_seComp['CARRYHEARINGAIDYES'] == '1') {
               $carryhearingaidyes = "background-color: #ccc";
            } else {
               $carryhearingaidyes = " ";
            }

            if ($result_seComp['CARRYHEARINGAIDNO'] == '1') {
               $carryhearingaidno = "background-color: #ccc";
            } else {
               $carryhearingaidno = " ";
            }
            /////////////////////////////////////////////////

            // อุณภูมิ
            $temp = $result_seComp['TEMPERATURE'];

            // ความดันบน-ความดันล่าง
            // $sys = $result_seComp['SYSVALUE1'];
            // $dia = $result_seComp['DIAVALUE1'];

            // ความดันบน
            if($result_seComp['SYSVALUE1'] > $result_seTenkoSTD['MAXSYS']           || $result_seComp['SYSVALUE1'] < $result_seTenkoSTD['MINSYS']){
               if ($result_seComp['SYSVALUE2'] > $result_seTenkoSTD['MAXSYS']       || $result_seComp['SYSVALUE2'] < $result_seTenkoSTD['MINSYS']) {
                   if ($result_seComp['SYSVALUE3'] > $result_seTenkoSTD['MAXSYS']   || $result_seComp['SYSVALUE3'] < $result_seTenkoSTD['MINSYS']) {
                       $sys = '-'; // ความดันบนครั้งที่ 3 เกิน
                   }else {
                       $sys = $result_seComp['SYSVALUE3'] ;      
                   }
               }else {
                       $sys = $result_seComp['SYSVALUE2'] ; 
               }
            }else{  
                       $sys = $result_seComp['SYSVALUE1'];     
            }

            // ความดันล่าง
            if($result_seComp['DIAVALUE1'] > $result_seTenkoSTD['MAXDIA']           || $result_seComp['DIAVALUE1'] < $result_seTenkoSTD['MINDIA']){
               if ($result_seComp['DIAVALUE2'] > $result_seTenkoSTD['MAXDIA']       || $result_seComp['DIAVALUE2'] < $result_seTenkoSTD['MINDIA']) {
                   if ($result_seComp['DIAVALUE3'] > $result_seTenkoSTD['MAXDIA']   || $result_seComp['DIAVALUE3'] < $result_seTenkoSTD['MINDIA']) {
                       $dia = '-'; // ความดันบนครั้งที่ 3 เกิน
                   }else {
                       $dia = $result_seComp['DIAVALUE3'] ;      
                   }
               }else {
                       $dia = $result_seComp['DIAVALUE2'] ; 
               }
            }else{  
                       $dia = $result_seComp['DIAVALUE1'];     
            }

            //แอลกอฮอล์
            $alcoholtype = $result_seComp['ALCOHOLTYPE'];
            if ($result_seComp['ALCOHOLTIME'] != '') {
               $alcoholtime = $result_seComp['ALCOHOLTIME'];
            }else {
               $alcoholtime = '-';
            }
            $alcoholvalume = $result_seComp['ALCOHOLVOLUME'];

            ///////////////////////////////////////////////////////////////////////

            // ชื่อผู้ควบคุม
            $sql_seconfirmbyFname = "SELECT TOP 1 VALUE  AS 'Fname' FROM STRING_SPLIT('".$result_seComp['CONFIRMEDBY']."', ' ')";
            $params_seconfirmbyFname = array();
            $query_seconfirmbyFname  = sqlsrv_query($conn, $sql_seconfirmbyFname, $params_seconfirmbyFname);
            $result_seconfirmbyFname = sqlsrv_fetch_array($query_seconfirmbyFname, SQLSRV_FETCH_ASSOC);  
         
            // ลงชื่อผู้ควบคุม
            $sql_seconfirmbyLname = "SELECT SUBSTRING( '".$result_seComp['CONFIRMEDBY']."' , LEN('".$result_seComp['CONFIRMEDBY']."') -  CHARINDEX(' ',REVERSE('".$result_seComp['CONFIRMEDBY']."')) + 2  , LEN('".$result_seComp['CONFIRMEDBY']."')  )  AS 'Lname'";
            $params_seconfirmbyLname = array();
            $query_seconfirmbyLname  = sqlsrv_query($conn, $sql_seconfirmbyLname, $params_seconfirmbyLname);
            $result_seconfirmbyLname = sqlsrv_fetch_array($query_seconfirmbyLname, SQLSRV_FETCH_ASSOC);  
         

            // $confirmby = $result_seComp['CONFIRMEDBY'];
               // // เลขไมค์ต้น

            // วันที่เลิกงาน
            if ($result_seComp['KEYDROPTIME'] != '') {
               $keydroptimechk = date_create($result_seComp['KEYDROPTIME']);
               $keydroptime_date = date_format($keydroptimechk,"d/m/Y");
               $keydroptime_minute = date_format($keydroptimechk,"H:i");
            }else{
               $keydroptime_date = '';
               $keydroptime_minute = '';
            }


            // $sql_seMileagestart = "SELECT TOP 1 MILEAGENUMBER FROM [dbo].[MILEAGE] 
            //                      WHERE MILEAGETYPE = 'MILEAGESTART' AND JOBNO = '" . $result_seComp['JOBNO'] . "' 
            //                      AND CONVERT(NVARCHAR,CREATEDATE,120) = (SELECT TOP 1 CONVERT(NVARCHAR,CREATEDATE,120) 
            //                      FROM [dbo].[MILEAGE] WHERE MILEAGETYPE = 'MILEAGESTART' 
            //                      AND JOBNO = '" . $result_seComp['JOBNO'] . "' 
            //                      ORDER BY CREATEDATE DESC) ORDER BY CREATEDATE DESC";
            // $query_seMileagestart = sqlsrv_query($conn, $sql_seMileagestart, $params_seMileagestart);
            // $result_seMileagestart = sqlsrv_fetch_array($query_seMileagestart, SQLSRV_FETCH_ASSOC);

         



      $td .= '<tr style="border:1px solid #000;" >
      <td  rowspan = "3" colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">'.$i.'</td>
      <td  rowspan = "3" colspan="16" style="border-right:1px solid #000;padding:3px;text-align:left;">'.$startwork.'</td>
      <td  colspan="183" height="15"  style="border-right:1px solid #000;padding:3px;text-align:left;"></td>  
      <tr style="border:1px solid #000;background-color: white" >
         <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;'.$tiredyyes.'">
            <b>มี</b>
         </td>
         <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;'.$illnessyes.'">
            <b>มี</b>
         </td>
         <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;'.$drowseyes.'">
            <b>มี</b>
         </td>
         <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;'.$injuryyes.'">
            <b>มี</b>
         </td>
          <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;'.$takemedicineyes.'">
            <b>มี</b>
         </td>
         <td  colspan="10" style="border-right:1px solid #000;padding:3px;text-align:center;'.$healthyyes.'">
            <b>ปกติ</b>
         </td>
         
         <td  colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>
            '.$sleepnormalstart.'
            <br>'.$sleepnormalend.'
            </b>
         </td>
         <td colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;'.$sleepnormalyes.'">
            <b>หลับสนิท</b>
         </td>
         <td  colspan="6" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 9px;">
            <b>
            '.$sleepextrastart.'
            <br> '.$sleepextraend.'
            </b>
         </td>
         <td colspan="6" style="border-right:1px solid #000;padding:3px;text-align:center;'.$sleepextrayes.'">
            <b>หลับสนิท</b>
         </td>
          <td colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>ชื่อโรค</b>
         </td>
         <td colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>พบหมอ</b>
         </td>
         <td colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>ชื่อยา</b>
         </td>
         <td colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 7px;">
            <b>ทานยา<br>เมื่อไหร่</b>
         </td>
         <td colspan="6" style="border-right:1px solid #000;padding:3px;text-align:center;'.$worryyes.'">
            <b>มี</b>
         </td>
         <td colspan="5" style="border-right:1px solid #000;padding:3px;text-align:center;'.$householdyes.'">
            <b>บ้าน</b>
         </td>
          <td colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>ปัญหา</b>
         </td>
         <td colspan="5" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>แว่นตา</b>
         </td>
         <td colspan="5" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 8px;">
            <b>เครื่องช่วยฟัง</b>
         </td>
         <td rowspan="2" colspan="12" style="border-right:1px solid #000;padding:3px;text-align:left;">
            <b>
            '.$result_seEHR['FnameT'].'
            <br>'.$result_seEHR['LnameT'].'
            </b>
         </td>
          <td rowspan="2" colspan="6" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>'.$temp.'</b>
         </td>
         <td rowspan="2" colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>'.$sys.'</b>
         </td>
          <td rowspan="2" colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>'.$dia.'</b>
         </td>
         <td rowspan="2" colspan="6" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>'.$alcoholtype.'</b>
         </td>
          <td rowspan="2" colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>'.$alcoholtime.'</b>
         </td>
         <td rowspan="2" colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>'.$alcoholvalume.'</b>
         </td>
         <td rowspan="2" colspan="30" style="border-right:1px solid #000;padding:3px;text-align:left;">
            <b>'. $result_seconfirmbyFname['Fname'] .'
            <br>'. $result_seconfirmbyLname['Lname'] .' </b>
         </td>
         <td rowspan="2" colspan="16" style="border-right:1px solid #000;padding:3px;text-align:left;">
            <b>'.$keydroptime_date.'
            <br>'.$keydroptime_minute.'</b>
         </td>
         <td rowspan="2" colspan="16" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b></b>
         </td>
      </tr>
      <tr style="border:1px solid #000;background-color: white" >
         <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;'.$tiredyno.'">
            <b>ไม่มี</b>
         </td>
         <td colspan = "2"   style="border-right:1px solid #000;padding:3px;text-align:center;'.$illnessno.'">
            <b>ไม่มี</b>
         </td>
         <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;'.$drowseno.'">
            <b>ไม่มี</b>
         </td>
         <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;'.$injuryno.'">
            <b>ไม่มี</b>
         </td>
          <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;'.$takemedicineno.'">
            <b>ไม่มี</b>
         </td>
         <td  colspan="10" style="border-right:1px solid #000;padding:3px;text-align:center;'.$healthyno.'">
            <b>ไม่ปกติ</b>
         </td>
         <td  colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>('.$timesleepnormal.')ชม</b>
         </td>
         <td colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;'.$sleepnormalno.'">
            <b>หลับไม่สนิท</b>
         </td>
         <td colspan="6" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>('.$timesleepextra.')ชม</b>
         </td>
          <td colspan="6" style="border-right:1px solid #000;padding:3px;text-align:center;'.$sleepextrano.'">
            <b>หลับไม่สนิท</b>
         </td>
         <td colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>'.$disease.'</b>
         </td>
         <td colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;'.$seedoctorcolor.'">
            <b>'.$seedoctor.'</b>
         </td>
          <td colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>'.$drugname.'</b>
         </td>
         <td colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>'.$drugtime.'</b>
         </td>
         <td colspan="6" style="border-right:1px solid #000;padding:3px;text-align:center;'.$worryno.'">
            <b>ไม่มี</b>
         </td>
          <td colspan="5" style="border-right:1px solid #000;padding:3px;text-align:center;'.$householdno.'">
            <b>นอกบ้าน</b>
         </td>
         <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;'.$eyeproblemyes.'">
            <b>มี</b>
         </td>
         <td colspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;'.$eyeproblemno.'">
            <b>ไม่มี</b>
         </td>
         <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;'.$carryeyeglassesyes.'">
            <b>ใส่</b>
         </td>
         <td colspan="3" style="border-right:1px solid #000;padding:3px;text-align:center;'.$carryeyeglassesno.'">
            <b>ไม่ใส่</b>
         </td>
         <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;'.$carryhearingaidyes.'">
            <b>ใส่</b>
         </td>
         <td colspan="3" style="border-right:1px solid #000;padding:3px;text-align:center;'.$carryhearingaidno.'">
            <b>ไม่ใส่</b>
         </td>
      </tr> 
      
   </tr>';



         // $rsmileagestart = $rsmileagestart + $result_seMileagestart['MILEAGENUMBER'];
         // $rsmileageend = $rsmileageend + $result_seMileageend['MILEAGENUMBER'];
         // $rsmileagestartend = $rsmileagestartend + ($result_seMileageend['MILEAGENUMBER'] - $result_seMileagestart['MILEAGENUMBER']);
         // $rscompo4 = $rscompo4 + $result_seComp['O4'];
         // $rscompensation = $rscompensation + $COMPENSATION;
         // $rscompensationemply = $rscompensationemply + $COMPENSATIONEMPLY;
         // $rspayrepair = $rspayrepair + $result_seCompensation1['PAY_REPAIR'];
         // $rspayother = $rspayother + ($result_seCompensation1['PAY_OTHER']+$result_seCompensation1['OTHER']);
         // $rspallet = $rspallet + $result_sePallet['PALLET'];
         // $resmoney = number_format(($result_seCompoilaverage51['CNT'] / $result_seCompoilaverage6['CNT']) - (($result_seCompoilaverage52['CNT'] / $result_seCompoilaverage6['CNT']) * -1));
         // $allmoney = $allmoney + $resmoney;
         $i++;


}

$table_end = '</tbody>
   <tfoot>
      <tr style="border:1px solid #000;" >
         <td colspan="201" height="15" style="border-right:1px solid #000;padding:3px;text-align:right;"><b></b></td>
      </tr>
   </tfoot>
</table>';

$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_begin);

$mpdf->WriteHTML($trrkl);

$mpdf->WriteHTML($td);
$mpdf->WriteHTML($table_end);

$mpdf->Output();

sqlsrv_close($conn);
?>

