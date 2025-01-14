<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
$sumgmtweight = "";
$sumcusweight = "";
$sumamounttrip = "";
$sumtotal = "";
if ($_GET['startdate'] == "" || $_GET['enddate'] == "") {
    $date_now = "";
} else {
    $date_now = $_GET['startdate'] . '-' . $_GET['enddate'];
}

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$sql_seInvoice = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,BILLING,DULYDATE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '" . $_GET['invoicecode'] . "'";
$params_seInvoic = array();
$query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoic);
$result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC);

// $condBilling1 = " AND c.COMPANYCODE = '" . $_GET['companycode'] . "' AND c.CUSTOMERCODE = '" . $_GET['customercode'] . "'";
// $condBilling2 = " AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'" . $result_seInvoicecode['BILLINGDATE'] . "',103) AND CONVERT(DATE,'" . $result_seInvoicecode['PAYMENTDATE'] . "',103) ";
//
// $sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
// $params_seBillings = array(
//     array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
//     array($condBilling1, SQLSRV_PARAM_IN),
//     array($condBilling2, SQLSRV_PARAM_IN)
// );
// $query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
// $result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);


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


//$invoicecode = create_invoice();

$mpdf = new mPDF('th', 'A4', '0', '');
$style = '
<style>
body{
  font-family: "Garuda";font-size:14px//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
}
</style>';



$table_header1 = '<table style="width: 100%;">
<thead>
<tr>
<td colspan="2" style="text-align:center;font-size:18px;"><b>รายงานสรุปรายการวางบิลลูกค้าrrrr</b></td>

</thead>
<tbody>
<tr>
<td colspan="2" style="text-align:center;font-size:12px;"><b>' . $result_seInvoice['BILLINGDATE'] . ' - ' . $result_seInvoice['PAYMENTDATE'] . ' (ค่าขนส่งปกติ)</b></td>
</tr>

<tr>
<td colspan="2">&nbsp;</td>
</tr>

</tbody>
</table>';


$i = 1;
$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,BILLING FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '" . $_GET['invoicecode'] . "'";

$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
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
$query_execTemp_billing = sqlsrv_query($conn, $sql_execTemp_billing, $params_execTemp_billing);
$result_execTemp_billing = sqlsrv_fetch_array($query_execTemp_billing, SQLSRV_FETCH_ASSOC);



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
      if ($result_seBilling1['JOBEND'] == 'AHT2' || $result_seBilling1['JOBEND'] == 'BHKT' || $result_seBilling1['JOBEND'] == 'TBFST' || $result_seBilling1['JOBEND'] == 'TBFST(BOI)') {
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
      $zone ="Prachin Buri";
    }else if ($result_seBilling1['LOCATION'] == 'เทพารักษ์') {
      $zone ="Samutsakorn";
    }else if ($result_seBilling1['LOCATION'] == 'กบินบุรี') {
      if ($result_seBilling1['JOBEND'] == 'HISADA') {
          $zone ="Prachin Buri";
      }else {
          $zone ="Kabinburi";
      }


    }else if ($result_seBilling1['LOCATION'] == 'บางบ่อ') {
      if ($result_seBilling1['JOBEND'] == 'SIMA') {
        $zone ="Bangplee";
      }else {
        $zone ="Bang-bo";
      }

    } else if ($result_seBilling1['LOCATION'] == 'เมือง'){
      if ($result_seBilling1['JOBEND'] == 'SARATHORN' || $result_seBilling1['JOBEND'] == 'SUNSTEEL') {
        $zone = "Samutsakorn";
      }else {
        $zone = "Mueang";
      }

    } else if($result_seBilling1['LOCATION'] == 'เวลโกรว์') {
      $zone = "Wellgrow";
    } else if($result_seBilling1['LOCATION'] == 'สุขสวัสดิ์') {
      $zone = "Sooksawat";
    } else if($result_seBilling1['LOCATION'] == 'หนองแค') {
      $zone = "Saraburi";
    }else if($result_seBilling1['LOCATION'] == 'แปลงยาว') {
      $zone = "Gateway";
    }else if($result_seBilling1['LOCATION'] == 'ปู่เจ้า') {
      $zone = "Poochao";
    } else {
      $zone = $result_seBilling1['LOCATION'];
    }

