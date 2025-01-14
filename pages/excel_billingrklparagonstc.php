<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['invoicecode'] == "" || $_GET['invoicecode'] == "") {
  $strExcelFileName = "RKLPARAGONSTC_Billing.xls";
} else {
  $strExcelFileName = "RKLPARAGONSTC_Billing" . $_GET['invoicecode'] . ".xls";
}

header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");


$sumgmtweight = "";
$sumcusweight = "";
$sumamounttrip = "";
$sumtotal = "";

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
  array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);


//
// $condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
// $condBilling2 = "";
//
// $sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
// $params_seBillings = array(
//     array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
//     array($condBilling1, SQLSRV_PARAM_IN),
//     array($condBilling2, SQLSRV_PARAM_IN)
// );
// $query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
// $result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);
//
// $condInvoice1 = " AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
// $condInvoice2 = "";
// $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
// $params_seInvoice = array(
//     array('select_loginvoice', SQLSRV_PARAM_IN),
//     array($condInvoice1, SQLSRV_PARAM_IN),
//     array($condInvoice2, SQLSRV_PARAM_IN)
// );
// $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
// $result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC);


$condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "' ";
$sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmployeeehr = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($condEmployeeehr1, SQLSRV_PARAM_IN)
);
$query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
$result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);

$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '".$_GET['invoicecode']."'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);


?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
 <br><br>
<!-- ////////////////////////////////////////////////Charge 10///////////////////////////////////////////////// -->
<?php

$sql_seBilling10 = "SELECT  c.JOBNO,b.JOBSTART,b.JOBEND,b.REMARK,c.BILLING,a.BILLINGDATE
FROM [dbo].[LOGINVOICE] a
INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] d ON c.[VEHICLETRANSPORTPRICEID] = d.[VEHICLETRANSPORTPRICEID]
WHERE b.COMPANYCODE='".$_GET['companycode']."' AND b.CUSTOMERCODE='".$_GET['companycode']."' AND b.REMARK = 'Charge 10' ";

$query_seBilling10 = sqlsrv_query($conn, $sql_seBilling10, $params_seBilling10);
$result_seBilling10 = sqlsrv_fetch_array($query_seBilling10, SQLSRV_FETCH_ASSOC);

 ?>

 <!-- //////////////////////////////////////Header Charge 10 ////////////////////////////// -->
 <table style="width: 100%;">
       <thead>
           <tr>

               <td colspan="28" style="text-align:center;font-size:18px;"><b>เอกสารแนบการวางบิลลูกค้า (คิดขั้นต่ำ)</b></td>

       </thead>
       <tbody>
           <tr>
               <td colspan="28" style="text-align:center;font-size:14px;"><b> <?= $result_seInvoicecode['BILLINGDATE']?> - <?= $result_seInvoicecode['PAYMENTDATE']?> &nbsp (ค่าขนส่งปกติ)</b></td>
          </tr>

          <tr>
               <td colspan="28">&nbsp;</td>
          </tr>

       </tbody>
   </table>
 <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
 <thead>
           <tr>
               <td colspan="16" style="text-align:left;font-size:16px;"><b>หมายเลขบัญชี : <?=$result_seBilling10['BILLING']?>  Charge 10</b></td>
               <td colspan="10" style="text-align:right;font-size:16px;"><b>ใบแจ้งหนี้: <?= $result_seInvoice['INVOICECODE']?></b></td>
           </tr>
           <tr style="border:1px solid #000;padding:4px;">

           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ลำดับ</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>วันที่</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>จาก</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ถึง</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Zone</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลข DO</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ปริมาณ(ตัน)</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>อัตรา(บาท/ตัน)</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ราคา(บาท)</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลขรถ</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>พนักงาน</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ราคาจริง</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ผลต่าง</b></td>
         </tr>
       </thead><tbody>


