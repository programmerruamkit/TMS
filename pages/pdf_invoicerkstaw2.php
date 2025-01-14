<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
// $sumtotal = "";

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

$sql_sejobend = "SELECT TOP 1 TRANSPORTATION AS 'JOBEND',BILLINGDATE,PAYMENTDATE
                FROM [dbo].[LOGINVOICE] WHERE INVOICECODE ='" . $result_seBillinginvoice['INVOICECODE'] . "'";
$params_sejobend = array();
$query_sejobend = sqlsrv_query($conn, $sql_sejobend, $params_sejobend);
$result_sejobend = sqlsrv_fetch_array($query_sejobend, SQLSRV_FETCH_ASSOC);

$sql_sumprice = "SELECT SUM(CONVERT(DECIMAL(10,3),a.ACTUALPRICE)) AS 'SUMACTUALPRICE'
FROM (SELECT CONVERT(VARCHAR(30), a.DATEVLIN, 103)  AS 'DATE_VLIN',
a.THAINAME AS 'THAINAME',a.EMPLOYEENAME1 AS 'EMPLOYEENAME1',a.JOBSTART AS 'JOBSTART',
a.JOBEND AS 'JOBEND',c.PRICE AS 'ACTUALPRICE',b.DOCUMENTCODE
FROM  [dbo].[VEHICLETRANSPORTPLAN] a
INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] c ON c.[VEHICLETRANSPORTPRICEID] = b.[VEHICLETRANSPORTPRICEID]
WHERE 1 = 1
AND a.COMPANYCODE ='RKS' AND a.CUSTOMERCODE ='TAW'
AND b.DOCUMENTCODE !='' AND b.DOCUMENTCODE IS NOT NULL
AND b.DOCUMENTCODE !='LOAD'
AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'".$result_sejobend['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_sejobend['PAYMENTDATE']."',103)
) a";
$params_sumprice = array();
$query_sumprice = sqlsrv_query($conn, $sql_sumprice, $params_sumprice);
$result_sumprice = sqlsrv_fetch_array($query_sumprice, SQLSRV_FETCH_ASSOC);

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


$condBilling1 = " AND a.INVOICECODE = '" . $result_seBillings['INVOICECODE'] . "'";
$condBilling2 = "";
$sql_seBilling1 = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
$params_seBilling1 = array(
    array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
    array($condBilling1, SQLSRV_PARAM_IN),
    array($condBilling2, SQLSRV_PARAM_IN)
);

