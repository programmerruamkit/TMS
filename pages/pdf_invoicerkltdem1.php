<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
$sumgmtweight = "";
$sumcusweight = "";
$sumamounttrip = "";
$sumtotal = "";


$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);


$condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condBilling2 = "";

$sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBillings = array(
    array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN)
);
$query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
$result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);

$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,DULYDATE,INVOICECODE 
FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '".$_GET['invoicecode']."'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);




$sql_ChkJobend = "SELECT COMPANYCODE,CUSTOMERCODE,INVOICECODE,JOBEND,HOLIDAY,BILLINGPRPO 
FROM [dbo].[BILLING_HOLIDAY] 
WHERE INVOICECODE ='".$_GET['invoicecode']."'
AND COMPANYCODE='RKL' AND CUSTOMERCODE = 'TDEM' ";
$params_ChkJobend = array();
$query_ChkJobend = sqlsrv_query($conn, $sql_ChkJobend, $params_ChkJobend);
$result_ChkJobend = sqlsrv_fetch_array($query_ChkJobend, SQLSRV_FETCH_ASSOC);



if ($_GET['datebilling'] == '') {
  $datebilling1 = substr($result_getDate['SYSDATE'],2);
  $datebilling = "28".$datebilling1;
}else{
  $datebilling = $_GET['datebilling'];
}
//$invoicecode = create_invoice();

$mpdf = new mPDF('', 'Letter', '', '', 3, 22, 85, 5, 5, 10);
$style = '
<style>
	body{
		font-family: "angsana";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';

if ($result_ChkJobend['JOBEND'] == 'TDEM/SR(RKL)') {
    $table_header3 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="2" style="text-align:center;font-size:28px"><b>ใบส่งสินค้า</b></td>
    </thead>
    <tbody>
      <tr>
            <td colspan="2" style="font-size:20px">บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์ จำกัด (RUAMKIT RUNGRUENG LOGISTICS CO., LTD.)</td>
       </tr>
       <tr>
            <td colspan="2" style="font-size:20px">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง จังหวัดชลบุรี 20160</td>
       </tr>
       <tr>
            <td colspan="2" style="font-size:20px">โทรศัพท์ : 038-452824-5 โทรสาร : 038-210396</td>
       </tr>
       <tr>
             <td colspan="2" style="font-size:20px">เลขประจำตัวผู้เสียภาษี 0105552003135</td>
       </tr>
       <tr>
            <td colspan="2">&nbsp;</td>
       </tr>


      <tr>
            <td style="width: 70%;font-size:20px">ลูกค้า บริษัท โตโยต้า มอเตอร์ ประเทศไทย จำกัด</td>
            <td style="width: 25%;text-align:right;font-size:20px">เลขที่ ' . $result_seInvoicecode['INVOICECODE'] . '</td>
       </tr>
       <tr>
            <td style="width: 75%;font-size:20px">สาขาที่ 00010 ที่อยู่ 186/2 ม.1 ถ.ทางรถไฟเก่า ต.สำโรงใต้ อ.พระประแดง จ.สมุทรปราการ 10130 </td>
            <td style="width: 25%;text-align:right;font-size:20px">วันที่ ' . $result_seInvoicecode['DULYDATE'] . '</td>
       </tr>
       <tr>
            <td style="width: 70%;font-size:20px">เลขประจำตัวผู้เสียภาษี 0105505001679</td>
          
       </tr>
    </tbody>
</table>';
}else {
    $table_header3 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="2" style="text-align:center;font-size:28px"><b>ใบส่งสินค้าSR</b></td>
    </thead>
    <tbody>
      <tr>
            <td colspan="2" style="font-size:20px">บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์ จำกัด (RUAMKIT RUNGRUENG LOGISTICS CO., LTD.)</td>
       </tr>
       <tr>
            <td colspan="2" style="font-size:20px">สำนักงานสาขาที่ 1  เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง จังหวัดชลบุรี 20160</td>
       </tr>
       <tr>
            <td colspan="2" style="font-size:20px">โทรศัพท์ : 038-452824-5 โทรสาร : 038-210396</td>
       </tr>
       <tr>
             <td colspan="2" style="font-size:20px">เลขประจำตัวผู้เสียภาษี 0105552003135</td>
       </tr>
       <tr>
            <td colspan="2">&nbsp;</td>
       </tr>


      <tr>
            <td style="width: 70%;font-size:20px">ลูกค้า บริษัท โตโยต้า มอเตอร์ ประเทศไทย  จำกัด</td>
            <td style="width: 30%;text-align:right;font-size:20px">เลขที่ ' . $result_seInvoicecode['INVOICECODE'] . '</td>
       </tr>
       <tr>
            <td style="width: 70%;font-size:20px">สาขาที่ 00019 ที่อยู่  99 หมู่ 2 ต.ลาดขวาง อ.บ้านโพธิ์ จ.ฉะเชิงเทรา 24140</td>
            <td style="width: 25%;text-align:right;font-size:20px">วันที่ ' . $result_seInvoicecode['DULYDATE'] . ' เครดิต 30 วัน</td>
       </tr>
       <tr>
            <td style="width: 70%;font-size:20px">เลขประจำตัวผู้เสียภาษี 0105505001679</td>
       </tr>
    </tbody>
</table>';
}



$table_begin3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">';
$thead3 = '<thead>

        <tr style="border:1px solid #000;padding:4px;">

        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;font-size:18px"><b>ลำดับที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;font-size:18px"><b>วันที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;font-size:18px"><b>หมายเลข DO</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;font-size:18px"><b>ทะเบียนรถ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;font-size:18px"><b>พนักงาน</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 28%;font-size:18px"><b>จาก</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 25%;font-size:18px"><b>ถึง</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;font-size:18px"><b>QT.</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;font-size:18px"><b>ราคา</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;font-size:18px"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
    </thead><tbody>';

$i = 1;
// $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
// $params_seBilling = array(
//     array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
//     array($condBilling1, SQLSRV_PARAM_IN),
//     array($condBilling2, SQLSRV_PARAM_IN)
// );
$sql_seBilling = "SELECT CONVERT(VARCHAR(30), a.DATEVLIN, 103)  AS 'DATE_VLIN',b.DOCUMENTCODE AS 'DOCUMENTCODE',
          a.THAINAME AS 'THAINAME',a.EMPLOYEENAME1 AS 'EMPLOYEENAME1',a.JOBSTART AS 'JOBSTART',a.JOBEND AS 'JOBEND',c.PRICE AS 'ACTUALPRICE',
          [STATUS],STATUSNUMBER
          FROM  [dbo].[VEHICLETRANSPORTPLAN] a
          INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
          INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.[VEHICLETRANSPORTPRICEID] = b.[VEHICLETRANSPORTPRICEID]
          WHERE 1 = 1
          AND a.COMPANYCODE ='RKL' AND a.CUSTOMERCODE ='TDEM'
          --AND b.DOCUMENTCODE = '" . $result_ChkJobend['BILLINGPRPO'] . "'
          AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103)
          ORDER BY a.DATEVLIN ASC";
