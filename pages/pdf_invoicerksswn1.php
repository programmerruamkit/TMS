<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
$sumgmtweight = "";
$sumcusweight = "";
$sumamounttrip = "";
$sumtotal = "";
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $date_now = "";
} else {
    $date_now = $_GET['datestart'] . ' ถึง ' . $_GET['dateend'];
}
$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);


$condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condBilling2 = " AND c.COMPANYCODE ='RKS' AND c.CUSTOMERCODE ='SWN' ";

$sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBillings = array(
    array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN)
);
$query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
$result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);

$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,DULYDATE,INVOICECODE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '".$_GET['invoicecode']."'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);

if ($result_seBillings['VEHICLETYPE'] == '10W(Van) (2 Trips/Trailer/Day)') {
  $vehicletype = '10 ล้อ';
}else if ($result_seBillings['VEHICLETYPE'] == '10W(Van) (1 Trips/Trailer/Day)') {
  $vehicletype = '10 ล้อ';
}else {
  $vehicletype = '6 ล้อ';
}


//$invoicecode = create_invoice();

$mpdf = new mPDF('', 'Letter', '', '', 6, 20, 55, 5, 5, 10);
$style = '
<style>
	body{
		font-family: "angsana";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';



$table_header3 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="2" style="text-align:center;font-size:28px"><b>ใบส่งสินค้า</b></td>
    </thead>
    <tbody>
      <tr>
            <td colspan="2" style="font-size:22px">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO., LTD.)</td>
       </tr>
       <tr>
            <td colspan="2" style="font-size:22px">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง จังหวัดชลบุรี 20160 โทรศัพท์ : 038-452824-5 โทรสาร : 038-210396</td>
       </tr>
       <tr>
            <td colspan="2" style="font-size:22px">เลขประจำตัวผู้เสียภาษี  0105544064899</td>
       </tr>
       <tr>
            <td colspan="2">&nbsp;</td>
       </tr>


       <tr>
       <td style="width: 50%;font-size:22px">ลูกค้า บริษัท สยามวัฒนา เวสต์ แมนเน็จเม้นท์ จำกัด </td>
       <td style="width: 50%;text-align:right;font-size:22px">เลขที่ ' . $result_seInvoicecode['INVOICECODE'] . '</td>
        </tr>
        <tr>
            <td style="width: 75%;font-size:22px">สำนักงานใหญ่ ที่อยู่ 22/1 หมู่ 6 ตำบลหนองบอนแดง อำเภอบ้านบึง จังหวัดชลบุรี 20170</td>
            <td style="width: 25%;text-align:right;font-size:22px">วันที่ ' . $result_seInvoicecode['DULYDATE'] . '</td>
        </tr>
    </tbody>
</table>';

$table_begin3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead3 = '<thead>

        <tr style="border:1px solid #000;padding:6px;">

        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 10%;"><font style="font-size: 24px"><b>ลำดับ</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 15%;"><font style="font-size: 24px"><b>วันที่</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 15%;"><font style="font-size: 24px"><b>หมายเลข DO</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 12%;"><font style="font-size: 24px"><b>ประเภทรถ</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 12%;"><font style="font-size: 24px"><b>ทะเบียนรถ</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 15%;"><font style="font-size: 24px"><b>พนักงาน</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 28%;"><font style="font-size: 24px"><b>จาก</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 30%;"><font style="font-size: 24px"><b>ถึง</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 10%;"><font style="font-size: 24px"><b>QT.</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 12%;"><font style="font-size: 24px"><b>ราคา</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 15%;"><font style="font-size: 24px"><b>จำนวนเงิน</b></font></td>
      </tr>
    </thead><tbody>';

$i = 1;
$sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBilling = array(
    array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN)
);



