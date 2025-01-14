<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['invoicecode'] == "" || $_GET['invoicecode'] == "") {
    $strExcelFileName = "RKLTTAST_OTHER(TRIP)_Billing.xls";
} else {
    $strExcelFileName = "RKLTTAST_OTHER(TRIP)_Billing" . $_GET['invoicecode'] . ".xls";
}

header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

// if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
//     $date_now = "";
// } else {
//     $date_now = $_GET['datestart'] . ' ถึง ' . $_GET['dateend'];
// }

// $sql_getDate = "{call megStopwork_v2(?)}";
// $params_getDate = array(
//     array('select_getdate', SQLSRV_PARAM_IN)
// );
// $query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
// $result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);


$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,BILLING,INVOICECODE 
FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '" . $_GET['invoicecode'] . "'";
$query_seInvoicecode  = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <br><br>


        <!-- //////////////////////////////////////Header Charge 10 ////////////////////////////// -->
        <table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="11" style="text-align:center;font-size:28px"><b>ใบส่งสินค้า(ใหม่)</b></td>
    </thead>
    <tbody>
        <tr>
            <td colspan="11" style="font-size:22px">บริษัท ร่วมกิจรุ่งเรือง (1993) จำกัด (RUAMKIT RUNGRUENG (1993) CO., LTD.)</td>
       </tr>
       <tr>
            <td colspan="11" style="font-size:22px">สำนักงานใหญ่ เลขที่ 51 หมู่ 4 ตำบลบ้านเก่า อำเภอพานทอง จังหวัดชลบุรี 20160  โทรศัพท์ : 038-452824-5 โทรสาร : 038-210396</td>
       </tr>
       <tr>
            <td colspan="11" style="font-size:22px">เลขประจำตัวผู้เสียภาษี  0105536076131</td>
       </tr>


       <tr>
            <td colspan="11">&nbsp;</td>
       </tr>


       <tr>
            <td colspan="7" style="font-size:22px">บริษัท ทีที ออโตโมทีฟ สตีล (ไทยแลนด์) จำกัด </td>
            <td colspan="4" style="text-align:right;font-size:22px">เลขที่ <?= $result_seInvoicecode['INVOICECODE'] ?></td>
       </tr>
       <tr>
            <td colspan="7" style="font-size:22px">สำนักงานใหญ่ นิคมอุตสาหกรรมเกตเวย์ซิตี้ เลขที่ 256 หมู่ที่ 7 ต.หัวสำโรง อ.แปลงยาว จ.ฉะเชิงเทรา 24190</td>
            <td colspan="4" style="text-align:right;font-size:22px">วันที่ <?= $result_seInvoicecode['PAYMENTDATE'] ?></td>
       </tr>

       <tr>
            <td colspan="7" style="font-size:22px">เลขประจำตัวผู้เสียภาษี  0105548107746</td>
            <td colspan="4" style="text-align:right;">&nbsp;</td>
       </tr>
    </tbody>
</table>

<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:20px;margin-top:8px;">
<thead>

        <tr style="border:1px solid #000;padding:4px;">

        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:20px"><b>ลำดับที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:20px"><b>วันที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:20px"><b>หมายเลข DO</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:20px"><b>ทะเบียนรถ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:20px"><b>พนักงาน</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:20px"><b>จาก</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:20px"><b>ถึง</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:20px"><b>พื้นที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:20px"><b>QT.</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:20px"><b>ราคา</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:20px"><b>จำนวนเงิน(บาท)</b></td>
      </tr>
    </thead><tbody>

