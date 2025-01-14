<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานค่าเที่ยวรวม.xls";
} else {
    $strExcelFileName = "รายงานค่าเที่ยวรวมตั้งแต่วันที่" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
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
        <td colspan="7" style="text-align:center;font-size: 20px;"><b><?=$companyname?></b></td>
      </thead>
      <tbody>
        <tr>
          <td colspan="7" style="text-align:center;font-size: 15px;"><b>ค่าเที่ยว วันที่ <?=$_GET['datestart']?> ถึง <?=$_GET['dateend']?></b></td>
        </tr>
        
      </tbody>
    </table>
      <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
        <thead>
          <tr>
            <th>ลำดับ</th>
            <th>วันที่</th>
            <th>รหัสพนักงาน</th>
            <th>ชื่อ-สกุล</th>
            <th>จำนวนเที่ยว</th>
            <th>รวมค่าเที่ยว</th>
            <th>หมายเหตุ</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;

            if ($_GET['companycode'] == 'RCC') {
              // echo 'RCC';
              ///ค้นหาข้อมูลสายงาน RCC
              ///ทะเบียนรถต้องไม่เท่ากับ RA หรือ ต้องเท่ากับ R
              $sql_sedriverchk = "SELECT DISTINCT a.EMPLOYEECODE1 AS 'EMPCODE',
              a.EMPLOYEENAME1 AS 'EMPNAME'
              FROM [dbo].[VEHICLETRANSPORTPLAN] a
              WHERE a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
              AND a.DOCUMENTCODE IS NOT NULL
              AND a.DOCUMENTCODE !=''
              AND (a.EMPLOYEECODE1 IS NOT NULL OR a.EMPLOYEECODE1 !='') 
              AND CONVERT(DATETIME,a.DATEWORKING) BETWEEN CONVERT(DATETIME,'".$_GET['datestart']."',103) AND CONVERT(DATETIME,'".$_GET['dateend']."',103)
              AND SUBSTRING(a.THAINAME, 1, 2) != 'RA'
              UNION
              SELECT DISTINCT a.EMPLOYEECODE2 AS 'EMPCODE',
              a.EMPLOYEENAME2 AS 'EMPNAME'
              FROM [dbo].[VEHICLETRANSPORTPLAN] a
              WHERE a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
              AND a.DOCUMENTCODE IS NOT NULL
              AND a.DOCUMENTCODE !=''
              AND (a.EMPLOYEECODE2 IS NOT NULL OR a.EMPLOYEECODE2 !='') 
              AND CONVERT(DATETIME,a.DATEWORKING) BETWEEN CONVERT(DATETIME,'".$_GET['datestart']."',103) AND CONVERT(DATETIME,'".$_GET['dateend']."',103)
              AND SUBSTRING(a.THAINAME, 1, 2) != 'RA'
              ORDER BY EMPNAME ASC";
              // ORDER BY a.JOBSTART,b.DATEWORKING ASC
            $query_sedriverchk = sqlsrv_query($conn, $sql_sedriverchk, $params_sedriverchk);
        }else {
            ///ค้นหาข้อมูลสายงาน RATC
            ///ทะเบียนรถต้องเท่ากับ RA 
            $sql_sedriverchk = "SELECT DISTINCT a.EMPLOYEECODE1 AS 'EMPCODE',
            a.EMPLOYEENAME1 AS 'EMPNAME'
            FROM [dbo].[VEHICLETRANSPORTPLAN] a
            WHERE a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
            AND a.DOCUMENTCODE IS NOT NULL
            AND a.DOCUMENTCODE !=''
            AND (a.EMPLOYEECODE1 IS NOT NULL OR a.EMPLOYEECODE1 !='') 
            AND CONVERT(DATETIME,a.DATEWORKING) BETWEEN CONVERT(DATETIME,'".$_GET['datestart']."',103) AND CONVERT(DATETIME,'".$_GET['dateend']."',103)
            AND SUBSTRING(a.THAINAME, 1, 2) = 'RA'
            UNION
            SELECT DISTINCT a.EMPLOYEECODE2 AS 'EMPCODE',
            a.EMPLOYEENAME2 AS 'EMPNAME'
            FROM [dbo].[VEHICLETRANSPORTPLAN] a
            WHERE a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
            AND a.DOCUMENTCODE IS NOT NULL
            AND a.DOCUMENTCODE !=''
            AND (a.EMPLOYEECODE2 IS NOT NULL OR a.EMPLOYEECODE2 !='') 
            AND CONVERT(DATETIME,a.DATEWORKING) BETWEEN CONVERT(DATETIME,'".$_GET['datestart']."',103) AND CONVERT(DATETIME,'".$_GET['dateend']."',103)
            AND SUBSTRING(a.THAINAME, 1, 2) = 'RA'
            ORDER BY EMPNAME ASC";
            // ORDER BY a.JOBSTART,b.DATEWORKING ASC
          $query_sedriverchk = sqlsrv_query($conn, $sql_sedriverchk, $params_sedriverchk);
        }
          while ($result_sedriverchk = sqlsrv_fetch_array($query_sedriverchk, SQLSRV_FETCH_ASSOC)) {

            if ($_GET['companycode'] == 'RCC') {
              //คำนวณหาค่าเที่ยวกรณีเป็นคนที่1
              $sql_seTotal = "SELECT 
              SUM(CONVERT(INT, c.TOTALNET))
              AS 'TOTALNET' 
                            
              FROM(
              SELECT DISTINCT CONVERT(VARCHAR(30), a.DATEWORKING, 103) AS 'DATEWORKING',a.EMPLOYEECODE1 AS 'EMPCODE1',
              a.EMPLOYEENAME1 AS 'EMPNAME1',a.JOBNO AS 'JOBNO',a.VEHICLETRANSPORTPLANID AS 'PLANID',
              a.JOBSTART AS 'JOBSTART',a.CLUSTER AS 'JOBEND',a.THAINAME AS 'THAINAME',
              b.TOTALNET
              FROM [dbo].[VEHICLETRANSPORTPLAN] a 
              INNER JOIN VEHICLETRANSPORTDOCUMENTDIRVER b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
              WHERE a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
              AND a.DOCUMENTCODE IS NOT NULL
              AND a.DOCUMENTCODE !=''
              AND (a.EMPLOYEECODE1 ='".$result_sedriverchk['EMPCODE']."' OR a.EMPLOYEECODE2 ='".$result_sedriverchk['EMPCODE']."')
              AND b.COMPENSATION1 IS NOT NULL
              AND b.COMPENSATION1 != ''
              AND CONVERT(DATETIME,a.DATEWORKING) BETWEEN CONVERT(DATETIME,'".$_GET['datestart']."',103) AND CONVERT(DATETIME,'".$_GET['dateend']."',103)
              AND SUBSTRING(a.THAINAME, 1, 2) != 'RA') AS c";
              $query_seTotal = sqlsrv_query($conn, $sql_seTotal, $params_seTotal);
              $result_seTotal = sqlsrv_fetch_array($query_seTotal, SQLSRV_FETCH_ASSOC);

              
              $sql_seCount = "SELECT COUNT(c.PLANID) AS 'COUNT' FROM 
              ( SELECT DISTINCT CONVERT(VARCHAR(30), a.DATEWORKING, 103) AS 'DATEWORKING',a.EMPLOYEECODE1 AS 'EMPCODE1',
              a.EMPLOYEENAME1 AS 'EMPNAME1',a.JOBNO AS 'JOBNO',a.VEHICLETRANSPORTPLANID AS 'PLANID'
              FROM [dbo].[VEHICLETRANSPORTPLAN] a
              WHERE a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
              AND a.DOCUMENTCODE IS NOT NULL
              AND a.DOCUMENTCODE !=''
              AND (a.EMPLOYEECODE1 ='".$result_sedriverchk['EMPCODE']."' OR a.EMPLOYEECODE2 ='".$result_sedriverchk['EMPCODE']."') 
              AND CONVERT(DATETIME,a.DATEWORKING) BETWEEN CONVERT(DATETIME,'".$_GET['datestart']."',103) AND CONVERT(DATETIME,'".$_GET['dateend']."',103)
              AND SUBSTRING(a.THAINAME, 1, 2) != 'RA' )AS c";
              $query_seCount = sqlsrv_query($conn, $sql_seCount, $params_seCount);
              $result_seCount = sqlsrv_fetch_array($query_seCount, SQLSRV_FETCH_ASSOC);
           }else {

            $sql_seTotal = "SELECT 
              SUM(CONVERT(INT, c.TOTALNET))
              AS 'TOTALNET' 
                            
              FROM(
              SELECT DISTINCT CONVERT(VARCHAR(30), a.DATEWORKING, 103) AS 'DATEWORKING',a.EMPLOYEECODE1 AS 'EMPCODE1',
              a.EMPLOYEENAME1 AS 'EMPNAME1',a.JOBNO AS 'JOBNO',a.VEHICLETRANSPORTPLANID AS 'PLANID',
              a.JOBSTART AS 'JOBSTART',a.CLUSTER AS 'JOBEND',a.THAINAME AS 'THAINAME',
              b.TOTALNET
              FROM [dbo].[VEHICLETRANSPORTPLAN] a 
              INNER JOIN VEHICLETRANSPORTDOCUMENTDIRVER b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
              WHERE a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
              AND a.DOCUMENTCODE IS NOT NULL
              AND a.DOCUMENTCODE !=''
              AND (a.EMPLOYEECODE1 ='".$result_sedriverchk['EMPCODE']."' OR a.EMPLOYEECODE2 ='".$result_sedriverchk['EMPCODE']."')
              AND b.COMPENSATION1 IS NOT NULL
              AND b.COMPENSATION1 != ''
              AND CONVERT(DATETIME,a.DATEWORKING) BETWEEN CONVERT(DATETIME,'".$_GET['datestart']."',103) AND CONVERT(DATETIME,'".$_GET['dateend']."',103)
              AND SUBSTRING(a.THAINAME, 1, 2) = 'RA') AS c";
              $query_seTotal = sqlsrv_query($conn, $sql_seTotal, $params_seTotal);
              $result_seTotal = sqlsrv_fetch_array($query_seTotal, SQLSRV_FETCH_ASSOC);

            $sql_seCount = "SELECT COUNT(c.PLANID) AS 'COUNT' FROM 
            ( SELECT DISTINCT CONVERT(VARCHAR(30), a.DATEWORKING, 103) AS 'DATEWORKING',a.EMPLOYEECODE1 AS 'EMPCODE1',
            a.EMPLOYEENAME1 AS 'EMPNAME1',a.JOBNO AS 'JOBNO',a.VEHICLETRANSPORTPLANID AS 'PLANID'
            FROM [dbo].[VEHICLETRANSPORTPLAN] a
            WHERE a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
            AND a.DOCUMENTCODE IS NOT NULL
            AND a.DOCUMENTCODE !=''
            AND (a.EMPLOYEECODE1 ='".$result_sedriverchk['EMPCODE']."' OR a.EMPLOYEECODE2 ='".$result_sedriverchk['EMPCODE']."') 
            AND CONVERT(DATETIME,a.DATEWORKING) BETWEEN CONVERT(DATETIME,'".$_GET['datestart']."',103) AND CONVERT(DATETIME,'".$_GET['dateend']."',103)
            AND SUBSTRING(a.THAINAME, 1, 2) = 'RA' )AS c";
            $query_seCount = sqlsrv_query($conn, $sql_seCount, $params_seCount);
            $result_seCount = sqlsrv_fetch_array($query_seCount, SQLSRV_FETCH_ASSOC);
           }
           
           
            $SUMCOMPEN = ($result_seTotal['TOTALNET']);

            ?>

            <tr>
              <td style="text-align: center"><?=$i?></td>
              <td style="text-align: center"><?=$_GET['datestart']?> ถึง <?=$_GET['dateend']?></td>
              <td style="text-align: center"><?=$result_sedriverchk['EMPCODE']?></td>
              <td style="text-align: center"><?=$result_sedriverchk['EMPNAME']?></td>
              <td style="text-align: center"><?=$result_seCount['COUNT']?></td>
              <td style="text-align: center"><?=number_format($SUMCOMPEN)?></td>
              
              <td style="text-align: center"></td>
              
              
             
            </tr>
            <?php
            $i++;
            $SUMCOUNT  = $SUMCOUNT+$result_seCount['COUNT'] ;
            $SUMALLCOMPEN = $SUMALLCOMPEN+$SUMCOMPEN;
            // $SUMCOMPEN = $SUMCOMPEN+(number_format($result_seCompen1['SUMCOMPEN1']+$result_seCompen2['SUMCOMPEN2']
            // +$result_seCompenemp1['SUMCOMPENEMP1']+$result_seCompenemp2['SUMCOMPENEMP2']
            // +$result_seOT1['SUMOT1']+$result_seOT2['SUMOT2']+$result_se48L1['SUM48L1']+$result_se48L2['SUM48L2']));
          }
          ?>
        
        </tbody>
        <tfoot>
          <tr>
              <td colspan = "4" style="text-align: center">ค่าเที่ยวสุทธิ</td>
              <td style="text-align: center"><?=$SUMCOUNT?></td>
              <td style="text-align: center"><?=number_format($SUMALLCOMPEN)?></td>
              <td style="text-align: center"></td>
          </tr>
        </tfoot>
      </table>
    </body>
    
</html>
