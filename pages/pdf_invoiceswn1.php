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


$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,INVOICECODE,COMPANYCODE,CUSTOMERCODE,TRANSPORTATION,JOBEND,MATERIALTYPE,DULYDATE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '" . $_GET['invoicecode'] . "'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);

$MAT = ($result_seInvoicecode['MATERIALTYPE'] == '') ? "" : " AND c.MATERIALTYPE = '" . $result_seInvoicecode['MATERIALTYPE'] . "'";


$condBilling1 = " AND c.COMPANYCODE = '" . $result_seInvoicecode['COMPANYCODE'] . "' AND c.CUSTOMERCODE = '" . $result_seInvoicecode['CUSTOMERCODE'] . "' AND b.JOBSTART='" . $result_seInvoicecode['TRANSPORTATION'] . "' AND b.JOBEND='" . $result_seInvoicecode['JOBEND'] . "' AND INVOICECODE = '".$_GET['invoicecode']."'";
$condBilling2 = " AND CONVERT(DATE,c.DATEDEALERIN) BETWEEN CONVERT(DATE,'" . $result_seInvoicecode['BILLINGDATE'] . "',103) AND CONVERT(DATE,'" . $result_seInvoicecode['PAYMENTDATE'] . "',103)  " . $MAT ;



$sql_seBillings = "SELECT DISTINCT c.MATERIALTYPE,c.THAINAME,c.JOBSTART,c.JOBEND
FROM [dbo].[LOGINVOICE] a
INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID]
INNER JOIN [dbo].[COMPANYEHR] d ON b.COMPANYCODE = d.Company_Code
WHERE 1 = 1 AND c.MATERIALTYPE ! = '' " . $condBilling1 . $condBilling2;

$query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
$result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);

//$invoicecode = create_invoice();
$year = $result_seInvoicecode['DULYDATE'];
$datemon = substr($year,0,6);
$yearsub = substr($year,6,10);
$year = $yearsub+543;