$query_seBilling1 = sqlsrv_query($conn, $sql_seBilling1, $params_seBilling1);
while ($result_seBilling1 = sqlsrv_fetch_array($query_seBilling1, SQLSRV_FETCH_ASSOC)) {




    // if ($result_seBilling1['PAY_EXPRESSWAY45'] == '45') {
    //     $expressway45 = "1";
    //     $sumexpressway45 = $expressway45 * 45;
    // } else {
    //     $expressway45 = "";
    //     $sumexpressway45 = "0";
    // }

    // if ($result_seBilling1['PAY_EXPRESSWAY55'] == '55') {
    //     $expressway55 = "1";
    //     $sumexpressway55 = $expressway55 * 55;
    // } else {
    //     $expressway55 = "";
    //     $sumexpressway55 = "0";
    // }
    // if ($result_seBilling1['PAY_EXPRESSWAY65'] == '65') {
    //     $expressway65 = "1";
    //     $sumexpressway65 = $expressway65 * 65;
    // } else {
    //     $expressway65 = "";
    //     $sumexpressway65 = "0";
    // }
    // if ($result_seBilling1['PAY_EXPRESSWAY65RETURN'] == '65') {
    //     $expressway65return = "1";
    //     $sumexpressway65return = $expressway65return * 65;
    // } else {
    //     $expressway65return = "";
    //     $sumexpressway65return = "0";
    // }

    // if ($result_seBilling1['PAY_EXPRESSWAY75'] == '75') {
    //     $expressway75 = "1";
    //     $sumexpressway75 = $expressway75 * 75;
    // } else {
    //     $expressway75 = "";
    //     $sumexpressway75 = "0";
    // }
    // if ($result_seBilling1['PAY_EXPRESSWAY195'] == '195') {
    //     $expressway195 = "1";
    //     $sumexpressway195 = $expressway195 * 195;
    // } else {
    //     $expressway195 = "";
    //     $sumexpressway195 = "0";
    // }

    // $cntexpressway45 += $expressway45;
    // $cntsumexpressway45 += $sumexpressway45;
    // $cntexpressway55 += $expressway55;
    // $cntsumexpressway55 += $sumexpressway55;
    // $cntexpressway65 += $expressway65;
    // $cntsumexpressway65 += $sumexpressway65;
    // $cntexpressway65return += $expressway65return;
    // $cntsumexpressway65return += $sumexpressway65return;
    // $cntexpressway75 += $expressway75;
    // $cntsumexpressway75 += $sumexpressway75;
    // $cntexpressway195 += $expressway195;
    // $cntsumexpressway195 += $sumexpressway195;
    // $cntalltrip += ($expressway45 + $expressway55 + $expressway65 + $expressway65return + $expressway75 + $expressway195);
    // $cntallprice += ($sumexpressway45 + $sumexpressway55 + $sumexpressway65 + $sumexpressway65return + $sumexpressway75 + $sumexpressway195);
}
// $data45 = ($cntexpressway45 != "0") ? "Express Way STM-TAW = " . $cntexpressway45 . " TRIP x 45 PRICE <br>" : "";
// $data55 = ($cntexpressway55 != "0") ? "Express Way STM-TAW = " . $cntexpressway55 . " TRIP x 55 PRICE <br>" : "";
// $data65 = ($cntexpressway65 != "0") ? "Express Way STM-TAW = " . $cntexpressway65 . " TRIP x 65 PRICE <br>" : "";
// $data65return = ($cntexpressway65return != "0") ? "Express Way STM-TAW = " . $cntexpressway65return . " TRIP x 65 PRICE <br>" : "";
// $data75 = ($cntexpressway75 != "0") ? "Express Way STM-TAW = " . $cntexpressway75 . " TRIP x 75 PRICE <br>" : "";
// $data195 = ($cntexpressway195 != "0") ? "Express Way STM-TAW = " . $cntexpressway195 . " TRIP x 195 PRICE" : "";

