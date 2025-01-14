<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['invoicecode'] == "" || $_GET['invoicecode'] == "") {
  $strExcelFileName = "RKRTTTCSTC_Billing.xls";
} else {
  $strExcelFileName = "RKRTTTCSTC_Billing" . $_GET['invoicecode'] . ".xls";
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

$sql_seInvoice = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,BILLING,DULYDATE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '" . $_GET['invoicecode'] . "'";
$params_seInvoic = array();
$query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoic);
$result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC);


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
<td colspan="12" style="text-align:center;font-size:18px;"><b>รายงานสรุปรายการวางบิลลูกค้า</b></td>

</thead>
<tbody>
<tr>
<td colspan="12" style="text-align:center;font-size:12px;"><b><?= $result_seInvoice['BILLINGDATE'] ?> - <?= $result_seInvoice['PAYMENTDATE'] ?> (ค่าขนส่งปกติ)</b></td>
</tr>

<tr>
<td colspan="12">&nbsp;</td>
</tr>

</tbody>
</table>

<?php
$i = 1;
$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,BILLING FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '" . $_GET['invoicecode'] . "'";

$query_seInvoicecode  = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);

$sql_execTemp_billing = "{call megTempbilling(?,?,?,?,?,?,?)}";
$params_execTemp_billing = array(
    array('select_tempbilling', SQLSRV_PARAM_IN),
    array($_GET['companycode'], SQLSRV_PARAM_IN),
    array($_GET['customercode'], SQLSRV_PARAM_IN),
    array($result_seInvoicecode['BILLINGDATE'], SQLSRV_PARAM_IN),
    array($result_seInvoicecode['PAYMENTDATE'], SQLSRV_PARAM_IN),
    array($result_seInvoicecode['BILLING'], SQLSRV_PARAM_IN),
    array($_GET['invoicecode'], SQLSRV_PARAM_IN)
);
$query_execTemp_billing   = sqlsrv_query($conn, $sql_execTemp_billing, $params_execTemp_billing);
$result_execTemp_billing  = sqlsrv_fetch_array($query_execTemp_billing, SQLSRV_FETCH_ASSOC);



?>



<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;margin-top:8px;">
   <thead>
  <tr>
    <td colspan="12" style="text-align:left;font-size:18px;"><b>หมายเลขบัญชี :<?= $result_seInvoice['BILLING'] ?></b></td>
  </tr>
  <tr style="border:1px solid #000;padding:4px;">
    <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>วันที่ใบแจ้งหนี้</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ใบแจ้งหนี้</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ประเภทรถ</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>จาก</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ถึง</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;"><b>Zone</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ปริมาณ(ตัน)</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>อัตรา(บาท/ตัน)</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ราคา(บาท)</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ราคาจริง(บาท)</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ผลต่าง</b></td>
    <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>หมายเหตุ</b></td>
  </tr>
  </thead><tbody>
<?php

$sql_seBilling1 = "SELECT BILLINGDATE, INVOICECODE, NUMBER, JOBSTART, JOBEND, LOCATION, PRICETON, REMARK, BILLING
FROM TEMP_BILLING
WHERE INVOICECODE = '" . $_GET['invoicecode'] . "'
GROUP BY BILLINGDATE, INVOICECODE, NUMBER, JOBSTART, JOBEND, LOCATION, PRICETON, REMARK, BILLING ORDER BY REMARK DESC";

