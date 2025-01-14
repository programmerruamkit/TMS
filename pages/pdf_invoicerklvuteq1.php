<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");


$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,INVOICECODE 
                      FROM [dbo].[LOGINVOICE] 
                      WHERE INVOICECODE = '".$_GET['invoicecode']."'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);

$date = substr($result_seInvoicecode['BILLINGDATE'],3,10);





$condduedate1 = " AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
$condduedate2 = "";
$sql_seduedate = "{call megLoginvoice_v2(?,?,?)}";
$params_seduedate = array(
    array('select_duedate', SQLSRV_PARAM_IN),
    array($condduedate1, SQLSRV_PARAM_IN),
    array($condduedate2, SQLSRV_PARAM_IN)
);
$query_seduedate = sqlsrv_query($conn, $sql_seduedate, $params_seduedate);
$result_seduedate = sqlsrv_fetch_array($query_seduedate, SQLSRV_FETCH_ASSOC);

//$invoicecode = create_invoice();

// $mpdf = new mPDF('th', 'A4', '0', '');
$mpdf = new mPDF('', 'Letter', '', '', 5, 10, 90, 5, 5, 10);
$style = '
<style>
	body{
		font-family: "angsana";font-size:12px//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';




$table_header3 = '<table style="width: 110%;">
    <thead>
        <tr>
            <td colspan="70" style="text-align:center;font-size:28px"><b>ใบส่งสินค้า</b></td>
        </tr>

    </thead>

    <tbody><br><br><br>
        <tr>
            <td colspan="48" style="width: 70%;font-size:22px">บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์ จำกัด (RUAMKIT RUNGRUENG LOGISTICS CO.,LTD.)</td>
       </tr>
       <tr>
            <td colspan="60" style="font-size:22px">สำนักงานใหญ่ เลขที่ 51 ม.4 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160 โทรศัพท์ : (038) 452824-5 โทรสาร : (038) 210396</td>
       </tr>
       <tr>
            <td colspan="48" style="font-size:22px">เลขประจำตัวผู้เสียภาษี : 0105552003135</td>
       </tr>
       <tr>
            <td colspan="48">&nbsp;</td>
       </tr>

       <tr>
            <td colspan="45" style="text-align:left;font-size:22px">ลูกค้า บริษัท วูเทคไทย จำกัด (สำนักงานใหญ่)</td>
            <td colspan="20" style="text-align:right;font-size:22px">เลขที่ ' . $result_seInvoicecode['INVOICECODE'] . '</td>
       </tr>
       <tr>
            <td colspan="45" style="text-align:left;font-size:22px">ที่อยู่ 700/66 หมู่ที่.6 ต.หนองไม้แดง <br> อ.เมืองชลบุรี  จ.ชลบุรี 20000</td>
            <td colspan="20" style="text-align:right;font-size:22px">วันที่ ' . $result_seduedate['DUEDATE'] . '</td>
       </tr>
       <tr>
            <td colspan="45" style="font-size:22px">เลขประจำตัวผู้เสียภาษี 0105538003891</td>
       </tr>
       
    </tbody>
</table>';

$table_begin3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead3 = '<thead>

        <tr  style="border:1px solid #000;padding:14px;">
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;width: 10%;font-size:50px"><b>ลำดับ</b></td>
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;width: 25%;font-size:50px"><b>วันที่</b></td>
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;width: 30%;font-size:50px"><b>หมายเลข PO</b></td>
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;width: 25%;font-size:50px"><b>ทะเบียนรถ</b></td>
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;width: 25%;font-size:50px"><b>ประเภทรถ</b></td>
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;width: 25%;font-size:50px"><b>พนักงาน</b></td>
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;width: 63%;font-size:50px"><b>จาก</b></td>
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;width: 45%;font-size:50px"><b>ถึง</b></td>
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;width: 15%;font-size:50px"><b>QT.</b></td>
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;width: 25%;font-size:50px"><b>หน่วยละ</b></td>
        <td   style="border-right:1px solid #000;padding:14px;text-align:center;width: 35%;font-size:50px"><b>จำนวนเงิน</b></td>
      </tr>
    </thead><tbody>';

$i = 1;
$count = 0 ;

$condBilling1 = " AND c.COMPANYCODE = 'RKL' AND c.CUSTOMERCODE = 'VUTEQ'";
$condBilling2 = "";
$sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBilling = array(
    array('select_pdfvehicletransportdocumentdriver-tgt', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN)
);



$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
   
    $condEmployeeehr1 = " AND a.PersonCode = '" . $result_seBilling['EMPLOYEECODE1'] . "' ";
    $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmployeeehr = array(
        array('select_employeeehr2', SQLSRV_PARAM_IN),
        array($condEmployeeehr1, SQLSRV_PARAM_IN)
    );
    $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
    $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);


    $sql_seHoliday = "SELECT  HOLIDAY AS 'DATE',COMPANYCODE,CUSTOMERCODE,INVOICECODE,JOBEND,BILLINGPRPO 
                        FROM [dbo].[BILLING_HOLIDAY] 
                        WHERE INVOICECODE ='".$result_seInvoicecode['INVOICECODE']."'
                        AND COMPANYCODE='RKL' AND CUSTOMERCODE = 'VUTEQ' AND JOBEND = 'RKLVUTEQ'";
    $params_seHoliday = array();
    $query_seHoliday = sqlsrv_query($conn, $sql_seHoliday, $params_seHoliday);
    $result_seHoliday = sqlsrv_fetch_array($query_seHoliday, SQLSRV_FETCH_ASSOC);


    $holiday = $result_seHoliday['DATE'];
    // $holiday = $result_seHoliday['DATE'];
    $holidaysplit = explode(",", $holiday);


      if (($result_seBilling['DATEVLIN_103'] == $holidaysplit[0]) || ($result_seBilling['DATEVLIN_103'] == $holidaysplit[1]) || ($result_seBilling['DATEVLIN_103'] == $holidaysplit[2]) || ($result_seBilling['DATEVLIN_103'] == $holidaysplit[3]) || ($result_seBilling['DATEVLIN_103'] == $holidaysplit[4])) {
        $tbody3 .= '

        <tr style="border:1px solid #000;padding:17px;">
        <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 20%;font-size:48px">' . $i . '</td>
        <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 25%;font-size:48px">' . $result_seBilling['DATEVLIN_103'] . '</td>
        <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 30%;font-size:48px">' . $result_seBilling['DOCUMENTCODE'] . '</td>
        <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 25%;font-size:48px">' . $result_seBilling['THAINAME'] . '</td>
        <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 25%;font-size:48px">เทรลเลอร์</td>
        <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 25%;font-size:48px">' . $result_seEmployeeehr['FnameT'] . '</td>
        <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 63%;font-size:48px">' . $result_seBilling['JOBSTART'] . '</td>
        <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 60%;font-size:48px">' . $result_seBilling['JOBEND'] . '</td>
        <td style="border-right:1px solid #000;padding:17px;text-align:right;width: 15%;font-size:48px">1.00</td>
        <td style="border-right:1px solid #000;padding:17px;text-align:right;width: 25%;font-size:48px">' . number_format($result_seBilling['PRICE'], 2) . '</td>
        <td style="border-right:1px solid #000;padding:17px;text-align:right;width: 35%;font-size:48px">' . number_format($result_seBilling['PRICE'], 2) . '</td>
      </tr>
      <tr style="border:1px solid #000;padding:17px;">
          <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 20%;font-size:48px"></td>
          <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 25%;font-size:48px">' . $result_seBilling['DATEVLIN_103'] . '</td>
          <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 30%;font-size:48px">' . $result_seBilling['DOCUMENTCODE'] . '</td>
          <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 25%;font-size:48px">' . $result_seBilling['THAINAME'] . '</td>
          <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 25%;font-size:48px">เทรลเลอร์</td>
          <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 25%;font-size:48px">' . $result_seEmployeeehr['FnameT'] . '</td>
          <td colspan="2" style="border-right:1px solid #000;padding:17px;text-align:center;width: 45%;font-size:48px">Holiday</td>
          <td style="border-right:1px solid #000;padding:17px;text-align:right;width: 15%;font-size:48px">1.00</td>
          <td style="border-right:1px solid #000;padding:17px;text-align:right;width: 25%;font-size:48px">1000</td>
          <td style="border-right:1px solid #000;padding:17px;text-align:right;width: 35%;font-size:48px">1000</td>
    </tr>

        ';

        $i++;
        $count ++ ;
        $sumtotalholiday = ($count * 1000);
        $sumtotal1 = $sumtotal1 + $result_seBilling['PRICE'];
      }else {
        $tbody3 .= '

          <tr style="border:1px solid #000;padding:17px;">
            <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 20%;font-size:48px">' . $i . '</td>
            <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 25%;font-size:48px">' . $result_seBilling['DATEVLIN_103'] . '</td>
            <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 30%;font-size:48px">' . $result_seBilling['DOCUMENTCODE'] . '</td>
            <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 25%;font-size:48px">' . $result_seBilling['THAINAME'] . '</td>
            <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 25%;font-size:48px">เทรลเลอร์</td>
            <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 25%;font-size:48px">' . $result_seEmployeeehr['FnameT'] . '</td>
            <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 63%;font-size:48px">' . $result_seBilling['JOBSTART'] . '</td>
            <td style="border-right:1px solid #000;padding:17px;text-align:center;width: 60%;font-size:48px">' . $result_seBilling['JOBEND'] . '</td>
            <td style="border-right:1px solid #000;padding:17px;text-align:right;width: 15%;font-size:48px">1.00</td>
            <td style="border-right:1px solid #000;padding:17px;text-align:right;width: 25%;font-size:48px">' . number_format($result_seBilling['PRICE'], 2) . '</td>
            <td style="border-right:1px solid #000;padding:17px;text-align:right;width: 35%;font-size:48px">' . number_format($result_seBilling['PRICE'], 2) . '</td>
          </tr>

        ';

        $i++;
        $sumtotal2 = $sumtotal2 + $result_seBilling['PRICE'];
      }





}///main while




$tfoot3 = '</tbody><tfoot>
     <tr style="border:1px solid #000;">
        <td  colspan="1" style="border-right:1px solid #000;padding:11px;text-align:center;font-size:46px"><b>รวมสุทธิ</td>

        <td  colspan="9" style="border-right:1px solid #000;padding:11px;text-align:center;font-size:46px"><b>' . convert($sumtotal1+$sumtotal2+$sumtotalholiday) . '</td>

        <td  colspan="1" style="border-right:1px solid #000;padding:11px;text-align:right;font-size:46px"><b>' . number_format($sumtotal1+$sumtotal2+$sumtotalholiday, 2) . '</td>

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

// $mpdf->WriteHTML($table_header3);
$mpdf->WriteHTML($table_begin3);
$mpdf->WriteHTML($thead3);
$mpdf->WriteHTML($tbody3);
$mpdf->WriteHTML($tfoot3);
$mpdf->WriteHTML($table_end3);
$mpdf->WriteHTML($table_footer3);
// $mpdf->SetHTMLFooter($table_footer3);
$mpdf->Output();


sqlsrv_close($conn);
?>
