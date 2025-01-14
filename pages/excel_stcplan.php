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


$strExcelFileName = "แผนประจำวัน STC".$result_getDate['SYSDATE'].".xls";
//
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");


?>
<style>
input.largerCheckbox {
  width: 20px;
  height: 20px;
}
</style>

<!-- ////////////////////////////////////////////////10W/STC///////////////////////////////////////////////// -->

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
  <br>
  <table   style="border-collapse: collapse;margin-top:8px;font-size:10px" width="100%"  >
    <tr>
      <th rowspan="2" colspan="1" style="border-left:1px solid #000;border-top:1px solid #000;padding:10px;text-align:left">Plan ประจำวันที่</th>
      <th rowspan="2" colspan="2" style="border-top:1px solid #000;text-align:left"></th>
      <th rowspan="2" colspan="3" style="border-top:1px solid #000;text-align:left">3 ธันวาคม 2562</th>
      <th rowspan="2" colspan="2" style="border-top:1px solid #000;text-align:left"></th>
      <th rowspan="2" colspan="2" style="border-top:1px solid #000;text-align:left"></th>
      <th rowspan="2" colspan="8" style="border-top:1px solid #000;text-align:left"></th>
      <th rowspan="2" colspan="4" style="border-top:1px solid #000;text-align:left">Master</th>
      <th rowspan="2" colspan="1" style="border-top:1px solid #000;border-right:1px solid #000;text-align:left">Weeranop</th>

    </tr>
<tr>