// $price45 = ($cntexpressway45 != "0") ? number_format(($cntexpressway45 * 45),2)." <br>" : "";
// $price55 = ($cntexpressway55 != "0") ? number_format(($cntexpressway55 * 55),2)." <br>" : "";
// $price65 = ($cntexpressway65 != "0") ? number_format(($cntexpressway65 * 65),2)." <br>" : "";
// $price65return = ($cntexpressway65return != "0") ? number_format(($cntexpressway65return * 65),2)." <br>" : "";
// $price75 = ($cntexpressway75 != "0") ? number_format(($cntexpressway75 * 75),2)." <br>" : "";
// $price195 = ($cntexpressway195 != "0") ? number_format(($cntexpressway195 * 195),2) : "";
// $totalprice = ($price45 + $price55 + $price65 + $price65return + $price75 + $price195);


  $sql_seHoliday = " SELECT HOLIDAY AS 'DATE' FROM [dbo].[BILLING_HOLIDAY] WHERE INVOICECODE ='".$result_seBillinginvoice['INVOICECODE']."'
    AND COMPANYCODE ='RKS' AND CUSTOMERCODE = 'TAW' ";
  $params_seHoliday = array();
  $query_seHoliday = sqlsrv_query($conn, $sql_seHoliday, $params_seHoliday);
  $result_seHoliday = sqlsrv_fetch_array($query_seHoliday, SQLSRV_FETCH_ASSOC);

  $counts = 0;
  $holiday = $result_seHoliday['DATE'];
  // $holiday = $result_seHoliday['DATE'];
  if ($holiday !='') {
    $holidaysplit = explode(",", $holiday);
    if ($holidaysplit[0] !='') {
      $sql_seCount0 = " SELECT COUNT(VEHICLETRANSPORTPLANID) AS 'COUNT_HOLIDAY0' 
        FROM [dbo].[VEHICLETRANSPORTPLAN] 
        WHERE COMPANYCODE ='RKS' AND CUSTOMERCODE ='SWN'
        AND DOCUMENTCODE !='' AND DOCUMENTCODE IS NOT NULL
        AND CONVERT(DATE,DATEVLIN) = CONVERT(DATE,'$holidaysplit[0]',103) ";
      $params_seCount0 = array();
      $query_seCount0 = sqlsrv_query($conn, $sql_seCount0, $params_seCount0);
      $result_seCount0 = sqlsrv_fetch_array($query_seCount0, SQLSRV_FETCH_ASSOC);
      $count0 = $result_seCount0['COUNT_HOLIDAY0'];
    }if ($holidaysplit[1] !='') {
      $sql_seCount1 = " SELECT COUNT(VEHICLETRANSPORTPLANID) AS 'COUNT_HOLIDAY1' 
        FROM [dbo].[VEHICLETRANSPORTPLAN] 
        WHERE COMPANYCODE ='RKS' AND CUSTOMERCODE ='SWN'
        AND DOCUMENTCODE !='' AND DOCUMENTCODE IS NOT NULL
        AND CONVERT(DATE,DATEVLIN) = CONVERT(DATE,'$holidaysplit[1]',103) ";
      $params_seCount1 = array();
      $query_seCount1 = sqlsrv_query($conn, $sql_seCount1, $params_seCount1);
      $result_seCount1 = sqlsrv_fetch_array($query_seCount1, SQLSRV_FETCH_ASSOC);
      $count1 = $result_seCount1['COUNT_HOLIDAY1'];
    }if ($holidaysplit[2] !='') {
      $sql_seCount2 = " SELECT COUNT(VEHICLETRANSPORTPLANID) AS 'COUNT_HOLIDAY2' 
        FROM [dbo].[VEHICLETRANSPORTPLAN] 
        WHERE COMPANYCODE ='RKS' AND CUSTOMERCODE ='SWN'
        AND DOCUMENTCODE !='' AND DOCUMENTCODE IS NOT NULL
        AND CONVERT(DATE,DATEVLIN) = CONVERT(DATE,'$holidaysplit[2]',103) ";
      $params_seCount2 = array();
      $query_seCount2 = sqlsrv_query($conn, $sql_seCount2, $params_seCount2);
      $result_seCount2 = sqlsrv_fetch_array($query_seCount2, SQLSRV_FETCH_ASSOC);
      $count2 = $result_seCount2['COUNT_HOLIDAY2'];
    }if ($holidaysplit[3] !='') {
      $sql_seCount3 = " SELECT COUNT(VEHICLETRANSPORTPLANID) AS 'COUNT_HOLIDAY3' 
        FROM [dbo].[VEHICLETRANSPORTPLAN] 
        WHERE COMPANYCODE ='RKS' AND CUSTOMERCODE ='SWN'
        AND DOCUMENTCODE !='' AND DOCUMENTCODE IS NOT NULL
        AND CONVERT(DATE,DATEVLIN) = CONVERT(DATE,'$holidaysplit[3]',103) ";
      $params_seCount3 = array();
      $query_seCount3 = sqlsrv_query($conn, $sql_seCount3, $params_seCount3);
      $result_seCount3 = sqlsrv_fetch_array($query_seCount3, SQLSRV_FETCH_ASSOC);
      $count3 = $result_seCount3['COUNT_HOLIDAY3'];
    }if ($holidaysplit[4] !='') {
      $sql_seCount4 = " SELECT COUNT(VEHICLETRANSPORTPLANID) AS 'COUNT_HOLIDAY4' 
        FROM [dbo].[VEHICLETRANSPORTPLAN] 
        WHERE COMPANYCODE ='RKS' AND CUSTOMERCODE ='SWN'
        AND DOCUMENTCODE !='' AND DOCUMENTCODE IS NOT NULL
        AND CONVERT(DATE,DATEVLIN) = CONVERT(DATE,'$holidaysplit[4]',103) ";
      $params_seCount4 = array();
      $query_seCount4 = sqlsrv_query($conn, $sql_seCount4, $params_seCount4);
      $result_seCount4 = sqlsrv_fetch_array($query_seCount4, SQLSRV_FETCH_ASSOC);
      $count4 = $result_seCount4['COUNT_HOLIDAY4'];
    }else {
      // code...
    }
  }else {
    $counts = 0;
  }
  $counts = $count0+$count1+$count2+$count3+$count4;
  $holidayprice = ($counts*1000);



