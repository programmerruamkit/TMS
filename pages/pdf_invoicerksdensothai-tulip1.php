<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");


$mpdf = new mPDF('th', 'A4', '0', '');

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


$condBilling1 = " AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
$condBilling2 = "";
$condBilling3 = "";

$sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seBillings = array(
    array('select_pdfvehicletransportdocumentdriver-densothai1', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN),
    array($condBilling3, SQLSRV_PARAM_IN)
);
$query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
$result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);


$sql_seData11 = "SELECT JOBSTART FROM VEHICLETRANSPORTDOCUMENTDIRVER WHERE DOCUMENTCODE = '" . $result_seBillings['DOCUMENTCODE'] . "' AND RIGHT(JOBSTART,3) != '(N)'";
$query_seData11 = sqlsrv_query($conn, $sql_seData11, $params_seData11);
$result_seData11 = sqlsrv_fetch_array($query_seData11, SQLSRV_FETCH_ASSOC);

$sql_seMinvldate = "SELECT CONVERT(VARCHAR(10), MIN(VLINDATE), 103) AS 'MINDATEVLIN_103'
FROM [dbo].[LOGINVOICE]
WHERE 1 = 1 AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
$query_seMinvldate = sqlsrv_query($conn, $sql_seMinvldate, $params_seMinvldate);
$result_seMinvldate = sqlsrv_fetch_array($query_seMinvldate, SQLSRV_FETCH_ASSOC);

$sql_seMaxvldate = "SELECT CONVERT(VARCHAR(10), MAX(VLINDATE), 103) AS 'MAXDATEVLIN_103'
FROM [dbo].[LOGINVOICE]
WHERE 1 = 1 AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
$query_seMaxvldate = sqlsrv_query($conn, $sql_seMaxvldate, $params_seMaxvldate);
$result_seMaxvldate = sqlsrv_fetch_array($query_seMaxvldate, SQLSRV_FETCH_ASSOC);

// $condInvoice1 = " AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
// $condInvoice2 = "";
// $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
// $params_seInvoice = array(
//     array('select_loginvoice', SQLSRV_PARAM_IN),
//     array($condInvoice1, SQLSRV_PARAM_IN),
//     array($condInvoice2, SQLSRV_PARAM_IN)
// );
// $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
// $result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC);

$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,INVOICECODE,INVOICEADTH,INVOICEBPK1,INVOICEBPK2,INVOICEASTH,INVOICEDSTH
FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '".$_GET['invoicecode']."'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);



$style = '
<style>
	body{
		font-family: "Garuda";font-size:12px//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	  }
         #rotated {
             position: absolute;
             top: 280mm;
             left: 15mm;
             width: 300mm;
             height: 40mm;
         }
</style>';



////////////////////////////////////////บริษัท อันเด็น ประเทศไทย////////////////////////////////////////////////////////////////

    $table_headerADTH = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;padding:4px;">
<td colspan="2" style="font-size:14;" align="center">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด<br><br>สำนักงานใหญ่ เลขที่ 51 ม.4 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี  20160<br><br>โทร .038 452824-5 โทรสาร .038-210396</td>
</tr>

<tr style="border:1px solid #000;">
<td colspan="2" align="center" style="font-size:16px;padding:5px;">ใบส่งของ (DELIVERY BILL)</td>
</tr>
<tr style="border:1px solid #000;padding:4px;">
<td style="border-right:1px solid #000;padding:5px;width:80%"><b>วันที่ ' . $result_seMinvldate['MINDATEVLIN_103'] . ' - ' . $result_seMaxvldate['MAXDATEVLIN_103'] . '</b></td>
<td><b>เลขที่ ' . $result_seInvoicecode['INVOICEADTH'] . '</b></td>
</tr>
<tr style="border:1px solid #000;padding:4px;">
<td style="font-size:14;" colspan="2" align="center"><br>บริษัท อันเด็น  (ประเทศไทย) จำกัด <br><br>
700/87 หมู่ 1 ถ.บางนา-ตราด กม.57 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160<br><br><br>
</td>
</tr>
<tr style="border:1px solid #000;">
<td style="padding:5px;font-size:14;" colspan="2" align="center"><b>' . $result_seData11['JOBSTART'] . '</b></td>
</tr>
</tbody>
</table>
';

    $table_beginADTH  = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
<thead>

<tr style="border:1px solid #000;padding:4px;">

