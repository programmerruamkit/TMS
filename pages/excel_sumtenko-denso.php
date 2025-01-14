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
  $strExcelFileName = "Summary_Tenko(DENSO)".$result_getDate['SYSDATE'].".xls";
} else {
  $strExcelFileName = "Summary_Tenko(DENSO)" . $result_getDate['SYSDATE'] . ".xls";
}

$condition1 = "  AND a.PersonCode = '" . $_GET["id"] . "'";
$sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmployee = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
$result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);



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
  <!-- ////////////////////////////////////////////////HEADER///////////////////////////////////////////////// -->



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
              <td   colspan="5" style="padding:4px;width: 30%;text-align:left"><b>ชื่อผู้รับผิดชอบSummary ข้อมูล <?=$result_seEmployee['nameT']?></b></td>
              <td   colspan="4" style="padding:4px;width: 30%;text-align:left"><b>เบอร์โทรศัพท์ <?=$result_seEmployee['Tel']?></b></td>
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
            <td   colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10px"><b>ค่าความดัน</b></td>
            <td   colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10px"><b>การเต้นของหัวใจ</b></td>
            <td   colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10px"><b>ปริมาณแอลกอฮอล์</b></td>
            <td   colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10px"><b>ชั่วโมงพักผ่อน</b></td>
            <td   colspan="2" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10px"><b>อุณหภูมิร่างกาย</b></td>
          </tr>
          <tr style="border:1px solid #000;">
            <!-- <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">AF</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">AE</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">WE</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">AAL03</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">IICS</td>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">supplier to supplier</td> -->
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

      $sql_seSumTenko = "SELECT FORMAT (CONVERT(DATE,b.CREATEDATE,103),'dd-MM-yyyy') AS 'DATE',FORMAT (CONVERT(DATE,GETDATE(),103),'dd-MM-yyyy') AS 'SYSDATE'
                  ,a.JOBSTART,a.JOBEND2 ,b.TENKOMASTERDIRVERNAME AS 'NAME',b.TENKOBEFOREOFFICER AS 'OFFICER' ,b.TENKOPRESSUREDATA_60100 AS 'SBP'
                  ,b.TENKOPRESSUREDATA_90160 AS 'DBP',	 b.TENKOALCOHOLDATA AS 'ALCOHOL',b.TENKORESTDATA AS 'REST',b.TENKOTEMPERATUREDATA AS 'TEMP'
                  ,b.TENKOPRESSUREDATA_60110 AS 'HEARTRATE',c.VEHICLETRANSPORTPLANID,a.TENKOMASTERID,c.JOBNO
                  FROM [dbo].[TENKOMASTER] a
                  INNER JOIN [dbo].[TENKOBEFORE]  b ON b.TENKOMASTERID = a.TENKOMASTERID
                  INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON c.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
                  WHERE 1=1
                  AND CONVERT(DATE,c.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
                  AND c.JOBSTART IN ('DM-021','DM-022')
                  --AND b.TENKOMASTERID = '1513055'
                  ORDER BY c.DATEWORKING ASC";
      $params_seSumTenko = array();
      $query_seSumTenko = sqlsrv_query($conn, $sql_seSumTenko, $params_seSumTenko);
      while ($result_seSumTenko = sqlsrv_fetch_array($query_seSumTenko, SQLSRV_FETCH_ASSOC)){


        ?>



        <tr   style="border:1px solid #000;padding:4px;">
          <td    colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?= $i?></td>
          <td    colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seSumTenko['DATE']?></td>
          <td    colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
          <td    colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;">RKS</td>
          <td    colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seSumTenko['NAME']?></td>
          <td    colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seSumTenko['OFFICER']?></td>
          <!-- <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"></td> -->


          <!-- //// DBP  ค่าความดันโลหิตสูงที่สุดเมื่อบีบตัว-->
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seSumTenko['DBP']?></td>
          <?php
          if ($result_seSumTenko['DBP'] < 90 || $result_seSumTenko['DBP'] > 140) {
            ?>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:70%;font-weight:bold;">&#x2716;</td>
            <?php

          }else {
            ?>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:70%;font-weight:bold;">&#x2714;</td>
            <?php
          }
          ?>

          <!-- //// SBP ค่าความดันโลหิตต่ำที่สุดเมื่อบีบตัว-->
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seSumTenko['SBP']?></td>

          <?php
          if ($result_seSumTenko['SBP'] < 60 || $result_seSumTenko['SBP'] > 90) {
            ?>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:70%;font-weight:bold;">&#x2716;</td>
            <?php

          }else {
            ?>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:70%;font-weight:bold;">&#x2714;</td>
            <?php
          }
          ?>

          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seSumTenko['HEARTRATE']?></td>
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:70%;font-weight:bold;">&#x2714;</td>


          <!-- //// SBP -->
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seSumTenko['ALCOHOL']?></td>
          <?php
          if ($result_seSumTenko['ALCOHOL'] > 0) {
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
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=$result_seSumTenko['REST']?></td>
          <?php
          if ($result_seSumTenko['REST'] < 8) {
            ?>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:70%;font-weight:bold;">&#x2716;</td>
            <?php

          }else {
            ?>
            <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;font-size:70%;font-weight:bold;">&#x2714;</td>
            <?php
          }
          ?>

          <!-- ////TEMPS-->
          <td  colspan="1" style="border-right:1px solid #000;padding:4px;text-align:center;"><?=number_format($result_seSumTenko['TEMP'],2) ?></td>
          <?php
          if ($result_seSumTenko['TEMP'] > 37.4) {
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
      <!-- <tr style="border:1px solid #000;">
        <td colspan="24" style="border-right:1px solid #000;padding:4px;text-align:left;font-size:15px;"><b>Remark : กรณีมีข้อสงสัยเรื่องการกรอข้อมูลกรุณาติดต่อ คุณ นันทวรรณ นาควรสุข Tel:095-367 2248 , E-mail : nantanak@honda.th.com</b></td>

      </tr> -->
      <tr style="border:1px solid #000;">
        <td colspan="18" style="border-right:1px solid #000;padding:8px;text-align:left;font-size:15px;"></td>

      </tr>
    </tfoot>


  </table>

</body>
</html>
