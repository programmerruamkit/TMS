<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");




// $sql_getDate = "{call megStopwork_v2(?)}";
// $params_getDate = array(
//   array('select_getdate', SQLSRV_PARAM_IN)
// );
// $query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
// $result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

if ($_GET['companycode'] == '01') {
  $COMPANY = 'RKR';
}else if ($_GET['companycode'] == '02') {
  $COMPANY = 'RKS';
}else if ($_GET['companycode'] == '07') {
  $COMPANY = 'RKL';
}else {
  $COMPANY = '';
}


$strExcelFileName = "รายงานค่าเที่ยวบริษัท(" .$COMPANY. ")ประจำเดือน".$_GET['datestart'] .".xls";



// header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
// header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
// header("Pragma:no-cache");





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
  <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">

  <thead>
       <tr style="border:1px solid #000;" >
              <td colspan="21" style="border-right:1px solid #000;padding:3px;text-align:left;">
                  <b>สรุปค่าเที่ยวบริษัท(month) <?= $COMPANY ?></b>
              </td>
              <td colspan="10" style="border-right:1px solid #000;padding:3px;text-align:left;">
                  <b>เดือน/ปี : <?= $_GET['datestart'] ?></b>
              </td>
         </tr>
         <tr style="border:1px solid #000;background-color: #ccc" >
              <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>ลำดับ</b>
              </td>
              <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>สายงาน</b>
              </td>
              <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>รหัส</b>
              </td>
              <td rowspan="2" colspan="3" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>พนักงานขับรถ</b>
              </td>

               <td colspan="3" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>จำนวนเที่ยว</b>
              </td>
              <td colspan="3" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>จำนวน Pallet</b>
              </td>

              <td colspan="3" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>รายได้ค่าเที่ยว</b>
              </td>
              <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>รายได้กิจกรรม<br>GA/Maintenance
              </td>
              <td rowspan="2" colspan="3" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>ค่าเบี้ยเลี้ยง<br>Training</b>
              </td>
              <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>รวมทั้งสิ้น</b>
              </td>
               <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>ประกันค่าเที่ยว</b>
              </td>
              <td colspan="8"  style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>ผลการประเมิน</b>
              </td>

              <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>เงินชดเชย</b>
              </td>
              <td rowspan="2" collapse="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>เงินสุทธิที่จ่าย</b>
              </td>

         </tr>
         <tr style="border:1px solid #000;background-color: #ccc" >
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>01--15</b></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>16--31</b></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>รวม</b></td>
               <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>01--15</b></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>16--31</b></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>รวม</b></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>01--15</b></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>16--31</b></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>รวม</b></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เกณท์รายได้</b></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เริ่มอนุมัติค่าเที่ยว</b></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ลางาน</b></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ไม่ปฏิเสธิงาน</b></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ความดัน</b></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ใบเตือน/อุบัติเหตุ</b></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ข้อร้องเรียน</b></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>สรุป</b></td>
         </tr>

      </thead><tbody>

<?php
$i = 1;
$sumpallet = "";
$sumcompen = "";
$sumall = "";
$sumresult = "";
$sql_seGetdate = "SELECT '01/" . $_GET['datestart'] . "' AS 'datestart',
                    CONVERT(VARCHAR, (SELECT DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,CONVERT(DATE,'01/" . $_GET['datestart'] . "',103))+1,0))), 103) AS 'dateend'";

$query_seGetdate = sqlsrv_query($conn, $sql_seGetdate, $params_seGetdate);
$result_seGetdate = sqlsrv_fetch_array($query_seGetdate, SQLSRV_FETCH_ASSOC);