<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ลำดับที่</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>วันที่</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><strong>ทะเบียนรถ</strong></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>พนักงานขับรถ</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>หมายเลขเส้นทาง</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ประเภทรถ</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>จำนวนเงิน(บาท)</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>หมายเหตุ</b></td>
</tr>
</thead><tbody>';
    $i1 = 1;
    $condBillingADTH1 = " AND c.COMPANYCODE ='RKS' AND c.CUSTOMERCODE='DENSO-THAI' AND a.DOCUMENTCODE ='".$result_seBillings['DOCUMENTCODE']."'";
    $condBillingADTH2 = " AND c.BILLINGDENSO1 !='' AND c.BILLINGDENSO1 != '0' AND c.BILLINGDENSO1 != '-' AND c.BILLINGDENSO1 IS NOT NULL ";
    $condBillingADTH3 = " AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seBillings['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seBillings['PAYMENTDATE']."',103)";


    $sql_seBillingADTHchk = "SELECT COUNT (b.VEHICLETRANSPORTPLANID) AS 'COUNT'
    FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
    INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.[VEHICLETRANSPORTPRICEID] = b.[VEHICLETRANSPORTPRICEID]
    WHERE 1 = 1
    AND a.COMPANYCODE ='RKS' AND a.CUSTOMERCODE='DENSO-THAI' AND a.DOCUMENTCODE ='".$result_seBillings['DOCUMENTCODE']."'
    AND c.BILLINGDENSO5 !='' AND c.BILLINGDENSO1 != '0' AND c.BILLINGDENSO1 != '-' AND c.BILLINGDENSO1 IS NOT NULL
    AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seBillings['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seBillings['PAYMENTDATE']."',103)";
    $params_seBillingADTHchk = array();
    $query_seBillingADTHchk = sqlsrv_query($conn, $sql_seBillingADTHchk, $params_seBillingADTHchk);
    while ($result_seBillingADTHchk = sqlsrv_fetch_array($query_seBillingADTHchk, SQLSRV_FETCH_ASSOC)) {
      $COUNTADTH = $result_seBillingADTHchk['COUNT'];
    }

    $sql_seBillingADTH = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
    $params_seBillingADTH = array(
        array('select_pdfvehicletransportdocumentdriver-densothai', SQLSRV_PARAM_IN),
        array($condBillingADTH1, SQLSRV_PARAM_IN),
        array($condBillingADTH2, SQLSRV_PARAM_IN),
        array($condBillingADTH3, SQLSRV_PARAM_IN)
    );

    $query_seBillingADTH = sqlsrv_query($conn, $sql_seBillingADTH, $params_seBillingADTH);
    while ($result_seBillingADTH = sqlsrv_fetch_array($query_seBillingADTH, SQLSRV_FETCH_ASSOC)) {
       $ADTH = $result_seBillingADTH['VEHICLETRANSPORTPLANID'];

        // $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "' ";
        // $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
        // $params_seEmployeeehr = array(
        //     array('select_employee', SQLSRV_PARAM_IN),
        //     array($condEmployeeehr1, SQLSRV_PARAM_IN)
        // );
        // $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
        // $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);


        // $sql_seData1 = "SELECT VEHICLETRANSPORTPLANID,ACTUALPRICE FROM VEHICLETRANSPORTDOCUMENTDIRVER WHERE DOCUMENTCODE = '" . $result_seBilling['DOCUMENTCODE'] . "'";
        // $query_seData1 = sqlsrv_query($conn, $sql_seData1, $params_seData1);
        // $result_seData1 = sqlsrv_fetch_array($query_seData1, SQLSRV_FETCH_ASSOC);
        //
        //
        // $sql_seData2 = "SELECT CONVERT(VARCHAR(10), a.DATEVLIN, 103) AS 'DATEVLIN_103',a.THAINAME,a.EMPLOYEENAME1,a.VEHICLETYPE,a.VEHICLETRANSPORTPRICEID FROM VEHICLETRANSPORTPLAN a
        //             WHERE a.VEHICLETRANSPORTPLANID = '" . $result_seData1['VEHICLETRANSPORTPLANID'] . "'";
        // $query_seData2 = sqlsrv_query($conn, $sql_seData2, $params_seData2);
        // $result_seData2 = sqlsrv_fetch_array($query_seData2, SQLSRV_FETCH_ASSOC);
        //
        // $sql_seData3 = "SELECT a.ROUTEDESCRIPTION,a.VEHICLETYPE,ROUTETYPE FROM VEHICLETRANSPORTPRICE a
        //             WHERE a.VEHICLETRANSPORTPRICEID = '" . $result_seData2['VEHICLETRANSPORTPRICEID'] . "'";
        // $query_seData3 = sqlsrv_query($conn, $sql_seData3, $params_seData3);
        // $result_seData3 = sqlsrv_fetch_array($query_seData3, SQLSRV_FETCH_ASSOC);

   $tbodyADTH  .= '
 <tr style="border:1px solid #000;">
 <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $i1 . '</td>
 <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingADTH['DATEVLIN_103'] . '</td>
 <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingADTH['THAINAME'] . '</td>
 <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seBillingADTH['EMPLOYEENAME1'] . '</td>
 <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingADTH['ROUTEDESCRIPTION'] . '</td>
 <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingADTH['VEHICLETYPE'] . '</td>
 <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingADTH['BILLINGDENSO1'] . '</td>
 <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingADTH['JOBEND'] . '</td>
 </tr>
 ';
   $i1++;
   $sumtotalADTH = $sumtotalADTH + $result_seBillingADTH['BILLINGDENSO1'];
 }

 $tfootADTH  = '</tbody><tfoot>
 <tr style="border:1px solid #000;">
 <td style="border-right:1px solid #000;padding:4px;text-align:center;">รวมทั้งสิ้น</td>
 <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($i1 - 1) . '</td>
 <td style="border-right:1px solid #000;padding:4px;text-align:center;">เที่ยว</td>
 <td style="border-right:1px solid #000;padding:4px;text-align:center;">รวมเป็นเงินทั้งสิ้น</td>
 <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . convert($sumtotalADTH) . '</td>
 <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . number_format($sumtotalADTH) . '</td>
 <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
 </tr>
 <tr style="border:1px solid #000;">

 <td colspan="4" style="padding:4px;text-align:center;"><br><br>ผู้รับของ. ______________________________________
 <br><br><br> วันที่.  ........................./......................../....................

 </td><br><br><br>
 <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br>ผู้ส่งของ. ______________________________________
 <br><br><br> วันที่.  ........................./......................../....................
 </td><br><br><br>

 </tr>
 </tfoot></table>';



 $tfoot1 = '
 </tbody><tfoot>
 <div id="rotated">
 <tr style="border:1px solid #000;">
 <td colspan="4" style="padding:4px;text-align:center;">FM-OPS-15/09</td>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
 <td colspan="4" style="padding:4px;text-align:center;">แก้ไขครั้งที่ : 00</td>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
 <td colspan="2" style="padding:4px;text-align:center;">มีผลบังคับใช้ : 01-02-49</td>
 </tr>
 </div>
 </tfoot></table>';



 // ////////////////////////////////////////บริษัท เด็นโซ่ ประเทศไทย (บางประกง) K'จำนงค์////////////////////////////////////////////////////////////////

     $table_headerBPK1 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">
 <tbody>
 <tr style="border:1px solid #000;padding:4px;">
 <td colspan="2" style="font-size:14;" align="center">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด<br><br> 51 ม.4 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี  20160<br><br>โทร .038 452824-5 โทรสาร .038-210396</td>
 </tr>

 <tr style="border:1px solid #000;">
 <td colspan="2" align="center" style="font-size:16px;padding:5px;">ใบส่งของ (DELIVERY BILL)</td>
 </tr>
 <tr style="border:1px solid #000;padding:4px;">
 <td style="border-right:1px solid #000;padding:5px;width:80%"><b>วันที่ ' . $result_seMinvldate['MINDATEVLIN_103'] . ' - ' . $result_seMaxvldate['MAXDATEVLIN_103'] . '</b></td>
 <td><b>เลขที่ ' . $result_seInvoicecode['INVOICEBPK1'] . '</b></td>
 </tr>
 <tr style="border:1px solid #000;padding:4px;">
 <td style="font-size:14;" colspan="2" align="center"><br>บริษัท เด็นโซ่ (ประเทศไทย) จำกัด <br><br>
 700/87 หมู่ 1 ถ.บางนา-ตราด กม.57 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160<br><br><br>
 </td>
 </tr>
 <tr style="border:1px solid #000;">
 <td style="padding:5px;font-size:14;" colspan="2" align="center"><b>' . $result_seData11['JOBSTART'] . '</b></td>
 </tr>
 </tbody>
 </table>
 ';

     $table_beginBPK1  = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
 <thead>

 <tr style="border:1px solid #000;padding:4px;">

 <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ลำดับที่</b></td>
 <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>วันที่</b></td>
 <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><strong>ทะเบียนรถ</strong></td>
 <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>พนักงานขับรถ</b></td>
 <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>หมายเลขเส้นทาง</b></td>
 <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ประเภทรถ</b></td>
 <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>จำนวนเงิน(บาท)</b></td>
 <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>หมายเหตุ</b></td>
 </tr>
 </thead><tbody>';
     $i2 = 1;
     $condBillingBPK1 = " AND c.COMPANYCODE ='RKS' AND c.CUSTOMERCODE='DENSO-THAI' AND a.DOCUMENTCODE ='".$result_seBillings['DOCUMENTCODE']."'";
     $condBillingBPK2 = " AND c.BILLINGDENSO2 !='' AND c.BILLINGDENSO2 != '0' AND c.BILLINGDENSO2 != '-' AND c.BILLINGDENSO2 IS NOT NULL ";
     $condBillingBPK3 = " AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seBillings['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seBillings['PAYMENTDATE']."',103)";

     $sql_seBillingBPK1chk = "SELECT COUNT (b.VEHICLETRANSPORTPLANID) AS 'COUNT'
     FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
     INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
     INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.[VEHICLETRANSPORTPRICEID] = b.[VEHICLETRANSPORTPRICEID]
     WHERE 1 = 1
     AND a.COMPANYCODE ='RKS' AND a.CUSTOMERCODE='DENSO-THAI' AND a.DOCUMENTCODE ='".$result_seBillings['DOCUMENTCODE']."'
     AND c.BILLINGDENSO2 !='' AND c.BILLINGDENSO2 != '0' AND c.BILLINGDENSO2 != '-' AND c.BILLINGDENSO2 IS NOT NULL
     AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seBillings['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seBillings['PAYMENTDATE']."',103)";
     $params_seBillingBPK1chk = array();
     $query_seBillingBPK1chk = sqlsrv_query($conn, $sql_seBillingBPK1chk, $params_seBillingBPK1chk);
     while ($result_seBillingBPK1chk = sqlsrv_fetch_array($query_seBillingBPK1chk, SQLSRV_FETCH_ASSOC)) {
       $COUNTBPK1 = $result_seBillingBPK1chk['COUNT'];
     }

     $sql_seBillingBPK1 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
     $params_seBillingBPK1 = array(
         array('select_pdfvehicletransportdocumentdriver-densothai', SQLSRV_PARAM_IN),
         array($condBillingBPK1, SQLSRV_PARAM_IN),
         array($condBillingBPK2, SQLSRV_PARAM_IN),
         array($condBillingBPK3, SQLSRV_PARAM_IN)
     );



     $query_seBillingBPK1 = sqlsrv_query($conn, $sql_seBillingBPK1, $params_seBillingBPK1);
     while ($result_seBillingBPK1 = sqlsrv_fetch_array($query_seBillingBPK1, SQLSRV_FETCH_ASSOC)) {

        $BPK1 = $result_seBillingBPK1['VEHICLETRANSPORTPLANID'];
    $tbodyBPK1  .= '
  <tr style="border:1px solid #000;">
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $i2 . '</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingBPK1['DATEVLIN_103'] . '</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingBPK1['THAINAME'] . '</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seBillingBPK1['EMPLOYEENAME1'] . '</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingBPK1['ROUTEDESCRIPTION'] . '</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingBPK1['VEHICLETYPE'] . '</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingBPK1['BILLINGDENSO2'] . '</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingBPK1['JOBEND'] . '</td>
  </tr>
  ';
    $i2++;
    $sumtotalBPK1 = $sumtotalBPK1 + $result_seBillingBPK1['BILLINGDENSO2'];
  }

  $tfootBPK1  = '</tbody><tfoot>
  <tr style="border:1px solid #000;">
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">รวมทั้งสิ้น</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($i2 - 1) . '</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">เที่ยว</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">รวมเป็นเงินทั้งสิ้น</td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . convert($sumtotalBPK1) . '</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . number_format($sumtotalBPK1) . '</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
  </tr>
  <tr style="border:1px solid #000;">

  <td colspan="4" style="padding:4px;text-align:center;"><br><br>ผู้รับของ. ______________________________________
  <br><br><br> วันที่.  ........................./......................../....................

  </td><br><br><br>
  <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br>ผู้ส่งของ. ______________________________________
  <br><br><br> วันที่.  ........................./......................../....................
  </td><br><br><br>

  </tr>
  </tfoot></table>';



  $tfoot2 = '
  </tbody><tfoot>
  <div id="rotated">
  <tr style="border:1px solid #000;">
  <td colspan="4" style="padding:4px;text-align:center;">FM-OPS-15/09</td>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
  <td colspan="4" style="padding:4px;text-align:center;">แก้ไขครั้งที่ : 00</td>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
  <td colspan="2" style="padding:4px;text-align:center;">มีผลบังคับใช้ : 01-02-49</td>
  </tr>
  </div>
  </tfoot></table>';


