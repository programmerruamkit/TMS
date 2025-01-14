<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['invoicecode'] == "" || $_GET['invoicecode'] == "") {
  $strExcelFileName = "RKRTTTC(Weight)_Billing.xls";
} else {
  $strExcelFileName = "RKRTTTC(Weight)_Billing" . $_GET['invoicecode'] . ".xls";
}
//

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

$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,BILLING FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '".$_GET['invoicecode']."'";
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
// $result_seBilling10s = sqlsrv_fetch_array($query_seBilling10s, SQLSRV_FETCH_ASSOC);

 ?>

 <!-- //////////////////////////////////////Header Charge 10 ////////////////////////////// -->
 <table style="width: 100%;">
       <thead>
           <tr>

               <td colspan="13" style="text-align:center;font-size:18px;"><b>เอกสารแนบการวางบิลลูกค้า (คิดขั้นต่ำ)</b></td>

       </thead>
       <tbody>
           <tr>
               <td colspan="13" style="text-align:center;font-size:14px;"><b> <?= $result_seInvoicecode['BILLINGDATE']?> - <?= $result_seInvoicecode['PAYMENTDATE']?> &nbsp (ค่าขนส่งปกติ)</b></td>
          </tr>

          <tr>
               <td colspan="13">&nbsp;</td>
          </tr>

       </tbody>
   </table>
 <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
 <thead>
           <tr>
               <td colspan="6" style="text-align:left;font-size:16px;"><b>หมายเลขบัญชี : <?=$result_seInvoicecode['BILLING']?>  Charge 10</b></td>
               <td colspan="7" style="text-align:right;font-size:16px;"><b>ใบแจ้งหนี้: <?= $_GET['invoicecode']?></b></td>
           </tr>
           <tr style="border:1px solid #000;padding:4px;">

           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ลำดับ</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>วันที่</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>จาก</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ถึง</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Zone</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลข DO</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ปริมาณ(ตัน)</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>อัตรา(บาท/ตัน)</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ราคา(บาท)</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลขรถ</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>พนักงาน</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ราคาจริง</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ผลต่าง</b></td>
         </tr>
       </thead><tbody>


<?php
$i10 = 1;
$sql_execTemp_billing10 = "{call megTempbilling(?,?,?,?,?,?,?)}";
$params_execTemp_billing10 = array(
    array('select_tempbillingexcel10', SQLSRV_PARAM_IN),
    array($_GET['companycode'], SQLSRV_PARAM_IN),
    array($_GET['customercode'], SQLSRV_PARAM_IN),
    array($result_seInvoicecode['BILLINGDATE'], SQLSRV_PARAM_IN),
    array($result_seInvoicecode['PAYMENTDATE'], SQLSRV_PARAM_IN),
    array($result_seInvoicecode['BILLING'], SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN)
);
$query_execTemp_billing10 = sqlsrv_query($conn, $sql_execTemp_billing10, $params_execTemp_billing10);
$result_execTemp_billing10 = sqlsrv_fetch_array($query_execTemp_billing10, SQLSRV_FETCH_ASSOC);

$sql_seBilling10 = "SELECT VEHICLETRANSPORTPLANID,VEHICLETRANSPORTDOCUMENTDRIVERID AS 'DRIVERID1' , BILLINGDATE, JOBSTART, JOBEND, LOCATION, DOCUMENTCODE,
                    WEIGHTIN, PRICETON, PRICE, THAINAME, EMPLOYEENAME1, PRICEAC, PRICEREAL, BILLINGEXCEL,BILLING
                    FROM TEMP_BILLINGEXCEL10
                    WHERE BILLING='".$result_seInvoicecode['BILLING']."' AND INVOICECODE = '".$_GET['invoicecode']."'
                    ORDER BY  DOCUMENTCODE,JOBEND,WEIGHTIN ASC ";
