<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานแผนการขนส่ง.xls";
} else {
    $strExcelFileName = "รายงานแผนการขนส่ง(".$_GET['customercode'].")วันที่" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
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
          <th>NO</th>
          <th>DATE</th>
          <th>DO</th>
          <th>BOOOKNO</th>
          <th>DRIVER</th>
          <th>FROM</th>
          <th>TO</th>
          <th>UNIT</th>
          <th>WEIGHTIN</th>
          <th>INCENTIVE</th>
          <th>PRICE</th>
          <th>TOTAL</th>
        </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;

          $sql_seReporttransport = "SELECT  CONVERT(VARCHAR(30), b.DATEWORKING, 103)  AS 'DATE',
          a.EMPLOYEENAME1 AS 'EMPNAME1',b.EMPLOYEECODE1 AS 'EMPCODE1'
          ,b.JOBNO AS 'JOBNO',a.DOCUMENTCODE AS 'DO',b.C8 AS 'GR',b.CLUSTER AS 'CLUSTER',
          a.JOBSTART AS 'FROM' ,a.JOBEND AS 'TO' ,b.MATERIALTYPE AS 'PRODUCTTYPE',b.THAINAME AS 'THAINAME',
          b.VEHICLEREGISNUMBER1 AS 'VEHICLEREGISNUMBER',a.TRIPAMOUNT AS 'UNIT', 
          a.COMPENSATION1 AS 'INCEN1',a.EMPLOYEENAME2 AS 'EMPNAME2',a.COMPENSATION2 AS 'INCEN2',
          a.WEIGHTIN AS 'WEIGHTIN',a.WEIGHTOUT AS 'WEIGHTOUT',b.ACTUALPRICE AS 'PRICE',c.FnameT AS 'NAMETHA',
          b.VEHICLETRANSPORTPLANID,
          ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM'    
          FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
          INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
          INNER JOIN [dbo].[EMPLOYEEEHR2] c ON b.EMPLOYEECODE1 = c.PersonCode
          AND a.COMPANYCODE ='RRC' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
          AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
          AND b.VEHICLEREGISNUMBER1 IS NOT NULL
          AND b.VEHICLEREGISNUMBER1 !=''
          AND b.DOCUMENTCODE IS NOT NULL
          AND b.DOCUMENTCODE !=''
          ORDER BY b.DATEWORKING,c.FnameE ASC";
          $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport, $params_seReporttransport);
          while ($result_seReporttransport = sqlsrv_fetch_array($query_seReporttransport, SQLSRV_FETCH_ASSOC)) {

            $sql_seIncentive = "SELECT (COMPENSATION1+COMPENSATION2+COMPENSATION3 ) AS 'INCEN1'
              FROM VEHICLETRANSPORTDOCUMENTDIRVER WHERE VEHICLETRANSPORTPLANID ='". $result_seReporttransport['VEHICLETRANSPORTPLANID']."'
              AND (COMPENSATION1 !='' OR COMPENSATION2 !='' OR COMPENSATION3 !='')
              AND (COMPENSATION1 IS NOT NULL OR COMPENSATION2 IS NOT NULL OR COMPENSATION3 IS NOT NULL)
			  ORDER BY INCEN1 DESC";
            $query_seIncentive = sqlsrv_query($conn, $sql_seIncentive, $params_seIncentive);
            $result_seIncentive = sqlsrv_fetch_array($query_seIncentive, SQLSRV_FETCH_ASSOC);

            if ($result_seReporttransport['ROWNUM'] > 1) {
              $i--;
              $NO = '';
              $INCEN = '';
              $PRICE = '';
              $TOTAL = '';
            }else {
                if ($result_seReporttransport['FROM'] == 'TTAST' && ($result_seReporttransport['TO'] == 'TTAST'|| $result_seReporttransport['TO'] == 'Move Coil')) {
                  $NO = $i;
                  $INCEN = number_format($result_seIncentive['INCEN1']);
                  $PRICE = number_format(($result_seReporttransport['PRICE']/$_GET['ttastday']));
                  $TOTAL = number_format(($result_seReporttransport['PRICE']/$_GET['ttastday']));
                }else{
                  $NO = $i;
                  $INCEN = number_format($result_seIncentive['INCEN1']);
                  $PRICE = number_format($result_seReporttransport['PRICE']);
                  $TOTAL = number_format($result_seReporttransport['PRICE']);
                }
              
              
            }



   
            ?>

            <tr>
              <td style="text-align: center"><?=$NO?></td>
              <td style="text-align: center"><?=$result_seReporttransport['DATE']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['DO']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['VEHICLEREGISNUMBER']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['NAMETHA']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['FROM']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['TO']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['UNIT']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['WEIGHTIN']?></td>
              <td style="text-align: center"><?=$INCEN?></td>
              <td style="text-align: center"><?=$PRICE?></td>
              <td style="text-align: center"><?=$TOTAL?></td>
            
            </tr>
            <?php
            $i++;
          }
          ?>
        
        </tbody>
      </table>
    </body>
    
</html>
