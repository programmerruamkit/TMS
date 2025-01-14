<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['invoicecode'] == "" || $_GET['invoicecode'] == "") {
    $strExcelFileName = "RKRTTAST(WEIGHT)_Billing.xls";
} else {
    $strExcelFileName = "RKRTTAST(WEIGHT)_Billing" . $_GET['invoicecode'] . ".xls";
}

header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

// header("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;name=\"$strExcelFileName\"");
// header("Content-Disposition: attachment; filename=\"$strExcelFileName\"");
// header("Pragma:no-cache");


$sumgmtweight = "";
$sumcusweight = "";
$sumamounttrip = "";
$sumtotal = "";
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $date_now = "";
} else {
    $date_now = $_GET['datestart'] . ' ถึง ' . $_GET['dateend'];
}
$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);


$condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condBilling2 = "";

$sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBillings = array(
    array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN)
);
$query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
$result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);

$condInvoice1 = " AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
$condInvoice2 = "";
$sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
$params_seInvoice = array(
    array('select_loginvoice', SQLSRV_PARAM_IN),
    array($condInvoice1, SQLSRV_PARAM_IN),
    array($condInvoice2, SQLSRV_PARAM_IN)
);
$query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
$result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC);
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <br><br>


        <!-- //////////////////////////////////////Header Charge 10 ////////////////////////////// -->
<table style="width: 100%;">
<thead>
<tr>
<td colspan="13" style="text-align:center;font-size:28px;"><b>เอกสารแนบการวางบิลลูกค้า (คิดขั้นต่ำ)</b></td>

</thead>
<tbody>
<tr>
<td colspan="13" style="text-align:center;font-size:22px;"><b><?= $result_seInvoice['BILLINGDATE'] ?>-<?=$result_seInvoice['PAYMENTDATE']?>(ค่าขนส่งปกติ)</b></td>
</tr>
<tr>
    <td colspan="7" style="text-align:left;"><b><font style="font-size: 18px">หมายเลขบัญชี :TXMA Charge 10 </font></b></td>
    <td colspan="6" style="text-align:right;"><b><font style="font-size: 18px">ใบแจ้งหนี้ : <?= $_GET['invoicecode'] ?> </font></b></td>
</tr>
</tbody>
</table>
<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">
<thead>

    <tr style="border:1px solid #000;padding:8px;">
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">ลำดับ</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">วันที่</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">จาก</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">ถึง</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">พื้นที่</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">หมายเลข DO </td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">ปริมาณ<br>(ตัน)</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">อัตรา<br>(บาท/ตัน)</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">ราคา<br>(บาท)</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">หมายเลขรถ</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">พนักงาน</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">ราคาจริง<br>(บาท)</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">ผลต่าง</td>
    </tr>
</thead><tbody>

<?php

$sql_seBilling10 = "SELECT (CONVERT(DECIMAL(10,3),WEIGHTINTON )  * CONVERT(INT,PRICE)) AS'PRICEREAL',* FROM (SELECT DISTINCT 
        ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.WEIGHTIN DESC) AS 'ROWNUM',
        e.VEHICLETYPE,CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CASE
        WHEN b.REMARK = 'Charge 7' THEN b.WEIGHTIN
        WHEN b.REMARK = 'Charge 10' THEN 10000
        ELSE CONVERT(INT,b.WEIGHTIN)
        END) / 1000) * CONVERT(INT,REPLACE(e.[PRICE],'<br><br>',''))) AS 'PRICEAC',
        CONVERT(VARCHAR(2),a.PAYMENTDATE) AS 'PAYMENTDATEDD',CONVERT(VARCHAR, CONVERT(DATETIME,a.PAYMENTDATE,103), 103) AS 'PAYMENTDATEDDMMYY', 
        SUBSTRING(convert(VARCHAR, CONVERT(DATETIME,a.PAYMENTDATE,103), 106),3,10) AS 'PAYMENTDATEDDYY',b.VEHICLETRANSPORTDOCUMENTDRIVERID, b.VEHICLETRANSPORTPLANID,b.DOCUMENTCODE, b.COMPANYCODE, 
        b.CUSTOMERCODE, b.EMPLOYEECODE1, b.EMPLOYEENAME1, b.EMPLOYEECODE2, b.EMPLOYEENAME2, b.JOBSTART, b.JOBEND,CONVERT(NVARCHAR,CONVERT(DECIMAL(10,3),(CONVERT(DECIMAL(10,3),CONVERT(INT,b.WEIGHTIN))/1000))) AS 'WEIGHTINTON', 
        b.WEIGHTIN,b.ACTIVESTATUS, b.REMARK ,CONVERT(VARCHAR(10), c.DATEVLIN, 103)  AS 'DATEVLIN_103',e.PRICE,
        b.ACTUALPRICE,c.THAINAME
        FROM [dbo].[LOGINVOICE] a
        INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
        INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID] 
        WHERE 1 = 1
        AND a.INVOICECODE = '" . $_GET['invoicecode'] . "'
        AND b.REMARK = 'Charge 10'
        AND e.CARRYTYPE ='weight'
        ) AS A ORDER BY VEHICLETRANSPORTPLANID,WEIGHTIN ASC";
