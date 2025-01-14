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
         WHERE CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)
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

if (substr($_GET['employeecode'], 0, 2) == '07') {
    $trrkl = '<thead>
     <tr style="border:1px solid #000;" >
            <td style="padding:3px;text-align:left;">
                <img src="../images/logonew.png">
            </td>
            <td colspan="23" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 15px;">
                <b>บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์ จำกัด (RUAMKIT RUNGRUENG LOGISTICS CO., LTD.)</b>
                <br>
                เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง จังหวัดชลบุรี 20160
            </td>
       </tr>

      <tr style="border:1px solid #000;" >
            <td colspan="15" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 12px;">
                <b>ค่าเบี้ยเลี้ยงและค่าอาหารการทำงานนอกสถานที่</b>
            </td>
            <td colspan="9" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
                <b>ทะเบียนรถ ' .$result_sethainame['THAINAME'] . '</b>
            </td>
       </tr>
       
       <tr style="border:1px solid #000;" >
         <td colspan="15" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
                รหัส : ' . $result_seEHR['PersonCode'] . ' | ชื่อ : ' . $result_seEHR['FnameT'] . ' ' . $result_seEHR['LnameT'] . '  |  สายงาน : ' . $result_seDep['DEPARTMENTNAME'] . ' |  
         </td>
         <td colspan="9" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
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
               <b>จำนวน<br>พาเลท</be></b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ค่า<br>พาเลท</be></b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ค่า<br>ตีเปล่า</b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ค่า<br>เทรนนิ่ง</b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ค่า<br>โอเจที</b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ค่า<br>มัลติสกิล</b>
            </td>
             <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ค่าเที่ยว</b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>รวม<br>รายได้</b>
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
if (substr($_GET['employeecode'], 0, 2) == '01'|| substr($_GET['employeecode'], 0, 2) == '10') {

    $trrkr = '<thead>
     <tr style="border:1px solid #000;" >
            <td style="padding:3px;text-align:left;">
                <img src="../images/logonew.png">
            </td>
            <td colspan="23" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 15px;">
                <b>บริษัท ร่วมกิจรุ่งเรือง (1993) จำกัด (RUAMKIT RUNGRUENG (1993) CO., LTD.)</b>
                <br>
                เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง จังหวัดชลบุรี 20160
            </td>
       </tr>
       <tr style="border:1px solid #000;" >
         <td colspan="15" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 12px;">
            <b>ค่าเบี้ยเลี้ยงและค่าอาหารการทำงานนอกสถานที่</b>
         </td>
         <td colspan="9" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
            <b>ทะเบียนรถ ' .$result_sethainame['THAINAME'] . '</b>
         </td>
      </tr>
      
      <tr style="border:1px solid #000;" >
         <td colspan="15" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
               รหัส : ' . $result_seEHR['PersonCode'] . ' | ชื่อ : ' . $result_seEHR['FnameT'] . ' ' . $result_seEHR['LnameT'] . '  |  สายงาน : ' . $result_seDep['DEPARTMENTNAME'] . ' |   
         </td>
         <td colspan="9" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
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
               <b>จำนวน<br>พาเลท</be></b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ค่า<br>พาเลท</be></b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ค่า<br>ตีเปล่า</b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ค่า<br>เทรนนิ่ง</b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ค่า<br>โอเจที</b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ค่า<br>มัลติสกิล</b>
            </td>
             <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ค่าเที่ยว</b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>รวม<br>รายได้</b>
           </td>
             <td colspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ผู้อนุมัติ</b>
            </td>
             
             <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>หมาย <br>เหตุ</b>
            </td> 
       </tr>

      <tr style="border:1px solid #000;background-color: #ccc" >
         <td style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินบวก</b>
         </td>
         <td style="border-right:1px solid #000;padding:3px;text-align:center;">
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
if (substr($_GET['employeecode'], 0, 2) == '02') {

    $trrks = '<thead>
     <tr style="border:1px solid #000;" >
            <td style="padding:3px;text-align:left;">
                <img src="../images/logonew.png">
            </td>
            <td colspan="23" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 15px;">
                <b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICE CO.,LTD)</b>
                <br>
                เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160
            </td>
       </tr>
       <tr style="border:1px solid #000;" >
         <td colspan="15" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 12px;">
            <b>ค่าเบี้ยเลี้ยงและค่าอาหารการทำงานนอกสถานที่</b>
         </td>
         <td colspan="9" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
            <b>ทะเบียนรถ ' .$result_sethainame['THAINAME'] . '</b>
         </td>
      </tr>
      
      <tr style="border:1px solid #000;" >
         <td colspan="15" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
               รหัส : ' . $result_seEHR['PersonCode'] . ' | ชื่อ : ' . $result_seEHR['FnameT'] . ' ' . $result_seEHR['LnameT'] . '  |  สายงาน : ' . $result_seDep['DEPARTMENTNAME'] . ' |    
         </td>
         <td colspan="9" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
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
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;width:8%">
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
               <b>จำนวน<br>พาเลท</be></b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ค่า<br>พาเลท</be></b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ค่า<br>ตีเปล่า</b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ค่า<br>เทรนนิ่ง</b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ค่า<br>โอเจที</b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ค่า<br>มัลติสกิล</b>
            </td>
             <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ค่าเที่ยว</b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>รวม<br>รายได้</b>
            </td>
             <td colspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ผู้อนุมัติ</b>
            </td>
             
             <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>หมาย <br>เหตุ</b>
            </td> 
         </tr>

      <tr style="border:1px solid #000;background-color: #ccc" >
         <td style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินบวก</b>
         </td>
         <td style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินลบ</b>
         </td>
         <td style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>Tenko</b>
         </td>
         <td style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>สายงาน</b>
         </td>
      </tr>
    </thead><tbody>';
}
if (substr($_GET['employeecode'], 0, 2) == '08') {

    $trrks = '<thead>
     <tr style="border:1px solid #000;" >
            <td style="padding:3px;text-align:left;">
                <img src="../images/logonew.png">
            </td>
            <td colspan="22" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 15px;">
                <b>&nbsp;</b>
                <br>&nbsp;
            </td>
       </tr>
       <tr style="border:1px solid #000;" >
         <td colspan="16" style="border-right:1px solid #000;padding:3px;text-align:center;font-size: 12px;">
            <b>ค่าเบี้ยเลี้ยงและค่าอาหารการทำงานนอกสถานที่</b>
         </td>
         <td colspan="9" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
            <b>ทะเบียนรถ ' .$result_sethainame['THAINAME'] . '</b>
         </td>
      </tr>
      
      <tr style="border:1px solid #000;" >
         <td colspan="16" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
               รหัส : ' . $result_seEHR['PersonCode'] . ' | ชื่อ : ' . $result_seEHR['FnameT'] . ' ' . $result_seEHR['LnameT'] . '  |  สายงาน : ' . $result_seDep['DEPARTMENTNAME'] . ' |    
         </td>
         <td colspan="9" style="border-right:1px solid #000;padding:3px;text-align:left;font-size: 12px;">
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
               <b>จำนวน<br>พาเลท</be></b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ค่า<br>พาเลท</be></b>
            </td>
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ค่า<br>ตีเปล่า</b>
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
            <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>รวม<br>รายได้</b>
            </td>
             <td colspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ผู้อนุมัติ</b>
            </td>
             
             <td rowspan="2"  style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>หมาย <br>เหตุ</b>
            </td> 
       </tr>

      <tr style="border:1px solid #000;background-color: #ccc" >
         <td style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินบวก</b>
         </td>
         <td style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>เงินลบ</b>
         </td>
         <td style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>Tenko</b>
         </td>
         <td style="border-right:1px solid #000;padding:3px;text-align:center;">
            <b>สายงาน</b>
         </td>
      </tr>
    </thead><tbody>';
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

      $sql_seComp = "SELECT ROW_NUMBER ( )   
         OVER (  PARTITION BY CONVERT(NVARCHAR(10),DATEWORKING,103) ORDER BY CONVERT(NVARCHAR(10),DATEWORKING,103) DESC ) AS 'CWORKROW' ,
         CONVERT(NVARCHAR(10),DATEWORKING,103) AS 'DATEWORKING', JOBSTART,JOBEND,a.JOBNO,a.VEHICLETYPE
         ,a.VEHICLETRANSPORTPLANID,EMPLOYEECODE1,d.PositionNameT AS 'POS1',EMPLOYEECODE2,e.PositionNameT  AS 'POS2',THAINAME,a.COMPANYCODE,a.CUSTOMERCODE,DOCUMENTCODE,C3,
         CASE WHEN CONVERT(DECIMAL,C3) >= 0 THEN C3 END AS 'C3PLUS',
         CASE WHEN CONVERT(DECIMAL,C3) < 0  THEN C3 END AS 'C3MINUS',
               
         CASE WHEN ((EMPLOYEECODE1 !='' OR EMPLOYEECODE1 != NULL) AND (EMPLOYEECODE2 !='' OR EMPLOYEECODE2 != NULL)) THEN '2' 
         ELSE '1'
         END AS 'COUNTEMP',b.OILAVERAGE AS 'OILAVERAGE',
         -- c.MILEAGESTART,c.MILEAGEEND,O4,
         f.MILEAGESTART,f.MILEAGEEND,f.OIL_AMOUNT O4,a.STATUSNUMBER
      
      
      FROM [dbo].[VEHICLETRANSPORTPLAN] a
      LEFT JOIN [dbo].[OILAVERAGE] b ON b.COMPANYCODE = a.COMPANYCODE AND b.CUSTOMERCODE = a.CUSTOMERCODE AND b.VEHICLETYPE = a.VEHICLETYPE
      LEFT JOIN [dbo].[MILEAGE_SUMMARY] c ON c.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID 
      LEFT JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE1
      LEFT JOIN [dbo].[EMPLOYEEEHR2] e ON e.PersonCode = a.EMPLOYEECODE2
      LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO f ON a.JOBNO = f.JOBNO COLLATE Thai_CI_AI 
         
                     
      WHERE CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)
      AND (EMPLOYEECODE1 = '" . $_GET['employeecode'] . "' OR EMPLOYEECODE2 = '" . $_GET['employeecode'] . "')
      AND (VEHICLETRANSPORTPRICEID IS NOT NULL AND VEHICLETRANSPORTPRICEID != '')
      AND (JOBSTART IS NOT NULL AND JOBSTART != '')
      AND (DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !='' OR STATUSNUMBER ='X')ORDER BY CONVERT(DATE,DATEWORKING,103)  ASC";

      $query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
      while ($result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC)) {

      if ($result_seComp['THAINAME'] =='61-4454' || $result_seComp['THAINAME'] =='61-4456' || $result_seComp['THAINAME'] =='61-3440' ||
         $result_seComp['THAINAME'] =='61-3441' || $result_seComp['THAINAME'] =='61-4453' || $result_seComp['THAINAME'] =='61-4457' ||
         $result_seComp['THAINAME'] =='61-4912' || $result_seComp['THAINAME'] =='61-4913' || $result_seComp['THAINAME'] =='61-4546' ||
         $result_seComp['THAINAME'] =='61-4547' || $result_seComp['THAINAME'] =='64-3452' || $result_seComp['THAINAME'] =='61-3445' ||
         $result_seComp['THAINAME'] =='61-3439' || $result_seComp['THAINAME'] =='61-3443' || $result_seComp['THAINAME'] =='61-3834' ||
         $result_seComp['THAINAME'] =='61-3835' || $result_seComp['THAINAME'] =='61-3438' || $result_seComp['THAINAME'] =='61-3437' || 
         $result_seComp['THAINAME'] =='62-9288' || $result_seComp['THAINAME'] =='61-3836' || $result_seComp['THAINAME'] =='61-4458' || 
         $result_seComp['THAINAME'] =='61-3444' || $result_seComp['THAINAME'] =='60-3868' || $result_seComp['THAINAME'] =='60-3870' ||
         $result_seComp['THAINAME'] =='61-3437' || $result_seComp['THAINAME'] =='61-3452') {

         $OILAVERAGE = '4.00';

      }else if($result_seComp['THAINAME'] =='60-3871' || $result_seComp['THAINAME'] =='61-3442' || $result_seComp['THAINAME'] =='60-2391' ||
         $result_seComp['THAINAME'] =='61-3444' || $result_seComp['THAINAME'] =='76-8919' || $result_seComp['THAINAME'] =='61-4458' ||
         $result_seComp['THAINAME'] =='79-2521' || $result_seComp['THAINAME'] =='79-2522' || $result_seComp['THAINAME'] =='79-2525' || 
         $result_seComp['THAINAME'] =='74-5653' || $result_seComp['THAINAME'] =='74-5684' || $result_seComp['THAINAME'] =='74-5684' || $result_seComp['THAINAME'] =='74-5654'  
      ) {
         $OILAVERAGE = '3.50';
      }else {
         // code...

         $OILAVERAGE = $result_seComp['OILAVERAGE'];
      }




      
      if($result_seComp['DOCUMENTCODE'] != '' || $result_seComp['STATUSNUMBER'] == 'X'){
      
         //จำนวนพาเลท
         //  Query เดิมมี  เปลี่ยนวันที่ 31.08.67 เนื่องจากมีเคสที่ พนักงานจะไม่ได้คีย์เลขเดียวกัน
         // $sql_sePallet = "SELECT SUM(CONVERT(INT,TRIPAMOUNT_PALLET)) AS 'PALLET',DOCUMENTCODE_PALLET AS 'DOPALLET'
         //                   FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] 
         //                   WHERE VEHICLETRANSPORTPLANID ='" . $result_seComp['VEHICLETRANSPORTPLANID'] . "'
         //                   AND (TRIPAMOUNT_PALLET IS NOT NULL OR TRIPAMOUNT_PALLET !='')
         //                   AND (DOCUMENTCODE_PALLET IS NOT NULL OR DOCUMENTCODE_PALLET !='')
         //                   GROUP BY TRIPAMOUNT_PALLET,DOCUMENTCODE_PALLET";
         // $query_sePallet = sqlsrv_query($conn, $sql_sePallet, $params_sePallet);
         // $result_sePallet = sqlsrv_fetch_array($query_sePallet, SQLSRV_FETCH_ASSOC);

         //จำนวนพาเลท
         $sql_sePallet = "SELECT SUM(CONVERT(INT,a.PALLET )) AS 'PALLET' FROM (
                  SELECT CONVERT(INT,TRIPAMOUNT_PALLET) AS 'PALLET',DOCUMENTCODE_PALLET AS 'DOPALLET'
                  FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] 
                  WHERE VEHICLETRANSPORTPLANID ='" . $result_seComp['VEHICLETRANSPORTPLANID'] . "'
                  AND (TRIPAMOUNT_PALLET IS NOT NULL OR TRIPAMOUNT_PALLET !='')
                  AND (DOCUMENTCODE_PALLET IS NOT NULL OR DOCUMENTCODE_PALLET !='')
               ) AS a";
         $query_sePallet = sqlsrv_query($conn, $sql_sePallet, $params_sePallet);
         $result_sePallet = sqlsrv_fetch_array($query_sePallet, SQLSRV_FETCH_ASSOC);
         
         //ค่าเที่ยว
         // SELECT_4LOAD2 คือ กรณีพนักงานคนที่ 1 เป็นเทรนเนอร์ ได้รับเงินเพิ่ม 100 บาท/วัน ในหน้าคีย์ค่าตอบแทน
         // SELECT_4LOAD5 คือ กรณีพนักงานคนที่ 2 เป็นพนักงาน(OJT) ได้รับเงินเพิ่ม 100 บาท/วัน ในหน้าคีย์ค่าตอบแทน
         // SELECT_8LOAD2 คือ กรณีพนักงานคนที่ 2 เป็นพนักงานเพิ่มทักษะทำงาน(Multiskills) ได้รับเงินเพิ่ม 200 บาท/วัน	 ในหน้าคีย์ค่าตอบแทน
         // เพิ่มเงื่อนไข ORDER BY MODIFIEDDATE 
         $sql_seCompensation1 = "SELECT COMPENSATION,COMPENSATION1,COMPENSATION2,COMPENSATION3,
                                 COMPENSATIONEMPTY,COMPENSATIONEMPTY1,COMPENSATIONEMPTY2,COMPENSATIONEMPTY3,
                                 SELECT_4LOAD2,SELECT_4LOAD5,SELECT_8LOAD2,
                                 PAY_REPAIR,PAY_OTHER,PAY_CONDITION,OTHER
                                 FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] 
                                 WHERE VEHICLETRANSPORTPLANID = '" . $result_seComp['VEHICLETRANSPORTPLANID'] . "'
                                 AND (COMPENSATION IS NOT NULL OR COMPENSATION != '')
								 AND (COMPENSATION != '0' )
                                 AND (COMPENSATION1 IS NOT NULL OR COMPENSATION1 != '')
                                 AND (COMPENSATION2 IS NOT NULL OR COMPENSATION2 != '')
                                 --AND (COMPENSATION3 IS NOT NULL OR COMPENSATION3 != '')
                                 ORDER BY COMPENSATION,MODIFIEDDATE DESC";
         $query_seCompensation1 = sqlsrv_query($conn, $sql_seCompensation1, $params_seCompensation1);
         $result_seCompensation1 = sqlsrv_fetch_array($query_seCompensation1, SQLSRV_FETCH_ASSOC);

         
         // if ($_GET['employeecode'] == $result_seComp['EMPLOYEECODE1']) {
         //    $COMPENSATION = $result_seCompensation1['COMPENSATION1'];
         // } else if ($_GET['employeecode'] == $result_seComp['EMPLOYEECODE2']) {
         //    $COMPENSATION = $result_seCompensation1['COMPENSATION2'];
         // }

         // echo substr('080778',0,2);
         $EMPC1SUB = substr($result_seComp['EMPLOYEECODE1'],0,2);
         $EMPC2SUB = substr($result_seComp['EMPLOYEECODE2'],0,2);
         $GETEMPC = $_GET['employeecode'];
         $EMPC1 = $result_seComp['EMPLOYEECODE1'];
         $EMPC2 = $result_seComp['EMPLOYEECODE2'];
         $POS1 = $result_seComp['POS1'];
         $POS2 = $result_seComp['POS2'];
         $CUSTOMERCODE = $result_seComp['CUSTOMERCODE'];
         $JOBEND=$result_seComp['JOBEND'];
         $COUNTEMP=$result_seComp['COUNTEMP'];     

         
         if ($GETEMPC == $EMPC1) {
            $TRAINNER = $result_seCompensation1['SELECT_4LOAD2'];
            $OJT = '';
            $MULTISKILL = '';
         }else if ($GETEMPC == $EMPC2) {
            $TRAINNER = '';
            $OJT = $result_seCompensation1['SELECT_4LOAD5'];
            $MULTISKILL = $result_seCompensation1['SELECT_8LOAD5'];
         }else{
            # code...
         }

         if(($CUSTOMERCODE=='SKB')){
            if($JOBEND=='คลังโคราช'){
               $C3PLUS='0.00';
               $C3MINUS='0.00';
               $CALC3='0.00';
               $plus = '0.00';
               $plus_format = number_format($plus);
               $plus_re = str_replace(",","",$plus_format);   
               $minus = '0.00';
               $minus_format = number_format($minus);
               $minus_re = str_replace(",","",$minus_format);
            }else{
               $C3PLUS=number_format($result_seComp['C3PLUS'] / ($result_seComp['COUNTEMP']), 2);
               $C3MINUS=number_format($result_seComp['C3MINUS'] / ($result_seComp['COUNTEMP']), 2);
               $CALC3=number_format(($result_seComp['C3PLUS'] / $result_seComp['COUNTEMP']) - (($result_seComp['C3MINUS'] / $result_seComp['COUNTEMP']) * -1));
               $plus = $result_seComp['C3PLUS'] / $result_seComp['COUNTEMP'];
               $plus_format = number_format($plus);
               $plus_re = str_replace(",","",$plus_format);   
               $minus = $result_seComp['C3MINUS'] / $result_seComp['COUNTEMP'];
               $minus_format = number_format($minus);
               $minus_re = str_replace(",","",$minus_format);
            }
               if ($GETEMPC == $result_seComp['EMPLOYEECODE1']) {

                  // ถ้าแผนงาน โดนตัดงาน ในวันเดียวกัน
                  // CASE 1 : วิ่งงาน 1 แผนงานและโดนตัดงานจะได้ 200 บาท
                  // CASR 2 : วิ่งงานมากกว่า 1 แผนงาน และ โดนตัดงานทั้งคู่ วันนั้นจะได้แค่ 200 บาท
                  // CASE 3 : วิ่งงานมากกกว่า 1 แผนงาน และ โดนตัดงานแค่ 1 แผนงาน แต่แผนงานอื่นๆไม่โดนตัดงานจะได้ค่าเที่ยวปกติ
                  if ($result_seComp['CWORKROW'] >= '1') {
                     if (($result_seComp['CWORKROW'] == '1' && $result_seComp['STATUSNUMBER'] == 'X') || ($result_seComp['CWORKROW'] > '1' && $result_seComp['STATUSNUMBER'] == 'X')) {
                        if ($result_seComp['CWORKROW'] == '1') {
                           $COMPENSATION = '200';
                           $COMPENSATION_OTHER = '0';
                        }else{
                           $COMPENSATION = '';
                           $COMPENSATION_OTHER = '';
                        }
                        
                     }else{
                        // CASE 3 : วิ่งงานมากกกว่า 1 แผนงาน และ โดนตัดงานแค่ 1 แผนงาน แต่แผนงานอื่นๆไม่โดนตัดงานจะได้ค่าเที่ยวปกติ
                        if ($result_seComp['STATUSNUMBER'] == 'X') {
                           $COMPENSATION = '';
                           $COMPENSATION_OTHER = '';
                        }else{
                           $COMPENSATION = $result_seCompensation1['COMPENSATION1'];
                           $COMPENSATION_OTHER = '0';
                        }
                        // $COMPENSATION = '666';
                        // $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD2'];   
                     }
                  
                  }else{
                     $COMPENSATION = $result_seCompensation1['COMPENSATION1'];
                     $COMPENSATION_OTHER = '0';
                  }

                     
                  
                  
               } else if ($GETEMPC == $result_seComp['EMPLOYEECODE2']) {
                  // ถ้าแผนงาน โดนตัดงาน ในวันเดียวกัน
                  // CASE 1 : วิ่งงาน 1 แผนงานและโดนตัดงานจะได้ 200 บาท
                  // CASR 2 : วิ่งงานมากกว่า 1 แผนงาน และ โดนตัดงานทั้งคู่ วันนั้นจะได้แค่ 200 บาท
                  // CASE 3 : วิ่งงานมากกกว่า 1 แผนงาน และ โดนตัดงานแค่ 1 แผนงาน แต่แผนงานอื่นๆไม่โดนตัดงานจะได้ค่าเที่ยวปกติ
                  if ($result_seComp['CWORKROW'] >= '1') {
                     if (($result_seComp['CWORKROW'] == '1' && $result_seComp['STATUSNUMBER'] == 'X') || ($result_seComp['CWORKROW'] > '1' && $result_seComp['STATUSNUMBER'] == 'X')) {
                        if ($result_seComp['CWORKROW'] == '1') {
                           $COMPENSATION = '200';
                           $COMPENSATION_OTHER = '0';
                        }else{
                           $COMPENSATION = '';
                           $COMPENSATION_OTHER = '';
                        }
                        
                     }else{
                        // CASE 3 : วิ่งงานมากกกว่า 1 แผนงาน และ โดนตัดงานแค่ 1 แผนงาน แต่แผนงานอื่นๆไม่โดนตัดงานจะได้ค่าเที่ยวปกติ
                        if ($result_seComp['STATUSNUMBER'] == 'X') {
                           $COMPENSATION = '';
                           $COMPENSATION_OTHER = '';
                        }else{
                           $COMPENSATION = $result_seCompensation1['COMPENSATION2'];
                           $COMPENSATION_OTHER = '0';
                        }
                        // $COMPENSATION = '666';
                        // $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD2'];   
                     }
                  
                  }else{
                     $COMPENSATION = $result_seCompensation1['COMPENSATION2'];
                     $COMPENSATION_OTHER = '0';
                  }
                     
                  
                  
               }
         }else if(($CUSTOMERCODE=='TTTCSTC') && (($JOBEND=='TAKANO')||($JOBEND=='KEIHIN,TAKANO')||($JOBEND=='KEIHIN'))){
               $C3PLUS=number_format($result_seComp['C3PLUS'] / ($result_seComp['COUNTEMP']), 2);
               $C3MINUS=number_format($result_seComp['C3MINUS'] / ($result_seComp['COUNTEMP']), 2);
               $CALC3=number_format(($result_seComp['C3PLUS'] / $result_seComp['COUNTEMP']) - (($result_seComp['C3MINUS'] / $result_seComp['COUNTEMP']) * -1));
               $plus = $result_seComp['C3PLUS'] / $result_seComp['COUNTEMP'];
               $plus_format = number_format($plus);
               $plus_re = str_replace(",","",$plus_format);   
               $minus = $result_seComp['C3MINUS'] / $result_seComp['COUNTEMP'];
               $minus_format = number_format($minus);
               $minus_re = str_replace(",","",$minus_format);
               if ($GETEMPC == $result_seComp['EMPLOYEECODE1']) {
                  // ถ้าแผนงาน โดนตัดงาน ในวันเดียวกัน
                  // CASE 1 : วิ่งงาน 1 แผนงานและโดนตัดงานจะได้ 200 บาท
                  // CASR 2 : วิ่งงานมากกว่า 1 แผนงาน และ โดนตัดงานทั้งคู่ วันนั้นจะได้แค่ 200 บาท
                  // CASE 3 : วิ่งงานมากกกว่า 1 แผนงาน และ โดนตัดงานแค่ 1 แผนงาน แต่แผนงานอื่นๆไม่โดนตัดงานจะได้ค่าเที่ยวปกติ
                  if ($result_seComp['CWORKROW'] >= '1') {
                     if (($result_seComp['CWORKROW'] == '1' && $result_seComp['STATUSNUMBER'] == 'X') || ($result_seComp['CWORKROW'] > '1' && $result_seComp['STATUSNUMBER'] == 'X')) {
                        if ($result_seComp['CWORKROW'] == '1') {
                           $COMPENSATION = '200';
                           $COMPENSATION_OTHER = '0';
                        }else{
                           $COMPENSATION = '';
                           $COMPENSATION_OTHER = '';
                        }
                        
                     }else{
                        // CASE 3 : วิ่งงานมากกกว่า 1 แผนงาน และ โดนตัดงานแค่ 1 แผนงาน แต่แผนงานอื่นๆไม่โดนตัดงานจะได้ค่าเที่ยวปกติ
                        if ($result_seComp['STATUSNUMBER'] == 'X') {
                           $COMPENSATION = '';
                           $COMPENSATION_OTHER = '';
                        }else{
                           $COMPENSATION = $result_seCompensation1['COMPENSATION1'];
                           $COMPENSATION_OTHER = '0';
                        }
                        // $COMPENSATION = '666';
                        // $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD2'];   
                     }
                  
                  }else{
                     $COMPENSATION = $result_seCompensation1['COMPENSATION1'];
                     $COMPENSATION_OTHER = '0';
                  }
                     
                  
                 
               } else if ($GETEMPC == $result_seComp['EMPLOYEECODE2']) {
                  // ถ้าแผนงาน โดนตัดงาน ในวันเดียวกัน
                  // CASE 1 : วิ่งงาน 1 แผนงานและโดนตัดงานจะได้ 200 บาท
                  // CASR 2 : วิ่งงานมากกว่า 1 แผนงาน และ โดนตัดงานทั้งคู่ วันนั้นจะได้แค่ 200 บาท
                  // CASE 3 : วิ่งงานมากกกว่า 1 แผนงาน และ โดนตัดงานแค่ 1 แผนงาน แต่แผนงานอื่นๆไม่โดนตัดงานจะได้ค่าเที่ยวปกติ
                  if ($result_seComp['CWORKROW'] >= '1') {
                     if (($result_seComp['CWORKROW'] == '1' && $result_seComp['STATUSNUMBER'] == 'X') || ($result_seComp['CWORKROW'] > '1' && $result_seComp['STATUSNUMBER'] == 'X')) {
                        if ($result_seComp['CWORKROW'] == '1') {
                           $COMPENSATION = '200';
                           $COMPENSATION_OTHER = '0';
                        }else{
                           $COMPENSATION = '';
                           $COMPENSATION_OTHER = '';
                        }
                        
                     }else{
                        // CASE 3 : วิ่งงานมากกกว่า 1 แผนงาน และ โดนตัดงานแค่ 1 แผนงาน แต่แผนงานอื่นๆไม่โดนตัดงานจะได้ค่าเที่ยวปกติ
                        if ($result_seComp['STATUSNUMBER'] == 'X') {
                           $COMPENSATION = '';
                           $COMPENSATION_OTHER = '';
                        }else{
                           $COMPENSATION = $result_seCompensation1['COMPENSATION2'];
                           $COMPENSATION_OTHER = '0';
                        }
                        // $COMPENSATION = '666';
                        // $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD2'];   
                     }
                  
                  }else{
                     $COMPENSATION = $result_seCompensation1['COMPENSATION2'];
                     $COMPENSATION_OTHER = '0';
                  }
                     
                  
                  
               }
         }else if(($CUSTOMERCODE=='TGT') && (($JOBEND=='INGY')||($JOBEND=='BJKC + INGY'))){
               $C3PLUS=number_format($result_seComp['C3PLUS'] / ($result_seComp['COUNTEMP']), 2);
               $C3MINUS=number_format($result_seComp['C3MINUS'] / ($result_seComp['COUNTEMP']), 2);
               $CALC3=number_format(($result_seComp['C3PLUS'] / $result_seComp['COUNTEMP']) - (($result_seComp['C3MINUS'] / $result_seComp['COUNTEMP']) * -1));
               $plus = $result_seComp['C3PLUS'] / $result_seComp['COUNTEMP'];
               $plus_format = number_format($plus);
               $plus_re = str_replace(",","",$plus_format);   
               $minus = $result_seComp['C3MINUS'] / $result_seComp['COUNTEMP'];
               $minus_format = number_format($minus);
               $minus_re = str_replace(",","",$minus_format);
               if ($GETEMPC == $result_seComp['EMPLOYEECODE1']) {
                  // ถ้าแผนงาน โดนตัดงาน ในวันเดียวกัน
                  // CASE 1 : วิ่งงาน 1 แผนงานและโดนตัดงานจะได้ 200 บาท
                  // CASR 2 : วิ่งงานมากกว่า 1 แผนงาน และ โดนตัดงานทั้งคู่ วันนั้นจะได้แค่ 200 บาท
                  // CASE 3 : วิ่งงานมากกกว่า 1 แผนงาน และ โดนตัดงานแค่ 1 แผนงาน แต่แผนงานอื่นๆไม่โดนตัดงานจะได้ค่าเที่ยวปกติ
                  if ($result_seComp['CWORKROW'] >= '1') {
                     if (($result_seComp['CWORKROW'] == '1' && $result_seComp['STATUSNUMBER'] == 'X') || ($result_seComp['CWORKROW'] > '1' && $result_seComp['STATUSNUMBER'] == 'X')) {
                        if ($result_seComp['CWORKROW'] == '1') {
                           $COMPENSATION = '200';
                           $COMPENSATION_OTHER = '0';
                        }else{
                           $COMPENSATION = '';
                           $COMPENSATION_OTHER = '';
                        }
                        
                     }else{
                        // CASE 3 : วิ่งงานมากกกว่า 1 แผนงาน และ โดนตัดงานแค่ 1 แผนงาน แต่แผนงานอื่นๆไม่โดนตัดงานจะได้ค่าเที่ยวปกติ
                        if ($result_seComp['STATUSNUMBER'] == 'X') {
                           $COMPENSATION = '';
                           $COMPENSATION_OTHER = '';
                        }else{
                           $COMPENSATION = $result_seCompensation1['COMPENSATION1'];
                           $COMPENSATION_OTHER = '';
                        }
                        // $COMPENSATION = '666';
                        // $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD2'];   
                     }
                  
                  }else{
                     $COMPENSATION = $result_seCompensation1['COMPENSATION1'];
                     $COMPENSATION_OTHER = '';
                  }
                     
                  
                  
               } else if ($GETEMPC == $result_seComp['EMPLOYEECODE2']) {
                  // ถ้าแผนงาน โดนตัดงาน ในวันเดียวกัน
                  // CASE 1 : วิ่งงาน 1 แผนงานและโดนตัดงานจะได้ 200 บาท
                  // CASR 2 : วิ่งงานมากกว่า 1 แผนงาน และ โดนตัดงานทั้งคู่ วันนั้นจะได้แค่ 200 บาท
                  // CASE 3 : วิ่งงานมากกกว่า 1 แผนงาน และ โดนตัดงานแค่ 1 แผนงาน แต่แผนงานอื่นๆไม่โดนตัดงานจะได้ค่าเที่ยวปกติ
                  if ($result_seComp['CWORKROW'] >= '1') {
                     if (($result_seComp['CWORKROW'] == '1' && $result_seComp['STATUSNUMBER'] == 'X') || ($result_seComp['CWORKROW'] > '1' && $result_seComp['STATUSNUMBER'] == 'X')) {
                        if ($result_seComp['CWORKROW'] == '1') {
                           $COMPENSATION = '200';
                           $COMPENSATION_OTHER = '0';
                        }else{
                           $COMPENSATION = '';
                           $COMPENSATION_OTHER = '';
                        }
                        
                     }else{
                        // CASE 3 : วิ่งงานมากกกว่า 1 แผนงาน และ โดนตัดงานแค่ 1 แผนงาน แต่แผนงานอื่นๆไม่โดนตัดงานจะได้ค่าเที่ยวปกติ
                        if ($result_seComp['STATUSNUMBER'] == 'X') {
                           $COMPENSATION = '';
                           $COMPENSATION_OTHER = '';
                        }else{
                           $COMPENSATION = $result_seCompensation1['COMPENSATION2'];
                           $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD5']+$result_seCompensation1['SELECT_8LOAD2'];
                        }
                        // $COMPENSATION = '666';
                        // $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD2'];   
                     }
                  
                  }else{
                     $COMPENSATION = $result_seCompensation1['COMPENSATION2'];
                     $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD5']+$result_seCompensation1['SELECT_8LOAD2'];
                  }
                      
               }
         }else{
            if ($GETEMPC == $EMPC1) {
               if(($POS1=='พนักงานขับรถ/ปลอกเขียว') || ($POS1=='พนักงานขับรถ/ปลอกเหลือง')){
                  $C3PLUS='0';
                  $C3MINUS='0';
                  $CALC3='0';
                  $plus = '0';
                  $plus_format = number_format($plus);
                  $plus_re = str_replace(",","",$plus_format);   
                  $minus = '0';
                  $minus_format = number_format($minus);
                  $minus_re = str_replace(",","",$minus_format);
                  $COMPENSATION = '0';
                  $COMPENSATION_OTHER = '0';
               }else{
                  $C3PLUS=number_format($result_seComp['C3PLUS'], 2);
                  $C3MINUS=number_format($result_seComp['C3MINUS'], 2);
                  $CALC3=number_format(($result_seComp['C3PLUS'] - $result_seComp['C3MINUS']), 2);
                  $plus = $result_seComp['C3PLUS'];
                  $plus_format = number_format($plus);
                  $plus_re = str_replace(",","",$plus_format);   
                  $minus = $result_seComp['C3MINUS'];
                  $minus_format = number_format($minus);
                  $minus_re = str_replace(",","",$minus_format);
                  if ($GETEMPC == $result_seComp['EMPLOYEECODE1']) {
                     
                        // ถ้าแผนงาน โดนตัดงาน ในวันเดียวกัน
                        // CASE 1 : วิ่งงาน 1 แผนงานและโดนตัดงานจะได้ 200 บาท
                        // CASR 2 : วิ่งงานมากกว่า 1 แผนงาน และ โดนตัดงานทั้งคู่ วันนั้นจะได้แค่ 200 บาท
                        // CASE 3 : วิ่งงานมากกกว่า 1 แผนงาน และ โดนตัดงานแค่ 1 แผนงาน แต่แผนงานอื่นๆไม่โดนตัดงานจะได้ค่าเที่ยวปกติ
                        if ($result_seComp['CWORKROW'] >= '1') {
                           if (($result_seComp['CWORKROW'] == '1' && $result_seComp['STATUSNUMBER'] == 'X') || ($result_seComp['CWORKROW'] > '1' && $result_seComp['STATUSNUMBER'] == 'X')) {
                              if ($result_seComp['CWORKROW'] == '1') {
                                 $COMPENSATION = '200';
                                 $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD2'];
                              }else{
                                 $COMPENSATION = '';
                                 $COMPENSATION_OTHER = '';
                              }
                              
                           }else{
                              // CASE 3 : วิ่งงานมากกกว่า 1 แผนงาน และ โดนตัดงานแค่ 1 แผนงาน แต่แผนงานอื่นๆไม่โดนตัดงานจะได้ค่าเที่ยวปกติ
                              if ($result_seComp['STATUSNUMBER'] == 'X') {
                                 $COMPENSATION = '';
                                 $COMPENSATION_OTHER = '';
                              }else{
                                 $COMPENSATION = $result_seCompensation1['COMPENSATION1'];
                                 $COMPENSATION_OTHER = '';
                                 // อันเดิมมี $result_seCompensation1['SELECT_4LOAD2']; 
                                 // แก้ไขวันที่ พบปัญหาที่ สายงาน STM SR คิดเงินเบิ้ล 100 บาท 12.09.67
                              }
                              // $COMPENSATION = '666';
                              // $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD2'];   
                           }
                        
                        }else{
                           $COMPENSATION = $result_seCompensation1['COMPENSATION1'];
                           $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD2'];
                        }

                 
                     
                     
                  } else if ($GETEMPC == $result_seComp['EMPLOYEECODE2']) {

                        // ถ้าแผนงาน โดนตัดงาน ในวันเดียวกัน
                        // CASE 1 : วิ่งงาน 1 แผนงานและโดนตัดงานจะได้ 200 บาท
                        // CASR 2 : วิ่งงานมากกว่า 1 แผนงาน และ โดนตัดงานทั้งคู่ วันนั้นจะได้แค่ 200 บาท
                        // CASE 3 : วิ่งงานมากกกว่า 1 แผนงาน และ โดนตัดงานแค่ 1 แผนงาน แต่แผนงานอื่นๆไม่โดนตัดงานจะได้ค่าเที่ยวปกติ
                        if ($result_seComp['CWORKROW'] >= '1') {
                           if (($result_seComp['CWORKROW'] == '1' && $result_seComp['STATUSNUMBER'] == 'X') || ($result_seComp['CWORKROW'] > '1' && $result_seComp['STATUSNUMBER'] == 'X')) {
                              if ($result_seComp['CWORKROW'] == '1') {
                                 $COMPENSATION = '200';
                                 $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD5']+$result_seCompensation1['SELECT_8LOAD2'];
                              }else{
                                 $COMPENSATION = '';
                                 $COMPENSATION_OTHER = '';
                              }
                              
                           }else{
                              // CASE 3 : วิ่งงานมากกกว่า 1 แผนงาน และ โดนตัดงานแค่ 1 แผนงาน แต่แผนงานอื่นๆไม่โดนตัดงานจะได้ค่าเที่ยวปกติ
                              if ($result_seComp['STATUSNUMBER'] == 'X') {
                                 $COMPENSATION = '';
                                 $COMPENSATION_OTHER = '';
                              }else{
                                 $COMPENSATION = $result_seCompensation1['COMPENSATION2'];
                                 $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD5']+$result_seCompensation1['SELECT_8LOAD2'];
                              }
                              // $COMPENSATION = '666';
                              // $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD2'];   
                           }
                        
                        }else{
                           $COMPENSATION = $result_seCompensation1['COMPENSATION1'];
                           $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD2'];
                        }

                        // $COMPENSATION = $result_seCompensation1['COMPENSATION2'];
                        // $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD5']+$result_seCompensation1['SELECT_8LOAD2'];
                    
                     
                  }
               }
            }else if($GETEMPC == $EMPC2) {
               if(($POS2=='พนักงานขับรถ/ปลอกเขียว') || ($POS2=='พนักงานขับรถ/ปลอกเหลือง')){
                  $C3PLUS='0';
                  $C3MINUS='0';
                  $CALC3='0';
                  $plus = '0';
                  $plus_format = number_format($plus);
                  $plus_re = str_replace(",","",$plus_format);   
                  $minus = '0';
                  $minus_format = number_format($minus);
                  $minus_re = str_replace(",","",$minus_format);
                  $COMPENSATION = '0';
                  $COMPENSATION_OTHER = '0';
               }else{
                  $C3PLUS=number_format($result_seComp['C3PLUS'], 2);
                  $C3MINUS=number_format($result_seComp['C3MINUS'], 2);
                  $CALC3=number_format(($result_seComp['C3PLUS'] - $result_seComp['C3MINUS']), 2);
                  $plus = $result_seComp['C3PLUS'];
                  $plus_format = number_format($plus);
                  $plus_re = str_replace(",","",$plus_format);   
                  $minus = $result_seComp['C3MINUS'];
                  $minus_format = number_format($minus);
                  $minus_re = str_replace(",","",$minus_format);
                  if ($GETEMPC == $result_seComp['EMPLOYEECODE1']) {
                        // ถ้าแผนงาน โดนตัดงาน ในวันเดียวกัน
                        // CASE 1 : วิ่งงาน 1 แผนงานและโดนตัดงานจะได้ 200 บาท
                        // CASR 2 : วิ่งงานมากกว่า 1 แผนงาน และ โดนตัดงานทั้งคู่ วันนั้นจะได้แค่ 200 บาท
                        // CASE 3 : วิ่งงานมากกกว่า 1 แผนงาน และ โดนตัดงานแค่ 1 แผนงาน แต่แผนงานอื่นๆไม่โดนตัดงานจะได้ค่าเที่ยวปกติ
                        if ($result_seComp['CWORKROW'] >= '1') {
                           if (($result_seComp['CWORKROW'] == '1' && $result_seComp['STATUSNUMBER'] == 'X') || ($result_seComp['CWORKROW'] > '1' && $result_seComp['STATUSNUMBER'] == 'X')) {
                              if ($result_seComp['CWORKROW'] == '1') {
                                 $COMPENSATION = '200';
                                 $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD2'];
                              }else{
                                 $COMPENSATION = '';
                                 $COMPENSATION_OTHER = '';
                              }
                              
                           }else{
                              // CASE 3 : วิ่งงานมากกกว่า 1 แผนงาน และ โดนตัดงานแค่ 1 แผนงาน แต่แผนงานอื่นๆไม่โดนตัดงานจะได้ค่าเที่ยวปกติ
                              if ($result_seComp['STATUSNUMBER'] == 'X') {
                                 $COMPENSATION = '';
                                 $COMPENSATION_OTHER = '';
                              }else{
                                 $COMPENSATION = $result_seCompensation1['COMPENSATION1'];
                                 $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD2'];
                              }
                              // $COMPENSATION = '666';
                              // $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD2'];   
                           }
                        
                        }else{
                           $COMPENSATION = $result_seCompensation1['COMPENSATION1'];
                           $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD2'];
                        }
                        
                     
                     
                  } else if ($GETEMPC == $result_seComp['EMPLOYEECODE2']) {
                        // ถ้าแผนงาน โดนตัดงาน ในวันเดียวกัน
                        // CASE 1 : วิ่งงาน 1 แผนงานและโดนตัดงานจะได้ 200 บาท
                        // CASR 2 : วิ่งงานมากกว่า 1 แผนงาน และ โดนตัดงานทั้งคู่ วันนั้นจะได้แค่ 200 บาท
                        // CASE 3 : วิ่งงานมากกกว่า 1 แผนงาน และ โดนตัดงานแค่ 1 แผนงาน แต่แผนงานอื่นๆไม่โดนตัดงานจะได้ค่าเที่ยวปกติ
                        if ($result_seComp['CWORKROW'] >= '1') {
                           if (($result_seComp['CWORKROW'] == '1' && $result_seComp['STATUSNUMBER'] == 'X') || ($result_seComp['CWORKROW'] > '1' && $result_seComp['STATUSNUMBER'] == 'X')) {
                              if ($result_seComp['CWORKROW'] == '1') {
                                 $COMPENSATION = '200';
                                 $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD5']+$result_seCompensation1['SELECT_8LOAD2'];
                              }else{
                                 $COMPENSATION = '';
                                 $COMPENSATION_OTHER = '';
                              }
                              
                           }else{
                              // CASE 3 : วิ่งงานมากกกว่า 1 แผนงาน และ โดนตัดงานแค่ 1 แผนงาน แต่แผนงานอื่นๆไม่โดนตัดงานจะได้ค่าเที่ยวปกติ
                              if ($result_seComp['STATUSNUMBER'] == 'X') {
                                 $COMPENSATION = '';
                                 $COMPENSATION_OTHER = '';
                              }else{
                                 $COMPENSATION = $result_seCompensation1['COMPENSATION2'];
                                 $COMPENSATION_OTHER = $result_seCompensation1['SELECT_8LOAD2'];
                                 // $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD5']+$result_seCompensation1['SELECT_8LOAD2'];
                              }
                              // $COMPENSATION = '666';
                              // $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD2'];   
                           }
                        
                        }else{
                           $COMPENSATION = $result_seCompensation1['COMPENSATION2'];
                           $COMPENSATION_OTHER = $result_seCompensation1['SELECT_4LOAD5']+$result_seCompensation1['SELECT_8LOAD2'];
                        }
                        
                     
                     
                  }
               }
            }
         }
      
      $td .= '<tr style="border:1px solid #000;" >
      <td  style="border-right:1px solid #000;padding:3px;text-align:center;">' . $i. '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . $result_seComp['DATEWORKING'] . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . $result_seComp['JOBSTART'] . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . $result_seComp['JOBEND'] . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . $result_seComp['THAINAME'] . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seComp['MILEAGESTART']) . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seComp['MILEAGEEND']) . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($result_seComp['MILEAGEEND'] - $result_seComp['MILEAGESTART']) . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . ($result_seComp['O4'] == '' ? '0':$result_seComp['O4']). '</td>            
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . ($OILAVERAGE == '' ? '0': $OILAVERAGE). '</td>   
      <td  style="border-right:1px solid #000;padding:3px;text-align:center;">' . $C3PLUS . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:center;">' . $C3MINUS . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:center;">' . $CALC3 . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:center;">' . ($result_sePallet['PALLET'] =='' ? '0':$result_sePallet['PALLET']) . '</td> 
      <td  style="border-right:1px solid #000;padding:3px;text-align:center;">' . ($result_sePallet['PALLET'] =='' ? '0':$result_sePallet['PALLET']*5) . '</td>  
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . number_format($COMPENSATIONEMPLY) . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . ($TRAINNER == '' ? '0':$TRAINNER) . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . ($OJT == '' ? '0':$OJT) . '</td> 
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . ($MULTISKILL == '' ? '0':$MULTISKILL) . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . ($COMPENSATION == '' ? '':number_format($COMPENSATION, 0)) . '</td>   
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . ($COMPENSATION == '' ? '':number_format($COMPENSATION+$COMPENSATION_OTHER+$COMPENSATIONEMPLY+($result_sePallet['PALLET']*5)+$TRAINNER+$OJT+$MULTISKILL, 0)) . '</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">-</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">-</td>
      <td  style="border-right:1px solid #000;padding:3px;text-align:left;">' . ($result_seComp['STATUSNUMBER'] == 'X' ? 'แผนงานตัดงาน':$result_seCompensation1['PAY_CONDITION'])  . '</td>
   </tr>';



         // $rsmileagestart = $rsmileagestart + $result_seComp['MILEAGESTART'];
         // $rsmileageend = $rsmileageend + $result_seComp['MILEAGEEND'];
         $rsc3plus               = $rsc3plus + $C3PLUS;
         $rsc3minus              = $rsc3minus + $C3MINUS;
         $rsmileagestartend      = $rsmileagestartend + ($result_seComp['MILEAGEEND'] - $result_seComp['MILEAGESTART']);
         $rscompo4               = $rscompo4 + $result_seComp['O4'];
         $rscompensation         = $rscompensation + $COMPENSATION;
         $rscompensationemply    = $rscompensationemply + $COMPENSATIONEMPLY;
         $rspayrepair            = $rspayrepair + $result_seCompensation1['PAY_REPAIR'];
         $rspayother             = $rspayother + ($COMPENSATION_OTHER);
         $rstrainer              = $rstrainer + $TRAINNER;
         $rsojt                  = $rsojt + $OJT;
         $rsmultiskills          = $rsmultiskills + $MULTISKILL;
         $rspallet               = $rspallet + $result_sePallet['PALLET'];
         $rspalletmoney          = ($rspallet*5);
         $resmoney               = ($plus_re) - (($minus_re) * -1);
         $allmoney               = $allmoney + $resmoney;
         $rscompensationall      = $rscompensation+$rspayother+$rscompensationemply+$rspalletmoney+$rstrainer+$rsojt+$rsmultiskills;
         $i++;
}else{


}

}