//ซ้าย ขวา body , , HEADER,ล่าง
$mpdf = new mPDF('', 'Letter', '', '', 2, 18, '', 5, '', 15);
$style = '
<style>
	body{
		font-family: "angsana";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';
$table_header21 = '<br>';
$table_header2 = '<table width="100%" >
    <tbody>
        <tr>
        	<td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
            <td colspan="7" style="font-size:24px" ><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO., LTD.)<b></td>
       </tr>
       <tr>
        	<td colspan="7" style="font-size:20px">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160</td>
       </tr>
        <tr>
        	<td colspan="7" style="font-size:20px">โทรศัพท์: 038-452824-5 โทรสาร : 038-210396</td>
       </tr>
        <tr>
        <td colspan="7" style="font-size:20px;">เลขประจำตัวผู้เสียภาษี 0105544064899</td>
       </tr>

       <tr>
        	<td colspan="8" style="text-align:center;font-size:24px"><b>ใบวางบิล</b></td>
       </tr>

    </tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;font-size:22px">
    <tbody>
        <tr style="border:1px solid #000;">
       	  <td style="border-right:1px solid #000;padding:4px;width:70%">ลูกค้า : รหัส ต-004
								<br>บริษัท โตโยต้า ออโต้ เวิคส จำกัด
								<br>สำนักงานใหญ่ ที่อยู่ 187 หมู่ 9 ถนนทางรถไฟเก่า ต.เทพารักษ์
								<br>อ.เมืองสมุทรปราการ จ.สมุทรปราการ 10270
								<br>โทร. 02-705-7300
		  </td>
            <td style="border-right:1px solid #000;padding:4px;width:30%">วันที่  ' . $result_seBillinginvoice['DUEDATE'] . '</td>
       </tr>

    </tbody>
</table>';

$table_begin2 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead2 = '<thead>

        <tr style="border:1px solid #000;padding:4px;font-size:20px">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%;font-size:20px"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%;font-size:20px"><b>เลขที่ใบแจ้งหนี้</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%;font-size:20px"><b>วันที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%;font-size:20px"><b>วันครบกำหนด</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%;font-size:20px"><b>จำนวนเงิน</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:20%;font-size:20px"><b>ยอดชำระแล้ว</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:15%;font-size:20px"><b>ยอดเงินคงค้าง</b></td>
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
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px"height="300px" valign="top">' . $i1 . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px" valign="top">' . $result_seBillinginvoice2['INVOICECODE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px" valign="top">' . $result_seBillinginvoice2['BILLINGDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px" valign="top">' . $result_seBillinginvoice2['PAYMENTDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px" valign="top">' . number_format($result_sumprice['SUMACTUALPRICE']+$holidayprice, 2) . '</td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px" valign="top"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px" valign="top">' . number_format($result_sumprice['SUMACTUALPRICE']+$holidayprice, 2) . '</td>
      </tr>