$params_seBilling10 = array();

$i10 = 1;
$i210 =0;
$query_seBilling10 = sqlsrv_query($conn, $sql_seBilling10, $params_seBilling10);
while ($result_seBilling10 = sqlsrv_fetch_array($query_seBilling10, SQLSRV_FETCH_ASSOC)) {

    $sql_seActualprice10 = "SELECT SUM((CONVERT(DECIMAL(10,3),WEIGHTINTON )  * CONVERT(INT,PRICE))) AS'PRICEREAL' 
        FROM (SELECT DISTINCT 
        ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.WEIGHTIN DESC) AS 'ROWNUM',
        e.VEHICLETYPE,CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CASE
        WHEN b.REMARK = 'Charge 7' THEN b.WEIGHTIN
        WHEN b.REMARK = 'Charge 10' THEN 10000
        ELSE CONVERT(INT,b.WEIGHTIN)
        END) / 1000) * CONVERT(INT,REPLACE(e.[PRICE],'<br><br>',''))) AS 'PRICEAC',
        CONVERT(NVARCHAR,CONVERT(DECIMAL(10,3),(CONVERT(DECIMAL(10,3),CONVERT(INT,b.WEIGHTIN))/1000))) AS 'WEIGHTINTON', 
        b.WEIGHTIN,b.ACTIVESTATUS, b.REMARK ,CONVERT(VARCHAR(10), c.DATEVLIN, 103)  AS 'DATEVLIN_103',e.PRICE,
        b.ACTUALPRICE,b.VEHICLETRANSPORTPLANID,c.EMPLOYEENAME1
        FROM [dbo].[LOGINVOICE] a
        INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
        INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID] 
        WHERE 1 = 1
        AND a.INVOICECODE = '" . $_GET['invoicecode'] . "'
        AND b.REMARK = 'Charge 10'
        AND e.CARRYTYPE ='weight'
        AND b.VEHICLETRANSPORTPLANID ='" .$result_seBilling10['VEHICLETRANSPORTPLANID'] ."'
        ) AS A";
    $params_seActualprice10 = array();
    $query_seActualprice10 = sqlsrv_query($conn, $sql_seActualprice10, $params_seActualprice10);
    $result_seActualprice10 = sqlsrv_fetch_array($query_seActualprice10, SQLSRV_FETCH_ASSOC);
    
       

    $condEmployeeehr110 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling10['EMPLOYEENAME1'] . "' ";
    $sql_seEmployeeehr10 = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmployeeehr10 = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($condEmployeeehr110, SQLSRV_PARAM_IN)
    );
    $query_seEmployeeehr10 = sqlsrv_query($conn, $sql_seEmployeeehr10, $params_seEmployeeehr10);
    $result_seEmployeeehr10 = sqlsrv_fetch_array($query_seEmployeeehr10, SQLSRV_FETCH_ASSOC);
    
     
    $pricereal10 = number_format($result_seBilling10['WEIGHTINTON'],3) * number_format($result_seBilling10['PRICE'],2);

    if($result_seBilling10['ROWNUM'] != '1'){
        $thainame10 = '';
        $empname10 = ''; 
        $price10 = '';
        $diff10 = '';
       
 
     }else{
         $thainame10 = $result_seBilling10['THAINAME'];
         $empname10 = $result_seEmployeeehr10['FnameT'];
         $price10 = number_format($result_seBilling10['PRICEAC'],2);
         $diff10 = number_format($result_seBilling10['PRICEAC']-$result_seActualprice10['PRICEREAL'],2);
         
         $i210++;
         $priceall10 = $i210*$result_seBilling10['PRICEAC'];
     }
?>

          

