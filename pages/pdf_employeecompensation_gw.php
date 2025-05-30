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

$sql_seDep = "SELECT DISTINCT b.DEPARTMENTNAME FROM [dbo].[ORGANIZATION] a
      INNER JOIN [dbo].[DEPARTMENT_NEW] b ON a.DEPARTMENTCODE = b.DEPARTMENTCODE
      WHERE a.EMPLOYEECODE = '" . $result_seEHR['PersonCode'] . "'";
$params_seDep = array(
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seDep = sqlsrv_query($conn, $sql_seDep, $params_seDep);
$result_seDep = sqlsrv_fetch_array($query_seDep, SQLSRV_FETCH_ASSOC);


// หาวันที่สิ้นสุดจากวันเริ่มต้น ตามเดือนที่เลือกมา
// $sql_seGetdate = "SELECT '01/" . $_GET['datestart'] . "' AS 'datestart',
//                     CONVERT(VARCHAR, (SELECT DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,CONVERT(DATE,'01/" . $_GET['datestart'] . "',103))+1,0))), 103) AS 'dateend'";

// $query_seGetdate = sqlsrv_query($conn, $sql_seGetdate, $params_seGetdate);
// $result_seGetdate = sqlsrv_fetch_array($query_seGetdate, SQLSRV_FETCH_ASSOC);



$sql_sethainame = "SELECT THAINAME  AS 'THAINAME'
         FROM [dbo].[VEHICLETRANSPORTPLAN]
         WHERE CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'" .  $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)
         AND (EMPLOYEECODE1 = '" . $_GET['employeecode'] . "' OR EMPLOYEECODE2 = '" . $_GET['employeecode'] . "')
         AND (VEHICLETRANSPORTPRICEID IS NOT NULL AND VEHICLETRANSPORTPRICEID != '')
         AND (JOBSTART IS NOT NULL AND JOBSTART != '')
         AND (DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !='')ORDER BY DATEDEALERIN ASC";

$query_sethainame = sqlsrv_query($conn, $sql_sethainame, $params_sethainame);
$result_sethainame = sqlsrv_fetch_array($query_sethainame, SQLSRV_FETCH_ASSOC);



// $mpdf = new mPDF('th', 'A4-L', '0', '');
$mpdf = new mPDF('th', 'A4-L', '0', '', 5, 5, 5, 5, 5, 5);
// $mpdf = new mPDF('th', 'A4-L', '0', '', ซ้าย, บน, ล่าง, 5, 5, 5);
$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';

$table_begin = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;">';
if (substr($_GET['employeecode'], 0, 2) == '09') {
    $trratc = '<thead>
     <tr style="border:1px solid #000;" >
            <td style="padding:3px;text-align:left;">
                <img src="../images/logonew.png">
            </td>
            <td colspan="21" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 15px;">
                <b>บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต  จำกัด (Ruamkit  Automotive Transport Co., Ltd.)</b>
                <br>

                 เลขที่ 109/1 หมู่ที่ 9 ตำบลหัวสำโรง อำเภอแปลงยาว จังหวัดฉะเชิงเทรา
            </td>
       </tr>
       <tr style="border:1px solid #000;" >
         <td colspan="17" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 12px;">
            <b>ค่าเบี้ยเลี้ยงและค่าอาหารการทำงานนอกสถานที่</b>
         </td>
         <td colspan="5" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
            <b>ทะเบียนรถ ' .$result_sethainame['THAINAME'] . '</b>
         </td>
      </tr>
       
      <tr style="border:1px solid #000;" >
         <td colspan="14" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
               รหัส : ' . $result_seEHR['PersonCode'] . ' | ชื่อ : ' . $result_seEHR['FnameT'] . ' ' . $result_seEHR['LnameT'] . '  |  สายงาน : ' . $result_seDep['DEPARTMENTNAME'] . ' | 
         </td>
         <td colspan="8" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
               <b>เดือน/ปี : ' . $_GET['datestart'] . '</b>
         </td>   
      </tr>   
       
   <tr style="border:1px solid #000;background-color: #ccc" >
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ลำดับ</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>วันที่</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>จากบริษัท</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ถึงบริษัท(ROUTE)</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ทะเบียนรถ</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>กิโลเมตร <br>ที่เริ่มไป</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>กิโลเมตร <br>ที่กลับถึง</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>รวมระยะทาง</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>จำนวน <br> ลิตร</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ค่าเฉลี่ยน้ำมัน</b>
      </td>
      <td colspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ค่าน้ำมัน</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ยอดที่<br>จ่ายจริง</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>จำนวนพาเลท</be></b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ค่าตีเปล่า</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ค่า<br>ซ่อม</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ค่า<br>อื่นๆ</b>
      </td>
     
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ค่าเที่ยว</b>
      </td>
      <td colspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ผู้อนุมัติ</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>หมาย <br>เหตุ</b>
      </td> 
   </tr>
  
      <tr style="border:1px solid #000;background-color: #ccc" >
       <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินบวก</b>
            </td>
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินลบ</b>
            </td>
      <td style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>Tenko</b>
                
            </td>
             <td style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>สายงาน</b>
                
            </td>
            
      </tr>
    </thead>';
}
if (substr($_GET['employeecode'], 0, 2) == '04') {
    $trrcc = '<thead>
     <tr style="border:1px solid #000;" >
            <td style="padding:3px;text-align:left;">
                <img src="../images/logonew.png">
            </td>
            <td colspan="21" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์  จำกัด (Ruamkit Rungrueng Car Carrier Co., Ltd.)</b>
                <br>

                 เลขที่ 109/1 หมู่ที่ 9 ตำบลหัวสำโรง อำเภอแปลงยาว จังหวัดฉะเชิงเทรา
            </td>
       </tr>

       <tr style="border:1px solid #000;" >
         <td colspan="17" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 12px;">
            <b>ค่าเบี้ยเลี้ยงและค่าอาหารการทำงานนอกสถานที่</b>
         </td>
         <td colspan="5" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
            <b>ทะเบียนรถ ' .$result_sethainame['THAINAME'] . '</b>
         </td>
      </tr>
         
      <tr style="border:1px solid #000;" >
         <td colspan="14" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
               รหัส : ' . $result_seEHR['PersonCode'] . ' | ชื่อ : ' . $result_seEHR['FnameT'] . ' ' . $result_seEHR['LnameT'] . '  |  สายงาน : ' . $result_seDep['DEPARTMENTNAME'] . ' | 
         </td>
         <td colspan="8" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
               <b>เดือน/ปี : ' . $_GET['datestart'] . '</b>
         </td>   
      </tr>
       
   <tr style="border:1px solid #000;background-color: #ccc" >
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ลำดับ</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>วันที่</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>จากบริษัท</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ถึงบริษัท(ROUTE)</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ทะเบียนรถ</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>กิโลเมตร <br>ที่เริ่มไป</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>กิโลเมตร <br>ที่กลับถึง</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>รวมระยะทาง</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>จำนวน <br> ลิตร</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ค่าเฉลี่ยน้ำมัน</b>
      </td>
      <td colspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ค่าน้ำมัน</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ยอดที่<br>จ่ายจริง</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>จำนวนพาเลท</be></b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ค่าตีเปล่า</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ค่า<br>ซ่อม</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ค่า<br>อื่นๆ</b>
      </td>
     
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ค่าเที่ยว</b>
      </td>
      <td colspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ผู้อนุมัติ</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>หมาย <br>เหตุ</b>
      </td> 
   </tr>

   <tr style="border:1px solid #000;background-color: #ccc" >
      <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>เงินบวก</b>
      </td>
         <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>เงินลบ</b>
      </td>
      <td style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>Tenko</b>
      </td>
      <td style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>สายงาน</b>
      </td>
   </tr>
    </thead>';
}
if (substr($_GET['employeecode'], 0, 2) == '05') {
    $trrrc = '<thead>
     <tr style="border:1px solid #000;" >
            <td style="padding:3px;text-align:left;">
                <img src="../images/logonew.png">
            </td>
            <td colspan="21" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด (RUAMKIT RECYCLE CARRIER CO.,LTD.)</b>
                <br>

                 เลขที่ 109/1 หมู่ที่ 9 ตำบลหัวสำโรง อำเภอแปลงยาว จังหวัดฉะเชิงเทรา
            </td>
       </tr>
       <tr style="border:1px solid #000;" >
            <td colspan="17" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 12px;">
                <b>ค่าเบี้ยเลี้ยงและค่าอาหารการทำงานนอกสถานที่</b>
            </td>
            <td colspan="5" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
                <b>ทะเบียนรถ ' .$result_sethainame['THAINAME'] . '</b>
            </td>
       </tr>
       
       <tr style="border:1px solid #000;" >
         <td colspan="14" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
                รหัส : ' . $result_seEHR['PersonCode'] . ' | ชื่อ : ' . $result_seEHR['FnameT'] . ' ' . $result_seEHR['LnameT'] . '  |  สายงาน : ' . $result_seDep['DEPARTMENTNAME'] . ' | 
                
         </td>
         <td colspan="8" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
                <b>เดือน/ปี : ' . $_GET['datestart'] . '</b>
         </td>   
       </tr>
       
   <tr style="border:1px solid #000;background-color: #ccc" >
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ลำดับ</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>วันที่</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>จากบริษัท</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ถึงบริษัท(ROUTE)</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ทะเบียนรถ</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>กิโลเมตร <br>ที่เริ่มไป</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>กิโลเมตร <br>ที่กลับถึง</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>รวมระยะทาง</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>จำนวน <br> ลิตร</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ค่าเฉลี่ยน้ำมัน</b>
      </td>
      <td colspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ค่าน้ำมัน</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ยอดที่<br>จ่ายจริง</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>จำนวนพาเลท</be></b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ค่าตีเปล่า</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ค่า<br>ซ่อม</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ค่า<br>อื่นๆ</b>
      </td>
    
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ค่าเที่ยว</b>
      </td>
      <td colspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>ผู้อนุมัติ</b>
      </td>
      <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
         <b>หมาย <br>เหตุ</b>
      </td> 
   </tr>
      <tr style="border:1px solid #000;background-color: #ccc" >
       <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินบวก</b>
            </td>
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินลบ</b>
            </td>
      <td style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>Tenko</b>
                
            </td>
             <td style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>สายงาน</b>
                
            </td>
            
      </tr>
    </thead>';
}

$i = 1;
   // $sql_seComp = "SELECT CONVERT(NVARCHAR(10),DATEDEALERIN,103) AS 'DATEDEALERIN', JOBSTART,JOBEND,JOBNO,O4,VEHICLETYPE
   //    ,VEHICLETRANSPORTPLANID,EMPLOYEECODE1,EMPLOYEECODE2,THAINAME,COMPANYCODE,CUSTOMERCODE
   //    FROM [dbo].[VEHICLETRANSPORTPLAN]
   //    WHERE CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'" . $result_seGetdate['datestart'] . "',103) AND CONVERT(DATE,'" . $result_seGetdate['dateend'] . "',103)
   //    AND (EMPLOYEECODE1 = '" . $_GET['employeecode'] . "' OR EMPLOYEECODE2 = '" . $_GET['employeecode'] . "')
   //    AND (VEHICLETRANSPORTPRICEID IS NOT NULL AND VEHICLETRANSPORTPRICEID != '')
   //    AND (JOBSTART IS NOT NULL AND JOBSTART != '')
   //    AND (DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !='')ORDER BY DATEDEALERIN ASC";

   // $query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);

      $sql_seComp = "SELECT CONVERT(NVARCHAR(10),DATEWORKING,103) AS 'DATEWORKING', JOBSTART,JOBEND,a.JOBNO,O4,a.VEHICLETYPE
      ,a.VEHICLETRANSPORTPLANID,EMPLOYEECODE1,EMPLOYEECODE2,THAINAME,a.COMPANYCODE,a.CUSTOMERCODE,DOCUMENTCODE,C2,C3,a.WORKTYPE,RS_OILAVERAGE,
      CASE WHEN CONVERT(DECIMAL,C3) >= 0 THEN C3 END AS 'C3PLUS',
      CASE WHEN CONVERT(DECIMAL,C3) < 0  THEN C3 END AS 'C3MINUS',
      CASE WHEN (d.PositionNameT LIKE '%ปลอกเหลือง%' OR d.PositionNameT LIKE '%ปลอกเขียว%') THEN 'not' ELSE '' END CHKPST1,
      CASE WHEN (e.PositionNameT LIKE '%ปลอกเหลือง%' OR e.PositionNameT LIKE '%ปลอกเขียว%') THEN 'not' ELSE '' END CHKPST2,
      CASE 
				WHEN ((EMPLOYEECODE1 !='' OR EMPLOYEECODE1 != NULL) AND (EMPLOYEECODE2 !='' OR EMPLOYEECODE2 != NULL)) AND (e.PositionNameT LIKE '%ปลอกเหลือง%' OR e.PositionNameT LIKE '%ปลอกเขียว%') THEN '1' 
				WHEN ((EMPLOYEECODE1 !='' OR EMPLOYEECODE1 != NULL) AND (EMPLOYEECODE2 !='' OR EMPLOYEECODE2 != NULL)) AND (d.PositionNameT LIKE '%ปลอกเหลือง%' OR d.PositionNameT LIKE '%ปลอกเขียว%')  THEN '1' 
				WHEN ((EMPLOYEECODE1 !='' OR EMPLOYEECODE1 != NULL) AND (EMPLOYEECODE2 !='' OR EMPLOYEECODE2 != NULL)) AND NOT (e.PositionNameT LIKE '%ปลอกเหลือง%' OR e.PositionNameT LIKE '%ปลอกเขียว%')  THEN '2'
				WHEN ((EMPLOYEECODE1 !='' OR EMPLOYEECODE1 != NULL) AND (EMPLOYEECODE2 !='' OR EMPLOYEECODE2 != NULL)) AND NOT (d.PositionNameT LIKE '%ปลอกเหลือง%' OR d.PositionNameT LIKE '%ปลอกเขียว%')  THEN '2'  
      ELSE '1'
      END AS 'COUNTEMP',b.OILAVERAGE AS 'OILAVERAGE',c.MILEAGESTART,c.MILEAGEEND,a.ROUNDAMOUNT
      FROM [dbo].[VEHICLETRANSPORTPLAN] a
      LEFT JOIN [dbo].[OILAVERAGE] b ON b.COMPANYCODE = a.COMPANYCODE AND b.CUSTOMERCODE = a.CUSTOMERCODE AND b.VEHICLETYPE = a.VEHICLETYPE AND a.WORKTYPE = b.REMARK
      LEFT JOIN [dbo].[MILEAGE_SUMMARY] c ON c.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID 
      LEFT JOIN [dbo].[EMPLOYEEEHR2] d ON a.EMPLOYEECODE1 = d.PersonCode
      LEFT JOIN [dbo].[EMPLOYEEEHR2] e ON a.EMPLOYEECODE2 = e.PersonCode                     
      WHERE CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)
      AND (EMPLOYEECODE1 = '" . $_GET['employeecode'] . "' OR EMPLOYEECODE2 = '" . $_GET['employeecode'] . "')
      AND (VEHICLETRANSPORTPRICEID IS NOT NULL AND VEHICLETRANSPORTPRICEID != '')
      AND (JOBSTART IS NOT NULL AND JOBSTART != '')
      AND (DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !='')ORDER BY CONVERT(DATE,DATEWORKING,103),a.ROUNDAMOUNT  ASC";

      $query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
      while ($result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC)) {

      // $sql_seChkdoc = "SELECT [DOCUMENTCODE] FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] WHERE VEHICLETRANSPORTPLANID = '" . $result_seComp['VEHICLETRANSPORTPLANID'] . "'";
      // $query_seChkdoc = sqlsrv_query($conn, $sql_seChkdoc, $params_seChkdoc);
      // $result_seChkdoc = sqlsrv_fetch_array($query_seChkdoc, SQLSRV_FETCH_ASSOC);

      if($result_seComp['DOCUMENTCODE'] != ''){

      // เลขไมค์ต้น
      // $sql_seMileagestart = "SELECT TOP 1 MILEAGENUMBER FROM [dbo].[MILEAGE] 
      //                      WHERE MILEAGETYPE = 'MILEAGESTART' AND JOBNO = '" . $result_seComp['JOBNO'] . "' 
      //                      AND CONVERT(NVARCHAR,CREATEDATE,120) = (SELECT TOP 1 CONVERT(NVARCHAR,CREATEDATE,120) 
      //                      FROM [dbo].[MILEAGE] WHERE MILEAGETYPE = 'MILEAGESTART' 
      //                      AND JOBNO = '" . $result_seComp['JOBNO'] . "' 
      //                      ORDER BY CREATEDATE DESC) ORDER BY CREATEDATE DESC";
      // $query_seMileagestart = sqlsrv_query($conn, $sql_seMileagestart, $params_seMileagestart);
      // $result_seMileagestart = sqlsrv_fetch_array($query_seMileagestart, SQLSRV_FETCH_ASSOC);

      // เลขไมค์ปลาย
      // $sql_seMileageend = "SELECT TOP 1 MILEAGENUMBER FROM [dbo].[MILEAGE] 
      //                      WHERE MILEAGETYPE = 'MILEAGEEND' AND JOBNO = '" . $result_seComp['JOBNO'] . "' 
      //                      AND CONVERT(NVARCHAR,CREATEDATE,120) = (SELECT TOP 1 CONVERT(NVARCHAR,CREATEDATE,120) 
      //                      FROM [dbo].[MILEAGE] WHERE MILEAGETYPE = 'MILEAGEEND' 
      //                      AND JOBNO = '" . $result_seComp['JOBNO'] . "' ORDER BY CREATEDATE DESC) 
      //                      ORDER BY CREATEDATE DESC";
      // $query_seMileageend = sqlsrv_query($conn, $sql_seMileageend, $params_seMileageend);
      // $result_seMileageend = sqlsrv_fetch_array($query_seMileageend, SQLSRV_FETCH_ASSOC);

      // ค่าเฉลี่ยน้ำมัน
      // $sql_seOilaverage = "SELECT DISTINCT OILAVERAGE FROM [dbo].[OILAVERAGE] 
      //                      WHERE VEHICLETYPE = '" . $result_seComp['VEHICLETYPE'] . "'
      //                      AND COMPANYCODE ='" . $result_seComp['COMPANYCODE'] . "'
      //                      AND CUSTOMERCODE ='" . $result_seComp['CUSTOMERCODE'] . "'";
      // $query_seOilaverage = sqlsrv_query($conn, $sql_seOilaverage, $params_seOilaverage);
      // $result_seOilaverage = sqlsrv_fetch_array($query_seOilaverage, SQLSRV_FETCH_ASSOC);
      
      //จำนวนพาเลท
      $sql_sePallet = "SELECT SUM(CONVERT(INT,TRIPAMOUNT_PALLET)) AS 'PALLET',DOCUMENTCODE_PALLET AS 'DOPALLET'
                        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] 
                        WHERE VEHICLETRANSPORTPLANID ='" . $result_seComp['VEHICLETRANSPORTPLANID'] . "'
                        GROUP BY TRIPAMOUNT_PALLET,DOCUMENTCODE_PALLET";
      $query_sePallet = sqlsrv_query($conn, $sql_sePallet, $params_sePallet);
      $result_sePallet = sqlsrv_fetch_array($query_sePallet, SQLSRV_FETCH_ASSOC);

      // $sql_sePallet = "SELECT CONVERT(INT,TRIPAMOUNT_PALLET) AS 'PALLET',DOCUMENTCODE_PALLET AS 'DOPALLET'
      //                   FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] 
      //                   WHERE VEHICLETRANSPORTPLANID ='" . $result_seComp['VEHICLETRANSPORTPLANID'] . "'
      //                   GROUP BY TRIPAMOUNT_PALLET,DOCUMENTCODE_PALLET";
      // $query_sePallet = sqlsrv_query($conn, $sql_sePallet, $params_sePallet);
      // $result_sePallet = sqlsrv_fetch_array($query_sePallet, SQLSRV_FETCH_ASSOC);



      //  $sql_seCompensation = "SELECT MAX(COMPENSATION) AS 'COMPENSATION' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] WHERE VEHICLETRANSPORTPLANID = '" . $result_seComp['VEHICLETRANSPORTPLANID'] . "'";
      //  $query_seCompensation = sqlsrv_query($conn, $sql_seCompensation, $params_seCompensation);
      //  $result_seCompensation = sqlsrv_fetch_array($query_seCompensation, SQLSRV_FETCH_ASSOC);

      //ค่าเที่ยว
      $sql_seCompensation1 = "SELECT COMPENSATION,COMPENSATION1,COMPENSATION2,COMPENSATION3,
                              COMPENSATIONEMPTY,COMPENSATIONEMPTY1,COMPENSATIONEMPTY2,COMPENSATIONEMPTY3,
                              PAY_REPAIR,PAY_OTHER,PAY_CONDITION,OTHER,
                              SELECT_4LOAD1,SELECT_4LOAD2,SELECT_4LOAD3,SELECT_4LOAD4,SELECT_4LOAD5,SELECT_4LOAD6,
                              SELECT_8LOAD1,SELECT_8LOAD2,SELECT_8LOAD3,SELECT_8LOAD4,SELECT_8LOAD5,SELECT_8LOAD6,TOTALNET
                              FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] 
                              WHERE VEHICLETRANSPORTPLANID = '" . $result_seComp['VEHICLETRANSPORTPLANID'] . "'
                              AND (COMPENSATION IS NOT NULL OR COMPENSATION != '')
                              AND (COMPENSATION1 IS NOT NULL OR COMPENSATION1 != '' 
                              OR COMPENSATION2 IS NOT NULL OR COMPENSATION2 != '' 
                              OR COMPENSATION3 IS NOT NULL OR COMPENSATION3 != '')
							  ORDER BY COMPENSATION DESC";
      $query_seCompensation1 = sqlsrv_query($conn, $sql_seCompensation1, $params_seCompensation1);
      $result_seCompensation1 = sqlsrv_fetch_array($query_seCompensation1, SQLSRV_FETCH_ASSOC);

      if ($_GET['employeecode'] == $result_seComp['EMPLOYEECODE1']) {
      
      $COMPENSATION = $result_seCompensation1['TOTALNET'];
      // $INCOMEOTHER = (
      // $result_seCompensation1['SELECT_4LOAD1']+$result_seCompensation1['SELECT_4LOAD2']+$result_seCompensation1['SELECT_4LOAD3']+
      // $result_seCompensation1['SELECT_4LOAD4']+$result_seCompensation1['SELECT_4LOAD5']+$result_seCompensation1['SELECT_4LOAD6']+
      // $result_seCompensation1['SELECT_8LOAD1']+$result_seCompensation1['SELECT_8LOAD2']+$result_seCompensation1['SELECT_8LOAD3']+
      // $result_seCompensation1['SELECT_8LOAD4']+$result_seCompensation1['SELECT_8LOAD5']+$result_seCompensation1['SELECT_8LOAD6']);
      
      } else if ($_GET['employeecode'] == $result_seComp['EMPLOYEECODE2']) {
         // COMPENSATION2 = 0 หรือ '' หรือ NULL คือไม่ได้ลงค่าเที่ยวคนที่ 2 หรือ 
         if ($result_seCompensation1['COMPENSATION2'] == '0' || $result_seCompensation1['COMPENSATION2'] == '' || $result_seCompensation1['COMPENSATION2'] == 'NULL') {
            $COMPENSATION = '0';
         }else {
            $COMPENSATION = $result_seCompensation1['TOTALNET'];
         }
      
      // $INCOMEOTHER = (
      // $result_seCompensation1['SELECT_4LOAD1']+$result_seCompensation1['SELECT_4LOAD2']+$result_seCompensation1['SELECT_4LOAD3']+
      // $result_seCompensation1['SELECT_4LOAD4']+$result_seCompensation1['SELECT_4LOAD5']+$result_seCompensation1['SELECT_4LOAD6']+
      // $result_seCompensation1['SELECT_8LOAD1']+$result_seCompensation1['SELECT_8LOAD2']+$result_seCompensation1['SELECT_8LOAD3']+
      // $result_seCompensation1['SELECT_8LOAD4']+$result_seCompensation1['SELECT_8LOAD5']+$result_seCompensation1['SELECT_8LOAD6']);
         

      } 

      // // ค่าตอบแทนตีเปล่า
      // if ($_GET['employeecode'] == $result_seComp['EMPLOYEECODE1']) {
      //    if ($result_seCompensation1['COMPENSATIONEMPTY1'] =='0' || $result_seCompensation1['COMPENSATIONEMPTY1'] == NULL) {
      //       $COMPENSATIONEMPLY = '0';
      //    }else{
      //       $COMPENSATIONEMPLY = $result_seCompensation1['COMPENSATIONEMPTY1'];
      //    }
      
      // } else if ($_GET['employeecode'] == $result_seComp['EMPLOYEECODE2']) {
      //    if ($result_seCompensation1['COMPENSATIONEMPTY1'] =='0' || $result_seCompensation1['COMPENSATIONEMPTY1'] == NULL) {
      //       $COMPENSATIONEMPLY = '0';
      //    }else{
      //       $COMPENSATIONEMPLY = $result_seCompensation1['COMPENSATIONEMPTY1'];
      //    }
        
      
      // }  

      
            
      //$COMPENSATION = $result_seCompensation1['COMPENSATION'];
      
      //เงินค่าน้ำมันที่บวก
      // $sql_seCompoilaverage51 = "SELECT SUM(CONVERT(DECIMAL,C3)) AS 'CNT' 
      //             FROM [dbo].[VEHICLETRANSPORTPLAN] 
      //             WHERE CONVERT(DATE,DATEWORKING,103) = CONVERT(DATE,'" . $result_seComp['DATEWORKING'] . "',103) 
      //             AND (EMPLOYEECODE1 = '" . $result_seEHR['PersonCode'] . "' OR EMPLOYEECODE2= '" . $result_seEHR['PersonCode'] . "') 
      //             AND VEHICLETRANSPORTPLANID = '" .$result_seComp['VEHICLETRANSPORTPLANID'] . "'
      //             AND CONVERT(DECIMAL,C3) >= 0
      //             AND COMPANYCODE ='" .$result_seComp['COMPANYCODE'] . "'
      //             AND CUSTOMERCODE ='" .$result_seComp['CUSTOMERCODE'] . "'";
      // $query_seCompoilaverage51 = sqlsrv_query($conn, $sql_seCompoilaverage51, $params_seCompoilaverage51);
      // $result_seCompoilaverage51 = sqlsrv_fetch_array($query_seCompoilaverage51, SQLSRV_FETCH_ASSOC);

      //เงินค่าน้ำมันที่ลบ
      // $sql_seCompoilaverage52 = "SELECT SUM(CONVERT(DECIMAL,C3)) AS 'CNT' 
      //             FROM [dbo].[VEHICLETRANSPORTPLAN] 
      //             WHERE CONVERT(DATE,DATEWORKING,103) = CONVERT(DATE,'" . $result_seComp['DATEWORKING'] . "',103) 
      //             AND (EMPLOYEECODE1 = '" . $result_seEHR['PersonCode'] . "' OR EMPLOYEECODE2= '" . $result_seEHR['PersonCode'] . "') 
      //             AND VEHICLETRANSPORTPLANID = '" .$result_seComp['VEHICLETRANSPORTPLANID'] . "'
      //             AND CONVERT(DECIMAL,C3) < 0
      //             AND COMPANYCODE ='" .$result_seComp['COMPANYCODE'] . "'
      //             AND CUSTOMERCODE ='" .$result_seComp['CUSTOMERCODE'] . "'";
      // $query_seCompoilaverage52 = sqlsrv_query($conn, $sql_seCompoilaverage52, $params_seCompoilaverage52);
      // $result_seCompoilaverage52 = sqlsrv_fetch_array($query_seCompoilaverage52, SQLSRV_FETCH_ASSOC);

      //หาว่าวิ่งงาน 1 หรือ  2 คน
      // $sql_seCompoilaverage6  = "SELECT COUNT(*) AS 'CNT' FROM (
      //             SELECT  TOP 1 JOBSTART,JOBEND,EMPLOYEECODE1 AS 'EMPLOYEECODE',EMPLOYEENAME1 AS 'EMPLOYEENAME',CUSTOMERCODE 
      //             FROM [dbo].[VEHICLETRANSPORTPLAN] 
      //             WHERE VEHICLETRANSPORTPLANID = '" .$result_seComp['VEHICLETRANSPORTPLANID'] . "' 
      //             AND EMPLOYEECODE1 IS NOT NULL
      //             UNION 
      //             SELECT TOP 1 JOBSTART,JOBEND,EMPLOYEECODE2 AS 'EMPLOYEECODE',EMPLOYEENAME2 AS 'EMPLOYEENAME',CUSTOMERCODE 
      //             FROM [dbo].[VEHICLETRANSPORTPLAN] 
      //             WHERE VEHICLETRANSPORTPLANID = '" . $result_seComp['VEHICLETRANSPORTPLANID'] . "' 
      //             AND EMPLOYEECODE2 IS NOT NULL ) AS a";
      // $query_seCompoilaverage6 = sqlsrv_query($conn, $sql_seCompoilaverage6, $params_seCompoilaverage6);
      // $result_seCompoilaverage6 = sqlsrv_fetch_array($query_seCompoilaverage6, SQLSRV_FETCH_ASSOC);
   


      // if ($result_seOilaverage['OILAVERAGE'] == '' || $result_seOilaverage['OILAVERAGE'] == '0') {
      //    $OILAVG = '0';
      // } else  {
      //    $OILAVG = $result_seOilaverage['OILAVERAGE'];
      // }
      if ($result_seComp['C2'] > '0') {
         $OILAVG = '3.75';
      }else if ($result_seComp['C2'] == '0') {
         if(isset($result_seComp['RS_OILAVERAGE'])){
            $OILAVG = $result_seComp['RS_OILAVERAGE'];
         }else{
            $OILAVG = $result_seComp['OILAVERAGE'];
         }
      } else  {
         // ดึงค่าเฉลี่ยจากฐานข้อมูลแผน เริ่มบันทึกข้อมูลเมื่อ 18/12/2023 อัพเดทโค้ด 03/01/2024 
            // $OILAVG = $result_seComp['RS_OILAVERAGE'];
         // ของเดิม ดึงค่าเฉลี่ยจากฐานข้อมูลค่าเฉลี่ยน้ำมัน ปิดโค้ดวันที่ 03/01/2024
            // $OILAVG = $result_seComp['OILAVERAGE'];
         if(isset($result_seComp['RS_OILAVERAGE'])){
            $OILAVG = $result_seComp['RS_OILAVERAGE'];
         }else{
            $OILAVG = $result_seComp['OILAVERAGE'];
         }
      } 

      $td .= '<tr style="border:1px solid #000;" >
      <td  style="border-right:1px solid #000;padding:3px;text-align:center;">' . $i. '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . $result_seComp['DATEWORKING'] . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . $result_seComp['JOBSTART'] . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . $result_seComp['JOBEND'] . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . str_replace("(4L)","",$result_seComp['THAINAME']) . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seComp['MILEAGESTART']) . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seComp['MILEAGEEND']) . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seComp['MILEAGEEND'] - $result_seComp['MILEAGESTART']) . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . ($result_seComp['O4'] == '' ? '0':$result_seComp['O4']). '</td>            
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . $OILAVG. '</td>   
      <td  style="border-right:1px solid #000;padding:3px;text-align:center;">' . number_format($result_seComp['C3PLUS'] / ($result_seComp['COUNTEMP'])) . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:center;">' . number_format($result_seComp['C3MINUS'] / ($result_seComp['COUNTEMP']),2) . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:center;">' . number_format(($result_seComp['C3PLUS'] / $result_seComp['COUNTEMP']) - (($result_seComp['C3MINUS'] / $result_seComp['COUNTEMP']) * -1)). '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:center;">' . ($result_sePallet['PALLET'] =='' ? '0':$result_sePallet['PALLET']) . '</td>   
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($COMPENSATIONEMPLY) . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seCompensation1['PAY_REPAIR']) . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seCompensation1['PAY_OTHER']+$result_seCompensation1['OTHER']) . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($COMPENSATION) . '</td>   
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">-</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">-</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' .$result_seCompensation1['PAY_CONDITION']  . '</td>
   </tr>';



         // $rsmileagestart = $rsmileagestart + $result_seComp['MILEAGESTART'];
         // $rsmileageend = $rsmileageend + $result_seComp['MILEAGEEND'];
         $rsmileagestartend = $rsmileagestartend + ($result_seComp['MILEAGEEND'] - $result_seComp['MILEAGESTART']);
         $rscompo4 = $rscompo4 + $result_seComp['O4'];
         // $rsincomeother = $rsincomeother + $INCOMEOTHER;
         $rscompensation = $rscompensation + $COMPENSATION;
         $rscompensationemply = $rscompensationemply + $COMPENSATIONEMPLY;
         $rspayrepair = $rspayrepair + $result_seCompensation1['PAY_REPAIR'];
         $rspayother = $rspayother + ($result_seCompensation1['PAY_OTHER']+$result_seCompensation1['OTHER']);
         $rspallet = $rspallet + $result_sePallet['PALLET'];
         // $resmoney =($result_seComp['C3PLUS'] / $result_seComp['COUNTEMP']) - (($result_seComp['C3MINUS'] / $result_seComp['COUNTEMP']) * -1);
         $resmoney =(round($result_seComp['C3PLUS'] / $result_seComp['COUNTEMP'])) - ((round($result_seComp['C3MINUS'] / $result_seComp['COUNTEMP'])) * -1);
         $allmoney = $allmoney + $resmoney;
         $i++;
}else{


}

}

