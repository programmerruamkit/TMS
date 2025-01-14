<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
$sumgmtweight = "";
$sumcusweight = "";
$sumamounttrip = "";
$sumtotal = "";
if ($_GET['startdate'] == "" || $_GET['enddate'] == "") {
    $date_now = "";
} else {
    $date_now = $_GET['startdate'] . '-' . $_GET['enddate'];
}

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

// $condBilling1_s1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
// $condBilling2_s1 = " AND b.REMARK = 'ไม่คิดขั้นต่ำ' ";
// $sql_seBilling_s1 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
// $params_seBilling_s1 = array(
//     array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
//     array($condBilling1_s1, SQLSRV_PARAM_IN),
//     array($condBilling2_s1, SQLSRV_PARAM_IN)
// );
// $query_seBilling_s1 = sqlsrv_query($conn, $sql_seBilling_s1, $params_seBilling_s1);
// $result_seBilling_s1 = sqlsrv_fetch_array($query_seBilling_s1, SQLSRV_FETCH_ASSOC);

// $condBilling1_s2 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
// $condBilling2_s2 = " AND b.REMARK = 'Charge 12' ";
// $sql_seBilling_s2 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
// $params_seBilling_s2 = array(
//     array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
//     array($condBilling1_s2, SQLSRV_PARAM_IN),
//     array($condBilling2_s2, SQLSRV_PARAM_IN)
// );
// $query_seBilling_s2 = sqlsrv_query($conn, $sql_seBilling_s2, $params_seBilling_s2);
// $result_seBilling_s2 = sqlsrv_fetch_array($query_seBilling_s2, SQLSRV_FETCH_ASSOC);

$condInvoice21 = " AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
$condInvoice22 = "";
$sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
$params_seInvoice = array(
    array('select_loginvoice', SQLSRV_PARAM_IN),
    array($condInvoice21, SQLSRV_PARAM_IN),
    array($condInvoice22, SQLSRV_PARAM_IN)
);
$query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
$result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC);

$sql_count = "SELECT COUNT(c.VEHICLETRANSPORTPLANID) AS 'COUNTPLAN'
FROM [dbo].[LOGINVOICE] a
INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID] 
WHERE 1 = 1
AND a.INVOICECODE = 'PAR'
AND b.REMARK = 'ไม่คิดขั้นต่ำ'";
$params_count = array();
$query_count = sqlsrv_query($conn, $sql_count, $params_count);
$result_count = sqlsrv_fetch_array($query_count, SQLSRV_FETCH_ASSOC);



$mpdf = new mPDF('', 'Letter', '', '', 6, 10,30, 5,5, 10);
$style = '
<style>
	body{
		font-family: "angsana";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';

$table_header3 = '<table style="width: 100%;">
<thead>
<tr>
<td colspan="20" style="text-align:center;font-size:28px;"><b>เอกสารแนบการวางบิลลูกค้า (คิดขั้นต่ำ)</b></td>

</thead>
<tbody>
<tr>
<td colspan="20" style="text-align:center;font-size:22px;"><b>' . $result_seInvoice['BILLINGDATE'] . '-'.$result_seInvoice['PAYMENTDATE'].'(ค่าขนส่งปกติ)</b></td>
</tr>
<tr>
    <td colspan="10" style="text-align:left;"><b><font style="font-size: 18px">หมายเลขบัญชี :Charge 10 </font></b></td>
    <td colspan="10" style="text-align:right;"><b><font style="font-size: 18px">ใบแจ้งหนี้ : ' . $_GET['invoicecode'] . ' </font></b></td>
</tr>
</tbody>
</table>';
$table_begin3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead3 = '<thead>

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
</thead><tbody>';


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

$tbody3 .= '
          

<tr style="border:1px solid #000;">
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 32px">' . $i . '</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:left;font-size: 32px">' . $result_seBilling['DATEVLIN_103'] . '</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:left;font-size: 32px">STC<br>(Amata City Chonburi)</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:left;font-size: 32px">Paragon<br>(Samut prakan)</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:left;font-size: 32px">' . $result_seBilling['DOCUMENTCODE'] . '</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 32px">' . number_format($result_seBilling['WEIGHTINTON'],3) . '</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 32px">' . number_format($result_seBilling['PRICE'],2) . '</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 32px">' . $price . '</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 32px">' . $thainame . '</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 32px">' . $empname . '</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 32px">' . number_format($pricereal,2). '</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 32px">' . $diff . '</td>
</tr>
        
      ';
    $i++;
    $rs3 = $rs3 + $result_seBilling['WEIGHTINTON'];
    $rs4 = $rs4 + $pricereal;
    
    
  }////end while