$mpdf = new mPDF('', 'Letter', '', '', 10, 10, 95, 5, 5, 5);
$style = '
<style>
	body{
		font-family: "angsanaupc";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';


if ($result_seBillings['JOBSTART'] == 'GMT' || $result_seBillings['JOBEND'] == 'GMT') {
    $table_header3 = '<br><table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="2" style="text-align:center"><b><font style="font-size: 28px">ใบส่งสินค้า</font></b></td>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" style="font-size:22px">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด (RUAMKIT RECYCLE CARRIER CO.,LTD.)</td>
       </tr>
       <tr>
            <td colspan="2" style="font-size:22px">สำนักงานใหญ่ 104 ซอยบางนา-ตราด 14 แขวงบางนา เขตบางนา กรุงเทพมหานคร</td>
       </tr>
       <tr>
            <td colspan="2" style="font-size:22px">สำนักงานสาขา 109/1 หมู่ที่ 9 ตำบลหัวสำโรง อำเภอแปลงยาว จังหวัดฉะเชิงเทรา</td>
       </tr>

       <tr>
            <td style="width: 50%;font-size:22px">เลขประจำตัวผู้เสียภาษี 0105551065951</td>
            <td style="width: 50%;text-align:right;font-size:22px">เลขที่ ' . $_GET['invoicecode'] . '</td>
       </tr>
       <tr>
            <td colspan="2" style="font-size:22px">&nbsp;</td>
       </tr>
       <tr>
            <td style="width: 50%;font-size:22px">ลูกค้า บริษัท  สยามวัฒนา เวสต์ แมนเน็จเม้นท์  จำกัด</td>
            <td style="width: 50%;text-align:right;font-size:22px">วันที่ ' . $datemon  . ''.$year.'</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;font-size:22px">22/1 หมู่ 6 ตำบลหนองบอนแดง อำเภอบ้านบึง จังหวัดชลบุรี</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;font-size:22px"></td>
       </tr>
    </tbody>
</table>';
} else {
    $table_header3 = '<br><table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="2" style="text-align:center"><b><font style="font-size: 28px">ใบส่งสินค้า</font></b></td>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" style="font-size:22px">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด (RUAMKIT RECYCLE CARRIER CO.,LTD.)</td>
       </tr>
       <tr>
            <td colspan="2" style="font-size:22px">สำนักงานใหญ่ 104 ซอยบางนา-ตราด 14 แขวงบางนา เขตบางนา กรุงเทพมหานคร</td>
       </tr>
       <tr>
            <td colspan="2" style="font-size:22px">สำนักงานสาขา 109/1 หมู่ที่ 9 ตำบลหัวสำโรง อำเภอแปลงยาว จังหวัดฉะเชิงเทรา</td>
       </tr>

       <tr>
            <td style="width: 50%;font-size:22px">เลขประจำตัวผู้เสียภาษี 0105551065951</td>
            <td style="width: 50%;text-align:right;font-size:22px">เลขที่ ' . $_GET['invoicecode'] . '</td>
       </tr>
       <tr>
            <td colspan="2" style="font-size:22px">&nbsp;</td>
       </tr>
       <tr>
            <td style="width: 50%;font-size:22px">ลูกค้า บริษัท  สยามวัฒนา เวสต์ แมนเน็จเม้นท์  จำกัด</td>
            <td style="width: 50%;text-align:right;font-size:22px">วันที่ ' . $datemon  . ''.$year.'</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;font-size:22px">22/1 หมู่ 6 ตำบลหนองบอนแดง อำเภอบ้านบึง จังหวัดชลบุรี</td>
       </tr>

    </tbody>
</table>';
}
$table_begin3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead3 = '<thead>

        <tr style="border:1px solid #000;padding:4px;">
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;"><b>No.</b></td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>D / M /Y</b></td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>Driver</b></td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Truck No.</b></td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Delivery</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Weight (Tons)</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Price</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Total</b></td>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>From</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>To</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Price</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Baht/Trips</b></td>
      </tr>
    </thead><tbody>';




$i = 1;

// $sql_seBilling = "SELECT DISTINCT CONVERT(NVARCHAR(6),CONVERT(DATE,b.DATEVLHEAD,103),6)+' '+RIGHT(CONVERT(NVARCHAR(4),CONVERT(DATE,b.DATEVLHEAD,103))+543,2) AS 'DATE_VLIN',
// CONVERT(DECIMAL(10,3),REPLACE(c.ACTUALPRICE, ',', '')) AS 'ACTUALPRICE2',b.JOBSTART, b.JOBEND,b.WEIGHTIN,CONVERT(VARCHAR(30), c.DATEDEALERIN, 106)  AS 'DATE_DEALERIN',
// b.WEIGHTOUT,c.ACTUALPRICE,b.EMPLOYEENAME1, b.EMPLOYEECODE2,c.[VEHICLETYPE],c.VEHICLETRANSPORTPLANID,b.VEHICLEREGISNUMBER,c.THAINAME
// FROM [dbo].[LOGINVOICE] a
// INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
// INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
// INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID]
// INNER JOIN [dbo].[COMPANYEHR] d ON b.COMPANYCODE = d.Company_Code
// WHERE 1 = 1 " . $condBilling1 . $condBilling2 ;

$sql_seBilling = "SELECT DISTINCT CONVERT(NVARCHAR(6),CONVERT(DATE,b.DATEVLHEAD,103),6)+' '+RIGHT(CONVERT(NVARCHAR(4),CONVERT(DATE,b.DATEVLHEAD,103))+543,2) AS 'DATE_VLIN',
CONVERT(DECIMAL(10,3),REPLACE(c.ACTUALPRICE, ',', '')) AS 'ACTUALPRICE2',b.JOBSTART, b.JOBEND,b.WEIGHTIN,CONVERT(VARCHAR(30), c.DATEDEALERIN, 106)  AS 'DATE_DEALERIN',
b.WEIGHTOUT,c.ACTUALPRICE,b.EMPLOYEENAME1, b.EMPLOYEECODE2,c.[VEHICLETYPE],c.VEHICLETRANSPORTPLANID,b.VEHICLEREGISNUMBER,c.THAINAME
FROM [dbo].[LOGINVOICE] a
INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID]
INNER JOIN [dbo].[COMPANYEHR] d ON b.COMPANYCODE = d.Company_Code
WHERE 1 = 1
AND c.COMPANYCODE = '" . $result_seInvoicecode['COMPANYCODE'] . "' AND c.CUSTOMERCODE = '" . $result_seInvoicecode['CUSTOMERCODE'] . "' AND b.JOBSTART='" . $result_seInvoicecode['TRANSPORTATION'] . "' AND b.JOBEND='" . $result_seInvoicecode['JOBEND'] . "' AND INVOICECODE = '".$_GET['invoicecode']."'
AND CONVERT(DATE,c.DATEDEALERIN) BETWEEN CONVERT(DATE,'" . $result_seInvoicecode['BILLINGDATE'] . "',103) AND CONVERT(DATE,'" . $result_seInvoicecode['PAYMENTDATE'] . "',103)
AND c.MATERIALTYPE = '" . $result_seInvoicecode['MATERIALTYPE'] . "'
ORDER BY  DATE_DEALERIN ASC ";

