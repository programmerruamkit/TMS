<?php

require_once("../class/meg_function.php");
date_default_timezone_set("Asia/Bangkok");
ini_set('display_errors', 0);
set_time_limit(0);
$conn = connect("RTMS");
// set_time_limit(2500);
// ini_set('max_execution_time', 2500);
// set_time_limit(0);
// ini_set('memory_limit', '128M');

// set_time_limit(0);







$strDate = $_GET['monthname'];
function DateThai($strDate)
{
$strMonth= date("n",strtotime($strDate));
$strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$strMonthThai=$strMonthCut[$strMonth];
return "$strMonthThai";
}



$month = $_GET['month'];
$years = $_GET['years'];

$strExcelFileName = "รายงานค่าอาหาร".$_GET['position']."วันที่".$_GET['datestart'] ." ถึง ".$_GET['dateend'] .".xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");


?>


<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>


<!-- <table width="100%" >
<tbody>
   <tr>
      <td colspan="8" style="text-align:center;font-size:24px"><b>ข้อมูลรายงานค่าอาหารรวม</b></td>
   </tr>
   <tr>
      <td colspan="8" style="text-align:center;font-size:24px"><b>ประจำวันที่ <?= $_GET['datestart'] ?> ถึง <?= $_GET['dateend'] ?></b></td>
   </tr>
</tbody>
</table> -->

<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
<thead>
        <!-- <tr style="border:1px solid #000;" >
            <td colspan="8" style="border-right:1px solid #000;padding:3px;text-align:left;">
                <b>แผนก <?= $depsec ?></b>
            </td>

        </tr> -->
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td rowspan="" colspan="1"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ลำดับ</b>
            </td>
            <td rowspan="" colspan="1"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>รหัสพนักงาน</b>
            </td>
            <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ชื่อ-สกุล</b>
            </td>
            <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วัน/เดือน/ปี</b>
            </td>
            <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วันทำงานตามปฎิทิน(EHR)</b>
            </td>
            <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วันหยุด</b>
            </td>
            <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วันลา</b>
            </td>
            <!-- <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วันสาย</b>
            </td> -->
            <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วันอาทิตย์</b>
            </td>
            <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วันทำงานจริง(แสกนนิ้วเข้า)</b>
            </td>
            <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วันทำงานจริง(แสกนนิ้วออก)</b>
            </td>
            <!-- <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>แสกนนิ้วเข้างานผิด</b>
            </td>
            <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>แสกนนิ้วหลังเลิกงานผิด</b>
            </td>
            <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>กะงาน</b>
            </td> -->
            <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วิ่งงาน</b>
            </td>
            <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ค่าอาหาร</b>
            </td>
            <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>หมายเหตุ</b>
            </td>
        </tr>

    </thead>
<?php

$i1 = 0;
$i2 = 1;
$sumpallet = "";
$sumcompen = "";
$sumall = "";
$sumresult = "";

    //นับวันที่ตามเดือนนั้นๆ นับจาก StartDate
    $sql_secountdate = "SELECT DATEDIFF(DAY, CONVERT(DATE,'" . $_GET['datestart'] . "',103), DATEADD(month, 1, CONVERT(DATE,'" . $_GET['datestart'] . "',103))) AS 'COUNTDATE'";
    $query_secountdate   = sqlsrv_query($conn, $sql_secountdate, $params_secountdate);
    $result_secountdate  = sqlsrv_fetch_array($query_secountdate, SQLSRV_FETCH_ASSOC);

     //นับวันที่ตามช่วงเวลาที่เลือก ไม่นับวันอาทิตย์ (วันที่ในเดือนนั้นๆ)
     $sql_seDatemonth = "SELECT
     (DATEDIFF(dd, CONVERT(DATE,'".$_GET['datestart']."',103), CONVERT(DATE,'".$_GET['dateend']."',103)) + 1)
     -(DATEDIFF(wk, CONVERT(DATE,'".$_GET['datestart']."',103), CONVERT(DATE,'".$_GET['dateend']."',103)) * 1)
     -(CASE WHEN DATENAME(dw, CONVERT(DATE,'".$_GET['datestart']."',103)) = 'Sunday' THEN 1 ELSE 0 END)
     -(CASE WHEN DATENAME(dw, CONVERT(DATE,'".$_GET['dateend']."',103))= 'Sunday' THEN 1 ELSE 0 END) AS 'DATEMONTH'";
     $query_seDatemonth  = sqlsrv_query($conn, $sql_seDatemonth, $params_seDatemonth);
     $result_seDatemonth = sqlsrv_fetch_array($query_seDatemonth, SQLSRV_FETCH_ASSOC);

     //นับวันหยุดใน EHR
     $sql_seHoliday = "SELECT COUNT( DISTINCT(Holiday_Date)) AS 'Holiday' FROM [203.150.225.30].[TigerE-HR].[dbo].[TAM_Holiday]
     WHERE CONVERT(DATE,Holiday_Date,103) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)";
     $query_seHoliday   = sqlsrv_query($conn, $sql_seHoliday, $params_seHoliday);
     $result_seHoliday  = sqlsrv_fetch_array($query_seHoliday, SQLSRV_FETCH_ASSOC);

    //  echo $result_seDatemonth['DATEMONTH'];
    //  echo "<br>";
    //  echo $result_seHoliday['Holiday'];
    //  echo "<br>";

     $dateworkingEHR = $result_seDatemonth['DATEMONTH'] - $result_seHoliday['Holiday'];

    //  echo $dateworkingEHR;

    //เช็ควันที่ Holiday
     $sql_seHolidaychk = "SELECT COUNT( DISTINCT(Holiday_Date)) AS 'Holiday' FROM [203.150.225.30].[TigerE-HR].[dbo].[TAM_Holiday]
        WHERE CONVERT(DATE,Holiday_Date,103) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)";
     $query_seHolidaychk   = sqlsrv_query($conn, $sql_seHolidaychk, $params_seHolidaychk);
     $result_seHolidaychk  = sqlsrv_fetch_array($query_seHolidaychk, SQLSRV_FETCH_ASSOC);



     if ($_GET['area'] == 'amata') {
         
        if ($_GET['position'] == 'Senior Driver/Kubota' || $_GET['position'] == 'พนักงานขับรถ/KUBOTA') {
            $sql_sePlan = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,d.PersonID,d.CompanyID,
                a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT,d.PositionNameT
                FROM [dbo].[ORGANIZATION] a 
                INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
                INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
                INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
                WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE ='03'
                AND a.AREA ='amata'
                AND d.EndDate IS NULL
                --AND a.EMPLOYEECODE IN ('070228')
                AND d.PositionNameT IN ('Senior Driver/Kubota','พนักงานขับรถ/KUBOTA')
                AND d.PositionNameT NOT IN ('เจ้าหน้าที่','เจ้าหน้าที่อาวุโส','ผู้จัดการ','หัวหน้างาน','Controller','Dispatcher')
                ORDER BY d.PositionNameT,a.EMPLOYEECODE ASC";
         }else if($_GET['position'] == 'พนักงานขับรถ/STM-SR' || $_GET['position'] == 'พนักงานขับรถ/STM-TAW' || $_GET['position'] == 'พนักงานขับรถ/SWN') {
            $sql_sePlan = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,d.PersonID,d.CompanyID,
                a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT,d.PositionNameT
                FROM [dbo].[ORGANIZATION] a 
                INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
                INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
                INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
                WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE ='03'
                AND a.AREA ='amata'
                AND d.EndDate IS NULL
                AND d.PositionNameT IN ('พนักงานขับรถ/STM-SR','พนักงานขับรถ/STM-TAW','พนักงานขับรถ/SWN')
                AND d.PositionNameT NOT IN ('เจ้าหน้าที่','เจ้าหน้าที่อาวุโส','ผู้จัดการ','หัวหน้างาน','Controller','Dispatcher')
                ORDER BY d.PositionNameT,a.EMPLOYEECODE ASC";
         }else {
            $sql_sePlan = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,d.PersonID,d.CompanyID,
                a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT,d.PositionNameT
                FROM [dbo].[ORGANIZATION] a 
                INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
                INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
                INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
                WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE ='03'
                AND a.AREA ='amata'
                AND d.EndDate IS NULL
                AND d.PositionNameT IN ('".$_GET['position']."')
                AND d.PositionNameT NOT IN ('เจ้าหน้าที่','เจ้าหน้าที่อาวุโส','ผู้จัดการ','หัวหน้างาน','Controller','Dispatcher')
                ORDER BY d.PositionNameT,a.EMPLOYEECODE ASC";
         }
            
        }else{
            $sql_sePlan = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,d.PersonID,d.CompanyID,
                a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT,d.PositionNameT
                FROM [dbo].[ORGANIZATION] a 
                INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
                INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
                INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
                WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE ='03'
                AND a.AREA ='gateway'
                AND d.EndDate IS NULL
                AND d.PositionNameT NOT IN ('เจ้าหน้าที่','เจ้าหน้าที่อาวุโส','ผู้จัดการ','หัวหน้างาน','Controller','Dispatcher')
                ORDER BY d.PositionNameT,a.EMPLOYEECODE ASC";
        }
    $query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
    while($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)){

         // วันที่ TAM_Work หา กะการทำงาน
        $sql_seTam_Work = "SELECT ID_Work,Work_Year,work_Month,PersonID,
            DS1,DS2,DS3,DS4,DS5,DS6,DS7,DS8,DS9,DS10,
            DS11,DS12,DS13,DS14,DS15,DS16,DS17,DS18,DS19,DS20,
            DS21,DS22,DS23,DS24,DS25,DS26,DS27,DS28,DS29,DS30,DS31
            FROM [203.150.225.30].[TigerE-HR].[dbo].[TAM_Work]    
            WHERE PersonID ='".$result_sePlan['PersonID']."' AND work_Month ='".$month."' AND Work_Year ='".$years."'";
        $query_seTam_Work = sqlsrv_query($conn, $sql_seTam_Work, $params_seTam_Work);
        $result_seTam_Work = sqlsrv_fetch_array($query_seTam_Work, SQLSRV_FETCH_ASSOC);   


        $sql_seHolidaychk = "SELECT  CONVERT(VARCHAR(10),Holiday_Date,103) AS 'Holiday',Holiday_Note
            FROM [203.150.225.30].[TigerE-HR].[dbo].[TAM_Holiday]
            WHERE CONVERT(DATE,Holiday_Date,103) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
            AND ID_Company ='".$result_sePlan['CompanyID']."'";
        $query_seHolidaychk   = sqlsrv_query($conn, $sql_seHolidaychk, $params_seHolidaychk);
        while($result_seHolidaychk  = sqlsrv_fetch_array($query_seHolidaychk, SQLSRV_FETCH_ASSOC)){


            if ($result_seHolidaychk['Holiday'] == "01"."/".$month."/".$years) {
                $holiday1 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday1 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "02"."/".$month."/".$years) {
                $holiday2 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday2 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "03"."/".$month."/".$years) {
                $holiday3 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday3 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "04"."/".$month."/".$years) {
                $holiday4 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday4 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "05"."/".$month."/".$years) {
                $holiday5 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday5 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "06"."/".$month."/".$years) {
                $holiday6 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday6 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "07"."/".$month."/".$years) {
                $holiday7 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday7 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "08"."/".$month."/".$years) {
                $holiday8 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday8 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "09"."/".$month."/".$years) {
                $holiday9 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday9 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "10"."/".$month."/".$years) {
                $holiday10 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday10 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "11"."/".$month."/".$years) {
                $holiday11 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday11 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "12"."/".$month."/".$years) {
                $holiday12 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday12 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "13"."/".$month."/".$years) {
                $holiday13 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday13 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "14"."/".$month."/".$years) {
                $holiday14 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday14 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "15"."/".$month."/".$years) {
                $holiday15 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday15 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "16"."/".$month."/".$years) {
                $holiday16 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday16 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "17"."/".$month."/".$years) {
                $holiday17 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday17 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "18"."/".$month."/".$years) {
                $holiday18 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday18 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "19"."/".$month."/".$years) {
                $holiday19 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday19 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "20"."/".$month."/".$years) {
                $holiday20 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday20 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "21"."/".$month."/".$years) {
                $holiday21 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday21 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "22"."/".$month."/".$years) {
                $holiday22 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday22 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "23"."/".$month."/".$years) {
                $holiday23 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday23 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "24"."/".$month."/".$years) {
                $holiday24 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday24 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "25"."/".$month."/".$years) {
                $holiday25 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday25 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "26"."/".$month."/".$years) {
                $holiday26 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday26 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "27"."/".$month."/".$years) {
                $holiday27 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday27 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "28"."/".$month."/".$years) {
                $holiday28 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday28 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "29"."/".$month."/".$years) {
                $holiday29 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday29 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "30"."/".$month."/".$years) {
                $holiday30 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday30 = '1';
            }else if ($result_seHolidaychk['Holiday'] == "31"."/".$month."/".$years) {
                $holiday31 = 'วันหยุด'.($result_seHolidaychk['Holiday_Note']);
                $countholiday31 = '1';
            }else {

            }



        }
        $sumcountholiday = $countholiday12 + $countholiday2 + $countholiday3;

     


    // วันที่มาทำงานตามจริง (มาแสกนนิ้วเข้า) Status = IN 31 วัน
    $sql_seScanActual1in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'01/".$month."/".$years."',103)";
    $query_seScanActual1in = sqlsrv_query($conn, $sql_seScanActual1in, $params_seScanActual1in);
    $result_seScanActual1in = sqlsrv_fetch_array($query_seScanActual1in, SQLSRV_FETCH_ASSOC);
    
    //หาเวลาการทำงาน วันที่ 1 ตามแผนงาน
    $sql_seChk_Shift1 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'01/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift1 = sqlsrv_query($conn, $sql_seChk_Shift1, $params_seChk_Shift1);
    $result_seChk_Shift1 = sqlsrv_fetch_array($query_seChk_Shift1, SQLSRV_FETCH_ASSOC);
    
    $sql_seScanActual1out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'01/".$month."/".$years."',103)";
    $query_seScanActual1out = sqlsrv_query($conn, $sql_seScanActual1out, $params_seScanActual1out);
    $result_seScanActual1out = sqlsrv_fetch_array($query_seScanActual1out, SQLSRV_FETCH_ASSOC);
    
    //  //แสกน IN หลัง  (เลิกงาน)
    //  $sql_seScanINerror1 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'01/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '".$result_seChk_Shift1['TimeIn']."'";
    // $query_seScanINerror1 = sqlsrv_query($conn, $sql_seScanINerror1, $params_seScanINerror1);
    // $result_seScanINerror1 = sqlsrv_fetch_array($query_seScanINerror1, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน  (เข้างาน)
    // $sql_seScanOUTerror1 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'01/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '05:00'";
    // $query_seScanOUTerror1 = sqlsrv_query($conn, $sql_seScanOUTerror1, $params_seScanOUTerror1);
    // $result_seScanOUTerror1 = sqlsrv_fetch_array($query_seScanOUTerror1, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk1 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'01/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk1   = sqlsrv_query($conn, $sql_seLeavedaychk1, $params_seLeavedaychk1);
    $result_seLeavedaychk1  = sqlsrv_fetch_array($query_seLeavedaychk1, SQLSRV_FETCH_ASSOC);
        
    if ($result_seLeavedaychk1['Leave_Memo'] == '') {
        $leavechk1 = '0';
    }else {
        $leavechk1 = '1';
    }

    $sql_sesundaychk1 = "SELECT DATENAME(DW,CONVERT(DATE,'01/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk1   = sqlsrv_query($conn, $sql_sesundaychk1, $params_sesundaychk1);
    $result_sesundaychk1  = sqlsrv_fetch_array($query_sesundaychk1, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual1in['TIMESCANACTUALIN'] == '' || $result_seScanActual1in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift1['JOBNO'] != '')) {
        $checkworking1 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual1in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift1['JOBNO'] == '') && ($result_sesundaychk1['SUNDAY'] !='Sunday')){
        $checkworking1 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking1 = '';
    }

    // if ($result_seScanActual1in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk1 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk1['Leave_Memo'] == '') {
    //         $latechk1 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk1 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
/////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual2in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'02/".$month."/".$years."',103)";
    $query_seScanActual2in = sqlsrv_query($conn, $sql_seScanActual2in, $params_seScanActual2in);
    $result_seScanActual2in = sqlsrv_fetch_array($query_seScanActual2in, SQLSRV_FETCH_ASSOC);

    //หาเวลาการทำงาน วันที่ 2 ตามแผนงาน
    $sql_seChk_Shift2 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'02/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift2 = sqlsrv_query($conn, $sql_seChk_Shift2, $params_seChk_Shift2);
    $result_seChk_Shift2 = sqlsrv_fetch_array($query_seChk_Shift2, SQLSRV_FETCH_ASSOC);
    
    $sql_seScanActual2out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'02/".$month."/".$years."',103)";
    $query_seScanActual2out = sqlsrv_query($conn, $sql_seScanActual2out, $params_seScanActual2out);
    $result_seScanActual2out = sqlsrv_fetch_array($query_seScanActual2out, SQLSRV_FETCH_ASSOC);

    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror2 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'02/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror2 = sqlsrv_query($conn, $sql_seScanINerror2, $params_seScanINerror2);
    // $result_seScanINerror2 = sqlsrv_fetch_array($query_seScanINerror2, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror2 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'02/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror2 = sqlsrv_query($conn, $sql_seScanOUTerror2, $params_seScanOUTerror2);
    // $result_seScanOUTerror2 = sqlsrv_fetch_array($query_seScanOUTerror2, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk2 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'02/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk2   = sqlsrv_query($conn, $sql_seLeavedaychk2, $params_seLeavedaychk2);
    $result_seLeavedaychk2  = sqlsrv_fetch_array($query_seLeavedaychk2, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk2['Leave_Memo'] == '') {
        $leavechk2 = '0';
    }else {
        $leavechk2 = '1';
    }

    $sql_sesundaychk2 = "SELECT DATENAME(DW,CONVERT(DATE,'02/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk2   = sqlsrv_query($conn, $sql_sesundaychk2, $params_sesundaychk2);
    $result_sesundaychk2  = sqlsrv_fetch_array($query_sesundaychk2, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual2in['TIMESCANACTUALIN'] == '' || $result_seScanActual2in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift2['JOBNO'] != '')) {
        $checkworking2 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual2in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift2['JOBNO'] == '') && ($result_sesundaychk2['SUNDAY'] !='Sunday')){
        $checkworking2 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking2 = '';
    }
    // if ($result_seScanActual2in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk2 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk2['Leave_Memo'] == '') {
    //         $latechk2 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk2 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }

