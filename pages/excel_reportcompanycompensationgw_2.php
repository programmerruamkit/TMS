<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
error_reporting(0);
ini_set('display_errors', 0);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");
$sumtotal = "";

$condComp = " AND Company_Code = '" . $_GET['companycode'] . "'";
$sql_seComp = "{call megCompanyEHR_v2(?,?)}";
$params_seComp = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condComp, SQLSRV_PARAM_IN)
);
$query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
$result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC);

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
  array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);


$strExcelFileName = "รายงานค่าเที่ยวRRC(Summary)ประจำเดือน".$_GET['datestart'] .".xls";

$date = substr($_GET['datestart'],3,10);




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
  <table id="bg-table" width="150%" style="border-collapse: collapse;font-size:12;">

  <thead>
       <tr style="border:1px solid #000;" >
              <td colspan="60" style="border-right:1px solid #000;padding:3px;text-align:center;">
                  <b>สรุปค่าเที่ยวบริษัท <?= $result_seComp['Company_NameT'] ?> </b>
              </td>
              <td colspan="12" style="border-right:1px solid #000;padding:3px;text-align:center;">
                  <b>วันที่: <?= $_GET['datestart'] ?> ถึง  <?= $_GET['dateend'] ?></b>
              </td>
         </tr>
         <tr style="border:1px solid #000;background-color: #ccc" >
              <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>ลำดับ</b>
              </td>
              <td rowspan="2" colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>สายงาน</b>
              </td>
              <td rowspan="2" colspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>รหัส</b>
              </td>
              <td rowspan="2" colspan="3" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>พนักงานขับรถ</b>
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

              </td>

         </tr>
         <tr style="border:1px solid #000;background-color: #ccc" >

          <!-- //1 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //2 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //3 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //4 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //5 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //6 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //7 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //8 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //9 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //10 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //11 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //12 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //13 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //14 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //15 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //16 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //17 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //18 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //19 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //20 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //21 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //22 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //23 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //24 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //25 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //26 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //27 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //28 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //29 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //30 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //31 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //TOTAL -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Trip</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>

         </tr>

      </thead><tbody>
        <?php
        $i = 1;
        $sumpallet = "";
        $sumcompen = "";
        $sumall = "";
        $sumresult = "";
        $sql_seGetdate = "SELECT '" . $_GET['datestart'] . "' AS 'datestart',
                            CONVERT(VARCHAR, (SELECT DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,CONVERT(DATE,'01/" . $_GET['datestart'] . "',103))+1,0))), 103) AS 'dateend'";

        $query_seGetdate = sqlsrv_query($conn, $sql_seGetdate, $params_seGetdate);
        $result_seGetdate = sqlsrv_fetch_array($query_seGetdate, SQLSRV_FETCH_ASSOC);

        $sql_sePlan = " SELECT DISTINCT EMPLOYEECODE,EMPLOYEENAME FROM (
                        SELECT  DISTINCT EMPLOYEENAME1  AS 'EMPLOYEENAME',EMPLOYEECODE1 AS 'EMPLOYEECODE' FROM [dbo].[VEHICLETRANSPORTPLAN]
                        WHERE COMPANYCODE  ='".$_GET['companycode']."'
                        AND CONVERT(DATE,DATEDEALERIN) BETWEEN CONVERT(DATE,'01/".$_GET['datestart']."',103) AND CONVERT(DATE,'".$result_seGetdate['dateend']."',103)
                        AND EMPLOYEENAME1 IS NOT NULL
                        AND EMPLOYEECODE1  IS NOT NULL
                        AND EMPLOYEENAME1 != ''
                        AND EMPLOYEECODE1 != ''
                        UNION
                        SELECT  DISTINCT EMPLOYEENAME2 AS 'EMPLOYEENAME',EMPLOYEECODE2 AS 'EMPLOYEECODE' FROM [dbo].[VEHICLETRANSPORTPLAN]
                        WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                        AND CONVERT(DATE,DATEDEALERIN) BETWEEN CONVERT(DATE,'01/".$_GET['datestart']."',103) AND CONVERT(DATE,'".$result_seGetdate['dateend']."',103)
                        AND EMPLOYEENAME2 IS NOT NULL
                        AND EMPLOYEECODE2 IS NOT NULL
                        AND EMPLOYEENAME2 != ''
                        AND EMPLOYEECODE2 != ''
                        ) A";
        $query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
        while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {

          ////////////////////////////(นับจำนวนเที่ยวในแต่ละวัน)////////////////////////////////
          //วันที่1
          $sql_sePlan1 = "SELECT COUNT(JOBNO) AS 'CNT1' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'01/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan1  = sqlsrv_query($conn, $sql_sePlan1, $params_sePlan1);
          $result_sePlan1 = sqlsrv_fetch_array($query_sePlan1, SQLSRV_FETCH_ASSOC);
          //วันที่2
          $sql_sePlan2 = "SELECT COUNT(JOBNO) AS 'CNT2' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'02/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan2  = sqlsrv_query($conn, $sql_sePlan2, $params_sePlan2);
          $result_sePlan2 = sqlsrv_fetch_array($query_sePlan2, SQLSRV_FETCH_ASSOC);
          //วันที3
          $sql_sePlan3 = "SELECT COUNT(JOBNO) AS 'CNT3' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'03/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan3  = sqlsrv_query($conn, $sql_sePlan3, $params_sePlan3);
          $result_sePlan3 = sqlsrv_fetch_array($query_sePlan3, SQLSRV_FETCH_ASSOC);
          //วันที4
          $sql_sePlan4 = "SELECT COUNT(JOBNO) AS 'CNT4' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'04/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan4  = sqlsrv_query($conn, $sql_sePlan4, $params_sePlan4);
          $result_sePlan4 = sqlsrv_fetch_array($query_sePlan4, SQLSRV_FETCH_ASSOC);
          //วันที่5
          $sql_sePlan5 = "SELECT COUNT(JOBNO) AS 'CNT5' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'05/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan5  = sqlsrv_query($conn, $sql_sePlan5, $params_sePlan5);
          $result_sePlan5 = sqlsrv_fetch_array($query_sePlan5, SQLSRV_FETCH_ASSOC);
          //วันที่6
          $sql_sePlan6 = "SELECT COUNT(JOBNO) AS 'CNT6' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'06/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan6  = sqlsrv_query($conn, $sql_sePlan6, $params_sePlan6);
          $result_sePlan6 = sqlsrv_fetch_array($query_sePlan6, SQLSRV_FETCH_ASSOC);
          //วันที่1
          $sql_sePlan7 = "SELECT COUNT(JOBNO) AS 'CNT7' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'07/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan7  = sqlsrv_query($conn, $sql_sePlan7, $params_sePlan7);
          $result_sePlan7 = sqlsrv_fetch_array($query_sePlan7, SQLSRV_FETCH_ASSOC);
          //วันที่8
          $sql_sePlan8 = "SELECT COUNT(JOBNO) AS 'CNT8' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'08/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan8  = sqlsrv_query($conn, $sql_sePlan8, $params_sePlan8);
          $result_sePlan8 = sqlsrv_fetch_array($query_sePlan8, SQLSRV_FETCH_ASSOC);
          //วันที่9
          $sql_sePlan9 = "SELECT COUNT(JOBNO) AS 'CNT9' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'09/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan9  = sqlsrv_query($conn, $sql_sePlan9, $params_sePlan9);
          $result_sePlan9 = sqlsrv_fetch_array($query_sePlan9, SQLSRV_FETCH_ASSOC);
          //วันที่10
          $sql_sePlan10 = "SELECT COUNT(JOBNO) AS 'CNT10' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'10/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan10  = sqlsrv_query($conn, $sql_sePlan10, $params_sePlan10);
          $result_sePlan10 = sqlsrv_fetch_array($query_sePlan10, SQLSRV_FETCH_ASSOC);
          //วันที่11
          $sql_sePlan11 = "SELECT COUNT(JOBNO) AS 'CNT11' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'11/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan11  = sqlsrv_query($conn, $sql_sePlan11, $params_sePlan11);
          $result_sePlan11 = sqlsrv_fetch_array($query_sePlan11, SQLSRV_FETCH_ASSOC);
          //วันที่10
          $sql_sePlan12 = "SELECT COUNT(JOBNO) AS 'CNT12' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'12/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan12  = sqlsrv_query($conn, $sql_sePlan12, $params_sePlan12);
          $result_sePlan12 = sqlsrv_fetch_array($query_sePlan12, SQLSRV_FETCH_ASSOC);
          //วันที่13
          $sql_sePlan13 = "SELECT COUNT(JOBNO) AS 'CNT13' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'13/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan13  = sqlsrv_query($conn, $sql_sePlan13, $params_sePlan13);
          $result_sePlan13 = sqlsrv_fetch_array($query_sePlan13, SQLSRV_FETCH_ASSOC);
          //วันที่14
          $sql_sePlan14 = "SELECT COUNT(JOBNO) AS 'CNT14' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'14/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan14  = sqlsrv_query($conn, $sql_sePlan14, $params_sePlan14);
          $result_sePlan14 = sqlsrv_fetch_array($query_sePlan14, SQLSRV_FETCH_ASSOC);
          //วันที่15
          $sql_sePlan15 = "SELECT COUNT(JOBNO) AS 'CNT15' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'15/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan15  = sqlsrv_query($conn, $sql_sePlan15, $params_sePlan15);
          $result_sePlan15 = sqlsrv_fetch_array($query_sePlan15, SQLSRV_FETCH_ASSOC);
          //วันที่16
          $sql_sePlan16 = "SELECT COUNT(JOBNO) AS 'CNT16' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'16/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan16  = sqlsrv_query($conn, $sql_sePlan16, $params_sePlan16);
          $result_sePlan16 = sqlsrv_fetch_array($query_sePlan16, SQLSRV_FETCH_ASSOC);
          //วันที่17
          $sql_sePlan17 = "SELECT COUNT(JOBNO) AS 'CNT17' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'17/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan17  = sqlsrv_query($conn, $sql_sePlan17, $params_sePlan17);
          $result_sePlan17 = sqlsrv_fetch_array($query_sePlan17, SQLSRV_FETCH_ASSOC);
          //วันที่18
          $sql_sePlan18 = "SELECT COUNT(JOBNO) AS 'CNT18' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'18/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan18  = sqlsrv_query($conn, $sql_sePlan18, $params_sePlan18);
          $result_sePlan18 = sqlsrv_fetch_array($query_sePlan18, SQLSRV_FETCH_ASSOC);
          //วันที่19
          $sql_sePlan19 = "SELECT COUNT(JOBNO) AS 'CNT19' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'19/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan19  = sqlsrv_query($conn, $sql_sePlan19, $params_sePlan19);
          $result_sePlan19 = sqlsrv_fetch_array($query_sePlan19, SQLSRV_FETCH_ASSOC);
          //วันที่20
          $sql_sePlan20 = "SELECT COUNT(JOBNO) AS 'CNT20' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'20/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan20  = sqlsrv_query($conn, $sql_sePlan20, $params_sePlan20);
          $result_sePlan20 = sqlsrv_fetch_array($query_sePlan20, SQLSRV_FETCH_ASSOC);
          //วันที่21
          $sql_sePlan21 = "SELECT COUNT(JOBNO) AS 'CNT21' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'21/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan21  = sqlsrv_query($conn, $sql_sePlan21, $params_sePlan21);
          $result_sePlan21 = sqlsrv_fetch_array($query_sePlan21, SQLSRV_FETCH_ASSOC);
          //วันที่22
          $sql_sePlan22 = "SELECT COUNT(JOBNO) AS 'CNT22' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'22/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan22  = sqlsrv_query($conn, $sql_sePlan22, $params_sePlan22);
          $result_sePlan22 = sqlsrv_fetch_array($query_sePlan22, SQLSRV_FETCH_ASSOC);
          //วันที่23
          $sql_sePlan23 = "SELECT COUNT(JOBNO) AS 'CNT23' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'23/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan23  = sqlsrv_query($conn, $sql_sePlan23, $params_sePlan23);
          $result_sePlan23 = sqlsrv_fetch_array($query_sePlan23, SQLSRV_FETCH_ASSOC);
          //วันที่24
          $sql_sePlan24 = "SELECT COUNT(JOBNO) AS 'CNT24' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'24/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan24  = sqlsrv_query($conn, $sql_sePlan24, $params_sePlan24);
          $result_sePlan24 = sqlsrv_fetch_array($query_sePlan24, SQLSRV_FETCH_ASSOC);
          //วันที่25
          $sql_sePlan25 = "SELECT COUNT(JOBNO) AS 'CNT25' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'25/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan25  = sqlsrv_query($conn, $sql_sePlan25, $params_sePlan25);
          $result_sePlan25 = sqlsrv_fetch_array($query_sePlan25, SQLSRV_FETCH_ASSOC);
          //วันที่26
          $sql_sePlan26 = "SELECT COUNT(JOBNO) AS 'CNT26' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'26/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan26  = sqlsrv_query($conn, $sql_sePlan26, $params_sePlan26);
          $result_sePlan26 = sqlsrv_fetch_array($query_sePlan26, SQLSRV_FETCH_ASSOC);
          //วันที่27
          $sql_sePlan27 = "SELECT COUNT(JOBNO) AS 'CNT27' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'27/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan27  = sqlsrv_query($conn, $sql_sePlan27, $params_sePlan27);
          $result_sePlan27 = sqlsrv_fetch_array($query_sePlan27, SQLSRV_FETCH_ASSOC);
          //วันที่28
          $sql_sePlan28 = "SELECT COUNT(JOBNO) AS 'CNT28' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'28/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan28  = sqlsrv_query($conn, $sql_sePlan28, $params_sePlan28);
          $result_sePlan28 = sqlsrv_fetch_array($query_sePlan28, SQLSRV_FETCH_ASSOC);
          //วันที่29
          $sql_sePlan29 = "SELECT COUNT(JOBNO) AS 'CNT29' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'29/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan29  = sqlsrv_query($conn, $sql_sePlan29, $params_sePlan29);
          $result_sePlan29 = sqlsrv_fetch_array($query_sePlan29, SQLSRV_FETCH_ASSOC);
          //วันที่30
          $sql_sePlan30 = "SELECT COUNT(JOBNO) AS 'CNT30' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'30/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan30  = sqlsrv_query($conn, $sql_sePlan30, $params_sePlan30);
          $result_sePlan30 = sqlsrv_fetch_array($query_sePlan30, SQLSRV_FETCH_ASSOC);
          //วันที่31
          $sql_sePlan31 = "SELECT COUNT(JOBNO) AS 'CNT31' FROM [dbo].[VEHICLETRANSPORTPLAN]
                          WHERE CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'31/".$_GET['datestart']."',103)
                          AND COMPANYCODE  ='".$_GET['companycode']."' 
                          AND (EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                          AND DOCUMENTCODE IS NOT NULL AND DOCUMENTCODE !=''";
          $query_sePlan31  = sqlsrv_query($conn, $sql_sePlan31, $params_sePlan31);
          $result_sePlan31 = sqlsrv_fetch_array($query_sePlan31, SQLSRV_FETCH_ASSOC);
          /////////////////////////////จำนวนรวมเที่ยวที่วิ่งงานของแต่ละพขร//////////////////////////////////////
          $SUMTRIP = $result_sePlan1['CNT1']+$result_sePlan2['CNT2']+$result_sePlan3['CNT3']+$result_sePlan4['CNT4']+$result_sePlan5['CNT5']
          +$result_sePlan6['CNT6']+$result_sePlan7['CNT7']+$result_sePlan8['CNT8']+$result_sePlan9['CNT9']+$result_sePlan10['CNT10']
          +$result_sePlan11['CNT11']+$result_sePlan12['CNT12']+$result_sePlan13['CNT13']+$result_sePlan14['CNT14']+$result_sePlan15['CNT15']
          +$result_sePlan16['CNT16']+$result_sePlan17['CNT17']+$result_sePlan18['CNT18']+$result_sePlan19['CNT19']+$result_sePlan20['CNT20']
          +$result_sePlan21['CNT21']+$result_sePlan22['CNT22']+$result_sePlan23['CNT23']+$result_sePlan24['CNT24']+$result_sePlan25['CNT25']
          +$result_sePlan26['CNT26']+$result_sePlan27['CNT27']+$result_sePlan28['CNT28']+$result_sePlan29['CNT29']+$result_sePlan30['CNT30']
          +$result_sePlan31['CNT31'];

          /////////////////////////////////////////////////////////////////////
        ////////////////////////////(ค่าเที่ยวในแต่ละวัน)/////////////////////////

        // $sql_seIncen1 = "SELECT ( SELECT COALESCE(SUM(CONVERT(INT,COMPENSATION1)),0) FROM(
        //           (SELECT  a.VEHICLETRANSPORTPLANID, a.COMPENSATION1  FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
        //           INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
        //           WHERE b.COMPANYCODE  ='".$_GET['companycode']."' AND b.CUSTOMERCODE = '".$_GET['customercode']."'
        //           AND CONVERT(DATE,b.DATEDEALERIN) = CONVERT(DATE,'01/".$date."',103)
        //           AND a.COMPENSATION1 IS NOT NULL
        //           AND a.COMPENSATION1 !=''
        //           AND b.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."'
        //           GROUP BY a.VEHICLETRANSPORTPLANID,a.COMPENSATION1))a)
        //           +
        //           ( SELECT COALESCE(SUM(CONVERT(INT,COMPENSATION2)),0) FROM(
        //           (SELECT  a.VEHICLETRANSPORTPLANID, a.COMPENSATION2  FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
        //           INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
        //           WHERE b.COMPANYCODE  ='".$_GET['companycode']."' AND b.CUSTOMERCODE = '".$_GET['customercode']."'
        //           AND CONVERT(DATE,b.DATEDEALERIN) = CONVERT(DATE,'01/".$date."',103)
        //           AND a.COMPENSATION2 IS NOT NULL
        //           AND a.COMPENSATION2 !=''
        //           AND b.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."'
        //           GROUP BY a.VEHICLETRANSPORTPLANID,a.COMPENSATION2))a)
        //           AS 'SUMINCEN1'";
        // $query_seIncen1  = sqlsrv_query($conn, $sql_seIncen1, $params_seIncen1);
        // $result_seIncen1 = sqlsrv_fetch_array($query_seIncen1, SQLSRV_FETCH_ASSOC);

        //วันที่1
        $sql_seIncen1 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'01/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'01/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN1'";
        $query_seIncen1  = sqlsrv_query($conn, $sql_seIncen1, $params_seIncen1);
        $result_seIncen1 = sqlsrv_fetch_array($query_seIncen1, SQLSRV_FETCH_ASSOC);
        //วันที่2
        $sql_seIncen2 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'02/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'02/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN2'";
        $query_seIncen2  = sqlsrv_query($conn, $sql_seIncen2, $params_seIncen2);
        $result_seIncen2 = sqlsrv_fetch_array($query_seIncen2, SQLSRV_FETCH_ASSOC);
        //วันที่3
        $sql_seIncen3 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'03/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'03/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN3'";
        $query_seIncen3  = sqlsrv_query($conn, $sql_seIncen3, $params_seIncen3);
        $result_seIncen3 = sqlsrv_fetch_array($query_seIncen3, SQLSRV_FETCH_ASSOC);
        //วันที่4
        $sql_seIncen4 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'04/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'04/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN4'";
        $query_seIncen4  = sqlsrv_query($conn, $sql_seIncen4, $params_seIncen4);
        $result_seIncen4 = sqlsrv_fetch_array($query_seIncen4, SQLSRV_FETCH_ASSOC);
        //วันที่5
        $sql_seIncen5 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'05/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'05/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN5'";
        $query_seIncen5  = sqlsrv_query($conn, $sql_seIncen5, $params_seIncen5);
        $result_seIncen5 = sqlsrv_fetch_array($query_seIncen5, SQLSRV_FETCH_ASSOC);
        //วันที่6
        $sql_seIncen6 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'06/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'06/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN6'";
        $query_seIncen6  = sqlsrv_query($conn, $sql_seIncen6, $params_seIncen6);
        $result_seIncen6 = sqlsrv_fetch_array($query_seIncen6, SQLSRV_FETCH_ASSOC);
        //วันที่7
        $sql_seIncen7 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'07/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'07/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN7'";
        $query_seIncen7  = sqlsrv_query($conn, $sql_seIncen7, $params_seIncen7);
        $result_seIncen7 = sqlsrv_fetch_array($query_seIncen7, SQLSRV_FETCH_ASSOC);
        //วันที่8
        $sql_seIncen8 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'08/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'08/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN8'";
        $query_seIncen8  = sqlsrv_query($conn, $sql_seIncen8, $params_seIncen8);
        $result_seIncen8 = sqlsrv_fetch_array($query_seIncen8, SQLSRV_FETCH_ASSOC);
        //วันที่9
        $sql_seIncen9 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'09/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'09/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN9'";
        $query_seIncen9  = sqlsrv_query($conn, $sql_seIncen9, $params_seIncen9);
        $result_seIncen9 = sqlsrv_fetch_array($query_seIncen9, SQLSRV_FETCH_ASSOC);
        //วันที่10
        $sql_seIncen10 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'10/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'10/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN10'";
        $query_seIncen10  = sqlsrv_query($conn, $sql_seIncen10, $params_seIncen10);
        $result_seIncen10 = sqlsrv_fetch_array($query_seIncen10, SQLSRV_FETCH_ASSOC);
        //วันที่11
        $sql_seIncen11 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'11/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'11/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN11'";
        $query_seIncen11  = sqlsrv_query($conn, $sql_seIncen11, $params_seIncen11);
        $result_seIncen11 = sqlsrv_fetch_array($query_seIncen11, SQLSRV_FETCH_ASSOC);
        //วันที่12
        $sql_seIncen12 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'12/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'12/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN12'";
        $query_seIncen12  = sqlsrv_query($conn, $sql_seIncen12, $params_seIncen12);
        $result_seIncen12 = sqlsrv_fetch_array($query_seIncen12, SQLSRV_FETCH_ASSOC);
        //วันที่13
        $sql_seIncen13 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'13/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'13/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN13'";
        $query_seIncen13  = sqlsrv_query($conn, $sql_seIncen13, $params_seIncen13);
        $result_seIncen13 = sqlsrv_fetch_array($query_seIncen13, SQLSRV_FETCH_ASSOC);
        //วันที่14
        $sql_seIncen14 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'14/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'14/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN14'";
        $query_seIncen14  = sqlsrv_query($conn, $sql_seIncen14, $params_seIncen14);
        $result_seIncen14 = sqlsrv_fetch_array($query_seIncen14, SQLSRV_FETCH_ASSOC);
        //วันที่14
        $sql_seIncen15 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'15/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'15/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN15'";
        $query_seIncen15  = sqlsrv_query($conn, $sql_seIncen15, $params_seIncen15);
        $result_seIncen15 = sqlsrv_fetch_array($query_seIncen15, SQLSRV_FETCH_ASSOC);
        //วันที่16
        $sql_seIncen16 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'16/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'16/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN16'";
        $query_seIncen16  = sqlsrv_query($conn, $sql_seIncen16, $params_seIncen16);
        $result_seIncen16 = sqlsrv_fetch_array($query_seIncen16, SQLSRV_FETCH_ASSOC);
        //วันที่17
        $sql_seIncen17 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'17/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'17/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN17'";
        $query_seIncen17  = sqlsrv_query($conn, $sql_seIncen17, $params_seIncen17);
        $result_seIncen17 = sqlsrv_fetch_array($query_seIncen17, SQLSRV_FETCH_ASSOC);
        //วันที่18
        $sql_seIncen18 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'18/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'18/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN18'";
        $query_seIncen18  = sqlsrv_query($conn, $sql_seIncen18, $params_seIncen18);
        $result_seIncen18 = sqlsrv_fetch_array($query_seIncen18, SQLSRV_FETCH_ASSOC);
        //วันที่19
        $sql_seIncen19 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'19/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'19/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN19'";
        $query_seIncen19  = sqlsrv_query($conn, $sql_seIncen19, $params_seIncen19);
        $result_seIncen19 = sqlsrv_fetch_array($query_seIncen19, SQLSRV_FETCH_ASSOC);
        //วันที่20
        $sql_seIncen20 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'20/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'20/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN20'";
        $query_seIncen20  = sqlsrv_query($conn, $sql_seIncen20, $params_seIncen20);
        $result_seIncen20 = sqlsrv_fetch_array($query_seIncen20, SQLSRV_FETCH_ASSOC);
        //วันที่21
        $sql_seIncen21 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'21/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'21/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN21'";
        $query_seIncen21  = sqlsrv_query($conn, $sql_seIncen21, $params_seIncen21);
        $result_seIncen21 = sqlsrv_fetch_array($query_seIncen21, SQLSRV_FETCH_ASSOC);
        //วันที่22
        $sql_seIncen22 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'22/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'22/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN22'";
        $query_seIncen22  = sqlsrv_query($conn, $sql_seIncen22, $params_seIncen22);
        $result_seIncen22 = sqlsrv_fetch_array($query_seIncen22, SQLSRV_FETCH_ASSOC);
        //วันที่23
        $sql_seIncen23 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'23/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'23/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN23'";
        $query_seIncen23  = sqlsrv_query($conn, $sql_seIncen23, $params_seIncen23);
        $result_seIncen23 = sqlsrv_fetch_array($query_seIncen23, SQLSRV_FETCH_ASSOC);
        //วันที่24
        $sql_seIncen24 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'24/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'24/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN24'";
        $query_seIncen24  = sqlsrv_query($conn, $sql_seIncen24, $params_seIncen24);
        $result_seIncen24 = sqlsrv_fetch_array($query_seIncen24, SQLSRV_FETCH_ASSOC);
        //วันที่25
        $sql_seIncen25 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'25/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'25/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN25'";
        $query_seIncen25  = sqlsrv_query($conn, $sql_seIncen25, $params_seIncen25);
        $result_seIncen25 = sqlsrv_fetch_array($query_seIncen25, SQLSRV_FETCH_ASSOC);
        //วันที่26
        $sql_seIncen26 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'26/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'26/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN26'";
        $query_seIncen26  = sqlsrv_query($conn, $sql_seIncen26, $params_seIncen26);
        $result_seIncen26 = sqlsrv_fetch_array($query_seIncen26, SQLSRV_FETCH_ASSOC);
        //วันที่27
        $sql_seIncen27 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'27/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'27/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN27'";
        $query_seIncen27  = sqlsrv_query($conn, $sql_seIncen27, $params_seIncen27);
        $result_seIncen27 = sqlsrv_fetch_array($query_seIncen27, SQLSRV_FETCH_ASSOC);
        //วันที่28
        $sql_seIncen28 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'28/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'28/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN28'";
        $query_seIncen28  = sqlsrv_query($conn, $sql_seIncen28, $params_seIncen28);
        $result_seIncen28 = sqlsrv_fetch_array($query_seIncen28, SQLSRV_FETCH_ASSOC);
        //วันที่29
        $sql_seIncen29 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'29/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'29/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN29'";
        $query_seIncen29  = sqlsrv_query($conn, $sql_seIncen29, $params_seIncen29);
        $result_seIncen29 = sqlsrv_fetch_array($query_seIncen29, SQLSRV_FETCH_ASSOC);
        //วันที่30
        $sql_seIncen30 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'30/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'30/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN30'";
        $query_seIncen30  = sqlsrv_query($conn, $sql_seIncen30, $params_seIncen30);
        $result_seIncen30 = sqlsrv_fetch_array($query_seIncen30, SQLSRV_FETCH_ASSOC);
        //วันที่31
        $sql_seIncen31 = "SELECT (SELECT   COALESCE(SUM(CONVERT(INT,E1)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'31/".$_GET['datestart']."',103)
                      AND E1 IS NOT NULL
                      AND E1 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."')
                      +
                      (SELECT   COALESCE(SUM(CONVERT(INT,E2)),0)   FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='".$_GET['companycode']."' 
                      AND CONVERT(DATE,DATEDEALERIN) = CONVERT(DATE,'31/".$_GET['datestart']."',103)
                      AND E2 IS NOT NULL
                      AND E2 !=''
                      AND DOCUMENTCODE IS NOT NULL
                      AND DOCUMENTCODE !=''
                      AND EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')
                      AS 'SUMINCEN31'";
        $query_seIncen31  = sqlsrv_query($conn, $sql_seIncen31, $params_seIncen31);
        $result_seIncen31 = sqlsrv_fetch_array($query_seIncen31, SQLSRV_FETCH_ASSOC);
        /////////////////////////////จำนวนรวมค่าเที่ยวที่วิ่งงานของแต่ละพขร//////////////////////////////////////
        $SUMINCEN = $result_seIncen1['SUMINCEN1']+$result_seIncen2['SUMINCEN2']+$result_seIncen3['SUMINCEN3']+$result_seIncen4['SUMINCEN4']+$result_seIncen5['SUMINCEN5']
        +$result_seIncen6['SUMINCEN6']+$result_seIncen7['SUMINCEN7']+$result_seIncen8['SUMINCEN8']+$result_seIncen9['SUMINCEN9']+$result_seIncen10['SUMINCEN10']
        +$result_seIncen11['SUMINCEN11']+$result_seIncen12['SUMINCEN12']+$result_seIncen13['SUMINCEN13']+$result_seIncen14['SUMINCEN14']+$result_seIncen15['SUMINCEN15']
        +$result_seIncen16['SUMINCEN16']+$result_seIncen17['SUMINCEN17']+$result_seIncen18['SUMINCEN18']+$result_seIncen19['SUMINCEN19']+$result_seIncen20['SUMINCEN20']
        +$result_seIncen21['SUMINCEN21']+$result_seIncen22['SUMINCEN22']+$result_seIncen23['SUMINCEN23']+$result_seIncen24['SUMINCEN24']+$result_seIncen25['SUMINCEN25']
        +$result_seIncen26['SUMINCEN26']+$result_seIncen27['SUMINCEN27']+$result_seIncen28['SUMINCEN28']+$result_seIncen29['SUMINCEN29']+$result_seIncen30['SUMINCEN30']
        +$result_seIncen31['SUMINCEN31'];

        /////////////////////////////////////////////////////////////////////


        //////////////////////////////////POSITION/////////////////////////////////

        $sql_sePosId = "SELECT PositionID AS 'POSID'  FROM EMPLOYEEEHR2 WHERE PersonCode = '" . $result_sePlan['EMPLOYEECODE'] . "'";
        $query_sePosId = sqlsrv_query($conn, $sql_sePosId, $params_sePosId);
        $result_sePosId = sqlsrv_fetch_array($query_sePosId, SQLSRV_FETCH_ASSOC);

        $sql_sePosName = "SELECT PositionNameT AS 'POSNAME'  FROM EMPLOYEEEHR2 WHERE PositionID ='" . $result_sePosId ['POSID']. "'";
        $query_sePosName = sqlsrv_query($conn, $sql_sePosName, $params_sePosName);
        $result_sePosName = sqlsrv_fetch_array($query_sePosName, SQLSRV_FETCH_ASSOC);

         ?>

      <tr style="border:1px solid #000;" >
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $i ?></td>
              <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePosName['POSNAME'] ?></td>
              <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
              <td colspan="3" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEENAME'] ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan1['CNT1']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen1['SUMINCEN1']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan2['CNT2']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen2['SUMINCEN2']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan3['CNT3']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen3['SUMINCEN3']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan4['CNT4']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen4['SUMINCEN4']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan5['CNT5']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen5['SUMINCEN5']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan6['CNT6']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen6['SUMINCEN6']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan7['CNT7']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen7['SUMINCEN7']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan8['CNT8']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen8['SUMINCEN8']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan9['CNT9']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen9['SUMINCEN9']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan10['CNT10']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen10['SUMINCEN10']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan11['CNT11']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen11['SUMINCEN11']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan12['CNT12']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen12['SUMINCEN12']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan13['CNT13']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen13['SUMINCEN13']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan14['CNT14']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen14['SUMINCEN14']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan15['CNT15']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen15['SUMINCEN15']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan16['CNT16']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen16['SUMINCEN16']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan17['CNT17']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen17['SUMINCEN17']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan18['CNT18']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen18['SUMINCEN18']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan19['CNT19']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen19['SUMINCEN19']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan20['CNT20']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen20['SUMINCEN20']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan21['CNT21']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen21['SUMINCEN21']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan22['CNT22']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen22['SUMINCEN22']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan23['CNT23']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen23['SUMINCEN23']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan24['CNT24']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen24['SUMINCEN24']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan25['CNT25']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen25['SUMINCEN25']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan26['CNT26']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen26['SUMINCEN26']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan27['CNT27']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen27['SUMINCEN27']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan28['CNT28']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen28['SUMINCEN28']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan29['CNT29']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen29['SUMINCEN29']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan30['CNT30']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen30['SUMINCEN30']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePlan31['CNT31']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_seIncen31['SUMINCEN31']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$SUMTRIP?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=number_format($SUMINCEN)?></td>

      </tr>
      <?php

      $i++;
      ///SUM TRIP ในแต่ละวัน
      $SUMTRIP1 = $SUMTRIP1+$result_sePlan1['CNT1'];  $SUMTRIP2 = $SUMTRIP2+$result_sePlan2['CNT2']; $SUMTRIP3 = $SUMTRIP3+$result_sePlan3['CNT3'];  $SUMTRIP4 = $SUMTRIP4+$result_sePlan4['CNT4'];
      $SUMTRIP5 = $SUMTRIP5+$result_sePlan5['CNT5'];  $SUMTRIP6 = $SUMTRIP6+$result_sePlan6['CNT6']; $SUMTRIP7 = $SUMTRIP7+$result_sePlan7['CNT7'];  $SUMTRIP8 = $SUMTRIP8+$result_sePlan8['CNT8'];
      $SUMTRIP9 = $SUMTRIP9+$result_sePlan9['CNT9'];  $SUMTRIP10 = $SUMTRIP10+$result_sePlan10['CNT10']; $SUMTRIP11 = $SUMTRIP11+$result_sePlan11['CNT11'];  $SUMTRIP12 = $SUMTRIP12+$result_sePlan12['CNT12'];
      $SUMTRIP13 = $SUMTRIP13+$result_sePlan13['CNT13'];  $SUMTRIP14 = $SUMTRIP14+$result_sePlan14['CNT14']; $SUMTRIP15 = $SUMTRIP15+$result_sePlan15['CNT15'];  $SUMTRIP16 = $SUMTRIP16+$result_sePlan16['CNT16'];
      $SUMTRIP17 = $SUMTRIP17+$result_sePlan17['CNT17'];  $SUMTRIP18 = $SUMTRIP18+$result_sePlan18['CNT18']; $SUMTRIP19 = $SUMTRIP19+$result_sePlan19['CNT19'];  $SUMTRIP20 = $SUMTRIP20+$result_sePlan20['CNT20'];
      $SUMTRIP21 = $SUMTRIP21+$result_sePlan21['CNT21']; $SUMTRIP22 = $SUMTRIP22+$result_sePlan22['CNT22'];  $SUMTRIP23 = $SUMTRIP23+$result_sePlan23['CNT23'];  $SUMTRIP24 = $SUMTRIP24+$result_sePlan24['CNT24'];
      $SUMTRIP25 = $SUMTRIP25+$result_sePlan25['CNT25']; $SUMTRIP26 = $SUMTRIP26+$result_sePlan26['CNT26'];  $SUMTRIP27 = $SUMTRIP27+$result_sePlan27['CNT27'];  $SUMTRIP28 = $SUMTRIP28+$result_sePlan28['CNT28'];
      $SUMTRIP29 = $SUMTRIP29+$result_sePlan29['CNT29']; $SUMTRIP30 = $SUMTRIP30+$result_sePlan30['CNT30'];  $SUMTRIP31 = $SUMTRIP31+$result_sePlan31['CNT31'];
      ///SUM INCEN ในแต่ละวัน
      $SUMINCEN1 = $SUMINCEN1+$result_seIncen1['SUMINCEN1']; $SUMINCEN2 = $SUMINCEN2+$result_seIncen2['SUMINCEN2']; $SUMINCEN3 = $SUMINCEN3+$result_seIncen3['SUMINCEN3']; $SUMINCEN4 = $SUMINCEN4+$result_seIncen4['SUMINCEN4'];
      $SUMINCEN5 = $SUMINCEN5+$result_seIncen5['SUMINCEN5']; $SUMINCEN6 = $SUMINCEN6+$result_seIncen6['SUMINCEN6']; $SUMINCEN7 = $SUMINCEN7+$result_seIncen7['SUMINCEN7']; $SUMINCEN8 = $SUMINCEN8+$result_seIncen8['SUMINCEN8'];
      $SUMINCEN9 = $SUMINCEN9+$result_seIncen9['SUMINCEN9']; $SUMINCEN10 = $SUMINCEN10+$result_seIncen10['SUMINCEN10']; $SUMINCEN11 = $SUMINCEN11+$result_seIncen11['SUMINCEN11']; $SUMINCEN12 = $SUMINCEN12+$result_seIncen12['SUMINCEN12'];
      $SUMINCEN13 = $SUMINCEN13+$result_seIncen13['SUMINCEN13']; $SUMINCEN14 = $SUMINCEN14+$result_seIncen14['SUMINCEN14']; $SUMINCEN15 = $SUMINCEN15+$result_seIncen15['SUMINCEN15']; $SUMINCEN16 = $SUMINCEN16+$result_seIncen16['SUMINCEN16'];
      $SUMINCEN17 = $SUMINCEN17+$result_seIncen17['SUMINCEN17']; $SUMINCEN18 = $SUMINCEN18+$result_seIncen18['SUMINCEN18']; $SUMINCEN19 = $SUMINCEN19+$result_seIncen19['SUMINCEN19']; $SUMINCEN20 = $SUMINCEN20+$result_seIncen20['SUMINCEN20'];
      $SUMINCEN21 = $SUMINCEN21+$result_seIncen21['SUMINCEN21']; $SUMINCEN22 = $SUMINCEN22+$result_seIncen22['SUMINCEN22']; $SUMINCEN23 = $SUMINCEN23+$result_seIncen23['SUMINCEN23']; $SUMINCEN24 = $SUMINCEN24+$result_seIncen24['SUMINCEN24'];
      $SUMINCEN25 = $SUMINCEN25+$result_seIncen25['SUMINCEN25']; $SUMINCEN26 = $SUMINCEN26+$result_seIncen26['SUMINCEN26']; $SUMINCEN27 = $SUMINCEN27+$result_seIncen27['SUMINCEN27']; $SUMINCEN28 = $SUMINCEN28+$result_seIncen28['SUMINCEN28'];
      $SUMINCEN29 = $SUMINCEN29+$result_seIncen29['SUMINCEN29']; $SUMINCEN30 = $SUMINCEN30+$result_seIncen30['SUMINCEN30']; $SUMINCEN31 = $SUMINCEN31+$result_seIncen31['SUMINCEN31'];


      $ALLSUMTRIP = $ALLSUMTRIP+$SUMTRIP;
      $ALLSUMINCEN = $ALLSUMINCEN+$SUMINCEN;
      }



       ?>

  </tbody><tfoot>
       <tr style="border:1px solid #000;">
          <td colspan="8" style="border:1px solid #000;padding:3px;text-align:center;"><b><u>รวม<u><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP1?><b></td>
          <td style="border:1px solid #000;padding:4px;text-align:center;"><b><?=number_format($SUMINCEN1)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP2?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN2)?><b></td>
          <td style="border:1px solid #000;padding:4px;text-align:center;"><b><?=$SUMTRIP3?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN3)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP4?><b></td>
          <td style="border:1px solid #000;padding:4px;text-align:center;"><b><?=number_format($SUMINCEN4)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP5?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN5)?><b></td>
          <td style="border:1px solid #000;padding:4px;text-align:center;"><b><?=$SUMTRIP6?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN6)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP7?><b></td>
          <td style="border:1px solid #000;padding:4px;text-align:center;"><b><?=number_format($SUMINCEN7)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP8?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN8)?><b></td>
          <td style="border:1px solid #000;padding:4px;text-align:center;"><b><?=$SUMTRIP9?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN9)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP10?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN10)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP11?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN11)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP12?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN12)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP13?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN13)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP14?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN14)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP15?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN15)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP16?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN16)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP17?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN17)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP18?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN18)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP19?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN19)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP20?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN20)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP21?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN21)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP22?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN22)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP23?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN23)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP24?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN24)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP25?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN25)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP26?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN26)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP27?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN27)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP28?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN28)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP29?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN29)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP30?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN30)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMTRIP31?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN31)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($ALLSUMTRIP)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($ALLSUMINCEN)?><b></td>
      </tr>
      </tfoot>
  </table>


      <br><br><br><br>
      <table style="width: 50%;border:1px solid #000">
    <tbody>
        <tr style="border:1px solid #000;">

            <td style="border:1px solid #000;padding:3px;text-align:center;width: 20%" >ผู้จัดทำ</td>
            <td style="border:1px solid #000;padding:3px;text-align:center;width: 20%" >ผู้ตรวจสอบ</td>
            <td style="border:1px solid #000;padding:3px;text-align:center;width: 20%" >ผู้ตรวจสอบ</td>
            <td style="border:1px solid #000;padding:3px;text-align:center;width: 20%" >ผู้ตรวจสอบ</td>
            <td style="border:1px solid #000;padding:3px;text-align:center;width: 20%" >ผู้อนุมัติ</td>
        </tr>
        <tr style="border:1px solid #000;">
            <td style="border:1px solid #000;padding:3px;text-align:center;width: 20%" ><br><br><br><br><br></td>
            <td style="border:1px solid #000;padding:3px;text-align:center;width: 20%" ></td>
            <td style="border:1px solid #000;padding:3px;text-align:center;width: 20%" ></td>
            <td style="border:1px solid #000;padding:3px;text-align:center;width: 20%" ></td>
            <td style="border:1px solid #000;padding:3px;text-align:center;width: 20%" ></td>
        </tr>
        <tr style="border:1px solid #000;">
            <td style="border:1px solid #000;padding:3px;text-align:center;width: 20%" >แผนกคุณภาพและความปลอดภัย</td>
            <td style="border:1px solid #000;padding:3px;text-align:center;width: 20%" >แผนกคุณภาพและความปลอดภัย</td>
            <td style="border:1px solid #000;padding:3px;text-align:center;width: 20%" >แผนกการตลาดและวางแผน</td>
            <td style="border:1px solid #000;padding:3px;text-align:center;width: 20%" >Trainee for DGM</td>
            <td style="border:1px solid #000;padding:3px;text-align:center;width: 20%" >GM Transportation</td>
        </tr>
        <tr style="border:1px solid #000;">
            <td style="border:1px solid #000;padding:3px;text-align:center;width: 20%" >........../........../..........</td>
            <td style="border:1px solid #000;padding:3px;text-align:center;width: 20%" >........../........../..........</td>
            <td style="border:1px solid #000;padding:3px;text-align:center;width: 20%" >........../........../..........</td>
            <td style="border:1px solid #000;padding:3px;text-align:center;width: 20%" >........../........../..........</td>
            <td style="border:1px solid #000;padding:3px;text-align:center;width: 20%" >........../........../..........</td>
        </tr>

    </tbody></table>

</body>
</html>
