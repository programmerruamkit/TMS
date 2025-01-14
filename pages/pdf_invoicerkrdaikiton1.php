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

$condBilling1_s1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condBilling2_s1 = " AND b.REMARK = 'ไม่คิดขั้นต่ำ' ";
$sql_seBilling_s1 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBilling_s1 = array(
    array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
    array($condBilling1_s1, SQLSRV_PARAM_IN),
    array($condBilling2_s1, SQLSRV_PARAM_IN)
);
$query_seBilling_s1 = sqlsrv_query($conn, $sql_seBilling_s1, $params_seBilling_s1);
$result_seBilling_s1 = sqlsrv_fetch_array($query_seBilling_s1, SQLSRV_FETCH_ASSOC);

$condBilling1_s2 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condBilling2_s2 = " AND b.REMARK = 'Charge 12' ";
$sql_seBilling_s2 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBilling_s2 = array(
    array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
    array($condBilling1_s2, SQLSRV_PARAM_IN),
    array($condBilling2_s2, SQLSRV_PARAM_IN)
);
$query_seBilling_s2 = sqlsrv_query($conn, $sql_seBilling_s2, $params_seBilling_s2);
$result_seBilling_s2 = sqlsrv_fetch_array($query_seBilling_s2, SQLSRV_FETCH_ASSOC);

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

$mpdf = new mPDF('', 'Letter', '', '', 6, 22, 25, 5, 5, 10);
$style = '
<style>
	body{
		font-family: "angsana";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';

$table_header3 = '<table style="width: 100%;">
<thead>
<tr>
<td style="text-align:center;font-size:28px;"><b>เอกสารแนบการวางบิลลูกค้า (ไม่คิดขั้นต่ำ)</b></td>

</thead>
<tbody>
<tr>
<td style="text-align:center;font-size:22px;"><b>' . $result_seInvoice['BILLINGDATE'] . '-'.$result_seInvoice['PAYMENTDATE'].'(ค่าขนส่งปกติ)</b></td>
</tr>


</tbody>
</table>';

$table_begin3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead3 = '<thead>
<tr>
  <td colspan="6" style="text-align:left;"><b><font style="font-size: 18px">หมายเลขบัญชี :- </font></b></td>
  <td colspan="6" style="text-align:right;"><b><font style="font-size: 18px">ใบแจ้งหนี้ : ' . $_GET['invoicecode'] . ' </font></b></td>
  </tr>
        <tr style="border:1px solid #000;padding:6px;">



        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 6%;"><b><font style="font-size: 18px">ลำดับ</font></b></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 10%;"><b><font style="font-size: 18px">วันที่</font></b></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 19%;"><b><font style="font-size: 18px">จาก</font></b></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 19%;"><b><font style="font-size: 18px">ถึง</font></b></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 15%;"><b><font style="font-size: 18px">หมายเลข DO</font></b></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 8%;"><b><font style="font-size: 18px">ปริมาณ<br>(ตัน)</font></b></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 10%;"><b><font style="font-size: 18px">อัตรา<br>(บาท/ตัน)</font></b></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 10%;"><b><font style="font-size: 18px">ราคา</font></b></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 10%;"><b><font style="font-size: 18px">หมายเลขรถ</font></b></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 10%;"><b><font style="font-size: 18px">พนักงาน</font></b></td>
       
      </tr>
    </thead><tbody>';

$condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condBilling2 = " AND (b.REMARK = 'ไม่คิดขั้นต่ำ' OR b.REMARK = 'Charge 12')";
$sql_seBilling = "SELECT * FROM (SELECT DISTINCT e.VEHICLETYPE,CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CASE
				WHEN b.REMARK = 'Charge 7' THEN b.WEIGHTIN
				WHEN b.REMARK = 'Charge 10' THEN 10000
				ELSE CONVERT(INT,b.WEIGHTIN)
				END) / 1000) * CONVERT(INT,REPLACE(e.[PRICE],'<br><br>',''))) AS 'PRICEAC',
				b.ACTUALPRICE_TEMP,CONVERT(VARCHAR(2),a.BILLINGDATE) AS 'BILLINGDATEDAY',CONVERT(VARCHAR(2),a.PAYMENTDATE) AS 'PAYMENTDATEDD',CONVERT(VARCHAR, CONVERT(DATETIME,a.PAYMENTDATE,103), 103) AS 'PAYMENTDATEDDMMYY', 
				SUBSTRING(convert(VARCHAR, CONVERT(DATETIME,a.PAYMENTDATE,103), 106),3,10) AS 'PAYMENTDATEDDYY',b.VEHICLETRANSPORTDOCUMENTDRIVERID, b.VEHICLETRANSPORTPLANID,b.DOCUMENTCODE, b.COMPANYCODE, 
				b.CUSTOMERCODE, b.EMPLOYEECODE1, b.EMPLOYEENAME1, b.EMPLOYEECODE2, b.EMPLOYEENAME2, b.JOBSTART, b.JOBEND,CONVERT(NVARCHAR,CONVERT(DECIMAL(10,3),(CONVERT(DECIMAL(10,3),CONVERT(INT,b.WEIGHTIN))/1000))) AS 'WEIGHTINTON', 
				b.WEIGHTIN, b.WEIGHTOUT, b.TRIPAMOUNT, b.VEHICLEREGISNUMBER, b.COMPENSATION,b.COMPENSATION1,b.COMPENSATION2,b.OVERTIME, b.OTHER, b.PAY_REMARK, 
				b.PAY_APPROVERS, b.PAY_EXPRESSWAY,PAY_EXPRESSWAY15,PAY_EXPRESSWAY25,PAY_EXPRESSWAY45,PAY_EXPRESSWAY50,PAY_EXPRESSWAY50RETURN,PAY_EXPRESSWAY55,PAY_EXPRESSWAY65,PAY_EXPRESSWAY65RETURN,PAY_EXPRESSWAY75,PAY_EXPRESSWAY195,PAY_EXPRESSWAY100,PAY_EXPRESSWAY105RETURN, b.PAY_REPAIR, b.PAY_OTHER,b.PAY_CONDITION, b.CHECKEDBY, b.APPROVEDBY, 
				b.ACTIVESTATUS, b.REMARK ,CONVERT(VARCHAR(30), c.DATEVLIN, 103)  AS 'DATE_VLIN',CONVERT(VARCHAR(10), c.DATEVLIN, 103)  AS 'DATEVLIN_103',e.PRICE,
				b.ACTUALPRICE,c.MATERIALTYPE,c.THAINAME
				FROM [dbo].[LOGINVOICE] a
				INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
				INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
				INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID] 
				WHERE 1 = 1" . $condBilling1 . $condBilling2 . ") AS A ORDER BY DOCUMENTCODE,JOBEND,WEIGHTIN ASC";
