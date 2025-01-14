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

$condBillinginvoice1 = " AND a.BILLINGCODE = '" . $_GET['billingcode'] . "'";
$condBillinginvoice2 = "";
$sql_seBillinginvoice = "{call megLogbillinginvoice_v2(?,?,?)}";
$params_seBillinginvoice = array(
    array('select_logbillinginvoice', SQLSRV_PARAM_IN),
    array($condBillinginvoice1, SQLSRV_PARAM_IN),
    array($condBillinginvoice2, SQLSRV_PARAM_IN)
);
$query_seBillinginvoice = sqlsrv_query($conn, $sql_seBillinginvoice, $params_seBillinginvoice);
$result_seBillinginvoice = sqlsrv_fetch_array($query_seBillinginvoice, SQLSRV_FETCH_ASSOC);

$condInvoice1 = " AND INVOICECODE = '" . $result_seBillinginvoice['INVOICECODE'] . "'";
$condInvoice2 = "";
$sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
$params_seInvoice = array(
    array('select_loginvoice', SQLSRV_PARAM_IN),
    array($condInvoice1, SQLSRV_PARAM_IN),
    array($condInvoice2, SQLSRV_PARAM_IN)
);
$query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
$result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC);

$sql_seInvoicecode = "SELECT DISTINCT DOCUMENTCODE,CONVERT(VARCHAR(10), VLINDATE, 103) AS 'DATEVLIN_103',BILLINGDATE,PAYMENTDATE,INVOICECODE,INVOICEADTH,INVOICEBPK1,INVOICEBPK2,INVOICEASTH,INVOICEDSTH
FROM [dbo].[LOGINVOICE] WHERE 1 = 1
AND  INVOICECODE = '".$result_seInvoice['INVOICECODE']."'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);

//////////////////////////PRICE ADTH////////////////////////////////////////////////////
$sql_sePriceADTH = "SELECT SUM(CAST(BILLINGDENSO1 AS DECIMAL(18,2)))  AS 'PRICEADTH',COUNT (b.VEHICLETRANSPORTPLANID) AS 'COUNT'
FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.[VEHICLETRANSPORTPRICEID] = b.[VEHICLETRANSPORTPRICEID]
WHERE 1 = 1
AND c.COMPANYCODE ='RKS' AND c.CUSTOMERCODE='DENSO-THAI' AND a.DOCUMENTCODE ='".$result_seInvoicecode['DOCUMENTCODE']."'
AND c.BILLINGDENSO1 !='' AND c.BILLINGDENSO1 != '0' AND c.BILLINGDENSO1 != '-' AND c.BILLINGDENSO1 IS NOT NULL
AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103)";
$params_sePriceADTH = array();
$query_sePriceADTH = sqlsrv_query($conn, $sql_sePriceADTH, $params_sePriceADTH);
$result_sePriceADTH = sqlsrv_fetch_array($query_sePriceADTH, SQLSRV_FETCH_ASSOC);

//////////////////////////PRICE BPK1////////////////////////////////////////////////////
$sql_sePriceBPK1 = "SELECT SUM(CAST(BILLINGDENSO2 AS DECIMAL(18,2)))  AS 'PRICEBPK1',COUNT (b.VEHICLETRANSPORTPLANID) AS 'COUNT'
FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.[VEHICLETRANSPORTPRICEID] = b.[VEHICLETRANSPORTPRICEID]
WHERE 1 = 1
AND c.COMPANYCODE ='RKS' AND c.CUSTOMERCODE='DENSO-THAI' AND a.DOCUMENTCODE ='".$result_seInvoicecode['DOCUMENTCODE']."'
AND c.BILLINGDENSO2 !='' AND c.BILLINGDENSO2 != '0' AND c.BILLINGDENSO2 != '-' AND c.BILLINGDENSO2 IS NOT NULL
AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103)";
$params_sePriceBPK1 = array();
$query_sePriceBPK1 = sqlsrv_query($conn, $sql_sePriceBPK1, $params_sePriceBPK1);
$result_sePriceBPK1 = sqlsrv_fetch_array($query_sePriceBPK1, SQLSRV_FETCH_ASSOC);