';

    $i1++;
    // $sumtotal = $sumtotal + $result_seBilling1['SUMTOTAL'];
}


$tfoot2 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td colspan="5" bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:22px">' . convert(($result_sumprice['SUMACTUALPRICE']+$holidayprice)) . '</td>
            <td style="border-right:1px solid #000;padding:4px;font-size:22px">รวมเงินทั้งสิ้น</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px">' . number_format(($result_sumprice['SUMACTUALPRICE']+$holidayprice), 2) . '</td>
      </tr>

       <tr style="">
        <td colspan="5" rowspan="2" style="border-right:1px solid #000;padding:4px;"></td>
        <td style="border-right:1px solid #000;padding:4px;font-size:22px">ภาษีหัก ณ ที่จ่าย 1 %</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px">' . number_format((($result_sumprice['SUMACTUALPRICE']+$holidayprice) * 1) / 100, 2) . '</td>

      </tr>
       <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;font-size:22px">ยอดต้องชำระ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:22px">' . number_format(($result_sumprice['SUMACTUALPRICE']+$holidayprice) - ((($result_sumprice['SUMACTUALPRICE']+$holidayprice) * 1) / 100), 2) . '</td>
      </tr>
    </tfoot>';

$table_end2 = '</table>';

$table_footer2 = '<br />
<br />
<br />

<table width="100%" style="border-collapse: collapse;margin-top:8px;font-size:22px">
<tfoot>
<tbody>
<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:3px;text-align:center;width:35%"><br /><br /><br />วันนัดชำระเงิน / Payment Date<br />____/____/____</td>
        <td style="border-right:1px solid #000;padding:3px;text-align:center;width:30%"><br /><br />...................................................<br />ผู้รับวางบิล / Received By<br />____/____/____</td>
        <td style="border-right:1px solid #000;padding:3px;text-align:center;width:35%"><br /><br />...................................................<br />ผู้วางบิล / Delivery By<br />____/____/____</td>
    </tr>
    </tbody>

    </tfoot>
</table>';


//////////////////////////////////////ใบแจ้งหนี้/ใบเสร็จรับเงิน//////////////////////////////////////////////////////////
$table_header31 = '<br>';
$table_header1 = '<table width="100%" >
    <tbody>
        <tr>
        	<td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
            <td colspan="7" style="font-size:24px"><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO., LTD.)</td>
       </tr>
       <tr>
        	<td colspan="7" style="font-size:20px">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160</td>
       </tr>
        <tr>
        	<td colspan="7" style="font-size:20px">โทรศัพท์: 038-452824-5 โทรสาร : 038-210396</td>
       </tr>
        <tr>
        	<td colspan="7" style="font-size:20px">เลขประจำตัวผู้เสียภาษี 0105544064899</td>
       </tr>

       <tr>
        	<td colspan="8" style="text-align:center;font-size:24px"><b>ใบแจ้งหนี้/ใบเสร็จรับเงิน</b></td>
       </tr>

    </tbody>
</table>
<table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;font-size:22px">
<tbody>
    <tr style="border:1px solid #000;" >
     <td style="border-right:1px solid #000;padding:4px;width:70%" rowspan="4">ลูกค้า : รหัส ต-004
            <br>บริษัท โตโยต้า ออโต้ เวิคส จำกัด
            <br>สำนักงานใหญ่ ที่อยู่ 187 หมู่ 9 ถนนทางรถไฟเก่า ต.เทพารักษ์
            <br>อ.เมืองสมุทรปราการ จ.สมุทรปราการ 10270
            <br>โทร. 02-705-7300
            <br>เลขประจำตัวผู้เสียภาษี 0115531001656
      </td>
        <td style="border-right:1px solid #000;padding:4px;width:30%">เลขที่ : ' . $result_seBillinginvoice['INVOICECODE'] . '
        <br>วันที่ : ' . $result_seBillinginvoice['BILLINGDATE'] . '
        <br>เครดิต : 30 วัน
        <br>วันที่ครบกำหนด : ' . $result_seBillinginvoice['PAYMENTDATE'] . '
        </td>

   </tr>
