<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['invoicecode'] == "" || $_GET['invoicecode'] == "") {
$strExcelFileName = "RKRPARAGON_Billing.xls";
} else {
$strExcelFileName = "RKRPARAGON_Billing" . $_GET['invoicecode'] . ".xls";
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

$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '" . $_GET['invoicecode'] . "'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);
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

<td colspan="12" style="text-align:center;font-size:18px;"><b>เอกสารแนบการวางบิลลูกค้า (คิดขั้นต่ำ)</b></td>

</thead>
<tbody>
<tr>
<td colspan="12" style="text-align:center;font-size:14px;"><b> <?= $result_seInvoicecode['BILLINGDATE'] ?> - <?= $result_seInvoicecode['PAYMENTDATE'] ?> &nbsp (ค่าขนส่งปกติ)</b></td>
</tr>

<tr>
<td colspan="12">&nbsp;</td>
</tr>

</tbody>
</table>
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
<thead>
<tr>
<td colspan="6" style="text-align:left;font-size:16px;"><b>หมายเลขบัญชี : <?= $result_seBilling10['BILLING'] ?>  Charge 10</b></td>
<td colspan="6" style="text-align:right;font-size:16px;"><b>ใบแจ้งหนี้: <?=$_GET['invoicecode']?> </b></td>
</tr>
<tr style="border:1px solid #000;padding:4px;">

<td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ลำดับ</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>วันที่</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>จาก</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ถึง</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลข DO</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ปริมาณ(ตัน)</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>อัตรา(บาท/ตัน)</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ราคา(บาท)</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลขรถ</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>พนักงาน</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ราคาจริง</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ผลต่าง</b></td>
</tr>
</thead><tbody>


