<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
$sumtotal = "";

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);


$rsprice=0;

// $mpdf = new mPDF('th', 'A4', '0', '');
$mpdf = new mPDF('', 'Letter', '', '', 2, 18, '', 5, '', 15);
$style = '
<style>
	body{
		font-family: "angsana";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';

////////////////////ใบแจ้งหนี้ ใบเสร็จ//////////////////////////////////////////////////
$table_header11 = '<br>';
$table_header1 = '<table width="100%" >
    <tbody>
        <tr>
        	<td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
            <td colspan="7" style="font-size:24px"><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICE CO.,LTD)<b></td>
       </tr>
       <tr>
        	<td colspan="7" style="font-size:20px">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160</td>
       </tr>
        <tr>
        	<td colspan="7" style="font-size:20px">โทรศัพท์: 038-452824-5 โทรสาร : 038-210396</td>
       </tr>
        <tr>
        	<td colspan="7" style="font-size:20px">เลขประจำตัวผู้เสียภาษี 0105544064899</td>
       </tr>

       <tr>
        	<td colspan="8" style="text-align:center;font-size:20px"><b>ใบแจ้งหนี้/ใบเสร็จรับเงิน</b></td>
       </tr>

    </tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;font-size:22px">
    <tbody>

       <tr style="border:1px solid #000;">
       	  <td style="border-right:1px solid #000;padding:4px;width:70%" rowspan="4">ลูกค้า : รหัส ต-002
								<br>บริษัท สยามโตโยต้าอุตสาหกรรม จำกัด
								<br>สำนักงานใหญ่ 700/109,111,113 ม.1 นิคมอุตสาหกรรมอมตะนคร
								<br>ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160
                                                                <br>โทร. 038-469000

		  <br>เลขประจำตัวผู้เสียภาษี 0105530032434</td>
            <td style="border-right:1px solid #000;padding:4px;width:30%">เลขที่ : ' . $result_seBillinginvoice['INVOICECODE'] . '</td>
       </tr>
       <tr style="border:1px solid #000;">
       	  <td style="border-right:1px solid #000;padding:4px;width:30%">วันที่ : ' . $result_seBillinginvoice['DUEDATE'] . '</td>
       </tr>
       <tr style="border:1px solid #000;">
       	  <td style="border-right:1px solid #000;padding:4px;width:30%">เครดิต : 30 วัน</td>
       </tr>
       <tr style="border:1px solid #000;">
       	  <td style="border-right:1px solid #000;padding:4px;width:30%">วันที่ครบกำหนด : ' . $result_seBillinginvoice['PAYMENTDATE'] . '</td>
       </tr>


    </tbody>
</table>';

$table_begin1 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;font-size:20px">';
$thead1 = '<thead>
        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:60%"><b>รายการ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:30%"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
  </thead><tbody>';
$i2 = 1;
$sql_seBillinginvoice1 = "SELECT DISTINCT a.INVOICECODE,a.BILLINGDATE, a.PAYMENTDATE,CASE WHEN b.[TRANSPORTATION]='STM(F.1)->STM(F.2) (IP01)' THEN 'IP-01'
WHEN b.[TRANSPORTATION]='STM(F.1)->STM(F.2) (IP02)' THEN 'IP-02'
WHEN b.[TRANSPORTATION]='STM(F.1)->STM(F.2) (IP03)' THEN 'IP-03'
WHEN b.[TRANSPORTATION]='STM(F.1)->STM(F.2) (IP04)' THEN 'IP-04'
WHEN b.[TRANSPORTATION]='STM(F.1)->STM(F.2) (IP05)' THEN 'IP-05'
WHEN b.[TRANSPORTATION]='STM(F.1)->STM(F.2) (IP06)' THEN 'IP-06' ELSE '' END AS 'TRANSPORTATION',b.[TRANSPORTATION] AS 'TRANSPORTATION2' FROM [dbo].[LOGBILLINGINVOICE] a
INNER JOIN [dbo].[LOGINVOICE] b ON a.INVOICECODE = b.INVOICECODE
WHERE a.ACTIVESTATUS = '1' AND a.BILLINGCODE = '" . $_GET['billingcode'] . "'";
$params_seBillinginvoice1 = array();
$query_seBillinginvoice1 = sqlsrv_query($conn, $sql_seBillinginvoice1, $params_seBillinginvoice1);

