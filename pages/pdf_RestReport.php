<?php
ob_start();
session_start();
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
date_default_timezone_set("Asia/Bangkok");


ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");
//$mpdf = new mPDF();
$mpdf = new mPDF('th', 'A3-L', '10', '10','10','10','5');
$mpdf->SetDisplayMode('fullpage');
///////////////////////////////////////////////////////////////////////////////

$sql_seSystime = "{call megGetdate_v2(?)}";
$params_seSystime = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
$result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);

///////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////

$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}

	input.big{
  height: 20em;
  width: 20em;
}
</style>';
$table0= '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:6;margin-top:6px;">
    <thead>
          <tr style="padding:2px;">
              <td colspan="116" style="padding:2px;text-align:center;font-size:18;text-align:center;"><b>เอกสารควบคุมการขับขี่ของพนักงานขนส่งยานยนต์ (สายไกล)</b></td>
          </tr>
          <tr style="padding:6px;">
              <td colspan="116" style="padding:2px;text-align:center;font-size:18;text-align:center;"></td>
          </tr><br>
          <tr style="padding:2px;">
              <td colspan="18" style="padding:2px;font-size:14;text-align:left">วันที่ '.$result_seSystime['SYSDATE'].'</td>
              <td colspan="50" style="padding:2px;font-size:20;text-align:left"><font color="red"><b>หน้า 1</b></font></td>
              <td colspan="46" style="padding:2px;font-size:10;text-align:center"><b>หมายเหตุ &nbsp;&nbsp;S=เริ่มออกจาก VL &nbsp;&nbsp;&nbsp;P=จอด&nbsp;&nbsp; E=จบการทำงาน&nbsp;&nbsp; DL=ดีลเลอร์</b></td>
          </tr>
        <tr style="border:1px solid #000;padding:2px;">
            <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:2px;text-align:center;font-size:12;">ลำดับ</td>
            <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:2px;text-align:center;font-size:12;">ชื่อรถ/ทะเบียน</td>
            <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:2px;text-align:center;font-size:12;">สายงาน</td>
            <td colspan="32"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:12;">วันที่และเวลา</td>
            <td colspan="14"  rowspan="2" style="border-right:1px solid #000;padding:2px;text-align:center;font-size:12;">ชื่อพนักงาน</td>
            <td colspan="48" style="border-right:1px solid #000;padding:2px;text-align:center;font-size:12;"><b>เวลาพักผ่อน/ปฎิบัติงาน</b></td>


				</tr>

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        <tr style="border:1px solid #000;padding:2px;">
        <td colspan="18" rowspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">DATE</td>
        <td colspan="14" rowspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">TIME</td>

// TD ของเวลา
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">00:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">01:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">02:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">03:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">04:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">05:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">06:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">07:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">08:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">09:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">10:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">11:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">12:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">13:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">14:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">15:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">16:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">17:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">18:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">19:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">20:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">21:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">22:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">23:00</td>
       </tr>

//////////////////////////////////////////ลำดับที่1/////////////////////////////////////////////////////////////////////////////////////


       <tr style="border:1px solid #000;padding:2px;">
         <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">1</td>
         <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
// TD ของเวลา
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
      </tr>

      <tr style="border:1px solid #000;padding:2px;">


        <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

