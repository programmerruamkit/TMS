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

$condPrice6w1 = " AND [FROM] = 'STM->TMT SR' AND VEHICLETYPE = '6W'";
$condPrice6w2 = "";
$sql_sePrice6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_sePrice6w = array(
    array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
    array($condPrice6w1, SQLSRV_PARAM_IN),
    array($condPrice6w2, SQLSRV_PARAM_IN)
);
$query_sePrice6w = sqlsrv_query($conn, $sql_sePrice6w, $params_sePrice6w);
$result_sePrice6w = sqlsrv_fetch_array($query_sePrice6w, SQLSRV_FETCH_ASSOC);

$condPrice10w1 = " AND [FROM] = 'STM->TMT SR' AND VEHICLETYPE = '10W'";
$condPrice10w2 = "";
$sql_sePrice10w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_sePrice10w = array(
    array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
    array($condPrice10w1, SQLSRV_PARAM_IN),
    array($condPrice10w2, SQLSRV_PARAM_IN)
);
$query_sePrice10w = sqlsrv_query($conn, $sql_sePrice10w, $params_sePrice10w);
$result_sePrice10w = sqlsrv_fetch_array($query_sePrice10w, SQLSRV_FETCH_ASSOC);
//
$TRIP6W11 = substr($result_seBillings['TRIP1'], 0, 3);
$TRIP10W11 = substr($result_seBillings['TRIP1'], -3, 6);
$TRIP6W22 = substr($result_seBillings['TRIP2'], 0, 3);
$TRIP10W22 = substr($result_seBillings['TRIP2'], -3, 6);

$sum6w11=($TRIP6W11*$result_sePrice6w['ACTUALPRICE']);
$sum10w11=($TRIP10W11*$result_sePrice10w['ACTUALPRICE']);
$sum6w22=($TRIP6W22*$result_sePrice6w['ACTUALPRICE']);
$sum10w22=($TRIP10W22*$result_sePrice10w['ACTUALPRICE']);
$sumtotal3 = $sum6w11 + $sum10w11+ $sum6w22+$sum10w22;

//
// $mpdf = new mPDF('th', 'A4', '0', '');
$mpdf = new mPDF('', 'Letter', '', '', 3, 18, '', 5, '', 15);
$style = '
<style>
	body{
		font-family: "angsana";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';

$table_header2 = '<br><table width="100%" >
<tbody>
    <tr>
      <td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
        <td colspan="7" style="font-size:24px" ><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO., LTD.)<b></td>
   </tr>
   <tr>
      <td colspan="7" style="font-size:20px">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160</td>
   </tr>
    <tr>
      <td colspan="7" style="font-size:20px">โทรศัพท์: 038-452824-5 โทรสาร : 038-210396</td>
   </tr>
    <tr>
    <td colspan="7" style="font-size:20px;">เลขประจำตัวผู้เสียภาษี 0105544064899</td>
   </tr>

   <tr>
      <td colspan="8" style="text-align:center;font-size:24px"><b>ใบวางบิล</b></td>
   </tr>

</tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;font-size:22px">
<tbody>
    <tr style="border:1px solid #000;">
      <td style="border-right:1px solid #000;padding:4px;width:70%;">ลูกค้า : รหัส ต-002
            <br>บริษัท โตโยต้า มอเตอร์ (ประเทศไทย) จำกัด (สำนักงานใหญ่)
            <br>186/1 หมู่ 1 ถนนทางรถไฟเก่า ต.สำโรงใต้ อ.พระประแดง จ.สมุสมุทรปราการ
            <br>โทร. 02-7905946
            <br>เลขประจำตัวผู้เสียภาษี 0105505001679
      </td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:30%;">วันที่ : ' . $result_seBillings['DUEDATE'] . '</td>
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
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:18%;font-size:20px"><b>ยอดชำระแล้ว</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%;font-size:20px"><b>ยอดเงินคงค้าง</b></td>
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
    $tbody2 .= '<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px">' . $i1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px">' . $result_seBillinginvoice2['INVOICECODE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px">' . $result_seBillinginvoice2['BILLINGDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px">' . $result_seBillinginvoice2['PAYMENTDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px">' . number_format($sumtotal3, 2) . '</td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px">' . number_format($sumtotal3, 2) . '</td>
      </tr>
';

    $i1++;
    $sumtotal = $sumtotal + $result_seBilling1['SUMTOTAL'];
}


$tfoot2 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px">' . convert(($sumtotal3)) . '</td>
            <td style="border-right:1px solid #000;padding:4px;font-size:22px">รวมเงินทั้งสิ้น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px">' . number_format(($sumtotal3), 2) . '</td>
      </tr>

       <tr style="border:1px solid #000;">
        <td colspan="5" rowspan="2" style="border-right:1px solid #000;padding:4px;font-size:22px"></td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px">ภาษีหัก ณ ที่จ่าย 1 %</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px">' . number_format((($sumtotal3) * 1) / 100, 2) . '</td>

      </tr>
       <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;font-size:22px">ยอดที่ต้องชำระ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px">' . number_format(($sumtotal3) - ((($sumtotal3) * 1) / 100), 2) . '</td>
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
<br />
<br />
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