$tbody1 .= '<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" valign="top">1</td>
        <td style="border-right:1px solid #000;padding:4px;"  valign="top">';
$tbody1 .= 'ค่าขนส่งสินค้าตามเอกสารแนบ<br>';
$tbody1 .= 'Transportation charge : STM TO INTERPLANT (10 Wheels)<br>';
while ($result_seBillinginvoice1 = sqlsrv_fetch_array($query_seBillinginvoice1, SQLSRV_FETCH_ASSOC)) {

    $sql_sePriceholip01 = "SELECT TOP 1 PRICE FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE [VEHICLETYPE]='10W' AND [FROM]='" . $result_seBillinginvoice1['TRANSPORTATION2'] . "' ORDER BY [CREATEDATE] DESC";
    $params_sePriceholip01 = array();
    $query_sePriceholip01 = sqlsrv_query($conn, $sql_sePriceholip01, $params_sePriceholip01);
    $result_sePriceholip01 = sqlsrv_fetch_array($query_sePriceholip01, SQLSRV_FETCH_ASSOC);



    $sql_seBiv01 = "SELECT TOP 1 INVOICECODE FROM [dbo].[LOGBILLINGINVOICE] WHERE [BILLINGCODE] = '" . $_GET['billingcode'] . "' ";
    $query_seBiv01 = sqlsrv_query($conn, $sql_seBiv01, $params_seBiv01);
    $result_seBiv01 = sqlsrv_fetch_array($query_seBiv01, SQLSRV_FETCH_ASSOC);

    $sql_seIv01 = "SELECT VLINDATE FROM [dbo].[LOGINVOICE] WHERE [INVOICECODE] = '" . $result_seBiv01['INVOICECODE'] . "' AND [TRANSPORTATION] = '" . $result_seBillinginvoice1['TRANSPORTATION2'] . "'";
    $query_seIv01 = sqlsrv_query($conn, $sql_seIv01, $params_seIv01);
    $result_seIv01 = sqlsrv_fetch_array($query_seIv01, SQLSRV_FETCH_ASSOC);

    $sql_seTripamountip01 = "SELECT SUM(CAST(LEFT(b.ROUNDAMOUNT,PATINDEX('%[^0-9]%',b.ROUNDAMOUNT)-1) AS int)) AS 'SUMTRIPSTM'
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
            WHERE 1 = 1
            AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seIv01['VLINDATE'] . "',111) AND CONVERT(DATE,'" . $result_seIv01['VLINDATE'] . "',111)
            AND b.COMPANYCODE = 'RKS' AND b.CUSTOMERCODE = 'STM'
            AND a.DOCUMENTCODE != ''
            AND (SUBSTRING(ROUNDAMOUNT, 3, 3) = 'D' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'D'
            OR SUBSTRING(ROUNDAMOUNT, 3, 3) = 'N' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'N' )  ";
    $query_seTripamountip01 = sqlsrv_query($conn, $sql_seTripamountip01, $params_seTripamountip01);
    $result_seTripamountip01 = sqlsrv_fetch_array($query_seTripamountip01, SQLSRV_FETCH_ASSOC);




    $tbody1 .= $result_seBillinginvoice1['TRANSPORTATION'] . ' = ' . $result_sePriceholip01['PRICE'] . ' PRICE X ' . $result_seTripamountip01['SUMTRIPSTM'] . ' TRIP';
    $tbody1 .= '<br>';
}
$tbody1 .= '</td>';
       $tbody1 .= '<td style="border-right:1px solid #000;padding:4px;text-align:right;" valign="top">';
       $tbody1 .= '<br><br>';
       $sql_seBillinginvoice1_1 = "SELECT DISTINCT a.INVOICECODE,a.BILLINGDATE, a.PAYMENTDATE,CASE WHEN b.[TRANSPORTATION]='STM(F.1)->STM(F.2) (IP01)' THEN 'IP-01'
