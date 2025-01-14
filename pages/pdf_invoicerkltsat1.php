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
$condBilling2 = " AND c.COMPANYCODE ='RKL' AND c.CUSTOMERCODE ='TSAT' ";

$sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBillings = array(
    array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN)
);
$query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
$result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);

$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,DULYDATE,INVOICECODE,TRANSPORTATION FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '".$_GET['invoicecode']."'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);




//$invoicecode = create_invoice();

$mpdf = new mPDF('', 'Letter', '', '', 6, 15, 70, 5, 5, 10);
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
            <td colspan="2" style="font-size:22px">บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์ จำกัด (RUAMKIT RUNGRUENG LOGISTICS CO., LTD.)</td>
       </tr>
       <tr>
            <td colspan="2" style="font-size:22px">สำนักงานสาขาที่ 1 เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง จังหวัดชลบุรี 20160 โทรศัพท์ : 038-452824-5 โทรสาร : 038-210396</td>
       </tr>
       <tr>
            <td colspan="2" style="font-size:22px">เลขประจำตัวผู้เสียภาษี  0105552003135</td>
       </tr>
       <tr>
            <td colspan="2">&nbsp;</td>
       </tr>


       <tr>
       <td style="width: 50%;font-size:22px">ลูกค้า บริษัท ไทยซัมมิท โอโตโมทีฟ จำกัด (สำนักงานใหญ่) </td>
       <td style="width: 50%;text-align:right;font-size:22px">เลขที่ ' . $result_seInvoicecode['INVOICECODE'] . '</td>
        </tr>
        <tr>
            <td style="width: 75%;font-size:22px">ที่อยู่  4/3, 4/29 หมู่ที่ 1 ถ.บางนา-ตราด กม.16  ต.บางโฉลง อ.บางพลี จ.สมุทรปราการ 10540</td>
            <td style="width: 25%;text-align:right;font-size:22px">วันที่ ' . $result_seInvoicecode['DULYDATE'] . '</td>
        </tr>
        <tr>
            <td style="width: 75%;font-size:22px">เลขประจำตัวผู้เสียภาษี 0115556007101</td>
            <td style="width: 25%;text-align:right;font-size:22px"></td>
        </tr>
    </tbody>
</table>';

$table_begin3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead3 = '<thead>

        <tr style="border:1px solid #000;padding:6px;">

        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 10%;"><font style="font-size: 24px"><b>ลำดับที่</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 18%;"><font style="font-size: 24px"><b>วันที่</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 25%;"><font style="font-size: 24px"><b>หมายเลข DO</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 15%;"><font style="font-size: 24px"><b>ทะเบียนรถ</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 20%;"><font style="font-size: 24px"><b>พนักงาน</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 28%;"><font style="font-size: 24px"><b>จาก</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 30%;"><font style="font-size: 24px"><b>ถึง</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 10%;"><font style="font-size: 24px"><b>QT.</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 12%;"><font style="font-size: 24px"><b>ราคา</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 20%;"><font style="font-size: 24px"><b>จำนวนเงิน(บาท)</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:center;width: 17%;"><font style="font-size: 24px"><b>REMARK</b></font></td>
      </tr>
    </thead><tbody>';

