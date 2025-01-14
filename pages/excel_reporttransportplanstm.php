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


$strExcelFileName = "แผนประจำวัน STM".$result_getDate['SYSDATE'].".xls";
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

<!-- ////////////////////////////////////////////////10W/STC///////////////////////////////////////////////// -->

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
  <br>
  <table   style="border-collapse: collapse;margin-top:8px;font-size:10px" width="100%"  >
    <tr>

      <th colspan="17" bgcolor="#B7DEE8" style="border-top:1px solid #000;font-size:14px;border:1px solid #000;padding:6px;text-align:center">
        <b>แผนงานการบริหารขนส่ง STM (STM-TMT/SR)</b> <br>
        <b> 3 DEC'19</b> <br>
        <b>TMT-Samrong 10 W <b>
      </th>

    </tr>
<tr>

</tr>
    <tr>

      <td colspan="1"  bgcolor="#D9D9D9" rowspan="2"  style="border:1px solid #000;padding:4px;text-align:center">ลำดับที่</td>
      <td colspan="1"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">เวลา</td>
      <td colspan="2"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">LOAD</td>
      <td colspan="1"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">เวลา</td>
      <td colspan="2"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">ค่าทางด่วนบูรพาวิถี</td>
      <td colspan="1"  bgcolor="#D9D9D9" rowspan="2"  style="border:1px solid #000;padding:4px;text-align:center">ประเภทรถ</td>
      <td colspan="1"  bgcolor="#D9D9D9" rowspan="2"  style="border:1px solid #000;padding:4px;text-align:center">ทะเบียน</td>
      <td colspan="1"  bgcolor="#D9D9D9" rowspan="2"  style="border:1px solid #000;padding:4px;text-align:center">หมายเลขรถ</td>
      <td colspan="2"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">DAY</td>
      <td colspan="2"  bgcolor="#D9D9D9" rowspan="2" style="border:1px solid #000;padding:4px;text-align:center">โทรศัทพ์</td>
      <td colspan="2"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">Memory Card</td>
      <td colspan="1"  bgcolor="#D9D9D9" rowspan="2"  style="border:1px solid #000;padding:4px;text-align:center">ลงชื่อ</td>

      <!-- //////////////////////////////SECTION 2/////////////////////////////////////////////////// -->


    <tr>
      <td colspan="1"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">รายงานตัว</td>
      <td colspan="1"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">เที่ยว</td>
      <td colspan="1"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">รอบส่ง</td>
      <td colspan="1"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">กลับ</td>
      <td colspan="1"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">ไป</td>
      <td colspan="1"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">กลับ</td>
      <td colspan="2"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">DRIVER</td>
      <td colspan="1"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">รับ</td>
      <td colspan="1"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">ส่ง</td>

    </tr>

<!-- //////////////////////////////////////BODY///////////////////////////////////////////// -->
<?php
$i=1;

$sql_seBilling = "SELECT CONVERT(VARCHAR(8),a.DATEPRESENT,108) AS 'TIMEPRESENT',
                  CONVERT(NVARCHAR(4),a.ROUNDAMOUNT) AS 'ROUNDS',LEFT(a.ROUNDAMOUNT,PATINDEX('%[^0-9]%',a.ROUNDAMOUNT)-1) AS 'Numerics',
                  CONVERT(VARCHAR(8),a.DATERETURN,108) AS 'TIMERETURN',
                  a.VEHICLETYPE AS 'VEHICLETYPE',a.THAINAME AS 'THAINAME', a.EMPLOYEECODE1 AS 'EMPCODE',a.EMPLOYEENAME1 AS 'EMPNAME',b.CurrentTel AS 'TEL'
                  FROM [dbo].[VEHICLETRANSPORTPLAN] a
                  INNER JOIN [dbo].[EMPLOYEEEHR] b ON b.PersonCode = a.EMPLOYEECODE1
                  WHERE COMPANYCODE='RKS' AND CUSTOMERCODE='TMT'
                  AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
                  AND ROUNDAMOUNT LIKE '%D' ORDER BY LEN(LEFT(a.ROUNDAMOUNT,PATINDEX('%[^0-9]%',a.ROUNDAMOUNT)-1)),Numerics ASC";
$params_seBilling = array();
$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);


