<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['invoicecode'] == "" || $_GET['invoicecode'] == "") {
  $strExcelFileName = "RKSDENSO-THAI(TULIP)_Billing.xls";
} else {
  $strExcelFileName = "RKSDENSO-THAI(TULIP)_Billing" . $_GET['invoicecode'] . ".xls";
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


$condBilling1 = " AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
$condBilling2 = "";
$condBilling3 = "";

$sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
$params_seBillings = array(
    array('select_pdfvehicletransportdocumentdriver-densothai1', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN),
    array($condBilling3, SQLSRV_PARAM_IN)
);
$query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
$result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);

$sql_seData11 = "SELECT JOBSTART FROM VEHICLETRANSPORTDOCUMENTDIRVER WHERE DOCUMENTCODE = '".$result_seBillings['DOCUMENTCODE']."' AND RIGHT(JOBSTART,3) != '(N)'";
$query_seData11 = sqlsrv_query($conn, $sql_seData11, $params_seData11);
$result_seData11 = sqlsrv_fetch_array($query_seData11, SQLSRV_FETCH_ASSOC);

$sql_seMinvldate = "SELECT CONVERT(VARCHAR(10), MIN(VLINDATE), 103) AS 'MINDATEVLIN_103'
FROM [dbo].[LOGINVOICE]
WHERE 1 = 1 AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
$query_seMinvldate = sqlsrv_query($conn, $sql_seMinvldate, $params_seMinvldate);
$result_seMinvldate = sqlsrv_fetch_array($query_seMinvldate, SQLSRV_FETCH_ASSOC);

$sql_seMaxvldate = "SELECT CONVERT(VARCHAR(10), MAX(VLINDATE), 103) AS 'MAXDATEVLIN_103'
FROM [dbo].[LOGINVOICE]
WHERE 1 = 1 AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
$query_seMaxvldate = sqlsrv_query($conn, $sql_seMaxvldate, $params_seMaxvldate);
$result_seMaxvldate = sqlsrv_fetch_array($query_seMaxvldate, SQLSRV_FETCH_ASSOC);

$condInvoice1 = " AND INVOICECODE = '" . $_GET['invoicecode'] . "'";
$condInvoice2 = "";
$sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
$params_seInvoice = array(
    array('select_loginvoice', SQLSRV_PARAM_IN),
    array($condInvoice1, SQLSRV_PARAM_IN),
    array($condInvoice2, SQLSRV_PARAM_IN)
);
$query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
$result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC);


?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

  <!-- ////////////////////////////////////////เด็นโซ๋ เซลล์ ประเทศไทย///////////////////////////////// -->

 <table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">
  <tbody>
  <tr style="border:1px solid #000;padding:4px;">
  <td colspan="2" style="font-size:14;" align="center">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด<br><br>สำนักงานใหญ่ เลขที่ 51 ม.4 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี  20160<br><br>โทร .038 452824-5 โทรสาร .038-210396</td>
  </tr>

  <tr style="border:1px solid #000;">
  <td colspan="2" align="center" style="font-size:16px;padding:5px;">ใบส่งของ (DELIVERY BILL)</td>
  </tr>
  <tr style="border:1px solid #000;padding:4px;">
  <td style="border-right:1px solid #000;padding:5px;width:80%"><b>วันที่ <?=$result_seMinvldate['MINDATEVLIN_103']?> - <?=$result_seMaxvldate['MAXDATEVLIN_103']?></b></td>
  <td><b>เลขที่ <?= $result_seInvoice['INVOICECODE'] ?></b></td>
  </tr>
  <tr style="border:1px solid #000;padding:4px;">
  <td style="font-size:14;" colspan="2" align="center"><br>บริษัท เด็นโซ่  (ประเทศไทย) จำกัด <br><br>
  700/87 หมู่ 1 ถ.บางนา-ตราด กม.57 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160<br><br><br>
  </td>
  </tr>
  <tr style="border:1px solid #000;">
  <td style="padding:5px;font-size:14;" colspan="2" align="center"><b><?=$result_seData11['JOBSTART']?></b></td>
  </tr>
  </tbody>
  </table>

