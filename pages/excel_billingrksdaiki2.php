<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
$sumtotal = "";

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$condBillinginvoice1 = " AND a.BILLINGCODE = '" . $_GET['billingcode'] . "'";
$condBillinginvoice2 = "";
$sql_seBillinginvoice = "{call megLogbillinginvoice_v2(?,?,?)}";
$params_seBillinginvoice = array(
    array('select_logbillinginvoice', SQLSRV_PARAM_IN),
    array($condBillinginvoice1, SQLSRV_PARAM_IN),
    array($condBillinginvoice2, SQLSRV_PARAM_IN)
);
$query_seBillinginvoice = sqlsrv_query($conn, $sql_seBillinginvoice, $params_seBillinginvoice);
$result_seBillinginvoice = sqlsrv_fetch_array($query_seBillinginvoice, SQLSRV_FETCH_ASSOC);






$condBillings1 = " AND a.BILLINGCODE = '" . $_GET['billingcode'] . "'";
$condBillings2 = "";
$sql_seBillings = "{call megLogbillinginvoice_v2(?,?,?)}";
$params_seBillings = array(
    array('select_logbillinginvoice', SQLSRV_PARAM_IN),
    array($condBillings1, SQLSRV_PARAM_IN),
    array($condBillings2, SQLSRV_PARAM_IN)
);

$query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
$result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);

if ($_GET['billingcode'] == "" || $_GET['billingcode'] == "") {
  $strExcelFileName = "RKSDAIKI_Billing.xls";
} else {
  $strExcelFileName = "RKSDAIKI_Billing" . $_GET['billingcode'] . ".xls";
}
// $strExcelFileName="Member-All.xls";

header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");
?>



<style>
	body{
		font-family: "Garuda";font-size:12px;
	}
</style>

<table width="100%" >
    <tbody>
        <tr>
        	<td colspan="2" rowspan="4" style="text-align:center"></td>
            <td colspan="6" style="font-size:20px"><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO.,LTD.)<b></td>
       </tr>
       <tr>
        	<td colspan="8" style="font-size:18px" >สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160</td>
       </tr>
        <tr>
        	<td colspan="8" style="font-size:18px">โทรศัพท์: 038-452824-5 โทรสาร : 038-210396</td>
       </tr>
        <tr>
        	<td colspan="8" style="font-size:18px">เลขประจำตัวผู้เสียภาษี 0105544064899</td>
       </tr>
       <tr>
        	<td colspan="8" style="text-align:center;">&nbsp;</td>
       </tr>
       <tr>
        	<td colspan="8" style="text-align:center;font-size:20px"><b>ใบวางบิล</b></td>
       </tr>
       <tr>
        	<td colspan="8" style="text-align:center;">&nbsp;</td>
       </tr>
    </tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;font-size:16px">
    <tbody>
        <tr style="border:1px solid #000;">
       	  <td colspan="5" style="border-right:1px solid #000;padding:4px;font-size:16px">ลูกค้า : รหัส ด-007
								<br>บริษัท ไดกิ อลูมิเนียม อินดัสทรี (ประเทศไทย) จำกัด
								<br>สำนักงานใหญ่ ที่อยู่ 700/99 ม.1 ต.บ้านเก่า
								<br>อ.พานทอง จ.ชลบุรี 20160
								<br>โทร. 038-468441,038-458862-3
		 </td>

            <td colspan="3" style="border-right:1px solid #000;padding:4px;font-size:16px">
              <br>วันที่ : <?= $result_seBillinginvoice['DUEDATE'] ?>
              <br>
              <br>
              <br>
            </td>
       </tr>

    </tbody>
</table>

<table width="100%" style="border-collapse: collapse;margin-top:8px;"></table>

<table width="100%" style="border-collapse: collapse;margin-top:8px;">
<thead>

        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center; "><b>ลำดับ</b></td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>เลขที่ใบแจ้งหนี้</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>วันที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>วันครบกำหนด</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>จำนวนเงิน</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ยอดชำระแล้ว</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ยอดเงินคงค้าง</b></td>
      </tr>
  </thead>
  <tbody>
    <?php
    $i1 = 1;
    $sql_seBillinginvoice2 = "{call megLogbillinginvoice_v2(?,?,?)}";
    $params_seBillinginvoice2 = array(
        array('select_logbillinginvoice', SQLSRV_PARAM_IN),
        array($condBillinginvoice1, SQLSRV_PARAM_IN),
        array($condBillinginvoice2, SQLSRV_PARAM_IN)
    );
    $query_seBillinginvoice2 = sqlsrv_query($conn, $sql_seBillinginvoice2, $params_seBillinginvoice2);
    while ($result_seBillinginvoice2 = sqlsrv_fetch_array($query_seBillinginvoice2, SQLSRV_FETCH_ASSOC)) {

     ?>
    <tr style="">
        <td style="border-right:1px solid #000;border-left:1px solid #000;padding:4px;text-align:center;" rowspan="12" valign="top"><?= $i1 ?></td>
        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;" rowspan="12" valign="top"><?= $result_seBillinginvoice2['INVOICECODE'] ?></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" rowspan="12" valign="top"><?= $result_seBillinginvoice2['BILLINGDATE'] ?></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" rowspan="12" valign="top"><?= $result_seBillinginvoice2['PAYMENTDATE'] ?></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;" rowspan="12" valign="top"><?= number_format($result_seBillinginvoice2['SUMTOTAL'], 2) ?></td>
        <td style="border-right:1px solid #000;padding:4px;" rowspan="12" valign="top"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;" rowspan="12" valign="top"><?= number_format($result_seBillinginvoice2['SUMTOTAL'], 2) ?></td>
      </tr>

<?php
$i1++;
$sumtotal = $sumtotal + $result_seBilling1['SUMTOTAL'];
}
 ?>

