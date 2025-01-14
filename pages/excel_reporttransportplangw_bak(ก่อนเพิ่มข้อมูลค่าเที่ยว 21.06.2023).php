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
            <th>WORKTYPE</th>
            <th>TRIPNO</th>
            <th>CLUSTER</th>
            <th>FROM</th>
            <th>TO</th>
            <th>JOBEND</th>
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

            if ($_GET['companycode'] == 'RCC') {
              ///ค้นหาข้อมูลสายงาน RCC
              ///ทะเบียนรถต้องไม่เท่ากับ RA หรือ ต้องเท่ากับ R
              $sql_seReporttransport1 = "SELECT  CONVERT(VARCHAR(30), b.DATEWORKING, 103)  AS 'DATE',b.JOBNO AS 'JOBNO',b.CLUSTER AS 'CLUSTER'
              ,a.TRIPNUMBER,a.TRIPNUMBER2,a.TRIPNUMBER3,a.TRIPNUMBER4,a.TRIPNUMBER5,a.JOBSTART AS 'FROM' ,a.JOBEND AS 'TO' 
              ,a.DOCUMENTCODE AS 'DO',b.THAINAME AS 'THAINAME',b.VEHICLEREGISNUMBER1 AS 'VEHICLEREGISNUMBER'
              ,a.TRIPAMOUNT AS 'UNIT',a.EMPLOYEECODE1 AS 'EMPCODE1',a.EMPLOYEENAME1 AS 'EMPNAME1',
              a.COMPENSATION1 AS 'INCEN1',a.EMPLOYEECODE2 AS 'EMPCODE2',a.EMPLOYEENAME2 AS 'EMPNAME2',a.COMPENSATION2 AS 'INCEN2',
              b.VEHICLETRANSPORTPLANID AS 'PLANID',
              ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.JOBNO,b.VEHICLETRANSPORTPLANID,a.DOCUMENTCODE ASC) AS 'ROWNUM',
              b.WORKTYPE,b.C2,b.VEHICLETRANSPORTPRICEID

              FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
              INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
              AND a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
              AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
              AND b.VEHICLEREGISNUMBER1 IS NOT NULL
              AND b.VEHICLEREGISNUMBER1 !=''
              AND b.DOCUMENTCODE IS NOT NULL
              AND b.DOCUMENTCODE !=''
              AND a.TRIPAMOUNT IS NOT NULL
              AND a.TRIPAMOUNT !=''
              AND SUBSTRING(b.THAINAME, 1, 2) != 'RA'
              ORDER BY a.EMPLOYEENAME1,b.JOBNO,b.DATEWORKING,a.DOCUMENTCODE ASC";
              // ORDER BY a.JOBSTART,b.DATEWORKING ASC
            $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport1, $params_seReporttransport);
        }else {
            ///ค้นหาข้อมูลสายงาน RATC
            ///ทะเบียนรถต้องเท่ากับ RA 
            $sql_seReporttransport1 = "SELECT  CONVERT(VARCHAR(30), b.DATEWORKING, 103)  AS 'DATE',b.JOBNO AS 'JOBNO',b.CLUSTER AS 'CLUSTER'
            ,a.TRIPNUMBER,a.TRIPNUMBER2,a.TRIPNUMBER3,a.TRIPNUMBER4,a.TRIPNUMBER5,a.JOBSTART AS 'FROM' ,a.JOBEND AS 'TO' 
            ,a.DOCUMENTCODE AS 'DO',b.THAINAME AS 'THAINAME',b.VEHICLEREGISNUMBER1 AS 'VEHICLEREGISNUMBER'
            ,a.TRIPAMOUNT AS 'UNIT',a.EMPLOYEECODE1 AS 'EMPCODE1',a.EMPLOYEENAME1 AS 'EMPNAME1',
            a.COMPENSATION1 AS 'INCEN1',a.EMPLOYEECODE2 AS 'EMPCODE2',a.EMPLOYEENAME2 AS 'EMPNAME2',a.COMPENSATION2 AS 'INCEN2',
            b.VEHICLETRANSPORTPLANID AS 'PLANID',
            ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.JOBNO,b.VEHICLETRANSPORTPLANID,a.DOCUMENTCODE ASC) AS 'ROWNUM',
            b.WORKTYPE,b.C2,b.VEHICLETRANSPORTPRICEID

            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
            AND a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
            AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
            AND b.VEHICLEREGISNUMBER1 IS NOT NULL
            AND b.VEHICLEREGISNUMBER1 !=''
            AND b.DOCUMENTCODE IS NOT NULL
            AND b.DOCUMENTCODE !=''
            AND a.TRIPAMOUNT IS NOT NULL
            AND a.TRIPAMOUNT !=''
            AND SUBSTRING(b.THAINAME, 1, 2) = 'RA'
            ORDER BY a.EMPLOYEENAME1,b.JOBNO,b.DATEWORKING,a.DOCUMENTCODE ASC";
            // ORDER BY a.JOBSTART,b.DATEWORKING ASC
          $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport1, $params_seReporttransport);
        }
          while ($result_seReporttransport = sqlsrv_fetch_array($query_seReporttransport, SQLSRV_FETCH_ASSOC)) {

            $sql_seCluster = "SELECT [NAME] AS 'NAME',CLUSTER AS 'CLUSTER'  FROM VEHICLETRANSPORTPRICE 
                    WHERE COMPANYCODE ='".$_GET['companycode']."' AND CUSTOMERCODE ='TTT'
                    AND WORKTYPE ='".$result_seReporttransport['WORKTYPE']."' 
                    AND [NAME] ='".$result_seReporttransport['TO']."'
                    AND CONVERT(DATE,GETDATE()) BETWEEN CONVERT(DATE,STARTDATE,103) AND CONVERT(DATE,ENDDATE,103)";
            $query_seCluster = sqlsrv_query($conn, $sql_seCluster, $params_seCluster);
            $result_seCluster = sqlsrv_fetch_array($query_seCluster, SQLSRV_FETCH_ASSOC);

            if ($result_seReporttransport['WORKTYPE'] == 'sh(n)') {
              $cluster = $result_seReporttransport['CLUSTER'];
            }else {
              $cluster = $result_seCluster['CLUSTER'];
            }
            
            $sql_seTruckLoad= "SELECT b.VEHICLETYPEAMOUNT,
                CASE
                    WHEN b.VEHICLETYPECODE = 'VT-1412-0689' THEN '8L'
                    WHEN b.VEHICLETYPECODE = 'VT-1411-0911' THEN '4L'
                    ELSE b.VEHICLETYPECODE
                END AS 'VEHICLETYPECODE'
                ,b.VEHICLETYPECODE AS 'VEHICLETYPECODE_OLD',a.VEHICLEINFOID,a.VEHICLEREGISNUMBER  FROM [dbo].[VEHICLEINFO] a
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

            $sql_seCompensation1 = "SELECT DISTINCT COMPENSATION1
                FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] 
                WHERE VEHICLETRANSPORTPLANID ='".$result_seReporttransport['PLANID']."' 
                AND( COMPENSATION1 IS NOT NULL OR  COMPENSATION1 !='')";
            $query_seCompensation1 = sqlsrv_query($conn, $sql_seCompensation1, $params_seCompensation1);
            $result_seCompensation1 = sqlsrv_fetch_array($query_seCompensation1, SQLSRV_FETCH_ASSOC);


            $sql_seCompensation2 = "SELECT DISTINCT COMPENSATION2
                FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] 
                WHERE VEHICLETRANSPORTPLANID ='".$result_seReporttransport['PLANID']."' 
                AND( COMPENSATION2 IS NOT NULL OR  COMPENSATION2 !='')";
            $query_seCompensation2 = sqlsrv_query($conn, $sql_seCompensation2, $params_seCompensation2);
            $result_seCompensation2 = sqlsrv_fetch_array($query_seCompensation2, SQLSRV_FETCH_ASSOC);

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
              $INCEN1  = $result_seCompensation1['COMPENSATION1'];
              $INCEN2  = $result_seCompensation2['COMPENSATION2'];
              $TOTAL = number_format($result_seCompensation1['COMPENSATION1']+$result_seCompensation2['COMPENSATION2']);
            }

              $sql_seJobend = "SELECT [NAME],DEALERCODE FROM VEHICLETRANSPORTPRICE WHERE VEHICLETRANSPORTPRICEID ='".$result_seReporttransport['VEHICLETRANSPORTPRICEID']."'";
              $query_seJobend = sqlsrv_query($conn, $sql_seJobend, $params_seJobend);
              $result_seJobend = sqlsrv_fetch_array($query_seJobend, SQLSRV_FETCH_ASSOC);
             
           

            ?>

            <tr>
              <td style="text-align: center"><?=$NO?></td>
              <td style="text-align: center"><?=$result_seReporttransport['DATE']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['JOBNO']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['WORKTYPE']?></td>
              <td style="text-align: center"><?=$result_seTripNumber['TRIPNUMBER']?><?=$result_seTripNumber['TRIPNUMBER2']?><?=$result_seTripNumber['TRIPNUMBER3']?><?=$result_seTripNumber['TRIPNUMBER4']?><?=$result_seTripNumber['TRIPNUMBER5']?></td>
              <td style="text-align: center"><?=$cluster?></td>
              <?php
              //ถ้าเป็นงานรับกลับ สลับ Jobend, Jobstart
                if($result_seReporttransport['C2'] != '' || $result_sePlanmonday['C2'] != NULL){
              ?>
                <td style="text-align: center"><?=$result_seReporttransport['TO']?></td>
              <?php
                }else{
              ?>
                <td style="text-align: center"><?=$result_seReporttransport['FROM']?></td>
              <?php    
                }
              ?>

              <?php
              //ถ้าเป็นงานรับกลับ สลับ Jobend, Jobstart
                if($result_seReporttransport['C2'] != '' || $result_sePlanmonday['C2'] != NULL){
              ?>
                <td style="text-align: center"><?=$result_seReporttransport['FROM']?></td>
              <?php
                }else{
              ?>
                <td style="text-align: center"><?=$result_seReporttransport['TO']?></td>
              <?php    
                }
              ?> 

              <?php
                if ($result_seReporttransport['WORKTYPE'] == 'sh(n)') {
               ?>
                <td style="text-align: center"><?=$result_seJobend['NAME']?></td>
               <?php
                }else {
                ?>
                <td style="text-align: center"></td>
                <?php
                }
              ?>
              
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
              <?php
              //ถ้าเป็นงานรับกลับ สลับ Jobend, Jobstart
                if($result_seReporttransport['C2'] != '' || $result_sePlanmonday['C2'] != NULL){
              ?>
                <td style="text-align: center">งานรับกลับ</td>
              <?php
                }else{
              ?>
                <td style="text-align: center"></td>
              <?php    
                }
              ?> 
             
            </tr>
            <?php
            $i++;
          }
          ?>
        
        </tbody>
      </table>
    </body>
    
</html>