while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

 ?>


    <tr>
        <?php
        if ($result_seBilling['VEHICLETYPE'] == '6W') {
        ?>
        <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"><?=$i?></td>
        <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['TIMEPRESENT']?></td>
        <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['ROUNDS']?></td>
        <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"></td>
        <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['TIMERETURN']?></td>
        <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"></td>
        <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"></td>
        <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['VEHICLETYPE']?></td>
        <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['THAINAME']?></td>
        <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"></td>
        <td colspan="2"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling['EMPNAME']?></td>
        <td colspan="2"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['TEL']?></td>
        <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['']?></td>
        <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['']?></td>
        <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['']?></td>
        <?php
        }else {
        ?>
        <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"><?=$i?></td>
        <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['TIMEPRESENT']?></td>
        <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['ROUNDS']?></td>
        <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['']?></td>
        <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['TIMERETURN']?></td>
        <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"></td>
        <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"></td>
        <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['VEHICLETYPE']?></td>
        <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['THAINAME']?></td>
        <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"></td>
        <td colspan="2"    style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling['EMPNAME']?></td>
        <td colspan="2"    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['TEL']?></td>
        <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"></td>
        <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"></td>
        <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"></td>
        <?php
        }
        ?>

    </tr>
<?php
$i++;
}
 ?>

<!-- //////////////////////////////////////NIGHT//////////////////////////////////////////// -->
<tr>

  <td colspan="1"  bgcolor="#D9D9D9" rowspan="2"  style="border:1px solid #000;padding:4px;text-align:center">ลำดับที่</td>
  <td colspan="1"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">เวลา</td>
  <td colspan="2"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">LOAD</td>
  <td colspan="1"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">เวลา</td>
  <td colspan="2"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">ค่าทางด่วนบูรพาวิถี</td>
  <td colspan="1"  bgcolor="#D9D9D9" rowspan="2"  style="border:1px solid #000;padding:4px;text-align:center">ประเภทรถ</td>
  <td colspan="1"  bgcolor="#D9D9D9" rowspan="2"  style="border:1px solid #000;padding:4px;text-align:center">ทะเบียน</td>
  <td colspan="1"  bgcolor="#D9D9D9" rowspan="2"  style="border:1px solid #000;padding:4px;text-align:center">หมายเลขรถ</td>
  <td colspan="2"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">NIGHT</td>
  <td colspan="2"  bgcolor="#D9D9D9" rowspan="2" style="border:1px solid #000;padding:4px;text-align:center">โทรศัทพ์</td>
  <td colspan="2"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">Memory Card</td>
  <td colspan="1"  bgcolor="#D9D9D9" rowspan="2"  style="border:1px solid #000;padding:4px;text-align:center">ลงชื่อ</td>

  <!-- //////////////////////////////SECTION 2/////////////////////////////////////////////////// -->


<tr>
  <td colspan="1"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">รายงานตัว</td>
  <td colspan="1"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">เที่ยว</td>
  <td colspan="1"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">รอบส่ง</td>
  <td colspan="1"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">กลับ</td>
  <td colspan="1"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">ไป</td>
  <td colspan="1"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">กลับ</td>
  <td colspan="2"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">DRIVER</td>
  <td colspan="1"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">รับ</td>
  <td colspan="1"  bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">ส่ง</td>

</tr>

<!-- //////////////////////////////////////BODY///////////////////////////////////////////// -->
<?php
$i=1;

$sql_seBilling = "SELECT CONVERT(VARCHAR(8),a.DATEPRESENT,108) AS 'TIMEPRESENT',
              CONVERT(NVARCHAR(4),a.ROUNDAMOUNT) AS 'ROUNDS',LEFT(a.ROUNDAMOUNT,PATINDEX('%[^0-9]%',a.ROUNDAMOUNT)-1) AS 'Numerics',
              CONVERT(VARCHAR(8),a.DATERETURN,108) AS 'TIMERETURN',
              a.VEHICLETYPE AS 'VEHICLETYPE',a.THAINAME AS 'THAINAME', a.EMPLOYEECODE1 AS 'EMPCODE',a.EMPLOYEENAME1 AS 'EMPNAME',b.CurrentTel AS 'TEL'
              FROM [dbo].[VEHICLETRANSPORTPLAN] a
              INNER JOIN [dbo].[EMPLOYEEEHR] b ON b.PersonCode = a.EMPLOYEECODE1
              WHERE COMPANYCODE='RKS' AND CUSTOMERCODE='TMT'
              AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
              AND ROUNDAMOUNT LIKE '%N' ORDER BY LEN(LEFT(a.ROUNDAMOUNT,PATINDEX('%[^0-9]%',a.ROUNDAMOUNT)-1)),Numerics ASC";
