<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานแผนการวิ่งงาน.xls";
} else {
    $strExcelFileName = "รายงานแผนการวิ่งงานตั้งแต่วันที่" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
}


  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
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
              <th>ลำดับ</th>
              <th>วันที่</th>
              <th>บริษัท</th>
              <th>ทะเบียน</th>
              <th>ประเภทรถ</th>
              <th>ต้นทาง</th>
              <th>คลัสเตอร์</th>
              <th>ปลายทาง</th>
              <th>พขร.1</th>
              <th>พขร.2</th>
              <th>เลขไมค์ต้น</th>
              <th>เลขไมค์ปลาย</th>
              <th>กิโลเมตรที่วิ่งงาน</th>
              <th>เลขที่แผนงาน</th>
              <th>จำนวนเที่ยว</th>
              <th>จำนวนยูนิต</th>
              <th>หมายเหตุ</th>
          </tr>
        </thead>
        <tbody>
       <?php
       //เช็คข้อมูลทะเบียนรถ
       $sql_checkthainame = "SELECT VEHICLEREGISNUMBER,THAINAME 
                            FROM VEHICLEINFO WHERE VEHICLEREGISNUMBER ='".$_GET['thainame']."'";
       $query_checkthainame  = sqlsrv_query($conn, $sql_checkthainame, $params_checkthainame);
       $result_checkthainame = sqlsrv_fetch_array($query_checkthainame, SQLSRV_FETCH_ASSOC);
       

       $i = 1;
       $count = 0;
       if($_GET['check'] == 'driverandthaiisnull'){
          $sql_seReporttransport = "SELECT CONVERT(VARCHAR(10),a.DATEWORKING,103) AS 'DATE',a.VEHICLETRANSPORTPLANID,a.JOBNO,
                a.CUSTOMERCODE,a.COMPANYCODE,a.THAINAME,a.THAINAME2,a.VEHICLETYPE,
                a.CLUSTER,a.JOBSTART,a.JOBEND,a.EMPLOYEECODE1,a.EMPLOYEENAME1,a.EMPLOYEECODE2,a.EMPLOYEENAME2,
                a.VEHICLETRANSPORTPRICEID,b.CARRYTYPE,[STATUS],STATUSNUMBER
                FROM  [dbo].[VEHICLETRANSPORTPLAN] a
                INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] b ON a.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
                WHERE CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
                ORDER BY a.COMPANYCODE,a.JOBNO,a.DATEWORKING ASC";
          $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport, $params_seReporttransport);
       }else if($_GET['check'] == 'driverisnull'){
            // $test = "driver";
            $sql_seReporttransport = "SELECT CONVERT(VARCHAR(10),a.DATEWORKING,103) AS 'DATE',a.VEHICLETRANSPORTPLANID,a.JOBNO,
                a.CUSTOMERCODE,a.COMPANYCODE,a.THAINAME,a.THAINAME2,a.VEHICLETYPE,
                a.CLUSTER,a.JOBSTART,a.JOBEND,a.EMPLOYEECODE1,a.EMPLOYEENAME1,a.EMPLOYEECODE2,
                a.EMPLOYEENAME2,a.VEHICLETRANSPORTPRICEID,b.CARRYTYPE,[STATUS],STATUSNUMBER
                FROM  [dbo].[VEHICLETRANSPORTPLAN] a
                INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] b ON a.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
                WHERE (a.THAINAME ='".$result_checkthainame['THAINAME']."' OR a.THAINAME ='".$result_checkthainame['VEHICLEREGISNUMBER']."'  OR a.THAINAME2 ='".$_GET['thainame']."')
                AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
                ORDER BY a.COMPANYCODE,a.JOBNO,a.DATEWORKING ASC";
            $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport, $params_seReporttransport);
        }else if ($_GET['check'] == 'thainameisnull') {
            // $test = "thainame";
            $sql_seReporttransport = "SELECT CONVERT(VARCHAR(10),DATEWORKING,103) AS 'DATE',VEHICLETRANSPORTPLANID,JOBNO,VEHICLETRANSPORTPRICEID,
            CUSTOMERCODE,COMPANYCODE,THAINAME,THAINAME2,VEHICLETYPE,
            CLUSTER,JOBSTART,JOBEND,EMPLOYEECODE1,EMPLOYEENAME1,EMPLOYEECODE2,EMPLOYEENAME2 
            FROM  [dbo].[VEHICLETRANSPORTPLAN] 
            WHERE (EMPLOYEECODE1 ='".$_GET['drivername']."' OR EMPLOYEECODE2 = '".$_GET['drivername']."')
            AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
            ORDER BY COMPANYCODE,JOBNO,DATEWORKING ASC";
            $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport, $params_seReporttransport);
        }else{
            // $test = "complete";
            $sql_seReporttransport = "SELECT CONVERT(VARCHAR(10),a.DATEWORKING,103) AS 'DATE',a.VEHICLETRANSPORTPLANID,a.JOBNO,
                a.CUSTOMERCODE,a.COMPANYCODE,a.THAINAME,a.THAINAME2,a.VEHICLETYPE,
                a.CLUSTER,a.JOBSTART,a.JOBEND,a.EMPLOYEECODE1,a.EMPLOYEENAME1,a.EMPLOYEECODE2,a.EMPLOYEENAME2,
                a.VEHICLETRANSPORTPRICEID,b.CARRYTYPE,[STATUS],STATUSNUMBER
                FROM  [dbo].[VEHICLETRANSPORTPLAN]  a
                INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] b ON a.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
                WHERE (a.EMPLOYEECODE1 ='".$_GET['drivername']."' OR a.EMPLOYEECODE2 = '".$_GET['drivername']."')
                AND (a.THAINAME ='".$result_checkthainame['THAINAME']."' OR a.THAINAME ='".$result_checkthainame['VEHICLEREGISNUMBER']."')
                AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
                ORDER BY a.COMPANYCODE,a.JOBNO,a.DATEWORKING ASC";
            $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport, $params_seReporttransport);
        }
       while ($result_seReporttransport = sqlsrv_fetch_array($query_seReporttransport, SQLSRV_FETCH_ASSOC)) {

            // หาข้อมูล Mileage แบบเดิม 
            //ไมล์ต้น
              // $sql_mileagestart = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGESTART',JOBNO 
              // FROM MILEAGE_SUMMARY WHERE JOBNO ='".$result_seReporttransport['JOBNO']."'
              // AND MILEAGETYPE ='MILEAGESTART'
              // ORDER BY CREATEDATE DESC";
              // $query_mileagestart  = sqlsrv_query($conn, $sql_mileagestart, $params_mileagestart);
              // $result_mileagestart = sqlsrv_fetch_array($query_mileagestart, SQLSRV_FETCH_ASSOC);    
            //ไมล์ปลาย
              // $sql_mileageend = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGEEND',JOBNO 
              // FROM MILEAGE_SUMMARY WHERE JOBNO ='".$result_seReporttransport['JOBNO']."'
              // AND MILEAGETYPE ='MILEAGEEND'
              // ORDER BY CREATEDATE DESC";
              // $query_mileageend  = sqlsrv_query($conn, $sql_mileageend, $params_mileageend);
              // $result_mileageend = sqlsrv_fetch_array($query_mileageend, SQLSRV_FETCH_ASSOC);    


            // หาข้อมูล Mileage แบบใหม่
            $sql_semileage = "SELECT TOP 1 MILEAGESTART,MILEAGEEND,JOBNO 
            FROM MILEAGE_SUMMARY WHERE JOBNO ='".$result_seReporttransport['JOBNO']."'
            ORDER BY CREATEDATE DESC";
            $query_semileage  = sqlsrv_query($conn, $sql_semileage, $params_semileage);
            $result_semileage = sqlsrv_fetch_array($query_semileage, SQLSRV_FETCH_ASSOC);
        
            if ($result_seReporttransport['CARRYTYPE'] == 'trip') {
                $sql_sumtrip = "SELECT SUM(CONVERT(INT,a.TRIPAMOUNT)) AS 'SUM' 
                  FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                  WHERE VEHICLETRANSPORTPLANID ='".$result_seReporttransport['VEHICLETRANSPORTPLANID']."'";
                $params_sumtrip  = array();
                $query_sumtrip  = sqlsrv_query($conn, $sql_sumtrip, $params_sumtrip);
                $result_sumtrip  = sqlsrv_fetch_array($query_sumtrip, SQLSRV_FETCH_ASSOC);
            }else{
              $sql_sumtrip = "SELECT SUM(CONVERT(INT,a.WEIGHTIN)) AS 'SUM' 
                FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
                WHERE VEHICLETRANSPORTPLANID ='".$result_seReporttransport['VEHICLETRANSPORTPLANID']."'";
              $params_sumtrip  = array();
              $query_sumtrip  = sqlsrv_query($conn, $sql_sumtrip, $params_sumtrip);
              $result_sumtrip  = sqlsrv_fetch_array($query_sumtrip, SQLSRV_FETCH_ASSOC);
            }
            
            
            
            


            

             ?>

             <tr>
               <!-- <td style="text-align: center"><?=$test?></td>   -->
               <td style="text-align: center"><?=$i?></td>
               <td><?=$result_seReporttransport['DATE']?></td>
               <td><?=$result_seReporttransport['COMPANYCODE']?></td>
               <td><?=$result_seReporttransport['THAINAME']?></td>
               <td><?=$result_seReporttransport['VEHICLETYPE']?></td>
               <td><?=$result_seReporttransport['JOBSTART']?></td>
               <td><?=$result_seReporttransport['CLUSTER']?></td>
               <td><?=$result_seReporttransport['JOBEND']?></td>
               <td><?=$result_seReporttransport['EMPLOYEENAME1']?></td>
               <td><?=$result_seReporttransport['EMPLOYEENAME2']?></td>
               <td><?=$result_semileage['MILEAGESTART']?></td>
               <td><?=$result_semileage['MILEAGEEND']?></td>
               <td style="text-align: center"><?=$result_semileage['MILEAGEEND']-$result_semileage['MILEAGESTART']?></td>
               <td><?=$result_seReporttransport['JOBNO']?></td>
               <td style="text-align: center">1</td>
               <td style="text-align: center"><?=$result_sumtrip['SUM']?></td>
               <td style="text-align: center"><?=$result_seReporttransport['STATUS']?></td>
             </tr>
             <?php
             $i++;
             $count++;
             $sumunit = $sumunit + $result_sumtrip['SUM'];
           }
           
           ?>
         </tbody>
         <tfoot>
  <tr>

    <td colspan="1"     style="text-align:center"></td>
    <td colspan="1"     style="text-align:center"></td>
    <td colspan="1"     style="text-align:center"></td>
    <td colspan="1"     style="text-align:center"></td>
    <td colspan="1"     style="text-align:center"></td>
    <td colspan="1"     style="text-align:center"></td>
    <td colspan="1"     style="text-align:center"></td>
    <td colspan="1"     style="text-align:center"></td>
    <td colspan="1"     style="text-align:center"></td>
    <td colspan="1"     style="text-align:center"></td>
    <td colspan="1"     style="text-align:center"></td>
    <td colspan="1"     style="text-align:center"></td>
    <td colspan="1"     style="text-align:center">รวม</td>
    <td colspan="1"     style="text-align:center"><?=$count?></td>
    <td colspan="1"     style="text-align:center"><?=$sumunit?></td>
</tr>

</tfoot>
      </table>
    </body>
    
</html>
