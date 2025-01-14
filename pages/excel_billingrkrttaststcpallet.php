<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['invoicecode'] == "" || $_GET['invoicecode'] == "") {
    $strExcelFileName = "RKRTTASTSTC_Billing.xls";
} else {
    $strExcelFileName = "RKRTTASTSTC_Billing" . $_GET['invoicecode'] . ".xls";
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


//
// $condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
// $condBilling2 = "";
//
// $sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
// $params_seBillings = array(
//     array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
//     array($condBilling1, SQLSRV_PARAM_IN),
//     array($condBilling2, SQLSRV_PARAM_IN)
// );
// $query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
// $result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);
//
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


$condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "' ";
$sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmployeeehr = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($condEmployeeehr1, SQLSRV_PARAM_IN)
);
$query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
$result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);

$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,BILLING FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '" . $_GET['invoicecode'] . "'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <br><br>
        <!-- ////////////////////////////////////////////////Charge 10///////////////////////////////////////////////// -->
<?php
// $sql_seBilling10s = "SELECT  c.JOBNO,b.JOBSTART,b.JOBEND,b.REMARK,c.BILLING,a.BILLINGDATE
// FROM [dbo].[LOGINVOICE] a
// INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
// INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
// INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] d ON c.[VEHICLETRANSPORTPRICEID] = d.[VEHICLETRANSPORTPRICEID]
// WHERE b.COMPANYCODE='".$_GET['companycode']."' AND b.CUSTOMERCODE='".$_GET['customercode']."' AND b.REMARK = 'Charge 10' ";
//
// $query_seBilling10s = sqlsrv_query($conn, $sql_seBilling10s, $params_seBilling10s);
// $result_seLocation0s = sqlsrv_fetch_array($query_seBilling10s, SQLSRV_FETCH_ASSOC);
?>

        <!-- //////////////////////////////////////Header Charge 10 ////////////////////////////// -->
        <table style="width: 100%;">
            <thead>
                <tr>

                    <td colspan="10" style="text-align:center;font-size:18px;"><b>เอกสารแนบการวางบิลลูกค้า (ไม่คิดขั้นต่ำ)</b></td>

            </thead>
            <tbody>
                <tr>
                    <td colspan="10" style="text-align:center;font-size:14px;"><b> <?= $result_seInvoicecode['BILLINGDATE'] ?> - <?= $result_seInvoicecode['PAYMENTDATE'] ?> &nbsp (พาเลท)</b></td>
                </tr>

                <tr>
                    <td colspan="10">&nbsp;</td>
                </tr>

            </tbody>
        </table>
        <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
            <thead>
                <tr>
                    <td colspan="5" style="text-align:left;font-size:16px;"><b>หมายเลขบัญชี : STC </b></td>
                    <td colspan="5" style="text-align:right;font-size:16px;"><b>ใบแจ้งหนี้:<?= $_GET['invoicecode'] ?> </b></td>
                </tr>
                <tr style="border:1px solid #000;padding:4px;">

                    <td  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ลำดับ</b></td>
                    <td  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>วันที่</b></td>
                    <td  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>จาก</b></td>
                    <td  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ถึง</b></td>
                    <td  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลข DO</b></td>
                    <td  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>จำนวนพาเลท</b></td>
                    <td  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>อัตรา(บาท/ชิ้น)</b></td>
                    <td  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ราคา(บาท)</b></td>
                    <td  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลขรถ</b></td>
                    <td  style="border-right:1px solid #000;padding:4px;text-align:center;"><b>พนักงาน</b></td>

                </tr>
            </thead><tbody>


<?php
$i = 1;
$sql_seBilling = "SELECT a.VEHICLETRANSPORTPLANID,CONVERT(VARCHAR(10), b.DATEVLIN, 103)  AS 'DATEVLIN_103',a.JOBSTART, a.JOBEND,a.DOCUMENTCODE_PALLET,a.TRIPAMOUNT_PALLET,'10' AS 'PALLETUNIT',(a.TRIPAMOUNT_PALLET*10) AS 'PALLETPRICE',
b.THAINAME AS 'TRUCKTYPE',a.EMPLOYEENAME1
FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
WHERE a.ACTIVESTATUS = 1
AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seInvoicecode['BILLINGDATE'] . "',103) AND CONVERT(DATE,'" . $result_seInvoicecode['PAYMENTDATE'] . "',103)
AND a.COMPANYCODE IN ('RKR','RKL') AND a.CUSTOMERCODE = 'TTASTSTC' AND a.PRODUCTTYPE ='pallet'
AND a.DOCUMENTCODE_PALLET != '' ";




