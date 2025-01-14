<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
require_once("../class/meg_function.php");
date_default_timezone_set('UTC');
// require_once("../mpdf/autoload.php");
$conn = connect("RTMS");

// $sumgmtweight = "";
$sumcusweight = "";
// $sumamounttrip = "";
$sumtotal = "";
$ACTUALPRICE = "";


$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,INVOICECODE,COMPANYCODE,CUSTOMERCODE,TRANSPORTATION,JOBEND,MATERIALTYPE,DULYDATE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '" . $_GET['invoicecode'] . "'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);



// $condBilling1 = " AND c.COMPANYCODE = '" . $result_seInvoicecode['COMPANYCODE'] . "' AND c.CUSTOMERCODE = '" . $result_seInvoicecode['CUSTOMERCODE'] . "' AND b.JOBSTART='" . $result_seInvoicecode['TRANSPORTATION'] . "' AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
// $condBilling2 = " AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seInvoicecode['BILLINGDATE'] . "',103) AND CONVERT(DATE,'" . $result_seInvoicecode['PAYMENTDATE'] . "',103) AND b.JOBEND = '" . $result_seInvoicecode['JOBEND'] . "'";

if ($_GET['invoicecode'] == "" || $_GET['invoicecode'] == "") {
    $strExcelFileName = "RRCTTAST_Billing.xls";
} else {
    $strExcelFileName = "RRCTTAST_Billing(" . $_GET['invoicecode'] . ").xls";
}

    header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
    header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
    header("Pragma:no-cache");

?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<?php