<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
  <thead>

  <tr style="border:1px solid #000;padding:4px;">

  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ลำดับที่</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>วันที่</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><strong>ทะเบียนรถ</strong></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>พนักงานขับรถ</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>หมายเลขเส้นทาง</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ประเภทรถ</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>จำนวนเงิน(บาท)</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>หมายเหตุ</b></td>
  </tr>
  </thead><tbody>
    <?php
    $i = 1;
    $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
    $params_seBilling = array(
        array('select_pdfvehicletransportdocumentdriver-densothai1', SQLSRV_PARAM_IN),
        array($condBilling1, SQLSRV_PARAM_IN),
        array($condBilling2, SQLSRV_PARAM_IN),
        array($condBilling3, SQLSRV_PARAM_IN)
    );



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


        $sql_seData1 = "SELECT VEHICLETRANSPORTPLANID,ACTUALPRICE FROM VEHICLETRANSPORTDOCUMENTDIRVER WHERE DOCUMENTCODE = '".$result_seBilling['DOCUMENTCODE']."'";
        $query_seData1 = sqlsrv_query($conn, $sql_seData1, $params_seData1);
        $result_seData1 = sqlsrv_fetch_array($query_seData1, SQLSRV_FETCH_ASSOC);


        $sql_seData2 = "SELECT CONVERT(VARCHAR(10), a.DATEVLIN, 103) AS 'DATEVLIN_103',a.THAINAME,a.EMPLOYEENAME1,a.VEHICLETYPE,a.VEHICLETRANSPORTPRICEID FROM VEHICLETRANSPORTPLAN a
                        WHERE a.VEHICLETRANSPORTPLANID = '".$result_seData1['VEHICLETRANSPORTPLANID']."'";
        $query_seData2 = sqlsrv_query($conn, $sql_seData2, $params_seData2);
        $result_seData2 = sqlsrv_fetch_array($query_seData2, SQLSRV_FETCH_ASSOC);

        $sql_seData3 = "SELECT a.ROUTEDESCRIPTION,a.VEHICLETYPE,ROUTETYPE FROM VEHICLETRANSPORTPRICE a
                        WHERE a.VEHICLETRANSPORTPRICEID = '".$result_seData2['VEHICLETRANSPORTPRICEID']."'";
        $query_seData3 = sqlsrv_query($conn, $sql_seData3, $params_seData3);
        $result_seData3 = sqlsrv_fetch_array($query_seData3, SQLSRV_FETCH_ASSOC);

     ?>
      <tr style="border:1px solid #000;">
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$i?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seBilling['DATEVLIN_103']?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seData2['THAINAME']?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:left;"><?=$result_seData2['EMPLOYEENAME1']?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seData3['ROUTEDESCRIPTION']?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seData3['VEHICLETYPE']?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=number_format($result_seData1['ACTUALPRICE'])?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seData3['ROUTETYPE']?></td>
  </tr>
<?php
$i++;
$sumtotal = $sumtotal + $result_seData1['ACTUALPRICE'];
}
 ?>


</tbody><tfoot>
  <tr style="border:1px solid #000;">
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">รวมทั้งสิ้น</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?($i-1)?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">เที่ยว</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">รวมเป็นเงินทั้งสิ้น</td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= convert($sumtotal) ?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= number_format($sumtotal) ?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
  </tr>
  <tr style="border:1px solid #000;">

  <td colspan="4" style="padding:4px;text-align:center;"><br><br>ผู้รับของ. ______________________________________
  <br><br><br> วันที่.  ........................./......................../....................

  </td><br><br><br>
  <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br>ผู้ส่งของ. ______________________________________
  <br><br><br> วันที่.  ........................./......................../....................
  </td><br><br><br>

  </tr>
  </tfoot></table>




  </tbody><tfoot>
     <div id="rotated">
     <tr style="border:1px solid #000;">
     <td colspan="4" style="padding:4px;text-align:center;">FM-OPS-15/09</td>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
     <td colspan="4" style="padding:4px;text-align:center;">แก้ไขครั้งที่ : 00</td>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
     <td colspan="2" style="padding:4px;text-align:center;">มีผลบังคับใช้ : 01-02-49</td>
     </tr>
     </div>
  </tfoot></table>

  <!-- ////////////////////////////////////////บริษัท อันเด็น ประเทศไทย//////////////////////////////////////////////////////////////// -->