$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
   
  $sql_sePerson = "SELECT [FnameT] FROM EMPLOYEEEHR2 WHERE ([FnameT]+' '+[LnameT]) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
    $query_sePerson = sqlsrv_query($conn, $sql_sePerson, $params_sePerson);
    $result_sePerson = sqlsrv_fetch_array($query_sePerson, SQLSRV_FETCH_ASSOC);
    
    $sql_seLocation = "SELECT TOP 1 b.LOCATION FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
    INNER JOIN [VEHICLETRANSPORTPRICE] b ON a.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
    WHERE a.VEHICLETRANSPORTPLANID = '".$result_seBilling['VEHICLETRANSPORTPLANID']."' AND a.JOBEND = '".$result_seBilling['JOBEND']. "'";
   
    $query_seLocation = sqlsrv_query($conn, $sql_seLocation, $params_seLocation);
    $result_seLocation = sqlsrv_fetch_array($query_seLocation, SQLSRV_FETCH_ASSOC);
    
    if ($result_seLocation['LOCATION'] == 'พระประแดง/สำโรง' || $result_seLocation['LOCATION'] == 'สำโรง') {
      $zone ="Samrong";
    } else if ($result_seLocation['LOCATION'] == 'บางพลี') {
      $zone ="Bangplee";
    } else if ($result_seLocation['LOCATION'] == 'เทพารักษ์') {
      if ($result_seBilling['JOBEND'] == 'HINO2') {
       $zone ="Bangplee";
      }else {
       $zone ="Thepharak";
      }

    } else if ($result_seLocation['LOCATION'] == 'ลาดกระบัง') {
      $zone ="Ladkrabang";
    } else if ($result_seLocation['LOCATION'] == 'บางประกง') {
      if ($result_seBilling['JOBEND'] == 'REFORM') {
        $zone ="Wellgrow";
      }else if ($result_seBilling['JOBEND'] == 'TOY') {
        $zone ="Banpho";
      }else {
        $zone ="Bang Pakong";
      }

    } else if ($result_seLocation['LOCATION'] == 'บ้านโพธิ์') {
      $zone ="Banpho";
    } else if ($result_seLocation['LOCATION'] == 'แปลงยาว') {
      if ($result_seBilling['JOBEND'] == 'NB-WOOD') {
        $zone ="Phanat Nikhom";

      }else {
        $zone ="Gateway";
      }

    } else if ($result_seLocation['LOCATION'] == 'บ้านบึง') {
      $zone ="Banbung";
    } else if ($result_seLocation['LOCATION'] == 'ศรีราชา') {
      $zone ="Sriracha";
    } else if ($result_seLocation['LOCATION'] == 'ปลวกแดง') {
      if ($result_seBilling['JOBEND'] == 'AHT2' || $result_seBilling['JOBEND'] == 'BHKT' || $result_seBilling['JOBEND'] == 'TBFST' || $result_seBilling['JOBEND'] == 'TBFST(BOI)') {
        $zone ="Eastern Seaboard IE.";
      }else if($result_seBilling['JOBEND'] == 'ALS') {
        $zone ="Borwin";
      }else {
        $zone ="Rayong";
      }

    } else if ($result_seLocation['LOCATION'] == 'อมตะนคร') {
      $zone ="Amata City Chonburi";
    } else if ($result_seLocation['LOCATION'] == 'บางปะอิน') {
      $zone ="Ayutthaya";
    } else if ($result_seLocation['LOCATION'] == 'กระทุ่มแบน') {
      $zone ="Prachin Buri";
    }else if ($result_seLocation['LOCATION'] == 'เทพารักษ์') {
      $zone ="Samutsakorn";
    }else if ($result_seLocation['LOCATION'] == 'กบินบุรี') {
      $zone ="Kabinburi";
    }else if ($result_seLocation['LOCATION'] == 'บางบ่อ') {
      if ($result_seBilling['JOBEND'] == 'SIMA') {
        $zone ="Bangplee";
      }else {
        $zone ="Bang-bo";
      }

    } else if ($result_seLocation['LOCATION'] == 'เมือง'){
      if ($result_seBilling['JOBEND'] == 'SARATHORN' || $result_seBilling['JOBEND'] == 'SUNSTEEL' || $result_seBilling['JOBEND'] == 'MONOSTEEL') {
        $zone = "Samutsakorn";
      }else {
        $zone = "Mueang";
      }

    } else if($result_seLocation['LOCATION'] == 'เวลโกรว์' || $result_seLocation['LOCATION'] == 'เวลล์โกร์') {
      $zone = "Wellgrow";
    } else if($result_seLocation['LOCATION'] == 'สุขสวัสดิ์') {
      $zone = "Sooksawat";
    } else if($result_seLocation['LOCATION'] == 'หนองแค') {
      $zone = "Saraburi";
    }else if($result_seLocation['LOCATION'] == 'แปลงยาว') {
      $zone = "Gateway";
    }else if($result_seLocation['LOCATION'] == 'ปู่เจ้า') {
      $zone = "Poochao";
    }else if($result_seLocation['LOCATION'] == 'ปทุมธานี') {
      $zone = "Pathum Thani";
    }else if($result_seLocation['LOCATION'] == 'อยุธยา') {
      $zone = "Ayutthaya";
    }else if($result_seLocation['LOCATION'] == 'อีสเทิร์น ซีบอร์ด') {
      if ($result_seBilling['JOBEND'] == 'SSSC3 : Easternseaboard' ) {
        $zone ="Rayong";
      }else {
        $zone = "Eastern Seaboard IE.";
      }

    } else {
      $zone = $result_seLocation['LOCATION'];
    }

        ?>

                        <tr style="border:1px solid #000;">
                            <td  style="border-right:1px solid #000;padding:5px;text-align:center;"><?= $i ?></td>
                            <td  style="border-right:1px solid #000;padding:5px;text-align:center;" ><?= $result_seBilling['DATEVLIN_103'] ?></td>
                            <td  style="border-right:1px solid #000;padding:5px;text-align:left;"><?= $result_seBilling['JOBEND'].' '.$zone?></td>
                            <td  style="border-right:1px solid #000;padding:5px;text-align:center;">STC Amata City Chonburi</td>
                            <td  style="border-right:1px solid #000;padding:5px;text-align:center;"><?= $result_seBilling['DOCUMENTCODE_PALLET'] ?></td>
                            <td  style="border-right:1px solid #000;padding:5px;text-align:right;"><?= number_format($result_seBilling['TRIPAMOUNT_PALLET'], 2) ?></td>
                            <td  style="border-right:1px solid #000;padding:5px;text-align:right;">10.00</td>
                            <td  style="border-right:1px solid #000;padding:5px;text-align:right;"><?= number_format($result_seBilling['PALLETPRICE'], 2) ?></td>
                            <td  style="border-right:1px solid #000;padding:5px;text-align:center;"><?= $result_seBilling['TRUCKTYPE'] ?></td>
                            <td  style="border-right:1px solid #000;padding:5px;text-align:center;"><?= $result_sePerson['FnameT'] ?> </td>

                        </tr>

        <?php
        $i++;
        $sumtotaltonnocharge += $result_seBilling['TRIPAMOUNT_PALLET'];
        $sumtotalpricenocharge += $result_seBilling['PALLETPRICE'];
    }
    ?>
                </tbody>
                <tfoot>
                    <tr style="border:1px solid #000;">
                        <td  style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
                        <td  style="border-right:1px solid #000;padding:5px;text-align:center;">รวมทั้งหมด</td>
                        <td  style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
                        <td  style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
                        <td  style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
                        <td  style="border-right:1px solid #000;padding:5px;text-align:right;"><?= number_format($sumtotaltonnocharge, 2) ?></td>
                        <td  style="border-right:1px solid #000;padding:5px;text-align:right;"></td>
                        <td  style="border-right:1px solid #000;padding:5px;text-align:right;"><?= number_format($sumtotalpricenocharge, 2) ?></td>
                    <td  style="border-right:1px solid #000;padding:5px;text-align:right;"></td>
                    <td  style="border-right:1px solid #000;padding:5px;text-align:right;"></td>

                </tr>
            </tfoot>
        </table>
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td colspan="10">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="10">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="10">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="10">&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="3" style="width: 30%;text-align:center">ผู้จัดทำ........................................</td>
                    <td colspan="4" style="width: 35%;text-align:center">ผู้ตรวจสอบ........................................</td>
                    <td colspan="3" style="width: 30%;text-align:center">ผู้อนุมัติ........................................</td>

                </tr>



            </tbody>
        </table>

    </body>
</html>