<?php
  $i = 1;
  // $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
  // $params_seBilling = array(
  //     array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
  //     array($condBilling1, SQLSRV_PARAM_IN),
  //     array($condBilling2, SQLSRV_PARAM_IN)
  // );
  $sql_seBilling = "SELECT ROW_NUMBER() OVER (PARTITION BY a.JOBEND,b.VEHICLETRANSPORTPLANID ORDER BY a.JOBEND,b.VEHICLETRANSPORTPLANID,a.DOCUMENTCODE ASC) AS 'ROWNUM',
    ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY a.JOBEND,b.VEHICLETRANSPORTPLANID ASC) AS 'RUNNUMBER',
    b.VEHICLETRANSPORTPLANID AS 'PLANID',
    CONVERT(VARCHAR(10), b.DATEWORKING, 103)  AS 'DATEWORK_103',a.DOCUMENTCODE AS 'DOCUMENTCODE',b.THAINAME AS 'THAINAME',b.EMPLOYEENAME1 AS 'EMPLOYEENAME1',
    b.JOBSTART AS 'JOBSTART',b.JOBEND AS 'JOBEND',c.PRICE AS 'PRICE'

    FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
    INNER JOIN  [dbo].[VEHICLETRANSPORTPLAN]  b ON b.VEHICLETRANSPORTPLANID  = a.VEHICLETRANSPORTPLANID
    INNER JOIN  [dbo].[VEHICLETRANSPORTPRICE] c ON b.VEHICLETRANSPORTPRICEID = c.VEHICLETRANSPORTPRICEID
    WHERE 1 = 1 
    AND a.COMPANYCODE ='RKl' 
    AND c.CARRYTYPE = 'trip'
    AND c.WORKTYPE = 'other'
    AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'".$result_seInvoicecode['BILLINGDATE']."',103) AND CONVERT(DATE,'".$result_seInvoicecode['PAYMENTDATE']."',103)
    AND b.EMPLOYEECODE1 IN ('100007','100009')
    ORDER BY a.JOBEND,b.VEHICLETRANSPORTPLANID,a.DOCUMENTCODE ASC";
  $params_seBilling = array();
  $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
  while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

    //เช็ค MAX ROWNUM ของ PLANID ที่มากที่สุด
    $sql_RowNumChk = "SELECT  TOP 1 ROW_NUMBER() OVER (PARTITION BY a.VEHICLETRANSPORTPLANID ORDER BY  a.JOBEND,a.VEHICLETRANSPORTPLANID,a.DOCUMENTCODE  ASC) AS 'ROWNUM_CHK'
      FROM VEHICLETRANSPORTDOCUMENTDIRVER a 
      WHERE a.VEHICLETRANSPORTPLANID ='655961'
      ORDER BY ROW_NUMBER() OVER (PARTITION BY a.VEHICLETRANSPORTPLANID ORDER BY a.JOBEND,a.VEHICLETRANSPORTPLANID,a.DOCUMENTCODE ASC) DESC";
    $query_RowNumChk = sqlsrv_query($conn, $sql_RowNumChk, $params_RowNumChk);
    $result_RowNumChk = sqlsrv_fetch_array($query_RowNumChk, SQLSRV_FETCH_ASSOC);

      if ($result_seBilling['ROWNUM'] == $result_RowNumChk['ROWNUM_CHK']) {
        $PRICE  = $result_seBilling['PRICE'];
        $QT = '1';
      }else {
        $PRICE = '';
        $QT = '';
      }

      if($result_seBilling['ROWNUM'] > 1 )
      {
        $i--;
        $NO = '';
        
      }else {
        $NO = $i;
      }


      if ($result_seBilling['JOBSTART'] == 'CH.R') {
        $jobstart = 'CH.R';
      }else if ($result_seBilling['JOBSTART'] == 'CS (Wellgrow)') {
        $jobstart = 'CS';
      }else if ($result_seBilling['JOBSTART'] == 'DMK  (Samrong)') {
        $jobstart = 'DMK';
      }else if ($result_seBilling['JOBSTART'] == 'HANWA (Amata city chonburi)') {
        $jobstart = 'HANWA';
      }else if ($result_seBilling['JOBSTART'] == 'Sakolchai (Pinthong2)') {
        $jobstart = 'Sakolchai';
      }else if ($result_seBilling['JOBSTART'] == 'SMTC (Pintong 2)') {
        $jobstart = 'SMTC';
      }else if ($result_seBilling['JOBSTART'] == 'SSSC3 (Rayong)') {
        $jobstart = 'SSSC3';
      }else if ($result_seBilling['JOBSTART'] == 'STC (Amata city chonburi)') {
        $jobstart = 'STC';
      }else if ($result_seBilling['JOBSTART'] == 'TKT (Amatanakorn)') {
        $jobstart = 'TKT';
      }else if ($result_seBilling['JOBSTART'] == 'TMT  (Samrong)') {
        $jobstart = 'TMT';
      }else if ($result_seBilling['JOBSTART'] == 'TTAST (G/W)') {
        $jobstart = 'TTAST';
      }else {
        $jobstart = $result_seBilling['JOBSTART'];
      }
    ////////////////////JOBEND//////////////////////////////////////////
      if ($result_seBilling['JOBEND'] == 'BKHT (Rayang)') {
        $jobend = 'BKHT';
        $location = 'Rayong';
      }else if ($result_seBilling['JOBEND'] == 'BP Engineering') {
        $jobend = 'BP Engineering';
        $location = 'Banpho';
      }else if ($result_seBilling['JOBEND'] == 'CS METAL (Wellgrow)') {
        $jobend = 'CS METAL';
        $location = 'Wellgrow';
      }else if ($result_seBilling['JOBEND'] == 'DMK  (Samrong)') {
        $jobend = 'DMK';
        $location = 'Samrong';
      }else if ($result_seBilling['JOBEND'] == 'Hino  (Bangplee)') {
        $jobend = 'Hino';
        $location = 'Bangplee';
      }else if ($result_seBilling['JOBEND'] == 'KIT') {
        $jobend = 'KIT';
        $location = 'Amata City Chonburi';
      }else if ($result_seBilling['JOBEND'] == 'MAC GRAPHIC (Bangplee)') {
        $jobend = 'MAC GRAPHIC';
        $location = 'Bangplee';
      }else if ($result_seBilling['JOBEND'] == 'OTC  (Ladkrabang)') {
        $jobend = 'OTC';
        $location = 'Ladkrabang';
      }else if ($result_seBilling['JOBEND'] == 'R&N (Samrong)') {
        $jobend = 'R&N ';
        $location = 'Samrong';
      }else if ($result_seBilling['JOBEND'] == 'Sakolchai (Pinthong)') {
        $jobend = 'Sakolchai';
        $location = 'Pinthong';
      }else if ($result_seBilling['JOBEND'] == 'Sarathon (Samutsakhon)') {
        $jobend = 'Sarathon';
        $location = 'Samutsakhon';
      }else if ($result_seBilling['JOBEND'] == 'SASC (Hemaraj Eastern Seaboard Rayong)') {
        $jobend = 'SASC';
        $location = 'Eastern Seaboard';
      }else if ($result_seBilling['JOBEND'] == 'SMM (Omnoi  Samutsakhon)') {
        $jobend = 'SMM';
        $location = 'Samutsakhon';
      }else if ($result_seBilling['JOBEND'] == 'STC (Amata city chonburi)') {
        $jobend = 'STC';
        $location = 'Amata City Chonburi';
      }else if ($result_seBilling['JOBEND'] == 'Sun Steel (Samutsakhon)') {
        $jobend = 'Sun Steel';
        $location = 'Samutsakhon';
      }else if ($result_seBilling['JOBEND'] == 'TAKEBE (Amata city chonburi)') {
        $jobend = 'TKB';
        $location = 'Amata City Chonburi';
      }else if ($result_seBilling['JOBEND'] == 'THAPT (Wellgrow)') {
        $jobend = 'THAPT';
        $location = 'Wellgrow';
      }else if ($result_seBilling['JOBEND'] == 'TMT  (B/P)') {
        $jobend = 'TMB';
        $location = 'Banpho';
      }else if ($result_seBilling['JOBEND'] == 'TMT  (Samrong)') {
        $jobend = 'TMS';
        $location = 'Samrong';
      }else if ($result_seBilling['JOBEND'] == 'TMT (Gateway)') {
        $jobend = 'TMG';
        $location = 'Gateway';
      }else if ($result_seBilling['JOBEND'] == 'TTAST  Plant2  (Pinthong)') {
        $jobend = 'TTAST';
        $location = 'Pinthong';
      }else if ($result_seBilling['JOBEND'] == 'TTAST2 (Pinthong2)') {
        $jobend = 'TTAST2';
        $location = 'Pinthong2';
      }else if ($result_seBilling['JOBEND'] == 'WMF(King Kaew)') {
        $jobend = 'WMF';
        $location = 'Kingkaew';
      }else if ($result_seBilling['JOBEND'] == 'YNP2') {
        $jobend = 'YNP2';
        $location = 'Bangplee';
      }else {
        $jobend = $result_seBilling['JOBEND'];
        $location = '';
      }

      // $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "' ";
      // $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
      // $params_seEmployeeehr = array(
      //     array('select_employeeEHR2', SQLSRV_PARAM_IN),
      //     array($condEmployeeehr1, SQLSRV_PARAM_IN)
      // );
      // $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
      // $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);


?>

      <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:20px"><?= $NO ?></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:20px"><?= $result_seBilling['DATEWORK_103'] ?></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:20px"><?= $result_seBilling['DOCUMENTCODE'] ?></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:20px"><?= $result_seBilling['THAINAME'] ?></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:20px"><?= $result_seBilling['EMPLOYEENAME1'] ?></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:20px"><?= $result_seBilling['JOBSTART'] ?></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:20px"><?= $result_seBilling['JOBEND'] ?></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;font-size:20px"><?= $location ?></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:20px"><?= $QT ?></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:20px"><?= ($PRICE  == '' ? '' : number_format($PRICE, 2)) ?></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:20px"><?= ($PRICE  == '' ? '' : number_format($PRICE, 2)) ?></td>
      </tr>
<?php
    $i++;
    $sumtotal = $sumtotal + $PRICE;
}
?>

</tbody><tfoot>
     <tr style="border:1px solid #000;">
        <td colspan="9" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px"><?= convert($sumtotal) ?></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;font-size:18px">รวมสุทธิ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;font-size:18px"><?= number_format($sumtotal, 2) ?></td>

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

    </body>
    </html>
