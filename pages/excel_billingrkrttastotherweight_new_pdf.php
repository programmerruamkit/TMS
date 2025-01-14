<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['invoicecode'] == "" || $_GET['invoicecode'] == "") {
    $strExcelFileName = "RKLTTAST_OTHER(WEIGHT)_Billing.xls";
} else {
    $strExcelFileName = "RKLTTAST_OTHER(WEIGHT)_Billing" . $_GET['invoicecode'] . ".xls";
}

header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

// header("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;name=\"$strExcelFileName\"");
// header("Content-Disposition: attachment; filename=\"$strExcelFileName\"");
// header("Pragma:no-cache");

// if ($_GET['startdate'] == "" || $_GET['enddate'] == "") {
//     $date_now = "";
// } else {
//     $date_now = $_GET['startdate'] . '-' . $_GET['enddate'];
// }



// $sql_getDate = "{call megStopwork_v2(?)}";
// $params_getDate = array(
//     array('select_getdate', SQLSRV_PARAM_IN)
// );
// $query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
// $result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);



$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,BILLING,INVOICECODE
FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '" . $_GET['invoicecode'] . "'";
$query_seInvoicecode  = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);

$sql_seSection = "SELECT TOP 1 e.VEHICLETRANSPORTPRICEID, e.BILLING2 AS 'SECTION'
    FROM   [dbo].[VEHICLETRANSPORTPLAN] c
    INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID]
    WHERE 1 = 1
    AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103)
    --AND a.INVOICECODE = 'TEST_TTASTW'
    --AND b.REMARK = 'CHARGE 12'
    AND e.CARRYTYPE ='weight'";
$query_seSection  = sqlsrv_query($conn, $sql_seSection, $params_seSection);
$result_seSection = sqlsrv_fetch_array($query_seSection, SQLSRV_FETCH_ASSOC);

// COUNT หาข้อมูลที่ไม่คิดขั้นต่ำ
$sql_count = "SELECT COUNT(c.VEHICLETRANSPORTPLANID) AS 'COUNTPLAN'
    FROM [dbo].[LOGINVOICE] a
    INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
    INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID]
    WHERE 1 = 1
    AND a.INVOICECODE = '" . $_GET['invoicecode'] . "'
    AND b.REMARK = 'ไม่คิดขั้นต่ำ'
    AND e.CARRYTYPE ='weight'
    AND e.WORKTYPE  ='other'";
$params_count   = array();
$query_count    = sqlsrv_query($conn, $sql_count, $params_count);
$result_count   = sqlsrv_fetch_array($query_count, SQLSRV_FETCH_ASSOC);

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
<td colspan="16" style="text-align:center;font-size:28px;"><b>เอกสารแนบการวางบิลลูกค้า (คิดขั้นต่ำ)</b></td>

</thead>
<tbody>
<tr>
<td colspan="16" style="text-align:center;font-size:22px;"><b><?= $result_seInvoicecode['BILLINGDATE'] ?>-<?=$result_seInvoicecode['PAYMENTDATE']?>(ค่าขนส่งปกติ)</b></td>
</tr>
<tr>
    <td colspan="4" style="text-align:left;"><b><font style="font-size: 18px">หมายเลขบัญชี : <?=$result_seSection['SECTION']?> Charge 12 </font></b></td>
    <td colspan="12" style="text-align:right;"><b><font style="font-size: 18px">ใบแจ้งหนี้ : <?= $_GET['invoicecode'] ?> </font></b></td>
</tr>
</tbody>
</table>
<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">
<thead>

    <tr style="border:1px solid #000;padding:8px;">
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">ลำดับ</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">วันที่</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">INVOICEDATE</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">INVOICENO</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">SECTION</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">จาก</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">ถึง</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">พื้นที่</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">หมายเลข DO </td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">ปริมาณ<br>(ตัน)</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">อัตรา<br>(บาท/ตัน)</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">ราคา<br>(บาท)</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">หมายเลขรถ</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">พนักงาน</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">ราคาจริง<br>(บาท)</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">ผลต่าง</td>
    </tr>
</thead><tbody>

