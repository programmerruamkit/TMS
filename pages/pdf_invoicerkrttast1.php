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
$condBilling2 = "";

$sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBillings = array(
    array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN)
);
$query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
$result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);

$condInvoice1 = " AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
$condInvoice2 = "";
$sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
$params_seInvoice = array(
    array('select_loginvoice', SQLSRV_PARAM_IN),
    array($condInvoice1, SQLSRV_PARAM_IN),
    array($condInvoice2, SQLSRV_PARAM_IN)
);
$query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
$result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC);


//$invoicecode = create_invoice();

$mpdf = new mPDF('th', 'A4', '0', '');
$style = '
<style>
	body{
		font-family: "angsana";font-size:16px//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';



$table_header3 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="2" style="text-align:center;font-size:28px"><b>ใบส่งสินค้า</b></td>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" style="width: 100%;font-size:24px">บริษัท ร่วมกิจรุ่งเรือง (1993) จำกัด (RUAMKIT RUNGRUENG (1993) CO., LTD.)</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 100%;font-size:22px">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง จังหวัดชลบุรี 20160  โทรศัพท์ : 038-452824-5 โทรสาร : 038-210396</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;font-size:22px">เลขประจำตัวผู้เสียภาษี  0105536076131</td>
       </tr>


       <tr>
            <td colspan="2">&nbsp;</td>
       </tr>


       <tr>
            <td style="width: 90%;font-size:22px">บริษัท ทีที ออโตโมทีฟ สตีล (ไทยแลนด์) จำกัด </td>
            <td style="width: 10%;text-align:right;font-size:22px">เลขที่ ' . $result_seInvoice['INVOICECODE'] . '</td>
       </tr>
       <tr>
            <td style="width: 95%;font-size:22px">สำนักงานใหญ่ นิคมอุตสาหกรรมเกตเวย์ซิตี้ เลขที่ 256 หมู่ที่ 7 ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190</td>
            <td style="width: 5%;text-align:right;font-size:22px">วันที่ ' . $result_getDate['SYSDATE'] . '</td>
       </tr>

       <tr>
            <td style="width: 50%;font-size:22px">เลขประจำตัวผู้เสียภาษี  0105548107746</td>
            <td style="width: 50%;text-align:right;">&nbsp;</td>
       </tr>
    </tbody>
</table>';

$table_begin3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:15px;margin-top:8px;">';
$thead3 = '<thead>

        <tr style="border:1px solid #000;padding:4px;">

        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;font-size:15px"><b>ลำดับที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;font-size:15px"><b>วันที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;font-size:15px"><b>หมายเลข DO</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;font-size:15px"><b>ทะเบียนรถ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;font-size:15px"><b>พนักงาน</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;font-size:15px"><b>จาก</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 35%;font-size:15px"><b>ถึง</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;font-size:15px"><b>พื้นที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;font-size:15px"><b>QT.</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;font-size:15px"><b>ราคา</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;font-size:15px"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
    </thead><tbody>';

$i = 1;
// $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
// $params_seBilling = array(
//     array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
//     array($condBilling1, SQLSRV_PARAM_IN),
//     array($condBilling2, SQLSRV_PARAM_IN)
// );
$sql_seBilling = "SELECT  e.VEHICLETYPE,
b.ACTUALPRICE_TEMP,CONVERT(VARCHAR(2),a.BILLINGDATE) AS 'BILLINGDATEDAY',CONVERT(VARCHAR(2),a.PAYMENTDATE) AS 'PAYMENTDATEDD',CONVERT(VARCHAR, CONVERT(DATETIME,a.PAYMENTDATE,103), 106) AS 'PAYMENTDATEDDMMYY', 
SUBSTRING(convert(VARCHAR, CONVERT(DATETIME,a.PAYMENTDATE,103), 106),3,10) AS 'PAYMENTDATEDDYY',b.VEHICLETRANSPORTDOCUMENTDRIVERID, b.VEHICLETRANSPORTPLANID,c.JOBNO,b.DOCUMENTCODE,b.PURCHASEORDER, b.COMPANYCODE, 
b.CUSTOMERCODE, b.EMPLOYEECODE1, b.EMPLOYEENAME1, b.EMPLOYEECODE2, b.EMPLOYEENAME2, b.JOBSTART, b.JOBEND,CONVERT(NVARCHAR,CONVERT(DECIMAL(10,3),(CONVERT(DECIMAL(10,3),CONVERT(INT,b.WEIGHTIN))/1000))) AS 'WEIGHTINTON', 
b.WEIGHTIN, b.WEIGHTOUT, b.TRIPAMOUNT, b.VEHICLEREGISNUMBER, b.COMPENSATION,b.COMPENSATION1,b.COMPENSATION2,b.OVERTIME, b.OTHER, b.PAY_REMARK, 
b.PAY_APPROVERS, b.PAY_EXPRESSWAY,PAY_EXPRESSWAY15,PAY_EXPRESSWAY25,PAY_EXPRESSWAY45,PAY_EXPRESSWAY50,PAY_EXPRESSWAY50RETURN,PAY_EXPRESSWAY55,PAY_EXPRESSWAY65,PAY_EXPRESSWAY65RETURN,PAY_EXPRESSWAY75,PAY_EXPRESSWAY195,
PAY_EXPRESSWAY100,PAY_EXPRESSWAY105RETURN, b.PAY_REPAIR, b.PAY_OTHER,b.PAY_CONDITION, b.CHECKEDBY, b.APPROVEDBY, 
b.ACTIVESTATUS, b.REMARK,CONVERT(VARCHAR(30), c.DATEWORKING, 103) AS 'DATEWORKING' ,CONVERT(VARCHAR(30), c.DATEVLIN, 103)  AS 'DATE_VLIN',CONVERT(VARCHAR(10), c.DATEVLIN, 103)  AS 'DATEVLIN_103',e.PRICE,
c.ACTUALPRICE,c.MATERIALTYPE,c.THAINAME,b.PURCHASEORDER,b.VEHICLETRANSPORTPLANID,
ROW_NUMBER() OVER (PARTITION BY c.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID,b.DOCUMENTCODE ASC) AS 'ROWNUM'
FROM [dbo].[LOGINVOICE] a
INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID] 
WHERE 1 = 1
AND INVOICECODE = '".$_GET['invoicecode']."'
AND c.COMPANYCODE ='".$result_seInvoice['COMPANYCODE']."'
ORDER BY c.DATEWORKING ASC";
$params_seBilling = array();


