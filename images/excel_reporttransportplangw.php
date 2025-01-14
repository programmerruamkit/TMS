<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานแผนการขนส่ง.xls";
} else {
    $strExcelFileName = "รายงานแผนการขนส่งตั้งแต่วันที่" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
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
            <th>JOBNO</th>
            <th>TRIPNO</th>
            <th>CLUSTER</th>
            <th>FROM</th>
            <th>TO</th>
            <th>DO</th>
            <th>TRUCK TYPE</th>
            <th>VEHICLENO</th>
            <th>UNIT</th>
            <th>EMPCODE(1)</th>
            <th>DRIVER(1)</th>
            <th>INCENTIVE(1)</th>
            <th>EMPCODE(2)</th>
            <th>DRIVER(2)</th>
            <th>INCENTIVE(2)</th>
            <th>TOTAL</th>
            <th>NOTE</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;

          $sql_seReporttransport1 = "SELECT  CONVERT(VARCHAR(30), b.DATEWORKING, 103)  AS 'DATE',b.JOBNO AS 'JOBNO',b.CLUSTER AS 'CLUSTER'
            ,a.TRIPNUMBER,a.TRIPNUMBER2,a.TRIPNUMBER3,a.TRIPNUMBER4,a.TRIPNUMBER5,a.JOBSTART AS 'FROM' ,a.JOBEND AS 'TO' 
            ,a.DOCUMENTCODE AS 'DO',b.THAINAME AS 'THAINAME',b.VEHICLEREGISNUMBER1 AS 'VEHICLEREGISNUMBER'
            ,a.TRIPAMOUNT AS 'UNIT',a.EMPLOYEECODE1 AS 'EMPCODE1',a.EMPLOYEENAME1 AS 'EMPNAME1',
            a.COMPENSATION1 AS 'INCEN1',a.EMPLOYEECODE2 AS 'EMPCODE2',a.EMPLOYEENAME2 AS 'EMPNAME2',a.COMPENSATION2 AS 'INCEN2',
            b.VEHICLETRANSPORTPLANID AS 'PLANID',
            ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM',
            b.WORKTYPE

            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
            AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='TTT'
            AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
            AND b.VEHICLEREGISNUMBER1 IS NOT NULL
            AND b.VEHICLEREGISNUMBER1 !=''
            AND b.DOCUMENTCODE IS NOT NULL
            AND b.DOCUMENTCODE !=''
            AND a.TRIPAMOUNT IS NOT NULL
            AND a.TRIPAMOUNT !=''
            ORDER BY a.JOBSTART,b.DATEWORKING ASC";
          $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport1, $params_seReporttransport);
          while ($result_seReporttransport = sqlsrv_fetch_array($query_seReporttransport, SQLSRV_FETCH_ASSOC)) {

            $sql_seCluster = "SELECT [NAME] AS 'NAME',CLUSTER AS 'CLUSTER'  FROM VEHICLETRANSPORTPRICE 
                    WHERE COMPANYCODE ='".$_GET['companycode']."' AND CUSTOMERCODE ='TTT'
                    AND WORKTYPE ='".$result_seReporttransport['WORKTYPE']."' 
                    AND [NAME] ='".$result_seReporttransport['TO']."'
                    AND CONVERT(DATE,GETDATE()) BETWEEN CONVERT(DATE,STARTDATE,103) AND CONVERT(DATE,ENDDATE,103)";
            $query_seCluster = sqlsrv_query($conn, $sql_seCluster, $params_seCluster);
            $result_seCluster = sqlsrv_fetch_array($query_seCluster, SQLSRV_FETCH_ASSOC);

            
            $sql_seTruckLoad= "SELECT b.VEHICLETYPEAMOUNT,b.VEHICLETYPECODE,a.VEHICLEINFOID,a.VEHICLEREGISNUMBER  FROM [dbo].[VEHICLEINFO] a
                    LEFT JOIN dbo.VEHICLETYPEGETWAY b ON a.VEHICLETYPECODE = b.VEHICLETYPECODE
                    WHERE b.VEHICLETYPEDESC IN ('4L','8L','10W','22W','10WVAN','Full trailer','Semi trailer')
                    AND a.VEHICLEREGISNUMBER = RTRIM('".$result_seReporttransport['VEHICLEREGISNUMBER']."')";
            $query_seTruckLoad = sqlsrv_query($conn, $sql_seTruckLoad, $params_seTruckLoad);
            $result_seTruckLoad = sqlsrv_fetch_array($query_seTruckLoad, SQLSRV_FETCH_ASSOC);

            $sql_seTripNumber = "SELECT TRIPNUMBER,TRIPNUMBER2,TRIPNUMBER3,TRIPNUMBER4,TRIPNUMBER5
                FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] 
                WHERE VEHICLETRANSPORTPLANID ='".$result_seReporttransport['PLANID']."' 
                AND( TRIPNUMBER IS NOT NULL 
                OR  TRIPNUMBER2 IS NOT NULL
                OR TRIPNUMBER3 IS NOT NULL
                OR TRIPNUMBER4 IS NOT NULL
                OR TRIPNUMBER5 IS NOT NULL
                OR TRIPNUMBER IS NOT NULL)";
            $query_seTripNumber = sqlsrv_query($conn, $sql_seTripNumber, $params_seTripNumber);
            $result_seTripNumber = sqlsrv_fetch_array($query_seTripNumber, SQLSRV_FETCH_ASSOC);



            if ($result_seReporttransport['ROWNUM'] > 1) {
              $i--;
              $NO = '';
              $EMPCODE1 ='';
              $DRIVER1 = '';
              $EMPCODE2 ='';
              $DRIVER2 = '';
              $INCEN1 = '';
              $INCEN2 = '';
              $TOTAL = '';
            }else {
              $NO = $i;
              $INCEN1  = $result_seReporttransport['INCEN1'];
              $INCEN2  = $result_seReporttransport['INCEN2'];
              $TOTAL = number_format($result_seReporttransport['INCEN1']+$result_seReporttransport['INCEN2']);
            }

          
            
           

            ?>

            <tr>
              <td style="text-align: center"><?=$NO?></td>
              <td style="text-align: center"><?=$result_seReporttransport['DATE']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['JOBNO']?></td>
              <td style="text-align: center"><?=$result_seTripNumber['TRIPNUMBER']?><?=$result_seTripNumber['TRIPNUMBER2']?><?=$result_seTripNumber['TRIPNUMBER3']?><?=$result_seTripNumber['TRIPNUMBER4']?><?=$result_seTripNumber['TRIPNUMBER5']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['FROM']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['TO']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['DO']?></td>
              <td style="text-align: center"><?=$result_seTruckLoad['VEHICLETYPECODE']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['THAINAME']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['UNIT']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['EMPCODE1']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['EMPNAME1']?></td>
              <td style="text-align: center"><?=$INCEN1?></td>
              <td style="text-align: center"><?=$result_seReporttransport['EMPCODE2']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['EMPNAME2']?></td>
              <td style="text-align: center"><?=$INCEN2?></td>
              <td style="text-align: center"><?=$TOTAL?></td>
              <td style="text-align: center"></td>
            </tr>
            <?php
            $i++;
          }
          ?>
        
        </tbody>
      </table>
    </body>
    
</html>