<?php
  $i = 1;
  // $sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '".$_GET['invoicecode']."'";
  //
  // $query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
  // $result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);

   $sql_seBilling1 = " SELECT DISTINCT c.JOBNO,a.BILLINGDATE,a.INVOICECODE,'1' AS 'NUMBER',b.JOBSTART,b.JOBEND,d.LOCATION,CONVERT(NVARCHAR,CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(INT,b.WEIGHTIN)) / 1000)) AS 'WEIGHTIN' ,d.[PRICE] AS 'PRICETON',
   CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CASE
   WHEN b.REMARK = 'Charge 7' THEN 7000
   WHEN b.REMARK = 'Charge 10' THEN 10000
   ELSE CONVERT(INT,b.WEIGHTIN)
   END) / 1000) * d.[PRICE]) AS 'PRICE',


   CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CASE
   WHEN b.REMARK = 'Charge 7' THEN b.WEIGHTIN
   WHEN b.REMARK = 'Charge 10' THEN 10000
   ELSE CONVERT(INT,b.WEIGHTIN)
   END) / 1000) * d.[PRICE]) AS 'PRICEAC',

   b.REMARK,a.BILLING,b.REMARK,c.THAINAME,c.EMPLOYEENAME1,b.DOCUMENTCODE
   FROM [dbo].[LOGINVOICE] a
   INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
   INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
   INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] d ON b.[VEHICLETRANSPORTPRICEID] = d.[VEHICLETRANSPORTPRICEID]
   WHERE c.COMPANYCODE = '".$_GET['companycode']."' AND c.CUSTOMERCODE = '".$_GET['customercode']."'
   AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103) AND b.REMARK='Charge 10' ORDER BY b.JOBEND ASC  ";


                $query_seBilling1 = sqlsrv_query($conn, $sql_seBilling1, $params_seBilling1);
                while($result_seBilling1 = sqlsrv_fetch_array($query_seBilling1, SQLSRV_FETCH_ASSOC)){
                  $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling1['EMPLOYEENAME1'] . "' ";
                  $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                  $params_seEmployeeehr = array(
                      array('select_employeeehr2', SQLSRV_PARAM_IN),
                      array($condEmployeeehr1, SQLSRV_PARAM_IN)
                  );
                  $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                  $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);

?>



  <tr style="border:1px solid #000;">
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:center;"><?= $i ?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling1['BILLINGDATE']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling1['JOBSTART']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling1['JOBEND']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling1['LOCATION']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling1['DOCUMENTCODE']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$result_seBilling1['WEIGHTIN']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$result_seBilling1['PRICETON']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=number_format($result_seBilling1['PRICE'],2)?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$result_seBilling1['THAINAME']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$result_seEmployeeehr['FnameT']?> </td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=number_format(($result_seBilling1['WEIGHTIN'])*($result_seBilling1['PRICETON']),2)?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=number_format(($result_seBilling1['PRICE'])-(($result_seBilling1['WEIGHTIN'])*($result_seBilling1['PRICETON'])),2)?> </td>
  </tr>
  <?php
  $i++;
  $sumtotalton1 += $result_seBilling1['WEIGHTIN'];
  $sumtotalprice1 += $result_seBilling1['PRICE'];
}
   ?>
  <tr style="border:1px solid #000;">
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>รวม<b></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:right;"><b><?=$sumtotalton1?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:right;"><b><?=number_format($sumtotalprice1,2)?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
  </tr>
   </tbody>
 </table>

<!-- ////////////////////////////////////Charge 7 /////////////////////////////////////// -->
<?php

$sql_seBilling7 = "SELECT  c.JOBNO,b.JOBSTART,b.JOBEND,b.REMARK,c.BILLING,a.BILLINGDATE
FROM [dbo].[LOGINVOICE] a
INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] d ON c.[VEHICLETRANSPORTPRICEID] = d.[VEHICLETRANSPORTPRICEID]
WHERE b.COMPANYCODE='".$_GET['companycode']."' AND b.CUSTOMERCODE='".$_GET['companycode']."' AND b.REMARK = 'Charge 7' ";

$query_seBilling7 = sqlsrv_query($conn, $sql_seBilling7, $params_seBilling7);
$result_seBilling7 = sqlsrv_fetch_array($query_seBilling7, SQLSRV_FETCH_ASSOC);

 ?>

 <!-- //////////////////////////////////////Header Charge 7 ////////////////////////////// -->
 <table style="width: 100%;">
       <thead>
           <tr>
               <td colspan="28" style="text-align:center;font-size:18px;"><b>เอกสารแนบการวางบิลลูกค้า (คิดขั้นต่ำ)</b></td>

       </thead>
       <tbody>
           <tr>
               <td colspan="28" style="text-align:center;font-size:14px;"><b> <?= $result_seInvoicecode['BILLINGDATE']?> - <?= $result_seInvoicecode['PAYMENTDATE']?> &nbsp (ค่าขนส่งปกติ)</b></td>
          </tr>

          <tr>
               <td colspan="28">&nbsp;</td>
          </tr>

       </tbody>
   </table>
 <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
 <thead>
           <tr>
               <td colspan="16" style="text-align:left;font-size:16px;"><b>หมายเลขบัญชี : <?=$result_seBilling7['BILLING']?>  Charge 7</b></td>
               <td colspan="10" style="text-align:right;font-size:16px;"><b>ใบแจ้งหนี้: <?= $result_seInvoice['INVOICECODE']?></b></td>
           </tr>
           <tr style="border:1px solid #000;padding:4px;">

           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ลำดับ</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>วันที่</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>จาก</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ถึง</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Zone</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลข DO</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ปริมาณ(ตัน)</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>อัตรา(บาท/ตัน)</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ราคา(บาท)</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลขรถ</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>พนักงาน</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ราคาจริง</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ผลต่าง</b></td>
         </tr>
       </thead><tbody>