</tbody>
</table>';

$table_begin1 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;font-size:20px">';
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
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" height="200px" valign="top">' . $i2 . '</td>
        <td style="border-right:1px solid #000;padding:4px;"  valign="top">ค่าขนส่งสินค้าตามเอกสารแนบ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;" valign="top">' . number_format($result_sumprice['SUMACTUALPRICE']+$holidayprice, 2) . '</td>
      </tr>
';

    $i2++;
    // $sumtotal = $sumtotal + $result_seBillinginvoice1['SUMTOTAL'];
}

$tfoot1 = '</tbody>
    <tfoot>
    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center">รวมเงิน</td>
            <td bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;">' . convert($result_sumprice['SUMACTUALPRICE']+$holidayprice) . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($result_sumprice['SUMACTUALPRICE']+$holidayprice, 2) . '</td>
      </tr>

    </tfoot>';

$table_end1 = '</table>';

$table_footer1 = '
<table width="100%" style="border-collapse: collapse;margin-top:8px;font-size:20px">
<tbody>
<tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:30%">ได้รับบริการตามรายการเรียบร้อยแล้ว<br><br><br><br><br><br><br>ผู้รับบริการ..........................................<br>ลงวันที่................/................/.............</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;width:35%">การชำระเงิน<input type="checkbox" size="5" /> เงินสด&nbsp;<input type="checkbox" size="5" checked="checked"/> โอนเงิน<br><input type="checkbox"  size="5"/> เช็คธนาคาร.............................................<br>เลขที่....................วันที่........../........../..........<br>จำนวนเงิน...................................................<br><br><br><br>ผู้รับเงิน.................................................<br>ลงวันที่................/................./.................</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width:35%">ในนาม บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด<br><br><br><br><br><br>.....................................................................<br>ลงวันที่............./............/.............<br>ผู้มีอำนาจลงนาม / Authorized Signature</td>
    </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>';
$table_remark1 = '<br /><table width="100%" style="font-size:18px" >
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
       </tr><br><br>
       <tr>
            <td colspan="2">FM-ADM-10/01 แก้ไขครั้งที่ : 01 มีผลบังคับใช้ : 01-09-60</td>
       </tr>
    </tbody>
</table>
';


/////////////////////////////////////////ใบแจ้งหนี้ทางด่วน///////////////////////////////////////////////////////