$query_seBilling1 = sqlsrv_query($conn, $sql_seBilling1, $params_seBilling1);
while ($result_seBilling1 = sqlsrv_fetch_array($query_seBilling1, SQLSRV_FETCH_ASSOC)) {

    //echo $sql_seBilling2 = "SELECT SUM(CONVERT(DECIMAL(10,3),WEIGHTIN)/1000) AS 'WEIGHTIN' FROM [VEHICLETRANSPORTDOCUMENTDIRVER] b
    //INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
    //WHERE c.COMPANYCODE = '".$_GET['companycode']."' AND c.CUSTOMERCODE = '".$_GET['customercode']."'
    //AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103)
    //AND b.JOBSTART = '".$result_seBilling1['JOBSTART']."' AND b.JOBEND = '".$result_seBilling1['JOBEND']."' AND CONVERT(DECIMAL(10,3),b.ACTUALPRICEHEAD) = '".$result_seBilling1['PRICE']."'";
    //SELECT VEHICLETRANSPORTPLANID,ACTUALPRICEHEAD AS 'PRICE', BILLINGDATE, INVOICECODE, NUMBER, JOBSTART, JOBEND, LOCATION, PRICETON, REMARK, BILLING FROM TEMP_BILLING
    //WHERE JOBSTART = 'TTAST-STC' AND JOBEND = 'SHIROKI' AND REMARK = 'Charge 7'

/////////////////////////////////ZONE////////////////////////////////////////////////////////////
    if ($result_seBilling1['LOCATION'] == 'พระประแดง/สำโรง' || $result_seBilling1['LOCATION'] == 'สำโรง') {
      $zone ="Samrong";
    } else if ($result_seBilling1['LOCATION'] == 'บางพลี') {
      $zone ="Bangplee";
    } else if ($result_seBilling1['LOCATION'] == 'เทพารักษ์') {
      if ($result_seBilling1['JOBEND'] == 'HINO2') {
       $zone ="Bangplee";
      }else {
       $zone ="Thepharak";
      }

    } else if ($result_seBilling1['LOCATION'] == 'ลาดกระบัง') {
      $zone ="Ladkrabang";
    } else if ($result_seBilling1['LOCATION'] == 'บางประกง') {
      if ($result_seBilling1['JOBEND'] == 'REFORM') {
        $zone ="Wellgrow";
      }else if ($result_seBilling1['JOBEND'] == 'TOY') {
        $zone ="Banpho";
      }else {
        $zone ="Bang Pakong";
      }

    } else if ($result_seBilling1['LOCATION'] == 'บ้านโพธิ์') {
      $zone ="Banpho";
    } else if ($result_seBilling1['LOCATION'] == 'แปลงยาว') {
      if ($result_seBilling1['JOBEND'] == 'NB-WOOD') {
        $zone ="Phanat Nikhom";

      }else {
        $zone ="Gateway";
      }

    } else if ($result_seBilling1['LOCATION'] == 'บ้านบึง') {
      $zone ="Banbung";
    } else if ($result_seBilling1['LOCATION'] == 'ศรีราชา') {
      $zone ="Sriracha";
    } else if ($result_seBilling1['LOCATION'] == 'ปลวกแดง') {
      if ($result_seBilling1['JOBEND'] == 'AHT2' || $result_seBilling1['JOBEND'] == 'BHKT' || $result_seBilling1['JOBEND'] == 'TBFST' || $result_seBilling1['JOBEND'] == 'TBFST(BOI)'|| $result_seBilling1['JOBEND'] == 'FTS2'|| $result_seBilling1['JOBEND'] == 'FTS1') {
        $zone ="Eastern Seaboard IE.";
      }else if($result_seBilling1['JOBEND'] == 'ALS') {
        $zone ="Borwin";
      }else {
        $zone ="Rayong";
      }

    } else if ($result_seBilling1['LOCATION'] == 'อมตะนคร') {
      $zone ="Amata City Chonburi";
    } else if ($result_seBilling1['LOCATION'] == 'บางปะอิน') {
      $zone ="Ayutthaya";
    } else if ($result_seBilling1['LOCATION'] == 'กระทุ่มแบน') {
      $zone ="Samutsakorn";
    }else if ($result_seBilling1['LOCATION'] == 'เทพารักษ์') {
      $zone ="Samutsakorn";
    }else if ($result_seBilling1['LOCATION'] == 'กบินบุรี') {
      $zone ="Kabinburi";
    }else if ($result_seBilling1['LOCATION'] == 'บางบ่อ') {
      if ($result_seBilling1['JOBEND'] == 'SIMA') {
        $zone ="Bangplee";
      }else {
        $zone ="Bang-bo";
      }

    } else if ($result_seBilling1['LOCATION'] == 'เมือง'){
      if ($result_seBilling1['JOBEND'] == 'SARATHORN' || $result_seBilling1['JOBEND'] == 'SUNSTEEL' || $result_seBilling1['JOBEND'] == 'MONOSTEEL') {
        $zone = "Samutsakorn";
      }else if ($result_seBilling1['JOBEND'] == 'KPN' ) {
        $zone = "Samutprakan";
      }else if ($result_seBilling1['JOBEND'] == 'WISDOM' ) {
        $zone = "Chachoengsao";
      }else {
        $zone = "Mueang";
      }

    } else if($result_seBilling1['LOCATION'] == 'เวลโกรว์' || $result_seBilling1['LOCATION'] == 'เวลล์โกร์') {
      $zone = "Wellgrow";
    } else if($result_seBilling1['LOCATION'] == 'สุขสวัสดิ์') {
      $zone = "Sooksawat";
    } else if($result_seBilling1['LOCATION'] == 'หนองแค') {
      $zone = "Saraburi";
    }else if($result_seBilling1['LOCATION'] == 'แปลงยาว') {
      $zone = "Gateway";
    }else if($result_seBilling1['LOCATION'] == 'ปู่เจ้า') {
      $zone = "Poochao";
    }else if($result_seBilling1['LOCATION'] == 'พนัสนิคม') {
      $zone = "Phanat Nikhom";
    }else if($result_seBilling1['LOCATION'] == 'ประชาอุทิศ') {
      $zone = "Pracha Uthid";
    }else if($result_seBilling1['LOCATION'] == 'อีสเทิร์นซีบอร์ด' || $result_seBilling1['LOCATION'] == 'อีสเทิร์น ซีบอร์ด') {
      $zone = "Eastern Seaboard IE";
    }else if($result_seBilling1['LOCATION'] == 'แหลมฉบัง') {
      $zone = "Laemchabang";
    } else {
      $zone = $result_seBilling1['LOCATION'];
    }



////////////////////////////////////////JOBEND///////////////////////////////////////////////
  if ($result_seBilling1['JOBEND'] == 'TMB') {
    $jobend = "TMT/BP";
  }else if ($result_seBilling1['JOBEND'] == 'APIGO') {
    $jobend = "AAPICO";
  }else if ($result_seBilling1['JOBEND'] == 'ASNO') {
    $jobend = "ASNO1";
  }else if ($result_seBilling1['JOBEND'] == 'TBFST' || $result_seBilling1['JOBEND'] == 'TBFST(BOI)') {
    $jobend = "TBFST";
  }else if ($result_seBilling1['JOBEND'] == 'TYP') {
    $jobend = "TYP";
  }else if ($result_seBilling1['JOBEND'] == 'WFAN/R.Y.') {
    $jobend = "WFAN/R.Y.";
  }else if ($result_seBilling1['JOBEND'] == 'TMG') {
    $jobend = "TMT/GW";
  }else if ($result_seBilling1['JOBEND'] == 'SSSC-02') {
    $jobend = "SSSC-2";
  }else if ($result_seBilling1['JOBEND'] == 'TABT/DMK') {
    $jobend = "DMK";
  }else if ($result_seBilling1['JOBEND'] == 'TMS') {
    $jobend = "TMT/SR";
  }else if ($result_seBilling1['JOBEND'] == 'SUNSTEEL') {
    $jobend = "SUNSTEEL";
  }else if ($result_seBilling1['JOBEND'] == 'SRP') {
    $jobend = "S.R-P";
  }else if ($result_seBilling1['JOBEND'] == 'KIT2/KIT') {
    $jobend = "KIT";
  }else if ($result_seBilling1['JOBEND'] == 'SHI/SHI2') {
    $jobend = "SHI(2)";
  }else if ($result_seBilling1['JOBEND'] == 'SHIROKI' || $result_seBilling1['JOBEND'] == 'SHIROKI(1)') {
    $jobend = "SHIROKI(1)";
  }else if ($result_seBilling1['JOBEND'] == 'YMPPD/BT') {
    $jobend = "BTD";
  }else if ($result_seBilling1['JOBEND'] == 'TTAST-PT') {   ////////////TTASTCS(OTHER)(WEIGHT)
    $jobend = "TTAST-PT";
  }else if ($result_seBilling1['JOBEND'] == 'JOZU : Teparak') {
    $jobend = "JOZU";
  }else if ($result_seBilling1['JOBEND'] == 'KSC : Nakhonratchasima') {
    $jobend = "KSC";
  }else if ($result_seBilling1['JOBEND'] == 'CPS : Amatanakorn') {
    $jobend = "CPS";
  }else if ($result_seBilling1['JOBEND'] == 'DCL : Banbung') {
    $jobend = "DCL";
  }else if ($result_seBilling1['JOBEND'] == 'AAA : BanPho') {
    $jobend = "AAA";
  }else if ($result_seBilling1['JOBEND'] == 'NB WOOD') {
    $jobend = "NB WOOD";
  }else if ($result_seBilling1['JOBEND'] == 'OTC : Ladkrabang') {
    $jobend = "OTC";
  }else if ($result_seBilling1['JOBEND'] == 'SAM : Laemchabang') {
    $jobend = "SAM";
  }else if ($result_seBilling1['JOBEND'] == 'TATP : Pathum Thani') {
    $jobend = "TATP";
  }else if ($result_seBilling1['JOBEND'] == 'KTAC:Phanat Nikhom') {
    $jobend = "KTAC";
  }else if ($result_seBilling1['JOBEND'] == 'SYM : Banbung') {
    $jobend = "SYM";
  }else if ($result_seBilling1['JOBEND'] == 'TSK : Amatanakorn') {
    $jobend = "TSK";
  }else if ($result_seBilling1['JOBEND'] == 'YAMATO : Sriracha') {
    $jobend = "YAMATO";
  }else if ($result_seBilling1['JOBEND'] == 'YKT : Eastern Seaboard IE.') {
    $jobend = "YKT";
  }else if ($result_seBilling1['JOBEND'] == 'YNPN1 : Bangplee') {
    $jobend = "YNPN1";
  }else if ($result_seBilling1['JOBEND'] == 'YNPN2 : Bangplee') {
    $jobend = "YNPN2";
  }else if ($result_seBilling1['JOBEND'] == 'YNPN3 : Banpho') {
    $jobend = "YNPN3";
  }else if ($result_seBilling1['JOBEND'] == 'YS PUND : Wellgrow') {
    $jobend = "YS PUND";
  }else if ($result_seBilling1['JOBEND'] == 'JSA : Pathum Thani') {
    $jobend = "JSA";
  }else if ($result_seBilling1['JOBEND'] == 'KCP : Bangpakong') {
    $jobend = "KCP";
  }else if ($result_seBilling1['JOBEND'] == 'Korawit : Teparak') {
    $jobend = "Korawit";
  }else if ($result_seBilling1['JOBEND'] == 'TOKAI : Amatanakorn') {
    $jobend = "TOKAI";
  }else if ($result_seBilling1['JOBEND'] == 'BVS : Banpho') {
    $jobend = "BVS";
  }else if ($result_seBilling1['JOBEND'] == 'VCS : Banpho') {
    $jobend = "VCS";
  }else if ($result_seBilling1['JOBEND'] == 'SARATHORN') {
    $jobend = "SARATHORN";
  }else if ($result_seBilling1['JOBEND'] == 'THAI NIPPON : Laemchabang') {
    $jobend = "THAI NIPPON";
  }else if ($result_seBilling1['JOBEND'] == 'VORASAK : Ayutthaya') {
    $jobend = "VORASAK";
  }else if ($result_seBilling1['JOBEND'] == 'SSSC2 : Poochao') {
    $jobend = "SSSC2";
  }else if ($result_seBilling1['JOBEND'] == 'KEIHIN : Lamphun') {
    $jobend = "KEIHIN";
  }else if ($result_seBilling1['JOBEND'] == 'KTAC : Samutsakorn') {
    $jobend = "KTAC";
  }else if ($result_seBilling1['JOBEND'] == 'MONOSTEEL') {
    $jobend = "MONOSTEEL";
  }else if ($result_seBilling1['JOBEND'] == 'SSSC3 : Easternseaboard') {
    $jobend = "SSSC3";
  }else if ($result_seBilling1['JOBEND'] == 'UCC2 : Amata') {
    $jobend = "UCC2";
  }else if ($result_seBilling1['JOBEND'] == 'STC : Amatanakorn') {
    $jobend = "STC";
  }else if ($result_seBilling1['JOBEND'] == 'STE : Wellgrow') {
    $jobend = "STE";
  }else if ($result_seBilling1['JOBEND'] == 'WWGF1 : Bangplee') {
    $jobend = "WWG";
  }else if ($result_seBilling1['JOBEND'] == 'KORAWIT : Teparak') {
    $jobend = "KORAWIT";
  }else {
    $jobend = $result_seBilling1['JOBEND'];
  }




    $sql_seBilling3 = "SELECT SUM(CONVERT(DECIMAL(10,3),CASE WHEN [WEIGHTIN] IS NULL THEN 0 ELSE [WEIGHTIN] END)/1000) AS 'WEIGHTIN'
      FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER]
      WHERE [VEHICLETRANSPORTPLANID] IN (
      SELECT VEHICLETRANSPORTPLANID FROM TEMP_BILLING
      WHERE REMARK = '" . $result_seBilling1['REMARK'] . "' AND JOBSTART = '" . $result_seBilling1['JOBSTART'] . "' AND JOBEND = '" . $result_seBilling1['JOBEND'] . "')
      AND JOBSTART = '" . $result_seBilling1['JOBSTART'] . "' AND JOBEND = '" . $result_seBilling1['JOBEND'] . "'";
    $query_seBilling3 = sqlsrv_query($conn, $sql_seBilling3, $params_seBilling3);
    $result_seBilling3 = sqlsrv_fetch_array($query_seBilling3, SQLSRV_FETCH_ASSOC);

    $sql_seBilling4 = "SELECT DISTINCT SUM(CONVERT(DECIMAL(10,3),ACTUALPRICEHEAD)) AS 'PRICE' FROM TEMP_BILLING
      WHERE JOBSTART = '" . $result_seBilling1['JOBSTART'] . "' AND JOBEND = '" . $result_seBilling1['JOBEND'] . "'";
    $query_seBilling4 = sqlsrv_query($conn, $sql_seBilling4, $params_seBilling4);
    $result_seBilling4 = sqlsrv_fetch_array($query_seBilling4, SQLSRV_FETCH_ASSOC);

    $priceac = number_format($result_seBilling3['WEIGHTIN'], 3) * $result_seBilling1['PRICETON'];

    if ($result_seBilling1['REMARK'] == 'CHARGE 12') {
        $sql_seCnt12 = "SELECT COUNT(*) 'CNT' FROM TEMP_BILLING
        WHERE JOBSTART = '" . $result_seBilling1['JOBSTART'] . "' AND JOBEND = '" . $result_seBilling1['JOBEND'] . "' AND REMARK = 'CHARGE 12'";
        $query_seCnt12 = sqlsrv_query($conn, $sql_seCnt12, $params_seCnt12);
        $result_seCnt12 = sqlsrv_fetch_array($query_seCnt12, SQLSRV_FETCH_ASSOC);

        $price = (($result_seBilling1['PRICETON'] * 12) * $result_seCnt12['CNT']);
    } else {
        $price = $result_seBilling1['PRICETON'] * $result_seBilling3['WEIGHTIN'];
    }

    $pricebt = "";
    $difference = "";

    if ($result_seBilling1['REMARK'] == 'NOT CHARGE') {
        $pricebt = "-";
        $difference = "-";
    } else {
        $pricebt = number_format($result_seBilling3['WEIGHTIN'] * $result_seBilling1['PRICETON'],2);
        $difference = number_format($price - (($result_seBilling3['WEIGHTIN']) * ($result_seBilling1['PRICETON'])),2);
    }

 ?>
  <tr style="border:1px solid #000;">
  <td style="border-right:1px solid #000;padding:5px;text-align:center;"><?= $result_seInvoice['DULYDATE'] ?></td>
  <td style="border-right:1px solid #000;padding:5px;text-align:center;"><?= $result_seBilling1['INVOICECODE'] ?></td>
  <td style="border-right:1px solid #000;padding:5px;text-align:center;">10 W</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:center;">CS <br>Wellgrow</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:center;"><?= $jobend ?></td>
  <td style="border-right:1px solid #000;padding:5px;text-align:center;"><?= $zone ?></td>
  <td style="border-right:1px solid #000;padding:5px;text-align:right;"><?= number_format($result_seBilling3['WEIGHTIN'], 3) ?></td>
  <td style="border-right:1px solid #000;padding:5px;text-align:right;"><?= $result_seBilling1['PRICETON'] ?></td>
  <td style="border-right:1px solid #000;padding:5px;text-align:right;"><?= number_format($price, 2) ?></td>
  <td style="border-right:1px solid #000;padding:5px;text-align:right;"><?= $pricebt?></td>
  <td style="border-right:1px solid #000;padding:5px;text-align:right;"><?= $difference ?>  </td>
  <td style="border-right:1px solid #000;padding:5px;text-align:center;"><?= $result_seBilling1['REMARK'] ?></td>
  </tr>
<?php
    $i++;
    $sumtotalton = $sumtotalton + $result_seBilling3['WEIGHTIN'];
    $sumtotalprice = $sumtotalprice + $price;
}
?>
</tbody><tfoot>
<tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>รวม<b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;"><b><?= number_format($sumtotalton, 3) ?></td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
<td style="border-right:1px solid #000;padding:5px;text-align:right;"><b><?= number_format($sumtotalprice, 2) ?></td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
</tr>
</tfoot>


</table>

<table style="width: 100%;">
<tbody>
<tr>
<td colspan="4">&nbsp;</td>
</tr>
<tr>
<td colspan="4">&nbsp;</td>
</tr>
<tr>
<td colspan="4">&nbsp;</td>
</tr>
<tr>
<td colspan="4">&nbsp;</td>
</tr>

<tr>
<td style="width: 10%;text-align:right">ผู้จัดทำ</td>
<td style="width: 25%;">........................................</td>
<td style="width: 15%;text-align:right">ผู้ตรวจสอบ</td>
<td style="width: 20%;">........................................</td>
<td style="width: 10%;text-align:right">ผู้อนุมัติ</td>
<td style="width: 20%;">........................................</td>
</tr>



</tbody>
</table>

</body>
</html>