WHEN b.[TRANSPORTATION]='STM(F.1)->STM(F.2) (IP02)' THEN 'IP-02'
WHEN b.[TRANSPORTATION]='STM(F.1)->STM(F.2) (IP03)' THEN 'IP-03'
WHEN b.[TRANSPORTATION]='STM(F.1)->STM(F.2) (IP04)' THEN 'IP-04'
WHEN b.[TRANSPORTATION]='STM(F.1)->STM(F.2) (IP05)' THEN 'IP-05'
WHEN b.[TRANSPORTATION]='STM(F.1)->STM(F.2) (IP06)' THEN 'IP-06' ELSE '' END AS 'TRANSPORTATION',b.[TRANSPORTATION] AS 'TRANSPORTATION2' FROM [dbo].[LOGBILLINGINVOICE] a
INNER JOIN [dbo].[LOGINVOICE] b ON a.INVOICECODE = b.INVOICECODE
WHERE a.ACTIVESTATUS = '1' AND a.BILLINGCODE = '" . $_GET['billingcode'] . "'";
$params_seBillinginvoice1_1 = array();
$query_seBillinginvoice1_1 = sqlsrv_query($conn, $sql_seBillinginvoice1_1, $params_seBillinginvoice1_1);
while ($result_seBillinginvoice1_1 = sqlsrv_fetch_array($query_seBillinginvoice1_1, SQLSRV_FETCH_ASSOC)) {
    $sql_sePriceholip01 = "SELECT TOP 1 PRICE FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE [VEHICLETYPE]='10W' AND [FROM]='" . $result_seBillinginvoice1_1['TRANSPORTATION2'] . "' ORDER BY [CREATEDATE] DESC";
    $params_sePriceholip01 = array();
    $query_sePriceholip01 = sqlsrv_query($conn, $sql_sePriceholip01, $params_sePriceholip01);
    $result_sePriceholip01 = sqlsrv_fetch_array($query_sePriceholip01, SQLSRV_FETCH_ASSOC);



    $sql_seBiv01 = "SELECT TOP 1 INVOICECODE FROM [dbo].[LOGBILLINGINVOICE] WHERE [BILLINGCODE] = '" . $_GET['billingcode'] . "' ";
    $query_seBiv01 = sqlsrv_query($conn, $sql_seBiv01, $params_seBiv01);
    $result_seBiv01 = sqlsrv_fetch_array($query_seBiv01, SQLSRV_FETCH_ASSOC);

    $sql_seIv01 = "SELECT VLINDATE FROM [dbo].[LOGINVOICE] WHERE [INVOICECODE] = '" . $result_seBiv01['INVOICECODE'] . "' AND [TRANSPORTATION] = '" . $result_seBillinginvoice1_1['TRANSPORTATION2'] . "'";
    $query_seIv01 = sqlsrv_query($conn, $sql_seIv01, $params_seIv01);
    $result_seIv01 = sqlsrv_fetch_array($query_seIv01, SQLSRV_FETCH_ASSOC);

    $sql_seTripamountip01 = "SELECT SUM(CAST(LEFT(b.ROUNDAMOUNT,PATINDEX('%[^0-9]%',b.ROUNDAMOUNT)-1) AS int)) AS 'SUMTRIPSTM'
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
            WHERE 1 = 1
            AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seIv01['VLINDATE'] . "',111) AND CONVERT(DATE,'" . $result_seIv01['VLINDATE'] . "',111)
            AND b.COMPANYCODE = 'RKS' AND b.CUSTOMERCODE = 'STM'
            AND a.DOCUMENTCODE != ''
            AND (SUBSTRING(ROUNDAMOUNT, 3, 3) = 'D' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'D'
            OR SUBSTRING(ROUNDAMOUNT, 3, 3) = 'N' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'N' )  ";
    $query_seTripamountip01 = sqlsrv_query($conn, $sql_seTripamountip01, $params_seTripamountip01);
    $result_seTripamountip01 = sqlsrv_fetch_array($query_seTripamountip01, SQLSRV_FETCH_ASSOC);
    
    
    $tbody1 .= number_format($result_sePriceholip01['PRICE']*$result_seTripamountip01['SUMTRIPSTM'],2);
    $tbody1 .= '<br>';
    $rsprice=$rsprice+($result_sePriceholip01['PRICE']*$result_seTripamountip01['SUMTRIPSTM']);
    
}
$tbody1 .= '</td>
      </tr>