//// TD ของเวลา
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
     </tr>
     /////////////////////////////////////////////////////////////////////////////////////////////////////////
     <tr style="border:1px solid #000;padding:2px;">
            <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
     </tr>

    </thead>';
    $table1 = '<tbody>

    //////////////////////////////////////////ลำดับที่2/////////////////////////////////////////////////////////////////////////////////////


           <tr style="border:1px solid #000;padding:2px;">
             <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">2</td>
             <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
    // TD ของเวลา
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
          </tr>

          <tr style="border:1px solid #000;padding:2px;">


            <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

    //// TD ของเวลา
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         </tr>
         /////////////////////////////////////////////////////////////////////////////////////////////////////////
         <tr style="border:1px solid #000;padding:2px;">
                <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
         </tr>

         //////////////////////////////////////////ลำดับที่3/////////////////////////////////////////////////////////////////////////////////////


                <tr style="border:1px solid #000;padding:2px;">
                  <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">3</td>
                  <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
         // TD ของเวลา
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
               </tr>

               <tr style="border:1px solid #000;padding:2px;">


                 <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

         //// TD ของเวลา
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
              </tr>
              /////////////////////////////////////////////////////////////////////////////////////////////////////////
              <tr style="border:1px solid #000;padding:2px;">
                     <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
              </tr>

              //////////////////////////////////////////ลำดับที่4/////////////////////////////////////////////////////////////////////////////////////


                     <tr style="border:1px solid #000;padding:2px;">
                       <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">4</td>
                       <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
              // TD ของเวลา
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                    </tr>

                    <tr style="border:1px solid #000;padding:2px;">


                      <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

              //// TD ของเวลา
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                   </tr>
                   /////////////////////////////////////////////////////////////////////////////////////////////////////////
                   <tr style="border:1px solid #000;padding:2px;">
                          <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                   </tr>


                   //////////////////////////////////////////ลำดับที่5/////////////////////////////////////////////////////////////////////////////////////


                          <tr style="border:1px solid #000;padding:2px;">
                            <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">5</td>
                            <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                   // TD ของเวลา
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                         </tr>

                         <tr style="border:1px solid #000;padding:2px;">


                           <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                   //// TD ของเวลา
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                        </tr>
                        /////////////////////////////////////////////////////////////////////////////////////////////////////////
                        <tr style="border:1px solid #000;padding:2px;">
                               <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                        </tr>



                        //////////////////////////////////////////ลำดับที่6/////////////////////////////////////////////////////////////////////////////////////


                               <tr style="border:1px solid #000;padding:2px;">
                                 <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">6</td>
                                 <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                        // TD ของเวลา
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                              </tr>

                              <tr style="border:1px solid #000;padding:2px;">


                                <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                        //// TD ของเวลา
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                             </tr>
                             /////////////////////////////////////////////////////////////////////////////////////////////////////////
                             <tr style="border:1px solid #000;padding:2px;">
                                    <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                             </tr>



                             //////////////////////////////////////////ลำดับที่7/////////////////////////////////////////////////////////////////////////////////////


                                    <tr style="border:1px solid #000;padding:2px;">
                                      <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">7</td>
                                      <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                             // TD ของเวลา
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                   </tr>

                                   <tr style="border:1px solid #000;padding:2px;">


                                     <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                             //// TD ของเวลา
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                  </tr>
                                  /////////////////////////////////////////////////////////////////////////////////////////////////////////
                                  <tr style="border:1px solid #000;padding:2px;">
                                         <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                  </tr>



                                  //////////////////////////////////////////ลำดับที่8/////////////////////////////////////////////////////////////////////////////////////


                                         <tr style="border:1px solid #000;padding:2px;">
                                           <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">8</td>
                                           <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                                  // TD ของเวลา
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                        </tr>

                                        <tr style="border:1px solid #000;padding:2px;">


                                          <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                                  //// TD ของเวลา
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                       </tr>
                                       /////////////////////////////////////////////////////////////////////////////////////////////////////////
                                       <tr style="border:1px solid #000;padding:2px;">
                                              <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                       </tr>



                                       //////////////////////////////////////////ลำดับที่9/////////////////////////////////////////////////////////////////////////////////////


                                              <tr style="border:1px solid #000;padding:2px;">
                                                <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">9</td>
                                                <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                                       // TD ของเวลา
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                             </tr>

                                             <tr style="border:1px solid #000;padding:2px;">


                                               <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                                       //// TD ของเวลา
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                            </tr>
                                            /////////////////////////////////////////////////////////////////////////////////////////////////////////
                                            <tr style="border:1px solid #000;padding:2px;">
                                                   <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                            </tr>




                                            //////////////////////////////////////////ลำดับที่10/////////////////////////////////////////////////////////////////////////////////////


                                                   <tr style="border:1px solid #000;padding:2px;">
                                                     <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">10</td>
                                                     <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                                            // TD ของเวลา
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                  </tr>

                                                  <tr style="border:1px solid #000;padding:2px;">


                                                    <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                                            //// TD ของเวลา
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                 </tr>
                                                 /////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                 <tr style="border:1px solid #000;padding:2px;">
                                                        <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                 </tr>




                                                 //////////////////////////////////////////ลำดับที่11/////////////////////////////////////////////////////////////////////////////////////


                                                        <tr style="border:1px solid #000;padding:2px;">
                                                          <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">11</td>
                                                          <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                                                 // TD ของเวลา
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                       </tr>

                                                       <tr style="border:1px solid #000;padding:2px;">


                                                         <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                                                 //// TD ของเวลา
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                      </tr>
                                                      /////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                      <tr style="border:1px solid #000;padding:2px;">
                                                             <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                      </tr>




                                                      //////////////////////////////////////////ลำดับที่12/////////////////////////////////////////////////////////////////////////////////////


                                                             <tr style="border:1px solid #000;padding:2px;">
                                                               <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">12</td>
                                                               <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                                                      // TD ของเวลา
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                            </tr>

                                                            <tr style="border:1px solid #000;padding:2px;">


                                                              <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                                                      //// TD ของเวลา
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                           </tr>
                                                           /////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                           <tr style="border:1px solid #000;padding:2px;">
                                                                  <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                           </tr>




                                                           //////////////////////////////////////////ลำดับที่13/////////////////////////////////////////////////////////////////////////////////////


                                                                  <tr style="border:1px solid #000;padding:2px;">
                                                                    <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">13</td>
                                                                    <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                                                           // TD ของเวลา
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                 </tr>

                                                                 <tr style="border:1px solid #000;padding:2px;">


                                                                   <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                                                           //// TD ของเวลา
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                </tr>
                                                                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                <tr style="border:1px solid #000;padding:2px;">
                                                                       <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                                </tr>



                                                                //////////////////////////////////////////ลำดับที่14/////////////////////////////////////////////////////////////////////////////////////


                                                                       <tr style="border:1px solid #000;padding:2px;">
                                                                         <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">14</td>
                                                                         <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                                                                // TD ของเวลา
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                      </tr>

                                                                      <tr style="border:1px solid #000;padding:2px;">


                                                                        <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                                                                //// TD ของเวลา
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                     </tr>
                                                                     /////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                     <tr style="border:1px solid #000;padding:2px;">
                                                                            <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                                     </tr>



                                                                     //////////////////////////////////////////ลำดับที่15/////////////////////////////////////////////////////////////////////////////////////


                                                                            <tr style="border:1px solid #000;padding:2px;">
                                                                              <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">15</td>
                                                                              <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                                                                     // TD ของเวลา
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                           </tr>

                                                                           <tr style="border:1px solid #000;padding:2px;">


                                                                             <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                                                                     //// TD ของเวลา
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                          </tr>
                                                                          /////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                          <tr style="border:1px solid #000;padding:2px;">
                                                                                 <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                                          </tr>



                                                                          //////////////////////////////////////////ลำดับที่16/////////////////////////////////////////////////////////////////////////////////////


                                                                                 <tr style="border:1px solid #000;padding:2px;">
                                                                                   <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">16</td>
                                                                                   <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                                                                          // TD ของเวลา
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                </tr>

                                                                                <tr style="border:1px solid #000;padding:2px;">


                                                                                  <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                                                                          //// TD ของเวลา
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                               </tr>
                                                                               /////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                               <tr style="border:1px solid #000;padding:2px;">
                                                                                      <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                                               </tr>


    </tbody>';
    $table_footer1 = '<tfoot>

    </tfoot>
