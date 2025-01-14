<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");



$condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "'  ";
$condBilling2 = "";
$condBilling3 = "";

$sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seBillings = array(
    array('select_pdfvehicletransportdocumentdriver-tmt', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN),
    array($condBilling3, SQLSRV_PARAM_IN)
);
$query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
$result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);

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

$mms = "";
switch ((int) substr($result_seBillings['BILLINGDATE'], 4, 2)) {
    case '1': {
            $mms = "Jan";
        }
        break;
    case '2': {
            $mms = "Feb";
        }
        break;
    case '3': {
            $mms = "Mar";
        }
        break;
    case '4': {
            $mms = "Apr";
        }
        break;
    case '5': {
            $mms = "May";
        }
        break;
    case '6': {
            $mms = "Jun";
        }
        break;
    case '7': {
            $mms = "Jul";
        }
        break;
    case '8': {
            $mms = "Aug";
        }
        break;
    case '9': {
            $mms = "Sep";
        }
        break;
    case '10': {
            $mms = "Oct";
        }
        break;
    case '11': {
            $mms = "Nov";
        }
        break;
    default : {
            $mms = "Dec";
        }
        break;
}

$mme = "";
switch ((int) substr($result_seBillings['PAYMENTDATE'], 4, 2)) {
    case '1': {
            $mme = "Jan";
        }
        break;
    case '2': {
            $mme = "Feb";
        }
        break;
    case '3': {
            $mme = "Mar";
        }
        break;
    case '4': {
            $mme = "Apr";
        }
        break;
    case '5': {
            $mme = "May";
        }
        break;
    case '6': {
            $mme = "Jun";
        }
        break;
    case '7': {
            $mme = "Jul";
        }
        break;
    case '8': {
            $mme = "Aug";
        }
        break;
    case '9': {
            $mme = "Sep";
        }
        break;
    case '10': {
            $mme = "Oct";
        }
        break;
    case '11': {
            $mme = "Nov";
        }
        break;
    default : {
            $mme = "Dec";
        }
        break;
}

$datestart = substr($result_seBillings['BILLINGDATE'],0,2);
$dateend = substr($result_seBillings['PAYMENTDATE'],0,2);
$BE = substr($result_seBillings['PAYMENTDATE'],6,10);

if ($mms == $mme) {
  $month = $datestart ." - ".$dateend ." ". $mms ." ".$BE ;
}else {
  $month = $datestart ." ". $mms ." - ".$dateend ." ". $mme ." ".$BE ;
}

// $mpdf = new mPDF('th', 'A4',10, 10, 10, 10, 10);
//ซ้าย ขวา บน ล่าง
$mpdf = new mPDF('', 'Letter', '', '', 3, 18, '', 5, '', 15);

$style = '
<style>
	body{
		font-family: "arial";font-size:12px//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';


$table_header31 = '<br>';
$table_header3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b>DETAILS FOR TRIPS OF STM to TMT Samrong (ENGINE)</b></td>
</tr>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b>(<u>MONTH</u> : ' . $month . ')</b></td>
</tr>
</tbody>
</table>
<table width="100%">
<tr>
<td width="45%">
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;margin-top:8px;">
<thead>
<tr style="border:1px solid #000;padding:4px;">
<td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 50%;">TOYOTA MOTOR THAILAND</td>
</tr>
</thead>
<tbody>
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%">PATS LOGISTICS</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%">S 5</td>
</tr>
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
</tr>
</tbody>
</table>

</td>
<td width="10%">
</td>
<td width="45%">
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;margin-top:8px;">
<thead>

<tr style="border:1px solid #000;padding:4px;">

<td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">RUAMKIT RUNGRUENG SERVICES CO.,LTD.</td>
</tr>
</thead><tbody>
    <tr style="border:1px solid #000;">
<td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">Issued By</td>
</tr>
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%"><br><br><br><br></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%"><br><br><br><br></td>
</tr>


</tbody></table>
</td>
</tr>
</table>
';

$table_begin3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;font-size:12;">
<thead>
<tr style="border:1px solid #000;padding:4px;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>DATE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>ROUTE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>6 Wheels</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>10 Wheels</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Extra Truck</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>TOTAL</b></td>
</tr>
</thead><tbody>';

$i = 1;


$condPrice6w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '6W'";
$condPrice6w2 = "";
$sql_sePrice6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_sePrice6w = array(
    array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
    array($condPrice6w1, SQLSRV_PARAM_IN),
    array($condPrice6w2, SQLSRV_PARAM_IN)
);
$query_sePrice6w = sqlsrv_query($conn, $sql_sePrice6w, $params_sePrice6w);
$result_sePrice6w = sqlsrv_fetch_array($query_sePrice6w, SQLSRV_FETCH_ASSOC);

$condPrice10w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '10W'";
$condPrice10w2 = "";
$sql_sePrice10w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_sePrice10w = array(
    array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
    array($condPrice10w1, SQLSRV_PARAM_IN),
    array($condPrice10w2, SQLSRV_PARAM_IN)
);
$query_sePrice10w = sqlsrv_query($conn, $sql_sePrice10w, $params_sePrice10w);
$result_sePrice10w = sqlsrv_fetch_array($query_sePrice10w, SQLSRV_FETCH_ASSOC);




$sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seBilling = array(
    array('select_pdfvehicletransportdocumentdriver-tmt', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN),
    array($condBilling3, SQLSRV_PARAM_IN)
);



$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

    $condCnt11 = " AND CONVERT(DATE,a.DATEVLIN) = CONVERT(DATE,'" . $result_seBilling['DATEVLIN10'] . "')";
    $condCnt12 = " AND a.JOBSTART = '" . $result_seBilling['JOBSTART'] . "' AND a.ACTIVESTATUS = '1'";
    $condCnt13 = " AND a.STATUSNUMBER != '0' AND a.STATUSNUMBER != 'X' AND b.DOCUMENTCODE != ''";

    $sql_seCnt1 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
    $params_seCnt1 = array(
        array('select_count6wheelstmt', SQLSRV_PARAM_IN),
        array($condCnt11, SQLSRV_PARAM_IN),
        array($condCnt12, SQLSRV_PARAM_IN),
        array($condCnt13, SQLSRV_PARAM_IN)
    );
    $query_seCnt1 = sqlsrv_query($conn, $sql_seCnt1, $params_seCnt1);
    $result_seCnt1 = sqlsrv_fetch_array($query_seCnt1, SQLSRV_FETCH_ASSOC);

    $sql_seCnt2 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
    $params_seCnt2 = array(
        array('select_count10wheelstmt', SQLSRV_PARAM_IN),
        array($condCnt11, SQLSRV_PARAM_IN),
        array($condCnt12, SQLSRV_PARAM_IN),
        array($condCnt13, SQLSRV_PARAM_IN)
    );
    $query_seCnt2 = sqlsrv_query($conn, $sql_seCnt2, $params_seCnt2);
    $result_seCnt2 = sqlsrv_fetch_array($query_seCnt2, SQLSRV_FETCH_ASSOC);

    $tbody3 .= '
    <tr style="border:1px solid #000;">
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['DATEVLIN10'] . '</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['TRANSPORTATION'] . ' (S5)</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($result_seCnt1['count6wheels']  == '0' ? '0' : $result_seCnt1['count6wheels']) . '</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($result_seCnt2['count10wheels']  == '0' ? '0' : $result_seCnt2['count10wheels']) . '</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">0</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($result_seCnt1['count6wheels'] + $result_seCnt2['count10wheels']) . '</td>


                                                                        </tr>
    ';
    $i++;

    $sum6w = $sum6w + $result_seCnt1['count6wheels'];
    $sum10w = $sum10w + $result_seCnt2['count10wheels'];
}


$tfoot3 = '</tbody>
<tfoot>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="2"><b>Total Trip</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . $sum6w . '</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . $sum10w . '</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>0</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . ($sum6w + $sum10w) . '</b></td>

                                                                    </tr>

                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="2"><b>Cost 6 Wheels/Trip</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . $sum6w . '</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2"><b>' . number_format($result_sePrice6w['ACTUALPRICE']) . '</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . number_format(($sum6w * $result_sePrice6w['ACTUALPRICE'])) . '</b></td>

                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="2"><b>Amount</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="4"><b>' . number_format(($sum6w * $result_sePrice6w['ACTUALPRICE'])) . '</td>

                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="2"><b>Cost 10 Wheels/Trip</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . $sum10w . '</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2"><b>' . number_format($result_sePrice10w['ACTUALPRICE']) . '</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . number_format(($sum10w * $result_sePrice10w['ACTUALPRICE'])) . '</b></td>

                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="2"><b>Amount</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="4"><b>' . number_format(($sum10w * $result_sePrice10w['ACTUALPRICE'])) . '</b></td>
                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="2"><b>Total Amount</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="4"><b>' . number_format(($sum6w * $result_sePrice6w['ACTUALPRICE']) + ($sum10w * $result_sePrice10w['ACTUALPRICE'])) . '</b></td>
                                                                    </tr>

                                                                </tfoot>
                                                     </table>
';

///////////////////////////WEEK1/////////////////////////////////////////////////////////////////////////

$sql_seWeek1 = "SELECT DISTINCT BILLINGDATE,PAYMENTDATE FROM LOGINVOICE WHERE REMARK = 1 AND INVOICECODE = RTRIM('" . $_GET['invoicecode'] . "')";
$query_seWeek1 = sqlsrv_query($conn, $sql_seWeek1, $params_seWeek1);
$result_seWeek1 = sqlsrv_fetch_array($query_seWeek1, SQLSRV_FETCH_ASSOC);

$mms = "";
switch ((int) substr($result_seWeek1['BILLINGDATE'], 4, 2)) {
    case '1': {
            $mms = "Jan";
        }
        break;
    case '2': {
            $mms = "Feb";
        }
        break;
    case '3': {
            $mms = "Mar";
        }
        break;
    case '4': {
            $mms = "Apr";
        }
        break;
    case '5': {
            $mms = "May";
        }
        break;
    case '6': {
            $mms = "Jun";
        }
        break;
    case '7': {
            $mms = "Jul";
        }
        break;
    case '8': {
            $mms = "Aug";
        }
        break;
    case '9': {
            $mms = "Sep";
        }
        break;
    case '10': {
            $mms = "Oct";
        }
        break;
    case '11': {
            $mms = "Nov";
        }
        break;
    default : {
            $mms = "Dec";
        }
        break;
}

$mme = "";
switch ((int) substr($result_seWeek1['PAYMENTDATE'], 4, 2)) {
    case '1': {
            $mme = "Jan";
        }
        break;
    case '2': {
            $mme = "Feb";
        }
        break;
    case '3': {
            $mme = "Mar";
        }
        break;
    case '4': {
            $mme = "Apr";
        }
        break;
    case '5': {
            $mme = "May";
        }
        break;
    case '6': {
            $mme = "Jun";
        }
        break;
    case '7': {
            $mme = "Jul";
        }
        break;
    case '8': {
            $mme = "Aug";
        }
        break;
    case '9': {
            $mme = "Sep";
        }
        break;
    case '10': {
            $mme = "Oct";
        }
        break;
    case '11': {
            $mme = "Nov";
        }
        break;
    default : {
            $mme = "Dec";
        }
        break;
}

$datestart = substr($result_seWeek1['BILLINGDATE'],0,2);
$dateend = substr($result_seWeek1['PAYMENTDATE'],0,2);
$BE = substr($result_seWeek1['PAYMENTDATE'],6,10);

if ($mms == $mme) {
  $month = $datestart ." - ".$dateend ." ". $mms ." ".$BE ;
}else {
  $month = $datestart ." ". $mms ." - ".$dateend ." ". $mme ." ".$BE ;
}

if ($result_seWeek1['BILLINGDATE'] != '') {
    $table_headerw11 = '<br>';
    $table_headerw1 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b>DETAILS FOR TRIPS OF STM to TMT Samrong (ENGINE)</b></td>
</tr>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b>(WEEK) : ' . $month . '</b></td>
</tr>
</tbody>
</table>
<table width="100%">
<tr>
<td width="45%">
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;margin-top:8px;">
<thead>
<tr style="border:1px solid #000;padding:4px;">
<td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 50%;">TOYOTA MOTOR THAILAND</td>
</tr>
</thead>
<tbody>
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%">PATS LOGISTICS</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%">S 5</td>
</tr>
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
</tr>
</tbody>
</table>

</td>
<td width="10%">
</td>
<td width="45%">
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;margin-top:8px;">
<thead>

<tr style="border:1px solid #000;padding:4px;">

<td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">RUAMKIT RUNGRUENG SERVICES CO.,LTD.</td>
</tr>
</thead><tbody>
    <tr style="border:1px solid #000;">
<td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">Issued By</td>
</tr>
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%"><br><br><br><br></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%"><br><br><br><br></td>
</tr>


</tbody></table>
</td>
</tr>
</table>
';

    $table_beginw1 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;font-size:12;">
<thead>
<tr style="border:1px solid #000;padding:4px;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>DATE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>ROUTE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>6 Wheels</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>10 Wheels</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Extra Truck</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>TOTAL</b></td>
</tr>
</thead><tbody>';

    $i = 1;


    $condPrice6w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '6W'";
    $condPrice6w2 = "";
    $sql_sePrice6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
    $params_sePrice6w = array(
        array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
        array($condPrice6w1, SQLSRV_PARAM_IN),
        array($condPrice6w2, SQLSRV_PARAM_IN)
    );
    $query_sePrice6w = sqlsrv_query($conn, $sql_sePrice6w, $params_sePrice6w);
    $result_sePrice6w = sqlsrv_fetch_array($query_sePrice6w, SQLSRV_FETCH_ASSOC);

    $condPrice10w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '10W'";
    $condPrice10w2 = "";
    $sql_sePrice10w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
    $params_sePrice10w = array(
        array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
        array($condPrice10w1, SQLSRV_PARAM_IN),
        array($condPrice10w2, SQLSRV_PARAM_IN)
    );
    $query_sePrice10w = sqlsrv_query($conn, $sql_sePrice10w, $params_sePrice10w);
    $result_sePrice10w = sqlsrv_fetch_array($query_sePrice10w, SQLSRV_FETCH_ASSOC);




    $condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
    $condBilling2 = " AND a.BILLINGDATE = '" . $result_seWeek1['BILLINGDATE'] . "' AND a.PAYMENTDATE = '" . $result_seWeek1['PAYMENTDATE'] . "'";
    $condBilling3 = "";
    $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
    $params_seBilling = array(
        array('select_pdfvehicletransportdocumentdriver-tmt', SQLSRV_PARAM_IN),
        array($condBilling1, SQLSRV_PARAM_IN),
        array($condBilling2, SQLSRV_PARAM_IN),
        array($condBilling3, SQLSRV_PARAM_IN)
    );



    $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
    while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

        $condCnt11 = " AND CONVERT(DATE,a.DATEVLIN) = CONVERT(DATE,'" . $result_seBilling['DATEVLIN10'] . "')";
        $condCnt12 = " AND a.JOBSTART = '" . $result_seBilling['JOBSTART'] . "' AND a.ACTIVESTATUS = '1'";
        $condCnt13 = " AND a.STATUSNUMBER != '0' AND a.STATUSNUMBER != 'X' AND b.DOCUMENTCODE != ''";

        $sql_seCnt1 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
        $params_seCnt1 = array(
            array('select_count6wheelstmt', SQLSRV_PARAM_IN),
            array($condCnt11, SQLSRV_PARAM_IN),
            array($condCnt12, SQLSRV_PARAM_IN),
            array($condCnt13, SQLSRV_PARAM_IN)
        );
        $query_seCnt1 = sqlsrv_query($conn, $sql_seCnt1, $params_seCnt1);
        $result_seCnt1 = sqlsrv_fetch_array($query_seCnt1, SQLSRV_FETCH_ASSOC);

        $sql_seCnt2 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
        $params_seCnt2 = array(
            array('select_count10wheelstmt', SQLSRV_PARAM_IN),
            array($condCnt11, SQLSRV_PARAM_IN),
            array($condCnt12, SQLSRV_PARAM_IN),
            array($condCnt13, SQLSRV_PARAM_IN)
        );
        $query_seCnt2 = sqlsrv_query($conn, $sql_seCnt2, $params_seCnt2);
        $result_seCnt2 = sqlsrv_fetch_array($query_seCnt2, SQLSRV_FETCH_ASSOC);

        $tbodyw1 .= '
    <tr style="border:1px solid #000;">
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['DATEVLIN10'] . '</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['TRANSPORTATION'] . ' (S5)</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($result_seCnt1['count6wheels']  == '0' ? '0' : $result_seCnt1['count6wheels']) . '</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($result_seCnt2['count10wheels']  == '0' ? '0' : $result_seCnt2['count10wheels']) . '</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">0</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($result_seCnt1['count6wheels'] + $result_seCnt2['count10wheels']) . '</td>


                                                                        </tr>
    ';
        $i++;

        $sum6w1 = $sum6w1 + $result_seCnt1['count6wheels'];
        $sum10w1 = $sum10w1 + $result_seCnt2['count10wheels'];
    }


    $tfootw1 = '</tbody>
<tfoot>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="2"><b>Total Trip</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . $sum6w1 . '</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . $sum10w1 . '</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>0</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . ($sum6w1 + $sum10w1) . '</b></td>

                                                                    </tr>



                                                                </tfoot>
                                                     </table>
';
}

////////////////WEEK2//////////////////////////////////////////////////////////////////

$sql_seWeek2 = "SELECT DISTINCT BILLINGDATE,PAYMENTDATE FROM LOGINVOICE WHERE REMARK = 2 AND INVOICECODE = RTRIM('" . $_GET['invoicecode'] . "')";
$query_seWeek2 = sqlsrv_query($conn, $sql_seWeek2, $params_seWeek2);
$result_seWeek2 = sqlsrv_fetch_array($query_seWeek2, SQLSRV_FETCH_ASSOC);

$mms = "";
switch ((int) substr($result_seWeek2['BILLINGDATE'], 4, 2)) {
    case '1': {
            $mms = "Jan";
        }
        break;
    case '2': {
            $mms = "Feb";
        }
        break;
    case '3': {
            $mms = "Mar";
        }
        break;
    case '4': {
            $mms = "Apr";
        }
        break;
    case '5': {
            $mms = "May";
        }
        break;
    case '6': {
            $mms = "Jun";
        }
        break;
    case '7': {
            $mms = "Jul";
        }
        break;
    case '8': {
            $mms = "Aug";
        }
        break;
    case '9': {
            $mms = "Sep";
        }
        break;
    case '10': {
            $mms = "Oct";
        }
        break;
    case '11': {
            $mms = "Nov";
        }
        break;
    default : {
            $mms = "Dec";
        }
        break;
}

$mme = "";
switch ((int) substr($result_seWeek2['PAYMENTDATE'], 4, 2)) {
    case '1': {
            $mme = "Jan";
        }
        break;
    case '2': {
            $mme = "Feb";
        }
        break;
    case '3': {
            $mme = "Mar";
        }
        break;
    case '4': {
            $mme = "Apr";
        }
        break;
    case '5': {
            $mme = "May";
        }
        break;
    case '6': {
            $mme = "Jun";
        }
        break;
    case '7': {
            $mme = "Jul";
        }
        break;
    case '8': {
            $mme = "Aug";
        }
        break;
    case '9': {
            $mme = "Sep";
        }
        break;
    case '10': {
            $mme = "Oct";
        }
        break;
    case '11': {
            $mme = "Nov";
        }
        break;
    default : {
            $mme = "Dec";
        }
        break;
}

$datestart = substr($result_seWeek2['BILLINGDATE'],0,2);
$dateend = substr($result_seWeek2['PAYMENTDATE'],0,2);
$BE = substr($result_seWeek2['PAYMENTDATE'],6,10);

if ($mms == $mme) {
  $month = $datestart ." - ".$dateend ." ". $mms ." ".$BE ;
}else {
  $month = $datestart ." ". $mms ." - ".$dateend ." ". $mme ." ".$BE ;
}

if ($result_seWeek2['BILLINGDATE'] != '') {
    $table_headerw22 = '<br>';
    $table_headerw2 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b>DETAILS FOR TRIPS OF STM to TMT Samrong (ENGINE)</b></td>
</tr>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b>(WEEK) : ' . $month . '</b></td>
</tr>
</tbody>
</table>
<table width="100%">
<tr>
<td width="45%">
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;margin-top:8px;">
<thead>
<tr style="border:1px solid #000;padding:4px;">
<td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 50%;">TOYOTA MOTOR THAILAND</td>
</tr>
</thead>
<tbody>
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%">PATS LOGISTICS</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%">S 5</td>
</tr>
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
</tr>
</tbody>
</table>

</td>
<td width="10%">
</td>
<td width="45%">
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;margin-top:8px;">
<thead>

<tr style="border:1px solid #000;padding:4px;">

<td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">RUAMKIT RUNGRUENG SERVICES CO.,LTD.</td>
</tr>
</thead><tbody>
    <tr style="border:1px solid #000;">
<td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">Issued By</td>
</tr>
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%"><br><br><br><br></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%"><br><br><br><br></td>
</tr>


</tbody></table>
</td>
</tr>
</table>
';

    $table_beginw2 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;font-size:12;">
<thead>
<tr style="border:1px solid #000;padding:4px;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>DATE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>ROUTE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>6 Wheels</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>10 Wheels</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Extra Truck</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>TOTAL</b></td>
</tr>
</thead><tbody>';

    $i = 1;


    $condPrice6w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '6W'";
    $condPrice6w2 = "";
    $sql_sePrice6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
    $params_sePrice6w = array(
        array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
        array($condPrice6w1, SQLSRV_PARAM_IN),
        array($condPrice6w2, SQLSRV_PARAM_IN)
    );
    $query_sePrice6w = sqlsrv_query($conn, $sql_sePrice6w, $params_sePrice6w);
    $result_sePrice6w = sqlsrv_fetch_array($query_sePrice6w, SQLSRV_FETCH_ASSOC);

    $condPrice10w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '10W'";
    $condPrice10w2 = "";
    $sql_sePrice10w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
    $params_sePrice10w = array(
        array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
        array($condPrice10w1, SQLSRV_PARAM_IN),
        array($condPrice10w2, SQLSRV_PARAM_IN)
    );
    $query_sePrice10w = sqlsrv_query($conn, $sql_sePrice10w, $params_sePrice10w);
    $result_sePrice10w = sqlsrv_fetch_array($query_sePrice10w, SQLSRV_FETCH_ASSOC);



    $condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
    $condBilling2 = " AND a.BILLINGDATE = '" . $result_seWeek2['BILLINGDATE'] . "' AND a.PAYMENTDATE = '" . $result_seWeek2['PAYMENTDATE'] . "'";
    $condBilling3 = "";
    $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
    $params_seBilling = array(
        array('select_pdfvehicletransportdocumentdriver-tmt', SQLSRV_PARAM_IN),
        array($condBilling1, SQLSRV_PARAM_IN),
        array($condBilling2, SQLSRV_PARAM_IN),
        array($condBilling3, SQLSRV_PARAM_IN)
    );



    $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
    while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

        $condCnt11 = " AND CONVERT(DATE,a.DATEVLIN) = CONVERT(DATE,'" . $result_seBilling['DATEVLIN10'] . "')";
        $condCnt12 = " AND a.JOBSTART = '" . $result_seBilling['JOBSTART'] . "' ";

        $sql_seCnt1 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
        $params_seCnt1 = array(
            array('select_count6wheelstmt', SQLSRV_PARAM_IN),
            array($condCnt11, SQLSRV_PARAM_IN),
            array($condCnt12, SQLSRV_PARAM_IN),
            array('', SQLSRV_PARAM_IN)
        );
        $query_seCnt1 = sqlsrv_query($conn, $sql_seCnt1, $params_seCnt1);
        $result_seCnt1 = sqlsrv_fetch_array($query_seCnt1, SQLSRV_FETCH_ASSOC);

        $sql_seCnt2 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
        $params_seCnt2 = array(
            array('select_count10wheelstmt', SQLSRV_PARAM_IN),
            array($condCnt11, SQLSRV_PARAM_IN),
            array($condCnt12, SQLSRV_PARAM_IN),
            array($condCnt13, SQLSRV_PARAM_IN)
        );
        $query_seCnt2 = sqlsrv_query($conn, $sql_seCnt2, $params_seCnt2);
        $result_seCnt2 = sqlsrv_fetch_array($query_seCnt2, SQLSRV_FETCH_ASSOC);

        $tbodyw2 .= '
    <tr style="border:1px solid #000;">
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['DATEVLIN10'] . '</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['TRANSPORTATION'] . ' (S5)</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($result_seCnt1['count6wheels']  == '0' ? '0' : $result_seCnt1['count6wheels']) . '</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($result_seCnt2['count10wheels']  == '0' ? '0' : $result_seCnt2['count10wheels']) . '</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">0</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($result_seCnt1['count6wheels'] + $result_seCnt2['count10wheels']) . '</td>


                                                                        </tr>
    ';
        $i++;

        $sum6w2 = $sum6w2 + $result_seCnt1['count6wheels'];
        $sum10w2 = $sum10w2 + $result_seCnt2['count10wheels'];
    }


    $tfootw2 = '</tbody>
