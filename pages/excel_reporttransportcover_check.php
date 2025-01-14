<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('display_errors', 0);
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานแผนการขนส่ง.xls";
} else {
    $strExcelFileName = "รายงานแผนการขนส่งตั้งแต่วันที่" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
}


header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");

?>
<html>
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
  <br>
<?php
  if (($_GET['companycode'] == 'RKR' || $_GET['companycode'] == 'RKL') && $_GET['customercode'] != 'SKB') {
    ?>
    <table  style="border-collapse: collapse;margin-top:8px;font-size:14px" width="30%"  >
      <label><b>Opentruck for checking</b></label>
    </table>
     <br><br>

          <table  border="1" style="border-collapse: collapse;margin-top:8px;font-size:16px" width="100%"  >

            <tr>
              <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center">NO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">FIRSTDRIVER</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">SECONDDRIVER</td>               
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">ZONE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">DO/PO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">weight DO/PO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">WEIGHT(TON)</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">CHARGE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">ACTUAL</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">IncentiveDri1</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">IncentiveDri2</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Pallet unit</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Fuel bill number</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Start mile</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Finish mile</td> 
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Liters</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">ค่าน้ำมัน</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>


            <?php
            $i = 1;
            if ($_GET['customercode'] == 'TTASTCS') {
              $customercode = 'TTASTCS';
              $jobstart = 'TTAST-CS';
            }else if($_GET['customercode'] == 'TTASTSTC'){
              $customercode = 'TTASTSTC';
              $jobstart = 'TTAST-STC';
            }else if ($_GET['customercode'] == 'ACSE') {
              $customercode = 'ACSE';
            }else if ($_GET['customercode'] == 'DAIKI') {
              $customercode = 'DAIKI';
              $jobstart = 'DAIKI';
            }else if ($_GET['customercode'] == 'GMT') {
              $customercode = 'GMT';
            }else if ($_GET['customercode'] == 'HINO') {
              $customercode = 'HINO';
            }else if ($_GET['customercode'] == 'NITTSU') {
              $customercode = 'NITTSU';
            }else if ($_GET['customercode'] == 'NITTSUSHOJI') {
              $customercode = 'NITTSUSHOJI';
            }else if ($_GET['customercode'] == 'PARAGON') {
              $customercode = 'PARAGON';
              $jobstart = 'STC';
            }else if ($_GET['customercode'] == 'SUTT') {
              $customercode = 'SUTT';
            }else if ($_GET['customercode'] == 'TDEM') {
              $customercode = 'TDEM';
            }else if ($_GET['customercode'] == 'TGT') {
              $customercode = 'TGT';
            }else if ($_GET['customercode'] == 'TID') {
              $customercode = 'TID';
            }else if ($_GET['customercode'] == 'TKT') {
              $customercode = 'TKT';
            }else if ($_GET['customercode'] == 'TMT') {
              $customercode = 'TMT';
            }else if ($_GET['customercode'] == 'TSPT') {
              $customercode = 'TSPT';
            }else if ($_GET['customercode'] == 'TTAST') {
              $customercode = 'TTAST';
            }else if ($_GET['customercode'] == 'TTASTCS') {
              $customercode = 'TTASTCS';
              $jobstart = 'TTAST-CS';
            }else if ($_GET['customercode'] == 'TTASTSTC') {
              $customercode = 'TTASTSTC';
            }else if ($_GET['customercode'] == 'TTAT') {
              $customercode = 'TTAT';
            }else if ($_GET['customercode'] == 'TTPRO') {
              $customercode = 'TTPRO';
            }else if ($_GET['customercode'] == 'TTPROSTC') {
              $customercode = 'TTPROSTC';
              $jobstart = 'TTTC (Amatanakorn)';
            }else if ($_GET['customercode'] == 'TTTC') {
              $customercode = 'TTTC';
            }else if ($_GET['customercode'] == 'TTTCSTC') {
              $customercode = 'TTTCSTC';
            }else if ($_GET['customercode'] == 'YNP') {
              $customercode = 'YNP';
            }else if ($_GET['customercode'] == 'TSAT') {
              $customercode = 'TSAT';
            }else if ($_GET['customercode'] == 'OLT') {
              $customercode = 'OLT';
            }else if ($_GET['customercode'] == 'CH-AUTO') {
              $customercode = 'CH-AUTO';
            }else {
              $customercode = '';
              $from  = '';
            }

            if ($_GET['customercode'] == 'TTASTCS' || $_GET['customercode'] == 'TTASTSTC' 
                || $_GET['customercode'] == 'PARAGON'|| $_GET['customercode'] == 'TTPROSTC') {
              $sql_seBilling = "SELECT a.[OILAVERAGE],b.JOBNO AS 'JOBNO',a.JOBSTART AS 'JOBSTART',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1'
              ,a.EMPLOYEENAME2 AS 'EMP2',a.JOBSTART,a.JOBEND AS 'JOBEND',a.DOCUMENTCODE, b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
              c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
              ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE,b.C8
              ,ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,b.VEHICLETRANSPORTPLANID ORDER BY a.EMPLOYEENAME1 ASC) AS 'ROWNUM'
              ,ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,a.JOBEND,b.VEHICLETRANSPORTPLANID ORDER BY a.EMPLOYEENAME1 ASC) AS 'ROWNUM2'   
              
              FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
              INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
              LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID

              WHERE a.ACTIVESTATUS = 1
              AND a.COMPANYCODE ='" .$_GET['companycode'] ."' AND a.CUSTOMERCODE='".$customercode."'
              AND b.JOBSTART ='".$jobstart."'
              AND a.DOCUMENTCODE IS NOT NULL
              AND a.DOCUMENTCODE !=''
              AND a.WEIGHTIN IS NOT NULL
              AND a.WEIGHTIN !=''
              AND a.WEIGHTIN !='0' AND a.WEIGHTIN !='-'
              AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
              AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
              
              GROUP BY a.[OILAVERAGE],b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1,a.EMPLOYEENAME2,a.JOBSTART, a.JOBEND,a.DOCUMENTCODE, a.JOBSTART,b.VEHICLETRANSPORTPRICEID,
              c.VEHICLETRANSPORTPRICEID,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE,b.C8
              ORDER BY a.EMPLOYEENAME1,b.JOBNO,a.JOBEND ASC";
              
              $params_seBilling = array();
              $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
              
            }else if ($_GET['customercode'] == 'TTTCSTC') {
              $sql_seBilling = "SELECT a.[OILAVERAGE],b.JOBNO AS 'JOBNO',a.JOBSTART AS 'JOBSTART',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1'
              ,a.EMPLOYEENAME2 AS 'EMP2',a.JOBSTART,a.JOBEND AS 'JOBEND',a.DOCUMENTCODE, b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
              c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
              ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE,b.C8
              ,ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,b.VEHICLETRANSPORTPLANID ORDER BY a.EMPLOYEENAME1 ASC) AS 'ROWNUM'
              ,ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,a.JOBEND,b.VEHICLETRANSPORTPLANID ORDER BY a.EMPLOYEENAME1 ASC) AS 'ROWNUM2'
              
              FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
              INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
              LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID

              WHERE a.ACTIVESTATUS = 1
              AND a.COMPANYCODE='".$_GET['companycode']."' AND a.CUSTOMERCODE='".$customercode."'
              AND a.DOCUMENTCODE IS NOT NULL
              AND a.DOCUMENTCODE !=''
              AND a.WEIGHTIN IS NOT NULL
              AND a.WEIGHTIN !=''
              AND a.WEIGHTIN !='0' AND a.WEIGHTIN !='-'
              AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
              AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
              
              GROUP BY a.[OILAVERAGE],b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1,a.EMPLOYEENAME2,a.JOBSTART, a.JOBEND,a.DOCUMENTCODE, a.JOBSTART,b.VEHICLETRANSPORTPRICEID,
              c.VEHICLETRANSPORTPRICEID,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE,b.C8
              ORDER BY a.EMPLOYEENAME1,b.JOBNO,a.JOBEND ASC";

              $params_seBilling = array();
              $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);

            }else if ($_GET['customercode'] == 'TTAST' && $_GET['carrytype'] == 'weight') {
              $sql_seBilling = "SELECT a.[OILAVERAGE],b.JOBNO AS 'JOBNO',a.JOBSTART AS 'JOBSTART',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1'
              ,a.EMPLOYEENAME2 AS 'EMP2',a.JOBSTART,a.JOBEND AS 'JOBEND',a.DOCUMENTCODE, b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
              c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
              ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE,b.C8
              ,ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,b.VEHICLETRANSPORTPLANID ORDER BY a.EMPLOYEENAME1 ASC) AS 'ROWNUM'
              ,ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,a.JOBEND,b.VEHICLETRANSPORTPLANID ORDER BY a.EMPLOYEENAME1 ASC) AS 'ROWNUM2'

              FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
              INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
              LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
      
              WHERE a.ACTIVESTATUS = 1
              AND a.COMPANYCODE='".$_GET['companycode']."' AND a.CUSTOMERCODE='".$customercode."'
              AND a.DOCUMENTCODE IS NOT NULL
              AND a.DOCUMENTCODE !=''
              AND a.WEIGHTIN IS NOT NULL
              AND a.WEIGHTIN !=''
              AND a.WEIGHTIN !='0' AND a.WEIGHTIN !='-'
              AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
              AND c.CARRYTYPE ='weight'
              AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
              
              GROUP BY a.[OILAVERAGE],b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1,a.EMPLOYEENAME2,a.JOBSTART, a.JOBEND,a.DOCUMENTCODE, a.JOBSTART,b.VEHICLETRANSPORTPRICEID,
              c.VEHICLETRANSPORTPRICEID,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE,b.C8
              ORDER BY a.EMPLOYEENAME1,b.JOBNO,a.JOBEND ASC";

              $params_seBilling = array();
              $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
            }else if ($_GET['customercode'] == 'TTAST' && $_GET['carrytype'] == 'trip') {
              $sql_seBilling = "SELECT a.[OILAVERAGE],b.JOBNO AS 'JOBNO',a.JOBSTART AS 'JOBSTART',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1'
              ,a.EMPLOYEENAME2 AS 'EMP2',a.JOBSTART,a.JOBEND AS 'JOBEND',a.DOCUMENTCODE, b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
              c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
              ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE,b.C8
              ,ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,b.VEHICLETRANSPORTPLANID ORDER BY a.EMPLOYEENAME1 ASC) AS 'ROWNUM'
              ,ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,a.JOBEND,b.VEHICLETRANSPORTPLANID ORDER BY a.EMPLOYEENAME1 ASC) AS 'ROWNUM2'
              
              FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
              INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
              LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
      
              WHERE a.ACTIVESTATUS = 1
              AND a.COMPANYCODE='".$_GET['companycode']."' AND a.CUSTOMERCODE='".$customercode."'
              AND a.DOCUMENTCODE IS NOT NULL
              AND a.DOCUMENTCODE !=''
              AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
              AND c.CARRYTYPE ='trip'
              AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
              
              GROUP a.[OILAVERAGE],BY b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1,a.EMPLOYEENAME2,a.JOBSTART, a.JOBEND,a.DOCUMENTCODE, a.JOBSTART,b.VEHICLETRANSPORTPRICEID,
              c.VEHICLETRANSPORTPRICEID,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE,b.C8
              ORDER BY a.EMPLOYEENAME1,b.JOBNO,a.JOBEND ASC";

              $params_seBilling = array();
              $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
            }else if ($_GET['customercode'] == 'DAIKI') {
              $sql_seBilling = "SELECT a.[OILAVERAGE],b.JOBNO AS 'JOBNO',a.JOBSTART AS 'JOBSTART',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1'
              ,a.EMPLOYEENAME2 AS 'EMP2',a.JOBSTART,a.JOBEND AS 'JOBEND',a.DOCUMENTCODE, b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
              c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
              ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE,b.C8
              ,ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,b.VEHICLETRANSPORTPLANID ORDER BY a.EMPLOYEENAME1 ASC) AS 'ROWNUM'
              ,ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,a.JOBEND,b.VEHICLETRANSPORTPLANID ORDER BY a.EMPLOYEENAME1 ASC) AS 'ROWNUM2'

              FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
              INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
              LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
      
              WHERE a.ACTIVESTATUS = 1
              AND a.COMPANYCODE='".$_GET['companycode']."' AND a.CUSTOMERCODE='".$customercode."'
              AND a.DOCUMENTCODE IS NOT NULL
              AND a.DOCUMENTCODE !=''
              AND a.WEIGHTIN IS NOT NULL
              AND a.WEIGHTIN !=''
              AND a.WEIGHTIN !='0' AND a.WEIGHTIN !='-'
              AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
              AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
              
              GROUP BY a.[OILAVERAGE],b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1,a.EMPLOYEENAME2,a.JOBSTART, a.JOBEND,a.DOCUMENTCODE, a.JOBSTART,b.VEHICLETRANSPORTPRICEID,
              c.VEHICLETRANSPORTPRICEID,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE,b.C8
              ORDER BY a.EMPLOYEENAME1,b.JOBNO,a.JOBEND ASC";

              $params_seBilling = array();
              $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
            }else {
              $sql_seBilling = "SELECT a.[OILAVERAGE],b.JOBNO AS 'JOBNO',a.JOBSTART AS 'JOBSTART',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1'
              ,a.EMPLOYEENAME2 AS 'EMP2',a.JOBSTART,a.JOBEND AS 'JOBEND',a.DOCUMENTCODE, b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
              c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
              ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE,b.C8
              ,ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,b.VEHICLETRANSPORTPLANID ORDER BY a.EMPLOYEENAME1 ASC) AS 'ROWNUM'
              ,ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,a.JOBEND,b.VEHICLETRANSPORTPLANID ORDER BY a.EMPLOYEENAME1 ASC) AS 'ROWNUM2'

              FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
              INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
              LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID

              WHERE a.ACTIVESTATUS = 1
              AND a.COMPANYCODE='" .$_GET['companycode'] ."' AND a.CUSTOMERCODE='".$customercode."'
              AND a.DOCUMENTCODE IS NOT NULL
              AND a.DOCUMENTCODE !=''
              -- AND a.WEIGHTIN IS NOT NULL
              -- AND a.WEIGHTIN !=''
              -- AND a.WEIGHTIN !='0' AND a.WEIGHTIN !='-'
              AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
              AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
              
              GROUP BY a.[OILAVERAGE],b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1,a.EMPLOYEENAME2,a.JOBSTART, a.JOBEND,a.DOCUMENTCODE, a.JOBSTART,b.VEHICLETRANSPORTPRICEID,
              c.VEHICLETRANSPORTPRICEID,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE,b.C8
              ORDER BY a.EMPLOYEENAME1,b.JOBNO,a.JOBEND ASC";

              $params_seBilling = array();
              $query_seBilling  = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
            }



            while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                
              ////////////ราคา/////////////
              if ($_GET['customercode'] == 'TTASTCS' || $_GET['customercode'] == 'TTASTSTC' 
                  || $_GET['customercode'] == 'PARAGON'|| $_GET['customercode'] == 'TTPROSTC') {
                $sql_sePrice = "SELECT PRICE AS 'PRICEAC',[LOCATION] AS 'LOCATION' FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE ACTIVESTATUS = 1
                AND COMPANYCODE='" . $_GET['companycode'] . "' AND CUSTOMERCODE='".$customercode."'
                AND PRICE IS NOT NULL AND [FROM]='".$jobstart."' AND [TO] = '" . $result_seBilling['JOBEND'] . "'
                AND CONVERT(DATE,GETDATE()) BETWEEN CONVERT(DATE,STARTDATE) AND CONVERT(DATE,ENDDATE)";
                $params_sePrice = array();
                $query_sePrice  = sqlsrv_query($conn, $sql_sePrice, $params_sePrice);
                $result_sePrice = sqlsrv_fetch_array($query_sePrice, SQLSRV_FETCH_ASSOC);
              }else {
                $sql_sePrice = "SELECT PRICE AS 'PRICEAC',[LOCATION] AS 'LOCATION' FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE ACTIVESTATUS = 1
                AND COMPANYCODE ='" . $_GET['companycode'] . "' AND CUSTOMERCODE='".$customercode."'
                AND PRICE IS NOT NULL  AND [FROM]='" . $result_seBilling['JOBSTART'] . "' AND [TO] = '" . $result_seBilling['JOBEND'] . "'
                AND CONVERT(DATE,GETDATE()) BETWEEN CONVERT(DATE,STARTDATE) AND CONVERT(DATE,ENDDATE)";
                $params_sePrice = array();
                $query_sePrice = sqlsrv_query($conn, $sql_sePrice, $params_sePrice);
                $result_sePrice = sqlsrv_fetch_array($query_sePrice, SQLSRV_FETCH_ASSOC);
              }

            /////////คิดชาท10,ชาท7,ไม่คิดขั้นต่ำ
            $sql_seID = "SELECT DISTINCT REMARK, REMARKHEAD,JOBEND,VEHICLETRANSPORTPLANID FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER]
                         WHERE VEHICLETRANSPORTPLANID = '".$result_seBilling['PLANID']."'
                         AND  JOBEND ='".$result_seBilling['JOBEND']."'";
            $params_seID = array();
            $query_seID = sqlsrv_query($conn, $sql_seID, $params_seID);
            $result_seID = sqlsrv_fetch_array($query_seID, SQLSRV_FETCH_ASSOC);

            ///////////////LOCATION/////////////
            $sql_seLocation = "SELECT VEHICLETRANSPORTPRICEID,[LOCATION] AS 'LOCATION' ,[TO] AS 'JOBEND' FROM [dbo].[VEHICLETRANSPORTPRICE]
            WHERE [TO] ='".$result_seBilling['JOBEND']."'
            AND COMPANYCODE ='".$_GET['companycode']."' AND CUSTOMERCODE='".$customercode."'
            AND CONVERT(DATE,GETDATE()) BETWEEN CONVERT(DATE,STARTDATE,103) AND CONVERT(DATE,ENDDATE,103)";
            $params_seLocation  = array();
            $query_seLocation   = sqlsrv_query($conn, $sql_seLocation, $params_seLocation);
            $result_seLocation  = sqlsrv_fetch_array($query_seLocation, SQLSRV_FETCH_ASSOC);
            
            //เช็คแถวล่างสุดแยก ๋ JOBEND
            $sql_seRownumchk = "SELECT MAX(a.ROWNUM) AS 'ROWNUMCHK' FROM (
                SELECT b.JOBNO AS 'JOBNO',b.VEHICLETRANSPORTPLANID,a.EMPLOYEENAME1
                ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',a.DOCUMENTCODE
                ,ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,a.VEHICLETRANSPORTPLANID ORDER BY a.EMPLOYEENAME1 ASC) AS 'ROWNUM'
                
                FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
                LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
                
                WHERE a.VEHICLETRANSPORTPLANID ='".$result_seBilling['PLANID']."'    
                AND a.JOBEND = '".$result_seBilling['JOBEND']."'    
                GROUP BY b.JOBNO,a.VEHICLETRANSPORTPLANID,a.WEIGHTIN,b.VEHICLETRANSPORTPLANID,a.EMPLOYEENAME1,a.JOBEND,a.DOCUMENTCODE ) a";
            $params_seRownumchk = array();
            $query_seRownumchk  = sqlsrv_query($conn, $sql_seRownumchk, $params_seRownumchk);
            $result_seRownumchk = sqlsrv_fetch_array($query_seRownumchk, SQLSRV_FETCH_ASSOC);
            
            //เช็คแถวล่างสุดตาม PLANID
            $sql_seRownumchk2 = "SELECT MAX(a.ROWNUM) AS 'ROWNUMCHK' FROM (
                SELECT b.JOBNO AS 'JOBNO',b.VEHICLETRANSPORTPLANID,a.EMPLOYEENAME1
                ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',a.DOCUMENTCODE
                ,ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,a.VEHICLETRANSPORTPLANID ORDER BY a.EMPLOYEENAME1 ASC) AS 'ROWNUM'
                
                FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
                LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
                
                WHERE a.VEHICLETRANSPORTPLANID ='".$result_seBilling['PLANID']."' 
                
                GROUP BY b.JOBNO,a.VEHICLETRANSPORTPLANID,a.WEIGHTIN,b.VEHICLETRANSPORTPLANID,a.EMPLOYEENAME1,a.JOBEND,a.DOCUMENTCODE ) a";
            $params_seRownumchk2  = array();
            $query_seRownumchk2   = sqlsrv_query($conn, $sql_seRownumchk2, $params_seRownumchk2);
            $result_seRownumchk2  = sqlsrv_fetch_array($query_seRownumchk2, SQLSRV_FETCH_ASSOC);
            
            //เช็คแถวล่างสุดตาม PLANID,JOBEND
            $sql_seRownumchk4 = "SELECT MAX(a.ROWNUM) AS 'ROWNUMCHK' FROM (
              SELECT b.JOBNO AS 'JOBNO',a.EMPLOYEENAME1
              ,b.VEHICLETRANSPORTPLANID AS 'PLANID',a.DOCUMENTCODE,a.JOBEND
              ,ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,a.VEHICLETRANSPORTPLANID,a.JOBEND ORDER BY a.EMPLOYEENAME1 ASC) AS 'ROWNUM'
              
              FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
              INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
              LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
              
              WHERE a.VEHICLETRANSPORTPLANID ='".$result_seBilling['PLANID']."' 
              AND a.JOBEND = '".$result_seBilling['JOBEND']."'     
              GROUP BY b.JOBNO,b.VEHICLETRANSPORTPLANID,a.VEHICLETRANSPORTPLANID,a.EMPLOYEENAME1,a.JOBEND,a.DOCUMENTCODE ) a";
            $params_seRownumchk4  = array();
            $query_seRownumchk4   = sqlsrv_query($conn, $sql_seRownumchk4, $params_seRownumchk4);
            $result_seRownumchk4  = sqlsrv_fetch_array($query_seRownumchk4, SQLSRV_FETCH_ASSOC);
           
          
          //เลขไมล์ต้น
            $sql_seMileageStart = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGESTART' 
            FROM [dbo].[MILEAGE] 
            WHERE JOBNO ='".$result_seBilling['JOBNO']."'
            AND MILEAGETYPE ='MILEAGESTART'
            ORDER BY CREATEDATE DESC";
            $params_seMileageStart  = array();
            $query_seMileageStart   = sqlsrv_query($conn, $sql_seMileageStart, $params_seMileageStart);
            $result_seMileageStart  = sqlsrv_fetch_array($query_seMileageStart, SQLSRV_FETCH_ASSOC);

            //เลขไมค์ปลาย
            $sql_seMileageEnd = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGEEND' 
            FROM [dbo].[MILEAGE] 
            WHERE JOBNO ='".$result_seBilling['JOBNO']."'
            AND MILEAGETYPE ='MILEAGEEND'
            ORDER BY CREATEDATE DESC";
            $params_seMileageEnd  = array();
            $query_seMileageEnd   = sqlsrv_query($conn, $sql_seMileageEnd, $params_seMileageEnd);
            $result_seMileageEnd  = sqlsrv_fetch_array($query_seMileageEnd, SQLSRV_FETCH_ASSOC);

            $sql_seSumweight = "SELECT SUM( CONVERT(INT, WEIGHTIN)) AS 'WEIGHTINSUM' FROM VEHICLETRANSPORTDOCUMENTDIRVER 
            WHERE VEHICLETRANSPORTPLANID ='".$result_seBilling['PLANID']."'
            AND JOBEND ='".$result_seBilling['JOBEND']."'";
            $params_seSumweight = array();
            $query_seSumweight  = sqlsrv_query($conn, $sql_seSumweight, $params_seSumweight);
            $result_seSumweight = sqlsrv_fetch_array($query_seSumweight, SQLSRV_FETCH_ASSOC);
            
            //ค่าเที่ยว และบิลน้ำมัน
            $sql_seCompen = "SELECT COMPENSATION,COMPENSATION1,COMPENSATION2,COMPENSATION3,OILNUMBER
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] 
            WHERE VEHICLETRANSPORTPLANID = '".$result_seBilling['PLANID']."'
            AND (COMPENSATION IS NOT NULL OR COMPENSATION != '')
            AND (COMPENSATION1 IS NOT NULL OR COMPENSATION1 != '')
            AND (COMPENSATION2 IS NOT NULL OR COMPENSATION2 != '')
            AND (COMPENSATION3 IS NOT NULL OR COMPENSATION3 != '')
            AND (OILNUMBER IS NOT NULL OR OILNUMBER != '')";
            $params_seCompen  = array();
            $query_seCompen   = sqlsrv_query($conn, $sql_seCompen, $params_seCompen);
            $result_seCompen  = sqlsrv_fetch_array($query_seCompen, SQLSRV_FETCH_ASSOC);

            // UNIT PALLET
            $sql_sePallet = "SELECT TRIPAMOUNT_PALLET AS 'PALLET'
            FROM VEHICLETRANSPORTDOCUMENTDIRVERPALLET 
            WHERE VEHICLETRANSPORTPLANID ='".$result_seBilling['PLANID']."'";
            $params_sePallet  = array();
            $query_sePallet   = sqlsrv_query($conn, $sql_sePallet, $params_sePallet);
            $result_sePallet  = sqlsrv_fetch_array($query_sePallet, SQLSRV_FETCH_ASSOC);
            
            // น้ำมัน Liters
            $sql_seOillite = "SELECT O4 AS 'OIL' 
            FROM VEHICLETRANSPORTPLAN 
            WHERE VEHICLETRANSPORTPLANID ='".$result_seBilling['PLANID']."'";
            $params_seOillite = array();
            $query_seOillite  = sqlsrv_query($conn, $sql_seOillite, $params_seOillite);
            $result_seOillite = sqlsrv_fetch_array($query_seOillite, SQLSRV_FETCH_ASSOC);

             //จัดรูปแบบการแสดงผล incentive,pallet uni,fual bill,liter แถวล่างสุด
            if ($result_seBilling['ROWNUM'] == $result_seRownumchk2['ROWNUMCHK']) {
                $incen1 = $result_seCompen['COMPENSATION1'];
                $incen2 = $result_seCompen['COMPENSATION2'];
                $palletunit = $result_sePallet['PALLET'];
                $fuelbill   = $result_seCompen['OILNUMBER'];
                $liters     = $result_seOillite['OIL'];
                $oilaverage = $result_seBilling['OILAVERAGE'];
                if ($result_seBilling['C8'] == 'return') {
                    $C8 = 'งานรับกลับ';
                }else {
                    $C8 = '';
                }
                $mileagestart = $result_seMileageStart['MILEAGESTART'];
                $mileageend = $result_seMileageEnd['MILEAGEEND'];
            }else {
                $incen1 = '';
                $incen2 = '';
                $palletunit = '';
                $fuelbill   = '';
                $liters = '';
                $C8 = '';
                $mileagestart = '';
                $mileageend   = '';
                $oilaverage   ='';
                
            }
                
            //จัดรูปแบบการแสดงผล แสดงผลแถวล่างสุด
           
            if ($result_seBilling['ROWNUM'] == $result_seRownumchk2['ROWNUMCHK']) {
                $weightton    = $result_seBilling['WEISUM'];
                $vihicletype  = $result_seBilling['VEHICLETYPE'];
                
                



            }else {
                $weightton    = '';
                $vihicletype  = '';
               
                
                
            }
            
            //จัดรูปแบบการแสดงผล แสดงผลแถวล่างสุดตาม  ๋JOBEND
            if ($result_seBilling['ROWNUM2'] == $result_seRownumchk4['ROWNUMCHK']) {
              $weisum = ($result_seSumweight['WEIGHTINSUM']/1000);

               
               
              //คิด ACTUAL
              if ($result_seID['REMARK'] == 'Charge 10') {
                  if($result_seBilling['CARRYTYPE'] == 'trip' && ($_GET['customercode'] == 'TSAT' || $_GET['customercode'] == 'TTAST' )){
                    $actual = '';
                  }else{
                    $actual = 10;
                  }

              } if ($result_seID['REMARK'] == 'Charge 7') {
                    $actual = 7;  
              } if ($result_seID['REMARK'] == 'ไม่คิดขั้นต่ำ') {
                  if($result_seBilling['CARRYTYPE'] == 'trip' && ($_GET['customercode'] == 'TSAT' || $_GET['customercode'] == 'TTAST' )){
                    $actual = '';
                  }else{
                    $actual = $weisum;
                  }
              } if ($result_seID['REMARK'] == 'CHARGE 12') {
                  if($result_seBilling['CARRYTYPE'] == 'trip' && ($_GET['customercode'] == 'TSAT' || $_GET['customercode'] == 'TTAST' )){
                    $actual = '';
                  }else{
                    $actual = 12;
                  }
              } if ($result_seID['REMARK'] == 'NOT CHARGE') {
                  if($result_seBilling['CARRYTYPE'] == 'trip' && ($_GET['customercode'] == 'TSAT' || $_GET['customercode'] == 'TTAST' )){
                    $actual = '';
                  }else{
                    $actual = $weisum;
                  }
              }

                $charge = $actual-$weisum;

            }else {
              $weisum = '';
              $actual = '';
              $charge = '';
            }

            //จัดรูปแบบการแสดงผล
            if ($result_seBilling['ROWNUM'] == '1') {
                $vihicletype  = $result_seBilling['VEHICLETYPE'];
                $thainame     = $result_seBilling['THAINAME'];
                $firstdriver  = $result_seBilling['EMP1'];
                $seconddriver = $result_seBilling['EMP2'];
                
                
                /////////////////////////////////ZONE////////////////////////////////////////////////////////////
                if ($result_seLocation['LOCATION'] == 'พระประแดง/สำโรง' || $result_seLocation['LOCATION'] == 'สำโรง') {
                  $zone = "Samrong";
                } else if ($result_seLocation['LOCATION'] == 'บางพลี') {
                  $zone = "Bangplee";
                } else if ($result_seLocation['LOCATION'] == 'เทพารักษ์') {
                  if ($result_seLocation['JOBEND'] == 'HINO2') {
                    $zone = "Bangplee";
                  }else {
                    $zone = "Thepharak";
                  }

                } else if ($result_seLocation['LOCATION'] == 'ลาดกระบัง') {
                  $zone = "Ladkrabang";
                } else if ($result_seLocation['LOCATION'] == 'บางประกง') {
                  if ($result_seLocation['JOBEND'] == 'REFORM') {
                    $zone = "Wellgrow";
                  }else if ($result_seLocation['JOBEND'] == 'TOY') {
                    $zone = "Banpho";
                  }else {
                    $zone = "Bang Pakong";
                  }

                } else if ($result_seLocation['LOCATION'] == 'บ้านโพธิ์') {

                    $zone = "Banpho";

                } else if ($result_seLocation['LOCATION'] == 'แปลงยาว') {
                  if ($result_seLocation['JOBEND'] == 'NB-WOOD') {
                    $zone = "Phanat Nikhom";

                  }else {
                    $zone = "Gateway";
                  }

                } else if ($result_seLocation['LOCATION'] == 'บ้านบึง') {
                  $zone = "Banbung";
                } else if ($result_seLocation['LOCATION'] == 'ศรีราชา') {
                  $zone = "Sriracha";
                } else if ($result_seLocation['LOCATION'] == 'ปลวกแดง') {
                  if ($result_seLocation['JOBEND'] == 'AHT2' || $result_seLocation['JOBEND'] == 'BHKT' || $result_seLocation['JOBEND'] == 'TBFST' || $result_seLocation['JOBEND'] == 'TBFST(BOI)') {
                    $zone = "Eastern Seaboard IE.";
                  }else if($result_seLocation['JOBEND'] == 'ALS') {
                    $zone = "Borwin";
                  }else {
                    $zone = "Rayong";
                  }

                } else if ($result_seLocation['LOCATION'] == 'อมตะนคร') {
                  $zone = "Amatanakorn";
                } else if ($result_seLocation['LOCATION'] == 'บางปะอิน') {
                  $zone = "Ayutthaya";
                } else if ($result_seLocation['LOCATION'] == 'กระทุ่มแบน') {
                  $zone = "Samutsakorn";
                } else if ($result_seLocation['LOCATION'] == 'เทพารักษ์') {
                  $zone = "Samutsakorn";
                } else if ($result_seLocation['LOCATION'] == 'กบินบุรี') {
                  if ($result_seLocation['JOBEND'] == 'HISADA') {
                    $zone = "Prachin Buri";
                  }else {
                    $zone = "Kabinburi";
                  }

                } else if ($result_seLocation['LOCATION'] == 'บางบ่อ') {
                  if ($result_seLocation['JOBEND'] == 'SIMA') {
                    $zone = "Bangplee";
                  }else {
                    $zone = "Bang-bo";
                  }

                } else if ($result_seLocation['LOCATION'] == 'เมือง'){
                  if ($result_seLocation['JOBEND'] == 'SARATHORN' || $result_seLocation['JOBEND'] == 'SUNSTEEL') {
                    $zone = "Samutsakorn";
                  }else if($result_seLocation['JOBEND'] == 'KEIHIN') {
                    $zone = "Lamphun";
                  }else {
                    $zone = "Mueang";
                  }

                } else if($result_seLocation['LOCATION'] == 'เวลโกรว์' || $result_seLocation['LOCATION'] == 'เวลล์โกร์') {
                  $zone = "Wellgrow";
                } else if($result_seLocation['LOCATION'] == 'สุขสวัสดิ์') {
                  $zone = "Sooksawat";
                } else if($result_seLocation['LOCATION'] == 'หนองแค') {
                  $zone = "Saraburi";
                }else if($result_seLocation['LOCATION'] == 'แปลงยาว' || $result_seLocation['LOCATION'] == 'เกตเวย์') {
                  $zone = "Gateway";
                }else if($result_seLocation['LOCATION'] == 'ปู่เจ้า') {
                  $zone = "Poochao";
                }else if($result_seLocation['LOCATION'] == 'ปิ่นทอง') {
                  $zone = "Pinthong";
                }else if($result_seLocation['LOCATION'] == 'ปทุมธานี') {
                  $zone = "Pathumthani";
                }else if($result_seLocation['LOCATION'] == 'อยุธยา') {
                  $zone = "Ayutthaya";
                }else if($result_seLocation['LOCATION'] == 'พนัสนิคม') {
                  $zone = "Phanat Nikhom";
                }else if($result_seLocation['LOCATION'] == 'อีสเทิร์น ซีบอร์ด' || $result_seLocation['LOCATION'] == 'อีสเทิร์นซีบอร์ด') {
                  $zone = "Eastern Seaboard IE.";
                }else if($result_seLocation['LOCATION'] == 'ประชาอุทิศ') { 
                  $zone = "Pracha Uthid";
                }else if($result_seBilling1['LOCATION'] == 'แหลมฉบัง') {
                  $zone = "Laemchabang";
                }else {
                  $zone = $result_seLocation['LOCATION'];
                }

              ////////////////////////////////////////JOBEND///////////////////////////////////////////////
                if ($result_seBilling['JOBEND'] == 'TMB') {
                  $jobend = "TMT/BP";
                }else if ($result_seBilling['JOBEND'] == 'APIGO') {
                  $jobend = "AAPICO";
                }else if ($result_seBilling['JOBEND'] == 'ASNO') {
                  $jobend = "ASNO1";
                }else if ($result_seBilling['JOBEND'] == 'TBFST' || $result_seBilling['JOBEND'] == 'TBFST(BOI)') {
                  $jobend = "TBFST";
                }else if ($result_seBilling['JOBEND'] == 'TYP') {
                  $jobend = "TYP";
                }else if ($result_seBilling['JOBEND'] == 'WFAN/R.Y.') {
                  $jobend = "WIREFORM";
                }else if ($result_seBilling['JOBEND'] == 'TMG') {
                  $jobend = "TMT/GW";
                }else if ($result_seBilling['JOBEND'] == 'SSSC-02') {
                  $jobend = "SSSC-2";
                }else if ($result_seBilling['JOBEND'] == 'TABT/DMK') {
                  $jobend = "DMK";
                }else if ($result_seBilling['JOBEND'] == 'TMS') {
                  $jobend = "TMT/SR";
                }else if ($result_seBilling['JOBEND'] == 'SUNSTEEL') {
                  $jobend = "Sonsteel";
                }else if ($result_seBilling['JOBEND'] == 'SRP') {
                  $jobend = "S.R-P";
                }else if ($result_seBilling['JOBEND'] == 'KIT2/KIT') {
                  $jobend = "KIT";
                }else if ($result_seBilling['JOBEND'] == 'SHI/SHI2') {
                  $jobend = "SHI(2)";
                }else if ($result_seBilling['JOBEND'] == 'SHIROKI' || $result_seBilling['JOBEND'] == 'SHIROKI(1)') {
                  $jobend = "SHIROKI(1)";
                }else if ($result_seBilling['JOBEND'] == 'YMPPD/BT') {
                  $jobend = "BTD";
                }else if ($result_seBilling['JOBEND'] == 'TTAST-PT') {   ////////////TTASTCS(OTHER)(WEIGHT)
                  $jobend = "TTAST-PT";
                }else if ($result_seBilling['JOBEND'] == 'JOZU : Teparak') {
                  $jobend = "JOZU";
                }else if ($result_seBilling['JOBEND'] == 'KSC : Nakhonratchasima') {
                  $jobend = "KSC";
                }else if ($result_seBilling['JOBEND'] == 'CPS : Amatanakorn') {
                  $jobend = "CPS";
                }else if ($result_seBilling['JOBEND'] == 'DCL : Banbung') {
                  $jobend = "DCL";
                }else if ($result_seBilling['JOBEND'] == 'AAA : BanPho') {
                  $jobend = "AAA";
                }else if ($result_seBilling['JOBEND'] == 'NB WOOD') {
                  $jobend = "NB WOOD";
                }else if ($result_seBilling['JOBEND'] == 'OTC : Ladkrabang') {
                  $jobend = "OTC";
                }else if ($result_seBilling['JOBEND'] == 'SAM : Laemchabang') {
                  $jobend = "SAM";
                }else if ($result_seBilling['JOBEND'] == 'TATP : Pathum Thani') {
                  $jobend = "TATP";
                }else if ($result_seBilling['JOBEND'] == 'KTAC:Phanat Nikhom') {
                  $jobend = "KTAC";
                }else if ($result_seBilling['JOBEND'] == 'SYM : Banbung') {
                  $jobend = "SYM";
                }else if ($result_seBilling['JOBEND'] == 'TSK : Amatanakorn') {
                  $jobend = "TSK";
                }else if ($result_seBilling['JOBEND'] == 'YAMATO : Sriracha') {
                  $jobend = "YAMATO";
                }else if ($result_seBilling['JOBEND'] == 'YKT : Eastern Seaboard IE.') {
                  $jobend = "YKT";
                }else if ($result_seBilling['JOBEND'] == 'YNPN1 : Bangplee') {
                  $jobend = "YNPN1";
                }else if ($result_seBilling['JOBEND'] == 'YNPN2 : Bangplee') {
                  $jobend = "YNPN2";
                }else if ($result_seBilling['JOBEND'] == 'YNPN3 : Banpho') {
                  $jobend = "YNPN3";
                }else if ($result_seBilling['JOBEND'] == 'YS PUND : Wellgrow') {
                  $jobend = "YS PUND";
                }else if ($result_seBilling['JOBEND'] == 'JSA : Pathum Thani') {
                  $jobend = "JSA";
                }else if ($result_seBilling['JOBEND'] == 'KCP : Bangpakong') {
                  $jobend = "KCP";
                }else if ($result_seBilling['JOBEND'] == 'Korawit : Teparak') {
                  $jobend = "Korawit";
                }else if ($result_seBilling['JOBEND'] == 'TOKAI : Amatanakorn') {
                  $jobend = "TOKAI";
                }else if ($result_seBilling['JOBEND'] == 'BVS : Banpho') {
                  $jobend = "BVS";
                }else if ($result_seBilling['JOBEND'] == 'SARATHORN') {
                  $jobend = "SARATHORN";
                }else if ($result_seBilling['JOBEND'] == 'THAI NIPPON : Laemchabang') {
                  $jobend = "THAI NIPPON";
                }else if ($result_seBilling['JOBEND'] == 'VORASAK : Ayutthaya') {
                  $jobend = "VORASAK";
                }else if ($result_seBilling['JOBEND'] == 'SSSC2 : Poochao') {
                  $jobend = "SSSC2";
                }else if ($result_seBilling['JOBEND'] == 'KEIHIN : Lamphun') {
                  $jobend = "KEIHIN";
                }else if ($result_seBilling['JOBEND'] == 'KTAC : Samutsakorn') {
                  $jobend = "KTAC";
                }else if ($result_seBilling['JOBEND'] == 'MONOSTEEL') {
                  $jobend = "MONOSTEEL";
                }else if ($result_seBilling['JOBEND'] == 'SSSC3 : Easternseaboard') {
                  $jobend = "SSSC3";
                }else if ($result_seBilling['JOBEND'] == 'UCC2 : Amata') {
                  $jobend = "UCC2";
                }else if ($result_seBilling['JOBEND'] == 'STC : Amatanakorn') {
                  $jobend = "STC";
                }else if ($result_seBilling['JOBEND'] == 'STE : Wellgrow') {
                  $jobend = "STE";
                }else if ($result_seBilling['JOBEND'] == 'WWGF1 : Bangplee') {
                  $jobend = "WWG";
                }else if ($result_seBilling1['JOBEND'] == 'KORAWIT : Teparak') {
                  $jobend = "KORAWIT";
                }else {
                  $jobend = $result_seBilling['JOBEND'];
                }

                /////////////////from งานนอก///////////////////////

                if ($_GET['customercode'] == 'TTASTCS') {
                  $from = 'CS Wellgrow';
                }else if($_GET['customercode'] == 'TTASTSTC'){
                  $from  = 'STC Amatacity chonburi';
                }else if ($_GET['customercode'] == 'ACSE') {
                  $from  = 'ACSE';
                }else if ($_GET['customercode'] == 'DAIKI') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'GMT') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'HINO') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'NITTSU') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'NITTSUSHOJI') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'PARAGON') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'SUTT') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'TDEM') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'TGT') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'TID') {
                  $from  = $result_seBilling['JOBSTART'];;
                }else if ($_GET['customercode'] == 'TKT') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'TMT') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'TSPT') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'TSAT') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'TTAST') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'TTAT') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'TTPRO') {
                  $from  = 'TTPRO';
                }else if ($_GET['customercode'] == 'TTPROSTC') {
                  $from  = 'TTPROSTC';
                }else if ($_GET['customercode'] == 'TTTC') {
                  $from  = 'TTTC';
                }else if ($_GET['customercode'] == 'TTTCSTC') {
                  $from  = 'TTTCSTC';
                }else if ($_GET['customercode'] == 'YNP') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'OLT') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'CH-AUTO') {
                  $from  = $result_seBilling['JOBSTART'];
                }else {
                  $from  = '';
                }

                $price = $result_sePrice['PRICEAC'];
                $do = $result_seBilling['DOCUMENTCODE'];

                
            }else {
                $vihicletype = '';
                $thainame = '';
                $firstdriver = '';
                $seconddriver = '';
                
                ////////////////////////////////////////JOBEND///////////////////////////////////////////////
                if ($result_seBilling['JOBEND'] == 'TMB') {
                  $jobend = "TMT/BP";
                }else if ($result_seBilling['JOBEND'] == 'APIGO') {
                  $jobend = "AAPICO";
                }else if ($result_seBilling['JOBEND'] == 'ASNO') {
                  $jobend = "ASNO1";
                }else if ($result_seBilling['JOBEND'] == 'TBFST' || $result_seBilling['JOBEND'] == 'TBFST(BOI)') {
                  $jobend = "TBFST";
                }else if ($result_seBilling['JOBEND'] == 'TYP') {
                  $jobend = "TYP";
                }else if ($result_seBilling['JOBEND'] == 'WFAN/R.Y.') {
                  $jobend = "WIREFORM";
                }else if ($result_seBilling['JOBEND'] == 'TMG') {
                  $jobend = "TMT/GW";
                }else if ($result_seBilling['JOBEND'] == 'SSSC-02') {
                  $jobend = "SSSC-2";
                }else if ($result_seBilling['JOBEND'] == 'TABT/DMK') {
                  $jobend = "DMK";
                }else if ($result_seBilling['JOBEND'] == 'TMS') {
                  $jobend = "TMT/SR";
                }else if ($result_seBilling['JOBEND'] == 'SUNSTEEL') {
                  $jobend = "Sonsteel";
                }else if ($result_seBilling['JOBEND'] == 'SRP') {
                  $jobend = "S.R-P";
                }else if ($result_seBilling['JOBEND'] == 'KIT2/KIT') {
                  $jobend = "KIT";
                }else if ($result_seBilling['JOBEND'] == 'SHI/SHI2') {
                  $jobend = "SHI(2)";
                }else if ($result_seBilling['JOBEND'] == 'SHIROKI' || $result_seBilling['JOBEND'] == 'SHIROKI(1)') {
                  $jobend = "SHIROKI(1)";
                }else if ($result_seBilling['JOBEND'] == 'YMPPD/BT') {
                  $jobend = "BTD";
                }else if ($result_seBilling['JOBEND'] == 'TTAST-PT') {   ////////////TTASTCS(OTHER)(WEIGHT)
                  $jobend = "TTAST-PT";
                }else if ($result_seBilling['JOBEND'] == 'JOZU : Teparak') {
                  $jobend = "JOZU";
                }else if ($result_seBilling['JOBEND'] == 'KSC : Nakhonratchasima') {
                  $jobend = "KSC";
                }else if ($result_seBilling['JOBEND'] == 'CPS : Amatanakorn') {
                  $jobend = "CPS";
                }else if ($result_seBilling['JOBEND'] == 'DCL : Banbung') {
                  $jobend = "DCL";
                }else if ($result_seBilling['JOBEND'] == 'AAA : BanPho') {
                  $jobend = "AAA";
                }else if ($result_seBilling['JOBEND'] == 'NB WOOD') {
                  $jobend = "NB WOOD";
                }else if ($result_seBilling['JOBEND'] == 'OTC : Ladkrabang') {
                  $jobend = "OTC";
                }else if ($result_seBilling['JOBEND'] == 'SAM : Laemchabang') {
                  $jobend = "SAM";
                }else if ($result_seBilling['JOBEND'] == 'TATP : Pathum Thani') {
                  $jobend = "TATP";
                }else if ($result_seBilling['JOBEND'] == 'KTAC:Phanat Nikhom') {
                  $jobend = "KTAC";
                }else if ($result_seBilling['JOBEND'] == 'SYM : Banbung') {
                  $jobend = "SYM";
                }else if ($result_seBilling['JOBEND'] == 'TSK : Amatanakorn') {
                  $jobend = "TSK";
                }else if ($result_seBilling['JOBEND'] == 'YAMATO : Sriracha') {
                  $jobend = "YAMATO";
                }else if ($result_seBilling['JOBEND'] == 'YKT : Eastern Seaboard IE.') {
                  $jobend = "YKT";
                }else if ($result_seBilling['JOBEND'] == 'YNPN1 : Bangplee') {
                  $jobend = "YNPN1";
                }else if ($result_seBilling['JOBEND'] == 'YNPN2 : Bangplee') {
                  $jobend = "YNPN2";
                }else if ($result_seBilling['JOBEND'] == 'YNPN3 : Banpho') {
                  $jobend = "YNPN3";
                }else if ($result_seBilling['JOBEND'] == 'YS PUND : Wellgrow') {
                  $jobend = "YS PUND";
                }else if ($result_seBilling['JOBEND'] == 'JSA : Pathum Thani') {
                  $jobend = "JSA";
                }else if ($result_seBilling['JOBEND'] == 'KCP : Bangpakong') {
                  $jobend = "KCP";
                }else if ($result_seBilling['JOBEND'] == 'Korawit : Teparak') {
                  $jobend = "Korawit";
                }else if ($result_seBilling['JOBEND'] == 'TOKAI : Amatanakorn') {
                  $jobend = "TOKAI";
                }else if ($result_seBilling['JOBEND'] == 'BVS : Banpho') {
                  $jobend = "BVS";
                }else if ($result_seBilling['JOBEND'] == 'SARATHORN') {
                  $jobend = "SARATHORN";
                }else if ($result_seBilling['JOBEND'] == 'THAI NIPPON : Laemchabang') {
                  $jobend = "THAI NIPPON";
                }else if ($result_seBilling['JOBEND'] == 'VORASAK : Ayutthaya') {
                  $jobend = "VORASAK";
                }else if ($result_seBilling['JOBEND'] == 'SSSC2 : Poochao') {
                  $jobend = "SSSC2";
                }else if ($result_seBilling['JOBEND'] == 'KEIHIN : Lamphun') {
                  $jobend = "KEIHIN";
                }else if ($result_seBilling['JOBEND'] == 'KTAC : Samutsakorn') {
                  $jobend = "KTAC";
                }else if ($result_seBilling['JOBEND'] == 'MONOSTEEL') {
                  $jobend = "MONOSTEEL";
                }else if ($result_seBilling['JOBEND'] == 'SSSC3 : Easternseaboard') {
                  $jobend = "SSSC3";
                }else if ($result_seBilling['JOBEND'] == 'UCC2 : Amata') {
                  $jobend = "UCC2";
                }else if ($result_seBilling['JOBEND'] == 'STC : Amatanakorn') {
                  $jobend = "STC";
                }else if ($result_seBilling['JOBEND'] == 'STE : Wellgrow') {
                  $jobend = "STE";
                }else if ($result_seBilling['JOBEND'] == 'WWGF1 : Bangplee') {
                  $jobend = "WWG";
                }else if ($result_seBilling1['JOBEND'] == 'KORAWIT : Teparak') {
                  $jobend = "KORAWIT";
                }else {
                  $jobend = $result_seBilling['JOBEND'];
                }

                /////////////////from งานนอก///////////////////////

                if ($_GET['customercode'] == 'TTASTCS') {
                  $from = 'CS Wellgrow';
                }else if($_GET['customercode'] == 'TTASTSTC'){
                  $from  = 'STC Amatacity chonburi';
                }else if ($_GET['customercode'] == 'ACSE') {
                  $from  = 'ACSE';
                }else if ($_GET['customercode'] == 'DAIKI') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'GMT') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'HINO') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'NITTSU') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'NITTSUSHOJI') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'PARAGON') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'SUTT') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'TDEM') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'TGT') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'TID') {
                  $from  = $result_seBilling['JOBSTART'];;
                }else if ($_GET['customercode'] == 'TKT') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'TMT') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'TSPT') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'TSAT') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'TTAST') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'TTAT') {
                  $from  = $result_seBilling['JOBSTART'];
                }else if ($_GET['customercode'] == 'TTPRO') {
                  $from  = 'TTPRO';
                }else if ($_GET['customercode'] == 'TTPROSTC') {
                  $from  = 'TTPROSTC';
                }else if ($_GET['customercode'] == 'TTTC') {
                  $from  = 'TTTC';
                }else if ($_GET['customercode'] == 'TTTCSTC') {
                  $from  = 'TTTCSTC';
                }else if ($_GET['customercode'] == 'YNP') {
                  $from  = $result_seBilling['JOBSTART'];
                }else {
                  $from  = '';
                }

                /////////////////////////////////ZONE////////////////////////////////////////////////////////////
                if ($result_seLocation['LOCATION'] == 'พระประแดง/สำโรง' || $result_seLocation['LOCATION'] == 'สำโรง') {
                  $zone = "Samrong";
                } else if ($result_seLocation['LOCATION'] == 'บางพลี') {
                  $zone = "Bangplee";
                } else if ($result_seLocation['LOCATION'] == 'เทพารักษ์') {
                  if ($result_seLocation['JOBEND'] == 'HINO2') {
                    $zone = "Bangplee";
                  }else {
                    $zone = "Thepharak";
                  }
                } else if ($result_seLocation['LOCATION'] == 'ลาดกระบัง') {
                  $zone = "Ladkrabang";
                } else if ($result_seLocation['LOCATION'] == 'บางประกง') {
                  if ($result_seLocation['JOBEND'] == 'REFORM') {
                    $zone = "Wellgrow";
                  }else if ($result_seLocation['JOBEND'] == 'TOY') {
                    $zone = "Banpho";
                  }else {
                    $zone = "Bang Pakong";
                  }
                } else if ($result_seLocation['LOCATION'] == 'บ้านโพธิ์') {
                    $zone = "Banpho";
                } else if ($result_seLocation['LOCATION'] == 'แปลงยาว') {
                  if ($result_seLocation['JOBEND'] == 'NB-WOOD') {
                    $zone = "Phanat Nikhom";
                  }else {
                    $zone = "Gateway";
                  }
                } else if ($result_seLocation['LOCATION'] == 'บ้านบึง') {
                  $zone = "Banbung";
                } else if ($result_seLocation['LOCATION'] == 'ศรีราชา') {
                  $zone = "Sriracha";
                } else if ($result_seLocation['LOCATION'] == 'ปลวกแดง') {
                  if ($result_seLocation['JOBEND'] == 'AHT2' || $result_seLocation['JOBEND'] == 'BHKT' || $result_seLocation['JOBEND'] == 'TBFST' || $result_seLocation['JOBEND'] == 'TBFST(BOI)') {
                    $zone = "Eastern Seaboard IE.";
                  }else if($result_seLocation['JOBEND'] == 'ALS') {
                    $zone = "Borwin";
                  }else {
                    $zone = "Rayong";
                  }
                } else if ($result_seLocation['LOCATION'] == 'อมตะนคร') {
                  $zone = "Amatanakorn";
                } else if ($result_seLocation['LOCATION'] == 'บางปะอิน') {
                  $zone = "Ayutthaya";
                } else if ($result_seLocation['LOCATION'] == 'กระทุ่มแบน') {
                  $zone = "Samutsakorn";
                }else if ($result_seLocation['LOCATION'] == 'เทพารักษ์') {
                  $zone = "Samutsakorn";
                }else if ($result_seLocation['LOCATION'] == 'กบินบุรี') {
                  if ($result_seLocation['JOBEND'] == 'HISADA') {
                    $zone = "Prachin Buri";
                  }else {
                    $zone = "Kabinburi";
                  }
                }else if ($result_seLocation['LOCATION'] == 'บางบ่อ') {
                  if ($result_seLocation['JOBEND'] == 'SIMA') {
                    $zone = "Bangplee";
                  }else {
                    $zone = "Bang-bo";
                  }
                } else if ($result_seLocation['LOCATION'] == 'เมือง'){
                  if ($result_seLocation['JOBEND'] == 'SARATHORN' || $result_seLocation['JOBEND'] == 'SUNSTEEL') {
                    $zone = "Samutsakorn";
                  }else if($result_seLocation['JOBEND'] == 'KEIHIN') {
                    $zone = "Lamphun";
                  }else {
                    $zone = "Mueang";
                  }
                } else if($result_seLocation['LOCATION'] == 'เวลโกรว์' || $result_seLocation['LOCATION'] == 'เวลล์โกร์') {
                  $zone = "Wellgrow";
                } else if($result_seLocation['LOCATION'] == 'สุขสวัสดิ์') {
                  $zone = "Sooksawat";
                } else if($result_seLocation['LOCATION'] == 'หนองแค') {
                  $zone = "Saraburi";
                }else if($result_seLocation['LOCATION'] == 'แปลงยาว' || $result_seLocation['LOCATION'] == 'เกตเวย์') {
                  $zone = "Gateway";
                }else if($result_seLocation['LOCATION'] == 'ปู่เจ้า') {
                  $zone = "Poochao";
                }else if($result_seLocation['LOCATION'] == 'ปิ่นทอง') {
                  $zone = "Pinthong";
                }else if($result_seLocation['LOCATION'] == 'ปทุมธานี') {
                  $zone = "Pathumthani";
                }else if($result_seLocation['LOCATION'] == 'อยุธยา') {
                  $zone = "Ayutthaya";
                }else if($result_seLocation['LOCATION'] == 'พนัสนิคม') {
                  $zone = "Phanat Nikhom";
                }else if($result_seLocation['LOCATION'] == 'อีสเทิร์น ซีบอร์ด' || $result_seLocation['LOCATION'] == 'อีสเทิร์นซีบอร์ด') {
                  $zone = "Eastern Seaboard IE.";
                }else if($result_seLocation['LOCATION'] == 'ประชาอุทิศ') { 
                  $zone = "Pracha Uthid";
                }else if($result_seBilling1['LOCATION'] == 'แหลมฉบัง') {
                  $zone = "Laemchabang";
                }else {
                  $zone = $result_seLocation['LOCATION'];
                }

                $price  = $result_sePrice['PRICEAC'];
                $do     = $result_seBilling['DOCUMENTCODE'];
                
             
            }

            
            ///////////////////////////////////////////
           
            

            ////////////NO///////////////////////
            if ($result_seBilling['ROWNUM'] > 1) {
                $i--;
                $NO = '';
            }else {
                $NO = $i;
            }


                    

                    

              ?>
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$NO?></td>
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$thainame?></td>
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$vihicletype?></td>
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$firstdriver?></td>
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$seconddriver?></td> 
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$from?></td>
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$jobend?></td>
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$zone?></td>
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$price?></td>
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$do?></td>
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=number_format(($result_seBilling['WEISUM']/1000),3)?></td>
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=(number_format(($weisum),3) == '0.000' ? '' : number_format(($weisum),3) )?></td>
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=($charge == '0'? '0.000':$charge)?></td>
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=number_format($actual,3)?></td>       
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$incen1?></td>
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$incen2?></td>
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$palletunit?></td>
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$fuelbill?></td>
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$mileagestart?></td>
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$mileageend?></td>    
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$liters?></td>
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$oilaverage?></td>
                
              <!-- REMARK -->
              <?php
              if($result_seBilling['CARRYTYPE'] == 'trip' && ($_GET['customercode'] == 'TSAT' || $_GET['customercode'] == 'TTAST' )){
                ?>
                  <td     style="border:1px solid #000;padding:4px;text-align:center"></td>
                <?php
              }else{
                ?>
                  <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$C8?></td>
              <?php  
              }
              ?>
              
              

            </tr>
            <?php
            $i++;
          }
          ?>
        </table>
    <?php
    // //////////////////////////RKS////////////////////////////////////////////////////
  }else if ($_GET['companycode'] == 'RKL' && $_GET['customercode'] == 'SKB'){
    ?>
    <table  style="border-collapse: collapse;margin-top:8px;font-size:14px" width="30%"  >
      <label><b>Opentruck for checking SKB</b></label>
    </table>
          <br><br>

          <table   style="border-collapse: collapse;margin-top:8px;font-size:14px" width="100%">

            <tr>
              <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center">NO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO1</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO2</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">DRIVER.1</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">DRIVER.2</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">DO/PO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Tractor</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">TOTAL UNIT</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Start Expressway</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Finish Expressway</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Incentive Dri1</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Incentive Dri2</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Fuel bill number</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Start mile</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Finish mile</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Liters</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">ค่าน้ำมัน</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>


            <?php
              $i = 1;

              $sql_seBilling = "SELECT a.[OILAVERAGE],b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME1',b.THAINAME2 AS 'THAINAME2',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
              a.EMPLOYEENAME2 AS 'EMP2',a.JOBSTART AS 'JOBSTART', a.JOBEND AS 'JOBEND',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
              c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
              ,b.VEHICLETRANSPORTPLANID AS 'PLANID',c.ROUTEDESCRIPTION AS 'DENSOTO',a.DOCUMENTCODE AS 'DOCUMENTCODE'
              ,a.PAY_CONDITION AS 'PAYCONDITION',a.EMPLOYEECODE1 AS 'EMPLOYEECODE1',a.TRIPAMOUNT AS 'TRIPAMOUNT'
              ,SUBSTRING(b.ROUNDAMOUNT, 1, 3)  AS 'ROUND',ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,a.VEHICLETRANSPORTPLANID ORDER BY a.EMPLOYEENAME1,a.DOCUMENTCODE ASC) AS 'ROWNUM'
              FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
              INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
              LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
                            
              WHERE a.ACTIVESTATUS = 1
              AND a.COMPANYCODE='RKL' AND a.CUSTOMERCODE='SKB'
              AND a.DOCUMENTCODE IS NOT NULL
              AND a.DOCUMENTCODE !=''
              AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
              AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
              
              ORDER BY a.EMPLOYEENAME1 ASC";
              $params_seBilling = array();
              $query_seBilling  = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
            while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                
                
            ////////////////////////////////////////////////////////////////////////////////////////////////
            if ($_GET['companycode'] == 'RKS' && $_GET['customercode'] == 'STM') {
              $sql_seTripamount = "SELECT LEFT(a.ROUNDAMOUNT,PATINDEX('%[^0-9]%',a.ROUNDAMOUNT)-1) AS 'TRIPAMOUNT'
                                   , SUBSTRING(a.JOBSTART, 21, 4)  AS 'JOBSTART',SUBSTRING(a.ROUNDAMOUNT, 2, 2)  AS 'ROUND'

                                   FROM [dbo].[VEHICLETRANSPORTPLAN] a
                                   WHERE a.ROUNDAMOUNT IS NOT NULL AND a.VEHICLETRANSPORTPLANID = '" . $result_seBilling['PLANID'] . "'";
              $query_seTripamount   = sqlsrv_query($conn, $sql_seTripamount, $params_seTripamount);
              $result_seTripamount  = sqlsrv_fetch_array($query_seTripamount, SQLSRV_FETCH_ASSOC);
            }else {
              // code...
            }

            //เช็คแถวล่างสุดตาม PLANID
          $sql_seRownumchk2 = "SELECT MAX(a.ROWNUM) AS 'ROWNUMCHK' FROM (
            SELECT b.JOBNO AS 'JOBNO',a.EMPLOYEENAME1
            ,b.VEHICLETRANSPORTPLANID AS 'PLANID',a.DOCUMENTCODE,a.JOBEND
            ,ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,a.VEHICLETRANSPORTPLANID ORDER BY a.EMPLOYEENAME1 ASC) AS 'ROWNUM'
            
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
            LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
            
            WHERE a.VEHICLETRANSPORTPLANID ='".$result_seBilling['PLANID']."'    
            GROUP BY b.JOBNO,b.VEHICLETRANSPORTPLANID,a.VEHICLETRANSPORTPLANID,a.EMPLOYEENAME1,a.JOBEND,a.DOCUMENTCODE ) a";
          $params_seRownumchk2  = array();
          $query_seRownumchk2   = sqlsrv_query($conn, $sql_seRownumchk2, $params_seRownumchk2);
          $result_seRownumchk2  = sqlsrv_fetch_array($query_seRownumchk2, SQLSRV_FETCH_ASSOC);

          


          //เช็คแถวล่างสุดตาม EMPLOYEECODE
          $sql_seRownumchk3 = "SELECT TOP 1 JOBNO,VEHICLETRANSPORTPLANID                   
            FROM [dbo].[VEHICLETRANSPORTPLAN] 
            WHERE EMPLOYEECODE1 ='".$result_seBilling['EMPLOYEECODE1']."'
            AND ( DOCUMENTCODE IS NOT NULL OR DOCUMENTCODE != '')
            AND CONVERT(DATE,DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103) 
            ORDER BY JOBNO DESC";
          $params_seRownumchk3  = array();
          $query_seRownumchk3   = sqlsrv_query($conn, $sql_seRownumchk3, $params_seRownumchk3);
         while($result_seRownumchk3 = sqlsrv_fetch_array($query_seRownumchk3, SQLSRV_FETCH_ASSOC)){
          
          $sql_seDO = "SELECT TOP 1 DOCUMENTCODE 
          FROM VEHICLETRANSPORTDOCUMENTDIRVER 
          WHERE VEHICLETRANSPORTPLANID ='".$result_seRownumchk3['VEHICLETRANSPORTPLANID']."'
          ORDER BY DOCUMENTCODE DESC";
          $params_seDO = array();
          $query_seDO = sqlsrv_query($conn, $sql_seDO, $params_seDO);
          $result_seDO = sqlsrv_fetch_array($query_seDO, SQLSRV_FETCH_ASSOC);

          $sql_seCount = "SELECT COUNT(JOBNO)  AS 'COUNT'        
          FROM [dbo].[VEHICLETRANSPORTPLAN] 
          WHERE EMPLOYEECODE1 ='".$result_seBilling['EMPLOYEECODE1']."'
          AND ( DOCUMENTCODE IS NOT NULL OR DOCUMENTCODE != '')
          AND CONVERT(DATE,DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103) ";
          $params_seCount = array();
          $query_seCount  = sqlsrv_query($conn, $sql_seCount, $params_seCount);
          $result_seCount = sqlsrv_fetch_array($query_seCount, SQLSRV_FETCH_ASSOC);

            
         } 

          //เลขไมล์ต้น
          $sql_seMileageStart = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGESTART' 
            FROM [dbo].[MILEAGE] 
            WHERE JOBNO ='".$result_seBilling['JOBNO']."'
            AND MILEAGETYPE ='MILEAGESTART'
            ORDER BY CREATEDATE DESC";
          $params_seMileageStart = array();
          $query_seMileageStart = sqlsrv_query($conn, $sql_seMileageStart, $params_seMileageStart);
          $result_seMileageStart = sqlsrv_fetch_array($query_seMileageStart, SQLSRV_FETCH_ASSOC);

          //เลขไมค์ปลาย
          $sql_seMileageEnd = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGEEND' 
            FROM [dbo].[MILEAGE] 
            WHERE JOBNO ='".$result_seBilling['JOBNO']."'
            AND MILEAGETYPE ='MILEAGEEND'
            ORDER BY CREATEDATE DESC";
          $params_seMileageEnd  = array();
          $query_seMileageEnd   = sqlsrv_query($conn, $sql_seMileageEnd, $params_seMileageEnd);
          $result_seMileageEnd  = sqlsrv_fetch_array($query_seMileageEnd, SQLSRV_FETCH_ASSOC);
        
          //ค่าเที่ยว และบิลน้ำมัน
          
            $sql_seCompen = "SELECT COMPENSATION,COMPENSATION1,COMPENSATION2,COMPENSATION3,OILNUMBER
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] 
            WHERE VEHICLETRANSPORTPLANID = '".$result_seBilling['PLANID']."'
            AND (COMPENSATION IS NOT NULL OR COMPENSATION != '')
            AND (COMPENSATION1 IS NOT NULL OR COMPENSATION1 != '')
            AND (COMPENSATION2 IS NOT NULL OR COMPENSATION2 != '')
            AND (COMPENSATION3 IS NOT NULL OR COMPENSATION3 != '')
            AND (OILNUMBER IS NOT NULL OR OILNUMBER != '')";
         
          
          $params_seCompen  = array();
          $query_seCompen   = sqlsrv_query($conn, $sql_seCompen, $params_seCompen);
          $result_seCompen  = sqlsrv_fetch_array($query_seCompen, SQLSRV_FETCH_ASSOC);

          // น้ำมัน Liters
          $sql_seOillite = "SELECT O4 AS 'OIL' 
          FROM VEHICLETRANSPORTPLAN 
          WHERE VEHICLETRANSPORTPLANID ='".$result_seBilling['PLANID']."'";
          $params_seOillite = array();
          $query_seOillite  = sqlsrv_query($conn, $sql_seOillite, $params_seOillite);
          $result_seOillite = sqlsrv_fetch_array($query_seOillite, SQLSRV_FETCH_ASSOC);

            
          
         // น้ำมัน REMARK //ค่าทางด่วน จาก PAY_CONDITION
         $sql_sePayother = "SELECT PAY_OTHER AS 'PAY_OTHER'  
         FROM VEHICLETRANSPORTDOCUMENTDIRVER 
         WHERE VEHICLETRANSPORTPLANID ='".$result_seBilling['PLANID']."'
         AND PAY_OTHER IS NOT NULL 
         AND PAY_OTHER !=''";
         $params_sePayother = array();
         $query_sePayother  = sqlsrv_query($conn, $sql_sePayother, $params_sePayother);
         $result_sePayother = sqlsrv_fetch_array($query_sePayother, SQLSRV_FETCH_ASSOC);


          //เช็คแถวบนสุด
          if ($result_seBilling['ROWNUM'] == '1') {
             $thainame1 = $result_seBilling['THAINAME1'];
             $thainame2 = $result_seBilling['THAINAME2'];
             $vehicletype = $result_seBilling['VEHICLETYPE'];
             $emp1 = $result_seBilling['EMP1'];
             $emp2 = $result_seBilling['EMP2'];
             
             
             
          }else {
            $thainame1 = '';
            $thainame2 = '';
            $vehicletype = '';
            $emp1 = '';
            $emp2 = '';
            
            
          }

          //เช็คแถวล่างสุด
          if ($result_seBilling['ROWNUM'] == $result_seRownumchk2['ROWNUMCHK']) {
            $unit = '1.00';
            $incen1 = $result_seCompen['COMPENSATION1'];
            $incen2 = $result_seCompen['COMPENSATION2'];
            $fuelbill = $result_seCompen['OILNUMBER'];
            $liters   = $result_seOillite['OIL'];
            $startmile  = $result_seMileageStart['MILEAGESTART'];
            $finishmile = $result_seMileageEnd['MILEAGEEND']; 
            $payother   = $result_sePayother['PAY_OTHER'];
            $oilaverage = $result_seBilling['OILAVERAGE'];
          }else {
            $unit = '';
            $incen1 = '';
            $incen2 = '';
            $fuelbill = '';
            $liters   = '';
            $startmile  = '';
            $finishmile = '';
            $payother   = '';
            $oilaverage ='';
          }

          //เช็คลงข้อมูล TOTAL UNIT
          if ($result_seBilling['DOCUMENTCODE'] == $result_seDO['DOCUMENTCODE']) {
            $totalunit = number_format($result_seCount['COUNT'],2);
          }else {
            $totalunit = '';
          }

          ?>
          <tr>
              <!-- NO -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$i?></td>
              <!-- ///TRUCKNO1/// -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$thainame1?></td>
              <!-- ///TRUCKNO2/// -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$thainame2?></td>
              <!-- ///VEHICLETYPE/// -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$vehicletype?></td>
              <!-- DRIVER1  -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$emp1?></td>
              <!-- DRIVER2  -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$emp2?></td>
              <!-- FROM -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['JOBSTART']?></td>
              <!-- TO -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['JOBEND']?></td>
               <!-- DOCUMENTCODE -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['DOCUMENTCODE']?></td>
              <!-- ///TRIPAMOUNT (ENGINE) -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['TRIPAMOUNT']?></td>
              <!-- UNIT -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$unit?></td>
              <!-- TOTAL UNIT -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$totalunit?></td>
              <!-- START EXPRESS WAY -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$payother?></td>
              <!-- FINISH EXPRESS WAY -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"></td>
              <!-- INCENTIVE1 -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$incen1?></td>
              <!-- INCENTIVE2 -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$incen2?></td>
              <!-- Fuel Bill -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$fuelbill?></td>
              <!-- STARTMILE -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$startmile?></td>
              <!-- FINISHMILE -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$finishmile?></td>
              <!-- Lites -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$liters?></td>
               <!-- REMARK -->
               <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$oilaverage?></td>
              <td    style="border:1px solid #000;padding:4px;text-align:center"></td> 
              
            </tr>
            <?php
            $i++;
          }
          ?>
        </table>
    <?php
  }else {
    ?>
    <table  style="border-collapse: collapse;margin-top:8px;font-size:14px" width="30%"  >
      <label><b>Vantruck for checking</b></label>
    </table>
          <br><br>

          <table   style="border-collapse: collapse;margin-top:8px;font-size:14px" width="100%">

            <tr>
              <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center">NO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">DRIVER.1</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">DRIVER.2</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">DO/PO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Engine</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">TOTAL UNIT</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Start Expressway</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Finish Expressway</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Incentive Dri1</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Incentive Dri2</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Fuel bill number</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Start mile</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Finish  mile</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">Liters</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">ค่าน้ำมัน</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>


            <?php
            $i = 1;

            if ($_GET['customercode']  == 'TMT') {

              $sql_seBilling = "SELECT a.OILAVERAGE,b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
              a.EMPLOYEENAME2 AS 'EMP2',a.JOBSTART AS 'JOBSTART', a.JOBEND AS 'JOBEND', a.DOCUMENTCODE ,b.ROUNDAMOUNT AS 'ROUND'
              ,LEFT(b.ROUNDAMOUNT,PATINDEX('%[^0-9]%',b.ROUNDAMOUNT)-1) AS 'Numerics',a.VEHICLETRANSPORTPLANID AS 'PLANID',a.TRIPAMOUNT,a.EMPLOYEECODE1
              ,ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,a.VEHICLETRANSPORTPLANID ORDER BY a.EMPLOYEENAME1,a.DOCUMENTCODE ASC) AS 'ROWNUM'
              FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
              INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
              LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
              
              WHERE a.ACTIVESTATUS = 1
              AND a.COMPANYCODE='RKS' AND a.CUSTOMERCODE='TMT'
              AND a.DOCUMENTCODE IS NOT NULL
              AND a.DOCUMENTCODE !=''
              AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
              AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
                            
              GROUP BY a.OILAVERAGE,b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1,a.EMPLOYEENAME2,a.TRIPAMOUNT,a.EMPLOYEECODE1, a.JOBSTART,a.JOBEND,a.DOCUMENTCODE
              ,b.ROUNDAMOUNT,a.VEHICLETRANSPORTPLANID
              ORDER BY a.EMPLOYEENAME1,b.JOBNO,a.DOCUMENTCODE ASC";

              $params_seBilling = array();
              $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);

            }else if ($_GET['customercode'] == 'STM') {
              $sql_seBilling = "SELECT a.OILAVERAGE,b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
              a.EMPLOYEENAME2 AS 'EMP2',a.JOBSTART AS 'JOBSTART', a.JOBEND AS 'JOBEND',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
              c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
              ,b.VEHICLETRANSPORTPLANID AS 'PLANID',c.ROUTEDESCRIPTION AS 'DENSOTO',a.DOCUMENTCODE AS 'DOCUMENTCODE'
              ,SUBSTRING(b.ROUNDAMOUNT, 1, 3)  AS 'ROUND',ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,a.VEHICLETRANSPORTPLANID ORDER BY a.EMPLOYEENAME1,a.DOCUMENTCODE ASC) AS 'ROWNUM'
              FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
              INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
              LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
              
              WHERE a.ACTIVESTATUS = 1
              AND a.COMPANYCODE='RKS' AND a.CUSTOMERCODE='STM'
              AND a.DOCUMENTCODE IS NOT NULL
              AND a.DOCUMENTCODE !=''
              AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
              AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
              
              ORDER BY JOBSTART,SUBSTRING(b.ROUNDAMOUNT, 3, 3) ASC";
              $params_seBilling = array();
              $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
            }else {
              $sql_seBilling = "SELECT a.OILAVERAGE,b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
              a.EMPLOYEENAME2 AS 'EMP2',a.JOBSTART AS 'JOBSTART', a.JOBEND AS 'JOBEND',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
              c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
              ,b.VEHICLETRANSPORTPLANID AS 'PLANID',c.ROUTEDESCRIPTION AS 'DENSOTO',a.DOCUMENTCODE AS 'DOCUMENTCODE'
              ,ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,a.VEHICLETRANSPORTPLANID ORDER BY a.EMPLOYEENAME1,a.DOCUMENTCODE ASC) AS 'ROWNUM'
              FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
              INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
              LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
      
              WHERE a.ACTIVESTATUS = 1
              AND a.COMPANYCODE='".$_GET['companycode']."' AND a.CUSTOMERCODE='".$_GET['customercode']."'
              AND a.DOCUMENTCODE IS NOT NULL
              AND a.DOCUMENTCODE !=''
              AND a.DOCUMENTCODE !='LOAD'
              AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
              AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
              
              ORDER BY a.EMPLOYEENAME1 ASC";
              $params_seBilling = array();
              $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
            }
            while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                
                
               
                
            ////////////////////////////////////////////////////////////////////////////////////////////////
            if ($_GET['companycode'] == 'RKS' && $_GET['customercode'] == 'STM') {
              $sql_seTripamount = "SELECT LEFT(a.ROUNDAMOUNT,PATINDEX('%[^0-9]%',a.ROUNDAMOUNT)-1) AS 'TRIPAMOUNT'
                                   , SUBSTRING(a.JOBSTART, 21, 4)  AS 'JOBSTART',SUBSTRING(a.ROUNDAMOUNT, 2, 2)  AS 'ROUND'

                                   FROM [dbo].[VEHICLETRANSPORTPLAN] a
                                   WHERE a.ROUNDAMOUNT IS NOT NULL AND a.VEHICLETRANSPORTPLANID = '" . $result_seBilling['PLANID'] . "'";
              $query_seTripamount = sqlsrv_query($conn, $sql_seTripamount, $params_seTripamount);
              $result_seTripamount = sqlsrv_fetch_array($query_seTripamount, SQLSRV_FETCH_ASSOC);
            }else {
              // code...
            }

            //เช็คแถวล่างสุดตาม PLANID
          $sql_seRownumchk2 = "SELECT MAX(a.ROWNUM) AS 'ROWNUMCHK' FROM (
            SELECT b.JOBNO AS 'JOBNO',a.EMPLOYEENAME1
            ,b.VEHICLETRANSPORTPLANID AS 'PLANID',a.DOCUMENTCODE,a.JOBEND
            ,ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1,a.VEHICLETRANSPORTPLANID ORDER BY a.EMPLOYEENAME1 ASC) AS 'ROWNUM'
            
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
            LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
            
            WHERE a.VEHICLETRANSPORTPLANID ='".$result_seBilling['PLANID']."'    
            GROUP BY b.JOBNO,b.VEHICLETRANSPORTPLANID,a.VEHICLETRANSPORTPLANID,a.EMPLOYEENAME1,a.JOBEND,a.DOCUMENTCODE ) a";
          $params_seRownumchk2  = array();
          $query_seRownumchk2   = sqlsrv_query($conn, $sql_seRownumchk2, $params_seRownumchk2);
          $result_seRownumchk2  = sqlsrv_fetch_array($query_seRownumchk2, SQLSRV_FETCH_ASSOC);

          


          //เช็คแถวล่างสุดตาม EMPLOYEECODE
          $sql_seRownumchk3 = "SELECT TOP 1 JOBNO,VEHICLETRANSPORTPLANID                   
            FROM [dbo].[VEHICLETRANSPORTPLAN] 
            WHERE EMPLOYEECODE1 ='".$result_seBilling['EMPLOYEECODE1']."'
            AND ( DOCUMENTCODE IS NOT NULL OR DOCUMENTCODE != '')
            AND CONVERT(DATE,DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103) 
            ORDER BY JOBNO DESC";
          $params_seRownumchk3  = array();
          $query_seRownumchk3   = sqlsrv_query($conn, $sql_seRownumchk3, $params_seRownumchk3);
         while($result_seRownumchk3 = sqlsrv_fetch_array($query_seRownumchk3, SQLSRV_FETCH_ASSOC)){
          
          $sql_seDO = "SELECT TOP 1 DOCUMENTCODE 
          FROM VEHICLETRANSPORTDOCUMENTDIRVER 
          WHERE VEHICLETRANSPORTPLANID ='".$result_seRownumchk3['VEHICLETRANSPORTPLANID']."'
          ORDER BY DOCUMENTCODE DESC";
          $params_seDO  = array();
          $query_seDO   = sqlsrv_query($conn, $sql_seDO, $params_seDO);
          $result_seDO  = sqlsrv_fetch_array($query_seDO, SQLSRV_FETCH_ASSOC);

          $sql_seCount = "SELECT COUNT(JOBNO)  AS 'COUNT'        
          FROM [dbo].[VEHICLETRANSPORTPLAN] 
          WHERE EMPLOYEECODE1 ='".$result_seBilling['EMPLOYEECODE1']."'
          AND ( DOCUMENTCODE IS NOT NULL OR DOCUMENTCODE != '')
          AND CONVERT(DATE,DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103) ";
          $params_seCount = array();
          $query_seCount  = sqlsrv_query($conn, $sql_seCount, $params_seCount);
          $result_seCount = sqlsrv_fetch_array($query_seCount, SQLSRV_FETCH_ASSOC);

            
         } 

          //เลขไมล์ต้น
          $sql_seMileageStart = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGESTART' 
            FROM [dbo].[MILEAGE] 
            WHERE JOBNO ='".$result_seBilling['JOBNO']."'
            AND MILEAGETYPE ='MILEAGESTART'
            ORDER BY CREATEDATE DESC";
          $params_seMileageStart = array();
          $query_seMileageStart = sqlsrv_query($conn, $sql_seMileageStart, $params_seMileageStart);
          $result_seMileageStart = sqlsrv_fetch_array($query_seMileageStart, SQLSRV_FETCH_ASSOC);

          //เลขไมค์ปลาย
          $sql_seMileageEnd = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGEEND' 
            FROM [dbo].[MILEAGE] 
            WHERE JOBNO ='".$result_seBilling['JOBNO']."'
            AND MILEAGETYPE ='MILEAGEEND'
            ORDER BY CREATEDATE DESC";
          $params_seMileageEnd  = array();
          $query_seMileageEnd   = sqlsrv_query($conn, $sql_seMileageEnd, $params_seMileageEnd);
          $result_seMileageEnd  = sqlsrv_fetch_array($query_seMileageEnd, SQLSRV_FETCH_ASSOC);
        
          //ค่าเที่ยว และบิลน้ำมัน
          if ($_GET['companycode'] == 'RKS' && $_GET['customercode'] == 'STM') {
            $sql_seCompen = "SELECT COMPENSATION,COMPENSATION1,COMPENSATION2,COMPENSATION3,OILNUMBER
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] 
            WHERE VEHICLETRANSPORTPLANID = '".$result_seBilling['PLANID']."'
            AND (COMPENSATION IS NOT NULL OR COMPENSATION != '')
            AND (COMPENSATION1 IS NOT NULL OR COMPENSATION1 != '')
            AND (COMPENSATION2 IS NOT NULL OR COMPENSATION2 != '')
            AND (COMPENSATION3 IS NOT NULL OR COMPENSATION3 != '')";
          }else {
            $sql_seCompen = "SELECT COMPENSATION,COMPENSATION1,COMPENSATION2,COMPENSATION3,OILNUMBER
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] 
            WHERE VEHICLETRANSPORTPLANID = '".$result_seBilling['PLANID']."'
            AND (COMPENSATION IS NOT NULL OR COMPENSATION != '')
            AND (COMPENSATION1 IS NOT NULL OR COMPENSATION1 != '')
            AND (COMPENSATION2 IS NOT NULL OR COMPENSATION2 != '')
            AND (COMPENSATION3 IS NOT NULL OR COMPENSATION3 != '')
            AND (OILNUMBER IS NOT NULL OR OILNUMBER != '')";
          }
          
          $params_seCompen  = array();
          $query_seCompen   = sqlsrv_query($conn, $sql_seCompen, $params_seCompen);
          $result_seCompen  = sqlsrv_fetch_array($query_seCompen, SQLSRV_FETCH_ASSOC);

          // น้ำมัน Liters
          $sql_seOillite = "SELECT O4 AS 'OIL' 
          FROM VEHICLETRANSPORTPLAN 
          WHERE VEHICLETRANSPORTPLANID ='".$result_seBilling['PLANID']."'";
          $params_seOillite = array();
          $query_seOillite  = sqlsrv_query($conn, $sql_seOillite, $params_seOillite);
          $result_seOillite = sqlsrv_fetch_array($query_seOillite, SQLSRV_FETCH_ASSOC);

            //คิดค่าเที่ยวขาไป
            $sql_seExpresswaygo = "SELECT 
            SUM(DISTINCT CONVERT(INT,PAY_EXPRESSWAY15))+
            SUM(DISTINCT CONVERT(INT,PAY_EXPRESSWAY25))+
            SUM(DISTINCT CONVERT(INT,PAY_EXPRESSWAY45))+
            SUM(DISTINCT CONVERT(INT,PAY_EXPRESSWAY50))+
            SUM(DISTINCT CONVERT(INT,PAY_EXPRESSWAY55))+
            SUM(DISTINCT CONVERT(INT,PAY_EXPRESSWAY65))+
            SUM(DISTINCT CONVERT(INT,PAY_EXPRESSWAY75))+
            SUM(DISTINCT CONVERT(INT,PAY_EXPRESSWAY100))+
            SUM(DISTINCT CONVERT(INT,PAY_EXPRESSWAY195)) AS 'SUMEXPRESSWAYGO'
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
            WHERE a.VEHICLETRANSPORTPLANID = '".$result_seBilling['PLANID']."'";
            $query_seExpresswaygo   = sqlsrv_query($conn, $sql_seExpresswaygo, $params_seExpresswaygo);
            $result_seExpresswaygo  = sqlsrv_fetch_array($query_seExpresswaygo, SQLSRV_FETCH_ASSOC);

            //คิดค่าเที่ยวขากลับ
            $sql_seExpresswayreturn = "SELECT 
                SUM(DISTINCT CONVERT(INT,PAY_EXPRESSWAY45RETURN))+
                SUM(DISTINCT CONVERT(INT,PAY_EXPRESSWAY50RETURN))+
                SUM(DISTINCT CONVERT(INT,PAY_EXPRESSWAY65RETURN))+
                SUM(DISTINCT CONVERT(INT,PAY_EXPRESSWAY105RETURN))
                AS 'SUMEXPRESSWAYRETURN'
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
            WHERE a.VEHICLETRANSPORTPLANID = '".$result_seBilling['PLANID']."'";
            $query_seExpresswayreturn = sqlsrv_query($conn, $sql_seExpresswayreturn, $params_seExpresswayreturn);
            $result_seExpresswayreturn = sqlsrv_fetch_array($query_seExpresswayreturn, SQLSRV_FETCH_ASSOC);
          
          //เช็คแถวบนสุด
          if ($result_seBilling['ROWNUM'] == '1') {
            $thainame = $result_seBilling['THAINAME'];
            
              if ($_GET['companycode'] == 'RKS') {
                if($_GET['customercode'] == 'SWN'){
                  $vehicletype = '10W(Van)';
                }else{
                  $vehicletype = $result_seBilling['VEHICLETYPE'];
                }
              }else{
               
              }

             $emp1 = $result_seBilling['EMP1'];
             $emp2 = $result_seBilling['EMP2'];
             $startmile = $result_seMileageStart['MILEAGESTART'];
             $finishmile = $result_seMileageEnd['MILEAGEEND'];
             
             
          }else {
            $thainame = '';
            $vehicletype = '';
            $emp1 = '';
            $emp2 = '';
            $startmile = '';
            $finishmile = '';
            
          }

          //เช็คแถวล่างสุด
          if ($result_seBilling['ROWNUM'] == $result_seRownumchk2['ROWNUMCHK']) {
            $unit = '1.00';
            $incen1 = $result_seCompen['COMPENSATION1'];
            $incen2 = $result_seCompen['COMPENSATION2'];
            $fuelbill = $result_seCompen['OILNUMBER'];
            $liters = $result_seOillite['OIL'];
            $expresswaygo = $result_seExpresswaygo['SUMEXPRESSWAYGO'];
            $expresswayreturn = $result_seExpresswaygo['SUMEXPRESSWAYRETURN']; 
            $oilaverage=$result_seBilling['OILAVERAGE'];
          }else {
            $unit = '';
            $incen1 = '';
            $incen2 = '';
            $fuelbill = '';
            $liters = '';
            $expresswaygo = '';
            $expresswayreturn = '';
            $oilaverage='';
          }

          //เช็คลงข้อมูล TOTAL UNIT
          if ($result_seBilling['DOCUMENTCODE'] == $result_seDO['DOCUMENTCODE']) {
            $totalunit = number_format($result_seCount['COUNT'],2);
          }else {
            $totalunit = '';
          }

          ?>
          <tr>
              <!-- NO -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$i?></td>
              <!-- ///TRUCKNO/// -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$thainame?></td>
              <!-- ///VEHICLETYPE/// -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$vehicletype?></td>
              <!-- DRIVER1  -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$emp1?></td>
              <!-- DRIVER2  -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$emp2?></td>
              
              
              
              <!-- //////////FROM//////// -->
              <?php
                if ($_GET['companycode'] == 'RKS') {
                    if ($_GET['customercode'] == 'TAW') {
                      ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center">STM</td>
                      <?php
                    }else if ($_GET['customercode'] == 'STM') {
                      ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center">STM</td>
                      <?php
                    }else if ($_GET['customercode'] == 'DAIKI') {
                      ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center">DAIKI1</td>
                      <?php
                    }else if ($_GET['customercode'] == 'TGT') {
                      if ($result_seBilling['JOBSTART'] == 'TGT1 (Amatanakorn IE.)') {
                        $jobstart = 'TGT#1';
                      }else if ($result_seBilling['JOBSTART'] == 'TGT2 (Amatanakorn IE.)') {
                        $jobstart = 'TGT#2';
                      }else if ($result_seBilling['JOBSTART'] == 'TGT3 (Amatanakorn IE.)') {
                        $jobstart = 'TGT#3';
                      }else if ($result_seBilling['JOBSTART'] == 'TGT3+TGT1 (Amatanakorn IE.)') {
                        $jobstart = 'TGT#3+1';
                      }else if ($result_seBilling['JOBSTART'] == 'TGT2+TGT3 (Amatanakorn IE.)') {
                        $jobstart = 'TGT#2+3';
                      }else  {
                        $jobstart = $result_seBilling['JOBSTART'];
                      }

                      ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$jobstart?></td>
                      <?php
                    }else if ($_GET['customercode'] == 'TMT') {
                      ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center">STM</td>
                      <?php
                    }else if ($_GET['customercode'] == 'DENSO-THAI') {
                      ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center">DITH</td>
                      <?php
                    }else {
                      ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['JOBSTART']?></td>
                      <?php
                    }
                    ?>
                    <?php
                }else {
                    ?>
                    <?php
                }

               ?>
              <!-- TO -->
              <?php
                if ($_GET['companycode'] == 'RKS') {
                    if ($_GET['customercode'] == 'TAW') {
                      ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center">TAW</td>
                      <?php
                    }else if ($_GET['customercode'] == 'STM') {
                      ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center">STM</td>
                      <?php
                    }else if ($_GET['customercode'] == 'DAIKI') {
                      ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center">DITH-C(B1)</td>
                      <?php
                    }else if ($_GET['customercode'] == 'TGT') {
                      ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['JOBEND']?></td>
                      <?php
                    }else if ($_GET['customercode'] == 'TMT') {
                      ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center">TMT</td>
                      <?php
                    }else if ($_GET['customercode'] == 'DENSO-THAI') {
                      ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling['DENSOTO']?></td>
                      <?php
                    }else {
                      ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['JOBEND']?></td>
                      <?php
                    }
                    ?>
                    <?php
                }else {
                    ?>
                    <?php
                }

               ?>
               <!-- DOCUMENTCODE -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['DOCUMENTCODE']?></td>
              <!-- ///TRIPAMOUNT (ENGINE) -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['TRIPAMOUNT']?></td>
              <!-- UNIT -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$unit?></td>
              <!-- TOTAL UNIT -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$totalunit?></td>
              <!-- START EXPRESS WAY -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$expresswaygo?></td>
              <!-- FINISH EXPRESS WAY -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$expresswayreturn?></td>
              <!-- INCENTIVE1 -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$incen1?></td>
              <!-- INCENTIVE2 -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$incen2?></td>
              <!-- Fuel Bill -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$fuelbill?></td>
              <!-- STARTMILE -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$startmile?></td>
              <!-- FINISHMILE -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$finishmile?></td>
              <!-- Lites -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$liters?></td>
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$oilaverage?></td>
              
               <!-- REMARK -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$incen2?></td> 
              
            </tr>
            <?php
            $i++;
          }
          ?>
        </table>
    <?php
  }
 ?>

    
    </body>
</html>