</table>';
/////////////////////////////////////////ADDPAGE2/////////////////////////////////////////////////////////////////////////////////////
$table2= '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:6;margin-top:6px;">
    <thead>
          <tr style="padding:2px;">
              <td colspan="116" style="padding:2px;text-align:center;font-size:18;text-align:center;"><b>เอกสารควบคุมการขับขี่ของพนักงานขนส่งยานยนต์ (สายไกล)</b></td>
          </tr>
          <tr style="padding:6px;">
              <td colspan="116" style="padding:2px;text-align:center;font-size:18;text-align:center;"></td>
          </tr><br>
          <tr style="padding:2px;">
              <td colspan="18" style="padding:2px;font-size:14;text-align:left">วันที่ '.$result_seSystime['SYSDATE'].'</td>
              <td colspan="50" style="padding:2px;font-size:20;text-align:left"><font color="red"><b>หน้า 2</b></font></td>
              <td colspan="46" style="padding:2px;font-size:10;text-align:center"><b>หมายเหตุ &nbsp;&nbsp;S=เริ่มออกจาก VL &nbsp;&nbsp;&nbsp;P=จอด&nbsp;&nbsp; E=จบการทำงาน&nbsp;&nbsp; DL=ดีลเลอร์</b></td>
          </tr>
        <tr style="border:1px solid #000;padding:2px;">
            <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:2px;text-align:center;font-size:12;">ลำดับ</td>
            <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:2px;text-align:center;font-size:12;">เบอร์รถ</td>
            <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:2px;text-align:center;font-size:12;">งาน</td>
            <td colspan="32"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:12;">ETA(dealer)</td>
            <td colspan="14"  rowspan="2" style="border-right:1px solid #000;padding:2px;text-align:center;font-size:12;">พชร</td>
            <td colspan="48" style="border-right:1px solid #000;padding:2px;text-align:center;font-size:12;"><b>สถานะการขับขี่</b></td>


				</tr>

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        <tr style="border:1px solid #000;padding:2px;">
        <td colspan="18" rowspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">DATE</td>
        <td colspan="14" rowspan="1" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">TIME</td>

