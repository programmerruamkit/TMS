<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
error_reporting(0);
ini_set('display_errors', 0);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");
$sumtotal = "";



$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
  array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);


$strExcelFileName = "รายงานน้ำมัน STM_IP วันที่ ".$_GET['datestart'] .".xls";

$date = substr($_GET['datestart'],3,10);




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
  <table id="bg-table" width="150%" style="border-collapse: collapse;font-size:12;">

    <thead>
           <tr>
                  <td colspan="18" style="border-right:1px solid #000;padding:3px;text-align:center;">
                      <b>บริษัท ร่วมกิจรุ่งเรือง  (อมตะซิตี้)</b>
                  </td>
             </tr>
             <tr>
                    <td colspan="18" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>RUAMKIT  RUNG  RUENG  (AMATA CITY)</b>
                    </td>
            </tr>
             <tr>
                    <td colspan="18" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>51 ม. 4 ต.บ้านเก่า อ.พานทอง จ. ชลบุรี 20160</b>
                    </td>
               </tr>
               <tr>
                      <td colspan="18" style="border-right:1px solid #000;padding:3px;text-align:center;">
                          <b><u>สรุปโครงการใช้น้ำมันรายบุคคลประจำเดือน <?=$month_arr[date("n")]." ".(date("Y")+543);?> </u></b>
                      </td>
               </tr>
               <tr>
                      <td colspan="18" style="border-right:1px solid #000;padding:3px;text-align:center;">
                          <b>สายงาน <?= $_GET['position'] ?> วันที่  <?=date("d")." ".$month_arr[date("n")]." ".(date("Y")+543);?></b>
                      </td>
               </tr>
           <tr style="border:1px solid #000;background-color: #ccc" >
                <td rowspan="2" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ลำดับ</b>
                </td>
                <td rowspan="2" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>รหัส</b>
                </td>
                <td rowspan="2" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ชื่อ - สกุล</b>
                </td>
                <td rowspan="2" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ทะเบียนรถ</b>
                </td>
                <td rowspan="2" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ประเภทรถ</b>
                </td>
                <td rowspan="2" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>จำนวนเที่ยวที่วิ่งงาน</b>
                </td>
                <td rowspan="2" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>งานที่ขนส่ง</b>
                </td>
                <td colspan="9" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>IP</b>
                </td>
                <td rowspan="2" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>รวมน้ำมัน</b>
                </td>
                <td rowspan="2" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>รวมเงิน</b>
                </td>
                </td>

           </tr>
           <tr style="border:1px solid #000;background-color: #ccc" >
            <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ไมล์ต้น</b></td>
            <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ไมล์ปลาย</b></td>
            <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ระยะทาง</b></td>
            <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>น้ำมันที่เติม</b></td>
            <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ค่าเฉลี่ยที่กำหนด</b></td>
            <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ค่าเฉลี่ยที่ได้</b></td>
            <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>จำนวนน้ำมันที่เกินกำหนด</b></td>
            <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>จำนวนบาท/ลิตร</b></td>
            <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>จำนวนเงินที่ได้(บาท)</b></td>
           </tr>

        </thead><tbody>
        <?php
        $i = 1;
        $mm = "";
        $sql_seBillings = "SELECT a.PersonID AS 'EMPID',a.PersonCode AS 'EMPLOYEECODE',a.FnameT,a.LnameT,
                  (a.FnameT+' '+a.LnameT) AS 'EMPLOYEENAME',c.PositionNameT,a.EndDate
                  FROM [203.150.225.30].[TigerE-HR].dbo.PNT_Person a
                  INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNT_PersonDetail b ON a.PersonID = b.PersonID
                  INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNM_Position c ON a.PositionID = c.PositionID
                  WHERE 1 = 1 AND a.[EndDate] IS NULL
                  AND SUBSTRING(a.PersonCode, 1, 2) IN('02')
                  AND a.PositionID IN('41')
                  AND a.PersonCode NOT IN
                  (SELECT PNT_Person.PersonCode
                  FROM [203.150.225.30].[TigerE-HR].[dbo].PNT_Resign
                  INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].PNM_ResignType ON PNT_Resign.ResignTypeID = PNM_ResignType.ResignTypeID
                  LEFT OUTER JOIN [203.150.225.30].[TigerE-HR].[dbo].PNT_Person ON PNT_Resign.PersonID = PNT_Person.PersonID
                  WHERE PNM_ResignType.ResignT !='เกษียณอายุ'
                  )
                  AND a.ResignStatus = '1'
                  AND a.ChkDeletePerson = '1'
                  ORDER BY a.PersonCode ASC
                  ";
        $params_seBillings = array();
        $query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
        while ($result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC)){

          ////////////////////หาราคาน้ำมันที่กำหนดไว้//////////////////////////////////////////////////
          $sql_seSystime = "{call megGetdate_v2(?)}";
          $params_seSystime = array(
              array('select_getdate', SQLSRV_PARAM_IN)
          );
          $query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
          $result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);
          $mm = "";
          switch ((int) substr($result_seSystime['GETDATE'], 4, 2)) {
              case '1': {
                      $mm = "มกราคม";
                  }
                  break;
              case '2': {
                      $mm = "กุมภาพันธ์";
                  }
                  break;
              case '3': {
                      $mm = "มีนาคม";
                  }
                  break;
              case '4': {
                      $mm = "เมษายน";
                  }
                  break;
              case '5': {
                      $mm = "พฤษภาคม";
                  }
                  break;
              case '6': {
                      $mm = "มิถุนายน";
                  }
                  break;
              case '7': {
                      $mm = "กรกฎาคม";
                  }
                  break;
              case '8': {
                      $mm = "สิงหาคม";
                  }
                  break;
              case '9': {
                      $mm = "กันยายน";
                  }
                  break;
              case '10': {
                      $mm = "ตุลาคม";
                  }
                  break;
              case '11': {
                      $mm = "พฤศจิกายน";
                  }
                  break;
              default : {
                      $mm = "ธันวาคม";
                  }
                  break;
          }
          $condOilprice1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND YEAR = '" . substr($result_seSystime['GETDATE'], 0, 4) . "' AND MONTH = '" . $mm . "'";
          $condOilprice2 = "";
          $condOilprice3 = "";
          $sql_seOilprice = "{call megOilprice_v2(?,?,?,?)}";
          $params_seOilprice = array(
              array('select_oilprice', SQLSRV_PARAM_IN),
              array($condOilprice1, SQLSRV_PARAM_IN),
              array($condOilprice2, SQLSRV_PARAM_IN),
              array($condOilprice3, SQLSRV_PARAM_IN)
          );
          $query_seOilprice = sqlsrv_query($conn, $sql_seOilprice, $params_seOilprice);
          $result_seOilprice = sqlsrv_fetch_array($query_seOilprice, SQLSRV_FETCH_ASSOC);

          ////////////////////////////////หา JOBงานหลัก///////////////////////////////////////

          $sql_seData= "SELECT CUSTOMERCODE,COMPANYCODE,THAINAME,VEHICLETYPE,O4 AS 'OIL',ROW_NUMBER() OVER(ORDER BY VEHICLETRANSPORTPLANID) AS 'TRIP',
                      JOBNO,VEHICLETRANSPORTPLANID FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='" . $_GET['companycode'] ."' AND CUSTOMERCODE = 'STM'
                      AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] ."',103) AND CONVERT(DATE,'" . $_GET['dateend'] ."',103)
                      AND (EMPLOYEECODE1 ='".$result_seBillings['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_seBillings['EMPLOYEECODE']."')";
          $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
          $result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC);


          /////////////////////////////////ดึงข้อมูล ค่าเฉลี่ยน้ำมันที่กำหนดไว้/////////////////////////////////////////////////////////
          $sql_seOilavg= "SELECT OILAVERAGE AS 'OILAVG' FROM [dbo].[OILAVERAGE]
                      WHERE ACTIVESTATUS ='1'
                      AND COMPANYCODE ='" .$_GET['companycode'] . "'
                      AND CUSTOMERCODE ='STM'
                      AND VEHICLETYPE ='" .$result_seData['VEHICLETYPE']."'";
          $query_seOilavg = sqlsrv_query($conn, $sql_seOilavg, $params_seOilavg);
          $result_seOilavg = sqlsrv_fetch_array($query_seOilavg, SQLSRV_FETCH_ASSOC);

          ////////////////////////////////////MILEAGESTART งานปกติ //////////////////////////////////////////////
          $sql_mileagestart= "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGESTART',MILEAGETYPE FROM [dbo].[MILEAGE]
                             WHERE JOBNO='" . $result_seData['JOBNO'] . "'
                             AND MILEAGETYPE = 'MILEAGESTART'
                             ORDER BY CREATEDATE DESC";
          $query_mileagestart = sqlsrv_query($conn, $sql_mileagestart, $params_mileagestart);
          $result_mileagestart = sqlsrv_fetch_array($query_mileagestart, SQLSRV_FETCH_ASSOC);

          /////////////////////////////////////////////////////////////////////////////////////////////////

          //////////////////////////////////////MILEAGESTART งานปกติ/////////////////////////////////////////
          $sql_mileageend= "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGEEND',MILEAGETYPE FROM [dbo].[MILEAGE]
                             WHERE JOBNO='" . $result_seData['JOBNO'] . "'
                             AND MILEAGETYPE = 'MILEAGEEND'
                             ORDER BY CREATEDATE DESC";
          $query_mileageend = sqlsrv_query($conn, $sql_mileageend, $params_mileageend);
          $result_mileageend = sqlsrv_fetch_array($query_mileageend, SQLSRV_FETCH_ASSOC);
          ///////////////////////////////////////////////////////////////////////////////////////////

          ////////////////////////////งานหลัก///////////////////////////////
          if ($result_seData['TRIP'] == '') {
            $Deliver = '';
            $Mileagestart = '';
            $Mileageend = '';
            $Distance = '';
            $AvgOil ='';
            $AvgOver = '';
            $MoneyOil = '';
            $OilPrice = '';

          }else {
            $Deliver = 'IP';
            $Mileagestart = $result_mileagestart['MILEAGESTART'];
            $Mileageend = $result_mileageend['MILEAGEEND'];
            $Distance = $result_mileageend['MILEAGEEND']-$result_mileagestart['MILEAGESTART'];
            $AvgOil = ($Distance/$result_seData['OIL']); //ค่าเฉลี่ยที่ได้
            $AvgOver = (($Distance/$result_seOilavg['OILAVG'])-$result_seData['OIL']); // ค่าเฉลี่ยที่ได้
            $MoneyOil = ((($Distance/$result_seOilavg['OILAVG'])-$result_seData['OIL'])*$result_seOilprice['PRICE']);
            $OilPrice = $result_seOilprice['PRICE'];
          }
         ?>

         <tr style="border:1px solid #000;" >
           <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$i?></b></td>
           <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$result_seBillings['EMPLOYEECODE']?></b></td>
           <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;"><b><?=$result_seBillings['EMPLOYEENAME']?></b></td>
           <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$result_seData['THAINAME']?></b></td>
           <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$result_seData['VEHICLETYPE']?></b></td>
           <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$result_seData['TRIP']?></b></td>
           <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$Deliver?></b></td>
           <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$Mileagestart?></b></td>
           <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$Mileageend?></b></td>
           <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$Distance?></b></td>
           <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$result_seData['OIL']?></b></td> <!-- น้ำมันที่เติม-->
           <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>2.75</b></td> <!-- ค่าเฉลี่ยที่กำหนด-->
           <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$AvgOil?></b></td> <!--น้้ำมันที่เติม -->
           <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$AvgOver1?></b></td><!--น้้ำมันที่เติมเกินกำหนด -->
           <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$OilPrice?></b></td>
           <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($MoneyOil)?></b></td>
           <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($result_seData['OIL'],2)?></b></td>
           <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($MoneyOil)?></b></td>
         </tr>
      <?php
      $i++;
      }
       ?>

  </tbody><tfoot>
       <tr style="border:1px solid #000;">
          <td colspan="7" style="border:1px solid #000;padding:3px;text-align:center;"><b><u>รวม<u><b></td>
          <td colspan="1" style="border:1px solid #000;padding:3px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:3px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:3px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:3px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:3px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:3px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:3px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
      </tr>
      </tfoot>
  </table>


      <br><br><br><br>
      <table>
      </table>

</body>
</html>