<?php
  $i = 1;
  // $sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '".$_GET['invoicecode']."'";
  //
  // $query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
  // $result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);

   $sql_seBilling2 = " SELECT DISTINCT c.JOBNO,a.BILLINGDATE,a.INVOICECODE,'1' AS 'NUMBER',b.JOBSTART,b.JOBEND,d.LOCATION,CONVERT(NVARCHAR,CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(INT,b.WEIGHTIN)) / 1000)) AS 'WEIGHTIN' ,d.[PRICE] AS 'PRICETON',
   CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CASE
   WHEN b.REMARK = 'Charge 7' THEN 7000
   WHEN b.REMARK = 'Charge 10' THEN 10000
   ELSE CONVERT(INT,b.WEIGHTIN)
   END) / 1000) * d.[PRICE]) AS 'PRICE',


   CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CASE
   WHEN b.REMARK = 'Charge 7' THEN b.WEIGHTIN
   WHEN b.REMARK = 'Charge 10' THEN 10000
   ELSE CONVERT(INT,b.WEIGHTIN)
   END) / 1000) * d.[PRICE]) AS 'PRICEAC',

   b.REMARK,a.BILLING,b.REMARK,c.THAINAME,c.EMPLOYEENAME1,b.DOCUMENTCODE
   FROM [dbo].[LOGINVOICE] a
   INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
   INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
   INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] d ON b.[VEHICLETRANSPORTPRICEID] = d.[VEHICLETRANSPORTPRICEID]
   WHERE c.COMPANYCODE = '".$_GET['companycode']."' AND c.CUSTOMERCODE = '".$_GET['customercode']."'
   AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103) AND b.REMARK='Charge 7' ORDER BY b.JOBEND ASC ";


                $query_seBilling2 = sqlsrv_query($conn, $sql_seBilling2, $params_seBilling2);
                while($result_seBilling2 = sqlsrv_fetch_array($query_seBilling2, SQLSRV_FETCH_ASSOC)){
                  $condEmployeeehr2 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling2['EMPLOYEENAME1'] . "' ";
                  $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                  $params_seEmployeeehr = array(
                      array('select_employeeehr2', SQLSRV_PARAM_IN),
                      array($condEmployeeehr2, SQLSRV_PARAM_IN)
                  );
                  $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                  $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);

?>



  <tr style="border:1px solid #000;">
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:center;"><?= $i ?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling2['BILLINGDATE']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling2['JOBSTART']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling2['JOBEND']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling2['LOCATION']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling2['DOCUMENTCODE']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$result_seBilling2['WEIGHTIN']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$result_seBilling2['PRICETON']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=number_format($result_seBilling2['PRICE'],2)?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$result_seBilling2['THAINAME']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$result_seEmployeeehr['FnameT']?> </td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=number_format(($result_seBilling2['WEIGHTIN'])*($result_seBilling2['PRICETON']),2)?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=number_format(($result_seBilling2['PRICE'])-(($result_seBilling2['WEIGHTIN'])*($result_seBilling2['PRICETON'])),2)?> </td>
  </tr>
  <?php
  $i++;
  $sumtotalton2 += $result_seBilling2['WEIGHTIN'];
  $sumtotalprice2 += $result_seBilling2['PRICE'];
}
   ?>
  <tr style="border:1px solid #000;">
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>รวม<b></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:right;"><b><?=$sumtotalton2?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:right;"><b><?=number_format($sumtotalprice2,2)?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
  </tr>
   </tbody>
 </table>

<!-- ///////////////////////////////////////ไม่คิดขั้นต่ำ//////////////////////////////////////////////// -->

<?php

$sql_seBilling3 = "SELECT  c.JOBNO,b.JOBSTART,b.JOBEND,b.REMARK,c.BILLING,a.BILLINGDATE
FROM [dbo].[LOGINVOICE] a
INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] d ON c.[VEHICLETRANSPORTPRICEID] = d.[VEHICLETRANSPORTPRICEID]
WHERE b.COMPANYCODE='".$_GET['companycode']."' AND b.CUSTOMERCODE='".$_GET['companycode']."' AND b.REMARK = 'ไม่คิดขั้นต่ำ' ";