///////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual3in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'03/".$month."/".$years."',103)";
    $query_seScanActual3in = sqlsrv_query($conn, $sql_seScanActual3in, $params_seScanActual3in);
    $result_seScanActual3in = sqlsrv_fetch_array($query_seScanActual3in, SQLSRV_FETCH_ASSOC);

    //หาเวลาการทำงาน วันที่ 3 ตามแผนงาน
    $sql_seChk_Shift3 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'03/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift3 = sqlsrv_query($conn, $sql_seChk_Shift3, $params_seChk_Shift3);
    $result_seChk_Shift3 = sqlsrv_fetch_array($query_seChk_Shift3, SQLSRV_FETCH_ASSOC);
    
    $sql_seScanActual3out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'03/".$month."/".$years."',103)";
    $query_seScanActual3out = sqlsrv_query($conn, $sql_seScanActual3out, $params_seScanActual3out);
    $result_seScanActual3out = sqlsrv_fetch_array($query_seScanActual3out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror3 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'03/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror3 = sqlsrv_query($conn, $sql_seScanINerror3, $params_seScanINerror3);
    // $result_seScanINerror3 = sqlsrv_fetch_array($query_seScanINerror3, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror3 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'03/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror3 = sqlsrv_query($conn, $sql_seScanOUTerror3, $params_seScanOUTerror3);
    // $result_seScanOUTerror3 = sqlsrv_fetch_array($query_seScanOUTerror3, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk3 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'03/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk3   = sqlsrv_query($conn, $sql_seLeavedaychk3, $params_seLeavedaychk3);
    $result_seLeavedaychk3  = sqlsrv_fetch_array($query_seLeavedaychk3, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk3['Leave_Memo'] == '') {
        $leavechk3 = '0';
    }else {
        $leavechk3 = '1';
    }

    $sql_sesundaychk3 = "SELECT DATENAME(DW,CONVERT(DATE,'03/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk3   = sqlsrv_query($conn, $sql_sesundaychk3, $params_sesundaychk3);
    $result_sesundaychk3  = sqlsrv_fetch_array($query_sesundaychk3, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual3in['TIMESCANACTUALIN'] == '' || $result_seScanActual3in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift3['JOBNO'] != '')) {
        $checkworking3 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual3in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift3['JOBNO'] == '') && ($result_sesundaychk3['SUNDAY'] !='Sunday')){
        $checkworking3 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking3 = '';
    }

    // if ($result_seScanActual3in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk3 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk3['Leave_Memo'] == '') {
    //         $latechk3 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk3 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
///////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual4in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'04/".$month."/".$years."',103)";
    $query_seScanActual4in = sqlsrv_query($conn, $sql_seScanActual4in, $params_seScanActual4in);
    $result_seScanActual4in = sqlsrv_fetch_array($query_seScanActual4in, SQLSRV_FETCH_ASSOC);

    //หากะเวลาการทำงาน วันที่ 4
    $sql_seChk_Shift4 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'04/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift4 = sqlsrv_query($conn, $sql_seChk_Shift4, $params_seChk_Shift4);
    $result_seChk_Shift4 = sqlsrv_fetch_array($query_seChk_Shift4, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual4out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'04/".$month."/".$years."',103)";
    $query_seScanActual4out = sqlsrv_query($conn, $sql_seScanActual4out, $params_seScanActual4out);
    $result_seScanActual4out = sqlsrv_fetch_array($query_seScanActual4out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror4 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'04/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror4 = sqlsrv_query($conn, $sql_seScanINerror4, $params_seScanINerror4);
    // $result_seScanINerror4 = sqlsrv_fetch_array($query_seScanINerror4, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror4 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'04/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror4 = sqlsrv_query($conn, $sql_seScanOUTerror4, $params_seScanOUTerror4);
    // $result_seScanOUTerror4 = sqlsrv_fetch_array($query_seScanOUTerror4, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk4 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'04/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk4   = sqlsrv_query($conn, $sql_seLeavedaychk4, $params_seLeavedaychk4);
    $result_seLeavedaychk4  = sqlsrv_fetch_array($query_seLeavedaychk4, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk4['Leave_Memo'] == '') {
        $leavechk4 = '0';
    }else {
        $leavechk4 = '1';
    }

    $sql_sesundaychk4 = "SELECT DATENAME(DW,CONVERT(DATE,'04/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk4  = sqlsrv_query($conn, $sql_sesundaychk4, $params_sesundaychk4);
    $result_sesundaychk4  = sqlsrv_fetch_array($query_sesundaychk4, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual4in['TIMESCANACTUALIN'] == '' || $result_seScanActual4in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift4['JOBNO'] != '')) {
        $checkworking4 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual4in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift4['JOBNO'] == '') && ($result_sesundaychk4['SUNDAY'] !='Sunday')){
        $checkworking4 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking4 = '';
    }

    // if ($result_seScanActual4in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk4 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk4['Leave_Memo'] == '') {
    //         $latechk4 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk4 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }

///////////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual5in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'05/".$month."/".$years."',103)";
    $query_seScanActual5in = sqlsrv_query($conn, $sql_seScanActual5in, $params_seScanActual5in);
    $result_seScanActual5in = sqlsrv_fetch_array($query_seScanActual5in, SQLSRV_FETCH_ASSOC);

    //หากะเวลาการทำงาน วันที่ 5
    $sql_seChk_Shift5 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'05/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift5 = sqlsrv_query($conn, $sql_seChk_Shift5, $params_seChk_Shift5);
    $result_seChk_Shift5 = sqlsrv_fetch_array($query_seChk_Shift5, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual5out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'05/".$month."/".$years."',103)";
    $query_seScanActual5out = sqlsrv_query($conn, $sql_seScanActual5out, $params_seScanActual5out);
    $result_seScanActual5out = sqlsrv_fetch_array($query_seScanActual5out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror5 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'05/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror5 = sqlsrv_query($conn, $sql_seScanINerror5, $params_seScanINerror5);
    // $result_seScanINerror5 = sqlsrv_fetch_array($query_seScanINerror5, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror5 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'05/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror5 = sqlsrv_query($conn, $sql_seScanOUTerror5, $params_seScanOUTerror5);
    // $result_seScanOUTerror5 = sqlsrv_fetch_array($query_seScanOUTerror5, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk5 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'05/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk5   = sqlsrv_query($conn, $sql_seLeavedaychk5, $params_seLeavedaychk5);
    $result_seLeavedaychk5  = sqlsrv_fetch_array($query_seLeavedaychk5, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk5['Leave_Memo'] == '') {
        $leavechk5 = '0';
    }else {
        $leavechk5 = '1';
    }

    $sql_sesundaychk5 = "SELECT DATENAME(DW,CONVERT(DATE,'05/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk5   = sqlsrv_query($conn, $sql_sesundaychk5, $params_sesundaychk5);
    $result_sesundaychk5  = sqlsrv_fetch_array($query_sesundaychk5, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual5in['TIMESCANACTUALIN'] == '' || $result_seScanActual5in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift5['JOBNO'] != '')) {
        $checkworking5 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual5in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift5['JOBNO'] == '') && ($result_sesundaychk5['SUNDAY'] !='Sunday')){
        $checkworking5 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking5 = '';
    }

    // if ($result_seScanActual5in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk5 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk5['Leave_Memo'] == '') {
    //         $latechk5 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk5 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }

///////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual6in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'06/".$month."/".$years."',103)";
    $query_seScanActual6in = sqlsrv_query($conn, $sql_seScanActual6in, $params_seScanActual6in);
    $result_seScanActual6in = sqlsrv_fetch_array($query_seScanActual6in, SQLSRV_FETCH_ASSOC);
    
     //หากะเวลาการทำงาน วันที่ 6
    $sql_seChk_Shift6 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'06/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift6 = sqlsrv_query($conn, $sql_seChk_Shift6, $params_seChk_Shift6);
    $result_seChk_Shift6 = sqlsrv_fetch_array($query_seChk_Shift6, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual6out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'06/".$month."/".$years."',103)";
    $query_seScanActual6out = sqlsrv_query($conn, $sql_seScanActual6out, $params_seScanActual6out);
    $result_seScanActual6out = sqlsrv_fetch_array($query_seScanActual6out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror6 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'06/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror6 = sqlsrv_query($conn, $sql_seScanINerror6, $params_seScanINerror6);
    // $result_seScanINerror6 = sqlsrv_fetch_array($query_seScanINerror6, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror6 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'06/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror6 = sqlsrv_query($conn, $sql_seScanOUTerror6, $params_seScanOUTerror6);
    // $result_seScanOUTerror6 = sqlsrv_fetch_array($query_seScanOUTerror6, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk6 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'06/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk6   = sqlsrv_query($conn, $sql_seLeavedaychk6, $params_seLeavedaychk6);
    $result_seLeavedaychk6  = sqlsrv_fetch_array($query_seLeavedaychk6, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk6['Leave_Memo'] == '') {
        $leavechk6 = '0';
    }else {
        $leavechk6 = '1';
    }

    $sql_sesundaychk6 = "SELECT DATENAME(DW,CONVERT(DATE,'06/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk6   = sqlsrv_query($conn, $sql_sesundaychk6, $params_sesundaychk6);
    $result_sesundaychk6  = sqlsrv_fetch_array($query_sesundaychk6, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual6in['TIMESCANACTUALIN'] == '' || $result_seScanActual6in['TIMESCANACTUALIN'] != '' || $result_seScanActual6out['DATESCANACTUALOUT'] == '') && ($result_seChk_Shift6['JOBNO'] != '')) {
        $checkworking6 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual6in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift6['JOBNO'] == '') && ($result_sesundaychk6['SUNDAY'] !='Sunday')){
        $checkworking6 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking6 = '';
    }

    // if ($result_seScanActual6in['TIMESCANACTUALIN'] < '08:00:00' ) {
    //     $latechk6 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk6['Leave_Memo'] == '') {
    //         $latechk6 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk6 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }

    // echo $latechk6;
    // echo "<br>";
    // echo $result_seLeavedaychk6['Leave_Memo'];
//////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual7in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'07/".$month."/".$years."',103)";
    $query_seScanActual7in = sqlsrv_query($conn, $sql_seScanActual7in, $params_seScanActual7in);
    $result_seScanActual7in = sqlsrv_fetch_array($query_seScanActual7in, SQLSRV_FETCH_ASSOC);

     //หากะเวลาการทำงาน วันที่ 7
    $sql_seChk_Shift7 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'07/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift7 = sqlsrv_query($conn, $sql_seChk_Shift7, $params_seChk_Shift7);
    $result_seChk_Shift7 = sqlsrv_fetch_array($query_seChk_Shift7, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual7out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'07/".$month."/".$years."',103)";
    $query_seScanActual7out = sqlsrv_query($conn, $sql_seScanActual7out, $params_seScanActual7out);
    $result_seScanActual7out = sqlsrv_fetch_array($query_seScanActual7out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror7 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'07/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror7 = sqlsrv_query($conn, $sql_seScanINerror7, $params_seScanINerror7);
    // $result_seScanINerror7 = sqlsrv_fetch_array($query_seScanINerror7, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror7 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'07/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror7 = sqlsrv_query($conn, $sql_seScanOUTerror7, $params_seScanOUTerror7);
    // $result_seScanOUTerror7 = sqlsrv_fetch_array($query_seScanOUTerror7, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk7 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'07/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk7   = sqlsrv_query($conn, $sql_seLeavedaychk7, $params_seLeavedaychk7);
    $result_seLeavedaychk7  = sqlsrv_fetch_array($query_seLeavedaychk7, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk7['Leave_Memo'] == '') {
        $leavechk7 = '0';
    }else {
        $leavechk7 = '1';
    }

    $sql_sesundaychk7 = "SELECT DATENAME(DW,CONVERT(DATE,'07/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk7   = sqlsrv_query($conn, $sql_sesundaychk7, $params_sesundaychk7);
    $result_sesundaychk7  = sqlsrv_fetch_array($query_sesundaychk7, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual7in['TIMESCANACTUALIN'] == '' || $result_seScanActual7in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift7['JOBNO'] != '')) {
        $checkworking7 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual7in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift7['JOBNO'] == '') && ($result_sesundaychk7['SUNDAY'] !='Sunday')){
        $checkworking7 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking7 = '';
    }

    // if ($result_seScanActual7in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk7 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk7['Leave_Memo'] == '') {
    //         $latechk7 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk7 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
/////////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual8in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'08/".$month."/".$years."',103)";
    $query_seScanActual8in = sqlsrv_query($conn, $sql_seScanActual8in, $params_seScanActual8in);
    $result_seScanActual8in = sqlsrv_fetch_array($query_seScanActual8in, SQLSRV_FETCH_ASSOC);

     //หากะเวลาการทำงาน วันที่ 8
    $sql_seChk_Shift8 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'08/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift8 = sqlsrv_query($conn, $sql_seChk_Shift8, $params_seChk_Shift8);
    $result_seChk_Shift8 = sqlsrv_fetch_array($query_seChk_Shift8, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual8out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'08/".$month."/".$years."',103)";
    $query_seScanActual8out = sqlsrv_query($conn, $sql_seScanActual8out, $params_seScanActual8out);
    $result_seScanActual8out = sqlsrv_fetch_array($query_seScanActual8out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror8 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'08/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror8 = sqlsrv_query($conn, $sql_seScanINerror8, $params_seScanINerror8);
    // $result_seScanINerror8 = sqlsrv_fetch_array($query_seScanINerror8, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror8 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'08/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror8 = sqlsrv_query($conn, $sql_seScanOUTerror8, $params_seScanOUTerror8);
    // $result_seScanOUTerror8 = sqlsrv_fetch_array($query_seScanOUTerror8, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk8 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'08/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk8   = sqlsrv_query($conn, $sql_seLeavedaychk8, $params_seLeavedaychk8);
    $result_seLeavedaychk8  = sqlsrv_fetch_array($query_seLeavedaychk8, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk8['Leave_Memo'] == '') {
        $leavechk8 = '0';
    }else {
        $leavechk8 = '1';
    }

    $sql_sesundaychk8 = "SELECT DATENAME(DW,CONVERT(DATE,'08/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk8   = sqlsrv_query($conn, $sql_sesundaychk8, $params_sesundaychk8);
    $result_sesundaychk8  = sqlsrv_fetch_array($query_sesundaychk8, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual8in['TIMESCANACTUALIN'] == '' || $result_seScanActual8in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift8['JOBNO'] != '')) {
        $checkworking8 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual8in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift8['JOBNO'] == '') && ($result_sesundaychk8['SUNDAY'] !='Sunday')){
        $checkworking8 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking8 = '';
    }

    // if ($result_seScanActual8in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk8 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk8['Leave_Memo'] == '') {
    //         $latechk8 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk8 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
////////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual9in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'09/".$month."/".$years."',103)";
    $query_seScanActual9in = sqlsrv_query($conn, $sql_seScanActual9in, $params_seScanActual9in);
    $result_seScanActual9in = sqlsrv_fetch_array($query_seScanActual9in, SQLSRV_FETCH_ASSOC);

     //หากะเวลาการทำงาน วันที่ 9
    $sql_seChk_Shift9 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'09/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift9 = sqlsrv_query($conn, $sql_seChk_Shift9, $params_seChk_Shift9);
    $result_seChk_Shift9 = sqlsrv_fetch_array($query_seChk_Shift9, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual9out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'09/".$month."/".$years."',103)";
    $query_seScanActual9out = sqlsrv_query($conn, $sql_seScanActual9out, $params_seScanActual9out);
    $result_seScanActual9out = sqlsrv_fetch_array($query_seScanActual9out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror9 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'09/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror9 = sqlsrv_query($conn, $sql_seScanINerror9, $params_seScanINerror9);
    // $result_seScanINerror9 = sqlsrv_fetch_array($query_seScanINerror9, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror9 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'09/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror9 = sqlsrv_query($conn, $sql_seScanOUTerror9, $params_seScanOUTerror9);
    // $result_seScanOUTerror9 = sqlsrv_fetch_array($query_seScanOUTerror9, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk9 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'09/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk9   = sqlsrv_query($conn, $sql_seLeavedaychk9, $params_seLeavedaychk9);
    $result_seLeavedaychk9 = sqlsrv_fetch_array($query_seLeavedaychk9, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk9['Leave_Memo'] == '') {
        $leavechk9 = '0';
    }else {
        $leavechk9 = '1';
    }

    $sql_sesundaychk9 = "SELECT DATENAME(DW,CONVERT(DATE,'09/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk9   = sqlsrv_query($conn, $sql_sesundaychk9, $params_sesundaychk9);
    $result_sesundaychk9  = sqlsrv_fetch_array($query_sesundaychk9, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual9in['TIMESCANACTUALIN'] == '' || $result_seScanActual9in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift9['JOBNO'] != '')) {
        $checkworking9 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual9in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift9['JOBNO'] == '') && ($result_sesundaychk9['SUNDAY'] !='Sunday')){
        $checkworking9 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking9 = '';
    }

    // if ($result_seScanActual9in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk9 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk9['Leave_Memo'] == '') {
    //         $latechk9 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk9 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
///////////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual10in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'10/".$month."/".$years."',103)";
    $query_seScanActual10in = sqlsrv_query($conn, $sql_seScanActual10in, $params_seScanActual10in);
    $result_seScanActual10in = sqlsrv_fetch_array($query_seScanActual10in, SQLSRV_FETCH_ASSOC);

    //หากะเวลาการทำงาน วันที่ 10
    $sql_seChk_Shift10 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'10/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift10 = sqlsrv_query($conn, $sql_seChk_Shift10, $params_seChk_Shift10);
    $result_seChk_Shift10 = sqlsrv_fetch_array($query_seChk_Shift10, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual10out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'10/".$month."/".$years."',103)";
    $query_seScanActual10out = sqlsrv_query($conn, $sql_seScanActual10out, $params_seScanActual10out);
    $result_seScanActual10out = sqlsrv_fetch_array($query_seScanActual10out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror10 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'10/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror10 = sqlsrv_query($conn, $sql_seScanINerror10, $params_seScanINerror10);
    // $result_seScanINerror10 = sqlsrv_fetch_array($query_seScanINerror10, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror10 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'10/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror10 = sqlsrv_query($conn, $sql_seScanOUTerror10, $params_seScanOUTerror10);
    // $result_seScanOUTerror10 = sqlsrv_fetch_array($query_seScanOUTerror10, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk10 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'10/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk10   = sqlsrv_query($conn, $sql_seLeavedaychk10, $params_seLeavedaychk10);
    $result_seLeavedaychk10  = sqlsrv_fetch_array($query_seLeavedaychk10, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk10['Leave_Memo'] == '') {
        $leavechk10 = '0';
    }else {
        $leavechk10 = '1';
    }

    $sql_sesundaychk10 = "SELECT DATENAME(DW,CONVERT(DATE,'10/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk10   = sqlsrv_query($conn, $sql_sesundaychk10, $params_sesundaychk10);
    $result_sesundaychk10  = sqlsrv_fetch_array($query_sesundaychk10, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual10in['TIMESCANACTUALIN'] == '' || $result_seScanActual10in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift10['JOBNO'] != '')) {
        $checkworking10 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual10in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift10['JOBNO'] == '') && ($result_sesundaychk10['SUNDAY'] !='Sunday')){
        $checkworking10 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking10 = '';
    }

    // if ($result_seScanActual10in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk10 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk10['Leave_Memo'] == '') {
    //         $latechk10 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk10 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