if ($_GET['position'] == '00') {
  // $sql_sePlan = "SELECT a.PersonID AS 'EMPID',a.PersonCode AS 'EMPLOYEECODE',a.FnameT,a.LnameT,
  //                 (a.FnameT+' '+a.LnameT) AS 'EMPLOYEENAME',c.PositionNameT,a.EndDate
  //                 FROM [203.150.225.30].[TigerE-HR].dbo.PNT_Person a
  //                 INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNT_PersonDetail b ON a.PersonID = b.PersonID
  //                 INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNM_Position c ON a.PositionID = c.PositionID
  //                 WHERE 1 = 1 AND a.[EndDate] IS NULL
  //                 AND SUBSTRING(a.PersonCode, 1, 2) IN('01','02','07')
  //                 AND a.PositionID IN('11','25','37','57','47','59','60','61')
  //                 AND a.PersonCode NOT IN
  //                 (SELECT PNT_Person.PersonCode
  //                 FROM [203.150.225.30].[TigerE-HR].[dbo].PNT_Resign
  //                 INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].PNM_ResignType ON PNT_Resign.ResignTypeID = PNM_ResignType.ResignTypeID
  //                 LEFT OUTER JOIN [203.150.225.30].[TigerE-HR].[dbo].PNT_Person ON PNT_Resign.PersonID = PNT_Person.PersonID
  //                 WHERE PNM_ResignType.ResignT !='เกษียณอายุ'
  //                 )
  //                 AND a.ResignStatus = '1'
  //                 AND a.ChkDeletePerson = '1'
  //                 ORDER BY a.PersonCode ASC";
  $sql_sePlan = "SELECT a.PersonID AS 'EMPID',a.PersonCode AS 'EMPLOYEECODE',a.FnameT,a.LnameT,
                      (a.FnameT+' '+a.LnameT) AS 'EMPLOYEENAME',a.PositionNameT,a.EndDate,a.PositionID
                      FROM EMPLOYEEEHR2 a
                      INNER JOIN EMPLOYEEDETAILEHR b ON b.PersonID = a.PersonID
                      WHERE  SUBSTRING(a.PersonCode, 1, 2) IN('01','02','07')
                      AND a.PositionID IN('11','25','37','57','47','59','60','61')
                      ORDER BY a.PersonCode ASC";
  $query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
}else {
  // $sql_sePlan = "SELECT a.PersonID AS 'EMPID',a.PersonCode AS 'EMPLOYEECODE',a.FnameT,a.LnameT,
  //                 (a.FnameT+' '+a.LnameT) AS 'EMPLOYEENAME',c.PositionNameT,a.EndDate
  //                 FROM [203.150.225.30].[TigerE-HR].dbo.PNT_Person a
  //                 INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNT_PersonDetail b ON a.PersonID = b.PersonID
  //                 INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNM_Position c ON a.PositionID = c.PositionID
  //                 WHERE 1 = 1 AND a.[EndDate] IS NULL
  //                 AND SUBSTRING(a.PersonCode, 1, 2) ='" .$_GET['companycode'] . "'
  //                 AND a.PositionID ='" .$_GET['position'] . "'
  //                 AND a.PersonCode NOT IN
  //                 (SELECT PNT_Person.PersonCode
  //                 FROM [203.150.225.30].[TigerE-HR].[dbo].PNT_Resign
  //                 INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].PNM_ResignType ON PNT_Resign.ResignTypeID = PNM_ResignType.ResignTypeID
  //                 LEFT OUTER JOIN [203.150.225.30].[TigerE-HR].[dbo].PNT_Person ON PNT_Resign.PersonID = PNT_Person.PersonID
  //                 WHERE PNM_ResignType.ResignT !='เกษียณอายุ'
  //                 )
  //                 AND a.ResignStatus = '1'
  //                 AND a.ChkDeletePerson = '1'
  //                 ORDER BY a.PersonCode ASC";
 $sql_sePlan = "SELECT a.PersonID AS 'EMPID',a.PersonCode AS 'EMPLOYEECODE',a.FnameT,a.LnameT,
                    (a.FnameT+' '+a.LnameT) AS 'EMPLOYEENAME',a.PositionNameT,a.EndDate,a.PositionID
                    FROM EMPLOYEEEHR2 a
                    INNER JOIN EMPLOYEEDETAILEHR b ON b.PersonID = a.PersonID
                    WHERE  SUBSTRING(a.PersonCode, 1, 2) ='" .$_GET['companycode'] . "'
                    AND a.PositionID ='" .$_GET['position'] . "'
                    ORDER BY a.PersonCode ASC";
  $query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
}


