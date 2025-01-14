<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
error_reporting(0);
ini_set('display_errors', 0);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");
$sumtotal = "";



$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
  array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);


$strExcelFileName = "รายงานค่าน้ำมัน(".$_GET['customercode'] .")ประจำเดือน".$_GET['datestart'] .".xls";

$date = substr($_GET['datestart'],3,10);


if ($_GET['customercode'] == 'TGT') {
  $POSITION ='44';
}else if ($_GET['customercode'] == 'KUBOTA') {
  $POSITION ='34';
}else if ($_GET['customercode'] == 'TTASTSTC') {
  if ($_GET['companycode'] == 'RKR') {
    $POSITION ='28';
  }else {
    $POSITION ='36';
  }
}else if ($_GET['customercode'] == 'TTASTCS') {
  $POSITION ='26';
}else if ($_GET['customercode'] == 'STM') {
  $POSITION ='41';
}else if ($_GET['customercode'] == 'DENSO-THAI') {
  $POSITION ='40';
}else {
  $POSITION ='';
}

if ($_GET['companycode'] == 'RKS') {
  $PERSONCODE ='02';
}else if ($_GET['companycode'] == 'RKR') {
  $PERSONCODE ='01';
}else if ($_GET['companycode'] == 'RKL') {
  $PERSONCODE ='07';
}else {
  $PERSONCODE ='';
}



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
  <table id="bg-table" width="150%" style="border-collapse: collapse;font-size:12;">

  <thead>
       <tr style="border:1px solid #000;" >
              <td colspan="54" style="border-right:1px solid #000;padding:3px;text-align:center;">
                  <b>สรุปค่าน้ำมันบริษัท <?= $result_seComp['Company_NameT'] ?> สายงาน <?= $_GET['customercode'] ?></b>
              </td>
              <td colspan="18" style="border-right:1px solid #000;padding:3px;text-align:center;">
                  <b>วันที่: <?= $_GET['datestart'] ?> ถึง  <?= $_GET['dateend'] ?></b>
              </td>
         </tr>
         <tr style="border:1px solid #000;background-color: #ccc" >
           <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
           <b>ลำดับ</b>
           </td>
           <td rowspan="2" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
           <b>รหัส</b>
           </td>
           <td rowspan="2" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
           <b>ชื่อ-สกุล</b>
           </td>
           <td rowspan="2" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
           <b>จำนวนเที่ยว</b>
           </td>
           <td rowspan="2" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
           <b>กิโลเมตร</b>
           </td>
           <td rowspan="2" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
           <b>KM/Trip</b>
           </td>
           <td rowspan="2" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
           <b>สายงาน</b>
           </td>

               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>01/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>02/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>03/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>04/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>05/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>06/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>07/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>08/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>09/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>10/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>11/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>12/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>13/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>14/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>15/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>16/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>17/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>18/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>19/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>20/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>21/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>22/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>23/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>24/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>25/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>26/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>27/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>28/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>29/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>30/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>31/<?=$date?></b>
               </td>
               <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>TOTAL</b>
               </td>
               <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
               <b>ยอดที่จ่ายจริง</b>
               </td>

              </td>

         </tr>
         <tr style="border:1px solid #000;background-color: #ccc" >

          <!-- //1 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //2 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //3 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //4 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //5 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //6 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //7 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //8 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //9 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //10 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //11 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //12 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //13 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //14 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //15 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //16 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //17 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //18 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //19 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //20 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //21 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //22 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //23 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //24 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //25 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //26 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //27 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //28 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //29 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //30 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //31 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!-- //TOTAL -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินบวก</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>เงินลบ</b></td>
          <!--//ยอดที่จ่ายจริง -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>จำนวน</b></td>
         </tr>

      </thead><tbody>
        <?php
        $i = 1;
        $ALLKM ="";
        $sumpallet = "";
        $sumcompen = "";
        $sumall = "";
        $sumresult = "";
        $sql_seGetdate = "SELECT '" . $_GET['datestart'] . "' AS 'datestart',
                            CONVERT(VARCHAR, (SELECT DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,CONVERT(DATE,'" . $_GET['dateend'] . "',103))+1,0))), 103) AS 'dateend'";

        $query_seGetdate = sqlsrv_query($conn, $sql_seGetdate, $params_seGetdate);
        $result_seGetdate = sqlsrv_fetch_array($query_seGetdate, SQLSRV_FETCH_ASSOC);

          if ($_GET['customercode'] =='other') {
            $sql_sePlan = "SELECT a.PersonID AS 'EMPID',a.PersonCode AS 'EMPLOYEECODE',a.FnameT,a.LnameT,
              (a.FnameT+' '+a.LnameT) AS 'EMPLOYEENAME',a.PositionNameT,a.EndDate   FROM EMPLOYEEEHR2 a
              WHERE  SUBSTRING(a.PersonCode, 1, 2) IN('01','02','07')
              AND a.PositionID IN('11','25','37','57','47')
              ORDER BY a.PersonCode ASC";
            $query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
          }else if ($_GET['customercode'] =='TMTTAW') {
            $sql_sePlan = "SELECT a.PersonID AS 'EMPID',a.PersonCode AS 'EMPLOYEECODE',a.FnameT,a.LnameT,
              (a.FnameT+' '+a.LnameT) AS 'EMPLOYEENAME',a.PositionNameT,a.EndDate   FROM EMPLOYEEEHR2 a
              WHERE  SUBSTRING(a.PersonCode, 1, 2) IN('02')
              AND a.PositionID IN('42','43')
              ORDER BY a.PersonCode ASC";
            $query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
          }else {
            $sql_sePlan = "SELECT a.PersonID AS 'EMPID',a.PersonCode AS 'EMPLOYEECODE',a.FnameT,a.LnameT,
              (a.FnameT+' '+a.LnameT) AS 'EMPLOYEENAME',a.PositionNameT,a.EndDate   FROM EMPLOYEEEHR2 a
              WHERE  SUBSTRING(a.PersonCode, 1, 2) IN($PERSONCODE)
              AND a.PositionID IN($POSITION)
              ORDER BY a.PersonCode ASC";
            $query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
          }


        while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {


          /////////////////////////หาทะเบียนรถที่วิ่งงาน//////////////////////////////////////
          $i2 = 1;
          if ($_GET['customercode'] =='other') {
            $sql_seThainame = "SELECT DISTINCT a.JOBNO,a.THAINAME FROM(
                          SELECT JOBNO,VEHICLETRANSPORTPLANID ,EMPLOYEENAME1,EMPLOYEECODE1,VEHICLEREGISNUMBER1,THAINAME
                          FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE COMPANYCODE  ='".$_GET['companycode']."'
                          AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'01/".$date."',103) AND CONVERT(DATE,GETDATE(),103)
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."'))a";
            $query_seThainame = sqlsrv_query($conn, $sql_seThainame, $params_seThainame);
          }else if ($_GET['companycode'] =='RKS' && $_GET['customercode'] =='TMTTAW'){
            $sql_seThainame = "SELECT DISTINCT a.JOBNO,a.THAINAME FROM(
                          SELECT JOBNO,VEHICLETRANSPORTPLANID ,EMPLOYEENAME1,EMPLOYEECODE1,VEHICLEREGISNUMBER1,THAINAME
                          FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW' )
                          AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'01/".$date."',103) AND CONVERT(DATE,GETDATE(),103)
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."'))a";
            $query_seThainame = sqlsrv_query($conn, $sql_seThainame, $params_seThainame);
          }else if ($_GET['companycode'] =='RKL' && $_GET['customercode'] =='KUBOTA'){
            $sql_seThainame = "SELECT DISTINCT a.JOBNO,a.THAINAME FROM(
                          SELECT JOBNO,VEHICLETRANSPORTPLANID ,EMPLOYEENAME1,EMPLOYEECODE1,VEHICLEREGISNUMBER1,THAINAME
                          FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE COMPANYCODE  ='RKL' AND CUSTOMERCODE = 'SKB'
                          AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'01/".$date."',103) AND CONVERT(DATE,GETDATE(),103)
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."'))a";
            $query_seThainame = sqlsrv_query($conn, $sql_seThainame, $params_seThainame);
          }else {
            $sql_seThainame = "SELECT DISTINCT a.JOBNO,a.THAINAME FROM(
                          SELECT JOBNO,VEHICLETRANSPORTPLANID ,EMPLOYEENAME1,EMPLOYEECODE1,VEHICLEREGISNUMBER1,THAINAME
                          FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'01/".$date."',103) AND CONVERT(DATE,GETDATE(),103)
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."'))a";
            $query_seThainame = sqlsrv_query($conn, $sql_seThainame, $params_seThainame);
          }

          while ($result_seThainame = sqlsrv_fetch_array($query_seThainame, SQLSRV_FETCH_ASSOC)) {

            $sql_execTemp_billing10 = "{call megTempOilreport(?,?,?,?)}";
            $params_execTemp_billing10 = array(
                array('select_tempoilkm', SQLSRV_PARAM_IN),
                array($result_seThainame['JOBNO'], SQLSRV_PARAM_IN),
                array($result_sePlan['EMPLOYEECODE'], SQLSRV_PARAM_IN),
                array($result_seThainame['THAINAME'], SQLSRV_PARAM_IN)

            );
            $query_execTemp_billing10 = sqlsrv_query($conn, $sql_execTemp_billing10, $params_execTemp_billing10);
            $result_execTemp_billing10 = sqlsrv_fetch_array($query_execTemp_billing10, SQLSRV_FETCH_ASSOC);

          $i2++;
        }





          ///////////////////นับจำนวน TRIP////////////////////////////////////////////
          if ($_GET['customercode'] == 'other') {
            $sql_seTrip = "SELECT MAX(a.TRIP) AS 'TRIP' FROM(SELECT JOBNO,VEHICLETRANSPORTPLANID ,EMPLOYEENAME1,EMPLOYEECODE1,EMPLOYEENAME2,EMPLOYEECODE2,
                          ROW_NUMBER() OVER(ORDER BY VEHICLETRANSPORTPLANID) AS 'TRIP'
                          FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE COMPANYCODE  ='".$_GET['companycode']."'
                          AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'01/".$date."',103) AND CONVERT(DATE,GETDATE(),103)
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."'))a";
            $query_seTrip = sqlsrv_query($conn, $sql_seTrip, $params_seTrip);
            $result_seTrip = sqlsrv_fetch_array($query_seTrip, SQLSRV_FETCH_ASSOC);
          }else if($_GET['companycode'] =='RKS' && $_GET['customercode'] =='TMTTAW') {
            $sql_seTrip = "SELECT MAX(a.TRIP) AS 'TRIP' FROM(SELECT JOBNO,VEHICLETRANSPORTPLANID ,EMPLOYEENAME1,EMPLOYEECODE1,EMPLOYEENAME2,EMPLOYEECODE2,
                          ROW_NUMBER() OVER(ORDER BY VEHICLETRANSPORTPLANID) AS 'TRIP'
                          FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'01/".$date."',103) AND CONVERT(DATE,GETDATE(),103)
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."'))a";
            $query_seTrip = sqlsrv_query($conn, $sql_seTrip, $params_seTrip);
            $result_seTrip = sqlsrv_fetch_array($query_seTrip, SQLSRV_FETCH_ASSOC);
          }else if($_GET['companycode'] =='RKL' && $_GET['customercode'] =='KUBOTA') {
            $sql_seTrip = "SELECT MAX(a.TRIP) AS 'TRIP' FROM(SELECT JOBNO,VEHICLETRANSPORTPLANID ,EMPLOYEENAME1,EMPLOYEECODE1,EMPLOYEENAME2,EMPLOYEECODE2,
                          ROW_NUMBER() OVER(ORDER BY VEHICLETRANSPORTPLANID) AS 'TRIP'
                          FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'01/".$date."',103) AND CONVERT(DATE,GETDATE(),103)
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."'))a";
            $query_seTrip = sqlsrv_query($conn, $sql_seTrip, $params_seTrip);
            $result_seTrip = sqlsrv_fetch_array($query_seTrip, SQLSRV_FETCH_ASSOC);
          }else {
            $sql_seTrip = "SELECT MAX(a.TRIP) AS 'TRIP' FROM(SELECT JOBNO,VEHICLETRANSPORTPLANID ,EMPLOYEENAME1,EMPLOYEECODE1,EMPLOYEENAME2,EMPLOYEECODE2,
                          ROW_NUMBER() OVER(ORDER BY VEHICLETRANSPORTPLANID) AS 'TRIP'
                          FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'01/".$date."',103) AND CONVERT(DATE,GETDATE(),103)
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."'))a";
            $query_seTrip = sqlsrv_query($conn, $sql_seTrip, $params_seTrip);
            $result_seTrip = sqlsrv_fetch_array($query_seTrip, SQLSRV_FETCH_ASSOC);
          }

          //////////////////หากิโลเมตร//////////////////////////
          if ($result_seTrip['TRIP'] == NULL) {
            $KM ='';
          }else {
            $sql_seKM = "SELECT SUM(CONVERT(DECIMAL,KM)) AS 'KM' FROM (
                SELECT  DISTINCT JOBNO,EMPLOYEECODE,THAINAME,KM
                FROM OILREPORT_KM
                WHERE EMPLOYEECODE ='".$result_sePlan['EMPLOYEECODE']."'
                AND KM IS NOT NULL
                AND KM !=''
                AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,GETDATE(),103))a";
            $query_seKM = sqlsrv_query($conn, $sql_seKM, $params_seKM);
            $result_seKM = sqlsrv_fetch_array($query_seKM, SQLSRV_FETCH_ASSOC);
            $KM = $result_seKM['KM'];

            // $sql_seKM = "SELECT SUM(CONVERT(DECIMAL,KM)) AS 'KM'  FROM OILREPORT_KM
            //             WHERE EMPLOYEECODE ='".$result_sePlan['EMPLOYEECODE']."'
            //             AND KM IS NOT NULL
            //             AND KM !=''
            //             AND CONVERT(DATE,CREATEDATE) = CONVERT(DATE,GETDATE(),103)";
            // $query_seKM = sqlsrv_query($conn, $sql_seKM, $params_seKM);
            // $result_seKM = sqlsrv_fetch_array($query_seKM, SQLSRV_FETCH_ASSOC);
            // $KM = $result_seKM['KM'];

          }


          ////////////////////////////(นับจำนวนเงินบวก)////////////////////////////////
          if ($_GET['customercode'] == 'other') {
            //วันที่1
            $sql_sePlan1 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT1' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'01/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan1  = sqlsrv_query($conn, $sql_sePlan1, $params_sePlan1);
            $result_sePlan1 = sqlsrv_fetch_array($query_sePlan1, SQLSRV_FETCH_ASSOC);
            //วันที่2
            $sql_sePlan2 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT2' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'02/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan2  = sqlsrv_query($conn, $sql_sePlan2, $params_sePlan2);
            $result_sePlan2 = sqlsrv_fetch_array($query_sePlan2, SQLSRV_FETCH_ASSOC);
            //วันที3
            $sql_sePlan3 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT3' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'03/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan3  = sqlsrv_query($conn, $sql_sePlan3, $params_sePlan3);
            $result_sePlan3 = sqlsrv_fetch_array($query_sePlan3, SQLSRV_FETCH_ASSOC);
            //วันที4
            $sql_sePlan4 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT4' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'04/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan4  = sqlsrv_query($conn, $sql_sePlan4, $params_sePlan4);
            $result_sePlan4 = sqlsrv_fetch_array($query_sePlan4, SQLSRV_FETCH_ASSOC);
            //วันที่5
            $sql_sePlan5 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT5' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'05/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan5  = sqlsrv_query($conn, $sql_sePlan5, $params_sePlan5);
            $result_sePlan5 = sqlsrv_fetch_array($query_sePlan5, SQLSRV_FETCH_ASSOC);
            //วันที่6
            $sql_sePlan6 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT6' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'06/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan6  = sqlsrv_query($conn, $sql_sePlan6, $params_sePlan6);
            $result_sePlan6 = sqlsrv_fetch_array($query_sePlan6, SQLSRV_FETCH_ASSOC);
            //วันที่1
            $sql_sePlan7 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT7' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'07/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan7  = sqlsrv_query($conn, $sql_sePlan7, $params_sePlan7);
            $result_sePlan7 = sqlsrv_fetch_array($query_sePlan7, SQLSRV_FETCH_ASSOC);
            //วันที่8
            $sql_sePlan8 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT8' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'08/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan8  = sqlsrv_query($conn, $sql_sePlan8, $params_sePlan8);
            $result_sePlan8 = sqlsrv_fetch_array($query_sePlan8, SQLSRV_FETCH_ASSOC);
            //วันที่9
            $sql_sePlan9 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT9' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'09/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan9  = sqlsrv_query($conn, $sql_sePlan9, $params_sePlan9);
            $result_sePlan9 = sqlsrv_fetch_array($query_sePlan9, SQLSRV_FETCH_ASSOC);
            //วันที่10
            $sql_sePlan10 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT10' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'10/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan10  = sqlsrv_query($conn, $sql_sePlan10, $params_sePlan10);
            $result_sePlan10 = sqlsrv_fetch_array($query_sePlan10, SQLSRV_FETCH_ASSOC);
            //วันที่11
            $sql_sePlan11 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT11' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'11/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan11  = sqlsrv_query($conn, $sql_sePlan11, $params_sePlan11);
            $result_sePlan11 = sqlsrv_fetch_array($query_sePlan11, SQLSRV_FETCH_ASSOC);
            //วันที่10
            $sql_sePlan12 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT12' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'12/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan12  = sqlsrv_query($conn, $sql_sePlan12, $params_sePlan12);
            $result_sePlan12 = sqlsrv_fetch_array($query_sePlan12, SQLSRV_FETCH_ASSOC);
            //วันที่13
            $sql_sePlan13 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT13' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'13/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan13  = sqlsrv_query($conn, $sql_sePlan13, $params_sePlan13);
            $result_sePlan13 = sqlsrv_fetch_array($query_sePlan13, SQLSRV_FETCH_ASSOC);
            //วันที่14
            $sql_sePlan14 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT14' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'14/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan14  = sqlsrv_query($conn, $sql_sePlan14, $params_sePlan14);
            $result_sePlan14 = sqlsrv_fetch_array($query_sePlan14, SQLSRV_FETCH_ASSOC);
            //วันที่15
            $sql_sePlan15 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT15' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'15/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan15  = sqlsrv_query($conn, $sql_sePlan15, $params_sePlan15);
            $result_sePlan15 = sqlsrv_fetch_array($query_sePlan15, SQLSRV_FETCH_ASSOC);
            //วันที่16
            $sql_sePlan16 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT16' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'16/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan16  = sqlsrv_query($conn, $sql_sePlan16, $params_sePlan16);
            $result_sePlan16 = sqlsrv_fetch_array($query_sePlan16, SQLSRV_FETCH_ASSOC);
            //วันที่17
            $sql_sePlan17 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT17' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'17/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan17  = sqlsrv_query($conn, $sql_sePlan17, $params_sePlan17);
            $result_sePlan17 = sqlsrv_fetch_array($query_sePlan17, SQLSRV_FETCH_ASSOC);
            //วันที่18
            $sql_sePlan18 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT18' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'18/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan18  = sqlsrv_query($conn, $sql_sePlan18, $params_sePlan18);
            $result_sePlan18 = sqlsrv_fetch_array($query_sePlan18, SQLSRV_FETCH_ASSOC);
            //วันที่19
            $sql_sePlan19 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT19' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'19/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan19  = sqlsrv_query($conn, $sql_sePlan19, $params_sePlan19);
            $result_sePlan19 = sqlsrv_fetch_array($query_sePlan19, SQLSRV_FETCH_ASSOC);
            //วันที่20
            $sql_sePlan20 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT20' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'20/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan20  = sqlsrv_query($conn, $sql_sePlan20, $params_sePlan20);
            $result_sePlan20 = sqlsrv_fetch_array($query_sePlan20, SQLSRV_FETCH_ASSOC);
            //วันที่21
            $sql_sePlan21 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT21' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'21/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan21  = sqlsrv_query($conn, $sql_sePlan21, $params_sePlan21);
            $result_sePlan21 = sqlsrv_fetch_array($query_sePlan21, SQLSRV_FETCH_ASSOC);
            //วันที่22
            $sql_sePlan22 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT22' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'22/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan22  = sqlsrv_query($conn, $sql_sePlan22, $params_sePlan22);
            $result_sePlan22 = sqlsrv_fetch_array($query_sePlan22, SQLSRV_FETCH_ASSOC);
            //วันที่23
            $sql_sePlan23 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT23' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'23/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan23  = sqlsrv_query($conn, $sql_sePlan23, $params_sePlan23);
            $result_sePlan23 = sqlsrv_fetch_array($query_sePlan23, SQLSRV_FETCH_ASSOC);
            //วันที่24
            $sql_sePlan24 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT24' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'24/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan24  = sqlsrv_query($conn, $sql_sePlan24, $params_sePlan24);
            $result_sePlan24 = sqlsrv_fetch_array($query_sePlan24, SQLSRV_FETCH_ASSOC);
            //วันที่25
            $sql_sePlan25 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT25' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'25/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
            $query_sePlan25  = sqlsrv_query($conn, $sql_sePlan25, $params_sePlan25);
            $result_sePlan25 = sqlsrv_fetch_array($query_sePlan25, SQLSRV_FETCH_ASSOC);
            //วันที่26
            $sql_sePlan26 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT26' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'26/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan26  = sqlsrv_query($conn, $sql_sePlan26, $params_sePlan26);
            $result_sePlan26 = sqlsrv_fetch_array($query_sePlan26, SQLSRV_FETCH_ASSOC);
            //วันที่27
            $sql_sePlan27 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT27' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'27/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan27  = sqlsrv_query($conn, $sql_sePlan27, $params_sePlan27);
            $result_sePlan27 = sqlsrv_fetch_array($query_sePlan27, SQLSRV_FETCH_ASSOC);
            //วันที่28
            $sql_sePlan28 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT28' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'28/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan28  = sqlsrv_query($conn, $sql_sePlan28, $params_sePlan28);
            $result_sePlan28 = sqlsrv_fetch_array($query_sePlan28, SQLSRV_FETCH_ASSOC);
            //วันที่29
            $sql_sePlan29 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT29' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'29/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan29  = sqlsrv_query($conn, $sql_sePlan29, $params_sePlan29);
            $result_sePlan29 = sqlsrv_fetch_array($query_sePlan29, SQLSRV_FETCH_ASSOC);
            //วันที่30
            $sql_sePlan30 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT30' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'30/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan30  = sqlsrv_query($conn, $sql_sePlan30, $params_sePlan30);
            $result_sePlan30 = sqlsrv_fetch_array($query_sePlan30, SQLSRV_FETCH_ASSOC);
            //วันที่31
            $sql_sePlan31 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT31' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'31/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan31  = sqlsrv_query($conn, $sql_sePlan31, $params_sePlan31);
            $result_sePlan31 = sqlsrv_fetch_array($query_sePlan31, SQLSRV_FETCH_ASSOC);
          }else if ($_GET['companycode'] == 'RKS' && $_GET['customercode'] == 'TMTTAW') {
            //วันที่1
            $sql_sePlan1 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2))  AS 'CNT1' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'01/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan1  = sqlsrv_query($conn, $sql_sePlan1, $params_sePlan1);
            $result_sePlan1 = sqlsrv_fetch_array($query_sePlan1, SQLSRV_FETCH_ASSOC);
            //วันที่2
            $sql_sePlan2 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2))  AS 'CNT2' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'02/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan2  = sqlsrv_query($conn, $sql_sePlan2, $params_sePlan2);
            $result_sePlan2 = sqlsrv_fetch_array($query_sePlan2, SQLSRV_FETCH_ASSOC);
            //วันที3
            $sql_sePlan3 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2))  AS 'CNT3' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'03/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan3  = sqlsrv_query($conn, $sql_sePlan3, $params_sePlan3);
            $result_sePlan3 = sqlsrv_fetch_array($query_sePlan3, SQLSRV_FETCH_ASSOC);
            //วันที4
            $sql_sePlan4 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2))  AS 'CNT4' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'04/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan4  = sqlsrv_query($conn, $sql_sePlan4, $params_sePlan4);
            $result_sePlan4 = sqlsrv_fetch_array($query_sePlan4, SQLSRV_FETCH_ASSOC);
            //วันที่5
            $sql_sePlan5 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2))  AS 'CNT5' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'05/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan5  = sqlsrv_query($conn, $sql_sePlan5, $params_sePlan5);
            $result_sePlan5 = sqlsrv_fetch_array($query_sePlan5, SQLSRV_FETCH_ASSOC);
            //วันที่6
            $sql_sePlan6 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT6' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'06/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan6  = sqlsrv_query($conn, $sql_sePlan6, $params_sePlan6);
            $result_sePlan6 = sqlsrv_fetch_array($query_sePlan6, SQLSRV_FETCH_ASSOC);
            //วันที่1
            $sql_sePlan7 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT7' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'07/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan7  = sqlsrv_query($conn, $sql_sePlan7, $params_sePlan7);
            $result_sePlan7 = sqlsrv_fetch_array($query_sePlan7, SQLSRV_FETCH_ASSOC);
            //วันที่8
            $sql_sePlan8 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT8' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'08/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan8  = sqlsrv_query($conn, $sql_sePlan8, $params_sePlan8);
            $result_sePlan8 = sqlsrv_fetch_array($query_sePlan8, SQLSRV_FETCH_ASSOC);
            //วันที่9
            $sql_sePlan9 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT9' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'09/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan9  = sqlsrv_query($conn, $sql_sePlan9, $params_sePlan9);
            $result_sePlan9 = sqlsrv_fetch_array($query_sePlan9, SQLSRV_FETCH_ASSOC);
            //วันที่10
            $sql_sePlan10 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT10' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'10/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan10  = sqlsrv_query($conn, $sql_sePlan10, $params_sePlan10);
            $result_sePlan10 = sqlsrv_fetch_array($query_sePlan10, SQLSRV_FETCH_ASSOC);
            //วันที่11
            $sql_sePlan11 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT11' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'11/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan11  = sqlsrv_query($conn, $sql_sePlan11, $params_sePlan11);
            $result_sePlan11 = sqlsrv_fetch_array($query_sePlan11, SQLSRV_FETCH_ASSOC);
            //วันที่10
            $sql_sePlan12 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT12' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'12/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan12  = sqlsrv_query($conn, $sql_sePlan12, $params_sePlan12);
            $result_sePlan12 = sqlsrv_fetch_array($query_sePlan12, SQLSRV_FETCH_ASSOC);
            //วันที่13
            $sql_sePlan13 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT13' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'13/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan13  = sqlsrv_query($conn, $sql_sePlan13, $params_sePlan13);
            $result_sePlan13 = sqlsrv_fetch_array($query_sePlan13, SQLSRV_FETCH_ASSOC);
            //วันที่14
            $sql_sePlan14 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT14' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'14/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan14  = sqlsrv_query($conn, $sql_sePlan14, $params_sePlan14);
            $result_sePlan14 = sqlsrv_fetch_array($query_sePlan14, SQLSRV_FETCH_ASSOC);
            //วันที่15
            $sql_sePlan15 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT15' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'15/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan15  = sqlsrv_query($conn, $sql_sePlan15, $params_sePlan15);
            $result_sePlan15 = sqlsrv_fetch_array($query_sePlan15, SQLSRV_FETCH_ASSOC);
            //วันที่16
            $sql_sePlan16 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT16' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'16/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan16  = sqlsrv_query($conn, $sql_sePlan16, $params_sePlan16);
            $result_sePlan16 = sqlsrv_fetch_array($query_sePlan16, SQLSRV_FETCH_ASSOC);
            //วันที่17
            $sql_sePlan17 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT17' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'17/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan17  = sqlsrv_query($conn, $sql_sePlan17, $params_sePlan17);
            $result_sePlan17 = sqlsrv_fetch_array($query_sePlan17, SQLSRV_FETCH_ASSOC);
            //วันที่18
            $sql_sePlan18 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT18' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'18/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan18  = sqlsrv_query($conn, $sql_sePlan18, $params_sePlan18);
            $result_sePlan18 = sqlsrv_fetch_array($query_sePlan18, SQLSRV_FETCH_ASSOC);
            //วันที่19
            $sql_sePlan19 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT19' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'19/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan19  = sqlsrv_query($conn, $sql_sePlan19, $params_sePlan19);
            $result_sePlan19 = sqlsrv_fetch_array($query_sePlan19, SQLSRV_FETCH_ASSOC);
            //วันที่20
            $sql_sePlan20 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT20' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'20/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan20  = sqlsrv_query($conn, $sql_sePlan20, $params_sePlan20);
            $result_sePlan20 = sqlsrv_fetch_array($query_sePlan20, SQLSRV_FETCH_ASSOC);
            //วันที่21
            $sql_sePlan21 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT21' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'21/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan21  = sqlsrv_query($conn, $sql_sePlan21, $params_sePlan21);
            $result_sePlan21 = sqlsrv_fetch_array($query_sePlan21, SQLSRV_FETCH_ASSOC);
            //วันที่22
            $sql_sePlan22 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT22' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'22/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan22  = sqlsrv_query($conn, $sql_sePlan22, $params_sePlan22);
            $result_sePlan22 = sqlsrv_fetch_array($query_sePlan22, SQLSRV_FETCH_ASSOC);
            //วันที่23
            $sql_sePlan23 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT23' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'23/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan23  = sqlsrv_query($conn, $sql_sePlan23, $params_sePlan23);
            $result_sePlan23 = sqlsrv_fetch_array($query_sePlan23, SQLSRV_FETCH_ASSOC);
            //วันที่24
            $sql_sePlan24 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT24' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'24/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan24  = sqlsrv_query($conn, $sql_sePlan24, $params_sePlan24);
            $result_sePlan24 = sqlsrv_fetch_array($query_sePlan24, SQLSRV_FETCH_ASSOC);
            //วันที่25
            $sql_sePlan25 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT25' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'25/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
            $query_sePlan25  = sqlsrv_query($conn, $sql_sePlan25, $params_sePlan25);
            $result_sePlan25 = sqlsrv_fetch_array($query_sePlan25, SQLSRV_FETCH_ASSOC);
            //วันที่26
            $sql_sePlan26 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT26' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'26/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan26  = sqlsrv_query($conn, $sql_sePlan26, $params_sePlan26);
            $result_sePlan26 = sqlsrv_fetch_array($query_sePlan26, SQLSRV_FETCH_ASSOC);
            //วันที่27
            $sql_sePlan27 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT27' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'27/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan27  = sqlsrv_query($conn, $sql_sePlan27, $params_sePlan27);
            $result_sePlan27 = sqlsrv_fetch_array($query_sePlan27, SQLSRV_FETCH_ASSOC);
            //วันที่28
            $sql_sePlan28 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT28' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'28/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan28  = sqlsrv_query($conn, $sql_sePlan28, $params_sePlan28);
            $result_sePlan28 = sqlsrv_fetch_array($query_sePlan28, SQLSRV_FETCH_ASSOC);
            //วันที่29
            $sql_sePlan29 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT29' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'29/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan29  = sqlsrv_query($conn, $sql_sePlan29, $params_sePlan29);
            $result_sePlan29 = sqlsrv_fetch_array($query_sePlan29, SQLSRV_FETCH_ASSOC);
            //วันที่30
            $sql_sePlan30 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT30' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'30/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan30  = sqlsrv_query($conn, $sql_sePlan30, $params_sePlan30);
            $result_sePlan30 = sqlsrv_fetch_array($query_sePlan30, SQLSRV_FETCH_ASSOC);
            //วันที่31
            $sql_sePlan31 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT31' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'31/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan31  = sqlsrv_query($conn, $sql_sePlan31, $params_sePlan31);
            $result_sePlan31 = sqlsrv_fetch_array($query_sePlan31, SQLSRV_FETCH_ASSOC);
          }else if ($_GET['companycode'] == 'RKL' && $_GET['customercode'] == 'KUBOTA') { //คิดเงิน SKB
            //วันที่1
            $sql_sePlan1 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT1' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'01/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan1  = sqlsrv_query($conn, $sql_sePlan1, $params_sePlan1);
            $result_sePlan1 = sqlsrv_fetch_array($query_sePlan1, SQLSRV_FETCH_ASSOC);
            //วันที่2
            $sql_sePlan2 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT2' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'02/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan2  = sqlsrv_query($conn, $sql_sePlan2, $params_sePlan2);
            $result_sePlan2 = sqlsrv_fetch_array($query_sePlan2, SQLSRV_FETCH_ASSOC);
            //วันที3
            $sql_sePlan3 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT3' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'03/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan3  = sqlsrv_query($conn, $sql_sePlan3, $params_sePlan3);
            $result_sePlan3 = sqlsrv_fetch_array($query_sePlan3, SQLSRV_FETCH_ASSOC);
            //วันที4
            $sql_sePlan4 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT4' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'04/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan4  = sqlsrv_query($conn, $sql_sePlan4, $params_sePlan4);
            $result_sePlan4 = sqlsrv_fetch_array($query_sePlan4, SQLSRV_FETCH_ASSOC);
            //วันที่5
            $sql_sePlan5 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT5' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'05/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan5  = sqlsrv_query($conn, $sql_sePlan5, $params_sePlan5);
            $result_sePlan5 = sqlsrv_fetch_array($query_sePlan5, SQLSRV_FETCH_ASSOC);
            //วันที่6
            $sql_sePlan6 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT6' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'06/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan6  = sqlsrv_query($conn, $sql_sePlan6, $params_sePlan6);
            $result_sePlan6 = sqlsrv_fetch_array($query_sePlan6, SQLSRV_FETCH_ASSOC);
            //วันที่1
            $sql_sePlan7 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT7' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'07/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan7  = sqlsrv_query($conn, $sql_sePlan7, $params_sePlan7);
            $result_sePlan7 = sqlsrv_fetch_array($query_sePlan7, SQLSRV_FETCH_ASSOC);
            //วันที่8
            $sql_sePlan8 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT8' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'08/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan8  = sqlsrv_query($conn, $sql_sePlan8, $params_sePlan8);
            $result_sePlan8 = sqlsrv_fetch_array($query_sePlan8, SQLSRV_FETCH_ASSOC);
            //วันที่9
            $sql_sePlan9 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT9' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'09/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan9  = sqlsrv_query($conn, $sql_sePlan9, $params_sePlan9);
            $result_sePlan9 = sqlsrv_fetch_array($query_sePlan9, SQLSRV_FETCH_ASSOC);
            //วันที่10
            $sql_sePlan10 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT10' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'10/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan10  = sqlsrv_query($conn, $sql_sePlan10, $params_sePlan10);
            $result_sePlan10 = sqlsrv_fetch_array($query_sePlan10, SQLSRV_FETCH_ASSOC);
            //วันที่11
            $sql_sePlan11 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT11' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'11/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan11  = sqlsrv_query($conn, $sql_sePlan11, $params_sePlan11);
            $result_sePlan11 = sqlsrv_fetch_array($query_sePlan11, SQLSRV_FETCH_ASSOC);
            //วันที่10
            $sql_sePlan12 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT12' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'12/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan12  = sqlsrv_query($conn, $sql_sePlan12, $params_sePlan12);
            $result_sePlan12 = sqlsrv_fetch_array($query_sePlan12, SQLSRV_FETCH_ASSOC);
            //วันที่13
            $sql_sePlan13 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT13' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'13/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan13  = sqlsrv_query($conn, $sql_sePlan13, $params_sePlan13);
            $result_sePlan13 = sqlsrv_fetch_array($query_sePlan13, SQLSRV_FETCH_ASSOC);
            //วันที่14
            $sql_sePlan14 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT14' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'14/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan14  = sqlsrv_query($conn, $sql_sePlan14, $params_sePlan14);
            $result_sePlan14 = sqlsrv_fetch_array($query_sePlan14, SQLSRV_FETCH_ASSOC);
            //วันที่15
            $sql_sePlan15 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT15' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'15/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan15  = sqlsrv_query($conn, $sql_sePlan15, $params_sePlan15);
            $result_sePlan15 = sqlsrv_fetch_array($query_sePlan15, SQLSRV_FETCH_ASSOC);
            //วันที่16
            $sql_sePlan16 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT16' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'16/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan16  = sqlsrv_query($conn, $sql_sePlan16, $params_sePlan16);
            $result_sePlan16 = sqlsrv_fetch_array($query_sePlan16, SQLSRV_FETCH_ASSOC);
            //วันที่17
            $sql_sePlan17 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT17' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'17/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan17  = sqlsrv_query($conn, $sql_sePlan17, $params_sePlan17);
            $result_sePlan17 = sqlsrv_fetch_array($query_sePlan17, SQLSRV_FETCH_ASSOC);
            //วันที่18
            $sql_sePlan18 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT18' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'18/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan18  = sqlsrv_query($conn, $sql_sePlan18, $params_sePlan18);
            $result_sePlan18 = sqlsrv_fetch_array($query_sePlan18, SQLSRV_FETCH_ASSOC);
            //วันที่19
            $sql_sePlan19 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT19' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'19/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan19  = sqlsrv_query($conn, $sql_sePlan19, $params_sePlan19);
            $result_sePlan19 = sqlsrv_fetch_array($query_sePlan19, SQLSRV_FETCH_ASSOC);
            //วันที่20
            $sql_sePlan20 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT20' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'20/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan20  = sqlsrv_query($conn, $sql_sePlan20, $params_sePlan20);
            $result_sePlan20 = sqlsrv_fetch_array($query_sePlan20, SQLSRV_FETCH_ASSOC);
            //วันที่21
            $sql_sePlan21 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT21' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'21/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan21  = sqlsrv_query($conn, $sql_sePlan21, $params_sePlan21);
            $result_sePlan21 = sqlsrv_fetch_array($query_sePlan21, SQLSRV_FETCH_ASSOC);
            //วันที่22
            $sql_sePlan22 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT22' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'22/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan22  = sqlsrv_query($conn, $sql_sePlan22, $params_sePlan22);
            $result_sePlan22 = sqlsrv_fetch_array($query_sePlan22, SQLSRV_FETCH_ASSOC);
            //วันที่23
            $sql_sePlan23 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT23' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'23/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan23  = sqlsrv_query($conn, $sql_sePlan23, $params_sePlan23);
            $result_sePlan23 = sqlsrv_fetch_array($query_sePlan23, SQLSRV_FETCH_ASSOC);
            //วันที่24
            $sql_sePlan24 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT24' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'24/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan24  = sqlsrv_query($conn, $sql_sePlan24, $params_sePlan24);
            $result_sePlan24 = sqlsrv_fetch_array($query_sePlan24, SQLSRV_FETCH_ASSOC);
            //วันที่25
            $sql_sePlan25 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT25' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'25/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
            $query_sePlan25  = sqlsrv_query($conn, $sql_sePlan25, $params_sePlan25);
            $result_sePlan25 = sqlsrv_fetch_array($query_sePlan25, SQLSRV_FETCH_ASSOC);
            //วันที่26
            $sql_sePlan26 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT26' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'26/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan26  = sqlsrv_query($conn, $sql_sePlan26, $params_sePlan26);
            $result_sePlan26 = sqlsrv_fetch_array($query_sePlan26, SQLSRV_FETCH_ASSOC);
            //วันที่27
            $sql_sePlan27 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT27' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'27/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan27  = sqlsrv_query($conn, $sql_sePlan27, $params_sePlan27);
            $result_sePlan27 = sqlsrv_fetch_array($query_sePlan27, SQLSRV_FETCH_ASSOC);
            //วันที่28
            $sql_sePlan28 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT28' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'28/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan28  = sqlsrv_query($conn, $sql_sePlan28, $params_sePlan28);
            $result_sePlan28 = sqlsrv_fetch_array($query_sePlan28, SQLSRV_FETCH_ASSOC);
            //วันที่29
            $sql_sePlan29 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT29' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'29/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan29  = sqlsrv_query($conn, $sql_sePlan29, $params_sePlan29);
            $result_sePlan29 = sqlsrv_fetch_array($query_sePlan29, SQLSRV_FETCH_ASSOC);
            //วันที่30
            $sql_sePlan30 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT30' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'30/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan30  = sqlsrv_query($conn, $sql_sePlan30, $params_sePlan30);
            $result_sePlan30 = sqlsrv_fetch_array($query_sePlan30, SQLSRV_FETCH_ASSOC);
            //วันที่31
            $sql_sePlan31 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT31' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'31/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan31  = sqlsrv_query($conn, $sql_sePlan31, $params_sePlan31);
            $result_sePlan31 = sqlsrv_fetch_array($query_sePlan31, SQLSRV_FETCH_ASSOC);
          }else {
            //วันที่1
            $sql_sePlan1 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT1' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'01/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan1  = sqlsrv_query($conn, $sql_sePlan1, $params_sePlan1);
            $result_sePlan1 = sqlsrv_fetch_array($query_sePlan1, SQLSRV_FETCH_ASSOC);
            //วันที่2
            $sql_sePlan2 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT2' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'02/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan2  = sqlsrv_query($conn, $sql_sePlan2, $params_sePlan2);
            $result_sePlan2 = sqlsrv_fetch_array($query_sePlan2, SQLSRV_FETCH_ASSOC);
            //วันที3
            $sql_sePlan3 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT3' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'03/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan3  = sqlsrv_query($conn, $sql_sePlan3, $params_sePlan3);
            $result_sePlan3 = sqlsrv_fetch_array($query_sePlan3, SQLSRV_FETCH_ASSOC);
            //วันที4
            $sql_sePlan4 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT4' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'04/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan4  = sqlsrv_query($conn, $sql_sePlan4, $params_sePlan4);
            $result_sePlan4 = sqlsrv_fetch_array($query_sePlan4, SQLSRV_FETCH_ASSOC);
            //วันที่5
            $sql_sePlan5 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT5' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'05/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan5  = sqlsrv_query($conn, $sql_sePlan5, $params_sePlan5);
            $result_sePlan5 = sqlsrv_fetch_array($query_sePlan5, SQLSRV_FETCH_ASSOC);
            //วันที่6
            $sql_sePlan6 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT6' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'06/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan6  = sqlsrv_query($conn, $sql_sePlan6, $params_sePlan6);
            $result_sePlan6 = sqlsrv_fetch_array($query_sePlan6, SQLSRV_FETCH_ASSOC);
            //วันที่1
            $sql_sePlan7 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT7' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'07/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan7  = sqlsrv_query($conn, $sql_sePlan7, $params_sePlan7);
            $result_sePlan7 = sqlsrv_fetch_array($query_sePlan7, SQLSRV_FETCH_ASSOC);
            //วันที่8
            $sql_sePlan8 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT8' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'08/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan8  = sqlsrv_query($conn, $sql_sePlan8, $params_sePlan8);
            $result_sePlan8 = sqlsrv_fetch_array($query_sePlan8, SQLSRV_FETCH_ASSOC);
            //วันที่9
            $sql_sePlan9 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT9' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'09/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan9  = sqlsrv_query($conn, $sql_sePlan9, $params_sePlan9);
            $result_sePlan9 = sqlsrv_fetch_array($query_sePlan9, SQLSRV_FETCH_ASSOC);
            //วันที่10
            $sql_sePlan10 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT10' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'10/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan10  = sqlsrv_query($conn, $sql_sePlan10, $params_sePlan10);
            $result_sePlan10 = sqlsrv_fetch_array($query_sePlan10, SQLSRV_FETCH_ASSOC);
            //วันที่11
            $sql_sePlan11 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT11' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'11/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan11  = sqlsrv_query($conn, $sql_sePlan11, $params_sePlan11);
            $result_sePlan11 = sqlsrv_fetch_array($query_sePlan11, SQLSRV_FETCH_ASSOC);
            //วันที่10
            $sql_sePlan12 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT12' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'12/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan12  = sqlsrv_query($conn, $sql_sePlan12, $params_sePlan12);
            $result_sePlan12 = sqlsrv_fetch_array($query_sePlan12, SQLSRV_FETCH_ASSOC);
            //วันที่13
            $sql_sePlan13 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT13' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'13/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan13  = sqlsrv_query($conn, $sql_sePlan13, $params_sePlan13);
            $result_sePlan13 = sqlsrv_fetch_array($query_sePlan13, SQLSRV_FETCH_ASSOC);
            //วันที่14
            $sql_sePlan14 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT14' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'14/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan14  = sqlsrv_query($conn, $sql_sePlan14, $params_sePlan14);
            $result_sePlan14 = sqlsrv_fetch_array($query_sePlan14, SQLSRV_FETCH_ASSOC);
            //วันที่15
            $sql_sePlan15 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT15' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'15/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan15  = sqlsrv_query($conn, $sql_sePlan15, $params_sePlan15);
            $result_sePlan15 = sqlsrv_fetch_array($query_sePlan15, SQLSRV_FETCH_ASSOC);
            //วันที่16
            $sql_sePlan16 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT16' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'16/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan16  = sqlsrv_query($conn, $sql_sePlan16, $params_sePlan16);
            $result_sePlan16 = sqlsrv_fetch_array($query_sePlan16, SQLSRV_FETCH_ASSOC);
            //วันที่17
            $sql_sePlan17 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT17' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'17/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan17  = sqlsrv_query($conn, $sql_sePlan17, $params_sePlan17);
            $result_sePlan17 = sqlsrv_fetch_array($query_sePlan17, SQLSRV_FETCH_ASSOC);
            //วันที่18
            $sql_sePlan18 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT18' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'18/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan18  = sqlsrv_query($conn, $sql_sePlan18, $params_sePlan18);
            $result_sePlan18 = sqlsrv_fetch_array($query_sePlan18, SQLSRV_FETCH_ASSOC);
            //วันที่19
            $sql_sePlan19 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT19' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'19/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan19  = sqlsrv_query($conn, $sql_sePlan19, $params_sePlan19);
            $result_sePlan19 = sqlsrv_fetch_array($query_sePlan19, SQLSRV_FETCH_ASSOC);
            //วันที่20
            $sql_sePlan20 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT20' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'20/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan20  = sqlsrv_query($conn, $sql_sePlan20, $params_sePlan20);
            $result_sePlan20 = sqlsrv_fetch_array($query_sePlan20, SQLSRV_FETCH_ASSOC);
            //วันที่21
            $sql_sePlan21 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT21' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'21/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan21  = sqlsrv_query($conn, $sql_sePlan21, $params_sePlan21);
            $result_sePlan21 = sqlsrv_fetch_array($query_sePlan21, SQLSRV_FETCH_ASSOC);
            //วันที่22
            $sql_sePlan22 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT22' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'22/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan22  = sqlsrv_query($conn, $sql_sePlan22, $params_sePlan22);
            $result_sePlan22 = sqlsrv_fetch_array($query_sePlan22, SQLSRV_FETCH_ASSOC);
            //วันที่23
            $sql_sePlan23 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT23' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'23/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan23  = sqlsrv_query($conn, $sql_sePlan23, $params_sePlan23);
            $result_sePlan23 = sqlsrv_fetch_array($query_sePlan23, SQLSRV_FETCH_ASSOC);
            //วันที่24
            $sql_sePlan24 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT24' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'24/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan24  = sqlsrv_query($conn, $sql_sePlan24, $params_sePlan24);
            $result_sePlan24 = sqlsrv_fetch_array($query_sePlan24, SQLSRV_FETCH_ASSOC);
            //วันที่25
            $sql_sePlan25 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT25' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'25/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
            $query_sePlan25  = sqlsrv_query($conn, $sql_sePlan25, $params_sePlan25);
            $result_sePlan25 = sqlsrv_fetch_array($query_sePlan25, SQLSRV_FETCH_ASSOC);
            //วันที่26
            $sql_sePlan26 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT26' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'26/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan26  = sqlsrv_query($conn, $sql_sePlan26, $params_sePlan26);
            $result_sePlan26 = sqlsrv_fetch_array($query_sePlan26, SQLSRV_FETCH_ASSOC);
            //วันที่27
            $sql_sePlan27 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT27' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'27/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan27  = sqlsrv_query($conn, $sql_sePlan27, $params_sePlan27);
            $result_sePlan27 = sqlsrv_fetch_array($query_sePlan27, SQLSRV_FETCH_ASSOC);
            //วันที่28
            $sql_sePlan28 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT28' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'28/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan28  = sqlsrv_query($conn, $sql_sePlan28, $params_sePlan28);
            $result_sePlan28 = sqlsrv_fetch_array($query_sePlan28, SQLSRV_FETCH_ASSOC);
            //วันที่29
            $sql_sePlan29 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT29' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'29/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan29  = sqlsrv_query($conn, $sql_sePlan29, $params_sePlan29);
            $result_sePlan29 = sqlsrv_fetch_array($query_sePlan29, SQLSRV_FETCH_ASSOC);
            //วันที่30
            $sql_sePlan30 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT30' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'30/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan30  = sqlsrv_query($conn, $sql_sePlan30, $params_sePlan30);
            $result_sePlan30 = sqlsrv_fetch_array($query_sePlan30, SQLSRV_FETCH_ASSOC);
            //วันที่31
            $sql_sePlan31 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'CNT31' FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'31/".$date."',103)
                            AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                            AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                            AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                            AND CONVERT(DECIMAL,C3) >= 0";
            $query_sePlan31  = sqlsrv_query($conn, $sql_sePlan31, $params_sePlan31);
            $result_sePlan31 = sqlsrv_fetch_array($query_sePlan31, SQLSRV_FETCH_ASSOC);
          }

          /////////////////////////////จำนวนรวมเที่ยวที่วิ่งงานของแต่ละพขร//////////////////////////////////////
          $SUMTRIP = number_format($result_sePlan1['CNT1'])+number_format($result_sePlan2['CNT2'])+number_format($result_sePlan3['CNT3'])+number_format($result_sePlan4['CNT4'])+number_format($result_sePlan5['CNT5'])
          +number_format($result_sePlan6['CNT6'])+number_format($result_sePlan7['CNT7'])+number_format($result_sePlan8['CNT8'])+number_format($result_sePlan9['CNT9'])+number_format($result_sePlan10['CNT10'])
          +number_format($result_sePlan11['CNT11'])+number_format($result_sePlan12['CNT12'])+number_format($result_sePlan13['CNT13'])+number_format($result_sePlan14['CNT14'])+number_format($result_sePlan15['CNT15'])
          +number_format($result_sePlan16['CNT16'])+number_format($result_sePlan17['CNT17'])+number_format($result_sePlan18['CNT18'])+number_format($result_sePlan19['CNT19'])+number_format($result_sePlan20['CNT20'])
          +number_format($result_sePlan21['CNT21'])+number_format($result_sePlan22['CNT22'])+number_format($result_sePlan23['CNT23'])+number_format($result_sePlan24['CNT24'])+number_format($result_sePlan25['CNT25'])
          +number_format($result_sePlan26['CNT26'])+number_format($result_sePlan27['CNT27'])+number_format($result_sePlan28['CNT28'])+number_format($result_sePlan29['CNT29'])+number_format($result_sePlan30['CNT30'])
          +number_format($result_sePlan31['CNT31']);

          /////////////////////////////////////////////////////////////////////

        //////////////////////////////(นับจำนวนเงินลบ)/////////////////////////////////////////

        if ($_GET['customercode'] =='other') {
          //วันที่1
          $sql_seIncen1 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN1' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'01/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen1  = sqlsrv_query($conn, $sql_seIncen1, $params_seIncen1);
          $result_seIncen1 = sqlsrv_fetch_array($query_seIncen1, SQLSRV_FETCH_ASSOC);
          //วันที่2
          $sql_seIncen2 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN2' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'02/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen2  = sqlsrv_query($conn, $sql_seIncen2, $params_seIncen2);
          $result_seIncen2 = sqlsrv_fetch_array($query_seIncen2, SQLSRV_FETCH_ASSOC);
          //วันที่3
          $sql_seIncen3 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN3' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'03/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen3  = sqlsrv_query($conn, $sql_seIncen3, $params_seIncen3);
          $result_seIncen3 = sqlsrv_fetch_array($query_seIncen3, SQLSRV_FETCH_ASSOC);
          //วันที่4
          $sql_seIncen4 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN4' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'04/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen4  = sqlsrv_query($conn, $sql_seIncen4, $params_seIncen4);
          $result_seIncen4 = sqlsrv_fetch_array($query_seIncen4, SQLSRV_FETCH_ASSOC);
          //วันที่5
          $sql_seIncen5 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN5' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'05/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen5  = sqlsrv_query($conn, $sql_seIncen5, $params_seIncen5);
          $result_seIncen5 = sqlsrv_fetch_array($query_seIncen5, SQLSRV_FETCH_ASSOC);
          //วันที่6
          $sql_seIncen6 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN6' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'06/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen6  = sqlsrv_query($conn, $sql_seIncen6, $params_seIncen6);
          $result_seIncen6 = sqlsrv_fetch_array($query_seIncen6, SQLSRV_FETCH_ASSOC);
          //วันที่7
          $sql_seIncen7 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN7' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'07/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen7  = sqlsrv_query($conn, $sql_seIncen7, $params_seIncen7);
          $result_seIncen7 = sqlsrv_fetch_array($query_seIncen7, SQLSRV_FETCH_ASSOC);
          //วันที่8
          $sql_seIncen8 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN8' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'08/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen8  = sqlsrv_query($conn, $sql_seIncen8, $params_seIncen8);
          $result_seIncen8 = sqlsrv_fetch_array($query_seIncen8, SQLSRV_FETCH_ASSOC);
          //วันที่9
          $sql_seIncen9 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN9' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'09/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen9  = sqlsrv_query($conn, $sql_seIncen9, $params_seIncen9);
          $result_seIncen9 = sqlsrv_fetch_array($query_seIncen9, SQLSRV_FETCH_ASSOC);
          //วันที่10
          $sql_seIncen10 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN10' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'10/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen10  = sqlsrv_query($conn, $sql_seIncen10, $params_seIncen10);
          $result_seIncen10 = sqlsrv_fetch_array($query_seIncen10, SQLSRV_FETCH_ASSOC);
          //วันที่11
          $sql_seIncen11 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN11' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'11/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen11  = sqlsrv_query($conn, $sql_seIncen11, $params_seIncen11);
          $result_seIncen11 = sqlsrv_fetch_array($query_seIncen11, SQLSRV_FETCH_ASSOC);
          //วันที่12
          $sql_seIncen12 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN12' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'12/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen12  = sqlsrv_query($conn, $sql_seIncen12, $params_seIncen12);
          $result_seIncen12 = sqlsrv_fetch_array($query_seIncen12, SQLSRV_FETCH_ASSOC);
          //วันที่13
          $sql_seIncen13 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN13' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'13/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen13  = sqlsrv_query($conn, $sql_seIncen13, $params_seIncen13);
          $result_seIncen13 = sqlsrv_fetch_array($query_seIncen13, SQLSRV_FETCH_ASSOC);
          //วันที่14
          $sql_seIncen14 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN14' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'14/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen14  = sqlsrv_query($conn, $sql_seIncen14, $params_seIncen14);
          $result_seIncen14 = sqlsrv_fetch_array($query_seIncen14, SQLSRV_FETCH_ASSOC);
          //วันที่14
          $sql_seIncen15 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN15' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'15/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen15  = sqlsrv_query($conn, $sql_seIncen15, $params_seIncen15);
          $result_seIncen15 = sqlsrv_fetch_array($query_seIncen15, SQLSRV_FETCH_ASSOC);
          //วันที่16
          $sql_seIncen16 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN16' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'16/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen16  = sqlsrv_query($conn, $sql_seIncen16, $params_seIncen16);
          $result_seIncen16 = sqlsrv_fetch_array($query_seIncen16, SQLSRV_FETCH_ASSOC);
          //วันที่17
          $sql_seIncen17 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN17' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'17/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen17  = sqlsrv_query($conn, $sql_seIncen17, $params_seIncen17);
          $result_seIncen17 = sqlsrv_fetch_array($query_seIncen17, SQLSRV_FETCH_ASSOC);
          //วันที่18
          $sql_seIncen18 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN18' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'18/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen18  = sqlsrv_query($conn, $sql_seIncen18, $params_seIncen18);
          $result_seIncen18 = sqlsrv_fetch_array($query_seIncen18, SQLSRV_FETCH_ASSOC);
          //วันที่19
          $sql_seIncen19 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN19' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'19/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen19  = sqlsrv_query($conn, $sql_seIncen19, $params_seIncen19);
          $result_seIncen19 = sqlsrv_fetch_array($query_seIncen19, SQLSRV_FETCH_ASSOC);
          //วันที่20
          $sql_seIncen20 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN20' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'20/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen20  = sqlsrv_query($conn, $sql_seIncen20, $params_seIncen20);
          $result_seIncen20 = sqlsrv_fetch_array($query_seIncen20, SQLSRV_FETCH_ASSOC);
          //วันที่21
          $sql_seIncen21 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN21' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'21/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen21  = sqlsrv_query($conn, $sql_seIncen21, $params_seIncen21);
          $result_seIncen21 = sqlsrv_fetch_array($query_seIncen21, SQLSRV_FETCH_ASSOC);
          //วันที่22
          $sql_seIncen22 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN22' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'22/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen22  = sqlsrv_query($conn, $sql_seIncen22, $params_seIncen22);
          $result_seIncen22 = sqlsrv_fetch_array($query_seIncen22, SQLSRV_FETCH_ASSOC);
          //วันที่23
          $sql_seIncen23 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN23' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'23/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen23  = sqlsrv_query($conn, $sql_seIncen23, $params_seIncen23);
          $result_seIncen23 = sqlsrv_fetch_array($query_seIncen23, SQLSRV_FETCH_ASSOC);
          //วันที่24
          $sql_seIncen24 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN24' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'24/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen24  = sqlsrv_query($conn, $sql_seIncen24, $params_seIncen24);
          $result_seIncen24 = sqlsrv_fetch_array($query_seIncen24, SQLSRV_FETCH_ASSOC);
          //วันที่25
          $sql_seIncen25 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN25' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'25/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen25  = sqlsrv_query($conn, $sql_seIncen25, $params_seIncen25);
          $result_seIncen25 = sqlsrv_fetch_array($query_seIncen25, SQLSRV_FETCH_ASSOC);
          //วันที่26
          $sql_seIncen26 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN26' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'26/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen26  = sqlsrv_query($conn, $sql_seIncen26, $params_seIncen26);
          $result_seIncen26 = sqlsrv_fetch_array($query_seIncen26, SQLSRV_FETCH_ASSOC);
          //วันที่27
          $sql_seIncen27 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN27' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'27/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen27  = sqlsrv_query($conn, $sql_seIncen27, $params_seIncen27);
          $result_seIncen27 = sqlsrv_fetch_array($query_seIncen27, SQLSRV_FETCH_ASSOC);
          //วันที่28
          $sql_seIncen28 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN28' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'28/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen28  = sqlsrv_query($conn, $sql_seIncen28, $params_seIncen28);
          $result_seIncen28 = sqlsrv_fetch_array($query_seIncen28, SQLSRV_FETCH_ASSOC);
          //วันที่29
          $sql_seIncen29 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN29' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'29/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen29  = sqlsrv_query($conn, $sql_seIncen29, $params_seIncen29);
          $result_seIncen29 = sqlsrv_fetch_array($query_seIncen29, SQLSRV_FETCH_ASSOC);
          //วันที่30
          $sql_seIncen30 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN30' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'30/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen30  = sqlsrv_query($conn, $sql_seIncen30, $params_seIncen30);
          $result_seIncen30 = sqlsrv_fetch_array($query_seIncen30, SQLSRV_FETCH_ASSOC);
          //วันที่31
          $sql_seIncen31 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN31' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'31/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen31  = sqlsrv_query($conn, $sql_seIncen31, $params_seIncen31);
          $result_seIncen31 = sqlsrv_fetch_array($query_seIncen31, SQLSRV_FETCH_ASSOC);
        }else if ($_GET['companycode'] =='RKS' && $_GET['customercode'] =='TMTTAW') {
          //วันที่1
          $sql_seIncen1 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN1' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'01/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen1  = sqlsrv_query($conn, $sql_seIncen1, $params_seIncen1);
          $result_seIncen1 = sqlsrv_fetch_array($query_seIncen1, SQLSRV_FETCH_ASSOC);
          //วันที่2
          $sql_seIncen2 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN2' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'02/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen2  = sqlsrv_query($conn, $sql_seIncen2, $params_seIncen2);
          $result_seIncen2 = sqlsrv_fetch_array($query_seIncen2, SQLSRV_FETCH_ASSOC);
          //วันที่3
          $sql_seIncen3 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN3' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'03/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen3  = sqlsrv_query($conn, $sql_seIncen3, $params_seIncen3);
          $result_seIncen3 = sqlsrv_fetch_array($query_seIncen3, SQLSRV_FETCH_ASSOC);
          //วันที่4
          $sql_seIncen4 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN4' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'04/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen4  = sqlsrv_query($conn, $sql_seIncen4, $params_seIncen4);
          $result_seIncen4 = sqlsrv_fetch_array($query_seIncen4, SQLSRV_FETCH_ASSOC);
          //วันที่5
          $sql_seIncen5 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN5' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'05/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen5  = sqlsrv_query($conn, $sql_seIncen5, $params_seIncen5);
          $result_seIncen5 = sqlsrv_fetch_array($query_seIncen5, SQLSRV_FETCH_ASSOC);
          //วันที่6
          $sql_seIncen6 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN6' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'06/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen6  = sqlsrv_query($conn, $sql_seIncen6, $params_seIncen6);
          $result_seIncen6 = sqlsrv_fetch_array($query_seIncen6, SQLSRV_FETCH_ASSOC);
          //วันที่7
          $sql_seIncen7 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN7' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'07/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen7  = sqlsrv_query($conn, $sql_seIncen7, $params_seIncen7);
          $result_seIncen7 = sqlsrv_fetch_array($query_seIncen7, SQLSRV_FETCH_ASSOC);
          //วันที่8
          $sql_seIncen8 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN8' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'08/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen8  = sqlsrv_query($conn, $sql_seIncen8, $params_seIncen8);
          $result_seIncen8 = sqlsrv_fetch_array($query_seIncen8, SQLSRV_FETCH_ASSOC);
          //วันที่9
          $sql_seIncen9 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN9' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'09/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen9  = sqlsrv_query($conn, $sql_seIncen9, $params_seIncen9);
          $result_seIncen9 = sqlsrv_fetch_array($query_seIncen9, SQLSRV_FETCH_ASSOC);
          //วันที่10
          $sql_seIncen10 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN10' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'10/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen10  = sqlsrv_query($conn, $sql_seIncen10, $params_seIncen10);
          $result_seIncen10 = sqlsrv_fetch_array($query_seIncen10, SQLSRV_FETCH_ASSOC);
          //วันที่11
          $sql_seIncen11 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN11' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'11/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen11  = sqlsrv_query($conn, $sql_seIncen11, $params_seIncen11);
          $result_seIncen11 = sqlsrv_fetch_array($query_seIncen11, SQLSRV_FETCH_ASSOC);
          //วันที่12
          $sql_seIncen12 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN12' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'12/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen12  = sqlsrv_query($conn, $sql_seIncen12, $params_seIncen12);
          $result_seIncen12 = sqlsrv_fetch_array($query_seIncen12, SQLSRV_FETCH_ASSOC);
          //วันที่13
          $sql_seIncen13 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN13' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'13/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen13  = sqlsrv_query($conn, $sql_seIncen13, $params_seIncen13);
          $result_seIncen13 = sqlsrv_fetch_array($query_seIncen13, SQLSRV_FETCH_ASSOC);
          //วันที่14
          $sql_seIncen14 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN14' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'14/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen14  = sqlsrv_query($conn, $sql_seIncen14, $params_seIncen14);
          $result_seIncen14 = sqlsrv_fetch_array($query_seIncen14, SQLSRV_FETCH_ASSOC);
          //วันที่14
          $sql_seIncen15 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN15' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'15/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen15  = sqlsrv_query($conn, $sql_seIncen15, $params_seIncen15);
          $result_seIncen15 = sqlsrv_fetch_array($query_seIncen15, SQLSRV_FETCH_ASSOC);
          //วันที่16
          $sql_seIncen16 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN16' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'16/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen16  = sqlsrv_query($conn, $sql_seIncen16, $params_seIncen16);
          $result_seIncen16 = sqlsrv_fetch_array($query_seIncen16, SQLSRV_FETCH_ASSOC);
          //วันที่17
          $sql_seIncen17 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN17' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'17/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen17  = sqlsrv_query($conn, $sql_seIncen17, $params_seIncen17);
          $result_seIncen17 = sqlsrv_fetch_array($query_seIncen17, SQLSRV_FETCH_ASSOC);
          //วันที่18
          $sql_seIncen18 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN18' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'18/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen18  = sqlsrv_query($conn, $sql_seIncen18, $params_seIncen18);
          $result_seIncen18 = sqlsrv_fetch_array($query_seIncen18, SQLSRV_FETCH_ASSOC);
          //วันที่19
          $sql_seIncen19 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN19' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'19/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen19  = sqlsrv_query($conn, $sql_seIncen19, $params_seIncen19);
          $result_seIncen19 = sqlsrv_fetch_array($query_seIncen19, SQLSRV_FETCH_ASSOC);
          //วันที่20
          $sql_seIncen20 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN20' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'20/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen20  = sqlsrv_query($conn, $sql_seIncen20, $params_seIncen20);
          $result_seIncen20 = sqlsrv_fetch_array($query_seIncen20, SQLSRV_FETCH_ASSOC);
          //วันที่21
          $sql_seIncen21 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN21' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'21/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen21  = sqlsrv_query($conn, $sql_seIncen21, $params_seIncen21);
          $result_seIncen21 = sqlsrv_fetch_array($query_seIncen21, SQLSRV_FETCH_ASSOC);
          //วันที่22
          $sql_seIncen22 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN22' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'22/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen22  = sqlsrv_query($conn, $sql_seIncen22, $params_seIncen22);
          $result_seIncen22 = sqlsrv_fetch_array($query_seIncen22, SQLSRV_FETCH_ASSOC);
          //วันที่23
          $sql_seIncen23 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN23' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'23/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen23  = sqlsrv_query($conn, $sql_seIncen23, $params_seIncen23);
          $result_seIncen23 = sqlsrv_fetch_array($query_seIncen23, SQLSRV_FETCH_ASSOC);
          //วันที่24
          $sql_seIncen24 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN24' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'24/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen24  = sqlsrv_query($conn, $sql_seIncen24, $params_seIncen24);
          $result_seIncen24 = sqlsrv_fetch_array($query_seIncen24, SQLSRV_FETCH_ASSOC);
          //วันที่25
          $sql_seIncen25 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN25' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'25/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen25  = sqlsrv_query($conn, $sql_seIncen25, $params_seIncen25);
          $result_seIncen25 = sqlsrv_fetch_array($query_seIncen25, SQLSRV_FETCH_ASSOC);
          //วันที่26
          $sql_seIncen26 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN26' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'26/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen26  = sqlsrv_query($conn, $sql_seIncen26, $params_seIncen26);
          $result_seIncen26 = sqlsrv_fetch_array($query_seIncen26, SQLSRV_FETCH_ASSOC);
          //วันที่27
          $sql_seIncen27 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN27' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'27/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen27  = sqlsrv_query($conn, $sql_seIncen27, $params_seIncen27);
          $result_seIncen27 = sqlsrv_fetch_array($query_seIncen27, SQLSRV_FETCH_ASSOC);
          //วันที่28
          $sql_seIncen28 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN28' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'28/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen28  = sqlsrv_query($conn, $sql_seIncen28, $params_seIncen28);
          $result_seIncen28 = sqlsrv_fetch_array($query_seIncen28, SQLSRV_FETCH_ASSOC);
          //วันที่29
          $sql_seIncen29 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN29' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'29/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen29  = sqlsrv_query($conn, $sql_seIncen29, $params_seIncen29);
          $result_seIncen29 = sqlsrv_fetch_array($query_seIncen29, SQLSRV_FETCH_ASSOC);
          //วันที่30
          $sql_seIncen30 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN30' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'30/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen30  = sqlsrv_query($conn, $sql_seIncen30, $params_seIncen30);
          $result_seIncen30 = sqlsrv_fetch_array($query_seIncen30, SQLSRV_FETCH_ASSOC);
          //วันที่31
          $sql_seIncen31 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN31' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'31/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND (CUSTOMERCODE = 'TMT' OR CUSTOMERCODE = 'TAW')
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen31  = sqlsrv_query($conn, $sql_seIncen31, $params_seIncen31);
          $result_seIncen31 = sqlsrv_fetch_array($query_seIncen31, SQLSRV_FETCH_ASSOC);
        }else if ($_GET['companycode'] =='RKL' && $_GET['customercode'] =='KUBOTA') {
          //วันที่1
          $sql_seIncen1 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN1' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'01/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen1  = sqlsrv_query($conn, $sql_seIncen1, $params_seIncen1);
          $result_seIncen1 = sqlsrv_fetch_array($query_seIncen1, SQLSRV_FETCH_ASSOC);
          //วันที่2
          $sql_seIncen2 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN2' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'02/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen2  = sqlsrv_query($conn, $sql_seIncen2, $params_seIncen2);
          $result_seIncen2 = sqlsrv_fetch_array($query_seIncen2, SQLSRV_FETCH_ASSOC);
          //วันที่3
          $sql_seIncen3 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN3' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'03/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen3  = sqlsrv_query($conn, $sql_seIncen3, $params_seIncen3);
          $result_seIncen3 = sqlsrv_fetch_array($query_seIncen3, SQLSRV_FETCH_ASSOC);
          //วันที่4
          $sql_seIncen4 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN4' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'04/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen4  = sqlsrv_query($conn, $sql_seIncen4, $params_seIncen4);
          $result_seIncen4 = sqlsrv_fetch_array($query_seIncen4, SQLSRV_FETCH_ASSOC);
          //วันที่5
          $sql_seIncen5 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN5' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'05/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen5  = sqlsrv_query($conn, $sql_seIncen5, $params_seIncen5);
          $result_seIncen5 = sqlsrv_fetch_array($query_seIncen5, SQLSRV_FETCH_ASSOC);
          //วันที่6
          $sql_seIncen6 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN6' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'06/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen6  = sqlsrv_query($conn, $sql_seIncen6, $params_seIncen6);
          $result_seIncen6 = sqlsrv_fetch_array($query_seIncen6, SQLSRV_FETCH_ASSOC);
          //วันที่7
          $sql_seIncen7 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN7' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'07/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen7  = sqlsrv_query($conn, $sql_seIncen7, $params_seIncen7);
          $result_seIncen7 = sqlsrv_fetch_array($query_seIncen7, SQLSRV_FETCH_ASSOC);
          //วันที่8
          $sql_seIncen8 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN8' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'08/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen8  = sqlsrv_query($conn, $sql_seIncen8, $params_seIncen8);
          $result_seIncen8 = sqlsrv_fetch_array($query_seIncen8, SQLSRV_FETCH_ASSOC);
          //วันที่9
          $sql_seIncen9 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN9' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'09/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen9  = sqlsrv_query($conn, $sql_seIncen9, $params_seIncen9);
          $result_seIncen9 = sqlsrv_fetch_array($query_seIncen9, SQLSRV_FETCH_ASSOC);
          //วันที่10
          $sql_seIncen10 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN10' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'10/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen10  = sqlsrv_query($conn, $sql_seIncen10, $params_seIncen10);
          $result_seIncen10 = sqlsrv_fetch_array($query_seIncen10, SQLSRV_FETCH_ASSOC);
          //วันที่11
          $sql_seIncen11 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN11' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'11/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen11  = sqlsrv_query($conn, $sql_seIncen11, $params_seIncen11);
          $result_seIncen11 = sqlsrv_fetch_array($query_seIncen11, SQLSRV_FETCH_ASSOC);
          //วันที่12
          $sql_seIncen12 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN12' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'12/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen12  = sqlsrv_query($conn, $sql_seIncen12, $params_seIncen12);
          $result_seIncen12 = sqlsrv_fetch_array($query_seIncen12, SQLSRV_FETCH_ASSOC);
          //วันที่13
          $sql_seIncen13 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN13' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'13/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen13  = sqlsrv_query($conn, $sql_seIncen13, $params_seIncen13);
          $result_seIncen13 = sqlsrv_fetch_array($query_seIncen13, SQLSRV_FETCH_ASSOC);
          //วันที่14
          $sql_seIncen14 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN14' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'14/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen14  = sqlsrv_query($conn, $sql_seIncen14, $params_seIncen14);
          $result_seIncen14 = sqlsrv_fetch_array($query_seIncen14, SQLSRV_FETCH_ASSOC);
          //วันที่14
          $sql_seIncen15 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN15' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'15/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen15  = sqlsrv_query($conn, $sql_seIncen15, $params_seIncen15);
          $result_seIncen15 = sqlsrv_fetch_array($query_seIncen15, SQLSRV_FETCH_ASSOC);
          //วันที่16
          $sql_seIncen16 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN16' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'16/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen16  = sqlsrv_query($conn, $sql_seIncen16, $params_seIncen16);
          $result_seIncen16 = sqlsrv_fetch_array($query_seIncen16, SQLSRV_FETCH_ASSOC);
          //วันที่17
          $sql_seIncen17 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN17' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'17/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen17  = sqlsrv_query($conn, $sql_seIncen17, $params_seIncen17);
          $result_seIncen17 = sqlsrv_fetch_array($query_seIncen17, SQLSRV_FETCH_ASSOC);
          //วันที่18
          $sql_seIncen18 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN18' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'18/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen18  = sqlsrv_query($conn, $sql_seIncen18, $params_seIncen18);
          $result_seIncen18 = sqlsrv_fetch_array($query_seIncen18, SQLSRV_FETCH_ASSOC);
          //วันที่19
          $sql_seIncen19 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN19' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'19/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen19  = sqlsrv_query($conn, $sql_seIncen19, $params_seIncen19);
          $result_seIncen19 = sqlsrv_fetch_array($query_seIncen19, SQLSRV_FETCH_ASSOC);
          //วันที่20
          $sql_seIncen20 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN20' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'20/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen20  = sqlsrv_query($conn, $sql_seIncen20, $params_seIncen20);
          $result_seIncen20 = sqlsrv_fetch_array($query_seIncen20, SQLSRV_FETCH_ASSOC);
          //วันที่21
          $sql_seIncen21 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN21' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'21/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen21  = sqlsrv_query($conn, $sql_seIncen21, $params_seIncen21);
          $result_seIncen21 = sqlsrv_fetch_array($query_seIncen21, SQLSRV_FETCH_ASSOC);
          //วันที่22
          $sql_seIncen22 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN22' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'22/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen22  = sqlsrv_query($conn, $sql_seIncen22, $params_seIncen22);
          $result_seIncen22 = sqlsrv_fetch_array($query_seIncen22, SQLSRV_FETCH_ASSOC);
          //วันที่23
          $sql_seIncen23 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN23' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'23/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen23  = sqlsrv_query($conn, $sql_seIncen23, $params_seIncen23);
          $result_seIncen23 = sqlsrv_fetch_array($query_seIncen23, SQLSRV_FETCH_ASSOC);
          //วันที่24
          $sql_seIncen24 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN24' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'24/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen24  = sqlsrv_query($conn, $sql_seIncen24, $params_seIncen24);
          $result_seIncen24 = sqlsrv_fetch_array($query_seIncen24, SQLSRV_FETCH_ASSOC);
          //วันที่25
          $sql_seIncen25 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN25' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'25/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen25  = sqlsrv_query($conn, $sql_seIncen25, $params_seIncen25);
          $result_seIncen25 = sqlsrv_fetch_array($query_seIncen25, SQLSRV_FETCH_ASSOC);
          //วันที่26
          $sql_seIncen26 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN26' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'26/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen26  = sqlsrv_query($conn, $sql_seIncen26, $params_seIncen26);
          $result_seIncen26 = sqlsrv_fetch_array($query_seIncen26, SQLSRV_FETCH_ASSOC);
          //วันที่27
          $sql_seIncen27 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN27' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'27/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen27  = sqlsrv_query($conn, $sql_seIncen27, $params_seIncen27);
          $result_seIncen27 = sqlsrv_fetch_array($query_seIncen27, SQLSRV_FETCH_ASSOC);
          //วันที่28
          $sql_seIncen28 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN28' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'28/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen28  = sqlsrv_query($conn, $sql_seIncen28, $params_seIncen28);
          $result_seIncen28 = sqlsrv_fetch_array($query_seIncen28, SQLSRV_FETCH_ASSOC);
          //วันที่29
          $sql_seIncen29 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN29' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'29/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen29  = sqlsrv_query($conn, $sql_seIncen29, $params_seIncen29);
          $result_seIncen29 = sqlsrv_fetch_array($query_seIncen29, SQLSRV_FETCH_ASSOC);
          //วันที่30
          $sql_seIncen30 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN30' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'30/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen30  = sqlsrv_query($conn, $sql_seIncen30, $params_seIncen30);
          $result_seIncen30 = sqlsrv_fetch_array($query_seIncen30, SQLSRV_FETCH_ASSOC);
          //วันที่31
          $sql_seIncen31 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN31' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'31/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = 'SKB'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen31  = sqlsrv_query($conn, $sql_seIncen31, $params_seIncen31);
          $result_seIncen31 = sqlsrv_fetch_array($query_seIncen31, SQLSRV_FETCH_ASSOC);
        }else {
          //วันที่1
          $sql_seIncen1 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN1' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'01/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen1  = sqlsrv_query($conn, $sql_seIncen1, $params_seIncen1);
          $result_seIncen1 = sqlsrv_fetch_array($query_seIncen1, SQLSRV_FETCH_ASSOC);
          //วันที่2
          $sql_seIncen2 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN2' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'02/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen2  = sqlsrv_query($conn, $sql_seIncen2, $params_seIncen2);
          $result_seIncen2 = sqlsrv_fetch_array($query_seIncen2, SQLSRV_FETCH_ASSOC);
          //วันที่3
          $sql_seIncen3 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN3' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'03/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen3  = sqlsrv_query($conn, $sql_seIncen3, $params_seIncen3);
          $result_seIncen3 = sqlsrv_fetch_array($query_seIncen3, SQLSRV_FETCH_ASSOC);
          //วันที่4
          $sql_seIncen4 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN4' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'04/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen4  = sqlsrv_query($conn, $sql_seIncen4, $params_seIncen4);
          $result_seIncen4 = sqlsrv_fetch_array($query_seIncen4, SQLSRV_FETCH_ASSOC);
          //วันที่5
          $sql_seIncen5 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN5' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'05/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen5  = sqlsrv_query($conn, $sql_seIncen5, $params_seIncen5);
          $result_seIncen5 = sqlsrv_fetch_array($query_seIncen5, SQLSRV_FETCH_ASSOC);
          //วันที่6
          $sql_seIncen6 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN6' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'06/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen6  = sqlsrv_query($conn, $sql_seIncen6, $params_seIncen6);
          $result_seIncen6 = sqlsrv_fetch_array($query_seIncen6, SQLSRV_FETCH_ASSOC);
          //วันที่7
          $sql_seIncen7 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN7' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'07/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen7  = sqlsrv_query($conn, $sql_seIncen7, $params_seIncen7);
          $result_seIncen7 = sqlsrv_fetch_array($query_seIncen7, SQLSRV_FETCH_ASSOC);
          //วันที่8
          $sql_seIncen8 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN8' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'08/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen8  = sqlsrv_query($conn, $sql_seIncen8, $params_seIncen8);
          $result_seIncen8 = sqlsrv_fetch_array($query_seIncen8, SQLSRV_FETCH_ASSOC);
          //วันที่9
          $sql_seIncen9 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN9' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'09/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen9  = sqlsrv_query($conn, $sql_seIncen9, $params_seIncen9);
          $result_seIncen9 = sqlsrv_fetch_array($query_seIncen9, SQLSRV_FETCH_ASSOC);
          //วันที่10
          $sql_seIncen10 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN10' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'10/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen10  = sqlsrv_query($conn, $sql_seIncen10, $params_seIncen10);
          $result_seIncen10 = sqlsrv_fetch_array($query_seIncen10, SQLSRV_FETCH_ASSOC);
          //วันที่11
          $sql_seIncen11 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN11' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'11/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen11  = sqlsrv_query($conn, $sql_seIncen11, $params_seIncen11);
          $result_seIncen11 = sqlsrv_fetch_array($query_seIncen11, SQLSRV_FETCH_ASSOC);
          //วันที่12
          $sql_seIncen12 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN12' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'12/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen12  = sqlsrv_query($conn, $sql_seIncen12, $params_seIncen12);
          $result_seIncen12 = sqlsrv_fetch_array($query_seIncen12, SQLSRV_FETCH_ASSOC);
          //วันที่13
          $sql_seIncen13 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN13' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'13/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen13  = sqlsrv_query($conn, $sql_seIncen13, $params_seIncen13);
          $result_seIncen13 = sqlsrv_fetch_array($query_seIncen13, SQLSRV_FETCH_ASSOC);
          //วันที่14
          $sql_seIncen14 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN14' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'14/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen14  = sqlsrv_query($conn, $sql_seIncen14, $params_seIncen14);
          $result_seIncen14 = sqlsrv_fetch_array($query_seIncen14, SQLSRV_FETCH_ASSOC);
          //วันที่14
          $sql_seIncen15 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN15' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'15/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen15  = sqlsrv_query($conn, $sql_seIncen15, $params_seIncen15);
          $result_seIncen15 = sqlsrv_fetch_array($query_seIncen15, SQLSRV_FETCH_ASSOC);
          //วันที่16
          $sql_seIncen16 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN16' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'16/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen16  = sqlsrv_query($conn, $sql_seIncen16, $params_seIncen16);
          $result_seIncen16 = sqlsrv_fetch_array($query_seIncen16, SQLSRV_FETCH_ASSOC);
          //วันที่17
          $sql_seIncen17 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN17' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'17/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen17  = sqlsrv_query($conn, $sql_seIncen17, $params_seIncen17);
          $result_seIncen17 = sqlsrv_fetch_array($query_seIncen17, SQLSRV_FETCH_ASSOC);
          //วันที่18
          $sql_seIncen18 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN18' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'18/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen18  = sqlsrv_query($conn, $sql_seIncen18, $params_seIncen18);
          $result_seIncen18 = sqlsrv_fetch_array($query_seIncen18, SQLSRV_FETCH_ASSOC);
          //วันที่19
          $sql_seIncen19 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN19' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'19/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen19  = sqlsrv_query($conn, $sql_seIncen19, $params_seIncen19);
          $result_seIncen19 = sqlsrv_fetch_array($query_seIncen19, SQLSRV_FETCH_ASSOC);
          //วันที่20
          $sql_seIncen20 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN20' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'20/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen20  = sqlsrv_query($conn, $sql_seIncen20, $params_seIncen20);
          $result_seIncen20 = sqlsrv_fetch_array($query_seIncen20, SQLSRV_FETCH_ASSOC);
          //วันที่21
          $sql_seIncen21 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN21' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'21/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen21  = sqlsrv_query($conn, $sql_seIncen21, $params_seIncen21);
          $result_seIncen21 = sqlsrv_fetch_array($query_seIncen21, SQLSRV_FETCH_ASSOC);
          //วันที่22
          $sql_seIncen22 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN22' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'22/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen22  = sqlsrv_query($conn, $sql_seIncen22, $params_seIncen22);
          $result_seIncen22 = sqlsrv_fetch_array($query_seIncen22, SQLSRV_FETCH_ASSOC);
          //วันที่23
          $sql_seIncen23 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN23' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'23/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen23  = sqlsrv_query($conn, $sql_seIncen23, $params_seIncen23);
          $result_seIncen23 = sqlsrv_fetch_array($query_seIncen23, SQLSRV_FETCH_ASSOC);
          //วันที่24
          $sql_seIncen24 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN24' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'24/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen24  = sqlsrv_query($conn, $sql_seIncen24, $params_seIncen24);
          $result_seIncen24 = sqlsrv_fetch_array($query_seIncen24, SQLSRV_FETCH_ASSOC);
          //วันที่25
          $sql_seIncen25 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN25' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'25/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen25  = sqlsrv_query($conn, $sql_seIncen25, $params_seIncen25);
          $result_seIncen25 = sqlsrv_fetch_array($query_seIncen25, SQLSRV_FETCH_ASSOC);
          //วันที่26
          $sql_seIncen26 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN26' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'26/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen26  = sqlsrv_query($conn, $sql_seIncen26, $params_seIncen26);
          $result_seIncen26 = sqlsrv_fetch_array($query_seIncen26, SQLSRV_FETCH_ASSOC);
          //วันที่27
          $sql_seIncen27 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN27' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'27/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen27  = sqlsrv_query($conn, $sql_seIncen27, $params_seIncen27);
          $result_seIncen27 = sqlsrv_fetch_array($query_seIncen27, SQLSRV_FETCH_ASSOC);
          //วันที่28
          $sql_seIncen28 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN28' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'28/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen28  = sqlsrv_query($conn, $sql_seIncen28, $params_seIncen28);
          $result_seIncen28 = sqlsrv_fetch_array($query_seIncen28, SQLSRV_FETCH_ASSOC);
          //วันที่29
          $sql_seIncen29 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN29' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'29/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen29  = sqlsrv_query($conn, $sql_seIncen29, $params_seIncen29);
          $result_seIncen29 = sqlsrv_fetch_array($query_seIncen29, SQLSRV_FETCH_ASSOC);
          //วันที่30
          $sql_seIncen30 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN30' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'30/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen30  = sqlsrv_query($conn, $sql_seIncen30, $params_seIncen30);
          $result_seIncen30 = sqlsrv_fetch_array($query_seIncen30, SQLSRV_FETCH_ASSOC);
          //วันที่31
          $sql_seIncen31 = "SELECT SUM(CONVERT(DECIMAL,C3)) / (COUNT(EMPLOYEECODE1) +  COUNT(EMPLOYEECODE2)) AS 'SUMINCEN31' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEWORKING) = CONVERT(DATE,'31/".$date."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' AND CUSTOMERCODE = '".$_GET['customercode']."'
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''
                          AND CONVERT(DECIMAL,C3) < 0";
          $query_seIncen31  = sqlsrv_query($conn, $sql_seIncen31, $params_seIncen31);
          $result_seIncen31 = sqlsrv_fetch_array($query_seIncen31, SQLSRV_FETCH_ASSOC);
        }

        /////////////////////////////จำนวนรวมค่าเที่ยวที่วิ่งงานของแต่ละพขร//////////////////////////////////////
        $SUMINCEN = number_format($result_seIncen1['SUMINCEN1'])+number_format($result_seIncen2['SUMINCEN2'])+number_format($result_seIncen3['SUMINCEN3'])+number_format($result_seIncen4['SUMINCEN4'])+number_format($result_seIncen5['SUMINCEN5'])
        +number_format($result_seIncen6['SUMINCEN6'])+number_format($result_seIncen7['SUMINCEN7'])+number_format($result_seIncen8['SUMINCEN8'])+number_format($result_seIncen9['SUMINCEN9'])+number_format($result_seIncen10['SUMINCEN10'])
        +number_format($result_seIncen11['SUMINCEN11'])+number_format($result_seIncen12['SUMINCEN12'])+number_format($result_seIncen13['SUMINCEN13'])+number_format($result_seIncen14['SUMINCEN14'])+number_format($result_seIncen15['SUMINCEN15'])
        +number_format($result_seIncen16['SUMINCEN16'])+number_format($result_seIncen17['SUMINCEN17'])+number_format($result_seIncen18['SUMINCEN18'])+number_format($result_seIncen19['SUMINCEN19'])+number_format($result_seIncen20['SUMINCEN20'])
        +number_format($result_seIncen21['SUMINCEN21'])+number_format($result_seIncen22['SUMINCEN22'])+number_format($result_seIncen23['SUMINCEN23'])+number_format($result_seIncen24['SUMINCEN24'])+number_format($result_seIncen25['SUMINCEN25'])
        +number_format($result_seIncen26['SUMINCEN26'])+number_format($result_seIncen27['SUMINCEN27'])+number_format($result_seIncen28['SUMINCEN28'])+number_format($result_seIncen29['SUMINCEN29'])+number_format($result_seIncen30['SUMINCEN30'])
        +number_format($result_seIncen31['SUMINCEN31']);

        /////////////////////////////////////////////////////////////////////


        //////////////////////////////////POSITION/////////////////////////////////

        // $sql_sePosId = "SELECT PositionID AS 'POSID'  FROM [203.150.225.30].[TigerE-HR].dbo.PNT_Person WHERE PersonCode = '" . $result_sePlan['EMPLOYEECODE'] . "'";
        // $query_sePosId = sqlsrv_query($conn, $sql_sePosId, $params_sePosId);
        // $result_sePosId = sqlsrv_fetch_array($query_sePosId, SQLSRV_FETCH_ASSOC);

        // $sql_sePosName = "SELECT PositionNameT AS 'POSNAME'  FROM [203.150.225.30].[TigerE-HR].[dbo].[ZFM_Position] WHERE PositionID ='" . $result_sePosId ['POSID']. "'";
        // $query_sePosName = sqlsrv_query($conn, $sql_sePosName, $params_sePosName);
        // $result_sePosName = sqlsrv_fetch_array($query_sePosName, SQLSRV_FETCH_ASSOC);

         ?>

      <tr style="border:1px solid #000;" >
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $i ?></td>
              <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
              <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEENAME'] ?></td>
              <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_seTrip['TRIP'] ?></td>
              <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $KM ?></td>
              <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= number_format($result_seKM['KM'] / $result_seTrip['TRIP'],2) ?></td>
              <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['PositionNameT']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan1['CNT1']) == '0' ? '' : number_format($result_sePlan1['CNT1']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen1['SUMINCEN1']) == '0' ? '' : number_format($result_seIncen1['SUMINCEN1']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan2['CNT2']) == '0' ? '' : number_format($result_sePlan2['CNT2']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen2['SUMINCEN2']) == '0' ? '' : number_format($result_seIncen2['SUMINCEN2']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan3['CNT3']) == '0' ? '' : number_format($result_sePlan3['CNT3']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen3['SUMINCEN3']) == '0' ? '' : number_format($result_seIncen3['SUMINCEN3']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan4['CNT4']) == '0' ? '' : number_format($result_sePlan4['CNT4']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen4['SUMINCEN4']) == '0' ? '' : number_format($result_seIncen4['SUMINCEN4']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan5['CNT5']) == '0' ? '' : number_format($result_sePlan5['CNT5']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen5['SUMINCEN5']) == '0' ? '' : number_format($result_seIncen5['SUMINCEN5']) ?></td>
              
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan6['CNT6']) == '0' ? '' : number_format($result_sePlan6['CNT6']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen6['SUMINCEN6']) == '0' ? '' : number_format($result_seIncen6['SUMINCEN6']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan7['CNT7']) == '0' ? '' : number_format($result_sePlan7['CNT7']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen7['SUMINCEN7']) == '0' ? '' : number_format($result_seIncen7['SUMINCEN7']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan8['CNT8']) == '0' ? '' : number_format($result_sePlan8['CNT8']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen8['SUMINCEN8']) == '0' ? '' : number_format($result_seIncen8['SUMINCEN8']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan9['CNT9']) == '0' ? '' : number_format($result_sePlan9['CNT9']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen9['SUMINCEN9']) == '0' ? '' : number_format($result_seIncen9['SUMINCEN9']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan10['CNT10']) == '0' ? '' : number_format($result_sePlan10['CNT10']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen10['SUMINCEN10']) == '0' ? '' : number_format($result_seIncen10['SUMINCEN10']) ?></td>
              
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan11['CNT11']) == '0' ? '' : number_format($result_sePlan11['CNT11']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen11['SUMINCEN11']) == '0' ? '' : number_format($result_seIncen11['SUMINCEN11']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan12['CNT12']) == '0' ? '' : number_format($result_sePlan12['CNT12']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen12['SUMINCEN12']) == '0' ? '' : number_format($result_seIncen12['SUMINCEN12']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan13['CNT13']) == '0' ? '' : number_format($result_sePlan13['CNT13']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen13['SUMINCEN13']) == '0' ? '' : number_format($result_seIncen13['SUMINCEN13']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan14['CNT14']) == '0' ? '' : number_format($result_sePlan14['CNT14']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen14['SUMINCEN14']) == '0' ? '' : number_format($result_seIncen14['SUMINCEN14']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan15['CNT15']) == '0' ? '' : number_format($result_sePlan15['CNT15']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen15['SUMINCEN15']) == '0' ? '' : number_format($result_seIncen15['SUMINCEN15']) ?></td>
              
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan16['CNT16']) == '0' ? '' : number_format($result_sePlan16['CNT16']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen16['SUMINCEN16']) == '0' ? '' : number_format($result_seIncen16['SUMINCEN16']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan17['CNT17']) == '0' ? '' : number_format($result_sePlan17['CNT17']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen17['SUMINCEN17']) == '0' ? '' : number_format($result_seIncen17['SUMINCEN17']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan18['CNT18']) == '0' ? '' : number_format($result_sePlan18['CNT18']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen18['SUMINCEN18']) == '0' ? '' : number_format($result_seIncen18['SUMINCEN18']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan19['CNT19']) == '0' ? '' : number_format($result_sePlan19['CNT19']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen19['SUMINCEN19']) == '0' ? '' : number_format($result_seIncen19['SUMINCEN19']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan20['CNT20']) == '0' ? '' : number_format($result_sePlan20['CNT20']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen20['SUMINCEN20']) == '0' ? '' : number_format($result_seIncen20['SUMINCEN20']) ?></td>
              
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan21['CNT21']) == '0' ? '' : number_format($result_sePlan21['CNT21']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen21['SUMINCEN21']) == '0' ? '' : number_format($result_seIncen21['SUMINCEN21']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan22['CNT22']) == '0' ? '' : number_format($result_sePlan22['CNT22']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen22['SUMINCEN22']) == '0' ? '' : number_format($result_seIncen22['SUMINCEN22']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan23['CNT23']) == '0' ? '' : number_format($result_sePlan23['CNT23']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen23['SUMINCEN23']) == '0' ? '' : number_format($result_seIncen23['SUMINCEN23']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan24['CNT24']) == '0' ? '' : number_format($result_sePlan24['CNT24']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen24['SUMINCEN24']) == '0' ? '' : number_format($result_seIncen24['SUMINCEN24']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan25['CNT25']) == '0' ? '' : number_format($result_sePlan25['CNT25']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen25['SUMINCEN25']) == '0' ? '' : number_format($result_seIncen25['SUMINCEN25']) ?></td>
              
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan26['CNT26']) == '0' ? '' : number_format($result_sePlan26['CNT26']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen26['SUMINCEN26']) == '0' ? '' : number_format($result_seIncen26['SUMINCEN26']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan27['CNT27']) == '0' ? '' : number_format($result_sePlan27['CNT27']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen27['SUMINCEN27']) == '0' ? '' : number_format($result_seIncen27['SUMINCEN27']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan28['CNT28']) == '0' ? '' : number_format($result_sePlan28['CNT28']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen28['SUMINCEN28']) == '0' ? '' : number_format($result_seIncen28['SUMINCEN28']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan29['CNT29']) == '0' ? '' : number_format($result_sePlan29['CNT29']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen29['SUMINCEN29']) == '0' ? '' : number_format($result_seIncen29['SUMINCEN29']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan30['CNT30']) == '0' ? '' : number_format($result_sePlan30['CNT30']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen30['SUMINCEN29']) == '0' ? '' : number_format($result_seIncen30['SUMINCEN30']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_sePlan31['CNT31']) == '0' ? '' : number_format($result_sePlan31['CNT31']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($result_seIncen31['SUMINCEN31']) == '0' ? '' : number_format($result_seIncen31['SUMINCEN31']) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($SUMTRIP) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($SUMINCEN) ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= number_format($SUMTRIP+$SUMINCEN) ?></td>


      </tr>
      <?php

      $i++;
      ///SUM TRIP ในแต่ละวัน
      $SUMTRIP1 = $SUMTRIP1+number_format($result_sePlan1['CNT1']);  $SUMTRIP2 = $SUMTRIP2+number_format($result_sePlan2['CNT2']); $SUMTRIP3 = $SUMTRIP3+number_format($result_sePlan3['CNT3']);  $SUMTRIP4 = $SUMTRIP4+number_format($result_sePlan4['CNT4']);
      $SUMTRIP5 = $SUMTRIP5+number_format($result_sePlan5['CNT5']);  $SUMTRIP6 = $SUMTRIP6+number_format($result_sePlan6['CNT6']); $SUMTRIP7 = $SUMTRIP7+number_format($result_sePlan7['CNT7']);  $SUMTRIP8 = $SUMTRIP8+number_format($result_sePlan8['CNT8']);
      $SUMTRIP9 = $SUMTRIP9+number_format($result_sePlan9['CNT9']);  $SUMTRIP10 = $SUMTRIP10+number_format($result_sePlan10['CNT10']); $SUMTRIP11 = $SUMTRIP11+number_format($result_sePlan11['CNT11']);  $SUMTRIP12 = $SUMTRIP12+number_format($result_sePlan12['CNT12']);
      $SUMTRIP13 = $SUMTRIP13+number_format($result_sePlan13['CNT13']);  $SUMTRIP14 = $SUMTRIP14+number_format($result_sePlan14['CNT14']); $SUMTRIP15 = $SUMTRIP15+number_format($result_sePlan15['CNT15']);  $SUMTRIP16 = $SUMTRIP16+number_format($result_sePlan16['CNT16']);
      $SUMTRIP17 = $SUMTRIP17+number_format($result_sePlan17['CNT17']);  $SUMTRIP18 = $SUMTRIP18+number_format($result_sePlan18['CNT18']); $SUMTRIP19 = $SUMTRIP19+number_format($result_sePlan19['CNT19']);  $SUMTRIP20 = $SUMTRIP20+number_format($result_sePlan20['CNT20']);
      $SUMTRIP21 = $SUMTRIP21+number_format($result_sePlan21['CNT21']); $SUMTRIP22 = $SUMTRIP22+number_format($result_sePlan22['CNT22']);  $SUMTRIP23 = $SUMTRIP23+number_format($result_sePlan23['CNT23']);  $SUMTRIP24 = $SUMTRIP24+number_format($result_sePlan24['CNT24']);
      $SUMTRIP25 = $SUMTRIP25+number_format($result_sePlan25['CNT25']); $SUMTRIP26 = $SUMTRIP26+number_format($result_sePlan26['CNT26']);  $SUMTRIP27 = $SUMTRIP27+number_format($result_sePlan27['CNT27']);  $SUMTRIP28 = $SUMTRIP28+number_format($result_sePlan28['CNT28']);
      $SUMTRIP29 = $SUMTRIP29+number_format($result_sePlan29['CNT29']); $SUMTRIP30 = $SUMTRIP30+number_format($result_sePlan30['CNT30']);  $SUMTRIP31 = $SUMTRIP31+number_format($result_sePlan31['CNT31']);
      ///SUM INCEN ในแต่ละวัน
      $SUMINCEN1 = $SUMINCEN1+number_format($result_seIncen1['SUMINCEN1']); $SUMINCEN2 = $SUMINCEN2+number_format($result_seIncen2['SUMINCEN2']); $SUMINCEN3 = $SUMINCEN3+number_format($result_seIncen3['SUMINCEN3']); $SUMINCEN4 = $SUMINCEN4+number_format($result_seIncen4['SUMINCEN4']);
      $SUMINCEN5 = $SUMINCEN5+number_format($result_seIncen5['SUMINCEN5']); $SUMINCEN6 = $SUMINCEN6+number_format($result_seIncen6['SUMINCEN6']); $SUMINCEN7 = $SUMINCEN7+number_format($result_seIncen7['SUMINCEN7']); $SUMINCEN8 = $SUMINCEN8+number_format($result_seIncen8['SUMINCEN8']);
      $SUMINCEN9 = $SUMINCEN9+number_format($result_seIncen9['SUMINCEN9']); $SUMINCEN10 = $SUMINCEN10+number_format($result_seIncen10['SUMINCEN10']); $SUMINCEN11 = $SUMINCEN11+number_format($result_seIncen11['SUMINCEN11']); $SUMINCEN12 = $SUMINCEN12+number_format($result_seIncen12['SUMINCEN12']);
      $SUMINCEN13 = $SUMINCEN13+number_format($result_seIncen13['SUMINCEN13']); $SUMINCEN14 = $SUMINCEN14+number_format($result_seIncen14['SUMINCEN14']); $SUMINCEN15 = $SUMINCEN15+number_format($result_seIncen15['SUMINCEN15']); $SUMINCEN16 = $SUMINCEN16+number_format($result_seIncen16['SUMINCEN16']);
      $SUMINCEN17 = $SUMINCEN17+number_format($result_seIncen17['SUMINCEN17']); $SUMINCEN18 = $SUMINCEN18+number_format($result_seIncen18['SUMINCEN18']); $SUMINCEN19 = $SUMINCEN19+number_format($result_seIncen19['SUMINCEN19']); $SUMINCEN20 = $SUMINCEN20+number_format($result_seIncen20['SUMINCEN20']);
      $SUMINCEN21 = $SUMINCEN21+number_format($result_seIncen21['SUMINCEN21']); $SUMINCEN22 = $SUMINCEN22+number_format($result_seIncen22['SUMINCEN22']); $SUMINCEN23 = $SUMINCEN23+number_format($result_seIncen23['SUMINCEN23']); $SUMINCEN24 = $SUMINCEN24+number_format($result_seIncen24['SUMINCEN24']);
      $SUMINCEN25 = $SUMINCEN25+number_format($result_seIncen25['SUMINCEN25']); $SUMINCEN26 = $SUMINCEN26+number_format($result_seIncen26['SUMINCEN26']); $SUMINCEN27 = $SUMINCEN27+number_format($result_seIncen27['SUMINCEN27']); $SUMINCEN28 = $SUMINCEN28+number_format($result_seIncen28['SUMINCEN28']);
      $SUMINCEN29 = $SUMINCEN29+number_format($result_seIncen29['SUMINCEN29']); $SUMINCEN30 = $SUMINCEN30+number_format($result_seIncen30['SUMINCEN30']); $SUMINCEN31 = $SUMINCEN31+number_format($result_seIncen31['SUMINCEN31']);


      $ALLSUMTRIP = $ALLSUMTRIP+$SUMTRIP;
      $ALLSUMINCEN = $ALLSUMINCEN+$SUMINCEN;
      }



       ?>

  </tbody><tfoot>
       <tr style="border:1px solid #000;">
          <td colspan="7" style="border:1px solid #000;padding:3px;text-align:center;"><b><u>รวม<u><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP1)?><b></td>
          <td style="border:1px solid #000;padding:4px;text-align:center;"><b><?=number_format($SUMINCEN1)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP2)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN2)?><b></td>
          <td style="border:1px solid #000;padding:4px;text-align:center;"><b><?=number_format($SUMTRIP3)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN3)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP4)?><b></td>
          <td style="border:1px solid #000;padding:4px;text-align:center;"><b><?=number_format($SUMINCEN4)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP5)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN5)?><b></td>
          <td style="border:1px solid #000;padding:4px;text-align:center;"><b><?=number_format($SUMTRIP6)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN6)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP7)?><b></td>
          <td style="border:1px solid #000;padding:4px;text-align:center;"><b><?=number_format($SUMINCEN7)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP8)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN8)?><b></td>
          <td style="border:1px solid #000;padding:4px;text-align:center;"><b><?=number_format($SUMTRIP9)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN9)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP10)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN10)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP11)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN11)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP12)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN12)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP13)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN13)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP14)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN14)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP15)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN15)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP16)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN16)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP17)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN17)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP18)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN18)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP19)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN19)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP20)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN20)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP21)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN21)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP22)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN22)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP23)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN23)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP24)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN24)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP25)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN25)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP26)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN26)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP27)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN27)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP28)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN28)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP29)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN29)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP30)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN30)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMTRIP31)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN31)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($ALLSUMTRIP)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($ALLSUMINCEN)?><b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><b><?=number_format($ALLSUMTRIP+$ALLSUMINCEN)?></b></td>
      </tr>
      </tfoot>
  </table>


      <br><br><br><br>
      <table >
      </table>

</body>
</html>
