<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");

$mpdf = new mPDF('th', 'A4', 10, 10, 10, 10, 10);





$sql_seDate = "SELECT DISTINCT BILLINGDATE,PAYMENTDATE FROM LOGINVOICE WHERE REMARK = 1 AND INVOICECODE = RTRIM('" . $_GET['invoicecode'] . "')";
$query_seDate = sqlsrv_query($conn, $sql_seDate, $params_seDate);
$result_seDate = sqlsrv_fetch_array($query_seDate, SQLSRV_FETCH_ASSOC);

$mms = "";
switch ((int) substr($result_seDate['BILLINGDATE'], 3, 2)) {
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
switch ((int) substr($result_seDate['PAYMENTDATE'], 3, 2)) {
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

$startdate = substr($result_seDate['BILLINGDATE'], 0, 2);
$dateend = substr($result_seDate['PAYMENTDATE'], 0, 2);
$BE = substr($result_seDate['PAYMENTDATE'], 6, 10);

if ($mms == $mme) {
    $month = $startdate . " - " . $dateend . " " . $mms . " " . $BE;
} else {
    $month = $startdate . " " . $mms . " - " . $dateend . " " . $mme . " " . $BE;
}


$sumqtyip01=0;
$sumpriceip01=0;
$sumqtyholip01=0;
$sumpriceholip01=0;


$style = '
<style>
        body{
                font-family: "arial";font-size:12px//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
        }
</style>';

///////////////////////////IP-01//////////////////

$table_headerip01 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b>DETAILS FOR TRIPS OF STM (INTERPLANT) 10 Wheels</b></td>
</tr>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b><u>(MONTH</u> : ' . $month . ')</b></td>
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
<td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">LOGISTICSPLANING</td>
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

$table_beginip01 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;font-size:12;">
<thead>
<tr style="border:1px solid #000;padding:4px;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>NO.</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>DATE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ROUTE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>QTY TRIP</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>Extra Truck</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Cost/Trip</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;"><b>TOTAL</b></td>
</tr>
</thead>
<tbody>';
$iip01 = 1;

$sql_seBillingip01 = "SELECT DISTINCT a.[VLINDATE] FROM [dbo].[LOGINVOICE] a 
WHERE a.INVOICECODE='" . $_GET['invoicecode'] . "' AND TRANSPORTATION='STM(F.1)->STM(F.2) (IP01)' AND (DATENAME(DW,a.VLINDATE) != 'Sunday')";
$params_seBillingip01 = array();
$query_seBillingip01 = sqlsrv_query($conn, $sql_seBillingip01, $params_seBillingip01);
while ($result_seBillingip01 = sqlsrv_fetch_array($query_seBillingip01, SQLSRV_FETCH_ASSOC)) {


    $mip01 = "";
    switch ((int) substr($result_seBillingip01['VLINDATE'], 5, 2)) {
        case '1': {
                $mip01 = "Jan";
            }
            break;
        case '2': {
                $mip01 = "Feb";
            }
            break;
        case '3': {
                $mip01 = "Mar";
            }
            break;
        case '4': {
                $mip01 = "Apr";
            }
            break;
        case '5': {
                $mip01 = "May";
            }
            break;
        case '6': {
                $mip01 = "Jun";
            }
            break;
        case '7': {
                $mip01 = "Jul";
            }
            break;
        case '8': {
                $mip01 = "Aug";
            }
            break;
        case '9': {
                $mip01 = "Sep";
            }
            break;
        case '10': {
                $mip01 = "Oct";
            }
            break;
        case '11': {
                $mip01 = "Nov";
            }
            break;
        default : {
                $mip01 = "Dec";
            }
            break;
    }
    $dip01 = substr($result_seBillingip01['VLINDATE'], 8, 2);
    $yip01 = substr($result_seBillingip01['VLINDATE'], 0, 4);

    $dmyip01 = $dip01 . "-" . $mip01 . "-" . $yip01;



    $sql_seTripamountip01 = "SELECT SUM(CAST(LEFT(b.ROUNDAMOUNT,PATINDEX('%[^0-9]%',b.ROUNDAMOUNT)-1) AS int)) AS 'SUMTRIPSTM'
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
            WHERE 1 = 1
            AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seBillingip01['VLINDATE'] . "',111) AND CONVERT(DATE,'" . $result_seBillingip01['VLINDATE'] . "',111)
            AND b.COMPANYCODE = 'RKS' AND b.CUSTOMERCODE = 'STM'
            AND a.DOCUMENTCODE != '' AND b.JOBSTART='STM(F.1)->STM(F.2) (IP01)'
            AND (SUBSTRING(ROUNDAMOUNT, 3, 3) = 'D' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'D'
            OR SUBSTRING(ROUNDAMOUNT, 3, 3) = 'N' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'N' )  ";
    $query_seTripamountip01 = sqlsrv_query($conn, $sql_seTripamountip01, $params_seTripamountip01);
    $result_seTripamountip01 = sqlsrv_fetch_array($query_seTripamountip01, SQLSRV_FETCH_ASSOC);

    $sql_sePriceip01 = "SELECT TOP 1 PRICE FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE [VEHICLETYPE]='10W' AND [FROM]='STM(F.1)->STM(F.2) (IP01)' ORDER BY [CREATEDATE] DESC";
    $query_sePriceip01 = sqlsrv_query($conn, $sql_sePriceip01, $params_sePriceip01);
    $result_sePriceip01 = sqlsrv_fetch_array($query_sePriceip01, SQLSRV_FETCH_ASSOC);


    $tbodyip01 .= '
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $iip01 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $dmyip01 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">IP-01</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTripamountip01['SUMTRIPSTM'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_sePriceip01['PRICE'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seTripamountip01['SUMTRIPSTM'] * $result_sePriceip01['PRICE']) . '</td>

</tr>
    ';
    $sumqtyip01=$sumqtyip01+$result_seTripamountip01['SUMTRIPSTM'];
    $sumpriceip01=$sumpriceip01+($result_seTripamountip01['SUMTRIPSTM'] * $result_sePriceip01['PRICE']);
    $iip01++;
}



$tfootip01 = '</tbody>
<tfoot>


<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="2"><b>Total</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b>'.$sumqtyip01.'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b>'.number_format($sumpriceip01).'</td>

</tr>



<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="3"><b>Tarditional Holidays</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>

</tr>';
$iholip01 = 1;

$sql_seBillingholip01 = "SELECT DISTINCT a.[VLINDATE] FROM [dbo].[LOGINVOICE] a 
WHERE a.INVOICECODE='" . $_GET['invoicecode'] . "' AND TRANSPORTATION='STM(F.1)->STM(F.2) (IP01)' AND (DATENAME(DW,a.VLINDATE) = 'Sunday')";
$params_seBillingholip01 = array();
$query_seBillingholip01 = sqlsrv_query($conn, $sql_seBillingholip01, $params_seBillingholip01);
while ($result_seBillingholip01 = sqlsrv_fetch_array($query_seBillingholip01, SQLSRV_FETCH_ASSOC)) {


    $mholip01 = "";
    switch ((int) substr($result_seBillingholip01['VLINDATE'], 5, 2)) {
        case '1': {
                $mholip01 = "Jan";
            }
            break;
        case '2': {
                $mholip01 = "Feb";
            }
            break;
        case '3': {
                $mholip01 = "Mar";
            }
            break;
        case '4': {
                $mholip01 = "Apr";
            }
            break;
        case '5': {
                $mholip01 = "May";
            }
            break;
        case '6': {
                $mholip01 = "Jun";
            }
            break;
        case '7': {
                $mholip01 = "Jul";
            }
            break;
        case '8': {
                $mholip01 = "Aug";
            }
            break;
        case '9': {
                $mholip01 = "Sep";
            }
            break;
        case '10': {
                $mholip01 = "Oct";
            }
            break;
        case '11': {
                $mholip01 = "Nov";
            }
            break;
        default : {
                $mholip01 = "Dec";
            }
            break;
    }
    $dholip01 = substr($result_seBillingholip01['VLINDATE'], 8, 2);
    $yholip01 = substr($result_seBillingholip01['VLINDATE'], 0, 4);

    $dmyholip01 = $dholip01 . "-" . $mholip01 . "-" . $yholip01;



    $sql_seTripamountholip01 = "SELECT SUM(CAST(LEFT(b.ROUNDAMOUNT,PATINDEX('%[^0-9]%',b.ROUNDAMOUNT)-1) AS int)) AS 'SUMTRIPSTM'
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
            WHERE 1 = 1
            AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seBillingholip01['VLINDATE'] . "',111) AND CONVERT(DATE,'" . $result_seBillingholip01['VLINDATE'] . "',111)
            AND b.COMPANYCODE = 'RKS' AND b.CUSTOMERCODE = 'STM'
            AND a.DOCUMENTCODE != '' AND b.JOBSTART='STM(F.1)->STM(F.2) (IP01)'
            AND (SUBSTRING(ROUNDAMOUNT, 3, 3) = 'D' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'D'
            OR SUBSTRING(ROUNDAMOUNT, 3, 3) = 'N' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'N' )  ";
    $query_seTripamountholip01 = sqlsrv_query($conn, $sql_seTripamountholip01, $params_seTripamountholip01);
    $result_seTripamountholip01 = sqlsrv_fetch_array($query_seTripamountholip01, SQLSRV_FETCH_ASSOC);

    $sql_sePriceholip01 = "SELECT TOP 1 PRICE FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE [VEHICLETYPE]='10W' AND [FROM]='STM(F.1)->STM(F.2) (IP01)' ORDER BY [CREATEDATE] DESC";
    $query_sePriceholip01 = sqlsrv_query($conn, $sql_sePriceholip01, $params_sePriceholip01);
    $result_sePriceholip01 = sqlsrv_fetch_array($query_sePriceholip01, SQLSRV_FETCH_ASSOC);


    $tfootip01 .= '
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $iholip01 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $dmyholip01 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">IP-01</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTripamountholip01['SUMTRIPSTM'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_sePriceholip01['PRICE'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seTripamountholip01['SUMTRIPSTM'] * $result_sePriceholip01['PRICE']) . '</td>

</tr>
    ';
    $sumqtyholip01=$sumqtyholip01+$result_seTripamountholip01['SUMTRIPSTM'];
    $sumpriceholip01=$sumpriceholip01+($result_seTripamountholip01['SUMTRIPSTM'] * $result_sePriceholip01['PRICE']);
    $iholip01++;
}
$rsqtyip01=$sumqtyip01+$sumqtyholip01;
$rspriceip01=$sumpriceip01+$sumpriceholip01;
$tfootip01 .='<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="3"><b>Grand Total</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b>'.$rsqtyip01.'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>'.number_format($rspriceip01).'</b></td>

</tr>

</tfoot>
                                                 </table>
';



/////////////////////IP-02//////////////////////






$table_headerip02 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b>DETAILS FOR TRIPS OF STM (INTERPLANT) 10 Wheels</b></td>
</tr>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b><u>(MONTH</u> : ' . $month . ')</b></td>
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
<td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">LOGISTICSPLANING</td>
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

$table_beginip02 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;font-size:12;">
<thead>
<tr style="border:1px solid #000;padding:4px;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>NO.</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>DATE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ROUTE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>QTY TRIP</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>Extra Truck</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Cost/Trip</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;"><b>TOTAL</b></td>
</tr>
</thead>
<tbody>';
$iip02 = 1;

$sql_seBillingip02 = "SELECT DISTINCT a.[VLINDATE] FROM [dbo].[LOGINVOICE] a 
WHERE a.INVOICECODE='" . $_GET['invoicecode'] . "' AND TRANSPORTATION='STM(F.1)->STM(F.2) (IP02)' AND (DATENAME(DW,a.VLINDATE) != 'Sunday')";
$params_seBillingip02 = array();
$query_seBillingip02 = sqlsrv_query($conn, $sql_seBillingip02, $params_seBillingip02);
while ($result_seBillingip02 = sqlsrv_fetch_array($query_seBillingip02, SQLSRV_FETCH_ASSOC)) {


    $mip02 = "";
    switch ((int) substr($result_seBillingip02['VLINDATE'], 5, 2)) {
        case '1': {
                $mip02 = "Jan";
            }
            break;
        case '2': {
                $mip02 = "Feb";
            }
            break;
        case '3': {
                $mip02 = "Mar";
            }
            break;
        case '4': {
                $mip02 = "Apr";
            }
            break;
        case '5': {
                $mip02 = "May";
            }
            break;
        case '6': {
                $mip02 = "Jun";
            }
            break;
        case '7': {
                $mip02 = "Jul";
            }
            break;
        case '8': {
                $mip02 = "Aug";
            }
            break;
        case '9': {
                $mip02 = "Sep";
            }
            break;
        case '10': {
                $mip02 = "Oct";
            }
            break;
        case '11': {
                $mip02 = "Nov";
            }
            break;
        default : {
                $mip02 = "Dec";
            }
            break;
    }
    $dip02 = substr($result_seBillingip02['VLINDATE'], 8, 2);
    $yip02 = substr($result_seBillingip02['VLINDATE'], 0, 4);

    $dmyip02 = $dip02 . "-" . $mip02 . "-" . $yip02;



    $sql_seTripamountip02 = "SELECT SUM(CAST(LEFT(b.ROUNDAMOUNT,PATINDEX('%[^0-9]%',b.ROUNDAMOUNT)-1) AS int)) AS 'SUMTRIPSTM'
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
            WHERE 1 = 1
            AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seBillingip02['VLINDATE'] . "',111) AND CONVERT(DATE,'" . $result_seBillingip02['VLINDATE'] . "',111)
            AND b.COMPANYCODE = 'RKS' AND b.CUSTOMERCODE = 'STM'
            AND a.DOCUMENTCODE != '' AND b.JOBSTART='STM(F.1)->STM(F.2) (IP02)'
            AND (SUBSTRING(ROUNDAMOUNT, 3, 3) = 'D' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'D'
            OR SUBSTRING(ROUNDAMOUNT, 3, 3) = 'N' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'N' )  ";
    $query_seTripamountip02 = sqlsrv_query($conn, $sql_seTripamountip02, $params_seTripamountip02);
    $result_seTripamountip02 = sqlsrv_fetch_array($query_seTripamountip02, SQLSRV_FETCH_ASSOC);

    $sql_sePriceip02 = "SELECT TOP 1 PRICE FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE [VEHICLETYPE]='10W' AND [FROM]='STM(F.1)->STM(F.2) (IP02)' ORDER BY [CREATEDATE] DESC";
    $query_sePriceip02 = sqlsrv_query($conn, $sql_sePriceip02, $params_sePriceip02);
    $result_sePriceip02 = sqlsrv_fetch_array($query_sePriceip02, SQLSRV_FETCH_ASSOC);


    $tbodyip02 .= '
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $iip02 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $dmyip02 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">IP-02</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTripamountip02['SUMTRIPSTM'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_sePriceip02['PRICE'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seTripamountip02['SUMTRIPSTM'] * $result_sePriceip02['PRICE']) . '</td>

</tr>
    ';
    $sumqtyip02=$sumqtyip02+$result_seTripamountip02['SUMTRIPSTM'];
    $sumpriceip02=$sumpriceip02+($result_seTripamountip02['SUMTRIPSTM'] * $result_sePriceip02['PRICE']);
    $iip02++;
}



$tfootip02 = '</tbody>
<tfoot>


<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="2"><b>Total</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b>'.$sumqtyip02.'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b>'.number_format($sumpriceip02).'</td>

</tr>



<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="3"><b>Tarditional Holidays</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>

</tr>';
$iholip02 = 1;

$sql_seBillingholip02 = "SELECT DISTINCT a.[VLINDATE] FROM [dbo].[LOGINVOICE] a 
WHERE a.INVOICECODE='" . $_GET['invoicecode'] . "' AND TRANSPORTATION='STM(F.1)->STM(F.2) (IP02)' AND (DATENAME(DW,a.VLINDATE) = 'Sunday')";
$params_seBillingholip02 = array();
$query_seBillingholip02 = sqlsrv_query($conn, $sql_seBillingholip02, $params_seBillingholip02);
while ($result_seBillingholip02 = sqlsrv_fetch_array($query_seBillingholip02, SQLSRV_FETCH_ASSOC)) {


    $mholip02 = "";
    switch ((int) substr($result_seBillingholip02['VLINDATE'], 5, 2)) {
        case '1': {
                $mholip02 = "Jan";
            }
            break;
        case '2': {
                $mholip02 = "Feb";
            }
            break;
        case '3': {
                $mholip02 = "Mar";
            }
            break;
        case '4': {
                $mholip02 = "Apr";
            }
            break;
        case '5': {
                $mholip02 = "May";
            }
            break;
        case '6': {
                $mholip02 = "Jun";
            }
            break;
        case '7': {
                $mholip02 = "Jul";
            }
            break;
        case '8': {
                $mholip02 = "Aug";
            }
            break;
        case '9': {
                $mholip02 = "Sep";
            }
            break;
        case '10': {
                $mholip02 = "Oct";
            }
            break;
        case '11': {
                $mholip02 = "Nov";
            }
            break;
        default : {
                $mholip02 = "Dec";
            }
            break;
    }
    $dholip02 = substr($result_seBillingholip02['VLINDATE'], 8, 2);
    $yholip02 = substr($result_seBillingholip02['VLINDATE'], 0, 4);

    $dmyholip02 = $dholip02 . "-" . $mholip02 . "-" . $yholip02;



    $sql_seTripamountholip02 = "SELECT SUM(CAST(LEFT(b.ROUNDAMOUNT,PATINDEX('%[^0-9]%',b.ROUNDAMOUNT)-1) AS int)) AS 'SUMTRIPSTM'
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
            WHERE 1 = 1
            AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seBillingholip02['VLINDATE'] . "',111) AND CONVERT(DATE,'" . $result_seBillingholip02['VLINDATE'] . "',111)
            AND b.COMPANYCODE = 'RKS' AND b.CUSTOMERCODE = 'STM'
            AND a.DOCUMENTCODE != '' AND b.JOBSTART='STM(F.1)->STM(F.2) (IP02)'
            AND (SUBSTRING(ROUNDAMOUNT, 3, 3) = 'D' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'D'
            OR SUBSTRING(ROUNDAMOUNT, 3, 3) = 'N' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'N' )  ";
    $query_seTripamountholip02 = sqlsrv_query($conn, $sql_seTripamountholip02, $params_seTripamountholip02);
    $result_seTripamountholip02 = sqlsrv_fetch_array($query_seTripamountholip02, SQLSRV_FETCH_ASSOC);

    $sql_sePriceholip02 = "SELECT TOP 1 PRICE FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE [VEHICLETYPE]='10W' AND [FROM]='STM(F.1)->STM(F.2) (IP02)' ORDER BY [CREATEDATE] DESC";
    $query_sePriceholip02 = sqlsrv_query($conn, $sql_sePriceholip02, $params_sePriceholip02);
    $result_sePriceholip02 = sqlsrv_fetch_array($query_sePriceholip02, SQLSRV_FETCH_ASSOC);


    $tfootip02 .= '
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $iholip02 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $dmyholip02 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">IP-02</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTripamountholip02['SUMTRIPSTM'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_sePriceholip02['PRICE'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seTripamountholip02['SUMTRIPSTM'] * $result_sePriceholip02['PRICE']) . '</td>

</tr>
    ';
    $sumqtyholip02=$sumqtyholip02+$result_seTripamountholip02['SUMTRIPSTM'];
    $sumpriceholip02=$sumpriceholip02+($result_seTripamountholip02['SUMTRIPSTM'] * $result_sePriceholip02['PRICE']);
    $iholip02++;
}
$rsqtyip02=$sumqtyip02+$sumqtyholip02;
$rspriceip02=$sumpriceip02+$sumpriceholip02;
$tfootip02 .='<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="3"><b>Grand Total</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b>'.$rsqtyip02.'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>'.number_format($rspriceip02).'</b></td>

</tr>

</tfoot>
                                                 </table>
';


/////////////////////////////IP-03/////////////////////////




$table_headerip03 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b>DETAILS FOR TRIPS OF STM (INTERPLANT) 10 Wheels</b></td>
</tr>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b><u>(MONTH</u> : ' . $month . ')</b></td>
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
<td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">LOGISTICSPLANING</td>
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

$table_beginip03 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;font-size:12;">
<thead>
<tr style="border:1px solid #000;padding:4px;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>NO.</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>DATE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ROUTE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>QTY TRIP</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>Extra Truck</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Cost/Trip</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;"><b>TOTAL</b></td>
</tr>
</thead>
<tbody>';
$iip03 = 1;

$sql_seBillingip03 = "SELECT DISTINCT a.[VLINDATE] FROM [dbo].[LOGINVOICE] a 
WHERE a.INVOICECODE='" . $_GET['invoicecode'] . "' AND TRANSPORTATION='STM(F.1)->STM(F.2) (IP03)' AND (DATENAME(DW,a.VLINDATE) != 'Sunday')";
$params_seBillingip03 = array();
$query_seBillingip03 = sqlsrv_query($conn, $sql_seBillingip03, $params_seBillingip03);
while ($result_seBillingip03 = sqlsrv_fetch_array($query_seBillingip03, SQLSRV_FETCH_ASSOC)) {


    $mip03 = "";
    switch ((int) substr($result_seBillingip03['VLINDATE'], 5, 2)) {
        case '1': {
                $mip03 = "Jan";
            }
            break;
        case '2': {
                $mip03 = "Feb";
            }
            break;
        case '3': {
                $mip03 = "Mar";
            }
            break;
        case '4': {
                $mip03 = "Apr";
            }
            break;
        case '5': {
                $mip03 = "May";
            }
            break;
        case '6': {
                $mip03 = "Jun";
            }
            break;
        case '7': {
                $mip03 = "Jul";
            }
            break;
        case '8': {
                $mip03 = "Aug";
            }
            break;
        case '9': {
                $mip03 = "Sep";
            }
            break;
        case '10': {
                $mip03 = "Oct";
            }
            break;
        case '11': {
                $mip03 = "Nov";
            }
            break;
        default : {
                $mip03 = "Dec";
            }
            break;
    }
    $dip03 = substr($result_seBillingip03['VLINDATE'], 8, 2);
    $yip03 = substr($result_seBillingip03['VLINDATE'], 0, 4);

    $dmyip03 = $dip03 . "-" . $mip03 . "-" . $yip03;



    $sql_seTripamountip03 = "SELECT SUM(CAST(LEFT(b.ROUNDAMOUNT,PATINDEX('%[^0-9]%',b.ROUNDAMOUNT)-1) AS int)) AS 'SUMTRIPSTM'
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
            WHERE 1 = 1
            AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seBillingip03['VLINDATE'] . "',111) AND CONVERT(DATE,'" . $result_seBillingip03['VLINDATE'] . "',111)
            AND b.COMPANYCODE = 'RKS' AND b.CUSTOMERCODE = 'STM'
            AND a.DOCUMENTCODE != '' AND b.JOBSTART='STM(F.1)->STM(F.2) (IP03)'
            AND (SUBSTRING(ROUNDAMOUNT, 3, 3) = 'D' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'D'
            OR SUBSTRING(ROUNDAMOUNT, 3, 3) = 'N' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'N' )  ";
    $query_seTripamountip03 = sqlsrv_query($conn, $sql_seTripamountip03, $params_seTripamountip03);
    $result_seTripamountip03 = sqlsrv_fetch_array($query_seTripamountip03, SQLSRV_FETCH_ASSOC);

    $sql_sePriceip03 = "SELECT TOP 1 PRICE FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE [VEHICLETYPE]='10W' AND [FROM]='STM(F.1)->STM(F.2) (IP03)' ORDER BY [CREATEDATE] DESC";
    $query_sePriceip03 = sqlsrv_query($conn, $sql_sePriceip03, $params_sePriceip03);
    $result_sePriceip03 = sqlsrv_fetch_array($query_sePriceip03, SQLSRV_FETCH_ASSOC);


    $tbodyip03 .= '
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $iip03 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $dmyip03 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">IP-03</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTripamountip03['SUMTRIPSTM'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_sePriceip03['PRICE'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seTripamountip03['SUMTRIPSTM'] * $result_sePriceip03['PRICE']) . '</td>

</tr>
    ';
    $sumqtyip03=$sumqtyip03+$result_seTripamountip03['SUMTRIPSTM'];
    $sumpriceip03=$sumpriceip03+($result_seTripamountip03['SUMTRIPSTM'] * $result_sePriceip03['PRICE']);
    $iip03++;
}



$tfootip03 = '</tbody>
<tfoot>


<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="2"><b>Total</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b>'.$sumqtyip03.'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b>'.number_format($sumpriceip03).'</td>

</tr>



<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="3"><b>Tarditional Holidays</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>

</tr>';
$iholip03 = 1;

$sql_seBillingholip03 = "SELECT DISTINCT a.[VLINDATE] FROM [dbo].[LOGINVOICE] a 
WHERE a.INVOICECODE='" . $_GET['invoicecode'] . "' AND TRANSPORTATION='STM(F.1)->STM(F.2) (IP03)' AND (DATENAME(DW,a.VLINDATE) = 'Sunday')";
$params_seBillingholip03 = array();
$query_seBillingholip03 = sqlsrv_query($conn, $sql_seBillingholip03, $params_seBillingholip03);
while ($result_seBillingholip03 = sqlsrv_fetch_array($query_seBillingholip03, SQLSRV_FETCH_ASSOC)) {


    $mholip03 = "";
    switch ((int) substr($result_seBillingholip03['VLINDATE'], 5, 2)) {
        case '1': {
                $mholip03 = "Jan";
            }
            break;
        case '2': {
                $mholip03 = "Feb";
            }
            break;
        case '3': {
                $mholip03 = "Mar";
            }
            break;
        case '4': {
                $mholip03 = "Apr";
            }
            break;
        case '5': {
                $mholip03 = "May";
            }
            break;
        case '6': {
                $mholip03 = "Jun";
            }
            break;
        case '7': {
                $mholip03 = "Jul";
            }
            break;
        case '8': {
                $mholip03 = "Aug";
            }
            break;
        case '9': {
                $mholip03 = "Sep";
            }
            break;
        case '10': {
                $mholip03 = "Oct";
            }
            break;
        case '11': {
                $mholip03 = "Nov";
            }
            break;
        default : {
                $mholip03 = "Dec";
            }
            break;
    }
    $dholip03 = substr($result_seBillingholip03['VLINDATE'], 8, 2);
    $yholip03 = substr($result_seBillingholip03['VLINDATE'], 0, 4);

    $dmyholip03 = $dholip03 . "-" . $mholip03 . "-" . $yholip03;



    $sql_seTripamountholip03 = "SELECT SUM(CAST(LEFT(b.ROUNDAMOUNT,PATINDEX('%[^0-9]%',b.ROUNDAMOUNT)-1) AS int)) AS 'SUMTRIPSTM'
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
            WHERE 1 = 1
            AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seBillingholip03['VLINDATE'] . "',111) AND CONVERT(DATE,'" . $result_seBillingholip03['VLINDATE'] . "',111)
            AND b.COMPANYCODE = 'RKS' AND b.CUSTOMERCODE = 'STM'
            AND a.DOCUMENTCODE != '' AND b.JOBSTART='STM(F.1)->STM(F.2) (IP03)'
            AND (SUBSTRING(ROUNDAMOUNT, 3, 3) = 'D' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'D'
            OR SUBSTRING(ROUNDAMOUNT, 3, 3) = 'N' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'N' )  ";
    $query_seTripamountholip03 = sqlsrv_query($conn, $sql_seTripamountholip03, $params_seTripamountholip03);
    $result_seTripamountholip03 = sqlsrv_fetch_array($query_seTripamountholip03, SQLSRV_FETCH_ASSOC);

    $sql_sePriceholip03 = "SELECT TOP 1 PRICE FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE [VEHICLETYPE]='10W' AND [FROM]='STM(F.1)->STM(F.2) (IP03)' ORDER BY [CREATEDATE] DESC";
    $query_sePriceholip03 = sqlsrv_query($conn, $sql_sePriceholip03, $params_sePriceholip03);
    $result_sePriceholip03 = sqlsrv_fetch_array($query_sePriceholip03, SQLSRV_FETCH_ASSOC);


    $tfootip03 .= '
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $iholip03 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $dmyholip03 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">IP-03</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTripamountholip03['SUMTRIPSTM'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_sePriceholip03['PRICE'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seTripamountholip03['SUMTRIPSTM'] * $result_sePriceholip03['PRICE']) . '</td>

</tr>
    ';
    $sumqtyholip03=$sumqtyholip03+$result_seTripamountholip03['SUMTRIPSTM'];
    $sumpriceholip03=$sumpriceholip03+($result_seTripamountholip03['SUMTRIPSTM'] * $result_sePriceholip03['PRICE']);
    $iholip03++;
}
$rsqtyip03=$sumqtyip03+$sumqtyholip03;
$rspriceip03=$sumpriceip03+$sumpriceholip03;
$tfootip03 .='<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="3"><b>Grand Total</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b>'.$rsqtyip03.'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>'.number_format($rspriceip03).'</b></td>

</tr>

</tfoot>
                                                 </table>
';


////////////////////////IP-04/////////////////////////////////////


$table_headerip04 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b>DETAILS FOR TRIPS OF STM (INTERPLANT) 10 Wheels</b></td>
</tr>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b><u>(MONTH</u> : ' . $month . ')</b></td>
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
<td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">LOGISTICSPLANING</td>
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

$table_beginip04 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;font-size:12;">
<thead>
<tr style="border:1px solid #000;padding:4px;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>NO.</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>DATE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ROUTE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>QTY TRIP</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>Extra Truck</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Cost/Trip</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;"><b>TOTAL</b></td>
</tr>
</thead>
<tbody>';
$iip04 = 1;

$sql_seBillingip04 = "SELECT DISTINCT a.[VLINDATE] FROM [dbo].[LOGINVOICE] a 
WHERE a.INVOICECODE='" . $_GET['invoicecode'] . "' AND TRANSPORTATION='STM(F.1)->STM(F.2) (IP04)' AND (DATENAME(DW,a.VLINDATE) != 'Sunday')";
$params_seBillingip04 = array();
$query_seBillingip04 = sqlsrv_query($conn, $sql_seBillingip04, $params_seBillingip04);
while ($result_seBillingip04 = sqlsrv_fetch_array($query_seBillingip04, SQLSRV_FETCH_ASSOC)) {


    $mip04 = "";
    switch ((int) substr($result_seBillingip04['VLINDATE'], 5, 2)) {
        case '1': {
                $mip04 = "Jan";
            }
            break;
        case '2': {
                $mip04 = "Feb";
            }
            break;
        case '3': {
                $mip04 = "Mar";
            }
            break;
        case '4': {
                $mip04 = "Apr";
            }
            break;
        case '5': {
                $mip04 = "May";
            }
            break;
        case '6': {
                $mip04 = "Jun";
            }
            break;
        case '7': {
                $mip04 = "Jul";
            }
            break;
        case '8': {
                $mip04 = "Aug";
            }
            break;
        case '9': {
                $mip04 = "Sep";
            }
            break;
        case '10': {
                $mip04 = "Oct";
            }
            break;
        case '11': {
                $mip04 = "Nov";
            }
            break;
        default : {
                $mip04 = "Dec";
            }
            break;
    }
    $dip04 = substr($result_seBillingip04['VLINDATE'], 8, 2);
    $yip04 = substr($result_seBillingip04['VLINDATE'], 0, 4);

    $dmyip04 = $dip04 . "-" . $mip04 . "-" . $yip04;



    $sql_seTripamountip04 = "SELECT SUM(CAST(LEFT(b.ROUNDAMOUNT,PATINDEX('%[^0-9]%',b.ROUNDAMOUNT)-1) AS int)) AS 'SUMTRIPSTM'
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
            WHERE 1 = 1
            AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seBillingip04['VLINDATE'] . "',111) AND CONVERT(DATE,'" . $result_seBillingip04['VLINDATE'] . "',111)
            AND b.COMPANYCODE = 'RKS' AND b.CUSTOMERCODE = 'STM'
            AND a.DOCUMENTCODE != '' AND b.JOBSTART='STM(F.1)->STM(F.2) (IP04)'
            AND (SUBSTRING(ROUNDAMOUNT, 3, 3) = 'D' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'D'
            OR SUBSTRING(ROUNDAMOUNT, 3, 3) = 'N' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'N' )  ";
    $query_seTripamountip04 = sqlsrv_query($conn, $sql_seTripamountip04, $params_seTripamountip04);
    $result_seTripamountip04 = sqlsrv_fetch_array($query_seTripamountip04, SQLSRV_FETCH_ASSOC);

    $sql_sePriceip04 = "SELECT TOP 1 PRICE FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE [VEHICLETYPE]='10W' AND [FROM]='STM(F.1)->STM(F.2) (IP04)' ORDER BY [CREATEDATE] DESC";
    $query_sePriceip04 = sqlsrv_query($conn, $sql_sePriceip04, $params_sePriceip04);
    $result_sePriceip04 = sqlsrv_fetch_array($query_sePriceip04, SQLSRV_FETCH_ASSOC);


    $tbodyip04 .= '
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $iip04 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $dmyip04 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">IP-04</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTripamountip04['SUMTRIPSTM'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_sePriceip04['PRICE'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seTripamountip04['SUMTRIPSTM'] * $result_sePriceip04['PRICE']) . '</td>

</tr>
    ';
    $sumqtyip04=$sumqtyip04+$result_seTripamountip04['SUMTRIPSTM'];
    $sumpriceip04=$sumpriceip04+($result_seTripamountip04['SUMTRIPSTM'] * $result_sePriceip04['PRICE']);
    $iip04++;
}



$tfootip04 = '</tbody>
<tfoot>


<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="2"><b>Total</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b>'.$sumqtyip04.'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b>'.number_format($sumpriceip04).'</td>

</tr>



<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="3"><b>Tarditional Holidays</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>

</tr>';
$iholip04 = 1;

$sql_seBillingholip04 = "SELECT DISTINCT a.[VLINDATE] FROM [dbo].[LOGINVOICE] a 
WHERE a.INVOICECODE='" . $_GET['invoicecode'] . "' AND TRANSPORTATION='STM(F.1)->STM(F.2) (IP04)' AND (DATENAME(DW,a.VLINDATE) = 'Sunday')";
$params_seBillingholip04 = array();
$query_seBillingholip04 = sqlsrv_query($conn, $sql_seBillingholip04, $params_seBillingholip04);
while ($result_seBillingholip04 = sqlsrv_fetch_array($query_seBillingholip04, SQLSRV_FETCH_ASSOC)) {


    $mholip04 = "";
    switch ((int) substr($result_seBillingholip04['VLINDATE'], 5, 2)) {
        case '1': {
                $mholip04 = "Jan";
            }
            break;
        case '2': {
                $mholip04 = "Feb";
            }
            break;
        case '3': {
                $mholip04 = "Mar";
            }
            break;
        case '4': {
                $mholip04 = "Apr";
            }
            break;
        case '5': {
                $mholip04 = "May";
            }
            break;
        case '6': {
                $mholip04 = "Jun";
            }
            break;
        case '7': {
                $mholip04 = "Jul";
            }
            break;
        case '8': {
                $mholip04 = "Aug";
            }
            break;
        case '9': {
                $mholip04 = "Sep";
            }
            break;
        case '10': {
                $mholip04 = "Oct";
            }
            break;
        case '11': {
                $mholip04 = "Nov";
            }
            break;
        default : {
                $mholip04 = "Dec";
            }
            break;
    }
    $dholip04 = substr($result_seBillingholip04['VLINDATE'], 8, 2);
    $yholip04 = substr($result_seBillingholip04['VLINDATE'], 0, 4);

    $dmyholip04 = $dholip04 . "-" . $mholip04 . "-" . $yholip04;



    $sql_seTripamountholip04 = "SELECT SUM(CAST(LEFT(b.ROUNDAMOUNT,PATINDEX('%[^0-9]%',b.ROUNDAMOUNT)-1) AS int)) AS 'SUMTRIPSTM'
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
            WHERE 1 = 1
            AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seBillingholip04['VLINDATE'] . "',111) AND CONVERT(DATE,'" . $result_seBillingholip04['VLINDATE'] . "',111)
            AND b.COMPANYCODE = 'RKS' AND b.CUSTOMERCODE = 'STM'
            AND a.DOCUMENTCODE != '' AND b.JOBSTART='STM(F.1)->STM(F.2) (IP04)'
            AND (SUBSTRING(ROUNDAMOUNT, 3, 3) = 'D' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'D'
            OR SUBSTRING(ROUNDAMOUNT, 3, 3) = 'N' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'N' )  ";
    $query_seTripamountholip04 = sqlsrv_query($conn, $sql_seTripamountholip04, $params_seTripamountholip04);
    $result_seTripamountholip04 = sqlsrv_fetch_array($query_seTripamountholip04, SQLSRV_FETCH_ASSOC);

    $sql_sePriceholip04 = "SELECT TOP 1 PRICE FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE [VEHICLETYPE]='10W' AND [FROM]='STM(F.1)->STM(F.2) (IP04)' ORDER BY [CREATEDATE] DESC";
    $query_sePriceholip04 = sqlsrv_query($conn, $sql_sePriceholip04, $params_sePriceholip04);
    $result_sePriceholip04 = sqlsrv_fetch_array($query_sePriceholip04, SQLSRV_FETCH_ASSOC);


    $tfootip04 .= '
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $iholip04 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $dmyholip04 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">IP-04</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTripamountholip04['SUMTRIPSTM'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_sePriceholip04['PRICE'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seTripamountholip04['SUMTRIPSTM'] * $result_sePriceholip04['PRICE']) . '</td>

</tr>
    ';
    $sumqtyholip04=$sumqtyholip04+$result_seTripamountholip04['SUMTRIPSTM'];
    $sumpriceholip04=$sumpriceholip04+($result_seTripamountholip04['SUMTRIPSTM'] * $result_sePriceholip04['PRICE']);
    $iholip04++;
}
$rsqtyip04=$sumqtyip04+$sumqtyholip04;
$rspriceip04=$sumpriceip04+$sumpriceholip04;
$tfootip04 .='<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="3"><b>Grand Total</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b>'.$rsqtyip04.'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>'.number_format($rspriceip04).'</b></td>

</tr>

</tfoot>
                                                 </table>
';

///////////////////////IP-05/////////////////////////////////////


$table_headerip05 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b>DETAILS FOR TRIPS OF STM (INTERPLANT) 10 Wheels</b></td>
</tr>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b><u>(MONTH</u> : ' . $month . ')</b></td>
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
<td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">LOGISTICSPLANING</td>
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

$table_beginip05 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;font-size:12;">
<thead>
<tr style="border:1px solid #000;padding:4px;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>NO.</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>DATE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ROUTE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>QTY TRIP</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>Extra Truck</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Cost/Trip</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;"><b>TOTAL</b></td>
</tr>
</thead>
<tbody>';
$iip05 = 1;

$sql_seBillingip05 = "SELECT DISTINCT a.[VLINDATE] FROM [dbo].[LOGINVOICE] a 
WHERE a.INVOICECODE='" . $_GET['invoicecode'] . "' AND TRANSPORTATION='STM(F.1)->STM(F.2) (IP05)' AND (DATENAME(DW,a.VLINDATE) != 'Sunday')";
$params_seBillingip05 = array();
$query_seBillingip05 = sqlsrv_query($conn, $sql_seBillingip05, $params_seBillingip05);
while ($result_seBillingip05 = sqlsrv_fetch_array($query_seBillingip05, SQLSRV_FETCH_ASSOC)) {


    $mip05 = "";
    switch ((int) substr($result_seBillingip05['VLINDATE'], 5, 2)) {
        case '1': {
                $mip05 = "Jan";
            }
            break;
        case '2': {
                $mip05 = "Feb";
            }
            break;
        case '3': {
                $mip05 = "Mar";
            }
            break;
        case '4': {
                $mip05 = "Apr";
            }
            break;
        case '5': {
                $mip05 = "May";
            }
            break;
        case '6': {
                $mip05 = "Jun";
            }
            break;
        case '7': {
                $mip05 = "Jul";
            }
            break;
        case '8': {
                $mip05 = "Aug";
            }
            break;
        case '9': {
                $mip05 = "Sep";
            }
            break;
        case '10': {
                $mip05 = "Oct";
            }
            break;
        case '11': {
                $mip05 = "Nov";
            }
            break;
        default : {
                $mip05 = "Dec";
            }
            break;
    }
    $dip05 = substr($result_seBillingip05['VLINDATE'], 8, 2);
    $yip05 = substr($result_seBillingip05['VLINDATE'], 0, 4);

    $dmyip05 = $dip05 . "-" . $mip05 . "-" . $yip05;



    $sql_seTripamountip05 = "SELECT SUM(CAST(LEFT(b.ROUNDAMOUNT,PATINDEX('%[^0-9]%',b.ROUNDAMOUNT)-1) AS int)) AS 'SUMTRIPSTM'
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
            WHERE 1 = 1
            AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seBillingip05['VLINDATE'] . "',111) AND CONVERT(DATE,'" . $result_seBillingip05['VLINDATE'] . "',111)
            AND b.COMPANYCODE = 'RKS' AND b.CUSTOMERCODE = 'STM'
            AND a.DOCUMENTCODE != '' AND b.JOBSTART='STM(F.1)->STM(F.2) (IP05)'
            AND (SUBSTRING(ROUNDAMOUNT, 3, 3) = 'D' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'D'
            OR SUBSTRING(ROUNDAMOUNT, 3, 3) = 'N' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'N' )  ";
    $query_seTripamountip05 = sqlsrv_query($conn, $sql_seTripamountip05, $params_seTripamountip05);
    $result_seTripamountip05 = sqlsrv_fetch_array($query_seTripamountip05, SQLSRV_FETCH_ASSOC);

    $sql_sePriceip05 = "SELECT TOP 1 PRICE FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE [VEHICLETYPE]='10W' AND [FROM]='STM(F.1)->STM(F.2) (IP05)' ORDER BY [CREATEDATE] DESC";
    $query_sePriceip05 = sqlsrv_query($conn, $sql_sePriceip05, $params_sePriceip05);
    $result_sePriceip05 = sqlsrv_fetch_array($query_sePriceip05, SQLSRV_FETCH_ASSOC);


    $tbodyip05 .= '
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $iip05 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $dmyip05 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">IP-05</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTripamountip05['SUMTRIPSTM'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_sePriceip05['PRICE'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seTripamountip05['SUMTRIPSTM'] * $result_sePriceip05['PRICE']) . '</td>

</tr>
    ';
    $sumqtyip05=$sumqtyip05+$result_seTripamountip05['SUMTRIPSTM'];
    $sumpriceip05=$sumpriceip05+($result_seTripamountip05['SUMTRIPSTM'] * $result_sePriceip05['PRICE']);
    $iip05++;
}



$tfootip05 = '</tbody>
<tfoot>


<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="2"><b>Total</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b>'.$sumqtyip05.'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b>'.number_format($sumpriceip05).'</td>

</tr>



<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="3"><b>Tarditional Holidays</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>

</tr>';
$iholip05 = 1;

$sql_seBillingholip05 = "SELECT DISTINCT a.[VLINDATE] FROM [dbo].[LOGINVOICE] a 
WHERE a.INVOICECODE='" . $_GET['invoicecode'] . "' AND TRANSPORTATION='STM(F.1)->STM(F.2) (IP05)' AND (DATENAME(DW,a.VLINDATE) = 'Sunday')";
$params_seBillingholip05 = array();
$query_seBillingholip05 = sqlsrv_query($conn, $sql_seBillingholip05, $params_seBillingholip05);
while ($result_seBillingholip05 = sqlsrv_fetch_array($query_seBillingholip05, SQLSRV_FETCH_ASSOC)) {


    $mholip05 = "";
    switch ((int) substr($result_seBillingholip05['VLINDATE'], 5, 2)) {
        case '1': {
                $mholip05 = "Jan";
            }
            break;
        case '2': {
                $mholip05 = "Feb";
            }
            break;
        case '3': {
                $mholip05 = "Mar";
            }
            break;
        case '4': {
                $mholip05 = "Apr";
            }
            break;
        case '5': {
                $mholip05 = "May";
            }
            break;
        case '6': {
                $mholip05 = "Jun";
            }
            break;
        case '7': {
                $mholip05 = "Jul";
            }
            break;
        case '8': {
                $mholip05 = "Aug";
            }
            break;
        case '9': {
                $mholip05 = "Sep";
            }
            break;
        case '10': {
                $mholip05 = "Oct";
            }
            break;
        case '11': {
                $mholip05 = "Nov";
            }
            break;
        default : {
                $mholip05 = "Dec";
            }
            break;
    }
    $dholip05 = substr($result_seBillingholip05['VLINDATE'], 8, 2);
    $yholip05 = substr($result_seBillingholip05['VLINDATE'], 0, 4);

    $dmyholip05 = $dholip05 . "-" . $mholip05 . "-" . $yholip05;



    $sql_seTripamountholip05 = "SELECT SUM(CAST(LEFT(b.ROUNDAMOUNT,PATINDEX('%[^0-9]%',b.ROUNDAMOUNT)-1) AS int)) AS 'SUMTRIPSTM'
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
            WHERE 1 = 1
            AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seBillingholip05['VLINDATE'] . "',111) AND CONVERT(DATE,'" . $result_seBillingholip05['VLINDATE'] . "',111)
            AND b.COMPANYCODE = 'RKS' AND b.CUSTOMERCODE = 'STM'
            AND a.DOCUMENTCODE != '' AND b.JOBSTART='STM(F.1)->STM(F.2) (IP05)'
            AND (SUBSTRING(ROUNDAMOUNT, 3, 3) = 'D' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'D'
            OR SUBSTRING(ROUNDAMOUNT, 3, 3) = 'N' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'N' )  ";
    $query_seTripamountholip05 = sqlsrv_query($conn, $sql_seTripamountholip05, $params_seTripamountholip05);
    $result_seTripamountholip05 = sqlsrv_fetch_array($query_seTripamountholip05, SQLSRV_FETCH_ASSOC);

    $sql_sePriceholip05 = "SELECT TOP 1 PRICE FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE [VEHICLETYPE]='10W' AND [FROM]='STM(F.1)->STM(F.2) (IP05)' ORDER BY [CREATEDATE] DESC";
    $query_sePriceholip05 = sqlsrv_query($conn, $sql_sePriceholip05, $params_sePriceholip05);
    $result_sePriceholip05 = sqlsrv_fetch_array($query_sePriceholip05, SQLSRV_FETCH_ASSOC);


    $tfootip05 .= '
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $iholip05 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $dmyholip05 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">IP-05</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTripamountholip05['SUMTRIPSTM'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_sePriceholip05['PRICE'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seTripamountholip05['SUMTRIPSTM'] * $result_sePriceholip05['PRICE']) . '</td>

</tr>
    ';
    $sumqtyholip05=$sumqtyholip05+$result_seTripamountholip05['SUMTRIPSTM'];
    $sumpriceholip05=$sumpriceholip05+($result_seTripamountholip05['SUMTRIPSTM'] * $result_sePriceholip05['PRICE']);
    $iholip05++;
}
$rsqtyip05=$sumqtyip05+$sumqtyholip05;
$rspriceip05=$sumpriceip05+$sumpriceholip05;
$tfootip05 .='<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="3"><b>Grand Total</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b>'.$rsqtyip05.'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>'.number_format($rspriceip05).'</b></td>

</tr>

</tfoot>
                                                 </table>
';

/////////////////////////////IP-06///////////////////////////////


$table_headerip06 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b>DETAILS FOR TRIPS OF STM (INTERPLANT) 10 Wheels</b></td>
</tr>
<tr style="border:1px solid #000;padding:4px;" >
<td align="center"><b><u>(MONTH</u> : ' . $month . ')</b></td>
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
<td style="border-right:1px solid #000;padding:4px;text-align:center;" colspan="2">LOGISTICSPLANING</td>
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

$table_beginip06 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;font-size:12;">
<thead>
<tr style="border:1px solid #000;padding:4px;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>NO.</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>DATE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ROUTE</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>QTY TRIP</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>Extra Truck</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Cost/Trip</b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;"><b>TOTAL</b></td>
</tr>
</thead>
<tbody>';
$iip06 = 1;

$sql_seBillingip06 = "SELECT DISTINCT a.[VLINDATE] FROM [dbo].[LOGINVOICE] a 
WHERE a.INVOICECODE='" . $_GET['invoicecode'] . "' AND TRANSPORTATION='STM(F.1)->STM(F.2) (IP06)' AND (DATENAME(DW,a.VLINDATE) != 'Sunday')";
$params_seBillingip06 = array();
$query_seBillingip06 = sqlsrv_query($conn, $sql_seBillingip06, $params_seBillingip06);
while ($result_seBillingip06 = sqlsrv_fetch_array($query_seBillingip06, SQLSRV_FETCH_ASSOC)) {


    $mip06 = "";
    switch ((int) substr($result_seBillingip06['VLINDATE'], 5, 2)) {
        case '1': {
                $mip06 = "Jan";
            }
            break;
        case '2': {
                $mip06 = "Feb";
            }
            break;
        case '3': {
                $mip06 = "Mar";
            }
            break;
        case '4': {
                $mip06 = "Apr";
            }
            break;
        case '5': {
                $mip06 = "May";
            }
            break;
        case '6': {
                $mip06 = "Jun";
            }
            break;
        case '7': {
                $mip06 = "Jul";
            }
            break;
        case '8': {
                $mip06 = "Aug";
            }
            break;
        case '9': {
                $mip06 = "Sep";
            }
            break;
        case '10': {
                $mip06 = "Oct";
            }
            break;
        case '11': {
                $mip06 = "Nov";
            }
            break;
        default : {
                $mip06 = "Dec";
            }
            break;
    }
    $dip06 = substr($result_seBillingip06['VLINDATE'], 8, 2);
    $yip06 = substr($result_seBillingip06['VLINDATE'], 0, 4);

    $dmyip06 = $dip06 . "-" . $mip06 . "-" . $yip06;



    $sql_seTripamountip06 = "SELECT SUM(CAST(LEFT(b.ROUNDAMOUNT,PATINDEX('%[^0-9]%',b.ROUNDAMOUNT)-1) AS int)) AS 'SUMTRIPSTM'
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
            WHERE 1 = 1
            AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seBillingip06['VLINDATE'] . "',111) AND CONVERT(DATE,'" . $result_seBillingip06['VLINDATE'] . "',111)
            AND b.COMPANYCODE = 'RKS' AND b.CUSTOMERCODE = 'STM'
            AND a.DOCUMENTCODE != '' AND b.JOBSTART='STM(F.1)->STM(F.2) (IP06)'
            AND (SUBSTRING(ROUNDAMOUNT, 3, 3) = 'D' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'D'
            OR SUBSTRING(ROUNDAMOUNT, 3, 3) = 'N' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'N' )  ";
    $query_seTripamountip06 = sqlsrv_query($conn, $sql_seTripamountip06, $params_seTripamountip06);
    $result_seTripamountip06 = sqlsrv_fetch_array($query_seTripamountip06, SQLSRV_FETCH_ASSOC);

    $sql_sePriceip06 = "SELECT TOP 1 PRICE FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE [VEHICLETYPE]='10W' AND [FROM]='STM(F.1)->STM(F.2) (IP06)' ORDER BY [CREATEDATE] DESC";
    $query_sePriceip06 = sqlsrv_query($conn, $sql_sePriceip06, $params_sePriceip06);
    $result_sePriceip06 = sqlsrv_fetch_array($query_sePriceip06, SQLSRV_FETCH_ASSOC);


    $tbodyip06 .= '
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $iip06 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $dmyip06 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">IP-06</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTripamountip06['SUMTRIPSTM'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_sePriceip06['PRICE'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seTripamountip06['SUMTRIPSTM'] * $result_sePriceip06['PRICE']) . '</td>

</tr>
    ';
    $sumqtyip06=$sumqtyip06+$result_seTripamountip06['SUMTRIPSTM'];
    $sumpriceip06=$sumpriceip06+($result_seTripamountip06['SUMTRIPSTM'] * $result_sePriceip06['PRICE']);
    $iip06++;
}



$tfootip06 = '</tbody>
<tfoot>


<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="2"><b>Total</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b>'.$sumqtyip06.'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b>'.number_format($sumpriceip06).'</td>

</tr>



<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="3"><b>Tarditional Holidays</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>

</tr>';
$iholip06 = 1;

$sql_seBillingholip06 = "SELECT DISTINCT a.[VLINDATE] FROM [dbo].[LOGINVOICE] a 
WHERE a.INVOICECODE='" . $_GET['invoicecode'] . "' AND TRANSPORTATION='STM(F.1)->STM(F.2) (IP06)' AND (DATENAME(DW,a.VLINDATE) = 'Sunday')";
$params_seBillingholip06 = array();
$query_seBillingholip06 = sqlsrv_query($conn, $sql_seBillingholip06, $params_seBillingholip06);
while ($result_seBillingholip06 = sqlsrv_fetch_array($query_seBillingholip06, SQLSRV_FETCH_ASSOC)) {


    $mholip06 = "";
    switch ((int) substr($result_seBillingholip06['VLINDATE'], 5, 2)) {
        case '1': {
                $mholip06 = "Jan";
            }
            break;
        case '2': {
                $mholip06 = "Feb";
            }
            break;
        case '3': {
                $mholip06 = "Mar";
            }
            break;
        case '4': {
                $mholip06 = "Apr";
            }
            break;
        case '5': {
                $mholip06 = "May";
            }
            break;
        case '6': {
                $mholip06 = "Jun";
            }
            break;
        case '7': {
                $mholip06 = "Jul";
            }
            break;
        case '8': {
                $mholip06 = "Aug";
            }
            break;
        case '9': {
                $mholip06 = "Sep";
            }
            break;
        case '10': {
                $mholip06 = "Oct";
            }
            break;
        case '11': {
                $mholip06 = "Nov";
            }
            break;
        default : {
                $mholip06 = "Dec";
            }
            break;
    }
    $dholip06 = substr($result_seBillingholip06['VLINDATE'], 8, 2);
    $yholip06 = substr($result_seBillingholip06['VLINDATE'], 0, 4);

    $dmyholip06 = $dholip06 . "-" . $mholip06 . "-" . $yholip06;



    $sql_seTripamountholip06 = "SELECT SUM(CAST(LEFT(b.ROUNDAMOUNT,PATINDEX('%[^0-9]%',b.ROUNDAMOUNT)-1) AS int)) AS 'SUMTRIPSTM'
            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
            WHERE 1 = 1
            AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seBillingholip06['VLINDATE'] . "',111) AND CONVERT(DATE,'" . $result_seBillingholip06['VLINDATE'] . "',111)
            AND b.COMPANYCODE = 'RKS' AND b.CUSTOMERCODE = 'STM'
            AND a.DOCUMENTCODE != '' AND b.JOBSTART='STM(F.1)->STM(F.2) (IP06)'
            AND (SUBSTRING(ROUNDAMOUNT, 3, 3) = 'D' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'D'
            OR SUBSTRING(ROUNDAMOUNT, 3, 3) = 'N' OR SUBSTRING(ROUNDAMOUNT, 2, 2) = 'N' )  ";
    $query_seTripamountholip06 = sqlsrv_query($conn, $sql_seTripamountholip06, $params_seTripamountholip06);
    $result_seTripamountholip06 = sqlsrv_fetch_array($query_seTripamountholip06, SQLSRV_FETCH_ASSOC);

    $sql_sePriceholip06 = "SELECT TOP 1 PRICE FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE [VEHICLETYPE]='10W' AND [FROM]='STM(F.1)->STM(F.2) (IP06)' ORDER BY [CREATEDATE] DESC";
    $query_sePriceholip06 = sqlsrv_query($conn, $sql_sePriceholip06, $params_sePriceholip06);
    $result_sePriceholip06 = sqlsrv_fetch_array($query_sePriceholip06, SQLSRV_FETCH_ASSOC);


    $tfootip06 .= '
    <tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $iholip06 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $dmyholip06 . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">IP-06</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seTripamountholip06['SUMTRIPSTM'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_sePriceholip06['PRICE'] . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;">' . number_format($result_seTripamountholip06['SUMTRIPSTM'] * $result_sePriceholip06['PRICE']) . '</td>

</tr>
    ';
    $sumqtyholip06=$sumqtyholip06+$result_seTripamountholip06['SUMTRIPSTM'];
    $sumpriceholip06=$sumpriceholip06+($result_seTripamountholip06['SUMTRIPSTM'] * $result_sePriceholip06['PRICE']);
    $iholip06++;
}
$rsqtyip06=$sumqtyip06+$sumqtyholip06;
$rspriceip06=$sumpriceip06+$sumpriceholip06;
$tfootip06 .='<tr style="border:1px solid #000;">
    <td style="border-right:1px solid #000;padding:4px;text-align:left;" colspan="3"><b>Grand Total</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b>'.$rsqtyip06.'</td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b></b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>'.number_format($rspriceip06).'</b></td>

</tr>

</tfoot>
                                                 </table>
';


$mpdf->WriteHTML($style);

$mpdf->WriteHTML($table_headerip01);
$mpdf->WriteHTML($table_beginip01);
$mpdf->WriteHTML($tbodyip01);
$mpdf->WriteHTML($tfootip01);
$mpdf->AddPage();
$mpdf->WriteHTML($table_headerip02);
$mpdf->WriteHTML($table_beginip02);
$mpdf->WriteHTML($tbodyip02);
$mpdf->WriteHTML($tfootip02);
$mpdf->AddPage();
$mpdf->WriteHTML($table_headerip03);
$mpdf->WriteHTML($table_beginip03);
$mpdf->WriteHTML($tbodyip03);
$mpdf->WriteHTML($tfootip03);
$mpdf->AddPage();
$mpdf->WriteHTML($table_headerip04);
$mpdf->WriteHTML($table_beginip04);
$mpdf->WriteHTML($tbodyip04);
$mpdf->WriteHTML($tfootip04);
$mpdf->AddPage();
$mpdf->WriteHTML($table_headerip05);
$mpdf->WriteHTML($table_beginip05);
$mpdf->WriteHTML($tbodyip05);
$mpdf->WriteHTML($tfootip05);
$mpdf->AddPage();
$mpdf->WriteHTML($table_headerip06);
$mpdf->WriteHTML($table_beginip06);
$mpdf->WriteHTML($tbodyip06);
$mpdf->WriteHTML($tfootip06);
$mpdf->Output();
sqlsrv_close($conn);
?>