// $table_header3 = '<table width="100%" >
// <tbody>
//     <tr>
//       <td colspan="1" rowspan="4" style="text-align:center"><img src="../images/logonew.png"></td>
//         <td colspan="7" style="font-size:15px"><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด (RUAMKIT RUNGRUENG SERVICES CO.,LTD.)</td>
//    </tr>
//    <tr>
//       <td colspan="7">สำนักงานสาขาที่ 2 เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง  จังหวัดชลบุรี 20160</td>
//    </tr>
//     <tr>
//       <td colspan="7">โทรศัพท์: 038-452824-5 โทรสาร : 038-210396</td>
//    </tr>
//     <tr>
//       <td colspan="7">เลขประจำตัวผู้เสียภาษี 0105544064899</td>
//    </tr>
//    <tr>
//       <td colspan="8" style="text-align:center;">&nbsp;</td>
//    </tr>
//    <tr>
//       <td colspan="8" style="text-align:center;font-size:16px"><b>ใบแจ้งหนี้/ใบเสร็จรับเงิน</b></td>
//    </tr>
//    <tr>
//       <td colspan="8" style="text-align:center;">&nbsp;</td>
//    </tr>
// </tbody>
// </table>
// <table id="bg-table" width="100%"  style="border-collapse: collapse;margin-top:8px;">
// <tbody>
// <tr style="border:1px solid #000;" >
//  <td style="border-right:1px solid #000;padding:4px;width:70%" rowspan="4">ลูกค้า : รหัส ต-004
//         <br><br>บริษัท โตโยต้า ออโต้ เวิคส จำกัด
//         <br><br>สำนักงานใหญ่ ที่อยู่ 187 หมู่ 9 ถนนทางรถไฟเก่า ต.เทพารักษ์
//         <br><br>อ.เมืองสมุทรปราการ จ.สมุทรปราการ 10270
//         <br><br>โทร. 02-705-7300
//         <br><br>เลขประจำตัวผู้เสียภาษี 0115531001656
//   </td>
//     <td style="border-right:1px solid #000;padding:4px;width:30%">เลขที่ : ' . $result_seBillinginvoice['INVOICECODE'] . '
//     <br><br>วันที่ : ' . $result_seBillinginvoice['BILLINGDATE'] . '
//     <br><br>เครดิต : 30 วัน
//     <br><br>วันที่ครบกำหนด : ' . $result_seBillinginvoice['PAYMENTDATE'] . '
//     </td>
//
// </tr>
// </tbody>
// </table>';
//
// $table_begin3 = '<table width="100%" style="border-collapse: collapse;margin-top:8px;">';
// $thead3 = '<thead>
//
//         <tr style="border:1px solid #000;padding:4px;">
//         <td style="border-right:1px solid #000;padding:4px;text-align:center;width:10%"><b>ลำดับ</b></td>
//         <td style="border-right:1px solid #000;padding:4px;text-align:center;width:60%"><b>รายการ</b></td>
//         <td style="border-right:1px solid #000;padding:4px;text-align:center;width:30%"><b>จำนวนเงิน(บาท)</b></td>
//       </tr>
//   </thead><tbody>';
// $i2 = 1;
// $sql_seBillinginvoice3 = "{call megLogbillinginvoice_v2(?,?,?)}";
// $params_seBillinginvoice3 = array(
//     array('select_logbillinginvoice', SQLSRV_PARAM_IN),
//     array($condBillinginvoice1, SQLSRV_PARAM_IN),
//     array($condBillinginvoice2, SQLSRV_PARAM_IN)
// );
// $query_seBillinginvoice3 = sqlsrv_query($conn, $sql_seBillinginvoice3, $params_seBillinginvoice3);
// while ($result_seBillinginvoice3 = sqlsrv_fetch_array($query_seBillinginvoice3, SQLSRV_FETCH_ASSOC)) {
//     $tbody3 .= '<tr style="border:1px solid #000;" >
//         <td style="border-right:1px solid #000;padding:4px;text-align:center;" height="210px" valign="top">' . $i2 . '</td>
//         <td style="border-right:1px solid #000;padding:4px;"  valign="top">' . $data45 . '' . $data55 . '' . $data65 . '' . $data65return . '' . $data75 . '' . $data195 . '</td>
//         <td style="border-right:1px solid #000;padding:4px;text-align:right;" valign="top">' . $price45. '' . $price55. '' . $price65. '' . $price65return. '' . $price75. '' . $price195. '</td>
//       </tr>
// ';
//
//     $i2++;
//     $sumtotal = $sumtotal + $result_seBillinginvoice3['SUMTOTAL'];
// }
//
// $tfoot3 = '</tbody>
//     <tfoot>
//     <tr style="border:1px solid #000;">
//         <td style="border-right:1px solid #000;padding:4px;text-align:center">รวมเงิน</td>
//             <td bgcolor="#CCCCCC" style="border-right:1px solid #000;padding:4px;">' . convert($cntallprice) . '</td>
//         <td style="border-right:1px solid #000;padding:4px;text-align:right;">' . number_format($cntallprice,2) . '</td>
//       </tr>
//
//     </tfoot>';
//
// $table_end3 = '</table>';
//
// $table_footer3 = '<br />
// <table width="100%" style="border-collapse: collapse;margin-top:8px;">
// <tbody>
// <tr style="border:1px solid #000;">
//         <td style="border-right:1px solid #000;padding:4px;text-align:left;width:30%">ได้รับบริการตามรายการเรียบร้อยแล้ว<br><br><br><br><br><br><br><br><br><br><br><br>ผู้รับบริการ..........................................<br><br>ลงวันที่................/................/.............</td>
//         <td style="border-right:1px solid #000;padding:4px;text-align:left;width:35%">การชำระเงิน<br><br><input type="checkbox" size="5" /> เงินสด&emsp;<input type="checkbox" size="5" checked="checked"/> โอนเงิน<br><br><input type="checkbox"  size="5" /> เช็คธนาคาร.............................................<br><br>เลขที่....................วันที่........../........../..........<br><br>จำนวนเงิน...................................................<br><br><br><br>ผู้รับเงิน.................................................<br><br>ลงวันที่................/................./.................</td>
//         <td style="border-right:1px solid #000;padding:4px;text-align:left;width:35%">ในนาม บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด<br><br><br><br><br><br><br><br><br><br>.....................................................................<br><br>ลงวันที่............./............/.............<br><br>ผู้มีอำนาจลงนาม / Authorized Signature</td>
//     </tr>
//     </tbody>
//     <tfoot>
//     </tfoot>
// </table>';
// $table_remark3 = '<br /><table width="100%" >
//     <tbody>
//         <tr>
//         	<td style="width:10%"><b><u>หมายเหตุ</u> :</b></td>
//             <td style="width:90%">1.ค่าขนส่งภาษีหัก ณ ที่จ่าย 1 %</td>
//        </tr>
//        <tr>
//         	<td style="width:10%"></td>
//             <td style="width:90%">2.ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์ เมื่อมีลายเซ็นผู้รับเงิน และได้รับเงินตามเช็ค หรือ เงินโอนเข้าบัญชีเรียบร้อยแล้ว</td>
//        </tr>
//        <tr>
//         	<td style="width:10%"></td>
//             <td style="width:90%">3.ผู้รับบริการชำระเกินกำหนดที่ระบุไว้ในใบแจ้งหนี้ ผู้รับบริการยินยอมชำระค่าปรับร้อยละ 15 ต่อปี ของจำนวนเงินที่ค้างชำระ</td>
//        </tr><br><br><br><br>
//        <tr>
//             <td colspan="2">FM-ADM-10/01 แก้ไขครั้งที่ : 01 มีผลบังคับใช้ : 01-09-60</td>
//        </tr>
//     </tbody>
// </table>
// ';



