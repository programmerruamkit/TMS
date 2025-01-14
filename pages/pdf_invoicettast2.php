

<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");


$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);



$mpdf = new mPDF('', 'Letter', '', '', 10, 10, 60, 5, 5, 5);
$style = '
<style>
	body{
		font-family: "Garuda";font-size:12px//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';

$table_header2 = '<table style="width: 100%;">
    <thead>
    </thead>
    <tbody>
        <tr>
            <td colspan="2">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด</td>
       </tr>
       <tr>
            <td colspan="2">109/1 หมู่ที่ 9 ตำบลหัวสำโรง อำเภอแปลงยาว จังหวัดฉะเชิงเทรา</td>
       </tr>
       <tr>
            <td colspan="2" style="text-align:right">ใบวางบิล/ใบแจ้งหนี้</td>
       </tr>
       <tr>
            <td colspan="2">&nbsp;</td>
       </tr>
       <tr>
            <td style="width: 50%;">&nbsp;</td>
            <td style="width: 50%;text-align:right">เลขที่วางบิล ' . $_GET['billingcode'] . '</td>
       </tr>
     
        <tr>
            <td style="width: 50%;">ลูกค้า บริษัท ทีที ออโตโมทีฟ สตีล (ไทยแลนด์) จำกัด</td>
            <td style="width: 50%;text-align:right">วันที่ ' . $result_getDate['SYSDATE'] . '</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;">ที่อยู่ 256 หมู่ที่ 7 นิคมอุตสาหกรรมเกตเวย์ซิตี้ ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;">ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190</td>
       </tr>
        <tr>
            <td style="width: 50%;text-align:center">หมายเหตุ</td>
          <td style="width: 50%;text-align:center">เงื่อนไขการชำระเงิน</td>
      </tr>
      <tr>
            <td style="width: 50%;text-align:center">&nbsp;</td>
         
      </tr>
       <tr>
            <td style="width: 50%;text-align:center">&nbsp;</td>
         
      </tr>
    </tbody>
</table>';

$table_begin2 = '<table width="100%" ><tr><td style="height:570px;padding-top:-520px"><table id="bg-table" width="100%"  style="border-collapse: collapse;font-size:10;margin-top:8px;">';
$thead2 = '<thead>
 
        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;"><b>No.</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 25%;"><b>เลขที่ใบกำกับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;"><b>วันที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;"><b>ครบกำหนด</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>จำนวนเงิน</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ชำระแล้ว</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>เงินคงค้าง</b></td>
        
      </tr>
  </thead><tbody>';
$i1 = 1;
$condBilling11 = " AND a.BILLINGCODE = '" . $_GET['billingcode'] . "'";
$condBilling12 = "";
$sql_seBilling1 = "{call megLogbillinginvoice_v2(?,?,?)}";
$params_seBilling1 = array(
    array('select_logbillinginvoice', SQLSRV_PARAM_IN),
    array($condBilling11, SQLSRV_PARAM_IN),
    array($condBilling12, SQLSRV_PARAM_IN)
);
$query_seBilling1 = sqlsrv_query($conn, $sql_seBilling1, $params_seBilling1);
while ($result_seBilling1 = sqlsrv_fetch_array($query_seBilling1, SQLSRV_FETCH_ASSOC)) {
    $tbody2 .= '<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $i1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling1['INVOICECODE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling1['BILLINGDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling1['PAYMENTDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seBilling1['SUMTOTAL']) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seBilling1['SUMTOTAL']) . '</td>
      </tr>';

    $i1++;
    $SUMTOTAL = SUMTOTAL + $result_seBilling1['SUMTOTAL'];
}

$tfoot2 = '</tbody><tfoot><tr style="border:1px solid #000;">
        <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:left;">' . convert($SUMTOTAL) . '</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">รวมเงินทั้งสิ้น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($SUMTOTAL) . '</td>
      </tr>
    </tfoot>';

$table_end2 = '</table></td></tr></table>';

$table_footer2 = '<table style="width: 100%;">

    <tbody>
       
     
       <tr>
            <td style="width: 50%;">ชื่อผู้รับวางบิล........................................</td>
            <td style="width: 50%;">ในนาม บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด</td>
       </tr>
       <tr>
            <td style="width: 50%;">วันที่รับ........../........../..........</td>
            <td style="width: 50%;">&nbsp;</td>
       </tr>
       <tr>
            <td style="width: 50%;">วันที่รับชำระ........../........../..........</td>
            <td style="width: 50%;">ชื่อผู้รับเงิน........................................</td>
       </tr>
    </tbody>
</table>';


$table_header1 = '<table style="width: 100%;">
    <thead>
    </thead>
    <tbody>
        <tr>
            <td colspan="2">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด</td>
       </tr>
       <tr>
            <td colspan="2">109/1 หมู่ที่ 9 ตำบลหัวสำโรง อำเภอแปลงยาว จังหวัดฉะเชิงเทรา</td>
       </tr>
       <tr>
            <td colspan="2" style="text-align:right">ใบเสร็จรับเงิน</td>
       </tr>
       <tr>
            <td colspan="2">&nbsp;</td>
       </tr>
       <tr>
            <td style="width: 50%;">&nbsp;</td>
            <td style="width: 50%;text-align:right">เลขที่วางบิล RE' . $invoicecode . '</td>
       </tr>
        <tr>
            <td style="width: 50%;">ลูกค้า บริษัท ทีที ออโตโมทีฟ สตีล (ไทยแลนด์) จำกัด</td>
            <td style="width: 50%;text-align:right">วันที่ ' . $result_getDate['SYSDATE'] . '</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;">ที่อยู่ 256 หมู่ที่ 7 นิคมอุตสาหกรรมเกตเวย์ซิตี้ ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;">ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190</td>
       </tr>
        <tr>
            <td style="width: 50%;text-align:center">หมายเหตุ</td>
          <td style="width: 50%;text-align:center">เงื่อนไขการชำระเงิน</td>
      </tr>
       <tr>
            <td style="width: 50%;text-align:center">&nbsp;</td>
         
      </tr>
    </tbody>