/////////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual11in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'11/".$month."/".$years."',103)";
    $query_seScanActual11in = sqlsrv_query($conn, $sql_seScanActual11in, $params_seScanActual11in);
    $result_seScanActual11in = sqlsrv_fetch_array($query_seScanActual11in, SQLSRV_FETCH_ASSOC);

    //หากะเวลาการทำงาน วันที่ 11
    $sql_seChk_Shift11 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'11/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift11 = sqlsrv_query($conn, $sql_seChk_Shift11, $params_seChk_Shift11);
    $result_seChk_Shift11 = sqlsrv_fetch_array($query_seChk_Shift11, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual11out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'11/".$month."/".$years."',103)";
    $query_seScanActual11out = sqlsrv_query($conn, $sql_seScanActual11out, $params_seScanActual11out);
    $result_seScanActual11out = sqlsrv_fetch_array($query_seScanActual11out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror11 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'11/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror11 = sqlsrv_query($conn, $sql_seScanINerror11, $params_seScanINerror11);
    // $result_seScanINerror11 = sqlsrv_fetch_array($query_seScanINerror11, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror11 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'11/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror11 = sqlsrv_query($conn, $sql_seScanOUTerror11, $params_seScanOUTerror11);
    // $result_seScanOUTerror11 = sqlsrv_fetch_array($query_seScanOUTerror11, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk11 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'11/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk11   = sqlsrv_query($conn, $sql_seLeavedaychk11, $params_seLeavedaychk11);
    $result_seLeavedaychk11  = sqlsrv_fetch_array($query_seLeavedaychk11, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk11['Leave_Memo'] == '') {
        $leavechk11 = '0';
    }else {
        $leavechk11 = '1';
    }

    $sql_sesundaychk11 = "SELECT DATENAME(DW,CONVERT(DATE,'11/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk11   = sqlsrv_query($conn, $sql_sesundaychk11, $params_sesundaychk11);
    $result_sesundaychk11  = sqlsrv_fetch_array($query_sesundaychk11, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual11in['TIMESCANACTUALIN'] == '' || $result_seScanActual11in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift11['JOBNO'] != '')) {
        $checkworking11 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual11in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift11['JOBNO'] == '') && ($result_sesundaychk11['SUNDAY'] !='Sunday')){
        $checkworking11 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking11 = '';
    }

    // if ($result_seScanActual11in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk11 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk11['Leave_Memo'] == '') {
    //         $latechk11 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk11 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
//////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual12in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'12/".$month."/".$years."',103)";
    $query_seScanActual12in = sqlsrv_query($conn, $sql_seScanActual12in, $params_seScanActual12in);
    $result_seScanActual12in = sqlsrv_fetch_array($query_seScanActual12in, SQLSRV_FETCH_ASSOC);

    //หากะเวลาการทำงาน วันที่ 12
    $sql_seChk_Shift12 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'12/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift12 = sqlsrv_query($conn, $sql_seChk_Shift12, $params_seChk_Shift12);
    $result_seChk_Shift12 = sqlsrv_fetch_array($query_seChk_Shift12, SQLSRV_FETCH_ASSOC);

    // $sql_seScanActual12out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'12/".$month."/".$years."',103)";
    // $query_seScanActual12out = sqlsrv_query($conn, $sql_seScanActual12out, $params_seScanActual12out);
    // $result_seScanActual12out = sqlsrv_fetch_array($query_seScanActual12out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror12 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'12/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror12 = sqlsrv_query($conn, $sql_seScanINerror12, $params_seScanINerror12);
    // $result_seScanINerror12 = sqlsrv_fetch_array($query_seScanINerror12, SQLSRV_FETCH_ASSOC);

    //แสกน OUT ก่อน 08.00 (เข้างาน)
    $sql_seScanOUTerror12 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'12/".$month."/".$years."',103)
        AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    $query_seScanOUTerror12 = sqlsrv_query($conn, $sql_seScanOUTerror12, $params_seScanOUTerror12);
    $result_seScanOUTerror12 = sqlsrv_fetch_array($query_seScanOUTerror12, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk12 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'12/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk12   = sqlsrv_query($conn, $sql_seLeavedaychk12, $params_seLeavedaychk12);
    $result_seLeavedaychk12 = sqlsrv_fetch_array($query_seLeavedaychk12, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk12['Leave_Memo'] == '') {
        $leavechk12 = '0';
    }else {
        $leavechk12 = '1';
    }

    $sql_sesundaychk12 = "SELECT DATENAME(DW,CONVERT(DATE,'12/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk12   = sqlsrv_query($conn, $sql_sesundaychk12, $params_sesundaychk12);
    $result_sesundaychk12  = sqlsrv_fetch_array($query_sesundaychk12, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual12in['TIMESCANACTUALIN'] == '' || $result_seScanActual12in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift12['JOBNO'] != '')) {
        $checkworking12 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual12in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift12['JOBNO'] == '') && ($result_sesundaychk12['SUNDAY'] !='Sunday') && ($leavechk13 == '0') && ($leavechk13 == '0') && ($holiday12 == '')){
        $checkworking12 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking12 = '';
    }

    // if ($result_seScanActual12in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk12 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk12['Leave_Memo'] == '') {
    //         $latechk12 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk12 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
//////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual13in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'13/".$month."/".$years."',103)";
    $query_seScanActual13in = sqlsrv_query($conn, $sql_seScanActual13in, $params_seScanActual13in);
    $result_seScanActual13in = sqlsrv_fetch_array($query_seScanActual13in, SQLSRV_FETCH_ASSOC);

     //หากะเวลาการทำงาน วันที่ 13
    $sql_seChk_Shift13 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'13/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift13 = sqlsrv_query($conn, $sql_seChk_Shift13, $params_seChk_Shift13);
    $result_seChk_Shift13 = sqlsrv_fetch_array($query_seChk_Shift13, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual13out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'13/".$month."/".$years."',103)";
    $query_seScanActual13out = sqlsrv_query($conn, $sql_seScanActual13out, $params_seScanActual13out);
    $result_seScanActual13out = sqlsrv_fetch_array($query_seScanActual13out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror13 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'13/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror13 = sqlsrv_query($conn, $sql_seScanINerror13, $params_seScanINerror13);
    // $result_seScanINerror13 = sqlsrv_fetch_array($query_seScanINerror13, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror13 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'13/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror13 = sqlsrv_query($conn, $sql_seScanOUTerror13, $params_seScanOUTerror13);
    // $result_seScanOUTerror13 = sqlsrv_fetch_array($query_seScanOUTerror13, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk13 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'13/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk13   = sqlsrv_query($conn, $sql_seLeavedaychk13, $params_seLeavedaychk13);
    $result_seLeavedaychk13  = sqlsrv_fetch_array($query_seLeavedaychk13, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk13['Leave_Memo'] == '') {
        $leavechk13 = '0';
    }else {
        $leavechk13 = '1';
    }

    $sql_sesundaychk13 = "SELECT DATENAME(DW,CONVERT(DATE,'13/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk13   = sqlsrv_query($conn, $sql_sesundaychk13, $params_sesundaychk13);
    $result_sesundaychk13  = sqlsrv_fetch_array($query_sesundaychk13, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual13in['TIMESCANACTUALIN'] == '' || $result_seScanActual13in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift13['JOBNO'] != '')) {
        $checkworking13 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual13in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift13['JOBNO'] == '') && ($result_sesundaychk13['SUNDAY'] !='Sunday') ){
        $checkworking13 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking13 = '';
    }

    // if ($result_seScanActual13in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk13 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk13['Leave_Memo'] == '') {
    //         $latechk13 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk13 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
//////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual14in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'14/".$month."/".$years."',103)";
    $query_seScanActual14in = sqlsrv_query($conn, $sql_seScanActual14in, $params_seScanActual14in);
    $result_seScanActual14in = sqlsrv_fetch_array($query_seScanActual14in, SQLSRV_FETCH_ASSOC);

     //หากะเวลาการทำงาน วันที่ 14
    $sql_seChk_Shift14 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'14/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift14 = sqlsrv_query($conn, $sql_seChk_Shift14, $params_seChk_Shift14);
    $result_seChk_Shift14 = sqlsrv_fetch_array($query_seChk_Shift14, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual14out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'14/".$month."/".$years."',103)";
    $query_seScanActual14out = sqlsrv_query($conn, $sql_seScanActual14out, $params_seScanActual14out);
    $result_seScanActual14out = sqlsrv_fetch_array($query_seScanActual14out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror14 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'14/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror14 = sqlsrv_query($conn, $sql_seScanINerror14, $params_seScanINerror14);
    // $result_seScanINerror14 = sqlsrv_fetch_array($query_seScanINerror14, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror14 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'14/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror14 = sqlsrv_query($conn, $sql_seScanOUTerror14, $params_seScanOUTerror14);
    // $result_seScanOUTerror14 = sqlsrv_fetch_array($query_seScanOUTerror14, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk14 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'14/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk14   = sqlsrv_query($conn, $sql_seLeavedaychk14, $params_seLeavedaychk14);
    $result_seLeavedaychk14  = sqlsrv_fetch_array($query_seLeavedaychk14, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk14['Leave_Memo'] == '') {
        $leavechk14 = '0';
    }else {
        $leavechk14 = '1';
    }

    $sql_sesundaychk14 = "SELECT DATENAME(DW,CONVERT(DATE,'10/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk14   = sqlsrv_query($conn, $sql_sesundaychk14, $params_sesundaychk14);
    $result_sesundaychk14  = sqlsrv_fetch_array($query_sesundaychk14, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual14in['TIMESCANACTUALIN'] == '' || $result_seScanActual14in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift14['JOBNO'] != '')) {
        $checkworking14 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual14in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift14['JOBNO'] == '') && ($result_sesundaychk14['SUNDAY'] !='Sunday')){
        $checkworking14 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking14 = '';
    }
    // if ($result_seScanActual14in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk14 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk14['Leave_Memo'] == '') {
    //         $latechk14 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk14 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
//////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual15in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'15/".$month."/".$years."',103)";
    $query_seScanActual15in = sqlsrv_query($conn, $sql_seScanActual15in, $params_seScanActual15in);
    $result_seScanActual15in = sqlsrv_fetch_array($query_seScanActual15in, SQLSRV_FETCH_ASSOC);

    //หากะเวลาการทำงาน วันที่ 15
    $sql_seChk_Shift15 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'15/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift15 = sqlsrv_query($conn, $sql_seChk_Shift15, $params_seChk_Shift15);
    $result_seChk_Shift15 = sqlsrv_fetch_array($query_seChk_Shift15, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual15out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'15/".$month."/".$years."',103)";
    $query_seScanActual15out = sqlsrv_query($conn, $sql_seScanActual15out, $params_seScanActual15out);
    $result_seScanActual15out = sqlsrv_fetch_array($query_seScanActual15out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror15 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'15/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror15 = sqlsrv_query($conn, $sql_seScanINerror15, $params_seScanINerror15);
    // $result_seScanINerror15 = sqlsrv_fetch_array($query_seScanINerror15, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror15 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'15/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror15 = sqlsrv_query($conn, $sql_seScanOUTerror15, $params_seScanOUTerror15);
    // $result_seScanOUTerror15 = sqlsrv_fetch_array($query_seScanOUTerror15, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk15 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'15/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk15   = sqlsrv_query($conn, $sql_seLeavedaychk15, $params_seLeavedaychk15);
    $result_seLeavedaychk15  = sqlsrv_fetch_array($query_seLeavedaychk15, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk15['Leave_Memo'] == '') {
        $leavechk15 = '0';
    }else {
        $leavechk15 = '1';
    }

    $sql_sesundaychk15 = "SELECT DATENAME(DW,CONVERT(DATE,'15/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk15   = sqlsrv_query($conn, $sql_sesundaychk15, $params_sesundaychk15);
    $result_sesundaychk15  = sqlsrv_fetch_array($query_sesundaychk15, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual15in['TIMESCANACTUALIN'] == '' || $result_seScanActual15in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift15['JOBNO'] != '')) {
        $checkworking15 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual15in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift15['JOBNO'] == '') && ($result_sesundaychk15['SUNDAY'] !='Sunday')){
        $checkworking15 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking15 = '';
    }

    // if ($result_seScanActual15in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk15 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk15['Leave_Memo'] == '') {
    //         $latechk15 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk15 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
//////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual16in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'16/".$month."/".$years."',103)";
    $query_seScanActual16in = sqlsrv_query($conn, $sql_seScanActual16in, $params_seScanActual16in);
    $result_seScanActual16in = sqlsrv_fetch_array($query_seScanActual16in, SQLSRV_FETCH_ASSOC);

    //หากะเวลาการทำงาน วันที่ 16
    $sql_seChk_Shift16 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'16/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift16 = sqlsrv_query($conn, $sql_seChk_Shift16, $params_seChk_Shift16);
    $result_seChk_Shift16 = sqlsrv_fetch_array($query_seChk_Shift16, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual16out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'16/".$month."/".$years."',103)";
    $query_seScanActual16out = sqlsrv_query($conn, $sql_seScanActual16out, $params_seScanActual16out);
    $result_seScanActual16out = sqlsrv_fetch_array($query_seScanActual16out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror16 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'16/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror16 = sqlsrv_query($conn, $sql_seScanINerror16, $params_seScanINerror16);
    // $result_seScanINerror16 = sqlsrv_fetch_array($query_seScanINerror16, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror16 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'16/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror16 = sqlsrv_query($conn, $sql_seScanOUTerror16, $params_seScanOUTerror16);
    // $result_seScanOUTerror16 = sqlsrv_fetch_array($query_seScanOUTerror16, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk16 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'16/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk16   = sqlsrv_query($conn, $sql_seLeavedaychk16, $params_seLeavedaychk16);
    $result_seLeavedaychk16  = sqlsrv_fetch_array($query_seLeavedaychk16, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk16['Leave_Memo'] == '') {
        $leavechk16 = '0';
    }else {
        $leavechk16 = '1';
    }

    $sql_sesundaychk16 = "SELECT DATENAME(DW,CONVERT(DATE,'16/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk16   = sqlsrv_query($conn, $sql_sesundaychk16, $params_sesundaychk16);
    $result_sesundaychk16  = sqlsrv_fetch_array($query_sesundaychk16, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual16in['TIMESCANACTUALIN'] == '' || $result_seScanActual16in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift16['JOBNO'] != '')) {
        $checkworking16 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual15in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift16['JOBNO'] == '') && ($result_sesundaychk16['SUNDAY'] !='Sunday')){
        $checkworking16 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking16 = '';
    }

    // if ($result_seScanActual16in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk16 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk16['Leave_Memo'] == '') {
    //         $latechk16 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk16 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
//////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual17in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'17/".$month."/".$years."',103)";
    $query_seScanActual17in = sqlsrv_query($conn, $sql_seScanActual17in, $params_seScanActual17in);
    $result_seScanActual17in = sqlsrv_fetch_array($query_seScanActual17in, SQLSRV_FETCH_ASSOC);

    //หากะเวลาการทำงาน วันที่ 17
    $sql_seChk_Shift17 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'17/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift17 = sqlsrv_query($conn, $sql_seChk_Shift17, $params_seChk_Shift17);
    $result_seChk_Shift17 = sqlsrv_fetch_array($query_seChk_Shift17, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual17out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'17/".$month."/".$years."',103)";
    $query_seScanActual17out = sqlsrv_query($conn, $sql_seScanActual17out, $params_seScanActual17out);
    $result_seScanActual17out = sqlsrv_fetch_array($query_seScanActual17out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror17 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'17/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror17 = sqlsrv_query($conn, $sql_seScanINerror17, $params_seScanINerror17);
    // $result_seScanINerror17 = sqlsrv_fetch_array($query_seScanINerror17, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror17 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'17/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror17 = sqlsrv_query($conn, $sql_seScanOUTerror17, $params_seScanOUTerror17);
    // $result_seScanOUTerror17 = sqlsrv_fetch_array($query_seScanOUTerror17, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk17 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'17/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk17   = sqlsrv_query($conn, $sql_seLeavedaychk17, $params_seLeavedaychk17);
    $result_seLeavedaychk17  = sqlsrv_fetch_array($query_seLeavedaychk17, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk17['Leave_Memo'] == '') {
        $leavechk17 = '0';
    }else {
        $leavechk17 = '1';
    }

    $sql_sesundaychk17 = "SELECT DATENAME(DW,CONVERT(DATE,'17/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk17   = sqlsrv_query($conn, $sql_sesundaychk17, $params_sesundaychk17);
    $result_sesundaychk17  = sqlsrv_fetch_array($query_sesundaychk17, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual17in['TIMESCANACTUALIN'] == '' || $result_seScanActual17in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift17['JOBNO'] != '')) {
        $checkworking17 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual17in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift17['JOBNO'] == '') && ($result_sesundaychk17['SUNDAY'] !='Sunday')){
        $checkworking17 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking17 = '';
    }

    // if ($result_seScanActual17in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk17 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk17['Leave_Memo'] == '') {
    //         $latechk17 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk17 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
//////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual18in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'18/".$month."/".$years."',103)";
    $query_seScanActual18in = sqlsrv_query($conn, $sql_seScanActual18in, $params_seScanActual18in);
    $result_seScanActual18in = sqlsrv_fetch_array($query_seScanActual18in, SQLSRV_FETCH_ASSOC);

    //หากะเวลาการทำงาน วันที่ 18
    $sql_seChk_Shift18 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'18/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift18 = sqlsrv_query($conn, $sql_seChk_Shift18, $params_seChk_Shift18);
    $result_seChk_Shift18 = sqlsrv_fetch_array($query_seChk_Shift18, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual18out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'18/".$month."/".$years."',103)";
    $query_seScanActual18out = sqlsrv_query($conn, $sql_seScanActual18out, $params_seScanActual18out);
    $result_seScanActual18out = sqlsrv_fetch_array($query_seScanActual18out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror18 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'18/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror18 = sqlsrv_query($conn, $sql_seScanINerror18, $params_seScanINerror18);
    // $result_seScanINerror18 = sqlsrv_fetch_array($query_seScanINerror18, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror18 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'18/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror18 = sqlsrv_query($conn, $sql_seScanOUTerror18, $params_seScanOUTerror18);
    // $result_seScanOUTerror18 = sqlsrv_fetch_array($query_seScanOUTerror18, SQLSRV_FETCH_ASSOC);
    
    $sql_seLeavedaychk18 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'18/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk18   = sqlsrv_query($conn, $sql_seLeavedaychk18, $params_seLeavedaychk18);
    $result_seLeavedaychk18  = sqlsrv_fetch_array($query_seLeavedaychk18, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk18['Leave_Memo'] == '') {
        $leavechk18 = '0';
    }else {
        $leavechk18 = '1';
    }

    $sql_sesundaychk18 = "SELECT DATENAME(DW,CONVERT(DATE,'18/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk18  = sqlsrv_query($conn, $sql_sesundaychk18, $params_sesundaychk18);
    $result_sesundaychk18  = sqlsrv_fetch_array($query_sesundaychk18, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual18in['TIMESCANACTUALIN'] == '' || $result_seScanActual18in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift18['JOBNO'] != '')) {
        $checkworking18 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual18in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift18['JOBNO'] == '') && ($result_sesundaychk18['SUNDAY'] !='Sunday')){
        $checkworking18 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking18 = '';
    }

    // if ($result_seScanActual18in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk18 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk18['Leave_Memo'] == '') {
    //         $latechk18 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk18 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