$query_seBilling10 = sqlsrv_query($conn, $sql_seBilling10, $params_seBilling10);
while($result_seBilling10 = sqlsrv_fetch_array($query_seBilling10, SQLSRV_FETCH_ASSOC)){

    $sql_seBilling10_1 = "SELECT TOP 1  VEHICLETRANSPORTDOCUMENTDRIVERID  AS 'DRIVERID2',WEIGHTIN,JOBSTART,JOBEND,DOCUMENTCODE
                          FROM [VEHICLETRANSPORTDOCUMENTDIRVER] a
                          WHERE a.VEHICLETRANSPORTPLANID = '".$result_seBilling10['VEHICLETRANSPORTPLANID']."' AND a.JOBEND = '".$result_seBilling10['JOBEND']."'
                          ORDER BY DOCUMENTCODE DESC";
    $query_seBilling10_1 = sqlsrv_query($conn, $sql_seBilling10_1, $params_seBilling10_1);
    $result_seBilling10_1 = sqlsrv_fetch_array($query_seBilling10_1, SQLSRV_FETCH_ASSOC);

    $sql_seSumDif10 = "SELECT SUM(CONVERT(DECIMAL(10,3),a.PRICEREAL)) AS 'SUMPRICEREAL'
                      FROM TEMP_BILLINGEXCEL10 a
                      WHERE a.VEHICLETRANSPORTPLANID = '".$result_seBilling10['VEHICLETRANSPORTPLANID']."' AND a.JOBEND = '".$result_seBilling10['JOBEND']."' AND a.INVOICECODE = '".$_GET['invoicecode']."'";
    $query_seSumDif10 = sqlsrv_query($conn, $sql_seSumDif10, $params_seSumDif10);
    $result_seSumDif10 = sqlsrv_fetch_array($query_seSumDif10, SQLSRV_FETCH_ASSOC);

    $sql_seDate10= "SELECT FORMAT (DATEWORKING, 'dd/MM/yyyy') AS 'DATE'
                    FROM [dbo].[VEHICLETRANSPORTPLAN] a
                    WHERE a.VEHICLETRANSPORTPLANID = '".$result_seBilling10['VEHICLETRANSPORTPLANID']."' ";
    $query_seDate10 = sqlsrv_query($conn, $sql_seDate10, $params_seDate10);
    $result_seDate10 = sqlsrv_fetch_array($query_seDate10, SQLSRV_FETCH_ASSOC);

    $price10 = "";
    $thainame10="";
    $employeename10="";
    $pricereal10="";

    if($result_seBilling10['DRIVERID1'] == $result_seBilling10_1['DRIVERID2'] )
    {
        $price10 = $result_seBilling10['PRICETON']*10;
        $thainame10 = $result_seBilling10['THAINAME'];
        $employeename10 = $result_seBilling10['EMPLOYEENAME1'];
        $pricereal10 = ($result_seSumDif10['SUMPRICEREAL']);
    }else {
        $price10 = "";
        $thainame10 = "";
        $employeename10 = "";
        $pricereal10 = "";
    }


/////////////////////////////////ZONE////////////////////////////////////////////////////////////
    if ($result_seBilling10['LOCATION'] == 'พระประแดง/สำโรง' || $result_seBilling10['LOCATION'] == 'สำโรง') {
      $zone10 ="Samrong";
    } else if ($result_seBilling10['LOCATION'] == 'บางพลี') {
      $zone10 ="Bangplee";
    } else if ($result_seBilling10['LOCATION'] == 'เทพารักษ์') {
      if ($result_seBilling10['JOBEND'] == 'HINO2') {
       $zone10 ="Bangplee";
      }else {
       $zone10 ="Thepharak";
      }

    } else if ($result_seBilling10['LOCATION'] == 'ลาดกระบัง') {
      $zone10 ="Ladkrabang";
    } else if ($result_seBilling10['LOCATION'] == 'บางประกง') {
      if ($result_seBilling10['JOBEND'] == 'REFORM') {
        $zone10 ="Wellgrow";
      }else if ($result_seBilling10['JOBEND'] == 'TOY') {
        $zone10 ="Banpho";
      }else {
        $zone10 ="Bang Pakong";
      }

    } else if ($result_seBilling10['LOCATION'] == 'บ้านโพธิ์') {
      $zone10 ="Banpho";
    } else if ($result_seBilling10['LOCATION'] == 'แปลงยาว') {
      if ($result_seBilling10['JOBEND'] == 'NB-WOOD') {
        $zone10 ="Phanat Nikhom";

      }else {
        $zone10 ="Gateway";
      }

    } else if ($result_seBilling10['LOCATION'] == 'บ้านบึง') {
      $zone10 ="Banbung";
    } else if ($result_seBilling10['LOCATION'] == 'ศรีราชา') {
      $zone10 ="Sriracha";
    } else if ($result_seBilling10['LOCATION'] == 'ปลวกแดง') {
      if ($result_seBilling10['JOBEND'] == 'AHT2' || $result_seBilling10['JOBEND'] == 'BHKT' || $result_seBilling10['JOBEND'] == 'TBFST' || $result_seBilling10['JOBEND'] == 'TBFST(BOI)') {
        $zone10 ="Eastern Seaboard IE.";
      }else if($result_seBilling10['JOBEND'] == 'ALS') {
        $zone10 ="Borwin";
      }else {
        $zone10 ="Rayong";
      }

    } else if ($result_seBilling10['LOCATION'] == 'อมตะนคร') {
      $zone10 ="Amata City Chonburi";
    } else if ($result_seBilling10['LOCATION'] == 'บางปะอิน') {
      $zone10 ="Ayutthaya";
    } else if ($result_seBilling10['LOCATION'] == 'กระทุ่มแบน') {
      $zone10 ="Prachin Buri";
    }else if ($result_seBilling10['LOCATION'] == 'เทพารักษ์') {
      $zone10 ="Samutsakorn";
    }else if ($result_seBilling10['LOCATION'] == 'กบินบุรี') {
      if ($result_seBilling10['JOBEND'] == 'HISADA') {
        $zone10 ="Prachin Buri";
      }else {
        $zone10 ="Kabinburi";
      }

    }else if ($result_seBilling10['LOCATION'] == 'บางบ่อ') {
      if ($result_seBilling10['JOBEND'] == 'SIMA') {
        $zone10 ="Bangplee";
      }else {
        $zone10 ="Bang-bo";
      }

    } else if ($result_seBilling10['LOCATION'] == 'เมือง'){
      if ($result_seBilling10['JOBEND'] == 'SARATHORN' || $result_seBilling10['JOBEND'] == 'SUNSTEEL') {
        $zone10 = "Samutsakorn";
      }else {
        $zone10 = "Mueang";
      }

    } else if($result_seBilling10['LOCATION'] == 'เวลโกรว์') {
      $zone10 = "Wellgrow";
    } else if($result_seBilling10['LOCATION'] == 'สุขสวัสดิ์') {
      $zone10 = "Sooksawat";
    } else if($result_seBilling10['LOCATION'] == 'หนองแค') {
      $zone10 = "Saraburi";
    }else if($result_seBilling10['LOCATION'] == 'แปลงยาว') {
      $zone10 = "Gateway";
    }else if($result_seBilling10['LOCATION'] == 'ปู่เจ้า') {
      $zone10 = "Poochao";
    }else if($result_seBilling10['LOCATION'] == 'พนัสนิคม') {
      $zone10 = "Phanat Nikhom";
    }else if($result_seBilling10['LOCATION'] == 'ประชาอุทิศ') {
      $zone10 = "Pracha Uthid";
    } else {
      $zone10 = $result_seBilling10['LOCATION'];
    }

    ////////////////////////////////////////JOBEND///////////////////////////////////////////////
      if ($result_seBilling10['JOBEND'] == 'TMB') {
        $jobend10 = "TMT/BP";
      }else if ($result_seBilling10['JOBEND'] == 'APIGO') {
        $jobend10 = "AAPICO";
      }else if ($result_seBilling10['JOBEND'] == 'ASNO') {
        $jobend10 = "ASNO1";
      }else if ($result_seBilling10['JOBEND'] == 'TBFST' || $result_seBilling10['JOBEND'] == 'TBFST(BOI)') {
        $jobend10 = "TBFST";
      }else if ($result_seBilling10['JOBEND'] == 'TYP') {
        $jobend10 = "TYKP";
      }else if ($result_seBilling10['JOBEND'] == 'WFAN/R.Y.') {
        $jobend10 = "WIREFORM";
      }else if ($result_seBilling10['JOBEND'] == 'TMG') {
        $jobend10 = "TMT/GW";
      }else if ($result_seBilling10['JOBEND'] == 'SSSC-02') {
        $jobend10 = "SSSC-2";
      }else if ($result_seBilling10['JOBEND'] == 'TABT/DMK') {
        $jobend10 = "DMK";
      }else if ($result_seBilling10['JOBEND'] == 'TMS') {
        $jobend10 = "TMT/SR";
      }else if ($result_seBilling10['JOBEND'] == 'SUNSTEEL') {
        $jobend10 = "Sonsteel";
      }else if ($result_seBilling10['JOBEND'] == 'SRP') {
        $jobend10 = "S.R-P";
      }else if ($result_seBilling10['JOBEND'] == 'KIT2/KIT') {
        $jobend10 = "KIT";
      }else if ($result_seBilling10['JOBEND'] == 'SHI/SHI2') {
        $jobend10 = "SHI(2)";
      }else if ($result_seBilling10['JOBEND'] == 'SHIROKI' || $result_seBilling10['JOBEND'] == 'SHIROKI(1)') {
        $jobend10 = "SHIROKI(1)";
      }else if ($result_seBilling10['JOBEND'] == 'YMPPD/BT') {
        $jobend10 = "BTD";
      }else {
        $jobend10 = $result_seBilling10['JOBEND'];
      }
 ?>




  <tr style="border:1px solid #000;">
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?= $i10 ?></td>
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seDate10['DATE']?></td>
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;">STC Amata City Chonburi</td>
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$jobend10?></td>
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$zone10?></td>
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling10['DOCUMENTCODE']?></td>
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$result_seBilling10['WEIGHTIN']?></td>
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$result_seBilling10['PRICETON']?></td>
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$price10?></td>
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$thainame10?></td>
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$employeename10?> </td>
  <!--<td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?//=number_format($result_seBilling10['PRICEAC'])?></td>-->
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=number_format($result_seBilling10['PRICETON']*$result_seBilling10['WEIGHTIN'],2)?> </td>
  <?php
  if ($pricereal10 == '') {
    ?>
    <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;">0.00</td>
    <?php
  }else {
    ?>
    <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?= number_format($price10-$pricereal10,2)?> </td>
    <?php
  }
   ?>


  </tr>
  <?php
  $i10++;
  $sumtotalton10 += $result_seBilling10['WEIGHTIN'];
  $sumtotalprice10 += $result_seBilling10['PRICE'];
}
   ?>

   </tbody>
 </table>

