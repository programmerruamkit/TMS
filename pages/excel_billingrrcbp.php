<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['invoicecode'] == "" || $_GET['invoicecode'] == "") {
  $strExcelFileName = "RRCBP_Billing.xls";
} else {
  $strExcelFileName = "RRCBP_Billing" . $_GET['invoicecode'] . ".xls";
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
    $date_now = $_GET['datestart'] ?> ถึง <?= $_GET['dateend'];
}
$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "'";
$condBilling2 = "";

$sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBillings = array(
    array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN)
);



$query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
$result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<table style="width: 100%;">
      <thead>
          <tr>
              <td colspan="10" style="text-align:center"><b>ใบส่งสินค้า</b></td>
      </thead>
      <tbody>
          <tr>
              <td colspan="10">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด (RUAMKIT RECYCLE CARRIER CO.,LTD.)</td>
         </tr>
         <tr>
              <td colspan="10">สำนักงานใหญ่ 104 ซอยบางนา-ตราด 14 แขวงบางนา เขตบางนา กรุงเทพมหานคร</td>
         </tr>
         <tr>
              <td colspan="10">สำนักงานสาขา 109/1 หมู่ที่ 9 ตำบลหัวสำโรง อำเภอแปลงยาว จังหวัดฉะเชิงเทรา</td>
         </tr>
         <tr>
              <td colspan="10">&nbsp;</td>
         </tr>
         <tr>
              <td colspan="5"style="width: 50%;">เลขประจำตัวผู้เสียภาษี 0105551065951</td>
              <td colspan="5"style="width: 50%;text-align:right">เลขที่ <?= $_GET['invoicecode'] ?></td>
         </tr>
         <tr>
              <td colspan="5" style="width: 50%;">&nbsp;</td>
         </tr>
         <tr>
              <td colspan="5"style="width: 50%;">บจก.บายโปรดักส์สตีล</td>
              <td colspan="5"style="width: 50%;text-align:right">วันที่ <?= $result_getDate['SYSDATE'] ?></td>
         </tr>
         <tr>
              <td colspan="5"colspan="10" style="width: 50%;">ที่อยู่ 88 หมู่ 6 ถนนสัตตพงษ์ ตำบลดอนหัวฬ่อ</td>
         </tr>
         <tr>
              <td colspan="5"colspan="2" style="width: 50%;">อำเภอเมืองชลบุรี จังหวัดชุลบุรี 20000</td>
         </tr>

      </tbody>
  </table>

<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
<thead>

          <tr style="border:1px solid #000;padding:4px;">
          <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;"><b>No.</b></td>
          <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>D / M /Y</b></td>
          <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>Driver</b></td>
          <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Truck No.</b></td>
          <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Delivery</b></td>
          <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Weight (Tons)</b></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>Price</td>
          <td rowspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Total</b></td>
          </tr>
          <tr style="border:1px solid #000;padding:4px;">
          <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>From</b></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>To</b></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>GMT weight</b></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>CUS weight</b></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>Baht/Trips</b></td>
        </tr>
      </thead><tbody>';

<?php
$i = 1;

$sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBilling = array(
    array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN)
);
$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
$condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['DRIVERNAME'] . "'";
                                                                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                                                                        $params_seEmployeeehr = array(
                                                                            array('select_employee', SQLSRV_PARAM_IN),
                                                                            array($condEmployeeehr1, SQLSRV_PARAM_IN)
                                                                        );
                                                                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                                                                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);


 ?>

          <tr style="border:1px solid #000;">
          <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $i ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling['DATE_VLIN'] ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seEmployeeehr['nameT'] ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling['VEHICLEREGISNUMBER'] ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling['JOBSTART'] ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling['JOBEND'] ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling['WEIGHTIN'] ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $result_seBilling['WEIGHTOUT'] ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= number_format($result_seBilling['ACTUALPRICE'],2) ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= number_format($result_seBilling['ACTUALPRICE'],2) ?></td>
        </tr>
    <?php
    $i++;
    $sumgmtweight = $sumgmtweight + $result_seBilling['WEIGHTIN'];
    $sumcusweight = $sumcusweight + $result_seBilling['WEIGHTOUT'];
    $sumtotal = $sumtotal + $result_seBilling['ACTUALPRICE'];
    }

     ?>

</tbody><tfoot>
       <tr style="border:1px solid #000;">
          <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;">PRODUCT : <?= $result_seBillings['MATERIALTYPE'] ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $sumgmtweight ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $sumcusweight ?></td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
          <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?= number_format($sumtotal,2) ?></td>
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
     		 <td style="width: 15%;text-align:right">ผู้จัดทำ</td>
              <td style="width: 35%;">........................................</td>
           <td style="width: 15%;text-align:right">ผู้ตรวจสอบ</td>
              <td style="width: 35%;">........................................</td>
         </tr>
         <tr>
     		 <td colspan="4">&nbsp;</td>
         </tr>
         <tr>
     		 <td style="width: 15%;text-align:right">ผู้อนุมัติ</td>
              <td style="width: 35%;">........................................</td>
              <td style="width: 15%;text-align:right">ผู้รับสินค้า</td>
              <td style="width: 35%;">........................................</td>
         </tr>

      </tbody>
  </table>
</body>
</html>