// //   ////////////////////////////////////////บริษัท เด็นโซ่ ประเทศไทย (บางประกง) K'อรจิตรา////////////////////////////////////////////////////////////////

      $table_headerBPK2 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">
  <tbody>
  <tr style="border:1px solid #000;padding:4px;">
  <td colspan="2" style="font-size:14;" align="center">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด<br><br> 51 ม.4 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี  20160<br><br>โทร .038 452824-5 โทรสาร .038-210396</td>
  </tr>

  <tr style="border:1px solid #000;">
  <td colspan="2" align="center" style="font-size:16px;padding:5px;">ใบส่งของ (DELIVERY BILL)</td>
  </tr>
  <tr style="border:1px solid #000;padding:4px;">
  <td style="border-right:1px solid #000;padding:5px;width:80%"><b>วันที่ ' . $result_seMinvldate['MINDATEVLIN_103'] . ' - ' . $result_seMaxvldate['MAXDATEVLIN_103'] . '</b></td>
  <td><b>เลขที่ ' . $result_seInvoicecode['INVOICEBPK2'] . '</b></td>
  </tr>
  <tr style="border:1px solid #000;padding:4px;">
  <td style="font-size:14;" colspan="2" align="center"><br>บริษัท เด็นโซ่ (ประเทศไทย) จำกัด <br><br>
  700/87 หมู่ 1 ถ.บางนา-ตราด กม.57 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160<br><br><br>
  </td>
  </tr>
  <tr style="border:1px solid #000;">
  <td style="padding:5px;font-size:14;" colspan="2" align="center"><b>' . $result_seData11['JOBSTART'] . '</b></td>
  </tr>
  </tbody>
  </table>
  ';

      $table_beginBPK2  = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
  <thead>

  <tr style="border:1px solid #000;padding:4px;">

  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ลำดับที่</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>วันที่</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><strong>ทะเบียนรถ</strong></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>พนักงานขับรถ</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>หมายเลขเส้นทาง</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ประเภทรถ</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>จำนวนเงิน(บาท)</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>หมายเหตุ</b></td>
  </tr>
  </thead><tbody>';
      $i3 = 1;
      $condBillingBPK21 = " AND c.COMPANYCODE ='RKS' AND c.CUSTOMERCODE='DENSO-THAI' AND a.DOCUMENTCODE ='".$result_seBillings['DOCUMENTCODE']."'";
      $condBillingBPK22 = " AND c.BILLINGDENSO3 !='' AND c.BILLINGDENSO3 != '0' AND c.BILLINGDENSO3 != '-' AND BILLINGDENSO3 IS NOT NULL ";
      $condBillingBPK23 = " AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seBillings['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seBillings['PAYMENTDATE']."',103)";

      $sql_seBillingBPK2chk = "SELECT COUNT (b.VEHICLETRANSPORTPLANID) AS 'COUNT'
      FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
      INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
      INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.[VEHICLETRANSPORTPRICEID] = b.[VEHICLETRANSPORTPRICEID]
      WHERE 1 = 1
      AND a.COMPANYCODE ='RKS' AND a.CUSTOMERCODE='DENSO-THAI' AND a.DOCUMENTCODE ='".$result_seBillings['DOCUMENTCODE']."'
      AND c.BILLINGDENSO3 !='' AND c.BILLINGDENSO3 != '0' AND c.BILLINGDENSO3 != '-' AND c.BILLINGDENSO3 IS NOT NULL
      AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seBillings['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seBillings['PAYMENTDATE']."',103)";
      $params_seBillingBPK2chk = array();
      $query_seBillingBPK2chk = sqlsrv_query($conn, $sql_seBillingBPK2chk, $params_seBillingBPK2chk);
      while ($result_seBillingBPK2chk = sqlsrv_fetch_array($query_seBillingBPK2chk, SQLSRV_FETCH_ASSOC)) {
        $COUNTBPK2 = $result_seBillingBPK2chk['COUNT'];
      }

      $sql_seBillingBPK2 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
      $params_seBillingBPK2 = array(
          array('select_pdfvehicletransportdocumentdriver-densothai', SQLSRV_PARAM_IN),
          array($condBillingBPK21, SQLSRV_PARAM_IN),
          array($condBillingBPK22, SQLSRV_PARAM_IN),
          array($condBillingBPK23, SQLSRV_PARAM_IN)
      );



      $query_seBillingBPK2 = sqlsrv_query($conn, $sql_seBillingBPK2, $params_seBillingBPK2);
      while ($result_seBillingBPK2 = sqlsrv_fetch_array($query_seBillingBPK2, SQLSRV_FETCH_ASSOC)) {

            $BPK2 = $result_seBillingBPK2['VEHICLETRANSPORTPLANID'];

     $tbodyBPK2  .= '
   <tr style="border:1px solid #000;">
   <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $i3 . '</td>
   <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingBPK2['DATEVLIN_103'] . '</td>
   <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingBPK2['THAINAME'] . '</td>
   <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seBillingBPK2['EMPLOYEENAME1'] . '</td>
   <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingBPK2['ROUTEDESCRIPTION'] . '</td>
   <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingBPK2['VEHICLETYPE'] . '</td>
   <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingBPK2['BILLINGDENSO3'] . '</td>
   <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingBPK2['JOBEND'] . '</td>
   </tr>
   ';
     $i3++;
     $sumtotalBPK2 = $sumtotalBPK2 + $result_seBillingBPK2['BILLINGDENSO3'];
   }

   $tfootBPK2  = '</tbody><tfoot>
   <tr style="border:1px solid #000;">
   <td style="border-right:1px solid #000;padding:4px;text-align:center;">รวมทั้งสิ้น</td>
   <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($i3 - 1) . '</td>
   <td style="border-right:1px solid #000;padding:4px;text-align:center;">เที่ยว</td>
   <td style="border-right:1px solid #000;padding:4px;text-align:center;">รวมเป็นเงินทั้งสิ้น</td>
   <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . convert($sumtotalBPK2) . '</td>
   <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . number_format($sumtotalBPK2) . '</td>
   <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
   </tr>
   <tr style="border:1px solid #000;">

   <td colspan="4" style="padding:4px;text-align:center;"><br><br>ผู้รับของ. ______________________________________
   <br><br><br> วันที่.  ........................./......................../....................

   </td><br><br><br>
   <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br>ผู้ส่งของ. ______________________________________
   <br><br><br> วันที่.  ........................./......................../....................
   </td><br><br><br>

   </tr>
   </tfoot></table>';



   $tfoot3 = '
   </tbody><tfoot>
   <div id="rotated">
   <tr style="border:1px solid #000;">
   <td colspan="4" style="padding:4px;text-align:center;">FM-OPS-15/09</td>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
   <td colspan="4" style="padding:4px;text-align:center;">แก้ไขครั้งที่ : 00</td>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
   <td colspan="2" style="padding:4px;text-align:center;">มีผลบังคับใช้ : 01-02-49</td>
   </tr>
   </div>
   </tfoot></table>';