//////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual19in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'19/".$month."/".$years."',103)";
    $query_seScanActual19in = sqlsrv_query($conn, $sql_seScanActual19in, $params_seScanActual19in);
    $result_seScanActual19in = sqlsrv_fetch_array($query_seScanActual19in, SQLSRV_FETCH_ASSOC);

    //หากะเวลาการทำงาน วันที่ 19
    $sql_seChk_Shift19 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'19/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift19 = sqlsrv_query($conn, $sql_seChk_Shift19, $params_seChk_Shift19);
    $result_seChk_Shift19 = sqlsrv_fetch_array($query_seChk_Shift19, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual19out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'19/".$month."/".$years."',103)";
    $query_seScanActual19out = sqlsrv_query($conn, $sql_seScanActual19out, $params_seScanActual19out);
    $result_seScanActual19out = sqlsrv_fetch_array($query_seScanActual19out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror19 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'19/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror19 = sqlsrv_query($conn, $sql_seScanINerror19, $params_seScanINerror19);
    // $result_seScanINerror19 = sqlsrv_fetch_array($query_seScanINerror19, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror19 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'19/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror19 = sqlsrv_query($conn, $sql_seScanOUTerror19, $params_seScanOUTerror19);
    // $result_seScanOUTerror19 = sqlsrv_fetch_array($query_seScanOUTerror19, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk19 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'19/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk19   = sqlsrv_query($conn, $sql_seLeavedaychk19, $params_seLeavedaychk19);
    $result_seLeavedaychk19  = sqlsrv_fetch_array($query_seLeavedaychk19, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk19['Leave_Memo'] == '') {
        $leavechk19 = '0';
    }else {
        $leavechk19 = '1';
    }

    $sql_sesundaychk19 = "SELECT DATENAME(DW,CONVERT(DATE,'19/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk19   = sqlsrv_query($conn, $sql_sesundaychk19, $params_sesundaychk19);
    $result_sesundaychk19  = sqlsrv_fetch_array($query_sesundaychk19, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual19in['TIMESCANACTUALIN'] == '' || $result_seScanActual19in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift19['JOBNO'] != '')) {
        $checkworking19 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual19in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift19['JOBNO'] == '') && ($result_sesundaychk19['SUNDAY'] !='Sunday')){
        $checkworking19 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking19 = '';
    }

    // if ($result_seScanActual19in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk19 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk19['Leave_Memo'] == '') {
    //         $latechk19 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk19 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
//////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual20in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'20/".$month."/".$years."',103)";
    $query_seScanActual20in = sqlsrv_query($conn, $sql_seScanActual20in, $params_seScanActual20in);
    $result_seScanActual20in = sqlsrv_fetch_array($query_seScanActual20in, SQLSRV_FETCH_ASSOC);

    //หากะเวลาการทำงาน วันที่ 20
    $sql_seChk_Shift20 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'20/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift20 = sqlsrv_query($conn, $sql_seChk_Shift20, $params_seChk_Shift20);
    $result_seChk_Shift20 = sqlsrv_fetch_array($query_seChk_Shift20, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual20out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'20/".$month."/".$years."',103)";
    $query_seScanActual20out = sqlsrv_query($conn, $sql_seScanActual20out, $params_seScanActual20out);
    $result_seScanActual20out = sqlsrv_fetch_array($query_seScanActual20out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror20 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'20/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror20 = sqlsrv_query($conn, $sql_seScanINerror20, $params_seScanINerror20);
    // $result_seScanINerror20 = sqlsrv_fetch_array($query_seScanINerror20, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror2 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'20/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror20 = sqlsrv_query($conn, $sql_seScanOUTerror20, $params_seScanOUTerror20);
    // $result_seScanOUTerror20 = sqlsrv_fetch_array($query_seScanOUTerror20, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk20 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'20/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk20   = sqlsrv_query($conn, $sql_seLeavedaychk20, $params_seLeavedaychk20);
    $result_seLeavedaychk20  = sqlsrv_fetch_array($query_seLeavedaychk20, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk20['Leave_Memo'] == '') {
        $leavechk20 = '0';
    }else {
        $leavechk20 = '1';
    }

    $sql_sesundaychk20 = "SELECT DATENAME(DW,CONVERT(DATE,'20/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk20   = sqlsrv_query($conn, $sql_sesundaychk20, $params_sesundaychk20);
    $result_sesundaychk20  = sqlsrv_fetch_array($query_sesundaychk20, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual20in['TIMESCANACTUALIN'] == '' || $result_seScanActual20in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift20['JOBNO'] != '')) {
        $checkworking20 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual20in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift20['JOBNO'] == '') && ($result_sesundaychk20['SUNDAY'] !='Sunday')){
        $checkworking20 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking20 = '';
    }

    // if ($result_seScanActual20in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk20 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk20['Leave_Memo'] == '') {
    //         $latechk20 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk20 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
////////////////////////////////////////////////////////////////////////////////////////////////
    $sql_seScanActual21in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'21/".$month."/".$years."',103)";
    $query_seScanActual21in = sqlsrv_query($conn, $sql_seScanActual21in, $params_seScanActual21in);
    $result_seScanActual21in = sqlsrv_fetch_array($query_seScanActual21in, SQLSRV_FETCH_ASSOC);

    //หากะเวลาการทำงาน วันที่ 21
    $sql_seChk_Shift21 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'21/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift21 = sqlsrv_query($conn, $sql_seChk_Shift21, $params_seChk_Shift21);
    $result_seChk_Shift21 = sqlsrv_fetch_array($query_seChk_Shift21, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual21out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'21/".$month."/".$years."',103)";
    $query_seScanActual21out = sqlsrv_query($conn, $sql_seScanActual21out, $params_seScanActual21out);
    $result_seScanActual21out = sqlsrv_fetch_array($query_seScanActual21out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror21 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'21/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror21 = sqlsrv_query($conn, $sql_seScanINerror21, $params_seScanINerror21);
    // $result_seScanINerror21 = sqlsrv_fetch_array($query_seScanINerror21, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror21 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'21/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror21 = sqlsrv_query($conn, $sql_seScanOUTerror21, $params_seScanOUTerror21);
    // $result_seScanOUTerror21 = sqlsrv_fetch_array($query_seScanOUTerror21, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk21 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'21/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk21   = sqlsrv_query($conn, $sql_seLeavedaychk21, $params_seLeavedaychk21);
    $result_seLeavedaychk21  = sqlsrv_fetch_array($query_seLeavedaychk21, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk21['Leave_Memo'] == '') {
        $leavechk21 = '0';
    }else {
        $leavechk21 = '1';
    }

    $sql_sesundaychk21 = "SELECT DATENAME(DW,CONVERT(DATE,'21/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk21   = sqlsrv_query($conn, $sql_sesundaychk21, $params_sesundaychk21);
    $result_sesundaychk21  = sqlsrv_fetch_array($query_sesundaychk21, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual21in['TIMESCANACTUALIN'] == '' || $result_seScanActual21in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift21['JOBNO'] != '')) {
        $checkworking21 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual21in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift21['JOBNO'] == '') && ($result_sesundaychk21['SUNDAY'] !='Sunday')){
        $checkworking21 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking21 = '';
    }

    // if ($result_seScanActual21in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk21 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk21['Leave_Memo'] == '') {
    //         $latechk21 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk21 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
//////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual22in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'22/".$month."/".$years."',103)";
    $query_seScanActual22in = sqlsrv_query($conn, $sql_seScanActual22in, $params_seScanActual22in);
    $result_seScanActual22in = sqlsrv_fetch_array($query_seScanActual22in, SQLSRV_FETCH_ASSOC);

    //หากะเวลาการทำงาน วันที่ 22
    $sql_seChk_Shift22 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'22/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift22 = sqlsrv_query($conn, $sql_seChk_Shift22, $params_seChk_Shift22);
    $result_seChk_Shift22 = sqlsrv_fetch_array($query_seChk_Shift22, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual22out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'22/".$month."/".$years."',103)";
    $query_seScanActual22out = sqlsrv_query($conn, $sql_seScanActual22out, $params_seScanActual22out);
    $result_seScanActual22out = sqlsrv_fetch_array($query_seScanActual22out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror22 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'22/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror22 = sqlsrv_query($conn, $sql_seScanINerror22, $params_seScanINerror22);
    // $result_seScanINerror22 = sqlsrv_fetch_array($query_seScanINerror22, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror22 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'22/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror22 = sqlsrv_query($conn, $sql_seScanOUTerror22, $params_seScanOUTerror22);
    // $result_seScanOUTerror22 = sqlsrv_fetch_array($query_seScanOUTerror22, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk22 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'22/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk22   = sqlsrv_query($conn, $sql_seLeavedaychk22, $params_seLeavedaychk22);
    $result_seLeavedaychk22  = sqlsrv_fetch_array($query_seLeavedaychk22, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk22['Leave_Memo'] == '') {
        $leavechk22 = '0';
    }else {
        $leavechk22 = '1';
    }

    $sql_sesundaychk22 = "SELECT DATENAME(DW,CONVERT(DATE,'22/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk22   = sqlsrv_query($conn, $sql_sesundaychk22, $params_sesundaychk22);
    $result_sesundaychk22  = sqlsrv_fetch_array($query_sesundaychk22, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual22in['TIMESCANACTUALIN'] == '' || $result_seScanActual22in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift22['JOBNO'] != '')) {
        $checkworking22 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual22in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift22['JOBNO'] == '') && ($result_sesundaychk22['SUNDAY'] !='Sunday')){
        $checkworking22 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking22 = '';
    }

    // if ($result_seScanActual22in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk22 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk22['Leave_Memo'] == '') {
    //         $latechk22 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk22 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
//////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual23in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'23/".$month."/".$years."',103)";
    $query_seScanActual23in = sqlsrv_query($conn, $sql_seScanActual23in, $params_seScanActual23in);
    $result_seScanActual23in = sqlsrv_fetch_array($query_seScanActual23in, SQLSRV_FETCH_ASSOC);

    //หากะเวลาการทำงาน วันที่ 23
    $sql_seChk_Shift23 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'23/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift23 = sqlsrv_query($conn, $sql_seChk_Shift23, $params_seChk_Shift23);
    $result_seChk_Shift23 = sqlsrv_fetch_array($query_seChk_Shift23, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual23out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'23/".$month."/".$years."',103)";
    $query_seScanActual23out = sqlsrv_query($conn, $sql_seScanActual23out, $params_seScanActual23out);
    $result_seScanActual23out = sqlsrv_fetch_array($query_seScanActual23out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror23 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'23/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror23 = sqlsrv_query($conn, $sql_seScanINerror23, $params_seScanINerror23);
    // $result_seScanINerror23 = sqlsrv_fetch_array($query_seScanINerror23, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror23 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'23/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror23 = sqlsrv_query($conn, $sql_seScanOUTerror23, $params_seScanOUTerror23);
    // $result_seScanOUTerror23 = sqlsrv_fetch_array($query_seScanOUTerror23, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk23 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'23/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk23   = sqlsrv_query($conn, $sql_seLeavedaychk23, $params_seLeavedaychk23);
    $result_seLeavedaychk23  = sqlsrv_fetch_array($query_seLeavedaychk23, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk23['Leave_Memo'] == '') {
        $leavechk23 = '0';
    }else {
        $leavechk23 = '1';
    }

    $sql_sesundaychk23 = "SELECT DATENAME(DW,CONVERT(DATE,'23/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk23   = sqlsrv_query($conn, $sql_sesundaychk23, $params_sesundaychk23);
    $result_sesundaychk23  = sqlsrv_fetch_array($query_sesundaychk23, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual23in['TIMESCANACTUALIN'] == '' || $result_seScanActual23in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift23['JOBNO'] != '')) {
        $checkworking23 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual23in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift23['JOBNO'] == '') && ($result_sesundaychk23['SUNDAY'] !='Sunday')){
        $checkworking23 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking23 = '';
    }

    // if ($result_seScanActual23in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk23 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk23['Leave_Memo'] == '') {
    //         $latechk23 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk23 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
//////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual24in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'24/".$month."/".$years."',103)";
    $query_seScanActual24in = sqlsrv_query($conn, $sql_seScanActual24in, $params_seScanActual24in);
    $result_seScanActual24in = sqlsrv_fetch_array($query_seScanActual24in, SQLSRV_FETCH_ASSOC);

    //หากะเวลาการทำงาน วันที่ 24
    $sql_seChk_Shift24 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'24/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift24 = sqlsrv_query($conn, $sql_seChk_Shift24, $params_seChk_Shift24);
    $result_seChk_Shift24 = sqlsrv_fetch_array($query_seChk_Shift24, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual24out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'24/".$month."/".$years."',103)";
    $query_seScanActual24out = sqlsrv_query($conn, $sql_seScanActual24out, $params_seScanActual24out);
    $result_seScanActual24out = sqlsrv_fetch_array($query_seScanActual24out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror24 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'24/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror24 = sqlsrv_query($conn, $sql_seScanINerror24, $params_seScanINerror24);
    // $result_seScanINerror24 = sqlsrv_fetch_array($query_seScanINerror24, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror24 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'24/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror24 = sqlsrv_query($conn, $sql_seScanOUTerror24, $params_seScanOUTerror24);
    // $result_seScanOUTerror24 = sqlsrv_fetch_array($query_seScanOUTerror24, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk24 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'24/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk24   = sqlsrv_query($conn, $sql_seLeavedaychk24, $params_seLeavedaychk24);
    $result_seLeavedaychk24  = sqlsrv_fetch_array($query_seLeavedaychk24, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk24['Leave_Memo'] == '') {
        $leavechk24 = '0';
    }else {
        $leavechk24 = '1';
    }

    $sql_sesundaychk24 = "SELECT DATENAME(DW,CONVERT(DATE,'24/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk24   = sqlsrv_query($conn, $sql_sesundaychk24, $params_sesundaychk24);
    $result_sesundaychk24  = sqlsrv_fetch_array($query_sesundaychk24, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual24in['TIMESCANACTUALIN'] == '' || $result_seScanActual24in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift24['JOBNO'] != '')) {
        $checkworking24 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual24in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift24['JOBNO'] == '') && ($result_sesundaychk24['SUNDAY'] !='Sunday')){
        $checkworking24 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking24 = '';
    }

    // if ($result_seScanActual24in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk24 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk24['Leave_Memo'] == '') {
    //         $latechk24 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk24 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
//////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual25in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'25/".$month."/".$years."',103)";
    $query_seScanActual25in = sqlsrv_query($conn, $sql_seScanActual25in, $params_seScanActual25in);
    $result_seScanActual25in = sqlsrv_fetch_array($query_seScanActual25in, SQLSRV_FETCH_ASSOC);

    //หากะเวลาการทำงาน วันที่ 25
    $sql_seChk_Shift25 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'25/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift25 = sqlsrv_query($conn, $sql_seChk_Shift25, $params_seChk_Shift25);
    $result_seChk_Shift25 = sqlsrv_fetch_array($query_seChk_Shift25, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual25out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'25/".$month."/".$years."',103)";
    $query_seScanActual25out = sqlsrv_query($conn, $sql_seScanActual25out, $params_seScanActual25out);
    $result_seScanActual25out = sqlsrv_fetch_array($query_seScanActual25out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror25 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'25/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '".$result_seChk_Shift25['TimeIn']."'";
    // $query_seScanINerror25 = sqlsrv_query($conn, $sql_seScanINerror25, $params_seScanINerror25);
    // $result_seScanINerror25 = sqlsrv_fetch_array($query_seScanINerror25, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror25 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'25/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '".$result_seChk_Shift25['TimeOut']."'";
    // $query_seScanOUTerror25 = sqlsrv_query($conn, $sql_seScanOUTerror25, $params_seScanOUTerror25);
    // $result_seScanOUTerror25 = sqlsrv_fetch_array($query_seScanOUTerror25, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk25 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'25/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk25   = sqlsrv_query($conn, $sql_seLeavedaychk25, $params_seLeavedaychk25);
    $result_seLeavedaychk25  = sqlsrv_fetch_array($query_seLeavedaychk25, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk25['Leave_Memo'] == '') {
        $leavechk25 = '0';
    }else {
        $leavechk25 = '1';
    }

    $sql_sesundaychk25 = "SELECT DATENAME(DW,CONVERT(DATE,'25/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk25   = sqlsrv_query($conn, $sql_sesundaychk25, $params_sesundaychk25);
    $result_sesundaychk25  = sqlsrv_fetch_array($query_sesundaychk25, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual25in['TIMESCANACTUALIN'] == '' || $result_seScanActual25in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift25['JOBNO'] != '')) {
        $checkworking25 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual25in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift25['JOBNO'] == '') && ($result_sesundaychk25['SUNDAY'] !='Sunday')){
        $checkworking25 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking25 = '';
    }

    // if ($result_seScanActual25in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk25 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk25['Leave_Memo'] == '') {
    //         $latechk25 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk25 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
//////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual26in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'26/".$month."/".$years."',103)";
    $query_seScanActual26in = sqlsrv_query($conn, $sql_seScanActual26in, $params_seScanActual26in);
    $result_seScanActual26in = sqlsrv_fetch_array($query_seScanActual26in, SQLSRV_FETCH_ASSOC);

    //หากะเวลาการทำงาน วันที่ 26
    $sql_seChk_Shift26 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'26/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift26 = sqlsrv_query($conn, $sql_seChk_Shift26, $params_seChk_Shift26);
    $result_seChk_Shift26 = sqlsrv_fetch_array($query_seChk_Shift26, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual26out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'26/".$month."/".$years."',103)";
    $query_seScanActual26out = sqlsrv_query($conn, $sql_seScanActual26out, $params_seScanActual26out);
    $result_seScanActual26out = sqlsrv_fetch_array($query_seScanActual26out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror26 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'26/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror26 = sqlsrv_query($conn, $sql_seScanINerror26, $params_seScanINerror26);
    // $result_seScanINerror26 = sqlsrv_fetch_array($query_seScanINerror26, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror26 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'26/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror26 = sqlsrv_query($conn, $sql_seScanOUTerror26, $params_seScanOUTerror26);
    // $result_seScanOUTerror26 = sqlsrv_fetch_array($query_seScanOUTerror26, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk26 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'26/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk26   = sqlsrv_query($conn, $sql_seLeavedaychk26, $params_seLeavedaychk26);
    $result_seLeavedaychk26  = sqlsrv_fetch_array($query_seLeavedaychk26, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk26['Leave_Memo'] == '') {
        $leavechk26 = '0';
    }else {
        $leavechk26 = '1';
    }

    $sql_sesundaychk26 = "SELECT DATENAME(DW,CONVERT(DATE,'26/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk26   = sqlsrv_query($conn, $sql_sesundaychk26, $params_sesundaychk26);
    $result_sesundaychk26  = sqlsrv_fetch_array($query_sesundaychk26, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual26in['TIMESCANACTUALIN'] == '' || $result_seScanActual26in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift26['JOBNO'] != '')) {
        $checkworking26 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual26in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift26['JOBNO'] == '') && ($result_sesundaychk26['SUNDAY'] !='Sunday')){
        $checkworking26 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking26 = '';
    }

    // if ($result_seScanActual26in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk26 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk26['Leave_Memo'] == '') {
    //         $latechk26 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk26 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