<tfoot>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="2"><b>Total Trip</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . $sum6w2 . '</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . $sum10w2 . '</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>0</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . ($sum6w2 + $sum10w2) . '</b></td>

                                                                    </tr>



                                                                </tfoot>
                                                     </table>
';
}

///////////////////////WEEK3/////////////////////////////////////////

$sql_seWeek3 = "SELECT DISTINCT BILLINGDATE,PAYMENTDATE FROM LOGINVOICE WHERE REMARK = 3 AND INVOICECODE = RTRIM('" . $_GET['invoicecode'] . "')";
$query_seWeek3 = sqlsrv_query($conn, $sql_seWeek3, $params_seWeek3);
$result_seWeek3 = sqlsrv_fetch_array($query_seWeek3, SQLSRV_FETCH_ASSOC);
$mms = "";
switch ((int) substr($result_seWeek3['BILLINGDATE'], 4, 2)) {
    case '1': {
            $mms = "Jan";
        }
        break;
    case '2': {
            $mms = "Feb";
        }
        break;
    case '3': {
            $mms = "Mar";
        }
        break;
    case '4': {
            $mms = "Apr";
        }
        break;
    case '5': {
            $mms = "May";
        }
        break;
    case '6': {
            $mms = "Jun";
        }
        break;
    case '7': {
            $mms = "Jul";
        }
        break;
    case '8': {
            $mms = "Aug";
        }
        break;
    case '9': {
            $mms = "Sep";
        }
        break;
    case '10': {
            $mms = "Oct";
        }
        break;
    case '11': {
            $mms = "Nov";
        }
        break;
    default : {
            $mms = "Dec";
        }
        break;
}

$mme = "";
switch ((int) substr($result_seWeek3['PAYMENTDATE'], 4, 2)) {
    case '1': {
            $mme = "Jan";
        }
        break;
    case '2': {
            $mme = "Feb";
        }
        break;
    case '3': {
            $mme = "Mar";
        }
        break;
    case '4': {
            $mme = "Apr";
        }
        break;
    case '5': {
            $mme = "May";
        }
        break;
    case '6': {
            $mme = "Jun";
        }
        break;
    case '7': {
            $mme = "Jul";
        }
        break;
    case '8': {
            $mme = "Aug";
        }
        break;
    case '9': {
            $mme = "Sep";
        }
        break;
    case '10': {
            $mme = "Oct";
        }
        break;
    case '11': {
            $mme = "Nov";
        }
        break;
    default : {
            $mme = "Dec";
        }
        break;
}

$datestart = substr($result_seWeek3['BILLINGDATE'],0,2);
$dateend = substr($result_seWeek3['PAYMENTDATE'],0,2);
$BE = substr($result_seWeek3['PAYMENTDATE'],6,10);

if ($mms == $mme) {
  $month = $datestart ." - ".$dateend ." ". $mms ." ".$BE ;
}else {
  $month = $datestart ." ". $mms ." - ".$dateend ." ". $mme ." ".$BE ;
}

if ($result_seWeek3['BILLINGDATE'] != '') {
    $table_headerw33 = '<br>';
    $table_headerw3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b>DETAILS FOR TRIPS OF STM to TMT Samrong (ENGINE)</b></td>
</tr>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b>(WEEK) : ' . $month . '</b></td>
</tr>
</tbody>
</table>
<table width="100%">
<tr>
<td width="45%">
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;margin-top:8px;">
<thead>
<tr style="border:1px solid #000;padding:4px;">
<td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 50%;">TOYOTA MOTOR THAILAND</td>
</tr>
</thead>
<tbody>
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%">PATS LOGISTICS</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%">S 5</td>
</tr>
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
</tr>
</tbody>
</table>

</td>
<td width="10%">
</td>
<td width="45%">
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;margin-top:8px;">
<thead>

<tr style="border:1px solid #000;padding:4px;">

<td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">RUAMKIT RUNGRUENG SERVICES CO.,LTD.</td>
</tr>
</thead><tbody>
    <tr style="border:1px solid #000;">
<td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">Issued By</td>
</tr>
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%"><br><br><br><br></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%"><br><br><br><br></td>
</tr>


</tbody></table>
</td>
</tr>
</table>
';

    $table_beginw3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;font-size:12;">
<thead>
<tr style="border:1px solid #000;padding:4px;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>DATE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>ROUTE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>6 Wheels</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>10 Wheels</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Extra Truck</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>TOTAL</b></td>
</tr>
</thead><tbody>';

    $i = 1;


    $condPrice6w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '6W'";
    $condPrice6w2 = "";
    $sql_sePrice6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
    $params_sePrice6w = array(
        array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
        array($condPrice6w1, SQLSRV_PARAM_IN),
        array($condPrice6w2, SQLSRV_PARAM_IN)
    );
    $query_sePrice6w = sqlsrv_query($conn, $sql_sePrice6w, $params_sePrice6w);
    $result_sePrice6w = sqlsrv_fetch_array($query_sePrice6w, SQLSRV_FETCH_ASSOC);

    $condPrice10w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '10W'";
    $condPrice10w2 = "";
    $sql_sePrice10w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
    $params_sePrice10w = array(
        array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
        array($condPrice10w1, SQLSRV_PARAM_IN),
        array($condPrice10w2, SQLSRV_PARAM_IN)
    );
    $query_sePrice10w = sqlsrv_query($conn, $sql_sePrice10w, $params_sePrice10w);
    $result_sePrice10w = sqlsrv_fetch_array($query_sePrice10w, SQLSRV_FETCH_ASSOC);



    $condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
    $condBilling2 = " AND a.BILLINGDATE = '" . $result_seWeek3['BILLINGDATE'] . "' AND a.PAYMENTDATE = '" . $result_seWeek3['PAYMENTDATE'] . "'";
    $condBilling3 = "";
    $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
    $params_seBilling = array(
        array('select_pdfvehicletransportdocumentdriver-tmt', SQLSRV_PARAM_IN),
        array($condBilling1, SQLSRV_PARAM_IN),
        array($condBilling2, SQLSRV_PARAM_IN),
        array($condBilling3, SQLSRV_PARAM_IN)
    );



    $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
    while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

        $condCnt11 = " AND CONVERT(DATE,a.DATEVLIN) = CONVERT(DATE,'" . $result_seBilling['DATEVLIN10'] . "')";
        $condCnt12 = " AND a.JOBSTART = '" . $result_seBilling['JOBSTART'] . "' ";

        $sql_seCnt1 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
        $params_seCnt1 = array(
            array('select_count6wheelstmt', SQLSRV_PARAM_IN),
            array($condCnt11, SQLSRV_PARAM_IN),
            array($condCnt12, SQLSRV_PARAM_IN),
            array('', SQLSRV_PARAM_IN)
        );
        $query_seCnt1 = sqlsrv_query($conn, $sql_seCnt1, $params_seCnt1);
        $result_seCnt1 = sqlsrv_fetch_array($query_seCnt1, SQLSRV_FETCH_ASSOC);

        $sql_seCnt2 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
        $params_seCnt2 = array(
            array('select_count10wheelstmt', SQLSRV_PARAM_IN),
            array($condCnt11, SQLSRV_PARAM_IN),
            array($condCnt12, SQLSRV_PARAM_IN),
            array($condCnt13, SQLSRV_PARAM_IN)
        );
        $query_seCnt2 = sqlsrv_query($conn, $sql_seCnt2, $params_seCnt2);
        $result_seCnt2 = sqlsrv_fetch_array($query_seCnt2, SQLSRV_FETCH_ASSOC);

        $tbodyw3 .= '
    <tr style="border:1px solid #000;">
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['DATEVLIN10'] . '</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['TRANSPORTATION'] . ' (S5)</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($result_seCnt1['count6wheels']  == '0' ? '0' : $result_seCnt1['count6wheels']) . '</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($result_seCnt2['count10wheels']  == '0' ? '0' : $result_seCnt2['count10wheels']) . '</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">0</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($result_seCnt1['count6wheels'] + $result_seCnt2['count10wheels']) . '</td>


                                                                        </tr>
    ';
        $i++;

        $sum6w3 = $sum6w3 + $result_seCnt1['count6wheels'];
        $sum10w3 = $sum10w3 + $result_seCnt2['count10wheels'];
    }


    $tfootw3 = '</tbody>
<tfoot>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="2"><b>Total Trip</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . $sum6w3 . '</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . $sum10w3 . '</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>0</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . ($sum6w3 + $sum10w3) . '</b></td>

                                                                    </tr>



                                                                </tfoot>
                                                     </table>
';
}

////////////////WEEK4///////////////////////////////////////////////////////////////////////////

$sql_seWeek4 = "SELECT DISTINCT BILLINGDATE,PAYMENTDATE FROM LOGINVOICE WHERE REMARK = 4 AND INVOICECODE = RTRIM('" . $_GET['invoicecode'] . "')";
$query_seWeek4 = sqlsrv_query($conn, $sql_seWeek4, $params_seWeek4);
$result_seWeek4 = sqlsrv_fetch_array($query_seWeek4, SQLSRV_FETCH_ASSOC);

$mms = "";
switch ((int) substr($result_seWeek4['BILLINGDATE'], 4, 2)) {
    case '1': {
            $mms = "Jan";
        }
        break;
    case '2': {
            $mms = "Feb";
        }
        break;
    case '3': {
            $mms = "Mar";
        }
        break;
    case '4': {
            $mms = "Apr";
        }
        break;
    case '5': {
            $mms = "May";
        }
        break;
    case '6': {
            $mms = "Jun";
        }
        break;
    case '7': {
            $mms = "Jul";
        }
        break;
    case '8': {
            $mms = "Aug";
        }
        break;
    case '9': {
            $mms = "Sep";
        }
        break;
    case '10': {
            $mms = "Oct";
        }
        break;
    case '11': {
            $mms = "Nov";
        }
        break;
    default : {
            $mms = "Dec";
        }
        break;
}

$mme = "";
switch ((int) substr($result_seWeek4['PAYMENTDATE'], 4, 2)) {
    case '1': {
            $mme = "Jan";
        }
        break;
    case '2': {
            $mme = "Feb";
        }
        break;
    case '3': {
            $mme = "Mar";
        }
        break;
    case '4': {
            $mme = "Apr";
        }
        break;
    case '5': {
            $mme = "May";
        }
        break;
    case '6': {
            $mme = "Jun";
        }
        break;
    case '7': {
            $mme = "Jul";
        }
        break;
    case '8': {
            $mme = "Aug";
        }
        break;
    case '9': {
            $mme = "Sep";
        }
        break;
    case '10': {
            $mme = "Oct";
        }
        break;
    case '11': {
            $mme = "Nov";
        }
        break;
    default : {
            $mme = "Dec";
        }
        break;
}

$datestart = substr($result_seWeek4['BILLINGDATE'],0,2);
$dateend = substr($result_seWeek4['PAYMENTDATE'],0,2);
$BE = substr($result_seWeek4['PAYMENTDATE'],6,10);

if ($mms == $mme) {
  $month = $datestart ." - ".$dateend ." ". $mms ." ".$BE ;
}else {
  $month = $datestart ." ". $mms ." - ".$dateend ." ". $mme ." ".$BE ;
}

if ($result_seWeek4['BILLINGDATE'] != '') {
    $table_headerw44 = '<br>';
    $table_headerw4 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b>DETAILS FOR TRIPS OF STM to TMT Samrong (ENGINE)</b></td>
</tr>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b>(WEEK) : ' . $month . '</b></td>
</tr>
</tbody>
</table>
<table width="100%">
<tr>
<td width="45%">
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;margin-top:8px;">
<thead>
<tr style="border:1px solid #000;padding:4px;">
<td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 50%;">TOYOTA MOTOR THAILAND</td>
</tr>
</thead>
<tbody>
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%">PATS LOGISTICS</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%">S 5</td>
</tr>
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
</tr>
</tbody>
</table>

</td>
<td width="10%">
</td>
<td width="45%">
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;margin-top:8px;">
<thead>

<tr style="border:1px solid #000;padding:4px;">

<td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">RUAMKIT RUNGRUENG SERVICES CO.,LTD.</td>
</tr>
</thead><tbody>
    <tr style="border:1px solid #000;">
<td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">Issued By</td>
</tr>
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%"><br><br><br><br></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%"><br><br><br><br></td>
</tr>


</tbody></table>
</td>
</tr>
</table>
';

    $table_beginw4 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;font-size:12;">
<thead>
<tr style="border:1px solid #000;padding:4px;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>DATE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>ROUTE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>6 Wheels</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>10 Wheels</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Extra Truck</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>TOTAL</b></td>
</tr>
</thead><tbody>';

    $i = 1;


    $condPrice6w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '6W'";
    $condPrice6w2 = "";
    $sql_sePrice6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
    $params_sePrice6w = array(
        array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
        array($condPrice6w1, SQLSRV_PARAM_IN),
        array($condPrice6w2, SQLSRV_PARAM_IN)
    );
    $query_sePrice6w = sqlsrv_query($conn, $sql_sePrice6w, $params_sePrice6w);
    $result_sePrice6w = sqlsrv_fetch_array($query_sePrice6w, SQLSRV_FETCH_ASSOC);

    $condPrice10w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '10W'";
    $condPrice10w2 = "";
    $sql_sePrice10w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
    $params_sePrice10w = array(
        array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
        array($condPrice10w1, SQLSRV_PARAM_IN),
        array($condPrice10w2, SQLSRV_PARAM_IN)
    );
    $query_sePrice10w = sqlsrv_query($conn, $sql_sePrice10w, $params_sePrice10w);
    $result_sePrice10w = sqlsrv_fetch_array($query_sePrice10w, SQLSRV_FETCH_ASSOC);



    $condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
    $condBilling2 = " AND a.BILLINGDATE = '" . $result_seWeek4['BILLINGDATE'] . "' AND a.PAYMENTDATE = '" . $result_seWeek4['PAYMENTDATE'] . "'";
    $condBilling3 = "";
    $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
    $params_seBilling = array(
        array('select_pdfvehicletransportdocumentdriver-tmt', SQLSRV_PARAM_IN),
        array($condBilling1, SQLSRV_PARAM_IN),
        array($condBilling2, SQLSRV_PARAM_IN),
        array($condBilling3, SQLSRV_PARAM_IN)
    );



    $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
    while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

        $condCnt11 = " AND CONVERT(DATE,a.DATEVLIN) = CONVERT(DATE,'" . $result_seBilling['DATEVLIN10'] . "')";
        $condCnt12 = " AND a.JOBSTART = '" . $result_seBilling['JOBSTART'] . "' ";

        $sql_seCnt1 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
        $params_seCnt1 = array(
            array('select_count6wheelstmt', SQLSRV_PARAM_IN),
            array($condCnt11, SQLSRV_PARAM_IN),
            array($condCnt12, SQLSRV_PARAM_IN),
            array('', SQLSRV_PARAM_IN)
        );
        $query_seCnt1 = sqlsrv_query($conn, $sql_seCnt1, $params_seCnt1);
        $result_seCnt1 = sqlsrv_fetch_array($query_seCnt1, SQLSRV_FETCH_ASSOC);

       $sql_seCnt2 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
        $params_seCnt2 = array(
            array('select_count10wheelstmt', SQLSRV_PARAM_IN),
            array($condCnt11, SQLSRV_PARAM_IN),
            array($condCnt12, SQLSRV_PARAM_IN),
            array($condCnt13, SQLSRV_PARAM_IN)
        );
        $query_seCnt2 = sqlsrv_query($conn, $sql_seCnt2, $params_seCnt2);
        $result_seCnt2 = sqlsrv_fetch_array($query_seCnt2, SQLSRV_FETCH_ASSOC);

        $tbodyw4 .= '
    <tr style="border:1px solid #000;">
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['DATEVLIN10'] . '</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['TRANSPORTATION'] . ' (S5)</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($result_seCnt1['count6wheels']  == '0' ? '0' : $result_seCnt1['count6wheels']) . '</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($result_seCnt2['count10wheels']  == '0' ? '0' : $result_seCnt2['count10wheels']) . '</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">0</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($result_seCnt1['count6wheels'] + $result_seCnt2['count10wheels']) . '</td>


                                                                        </tr>
    ';
        $i++;

        $sum6w4 = $sum6w4 + $result_seCnt1['count6wheels'];
        $sum10w4 = $sum10w4 + $result_seCnt2['count10wheels'];
    }


    $tfootw4 = '</tbody>
<tfoot>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="2"><b>Total Trip</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . $sum6w4 . '</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . $sum10w4 . '</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>0</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . ($sum6w4 + $sum10w4) . '</b></td>

                                                                    </tr>



                                                                </tfoot>
                                                     </table>
';
}

/////////////////////////////////WEEK5/////////////////////////////////////////////////////////////////

$sql_seWeek5 = "SELECT DISTINCT BILLINGDATE,PAYMENTDATE FROM LOGINVOICE WHERE REMARK = 5 AND INVOICECODE = RTRIM('" . $_GET['invoicecode'] . "')";
$query_seWeek5 = sqlsrv_query($conn, $sql_seWeek5, $params_seWeek5);
$result_seWeek5 = sqlsrv_fetch_array($query_seWeek5, SQLSRV_FETCH_ASSOC);
$mms = "";
switch ((int) substr($result_seWeek5['BILLINGDATE'], 4, 2)) {
    case '1': {
            $mms = "Jan";
        }
        break;
    case '2': {
            $mms = "Feb";
        }
        break;
    case '3': {
            $mms = "Mar";
        }
        break;
    case '4': {
            $mms = "Apr";
        }
        break;
    case '5': {
            $mms = "May";
        }
        break;
    case '6': {
            $mms = "Jun";
        }
        break;
    case '7': {
            $mms = "Jul";
        }
        break;
    case '8': {
            $mms = "Aug";
        }
        break;
    case '9': {
            $mms = "Sep";
        }
        break;
    case '10': {
            $mms = "Oct";
        }
        break;
    case '11': {
            $mms = "Nov";
        }
        break;
    default : {
            $mms = "Dec";
        }
        break;
}

$mme = "";
switch ((int) substr($result_seWeek5['PAYMENTDATE'], 4, 2)) {
    case '1': {
            $mme = "Jan";
        }
        break;
    case '2': {
            $mme = "Feb";
        }
        break;
    case '3': {
            $mme = "Mar";
        }
        break;
    case '4': {
            $mme = "Apr";
        }
        break;
    case '5': {
            $mme = "May";
        }
        break;
    case '6': {
            $mme = "Jun";
        }
        break;
    case '7': {
            $mme = "Jul";
        }
        break;
    case '8': {
            $mme = "Aug";
        }
        break;
    case '9': {
            $mme = "Sep";
        }
        break;
    case '10': {
            $mme = "Oct";
        }
        break;
    case '11': {
            $mme = "Nov";
        }
        break;
    default : {
            $mme = "Dec";
        }
        break;
}

$datestart = substr($result_seWeek5['BILLINGDATE'],0,2);
$dateend = substr($result_seWeek5['PAYMENTDATE'],0,2);
$BE = substr($result_seWeek5['PAYMENTDATE'],6,10);

if ($mms == $mme) {
  $month = $datestart ." - ".$dateend ." ". $mms ." ".$BE ;
}else {
  $month = $datestart ." ". $mms ." - ".$dateend ." ". $mme ." ".$BE ;
}