$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_header21);
$mpdf->WriteHTML($table_header2);
$mpdf->WriteHTML($table_begin2);
$mpdf->WriteHTML($thead2);
$mpdf->WriteHTML($tbody2);
$mpdf->WriteHTML($tfoot2);
$mpdf->WriteHTML($table_end2);
$mpdf->WriteHTML($table_footer2);
$mpdf->AddPage();
$mpdf->WriteHTML($table_header31);
$mpdf->WriteHTML($table_header1);
$mpdf->WriteHTML($table_begin1);
$mpdf->WriteHTML($thead1);
$mpdf->WriteHTML($tbody1);
$mpdf->WriteHTML($tfoot1);
$mpdf->WriteHTML($table_end1);
$mpdf->WriteHTML($table_footer1);
$mpdf->WriteHTML($table_remark1);
// $mpdf->AddPage();
// $mpdf->WriteHTML($table_header3);
// $mpdf->WriteHTML($table_begin3);
// $mpdf->WriteHTML($thead3);
// $mpdf->WriteHTML($tbody3);
// $mpdf->WriteHTML($tfoot3);
// $mpdf->WriteHTML($table_end3);
// $mpdf->WriteHTML($table_footer3);
// $mpdf->WriteHTML($table_remark3);

$mpdf->Output();



sqlsrv_close($conn);
?>