';





$tfoot1 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center">รวมเงิน</td>
            <td style="border-right:1px solid #000;padding:4px;">' . convert($rsprice) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($rsprice, 2) . '</td>
      </tr>

    </tfoot>';

$table_end1 = '</table>';

$table_footer1 = '
<table width="100%" style="border-collapse: collapse;margin-top:8px;font-size:20px">
<tbody>
<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:30%">ได้รับบริการตามรายการเรียบร้อยแล้ว<br><br><br><br><br><br><br>ผู้รับบริการ..........................................<br>ลงวันที่................/................/.............</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:35%">การชำระเงิน<input type="checkbox" size="5" /> เงินสด&nbsp;<input type="checkbox" size="5" checked="checked"/> โอนเงิน<br><input type="checkbox"  size="5"/> เช็คธนาคาร.............................................<br>เลขที่....................วันที่........../........../..........<br>จำนวนเงิน...................................................<br><br><br><br>ผู้รับเงิน.................................................<br>ลงวันที่................/................./.................</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:35%">ในนาม บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด<br><br><br><br><br><br>.....................................................................<br>ลงวันที่............./............/.............<br>ผู้มีอำนาจลงนาม / Authorized Signature</td>
    </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>';
$table_remark1 = '<br /><table width="100%" style="font-size:18px" >
<tbody>
    <tr>
      <td style="width:10%"><b><u>หมายเหตุ</u> :</b></td>
        <td style="width:90%">1.ค่าขนส่งภาษีหัก ณ ที่จ่าย 1 %</td>
   </tr>
   <tr>
      <td style="width:10%"></td>
        <td style="width:90%">2.ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์ เมื่อมีลายเซ็นผู้รับเงิน และได้รับเงินตามเช็ค หรือ เงินโอนเข้าบัญชีเรียบร้อยแล้ว</td>
   </tr>
   <tr>
      <td style="width:10%"></td>
        <td style="width:90%">3.ผู้รับบริการชำระเกินกำหนดที่ระบุไว้ในใบแจ้งหนี้ ผู้รับบริการยินยอมชำระค่าปรับร้อยละ 15 ต่อปี ของจำนวนเงินที่ค้างชำระ</td>
   </tr><br><br>
   <tr>
        <td colspan="2">FM-ADM-10/01 แก้ไขครั้งที่ : 01 มีผลบังคับใช้ : 01-09-60</td>
   </tr>
</tbody>
</table>';



$table_header21 = '<br>';
$table_header2 = '<table width="100%" >
    <tbody>
        <tr>
        	<td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
            <td colspan="7" style="font-size:24px"><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO.,LTD)<b></td>
       </tr>
       <tr>
        	<td colspan="7" style="font-size:20px">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160</td>
       </tr>
        <tr>
        	<td colspan="7" style="font-size:20px">โทรศัพท์: 038-452824-5 โทรสาร : 038-210396</td>
       </tr>
        <tr>
        	<td colspan="7" style="font-size:20px">เลขประจำตัวผู้เสียภาษี 0105544064899</td>
       </tr>
       <tr>
        	<td colspan="8" style="text-align:center;font-size:24px"><b>ใบวางบิล</b></td>
       </tr>
    </tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;font-size:22px">
    <tbody>
        <tr style="border:1px solid #000;font-size:22px">
       	  <td style="border-right:1px solid #000;padding:4px;width:70%">ลูกค้า : รหัส ต-002
								<br>บริษัท สยามโตโยต้าอุตสาหกรรม จำกัด
								<br>สำนักงานใหญ่ 700/109,111,113 ม.1 นิคมอุตสาหกรรมอมตะนคร
								<br>ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160
                <br>โทร. 038-469000

		  <br>เลขประจำตัวผู้เสียภาษี 0105530032434</td>
            <td style="border-right:1px solid #000;padding:4px;width:30%">วันที่ : ' . $result_seBillinginvoice['DUEDATE'] . '</td>
       </tr>

    </tbody>
</table>';