$params_seBilling = array();
$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

     if ($result_seBilling['STATUSNUMBER'] == 'X') {
          $PRICE = $result_seBilling['ACTUALPRICE']/2;
       
     }else{
          $PRICE = $result_seBilling['ACTUALPRICE']; 
     
     }


    $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "' ";
    $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmployeeehr = array(
        array('select_employeeehr2', SQLSRV_PARAM_IN),
        array($condEmployeeehr1, SQLSRV_PARAM_IN)
    );
    $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
    $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);

    $sql_seHoliday = " SELECT HOLIDAY AS 'DATE' FROM [dbo].[BILLING_HOLIDAY] WHERE INVOICECODE ='".$result_seInvoicecode['INVOICECODE']."'
    AND COMPANYCODE='RKL' AND CUSTOMERCODE = 'TDEM' AND JOBEND = '" . $result_ChkJobend['JOBEND'] . "'";
    $params_seHoliday = array();
    $query_seHoliday = sqlsrv_query($conn, $sql_seHoliday, $params_seHoliday);
    $result_seHoliday = sqlsrv_fetch_array($query_seHoliday, SQLSRV_FETCH_ASSOC);


    $holiday = $result_seHoliday['DATE'];
    // $holiday = $result_seHoliday['DATE'];
    $holidaysplit = explode(",", $holiday);

    if (($result_seBilling['DATE_VLIN'] == $holidaysplit[0]) || ($result_seBilling['DATE_VLIN'] == $holidaysplit[1]) || ($result_seBilling['DATE_VLIN'] == $holidaysplit[2]) || ($result_seBilling['DATE_VLIN'] == $holidaysplit[3]) || ($result_seBilling['DATE_VLIN'] == $holidaysplit[4])) {
      $tbody3 .= '
      <tr style="border:1px solid #000;font-size:30px">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:30px">' . $i . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:30px">' . $result_seBilling['DATE_VLIN'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:30px">' . substr($result_seBilling['DOCUMENTCODE'],0,13) . ' <br> ' . substr($result_seBilling['DOCUMENTCODE'],13,26) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:30px">' . $result_seBilling['THAINAME'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:30px">' . $result_seEmployeeehr['FnameT'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:30px">' . $result_seBilling['JOBSTART'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:30px">' . $result_seBilling['JOBEND'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:30px">1.00</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:30px">' . number_format($PRICE, 2) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:30px">' . number_format($PRICE, 2) . '</td>
      </tr>
        <tr style="border:1px solid #000;">
          <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:30px"></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:30px">' . $result_seBilling['DATE_VLIN'] . '</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:30px">Holiday</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:30px">' . $result_seBilling['THAINAME'] . '</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:30px">' . $result_seEmployeeehr['FnameT'] . '</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:30px">' . $result_seBilling['JOBSTART'] . '</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:30px">' . $result_seBilling['JOBEND'] . '</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:30px">1.00</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:30px">1,000.00</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:30px">1,000.00</td>
        </tr>
      ';
      $i++;
      $count ++ ;
      $sumtotalholiday = ($count * 1000);
      $sumtotal1 = $sumtotal1 + $PRICE;

    }else {
      $tbody3 .= '

          <tr style="border:1px solid #000;">
          <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:20px">' . $i . '</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:20px">' . $result_seBilling['DATE_VLIN'] . '</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:20px">' . substr($result_seBilling['DOCUMENTCODE'],0,13) . ' <br> ' . substr($result_seBilling['DOCUMENTCODE'],13,26) . '</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:20px">' . $result_seBilling['THAINAME'] . '</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:20px">' . $result_seEmployeeehr['FnameT'] . '</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:20px">' . $result_seBilling['JOBSTART'] . '</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:20px">' . $result_seBilling['JOBEND'] . '</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:20px">1.00</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:20px">' . number_format($PRICE, 2) . '</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:20px">' . number_format($PRICE, 2) . '</td>
        </tr>
      ';
      $i++;
      $sumtotal2 = $sumtotal2 + $PRICE;
    }

  }////end while




$tfoot3 = '</tbody><tfoot>
     <tr style="border:1px solid #000;">
        <td colspan="8" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:20px">' .  convert($sumtotal1+$sumtotal2+$sumtotalholiday) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:20px">รวมสุทธิ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:20px">' . number_format($sumtotal1+$sumtotal2+$sumtotalholiday, 2) . '</td>

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
