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
    array('select_logbillinginvoice_all', SQLSRV_PARAM_IN),
    array($condBillinginvoice1, SQLSRV_PARAM_IN),
    array($condBillinginvoice2, SQLSRV_PARAM_IN)
);
$query_seBillinginvoice = sqlsrv_query($conn, $sql_seBillinginvoice, $params_seBillinginvoice);
$result_seBillinginvoice = sqlsrv_fetch_array($query_seBillinginvoice, SQLSRV_FETCH_ASSOC);

// $condInvoice1 = " AND INVOICECODE = '" . $result_seBillinginvoice['INVOICECODE'] . "'";
// $condInvoice2 = "";
// $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
// $params_seInvoice = array(
//     array('select_loginvoice', SQLSRV_PARAM_IN),
//     array($condInvoice1, SQLSRV_PARAM_IN),
//     array($condInvoice2, SQLSRV_PARAM_IN)
// );
// $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
// $result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC);




// $condBillings1 = " AND a.BILLINGCODE = '" . $_GET['billingcode'] . "'";
// $condBillings2 = "";
// $sql_seBillings = "{call megLogbillinginvoice_v2(?,?,?)}";
// $params_seBillings = array(
//     array('select_logbillinginvoice', SQLSRV_PARAM_IN),
//     array($condBillings1, SQLSRV_PARAM_IN),
//     array($condBillings2, SQLSRV_PARAM_IN)
// );
//
// $query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
// $result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);

$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,BILLING,COMPANYCODE,CUSTOMERCODE FROM [dbo].[LOGINVOICE] WHERE INVOICECODE ='" . $result_seBillinginvoice['INVOICECODE'] . "' ";

$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);

$sql_execTemp_billing = "{call megTempbilling(?,?,?,?,?,?,?)}";
$params_execTemp_billing = array(
    array('select_tempbilling_stc', SQLSRV_PARAM_IN),
    array($result_seInvoicecode['COMPANYCODE'], SQLSRV_PARAM_IN),
    array($result_seInvoicecode['CUSTOMERCODE'], SQLSRV_PARAM_IN),
    array($result_seInvoicecode['BILLINGDATE'], SQLSRV_PARAM_IN),
    array($result_seInvoicecode['PAYMENTDATE'], SQLSRV_PARAM_IN),
    array($result_seInvoicecode['BILLING'], SQLSRV_PARAM_IN),
    array($result_seBillinginvoice['INVOICECODE'], SQLSRV_PARAM_IN)
);
$query_execTemp_billing = sqlsrv_query($conn, $sql_execTemp_billing, $params_execTemp_billing);
$result_execTemp_billing = sqlsrv_fetch_array($query_execTemp_billing, SQLSRV_FETCH_ASSOC);






$i = 1;

$sql_seBilling1 = "SELECT DISTINCT  BILLINGDATE, INVOICECODE, NUMBER, JOBSTART, JOBEND, LOCATION, PRICETON, REMARK, BILLING
FROM TEMP_BILLINGSTC  WHERE INVOICECODE ='" . $result_seBillinginvoice['INVOICECODE'] . "'
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




    $sql_seBilling3 = "SELECT SUM(CONVERT(DECIMAL(10,3),CASE WHEN [WEIGHTIN] IS NULL THEN 0 ELSE [WEIGHTIN] END)/1000) AS 'WEIGHTIN'  FROM
    [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] WHERE [VEHICLETRANSPORTPLANID] IN (SELECT VEHICLETRANSPORTPLANID FROM TEMP_BILLINGSTC
    WHERE REMARK = '" . $result_seBilling1['REMARK'] . "' AND JOBSTART = '" . $result_seBilling1['JOBSTART'] . "' AND JOBEND = '" . $result_seBilling1['JOBEND'] . "') AND JOBSTART = '" . $result_seBilling1['JOBSTART'] . "' AND JOBEND = '" . $result_seBilling1['JOBEND'] . "'";
    $query_seBilling3 = sqlsrv_query($conn, $sql_seBilling3, $params_seBilling3);
    $result_seBilling3 = sqlsrv_fetch_array($query_seBilling3, SQLSRV_FETCH_ASSOC);

    $sql_seBilling4 = "SELECT DISTINCT SUM(CONVERT(DECIMAL(10,3),ACTUALPRICEHEAD)) AS 'PRICE' FROM TEMP_BILLINGSTC
    WHERE JOBSTART = '" . $result_seBilling1['JOBSTART'] . "' AND JOBEND = '" . $result_seBilling1['JOBEND'] . "'";
    $query_seBilling4 = sqlsrv_query($conn, $sql_seBilling4, $params_seBilling4);
    $result_seBilling4 = sqlsrv_fetch_array($query_seBilling4, SQLSRV_FETCH_ASSOC);

    $priceac = number_format($result_seBilling3['WEIGHTIN'], 3) * $result_seBilling1['PRICETON'];


    if ($result_seBilling1['REMARK'] == 'Charge 10') {
        $sql_seCnt10 = "SELECT COUNT(*) 'CNT' FROM TEMP_BILLINGSTC
    WHERE JOBSTART = '" . $result_seBilling1['JOBSTART'] . "' AND JOBEND = '" . $result_seBilling1['JOBEND'] . "' AND REMARK = 'Charge 10'";
        $query_seCnt10 = sqlsrv_query($conn, $sql_seCnt10, $params_seCnt10);
        $result_seCnt10 = sqlsrv_fetch_array($query_seCnt10, SQLSRV_FETCH_ASSOC);

        $price = (($result_seBilling1['PRICETON'] * 10) * $result_seCnt10['CNT']);

    } else if ($result_seBilling1['REMARK'] == 'Charge 7') {

        $sql_seCnt7 = "SELECT COUNT(*) 'CNT' FROM TEMP_BILLINGSTC
        WHERE JOBSTART = '" . $result_seBilling1['JOBSTART'] . "' AND JOBEND = '" . $result_seBilling1['JOBEND'] . "' AND REMARK = 'Charge 7'";
        $query_seCnt7 = sqlsrv_query($conn, $sql_seCnt7, $params_seCnt7);
        $result_seCnt7 = sqlsrv_fetch_array($query_seCnt7, SQLSRV_FETCH_ASSOC);

         $price = (($result_seBilling1['PRICETON'] * 7) * $result_seCnt7['CNT']);



    } else {
        $price = $result_seBilling1['PRICETON'] * $result_seBilling3['WEIGHTIN'];

    }





  $i++;
  $sumtotalprice = $sumtotalprice + $price;
  $sumtotalton = $sumtotalton + $result_seBilling3['WEIGHTIN'];
  }