$i = 1;
$sql_seBilling = "SELECT DISTINCT ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY a.JOBEND,b.VEHICLETRANSPORTPLANID ASC) AS 'RUNNUMBER',
    e.VEHICLETYPE,CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CASE
    WHEN b.REMARK = 'Charge 7' THEN b.WEIGHTIN
    WHEN b.REMARK = 'Charge 10' THEN 10000
    ELSE CONVERT(INT,b.WEIGHTIN)
    END) / 1000) * CONVERT(INT,REPLACE(e.[PRICE],'<br><br>',''))) AS 'PRICEAC',
    b.ACTUALPRICE_TEMP,CONVERT(VARCHAR(2),a.BILLINGDATE) AS 'BILLINGDATEDAY',CONVERT(VARCHAR(2),a.PAYMENTDATE) AS 'PAYMENTDATEDD',CONVERT(VARCHAR, CONVERT(DATETIME,a.PAYMENTDATE,103), 106) AS 'PAYMENTDATEDDMMYY', 
    SUBSTRING(convert(VARCHAR, CONVERT(DATETIME,a.PAYMENTDATE,103), 106),3,10) AS 'PAYMENTDATEDDYY',b.VEHICLETRANSPORTDOCUMENTDRIVERID, b.VEHICLETRANSPORTPLANID,b.DOCUMENTCODE,b.PURCHASEORDER, b.COMPANYCODE, 
    b.CUSTOMERCODE, b.EMPLOYEECODE1, b.EMPLOYEENAME1, b.EMPLOYEECODE2, b.EMPLOYEENAME2, b.JOBSTART, b.JOBEND,CONVERT(NVARCHAR,CONVERT(DECIMAL(10,3),(CONVERT(DECIMAL(10,3),CONVERT(INT,b.WEIGHTIN))/1000))) AS 'WEIGHTINTON', 
    b.WEIGHTIN, b.WEIGHTOUT, b.TRIPAMOUNT, b.VEHICLEREGISNUMBER, b.COMPENSATION,b.COMPENSATION1,b.COMPENSATION2,b.OVERTIME, b.OTHER, b.PAY_REMARK, 
    b.PAY_APPROVERS, b.PAY_EXPRESSWAY,PAY_EXPRESSWAY15,PAY_EXPRESSWAY25,PAY_EXPRESSWAY45,PAY_EXPRESSWAY50,PAY_EXPRESSWAY50RETURN,PAY_EXPRESSWAY55,PAY_EXPRESSWAY65,PAY_EXPRESSWAY65RETURN,PAY_EXPRESSWAY75,PAY_EXPRESSWAY195,PAY_EXPRESSWAY100,PAY_EXPRESSWAY105RETURN, b.PAY_REPAIR, b.PAY_OTHER,b.PAY_CONDITION, b.CHECKEDBY, b.APPROVEDBY, 
    b.ACTIVESTATUS, b.REMARK ,CONVERT(VARCHAR(30), c.DATEVLIN, 103)  AS 'DATE_VLIN',CONVERT(VARCHAR(10), c.DATEVLIN, 103)  AS 'DATEVLIN_103',e.PRICE,
    c.ACTUALPRICE,c.MATERIALTYPE,c.THAINAME,b.PURCHASEORDER,c.C8,CASE
    WHEN c.C8 = 'return' THEN ((e.PRICE*40)/100)
    ELSE ''
    END AS 'PRICE_RETURN'
    FROM [dbo].[LOGINVOICE] a
    INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
    INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID] 
    WHERE  c.ACTIVESTATUS ='1' AND c.VEHICLETRANSPORTPLANID !=''
    AND a.INVOICECODE = '".$_GET['invoicecode']."' 
    AND c.COMPANYCODE ='RKL' AND c.CUSTOMERCODE ='TSAT' ";
