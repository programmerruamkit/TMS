<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
$sumgmtweight = "";
$sumcusweight = "";
$sumamounttrip = "";
$sumtotal = "";

// if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
//     $date_now = "";
// } else {
//     $date_now = $_GET['datestart'] . ' ถึง ' . $_GET['dateend'];
// }

// $sql_getDate = "{call megStopwork_v2(?)}";
// $params_getDate = array(
//     array('select_getdate', SQLSRV_PARAM_IN)
// );
// $query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
// $result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);


$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,INVOICECODE,COMPANYCODE,CUSTOMERCODE,TRANSPORTATION,JOBEND,MATERIALTYPE,DULYDATE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '" . $_GET['invoicecode'] . "'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);

$MAT = ($result_seInvoicecode['MATERIALTYPE'] == '') ? "" : " AND c.MATERIALTYPE = '" . $result_seInvoicecode['MATERIALTYPE'] . "'";


$condBilling1 = " AND c.COMPANYCODE = '" . $result_seInvoicecode['COMPANYCODE'] . "' AND c.CUSTOMERCODE = '" . $result_seInvoicecode['CUSTOMERCODE'] . "' AND b.JOBSTART='" . $result_seInvoicecode['TRANSPORTATION'] . "' AND b.JOBEND='" . $result_seInvoicecode['JOBEND'] . "' AND INVOICECODE = '".$_GET['invoicecode']."'";
$condBilling2 = " AND CONVERT(DATE,c.DATEDEALERIN) BETWEEN CONVERT(DATE,'" . $result_seInvoicecode['BILLINGDATE'] . "',103) AND CONVERT(DATE,'" . $result_seInvoicecode['PAYMENTDATE'] . "',103)  " . $MAT ;





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
            <td colspan="2" style="font-size:22px">สำนักงานใหญ่ 109/1 หมู่ที่ 9 ตำบลหัวสำโรง อำเภอแปลงยาว จังหวัดฉะเชิงเทรา</td>
       </tr>
       <tr>
            <td colspan="2" style="font-size:22px">&nbsp;</td>
       </tr>
       <tr>
            <td style="width: 50%;font-size:22px">เลขประจำตัวผู้เสียภาษี 0105551065951</td>
            <td style="width: 50%;text-align:right;font-size:22px">เลขที่ ' . $_GET['invoicecode'] . '</td>
       </tr>
       <tr>
            <td colspan="2" style="font-size:22px">&nbsp;</td>
       </tr>
       <tr>
            <td style="width: 50%;font-size:22px">ลูกค้า บจก.กรีน เมทัลส์(ประเทศไทย)</td>
            <td style="width: 50%;text-align:right;font-size:22px">วันที่ ' . $datemon  . ''.$year.'</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;font-size:22px">ที่อยู่ 254 หมู่ 7 นิคมอุตสาหกรรมเกตเวย์ชิตี้ </td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;font-size:22px">ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190</td>
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
            <td colspan="2" style="font-size:22px">สำนักงานใหญ่ 109/1 หมู่ที่ 9 ตำบลหัวสำโรง อำเภอแปลงยาว จังหวัดฉะเชิงเทรา</td>
       </tr>
       <tr>
            <td colspan="2" style="font-size:22px">&nbsp;</td>
       </tr>
       <tr>
            <td style="width: 50%;font-size:22px">เลขประจำตัวผู้เสียภาษี 0105551065951</td>
            <td style="width: 50%;text-align:right;font-size:22px">เลขที่ ' . $_GET['invoicecode'] . '</td>
       </tr>
       <tr>
            <td colspan="2" style="font-size:22px">&nbsp;</td>
       </tr>
       <tr>
            <td style="width: 50%;font-size:22px">ลูกค้า บจก.กรีน เมทัลส์(ประเทศไทย)</td>
            <td style="width: 50%;text-align:right;font-size:22px">วันที่ ' . $datemon  . ''.$year.'</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;font-size:22px">ที่อยู่ 219/18 หมู่ 6 นิคมอุตสาหกรรมปิ่นทอง 3</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;font-size:22px">ตำบลบ่อวิน อำเภอศรีราชา จังหวัดชลบุรี 20230</td>
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
          <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Weight (Tons)</b></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Price</td>
          <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Total</b></td>
          <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>REMARK</b></td>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
          <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>From</b></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>To</b></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>GMT weight</b></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>CUS weight</b></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Baht/Trips</b></td>
        </tr>
    </thead><tbody>';