$mpdf = new mPDF('th', 'A4', '0', '');
$style = '
<style>
	body{
		font-family: "Garuda";font-size:12px//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';

$table_header2 = '<table width="100%" >
    <tbody>
        <tr>
        	<td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
            <td colspan="7">บริษัท ร่วมกิจรุ่งเรือง (1993) จำกัด (RUAMKIT RUNGRUENG (1993) CO., LTD.)</td>
       </tr>
       <tr>
        	<td colspan="7">สำนักงานใหญ่  เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง จังหวัดชลบุรี 20160</td>
       </tr>
        <tr>
        	<td colspan="7">โทรศัพท์ : 038-452824-5 โทรสาร : 038-210396</td>
       </tr>
        <tr>
        	<td colspan="7">เลขประจำตัวผู้เสียภาษี 0105536076131</td>
       </tr>
       <tr>
        	<td colspan="8" style="text-align:center;">&nbsp;</td>
       </tr>
       <tr>
        	<td colspan="8" style="text-align:center;font-size:16px"><b>ใบวางบิล</b></td>
       </tr>
       <tr>
        	<td colspan="8" style="text-align:center;">&nbsp;</td>
       </tr>
    </tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;">
    <tbody>
        <tr style="border:1px solid #000;">
       	  <td style="border-right:1px solid #000;padding:4px;width:70%">ลูกค้า : รหัส ต-001
                <br>บริษัท โตโยต้า ทูโช (ไทยแลนด์) จำกัด
                <br>สำนักงานใหญ่ 607 ถ.อโศก-ดินแดง
                <br>แขวงดินแดง เขตดินแดง กรุงเทพฯ 10400
                <br>โทร. 02-6255555


		 </td>
            <td style="border-right:1px solid #000;padding:4px;width:30%">วันที่ : ' . $result_seBillinginvoice['DUEDATE'] . '</td>
       </tr>

    </tbody>
</table>';

$table_begin2 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead2 = '<thead>

        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>เลขที่ใบแจ้งหนี้</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>วันที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>วันครบกำหนด</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>จำนวนเงิน</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:20%"><b>ยอดชำระแล้ว</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%"><b>ยอดเงินคงค้าง</b></td>
      </tr>
  </thead><tbody>';
$i1 = 1;
$sql_seBillinginvoice2 = "{call megLogbillinginvoice_v2(?,?,?)}";
$params_seBillinginvoice2 = array(
    array('select_logbillinginvoice_all', SQLSRV_PARAM_IN),
    array($condBillinginvoice1, SQLSRV_PARAM_IN),
    array($condBillinginvoice2, SQLSRV_PARAM_IN)
);
$query_seBillinginvoice2 = sqlsrv_query($conn, $sql_seBillinginvoice2, $params_seBillinginvoice2);
while ($result_seBillinginvoice2 = sqlsrv_fetch_array($query_seBillinginvoice2, SQLSRV_FETCH_ASSOC)) {
    $tbody2 .= '<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" height="340px" valign="top">' . $i1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;"  valign="top">' . $result_seBillinginvoice2['INVOICECODE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;"  valign="top">' . $result_seBillinginvoice2['BILLINGDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;"  valign="top">' . $result_seBillinginvoice2['PAYMENTDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;"  valign="top">' . number_format($sumtotalprice, 2) . '</td>
        <td style="border-right:1px solid #000;padding:4px;"  valign="top"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;"  valign="top">' . number_format($sumtotalprice, 2) . '</td>
      </tr>
';

    $i1++;
    // $sumtotal = $sumtotal + $result_seBilling1['SUMTOTAL'];
}


$tfoot2 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td colspan="5" style="border-right:1px solid #000;padding:4px;text-align:center;">' . convert(($sumtotalprice)) . '</td>
            <td style="border-right:1px solid #000;padding:4px;">รวมเงินทั้งสิ้น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format(($sumtotalprice), 2) . '</td>
      </tr>

       <tr style="border:1px solid #000;">
        <td colspan="5" rowspan="2" style="border-right:1px solid #000;padding:4px;"></td>
        <td style="border-right:1px solid #000;padding:4px;">ภาษีหัก ณ ที่จ่าย 1 %</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format((($sumtotalprice) * 1) / 100, 2) . '</td>

      </tr>
       <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;">ยอดต้องชำระ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format(($sumtotalprice) - ((($sumtotalprice) * 1) / 100), 2) . '</td>
      </tr>
    </tfoot>';

$table_end2 = '</table>';

$table_footer2 = '<br />
<br />
<br />
<br />
<br />
<br />
<br />




<table width="100%" style="border-collapse: collapse;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:14px;width:35%"><br /><br /><br />วันนัดชำระเงิน / Payment Date<br /><br />___/___/___</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:14px;width:30%"><br /><br /><hr /><br />ผู้รับวางบิล / Received By<br /><br />___/___/___</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:14px;width:35%"><br /><br /><hr /><br />ผู้วางบิล / Delivery By<br /><br />___/___/___</td>
    </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>';

$table_header1 = '<table width="100%" >
   <tbody>
        <tr>
        	<td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
            <td colspan="7">บริษัท ร่วมกิจรุ่งเรือง (1993) จำกัด (RUAMKIT RUNGRUENG (1993) CO., LTD.)</td>
       </tr>
       <tr>
        	<td colspan="7">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง จังหวัดชลบุรี 20160</td>
       </tr>
        <tr>
        	<td colspan="7">โทรศัพท์ : 038-452824-5 โทรสาร : 038-210396</td>
       </tr>
        <tr>
        	<td colspan="7">เลขประจำตัวผู้เสียภาษี 0105536076131</td>
       </tr>
       <tr>
        	<td colspan="8" style="text-align:center;">&nbsp;</td>
       </tr>
       <tr>
        	<td colspan="8" style="text-align:center;font-size:16px"><b>ใบแจ้งหนี้/ใบเสร็จรับเงิน</b></td>
       </tr>
       <tr>
        	<td colspan="8" style="text-align:center;">&nbsp;</td>
       </tr>
    </tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;">
    <tbody>
        <tr style="border:1px solid #000;" >
        <td style="border-right:1px solid #000;padding:4px;width:70%" rowspan="4">ลูกค้า : รหัส ต-001
            <br>บริษัท โตโยต้า ทูโช (ไทยแลนด์) จำกัด
            <br>สำนักงานใหญ่ 607 ถ.อโศก-ดินแดง
            <br>แขวงดินแดง เขตดินแดง กรุงเทพฯ 10400
            <br>โทร. 02-6255555
            <br>เลขประจำตัวผู้เสียภาษี 010550000001

		 </td>



            <td style="border-right:1px solid #000;padding:4px;width:30%">เลขที่ : ' . $result_seBillinginvoice['INVOICECODE'] . '</td>
       </tr>
       <tr style="border:1px solid #000;">
       	  <td style="border-right:1px solid #000;padding:4px;width:30%">วันที่ : ' . $result_seBillinginvoice['DUEDATE'] . '</td>
       </tr>
       <tr style="border:1px solid #000;">
       	  <td style="border-right:1px solid #000;padding:4px;width:30%">เครดิต : 30 วัน</td>
       </tr>
       <tr style="border:1px solid #000;">
       	  <td style="border-right:1px solid #000;padding:4px;width:30%">วันที่ครบกำหนด : ' . $result_seBillinginvoice['PAYMENTDATE'] . '</td>
       </tr>


    </tbody>
</table>';

$table_begin1 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead1 = '<thead>

        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:60%"><b>รายการ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:30%"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
  </thead><tbody>';
$i2 = 1;
$sql_seBillinginvoice1 = "{call megLogbillinginvoice_v2(?,?,?)}";
$params_seBillinginvoice1 = array(
    array('select_logbillinginvoice_all', SQLSRV_PARAM_IN),
    array($condBillinginvoice1, SQLSRV_PARAM_IN),
    array($condBillinginvoice2, SQLSRV_PARAM_IN)
);
$query_seBillinginvoice1 = sqlsrv_query($conn, $sql_seBillinginvoice1, $params_seBillinginvoice1);
while ($result_seBillinginvoice1 = sqlsrv_fetch_array($query_seBillinginvoice1, SQLSRV_FETCH_ASSOC)) {
    $tbody1 .= '<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" valign="top">' . $i2 . '</td>
        <td style="border-right:1px solid #000;padding:4px;" height="300px" valign="top">ค่าขนส่งสินค้าตามเอกสารแนบ
        <br><br>จำนวนตันรวม ' .number_format($sumtotalton,3)  . ' ตัน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;" valign="top">' . number_format($sumtotalprice, 2) . '</td>

      </tr>
';

    $i2++;
    // $sumtotal = $sumtotal + $result_seBillinginvoice1['SUMTOTAL'];
}

$tfoot1 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center">รวมเงิน</td>
            <td style="border-right:1px solid #000;padding:4px;">' . convert($sumtotalprice) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($sumtotalprice, 2) . '</td>
      </tr>

    </tfoot>';

$table_end1 = '</table>';

$table_footer1 = '<br />
<table width="100%" style="border-collapse: collapse;margin-top:8px;">
<tbody>
<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:14px;width:34%">ได้รับบริการตามรายการเรียบร้อยแล้ว<br><br><br><br><br><br><br><br><br><br><br><br>ผู้รับบริการ.........................................<br><br>ลงวันที่................/................/............</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:14px;width:34%">การชำระเงิน<br><br><input type="checkbox" size="5" /> เงินสด&emsp;<input type="checkbox" size="5" checked="checked"/> โอนเงิน<br><br><input type="checkbox"  size="5" /> เช็คธนาคาร................................<br><br>เลขที่.............วันที่......../......../.......<br><br>จำนวนเงิน......................................<br><br><br><br>ผู้รับเงิน..........................................<br><br>ลงวันที่............/............./.............</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:14px;width:32%">ในนาม บริษัท ร่วมกิจรุ่งเรือง (1993) จำกัด<br><br><br><br><br><br><br><br><br><br>.....................................................................<br><br>ลงวันที่............./............/.............<br><br>ผู้มีอำนาจลงนาม / Authorized Signature</td>
    </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>';
$table_remark1 = '<br /><table width="100%" >
    <tbody>
        <tr>
        	<td style="width:10%"><b><u>หมายเหตุ</u> :</b></td>
            <td style="width:90%">1.ค่าขนส่งภาษีหัก ณ ที่จ่าย 1 %</td>
       </tr>
       <tr>
        	<td style="width:10%"></td>
            <td style="width:90%">2.ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์ เมื่อมีลายเซ็นผู้รับเงิน และได้รับเงินตามเช็ค หรือ เงินโอนเข้าบัญชีเรียบร้อยแล้ว</td>
       </tr>
       <tr>
        	<td style="width:10%"></td>
            <td style="width:90%">3.ผู้รับบริการชำระเกินกำหนดที่ระบุไว้ในใบแจ้งหนี้ ผู้รับบริการยินยอมชำระค่าปรับร้อยละ 15 ต่อปี ของจำนวนเงินที่ค้างชำระ</td>
       </tr>
       <tr>
            <td colspan="2">FM-ADM-10/01 แก้ไขครั้งที่ : 01 มีผลบังคับใช้ : 01-09-60</td>
       </tr>
    </tbody>
</table>';




$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_header2);
$mpdf->WriteHTML($table_begin2);
$mpdf->WriteHTML($thead2);
$mpdf->WriteHTML($tbody2);
$mpdf->WriteHTML($tfoot2);
$mpdf->WriteHTML($table_end2);
$mpdf->WriteHTML($table_footer2);
$mpdf->AddPage();
$mpdf->WriteHTML($table_header1);
$mpdf->WriteHTML($table_begin1);
$mpdf->WriteHTML($thead1);
$mpdf->WriteHTML($tbody1);
$mpdf->WriteHTML($tfoot1);
$mpdf->WriteHTML($table_end1);
$mpdf->WriteHTML($table_footer1);
$mpdf->WriteHTML($table_remark1);


$mpdf->Output();



sqlsrv_close($conn);
?>