//////////////////////////////////////////////////////////////////////////////////////////////

    $sql_seScanActual27in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'27/".$month."/".$years."',103)";
    $query_seScanActual27in = sqlsrv_query($conn, $sql_seScanActual27in, $params_seScanActual27in);
    $result_seScanActual27in = sqlsrv_fetch_array($query_seScanActual27in, SQLSRV_FETCH_ASSOC);

    //หากะเวลาการทำงาน วันที่ 27
    $sql_seChk_Shift27 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'27/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift27 = sqlsrv_query($conn, $sql_seChk_Shift27, $params_seChk_Shift27);
    $result_seChk_Shift27 = sqlsrv_fetch_array($query_seChk_Shift27, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual27out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'27/".$month."/".$years."',103)";
    $query_seScanActual27out = sqlsrv_query($conn, $sql_seScanActual27out, $params_seScanActual27out);
    $result_seScanActual27out = sqlsrv_fetch_array($query_seScanActual27out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror27 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'27/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror27 = sqlsrv_query($conn, $sql_seScanINerror27, $params_seScanINerror27);
    // $result_seScanINerror27 = sqlsrv_fetch_array($query_seScanINerror27, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror27 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'27/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror27 = sqlsrv_query($conn, $sql_seScanOUTerror27, $params_seScanOUTerror27);
    // $result_seScanOUTerror27 = sqlsrv_fetch_array($query_seScanOUTerror27, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk27 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'27/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk27   = sqlsrv_query($conn, $sql_seLeavedaychk27, $params_seLeavedaychk27);
    $result_seLeavedaychk27  = sqlsrv_fetch_array($query_seLeavedaychk27, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk27['Leave_Memo'] == '') {
        $leavechk27 = '0';
    }else {
        $leavechk27 = '1';
    }

    $sql_sesundaychk27 = "SELECT DATENAME(DW,CONVERT(DATE,'27/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk27   = sqlsrv_query($conn, $sql_sesundaychk27, $params_sesundaychk27);
    $result_sesundaychk27  = sqlsrv_fetch_array($query_sesundaychk27, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual27in['TIMESCANACTUALIN'] == '' || $result_seScanActual27in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift27['JOBNO'] != '')) {
        $checkworking27 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual27in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift27['JOBNO'] == '') && ($result_sesundaychk27['SUNDAY'] !='Sunday')){
        $checkworking27 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking27 = '';
    }

    // if ($result_seScanActual27in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk27 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk27['Leave_Memo'] == '') {
    //         $latechk27 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk27 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