$i = 1;
$count = 0 ;
// $sql_seBilling = "SELECT DISTINCT CONVERT(NVARCHAR(6),CONVERT(DATE,b.DATEVLHEAD,103),6)+' '+RIGHT(CONVERT(NVARCHAR(4),CONVERT(DATE,b.DATEVLHEAD,103))+543,2) AS 'DATE_VLIN',
// CONVERT(DECIMAL(10,3),REPLACE(c.ACTUALPRICE, ',', '')) AS 'ACTUALPRICE2',b.JOBSTART, b.JOBEND,b.WEIGHTIN,CONVERT(VARCHAR(30), c.DATEDEALERIN, 106)  AS 'DATE_DEALERIN',
// b.WEIGHTOUT,c.ACTUALPRICE,b.EMPLOYEENAME1, b.EMPLOYEECODE2,c.[VEHICLETYPE],c.VEHICLETRANSPORTPLANID,b.VEHICLEREGISNUMBER,c.THAINAME
// FROM [dbo].[LOGINVOICE] a
// INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
// INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
// INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID]
// INNER JOIN [dbo].[COMPANYEHR] d ON b.COMPANYCODE = d.Company_Code
// WHERE 1 = 1 " . $condBilling1 . $condBilling2 ;

$sql_seBilling = "SELECT  CONVERT(NVARCHAR(6),CONVERT(DATE,a.DATEVLIN,103),6)+' '+RIGHT(CONVERT(NVARCHAR(4),CONVERT(DATE,a.DATEVLIN,103))+543,2) AS 'DATE_VLIN',
CONVERT(VARCHAR(10), a.DATEDEALERIN, 6)  AS 'DATE_DEALERIN',
a.[VEHICLETYPE],a.VEHICLETRANSPORTPLANID,a.JOBNO,b.JOBSTART,b.JOBEND,
b.EMPLOYEENAME1, b.EMPLOYEENAME2,b.VEHICLEREGISNUMBER,a.THAINAME,a.ACTUALPRICE,CONVERT(VARCHAR(10), a.DATEVLIN, 103)  AS 'DATEVLIN_103',a.C8,
CASE
    WHEN a.C8 = 'return' THEN ((a.ACTUALPRICE*50)/100)
    ELSE a.ACTUALPRICE
    END AS 'PRICE_RETURN'
FROM [dbo].[VEHICLETRANSPORTPLAN] a 
INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON b.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID]

WHERE a.ACTIVESTATUS ='1'
AND a.COMPANYCODE = '" . $result_seInvoicecode['COMPANYCODE'] . "' AND a.CUSTOMERCODE = '" . $result_seInvoicecode['CUSTOMERCODE'] . "' 
AND b.JOBSTART='" . $result_seInvoicecode['TRANSPORTATION'] . "' AND b.JOBEND='" . $result_seInvoicecode['JOBEND'] . "' 
AND CONVERT(DATE,a.DATEDEALERIN) BETWEEN CONVERT(DATE,'" . $result_seInvoicecode['BILLINGDATE'] . "',103) AND CONVERT(DATE,'" . $result_seInvoicecode['PAYMENTDATE'] . "',103)
AND a.MATERIALTYPE = '" . $result_seInvoicecode['MATERIALTYPE'] . "'
AND a.DOCUMENTCODE != '' 
AND b.BILLINGSTATUS='1'
GROUP BY a.DATEVLIN, a.DATEDEALERIN,a.VEHICLETYPE,a.VEHICLETRANSPORTPLANID,b.JOBSTART,b.JOBEND,b.EMPLOYEENAME1,b.EMPLOYEENAME2,b.VEHICLEREGISNUMBER,a.THAINAME,a.ACTUALPRICE,a.JOBNO,a.C8
ORDER BY a.DATEVLIN ASC";

