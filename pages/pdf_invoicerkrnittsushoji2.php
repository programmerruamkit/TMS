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



$sql_LastDate = "{call megStopwork_v2(?,?)}";
$params_LastDate = array(
    array('select_lastdate', SQLSRV_PARAM_IN),
    array($result_seBillinginvoice['BILLINGDATE'], SQLSRV_PARAM_IN)
);
$query_LastDate = sqlsrv_query($conn, $sql_LastDate, $params_LastDate);
$result_LastDate = sqlsrv_fetch_array($query_LastDate, SQLSRV_FETCH_ASSOC);

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




$sql_sejobend = "SELECT TOP 1 TRANSPORTATION AS 'JOBEND'  FROM [dbo].[LOGINVOICE] WHERE INVOICECODE ='" . $result_seBillinginvoice['INVOICECODE'] . "'";
$params_sejobend = array();
$query_sejobend = sqlsrv_query($conn, $sql_sejobend, $params_sejobend);
$result_sejobend = sqlsrv_fetch_array($query_sejobend, SQLSRV_FETCH_ASSOC);



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

$sql_sumprice = "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICE)) AS 'SUMACTUALPRICE'
FROM (SELECT CONVERT(VARCHAR(30), a.DATEVLIN, 103)  AS 'DATE_VLIN',
a.THAINAME AS 'THAINAME',a.EMPLOYEENAME1 AS 'EMPLOYEENAME1',a.JOBSTART AS 'JOBSTART',a.JOBEND AS 'JOBEND',c.PRICE AS 'ACTUALPRICE'
FROM  [dbo].[VEHICLETRANSPORTPLAN] a
INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.[VEHICLETRANSPORTPRICEID] = b.[VEHICLETRANSPORTPRICEID]
WHERE 1 = 1
AND a.COMPANYCODE ='RKR' AND a.CUSTOMERCODE ='NITTSUSHOJI'
AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoice['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoice['PAYMENTDATE']."',103)
) a";
$params_sumprice = array();
$query_sumprice = sqlsrv_query($conn, $sql_sumprice, $params_sumprice);
$result_sumprice = sqlsrv_fetch_array($query_sumprice, SQLSRV_FETCH_ASSOC);




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
      <td style="border-right:1px solid #000;padding:4px;width:70%;">บริษัท ที.เอช.เอ็ม.เอ็นเตอร์ไพรส์ (ประเทศไทย) จำกัด
								<br>สำนักงานใหญ่ ที่อยู่  166/58  หมู่ที่ 3 ตำบลบึง อำเภอศรีราชา จังหวัดชลบุรี 20230		
								<br>โทร. 038-110206-7
								<br> เลขประจำตัวผู้เสียภาษี 0205560011540 
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

  $sql_seHoliday = " SELECT HOLIDAY AS 'DATE' FROM [dbo].[BILLING_HOLIDAY] WHERE INVOICECODE ='".$result_seInvoice['INVOICECODE']."'
  AND COMPANYCODE='RKR' AND CUSTOMERCODE = 'TGT' AND JOBEND = 'TGT(RKR)'";
  $params_seHoliday = array();
  $query_seHoliday = sqlsrv_query($conn, $sql_seHoliday, $params_seHoliday);
  $result_seHoliday = sqlsrv_fetch_array($query_seHoliday, SQLSRV_FETCH_ASSOC);

  $counts = 0;
  $holiday = $result_seHoliday['DATE'];
  // $holiday = $result_seHoliday['DATE'];
  if ($holiday !='') {
    $holidaysplit = explode(",", $holiday);
    if ($holidaysplit[0] !='') {
      $count1 = 1;
    }if ($holidaysplit[1] !='') {
      $count2 = 1;
    }if ($holidaysplit[2] !='') {
      $count3 = 1;
    }if ($holidaysplit[3] !='') {
      $count3 = 1;
    }if ($holidaysplit[4] !='') {
      $count3 = 1;
    }else {
      // code...
    }
  }else {
    $counts = 0;
  }
  $counts = $counts+$count1+$count2+$count3;
  $holidayprice = ($counts*1000);
    $tbody2 .= '<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px;" height="300px" valign="top">' . $i1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px;" valign="top">' . $result_seBillinginvoice['INVOICECODE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px;" valign="top">' . $result_seBillinginvoice2['BILLINGDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px;" valign="top">' . $result_seBillinginvoice2['PAYMENTDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px;" valign="top">' . number_format($result_seBillings['SUMTOTAL'], 2) . '</td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px;" valign="top"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px;" valign="top">' . number_format($result_seBillings['SUMTOTAL'], 2) . '</td>
      </tr>
';

    $i1++;
    $sumtotal = $sumtotal + $result_seBillings['SUMTOTAL'];
}


$tfoot2 = '</tbody>
    <tfoot >
    <tr style="border:1px solid #000;">
        <td colspan="5" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px;">' . convert(($result_seBillings['SUMTOTAL'])) . '</td>
            <td style="border-right:1px solid #000;padding:4px;font-size:22px;">รวมทั้งสิ้น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px;">' . number_format(($result_seBillings['SUMTOTAL']), 2) . '</td>
      </tr>

       <tr style="">
        <td colspan="5" rowspan="2" style="border-right:1px solid #000;padding:4px;font-size:22px;"></td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px;">ภาษีหัก ณ ที่จ่าย 1 %</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px;">' . number_format((($result_seBillings['SUMTOTAL']) * 1) / 100, 2) . '</td>

      </tr>
       <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;font-size:22px;">ยอดที่ต้องชำระ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px;">' . number_format(($result_seBillings['SUMTOTAL']) - ((($result_seBillings['SUMTOTAL']) * 1) / 100), 2) . '</td>
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
    <td style="border-right:1px solid #000;padding:4px;width:70%">ลูกค้า : รหัส  	ท-035
								<br>บริษัท ที.เอช.เอ็ม.เอ็นเตอร์ไพรส์ (ประเทศไทย) จำกัด
								<br>สำนักงานใหญ่ ที่อยู่  166/58  หมู่ที่ 3  ตำบลบึง 
                                                                <br>อำเภอศรีราชา จังหวัดชลบุรี 20230 
								<br> โทร. 038-110206-7 
								<br>เลขประจำตัวผู้เสียภาษี 0205560011540 
    </td>
        <td style="padding:4px;width:20%">เลขที่ :
        <br>วันที่ :
        <br>เครดิต :
        <br>วันที่ครบกำหนด :
        </td>

        <td style="border-right:1px solid #000;padding:4px;font-size:22px;width:20%">' . $result_seBillinginvoice['INVOICECODE'] . '
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
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:20px;" valign="top">' . number_format($result_seBillings['SUMTOTAL'], 2) . '</td>
      </tr>
';

    $i2++;
    $sumtotal = $sumtotal + $result_seBillinginvoice1['SUMTOTAL'];
}

$tfoot1 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:20px;">รวมเงิน</td>
            <td bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;font-size:20px;">' . convert($result_seBillings['SUMTOTAL']) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:20px;">' . number_format($result_seBillings['SUMTOTAL'], 2) . '</td>
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
