<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('display_errors', 0);
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานเวลาปฏิบัติงาน.xls";
} else {
    $strExcelFileName = "รายงานเวลาปฏิบัติงาน" . $_GET['startdate'] . ' ถึง ' . $_GET['enddate'] . ".xls";
}


header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");
?>
<html>
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
      <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
        <thead>
        <tr>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">ลำดับ</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">ไอดีแจ้งสุขภาพ</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">รหัสพนักงาน</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">ชื่อ - นามสกุล</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">ต้นทาง</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">ปลายทาง</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">วันที่</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">เวลาเริ่มงาน</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">เวลาเลิกงาน</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">รวมเวลาปฎิบัติงาน</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">หมายเหตุ(ทำงานเกิน 14 ชม.)</th>
        </tr>
        </thead>
        <tbody>
          <?php
            $i = 1;
            if ($_GET['companycode'] == '00') {
                # 00 คือ บริษัททั้งหมด RKS,RKR,RKL
                $sql_seData = "SELECT a.SELFCHECKID,a.EMPLOYEECODE,a.EMPLOYEENAME,a.DATEWORKING,
                    REPLACE(a.SLEEPRESTEND, 'T', ' ') AS 'DATETIMESTARTWORKING',
                    REPLACE(a.KEYDROPTIME, 'T', ' ') AS 'DATETIMEENDWORKING',
                    a.TIMEWORKING,a.TIMEWORKINGSTATUS,b.PositionNameT,a.TIMEWORKINGDATANG
                    FROM DRIVERSELFCHECK a 
                    INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a.EMPLOYEECODE
                    WHERE   SUBSTRING(a.EMPLOYEECODE, 0, 3) IN ('04','05','09')
                    AND CONVERT(DATE,DATEWORKING,103) BETWEEN CONVERT(DATE,'".$_GET['startdate']."',103) AND CONVERT(DATE,'".$_GET['enddate']."',103)
                    ORDER BY CONVERT(DATE,a.DATEWORKING,103),a.EMPLOYEECODE,b.PositionNameT ASC";

            }else{
                $sql_seData = "SELECT a.SELFCHECKID,a.EMPLOYEECODE,a.EMPLOYEENAME,a.DATEWORKING,
                    REPLACE(a.SLEEPRESTEND, 'T', ' ') AS 'DATETIMESTARTWORKING',
                    REPLACE(a.KEYDROPTIME, 'T', ' ') AS 'DATETIMEENDWORKING',
                    a.TIMEWORKING,a.TIMEWORKINGSTATUS,b.PositionNameT,a.TIMEWORKINGDATANG
                    FROM DRIVERSELFCHECK a 
                    INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a.EMPLOYEECODE
                    WHERE   SUBSTRING(a.EMPLOYEECODE, 0, 3) ='".$_GET['companycode']."'
                    AND CONVERT(DATE,DATEWORKING,103) BETWEEN CONVERT(DATE,'".$_GET['startdate']."',103) AND CONVERT(DATE,'".$_GET['enddate']."',103)
                    ORDER BY CONVERT(DATE,a.DATEWORKING,103),a.EMPLOYEECODE,b.PositionNameT ASC";


            }

            
            
            $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
            while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)) {          
                
            

            //ค้นหาข้อมูลแผนงานประจำวันที่นั้นๆ แผนงานแรก
            $sql_seRoute1 = "SELECT TOP 1 JOBNO,JOBSTART,JOBEND FROM VEHICLETRANSPORTPLAN 
            WHERE CONVERT(DATE,DATEWORKING,103) = CONVERT(DATE,'".$result_seData['DATEWORKING']."',103)
            AND (EMPLOYEECODE1 ='".$result_seData['EMPLOYEECODE']."' OR EMPLOYEECODE2 ='".$result_seData['EMPLOYEECODE']."' )
            ORDER BY JOBNO ASC";
            $query_seRoute1 = sqlsrv_query($conn, $sql_seRoute1, $params_seRoute1);
            $result_seRoute1 = sqlsrv_fetch_array($query_seRoute1, SQLSRV_FETCH_ASSOC);
            
            
              //ค้นหาข้อมูลแผนงานประจำวันที่นั้นๆ แผนงานที่สอง
            // $sql_seRoute2 = "SELECT TOP 1 JOBNO,JOBSTART,JOBEND FROM VEHICLETRANSPORTPLAN 
            // WHERE  CONVERT(DATE,DATEWORKING,103) = CONVERT(DATE,'".$result_seData['DATEWORKING']."',103)
            // AND (EMPLOYEECODE1 ='".$result_seData['EMPLOYEECODE']."' OR EMPLOYEECODE2 ='".$result_seData['EMPLOYEECODE']."' )
            // ORDER BY JOBNO DESC";
            // $query_seRoute2 = sqlsrv_query($conn, $sql_seRoute2, $params_seRoute2);
            // $result_seRoute2 = sqlsrv_fetch_array($query_seRoute2, SQLSRV_FETCH_ASSOC);

            

            

            ?>
            

              <tr>
                <td style="text-align: center;border: 1px solid #000000;"><?=$i?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['SELFCHECKID']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['EMPLOYEECODE']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['EMPLOYEENAME']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seRoute1['JOBSTART']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seRoute1['JOBEND']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['DATEWORKING']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['DATETIMESTARTWORKING']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['DATETIMEENDWORKING']?></td> 
                <?php
                if ($result_seData['TIMEWORKINGSTATUS'] == 'OK') {
                ?>
                <td style="background-color: #94FA67;text-align: center;border: 1px solid #000000;"><?=$result_seData['TIMEWORKING']?></td>
                <?php
                }else if ($result_seData['TIMEWORKINGSTATUS'] == 'NG'){
                ?>
                <td style="background-color: #FA9167;text-align: center;border: 1px solid #000000;"><?=$result_seData['TIMEWORKING']?></td>
                <?php
                }else{
                ?>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['TIMEWORKING']?></td>
                <?php
                }
                ?>
                 <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['TIMEWORKINGDATANG']?></td> 
              </tr>
              
            <?php
            $i++;

            // if ($intervalemp1->format('%R') == '-' && $result_seTimeInOutEmp1['DATEINOUT'] != '') {
            //   $intimeemp1 = $intimeemp1+1;
            // }if ($intervalemp1->format('%R') == '+' && $result_seTimeInOutEmp1['DATEINOUT'] != '') {
            //   $overtimeemp1 = $overtimeemp1+1;
            // }else {
              
            // }
    
            // echo $intimeemp1;
            // echo $overtimeemp1;

            // if ($intervalemp2->format('%R') == '-' && $result_seTimeInOutEmp2['DATEINOUT'] != '') {
            //   $intimeemp2 = $intimeemp2+1;
            // }if ($intervalemp1->format('%R') == '+' && $result_seTimeInOutEmp2['DATEINOUT'] != '') {
            //   $overtimeemp2 = $overtimeemp2+1;
            // }else {
              
            // }

            // echo $intimeemp2;
            // echo $overtimeemp2;

          }
          ?>
        
        </tbody>
        <!-- <tfoot>
              <tr>
              <td colspan="1" style="text-align: center;border: 1px solid #000000;background-color: #B3B1B0">จำนวนแผนงาน</td>
              <td colspan="1" style="text-align: center;border: 1px solid #000000;background-color: #B3B1B0"><?=$result_seCountPlan['COUNTPLAN']?></td>
              <td colspan="1" style="text-align: center;border: 1px solid #000000;background-color: #B3B1B0">จำนวนพนักงานที่วิ่งงาน</td>
              <td colspan="1" style="text-align: center;border: 1px solid #000000;background-color: #B3B1B0"><?=$result_seCountEmp['COUNTEMPLOYEEDIS']?></td>
              <td colspan="1" style="text-align: center;border: 1px solid #000000;background-color: #B3B1B0">จำนวนพนักงานที่มารายงานตัว</td>
              <td colspan="1" style="text-align: center;border: 1px solid #000000;background-color: #B3B1B0"><?=$empintime1+$empintime2?></td> 
              <td colspan="1" style="text-align: center;border: 1px solid #000000;background-color: #B3B1B0">จำนวนพนักงานที่ยังไม่มารายงานตัว</td>
              <td colspan="1" style="text-align: center;border: 1px solid #000000;background-color: #B3B1B0"><?=$emplate1+$emplate2?></td>    
              </tr>
          </tfoot> -->
      </table>
    </body>
    
</html>
