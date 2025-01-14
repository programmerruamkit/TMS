<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['invoicecode'] == "" || $_GET['invoicecode'] == "") {
    $strExcelFileName = "RKRTDAIKITON_Billing.xls";
} else {
    $strExcelFileName = "RKRTDAIKITON_Billing" . $_GET['invoicecode'] . ".xls";
}

header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");


$sumgmtweight = "";
$sumcusweight = "";
$sumamounttrip = "";
$sumtotal = "";

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '" . $_GET['invoicecode'] . "'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <br><br>


        <!-- //////////////////////////////////////Header Charge 10 ////////////////////////////// -->
        <table style="width: 100%;">
            <thead>
                <tr>

                    <td colspan="12" style="text-align:center;font-size:18px;"><b>เอกสารแนบการวางบิลลูกค้า (คิดขั้นต่ำ)</b></td>

            </thead>
            <tbody>
                <tr>
                    <td colspan="12" style="text-align:center;font-size:14px;"><b> <?= $result_seInvoicecode['BILLINGDATE'] ?> - <?= $result_seInvoicecode['PAYMENTDATE'] ?> &nbsp (ค่าขนส่งปกติ)</b></td>
                </tr>

                <tr>
                    <td colspan="12">&nbsp;</td>
                </tr>

            </tbody>
        </table>
        <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
            <thead>
                <tr>
                    <td colspan="6" style="text-align:left;font-size:16px;"><b>หมายเลขบัญชี : <?= $result_seBilling10['BILLING'] ?>  Charge 12</b></td>
                    <td colspan="6" style="text-align:right;font-size:16px;"><b>ใบแจ้งหนี้: <?=$_GET['invoicecode']?> </b></td>
                </tr>
                <tr style="border:1px solid #000;padding:4px;">

                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ลำดับ</b></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>วันที่</b></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>จาก</b></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ถึง</b></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลข DO</b></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ปริมาณ(ตัน)</b></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>อัตรา(บาท/ตัน)</b></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ราคา(บาท)</b></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลขรถ</b></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>พนักงาน</b></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ราคาจริง</b></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ผลต่าง</b></td>
                </tr>
            </thead><tbody>


                <?php
                $i = 1;
                $condBilling3 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
                $condBilling4 = " AND b.REMARK = 'Charge 12' ";
                $sql_seBilling2 = "SELECT * FROM (SELECT DISTINCT e.VEHICLETYPE,CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CASE
				WHEN b.REMARK = 'Charge 7' THEN b.WEIGHTIN
				WHEN b.REMARK = 'Charge 10' THEN 10000
				ELSE CONVERT(INT,b.WEIGHTIN)
				END) / 1000) * CONVERT(INT,REPLACE(e.[PRICE],'<br><br>',''))) AS 'PRICEAC',
				b.ACTUALPRICE_TEMP,CONVERT(VARCHAR(2),a.BILLINGDATE) AS 'BILLINGDATEDAY',CONVERT(VARCHAR(2),a.PAYMENTDATE) AS 'PAYMENTDATEDD',CONVERT(VARCHAR, CONVERT(DATETIME,a.PAYMENTDATE,103), 103) AS 'PAYMENTDATEDDMMYY', 
				SUBSTRING(convert(VARCHAR, CONVERT(DATETIME,a.PAYMENTDATE,103), 106),3,10) AS 'PAYMENTDATEDDYY',b.VEHICLETRANSPORTDOCUMENTDRIVERID, b.VEHICLETRANSPORTPLANID,b.DOCUMENTCODE, b.COMPANYCODE, 
				b.CUSTOMERCODE, b.EMPLOYEECODE1, b.EMPLOYEENAME1, b.EMPLOYEECODE2, b.EMPLOYEENAME2, b.JOBSTART, b.JOBEND,CONVERT(NVARCHAR,CONVERT(DECIMAL(10,3),(CONVERT(DECIMAL(10,3),CONVERT(INT,b.WEIGHTIN))/1000))) AS 'WEIGHTINTON', 
				b.WEIGHTIN, b.WEIGHTOUT, b.TRIPAMOUNT, b.VEHICLEREGISNUMBER, b.COMPENSATION,b.COMPENSATION1,b.COMPENSATION2,b.OVERTIME, b.OTHER, b.PAY_REMARK, 
				b.PAY_APPROVERS, b.PAY_EXPRESSWAY,PAY_EXPRESSWAY15,PAY_EXPRESSWAY25,PAY_EXPRESSWAY45,PAY_EXPRESSWAY50,PAY_EXPRESSWAY50RETURN,PAY_EXPRESSWAY55,PAY_EXPRESSWAY65,PAY_EXPRESSWAY65RETURN,PAY_EXPRESSWAY75,PAY_EXPRESSWAY195,PAY_EXPRESSWAY100,PAY_EXPRESSWAY105RETURN, b.PAY_REPAIR, b.PAY_OTHER,b.PAY_CONDITION, b.CHECKEDBY, b.APPROVEDBY, 
				b.ACTIVESTATUS, b.REMARK ,CONVERT(VARCHAR(30), c.DATEVLIN, 106)  AS 'DATE_VLIN',CONVERT(VARCHAR(10), c.DATEVLIN, 103)  AS 'DATEVLIN_103',CONVERT(VARCHAR(10), c.DATEWORKING, 103)  AS 'DATEWORKING_103',e.PRICE,
				b.ACTUALPRICE,c.MATERIALTYPE,c.THAINAME
				FROM [dbo].[LOGINVOICE] a
				INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
				INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
				INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID] 
				WHERE 1 = 1" . $condBilling3 . $condBilling4.") AS A ORDER BY DOCUMENTCODE ASC";
                $params_seBilling2 = array();
                $query_seBilling2 = sqlsrv_query($conn, $sql_seBilling2, $params_seBilling2);
                while ($result_seBilling2 = sqlsrv_fetch_array($query_seBilling2, SQLSRV_FETCH_ASSOC)) {
                    $rs = $result_seBilling2['ACTUALPRICE'] - ($result_seBilling2['PRICE'] * $result_seBilling2['WEIGHTINTON']);
                    $sql_seActualprice = "SELECT TOP 1 a.ACTUALPRICE,b.[THAINAME],b.EMPLOYEENAME1,
                    a.ACTUALPRICE-('" . $result_seBilling2['PRICE'] . "' * (SELECT SUM(CONVERT(DECIMAL(10,3),(CONVERT(DECIMAL(10,3),CONVERT(INT,WEIGHTIN))/1000))) FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] WHERE DOCUMENTCODE = '" . $result_seBilling2['DOCUMENTCODE'] . "' )) AS 'DIFF'
                    FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a 
                    INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                    WHERE a.DOCUMENTCODE = '" . $result_seBilling2['DOCUMENTCODE'] . "' 
                    AND '" . $result_seBilling2['WEIGHTIN'] . "' = (SELECT TOP 1 WEIGHTIN FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] WHERE DOCUMENTCODE = '" . $result_seBilling2['DOCUMENTCODE'] . "' )";
                    $params_seActualprice = array();
                    $query_seActualprice = sqlsrv_query($conn, $sql_seActualprice, $params_seActualprice);
                    $result_seActualprice = sqlsrv_fetch_array($query_seActualprice, SQLSRV_FETCH_ASSOC);
                    if ($result_seActualprice['DIFF'] != '') {
                    $diff = number_format($result_seActualprice['DIFF'], 2);
                    } else {
                    $diff = '';
                    }
                    ?>



                    <tr style="border:1px solid #000;">
                        <td style="border-right:1px solid #000;padding:5px;text-align:center;"><?= $i ?></td>
                        <td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seBilling2['DATEWORKING_103'] ?></td>
                        <td style="border-right:1px solid #000;padding:5px;text-align:left;">DAIKI : Amatanakorn</td>
                        <td style="border-right:1px solid #000;padding:5px;text-align:left;">STM : Amatanakorn</td>
                        <td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seBilling2['DOCUMENTCODE'] ?></td>
                        <td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seBilling2['WEIGHTINTON'] ?></td>
                        <td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seBilling2['PRICE'] ?></td>
                        <td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seActualprice['ACTUALPRICE'] ?></td>
                        <td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seActualprice['THAINAME'] ?></td>
                        <td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seActualprice['EMPLOYEENAME1'] ?></td>
                        <td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seBilling2['PRICE'] * $result_seBilling2['WEIGHTINTON'] ?></td>
                        <td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $diff ?></td>

                    </tr>  
                    <?php
                    $sumtotalton1 = $sumtotalton1 + $result_seBilling2['WEIGHTINTON'];
                    $sumtotalprice1 = $sumtotalprice1 + $result_seActualprice['ACTUALPRICE'];
                    $i++;
                }
                ?>
                <tr style="border:1px solid #000;">
                    <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                    <td style="border-right:1px solid #000;padding:4px;text-align:left;"><b>รวม<b></td>
                                <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                <td style="border-right:1px solid #000;padding:4px;text-align:left;"><b><?= $sumtotalton1 ?></b></td>
                                <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                <td style="border-right:1px solid #000;padding:4px;text-align:left;"><b><?= number_format($sumtotalprice1, 2) ?></b></td>
                                <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                </tr>
                                </tbody>
                                </table>




                                <!-- ///////////////////////////////////////ไม่คิดขั้นต่ำ//////////////////////////////////////////////// -->


                                <table style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <td colspan="11" style="text-align:center;font-size:18px;"><b>เอกสารแนบการวางบิลลูกค้า (ไม่คิดขั้นต่ำ)</b></td>

                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="11" style="text-align:center;font-size:14px;"><b> <?= $result_seInvoicecode['BILLINGDATE'] ?> - <?= $result_seInvoicecode['PAYMENTDATE'] ?> &nbsp (ค่าขนส่งปกติ)</b></td>
                                        </tr>

                                        <tr>
                                            <td colspan="11">&nbsp;</td>
                                        </tr>

                                    </tbody>
                                </table>
                                <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
                                    <thead>
                                        <tr>
                                            <td colspan="6" style="text-align:left;font-size:16px;"><b>หมายเลขบัญชี : <?= $result_seBilling3['BILLING'] ?> </b></td>
                                            <td colspan="5" style="text-align:right;font-size:16px;"><b>ใบแจ้งหนี้: <?=$_GET['invoicecode']?></b></td>
                                        </tr>
                                        <tr style="border:1px solid #000;padding:4px;">

                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ลำดับ</b></td>
                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>วันที่</b></td>
                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>จาก</b></td>
                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ถึง</b></td>
                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลข DO</b></td>
                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ปริมาณ(ตัน)</b></td>
                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>อัตรา(บาท/ตัน)</b></td>
                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ราคา(บาท)</b></td>
                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลขรถ</b></td>
                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>พนักงาน</b></td>

                                        </tr>
                                    </thead><tbody>


                                        <?php
                                        $condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
                                        $condBilling2 = " AND b.REMARK = 'ไม่คิดขั้นต่ำ' ";
                                        $sql_seBilling = "SELECT * FROM (SELECT DISTINCT e.VEHICLETYPE,CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CASE
                                        WHEN b.REMARK = 'Charge 7' THEN b.WEIGHTIN
                                        WHEN b.REMARK = 'Charge 10' THEN 10000
                                        ELSE CONVERT(INT,b.WEIGHTIN)
                                        END) / 1000) * CONVERT(INT,REPLACE(e.[PRICE],'<br><br>',''))) AS 'PRICEAC',
                                        b.ACTUALPRICE_TEMP,CONVERT(VARCHAR(2),a.BILLINGDATE) AS 'BILLINGDATEDAY',CONVERT(VARCHAR(2),a.PAYMENTDATE) AS 'PAYMENTDATEDD',CONVERT(VARCHAR, CONVERT(DATETIME,a.PAYMENTDATE,103), 103) AS 'PAYMENTDATEDDMMYY', 
                                        SUBSTRING(convert(VARCHAR, CONVERT(DATETIME,a.PAYMENTDATE,103), 106),3,10) AS 'PAYMENTDATEDDYY',b.VEHICLETRANSPORTDOCUMENTDRIVERID, b.VEHICLETRANSPORTPLANID,b.DOCUMENTCODE, b.COMPANYCODE, 
                                        b.CUSTOMERCODE, b.EMPLOYEECODE1, b.EMPLOYEENAME1, b.EMPLOYEECODE2, b.EMPLOYEENAME2, b.JOBSTART, b.JOBEND,CONVERT(NVARCHAR,CONVERT(DECIMAL(10,3),(CONVERT(DECIMAL(10,3),CONVERT(INT,b.WEIGHTIN))/1000))) AS 'WEIGHTINTON', 
                                        b.WEIGHTIN, b.WEIGHTOUT, b.TRIPAMOUNT, b.VEHICLEREGISNUMBER, b.COMPENSATION,b.COMPENSATION1,b.COMPENSATION2,b.OVERTIME, b.OTHER, b.PAY_REMARK, 
                                        b.PAY_APPROVERS, b.PAY_EXPRESSWAY,PAY_EXPRESSWAY15,PAY_EXPRESSWAY25,PAY_EXPRESSWAY45,PAY_EXPRESSWAY50,PAY_EXPRESSWAY50RETURN,PAY_EXPRESSWAY55,PAY_EXPRESSWAY65,PAY_EXPRESSWAY65RETURN,PAY_EXPRESSWAY75,PAY_EXPRESSWAY195,PAY_EXPRESSWAY100,PAY_EXPRESSWAY105RETURN, b.PAY_REPAIR, b.PAY_OTHER,b.PAY_CONDITION, b.CHECKEDBY, b.APPROVEDBY, 
                                        b.ACTIVESTATUS, b.REMARK ,CONVERT(VARCHAR(30), c.DATEVLIN, 106)  AS 'DATE_VLIN',CONVERT(VARCHAR(10), c.DATEVLIN, 103)  AS 'DATEVLIN_103',CONVERT(VARCHAR(10), c.DATEWORKING, 103)  AS 'DATEWORKING_103',e.PRICE,
                                        b.ACTUALPRICE,c.MATERIALTYPE,c.THAINAME
                                        FROM [dbo].[LOGINVOICE] a
                                        INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
                                        INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
                                        INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] e ON c.[VEHICLETRANSPORTPRICEID] = e.[VEHICLETRANSPORTPRICEID] 
                                        WHERE 1 = 1" . $condBilling1 . $condBilling2.") AS A ORDER BY DOCUMENTCODE ASC";
                                        $params_seBilling = array();


                                        $i = 1;
                                        $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                                        while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                                            
                                            $sql_seActualprice = "SELECT TOP 1 a.ACTUALPRICE,b.[THAINAME],b.EMPLOYEENAME1,
                                            a.ACTUALPRICE-('" . $result_seBilling['PRICE'] . "' * (SELECT SUM(CONVERT(DECIMAL(10,3),(CONVERT(DECIMAL(10,3),CONVERT(INT,WEIGHTIN))/1000))) FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] WHERE DOCUMENTCODE = '" . $result_seBilling['DOCUMENTCODE'] . "' )) AS 'DIFF'
                                            FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a 
                                            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                                            WHERE a.DOCUMENTCODE = '" . $result_seBilling['DOCUMENTCODE'] . "' 
                                            AND '" . $result_seBilling['WEIGHTIN'] . "' = (SELECT TOP 1 WEIGHTIN FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] WHERE DOCUMENTCODE = '" . $result_seBilling['DOCUMENTCODE'] . "' )";
                                            $params_seActualprice = array();
                                            $query_seActualprice = sqlsrv_query($conn, $sql_seActualprice, $params_seActualprice);
                                            $result_seActualprice = sqlsrv_fetch_array($query_seActualprice, SQLSRV_FETCH_ASSOC);
                                            if ($result_seActualprice['DIFF'] != '') {
                                            $diff = number_format($result_seActualprice['DIFF'], 2);
                                            } else {
                                            $diff = '';
                                            }


                                            $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seActualprice['EMPLOYEENAME1'] . "' ";
                                            $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                                            $params_seEmployeeehr = array(
                                                array('select_employeeehr2', SQLSRV_PARAM_IN),
                                                array($condEmployeeehr1, SQLSRV_PARAM_IN)
                                            );
                                            $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                                            $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                                            ?>



                                            <tr style="border:1px solid #000;">
                                                <td style="border-right:1px solid #000;padding:5px;text-align:center;"><?= $i ?></td>
                                                <td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seBilling['DATEWORKING_103'] ?></td>
                                                <td style="border-right:1px solid #000;padding:5px;text-align:left;">DAIKI : Amatanakorn</td>
                                                <td style="border-right:1px solid #000;padding:5px;text-align:left;">STM : Amatanakorn</td>
                                                <td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                                                <td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seBilling['WEIGHTINTON'] ?></td>
                                                <td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seBilling['PRICE'] ?></td>
                                                <td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= number_format($result_seActualprice['ACTUALPRICE'], 2) ?></td>
                                                <td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seActualprice['THAINAME'] ?></td>
                                                <td style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seEmployeeehr['FnameT'] ?></td>
                                            </tr>
                                            <?php
                                            $i++;
                                            $sumtotalton3 += $result_seBilling['WEIGHTINTON'];
                                            $sumtotalprice3 += $result_seActualprice['ACTUALPRICE'];
                                        }
                                        ?>
                                    <tr style="border:1px solid #000;">
                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
                                        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>รวม<b></td>
                                        <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                        <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                        <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                        <td style="border-right:1px solid #000;padding:4px;text-align:left;"><b><?= $sumtotalton3 ?></td>
                                        <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                        <td style="border-right:1px solid #000;padding:4px;text-align:left;"><b><?= number_format($sumtotalprice3, 2) ?></td>
                                        <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>
                                        <td style="border-right:1px solid #000;padding:4px;text-align:left;"></td>

                                    </tr>
                                    </tbody>
                                    </table>

                                    </body>
                                    </html>
