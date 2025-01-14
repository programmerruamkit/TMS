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


// $sumgmtweight = "";
// $sumcusweight = "";
// $sumamounttrip = "";
// $sumtotal = "";

// $sql_getDate = "{call megStopwork_v2(?)}";
// $params_getDate = array(
//   array('select_getdate', SQLSRV_PARAM_IN)
// );
// $query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
// $result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);


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


// $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "' ";
// $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
// $params_seEmployeeehr = array(
//     array('select_employee2', SQLSRV_PARAM_IN),
//     array($condEmployeeehr1, SQLSRV_PARAM_IN)
// );
// $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
// $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);

$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,BILLING FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '".$_GET['invoicecode']."'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);


?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
 <br>

 <table style="width: 100%;">
       <thead>
           <tr>

               <td colspan="13" style="text-align:center;font-size:18px;"><b>เอกสารแนบการวางบิลลูกค้า (คิดขั้นต่ำ) แบบใหม่</b></td>

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
 <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16;margin-top:8px;">
 <thead>
           <tr>
               <td colspan="6" style="text-align:left;font-size:16px;"><b>หมายเลขบัญชี : <?=$result_seInvoicecode['BILLING']?>  Charge 12</b></td>
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
$i12 = 1;
$sql_execTemp_billing12 = "{call megTempbilling(?,?,?,?,?,?,?)}";
$params_execTemp_billing12= array(
    array('select_tempbillingexcel12', SQLSRV_PARAM_IN),
    array($_GET['companycode'], SQLSRV_PARAM_IN),
    array($_GET['customercode'], SQLSRV_PARAM_IN),
    array($result_seInvoicecode['BILLINGDATE'], SQLSRV_PARAM_IN),
    array($result_seInvoicecode['PAYMENTDATE'], SQLSRV_PARAM_IN),
    array($result_seInvoicecode['BILLING'], SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN)
);
$query_execTemp_billing12 = sqlsrv_query($conn, $sql_execTemp_billing12, $params_execTemp_billing12);
$result_execTemp_billing12 = sqlsrv_fetch_array($query_execTemp_billing12, SQLSRV_FETCH_ASSOC);

$sql_seBilling12 = "SELECT VEHICLETRANSPORTPLANID,VEHICLETRANSPORTDOCUMENTDRIVERID AS 'DRIVERID1' , BILLINGDATE, JOBSTART, JOBEND, LOCATION, DOCUMENTCODE,
                    WEIGHTIN, PRICETON, PRICE, THAINAME, EMPLOYEENAME1, PRICEAC, PRICEREAL, BILLINGEXCEL,BILLING
                    FROM TEMP_BILLINGEXCEL12
                    WHERE BILLING='".$result_seInvoicecode['BILLING']."' AND INVOICECODE = '".$_GET['invoicecode']."'
                    ORDER BY  DOCUMENTCODE,JOBEND,WEIGHTIN ASC ";