</tr>
    <tr>
      <th colspan="6"  style="border:1px solid #000;border-top:1px solid #000;padding:10px;text-align:left"></th>

      <th colspan="2"  style="border:1px solid #000;text-align:center">Trip 1</th>

      <th colspan="2"  style="border:1px solid #000;text-align:center">Trip 2</th>

      <th colspan="2"  style="border:1px solid #000;text-align:center">Trip 3</th>

      <th colspan="2"  style="border:1px solid #000;text-align:center">Trip 4</th>

      <th colspan="2"  style="border:1px solid #000;text-align:center">Trip 5</th>

      <th colspan="2"  style="border:1px solid #000;text-align:center">Trip 6</th>

      <th colspan="4"  style="border:1px solid #000;text-align:left"></th>
      <th colspan="1"  style="border:1px solid #000;border-right:1px solid #000;text-align:left"></th>




    </tr>


    <tr>
      <td colspan="1"   bgcolor="#DCE6F1" style="border:1px solid #000;padding:10px;text-align:left">NO</td>

      <td colspan="1"   bgcolor="#DCE6F1" style="border:1px solid #000;padding:4px;text-align:left">DRIVER</td>
      <td colspan="1"   bgcolor="#DCE6F1" style="border:1px solid #000;padding:4px;text-align:left">TRUCK</td>
      <td colspan="1"   bgcolor="#DCE6F1" style="border:1px solid #000;padding:4px;text-align:left">ประเภท</td>
      <td colspan="1"   bgcolor="#DCE6F1" style="border:1px solid #000;padding:4px;text-align:left">เวลารายงานตัว</td>
      <td colspan="1"   bgcolor="#DCE6F1" style="border:1px solid #000;padding:4px;text-align:left">ออกจาก RK</td>

      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:left">ถึงต้นทาง</td>
      <td colspan="1"   bgcolor="#DCE6F1" style="border:1px solid #000;padding:4px;text-align:left">ชื่อลูกค้าTrip 1</td>

      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:left">ถึงต้นทาง</td>
      <td colspan="1"   bgcolor="#DCE6F1" style="border:1px solid #000;padding:4px;text-align:left">ชื่อลูกค้าTrip 2</td>

      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:left">ถึงต้นทาง</td>
      <td colspan="1"   bgcolor="#DCE6F1" style="border:1px solid #000;padding:4px;text-align:left">ชื่อลูกค้าTrip 3</td>

      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:left">ถึงต้นทาง</td>
      <td colspan="1"   bgcolor="#DCE6F1" style="border:1px solid #000;padding:4px;text-align:left">ชื่อลูกค้าTrip 4</td>

      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:left">ถึงต้นทาง</td>
      <td colspan="1"   bgcolor="#DCE6F1" style="border:1px solid #000;padding:4px;text-align:left">ชื่อลูกค้าTrip 5</td>

      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:left">ถึงต้นทาง</td>
      <td colspan="1"   bgcolor="#DCE6F1" style="border:1px solid #000;padding:4px;text-align:left">ชื่อลูกค้าTrip 6</td>

      <td colspan="1"   bgcolor="#DCE6F1" style="border:1px solid #000;padding:4px;text-align:left">ออกปลายทาง</td>

      <td colspan="1"   bgcolor="#DCE6F1" style="border:1px solid #000;padding:4px;text-align:left">เวลากลับ</td>
      <td colspan="1"   bgcolor="#DCE6F1" style="border:1px solid #000;padding:4px;text-align:left">เวลารายงานตัววันถัดไป</td>
      <td colspan="1"   style="border:1px solid #000;padding:4px;text-align:left">Memory Card(ส่ง)</td>


      <td colspan="1"   bgcolor="#DCE6F1" style="border:1px solid #000;padding:4px;text-align:left">Remark</td>


    </tr>
    <tr>
      <td colspan="23"  style="border:1px solid #000;padding:4px;text-align:left"><u><b>10W/STC<b></u></td>
      </tr>

      <?php

      $i = 1;
      $sql_seBilling = "SELECT  EMPLOYEENAME1,THAINAME,VEHICLETYPE,JOBSTART,JOBEND,
                      CONVERT(VARCHAR(8),DATEPRESENT,108) AS 'DATEPRESENT',CONVERT(VARCHAR(8),DATERK,108) AS 'DATERK',
                      CONVERT(VARCHAR(8),DATEVLIN,108) AS 'DATEVLIN',CONVERT(VARCHAR(8),DATEDEALERIN,108) AS 'DATEDEALERIN',
                      CONVERT(VARCHAR(8),DATERETURN,108) AS 'DATERETURN'
                      FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1
                      AND COMPANYCODE='RKR' AND CUSTOMERCODE='TTASTSTC'
                      AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart'] ."',103) AND CONVERT(DATE,'".$_GET['dateend'] ."',103)
                      ORDER BY EMPLOYEENAME1 ASC";
      $params_seBilling = array();

      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

        // echo $jobend=$result_seBilling['JOBEND']; echo '<br>';
        $jobend  = $result_seBilling['JOBEND'];
        $jobendsplit = explode(",", $jobend);
        // echo $jobendsplit[0]; echo '<br>';
        // echo $jobendsplit[1]; echo '<br>';
        // echo $jobendsplit[2]; echo '<br>';
        // echo $jobendsplit[3]; echo '<br>';
       ?>
      <tr>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=$i?></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling['EMPLOYEENAME1']?></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['THAINAME']?></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['VEHICLETYPE']?></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling['DATEPRESENT']?></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling['DATERK']?></td>

        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling['DATEVLIN']?></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$jobendsplit[0];?></td>

        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling['DATEDEALERIN']?></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$jobendsplit[1];?></td>

        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$jobendsplit[2];?></td>

        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$jobendsplit[3];?></td>

        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$jobendsplit[4];?></td>

        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>

        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling['DATERETURN']?></td>

        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>


        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>


      </tr>
      <?php
      $i++;

      }

       ?>


      <!-- /////////////////////////////////////////TL/STC//////////////////////// -->
      <tr>
        <td colspan="23"  style="border:1px solid #000;padding:4px;text-align:left"><u><b>TL/STC<b></u></td>
      </tr>
      <?php

      $i1 = 1;
      $sql_seBilling1 = "SELECT  EMPLOYEENAME1,THAINAME,VEHICLETYPE,JOBSTART,JOBEND,
                        CONVERT(VARCHAR(8),DATEPRESENT,108) AS 'DATEPRESENT',CONVERT(VARCHAR(8),DATERK,108) AS 'DATERK',
                        CONVERT(VARCHAR(8),DATEVLIN,108) AS 'DATEVLIN',CONVERT(VARCHAR(8),DATEDEALERIN,108) AS 'DATEDEALERIN',
                        CONVERT(VARCHAR(8),DATERETURN,108) AS 'DATERETURN'
                        FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1
                        AND COMPANYCODE='RKL' AND CUSTOMERCODE='TTASTSTC'
                        AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart'] ."',103) AND CONVERT(DATE,'".$_GET['dateend'] ."',103)
                        ORDER BY EMPLOYEENAME1 ASC";
      $params_seBilling1 = array();

      $query_seBilling1 = sqlsrv_query($conn, $sql_seBilling1, $params_seBilling1);
      while ($result_seBilling1 = sqlsrv_fetch_array($query_seBilling1, SQLSRV_FETCH_ASSOC)) {

        // echo $jobend=$result_seBilling['JOBEND']; echo '<br>';
        $jobend1  = $result_seBilling1['JOBEND'];
        $jobendsplit1 = explode(",", $jobend1);
        // echo $jobendsplit[0]; echo '<br>';
        // echo $jobendsplit[1]; echo '<br>';
        // echo $jobendsplit[2]; echo '<br>';
        // echo $jobendsplit[3]; echo '<br>';
       ?>
      <tr>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=$i1?></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling1['EMPLOYEENAME1']?></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling1['THAINAME']?></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling1['VEHICLETYPE']?></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling1['DATEPRESENT']?></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling1['DATERK']?></td>

        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling1['DATEVLIN']?></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$jobendsplit1[0];?></td>

        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling1['DATEDEALERIN']?></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$jobendsplit1[1];?></td>

        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$jobendsplit1[2];?></td>

        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$jobendsplit1[3];?></td>

        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$jobendsplit1[4];?></td>

        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>

        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling1['DATERETURN']?></td>

        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>


        <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>


      </tr>
      <?php
      $i1++;

      }

       ?>
        <!-- ///////////////////////////////////////////////TTAST////////////////////////////// -->
        <tr>
          <td colspan="23"  style="border:1px solid #000;padding:4px;text-align:left"><u><b>TTAST<b></u></td>
        </tr>

        <?php

        $i2= 1;
        $i3= 1;
        $sql_seBilling2 = "SELECT  EMPLOYEENAME1,THAINAME,VEHICLETYPE,JOBSTART,JOBEND,
                            CONVERT(VARCHAR(8),DATEPRESENT,108) AS 'DATEPRESENT',CONVERT(VARCHAR(8),DATERK,108) AS 'DATERK',
                            CONVERT(VARCHAR(8),DATEVLIN,108) AS 'DATEVLIN',CONVERT(VARCHAR(8),DATEDEALERIN,108) AS 'DATEDEALERIN',
                            CONVERT(VARCHAR(8),DATERETURN,108) AS 'DATERETURN'
                            FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1
                            AND COMPANYCODE='RKR' AND CUSTOMERCODE='TTTCSTC'
                            AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart'] ."',103) AND CONVERT(DATE,'".$_GET['dateend'] ."',103)
                            ORDER BY EMPLOYEENAME1 ASC";
        $params_seBilling2 = array();


        $query_seBilling2 = sqlsrv_query($conn, $sql_seBilling2, $params_seBilling2);
        while ($result_seBilling2 = sqlsrv_fetch_array($query_seBilling2, SQLSRV_FETCH_ASSOC)) {

          // echo $jobend=$result_seBilling['JOBEND']; echo '<br>';
          $jobend2  = $result_seBilling2['JOBEND'];
          $jobendsplit2 = explode(",", $jobend2);
          // echo $jobendsplit[0]; echo '<br>';
          // echo $jobendsplit[1]; echo '<br>';
          // echo $jobendsplit[2]; echo '<br>';
          // echo $jobendsplit[3]; echo '<br>';


         ?>
        <tr>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=$i2?></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling2['EMPLOYEENAME1']?></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling2['THAINAME']?></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling2['VEHICLETYPE']?></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling2['DATEPRESENT']?></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling2['DATERK']?></td>

          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling2['DATEVLIN']?></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$jobendsplit2[0];?></td>

          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling2['DATEDEALERIN']?></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$jobendsplit2[1];?></td>

          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$jobendsplit2[2];?></td>

          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$jobendsplit2[3];?></td>

          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$jobendsplit2[4];?></td>

          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>

          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling2['DATERETURN']?></td>

          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>


          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>


        </tr>
        <?php
        $i2++;
          }
        ?>
          <?php
          $sql_seBilling3 = "SELECT  EMPLOYEENAME1,THAINAME,VEHICLETYPE,JOBSTART,JOBEND,
                          CONVERT(VARCHAR(8),DATEPRESENT,108) AS 'DATEPRESENT',CONVERT(VARCHAR(8),DATERK,108) AS 'DATERK',
                          CONVERT(VARCHAR(8),DATEVLIN,108) AS 'DATEVLIN',CONVERT(VARCHAR(8),DATEDEALERIN,108) AS 'DATEDEALERIN',
                          CONVERT(VARCHAR(8),DATERETURN,108) AS 'DATERETURN'
                          FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1
                          AND COMPANYCODE='RKR' AND CUSTOMERCODE='TTTC'
                          AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart'] ."',103) AND CONVERT(DATE,'".$_GET['dateend'] ."',103)
                          ORDER BY EMPLOYEENAME1 ASC";
          $params_seBilling3 = array();

          $query_seBilling3 = sqlsrv_query($conn, $sql_seBilling3, $params_seBilling3);
          while ($result_seBilling3 = sqlsrv_fetch_array($query_seBilling3, SQLSRV_FETCH_ASSOC)) {

            // echo $jobend=$result_seBilling['JOBEND']; echo '<br>';
            $jobend3  = $result_seBilling3['JOBEND'];
            $jobendsplit3 = explode(",", $jobend3);
            // echo $jobendsplit[0]; echo '<br>';
            // echo $jobendsplit[1]; echo '<br>';
            // echo $jobendsplit[2]; echo '<br>';
            // echo $jobendsplit[3]; echo '<br>';

           ?>
        <tr>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=$i2?></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling3['EMPLOYEENAME1']?></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling3['THAINAME']?></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling3['VEHICLETYPE']?></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling3['DATEPRESENT']?></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling3['DATERK']?></td>

          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling3['DATEVLIN']?></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$jobendsplit3[0];?></td>

          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling3['DATEDEALERIN']?></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$jobendsplit3[1];?></td>

          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$jobendsplit3[2];?></td>

          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$jobendsplit3[3];?></td>

          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$jobendsplit3[4];?></td>

          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>

          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling3['DATERETURN']?></td>

          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>


          <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>

        </tr>
        <?php
        $i2++;
          }
        ?>

