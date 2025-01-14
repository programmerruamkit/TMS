<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$strExcelFileName = "" . $_GET['companycode'] . "_" . $_GET['customercode'] . "(".$_GET['startdate']." To ".$_GET['enddate'].")_Billing". ".xls";



header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");


// $sumgmtweight = "";
// $sumcusweight = "";
// $sumamounttrip = "";
// $sumtotal = "";

// $sql_getDate = "{call megStopwork_v2(?)}";
// $params_getDate = array(
//   array('select_getdate', SQLSRV_PARAM_IN)
// );
// $query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
// $result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);


//
// $condBilling1 = " AND a.INVOICECODE = '" . $_GET['invoicecode'] . "' ";
// $condBilling2 = "";
//
// $sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
// $params_seBillings = array(
//     array('select_pdfvehicletransportdocumentdriver', SQLSRV_PARAM_IN),
//     array($condBilling1, SQLSRV_PARAM_IN),
//     array($condBilling2, SQLSRV_PARAM_IN)
// );
// $query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
// $result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);
//
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


// $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "' ";
// $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
// $params_seEmployeeehr = array(
//     array('select_employee', SQLSRV_PARAM_IN),
//     array($condEmployeeehr1, SQLSRV_PARAM_IN)
// );
// $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
// $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);

$sql_seInvoicecode = "SELECT TOP 1 BILLINGDATE,PAYMENTDATE,BILLING FROM [dbo].[LOGINVOICE] WHERE INVOICECODE = '".$_GET['invoicecode']."'";
$query_seInvoicecode = sqlsrv_query($conn, $sql_seInvoicecode, $params_seInvoicecode);
$result_seInvoicecode = sqlsrv_fetch_array($query_seInvoicecode, SQLSRV_FETCH_ASSOC);


?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
 <br><br>
<!-- ////////////////////////////////////////////////Charge 10///////////////////////////////////////////////// -->
<?php

