<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

if ($_GET['companycode'] == "" || $_GET['companycode'] == "") {
  $strExcelFileName = "แผนประจำวัน DENSO+TGT".$result_getDate['SYSDATE'].".xls";
} else {
  $strExcelFileName = "Summary_Tenko" . $result_getDate['SYSDATE'] . ".xls";
}


// 
// header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
// header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
// header("Pragma:no-cache");


?>
<style>
        input.largerCheckbox {
            width: 20px;
            height: 20px;
        }
    </style>

<!-- ////////////////////////////////////////////////DENSO-THAI///////////////////////////////////////////////// -->

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<table id="bg-table"  colspan="44"  style="border-collapse: collapse;margin-top:8px;" width="100%" >
    <tbody>
      <thead>
        <th >
          <tr>
            <td   colspan="4" rowspan="4"  width="10%" style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;padding:2px;text-align:left"><img src="../images/logonew.png"></b></td>
            <td   colspan="4" rowspan="4" width="1%" style="border-top:1px solid #000;border-bottom:1px solid #000;padding:4px;text-align:left"><input type="checkbox" class="largerCheckbox" disabled="disabled" checked="checked"></input></td>
            <td   colspan="4" rowspan="4" width="4%" style="border-top:1px solid #000;border-bottom:1px solid #000;padding:4px;text-align:left"><b>DITH </b></td>
            <td   colspan="4" rowspan="4" width="1%" style="border-top:1px solid #000;border-bottom:1px solid #000;padding:4px;text-align:left"><b><input type="checkbox" class="largerCheckbox" disabled="disabled"  ></input> </b></td>
            <td   colspan="4" rowspan="4" width="4%" style="border-top:1px solid #000;border-bottom:1px solid #000;padding:4px;text-align:left"><b>TGT </b></td>
            <td   colspan="4" rowspan="4" width="5%" style="border-top:1px solid #000;border-bottom:1px solid #000;padding:4px;text-align:left"><b></b></td>
            <td   colspan="4" rowspan="4" width="10%" style="border-top:1px solid #000;border-bottom:1px solid #000;padding:4px;text-align:left"><b> <?=$result_getDate['SYSDATE']?></b></td>
            <td   colspan="4" rowspan="4" width="5%" style="border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;padding:4px;text-align:left"><b></b></td>
            <td   colspan="4" width="15%" bgcolor="#DCE6F1" style="border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;padding:12px;text-align:center"><b>Planing </b></td>
            <td   colspan="4" width="15%" bgcolor="#DCE6F1" style="border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;padding:4px;text-align:center"><b>Operate</b></td>
            <td   colspan="4" width="15%" bgcolor="#DCE6F1" style="border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;padding:4px;text-align:center"><b>Control</b></td>
          </tr>
        </th>
        <tr>
          <td   colspan="4" style="border:1px solid #000;padding:20px;text-align:left"><b></b></td>
          <td   colspan="4" style="border:1px solid #000;padding:20px;text-align:left"><b></b></td>
          <td   colspan="4" style="border:1px solid #000;padding:20px;text-align:left"><b></b></td>



        </tr>
      </thead>
      </tbody>
  </table>
  <br>
  <table   style="border-collapse: collapse;margin-top:8px;font-size:12px" width="100%"  >
      <tr>
        <th colspan="10" style="border:1px solid #000;padding:8px;text-align:left"></th>
        <th colspan="14"  style="border-top:1px solid #000;border-bottom:1px solid #000;padding:8px;text-align:left">DENSO</th>
        <th colspan="18" style="border-right: 1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;padding:8px;text-align:left"><?=$result_getDate['SYSDATE']?> &#160; &#160; &#160; &#160;Master</th>
        <th colspan="4" style="border:1px solid #000;padding:8px;text-align:left">Memory Card</th>
        <th colspan="2" style="border:1px solid #000;padding:8px;text-align:left"></th>
      </tr>
      <tr>
        <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">ลำดับ</th>
        <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">ทะเบียน</th>
        <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">ชื่อรถ</th>
        <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">พขร.</th>
        <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">ผช. พขร.</th>

        <th  colspan="14" style="border:1px solid #000;padding:4px;text-align:left">ลูกค้า</th>

        <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">ROUTE</th>
        <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">ชนิดรถ</th>
        <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">รายงานตัว</th>
        <th  colspan="4" style="border:1px solid #000;padding:4px;text-align:left">เวลาโหลด</th>
        <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">ออกจากYard</th>
        <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">รอบเวลาลงงาน</th>
        <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">เวลากลับ</th>
        <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">หมายเหตุ</th>

        <th colspan="2"  style="border:1px solid #000;padding:4px;text-align:left">รับ</th>
        <th colspan="2" style="border:1px solid #000;padding:4px;text-align:left">ส่ง</th>

        <th colspan="2" style="border:1px solid #000;padding:4px;text-align:left">พขร. เซ็นรับทราบ</th>
      </tr>

      <?php

      $i = 1;
      $sql_seBilling = "SELECT a.THAINAME AS 'THAINAME1',c.THAINAME AS 'THAINAME2',a.EMPLOYEENAME1 AS 'EMP1',a.EMPLOYEENAME2 AS 'EMP2',
                    b.ROUTEDESCRIPTION AS 'ROUTEDES',a.JOBSTART AS 'JOBSTART',b.VEHICLETYPE AS 'VEHICLETYPE',a.JOBEND AS 'JOBEND',
                    FORMAT (CONVERT(DATE,a.DATEWORKING,103),'dd-MM-yyyy') AS 'DATE'
                    FROM [dbo].[VEHICLETRANSPORTPLAN] a
                    INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] b ON b.VEHICLETRANSPORTPRICEID = a.VEHICLETRANSPORTPRICEID
                    INNER JOIN [dbo].[VEHICLEINFO] c ON c.VEHICLEREGISNUMBER = a.THAINAME
                    WHERE a.COMPANYCODE='RKS' AND a.CUSTOMERCODE='DENSO-THAI'
                    AND a.ACTIVESTATUS = 1 AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
                    ORDER BY JOBEND ASC ";
      $params_seBilling = array();

      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
       ?>
      <tr>
        <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $i ?></td>
        <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['THAINAME1']?></td>
        <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['THAINAME2']?></td>
        <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['EMP1']?></td>
        <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['EMP2']?></td>

        <td colspan="14"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['ROUTEDES']?></td>

        <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['JOBSTART']?></td>
        <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['VEHICLETYPE']?></td>
        <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['']?></td>
        <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['']?></td>
        <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['']?></td>
        <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['']?></td>
        <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['']?></td>
        <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['']?></td>
        <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['JOBEND']?></td>

        <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['']?></td>
        <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['']?></td>

        <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['']?></td>




      </tr>
      <?php
      $i++;

      }

       ?>
    </table>