//
// ////////////////////////////////////////บริษัท แอร์ ซิสเต็มส์////////////////////////////////////////////////

        $table_headerASTH = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">
    <tbody>
    <tr style="border:1px solid #000;padding:4px;">
    <td colspan="2" style="font-size:14;" align="center">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด<br><br> 51 ม.4 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี  20160<br><br>โทร .038 452824-5 โทรสาร .038-210396</td>
    </tr>

    <tr style="border:1px solid #000;">
    <td colspan="2" align="center" style="font-size:16px;padding:5px;">ใบส่งของ (DELIVERY BILL)</td>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
    <td style="border-right:1px solid #000;padding:5px;width:80%"><b>วันที่ ' . $result_seMinvldate['MINDATEVLIN_103'] . ' - ' . $result_seMaxvldate['MAXDATEVLIN_103'] . '</b></td>
    <td><b>เลขที่ ' . $result_seInvoicecode['INVOICEASTH'] . '</b></td>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
    <td style="font-size:14;" colspan="2" align="center"><br>บริษัท แอร์ซิสเต็มส์  (ประเทศไทย) จำกัด <br><br>
    219/5-6 หมู่ 6 ต.บ่อวิน อ.ศรีราชา จ.ชลบุรี 20230<br><br><br>
    </td>
    </tr>
    <tr style="border:1px solid #000;">
    <td style="padding:5px;font-size:14;" colspan="2" align="center"><b>' . $result_seData11['JOBSTART'] . '</b></td>
    </tr>
    </tbody>
    </table>
    ';

        $table_beginASTH = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
    <thead>

    <tr style="border:1px solid #000;padding:4px;">

    <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ลำดับที่</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>วันที่</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><strong>ทะเบียนรถ</strong></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>พนักงานขับรถ</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>หมายเลขเส้นทาง</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ประเภทรถ</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>จำนวนเงิน(บาท)</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>หมายเหตุ</b></td>
    </tr>
    </thead><tbody>';
    $i4 = 1;
    $condBillingASTH1 = " AND c.COMPANYCODE ='RKS' AND c.CUSTOMERCODE='DENSO-THAI' AND a.DOCUMENTCODE ='".$result_seBillings['DOCUMENTCODE']."'";
    $condBillingASTH2 = " AND c.BILLINGDENSO4 !='' AND c.BILLINGDENSO4 != '0' AND c.BILLINGDENSO4 != '-' AND c.BILLINGDENSO4 IS NOT NULL ";
    $condBillingASTH3 = " AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seBillings['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seBillings['PAYMENTDATE']."',103)";

    $sql_seBillingASTHchk = "SELECT COUNT (b.VEHICLETRANSPORTPLANID) AS 'COUNT'
    FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
    INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.[VEHICLETRANSPORTPRICEID] = b.[VEHICLETRANSPORTPRICEID]
    WHERE 1 = 1
    AND a.COMPANYCODE ='RKS' AND a.CUSTOMERCODE='DENSO-THAI' AND a.DOCUMENTCODE ='".$result_seBillings['DOCUMENTCODE']."'
    AND c.BILLINGDENSO4 !='' AND c.BILLINGDENSO4 != '0' AND c.BILLINGDENSO4 != '-' AND c.BILLINGDENSO4 IS NOT NULL
    AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seBillings['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seBillings['PAYMENTDATE']."',103)";
    $params_seBillingASTHchk = array();
    $query_seBillingASTHchk = sqlsrv_query($conn, $sql_seBillingASTHchk, $params_seBillingASTHchk);
    while ($result_seBillingASTHchk = sqlsrv_fetch_array($query_seBillingASTHchk, SQLSRV_FETCH_ASSOC)) {
      $COUNTASTH = $result_seBillingASTHchk['COUNT'];
    }

    $sql_seBillingASTH = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
    $params_seBillingASTH = array(
        array('select_pdfvehicletransportdocumentdriver-densothai', SQLSRV_PARAM_IN),
        array($condBillingASTH1, SQLSRV_PARAM_IN),
        array($condBillingASTH2, SQLSRV_PARAM_IN),
        array($condBillingASTH3, SQLSRV_PARAM_IN)
    );



    $query_seBillingASTH = sqlsrv_query($conn, $sql_seBillingASTH, $params_seBillingASTH);
    while ($result_seBillingASTH = sqlsrv_fetch_array($query_seBillingASTH, SQLSRV_FETCH_ASSOC)) {
        $ASTH = $result_seBillingASTH['VEHICLETRANSPORTPLANID'];

    $tbodyASTH  .= '
    <tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $i4 . '</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingASTH['DATEVLIN_103'] . '</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingASTH['THAINAME'] . '</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seBillingASTH['EMPLOYEENAME1'] . '</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingASTH['ROUTEDESCRIPTION'] . '</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingASTH['VEHICLETYPE'] . '</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingASTH['BILLINGDENSO4'] . '</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingASTH['JOBEND'] . '</td>
    </tr>
    ';
    $i4++;
    $sumtotalASTH = $sumtotalASTH + $result_seBillingASTH['BILLINGDENSO4'];
    }

    $tfootASTH = '</tbody><tfoot>
<tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;">รวมทั้งสิ้น</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($i4 - 1) . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">เที่ยว</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">รวมเป็นเงินทั้งสิ้น</td>
<td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">' . convert($sumtotalASTH) . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . number_format($sumtotalASTH) . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
</tr>
<tr style="border:1px solid #000;">

<td colspan="4" style="padding:4px;text-align:center;"><br><br>ผู้รับของ. ______________________________________
<br><br><br> วันที่.  ........................./......................../....................

</td><br><br><br>
<td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br>ผู้ส่งของ. ______________________________________
<br><br><br> วันที่.  ........................./......................../....................
</td><br><br><br>

</tr>
</tfoot></table>';


    $tfoot4 = '

</tbody><tfoot>
   <div id="rotated">
   <tr style="border:1px solid #000;">
   <td colspan="4" style="padding:4px;text-align:center;">FM-OPS-15/09</td>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
   <td colspan="4" style="padding:4px;text-align:center;">แก้ไขครั้งที่ : 00</td>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
   <td colspan="2" style="padding:4px;text-align:center;">มีผลบังคับใช้ : 01-02-49</td>
   </tr>
   </div>
</tfoot></table>';

// //////////////////บริษัท เด็นโซ๋่เซลล์ DSTH////////////////////////////////////////////