<!-- ////////////////////////////////////Charge 7 /////////////////////////////////////// -->
<br><br>
 <!-- //////////////////////////////////////Header Charge 7 ////////////////////////////// -->
 <table style="width: 100%;">
       <thead>
           <tr>
               <td colspan="13" style="text-align:center;font-size:18px;"><b>เอกสารแนบการวางบิลลูกค้า (คิดขั้นต่ำ)</b></td>

       </thead>
       <tbody>
           <tr>
               <td colspan="13" style="text-align:center;font-size:14px;"><b> <?= $result_seInvoicecode['BILLINGDATE']?> - <?= $result_seInvoicecode['PAYMENTDATE']?> &nbsp (ค่าขนส่งปกติ)</b></td>
          </tr>

          <tr>
               <td colspan="13">&nbsp;</td>
          </tr>

       </tbody>
   </table>
 <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
 <thead>
           <tr>
               <td colspan="6" style="text-align:left;font-size:16px;"><b>หมายเลขบัญชี : <?=$result_seInvoicecode['BILLING']?>  Charge 7</b></td>
               <td colspan="7" style="text-align:right;font-size:16px;"><b>ใบแจ้งหนี้: <?= $_GET['invoicecode']?></b></td>
           </tr>
           <tr style="border:1px solid #000;padding:4px;">

           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ลำดับ</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>วันที่</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>จาก</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ถึง</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Zone</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลข DO</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ปริมาณ(ตัน)</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>อัตรา(บาท/ตัน)</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ราคา(บาท)</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลขรถ</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>พนักงาน</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ราคาจริง</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ผลต่าง</b></td>
         </tr>
       </thead><tbody>


