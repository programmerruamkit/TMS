<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

if ($_GET['invoicecode'] == "" || $_GET['invoicecode'] == "") {
  $strExcelFileName = "RKRRNSTEEL_Billing.xls";
} else {
  $strExcelFileName = "RKRRNSTEEL_Billing" . $_GET['invoicecode'] . ".xls";
}
// $strExcelFileName="Member-All.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

// $sumgmtweight = "";
// $sumcusweight = "";
// $sumamounttrip = "";
$sumtotal = "";
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
  $date_now = "";
} else {
  $date_now = $_GET['datestart'] ?> ถึง <?= $_GET['dateend'];
}
$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
  array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);


$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,INVOICECODE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '".$_GET['invoicecode']."'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);

$date = substr($result_seInvoicecode['BILLINGDATE'],3,10);





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

?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    
 <table style="width: 110%;">
      <thead>
          <tr>
              <td colspan="10" style="text-align:center;font-size:28px"><b>ใบส่งสินค้า</b></td>
          </tr>

      </thead>

      <tbody><br><br><br>
          <tr>
              <td colspan="10" style="font-size:22px">บริษัท ร่วมกิจรุ่งเรือง (1993) จำกัด (RUAMKIT RUNGRUENG (1993) CO.,LTD.)</td>
        </tr>
        <tr>
              <td colspan="10" style="font-size:22px">สำนักงานใหญ่ เลขที่ 51 ม.4 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160 โทรศัพท์ : (038) 452824-5 โทรสาร : (038) 210396</td>
        </tr>
        <tr>
              <td colspan="10" style="font-size:22px" >เลขประจำตัวผู้เสียภาษี : 0105536076131</td>
        </tr>
        <tr>
              <td colspan="10">&nbsp;</td>
        </tr>

        <tr>
              <td colspan="5" style="text-align:left;font-size:22px">ลูกค้า บริษัท อาร์ แอนด์ เอ็น สตีล จำกัด</td>
              <td colspan="5" style="text-align:right;font-size:22px">เลขที่ <?= $result_seInvoicecode['INVOICECODE'] ?></td>
        </tr>
        <tr>
              <td colspan="5" style="text-align:left;font-size:22px">สำนักงานใหญ่ ที่อยู่ 2341/1 ม.6 ถ.เทพารักษ์ ต.เทพารักษ์  อ.เมืองสมุทรปราการ  จ.สมุทรปราการ 10270</td>
              <td colspan="5" style="text-align:right;font-size:22px">วันที่ <?= $result_seduedate['DUEDATE'] ?></td>
        </tr>
        <tr>
              <td colspan="5" style="font-size:22px">เลขประจำตัวผู้เสียภาษี 0115541004666</td>
        </tr>
      </tbody>
  </table>

<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">
 <thead>

          <tr  style="border:1px solid #000;padding:14px;">
          <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:12px"><b>ลำดับ</b></td>
          <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:12px"><b>วันที่</b></td>
          <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:12px"><b>หมายเลข DO</b></td>
          <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:12px"><b>ทะเบียนรถ</b></td>
          <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:12px"><b>พนักงาน</b></td>
          <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:12px"><b>จาก</b></td>
          <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:12px"><b>ถึง</b></td>
          <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:12px"><b>QT.</b></td>
          <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:12px"><b>หน่วยละ</b></td>
          <td   style="border-right:1px solid #000;padding:14px;text-align:center;font-size:12px"><b>จำนวนเงิน</b></td>
        </tr>
      </thead><tbody>