<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">
  <tbody>
  <tr style="border:1px solid #000;padding:4px;">
  <td colspan="2" style="font-size:14;" align="center">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด<br><br> 51 ม.4 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี  20160<br><br>โทร .038 452824-5 โทรสาร .038-210396</td>
  </tr>

  <tr style="border:1px solid #000;">
  <td colspan="2" align="center" style="font-size:16px;padding:5px;">ใบส่งของ (DELIVERY BILL)</td>
  </tr>
  <tr style="border:1px solid #000;padding:4px;">
  <td style="border-right:1px solid #000;padding:5px;width:80%"><b>วันที่ <?=$result_seMinvldate['MINDATEVLIN_103']?> - <?$result_seMaxvldate['MAXDATEVLIN_103']?></b></td>
  <td><b>เลขที่ <?= $result_seInvoice['INVOICECODE'] ?></b></td>
  </tr>
  <tr style="border:1px solid #000;padding:4px;">
  <td style="font-size:14;" colspan="2" align="center"><br>บริษัท อันเด็น  (ประเทศไทย) จำกัด <br><br>
  700/87 หมู่ 1 ถ.บางนา-ตราด กม.57 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี 20160<br><br><br>
  </td>
  </tr>
  <tr style="border:1px solid #000;">
  <td style="padding:5px;font-size:14;" colspan="2" align="center"><b><?=$result_seData11['JOBSTART']?></b></td>
  </tr>
  </tbody>
  </table>


<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
  <thead>

  <tr style="border:1px solid #000;padding:4px;">

  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ลำดับที่</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>วันที่</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><strong>ทะเบียนรถ</strong></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>พนักงานขับรถ</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>หมายเลขเส้นทาง</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ประเภทรถ</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>จำนวนเงิน(บาท)</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>หมายเหตุ</b></td>
  </tr>
  </thead><tbody>
    <?php
    $i = 1;
    $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
    $params_seBilling = array(
        array('select_pdfvehicletransportdocumentdriver-densothai1', SQLSRV_PARAM_IN),
        array($condBilling1, SQLSRV_PARAM_IN),
        array($condBilling2, SQLSRV_PARAM_IN),
        array($condBilling3, SQLSRV_PARAM_IN)
    );



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


        $sql_seData1 = "SELECT VEHICLETRANSPORTPLANID,ACTUALPRICE FROM VEHICLETRANSPORTDOCUMENTDIRVER WHERE DOCUMENTCODE = '".$result_seBilling['DOCUMENTCODE']."'";
        $query_seData1 = sqlsrv_query($conn, $sql_seData1, $params_seData1);
        $result_seData1 = sqlsrv_fetch_array($query_seData1, SQLSRV_FETCH_ASSOC);


        $sql_seData2 = "SELECT CONVERT(VARCHAR(10), a.DATEVLIN, 103) AS 'DATEVLIN_103',a.THAINAME,a.EMPLOYEENAME1,a.VEHICLETYPE,a.VEHICLETRANSPORTPRICEID FROM VEHICLETRANSPORTPLAN a
                        WHERE a.VEHICLETRANSPORTPLANID = '".$result_seData1['VEHICLETRANSPORTPLANID']."'";
        $query_seData2 = sqlsrv_query($conn, $sql_seData2, $params_seData2);
        $result_seData2 = sqlsrv_fetch_array($query_seData2, SQLSRV_FETCH_ASSOC);

        $sql_seData3 = "SELECT a.ROUTEDESCRIPTION,a.VEHICLETYPE,ROUTETYPE FROM VEHICLETRANSPORTPRICE a
                        WHERE a.VEHICLETRANSPORTPRICEID = '".$result_seData2['VEHICLETRANSPORTPRICEID']."'";
        $query_seData3 = sqlsrv_query($conn, $sql_seData3, $params_seData3);
        $result_seData3 = sqlsrv_fetch_array($query_seData3, SQLSRV_FETCH_ASSOC);
     ?>

      <tr style="border:1px solid #000;">
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$i?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seBilling['DATEVLIN_103']?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seData2['THAINAME']?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:left;"><?=$result_seData2['EMPLOYEENAME1']?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seData3['ROUTEDESCRIPTION']?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seData3['VEHICLETYPE']?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=number_format($result_seData1['ACTUALPRICE'])?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seData3['ROUTETYPE']?></td>
  </tr>
      <?php
      $i++;
      $sumtotal = $sumtotal + $result_seData1['ACTUALPRICE'];
  }
       ?>