$params_seBilling = array();
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



    $sql_seHoliday = "SELECT HOLIDAY AS 'DATE' FROM [dbo].[BILLING_HOLIDAY] WHERE INVOICECODE ='".$result_seInvoicecode['INVOICECODE']."'
    AND COMPANYCODE='RKL' AND CUSTOMERCODE = 'TSAT'";
    $params_seHoliday = array();
    $query_seHoliday = sqlsrv_query($conn, $sql_seHoliday, $params_seHoliday);
    $result_seHoliday = sqlsrv_fetch_array($query_seHoliday, SQLSRV_FETCH_ASSOC);


    $holiday = $result_seHoliday['DATE'];
    // $holiday = $result_seHoliday['DATE'];
    $holidaysplit = explode(",", $holiday);

    $documentcode_return = $result_seBilling['DOCUMENTCODE'];
    $documentcode_returnsplit = explode(",", $documentcode_return);
    // $document_return = $result_seHoliday['DOCUMENTCODE'];
    // $document_returnsplit = explode(",", $document_return);
    // if ($result_seInvoicecode['TRANSPORTATION'] == 'TSR&D / TSAT (Bangna Trad Kms.16)') {
    //   $JOBSTART = $result_seBilling['JOBEND'];
    //   $JONEND = $result_seBilling['JOBSTART'];
    // }else {
    //   $JOBSTART = $result_seBilling['JOBSTART'];
    //   $JONEND = $result_seBilling['JOBEND'];
    // }

    if ((($result_seBilling['DATE_VLIN'] == $holidaysplit[0]) || ($result_seBilling['DATE_VLIN'] == $holidaysplit[1]) || ($result_seBilling['DATE_VLIN'] == $holidaysplit[2]) || ($result_seBilling['DATE_VLIN'] == $holidaysplit[3]) || ($result_seBilling['DATE_VLIN'] == $holidaysplit[4])) && ($result_seBilling['C8'] != 'return')) {
        $tbody3 .= '
            

        <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $i . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['DATE_VLIN'] . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['DOCUMENTCODE'] . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['THAINAME'] . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seEmployeeehr['FnameT'] . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . ($result_seBilling['JOBSTART']  == 'TSR&D / TSAT (Bangna-Trad Kms.16)' ? 'TSAT (Bangplee)' : $result_seBilling['JOBSTART']) . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['JOBEND']. '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">1.00</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">' . number_format($result_seBilling['PRICE'], 2) . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">' . number_format($result_seBilling['PRICE'], 2) . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px"></font></td>
        </tr>
            <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['DATE_VLIN'] . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['DOCUMENTCODE'] . '</td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['THAINAME'] . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seEmployeeehr['FnameT'] . '</font></td>
            <td colspan="2" style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">Holiday</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">1.00</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">1,000.00</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">1,000.00</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px"></font></td>
            </tr>
        ';
        $i++;
        $count ++ ;
        $sumtotalholiday = ($count * 1000);
        $sumtotal1 = $sumtotal1 + $result_seBilling['PRICE'];

    }else if((($result_seBilling['DATE_VLIN'] == $holidaysplit[0]) || ($result_seBilling['DATE_VLIN'] == $holidaysplit[1]) || ($result_seBilling['DATE_VLIN'] == $holidaysplit[2]) || ($result_seBilling['DATE_VLIN'] == $holidaysplit[3]) || ($result_seBilling['DATE_VLIN'] == $holidaysplit[4])) && ($result_seBilling['C8'] == 'return')){
        $tbody3 .= '
            

            <tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $i . '</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['DATE_VLIN'] . '</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['DOCUMENTCODE'] . '</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['THAINAME'] . '</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seEmployeeehr['FnameT'] . '</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . ($result_seBilling['JOBSTART']  == 'TSR&D / TSAT (Bangna-Trad Kms.16)' ? 'TSAT (Bangplee)' : $result_seBilling['JOBSTART']) . '</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['JOBEND']. '</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">1.00</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">' . number_format($result_seBilling['PRICE'], 2) . '</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">' . number_format($result_seBilling['PRICE'], 2) . '</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px"></font></td>
            </tr>
            <tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"></font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['DATE_VLIN'] . '</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $documentcode_returnsplit[1] . '</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['THAINAME'] . '</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seEmployeeehr['FnameT'] . '</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['JOBEND']. '</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . ($result_seBilling['JOBSTART']  == 'TSR&D / TSAT (Bangna-Trad Kms.16)' ? 'TSAT (Bangplee)' : $result_seBilling['JOBSTART']) . '</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">1.00</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">' . number_format($result_seBilling['PRICE_RETURN'], 2) . '</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">' . number_format($result_seBilling['PRICE_RETURN'], 2) . '</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">งานรับกลับคิด 40%</font></td>
            </tr>
            <tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['DATE_VLIN'] . '</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['DOCUMENTCODE'] . '</td>
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['THAINAME'] . '</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seEmployeeehr['FnameT'] . '</font></td>
                <td colspan="2" style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">Holiday</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">1.00</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">1,000.00</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">1,000.00</font></td>
                <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px"></font></td>
            </tr>
        ';
        $i++;
        $count ++ ;
        $sumtotalholiday = ($count * 1000);
        $sumtotalreturn  = $sumtotalreturn +$result_seBilling['PRICE_RETURN'];
        $sumtotal1 = $sumtotal1 + $result_seBilling['PRICE'];
    }else {
        $tbody3 .= '

            <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px">' . $i . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px">' . $result_seBilling['DATE_VLIN'] . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['DOCUMENTCODE'] . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px">' . $result_seBilling['THAINAME'] . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><font style="font-size: 24px">' . $result_seEmployeeehr['FnameT'] . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . ($result_seBilling['JOBSTART']  == 'TSR&D / TSAT (Bangna-Trad Kms.16)' ? 'TSAT (Bangplee)' : $result_seBilling['JOBSTART']) . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">' . $result_seBilling['JOBEND']. '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px">1.00</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">' . number_format($result_seBilling['PRICE'], 2) . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px">' . number_format($result_seBilling['PRICE'], 2) . '</font></td>
            <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px"></font></td>
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
        <td colspan="7" style="border-right:1px solid #000;padding:6px;text-align:center;"><font style="font-size: 24px"><b>' .  convert($sumtotal1+$sumtotal2+$sumtotalreturn+$sumtotalholiday) . '</b></font></td>
        <td style="border-right:1px solid #000;padding:6px;text-align:right;"><font style="font-size: 24px"><b>' . number_format($sumtotal1+$sumtotal2+$sumtotalreturn+$sumtotalholiday, 2) . '</b></font></td>

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