<tr style="border:1px solid #000;">
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px"><?= $i10 ?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px"><?= $result_seBilling10['DATEVLIN_103'] ?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px"><?= $result_seBilling10['JOBSTART'] ?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px"><?= ($result_seBilling10['JOBEND']  == 'TMG' ? 'TMT/GW' : $result_seBilling['JOBEND']) ?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">Gateway</td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px"><?= $result_seBilling10['DOCUMENTCODE'] ?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 16px"><?= number_format($result_seBilling10['WEIGHTINTON'],3) ?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 16px"><?= number_format($result_seBilling10['PRICE'],2) ?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 16px"><?= $price10 ?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px"><?= $thainame10 ?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px"><?= $empname10 ?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 16px"><?= number_format($pricereal10,2)?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 16px"><?= $diff10 ?></td>
</tr>
        
      <?php
    $i10++;
    $rs310 = $rs310 + $result_seBilling10['WEIGHTINTON'];
    $rs410 = $rs410 + $pricereal10;
    
    
  }////end while
?>



</tbody><tfoot>
    
<tr style="border:1px solid #000;">
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 16px"></td>
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 16px">รวมทั้งหมด</td>
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 16px"></td>
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 16px"></td>
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 16px"></td>
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 16px"></td>
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 16px"><?= number_format($rs310,3) ?></td>
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 16px"></td>
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 16px"><?= number_format($priceall10,3) ?></td>
<td colspan="1" style="border-right:1px solid #000;padding:5px;text-align:center;font-size: 16px"></td>
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 16px"></td>
<td colspan="1" style="border-right:1px solid #000;padding:5px;text-align:right;font-size: 16px"><?= number_format($rs410,2) ?></td>
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 16px"><?= number_format($priceall10-$rs410,2) ?></td>
</tr>


   
    </tfoot>


</table>

<table style="width: 100%;">
    <tbody>
       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>
       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>
       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>
       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>

       <tr>
   		  <td colspan="4" style="text-align:left;font-size:20px">ผู้จัดทำ..............................</td>

        <td colspan="5" style="text-align:center;font-size:20px">ผู้ตรวจสอบ..........................</td>

        <td colspan="4" style="text-align:right;font-size:20px">ผู้อนุมัติ..............................</td>

       </tr>



    </tbody>
</table>
<!-- //เอกสารแนบไม่คิดขั้นต่่ำ -->
<table style="width: 100%;">
<thead>
<tr>
<td colspan="11" style="text-align:center;font-size:28px;"><b>เอกสารแนบการวางบิลลูกค้า (คิดขั้นต่ำ)</b></td>

</thead>
<tbody>
<tr>
<td colspan="11" style="text-align:center;font-size:22px;"><b><?= $result_seInvoice['BILLINGDATE'] ?>-<?=$result_seInvoice['PAYMENTDATE']?>(ค่าขนส่งปกติ)</b></td>
</tr>
<tr>
    <td colspan="6" style="text-align:left;"><b><font style="font-size: 18px">หมายเลขบัญชี : </font></b></td>
    <td colspan="5" style="text-align:right;"><b><font style="font-size: 18px">ใบแจ้งหนี้ : <?= $_GET['invoicecode'] ?> </font></b></td>
</tr>
</tbody>
</table>
<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">
<thead>

    <tr style="border:1px solid #000;padding:8px;">
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">ลำดับ</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">วันที่</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">จาก</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">ถึง</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">พื้นที่</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">หมายเลข DO</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">ปริมาณ<br>(ตัน)</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">อัตรา<br>(บาท/ตัน)</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">ราคา<br>(บาท)</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">หมายเลขรถ</td>
        <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px">พนักงาน</td>
    </tr>
</thead><tbody>