//////////////////////////PRICE BPK2////////////////////////////////////////////////////
$sql_sePriceBPK2 = "SELECT SUM(CAST(BILLINGDENSO3 AS DECIMAL(18,2)))  AS 'PRICEBPK2',COUNT (b.VEHICLETRANSPORTPLANID) AS 'COUNT'
FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.[VEHICLETRANSPORTPRICEID] = b.[VEHICLETRANSPORTPRICEID]
WHERE 1 = 1
AND c.COMPANYCODE ='RKS' AND c.CUSTOMERCODE='DENSO-THAI' AND a.DOCUMENTCODE ='".$result_seInvoicecode['DOCUMENTCODE']."'
AND c.BILLINGDENSO1 !='' AND c.BILLINGDENSO3 != '0' AND c.BILLINGDENSO3 != '-' AND c.BILLINGDENSO3 IS NOT NULL
AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103)";
$params_sePriceBPK2 = array();
$query_sePriceBPK2 = sqlsrv_query($conn, $sql_sePriceBPK2, $params_sePriceBPK2);
$result_sePriceBPK2 = sqlsrv_fetch_array($query_sePriceBPK2, SQLSRV_FETCH_ASSOC);

//////////////////////////PRICE ASTH////////////////////////////////////////////////////
$sql_sePriceASTH = "SELECT SUM(CAST(BILLINGDENSO4 AS DECIMAL(18,2)))  AS 'PRICEASTH',COUNT (b.VEHICLETRANSPORTPLANID) AS 'COUNT'
FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.[VEHICLETRANSPORTPRICEID] = b.[VEHICLETRANSPORTPRICEID]
WHERE 1 = 1
AND c.COMPANYCODE ='RKS' AND c.CUSTOMERCODE='DENSO-THAI' AND a.DOCUMENTCODE ='".$result_seInvoicecode['DOCUMENTCODE']."'
AND c.BILLINGDENSO1 !='' AND c.BILLINGDENSO4 != '0' AND c.BILLINGDENSO4 != '-' AND c.BILLINGDENSO4 IS NOT NULL
AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103)";
$params_sePriceASTH = array();
$query_sePriceASTH = sqlsrv_query($conn, $sql_sePriceASTH, $params_sePriceASTH);
$result_sePriceASTH = sqlsrv_fetch_array($query_sePriceASTH, SQLSRV_FETCH_ASSOC);

//////////////////////////PRICE DSTH////////////////////////////////////////////////////
$sql_sePriceDSTH = "SELECT SUM(CAST(BILLINGDENSO5 AS DECIMAL(18,2)))  AS 'PRICEDSTH',COUNT (b.VEHICLETRANSPORTPLANID) AS 'COUNT'
FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.[VEHICLETRANSPORTPRICEID] = b.[VEHICLETRANSPORTPRICEID]
WHERE 1 = 1
AND c.COMPANYCODE ='RKS' AND c.CUSTOMERCODE='DENSO-THAI' AND a.DOCUMENTCODE ='".$result_seInvoicecode['DOCUMENTCODE']."'
AND c.BILLINGDENSO1 !='' AND c.BILLINGDENSO5 != '0' AND c.BILLINGDENSO5 != '-' AND c.BILLINGDENSO5 IS NOT NULL
AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103)";
$params_sePriceDSTH = array();
$query_sePriceDSTH = sqlsrv_query($conn, $sql_sePriceDSTH, $params_sePriceDSTH);
$result_sePriceDSTH = sqlsrv_fetch_array($query_sePriceDSTH, SQLSRV_FETCH_ASSOC);




$mpdf = new mPDF('th', 'A4', '0', '');
$style = '
<style>
	body{
		font-family: "Garuda";font-size:12px//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';

////////////////////////////////////////////////////บริษัท อันเด็น ประเทศไทย///////////////////////
$table_headerADTH = '<table width="100%" >
<tbody>
    <tr>
      <td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
        <td colspan="7" style="font-size:15px"><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO.,LTD.)<b></td>
   </tr>
   <tr>
      <td colspan="7">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160</td>
   </tr>
    <tr>
      <td colspan="7">โทรศัพท์: 038-452824-5 โทรสาร : 038-210396</td>
   </tr>
    <tr>
      <td colspan="7">เลขประจำตัวผู้เสียภาษี 0105544064899</td>
   </tr>
   <tr>
      <td colspan="8" style="text-align:center;">&nbsp;</td>
   </tr>
   <tr>
      <td colspan="8" style="text-align:center;font-size:16px"><b>ใบแจ้งหนี้/ใบเสร็จรับเงิน</b></td>
   </tr>
   <tr>
      <td colspan="8" style="text-align:center;">&nbsp;</td>
   </tr>
</tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;">
    <tbody>

       <tr style="border:1px solid #000;">
       <td style="border-right:1px solid #000;padding:4px;width:70%"> รหัสลูกค้า อ-002
             <br><br>บริษัท อันเด็น  (ประเทศไทย) จำกัด
             <br><br>700/87 หมู่ 1 ถ.บางนา-ตราด กม.57 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160
             <br><br>โทร. 038-21 4649, 038-21 4651-4
             <br><br>เลขประจำตัวผู้เสียภาษี 0205545008860
        </td>

      <td style="border-right:1px solid #000;padding:4px;width:30%"><br>
      เลขที : '.$result_seInvoicecode['INVOICEADTH'].'<br><br>
      วันที่  : ' . $result_getDate['SYSDATE'] . '<br><br>
      วันที่ครบกำหนด : ' . $result_seBillinginvoice['PAYMENTDATE'] . '
      </td>
       </tr>


    </tbody>
</table>';

$table_beginADTH = '<table width="100%" style="border-collapse: collapse;margin-top:8px;">';
$theadADTH = '<thead>

        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:60%"><b>รายการ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:30%"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
  </thead><tbody>';

$tbodyADTH .= '<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" height="250px" valign="top">1</td>
    <td style="border-right:1px solid #000;padding:4px;" valign="top">ค่าขนส่งสินค้าตามเอกสารแนบ</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:right;" valign="top">' . number_format($result_sePriceADTH['PRICEADTH'], 2) . '</td>
  </tr>
';

$tfootADTH = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center">รวมเงิน</td>
            <td style="border-right:1px solid #000;padding:4px;">' . convert($result_sePriceADTH['PRICEADTH']) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($result_sePriceADTH['PRICEADTH'], 2) . '</td>
      </tr>

    </tfoot>';

$table_endADTH = '</table>';

$table_footerADTH = '<br /><br />
<table width="100%" style="border-collapse: collapse;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:30%">ได้รับบริการตามรายการเรียบร้อยแล้ว<br><br><br><br><br><br><br><br><br><br><br><br>ผู้รับบริการ..........................................<br><br>ลงวันที่................/................/.............</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:35%">การชำระเงิน<br><br><input type="checkbox" size="5" /> เงินสด&emsp;<input type="checkbox" size="5" /> โอนเงิน<br><br><input type="checkbox"  size="5" /> เช็คธนาคาร.............................................<br><br>เลขที่....................วันที่........../........../..........<br><br>จำนวนเงิน...................................................<br><br><br><br>ผู้รับเงิน.................................................<br><br>ลงวันที่................/................./.................</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:35%">ในนาม บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด<br><br><br><br><br><br><br><br><br><br>.....................................................................<br><br>ลงวันที่............./............/.............<br><br>ผู้มีอำนาจลงนาม / Authorized Signature</td>
    </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>';
$table_remarkADTH = '<br /><table width="100%" >
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
</table>
';
////////////////////////////////////////////////////////////////////////////////////

// /////////////////////////////////////เด็นโซ่ โรงงานบางประกง  (K.จำนงค์)////////////////////////////////
$table_headerBPK1 = '<table width="100%" >
<tbody>
    <tr>
      <td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
        <td colspan="7" style="font-size:15px"><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO.,LTD.)<b></td>
   </tr>
   <tr>
      <td colspan="7">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160</td>
   </tr>
    <tr>
      <td colspan="7">โทรศัพท์: 038-452824-5 โทรสาร : 038-210396</td>
   </tr>
    <tr>
      <td colspan="7">เลขประจำตัวผู้เสียภาษี 0105544064899</td>
   </tr>
   <tr>
      <td colspan="8" style="text-align:center;">&nbsp;</td>
   </tr>
   <tr>
      <td colspan="8" style="text-align:center;font-size:16px"><b>ใบแจ้งหนี้/ใบเสร็จรับเงิน</b></td>
   </tr>
   <tr>
      <td colspan="8" style="text-align:center;">&nbsp;</td>
   </tr>
</tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;">
    <tbody>

       <tr style="border:1px solid #000;">
       <td style="border-right:1px solid #000;padding:4px;width:70%">รหัสลูกค้า ด-002
             <br><br>บริษัท เด็นโซ่  (ประเทศไทย) จำกัด (โรงงานบางประกง)
             <br><br>700/87 หมู่ 1 ถ.บางนา-ตราด กม.57 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160
             <br><br>เลขประจำตัวผู้เสียภาษี 0115541001250
        </td>

      <td style="border-right:1px solid #000;padding:4px;width:30%"><br>
      เลขที : '.$result_seInvoicecode['INVOICEBPK1'].'<br><br>
      วันที่  : ' . $result_getDate['SYSDATE'] . '<br><br>
      วันที่ครบกำหนด : ' . $result_seBillinginvoice['PAYMENTDATE'] . '
      </td>
       </tr>


    </tbody>
</table>';

$table_beginBPK1 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;">';
$theadBPK1 = '<thead>

        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:60%"><b>รายการ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:30%"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
  </thead><tbody>';

$tbodyBPK1 .= '<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" height="250px" valign="top">1</td>
    <td style="border-right:1px solid #000;padding:4px;" valign="top">ค่าขนส่งสินค้าตามเอกสารแนบ</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:right;" valign="top">' . number_format($result_sePriceBPK1['PRICEBPK1'], 2) . '</td>
  </tr>
';
$tfootBPK1 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center">รวมเงิน</td>
            <td style="border-right:1px solid #000;padding:4px;">' . convert($result_sePriceBPK1['PRICEBPK1']) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($result_sePriceBPK1['PRICEBPK1'], 2) . '</td>
      </tr>

    </tfoot>';

$table_endBPK1 = '</table>';

$table_footerBPK1 = '<br /><br />
<table width="100%" style="border-collapse: collapse;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:30%">ได้รับบริการตามรายการเรียบร้อยแล้ว<br><br><br><br><br><br><br><br><br><br><br><br>ผู้รับบริการ..........................................<br><br>ลงวันที่................/................/.............</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:35%">การชำระเงิน<br><br><input type="checkbox" size="5" /> เงินสด&emsp;<input type="checkbox" size="5" /> โอนเงิน<br><br><input type="checkbox"  size="5" /> เช็คธนาคาร.............................................<br><br>เลขที่....................วันที่........../........../..........<br><br>จำนวนเงิน...................................................<br><br><br><br>ผู้รับเงิน.................................................<br><br>ลงวันที่................/................./.................</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:35%">ในนาม บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด<br><br><br><br><br><br><br><br><br><br>.....................................................................<br><br>ลงวันที่............./............/.............<br><br>ผู้มีอำนาจลงนาม / Authorized Signature</td>
    </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>';
$table_remarkBPK1 = '<br /><table width="100%" >
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
</table>
';
// /////////////////////////////////////เด็นโซ่ โรงงานบางประกง  (K.อรจิตรา)////////////////////////////////
$table_headerBPK2 = '<table width="100%" >
<tbody>
    <tr>
      <td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
        <td colspan="7" style="font-size:15px"><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO.,LTD.)<b></td>
   </tr>
   <tr>
      <td colspan="7">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160</td>
   </tr>
    <tr>
      <td colspan="7">โทรศัพท์: 038-452824-5 โทรสาร : 038-210396</td>
   </tr>
    <tr>
      <td colspan="7">เลขประจำตัวผู้เสียภาษี 0105544064899</td>
   </tr>
   <tr>
      <td colspan="8" style="text-align:center;">&nbsp;</td>
   </tr>
   <tr>
      <td colspan="8" style="text-align:center;font-size:16px"><b>ใบแจ้งหนี้/ใบเสร็จรับเงิน</b></td>
   </tr>
   <tr>
      <td colspan="8" style="text-align:center;">&nbsp;</td>
   </tr>
</tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;">
    <tbody>

       <tr style="border:1px solid #000;">
       <td style="border-right:1px solid #000;padding:4px;width:70%">รหัสลูกค้า ด-002
             <br><br>บริษัท เด็นโซ่  (ประเทศไทย) จำกัด (โรงงานบางประกง)
             <br><br>700/87 หมู่ 1 ถ.บางนา-ตราด กม.57 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160
             <br><br>เลขประจำตัวผู้เสียภาษี 0115541001250
        </td>

      <td style="border-right:1px solid #000;padding:4px;width:30%"><br>
      เลขที : '.$result_seInvoicecode['INVOICEBPK2'].'<br><br>
      วันที่  : ' . $result_getDate['SYSDATE'] . '<br><br>
      วันที่ครบกำหนด : ' . $result_seBillinginvoice['PAYMENTDATE'] . '
      </td>
       </tr>


    </tbody>