// TD ของเวลา
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">00:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">01:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">02:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">03:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">04:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">05:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">06:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">07:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">08:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">09:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">10:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">11:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">12:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">13:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">14:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">15:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">16:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">17:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">18:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">19:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">20:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">21:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">22:00</td>
          <td colspan="2"  style="border-right:1px solid #000;padding:2px;text-align:center;font-size:10;">23:00</td>
       </tr>

//////////////////////////////////////////ลำดับที่17/////////////////////////////////////////////////////////////////////////////////////


       <tr style="border:1px solid #000;padding:2px;">
         <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">17</td>
         <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
// TD ของเวลา
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
      </tr>

      <tr style="border:1px solid #000;padding:2px;">


        <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

//// TD ของเวลา
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
     </tr>
     /////////////////////////////////////////////////////////////////////////////////////////////////////////
     <tr style="border:1px solid #000;padding:2px;">
            <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
     </tr>

    </thead>';
    $table3 = '<tbody>

    //////////////////////////////////////////ลำดับที่18/////////////////////////////////////////////////////////////////////////////////////


           <tr style="border:1px solid #000;padding:2px;">
             <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">18</td>
             <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
    // TD ของเวลา
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
             <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
          </tr>

          <tr style="border:1px solid #000;padding:2px;">


            <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

    //// TD ของเวลา
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
         </tr>
         /////////////////////////////////////////////////////////////////////////////////////////////////////////
         <tr style="border:1px solid #000;padding:2px;">
                <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
         </tr>

         //////////////////////////////////////////ลำดับที่19/////////////////////////////////////////////////////////////////////////////////////


                <tr style="border:1px solid #000;padding:2px;">
                  <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">19</td>
                  <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
         // TD ของเวลา
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                  <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
               </tr>

               <tr style="border:1px solid #000;padding:2px;">


                 <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

         //// TD ของเวลา
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
              </tr>
              /////////////////////////////////////////////////////////////////////////////////////////////////////////
              <tr style="border:1px solid #000;padding:2px;">
                     <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
              </tr>

              //////////////////////////////////////////ลำดับที่20/////////////////////////////////////////////////////////////////////////////////////

                     <tr style="border:1px solid #000;padding:2px;">
                       <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">20</td>
                       <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
              // TD ของเวลา
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                       <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                    </tr>

                    <tr style="border:1px solid #000;padding:2px;">


                      <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

              //// TD ของเวลา
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                   </tr>
                   /////////////////////////////////////////////////////////////////////////////////////////////////////////
                   <tr style="border:1px solid #000;padding:2px;">
                          <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                   </tr>

