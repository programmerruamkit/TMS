    <?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");


$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานค่าเที่ยว(Error).xls";
} else {
    $strExcelFileName = "รายงานค่าเที่ยว RRC ตั้งแต่วันที่" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
}


header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");
// header('Cache-Control: max-age=0');


 $monthchk = substr($_GET['datestart'],3,2);
// echo  $monthchk ;
if ($monthchk == '01') {
    $month = 'มกราคม';
}else if ($monthchk == '02') {
    $month = 'กุมภาพันธ์';
}else if ($monthchk == '03') {
    $month = 'มีนาคม';
}else if ($monthchk == '04') {
    $month = 'เมษายน';
}else if ($monthchk == '05') {
    $month = 'พฤษภาคม';
}else if ($monthchk == '06') {
    $month = 'มิถุนายน';
}else if ($monthchk == '07') {
    $month = 'กรกฎาคม';
}else if ($monthchk == '08') {
    $month = 'สิงหาคม';
}else if ($monthchk == '09') {
    $month = 'กันยายน';
}else if ($monthchk == '10') {
    $month = 'ตุลาคม';
}else if ($monthchk == '11') {
    $month = 'พฤศจิกายน';
}else if ($monthchk == '12') {
    $month = 'ธันวาคม';
}else{
    $month = '-';
}
?>
<?php
if ($_GET['companycode'] == "GMT") {
?>
<html>
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <table  border="1"  style="width: 100%;">
            <thead>
                <tr>
                    <th colspan="23" style="text-align: center;background-color: #dedede">ค่าเที่ยว สายงาน GMT</th>
                    
                </tr>
                <tr>
                    <th colspan="23" style="text-align: center;background-color: #dedede">เดือน <b><?=$month?></b> วันที่ <b><?= $_GET['datestart'] ?> - <?= $_GET['dateend'] ?></b></th>
                    
                </tr>
                <tr>   
                    <!-- <th rowspan="2" style="text-align:center;background-color: #dedede">แผน</th> -->
                    <th rowspan="3" style="text-align:center;background-color: #dedede">NO.</th>
                    <th rowspan="3" style="text-align:center;background-color: #dedede">รหัสพนักงาน</th>
                    <th rowspan="3" style="text-align:center;background-color: #dedede">รายชื่อพนักงาน</th>
                    <th colspan="6" style="text-align:center;background-color: #dedede">GMT</th>
                    <th colspan="6" style="text-align:center;background-color: #dedede">TTAST</th>
                    <th colspan="6" style="text-align:center;background-color: #dedede">Total</th>
                    
                    <th rowspan="3" style="text-align:center;background-color: #dedede">หมายเหตุ</th>
                    <th rowspan="3" style="text-align:center;background-color: #dedede">ประเภทรถ</th>

                </tr>
                 
                 <tr>
                    <!-- จำนวนเที่ยว,ค่าเที่ยว  GMT-->
                    <th colspan="3" style="text-align:center;background-color: #dedede">จำนวนเที่ยว</th>
                    <th colspan="3" style="text-align:center;background-color: #dedede">ค่าเที่ยว</th>

                    <!-- จำนวนเที่ยว,ค่าเที่ยว  TTAST-->
                    <th colspan="3" style="text-align:center;background-color: #dedede">จำนวนเที่ยว</th>
                    <th colspan="3" style="text-align:center;background-color: #dedede">ค่าเที่ยว</th>

                    <!-- จำนวนเที่ยว,ค่าเที่ยว  Total-->
                    <th colspan="3" style="text-align:center;background-color: #dedede">จำนวนเที่ยว</th>
                    <th colspan="3" style="text-align:center;background-color: #dedede">ค่าเที่ยว</th>
                </tr>

               
                <tr>
                    <!-- จำนวนเที่ยว,ค่าเที่ยว GMT -->
                    <th  style="text-align:center;background-color: #dedede">Extra</th>
                    <th  style="text-align:center;background-color: #dedede">Normal</th>
                    <th  style="text-align:center;background-color: #dedede">Total</th>
                    <th  style="text-align:center;background-color: #dedede">Extra</th>
                    <th  style="text-align:center;background-color: #dedede">Normal</th>
                    <th  style="text-align:center;background-color: #dedede">Total</th>
                    
                     <!-- จำนวนเที่ยว,ค่าเที่ยว  TTAST-->
                    <th  style="text-align:center;background-color: #dedede">Extra</th>
                    <th  style="text-align:center;background-color: #dedede">Normal</th>
                    <th  style="text-align:center;background-color: #dedede">Total</th>
                    <th  style="text-align:center;background-color: #dedede">Extra</th>
                    <th  style="text-align:center;background-color: #dedede">Normal</th>
                    <th  style="text-align:center;background-color: #dedede">Total</th>
                    
                    <!-- จำนวนเที่ยว,ค่าเที่ยว  Total-->
                    <th  style="text-align:center;background-color: #dedede">Extra</th>
                    <th  style="text-align:center;background-color: #dedede">Normal</th>
                    <th  style="text-align:center;background-color: #dedede">Total</th>
                    <th  style="text-align:center;background-color: #dedede">Extra</th>
                    <th  style="text-align:center;background-color: #dedede">Normal</th>
                    <th  style="text-align:center;background-color: #dedede">Total</th>

                    
                </tr>

            </thead>
            <tbody>
                <?php
                    $i = 1;
               

                    $sql_sePerson = "SELECT PersonCode, SUBSTRING(PersonCode, 4, 6) AS 'R_PERSONCODE',nameT,PositionNameT
                    FROM EMPLOYEEEHR2 
                    -- WHERE  (PositionNameT ='พนักงานขับรถ/GMT' OR PersonCode IN ('100007','100009'))
                    WHERE  PositionNameT ='พนักงานขับรถ/GMT'
                    ORDER BY PersonCode ASC";
                    $params_sePerson = array();
                    $query_sePerson = sqlsrv_query($conn, $sql_sePerson, $params_sePerson);
                    while ($result_sePerson = sqlsrv_fetch_array($query_sePerson, SQLSRV_FETCH_ASSOC)) {

                         //ข้อมูลสายงาน GMT
                         //ตรวจสอบข้อมูล รอบวิ่งงาน EX และ ค่าเที่ยว EX สายงาน GMT
                         $sql_sePlanEXGMT = "{call megCompensationReportRRC_v2(?,?,?,?)}";
                         $params_sePlanEXGMT = array(
                             array('select_compensationex_gmt', SQLSRV_PARAM_IN),
                             array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                             array($_GET['datestart'], SQLSRV_PARAM_IN),
                             array($_GET['dateend'], SQLSRV_PARAM_IN),
                         );
                         $query_sePlanEXGMT = sqlsrv_query($conn, $sql_sePlanEXGMT, $params_sePlanEXGMT);
                         $result_sePlanEXGMT = sqlsrv_fetch_array($query_sePlanEXGMT, SQLSRV_FETCH_ASSOC);
                 
                        //echo $result_sePlanEXGMT['COUNTEX_GMT'];

                         //ตรวจสอบข้อมูล รอบวิ่งงาน NM และ ค่าเที่ยว NM สายงาน GMT
                         $sql_sePlanNMGMT = "{call megCompensationReportRRC_v2(?,?,?,?)}";
                         $params_sePlanNMGMT = array(
                             array('select_compensationnm_gmt', SQLSRV_PARAM_IN),
                             array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                             array($_GET['datestart'], SQLSRV_PARAM_IN),
                             array($_GET['dateend'], SQLSRV_PARAM_IN),
                         );
                         $query_sePlanNMGMT = sqlsrv_query($conn, $sql_sePlanNMGMT, $params_sePlanNMGMT);
                         $result_sePlanNMGMT = sqlsrv_fetch_array($query_sePlanNMGMT, SQLSRV_FETCH_ASSOC);
                         
                         //echo $result_sePlanNMGMT['SUMCOMPENSATIONNM_GMT'];

                         //ข้อมูลสายงาน TTAST
                         //ตรวจสอบข้อมูล รอบวิ่งงาน EX และ ค่าเที่ยว EX สายงาน TTAST
                         $sql_sePlanEXTTAST = "{call megCompensationReportRRC_v2(?,?,?,?)}";
                         $params_sePlanEXTTAST  = array(
                             array('select_compensationex_ttast', SQLSRV_PARAM_IN),
                             array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                             array($_GET['datestart'], SQLSRV_PARAM_IN),
                             array($_GET['dateend'], SQLSRV_PARAM_IN),
                         );
                         $query_sePlanEXTTAST  = sqlsrv_query($conn, $sql_sePlanEXTTAST , $params_sePlanEXTTAST);
                         $result_sePlanEXTTAST  = sqlsrv_fetch_array($query_sePlanEXTTAST , SQLSRV_FETCH_ASSOC);
                 
                         //echo $result_sePlanEXTTAST ['COUNTEX_GMT'];

                         //ตรวจสอบข้อมูล รอบวิ่งงาน NM และ ค่าเที่ยว NM สายงาน TTAST
                         $sql_sePlanNMTTAST = "{call megCompensationReportRRC_v2(?,?,?,?)}";
                         $params_sePlanNMTTAST = array(
                             array('select_compensationnm_ttast', SQLSRV_PARAM_IN),
                             array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                             array($_GET['datestart'], SQLSRV_PARAM_IN),
                             array($_GET['dateend'], SQLSRV_PARAM_IN),
                         );
                         $query_sePlanNMTTAST = sqlsrv_query($conn, $sql_sePlanNMTTAST, $params_sePlanNMTTAST);
                         $result_sePlanNMTTAST = sqlsrv_fetch_array($query_sePlanNMTTAST, SQLSRV_FETCH_ASSOC);
                         
                        // echo $result_sePlanNMTTAST['SUMCOMPENSATIONNM_GMT'];


                        //   $sql_sePlanEXGMT = "SELECT MAX(a.ROWNUM) AS 'COUNTEX_GMT',SUM(CONVERT( INT, a.COMPENSATION)) AS 'SUMCOMPENSATIONEX_GMT' FROM (

                        //     SELECT ROW_NUMBER() OVER(ORDER BY a.VEHICLETRANSPORTPLANID ASC) AS 'ROWNUM',a.COMPANYCODE,a.CUSTOMERCODE,
                        //     a.VEHICLETRANSPORTPLANID,a.JOBNO,a.ROUNDAMOUNT,
                        //     CASE
                        //         WHEN a.EMPLOYEECODE1 = '100007' THEN b.COMPENSATION1
                        //         WHEN a.EMPLOYEECODE2 = '100007' THEN b.COMPENSATION2
                        //         ELSE 'Eror'
                        //     END AS 'COMPENSATION'
                            
                        //     FROM VEHICLETRANSPORTPLAN a 
                        //     INNER JOIN VEHICLETRANSPORTDOCUMENTDIRVER b ON b.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
                        //     WHERE 
                        //     CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'01/03/2023',103) AND CONVERT(DATE,'08/03/2023',103)
                        //     AND (a.EMPLOYEECODE1 = '100007' OR a.EMPLOYEECODE2 ='100007')
                        //     AND a.COMPANYCODE ='RRC' 
                        //     AND a.CUSTOMERCODE IN ('TTTC','SWN','GMT','GMT-IB','BP')
                        //     AND b.DOCUMENTCODE IS NOT NULL 
                        //     AND b.DOCUMENTCODE != ''
                        //     AND a.ROUNDAMOUNT ='2(EX)'
                        //     ) AS a";
                        //   $params_sePlanEXGMT = array();
                        //   $query_sePlanEXGMT  = sqlsrv_query($conn, $sql_sePlanEXGMT, $params_sePlanEXGMT);
                        //   $result_sePlanEXGMT = sqlsrv_fetch_array($query_sePlanEXGMT, SQLSRV_FETCH_ASSOC);
                            
                            // GMT
                            $GMT_TRIP_TOTAL   = ($result_sePlanEXGMT['COUNTEX_GMT']+$result_sePlanNMGMT['COUNTNM_GMT']);
                            $GMT_COMPEN_TOTAL = ($result_sePlanEXGMT['SUMCOMPENSATIONEX_GMT']+$result_sePlanNMGMT['SUMCOMPENSATIONNM_GMT']);
                            // TTAST
                            $TTAST_TRIP_TOTAL   = ($result_sePlanEXTTAST['COUNTEX_TTAST']+$result_sePlanNMTTAST['COUNTNM_TTAST']);
                            $TTAST_COMPEN_TOTAL = ($result_sePlanEXTTAST['SUMCOMPENSATIONEX_TTAST']+$result_sePlanNMTTAST['SUMCOMPENSATIONNM_TTAST']);
                            // TOTAL TRIP
                            $TOTAL_TRIP_EX  = ($result_sePlanEXGMT['COUNTEX_GMT']+$result_sePlanEXTTAST['COUNTEX_TTAST']);
                            $TOTAL_TRIP_NM  = ($result_sePlanNMGMT['COUNTNM_GMT']+$result_sePlanNMTTAST['COUNTNM_TTAST']);
                            $TOTAL_ALL_TRIP = $TOTAL_TRIP_EX+$TOTAL_TRIP_NM;
                            // TOTAL COMPENSATION
                            $TOTAL_COMPEN_EX  = ($result_sePlanEXGMT['SUMCOMPENSATIONEX_GMT']+$result_sePlanEXTTAST['SUMCOMPENSATIONEX_TTAST']);
                            $TOTAL_COMPEN_NM  = ($result_sePlanNMGMT['SUMCOMPENSATIONNM_GMT']+$result_sePlanNMTTAST['SUMCOMPENSATIONNM_TTAST']);
                            $TOTAL_ALL_COMPEN = $TOTAL_COMPEN_EX+$TOTAL_COMPEN_NM;
                            ?>
                            
                            <tr>
                                
                                <!-- <td style="text-align: left"><?=$result_seRepairplan['REPAIRPLANID']?></td> -->
                                <td style="text-align: left"><?= $i?></td>
                                <td style="text-align: center">RR <?=$result_sePerson['R_PERSONCODE']?></td>
                                <td style="text-align: left">นาย &nbsp;<?=$result_sePerson['nameT']?></td>
                                <!-- จำนวนเที่ยว,ค่าเที่ยว GMT -->
                                <td style="text-align: center;color:red;"><?= $result_sePlanEXGMT['COUNTEX_GMT']  == '' ? '-' : $result_sePlanEXGMT['COUNTEX_GMT'] ?></td>
                                <td style="text-align: center;color:blue;"><?= $result_sePlanNMGMT['COUNTNM_GMT'] == '' ? '-' : $result_sePlanNMGMT['COUNTNM_GMT'] ?></td>
                                <td style="text-align: center;color:green;"><?= $GMT_TRIP_TOTAL == '0' ? '-' : $GMT_TRIP_TOTAL ?></td>
                                <td style="text-align: center;color:red;"><?=  $result_sePlanEXGMT['SUMCOMPENSATIONEX_GMT']  == '' ? '-'  : number_format($result_sePlanEXGMT['SUMCOMPENSATIONEX_GMT']) ?></td>
                                <td style="text-align: center;color:blue;"><?= $result_sePlanNMGMT['SUMCOMPENSATIONNM_GMT']  == '' ? '-'  : number_format($result_sePlanNMGMT['SUMCOMPENSATIONNM_GMT']) ?></td>
                                <td style="text-align: center;color:green;"><?= $GMT_COMPEN_TOTAL == '0' ? '-' : number_format($GMT_COMPEN_TOTAL)?></td>
                                
                                <!-- จำนวนเที่ยว,ค่าเที่ยว TTAST -->
                                <td style="text-align: center;color:red;"><?= $result_sePlanEXTTAST['COUNTEX_TTAST']  == '' ? '-' : $result_sePlanEXTTAST['COUNTEX_TTAST'] ?></td>
                                <td style="text-align: center;color:blue;"><?= $result_sePlanNMTTAST['COUNTNM_TTAST']  == '' ? '-' : $result_sePlanNMTTAST['COUNTNM_TTAST'] ?></td>
                                <td style="text-align: center;color:green;"><?= $TTAST_TRIP_TOTAL == '0' ? '-' : $TTAST_TRIP_TOTAL ?></td>
                                <td style="text-align: center;color:red;"><?= $result_sePlanEXTTAST['SUMCOMPENSATIONEX_TTAST']   == '' ? '-'  : number_format($result_sePlanEXTTAST['SUMCOMPENSATIONEX_TTAST']) ?></td>
                                <td style="text-align: center;color:blue;"><?= $result_sePlanNMTTAST['SUMCOMPENSATIONNM_TTAST']  == '' ? '-'  : number_format($result_sePlanNMTTAST['SUMCOMPENSATIONNM_TTAST']) ?></td>
                                <td style="text-align: center;color:green;"><?= $TTAST_COMPEN_TOTAL == '0' ? '-' : number_format($TTAST_COMPEN_TOTAL)?></td>

                                <!-- จำนวนเที่ยว,ค่าเที่ยว Total -->
                                <td style="text-align: center;color:red;"><?=$TOTAL_TRIP_EX     == '0' ? '-' : $TOTAL_TRIP_EX?></td>
                                <td style="text-align: center;color:blue;"><?=$TOTAL_TRIP_NM    == '0' ? '-' : $TOTAL_TRIP_NM?></td>
                                <td style="text-align: center;color:green;"><?=$TOTAL_ALL_TRIP  == '0' ? '-' : $TOTAL_ALL_TRIP?></td>
                                <td style="text-align: center;color:red;"><?=$TOTAL_COMPEN_EX   == '0' ? '-' : number_format($TOTAL_COMPEN_EX)?></td>
                                <td style="text-align: center;color:blue;"><?=$TOTAL_COMPEN_NM  == '0' ? '-' : number_format($TOTAL_COMPEN_NM)?></td>
                                <td style="text-align: center"><?=$TOTAL_ALL_COMPEN  == '0' ? '-' : number_format($TOTAL_ALL_COMPEN)?></td>

                                <!-- หมายเหตุ,ประเถทรถ -->
                                <td style="text-align: center"></td>
                                <td style="text-align: center"></td>
                            </tr>

                        <?php
                          //GMT จำนวนเที่ยว
                          $SUMEX_TRIP_GMT  = $SUMEX_TRIP_GMT + $result_sePlanEXGMT['COUNTEX_GMT'];
                          $SUMNM_TRIP_GMT  = $SUMNM_TRIP_GMT + $result_sePlanNMGMT['COUNTNM_GMT'];
                          $TOTAL_TRIP_GMT  = $TOTAL_TRIP_GMT + $GMT_TRIP_TOTAL;
                          //GMT ค่าเที่ยว
                          $SUMEX_COMPEN_GMT  = $SUMEX_COMPEN_GMT + $result_sePlanEXGMT['SUMCOMPENSATIONEX_GMT'];
                          $SUMNM_COMPEN_GMT  = $SUMNM_COMPEN_GMT + $result_sePlanNMGMT['SUMCOMPENSATIONNM_GMT'];
                          $TOTAL_COMPEN_GMT  = $TOTAL_COMPEN_GMT + $GMT_COMPEN_TOTAL;
                          //TTAST จำนวนเที่ยว
                          $SUMEX_TRIP_TTAST  = $SUMEX_TRIP_TTAST + $result_sePlanEXTTAST['COUNTEX_TTAST'];
                          $SUMNM_TRIP_TTAST  = $SUMNM_TRIP_TTAST + $result_sePlanNMTTAST['COUNTNM_TTAST'];
                          $TOTAL_TRIP_TTAST  = $TOTAL_TRIP_TTAST + $TTAST_TRIP_TOTAL;
                          //TTAST ค่าเที่ยว
                          $SUMEX_COMPEN_TTAST  = $SUMEX_COMPEN_TTAST + $result_sePlanEXTTAST['SUMCOMPENSATIONEX_TTAST'];
                          $SUMNM_COMPEN_TTAST  = $SUMNM_COMPEN_TTAST + $result_sePlanNMTTAST['SUMCOMPENSATIONNM_TTAST'];
                          $TOTAL_COMPEN_TTAST  = $TOTAL_COMPEN_TTAST + $TTAST_COMPEN_TOTAL;

                          //TOTAL
                          $SUMTOTAL_EX_TRIP     = $SUMTOTAL_EX_TRIP     + $TOTAL_TRIP_EX;
                          $SUMTOTAL_NM_TRIP     = $SUMTOTAL_NM_TRIP     + $TOTAL_TRIP_NM;
                          $SUMTOTAL_TRIP_TOTAL  = $SUMTOTAL_TRIP_TOTAL  + $TOTAL_ALL_TRIP;

                          $SUMTOTAL_EX_COMPEN     = $SUMTOTAL_EX_COMPEN     + $TOTAL_COMPEN_EX;
                          $SUMTOTAL_NM_COMPEN     = $SUMTOTAL_NM_COMPEN     + $TOTAL_COMPEN_NM;
                          $SUMTOTAL_COMPEN_TOTAL  = $SUMTOTAL_COMPEN_TOTAL  + $TOTAL_ALL_COMPEN;



                        $i++;   
                    }
                    ?>
                <tr>
                    <td colspan="3" style="text-align: right;background-color: #dedede">รวม</ก>
                    <td style="text-align: center;"><b><?=$SUMEX_TRIP_GMT  == '0' ? '-' : $SUMEX_TRIP_GMT?></b></td>
                    <td style="text-align: center;"><b><?=$SUMNM_TRIP_GMT  == '0' ? '-' : $SUMNM_TRIP_GMT?></b></td>
                    <td style="text-align: center;"><b><?=$TOTAL_TRIP_GMT  == '0' ? '-' : $TOTAL_TRIP_GMT?></b></td>
                    <td style="text-align: center;"><b><?=$SUMEX_COMPEN_GMT  == '0' ? '-' : number_format($SUMEX_COMPEN_GMT)?></b></td>
                    <td style="text-align: center;"><b><?=$SUMNM_COMPEN_GMT  == '0' ? '-' : number_format($SUMNM_COMPEN_GMT)?></b></td>
                    <td style="text-align: center;"><b><?=$TOTAL_COMPEN_GMT  == '0' ? '-' : number_format($TOTAL_COMPEN_GMT)?></b></td>

                    <td style="text-align: center;"><b><?=$SUMEX_TRIP_TTAST     == '0' ? '-' : $SUMEX_TRIP_TTAST?></b></td>
                    <td style="text-align: center;"><b><?=$SUMNM_TRIP_TTAST     == '0' ? '-' : $SUMNM_TRIP_TTAST?></b></td>
                    <td style="text-align: center;"><b><?=$TOTAL_TRIP_TTAST     == '0' ? '-' : $TOTAL_TRIP_TTAST?></b></td>
                    <td style="text-align: center;"><b><?=$SUMEX_COMPEN_TTAST   == '0' ? '-' : number_format($SUMEX_COMPEN_TTAST)?></b></td>
                    <td style="text-align: center;"><b><?=$SUMNM_COMPEN_TTAST   == '0' ? '-' : number_format($SUMNM_COMPEN_TTAST)?></b></td>
                    <td style="text-align: center;"><b><?=$TOTAL_COMPEN_TTAST   == '0' ? '-' : number_format($TOTAL_COMPEN_TTAST)?></b></td>

                    <td style="text-align: center;"><b><?=$SUMTOTAL_EX_TRIP         == '0' ? '-' : $SUMTOTAL_EX_TRIP?></b></td>
                    <td style="text-align: center;"><b><?=$SUMTOTAL_NM_TRIP         == '0' ? '-' : $SUMTOTAL_NM_TRIP?></b></td>
                    <td style="text-align: center;"><b><?=$SUMTOTAL_TRIP_TOTAL      == '0' ? '-' : $SUMTOTAL_TRIP_TOTAL?></b></td>
                    <td style="text-align: center;"><b><?=$SUMTOTAL_EX_COMPEN       == '0' ? '-' : number_format($SUMTOTAL_EX_COMPEN)?></b></td>
                    <td style="text-align: center;"><b><?=$SUMTOTAL_NM_COMPEN       == '0' ? '-' : number_format($SUMTOTAL_NM_COMPEN)?></b></td>
                    <td style="text-align: center;"><b><?=$SUMTOTAL_COMPEN_TOTAL    == '0' ? '-' : number_format($SUMTOTAL_COMPEN_TOTAL)?></b></td>

                    <td style="text-align: center;"><b></b></td>
                    <td style="text-align: center;"><b></b></td>
                </tr>
            </tbody>
        </table>
        <br><br>
        <table style="text-align: center;background-color: #ffffff;border-collapse: collapse;">
            <tfoot>
                <tr>
                    <td colspan="11" style="text-align: center;"></td>
                    <td colspan="3" style="text-align: center;background-color: #ffffff;border-collapse: collapse;border:1px solid #000">ISSUE BY</td>
                    <td colspan="3" style="text-align: center;background-color: #ffffff;border-collapse: collapse;border:1px solid #000">CHECK BY</td>
                    <td colspan="3" style="text-align: center;background-color: #ffffff;border-collapse: collapse;border:1px solid #000">APPROVE BY</td>
                </tr>
                <tr>
                    <td colspan="11" style="text-align: center;"></td>
                    <td colspan="3" style="text-align: center;border:1px solid #000"><br><br><br></td>
                    <td colspan="3" style="text-align: center;border:1px solid #000"><br><br><br></td>
                    <td colspan="3" style="text-align: center;border:1px solid #000"><br><br><br></td>
                </tr>
                <tr>
                    <td colspan="11" style="text-align: center;"></td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">(นางสาวพุทธิดา เสาวนา)</td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">(นายธีรศักดิ์ สมศรี)</td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">(นายบัญชา กงแก้ว)</td>
                </tr>
                <tr>
                    <td colspan="11" style="text-align: center;"></td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">เจ้าหน้าที่อาวุโสแผนกปฏิบัติการ<br>ฝ่ายงานขนส่ง</td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">หัวหน้างานแผนกปฏิบัติการ<br>ฝ่ายงานขนส่ง</td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">ผจก.แผนกปฏิบัติการ<br>ฝ่ายงานขนส่ง</td>
                </tr> 
                <tr>
                    <td colspan="11" style="text-align: center;"></td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">ลงวันที่ .......... /.......... /..........</td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">ลงวันที่ .......... /.......... /..........</td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">ลงวันที่ .......... /.......... /..........</td>
                </tr>   
            </tfoot>
        </table>
        
    </body>
</html>
<?php
}else if($_GET['companycode'] == "TTAST"){
?>
<html>
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <table  border="1"  style="width: 100%;">
            <thead>
                <tr>
                    <th colspan="23" style="text-align: center;background-color: #dedede">ค่าเที่ยว สายงาน TTAST </th>
                    
                </tr>
                <tr>
                    <th colspan="23" style="text-align: center;background-color: #dedede">เดือน <b><?=$month?></b> วันที่ <b><?= $_GET['datestart'] ?> - <?= $_GET['dateend'] ?></b></th>
                    
                </tr>
                <tr>   
                    <!-- <th rowspan="2" style="text-align:center;background-color: #dedede">แผน</th> -->
                    <th rowspan="3" style="text-align:center;background-color: #dedede">NO.</th>
                    <th rowspan="3" style="text-align:center;background-color: #dedede">รหัสพนักงาน</th>
                    <th rowspan="3" style="text-align:center;background-color: #dedede">รายชื่อพนักงาน</th>
                    <th colspan="6" style="text-align:center;background-color: #dedede">GMT</th>
                    <th colspan="6" style="text-align:center;background-color: #dedede">TTAST</th>
                    <th colspan="6" style="text-align:center;background-color: #dedede">Total</th>
                    
                    <th rowspan="3" style="text-align:center;background-color: #dedede">หมายเหตุ</th>
                    <th rowspan="3" style="text-align:center;background-color: #dedede">ประเภทรถ</th>

                </tr>
                 
                 <tr>
                    <!-- จำนวนเที่ยว,ค่าเที่ยว  GMT-->
                    <th colspan="3" style="text-align:center;background-color: #dedede">จำนวนเที่ยว</th>
                    <th colspan="3" style="text-align:center;background-color: #dedede">ค่าเที่ยว</th>

                    <!-- จำนวนเที่ยว,ค่าเที่ยว  TTAST-->
                    <th colspan="3" style="text-align:center;background-color: #dedede">จำนวนเที่ยว</th>
                    <th colspan="3" style="text-align:center;background-color: #dedede">ค่าเที่ยว</th>

                    <!-- จำนวนเที่ยว,ค่าเที่ยว  Total-->
                    <th colspan="3" style="text-align:center;background-color: #dedede">จำนวนเที่ยว</th>
                    <th colspan="3" style="text-align:center;background-color: #dedede">ค่าเที่ยว</th>
                </tr>

               
                <tr>
                    <!-- จำนวนเที่ยว,ค่าเที่ยว GMT -->
                    <th  style="text-align:center;background-color: #dedede">Extra</th>
                    <th  style="text-align:center;background-color: #dedede">Normal</th>
                    <th  style="text-align:center;background-color: #dedede">Total</th>
                    <th  style="text-align:center;background-color: #dedede">Extra</th>
                    <th  style="text-align:center;background-color: #dedede">Normal</th>
                    <th  style="text-align:center;background-color: #dedede">Total</th>
                    
                     <!-- จำนวนเที่ยว,ค่าเที่ยว  TTAST-->
                    <th  style="text-align:center;background-color: #dedede">Extra</th>
                    <th  style="text-align:center;background-color: #dedede">Normal</th>
                    <th  style="text-align:center;background-color: #dedede">Total</th>
                    <th  style="text-align:center;background-color: #dedede">Extra</th>
                    <th  style="text-align:center;background-color: #dedede">Normal</th>
                    <th  style="text-align:center;background-color: #dedede">Total</th>
                    
                    <!-- จำนวนเที่ยว,ค่าเที่ยว  Total-->
                    <th  style="text-align:center;background-color: #dedede">Extra</th>
                    <th  style="text-align:center;background-color: #dedede">Normal</th>
                    <th  style="text-align:center;background-color: #dedede">Total</th>
                    <th  style="text-align:center;background-color: #dedede">Extra</th>
                    <th  style="text-align:center;background-color: #dedede">Normal</th>
                    <th  style="text-align:center;background-color: #dedede">Total</th>

                    
                </tr>

            </thead>
            <tbody>
                    <?php
                            $i = 1;
               

                        $sql_sePerson = "SELECT PersonCode, SUBSTRING(PersonCode, 4, 6) AS 'R_PERSONCODE',nameT,PositionNameT
                        FROM EMPLOYEEEHR2 
                        -- WHERE  (PositionNameT ='พนักงานขับรถ/TTAST/เกตเวย์' OR PersonCode IN ('100007','100009'))
                        WHERE  PositionNameT ='พนักงานขับรถ/TTAST/เกตเวย์'
                        ORDER BY PersonCode ASC";
                        $params_sePerson = array();
                        $query_sePerson = sqlsrv_query($conn, $sql_sePerson, $params_sePerson);
                        while ($result_sePerson = sqlsrv_fetch_array($query_sePerson, SQLSRV_FETCH_ASSOC)) {

                            //ข้อมูลสายงาน GMT
                            //ตรวจสอบข้อมูล รอบวิ่งงาน EX และ ค่าเที่ยว EX สายงาน GMT
                            $sql_sePlanEXGMT = "{call megCompensationReportRRC_v2(?,?,?,?)}";
                            $params_sePlanEXGMT = array(
                                array('select_compensationex_gmt', SQLSRV_PARAM_IN),
                                array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                                array($_GET['datestart'], SQLSRV_PARAM_IN),
                                array($_GET['dateend'], SQLSRV_PARAM_IN),
                            );
                            $query_sePlanEXGMT = sqlsrv_query($conn, $sql_sePlanEXGMT, $params_sePlanEXGMT);
                            $result_sePlanEXGMT = sqlsrv_fetch_array($query_sePlanEXGMT, SQLSRV_FETCH_ASSOC);
                    
                            //echo $result_sePlanEXGMT['COUNTEX_GMT'];

                            //ตรวจสอบข้อมูล รอบวิ่งงาน NM และ ค่าเที่ยว NM สายงาน GMT
                            $sql_sePlanNMGMT = "{call megCompensationReportRRC_v2(?,?,?,?)}";
                            $params_sePlanNMGMT = array(
                                array('select_compensationnm_gmt', SQLSRV_PARAM_IN),
                                array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                                array($_GET['datestart'], SQLSRV_PARAM_IN),
                                array($_GET['dateend'], SQLSRV_PARAM_IN),
                            );
                            $query_sePlanNMGMT = sqlsrv_query($conn, $sql_sePlanNMGMT, $params_sePlanNMGMT);
                            $result_sePlanNMGMT = sqlsrv_fetch_array($query_sePlanNMGMT, SQLSRV_FETCH_ASSOC);
                            
                            //echo $result_sePlanNMGMT['SUMCOMPENSATIONNM_GMT'];

                            //ข้อมูลสายงาน TTAST
                            //ตรวจสอบข้อมูล รอบวิ่งงาน EX และ ค่าเที่ยว EX สายงาน TTAST
                            $sql_sePlanEXTTAST = "{call megCompensationReportRRC_v2(?,?,?,?)}";
                            $params_sePlanEXTTAST  = array(
                                array('select_compensationex_ttast', SQLSRV_PARAM_IN),
                                array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                                array($_GET['datestart'], SQLSRV_PARAM_IN),
                                array($_GET['dateend'], SQLSRV_PARAM_IN),
                            );
                            $query_sePlanEXTTAST  = sqlsrv_query($conn, $sql_sePlanEXTTAST , $params_sePlanEXTTAST);
                            $result_sePlanEXTTAST  = sqlsrv_fetch_array($query_sePlanEXTTAST , SQLSRV_FETCH_ASSOC);
                    
                            //echo $result_sePlanEXTTAST ['COUNTEX_GMT'];

                            //ตรวจสอบข้อมูล รอบวิ่งงาน NM และ ค่าเที่ยว NM สายงาน TTAST
                            $sql_sePlanNMTTAST = "{call megCompensationReportRRC_v2(?,?,?,?)}";
                            $params_sePlanNMTTAST = array(
                                array('select_compensationnm_ttast', SQLSRV_PARAM_IN),
                                array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                                array($_GET['datestart'], SQLSRV_PARAM_IN),
                                array($_GET['dateend'], SQLSRV_PARAM_IN),
                            );
                            $query_sePlanNMTTAST = sqlsrv_query($conn, $sql_sePlanNMTTAST, $params_sePlanNMTTAST);
                            $result_sePlanNMTTAST = sqlsrv_fetch_array($query_sePlanNMTTAST, SQLSRV_FETCH_ASSOC);
                            
                            // echo $result_sePlanNMTTAST['COUNTNM_TTAST'];


                            // GMT
                            $GMT_TRIP_TOTAL   = ($result_sePlanEXGMT['COUNTEX_GMT']+$result_sePlanNMGMT['COUNTNM_GMT']);
                            $GMT_COMPEN_TOTAL = ($result_sePlanEXGMT['SUMCOMPENSATIONEX_GMT']+$result_sePlanNMGMT['SUMCOMPENSATIONNM_GMT']);
                            // TTAST
                            $TTAST_TRIP_TOTAL   = ($result_sePlanEXTTAST['COUNTEX_TTAST']+$result_sePlanNMTTAST['COUNTNM_TTAST']);
                            $TTAST_COMPEN_TOTAL = ($result_sePlanEXTTAST['SUMCOMPENSATIONEX_TTAST']+$result_sePlanNMTTAST['SUMCOMPENSATIONNM_TTAST']);
                            // TOTAL TRIP
                            $TOTAL_TRIP_EX  = ($result_sePlanEXGMT['COUNTEX_GMT']+$result_sePlanEXTTAST['COUNTEX_TTAST']);
                            $TOTAL_TRIP_NM  = ($result_sePlanNMGMT['COUNTNM_GMT']+$result_sePlanNMTTAST['COUNTNM_TTAST']);
                            $TOTAL_ALL_TRIP = $TOTAL_TRIP_EX+$TOTAL_TRIP_NM;
                            // TOTAL COMPENSATION
                            $TOTAL_COMPEN_EX  = ($result_sePlanEXGMT['SUMCOMPENSATIONEX_GMT']+$result_sePlanEXTTAST['SUMCOMPENSATIONEX_TTAST']);
                            $TOTAL_COMPEN_NM  = ($result_sePlanNMGMT['SUMCOMPENSATIONNM_GMT']+$result_sePlanNMTTAST['SUMCOMPENSATIONNM_TTAST']);
                            $TOTAL_ALL_COMPEN = $TOTAL_COMPEN_EX+$TOTAL_COMPEN_NM;
                            ?>
                            
                            <tr>
                                
                                <!-- <td style="text-align: left"><?=$result_seRepairplan['REPAIRPLANID']?></td> -->
                                <td style="text-align: left"><?= $i?></td>
                                <td style="text-align: center">RR <?=$result_sePerson['R_PERSONCODE']?></td>
                                <td style="text-align: left">นาย &nbsp;<?=$result_sePerson['nameT']?></td>
                                <!-- จำนวนเที่ยว,ค่าเที่ยว GMT -->
                                <td style="text-align: center;color:red;"><?= $result_sePlanEXGMT['COUNTEX_GMT']  == '' ? '-' : $result_sePlanEXGMT['COUNTEX_GMT'] ?></td>
                                <td style="text-align: center;color:blue;"><?= $result_sePlanNMGMT['COUNTNM_GMT'] == '' ? '-' : $result_sePlanNMGMT['COUNTNM_GMT'] ?></td>
                                <td style="text-align: center;color:green;"><?= $GMT_TRIP_TOTAL == '0' ? '-' : $GMT_TRIP_TOTAL ?></td>
                                <td style="text-align: center;color:red;"><?=  $result_sePlanEXGMT['SUMCOMPENSATIONEX_GMT']  == '' ? '-'  : number_format($result_sePlanEXGMT['SUMCOMPENSATIONEX_GMT']) ?></td>
                                <td style="text-align: center;color:blue;"><?= $result_sePlanNMGMT['SUMCOMPENSATIONNM_GMT']  == '' ? '-'  : number_format($result_sePlanNMGMT['SUMCOMPENSATIONNM_GMT']) ?></td>
                                <td style="text-align: center;color:green;"><?= $GMT_COMPEN_TOTAL == '0' ? '-' : number_format($GMT_COMPEN_TOTAL)?></td>
                                
                                <!-- จำนวนเที่ยว,ค่าเที่ยว TTAST -->
                                <td style="text-align: center;color:red;"><?= $result_sePlanEXTTAST['COUNTEX_TTAST']  == '' ? '-' : $result_sePlanEXTTAST['COUNTEX_TTAST'] ?></td>
                                <td style="text-align: center;color:blue;"><?= $result_sePlanNMTTAST['COUNTNM_TTAST']  == '' ? '-' : $result_sePlanNMTTAST['COUNTNM_TTAST'] ?></td>
                                <td style="text-align: center;color:green;"><?= $TTAST_TRIP_TOTAL == '0' ? '-' : $TTAST_TRIP_TOTAL ?></td>
                                <td style="text-align: center;color:red;"><?= $result_sePlanEXTTAST['SUMCOMPENSATIONEX_TTAST']   == '' ? '-'  : number_format($result_sePlanEXTTAST['SUMCOMPENSATIONEX_TTAST']) ?></td>
                                <td style="text-align: center;color:blue;"><?= $result_sePlanNMTTAST['SUMCOMPENSATIONNM_TTAST']  == '' ? '-'  : number_format($result_sePlanNMTTAST['SUMCOMPENSATIONNM_TTAST']) ?></td>
                                <td style="text-align: center;color:green;"><?= $TTAST_COMPEN_TOTAL == '0' ? '-' : number_format($TTAST_COMPEN_TOTAL)?></td>

                                <!-- จำนวนเที่ยว,ค่าเที่ยว Total -->
                                <td style="text-align: center;color:red;"><?=$TOTAL_TRIP_EX     == '0' ? '-' : $TOTAL_TRIP_EX?></td>
                                <td style="text-align: center;color:blue;"><?=$TOTAL_TRIP_NM    == '0' ? '-' : $TOTAL_TRIP_NM?></td>
                                <td style="text-align: center;color:green;"><?=$TOTAL_ALL_TRIP  == '0' ? '-' : $TOTAL_ALL_TRIP?></td>
                                <td style="text-align: center;color:red;"><?=$TOTAL_COMPEN_EX   == '0' ? '-' : number_format($TOTAL_COMPEN_EX)?></td>
                                <td style="text-align: center;color:blue;"><?=$TOTAL_COMPEN_NM  == '0' ? '-' : number_format($TOTAL_COMPEN_NM)?></td>
                                <td style="text-align: center"><?=$TOTAL_ALL_COMPEN  == '0' ? '-' : number_format($TOTAL_ALL_COMPEN)?></td>

                                <!-- หมายเหตุ,ประเถทรถ -->
                                <td style="text-align: center"></td>
                                <td style="text-align: center"></td>
                            </tr>

                            <?php
                            //GMT จำนวนเที่ยว
                            $SUMEX_TRIP_GMT  = $SUMEX_TRIP_GMT + $result_sePlanEXGMT['COUNTEX_GMT'];
                            $SUMNM_TRIP_GMT  = $SUMNM_TRIP_GMT + $result_sePlanNMGMT['COUNTNM_GMT'];
                            $TOTAL_TRIP_GMT  = $TOTAL_TRIP_GMT + $GMT_TRIP_TOTAL;
                            //GMT ค่าเที่ยว
                            $SUMEX_COMPEN_GMT  = $SUMEX_COMPEN_GMT + $result_sePlanEXGMT['SUMCOMPENSATIONEX_GMT'];
                            $SUMNM_COMPEN_GMT  = $SUMNM_COMPEN_GMT + $result_sePlanNMGMT['SUMCOMPENSATIONNM_GMT'];
                            $TOTAL_COMPEN_GMT  = $TOTAL_COMPEN_GMT + $GMT_COMPEN_TOTAL;
                            //TTAST จำนวนเที่ยว
                            $SUMEX_TRIP_TTAST  = $SUMEX_TRIP_TTAST + $result_sePlanEXTTAST['COUNTEX_TTAST'];
                            $SUMNM_TRIP_TTAST  = $SUMNM_TRIP_TTAST + $result_sePlanNMTTAST['COUNTNM_TTAST'];
                            $TOTAL_TRIP_TTAST  = $TOTAL_TRIP_TTAST + $TTAST_TRIP_TOTAL;
                            //TTAST ค่าเที่ยว
                            $SUMEX_COMPEN_TTAST  = $SUMEX_COMPEN_TTAST + $result_sePlanEXTTAST['SUMCOMPENSATIONEX_TTAST'];
                            $SUMNM_COMPEN_TTAST  = $SUMNM_COMPEN_TTAST + $result_sePlanNMTTAST['SUMCOMPENSATIONNM_TTAST'];
                            $TOTAL_COMPEN_TTAST  = $TOTAL_COMPEN_TTAST + $TTAST_COMPEN_TOTAL;

                            //TOTAL
                            $SUMTOTAL_EX_TRIP     = $SUMTOTAL_EX_TRIP     + $TOTAL_TRIP_EX;
                            $SUMTOTAL_NM_TRIP     = $SUMTOTAL_NM_TRIP     + $TOTAL_TRIP_NM;
                            $SUMTOTAL_TRIP_TOTAL  = $SUMTOTAL_TRIP_TOTAL  + $TOTAL_ALL_TRIP;

                            $SUMTOTAL_EX_COMPEN     = $SUMTOTAL_EX_COMPEN     + $TOTAL_COMPEN_EX;
                            $SUMTOTAL_NM_COMPEN     = $SUMTOTAL_NM_COMPEN     + $TOTAL_COMPEN_NM;
                            $SUMTOTAL_COMPEN_TOTAL  = $SUMTOTAL_COMPEN_TOTAL  + $TOTAL_ALL_COMPEN;



                            $i++;   
                        }
                        ?>
                <tr>
                    <td colspan="3" style="text-align: right;background-color: #dedede">รวม</ก>
                    <td style="text-align: center;"><b><?=$SUMEX_TRIP_GMT  == '0' ? '-' : $SUMEX_TRIP_GMT?></b></td>
                    <td style="text-align: center;"><b><?=$SUMNM_TRIP_GMT  == '0' ? '-' : $SUMNM_TRIP_GMT?></b></td>
                    <td style="text-align: center;"><b><?=$TOTAL_TRIP_GMT  == '0' ? '-' : $TOTAL_TRIP_GMT?></b></td>
                    <td style="text-align: center;"><b><?=$SUMEX_COMPEN_GMT  == '0' ? '-' : number_format($SUMEX_COMPEN_GMT)?></b></td>
                    <td style="text-align: center;"><b><?=$SUMNM_COMPEN_GMT  == '0' ? '-' : number_format($SUMNM_COMPEN_GMT)?></b></td>
                    <td style="text-align: center;"><b><?=$TOTAL_COMPEN_GMT  == '0' ? '-' : number_format($TOTAL_COMPEN_GMT)?></b></td>

                    <td style="text-align: center;"><b><?=$SUMEX_TRIP_TTAST     == '0' ? '-' : $SUMEX_TRIP_TTAST?></b></td>
                    <td style="text-align: center;"><b><?=$SUMNM_TRIP_TTAST     == '0' ? '-' : $SUMNM_TRIP_TTAST?></b></td>
                    <td style="text-align: center;"><b><?=$TOTAL_TRIP_TTAST     == '0' ? '-' : $TOTAL_TRIP_TTAST?></b></td>
                    <td style="text-align: center;"><b><?=$SUMEX_COMPEN_TTAST   == '0' ? '-' : number_format($SUMEX_COMPEN_TTAST)?></b></td>
                    <td style="text-align: center;"><b><?=$SUMNM_COMPEN_TTAST   == '0' ? '-' : number_format($SUMNM_COMPEN_TTAST)?></b></td>
                    <td style="text-align: center;"><b><?=$TOTAL_COMPEN_TTAST   == '0' ? '-' : number_format($TOTAL_COMPEN_TTAST)?></b></td>

                    <td style="text-align: center;"><b><?=$SUMTOTAL_EX_TRIP         == '0' ? '-' : $SUMTOTAL_EX_TRIP?></b></td>
                    <td style="text-align: center;"><b><?=$SUMTOTAL_NM_TRIP         == '0' ? '-' : $SUMTOTAL_NM_TRIP?></b></td>
                    <td style="text-align: center;"><b><?=$SUMTOTAL_TRIP_TOTAL      == '0' ? '-' : $SUMTOTAL_TRIP_TOTAL?></b></td>
                    <td style="text-align: center;"><b><?=$SUMTOTAL_EX_COMPEN       == '0' ? '-' : number_format($SUMTOTAL_EX_COMPEN)?></b></td>
                    <td style="text-align: center;"><b><?=$SUMTOTAL_NM_COMPEN       == '0' ? '-' : number_format($SUMTOTAL_NM_COMPEN)?></b></td>
                    <td style="text-align: center;"><b><?=$SUMTOTAL_COMPEN_TOTAL    == '0' ? '-' : number_format($SUMTOTAL_COMPEN_TOTAL)?></b></td>

                    <td style="text-align: center;"><b></b></td>
                    <td style="text-align: center;"><b></b></td>
                </tr>
            </tbody>
        </table>
        <br><br>
        <table style="text-align: center;background-color: #ffffff;border-collapse: collapse;">
            <tfoot>
                <tr>
                    <td colspan="11" style="text-align: center;"></td>
                    <td colspan="3" style="text-align: center;background-color: #ffffff;border-collapse: collapse;border:1px solid #000">ISSUE BY</td>
                    <td colspan="3" style="text-align: center;background-color: #ffffff;border-collapse: collapse;border:1px solid #000">CHECK BY</td>
                    <td colspan="3" style="text-align: center;background-color: #ffffff;border-collapse: collapse;border:1px solid #000">APPROVE BY</td>
                </tr>
                <tr>
                    <td colspan="11" style="text-align: center;"></td>
                    <td colspan="3" style="text-align: center;border:1px solid #000"><br><br><br></td>
                    <td colspan="3" style="text-align: center;border:1px solid #000"><br><br><br></td>
                    <td colspan="3" style="text-align: center;border:1px solid #000"><br><br><br></td>
                </tr>
                <tr>
					<td colspan="11" style="text-align: center;"></td>
					<td colspan="3" style="text-align: center;border:1px solid #000">(นางสาวพุทธิดา เสาวนา)</td>
					<td colspan="3" style="text-align: center;border:1px solid #000">(นายวรวิทย์ คุณเจริญ)</td>
					<td colspan="3" style="text-align: center;border:1px solid #000">(นายบัญชา กงแก้ว)</td>
				</tr>
				<tr>
					<td colspan="11" style="text-align: center;"></td>
					<td colspan="3" style="text-align: center;border:1px solid #000">เจ้าหน้าที่อาวุโสแผนกปฏิบัติการ<br>ฝ่ายงานขนส่ง</td>
					<td colspan="3" style="text-align: center;border:1px solid #000">ผช.ผจก.แผนกปฏิบัติการ<br>ฝ่ายงานขนส่ง</td>
					<td colspan="3" style="text-align: center;border:1px solid #000">ผจก.แผนกปฏิบัติการ<br>ฝ่ายงานขนส่ง</td>
				</tr> 
				<tr>
					<td colspan="11" style="text-align: center;"></td>
					<td colspan="3" style="text-align: center;border:1px solid #000">ลงวันที่ .......... /.......... /..........</td>
					<td colspan="3" style="text-align: center;border:1px solid #000">ลงวันที่ .......... /.......... /..........</td>
					<td colspan="3" style="text-align: center;border:1px solid #000">ลงวันที่ .......... /.......... /..........</td>
				</tr>   
            </tfoot>
        </table>
        
    </body>
</html>
<?php
}else{
    ?>
    <html>
        <head>
            <link rel="shortcut icon" href="../images/logo.ico" />
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        </head>
        <body>
            <table  border="1"  style="width: 100%;">
                <thead>
                    <tr>
                        <th colspan="23" style="text-align: center;background-color: #dedede">ค่าเที่ยว สายงาน GMT</th>
                        
                    </tr>
                    <tr>
                        <th colspan="23" style="text-align: center;background-color: #dedede">เดือน <b><?=$month?></b> วันที่ <b><?= $_GET['datestart'] ?> - <?= $_GET['dateend'] ?></b></th>
                        
                    </tr>
                    <tr>   
                        <!-- <th rowspan="2" style="text-align:center;background-color: #dedede">แผน</th> -->
                        <th rowspan="3" style="text-align:center;background-color: #dedede">NO.</th>
                        <th rowspan="3" style="text-align:center;background-color: #dedede">รหัสพนักงาน</th>
                        <th rowspan="3" style="text-align:center;background-color: #dedede">รายชื่อพนักงาน</th>
                        <th colspan="6" style="text-align:center;background-color: #dedede">GMT</th>
                        <th colspan="6" style="text-align:center;background-color: #dedede">TTAST</th>
                        <th colspan="6" style="text-align:center;background-color: #dedede">Total</th>
                        
                        <th rowspan="3" style="text-align:center;background-color: #dedede">หมายเหตุ</th>
                        <th rowspan="3" style="text-align:center;background-color: #dedede">ประเภทรถ</th>
    
                    </tr>
                     
                     <tr>
                        <!-- จำนวนเที่ยว,ค่าเที่ยว  GMT-->
                        <th colspan="3" style="text-align:center;background-color: #dedede">จำนวนเที่ยว</th>
                        <th colspan="3" style="text-align:center;background-color: #dedede">ค่าเที่ยว</th>
    
                        <!-- จำนวนเที่ยว,ค่าเที่ยว  TTAST-->
                        <th colspan="3" style="text-align:center;background-color: #dedede">จำนวนเที่ยว</th>
                        <th colspan="3" style="text-align:center;background-color: #dedede">ค่าเที่ยว</th>
    
                        <!-- จำนวนเที่ยว,ค่าเที่ยว  Total-->
                        <th colspan="3" style="text-align:center;background-color: #dedede">จำนวนเที่ยว</th>
                        <th colspan="3" style="text-align:center;background-color: #dedede">ค่าเที่ยว</th>
                    </tr>
    
                   
                    <tr>
                        <!-- จำนวนเที่ยว,ค่าเที่ยว GMT -->
                        <th  style="text-align:center;background-color: #dedede">Extra</th>
                        <th  style="text-align:center;background-color: #dedede">Normal</th>
                        <th  style="text-align:center;background-color: #dedede">Total</th>
                        <th  style="text-align:center;background-color: #dedede">Extra</th>
                        <th  style="text-align:center;background-color: #dedede">Normal</th>
                        <th  style="text-align:center;background-color: #dedede">Total</th>
                        
                         <!-- จำนวนเที่ยว,ค่าเที่ยว  TTAST-->
                        <th  style="text-align:center;background-color: #dedede">Extra</th>
                        <th  style="text-align:center;background-color: #dedede">Normal</th>
                        <th  style="text-align:center;background-color: #dedede">Total</th>
                        <th  style="text-align:center;background-color: #dedede">Extra</th>
                        <th  style="text-align:center;background-color: #dedede">Normal</th>
                        <th  style="text-align:center;background-color: #dedede">Total</th>
                        
                        <!-- จำนวนเที่ยว,ค่าเที่ยว  Total-->
                        <th  style="text-align:center;background-color: #dedede">Extra</th>
                        <th  style="text-align:center;background-color: #dedede">Normal</th>
                        <th  style="text-align:center;background-color: #dedede">Total</th>
                        <th  style="text-align:center;background-color: #dedede">Extra</th>
                        <th  style="text-align:center;background-color: #dedede">Normal</th>
                        <th  style="text-align:center;background-color: #dedede">Total</th>
    
                        
                    </tr>
    
                </thead>
                <tbody>
                        <?php
                                $i = 1;
                   
    
                            $sql_sePerson = "SELECT PersonCode, SUBSTRING(PersonCode, 4, 6) AS 'R_PERSONCODE',nameT,PositionNameT
                            FROM EMPLOYEEEHR2 
                            -- WHERE  (PositionNameT ='พนักงานขับรถ/TTAST/เกตเวย์' OR PersonCode IN ('100007','100009'))
                            WHERE  PositionNameT IN ('เจ้าหน้าที่ คปป./GMT') 
                            ORDER BY PersonCode ASC";
                            $params_sePerson = array();
                            $query_sePerson = sqlsrv_query($conn, $sql_sePerson, $params_sePerson);
                            while ($result_sePerson = sqlsrv_fetch_array($query_sePerson, SQLSRV_FETCH_ASSOC)) {
    
                                //ข้อมูลสายงาน GMT
                                //ตรวจสอบข้อมูล รอบวิ่งงาน EX และ ค่าเที่ยว EX สายงาน GMT
                                $sql_sePlanEXGMT = "{call megCompensationReportRRC_v2(?,?,?,?)}";
                                $params_sePlanEXGMT = array(
                                    array('select_compensationex_gmt', SQLSRV_PARAM_IN),
                                    array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                                    array($_GET['datestart'], SQLSRV_PARAM_IN),
                                    array($_GET['dateend'], SQLSRV_PARAM_IN),
                                );
                                $query_sePlanEXGMT = sqlsrv_query($conn, $sql_sePlanEXGMT, $params_sePlanEXGMT);
                                $result_sePlanEXGMT = sqlsrv_fetch_array($query_sePlanEXGMT, SQLSRV_FETCH_ASSOC);
                        
                                //echo $result_sePlanEXGMT['COUNTEX_GMT'];
    
                                //ตรวจสอบข้อมูล รอบวิ่งงาน NM และ ค่าเที่ยว NM สายงาน GMT
                                $sql_sePlanNMGMT = "{call megCompensationReportRRC_v2(?,?,?,?)}";
                                $params_sePlanNMGMT = array(
                                    array('select_compensationnm_gmt', SQLSRV_PARAM_IN),
                                    array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                                    array($_GET['datestart'], SQLSRV_PARAM_IN),
                                    array($_GET['dateend'], SQLSRV_PARAM_IN),
                                );
                                $query_sePlanNMGMT = sqlsrv_query($conn, $sql_sePlanNMGMT, $params_sePlanNMGMT);
                                $result_sePlanNMGMT = sqlsrv_fetch_array($query_sePlanNMGMT, SQLSRV_FETCH_ASSOC);
                                
                                //echo $result_sePlanNMGMT['SUMCOMPENSATIONNM_GMT'];
    
                                //ข้อมูลสายงาน TTAST
                                //ตรวจสอบข้อมูล รอบวิ่งงาน EX และ ค่าเที่ยว EX สายงาน TTAST
                                $sql_sePlanEXTTAST = "{call megCompensationReportRRC_v2(?,?,?,?)}";
                                $params_sePlanEXTTAST  = array(
                                    array('select_compensationex_ttast', SQLSRV_PARAM_IN),
                                    array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                                    array($_GET['datestart'], SQLSRV_PARAM_IN),
                                    array($_GET['dateend'], SQLSRV_PARAM_IN),
                                );
                                $query_sePlanEXTTAST  = sqlsrv_query($conn, $sql_sePlanEXTTAST , $params_sePlanEXTTAST);
                                $result_sePlanEXTTAST  = sqlsrv_fetch_array($query_sePlanEXTTAST , SQLSRV_FETCH_ASSOC);
                        
                                //echo $result_sePlanEXTTAST ['COUNTEX_GMT'];
    
                                //ตรวจสอบข้อมูล รอบวิ่งงาน NM และ ค่าเที่ยว NM สายงาน TTAST
                                $sql_sePlanNMTTAST = "{call megCompensationReportRRC_v2(?,?,?,?)}";
                                $params_sePlanNMTTAST = array(
                                    array('select_compensationnm_ttast', SQLSRV_PARAM_IN),
                                    array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                                    array($_GET['datestart'], SQLSRV_PARAM_IN),
                                    array($_GET['dateend'], SQLSRV_PARAM_IN),
                                );
                                $query_sePlanNMTTAST = sqlsrv_query($conn, $sql_sePlanNMTTAST, $params_sePlanNMTTAST);
                                $result_sePlanNMTTAST = sqlsrv_fetch_array($query_sePlanNMTTAST, SQLSRV_FETCH_ASSOC);
                                
                                // echo $result_sePlanNMTTAST['COUNTNM_TTAST'];
    
    
                                // GMT
                                $GMT_TRIP_TOTAL   = ($result_sePlanEXGMT['COUNTEX_GMT']+$result_sePlanNMGMT['COUNTNM_GMT']);
                                $GMT_COMPEN_TOTAL = ($result_sePlanEXGMT['SUMCOMPENSATIONEX_GMT']+$result_sePlanNMGMT['SUMCOMPENSATIONNM_GMT']);
                                // TTAST
                                $TTAST_TRIP_TOTAL   = ($result_sePlanEXTTAST['COUNTEX_TTAST']+$result_sePlanNMTTAST['COUNTNM_TTAST']);
                                $TTAST_COMPEN_TOTAL = ($result_sePlanEXTTAST['SUMCOMPENSATIONEX_TTAST']+$result_sePlanNMTTAST['SUMCOMPENSATIONNM_TTAST']);
                                // TOTAL TRIP
                                $TOTAL_TRIP_EX  = ($result_sePlanEXGMT['COUNTEX_GMT']+$result_sePlanEXTTAST['COUNTEX_TTAST']);
                                $TOTAL_TRIP_NM  = ($result_sePlanNMGMT['COUNTNM_GMT']+$result_sePlanNMTTAST['COUNTNM_TTAST']);
                                $TOTAL_ALL_TRIP = $TOTAL_TRIP_EX+$TOTAL_TRIP_NM;
                                // TOTAL COMPENSATION
                                $TOTAL_COMPEN_EX  = ($result_sePlanEXGMT['SUMCOMPENSATIONEX_GMT']+$result_sePlanEXTTAST['SUMCOMPENSATIONEX_TTAST']);
                                $TOTAL_COMPEN_NM  = ($result_sePlanNMGMT['SUMCOMPENSATIONNM_GMT']+$result_sePlanNMTTAST['SUMCOMPENSATIONNM_TTAST']);
                                $TOTAL_ALL_COMPEN = $TOTAL_COMPEN_EX+$TOTAL_COMPEN_NM;
                                ?>
                                
                                <tr>
                                    
                                    <!-- <td style="text-align: left"><?=$result_seRepairplan['REPAIRPLANID']?></td> -->
                                    <td style="text-align: left"><?= $i?></td>
                                    <td style="text-align: center">RR <?=$result_sePerson['R_PERSONCODE']?></td>
                                    <td style="text-align: left">นาย &nbsp;<?=$result_sePerson['nameT']?></td>
                                    <!-- จำนวนเที่ยว,ค่าเที่ยว GMT -->
                                    <td style="text-align: center;color:red;"><?= $result_sePlanEXGMT['COUNTEX_GMT']  == '' ? '-' : $result_sePlanEXGMT['COUNTEX_GMT'] ?></td>
                                    <td style="text-align: center;color:blue;"><?= $result_sePlanNMGMT['COUNTNM_GMT'] == '' ? '-' : $result_sePlanNMGMT['COUNTNM_GMT'] ?></td>
                                    <td style="text-align: center;color:green;"><?= $GMT_TRIP_TOTAL == '0' ? '-' : $GMT_TRIP_TOTAL ?></td>
                                    <td style="text-align: center;color:red;"><?=  $result_sePlanEXGMT['SUMCOMPENSATIONEX_GMT']  == '' ? '-'  : number_format($result_sePlanEXGMT['SUMCOMPENSATIONEX_GMT']) ?></td>
                                    <td style="text-align: center;color:blue;"><?= $result_sePlanNMGMT['SUMCOMPENSATIONNM_GMT']  == '' ? '-'  : number_format($result_sePlanNMGMT['SUMCOMPENSATIONNM_GMT']) ?></td>
                                    <td style="text-align: center;color:green;"><?= $GMT_COMPEN_TOTAL == '0' ? '-' : number_format($GMT_COMPEN_TOTAL)?></td>
                                    
                                    <!-- จำนวนเที่ยว,ค่าเที่ยว TTAST -->
                                    <td style="text-align: center;color:red;"><?= $result_sePlanEXTTAST['COUNTEX_TTAST']  == '' ? '-' : $result_sePlanEXTTAST['COUNTEX_TTAST'] ?></td>
                                    <td style="text-align: center;color:blue;"><?= $result_sePlanNMTTAST['COUNTNM_TTAST']  == '' ? '-' : $result_sePlanNMTTAST['COUNTNM_TTAST'] ?></td>
                                    <td style="text-align: center;color:green;"><?= $TTAST_TRIP_TOTAL == '0' ? '-' : $TTAST_TRIP_TOTAL ?></td>
                                    <td style="text-align: center;color:red;"><?= $result_sePlanEXTTAST['SUMCOMPENSATIONEX_TTAST']   == '' ? '-'  : number_format($result_sePlanEXTTAST['SUMCOMPENSATIONEX_TTAST']) ?></td>
                                    <td style="text-align: center;color:blue;"><?= $result_sePlanNMTTAST['SUMCOMPENSATIONNM_TTAST']  == '' ? '-'  : number_format($result_sePlanNMTTAST['SUMCOMPENSATIONNM_TTAST']) ?></td>
                                    <td style="text-align: center;color:green;"><?= $TTAST_COMPEN_TOTAL == '0' ? '-' : number_format($TTAST_COMPEN_TOTAL)?></td>
    
                                    <!-- จำนวนเที่ยว,ค่าเที่ยว Total -->
                                    <td style="text-align: center;color:red;"><?=$TOTAL_TRIP_EX     == '0' ? '-' : $TOTAL_TRIP_EX?></td>
                                    <td style="text-align: center;color:blue;"><?=$TOTAL_TRIP_NM    == '0' ? '-' : $TOTAL_TRIP_NM?></td>
                                    <td style="text-align: center;color:green;"><?=$TOTAL_ALL_TRIP  == '0' ? '-' : $TOTAL_ALL_TRIP?></td>
                                    <td style="text-align: center;color:red;"><?=$TOTAL_COMPEN_EX   == '0' ? '-' : number_format($TOTAL_COMPEN_EX)?></td>
                                    <td style="text-align: center;color:blue;"><?=$TOTAL_COMPEN_NM  == '0' ? '-' : number_format($TOTAL_COMPEN_NM)?></td>
                                    <td style="text-align: center"><?=$TOTAL_ALL_COMPEN  == '0' ? '-' : number_format($TOTAL_ALL_COMPEN)?></td>
    
                                    <!-- หมายเหตุ,ประเถทรถ -->
                                    <td style="text-align: center"></td>
                                    <td style="text-align: center"></td>
                                </tr>
    
                                <?php
                                //GMT จำนวนเที่ยว
                                $SUMEX_TRIP_GMT  = $SUMEX_TRIP_GMT + $result_sePlanEXGMT['COUNTEX_GMT'];
                                $SUMNM_TRIP_GMT  = $SUMNM_TRIP_GMT + $result_sePlanNMGMT['COUNTNM_GMT'];
                                $TOTAL_TRIP_GMT  = $TOTAL_TRIP_GMT + $GMT_TRIP_TOTAL;
                                //GMT ค่าเที่ยว
                                $SUMEX_COMPEN_GMT  = $SUMEX_COMPEN_GMT + $result_sePlanEXGMT['SUMCOMPENSATIONEX_GMT'];
                                $SUMNM_COMPEN_GMT  = $SUMNM_COMPEN_GMT + $result_sePlanNMGMT['SUMCOMPENSATIONNM_GMT'];
                                $TOTAL_COMPEN_GMT  = $TOTAL_COMPEN_GMT + $GMT_COMPEN_TOTAL;
                                //TTAST จำนวนเที่ยว
                                $SUMEX_TRIP_TTAST  = $SUMEX_TRIP_TTAST + $result_sePlanEXTTAST['COUNTEX_TTAST'];
                                $SUMNM_TRIP_TTAST  = $SUMNM_TRIP_TTAST + $result_sePlanNMTTAST['COUNTNM_TTAST'];
                                $TOTAL_TRIP_TTAST  = $TOTAL_TRIP_TTAST + $TTAST_TRIP_TOTAL;
                                //TTAST ค่าเที่ยว
                                $SUMEX_COMPEN_TTAST  = $SUMEX_COMPEN_TTAST + $result_sePlanEXTTAST['SUMCOMPENSATIONEX_TTAST'];
                                $SUMNM_COMPEN_TTAST  = $SUMNM_COMPEN_TTAST + $result_sePlanNMTTAST['SUMCOMPENSATIONNM_TTAST'];
                                $TOTAL_COMPEN_TTAST  = $TOTAL_COMPEN_TTAST + $TTAST_COMPEN_TOTAL;
    
                                //TOTAL
                                $SUMTOTAL_EX_TRIP     = $SUMTOTAL_EX_TRIP     + $TOTAL_TRIP_EX;
                                $SUMTOTAL_NM_TRIP     = $SUMTOTAL_NM_TRIP     + $TOTAL_TRIP_NM;
                                $SUMTOTAL_TRIP_TOTAL  = $SUMTOTAL_TRIP_TOTAL  + $TOTAL_ALL_TRIP;
    
                                $SUMTOTAL_EX_COMPEN     = $SUMTOTAL_EX_COMPEN     + $TOTAL_COMPEN_EX;
                                $SUMTOTAL_NM_COMPEN     = $SUMTOTAL_NM_COMPEN     + $TOTAL_COMPEN_NM;
                                $SUMTOTAL_COMPEN_TOTAL  = $SUMTOTAL_COMPEN_TOTAL  + $TOTAL_ALL_COMPEN;
    
    
    
                                $i++;   
                            }
                            ?>
                    <tr>
                        <td colspan="3" style="text-align: right;background-color: #dedede">รวม</ก>
                        <td style="text-align: center;"><b><?=$SUMEX_TRIP_GMT  == '0' ? '-' : $SUMEX_TRIP_GMT?></b></td>
                        <td style="text-align: center;"><b><?=$SUMNM_TRIP_GMT  == '0' ? '-' : $SUMNM_TRIP_GMT?></b></td>
                        <td style="text-align: center;"><b><?=$TOTAL_TRIP_GMT  == '0' ? '-' : $TOTAL_TRIP_GMT?></b></td>
                        <td style="text-align: center;"><b><?=$SUMEX_COMPEN_GMT  == '0' ? '-' : number_format($SUMEX_COMPEN_GMT)?></b></td>
                        <td style="text-align: center;"><b><?=$SUMNM_COMPEN_GMT  == '0' ? '-' : number_format($SUMNM_COMPEN_GMT)?></b></td>
                        <td style="text-align: center;"><b><?=$TOTAL_COMPEN_GMT  == '0' ? '-' : number_format($TOTAL_COMPEN_GMT)?></b></td>
    
                        <td style="text-align: center;"><b><?=$SUMEX_TRIP_TTAST     == '0' ? '-' : $SUMEX_TRIP_TTAST?></b></td>
                        <td style="text-align: center;"><b><?=$SUMNM_TRIP_TTAST     == '0' ? '-' : $SUMNM_TRIP_TTAST?></b></td>
                        <td style="text-align: center;"><b><?=$TOTAL_TRIP_TTAST     == '0' ? '-' : $TOTAL_TRIP_TTAST?></b></td>
                        <td style="text-align: center;"><b><?=$SUMEX_COMPEN_TTAST   == '0' ? '-' : number_format($SUMEX_COMPEN_TTAST)?></b></td>
                        <td style="text-align: center;"><b><?=$SUMNM_COMPEN_TTAST   == '0' ? '-' : number_format($SUMNM_COMPEN_TTAST)?></b></td>
                        <td style="text-align: center;"><b><?=$TOTAL_COMPEN_TTAST   == '0' ? '-' : number_format($TOTAL_COMPEN_TTAST)?></b></td>
    
                        <td style="text-align: center;"><b><?=$SUMTOTAL_EX_TRIP         == '0' ? '-' : $SUMTOTAL_EX_TRIP?></b></td>
                        <td style="text-align: center;"><b><?=$SUMTOTAL_NM_TRIP         == '0' ? '-' : $SUMTOTAL_NM_TRIP?></b></td>
                        <td style="text-align: center;"><b><?=$SUMTOTAL_TRIP_TOTAL      == '0' ? '-' : $SUMTOTAL_TRIP_TOTAL?></b></td>
                        <td style="text-align: center;"><b><?=$SUMTOTAL_EX_COMPEN       == '0' ? '-' : number_format($SUMTOTAL_EX_COMPEN)?></b></td>
                        <td style="text-align: center;"><b><?=$SUMTOTAL_NM_COMPEN       == '0' ? '-' : number_format($SUMTOTAL_NM_COMPEN)?></b></td>
                        <td style="text-align: center;"><b><?=$SUMTOTAL_COMPEN_TOTAL    == '0' ? '-' : number_format($SUMTOTAL_COMPEN_TOTAL)?></b></td>
    
                        <td style="text-align: center;"><b></b></td>
                        <td style="text-align: center;"><b></b></td>
                    </tr>
                </tbody>
            </table>
            <br><br>
           
            <table style="text-align: center;background-color: #ffffff;border-collapse: collapse;">
                <tfoot>
                    <tr>
                        <td colspan="11" style="text-align: center;"></td>
                        <td colspan="3" style="text-align: center;background-color: #ffffff;border-collapse: collapse;border:1px solid #000">ISSUE BY</td>
                        <td colspan="3" style="text-align: center;background-color: #ffffff;border-collapse: collapse;border:1px solid #000">CHECK BY</td>
                        <td colspan="3" style="text-align: center;background-color: #ffffff;border-collapse: collapse;border:1px solid #000">APPROVE BY</td>
                    </tr>
                    <tr>
                        <td colspan="11" style="text-align: center;"></td>
                        <td colspan="3" style="text-align: center;border:1px solid #000"><br><br><br></td>
                        <td colspan="3" style="text-align: center;border:1px solid #000"><br><br><br></td>
                        <td colspan="3" style="text-align: center;border:1px solid #000"><br><br><br></td>
                    </tr>
                    <tr>
                        <td colspan="11" style="text-align: center;"></td>
                        <td colspan="3" style="text-align: center;border:1px solid #000">(นางสาวพุทธิดา เสาวนา)</td>
                        <td colspan="3" style="text-align: center;border:1px solid #000">(นายวรวิทย์ คุณเจริญ)</td>
                        <td colspan="3" style="text-align: center;border:1px solid #000">(นายบัญชา กงแก้ว)</td>
                    </tr>
                    <tr>
                        <td colspan="11" style="text-align: center;"></td>
                        <td colspan="3" style="text-align: center;border:1px solid #000">เจ้าหน้าที่อาวุโสแผนกปฏิบัติการ<br>ฝ่ายงานขนส่ง</td>
                        <td colspan="3" style="text-align: center;border:1px solid #000">ผช.ผจก.แผนกปฏิบัติการ<br>ฝ่ายงานขนส่ง</td>
                        <td colspan="3" style="text-align: center;border:1px solid #000">ผจก.แผนกปฏิบัติการ<br>ฝ่ายงานขนส่ง</td>
                    </tr> 
                    <tr>
                        <td colspan="11" style="text-align: center;"></td>
                        <td colspan="3" style="text-align: center;border:1px solid #000">ลงวันที่ .......... /.......... /..........</td>
                        <td colspan="3" style="text-align: center;border:1px solid #000">ลงวันที่ .......... /.......... /..........</td>
                        <td colspan="3" style="text-align: center;border:1px solid #000">ลงวันที่ .......... /.......... /..........</td>
                    </tr>  
                </tfoot>
            </table>
            
        </body>
    </html>
<?php
}
?>