// $sql_seBilling10s = "SELECT  c.JOBNO,b.JOBSTART,b.JOBEND,b.REMARK,c.BILLING,a.BILLINGDATE
// FROM [dbo].[LOGINVOICE] a
// INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.DOCUMENTCODE = b.DOCUMENTCODE
// INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON b.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
// INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] d ON c.[VEHICLETRANSPORTPRICEID] = d.[VEHICLETRANSPORTPRICEID]
// WHERE b.COMPANYCODE='".$_GET['companycode']."' AND b.CUSTOMERCODE='".$_GET['customercode']."' AND b.REMARK = 'Charge 10' ";
//
// $query_seBilling10s = sqlsrv_query($conn, $sql_seBilling10s, $params_seBilling10s);
// $result_seBillings = sqlsrv_fetch_array($query_seBilling10s, SQLSRV_FETCH_ASSOC);

 ?>

 <!-- //////////////////////////////////////Header Charge 10 ////////////////////////////// -->
  <table style="width: 100%;">
      <thead>
          <tr>

              <td colspan="25" style="text-align:center;font-size:18px;"><b>รายงานสรุปรายการวางบิล</b></td>

      </thead>
      <tbody>
          <tr>
              <td colspan="25" style="text-align:center;font-size:14px;"><b> <?= $_GET['startdate']?> - <?= $_GET['enddate']?></b></td>
        </tr>

        <tr>
              <td colspan="25">&nbsp;</td>
        </tr>

      </tbody>
  </table>

  <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">
      <thead>
           <tr>
               <!-- <td colspan="6" style="text-align:left;font-size:16px;"><b>หมายเลขบัญชี : <?=$result_seInvoicecode['BILLING']?>  Charge 10</b></td>
               <td colspan="7" style="text-align:right;font-size:16px;"><b>ใบแจ้งหนี้: <?= $_GET['invoicecode']?></b></td> -->
           </tr>
           <tr style="border:1px solid #000;padding:4px;">
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>NO</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>DATE</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>INVOICEDATE</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>INVOICENO</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>TRUCKNO</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>TYPE</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>DRIVER</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>FROM</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>TO</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>ZONE</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>DOCUMENTCODE</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>SECTION</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>PRICE</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>WEIGHT(TON)</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>WEIGHT(TRIP)</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>QUANTITY</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>DESTINATION</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>CHARGE</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>DIFF(TON)</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>THB</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>DROP</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>TOTAL THB(CHARGE)</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>TOTAL THB(ACTUAL)</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>DIFF(THB)</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>REMARK</b></td>
         </tr>
      </thead>
    <tbody>


      <?php
      $i = 1;
      // $sql_execTemp_billing10 = "{call megTempbilling(?,?,?,?,?,?,?)}";
      // $params_execTemp_billing10 = array(
      //     array('select_tempbillingexcel10', SQLSRV_PARAM_IN),
      //     array($_GET['companycode'], SQLSRV_PARAM_IN),
      //     array($_GET['customercode'], SQLSRV_PARAM_IN),
      //     array($result_seInvoicecode['BILLINGDATE'], SQLSRV_PARAM_IN),
      //     array($result_seInvoicecode['PAYMENTDATE'], SQLSRV_PARAM_IN),
      //     array($result_seInvoicecode['BILLING'], SQLSRV_PARAM_IN),
      //     array($_GET['invoicecode'], SQLSRV_PARAM_IN)
      // );
      // $query_execTemp_billing10 = sqlsrv_query($conn, $sql_execTemp_billing10, $params_execTemp_billing10);
      // $result_execTemp_billing10 = sqlsrv_fetch_array($query_execTemp_billing10, SQLSRV_FETCH_ASSOC);

          $sql_seBilling = "SELECT  ROW_NUMBER() OVER (PARTITION BY a.JOBEND,b.VEHICLETRANSPORTPLANID ORDER BY a.JOBEND,b.VEHICLETRANSPORTPLANID,a.DOCUMENTCODE ASC) AS 'ROWNUM',
              ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY a.JOBEND,b.VEHICLETRANSPORTPLANID ASC) AS 'RUNNUMBER',
              ROW_NUMBER() OVER (PARTITION BY CONVERT(VARCHAR,b.DATEWORKING,5) ORDER BY b.DATEWORKING,b.VEHICLETRANSPORTPLANID ASC) AS 'RUNNUMBER_WITHDATE',
              a.VEHICLETRANSPORTPLANID AS 'PLANID',CONVERT(VARCHAR,b.DATEWORKING,5) AS 'DATE',b.THAINAME AS 'TRUCKNO',
              b.VEHICLETYPE AS 'TYPE',b.EMPLOYEENAME1 AS 'DRIVER',a.JOBSTART AS 'FROM',a.JOBEND AS 'JOBEND',c.[LOCATION] AS 'LOCATION',
              a.DOCUMENTCODE AS 'DOCUMENTCODE',c.PRICE AS 'PRICE',
              CONVERT(NVARCHAR,CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(INT,a.WEIGHTIN)) / 1000)) AS 'WEIGHT_TON',
              c.WORKTYPE AS 'WORKTYPE',c.CARRYTYPE AS 'CARRYTYPE',c.BILLING2 AS 'SECTION'
              
              FROM VEHICLETRANSPORTDOCUMENTDIRVER a 
              INNER JOIN VEHICLETRANSPORTPLAN b  ON  a.VEHICLETRANSPORTPLANID  = b.VEHICLETRANSPORTPLANID
              INNER JOIN VEHICLETRANSPORTPRICE c ON  a.VEHICLETRANSPORTPRICEID = c.VEHICLETRANSPORTPRICEID
              WHERE a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
              AND c.WORKTYPE='other' AND c.CARRYTYPE ='trip'
              AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['startdate']."',103) AND CONVERT(DATE,'".$_GET['enddate']."',103)
              AND (a.DOCUMENTCODE !=''  OR a.DOCUMENTCODE IS NOT NULL)
              ORDER BY b.DATEWORKING,b.JOBNO,a.JOBEND ASC";
          $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
          while($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)){


          $sql_seSumWeighTrip = "SELECT SUM(CONVERT(INT,WEIGHTIN)) AS 'WEIGHTIN_TRIP'
                                FROM VEHICLETRANSPORTDOCUMENTDIRVER
                                WHERE [VEHICLETRANSPORTPLANID] = '".$result_seBilling['PLANID']."'
                                AND JOBEND ='".$result_seBilling['JOBEND']."'";
          $query_seSumWeighTrip = sqlsrv_query($conn, $sql_seSumWeighTrip, $params_seSumWeighTrip);
          $result_seSumWeighTrip = sqlsrv_fetch_array($query_seSumWeighTrip, SQLSRV_FETCH_ASSOC);

          $sql_RowNumChk = "SELECT  ROW_NUMBER() OVER (PARTITION BY a.JOBEND,a.VEHICLETRANSPORTPLANID ORDER BY a.JOBEND,a.VEHICLETRANSPORTPLANID ASC) AS 'ROWNUM_CHK'
                FROM VEHICLETRANSPORTDOCUMENTDIRVER a 
                WHERE a.VEHICLETRANSPORTPLANID ='".$result_seBilling['PLANID']."'
                AND a.JOBEND ='".$result_seBilling['JOBEND']."'
                ORDER BY ROW_NUMBER() OVER (PARTITION BY a.JOBEND,a.VEHICLETRANSPORTPLANID ORDER BY a.JOBEND,a.VEHICLETRANSPORTPLANID ASC) DESC";
          $query_RowNumChk = sqlsrv_query($conn, $sql_RowNumChk, $params_RowNumChk);
          $result_RowNumChk = sqlsrv_fetch_array($query_RowNumChk, SQLSRV_FETCH_ASSOC);

          

          // CHECK ROWNUM ถ้า ROWNUM มากสุด = ROW NUM จากการเช็คข้อมูล
          if ($result_seBilling['ROWNUM'] == $result_RowNumChk['ROWNUM_CHK']) {
            
              $PRICE = $result_seBilling['PRICE'];
              $WEIGHTIN_TRIP = $result_seSumWeighTrip['WEIGHTIN_TRIP'];
              $THB = $result_seBilling['PRICE'];
              $TOTAL_THB_ACTUAL = $result_seBilling['PRICE'];
              // $SECTION = $result_seBilling['SECTION'];
          }else {

              $PRICE = '';
              $WEIGHTIN_TRIP = ''; 
              $THB = '';
              $TOTAL_THB_ACTUAL = '0';
              // $SECTION = '';
          }
          
          // เช็ค RUNNUMBER_WITHDATE นับตามวันที่
          if($result_seBilling['RUNNUMBER_WITHDATE'] == 1 ){
            
            // เช็ค ROWNUM > 1 
            // ถ้า > 1 จะใส่ค่าว่าง
            if($result_seBilling['RUNNUMBER'] > 1 ){
              $i--;
              $NO = '';
            }else {
              $i = 1;
              $NO = $i;
            }
            
          }else {
            if($result_seBilling['RUNNUMBER'] > 1 ){
              $i--;
              $NO = '';
            }else {
              $NO = $i;
            }
            
          }

          //เงื่อนไขเดิมการใส่ เลข RUNNUMBER
          // เช็ค ROWNUM > 1 
          // ถ้า > 1 จะใส่ค่าว่าง
          // if($result_seBilling['RUNNUMBER'] > 1 )
          // {
          //   $i--;
          //   $NO = '';
            
          // }else {
          //   $NO = $i;
            
            
          // }

          // $TOTAL_THB_CHARGE = ($result_seBilling['DROP']+$THB);
          // $TOTAL_THB_ACTUAL = ($result_seBilling['PRICE'] * ($WEIGHTIN_TRIP/1000));
          // $DIF_THB = $TOTAL_THB_ACTUAL - $TOTAL_THB_CHARGE;

          
          /////////////////////////////////ZONE///////////////////////////////////////////////////////
          ////////////////////////////////FROM////////////////////////////////////////////////////////
          if ($result_seBilling['FROM'] == 'TTAST (G/W)') {
            $jobstart = "TTAST Gateway";
          }else if ($result_seBilling['FROM'] == 'CS (Wellgrow)') {
            $jobstart = "CS Wellgrow";
          }else if ($result_seBilling['FROM'] == 'HANWA (Amata city chonburi)') {
            $jobstart = "HANWA Amata City Chonburi";
          }else if ($result_seBilling['FROM'] == 'HANWA (AMATA)') {
            $jobstart = "HANWA Amata City Chonburi";
          }else if ($result_seBilling['FROM'] == 'OSK (Samrong)') {
            $jobstart = "OSK Samrong";
          }else if ($result_seBilling['FROM'] == 'PTT (Banpho)') {
            $jobstart = "PTT Banpho";
          }else if ($result_seBilling['FROM'] == 'R&N (Bangpee)') {
            $jobstart = "R&N Bangpee";
          }else if ($result_seBilling['FROM'] == 'Sakolchai (Pinthong2)') {
            $jobstart = "SAKOLCHAI Pinthing";
          }else if ($result_seBilling['FROM'] == 'SARATHORN ( Samutsakorn)') {
            $jobstart = "SARATHORN Samutsakorn";
          }else if ($result_seBilling['FROM'] == 'SMTC (Pinthong1)') {
            $jobstart = "SMTC Pinthong1)";
          }else if ($result_seBilling['FROM'] == 'SMTC (Pintong 2)') {
            $jobstart = "SMTC Pinthong2)";
          }else if ($result_seBilling['FROM'] == 'SSSC1') {
            $jobstart = "SSSC1 Poocho";
          }else if ($result_seBilling['FROM'] == 'SSSC1 (Samrong)') {
            $jobstart = "SSSC1 Poocho";
          }else if ($result_seBilling['FROM'] == 'SSSC2 (Samrong)') {
            $jobstart = "SSSC2 Poocho";
          }else if ($result_seBilling['FROM'] == 'SSSC3') {
            $jobstart = "SSSC3 Rayong)";
          }else if ($result_seBilling['FROM'] == 'SSSC3 (Rayong)') {
            $jobstart = "SSSC3 Rayong)";
          }else if ($result_seBilling['FROM'] == 'STC (Amata city chonburi)') {
            $jobstart = "STC Amata City Chonburi";
          }else if ($result_seBilling['FROM'] == 'TMB') {
            $jobstart = "TMB Banpho";
          }else if ($result_seBilling['FROM'] == 'TMT (G/W)') {
            $jobstart = "TMG Gateway";
          }else if ($result_seBilling['FROM'] == 'TMT/GW') {
            $jobstart = "TMG Gateway";
          }else if ($result_seBilling['FROM'] == 'TTAST') {
            $jobstart = "TTAST Gateway";
          }else if ($result_seBilling['FROM'] == 'TTAST (G/W)') {
            $jobstart = "TTAST Gateway";
          }else if ($result_seBilling['FROM'] == 'TTAST (GW)') {
            $jobstart = "TTAST Gateway";
          }else{
            $jobstart = $result_seBilling['FROM'];
          }
          ////////////////////////////////////////JOBEND//////////////////////////////////////////////
          if ($result_seBilling['JOBEND'] == 'TMB') {
            $jobend = "TMB";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'APIGO') {
            $jobend = "AAPICO";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'ASNO') {
            $jobend = "ASNO1";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'TBFST' || $result_seBilling['JOBEND'] == 'TBFST(BOI)') {
            $jobend = "TBFST";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'TYP') {
            $jobend = "TYP";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'WFAN/R.Y.') {
            $jobend = "WFAN/R.Y";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'TMG') {
            $jobend = "TMG";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'SSSC-02') {
            $jobend = "SSSC2";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'SSSC-03') {
            $jobend = "SSSC3";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'TABT/DMK') {
            $jobend = "DMK";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'TMS') {
            $jobend = "TMS";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'SUNSTEEL') {
            $jobend = "SUNSTEEL";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'SRP') {
            $jobend = "S.R-P";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'KIT2/KIT') {
            $jobend = "KIT";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'SHI/SHI2') {
            $jobend = "SHI(2)";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'SHIROKI' || $result_seBilling['JOBEND'] == 'SHIROKI(1)') {
            $jobend = "SHIROKI";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'YMPPD/BT') {
            $jobend = "BTD";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'TTAST-PT') {   ////////////TTASTCS(OTHER)(WEIGHT)
            $jobend = "TTAST-PT";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'JOZU : Teparak') {
            $jobend = "JOZU";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'KSC : Nakhonratchasima') {
            $jobend = "KSC";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'CPS : Amatanakorn') {
            $jobend = "CPS";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'DCL : Banbung') {
            $jobend = "DCL";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'AAA : BanPho') {
            $jobend = "AAA";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'NB WOOD') {
            $jobend = "NB WOOD";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'OTC : Ladkrabang') {
            $jobend = "OTC";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'SAM : Laemchabang') {
            $jobend = "SAM";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'TATP : Pathum Thani') {
            $jobend = "TATP";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'KTAC:Phanat Nikhom') {
            $jobend = "KTAC";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'SYM : Banbung') {
            $jobend = "SYM";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'TSK : Amatanakorn') {
            $jobend = "TSK";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'YAMATO : Sriracha') {
            $jobend = "YAMATO";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'YKT : Eastern Seaboard IE.') {
            $jobend = "YKT";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'YNPN1 : Bangplee') {
            $jobend = "YNPN1";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'YNPN2 : Bangplee') {
            $jobend = "YNPN2";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'YNPN3 : Banpho') {
            $jobend = "YNPN3";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'YS PUND : Wellgrow') {
            $jobend = "YS PUND";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'JSA : Pathum Thani') {
            $jobend = "JSA";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'KCP : Bangpakong') {
            $jobend = "KCP";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'Korawit : Teparak') {
            $jobend = "Korawit";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'TOKAI : Amatanakorn') {
            $jobend = "TOKAI";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'BVS : Banpho') {
            $jobend = "BVS";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'VCS : Banpho') {
            $jobend = "VCS";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'SARATHORN') {
            $jobend = "SARATHORN";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'THAI NIPPON : Laemchabang') {
            $jobend = "THAI NIPPON";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'VORASAK : Ayutthaya') {
            $jobend = "VORASAK";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'SSSC2 : Poochao') {
            $jobend = "SSSC2";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'KEIHIN : Lamphun') {
            $jobend = "KEIHIN";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'KTAC : Samutsakorn') {
            $jobend = "KTAC";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'MONOSTEEL') {
            $jobend = "MONOSTEEL";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'SSSC3 : Easternseaboard') {
            $jobend = "SSSC3";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'UCC2 : Amata') {
            $jobend = "UCC2";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'STC : Amatanakorn') {
            $jobend = "STC";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'STE : Wellgrow') {
            $jobend = "STE";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'WWGF1 : Bangplee') {
            $jobend = "WWG";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'KORAWIT : Teparak') {
            $jobend = "KORAWIT";
            $zone = "";
          }else if ($result_seBilling['JOBEND'] == 'BCC (Amatanakorn)') {
            $jobend = "BCC";
            $zone = "Amata City Chonburi";
          }else if ($result_seBilling['JOBEND'] == 'CS METAL (Wellgrow)') {
            $jobend = "CS METAL";
            $zone = "Wellgrow";
          }else if ($result_seBilling['JOBEND'] == 'CS Wellgrow') {
            $jobend = "CS METAL";
            $zone = "Wellgrow";
          }else if ($result_seBilling['JOBEND'] == 'DMK  (Samrong)') {
            $jobend = "DMK";
            $zone = "Samrong";
          }else if ($result_seBilling['JOBEND'] == 'GTE (EASTERN RAYONG)') {
            $jobend = "GTE";
            $zone = "Eastern Seaboard IE.";
          }else if ($result_seBilling['JOBEND'] == 'Hino  (Bangplee)') {
            $jobend = "HMMT2";
            $zone = "Bangplee";
          }else if ($result_seBilling['JOBEND'] == 'HINO (Ladkrabang)') {
            $jobend = "HMMT4";
            $zone = "Asia Suvarnabhumi Industrial";
          }else if ($result_seBilling['JOBEND'] == 'HISADA (304)') {
            $jobend = "HISADA";
            $zone = "Prachin Buri";
          }else if ($result_seBilling['JOBEND'] == 'INTECH STEEL (Samut Sakhon)') {
            $jobend = "INTECH STEEL";
            $zone = "Samutsakhon";
          }else if ($result_seBilling['JOBEND'] == 'NB WOOD') {
            $jobend = "NB WOOD";
            $zone = "Phanat Nikhom";
          }else if ($result_seBilling['JOBEND'] == 'OTC  (Ladkrabang)') {
            $jobend = "OTC";
            $zone = "Ladkrabang";
          }else if ($result_seBilling['JOBEND'] == 'R&N (Samrong)') {
            $jobend = "R&N STEEL";
            $zone = "Bangplee";
          }else if ($result_seBilling['JOBEND'] == 'Sakolchai (Pinthong)') {
            $jobend = "SAKOLCHAI";
            $zone = "Pinthong";
          }else if ($result_seBilling['JOBEND'] == 'SANGO THAI ENGINEERING & MANFATURING CO.,LTD') {
            $jobend = "STE";
            $zone = "Wellgrow";
          }else if ($result_seBilling['JOBEND'] == 'Sarathon (Samutsakhon)') {
            $jobend = "SARATHORN";
            $zone = "Samutsakorn";
          }else if ($result_seBilling['JOBEND'] == 'SASC (Hemaraj Eastern Seaboard Rayong)') {
            $jobend = "SASC";
            $zone = "Eastern Seaboard IE.";
          }else if ($result_seBilling['JOBEND'] == 'SMM (Omnoi  Samutsakhon)') {
            $jobend = "SMM";
            $zone = "Samutsakorn";
          }else if ($result_seBilling['JOBEND'] == 'SSSC1 (Samutprakarn)') {
            $jobend = "SSSC1";
            $zone = "Poochao";
          }else if ($result_seBilling['JOBEND'] == 'SSSC2') {
            $jobend = "SSSC2";
            $zone = "Poochao";
          }else if ($result_seBilling['JOBEND'] == 'SSSC3 (Rayong)') {
            $jobend = "SSSC3";
            $zone = "Rayong";
          }else if ($result_seBilling['JOBEND'] == 'STC (Amata city chonburi)') {
            $jobend = "STC";
            $zone = "Amata City Chonburi";
          }else if ($result_seBilling['JOBEND'] == 'Sun Steel (Samutsakhon)') {
            $jobend = "MONOSTEEL";
            $zone = "Samutsakhon";
          }else if ($result_seBilling['JOBEND'] == 'TAKEBE (Amata city chonburi)') {
            $jobend = "TKB";
            $zone = "Amata City Chonburi";
          }else if ($result_seBilling['JOBEND'] == 'TDEM') {
            $jobend = "TDEM";
            $zone = "Bangbo";
          }else if ($result_seBilling['JOBEND'] == 'THAPT (Wellgrow)') {
            $jobend = "THAPT";
            $zone = "Wellgrow";
          }else if ($result_seBilling['JOBEND'] == 'TMT  (Samrong)') {
            $jobend = "TMT";
            $zone = "Samrong";
          }else if ($result_seBilling['JOBEND'] == 'TTAST  Plant2  (Pinthong)') {
            $jobend = "TTAST2";
            $zone = "Pinthong 3";
          }else if ($result_seBilling['JOBEND'] == 'TTAST (Pinthong)') {
            $jobend = "TTAST2";
            $zone = "Pinthong 3";
          }else if ($result_seBilling['JOBEND'] == 'TTAST 2 (Pinthong)') {
            $jobend = "TTAST2";
            $zone = "Pinthong 3";
          }else if ($result_seBilling['JOBEND'] == 'TTAST(Geteway)') {
            $jobend = "TTAST";
            $zone = "Geteway";
          }else if ($result_seBilling['JOBEND'] == 'TTAST2 (Pinthong2)') {
            $jobend = "TTAST2";
            $zone = "Pinthong 3";
          }else if ($result_seBilling['JOBEND'] == 'WMF(King Kaew)') {
            $jobend = "WMF";
            $zone = "Kingkaew";
          }else if ($result_seBilling['JOBEND'] == 'sunsteel') {
            $jobend = "MONOSTEEL";
            $zone = "Samutsakorn";
          }else if ($result_seBilling['JOBEND'] == 'STC') {
            $jobend = "STC";
            $zone = "Amata City Chonburi";
          }else if ($result_seBilling['JOBEND'] == 'นพเกตุ') {
            $jobend = "SWN";
            $zone = "Banbung";
          }else if ($result_seBilling['JOBEND'] == 'SSSC2 (Samrong)') {
            $jobend = "SSSC2";
            $zone = "Poochao";
          }else if ($result_seBilling['JOBEND'] == 'TTAST (Pinthong3)') {
            $jobend = "TTAST2";
            $zone = "Pinthong 3";
          }else if ($result_seBilling['JOBEND'] == 'SASC') {
            $jobend = "SASC";
            $zone = "Eastern Seaboard IE.";
          }else if ($result_seBilling['JOBEND'] == 'TTAST2') {
            $jobend = "TTAST2";
            $zone = "Pinthong 3";
          }else if ($result_seBilling['JOBEND'] == 'SSSC1 (Samrong)') {
            $jobend = "SSSC1";
            $zone = "Poochao";
          }else if ($result_seBilling['JOBEND'] == 'R&N steel') {
            $jobend = "R&N STEEL";
            $zone = "Bangplee";
          }else if ($result_seBilling['JOBEND'] == 'TTAST (GW)') {
            $jobend = "TTAST";
            $zone = "Gateway";
          }else {
            $jobend = $result_seBilling['JOBEND'];
            $zone = "";
          }
      ?>




            <tr style="border:1px solid #000;">
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?= $NO ?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling['DATE']?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling['TRUCKNO']?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling['TYPE']?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:left;"><?=$result_seBilling['DRIVER']?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$jobstart?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$jobend?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$zone?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling['DOCUMENTCODE']?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling['SECTION']?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$PRICE == '' ? '' : number_format($PRICE,2)?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
            <!-- <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$WEIGHTIN_TRIP == '' ? ''  : number_format($WEIGHTIN_TRIP/1000,3)?></td>  -->
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;">1</td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;">D</td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$THB == '' ? '' : number_format($THB,2)?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$TOTAL_THB_ACTUAL == '0' ? '' : number_format($TOTAL_THB_ACTUAL,2)?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"></td>


            </tr>
            <?php
            $i++;
            // $sumtotalton += $result_seBilling['WEIGHTIN'];
            // $sumtotalprice += $result_seBilling['PRICE'];
          }
            ?>

    </tbody>
 </table>

<!-- //////////////////////////////////// /////////////////////////////////////// -->

  </body>
</html>
