<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
$sumgmtweight = "";
$sumcusweight = "";
$sumamounttrip = "";
$sumtotal = "";
$ACTUALPRICE = "";

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

$sql_sumprice = "SELECT SUM(CONVERT(INT,e.PRICE)) AS 'SUMACTUALPRICE'
FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b 
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON b.VEHICLETRANSPORTPRICEID = e.VEHICLETRANSPORTPRICEID
WHERE b.ACTIVESTATUS = '1'
AND (b.JOBSTART='".$result_seInvoicecode['JOBEND']."' OR b.JOBEND = '".$result_seInvoicecode['JOBEND']."')
AND b.COMPANYCODE = '".$result_seInvoicecode['COMPANYCODE']."'
AND b.CUSTOMERCODE = '".$result_seInvoicecode['CUSTOMERCODE']."' 
AND  (b.DOCUMENTCODE != '' OR b.DOCUMENTCODE IS NOT NULL)
AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103)AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103)";
$query_sumprice = sqlsrv_query($conn, $sql_sumprice, $params_sumprice);
$result_sumprice = sqlsrv_fetch_array($query_sumprice, SQLSRV_FETCH_ASSOC);

// $condBilling1 = " AND c.COMPANYCODE = '" . $result_seInvoicecode['COMPANYCODE'] . "' AND c.CUSTOMERCODE = '" . $result_seInvoicecode['CUSTOMERCODE'] . "' AND b.JOBSTART='" . $result_seInvoicecode['TRANSPORTATION'] . "' AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
// $condBilling2 = " AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seInvoicecode['BILLINGDATE'] . "',103) AND CONVERT(DATE,'" . $result_seInvoicecode['PAYMENTDATE'] . "',103) AND b.JOBEND = '".$result_seInvoicecode['JOBEND']."'";




$mpdf = new mPDF('', 'Letter', '', '', 10, 10, 65, 5, 5, 5);