if ($result_seWeek5['BILLINGDATE'] != '') {
    $table_headerw55 = '<br>';
    $table_headerw5 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b>DETAILS FOR TRIPS OF STM to TMT Samrong (ENGINE)</b></td>
</tr>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b>(WEEK) : ' . $month . '</b></td>
</tr>
</tbody>
</table>
<table width="100%">
<tr>
<td width="45%">
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;margin-top:8px;">
<thead>
<tr style="border:1px solid #000;padding:4px;">
<td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 50%;">TOYOTA MOTOR THAILAND</td>
</tr>
</thead>
<tbody>
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%">PATS LOGISTICS</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%">S 5</td>
</tr>
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br><br><br></td>
</tr>
</tbody>
</table>

</td>
<td width="10%">
</td>
<td width="45%">
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;margin-top:8px;">
<thead>

<tr style="border:1px solid #000;padding:4px;">

<td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">RUAMKIT RUNGRUENG SERVICES CO.,LTD.</td>
</tr>
</thead><tbody>
    <tr style="border:1px solid #000;">
<td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">Issued By</td>
</tr>
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%"><br><br><br><br></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;" width="50%"><br><br><br><br></td>
</tr>


</tbody></table>
</td>
</tr>
</table>
';

    $table_beginw5 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;font-size:12;">
<thead>
<tr style="border:1px solid #000;padding:4px;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>DATE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>ROUTE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>6 Wheels</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>10 Wheels</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Extra Truck</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>TOTAL</b></td>
</tr>
</thead><tbody>';

    $i = 1;


    $condPrice6w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '6W'";
    $condPrice6w2 = "";
    $sql_sePrice6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
    $params_sePrice6w = array(
        array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
        array($condPrice6w1, SQLSRV_PARAM_IN),
        array($condPrice6w2, SQLSRV_PARAM_IN)
    );
    $query_sePrice6w = sqlsrv_query($conn, $sql_sePrice6w, $params_sePrice6w);
    $result_sePrice6w = sqlsrv_fetch_array($query_sePrice6w, SQLSRV_FETCH_ASSOC);

    $condPrice10w1 = " AND [FROM] = '" . $result_seBillings['TRANSPORTATION'] . "' AND VEHICLETYPE = '10W'";
    $condPrice10w2 = "";
    $sql_sePrice10w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
    $params_sePrice10w = array(
        array('select_actualpricerkstmt', SQLSRV_PARAM_IN),
        array($condPrice10w1, SQLSRV_PARAM_IN),
        array($condPrice10w2, SQLSRV_PARAM_IN)
    );
    $query_sePrice10w = sqlsrv_query($conn, $sql_sePrice10w, $params_sePrice10w);
    $result_sePrice10w = sqlsrv_fetch_array($query_sePrice10w, SQLSRV_FETCH_ASSOC);



    $condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
    $condBilling2 = " AND a.BILLINGDATE = '" . $result_seWeek5['BILLINGDATE'] . "' AND a.PAYMENTDATE = '" . $result_seWeek5['PAYMENTDATE'] . "'";
    $condBilling3 = "";
    $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
    $params_seBilling = array(
        array('select_pdfvehicletransportdocumentdriver-tmt', SQLSRV_PARAM_IN),
        array($condBilling1, SQLSRV_PARAM_IN),
        array($condBilling2, SQLSRV_PARAM_IN),
        array($condBilling3, SQLSRV_PARAM_IN)
    );



    $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
    while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

        $condCnt11 = " AND CONVERT(DATE,a.DATEVLIN) = CONVERT(DATE,'" . $result_seBilling['DATEVLIN10'] . "')";
        $condCnt12 = " AND a.JOBSTART = '" . $result_seBilling['JOBSTART'] . "' ";

        $sql_seCnt1 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
        $params_seCnt1 = array(
            array('select_count6wheelstmt', SQLSRV_PARAM_IN),
            array($condCnt11, SQLSRV_PARAM_IN),
            array($condCnt12, SQLSRV_PARAM_IN),
            array('', SQLSRV_PARAM_IN)
        );
        $query_seCnt1 = sqlsrv_query($conn, $sql_seCnt1, $params_seCnt1);
        $result_seCnt1 = sqlsrv_fetch_array($query_seCnt1, SQLSRV_FETCH_ASSOC);

       $sql_seCnt2 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
        $params_seCnt2 = array(
            array('select_count10wheelstmt', SQLSRV_PARAM_IN),
            array($condCnt11, SQLSRV_PARAM_IN),
            array($condCnt12, SQLSRV_PARAM_IN),
            array($condCnt13, SQLSRV_PARAM_IN)
        );
        $query_seCnt2 = sqlsrv_query($conn, $sql_seCnt2, $params_seCnt2);
        $result_seCnt2 = sqlsrv_fetch_array($query_seCnt2, SQLSRV_FETCH_ASSOC);

        $tbodyw5 .= '
    <tr style="border:1px solid #000;">
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['DATEVLIN10'] . '</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['TRANSPORTATION'] . '(S5)</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($result_seCnt1['count6wheels']  == '0' ? '0' : $result_seCnt1['count6wheels']) . '</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($result_seCnt2['count10wheels']  == '0' ? '0' : $result_seCnt2['count10wheels']) . '</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">0</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . ($result_seCnt1['count6wheels'] + $result_seCnt2['count10wheels']) . '</td>


                                                                        </tr>
    ';
        $i++;

        $sum6w5 = $sum6w5 + $result_seCnt1['count6wheels'];
        $sum10w5 = $sum10w5 + $result_seCnt2['count10wheels'];
    }


    $tfootw5 = '</tbody>
<tfoot>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="2"><b>Total Trip</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . $sum6w5 . '</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . $sum10w5 . '</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>0</b></td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>' . ($sum6w5 + $sum10w5) . '</b></td>

                                                                    </tr>



                                                                </tfoot>
                                                     </table>
';
}