////////////////////////////////////////JOBEND///////////////////////////////////////////////
  if ($result_seBilling1['JOBEND'] == 'TMB') {
    $jobend = "TMB";
  }else if ($result_seBilling1['JOBEND'] == 'APIGO') {
    $jobend = "AAPICO";
  }else if ($result_seBilling1['JOBEND'] == 'ASNO') {
    $jobend = "ASNO1";
  }else if ($result_seBilling1['JOBEND'] == 'TBFST' || $result_seBilling1['JOBEND'] == 'TBFST(BOI)') {
    $jobend = "TBFST";
  }else if ($result_seBilling1['JOBEND'] == 'TYP') {
    $jobend = "TYKP";
  }else if ($result_seBilling1['JOBEND'] == 'WFAN/R.Y.') {
    $jobend = "WIREFORM";
  }else if ($result_seBilling1['JOBEND'] == 'TMG') {
    $jobend = "TMT/GW";
  }else if ($result_seBilling1['JOBEND'] == 'SSSC-02') {
    $jobend = "SSSC-2";
  }else if ($result_seBilling1['JOBEND'] == 'TABT/DMK') {
    $jobend = "DMK";
  }else if ($result_seBilling1['JOBEND'] == 'TMS') {
    $jobend = "TMT/SR";
  }else if ($result_seBilling1['JOBEND'] == 'SUNSTEEL') {
    $jobend = "Sonsteel";
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
  }else {
    $jobend = $result_seBilling1['JOBEND'];
  }




    $sql_seBilling3 = "SELECT SUM(CONVERT(DECIMAL(10,3),CASE WHEN [WEIGHTIN] IS NULL THEN 0 ELSE [WEIGHTIN] END)/1000) AS 'WEIGHTIN'  FROM
    [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] WHERE [VEHICLETRANSPORTPLANID] IN (SELECT VEHICLETRANSPORTPLANID FROM TEMP_BILLING
    WHERE REMARK = '" . $result_seBilling1['REMARK'] . "' AND JOBSTART = '" . $result_seBilling1['JOBSTART'] . "' AND JOBEND = '" . $result_seBilling1['JOBEND'] . "') AND JOBSTART = '" . $result_seBilling1['JOBSTART'] . "' AND JOBEND = '" . $result_seBilling1['JOBEND'] . "'";
    $query_seBilling3 = sqlsrv_query($conn, $sql_seBilling3, $params_seBilling3);
    $result_seBilling3 = sqlsrv_fetch_array($query_seBilling3, SQLSRV_FETCH_ASSOC);

    $sql_seBilling4 = "SELECT DISTINCT SUM(CONVERT(DECIMAL(10,3),ACTUALPRICEHEAD)) AS 'PRICE' FROM TEMP_BILLING
    WHERE JOBSTART = '" . $result_seBilling1['JOBSTART'] . "' AND JOBEND = '" . $result_seBilling1['JOBEND'] . "'";
    $query_seBilling4 = sqlsrv_query($conn, $sql_seBilling4, $params_seBilling4);
    $result_seBilling4 = sqlsrv_fetch_array($query_seBilling4, SQLSRV_FETCH_ASSOC);




    $table_begin1 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">';
    $thead1 = '<thead>
  <tr>
  <td colspan="10" style="text-align:left;font-size:16px;"><b>หมายเลขบัญชี :' . $result_seInvoice['BILLING'] . ' Charge 10 </b></td>
  </tr>
  <tr style="border:1px solid #000;padding:4px;">

  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>วันที่ใบแจ้งหนี้</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ใบแจ้งหนี้</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ประเภทรถ</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>จาก</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ถึง</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;"><b>Zone</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ปริมาณ(ตัน)</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>อัตรา(บาท/ตัน)</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ราคา(บาท)</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ราคาจริง(บาท)</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ผลต่าง</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>หมายเหตุ</b></td>
  </tr>
  </thead><tbody>';

    $priceac = number_format($result_seBilling3['WEIGHTIN'], 3) * $result_seBilling1['PRICETON'];
    if ($result_seBilling1['REMARK'] == 'Charge 10') {
        $sql_seCnt10 = "SELECT COUNT(*) 'CNT' FROM TEMP_BILLING
    WHERE JOBSTART = '" . $result_seBilling1['JOBSTART'] . "' AND JOBEND = '" . $result_seBilling1['JOBEND'] . "' AND REMARK = 'Charge 10'";
        $query_seCnt10 = sqlsrv_query($conn, $sql_seCnt10, $params_seCnt10);
        $result_seCnt10 = sqlsrv_fetch_array($query_seCnt10, SQLSRV_FETCH_ASSOC);

        $price = (($result_seBilling1['PRICETON'] * 10) * $result_seCnt10['CNT']);
    } else if ($result_seBilling1['REMARK'] == 'Charge 7') {
        $sql_seCnt7 = "SELECT COUNT(*) 'CNT' FROM TEMP_BILLING
    WHERE JOBSTART = '" . $result_seBilling1['JOBSTART'] . "' AND JOBEND = '" . $result_seBilling1['JOBEND'] . "' AND REMARK = 'Charge 7'";
        $query_seCnt7 = sqlsrv_query($conn, $sql_seCnt7, $params_seCnt7);
        $result_seCnt7 = sqlsrv_fetch_array($query_seCnt7, SQLSRV_FETCH_ASSOC);
        $price = (($result_seBilling1['PRICETON'] * 7) * $result_seCnt7['CNT']);
    } else {
        $price = $result_seBilling1['PRICETON'] * $result_seBilling3['WEIGHTIN'];
    }
    $pricebt = "";
    $difference = "";

    if ($result_seBilling1['REMARK'] == 'ไม่คิดขั้นต่ำ') {
        $pricebt = "-";
        $difference = "-";
    } else {
        $pricebt = number_format($result_seBilling3['WEIGHTIN'] * $result_seBilling1['PRICETON'],2);
        $difference = number_format($price - (($result_seBilling3['WEIGHTIN']) * ($result_seBilling1['PRICETON'])),2);
    }
    $tbody1 .= '

  <tr style="border:1px solid #000;">
  <td style="border-right:1px solid #000;padding:5px;text-align:center;">' . $result_seInvoice['DULYDATE'] . '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:center;">' . $result_seBilling1['INVOICECODE'] . '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:center;">10 W</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:center;">STC Amatanakorn</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:center;">' . $jobend . '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:center;">' . $zone . '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:right;">' . number_format($result_seBilling3['WEIGHTIN'], 3) . '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:right;">' . $result_seBilling1['PRICETON'] . '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:right;">' . number_format($price, 2) . '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:right;">' . $pricebt. '</td>
  <td style="border-right:1px solid #000;padding:5px;text-align:right;">' . $difference . '  </td>
  <td style="border-right:1px solid #000;padding:5px;text-align:center;">' . $result_seBilling1['REMARK'] . '</td>
  </tr>';
    $i++;
    $sumtotalton = $sumtotalton + $result_seBilling3['WEIGHTIN'];
    $sumtotalprice = $sumtotalprice + $price;
}

$tfoot1 = '</tbody><tfoot>
<tr style="border:1px solid #000;">
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>รวม<b></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;"><b>' . number_format($sumtotalton, 3) . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
<td style="border-right:1px solid #000;padding:5px;text-align:right;"><b>' . number_format($sumtotalprice, 2) . '</td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
</tr>
</tfoot>';


$table_end1 = '</table>';

$table_footer1 = '<table style="width: 100%;">
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
</table>';
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////



$mpdf->WriteHTML($style);

$mpdf->WriteHTML($table_header1);
$mpdf->WriteHTML($table_begin1);
$mpdf->WriteHTML($thead1);
$mpdf->WriteHTML($tbody1);
$mpdf->WriteHTML($tfoot1);
$mpdf->WriteHTML($table_end1);
$mpdf->WriteHTML($table_footer1);

$mpdf->Output();


sqlsrv_close($conn);
?>