///////////////ใบแจ้งหนี้ ใบเสร็จรับเงิน///////////////////////////////////////////////////////////

$table_header1 = '<br><table width="100%" >
<tbody>
    <tr>
      <td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
        <td colspan="7" style="font-size:24px"><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO., LTD.)</td>
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
      <td colspan="8" style="text-align:center;font-size:24px"><b>ใบแจ้งหนี้/ใบเสร็จรับเงิน</b></td>
   </tr>

</tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;font-size:22px">
<tbody>
    <tr style="border:1px solid #000;" >
    <td style="border-right:1px solid #000;padding:4px;width:70%">ลูกค้า : รหัส ต-002
          <br>บริษัท โตโยต้า มอเตอร์ (ประเทศไทย) จำกัด (สำนักงานใหญ่)
          <br>186/1 หมู่ 1 ถนนทางรถไฟเก่า ต.สำโรงใต้ อ.พระประแดง จ.สมุสมุทรปราการ
          <br>โทร. 02-7905946
          <br>เลขประจำตัวผู้เสียภาษี 0105505001679
    </td>
        <td style="padding:4px;width:20%">เลขที่ :
        <br>วันที่ :
        <br>เครดิต :
        <br>วันที่ครบกำหนด :
        </td>

        <td style="border-right:1px solid #000;padding:4px;width:20%">' . $result_seBillinginvoice['INVOICECODE'] . '
        <br> ' . $result_seBillings['DUEDATE'] . '
        <br> 30 วัน
        <br> ' . $result_seBillinginvoice['PAYMENTDATE'] . '
        </td>
   </tr>
</tbody>
</table>';

$table_begin1 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;font-size:20px">';
$thead1 = '<thead>

        <tr style="border:1px solid #000;padding:4px;">
        <th style="border-right:1px solid #000;padding:4px;text-align:center;width:10%"><b>ลำดับ</b></th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;width:75%"><b>รายการ</b></th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;width:20%"><b>จำนวนเงิน(บาท)</b></th>
      </tr>
  </thead><tbody>';
$i2 = 1;
$PR1 = substr($result_seBillings['PRPO1'], 0, 10);
$PO1 = substr($result_seBillings['PRPO1'], -10, 20);
$TRIP6W1 = substr($result_seBillings['TRIP1'], 0, 3);
$TRIP10W1 = substr($result_seBillings['TRIP1'], -3, 6);


$PR2 = substr($result_seBillings['PRPO2'], 0, 10);
$PO2 = substr($result_seBillings['PRPO2'], -10, 20);
$TRIP6W2 = substr($result_seBillings['TRIP2'], 0, 3);
$TRIP10W2 = substr($result_seBillings['TRIP2'], -3, 6);