$tfoot3 = '</tbody><tfoot>
    
<tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px">รวมทั้งหมด</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 32px">' . number_format($rs3,3) . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 32px">' .number_format($priceall,3) . '</td>
<td style="border-right:1px solid #000;padding:5px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:5px;text-align:right;font-size: 32px">' .number_format($rs4,2) .'</td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 32px">' .number_format($priceall-$rs4,2) . '</td>
</tr>


   
    </tfoot>';


$table_end3 = '</table>';

$table_footer3 = '<table style="width: 100%;">
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
</table>';
//เอกสารแนบไม่คิดขั้นต่่ำ
$table_header4 = '<table style="width: 100%;">
<thead>
<tr>
<td colspan="20" style="text-align:center;font-size:28px;"><b>เอกสารแนบการวางบิลลูกค้า (คิดขั้นต่ำ)</b></td>

</thead>
<tbody>
<tr>
<td colspan="20" style="text-align:center;font-size:22px;"><b>' . $result_seInvoice['BILLINGDATE'] . '-'.$result_seInvoice['PAYMENTDATE'].'(ค่าขนส่งปกติ)</b></td>
</tr>
<tr>
    <td colspan="10" style="text-align:left;"><b><font style="font-size: 18px">หมายเลขบัญชี : </font></b></td>
    <td colspan="10" style="text-align:right;"><b><font style="font-size: 18px">ใบแจ้งหนี้ : ' . $_GET['invoicecode'] . ' </font></b></td>
</tr>
</tbody>
</table>';
$table_begin4 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead4 = '<thead>

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
</thead><tbody>';


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

$tbody4 .= '
          

<tr style="border:1px solid #000;">
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 32px">' . $i . '</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:left;font-size: 32px">' . $result_seBilling['DATEVLIN_103'] . '</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:left;font-size: 32px">STC<br>(Amata City Chonburi)</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:left;font-size: 32px">Paragon<br>(Samut prakan)</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:left;font-size: 32px">' . $result_seBilling['DOCUMENTCODE'] . '</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 32px">' . number_format($result_seBilling['WEIGHTINTON'],3) . '</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 32px">' . number_format($result_seBilling['PRICE'],2) . '</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:right;font-size: 32px">' . $price . '</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 32px">' . $thainame . '</td>
  <td style="border-right:1px solid #000;padding:8px;text-align:center;font-size: 32px">' . $empname . '</td>
</tr>
        
      ';
    $i++;
    $rs3 = $rs3 + $result_seBilling['WEIGHTINTON'];
    $rs4 = $rs4 + $pricereal;
    
    
  }////end while




$tfoot4 = '</tbody><tfoot>
    
<tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px">รวมทั้งหมด</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 32px">' . number_format($rs3,3) . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;font-size: 32px">' .number_format($priceall,3) . '</td>
<td style="border-right:1px solid #000;padding:5px;text-align:center;font-size: 32px"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;font-size: 32px"></td>
</tr>


   
    </tfoot>';


$table_end4 = '</table>';

$table_footer4 = '<table style="width: 100%;">
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
</table>';




$mpdf->WriteHTML($style);
$mpdf->SetHTMLHeader($table_header3, 'O', true);
// $mpdf->WriteHTML($table_header3);
$mpdf->WriteHTML($table_begin3);
$mpdf->WriteHTML($thead3);
$mpdf->WriteHTML($tbody3);
$mpdf->WriteHTML($tfoot3);
$mpdf->WriteHTML($table_end3);
$mpdf->WriteHTML($table_footer3);
if($result_count['COUNTPLAN'] != '0'){
    $mpdf->AddPage();
    $mpdf->SetHTMLHeader($table_header4, 'O', true);
    $mpdf->WriteHTML($table_begin4);
    $mpdf->WriteHTML($thead4);
    $mpdf->WriteHTML($tbody4);
    $mpdf->WriteHTML($tfoot4);
    $mpdf->WriteHTML($table_end4);
    $mpdf->WriteHTML($table_footer4);
}else {
    # code...
}

$mpdf->Output();


sqlsrv_close($conn);
?>
