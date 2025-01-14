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


$strExcelFileName = "ใบปะหน้าบริษัท".$_GET['companycode']."(".$_GET['customercode'].")".$_GET['datestart'].".xls";

header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");




// $excel = new PHPExcel();
// header('Content-Type: application/vnd.ms-excel');
// header('Content-Disposition: attachment;filename="your_name.xls"');
// header('Cache-Control: max-age=0');  
//
// $excel->setActiveSheetIndex(0)
//         ->setCellValue('A1', 'Hello')
//         ->setCellValue('B2', 'world!')
//         ->setCellValue('C1', 'Hello')
//         ->setCellValue('D2', 'world!');
//
// $objDrawing = new PHPExcel_Worksheet_Drawing();
// $objDrawing->setName('Logo');
// $objDrawing->setDescription('Logo');
// $logo = 'images/logo.png'; // Provide path to your logo file
// $objDrawing->setPath($logo);  //setOffsetY has no effect
// $objDrawing->setCoordinates('E1');
// $objDrawing->setHeight(200); // logo height
// $objDrawing->setWorksheet($excel->getActiveSheet());







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
<?php
  if ($_GET['companycode'] == 'RKR' || $_GET['companycode'] == 'RKL') {
    ?>
    <table  style="border-collapse: collapse;margin-top:8px;font-size:14px" width="30%"  >
      <label><b>Delivery Summary For Open Truck</b></label>
      <tr>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><b>Date</b></td>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><b>Month</td>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><b>Year</td>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><b>Customer</b></td>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><b>Issued by</b></td>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><b>Checked by</b></td>
        <tr>
          <?php
          $date  = $_GET['datestart'];
          $dateplit = explode("/", $date);
          // echo $dateplit[0]; echo '<br>';
          // echo $dateplit[1]; echo '<br>';
          // echo $dateplit[2]; echo '<br>';
          $year=(date("Y")+543);
          // echo $year;
          // echo $jobendsplit[3]; echo '<br>';



           ?>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><?=$dateplit[0];?></td>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><?=$dateplit[1];?></td>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><?=  $year=(date("Y")+543);?></td>
            <?php
            if ($_GET['customercode'] == 'TTASTSTC') {
            ?>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center">STC-<?=$_GET['companycode']?> </td>
            <?php
          }else if ($_GET['customercode'] == 'TTASTCS') {
            ?>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center">TTAST-<?=$_GET['companycode']?> </td>
            <?php
            }else {
            ?>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><?=$_GET['customercode']?> </td>
            <?php
            }
             ?>

            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"></td>
            <td     style="width: 5%; border:1px solid #000;padding:4px;text-align:center"></td>
      </tr>


          </table>
          <br><br><br>

          <table   style="border-collapse: collapse;margin-top:8px;font-size:16px" width="100%"  >

            <?php
             if ($_GET['customercode'] == 'TTASTCS') {
              ?>
                <tr>
                  <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center">NO</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">DATE</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">FIRSTDRIVER</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">TO</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">ZONE</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">WEIGHT(TON)</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">CHARGE</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">ACTUAL</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
                </tr>
              <?php
             }else {
               ?>
                <tr>
                  <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center">NO</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">FIRSTDRIVER</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">TO</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">ZONE</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">WEIGHT(TON)</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">CHARGE</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">ACTUAL</td>
                  <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
                </tr>
               <?php
             }
            
            
            ?>
            


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
            }else if ($_GET['customercode'] == 'COPPERCORD') {
              $customercode = 'COPPERCORD';
            }else if ($_GET['customercode'] == 'RNSTEEL') {
              $customercode = 'RNSTEEL';
            }else if ($_GET['customercode'] == 'VUTEQ') {
              $customercode = 'VUTEQ';
            }else if ($_GET['customercode'] == 'PJW') {
              $customercode = 'PJW';
            }else {
              $customercode = '';
              $from  = '';
            }

            if ( $_GET['customercode'] == 'TTASTSTC' || $_GET['customercode'] == 'PARAGON'|| $_GET['customercode'] == 'TTPROSTC') {
              $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',a.JOBSTART AS 'JOBSTART',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
              a.JOBEND AS 'JOBEND',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
              c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
              ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE,b.C8
              ,ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM'

              FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
              INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
              LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID

              WHERE a.ACTIVESTATUS = 1
              AND a.COMPANYCODE='" .$_GET['companycode'] ."' AND a.CUSTOMERCODE='".$customercode."'
              AND b.JOBSTART ='".$jobstart."'
              AND a.DOCUMENTCODE IS NOT NULL
              AND a.DOCUMENTCODE !=''
              AND a.WEIGHTIN IS NOT NULL
              AND a.WEIGHTIN !=''
              AND a.WEIGHTIN !='0' AND a.WEIGHTIN !='-'
              AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
              AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
              
              GROUP BY b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1, a.JOBEND,a.JOBSTART,b.VEHICLETRANSPORTPRICEID,
              c.VEHICLETRANSPORTPRICEID,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE,b.C8
              ORDER BY a.EMPLOYEENAME1,b.JOBNO ASC";
              $params_seBilling = array();
              $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
            }else if ($_GET['customercode'] == 'TTASTCS') {
              $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
              a.JOBEND AS 'JOBEND',a.JOBSTART AS 'JOBSTART',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
              c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
              ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE,b.C8
              ,ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM'
              ,CONVERT(VARCHAR(10), b.DATEWORKING, 103) AS 'DATE'
              FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
              INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
              LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID

              WHERE a.ACTIVESTATUS = 1
              AND a.COMPANYCODE='" .$_GET['companycode'] ."' AND a.CUSTOMERCODE='".$customercode."'
              AND b.JOBSTART ='".$jobstart."'
              AND a.DOCUMENTCODE IS NOT NULL
              AND a.DOCUMENTCODE !=''
              AND a.WEIGHTIN IS NOT NULL
              AND a.WEIGHTIN !=''
              AND a.WEIGHTIN !='0' AND a.WEIGHTIN !='-'
              AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
              AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
              
              GROUP BY b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1, a.JOBEND,a.JOBSTART,b.VEHICLETRANSPORTPRICEID,c.VEHICLETRANSPORTPRICEID
              ,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE,b.C8,b.DATEWORKING
              ORDER BY b.DATEWORKING,a.EMPLOYEENAME1,b.JOBNO ASC";
              $params_seBilling = array();
              $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
            }else if ($_GET['customercode'] == 'TTTCSTC') {
              $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
              a.JOBEND AS 'JOBEND',a.JOBSTART AS 'JOBSTART',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
              c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
              ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE
              ,ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM'
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
              
              GROUP BY b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1, a.JOBEND,a.JOBSTART,b.VEHICLETRANSPORTPRICEID,
              c.VEHICLETRANSPORTPRICEID,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE
              ORDER BY a.EMPLOYEENAME1,b.JOBNO ASC";
              $params_seBilling = array();
              $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
            }else if ($_GET['customercode'] == 'TTAST' && $_GET['carrytype'] == 'weight') {
              // งาน TTAST Other Trip  งานต้นทาง KIT1,KIT2 น้ำหนักลงข้อมูลเป็นทศนิยม
              $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
              a.JOBEND AS 'JOBEND',a.JOBSTART AS 'JOBSTART',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
              c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
              ,SUM( CONVERT(DECIMAL(18,3), a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE
              ,ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM'
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
              
              GROUP BY b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1, a.JOBEND,a.JOBSTART,b.VEHICLETRANSPORTPRICEID,c.VEHICLETRANSPORTPRICEID
              ,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE
              ORDER BY a.EMPLOYEENAME1,b.JOBNO ASC";
              $params_seBilling = array();
              $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
            }else if ($_GET['customercode'] == 'TTAST' && $_GET['carrytype'] == 'trip') {
              $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
              a.JOBEND AS 'JOBEND',a.JOBSTART AS 'JOBSTART',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
              c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
              ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE
              ,ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM'
              FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
              INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
              LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
      
              WHERE a.ACTIVESTATUS = 1
              AND a.COMPANYCODE='".$_GET['companycode']."' AND a.CUSTOMERCODE='".$customercode."'
              AND a.DOCUMENTCODE IS NOT NULL
              AND a.DOCUMENTCODE !=''
              AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
              AND c.CARRYTYPE ='trip'
              AND b.WORKTYPE = 'other'
              AND a.WEIGHTIN NOT LIKE '%.%'
              AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
              
              GROUP BY b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1, a.JOBEND,a.JOBSTART,b.VEHICLETRANSPORTPRICEID,c.VEHICLETRANSPORTPRICEID
              ,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE
              ORDER BY a.EMPLOYEENAME1,b.JOBNO ASC";
              $params_seBilling = array();
              $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
            }else if ($_GET['customercode'] == 'VUTEQ' && $_GET['carrytype'] == 'trip') {
              $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
              a.JOBEND AS 'JOBEND',a.JOBSTART AS 'JOBSTART',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
              c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
              ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE
              ,ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM'
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
              
              GROUP BY b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1, a.JOBEND,a.JOBSTART,b.VEHICLETRANSPORTPRICEID,c.VEHICLETRANSPORTPRICEID
              ,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE
              ORDER BY a.EMPLOYEENAME1,b.JOBNO ASC";
              $params_seBilling = array();
              $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
            }else if ($_GET['customercode'] == 'DAIKI') {
              $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
              a.JOBEND AS 'JOBEND',a.JOBSTART AS 'JOBSTART',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
              c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
              ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE
              ,ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM'
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
              
              GROUP BY b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1, a.JOBEND,a.JOBSTART,b.VEHICLETRANSPORTPRICEID,
              c.VEHICLETRANSPORTPRICEID,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE
              ORDER BY a.EMPLOYEENAME1,b.JOBNO ASC";
              $params_seBilling = array();
              $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
            }else {
              $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
              a.JOBSTART AS 'JOBSTART',a.JOBEND AS 'JOBEND',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
              c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
              ,SUM( CONVERT(INT, a.WEIGHTIN)) AS 'WEISUM',b.VEHICLETRANSPORTPLANID AS 'PLANID',c.CARRYTYPE
              ,ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM'

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
              
              GROUP BY b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1, a.JOBEND,a.JOBSTART ,b.VEHICLETRANSPORTPRICEID,
              c.VEHICLETRANSPORTPRICEID,c.[LOCATION],b.CLUSTER,c.PRICE,b.VEHICLETRANSPORTPLANID,c.CARRYTYPE
              ORDER BY a.EMPLOYEENAME1,b.JOBNO ASC";
              $params_seBilling = array();
              $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
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
                $query_sePrice = sqlsrv_query($conn, $sql_sePrice, $params_sePrice);
                $result_sePrice = sqlsrv_fetch_array($query_sePrice, SQLSRV_FETCH_ASSOC);
              }else {
                $sql_sePrice = "SELECT PRICE AS 'PRICEAC',[LOCATION] AS 'LOCATION' FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE ACTIVESTATUS = 1
                AND COMPANYCODE='" . $_GET['companycode'] . "' AND CUSTOMERCODE='".$customercode."'
                AND PRICE IS NOT NULL  AND [FROM]='" . $result_seBilling['JOBSTART'] . "' AND [TO] = '" . $result_seBilling['JOBEND'] . "'
                AND CONVERT(DATE,GETDATE()) BETWEEN CONVERT(DATE,STARTDATE) AND CONVERT(DATE,ENDDATE)";
                $params_sePrice = array();
                $query_sePrice = sqlsrv_query($conn, $sql_sePrice, $params_sePrice);
                $result_sePrice = sqlsrv_fetch_array($query_sePrice, SQLSRV_FETCH_ASSOC);
              }

            /////////คิดชาท10,ชาท7,ไม่คิดขั้นต่ำ
            $sql_seID = "SELECT  DISTINCT REMARK, REMARKHEAD,JOBEND,VEHICLETRANSPORTPLANID FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER]
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
            $params_seLocation = array();
            $query_seLocation = sqlsrv_query($conn, $sql_seLocation, $params_seLocation);
            $result_seLocation = sqlsrv_fetch_array($query_seLocation, SQLSRV_FETCH_ASSOC);

                ///////////////////////////////////////////
              if ($result_seBilling['C8'] == 'return') {
                $C8 = 'งานรับกลับ';
              }else {
                $C8 = '';
              }
                  /////////////////////////////////ZONE////////////////////////////////////////////////////////////
                  if ($result_seLocation['LOCATION'] == 'พระประแดง/สำโรง' || $result_seLocation['LOCATION'] == 'สำโรง') {
                    $zone ="Samrong";
                  } else if ($result_seLocation['LOCATION'] == 'บางพลี') {
                    $zone ="Bangplee";
                  } else if ($result_seLocation['LOCATION'] == 'เทพารักษ์') {
                    if ($result_seLocation['JOBEND'] == 'HINO2') {
                     $zone ="Bangplee";
                    }else {
                     $zone ="Thepharak";
                    }

                  } else if ($result_seLocation['LOCATION'] == 'ลาดกระบัง') {
                    $zone ="Ladkrabang";
                  } else if ($result_seLocation['LOCATION'] == 'บางประกง') {
                    if ($result_seLocation['JOBEND'] == 'REFORM') {
                      $zone ="Wellgrow";
                    }else if ($result_seLocation['JOBEND'] == 'TOY') {
                      $zone ="Banpho";
                    }else {
                      $zone ="Bang Pakong";
                    }

                  } else if ($result_seLocation['LOCATION'] == 'บ้านโพธิ์') {

                      $zone ="Banpho";

                  } else if ($result_seLocation['LOCATION'] == 'แปลงยาว') {
                    if ($result_seLocation['JOBEND'] == 'NB-WOOD') {
                      $zone ="Phanat Nikhom";

                    }else {
                      $zone ="Gateway";
                    }

                  } else if ($result_seLocation['LOCATION'] == 'บ้านบึง') {
                    $zone ="Banbung";
                  } else if ($result_seLocation['LOCATION'] == 'ศรีราชา') {
                    $zone ="Sriracha";
                  } else if ($result_seLocation['LOCATION'] == 'ปลวกแดง') {
                    if ($result_seLocation['JOBEND'] == 'AHT2' || $result_seLocation['JOBEND'] == 'BHKT' || $result_seLocation['JOBEND'] == 'TBFST' || $result_seLocation['JOBEND'] == 'TBFST(BOI)') {
                      $zone ="Eastern Seaboard IE.";
                    }else if($result_seLocation['JOBEND'] == 'ALS') {
                      $zone ="Borwin";
                    }else {
                      $zone ="Rayong";
                    }

                  } else if ($result_seLocation['LOCATION'] == 'อมตะนคร') {
                    $zone ="Amatanakorn";
                  } else if ($result_seLocation['LOCATION'] == 'บางปะอิน') {
                    $zone ="Ayutthaya";
                  } else if ($result_seLocation['LOCATION'] == 'กระทุ่มแบน') {
                    $zone ="Samutsakorn";
                  }else if ($result_seLocation['LOCATION'] == 'เทพารักษ์') {
                    $zone ="Samutsakorn";
                  }else if ($result_seLocation['LOCATION'] == 'กบินบุรี') {
                    if ($result_seLocation['JOBEND'] == 'HISADA') {
                      $zone ="Prachin Buri";
                    }else {
                      $zone ="Kabinburi";
                    }

                  }else if ($result_seLocation['LOCATION'] == 'บางบ่อ/บางพลี') {
                    if ($result_seLocation['JOBEND'] == 'SIMA') {
                      $zone ="Bangplee";
                    }else {
                      $zone ="Bang-bo";
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
                    if ($result_seLocation['JOBEND'] == 'SSSC3' || $result_seLocation['JOBEND'] == 'SSSC3 : Easternseaboard') {
                      $zone = "Rayong";
                    }else {
                      $zone = "Eastern Seaboard IE.";
                    }
                  }else if($result_seLocation['LOCATION'] == 'ประชาอุทิศ') { 
                    $zone = "Pracha Uthid";
                  }else if($result_seLocation['LOCATION'] == 'แหลมฉบัง') { 
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
                }else if ($result_seBilling['JOBEND'] == 'VCS : Banpho') {
                  $jobend = "VCS";
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
                }else if ($result_seBilling['JOBEND'] == 'OLT') {
                  $jobend = "OLT";
                }else if ($result_seBilling['JOBEND'] == 'WWGF1 : Bangplee') {
                  $jobend = "WWG";
                }else if ($result_seBilling['JOBEND'] == 'KORAWIT : Teparak') {
                  $jobend = "KORAWIT";
                }else {
                  $jobend = $result_seBilling['JOBEND'];
                }

                    ////////////NO///////////////////////
                    if ($result_seBilling['ROWNUM'] > 1) {
                      $i--;
                      $NO = '';
                      // $date = '';
                    }else {
                      $NO = $i;
                      // $date = $result_seBilling['DATE'];
                    }


                    /////////////////from งานนอก///////////////////////

                    /////////////////from งานนอก///////////////////////

                    if ($_GET['customercode'] == 'TTASTCS') {
                      $from = 'CS Wellgrow';
                    }else if($_GET['customercode'] == 'TTASTSTC'){
                      $from  = 'STC Amatanakorn';
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
                    }else if ($_GET['customercode'] == 'COPPERCORD') {
                      $from  = $result_seBilling['JOBSTART'];
                    }else if ($_GET['customercode'] == 'RNSTEEL') {
                      $from  = $result_seBilling['JOBSTART'];
                    }else if ($_GET['customercode'] == 'VUTEQ') {
                      $from  = $result_seBilling['JOBSTART'];
                    }else if ($_GET['customercode'] == 'PJW') {
                      $from  = $result_seBilling['JOBSTART'];
                    }else {
                      $from  = '';
                    }
                    
                    $date = $result_seBilling['DATE'];
                    

              ?>
              <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$NO?></td>
              <?php
              if ($_GET['customercode'] == 'TTASTCS') {
                ?>
                <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$date?></td>
                <?php
              }else {
                ?>
                <!--<td     style="border:1px solid #000;padding:4px;text-align:center"><?//=$date?></td>-->
                <?php
              }
               ?>
              <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['THAINAME']?></td>
              <?php
              if ($_GET['companycode'] == 'RKR') {
                ?>
                <td     style="border:1px solid #000;padding:4px;text-align:center">10W(O)</td>
                <?php
              }else {
                ?>
                <td     style="border:1px solid #000;padding:4px;text-align:center">Trailer</td>
                <?php
              }
               ?>

              <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['EMP1']?></td>
              <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$from?></td>
              <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$jobend?></td>
              <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$zone?></td>
              <!-- UNIT  -->
              <?php
              if($result_seBilling['CARRYTYPE'] == 'trip' && ($_GET['customercode'] == 'TSAT' || $_GET['customercode'] == 'TTAST' || $_GET['customercode'] == 'OLT'|| $_GET['customercode'] == 'COPPERCORD')){
                ?>
                  <td   style="border:1px solid #000;padding:4px;text-align:center">1</td> 
                <?php
              }else{
                ?>
                <td     style="border:1px solid #000;padding:4px;text-align:center"></td>
                <?php 
              }
              ?>

              <td     style="border:1px solid #000;padding:4px;text-align:center"><?=$result_sePrice['PRICEAC']?></td>

              <!-- WEIGHTIN  -->
              <?php
              if($result_seBilling['CARRYTYPE'] == 'trip' && ($_GET['customercode'] == 'TSAT' || $_GET['customercode'] == 'TTAST' )){
                ?>
                  <td   style="border:1px solid #000;padding:4px;text-align:center"></td> 
                <?php
              }else{
                ?>
                  <?php
                  if ($result_seBilling['JOBSTART'] =='KIT1' || $result_seBilling['JOBSTART'] =='KIT2') {
                  ?>
                    <td     style="border:1px solid #000;padding:4px;text-align:center"><?=($result_seBilling['WEISUM']/1000)?></td>
                  <?php
                  }else{
                  ?>
                    <td     style="border:1px solid #000;padding:4px;text-align:center"><?=number_format(($result_seBilling['WEISUM']/1000),3)?></td>
                  <?php
                  }
                  ?>
                
                <?php 
              }
              ?>
              
              <!-- เงื่อนไขใหม่ -->
              <!-- คิด CHARGE -->
              <?php
              if ($result_seID['REMARK'] == 'CHARGE 12') {
                if($result_seBilling['CARRYTYPE'] == 'trip' && ($_GET['customercode'] == 'TSAT' || $_GET['customercode'] == 'TTAST' )){
                    ?>
                      <td   style="border:1px solid #000;padding:4px;text-align:center"></td> 
                    <?php
                  }else{
                    ?>
                      <?php
                      if ($result_seBilling['JOBSTART'] =='KIT1' || $result_seBilling['JOBSTART'] =='KIT2') {
                      ?>
                        <td     style="border:1px solid #000;padding:4px;text-align:center"><?=($result_seBilling['WEISUM']/1000)?></td>
                      <?php
                      }else{
                      ?>
                        <td     style="border:1px solid #000;padding:4px;text-align:center"><?=number_format((12.000-($result_seBilling['WEISUM']/1000)),3)?></td>
                      <?php
                      }
                      ?>
                    
                    <?php 
                  }
                    ?>
                
                <?php
              } if ($result_seID['REMARK'] == 'NOT CHARGE') {
                if($result_seBilling['CARRYTYPE'] == 'trip' && ($_GET['customercode'] == 'TSAT' || $_GET['customercode'] == 'TTAST' )){
                    ?>
                      <td   style="border:1px solid #000;padding:4px;text-align:center"></td> 
                    <?php
                  }else{
                    ?>

                      <?php
                      if ($result_seBilling['JOBSTART'] =='KIT1' || $result_seBilling['JOBSTART'] =='KIT2') {
                      ?>
                        <td     style="border:1px solid #000;padding:4px;text-align:center">0.000</td>
                      <?php
                      }else{
                      ?>
                        <td     style="border:1px solid #000;padding:4px;text-align:center">0.000</td>
                      <?php
                      }
                      ?>
                    
                    <?php 
                  }
                    ?>
              <?php
              }if ($result_seID['REMARK'] == 'Charge 10') {
                if($result_seBilling['CARRYTYPE'] == 'trip' && ($_GET['customercode'] == 'TSAT' || $_GET['customercode'] == 'TTAST' )){
                    ?>
                      <td   style="border:1px solid #000;padding:4px;text-align:center"></td> 
                    <?php
                  }else{
                    ?>
                      <?php
                      if ($result_seBilling['JOBSTART'] =='KIT1' || $result_seBilling['JOBSTART'] =='KIT2') {
                      ?>
                        <td     style="border:1px solid #000;padding:4px;text-align:center"><?=(10.000-($result_seBilling['WEISUM']/1000))?></td>
                      <?php
                      }else{
                      ?>
                        <td     style="border:1px solid #000;padding:4px;text-align:center"><?=number_format((10.000-($result_seBilling['WEISUM']/1000)),3)?></td>
                      <?php
                      }
                      ?>
                    
                    <?php 
                  }
                    ?>
                
                <?php
              }if ($result_seID['REMARK'] == 'Charge 7') {
                if($result_seBilling['CARRYTYPE'] == 'trip' && ($_GET['customercode'] == 'TSAT' || $_GET['customercode'] == 'TTAST' )){
                    ?>
                      <td   style="border:1px solid #000;padding:4px;text-align:center"></td> 
                    <?php
                  }else{
                    ?>
                      <?php
                      if ($result_seBilling['JOBSTART'] =='KIT1' || $result_seBilling['JOBSTART'] =='KIT2') {
                      ?>
                        <td     style="border:1px solid #000;padding:4px;text-align:center"><?=(7.000-($result_seBilling['WEISUM']/1000))?></td>
                      <?php
                      }else{
                      ?>
                        <td     style="border:1px solid #000;padding:4px;text-align:center"><?=number_format((7.000-($result_seBilling['WEISUM']/1000)),3)?></td>
                      <?php
                      }
                      ?>
                    
                    <?php 
                  }
                    ?>
                
                <?php
              }if ($result_seID['REMARK'] == 'ไม่คิดขั้นต่ำ') {
                if($result_seBilling['CARRYTYPE'] == 'trip' && ($_GET['customercode'] == 'TSAT' || $_GET['customercode'] == 'TTAST' )){
                    ?>
                      <td   style="border:1px solid #000;padding:4px;text-align:center"></td> 
                    <?php
                  }else{
                    ?>
                      <?php
                      if ($result_seBilling['JOBSTART'] =='KIT1' || $result_seBilling['JOBSTART'] =='KIT2') {
                      ?>
                        <td     style="border:1px solid #000;padding:4px;text-align:center">0.000</td>
                      <?php
                      }else{
                      ?>
                        <td     style="border:1px solid #000;padding:4px;text-align:center">0.000</td>
                      <?php
                      }
                      ?>
                    
                    <?php 
                  }
                    ?>
              <?php
              }else{
                ?>
                  
                <?php
              }
               ?>

              <!-- เงื่อนไขใหม่ -->
              <!-- คิด ACTUAL -->
              <?php
              if ($result_seID['REMARK'] == 'CHARGE 12') {
                if($result_seBilling['CARRYTYPE'] == 'trip' && ($_GET['customercode'] == 'TSAT' || $_GET['customercode'] == 'TTAST' )){
                  ?>
                    <td   style="border:1px solid #000;padding:4px;text-align:center"></td> 
                  <?php
                }else{
                  ?>

                      <?php
                      if ($result_seBilling['JOBSTART'] =='KIT1' || $result_seBilling['JOBSTART'] =='KIT2') {
                      ?>
                        <td   style="border:1px solid #000;padding:4px;text-align:center">12.000</td>
                      <?php
                      }else{
                      ?>
                        <td   style="border:1px solid #000;padding:4px;text-align:center">12.000</td>
                      <?php
                      }
                      ?>
                  
                  <?php 
                }
                  ?>
              
              <?php
              }if ($result_seID['REMARK'] == 'NOT CHARGE') {
                if($result_seBilling['CARRYTYPE'] == 'trip' && ($_GET['customercode'] == 'TSAT' || $_GET['customercode'] == 'TTAST' )){
                ?>
                 <td   style="border:1px solid #000;padding:4px;text-align:center"></td> 
                <?php
                }else{
                 ?>

                    <?php
                    if ($result_seBilling['JOBSTART'] =='KIT1' || $result_seBilling['JOBSTART'] =='KIT2') {
                    ?>
                      <td   style="border:1px solid #000;padding:4px;text-align:center"><?=($result_seBilling['WEISUM']/1000)?></td>
                    <?php
                    }else{
                    ?>
                      <td   style="border:1px solid #000;padding:4px;text-align:center"><?=number_format(($result_seBilling['WEISUM']/1000),3)?></td>
                    <?php
                    }
                    ?>

                 
                 <?php 
                }
                ?>
                <?php
              }if ($result_seID['REMARK'] == 'Charge 10') {
                if($result_seBilling['CARRYTYPE'] == 'trip' && ($_GET['customercode'] == 'TSAT' || $_GET['customercode'] == 'TTAST' )){
                  ?>
                    <td   style="border:1px solid #000;padding:4px;text-align:center"></td> 
                  <?php
                }else{
                  ?>

                    <?php
                    if ($result_seBilling['JOBSTART'] =='KIT1' || $result_seBilling['JOBSTART'] =='KIT2') {
                    ?>
                      <td   style="border:1px solid #000;padding:4px;text-align:center">10.000</td>
                    <?php
                    }else{
                    ?>
                      <td   style="border:1px solid #000;padding:4px;text-align:center">10.000</td>
                    <?php
                    }
                    ?>
                  
                  <?php 
                }
                  ?>
              
              <?php
              }if ($result_seID['REMARK'] == 'Charge 7') {
                if($result_seBilling['CARRYTYPE'] == 'trip' && ($_GET['customercode'] == 'TSAT' || $_GET['customercode'] == 'TTAST' )){
                  ?>
                    <td   style="border:1px solid #000;padding:4px;text-align:center"></td> 
                  <?php
                }else{
                  ?>

                    <?php
                    if ($result_seBilling['JOBSTART'] =='KIT1' || $result_seBilling['JOBSTART'] =='KIT2') {
                    ?>
                      <td   style="border:1px solid #000;padding:4px;text-align:center">7.000</td>
                    <?php
                    }else{
                    ?>
                      <td   style="border:1px solid #000;padding:4px;text-align:center">7.000</td>
                    <?php
                    }
                    ?>
                  
                  <?php 
                }
                  ?>
              
              <?php
              }if ($result_seID['REMARK'] == 'ไม่คิดขั้นต่ำ') {
                if($result_seBilling['CARRYTYPE'] == 'trip' && ($_GET['customercode'] == 'TSAT' || $_GET['customercode'] == 'TTAST' )){
                ?>
                 <td   style="border:1px solid #000;padding:4px;text-align:center"></td> 
                <?php
                }else{
                 ?>

                    <?php
                    if ($result_seBilling['JOBSTART'] =='KIT1' || $result_seBilling['JOBSTART'] =='KIT2') {
                    ?>
                      <td   style="border:1px solid #000;padding:4px;text-align:center"><?=($result_seBilling['WEISUM']/1000)?></td>
                    <?php
                    }else{
                    ?>
                      <td   style="border:1px solid #000;padding:4px;text-align:center"><?=number_format(($result_seBilling['WEISUM']/1000),3)?></td>
                    <?php
                    }
                    ?>
                 
                 <?php 
                }
                ?>
                <?php
              }else{
                ?>
                 
                <?php
              }
               ?>


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
  }else {
    ?>
    <table  style="border-collapse: collapse;margin-top:8px;font-size:14px" width="30%"  >
      <label><b>Delivery Summary For Van Truck</b></label>
      <tr>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><b>Date</b></td>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><b>Month</td>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><b>Year</td>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><b>Customer</b></td>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><b>Issued by</b></td>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><b>Checked by</b></td>
        <tr>
          <?php
          $date  = $_GET['datestart'];
          $dateplit = explode("/", $date);
          // echo $dateplit[0]; echo '<br>';
          // echo $dateplit[1]; echo '<br>';
          // echo $dateplit[2]; echo '<br>';
          $year=(date("Y")+543);
          // echo $year;
          // echo $jobendsplit[3]; echo '<br>';



           ?>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><?=$dateplit[0];?></td>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><?=$dateplit[1];?></td>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><?=  $year=(date("Y")+543);?></td>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"><?=$_GET['customercode']?> </td>
            <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center"></td>
            <td     style="width: 5%; border:1px solid #000;padding:4px;text-align:center"></td>
      </tr>


          </table>
          <br><br><br>

          <table   style="border-collapse: collapse;margin-top:8px;font-size:14px" width="100%">

            <tr>
              <td     style="width: 5%;border:1px solid #000;padding:4px;text-align:center">NO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">TRUCKNO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">VEHICLETYPE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">DRIVER.1</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">DRIVER.2</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">FROM</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">TO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">UNIT</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">ROUTE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">NORMAL</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">DO/PO</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">PRICE</td>
              <td     style="width: 10%;border:1px solid #000;padding:4px;text-align:center">REMARK</td>
            </tr>


            <?php
            $i = 1;

            if ($_GET['customercode']  == 'TMT') {
              $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
              a.EMPLOYEENAME2 AS 'EMP2',a.JOBSTART AS 'JOBSTART', a.JOBEND AS 'JOBEND',b.ROUNDAMOUNT AS 'ROUND'
              ,LEFT(b.ROUNDAMOUNT,PATINDEX('%[^0-9]%',b.ROUNDAMOUNT)-1) AS 'Numerics'
              FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
              INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
              LEFT JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID

              WHERE a.ACTIVESTATUS = 1
              AND a.COMPANYCODE='RKS' AND a.CUSTOMERCODE='TMT'
              AND a.DOCUMENTCODE IS NOT NULL
              AND a.DOCUMENTCODE !=''
              AND b.STATUSNUMBER !='X' AND STATUSNUMBER !='0'
              AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
              
              GROUP BY b.JOBNO,b.THAINAME,b.VEHICLETYPE,a.EMPLOYEENAME1,a.EMPLOYEENAME2, a.JOBSTART,a.JOBEND,b.ROUNDAMOUNT
              ORDER BY LEN(LEFT(b.ROUNDAMOUNT,PATINDEX('%[^0-9]%',b.ROUNDAMOUNT)-1)),Numerics ASC";
              $params_seBilling = array();
              $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);

            }else if ($_GET['customercode'] == 'STM') {
              $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
              a.EMPLOYEENAME2 AS 'EMP2',a.JOBSTART AS 'JOBSTART', a.JOBEND AS 'JOBEND',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
              c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
              ,b.VEHICLETRANSPORTPLANID AS 'PLANID',c.ROUTEDESCRIPTION AS 'DENSOTO',a.DOCUMENTCODE AS 'DOCUMENTCODE'
              ,SUBSTRING(b.ROUNDAMOUNT, 1, 3)  AS 'ROUND'
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
            }else if ($_GET['customercode'] == 'TGT') {
              $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
              a.EMPLOYEENAME2 AS 'EMP2',a.JOBSTART AS 'JOBSTART', a.JOBEND AS 'JOBEND',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
              c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
              ,b.VEHICLETRANSPORTPLANID AS 'PLANID',c.ROUTEDESCRIPTION AS 'DENSOTO',a.DOCUMENTCODE AS 'DOCUMENTCODE'
      
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
              
              ORDER BY a.DOCUMENTCODE ASC";
              $params_seBilling = array();
              $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
            }else {
              $sql_seBilling = "SELECT b.JOBNO AS 'JOBNO',b.THAINAME AS 'THAINAME',b.VEHICLETYPE AS 'VEHICLETYPE',a.EMPLOYEENAME1 AS 'EMP1',
              a.EMPLOYEENAME2 AS 'EMP2',a.JOBSTART AS 'JOBSTART', a.JOBEND AS 'JOBEND',b.VEHICLETRANSPORTPRICEID AS 'PLANPRICE',
              c.VEHICLETRANSPORTPRICEID AS 'DOPRICE',c.[LOCATION] AS 'LOCATION',b.CLUSTER AS 'CLUSTER',c.PRICE AS 'PRICE'
              ,b.VEHICLETRANSPORTPLANID AS 'PLANID',c.ROUTEDESCRIPTION AS 'DENSOTO',a.DOCUMENTCODE AS 'DOCUMENTCODE'
      
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



          ?>
          <tr>
              <!-- ////NO//// -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$i?></td>
              <!-- ///TRUCKNO/// -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['THAINAME']?></td>
              <!-- ///VEHICLETYPE/// -->
              <?php
              if ($_GET['companycode'] == 'RKS') {
                if($_GET['customercode'] == 'SWN'){
                  ?>
                <td    style="border:1px solid #000;padding:4px;text-align:center">10W(Van)</td>
                  <?php
                }else{
                  ?>
                <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['VEHICLETYPE']?></td>      
                  <?php
                }
              }else{
                ?>
             
                <?php
              }
              ?>
              
              <!-- //////DRIVER1///////// -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['EMP1']?></td>
              <!-- //////DRIVER2///////// -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['EMP2']?></td>
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
              <!-- //////////TO//////// -->
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

              <!-- ////////UNIT//////// -->
              <?php
              if ($_GET['companycode'] == 'RKS') {
                if ($_GET['customercode'] == 'STM') {
                ?>
                 <td    style="border:1px solid #000;padding:4px;text-align:right"><?=number_format($result_seTripamount['TRIPAMOUNT'],2)?></td>
                <?php
                }else {
                 ?>
                  <td    style="border:1px solid #000;padding:4px;text-align:center">1.00</td>
                 <?php
                }
              ?>

              <?php
              }else {
               ?>
              <td    style="border:1px solid #000;padding:4px;text-align:center"></td>
               <?php
              }
               ?>

              <!-- /////////ROUTE///////// -->
              <?php
              if ($_GET['companycode'] == 'RKS') {
                if ($_GET['customercode'] == 'STM') {
                  if ($result_seBilling['JOBSTART'] == 'STM(F.1)->STM(F.2) (IP01)') {
                    ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center">IP-01/<?=$result_seBilling['ROUND']?></td>
                    <?php
                  }else if ($result_seBilling['JOBSTART'] == 'STM(F.1)->STM(F.2) (IP02)') {
                    ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center">IP-02/<?=$result_seBilling['ROUND']?></td>
                    <?php
                  }else if ($result_seBilling['JOBSTART'] == 'STM(F.1)->STM(F.2) (IP03)') {
                    ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center">IP-03/<?=$result_seBilling['ROUND']?></td>
                    <?php
                  }else if ($result_seBilling['JOBSTART'] == 'STM(F.1)->STM(F.2) (IP04)') {
                    ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center">IP-04/<?=$result_seBilling['ROUND']?></td>
                    <?php
                  }else if ($result_seBilling['JOBSTART'] == 'STM(F.1)->STM(F.2) (IP05)') {
                    ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center">IP-05/<?=$result_seBilling['ROUND']?></td>
                    <?php
                  }else if ($result_seBilling['JOBSTART'] == 'STM(F.1)->STM(F.2) (IP06)') {
                    ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center">IP-06/<?=$result_seBilling['ROUND']?></td>
                    <?php
                  }else {
                    ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center"></td>
                    <?php
                  }
                  ?>

                <?php
              }else if ($_GET['customercode'] == 'TGT') {
                ?>
                  <td    style="border:1px solid #000;padding:4px;text-align:center">TGT</td>
                <?php
              }else if ($_GET['customercode'] == 'DENSO-THAI') {
                ?>
                  <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['JOBSTART']?></td>
                <?php
              }else {
                ?>
                  <td    style="border:1px solid #000;padding:4px;text-align:center"></td>
                <?php
                }
              }else {
                ?>
                 <td    style="border:1px solid #000;padding:4px;text-align:center"></td>
                <?php
              }

               ?>

              <!-- /////NORMAL////////// -->
              <?php
                if ($_GET['companycode'] == 'RKS' && $_GET['customercode'] == 'DENSO-THAI') {
                  ?>
                    <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['JOBEND']?></td>
                  <?php
                }else {
                  ?>
                    <td    style="border:1px solid #000;padding:4px;text-align:center"></td>
                  <?php
                }
               ?>

              <!-- /////////DO/PO///////// -->
              <?php
              if ($_GET['companycode'] == 'RKS') {
                    if ($_GET['customercode'] == 'TAW') {
                      ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center"><?=substr($result_seBilling['DOCUMENTCODE'],1,7)?></td>
                    <?php
                  }else if ($_GET['customercode'] == 'STM') {
                    ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center">วิรัช</td>
                    <?php
                  }else if ($_GET['customercode'] == 'DAIKI') {
                    ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['DOCUMENTCODE']?></td>
                    <?php
                  }else if ($_GET['customercode'] == 'TGT') {
                    ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['DOCUMENTCODE']?></td>
                    <?php
                  }else if ($_GET['customercode'] == 'GMT') {
                    ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['DOCUMENTCODE']?></td>
                    <?php
                  }else if ($_GET['customercode'] == 'THAITOHKEN') {
                    ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['DOCUMENTCODE']?></td>
                    <?php
                  }else if ($_GET['customercode'] == 'COPPERCORD') {
                    ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['DOCUMENTCODE']?></td>
                    <?php
                  }else {
                    ?>
                      <td    style="border:1px solid #000;padding:4px;text-align:center"></td>
                    <?php
                    }
              }else {
                ?>
                 <td    style="border:1px solid #000;padding:4px;text-align:center"></td>
                <?php
              }

               ?>

              <!-- ////////PRICE////////////// -->
              <?php
              if ($_GET['companycode'] == 'RKS') {
                if($_GET['customercode'] == 'SWN' || $_GET['customercode'] == 'THAITOHKEN'|| $_GET['customercode'] == 'COPPERCORD'){
                  ?>
                  <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['PRICE']?></td>
                  <?php
                }else if ($_GET['customercode'] == 'GMT') {
                  ?>
                  <td    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['PRICE']?></td>
                  <?php
                }else{
                  ?>
                <td    style="border:1px solid #000;padding:4px;text-align:center"></td>      
                  <?php
                }
              }else{
                ?>
                <?php
              }
              ?>
              
              <!-- /////////REMARK///////////////// -->
              <td    style="border:1px solid #000;padding:4px;text-align:center"></td>
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