$table_headerDSTH = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;padding:4px;">
<td colspan="2" style="font-size:14;" align="center">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด<br><br> 51 ม.4 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี  20160<br><br>โทร .038 452824-5 โทรสาร .038-210396</td>
</tr>

<tr style="border:1px solid #000;">
<td colspan="2" align="center" style="font-size:16px;padding:5px;">ใบส่งของ (DELIVERY BILL)</td>
</tr>
<tr style="border:1px solid #000;padding:4px;">
<td style="border-right:1px solid #000;padding:5px;width:80%"><b>วันที่ ' . $result_seMinvldate['MINDATEVLIN_103'] . ' - ' . $result_seMaxvldate['MAXDATEVLIN_103'] . '</b></td>
<td><b>เลขที่ ' . $result_seInvoicecode['INVOICEDSTH'] . '</b></td>
</tr>
<tr style="border:1px solid #000;padding:4px;">
<td style="font-size:14;" colspan="2" align="center"><br>บริษัท แอร์ซิสเต็มส์1  (ประเทศไทย) จำกัด <br><br>
219/5-6 หมู่ 6 ต.บ่อวิน อ.ศรีราชา จ.ชลบุรี 20230<br><br><br>
</td>
</tr>
<tr style="border:1px solid #000;">
<td style="padding:5px;font-size:14;" colspan="2" align="center"><b>' . $result_seData11['JOBSTART'] . '</b></td>
</tr>
</tbody>
</table>
';