</table>';

$table_beginBPK2 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;">';
$theadBPK2 = '<thead>

        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:60%"><b>รายการ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:30%"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
  </thead><tbody>';

$tbodyBPK2 .= '<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" height="250px" valign="top">3</td>
    <td style="border-right:1px solid #000;padding:4px;" valign="top">ค่าขนส่งสินค้าตามเอกสารแนบ</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:right;" valign="top">' . number_format($result_sePriceBPK2['PRICEBPK2'], 2) . '</td>
  </tr>
';

$tfootBPK2 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center">รวมเงิน</td>
            <td style="border-right:1px solid #000;padding:4px;">' . convert($result_sePriceBPK2['PRICEBPK2']) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($result_sePriceBPK2['PRICEBPK2'], 2) . '</td>
      </tr>

    </tfoot>';

$table_endBPK2 = '</table>';

$table_footerBPK2 = '<br /><br />
<table width="100%" style="border-collapse: collapse;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:30%">ได้รับบริการตามรายการเรียบร้อยแล้ว<br><br><br><br><br><br><br><br><br><br><br><br>ผู้รับบริการ..........................................<br><br>ลงวันที่................/................/.............</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:35%">การชำระเงิน<br><br><input type="checkbox" size="5" /> เงินสด&emsp;<input type="checkbox" size="5" /> โอนเงิน<br><br><input type="checkbox"  size="5" /> เช็คธนาคาร.............................................<br><br>เลขที่....................วันที่........../........../..........<br><br>จำนวนเงิน...................................................<br><br><br><br>ผู้รับเงิน.................................................<br><br>ลงวันที่................/................./.................</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:35%">ในนาม บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด<br><br><br><br><br><br><br><br><br><br>.....................................................................<br><br>ลงวันที่............./............/.............<br><br>ผู้มีอำนาจลงนาม / Authorized Signature</td>
    </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>';
$table_remarkBPK2 = '<br /><table width="100%" >
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
</table>
';

///////////////////////////////////////บริษัท แอร์ ซิสเต็มส์ ประเทศไทย///////////////////////////////////////////////////////////

$table_headerASTH = '<table width="100%" >
<tbody>
    <tr>
      <td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
        <td colspan="7" style="font-size:15px"><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO.,LTD.)<b></td>
   </tr>
   <tr>
      <td colspan="7">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160</td>
   </tr>
    <tr>
      <td colspan="7">โทรศัพท์: 038-452824-5 โทรสาร : 038-210396</td>
   </tr>
    <tr>
      <td colspan="7">เลขประจำตัวผู้เสียภาษี 0105544064899</td>
   </tr>
   <tr>
      <td colspan="8" style="text-align:center;">&nbsp;</td>
   </tr>
   <tr>
      <td colspan="8" style="text-align:center;font-size:16px"><b>ใบแจ้งหนี้/ใบเสร็จรับเงิน</b></td>
   </tr>
   <tr>
      <td colspan="8" style="text-align:center;">&nbsp;</td>
   </tr>
</tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;">
    <tbody>

       <tr style="border:1px solid #000;">
       <td style="border-right:1px solid #000;padding:4px;width:70%"> รหัสลูกค้า อ-025
             <br><br>บริษัท แอร์ ซิสเต็มส์์  (ประเทศไทย) จำกัด
             <br><br>219/5-6 หมู่ 6 ต.บ่อวิน อ.ศรีราชา จ.ชลบุรี 20230
             <br><br>โทร. 038-317050-1
             <br><br>เลขประจำตัวผู้เสียภาษี 0245555000837
        </td>

      <td style="border-right:1px solid #000;padding:4px;width:30%"><br>
      เลขที : '.$result_seInvoicecode['INVOICEASTH'].'<br><br>
      วันที่  : ' . $result_getDate['SYSDATE'] . '<br><br>
      วันที่ครบกำหนด : ' . $result_seBillinginvoice['PAYMENTDATE'] . '
      </td>
       </tr>


    </tbody>
</table>';

$table_beginASTH = '<table width="100%" style="border-collapse: collapse;margin-top:8px;">';
$theadASTH = '<thead>

        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:60%"><b>รายการ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:30%"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
  </thead><tbody>';

