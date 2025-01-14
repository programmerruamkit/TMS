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


$strExcelFileName = "รายงานน้ำมัน SKB วันที่ ".$_GET['datestart'] .".xls";

$date = substr($_GET['datestart'],3,10);




header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

$month_arr=array(
    "1"=>"มกราคม",
    "2"=>"กุมภาพันธ์",
    "3"=>"มีนาคม",
    "4"=>"เมษายน",
    "5"=>"พฤษภาคม",
    "6"=>"มิถุนายน",
    "7"=>"กรกฎาคม",
    "8"=>"สิงหาคม",
    "9"=>"กันยายน",
    "10"=>"ตุลาคม",
    "11"=>"พฤศจิกายน",
    "12"=>"ธันวาคม"
);

 $month_arr[date("n")]." ".(date("Y")+543);

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
                <td colspan="45" style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <b>บริษัท ร่วมกิจรุ่งเรือง  (อมตะซิตี้)</b>
                </td>
           </tr>
           <tr>
                  <td colspan="45" style="border-right:1px solid #000;padding:3px;text-align:center;">
                      <b>RUAMKIT  RUNG  RUENG  (AMATA CITY)</b>
                  </td>
          </tr>
           <tr>
                  <td colspan="45" style="border-right:1px solid #000;padding:3px;text-align:center;">
                      <b>51 ม. 4 ต.บ้านเก่า อ.พานทอง จ. ชลบุรี 20160</b>
                  </td>
             </tr>
             <tr>
                    <td colspan="45" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b><u>สรุปโครงการใช้น้ำมันรายบุคคลประจำเดือน <?=$month_arr[date("n")]." ".(date("Y")+543);?> </u></b>
                    </td>
             </tr>
             <tr>
                    <td colspan="45" style="border-right:1px solid #000;padding:3px;text-align:center;">
                        <b>สายงาน <?= $_GET['customercode'] ?>วันที่  <?=date("d")." ".$month_arr[date("n")]." ".(date("Y")+543);?></b>
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
              <b>TL OTHER 2</b>
              </td>
              <td colspan="9" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>TL OTHER  FB</b>
              </td>
              <td colspan="9" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>STC-TL</b>
              </td>
              <td colspan="9" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>STC-TL AMATA</b>
              </td>
              <td rowspan="2" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>รวมน้ำมัน</b>
              </td>
              <td rowspan="2" colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;">
              <b>รวมเงิน</b>
              </td>


         </tr>
         <tr style="border:1px solid #000;background-color: #ccc" >

          <!-- TL OTHER 2 -->
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ไมล์ต้น</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ไมล์ปลาย</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ระยะทาง</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>น้ำมันที่เติม</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ค่าเฉลี่ยที่กำหนด</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ค่าเฉลี่ยที่ได้</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>จำนวนน้ำมันที่เกินกำหนด</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>จำนวนบาท/ลิตร</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>จำนวนเงินที่ได้(บาท)</b></td>

          <!-- TL OTHER  FB -->
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ไมล์ต้น</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ไมล์ปลาย</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ระยะทาง</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>น้ำมันที่เติม</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ค่าเฉลี่ยที่กำหนด</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ค่าเฉลี่ยที่ได้</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>จำนวนน้ำมันที่เกินกำหนด</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>จำนวนบาท/ลิตร</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>จำนวนเงินที่ได้(บาท)</b></td>

          <!-- STC-TL -->
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ไมล์ต้น</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ไมล์ปลาย</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ระยะทาง</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>น้ำมันที่เติม</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ค่าเฉลี่ยที่กำหนด</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>ค่าเฉลี่ยที่ได้</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>จำนวนน้ำมันที่เกินกำหนด</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>จำนวนบาท/ลิตร</b></td>
          <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b>จำนวนเงินที่ได้(บาท)</b></td>

          <!-- STC-TL AMATA -->
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
              AND SUBSTRING(a.PersonCode, 1, 2) IN('07')
              AND a.PositionID IN('34')
              AND a.PersonCode NOT IN
              (SELECT PNT_Person.PersonCode
              FROM [203.150.225.30].[TigerE-HR].[dbo].PNT_Resign
              INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].PNM_ResignType ON PNT_Resign.ResignTypeID = PNM_ResignType.ResignTypeID
              LEFT OUTER JOIN [203.150.225.30].[TigerE-HR].[dbo].PNT_Person ON PNT_Resign.PersonID = PNT_Person.PersonID
              WHERE PNM_ResignType.ResignT !='เกษียณอายุ'
              )
              AND a.ResignStatus = '1'
              AND a.ChkDeletePerson = '1'
              ORDER BY a.PersonCode ASC";
        $params_seBillings = array();
        $query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
        while ($result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC)){


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
          ////////////////////น้ำมันที่กำหนดไว้งาน AMATA/////////////////////////////////////
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

          ///////////////////นับจำนวน TRIP////////////////////////////////////////////
          $sql_seTrip = "SELECT MAX(a.TRIP) AS 'TRIP' FROM(
                      SELECT ROW_NUMBER() OVER(ORDER BY VEHICLETRANSPORTPLANID) AS 'TRIP'
                      FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='" . $_GET['companycode'] ."' AND CUSTOMERCODE ='SKB'
                      AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] ."',103) AND CONVERT(DATE,'" . $_GET['dateend'] ."',103)
                      AND (EMPLOYEECODE1 ='".$result_seBillings['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_seBillings['EMPLOYEECODE']."')) a
                      ";
          $query_seTrip = sqlsrv_query($conn, $sql_seTrip, $params_seTrip);
          $result_seTrip = sqlsrv_fetch_array($query_seTrip, SQLSRV_FETCH_ASSOC);
          ////////////////////////////////THAINAME AND VEHICLETYPE///////////////////////////////////////
          $sql_seVehicledata = "SELECT CUSTOMERCODE,COMPANYCODE,THAINAME,VEHICLETYPE,O4 AS 'OIL',ROW_NUMBER() OVER(ORDER BY VEHICLETRANSPORTPLANID) AS 'TRIP',
                      JOBNO,JOBSTART,VEHICLETRANSPORTPLANID,JOBSTART FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='" . $_GET['companycode'] ."' AND CUSTOMERCODE IN ('SKB')
                      AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] ."',103) AND CONVERT(DATE,'" . $_GET['dateend'] ."',103)
                      AND (EMPLOYEECODE1 ='".$result_seBillings['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_seBillings['EMPLOYEECODE']."')
                      AND O4 IS NOT NULL
                      AND O4 != ''";
          $query_seVehicledata = sqlsrv_query($conn, $sql_seVehicledata, $params_seVehicledata);
          $result_seVehicledata = sqlsrv_fetch_array($query_seVehicledata, SQLSRV_FETCH_ASSOC);

          ////////////////////////////////หา TL OTHER 2///////////////////////////////////////
          $sql_seData = "SELECT CUSTOMERCODE,COMPANYCODE,THAINAME,VEHICLETYPE,O4 AS 'OIL',ROW_NUMBER() OVER(ORDER BY VEHICLETRANSPORTPLANID) AS 'TRIP',
                      JOBNO,JOBSTART,VEHICLETRANSPORTPLANID FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='" . $_GET['companycode'] ."' AND CUSTOMERCODE IN ('SKB')
                      AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] ."',103) AND CONVERT(DATE,'" . $_GET['dateend'] ."',103)
                      AND (EMPLOYEECODE1 ='".$result_seBillings['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_seBillings['EMPLOYEECODE']."')
                      AND VEHICLETYPE ='ADC-DEALER(SL2)'
                      AND O4 IS NOT NULL
                      AND O4 != ''";
          $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
          $result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC);
          ////////////////////////////////หา TL OTHER  FB ///////////////////////////////////////
          $sql_seData2 = "SELECT CUSTOMERCODE,COMPANYCODE,THAINAME,VEHICLETYPE,O4 AS 'OIL',ROW_NUMBER() OVER(ORDER BY VEHICLETRANSPORTPLANID) AS 'TRIP',
                      JOBNO,JOBSTART,VEHICLETRANSPORTPLANID FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='" . $_GET['companycode'] ."' AND CUSTOMERCODE IN ('SKB')
                      AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] ."',103) AND CONVERT(DATE,'" . $_GET['dateend'] ."',103)
                      AND (EMPLOYEECODE1 ='".$result_seBillings['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_seBillings['EMPLOYEECODE']."')
                      AND VEHICLETYPE ='ADC-Dealer(FB)'
                      AND O4 IS NOT NULL
                      AND O4 != ''";
          $query_seData2 = sqlsrv_query($conn, $sql_seData2, $params_seData2);
          $result_seData2 = sqlsrv_fetch_array($query_seData2, SQLSRV_FETCH_ASSOC);
          ////////////////////////////////หา STC-TL  ///////////////////////////////////////
          $sql_seData3 = "SELECT CUSTOMERCODE,COMPANYCODE,THAINAME,VEHICLETYPE,O4 AS 'OIL',ROW_NUMBER() OVER(ORDER BY VEHICLETRANSPORTPLANID) AS 'TRIP',
                      JOBNO,JOBSTART,VEHICLETRANSPORTPLANID FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='" . $_GET['companycode'] ."' AND CUSTOMERCODE IN ('TTASTSTC')
                      AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] ."',103) AND CONVERT(DATE,'" . $_GET['dateend'] ."',103)
                      AND (EMPLOYEECODE1 ='".$result_seBillings['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_seBillings['EMPLOYEECODE']."')
                      AND VEHICLETYPE ='Trailer'
                      AND O4 IS NOT NULL
                      AND O4 != ''";
          $query_seData3 = sqlsrv_query($conn, $sql_seData3, $params_seData3);
          $result_seData3 = sqlsrv_fetch_array($query_seData3, SQLSRV_FETCH_ASSOC);
          ////////////////////////////////STC-TL AMATA ///////////////////////////////////////
          $sql_seData4 = "SELECT CUSTOMERCODE,COMPANYCODE,THAINAME,VEHICLETYPE,O4 AS 'OIL',ROW_NUMBER() OVER(ORDER BY VEHICLETRANSPORTPLANID) AS 'TRIP',
                      JOBNO,JOBSTART,VEHICLETRANSPORTPLANID FROM [dbo].[VEHICLETRANSPORTPLAN]
                      WHERE COMPANYCODE  ='" . $_GET['companycode'] ."' AND CUSTOMERCODE IN ('TTASTSTC')
                      AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] ."',103) AND CONVERT(DATE,'" . $_GET['dateend'] ."',103)
                      AND (EMPLOYEECODE1 ='".$result_seBillings['EMPLOYEECODE']."' OR  EMPLOYEECODE2 ='".$result_seBillings['EMPLOYEECODE']."')
                      AND VEHICLETYPE ='Trailer(AMT)'
                      AND O4 IS NOT NULL
                      AND O4 != ''";
          $query_seData4 = sqlsrv_query($conn, $sql_seData4, $params_seData4);
          $result_seData4 = sqlsrv_fetch_array($query_seData4, SQLSRV_FETCH_ASSOC);

          ////////////////////////////น้ำมันที่กำหนดไว้งาน OTHER//////////////////////////////////
          $condOilprice11 = " AND COMPANYCODE = '" . $result_seData2['COMPANYCODE'] . "' AND YEAR = '" . substr($result_seSystime['GETDATE'], 0, 4) . "' AND MONTH = '" . $mm . "'";
          $condOilprice22 = "";
          $condOilprice33 = "";
          $sql_seOilprice2 = "{call megOilprice_v2(?,?,?,?)}";
          $params_seOilprice2 = array(
              array('select_oilprice', SQLSRV_PARAM_IN),
              array($condOilprice11, SQLSRV_PARAM_IN),
              array($condOilprice22, SQLSRV_PARAM_IN),
              array($condOilprice33, SQLSRV_PARAM_IN)
          );
          $query_seOilprice2 = sqlsrv_query($conn, $sql_seOilprice2, $params_seOilprice2);
          $result_seOilprice2 = sqlsrv_fetch_array($query_seOilprice2, SQLSRV_FETCH_ASSOC);
          ////////////////////////////ำมันที่กำหนดไว้งาน 4W OTHER//////////////////////////////////
          $condOilprice44 = " AND COMPANYCODE = '" . $result_seData3['COMPANYCODE'] . "' AND YEAR = '" . substr($result_seSystime['GETDATE'], 0, 4) . "' AND MONTH = '" . $mm . "'";
          $condOilprice55 = "";
          $condOilprice66 = "";
          $sql_seOilprice3 = "{call megOilprice_v2(?,?,?,?)}";
          $params_seOilprice3 = array(
              array('select_oilprice', SQLSRV_PARAM_IN),
              array($condOilprice44, SQLSRV_PARAM_IN),
              array($condOilprice55, SQLSRV_PARAM_IN),
              array($condOilprice66, SQLSRV_PARAM_IN)
          );
          $query_seOilprice3 = sqlsrv_query($conn, $sql_seOilprice3, $params_seOilprice3);
          $result_seOilprice3 = sqlsrv_fetch_array($query_seOilprice3, SQLSRV_FETCH_ASSOC);

          $condOilprice77 = " AND COMPANYCODE = '" . $result_seData3['COMPANYCODE'] . "' AND YEAR = '" . substr($result_seSystime['GETDATE'], 0, 4) . "' AND MONTH = '" . $mm . "'";
          $condOilprice88 = "";
          $condOilprice99 = "";
          $sql_seOilprice4 = "{call megOilprice_v2(?,?,?,?)}";
          $params_seOilprice4 = array(
              array('select_oilprice', SQLSRV_PARAM_IN),
              array($condOilprice77, SQLSRV_PARAM_IN),
              array($condOilprice88, SQLSRV_PARAM_IN),
              array($condOilprice99, SQLSRV_PARAM_IN)
          );
          $query_seOilprice4 = sqlsrv_query($conn, $sql_seOilprice4, $params_seOilprice4);
          $result_seOilprice4 = sqlsrv_fetch_array($query_seOilprice4, SQLSRV_FETCH_ASSOC);

          ///////////////ดึงข้อมูล ค่าเฉลี่ยน้ำมันที่กำหนดไว้ TL OTHER 2//////////////////////////////////////////
          $sql_seOilavg= "SELECT OILAVERAGE AS 'OILAVG' FROM [dbo].[OILAVERAGE]
                      WHERE ACTIVESTATUS ='1'
                      AND COMPANYCODE ='" .$_GET['companycode'] . "'
                      AND CUSTOMERCODE ='SKB'
                      AND VEHICLETYPE ='" .$result_seData['VEHICLETYPE']."'";
          $query_seOilavg = sqlsrv_query($conn, $sql_seOilavg, $params_seOilavg);
          $result_seOilavg = sqlsrv_fetch_array($query_seOilavg, SQLSRV_FETCH_ASSOC);
          ///////////////////ดึงข้อมูล ค่าเฉลี่ยน้ำมันที่กำหนดไว้ TL OTHER  FB//////////////////////////////////////
          $sql_seOilavg2 = "SELECT OILAVERAGE AS 'OILAVG' FROM [dbo].[OILAVERAGE]
                      WHERE ACTIVESTATUS ='1'
                      AND COMPANYCODE ='" .$result_seData2['COMPANYCODE']."'
                      AND CUSTOMERCODE ='SKB'
                      AND VEHICLETYPE ='" .$result_seData2['VEHICLETYPE']."'";
          $query_seOilavg2 = sqlsrv_query($conn, $sql_seOilavg2, $params_seOilavg2);
          $result_seOilavg2 = sqlsrv_fetch_array($query_seOilavg2, SQLSRV_FETCH_ASSOC);
          ///////////////////ดึงข้อมูล ค่าเฉลี่ยน้ำมันที่กำหนดไว STC-TL ///////////////////////////////////
          $sql_seOilavg3 = "SELECT OILAVERAGE AS 'OILAVG' FROM [dbo].[OILAVERAGE]
                      WHERE ACTIVESTATUS ='1'
                      AND COMPANYCODE ='" .$result_seData3['COMPANYCODE']."'
                      AND CUSTOMERCODE ='TTASTSTC'
                      AND VEHICLETYPE ='" .$result_seData3['VEHICLETYPE']."'";
          $query_seOilavg3 = sqlsrv_query($conn, $sql_seOilavg3, $params_seOilavg3);
          $result_seOilavg3 = sqlsrv_fetch_array($query_seOilavg3, SQLSRV_FETCH_ASSOC);
          ///////////////////ดึงข้อมูล ค่าเฉลี่ยน้ำมันที่กำหนดไว STC-TL AMATA ///////////////////////////////////
          $sql_seOilavg4 = "SELECT OILAVERAGE AS 'OILAVG' FROM [dbo].[OILAVERAGE]
                      WHERE ACTIVESTATUS ='1'
                      AND COMPANYCODE ='" .$result_seData4['COMPANYCODE']."'
                      AND CUSTOMERCODE ='TTASTSTC'
                      AND VEHICLETYPE ='" .$result_seData4['VEHICLETYPE']."'";
          $query_seOilavg4 = sqlsrv_query($conn, $sql_seOilavg4, $params_seOilavg4);
          $result_seOilavg4 = sqlsrv_fetch_array($query_seOilavg4, SQLSRV_FETCH_ASSOC);


          ////////////////////////////////////MILEAGESTART TL OTHER 2 //////////////////////////////////////////
          $sql_mileagestart= "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGESTART',MILEAGETYPE FROM [dbo].[MILEAGE]
                             WHERE JOBNO='" . $result_seData['JOBNO'] . "'
                             AND MILEAGETYPE = 'MILEAGESTART'
                             ORDER BY CREATEDATE DESC";
          $query_mileagestart = sqlsrv_query($conn, $sql_mileagestart, $params_mileagestart);
          $result_mileagestart = sqlsrv_fetch_array($query_mileagestart, SQLSRV_FETCH_ASSOC);
          ////////////////////////////////////MILEAGESTART TL OTHER  FB //////////////////////////////////////////////
          $sql_mileagestart2= "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGESTART',MILEAGETYPE FROM [dbo].[MILEAGE]
                             WHERE JOBNO='" . $result_seData2['JOBNO'] . "'
                             AND MILEAGETYPE = 'MILEAGESTART'
                             ORDER BY CREATEDATE DESC";
          $query_mileagestart2 = sqlsrv_query($conn, $sql_mileagestart2, $params_mileagestart2);
          $result_mileagestart2 = sqlsrv_fetch_array($query_mileagestart2, SQLSRV_FETCH_ASSOC);
          ////////////////////////////////////MILEAGESTART STC-TL  //////////////////////////////////////////////
          $sql_mileagestart3= "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGESTART',MILEAGETYPE FROM [dbo].[MILEAGE]
                             WHERE JOBNO='" . $result_seData3['JOBNO'] . "'
                             AND MILEAGETYPE = 'MILEAGESTART'
                             ORDER BY CREATEDATE DESC";
          $query_mileagestart3 = sqlsrv_query($conn, $sql_mileagestart3, $params_mileagestart3);
          $result_mileagestart3 = sqlsrv_fetch_array($query_mileagestart3, SQLSRV_FETCH_ASSOC);
          ////////////////////////////////////MILEAGESTART STC-TL AMATA //////////////////////////////////////////////
          $sql_mileagestart4= "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGESTART',MILEAGETYPE FROM [dbo].[MILEAGE]
                             WHERE JOBNO='" . $result_seData4['JOBNO'] . "'
                             AND MILEAGETYPE = 'MILEAGESTART'
                             ORDER BY CREATEDATE DESC";
          $query_mileagestart4 = sqlsrv_query($conn, $sql_mileagestart4, $params_mileagestart4);
          $result_mileagestart4 = sqlsrv_fetch_array($query_mileagestart4, SQLSRV_FETCH_ASSOC);
          /////////////////////////////////////////////////////////////////////////////////////////////////

          //////////////////////////////////////MILEAGEND TL OTHER 2 //////////////////////////////
          $sql_mileageend = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGEEND',MILEAGETYPE FROM [dbo].[MILEAGE]
                             WHERE JOBNO='" . $result_seData['JOBNO'] . "'
                             AND MILEAGETYPE = 'MILEAGEEND'
                             ORDER BY CREATEDATE DESC";
          $query_mileageend = sqlsrv_query($conn, $sql_mileageend, $params_mileageend);
          $result_mileageend = sqlsrv_fetch_array($query_mileageend, SQLSRV_FETCH_ASSOC);
          //////////////////////////////////////MILEAGEND TL OTHER  FB//////////////////////////////////////
          $sql_mileageend2 = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGEEND',MILEAGETYPE FROM [dbo].[MILEAGE]
                             WHERE JOBNO='" . $result_seData2['JOBNO'] . "'
                             AND MILEAGETYPE = 'MILEAGEEND'
                             ORDER BY CREATEDATE DESC";
          $query_mileageend2 = sqlsrv_query($conn, $sql_mileageend2, $params_mileageend2);
          $result_mileageend2 = sqlsrv_fetch_array($query_mileageend2, SQLSRV_FETCH_ASSOC);
          ////////////////////////////////////MILEAGEND STC-TL  ////////////////////////////////
          $sql_mileageend3 = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGEEND',MILEAGETYPE FROM [dbo].[MILEAGE]
                             WHERE JOBNO='" . $result_seData3['JOBNO'] . "'
                             AND MILEAGETYPE = 'MILEAGEEND'
                             ORDER BY CREATEDATE DESC";
          $query_mileageend3 = sqlsrv_query($conn, $sql_mileageend3, $params_mileageend3);
          $result_mileageend3 = sqlsrv_fetch_array($query_mileageend3, SQLSRV_FETCH_ASSOC);
          ////////////////////////////////////MILEAGEND STC-TL AMATA ////////////////////////////////
          $sql_mileageend4 = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGEEND',MILEAGETYPE FROM [dbo].[MILEAGE]
                             WHERE JOBNO='" . $result_seData4['JOBNO'] . "'
                             AND MILEAGETYPE = 'MILEAGEEND'
                             ORDER BY CREATEDATE DESC";
          $query_mileageend4 = sqlsrv_query($conn, $sql_mileageend4, $params_mileageend4);
          $result_mileageend4 = sqlsrv_fetch_array($query_mileageend4, SQLSRV_FETCH_ASSOC);
          /////////////////////////////////////////////////////////////////////////////////////


          ////////////////////////////งานหลัก TL OTHER 2///////////////////////////////
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
            $Deliver = $result_seData['JOBSTART'];
            $Mileagestart = $result_mileagestart['MILEAGESTART'];
            $Mileageend = $result_mileageend['MILEAGEEND'];
            $Distance = $result_mileageend['MILEAGEEND']-$result_mileagestart['MILEAGESTART'];
            $AvgOil = ($Distance/$result_seData['OIL']); //ค่าเฉลี่ยที่ได้
            $AvgOver = (($Distance/$result_seOilavg['OILAVG'])-$result_seData['OIL']); // ค่าเฉลี่ยที่ได้
            $MoneyOil = ((($Distance/$result_seOilavg['OILAVG'])-$result_seData['OIL'])*$result_seOilprice['PRICE']);
            $OilPrice = $result_seOilprice['PRICE'];
          }

          ////////////////////////////TL OTHER  FB///////////////////////////////
          if ($result_seData2['TRIP'] == '') {
            $Deliver2 = '';
            $Mileagestart2 = '';
            $Mileageend2 = '';
            $Distance2 = '';
            $AvgOil2 ='';
            $AvgOver2 = '';
            $MoneyOil2 = '';
            $OilPrice2 = '';

          }else {
            $Deliver2 = $result_seData2['JOBSTART'];
            $Mileagestart2 = $result_mileagestart2['MILEAGESTART'];
            $Mileageend2 = $result_mileageend2['MILEAGEEND'];
            $Distance2 = $result_mileageend2['MILEAGEEND']-$result_mileagestart2['MILEAGESTART'];
            $AvgOil2 = ($Distance2/$result_seData2['OIL']); //ค่าเฉลี่ยที่ได้
            $AvgOver2 = (($Distance2/$result_seOilavg2['OILAVG'])-$result_seData2['OIL']); // ค่าเฉลี่ยที่ได้
            $MoneyOil2 = ((($Distance2/$result_seOilavg2['OILAVG'])-$result_seData2['OIL'])*$result_seOilprice2['PRICE']);
            $OilPrice2 = $result_seOilprice2['PRICE'];
          }

          ////////////////////////////STC-TL ///////////////////////////////
          if ($result_seData3['TRIP'] == '') {
            $Deliver3 = '';
            $Mileagestart3 = '';
            $Mileageend3 = '';
            $Distance3 = '';
            $AvgOil3 ='';
            $AvgOver3 = '';
            $MoneyOil3 = '';
            $OilPrice3 = '';

          }else {
            $Deliver3 = $result_seData3['JOBSTART'];
            $Mileagestart3 = $result_mileagestart3['MILEAGESTART'];
            $Mileageend3 = $result_mileageend3['MILEAGEEND'];
            $Distance3 = $result_mileageend3['MILEAGEEND']-$result_mileagestart3['MILEAGESTART'];
            $AvgOil3 = ($Distance3/$result_seData3['OIL']); //ค่าเฉลี่ยที่ได้
            $AvgOver3 = (($Distance3/$result_seOilavg3['OILAVG'])-$result_seData3['OIL']); // ค่าเฉลี่ยที่ได้
            $MoneyOil3 = ((($Distance3/$result_seOilavg3['OILAVG'])-$result_seData3['OIL'])*$result_seOilprice3['PRICE']);
            $OilPrice3 = $result_seOilprice3['PRICE'];
          }

          ////////////////////////////STC-TL AMATA ///////////////////////////////
          if ($result_seData4['TRIP'] == '') {
            $Deliver4 = '';
            $Mileagestart4 = '';
            $Mileageend4 = '';
            $Distance4 = '';
            $AvgOil4 ='';
            $AvgOver4 = '';
            $MoneyOil4 = '';
            $OilPrice4 = '';

          }else {
            $Deliver4 = $result_seData4['JOBSTART'];
            $Mileagestart4 = $result_mileagestart4['MILEAGESTART'];
            $Mileageend4 = $result_mileageend4['MILEAGEEND'];
            $Distance4 = $result_mileageend4['MILEAGEEND']-$result_mileagestart4['MILEAGESTART'];
            $AvgOil4 = ($Distance4/$result_seData4['OIL']); //ค่าเฉลี่ยที่ได้
            $AvgOver4 = (($Distance4/$result_seOilavg4['OILAVG'])-$result_seData4['OIL']); // ค่าเฉลี่ยที่ได้
            $MoneyOil4 = ((($Distance4/$result_seOilavg4['OILAVG'])-$result_seData4['OIL'])*$result_seOilprice4['PRICE']);
            $OilPrice4 = $result_seOilprice4['PRICE'];
          }
         ?>

      <tr style="border:1px solid #000;" >

        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$i?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$result_seBillings['EMPLOYEECODE']?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;"><b><?=$result_seBillings['EMPLOYEENAME']?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$result_seVehicledata['THAINAME']?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$result_seVehicledata['VEHICLETYPE']?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$result_seTrip['TRIP']?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:left;"><b><?=$result_seVehicledata['JOBSTART']?></b></td>
        <!-- TL OTHER 2 -->
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$Mileagestart?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$Mileageend?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$Distance?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$result_seData['OIL']?></b></td> <!-- น้ำมันที่เติม-->
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$result_seOilavg['OILAVG']?></b></td> <!-- ค่าเฉลี่ยที่กำหนด-->
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($AvgOil,2)?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($AvgOver,2)?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$OilPrice?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($MoneyOil)?></b></td>
        <!-- TL OTHER  FB -->
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$Mileagestart2?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$Mileageend2?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$Distance2?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$result_seData2['OIL']?></b></td> <!--น้้ำมันที่เติมงานนอก -->
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$result_seOilavg2['OILAVG']?></b></td> <!-- ค่าเฉลี่ยที่กำหนด-->
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($AvgOil2,2)?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($AvgOver2,2)?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$OilPrice2?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($MoneyOil2)?></b></td>
        <!-- STC-TL -->
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$Mileagestart3?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$Mileageend3?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$Distance3?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$result_seData3['OIL']?></b></td> <!--น้้ำมันที่เติมงานนอก -->
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$result_seOilavg3['OILAVG']?></b></td> <!-- ค่าเฉลี่ยที่กำหนด-->
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($AvgOil3,2)?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($AvgOver3,2)?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$OilPrice3?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($MoneyOil3)?></b></td>
        <!-- STC-TL AMATA -->
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$Mileagestart4?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$Mileageend4?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$Distance4?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$result_seData4['OIL']?></b></td> <!--น้้ำมันที่เติมงานนอก -->
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$result_seOilavg4['OILAVG']?></b></td> <!-- ค่าเฉลี่ยที่กำหนด-->
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($AvgOil4,2)?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($AvgOver4,2)?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=$OilPrice4?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($MoneyOil4)?></b></td>

        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($result_seData['OIL']+$result_seData2['OIL']+$result_seData3['OIL']+$result_seData4['OIL'],2)?></b></td>
        <td colspan="1" style="border-right:1px solid #000;padding:3px;text-align:center;"><b><?=number_format($MoneyOil)+number_format($MoneyOil2)+number_format($MoneyOil3)+number_format($MoneyOil4)?></b></td>
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
          <td colspan="1" style="border:1px solid #000;padding:3px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:3px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>
          <td colspan="1" style="border:1px solid #000;padding:4px;text-align:center;"><b><b></td>

      </tr>
      </tfoot>
  </table>

  <br><br><br><br>
  <table>
  </table>


</body>
</html>