///////////////////งานเหมา //////////////////////////////////////////
if($result_seInvoicecode['JOBEND'] == 'GMT' )
{

$style = '
<style>
	body{
		font-family: "Garuda";font-size:13px//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';
$table_header = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="2" style="text-align:center"><b><font style="font-size: 18px">ใบส่งสินค้า</font></b></td>
    </thead>
    <tbody>
        <tr>
            <td colspan="2">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด (RUAMKIT RECYCLE CARRIER CO.,LTD.)</td>
       </tr>
       <tr>
            <td colspan="2">สำนักงานใหญ่ 109/1 หมู่ที่ 9 ตำบลหัวสำโรง อำเภอแปลงยาว จังหวัดฉะเชิงเทรา</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;">&nbsp;</td>
       </tr>
       <tr>
            <td style="width: 50%;">เลขประจำตัวผู้เสียภาษี 0105551065951</td>
            <td style="width: 50%;text-align:right">เลขที่ ' . $_GET['invoicecode'] . '</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;">&nbsp;</td>
       </tr>
       <tr>
            <td style="width: 50%;">ลูกค้า บจก.กรีน เมทัลส์(ประเทศไทย)</td>
            <td style="width: 50%;text-align:right">วันที่ ' . $result_seInvoicecode['DULYDATE'] . '</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;">ที่อยู่ 254 หมู่7 นิคมอุตสาหกรรมเกตเวย์ซิตี้</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;">ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190</td>
       </tr>
    </tbody>
</table>';

$table_begin = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:14px;margin-top:8px;">';
$thead = '<thead>

         <tr style="border:1px solid #000;">
            <th rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;"><b>No.</th>
            <th rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;">D/M/Y</th>
            <th rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;">Driver</th>
            <th rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 8%;">Truck No</th>
            <th colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;">Delivery</th>
            <th colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 8%;">Weight (Tons)</th>
            <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;width: 8%;">Price</th>
            <th rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 9%;">Total</th>
            <th rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 9%;">Remark</th>
        </tr>
        <tr>
            <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;">From</th>
            <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;">To</th>
            <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">Source<br>weight</th>
            <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">Destination<br>weight</th>
            <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">Bath/Trips</th>
        </tr>
    </thead><tbody>';

}
else
{

// หัวกระดาษ กรณีเลือกข้อมูลเป็น GMT2
$style = '
<style>
	body{
		font-family: "Garuda";font-size:13px//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';
$table_header = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="2" style="text-align:center"><b><font style="font-size: 18px">ใบส่งสินค้า</font></b></td>
    </thead>
    <tbody>
        <tr>
            <td colspan="2">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด (RUAMKIT RECYCLE CARRIER CO.,LTD.)</td>
       </tr>
       <tr>
            <td colspan="2">สำนักงานใหญ่ 109/1 หมู่ที่ 9 ตำบลหัวสำโรง อำเภอแปลงยาว จังหวัดฉะเชิงเทรา</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;">&nbsp;</td>
       </tr>
       <tr>
            <td style="width: 50%;">เลขประจำตัวผู้เสียภาษี 0105551065951</td>
            <td style="width: 50%;text-align:right">เลขที่ ' . $_GET['invoicecode'] . '</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;">&nbsp;</td>
       </tr>
       <tr>
            <td style="width: 50%;">ลูกค้า บจก.กรีน เมทัลส์(ประเทศไทย)</td>
            <td style="width: 50%;text-align:right">วันที่ ' . $result_seInvoicecode['DULYDATE'] . '</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;">ที่อยู่ 219/18 หมู่ที่ 6 นิคมอุตสาหกรรมปิ่นทอง 3</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;">ตำบลบ่อวิน อำเภอศรีราชา จังหวัดชลบุรี 20230</td>
       </tr>
    </tbody>
</table>';

$table_begin = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">';
$thead = '<thead>

         <tr style="border:1px solid #000;">
            <th rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;"><b>No.</th>
            <th rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;">D/M/Y</th>
            <th rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;">Driver</th>
            <th rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 8%;">Truck No</th>
            <th colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;">Delivery</th>
            <th colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 8%;">Weight (Tons)</th>
            <th colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;width: 8%;">Price</th>
            <th rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 9%;">Total</th>
            <th rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 9%;">Remark</th>
        </tr>
        <tr>
            <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;">From</th>
            <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;">To</th>
            <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">Source<br>weight</th>
            <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">Destination<br>weight</th>
            <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 8%;">Bath/Trips</th>
        </tr>
    </thead><tbody>';
}

$i = 1;

 $sql_seBilling = "SELECT DISTINCT CONVERT(NVARCHAR(6),CONVERT(DATE,b.DATEVLIN,103),3)+''+RIGHT(CONVERT(NVARCHAR(4),CONVERT(DATE,b.DATEVLIN,103))+543,2) AS 'DATE_VLIN',
        a.VEHICLEREGISNUMBER AS 'VEHICLEREGISNUMBER',b.ACTUALPRICE AS 'ACTUALPRICE',b.EMPLOYEECODE1,b.EMPLOYEENAME1,c.FnameE,b.DATEVLIN,
        CONVERT(VARCHAR(10), b.DATEVLIN, 103) AS 'DATE_CHK',
        CONVERT(VARCHAR(10), b.DATEDEALERIN, 6)  AS 'DATE_DEALERIN'
        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
        INNER JOIN [dbo].[EMPLOYEEEHR2] c ON c.PersonCode = b.EMPLOYEECODE1
        WHERE b.ACTIVESTATUS = '1'
        AND b.COMPANYCODE = 'RRC'
        AND b.CUSTOMERCODE = 'GMT-IB' 
        AND (b.JOBSTART='".$result_seInvoicecode['JOBEND']."' OR b.JOBEND = '".$result_seInvoicecode['JOBEND']."')
        AND  (a.DOCUMENTCODE != '' OR a.DOCUMENTCODE IS NOT NULL)
        AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103)AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103)
        ORDER BY b.DATEVLIN ASC";