$tbodyASTH .= '<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" height="250px" valign="top">1</td>
    <td style="border-right:1px solid #000;padding:4px;" valign="top">ค่าขนส่งสินค้าตามเอกสารแนบ</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:right;" valign="top">' . number_format($result_sePriceASTH['PRICEASTH'], 2) . '</td>
  </tr>
';

$tfootASTH = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center">รวมเงิน</td>
            <td style="border-right:1px solid #000;padding:4px;">' . convert($result_sePriceASTH['PRICEASTH']) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($result_sePriceASTH['PRICEASTH'], 2) . '</td>
      </tr>

    </tfoot>';

$table_endASTH = '</table>';

$table_footerASTH = '<br /><br />
<table width="100%" style="border-collapse: collapse;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:30%">ได้รับบริการตามรายการเรียบร้อยแล้ว<br><br><br><br><br><br><br><br><br><br><br><br>ผู้รับบริการ..........................................<br><br>ลงวันที่................/................/.............</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:35%">การชำระเงิน<br><br><input type="checkbox" size="5" /> เงินสด&emsp;<input type="checkbox" size="5" /> โอนเงิน<br><br><input type="checkbox"  size="5" /> เช็คธนาคาร.............................................<br><br>เลขที่....................วันที่........../........../..........<br><br>จำนวนเงิน...................................................<br><br><br><br>ผู้รับเงิน.................................................<br><br>ลงวันที่................/................./.................</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:35%">ในนาม บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด<br><br><br><br><br><br><br><br><br><br>.....................................................................<br><br>ลงวันที่............./............/.............<br><br>ผู้มีอำนาจลงนาม / Authorized Signature</td>
    </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>';
$table_remarkASTH = '<br /><table width="100%" >
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
</table>
';

// ////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////บริษัท เด็นโซ่บางบ่อ ประเทศไทย///////////////////////////////////////////////

$table_headerDSTH = '<table width="100%" >
<tbody>
    <tr>
      <td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
        <td colspan="7" style="font-size:15px"><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO.,LTD.)<b></td>
   </tr>
   <tr>
      <td colspan="7">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160</td>
   </tr>
    <tr>
      <td colspan="7">โทรศัพท์: 038-452824-5 โทรสาร : 038-210396</td>
   </tr>
    <tr>
      <td colspan="7">เลขประจำตัวผู้เสียภาษี 0105544064899</td>
   </tr>
   <tr>
      <td colspan="8" style="text-align:center;">&nbsp;</td>
   </tr>
   <tr>
      <td colspan="8" style="text-align:center;font-size:16px"><b>ใบแจ้งหนี้/ใบเสร็จรับเงิน</b></td>
   </tr>
   <tr>
      <td colspan="8" style="text-align:center;">&nbsp;</td>
   </tr>
</tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;">
    <tbody>

       <tr style="border:1px solid #000;">
       <td style="border-right:1px solid #000;padding:4px;width:70%"> รหัสลูกค้า อ-025
             <br><br>บริษัท แอร์ ซิสเต็มส์์  (ประเทศไทย) จำกัด
             <br><br>219/5-6 หมู่ 6 ต.บ่อวิน อ.ศรีราชา จ.ชลบุรี 20230
             <br><br>โทร. 038-317050-1
             <br><br>เลขประจำตัวผู้เสียภาษี 0245555000837
        </td>

      <td style="border-right:1px solid #000;padding:4px;width:30%"><br>
      เลขที : '.$result_seInvoicecode['INVOICEDSTH'].'<br><br>
      วันที่  : ' . $result_getDate['SYSDATE'] . '<br><br>
      วันที่ครบกำหนด : ' . $result_seBillinginvoice['PAYMENTDATE'] . '
      </td>
       </tr>


    </tbody>
</table>';

$table_beginDSTH = '<table width="100%" style="border-collapse: collapse;margin-top:8px;">';
$theadDSTH = '<thead>

        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:60%"><b>รายการ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:30%"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
  </thead><tbody>';

$tbodyDSTH .= '<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:center;" height="250px" valign="top">1</td>
    <td style="border-right:1px solid #000;padding:4px;" valign="top">ค่าขนส่งสินค้าตามเอกสารแนบ</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:right;" valign="top">' . number_format($result_sePriceDSTH['PRICEDSTH'], 2) . '</td>
  </tr>
';
$tfootDSTH = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center">รวมเงิน</td>
            <td style="border-right:1px solid #000;padding:4px;">' . convert($result_sePriceDSTH['PRICEDSTH']) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($result_sePriceDSTH['PRICEDSTH'], 2) . '</td>
      </tr>

    </tfoot>';