$query_seBilling3 = sqlsrv_query($conn, $sql_seBilling3, $params_seBilling3);
$result_seBilling3 = sqlsrv_fetch_array($query_seBilling3, SQLSRV_FETCH_ASSOC);

 ?>

 <!-- //////////////////////////////////////Header ไม่คิดขั้นต่ำ ////////////////////////////// -->
 <table style="width: 100%;">
       <thead>
           <tr>
               <td colspan="26" style="text-align:center;font-size:18px;"><b>เอกสารแนบการวางบิลลูกค้า (ไม่คิดขั้นต่ำ)</b></td>

       </thead>
       <tbody>
           <tr>
               <td colspan="26" style="text-align:center;font-size:14px;"><b> <?= $result_seInvoicecode['BILLINGDATE']?> - <?= $result_seInvoicecode['PAYMENTDATE']?> &nbsp (ค่าขนส่งปกติ)</b></td>
          </tr>

          <tr>
               <td colspan="26">&nbsp;</td>
          </tr>

       </tbody>
   </table>
 <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
 <thead>
           <tr>
               <td colspan="12" style="text-align:left;font-size:16px;"><b>หมายเลขบัญชี : <?=$result_seBilling3['BILLING']?> </b></td>
               <td colspan="10" style="text-align:right;font-size:16px;"><b>ใบแจ้งหนี้: <?= $result_seInvoice['INVOICECODE']?></b></td>
           </tr>
           <tr style="border:1px solid #000;padding:4px;">

           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ลำดับ</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>วันที่</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>จาก</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ถึง</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Zone</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลข DO</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ปริมาณ(ตัน)</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>อัตรา(บาท/ตัน)</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ราคา(บาท)</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลขรถ</b></td>
           <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>พนักงาน</b></td>

         </tr>
       </thead><tbody>


<?php
  $i = 1;
  // $sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '".$_GET['invoicecode']."'";
  //
  // $query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
  // $result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);

   $sql_seBilling3 = " SELECT DISTINCT c.JOBNO,a.BILLINGDATE,a.INVOICECODE,'1' AS 'NUMBER',b.JOBSTART,b.JOBEND,d.LOCATION,CONVERT(NVARCHAR,CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(INT,b.WEIGHTIN)) / 1000)) AS 'WEIGHTIN' ,d.[PRICE] AS 'PRICETON',
   CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CASE
   WHEN b.REMARK = 'Charge 7' THEN 7000
   WHEN b.REMARK = 'Charge 10' THEN 10000
   ELSE CONVERT(INT,b.WEIGHTIN)
   END) / 1000) * d.[PRICE]) AS 'PRICE',


   CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CASE
   WHEN b.REMARK = 'Charge 7' THEN b.WEIGHTIN
   WHEN b.REMARK = 'Charge 10' THEN 10000
   ELSE CONVERT(INT,b.WEIGHTIN)
   END) / 1000) * d.[PRICE]) AS 'PRICEAC',

   b.REMARK,a.BILLING,b.REMARK,c.THAINAME,c.EMPLOYEENAME1,b.DOCUMENTCODE
   FROM [dbo].[LOGINVOICE] a
   INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
   INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
   INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] d ON b.[VEHICLETRANSPORTPRICEID] = d.[VEHICLETRANSPORTPRICEID]
   WHERE c.COMPANYCODE = '".$_GET['companycode']."' AND c.CUSTOMERCODE = '".$_GET['customercode']."'
   AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103) AND b.REMARK='ไม่คิดขั้นต่ำ' ORDER BY b.JOBEND ASC ";


                $query_seBilling3 = sqlsrv_query($conn, $sql_seBilling3, $params_seBilling3);
                while($result_seBilling3 = sqlsrv_fetch_array($query_seBilling3, SQLSRV_FETCH_ASSOC)){
                  $condEmployeeehr3 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling3['EMPLOYEENAME1'] . "' ";
                  $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                  $params_seEmployeeehr = array(
                      array('select_employeeehr2', SQLSRV_PARAM_IN),
                      array($condEmployeeehr3, SQLSRV_PARAM_IN)
                  );
                  $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                  $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);

?>



  <tr style="border:1px solid #000;">
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:center;"><?= $i ?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling3['BILLINGDATE']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling3['JOBSTART']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling3['JOBEND']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling3['LOCATION']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling3['DOCUMENTCODE']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$result_seBilling3['WEIGHTIN']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$result_seBilling3['PRICETON']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=number_format($result_seBilling3['PRICE'],2)?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$result_seBilling3['THAINAME']?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$result_seEmployeeehr['FnameT']?> </td>
  </tr>
  <?php
  $i++;
  $sumtotalton3 += $result_seBilling3['WEIGHTIN'];
  $sumtotalprice3 += $result_seBilling3['PRICE'];
}
   ?>
  <tr style="border:1px solid #000;">
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>รวม<b></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:right;"><b><?=$sumtotalton3?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:right;"><b><?=number_format($sumtotalprice3,2)?></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>

  </tr>
   </tbody>
 </table>

  </body>
  </html>