<?php
$i7 = 1;
$sql_execTemp_billing7 = "{call megTempbilling(?,?,?,?,?,?,?)}";
$params_execTemp_billing7 = array(
    array('select_tempbillingexcel7', SQLSRV_PARAM_IN),
    array($_GET['companycode'], SQLSRV_PARAM_IN),
    array($_GET['customercode'], SQLSRV_PARAM_IN),
    array($result_seInvoicecode['BILLINGDATE'], SQLSRV_PARAM_IN),
    array($result_seInvoicecode['PAYMENTDATE'], SQLSRV_PARAM_IN),
    array($result_seInvoicecode['BILLING'], SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN)

);
$query_execTemp_billing7 = sqlsrv_query($conn, $sql_execTemp_billing7, $params_execTemp_billing7);
$result_execTemp_billing7 = sqlsrv_fetch_array($query_execTemp_billing7, SQLSRV_FETCH_ASSOC);

$sql_seBilling7 = "SELECT VEHICLETRANSPORTPLANID,VEHICLETRANSPORTDOCUMENTDRIVERID AS 'DRIVERID1', BILLINGDATE, JOBSTART, JOBEND, LOCATION, DOCUMENTCODE,
                    WEIGHTIN, PRICETON, PRICE, THAINAME, EMPLOYEENAME1, PRICEAC, PRICEREAL, BILLINGEXCEL,BILLING
                    FROM TEMP_BILLINGEXCEL7
                    WHERE BILLING='".$result_seInvoicecode['BILLING']."' AND INVOICECODE = '".$_GET['invoicecode']."'
                    ORDER BY DOCUMENTCODE,JOBEND,WEIGHTIN DESC";