while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {

// $sql_seCheckdo = "SELECT  [DOCUMENTCODE] FROM [dbo].[VEHICLETRANSPORTPLAN]
// WHERE VEHICLETRANSPORTPLANID = '" . $result_sePlan['VEHICLETRANSPORTPLANID'] . "'";
//
// $query_seCheckdo = sqlsrv_query($conn, $sql_seCheckdo, $params_seCheckdo);
// $result_seCheckdo = sqlsrv_fetch_array($query_seCheckdo, SQLSRV_FETCH_ASSOC);

//////////////////////////////แผนวิ่งงาน/////////////////////////////////////////////////
if ($_GET['position'] == '41') {

  $sql_sePlan15 = "SELECT SUM(CAST(SUBSTRING(ROUNDAMOUNT, 1, 2)AS INT)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN]
                WHERE CONVERT(DATE,DATEVLIN) BETWEEN CONVERT(DATE,'01/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'15/" . $_GET['datestart'] . "',103)
                AND (EMPLOYEECODE1 ='" . $result_sePlan['EMPLOYEECODE'] . "' OR  EMPLOYEECODE2 ='" . $result_sePlan['EMPLOYEECODE'] . "' )
                AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
  $query_sePlan15 = sqlsrv_query($conn, $sql_sePlan15, $params_sePlan15);
  $result_sePlan15 = sqlsrv_fetch_array($query_sePlan15, SQLSRV_FETCH_ASSOC);

  $sql_sePlan30 = "SELECT SUM(CAST(SUBSTRING(ROUNDAMOUNT, 1, 2)AS INT)) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN]
        WHERE CONVERT(DATE,DATEVLIN) BETWEEN CONVERT(DATE,'16/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $result_seGetdate['dateend'] . "',103)
        AND (EMPLOYEECODE1 ='" . $result_sePlan['EMPLOYEECODE'] . "' OR  EMPLOYEECODE2 ='" . $result_sePlan['EMPLOYEECODE'] . "' )
        AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
  $query_sePlan30 = sqlsrv_query($conn, $sql_sePlan30, $params_sePlan30);
  $result_sePlan30 = sqlsrv_fetch_array($query_sePlan30, SQLSRV_FETCH_ASSOC);
}else {

  $sql_sePlan15 = "SELECT COUNT(VEHICLETRANSPORTPLANID) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN]
                WHERE CONVERT(DATE,DATEVLIN) BETWEEN CONVERT(DATE,'01/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'15/" . $_GET['datestart'] . "',103)
                AND (EMPLOYEECODE1 ='" . $result_sePlan['EMPLOYEECODE'] . "' OR  EMPLOYEECODE2 ='" . $result_sePlan['EMPLOYEECODE'] . "' )
                AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
  $query_sePlan15 = sqlsrv_query($conn, $sql_sePlan15, $params_sePlan15);
  $result_sePlan15 = sqlsrv_fetch_array($query_sePlan15, SQLSRV_FETCH_ASSOC);

  $sql_sePlan30 = "SELECT COUNT(VEHICLETRANSPORTPLANID) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN]
        WHERE CONVERT(DATE,DATEVLIN) BETWEEN CONVERT(DATE,'16/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $result_seGetdate['dateend'] . "',103)
        AND (EMPLOYEECODE1 ='" . $result_sePlan['EMPLOYEECODE'] . "' OR  EMPLOYEECODE2 ='" . $result_sePlan['EMPLOYEECODE'] . "' )
        AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
  $query_sePlan30 = sqlsrv_query($conn, $sql_sePlan30, $params_sePlan30);
  $result_sePlan30 = sqlsrv_fetch_array($query_sePlan30, SQLSRV_FETCH_ASSOC);
}


/////////////////////////////////////////////////////////////////////////////

//////////////////////////////PALLET/////////////////////////////////////////////////
$sql_sePlanpallet15 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
    WHERE (a.DOCUMENTCODE_PALLET IS NOT NULL AND a.DOCUMENTCODE_PALLET != '')
    AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'01/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'15/" . $_GET['datestart'] . "',103)
    AND (a.EMPLOYEECODE1 ='" . $result_sePlan['EMPLOYEECODE'] . "' OR  a.EMPLOYEECODE2 ='" . $result_sePlan['EMPLOYEECODE'] . "')";

$query_sePlanpallet15 = sqlsrv_query($conn, $sql_sePlanpallet15, $params_sePlanpallet15);
$result_sePlanpallet15 = sqlsrv_fetch_array($query_sePlanpallet15, SQLSRV_FETCH_ASSOC);
$SUMPALLET15 = ($result_sePlanpallet15['CNTPALLET']*5);


$sql_sePlanpallet30 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
    WHERE (a.DOCUMENTCODE_PALLET IS NOT NULL AND a.DOCUMENTCODE_PALLET != '')
    AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'16/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $result_seGetdate['dateend'] . "',103)
    AND (a.EMPLOYEECODE1 ='" . $result_sePlan['EMPLOYEECODE'] . "' OR  a.EMPLOYEECODE2 ='" . $result_sePlan['EMPLOYEECODE'] . "')";

$query_sePlanpallet30 = sqlsrv_query($conn, $sql_sePlanpallet30, $params_sePlanpallet30);
$result_sePlanpallet30 = sqlsrv_fetch_array($query_sePlanpallet30, SQLSRV_FETCH_ASSOC);
$SUMPALLET30 =($result_sePlanpallet30['CNTPALLET']*5);
/////////////////////////////////////////////////////////////////////////////

//////////////////////ค่าเที่ยว 1-15/////////////////////////////////////////////////

// $sql_seComp15 = "SELECT SUM(CONVERT(INT,a.COMPENSATION1)) AS '15CNT1',SUM(CONVERT(INT,a.COMPENSATION2)) AS '15CNT2' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
//                 INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
//                 WHERE CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'01/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'15/" . $_GET['datestart'] . "',103)
//                 AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND (b.EMPLOYEECODE1 IS NOT NULL OR  b.EMPLOYEECODE2 IS NOT NULL )
//                 AND (b.EMPLOYEECODE1 ='" . $result_sePlan['EMPLOYEECODE'] . "' OR  b.EMPLOYEECODE2 ='" . $result_sePlan['EMPLOYEECODE'] . "' )";
// $query_seComp15 = sqlsrv_query($conn, $sql_seComp15, $params_seComp15);
// $result_seComp15 = sqlsrv_fetch_array($query_seComp15, SQLSRV_FETCH_ASSOC);
//
// if ($result_seComp15['15CNT1'] != '' OR $result_seComp15['15CNT1'] !='NULL') {
//     $COMPEN15 = $result_seComp15['15CNT1'];
// }else {
//     $COMPEN15 = $result_seComp15['15CNT2'];
// }

$sql_seComp151 = "SELECT SUM(CONVERT(INT,a.COMPENSATION1)) AS '15CNT1'
FROM (SELECT a.COMPENSATION1 ,b.JOBNO
FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
WHERE CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'01/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'15/" . $_GET['datestart'] . "',103)
AND b.COMPANYCODE = '" . $COMPANY . "' AND b.EMPLOYEECODE1 IS NOT NULL
AND a.COMPENSATION1 IS NOT NULL
AND b.EMPLOYEECODE1 ='" . $result_sePlan['EMPLOYEECODE'] . "'
AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE !=''
GROUP BY a.COMPENSATION1 ,b.JOBNO) a ";
$query_seComp151 = sqlsrv_query($conn, $sql_seComp151, $params_seComp151);
$result_seComp151 = sqlsrv_fetch_array($query_seComp151, SQLSRV_FETCH_ASSOC);

$sql_seComp152 = "SELECT SUM(CONVERT(INT,a.COMPENSATION2)) AS '15CNT2'
FROM (SELECT a.COMPENSATION2 ,b.JOBNO
FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
WHERE CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'01/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'15/" . $_GET['datestart'] . "',103)
AND b.COMPANYCODE = '" . $COMPANY . "' AND b.EMPLOYEECODE2 IS NOT NULL
AND a.COMPENSATION2 IS NOT NULL
AND b.EMPLOYEECODE2 ='" . $result_sePlan['EMPLOYEECODE'] . "'
AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE !=''
GROUP BY a.COMPENSATION2 ,b.JOBNO) a ";
$query_seComp152 = sqlsrv_query($conn, $sql_seComp152, $params_seComp152);
$result_seComp152 = sqlsrv_fetch_array($query_seComp152, SQLSRV_FETCH_ASSOC);

$CompAll15 = $result_seComp151['15CNT1'] + $result_seComp152['15CNT2'];


//////////////////////////ค่าเที่ยว 16-30///////////////////////////////////////////////////
// $sql_seComp301 = "SELECT SUM(CONVERT(INT,a.COMPENSATION1)) AS '30CNT1'
// FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
// INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
// WHERE CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'16/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $result_seGetdate['dateend'] . "',103)
// AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.EMPLOYEECODE1 IS NOT NULL
// AND b.EMPLOYEECODE1 ='" . $result_sePlan['EMPLOYEECODE'] . "'
// AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE !='' ";
// $query_seComp301 = sqlsrv_query($conn, $sql_seComp301, $params_seComp301);
// $result_seComp301 = sqlsrv_fetch_array($query_seComp301, SQLSRV_FETCH_ASSOC);

$sql_seComp301 = "SELECT SUM(CONVERT(INT,a.COMPENSATION1)) AS '30CNT1'
FROM (SELECT a.COMPENSATION1 ,b.JOBNO
FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
WHERE CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'16/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $result_seGetdate['dateend'] . "',103)
AND b.COMPANYCODE = '" . $COMPANY . "' AND b.EMPLOYEECODE1 IS NOT NULL
AND a.COMPENSATION1 IS NOT NULL
AND b.EMPLOYEECODE1 ='" . $result_sePlan['EMPLOYEECODE'] . "'
AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE !=''
GROUP BY a.COMPENSATION1 ,b.JOBNO) a ";
$query_seComp301 = sqlsrv_query($conn, $sql_seComp301, $params_seComp301);
$result_seComp301 = sqlsrv_fetch_array($query_seComp301, SQLSRV_FETCH_ASSOC);

$sql_seComp302 = "SELECT SUM(CONVERT(INT,a.COMPENSATION2)) AS '30CNT2'
FROM (SELECT a.COMPENSATION2 ,b.JOBNO
FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
WHERE CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'16/" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $result_seGetdate['dateend'] . "',103)
AND b.COMPANYCODE = '" . $COMPANY . "' AND b.EMPLOYEECODE2 IS NOT NULL
AND a.COMPENSATION2 IS NOT NULL
AND b.EMPLOYEECODE2 ='" . $result_sePlan['EMPLOYEECODE'] . "'
AND a.DOCUMENTCODE IS NOT NULL AND a.DOCUMENTCODE !=''
GROUP BY a.COMPENSATION2 ,b.JOBNO) a  ";
$query_seComp302 = sqlsrv_query($conn, $sql_seComp302, $params_seComp302);
$result_seComp302 = sqlsrv_fetch_array($query_seComp302, SQLSRV_FETCH_ASSOC);