<?php
$i  = 1;
// $i2 = 0;
$sql_seBilling = "SELECT ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY c.VEHICLETRANSPORTPLANID,b.DOCUMENTCODE  ASC) AS 'ROWNUM',
    b.VEHICLETRANSPORTPLANID AS 'PLANID',CONVERT(VARCHAR(10), c.DATEVLIN, 103)  AS 'DATE',e.BILLING2 AS 'SECTION',b.JOBSTART AS 'JOBSTART',b.JOBEND AS 'JOBEND',
    b.WEIGHTIN,b.DOCUMENTCODE AS 'DOCUMENTCODE',e.PRICE AS 'PRICE',b.REMARKHEAD AS 'REMARK', b.ACTUALPRICE AS 'ACTUALPRICE',
    c.EMPLOYEECODE1 AS 'EMPCODE',b.WEIGHTIN AS 'WEIGHTIN',c.THAINAME AS 'THAINAME'
    FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b
    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
    INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID]
    WHERE 1 = 1
    AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103)
    --AND a.INVOICECODE = 'TEST_TTASTW'
    AND b.REMARK = 'CHARGE 12'
    AND e.CARRYTYPE ='weight'
    ORDER BY c.VEHICLETRANSPORTPLANID,b.DOCUMENTCODE ASC";
$params_seBilling = array();
$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {



    // คำนวณน้ำหนักรวมของแต่ละ PLANID และ ปลายทาง
    $sql_seSumWeighTrip = "SELECT SUM(CONVERT(DECIMAL(10,3),WEIGHTIN))/1000 AS 'WEIGHTIN_TRIP'
                            FROM VEHICLETRANSPORTDOCUMENTDIRVER
                            WHERE [VEHICLETRANSPORTPLANID] = '".$result_seBilling['PLANID']."'
                            AND JOBEND ='".$result_seBilling['JOBEND']."'";
    $query_seSumWeighTrip = sqlsrv_query($conn, $sql_seSumWeighTrip, $params_seSumWeighTrip);
    $result_seSumWeighTrip = sqlsrv_fetch_array($query_seSumWeighTrip, SQLSRV_FETCH_ASSOC);


    $sql_seEmployeeehr = "SELECT FnameT AS 'FnameT',LnameT AS 'LnameT'
        FROM EMPLOYEEEHR2
        WHERE PersonCode ='".$result_seBilling['EMPCODE']."'";
    $params_seEmployeeehr = array();
    $query_seEmployeeehr  = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
    $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);

    //เช็ค MAX ROWNUM ของ PLANID ที่มากที่สุด
    $sql_RowNumChk = "SELECT TOP 1 ROW_NUMBER() OVER (PARTITION BY a.VEHICLETRANSPORTPLANID ORDER BY a.VEHICLETRANSPORTPLANID,a.DOCUMENTCODE ASC) AS 'ROWNUM_CHK'
        FROM VEHICLETRANSPORTDOCUMENTDIRVER a
        WHERE a.VEHICLETRANSPORTPLANID ='".$result_seBilling['PLANID']."'
        --AND a.JOBEND ='".$result_seBilling['TO']."'
        ORDER BY ROW_NUMBER() OVER (PARTITION BY a.VEHICLETRANSPORTPLANID ORDER BY a.VEHICLETRANSPORTPLANID,a.DOCUMENTCODE ASC) DESC";
    $query_RowNumChk = sqlsrv_query($conn, $sql_RowNumChk, $params_RowNumChk);
    $result_RowNumChk = sqlsrv_fetch_array($query_RowNumChk, SQLSRV_FETCH_ASSOC);

    // $pricereal = number_format($result_seBilling['WEIGHTINTON'],3) * number_format($result_seBilling['PRICE'],2);

    // CHECK ROWNUM ถ้า ROWNUM มากสุด = ROW NUM CHK จากการเช็คข้อมูล
    if($result_seBilling['ROWNUM']  == $result_RowNumChk['ROWNUM_CHK']){

        $WEIGHTIN       = $result_seSumWeighTrip['WEIGHTIN_TRIP'];
        $PRICETON       = $result_seBilling['PRICE'];
        $ACTUALPRICE    = number_format($result_seBilling['ACTUALPRICE'],2);
        $THAINAME       = $result_seBilling['THAINAME'];
        $DRIVER         = $result_seEmployeeehr['FnameT'];
        $REALRICE       = number_format($result_seSumWeighTrip['WEIGHTIN_TRIP']*$result_seBilling['PRICE'],2);
        $DIFF           = number_format($result_seBilling['ACTUALPRICE']-($result_seSumWeighTrip['WEIGHTIN_TRIP']*$result_seBilling['PRICE']),2);

     }else{

        $WEIGHTIN       = '';
        $PRICETON       = '';
        $ACTUALPRICE    = '';
        $THAINAME       = '';
        $DRIVER         = '';
        $REALRICE       = '';
        $DIFF           = '';

     }

     if($result_seBilling['ROWNUM'] > 1 )
     {
       $i--;
       $NO = '';

     }else {
       $NO = $i;
     }

