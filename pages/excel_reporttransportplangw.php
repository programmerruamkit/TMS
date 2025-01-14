<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', '300');

$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานแผนการขนส่ง.xls";
} else {
    $strExcelFileName = "รายงานแผนการขนส่งตั้งแต่วันที่" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
}


  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
  header("Pragma:no-cache");
?>
<html>
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
      <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;border: 1px solid black;">
        <thead>
          <tr>
            <th style="border: 1px solid black;background-color: #E2E3E4">NO</th>
            <th style="border: 1px solid black;background-color: #E2E3E4">DATE</th>
            <th style="border: 1px solid black;background-color: #E2E3E4">TIME</th>
            <th style="border: 1px solid black;background-color: #E2E3E4">JOBNO</th>
            <th style="border: 1px solid black;background-color: #E2E3E4">WORKTYPE</th>
            <th style="border: 1px solid black;background-color: #E2E3E4">TRIP</th>
            <!-- <th style="border: 1px solid black;background-color: #E2E3E4">TRIPNO</th> -->
            <!-- <th style="border: 1px solid black;background-color: #E2E3E4">CLUSTER</th> -->
            <th style="border: 1px solid black;background-color: #E2E3E4">FROM</th>
            <th style="border: 1px solid black;background-color: #E2E3E4">TO</th>
            <!-- <th style="border: 1px solid black;background-color: #E2E3E4">JOBEND</th> -->
            <!-- <th style="border: 1px solid black;background-color: #E2E3E4">DO</th> -->
            <th style="border: 1px solid black;background-color: #E2E3E4">TRUCK TYPE</th>
            <th style="border: 1px solid black;background-color: #E2E3E4">VEHICLENO</th>
            <th style="border: 1px solid black;background-color: #E2E3E4">UNIT</th>
            <th style="border: 1px solid black;background-color: #E2E3E4">จำนวนรับกลับ</th>

            <th style="background-color: #81FAA4;border: 1px solid black;">EMPCODE(1)</th>
            <th style="background-color: #81FAA4;border: 1px solid black;">DRIVER(1)</th>
            <th style="background-color: #81FAA4;border: 1px solid black;">INCENTIVE(1)</th>
            <!-- รายได้อื่นๆ พขร.1 -->
            <th style="background-color: #81FAA4;border: 1px solid black;">รับงานรอบ 2 (4L)</th>
            <th style="background-color: #81FAA4;border: 1px solid black;">ลง 3 ดีลเลอร์ (4L)</th>
            <th style="background-color: #81FAA4;border: 1px solid black;">รองาน (4L)</th>
            <th style="background-color: #81FAA4;border: 1px solid black;">ตีเปล่าบ้านโพธิ์/สำโรง (4L)</th>
            <th style="background-color: #81FAA4;border: 1px solid black;">วิ่ง SH เที่ยวเดียว (4L)</th>
            <th style="background-color: #81FAA4;border: 1px solid black;">ลง 4 ดีลเลอร์ (8L)(วิ่งคู่หาร 2)</th>
            <th style="background-color: #81FAA4;border: 1px solid black;">วิ่ง SH 50% ค่าเที่ยว (8L)</th>
            <th style="background-color: #81FAA4;border: 1px solid black;">ลง 4 ดีลเลอร์ (8L)(วิ่งคนเดียว)</th>
            <th style="background-color: #81FAA4;border: 1px solid black;">OT วันหยุด</th>
            <th style="background-color: #81FAA4;border: 1px solid black;">รวม</th>
            <th style="background-color: #FAF881;border: 1px solid black;">ค่ารถรับกลับ</th>
            <th style="background-color: #81FAA4;border: 1px solid black;">OT 1.5 เท่า</th>
            <th style="background-color: #FACE81;border: 1px solid black;">TOTAL1</th>
            <!-- END DRIVER1 -->

            <th style="background-color: #81C1FA;border: 1px solid black;">EMPCODE(2)</th>
            <th style="background-color: #81C1FA;border: 1px solid black;">DRIVER(2)</th>
            <th style="background-color: #81C1FA;border: 1px solid black;">INCENTIVE(2)</th>
            <!-- รายได้อื่นๆ พขร.2 -->
            <th style="background-color: #81C1FA;border: 1px solid black;">รับงานรอบ 2 (4L)</th>
            <th style="background-color: #81C1FA;border: 1px solid black;">ลง 3 ดีลเลอร์ (4L)</th>
            <th style="background-color: #81C1FA;border: 1px solid black;">รองาน (4L)</th>
            <th style="background-color: #81C1FA;border: 1px solid black;">ตีเปล่าบ้านโพธิ์/สำโรง (4L)</th>
            <th style="background-color: #81C1FA;border: 1px solid black;">วิ่ง SH เที่ยวเดียว (4L)</th>
            <th style="background-color: #81C1FA;border: 1px solid black;">ลง 4 ดีลเลอร์ (8L)(วิ่งคู่หาร 2)</th>
            <th style="background-color: #81C1FA;border: 1px solid black;">วิ่ง SH 50% ค่าเที่ยว (8L)</th>
            <th style="background-color: #81C1FA;border: 1px solid black;">OT วันหยุด</th>
            <th style="background-color: #81C1FA;border: 1px solid black;">รวม</th>
            <th style="background-color: #FAF881;border: 1px solid black;">ค่ารถรับกลับ</th>
            <th style="background-color: #81C1FA;border: 1px solid black;">OT 1.5 เท่า</th>
            <th style="background-color: #FACE81;border: 1px solid black;">TOTAL2</th>
            <!-- END DRIVER2 -->

            <th style="border: 1px solid black;background-color: #E2E3E4">รวมรับสุทธิ</th>
            <th style="border: 1px solid black;background-color: #E2E3E4">หมายเหตุ</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;

            if ($_GET['companycode'] == 'RCC') {
              ///ค้นหาข้อมูลสายงาน RCC
              ///ทะเบียนรถต้องไม่เท่ากับ RA หรือ ต้องเท่ากับ R
              $sql_seReporttransport1 = "SELECT  b.DATEWORKING,CONVERT(VARCHAR(30), b.DATEWORKING, 103)  AS 'DATE'
              ,SUBSTRING(CONVERT(VARCHAR, b.DATEWORKING, 108),0,6) AS 'TIME'
              ,b.JOBNO AS 'JOBNO',b.CLUSTER AS 'CLUSTER'
              ,a.TRIPNUMBER,a.TRIPNUMBER2,a.TRIPNUMBER3,a.TRIPNUMBER4,a.TRIPNUMBER5,a.JOBSTART AS 'FROM' ,a.JOBEND AS 'TO' 
              ,a.DOCUMENTCODE AS 'DO',b.THAINAME AS 'THAINAME',b.VEHICLEREGISNUMBER1 AS 'VEHICLEREGISNUMBER'
              ,a.TRIPAMOUNT AS 'UNIT',b.C2 AS 'RETURNCOUNT',a.RETURNPRICE1 AS 'RETURNPRICE1',a.RETURNPRICE2 AS 'RETURNPRICE2'
              ,a.EMPLOYEECODE1 AS 'EMPCODE1',a.EMPLOYEENAME1 AS 'EMPNAME1'
              ,a.COMPENSATION1 AS 'INCEN1',a.EMPLOYEECODE2 AS 'EMPCODE2',a.EMPLOYEENAME2 AS 'EMPNAME2',a.COMPENSATION2 AS 'INCEN2'
              ,b.VEHICLETRANSPORTPLANID AS 'PLANID'
              ,ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.JOBNO,b.VEHICLETRANSPORTPLANID,a.DOCUMENTCODE ASC) AS 'ROWNUM'
              ,b.WORKTYPE,b.C2,b.VEHICLETRANSPORTPRICEID,b.ROUNDAMOUNT AS 'TRIP'

              FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
              INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
              AND a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
              AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
              --AND (b.EMPLOYEECODE1 IN ('100007') OR b.EMPLOYEECODE1 NOT IN ('100007') )
              AND b.VEHICLEREGISNUMBER1 IS NOT NULL
              AND b.VEHICLEREGISNUMBER1 !=''
              AND b.DOCUMENTCODE IS NOT NULL
              AND b.DOCUMENTCODE !=''
              AND a.TRIPAMOUNT IS NOT NULL
              AND a.TRIPAMOUNT !=''
              AND SUBSTRING(b.THAINAME, 1, 2) != 'RA'
              ORDER BY a.EMPLOYEENAME1,b.ROUNDAMOUNT,b.JOBNO,b.DATEWORKING,a.DOCUMENTCODE ASC";
              // ORDER BY a.JOBSTART,b.DATEWORKING ASC
            $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport1, $params_seReporttransport);
        }else {
            ///ค้นหาข้อมูลสายงาน RATC
            ///ทะเบียนรถต้องเท่ากับ RA 
            $sql_seReporttransport1 = "SELECT  b.DATEWORKING,CONVERT(VARCHAR(30), b.DATEWORKING, 103)  AS 'DATE'
            ,SUBSTRING(CONVERT(VARCHAR, b.DATEWORKING, 108),0,6) AS 'TIME'
            ,b.JOBNO AS 'JOBNO',b.CLUSTER AS 'CLUSTER'
            ,a.TRIPNUMBER,a.TRIPNUMBER2,a.TRIPNUMBER3,a.TRIPNUMBER4,a.TRIPNUMBER5,a.JOBSTART AS 'FROM' ,a.JOBEND AS 'TO' 
            ,a.DOCUMENTCODE AS 'DO',b.THAINAME AS 'THAINAME',b.VEHICLEREGISNUMBER1 AS 'VEHICLEREGISNUMBER'
            ,a.TRIPAMOUNT AS 'UNIT',b.C2 AS 'RETURNCOUNT',a.RETURNPRICE1 AS 'RETURNPRICE1',a.RETURNPRICE2 AS 'RETURNPRICE2'
            ,a.EMPLOYEECODE1 AS 'EMPCODE1',a.EMPLOYEENAME1 AS 'EMPNAME1',a.COMPENSATION1 AS 'INCEN1'
            ,a.EMPLOYEECODE2 AS 'EMPCODE2',a.EMPLOYEENAME2 AS 'EMPNAME2',a.COMPENSATION2 AS 'INCEN2'
            ,b.VEHICLETRANSPORTPLANID AS 'PLANID'
            ,ROW_NUMBER() OVER (PARTITION BY b.VEHICLETRANSPORTPLANID ORDER BY b.JOBNO,b.VEHICLETRANSPORTPLANID,a.DOCUMENTCODE ASC) AS 'ROWNUM'
            ,b.WORKTYPE,b.C2,b.VEHICLETRANSPORTPRICEID,b.ROUNDAMOUNT AS 'TRIP'

            FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] a
            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
            AND a.COMPANYCODE IN ('RATC','RCC') AND a.CUSTOMERCODE ='TTT'
            AND CONVERT(DATE,b.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
            AND (b.EMPLOYEECODE1 IN ('100007') OR b.EMPLOYEECODE1 NOT IN ('100007') )
            AND b.VEHICLEREGISNUMBER1 IS NOT NULL
            AND b.VEHICLEREGISNUMBER1 !=''
            AND b.DOCUMENTCODE IS NOT NULL
            AND b.DOCUMENTCODE !=''
            AND a.TRIPAMOUNT IS NOT NULL
            AND a.TRIPAMOUNT !=''
            AND SUBSTRING(b.THAINAME, 1, 2) = 'RA'
            ORDER BY a.EMPLOYEENAME1,b.ROUNDAMOUNT,b.JOBNO,b.DATEWORKING,a.DOCUMENTCODE ASC";
            // ORDER BY a.JOBSTART,b.DATEWORKING ASC
          $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport1, $params_seReporttransport);
        }
          while ($result_seReporttransport = sqlsrv_fetch_array($query_seReporttransport, SQLSRV_FETCH_ASSOC)) {

            // ค้นหา CLUSTER
           
              $cluster = $result_seReporttransport['CLUSTER'];
            
            //////////////////////////////////////////////////

            //ค้นหาประเภทรถ
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
            ////////////////////////////////////////////////
            
            //ค้นหา TRIPNUMBER หรือ Calling Sheet No.
            // $sql_seTripNumber = "SELECT TRIPNUMBER,TRIPNUMBER2,TRIPNUMBER3,TRIPNUMBER4,TRIPNUMBER5
            //     FROM  [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] 
            //     WHERE VEHICLETRANSPORTPLANID ='".$result_seReporttransport['PLANID']."' 
            //     AND( TRIPNUMBER IS NOT NULL 
            //     OR  TRIPNUMBER2 IS NOT NULL
            //     OR TRIPNUMBER3 IS NOT NULL
            //     OR TRIPNUMBER4 IS NOT NULL
            //     OR TRIPNUMBER5 IS NOT NULL
            //     OR TRIPNUMBER IS NOT NULL)";
            // $query_seTripNumber = sqlsrv_query($conn, $sql_seTripNumber, $params_seTripNumber);
            // $result_seTripNumber = sqlsrv_fetch_array($query_seTripNumber, SQLSRV_FETCH_ASSOC);
            /////////////////////////////////////////////////

            //ค้นหาค่าเที่ยว พนักงานคนที่ 1 และ 2
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
            /////////////////////////////////////////////////////////

            //ค่าเที่ยวเพิ่มเติมกรณี4l และ 8L
            $sql_seOtherCompen = "SELECT  DISTINCT a.VEHICLETRANSPORTPLANID,a.SELECT_4LOAD1,a.PAY_4LOAD1REMARK,a.SELECT_4LOAD2,a.PAY_4LOAD2REMARK,
            a.SELECT_4LOAD3,a.PAY_4LOAD3REMARK,a.SELECT_4LOAD4,a.PAY_4LOAD4REMARK,
            a.SELECT_4LOAD5,a.PAY_4LOAD5REMARK,a.SELECT_4LOAD6,a.PAY_4LOAD6REMARK,
            a.SELECT_8LOAD1,a.PAY_8LOAD1REMARK,a.SELECT_8LOAD2,a.PAY_8LOAD2REMARK,
            a.SELECT_8LOAD3,a.PAY_8LOAD3REMARK,a.SELECT_8LOAD4,a.PAY_8LOAD4REMARK,
            a.SELECT_8LOAD5,a.PAY_8LOAD5REMARK,a.SELECT_8LOAD6,a.PAY_8LOAD6REMARK,
            a.OT180CHK,a.OT360CHK,a.OT15CHK,a.TOTALCOMPEN,a.TOTALNET,a.COMPENSATION1
            FROM VEHICLETRANSPORTDOCUMENTDIRVER a WHERE VEHICLETRANSPORTPLANID ='".$result_seReporttransport['PLANID']."'";
            $query_seOtherCompen = sqlsrv_query($conn, $sql_seOtherCompen, $params_seOtherCompen);
            $result_seOtherCompen = sqlsrv_fetch_array($query_seOtherCompen, SQLSRV_FETCH_ASSOC); 

            if ($result_seReporttransport['EMPCODE2'] == NULL OR $result_seReporttransport['EMPCODE2'] == '') {
                // EMP2 = NULL หรือว่าง แสดงว่า วิ่งงานคนเดียว
                //ค่าอื่นๆพนักงานคนที่ 1
               $SELECT4LOAD1_CHK1 = $result_seOtherCompen['SELECT_4LOAD1'];
               $SELECT4LOAD2_CHK1 = $result_seOtherCompen['SELECT_4LOAD2'];
               $SELECT4LOAD4_CHK1 = $result_seOtherCompen['SELECT_4LOAD4'];
               $SELECT4LOAD5_CHK1 = $result_seOtherCompen['SELECT_4LOAD5'];
               $SELECT4LOAD6_CHK1 = $result_seOtherCompen['SELECT_4LOAD6'];

               $SELECT8LOAD3_CHK1 = $result_seOtherCompen['SELECT_8LOAD3'];
               $SELECT8LOAD5_CHK1 = $result_seOtherCompen['SELECT_8LOAD5'];
               $SELECT8LOAD6_CHK1 = $result_seOtherCompen['SELECT_8LOAD6'];

               //ค่าอื่นๆพนักงานคนที่ 2
               $SELECT4LOAD1_CHK2 = '';
               $SELECT4LOAD2_CHK2 = '';
               $SELECT4LOAD4_CHK2 = '';
               $SELECT4LOAD5_CHK2 = '';
               $SELECT4LOAD6_CHK2 = '';

               $SELECT8LOAD3_CHK2 = '';
               $SELECT8LOAD5_CHK2 = '';

            }else {
              $SELECT4LOAD1_CHK1 = $result_seOtherCompen['SELECT_4LOAD1']/2;
              $SELECT4LOAD2_CHK1 = $result_seOtherCompen['SELECT_4LOAD2']/2;
              $SELECT4LOAD4_CHK1 = $result_seOtherCompen['SELECT_4LOAD4']/2;
              $SELECT4LOAD5_CHK1 = $result_seOtherCompen['SELECT_4LOAD5']/2;
              $SELECT4LOAD6_CHK1 = $result_seOtherCompen['SELECT_4LOAD6']/2;

              $SELECT8LOAD3_CHK1 = $result_seOtherCompen['SELECT_8LOAD3'];
              $SELECT8LOAD5_CHK1 = $result_seOtherCompen['SELECT_8LOAD5']/2;
              $SELECT8LOAD6_CHK1 = $result_seOtherCompen['SELECT_8LOAD6'];

              //ค่าอื่นๆพนักงานคนที่ 2
              $SELECT4LOAD1_CHK2 = $result_seOtherCompen['SELECT_4LOAD1']/2;
              $SELECT4LOAD2_CHK2 = $result_seOtherCompen['SELECT_4LOAD2']/2;
              $SELECT4LOAD4_CHK2 = $result_seOtherCompen['SELECT_4LOAD4']/2;
              $SELECT4LOAD5_CHK2 = $result_seOtherCompen['SELECT_4LOAD5']/2;
              $SELECT4LOAD6_CHK2 = $result_seOtherCompen['SELECT_4LOAD6']/2;

              $SELECT8LOAD3_CHK2 = $result_seOtherCompen['SELECT_8LOAD3'];
              $SELECT8LOAD5_CHK2 = $result_seOtherCompen['SELECT_8LOAD5']/2;

            }

            $OT_CHK   = $result_seOtherCompen['OT180CHK'] + $result_seOtherCompen['OT360CHK'];
            $OT15_CHK = $result_seOtherCompen['OT15CHK'];

            $TOTAL_OTHERCHK1 =($result_seCompensation1['COMPENSATION1']+$SELECT4LOAD1_CHK1+$SELECT4LOAD2_CHK1+$SELECT4LOAD4_CHK1+$SELECT4LOAD5_CHK1+$SELECT4LOAD6_CHK1
                              +$SELECT8LOAD3_CHK1+$SELECT8LOAD5_CHK1+$SELECT8LOAD6_CHK1+$OT); 
            $TOTAL_OTHERCHK2 =($result_seCompensation2['COMPENSATION2']+$SELECT4LOAD1_CHK2+$SELECT4LOAD2_CHK2+$SELECT4LOAD4_CHK2+$SELECT4LOAD5_CHK2+$SELECT4LOAD6_CHK2
                              +$SELECT8LOAD3_CHK2+$SELECT8LOAD5_CHK2+$OT);
            
            // ค่างานรับกลับ
            $RETURNPICE1_CHK = $result_seReporttransport['RETURNPRICE1'];
            $RETURNPICE2_CHK = $result_seReporttransport['RETURNPRICE2'];


            $TOTAL_ALLCHK1 = $TOTAL_OTHERCHK1+$OT15_CHK+$RETURNPICE1_CHK;
            $TOTAL_ALLCHK2 = $TOTAL_OTHERCHK2+$OT15_CHK+$RETURNPICE2_CHK;

            $SUMTOTAL_ALLCHK = $TOTAL_ALLCHK1+ $TOTAL_ALLCHK2;

            if ($result_seReporttransport['ROWNUM'] > 1) {
              $i--;
              $NO         = '';
              $EMPCODE1   ='';
              $DRIVER1    = '';
              $EMPCODE2   ='';
              $DRIVER2    = '';
              $INCEN1     = '';
              $INCEN2     = '';
              $RETURN_COUNT = '';

              // พนักงานคนที่1
              $SELECT4LOAD1_D1 = '';
              $SELECT4LOAD2_D1 = '';
              $SELECT4LOAD4_D1 = '';
              $SELECT4LOAD5_D1 = '';
              $SELECT4LOAD6_D1 = '';
              
              $SELECT8LOAD3_D1 = '';
              $SELECT8LOAD5_D1 = '';
              $SELECT8LOAD6_D1 = '';

              // พนักงานคนที่2
              $SELECT4LOAD1_D2 = '';
              $SELECT4LOAD2_D2 = '';
              $SELECT4LOAD4_D2 = '';
              $SELECT4LOAD5_D2 = '';
              $SELECT4LOAD6_D2 = '';
              
              $SELECT8LOAD3_D2 = '';
              $SELECT8LOAD5_D2 = '';


              $OT           = '';
              $TOTAL_OTHER1 = '';
              $OT15         = '';
              $TOTAL_OTHER2 = '';
              $TOTAL_ALL1   = '';
              $TOTAL_ALL2   = '';
              $SUMTOTAL_ALL = '';


            }else {
              $NO = $i;
              $INCEN1  = $result_seCompensation1['COMPENSATION1'];
              $INCEN2  = $result_seCompensation2['COMPENSATION2'];
              $RETURN_COUNT = $result_seReporttransport['RETURNCOUNT'];

              // พนักงานคนที่1
              $SELECT4LOAD1_D1 = $SELECT4LOAD1_CHK1;
              $SELECT4LOAD2_D1 = $SELECT4LOAD2_CHK1;
              $SELECT4LOAD4_D1 = $SELECT4LOAD4_CHK1;
              $SELECT4LOAD5_D1 = $SELECT4LOAD5_CHK1;
              $SELECT4LOAD6_D1 = $SELECT4LOAD6_CHK1;

              $SELECT8LOAD3_D1 = $SELECT8LOAD3_CHK1;
              $SELECT8LOAD5_D1 = $SELECT8LOAD5_CHK1;
              $SELECT8LOAD6_D1 = $SELECT8LOAD6_CHK1;

              // พนักงานคนที่2
              $SELECT4LOAD1_D2 = $SELECT4LOAD1_CHK2;
              $SELECT4LOAD2_D2 = $SELECT4LOAD2_CHK2;
              $SELECT4LOAD4_D2 = $SELECT4LOAD4_CHK2;
              $SELECT4LOAD5_D2 = $SELECT4LOAD5_CHK2;
              $SELECT4LOAD6_D2 = $SELECT4LOAD6_CHK2;

              $SELECT8LOAD3_D2 = $SELECT8LOAD3_CHK2;
              $SELECT8LOAD5_D2 = $SELECT8LOAD5_CHK2;


              $OT           = $OT_CHK;
              $TOTAL_OTHER1 = $TOTAL_OTHERCHK1;
              $RETURNPICE1  = $RETURNPICE1_CHK;
              $OT15         = $OT15_CHK;
              $TOTAL_OTHER2 = $TOTAL_OTHERCHK2;
              $RETURNPICE2  = $RETURNPICE2_CHK;
              $TOTAL_ALL1   = $TOTAL_ALLCHK1;
              $TOTAL_ALL2   = $TOTAL_ALLCHK2;
              $SUMTOTAL_ALL = $SUMTOTAL_ALLCHK;
              
            }

            
            
           

            ?>

            <tr>
              <td style="text-align: center;"><?=$NO?></td>
              <td style="text-align: center"><?=$result_seReporttransport['DATE']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['TIME']?></td>
              <td style="text-align: center;"><?=$result_seReporttransport['JOBNO']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['WORKTYPE']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['TRIP']?></td>
              <!-- <td style="text-align: center"><?=$result_seTripNumber['TRIPNUMBER']?><?=$result_seTripNumber['TRIPNUMBER2']?><?=$result_seTripNumber['TRIPNUMBER3']?><?=$result_seTripNumber['TRIPNUMBER4']?><?=$result_seTripNumber['TRIPNUMBER5']?></td> -->
              <!-- <td style="text-align: center"><?=$cluster?></td> -->
              
              <!-- FROM -->
              <?php
              //ถ้าเป็นงานรับกลับ จะไม่สลับ Jobend, Jobstart
                if($result_seReporttransport['C2'] != '' || $result_sePlanmonday['C2'] != NULL){
              ?>
                <td style="text-align: center"><?=$result_seReporttransport['FROM']?></td>
              <?php
                }else{
              ?>
                <td style="text-align: center"><?=$result_seReporttransport['FROM']?></td>
              <?php    
                }
              ?>

              <!-- TO -->
              <?php
              //ถ้าเป็นงานรับกลับ จะไม่สลับ Jobend, Jobstart
                if($result_seReporttransport['C2'] != '' || $result_sePlanmonday['C2'] != NULL){
              ?>
                <td style="text-align: center"><?=$result_seReporttransport['TO']?></td>
              <?php
                }else{
              ?>
                <td style="text-align: center"><?=$result_seReporttransport['TO']?></td>
              <?php    
                }
              ?> 

              <!-- JOBEND -->
              <!-- <td style="text-align: center"></td> -->
               
              
              <!-- <td style="text-align: center"><?=$result_seReporttransport['DO']?></td> -->
              <td style="text-align: center"><?=$result_seTruckLoad['VEHICLETYPECODE']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['THAINAME']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['UNIT']?></td>
              <td style="text-align: center"><?=$RETURN_COUNT == '0' ? '' : $RETURN_COUNT?></td>
              <td style="text-align: center"><?=$result_seReporttransport['EMPCODE1']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['EMPNAME1']?></td>
              <td style="text-align: center"><?=$INCEN1?></td>
              <!-- รายได้อื่นๆ พขร.1 -->
              <td style="text-align: center"><?=$SELECT4LOAD1_D1 == '0' ? '' : $SELECT4LOAD1_D1?></td>
              <td style="text-align: center"><?=$SELECT4LOAD2_D1 == '0' ? '' : $SELECT4LOAD2_D1?></td>
              <td style="text-align: center"><?=$SELECT4LOAD4_D1 == '0' ? '' : $SELECT4LOAD4_D1?></td>
              <td style="text-align: center"><?=$SELECT4LOAD5_D1 == '0' ? '' : $SELECT4LOAD5_D1?></td>
              <td style="text-align: center"><?=$SELECT4LOAD6_D1 == '0' ? '' : $SELECT4LOAD6_D1?></td>
              <td style="text-align: center"><?=$SELECT8LOAD3_D1 == '0' ? '' : $SELECT8LOAD3_D1?></td>
              <td style="text-align: center"><?=$SELECT8LOAD5_D1 == '0' ? '' : $SELECT8LOAD5_D1?></td>
              <td style="text-align: center"><?=$SELECT8LOAD6_D1 == '0' ? '' : $SELECT8LOAD6_D1?></td>
              <td style="text-align: center"><?=$OT   == '0' ? '' : $OT?></td>
              <td style="text-align: center"><?=$TOTAL_OTHER1 == '' ? '' : number_format($TOTAL_OTHER1)?></td>
              <td style="text-align: center"><?=$RETURNPICE1?></td>
              <td style="text-align: center"><?=$OT15 == '0' ? '' : $OT15?></td>
              <td style="text-align: center"><?=$TOTAL_ALL1   == '' ? '' : number_format($TOTAL_ALL1)?></td>
              
              <td style="text-align: center"><?=$result_seReporttransport['EMPCODE2']?></td>
              <td style="text-align: center"><?=$result_seReporttransport['EMPNAME2']?></td>
              <td style="text-align: center"><?=$INCEN2?></td>
              <!-- รายได้อื่นๆ พขร.2 -->
              <td style="text-align: center"><?=$SELECT4LOAD1_D2 == '0' ? '' : $SELECT4LOAD1_D2?></td>
              <td style="text-align: center"><?=$SELECT4LOAD2_D2 == '0' ? '' : $SELECT4LOAD2_D2?></td>
              <td style="text-align: center"><?=$SELECT4LOAD4_D2 == '0' ? '' : $SELECT4LOAD4_D2?></td>
              <td style="text-align: center"><?=$SELECT4LOAD5_D2 == '0' ? '' : $SELECT4LOAD5_D2?></td>
              <td style="text-align: center"><?=$SELECT4LOAD6_D2 == '0' ? '' : $SELECT4LOAD6_D2?></td>
              <td style="text-align: center"><?=$SELECT8LOAD3_D2 == '0' ? '' : $SELECT8LOAD3_D2?></td>
              <td style="text-align: center"><?=$SELECT8LOAD5_D2 == '0' ? '' : $SELECT8LOAD5_D2?></td>
              <td style="text-align: center"><?=$OT   == '0' ? '' : $OT?></td>
              <td style="text-align: center"><?=$TOTAL_OTHER2 == '' ? '' : number_format($TOTAL_OTHER2)?></td>
              <td style="text-align: center"><?=$RETURNPICE2?></td>
              <td style="text-align: center"><?=$OT15 == '0' ? '' : $OT15?></td>
              <td style="text-align: center"><?=$TOTAL_ALL2   == '' ? '' : number_format($TOTAL_ALL2)?></td>

              <td style="text-align: center"><?=$SUMTOTAL_ALL == '' ? '' : number_format($SUMTOTAL_ALL)?></td>
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