<?php
$i = 1;
$condBilling3 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condBilling4 = " AND b.REMARK = 'Charge 12' ";
$sql_seBilling2 = "SELECT * FROM (SELECT DISTINCT e.VEHICLETYPE,CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CASE
WHEN b.REMARK = 'Charge 7' THEN b.WEIGHTIN
WHEN b.REMARK = 'Charge 10' THEN 10000
ELSE CONVERT(INT,b.WEIGHTIN)
END) / 1000) * CONVERT(INT,REPLACE(e.[PRICE],'<br><br>',''))) AS 'PRICEAC',
b.ACTUALPRICE_TEMP,CONVERT(VARCHAR(2),a.BILLINGDATE) AS 'BILLINGDATEDAY',CONVERT(VARCHAR(2),a.PAYMENTDATE) AS 'PAYMENTDATEDD',CONVERT(VARCHAR, CONVERT(DATETIME,a.PAYMENTDATE,103), 103) AS 'PAYMENTDATEDDMMYY',
SUBSTRING(convert(VARCHAR, CONVERT(DATETIME,a.PAYMENTDATE,103), 106),3,10) AS 'PAYMENTDATEDDYY',b.VEHICLETRANSPORTDOCUMENTDRIVERID, b.VEHICLETRANSPORTPLANID,b.DOCUMENTCODE, b.COMPANYCODE,
b.CUSTOMERCODE, b.EMPLOYEECODE1, b.EMPLOYEENAME1, b.EMPLOYEECODE2, b.EMPLOYEENAME2, b.JOBSTART, b.JOBEND,CONVERT(NVARCHAR,CONVERT(DECIMAL(10,3),(CONVERT(DECIMAL(10,3),CONVERT(INT,b.WEIGHTIN))/1000))) AS 'WEIGHTINTON',
b.WEIGHTIN, b.WEIGHTOUT, b.TRIPAMOUNT, b.VEHICLEREGISNUMBER, b.COMPENSATION,b.COMPENSATION1,b.COMPENSATION2,b.OVERTIME, b.OTHER, b.PAY_REMARK,
b.PAY_APPROVERS, b.PAY_EXPRESSWAY,PAY_EXPRESSWAY15,PAY_EXPRESSWAY25,PAY_EXPRESSWAY45,PAY_EXPRESSWAY50,PAY_EXPRESSWAY50RETURN,PAY_EXPRESSWAY55,PAY_EXPRESSWAY65,PAY_EXPRESSWAY65RETURN,PAY_EXPRESSWAY75,PAY_EXPRESSWAY195,PAY_EXPRESSWAY100,PAY_EXPRESSWAY105RETURN, b.PAY_REPAIR, b.PAY_OTHER,b.PAY_CONDITION, b.CHECKEDBY, b.APPROVEDBY,
b.ACTIVESTATUS, b.REMARK ,CONVERT(VARCHAR(30), c.DATEVLIN, 106)  AS 'DATE_VLIN',CONVERT(VARCHAR(10), c.DATEVLIN, 103)  AS 'DATEVLIN_103',e.PRICE,
b.ACTUALPRICE,c.MATERIALTYPE,c.THAINAME
FROM [dbo].[LOGINVOICE] a
INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID]
WHERE 1 = 1" . $condBilling3 . $condBilling4.") AS A ORDER BY DOCUMENTCODE ASC";
$params_seBilling2 = array();
$query_seBilling2 = sqlsrv_query($conn, $sql_seBilling2, $params_seBilling2);
while ($result_seBilling2 = sqlsrv_fetch_array($query_seBilling2, SQLSRV_FETCH_ASSOC)) {
$rs = $result_seBilling2['ACTUALPRICE'] - ($result_seBilling2['PRICE'] * $result_seBilling2['WEIGHTINTON']);
$sql_seActualprice = "SELECT TOP 1 a.ACTUALPRICE,b.[THAINAME],b.EMPLOYEENAME1,
a.ACTUALPRICE-('" . $result_seBilling2['PRICE'] . "' * (SELECT SUM(CONVERT(DECIMAL(10,3),(CONVERT(DECIMAL(10,3),CONVERT(INT,WEIGHTIN))/1000))) FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] WHERE DOCUMENTCODE = '" . $result_seBilling2['DOCUMENTCODE'] . "' )) AS 'DIFF'
FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
WHERE a.DOCUMENTCODE = '" . $result_seBilling2['DOCUMENTCODE'] . "'
AND '" . $result_seBilling2['WEIGHTIN'] . "' = (SELECT TOP 1 WEIGHTIN FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] WHERE DOCUMENTCODE = '" . $result_seBilling2['DOCUMENTCODE'] . "' )";
$params_seActualprice = array();
$query_seActualprice = sqlsrv_query($conn, $sql_seActualprice, $params_seActualprice);
$result_seActualprice = sqlsrv_fetch_array($query_seActualprice, SQLSRV_FETCH_ASSOC);
if ($result_seActualprice['DIFF'] != '') {
$diff = number_format($result_seActualprice['DIFF'], 2);
} else {
$diff = '';
}
?>



<tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:5px;text-align:center;"><?= $i ?></td>
<td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seBilling2['PAYMENTDATEDDMMYY'] ?></td>
<td style="border-right:1px solid #000;padding:5px;text-align:left;">STC (Amata City Chonburi)</td>
<td style="border-right:1px solid #000;padding:5px;text-align:left;">Paragon (Samut prakan)</td>
<td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seBilling2['DOCUMENTCODE'] ?></td>
<td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seBilling2['WEIGHTINTON'] ?></td>
<td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seBilling2['PRICE'] ?></td>
<td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seActualprice['ACTUALPRICE'] ?></td>
<td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seActualprice['THAINAME'] ?></td>
<td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seActualprice['EMPLOYEENAME1'] ?></td>
<td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seBilling2['PRICE'] * $result_seBilling2['WEIGHTINTON'] ?></td>
<td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $diff ?></td>

</tr>
<?php
$sumtotalton1 = $sumtotalton1 + $result_seBilling2['WEIGHTINTON'];
$sumtotalprice1 = $sumtotalprice1 + $result_seActualprice['ACTUALPRICE'];
$i++;
}
?>
<tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:left;"><b>รวม<b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:left;"><b><?= $sumtotalton1 ?></b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:left;"><b><?= number_format($sumtotalprice1, 2) ?></b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
</tr>
</tbody>
</table>