<?php
$sql_seBilling = "SELECT (CONVERT(DECIMAL(10,3),WEIGHTINTON )  * CONVERT(INT,PRICE)) AS'PRICEREAL',* FROM (SELECT DISTINCT 
        ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.WEIGHTIN DESC) AS 'ROWNUM',
        e.VEHICLETYPE,CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CASE
        WHEN b.REMARK = 'Charge 7' THEN b.WEIGHTIN
        WHEN b.REMARK = 'Charge 10' THEN 10000
        ELSE CONVERT(INT,b.WEIGHTIN)
        END) / 1000) * CONVERT(INT,REPLACE(e.[PRICE],'<br><br>',''))) AS 'PRICEAC',
        CONVERT(VARCHAR(2),a.PAYMENTDATE) AS 'PAYMENTDATEDD',CONVERT(VARCHAR, CONVERT(DATETIME,a.PAYMENTDATE,103), 103) AS 'PAYMENTDATEDDMMYY', 
        SUBSTRING(convert(VARCHAR, CONVERT(DATETIME,a.PAYMENTDATE,103), 106),3,10) AS 'PAYMENTDATEDDYY',b.VEHICLETRANSPORTDOCUMENTDRIVERID, b.VEHICLETRANSPORTPLANID,b.DOCUMENTCODE, b.COMPANYCODE, 
        b.CUSTOMERCODE, b.EMPLOYEECODE1, b.EMPLOYEENAME1, b.EMPLOYEECODE2, b.EMPLOYEENAME2, b.JOBSTART, b.JOBEND,CONVERT(NVARCHAR,CONVERT(DECIMAL(10,3),(CONVERT(DECIMAL(10,3),CONVERT(INT,b.WEIGHTIN))/1000))) AS 'WEIGHTINTON', 
        b.WEIGHTIN,b.ACTIVESTATUS, b.REMARK ,CONVERT(VARCHAR(10), c.DATEVLIN, 103)  AS 'DATEVLIN_103',e.PRICE,
        b.ACTUALPRICE,c.THAINAME
        FROM [dbo].[LOGINVOICE] a
        INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
        INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID] 
        WHERE 1 = 1
        AND a.INVOICECODE = '" . $_GET['invoicecode'] . "'
        AND b.REMARK = 'ไม่คิดขั้นต่ำ'
        AND e.CARRYTYPE ='weight'
        ) AS A ORDER BY VEHICLETRANSPORTPLANID,WEIGHTIN ASC";
$params_seBilling = array();

$i = 1;
$i2 =0;
$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

   
    $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "' ";
    $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmployeeehr = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($condEmployeeehr1, SQLSRV_PARAM_IN)
    );
    $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
    $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
    
     
    $pricereal = number_format($result_seBilling['WEIGHTINTON'],3) * number_format($result_seBilling['PRICE'],2);

    if($result_seBilling['ROWNUM'] != '1'){
        $thainame = '';
        $empname = ''; 
        $price = '';
        
       
 
     }else{
         $thainame = $result_seBilling['THAINAME'];
         $empname = $result_seEmployeeehr['FnameT'];
         $price = number_format($result_seBilling['PRICEAC'],2);
         
         
         $i2++;
         $priceall = $i2*$result_seBilling['PRICEAC'];
     }

?>
          

<tr style="border:1px solid #000;">
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px"><?= $i ?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px"><?= $result_seBilling['DATEVLIN_103'] ?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px"><?= $result_seBilling['JOBSTART'] ?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px"><?= ($result_seBilling['JOBEND']  == 'TMG' ? 'TMT/GW' : $result_seBilling['JOBEND']) ?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:left;font-size: 16px">Gateway</td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:left;font-size: 16px"><?= $result_seBilling['DOCUMENTCODE'] ?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 16px"><?= number_format($result_seBilling['WEIGHTINTON'],3) ?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 16px"><?= number_format($result_seBilling['PRICE'],2) ?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 16px"><?= $price ?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px"><?= $thainame ?></td>
  <td colspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 16px"><?= $empname ?></td>
</tr>
        
    <?php
    $i++;
    $rs3 = $rs3 + $result_seBilling['WEIGHTINTON'];
    $rs4 = $rs4 + $pricereal;
    
    
  }////end while
?>



</tbody><tfoot>
    
<tr style="border:1px solid #000;">
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 16px"></td>
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 16px">รวมทั้งหมด</td>
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 16px"></td>
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 16px"></td>
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 16px"></td>
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 16px"></td>
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 16px"><?= number_format($rs3,3) ?></td>
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 16px"></td>
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 16px"><?= number_format($priceall,3) ?></td>
<td colspan="1" style="border-right:1px solid #000;padding:5px;text-align:center;font-size: 16px"></td>
<td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 16px"></td>
</tr>


   
    </tfoot>

</table>
<table style="width: 100%;">
    <tbody>
       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>
       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>
       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>
       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>

       <tr>
   		  <td colspan="4" style="width: 33%;text-align:left;font-size:20px">ผู้จัดทำ..............................</td>

        <td colspan="5" style="width: 34%;text-align:center;font-size:20px">ผู้ตรวจสอบ..........................</td>

        <td colspan="4" style="width: 33%;text-align:right;font-size:20px">ผู้อนุมัติ..............................</td>

       </tr>



    </tbody>
</table>  

    </body>
    </html>