<br><br><br>
<!-- //////////////////////////////////////TGT////////////////////////////////////////////////// -->
<table id="bg-table"  colspan="44"  style="border-collapse: collapse;" width="100%" >
    <tbody>
      <thead>
        <th >
          <tr>
            <td   colspan="4" rowspan="4"  width="10%" style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;padding:2px;text-align:left"><img src="../images/logonew.png"></b></td>
            <td   colspan="4" rowspan="4" width="1%" style="border-top:1px solid #000;border-bottom:1px solid #000;padding:4px;text-align:left"><input type="checkbox" class="largerCheckbox" disabled="disabled" ></input></td>
            <td   colspan="4" rowspan="4" width="4%" style="border-top:1px solid #000;border-bottom:1px solid #000;padding:4px;text-align:left"><b>DITH </b></td>
            <td   colspan="4" rowspan="4" width="1%" style="border-top:1px solid #000;border-bottom:1px solid #000;padding:4px;text-align:left"><b><input type="checkbox" class="largerCheckbox" disabled="disabled" checked="checked" ></input> </b></td>
            <td   colspan="4" rowspan="4" width="4%" style="border-top:1px solid #000;border-bottom:1px solid #000;padding:4px;text-align:left"><b>TGT </b></td>
            <td   colspan="4" rowspan="4" width="5%" style="border-top:1px solid #000;border-bottom:1px solid #000;padding:4px;text-align:left"><b></b></td>
            <td   colspan="4" rowspan="4" width="10%" style="border-top:1px solid #000;border-bottom:1px solid #000;padding:4px;text-align:left"><b> <?=$result_getDate['SYSDATE']?></b></td>
            <td   colspan="4" rowspan="4" width="5%" style="border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;padding:4px;text-align:left"><b></b></td>
            <td   colspan="4" width="15%" bgcolor="#DCE6F1" style="border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;padding:12px;text-align:center"><b>Planing </b></td>
            <td   colspan="4" width="15%" bgcolor="#DCE6F1" style="border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;padding:4px;text-align:center"><b>Operate</b></td>
            <td   colspan="4" width="15%" bgcolor="#DCE6F1" style="border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;padding:4px;text-align:center"><b>Control</b></td>
          </tr>
        </th>
        <tr>
          <td   colspan="4" style="border:1px solid #000;padding:20px;text-align:left"><b></b></td>
          <td   colspan="4" style="border:1px solid #000;padding:20px;text-align:left"><b></b></td>
          <td   colspan="4" style="border:1px solid #000;padding:20px;text-align:left"><b></b></td>



        </tr>
      </thead>
      </tbody>
  </table>