//////////////////////////////////////////ลำดับที่21/////////////////////////////////////////////////////////////////////////////////////


                          <tr style="border:1px solid #000;padding:2px;">
                            <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">21</td>
                            <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                   // TD ของเวลา
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                            <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                         </tr>

                         <tr style="border:1px solid #000;padding:2px;">


                           <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                   //// TD ของเวลา
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                        </tr>
                        /////////////////////////////////////////////////////////////////////////////////////////////////////////
                        <tr style="border:1px solid #000;padding:2px;">
                               <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                        </tr>



                        //////////////////////////////////////////ลำดับที่22/////////////////////////////////////////////////////////////////////////////////////


                               <tr style="border:1px solid #000;padding:2px;">
                                 <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">22</td>
                                 <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                        // TD ของเวลา
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                 <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                              </tr>

                              <tr style="border:1px solid #000;padding:2px;">


                                <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                        //// TD ของเวลา
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                             </tr>
                             /////////////////////////////////////////////////////////////////////////////////////////////////////////
                             <tr style="border:1px solid #000;padding:2px;">
                                    <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                             </tr>



                             //////////////////////////////////////////ลำดับที่23/////////////////////////////////////////////////////////////////////////////////////


                                    <tr style="border:1px solid #000;padding:2px;">
                                      <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">23</td>
                                      <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                             // TD ของเวลา
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                      <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                   </tr>

                                   <tr style="border:1px solid #000;padding:2px;">


                                     <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                             //// TD ของเวลา
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                  </tr>
                                  /////////////////////////////////////////////////////////////////////////////////////////////////////////
                                  <tr style="border:1px solid #000;padding:2px;">
                                         <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                  </tr>



                                  //////////////////////////////////////////ลำดับที่24/////////////////////////////////////////////////////////////////////////////


                                         <tr style="border:1px solid #000;padding:2px;">
                                           <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">24</td>
                                           <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                                  // TD ของเวลา
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                           <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                        </tr>

                                        <tr style="border:1px solid #000;padding:2px;">


                                          <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                                  //// TD ของเวลา
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                       </tr>
                                       /////////////////////////////////////////////////////////////////////////////////////////////////////////
                                       <tr style="border:1px solid #000;padding:2px;">
                                              <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                       </tr>



                                       //////////////////////////////////////////ลำดับที่25/////////////////////////////////////////////////////////////////////////////////////


                                              <tr style="border:1px solid #000;padding:2px;">
                                                <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">25</td>
                                                <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                                       // TD ของเวลา
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                             </tr>

                                             <tr style="border:1px solid #000;padding:2px;">


                                               <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                                       //// TD ของเวลา
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                            </tr>
                                            /////////////////////////////////////////////////////////////////////////////////////////////////////////
                                            <tr style="border:1px solid #000;padding:2px;">
                                                   <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                            </tr>




                                            //////////////////////////////////////////ลำดับที่26/////////////////////////////////////////////////////////////////////////////////////


                                                   <tr style="border:1px solid #000;padding:2px;">
                                                     <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">26</td>
                                                     <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                                            // TD ของเวลา
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                     <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                  </tr>

                                                  <tr style="border:1px solid #000;padding:2px;">


                                                    <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                                            //// TD ของเวลา
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                 </tr>
                                                 /////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                 <tr style="border:1px solid #000;padding:2px;">
                                                        <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                 </tr>




                                                 //////////////////////////////////////////ลำดับที่27/////////////////////////////////////////////////////////////////////////////////////


                                                        <tr style="border:1px solid #000;padding:2px;">
                                                          <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">27</td>
                                                          <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                                                 // TD ของเวลา
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                          <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                       </tr>

                                                       <tr style="border:1px solid #000;padding:2px;">


                                                         <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                                                 //// TD ของเวลา
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                      </tr>
                                                      /////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                      <tr style="border:1px solid #000;padding:2px;">
                                                             <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                      </tr>




                                                      //////////////////////////////////////////ลำดับที่28/////////////////////////////////////////////////////////////////////////////////////


                                                             <tr style="border:1px solid #000;padding:2px;">
                                                               <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">28</td>
                                                               <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                                                      // TD ของเวลา
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                               <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                            </tr>

                                                            <tr style="border:1px solid #000;padding:2px;">


                                                              <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                                                      //// TD ของเวลา
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                              <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                           </tr>
                                                           /////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                           <tr style="border:1px solid #000;padding:2px;">
                                                                  <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                           </tr>




                                                           //////////////////////////////////////////ลำดับที่29/////////////////////////////////////////////////////////////////////////////////////


                                                                  <tr style="border:1px solid #000;padding:2px;">
                                                                    <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">29</td>
                                                                    <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                                                           // TD ของเวลา
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                    <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                 </tr>

                                                                 <tr style="border:1px solid #000;padding:2px;">


                                                                   <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                                                           //// TD ของเวลา
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                   <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                </tr>
                                                                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                <tr style="border:1px solid #000;padding:2px;">
                                                                       <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                                </tr>



                                                                //////////////////////////////////////////ลำดับที่30/////////////////////////////////////////////////////////////////////////////////////


                                                                       <tr style="border:1px solid #000;padding:2px;">
                                                                         <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;">30</td>
                                                                         <td colspan="6" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="18" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="14" rowspan="2" style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>
                                                                // TD ของเวลา
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                         <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                      </tr>

                                                                      <tr style="border:1px solid #000;padding:2px;">


                                                                        <td colspan="14"  style="border-right:1px solid #000;padding:10px;text-align:center;font-size:10;"></td>

                                                                //// TD ของเวลา
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                        <td colspan="2"  style="border-right:1px solid #000;padding:8px;text-align:center;font-size:10;"></td>
                                                                     </tr>
                                                                     /////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                     <tr style="border:1px solid #000;padding:2px;">
                                                                            <td colspan="116" bgcolor="#CCCCCC"  style="border-right:1px solid #000;padding:4px;text-align:center;font-size:10;"></td>
                                                                     </tr>
                                              </tbody>';

    $table_footer2 = '<tfoot>

    </tfoot>
