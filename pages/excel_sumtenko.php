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
  $strExcelFileName = "Summary_Tenko".$result_getDate['SYSDATE'].".xls";
} else {
  $strExcelFileName = "Summary_Tenko" . $result_getDate['SYSDATE'] . ".xls";
}




header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");


?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
  <br><br>
  <!-- ////////////////////////////////////////////////Charge 10///////////////////////////////////////////////// -->



  <html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  </head>
  <body>

    <table style="width: 100%;" >
      <tbody>
        <thead>
          <th style="width: 100%;" >
            <tr style="width: 100%;">
              <td  colspan="24" style="text-align:left;font-size:20px;"><b><u>แบบฟอร์ม Summary ใบTenko suppliers </u> &#160;&#160;&#160;&#160;&#160; Month :  <?= date(" F ")?></b></td>
            </tr>
          </th>
        </thead>
      </tbody>
    </table>
    <br>
    <table style="width: 100%;" >
      <tbody>
        <thead>
          <th>
            <tr style="width: 100%;">
              <td   colspan="5" style="padding:4px;width: 25%;text-align:left"><b>วันที่ Issue <?=$result_getDate['SYSDATE']?></b></td>
              <td   colspan="11" style="padding:4px;width: 30%;text-align:left"><b>ชื่อผู้รับผิดชอบSummary ข้อมูล <?=$_GET['name']?></b></td>
              <td   colspan="4" style="padding:4px;width: 30%;text-align:left"><b>เบอร์โทรศัพท์ <?=$result_seEmployee['Email']?></b></td>
              <td   colspan="4" style="padding:4px;width: 15%;text-align:left"><b>E-mail : <?=$result_seEmployee['Email']?></b></td>
            </tr>
          </th>
        </thead>
      </tbody>
    </table>
    <table id="bg-table"  style="width: 100%;border-collapse: collapse;font-size:9;margin-top:8px;">
      <tbody>
        <thead>
          <tr   style="border:1px solid #000;padding:4px;">
            <td   rowspan="2" colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10px"><b>No.</b></td>
            <td   rowspan="2" colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10px"><b>วันที่</b></td>
            <td   rowspan="2" colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10px"><b>รอบเวลาการจัดส่ง</b></td>
            <td   rowspan="2" colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10px"><b>ชื่อบริษัท</b></td>
            <td   rowspan="2" colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10px"><b>ชื่อ พนักงานขับรถ</b></td>
            <td   rowspan="2" colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10px"><b>ชื่อ ผู้ตรวจสอบความพร้อม</b></td>
            <td   colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10px"><b>จุดจัดส่ง</b></td>
            <td   colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10px"><b>ค่าความดัน</b></td>
            <td   colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10px"><b>การเต้นของหัวใจ</b></td>
            <td   colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10px"><b>ปริมาณแอลกอฮอล์</b></td>
            <td   colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10px"><b>ชั่วโมงพักผ่อน</b></td>
            <td   colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10px"><b>อุณหภูมิร่างกาย</b></td>
          </tr>
          <tr style="border:1px solid #000;">
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">AF</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">AE</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">WE</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">AAL03</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">IICS</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">supplier to supplier</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">(มาตรฐาน)ค่าการบีบตัว 90-140 mmHg</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">ผ่าน/ไม่ผ่าน</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">(มาตรฐาน)ค่าการคลายตัว 60-90 mmHg</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">ผ่าน/ไม่ผ่าน</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">(มาตรฐาน)60-100 ครั้ง/นาที</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">ผ่าน/ไม่ผ่าน</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">(มาตรฐาน) 0 mg%</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">ผ่าน/ไม่ผ่าน</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">(มาตรฐาน) 8 ชั่วโมง</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">ผ่าน/ไม่ผ่าน</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">(มาตรฐาน) ไม่เกิน 37.4 ° C</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">ผ่าน/ไม่ผ่าน</td>
          </tr>
        </thead>
      </tbody>
      <?php
      $i = 1;
      $sql_seBilling = "SELECT FORMAT (CONVERT(DATE,b.CREATEDATE,103),'dd-MM-yyyy') AS 'DATE',FORMAT (CONVERT(DATE,GETDATE(),103),'dd-MM-yyyy') AS 'SYSDATE'
                        ,a.JOBSTART,a.JOBEND2 ,b.TENKOMASTERDIRVERNAME AS 'NAME',b.TENKOBEFOREOFFICER AS 'OFFICER' ,b.TENKOPRESSUREDATA_60100 AS 'SBP'
                        ,b.TENKOPRESSUREDATA_90160 AS 'DBP',	 b.TENKOALCOHOLDATA AS 'ALCOHOL',b.TENKORESTDATA AS 'REST',b.TENKOTEMPERATUREDATA AS 'TEMP',b.TENKOPRESSUREDATA_60110 AS 'HEARTRATE'
                        FROM [dbo].[TENKOMASTER] a
                        INNER JOIN [dbo].[TENKOBEFORE]  b ON b.TENKOMASTERID = a.TENKOMASTERID
                        WHERE CONVERT(DATE,b.CREATEDATE) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
                        AND a.JOBEND2 IN ('Honda (Prajinburi)','Honda    (Prajinburi)','BJKC','BJKC + INGY','HONDA (Prachinburi)','INGY','NHK','NHK + CHI + TKT','SNA','TGT1 (Amatanakorn IE.)','TGT3 (Amatanakorn IE.)')
                        ORDER BY a.JOBEND2 ASC";
      $params_seBilling = array();

      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

        ?>



        <tr   style="border:1px solid #000;padding:4px;">
          <td    colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $i?></td>
          <td    colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seBilling['DATE']?></td>
          <td    colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
          <td    colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">RKS</td>
          <td    colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seBilling['NAME']?></td>
          <td    colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seBilling['OFFICER']?></td>
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>

          <!-- //// DBP -->
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seBilling['DBP']?></td>
          <?php
          if ($result_seBilling['DBP'] < 90 || $result_seBilling['DBP'] > 140) {
            ?>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:70%;font-weight:bold;">&#x2716;</td>
            <?php

          }else {
            ?>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:70%;font-weight:bold;">&#x2714;</td>
            <?php
          }
          ?>

          <!-- //// SBP -->
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seBilling['SBP']?></td>

          <?php
          if ($result_seBilling['SBP'] < 60 || $result_seBilling['SBP'] > 90) {
            ?>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:70%;font-weight:bold;">&#x2716;</td>
            <?php

          }else {
            ?>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:70%;font-weight:bold;">&#x2714;</td>
            <?php
          }
          ?>

          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seBilling['HEARTRATE']?></td>
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:70%;font-weight:bold;">&#x2714;</td>


          <!-- //// SBP -->
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seBilling['ALCOHOL']?></td>
          <?php
          if ($result_seBilling['ALCOHOL'] > 0) {
            ?>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:70%;font-weight:bold;">&#x2716;</td>
            <?php

          }else {
            ?>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:70%;font-weight:bold;">&#x2714;</td>
            <?php
          }
          ?>

          <!-- //// REST -->
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seBilling['REST']?></td>
          <?php
          if ($result_seBilling['REST'] < 8) {
            ?>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:70%;font-weight:bold;">&#x2716;</td>
            <?php

          }else {
            ?>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:70%;font-weight:bold;">&#x2714;</td>
            <?php
          }
          ?>

          <!-- //// TEMP -->
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seBilling['TEMP']?></td>
          <?php
          if ($result_seBilling['TEMP'] > 37.4) {
            ?>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:70%;font-weight:bold;">&#x2716;</td>
            <?php

          }else {
            ?>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:70%;font-weight:bold;">&#x2714;</td>
            <?php
          }
          ?>
        </tr>
        <!-- /// 2716 X mark -->


        <?php
        $i++;

      }

      ?>

    </tbody><tfoot>
      <tr style="border:1px solid #000;">
        <td colspan="24" style="border-right:1px solid #000;padding:4px;text-align:left;font-size:15px;"><b>Remark : กรณีมีข้อสงสัยเรื่องการกรอข้อมูลกรุณาติดต่อ คุณ นันทวรรณ นาควรสุข Tel:095-367 2248 , E-mail : nantanak@honda.th.com</b></td>

      </tr>
    </tfoot>


  </table>

</body>
</html>