$table_begin2 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead2 = '<thead>

        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%;font-size:20px"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%;font-size:20px"><b>เลขที่ใบแจ้งหนี้</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%;font-size:20px"><b>วันที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%;font-size:20px"><b>วันครบกำหนด</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%;font-size:20px"><b>จำนวนเงิน</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:20%;font-size:20px"><b>ยอดชำระแล้ว</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%;font-size:20px"><b>ยอดเงินคงค้าง</b></td>
      </tr>
  </thead><tbody>';
$i1 = 1;
$sql_seBillinginvoice2 = "SELECT DISTINCT a.INVOICECODE,a.BILLINGDATE, a.PAYMENTDATE FROM [dbo].[LOGBILLINGINVOICE] a
INNER JOIN [dbo].[LOGINVOICE] b ON a.INVOICECODE = b.INVOICECODE
WHERE a.ACTIVESTATUS = '1' AND a.BILLINGCODE = '" . $_GET['billingcode'] . "'";
$params_seBillinginvoice2 = array();
$query_seBillinginvoice2 = sqlsrv_query($conn, $sql_seBillinginvoice2, $params_seBillinginvoice2);
while ($result_seBillinginvoice2 = sqlsrv_fetch_array($query_seBillinginvoice2, SQLSRV_FETCH_ASSOC)) {
    
    
    
    
    
    $tbody2 .= '<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px"height="300px" valign="top">' . $i1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px"valign="top">' . $result_seBillinginvoice2['INVOICECODE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px"valign="top">' . $result_seBillinginvoice2['BILLINGDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px"valign="top">' . $result_seBillinginvoice2['PAYMENTDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px"valign="top">' . number_format($rsprice, 2) . '</td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px"valign="top"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px"valign="top">' . number_format($rsprice, 2) . '</td>
      </tr>
';

    $i1++;
    $sumtotal = $sumtotal + $result_Sumprice['SUMPRICESTM'];
}


$tfoot2 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td colspan="5" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px">' . convert(($rsprice)) . '</td>
            <td style="border-right:1px solid #000;padding:4px;font-size:22px">รวมเงินทั้งสิ้น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px">' . number_format(($rsprice), 2) . '</td>
      </tr>

       <tr style="">
        <td colspan="5" rowspan="2" style="border-right:1px solid #000;padding:4px;font-size:22px"></td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px">ภาษีหัก ณ ที่จ่าย 1 %</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px">' . number_format((($rsprice) * 1) / 100, 2) . '</td>

      </tr>
       <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;font-size:22px">ยอดต้องชำระ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px">' . number_format(($rsprice) - ((($rsprice) * 1) / 100), 2) . '</td>
      </tr>
    </tfoot>';

$table_end2 = '</table>';

$table_footer2 = '<br />
<br />
<br />
<table width="100%" style="border-collapse: collapse;margin-top:8px;font-size:22px">
<tfoot>
<tbody>
<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:3px;text-align:center;width:35%"><br /><br /><br />วันนัดชำระเงิน / Payment Date<br />____/____/____</td>
        <td style="border-right:1px solid #000;padding:3px;text-align:center;width:30%"><br /><br />...................................................<br />ผู้รับวางบิล / Received By<br />____/____/____</td>
        <td style="border-right:1px solid #000;padding:3px;text-align:center;width:35%"><br /><br />...................................................<br />ผู้วางบิล / Delivery By<br />____/____/____</td>
    </tr>
    </tbody>

    </tfoot>
</table>';

$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_header21);
$mpdf->WriteHTML($table_header2);
$mpdf->WriteHTML($table_begin2);
$mpdf->WriteHTML($thead2);
$mpdf->WriteHTML($tbody2);
$mpdf->WriteHTML($tfoot2);
$mpdf->WriteHTML($table_end2);
$mpdf->WriteHTML($table_footer2);
$mpdf->AddPage();
$mpdf->WriteHTML($table_header11);
$mpdf->WriteHTML($table_header1);
$mpdf->WriteHTML($table_begin1);
$mpdf->WriteHTML($thead1);
$mpdf->WriteHTML($tbody1);
$mpdf->WriteHTML($tfoot1);
$mpdf->WriteHTML($table_end1);
$mpdf->WriteHTML($table_footer1);
$mpdf->WriteHTML($table_remark1);



$mpdf->Output();



sqlsrv_close($conn);
?>