$query_seBilling12 = sqlsrv_query($conn, $sql_seBilling12, $params_seBilling12);
while($result_seBilling12 = sqlsrv_fetch_array($query_seBilling12, SQLSRV_FETCH_ASSOC)){

    $sql_seBilling12_1 = "SELECT TOP 1  VEHICLETRANSPORTDOCUMENTDRIVERID  AS 'DRIVERID2',WEIGHTIN,JOBSTART,JOBEND,DOCUMENTCODE
                          FROM [VEHICLETRANSPORTDOCUMENTDIRVER] a
                          WHERE a.VEHICLETRANSPORTPLANID = '".$result_seBilling12['VEHICLETRANSPORTPLANID']."' AND a.JOBEND = '".$result_seBilling12['JOBEND']."'
                          ORDER BY DOCUMENTCODE DESC";
    $query_seBilling12_1 = sqlsrv_query($conn, $sql_seBilling12_1, $params_seBilling12_1);
    $result_seBilling12_1 = sqlsrv_fetch_array($query_seBilling12_1, SQLSRV_FETCH_ASSOC);

    $sql_seSumDif12 = "SELECT SUM(CONVERT(DECIMAL(10,3),a.PRICEREAL)) AS 'SUMPRICEREAL'
                      FROM TEMP_BILLINGEXCEL12 a
                      WHERE a.VEHICLETRANSPORTPLANID = '".$result_seBilling12['VEHICLETRANSPORTPLANID']."' AND a.JOBEND = '".$result_seBilling12['JOBEND']."' AND a.INVOICECODE = '".$_GET['invoicecode']."'";
    $query_seSumDif12 = sqlsrv_query($conn, $sql_seSumDif12, $params_seSumDif12);
    $result_seSumDif12 = sqlsrv_fetch_array($query_seSumDif12, SQLSRV_FETCH_ASSOC);

    $sql_seDate12 = "SELECT FORMAT (DATEWORKING, 'dd/MM/yyyy') AS 'DATE'
                    FROM [dbo].[VEHICLETRANSPORTPLAN] a
                    WHERE a.VEHICLETRANSPORTPLANID = '".$result_seBilling12['VEHICLETRANSPORTPLANID']."' ";
    $query_seDate12 = sqlsrv_query($conn, $sql_seDate12, $params_seDate12);
    $result_seDate12 = sqlsrv_fetch_array($query_seDate12, SQLSRV_FETCH_ASSOC);

    $price12 = "";
    $thainame12 ="";
    $employeename12 ="";
    $pricereal12 ="";

    if($result_seBilling12['DRIVERID1'] == $result_seBilling12_1['DRIVERID2'] )
    {
        $price12 = $result_seBilling12['PRICETON']*12;
        $thainame12 = $result_seBilling12['THAINAME'];
        $employeename12 = $result_seBilling12['EMPLOYEENAME1'];
        $pricereal12 = ($result_seSumDif12['SUMPRICEREAL']);
    }else {
      $price12 = "";
      $thainame10 = "";
      $employeename10 = "";
      $pricereal12 = "";
    }


/////////////////////////////////ZONE////////////////////////////////////////////////////////////
    if ($result_seBilling12['LOCATION'] == 'พระประแดง/สำโรง' || $result_seBilling12['LOCATION'] == 'สำโรง') {
      $zone12 ="Samrong";
    } else if ($result_seBilling12['LOCATION'] == 'บางพลี') {
      $zone12 ="Bangplee";
    } else if ($result_seBilling12['LOCATION'] == 'เทพารักษ์') {
      if ($result_seBilling12['JOBEND'] == 'HINO2') {
       $zone12 ="Bangplee";
      }else {
       $zone12 ="Thepharak";
      }

    } else if ($result_seBilling12['LOCATION'] == 'ลาดกระบัง') {
      $zone12 ="Ladkrabang";
    } else if ($result_seBilling12['LOCATION'] == 'บางประกง') {
      if ($result_seBilling12['JOBEND'] == 'REFORM') {
        $zone12 ="Wellgrow";
      }else if ($result_seBilling12['JOBEND'] == 'TOY') {
        $zone12 ="Banpho";
      }else {
        $zone12 ="Bang Pakong";
      }

    } else if ($result_seBilling12['LOCATION'] == 'บ้านโพธิ์') {
      $zone12 ="Banpho";
    } else if ($result_seBilling12['LOCATION'] == 'แปลงยาว') {
      if ($result_seBilling12['JOBEND'] == 'NB-WOOD') {
        $zone12 ="Phanat Nikhom";

      }else {
        $zone12 ="Gateway";
      }

    } else if ($result_seBilling12['LOCATION'] == 'บ้านบึง') {
      $zone12 ="Banbung";
    } else if ($result_seBilling12['LOCATION'] == 'ศรีราชา') {
      $zone12 ="Sriracha";
    } else if ($result_seBilling12['LOCATION'] == 'ปลวกแดง') {
      if ($result_seBilling12['JOBEND'] == 'AHT2' || $result_seBilling12['JOBEND'] == 'BHKT' || $result_seBilling12['JOBEND'] == 'TBFST' || $result_seBilling12['JOBEND'] == 'TBFST(BOI)') {
        $zone12 ="Eastern Seaboard IE.";
      }else if($result_seBilling12['JOBEND'] == 'ALS') {
        $zone12 ="Borwin";
      }else {
        $zone12 ="Rayong";
      }

    } else if ($result_seBilling12['LOCATION'] == 'อมตะนคร') {
      $zone12 ="Amata City Chonburi";
    } else if ($result_seBilling12['LOCATION'] == 'บางปะอิน') {
      $zone12 ="Ayutthaya";
    } else if ($result_seBilling12['LOCATION'] == 'กระทุ่มแบน') {
      $zone12 ="Prachin Buri";
    }else if ($result_seBilling12['LOCATION'] == 'เทพารักษ์') {
      $zone12 ="Samutsakorn";
    }else if ($result_seBilling12['LOCATION'] == 'กบินบุรี') {
      $zone12 ="Kabinburi";
    }else if ($result_seBilling12['LOCATION'] == 'บางบ่อ') {
      if ($result_seBilling12['JOBEND'] == 'SIMA') {
        $zone12 ="Bangplee";
      }else {
        $zone12 ="Bang-bo";
      }

    } else if ($result_seBilling12['LOCATION'] == 'เมือง'){
      if ($result_seBilling12['JOBEND'] == 'SARATHORN' || $result_seBilling12['JOBEND'] == 'SUNSTEEL' || $result_seBilling12['JOBEND'] == 'MONOSTEEL') {
        $zone12 = "Samutsakorn";
      }else if ($result_seBilling12['JOBEND'] == 'KPN' ) {
        $zone12 = "Samutprakan";
      }else if ($result_seBilling12['JOBEND'] == 'WISDOM' ) {
        $zone12 = "Chachoengsao";
      }else {
        $zone12 = "Mueang";
      }

      

    } else if($result_seBilling12['LOCATION'] == 'เวลโกรว์' || $result_seBilling12['LOCATION'] == 'เวลล์โกร์') {
      $zone12 = "Wellgrow";
    } else if($result_seBilling12['LOCATION'] == 'สุขสวัสดิ์') {
      $zone12 = "Sooksawat";
    } else if($result_seBilling12['LOCATION'] == 'หนองแค') {
      $zone12 = "Saraburi";
    }else if($result_seBilling12['LOCATION'] == 'แปลงยาว') {
      $zone12 = "Gateway";
    }else if($result_seBilling12['LOCATION'] == 'ปู่เจ้า') {
      $zone12 = "Poochao";
    }else if($result_seBilling12['LOCATION'] == 'พนัสนิคม') {
      $zone12 = "Phanat Nikhom";
    }else if($result_seBilling12['LOCATION'] == 'ประชาอุทิศ') {
      $zone12 = "Pracha Uthid";
    }else if($result_seBilling12['LOCATION'] == 'อีสเทิร์นซีบอร์ด' || $result_seBilling12['LOCATION'] == 'อีสเทิร์น ซีบอร์ด') {
      $zone12 = "Eastern Seaboard IE.";
    }else if($result_seBilling12['LOCATION'] == 'แหลมฉบัง') {
      $zone12 = "Laemchabang";
    } else {
      $zone12 = $result_seBilling12['LOCATION'];
    }

    ////////////////////////////////////////JOBEND///////////////////////////////////////////////
    if ($result_seBilling12['JOBEND'] == 'TMB') {
      $jobend12 = "TMT/BP";
    }else if ($result_seBilling12['JOBEND'] == 'APIGO') {
      $jobend12 = "AAPICO";
    }else if ($result_seBilling12['JOBEND'] == 'ASNO') {
      $jobend12 = "ASNO1";
    }else if ($result_seBilling12['JOBEND'] == 'TBFST' || $result_seBilling12['JOBEND'] == 'TBFST(BOI)') {
      $jobend12 = "TBFST";
    }else if ($result_seBilling12['JOBEND'] == 'TYP') {
      $jobend12 = "TYP";
    }else if ($result_seBilling12['JOBEND'] == 'WFAN/R.Y.') {
      $jobend12 = "WFAN/R.Y";
    }else if ($result_seBilling12['JOBEND'] == 'TMG') {
      $jobend12 = "TMT/GW";
    }else if ($result_seBilling12['JOBEND'] == 'SSSC-02') {
      $jobend12 = "SSSC-2";
    }else if ($result_seBilling12['JOBEND'] == 'TABT/DMK') {
      $jobend12 = "DMK";
    }else if ($result_seBilling12['JOBEND'] == 'TMS') {
      $jobend12 = "TMT/SR";
    }else if ($result_seBilling12['JOBEND'] == 'SUNSTEEL') {
      $jobend12 = "SUNSTEEL";
    }else if ($result_seBilling12['JOBEND'] == 'SRP') {
      $jobend12 = "S.R-P";
    }else if ($result_seBilling12['JOBEND'] == 'KIT2/KIT') {
      $jobend12 = "KIT";
    }else if ($result_seBilling12['JOBEND'] == 'SHI/SHI2') {
      $jobend12 = "SHI(2)";
    }else if ($result_seBilling12['JOBEND'] == 'SHIROKI' || $result_seBilling12['JOBEND'] == 'SHIROKI(1)') {
      $jobend12 = "SHIROKI(1)";
    }else if ($result_seBilling12['JOBEND'] == 'YMPPD/BT') {
      $jobend12 = "BTD";
    }else if ($result_seBilling12['JOBEND'] == 'TTAST-PT') {   ////////////TTASTCS(OTHER)(WEIGHT)
      $jobend12 = "TTAST-PT";
    }else if ($result_seBilling12['JOBEND'] == 'JOZU : Teparak') {
      $jobend12 = "JOZU";
    }else if ($result_seBilling12['JOBEND'] == 'KSC : Nakhonratchasima') {
      $jobend12 = "KSC";
    }else if ($result_seBilling12['JOBEND'] == 'CPS : Amatanakorn') {
      $jobend12 = "CPS";
    }else if ($result_seBilling12['JOBEND'] == 'DCL : Banbung') {
      $jobend12 = "DCL";
    }else if ($result_seBilling12['JOBEND'] == 'AAA : BanPho') {
      $jobend12 = "AAA";
    }else if ($result_seBilling12['JOBEND'] == 'NB WOOD') {
      $jobend12 = "NB WOOD";
    }else if ($result_seBilling12['JOBEND'] == 'OTC : Ladkrabang') {
      $jobend12 = "OTC";
    }else if ($result_seBilling12['JOBEND'] == 'SAM : Lamchabang') {
      $jobend12 = "SAM";
    }else if ($result_seBilling12['JOBEND'] == 'TATP : Pathum Thani') {
      $jobend12 = "TATP";
    }else if ($result_seBilling12['JOBEND'] == 'KTAC:Phanat Nikhom') {
      $jobend12 = "KTAC";
    }else if ($result_seBilling12['JOBEND'] == 'SYM : Banbung') {
      $jobend12 = "SYM";
    }else if ($result_seBilling12['JOBEND'] == 'TSK : Amatanakorn') {
      $jobend12 = "TSK";
    }else if ($result_seBilling12['JOBEND'] == 'YAMATO : Sriracha') {
      $jobend12 = "YAMATO";
    }else if ($result_seBilling12['JOBEND'] == 'YKT : Eastern Seaboard IE.') {
      $jobend12 = "YKT";
    }else if ($result_seBilling12['JOBEND'] == 'YNPN1 : Bangplee') {
      $jobend12 = "YNPN1";
    }else if ($result_seBilling12['JOBEND'] == 'YNPN2 : Bangplee') {
      $jobend12 = "YNPN2";
    }else if ($result_seBilling12['JOBEND'] == 'YNPN3 : Banpho') {
      $jobend12 = "YNPN3";
    }else if ($result_seBilling12['JOBEND'] == 'YS PUND : Wellgrow') {
      $jobend12 = "YS PUND";
    }else if ($result_seBilling12['JOBEND'] == 'JSA : Pathum Thani') {
      $jobend12 = "JSA";
    }else if ($result_seBilling12['JOBEND'] == 'KCP : Bangpakong') {
      $jobend12 = "KCP";
    }else if ($result_seBilling12['JOBEND'] == 'Korawit : Teparak') {
      $jobend12 = "Korawit";
    }else if ($result_seBilling12['JOBEND'] == 'TOKAI : Amatanakorn') {
      $jobend12 = "TOKAI";
    }else if ($result_seBilling12['JOBEND'] == 'BVS : Banpho') {
      $jobend12 = "BVS";
    }else if ($result_seBilling12['JOBEND'] == 'VCS : Banpho') {
      $jobend12 = "VCS";
    }else if ($result_seBilling12['JOBEND'] == 'SARATHORN') {
      $jobend12 = "SARATHORN";
    }else if ($result_seBilling12['JOBEND'] == 'THAI NIPPON : Lamchabang') {
      $jobend12 = "THAI NIPPON";
    }else if ($result_seBilling12['JOBEND'] == 'VORASAK : Ayutthaya') {
      $jobend12 = "VORASAK";
    }else if ($result_seBilling12['JOBEND'] == 'SSSC2 : Poochao') {
      $jobend12 = "SSSC2";
    }else if ($result_seBilling12['JOBEND'] == 'KEIHIN : Lamphun') {
      $jobend12 = "KEIHIN";
    }else if ($result_seBilling12['JOBEND'] == 'KTAC : Samutsakorn') {
      $jobend12 = "KTAC";
    }else if ($result_seBilling12['JOBEND'] == 'MONOSTEEL') {
      $jobend12 = "MONOSTEEL";
    }else if ($result_seBilling12['JOBEND'] == 'SSSC3 : Easternseaboard') {
      $jobend12 = "SSSC3";
    }else if ($result_seBilling12['JOBEND'] == 'UCC2 : Amata') {
      $jobend12 = "UCC2";
    }else if ($result_seBilling12['JOBEND'] == 'STC : Amatanakorn') {
      $jobend12 = "STC";
    }else if ($result_seBilling12['JOBEND'] == 'STE : Wellgrow') {
      $jobend12 = "STE";
    }else if ($result_seBilling12['JOBEND'] == 'WWGF1 : Bangplee') {
      $jobend12 = "WWG";
    }else if ($result_seBilling12['JOBEND'] == 'KORAWIT : Teparak') {
      $jobend12 = "KORAWIT";
    }else {
      $jobend12 = $result_seBilling12['JOBEND'];
    }
 ?>




  <tr style="border:1px solid #000;">
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?= $i12 ?></td>
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seDate12['DATE']?></td>
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;">STC Amata City Chonburi</td>
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$jobend12?></td>
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$zone12?></td>
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling12['DOCUMENTCODE']?></td>
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$result_seBilling12['WEIGHTIN']?></td>
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$result_seBilling12['PRICETON']?></td>
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$price12?></td>
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$thainame12?></td>
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=$employeename12?> </td>
  
  <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?=number_format($result_seBilling12['PRICETON']*$result_seBilling12['WEIGHTIN'],2)?> </td>
  <?php
  if ($pricereal12 == '') {
    ?>
    <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;">0.00</td>
    <?php
  }else {
    ?>
    <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:right;"><?= number_format($price12-$pricereal12,2)?> </td>
    <?php
  }
   ?>


  </tr>
  <?php
  $i12++;
  $sumtotalton12 += $result_seBilling12['WEIGHTIN'];
  $sumtotalprice12 += $result_seBilling12['PRICE'];
}
   ?>

   </tbody>
 </table>