///////////////////งานเหมา //////////////////////////////////////////
if ($result_seInvoicecode['TRANSPORTATION'] == 'TTAST' && ($result_seInvoicecode['JOBEND'] == 'TTAST' || $result_seInvoicecode['JOBEND'] == 'Move Coil' )) {
    ?>
    <style>
        table{
            font-family: "Angsana New";
            font-size:23px;
        }
    </style>
    <table style="width: 100%;font-size:23px">
        <thead>
            <tr>
                <td colspan="12" style="text-align:center"><b><font style="">ใบส่งสินค้า</font></b></td>
        </thead>
        <tbody>
            <tr>
                <td colspan="12">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด (RUAMKIT RECYCLE CARRIER CO.,LTD.)</td>
            </tr>
            <tr>
                <td colspan="12">สำนักงานใหญ่ 109/1 หมู่ที่ 9 ตำบลหัวสำโรง อำเภอแปลงยาว จังหวัดฉะเชิงเทรา</td>
            </tr>
            <tr>
                <td colspan="12" style="width: 50%;">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="8" style="width: 50%;">เลขประจำตัวผู้เสียภาษี 0105551065951</td>
                <td colspan="4" style="width: 50%;text-align:right">เลขที่ <?= $_GET['invoicecode'] ?></td>
            </tr>
            <tr>
                <td colspan="12" style="width: 50%;">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="8" style="width: 50%;">ลูกค้า บริษัท ทีที ออโตโมทีฟ สตีล (ไทยแลนด์) จำกัด</td>
                <td colspan="4" style="width: 50%;text-align:right">วันที่ <?= $result_seInvoicecode['DULYDATE'] ?></td>
            </tr>
            <tr>
                <td colspan="12" style="width: 50%;">ที่อยู่ 256 หมู่ที่ 7 นิคมอุตสาหกรรมเกตเวย์ซิตี้ ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190</td>
            </tr>
        </tbody>
    </table>

    <table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;font-size:23px">
        <thead>
            <tr style="border:1px solid #000;">
                <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;"><b>ลำดับ</th>
                <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 7%;">วันที่</th>
                <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 13%;">หมายเลข DO</th>
                <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 8%;">ทะเบียนรถ</th>
                <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 8%;">พนักงาน</th>
                <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 8%;">จาก</th>
                <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 8%;">ถึง</th>
                <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 9%;">จำนวน<br>แพ็ค/เที่ยว</th>
                <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 9%;">น้ำหนัก<br>รวม/เที่ยว</th>
                <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;">QT.</th>
                <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">หน่วยละ</th>
                <th style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">จำนวนเงิน(บาท)</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $i = 1;

            $sql_seBilling = "SELECT CONVERT(NVARCHAR(6),CONVERT(DATE,b.DATEVLHEAD,103),3)+''+RIGHT(CONVERT(NVARCHAR(4),CONVERT(DATE,b.DATEVLHEAD,103))+543,2) AS 'DATE_VLIN',
                CONVERT(VARCHAR, c.DATEVLIN, 105) AS 'DATE_VLIN2',b.DOCUMENTCODE AS 'DOCUMENTCODE',
                b.VEHICLEREGISNUMBERHEAD AS 'VEHICLEREGISNUMBER',b.EMPLOYEENAME1, b.EMPLOYEECODE1
                ,b.JOBSTART AS 'JOBSTART',b.JOBEND AS 'JOBEND',b.TRIPAMOUNT,b.WEIGHTIN,
                b.WEIGHTOUT,c.ACTUALPRICE AS 'ACTUALPRICE',c.C8
                FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b
                INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
                INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID]
                WHERE b.ACTIVESTATUS = '1'
                AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103)

                AND b.COMPANYCODE = '".$result_seInvoicecode['COMPANYCODE']."' AND b.CUSTOMERCODE = '".$result_seInvoicecode['CUSTOMERCODE']."'
                AND c.JOBSTART = 'TTAST' AND c.JOBEND IN('TTAST','Move Coil') AND b.DOCUMENTCODE != ''
                ORDER BY c.DATEVLIN ASC";
            $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
            while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

                // $sql_seVehicleregisnumber = "SELECT VEHICLEREGISNUMBER FROM [dbo].[VEHICLEINFO]
                //     WHERE SUBSTRING(THAINAME,0,7) = SUBSTRING((SELECT DISTINCT SUBSTRING(THAINAME, 0, 7) FROM [dbo].[VEHICLEINFO] WHERE VEHICLEREGISNUMBER = '" . $result_seBilling['VEHICLEREGISNUMBER'] . "'), 0, 7)
                //     AND (VEHICLETYPECODE = '10W' OR VEHICLETYPECODE = 'Semi Trailer' OR VEHICLETYPECODE = 'Trailer' OR VEHICLETYPECODE = 'Semitrailer' OR VEHICLETYPECODE = '10W(TTAST)')";
                // $query_seVehicleregisnumber = sqlsrv_query($conn, $sql_seVehicleregisnumber, $params_seVehicleregisnumber);
                // $result_seVehicleregisnumber = sqlsrv_fetch_array($query_seVehicleregisnumber, SQLSRV_FETCH_ASSOC);

                // $sql_seDo = "SELECT COUNT(*) AS 'rs' FROM [VEHICLETRANSPORTDOCUMENTDIRVER] a
                //     INNER JOIN [VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                //     WHERE b.JOBNO = '" . $result_seBilling['JOBNO'] . "'";
                // $query_seDo = sqlsrv_query($conn, $sql_seDo, $params_seDo);
                // $result_seDo = sqlsrv_fetch_array($query_seDo, SQLSRV_FETCH_ASSOC);

                // $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                // $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                // $params_seEmployeeehr = array(
                //     array('select_employeeehr2', SQLSRV_PARAM_IN),
                //     array($condEmployeeehr1, SQLSRV_PARAM_IN)
                // );
                // $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                // $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);

                $employeename  = $result_seBilling['EMPLOYEENAME1'];
                $employeenamesplit = explode(" ", $employeename);

                if ($result_seBilling['C8'] =='return') {
                    $JOBSTART = $result_seBilling['JOBEND'];
                    $JOBEND   = $result_seBilling['JOBSTART'];
                }else {
                    $JOBSTART = $result_seBilling['JOBSTART'];
                    $JOBEND   = $result_seBilling['JOBEND'];
                }

                ?>
                <tr style="border:1px solid #000;font-size:23px">
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $i ?></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling['DATE_VLIN2'] ?></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling['VEHICLEREGISNUMBER'] ?></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $employeenamesplit[0] ?></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $JOBSTART ?></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $JOBEND ?></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling['TRIPAMOUNT'] ?></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= number_format($result_seBilling['WEIGHTIN']) ?></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;">1.00</td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                </tr>
                <?php
                $i++;
                $sumtrip = $sumtrip + $result_seBilling['TRIPAMOUNT'];
                $sunweight = $sunweight + $result_seBilling['WEIGHTIN'];
                $sumtotal = (int) $result_seBilling['ACTUALPRICE'];
            }
            ?>
        </tbody> 
        <tfoot>
            <tr style="border:1px solid #000;font-size:23px">
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>รวม</b></td>
                <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $sumtrip ?></td>
                <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= number_format($sunweight, 0) ?></td>
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
            </tr>
            <tr style="border:1px solid #000;font-size:23px">
                <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ยอดสุทธิ</b></td>
                <td colspan="9" style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= convert($sumtotal) ?></b></td>
                <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= number_format($sumtotal, 0) ?></b></td>
            </tr>
        </tfoot>
    </table>
    <br><br><br><br>
    <table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;font-size:23px">
        <tbody>
            <tr>
                <td colspan="6" style="text-align:center;font-size:20px">........................................ </td>
                <td colspan="6" style="text-align:center;font-size:20px">........................................</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align:center;font-size:20px">ผู้จัดทำ</td>
                <td colspan="6" style="text-align:center;font-size:20px">ผู้ตรวจสอบ</td>
            </tr>
            <tr>
                <td colspan="12">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="12">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align:center;font-size:20px">........................................ </td>
                <td colspan="6" style="text-align:center;font-size:20px">........................................</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align:center;font-size:20px">ผู้อนุมัติ</td>
                <td colspan="6" style="text-align:center;font-size:20px">ผู้อนุมัติ</td>
            </tr>
        </tbody>      
    </table>
    <?php
} else {
    ?>
    <style>
        table{
            font-family: "Angsana New";
            font-size:23px;
        }
    </style>
    <table style="width: 100%;font-size:23px">
        <thead>
            <tr>
                <td colspan="12" style="text-align:center;"><b><font style="">ใบส่งสินค้า</font></b></td>
        </thead>
        <tbody>
            <tr>
                <td colspan="12">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด (RUAMKIT RECYCLE CARRIER CO.,LTD.)</td>
            </tr>
            <tr>
                <td colspan="12">สำนักงานใหญ่ 109/1 หมู่ที่ 9 ตำบลหัวสำโรง อำเภอแปลงยาว จังหวัดฉะเชิงเทรา</td>
            </tr>
            <tr>
                <td colspan="2" style="width: 50%;">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="8" style="width: 50%;">เลขประจำตัวผู้เสียภาษี 0105551065951</td>
                <td colspan="4" style="width: 50%;text-align:right">เลขที่ <?= $_GET['invoicecode'] ?></td>
            </tr>
            <tr>
                <td colspan="12" style="width: 50%;">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="8" style="width: 50%;">ลูกค้า บริษัท ทีที ออโตโมทีฟ สตีล (ไทยแลนด์) จำกัด</td>
                <td colspan="4" style="width: 50%;text-align:right">วันที่ <?= $result_seInvoicecode['DULYDATE'] ?></td>
            </tr>
            <tr>
                <td colspan="12" style="width: 50%;">ที่อยู่ 256 หมู่ที่ 7 นิคมอุตสาหกรรมเกตเวย์ซิตี้ ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190</td>
            </tr>
        </tbody>
    </table>

    <table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px">
        <thead>
            <tr style="border:1px groove #000;">
                <th style="border-right:1px groove #000;padding:4px;text-align:center;width: 5%;"><b>ลำดับ</th>
                <th style="border-right:1px groove #000;padding:4px;text-align:center;width: 7%;">วันที่</th>
                <th style="border-right:1px groove #000;padding:4px;text-align:center;width: 13%;">หมายเลข DO</th>
                <th style="border-right:1px groove #000;padding:4px;text-align:center;width: 8%;">ทะเบียนรถ</th>
                <th style="border-right:1px groove #000;padding:4px;text-align:center;width: 8%;">พนักงาน</th>
                <th style="border-right:1px groove #000;padding:4px;text-align:center;width: 8%;">จาก</th>
                <th style="border-right:1px groove #000;padding:4px;text-align:center;width: 8%;">ถึง</th>
                <th style="border-right:1px groove #000;padding:4px;text-align:center;width: 9%;">จำนวน<br>แพ็ค/เที่ยว</th>
                <th style="border-right:1px groove #000;padding:4px;text-align:center;width: 9%;">น้ำหนัก<br>รวม/เที่ยว</th>
                <th style="border-right:1px groove #000;padding:4px;text-align:center;width: 5%;">QT.</th>
                <th style="border-right:1px groove #000;padding:4px;text-align:center;width: 10%;">หน่วยละ</th>
                <th style="border-right:1px groove #000;padding:4px;text-align:center;width: 10%;">จำนวนเงิน(บาท)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;

            $sql_seBilling = "SELECT DISTINCT b.JOBNO,CONVERT(NVARCHAR(6),CONVERT(DATE,b.DATEVLIN,103),3)+''+RIGHT(CONVERT(NVARCHAR(4),CONVERT(DATE,b.DATEVLIN,103))+543,2) AS 'DATE_VLIN',
                    CONVERT(VARCHAR, b.DATEVLIN, 105) AS 'DATE_VLIN2',
                    a.VEHICLEREGISNUMBER AS 'VEHICLEREGISNUMBER',a.JOBSTART AS 'JOBSTART', a.JOBEND AS 'JOBEND',b.ACTUALPRICE AS 'ACTUALPRICE',b.C8,
                    CASE
                        WHEN b.C8 = 'return' THEN CAST((b.ACTUALPRICE*40) AS FLOAT) / CAST(100 AS FLOAT)
                        ELSE b.ACTUALPRICE
                        END AS 'ACTUALPRICE_WITH_RETURN'
                    FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                    WHERE b.ACTIVESTATUS = '1'
                    AND b.COMPANYCODE = '" . $result_seInvoicecode['COMPANYCODE'] . "'
                    AND b.CUSTOMERCODE = '" . $result_seInvoicecode['CUSTOMERCODE'] . "' 
                    AND b.JOBSTART='" . $result_seInvoicecode['TRANSPORTATION'] . "'
                    AND b.JOBEND = '".$result_seInvoicecode['JOBEND']."'
                    AND  (a.DOCUMENTCODE != '' OR a.DOCUMENTCODE IS NOT NULL)
                    AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seInvoicecode['BILLINGDATE'] . "',103)
                    AND CONVERT(DATE,'" . $result_seInvoicecode['PAYMENTDATE'] . "',103)
                    ORDER BY DATE_VLIN,b.JOBNO ASC";
            $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
            while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {



                // $sql_seVehicleregisnumber = "SELECT VEHICLEREGISNUMBER FROM [dbo].[VEHICLEINFO]
                //     WHERE SUBSTRING(THAINAME,0,7) = SUBSTRING((SELECT DISTINCT SUBSTRING(THAINAME, 0, 7) FROM [dbo].[VEHICLEINFO] WHERE VEHICLEREGISNUMBER = '" . $result_seBilling['VEHICLEREGISNUMBER'] . "'), 0, 7)
                //     AND (VEHICLETYPECODE = '10W' OR VEHICLETYPECODE = 'Semi Trailer' OR VEHICLETYPECODE = 'Trailer' OR VEHICLETYPECODE = 'Semitrailer' OR VEHICLETYPECODE = '10W(TTAST)')";
                // $query_seVehicleregisnumber = sqlsrv_query($conn, $sql_seVehicleregisnumber, $params_seVehicleregisnumber);
                // $result_seVehicleregisnumber = sqlsrv_fetch_array($query_seVehicleregisnumber, SQLSRV_FETCH_ASSOC);

                // $sql_seDo = "SELECT COUNT(*) AS 'rs' FROM [VEHICLETRANSPORTDOCUMENTDIRVER] a
                //     INNER JOIN [VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                //     WHERE b.JOBNO = '" . $result_seBilling['JOBNO'] . "'";
                // $query_seDo = sqlsrv_query($conn, $sql_seDo, $params_seDo);
                // $result_seDo = sqlsrv_fetch_array($query_seDo, SQLSRV_FETCH_ASSOC);

                // $ACTUALPRICE = ($result_seBilling['ACTUALPRICE'] != "") ? number_format($result_seBilling['ACTUALPRICE']) : "";

                if ($result_seBilling['C8'] == 'return') {
                    $ACTUALPRICE = number_format($result_seBilling['ACTUALPRICE_WITH_RETURN'],2);
                    $JOBSTART    = $result_seBilling['JOBEND'];
                    $JOBEND      = $result_seBilling['JOBSTART'];
                }else{
                    $ACTUALPRICE = ($result_seBilling['ACTUALPRICE_WITH_RETURN'] != "") ? number_format($result_seBilling['ACTUALPRICE_WITH_RETURN']) : "";
                    $JOBSTART    = $result_seBilling['JOBSTART'];
                    $JOBEND      = $result_seBilling['JOBEND'];
                }

                ?>
                <tr style="border:1px groove #000;font-size:23px">
                    <td style="border-right:1px groove #000;padding:4px;text-align:center;vertical-align: middle;"><?= $i ?></td>
                    <td style="border-right:1px groove #000;padding:4px;text-align:center;vertical-align: middle;"><?= $result_seBilling['DATE_VLIN2'] ?></td>

                    <!-- DOCUMENTCODE -->
                    <td style="border-right:1px groove #000;padding:4px;text-align:center;">
                        <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:23px;">
                            <?php
                            $sql_seBilling2 = "SELECT b.DOCUMENTCODE
                                FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b 
                                INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
                                WHERE b.ACTIVESTATUS = '1'
                                AND c.JOBNO = '" . $result_seBilling['JOBNO'] . "'
                                ORDER BY b.DOCUMENTCODE,b.[VEHICLETRANSPORTDOCUMENTDRIVERID] ASC";
                            $query_seBilling2 = sqlsrv_query($conn, $sql_seBilling2, $params_seBilling2);
                            while ($result_seBilling2 = sqlsrv_fetch_array($query_seBilling2, SQLSRV_FETCH_ASSOC)) {
                                ?>
                                <tr><td style="border:1px groove #000;padding:4px;text-align:center;vertical-align: middle;"><?= $result_seBilling2['DOCUMENTCODE'] ?></td></tr>
                                <?php
                            }
                            ?>
                        </table>
                    </td>

                    <!-- VEHICLEREGISNUMBER -->
                    <td style="border-right:1px groove #000;padding:4px;text-align:center;vertical-align: middle;" ><?= $result_seBilling['VEHICLEREGISNUMBER'] ?></td>
                    
                    <!-- EMPLOYEENAME1 -->
                    <td style="border-right:1px groove #000;padding:4px;text-align:center;vertical-align: middle;">
                        <!-- <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;"> -->
                            <?php
                            $sql_seBilling3 = "SELECT DISTINCT b.EMPLOYEENAME1
                                FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b 
                                INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
                                WHERE b.ACTIVESTATUS = '1'
                                AND c.JOBNO = '" . $result_seBilling['JOBNO'] . "'";
                            $query_seBilling3 = sqlsrv_query($conn, $sql_seBilling3, $params_seBilling3);
                            while ($result_seBilling3 = sqlsrv_fetch_array($query_seBilling3, SQLSRV_FETCH_ASSOC)) {

                                $employeename  = $result_seBilling3['EMPLOYEENAME1'];
                                $employeenamesplit = explode(" ", $employeename);

                                echo $employeenamesplit[0];
                                ?>
                                <!-- <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling3['EMPLOYEENAME1'] ?></td> -->
                                <?php
                            }
                            ?>
                        <!-- </table> -->
                    </td>

                    <!-- JOBSTART -->
                    <td style="border-right:1px groove #000;padding:4px;text-align:center;vertical-align: middle;"><?= $JOBSTART ?></td>
                    
                    <!-- JOBEND -->
                    <td style="border-right:1px groove #000;padding:4px;text-align:center;vertical-align: middle;"><?= $JOBEND ?></td>
                    
                    <!-- TRIPAMOUNT -->
                    <td style="border-right:1px groove #000;padding:4px;text-align:center;">
                        <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:23px;">
                            <?php
                            $sql_seBilling5 = "SELECT b.TRIPAMOUNT
                                FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b 
                                INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
                                WHERE b.ACTIVESTATUS = '1'
                                AND c.JOBNO = '" . $result_seBilling['JOBNO'] . "'
                                ORDER BY b.DOCUMENTCODE,b.VEHICLETRANSPORTDOCUMENTDRIVERID ASC";
                            $query_seBilling5 = sqlsrv_query($conn, $sql_seBilling5, $params_seBilling5);
                            while ($result_seBilling5 = sqlsrv_fetch_array($query_seBilling5, SQLSRV_FETCH_ASSOC)) {
                                ?>
                                <tr><td style = "border:1px groove #000;padding:4px;text-align:center;vertical-align: middle;"><?= $result_seBilling5['TRIPAMOUNT'] ?></td></tr>
                                <?php
                                $sumamt = $sumamt + (int) $result_seBilling5['TRIPAMOUNT'];
                            }
                            ?>
                        </table>
                    </td>

                    <!-- WEIGHTOUT -->
                    <td style="border-right:1px groove #000;padding:4px;text-align:center;">
                        <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:23px;">
                            <?php
                            $sql_seBilling4 = "SELECT b.WEIGHTOUT
                                FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b 
                                INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
                                WHERE b.ACTIVESTATUS = '1'
                                AND c.JOBNO = '" . $result_seBilling['JOBNO'] . "'
                                ORDER BY b.DOCUMENTCODE,b.VEHICLETRANSPORTDOCUMENTDRIVERID ASC";
                            $query_seBilling4 = sqlsrv_query($conn, $sql_seBilling4, $params_seBilling4);
                            while ($result_seBilling4 = sqlsrv_fetch_array($query_seBilling4, SQLSRV_FETCH_ASSOC)) {
                                ?>
                                <tr><td style="border:1px groove #000;padding:4px;text-align:center;vertical-align: middle;"><?= $result_seBilling4['WEIGHTOUT'] ?></td></tr>
                                <?php
                                $sumcusweight = $sumcusweight + $result_seBilling4['WEIGHTOUT'];
                            }
                            ?>
                        </table>
                    </td>

                    <!-- QT 1 -->
                    <td style="border-right:1px groove #000;padding:4px;text-align:center;vertical-align: middle;">1</td>
                    
                    <!-- ACTUALPRICE -->
                    <td style="border-right:1px groove #000;padding:4px;text-align:center;vertical-align: middle;"><?= $ACTUALPRICE ?></td>
                    
                    <!-- ACTUALPRICE -->
                    <td style="border-right:1px groove #000;padding:4px;text-align:center;vertical-align: middle;"><?= $ACTUALPRICE ?></td>
                </tr>
                <?php
                $i++;
                // Sumtotal อันเดิม
                // $sumtotal = $sumtotal + (int) $result_seBilling['ACTUALPRICE'];

                $sumtotal = $sumtotal + $result_seBilling['ACTUALPRICE_WITH_RETURN'];
            }
            ?>
        </tbody> 
        <tfoot>
            <tr style="border:1px groove #000;font-size:23px">
                <td colspan="2" style="border-right:1px groove #000;padding:4px;text-align:center;"><b>รวม</b></td>
                <td colspan="5" style="border-right:1px groove #000;padding:4px;text-align:center;"></td>
                <td style="border-right:1px groove #000;padding:4px;text-align:center;"><?= $sumamt ?></td>
                <td style="border-right:1px groove #000;padding:4px;text-align:center;"><?= number_format($sumcusweight, 0) ?></td>
                <td colspan="2" style="border-right:1px groove #000;padding:4px;text-align:center;"></td>
                <td style="border-right:1px groove #000;padding:4px;text-align:center;"></td>
            </tr>
            <tr style="border:1px groove #000;font-size:23px">
                <td colspan="2" style="border-right:1px groove #000;padding:4px;text-align:center;"><b>ยอดสุทธิ</b></td>
                <td colspan="9" style="border-right:1px groove #000;padding:4px;text-align:center;"><b><?= convert($sumtotal) ?></b></td>
                <td style="border-right:1px groove #000;padding:4px;text-align:center;"><b><?= number_format($sumtotal, 2) ?></b></td>
            </tr>
        </tfoot>
    </table>

    <br><br><br><br>
    <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:23px;margin-top:8px;">
        <tbody>
            <tr>
                <td colspan="6" style="text-align:center;font-size:20px">........................................ </td>
                <td colspan="6" style="text-align:center;font-size:20px">........................................</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align:center;font-size:20px">ผู้จัดทำ</td>
                <td colspan="6" style="text-align:center;font-size:20px">ผู้ตรวจสอบ</td>
            </tr>
            <tr>
                <td colspan="12">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="12">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align:center;font-size:20px">........................................ </td>
                <td colspan="6" style="text-align:center;font-size:20px">........................................</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align:center;font-size:20px">ผู้อนุมัติ</td>
                <td colspan="6" style="text-align:center;font-size:20px">ผู้อนุมัติ</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
    <?php
}
sqlsrv_close($conn);
?>
