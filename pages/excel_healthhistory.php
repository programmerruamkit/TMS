<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$yearchk = $_GET['createyear']+543;

$strExcelFileName = "รายงานข้อมูลประวัติสุขภาพพนักงานประจำปี".$yearchk ."ตำแหน่ง".$_GET['position'] ." .xls";

header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");


?>
<style>
input.largerCheckbox {
  width: 20px;
  height: 20px;
}
</style>

<!-- ////////////////////////////////////////////////10W/STC///////////////////////////////////////////////// -->

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
  
  <table width="100%" style="border-collapse: collapse;margin-top:8px;">
  	<thead>
  	<tr>
  	    <th colspan ="25" bgcolor="#CCCCCC" style="text-align: center;border:1px solid #000;padding:4px;" >รายงานข้อมูลประวัติสุขภาพพนักงานประจำปี <?=$_GET['createyear']+543?></th>
  	</tr>
  	
  	<tr>

  	    <th style="text-align: center;border:1px solid #000;padding:4px;" rowspan="2">ลำดับ</th>
  	    <th style="text-align: center;border:1px solid #000;padding:4px;" rowspan="2">รหัสพนักงาน</th>
		<th style="text-align: center;border:1px solid #000;padding:4px;" rowspan="2">ชื่อ-สกุล</th>
  	    <th style="text-align: center;border:1px solid #000;padding:4px;" rowspan="2">เพศ</th>
		<th style="text-align: center;border:1px solid #000;padding:4px;" rowspan="2">อายุ</th>
  	    <th style="text-align: center;border:1px solid #000;padding:4px;" rowspan="2">กรุ๊ปเลือด</th>
		<th style="text-align: center;border:1px solid #000;padding:4px;" rowspan="2">บริษัท</th>
  	    <th style="text-align: center;border:1px solid #000;padding:4px;" colspan="6">โรค/ความเจ็บป่วย</th>
		<th style="text-align: center;border:1px solid #000;padding:4px;" colspan="11">สายตา</th>
  	    <th style="text-align: center;border:1px solid #000;padding:4px;" rowspan="2" >โรคอื่นๆ</th>
  	</tr>
  	<tr>
  	    <th style="text-align: center;border:1px solid #000;">เบาหวาน</th>
  	    <th style="text-align: center;border:1px solid #000;">ความดันโลหิตสูง</th>
  	    <th style="text-align: center;border:1px solid #000;">ความดันโลหิตต่ำ</th>
		<th style="text-align: center;border:1px solid #000;">โรคหัวใจ</th>
  	    <th style="text-align: center;border:1px solid #000;">ลมชัก/ลมบ้าหมู</th>
  	    <th style="text-align: center;border:1px solid #000;">ผ่าตัดสมอง</th>
		<th style="text-align: center;border:1px solid #000;">สั้น</th>
        <th style="text-align: center;border:1px solid #000;">สั้น(ขวา)</th>
        <th style="text-align: center;border:1px solid #000;">สั้น(ซ้าย)</th>
		<th style="text-align: center;border:1px solid #000;">ยาว</th>
		<th style="text-align: center;border:1px solid #000;">ยาว(ขวา)</th>
		<th style="text-align: center;border:1px solid #000;">ยาว(ซ้าย)</th>
  	    <th style="text-align: center;border:1px solid #000;">เอียง</th>
		<th style="text-align: center;border:1px solid #000;">เอียง(ขวา)</th>
		<th style="text-align: center;border:1px solid #000;">เอียง(ซ้าย)</th>
  	    <th style="text-align: center;border:1px solid #000;">ตาบอดสี(ปกติ)</th>
        <th style="text-align: center;border:1px solid #000;">ตาบอดสี(ผิดปกติ)</th>
  	</tr>
	  
  	  </thead><tbody>
        <?php
            $i = 1;
            if ($_GET['position'] == 'not select') {
                $sql_seData = "SELECT  EMPLOYEECODE AS 'EMPCODE',b.FnameT,b.LnameT,b.PositionNameT
                            FROM HEALTHHISTORY a
                            INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a.EMPLOYEECODE
                            WHERE  SUBSTRING(EMPLOYEECODE, 1, 2) ='".$_GET['companycode']."'
                            AND CREATEYEAR ='".$_GET['createyear']."' 
                            ORDER BY b.PersonCode ASC";
                $params_seData = array();
                $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
            }else {
                $sql_seData = "SELECT  EMPLOYEECODE AS 'EMPCODE',b.FnameT,b.LnameT,b.PositionNameT
                            FROM HEALTHHISTORY a
                            INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a.EMPLOYEECODE
                            WHERE  SUBSTRING(EMPLOYEECODE, 1, 2) ='".$_GET['companycode']."'
                            AND PositionNameT ='".$_GET['position']."'
                            AND CREATEYEAR ='".$_GET['createyear']."' 
                            ORDER BY b.PersonCode ASC";
                $params_seData = array();
                $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
            }
           
     while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)){

            
          
            $sql_seEmpData = "SELECT a.PersonCode,a.FnameT,a.LnameT,(a.FnameT+' '+a.LnameT) AS nameT,  
                a.FnameE, a.LnameE,(a.FnameE+' '+a.LnameE) AS nameE,(YEAR(GETDATE())-YEAR(a.BirthDate)) AS 'Age',
                a.SexID,a.SexT,b.BloodID,
                CASE
                WHEN SUBSTRING(a.PersonCode, 1, 2) ='01' THEN 'RKR'
                WHEN SUBSTRING(a.PersonCode, 1, 2) ='02' THEN 'RKS'
                WHEN SUBSTRING(a.PersonCode, 1, 2) ='04' THEN 'RCC'
                WHEN SUBSTRING(a.PersonCode, 1, 2) ='05' THEN 'RRC'
                WHEN SUBSTRING(a.PersonCode, 1, 2) ='06' THEN 'RTD'
                WHEN SUBSTRING(a.PersonCode, 1, 2) ='07' THEN 'RKL'
                WHEN SUBSTRING(a.PersonCode, 1, 2) ='08' THEN 'RTC'
                WHEN SUBSTRING(a.PersonCode, 1, 2) ='09' THEN 'RATC'
                WHEN SUBSTRING(a.PersonCode, 1, 2) ='10' THEN 'RIT'
                ELSE 'ER'
                END AS 'EMPCOM'
                FROM EMPLOYEEEHR2 a
                INNER JOIN [EMPLOYEEDETAILEHR] b ON b.PersonID = a.PersonID
                AND PersonCode ='" . $result_seData['EMPCODE'] . "'";
            $params_seEmpData = array();
            $query_seEmpData = sqlsrv_query($conn, $sql_seEmpData, $params_seEmpData);
            $result_seEmpData = sqlsrv_fetch_array($query_seEmpData, SQLSRV_FETCH_ASSOC);  
          
            $sql_seHealthData = "SELECT  TOP 1 ID,DIABETES,HIGHTBLOODPRESSURE,LOWBLOODPRESSURE,
                        HEARTDISEASE, EPILEPPSY, BRAINSURGERY, SHORTSIGHT,SHORTSIGHT_R,SHORTSIGHT_L,LONGSIGHT,LONGSIGHT_R,LONGSIGHT_L,
                        OBLIQUESIGHT,OBLIQUESIGHT_R,OBLIQUESIGHT_L,COLORBLIND_OK,COLORBLIND_NG,OTHERDISEASE1,OTHERDISEASE2,OTHERDISEASE3,
                        OTHERDISEASE4,OTHERDISEASE5,OTHERDISEASE6,CREATEDATE
                        FROM [dbo].[HEALTHHISTORY]
                        WHERE EMPLOYEECODE ='" . $result_seData['EMPCODE'] . "'
                        AND CREATEYEAR ='" . $_GET['createyear'] . "'
                        AND ACTIVESTATUS ='1'
                        ORDER BY CREATEDATE DESC";
            $params_seHealthData = array();
            $query_seHealthData = sqlsrv_query($conn, $sql_seHealthData, $params_seHealthData);
            $result_seHealthData = sqlsrv_fetch_array($query_seHealthData, SQLSRV_FETCH_ASSOC);

            //BloodTyPE ข้อมูลอิงตาม [dbo].[PNM_Blood] ของ EHR
            if ($result_seEmpData['BloodID'] == '1') {
                $BloodType ='-';
            }else if ($result_seEmpData['BloodID'] == '2') {
                $BloodType ='O';
            }else if ($result_seEmpData['BloodID'] == '3') {
                $BloodType ='A';
            }else if ($result_seEmpData['BloodID'] == '4') {
                $BloodType ='B';
            }else if ($result_seEmpData['BloodID'] == '5') {
                $BloodType ='AB';
            }else{
                $BloodType ='-';
            }
  	        
            ?>
  	    <tr style="">
  	        <td style="border:1px solid #000;border-left:1px solid #000;padding:4px;text-align:center;"><?=$i?></td>
  	        <td style="border:1px solid #000;padding:4px;text-align:center;"><?=$result_seEmpData['PersonCode']?></td>
  	        <td style="border:1px solid #000;padding:4px;text-align:center;"><?=$result_seEmpData['nameT']?></td>
  	        <td style="border:1px solid #000;padding:4px;text-align:center;"><?=$result_seEmpData['SexT']?></td>
  	        <td style="border:1px solid #000;padding:4px;text-align:center;"><?=$result_seEmpData['Age']?></td>
			<td style="border:1px solid #000;padding:4px;text-align:center;"><?=$BloodType?></td>
  	        <td style="border:1px solid #000;padding:4px;text-align:center;"><?=$result_seEmpData['EMPCOM']?></td>

            <!--เบาหวาน -->
            <?php
            if ($result_seHealthData['DIABETES'] == '1') {
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;">&#9899;</td>
            <?php
            }else{
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"></td>
            <?php
            }
            ?>
			
            <!--ความดันโลหิตต่ำ -->
            <?php
            if ($result_seHealthData['LOWBLOODPRESSURE'] == '1') {
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;">&#9899;</td>
            <?php
            }else{
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"></td>
            <?php
            }
            ?>

            <!--ความดันโลหิตสูง -->
            <?php
            if ($result_seHealthData['HIGHTBLOODPRESSURE'] == '1') {
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;">&#9899;</td>
            <?php
            }else{
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"></td>
            <?php
            }
            ?>

            <!--โรคหัวใจ -->
            <?php
            if ($result_seHealthData['HEARTDISEASE'] == '1') {
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;">&#9899;</td>
            <?php
            }else{
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"></td>
            <?php
            }
            ?>

            <!--ลมชัก/ลมบ้าหมู -->
            <?php
            if ($result_seHealthData['EPILEPPSY'] == '1') {
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;">&#9899;</td>
            <?php
            }else{
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"></td>
            <?php
            }
            ?>

            <!--ผ่าตัดสมอง -->
            <?php
            if ($result_seHealthData['BRAINSURGERY'] == '1') {
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;">&#9899;</td>
            <?php
            }else{
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"></td>
            <?php
            }
            ?>

            <!--สายตาสั้น -->
            <?php
            if ($result_seHealthData['SHORTSIGHT'] == '1') {
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;">&#9899;</td>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"><?=$result_seHealthData['SHORTSIGHT_R']?></td>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"><?=$result_seHealthData['SHORTSIGHT_L']?></td>
            <?php
            }else{
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"></td>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"></td>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"></td>
            <?php
            }
            ?>
            
            <!--สายตายาว -->
            <?php
            if ($result_seHealthData['LONGSIGHT'] == '1') {
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;">&#9899;</td>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"><?=$result_seHealthData['LONGSIGHT_R']?></td>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"><?=$result_seHealthData['LONGSIGHT_L']?></td>
            <?php
            }else{
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"></td>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"></td>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"></td>
            <?php
            }
            ?>

            <!--สายตาเอียง -->
            <?php
            if ($result_seHealthData['OBLIQUESIGHT'] == '1') {
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;">&#9899;</td>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"><?=$result_seHealthData['OBLIQUESIGHT_R']?></td>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"><?=$result_seHealthData['OBLIQUESIGHT_L']?></td>
            <?php
            }else{
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"></td>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"></td>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"></td>
            <?php
            }
            ?>

            <!--ตาบอดสีปกติ -->
            <?php
            if ($result_seHealthData['COLORBLIND_OK'] == '1') {
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;">&#9899;</td>
                
            <?php
            }else{
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"></td>
            <?php
            }
            ?>
            
            <!--ตาบอดสีผิดปกติ -->
            <?php
            if ($result_seHealthData['COLORBLIND_NG'] == '1') {
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;">&#9899;</td>
                
            <?php
            }else{
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"></td>
            <?php
            }
            ?>

            <!--โรคอื่นๆ -->
            <?php
            if ($result_seHealthData['OTHERDISEASE1'] == '' ||$result_seHealthData['OTHERDISEASE1'] == NULL) {
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"></td>
                
            <?php
            }else{
            ?>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-size:18px;font-weight:bold;"><?=$result_seHealthData['OTHERDISEASE1']?>,<?=$result_seHealthData['OTHERDISEASE2']?>,<?=$result_seHealthData['OTHERDISEASE3']?>,<?=$result_seHealthData['OTHERDISEASE4']?>,<?=$result_seHealthData['OTHERDISEASE5']?>,<?=$result_seHealthData['OTHERDISEASE6']?></td>
            <?php
            }
            ?>
                
  	      </tr>
		 
  <?php
  $i++;
  }
  ?>

  	   </tbody>
  	  
  	</table>
    

</body>
</html>