<!-- END CHARGE 12 -->
<br><br>
 <!-- HEADER NOT CHARGE -->
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
 <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16;margin-top:8px;">
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
             array('select_tempbillingexcelnochargenew', SQLSRV_PARAM_IN),
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
                             FROM TEMP_BILLINGEXCELNOCHARGENEW
                             WHERE BILLING='".$result_seInvoicecode['BILLING']."' AND INVOICECODE = '".$_GET['invoicecode']."'
                             ORDER BY DOCUMENTCODE,JOBEND,WEIGHTIN DESC";
         $query_seBillingnocharge = sqlsrv_query($conn, $sql_seBillingnocharge, $params_seBillingnocharge);
         while($result_seBillingnocharge = sqlsrv_fetch_array($query_seBillingnocharge, SQLSRV_FETCH_ASSOC)){

           $sql_seBillingnocharge_1 = "SELECT TOP 1  VEHICLETRANSPORTDOCUMENTDRIVERID  AS 'DRIVERID2',WEIGHTIN,JOBSTART,JOBEND,DOCUMENTCODE
                                 FROM [VEHICLETRANSPORTDOCUMENTDIRVER] a
                                 WHERE a.VEHICLETRANSPORTPLANID = '".$result_seBillingnocharge['VEHICLETRANSPORTPLANID']."' AND a.JOBEND = '".$result_seBillingnocharge['JOBEND']."'
                                 ORDER BY DOCUMENTCODE DESC";
           $query_seBillingnocharge_1 = sqlsrv_query($conn, $sql_seBillingnocharge_1, $params_seBillingnocharge_1_1);
           $result_seBillingnocharge_1 = sqlsrv_fetch_array($query_seBillingnocharge_1, SQLSRV_FETCH_ASSOC);

           $sql_seSumDifNocharge = "SELECT SUM(CONVERT(DECIMAL(10,3),a.PRICEREAL)) AS 'SUMPRICEREAL'
                             FROM TEMP_BILLINGEXCELNOCHARGENEW a
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
                 $zonenc ="Samrong";
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
                 $zonenc ="Kabinburi";
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

               } else if($result_seBillingnocharge['LOCATION'] == 'เวลโกรว์' || $result_seBillingnocharge['LOCATION'] == 'เวลล์โกร์') {
                 $zonenc = "Wellgrow";
               } else if($result_seBillingnocharge['LOCATION'] == 'สุขสวัสดิ์') {
                 $zonenc = "Sooksawat";
               } else if($result_seBillingnocharge['LOCATION'] == 'หนองแค') {
                 $zonenc = "Saraburi";
               }else if($result_seBillingnocharge['LOCATION'] == 'แปลงยาว') {
                 $zonenc = "Gateway";
               }else if($result_seBillingnocharge['LOCATION'] == 'ปู่เจ้า') {
                 $zonenc = "Poochao";
               }else if($result_seBillingnocharge['LOCATION'] == 'อีสเทิร์นซีบอร์ด' || $result_seBillingnocharge['LOCATION'] == 'อีสเทิร์น ซีบอร์ด') {
                 $zonenc = "Eastern Seaboard IE.";
              }else if($result_seBillingnocharge['LOCATION'] == 'แหลมฉบัง') {
                 $zonenc = "Laemchabang";
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
                $jobendnc = "TYP";
              }else if ($result_seBillingnocharge['JOBEND'] == 'WFAN/R.Y.') {
                $jobendnc = "WFAN/R.Y.";
              }else if ($result_seBillingnocharge['JOBEND'] == 'TMG') {
                $jobendnc = "TMT/GW";
              }else if ($result_seBillingnocharge['JOBEND'] == 'SSSC-02') {
                $jobendnc = "SSSC-2";
              }else if ($result_seBillingnocharge['JOBEND'] == 'TABT/DMK') {
                $jobendnc = "DMK";
              }else if ($result_seBillingnocharge['JOBEND'] == 'TMS') {
                $jobendnc = "TMT/SR";
              }else if ($result_seBillingnocharge['JOBEND'] == 'SUNSTEEL') {
                $jobendnc = "SUNSTEEL";
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
              }else if ($result_seBillingnocharge['JOBEND'] == 'TTAST-PT') {   ////////////TTASTCS(OTHER)(WEIGHT)
               $jobendnc = "TTAST-PT";
               }else if ($result_seBillingnocharge['JOBEND'] == 'JOZU : Teparak') {
                 $jobendnc = "JOZU";
               }else if ($result_seBillingnocharge['JOBEND'] == 'KSC : Nakhonratchasima') {
                 $jobendnc = "KSC";
               }else if ($result_seBillingnocharge['JOBEND'] == 'CPS : Amatanakorn') {
                 $jobendnc = "CPS";
               }else if ($result_seBillingnocharge['JOBEND'] == 'DCL : Banbung') {
                 $jobendnc = "DCL";
               }else if ($result_seBillingnocharge['JOBEND'] == 'AAA : BanPho') {
                 $jobendnc = "AAA";
               }else if ($result_seBillingnocharge['JOBEND'] == 'NB WOOD') {
                 $jobendnc = "NB WOOD";
               }else if ($result_seBillingnocharge['JOBEND'] == 'OTC : Ladkrabang') {
                 $jobendnc = "OTC";
               }else if ($result_seBillingnocharge['JOBEND'] == 'SAM : Lamchabang') {
                 $jobendnc = "SAM";
               }else if ($result_seBillingnocharge['JOBEND'] == 'TATP : Pathum Thani') {
                 $jobendnc = "TATP";
               }else if ($result_seBillingnocharge['JOBEND'] == 'KTAC:Phanat Nikhom') {
                 $jobendnc = "KTAC";
               }else if ($result_seBillingnocharge['JOBEND'] == 'SYM : Banbung') {
                 $jobendnc = "SYM";
               }else if ($result_seBillingnocharge['JOBEND'] == 'TSK : Amatanakorn') {
                 $jobendnc = "TSK";
               }else if ($result_seBillingnocharge['JOBEND'] == 'YAMATO : Sriracha') {
                 $jobendnc = "YAMATO";
               }else if ($result_seBillingnocharge['JOBEND'] == 'YKT : Eastern Seaboard IE.') {
                 $jobendnc = "YKT";
               }else if ($result_seBillingnocharge['JOBEND'] == 'YNPN1 : Bangplee') {
                 $jobendnc = "YNPN1";
               }else if ($result_seBillingnocharge['JOBEND'] == 'YNPN2 : Bangplee') {
                 $jobendnc = "YNPN2";
               }else if ($result_seBillingnocharge['JOBEND'] == 'YNPN3 : Banpho') {
                 $jobendnc = "YNPN3";
               }else if ($result_seBillingnocharge['JOBEND'] == 'YS PUND : Wellgrow') {
                 $jobendnc = "YS PUND";
               }else if ($result_seBillingnocharge['JOBEND'] == 'JSA : Pathum Thani') {
                 $jobendnc = "JSA";
               }else if ($result_seBillingnocharge['JOBEND'] == 'KCP : Bangpakong') {
                 $jobendnc = "KCP";
               }else if ($result_seBillingnocharge['JOBEND'] == 'Korawit : Teparak') {
                 $jobendnc = "Korawit";
               }else if ($result_seBillingnocharge['JOBEND'] == 'TOKAI : Amatanakorn') {
                 $jobendnc = "TOKAI";
               }else if ($result_seBillingnocharge['JOBEND'] == 'BVS : Banpho') {
                 $jobendnc = "BVS";
               }else if ($result_seBillingnocharge['JOBEND'] == 'VCS : Banpho') {
                 $jobendnc = "VCS";
               }else if ($result_seBillingnocharge['JOBEND'] == 'SARATHORN') {
                 $jobendnc = "SARATHORN";
               }else if ($result_seBillingnocharge['JOBEND'] == 'THAI NIPPON : Lamchabang') {
                 $jobendnc = "THAI NIPPON";
               }else if ($result_seBillingnocharge['JOBEND'] == 'VORASAK : Ayutthaya') {
                 $jobendnc = "VORASAK";
               }else if ($result_seBillingnocharge['JOBEND'] == 'SSSC2 : Poochao') {
                 $jobendnc = "SSSC2";
               }else if ($result_seBillingnocharge['JOBEND'] == 'KEIHIN : Lamphun') {
                 $jobendnc = "KEIHIN";
               }else if ($result_seBillingnocharge['JOBEND'] == 'KTAC : Samutsakorn') {
                 $jobendnc = "KTAC";
               }else if ($result_seBillingnocharge['JOBEND'] == 'MONOSTEEL') {
                 $jobendnc = "MONOSTEEL";
               }else if ($result_seBillingnocharge['JOBEND'] == 'SSSC3 : Easternseaboard') {
                 $jobendnc = "SSSC3";
               }else if ($result_seBillingnocharge['JOBEND'] == 'UCC2 : Amata') {
                 $jobendnc = "UCC2";
               }else if ($result_seBillingnocharge['JOBEND'] == 'STC : Amatanakorn') {
                 $jobendnc = "STC";
               }else if ($result_seBillingnocharge['JOBEND'] == 'STE : Wellgrow') {
                 $jobendnc = "STE";
               }else if ($result_seBillingnocharge['JOBEND'] == 'WWGF1 : Bangplee') {
                 $jobendnc = "WWG";
               }else if ($result_seBillingnocharge['JOBEND'] == 'KORAWIT : Teparak') {
                 $jobendnc = "KORAWIT";
               }else  {
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
