  <?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['invoicecode'] == "" || $_GET['invoicecode'] == "") {
  $strExcelFileName = "RKSTAW_Billing.xls";
} else {
  $strExcelFileName = "RKSTAW_Billing" . $_GET['invoicecode'] . ".xls";
}
// $strExcelFileName="Member-All.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

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
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,COMPANYCODE,CUSTOMERCODE,INVOICECODE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '".$_GET['invoicecode']."'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);

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
//
//
// $query_date = $result_seInvoicecode['BILLINGDATE'];
// $date = new DateTime($query_date);
// //get month
// $date->modify('month');
// $month= $date->format('F Y');
//
// $fdate=substr($result_seInvoicecode['BILLINGDATE'],-10,2);
// $ldate=substr($result_seInvoicecode['PAYMENTDATE'],-10,2);

?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

  <table style="width: 100%;">
    <thead>
      <tr>
        <td colspan="9" style="text-align:center;"><b>ใบส่งสินค้า</b></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td  colspan="9" >บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICE CO.,LTD.)</td>
      </tr>
      <tr>
        <td colspan="9" >สำนักงานใหญ่ เลขที่ 51 ม.4 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี โทรศัพท์ : (038) 452824-5 โทรสาร : (038) 210396</td>
      </tr>
      <tr>
        <td colspan="9" >เลขประจำตัวผู้เสียภาษี : 0105544064899</td>
      </tr>
      <tr>
        <td >&nbsp;</td>
      </tr>

      <tr>
        <td  colspan="5"style="width: 50%;">ลูกค้า บริษัท โตโยต้า ออโต้ เวิคส จำกัด (สำนักงานใหญ่)</td>
        <td  colspan="4"style="width: 50%;text-align:right">เลขที่ <?= $result_seInvoicecode['INVOICECODE']?></td>
      </tr>
      <tr>
        <td  colspan="5" style="width: 50%;">ที่อยู่ 187 หมู่ 9 ถนนทางรถไฟเก่า ต.เทพารักษ์ อ.เมืองสมุทรปราการ จ.สมุทรปราการ</td>
        <td  colspan="4" style="width: 50%;text-align:right">วันที่ <?= $result_getDate['SYSDATE'] ?> เครดิต 30 วัน</td>
      </tr>
      <tr>
        <td  colspan="5" style="width: 50%;">เลขประจำตัวผู้เสียภาษี 0115531001656</td>
        <td  colspan="4" style="width: 50%;text-align:right">วันที่ครบกำหนด <?= $result_seduedate['DUEDATE']?></td>
      </tr>
    </tbody>
  </table>

  <table  width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
    <thead>

      <tr style="border:1px solid #000;padding:4px;">
        <td colspan="1"style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ลำดับที่</b></td>
        <td colspan="1"style="border-right:1px solid #000;padding:4px;text-align:center;"><b>วันที่</b></td>
        <td colspan="1"style="border-right:1px solid #000;padding:4px;text-align:center;"><b>หมายเลข DO</b></td>
        <td colspan="1"style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ทะเบียนรถ</b></td>
        <td colspan="1"style="border-right:1px solid #000;padding:4px;text-align:center;"><b>พนักงาน</b></td>
        <td colspan="1"style="border-right:1px solid #000;padding:4px;text-align:center;"><b>เส้นทาง</b></td>
        <td colspan="1"style="border-right:1px solid #000;padding:4px;text-align:center;"><b>QT.</b></td>
        <td colspan="1"style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ราคา</b></td>
        <td colspan="1"style="border-right:1px solid #000;padding:4px;text-align:center;"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
    </thead><tbody>
      <?php
      $i = 1;
      $sql_seBilling = "SELECT CONVERT(VARCHAR(10), c.DATEVLIN, 103) AS 'DATEVLIN',a.DOCUMENTCODE,c.THAINAME,c.EMPLOYEENAME1,c.JOBSTART,c.JOBEND,c.ACTUALPRICE
                          FROM [dbo].[LOGINVOICE] a
                          INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
                          INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
                          WHERE c.COMPANYCODE = '".$result_seInvoicecode['COMPANYCODE']."' AND c.CUSTOMERCODE = '".$result_seInvoicecode['CUSTOMERCODE']."'
                          AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103)";

      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
        ?>
        <tr style="border:1px solid #000;">
          <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $i ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:left;"><?= $result_seBilling['DATEVLIN_103'] ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:left;"><?= $result_seBilling['DOCUMENTCODE'] ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:left;"><?= $result_seBilling['THAINAME'] ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:left;"><?= $result_seBilling['EMPLOYEENAME1'] ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:left;"><?= $result_seBilling['JOBSTART'] ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:right;">1.00</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:right;"><?= number_format($result_seBilling['ACTUALPRICE'], 2) ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:right;"><?= number_format($result_seBilling['ACTUALPRICE'], 2) ?></td>
        </tr>
        <?php
        $i++;
        $sumtotal = $sumtotal + $result_seBilling['ACTUALPRICE'];
      }
      ?>

    </tbody>
    <tfoot>
      <tr style="border:1px solid #000;">
        <td colspan="7" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= convert($sumtotal) ?></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">รวมสุทธิ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;"><?= number_format($sumtotal, 2) ?></td>
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
        <td style="width: 10%;text-align:right">ผู้ตรวจสอบ</td>
        <td style="width: 20%;">........................................</td>
        <td style="width: 10%;text-align:right">ผู้อนุมัติ</td>
        <td style="width: 25%;">........................................</td>
      </tr>



    </tbody>
  </table>

  <table ><tbody><th align="center"><b></b></th></tbody></table>
  <table ><tbody><th align="center"><b></b></th></tbody></table>


  <table  width="100%"  style="border-collapse: collapse;margin-top:8px;font-size:8px">
    <tbody>
      <tr style="border:1px solid #000;" >
        <td colspan="3" rowspan="3" style="border-right:1px solid #000;padding:4px;"></td>
        <td colspan="2"style="border-right:1px solid #000;padding:4px;text-align:center">Approed by PL</td>
        <td colspan="2"style="border-right:1px solid #000;padding:4px;text-align:center">Check by</td>
        <td colspan="2"style="border-right:1px solid #000;padding:4px;text-align:center">Issued by</td>
      </tr>
      <tr style="border:1px solid #000;" >
        <td colspan="2"style="border-right:1px solid #000;padding:4px;">&nbsp;</td>
        <td colspan="2"style="border-right:1px solid #000;padding:4px;">&nbsp;</td>
        <td colspan="2"style="border-right:1px solid #000;padding:4px;">&nbsp;</td>
      </tr>
      <tr style="border:1px solid #000;" >
        <td colspan="2"style="border-right:1px solid #000;padding:4px;">&nbsp;</td>
        <td colspan="2"style="border-right:1px solid #000;padding:4px;">&nbsp;</td>
        <td colspan="2"style="border-right:1px solid #000;padding:4px;">&nbsp;</td>
      </tr>
    </tbody>
  </table>

  <table ><tbody><th align="center"><b></b></th></tbody></table>

  <table width="100%" style="border-collapse: collapse;margin-top:8px;font-size:8px">
    <thead>

      <tr style="border:1px solid #000;padding:4px;">
        <td colspan="19" style="border-right:1px solid #000;padding:4px;text-align:center">Detail express way charge for route transport on <?=$result_seInvoicecode['BILLINGDATE']?>-<?=$result_seInvoicecode['PAYMENTDATE']?> (TAW)</td>
      </tr>
      <tr style="border:1px solid #000;">
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">Date</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">Nomal trip</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;;">Extra trip</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">Total trip</td>
        <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">Total bill express way</td>
        <td colspan="14" style="border-right:1px solid #000;padding:4px;text-align:center;">Day + Night</td>
      </tr>
      <tr style="border:1px solid #000;">
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center">45</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center">55</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center">65</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center">65 Return trip</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center">75</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center">195</td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center">Total</td>
      </tr>
      <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:5%;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:5%;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:5%;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:5%;">&nbsp;</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:5%;">Trip</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:5%;">Price</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:5%;">Trip</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:5%;">Price</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:5%;">Trip</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:5%;">Price</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:5%;">Trip</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:5%;">Price</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:5%;">Trip</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:5%;">Price</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:5%;">Trip</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:5%;">Price</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:5%;">Trip</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:5%;">Price</td>
      </tr>
    </thead><tbody>
      <?php
      $i4 = 1;
      $sql_seBilling1 = "SELECT CONVERT(VARCHAR(10), c.DATEVLIN, 103) AS 'DATEVLIN' ,a.DOCUMENTCODE,c.THAINAME,c.EMPLOYEENAME1,c.JOBSTART,c.JOBEND,c.ACTUALPRICE,d.Company_Memo,
      b.PAY_EXPRESSWAY, b.PAY_EXPRESSWAY15, b.PAY_EXPRESSWAY25, b.PAY_EXPRESSWAY45, b.PAY_EXPRESSWAY45RETURN, b.PAY_EXPRESSWAY50, b.PAY_EXPRESSWAY50RETURN,
      b.PAY_EXPRESSWAY55, b.PAY_EXPRESSWAY65, b.PAY_EXPRESSWAY65RETURN, b.PAY_EXPRESSWAY75, b.PAY_EXPRESSWAY100, b.PAY_EXPRESSWAY105RETURN, b.PAY_EXPRESSWAY195
      FROM [dbo].[LOGINVOICE] a
      INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
      INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
      INNER JOIN [dbo].[COMPANYEHR] d ON c.COMPANYCODE = d.[Company_Code]
       WHERE c.COMPANYCODE = '".$result_seInvoicecode['COMPANYCODE']."' AND c.CUSTOMERCODE = '".$result_seInvoicecode['CUSTOMERCODE']."'
                          AND CONVERT(DATE,c.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103)";

      $query_seBilling1 = sqlsrv_query($conn, $sql_seBilling1, $params_seBilling1);
      while ($result_seBilling1 = sqlsrv_fetch_array($query_seBilling1, SQLSRV_FETCH_ASSOC)) {

          $sql_seStartholiday2 = "{call megHolidayEHR_v2(?,?,?,?)}";
          $params_seStartholiday2 = array(
              array('start_holidaywork', SQLSRV_PARAM_IN),
              array("", SQLSRV_PARAM_IN),
              array($result_seBilling1['Company_Memo'], SQLSRV_PARAM_IN),
              array($result_seBilling1['DATEVLIN'], SQLSRV_PARAM_IN),
          );
          $query_seStartholiday2 = sqlsrv_query($conn, $sql_seStartholiday2, $params_seStartholiday2);
          $result_seStartholiday2 = sqlsrv_fetch_array($query_seStartholiday2, SQLSRV_FETCH_ASSOC);

          $normaltrip = ($result_seStartholiday2['HOLIDAYWORK'] == '0') ? '1' : '0';
          $extratrip = ($result_seStartholiday2['HOLIDAYWORK'] != '0') ? '1' : '0';
          if ($result_seBilling1['PAY_EXPRESSWAY45'] == '45') {
              $expressway45 = "1";
              $sumexpressway45 = $expressway45 * 45;
          } else {
              $expressway45 = "";
              $sumexpressway45 = "0";
          }
          if ($result_seBilling1['PAY_EXPRESSWAY55'] == '55') {
              $expressway55 = "1";
              $sumexpressway55 = $expressway55 * 55;
          } else {
              $expressway55 = "";
              $sumexpressway55 = "0";
          }
          if ($result_seBilling1['PAY_EXPRESSWAY65'] == '65') {
              $expressway65 = "1";
              $sumexpressway65 = $expressway65 * 65;
          } else {
              $expressway65 = "";
              $sumexpressway65 = "0";
          }
            if ($result_seBilling1['PAY_EXPRESSWAY65RETURN'] == '65') {
              $expressway65return = "1";
              $sumexpressway65return = $expressway65return * 65;
          } else {
              $expressway65return = "";
              $sumexpressway65return = "0";
          }
          if ($result_seBilling1['PAY_EXPRESSWAY75'] == '75') {
              $expressway75 = "1";
              $sumexpressway75 = $expressway75 * 75;
          } else {
              $expressway75 = "";
              $sumexpressway75 = "0";
          }
          if ($result_seBilling1['PAY_EXPRESSWAY195'] == '195') {
              $expressway195 = "1";
              $sumexpressway195 = $expressway195 * 195;
          } else {
              $expressway195 = "";
              $sumexpressway195 = "0";
          }
        ?>

        <tr style="border:1px solid #000;">
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= $result_seBilling1['DATE_VLIN'] ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= $normaltrip ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= $extratrip ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= ($normaltrip + $extratrip) ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= ($normaltrip + $extratrip) ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= $expressway45 ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= $sumexpressway45 ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= $expressway55 ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= $sumexpressway55 ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= $expressway65 ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= $sumexpressway65 ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= $expressway65return ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= $sumexpressway65return ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= $expressway75 ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= $sumexpressway75 ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= $expressway195 ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= $sumexpressway195 ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= ($expressway45 + $expressway55 + $expressway65 +$expressway65return+ $expressway75 + $expressway195) ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= ($sumexpressway45 + $sumexpressway55 + $sumexpressway65 +$sumexpressway65return+ $sumexpressway75 + $sumexpressway195) ?></td>
        </tr>
        <?php
        $cntnormaltrip += $normaltrip;
        $cntextratrip += $extratrip;
        $cntnormaltripextratrip += ($normaltrip + $extratrip);
        $cntexpressway45 += $expressway45;
        $cntsumexpressway45 += $sumexpressway45;
        $cntexpressway55 += $expressway55;
        $cntsumexpressway55 += $sumexpressway55;
        $cntexpressway65 += $expressway65;
        $cntsumexpressway65 += $sumexpressway65;
        $cntexpressway65return += $expressway65return;
        $cntsumexpressway65return += $sumexpressway65return;
        $cntexpressway75 += $expressway75;
        $cntsumexpressway75 += $sumexpressway75;
        $cntexpressway195 += $expressway195;
        $cntsumexpressway195 += $sumexpressway195;
        $cntalltrip += ($expressway45 + $expressway55 + $expressway65 +$expressway65return+ $expressway75 + $expressway195);
        $cntallprice += ($sumexpressway45 + $sumexpressway55 + $sumexpressway65 +$sumexpressway65return+ $sumexpressway75 + $sumexpressway195);
        $i4++;
    }


      ?>
      <tfoot>
        <tr style="border:1px solid #000;">
          <td style="border-right:1px solid #000;padding:4px;text-align:center">Total</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= $cntnormaltrip ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= $cntextratrip ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= $cntnormaltripextratrip ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?= $cntnormaltripextratrip ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?=$cntexpressway45?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?=$cntsumexpressway45?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?=$cntexpressway55?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?=$cntsumexpressway55?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?=$cntexpressway65?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?=$cntsumexpressway65?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?=$cntexpressway65return?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?=$cntsumexpressway65return?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?=$cntexpressway75?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?=$cntsumexpressway75?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?=$cntexpressway195?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?=$cntsumexpressway195?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?=$cntalltrip?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center"><?=$cntallprice?></td>
        </tr>
      </tfoot>
    </table>

    <table width="100%" style="border-collapse: collapse;margin-top:8px;font-size:8px">
      <tbody>
      <tr>
          	<td colspan="2"><b>Remark : Price express way</b></td>

         </tr>
          <tr>
          	<td style="width:10%"><b>45 bt.</b></td>
              <td style="width:90%"><b> : Erawan Museum > Srinakarin</td>
         </tr>
         <tr>
          	<td style="width:10%"><b>55 bt.</b></td>
              <td style="width:90%"><b> : Erawan Museum > Teparak</td>
         </tr>
         <tr>
          	<td style="width:10%"><b>65 bt.</b></td>
              <td style="width:90%"><b> : Erawan Museum > Bangkaew</td>
         </tr>
         <tr>
          	<td style="width:10%"><b>65 bt.</b></td>
              <td style="width:90%"><b> : Kingkaew > Bangsamak</td>
         </tr>
         <tr>
          	<td style="width:10%"><b>75 bt.</b></td>
              <td style="width:90%"><b> : Bangkaew > Bangsamak</td>
         </tr>
      </tbody>
    </table>



  </tbody>

</body>
</html>
