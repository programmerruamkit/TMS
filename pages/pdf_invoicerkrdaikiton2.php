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



$mpdf = new mPDF('', 'Letter', '', '', 5, 18, 5, 5, '', 15);
$style = '
<style>
	body{
		font-family: "angsana";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';

$table_header2 = '<table width="100%" >
    <tbody>
        <tr>
        	<td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
            <td colspan="7" style="font-size:24px" ><b>บริษัท ร่วมกิจรุ่งเรือง (1993) จำกัด (RUAMKIT RUNGRUENG (1993) CO., LTD.)<b></td>
       </tr>
       <tr>
        	<td colspan="7" style="font-size:20px">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง จังหวัดชลบุรี 20160</td>
       </tr>
        <tr>
        	<td colspan="7" style="font-size:20px">โทรศัพท์ : 038-452824-5 โทรสาร : 038-210396</td>
       </tr>
        <tr>
        <td colspan="7" style="font-size:20px;">เลขประจำตัวผู้เสียภาษี 0105536076131</td>
       </tr>

       <tr>
        	<td colspan="8" style="text-align:center;font-size:24px"><b>ใบวางบิล</b></td>
       </tr>

    </tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;font-size:22px">
    <tbody>
        <tr style="border:1px solid #000;">
       	  <td style="border-right:1px solid #000;padding:4px;width:70%">ลูกค้า : รหัส ด-005
								<br>บริษัท ไดกิ อลูมิเนียม อินดัสทรี (ประเทศไทย) จำกัด
								<br>สำนักงานใหญ่ ที่อยู่ 700/99 ม.1 ต.บ้านเก่า
								<br>อ.พานทอง จ.ชลบุรี 20160
								<br>โทร. 038-468441,038-458862-3
		 </td>
            <td style="border-right:1px solid #000;padding:4px;width:30%">วันที่ : ' . $result_seBillings['DUEDATE'] . '</td>
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
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:25%;font-size:20px"><b>ยอดชำระแล้ว</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%;font-size:20px"><b>ยอดเงินคงค้าง</b></td>
      </tr>
  </thead><tbody>';
$i1 = 1;
$condBillinginvoice21 = " AND a.BILLINGCODE = '" . $_GET['billingcode'] . "'";
$condBillinginvoice22 = " AND b.WORKTYPE != 'return'";
$sql_seBillinginvoice2 = "{call megLogbillinginvoice_v2(?,?,?)}";
$params_seBillinginvoice2 = array(
    array('select_logbillinginvoice_all', SQLSRV_PARAM_IN),
    array($condBillinginvoice21, SQLSRV_PARAM_IN),
    array($condBillinginvoice22, SQLSRV_PARAM_IN)
);
$query_seBillinginvoice2 = sqlsrv_query($conn, $sql_seBillinginvoice2, $params_seBillinginvoice2);
while ($result_seBillinginvoice2 = sqlsrv_fetch_array($query_seBillinginvoice2, SQLSRV_FETCH_ASSOC)) {

  


    $tbody2 .= '<tr style="border:1px solid #000;font-size:22px">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px" height="300px" valign="top">' . $i1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px;text-align:center;" valign="top">' . $result_seBillinginvoice2['INVOICECODE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px;text-align:center;" valign="top">' . $result_seBillinginvoice2['BILLINGDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px;text-align:center;" valign="top">' . $result_seBillinginvoice2['PAYMENTDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px" valign="top">' . number_format($result_seBillinginvoice2['SUMTOTAL'], 2) . '</td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px" valign="top"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px" valign="top">' . number_format($result_seBillinginvoice2['SUMTOTAL'], 2) . '</td>
      </tr>
';

    $i1++;
    $sumtotal = $sumtotal + $result_seBillinginvoice2['SUMTOTAL'];
}


$tfoot2 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px">' . convert(($result_seBillinginvoice['SUMTOTAL'])) . '</td>
            <td style="border-right:1px solid #000;padding:4px;font-size:22px">รวมเงินทั้งสิ้น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px">' . number_format(($result_seBillinginvoice['SUMTOTAL']), 2) . '</td>
      </tr>

       <tr >
        <td colspan="5" rowspan="2" style="border-right:1px solid #000;padding:4px;font-size:22px"></td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px">ภาษีหัก ณ ที่จ่าย 1 %</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px">' . number_format((($result_seBillinginvoice['SUMTOTAL']) * 1) / 100, 2) . '</td>

      </tr>
       <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;font-size:22px">ยอดต้องชำระ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px">' . number_format(($result_seBillinginvoice['SUMTOTAL']) - ((($result_seBillinginvoice['SUMTOTAL']) * 1) / 100), 2) . '</td>
      </tr>
    </tfoot>';

$table_end2 = '</table>';

$table_footer2 = '
<br />
<br />
<br />
<br />
<br />



<table width="100%" style="border-collapse: collapse;margin-top:8px;font-size:22px">
<tbody>
<tr style="border:1px solid #000;">
       <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:3px;text-align:center;width:35%"><br /><br /><br />วันนัดชำระเงิน / Payment Date<br />____/____/____</td>
        <td style="border-right:1px solid #000;padding:3px;text-align:center;width:30%"><br /><br />...................................................<br />ผู้รับวางบิล / Received By<br />____/____/____</td>
        <td style="border-right:1px solid #000;padding:3px;text-align:center;width:35%"><br /><br />...................................................<br />ผู้วางบิล / Delivery By<br />____/____/____</td>
    </tr>
    </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>';

$table_header1 = '<table width="100%" >
   <tbody>
        <tr>
        	<td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
            <td colspan="7" style="font-size:24px" >บริษัท ร่วมกิจรุ่งเรือง (1993) จำกัด (RUAMKIT RUNGRUENG (1993) CO., LTD.)</td>
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
        	<td colspan="8" style="font-size:20px">&nbsp;</td>
       </tr>
       <tr>
        	<td colspan="8" style="text-align:center;font-size:24px"><b>ใบแจ้งหนี้/ใบเสร็จรับเงิน</b></td>
       </tr>
       <tr>
        	<td colspan="8" style="text-align:center;">&nbsp;</td>
       </tr>
    </tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;font-size:22px;">
    <tbody>
    
        <tr style="border:1px solid #000;" >
         <td style="border-right:1px solid #000;padding:4px;width:70%" rowspan="4">ลูกค้า : รหัส ด-005
								<br>บริษัท ไดกิ อลูมิเนียม อินดัสทรี (ประเทศไทย) จำกัด
								<br>สำนักงานใหญ่ ที่อยู่ 700/99 ม.1 ต.บ้านเก่า
								<br>อ.พานทอง จ.ชลบุรี 20160
								<br>โทร. 038-468441,038-458862-3
                <br>เลขประจำตัวผู้เสียภาษี 0105542046974
		      </td>
            <td style="border-right:1px solid #000;padding:4px;width:30%">เลขที่ : ' . $result_seBillinginvoice['INVOICECODE'] . '
            <br>วันที่ : ' . $result_seBillings['BILLINGDATE'] . '
            <br>เครดิต : 30 วัน
            <br>วันที่ครบกำหนด : ' . $result_seBillinginvoice['PAYMENTDATE'] . '
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
$condBillinginvoice11 = " AND a.BILLINGCODE = '" . $_GET['billingcode'] . "'";
$condBillinginvoice12 = " AND b.WORKTYPE != 'return'";
$sql_seBillinginvoice1 = "{call megLogbillinginvoice_v2(?,?,?)}";
$params_seBillinginvoice1 = array(
    array('select_logbillinginvoice_all', SQLSRV_PARAM_IN),
    array($condBillinginvoice11, SQLSRV_PARAM_IN),
    array($condBillinginvoice12, SQLSRV_PARAM_IN)
);
$query_seBillinginvoice1 = sqlsrv_query($conn, $sql_seBillinginvoice1, $params_seBillinginvoice1);
while ($result_seBillinginvoice1 = sqlsrv_fetch_array($query_seBillinginvoice1, SQLSRV_FETCH_ASSOC)) {
    $tbody1 .= '<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" valign="top">' . $i2 . '</td>
        <td style="border-right:1px solid #000;padding:4px;" height="180px" valign="top">ค่าขนส่งสินค้าตามเอกสารแนบ</td>
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
$table_remark1 = '<table width="100%" style="font-size:18px">
    <tbody>
        <tr>
        	<td style="width:10%"><b><u>หมายเหตุ</u> :</b></td>
            <td style="width:90%">1.ค่าขนส่งภาษีหัก ณ ที่จ่าย 1 %</td>
       </tr>
       <tr>
        	<td style="width:10%"></td>
            <td style="width:90%">2.ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์ เมื่อมีลายเซ็นผู้รับเงิน และได้รับเงินตามเซ็ค หรือ เงินโอนเข้าบัญชีเรียบร้อยแล้ว</td>
       </tr>
       <tr>
        	<td style="width:10%"></td>
            <td style="width:90%">3.ผู้รับบริการชำระเกินกำหนดที่ระบุไว้ในใบแจ้งหนี้ ผู้รับบริการยินยอมชำระค่าปรับร้อยละ 15 ต่อปี ของจำนวนเงินที่ค้างชำระ</td>
       </tr>
       <tr>
            <td colspan="2">FM-ADM-10/01 แก้ไขครั้งที่ : 01 มีผลบังคับใช้ : 01-09-60</td>
       </tr>
    </tbody>
</table>
';




$table_header4 = '<table width="100%" style="">
    <tbody>
        <tr>
        	<td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
            <td colspan="7">บริษัท ร่วมกิจรุ่งเรือง (1993) จำกัด (RUAMKIT RUNGRUENG (1993) CO., LTD.)</td>
       </tr>
       <tr>
        	<td colspan="7">สำนักงานสาขาที่ 1  เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง จังหวัดชลบุรี 20160</td>
       </tr>
        <tr>
        	<td colspan="7">โทรศัพท์ : 038-452824-5 โทรสาร : 038-210396</td>
       </tr>
        <tr>
        	<td colspan="7">เลขประจำตัวผู้เสียภาษี 0105536076131</td>
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
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;font-size:12px;">
    <tbody>
        <tr style="border:1px solid #000;">
       	  <td style="border-right:1px solid #000;padding:4px;width:70%">ลูกค้า : รหัส ด-007
								<br><br>บริษัท ไดกิ อลูมิเนียม อินดัสทรี (ประเทศไทย) จำกัด
								<br><br>สำนักงานใหญ่ ที่อยู่ 700/99 ม.1 ต.บ้านเก่า
								<br><br>อ.พานทอง จ.ชลบุรี 20160
								<br><br>โทร. 038-468441,038-458862-3
		 </td>
            <td style="border-right:1px solid #000;padding:4px;width:30%">วันที่ : ' . $result_getDate['SYSDATE'] . '</td>
       </tr>

    </tbody>
</table>';

$table_begin4 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead4 = '<thead>

        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>เลขที่ใบแจ้งหนี้</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>วันที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>วันครบกำหนด</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>จำนวนเงิน</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>ยอดชำระแล้ว</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>ยอดเงินคงค้าง</b></td>
      </tr>
  </thead><tbody>';
$i1 = 1;
$condBillinginvoice41 = " AND a.BILLINGCODE = '" . $_GET['billingcode'] . "'";
$condBillinginvoice42 = " AND b.WORKTYPE = 'return'";
$sql_seBillinginvoice4 = "{call megLogbillinginvoice_v2(?,?,?)}";
$params_seBillinginvoice4 = array(
    array('select_logbillinginvoice_all', SQLSRV_PARAM_IN),
    array($condBillinginvoice41, SQLSRV_PARAM_IN),
    array($condBillinginvoice42, SQLSRV_PARAM_IN)
);
$query_seBillinginvoice4 = sqlsrv_query($conn, $sql_seBillinginvoice4, $params_seBillinginvoice4);
while ($result_seBillinginvoice4 = sqlsrv_fetch_array($query_seBillinginvoice4, SQLSRV_FETCH_ASSOC)) {
    $tbody4 .= '<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $i1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;">' . $result_seBillinginvoice4['INVOICECODE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;">' . $result_seBillinginvoice4['BILLINGDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;">' . $result_seBillinginvoice4['PAYMENTDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($result_seBillinginvoice4['SUMTOTAL'], 2) . '</td>
        <td style="border-right:1px solid #000;padding:4px;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($result_seBillinginvoice4['SUMTOTAL'], 2) . '</td>
      </tr>
';

    $i1++;
    $sumtotal = $sumtotal + $result_seBilling1['SUMTOTAL'];
}


$tfoot4 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;">' . convert(($result_seBillinginvoice['SUMTOTAL'])) . '</td>
            <td style="border-right:1px solid #000;padding:4px;">รวมเงินทั้งสิ้น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format(($result_seBillinginvoice['SUMTOTAL']), 2) . '</td>
      </tr>

       <tr style="border:1px solid #000;">
        <td colspan="5" rowspan="2" style="border-right:1px solid #000;padding:4px;"></td>
        <td style="border-right:1px solid #000;padding:4px;">ภาษีหัก ณ ที่จ่าย 1 %</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format((($result_seBillinginvoice['SUMTOTAL']) * 1) / 100, 2) . '</td>

      </tr>
       <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;">ยอดต้องชำระ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format(($result_seBillinginvoice['SUMTOTAL']) - ((($result_seBillinginvoice['SUMTOTAL']) * 1) / 100), 2) . '</td>
      </tr>
    </tfoot>';

$table_end4 = '</table>';

$table_footer4 = '
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
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:35%"><br /><br />วันนัดชำระเงิน / Payment Date<br />___/___/___</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:30%"><br /><hr /><br />ผู้วางบิล / Received By<br />___/___/___</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:35%"><br /><hr /><br />ผู้วางบิล / Delivery By<br />___/___/___</td>
    </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>';

$table_header3 = '<table width="100%" style="">
   <tbody>
        <tr>
        	<td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
            <td colspan="7">บริษัท ร่วมกิจรุ่งเรือง (1993) จำกัด (RUAMKIT RUNGRUENG (1993) CO., LTD.)</td>
       </tr>
       <tr>
        	<td colspan="7">สำนักงานสาขาที่ 1  เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง จังหวัดชลบุรี 20160</td>
       </tr>
        <tr>
        	<td colspan="7">โทรศัพท์ : 038-452824-5 โทรสาร : 038-210396</td>
       </tr>
        <tr>
        	<td colspan="7">เลขประจำตัวผู้เสียภาษี 0105536076131</td>
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
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;font-size:12px;">
    <tbody>
        <tr style="border:1px solid #000;" >
         <td style="border-right:1px solid #000;padding:4px;width:70%" rowspan="4">ลูกค้า : รหัส ด-007
								<br><br>บริษัท ไดกิ อลูมิเนียม อินดัสทรี (ประเทศไทย) จำกัด
								<br><br>สำนักงานใหญ่ ที่อยู่ 700/99 ม.1 ต.บ้านเก่า
								<br><br>อ.พานทอง จ.ชลบุรี 20160
								<br><br>โทร. 038-468441,038-458862-3
                <br><br>เลขประจำตัวผู้เสียภาษี 0105542046974
		      </td>
            <td style="border-right:1px solid #000;padding:4px;width:30%">เลขที่ : ' . $result_seBillinginvoice['INVOICECODE'] . '
            <br><br>วันที่ : ' . $result_getDate['SYSDATE'] . '
            <br><br>เครดิต : 30 วัน
            <br><br>วันที่ครบกำหนด : ' . $result_seBillinginvoice['PAYMENTDATE'] . '
            </td>

       </tr>
    </tbody>
</table>';

$table_begin3 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead3 = '<thead>

        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:60%"><b>รายการ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:30%"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
  </thead><tbody>';
$i2 = 1;
$condBillinginvoice31 = " AND a.BILLINGCODE = '" . $_GET['billingcode'] . "'";
$condBillinginvoice32 = " AND b.WORKTYPE = 'return'";
$sql_seBillinginvoice3 = "{call megLogbillinginvoice_v2(?,?,?)}";
$params_seBillinginvoice3 = array(
    array('select_logbillinginvoice_all', SQLSRV_PARAM_IN),
    array($condBillinginvoice31, SQLSRV_PARAM_IN),
    array($condBillinginvoice32, SQLSRV_PARAM_IN)
);
$query_seBillinginvoice3 = sqlsrv_query($conn, $sql_seBillinginvoice3, $params_seBillinginvoice3);
while ($result_seBillinginvoice3 = sqlsrv_fetch_array($query_seBillinginvoice3, SQLSRV_FETCH_ASSOC)) {
    $tbody3 .= '<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" valign="top">' . $i2 . '</td>
        <td style="border-right:1px solid #000;padding:4px;" height="200px" valign="top">ค่าขนส่งสินค้าตามเอกสารแนบ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;" valign="top">' . number_format($result_seBillinginvoice3['SUMTOTAL'], 2) . '</td>
      </tr>
';

    $i2++;
    $sumtotal = $sumtotal + $result_seBillinginvoice3['SUMTOTAL'];
}

$tfoot3 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center">รวมเงิน</td>
            <td style="border-right:1px solid #000;padding:4px;">' . convert($result_seBillinginvoice['SUMTOTAL']) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($result_seBillinginvoice['SUMTOTAL'], 2) . '</td>
      </tr>

    </tfoot>';

$table_end3 = '</table>';

$table_footer3 = '<br /><br />
<table width="100%" style="border-collapse: collapse;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:30%">ได้รับบริการตามรายการเรียบร้อยแล้ว<br><br><br><br><br><br><br><br><br><br><br><br>ผู้รับบริการ.......................................<br><br>ลงวันที่........../........../..........</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:35%">การชำระเงิน<br><br><input type="checkbox" size="5" /> เงินสด&emsp;<input type="checkbox" size="5" checked="checked"/> โอนเงิน<br><br><input type="checkbox"  size="5" /> เช็คธนาคาร...................................<br><br>เลขที่.................................................<br><br>วันที่........../........../..........<br><br><br><br>ผู้รับเงิน.............................................<br><br>ลงวันที่........../........../..........</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:35%">ในนาม บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด<br><br><br><br><br><br><br><br><br><br>.......................................................<br><br>ลงวันที่........../........../..........<br><br>ผู้มีอำนาจลงนาม / Authorized Signature</td>
    </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>';
$table_remark3 = '<br /><table width="100%" style="">
    <tbody>
        <tr>
        	<td style="width:10%"><b><u>หมายเหตุ</u> :</b></td>
            <td style="width:90%">1.ค่าขนส่งภาษีหัก ณ ที่จ่าย 1 %</td>
       </tr>
       <tr>
        	<td style="width:10%"></td>
            <td style="width:90%">2.ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์ เมื่อมีลายเซ็นผู้รับเงิน และได้รับเงินตามเซ็ค หรือ เงินโอนเข้าบัญชีเรียบร้อยแล้ว</td>
       </tr>
       <tr>
        	<td style="width:10%"></td>
            <td style="width:90%">3.ผู้รับบริการชำระเกินกำหนดที่ระบุไว้ในใบแจ้งหนี้ ผู้รับบริการยินยอมชำระค่าปรับร้อยละ 15 ต่อปี ของจำนวนเงินที่ค้างชำระ</td>
       </tr>
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
/* $mpdf->AddPage();
  $mpdf->WriteHTML($table_header4);
  $mpdf->WriteHTML($table_begin4);
  $mpdf->WriteHTML($thead4);
  $mpdf->WriteHTML($tbody4);
  $mpdf->WriteHTML($tfoot4);
  $mpdf->WriteHTML($table_end4);
  $mpdf->WriteHTML($table_footer4);
  $mpdf->AddPage();
  $mpdf->WriteHTML($table_header3);
  $mpdf->WriteHTML($table_begin3);
  $mpdf->WriteHTML($thead3);
  $mpdf->WriteHTML($tbody3);
  $mpdf->WriteHTML($tfoot3);
  $mpdf->WriteHTML($table_end3);
  $mpdf->WriteHTML($table_footer3);
  $mpdf->WriteHTML($table_remark3);
 */
$mpdf->Output();



sqlsrv_close($conn);
?>
