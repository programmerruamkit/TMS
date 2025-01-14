<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('display_errors', 0);
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานวันที่และเวลาตรวจร่างกาย.xls";
} else {
    $strExcelFileName = "รายงานข้อมูลเวลาตรวจร่างกาย" . $_GET['datestart'] . ".xls";
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
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">NO</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">JOBNO</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">EMPLOYEECODE1</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">EMPLOYEENAME1</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">EMPLOYEECODE2</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">EMPLOYEENAME2</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">JOBSTART</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">JOBEND</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">VEHICLETYPE</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">THAINAME</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">DATEPLAN</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">TIMEPLAN</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">DATEACTUALEMP1</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">TIMEACTUALEEMP1</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">TIMEDIFFEMP1</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">DATEACTUALEMP2</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">TIMEACTUALEEMP2</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">TIMEDIFFEMP2</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">DATETENKO</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">TIMETENKO</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">DATERETURN</th>
            <th style="background-color:#B8B8B8;border: 1px solid #000000;">TIMERETURN</th>
        </tr>
        </thead>
        <tbody>
          <?php
        $i = 1;
        $empintime1 = 0;
        $empintime2 = 0;
        $emplate1 = 0;
        $emplate2 = 0;
        $intimeemp1 = 0;
        $overtimeemp1 = 0;
        $intimeemp2 = 0;
        $overtimeemp2 = 0;

        //รหัสพนักงาน1
        $sql_seDisemp1 = "SELECT DISTINCT EMPLOYEECODE1 AS 'EMP1'
        FROM VEHICLETRANSPORTPLAN 
        WHERE COMPANYCODE ='".$_GET['companycode']."' 
        AND EMPLOYEECODE1 IS NOT NULL
        AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['datestart']."',103)";
        $query_seDisemp1 = sqlsrv_query($conn, $sql_seDisemp1, $params_seDisemp1);
        while ($result_seDisemp1 = sqlsrv_fetch_array($query_seDisemp1, SQLSRV_FETCH_ASSOC)){
          
          $sql_seTenkoData1 = "SELECT PersonCardID,TimeInout,InOutMode,ID_TimeInout,CommitTime
          FROM [203.150.225.30].[TigerWebServer].dbo.ZFP_TimeInOut
          WHERE FORMAT (TimeInout, 'dd/MM/yyyy') = '".$_GET['datestart']."'
          AND PersonCardID = '".$result_seDisemp1['EMP1']."'
          AND InOutMode = 'I'";
          $query_seTenkoData1 = sqlsrv_query($conn, $sql_seTenkoData1, $params_seTenkoData1);
          $result_seTenkoData1 = sqlsrv_fetch_array($query_seTenkoData1, SQLSRV_FETCH_ASSOC);  
          
        if ($result_seTenkoData1['TimeInout'] != '') {
          $empintime1 = $empintime1 + 1;
        }else {
          $emplate1 = $emplate1 + 1;
        }
        
        }

        //รหัสพนักงาน2
        $sql_seDisemp2 = "SELECT DISTINCT EMPLOYEECODE2 AS 'EMP2'
        FROM VEHICLETRANSPORTPLAN 
        WHERE COMPANYCODE ='".$_GET['companycode']."' 
        AND EMPLOYEECODE2 IS NOT NULL
        AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['datestart']."',103)";
        $query_seDisemp2 = sqlsrv_query($conn, $sql_seDisemp2, $params_seDisemp2);
        while ($result_seDisemp2 = sqlsrv_fetch_array($query_seDisemp2, SQLSRV_FETCH_ASSOC)){
          
          $sql_seTenkoData2 = "SELECT PersonCardID,TimeInout,InOutMode,ID_TimeInout,CommitTime
          FROM [203.150.225.30].[TigerWebServer].dbo.ZFP_TimeInOut
          WHERE FORMAT (TimeInout, 'dd/MM/yyyy') = '".$_GET['datestart']."'
          AND PersonCardID = '".$result_seDisemp2['EMP2']."'
          AND InOutMode = 'I'";
          $query_seTenkoData2 = sqlsrv_query($conn, $sql_seTenkoData2, $params_seTenkoData2);
          $result_seTenkoData2 = sqlsrv_fetch_array($query_seTenkoData2, SQLSRV_FETCH_ASSOC);  
          
        if ($result_seTenkoData2['TimeInout'] != '') {
          $empintime2 = $empintime2 + 1;
        }else {
          $emplate2 = $emplate2 + 1;
        }
        
        }

        $sql_seData = "SELECT JOBNO,EMPLOYEECODE1,EMPLOYEENAME1,EMPLOYEECODE2,EMPLOYEENAME2,JOBSTART,JOBEND,COMPANYCODE,CUSTOMERCODE
        ,VEHICLETYPE,THAINAME,CONVERT(VARCHAR(10), DATEPRESENT, 101) + ' '  + convert(VARCHAR(5), DATEPRESENT, 14) AS 'DATEPRESENT',
        FORMAT (DATEPRESENT, 'dd/MM/yyyy')  AS 'DATEPLAN',CONVERT(CHAR(5), DATEPRESENT, 108) AS 'TIMEPLAN',
        FORMAT (DATERETURN, 'dd/MM/yyyy')  AS 'DATERETURN',CONVERT(CHAR(5), DATERETURN, 108) AS 'TIMERETURN',
        TENKOMASTERID
        FROM VEHICLETRANSPORTPLAN 
        WHERE COMPANYCODE ='".$_GET['companycode']."' 
        AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['datestart']."',103)
        ORDER BY JOBSTART,JOBNO ASC";
        $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
        while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)) {
        
        
          
        
        //DATEACTUAL AND TIMEACTUAL FOR EMP1
        $sql_seTimeInOutEmp1 = "SELECT PersonCardID,TimeInout,InOutMode,ID_TimeInout,CommitTime,
        CONVERT(VARCHAR(10), TimeInout, 101) + ' '  + convert(VARCHAR(5), TimeInout, 14) AS 'DATEINOUT',
        FORMAT (TimeInout, 'dd/MM/yyyy')  AS 'DATEACTUAL',CONVERT(CHAR(5), TimeInout, 108) AS 'TIMEACTUAL'
        FROM [203.150.225.30].[TigerWebServer].dbo.ZFP_TimeInOut
        WHERE FORMAT (TimeInout, 'dd/MM/yyyy') = '".$_GET['datestart']."'
        AND PersonCardID ='".$result_seData['EMPLOYEECODE1']."'
        AND InOutMode ='I'";
        $query_seTimeInOutEmp1 = sqlsrv_query($conn, $sql_seTimeInOutEmp1, $params_seTimeInOutEmp1);
        $result_seTimeInOutEmp1 = sqlsrv_fetch_array($query_seTimeInOutEmp1, SQLSRV_FETCH_ASSOC);
        
        
        $dateoriemp1 =  $result_seData['DATEPRESENT'];  
        // echo $dateoriemp1; echo '<br>';
        $datetargetemp1 =  $result_seTimeInOutEmp1['DATEINOUT'];  
        // $datetargetemp1;
        $originemp1 = date_create($dateoriemp1);
        $targetemp1 = date_create($datetargetemp1);
        $intervalemp1 = date_diff($originemp1, $targetemp1);
        $intervalemp1->format('%R');
         // $intervalemp1->format('%R %H:%I');
        

        $sql_seTimeInOutEmp2 = "SELECT PersonCardID,TimeInout,InOutMode,ID_TimeInout,CommitTime,
        CONVERT(VARCHAR(10), TimeInout, 101) + ' '  + convert(VARCHAR(5), TimeInout, 14) AS 'DATEINOUT',
        FORMAT (TimeInout, 'dd/MM/yyyy')  AS 'DATEACTUAL',CONVERT(CHAR(5), TimeInout, 108) AS 'TIMEACTUAL'
        FROM [203.150.225.30].[TigerWebServer].dbo.ZFP_TimeInOut
        WHERE FORMAT (TimeInout, 'dd/MM/yyyy') = '".$_GET['datestart']."'
        AND PersonCardID ='".$result_seData['EMPLOYEECODE2']."'
        AND InOutMode ='I'";
        $query_seTimeInOutEmp2 = sqlsrv_query($conn, $sql_seTimeInOutEmp2, $params_seTimeInOutEmp2);
        $result_seTimeInOutEmp2 = sqlsrv_fetch_array($query_seTimeInOutEmp2, SQLSRV_FETCH_ASSOC);
        
        
        
          $dateoriemp2 =  $result_seData['DATEPRESENT'];  
          // echo $dateoriemp2; echo '<br>';
          $datetargetemp2 =  $result_seTimeInOutEmp2['DATEINOUT'];  
          // echo $datetargetemp2;
          $originemp2 = date_create($dateoriemp2);
          $targetemp2 = date_create($datetargetemp2);
          $intervalemp2 = date_diff($originemp2, $targetemp2);
      
          // $intervalemp2->format('%R %H:%I');

          // จำนวนแผนงาน
          $sql_seCountPlan = "SELECT COUNT(VEHICLETRANSPORTPLANID) AS 'COUNTPLAN'
          FROM VEHICLETRANSPORTPLAN 
          WHERE COMPANYCODE ='".$_GET['companycode']."' 
          AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['datestart']."',103)";
          $query_seCountPlan = sqlsrv_query($conn, $sql_seCountPlan, $params_seCountPlan);
          $result_seCountPlan = sqlsrv_fetch_array($query_seCountPlan, SQLSRV_FETCH_ASSOC);
          
          // จำนวนพนักงาน
          $sql_seCountEmp = "SELECT COUNT(EMPLOYEECODE1)+COUNT(EMPLOYEECODE2) AS 'COUNTEMPLOYEE',
          COUNT(DISTINCT EMPLOYEECODE1)+COUNT(DISTINCT EMPLOYEECODE2) AS 'COUNTEMPLOYEEDIS'
          FROM VEHICLETRANSPORTPLAN 
          WHERE COMPANYCODE ='".$_GET['companycode']."' 
          AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['datestart']."',103)";
          $query_seCountEmp = sqlsrv_query($conn, $sql_seCountEmp, $params_seCountEmp);
          $result_seCountEmp = sqlsrv_fetch_array($query_seCountEmp, SQLSRV_FETCH_ASSOC);

    
          // ข้อมูลการตรวจร่างกาย
          $sql_seTenkoData = "SELECT CREATEBY,FORMAT (CREATEDATE, 'dd/MM/yyyy') AS 'DATETENKO',CONVERT(CHAR(5), 
          CREATEDATE, 108) AS 'TIMETENKO'
          FROM TENKOMASTER 
          WHERE TENKOMASTERID ='".$result_seData['TENKOMASTERID']."'";
          $query_seTenkoData = sqlsrv_query($conn, $sql_seTenkoData, $params_seTenkoData);
          $result_seTenkoData = sqlsrv_fetch_array($query_seTenkoData, SQLSRV_FETCH_ASSOC);  
          
          // ข้อมูลเวลาแสกนนิ้ว

        ?>
            

              <tr>
                <td style="text-align: center;border: 1px solid #000000;"><?=$i?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['JOBNO']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['EMPLOYEECODE1']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['EMPLOYEENAME1']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['EMPLOYEECODE2']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['EMPLOYEENAME2']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['JOBSTART']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['JOBEND']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['VEHICLETYPE']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['THAINAME']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['DATEPLAN']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['TIMEPLAN']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seTimeInOutEmp1['DATEACTUAL']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seTimeInOutEmp1['TIMEACTUAL']?></td>
                <?php
                if ($result_seTimeInOutEmp1['DATEINOUT'] == '' ) {
                  ?>
                  <td style="text-align: center;border: 1px solid #000000;"></td>
                 <?php 
                }else {
                 ?>
                  <td style="text-align: center;border: 1px solid #000000;"><?=$intervalemp1->format('(%R) %H:%I');?></td>
                 <?php
                }
                ?>
                
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seTimeInOutEmp2['DATEACTUAL']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seTimeInOutEmp2['TIMEACTUAL']?></td>
                <?php
                if ($result_seData['EMPLOYEECODE2'] == '' || $result_seTimeInOutEmp2['DATEINOUT'] == '') {
                  ?>
                  <td style="text-align: center;border: 1px solid #000000;"></td>
                 <?php 
                }else {
                 ?>
                  <td style="text-align: center;border: 1px solid #000000;"><?=$intervalemp2->format('(%R) %H:%I');?></td>
                 <?php
                }
                ?>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seTenkoData['DATETENKO']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seTenkoData['TIMETENKO']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['DATERETURN']?></td>
                <td style="text-align: center;border: 1px solid #000000;"><?=$result_seData['TIMERETURN']?></td>
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
        <tfoot>
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
          </tfoot>
      </table>
    </body>
    
</html>
