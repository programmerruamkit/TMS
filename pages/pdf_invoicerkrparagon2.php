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


$condBillings1 = " AND a.BILLINGCODE = '" . $_GET['billingcode'] . "'";
$condBillings2 = "";
$sql_seBillings = "{call megLogbillinginvoice_v2(?,?,?)}";
$params_seBillings = array(
    array('select_logbillinginvoice', SQLSRV_PARAM_IN),
    array($condBillings1, SQLSRV_PARAM_IN),
    array($condBillings2, SQLSRV_PARAM_IN)
);

$query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
$result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);


//คำนวณเงินรวมของ Charge 10
$sql_sumpriceCharge10 = "SELECT DISTINCT VEHICLETRANSPORTPLANID,PRICEAC FROM (SELECT DISTINCT 
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
AND a.INVOICECODE = '" .$result_seBillinginvoice['INVOICECODE'] . "'
AND b.REMARK = 'Charge 10'
) AS A ORDER BY VEHICLETRANSPORTPLANID ASC ";
$params_sumpriceCharge10 = array();
$query_sumpriceCharge10 = sqlsrv_query($conn, $sql_sumpriceCharge10, $params_sumpriceCharge10);
while($result_sumpriceCharge10 = sqlsrv_fetch_array($query_sumpriceCharge10, SQLSRV_FETCH_ASSOC)){

  $sumpriceCharge10 = $sumpriceCharge10 +$result_sumpriceCharge10['PRICEAC'];
}

//คำนวณเงินรวมของ ไม่คิดขั้นต่ำ
$sql_sumpriceNocharge = "SELECT DISTINCT VEHICLETRANSPORTPLANID,PRICEAC FROM (SELECT DISTINCT 
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
AND a.INVOICECODE = '" .$result_seBillinginvoice['INVOICECODE'] . "'
AND b.REMARK = 'ไม่คิดขั้นต่ำ'
) AS A ORDER BY VEHICLETRANSPORTPLANID ASC ";
$params_sumpriceNocharge = array();
$query_sumpriceNocharge = sqlsrv_query($conn, $sql_sumpriceNocharge, $params_sumpriceNocharge);
while($result_sumpriceNocharge = sqlsrv_fetch_array($query_sumpriceNocharge, SQLSRV_FETCH_ASSOC)){

  $sumpriceNocharge = $sumpriceNocharge +$result_sumpriceNocharge['PRICEAC'];
}

$allprice = $sumpriceCharge10 + $sumpriceNocharge;