if ($result_seBillings['PRPO2'] != '') {
$sql_seBillinginvoice1 = "{call megLogbillinginvoice_v2(?,?,?)}";
$params_seBillinginvoice1 = array(
    array('select_logbillinginvoice', SQLSRV_PARAM_IN),
    array($condBillinginvoice1, SQLSRV_PARAM_IN),
    array($condBillinginvoice2, SQLSRV_PARAM_IN)
);
$query_seBillinginvoice1 = sqlsrv_query($conn, $sql_seBillinginvoice1, $params_seBillinginvoice1);
$result_seBillinginvoice1 = sqlsrv_fetch_array($query_seBillinginvoice1, SQLSRV_FETCH_ASSOC);

      $tbody1 .= '<tr style="border:1px solid #000;">
                  <td style="border-right:1px solid #000;padding:4px;text-align:center;" height="100px" valign="top">1</td>
                  <td style="border-right:1px solid #000;padding:4px;"  valign="top">ค่าขนส่งสินค้าตามเอกสารแนบ

                  <br>PR. '.$PR1.' PO. '.$PO1.'
                  <br>1.1 Transportation charge : STM TO TMT S/R (6 Wheels) = TRIP '.str_replace(',','',$TRIP6W1).' x '.$result_sePrice6w['ACTUALPRICE'].' PRICE
                  <br>1.2 Transportation charge : STM TO TMT S/R (10 Wheels) = TRIP '.str_replace(',','',$TRIP10W1).' x '.$result_sePrice10w['ACTUALPRICE'].' PRICE
                  </td>

                      <td style="border-right:1px solid #000;padding:4px;text-align:right;" valign="top">
                      <br><br>'.number_format(($TRIP6W1*$result_sePrice6w['ACTUALPRICE']),2).'
                      <br>'.number_format(($TRIP10W1*$result_sePrice10w['ACTUALPRICE']),2).'
                      </td>
                 </tr>
                 <tr style="border:1px solid #000;">
                     <td style="border-right:1px solid #000;padding:4px;text-align:center;" height="100px" valign="top">2</td>
                     <td style="border-right:1px solid #000;padding:4px;"  valign="top">ค่าขนส่งสินค้าตามเอกสารแนบ

                     <br>PR. '.$PR2.' PO. '.$PO2.'
                     <br>1.1 Transportation charge : STM TO TMT S/R (6 Wheels) = TRIP '.str_replace(',','',$TRIP6W2).' x '.$result_sePrice6w['ACTUALPRICE'].' PRICE
                     <br>1.2 Transportation charge : STM TO TMT S/R (10 Wheels) = TRIP '.str_replace(',','',$TRIP10W2).' x '.$result_sePrice10w['ACTUALPRICE'].' PRICE
                     </td>

                     <td style="border-right:1px solid #000;padding:4px;text-align:right;" valign="top">
                     <br><br>'.number_format(($TRIP6W2*$result_sePrice6w['ACTUALPRICE']),2).'
                     <br>'.number_format(($TRIP10W2*$result_sePrice10w['ACTUALPRICE']),2).'
                     </td>
                 </tr>


      ';

      $sum6w1=($TRIP6W1*$result_sePrice6w['ACTUALPRICE']);
      $sum10w1=($TRIP10W1*$result_sePrice10w['ACTUALPRICE']);
      $sum6w2=($TRIP6W2*$result_sePrice6w['ACTUALPRICE']);
      $sum10w2=($TRIP10W2*$result_sePrice10w['ACTUALPRICE']);
      $sumtotal1 = $sum6w1 + $sum10w1+ $sum6w2+$sum10w2;
}else {


      $tbody1 .= '<tr style="border:1px solid #000;">
                  <td style="border-right:1px solid #000;padding:4px;text-align:center;" height="130px" valign="top">1</td>
                  <td style="border-right:1px solid #000;padding:4px;"  valign="top">ค่าขนส่งสินค้าตามเอกสารแนบ
                  <br>'.$result_seBillings['PRPO1'].'
                  <br>PR. '.$PR1.' PO. '.$PO1.'
                  <br>1.1 Transportation charge : STM TO TMT S/R (6 Wheels) = TRIP '.str_replace(',','',$TRIP6W1).' x '.$result_sePrice6w['ACTUALPRICE'].' PRICE
                  <br>1.2 Transportation charge : STM TO TMT S/R (10 Wheels) = TRIP '.str_replace(',','',$TRIP10W1).' x '.$result_sePrice10w['ACTUALPRICE'].' PRICE
                  </td>

                      <td style="border-right:1px solid #000;padding:4px;text-align:right;" valign="top">
                      <br><br>'.number_format(($TRIP6W1*$result_sePrice6w['ACTUALPRICE']),2).'
                      <br>'.number_format(($TRIP10W1*$result_sePrice10w['ACTUALPRICE']),2).'
                      </td>
                 </tr>


      ';

      $sum6w1=($TRIP6W1*$result_sePrice6w['ACTUALPRICE']);
      $sum10w1=($TRIP10W1*$result_sePrice10w['ACTUALPRICE']);
      $sum6w2=($TRIP6W2*$result_sePrice6w['ACTUALPRICE']);
      $sum10w2=($TRIP10W2*$result_sePrice10w['ACTUALPRICE']);
      $sumtotal1 = $sum6w1 + $sum10w1+ $sum6w2+$sum10w2;


}




$tfoot1 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center">รวมเงิน</td>
            <td style="border-right:1px solid #000;padding:4px;">' . convert($sumtotal1) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($sumtotal1, 2) . '</td>
      </tr>

    </tfoot>';

$table_end1 = '</table>';

$table_footer1 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;font-size:20px">
<tbody>
<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:30%">ได้รับบริการตามรายการเรียบร้อยแล้ว<br><br><br><br><br><br><br><br>ผู้รับบริการ..........................................<br>ลงวันที่................/................/.............</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:35%">การชำระเงิน<input type="checkbox" size="5" /> เงินสด&nbsp;<input type="checkbox" size="5" checked="checked"/> โอนเงิน<br><input type="checkbox"  size="5"/> เช็คธนาคาร.............................................<br>เลขที่....................วันที่........../........../..........<br>จำนวนเงิน...................................................<br><br><br><br><br>ผู้รับเงิน.................................................<br>ลงวันที่................/................./.................</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:35%">ในนาม บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด<br><br><br><br><br><br><br>.....................................................................<br>ลงวันที่............./............/.............<br>ผู้มีอำนาจลงนาม / Authorized Signature</td>
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


$mpdf->Output();



sqlsrv_close($conn);
?>