<?php
  $i = 1;
  $count = 0 ;

  $condBilling1 = " AND c.COMPANYCODE = 'RKR' AND c.CUSTOMERCODE = 'RNSTEEL'";
  $condBilling2 = "";
  $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
  $params_seBilling = array(
      array('select_pdfvehicletransportdocumentdriver-tgt', SQLSRV_PARAM_IN),
      array($condBilling1, SQLSRV_PARAM_IN),
      array($condBilling2, SQLSRV_PARAM_IN)
  );



  $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
  while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
    
      $condEmployeeehr1 = " AND a.PersonCode = '" . $result_seBilling['EMPLOYEECODE1'] . "' ";
      $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
      $params_seEmployeeehr = array(
          array('select_employeeehr2', SQLSRV_PARAM_IN),
          array($condEmployeeehr1, SQLSRV_PARAM_IN)
      );
      $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
      $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);


      $sql_seHoliday = "SELECT  HOLIDAY AS 'DATE',COMPANYCODE,CUSTOMERCODE,INVOICECODE,JOBEND,BILLINGPRPO 
                          FROM [dbo].[BILLING_HOLIDAY] 
                          WHERE INVOICECODE ='".$result_seInvoicecode['INVOICECODE']."'
                          AND COMPANYCODE='RKR' AND CUSTOMERCODE = 'RNSTEEL' AND JOBEND = 'RKRRNSTEEL'";
      $params_seHoliday = array();
      $query_seHoliday = sqlsrv_query($conn, $sql_seHoliday, $params_seHoliday);
      $result_seHoliday = sqlsrv_fetch_array($query_seHoliday, SQLSRV_FETCH_ASSOC);


      $holiday = $result_seHoliday['DATE'];
      // $holiday = $result_seHoliday['DATE'];
      $holidaysplit = explode(",", $holiday);


        if (($result_seBilling['DATEVLIN_103'] == $holidaysplit[0]) || ($result_seBilling['DATEVLIN_103'] == $holidaysplit[1]) || ($result_seBilling['DATEVLIN_103'] == $holidaysplit[2]) || ($result_seBilling['DATEVLIN_103'] == $holidaysplit[3]) || ($result_seBilling['DATEVLIN_103'] == $holidaysplit[4])) {
          ?>

          <tr style="border:1px solid #000;padding:17px;">
          <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:12px"><?= $i ?></td>
          <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:12px"><?= $result_seBilling['DATEVLIN_103'] ?></td>
          <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:12px"><?= $result_seBilling['PURCHASEORDER'] ?></td>
          <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:12px"><?= $result_seBilling['THAINAME'] ?></td>
          <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:12px"><?= $result_seEmployeeehr['FnameT'] ?></td>
          <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:12px"><?= $result_seBilling['JOBSTART'] ?></td>
          <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:12px"><?= $result_seBilling['JOBEND'] ?></td>
          <td style="border-right:1px solid #000;padding:17px;text-align:right;font-size:12px">1.00</td>
          <td style="border-right:1px solid #000;padding:17px;text-align:right;font-size:12px"><?= number_format($result_seBilling['PRICE'], 2) ?></td>
          <td style="border-right:1px solid #000;padding:17px;text-align:right;font-size:12px"><?= number_format($result_seBilling['PRICE'], 2) ?></td>
        </tr>
        <tr style="border:1px solid #000;padding:17px;">
            <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:12px"></td>
            <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:12px"><?= $result_seBilling['DATEVLIN_103'] ?></td>
            <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:12px"><?= $result_seBilling['PURCHASEORDER'] ?></td>
            <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:12px"><?= $result_seBilling['THAINAME'] ?></td>
            <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:12px"><?= $result_seEmployeeehr['FnameT'] ?></td>
            <td colspan="2" style="border-right:1px solid #000;padding:17px;text-align:center;font-size:12px">Holiday</td>
            <td style="border-right:1px solid #000;padding:17px;text-align:right;font-size:12px">1.00</td>
            <td style="border-right:1px solid #000;padding:17px;text-align:right;font-size:12px">1000</td>
            <td style="border-right:1px solid #000;padding:17px;text-align:right;font-size:12px">1000</td>
      </tr>

      
  <?php
          $i++;
          $count ++ ;
          $sumtotalholiday = ($count * 1000);
          $sumtotal1 = $sumtotal1 + $result_seBilling['PRICE'];
        }else {
  ?> 

            <tr style="border:1px solid #000;padding:17px;">
              <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:12px"><?= $i ?></td>
              <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:12px"><?= $result_seBilling['DATEVLIN_103'] ?></td>
              <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:12px"><?= $result_seBilling['PURCHASEORDER'] ?></td>
              <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:12px"><?= $result_seBilling['THAINAME'] ?></td>
              <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:12px"><?= $result_seEmployeeehr['FnameT'] ?></td>
              <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:12px"><?= $result_seBilling['JOBSTART'] ?></td>
              <td style="border-right:1px solid #000;padding:17px;text-align:center;font-size:12px"><?= $result_seBilling['JOBEND'] ?></td>
              <td style="border-right:1px solid #000;padding:17px;text-align:right;font-size:12px">1.00</td>
              <td style="border-right:1px solid #000;padding:17px;text-align:right;font-size:12px"><?= number_format($result_seBilling['PRICE'], 2) ?></td>
              <td style="border-right:1px solid #000;padding:17px;text-align:right;font-size:12px"><?= number_format($result_seBilling['PRICE'], 2) ?></td>
            </tr>

          <?php

          $i++;
          $sumtotal2 = $sumtotal2 + $result_seBilling['PRICE'];
        }





  }///main while
?>



      </tbody><tfoot>
      <tr style="border:1px solid #000;">
          <td  colspan="1" style="border-right:1px solid #000;padding:11px;text-align:center;font-size:12px"><b>รวมสุทธิ</td>

          <td  colspan="8" style="border-right:1px solid #000;padding:11px;text-align:center;font-size:12px"><b><?= convert($sumtotal1+$sumtotal2+$sumtotalholiday) ?></td>

          <td  colspan="1" style="border-right:1px solid #000;padding:11px;text-align:right;font-size:12px"><b><?= number_format($sumtotal1+$sumtotal2+$sumtotalholiday, 2) ?></td>

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
        <td style="width: 33%;text-align:left;font-size:20px">ผู้จัดทำ..............................</td>

          <td style="width: 34%;text-align:center;font-size:20px">ผู้ตรวจสอบ..........................</td>

          <td style="width: 33%;text-align:right;font-size:20px">ผู้อนุมัติ..............................</td>

        </tr>



      </tbody>
  </table>
  



</body>
</html>