//////////////////////////////////////////////////////////////////////////////////////////////

    if ($result_secountdate['COUNTDATE'] == '28') {

    $sql_seScanActual28in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'I'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'28/".$month."/".$years."',103)";
    $query_seScanActual28in = sqlsrv_query($conn, $sql_seScanActual28in, $params_seScanActual28in);
    $result_seScanActual28in = sqlsrv_fetch_array($query_seScanActual28in, SQLSRV_FETCH_ASSOC);

     //หากะเวลาการทำงาน วันที่ 28
    $sql_seChk_Shift28 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
        b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
        FROM VEHICLETRANSPORTPLAN a
        INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
        INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
        WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
        AND (CONVERT(DATE,'28/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
    $query_seChk_Shift28 = sqlsrv_query($conn, $sql_seChk_Shift28, $params_seChk_Shift28);
    $result_seChk_Shift28 = sqlsrv_fetch_array($query_seChk_Shift28, SQLSRV_FETCH_ASSOC);

    $sql_seScanActual28out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
        FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        AND InOutMode = 'O'
        AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'28/".$month."/".$years."',103)";
    $query_seScanActual28out = sqlsrv_query($conn, $sql_seScanActual28out, $params_seScanActual28out);
    $result_seScanActual28out = sqlsrv_fetch_array($query_seScanActual28out, SQLSRV_FETCH_ASSOC);
    
    // //แสกน IN หลัง 17.00 (เลิกงาน)
    // $sql_seScanINerror28 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'I'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'28/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
    // $query_seScanINerror28 = sqlsrv_query($conn, $sql_seScanINerror28, $params_seScanINerror28);
    // $result_seScanINerror28 = sqlsrv_fetch_array($query_seScanINerror28, SQLSRV_FETCH_ASSOC);

    // //แสกน OUT ก่อน 08.00 (เข้างาน)
    // $sql_seScanOUTerror28 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
    //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
    //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
    //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
    //     AND InOutMode = 'O'
    //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'28/".$month."/".$years."',103)
    //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
    // $query_seScanOUTerror28 = sqlsrv_query($conn, $sql_seScanOUTerror28, $params_seScanOUTerror28);
    // $result_seScanOUTerror28 = sqlsrv_fetch_array($query_seScanOUTerror28, SQLSRV_FETCH_ASSOC);

    $sql_seLeavedaychk28 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
        CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
        FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
        WHERE PersonID ='".$result_sePlan['PersonID']."'
        AND Approve IN('A','2')
        AND StatusDel !='1'
        AND (CONVERT(DATE,'28/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
    $query_seLeavedaychk28   = sqlsrv_query($conn, $sql_seLeavedaychk28, $params_seLeavedaychk28);
    $result_seLeavedaychk28  = sqlsrv_fetch_array($query_seLeavedaychk28, SQLSRV_FETCH_ASSOC);

    if ($result_seLeavedaychk28['Leave_Memo'] == '') {
        $leavechk28 = '0';
    }else {
        $leavechk28 = '1';
    }

    $sql_sesundaychk28 = "SELECT DATENAME(DW,CONVERT(DATE,'28/".$month."/".$years."',103)) AS 'SUNDAY'";
    $query_sesundaychk28   = sqlsrv_query($conn, $sql_sesundaychk28, $params_sesundaychk28);
    $result_sesundaychk28  = sqlsrv_fetch_array($query_sesundaychk28, SQLSRV_FETCH_ASSOC);

    if (($result_seScanActual28in['TIMESCANACTUALIN'] == '' || $result_seScanActual28in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift28['JOBNO'] != '')) {
        $checkworking28 = 'อยู่ระหว่างวิ่งงาน';
    }else if(($result_seScanActual28in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift28['JOBNO'] == '') && ($result_sesundaychk28['SUNDAY'] !='Sunday')){
        $checkworking28 = 'พขร.อยู่บ้าน';
    }else {
        $checkworking28 = '';
    }

    // if ($result_seScanActual28in['TIMESCANACTUALIN'] <= '08:00:00' ) {
    //     $latechk28 = '0'; //มาตรงเวลา

    // }else {
    //     if ($result_seLeavedaychk28['Leave_Memo'] == '') {
    //         $latechk28 = '1'; //มาสายแต่ไม่ลางาน
    //     }else {
    //         $latechk28 = '0'; //มาสายแต่ลางาน
    //     }
        
    // }
//////////////////////////////////////////////////////////////////////////////////////////////////

    }if ($result_secountdate['COUNTDATE'] == '29') {
        $sql_seScanActual28in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
            ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
            FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
            WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
            AND InOutMode = 'I'
            AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'28/".$month."/".$years."',103)";
        $query_seScanActual28in = sqlsrv_query($conn, $sql_seScanActual28in, $params_seScanActual28in);
        $result_seScanActual28in = sqlsrv_fetch_array($query_seScanActual28in, SQLSRV_FETCH_ASSOC);

        //หากะเวลาการทำงาน วันที่ 28
        $sql_seChk_Shift28 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
            b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
            FROM VEHICLETRANSPORTPLAN a
            INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
            INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
            INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
            WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
            AND (CONVERT(DATE,'28/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
        $query_seChk_Shift28 = sqlsrv_query($conn, $sql_seChk_Shift28, $params_seChk_Shift28);
        $result_seChk_Shift28 = sqlsrv_fetch_array($query_seChk_Shift28, SQLSRV_FETCH_ASSOC);

        $sql_seScanActual28out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
            ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
            FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
            WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
            AND InOutMode = '0'
            AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'28/".$month."/".$years."',103)";
        $query_seScanActual28out = sqlsrv_query($conn, $sql_seScanActual28out, $params_seScanActual28out);
        $result_seScanActual28out = sqlsrv_fetch_array($query_seScanActual28out, SQLSRV_FETCH_ASSOC);

        // //แสกน IN หลัง 17.00 (เลิกงาน)
        // $sql_seScanINerror28 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
        //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        //     AND InOutMode = 'I'
        //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'28/".$month."/".$years."',103)
        //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
        // $query_seScanINerror28 = sqlsrv_query($conn, $sql_seScanINerror28, $params_seScanINerror29);
        // $result_seScanINerror28 = sqlsrv_fetch_array($query_seScanINerror28, SQLSRV_FETCH_ASSOC);

        // //แสกน OUT ก่อน 08.00 (เข้างาน)
        // $sql_seScanOUTerror28 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
        //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        //     AND InOutMode = 'O'
        //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'28/".$month."/".$years."',103)
        //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
        // $query_seScanOUTerror28 = sqlsrv_query($conn, $sql_seScanOUTerror28, $params_seScanOUTerror28);
        // $result_seScanOUTerror28 = sqlsrv_fetch_array($query_seScanOUTerror28, SQLSRV_FETCH_ASSOC);

        $sql_seLeavedaychk28 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
            CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
            FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
            WHERE PersonID ='".$result_sePlan['PersonID']."'
            AND Approve IN('A','2')
            AND (CONVERT(DATE,'28/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
        $query_seLeavedaychk28   = sqlsrv_query($conn, $sql_seLeavedaychk28, $params_seLeavedaychk28);
        $result_seLeavedaychk28  = sqlsrv_fetch_array($query_seLeavedaychk28, SQLSRV_FETCH_ASSOC);

        if ($result_seLeavedaychk28['Leave_Memo'] == '') {
            $leavechk28 = '0';
        }else {
            $leavechk28 = '1';
        }

        $sql_sesundaychk28 = "SELECT DATENAME(DW,CONVERT(DATE,'28/".$month."/".$years."',103)) AS 'SUNDAY'";
        $query_sesundaychk28   = sqlsrv_query($conn, $sql_sesundaychk28, $params_sesundaychk28);
        $result_sesundaychk28  = sqlsrv_fetch_array($query_sesundaychk28, SQLSRV_FETCH_ASSOC);

        if (($result_seScanActual28in['TIMESCANACTUALIN'] == '' || $result_seScanActual28in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift28['JOBNO'] != '')) {
            $checkworking28 = 'อยู่ระหว่างวิ่งงาน';
        }else if(($result_seScanActual28in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift28['JOBNO'] == '') && ($result_sesundaychk28['SUNDAY'] !='Sunday')){
            $checkworking28 = 'พขร.อยู่บ้าน';
        }else {
            $checkworking28 = '';
        }

        // if ($result_seScanActual28in['TIMESCANACTUALIN'] <= '08:00:00' ) {
        //     $latechk28 = '0'; //มาตรงเวลา
    
        // }else {
        //     if ($result_seLeavedaychk28['Leave_Memo'] == '') {
        //         $latechk28 = '1'; //มาสายแต่ไม่ลางาน
        //     }else {
        //         $latechk28 = '0'; //มาสายแต่ลางาน
        //     }
            
        // }
//////////////////////////////////////////////////////////////////////////////////////////////////

        $sql_seScanActual29in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
            ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
            FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
            WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
            AND InOutMode = 'I'
            AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'29/".$month."/".$years."',103)";
        $query_seScanActual29in = sqlsrv_query($conn, $sql_seScanActual29in, $params_seScanActual29in);
        $result_seScanActual29in = sqlsrv_fetch_array($query_seScanActual29in, SQLSRV_FETCH_ASSOC);

        //หากะเวลาการทำงาน วันที่ 29
        $sql_seChk_Shift29 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
            b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
            FROM VEHICLETRANSPORTPLAN a
            INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
            INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
            INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
            WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
            AND (CONVERT(DATE,'29/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
        $query_seChk_Shift29 = sqlsrv_query($conn, $sql_seChk_Shift29, $params_seChk_Shift29);
        $result_seChk_Shift29 = sqlsrv_fetch_array($query_seChk_Shift29, SQLSRV_FETCH_ASSOC);

        $sql_seScanActual29out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
            ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
            FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
            WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
            AND InOutMode = 'O'
            AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'29/".$month."/".$years."',103)";
        $query_seScanActual29out = sqlsrv_query($conn, $sql_seScanActual29out, $params_seScanActual29out);
        $result_seScanActual29out = sqlsrv_fetch_array($query_seScanActual29out, SQLSRV_FETCH_ASSOC);

        // //แสกน IN หลัง 17.00 (เลิกงาน)
        // $sql_seScanINerror29 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
        //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        //     AND InOutMode = 'I'
        //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'29/".$month."/".$years."',103)
        //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
        // $query_seScanINerror29 = sqlsrv_query($conn, $sql_seScanINerror29, $params_seScanINerror29);
        // $result_seScanINerror29 = sqlsrv_fetch_array($query_seScanINerror29, SQLSRV_FETCH_ASSOC);

        // //แสกน OUT ก่อน 08.00 (เข้างาน)
        // $sql_seScanOUTerror29 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
        //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        //     AND InOutMode = 'O'
        //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'29/".$month."/".$years."',103)
        //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
        // $query_seScanOUTerror29 = sqlsrv_query($conn, $sql_seScanOUTerror29, $params_seScanOUTerror29);
        // $result_seScanOUTerror29 = sqlsrv_fetch_array($query_seScanOUTerror29, SQLSRV_FETCH_ASSOC);

        $sql_seLeavedaychk29 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
            CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
            FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
            WHERE PersonID ='".$result_sePlan['PersonID']."'
            AND Approve IN('A','2')
            AND StatusDel !='1'
            AND (CONVERT(DATE,'29/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
        $query_seLeavedaychk29   = sqlsrv_query($conn, $sql_seLeavedaychk29, $params_seLeavedaychk29);
        $result_seLeavedaychk29  = sqlsrv_fetch_array($query_seLeavedaychk29, SQLSRV_FETCH_ASSOC);

        if ($result_seLeavedaychk29['Leave_Memo'] == '') {
            $leavechk29 = '0';
        }else {
            $leavechk29 = '1';
        }

        $sql_sesundaychk29 = "SELECT DATENAME(DW,CONVERT(DATE,'29/".$month."/".$years."',103)) AS 'SUNDAY'";
        $query_sesundaychk29   = sqlsrv_query($conn, $sql_sesundaychk29, $params_sesundaychk29);
        $result_sesundaychk29  = sqlsrv_fetch_array($query_sesundaychk29, SQLSRV_FETCH_ASSOC);

        if (($result_seScanActual29in['TIMESCANACTUALIN'] == '' || $result_seScanActual29in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift29['JOBNO'] != '')) {
            $checkworking29 = 'อยู่ระหว่างวิ่งงาน';
        }else if(($result_seScanActual29in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift29['JOBNO'] == '') && ($result_sesundaychk29['SUNDAY'] !='Sunday')){
            $checkworking29 = 'พขร.อยู่บ้าน';
        }else {
            $checkworking29 = '';
        }

        // if ($result_seScanActual29in['TIMESCANACTUALIN'] <= '08:00:00' ) {
        //     $latechk29 = '0'; //มาตรงเวลา
    
        // }else {
        //     if ($result_seLeavedaychk29['Leave_Memo'] == '') {
        //         $latechk29 = '1'; //มาสายแต่ไม่ลางาน
        //     }else {
        //         $latechk29 = '0'; //มาสายแต่ลางาน
        //     }
            
        // }
//////////////////////////////////////////////////////////////////////////////////////////////////

    }if ($result_secountdate['COUNTDATE'] == '30') {

        $sql_seScanActual28in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
            ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
            FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
            WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
            AND InOutMode = 'I'
            AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'28/".$month."/".$years."',103)";
        $query_seScanActual28in = sqlsrv_query($conn, $sql_seScanActual28in, $params_seScanActual28in);
        $result_seScanActual28in = sqlsrv_fetch_array($query_seScanActual28in, SQLSRV_FETCH_ASSOC);

        //หากะเวลาการทำงาน วันที่ 28
        $sql_seChk_Shift28 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
            b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
            FROM VEHICLETRANSPORTPLAN a
            INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
            INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
            INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
            WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
            AND (CONVERT(DATE,'28/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
        $query_seChk_Shift28 = sqlsrv_query($conn, $sql_seChk_Shift28, $params_seChk_Shift28);
        $result_seChk_Shift28 = sqlsrv_fetch_array($query_seChk_Shift28, SQLSRV_FETCH_ASSOC);

        $sql_seScanActual28out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
            ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
            FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
            WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
            AND InOutMode = 'O'
            AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'28/".$month."/".$years."',103)";
        $query_seScanActual28out = sqlsrv_query($conn, $sql_seScanActual28out, $params_seScanActual28out);
        $result_seScanActual28out = sqlsrv_fetch_array($query_seScanActual28out, SQLSRV_FETCH_ASSOC);
        
        // //แสกน IN หลัง 17.00 (เลิกงาน)
        // $sql_seScanINerror28 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
        //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        //     AND InOutMode = 'I'
        //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'28/".$month."/".$years."',103)
        //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
        // $query_seScanINerror28 = sqlsrv_query($conn, $sql_seScanINerror28, $params_seScanINerror28);
        // $result_seScanINerror28 = sqlsrv_fetch_array($query_seScanINerror28, SQLSRV_FETCH_ASSOC);

        // //แสกน OUT ก่อน 08.00 (เข้างาน)
        // $sql_seScanOUTerror28 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
        //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        //     AND InOutMode = 'O'
        //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'28/".$month."/".$years."',103)
        //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
        // $query_seScanOUTerror28 = sqlsrv_query($conn, $sql_seScanOUTerror28, $params_seScanOUTerror28);
        // $result_seScanOUTerror28 = sqlsrv_fetch_array($query_seScanOUTerror28, SQLSRV_FETCH_ASSOC);

        $sql_seLeavedaychk28 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
            CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
            FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
            WHERE PersonID ='".$result_sePlan['PersonID']."'
            AND Approve IN('A','2')
            AND StatusDel !='1'
            AND (CONVERT(DATE,'28/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
        $query_seLeavedaychk28   = sqlsrv_query($conn, $sql_seLeavedaychk28, $params_seLeavedaychk28);
        $result_seLeavedaychk28  = sqlsrv_fetch_array($query_seLeavedaychk28, SQLSRV_FETCH_ASSOC);

        if ($result_seLeavedaychk28['Leave_Memo'] == '') {
            $leavechk28 = '0';
        }else {
            $leavechk28 = '1';
        }

        $sql_sesundaychk28 = "SELECT DATENAME(DW,CONVERT(DATE,'28/".$month."/".$years."',103)) AS 'SUNDAY'";
        $query_sesundaychk28   = sqlsrv_query($conn, $sql_sesundaychk28, $params_sesundaychk28);
        $result_sesundaychk28  = sqlsrv_fetch_array($query_sesundaychk28, SQLSRV_FETCH_ASSOC);

        if (($result_seScanActual28in['TIMESCANACTUALIN'] == '' || $result_seScanActual28in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift28['JOBNO'] != '')) {
            $checkworking28 = 'อยู่ระหว่างวิ่งงาน';
        }else if(($result_seScanActual28in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift28['JOBNO'] == '') && ($result_sesundaychk28['SUNDAY'] !='Sunday')){
            $checkworking28 = 'พขร.อยู่บ้าน';
        }else {
            $checkworking28 = '';
        }

        // if ($result_seScanActual28in['TIMESCANACTUALIN'] <= '08:00:00' ) {
        //     $latechk28 = '0'; //มาตรงเวลา
    
        // }else {
        //     if ($result_seLeavedaychk28['Leave_Memo'] == '') {
        //         $latechk28 = '1'; //มาสายแต่ไม่ลางาน
        //     }else {
        //         $latechk28 = '0'; //มาสายแต่ลางาน
        //     }
            
        // }
//////////////////////////////////////////////////////////////////////////////////////////////////

        $sql_seScanActual29in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
            ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
            FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
            WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
            AND InOutMode = 'I'
            AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'29/".$month."/".$years."',103)";
        $query_seScanActual29in = sqlsrv_query($conn, $sql_seScanActual29in, $params_seScanActual29in);
        $result_seScanActual29in = sqlsrv_fetch_array($query_seScanActual29in, SQLSRV_FETCH_ASSOC);

        //หากะเวลาการทำงาน วันที่ 29
        $sql_seChk_Shift29 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
            b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
            FROM VEHICLETRANSPORTPLAN a
            INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
            INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
            INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
            WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
            AND (CONVERT(DATE,'29/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
        $query_seChk_Shift29 = sqlsrv_query($conn, $sql_seChk_Shift29, $params_seChk_Shift29);
        $result_seChk_Shift29 = sqlsrv_fetch_array($query_seChk_Shift29, SQLSRV_FETCH_ASSOC);

        $sql_seScanActual29out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
            ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
            FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
            WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
            AND InOutMode = 'O'
            AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'29/".$month."/".$years."',103)";
        $query_seScanActual29out = sqlsrv_query($conn, $sql_seScanActual29out, $params_seScanActual29out);
        $result_seScanActual29out = sqlsrv_fetch_array($query_seScanActual29out, SQLSRV_FETCH_ASSOC);

        // //แสกน IN หลัง 17.00 (เลิกงาน)
        // $sql_seScanINerror29 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
        //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        //     AND InOutMode = 'I'
        //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'29/".$month."/".$years."',103)
        //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
        // $query_seScanINerror29 = sqlsrv_query($conn, $sql_seScanINerror29, $params_seScanINerror29);
        // $result_seScanINerror29 = sqlsrv_fetch_array($query_seScanINerror29, SQLSRV_FETCH_ASSOC);

        // //แสกน OUT ก่อน 08.00 (เข้างาน)
        // $sql_seScanOUTerror29 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
        //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        //     AND InOutMode = 'O'
        //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'29/".$month."/".$years."',103)
        //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
        // $query_seScanOUTerror29 = sqlsrv_query($conn, $sql_seScanOUTerror29, $params_seScanOUTerror29);
        // $result_seScanOUTerror29 = sqlsrv_fetch_array($query_seScanOUTerror29, SQLSRV_FETCH_ASSOC);

        $sql_seLeavedaychk29 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
            CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
            FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
            WHERE PersonID ='".$result_sePlan['PersonID']."'
            AND Approve IN('A','2')
            AND StatusDel !='1'
            AND (CONVERT(DATE,'29/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
        $query_seLeavedaychk29   = sqlsrv_query($conn, $sql_seLeavedaychk29, $params_seLeavedaychk29);
        $result_seLeavedaychk29  = sqlsrv_fetch_array($query_seLeavedaychk29, SQLSRV_FETCH_ASSOC);

        if ($result_seLeavedaychk29['Leave_Memo'] == '') {
            $leavechk29 = '0';
        }else {
            $leavechk29 = '1';
        }

        $sql_sesundaychk29 = "SELECT DATENAME(DW,CONVERT(DATE,'29/".$month."/".$years."',103)) AS 'SUNDAY'";
        $query_sesundaychk29   = sqlsrv_query($conn, $sql_sesundaychk29, $params_sesundaychk29);
        $result_sesundaychk29  = sqlsrv_fetch_array($query_sesundaychk29, SQLSRV_FETCH_ASSOC);

        if (($result_seScanActual29in['TIMESCANACTUALIN'] == '' || $result_seScanActual29in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift29['JOBNO'] != '')) {
            $checkworking29 = 'อยู่ระหว่างวิ่งงาน';
        }else if(($result_seScanActual29in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift29['JOBNO'] == '') && ($result_sesundaychk29['SUNDAY'] !='Sunday')){
            $checkworking29 = 'พขร.อยู่บ้าน';
        }else {
            $checkworking29 = '';
        }

        // if ($result_seScanActual29in['TIMESCANACTUALIN'] <= '08:00:00' ) {
        //     $latechk29 = '0'; //มาตรงเวลา
    
        // }else {
        //     if ($result_seLeavedaychk29['Leave_Memo'] == '') {
        //         $latechk29 = '1'; //มาสายแต่ไม่ลางาน
        //     }else {
        //         $latechk29 = '0'; //มาสายแต่ลางาน
        //     }
            
        // }
//////////////////////////////////////////////////////////////////////////////////////////////////

        $sql_seScanActual30in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
            ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
            FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
            WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
            AND InOutMode = 'I'
            AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'30/".$month."/".$years."',103)";
        $query_seScanActual30in = sqlsrv_query($conn, $sql_seScanActual30in, $params_seScanActual30in);
        $result_seScanActual30in = sqlsrv_fetch_array($query_seScanActual30in, SQLSRV_FETCH_ASSOC);

        //หากะเวลาการทำงาน วันที่ 30
        $sql_seChk_Shift30 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
            b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
            FROM VEHICLETRANSPORTPLAN a
            INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
            INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
            INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
            WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
            AND (CONVERT(DATE,'30/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
        $query_seChk_Shift30 = sqlsrv_query($conn, $sql_seChk_Shift30, $params_seChk_Shift30);
        $result_seChk_Shift30 = sqlsrv_fetch_array($query_seChk_Shift30, SQLSRV_FETCH_ASSOC);

        $sql_seScanActual30out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
            ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
            FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
            WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
            AND InOutMode = 'O'
            AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'30/".$month."/".$years."',103)";
        $query_seScanActual30out = sqlsrv_query($conn, $sql_seScanActual30out, $params_seScanActual30out);
        $result_seScanActual30out = sqlsrv_fetch_array($query_seScanActual30out, SQLSRV_FETCH_ASSOC);
        
        // //แสกน IN หลัง 17.00 (เลิกงาน)
        // $sql_seScanINerror30 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
        //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        //     AND InOutMode = 'I'
        //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'30/".$month."/".$years."',103)
        //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
        // $query_seScanINerror30 = sqlsrv_query($conn, $sql_seScanINerror30, $params_seScanINerror30);
        // $result_seScanINerror30 = sqlsrv_fetch_array($query_seScanINerror30, SQLSRV_FETCH_ASSOC);

        // //แสกน OUT ก่อน 08.00 (เข้างาน)
        // $sql_seScanOUTerror30 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
        //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        //     AND InOutMode = 'O'
        //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'30/".$month."/".$years."',103)
        //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
        // $query_seScanOUTerror30 = sqlsrv_query($conn, $sql_seScanOUTerror30, $params_seScanOUTerror30);
        // $result_seScanOUTerror30 = sqlsrv_fetch_array($query_seScanOUTerror30, SQLSRV_FETCH_ASSOC);

        $sql_seLeavedaychk30 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
            CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
            FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
            WHERE PersonID ='".$result_sePlan['PersonID']."'
            AND Approve IN('A','2')
            AND StatusDel !='1'
            AND (CONVERT(DATE,'30/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
        $query_seLeavedaychk30   = sqlsrv_query($conn, $sql_seLeavedaychk30, $params_seLeavedaychk30);
        $result_seLeavedaychk30  = sqlsrv_fetch_array($query_seLeavedaychk30, SQLSRV_FETCH_ASSOC);

        if ($result_seLeavedaychk30['Leave_Memo'] == '') {
            $leavechk30 = '0';
        }else {
            $leavechk30 = '1';
        }

        $sql_sesundaychk30 = "SELECT DATENAME(DW,CONVERT(DATE,'30/".$month."/".$years."',103)) AS 'SUNDAY'";
        $query_sesundaychk30   = sqlsrv_query($conn, $sql_sesundaychk30, $params_sesundaychk30);
        $result_sesundaychk30  = sqlsrv_fetch_array($query_sesundaychk30, SQLSRV_FETCH_ASSOC);

        if (($result_seScanActual30in['TIMESCANACTUALIN'] == '' || $result_seScanActual30in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift30['JOBNO'] != '')) {
            $checkworking30 = 'อยู่ระหว่างวิ่งงาน';
        }else if(($result_seScanActual30in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift30['JOBNO'] == '') && ($result_sesundaychk30['SUNDAY'] !='Sunday')){
            $checkworking30 = 'พขร.อยู่บ้าน';
        }else {
            $checkworking30 = '';
        }

        // if ($result_seScanActual30in['TIMESCANACTUALIN'] <= '08:00:00' ) {
        //     $latechk30 = '0'; //มาตรงเวลา
    
        // }else {
        //     if ($result_seLeavedaychk30['Leave_Memo'] == '') {
        //         $latechk30 = '1'; //มาสายแต่ไม่ลางาน
        //     }else {
        //         $latechk30 = '0'; //มาสายแต่ลางาน
        //     }
            
        // }
//////////////////////////////////////////////////////////////////////////////////////////////////

    }else {
        $sql_seScanActual28in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
            ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
            FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
            WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
            AND InOutMode = 'I'
            AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'28/".$month."/".$years."',103)";
        $query_seScanActual28in = sqlsrv_query($conn, $sql_seScanActual28in, $params_seScanActual28in);
        $result_seScanActual28in = sqlsrv_fetch_array($query_seScanActual28in, SQLSRV_FETCH_ASSOC);

        //หากะเวลาการทำงาน วันที่ 28
        $sql_seChk_Shift28 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
            b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
            FROM VEHICLETRANSPORTPLAN a
            INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
            INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
            INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
            WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
            AND (CONVERT(DATE,'28/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
        $query_seChk_Shift28 = sqlsrv_query($conn, $sql_seChk_Shift28, $params_seChk_Shift28);
        $result_seChk_Shift28 = sqlsrv_fetch_array($query_seChk_Shift28, SQLSRV_FETCH_ASSOC);

        $sql_seScanActual28out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
            ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
            FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
            WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
            AND InOutMode = 'O'
            AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'28/".$month."/".$years."',103)";
        $query_seScanActual28out = sqlsrv_query($conn, $sql_seScanActual28out, $params_seScanActual28out);
        $result_seScanActual28out = sqlsrv_fetch_array($query_seScanActual28out, SQLSRV_FETCH_ASSOC);

        // //แสกน IN หลัง 17.00 (เลิกงาน)
        // $sql_seScanINerror28 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
        //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        //     AND InOutMode = 'I'
        //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'28/".$month."/".$years."',103)
        //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
        // $query_seScanINerror28 = sqlsrv_query($conn, $sql_seScanINerror28, $params_seScanINerror28);
        // $result_seScanINerror28 = sqlsrv_fetch_array($query_seScanINerror28, SQLSRV_FETCH_ASSOC);

        // //แสกน OUT ก่อน 08.00 (เข้างาน)
        // $sql_seScanOUTerror28 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
        //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        //     AND InOutMode = 'O'
        //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'28/".$month."/".$years."',103)
        //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
        // $query_seScanOUTerror28 = sqlsrv_query($conn, $sql_seScanOUTerror28, $params_seScanOUTerror28);
        // $result_seScanOUTerror28 = sqlsrv_fetch_array($query_seScanOUTerror28, SQLSRV_FETCH_ASSOC);

        $sql_seLeavedaychk28 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
            CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
            FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
            WHERE PersonID ='".$result_sePlan['PersonID']."'
            AND Approve IN('A','2')
            AND StatusDel !='1'
            AND (CONVERT(DATE,'28/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
        $query_seLeavedaychk28   = sqlsrv_query($conn, $sql_seLeavedaychk28, $params_seLeavedaychk28);
        $result_seLeavedaychk28  = sqlsrv_fetch_array($query_seLeavedaychk28, SQLSRV_FETCH_ASSOC);

        if ($result_seLeavedaychk28['Leave_Memo'] == '') {
            $leavechk28 = '0';
        }else {
            $leavechk28 = '1';
        }

        $sql_sesundaychk28 = "SELECT DATENAME(DW,CONVERT(DATE,'28/".$month."/".$years."',103)) AS 'SUNDAY'";
        $query_sesundaychk28   = sqlsrv_query($conn, $sql_sesundaychk28, $params_sesundaychk28);
        $result_sesundaychk28  = sqlsrv_fetch_array($query_sesundaychk28, SQLSRV_FETCH_ASSOC);

        if (($result_seScanActual28in['TIMESCANACTUALIN'] == '' || $result_seScanActual28in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift28['JOBNO'] != '')) {
            $checkworking28 = 'อยู่ระหว่างวิ่งงาน';
        }else if(($result_seScanActual28in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift28['JOBNO'] == '') && ($result_sesundaychk28['SUNDAY'] !='Sunday')){
            $checkworking28 = 'พขร.อยู่บ้าน';
        }else {
            $checkworking28 = '';
        }

        // if ($result_seScanActual28in['TIMESCANACTUALIN'] <= '08:00:00' ) {
        //     $latechk28 = '0'; //มาตรงเวลา
    
        // }else {
        //     if ($result_seLeavedaychk28['Leave_Memo'] == '') {
        //         $latechk28 = '1'; //มาสายแต่ไม่ลางาน
        //     }else {
        //         $latechk28 = '0'; //มาสายแต่ลางาน
        //     }
            
        // }
//////////////////////////////////////////////////////////////////////////////////////////////////

        $sql_seScanActual29in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
            ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
            FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
            WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
            AND InOutMode = 'I'
            AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'29/".$month."/".$years."',103)";
        $query_seScanActual29in = sqlsrv_query($conn, $sql_seScanActual29in, $params_seScanActual29in);
        $result_seScanActual29in = sqlsrv_fetch_array($query_seScanActual29in, SQLSRV_FETCH_ASSOC);

        //หากะเวลาการทำงาน วันที่ 29
        $sql_seChk_Shift29 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
            b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
            FROM VEHICLETRANSPORTPLAN a
            INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
            INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
            INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
            WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
            AND (CONVERT(DATE,'29/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
        $query_seChk_Shift29 = sqlsrv_query($conn, $sql_seChk_Shift29, $params_seChk_Shift29);
        $result_seChk_Shift29 = sqlsrv_fetch_array($query_seChk_Shift29, SQLSRV_FETCH_ASSOC);

        $sql_seScanActual29out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
            ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
            FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
            WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
            AND InOutMode = 'O'
            AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'29/".$month."/".$years."',103)";
        $query_seScanActual29out = sqlsrv_query($conn, $sql_seScanActual29out, $params_seScanActual29out);
        $result_seScanActual29out = sqlsrv_fetch_array($query_seScanActual29out, SQLSRV_FETCH_ASSOC);

        // //แสกน IN หลัง 17.00 (เลิกงาน)
        // $sql_seScanINerror29 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
        //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        //     AND InOutMode = 'I'
        //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'29/".$month."/".$years."',103)
        //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
        // $query_seScanINerror29 = sqlsrv_query($conn, $sql_seScanINerror29, $params_seScanINerror29);
        // $result_seScanINerror29 = sqlsrv_fetch_array($query_seScanINerror29, SQLSRV_FETCH_ASSOC);

        // //แสกน OUT ก่อน 08.00 (เข้างาน)
        // $sql_seScanOUTerror29 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
        //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        //     AND InOutMode = 'O'
        //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'29/".$month."/".$years."',103)
        //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
        // $query_seScanOUTerror29 = sqlsrv_query($conn, $sql_seScanOUTerror29, $params_seScanOUTerror29);
        // $result_seScanOUTerror29 = sqlsrv_fetch_array($query_seScanOUTerror29, SQLSRV_FETCH_ASSOC);

        $sql_seLeavedaychk29 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
            CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
            FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
            WHERE PersonID ='".$result_sePlan['PersonID']."'
            AND Approve IN('A','2')
            AND StatusDel !='1'
            AND (CONVERT(DATE,'29/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
        $query_seLeavedaychk29   = sqlsrv_query($conn, $sql_seLeavedaychk29, $params_seLeavedaychk29);
        $result_seLeavedaychk29  = sqlsrv_fetch_array($query_seLeavedaychk29, SQLSRV_FETCH_ASSOC);

        if ($result_seLeavedaychk29['Leave_Memo'] == '') {
            $leavechk29 = '0';
        }else {
            $leavechk29 = '1';
        }

        $sql_sesundaychk29 = "SELECT DATENAME(DW,CONVERT(DATE,'29/".$month."/".$years."',103)) AS 'SUNDAY'";
        $query_sesundaychk29   = sqlsrv_query($conn, $sql_sesundaychk29, $params_sesundaychk29);
        $result_sesundaychk29  = sqlsrv_fetch_array($query_sesundaychk29, SQLSRV_FETCH_ASSOC);

        if (($result_seScanActual29in['TIMESCANACTUALIN'] == '' || $result_seScanActual29in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift29['JOBNO'] != '')) {
            $checkworking29 = 'อยู่ระหว่างวิ่งงาน';
        }else if(($result_seScanActual29in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift29['JOBNO'] == '') && ($result_sesundaychk29['SUNDAY'] !='Sunday')){
            $checkworking29 = 'พขร.อยู่บ้าน';
        }else {
            $checkworking29 = '';
        }

        // if ($result_seScanActual29in['TIMESCANACTUALIN'] <= '08:00:00' ) {
        //     $latechk29 = '0'; //มาตรงเวลา
    
        // }else {
        //     if ($result_seLeavedaychk29['Leave_Memo'] == '') {
        //         $latechk29 = '1'; //มาสายแต่ไม่ลางาน
        //     }else {
        //         $latechk9 = '0'; //มาสายแต่ลางาน
        //     }
            
        // }
//////////////////////////////////////////////////////////////////////////////////////////////////

        $sql_seScanActual30in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
            ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
            FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
            WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
            AND InOutMode = 'I'
            AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'30/".$month."/".$years."',103)";
        $query_seScanActual30in = sqlsrv_query($conn, $sql_seScanActual30in, $params_seScanActual30in);
        $result_seScanActual30in = sqlsrv_fetch_array($query_seScanActual30in, SQLSRV_FETCH_ASSOC);

        //หากะเวลาการทำงาน วันที่ 30
        $sql_seChk_Shift30 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
            b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
            FROM VEHICLETRANSPORTPLAN a
            INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
            INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
            INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
            WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
            AND (CONVERT(DATE,'30/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
        $query_seChk_Shift30 = sqlsrv_query($conn, $sql_seChk_Shift30, $params_seChk_Shift30);
        $result_seChk_Shift30 = sqlsrv_fetch_array($query_seChk_Shift30, SQLSRV_FETCH_ASSOC);

        $sql_seScanActual30out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
            ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
            FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
            WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
            AND InOutMode = 'O'
            AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'30/".$month."/".$years."',103)";
        $query_seScanActual30out = sqlsrv_query($conn, $sql_seScanActual30out, $params_seScanActual30out);
        $result_seScanActual30out = sqlsrv_fetch_array($query_seScanActual30out, SQLSRV_FETCH_ASSOC);

        // //แสกน IN หลัง 17.00 (เลิกงาน)
        // $sql_seScanINerror30 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
        //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        //     AND InOutMode = 'I'
        //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'30/".$month."/".$years."',103)
        //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
        // $query_seScanINerror30 = sqlsrv_query($conn, $sql_seScanINerror30, $params_seScanINerror30);
        // $result_seScanINerror30 = sqlsrv_fetch_array($query_seScanINerror30, SQLSRV_FETCH_ASSOC);

        // //แสกน OUT ก่อน 08.00 (เข้างาน)
        // $sql_seScanOUTerror30 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
        //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        //     AND InOutMode = 'O'
        //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'30/".$month."/".$years."',103)
        //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
        // $query_seScanOUTerror30 = sqlsrv_query($conn, $sql_seScanOUTerror30, $params_seScanOUTerror30);
        // $result_seScanOUTerror30 = sqlsrv_fetch_array($query_seScanOUTerror30, SQLSRV_FETCH_ASSOC);

        $sql_seLeavedaychk30 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
            CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
            FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
            WHERE PersonID ='".$result_sePlan['PersonID']."'
            AND Approve IN('A','2')
            AND StatusDel !='1'
            AND (CONVERT(DATE,'30/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
        $query_seLeavedaychk30   = sqlsrv_query($conn, $sql_seLeavedaychk30, $params_seLeavedaychk30);
        $result_seLeavedaychk30  = sqlsrv_fetch_array($query_seLeavedaychk30, SQLSRV_FETCH_ASSOC);

        if ($result_seLeavedaychk30['Leave_Memo'] == '') {
            $leavechk30 = '0';
        }else {
            $leavechk30 = '1';
        }

        $sql_sesundaychk30 = "SELECT DATENAME(DW,CONVERT(DATE,'30/".$month."/".$years."',103)) AS 'SUNDAY'";
        $query_sesundaychk30   = sqlsrv_query($conn, $sql_sesundaychk30, $params_sesundaychk30);
        $result_sesundaychk30  = sqlsrv_fetch_array($query_sesundaychk30, SQLSRV_FETCH_ASSOC);

        if (($result_seScanActual30in['TIMESCANACTUALIN'] == '' || $result_seScanActual30in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift30['JOBNO'] != '')) {
            $checkworking30 = 'อยู่ระหว่างวิ่งงาน';
        }else if(($result_seScanActual30in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift30['JOBNO'] == '') && ($result_sesundaychk30['SUNDAY'] !='Sunday')){
            $checkworking30 = 'พขร.อยู่บ้าน';
        }else {
            $checkworking30 = '';
        }

        // if ($result_seScanActual30in['TIMESCANACTUALIN'] <= '08:00:00' ) {
        //     $latechk30 = '0'; //มาตรงเวลา
    
        // }else {
        //     if ($result_seLeavedaychk30['Leave_Memo'] == '') {
        //         $latechk30 = '1'; //มาสายแต่ไม่ลางาน
        //     }else {
        //         $latechk30 = '0'; //มาสายแต่ลางาน
        //     }
            
        // }
//////////////////////////////////////////////////////////////////////////////////////////////////

        $sql_seScanActual31in = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALIN'
            ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALIN'
            FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
            WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
            AND InOutMode = 'I'
            AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'31/".$month."/".$years."',103)";
        $query_seScanActual31in = sqlsrv_query($conn, $sql_seScanActual31in, $params_seScanActual31in);
        $result_seScanActual31in = sqlsrv_fetch_array($query_seScanActual31in, SQLSRV_FETCH_ASSOC);

        //หากะเวลาการทำงาน วันที่ 31
        $sql_seChk_Shift31 = "SELECT DISTINCT a.JOBNO,a.VEHICLETRANSPORTPLANID,a.EMPLOYEECODE1,a.EMPLOYEECODE2, a.TENKOMASTERID AS 'MASTERPLAN',
            b.TENKOMASTERID AS 'MASTERID',c.TENKOMASTERID AS 'BEFOREMASTERID'
            FROM VEHICLETRANSPORTPLAN a
            INNER JOIN TENKOMASTER b ON b.TENKOMASTERID = a.TENKOMASTERID
            INNER JOIN TENKOBEFORE c ON c.TENKOMASTERID = a.TENKOMASTERID
            INNER JOIN TENKOAFTER d ON d.TENKOMASTERID = a.TENKOMASTERID
            WHERE (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
            AND (CONVERT(DATE,'31/".$month."/".$years."',103) BETWEEN CONVERT(DATE,c.CREATEDATE,103) AND CONVERT(DATE,d.TENKOAFTERDATE,103))";
        $query_seChk_Shift31 = sqlsrv_query($conn, $sql_seChk_Shift31, $params_seChk_Shift31);
        $result_seChk_Shift31 = sqlsrv_fetch_array($query_seChk_Shift31, SQLSRV_FETCH_ASSOC);

        $sql_seScanActual31out = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
            ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT'
            FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
            WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
            AND InOutMode = 'O'
            AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'31/".$month."/".$years."',103)";
        $query_seScanActual31out = sqlsrv_query($conn, $sql_seScanActual31out, $params_seScanActual31out);
        $result_seScanActual31out = sqlsrv_fetch_array($query_seScanActual31out, SQLSRV_FETCH_ASSOC);

        // //แสกน IN หลัง 17.00 (เลิกงาน)
        // $sql_seScanINerror31 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
        //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        //     AND InOutMode = 'I'
        //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'31/".$month."/".$years."',103)
        //     AND CONVERT(VARCHAR(5),timeinout,108) >= '17:00'";
        // $query_seScanINerror31 = sqlsrv_query($conn, $sql_seScanINerror31, $params_seScanINerror31);
        // $result_seScanINerror31 = sqlsrv_fetch_array($query_seScanINerror31, SQLSRV_FETCH_ASSOC);

        // //แสกน OUT ก่อน 08.00 (เข้างาน)
        // $sql_seScanOUTerror31 = "SELECT DISTINCT CONVERT(NVARCHAR(10),timeinout,103) AS 'DATESCANACTUALOUT'
        //     ,CONVERT(VARCHAR(5),timeinout,108) AS 'TIMESCANACTUALOUT',InOutMode
        //     FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut]
        //     WHERE personcardid = '".$result_sePlan['EMPLOYEECODE']."'
        //     AND InOutMode = 'O'
        //     AND CONVERT(DATE,Timeinout,103) = CONVERT(DATE,'31/".$month."/".$years."',103)
        //     AND CONVERT(VARCHAR(5),timeinout,108) <= '08.00'";
        // $query_seScanOUTerror31 = sqlsrv_query($conn, $sql_seScanOUTerror31, $params_seScanOUTerror31);
        // $result_seScanOUTerror31 = sqlsrv_fetch_array($query_seScanOUTerror31, SQLSRV_FETCH_ASSOC);

        $sql_seLeavedaychk31 = "SELECT PersonID,Leave_Memo,Leave_DateTotal,Approve,User_Approve,StatusDel,
            CONVERT(VARCHAR(10),Leave_DateS,103) AS 'Leave_DateS',CONVERT(VARCHAR(10),Leave_DateE,103) AS 'Leave_DateS'
            FROM [203.150.225.30].[TigerE-HR].[dbo].[TAP_LeaveForm]
            WHERE PersonID ='".$result_sePlan['PersonID']."'
            AND Approve IN('A','2')
            AND StatusDel !='1'
            AND (CONVERT(DATE,'31/".$month."/".$years."',103) BETWEEN CONVERT(DATE,Leave_DateS,103) AND CONVERT(DATE,Leave_DateE,103))";
        $query_seLeavedaychk31   = sqlsrv_query($conn, $sql_seLeavedaychk31, $params_seLeavedaychk31);
        $result_seLeavedaychk31  = sqlsrv_fetch_array($query_seLeavedaychk31, SQLSRV_FETCH_ASSOC);

        if ($result_seLeavedaychk31['Leave_Memo'] == '') {
            $leavechk31 = '0';
        }else {
            $leavechk31 = '1';
        }

        $sql_sesundaychk31 = "SELECT DATENAME(DW,CONVERT(DATE,'31/".$month."/".$years."',103)) AS 'SUNDAY'";
        $query_sesundaychk31   = sqlsrv_query($conn, $sql_sesundaychk31, $params_sesundaychk31);
        $result_sesundaychk31  = sqlsrv_fetch_array($query_sesundaychk31, SQLSRV_FETCH_ASSOC);

        if (($result_seScanActual31in['TIMESCANACTUALIN'] == '' || $result_seScanActual31in['TIMESCANACTUALIN'] != '') && ($result_seChk_Shift31['JOBNO'] != '')) {
            $checkworking31 = 'อยู่ระหว่างวิ่งงาน';
        }else if(($result_seScanActual31in['TIMESCANACTUALIN'] == '') && ($result_seChk_Shift31['JOBNO'] == '') && ($result_sesundaychk31['SUNDAY'] !='Sunday')){
            $checkworking31 = 'พขร.อยู่บ้าน';
        }else {
            $checkworking31 = '';
        }

        // if ($result_seScanActual31in['TIMESCANACTUALIN'] <= '08:00:00' ) {
        //     $latechk31 = '0'; //มาตรงเวลา
    
        // }else {
        //     if ($result_seLeavedaychk31['Leave_Memo'] == '') {
        //         $latechk31 = '1'; //มาสายแต่ไม่ลางาน
        //     }else {
        //         $latechk31 = '0'; //มาสายแต่ลางาน
        //     }
            
        // }
//////////////////////////////////////////////////////////////////////////////////////////////////
    }





/////////////////////////////////////////////////////////////////////////////////////////////////////



    // if ($result_seCheckIN['LAT'] == '' && $result_seCheckIN['LONG'] == '' && $result_seCheckIN['ADDRESS'] == '') {
    //     $color = "background-color: #FF9966";
    // } else {
    //     $color = "";
    // }

    // วันที่1
    if ($result_seChk_Shift1['JOBNO'] != '') {
        $check1 = '35';
    }else {
        if ( $result_seScanActual1in['TIMESCANACTUALIN'] !='' && $result_seScanActual1out['TIMESCANACTUALOUT'] !='' ) {
            $check1 = '35';
        }else {
            $check1 = '0';
        }
    }
    // วันที่2
    if ($result_seChk_Shift2['JOBNO'] != '') {
        $check2 = '35';
    }else {
        if ( $result_seScanActual2in['TIMESCANACTUALIN'] !='' && $result_seScanActual2out['TIMESCANACTUALOUT'] !='' ) {
            $check2 = '35';
        }else {
            $check2 = '0';
        }
    }
    // วันที่3
    if ($result_seChk_Shift3['JOBNO'] != '') {
        $check3 = '35';
    }else {
        if ( $result_seScanActual3in['TIMESCANACTUALIN'] !='' && $result_seScanActual3out['TIMESCANACTUALOUT'] !='' ) {
            $check3 = '35';
        }else {
            $check3 = '0';
        }
    }
    // วันที่4
    if ($result_seChk_Shift4['JOBNO'] != '') {
        $check4 = '35';
    }else {
        if ( $result_seScanActual4in['TIMESCANACTUALIN'] !='' && $result_seScanActual4out['TIMESCANACTUALOUT'] !='' ) {
            $check4 = '35';
        }else {
            $check4 = '0';
        }
    }
    // วันที่5
    if ($result_seChk_Shift5['JOBNO'] != '') {
        $check5 = '35';
    }else {
        if ( $result_seScanActual5in['TIMESCANACTUALIN'] !='' && $result_seScanActual5out['TIMESCANACTUALOUT'] !='' ) {
            $check5 = '35';
        }else {
            $check5 = '0';
        }
    }
    // วันที่6
    if ($result_seChk_Shift6['JOBNO'] != '') {
        $check6 = '35';
    }else {
        if ( $result_seScanActual6in['TIMESCANACTUALIN'] !='' && $result_seScanActual6out['TIMESCANACTUALOUT'] !='' ) {
            $check6 = '35';
        }else {
            $check6 = '0';
        }
    }
    // วันที่7
    if ($result_seChk_Shift7['JOBNO'] != '') {
        $check7 = '35';
    }else {
        if ( $result_seScanActual7in['TIMESCANACTUALIN'] !='' && $result_seScanActual7out['TIMESCANACTUALOUT'] !='' ) {
            $check7 = '35';
        }else {
            $check7 = '0';
        }
    }
    // วันที่8
    if ($result_seChk_Shift8['JOBNO'] != '') {
        $check8 = '35';
    }else {
        if ( $result_seScanActual8in['TIMESCANACTUALIN'] !='' && $result_seScanActual8out['TIMESCANACTUALOUT'] !='' ) {
            $check8 = '35';
        }else {
            $check8 = '0';
        }
    }
    // วันที่9
    if ($result_seChk_Shift9['JOBNO'] != '') {
        $check9 = '35';
    }else {
        if ( $result_seScanActual9in['TIMESCANACTUALIN'] !='' && $result_seScanActual9out['TIMESCANACTUALOUT'] !='' ) {
            $check9 = '35';
        }else {
            $check9 = '0';
        }
    }
    // วันที่10
    if ($result_seChk_Shift10['JOBNO'] != '') {
        $check10 = '35';
    }else {
        if ( $result_seScanActual10in['TIMESCANACTUALIN'] !='' && $result_seScanActual10out['TIMESCANACTUALOUT'] !='' ) {
            $check10 = '35';
        }else {
            $check10 = '0';
        }
    }
    // วันที่11
    if ($result_seChk_Shift11['JOBNO'] != '') {
        $check11 = '35';
    }else {
        if ( $result_seScanActual11in['TIMESCANACTUALIN'] !='' && $result_seScanActual11out['TIMESCANACTUALOUT'] !='' ) {
            $check11 = '35';
        }else {
            $check11 = '0';
        }
    }
    // วันที่12
    if ($result_seChk_Shift12['JOBNO'] != '') {
        $check12 = '35';
    }else {
        if ( $result_seScanActual12in['TIMESCANACTUALIN'] !='' && $result_seScanActual12out['TIMESCANACTUALOUT'] !='' ) {
            $check12 = '35';
        }else {
            $check12 = '0';
        }
    }
    // วันที่13
    if ($result_seChk_Shift13['JOBNO'] != '') {
        $check13 = '35';
    }else {
        if ( $result_seScanActual13in['TIMESCANACTUALIN'] !='' && $result_seScanActual13out['TIMESCANACTUALOUT'] !='' ) {
            $check13 = '35';
        }else {
            $check13 = '0';
        }
    }
    // วันที่14
    if ($result_seChk_Shift14['JOBNO'] != '') {
        $check14 = '35';
    }else {
        if ( $result_seScanActual14in['TIMESCANACTUALIN'] !='' && $result_seScanActual14out['TIMESCANACTUALOUT'] !='' ) {
            $check14 = '35';
        }else {
            $check14 = '0';
        }
    }
    // วันที่15
    if ($result_seChk_Shift15['JOBNO'] != '') {
        $check15 = '35';
    }else {
        if ( $result_seScanActual15in['TIMESCANACTUALIN'] !='' && $result_seScanActual15out['TIMESCANACTUALOUT'] !='' ) {
            $check15 = '35';
        }else {
            $check15 = '0';
        }
    }
    // วันที่16
    if ($result_seChk_Shift16['JOBNO'] != '') {
        $check16 = '35';
    }else {
        if ( $result_seScanActual16in['TIMESCANACTUALIN'] !='' && $result_seScanActual16out['TIMESCANACTUALOUT'] !='' ) {
            $check16 = '35';
        }else {
            $check16 = '0';
        }
    }
    // วันที่17
    if ($result_seChk_Shift17['JOBNO'] != '') {
        $check17 = '35';
    }else {
        if ( $result_seScanActual17in['TIMESCANACTUALIN'] !='' && $result_seScanActual17out['TIMESCANACTUALOUT'] !='' ) {
            $check17 = '35';
        }else {
            $check17 = '0';
        }
    }
    // วันที่18
    if ($result_seChk_Shift18['JOBNO'] != '') {
        $check18 = '35';
    }else {
        if ( $result_seScanActual18in['TIMESCANACTUALIN'] !='' && $result_seScanActual18out['TIMESCANACTUALOUT'] !='' ) {
            $check18 = '35';
        }else {
            $check18 = '0';
        }
    }
    // วันที่19
    if ($result_seChk_Shift19['JOBNO'] != '') {
        $check19 = '35';
    }else {
        if ( $result_seScanActual19in['TIMESCANACTUALIN'] !='' && $result_seScanActual19out['TIMESCANACTUALOUT'] !='' ) {
            $check19 = '35';
        }else {
            $check19 = '0';
        }
    }
    // วันที่20
    if ($result_seChk_Shift20['JOBNO'] != '') {
        $check20 = '35';
    }else {
        if ( $result_seScanActual20in['TIMESCANACTUALIN'] !='' && $result_seScanActual20out['TIMESCANACTUALOUT'] !='' ) {
            $check20 = '35';
        }else {
            $check20 = '0';
        }
    }
    // วันที่21
    if ($result_seChk_Shift21['JOBNO'] != '') {
        $check21 = '35';
    }else {
        if ( $result_seScanActual21in['TIMESCANACTUALIN'] !='' && $result_seScanActual21out['TIMESCANACTUALOUT'] !='' ) {
            $check21 = '35';
        }else {
            $check21 = '0';
        }
    }
    // วันที่22
    if ($result_seChk_Shift22['JOBNO'] != '') {
        $check22 = '35';
    }else {
        if ( $result_seScanActual22in['TIMESCANACTUALIN'] !='' && $result_seScanActual22out['TIMESCANACTUALOUT'] !='' ) {
            $check22 = '35';
        }else {
            $check22 = '0';
        }
    }
    // วันที่23
    if ($result_seChk_Shift23['JOBNO'] != '') {
        $check23 = '35';
    }else {
        if ( $result_seScanActual23in['TIMESCANACTUALIN'] !='' && $result_seScanActual23out['TIMESCANACTUALOUT'] !='' ) {
            $check23 = '35';
        }else {
            $check23 = '0';
        }
    }
    // วันที่24
    if ($result_seChk_Shift24['JOBNO'] != '') {
        $check24 = '35';
    }else {
        if ( $result_seScanActual24in['TIMESCANACTUALIN'] !='' && $result_seScanActual24out['TIMESCANACTUALOUT'] !='' ) {
            $check24 = '35';
        }else {
            $check24 = '0';
        }
    }
    // วันที่25
    if ($result_seChk_Shift25['JOBNO'] != '') {
        $check25 = '35';
    }else {
        if ( $result_seScanActual25in['TIMESCANACTUALIN'] !='' && $result_seScanActual25out['TIMESCANACTUALOUT'] !='' ) {
            $check25 = '35';
        }else {
            $check25 = '0';
        }
    }
    // วันที่26
    if ($result_seChk_Shift26['JOBNO'] != '') {
        $check26 = '35';
    }else {
        if ( $result_seScanActual26in['TIMESCANACTUALIN'] !='' && $result_seScanActual26out['TIMESCANACTUALOUT'] !='' ) {
            $check26 = '35';
        }else {
            $check26 = '0';
        }
    }
    // วันที่27
    if ($result_seChk_Shift27['JOBNO'] != '') {
        $check27 = '35';
    }else {
        if ( $result_seScanActual27in['TIMESCANACTUALIN'] !='' && $result_seScanActual27out['TIMESCANACTUALOUT'] !='' ) {
            $check27 = '35';
        }else {
            $check27 = '0';
        }
    }
    // วันที่28
    if ($result_seChk_Shift28['JOBNO'] != '') {
        $check28 = '35';
    }else {
        if ( $result_seScanActual28in['TIMESCANACTUALIN'] !='' && $result_seScanActual28out['TIMESCANACTUALOUT'] !='' ) {
            $check28 = '35';
        }else {
            $check28 = '0';
        }
    }
    // วันที่29
    if ($result_seChk_Shift29['JOBNO'] != '') {
        $check29 = '35';
    }else {
        if ( $result_seScanActual29in['TIMESCANACTUALIN'] !='' && $result_seScanActual29out['TIMESCANACTUALOUT'] !='' ) {
            $check29 = '35';
        }else {
            $check29 = '0';
        }
    }
    // วันที่30
    if ($result_seChk_Shift30['JOBNO'] != '') {
        $check30 = '35';
    }else {
        if ( $result_seScanActual30in['TIMESCANACTUALIN'] !='' && $result_seScanActual30out['TIMESCANACTUALOUT'] !='' ) {
            $check30 = '35';
        }else {
            $check30 = '0';
        }
    }
    // วันที่31
    if ($result_seChk_Shift31['JOBNO'] != '') {
        $check31 = '35';
    }else {
        if ( $result_seScanActual31in['TIMESCANACTUALIN'] !='' && $result_seScanActual31out['TIMESCANACTUALOUT'] !='' ) {
            $check31 = '35';
        }else {
            $check31 = '0';
        }
    }
?>

    <tbody>
                <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >1</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >01/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday1 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk1['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late1 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk1['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual1in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual1in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual1out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual1out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror1['DATESCANACTUALOUT']?> : <?= $result_seScanINerror1['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror1['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror1['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror1['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror1['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift1['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking1 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check1 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >2</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >02/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday2 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk2['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late2 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk2['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual2in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual2in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual2out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual2out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror2['DATESCANACTUALOUT']?> : <?= $result_seScanINerror2['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror2['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror2['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror2['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror2['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift2['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking2 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check2 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >3</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >03/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday3 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk3['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late3 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk3['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual3in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual3in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual3out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual3out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror3['DATESCANACTUALOUT']?> : <?= $result_seScanINerror3['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror3['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror3['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror3['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror3['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift3['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking3 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check3 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >4</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >04/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday4 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk4['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late4 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk4['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual4in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual4in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual4out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual4out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror4['DATESCANACTUALOUT']?> : <?= $result_seScanINerror4['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror4['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror4['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror4['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror4['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift4['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking4 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check4 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >5</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >05/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday5 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk5['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late5 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk5['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual5in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual5in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual5out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual5out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror5['DATESCANACTUALOUT']?> : <?= $result_seScanINerror5['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror5['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror5['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror5['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror5['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift5['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking5 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check5 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >6</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >06/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday6 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk6['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late6 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk6['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual6in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual6in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual6out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual6out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror6['DATESCANACTUALOUT']?> : <?= $result_seScanINerror6['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror6['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror6['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror6['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror6['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift6['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking6 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check6 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >7</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >07/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday7 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk7['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late7 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk7['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual7in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual7in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual7out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual7out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror7['DATESCANACTUALOUT']?> : <?= $result_seScanINerror7['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror7['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror7['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror7['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror7['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift7['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking7 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check7 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >8</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >08/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday8 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk8['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late8 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk8['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual8in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual8in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual8out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual8out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror8['DATESCANACTUALOUT']?> : <?= $result_seScanINerror8['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror8['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror8['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror8['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror8['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift8['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking8 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check8 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >9</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >09/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday9 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk9['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late9 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk9['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual9in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual9in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual9out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual9out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror9['DATESCANACTUALOUT']?> : <?= $result_seScanINerror9['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror9['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror9['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror9['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror9['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift9['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking9 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check9 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >10</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >10/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday10 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk10['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late10 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk10['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual10in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual10in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual10out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual10out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror10['DATESCANACTUALOUT']?> : <?= $result_seScanINerror10['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror10['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror10['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror10['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror10['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift10['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking10 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check10 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                <!-- //////////////////////////////////////////////////////////;////////////////////////////////////////////////////////// -->
                <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >11</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >11/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday11 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk11['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late11 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk11['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual11in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual11in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual11out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual11out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror11['DATESCANACTUALOUT']?> : <?= $result_seScanINerror11['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror11['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror11['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror11['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror11['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift11['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking11 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check11 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >12</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >12/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday12 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk12['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late12 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk12['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual12in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual12in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual12out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual12out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror12['DATESCANACTUALOUT']?> : <?= $result_seScanINerror12['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror12['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror12['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror12['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror12['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift12['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking12 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check12 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >13</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >13/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday13 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk13['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late13 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk13['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual13in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual13in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual13out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual13out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror13['DATESCANACTUALOUT']?> : <?= $result_seScanINerror13['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror13['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror13['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror13['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror13['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift13['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking13 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check13 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >14</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >14/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday14 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk14['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late14 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk14['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual14in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual14in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual14out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual14out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror14['DATESCANACTUALOUT']?> : <?= $result_seScanINerror14['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror14['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror14['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror14['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror14['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift14['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking14 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check14 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >15</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >15/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday15 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk15['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late15 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk15['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual15in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual15in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual15out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual15out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror15['DATESCANACTUALOUT']?> : <?= $result_seScanINerror15['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror15['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror15['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror15['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror15['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift15['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking15 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check15 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >16</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >16/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday16 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk16['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late16 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk16['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual16in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual16in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual16out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual16out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror16['DATESCANACTUALOUT']?> : <?= $result_seScanINerror16['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror16['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror16['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror16['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror16['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift16['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking16 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check16 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >17</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >17/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday17 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk17['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late17 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk17['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual17in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual17in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual17out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual17out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror17['DATESCANACTUALOUT']?> : <?= $result_seScanINerror17['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror17['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror17['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror17['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror17['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift17['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking17 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check17 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >18</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >18/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday18 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk18['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late18 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk18['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual18in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual18in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual18out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual18out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror18['DATESCANACTUALOUT']?> : <?= $result_seScanINerror18['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror18['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror18['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror18['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror18['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift18['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking18 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check18 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >19</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >19/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday19 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk19['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late19 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk19['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual19in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual19in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual19out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual19out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror19['DATESCANACTUALOUT']?> : <?= $result_seScanINerror19['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror19['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror19['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror19['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror19['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift19['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking19 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check19 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >20</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >20/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday20 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk20['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late20 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk20['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual20in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual20in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual20out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual20out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror20['DATESCANACTUALOUT']?> : <?= $result_seScanINerror20['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror20['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror20['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror20['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror20['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift20['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking20 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check20 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
                <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >21</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >21/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday21 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk21['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late21 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk21['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual21in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual21in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual21out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual21out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror21['DATESCANACTUALOUT']?> : <?= $result_seScanINerror21['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror21['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror21['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror21['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror21['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift21['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking21 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check21 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>

                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >22</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >22/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday22 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk22['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late22 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk22['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual22in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual22in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual22out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual22out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror22['DATESCANACTUALOUT']?> : <?= $result_seScanINerror22['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror22['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror22['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror22['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror22['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift22['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking22 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check22 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >23</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >23/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday23 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk23['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late23 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk23['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual23in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual23in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual23out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual23out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror23['DATESCANACTUALOUT']?> : <?= $result_seScanINerror23['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror23['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror23['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror23['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror23['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift23['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking23 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check23 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >24</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >24/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday24 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk24['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late24 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk24['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual24in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual24in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual24out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual24out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror24['DATESCANACTUALOUT']?> : <?= $result_seScanINerror24['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror24['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror24['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror24['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror24['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift24['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking24 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check24 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >25</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >25/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday25 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk25['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late25 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk25['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual25in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual25in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual25out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual25out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror25['DATESCANACTUALOUT']?> : <?= $result_seScanINerror25['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror25['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror25['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror25['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror25['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift25['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking25 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check25 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >26</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >26/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday26 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk26['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late26 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk26['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual26in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual26in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual26out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual26out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror26['DATESCANACTUALOUT']?> : <?= $result_seScanINerror26['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror26['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror26['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror26['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror26['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift26['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking26 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check26 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >27</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >27/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday27 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk27['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late27 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk27['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual27in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual27in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual27out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual27out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror27['DATESCANACTUALOUT']?> : <?= $result_seScanINerror27['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror27['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror27['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror27['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror27['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift27['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking27 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check27 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >28</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >28/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday28 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk28['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late28 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk28['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual28in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual28in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual28out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual28out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror28['DATESCANACTUALOUT']?> : <?= $result_seScanINerror28['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror28['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror28['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror28['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror28['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift28['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking28 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check28 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >29</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >29/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday29 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk29['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late29 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk29['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual29in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual29in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual29out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual29out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror29['DATESCANACTUALOUT']?> : <?= $result_seScanINerror29['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror29['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror29['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror29['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror29['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift29['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking29 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check29 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >30</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >30/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday30 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk30['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late30 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk30['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual30in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual30in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual30out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual30out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror30['DATESCANACTUALOUT']?> : <?= $result_seScanINerror30['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror30['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror30['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror30['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror30['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift30['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking30 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check30 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                 </tr>
                 <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
                 <tr style="border:1px solid #000;" >
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" >31</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['nameT'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" >31/<?= $month ?>/<?= $years ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $holiday31 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seLeavedaychk31['Leave_Memo'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $late31 ?></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= ($result_sesundaychk31['SUNDAY']  == 'Sunday' ? 'วันอาทิตย์' : '') ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual31in['DATESCANACTUALIN'] ?> : <?= $result_seScanActual31in['TIMESCANACTUALIN'] ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seScanActual31out['DATESCANACTUALOUT'] ?> : <?= $result_seScanActual31out['TIMESCANACTUALOUT'] ?></td>
                    <!-- <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanINerror31['DATESCANACTUALOUT']?> : <?= $result_seScanINerror31['TIMESCANACTUALOUT'] ?>(<?= $result_seScanINerror31['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:red;" ><?= $result_seScanOUTerror31['DATESCANACTUALOUT']?> : <?= $result_seScanOUTerror31['TIMESCANACTUALOUT'] ?>(<?= $result_seScanOUTerror31['InOutMode']?>)</td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seChk_Shift31['Shift_Name']?></td></td> -->
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;color:green;" ><?= $checkworking31 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $check31 ?></td>
                    <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ></td>
                </tr>
 </tbody>

<!-- <?php

//จำนวนเงิน
$sumfood = ($check1 + $check2 + $check3 + $check4 + $check5
            + $check6 + $check7 + $check8 + $check9 + $check10
            + $check11 + $check12 + $check13 + $check14 + $check15
            + $check16 + $check17 + $check18 + $check19 + $check20
            + $check21 + $check22 + $check23 + $check24 + $check25
            + $check26 + $check27 + $check28 + $check29 + $check30
            + $check31 );
//จำนวนวันสาย
// $sumlate = ($latechk1 + $latechk2 + $latechk3 + $latechk4 + $latechk5
//             + $latechk6 + $latechk7 + $latechk8 + $latechk9 + $latechk10
//             + $latechk11 + $latechk12 + $latechk13 + $latechk14 + $latechk15 
//             + $latechk16 + $latechk17 + $latechk18 + $latechk19 + $latechk20 
//             + $latechk21 + $latechk22 + $latechk23 + $latechk24 + $latechk25 
//             + $latechk26 + $latechk27 + $latechk28 + $latechk29 + $latechk30
//             + $latechk31 );
//จำนวนวันลา
$sumleave = ($leavechk1 + $leavechk2 + $leavechk3 + $leavechk4 + $leavechk5
            + $leavechk6 + $leavechk7 + $leavechk8 + $leavechk9 + $leavechk10
            + $leavechk11 + $leavechk12 + $leavechk13 + $leavechk14 + $leavechk15
            + $leavechk16 + $leavechk17 + $leavechk18 + $leavechk19 + $leavechk20
            + $leavechk21 + $leavechk22 + $leavechk23 + $leavechk24 + $leavechk25
            + $leavechk26 + $leavechk27 + $leavechk28 + $leavechk29 + $leavechk30
            + $leavechk31 );

// $monthchk = $_GET['month'];

// $sumlatechk = $latechk6;
// echo $sumfood;


$i1++;



$sql_TempCalFood = "{call megTempCalfood(?,?,?,?,?,?,?,?)}";
$params_TempCalFood = array(
    array('select_tempcalfood', SQLSRV_PARAM_IN),
    array($result_sePlan['EMPLOYEECODE'], SQLSRV_PARAM_IN),
    array($result_sePlan['nameT'], SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array($sumleave, SQLSRV_PARAM_IN),
    array($sumfood, SQLSRV_PARAM_IN),
    array($_GET['month'], SQLSRV_PARAM_IN),
    array($_GET['years'], SQLSRV_PARAM_IN)
);
$query_TempCalFood = sqlsrv_query($conn, $sql_TempCalFood, $params_TempCalFood);
$result_TempCalFood = sqlsrv_fetch_array($query_TempCalFood, SQLSRV_FETCH_ASSOC);

}
?> -->

</table>

<!-- Table2 -->
<!-- <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
    <thead>
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td rowspan="" colspan="1"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ลำดับ</b>
            </td>
            <td rowspan="" colspan="1"  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>รหัสพนักงาน</b>
            </td>
            <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ชื่อ-สกุล</b>
            </td>
            <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>เดือน</b>
            </td>
            <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วันทำงานตามปฎิทิน(EHR)</b>
            </td>
            <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วันหยุด</b>
            </td>
            <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>วันลา</b>
            </td>
            <td rowspan="" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ค่าอาหาร</b>
            </td>
        </tr>

    </thead>
        <?php

        $isum = 1;
        // $i2 = 1;
        // // $sumpallet = "";
        // // $sumcompen = "";
        // // $sumall = "";
        // // $sumresult = "";

        if ($_GET['area'] == 'amata') {
         
            if ($_GET['position'] == 'Senior Driver/Kubota' || $_GET['position'] == 'พนักงานขับรถ/KUBOTA') {
                $sql_sePlansum = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,d.PersonID,d.CompanyID,
                    a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT,d.PositionNameT
                    FROM [dbo].[ORGANIZATION] a 
                    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
                    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
                    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
                    WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE ='03'
                    AND a.AREA ='amata'
                    AND d.EndDate IS NULL
                    --AND a.EMPLOYEECODE IN ('070074')
                    AND d.PositionNameT IN ('Senior Driver/Kubota','พนักงานขับรถ/KUBOTA')
                    AND d.PositionNameT NOT IN ('เจ้าหน้าที่','เจ้าหน้าที่อาวุโส','ผู้จัดการ','หัวหน้างาน','Controller','Dispatcher')
                    ORDER BY d.PositionNameT,a.EMPLOYEECODE ASC";
             }else if($_GET['position'] == 'พนักงานขับรถ/STM-SR' || $_GET['position'] == 'พนักงานขับรถ/STM-TAW' || $_GET['position'] == 'พนักงานขับรถ/SWN') {
                $sql_sePlansum = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,d.PersonID,d.CompanyID,
                    a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT,d.PositionNameT
                    FROM [dbo].[ORGANIZATION] a 
                    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
                    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
                    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
                    WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE ='03'
                    AND a.AREA ='amata'
                    AND d.EndDate IS NULL
                    AND d.PositionNameT IN ('พนักงานขับรถ/STM-SR','พนักงานขับรถ/STM-TAW','พนักงานขับรถ/SWN')
                    AND d.PositionNameT NOT IN ('เจ้าหน้าที่','เจ้าหน้าที่อาวุโส','ผู้จัดการ','หัวหน้างาน','Controller','Dispatcher')
                    ORDER BY d.PositionNameT,a.EMPLOYEECODE ASC";
             }else {
                $sql_sePlansum = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,d.PersonID,d.CompanyID,
                    a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT,d.PositionNameT
                    FROM [dbo].[ORGANIZATION] a 
                    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
                    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
                    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
                    WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE ='03'
                    AND a.AREA ='amata'
                    AND d.EndDate IS NULL
                    AND d.PositionNameT IN ('".$_GET['position']."')
                    AND d.PositionNameT NOT IN ('เจ้าหน้าที่','เจ้าหน้าที่อาวุโส','ผู้จัดการ','หัวหน้างาน','Controller','Dispatcher')
                    ORDER BY d.PositionNameT,a.EMPLOYEECODE ASC";
             }
                
            }else{
                $sql_sePlansum = "SELECT a.ORGANIZATIONID,a.AREA,a.COMPANYCODE,a.DEPARTMENTCODE,a.SECTIONCODE,a.EMPLOYEECODE,d.PersonID,d.CompanyID,
                    a.ACTIVESTATUS,b.DEPARTMENTNAME,c.SECTIONNAME,(d.FnameT+' '+d.LnameT) AS nameT,d.PositionNameT
                    FROM [dbo].[ORGANIZATION] a 
                    INNER JOIN [dbo].[DEPARTMENT_NEW] b ON b.DEPARTMENTCODE = a.DEPARTMENTCODE AND b.COMPANYCODE = a.COMPANYCODE
                    INNER JOIN [dbo].[SECTION_NEW] c ON c.DEPARTMENTCODE = b.DEPARTMENTCODE AND c.SECTIONCODE = a.SECTIONCODE
                    INNER JOIN [dbo].[EMPLOYEEEHR2] d ON d.PersonCode = a.EMPLOYEECODE
                    WHERE b.DEPARTMENTCODE ='03' AND c.SECTIONCODE ='03'
                    AND a.AREA ='gateway'
                    AND d.EndDate IS NULL
                    AND d.PositionNameT NOT IN ('เจ้าหน้าที่','เจ้าหน้าที่อาวุโส','ผู้จัดการ','หัวหน้างาน','Controller','Dispatcher')
                    ORDER BY d.PositionNameT,a.EMPLOYEECODE ASC";
            }
            $query_sePlansum = sqlsrv_query($conn, $sql_sePlansum, $params_sePlansum);
            while($result_sePlansum = sqlsrv_fetch_array($query_sePlansum, SQLSRV_FETCH_ASSOC)){
                
                $sql_seFoodData = "SELECT EMPLOYEECODE,EMPLOYEENAME,LATE,LEAVE,SUMFOOD,MONTHS,YEARS 
                FROM TEMP_CALFOOD
                WHERE EMPLOYEECODE ='".$result_sePlansum['EMPLOYEECODE']."'
                AND MONTHS ='".$_GET['month']."'
                AND YEARS ='".$_GET['years']."'";
                $query_seFoodData   = sqlsrv_query($conn, $sql_seFoodData, $params_seFoodData);
                $result_seFoodData  = sqlsrv_fetch_array($query_seFoodData, SQLSRV_FETCH_ASSOC);
       
       ?>

        <tbody>

                    <tr style="border:1px solid #000;" >
                        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $isum ?></td>
                        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlansum['EMPLOYEECODE'] ?></td>
                        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlansum['nameT'] ?></td>
                        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= DateThai($strDate) ?></td>
                        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $dateworkingEHR ?></td>
                        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $sumcountholiday ?></td>
                        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seFoodData['LEAVE']?></td>
                        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $result_seFoodData['SUMFOOD']?></td>
                    </tr>
    </tbody>
    <?php
        $isum++;
        }
    ?>

</table> -->