<!-- ///////////////////////////////////////ไม่คิดขั้นต่ำ//////////////////////////////////////////////// -->


<table style="width: 100%;">
<thead>
<tr>
<td colspan="20" style="text-align:center;font-size:28px;"><b>เอกสารแนบการวางบิลลูกค้า (คิดขั้นต่ำ)</b></td>

</thead>
<tbody>
<tr>
<td colspan="20" style="text-align:center;font-size:22px;"><b><?= $result_seInvoice['BILLINGDATE'] ?>-<?= $result_seInvoice['PAYMENTDATE']?>(ค่าขนส่งปกติ)</b></td>
</tr>
<tr>
    <td colspan="10" style="text-align:left;"><b><font style="font-size: 18px">หมายเลขบัญชี :Charge 10 </font></b></td>
    <td colspan="10" style="text-align:right;"><b><font style="font-size: 18px">ใบแจ้งหนี้ : <?= $_GET['invoicecode'] ?> </font></b></td>
</tr>
</tbody>
</table>
<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">
<thead>

    <tr style="border:1px solid #000;padding:8px;">
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 10%;font-size: 32px">ลำดับ</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 18%;font-size: 32px">วันที่</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 25%;font-size: 32px">จาก</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 25%;font-size: 32px">ถึง</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 20%;font-size: 32px">หมายเลข <br>DO</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 14%;font-size: 32px">ปริมาณ<br>(ตัน)</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 17%;font-size: 32px">อัตรา<br>(บาท/ตัน)</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 15%;font-size: 32px">ราคา<br>(บาท)</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 16%;font-size: 32px">หมายเลขรถ</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 15%;font-size: 32px">พนักงาน</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 20%;font-size: 32px">ราคาจริง<br>(บาท)</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 15%;font-size: 32px">ผลต่าง</td>
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
        AND b.REMARK = 'Charge 10'
        ) AS A ORDER BY VEHICLETRANSPORTPLANID,WEIGHTIN ASC";
$params_seBilling = array();

$i = 1;
$i2 =0;
$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

    $sql_seActualprice = "SELECT SUM((CONVERT(DECIMAL(10,3),WEIGHTINTON )  * CONVERT(INT,PRICE))) AS'PRICEREAL'
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
        AND b.VEHICLETRANSPORTPLANID ='" .$result_seBilling['VEHICLETRANSPORTPLANID'] ."'
        ) AS A";
    $params_seActualprice = array();
    $query_seActualprice = sqlsrv_query($conn, $sql_seActualprice, $params_seActualprice);
    $result_seActualprice = sqlsrv_fetch_array($query_seActualprice, SQLSRV_FETCH_ASSOC);



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
        $diff = '';


     }else{
         $thainame = $result_seBilling['THAINAME'];
         $empname = $result_seEmployeeehr['FnameT'];
         $price = number_format($result_seBilling['PRICEAC'],2);
         $diff = number_format($result_seBilling['PRICEAC']-$result_seActualprice['PRICEREAL'],2);

         $i2++;
         $priceall = $i2*$result_seBilling['PRICEAC'];
     }
?>



<tr style="border:1px solid #000;">
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 32px"><?= $i ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:left;font-size: 32px"><?= $result_seBilling['DATEVLIN_103'] ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:left;font-size: 32px">STC<br>(Amata City Chonburi)</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:left;font-size: 32px">Paragon<br>(Samut prakan)</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:left;font-size: 32px"><?= $result_seBilling['DOCUMENTCODE'] ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 32px"><?= number_format($result_seBilling['WEIGHTINTON'],3) ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 32px"><?= number_format($result_seBilling['PRICE'],2) ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 32px"><?= $price ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 32px"><?= $thainame ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 32px"><?= $empname ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 32px"><?= number_format($pricereal,2)?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 32px"><?= $diff ?></td>
</tr>

   <?php
    $i++;
    $rs3 = $rs3 + $result_seBilling['WEIGHTINTON'];
    $rs4 = $rs4 + $pricereal;


  }////end while
