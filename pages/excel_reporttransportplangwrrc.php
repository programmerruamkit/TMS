<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานแผนการขนส่ง.xls";
} else {
    $strExcelFileName = "รายงานแผนการขนส่งสายงาน".$_GET['customercode']."ตั้งแต่วันที่" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
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
          <th>JOBDATE</th>
          <th>DRIVER(1)</th>
          <th>BOOOKNO</th>
          <th>TRUCKNO</th>
          <th>MATERIALTYPE</th>
          <th>FROM</th>
          <th>TO</th>
          <th>DO</th>
          <th>WEIGHTIN</th>
          <th>WEIGHTOUT</th>
          <th>INCENTIVE</th>
          <th>PRICE</th>
          <th>TOTAL</th>
          <th>REMARK</th>
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
			a.WEIGHTIN AS 'WEIGHTIN',a.WEIGHTOUT AS 'WEIGHTOUT',d.PRICE AS 'PRICE',c.FnameE AS 'NAMEENG',
			b.VEHICLETRANSPORTPLANID,b.MATERIALTYPE,b.VEHICLETRANSPORTPRICEID,
			ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM'    
			FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
			INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
			INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] d ON d.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
			INNER JOIN [dbo].[EMPLOYEEEHR2] c ON b.EMPLOYEECODE1 = c.PersonCode
			AND a.COMPANYCODE ='RRC' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
			AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
			--AND b.VEHICLEREGISNUMBER1 IS NOT NULL
			--AND b.VEHICLEREGISNUMBER1 !=''
			AND b.DOCUMENTCODE IS NOT NULL
			AND b.DOCUMENTCODE !=''
			ORDER BY b.DATEWORKING,c.FnameE ASC";
          $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport, $params_seReporttransport);
          while ($result_seReporttransport = sqlsrv_fetch_array($query_seReporttransport, SQLSRV_FETCH_ASSOC)) {

            // ใช้ JOIN TABLE แทนได้
            $sql_regisnumbercheck = " SELECT VEHICLEREGISNUMBER AS 'VEHICLEREGISNUMBER' 
              FROM VEHICLEINFO 
              WHERE THAINAME ='".$result_seReporttransport['THAINAME']."'
              AND ACTIVESTATUS = '1'";
            $query_regisnumbercheck  = sqlsrv_query($conn, $sql_regisnumbercheck, $params_regisnumbercheck);
            $result_regisnumbercheck = sqlsrv_fetch_array($query_regisnumbercheck, SQLSRV_FETCH_ASSOC);    
            
            $holiday = $_GET['holiday'];
            // $holiday = $result_seHoliday['DATE'];
            $holidaysplit = explode(",", $holiday);
            
           
           if (($result_seReporttransport['DATE'] == $holidaysplit[0])      || ($result_seReporttransport['DATE'] == $holidaysplit[1]) 
                || ($result_seReporttransport['DATE'] == $holidaysplit[2])  || ($result_seReporttransport['DATE'] == $holidaysplit[3]) 
                || ($result_seReporttransport['DATE'] == $holidaysplit[4])) {
            // echo  $holidaysplit[0];
                  $HOLIDAYPRICE = '1000';
           }else{
                  $HOLIDAYPRICE = '0';
            // echo  $holidaysplit[1];
           }

            if ($result_seReporttransport['ROWNUM'] == '1') {
              $NO = $i;
              $WEIGHTIN   = $result_seReporttransport['WEIGHTIN'];
              $WEIGHTOUT  = $result_seReporttransport['WEIGHTOUT'];
              $INCENTIVE  = number_format($result_seReporttransport['INCEN1']);
              if ($result_seReporttransport['GR'] == 'return') {
                $PRICE      = number_format((($result_seReporttransport['PRICE']*50)/100)+$HOLIDAYPRICE);
                $REMARK     = 'งานรับกลับ';
                // งานรับกลับสลับต้นทางปลายทาง
                $FROM       = $result_seReporttransport['TO'];
                $TO         = $result_seReporttransport['FROM'];
              }else {
                $PRICE      = number_format($result_seReporttransport['PRICE']+$HOLIDAYPRICE);
                $REMARK     = '';
                $FROM       = $result_seReporttransport['FROM'];
                $TO         = $result_seReporttransport['TO'];
              }
              

            }else{
              $i--;
              $NO = '';
              $WEIGHTIN   = $result_seReporttransport['WEIGHTIN'];
              $WEIGHTOUT  = $result_seReporttransport['WEIGHTOUT'];
              $INCENTIVE  = '';
              if ($result_seReporttransport['GR'] == 'return') {
                $PRICE      = '';
                $REMARK     = 'งานรับกลับ';
                // งานรับกลับสลับต้นทางปลายทาง
                $FROM       = $result_seReporttransport['TO'];
                $TO         = $result_seReporttransport['FROM'];
              }else {
                $PRICE      = '';
                $REMARK     = '';
                $FROM       = $result_seReporttransport['FROM'];
                $TO         = $result_seReporttransport['TO'];
              }
                
            }
            ?>

              <tr>
                <td style="text-align: center"><?=$NO?></td>
                <td style="text-align: center"><?=$result_seReporttransport['DATE']?></td>
                <td style="text-align: center"><?=$result_seReporttransport['NAMEENG']?></td>
                <td style="text-align: center"><?=$result_seReporttransport['JOBNO']?></td>
                <td style="text-align: center"><?=$result_regisnumbercheck['VEHICLEREGISNUMBER']?></td>
                <td style="text-align: center"><?=$result_seReporttransport['MATERIALTYPE']?></td>
                <td style="text-align: center"><?=$FROM?></td>
                <td style="text-align: center"><?=$TO?></td>
                <td style="text-align: center"><?=$result_seReporttransport['DO']?></td>
                <td style="text-align: center"><?=$WEIGHTIN?></td>
                <td style="text-align: center"><?=$WEIGHTOUT?></td>
                <td style="text-align: center"><?=$INCENTIVE?></td>
                <td style="text-align: center"><?=$PRICE?></td>
                <td style="text-align: center"><?=$PRICE?></td>
                <td style="text-align: center"><?=$REMARK?></td>
              </tr>
            <?php
            $i++;
          }
          ?>
        
        </tbody>
      </table>
    </body>
    
</html>
