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



$mpdf = new mPDF('th', 'A4', '0', '');
$style = '
<style>
	body{
		font-family: "Garuda";font-size:12px//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';
// /////////////////////////////////////เด็นโซ่ โรงงานบางประกง////////////////////////////////
$table_header2 = '<table width="100%" >
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
      <td colspan="8" style="text-align:center;font-size:16px"><b>ใบวางบิล</b></td>
   </tr>
   <tr>
      <td colspan="8" style="text-align:center;">&nbsp;</td>
   </tr>
</tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;font-size:12px">
    <tbody>
        <tr style="border:1px solid #000;">
       	  <td style="border-right:1px solid #000;padding:4px;width:70%"> รหัสลูกค้า ด-002
								<br><br>บริษัท เด็นโซ่  (ประเทศไทย) จำกัด (โรงงานบางประกง)
								<br><br>700/87 หมู่ 1 ถ.บางนา-ตราด กม.57 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160
								<br><br>เลขประจำตัวผู้เสียภาษี 0115541001250
		       </td>
            <td style="border-right:1px solid #000;padding:4px;width:30%">วันที่ : ' . $result_getDate['SYSDATE'] . '
            <br><br><br> เลขที่ใบวางบิล : '.$result_seInvoice['INVOICECODE'].'
            </td>
       </tr>

    </tbody>
</table>';

$table_begin2 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead2 = '<thead>

        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>เลขที่ใบแจ้งหนี้</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>วันที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>วันครบกำหนด</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>จำนวนเงิน</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:20%"><b>ยอดชำระแล้ว</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>ยอดเงินคงค้าง</b></td>
      </tr>
  </thead><tbody>';
$i1 = 1;
$sql_seBillinginvoice2 = "{call megLogbillinginvoice_v2(?,?,?)}";
$params_seBillinginvoice2 = array(
    array('select_logbillinginvoice', SQLSRV_PARAM_IN),
    array($condBillinginvoice1, SQLSRV_PARAM_IN),
    array($condBillinginvoice2, SQLSRV_PARAM_IN)
);
$query_seBillinginvoice2 = sqlsrv_query($conn, $sql_seBillinginvoice2, $params_seBillinginvoice2);
while ($result_seBillinginvoice2 = sqlsrv_fetch_array($query_seBillinginvoice2, SQLSRV_FETCH_ASSOC)) {
    $tbody2 .= '<tr style="">
        <td style="border-right:1px solid #000;border-left:1px solid #000;padding:4px;text-align:center;" height="240px" valign="top">' . $i1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;"valign="top">' . $result_seBillinginvoice2['INVOICECODE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;"valign="top">' . $result_seBillinginvoice2['BILLINGDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;"valign="top">' . $result_seBillinginvoice2['PAYMENTDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;"valign="top">' . number_format($result_seBillinginvoice2['SUMTOTAL'], 2) . '</td>
        <td style="border-right:1px solid #000;padding:4px;"valign="top"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;"valign="top">' . number_format($result_seBillinginvoice2['SUMTOTAL'], 2) . '</td>
      </tr>
';

    $i1++;
    $sumtotal = $sumtotal + $result_seBilling1['SUMTOTAL'];
}


$tfoot2 = '</tbody>
<tfoot>
<tr style="border:1px solid #000;">
    <td colspan="5" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;">' . convert(($result_seBillinginvoice['SUMTOTAL'])) . '</td>
        <td style="border-right:1px solid #000;padding:4px;">รวมเงินทั้งสิ้น</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format(($result_seBillinginvoice['SUMTOTAL']), 2) . '</td>
  </tr>

   <tr style="">
    <td colspan="5" rowspan="2" style="border-right:1px solid #000;padding:4px;"></td>
    <td style="border-right:1px solid #000;padding:4px;">ภาษีหัก ณ ที่จ่าย 1 %</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format((($result_seBillinginvoice['SUMTOTAL']) * 1) / 100, 2) . '</td>

  </tr>
   <tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;">ยอดต้องชำระ</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format(($result_seBillinginvoice['SUMTOTAL']) - ((($result_seBillinginvoice['SUMTOTAL']) * 1) / 100), 2) . '</td>
  </tr>
</tfoot>';

$table_end2 = '</table>';

$table_footer2 = '<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />





<table width="100%" style="border-collapse: collapse;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:35%"><br /><br />วันนัดชำระเงิน / Payment Date<br /><br />___/___/___</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:30%"><br /><hr /><br />ผู้วางบิล / Received By<br /><br />___/___/___</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:35%"><br /><hr /><br />ผู้วางบิล / Delivery By<br /><br />___/___/___</td>
    </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>';

$table_header1 = '<table width="100%" >
<tbody>
    <tr>
      <td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
        <td colspan="7" style="font-size:15px"><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO.,LTD.)<b></td>
   </tr>
   <tr>
      <td colspan="7">สำนักงานสาขาที่ 2 เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160</td>
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
      เลขที : '.$result_seInvoice['INVOICECODE'].'<br><br>
      วันที่  : ' . $result_getDate['SYSDATE'] . '<br><br>
      วันที่ครบกำหนด : ' . $result_seBillinginvoice['PAYMENTDATE'] . '
      </td>
       </tr>


    </tbody>
</table>';

$table_begin1 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;">';
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
    array('select_logbillinginvoice', SQLSRV_PARAM_IN),
    array($condBillinginvoice1, SQLSRV_PARAM_IN),
    array($condBillinginvoice2, SQLSRV_PARAM_IN)
);
$query_seBillinginvoice1 = sqlsrv_query($conn, $sql_seBillinginvoice1, $params_seBillinginvoice1);
while ($result_seBillinginvoice1 = sqlsrv_fetch_array($query_seBillinginvoice1, SQLSRV_FETCH_ASSOC)) {
    $tbody1 .= '<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" height="250px" valign="top">' . $i2 . '</td>
        <td style="border-right:1px solid #000;padding:4px;" valign="top">ค่าขนส่งสินค้าตามเอกสารแนบ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;" valign="top">' . number_format($result_seBillinginvoice1['SUMTOTAL'], 2) . '</td>
      </tr>
';

    $i2++;
    $sumtotal = $sumtotal + $result_seBillinginvoice1['SUMTOTAL'];
}

$tfoot1 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center">รวมเงิน</td>
            <td style="border-right:1px solid #000;padding:4px;">' . convert($result_seBillinginvoice['SUMTOTAL']) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($result_seBillinginvoice['SUMTOTAL'], 2) . '</td>
      </tr>

    </tfoot>';

$table_end1 = '</table>';

$table_footer1 = '<br /><br />
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
$table_remark1 = '<br /><table width="100%" >
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
////////////////////////////////////////////////////บริษัท อันเด็น ประเทศไทย///////////////////////

$table_header3 = '<table width="100%" >
<tbody>
    <tr>
      <td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
        <td colspan="7" style="font-size:15px"><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO.,LTD.)<b></td>
   </tr>
   <tr>
      <td colspan="7">สำนักงานสาขาที่ 2 เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160</td>
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
      <td colspan="8" style="text-align:center;font-size:16px"><b>ใบวางบิล</b></td>
   </tr>
   <tr>
      <td colspan="8" style="text-align:center;">&nbsp;</td>
   </tr>
</tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;font-size:12px">
    <tbody>
        <tr style="border:1px solid #000;">
       	  <td style="border-right:1px solid #000;padding:4px;width:70%"> รหัสลูกค้า อ-002
								<br><br>บริษัท อันเด็น  (ประเทศไทย) จำกัด
								<br><br>700/87 หมู่ 1 ถ.บางนา-ตราด กม.57 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160
                <br><br>โทร. 038-21 4649, 038-21 4651-4
								<br><br>เลขประจำตัวผู้เสียภาษี 0205545008860
		       </td>
            <td style="border-right:1px solid #000;padding:4px;width:30%">วันที่ : ' . $result_getDate['SYSDATE'] . '
            <br><br><br> เลขที่ใบวางบิล : '.$result_seInvoice['INVOICECODE'].'
            </td>
       </tr>

    </tbody>
</table>';

$table_begin3 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead3 = '<thead>

        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>เลขที่ใบแจ้งหนี้</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>วันที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>วันครบกำหนด</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>จำนวนเงิน</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:20%"><b>ยอดชำระแล้ว</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>ยอดเงินคงค้าง</b></td>
      </tr>
  </thead><tbody>';
$i1 = 1;
$sql_seBillinginvoice2 = "{call megLogbillinginvoice_v2(?,?,?)}";
$params_seBillinginvoice2 = array(
    array('select_logbillinginvoice', SQLSRV_PARAM_IN),
    array($condBillinginvoice1, SQLSRV_PARAM_IN),
    array($condBillinginvoice2, SQLSRV_PARAM_IN)
);
$query_seBillinginvoice2 = sqlsrv_query($conn, $sql_seBillinginvoice2, $params_seBillinginvoice2);
while ($result_seBillinginvoice2 = sqlsrv_fetch_array($query_seBillinginvoice2, SQLSRV_FETCH_ASSOC)) {
    $tbody3 .= '<tr style="">
        <td style="border-right:1px solid #000;border-left:1px solid #000;padding:4px;text-align:center;" height="240px" valign="top">' . $i1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;"valign="top">' . $result_seBillinginvoice2['INVOICECODE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;"valign="top">' . $result_seBillinginvoice2['BILLINGDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;"valign="top">' . $result_seBillinginvoice2['PAYMENTDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;"valign="top">' . number_format($result_seBillinginvoice2['SUMTOTAL'], 2) . '</td>
        <td style="border-right:1px solid #000;padding:4px;"valign="top"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;"valign="top">' . number_format($result_seBillinginvoice2['SUMTOTAL'], 2) . '</td>
      </tr>
';

    $i1++;
    $sumtotal = $sumtotal + $result_seBilling1['SUMTOTAL'];
}


$tfoot3 = '</tbody>
<tfoot>
<tr style="border:1px solid #000;">
    <td colspan="5" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;">' . convert(($result_seBillinginvoice['SUMTOTAL'])) . '</td>
        <td style="border-right:1px solid #000;padding:4px;">รวมเงินทั้งสิ้น</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format(($result_seBillinginvoice['SUMTOTAL']), 2) . '</td>
  </tr>

   <tr style="">
    <td colspan="5" rowspan="2" style="border-right:1px solid #000;padding:4px;"></td>
    <td style="border-right:1px solid #000;padding:4px;">ภาษีหัก ณ ที่จ่าย 1 %</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format((($result_seBillinginvoice['SUMTOTAL']) * 1) / 100, 2) . '</td>

  </tr>
   <tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;">ยอดต้องชำระ</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format(($result_seBillinginvoice['SUMTOTAL']) - ((($result_seBillinginvoice['SUMTOTAL']) * 1) / 100), 2) . '</td>
  </tr>
</tfoot>';

$table_end3 = '</table>';

$table_footer3 = '<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />


<table width="100%" style="border-collapse: collapse;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:35%"><br /><br />วันนัดชำระเงิน / Payment Date<br /><br />___/___/___</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:30%"><br /><hr /><br />ผู้วางบิล / Received By<br /><br />___/___/___</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:35%"><br /><hr /><br />ผู้วางบิล / Delivery By<br /><br />___/___/___</td>
    </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>';

$table_header4 = '<table width="100%" >
<tbody>
    <tr>
      <td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
        <td colspan="7" style="font-size:15px"><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO.,LTD.)<b></td>
   </tr>
   <tr>
      <td colspan="7">สำนักงานสาขาที่ 2 เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160</td>
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
      เลขที : '.$result_seInvoice['INVOICECODE'].'<br><br>
      วันที่  : ' . $result_getDate['SYSDATE'] . '<br><br>
      วันที่ครบกำหนด : ' . $result_seBillinginvoice['PAYMENTDATE'] . '
      </td>
       </tr>


    </tbody>
</table>';

$table_begin4 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead4 = '<thead>

        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:60%"><b>รายการ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:30%"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
  </thead><tbody>';
$i2 = 1;
$sql_seBillinginvoice1 = "{call megLogbillinginvoice_v2(?,?,?)}";
$params_seBillinginvoice1 = array(
    array('select_logbillinginvoice', SQLSRV_PARAM_IN),
    array($condBillinginvoice1, SQLSRV_PARAM_IN),
    array($condBillinginvoice2, SQLSRV_PARAM_IN)
);
$query_seBillinginvoice1 = sqlsrv_query($conn, $sql_seBillinginvoice1, $params_seBillinginvoice1);
while ($result_seBillinginvoice1 = sqlsrv_fetch_array($query_seBillinginvoice1, SQLSRV_FETCH_ASSOC)) {
    $tbody4 .= '<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" height="250px" valign="top">' . $i2 . '</td>
        <td style="border-right:1px solid #000;padding:4px;" valign="top">ค่าขนส่งสินค้าตามเอกสารแนบ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;" valign="top">' . number_format($result_seBillinginvoice1['SUMTOTAL'], 2) . '</td>
      </tr>
';

    $i2++;
    $sumtotal = $sumtotal + $result_seBillinginvoice1['SUMTOTAL'];
}

$tfoot4 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center">รวมเงิน</td>
            <td style="border-right:1px solid #000;padding:4px;">' . convert($result_seBillinginvoice['SUMTOTAL']) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($result_seBillinginvoice['SUMTOTAL'], 2) . '</td>
      </tr>

    </tfoot>';

$table_end4 = '</table>';

$table_footer4 = '<br /><br />
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
$table_remark4 = '<br /><table width="100%" >
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
$table_header5 = '<table width="100%" >
<tbody>
    <tr>
      <td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
        <td colspan="7" style="font-size:15px"><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO.,LTD.)<b></td>
   </tr>
   <tr>
      <td colspan="7">สำนักงานสาขาที่ 2 เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160</td>
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
      <td colspan="8" style="text-align:center;font-size:16px"><b>ใบวางบิล</b></td>
   </tr>
   <tr>
      <td colspan="8" style="text-align:center;">&nbsp;</td>
   </tr>
</tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;font-size:12px">
    <tbody>
        <tr style="border:1px solid #000;">
       	  <td style="border-right:1px solid #000;padding:4px;width:70%"> รหัสลูกค้า อ-025
								<br><br>บริษัท แอร์ ซิสเต็มส์  (ประเทศไทย) จำกัด
								<br><br>219/5-6 หมู่ 6 ต.บ่อวิน อ.ศรีราชา จ.ชลบุรี 20230
                <br><br>โทร. 038-317050-1
								<br><br>เลขประจำตัวผู้เสียภาษี 0245555000837
		       </td>
            <td style="border-right:1px solid #000;padding:4px;width:30%">วันที่ : ' . $result_getDate['SYSDATE'] . '
            <br><br><br> เลขที่ใบวางบิล : '.$result_seInvoice['INVOICECODE'].'
            </td>
       </tr>

    </tbody>
</table>';

$table_begin5 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead5 = '<thead>

        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>เลขที่ใบแจ้งหนี้</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>วันที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>วันครบกำหนด</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>จำนวนเงิน</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:20%"><b>ยอดชำระแล้ว</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>ยอดเงินคงค้าง</b></td>
      </tr>
  </thead><tbody>';
$i1 = 1;
$sql_seBillinginvoice2 = "{call megLogbillinginvoice_v2(?,?,?)}";
$params_seBillinginvoice2 = array(
    array('select_logbillinginvoice', SQLSRV_PARAM_IN),
    array($condBillinginvoice1, SQLSRV_PARAM_IN),
    array($condBillinginvoice2, SQLSRV_PARAM_IN)
);
$query_seBillinginvoice2 = sqlsrv_query($conn, $sql_seBillinginvoice2, $params_seBillinginvoice2);
while ($result_seBillinginvoice2 = sqlsrv_fetch_array($query_seBillinginvoice2, SQLSRV_FETCH_ASSOC)) {
    $tbody5 .= '<tr style="">
        <td style="border-right:1px solid #000;border-left:1px solid #000;padding:4px;text-align:center;" height="240px" valign="top">' . $i1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;"valign="top">' . $result_seBillinginvoice2['INVOICECODE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;"valign="top">' . $result_seBillinginvoice2['BILLINGDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;"valign="top">' . $result_seBillinginvoice2['PAYMENTDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;"valign="top">' . number_format($result_seBillinginvoice2['SUMTOTAL'], 2) . '</td>
        <td style="border-right:1px solid #000;padding:4px;"valign="top"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;"valign="top">' . number_format($result_seBillinginvoice2['SUMTOTAL'], 2) . '</td>
      </tr>
';

    $i1++;
    $sumtotal = $sumtotal + $result_seBilling1['SUMTOTAL'];
}


$tfoot5 = '</tbody>
<tfoot>
<tr style="border:1px solid #000;">
    <td colspan="5" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;">' . convert(($result_seBillinginvoice['SUMTOTAL'])) . '</td>
        <td style="border-right:1px solid #000;padding:4px;">รวมเงินทั้งสิ้น</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format(($result_seBillinginvoice['SUMTOTAL']), 2) . '</td>
  </tr>

   <tr style="">
    <td colspan="5" rowspan="2" style="border-right:1px solid #000;padding:4px;"></td>
    <td style="border-right:1px solid #000;padding:4px;">ภาษีหัก ณ ที่จ่าย 1 %</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format((($result_seBillinginvoice['SUMTOTAL']) * 1) / 100, 2) . '</td>

  </tr>
   <tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;">ยอดต้องชำระ</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format(($result_seBillinginvoice['SUMTOTAL']) - ((($result_seBillinginvoice['SUMTOTAL']) * 1) / 100), 2) . '</td>
  </tr>
</tfoot>';

$table_end5 = '</table>';

$table_footer5 = '<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />


<table width="100%" style="border-collapse: collapse;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:35%"><br /><br />วันนัดชำระเงิน / Payment Date<br /><br />___/___/___</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:30%"><br /><hr /><br />ผู้วางบิล / Received By<br /><br />___/___/___</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:35%"><br /><hr /><br />ผู้วางบิล / Delivery By<br /><br />___/___/___</td>
    </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>';

$table_header6 = '<table width="100%" >
<tbody>
    <tr>
      <td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
        <td colspan="7" style="font-size:15px"><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO.,LTD.)<b></td>
   </tr>
   <tr>
      <td colspan="7">สำนักงานสาขาที่ 2 เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160</td>
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
      เลขที : '.$result_seInvoice['INVOICECODE'].'<br><br>
      วันที่  : ' . $result_getDate['SYSDATE'] . '<br><br>
      วันที่ครบกำหนด : ' . $result_seBillinginvoice['PAYMENTDATE'] . '
      </td>
       </tr>


    </tbody>
</table>';

$table_begin6 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead6 = '<thead>

        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:60%"><b>รายการ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:30%"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
  </thead><tbody>';
$i2 = 1;
$sql_seBillinginvoice1 = "{call megLogbillinginvoice_v2(?,?,?)}";
$params_seBillinginvoice1 = array(
    array('select_logbillinginvoice', SQLSRV_PARAM_IN),
    array($condBillinginvoice1, SQLSRV_PARAM_IN),
    array($condBillinginvoice2, SQLSRV_PARAM_IN)
);
$query_seBillinginvoice1 = sqlsrv_query($conn, $sql_seBillinginvoice1, $params_seBillinginvoice1);
while ($result_seBillinginvoice1 = sqlsrv_fetch_array($query_seBillinginvoice1, SQLSRV_FETCH_ASSOC)) {
    $tbody6 .= '<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" height="250px" valign="top">' . $i2 . '</td>
        <td style="border-right:1px solid #000;padding:4px;" valign="top">ค่าขนส่งสินค้าตามเอกสารแนบ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;" valign="top">' . number_format($result_seBillinginvoice1['SUMTOTAL'], 2) . '</td>
      </tr>
';

    $i2++;
    $sumtotal = $sumtotal + $result_seBillinginvoice1['SUMTOTAL'];
}

$tfoot6 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center">รวมเงิน</td>
            <td style="border-right:1px solid #000;padding:4px;">' . convert($result_seBillinginvoice['SUMTOTAL']) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($result_seBillinginvoice['SUMTOTAL'], 2) . '</td>
      </tr>

    </tfoot>';

$table_end6 = '</table>';

$table_footer6 = '<br /><br />
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
$table_remark6 = '<br /><table width="100%" >
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
$mpdf->WriteHTML($table_header2);
$mpdf->WriteHTML($table_begin2);
$mpdf->WriteHTML($thead2);
$mpdf->WriteHTML($tbody2);
$mpdf->WriteHTML($tfoot2);
$mpdf->WriteHTML($table_end2);
$mpdf->WriteHTML($table_footer2);
$mpdf->AddPage();
$mpdf->WriteHTML($table_header1);
$mpdf->WriteHTML($table_begin1);
$mpdf->WriteHTML($thead1);
$mpdf->WriteHTML($tbody1);
$mpdf->WriteHTML($tfoot1);
$mpdf->WriteHTML($table_end1);
$mpdf->WriteHTML($table_footer1);
$mpdf->WriteHTML($table_remark1);
/////////////////////////////////
$mpdf->AddPage();
$mpdf->WriteHTML($table_header3);
$mpdf->WriteHTML($table_begin3);
$mpdf->WriteHTML($thead3);
$mpdf->WriteHTML($tbody3);
$mpdf->WriteHTML($tfoot3);
$mpdf->WriteHTML($table_end3);
$mpdf->WriteHTML($table_footer3);
$mpdf->AddPage();
$mpdf->WriteHTML($table_header4);
$mpdf->WriteHTML($table_begin4);
$mpdf->WriteHTML($thead4);
$mpdf->WriteHTML($tbody4);
$mpdf->WriteHTML($tfoot4);
$mpdf->WriteHTML($table_end4);
$mpdf->WriteHTML($table_footer4);
///////////////////////////////////
$mpdf->AddPage();
$mpdf->WriteHTML($table_header5);
$mpdf->WriteHTML($table_begin5);
$mpdf->WriteHTML($thead5);
$mpdf->WriteHTML($tbody5);
$mpdf->WriteHTML($tfoot5);
$mpdf->WriteHTML($table_end5);
$mpdf->WriteHTML($table_footer5);
$mpdf->AddPage();
$mpdf->WriteHTML($table_header6);
$mpdf->WriteHTML($table_begin6);
$mpdf->WriteHTML($thead6);
$mpdf->WriteHTML($tbody6);
$mpdf->WriteHTML($tfoot6);
$mpdf->WriteHTML($table_end6);
$mpdf->WriteHTML($table_footer6);

$mpdf->Output();



sqlsrv_close($conn);
?>