</tbody><tfoot>
  <tr style="border:1px solid #000;">
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">รวมทั้งสิ้น</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=($i-1)?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">เที่ยว</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">รวมเป็นเงินทั้งสิ้น</td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= convert($sumtotal) ?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= number_format($sumtotal) ?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
  </tr>
  <tr style="border:1px solid #000;">

  <td colspan="4" style="padding:4px;text-align:center;"><br><br>ผู้รับของ. ______________________________________
  <br><br><br> วันที่.  ........................./......................../....................

  </td><br><br><br>
  <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br>ผู้ส่งของ. ______________________________________
  <br><br><br> วันที่.  ........................./......................../....................
  </td><br><br><br>

  </tr>
  </tfoot></table>




  </tbody><tfoot>
     <div id="rotated">
     <tr style="border:1px solid #000;">
     <td colspan="4" style="padding:4px;text-align:center;">FM-OPS-15/09</td>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
     <td colspan="4" style="padding:4px;text-align:center;">แก้ไขครั้งที่ : 00</td>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
     <td colspan="2" style="padding:4px;text-align:center;">มีผลบังคับใช้ : 01-02-49</td>
     </tr>
     </div>
  </tfoot></table>

  <!-- /////////////////////////////////////บริษัท แอร์ ซิสเต็มส์//////////////////////////////////////////////// -->
  <table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">
  <tbody>
  <tr style="border:1px solid #000;padding:4px;">
  <td colspan="2" style="font-size:14;" align="center">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด<br><br> 51 ม.4 ต.บ้านเก่า อ.พานทอง จ.ชลบุรี  20160<br><br>โทร .038 452824-5 โทรสาร .038-210396</td>
  </tr>

  <tr style="border:1px solid #000;">
  <td colspan="2" align="center" style="font-size:16px;padding:5px;">ใบส่งของ (DELIVERY BILL)</td>
  </tr>
  <tr style="border:1px solid #000;padding:4px;">
  <td style="border-right:1px solid #000;padding:5px;width:80%"><b>วันที่ <?=$result_seMinvldate['MINDATEVLIN_103']?> - <?=$result_seMaxvldate['MAXDATEVLIN_103']?></b></td>
  <td><b>เลขที่ <?= $result_seInvoice['INVOICECODE'] ?></b></td>
  </tr>
  <tr style="border:1px solid #000;padding:4px;">
  <td style="font-size:14;" colspan="2" align="center"><br>บริษัท แอร์ซิสเต็มส์  (ประเทศไทย) จำกัด <br><br>
  219/5-6 หมู่ 6 ต.บ่อวิน อ.ศรีราชา จ.ชลบุรี 20230<br><br><br>
  </td>
  </tr>
  <tr style="border:1px solid #000;">
  <td style="padding:5px;font-size:14;" colspan="2" align="center"><b><?=$result_seData11['JOBSTART']?></b></td>
  </tr>
  </tbody>
  </table>