<!-- ///////////////////////////////////////// CS //////////////////////// -->
              <tr>
                <td colspan="23"  style="border:1px solid #000;padding:4px;text-align:left"><u><b>CS<b></u></td>
              </tr>
              <?php

              $i4 = 1;
              $sql_seBilling4 = "SELECT  EMPLOYEENAME1,THAINAME,VEHICLETYPE,JOBSTART,JOBEND,
                                  CONVERT(VARCHAR(8),DATEPRESENT,108) AS 'DATEPRESENT',CONVERT(VARCHAR(8),DATERK,108) AS 'DATERK',
                                  CONVERT(VARCHAR(8),DATEVLIN,108) AS 'DATEVLIN',CONVERT(VARCHAR(8),DATEDEALERIN,108) AS 'DATEDEALERIN',
                                  CONVERT(VARCHAR(8),DATERETURN,108) AS 'DATERETURN'
                                  FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1
                                  AND COMPANYCODE='RKR' AND CUSTOMERCODE='TTASTCS'
                                  AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart'] ."',103) AND CONVERT(DATE,'".$_GET['dateend'] ."',103)
                                  ORDER BY EMPLOYEENAME1 ASC ";
              $params_seBilling4 = array();

              $query_seBilling4 = sqlsrv_query($conn, $sql_seBilling4, $params_seBilling4);
              while ($result_seBilling4 = sqlsrv_fetch_array($query_seBilling4, SQLSRV_FETCH_ASSOC)) {

                // echo $jobend=$result_seBilling['JOBEND']; echo '<br>';
                $jobend4  = $result_seBilling4['JOBEND'];
                $jobendsplit4 = explode(",", $jobend4);
                // $jobendsplit41 = explode(":", $jobendsplit4);
                // echo $jobendsplit4[0]; echo '<br>';
                // echo $jobendsplit4[1]; echo '<br>';
                // echo $jobendsplit4[2]; echo '<br>';
                // echo $jobendsplit4[3]; echo '<br>';

                $st1 = $jobendsplit4[0];
                list($a1) = explode(':',$st1);
                $st2 = $jobendsplit4[1];
                list($a2) = explode(':',$st2);
                $st3 = $jobendsplit4[2];
                list($a3) = explode(':',$st3);
                $st4 = $jobendsplit4[3];
                list($a4) = explode(':',$st4);
                $st5 = $jobendsplit4[4];
                list($a5) = explode(':',$st5);
                // echo $a1."<br>";
                // echo $a2."<br>";
                // echo $a3."<br>";
                // echo $a4."<br>";
                // echo $a5."<br>";
               ?>
              <tr>
                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=$i4?></td>
                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling4['EMPLOYEENAME1']?></td>
                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling4['THAINAME']?></td>
                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling4['VEHICLETYPE']?></td>
                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling4['DATEPRESENT']?></td>
                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling4['DATERK']?></td>

                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling4['DATEVLIN']?></td>
                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$a1?></td>

                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling4['DATEDEALERIN']?></td>
                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$a2?></td>

                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$a3?></td>

                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$a4?></td>

                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$a4?></td>

                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>

                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling4['DATERETURN']?></td>

                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>
                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>


                <td colspan="1"  style="border:1px solid #000;padding:4px;text-align:left"></td>


              </tr>
              <?php
              $i4++;

              }

               ?>

          </table>
        </body>
        </html>