?>
<tr style="border:1px solid #000;">
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px"><?= $NO ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px"><?= $result_seBilling['DATE'] ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px"><?= $result_seInvoicecode['BILLINGDATE'] ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px"><?= $result_seInvoicecode['INVOICECODE'] ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px"><?= $result_seBilling['SECTION'] ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px"><?= $result_seBilling['JOBSTART'] ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px"><?= ($result_seBilling['JOBEND']  == 'TMG' ? 'TMT/GW' : $result_seBilling['JOBEND']) ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">Gateway</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px"><?= $result_seBilling['DOCUMENTCODE'] ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 14px"><?= $WEIGHTIN == '' ? '' : number_format($WEIGHTIN,3) ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 14px"><?= $PRICETON == '' ? '' : number_format($PRICETON,2) ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 14px"><?= $ACTUALPRICE ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px"><?= $THAINAME ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px"><?= $DRIVER ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 14px"><?= $REALRICE?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 14px"><?= $DIFF ?></td>
</tr>

<?php

    $i++;
    $WEIGHTIN_ALL12     = $WEIGHTIN_ALL12    + $WEIGHTIN;
    $ACTUALPRICE_ALL12  = $ACTUALPRICE_ALL12 + str_replace(",","",$ACTUALPRICE);
    $REALPRICE_ALL12    = $REALPRICE_ALL12   + str_replace(",","",$REALRICE);
    $DIFF_ALL12         = $DIFF_ALL12        + str_replace(",","",$DIFF);

  }////end while

?>


</tbody><tfoot>
    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px">รวมทั้งหมด</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 14px"><?=number_format($WEIGHTIN_ALL12,3)?></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 14px"><?=number_format($ACTUALPRICE_ALL12,2)?></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:right;font-size: 14px"><?=number_format($REALPRICE_ALL12,2)?></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 14px"><?=number_format($DIFF_ALL12,2)?></td>
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
        <td style="width: 10%;text-align:right">ผู้จัดทำ</td>
        <td style="width: 25%;">........................................</td>
        <td style="width: 10%;text-align:right">ผู้ตรวจสอบ</td>
        <td style="width: 20%;">........................................</td>
        <td style="width: 10%;text-align:right">ผู้อนุมัติ</td>
        <td style="width: 25%;">........................................</td>
    </tr>
    </tbody>
</table>