</table>';

$table_begin1 = '<table width="100%" ><tr><td style="height:510px;padding-top:-460px"><table id="bg-table" width="100%"  style="border-collapse: collapse;font-size:10;margin-top:8px;">';
$thead1 = '<thead>
 
        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;"><b>No.</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 25%;"><b>เลขที่ใบกำกับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;"><b>วันที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;"><b>ครบกำหนด</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>จำนวนเงิน</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ชำระแล้ว</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>เงินคงค้าง</b></td>
        
      </tr>
  </thead><tbody>';
$i2 = 1;
$condBilling21 = " AND a.BILLINGCODE = '" . $_GET['billingcode'] . "'";
$condBilling22 = "";
$sql_seBilling2 = "{call megLogbillinginvoice_v2(?,?,?)}";
$params_seBilling2 = array(
    array('select_logbillinginvoice', SQLSRV_PARAM_IN),
    array($condBilling21, SQLSRV_PARAM_IN),
    array($condBilling22, SQLSRV_PARAM_IN)
);
$query_seBilling2 = sqlsrv_query($conn, $sql_seBilling2, $params_seBilling2);
while ($result_seBilling2 = sqlsrv_fetch_array($query_seBilling2, SQLSRV_FETCH_ASSOC)) {
    $tbody1 = '<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $i2 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling2['INVOICECODE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling2['BILLINGDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling2['PAYMENTDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seBilling2['SUMTOTAL']) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seBilling2['SUMTOTAL']) . '</td>
      </tr>';
          $i2++;
          $SUMTOTAL = SUMTOTAL + $result_seBilling2['SUMTOTAL'];
}

$tfoot1 = '</tbody><tfoot><tr style="border:1px solid #000;">
        <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:left;">' . convert($SUMTOTAL) . '</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">รวมเงินทั้งสิ้น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($SUMTOTAL) . '</td>
      </tr>
    </tfoot>';

$table_end1 = '</table></td></tr></table>';

$table_footer1 = '<table style="width: 100%;">
    
    <tbody>
   
   
      
      
       <tr>
            <td colspan="8">ในการรับเงินด้วยเช็คจะสมบูรณ์เมื่อบริษัทได้รับเงินตามเช็คเรียบร้อย</td>
       </tr>
       <tr>
            <td colspan="8">เงินสด..................................................</td>
            
       </tr>
       <tr>
            <td style="width: 10%;text-align:center;">เช็คธนาคาร</td>
            <td style="width: 15%;">.............................</td>
            <td style="width: 10%;text-align:center;">เช็คเลขที่</td>
            <td style="width: 15%;">.............................</td>
            <td style="width: 10%;text-align:center;">ลงวันที่</td>
            <td style="width: 15%;">.............................</td>
            <td style="width: 10%;text-align:center;">จำนวนเงิน</td>
            <td style="width: 15%;">.............................</td>
       </tr>
       <tr>
            <td style="width: 10%;text-align:center;">โอนเงินผ่านธนาคาร</td>
            <td style="width: 15%;">.............................</td>
            <td style="width: 10%;text-align:center;">สาขา</td>
            <td style="width: 15%;">.............................</td>
            <td style="width: 10%;text-align:center;">ลงวันที่</td>
            <td style="width: 15%;">.............................</td>
            <td style="width: 10%;text-align:center;">จำนวนเงิน</td>
            <td style="width: 15%;">.............................</td>
       </tr>
       <tr>
            <td colspan="4"></td>
            <td colspan="4">ในนาม บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด</td>
       </tr>
       <tr>
            <td colspan="8">&nbsp;</td>
       </tr>
       <tr>
            <td colspan="8">&nbsp;</td>
       </tr>
       <tr>
            <td style="width: 10%;text-align:center;" >ผู้รับเงิน</td>
            <td style="width: 15%;">.............................</td>
            <td style="width: 10%;text-align:center;">วันที่</td>
            <td style="width: 15%;">.............................</td>
            <td stype="text-align:center;">ผู้รับมอบอำนาจ</td>
            <td colspan="3">.............................</td>
           
       </tr>
    </tbody>
</table>';




$mpdf->WriteHTML($style);
$mpdf->SetHTMLHeader($table_header2, 'O', true);
$mpdf->WriteHTML($table_begin2);
$mpdf->WriteHTML($thead2);
$mpdf->WriteHTML($tbody2);
$mpdf->WriteHTML($tfoot2);
$mpdf->WriteHTML($table_end2);
$mpdf->SetHTMLFooter($table_footer2);
$mpdf->AddPage();
$mpdf->SetHTMLHeader($table_header1, 'O', true);
$mpdf->WriteHTML($table_begin1);
$mpdf->WriteHTML($thead1);
$mpdf->WriteHTML($tbody1);
$mpdf->WriteHTML($tfoot1);
$mpdf->WriteHTML($table_end1);
$mpdf->SetHTMLFooter($table_footer1);

$mpdf->Output();



sqlsrv_close($conn);
?>

