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

$i2 = 1;
$sql_sePrice = "SELECT DISTINCT b.VEHICLETRANSPORTDOCUMENTDRIVERID, b.VEHICLETRANSPORTPLANID,c.ACTUALPRICE AS 'PRICE'
            FROM [dbo].[LOGINVOICE] a
            INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
            INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID]
            WHERE 1 = 1 AND a.INVOICECODE = '" . $result_seBillinginvoice['INVOICECODE'] . "'";
$params_sePrice = array();
$query_sePrice = sqlsrv_query($conn, $sql_sePrice, $params_sePrice);
while ($result_sePrice = sqlsrv_fetch_array($query_sePrice, SQLSRV_FETCH_ASSOC)){

$price = $price+$result_sePrice['PRICE'];

$i2++;

}




$condBillings1 = " AND a.BILLINGCODE = '" . $_GET['billingcode'] . "'";
$condBillings2 = "";
$sql_seBilling1 = "SELECT DISTINCT a.DUEDATE,a.COMPANYCODE,a.CUSTOMERCODE, a.BILLINGCODE, a.INVOICECODE, a.BILLINGDATE, a.PAYMENTDATE,a.PRPO1,a.TRIP1,a.PRPO2,a.TRIP2, a.SUMTOTAL, a.EXPRESSWAYAMT15, a.EXPRESSWAYAMT45, a.EXPRESSWAYAMT55, a.EXPRESSWAYAMT65, a.EXPRESSWAYAMT75, a.EXPRESSWAYAMT100, a.EXPRESSWAYAMT195, a.EXPRESSWAYAMT65RETURN, a.EXPRESSWAYAMT105RETURN, a.EXPRESSWAYPRICE15, a.EXPRESSWAYPRICE45, a.EXPRESSWAYPRICE55, a.EXPRESSWAYPRICE65, a.EXPRESSWAYPRICE75, a.EXPRESSWAYPRICE100, a.EXPRESSWAYPRICE195, a.EXPRESSWAYPRICE65RETURN, a.EXPRESSWAYPRICE105RETURN, a.ACTIVESTATUS, a.REMARK,b.EXPRESSWAYCODE FROM [dbo].[LOGBILLINGINVOICE] a
			INNER JOIN [dbo].[LOGINVOICE] b ON a.INVOICECODE = b.INVOICECODE
			WHERE a.ACTIVESTATUS = '1'".$condBillings1.$condBillings2;
$params_seBillings = array();

$query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
$result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);