$table_beginDSTH = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
<thead>

<tr style="border:1px solid #000;padding:4px;">

<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ลำดับที่</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>วันที่</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><strong>ทะเบียนรถ</strong></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>พนักงานขับรถ</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>หมายเลขเส้นทาง</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ประเภทรถ</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>จำนวนเงิน(บาท)</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>หมายเหตุ</b></td>
</tr>
</thead><tbody>';
$i5 = 1;
$condBillingDSTH1 = " AND c.COMPANYCODE ='RKS' AND c.CUSTOMERCODE='DENSO-THAI' AND a.DOCUMENTCODE ='".$result_seBillings['DOCUMENTCODE']."'";
$condBillingDSTH2 = " AND c.BILLINGDENSO5 !='' AND c.BILLINGDENSO5 != '0' AND c.BILLINGDENSO5 != '-' AND BILLINGDENSO5 IS NOT NULL ";
$condBillingDSTH3 = " AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seBillings['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seBillings['PAYMENTDATE']."',103)";


$sql_seBillingDSTHchk = "SELECT COUNT (b.VEHICLETRANSPORTPLANID) AS 'COUNT'
FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.[VEHICLETRANSPORTPRICEID] = b.[VEHICLETRANSPORTPRICEID]
WHERE 1 = 1
AND a.COMPANYCODE ='RKS' AND a.CUSTOMERCODE='DENSO-THAI' AND a.DOCUMENTCODE ='".$result_seBillings['DOCUMENTCODE']."'
AND c.BILLINGDENSO5 !='' AND c.BILLINGDENSO5 != '0' AND c.BILLINGDENSO5 != '-' AND c.BILLINGDENSO5 IS NOT NULL
AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seBillings['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seBillings['PAYMENTDATE']."',103)";
$params_seBillingDSTHchk = array();
$query_seBillingDSTHchk = sqlsrv_query($conn, $sql_seBillingDSTHchk, $params_seBillingDSTHchk);
while ($result_seBillingDSTHchk = sqlsrv_fetch_array($query_seBillingDSTHchk, SQLSRV_FETCH_ASSOC)) {
  $COUNTDSTH = $result_seBillingDSTHchk['COUNT'];
}


