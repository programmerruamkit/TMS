<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
  array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);


$strExcelFileName = "TGT PRESENT".$result_getDate['SYSDATE'].".xls";
// //
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
  <br>
  <table>
    <th colspan="1" >Summary service result</th>
  </table>
  <br>
  <table   style="border-collapse: collapse;margin-top:8px;font-size:16px" width="100%"  >

    <tr>
      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:left"><b>Month</b></td>
      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Jan</b></td>
      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Feb</b></td>
      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Mar</b></td>
      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Apr</b></td>
      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>May</b></td>
      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Jun</b></td>
      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Jul</b></td>
      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Aug</b></td>
      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Sep</b></td>
      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Oct</b></td>
      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Nov</b></td>
      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Dec</b></td>
      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:center"><b>Total</b></td>
    </tr>

    <!-- /////////////////////////////////////PLAN//////////////////////////////////////////////// -->

    <tr style="border-collapse: collapse;margin-top:8px;font-size:16px" width="100%">
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><b>Plan (trip)</b></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
    </tr>

    <!-- /////////////////////////////////////ACTUAL////////////////////////////////////////// -->
    <?php
    $sql_monthJan = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
    WHERE  DATEPART(MONTH, DATEINPUT) IN ('1')
    AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
    $params_monthJan = array();
    $query_monthJan = sqlsrv_query($conn, $sql_monthJan, $params_monthJan);
    $result_monthJan = sqlsrv_fetch_array($query_monthJan, SQLSRV_FETCH_ASSOC);

    $sql_monthFeb = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
    WHERE  DATEPART(MONTH, DATEINPUT) IN ('2')
    AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
    $params_monthFeb = array();
    $query_monthFeb = sqlsrv_query($conn, $sql_monthFeb, $params_monthFeb);
    $result_monthFeb = sqlsrv_fetch_array($query_monthFeb, SQLSRV_FETCH_ASSOC);

    $sql_monthMar = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
    WHERE  DATEPART(MONTH, DATEINPUT) IN ('3')
    AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
    $params_monthMar = array();
    $query_monthMar  = sqlsrv_query($conn, $sql_monthMar, $params_monthMar);
    $result_monthMar  = sqlsrv_fetch_array($query_monthMar, SQLSRV_FETCH_ASSOC);

    $sql_monthApr = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
    WHERE  DATEPART(MONTH, DATEINPUT) IN ('4')
    AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
    $params_monthApr = array();
    $query_monthApr = sqlsrv_query($conn, $sql_monthApr, $params_monthApr);
    $result_monthApr = sqlsrv_fetch_array($query_monthApr, SQLSRV_FETCH_ASSOC);

    $sql_monthMay = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
    WHERE  DATEPART(MONTH, DATEINPUT) IN ('5')
    AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
    $params_monthMay = array();
    $query_monthMay = sqlsrv_query($conn, $sql_monthMay, $params_monthMay);
    $result_monthMay = sqlsrv_fetch_array($query_monthMay, SQLSRV_FETCH_ASSOC);

    $sql_monthJun = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
    WHERE  DATEPART(MONTH, DATEINPUT) IN ('6')
    AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
    $params_monthJun = array();
    $query_monthJun = sqlsrv_query($conn, $sql_monthJun, $params_monthJun);
    $result_monthJun = sqlsrv_fetch_array($query_monthJun, SQLSRV_FETCH_ASSOC);

    $sql_monthJul = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
    WHERE  DATEPART(MONTH, DATEINPUT) IN ('7')
    AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
    $params_monthJul= array();
    $query_monthJul = sqlsrv_query($conn, $sql_monthJul, $params_monthJul);
    $result_monthJul = sqlsrv_fetch_array($query_monthJul, SQLSRV_FETCH_ASSOC);

    $sql_monthAug = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
    WHERE  DATEPART(MONTH, DATEINPUT) IN ('8')
    AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
    $params_monthAug = array();
    $query_monthAug = sqlsrv_query($conn, $sql_monthAug, $params_monthAug);
    $result_monthAug = sqlsrv_fetch_array($query_monthAug, SQLSRV_FETCH_ASSOC);

    $sql_monthSep = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
    WHERE  DATEPART(MONTH, DATEINPUT) IN ('9')
    AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
    $params_monthSep = array();
    $query_monthSep = sqlsrv_query($conn, $sql_monthSep, $params_monthSep);
    $result_monthSep = sqlsrv_fetch_array($query_monthSep, SQLSRV_FETCH_ASSOC);

    $sql_monthOct = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
    WHERE  DATEPART(MONTH, DATEINPUT) IN ('10')
    AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
    $params_monthOct = array();
    $query_monthOct = sqlsrv_query($conn, $sql_monthOct, $params_monthOct);
    $result_monthOct = sqlsrv_fetch_array($query_monthOct, SQLSRV_FETCH_ASSOC);

    $sql_monthNov = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
    WHERE  DATEPART(MONTH, DATEINPUT) IN ('11')
    AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
    $params_monthNov = array();
    $query_monthNov = sqlsrv_query($conn, $sql_monthNov, $params_monthNov);
    $result_monthNov = sqlsrv_fetch_array($query_monthNov, SQLSRV_FETCH_ASSOC);

    $sql_monthDec = "SELECT DATEPART(MONTH, DATEINPUT) AS [MONTH],DATEPART(YEAR, DATEINPUT) AS [YEAR],CUSTOMERCODE,COUNT(*) AS [COUNT] FROM [dbo].[VEHICLETRANSPORTPLAN]
    WHERE  DATEPART(MONTH, DATEINPUT) IN ('12')
    AND COMPANYCODE='RKS' AND CUSTOMERCODE='TGT' AND DATEPART(YEAR, DATEINPUT)=CONVERT(VARCHAR(4),GETDATE(),112) GROUP BY DATEPART(MONTH, DATEINPUT),DATEPART(YEAR, DATEINPUT),CUSTOMERCODE ORDER BY [MONTH] ASC";
    $params_monthDec = array();
    $query_monthDec = sqlsrv_query($conn, $sql_monthDec, $params_monthDec);
    $result_monthDec = sqlsrv_fetch_array($query_monthDec, SQLSRV_FETCH_ASSOC);

    $sum = ($result_monthJan['COUNT']+$result_monthFeb['COUNT']+$result_monthMar['COUNT']+
    $result_monthApr['COUNT']+$result_monthMay['COUNT']+$result_monthJun['COUNT']+
    $result_monthJul['COUNT']+$result_monthAug['COUNT']+$result_monthSep['COUNT']+
    $result_monthOct['COUNT']+$result_monthNov['COUNT']+$result_monthDec['COUNT'])


      ?>

      <?php
       $sumtotal = str_replace('.00', '', number_format($sum, 2));
       ?>
    <tr style="border-collapse: collapse;margin-top:8px;font-size:16px" width="100%">
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><b>Actual (trip)</b></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthJan['COUNT']  == ''  ? '0' : $result_monthJan['COUNT'])?></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthFeb['COUNT']  == ''  ? '0' : $result_monthFeb['COUNT'])?></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthMar['COUNT']  == ''  ? '0' : $result_monthMar['COUNT'])?></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthApr['COUNT']  == ''  ? '0' : $result_monthApr['COUNT'])?></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthMay['COUNT']  == ''  ? '0' : $result_monthMay['COUNT'])?></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthJun['COUNT']  == ''  ? '0' : $result_monthJun['COUNT'])?></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthJul['COUNT']  == ''  ? '0' : $result_monthJul['COUNT'])?></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthAug['COUNT']  == ''  ? '0' : $result_monthAug['COUNT'])?></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthSep['COUNT']  == ''  ? '0' : $result_monthSep['COUNT'])?></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthOct['COUNT']  == ''  ? '0' : $result_monthOct['COUNT'])?></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthNov['COUNT']  == ''  ? '0' : $result_monthNov['COUNT'])?></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=($result_monthDec['COUNT']  == ''  ? '0' : $result_monthDec['COUNT'])?></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=$sumtotal?></td>
    </tr>

    <!-- ////////////////////////////////Target (100%)///////////////////////////////////////////////////// -->

    <tr style="border-collapse: collapse;margin-top:8px;font-size:16px" width="100%">
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><b>Target (100%)</b></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center">100%</td>
    </tr>

    <!-- ////////////////////////////////Result (%)///////////////////////////////////////////////////////// -->

    <tr style="border-collapse: collapse;margin-top:8px;font-size:16px" width="100%">
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><b>Result (%)</b></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
      <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"></td>
    </tr>

  </table>
</body>
</html>