$table_end = '</tbody>
   <tfoot>
      <tr style="border:1px solid #000;" >
         <td colspan="5" style="border-right:1px solid #000;padding:3px;text-align:right;"><b>ยอดรวม</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b></b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b></b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>' . number_format($rsmileagestartend) . '</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>' . number_format($rscompo4, 2) . '</b></td>            
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>-</b></td>  
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>' . number_format($rsc3plus, 2) . '</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>' . number_format($rsc3minus, 2) . '</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>' . number_format($allmoney, 2) . '</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>' . number_format($rspallet) . '</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>' . number_format($rspalletmoney) . '</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>' . number_format($rscompensationemply) . '</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>' . number_format($rstrainer) . '</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>' . number_format($rsojt) . '</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>' . number_format($rsmultiskills) . '</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>' . number_format($rscompensation, 2) . '</b></td>  
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>' . number_format($rscompensationall, 2) . '</b></td>   
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>-</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>-</b></td>
         <td style="border-right:1px solid #000;padding:3px;text-align:left;"><b>-</b></td>
      </tr>
   </tfoot>
</table>';

$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_begin);

if (substr($_GET['employeecode'], 0, 2) == '07') {
    $mpdf->WriteHTML($trrkl);
}
if (substr($_GET['employeecode'], 0, 2) == '01' || substr($_GET['employeecode'], 0, 2) == '10') {
    $mpdf->WriteHTML($trrkr);
}
if (substr($_GET['employeecode'], 0, 2) == '02') {
    $mpdf->WriteHTML($trrks);
}
if (substr($_GET['employeecode'], 0, 2) == '08') {
    $mpdf->WriteHTML($trrks);
}
$mpdf->WriteHTML($td);
$mpdf->WriteHTML($table_end);

$mpdf->Output();

sqlsrv_close($conn);
?>