$table_endDSTH = '</table>';

$table_footerDSTH = '<br /><br />
<table width="100%" style="border-collapse: collapse;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:30%">ได้รับบริการตามรายการเรียบร้อยแล้ว<br><br><br><br><br><br><br><br><br><br><br><br>ผู้รับบริการ..........................................<br><br>ลงวันที่................/................/.............</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:35%">การชำระเงิน<br><br><input type="checkbox" size="5" /> เงินสด&emsp;<input type="checkbox" size="5" /> โอนเงิน<br><br><input type="checkbox"  size="5" /> เช็คธนาคาร.............................................<br><br>เลขที่....................วันที่........../........../..........<br><br>จำนวนเงิน...................................................<br><br><br><br>ผู้รับเงิน.................................................<br><br>ลงวันที่................/................./.................</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:35%">ในนาม บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด<br><br><br><br><br><br><br><br><br><br>.....................................................................<br><br>ลงวันที่............./............/.............<br><br>ผู้มีอำนาจลงนาม / Authorized Signature</td>
    </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>';
$table_remarkDSTH= '<br /><table width="100%" >
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
</table>
';



$mpdf->WriteHTML($style);
if ($result_sePriceADTH['COUNT'] > 0 ) {
  $mpdf->WriteHTML($table_headerADTH);
  $mpdf->WriteHTML($table_beginADTH);
  $mpdf->WriteHTML($theadADTH);
  $mpdf->WriteHTML($tbodyADTH);
  $mpdf->WriteHTML($tfootADTH);
  $mpdf->WriteHTML($table_endADTH);
  $mpdf->WriteHTML($table_footerADTH);
  $mpdf->WriteHTML($table_remarkADTH);
}else {
  // code...
}
//////////////////////////////////////////
if ($result_sePriceBPK1['COUNT'] > 0 ) {
  $mpdf->AddPage();
  $mpdf->WriteHTML($table_headerBPK1);
  $mpdf->WriteHTML($table_beginBPK1);
  $mpdf->WriteHTML($theadBPK1);
  $mpdf->WriteHTML($tbodyBPK1);
  $mpdf->WriteHTML($tfootBPK1);
  $mpdf->WriteHTML($table_endBPK1);
  $mpdf->WriteHTML($table_footerBPK1);
  $mpdf->WriteHTML($table_remarkBPK1);
}else {
  // code...
}
//////////////////////////////////////////
if ($result_sePriceBPK2['COUMT'] > 0 ) {
  $mpdf->AddPage();
  $mpdf->WriteHTML($table_headerBPK2);
  $mpdf->WriteHTML($table_beginBPK2);
  $mpdf->WriteHTML($theadBPK2);
  $mpdf->WriteHTML($tbodyBPK2);
  $mpdf->WriteHTML($tfootBPK2);
  $mpdf->WriteHTML($table_endBPK2);
  $mpdf->WriteHTML($table_footerBPK2);
  $mpdf->WriteHTML($table_remarkBPK2);
}else {
  // code...
}

//////////////////////////////////////
if ($result_sePriceASTH['COUNT'] > 0 ) {
  $mpdf->AddPage();
  $mpdf->WriteHTML($table_headerASTH);
  $mpdf->WriteHTML($table_beginASTH);
  $mpdf->WriteHTML($theadASTH);
  $mpdf->WriteHTML($tbodyASTH);
  $mpdf->WriteHTML($tfootASTH);
  $mpdf->WriteHTML($table_endASTH);
  $mpdf->WriteHTML($table_footerASTH);
  $mpdf->WriteHTML($table_remarkASTH);
}else {
  // code...
}

//////////////////////////////////////
if ($result_sePriceDSTH['COUNT'] > 0 ) {
  $mpdf->AddPage();
  $mpdf->WriteHTML($table_headerDSTH);
  $mpdf->WriteHTML($table_beginDSTH);
  $mpdf->WriteHTML($theadDSTH);
  $mpdf->WriteHTML($tbodyDSTH);
  $mpdf->WriteHTML($tfootDSTH);
  $mpdf->WriteHTML($table_endDSTH);
  $mpdf->WriteHTML($table_footerDSTH);
  $mpdf->WriteHTML($table_remarkDSTH);
}

$mpdf->Output();



sqlsrv_close($conn);
?>