<?php
if($result_count['COUNTPLAN'] != '0'){

//เอกสารแนบไม่คิดขั้นต่่ำ
?>
<table style="width: 100%;">
<thead>
<tr>
<td colspan="16" style="text-align:center;font-size:28px;"><b>เอกสารแนบการวางบิลลูกค้า (คิดขั้นต่ำ)</b></td>

</thead>
<tbody>
<tr>
<td colspan="16" style="text-align:center;font-size:22px;"><b><?= $result_seInvoicecode['BILLINGDATE'] ?>-<?=$result_seInvoicecode['PAYMENTDATE']?>(ค่าขนส่งปกติ)</b></td>
</tr>
<tr>
    <td colspan="4" style="text-align:left;"><b><font style="font-size: 18px">หมายเลขบัญชี : <?=$result_seSection['SECTION']?> คิดขั้นต่ำ </font></b></td>
    <td colspan="12" style="text-align:right;"><b><font style="font-size: 18px">ใบแจ้งหนี้ : <?= $_GET['invoicecode'] ?> </font></b></td>
</tr>
</tbody>
</table>
<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">';
<thead>

    <tr style="border:1px solid #000;padding:8px;">
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">ลำดับ</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">วันที่</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">INVOICEDATE</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">INVOICENO</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">SECTION</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">จาก</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">ถึง</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">พื้นที่</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">หมายเลข DO </td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">ปริมาณ<br>(ตัน)</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">อัตรา<br>(บาท/ตัน)</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">ราคา<br>(บาท)</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">หมายเลขรถ</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">พนักงาน</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">ราคาจริง<br>(บาท)</td>
        <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">ผลต่าง</td>
    </tr>
</thead><tbody>

<?php
$i = 1;
// $i2 =0;
$sql_seBilling = "SELECT ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY c.VEHICLETRANSPORTPLANID,b.DOCUMENTCODE  ASC) AS 'ROWNUM',
        b.VEHICLETRANSPORTPLANID AS 'PLANID',CONVERT(VARCHAR(10), c.DATEVLIN, 103)  AS 'DATE',e.BILLING2 AS 'SECTION',b.JOBSTART AS 'JOBSTART',b.JOBEND AS 'JOBEND',
        b.WEIGHTIN,b.DOCUMENTCODE AS 'DOCUMENTCODE',e.PRICE AS 'PRICE',b.REMARKHEAD AS 'REMARK', b.ACTUALPRICE AS 'ACTUALPRICE',
        c.EMPLOYEECODE1 AS 'EMPCODE',b.WEIGHTIN AS 'WEIGHTIN',c.THAINAME AS 'THAINAME'
        FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b
        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
        INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID]
        WHERE 1 = 1
        AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103)
        --AND a.INVOICECODE = 'TEST_TTASTW'
        AND b.REMARK = 'CHARGE 12'
        AND e.CARRYTYPE ='weight'
        ORDER BY c.VEHICLETRANSPORTPLANID,b.DOCUMENTCODE ASC";
$params_seBilling = array();
$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

    // คำนวณน้ำหนักรวมของแต่ละ PLANID และ ปลายทาง
    $sql_seSumWeighTrip = "SELECT SUM(CONVERT(DECIMAL(10,3),WEIGHTIN))/1000 AS 'WEIGHTIN_TRIP'
                            FROM VEHICLETRANSPORTDOCUMENTDIRVER
                            WHERE [VEHICLETRANSPORTPLANID] = '".$result_seBilling['PLANID']."'
                            AND JOBEND ='".$result_seBilling['JOBEND']."'";
    $query_seSumWeighTrip = sqlsrv_query($conn, $sql_seSumWeighTrip, $params_seSumWeighTrip);
    $result_seSumWeighTrip = sqlsrv_fetch_array($query_seSumWeighTrip, SQLSRV_FETCH_ASSOC);


    $sql_seEmployeeehr = "SELECT FnameT AS 'FnameT',LnameT AS 'LnameT'
        FROM EMPLOYEEEHR2
        WHERE PersonCode ='".$result_seBilling['EMPCODE']."'";
    $params_seEmployeeehr = array();
    $query_seEmployeeehr  = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
    $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);

    //เช็ค MAX ROWNUM ของ PLANID ที่มากที่สุด
    $sql_RowNumChk = "SELECT TOP 1 ROW_NUMBER() OVER (PARTITION BY a.VEHICLETRANSPORTPLANID ORDER BY a.VEHICLETRANSPORTPLANID,a.DOCUMENTCODE ASC) AS 'ROWNUM_CHK'
        FROM VEHICLETRANSPORTDOCUMENTDIRVER a
        WHERE a.VEHICLETRANSPORTPLANID ='".$result_seBilling['PLANID']."'
        --AND a.JOBEND ='".$result_seBilling['TO']."'
        ORDER BY ROW_NUMBER() OVER (PARTITION BY a.VEHICLETRANSPORTPLANID ORDER BY a.VEHICLETRANSPORTPLANID,a.DOCUMENTCODE ASC) DESC";
    $query_RowNumChk = sqlsrv_query($conn, $sql_RowNumChk, $params_RowNumChk);
    $result_RowNumChk = sqlsrv_fetch_array($query_RowNumChk, SQLSRV_FETCH_ASSOC);

    // $pricereal = number_format($result_seBilling['WEIGHTINTON'],3) * number_format($result_seBilling['PRICE'],2);

    // CHECK ROWNUM ถ้า ROWNUM มากสุด = ROW NUM CHK จากการเช็คข้อมูล
    if($result_seBilling['ROWNUM']  == $result_RowNumChk['ROWNUM_CHK']){

        $WEIGHTIN       = $result_seSumWeighTrip['WEIGHTIN_TRIP'];
        $PRICETON       = $result_seBilling['PRICE'];
        $ACTUALPRICE    = number_format($result_seBilling['ACTUALPRICE'],2);
        $THAINAME       = $result_seBilling['THAINAME'];
        $DRIVER         = $result_seEmployeeehr['FnameT'];
        $REALRICE       = number_format($result_seSumWeighTrip['WEIGHTIN_TRIP']*$result_seBilling['PRICE'],2);
        $DIFF           = number_format($result_seBilling['ACTUALPRICE']-($result_seSumWeighTrip['WEIGHTIN_TRIP']*$result_seBilling['PRICE']),2);

     }else{

        $WEIGHTIN       = '';
        $PRICETON       = '';
        $ACTUALPRICE    = '';
        $THAINAME       = '';
        $DRIVER         = '';
        $REALRICE       = '';
        $DIFF           = '';

     }

     if($result_seBilling['ROWNUM'] > 1 )
     {
       $i--;
       $NO = '';

     }else {
       $NO = $i;
     }