$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

    $sql_seThainame = " SELECT VEHICLEREGISNUMBER AS 'THAINAME' FROM [dbo].[VEHICLEINFO] WHERE THAINAME ='" .$result_seBilling['THAINAME']. "'  AND ACTIVESTATUS ='1'";
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
    
    $sql_seHoliday = "SELECT HOLIDAY AS 'DATE',BILLINGPRPO AS 'PRODUCT'
        FROM [dbo].[BILLING_HOLIDAY] 
        WHERE INVOICECODE ='".$result_seInvoicecode['INVOICECODE']."'
        AND COMPANYCODE ='".$result_seInvoicecode['COMPANYCODE']."' AND CUSTOMERCODE = '".$result_seInvoicecode['CUSTOMERCODE']."'";
    $params_seHoliday = array();
    $query_seHoliday = sqlsrv_query($conn, $sql_seHoliday, $params_seHoliday);
    $result_seHoliday = sqlsrv_fetch_array($query_seHoliday, SQLSRV_FETCH_ASSOC);


    $holiday = $result_seHoliday['DATE'];
    // $holiday = $result_seHoliday['DATE'];
    $holidaysplit = explode(",", $holiday);

    $product = $result_seHoliday['PRODUCT'];

    // $VAR_VEHICLEREGISNUMBER = "";
    // if ($result_seBilling['VEHICLETYPE'] == '22W(Dump)') {
    //     $sql_seVeh = "SELECT VEHICLEREGISNUMBER FROM [dbo].[VEHICLEINFO] WHERE SUBSTRING(THAINAME,0,7) =
    //     (SELECT DISTINCT SUBSTRING(THAINAME,0,7) FROM [dbo].[VEHICLEINFO] WHERE VEHICLEREGISNUMBER = '" . $result_seBilling['VEHICLEREGISNUMBER'] . "')
    //     AND [VEHICLETYPECODE] = '10W'";

    //     $query_seVeh = sqlsrv_query($conn, $sql_seVeh, $params_seVeh);
    //     $result_seVeh = sqlsrv_fetch_array($query_seVeh, SQLSRV_FETCH_ASSOC);
    //     $VAR_VEHICLEREGISNUMBER = $result_seVeh['VEHICLEREGISNUMBER'];
    // } else {
    //     $VAR_VEHICLEREGISNUMBER = $result_seBilling['VEHICLEREGISNUMBER'];
    // }

    $sql_Sumweight = "SELECT SUM(CONVERT(INT,WEIGHTIN)) AS 'SUMWEIGHTIN',SUM(CONVERT(INT,WEIGHTOUT)) AS 'SUMWEIGHTOUT' 
               FROM [VEHICLETRANSPORTDOCUMENTDIRVER]
               WHERE VEHICLETRANSPORTPLANID ='".$result_seBilling['VEHICLETRANSPORTPLANID']."'";
    $params_Sumweight = array();
    $query_Sumweight = sqlsrv_query($conn, $sql_Sumweight, $params_Sumweight);
    $result_Sumweight = sqlsrv_fetch_array($query_Sumweight, SQLSRV_FETCH_ASSOC);

    if (($result_seBilling['DATEVLIN_103'] == $holidaysplit[0]) || ($result_seBilling['DATEVLIN_103'] == $holidaysplit[1]) || ($result_seBilling['DATEVLIN_103'] == $holidaysplit[2]) || ($result_seBilling['DATEVLIN_103'] == $holidaysplit[3]) || ($result_seBilling['DATEVLIN_103'] == $holidaysplit[4])) {
        $tbody3 .= '

        <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $i . '</td>
            <td  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seBilling['DATE_DEALERIN'] . '</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seEmployeeehr['FnameE'] . '</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seThainame['THAINAME'] . '</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seBilling['JOBSTART'] . '</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seBilling['JOBEND'] . '</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . number_format($result_Sumweight['SUMWEIGHTIN']) . '</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . number_format($result_Sumweight['SUMWEIGHTOUT']) . '</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . number_format($result_seBilling['ACTUALPRICE']) . '</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . number_format($result_seBilling['ACTUALPRICE']) . '</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px"></td>
        </tr>
        <tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px"></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seBilling['DATE_DEALERIN'] . '</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seEmployeeehr['FnameE'] . '</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seThainame['THAINAME'] . '</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seBilling['JOBSTART'] . '</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seBilling['JOBEND'] . '</td>
            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">Holiday</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . number_format(1000) . '</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . number_format(1000) . '</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px"></td>
        </tr>
    ';

        $i++;
        $count ++ ;
        $sumtotalholiday = ($count * 1000);
        $sumgmtweight = $sumgmtweight + $result_Sumweight['SUMWEIGHTIN'];
        $sumcusweight = $sumcusweight + $result_Sumweight['SUMWEIGHTOUT'];
        $sumtotal = $sumtotal + $result_seBilling['ACTUALPRICE'];

    }else if ($result_seBilling['C8'] == 'return'){
     $tbody3 .= '

     <tr style="border:1px solid #000;">
     <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $i . '</td>
     <td  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seBilling['DATE_DEALERIN'] . '</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seEmployeeehr['FnameE'] . '</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seThainame['THAINAME'] . '</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seBilling['JOBEND'] . '</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seBilling['JOBSTART'] . '</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . number_format($result_Sumweight['SUMWEIGHTIN']) . '</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . number_format($result_Sumweight['SUMWEIGHTOUT']) . '</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . number_format(($result_seBilling['ACTUALPRICE']*50)/100) . '</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . number_format(($result_seBilling['ACTUALPRICE']*50)/100) . '</td>
     <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">งานรับกลับ</td>
   </tr>
 ';

     $i++;
     $sumgmtweight = $sumgmtweight + $result_Sumweight['SUMWEIGHTIN'];
     $sumcusweight = $sumcusweight + $result_Sumweight['SUMWEIGHTOUT'];
     $sumtotal_return = $sumtotal_return + $result_seBilling['PRICE_RETURN'];

 }else{
        $tbody3 .= '

        <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $i . '</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seBilling['DATE_DEALERIN'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seEmployeeehr['FnameE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seThainame['THAINAME'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seBilling['JOBSTART'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . $result_seBilling['JOBEND'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . number_format($result_Sumweight['SUMWEIGHTIN']) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . number_format($result_Sumweight['SUMWEIGHTOUT']) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . number_format($result_seBilling['ACTUALPRICE']) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">' . number_format($result_seBilling['ACTUALPRICE']) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px"></td>
      </tr>
    ';

        $i++;
        $sumgmtweight = $sumgmtweight + $result_Sumweight['SUMWEIGHTIN'];
        $sumcusweight = $sumcusweight + $result_Sumweight['SUMWEIGHTOUT'];
        $sumtotal2 = $sumtotal2 + $result_seBilling['ACTUALPRICE'];

    }
    



    
    
}



$tfoot3 = '</tbody><tfoot>
     <tr style="border:1px solid #000;">

        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">PRODUCT : ' . $product . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px"><b>' . number_format($sumgmtweight) . '</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px"><b>' . number_format($sumcusweight) . '</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">-</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px"><b>' . number_format($sumtotal+$sumtotal2+$sumtotalholiday+$sumtotal_return) . '</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px"></td>
            </tr>
    </tfoot>';


$table_end3 = '</table>';

// $table_footer3 = '<br><br><br><br><br><br><table style="width: 100%;">
$table_footer3 = '<br><br><br><br><br><br><table style="width: 100%;">
    <tbody>
       <tr>
            <td style="width: 50%;text-align:center;font-size:30px">........................................ </td>
            <td style="width: 50%;text-align:center;font-size:30px">........................................</td>
       </tr>
        <tr>
            <td style="width: 100%;text-align:center;font-size:30px">ผู้จัดทำ</td>
            <td style="width: 100%;text-align:center;font-size:30px">ผู้ตรวจสอบ</td>
       </tr>
       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>
       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>
       <tr>
            <td style="width: 50%;text-align:center;font-size:30px">........................................ </td>
            <td style="width: 50%;text-align:center;font-size:30px">........................................</td>
       </tr>
        <tr>
            <td style="width: 100%;text-align:center;font-size:30px">ผู้อนุมัติ</td>
            <td style="width: 100%;text-align:center;font-size:30px">ผู้อนุมัติ</td>
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