$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

    $sql_seThainame = " SELECT VEHICLEREGISNUMBER AS 'THAINAME' FROM [dbo].[VEHICLEINFO] WHERE THAINAME ='" .$result_seBilling['THAINAME']. "'";
    $params_seThainame  = array();
    $query_seThainame  = sqlsrv_query($conn, $sql_seThainame, $params_seThainame);
    $result_seThainame  = sqlsrv_fetch_array($query_seThainame, SQLSRV_FETCH_ASSOC);

    $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "' ";
    $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmployeeehr = array(
        array('select_employeeehr2', SQLSRV_PARAM_IN),
        array($condEmployeeehr1, SQLSRV_PARAM_IN)
    );
    $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
    $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
    $VAR_VEHICLEREGISNUMBER = "";
    if ($result_seBilling['VEHICLETYPE'] == '22W(Dump)') {
        $sql_seVeh = "SELECT VEHICLEREGISNUMBER FROM [dbo].[VEHICLEINFO] WHERE SUBSTRING(THAINAME,0,7) =
        (SELECT DISTINCT SUBSTRING(THAINAME,0,7) FROM [dbo].[VEHICLEINFO] WHERE VEHICLEREGISNUMBER = '" . $result_seBilling['VEHICLEREGISNUMBER'] . "')
        AND [VEHICLETYPECODE] = '10W'";

        $query_seVeh = sqlsrv_query($conn, $sql_seVeh, $params_seVeh);
        $result_seVeh = sqlsrv_fetch_array($query_seVeh, SQLSRV_FETCH_ASSOC);
        $VAR_VEHICLEREGISNUMBER = $result_seVeh['VEHICLEREGISNUMBER'];
    } else {
        $VAR_VEHICLEREGISNUMBER = $result_seBilling['VEHICLEREGISNUMBER'];
    }

    $tbody3 .= '

        <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $i . '</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seBilling['DATE_DEALERIN'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seEmployeeehr['FnameT'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seThainame['THAINAME'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seBilling['JOBSTART'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seBilling['JOBEND'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . number_format($result_seBilling['WEIGHTIN']/1000) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . number_format($result_seBilling['ACTUALPRICE2']) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . number_format($result_seBilling['ACTUALPRICE2']) . '</td>
      </tr>
    ';
    $i++;
    $sumgmtweight = $sumgmtweight + ($result_seBilling['WEIGHTIN']/1000);
    $sumtotal = $sumtotal + $result_seBilling['ACTUALPRICE2'];
    $planid = $planid . $result_seBilling['VEHICLETRANSPORTPLANID'] . "','";
}

$MATERIALTYPE = "";

if ($result_seBillings['THAINAME'] == 'สนามชัยเขต' || $result_seBillings['THAINAME'] == 'แปลงยาว') {
    $sql_seMaterialtype = "SELECT DISTINCT MATERIALTYPE FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE VEHICLETRANSPORTPLANID IN ('" . $planid . "')";
    $query_seMaterialtype = sqlsrv_query($conn, $sql_seMaterialtype, $params_seMaterialtype);
    while ($result_seMaterialtype = sqlsrv_fetch_array($query_seMaterialtype, SQLSRV_FETCH_ASSOC)) {
        $MATERIALTYPE = $MATERIALTYPE . $result_seMaterialtype['MATERIALTYPE'] . "<br>";
    }
} else {
    $MATERIALTYPE = $result_seBillings['MATERIALTYPE'];
}

$tfoot3 = '</tbody><tfoot>
     <tr style="border:1px solid #000;">

        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">PRODUCT : ' . $MATERIALTYPE . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px"><b>' . number_format($sumgmtweight) . '</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">-</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px"><b>' . number_format($sumtotal) . '</b></td>
            </tr>
    </tfoot>';


$table_end3 = '</table>';

// $table_footer3 = '<br><br><br><br><br><br><table style="width: 100%;">
$table_footer3 = '<br><br><br><br><br><br><br><br><br><table style="width: 100%;">
    <tbody>

       <tr>
   		 <td style="width: 50%;text-align:center;font-size:18px">ผู้จัดทำ........................................ </td>

       <td style="width: 50%;text-align:center;font-size:18px">ผู้ตรวจสอบ........................................</td>

       </tr>

       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>
       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>


       <tr>
   		 <td style="width: 50%;text-align:center;font-size:18px">ผู้อนุมัติ........................................ </td>

       <td style="width: 50%;text-align:center;font-size:18px">ผู้รับสินค้า........................................</td>

       </tr>

    </tbody>
</table>';
$mpdf->WriteHTML($style);
$mpdf->SetHTMLHeader($table_header3, 'O', true);
$mpdf->WriteHTML($table_begin3);
$mpdf->WriteHTML($thead3);
$mpdf->WriteHTML($tbody3);
$mpdf->WriteHTML($tfoot3);
$mpdf->WriteHTML($table_end3);
$mpdf->WriteHTML($table_footer3);
$mpdf->Output();


sqlsrv_close($conn);
?>