$mpdf = new mPDF('', 'Letter', '', '', 6, 18, '', 5, '', 15);
$style = '
<style>
	body{
		font-family: "angsana";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';
$table_header21 = '<br>';
$table_header2 = '<table width="100%" >
<tbody>
    <tr>
      <td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
        <td colspan="7" style="font-size:20px" ><b>บริษัท ร่วมกิจรุ่งเรือง (1993) จำกัด (RUAMKIT RUNGRUENG (1993) CO., LTD.)<b></td>
   </tr>
   <tr>
      <td colspan="7" style="font-size:20px">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง จังหวัดชลบุรี 20160</td>
   </tr>
   
    <tr>
      <td colspan="7" style="font-size:20px">โทรศัพท์ : 038-452824-5 โทรสาร : 038-210396</td>
   </tr>
    <tr>
      <td colspan="7" style="font-size:20px">เลขประจำตัวผู้เสียภาษี 0105536076131</td>
   </tr>
   <tr>
      <td colspan="8" style="text-align:center;font-size:24px"><b>ใบวางบิล</b></td>
   </tr>
</tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;font-size:22px">
<tbody>
    <tr style="border:1px solid #000;font-size:24px">
      <td style="border-right:1px solid #000;padding:4px;width:70%;">บริษัท พารากอน สตีล ซัพพลายส์ จำกัด
                <br>สำนักงานใหญ่ 309 หมู่ที่ 3 ถนนบางโปรง ต.บางโปรง 	 
                <br>อ.เมืองสมุทรปราการ จ.สมุทรปราการ 10270
								<br>โทร.  02-755-5100
      </td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:30%">วันที่ : ' . $result_seBillings['DUEDATE'] . '</td>
   </tr>

</tbody>
</table>';

$table_begin2 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead2 = '<thead>
        <tr style="border:1px solid #000;padding:4px;font-size:20px">
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
$sql_seBillinginvoice2 = "{call megLogbillinginvoice_v2(?,?,?)}";
$params_seBillinginvoice2 = array(
    array('select_logbillinginvoice_all', SQLSRV_PARAM_IN),
    array($condBillinginvoice1, SQLSRV_PARAM_IN),
    array($condBillinginvoice2, SQLSRV_PARAM_IN)
);
$query_seBillinginvoice2 = sqlsrv_query($conn, $sql_seBillinginvoice2, $params_seBillinginvoice2);
while ($result_seBillinginvoice2 = sqlsrv_fetch_array($query_seBillinginvoice2, SQLSRV_FETCH_ASSOC)) {

  
  $tbody2 .= '<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px;" height="300px" valign="top">' . $i1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px;" valign="top">' . $result_seBillinginvoice['INVOICECODE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px;" valign="top">' . $result_seBillinginvoice2['BILLINGDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px;" valign="top">' . $result_seBillinginvoice2['PAYMENTDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px;" valign="top">' . number_format($allprice,2) . '</td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px;" valign="top"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px;" valign="top">' . number_format($allprice, 2) . '</td>
      </tr>
';

    $i1++;
    $sumtotal = $sumtotal + $result_seBillings['SUMTOTAL'];
}


$tfoot2 = '</tbody>
    <tfoot >
    <tr style="border:1px solid #000;">
        <td colspan="5" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px;">' . convert(($allprice)) . '</td>
            <td style="border-right:1px solid #000;padding:4px;font-size:22px;">รวมทั้งสิ้น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px;">' . number_format(($allprice), 2) . '</td>
      </tr>

       <tr style="">
        <td colspan="5" rowspan="2" style="border-right:1px solid #000;padding:4px;font-size:22px;"></td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px;">ภาษีหัก ณ ที่จ่าย 1 %</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px;">' . number_format((($allprice) * 1) / 100, 2) . '</td>

      </tr>
       <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;font-size:22px;">ยอดที่ต้องชำระ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px;">' . number_format(($allprice) - ((($allprice) * 1) / 100), 2) . '</td>
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


////////////////////ใบแจ้งหนี้ ใบเสร็จ//////////////////////////////////////////////////
$table_header11 = '<br>';
$table_header1 = '<table width="100%" >
<tbody>



  <tr>
    <td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
      <td colspan="7" style="font-size:20px" ><b>บริษัท ร่วมกิจรุ่งเรือง (1993) จำกัด (RUAMKIT RUNGRUENG (1993) CO., LTD.)<b></td>
  </tr>
  <tr>
    <td colspan="7" style="font-size:20px">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง จังหวัดชลบุรี 20160</td>
  </tr>
  <tr>
    <td colspan="7" style="font-size:20px">โทรศัพท์ : 038-452824-5 โทรสาร : 038-210396</td>
  </tr>
  <tr>
    <td colspan="7" style="font-size:20px">เลขประจำตัวผู้เสียภาษี 0105536076131</td>
  </tr>

   <tr>
        <td colspan="8" style="text-align:center;font-size:24px"><b>ใบแจ้งหนี้/ใบเสร็จรับเงิน</b></td>
   </tr>

</tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;font-size:24px">
<tbody>
    <tr style="border:1px solid #000;" >
    <td style="border-right:1px solid #000;padding:4px;width:70%">ลูกค้า : รหัส  	พ-014
								<br>บริษัท พารากอน สตีล ซัพพลายส์ จำกัด
								<br>สำนักงานใหญ่ 309 หมู่ที่ 3 ถนนบางโปรง ต.บางโปรง 
                <br>อ.เมืองสมุทรปราการ จ.สมุทรปราการ 10270	
								<br> โทร.  02-755-5100
								<br>เลขประจำตัวผู้เสียภาษี 0115543004230 
    </td>
        <td style="padding:4px;width:20%">เลขที่ :
        <br>วันที่ :
        <br>เครดิต :
        <br>วันที่ครบกำหนด :
        </td>

        <td style="border-right:1px solid #000;padding:4px;font-size:22px;width:20%">' . $result_seBillinginvoice['INVOICECODE'] . '
        <br> ' . $result_seBillinginvoice['DUEDATE'] . '
        <br> 30 วัน
        <br> ' . $result_seBillinginvoice['PAYMENTDATE'] . '
        </td>
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
$sql_seBillinginvoice1 = "{call megLogbillinginvoice_v2(?,?,?)}";
$params_seBillinginvoice1 = array(
    array('select_logbillinginvoice_all', SQLSRV_PARAM_IN),
    array($condBillinginvoice1, SQLSRV_PARAM_IN),
    array($condBillinginvoice2, SQLSRV_PARAM_IN)
);
$query_seBillinginvoice1 = sqlsrv_query($conn, $sql_seBillinginvoice1, $params_seBillinginvoice1);
while ($result_seBillinginvoice1 = sqlsrv_fetch_array($query_seBillinginvoice1, SQLSRV_FETCH_ASSOC)) {
    $tbody1 .= '<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:20px;" height="200px" valign="top">' . $i2 . '</td>
        <td style="border-right:1px solid #000;padding:4px;font-size:20px;"  valign="top">ค่าขนส่งสินค้าตามเอกสารแนบ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:20px;" valign="top">' . number_format($allprice, 2) . '</td>
      </tr>
';

    $i2++;
    $sumtotal = $sumtotal + $result_seBillinginvoice1['SUMTOTAL'];
}

$tfoot1 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:20px;">รวมเงิน</td>
            <td bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;font-size:20px;">' . convert($allprice) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:20px;">' . number_format($allprice, 2) . '</td>
      </tr>

    </tfoot>';

$table_end1 = '</table>';

$table_footer1 = '
<table width="100%" style="border-collapse: collapse;margin-top:8px;font-size:20px">
<tbody>
<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:30%">ได้รับบริการตามรายการเรียบร้อยแล้ว<br><br><br><br><br><br><br>ผู้รับบริการ..........................................<br>ลงวันที่................/................/.............</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:35%">การชำระเงิน<input type="checkbox" size="5" /> เงินสด&nbsp;<input type="checkbox" size="5" checked="checked"/> โอนเงิน<br><input type="checkbox"  size="5"/> เช็คธนาคาร.............................................<br>เลขที่....................วันที่........../........../..........<br>จำนวนเงิน...................................................<br><br><br><br>ผู้รับเงิน.................................................<br>ลงวันที่................/................./.................</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:35%">ในนาม บริษัท ร่วมกิจรุ่งเรือง (1993) จำกัด<br><br><br><br><br><br>.....................................................................<br>ลงวันที่............./............/.............<br>ผู้มีอำนาจลงนาม / Authorized Signature</td>
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
</table>
';




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
