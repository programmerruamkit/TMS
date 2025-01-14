<?php

require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
$sumgmtweight = "";
$sumcusweight = "";
$sumamounttrip = "";
$sumtotal = "";
$ACTUALPRICE = "";
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




$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,INVOICECODE,COMPANYCODE,CUSTOMERCODE,TRANSPORTATION,JOBEND,MATERIALTYPE,DULYDATE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '".$_GET['invoicecode']."'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);



$condBilling1 = " AND c.COMPANYCODE = '".$result_seInvoicecode['COMPANYCODE']."' AND c.CUSTOMERCODE = '".$result_seInvoicecode['CUSTOMERCODE']."' AND b.JOBSTART='".$result_seInvoicecode['TRANSPORTATION']."' AND INVOICECODE = '".$_GET['invoicecode']."'";
$condBilling2 = " AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103) ";




$mpdf = new mPDF('', 'Letter', '', '', 10, 10, 75, 5, 5, 5);
$style = '
<style>
	body{
		font-family: "angsanaupc";font-size:13px//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';
$table_header = '<table style="width: 100%;">
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
            <td colspan="2">&nbsp;</td>
       </tr>
       <tr>
            <td style="width: 50%;font-size:22px">เลขประจำตัวผู้เสียภาษี 0105551065951</td>
            <td style="width: 50%;text-align:right;font-size:22px">เลขที่ '.$_GET['invoicecode'].'</td>
       </tr>

       <tr>
            <td style="width: 50%;font-size:22px">บจก.บายโปรดักส์สตีล</td>
            <td style="width: 50%;text-align:right;font-size:22px">วันที่ ' . $result_getDate['SYSDATE'] . '</td>
       </tr>
       <tr>
            <td colspan="2" style="width: 50%;font-size:22px">ที่อยู่ 88 หมู่ 6 ถนนสัตตพงษ์ ตำบลดอนหัวฬ่อ อำเภอเมืองชลบุรี จังหวัดชลบุรี 20000</td>
       </tr>


    </tbody>
</table>';

$table_begin = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;margin-top:8px;">';
$thead = '<thead>

         <tr style="border:1px solid #000;">
            <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;" rowspan="2"><b>No.</th>
            <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;" rowspan="2">D / M / Y</th>
            <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;" rowspan="2">Driver</th>
            <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;" rowspan="2">Truck No.</th>
            <th style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">Delivery</th>
            <th style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">Weight(Tons)</th>
            <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">Price</th>
            <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;" rowspan="2">Total</th>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 7%;" ><b>From</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 7%;" ><b>To</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 7%;" ><b>BP weight</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 7%;" ><b>CUS weight</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" ><b>Bath/Trips</b></td>
    </tr>
    </thead><tbody>';

$i = 1;


$sql_seBilling = "SELECT DISTINCT CONVERT(NVARCHAR(6),CONVERT(DATE,b.DATEVLHEAD,103),6)+' '+RIGHT(CONVERT(NVARCHAR(4),CONVERT(DATE,b.DATEVLHEAD,103))+543,2) AS 'DATE_VLIN',
b.VEHICLEREGISNUMBERHEAD AS 'VEHICLEREGISNUMBER',b.JOBSTARTHEAD AS 'JOBSTART', b.JOBENDHEAD AS 'JOBEND',b.WEIGHTIN,
b.WEIGHTOUT,c.ACTUALPRICE AS 'ACTUALPRICE',b.EMPLOYEENAME1, b.EMPLOYEECODE2,b.EMPLOYEEHEAD,c.[VEHICLETYPE],c.VEHICLETRANSPORTPLANID,b.DOCUMENTCODE,QTHEAD
FROM [dbo].[LOGINVOICE] a
INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.VEHICLETRANSPORTPRICEID = e.VEHICLETRANSPORTPRICEID
INNER JOIN [dbo].[COMPANYEHR] d ON b.COMPANYCODE = d.Company_Code
WHERE 1 = 1 AND c.STATUSNUMBER != '0'" . $condBilling1 . $condBilling2;



$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

    $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
    $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmployeeehr = array(
        array('select_employeeehr2', SQLSRV_PARAM_IN),
        array($condEmployeeehr1, SQLSRV_PARAM_IN)
    );
    $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
    $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);

    $sql_seVehicleregisnumber = "SELECT VEHICLEREGISNUMBER FROM [dbo].[VEHICLEINFO]
    WHERE SUBSTRING(THAINAME,0,7) = SUBSTRING((SELECT DISTINCT SUBSTRING(THAINAME, 0, 7) FROM [dbo].[VEHICLEINFO] WHERE VEHICLEREGISNUMBER = '".$result_seBilling['VEHICLEREGISNUMBER']."' AND ACTIVESTATUS ='1'), 0, 7)
    AND VEHICLETYPECODE = '10W' ";
    $query_seVehicleregisnumber = sqlsrv_query($conn, $sql_seVehicleregisnumber, $params_seVehicleregisnumber);
    $result_seVehicleregisnumber = sqlsrv_fetch_array($query_seVehicleregisnumber, SQLSRV_FETCH_ASSOC);

    $tbody .= '<tr style="border:1px solid #000;">
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:16px">' . $i . '</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:16px">' . $result_seBilling['DATE_VLIN'] . '</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:16px">' . $result_seEmployeeehr['nameE'] . '</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:16px">' . $result_seVehicleregisnumber['VEHICLEREGISNUMBER'] . '</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:16px">' . $result_seBilling['JOBSTART'] . '</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:16px">' . $result_seBilling['JOBEND'] . '</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:16px">' . $result_seBilling['WEIGHTIN'] . '</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:16px">' . $result_seBilling['WEIGHTOUT'] . '</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:16px">' . number_format($result_seBilling['ACTUALPRICE']) . '</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:16px">' . number_format($result_seBilling['ACTUALPRICE']) .'</td>
                                                        </tr>
    ';
    $i++;
    $sumcusweightin = $sumcusweightin + $result_seBilling['WEIGHTIN'];
    $sumcusweightout = $sumcusweightout + $result_seBilling['WEIGHTOUT'];
    $sumtotal = $sumtotal+(int)$result_seBilling['ACTUALPRICE'];
    $planid = $planid . $result_seBilling['VEHICLETRANSPORTPLANID'] . "','";

}
$MATERIALTYPE = "";
 $sql_seMaterialtype = "SELECT DISTINCT MATERIALTYPE FROM [dbo].[VEHICLETRANSPORTPLAN]
                            WHERE VEHICLETRANSPORTPLANID IN ('" . $planid . "')";
                                        $query_seMaterialtype = sqlsrv_query($conn, $sql_seMaterialtype, $params_seMaterialtype);
                                        while ($result_seMaterialtype = sqlsrv_fetch_array($query_seMaterialtype, SQLSRV_FETCH_ASSOC)) {
                                            $MATERIALTYPE = $MATERIALTYPE.$result_seMaterialtype['MATERIALTYPE']."<br>";

                                        }
$tfoot = '</tbody> <tfoot>
                                                    <tr style="border:1px solid #000;">
                                                        <td style="padding:4px;text-align:center;font-size:18px"></td>
                                                        <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:left;font-size:18px">PRODUCT : เหล็กชิ้นเล็ก,เหล็กแผ่นตัก MD,Shredded A-MC,Cut Plate MC</td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px"><b>' . $sumcusweightin . '</b></td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px"><b>' . $sumcusweightout . '</b></td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px"></td>
                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px"><b>'.number_format($sumtotal).'</b></td>

                                                    </tr>

                                                </tfoot>';


$table_end = '</table>';

$table_footer = '<br><br><table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
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

$mpdf->SetHTMLHeader($table_header, 'O', true);
$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_begin);
$mpdf->WriteHTML($thead);
$mpdf->WriteHTML($tbody);
$mpdf->WriteHTML($tfoot);
$mpdf->WriteHTML($table_end);
$mpdf->WriteHTML($table_footer);
$mpdf->Output();



sqlsrv_close($conn);
?>