$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {



    // $sql_seVehicleregisnumber = "SELECT VEHICLEREGISNUMBER FROM [dbo].[VEHICLEINFO]
    // WHERE SUBSTRING(THAINAME,0,7) = SUBSTRING((SELECT DISTINCT SUBSTRING(THAINAME, 0, 7) FROM [dbo].[VEHICLEINFO] WHERE VEHICLEREGISNUMBER = '" . $result_seBilling['VEHICLEREGISNUMBER'] . "'), 0, 7)
    // AND (VEHICLETYPECODE = '10W' OR VEHICLETYPECODE = 'Semi Trailer' OR VEHICLETYPECODE = 'Trailer' OR VEHICLETYPECODE = 'Semitrailer' OR VEHICLETYPECODE = '10W(TTAST)')";
    // $query_seVehicleregisnumber = sqlsrv_query($conn, $sql_seVehicleregisnumber, $params_seVehicleregisnumber);
    // $result_seVehicleregisnumber = sqlsrv_fetch_array($query_seVehicleregisnumber, SQLSRV_FETCH_ASSOC);

    // $sql_seDo = "SELECT COUNT(*) AS 'rs' FROM [VEHICLETRANSPORTDOCUMENTDIRVER] a
    // INNER JOIN [VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
    // WHERE b.JOBNO = '" . $result_seBilling['JOBNO'] . "'";
    // $query_seDo = sqlsrv_query($conn, $sql_seDo, $params_seDo);
    // $result_seDo = sqlsrv_fetch_array($query_seDo, SQLSRV_FETCH_ASSOC);

    // $condBilling1 = " AND c.COMPANYCODE = '" . $result_seInvoicecode['COMPANYCODE'] . "' AND c.CUSTOMERCODE = '" . $result_seInvoicecode['CUSTOMERCODE'] . "' AND b.JOBSTART='" . $result_seInvoicecode['TRANSPORTATION'] . "' AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
    // $condBilling2 = " AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seInvoicecode['BILLINGDATE'] . "',103) AND CONVERT(DATE,'" . $result_seInvoicecode['PAYMENTDATE'] . "',103) AND b.JOBEND = '".$result_seInvoicecode['JOBEND']."'";



    $ACTUALPRICE = ($result_seBilling['ACTUALPRICE'] != "") ? number_format($result_seBilling['ACTUALPRICE']) : "";

    $tbody .= '<tr style="border:1px solid #000;">
                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $i . '</td>
                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['DATE_DEALERIN'] . '</td>

                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['FnameE'] . '</td>';
           
    $tbody .= '
                </td>
                <td style="border-right:1px solid #000;padding:4px;text-align:center;" >' . $result_seBilling['VEHICLEREGISNUMBER'] . '</td>
                <td style="border-right:1px solid #000;padding:4px;text-align:center;">
                <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;">';
   
   $sql_seBilling3 = "SELECT b.JOBSTART
        FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b 
        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
        WHERE b.ACTIVESTATUS = '1'
        AND b.EMPLOYEECODE1 ='".$result_seBilling['EMPLOYEECODE1']."'
        AND (b.JOBSTART='".$result_seInvoicecode['JOBEND']."' OR b.JOBEND = '".$result_seInvoicecode['JOBEND']."')
        AND  (b.DOCUMENTCODE != '' OR b.DOCUMENTCODE IS NOT NULL)
        AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seBilling['DATE_CHK']."',103)AND CONVERT(DATE,'".$result_seBilling['DATE_CHK']."',103)
        ORDER BY b.WEIGHTIN,b.[VEHICLETRANSPORTDOCUMENTDRIVERID] ASC";
    $query_seBilling3 = sqlsrv_query($conn, $sql_seBilling3, $params_seBilling3);
    while ($result_seBilling3 = sqlsrv_fetch_array($query_seBilling3, SQLSRV_FETCH_ASSOC)) {
        $tbody .= '<tr><td style="padding:4px;text-align:center;">' . $result_seBilling3['JOBSTART'] . '</td></tr>';
    }
    
    $tbody .= '</table>
                <td style="border-right:1px solid #000;padding:4px;text-align:center;">
                <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;">';
   
        $sql_seBilling3 = "SELECT b.JOBEND
                FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b 
                INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
                WHERE b.ACTIVESTATUS = '1'
                AND b.EMPLOYEECODE1 ='".$result_seBilling['EMPLOYEECODE1']."'
                AND (b.JOBSTART='".$result_seInvoicecode['JOBEND']."' OR b.JOBEND = '".$result_seInvoicecode['JOBEND']."')
                AND  (b.DOCUMENTCODE != '' OR b.DOCUMENTCODE IS NOT NULL)
                AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seBilling['DATE_CHK']."',103)AND CONVERT(DATE,'".$result_seBilling['DATE_CHK']."',103)
                ORDER BY b.WEIGHTIN,b.[VEHICLETRANSPORTDOCUMENTDRIVERID] ASC";
            $query_seBilling3 = sqlsrv_query($conn, $sql_seBilling3, $params_seBilling3);
            while ($result_seBilling3 = sqlsrv_fetch_array($query_seBilling3, SQLSRV_FETCH_ASSOC)) {
                
                $tbody .= '<tr><td style="padding:4px;text-align:center;">' . $result_seBilling3['JOBEND'] . '</td></tr>';
            }

    $tbody .= '</table>
            </td>
            
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">
            <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;">';
            $sql_seBilling5 = "SELECT b.WEIGHTIN
                FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b 
                INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
                WHERE b.ACTIVESTATUS = '1'
                AND b.EMPLOYEECODE1 ='".$result_seBilling['EMPLOYEECODE1']."'
                AND (b.JOBSTART='".$result_seInvoicecode['JOBEND']."' OR b.JOBEND = '".$result_seInvoicecode['JOBEND']."')
                AND  (b.DOCUMENTCODE != '' OR b.DOCUMENTCODE IS NOT NULL)
                AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seBilling['DATE_CHK']."',103)AND CONVERT(DATE,'".$result_seBilling['DATE_CHK']."',103)
                ORDER BY b.WEIGHTIN,b.[VEHICLETRANSPORTDOCUMENTDRIVERID] ASC";
            $query_seBilling5 = sqlsrv_query($conn, $sql_seBilling5, $params_seBilling5);
            while ($result_seBilling5 = sqlsrv_fetch_array($query_seBilling5, SQLSRV_FETCH_ASSOC)) {
                $tbody .= '<tr><td style="padding:4px;text-align:center;">' . number_format($result_seBilling5['WEIGHTIN']) . '</td></tr>';
                $sumcusweightin = $sumcusweightin + (int) $result_seBilling5['WEIGHTIN'];
            }
            $tbody .= '</table>
            </td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">
            <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;">';
            $sql_seBilling4 = "SELECT b.WEIGHTOUT
                FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b 
                INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
                WHERE b.ACTIVESTATUS = '1'
                AND b.EMPLOYEECODE1 ='".$result_seBilling['EMPLOYEECODE1']."'
                AND (b.JOBSTART='".$result_seInvoicecode['JOBEND']."' OR b.JOBEND = '".$result_seInvoicecode['JOBEND']."')
                AND  (b.DOCUMENTCODE != '' OR b.DOCUMENTCODE IS NOT NULL)
                AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seBilling['DATE_CHK']."',103)AND CONVERT(DATE,'".$result_seBilling['DATE_CHK']."',103)
                ORDER BY b.WEIGHTIN,b.[VEHICLETRANSPORTDOCUMENTDRIVERID] ASC";
            $query_seBilling4 = sqlsrv_query($conn, $sql_seBilling4, $params_seBilling4);
            while ($result_seBilling4 = sqlsrv_fetch_array($query_seBilling4, SQLSRV_FETCH_ASSOC)) {
                $tbody .= '<tr><td style="padding:4px;text-align:center;">' . number_format($result_seBilling4['WEIGHTOUT']) . '</td></tr>';
                $sumcusweightout = $sumcusweightout + $result_seBilling4['WEIGHTOUT'];
            }
            $tbody .= '</table>

                </td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;">
            <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;">';
            $sql_seBilling4 = "SELECT e.PRICE AS 'ACTUALPRICE'
                FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b 
                INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
                INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON b.VEHICLETRANSPORTPRICEID = e.VEHICLETRANSPORTPRICEID
                WHERE b.ACTIVESTATUS = '1'
                AND b.EMPLOYEECODE1 ='".$result_seBilling['EMPLOYEECODE1']."'
                AND (b.JOBSTART='".$result_seInvoicecode['JOBEND']."' OR b.JOBEND = '".$result_seInvoicecode['JOBEND']."')
                AND  (b.DOCUMENTCODE != '' OR b.DOCUMENTCODE IS NOT NULL)
                AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seBilling['DATE_CHK']."',103)AND CONVERT(DATE,'".$result_seBilling['DATE_CHK']."',103)
                ORDER BY b.WEIGHTIN,b.[VEHICLETRANSPORTDOCUMENTDRIVERID] ASC";
            $query_seBilling4 = sqlsrv_query($conn, $sql_seBilling4, $params_seBilling4);
            while ($result_seBilling4 = sqlsrv_fetch_array($query_seBilling4, SQLSRV_FETCH_ASSOC)) {
                $tbody .= '<tr><td style="padding:4px;text-align:center;">' . number_format($result_seBilling4['ACTUALPRICE']) . '</td></tr>';
                $sumcusprice= $sumcusprice + $result_seBilling4['ACTUALPRICE'];
            }
            $tbody .= '</table>
            </td>
            
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;">';
            $sql_seBilling4 = "SELECT e.PRICE AS 'ACTUALPRICE'
                FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b 
                INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
                INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON b.VEHICLETRANSPORTPRICEID = e.VEHICLETRANSPORTPRICEID
                WHERE b.ACTIVESTATUS = '1'
                AND b.EMPLOYEECODE1 ='".$result_seBilling['EMPLOYEECODE1']."'
                AND (b.JOBSTART='".$result_seInvoicecode['JOBEND']."' OR b.JOBEND = '".$result_seInvoicecode['JOBEND']."')
                AND  (b.DOCUMENTCODE != '' OR b.DOCUMENTCODE IS NOT NULL)
                AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seBilling['DATE_CHK']."',103)AND CONVERT(DATE,'".$result_seBilling['DATE_CHK']."',103)
                ORDER BY b.WEIGHTIN,b.[VEHICLETRANSPORTDOCUMENTDRIVERID] ASC";
            $query_seBilling4 = sqlsrv_query($conn, $sql_seBilling4, $params_seBilling4);
            while ($result_seBilling4 = sqlsrv_fetch_array($query_seBilling4, SQLSRV_FETCH_ASSOC)) {
                $tbody .= '<tr><td style="padding:4px;text-align:center;">' . number_format($result_seBilling4['ACTUALPRICE']) . '</td></tr>';
                $sumcusprice= $sumcusprice + $result_seBilling4['ACTUALPRICE'];
            }
            $tbody .= '</table></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            
        </tr>
    ';

    $i++;

    $sumtotal = $sumtotal + (int) $sumcusprice;

}

