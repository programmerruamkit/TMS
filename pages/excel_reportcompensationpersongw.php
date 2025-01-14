<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานค่าเที่ยวบุคคล.xls";
} else {
    $strExcelFileName = "รายงานค่าเที่ยวบุคคลตั้งแต่วันที่" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
}


  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: inline; filename=\"$strExcelFileName\"");

  if ($_GET['companycode'] == 'RCC') {
    $companyname = 'บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์';
  }else if ($_GET['companycode'] == 'RRC') {
    $companyname = 'บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต';
  }else {
    $companyname = '';
  }
?>
<html>
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style>
          table, th, td {
          border: 1px solid black;
          }
        </style>
    </head>
    <body>
    <table style="width: 100%;">
      <thead>
      <tr>
        <td colspan="22" style="text-align:center;font-size: 20px;border: 1px solid black;"><b><?=$companyname?></b></td>
      </thead>
      <tbody>
        <tr>
          <td colspan="22" style="text-align:center;font-size: 15px;border: 1px solid black;"><b>ค่าเที่ยว วันที่ <?=$_GET['datestart']?> ถึง <?=$_GET['dateend']?></b></td>
        </tr>
        
      </tbody>
    </table>
      <table width="100%"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
        <thead>
          <tr>
            <th>ลำดับ</th>
            <th>วันที่</th>
            <th>รหัสพนักงาน</th>
            <th>ชื่อ-สกุล</th>
            <th>คลัสเตอร์</th>
            <th>ต้นทาง</th>
            <th>ปลายทาง</th>
            <th>ทะเบียนรถ</th>
            <th>ค่าเที่ยวปกติ</th>
            <!-- <th>ค่าตีเปล่า</th> -->
            <th>รับงานรอบ 2 (4L)</th>
            <th>ลง 3 ดีลเลอร์ (4L)</th>
            <th>รองาน (4L)</th>
            <th>ตีเปล่าบ้านโพธิ์/สำโรง (4L)</th>
            <th>วิ่ง SH เที่ยวเดียว (4L)</th>
            <th>ลง 4 ดีลเลอร์ (8L)(วิ่งคู่หาร 2)</th>
            <th>วิ่ง SH 50% ค่าเที่ยว (8L)</th>
            <th>ลง 4 ดีลเลอร์ (8L)(วิ่งคนเดียว)</th>
            <th>OT วันหยุด</th>
            <th>รวม</th>
            <th>OT 1.5 เท่า</th>
            <!-- <th>รายได้อื่นๆ</th> -->
            <th>รวมรับสุทธิ</th>
            <th>หมายเหตุ</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;

            if ($_GET['companycode'] == 'RCC') {
              $sql_sedriverchk = "SELECT ROW_NUMBER() OVER (PARTITION BY c.EMPCODE
                ORDER BY CONVERT(VARCHAR(30), c.DATEWORKING, 103),c.JOBNO ASC) AS 'ROWNUM' ,c.DATEWORKING AS 'DATEWORKING',
                c.EMPCODE AS 'EMPCODE',c.EMPNAME AS 'EMPNAME',c.JOBNO AS 'JOBNO' ,c.PLANID AS 'PLANID',
                c.JOBSTART AS 'JOBSTART',c.CLUSTER AS 'CLUSTER',c.JOBEND AS 'JOBEND',c.THAINAME AS 'THAINAME'
                FROM
                (SELECT DISTINCT CONVERT(VARCHAR(30), a.DATEWORKING, 103) AS 'DATEWORKING',a.EMPLOYEECODE1 AS 'EMPCODE',
                a.EMPLOYEENAME1 AS 'EMPNAME',a.JOBNO AS 'JOBNO',a.VEHICLETRANSPORTPLANID AS 'PLANID',
                a.JOBSTART AS 'JOBSTART',a.CLUSTER AS 'CLUSTER',a.JOBEND AS 'JOBEND',a.THAINAME AS 'THAINAME'
                FROM [dbo].[VEHICLETRANSPORTPLAN] a
                WHERE a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
                AND a.DOCUMENTCODE IS NOT NULL
                AND a.DOCUMENTCODE !=''
                AND (a.EMPLOYEECODE1 IS NOT NULL OR a.EMPLOYEECODE1 !='') 
                AND CONVERT(DATETIME,a.DATEWORKING) BETWEEN CONVERT(DATETIME,'".$_GET['datestart']."',103) AND CONVERT(DATETIME,'".$_GET['dateend']."',103)
                AND SUBSTRING(a.THAINAME, 1, 2) != 'RA'
                UNION
                SELECT DISTINCT CONVERT(VARCHAR(30), a.DATEWORKING, 103) AS 'DATEWORKING',a.EMPLOYEECODE2 AS 'EMPCODE',
                a.EMPLOYEENAME2 AS 'EMPNAME',a.JOBNO AS 'JOBNO',a.VEHICLETRANSPORTPLANID AS 'PLANID',
                a.JOBSTART AS 'JOBSTART',a.CLUSTER AS 'CLUSTER',a.JOBEND AS 'JOBEND',a.THAINAME AS 'THAINAME'
                FROM [dbo].[VEHICLETRANSPORTPLAN] a
                WHERE a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
                AND a.DOCUMENTCODE IS NOT NULL
                AND a.DOCUMENTCODE !=''
                AND (a.EMPLOYEECODE2 IS NOT NULL OR a.EMPLOYEECODE2 !='') 
                AND CONVERT(DATETIME,a.DATEWORKING) BETWEEN CONVERT(DATETIME,'".$_GET['datestart']."',103) AND CONVERT(DATETIME,'".$_GET['dateend']."',103)
                AND SUBSTRING(a.THAINAME, 1, 2) != 'RA'
                )AS c
                ORDER BY c.EMPNAME ASC";
                // ORDER BY a.JOBSTART,b.DATEWORKING ASC
              $query_sedriverchk = sqlsrv_query($conn, $sql_sedriverchk, $params_sedriverchk);
              // echo 'RCC';
            }else {
              $sql_sedriverchk = "SELECT ROW_NUMBER() OVER (PARTITION BY c.EMPCODE
                ORDER BY CONVERT(VARCHAR(30), c.DATEWORKING, 103),c.JOBNO ASC) AS 'ROWNUM' ,c.DATEWORKING AS 'DATEWORKING',
                c.EMPCODE AS 'EMPCODE',c.EMPNAME AS 'EMPNAME',c.JOBNO AS 'JOBNO' ,c.PLANID AS 'PLANID',
                c.JOBSTART AS 'JOBSTART',c.CLUSTER AS 'CLUSTER',c.JOBEND AS 'JOBEND',c.THAINAME AS 'THAINAME'
                FROM
                (SELECT DISTINCT CONVERT(VARCHAR(30), a.DATEWORKING, 103) AS 'DATEWORKING',a.EMPLOYEECODE1 AS 'EMPCODE',
                a.EMPLOYEENAME1 AS 'EMPNAME',a.JOBNO AS 'JOBNO',a.VEHICLETRANSPORTPLANID AS 'PLANID',
                a.JOBSTART AS 'JOBSTART',a.CLUSTER AS 'CLUSTER',a.JOBEND AS 'JOBEND',a.THAINAME AS 'THAINAME'
                FROM [dbo].[VEHICLETRANSPORTPLAN] a
                WHERE a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
                AND a.DOCUMENTCODE IS NOT NULL
                AND a.DOCUMENTCODE !=''
                AND (a.EMPLOYEECODE1 IS NOT NULL OR a.EMPLOYEECODE1 !='') 
                AND CONVERT(DATETIME,a.DATEWORKING) BETWEEN CONVERT(DATETIME,'".$_GET['datestart']."',103) AND CONVERT(DATETIME,'".$_GET['dateend']."',103)
                AND SUBSTRING(a.THAINAME, 1, 2) = 'RA'
                UNION
                SELECT DISTINCT CONVERT(VARCHAR(30), a.DATEWORKING, 103) AS 'DATEWORKING',a.EMPLOYEECODE2 AS 'EMPCODE',
                a.EMPLOYEENAME2 AS 'EMPNAME',a.JOBNO AS 'JOBNO',a.VEHICLETRANSPORTPLANID AS 'PLANID',
                a.JOBSTART AS 'JOBSTART',a.CLUSTER AS 'CLUSTER',a.JOBEND AS 'JOBEND',a.THAINAME AS 'THAINAME'
                FROM [dbo].[VEHICLETRANSPORTPLAN] a
                WHERE a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
                AND a.DOCUMENTCODE IS NOT NULL
                AND a.DOCUMENTCODE !=''
                AND (a.EMPLOYEECODE2 IS NOT NULL OR a.EMPLOYEECODE2 !='') 
                AND CONVERT(DATETIME,a.DATEWORKING) BETWEEN CONVERT(DATETIME,'".$_GET['datestart']."',103) AND CONVERT(DATETIME,'".$_GET['dateend']."',103)
                AND SUBSTRING(a.THAINAME, 1, 2) = 'RA'
                )AS c
                ORDER BY c.EMPNAME ASC";
                // ORDER BY a.JOBSTART,b.DATEWORKING ASC
              $query_sedriverchk = sqlsrv_query($conn, $sql_sedriverchk, $params_sedriverchk);
            }
            
        while ($result_sedriverchk = sqlsrv_fetch_array($query_sedriverchk, SQLSRV_FETCH_ASSOC)) {

         
            
            // if ($result_seReporttransport['ROWNUM'] > 1) {
            //   $i--;
            //   $NO = '';
            //   $EMPCODE1 ='';
            //   $DRIVER1 = '';
            //   $EMPCODE2 ='';
            //   $DRIVER2 = '';
            //   $INCEN1 = '';
            //   $INCEN2 = '';
            //   $TOTAL = '';
            // }else {
            //   $NO = $i;
            //   $INCEN1  = $result_seCompensation1['COMPENSATION1'];
            //   $INCEN2  = $result_seCompensation2['COMPENSATION2'];
            //   $TOTAL = number_format($result_seCompensation1['COMPENSATION1']+$result_seCompensation2['COMPENSATION2']);
            // }

            //ค่าเที่ยวกรณีเป็นพขรคนที่1
            $sql_seCompen1 = "SELECT DISTINCT CONVERT(DECIMAL(10,2),COMPENSATION1) AS 'COMPEN1',
              COMPENSATIONEMPTY1 AS 'COMEMP1'
              FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] 
              WHERE VEHICLETRANSPORTPLANID ='".$result_sedriverchk['PLANID']."' 
              AND EMPLOYEECODE1 ='".$result_sedriverchk['EMPCODE']."'
              AND( COMPENSATION1 IS NOT NULL OR  COMPENSATION1 !='')";
            $query_seCompen1 = sqlsrv_query($conn, $sql_seCompen1, $params_seCompen1);
            $result_seCompen1 = sqlsrv_fetch_array($query_seCompen1, SQLSRV_FETCH_ASSOC);
            //ค่าเที่ยวกรณีเป็นพขรคนที่2
            $sql_seCompen2 = "SELECT DISTINCT COMPENSATION2 AS 'COMPEN2',
              COMPENSATIONEMPTY2 AS 'COMEMP2'
              FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] 
              WHERE VEHICLETRANSPORTPLANID ='".$result_sedriverchk['PLANID']."' 
              AND EMPLOYEECODE2 ='".$result_sedriverchk['EMPCODE']."'
              AND( COMPENSATION2 IS NOT NULL OR  COMPENSATION2 !='')";
            $query_seCompen2 = sqlsrv_query($conn, $sql_seCompen2, $params_seCompen2);
            $result_seCompen2 = sqlsrv_fetch_array($query_seCompen2, SQLSRV_FETCH_ASSOC);
            //ค่าเที่ยวเพิ่มเติมกรณี4l และ 8L
            $sql_seOtherCompen = "SELECT  DISTINCT a.VEHICLETRANSPORTPLANID,a.SELECT_4LOAD1,a.PAY_4LOAD1REMARK,a.SELECT_4LOAD2,a.PAY_4LOAD2REMARK,
            a.SELECT_4LOAD3,a.PAY_4LOAD3REMARK,a.SELECT_4LOAD4,a.PAY_4LOAD4REMARK,
            a.SELECT_4LOAD5,a.PAY_4LOAD5REMARK,a.SELECT_4LOAD6,a.PAY_4LOAD6REMARK,
            a.SELECT_8LOAD1,a.PAY_8LOAD1REMARK,a.SELECT_8LOAD2,a.PAY_8LOAD2REMARK,
            a.SELECT_8LOAD3,a.PAY_8LOAD3REMARK,a.SELECT_8LOAD4,a.PAY_8LOAD4REMARK,
            a.SELECT_8LOAD5,a.PAY_8LOAD5REMARK,a.SELECT_8LOAD6,a.PAY_8LOAD6REMARK,
            a.OT180CHK,a.OT360CHK,a.OT15CHK,a.TOTALCOMPEN,a.TOTALNET,a.COMPENSATION1
            FROM VEHICLETRANSPORTDOCUMENTDIRVER a WHERE VEHICLETRANSPORTPLANID ='".$result_sedriverchk['PLANID']."'";
            $query_seOtherCompen = sqlsrv_query($conn, $sql_seOtherCompen, $params_seOtherCompen);
            $result_seOtherCompen = sqlsrv_fetch_array($query_seOtherCompen, SQLSRV_FETCH_ASSOC);  
            
            $OT = $result_seOtherCompen['OT180CHK'] + $result_seOtherCompen['OT360CHK'];

            if ($result_seOtherCompen['OT15CHK']  == NULL || $result_seOtherCompen['OT15CHK'] == '0' || $result_seOtherCompen['OT15CHK'] == '' ) {
              // echo "ไม่ได้เลือกโอที";
              $ALLCOMPEN = $result_seCompen1['COMPEN1']+$result_seCompen2['COMPEN2']+
                         $result_seCompen1['COMEMP1']+$result_seCompen2['COMEMP2']+
                         $result_seOtherCompen['SELECT_4LOAD1']+$result_seOtherCompen['SELECT_4LOAD2']+
                         $result_seOtherCompen['SELECT_4LOAD4']+$result_seOtherCompen['SELECT_4LOAD5']+
                         $result_seOtherCompen['SELECT_4LOAD6']+$result_seOtherCompen['SELECT_8LOAD3']+
                         $result_seOtherCompen['SELECT_8LOAD5']+$result_seOtherCompen['SELECT_8LOAD6']+$OT;

              $SUMCHK = $result_seOtherCompen['TOTALCOMPEN'];           
            }else{
              // echo "เลือกโอที";
              $ALLCOMPEN = (($result_seCompen1['COMPEN1']+$result_seCompen2['COMPEN2']+
                         $result_seCompen1['COMEMP1']+$result_seCompen2['COMEMP2']+
                         $result_seOtherCompen['SELECT_4LOAD1']+$result_seOtherCompen['SELECT_4LOAD2']+
                         $result_seOtherCompen['SELECT_4LOAD4']+$result_seOtherCompen['SELECT_4LOAD5']+
                         $result_seOtherCompen['SELECT_4LOAD6']+$result_seOtherCompen['SELECT_8LOAD3']+
                         $result_seOtherCompen['SELECT_8LOAD5']+$result_seOtherCompen['SELECT_8LOAD5']+
                         $OT)*1.5);

              $SUMCHK =(($result_seOtherCompen['COMPENSATION1'])+($result_seOtherCompen['SELECT_4LOAD1'])
              +($result_seOtherCompen['SELECT_4LOAD2'])+($result_seOtherCompen['SELECT_4LOAD4'])
              +($result_seOtherCompen['SELECT_4LOAD5'])+($result_seOtherCompen['SELECT_4LOAD6'])
              +($result_seOtherCompen['SELECT_8LOAD3'])+($result_seOtherCompen['SELECT_8LOAD5'])
              +($result_seOtherCompen['SELECT_8LOAD6']));

            }
            
            if ($SUMCHK < 0) {
              $SUM = 0;
            }else {
              $SUM = $SUMCHK;
            }
            ?>

            <tr>
              <td style="text-align: center"><?=$result_sedriverchk['ROWNUM']?></td>
              <td style="text-align: center"><?=$result_sedriverchk['DATEWORKING']?></td>
              <td style="text-align: center"><?=$result_sedriverchk['EMPCODE']?></td>
              <td style="text-align: center"><?=$result_sedriverchk['EMPNAME']?></td>
              <td style="text-align: center"><?=$result_sedriverchk['CLUSTER']?></td>
              <td style="text-align: center"><?=$result_sedriverchk['JOBSTART']?></td>
              <td style="text-align: center"><?=$result_sedriverchk['JOBEND']?></td>
              <td style="text-align: center"><?=$result_sedriverchk['THAINAME']?></td>
              <td style="text-align: center"><?=number_format($result_seCompen1['COMPEN1']+$result_seCompen2['COMPEN2'])?></td>
              <!-- <td style="text-align: center"><?=number_format($result_seCompen1['COMEMP1']+$result_seCompen2['COMEMP2'])?></td> -->
              <td style="text-align: center"><?=$result_seOtherCompen['SELECT_4LOAD1']?></td> <!--รับงาน2 รอบ 4L -->
              <td style="text-align: center"><?=$result_seOtherCompen['SELECT_4LOAD2']?></td>  <!--ลงงาน 3 ดีลเลอร์ 4L -->
              <td style="text-align: center"><?=$result_seOtherCompen['SELECT_4LOAD4']?></td> <!-- กรณีรองานที่ยาร์ด 4L -->
              <td style="text-align: center"><?=$result_seOtherCompen['SELECT_4LOAD5']?></td> <!--กรณีตีเปล่าเข้ารับงานที่บ้านโพธิ์/สำโรง -->
              <td style="text-align: center"><?=$result_seOtherCompen['SELECT_4LOAD6']?></td> <!--กรณีงาน SH มีงาน 1 รอบ 4L -->
              <td style="text-align: center"><?=$result_seOtherCompen['SELECT_8LOAD3']?></td>
              <td style="text-align: center"><?=$result_seOtherCompen['SELECT_8LOAD5']?></td>
              <td style="text-align: center"><?=$result_seOtherCompen['SELECT_8LOAD6']?></td>
              <td style="text-align: center"><?=$OT?></td>
              <td style="text-align: center"><?=$SUM?></td>
              <td style="text-align: center"><?=number_format($result_seOtherCompen['TOTALNET']-$SUM)?></td>
              <!-- <td style="text-align: center"><?=$result_seOtherCompen['OT15CHK']?></td> -->
              <!-- <td style="text-align: center"></td> -->
              <td style="text-align: center"><?=number_format($result_seOtherCompen['TOTALNET'])?></td>
              <!-- <td style="text-align: center"><?=number_format($ALLCOMPEN)?></td> -->
              <td style="text-align: center"></td>
             
            </tr>
            <?php
             
            $i++;
            $SUMCOMPEN = $SUMCOMPEN + ($result_seCompen1['COMPEN1'] + $result_seCompen2['COMPEN2']); 
            $SUMCOMPENEMP  = $SUMCOMPENEMP + ($result_seCompen1['COMEMP1'] + $result_seCompen2['COMEMP2']);
            $SUM4LOAD1 =  $SUM4LOAD1 + $result_seOtherCompen['SELECT_4LOAD1'];
            $SUM4LOAD2 =  $SUM4LOAD2 + $result_seOtherCompen['SELECT_4LOAD2'];
            $SUM4LOAD4 =  $SUM4LOAD4 + $result_seOtherCompen['SELECT_4LOAD4'];
            $SUM4LOAD5 =  $SUM4LOAD5 + $result_seOtherCompen['SELECT_4LOAD5'];
            $SUM4LOAD6 =  $SUM4LOAD6 + $result_seOtherCompen['SELECT_4LOAD6'];
            $SUM8LOAD3 =  $SUM8LOAD3 + $result_seOtherCompen['SELECT_8LOAD3'];
            $SUM8LOAD5 =  $SUM8LOAD5 + $result_seOtherCompen['SELECT_8LOAD5'];
            $SUM8LOAD6 =  $SUM8LOAD6 + $result_seOtherCompen['SELECT_8LOAD6'];
            $SUMOT = $SUMOT + $OT; //ช่องOTวันหยุด
            $SUMOT15 = $SUMOT15 + $SUM; //ช่องรวม
            $SUMONLYOT15 = $SUMONLYOT15 + ($result_seOtherCompen['TOTALNET']-$SUM);//ช่องรวมเฉพาะOT15
            $SUMALLCOMPEN = $SUMALLCOMPEN + $result_seOtherCompen['TOTALNET']; //TOTALNET คือ TOTALCOMPEN+(OT180,OT360)
            // $SUMOT15 = $SUMOT15 + $result_seOtherCompen['OT15CHK'];
            // $SUMALLCOMPEN = $SUMALLCOMPEN + $ALLCOMPEN;


          }
          ?>
        
        </tbody>
        <tfoot>
          <tr>
              <td colspan = "8" style="text-align: center">ค่าเที่ยวสุทธิ</td>
              <td style="text-align: center"><?=number_format($SUMCOMPEN)?></td>
              <td style="text-align: center"><?=number_format($SUM4LOAD1)?></td>
              <td style="text-align: center"><?=number_format($SUM4LOAD2)?></td>
              <td style="text-align: center"><?=number_format($SUM4LOAD4)?></td>
              <td style="text-align: center"><?=number_format($SUM4LOAD5)?></td>
              <td style="text-align: center"><?=number_format($SUM4LOAD6)?></td>
              <td style="text-align: center"><?=number_format($SUM8LOAD3)?></td>
              <td style="text-align: center"><?=number_format($SUM8LOAD5)?></td>
              <td style="text-align: center"><?=number_format($SUM8LOAD6)?></td>
              <td style="text-align: center"><?=number_format($SUMOT)?></td>
              <td style="text-align: center"><?=number_format($SUMOT15)?></td>
              <td style="text-align: center"><?=number_format($SUMONLYOT15)?></td>
              <td style="text-align: center"><?=number_format($SUMALLCOMPEN)?></td>
              <td style="text-align: center"></td>
          </tr>
        </tfoot>
      </table>
    </body>
    
</html>