</table>';

/////////////////////////////////////////ADDPAGE2/////////////////////////////////////////////////////////////////////////////////////
$table4= '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:6;margin-top:4px;">
    <thead>
    <tr style="padding:2px;">
          <td colspan="116" style="padding:2px;text-align:center;font-size:18;text-align:center;hidden"></td>
    </tr>
    <tr style="padding:2px;">
          <td colspan="116" style="padding:2px;text-align:center;font-size:18;text-align:center;hidden"></td>
    </tr>

    <tr style="border:1px solid #FFF;padding:2px;">
           <td colspan="13"  rowspan="1" style="border:1px solid  #FFF;padding:4px;text-align:right;font-size:10;"></td>
           <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:left;font-size:10;">&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;บันทึกเปลี่ยนกะ Day</td>
           <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:left;font-size:10;"></td>
           <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:left;font-size:10;"></td>
           <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:left;font-size:10;"></td>
           <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:left;font-size:10;"></td>
    </tr>
    <tr style="border:1px solid #FFF;padding:2px;">
            <td colspan="16"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:left;font-size:10;"></td>
            <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:left;font-size:10;">.................................................................................................................................................................</td>
            <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10;"></td>
            <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10;"></td>
            <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10;"></td>
            <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10;"></td>
    </tr>
    <tr style="border:1px solid #FFF;padding:2px;">
           <td colspan="16"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:left;font-size:10;"></td>
           <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:left;font-size:10;">.................................................................................................................................................................</td>
           <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10;">.............................................</td>
           <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10;">.............................................</td>
           <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10;">.............................................</td>
           <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10;">.............................................</td>
    </tr>
    <tr style="border:1px solid #FFF;padding:2px;">
            <td colspan="16"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:left;font-size:10;"></td>
            <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:left;font-size:10;">บันทึกเปลี่ยนกะ  Night </td>
            <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10;">(.............................................)</td>
            <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10;">(.............................................)</td>
            <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10;">(.............................................)</td>
            <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10;">(นายบัญชา   กงแก้ว)</td>
    </tr>
    <tr style="border:1px solid #FFF;padding:2px;">
            <td colspan="16"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:left;font-size:10;"></td>
            <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:left;font-size:10;">................................................................................................................................................................</td>
            <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10;">เจ้าหน้าที่ GPS (Day)</td>
            <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10;">เจ้าหน้าที่ GPS (Night)</td>
            <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10;">เจ้าหน้าที่อาวุโส</td>
            <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10;">ผู้จัดการ SQ-Training</td>
    </tr>
    <tr style="border:1px solid #FFF;padding:2px;">
           <td colspan="16"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10">มีผลบังคับใช้ : 01-01-61</td>
           <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:left;font-size:10;">.................................................................................................................................................................</td>
           <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10;">วันที่....'.date("d").'..../.....'.date("m").'..../....'.date("Y").'....</td>
           <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10;">วันที่....'.date("d").'..../.....'.date("m").'..../....'.date("Y").'....</td>
           <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10;">วันที่....'.date("d").'..../.....'.date("m").'..../....'.date("Y").'....</td>
           <td colspan="20"   rowspan="1" style="border:1px solid #FFF;padding:4px;text-align:center;font-size:10;">วันที่....'.date("d").'..../.....'.date("m").'..../....'.date("Y").'....</td>
    </tr>


    </thead>';
    $table5 = '<tbody>



              </tbody>';

    $table_footer3 = '<tfoot>

    </tfoot>
</table>';


$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table0);
$mpdf->WriteHTML($table1);
$mpdf->WriteHTML($table_footer1);
$mpdf->AddPage();
$mpdf->WriteHTML($table2);
$mpdf->WriteHTML($table3);
$mpdf->WriteHTML($table_footer2);
$mpdf->WriteHTML($table4);
$mpdf->WriteHTML($table5);
$mpdf->WriteHTML($table_footer3);

// $mpdf->AddPage();
// $mpdf->WriteHTML($table4);
// $mpdf->WriteHTML($table5);
// $mpdf->WriteHTML($table_footer3);
$mpdf->Output();
sqlsrv_close($conn);
?>