?>

<tr style="border:1px solid #000;">
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px"><?= $NO ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px"><?= $result_seBilling['DATE'] ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px"><?= $result_seInvoicecode['BILLINGDATE'] ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px"><?= $result_seInvoicecode['INVOICECODE'] ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px"><?= $result_seBilling['SECTION'] ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px"><?= $result_seBilling['JOBSTART'] ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px"><?= ($result_seBilling['JOBEND']  == 'TMG' ? 'TMT/GW' : $result_seBilling['JOBEND']) ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px">Gateway</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px"><?= $result_seBilling['DOCUMENTCODE'] ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 14px"><?= $WEIGHTIN == '' ? '' : number_format($WEIGHTIN,3) ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 14px"><?= $PRICETON == '' ? '' : number_format($PRICETON,2) ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 14px"><?= $ACTUALPRICE ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px"><?= $THAINAME ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 14px"><?= $DRIVER ?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 14px"><?= $REALRICE?></td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 14px"><?= $DIFF ?></td>
</tr>

<?php
    $i++;
    $WEIGHTIN_NC     = $WEIGHTIN_NC    + $WEIGHTIN;
    $ACTUALPRICE_NC  = $ACTUALPRICE_NC + str_replace(",","",$ACTUALPRICE);
    $REALPRICE_NC    = $REALPRICE_NC   + str_replace(",","",$REALRICE);
    $DIFF_NC         = $DIFF_NC        + str_replace(",","",$DIFF);


  }////end while
?>



</tbody><tfoot>
    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px">รวมทั้งหมด</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 14px"><?= number_format($WEIGHTIN_NC,3) ?></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 14px"><?= number_format($ACTUALPRICE_NC,2) ?></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 14px"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:right;font-size: 14px"><?= number_format($REALPRICE_NC,2) ?></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 14px"><?= number_format($DIFF_NC,2) ?></td>
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
        <td style="width: 10%;text-align:right">ผู้จัดทำ</td>
        <td style="width: 25%;">........................................</td>
        <td style="width: 10%;text-align:right">ผู้ตรวจสอบ</td>
        <td style="width: 20%;">........................................</td>
        <td style="width: 10%;text-align:right">ผู้อนุมัติ</td>
        <td style="width: 25%;">........................................</td>
    </tr>
    </tbody>
</table>
 <?php
}else{
 ?>

 <?php
}
 ?>
    </body>
    </html>