?>



</tbody><tfoot>

<tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px">รวมทั้งหมด</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 32px"><?= number_format($rs3,3) ?></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 32px"><?=number_format($priceall,3) ?></td>
<td style="border-right:1px solid #000;padding:5px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:5px;text-align:right;font-size: 32px"><?=number_format($rs4,2) ?></td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 32px"><?=number_format($priceall-$rs4,2) ?></td>
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
   		 <td style="width: 33%;text-align:left;font-size:20px">ผู้จัดทำ..............................</td>

        <td style="width: 34%;text-align:center;font-size:20px">ผู้ตรวจสอบ..........................</td>

        <td style="width: 33%;text-align:right;font-size:20px">ผู้อนุมัติ..............................</td>

       </tr>



    </tbody>
</table>
<!-- //เอกสารแนบไม่คิดขั้นต่่ำ -->
<table style="width: 100%;">
<thead>
<tr>
<td colspan="20" style="text-align:center;font-size:28px;"><b>เอกสารแนบการวางบิลลูกค้า (คิดขั้นต่ำ)</b></td>

</thead>
<tbody>
<tr>
<td colspan="20" style="text-align:center;font-size:22px;"><b><?= $result_seInvoice['BILLINGDATE'] ?>-<?=$result_seInvoice['PAYMENTDATE']?>(ค่าขนส่งปกติ)</b></td>
</tr>
<tr>
    <td colspan="10" style="text-align:left;"><b><font style="font-size: 18px">หมายเลขบัญชี : </font></b></td>
    <td colspan="10" style="text-align:right;"><b><font style="font-size: 18px">ใบแจ้งหนี้ : <?= $_GET['invoicecode'] ?> </font></b></td>
</tr>
</tbody>
</table>
<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">
<thead>

    <tr style="border:1px solid #000;padding:8px;">
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 10%;font-size: 32px">ลำดับ</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 18%;font-size: 32px">วันที่</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 25%;font-size: 32px">จาก</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 25%;font-size: 32px">ถึง</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 20%;font-size: 32px">หมายเลข <br>DO</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 14%;font-size: 32px">ปริมาณ<br>(ตัน)</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 17%;font-size: 32px">อัตรา<br>(บาท/ตัน)</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 15%;font-size: 32px">ราคา<br>(บาท)</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 16%;font-size: 32px">หมายเลขรถ</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;width: 15%;font-size: 32px">พนักงาน</td>
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
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 32px"><?= $i ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:left;font-size: 32px"><?= $result_seBilling['DATEVLIN_103'] ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:left;font-size: 32px">STC<br>(Amata City Chonburi)</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:left;font-size: 32px">Paragon<br>(Samut prakan)</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:left;font-size: 32px"><?= $result_seBilling['DOCUMENTCODE'] ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 32px"><?= number_format($result_seBilling['WEIGHTINTON'],3) ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 32px"><?= number_format($result_seBilling['PRICE'],2) ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 32px"><?= $price ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 32px"><?= $thainame ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 32px"><?= $empname ?></td>
</tr>

    <?php
    $i++;
    $rs3 = $rs3 + $result_seBilling['WEIGHTINTON'];
    $rs4 = $rs4 + $pricereal;


  }////end while

?>


</tbody><tfoot>

<tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px">รวมทั้งหมด</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 32px"><?= number_format($rs3,3) ?></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 32px"><?=number_format($priceall,3) ?></td>
<td style="border-right:1px solid #000;padding:5px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
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
   		 <td style="width: 33%;text-align:left;font-size:20px">ผู้จัดทำ..............................</td>

        <td style="width: 34%;text-align:center;font-size:20px">ผู้ตรวจสอบ..........................</td>

        <td style="width: 33%;text-align:right;font-size:20px">ผู้อนุมัติ..............................</td>

       </tr>



    </tbody>
</table>

</body>
</html>