<br>
<table   style="border-collapse: collapse;margin-top:8px;font-size:12px" width="100%"  >
    <tr>
      <th colspan="10" style="border:1px solid #000;padding:8px;text-align:left"></th>
      <th colspan="14"  style="border-top:1px solid #000;border-bottom:1px solid #000;padding:8px;text-align:left">DENSO</th>
      <th colspan="18" style="border-right: 1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;padding:8px;text-align:left"><?=$result_getDate['SYSDATE']?> &#160; &#160; &#160; &#160;Master</th>
      <th colspan="4" style="border:1px solid #000;padding:8px;text-align:left">Memory Card</th>
      <th colspan="2" style="border:1px solid #000;padding:8px;text-align:left"></th>
    </tr>
    <tr>
      <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">ลำดับ</th>
      <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">ทะเบียน</th>
      <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">ชื่อรถ</th>
      <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">พขร.</th>
      <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">ผช. พขร.</th>

      <th  colspan="14" style="border:1px solid #000;padding:4px;text-align:left">ลูกค้า</th>

      <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">ROUTE</th>
      <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">ชนิดรถ</th>
      <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">รายงานตัว</th>
      <th  colspan="4" style="border:1px solid #000;padding:4px;text-align:left">เวลาโหลด</th>
      <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">ออกจากYard</th>
      <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">รอบเวลาลงงาน</th>
      <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">เวลากลับ</th>
      <th  colspan="2" style="border:1px solid #000;padding:4px;text-align:left">หมายเหตุ</th>

      <th colspan="2"  style="border:1px solid #000;padding:4px;text-align:left">รับ</th>
      <th colspan="2" style="border:1px solid #000;padding:4px;text-align:left">ส่ง</th>

      <th colspan="2" style="border:1px solid #000;padding:4px;text-align:left">พขร. เซ็นรับทราบ</th>
    </tr>

    <?php

    $i = 1;
    $sql_seBilling = "SELECT a.THAINAME AS 'THAINAME1',c.THAINAME AS 'THAINAME2',a.EMPLOYEENAME1 AS 'EMP1',a.EMPLOYEENAME2 AS 'EMP2',
                      b.ROUTEDESCRIPTION AS 'ROUTEDES',a.JOBSTART AS 'JOBSTART',b.VEHICLETYPE AS 'VEHICLETYPE',a.JOBEND AS 'JOBEND',a.ROUNDAMOUNT AS 'ROUND',
                      FORMAT (CONVERT(DATE,a.DATEWORKING,103),'dd-MM-yyyy') AS 'DATE'
                      FROM [dbo].[VEHICLETRANSPORTPLAN] a
                      INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] b ON b.VEHICLETRANSPORTPRICEID = a.VEHICLETRANSPORTPRICEID
                      INNER JOIN [dbo].[VEHICLEINFO] c ON c.VEHICLEREGISNUMBER = a.THAINAME
                      WHERE a.COMPANYCODE='RKS' AND a.CUSTOMERCODE='TGT'
                      AND a.ACTIVESTATUS = 1 AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
                      ORDER BY JOBEND ASC ";
    $params_seBilling = array();

    $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
    while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
     ?>
    <tr>
      <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $i ?></td>
      <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['THAINAME1']?></td>
      <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['THAINAME2']?></td>
      <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['EMP1']?></td>
      <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['EMP2']?></td>

      <td colspan="14"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['JOBSTART']?></td>

      <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['JOBEND']?></td>
      <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['VEHICLETYPE']?></td>
      <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['']?></td>
      <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['']?></td>
      <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['']?></td>
      <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['']?></td>
      <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['']?></td>
      <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['']?></td>
      <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['ROUND']?></td>

      <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['']?></td>
      <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['']?></td>

      <td colspan="2"  style="border:1px solid #000;padding:4px;text-align:left"><?= $result_seBilling['']?></td>




    </tr>
    <?php
    $i++;

    }

     ?>
  </table>

  </body>
  </html>
