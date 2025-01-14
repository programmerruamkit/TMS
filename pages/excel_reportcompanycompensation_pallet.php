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


$strExcelFileName = "รายงานค่าเที่ยวพาเลทประจำเดือน".$_GET['datestart'] .".xls";

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


<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
  <table id="bg-table" width="150%" style="border-collapse: collapse;font-size:12;">

  <thead>
       <tr style="border:1px solid #000;" >
              <td colspan="60" style="border-right:1px solid #000;padding:3px;text-align:center;">
                  <b>สรุปค่าเที่ยวพาเลทบริษัท <?= $_GET['companycode'] ?> สายงาน <?= $_GET['customercode'] ?></b>
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
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //2 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //3 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //4 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //5 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //6 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //7 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //8 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //9 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //10 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //11 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //12 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //13 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //14 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //15 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //16 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //17 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //18 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //19 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //20 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //21 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //22 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //23 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //24 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //25 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //26 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //27 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //28 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //29 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //30 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //31 -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Incentive</b></td>
          <!-- //TOTAL -->
          <td style="border-right:1px solid #000;padding:3px;text-align:center;"><b>Pallet</b></td>
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
                            CONVERT(VARCHAR, (SELECT DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,CONVERT(DATE,'" . $_GET['dateend'] . "',103))+1,0))), 103) AS 'dateend'";

        $query_seGetdate = sqlsrv_query($conn, $sql_seGetdate, $params_seGetdate);
        $result_seGetdate = sqlsrv_fetch_array($query_seGetdate, SQLSRV_FETCH_ASSOC);

        $sql_sePlan = "SELECT *, ROW_NUMBER() OVER(ORDER BY EMPLOYEECODE) AS 'ROWNUM' FROM (
                            SELECT  DISTINCT b.EMPLOYEENAME1  AS 'EMPLOYEENAME',b.EMPLOYEECODE1 AS 'EMPLOYEECODE' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                            WHERE b.COMPANYCODE  ='" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "'
                            AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
                            AND b.EMPLOYEENAME1 IS NOT NULL
                            AND b.EMPLOYEECODE1  IS NOT NULL
                            AND b.EMPLOYEENAME1 != ''
                            AND b.EMPLOYEECODE1 != ''
                            UNION
                            SELECT  DISTINCT b.EMPLOYEENAME2 AS 'EMPLOYEENAME',b.EMPLOYEECODE2 AS 'EMPLOYEECODE' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                            WHERE b.COMPANYCODE  ='" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "'
                            AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
                            AND b.EMPLOYEENAME2 IS NOT NULL
                            AND b.EMPLOYEECODE2 IS NOT NULL
                            AND b.EMPLOYEENAME2 != ''
                            AND b.EMPLOYEECODE2 != ''
                            ) a
                      ORDER BY EMPLOYEECODE ASC";
        $query_sePlan = sqlsrv_query($conn, $sql_sePlan, $params_sePlan);
        while ($result_sePlan = sqlsrv_fetch_array($query_sePlan, SQLSRV_FETCH_ASSOC)) {

          ////////////////////////////(นับจำนวนเที่ยวในแต่ละวัน)////////////////////////////////
          //วันที่1
          $sql_sePallet1 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET1' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'01/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet1  = sqlsrv_query($conn, $sql_sePallet1, $params_sePallet1);
          $result_sePallet1 = sqlsrv_fetch_array($query_sePallet1, SQLSRV_FETCH_ASSOC);
          //วันที่2
          $sql_sePallet2 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET2' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'02/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet2  = sqlsrv_query($conn, $sql_sePallet2, $params_sePallet2);
          $result_sePallet2 = sqlsrv_fetch_array($query_sePallet2, SQLSRV_FETCH_ASSOC);
          //วันที3
          $sql_sePallet3 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET3' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'03/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet3  = sqlsrv_query($conn, $sql_sePallet3, $params_sePallet3);
          $result_sePallet3 = sqlsrv_fetch_array($query_sePallet3, SQLSRV_FETCH_ASSOC);
          //วันที4
          $sql_sePallet4 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET4' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'04/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet4  = sqlsrv_query($conn, $sql_sePallet4, $params_sePallet4);
          $result_sePallet4 = sqlsrv_fetch_array($query_sePallet4, SQLSRV_FETCH_ASSOC);
          //วันที่5
          $sql_sePallet5 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET5' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'05/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet5  = sqlsrv_query($conn, $sql_sePallet5, $params_sePallet5);
          $result_sePallet5 = sqlsrv_fetch_array($query_sePallet5, SQLSRV_FETCH_ASSOC);
          //วันที่6
          $sql_sePallet6 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET6' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'06/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet6  = sqlsrv_query($conn, $sql_sePallet6, $params_sePallet6);
          $result_sePallet6 = sqlsrv_fetch_array($query_sePallet6, SQLSRV_FETCH_ASSOC);
          //วันที่1
          $sql_sePallet7 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET7' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'07/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet7  = sqlsrv_query($conn, $sql_sePallet7, $params_sePallet7);
          $result_sePallet7 = sqlsrv_fetch_array($query_sePallet7, SQLSRV_FETCH_ASSOC);
          //วันที่8
          $sql_sePallet8 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET8' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'08/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet8  = sqlsrv_query($conn, $sql_sePallet8, $params_sePallet8);
          $result_sePallet8 = sqlsrv_fetch_array($query_sePallet8, SQLSRV_FETCH_ASSOC);
          //วันที่9
          $sql_sePallet9 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET1' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'09/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet9  = sqlsrv_query($conn, $sql_sePallet9, $params_sePallet9);
          $result_sePallet9 = sqlsrv_fetch_array($query_sePallet9, SQLSRV_FETCH_ASSOC);
          //วันที่10
          $sql_sePallet10  = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET10' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'10/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet10  = sqlsrv_query($conn, $sql_sePallet10, $params_sePallet10);
          $result_sePallet10 = sqlsrv_fetch_array($query_sePallet10, SQLSRV_FETCH_ASSOC);
          //วันที่11
          $sql_sePallet11 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET11' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'11/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet11  = sqlsrv_query($conn, $sql_sePallet11, $params_sePallet11);
          $result_sePallet11 = sqlsrv_fetch_array($query_sePallet11, SQLSRV_FETCH_ASSOC);
          //วันที่10
          $sql_sePallet12 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET12' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'12/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet12  = sqlsrv_query($conn, $sql_sePallet12, $params_sePallet12);
          $result_sePallet12 = sqlsrv_fetch_array($query_sePallet12, SQLSRV_FETCH_ASSOC);
          //วันที่13
          $sql_sePallet13 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET13' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'13/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet13  = sqlsrv_query($conn, $sql_sePallet13, $params_sePallet13);
          $result_sePallet13 = sqlsrv_fetch_array($query_sePallet13, SQLSRV_FETCH_ASSOC);
          //วันที่14
          $sql_sePallet14 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET14' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'14/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet14  = sqlsrv_query($conn, $sql_sePallet14, $params_sePallet14);
          $result_sePallet14 = sqlsrv_fetch_array($query_sePallet14, SQLSRV_FETCH_ASSOC);
          //วันที่15
          $sql_sePallet15 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET15' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'15/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet15  = sqlsrv_query($conn, $sql_sePallet15, $params_sePallet15);
          $result_sePallet15 = sqlsrv_fetch_array($query_sePallet15, SQLSRV_FETCH_ASSOC);
          //วันที่16
          $sql_sePallet16 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET16' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'16/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet16  = sqlsrv_query($conn, $sql_sePallet16, $params_sePallet16);
          $result_sePallet1 = sqlsrv_fetch_array($query_sePallet16, SQLSRV_FETCH_ASSOC);
          //วันที่17
          $sql_sePallet17 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET17' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'17/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet17  = sqlsrv_query($conn, $sql_sePallet17, $params_sePallet17);
          $result_sePallet17 = sqlsrv_fetch_array($query_sePallet17, SQLSRV_FETCH_ASSOC);
          //วันที่18
          $sql_sePallet18 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET18' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'18/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet18  = sqlsrv_query($conn, $sql_sePallet18, $params_sePallet18);
          $result_sePallet18 = sqlsrv_fetch_array($query_sePallet18, SQLSRV_FETCH_ASSOC);
          //วันที่19
          $sql_sePallet19 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET19' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'19/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet19  = sqlsrv_query($conn, $sql_sePallet19, $params_sePallet19);
          $result_sePallet19 = sqlsrv_fetch_array($query_sePallet19, SQLSRV_FETCH_ASSOC);
          //วันที่20
          $sql_sePallet20 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET20' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'20/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet20  = sqlsrv_query($conn, $sql_sePallet20, $params_sePallet20);
          $result_sePallet20 = sqlsrv_fetch_array($query_sePallet20, SQLSRV_FETCH_ASSOC);
          //วันที่21
          $sql_sePallet21 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET21' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'21/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet21  = sqlsrv_query($conn, $sql_sePallet21, $params_sePallet21);
          $result_sePallet21 = sqlsrv_fetch_array($query_sePallet21, SQLSRV_FETCH_ASSOC);
          //วันที่22
          $sql_sePallet22 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET22' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'22/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet22  = sqlsrv_query($conn, $sql_sePallet22, $params_sePallet22);
          $result_sePallet22 = sqlsrv_fetch_array($query_sePallet22, SQLSRV_FETCH_ASSOC);
          //วันที่23
          $sql_sePallet23 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET23' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'23/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet23  = sqlsrv_query($conn, $sql_sePallet23, $params_sePallet23);
          $result_sePallet23 = sqlsrv_fetch_array($query_sePallet23, SQLSRV_FETCH_ASSOC);
          //วันที่24
          $sql_sePallet24 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET24' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'24/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet24  = sqlsrv_query($conn, $sql_sePallet24, $params_sePallet24);
          $result_sePallet24 = sqlsrv_fetch_array($query_sePallet24, SQLSRV_FETCH_ASSOC);
          //วันที่25
          $sql_sePallet25 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET25' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'25/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet25  = sqlsrv_query($conn, $sql_sePallet25, $params_sePallet25);
          $result_sePallet25 = sqlsrv_fetch_array($query_sePallet25, SQLSRV_FETCH_ASSOC);
          //วันที่26
          $sql_sePallet26 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET26' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'26/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet26  = sqlsrv_query($conn, $sql_sePallet26, $params_sePallet26);
          $result_sePallet26 = sqlsrv_fetch_array($query_sePallet26, SQLSRV_FETCH_ASSOC);
          //วันที่27
          $sql_sePallet27 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET1' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'27/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet27  = sqlsrv_query($conn, $sql_sePallet27, $params_sePallet27);
          $result_sePallet27 = sqlsrv_fetch_array($query_sePallet27, SQLSRV_FETCH_ASSOC);
          //วันที่28
          $sql_sePallet28 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET28' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'28/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet28  = sqlsrv_query($conn, $sql_sePallet28, $params_sePallet28);
          $result_sePallet28 = sqlsrv_fetch_array($query_sePallet28, SQLSRV_FETCH_ASSOC);
          //วันที่29
          $sql_sePallet29 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET29' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'29/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet29  = sqlsrv_query($conn, $sql_sePallet29, $params_sePallet29);
          $result_sePallet29 = sqlsrv_fetch_array($query_sePallet29, SQLSRV_FETCH_ASSOC);
          //วันที่30
          $sql_sePallet30 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET30' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'30/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet30  = sqlsrv_query($conn, $sql_sePallet30, $params_sePallet30);
          $result_sePallet30 = sqlsrv_fetch_array($query_sePallet30, SQLSRV_FETCH_ASSOC);
          //วันที่31
          $sql_sePallet31 = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT_PALLET)) AS 'CNTPALLET31' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                        WHERE  CONVERT(DATE,b.DATEWORKING) = CONVERT(DATE,'31/".$date."',103)
                        AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                        AND a.DOCUMENTCODE_PALLET IS NOT NULL
                        AND a.DOCUMENTCODE_PALLET != ''
                        AND (a.EMPLOYEECODE1 ='".$result_sePlan['EMPLOYEECODE']."' OR  a.EMPLOYEECODE2 ='".$result_sePlan['EMPLOYEECODE']."')";
          $query_sePallet31  = sqlsrv_query($conn, $sql_sePallet31, $params_sePallet31);
          $result_sePallet31 = sqlsrv_fetch_array($query_sePallet31, SQLSRV_FETCH_ASSOC);

          /////////////////////////////จำนวนรวมเที่ยวที่วิ่งงานของแต่ละพขร//////////////
          $SUMPALLET = $result_sePallet1['CNTPALLET1']+$result_sePallet2['CNTPALLET2']+$result_sePallet3['CNTPALLET3']+$result_sePallet4['CNTPALLET4']
          +$result_sePallet5['CNTPALLET5']+$result_sePallet6['CNTPALLET6']+$result_sePallet7['CNTPALLET7']+$result_sePallet8['CNTPALLET8']
          +$result_sePallet9['CNTPALLET9']+$result_sePallet10['CNTPALLET10']+$result_sePallet11['CNTPALLET11']+$result_sePallet12['CNTPALLET12']
          +$result_sePallet13['CNTPALLET13']+$result_sePallet14['CNTPALLET14']+$result_sePallet15['CNTPALLET15']+$result_sePallet16['CNTPALLET16']
          +$result_sePallet17['CNTPALLET17']+$result_sePallet18['CNTPALLET18']+$result_sePallet19['CNTPALLET19']+$result_sePallet20['CNTPALLET20']
          +$result_sePallet20['CNTPALLET20']+$result_sePallet21['CNTPALLET21']+$result_sePallet22['CNTPALLET22']+$result_sePallet23['CNTPALLET23']
          +$result_sePallet24['CNTPALLET24']+$result_sePallet25['CNTPALLET25']+$result_sePallet26['CNTPALLET26']+$result_sePallet27['CNTPALLET27']
          +$result_sePallet28['CNTPALLET28']+$result_sePallet29['CNTPALLET29']+$result_sePallet30['CNTPALLET30']+$result_sePallet31['CNTPALLET31'];

          /////////////////////////////////////////////////////////////////////
        ////////////////////////////(ค่าเที่ยวในแต่ละวัน)/////////////////////////
        $INCEN1 = ($result_sePallet1['CNTPALLET1'] * 5); $INCEN2 = ($result_sePallet2['CNTPALLET2'] * 5); $INCEN3 = ($result_sePallet3['CNTPALLET3'] * 5);
        $INCEN4 = ($result_sePallet4['CNTPALLET4'] * 5); $INCEN5 = ($result_sePallet5['CNTPALLET5'] * 5); $INCEN6 = ($result_sePallet6['CNTPALLET6'] * 5);
        $INCEN7 = ($result_sePallet7['CNTPALLET7'] * 5); $INCEN7 = ($result_sePallet7['CNTPALLET7'] * 5); $INCEN8 = ($result_sePallet8['CNTPALLET8'] * 5);
        $INCEN9 = ($result_sePallet9['CNTPALLET9'] * 5); $INCEN10 = ($result_sePallet10['CNTPALLET10'] * 5); $INCEN11 = ($result_sePallet11['CNTPALLET11'] * 5);
        $INCEN12 = ($result_sePallet12['CNTPALLET12'] * 5); $INCEN13 = ($result_sePallet13['CNTPALLET13'] * 5); $INCEN14 = ($result_sePallet14['CNTPALLET14'] * 5);
        $INCEN13 = ($result_sePallet13['CNTPALLET13'] * 5); $INCEN14 = ($result_sePallet14['CNTPALLET14'] * 5); $INCEN15 = ($result_sePallet15['CNTPALLET15'] * 5);
        $INCEN16 = ($result_sePallet16['CNTPALLET16'] * 5); $INCEN17 = ($result_sePallet17['CNTPALLET17'] * 5); $INCEN18 = ($result_sePallet18['CNTPALLET18'] * 5);
        $INCEN19 = ($result_sePallet19['CNTPALLET19'] * 5); $INCEN20 = ($result_sePallet20['CNTPALLET20'] * 5); $INCEN21 = ($result_sePallet21['CNTPALLET21'] * 5);
        $INCEN22 = ($result_sePallet22['CNTPALLET22'] * 5); $INCEN23 = ($result_sePallet23['CNTPALLET23'] * 5); $INCEN24 = ($result_sePallet24['CNTPALLET24'] * 5);
        $INCEN25 = ($result_sePallet25['CNTPALLET25'] * 5); $INCEN26 = ($result_sePallet26['CNTPALLET26'] * 5); $INCEN27 = ($result_sePallet27['CNTPALLET27'] * 5);
        $INCEN28 = ($result_sePallet28['CNTPALLET28'] * 5); $INCEN29 = ($result_sePallet29['CNTPALLET29'] * 5); $INCEN30 = ($result_sePallet30['CNTPALLET30'] * 5);
        $INCEN31 = ($result_sePallet31['CNTPALLET31'] * 5);

        ///////////////////////////////จำนวนรวมเงินรวมที่จ่าย///////////////////////////
        $SUMINCEN = $INCEN1+$INCEN2+$INCEN3+$INCEN4+$INCEN5+$INCEN6+$INCEN7+$INCEN8+$INCEN9+$INCEN10
        +$INCEN11+$INCEN12+$INCEN13+$INCEN14+$INCEN15+$INCEN16+$INCEN17+$INCEN18+$INCEN19+$INCEN20
        +$INCEN21+$INCEN22+$INCEN23+$INCEN24+$INCEN25+$INCEN26+$INCEN27+$INCEN28+$INCEN29+$INCEN30
        +$INCEN31;
        ///////////////////////////////////////////////////////////////////////////

        //////////////////////////////////POSITION/////////////////////////////////

        $sql_sePosId = "SELECT PositionID AS 'POSID'  FROM EMPLOYEEEHR2 WHERE PersonCode = '" . $result_sePlan['EMPLOYEECODE'] . "'";
        $query_sePosId = sqlsrv_query($conn, $sql_sePosId, $params_sePosId);
        $result_sePosId = sqlsrv_fetch_array($query_sePosId, SQLSRV_FETCH_ASSOC);

        $sql_sePosName = "SELECT PositionNameT AS 'POSNAME'  EMPLOYEEEHR2 WHERE PositionID ='" . $result_sePosId ['POSID']. "'";
        $query_sePosName = sqlsrv_query($conn, $sql_sePosName, $params_sePosName);
        $result_sePosName = sqlsrv_fetch_array($query_sePosName, SQLSRV_FETCH_ASSOC);

         ?>

      <tr style="border:1px solid #000;" >
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $i ?></td>
              <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePosName['POSNAME'] ?></td>
              <td colspan="2" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEECODE'] ?></td>
              <td colspan="3" style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePlan['EMPLOYEENAME'] ?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet1['CNTPALLET1']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN1 == '0'?'':$INCEN1?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet2['CNTPALLET2']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN2 == '0'?'':$INCEN2?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet3['CNTPALLET3']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN3 == '0'?'':$INCEN3?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet4['CNTPALLET4']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN4 == '0'?'':$INCEN4?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet5['CNTPALLET5']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN5 == '0'?'':$INCEN5?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet6['CNTPALLET6']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN6 == '0'?'':$INCEN6?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet7['CNTPALLET7']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN7 == '0'?'':$INCEN7?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet8['CNTPALLET8']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN8 == '0'?'':$INCEN8?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet9['CNTPALLET9']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN9 == '0'?'':$INCEN9?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet10['CNTPALLET10']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN10 == '0'?'':$INCEN10?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet11['CNTPALLET11']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN11 == '0'?'':$INCEN11?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet12['CNTPALLET12']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN12 == '0'?'':$INCEN12?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet13['CNTPALLET13']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN13 == '0'?'':$INCEN13?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet14['CNTPALLET14']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN14 == '0'?'':$INCEN14?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet15['CNTPALLET15']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN15 == '0'?'':$INCEN15?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet16['CNTPALLET16']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN16 == '0'?'':$INCEN16?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet17['CNTPALLET17']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN17 == '0'?'':$INCEN17?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet18['CNTPALLET18']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN18 == '0'?'':$INCEN18?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet19['CNTPALLET19']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN19 == '0'?'':$INCEN19?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet20['CNTPALLET20']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN20 == '0'?'':$INCEN20?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet21['CNTPALLET21']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN21 == '0'?'':$INCEN21?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet22['CNTPALLET22']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN22 == '0'?'':$INCEN22?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet23['CNTPALLET23']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN23 == '0'?'':$INCEN23?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet24['CNTPALLET24']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN24 == '0'?'':$INCEN24?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet25['CNTPALLET25']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN25 == '0'?'':$INCEN25?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet26['CNTPALLET26']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN26 == '0'?'':$INCEN26?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet27['CNTPALLET27']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN27 == '0'?'':$INCEN27?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet28['CNTPALLET28']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN28 == '0'?'':$INCEN28?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet29['CNTPALLET29']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN29 == '0'?'':$INCEN29?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet30['CNTPALLET30']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN30 == '0'?'':$INCEN30?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$result_sePallet31['CNTPALLET31']?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=$INCEN31 == '0'?'':$INCEN31?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=number_format($SUMPALLET)?></td>
              <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?=number_format($SUMINCEN)?></td>

      </tr>
      <?php

      $i++;
      ///SUM TRIP ในแต่ละวัน
      $SUMPALLET1 = $SUMPALLET1+$result_sePallet1['CNTPALLET1']; $SUMPALLET2 = $SUMPALLET2+$result_sePallet2['CNTPALLET2']; $SUMPALLET3 = $SUMPALLET3+$result_sePallet3['CNTPALLET3'];
      $SUMPALLET4 = $SUMPALLET4+$result_sePallet4['CNTPALLET4']; $SUMPALLET5 = $SUMPALLET5+$result_sePallet5['CNTPALLET5']; $SUMPALLET6 = $SUMPALLET6+$result_sePallet6['CNTPALLET6'];
      $SUMPALLET7 = $SUMPALLET7+$result_sePallet7['CNTPALLET7']; $SUMPALLET8 = $SUMPALLET8+$result_sePallet8['CNTPALLET8']; $SUMPALLET9 = $SUMPALLET9+$result_sePallet9['CNTPALLET9'];
      $SUMPALLET10 = $SUMPALLET10+$result_sePallet10['CNTPALLET10']; $SUMPALLET11 = $SUMPALLET11+$result_sePallet11['CNTPALLET11']; $SUMPALLET12 = $SUMPALLET12+$result_sePallet12['CNTPALLET12'];
      $SUMPALLET13 = $SUMPALLET13+$result_sePallet13['CNTPALLET13']; $SUMPALLET14 = $SUMPALLET14+$result_sePallet14['CNTPALLET14']; $SUMPALLET15 = $SUMPALLET15+$result_sePallet15['CNTPALLET15'];
      $SUMPALLET16 = $SUMPALLET16+$result_sePallet16['CNTPALLET16']; $SUMPALLET16 = $SUMPALLET16+$result_sePallet16['CNTPALLET16']; $SUMPALLET17 = $SUMPALLET17+$result_sePallet17['CNTPALLET17'];
      $SUMPALLET17 = $SUMPALLET17+$result_sePallet17['CNTPALLET17']; $SUMPALLET18 = $SUMPALLET18+$result_sePallet18['CNTPALLET18']; $SUMPALLET19 = $SUMPALLET19+$result_sePallet19['CNTPALLET19'];
      $SUMPALLET20 = $SUMPALLET20+$result_sePallet20['CNTPALLET20']; $SUMPALLET21 = $SUMPALLET21+$result_sePallet21['CNTPALLET21']; $SUMPALLET22 = $SUMPALLET22+$result_sePallet22['CNTPALLET22'];
      $SUMPALLET23 = $SUMPALLET23+$result_sePallet23['CNTPALLET23']; $SUMPALLET24 = $SUMPALLET24+$result_sePallet24['CNTPALLET24']; $SUMPALLET25 = $SUMPALLET25+$result_sePallet25['CNTPALLET25'];
      $SUMPALLET26 = $SUMPALLET26+$result_sePallet26['CNTPALLET26']; $SUMPALLET27 = $SUMPALLET27+$result_sePallet27['CNTPALLET27']; $SUMPALLET28 = $SUMPALLET28+$result_sePallet28['CNTPALLET28'];
      $SUMPALLET29 = $SUMPALLET29+$result_sePallet29['CNTPALLET29']; $SUMPALLET30 = $SUMPALLET30+$result_sePallet30['CNTPALLET30']; $SUMPALLET31 = $SUMPALLET31+$result_sePallet31['CNTPALLET31'];



      ///SUM INCEN ในแต่ละวัน
      $SUMINCEN1 = $SUMINCEN1+$INCEN1; $SUMINCEN2 = $SUMINCEN2+$INCEN2; $SUMINCEN3 = $SUMINCEN3+$INCEN3; $SUMINCEN4 = $SUMINCEN4+$INCEN4;
      $SUMINCEN5 = $SUMINCEN5+$INCEN5; $SUMINCEN6 = $SUMINCEN6+$INCEN6; $SUMINCEN7 = $SUMINCEN7+$INCEN7; $SUMINCEN8 = $SUMINCEN8+$INCEN8;
      $SUMINCEN9 = $SUMINCEN9+$INCEN9; $SUMINCEN10 = $SUMINCEN10+$INCEN10; $SUMINCEN11 = $SUMINCEN11+$INCEN11; $SUMINCEN12 = $SUMINCEN12+$INCEN12;
      $SUMINCEN13 = $SUMINCEN13+$INCEN13; $SUMINCEN14 = $SUMINCEN14+$INCEN14; $SUMINCEN15 = $SUMINCEN15+$INCEN15; $SUMINCEN16 = $SUMINCEN16+$INCEN16;
      $SUMINCEN17 = $SUMINCEN17+$INCEN17; $SUMINCEN18 = $SUMINCEN18+$INCEN18; $SUMINCEN19 = $SUMINCEN19+$INCEN19; $SUMINCEN20 = $SUMINCEN20+$INCEN20;
      $SUMINCEN21 = $SUMINCEN21+$INCEN21; $SUMINCEN22 = $SUMINCEN22+$INCEN22; $SUMINCEN23 = $SUMINCEN23+$INCEN23; $SUMINCEN24 = $SUMINCEN24+$INCEN24;
      $SUMINCEN25 = $SUMINCEN25+$INCEN25; $SUMINCEN26 = $SUMINCEN26+$INCEN26; $SUMINCEN27 = $SUMINCEN27+$INCEN27; $SUMINCEN28 = $SUMINCEN28+$INCEN28;
      $SUMINCEN29 = $SUMINCEN29+$INCEN29; $SUMINCEN30 = $SUMINCEN30+$INCEN30; $SUMINCEN31 = $SUMINCEN31+$INCEN31;


      $ALLSUMPALLET = $ALLSUMPALLET+$SUMPALLET;
      $ALLSUMINCEN  = $ALLSUMINCEN+$SUMINCEN;

      }




       ?>

  </tbody><tfoot>
       <tr style="border:1px solid #000;">
          <td colspan="8" style="border:1px solid #000;padding:3px;text-align:center;"><b><u>รวม<u><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET1?><b></td>
          <td style="border:1px solid #000;padding:4px;text-align:center;"><b><?=number_format($SUMINCEN1)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET2?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN2)?><b></td>
          <td style="border:1px solid #000;padding:4px;text-align:center;"><b><?=$SUMPALLET3?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN3)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET4?><b></td>
          <td style="border:1px solid #000;padding:4px;text-align:center;"><b><?=number_format($SUMINCEN4)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET5?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN5)?><b></td>
          <td style="border:1px solid #000;padding:4px;text-align:center;"><b><?=$SUMPALLET6?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN6)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET7?><b></td>
          <td style="border:1px solid #000;padding:4px;text-align:center;"><b><?=number_format($SUMINCEN7)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET8?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN8)?><b></td>
          <td style="border:1px solid #000;padding:4px;text-align:center;"><b><?=$SUMPALLET9?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN9)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET10?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN10)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET11?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN11)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET12?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN12)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET13?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN13)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET14?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN14)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET15?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN15)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET16?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN16)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET17?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN17)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET18?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN18)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET19?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN19)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET20?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN20)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET21?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN21)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET22?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN22)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET23?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN23)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET24?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN24)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET25?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN25)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET26?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN26)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET27?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN27)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET28?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN28)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET29?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN29)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET30?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN30)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=$SUMPALLET31?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($SUMINCEN31)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($ALLSUMPALLET)?><b></td>
          <td style="border:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($ALLSUMINCEN)?><b></td>
      </tr>
      </tfoot>
  </table>


      <br><br><br><br>
      <table style="width: 100%;border:1px solid #000">
      <tbody>
      <tr style="border:1px solid #000;">

              <td style="border:1px solid #000;padding:3px;text-align:center;" colspan="5">ผู้จัดทำ</td>
              <td style="border:1px solid #000;padding:3px;text-align:center;" colspan="8">ผู้ตรวจสอบ</td>
              <td style="border:1px solid #000;padding:3px;text-align:center;" colspan="5">ผู้ตรวจสอบ</td>
              <td style="border:1px solid #000;padding:3px;text-align:center;" colspan="5">ผู้ตรวจสอบ</td>
              <td style="border:1px solid #000;padding:3px;text-align:center;" colspan="5">ผู้อนุมัติ</td>
              </tr>
              <tr style="border:1px solid #000;">
              <td style="border:1px solid #000;padding:3px;text-align:center;" colspan="5"><br><br><br><br><br></td>
              <td style="border:1px solid #000;padding:3px;text-align:center;" colspan="8"></td>
              <td style="border:1px solid #000;padding:3px;text-align:center;" colspan="5"></td>
              <td style="border:1px solid #000;padding:3px;text-align:center;" colspan="5"></td>
              <td style="border:1px solid #000;padding:3px;text-align:center;" colspan="5"></td>
              </tr>
              <tr style="border:1px solid #000;">
              <td style="border:1px solid #000;padding:3px;text-align:center;" colspan="5">แผนกคุณภาพและความปลอดภัย</td>
              <td style="border:1px solid #000;padding:3px;text-align:center;" colspan="8">แผนกคุณภาพและความปลอดภัย</td>
              <td style="border:1px solid #000;padding:3px;text-align:center;" colspan="5">แผนกการตลาดและวางแผน</td>
              <td style="border:1px solid #000;padding:3px;text-align:center;" colspan="5">Trainee for DGM</td>
              <td style="border:1px solid #000;padding:3px;text-align:center;" colspan="5">GM Transportation</td>
              </tr>
              <tr style="border:1px solid #000;">
              <td style="border:1px solid #000;padding:3px;text-align:center;" colspan="5">........../........../..........</td>
              <td style="border:1px solid #000;padding:3px;text-align:center;" colspan="8">........../........../..........</td>
              <td style="border:1px solid #000;padding:3px;text-align:center;" colspan="5">........../........../..........</td>
              <td style="border:1px solid #000;padding:3px;text-align:center;" colspan="5">........../........../..........</td>
              <td style="border:1px solid #000;padding:3px;text-align:center;" colspan="5">........../........../..........</td>
              </tr>

          </tbody></table>

</body>
</html>
