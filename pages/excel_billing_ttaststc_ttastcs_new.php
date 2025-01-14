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
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>TOTAL THB(CHANGE)</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>TOTAL THB(ACTUAL)</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>DIFF(THB)</b></td>
           <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>REMARK</b></td>
           <!-- <td colspan="" style="border-right:1px solid #000;padding:4px;text-align:center;"><b>WORKTYPE</b></td> -->
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
          a.DOCUMENTCODE AS 'DOCUMENTCODE',c.BILLING2 AS 'SECTION',c.PRICE AS 'PRICE',
          CONVERT(NVARCHAR,CONVERT(DECIMAL(10,3),CONVERT(DECIMAL(10,3),CONVERT(INT,a.WEIGHTIN)) / 1000)) AS 'WEIGHT_TON',
          a.DESTINATION AS 'DESTINATION',b.C8 AS 'GORETURN',

          CASE WHEN a.REMARK = 'CHARGE 12' THEN '12.000'
          WHEN a.REMARK = 'NOT CHARGE' THEN '0.000'
          WHEN a.REMARK = 'RETURN' THEN '0.000'
          ELSE ''
          END AS 'CHARGE',

          CASE WHEN a.DESTINATION = 'C' AND  b.C8 != 'return' THEN '100'
          ELSE ''
          END AS 'DROP',
          a.ACTUALPRICEHEAD AS 'TOTAL_THB',a.REMARK AS 'REMARK'
          
          
          FROM VEHICLETRANSPORTDOCUMENTDIRVER a 
          INNER JOIN VEHICLETRANSPORTPLAN b  ON  a.VEHICLETRANSPORTPLANID  = b.VEHICLETRANSPORTPLANID
          INNER JOIN VEHICLETRANSPORTPRICE c ON  a.VEHICLETRANSPORTPRICEID = c.VEHICLETRANSPORTPRICEID
          WHERE a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
          AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['startdate']."',103) AND CONVERT(DATE,'".$_GET['enddate']."',103)
          AND (a.DOCUMENTCODE !=''  OR a.DOCUMENTCODE IS NOT NULL)
          AND (a.WEIGHTIN !=''      OR a.WEIGHTIN IS NOT NULL)
          ORDER BY b.DATEWORKING,b.VEHICLETRANSPORTPLANID,b.JOBNO,a.JOBEND ASC";
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

          //เช็ค DIF สำหรับไปคำนวณการชาท
          if ($result_seBilling['CHARGE'] == '12.000') {
              $DIF_CHK = '12000';
          }else{
              $DIF_CHK = '0';
          }

          //เช็คว่าเป็นงานรับกลับ
          // if ($result_seBilling['GORETURN'] == 'return') {
          //     $GORETURN_CHK = 'RETURN';
          // }else{
          //     $GORETURN_CHK = '';
          // }

          // CHECK ROWNUM ถ้า ROWNUM มากสุด = ROW NUM จากการเช็คข้อมูล
          if ($result_seBilling['ROWNUM'] == $result_RowNumChk['ROWNUM_CHK']) {
              $CHARGE = $result_seBilling['CHARGE'];
              $WEIGHTIN_TRIP = $result_seSumWeighTrip['WEIGHTIN_TRIP'];

              if ($DIF_CHK == '0') {
                $DIF_TON = '0.000';
              }else{
                $DIF_TON = ($DIF_CHK - $WEIGHTIN_TRIP)/1000;
              }
              $THB = $result_seBilling['TOTAL_THB'];
              $DROP = $result_seBilling['DROP'];
              $TOTAL_THB_CHARGE = ($result_seBilling['DROP']+$THB);
              $TOTAL_THB_ACTUAL = ($result_seBilling['PRICE'] * ($WEIGHTIN_TRIP/1000));
              $DIF_THB =  $TOTAL_THB_CHARGE - $TOTAL_THB_ACTUAL ;
              $REMARK = $result_seBilling['REMARK'];
              // $GORETURN = $GORETURN_CHK;
          }else {
              $CHARGE = '';
              $WEIGHTIN_TRIP = '';
              $DIF_TON = '';
              $THB = '';
              $DROP = '';
              $TOTAL_THB_CHARGE = '0';
              $TOTAL_THB_ACTUAL = '0';
              $DIF_THB = '0';
              $REMARK = '';
              // $GORETURN = '';
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


          

          // $TOTAL_THB_CHARGE = ($result_seBilling['DROP']+$THB);
          // $TOTAL_THB_ACTUAL = ($result_seBilling['PRICE'] * ($WEIGHTIN_TRIP/1000));
          // $DIF_THB = $TOTAL_THB_ACTUAL - $TOTAL_THB_CHARGE;
      /////////////////////////////////ZONE////////////////////////////////////////////////////////////
          if ($result_seBilling['LOCATION'] == 'พระประแดง/สำโรง' || $result_seBilling['LOCATION'] == 'สำโรง') {
            $zone ="Samrong";
          } else if ($result_seBilling['LOCATION'] == 'บางพลี') {
            $zone ="Bangplee";
          } else if ($result_seBilling['LOCATION'] == 'เทพารักษ์') {
            if ($result_seBilling['JOBEND'] == 'HINO2') {
            $zone ="Bangplee";
            }else {
            $zone ="Thepharak";
            }

          } else if ($result_seBilling['LOCATION'] == 'ลาดกระบัง') {
            $zone ="Ladkrabang";
          } else if ($result_seBilling['LOCATION'] == 'บางประกง') {
            if ($result_seBilling['JOBEND'] == 'REFORM') {
              $zone ="Wellgrow";
            }else if ($result_seBilling['JOBEND'] == 'TOY') {
              $zone ="Banpho";
            }else {
              $zone ="Bang Pakong";
            }

          } else if ($result_seBilling['LOCATION'] == 'บ้านโพธิ์') {
            $zone ="Banpho";
          } else if ($result_seBilling['LOCATION'] == 'แปลงยาว') {
            if ($result_seBilling['JOBEND'] == 'NB-WOOD') {
              $zone ="Phanat Nikhom";

            }else {
              $zone ="Gateway";
            }

          } else if ($result_seBilling['LOCATION'] == 'บ้านบึง') {
            $zone ="Banbueng";
          } else if ($result_seBilling['LOCATION'] == 'ศรีราชา') {
            $zone ="Sriracha";
          } else if ($result_seBilling['LOCATION'] == 'ปลวกแดง') {
            if ($result_seBilling['JOBEND'] == 'AHT2' || $result_seBilling['JOBEND'] == 'BHKT' || $result_seBilling['JOBEND'] == 'TBFST' 
            || $result_seBilling['JOBEND'] == 'TBFST(BOI)' || $result_seBilling['JOBEND'] == 'FTS2'|| $result_seBilling['JOBEND'] == 'FTS1'
			|| $result_seBilling['JOBEND'] == 'SASC') {
              
                $zone ="Eastern Seaboard IE.";
            
            }else if($result_seBilling['JOBEND'] == 'ALS') {
              $zone ="Borwin";
            }else {
              $zone ="Rayong";
            }

          } else if ($result_seBilling['LOCATION'] == 'อมตะนคร') {
            $zone ="Amata City Chonburi";
          } else if ($result_seBilling['LOCATION'] == 'บางปะอิน') {
            $zone ="Ayutthaya";
          } else if ($result_seBilling['LOCATION'] == 'กระทุ่มแบน') {
            $zone ="Prachin Buri";
          }else if ($result_seBilling['LOCATION'] == 'เทพารักษ์') {
            $zone ="Samutsakorn";
          }else if ($result_seBilling['LOCATION'] == 'กบินบุรี') {
            if ($result_seBilling['JOBEND'] == 'HISADA') {
              $zone ="Prachin Buri";
            }else {
              $zone ="Kabinburi";
            }

          }else if ($result_seBilling['LOCATION'] == 'บางบ่อ/บางพลี') {
            if ($result_seBilling['JOBEND'] == 'SIMA') {
              $zone ="Bangplee";
            }else {
              $zone ="Bang-bo";
            }

          } else if ($result_seBilling['LOCATION'] == 'เมือง'){
            if ($result_seBilling['JOBEND'] == 'SARATHORN' || $result_seBilling['JOBEND'] == 'SUNSTEEL' || $result_seBilling['JOBEND'] == 'MONOSTEEL') {
              $zone = "Samutsakorn";
            }else if ($result_seBilling['JOBEND'] == 'KPN' ) {
              $zone = "Samutprakan";
            }else if ($result_seBilling['JOBEND'] == 'WISDOM' ) {
              $zone = "Chachoengsao";
            }else {
              $zone = "Mueang";
            }

          } else if($result_seBilling['LOCATION'] == 'เวลโกรว์' || $result_seBilling['LOCATION'] == 'เวลล์โกร์') {
            $zone = "Wellgrow";
          } else if($result_seBilling['LOCATION'] == 'สุขสวัสดิ์') {
            $zone = "Suksawat";
          } else if($result_seBilling['LOCATION'] == 'หนองแค') {
            $zone = "Saraburi";
          }else if($result_seBilling['LOCATION'] == 'แปลงยาว') {
            $zone = "Gateway";
          }else if($result_seBilling['LOCATION'] == 'ปู่เจ้า') {
            $zone = "Poochao";
          }else if($result_seBilling['LOCATION'] == 'พนัสนิคม') {
            $zone = "Phanat Nikhom";
          }else if($result_seBilling['LOCATION'] == 'ประชาอุทิศ') {
            $zone = "Pracha Uthid";
          }else if($result_seBilling['LOCATION'] == 'อีสเทิร์นซีบอร์ด' || $result_seBilling['LOCATION'] == 'อีสเทิร์น ซีบอร์ด') {
			if ($result_seBilling['JOBEND'] == 'SSSC3' || $result_seBilling['JOBEND'] == 'SSSC3 : Easternseaboard') {
              $zone ="Rayong";
            }else {
              $zone ="Eastern Seaboard IE.";
            }
          }else if($result_seBilling['LOCATION'] == 'แหลมฉบัง') {
            $zone = "Laemchabang";
          }else if($result_seBilling['LOCATION'] == 'ปทุมธานี') {
            $zone = "Pathum Thani";
          }else if($result_seBilling['LOCATION'] == 'อยุธยา') {
            $zone = "Ayutthaya";
          }else if($result_seBilling['LOCATION'] == 'บางปู') { 
            $zone = "Bang Pu";
          }else {
            $zone = $result_seBilling['LOCATION'];
          }

          ////////////////////////////////////////JOBEND///////////////////////////////////////////////
            if ($result_seBilling['JOBEND'] == 'TMB') {
              $jobend = "TMB";
            }else if ($result_seBilling['JOBEND'] == 'APIGO') {
              $jobend = "AAPICO";
            }else if ($result_seBilling['JOBEND'] == 'ASNO') {
              $jobend = "ASNO1";
            }else if ($result_seBilling['JOBEND'] == 'TBFST' || $result_seBilling['JOBEND'] == 'TBFST(BOI)') {
              $jobend = "TBFST";
            }else if ($result_seBilling['JOBEND'] == 'TYP') {
              $jobend = "TYP";
            }else if ($result_seBilling['JOBEND'] == 'WFAN/R.Y.') {
              $jobend = "WFAN/R.Y";
            }else if ($result_seBilling['JOBEND'] == 'TMG') {
              $jobend = "TMG";
            }else if ($result_seBilling['JOBEND'] == 'SSSC-02') {
              $jobend = "SSSC2";
            }else if ($result_seBilling['JOBEND'] == 'SSSC-03') {
              $jobend = "SSSC3";
            }else if ($result_seBilling['JOBEND'] == 'TABT/DMK') {
              $jobend = "DMK";
            }else if ($result_seBilling['JOBEND'] == 'TMS') {
              $jobend = "TMS";
            }else if ($result_seBilling['JOBEND'] == 'SUNSTEEL') {
              $jobend = "SUNSTEEL";
            }else if ($result_seBilling['JOBEND'] == 'SRP') {
              $jobend = "S.R-P";
            }else if ($result_seBilling['JOBEND'] == 'KIT2/KIT') {
              $jobend = "KIT";
            }else if ($result_seBilling['JOBEND'] == 'SHI/SHI2') {
              $jobend = "SHI(2)";
            }else if ($result_seBilling['JOBEND'] == 'SHIROKI' || $result_seBilling['JOBEND'] == 'SHIROKI(1)') {
              $jobend = "SHIROKI";
            }else if ($result_seBilling['JOBEND'] == 'YMPPD/BT') {
              $jobend = "BTD";
            }else if ($result_seBilling['JOBEND'] == 'TTAST-PT') {   ////////////TTASTCS(OTHER)(WEIGHT)
              $jobend = "TTAST-PT";
            }else if ($result_seBilling['JOBEND'] == 'JOZU : Teparak') {
              $jobend = "JOZU";
            }else if ($result_seBilling['JOBEND'] == 'KSC : Nakhonratchasima') {
              $jobend = "KSC";
            }else if ($result_seBilling['JOBEND'] == 'CPS : Amatanakorn') {
              $jobend = "CPS";
            }else if ($result_seBilling['JOBEND'] == 'DCL : Banbung') {
              $jobend = "DCL";
            }else if ($result_seBilling['JOBEND'] == 'AAA : BanPho') {
              $jobend = "AAA";
            }else if ($result_seBilling['JOBEND'] == 'NB WOOD') {
              $jobend = "NB WOOD";
            }else if ($result_seBilling['JOBEND'] == 'OTC : Ladkrabang') {
              $jobend = "OTC";
            }else if ($result_seBilling['JOBEND'] == 'SAM : Laemchabang') {
              $jobend = "SAM";
            }else if ($result_seBilling['JOBEND'] == 'TATP : Pathum Thani') {
              $jobend = "TATP";
            }else if ($result_seBilling['JOBEND'] == 'KTAC:Phanat Nikhom') {
              $jobend = "KTAC";
            }else if ($result_seBilling['JOBEND'] == 'SYM : Banbung') {
              $jobend = "SYM";
            }else if ($result_seBilling['JOBEND'] == 'TSK : Amatanakorn') {
              $jobend = "TSK";
            }else if ($result_seBilling['JOBEND'] == 'YAMATO : Sriracha') {
              $jobend = "YAMATO";
            }else if ($result_seBilling['JOBEND'] == 'YKT : Eastern Seaboard IE.') {
              $jobend = "YKT";
            }else if ($result_seBilling['JOBEND'] == 'YNPN1 : Bangplee') {
              $jobend = "YNPN1";
            }else if ($result_seBilling['JOBEND'] == 'YNPN2 : Bangplee') {
              $jobend = "YNPN2";
            }else if ($result_seBilling['JOBEND'] == 'YNPN3 : Banpho') {
              $jobend = "YNPN3";
            }else if ($result_seBilling['JOBEND'] == 'YS PUND : Wellgrow') {
              $jobend = "YS PUND";
            }else if ($result_seBilling['JOBEND'] == 'JSA : Pathum Thani') {
              $jobend = "JSA";
            }else if ($result_seBilling['JOBEND'] == 'KCP : Bangpakong') {
              $jobend = "KCP";
            }else if ($result_seBilling['JOBEND'] == 'Korawit : Teparak') {
              $jobend = "Korawit";
            }else if ($result_seBilling['JOBEND'] == 'TOKAI : Amatanakorn') {
              $jobend = "TOKAI";
            }else if ($result_seBilling['JOBEND'] == 'BVS : Banpho') {
              $jobend = "BVS";
            }else if ($result_seBilling['JOBEND'] == 'VCS : Banpho') {
              $jobend = "VCS";
            }else if ($result_seBilling['JOBEND'] == 'SARATHORN') {
              $jobend = "SARATHORN";
            }else if ($result_seBilling['JOBEND'] == 'THAI NIPPON : Laemchabang') {
              $jobend = "THAI NIPPON";
            }else if ($result_seBilling['JOBEND'] == 'VORASAK : Ayutthaya') {
              $jobend = "VORASAK";
            }else if ($result_seBilling['JOBEND'] == 'SSSC2 : Poochao') {
              $jobend = "SSSC2";
            }else if ($result_seBilling['JOBEND'] == 'KEIHIN : Lamphun') {
              $jobend = "KEIHIN";
            }else if ($result_seBilling['JOBEND'] == 'KTAC : Samutsakorn') {
              $jobend = "KTAC";
            }else if ($result_seBilling['JOBEND'] == 'MONOSTEEL') {
              $jobend = "MONOSTEEL";
            }else if ($result_seBilling['JOBEND'] == 'SSSC3 : Easternseaboard') {
              $jobend = "SSSC3";
            }else if ($result_seBilling['JOBEND'] == 'UCC2 : Amata') {
              $jobend = "UCC2";
            }else if ($result_seBilling['JOBEND'] == 'STC : Amatanakorn') {
              $jobend = "STC";
            }else if ($result_seBilling['JOBEND'] == 'STE : Wellgrow') {
              $jobend = "STE";
            }else if ($result_seBilling['JOBEND'] == 'WWGF1 : Bangplee') {
              $jobend = "WWG";
            }else if ($result_seBilling['JOBEND'] == 'KORAWIT : Teparak') {
              $jobend = "KORAWIT";
            }else {
              $jobend = $result_seBilling['JOBEND'];
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
            <?php
            // กรณีงานรับกลับ ต้นทางและปลายทางจะสลับกัน
            if ($result_seBilling['GORETURN'] == 'return') {
            ?>
              <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$jobend?></td>
              <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$_GET['customercode'] == 'TTASTCS' ? 'CS Wellgrow' : 'STC Amata City Chonburi'?></td>
            <?php
            }else {
            ?>
              <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$_GET['customercode'] == 'TTASTCS' ? 'CS Wellgrow' : 'STC Amata City Chonburi'?></td>
              <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$jobend?></td>
            <?php
            }
            ?>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$zone?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling['DOCUMENTCODE']?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling['SECTION']?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling['PRICE']?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling['WEIGHT_TON']?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$WEIGHTIN_TRIP == '' ? '' : number_format($WEIGHTIN_TRIP/1000,3)?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$result_seBilling['DESTINATION']?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$CHARGE == '0.000' ? number_format($WEIGHTIN_TRIP/1000,3) : $CHARGE?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$DIF_TON == '' ? '' : number_format($DIF_TON,3)?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$THB == '' ? '' : number_format($THB,3)?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$DROP?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$TOTAL_THB_CHARGE == '0' ? '' : number_format($TOTAL_THB_CHARGE,3)?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$TOTAL_THB_ACTUAL == '0' ? '' : number_format($TOTAL_THB_ACTUAL,3)?></td>
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$DIF_THB == '0' ? '0.00' : str_replace("-"," ",number_format($DIF_THB,2));?></td>
            <!-- <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$DIF_THB == '0' ? '0.00' : $DIF_THB?></td> -->
            <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$REMARK?></td>
            <!-- <td colspan="" style="border-right:1px solid #000;padding:5px;text-align:center;"><?=$GORETURN?></td> -->

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