$sql_seBillingDSTH = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seBillingDSTH = array(
array('select_pdfvehicletransportdocumentdriver-densothai', SQLSRV_PARAM_IN),
array($condBillingDSTH1, SQLSRV_PARAM_IN),
array($condBillingDSTH2, SQLSRV_PARAM_IN),
array($condBillingDSTH3, SQLSRV_PARAM_IN)
);



$query_seBillingDSTH = sqlsrv_query($conn, $sql_seBillingDSTH, $params_seBillingDSTH);
while ($result_seBillingDSTH = sqlsrv_fetch_array($query_seBillingDSTH, SQLSRV_FETCH_ASSOC)) {

    $DSTH = $result_seBillingDSTH['VEHICLETRANSPORTPLANID'];

$tbodyDSTH  .= '
<tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $i5 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingDSTH['DATEVLIN_103'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingDSTH['THAINAME'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seBillingDSTH['EMPLOYEENAME1'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingDSTH['ROUTEDESCRIPTION'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingDSTH['VEHICLETYPE'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingDSTH['BILLINGDENSO5'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBillingDSTH['JOBEND'] . '</td>
</tr>
';
$i5++;
$sumtotalDSTH = $sumtotalDSTH + $result_seBillingDSTH['BILLINGDENSO5'];
}


$tfoot5 = '

</tbody><tfoot>
<div id="rotated">
<tr style="border:1px solid #000;">
<td colspan="4" style="padding:4px;text-align:center;">FM-OPS-15/09</td>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
<td colspan="4" style="padding:4px;text-align:center;">แก้ไขครั้งที่ : 00</td>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
<td colspan="2" style="padding:4px;text-align:center;">มีผลบังคับใช้ : 01-02-49</td>
</tr>
</div>
</tfoot></table>';


$mpdf->WriteHTML($style);
      if ($COUNTADTH > 0) {
        $mpdf->WriteHTML($table_headerADTH);
        $mpdf->WriteHTML($table_beginADTH);
        $mpdf->WriteHTML($tbodyADTH);
        $mpdf->WriteHTML($tfootADTH);
        $mpdf->WriteHTML($tfoot1);
      }else{
        // code...
      }

    if ($COUNTBPK1 > 0) {
      $mpdf->AddPage();
      $mpdf->WriteHTML($table_headerBPK1);
      $mpdf->WriteHTML($table_beginBPK1);
      $mpdf->WriteHTML($tbodyBPK1);
      $mpdf->WriteHTML($tfootBPK1);
      $mpdf->WriteHTML($tfoot2);
    }else {
      // code...
    }

    if ($COUNTBPK2 > 0 ) {
      $mpdf->AddPage();
      $mpdf->WriteHTML($table_headerBPK2);
      $mpdf->WriteHTML($table_beginBPK2);
      $mpdf->WriteHTML($tbodyBPK2);
      $mpdf->WriteHTML($tfootBPK2);
      $mpdf->WriteHTML($tfoot3);
    }else {
      // code...
    }

    if ($COUNTASTH > 0 ) {
      $mpdf->AddPage();
      $mpdf->WriteHTML($table_headerASTH);
      $mpdf->WriteHTML($table_beginASTH);
      $mpdf->WriteHTML($tbodyASTH);
      $mpdf->WriteHTML($tfootASTH);
      $mpdf->WriteHTML($tfoot4);
    }else {
      // code...
    }

    if ($COUNTDSTH > 0 ) {
      $mpdf->AddPage();
      $mpdf->WriteHTML($table_headerDSTH);
      $mpdf->WriteHTML($table_beginDSTH);
      $mpdf->WriteHTML($tbodyDSTH);
      $mpdf->WriteHTML($tfootDSTH);
      $mpdf->WriteHTML($tfoot5);
    }else {
      // code...
    }

$mpdf->Output();
sqlsrv_close($conn);
?>