$params_seBilling = array();
$query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);


while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {

?>

<tr>
    <?php
    if ($result_seBilling['VEHICLETYPE'] == '6W') {
    ?>
    <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"><?=$i?></td>
    <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['TIMEPRESENT']?></td>
    <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['ROUNDS']?></td>
    <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"></td>
    <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['TIMERETURN']?></td>
    <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"></td>
    <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"></td>
    <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['VEHICLETYPE']?></td>
    <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['THAINAME']?></td>
    <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"></td>
    <td colspan="2"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling['EMPNAME']?></td>
    <td colspan="2"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['TEL']?></td>
    <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['']?></td>
    <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['']?></td>
    <td colspan="1"  bgcolor="#92D050"  style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['']?></td>
    <?php
    }else {
    ?>
    <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"><?=$i?></td>
    <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['TIMEPRESENT']?></td>
    <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['ROUNDS']?></td>
    <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['']?></td>
    <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['TIMERETURN']?></td>
    <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"></td>
    <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"></td>
    <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['VEHICLETYPE']?></td>
    <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['THAINAME']?></td>
    <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"></td>
    <td colspan="2"    style="border:1px solid #000;padding:4px;text-align:left"><?=$result_seBilling['EMPNAME']?></td>
    <td colspan="2"    style="border:1px solid #000;padding:4px;text-align:center"><?=$result_seBilling['TEL']?></td>
    <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"></td>
    <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"></td>
    <td colspan="1"    style="border:1px solid #000;padding:4px;text-align:center"></td>
    <?php
    }
    ?>

</tr>
<?php
$i++;
}
?>



<tfoot>
  <tr>

    <td colspan="1"  bgcolor="#FCD5B4" rowspan="2"  style="border:1px solid #000;padding:10px;text-align:center">1</td>
    <td colspan="1"  bgcolor="#FCD5B4"   style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="1"  bgcolor="#FCD5B4"   style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="1"  bgcolor="#FCD5B4"   style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="1"  bgcolor="#FCD5B4"   style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="1"  bgcolor="#FCD5B4"   style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="1"  bgcolor="#FCD5B4"   style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="1"  bgcolor="#FCD5B4"   style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="1"  bgcolor="#FCD5B4"   style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="1"  bgcolor="#FCD5B4"  style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="2"  bgcolor="#FCD5B4"  style="border:1px solid #000;padding:5px;text-align:center"> </td>
    <td colspan="2"  bgcolor="#FCD5B4"  style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="3"  bgcolor="#FCD5B4"  style="border:1px solid #000;padding:5px;text-align:center"></td>


  </tr>
    <td colspan="1"   bgcolor="#FCD5B4" style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="1"   bgcolor="#FCD5B4" style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="1"   bgcolor="#FCD5B4" style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="1"   bgcolor="#FCD5B4" style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="1"   bgcolor="#FCD5B4" style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="1"   bgcolor="#FCD5B4" style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="1"   bgcolor="#FCD5B4" style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="1"   bgcolor="#FCD5B4" style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="1"   bgcolor="#FCD5B4" style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="2"   bgcolor="#FCD5B4" style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="2"   bgcolor="#FCD5B4" style="border:1px solid #000;padding:5px;text-align:center"></td>
    <td colspan="3"   bgcolor="#FCD5B4" style="border:1px solid #000;padding:5px;text-align:center"></td>
  </tr>

<tr>
  <td colspan="14"   bgcolor="#FFFF00" style="border:1px solid #000;padding:3px;text-align:left">รอบที่ 1,2 :รถต้องกลับมาโหลดงานค้างสามารถเบิกค่าทางด่วนได้</td>
  <td colspan="3"    bgcolor="#FFFF00" style="border:1px solid #000;padding:3px;text-align:center"></td>
</tr>

<tr>
  <td colspan="14"   bgcolor="#FFFF00" style="border:1px solid #000;padding:3px;text-align:left">รอบที่ 1,2 :รถต้องกลับมาโหลดงานค้างสามารถเบิกค่าทางด่วนได้</td>
  <td colspan="3"    bgcolor="#FFFF00" style="border:1px solid #000;padding:3px;text-align:center"></td>
</tr>

</tfoot>



          </table>
        </body>
        </html>
