<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
$sumgmtweight = "";
$sumcusweight = "";
$sumamounttrip = "";
$sumtotal = "";
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $date_now = "";
} else {
    $date_now = $_GET['datestart'] . ' ถึง ' . $_GET['dateend'];
}
$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_lastdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);




$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,INVOICECODE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '".$_GET['invoicecode']."'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);



if($_GET['transportation2'] != '' )
{
  $condBilling1 = " AND c.COMPANYCODE = '".$_GET['companycode']."' AND c.CUSTOMERCODE = '".$_GET['customercode']."' AND b.JOBSTART = '".$_GET['transportation1'].'+'.$_GET['transportation2']."' AND b.DOCUMENTCODE_PALLET NOT IN ('000001','000002')";
  $condBilling2 = " AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103) ";

}
else {
  $condBilling1 = " AND c.COMPANYCODE = '".$_GET['companycode']."' AND c.CUSTOMERCODE = '".$_GET['customercode']."' AND b.JOBSTART='".$_GET['transportation']."' AND b.DOCUMENTCODE_PALLET NOT IN ('000001','000002')";
  $condBilling2 = " AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103) ";
}


$sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBillings = array(
    array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN)
);
$query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
$result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);

$condduedate1 = " AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
$condduedate2 = "";
$sql_seduedate = "{call megLoginvoice_v2(?,?,?)}";
$params_seduedate = array(
    array('select_duedate', SQLSRV_PARAM_IN),
    array($condduedate1, SQLSRV_PARAM_IN),
    array($condduedate2, SQLSRV_PARAM_IN)
);
$query_seduedate = sqlsrv_query($conn, $sql_seduedate, $params_seduedate);
$result_seduedate = sqlsrv_fetch_array($query_seduedate, SQLSRV_FETCH_ASSOC);

//$invoicecode = create_invoice();

// $mpdf = new mPDF('th', 'A4', '0', '');
$mpdf = new mPDF('', 'A4', '', '', 10, 10, 25, 5, 5, 5);
$style = '
<style>
	body{
		font-family: "Garuda";font-size:12px//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';




$table_header3 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="2" style="text-align:center;font-size:14px"><b>เอกสารแนบการวางบิลลูกค้า (ไม่คิดขั้นต่ำ)</b></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;font-size:14px"><b>'.$result_seInvoicecode['BILLINGDATE'] . ' - ' . $result_seInvoicecode['PAYMENTDATE'].' (พาเลท)</b></td>
        </tr>

    </thead>

    <tbody>
        <tr>
            <td style="width: 70%;font-size:12px"><b>หมายเลขบัญชี : STC</td>
            <td style="width: 30%;font-size:12px;text-align:right"><b>ใบแจ้งหนี้ : '.$_GET['invoicecode'] . '</td>
       </tr>

    </tbody>
</table>';

$table_begin3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:11px;">';
$thead3 = '<thead>

        <tr  style="border:1px solid #000;padding:4px;">
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;width: 6%;"><b>ลำดับ</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>วันที่</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;width: 18%;"><b>จาก</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;width: 14%"><b>ถึง</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;width: 8%;"><b>หมายเลข<br>DO</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;width: 9%"><b>จำนวน<br>(พาเลท)</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;width: 9 %"><b>อัตรา<br>(บาท/ชิ้น)</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%"><b>ราคา<br>(บาท)</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;width: 8%;"><b>หมายเลข<br>รถ</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;width: 8%;"><b>พนักงาน</b></td>

      </tr>
    </thead><tbody>';

$i = 1;
$sql_seBilling = "SELECT b.VEHICLETRANSPORTPRICEID,CONVERT(VARCHAR(10), b.DATEVLIN, 103)  AS 'DATEVLIN_103',a.JOBSTART, a.JOBEND,a.DOCUMENTCODE_PALLET,a.TRIPAMOUNT_PALLET,'10' AS 'PALLETUNIT',(a.TRIPAMOUNT_PALLET*10) AS 'PALLETPRICE',
b.THAINAME AS 'TRUCKTYPE',a.EMPLOYEENAME1
FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVERPALLET] a
INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
WHERE a.ACTIVESTATUS = 1
AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103)
AND a.COMPANYCODE IN ('RKR','RKL') AND a.CUSTOMERCODE = 'TTASTSTC' AND a.PRODUCTTYPE ='pallet'
AND a.DOCUMENTCODE_PALLET != '' order by b.DATEVLIN ASC";




$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
    $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "' ";
    $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEmployeeehr = array(
        array('select_employeeehr2', SQLSRV_PARAM_IN),
        array($condEmployeeehr1, SQLSRV_PARAM_IN)
    );
    $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
    $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
    
    
    $sql_seLocation = "SELECT TOP 1 [LOCATION] FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE [VEHICLETRANSPORTPRICEID] = '" . $result_seBilling['VEHICLETRANSPORTPRICEID'] . "'";
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
    
    

  $tbody3 .= '

    <tr style="border:1px solid #000;">
      <td style="border-right:1px solid #000;padding:4px;text-align:center">' . $i . '</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['DATEVLIN_103'] . '</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:left;">' . $result_seBilling['JOBEND'] .' '.$zone.'</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:center;">STC Amata City Chonburi</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['DOCUMENTCODE_PALLET'] . '</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($result_seBilling['TRIPAMOUNT_PALLET'],2) . '</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:right;">10.00</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:right;">'.number_format($result_seBilling['TRIPAMOUNT_PALLET']*10, 2).'</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seBilling['TRUCKTYPE'] . '</td>
      <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seEmployeeehr['FnameT'] . '</td>
    </tr>
  ';
$i++;
  $sumtotal = $sumtotal + ($result_seBilling['TRIPAMOUNT_PALLET']*10);
  $sumpallet = $sumpallet +$result_seBilling['TRIPAMOUNT_PALLET'];
}





$tfoot3 = '</tbody><tfoot>
     <tr style="border:1px solid #000;">
        <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>รวมทั้งหมด</td>
        <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:right;"><b>' . number_format($sumpallet,2) . '</td>
        <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:right;"><b>' . number_format($sumtotal,2) . '</td>
        <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>

            </tr>
    </tfoot>';


$table_end3 = '</table>';

$table_footer3 = '<table style="width: 100%;">
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
   		 <td style="width: 35%;text-align:left">ผู้จัดทำ........................................</td>
         <td style="width: 30%;text-align:center">ผู้ตรวจสอบ........................................</td>
            <td style="width: 35%;text-align:right">ผู้อนุมัติ........................................</td>

       </tr>



    </tbody>
</table>';





$mpdf->WriteHTML($style);
$mpdf->SetHTMLHeader($table_header3, 'O', true);
// $mpdf->WriteHTML($table_header3);
$mpdf->WriteHTML($table_begin3);
$mpdf->WriteHTML($thead3);
$mpdf->WriteHTML($tbody3);
$mpdf->WriteHTML($tfoot3);
$mpdf->WriteHTML($table_end3);
$mpdf->WriteHTML($table_footer3);

$mpdf->Output();


sqlsrv_close($conn);
?>