$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

    if ($result_seBilling['ROWNUM'] > 1) {
      $i--;
      $PRICE = '0';
      $QT = '';
    }else {
      $NO = $i;
      $PRICE  = $result_seBilling['PRICE'];
      $QT = '1';
    }


    if ($result_seBilling['JOBSTART'] == 'CH.R') {
      $jobstart = 'CH.R';
    }else if ($result_seBilling['JOBSTART'] == 'CS (Wellgrow)') {
      $jobstart = 'CS';
    }else if ($result_seBilling['JOBSTART'] == 'DMK  (Samrong)') {
      $jobstart = 'DMK';
    }else if ($result_seBilling['JOBSTART'] == 'HANWA (Amata city chonburi)') {
      $jobstart = 'HANWA';
    }else if ($result_seBilling['JOBSTART'] == 'Sakolchai (Pinthong2)') {
      $jobstart = 'Sakolchai';
    }else if ($result_seBilling['JOBSTART'] == 'SMTC (Pintong 2)') {
      $jobstart = 'SMTC';
    }else if ($result_seBilling['JOBSTART'] == 'SSSC3 (Rayong)') {
      $jobstart = 'SSSC3';
    }else if ($result_seBilling['JOBSTART'] == 'STC (Amata city chonburi)') {
      $jobstart = 'STC';
    }else if ($result_seBilling['JOBSTART'] == 'TKT (Amatanakorn)') {
      $jobstart = 'TKT';
    }else if ($result_seBilling['JOBSTART'] == 'TMT  (Samrong)') {
      $jobstart = 'TMT';
    }else if ($result_seBilling['JOBSTART'] == 'TTAST (G/W)') {
      $jobstart = 'TTAST';
    }else {
      $jobstart = $result_seBilling['JOBSTART'];
    }
  ////////////////////JOBEND//////////////////////////////////////////
    if ($result_seBilling['JOBEND'] == 'BKHT (Rayang)') {
      $jobend = 'BKHT';
      $location = 'Rayong';
    }else if ($result_seBilling['JOBEND'] == 'BP Engineering') {
      $jobend = 'BP Engineering';
      $location = 'Banpho';
    }else if ($result_seBilling['JOBEND'] == 'CS METAL (Wellgrow)') {
      $jobend = 'CS METAL';
      $location = 'Wellgrow';
    }else if ($result_seBilling['JOBEND'] == 'DMK  (Samrong)') {
      $jobend = 'DMK';
      $location = 'Samrong';
    }else if ($result_seBilling['JOBEND'] == 'Hino  (Bangplee)') {
      $jobend = 'Hino';
      $location = 'Bangplee';
    }else if ($result_seBilling['JOBEND'] == 'KIT') {
      $jobend = 'KIT';
      $location = 'Amata City Chonburi';
    }else if ($result_seBilling['JOBEND'] == 'MAC GRAPHIC (Bangplee)') {
      $jobend = 'MAC GRAPHIC';
      $location = 'Bangplee';
    }else if ($result_seBilling['JOBEND'] == 'OTC  (Ladkrabang)') {
      $jobend = 'OTC';
      $location = 'Ladkrabang';
    }else if ($result_seBilling['JOBEND'] == 'R&N (Samrong)') {
      $jobend = 'R&N ';
      $location = 'Samrong';
    }else if ($result_seBilling['JOBEND'] == 'Sakolchai (Pinthong)') {
      $jobend = 'Sakolchai';
      $location = 'Pinthong';
    }else if ($result_seBilling['JOBEND'] == 'Sarathon (Samutsakhon)') {
      $jobend = 'Sarathon';
      $location = 'Samutsakhon';
    }else if ($result_seBilling['JOBEND'] == 'SASC (Hemaraj Eastern Seaboard Rayong)') {
      $jobend = 'SASC';
      $location = 'Eastern Seaboard';
    }else if ($result_seBilling['JOBEND'] == 'SMM (Omnoi  Samutsakhon)') {
      $jobend = 'SMM';
      $location = 'Samutsakhon';
    }else if ($result_seBilling['JOBEND'] == 'STC (Amata city chonburi)') {
      $jobend = 'STC';
      $location = 'Amata City Chonburi';
    }else if ($result_seBilling['JOBEND'] == 'Sun Steel (Samutsakhon)') {
      $jobend = 'Sun Steel';
      $location = 'Samutsakhon';
    }else if ($result_seBilling['JOBEND'] == 'TAKEBE (Amata city chonburi)') {
      $jobend = 'TKB';
      $location = 'Amata City Chonburi';
    }else if ($result_seBilling['JOBEND'] == 'THAPT (Wellgrow)') {
      $jobend = 'THAPT';
      $location = 'Wellgrow';
    }else if ($result_seBilling['JOBEND'] == 'TMT  (B/P)') {
      $jobend = 'TMB';
      $location = 'Banpho';
    }else if ($result_seBilling['JOBEND'] == 'TMT  (Samrong)') {
      $jobend = 'TMS';
      $location = 'Samrong';
    }else if ($result_seBilling['JOBEND'] == 'TMT (Gateway)') {
      $jobend = 'TMG';
      $location = 'Gateway';
    }else if ($result_seBilling['JOBEND'] == 'TTAST  Plant2  (Pinthong)') {
      $jobend = 'TTAST';
      $location = 'Pinthong';
    }else if ($result_seBilling['JOBEND'] == 'TTAST2 (Pinthong2)') {
      $jobend = 'TTAST2';
      $location = 'Pinthong2';
    }else if ($result_seBilling['JOBEND'] == 'WMF(King Kaew)') {
      $jobend = 'WMF';
      $location = 'Kingkaew';
    }else if ($result_seBilling['JOBEND'] == 'YNP2') {
      $jobend = 'YNP2';
      $location = 'Bangplee';
    }else {
      $jobend = $result_seBilling['JOBEND'];
      $location = '';
    }

    $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "' ";
    $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmployeeehr = array(
        array('select_employeeehr2', SQLSRV_PARAM_IN),
        array($condEmployeeehr1, SQLSRV_PARAM_IN)
    );
    $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
    $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);


    $tbody3 .= '

      <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $i . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:18px">' . $result_seBilling['DATEVLIN_103'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:18px">' . $result_seBilling['DOCUMENTCODE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:18px">' . $result_seBilling['THAINAME'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:18px">' . $result_seBilling['EMPLOYEENAME1'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:18px">' . $result_seBilling['JOBSTART'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:18px">' . $result_seBilling['JOBEND'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:18px">' . $location . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:18px">' . $QT . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:18px">' . number_format($PRICE, 2) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:18px">' . number_format($PRICE, 2) . '</td>
      </tr>
    ';
    $i++;
    $sumtotal = $sumtotal + $PRICE;
}


$tfoot3 = '</tbody><tfoot>
     <tr style="border:1px solid #000;">
        <td colspan="9" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . convert($sumtotal) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">รวมสุทธิ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:18px">' . number_format($sumtotal, 2) . '</td>

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
   		 <td style="width: 10%;text-align:right">ผู้จัดทำ</td>
            <td style="width: 25%;">........................................</td>
         <td style="width: 10%;text-align:right">ผู้ตรวจสอบ</td>
            <td style="width: 20%;">........................................</td>
            <td style="width: 10%;text-align:right">ผู้อนุมัติ</td>
            <td style="width: 25%;">........................................</td>
       </tr>



    </tbody>
</table>';



$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_header3);
$mpdf->WriteHTML($table_begin3);
$mpdf->WriteHTML($thead3);
$mpdf->WriteHTML($tbody3);
$mpdf->WriteHTML($tfoot3);
$mpdf->WriteHTML($table_end3);
$mpdf->WriteHTML($table_footer3);

$mpdf->Output();


sqlsrv_close($conn);
?>