$condMaxexpressway15011 = "01";
$condMaxexpressway15012 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15013 = "";
$sql_seMaxexpressway1501 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1501 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15011, SQLSRV_PARAM_IN),
    array($condMaxexpressway15012, SQLSRV_PARAM_IN),
    array($condMaxexpressway15013, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1501 = sqlsrv_query($conn, $sql_seMaxexpressway1501, $params_seMaxexpressway1501);
$result_seMaxexpressway1501 = sqlsrv_fetch_array($query_seMaxexpressway1501, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15021 = "02";
$condMaxexpressway15022 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15023 = "";
$sql_seMaxexpressway1502 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1502 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15021, SQLSRV_PARAM_IN),
    array($condMaxexpressway15022, SQLSRV_PARAM_IN),
    array($condMaxexpressway15023, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1502 = sqlsrv_query($conn, $sql_seMaxexpressway1502, $params_seMaxexpressway1502);
$result_seMaxexpressway1502 = sqlsrv_fetch_array($query_seMaxexpressway1502, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15031 = "03";
$condMaxexpressway15032 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15033 = "";
$sql_seMaxexpressway1503 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1503 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15031, SQLSRV_PARAM_IN),
    array($condMaxexpressway15032, SQLSRV_PARAM_IN),
    array($condMaxexpressway15033, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1503 = sqlsrv_query($conn, $sql_seMaxexpressway1503, $params_seMaxexpressway1503);
$result_seMaxexpressway1503 = sqlsrv_fetch_array($query_seMaxexpressway1503, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15041 = "04";
$condMaxexpressway15042 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15043 = "";
$sql_seMaxexpressway1504 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1504 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15041, SQLSRV_PARAM_IN),
    array($condMaxexpressway15042, SQLSRV_PARAM_IN),
    array($condMaxexpressway15043, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1504 = sqlsrv_query($conn, $sql_seMaxexpressway1504, $params_seMaxexpressway1504);
$result_seMaxexpressway1504 = sqlsrv_fetch_array($query_seMaxexpressway1504, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15051 = "05";
$condMaxexpressway15052 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15053 = "";
$sql_seMaxexpressway1505 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1505 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15051, SQLSRV_PARAM_IN),
    array($condMaxexpressway15052, SQLSRV_PARAM_IN),
    array($condMaxexpressway15053, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1505 = sqlsrv_query($conn, $sql_seMaxexpressway1505, $params_seMaxexpressway1505);
$result_seMaxexpressway1505 = sqlsrv_fetch_array($query_seMaxexpressway1505, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15061 = "06";
$condMaxexpressway15062 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15063 = "";
$sql_seMaxexpressway1506 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1506 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15061, SQLSRV_PARAM_IN),
    array($condMaxexpressway15062, SQLSRV_PARAM_IN),
    array($condMaxexpressway15063, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1506 = sqlsrv_query($conn, $sql_seMaxexpressway1506, $params_seMaxexpressway1506);
$result_seMaxexpressway1506 = sqlsrv_fetch_array($query_seMaxexpressway1506, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15071 = "07";
$condMaxexpressway15072 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15073 = "";
$sql_seMaxexpressway1507 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1507 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15071, SQLSRV_PARAM_IN),
    array($condMaxexpressway15072, SQLSRV_PARAM_IN),
    array($condMaxexpressway15073, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1507 = sqlsrv_query($conn, $sql_seMaxexpressway1507, $params_seMaxexpressway1507);
$result_seMaxexpressway1507 = sqlsrv_fetch_array($query_seMaxexpressway1507, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15081 = "08";
$condMaxexpressway15082 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15083 = "";
$sql_seMaxexpressway1508 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1508 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15081, SQLSRV_PARAM_IN),
    array($condMaxexpressway15082, SQLSRV_PARAM_IN),
    array($condMaxexpressway15083, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1508 = sqlsrv_query($conn, $sql_seMaxexpressway1508, $params_seMaxexpressway1508);
$result_seMaxexpressway1508 = sqlsrv_fetch_array($query_seMaxexpressway1508, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15091 = "09";
$condMaxexpressway15092 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15093 = "";
$sql_seMaxexpressway1509 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1509 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15091, SQLSRV_PARAM_IN),
    array($condMaxexpressway15092, SQLSRV_PARAM_IN),
    array($condMaxexpressway15093, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1509 = sqlsrv_query($conn, $sql_seMaxexpressway1509, $params_seMaxexpressway1509);
$result_seMaxexpressway1509 = sqlsrv_fetch_array($query_seMaxexpressway1509, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15101 = "10";
$condMaxexpressway15102 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15103 = "";
$sql_seMaxexpressway1510 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1510 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15101, SQLSRV_PARAM_IN),
    array($condMaxexpressway15102, SQLSRV_PARAM_IN),
    array($condMaxexpressway15103, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1510 = sqlsrv_query($conn, $sql_seMaxexpressway1510, $params_seMaxexpressway1510);
$result_seMaxexpressway1510 = sqlsrv_fetch_array($query_seMaxexpressway1510, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15111 = "11";
$condMaxexpressway15112 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15113 = "";
$sql_seMaxexpressway1511 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1511 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15111, SQLSRV_PARAM_IN),
    array($condMaxexpressway15112, SQLSRV_PARAM_IN),
    array($condMaxexpressway15113, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1511 = sqlsrv_query($conn, $sql_seMaxexpressway1511, $params_seMaxexpressway1511);
$result_seMaxexpressway1511 = sqlsrv_fetch_array($query_seMaxexpressway1511, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15121 = "12";
$condMaxexpressway15122 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15123 = "";
$sql_seMaxexpressway1512 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1512 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15121, SQLSRV_PARAM_IN),
    array($condMaxexpressway15122, SQLSRV_PARAM_IN),
    array($condMaxexpressway15123, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1512 = sqlsrv_query($conn, $sql_seMaxexpressway1512, $params_seMaxexpressway1512);
$result_seMaxexpressway1512 = sqlsrv_fetch_array($query_seMaxexpressway1512, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15131 = "13";
$condMaxexpressway15132 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15133 = "";
$sql_seMaxexpressway1513 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1513 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15131, SQLSRV_PARAM_IN),
    array($condMaxexpressway15132, SQLSRV_PARAM_IN),
    array($condMaxexpressway15133, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1513 = sqlsrv_query($conn, $sql_seMaxexpressway1513, $params_seMaxexpressway1513);
$result_seMaxexpressway1513 = sqlsrv_fetch_array($query_seMaxexpressway1513, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15141 = "14";
$condMaxexpressway15142 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15143 = "";
$sql_seMaxexpressway1514 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1514 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15141, SQLSRV_PARAM_IN),
    array($condMaxexpressway15142, SQLSRV_PARAM_IN),
    array($condMaxexpressway15143, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1514 = sqlsrv_query($conn, $sql_seMaxexpressway1514, $params_seMaxexpressway1514);
$result_seMaxexpressway1514 = sqlsrv_fetch_array($query_seMaxexpressway1514, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15151 = "15";
$condMaxexpressway15152 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15153 = "";
$sql_seMaxexpressway1515 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1515 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15151, SQLSRV_PARAM_IN),
    array($condMaxexpressway15152, SQLSRV_PARAM_IN),
    array($condMaxexpressway15153, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1515 = sqlsrv_query($conn, $sql_seMaxexpressway1515, $params_seMaxexpressway1515);
$result_seMaxexpressway1515 = sqlsrv_fetch_array($query_seMaxexpressway1515, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15161 = "16";
$condMaxexpressway15162 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15163 = "";
$sql_seMaxexpressway1516 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1516 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15161, SQLSRV_PARAM_IN),
    array($condMaxexpressway15162, SQLSRV_PARAM_IN),
    array($condMaxexpressway15163, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1516 = sqlsrv_query($conn, $sql_seMaxexpressway1516, $params_seMaxexpressway1516);
$result_seMaxexpressway1516 = sqlsrv_fetch_array($query_seMaxexpressway1516, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15171 = "17";
$condMaxexpressway15172 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15173 = "";
$sql_seMaxexpressway1517 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1517 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15171, SQLSRV_PARAM_IN),
    array($condMaxexpressway15172, SQLSRV_PARAM_IN),
    array($condMaxexpressway15173, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1517 = sqlsrv_query($conn, $sql_seMaxexpressway1517, $params_seMaxexpressway1517);
$result_seMaxexpressway1517 = sqlsrv_fetch_array($query_seMaxexpressway1517, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15181 = "18";
$condMaxexpressway15182 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15183 = "";
$sql_seMaxexpressway1518 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1518 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15181, SQLSRV_PARAM_IN),
    array($condMaxexpressway15182, SQLSRV_PARAM_IN),
    array($condMaxexpressway15183, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1518 = sqlsrv_query($conn, $sql_seMaxexpressway1518, $params_seMaxexpressway1518);
$result_seMaxexpressway1518 = sqlsrv_fetch_array($query_seMaxexpressway1518, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15191 = "19";
$condMaxexpressway15192 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15193 = "";
$sql_seMaxexpressway1519 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1519 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15191, SQLSRV_PARAM_IN),
    array($condMaxexpressway15192, SQLSRV_PARAM_IN),
    array($condMaxexpressway15193, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1519 = sqlsrv_query($conn, $sql_seMaxexpressway1519, $params_seMaxexpressway1519);
$result_seMaxexpressway1519 = sqlsrv_fetch_array($query_seMaxexpressway1519, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15201 = "20";
$condMaxexpressway15202 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15203 = "";
$sql_seMaxexpressway1520 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1520 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15201, SQLSRV_PARAM_IN),
    array($condMaxexpressway15202, SQLSRV_PARAM_IN),
    array($condMaxexpressway15203, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1520 = sqlsrv_query($conn, $sql_seMaxexpressway1520, $params_seMaxexpressway1520);
$result_seMaxexpressway1520 = sqlsrv_fetch_array($query_seMaxexpressway1520, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15211 = "21";
$condMaxexpressway15212 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15213 = "";
$sql_seMaxexpressway1521 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1521 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15211, SQLSRV_PARAM_IN),
    array($condMaxexpressway15212, SQLSRV_PARAM_IN),
    array($condMaxexpressway15213, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1521 = sqlsrv_query($conn, $sql_seMaxexpressway1521, $params_seMaxexpressway1521);
$result_seMaxexpressway1521 = sqlsrv_fetch_array($query_seMaxexpressway1521, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15221 = "22";
$condMaxexpressway15222 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15223 = "";
$sql_seMaxexpressway1522 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1522 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15221, SQLSRV_PARAM_IN),
    array($condMaxexpressway15222, SQLSRV_PARAM_IN),
    array($condMaxexpressway15223, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1522 = sqlsrv_query($conn, $sql_seMaxexpressway1522, $params_seMaxexpressway1522);
$result_seMaxexpressway1522 = sqlsrv_fetch_array($query_seMaxexpressway1522, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15231 = "23";
$condMaxexpressway15232 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15233 = "";
$sql_seMaxexpressway1523 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1523 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15231, SQLSRV_PARAM_IN),
    array($condMaxexpressway15232, SQLSRV_PARAM_IN),
    array($condMaxexpressway15233, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1523 = sqlsrv_query($conn, $sql_seMaxexpressway1523, $params_seMaxexpressway1523);
$result_seMaxexpressway1523 = sqlsrv_fetch_array($query_seMaxexpressway1523, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15241 = "24";
$condMaxexpressway15242 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15243 = "";
$sql_seMaxexpressway1524 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1524 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15241, SQLSRV_PARAM_IN),
    array($condMaxexpressway15242, SQLSRV_PARAM_IN),
    array($condMaxexpressway15243, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1524 = sqlsrv_query($conn, $sql_seMaxexpressway1524, $params_seMaxexpressway1524);
$result_seMaxexpressway1524 = sqlsrv_fetch_array($query_seMaxexpressway1524, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15251 = "25";
$condMaxexpressway15252 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15253 = "";
$sql_seMaxexpressway1525 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1525 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15251, SQLSRV_PARAM_IN),
    array($condMaxexpressway15252, SQLSRV_PARAM_IN),
    array($condMaxexpressway15253, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1525 = sqlsrv_query($conn, $sql_seMaxexpressway1525, $params_seMaxexpressway1525);
$result_seMaxexpressway1525 = sqlsrv_fetch_array($query_seMaxexpressway1525, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15261 = "26";
$condMaxexpressway15262 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15263 = "";
$sql_seMaxexpressway1526 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1526 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15261, SQLSRV_PARAM_IN),
    array($condMaxexpressway15262, SQLSRV_PARAM_IN),
    array($condMaxexpressway15263, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1526 = sqlsrv_query($conn, $sql_seMaxexpressway1526, $params_seMaxexpressway1526);
$result_seMaxexpressway1526 = sqlsrv_fetch_array($query_seMaxexpressway1526, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15271 = "27";
$condMaxexpressway15272 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15273 = "";
$sql_seMaxexpressway1527 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1527 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15271, SQLSRV_PARAM_IN),
    array($condMaxexpressway15272, SQLSRV_PARAM_IN),
    array($condMaxexpressway15273, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1527 = sqlsrv_query($conn, $sql_seMaxexpressway1527, $params_seMaxexpressway1527);
$result_seMaxexpressway1527 = sqlsrv_fetch_array($query_seMaxexpressway1527, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15281 = "28";
$condMaxexpressway15282 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15283 = "";
$sql_seMaxexpressway1528 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1528 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15281, SQLSRV_PARAM_IN),
    array($condMaxexpressway15282, SQLSRV_PARAM_IN),
    array($condMaxexpressway15283, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1528 = sqlsrv_query($conn, $sql_seMaxexpressway1528, $params_seMaxexpressway1528);
$result_seMaxexpressway1528 = sqlsrv_fetch_array($query_seMaxexpressway1528, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15291 = "29";
$condMaxexpressway15292 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15293 = "";
$sql_seMaxexpressway1529 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1529 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15291, SQLSRV_PARAM_IN),
    array($condMaxexpressway15292, SQLSRV_PARAM_IN),
    array($condMaxexpressway15293, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1529 = sqlsrv_query($conn, $sql_seMaxexpressway1529, $params_seMaxexpressway1529);
$result_seMaxexpressway1529 = sqlsrv_fetch_array($query_seMaxexpressway1529, SQLSRV_FETCH_ASSOC);

$condMaxexpressway15301 = "30";
$condMaxexpressway15302 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15303 = "";
$sql_seMaxexpressway1530 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1530 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15301, SQLSRV_PARAM_IN),
    array($condMaxexpressway15302, SQLSRV_PARAM_IN),
    array($condMaxexpressway15303, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1530 = sqlsrv_query($conn, $sql_seMaxexpressway1530, $params_seMaxexpressway1530);
$result_seMaxexpressway1530 = sqlsrv_fetch_array($query_seMaxexpressway1530, SQLSRV_FETCH_ASSOC);


$condMaxexpressway15311 = "31";
$condMaxexpressway15312 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway15313 = "";
$sql_seMaxexpressway1531 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway1531 = array(
    array('select_maxexpressway15', SQLSRV_PARAM_IN),
    array($condMaxexpressway15311, SQLSRV_PARAM_IN),
    array($condMaxexpressway15312, SQLSRV_PARAM_IN),
    array($condMaxexpressway15313, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway1531 = sqlsrv_query($conn, $sql_seMaxexpressway1531, $params_seMaxexpressway1531);
$result_seMaxexpressway1531 = sqlsrv_fetch_array($query_seMaxexpressway1531, SQLSRV_FETCH_ASSOC);





$condMaxexpressway65011 = "01";
$condMaxexpressway65012 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65013 = "";
$sql_seMaxexpressway6501 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6501 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65011, SQLSRV_PARAM_IN),
    array($condMaxexpressway65012, SQLSRV_PARAM_IN),
    array($condMaxexpressway65013, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6501 = sqlsrv_query($conn, $sql_seMaxexpressway6501, $params_seMaxexpressway6501);
$result_seMaxexpressway6501 = sqlsrv_fetch_array($query_seMaxexpressway6501, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65021 = "02";
$condMaxexpressway65022 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65023 = "";
$sql_seMaxexpressway6502 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6502 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65021, SQLSRV_PARAM_IN),
    array($condMaxexpressway65022, SQLSRV_PARAM_IN),
    array($condMaxexpressway65023, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6502 = sqlsrv_query($conn, $sql_seMaxexpressway6502, $params_seMaxexpressway6502);
$result_seMaxexpressway6502 = sqlsrv_fetch_array($query_seMaxexpressway6502, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65031 = "03";
$condMaxexpressway65032 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65033 = "";
$sql_seMaxexpressway6503 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6503 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65031, SQLSRV_PARAM_IN),
    array($condMaxexpressway65032, SQLSRV_PARAM_IN),
    array($condMaxexpressway65033, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6503 = sqlsrv_query($conn, $sql_seMaxexpressway6503, $params_seMaxexpressway6503);
$result_seMaxexpressway6503 = sqlsrv_fetch_array($query_seMaxexpressway6503, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65041 = "04";
$condMaxexpressway65042 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65043 = "";
$sql_seMaxexpressway6504 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6504 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65041, SQLSRV_PARAM_IN),
    array($condMaxexpressway65042, SQLSRV_PARAM_IN),
    array($condMaxexpressway65043, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6504 = sqlsrv_query($conn, $sql_seMaxexpressway6504, $params_seMaxexpressway6504);
$result_seMaxexpressway6504 = sqlsrv_fetch_array($query_seMaxexpressway6504, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65051 = "05";
$condMaxexpressway65052 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65053 = "";
$sql_seMaxexpressway6505 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6505 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65051, SQLSRV_PARAM_IN),
    array($condMaxexpressway65052, SQLSRV_PARAM_IN),
    array($condMaxexpressway65053, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6505 = sqlsrv_query($conn, $sql_seMaxexpressway6505, $params_seMaxexpressway6505);
$result_seMaxexpressway6505 = sqlsrv_fetch_array($query_seMaxexpressway6505, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65061 = "06";
$condMaxexpressway65062 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65063 = "";
$sql_seMaxexpressway6506 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6506 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65061, SQLSRV_PARAM_IN),
    array($condMaxexpressway65062, SQLSRV_PARAM_IN),
    array($condMaxexpressway65063, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6506 = sqlsrv_query($conn, $sql_seMaxexpressway6506, $params_seMaxexpressway6506);
$result_seMaxexpressway6506 = sqlsrv_fetch_array($query_seMaxexpressway6506, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65071 = "07";
$condMaxexpressway65072 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65073 = "";
$sql_seMaxexpressway6507 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6507 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65071, SQLSRV_PARAM_IN),
    array($condMaxexpressway65072, SQLSRV_PARAM_IN),
    array($condMaxexpressway65073, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6507 = sqlsrv_query($conn, $sql_seMaxexpressway6507, $params_seMaxexpressway6507);
$result_seMaxexpressway6507 = sqlsrv_fetch_array($query_seMaxexpressway6507, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65081 = "08";
$condMaxexpressway65082 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65083 = "";
$sql_seMaxexpressway6508 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6508 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65081, SQLSRV_PARAM_IN),
    array($condMaxexpressway65082, SQLSRV_PARAM_IN),
    array($condMaxexpressway65083, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6508 = sqlsrv_query($conn, $sql_seMaxexpressway6508, $params_seMaxexpressway6508);
$result_seMaxexpressway6508 = sqlsrv_fetch_array($query_seMaxexpressway6508, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65091 = "09";
$condMaxexpressway65092 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65093 = "";
$sql_seMaxexpressway6509 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6509 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65091, SQLSRV_PARAM_IN),
    array($condMaxexpressway65092, SQLSRV_PARAM_IN),
    array($condMaxexpressway65093, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6509 = sqlsrv_query($conn, $sql_seMaxexpressway6509, $params_seMaxexpressway6509);
$result_seMaxexpressway6509 = sqlsrv_fetch_array($query_seMaxexpressway6509, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65101 = "10";
$condMaxexpressway65102 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65103 = "";
$sql_seMaxexpressway6510 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6510 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65101, SQLSRV_PARAM_IN),
    array($condMaxexpressway65102, SQLSRV_PARAM_IN),
    array($condMaxexpressway65103, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6510 = sqlsrv_query($conn, $sql_seMaxexpressway6510, $params_seMaxexpressway6510);
$result_seMaxexpressway6510 = sqlsrv_fetch_array($query_seMaxexpressway6510, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65111 = "11";
$condMaxexpressway65112 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65113 = "";
$sql_seMaxexpressway6511 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6511 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65111, SQLSRV_PARAM_IN),
    array($condMaxexpressway65112, SQLSRV_PARAM_IN),
    array($condMaxexpressway65113, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6511 = sqlsrv_query($conn, $sql_seMaxexpressway6511, $params_seMaxexpressway6511);
$result_seMaxexpressway6511 = sqlsrv_fetch_array($query_seMaxexpressway6511, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65121 = "12";
$condMaxexpressway65122 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65123 = "";
$sql_seMaxexpressway6512 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6512 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65121, SQLSRV_PARAM_IN),
    array($condMaxexpressway65122, SQLSRV_PARAM_IN),
    array($condMaxexpressway65123, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6512 = sqlsrv_query($conn, $sql_seMaxexpressway6512, $params_seMaxexpressway6512);
$result_seMaxexpressway6512 = sqlsrv_fetch_array($query_seMaxexpressway6512, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65131 = "13";
$condMaxexpressway65132 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65133 = "";
$sql_seMaxexpressway6513 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6513 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65131, SQLSRV_PARAM_IN),
    array($condMaxexpressway65132, SQLSRV_PARAM_IN),
    array($condMaxexpressway65133, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6513 = sqlsrv_query($conn, $sql_seMaxexpressway6513, $params_seMaxexpressway6513);
$result_seMaxexpressway6513 = sqlsrv_fetch_array($query_seMaxexpressway6513, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65141 = "14";
$condMaxexpressway65142 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65143 = "";
$sql_seMaxexpressway6514 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6514 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65141, SQLSRV_PARAM_IN),
    array($condMaxexpressway65142, SQLSRV_PARAM_IN),
    array($condMaxexpressway65143, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6514 = sqlsrv_query($conn, $sql_seMaxexpressway6514, $params_seMaxexpressway6514);
$result_seMaxexpressway6514 = sqlsrv_fetch_array($query_seMaxexpressway6514, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65151 = "15";
$condMaxexpressway65152 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65153 = "";
$sql_seMaxexpressway6515 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6515 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65151, SQLSRV_PARAM_IN),
    array($condMaxexpressway65152, SQLSRV_PARAM_IN),
    array($condMaxexpressway65153, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6515 = sqlsrv_query($conn, $sql_seMaxexpressway6515, $params_seMaxexpressway6515);
$result_seMaxexpressway6515 = sqlsrv_fetch_array($query_seMaxexpressway6515, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65161 = "16";
$condMaxexpressway65162 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65163 = "";
$sql_seMaxexpressway6516 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6516 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65161, SQLSRV_PARAM_IN),
    array($condMaxexpressway65162, SQLSRV_PARAM_IN),
    array($condMaxexpressway65163, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6516 = sqlsrv_query($conn, $sql_seMaxexpressway6516, $params_seMaxexpressway6516);
$result_seMaxexpressway6516 = sqlsrv_fetch_array($query_seMaxexpressway6516, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65171 = "17";
$condMaxexpressway65172 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65173 = "";
$sql_seMaxexpressway6517 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6517 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65171, SQLSRV_PARAM_IN),
    array($condMaxexpressway65172, SQLSRV_PARAM_IN),
    array($condMaxexpressway65173, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6517 = sqlsrv_query($conn, $sql_seMaxexpressway6517, $params_seMaxexpressway6517);
$result_seMaxexpressway6517 = sqlsrv_fetch_array($query_seMaxexpressway6517, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65181 = "18";
$condMaxexpressway65182 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65183 = "";
$sql_seMaxexpressway6518 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6518 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65181, SQLSRV_PARAM_IN),
    array($condMaxexpressway65182, SQLSRV_PARAM_IN),
    array($condMaxexpressway65183, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6518 = sqlsrv_query($conn, $sql_seMaxexpressway6518, $params_seMaxexpressway6518);
$result_seMaxexpressway6518 = sqlsrv_fetch_array($query_seMaxexpressway6518, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65191 = "19";
$condMaxexpressway65192 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65193 = "";
$sql_seMaxexpressway6519 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6519 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65191, SQLSRV_PARAM_IN),
    array($condMaxexpressway65192, SQLSRV_PARAM_IN),
    array($condMaxexpressway65193, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6519 = sqlsrv_query($conn, $sql_seMaxexpressway6519, $params_seMaxexpressway6519);
$result_seMaxexpressway6519 = sqlsrv_fetch_array($query_seMaxexpressway6519, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65201 = "20";
$condMaxexpressway65202 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65203 = "";
$sql_seMaxexpressway6520 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6520 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65201, SQLSRV_PARAM_IN),
    array($condMaxexpressway65202, SQLSRV_PARAM_IN),
    array($condMaxexpressway65203, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6520 = sqlsrv_query($conn, $sql_seMaxexpressway6520, $params_seMaxexpressway6520);
$result_seMaxexpressway6520 = sqlsrv_fetch_array($query_seMaxexpressway6520, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65211 = "21";
$condMaxexpressway65212 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65213 = "";
$sql_seMaxexpressway6521 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6521 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65211, SQLSRV_PARAM_IN),
    array($condMaxexpressway65212, SQLSRV_PARAM_IN),
    array($condMaxexpressway65213, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6521 = sqlsrv_query($conn, $sql_seMaxexpressway6521, $params_seMaxexpressway6521);
$result_seMaxexpressway6521 = sqlsrv_fetch_array($query_seMaxexpressway6521, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65221 = "22";
$condMaxexpressway65222 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65223 = "";
$sql_seMaxexpressway6522 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6522 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65221, SQLSRV_PARAM_IN),
    array($condMaxexpressway65222, SQLSRV_PARAM_IN),
    array($condMaxexpressway65223, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6522 = sqlsrv_query($conn, $sql_seMaxexpressway6522, $params_seMaxexpressway6522);
$result_seMaxexpressway6522 = sqlsrv_fetch_array($query_seMaxexpressway6522, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65231 = "23";
$condMaxexpressway65232 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65233 = "";
$sql_seMaxexpressway6523 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6523 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65231, SQLSRV_PARAM_IN),
    array($condMaxexpressway65232, SQLSRV_PARAM_IN),
    array($condMaxexpressway65233, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6523 = sqlsrv_query($conn, $sql_seMaxexpressway6523, $params_seMaxexpressway6523);
$result_seMaxexpressway6523 = sqlsrv_fetch_array($query_seMaxexpressway6523, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65241 = "24";
$condMaxexpressway65242 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65243 = "";
$sql_seMaxexpressway6524 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6524 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65241, SQLSRV_PARAM_IN),
    array($condMaxexpressway65242, SQLSRV_PARAM_IN),
    array($condMaxexpressway65243, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6524 = sqlsrv_query($conn, $sql_seMaxexpressway6524, $params_seMaxexpressway6524);
$result_seMaxexpressway6524 = sqlsrv_fetch_array($query_seMaxexpressway6524, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65251 = "25";
$condMaxexpressway65252 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65253 = "";
$sql_seMaxexpressway6525 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6525 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65251, SQLSRV_PARAM_IN),
    array($condMaxexpressway65252, SQLSRV_PARAM_IN),
    array($condMaxexpressway65253, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6525 = sqlsrv_query($conn, $sql_seMaxexpressway6525, $params_seMaxexpressway6525);
$result_seMaxexpressway6525 = sqlsrv_fetch_array($query_seMaxexpressway6525, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65261 = "26";
$condMaxexpressway65262 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65263 = "";
$sql_seMaxexpressway6526 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6526 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65261, SQLSRV_PARAM_IN),
    array($condMaxexpressway65262, SQLSRV_PARAM_IN),
    array($condMaxexpressway65263, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6526 = sqlsrv_query($conn, $sql_seMaxexpressway6526, $params_seMaxexpressway6526);
$result_seMaxexpressway6526 = sqlsrv_fetch_array($query_seMaxexpressway6526, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65271 = "27";
$condMaxexpressway65272 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65273 = "";
$sql_seMaxexpressway6527 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6527 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65271, SQLSRV_PARAM_IN),
    array($condMaxexpressway65272, SQLSRV_PARAM_IN),
    array($condMaxexpressway65273, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6527 = sqlsrv_query($conn, $sql_seMaxexpressway6527, $params_seMaxexpressway6527);
$result_seMaxexpressway6527 = sqlsrv_fetch_array($query_seMaxexpressway6527, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65281 = "28";
$condMaxexpressway65282 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65283 = "";
$sql_seMaxexpressway6528 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6528 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65281, SQLSRV_PARAM_IN),
    array($condMaxexpressway65282, SQLSRV_PARAM_IN),
    array($condMaxexpressway65283, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6528 = sqlsrv_query($conn, $sql_seMaxexpressway6528, $params_seMaxexpressway6528);
$result_seMaxexpressway6528 = sqlsrv_fetch_array($query_seMaxexpressway6528, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65291 = "29";
$condMaxexpressway65292 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65293 = "";
$sql_seMaxexpressway6529 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6529 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65291, SQLSRV_PARAM_IN),
    array($condMaxexpressway65292, SQLSRV_PARAM_IN),
    array($condMaxexpressway65293, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6529 = sqlsrv_query($conn, $sql_seMaxexpressway6529, $params_seMaxexpressway6529);
$result_seMaxexpressway6529 = sqlsrv_fetch_array($query_seMaxexpressway6529, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65301 = "30";
$condMaxexpressway65302 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65303 = "";
$sql_seMaxexpressway6530 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6530 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65301, SQLSRV_PARAM_IN),
    array($condMaxexpressway65302, SQLSRV_PARAM_IN),
    array($condMaxexpressway65303, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6530 = sqlsrv_query($conn, $sql_seMaxexpressway6530, $params_seMaxexpressway6530);
$result_seMaxexpressway6530 = sqlsrv_fetch_array($query_seMaxexpressway6530, SQLSRV_FETCH_ASSOC);


$condMaxexpressway65311 = "31";
$condMaxexpressway65312 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65313 = "";
$sql_seMaxexpressway6531 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway6531 = array(
    array('select_maxexpressway65', SQLSRV_PARAM_IN),
    array($condMaxexpressway65311, SQLSRV_PARAM_IN),
    array($condMaxexpressway65312, SQLSRV_PARAM_IN),
    array($condMaxexpressway65313, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway6531 = sqlsrv_query($conn, $sql_seMaxexpressway6531, $params_seMaxexpressway6531);
$result_seMaxexpressway6531 = sqlsrv_fetch_array($query_seMaxexpressway6531, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100011 = "01";
$condMaxexpressway100012 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100013 = "";
$sql_seMaxexpressway10001 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10001 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100011, SQLSRV_PARAM_IN),
    array($condMaxexpressway100012, SQLSRV_PARAM_IN),
    array($condMaxexpressway100013, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10001 = sqlsrv_query($conn, $sql_seMaxexpressway10001, $params_seMaxexpressway10001);
$result_seMaxexpressway10001 = sqlsrv_fetch_array($query_seMaxexpressway10001, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100021 = "02";
$condMaxexpressway100022 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100023 = "";
$sql_seMaxexpressway10002 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10002 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100021, SQLSRV_PARAM_IN),
    array($condMaxexpressway100022, SQLSRV_PARAM_IN),
    array($condMaxexpressway100023, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10002 = sqlsrv_query($conn, $sql_seMaxexpressway10002, $params_seMaxexpressway10002);
$result_seMaxexpressway10002 = sqlsrv_fetch_array($query_seMaxexpressway10002, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100031 = "03";
$condMaxexpressway100032 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100033 = "";
$sql_seMaxexpressway10003 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10003 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100031, SQLSRV_PARAM_IN),
    array($condMaxexpressway100032, SQLSRV_PARAM_IN),
    array($condMaxexpressway100033, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10003 = sqlsrv_query($conn, $sql_seMaxexpressway10003, $params_seMaxexpressway10003);
$result_seMaxexpressway10003 = sqlsrv_fetch_array($query_seMaxexpressway10003, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100041 = "04";
$condMaxexpressway100042 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100043 = "";
$sql_seMaxexpressway10004 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10004 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100041, SQLSRV_PARAM_IN),
    array($condMaxexpressway100042, SQLSRV_PARAM_IN),
    array($condMaxexpressway100043, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10004 = sqlsrv_query($conn, $sql_seMaxexpressway10004, $params_seMaxexpressway10004);
$result_seMaxexpressway10004 = sqlsrv_fetch_array($query_seMaxexpressway10004, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100051 = "05";
$condMaxexpressway100052 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100053 = "";
$sql_seMaxexpressway10005 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10005 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100051, SQLSRV_PARAM_IN),
    array($condMaxexpressway100052, SQLSRV_PARAM_IN),
    array($condMaxexpressway100053, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10005 = sqlsrv_query($conn, $sql_seMaxexpressway10005, $params_seMaxexpressway10005);
$result_seMaxexpressway10005 = sqlsrv_fetch_array($query_seMaxexpressway10005, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100061 = "06";
$condMaxexpressway100062 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100063 = "";
$sql_seMaxexpressway10006 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10006 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100061, SQLSRV_PARAM_IN),
    array($condMaxexpressway100062, SQLSRV_PARAM_IN),
    array($condMaxexpressway100063, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10006 = sqlsrv_query($conn, $sql_seMaxexpressway10006, $params_seMaxexpressway10006);
$result_seMaxexpressway10006 = sqlsrv_fetch_array($query_seMaxexpressway10006, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100071 = "07";
$condMaxexpressway100072 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100073 = "";
$sql_seMaxexpressway10007 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10007 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100071, SQLSRV_PARAM_IN),
    array($condMaxexpressway100072, SQLSRV_PARAM_IN),
    array($condMaxexpressway100073, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10007 = sqlsrv_query($conn, $sql_seMaxexpressway10007, $params_seMaxexpressway10007);
$result_seMaxexpressway10007 = sqlsrv_fetch_array($query_seMaxexpressway10007, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100081 = "08";
$condMaxexpressway100082 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100083 = "";
$sql_seMaxexpressway10008 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10008 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100081, SQLSRV_PARAM_IN),
    array($condMaxexpressway100082, SQLSRV_PARAM_IN),
    array($condMaxexpressway100083, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10008 = sqlsrv_query($conn, $sql_seMaxexpressway10008, $params_seMaxexpressway10008);
$result_seMaxexpressway10008 = sqlsrv_fetch_array($query_seMaxexpressway10008, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100091 = "09";
$condMaxexpressway100092 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100093 = "";
$sql_seMaxexpressway10009 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10009 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100091, SQLSRV_PARAM_IN),
    array($condMaxexpressway100092, SQLSRV_PARAM_IN),
    array($condMaxexpressway100093, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10009 = sqlsrv_query($conn, $sql_seMaxexpressway10009, $params_seMaxexpressway10009);
$result_seMaxexpressway10009 = sqlsrv_fetch_array($query_seMaxexpressway10009, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100101 = "10";
$condMaxexpressway100102 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100103 = "";
$sql_seMaxexpressway10010 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10010 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100101, SQLSRV_PARAM_IN),
    array($condMaxexpressway100102, SQLSRV_PARAM_IN),
    array($condMaxexpressway100103, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10010 = sqlsrv_query($conn, $sql_seMaxexpressway10010, $params_seMaxexpressway10010);
$result_seMaxexpressway10010 = sqlsrv_fetch_array($query_seMaxexpressway10010, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100111 = "11";
$condMaxexpressway100112 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100113 = "";
$sql_seMaxexpressway10011 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10011 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100111, SQLSRV_PARAM_IN),
    array($condMaxexpressway100112, SQLSRV_PARAM_IN),
    array($condMaxexpressway100113, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10011 = sqlsrv_query($conn, $sql_seMaxexpressway10011, $params_seMaxexpressway10011);
$result_seMaxexpressway10011 = sqlsrv_fetch_array($query_seMaxexpressway10011, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100121 = "12";
$condMaxexpressway100122 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100123 = "";
$sql_seMaxexpressway10012 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10012 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100121, SQLSRV_PARAM_IN),
    array($condMaxexpressway100122, SQLSRV_PARAM_IN),
    array($condMaxexpressway100123, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10012 = sqlsrv_query($conn, $sql_seMaxexpressway10012, $params_seMaxexpressway10012);
$result_seMaxexpressway10012 = sqlsrv_fetch_array($query_seMaxexpressway10012, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100131 = "13";
$condMaxexpressway100132 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100133 = "";
$sql_seMaxexpressway10013 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10013 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100131, SQLSRV_PARAM_IN),
    array($condMaxexpressway100132, SQLSRV_PARAM_IN),
    array($condMaxexpressway100133, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10013 = sqlsrv_query($conn, $sql_seMaxexpressway10013, $params_seMaxexpressway10013);
$result_seMaxexpressway10013 = sqlsrv_fetch_array($query_seMaxexpressway10013, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100141 = "14";
$condMaxexpressway100142 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100143 = "";
$sql_seMaxexpressway10014 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10014 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100141, SQLSRV_PARAM_IN),
    array($condMaxexpressway100142, SQLSRV_PARAM_IN),
    array($condMaxexpressway100143, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10014 = sqlsrv_query($conn, $sql_seMaxexpressway10014, $params_seMaxexpressway10014);
$result_seMaxexpressway10014 = sqlsrv_fetch_array($query_seMaxexpressway10014, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100151 = "15";
$condMaxexpressway100152 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100153 = "";
$sql_seMaxexpressway10015 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10015 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100151, SQLSRV_PARAM_IN),
    array($condMaxexpressway100152, SQLSRV_PARAM_IN),
    array($condMaxexpressway100153, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10015 = sqlsrv_query($conn, $sql_seMaxexpressway10015, $params_seMaxexpressway10015);
$result_seMaxexpressway10015 = sqlsrv_fetch_array($query_seMaxexpressway10015, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100161 = "16";
$condMaxexpressway100162 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100163 = "";
$sql_seMaxexpressway10016 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10016 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100161, SQLSRV_PARAM_IN),
    array($condMaxexpressway100162, SQLSRV_PARAM_IN),
    array($condMaxexpressway100163, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10016 = sqlsrv_query($conn, $sql_seMaxexpressway10016, $params_seMaxexpressway10016);
$result_seMaxexpressway10016 = sqlsrv_fetch_array($query_seMaxexpressway10016, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100171 = "17";
$condMaxexpressway100172 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100173 = "";
$sql_seMaxexpressway10017 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10017 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100171, SQLSRV_PARAM_IN),
    array($condMaxexpressway100172, SQLSRV_PARAM_IN),
    array($condMaxexpressway100173, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10017 = sqlsrv_query($conn, $sql_seMaxexpressway10017, $params_seMaxexpressway10017);
$result_seMaxexpressway10017 = sqlsrv_fetch_array($query_seMaxexpressway10017, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100181 = "18";
$condMaxexpressway100182 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100183 = "";
$sql_seMaxexpressway10018 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10018 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100181, SQLSRV_PARAM_IN),
    array($condMaxexpressway100182, SQLSRV_PARAM_IN),
    array($condMaxexpressway100183, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10018 = sqlsrv_query($conn, $sql_seMaxexpressway10018, $params_seMaxexpressway10018);
$result_seMaxexpressway10018 = sqlsrv_fetch_array($query_seMaxexpressway10018, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100191 = "19";
$condMaxexpressway100192 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100193 = "";
$sql_seMaxexpressway10019 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10019 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100191, SQLSRV_PARAM_IN),
    array($condMaxexpressway100192, SQLSRV_PARAM_IN),
    array($condMaxexpressway100193, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10019 = sqlsrv_query($conn, $sql_seMaxexpressway10019, $params_seMaxexpressway10019);
$result_seMaxexpressway10019 = sqlsrv_fetch_array($query_seMaxexpressway10019, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100201 = "20";
$condMaxexpressway100202 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100203 = "";
$sql_seMaxexpressway10020 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10020 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100201, SQLSRV_PARAM_IN),
    array($condMaxexpressway100202, SQLSRV_PARAM_IN),
    array($condMaxexpressway100203, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10020 = sqlsrv_query($conn, $sql_seMaxexpressway10020, $params_seMaxexpressway10020);
$result_seMaxexpressway10020 = sqlsrv_fetch_array($query_seMaxexpressway10020, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100211 = "21";
$condMaxexpressway100212 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100213 = "";
$sql_seMaxexpressway10021 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10021 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100211, SQLSRV_PARAM_IN),
    array($condMaxexpressway100212, SQLSRV_PARAM_IN),
    array($condMaxexpressway100213, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10021 = sqlsrv_query($conn, $sql_seMaxexpressway10021, $params_seMaxexpressway10021);
$result_seMaxexpressway10021 = sqlsrv_fetch_array($query_seMaxexpressway10021, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100221 = "22";
$condMaxexpressway100222 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100223 = "";
$sql_seMaxexpressway10022 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10022 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100221, SQLSRV_PARAM_IN),
    array($condMaxexpressway100222, SQLSRV_PARAM_IN),
    array($condMaxexpressway100223, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10022 = sqlsrv_query($conn, $sql_seMaxexpressway10022, $params_seMaxexpressway10022);
$result_seMaxexpressway10022 = sqlsrv_fetch_array($query_seMaxexpressway10022, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100231 = "23";
$condMaxexpressway100232 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100233 = "";
$sql_seMaxexpressway10023 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10023 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100231, SQLSRV_PARAM_IN),
    array($condMaxexpressway100232, SQLSRV_PARAM_IN),
    array($condMaxexpressway100233, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10023 = sqlsrv_query($conn, $sql_seMaxexpressway10023, $params_seMaxexpressway10023);
$result_seMaxexpressway10023 = sqlsrv_fetch_array($query_seMaxexpressway10023, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100241 = "24";
$condMaxexpressway100242 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100243 = "";
$sql_seMaxexpressway10024 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10024 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100241, SQLSRV_PARAM_IN),
    array($condMaxexpressway100242, SQLSRV_PARAM_IN),
    array($condMaxexpressway100243, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10024 = sqlsrv_query($conn, $sql_seMaxexpressway10024, $params_seMaxexpressway10024);
$result_seMaxexpressway10024 = sqlsrv_fetch_array($query_seMaxexpressway10024, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100251 = "25";
$condMaxexpressway100252 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100253 = "";
$sql_seMaxexpressway10025 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10025 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100251, SQLSRV_PARAM_IN),
    array($condMaxexpressway100252, SQLSRV_PARAM_IN),
    array($condMaxexpressway100253, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10025 = sqlsrv_query($conn, $sql_seMaxexpressway10025, $params_seMaxexpressway10025);
$result_seMaxexpressway10025 = sqlsrv_fetch_array($query_seMaxexpressway10025, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100261 = "26";
$condMaxexpressway100262 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100263 = "";
$sql_seMaxexpressway10026 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10026 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100261, SQLSRV_PARAM_IN),
    array($condMaxexpressway100262, SQLSRV_PARAM_IN),
    array($condMaxexpressway100263, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10026 = sqlsrv_query($conn, $sql_seMaxexpressway10026, $params_seMaxexpressway10026);
$result_seMaxexpressway10026 = sqlsrv_fetch_array($query_seMaxexpressway10026, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100271 = "27";
$condMaxexpressway100272 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100273 = "";
$sql_seMaxexpressway10027 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10027 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100271, SQLSRV_PARAM_IN),
    array($condMaxexpressway100272, SQLSRV_PARAM_IN),
    array($condMaxexpressway100273, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10027 = sqlsrv_query($conn, $sql_seMaxexpressway10027, $params_seMaxexpressway10027);
$result_seMaxexpressway10027 = sqlsrv_fetch_array($query_seMaxexpressway10027, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100281 = "28";
$condMaxexpressway100282 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100283 = "";
$sql_seMaxexpressway10028 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10028 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100281, SQLSRV_PARAM_IN),
    array($condMaxexpressway100282, SQLSRV_PARAM_IN),
    array($condMaxexpressway100283, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10028 = sqlsrv_query($conn, $sql_seMaxexpressway10028, $params_seMaxexpressway10028);
$result_seMaxexpressway10028 = sqlsrv_fetch_array($query_seMaxexpressway10028, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100291 = "29";
$condMaxexpressway100292 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100293 = "";
$sql_seMaxexpressway10029 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10029 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100291, SQLSRV_PARAM_IN),
    array($condMaxexpressway100292, SQLSRV_PARAM_IN),
    array($condMaxexpressway100293, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10029 = sqlsrv_query($conn, $sql_seMaxexpressway10029, $params_seMaxexpressway10029);
$result_seMaxexpressway10029 = sqlsrv_fetch_array($query_seMaxexpressway10029, SQLSRV_FETCH_ASSOC);

$condMaxexpressway100301 = "30";
$condMaxexpressway100302 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100303 = "";
$sql_seMaxexpressway10030 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10030 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100301, SQLSRV_PARAM_IN),
    array($condMaxexpressway100302, SQLSRV_PARAM_IN),
    array($condMaxexpressway100303, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10030 = sqlsrv_query($conn, $sql_seMaxexpressway10030, $params_seMaxexpressway10030);
$result_seMaxexpressway10030 = sqlsrv_fetch_array($query_seMaxexpressway10030, SQLSRV_FETCH_ASSOC);


$condMaxexpressway100311 = "31";
$condMaxexpressway100312 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway100313 = "";
$sql_seMaxexpressway10031 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway10031 = array(
    array('select_maxexpressway100', SQLSRV_PARAM_IN),
    array($condMaxexpressway100311, SQLSRV_PARAM_IN),
    array($condMaxexpressway100312, SQLSRV_PARAM_IN),
    array($condMaxexpressway100313, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway10031 = sqlsrv_query($conn, $sql_seMaxexpressway10031, $params_seMaxexpressway10031);
$result_seMaxexpressway10031 = sqlsrv_fetch_array($query_seMaxexpressway10031, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return011 = "01";
$condMaxexpressway65return012 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return013 = "";
$sql_seMaxexpressway65return01 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return01 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return011, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return012, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return013, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return01 = sqlsrv_query($conn, $sql_seMaxexpressway65return01, $params_seMaxexpressway65return01);
$result_seMaxexpressway65return01 = sqlsrv_fetch_array($query_seMaxexpressway65return01, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return021 = "02";
$condMaxexpressway65return022 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return023 = "";
$sql_seMaxexpressway65return02 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return02 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return021, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return022, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return023, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return02 = sqlsrv_query($conn, $sql_seMaxexpressway65return02, $params_seMaxexpressway65return02);
$result_seMaxexpressway65return02 = sqlsrv_fetch_array($query_seMaxexpressway65return02, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return031 = "03";
$condMaxexpressway65return032 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return033 = "";
$sql_seMaxexpressway65return03 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return03 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return031, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return032, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return033, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return03 = sqlsrv_query($conn, $sql_seMaxexpressway65return03, $params_seMaxexpressway65return03);
$result_seMaxexpressway65return03 = sqlsrv_fetch_array($query_seMaxexpressway65return03, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return041 = "04";
$condMaxexpressway65return042 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return043 = "";
$sql_seMaxexpressway65return04 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return04 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return041, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return042, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return043, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return04 = sqlsrv_query($conn, $sql_seMaxexpressway65return04, $params_seMaxexpressway65return04);
$result_seMaxexpressway65return04 = sqlsrv_fetch_array($query_seMaxexpressway65return04, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return051 = "05";
$condMaxexpressway65return052 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return053 = "";
$sql_seMaxexpressway65return05 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return05 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return051, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return052, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return053, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return05 = sqlsrv_query($conn, $sql_seMaxexpressway65return05, $params_seMaxexpressway65return05);
$result_seMaxexpressway65return05 = sqlsrv_fetch_array($query_seMaxexpressway65return05, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return061 = "06";
$condMaxexpressway65return062 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return063 = "";
$sql_seMaxexpressway65return06 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return06 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return061, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return062, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return063, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return06 = sqlsrv_query($conn, $sql_seMaxexpressway65return06, $params_seMaxexpressway65return06);
$result_seMaxexpressway65return06 = sqlsrv_fetch_array($query_seMaxexpressway65return06, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return071 = "07";
$condMaxexpressway65return072 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return073 = "";
$sql_seMaxexpressway65return07 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return07 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return071, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return072, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return073, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return07 = sqlsrv_query($conn, $sql_seMaxexpressway65return07, $params_seMaxexpressway65return07);
$result_seMaxexpressway65return07 = sqlsrv_fetch_array($query_seMaxexpressway65return07, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return081 = "08";
$condMaxexpressway65return082 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return083 = "";
$sql_seMaxexpressway65return08 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return08 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return081, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return082, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return083, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return08 = sqlsrv_query($conn, $sql_seMaxexpressway65return08, $params_seMaxexpressway65return08);
$result_seMaxexpressway65return08 = sqlsrv_fetch_array($query_seMaxexpressway65return08, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return091 = "09";
$condMaxexpressway65return092 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return093 = "";
$sql_seMaxexpressway65return09 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return09 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return091, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return092, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return093, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return09 = sqlsrv_query($conn, $sql_seMaxexpressway65return09, $params_seMaxexpressway65return09);
$result_seMaxexpressway65return09 = sqlsrv_fetch_array($query_seMaxexpressway65return09, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return101 = "10";
$condMaxexpressway65return102 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return103 = "";
$sql_seMaxexpressway65return10 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return10 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return101, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return102, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return103, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return10 = sqlsrv_query($conn, $sql_seMaxexpressway65return10, $params_seMaxexpressway65return10);
$result_seMaxexpressway65return10 = sqlsrv_fetch_array($query_seMaxexpressway65return10, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return111 = "11";
$condMaxexpressway65return112 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return113 = "";
$sql_seMaxexpressway65return11 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return11 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return111, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return112, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return113, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return11 = sqlsrv_query($conn, $sql_seMaxexpressway65return11, $params_seMaxexpressway65return11);
$result_seMaxexpressway65return11 = sqlsrv_fetch_array($query_seMaxexpressway65return11, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return121 = "12";
$condMaxexpressway65return122 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return123 = "";
$sql_seMaxexpressway65return12 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return12 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return121, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return122, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return123, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return12 = sqlsrv_query($conn, $sql_seMaxexpressway65return12, $params_seMaxexpressway65return12);
$result_seMaxexpressway65return12 = sqlsrv_fetch_array($query_seMaxexpressway65return12, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return131 = "13";
$condMaxexpressway65return132 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return133 = "";
$sql_seMaxexpressway65return13 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return13 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return131, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return132, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return133, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return13 = sqlsrv_query($conn, $sql_seMaxexpressway65return13, $params_seMaxexpressway65return13);
$result_seMaxexpressway65return13 = sqlsrv_fetch_array($query_seMaxexpressway65return13, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return141 = "14";
$condMaxexpressway65return142 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return143 = "";
$sql_seMaxexpressway65return14 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return14 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return141, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return142, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return143, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return14 = sqlsrv_query($conn, $sql_seMaxexpressway65return14, $params_seMaxexpressway65return14);
$result_seMaxexpressway65return14 = sqlsrv_fetch_array($query_seMaxexpressway65return14, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return151 = "15";
$condMaxexpressway65return152 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return153 = "";
$sql_seMaxexpressway65return15 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return15 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return151, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return152, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return153, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return15 = sqlsrv_query($conn, $sql_seMaxexpressway65return15, $params_seMaxexpressway65return15);
$result_seMaxexpressway65return15 = sqlsrv_fetch_array($query_seMaxexpressway65return15, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return161 = "16";
$condMaxexpressway65return162 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return163 = "";
$sql_seMaxexpressway65return16 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return16 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return161, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return162, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return163, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return16 = sqlsrv_query($conn, $sql_seMaxexpressway65return16, $params_seMaxexpressway65return16);
$result_seMaxexpressway65return16 = sqlsrv_fetch_array($query_seMaxexpressway65return16, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return171 = "17";
$condMaxexpressway65return172 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return173 = "";
$sql_seMaxexpressway65return17 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return17 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return171, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return172, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return173, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return17 = sqlsrv_query($conn, $sql_seMaxexpressway65return17, $params_seMaxexpressway65return17);
$result_seMaxexpressway65return17 = sqlsrv_fetch_array($query_seMaxexpressway65return17, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return181 = "18";
$condMaxexpressway65return182 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return183 = "";
$sql_seMaxexpressway65return18 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return18 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return181, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return182, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return183, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return18 = sqlsrv_query($conn, $sql_seMaxexpressway65return18, $params_seMaxexpressway65return18);
$result_seMaxexpressway65return18 = sqlsrv_fetch_array($query_seMaxexpressway65return18, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return191 = "19";
$condMaxexpressway65return192 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return193 = "";
$sql_seMaxexpressway65return19 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return19 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return191, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return192, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return193, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return19 = sqlsrv_query($conn, $sql_seMaxexpressway65return19, $params_seMaxexpressway65return19);
$result_seMaxexpressway65return19 = sqlsrv_fetch_array($query_seMaxexpressway65return19, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return201 = "20";
$condMaxexpressway65return202 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return203 = "";
$sql_seMaxexpressway65return20 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return20 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return201, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return202, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return203, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return20 = sqlsrv_query($conn, $sql_seMaxexpressway65return20, $params_seMaxexpressway65return20);
$result_seMaxexpressway65return20 = sqlsrv_fetch_array($query_seMaxexpressway65return20, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return211 = "21";
$condMaxexpressway65return212 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return213 = "";
$sql_seMaxexpressway65return21 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return21 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return211, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return212, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return213, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return21 = sqlsrv_query($conn, $sql_seMaxexpressway65return21, $params_seMaxexpressway65return21);
$result_seMaxexpressway65return21 = sqlsrv_fetch_array($query_seMaxexpressway65return21, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return221 = "22";
$condMaxexpressway65return222 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return223 = "";
$sql_seMaxexpressway65return22 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return22 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return221, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return222, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return223, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return22 = sqlsrv_query($conn, $sql_seMaxexpressway65return22, $params_seMaxexpressway65return22);
$result_seMaxexpressway65return22 = sqlsrv_fetch_array($query_seMaxexpressway65return22, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return231 = "23";
$condMaxexpressway65return232 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return233 = "";
$sql_seMaxexpressway65return23 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return23 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return231, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return232, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return233, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return23 = sqlsrv_query($conn, $sql_seMaxexpressway65return23, $params_seMaxexpressway65return23);
$result_seMaxexpressway65return23 = sqlsrv_fetch_array($query_seMaxexpressway65return23, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return241 = "24";
$condMaxexpressway65return242 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return243 = "";
$sql_seMaxexpressway65return24 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return24 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return241, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return242, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return243, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return24 = sqlsrv_query($conn, $sql_seMaxexpressway65return24, $params_seMaxexpressway65return24);
$result_seMaxexpressway65return24 = sqlsrv_fetch_array($query_seMaxexpressway65return24, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return251 = "25";
$condMaxexpressway65return252 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return253 = "";
$sql_seMaxexpressway65return25 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return25 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return251, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return252, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return253, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return25 = sqlsrv_query($conn, $sql_seMaxexpressway65return25, $params_seMaxexpressway65return25);
$result_seMaxexpressway65return25 = sqlsrv_fetch_array($query_seMaxexpressway65return25, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return261 = "26";
$condMaxexpressway65return262 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return263 = "";
$sql_seMaxexpressway65return26 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return26 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return261, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return262, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return263, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return26 = sqlsrv_query($conn, $sql_seMaxexpressway65return26, $params_seMaxexpressway65return26);
$result_seMaxexpressway65return26 = sqlsrv_fetch_array($query_seMaxexpressway65return26, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return271 = "27";
$condMaxexpressway65return272 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return273 = "";
$sql_seMaxexpressway65return27 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return27 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return271, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return272, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return273, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return27 = sqlsrv_query($conn, $sql_seMaxexpressway65return27, $params_seMaxexpressway65return27);
$result_seMaxexpressway65return27 = sqlsrv_fetch_array($query_seMaxexpressway65return27, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return281 = "28";
$condMaxexpressway65return282 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return283 = "";
$sql_seMaxexpressway65return28 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return28 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return281, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return282, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return283, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return28 = sqlsrv_query($conn, $sql_seMaxexpressway65return28, $params_seMaxexpressway65return28);
$result_seMaxexpressway65return28 = sqlsrv_fetch_array($query_seMaxexpressway65return28, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return291 = "29";
$condMaxexpressway65return292 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return293 = "";
$sql_seMaxexpressway65return29 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return29 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return291, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return292, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return293, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return29 = sqlsrv_query($conn, $sql_seMaxexpressway65return29, $params_seMaxexpressway65return29);
$result_seMaxexpressway65return29 = sqlsrv_fetch_array($query_seMaxexpressway65return29, SQLSRV_FETCH_ASSOC);

$condMaxexpressway65return301 = "30";
$condMaxexpressway65return302 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return303 = "";
$sql_seMaxexpressway65return30 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return30 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return301, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return302, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return303, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return30 = sqlsrv_query($conn, $sql_seMaxexpressway65return30, $params_seMaxexpressway65return30);
$result_seMaxexpressway65return30 = sqlsrv_fetch_array($query_seMaxexpressway65return30, SQLSRV_FETCH_ASSOC);


$condMaxexpressway65return311 = "31";
$condMaxexpressway65return312 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway65return313 = "";
$sql_seMaxexpressway65return31 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway65return31 = array(
    array('select_maxexpressway65return', SQLSRV_PARAM_IN),
    array($condMaxexpressway65return311, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return312, SQLSRV_PARAM_IN),
    array($condMaxexpressway65return313, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway65return31 = sqlsrv_query($conn, $sql_seMaxexpressway65return31, $params_seMaxexpressway65return31);
$result_seMaxexpressway65return31 = sqlsrv_fetch_array($query_seMaxexpressway65return31, SQLSRV_FETCH_ASSOC);


$condMaxexpressway105return011 = "01";
$condMaxexpressway105return012 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return013 = "";
$sql_seMaxexpressway105return01 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return01 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return011, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return012, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return013, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return01 = sqlsrv_query($conn, $sql_seMaxexpressway105return01, $params_seMaxexpressway105return01);
$result_seMaxexpressway105return01 = sqlsrv_fetch_array($query_seMaxexpressway105return01, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return021 = "02";
$condMaxexpressway105return022 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return023 = "";
$sql_seMaxexpressway105return02 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return02 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return021, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return022, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return023, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return02 = sqlsrv_query($conn, $sql_seMaxexpressway105return02, $params_seMaxexpressway105return02);
$result_seMaxexpressway105return02 = sqlsrv_fetch_array($query_seMaxexpressway105return02, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return031 = "03";
$condMaxexpressway105return032 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return033 = "";
$sql_seMaxexpressway105return03 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return03 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return031, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return032, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return033, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return03 = sqlsrv_query($conn, $sql_seMaxexpressway105return03, $params_seMaxexpressway105return03);
$result_seMaxexpressway105return03 = sqlsrv_fetch_array($query_seMaxexpressway105return03, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return041 = "04";
$condMaxexpressway105return042 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return043 = "";
$sql_seMaxexpressway105return04 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return04 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return041, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return042, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return043, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return04 = sqlsrv_query($conn, $sql_seMaxexpressway105return04, $params_seMaxexpressway105return04);
$result_seMaxexpressway105return04 = sqlsrv_fetch_array($query_seMaxexpressway105return04, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return051 = "05";
$condMaxexpressway105return052 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return053 = "";
$sql_seMaxexpressway105return05 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return05 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return051, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return052, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return053, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return05 = sqlsrv_query($conn, $sql_seMaxexpressway105return05, $params_seMaxexpressway105return05);
$result_seMaxexpressway105return05 = sqlsrv_fetch_array($query_seMaxexpressway105return05, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return061 = "06";
$condMaxexpressway105return062 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return063 = "";
$sql_seMaxexpressway105return06 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return06 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return061, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return062, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return063, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return06 = sqlsrv_query($conn, $sql_seMaxexpressway105return06, $params_seMaxexpressway105return06);
$result_seMaxexpressway105return06 = sqlsrv_fetch_array($query_seMaxexpressway105return06, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return071 = "07";
$condMaxexpressway105return072 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return073 = "";
$sql_seMaxexpressway105return07 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return07 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return071, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return072, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return073, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return07 = sqlsrv_query($conn, $sql_seMaxexpressway105return07, $params_seMaxexpressway105return07);
$result_seMaxexpressway105return07 = sqlsrv_fetch_array($query_seMaxexpressway105return07, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return081 = "08";
$condMaxexpressway105return082 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return083 = "";
$sql_seMaxexpressway105return08 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return08 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return081, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return082, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return083, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return08 = sqlsrv_query($conn, $sql_seMaxexpressway105return08, $params_seMaxexpressway105return08);
$result_seMaxexpressway105return08 = sqlsrv_fetch_array($query_seMaxexpressway105return08, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return091 = "09";
$condMaxexpressway105return092 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return093 = "";
$sql_seMaxexpressway105return09 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return09 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return091, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return092, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return093, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return09 = sqlsrv_query($conn, $sql_seMaxexpressway105return09, $params_seMaxexpressway105return09);
$result_seMaxexpressway105return09 = sqlsrv_fetch_array($query_seMaxexpressway105return09, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return101 = "10";
$condMaxexpressway105return102 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return103 = "";
$sql_seMaxexpressway105return10 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return10 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return101, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return102, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return103, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return10 = sqlsrv_query($conn, $sql_seMaxexpressway105return10, $params_seMaxexpressway105return10);
$result_seMaxexpressway105return10 = sqlsrv_fetch_array($query_seMaxexpressway105return10, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return111 = "11";
$condMaxexpressway105return112 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return113 = "";
$sql_seMaxexpressway105return11 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return11 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return111, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return112, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return113, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return11 = sqlsrv_query($conn, $sql_seMaxexpressway105return11, $params_seMaxexpressway105return11);
$result_seMaxexpressway105return11 = sqlsrv_fetch_array($query_seMaxexpressway105return11, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return121 = "12";
$condMaxexpressway105return122 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return123 = "";
$sql_seMaxexpressway105return12 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return12 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return121, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return122, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return123, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return12 = sqlsrv_query($conn, $sql_seMaxexpressway105return12, $params_seMaxexpressway105return12);
$result_seMaxexpressway105return12 = sqlsrv_fetch_array($query_seMaxexpressway105return12, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return131 = "13";
$condMaxexpressway105return132 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return133 = "";
$sql_seMaxexpressway105return13 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return13 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return131, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return132, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return133, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return13 = sqlsrv_query($conn, $sql_seMaxexpressway105return13, $params_seMaxexpressway105return13);
$result_seMaxexpressway105return13 = sqlsrv_fetch_array($query_seMaxexpressway105return13, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return141 = "14";
$condMaxexpressway105return142 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return143 = "";
$sql_seMaxexpressway105return14 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return14 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return141, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return142, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return143, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return14 = sqlsrv_query($conn, $sql_seMaxexpressway105return14, $params_seMaxexpressway105return14);
$result_seMaxexpressway105return14 = sqlsrv_fetch_array($query_seMaxexpressway105return14, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return151 = "15";
$condMaxexpressway105return152 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return153 = "";
$sql_seMaxexpressway105return15 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return15 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return151, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return152, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return153, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return15 = sqlsrv_query($conn, $sql_seMaxexpressway105return15, $params_seMaxexpressway105return15);
$result_seMaxexpressway105return15 = sqlsrv_fetch_array($query_seMaxexpressway105return15, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return161 = "16";
$condMaxexpressway105return162 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return163 = "";
$sql_seMaxexpressway105return16 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return16 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return161, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return162, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return163, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return16 = sqlsrv_query($conn, $sql_seMaxexpressway105return16, $params_seMaxexpressway105return16);
$result_seMaxexpressway105return16 = sqlsrv_fetch_array($query_seMaxexpressway105return16, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return171 = "17";
$condMaxexpressway105return172 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return173 = "";
$sql_seMaxexpressway105return17 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return17 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return171, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return172, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return173, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return17 = sqlsrv_query($conn, $sql_seMaxexpressway105return17, $params_seMaxexpressway105return17);
$result_seMaxexpressway105return17 = sqlsrv_fetch_array($query_seMaxexpressway105return17, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return181 = "18";
$condMaxexpressway105return182 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return183 = "";
$sql_seMaxexpressway105return18 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return18 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return181, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return182, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return183, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return18 = sqlsrv_query($conn, $sql_seMaxexpressway105return18, $params_seMaxexpressway105return18);
$result_seMaxexpressway105return18 = sqlsrv_fetch_array($query_seMaxexpressway105return18, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return191 = "19";
$condMaxexpressway105return192 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return193 = "";
$sql_seMaxexpressway105return19 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return19 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return191, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return192, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return193, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return19 = sqlsrv_query($conn, $sql_seMaxexpressway105return19, $params_seMaxexpressway105return19);
$result_seMaxexpressway105return19 = sqlsrv_fetch_array($query_seMaxexpressway105return19, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return201 = "20";
$condMaxexpressway105return202 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return203 = "";
$sql_seMaxexpressway105return20 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return20 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return201, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return202, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return203, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return20 = sqlsrv_query($conn, $sql_seMaxexpressway105return20, $params_seMaxexpressway105return20);
$result_seMaxexpressway105return20 = sqlsrv_fetch_array($query_seMaxexpressway105return20, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return211 = "21";
$condMaxexpressway105return212 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return213 = "";
$sql_seMaxexpressway105return21 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return21 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return211, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return212, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return213, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return21 = sqlsrv_query($conn, $sql_seMaxexpressway105return21, $params_seMaxexpressway105return21);
$result_seMaxexpressway105return21 = sqlsrv_fetch_array($query_seMaxexpressway105return21, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return221 = "22";
$condMaxexpressway105return222 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return223 = "";
$sql_seMaxexpressway105return22 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return22 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return221, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return222, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return223, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return22 = sqlsrv_query($conn, $sql_seMaxexpressway105return22, $params_seMaxexpressway105return22);
$result_seMaxexpressway105return22 = sqlsrv_fetch_array($query_seMaxexpressway105return22, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return231 = "23";
$condMaxexpressway105return232 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return233 = "";
$sql_seMaxexpressway105return23 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return23 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return231, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return232, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return233, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return23 = sqlsrv_query($conn, $sql_seMaxexpressway105return23, $params_seMaxexpressway105return23);
$result_seMaxexpressway105return23 = sqlsrv_fetch_array($query_seMaxexpressway105return23, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return241 = "24";
$condMaxexpressway105return242 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return243 = "";
$sql_seMaxexpressway105return24 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return24 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return241, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return242, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return243, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return24 = sqlsrv_query($conn, $sql_seMaxexpressway105return24, $params_seMaxexpressway105return24);
$result_seMaxexpressway105return24 = sqlsrv_fetch_array($query_seMaxexpressway105return24, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return251 = "25";
$condMaxexpressway105return252 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return253 = "";
$sql_seMaxexpressway105return25 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return25 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return251, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return252, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return253, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return25 = sqlsrv_query($conn, $sql_seMaxexpressway105return25, $params_seMaxexpressway105return25);
$result_seMaxexpressway105return25 = sqlsrv_fetch_array($query_seMaxexpressway105return25, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return261 = "26";
$condMaxexpressway105return262 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return263 = "";
$sql_seMaxexpressway105return26 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return26 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return261, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return262, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return263, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return26 = sqlsrv_query($conn, $sql_seMaxexpressway105return26, $params_seMaxexpressway105return26);
$result_seMaxexpressway105return26 = sqlsrv_fetch_array($query_seMaxexpressway105return26, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return271 = "27";
$condMaxexpressway105return272 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return273 = "";
$sql_seMaxexpressway105return27 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return27 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return271, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return272, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return273, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return27 = sqlsrv_query($conn, $sql_seMaxexpressway105return27, $params_seMaxexpressway105return27);
$result_seMaxexpressway105return27 = sqlsrv_fetch_array($query_seMaxexpressway105return27, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return281 = "28";
$condMaxexpressway105return282 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return283 = "";
$sql_seMaxexpressway105return28 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return28 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return281, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return282, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return283, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return28 = sqlsrv_query($conn, $sql_seMaxexpressway105return28, $params_seMaxexpressway105return28);
$result_seMaxexpressway105return28 = sqlsrv_fetch_array($query_seMaxexpressway105return28, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return291 = "29";
$condMaxexpressway105return292 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return293 = "";
$sql_seMaxexpressway105return29 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return29 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return291, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return292, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return293, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return29 = sqlsrv_query($conn, $sql_seMaxexpressway105return29, $params_seMaxexpressway105return29);
$result_seMaxexpressway105return29 = sqlsrv_fetch_array($query_seMaxexpressway105return29, SQLSRV_FETCH_ASSOC);

$condMaxexpressway105return301 = "30";
$condMaxexpressway105return302 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return303 = "";
$sql_seMaxexpressway105return30 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return30 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return301, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return302, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return303, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return30 = sqlsrv_query($conn, $sql_seMaxexpressway105return30, $params_seMaxexpressway105return30);
$result_seMaxexpressway105return30 = sqlsrv_fetch_array($query_seMaxexpressway105return30, SQLSRV_FETCH_ASSOC);


$condMaxexpressway105return311 = "31";
$condMaxexpressway105return312 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
$condMaxexpressway105return313 = "";
$sql_seMaxexpressway105return31 = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seMaxexpressway105return31 = array(
    array('select_maxexpressway105return', SQLSRV_PARAM_IN),
    array($condMaxexpressway105return311, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return312, SQLSRV_PARAM_IN),
    array($condMaxexpressway105return313, SQLSRV_PARAM_IN)
);
$query_seMaxexpressway105return31 = sqlsrv_query($conn, $sql_seMaxexpressway105return31, $params_seMaxexpressway105return31);
$result_seMaxexpressway105return31 = sqlsrv_fetch_array($query_seMaxexpressway105return31, SQLSRV_FETCH_ASSOC);


$condExpressway10w1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' AND c.VEHICLETYPE = '10W'";
$condExpressway10w2 = "";
$sql_seExpressway10w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seExpressway10w = array(
    array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
    array($condExpressway10w1, SQLSRV_PARAM_IN),
    array($condExpressway10w2, SQLSRV_PARAM_IN)
);
$query_seExpressway10w = sqlsrv_query($conn, $sql_seExpressway10w, $params_seExpressway10w);
$result_seExpressway10w = sqlsrv_fetch_array($query_seExpressway10w, SQLSRV_FETCH_ASSOC);

$condExpressway6w1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' AND c.VEHICLETYPE = '6W'";
$condExpressway6w2 = "";
$sql_seExpressway6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seExpressway6w = array(
    array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
    array($condExpressway6w1, SQLSRV_PARAM_IN),
    array($condExpressway6w2, SQLSRV_PARAM_IN)
);
$query_seExpressway6w = sqlsrv_query($conn, $sql_seExpressway6w, $params_seExpressway6w);
$result_seExpressway6w = sqlsrv_fetch_array($query_seExpressway6w, SQLSRV_FETCH_ASSOC);

$condExpresswaynight1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "'";
$condExpresswaynight2 = " AND c.DATEVLIN BETWEEN CONVERT(DATETIME,CONVERT(VARCHAR,DATEVLIN,103)+' 20:00',103) AND DATEADD(DAY,1,CONVERT(DATETIME,CONVERT(VARCHAR,DATEVLIN,103)+' 05:00',103))";
$condExpresswaynight3 = "";
$sql_seExpresswaynight = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seExpresswaynight = array(
    array('select_pdfvehicletransportdocumentdriver-stm', SQLSRV_PARAM_IN),
    array($condExpresswaynight1, SQLSRV_PARAM_IN),
    array($condExpresswaynight2, SQLSRV_PARAM_IN),
    array($condExpresswaynight2, SQLSRV_PARAM_IN)
);
$query_seExpresswaynight = sqlsrv_query($conn, $sql_seExpresswaynight, $params_seExpresswaynight);
$result_seExpresswaynight = sqlsrv_fetch_array($query_seExpresswaynight, SQLSRV_FETCH_ASSOC);


$condExpresswayday1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "'";
$condExpresswayday2 = " AND c.DATEVLIN BETWEEN CONVERT(DATETIME,CONVERT(VARCHAR,DATEVLIN,103)+' 05:01',103) AND CONVERT(DATETIME,CONVERT(VARCHAR,DATEVLIN,103)+' 19:59',103)";
$condExpresswayday3 = "";
$sql_seExpresswayday = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seExpresswayday = array(
    array('select_pdfvehicletransportdocumentdriver-stm', SQLSRV_PARAM_IN),
    array($condExpresswayday1, SQLSRV_PARAM_IN),
    array($condExpresswayday2, SQLSRV_PARAM_IN),
    array($condExpresswayday2, SQLSRV_PARAM_IN)
);
$query_seExpresswayday = sqlsrv_query($conn, $sql_seExpresswayday, $params_seExpresswayday);
$result_seExpresswayday = sqlsrv_fetch_array($query_seExpresswayday, SQLSRV_FETCH_ASSOC);


$sql_seCntday01 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday01 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('01', SQLSRV_PARAM_IN)
);
$query_seCntday01 = sqlsrv_query($conn, $sql_seCntday01, $params_seCntday01);
$result_seCntday01 = sqlsrv_fetch_array($query_seCntday01, SQLSRV_FETCH_ASSOC);

$sql_seCntday02 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday02 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('02', SQLSRV_PARAM_IN)
);
$query_seCntday02 = sqlsrv_query($conn, $sql_seCntday02, $params_seCntday02);
$result_seCntday02 = sqlsrv_fetch_array($query_seCntday02, SQLSRV_FETCH_ASSOC);

$sql_seCntday03 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday03 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('03', SQLSRV_PARAM_IN)
);
$query_seCntday03 = sqlsrv_query($conn, $sql_seCntday03, $params_seCntday03);
$result_seCntday03 = sqlsrv_fetch_array($query_seCntday03, SQLSRV_FETCH_ASSOC);

$sql_seCntday04 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday04 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('04', SQLSRV_PARAM_IN)
);
$query_seCntday04 = sqlsrv_query($conn, $sql_seCntday04, $params_seCntday04);
$result_seCntday04 = sqlsrv_fetch_array($query_seCntday04, SQLSRV_FETCH_ASSOC);

$sql_seCntday05 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday05 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('05', SQLSRV_PARAM_IN)
);
$query_seCntday05 = sqlsrv_query($conn, $sql_seCntday05, $params_seCntday05);
$result_seCntday05 = sqlsrv_fetch_array($query_seCntday05, SQLSRV_FETCH_ASSOC);

$sql_seCntday06 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday06 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('06', SQLSRV_PARAM_IN)
);
$query_seCntday06 = sqlsrv_query($conn, $sql_seCntday06, $params_seCntday06);
$result_seCntday06 = sqlsrv_fetch_array($query_seCntday06, SQLSRV_FETCH_ASSOC);

$sql_seCntday07 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday07 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('07', SQLSRV_PARAM_IN)
);
$query_seCntday07 = sqlsrv_query($conn, $sql_seCntday07, $params_seCntday07);
$result_seCntday07 = sqlsrv_fetch_array($query_seCntday07, SQLSRV_FETCH_ASSOC);

$sql_seCntday08 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday08 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('08', SQLSRV_PARAM_IN)
);
$query_seCntday08 = sqlsrv_query($conn, $sql_seCntday08, $params_seCntday08);
$result_seCntday08 = sqlsrv_fetch_array($query_seCntday08, SQLSRV_FETCH_ASSOC);

$sql_seCntday09 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday09 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('09', SQLSRV_PARAM_IN)
);
$query_seCntday09 = sqlsrv_query($conn, $sql_seCntday09, $params_seCntday09);
$result_seCntday09 = sqlsrv_fetch_array($query_seCntday09, SQLSRV_FETCH_ASSOC);

$sql_seCntday10 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday10 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('10', SQLSRV_PARAM_IN)
);
$query_seCntday10 = sqlsrv_query($conn, $sql_seCntday10, $params_seCntday10);
$result_seCntday10 = sqlsrv_fetch_array($query_seCntday10, SQLSRV_FETCH_ASSOC);

$sql_seCntday11 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday11 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('11', SQLSRV_PARAM_IN)
);
$query_seCntday11 = sqlsrv_query($conn, $sql_seCntday11, $params_seCntday11);
$result_seCntday11 = sqlsrv_fetch_array($query_seCntday11, SQLSRV_FETCH_ASSOC);

$sql_seCntday12 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday12 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('12', SQLSRV_PARAM_IN)
);
$query_seCntday12 = sqlsrv_query($conn, $sql_seCntday12, $params_seCntday12);
$result_seCntday12 = sqlsrv_fetch_array($query_seCntday12, SQLSRV_FETCH_ASSOC);

$sql_seCntday13 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday13 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('13', SQLSRV_PARAM_IN)
);
$query_seCntday13 = sqlsrv_query($conn, $sql_seCntday13, $params_seCntday13);
$result_seCntday13 = sqlsrv_fetch_array($query_seCntday13, SQLSRV_FETCH_ASSOC);

$sql_seCntday14 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday14 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('14', SQLSRV_PARAM_IN)
);
$query_seCntday14 = sqlsrv_query($conn, $sql_seCntday14, $params_seCntday14);
$result_seCntday14 = sqlsrv_fetch_array($query_seCntday14, SQLSRV_FETCH_ASSOC);

$sql_seCntday15 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday15 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('15', SQLSRV_PARAM_IN)
);
$query_seCntday15 = sqlsrv_query($conn, $sql_seCntday15, $params_seCntday15);
$result_seCntday15 = sqlsrv_fetch_array($query_seCntday15, SQLSRV_FETCH_ASSOC);

$sql_seCntday16 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday16 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('16', SQLSRV_PARAM_IN)
);
$query_seCntday16 = sqlsrv_query($conn, $sql_seCntday16, $params_seCntday16);
$result_seCntday16 = sqlsrv_fetch_array($query_seCntday16, SQLSRV_FETCH_ASSOC);

$sql_seCntday17 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday17 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('17', SQLSRV_PARAM_IN)
);
$query_seCntday17 = sqlsrv_query($conn, $sql_seCntday17, $params_seCntday17);
$result_seCntday17 = sqlsrv_fetch_array($query_seCntday17, SQLSRV_FETCH_ASSOC);

$sql_seCntday18 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday18 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('18', SQLSRV_PARAM_IN)
);
$query_seCntday18 = sqlsrv_query($conn, $sql_seCntday18, $params_seCntday18);
$result_seCntday18 = sqlsrv_fetch_array($query_seCntday18, SQLSRV_FETCH_ASSOC);

$sql_seCntday19 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday19 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('19', SQLSRV_PARAM_IN)
);
$query_seCntday19 = sqlsrv_query($conn, $sql_seCntday19, $params_seCntday19);
$result_seCntday19 = sqlsrv_fetch_array($query_seCntday19, SQLSRV_FETCH_ASSOC);

$sql_seCntday20 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday20 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('20', SQLSRV_PARAM_IN)
);
$query_seCntday20 = sqlsrv_query($conn, $sql_seCntday20, $params_seCntday20);
$result_seCntday20 = sqlsrv_fetch_array($query_seCntday20, SQLSRV_FETCH_ASSOC);

$sql_seCntday21 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday21 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('21', SQLSRV_PARAM_IN)
);
$query_seCntday21 = sqlsrv_query($conn, $sql_seCntday21, $params_seCntday21);
$result_seCntday21 = sqlsrv_fetch_array($query_seCntday21, SQLSRV_FETCH_ASSOC);

$sql_seCntday22 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday22 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('22', SQLSRV_PARAM_IN)
);
$query_seCntday22 = sqlsrv_query($conn, $sql_seCntday22, $params_seCntday22);
$result_seCntday22 = sqlsrv_fetch_array($query_seCntday22, SQLSRV_FETCH_ASSOC);

$sql_seCntday23 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday23 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('23', SQLSRV_PARAM_IN)
);
$query_seCntday23 = sqlsrv_query($conn, $sql_seCntday23, $params_seCntday23);
$result_seCntday23 = sqlsrv_fetch_array($query_seCntday23, SQLSRV_FETCH_ASSOC);

$sql_seCntday24 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday24 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('24', SQLSRV_PARAM_IN)
);
$query_seCntday24 = sqlsrv_query($conn, $sql_seCntday24, $params_seCntday24);
$result_seCntday24 = sqlsrv_fetch_array($query_seCntday24, SQLSRV_FETCH_ASSOC);

$sql_seCntday25 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday25 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('25', SQLSRV_PARAM_IN)
);
$query_seCntday25 = sqlsrv_query($conn, $sql_seCntday25, $params_seCntday25);
$result_seCntday25 = sqlsrv_fetch_array($query_seCntday25, SQLSRV_FETCH_ASSOC);

$sql_seCntday26 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday26 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('26', SQLSRV_PARAM_IN)
);
$query_seCntday26 = sqlsrv_query($conn, $sql_seCntday26, $params_seCntday26);
$result_seCntday26 = sqlsrv_fetch_array($query_seCntday26, SQLSRV_FETCH_ASSOC);

$sql_seCntday27 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday27 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('27', SQLSRV_PARAM_IN)
);
$query_seCntday27 = sqlsrv_query($conn, $sql_seCntday27, $params_seCntday27);
$result_seCntday27 = sqlsrv_fetch_array($query_seCntday27, SQLSRV_FETCH_ASSOC);

$sql_seCntday28 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday28 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('028', SQLSRV_PARAM_IN)
);
$query_seCntday28 = sqlsrv_query($conn, $sql_seCntday28, $params_seCntday28);
$result_seCntday28 = sqlsrv_fetch_array($query_seCntday28, SQLSRV_FETCH_ASSOC);

$sql_seCntday29 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday29 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('29', SQLSRV_PARAM_IN)
);
$query_seCntday29 = sqlsrv_query($conn, $sql_seCntday29, $params_seCntday29);
$result_seCntday29 = sqlsrv_fetch_array($query_seCntday29, SQLSRV_FETCH_ASSOC);

$sql_seCntday30 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday30 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('30', SQLSRV_PARAM_IN)
);
$query_seCntday30 = sqlsrv_query($conn, $sql_seCntday30, $params_seCntday30);
$result_seCntday30 = sqlsrv_fetch_array($query_seCntday30, SQLSRV_FETCH_ASSOC);

$sql_seCntday31 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday31 = array(
    array('select_vldateday10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('31', SQLSRV_PARAM_IN)
);
$query_seCntday31 = sqlsrv_query($conn, $sql_seCntday31, $params_seCntday31);
$result_seCntday31 = sqlsrv_fetch_array($query_seCntday31, SQLSRV_FETCH_ASSOC);


$sql_seCntnight01 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight01 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('01', SQLSRV_PARAM_IN)
);
$query_seCntnight01 = sqlsrv_query($conn, $sql_seCntnight01, $params_seCntnight01);
$result_seCntnight01 = sqlsrv_fetch_array($query_seCntnight01, SQLSRV_FETCH_ASSOC);

$sql_seCntnight02 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight02 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('02', SQLSRV_PARAM_IN)
);
$query_seCntnight02 = sqlsrv_query($conn, $sql_seCntnight02, $params_seCntnight02);
$result_seCntnight02 = sqlsrv_fetch_array($query_seCntnight02, SQLSRV_FETCH_ASSOC);

$sql_seCntnight03 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight03 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('03', SQLSRV_PARAM_IN)
);
$query_seCntnight03 = sqlsrv_query($conn, $sql_seCntnight03, $params_seCntnight03);
$result_seCntnight03 = sqlsrv_fetch_array($query_seCntnight03, SQLSRV_FETCH_ASSOC);

$sql_seCntnight04 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight04 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('04', SQLSRV_PARAM_IN)
);
$query_seCntnight04 = sqlsrv_query($conn, $sql_seCntnight04, $params_seCntnight04);
$result_seCntnight04 = sqlsrv_fetch_array($query_seCntnight04, SQLSRV_FETCH_ASSOC);

$sql_seCntnight05 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight05 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('05', SQLSRV_PARAM_IN)
);
$query_seCntnight05 = sqlsrv_query($conn, $sql_seCntnight05, $params_seCntnight05);
$result_seCntnight05 = sqlsrv_fetch_array($query_seCntnight05, SQLSRV_FETCH_ASSOC);

$sql_seCntnight06 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight06 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('06', SQLSRV_PARAM_IN)
);
$query_seCntnight06 = sqlsrv_query($conn, $sql_seCntnight06, $params_seCntnight06);
$result_seCntnight06 = sqlsrv_fetch_array($query_seCntnight06, SQLSRV_FETCH_ASSOC);

$sql_seCntnight07 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight07 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('07', SQLSRV_PARAM_IN)
);
$query_seCntnight07 = sqlsrv_query($conn, $sql_seCntnight07, $params_seCntnight07);
$result_seCntnight07 = sqlsrv_fetch_array($query_seCntnight07, SQLSRV_FETCH_ASSOC);

$sql_seCntnight08 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight08 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('08', SQLSRV_PARAM_IN)
);
$query_seCntnight08 = sqlsrv_query($conn, $sql_seCntnight08, $params_seCntnight08);
$result_seCntnight08 = sqlsrv_fetch_array($query_seCntnight08, SQLSRV_FETCH_ASSOC);

$sql_seCntnight09 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight09 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('09', SQLSRV_PARAM_IN)
);
$query_seCntnight09 = sqlsrv_query($conn, $sql_seCntnight09, $params_seCntnight09);
$result_seCntnight09 = sqlsrv_fetch_array($query_seCntnight09, SQLSRV_FETCH_ASSOC);

$sql_seCntnight10 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight10 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('10', SQLSRV_PARAM_IN)
);
$query_seCntnight10 = sqlsrv_query($conn, $sql_seCntnight10, $params_seCntnight10);
$result_seCntnight10 = sqlsrv_fetch_array($query_seCntnight10, SQLSRV_FETCH_ASSOC);

$sql_seCntnight11 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight11 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('11', SQLSRV_PARAM_IN)
);
$query_seCntnight11 = sqlsrv_query($conn, $sql_seCntnight11, $params_seCntnight11);
$result_seCntnight11 = sqlsrv_fetch_array($query_seCntnight11, SQLSRV_FETCH_ASSOC);

$sql_seCntnight12 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight12 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('12', SQLSRV_PARAM_IN)
);
$query_seCntnight12 = sqlsrv_query($conn, $sql_seCntnight12, $params_seCntnight12);
$result_seCntnight12 = sqlsrv_fetch_array($query_seCntnight12, SQLSRV_FETCH_ASSOC);

$sql_seCntnight13 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight13 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('13', SQLSRV_PARAM_IN)
);
$query_seCntnight13 = sqlsrv_query($conn, $sql_seCntnight13, $params_seCntnight13);
$result_seCntnight13 = sqlsrv_fetch_array($query_seCntnight13, SQLSRV_FETCH_ASSOC);

$sql_seCntnight14 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight14 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('14', SQLSRV_PARAM_IN)
);
$query_seCntnight14 = sqlsrv_query($conn, $sql_seCntnight14, $params_seCntnight14);
$result_seCntnight14 = sqlsrv_fetch_array($query_seCntnight14, SQLSRV_FETCH_ASSOC);

$sql_seCntnight15 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight15 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('15', SQLSRV_PARAM_IN)
);
$query_seCntnight15 = sqlsrv_query($conn, $sql_seCntnight15, $params_seCntnight15);
$result_seCntnight15 = sqlsrv_fetch_array($query_seCntnight15, SQLSRV_FETCH_ASSOC);

$sql_seCntnight16 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight16 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('16', SQLSRV_PARAM_IN)
);
$query_seCntnight16 = sqlsrv_query($conn, $sql_seCntnight16, $params_seCntnight16);
$result_seCntnight16 = sqlsrv_fetch_array($query_seCntnight16, SQLSRV_FETCH_ASSOC);

$sql_seCntnight17 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight17 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('17', SQLSRV_PARAM_IN)
);
$query_seCntnight17 = sqlsrv_query($conn, $sql_seCntnight17, $params_seCntnight17);
$result_seCntnight17 = sqlsrv_fetch_array($query_seCntnight17, SQLSRV_FETCH_ASSOC);

$sql_seCntnight18 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight18 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('18', SQLSRV_PARAM_IN)
);
$query_seCntnight18 = sqlsrv_query($conn, $sql_seCntnight18, $params_seCntnight18);
$result_seCntnight18 = sqlsrv_fetch_array($query_seCntnight18, SQLSRV_FETCH_ASSOC);

$sql_seCntnight19 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight19 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('19', SQLSRV_PARAM_IN)
);
$query_seCntnight19 = sqlsrv_query($conn, $sql_seCntnight19, $params_seCntnight19);
$result_seCntnight19 = sqlsrv_fetch_array($query_seCntnight19, SQLSRV_FETCH_ASSOC);

$sql_seCntnight20 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight20 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('20', SQLSRV_PARAM_IN)
);
$query_seCntnight20 = sqlsrv_query($conn, $sql_seCntnight20, $params_seCntnight20);
$result_seCntnight20 = sqlsrv_fetch_array($query_seCntnight20, SQLSRV_FETCH_ASSOC);

$sql_seCntnight21 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight21 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('21', SQLSRV_PARAM_IN)
);
$query_seCntnight21 = sqlsrv_query($conn, $sql_seCntnight21, $params_seCntnight21);
$result_seCntnight21 = sqlsrv_fetch_array($query_seCntnight21, SQLSRV_FETCH_ASSOC);

$sql_seCntnight22 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight22 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('22', SQLSRV_PARAM_IN)
);
$query_seCntnight22 = sqlsrv_query($conn, $sql_seCntnight22, $params_seCntnight22);
$result_seCntnight22 = sqlsrv_fetch_array($query_seCntnight22, SQLSRV_FETCH_ASSOC);

$sql_seCntnight23 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight23 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('23', SQLSRV_PARAM_IN)
);
$query_seCntnight23 = sqlsrv_query($conn, $sql_seCntnight23, $params_seCntnight23);
$result_seCntnight23 = sqlsrv_fetch_array($query_seCntnight23, SQLSRV_FETCH_ASSOC);

$sql_seCntnight24 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight24 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('24', SQLSRV_PARAM_IN)
);
$query_seCntnight24 = sqlsrv_query($conn, $sql_seCntnight24, $params_seCntnight24);
$result_seCntnight24 = sqlsrv_fetch_array($query_seCntnight24, SQLSRV_FETCH_ASSOC);

$sql_seCntnight25 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight25 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('25', SQLSRV_PARAM_IN)
);
$query_seCntnight25 = sqlsrv_query($conn, $sql_seCntnight25, $params_seCntnight25);
$result_seCntnight25 = sqlsrv_fetch_array($query_seCntnight25, SQLSRV_FETCH_ASSOC);

$sql_seCntnight26 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight26 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('26', SQLSRV_PARAM_IN)
);
$query_seCntnight26 = sqlsrv_query($conn, $sql_seCntnight26, $params_seCntnight26);
$result_seCntnight26 = sqlsrv_fetch_array($query_seCntnight26, SQLSRV_FETCH_ASSOC);

$sql_seCntnight27 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight27 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('27', SQLSRV_PARAM_IN)
);
$query_seCntnight27 = sqlsrv_query($conn, $sql_seCntnight27, $params_seCntnight27);
$result_seCntnight27 = sqlsrv_fetch_array($query_seCntnight27, SQLSRV_FETCH_ASSOC);

$sql_seCntnight28 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight28 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('028', SQLSRV_PARAM_IN)
);
$query_seCntnight28 = sqlsrv_query($conn, $sql_seCntnight28, $params_seCntnight28);
$result_seCntnight28 = sqlsrv_fetch_array($query_seCntnight28, SQLSRV_FETCH_ASSOC);

$sql_seCntnight29 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight29 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('29', SQLSRV_PARAM_IN)
);
$query_seCntnight29 = sqlsrv_query($conn, $sql_seCntnight29, $params_seCntnight29);
$result_seCntnight29 = sqlsrv_fetch_array($query_seCntnight29, SQLSRV_FETCH_ASSOC);

$sql_seCntnight30 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight30 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('30', SQLSRV_PARAM_IN)
);
$query_seCntnight30 = sqlsrv_query($conn, $sql_seCntnight30, $params_seCntnight30);
$result_seCntnight30 = sqlsrv_fetch_array($query_seCntnight30, SQLSRV_FETCH_ASSOC);

$sql_seCntnight31 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight31 = array(
    array('select_vldatenight10W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('31', SQLSRV_PARAM_IN)
);
$query_seCntnight31 = sqlsrv_query($conn, $sql_seCntnight31, $params_seCntnight31);
$result_seCntnight31 = sqlsrv_fetch_array($query_seCntnight31, SQLSRV_FETCH_ASSOC);


$sql_seCntday01_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday01_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('01', SQLSRV_PARAM_IN)
);
$query_seCntday01_6W = sqlsrv_query($conn, $sql_seCntday01_6W, $params_seCntday01_6W);
$result_seCntday01_6W = sqlsrv_fetch_array($query_seCntday01_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday02_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday02_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('02', SQLSRV_PARAM_IN)
);
$query_seCntday02_6W = sqlsrv_query($conn, $sql_seCntday02_6W, $params_seCntday02_6W);
$result_seCntday02_6W = sqlsrv_fetch_array($query_seCntday02_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday03_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday03_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('03', SQLSRV_PARAM_IN)
);
$query_seCntday03_6W = sqlsrv_query($conn, $sql_seCntday03_6W, $params_seCntday03_6W);
$result_seCntday03_6W = sqlsrv_fetch_array($query_seCntday03_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday04_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday04_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('04', SQLSRV_PARAM_IN)
);
$query_seCntday04_6W = sqlsrv_query($conn, $sql_seCntday04_6W, $params_seCntday04_6W);
$result_seCntday04_6W = sqlsrv_fetch_array($query_seCntday04_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday05_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday05_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('05', SQLSRV_PARAM_IN)
);
$query_seCntday05_6W = sqlsrv_query($conn, $sql_seCntday05_6W, $params_seCntday05_6W);
$result_seCntday05_6W = sqlsrv_fetch_array($query_seCntday05_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday06_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday06_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('06', SQLSRV_PARAM_IN)
);
$query_seCntday06_6W = sqlsrv_query($conn, $sql_seCntday06_6W, $params_seCntday06_6W);
$result_seCntday06_6W = sqlsrv_fetch_array($query_seCntday06_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday07_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday07_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('07', SQLSRV_PARAM_IN)
);
$query_seCntday07_6W = sqlsrv_query($conn, $sql_seCntday07_6W, $params_seCntday07_6W);
$result_seCntday07_6W = sqlsrv_fetch_array($query_seCntday07_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday08_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday08_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('08', SQLSRV_PARAM_IN)
);
$query_seCntday08_6W = sqlsrv_query($conn, $sql_seCntday08_6W, $params_seCntday08_6W);
$result_seCntday08_6W = sqlsrv_fetch_array($query_seCntday08_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday09_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday09_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('09', SQLSRV_PARAM_IN)
);
$query_seCntday09_6W = sqlsrv_query($conn, $sql_seCntday09_6W, $params_seCntday09_6W);
$result_seCntday09_6W = sqlsrv_fetch_array($query_seCntday09_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday10_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday10_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('10', SQLSRV_PARAM_IN)
);
$query_seCntday10_6W = sqlsrv_query($conn, $sql_seCntday10_6W, $params_seCntday10_6W);
$result_seCntday10_6W = sqlsrv_fetch_array($query_seCntday10_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday11_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday11_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('11', SQLSRV_PARAM_IN)
);
$query_seCntday11_6W = sqlsrv_query($conn, $sql_seCntday11_6W, $params_seCntday11_6W);
$result_seCntday11_6W = sqlsrv_fetch_array($query_seCntday11_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday12_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday12_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('12', SQLSRV_PARAM_IN)
);
$query_seCntday12_6W = sqlsrv_query($conn, $sql_seCntday12_6W, $params_seCntday12_6W);
$result_seCntday12_6W = sqlsrv_fetch_array($query_seCntday12_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday13_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday13_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('13', SQLSRV_PARAM_IN)
);
$query_seCntday13_6W = sqlsrv_query($conn, $sql_seCntday13_6W, $params_seCntday13_6W);
$result_seCntday13_6W = sqlsrv_fetch_array($query_seCntday13_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday14_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday14_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('14', SQLSRV_PARAM_IN)
);
$query_seCntday14_6W = sqlsrv_query($conn, $sql_seCntday14_6W, $params_seCntday14_6W);
$result_seCntday14_6W = sqlsrv_fetch_array($query_seCntday14_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday15_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday15_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('15', SQLSRV_PARAM_IN)
);
$query_seCntday15_6W = sqlsrv_query($conn, $sql_seCntday15_6W, $params_seCntday15_6W);
$result_seCntday15_6W = sqlsrv_fetch_array($query_seCntday15_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday16_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday16_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('16', SQLSRV_PARAM_IN)
);
$query_seCntday16_6W = sqlsrv_query($conn, $sql_seCntday16_6W, $params_seCntday16_6W);
$result_seCntday16_6W = sqlsrv_fetch_array($query_seCntday16_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday17_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday17_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('17', SQLSRV_PARAM_IN)
);
$query_seCntday17_6W = sqlsrv_query($conn, $sql_seCntday17_6W, $params_seCntday17_6W);
$result_seCntday17_6W = sqlsrv_fetch_array($query_seCntday17_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday18_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday18_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('18', SQLSRV_PARAM_IN)
);
$query_seCntday18_6W = sqlsrv_query($conn, $sql_seCntday18_6W, $params_seCntday18_6W);
$result_seCntday18_6W = sqlsrv_fetch_array($query_seCntday18_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday19_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday19_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('19', SQLSRV_PARAM_IN)
);
$query_seCntday19_6W = sqlsrv_query($conn, $sql_seCntday19_6W, $params_seCntday19_6W);
$result_seCntday19_6W = sqlsrv_fetch_array($query_seCntday19_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday20_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday20_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('20', SQLSRV_PARAM_IN)
);
$query_seCntday20_6W = sqlsrv_query($conn, $sql_seCntday20_6W, $params_seCntday20_6W);
$result_seCntday20_6W = sqlsrv_fetch_array($query_seCntday20_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday21_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday21_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('21', SQLSRV_PARAM_IN)
);
$query_seCntday21_6W = sqlsrv_query($conn, $sql_seCntday21_6W, $params_seCntday21_6W);
$result_seCntday21_6W = sqlsrv_fetch_array($query_seCntday21_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday22_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday22_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('22', SQLSRV_PARAM_IN)
);
$query_seCntday22_6W = sqlsrv_query($conn, $sql_seCntday22_6W, $params_seCntday22_6W);
$result_seCntday22_6W = sqlsrv_fetch_array($query_seCntday22_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday23_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday23_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('23', SQLSRV_PARAM_IN)
);
$query_seCntday23_6W = sqlsrv_query($conn, $sql_seCntday23_6W, $params_seCntday23_6W);
$result_seCntday23_6W = sqlsrv_fetch_array($query_seCntday23_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday24_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday24_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('24', SQLSRV_PARAM_IN)
);
$query_seCntday24_6W = sqlsrv_query($conn, $sql_seCntday24_6W, $params_seCntday24_6W);
$result_seCntday24_6W = sqlsrv_fetch_array($query_seCntday24_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday25_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday25_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('25', SQLSRV_PARAM_IN)
);
$query_seCntday25_6W = sqlsrv_query($conn, $sql_seCntday25_6W, $params_seCntday25_6W);
$result_seCntday25_6W = sqlsrv_fetch_array($query_seCntday25_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday26_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday26_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('26', SQLSRV_PARAM_IN)
);
$query_seCntday26_6W = sqlsrv_query($conn, $sql_seCntday26_6W, $params_seCntday26_6W);
$result_seCntday26_6W = sqlsrv_fetch_array($query_seCntday26_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday27_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday27_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('27', SQLSRV_PARAM_IN)
);
$query_seCntday27_6W = sqlsrv_query($conn, $sql_seCntday27_6W, $params_seCntday27_6W);
$result_seCntday27_6W = sqlsrv_fetch_array($query_seCntday27_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday28_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday28_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('28', SQLSRV_PARAM_IN)
);
$query_seCntday28_6W = sqlsrv_query($conn, $sql_seCntday28_6W, $params_seCntday28_6W);
$result_seCntday28_6W = sqlsrv_fetch_array($query_seCntday28_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday29_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday29_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('29', SQLSRV_PARAM_IN)
);
$query_seCntday29_6W = sqlsrv_query($conn, $sql_seCntday29_6W, $params_seCntday29_6W);
$result_seCntday29_6W = sqlsrv_fetch_array($query_seCntday29_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday30_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday30_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('30', SQLSRV_PARAM_IN)
);
$query_seCntday30_6W = sqlsrv_query($conn, $sql_seCntday30_6W, $params_seCntday30_6W);
$result_seCntday30_6W = sqlsrv_fetch_array($query_seCntday30_6W, SQLSRV_FETCH_ASSOC);

$sql_seCntday31_6W = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntday31_6W = array(
    array('select_vldateday6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('31', SQLSRV_PARAM_IN)
);
$query_seCntday31_6W = sqlsrv_query($conn, $sql_seCntday31_6W, $params_seCntday31_6W);
$result_seCntday31_6W = sqlsrv_fetch_array($query_seCntday31_6W, SQLSRV_FETCH_ASSOC);


$sql_seCntnight01_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight01_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('01', SQLSRV_PARAM_IN)
);
$query_seCntnight01_6w = sqlsrv_query($conn, $sql_seCntnight01_6w, $params_seCntnight01_6w);
$result_seCntnight01_6w = sqlsrv_fetch_array($query_seCntnight01_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight02_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight02_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('02', SQLSRV_PARAM_IN)
);
$query_seCntnight02_6w = sqlsrv_query($conn, $sql_seCntnight02_6w, $params_seCntnight02_6w);
$result_seCntnight02_6w = sqlsrv_fetch_array($query_seCntnight02_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight03_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight03_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('03', SQLSRV_PARAM_IN)
);
$query_seCntnight03_6w = sqlsrv_query($conn, $sql_seCntnight03_6w, $params_seCntnight03_6w);
$result_seCntnight03_6w = sqlsrv_fetch_array($query_seCntnight03_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight04_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight04_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('04', SQLSRV_PARAM_IN)
);
$query_seCntnight04_6w = sqlsrv_query($conn, $sql_seCntnight04_6w, $params_seCntnight04_6w);
$result_seCntnight04_6w = sqlsrv_fetch_array($query_seCntnight04_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight05_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight05_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('05', SQLSRV_PARAM_IN)
);
$query_seCntnight05_6w = sqlsrv_query($conn, $sql_seCntnight05_6w, $params_seCntnight05_6w);
$result_seCntnight05_6w = sqlsrv_fetch_array($query_seCntnight05_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight06_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight06_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('06', SQLSRV_PARAM_IN)
);
$query_seCntnight06_6w = sqlsrv_query($conn, $sql_seCntnight06_6w, $params_seCntnight06_6w);
$result_seCntnight06_6w = sqlsrv_fetch_array($query_seCntnight06_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight07_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight07_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('07', SQLSRV_PARAM_IN)
);
$query_seCntnight07_6w = sqlsrv_query($conn, $sql_seCntnight07_6w, $params_seCntnight07_6w);
$result_seCntnight07_6w = sqlsrv_fetch_array($query_seCntnight07_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight08_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight08_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('08', SQLSRV_PARAM_IN)
);
$query_seCntnight08_6w = sqlsrv_query($conn, $sql_seCntnight08_6w, $params_seCntnight08_6w);
$result_seCntnight08_6w = sqlsrv_fetch_array($query_seCntnight08_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight09_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight09_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('09', SQLSRV_PARAM_IN)
);
$query_seCntnight09_6w = sqlsrv_query($conn, $sql_seCntnight09_6w, $params_seCntnight09_6w);
$result_seCntnight09_6w = sqlsrv_fetch_array($query_seCntnight09_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight10_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight10_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('10', SQLSRV_PARAM_IN)
);
$query_seCntnight10_6w = sqlsrv_query($conn, $sql_seCntnight10_6w, $params_seCntnight10_6w);
$result_seCntnight10_6w = sqlsrv_fetch_array($query_seCntnight10_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight11_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight11_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('11', SQLSRV_PARAM_IN)
);
$query_seCntnight11_6w = sqlsrv_query($conn, $sql_seCntnight11_6w, $params_seCntnight11_6w);
$result_seCntnight11_6w = sqlsrv_fetch_array($query_seCntnight11_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight12_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight12_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('12', SQLSRV_PARAM_IN)
);
$query_seCntnight12_6w = sqlsrv_query($conn, $sql_seCntnight12_6w, $params_seCntnight12_6w);
$result_seCntnight12_6w = sqlsrv_fetch_array($query_seCntnight12_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight13_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight13_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('13', SQLSRV_PARAM_IN)
);
$query_seCntnight13_6w = sqlsrv_query($conn, $sql_seCntnight13_6w, $params_seCntnight13_6w);
$result_seCntnight13_6w = sqlsrv_fetch_array($query_seCntnight13_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight14_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight14_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('14', SQLSRV_PARAM_IN)
);
$query_seCntnight14_6w = sqlsrv_query($conn, $sql_seCntnight14_6w, $params_seCntnight14_6w);
$result_seCntnight14_6w = sqlsrv_fetch_array($query_seCntnight14_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight15_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight15_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('15', SQLSRV_PARAM_IN)
);
$query_seCntnight15_6w = sqlsrv_query($conn, $sql_seCntnight15_6w, $params_seCntnight15_6w);
$result_seCntnight15_6w = sqlsrv_fetch_array($query_seCntnight15_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight16_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight16_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('16', SQLSRV_PARAM_IN)
);
$query_seCntnight16_6w = sqlsrv_query($conn, $sql_seCntnight16_6w, $params_seCntnight16_6w);
$result_seCntnight16_6w = sqlsrv_fetch_array($query_seCntnight16_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight17_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight17_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('17', SQLSRV_PARAM_IN)
);
$query_seCntnight17_6w = sqlsrv_query($conn, $sql_seCntnight17_6w, $params_seCntnight17_6w);
$result_seCntnight17_6w = sqlsrv_fetch_array($query_seCntnight17_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight18_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight18_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('18', SQLSRV_PARAM_IN)
);
$query_seCntnight18_6w = sqlsrv_query($conn, $sql_seCntnight18_6w, $params_seCntnight18_6w);
$result_seCntnight18_6w = sqlsrv_fetch_array($query_seCntnight18_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight19_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight19_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('19', SQLSRV_PARAM_IN)
);
$query_seCntnight19_6w = sqlsrv_query($conn, $sql_seCntnight19_6w, $params_seCntnight19_6w);
$result_seCntnight19_6w = sqlsrv_fetch_array($query_seCntnight19_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight20_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight20_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('20', SQLSRV_PARAM_IN)
);
$query_seCntnight20_6w = sqlsrv_query($conn, $sql_seCntnight20_6w, $params_seCntnight20_6w);
$result_seCntnight20_6w = sqlsrv_fetch_array($query_seCntnight20_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight21_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight21_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('21', SQLSRV_PARAM_IN)
);
$query_seCntnight21_6w = sqlsrv_query($conn, $sql_seCntnight21_6w, $params_seCntnight21_6w);
$result_seCntnight21_6w = sqlsrv_fetch_array($query_seCntnight21_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight22_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight22_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('22', SQLSRV_PARAM_IN)
);
$query_seCntnight22_6w = sqlsrv_query($conn, $sql_seCntnight22_6w, $params_seCntnight22_6w);
$result_seCntnight22_6w = sqlsrv_fetch_array($query_seCntnight22_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight23_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight23_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('23', SQLSRV_PARAM_IN)
);
$query_seCntnight23_6w = sqlsrv_query($conn, $sql_seCntnight23_6w, $params_seCntnight23_6w);
$result_seCntnight23_6w = sqlsrv_fetch_array($query_seCntnight23_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight24_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight24_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('24', SQLSRV_PARAM_IN)
);
$query_seCntnight24_6w = sqlsrv_query($conn, $sql_seCntnight24_6w, $params_seCntnight24_6w);
$result_seCntnight24_6w = sqlsrv_fetch_array($query_seCntnight24_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight25_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight25_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('25', SQLSRV_PARAM_IN)
);
$query_seCntnight25_6w = sqlsrv_query($conn, $sql_seCntnight25_6w, $params_seCntnight25_6w);
$result_seCntnight25_6w = sqlsrv_fetch_array($query_seCntnight25_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight26_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight26_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('26', SQLSRV_PARAM_IN)
);
$query_seCntnight26_6w = sqlsrv_query($conn, $sql_seCntnight26_6w, $params_seCntnight26_6w);
$result_seCntnight26_6w = sqlsrv_fetch_array($query_seCntnight26_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight27_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight27_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('27', SQLSRV_PARAM_IN)
);
$query_seCntnight27_6w = sqlsrv_query($conn, $sql_seCntnight27_6w, $params_seCntnight27_6w);
$result_seCntnight27_6w = sqlsrv_fetch_array($query_seCntnight27_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight28_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight28_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('028', SQLSRV_PARAM_IN)
);
$query_seCntnight28_6w = sqlsrv_query($conn, $sql_seCntnight28_6w, $params_seCntnight28_6w);
$result_seCntnight28_6w = sqlsrv_fetch_array($query_seCntnight28_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight29_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight29_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('29', SQLSRV_PARAM_IN)
);
$query_seCntnight29_6w = sqlsrv_query($conn, $sql_seCntnight29_6w, $params_seCntnight29_6w);
$result_seCntnight29_6w = sqlsrv_fetch_array($query_seCntnight29_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight30_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight30_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('30', SQLSRV_PARAM_IN)
);
$query_seCntnight30_6w = sqlsrv_query($conn, $sql_seCntnight30_6w, $params_seCntnight30_6w);
$result_seCntnight30_6w = sqlsrv_fetch_array($query_seCntnight30_6w, SQLSRV_FETCH_ASSOC);

$sql_seCntnight31_6w = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seCntnight31_6w = array(
    array('select_vldatenight6W', SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN),
    array('31', SQLSRV_PARAM_IN)
);
$query_seCntnight31_6w = sqlsrv_query($conn, $sql_seCntnight31_6w, $params_seCntnight31_6w);
$result_seCntnight31_6w = sqlsrv_fetch_array($query_seCntnight31_6w, SQLSRV_FETCH_ASSOC);

$cntday10w = (int) $result_seCntday01['VLINDATEDAY'] + (int) $result_seCntday02['VLINDATEDAY'] + (int) $result_seCntday03['VLINDATEDAY'] + (int) $result_seCntday04['VLINDATEDAY'] + (int) $result_seCntday05['VLINDATEDAY'] + (int) $result_seCntday06['VLINDATEDAY'] + (int) $result_seCntday07['VLINDATEDAY'] + (int) $result_seCntday08['VLINDATEDAY'] + (int) $result_seCntday09['VLINDATEDAY'] + (int) $result_seCntday10['VLINDATEDAY'] + (int) $result_seCntday11['VLINDATEDAY'] + (int) $result_seCntday12['VLINDATEDAY'] + (int) $result_seCntday13['VLINDATEDAY'] + (int) $result_seCntday14['VLINDATEDAY'] + (int) $result_seCntday15['VLINDATEDAY'] + (int) $result_seCntday16['VLINDATEDAY'] + (int) $result_seCntday17['VLINDATEDAY'] + (int) $result_seCntday18['VLINDATEDAY'] + (int) $result_seCntday19['VLINDATEDAY'] + (int) $result_seCntday20['VLINDATEDAY'] + (int) $result_seCntday21['VLINDATEDAY'] + (int) $result_seCntday22['VLINDATEDAY'] + (int) $result_seCntday23['VLINDATEDAY'] + (int) $result_seCntday24['VLINDATEDAY'] + (int) $result_seCntday25['VLINDATEDAY'] + (int) $result_seCntday26['VLINDATEDAY'] + (int) $result_seCntday27['VLINDATEDAY'] + (int) $result_seCntday28['VLINDATEDAY'] + (int) $result_seCntday29['VLINDATEDAY'] + (int) $result_seCntday30['VLINDATEDAY'] + (int) $result_seCntday31['VLINDATEDAY'];
$Cntnight10w = (int) $result_seCntnight01['VLINDATENIGHT'] + (int) $result_seCntnight02['VLINDATENIGHT'] + (int) $result_seCntnight03['VLINDATENIGHT'] + (int) $result_seCntnight04['VLINDATENIGHT'] + (int) $result_seCntnight05['VLINDATENIGHT'] + (int) $result_seCntnight06['VLINDATENIGHT'] + (int) $result_seCntnight07['VLINDATENIGHT'] + (int) $result_seCntnight08['VLINDATENIGHT'] + (int) $result_seCntnight09['VLINDATENIGHT'] + (int) $result_seCntnight10['VLINDATENIGHT'] + (int) $result_seCntnight11['VLINDATENIGHT'] + (int) $result_seCntnight12['VLINDATENIGHT'] + (int) $result_seCntnight13['VLINDATENIGHT'] + (int) $result_seCntnight14['VLINDATENIGHT'] + (int) $result_seCntnight15['VLINDATENIGHT'] + (int) $result_seCntnight16['VLINDATENIGHT'] + (int) $result_seCntnight17['VLINDATENIGHT'] + (int) $result_seCntnight18['VLINDATENIGHT'] + (int) $result_seCntnight19['VLINDATENIGHT'] + (int) $result_seCntnight20['VLINDATENIGHT'] + (int) $result_seCntnight21['VLINDATENIGHT'] + (int) $result_seCntnight22['VLINDATENIGHT'] + (int) $result_seCntnight23['VLINDATENIGHT'] + (int) $result_seCntnight24['VLINDATENIGHT'] + (int) $result_seCntnight25['VLINDATENIGHT'] + (int) $result_seCntnight26['VLINDATENIGHT'] + (int) $result_seCntnight27['VLINDATENIGHT'] + (int) $result_seCntnight28['VLINDATENIGHT'] + (int) $result_seCntnight29['VLINDATENIGHT'] + (int) $result_seCntnight30['VLINDATENIGHT'] + (int) $result_seCntnight31['VLINDATENIGHT'];
$Cntnight6w = (int) $result_seCntnight01_6w['VLINDATENIGHT'] + (int) $result_seCntnight02_6w['VLINDATENIGHT'] + (int) $result_seCntnight03_6w['VLINDATENIGHT'] + (int) $result_seCntnight04_6w['VLINDATENIGHT'] + (int) $result_seCntnight05_6w['VLINDATENIGHT'] + (int) $result_seCntnight06_6w['VLINDATENIGHT'] + (int) $result_seCntnight07_6w['VLINDATENIGHT'] + (int) $result_seCntnight08_6w['VLINDATENIGHT'] + (int) $result_seCntnight09_6w['VLINDATENIGHT'] + (int) $result_seCntnight10_6w['VLINDATENIGHT'] + (int) $result_seCntnight11_6w['VLINDATENIGHT'] + (int) $result_seCntnight12_6w['VLINDATENIGHT'] + (int) $result_seCntnight13_6w['VLINDATENIGHT'] + (int) $result_seCntnight14_6w['VLINDATENIGHT'] + (int) $result_seCntnight15_6w['VLINDATENIGHT'] + (int) $result_seCntnight16_6w['VLINDATENIGHT'] + (int) $result_seCntnight17_6w['VLINDATENIGHT'] + (int) $result_seCntnight18_6w['VLINDATENIGHT'] + (int) $result_seCntnight19_6w['VLINDATENIGHT'] + (int) $result_seCntnight20_6w['VLINDATENIGHT'] + (int) $result_seCntnight21_6w['VLINDATENIGHT'] + (int) $result_seCntnight22_6w['VLINDATENIGHT'] + (int) $result_seCntnight23_6w['VLINDATENIGHT'] + (int) $result_seCntnight24_6w['VLINDATENIGHT'] + (int) $result_seCntnight25_6w['VLINDATENIGHT'] + (int) $result_seCntnight26_6w['VLINDATENIGHT'] + (int) $result_seCntnight27_6w['VLINDATENIGHT'] + (int) $result_seCntnight28_6w['VLINDATENIGHT'] + (int) $result_seCntnight29_6w['VLINDATENIGHT'] + (int) $result_seCntnight30_6w['VLINDATENIGHT'] + (int) $result_seCntnight31_6w['VLINDATENIGHT'];
$Cntday6w = (int) $result_seCntday01_6w['VLINDATENIGHT'] + (int) $result_seCntday02_6w['VLINDATENIGHT'] + (int) $result_seCntday03_6w['VLINDATENIGHT'] + (int) $result_seCntday04_6w['VLINDATENIGHT'] + (int) $result_seCntday05_6w['VLINDATENIGHT'] + (int) $result_seCntday06_6w['VLINDATENIGHT'] + (int) $result_seCntday07_6w['VLINDATENIGHT'] + (int) $result_seCntday08_6w['VLINDATENIGHT'] + (int) $result_seCntday09_6w['VLINDATENIGHT'] + (int) $result_seCntday10_6w['VLINDATENIGHT'] + (int) $result_seCntday11_6w['VLINDATENIGHT'] + (int) $result_seCntday12_6w['VLINDATENIGHT'] + (int) $result_seCntday13_6w['VLINDATENIGHT'] + (int) $result_seCntday14_6w['VLINDATENIGHT'] + (int) $result_seCntday15_6w['VLINDATENIGHT'] + (int) $result_seCntday16_6w['VLINDATENIGHT'] + (int) $result_seCntday17_6w['VLINDATENIGHT'] + (int) $result_seCntday18_6w['VLINDATENIGHT'] + (int) $result_seCntday19_6w['VLINDATENIGHT'] + (int) $result_seCntday20_6w['VLINDATENIGHT'] + (int) $result_seCntday21_6w['VLINDATENIGHT'] + (int) $result_seCntday22_6w['VLINDATENIGHT'] + (int) $result_seCntday23_6w['VLINDATENIGHT'] + (int) $result_seCntday24_6w['VLINDATENIGHT'] + (int) $result_seCntday25_6w['VLINDATENIGHT'] + (int) $result_seCntday26_6w['VLINDATENIGHT'] + (int) $result_seCntday27_6w['VLINDATENIGHT'] + (int) $result_seCntday28_6w['VLINDATENIGHT'] + (int) $result_seCntday29_6w['VLINDATENIGHT'] + (int) $result_seCntday30_6w['VLINDATENIGHT'] + (int) $result_seCntday31_6w['VLINDATENIGHT'];


$Cntmaxexpressway15 = (int) $result_seMaxexpressway1501['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1502['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1503['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1504['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1505['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1506['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1507['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1508['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1509['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1510['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1511['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1512['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1513['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1514['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1515['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1516['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1517['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1518['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1519['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1520['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1521['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1522['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1523['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1524['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1525['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1526['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1527['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1528['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1529['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1530['MAXEXPRESSWAY15'] + (int) $result_seMaxexpressway1531['MAXEXPRESSWAY15'];
$Cntmaxexpressway65 = (int) $result_seMaxexpressway6501['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6502['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6503['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6504['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6505['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6506['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6507['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6508['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6509['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6510['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6511['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6512['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6513['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6514['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6515['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6516['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6517['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6518['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6519['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6520['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6521['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6522['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6523['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6524['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6525['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6526['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6527['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6528['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6529['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6530['MAXEXPRESSWAY65'] + (int) $result_seMaxexpressway6531['MAXEXPRESSWAY65'];
$Cntmaxexpressway100 = (int) $result_seMaxexpressway10001['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10002['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10003['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10004['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10005['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10006['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10007['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10008['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10009['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10010['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10011['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10012['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10013['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10014['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10015['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10016['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10017['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10018['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10019['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10020['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10021['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10022['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10023['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10024['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10025['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10026['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10027['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10028['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10029['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10030['MAXEXPRESSWAY100'] + (int) $result_seMaxexpressway10031['MAXEXPRESSWAY100'];
$Cntmaxexpressway195 = (int) $result_seMaxexpressway19501['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19502['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19503['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19504['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19505['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19506['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19507['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19508['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19509['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19510['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19511['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19512['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19513['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19514['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19515['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19516['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19517['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19518['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19519['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19520['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19521['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19522['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19523['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19524['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19525['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19526['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19527['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19528['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19529['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19530['MAXEXPRESSWAY195'] + (int) $result_seMaxexpressway19531['MAXEXPRESSWAY195'];
$Cntmaxexpressway65return = (int) $result_seMaxexpressway65return01['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return02['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return03['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return04['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return05['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return06['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return07['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return08['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return09['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return10['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return11['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return12['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return13['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return14['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return15['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return16['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return17['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return18['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return19['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return20['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return21['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return22['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return23['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return24['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return25['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return26['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return27['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return28['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return29['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return30['MAXEXPRESSWAY65RETURN'] + (int) $result_seMaxexpressway65return31['MAXEXPRESSWAY65RETURN'];
$Cntmaxexpressway195return = (int) $result_seMaxexpressway195return01['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return02['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return03['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return04['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return05['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return06['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return07['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return08['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return09['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return10['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return11['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return12['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return13['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return14['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return15['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return16['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return17['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return18['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return19['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return20['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return21['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return22['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return23['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return24['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return25['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return26['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return27['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return28['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return29['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return30['MAXEXPRESSWAY195RETURN'] + (int) $result_seMaxexpressway195return31['MAXEXPRESSWAY195RETURN'];
$theaderexpressway = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;font-size:8px;">
<thead>
<tr style="padding:4px;">
<td colspan="38" style="border-right:1px solid #000;padding:4px;text-align:left;"><strong>Interplant running trip &amp; Expressway record : STM to SR S5 (' . $result_seExpressway10w['PAYMENTDATEDD'] . '-' . $result_seExpressway10w['PAYMENTDATEDDMMYY'] . ')</strong></td>
<td colspan="2" style="border:1px solid #000;border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
<td colspan="2" style="border:1px solid #000;border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
</tr>
  <tr >
                                                                            <td colspan="38" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">Approve</td>
                                                                            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">Issue</td>
                                                                        </tr>
                                                                         <tr style="border:1px solid #000;">
                                                                            <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width:3%"><b>Log. Partner code</b></td>
                                                                            <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width:3%"><b>Route</b></td>
                                                                            <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width:4%"><b>Part Type</b></td>
                                                                            <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width:3%"><b>From</b></td>
                                                                            <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width:3%"><b>To</b></td>
                                                                            <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width:3%">&nbsp;</td>
                                                                            <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width:4%"><b>SHIFT</b></td>
                                                                            <td colspan="31" style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#999999"><b>' . $result_seExpressway10w['PAYMENTDATEDDYY'] . '</b></td>
                                                                            <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>1st period</b></td>
                                                                        </tr>
                                                                         <tr style="border:1px solid #000;">
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>1</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>2</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>3</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>4</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>5</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>6</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>7</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>8</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>9</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>10</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>11</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>12</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>13</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>14</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>15</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>16</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>17</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>18</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>19</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>20</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>21</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>22</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>23</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>24</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>25</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>26</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>27</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>28</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>29</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>30</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;width:2%"><b>31</b></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">Total trip</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">price/trip</td>
                                                                            <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">Total amount</td>
                                                                        </tr>
</thead><tbody>';


$tbodyexpressway = '<tr style="border:1px solid #000;">
                                                                            <td rowspan="20" style="border-right:1px solid #000;padding:4px;text-align:center;">RKS</td>
                                                                            <td rowspan="20" style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">STM to SR S5</td>
                                                                            <td rowspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">ENGING(10 WHEEL)</td>
                                                                            <td rowspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">STM</td>
                                                                            <td rowspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">(A)S/R</td>
                                                                            <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">Plan</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;" >DAY</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>

                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;width:4%">-</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;width:4%">-</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;width:8%" colspan="2">-</td>
                                                                        </tr>
                                                                         <tr style="border:1px solid #000;">
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">NIGHT</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">-</td>
                                                                        </tr>


                                                                    <tr style="border:1px solid #000;">
                                                                        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">Total</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2" bgcolor="#CCCCCC">-</td>
                                                                    </tr>
                                                                     <tr style="border:1px solid #000;">
                                                                        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;"  bgcolor="#CCCCCC">Actual</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">DAY</td>

                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday01['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday02['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday03['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday04['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday05['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday06['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday07['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday08['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday09['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday10['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday11['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday12['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday13['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday14['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday15['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday16['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday17['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday18['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday19['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday20['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday21['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday22['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday23['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday24['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday25['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday26['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday27['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday28['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday29['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday30['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday31['VLINDATEDAY'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $cntday10w . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seExpressway10w['ACTUALPRICE']) . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">' . number_format($cntday10w * $result_seExpressway10w['ACTUALPRICE']) . '</td>

                                                                    </tr>
                                                                     <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"  bgcolor="#CCCCCC">NIGHT</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight01['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight02['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight03['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight04['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight05['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight06['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight07['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight08['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight09['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight10['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight11['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight12['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight13['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight14['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight15['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight16['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight17['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight18['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight19['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight20['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight21['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight22['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight23['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight24['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight25['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight26['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight27['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight28['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight29['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight30['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight31['VLINDATENIGHT'] . '</td>

                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $Cntnight10w . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seExpressway10w['ACTUALPRICE']) . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">' . number_format($Cntnight10w * $result_seExpressway10w['ACTUALPRICE']) . '</td>

                                                                    </tr>
                                                                     <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">EXTRA</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seExpressway10w['ACTUALPRICE']) . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">-</td>
                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">Total</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2" bgcolor="#CCCCCC">' . number_format(($cntday10w * $result_seExpressway10w['ACTUALPRICE']) + ($Cntnight10w * $result_seExpressway10w['ACTUALPRICE'])) . '</td>

                                                                    </tr>
                                                                     <tr style="border:1px solid #000;">
                                                                            <td rowspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;"  bgcolor="#CCCCCC">ENGING(6 WHEEL)</td>
                                                                            <td rowspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;"  bgcolor="#CCCCCC">STM</td>
                                                                            <td rowspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;"  bgcolor="#CCCCCC">(A)S/R</td>
                                                                            <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"  bgcolor="#CCCCCC">Plan</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">DAY</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">-</td>
    </tr>
                                                                         <tr style="border:1px solid #000;">
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">NIGHT</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
                                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">-</td>
                                                                        </tr>


                                                                    <tr style="border:1px solid #000;">
                                                                        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">Total</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2" bgcolor="#CCCCCC">-</td>
                                                                    </tr>
                                                                     <tr style="border:1px solid #000;">
                                                                        <td rowspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;"  bgcolor="#CCCCCC">Actual</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">DAY</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday01_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday02_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday03_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday04_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday05_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday06_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday07_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday08_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday09_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday10_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday11_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday12_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday13_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday14_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday15_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday16_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday17_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday18_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday19_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday20_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday21_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday22_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday23_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday24_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday25_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday26_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday27_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday28_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday29_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday30_6W['VLINDATEDAY'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntday31_6W['VLINDATEDAY'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $Cntday6w . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seExpressway6w['ACTUALPRICE']) . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">' . number_format($Cntday6w * $result_seExpressway6w['ACTUALPRICE']) . '</td>

                                                                    </tr>
                                                                     <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">NIGHT</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight01_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight02_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight03_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight04_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight05_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight06_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight07_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight08_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight09_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight10_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight11_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight12_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight13_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight14_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight15_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight16_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight17_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight18_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight19_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight20_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight21_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight22_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight23_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight24_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight25_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight26_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight27_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight28_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight29_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight30_6w['VLINDATENIGHT'] . '</td>
                                                                           <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seCntnight31_6w['VLINDATENIGHT'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $Cntnight6w . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seExpressway6w['ACTUALPRICE']) . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">' . number_format($Cntnight6w * $result_seExpressway6w['ACTUALPRICE']) . '</td>

                                                                    </tr>
                                                                     <tr style="border:1px solid #000;">
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">EXTRA</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seExpressway6w['ACTUALPRICE']) . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">-</td>
                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">Total</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">&nbsp;</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">-</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2" bgcolor="#CCCCCC">' . number_format(($Cntnight6w * $result_seExpressway6w['ACTUALPRICE']) + ($Cntday6w * $result_seExpressway6w['ACTUALPRICE'])) . '</td>
                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">Expressway 15</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1501['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1502['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1503['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1504['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1505['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1506['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1507['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1508['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1509['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1510['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1511['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1512['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1513['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1514['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1515['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1516['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1517['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1518['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1519['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1520['MAXEXPRESSWAY15'] . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1521['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1522['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1523['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1524['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1525['MAXEXPRESSWAY15'] . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1526['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1527['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1528['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1529['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1530['MAXEXPRESSWAY15'] . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway1531['MAXEXPRESSWAY15'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $Cntmaxexpressway15 . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">15</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">' . number_format($Cntmaxexpressway15 * 15) . '</td>
                                                                    </tr>


<tr style="border:1px solid #000;">
                                                                        <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">Expressway 45</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6501['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6502['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6503['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6504['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6505['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6506['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6507['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6508['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6509['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6510['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6511['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6512['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6513['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6514['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6515['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6516['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6517['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6518['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6519['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6520['MAXEXPRESSWAY100'] . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6521['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6522['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6523['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6524['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6525['MAXEXPRESSWAY100'] . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6526['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6527['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6528['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6529['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6530['MAXEXPRESSWAY100'] . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway6531['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $Cntmaxexpressway65 . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">65</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">' . number_format($Cntmaxexpressway65 * 65) . '</td>
                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">Expressway 55</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10001['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10002['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10003['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10004['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10005['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10006['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10007['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10008['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10009['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10010['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10011['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10012['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10013['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10014['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10015['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10016['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10017['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10018['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10019['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10020['MAXEXPRESSWAY100'] . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10021['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10022['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10023['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10024['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10025['MAXEXPRESSWAY100'] . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10026['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10027['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10028['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10029['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10030['MAXEXPRESSWAY100'] . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway10031['MAXEXPRESSWAY100'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $Cntmaxexpressway100 . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">100</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">' . number_format($Cntmaxexpressway100 * 100) . '</td>
                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">Expressway 195</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19501['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19502['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19503['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19504['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19505['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19506['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19507['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19508['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19509['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19510['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19511['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19512['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19513['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19514['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19515['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19516['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19517['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19518['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19519['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19520['MAXEXPRESSWAY195'] . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19521['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19522['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19523['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19524['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19525['MAXEXPRESSWAY195'] . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19526['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19527['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19528['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19529['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19530['MAXEXPRESSWAY195'] . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway19531['MAXEXPRESSWAY195'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $Cntmaxexpressway195 . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">195</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">' . number_format($Cntmaxexpressway195 * 195) . '</td>
                                                                    </tr>

                                                                    <tr style="border:1px solid #000;">
                                                                        <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">Expressway 65 (Return trip)</td>
                                                                       <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return01['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return02['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return03['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return04['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return05['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return06['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return07['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return08['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return09['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return10['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return11['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return12['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return13['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return14['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return15['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return16['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return17['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return18['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return19['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return20['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return21['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return22['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return23['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return24['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return25['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return26['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return27['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return28['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return29['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return30['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway65return31['MAXEXPRESSWAY65RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $Cntmaxexpressway65return . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">65</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">' . number_format($Cntmaxexpressway65return * 65) . '</td>
                                                                    </tr>
                                                                    <tr style="border:1px solid #000;">
                                                                        <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;" bgcolor="#CCCCCC">Expressway 105 (Return trip)</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return01['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return02['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return03['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return04['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return05['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return06['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return07['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return08['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return09['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return10['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return11['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return12['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return13['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return14['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return15['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return16['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return17['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return18['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return19['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return20['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return21['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return22['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return23['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return24['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return25['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return26['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return27['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return28['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return29['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return30['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                         <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seMaxexpressway105return31['MAXEXPRESSWAY105RETURN'] . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $Cntmaxexpressway105return . '</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;">105</td>
                                                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">' . number_format($Cntmaxexpressway105return * 105) . '</td>
                                                                    </tr>


</tbody><tfoot>';
$tfootexpressway = '<tr>
                                                                        <td colspan="42" style="padding:4px;text-align:left;">&nbsp;</td>

                                                                    </tr>
<tr>
                                                                        <td colspan="42" style="padding:4px;text-align:left;">Remark :</td>

                                                                    </tr>
                                                                    <tr >
                                                                        <td colspan="42" style="padding:4px;text-align:left;">1. For normal route plan, Please refer to route planner information (Can assume daily running trip by route planner info)</td>

                                                                    </tr>
                                                                    <tr >
                                                                        <td colspan="42" style="padding:4px;text-align:left;">2. For Sequence route (e.g. KLTL : Frame, RR Axel, Side deck, etc. , ATH : Frame, Side Deck) , No need to input plan</td>

                                                                    </tr>
                                                                    <tr >
                                                                        <td colspan="42" style="padding:4px;text-align:left;">3. Submit signed format with debit note, If not submit with debit note LP will not accept that note</td>

                                                                    </tr>
                                                                    <tr >
                                                                        <td colspan="42" style="padding:4px;text-align:left;">4. After planning was end, Log Partner need to submit this form by e-mail to LP within 3 working days</td>

                                                                    </tr>
</tfoot>


                                                     </table>';


$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_header31);
$mpdf->WriteHTML($table_header3);
$mpdf->WriteHTML($table_begin3);
$mpdf->WriteHTML($tbody3);
$mpdf->WriteHTML($tfoot3);
if ($result_seWeek1['BILLINGDATE'] != '') {
    $mpdf->AddPage();
    $mpdf->WriteHTML($table_headerw11);
    $mpdf->WriteHTML($table_headerw1);
    $mpdf->WriteHTML($table_beginw1);
    $mpdf->WriteHTML($tbodyw1);
    $mpdf->WriteHTML($tfootw1);
}
if ($result_seWeek2['BILLINGDATE'] != '') {
    $mpdf->AddPage();
    $mpdf->WriteHTML($table_headerw22);
    $mpdf->WriteHTML($table_headerw2);
    $mpdf->WriteHTML($table_beginw2);
    $mpdf->WriteHTML($tbodyw2);
    $mpdf->WriteHTML($tfootw2);
}
if ($result_seWeek3['BILLINGDATE'] != '') {
    $mpdf->AddPage();
    $mpdf->WriteHTML($table_headerw33);
    $mpdf->WriteHTML($table_headerw3);
    $mpdf->WriteHTML($table_beginw3);
    $mpdf->WriteHTML($tbodyw3);
    $mpdf->WriteHTML($tfootw3);
}
if ($result_seWeek4['BILLINGDATE'] != '') {
    $mpdf->AddPage();
    $mpdf->WriteHTML($table_headerw44);
    $mpdf->WriteHTML($table_headerw4);
    $mpdf->WriteHTML($table_beginw4);
    $mpdf->WriteHTML($tbodyw4);
    $mpdf->WriteHTML($tfootw4);
}
if ($result_seWeek5['BILLINGDATE'] != '') {
    $mpdf->AddPage();
    $mpdf->WriteHTML($table_headerw55);
    $mpdf->WriteHTML($table_headerw5);
    $mpdf->WriteHTML($table_beginw5);
    $mpdf->WriteHTML($tbodyw5);
    $mpdf->WriteHTML($tfootw5);
}
$mpdf->AddPage('L', 'A4', '', '', '', 5, 5, 5, 5, 5, 5);
$mpdf->WriteHTML($theaderexpressway);
$mpdf->WriteHTML($tbodyexpressway);
$mpdf->WriteHTML($tfootexpressway);
$mpdf->Output();
sqlsrv_close($conn);
?>