$table_end = '</tbody>
   <tfoot>
      <tr style="border:1px solid #000;" >
         <td colspan="4" style="border-right:1px solid #000;padding:3px;text-align:right;"><b>รวม</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b></b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b></b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b></b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>' . number_format($rsmileagestartend) . '</b></td>            
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>' . number_format($rscompo4) . '</b></td>   
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>-</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>-</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>-</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>' . number_format($allmoney) . '</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>' . number_format($rspallet) . '</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>' . number_format($rscompensationemply) . '</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>' . number_format($rspayrepair) . '</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>' . number_format($rspayother) . '</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>' . number_format($rscompensation) . '</b></td>   
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>-</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>-</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>-</b></td>
      </tr>
   </tfoot>
</table>';

$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_begin);
if (substr($_GET['employeecode'], 0, 2) == '09') {
    $mpdf->WriteHTML($trratc);
}
if (substr($_GET['employeecode'], 0, 2) == '04') {
    $mpdf->WriteHTML($trrcc);
}
if (substr($_GET['employeecode'], 0, 2) == '05') {
    $mpdf->WriteHTML($trrrc);
}
if (substr($_GET['employeecode'], 0, 2) == '07') {
    $mpdf->WriteHTML($trrkl);
}
if (substr($_GET['employeecode'], 0, 2) == '01') {
    $mpdf->WriteHTML($trrkr);
}
if (substr($_GET['employeecode'], 0, 2) == '02') {
    $mpdf->WriteHTML($trrks);
}
$mpdf->WriteHTML($td);
$mpdf->WriteHTML($table_end);

$mpdf->Output();

sqlsrv_close($conn);
?>