<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
  <thead>

  <tr style="border:1px solid #000;padding:4px;">

  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ลำดับที่</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>วันที่</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><strong>ทะเบียนรถ</strong></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>พนักงานขับรถ</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 30%;"><b>หมายเลขเส้นทาง</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ประเภทรถ</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>จำนวนเงิน(บาท)</b></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>หมายเหตุ</b></td>
  </tr>
  </thead><tbody>

    <?php
    $i = 1;
    $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
    $params_seBilling = array(
        array('select_pdfvehicletransportdocumentdriver-densothai1', SQLSRV_PARAM_IN),
        array($condBilling1, SQLSRV_PARAM_IN),
        array($condBilling2, SQLSRV_PARAM_IN),
        array($condBilling3, SQLSRV_PARAM_IN)
    );



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


        $sql_seData1 = "SELECT VEHICLETRANSPORTPLANID,ACTUALPRICE FROM VEHICLETRANSPORTDOCUMENTDIRVER WHERE DOCUMENTCODE = '".$result_seBilling['DOCUMENTCODE']."'";
        $query_seData1 = sqlsrv_query($conn, $sql_seData1, $params_seData1);
        $result_seData1 = sqlsrv_fetch_array($query_seData1, SQLSRV_FETCH_ASSOC);


        $sql_seData2 = "SELECT CONVERT(VARCHAR(10), a.DATEVLIN, 103) AS 'DATEVLIN_103',a.THAINAME,a.EMPLOYEENAME1,a.VEHICLETYPE,a.VEHICLETRANSPORTPRICEID FROM VEHICLETRANSPORTPLAN a
                        WHERE a.VEHICLETRANSPORTPLANID = '".$result_seData1['VEHICLETRANSPORTPLANID']."'";
        $query_seData2 = sqlsrv_query($conn, $sql_seData2, $params_seData2);
        $result_seData2 = sqlsrv_fetch_array($query_seData2, SQLSRV_FETCH_ASSOC);

        $sql_seData3 = "SELECT a.ROUTEDESCRIPTION,a.VEHICLETYPE,ROUTETYPE FROM VEHICLETRANSPORTPRICE a
                        WHERE a.VEHICLETRANSPORTPRICEID = '".$result_seData2['VEHICLETRANSPORTPRICEID']."'";
        $query_seData3 = sqlsrv_query($conn, $sql_seData3, $params_seData3);
        $result_seData3 = sqlsrv_fetch_array($query_seData3, SQLSRV_FETCH_ASSOC);
     ?>





      <tr style="border:1px solid #000;">
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$i?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seBilling['DATEVLIN_103']?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seData2['THAINAME']?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:left;"><?=$result_seData2['EMPLOYEENAME1']?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seData3['ROUTEDESCRIPTION']?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seData3['VEHICLETYPE']?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=number_format($result_seData1['ACTUALPRICE'])?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seData3['ROUTETYPE']?></td>
  </tr>
    <?php
    $i++;
    $sumtotal = $sumtotal + $result_seData1['ACTUALPRICE'];
  }
     ?>


   </tbody><tfoot>
  <tr style="border:1px solid #000;">
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">รวมทั้งสิ้น</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><?=($i-1)?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">เที่ยว</td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">รวมเป็นเงินทั้งสิ้น</td>
  <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= convert($sumtotal) ?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b><?= number_format($sumtotal) ?></td>
  <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
  </tr>
  <tr style="border:1px solid #000;">

  <td colspan="4" style="padding:4px;text-align:center;"><br><br>ผู้รับของ. ______________________________________
  <br><br><br> วันที่.  ........................./......................../....................

  </td><br><br><br>
  <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;"><br><br>ผู้ส่งของ. ______________________________________
  <br><br><br> วันที่.  ........................./......................../....................
  </td><br><br><br>

  </tr>
  </tfoot></table>




  </tbody><tfoot>
     <div id="rotated">
     <tr style="border:1px solid #000;">
     <td colspan="4" style="padding:4px;text-align:center;">FM-OPS-15/09</td>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
     <td colspan="4" style="padding:4px;text-align:center;">แก้ไขครั้งที่ : 00</td>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
     <td colspan="2" style="padding:4px;text-align:center;">มีผลบังคับใช้ : 01-02-49</td>
     </tr>
     </div>
  </tfoot></table>

</body>
</html>