$params_seBilling = array();


$i = 1;
$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

    $sql_seActualprice = "SELECT TOP 1 a.ACTUALPRICE,b.[THAINAME],b.EMPLOYEENAME1,
    a.ACTUALPRICE-('" . $result_seBilling['PRICE'] . "' * (SELECT SUM(CONVERT(DECIMAL(10,3),(CONVERT(DECIMAL(10,3),CONVERT(INT,WEIGHTIN))/1000))) FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] WHERE DOCUMENTCODE = '" . $result_seBilling['DOCUMENTCODE'] . "' )) AS 'DIFF'
    FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a 
    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
    WHERE a.DOCUMENTCODE = '" . $result_seBilling['DOCUMENTCODE'] . "' 
    AND '" . $result_seBilling['WEIGHTIN'] . "' = (SELECT TOP 1 WEIGHTIN FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] WHERE DOCUMENTCODE = '" . $result_seBilling['DOCUMENTCODE'] . "' ORDER BY WEIGHTIN DESC)  ORDER BY a.WEIGHTIN DESC";
    $params_seActualprice = array();
    $query_seActualprice = sqlsrv_query($conn, $sql_seActualprice, $params_seActualprice);
    $result_seActualprice = sqlsrv_fetch_array($query_seActualprice, SQLSRV_FETCH_ASSOC);
    if ($result_seActualprice['DIFF'] != '') {
    $diff = number_format($result_seActualprice['DIFF'], 2);
    } else {
    $diff = '';
    }

    $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seActualprice['EMPLOYEENAME1'] . "' ";
    $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmployeeehr = array(
        array('select_employeeehr2', SQLSRV_PARAM_IN),
        array($condEmployeeehr1, SQLSRV_PARAM_IN)
    );
    $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
    $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
 $tbody3 .= '
          

      <tr style="border:1px solid #000;">
      
 <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 18px">' . $i . '</font></td>
  <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 18px">' . $result_seBilling['DATE_VLIN'] . '</font></td>
  <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 18px">DAIKI : Amatanakorn</font></td>
  <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 18px">STM : Amatanakorn</font></td>
  <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 18px">' . $result_seBilling['DOCUMENTCODE'] . '</font></td>
  <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 18px">' . $result_seBilling['WEIGHTINTON'] . '</font></td>
  <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 18px">' . number_format($result_seBilling['PRICE'],2) . '</font></td>
  <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 18px">' . number_format($result_seBilling['PRICEAC'],2) . '</font></td>
  <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 18px">' . $result_seActualprice['THAINAME'] . '</font></td>
  <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 18px">' . $result_seEmployeeehr['FnameT'] . '</font></td>
 
      


       
      </tr>
        
      ';
      $i++;
    $rs3 = $rs3 + $result_seBilling['WEIGHTINTON'];
    $rs4 = $rs4 + $result_seBilling['PRICEAC'];

    
  }////end while




$tfoot3 = '</tbody><tfoot>
    
<tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><font style="font-size: 18px">รวมทั้งหมด<b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>

<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;"><font style="font-size: 18px">' . number_format($rs3,3) . '</font></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;"><font style="font-size: 18px">' . number_format($rs4,2) . '</font></td>
<td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
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



$mpdf->WriteHTML($style);
$mpdf->SetHTMLHeader($table_header3, 'O', true);

//
// $mpdf->WriteHTML($table_header3);
$mpdf->WriteHTML($table_begin3);
$mpdf->WriteHTML($thead3);
$mpdf->WriteHTML($tbody3);
$mpdf->WriteHTML($tfoot3);
$mpdf->WriteHTML($table_end3);
$mpdf->WriteHTML($table_footer3);

$mpdf->Output();


sqlsrv_close($conn);
?>