$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
    $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "' ";
    $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmployeeehr = array(
        array('select_employeeehr2', SQLSRV_PARAM_IN),
        array($condEmployeeehr1, SQLSRV_PARAM_IN)
    );
    $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
    $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);



    $sql_seHoliday = " SELECT HOLIDAY AS 'DATE' FROM [dbo].[BILLING_HOLIDAY] WHERE INVOICECODE ='".$result_seInvoicecode['INVOICECODE']."'
    AND COMPANYCODE='RKS' AND CUSTOMERCODE = 'SWN'";
    $params_seHoliday = array();
    $query_seHoliday = sqlsrv_query($conn, $sql_seHoliday, $params_seHoliday);
    $result_seHoliday = sqlsrv_fetch_array($query_seHoliday, SQLSRV_FETCH_ASSOC);


    $holiday = $result_seHoliday['DATE'];
    // $holiday = $result_seHoliday['DATE'];
    $holidaysplit = explode(",", $holiday);

    if (($result_seBilling['DATE_VLIN'] == $holidaysplit[0]) || ($result_seBilling['DATE_VLIN'] == $holidaysplit[1]) || ($result_seBilling['DATE_VLIN'] == $holidaysplit[2]) || ($result_seBilling['DATE_VLIN'] == $holidaysplit[3]) || ($result_seBilling['DATE_VLIN'] == $holidaysplit[4])) {
      $tbody3 .= '
          

      <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $i . '</font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['DATE_VLIN'] . '</font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' .  $vehicletype . '</font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['THAINAME'] . '</font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seEmployeeehr['FnameT'] . '</font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . ($result_seBilling['JOBSTART'] == 'SWN (Ban Bueng) (Return)' ? 'SWN (Ban Bueng)' :$result_seBilling['JOBSTART']). '</font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['JOBEND'] . '</font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">1.00</font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">' . number_format($result_seBilling['PRICE'], 2) . '</font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">' . number_format($result_seBilling['PRICE'], 2) . '</font></td>
      </tr>
        <tr style="border:1px solid #000;">
          <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"></td>
          <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['DATE_VLIN'] . '</font></td>
          <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"></td>
          <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' .  $vehicletype . '</font></td>
          <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['THAINAME'] . '</font></td>
          <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seEmployeeehr['FnameT'] . '</font></td>
          <td colspan="2" style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">Holiday</font></td>
          <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">1.00</font></td>
          <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">1,000.00</font></td>
          <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">1,000.00</font></td>
        </tr>
      ';
      $i++;
      $count ++ ;
      $sumtotalholiday = ($count * 1000);
      $sumtotal1 = $sumtotal1 + $result_seBilling['PRICE'];

    }else if ($result_seBilling['JOBSTART'] =='SWN (Ban Bueng) (Return)'){
        $tbody3 .= '
  
            <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px">' . $i . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px">' . $result_seBilling['DATE_VLIN'] . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">ตีรถไปรับ<br>ถังเปล่าคิด 50%</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' .  $vehicletype . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px">' . $result_seBilling['THAINAME'] . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px">' . $result_seEmployeeehr['FnameT'] . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px">' . ($result_seBilling['JOBSTART'] == 'SWN (Ban Bueng) (Return)' ? 'SWN (Ban Bueng)' : $result_seBilling['JOBSTART']). '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px">' . $result_seBilling['JOBEND'] . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">1.00</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">' . number_format($result_seBilling['PRICE'], 2) . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">' . number_format($result_seBilling['PRICE'], 2) . '</font></td>
          </tr>
        ';
        $i++;
        $sumtotal2 = $sumtotal2 + $result_seBilling['PRICE'];
    }else {
    $tbody3 .= '

        <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px">' . $i . '</font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px">' . $result_seBilling['DATE_VLIN'] . '</font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' .  $vehicletype . '</font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px">' . $result_seBilling['THAINAME'] . '</font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px">' . $result_seEmployeeehr['FnameT'] . '</font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px">' . ($result_seBilling['JOBSTART'] == 'SWN (Ban Bueng) (Return)' ? 'SWN (Ban Bueng)' : $result_seBilling['JOBSTART']). '</font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px">' . $result_seBilling['JOBEND'] . '</font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">1.00</font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">' . number_format($result_seBilling['PRICE'], 2) . '</font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">' . number_format($result_seBilling['PRICE'], 2) . '</font></td>
    </tr>
    ';
    $i++;
    $sumtotal2 = $sumtotal2 + $result_seBilling['PRICE'];
}

  }////end while




$tfoot3 = '</tbody><tfoot>
     <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><b>ยอดรวมสุทธิ</b></font></td>
        <td colspan="8" style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><b>' .  convert($sumtotal1+$sumtotal2+$sumtotalholiday) . '</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px"><b>' . number_format($sumtotal1+$sumtotal2+$sumtotalholiday, 2) . '</b></font></td>

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