$mpdf = new mPDF('', 'Letter', '', '', 4, 15, 95, 5, 5, 5);
// $mpdf = new mPDF('', 'Letter', '', '', 2, 18, 100, 5, '', 15);
$style = '
<style>
	body{
		font-family: "angsana";font-size:12px//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';


//////////////////////////////ใบวางบิล//////////////////////////////////
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
       	  <td style="border-right:1px solid #000;padding:4px;width:70%">ลูกค้า : รหัส ด-007
								<br>บริษัท ไดกิ อลูมิเนียม อินดัสทรี (ประเทศไทย) จำกัด
								<br>สำนักงานใหญ่ ที่อยู่ 700/99 ม.1 ต.บ้านเก่า
								<br>อ.พานทอง จ.ชลบุรี 20160
								<br>โทร. 038-468441,038-458862-3
		 </td>
            <td style="border-right:1px solid #000;padding:4px;width:30%">วันที่ : ' . $result_seBillinginvoice['DUEDATE'] . '</td>
       </tr>

    </tbody>
</table>';

$table_begin2 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;font-size:22px">';
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
$sql_seBillinginvoice2 = "SELECT DISTINCT a.DUEDATE,a.COMPANYCODE,a.CUSTOMERCODE, a.BILLINGCODE, a.INVOICECODE, a.BILLINGDATE, a.PAYMENTDATE,a.PRPO1,a.TRIP1,a.PRPO2,a.TRIP2, a.SUMTOTAL, a.EXPRESSWAYAMT15, a.EXPRESSWAYAMT45, a.EXPRESSWAYAMT55, a.EXPRESSWAYAMT65, a.EXPRESSWAYAMT75, a.EXPRESSWAYAMT100, a.EXPRESSWAYAMT195, a.EXPRESSWAYAMT65RETURN, a.EXPRESSWAYAMT105RETURN, a.EXPRESSWAYPRICE15, a.EXPRESSWAYPRICE45, a.EXPRESSWAYPRICE55, a.EXPRESSWAYPRICE65, a.EXPRESSWAYPRICE75, a.EXPRESSWAYPRICE100, a.EXPRESSWAYPRICE195, a.EXPRESSWAYPRICE65RETURN, a.EXPRESSWAYPRICE105RETURN, a.ACTIVESTATUS, a.REMARK,b.EXPRESSWAYCODE FROM [dbo].[LOGBILLINGINVOICE] a
			INNER JOIN [dbo].[LOGINVOICE] b ON a.INVOICECODE = b.INVOICECODE
			WHERE a.ACTIVESTATUS = '1'".$condBillinginvoice1.$condBillinginvoice2;
$params_seBillinginvoice2 = array();
$query_seBillinginvoice2 = sqlsrv_query($conn, $sql_seBillinginvoice2, $params_seBillinginvoice2);
while ($result_seBillinginvoice2 = sqlsrv_fetch_array($query_seBillinginvoice2, SQLSRV_FETCH_ASSOC)) {
    $tbody2 .= '<tr style="">
        <td style="border-right:1px solid #000;border-left:1px solid #000;padding:4px;text-align:center;" height="250px" valign="top">' . $i1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"valign="top">' . $result_seBillinginvoice2['INVOICECODE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"valign="top">' . $result_seBillinginvoice2['BILLINGDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"valign="top">' . $result_seBillinginvoice2['PAYMENTDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;"valign="top">' . number_format($price, 2) . '</td>
        <td style="border-right:1px solid #000;padding:4px;"valign="top"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;"valign="top">' . number_format($price, 2) . '</td>
      </tr>

';

    $i1++;
    $sumtotal = $sumtotal + $result_seBilling1['SUMTOTAL'];
}


$tfoot2 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td colspan="5" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;">' . convert(($price)) . '</td>
            <td style="border-right:1px solid #000;padding:4px;">รวมเงินทั้งสิ้น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format(($price), 2) . '</td>
      </tr>

       <tr style="">
        <td colspan="5" rowspan="2" style="border-right:1px solid #000;padding:4px;"></td>
        <td style="border-right:1px solid #000;padding:4px;">ภาษีหัก ณ ที่จ่าย 1 %</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format((($price) * 1) / 100, 2) . '</td>

      </tr>
       <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;">ยอดต้องชำระ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format(($price) - ((($price) * 1) / 100), 2) . '</td>
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
//////////////////////////////ใบแจ้งหนี้/ใบเสร็จรับเงิน//////////////////////////////////
$table_header1 = '<br><table width="100%" >
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
      <td colspan="8" style="text-align:center;font-size:24px"><b>ใบแจ้งหนี้/ใบเสร็จรับเงิน</b></td>
   </tr>

</tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;font-size:22px;">
    <tbody>
        <tr style="border:1px solid #000;" >
         <td style="border-right:1px solid #000;padding:4px;width:70%" rowspan="4">ลูกค้า : รหัส ด-007
								<br>บริษัท ไดกิ อลูมิเนียม อินดัสทรี (ประเทศไทย) จำกัด
								<br>สำนักงานใหญ่ ที่อยู่ 700/99 ม.1 ต.บ้านเก่า
								<br>อ.พานทอง จ.ชลบุรี 20160
								<br>โทร. 038-468441,038-458862-3
                <br>เลขประจำตัวผู้เสียภาษี 0105542046974
		      </td>
            <td style="border-right:1px solid #000;padding:4px;width:30%">เลขที่ : ' . $result_seBillinginvoice['INVOICECODE'] . '
            <br>วันที่ : ' . $result_seBillinginvoice['BILLINGDATE'] . '
            <br>เครดิต : 30 วัน
            <br>วันที่ครบกำหนด : ' . $result_seBillinginvoice['PAYMENTDATE'] . '
            </td>

       </tr>
    </tbody>
</table>';

$table_begin1 = '<br><table width="100%" style="border-collapse: collapse;margin-top:8px;font-size:20px">';
$thead1 = '<thead>

        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:60%"><b>รายการ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:30%"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
  </thead><tbody>';
$i2 = 1;
$sql_seBillinginvoice1 = "SELECT DISTINCT a.DUEDATE,a.COMPANYCODE,a.CUSTOMERCODE, a.BILLINGCODE, a.INVOICECODE, a.BILLINGDATE, a.PAYMENTDATE,a.PRPO1,a.TRIP1,a.PRPO2,a.TRIP2, a.SUMTOTAL, a.EXPRESSWAYAMT15, a.EXPRESSWAYAMT45, a.EXPRESSWAYAMT55, a.EXPRESSWAYAMT65, a.EXPRESSWAYAMT75, a.EXPRESSWAYAMT100, a.EXPRESSWAYAMT195, a.EXPRESSWAYAMT65RETURN, a.EXPRESSWAYAMT105RETURN, a.EXPRESSWAYPRICE15, a.EXPRESSWAYPRICE45, a.EXPRESSWAYPRICE55, a.EXPRESSWAYPRICE65, a.EXPRESSWAYPRICE75, a.EXPRESSWAYPRICE100, a.EXPRESSWAYPRICE195, a.EXPRESSWAYPRICE65RETURN, a.EXPRESSWAYPRICE105RETURN, a.ACTIVESTATUS, a.REMARK,b.EXPRESSWAYCODE FROM [dbo].[LOGBILLINGINVOICE] a
			INNER JOIN [dbo].[LOGINVOICE] b ON a.INVOICECODE = b.INVOICECODE
			WHERE a.ACTIVESTATUS = '1'".$condBillinginvoice1.$condBillinginvoice2;
$params_seBillinginvoice1 = array();
$query_seBillinginvoice1 = sqlsrv_query($conn, $sql_seBillinginvoice1, $params_seBillinginvoice1);
while ($result_seBillinginvoice1 = sqlsrv_fetch_array($query_seBillinginvoice1, SQLSRV_FETCH_ASSOC)) {
    $tbody1 .= '<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"  height="180px" valign="top">' . $i2 . '</td>
        <td style="border-right:1px solid #000;padding:4px;" valign="top">ค่าขนส่งสินค้าตามเอกสารแนบ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;" valign="top">' . number_format($price, 2) . '</td>
      </tr>
';

    $i2++;
    $sumtotal = $sumtotal + $result_seBillinginvoice1['SUMTOTAL'];
}

$tfoot1 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center">รวมเงิน</td>
            <td bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;">' . convert($price) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($price, 2) . '</td>
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
</table>
';




$mpdf->WriteHTML($style);
$mpdf->SetHTMLHeader($table_header2, 'O', true);
$mpdf->WriteHTML($table_begin2);
$mpdf->WriteHTML($thead2);
$mpdf->WriteHTML($tbody2);
$mpdf->WriteHTML($tfoot2);
$mpdf->WriteHTML($table_end2);
$mpdf->WriteHTML($table_footer2);
$mpdf->AddPage();
$mpdf->SetHTMLHeader($table_header1, 'O', true);
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