</tbody>
</table>

<table width="100%" style="border-collapse: collapse;margin-top:8px;">
  <thead>

    <tr style="border:1px solid #000;">
        <td bgcolor="#CCCCCC" colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= convert(($result_seBillinginvoice['SUMTOTAL'])) ?></td>
        <td style="border-right:1px solid #000;padding:4px;">รวมเงินทั้งสิ้น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;"><?= number_format(($result_seBillinginvoice['SUMTOTAL']), 2) ?></td>
      </tr>

       <tr style="">
        <td colspan="6" style="border-right:1px solid #000;padding:4px;"></td>
        <td style="border-right:1px solid #000;padding:4px;">ภาษีหัก ณ ที่จ่าย 1 %</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;"><?= number_format((($result_seBillinginvoice['SUMTOTAL']) * 1) / 100, 2) ?></td>

      </tr>
       <tr  style="">
        <td colspan="6" style="border-right:1px solid #000;padding:4px;"></td>
        <td style="border:1px solid #000;padding:4px;">ยอดต้องชำระ</td>
        <td style="border:1px solid #000;padding:4px;text-align:right;"><?= number_format(($result_seBillinginvoice['SUMTOTAL']) - ((($result_seBillinginvoice['SUMTOTAL']) * 1) / 100), 2) ?></td>
      </tr>

  </thead>
</table>


<table width="100%" style=""></table>

<table width="100%" style="border-collapse: collapse;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;">
        <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">
        <br><br>
        <br><br>วันนัดชำระเงิน / Payment Date
        <br><br>_______/_______/_______
        <br><br>
        </td>

        <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;">
        <br><br>____________________________
        <br><br>ผู้วางบิล / Received By
        <br><br>_______/_______/_______
        <br><br>
        </td>

        <td colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;">
        <br><br>____________________________
        <br><br>ผู้วางบิล / Delivery By
        <br><br>_______/_______/_______
        <br><br>
        </td>
    </tr>
    </tbody>
</table>

<br><br><br><br>

<table width="100%" >
    <tbody>
        <tr>
         <td colspan="2" rowspan="4" style="text-align:center"></td>
            <td colspan="6" style="font-size:20px"><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO.,LTD.)<b></td>
       </tr>
       <tr>
         <td colspan="8" style="font-size:16px" >สำนักงานสาขาที่ 2 เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160</td>
       </tr>
        <tr>
         <td colspan="8" style="font-size:16px">โทรศัพท์: 038-452824-5 โทรสาร : 038-210396</td>
       </tr>
        <tr>
         <td colspan="8" style="font-size:16px">เลขประจำตัวผู้เสียภาษี 0105544064899</td>
       </tr>
       <tr>
         <td colspan="8" style="text-align:center;">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="8" style="text-align:center;font-size:17px"><b>ใบแจ้งหนี้/ใบเสร็จรับเงิน</b></td>
       </tr>
       <tr>
         <td colspan="8" style="text-align:center;">&nbsp;</td>
       </tr>
    </tbody>
</table>

<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;font-size:16px;">
    <tbody>
        <tr style="border:1px solid #000;" >
         <td colspan="5" style="border-right:1px solid #000;padding:4px;font-size:16px" rowspan="4">

                ลูกค้า : รหัส ด-007
								<br>บริษัท ไดกิ อลูมิเนียม อินดัสทรี (ประเทศไทย) จำกัด
								<br>สำนักงานใหญ่ ที่อยู่ 700/99 ม.1 ต.บ้านเก่า
								<br>อ.พานทอง จ.ชลบุรี 20160
								<br>โทร. 038-468441,038-458862-3
                <br>เลขประจำตัวผู้เสียภาษี 0105542046974
		      </td>
            <td colspan="3" style="border-right:1px solid #000;padding:4px;width:30%" rowspan="4">
            <br>
            เลขที่ : <?= $result_seBillinginvoice['INVOICECODE'] ?>
            <br>วันที่ : <?= $result_seBillinginvoice['BILLINGDATE'] ?>
            <br>เครดิต : 30 วัน
            <br>วันที่ครบกำหนด : <?= $result_seBillinginvoice['PAYMENTDATE'] ?>
            <br>
            <br>
          </td>

       </tr>
    </tbody>