$tfoot = '</tbody> <tfoot>
            <tr style="border:1px solid #000;">
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>รวม</b></td>
                <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($sumcusweightin, 0) . '</td>
                <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($sumcusweightout, 0) . '</td>
                <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            </tr>
            <tr style="border:1px solid #000;">
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ยอดสุทธิ</b></td>
                <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . convert($result_sumprice['SUMACTUALPRICE']) . '</b></td>
                <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . number_format($result_sumprice['SUMACTUALPRICE'] , 0) . '</b></td>
                <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . number_format($result_sumprice['SUMACTUALPRICE'] , 0) . '</b></td>
                <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            </tr>
        </tfoot>';


$table_end = '</table>';

$table_footer = '<br><br><br><br><table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
    <tbody>
       <tr>
            <td style="width: 50%;text-align:center;font-size:22px">........................................ </td>
            <td style="width: 50%;text-align:center;font-size:22px">........................................</td>
       </tr>
        <tr>
            <td style="width: 100%;text-align:center;font-size:22px">ผู้จัดทำ</td>
            <td style="width: 100%;text-align:center;font-size:22px">ผู้ตรวจสอบ</td>
       </tr>
       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>
       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>
       <tr>
            <td style="width: 50%;text-align:center;font-size:22px">........................................ </td>
            <td style="width: 50%;text-align:center;font-size:22px">........................................</td>
       </tr>
        <tr>
            <td style="width: 100%;text-align:center;font-size:22px">ผู้อนุมัติ</td>
            <td style="width: 100%;text-align:center;font-size:22px">ผู้อนุมัติ</td>
       </tr>
    </tbody>
</table>';


$mpdf->SetHTMLHeader($table_header, 'O', true);
$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_begin);
$mpdf->WriteHTML($thead);
$mpdf->WriteHTML($tbody);
$mpdf->WriteHTML($tfoot);
$mpdf->WriteHTML($table_end);
$mpdf->SetHTMLFooter($table_footer);
$mpdf->Output();



sqlsrv_close($conn);
?>