$query_seBilling7 = sqlsrv_query($conn, $sql_seBilling7, $params_seBilling7);
while($result_seBilling7 = sqlsrv_fetch_array($query_seBilling7, SQLSRV_FETCH_ASSOC)){

    $sql_seBilling7_1 = "SELECT TOP 1  VEHICLETRANSPORTDOCUMENTDRIVERID  AS 'DRIVERID2',WEIGHTIN,JOBSTART,JOBEND,DOCUMENTCODE
                          FROM [VEHICLETRANSPORTDOCUMENTDIRVER] a
                          WHERE a.VEHICLETRANSPORTPLANID = '".$result_seBilling7['VEHICLETRANSPORTPLANID']."' AND a.JOBEND = '".$result_seBilling7['JOBEND']."'
                          ORDER BY DOCUMENTCODE DESC";
    $query_seBilling7_1 = sqlsrv_query($conn, $sql_seBilling7_1, $params_seBilling7_1);
    $result_seBilling7_1 = sqlsrv_fetch_array($query_seBilling7_1, SQLSRV_FETCH_ASSOC);

    $sql_seSumDif7 = "SELECT SUM(CONVERT(DECIMAL(10,3),a.PRICEREAL)) AS 'SUMPRICEREAL'
                      FROM TEMP_BILLINGEXCEL7 a
                      WHERE a.VEHICLETRANSPORTPLANID = '".$result_seBilling7['VEHICLETRANSPORTPLANID']."' AND a.JOBEND = '".$result_seBilling7['JOBEND']."' AND a.INVOICECODE = '".$_GET['invoicecode']."'";
    $query_seSumDif7 = sqlsrv_query($conn, $sql_seSumDif7, $params_seSumDif7);
    $result_seSumDif7 = sqlsrv_fetch_array($query_seSumDif7, SQLSRV_FETCH_ASSOC);

    $sql_seDate7= "SELECT FORMAT (DATEWORKING, 'dd/MM/yyyy') AS 'DATE'
                    FROM [dbo].[VEHICLETRANSPORTPLAN] a
                    WHERE a.VEHICLETRANSPORTPLANID = '".$result_seBilling7['VEHICLETRANSPORTPLANID']."' ";
    $query_seDate7 = sqlsrv_query($conn, $sql_seDate7, $params_seDate7);
    $result_seDate7 = sqlsrv_fetch_array($query_seDate7, SQLSRV_FETCH_ASSOC);

    $price7 = "";
    $thainame7="";
    $employeename7="";
    $pricereal7="";

    if($result_seBilling7['DRIVERID1'] == $result_seBilling7_1['DRIVERID2'] )
    {
        $price7 = $result_seBilling7['PRICETON']*7;
        $thainame7= $result_seBilling7['THAINAME'];
        $employeename7 = $result_seBilling7['EMPLOYEENAME1'];
        $pricereal7 = ($result_seSumDif7['SUMPRICEREAL']);
    }else {
        $price7 = "";
        $thainame7 = "";
        $employeename7 = "";
        $pricereal7 = "";
    }

    /////////////////////////////////ZONE////////////////////////////////////////////////////////////
        if ($result_seBilling7['LOCATION'] == 'พระประแดง/สำโรง' || $result_seBilling7['LOCATION'] == 'สำโรง') {
          $zone7 ="Somrong";
        } else if ($result_seBilling7['LOCATION'] == 'บางพลี') {
          $zone7 ="Bangplee";
        } else if ($result_seBilling7['LOCATION'] == 'เทพารักษ์') {
          if ($result_seBilling7['JOBEND'] == 'HINO2') {
           $zone7 ="Bangplee";
          }else {
           $zone7 ="Thepharak";
          }

        } else if ($result_seBilling7['LOCATION'] == 'ลาดกระบัง') {
          $zone7 ="Ladkrabang";
        } else if ($result_seBilling7['LOCATION'] == 'บางประกง') {
          if ($result_seBilling7['JOBEND'] == 'REFORM') {
            $zone7 ="Wellgrow";
          }else if ($result_seBilling7['JOBEND'] == 'TOY') {
            $zone7 ="Banpho";
          }else {
            $zone7 ="Bang Pakong";
          }

        } else if ($result_seBilling7['LOCATION'] == 'บ้านโพธิ์') {
          $zone7 ="Banpho";
        } else if ($result_seBilling7['LOCATION'] == 'แปลงยาว') {
          if ($result_seBilling7['JOBEND'] == 'NB-WOOD') {
            $zone7 ="Phanat Nikhom";

          }else {
            $zone7 ="Gateway";
          }

        } else if ($result_seBilling7['LOCATION'] == 'บ้านบึง') {
          $zone7 ="Banbung";
        } else if ($result_seBilling7['LOCATION'] == 'ศรีราชา') {
          $zone7 ="Sriracha";
        } else if ($result_seBilling7['LOCATION'] == 'ปลวกแดง') {
          if ($result_seBilling7['JOBEND'] == 'AHT2' || $result_seBilling7['JOBEND'] == 'BHKT' || $result_seBilling7['JOBEND'] == 'TBFST' || $result_seBilling7['JOBEND'] == 'TBFST(BOI)') {
            $zone7 ="Eastern Seaboard IE.";
          }else if($result_seBilling7['JOBEND'] == 'ALS') {
            $zone7 ="Borwin";
          }else {
            $zone7 ="Rayong";
          }

        } else if ($result_seBilling7['LOCATION'] == 'อมตะนคร') {
          $zone7 ="Amata City Chonburi";
        } else if ($result_seBilling7['LOCATION'] == 'บางปะอิน') {
          $zone7 ="Ayutthaya";
        } else if ($result_seBilling7['LOCATION'] == 'กระทุ่มแบน') {
          $zone7 ="Prachin Buri";
        }else if ($result_seBilling7['LOCATION'] == 'เทพารักษ์') {
          $zone7 ="Samutsakorn";
        }else if ($result_seBilling7['LOCATION'] == 'กบินบุรี') {
          if ($result_seBilling7['JOBEND'] == 'HISADA') {
            $zone7 ="Prachin Buri";
          }else {
            $zone7 ="Kabinburi";
          }
        }else if ($result_seBilling7['LOCATION'] == 'บางบ่อ') {
          if ($result_seBilling7['JOBEND'] == 'SIMA') {
            $zone7 ="Bangplee";
          }else {
            $zone7 ="Bang-bo";
          }

        } else if ($result_seBilling7['LOCATION'] == 'เมือง'){
          if ($result_seBilling7['JOBEND'] == 'SARATHORN' || $result_seBilling7['JOBEND'] == 'SUNSTEEL') {
            $zone7 = "Samutsakorn";
          }else {
            $zone7 = "Mueang";
          }

        } else if($result_seBilling7['LOCATION'] == 'เวลโกรว์') {
          $zone7 = "Wellgrow";
        } else if($result_seBilling7['LOCATION'] == 'สุขสวัสดิ์') {
          $zone7 = "Sooksawat";
        } else if($result_seBilling7['LOCATION'] == 'หนองแค') {
          $zone7 = "Saraburi";
        }else if($result_seBilling7['LOCATION'] == 'แปลงยาว') {
          $zone7 = "Gateway";
        }else if($result_seBilling7['LOCATION'] == 'ปู่เจ้า') {
          $zone7 = "Poochao";
        }  else {
          $zone7 = $result_seBilling7['LOCATION'];
        }

        ////////////////////////////////////////JOBEND///////////////////////////////////////////////
          if ($result_seBilling7['JOBEND'] == 'TMB') {
            $jobend7 = "TMT/BP";
          }else if ($result_seBilling7['JOBEND'] == 'APIGO') {
            $jobend7 = "AAPICO";
          }else if ($result_seBilling7['JOBEND'] == 'ASNO') {
            $jobend7 = "ASNO1";
          }else if ($result_seBilling7['JOBEND'] == 'TBFST' || $result_seBilling7['JOBEND'] == 'TBFST(BOI)') {
            $jobend7 = "TBFST";
          }else if ($result_seBilling7['JOBEND'] == 'TYP') {
            $jobend7 = "TYKP";
          }else if ($result_seBilling7['JOBEND'] == 'WFAN/R.Y.') {
            $jobend7 = "WIREFORM";
          }else if ($result_seBilling7['JOBEND'] == 'TMG') {
            $jobend7 = "TMT/GW";
          }else if ($result_seBilling7['JOBEND'] == 'SSSC-02') {
            $jobend7 = "SSSC-2";
          }else if ($result_seBilling7['JOBEND'] == 'TABT/DMK') {
            $jobend7 = "DMK";
          }else if ($result_seBilling7['JOBEND'] == 'TMS') {
            $jobend7 = "TMT/SR";
          }else if ($result_seBilling7['JOBEND'] == 'SUNSTEEL') {
            $jobend7 = "Sonsteel";
          }else if ($result_seBilling7['JOBEND'] == 'SRP') {
            $jobend7 = "S.R-P";
          }else if ($result_seBilling7['JOBEND'] == 'KIT2/KIT') {
            $jobend7 = "KIT";
          }else if ($result_seBilling7['JOBEND'] == 'SHI/SHI2') {
            $jobend7 = "SHI(2)";
          }else if ($result_seBilling7['JOBEND'] == 'SHIROKI' || $result_seBilling7['JOBEND'] == 'SHIROKI(1)') {
            $jobend7 = "SHIROKI(1)";
          }else if ($result_seBilling7['JOBEND'] == 'YMPPD/BT') {
            $jobend7 = "BTD";
          }else {
            $jobend7 = $result_seBilling7['JOBEND'];
          }


 ?>



 <tr style="border:1px solid #000;">
 <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?= $i7 ?></td>
 <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seDate7['DATE']?></td>
 <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;">STC Amata City Chonburi</td>
 <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$jobend7?></td>
 <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$zone7?></td>
 <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling7['DOCUMENTCODE']?></td>
 <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$result_seBilling7['WEIGHTIN']?></td>
 <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$result_seBilling7['PRICETON']?></td>
 <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$price7?></td>
 <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$thainame7?></td>
 <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$employeename7?> </td>
 <!--<td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?//=number_format($result_seBilling10['PRICEAC'])?></td>-->
 <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=number_format($result_seBilling7['PRICETON']*$result_seBilling7['WEIGHTIN'],2)?> </td>
 <?php
 if ($pricereal7 == '') {
   ?>
   <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"></td>
   <?php
 }else {
   ?>
   <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?= number_format($price7-$pricereal7,2)?> </td>
   <?php
 }
  ?>


 </tr>
  <?php
  $i7++;
  $sumtotalton7 += $result_seBilling7['WEIGHTIN'];
  $sumtotalprice7 += $result_seBilling7['PRICE'];
}
   ?>

   </tbody>
 </table>