</table>

<table width="100%" style="border-collapse: collapse;margin-top:8px;">

<table width="100%" style="border-collapse: collapse;margin-top:8px;">
<thead>

        <tr style="border:1px solid #000;padding:4px;">
        <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ลำดับ</b></td>
        <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>รายการ</b></td>
        <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
  </thead><tbody>
    <?php
    $i2 = 1;
    $sql_seBillinginvoice1 = "{call megLogbillinginvoice_v2(?,?,?)}";
    $params_seBillinginvoice1 = array(
        array('select_logbillinginvoice', SQLSRV_PARAM_IN),
        array($condBillinginvoice1, SQLSRV_PARAM_IN),
        array($condBillinginvoice2, SQLSRV_PARAM_IN)
    );
    $query_seBillinginvoice1 = sqlsrv_query($conn, $sql_seBillinginvoice1, $params_seBillinginvoice1);
    while ($result_seBillinginvoice1 = sqlsrv_fetch_array($query_seBillinginvoice1, SQLSRV_FETCH_ASSOC)) {
     ?>

<tr style="border:1px solid #000;">
        <td colspan="1" rowspan="12" style="border-right:1px solid #000;padding:4px;text-align:center;" valign="top"><?= $i2 ?></td>
        <td colspan="4" rowspan="12" style="border-right:1px solid #000;padding:4px;"  valign="top">ค่าขนส่งสินค้าตามเอกสารแนบ</td>
        <td colspan="3" rowspan="12" style="border-right:1px solid #000;padding:4px;text-align:right;" valign="top"><?= number_format($result_seBillinginvoice1['SUMTOTAL'], 2) ?></td>
      </tr>
<?php
$i2++;
$sumtotal = $sumtotal + $result_seBillinginvoice1['SUMTOTAL'];
}

 ?>

</tbody>
</table>

<table>
  <tbody>
    <tr style="border:1px solid #000;">
        <td colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center">รวมเงิน</td>
        <td colspan="4" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;"><?= convert($result_seBillinginvoice['SUMTOTAL']) ?></td>
        <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:right;"><?= number_format($result_seBillinginvoice['SUMTOTAL'], 2) ?></td>
      </tr>
  </tbody>
</table>
<br>

<table width="100%" style="border-collapse: collapse;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;">
        <td colspan="3" style="border-right:1px solid #000;padding:4px;text-align:left;">
          ได้รับบริการตามรายการเรียบร้อยแล้ว
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          ผู้รับบริการ.......................................
          <br>
          ลงวันที่............../............../............
        </td>
        <td colspan="2"  style="border-right:1px solid #000;padding:4px;text-align:left;">
          การชำระเงิน
          <br>&emsp;&emsp;&emsp;&emsp;เงินสด &emsp;&emsp;&emsp;&emsp;โอนเงิน
          <br>&emsp;&emsp;&emsp;&emsp;เช็คธนาคาร...........................................
          <br>เลขที่..................วันที่........../........../..........
          <br>จำนวนเงิน..................................................
          <br>
          <br>

          ผู้รับเงิน...................................................
          <br>
          ลงวันที่................./................./................
        </td>
        <td colspan="3"  style="border-right:1px solid #000;padding:4px;text-align:center;">
          ในนาม บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด
          <br>
          <br>
          <br>
          <br>
          <br>
          .............................................................
          <br>
          ลงวันที่................../................../..................
          <br>
          ผู้มีอำนาจลงนาม / Authorized Signature
        </td>
    </tr>
    </tbody>

</table>
<br />
<table width="100%" >
    <tbody>
        <tr>
        	<td colspan="1" style=""><b><u>หมายเหตุ :</u> </b></td>
            <td colspan="7" style="">1.ค่าขนส่งภาษีหัก ณ ที่จ่าย 1 %</td>
       </tr>
       <tr>
        	<td colspan="1" style=""></td>
            <td colspan="7" style="">2.ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์ เมื่อมีลายเซ็นผู้รับเงิน และได้รับเงินตามเช็ค หรือ เงินโอนเข้าบัญชีเรียบร้อยแล้ว</td>
       </tr>
       <tr>
        	<td colspan="1" style=""></td>
            <td colspan="7" style="">3.ผู้รับบริการชำระเกินกำหนดที่ระบุไว้ในใบแจ้งหนี้ ผู้รับบริการยินยอมชำระค่าปรับร้อยละ 15 ต่อปี ของจำนวนเงินที่ค้างชำระ</td>
       </tr>
       <br><br>
       <tr>
            <td colspan="4">FM-ADM-10/01 แก้ไขครั้งที่ : 01 มีผลบังคับใช้ : 01-09-60</td>
       </tr>
    </tbody>
</table>
