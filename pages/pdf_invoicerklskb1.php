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



$mpdf = new mPDF('th', 'A4', '0', '');
$style = '
<style>
	body{
		font-family: "Garuda";font-size:12px//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';



$table_header3 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="2" style="text-align:center"><b>ใบส่งสินค้า</b></td>
    </thead>
    <tbody>
       <tr>
            <td colspan="2" style="font-size:14px"><b>บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์ จำกัด (RUAMKIT RUNGRUENG LOGISTICS CO., LTD.)<b></td>
       </tr>
       <tr>
            <td colspan="2">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง จังหวัดชลบุรี 20160</td>
       </tr>
       <tr>
            <td colspan="2">โทรศัพท์ : 038-452824-5 โทรสาร : 038-210396</td>
       </tr>
       <tr>
            <td colspan="2">&nbsp;</td>
       </tr>

       <tr>
            <td style="width: 50%;">ลูกค้า บริษัท สยามคูโบต้า คอร์ปอเรชั่น จำกัด </td>
            <td style="width: 50%;text-align:right">เลขที่ ' . $_GET['invoicecode'] . '</td>
       </tr>
       <tr>
            <td style="width: 50%;">ที่อยู่ 700/867 หมู่ 3 นิคมอุตสาหกรรมอมตะชิตี้ชลบุรี<br>ตำบลหนองกะขะ อำเภอพานทอง จังหวัดชลบุรี 20160</td>
            <td style="width: 50%;text-align:right">วันที่ ' . $result_getDate['SYSDATE'] . ' เครดิต 30 วัน</td>
       </tr>
       <tr>
            <td style="width: 50%;">เลขประจำตัวผู้เสียภาษี 01355503009111</td>
            <td style="width: 50%;text-align:right">วันที่ครบกำหนด '.$_GET['datedue'].'</td>
       </tr>
    </tbody>
</table>';

$table_begin3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">';
$thead3 = '<thead>

        <tr style="border:1px solid #000;padding:4px;">

        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 8%;"><b>ลำดับที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>วันที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>หมายเลข DO</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ทะเบียนรถ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>พนักงาน</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 25%;"><b>เส้นทาง</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;"><b>QT.</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ราคา</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
    </thead><tbody>';
$i = 1;
$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '" . $_GET['invoicecode'] . "'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);

$condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seInvoicecode['BILLINGDATE'] . "',103) AND CONVERT(DATE,'" . $result_seInvoicecode['PAYMENTDATE'] . "',103) ";
$condBilling2 = " AND a.COMPANYCODE = '" . $_GET['companycode'] . "' AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "' ";



$sql_seBilling = "SELECT d.PRICE AS 'SUMPRICE',d.PRICEKM,b.CUSTOMERCODE_BILLING,b.BILLING,c.PRICE AS 'ACTUALPRICE_TEMP', b.[CLUSTER],a.VEHICLETRANSPORTDOCUMENTDRIVERID, a.VEHICLETRANSPORTPLANID,a.TRIPNUMBER,a.OILNUMBER, a.DOCUMENTCODE, a.COMPANYCODE, a.CUSTOMERCODE,
                                        a.EMPLOYEECODE1, a.EMPLOYEENAME1, a.EMPLOYEECODE2, a.EMPLOYEENAME2, a.JOBSTART, a.JOBEND, a.WEIGHTIN,CONVERT(NVARCHAR,CONVERT(DECIMAL(10,3),(CONVERT(DECIMAL(10,3),CONVERT(INT,a.WEIGHTIN))/1000))) AS 'WEIGHTINTON', a.WEIGHTOUT, a.TRIPAMOUNT,
                                        a.VEHICLEREGISNUMBER, CONVERT(INT,a.COMPENSATION) AS 'COMPENSATION',a.OILAVERAGE,a.OVERTIME, a.OTHER, a.PAY_REMARK, a.PAY_APPROVERS, a.PAY_EXPRESSWAY,
                                        PAY_EXPRESSWAY15,PAY_EXPRESSWAY25,PAY_EXPRESSWAY45,PAY_EXPRESSWAY50,PAY_EXPRESSWAY50RETURN,PAY_EXPRESSWAY55,PAY_EXPRESSWAY65,PAY_EXPRESSWAY65RETURN,PAY_EXPRESSWAY75,PAY_EXPRESSWAY195, a.PAY_REPAIR, a.PAY_OTHER,a.PAY_CONDITION, a.CHECKEDBY,
                                        a.APPROVEDBY, a.ACTIVESTATUS, a.REMARK, a.CREATEBY, a.CREATEDATE, a.MODIFIEDBY, a.MODIFIEDDATE,CONVERT(VARCHAR(30), b.DATEVLIN, 106)  AS 'DATE_VLIN',CONVERT(VARCHAR(10), b.DATEVLIN, 103)  AS 'DATEVLIN_103',
                                        a.ACTUALPRICE,b.MATERIALTYPE,a.BILLINGSTATUS,b.JOBNO,b.THAINAME AS 'TRUCKTYPE',c.ROUTEDESCRIPTION,c.VEHICLETYPE ,b.ROUNDAMOUNT,c.ZONE
                                        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                                        INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON a.[VEHICLETRANSPORTPRICEID] = c.[VEHICLETRANSPORTPRICEID]
                                        INNER JOIN [dbo].[CONFRIMSKB] d ON b.VEHICLETRANSPORTPLANID = d.VEHICLETRANSPORTPLANID AND a.[VEHICLETRANSPORTDOCUMENTDRIVERID] = d.[VEHICLETRANSPORTDOCUMENTDRIVERID]
                                        WHERE a.ACTIVESTATUS = 1".$condBilling1.$condBilling2;
$params_seBilling = array(
    array('select_vehicletransportdocumentdriverall', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);


$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {





    $tbody3 .= '

        <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $i . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['DATE_VLIN'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['DOCUMENTCODE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['TRUCKTYPE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['EMPLOYEENAME1'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seBilling['JOBSTART'].'-'.$result_seBilling['JOBEND']. '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['TRIPAMOUNT'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($result_seBilling['PRICEKM'], 2) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($result_seBilling['PRICEKM'], 2) . '</td>
      </tr>
    ';
    $i++;
    $sumtotal = $result_seBilling['SUMPRICE'];
}


$tfoot3 = '</tbody><tfoot>
     <tr style="border:1px solid #000;">
        <td colspan="7" style="border-right:1px solid #000;padding:4px;text-align:center;">' . convert($sumtotal) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">รวมสุทธิ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($sumtotal, 2) . '</td>

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