<!-- ///////////////////////////////////////ไม่คิดขั้นต่ำ//////////////////////////////////////////////// -->

<br><br>
 <!-- //////////////////////////////////////Header ไม่คิดขั้นต่ำ ////////////////////////////// -->
 <table style="width: 100%;">
       <thead>
           <tr>
               <td colspan="13" style="text-align:center;font-size:18px;"><b>เอกสารแนบการวางบิลลูกค้า (ไม่คิดขั้นต่ำ)</b></td>

       </thead>
       <tbody>
           <tr>
               <td colspan="13" style="text-align:center;font-size:14px;"><b> <?= $result_seInvoicecode['BILLINGDATE']?> - <?= $result_seInvoicecode['PAYMENTDATE']?> &nbsp (ค่าขนส่งปกติ)</b></td>
          </tr>

          <tr>
               <td colspan="13">&nbsp;</td>
          </tr>

       </tbody>
   </table>
 <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
 <thead>
           <tr>
               <td colspan="5" style="text-align:left;font-size:16px;"><b>หมายเลขบัญชี : <?=$result_seInvoicecode['BILLING']?>  ไม่คิดขั้นต่ำ </b></td>
               <td colspan="6" style="text-align:right;font-size:16px;"><b>ใบแจ้งหนี้:<?= $_GET['invoicecode']?> </b></td>
           </tr>
           <tr style="border:1px solid #000;padding:4px;">

           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ลำดับ</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>วันที่</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>จาก</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ถึง</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Zone</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลข DO</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ปริมาณ(ตัน)</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>อัตรา(บาท/ตัน)</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ราคา(บาท)</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลขรถ</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>พนักงาน</b></td>

         </tr>
       </thead><tbody>


         <?php
         $inocharge = 1;
         $sql_execTemp_billingnocharge = "{call megTempbilling(?,?,?,?,?,?,?)}";
         $params_execTemp_billingnocharge = array(
             array('select_tempbillingexcelnocharge', SQLSRV_PARAM_IN),
             array($_GET['companycode'], SQLSRV_PARAM_IN),
             array($_GET['customercode'], SQLSRV_PARAM_IN),
             array($result_seInvoicecode['BILLINGDATE'], SQLSRV_PARAM_IN),
             array($result_seInvoicecode['PAYMENTDATE'], SQLSRV_PARAM_IN),
             array($result_seInvoicecode['BILLING'], SQLSRV_PARAM_IN),
             array($_GET['invoicecode'], SQLSRV_PARAM_IN)

         );
         $query_execTemp_billingnocharge  = sqlsrv_query($conn, $sql_execTemp_billingnocharge, $params_execTemp_billingnocharge);
         $result_execTemp_billingnocharge  = sqlsrv_fetch_array($query_execTemp_billingnocharge, SQLSRV_FETCH_ASSOC);

         $sql_seBillingnocharge = "SELECT VEHICLETRANSPORTPLANID,VEHICLETRANSPORTDOCUMENTDRIVERID AS 'DRIVERID1', BILLINGDATE, JOBSTART, JOBEND, LOCATION, DOCUMENTCODE,
                             WEIGHTIN, PRICETON, PRICE, THAINAME, EMPLOYEENAME1, PRICEAC, PRICEREAL, BILLINGEXCEL,BILLING
                             FROM TEMP_BILLINGEXCELNOCHARGE
                             WHERE BILLING='".$result_seInvoicecode['BILLING']."' AND INVOICECODE = '".$_GET['invoicecode']."'
                             ORDER BY DOCUMENTCODE,JOBEND,WEIGHTIN DESC ";
         $query_seBillingnocharge = sqlsrv_query($conn, $sql_seBillingnocharge, $params_seBillingnocharge);
         while($result_seBillingnocharge = sqlsrv_fetch_array($query_seBillingnocharge, SQLSRV_FETCH_ASSOC)){

           $sql_seBillingnocharge_1 = "SELECT TOP 1  VEHICLETRANSPORTDOCUMENTDRIVERID  AS 'DRIVERID2',WEIGHTIN,JOBSTART,JOBEND,DOCUMENTCODE
                                 FROM [VEHICLETRANSPORTDOCUMENTDIRVER] a
                                 WHERE a.VEHICLETRANSPORTPLANID = '".$result_seBillingnocharge['VEHICLETRANSPORTPLANID']."' AND a.JOBEND = '".$result_seBillingnocharge['JOBEND']."'
                                 ORDER BY DOCUMENTCODE DESC";
           $query_seBillingnocharge_1 = sqlsrv_query($conn, $sql_seBillingnocharge_1, $params_seBillingnocharge_1_1);
           $result_seBillingnocharge_1 = sqlsrv_fetch_array($query_seBillingnocharge_1, SQLSRV_FETCH_ASSOC);

           $sql_seSumDifNocharge = "SELECT SUM(CONVERT(DECIMAL(10,3),a.PRICEREAL)) AS 'SUMPRICEREAL'
                             FROM TEMP_BILLINGEXCELNOCHARGE a
                             WHERE a.VEHICLETRANSPORTPLANID = '".$result_seBillingnocharge['VEHICLETRANSPORTPLANID']."' AND a.JOBEND = '".$result_seBillingnocharge['JOBEND']."' AND a.INVOICECODE = '".$_GET['invoicecode']."'";
           $query_seSumDifNocharge = sqlsrv_query($conn, $sql_seSumDifNocharge, $params_seSumDifNocharge);
           $result_seSumDifNocharge = sqlsrv_fetch_array($query_seSumDifNocharge, SQLSRV_FETCH_ASSOC);

           $sql_seDatenocharge= "SELECT FORMAT (DATEWORKING, 'dd/MM/yyyy') AS 'DATE'
                           FROM [dbo].[VEHICLETRANSPORTPLAN] a
                           WHERE a.VEHICLETRANSPORTPLANID = '".$result_seBillingnocharge['VEHICLETRANSPORTPLANID']."' ";
           $query_seDatenocharge = sqlsrv_query($conn, $sql_seDatenocharge, $params_seDatenocharge);
           $result_seDatenocharge = sqlsrv_fetch_array($query_seDatenocharge, SQLSRV_FETCH_ASSOC);


           $pricenocharge = "";
           $thainamenocharge="";
           $employeenamenocharge="";
           $pricerealnocharge="";

           if($result_seBillingnocharge['DRIVERID1'] == $result_seBillingnocharge_1['DRIVERID2'] )
           {
               $pricenocharge = $result_seBillingnocharge['PRICETON']*$result_seBillingnocharge['WEIGHTIN'];
               $thainamenocharge= $result_seBillingnocharge['THAINAME'];
               $employeenamenocharge = $result_seBillingnocharge['EMPLOYEENAME1'];

           }else {
               $pricenocharge = $result_seBillingnocharge['PRICETON']*$result_seBillingnocharge['WEIGHTIN'];
               $thainamenocharge = "";
               $employeenamenocharge ="";

           }

           /////////////////////////////////ZONE////////////////////////////////////////////////////////////
               if ($result_seBillingnocharge['LOCATION'] == 'พระประแดง/สำโรง' || $result_seBillingnocharge['LOCATION'] == 'สำโรง') {
                 $zonenc ="Somrong";
               } else if ($result_seBillingnocharge['LOCATION'] == 'บางพลี') {
                 $zonenc ="Bangplee";
               } else if ($result_seBillingnocharge['LOCATION'] == 'เทพารักษ์') {
                 if ($result_seBillingnocharge['JOBEND'] == 'HINO2') {
                  $zonenc ="Bangplee";
                 }else {
                  $zonenc ="Thepharak";
                 }

               } else if ($result_seBillingnocharge['LOCATION'] == 'ลาดกระบัง') {
                 $zonenc ="Ladkrabang";
               } else if ($result_seBillingnocharge['LOCATION'] == 'บางประกง') {
                 if ($result_seBillingnocharge['JOBEND'] == 'REFORM') {
                   $zonenc ="Wellgrow";
                 }else if ($result_seBillingnocharge['JOBEND'] == 'TOY') {
                   $zonenc ="Banpho";
                 }else {
                   $zonenc ="Bang Pakong";
                 }

               } else if ($result_seBillingnocharge['LOCATION'] == 'บ้านโพธิ์') {
                 $zonenc ="Banpho";
               } else if ($result_seBillingnocharge['LOCATION'] == 'แปลงยาว') {
                 if ($result_seBillingnocharge['JOBEND'] == 'NB-WOOD') {
                   $zonenc ="Phanat Nikhom";

                 }else {
                   $zonenc ="Gateway";
                 }

               } else if ($result_seBillingnocharge['LOCATION'] == 'บ้านบึง') {
                 $zonenc ="Banbung";
               } else if ($result_seBillingnocharge['LOCATION'] == 'ศรีราชา') {
                 $zonenc ="Sriracha";
               } else if ($result_seBillingnocharge['LOCATION'] == 'ปลวกแดง') {
                 if ($result_seBillingnocharge['JOBEND'] == 'AHT2' || $result_seBillingnocharge['JOBEND'] == 'BHKT' || $result_seBillingnocharge['JOBEND'] == 'TBFST' || $result_seBillingnocharge['JOBEND'] == 'TBFST(BOI)') {
                   $zonenc ="Eastern Seaboard IE.";
                 }else if($result_seBillingnocharge['JOBEND'] == 'ALS') {
                   $zonenc ="Borwin";
                 }else {
                   $zonenc ="Rayong";
                 }

               } else if ($result_seBillingnocharge['LOCATION'] == 'อมตะนคร') {
                 $zonenc ="Amata City Chonburi";
               } else if ($result_seBillingnocharge['LOCATION'] == 'บางปะอิน') {
                 $zonenc ="Ayutthaya";
               } else if ($result_seBillingnocharge['LOCATION'] == 'กระทุ่มแบน') {
                 $zonenc ="Prachin Buri";
               }else if ($result_seBillingnocharge['LOCATION'] == 'เทพารักษ์') {
                 $zonenc ="Samutsakorn";
               }else if ($result_seBillingnocharge['LOCATION'] == 'กบินบุรี') {
                 if ($result_seBillingnocharge['JOBEND'] == 'HISADA') {
                   $zonenc ="Prachin Buri";
                 }else {
                   $zonenc ="Kabinburi";
                 }
               }else if ($result_seBillingnocharge['LOCATION'] == 'บางบ่อ') {
                 if ($result_seBillingnocharge['JOBEND'] == 'SIMA') {
                   $zonenc ="Bangplee";
                 }else {
                   $zonenc ="Bang-bo";
                 }

               } else if ($result_seBillingnocharge['LOCATION'] == 'เมือง'){
                 if ($result_seBillingnocharge['JOBEND'] == 'SARATHORN' || $result_seBillingnocharge['JOBEND'] == 'SUNSTEEL') {
                   $zonenc = "Samutsakorn";
                 }else {
                   $zonenc = "Mueang";
                 }

               } else if($result_seBillingnocharge['LOCATION'] == 'เวลโกรว์') {
                 $zonenc = "Wellgrow";
               } else if($result_seBillingnocharge['LOCATION'] == 'สุขสวัสดิ์') {
                 $zonenc = "Sooksawat";
               } else if($result_seBillingnocharge['LOCATION'] == 'หนองแค') {
                 $zonenc = "Saraburi";
               }else if($result_seBillingnocharge['LOCATION'] == 'แปลงยาว') {
                 $zonenc = "Gateway";
               }else if($result_seBillingnocharge['LOCATION'] == 'ปู่เจ้า') {
                 $zonenc = "Poochao";
               } else {
                 $zonenc = $result_seBillingnocharge['LOCATION'];
               }

               ////////////////////////////////////////JOBEND///////////////////////////////////////////////
                 if ($result_seBillingnocharge['JOBEND'] == 'TMB') {
                   $jobendnc = "TMT/BP";
                 }else if ($result_seBillingnocharge['JOBEND'] == 'APIGO') {
                   $jobendnc = "AAPICO";
                 }else if ($result_seBillingnocharge['JOBEND'] == 'ASNO') {
                   $jobendnc = "ASNO1";
                 }else if ($result_seBillingnocharge['JOBEND'] == 'TBFST' || $result_seBillingnocharge['JOBEND'] == 'TBFST(BOI)') {
                   $jobendnc = "TBFST";
                 }else if ($result_seBillingnocharge['JOBEND'] == 'TYP') {
                   $jobendnc = "TYKP";
                 }else if ($result_seBillingnocharge['JOBEND'] == 'WFAN/R.Y.') {
                   $jobendnc = "WIREFORM";
                 }else if ($result_seBillingnocharge['JOBEND'] == 'TMG') {
                   $jobendnc = "TMT/GW";
                 }else if ($result_seBillingnocharge['JOBEND'] == 'SSSC-02') {
                   $jobendnc = "SSSC-2";
                 }else if ($result_seBillingnocharge['JOBEND'] == 'TABT/DMK') {
                   $jobendnc = "DMK";
                 }else if ($result_seBillingnocharge['JOBEND'] == 'TMS') {
                   $jobendnc = "TMT/SR";
                 }else if ($result_seBillingnocharge['JOBEND'] == 'SUNSTEEL') {
                   $jobendnc = "Sonsteel";
                 }else if ($result_seBillingnocharge['JOBEND'] == 'SRP') {
                   $jobendnc = "S.R-P";
                 }else if ($result_seBillingnocharge['JOBEND'] == 'KIT2/KIT') {
                   $jobendnc = "KIT";
                 }else if ($result_seBillingnocharge['JOBEND'] == 'SHI/SHI2') {
                   $jobendnc = "SHI(2)";
                 }else if ($result_seBillingnocharge['JOBEND'] == 'SHIROKI' || $result_seBillingnocharge['JOBEND'] == 'SHIROKI(1)') {
                   $jobendnc = "SHIROKI(1)";
                 }else if ($result_seBillingnocharge['JOBEND'] == 'YMPPD/BT') {
                   $jobendnc = "BTD";
                 }else {
                   $jobendnc = $result_seBillingnocharge['JOBEND'];
                 }
          ?>





          <tr style="border:1px solid #000;">
          <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?= $inocharge ?></td>
          <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seDatenocharge['DATE']?></td>
          <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;">STC Amata City Chonburi</td>
          <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$jobendnc?></td>
          <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$zonenc?></td>
          <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBillingnocharge['DOCUMENTCODE']?></td>
          <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$result_seBillingnocharge['WEIGHTIN']?></td>
          <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$result_seBillingnocharge['PRICETON']?></td>
          <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=number_format($pricenocharge,2)?></td>
          <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$thainamenocharge?></td>
          <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$employeenamenocharge?> </td>
          <!--<td colspan="2" style="border-right:1px solid #000;padding:5px;text-align:right;"><?//=number_format($result_seBilling10['PRICEAC'])?></td>-->


          </tr>
  <?php
  $inocharge++;
  $sumtotaltonnocharge += $result_seBillingnocharge['WEIGHTIN'];
  $sumtotalpricenocharge += $result_seBillingnocharge['PRICE'];
}
   ?>
   </tbody>
 </table>

  </body>
  </html>