$CompAll30 = $result_seComp301['30CNT1'] + $result_seComp302['30CNT2'];

//////////////////////////////////POSITION/////////////////////////////////

$sql_sePosId = "SELECT PositionID AS 'POSID'  FROM EMPLOYEEEHR2 WHERE PersonCode = '" . $result_sePlan['EMPLOYEECODE'] . "'";
$query_sePosId = sqlsrv_query($conn, $sql_sePosId, $params_sePosId);
$result_sePosId = sqlsrv_fetch_array($query_sePosId, SQLSRV_FETCH_ASSOC);

$sql_sePosName = "SELECT PositionNameT AS 'POSNAME'  FROM EMPLOYEEEHR2 WHERE PositionID ='" . $result_sePosId ['POSID']. "'";
$query_sePosName = sqlsrv_query($conn, $sql_sePosName, $params_sePosName);
$result_sePosName = sqlsrv_fetch_array($query_sePosName, SQLSRV_FETCH_ASSOC);

    // if ($result_sePlan['ROWNUM'] <= '30') {

 ?>

      <tr style="border:1px solid #000;" >
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $i ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePosName['POSNAME'] ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
              <td colspan = "3" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEENAME'] ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan15['CNT'] ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan30['CNT'] ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= ($result_sePlan15['CNT'] + $result_sePlan30['CNT']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= number_format($SUMPALLET15) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= number_format($SUMPALLET30) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= number_format($SUMPALLET15 + $SUMPALLET30) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= number_format($CompAll15) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= number_format($CompAll30) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= number_format(($CompAll15 + $CompAll30)) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;">-</td>
              <td colspan="3" style="border-right:1px solid #000;padding:3px;text-align:left;">-</td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format((($SUMPALLET15 + $SUMPALLET30)) + ($CompAll15 + $CompAll30)) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;">8,000</td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;">-</td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;">-</td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;">-</td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;">-</td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;">-</td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;">-</td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;">-</td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;">-</td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;">-</td>
              <td style="border-right:1px solid #000;padding:3px;text-align:left;"><?= number_format(($SUMPALLET15 + $SUMPALLET30) + ($CompAll15 + $CompAll30)) ?></td>

      </tr>
      <?php
      // }
        $i++;
        $sumpallet  = $sumpallet+($SUMPALLET15 + $SUMPALLET30);
        $sumcompen  = $sumcompen+ ($CompAll15 + $CompAll30);
        $sumall = $sumall + (($SUMPALLET15 + $SUMPALLET30) + ($CompAll15 + $CompAll30));
      }
       ?>

</tbody><tfoot>
       <tr style="border:1px solid #000;">
          <td colspan="12" style="border:1px solid #000;padding:3px;text-align:right;"><?= number_format($sumpallet) ?></td>
          <td colspan="3" style="border:1px solid #000;padding:3px;text-align:right;"><?= number_format($sumcompen) ?></td>
          <td colspan="5" style="border:1px solid #000;padding:4px;text-align:right;"><?= number_format($sumall) ?></td>
          <td colspan="11" style="border:1px solid #000;padding:3px;text-align:right;"><?= number_format($sumall) ?></td>

      </tr>
      </tfoot>
</table>


      <br><br><br><br>
      <table >
      </table>

</body>
</html>
