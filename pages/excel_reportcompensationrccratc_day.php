<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");


if ($_GET['companycode'] == 'RCC'       && $_GET['datasearch'] == 'พนักงานขนส่งยานยนต์/RCC 4 LOAD') {
    $filenamechk = 'RCC4L_DAY_';
}else if($_GET['companycode'] == 'RCC'  && $_GET['datasearch'] == 'พนักงานขนส่งยานยนต์/RCC 8 LOAD'){
    $filenamechk = 'RCC8L_DAY_';
}else if($_GET['companycode'] == 'RATC' && $_GET['datasearch'] == 'พนักงานขนส่งยานยนต์/RATC 4 LOAD'){
    $filenamechk = 'RATC4L_DAY_';
}else if($_GET['companycode'] == 'RATC' && $_GET['datasearch'] == 'พนักงานขนส่งยานยนต์/RATC 8 LOAD'){
    $filenamechk = 'RATC8L_DAY_';
}else {
    $filenamechk = 'ตำแหน่งอื่นๆ';
}

if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานค่าเที่ยว(Error).xls";
} else {
    $strExcelFileName = "$filenamechk(".$_GET['datestart']."-".$_GET['dateend'].").xls";
}


header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");
error_reporting(0);



// header('Content-Type: application/vnd.ms-excel');
// header('Cache-Control: max-age=0');


 $monthchk  = substr($_GET['datestart'],3,2);

 $yearstartchk   = substr($_GET['datestart'],6,10);
 $yearsendchk    = substr($_GET['dateend'],6,10);


 $daymonthstart  = substr($_GET['datestart'],0,5);
 $daymonthend    = substr($_GET['dateend'],0,5);

 $timestartchk   = substr($_GET['datestart'],10,18);
 $timeendchk     = substr($_GET['dateend'],10,18);
 
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


$datacheck  = $_GET['datasearch'];
// echo $datacheck;
// echo '<br>';

if ($datacheck == 'พนักงานขนส่งยานยนต์/RCC 4 LOAD') {
    $companyheader = 'บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์ จำกัด';
    $header = '4 LOAD TTT';
    //$datasearch = 'พนักงานขนส่งยานยนต์/RCC 4 LOAD';

}else if ($datacheck == 'พนักงานขนส่งยานยนต์/RCC 8 LOAD') {
    $companyheader = 'บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์ จำกัด';
    $header = '8 LOAD TTT';
    //$datasearch = 'พนักงานขนส่งยานยนต์/RCC 4 LOAD';

}else if ($datacheck == 'พนักงานขนส่งยานยนต์/RATC 4 LOAD') {
    $companyheader = 'บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต จำกัด';
    $header = '4 LOAD TTT';
   //$datasearch = 'พนักงานขนส่งยานยนต์/RCC 4 LOAD';

}else if ($datacheck == 'พนักงานขนส่งยานยนต์/RATC 8 LOAD') {
    $companyheader = 'บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต จำกัด';
    $header = '8 LOAD TTT';
    //$datasearch = 'พนักงานขนส่งยานยนต์/RCC 8 LOAD';

}else{
    if ($_GET['companycode'] == 'RCC') {
        $companyheader = 'บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์ จำกัด';
        $header = 'ตำแหน่งอื่นๆ';
        //$datasearch = 'ERROR';
    }else if ($_GET['companycode'] == 'RATC'){
        $companyheader = 'บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต จำกัด';
        $header = 'ตำแหน่งอื่นๆ';
        //$datasearch = 'ERROR';   
    }else{
        $companyheader = 'บริษัท ร่วมกิจ รีไซเคิล แคริเออร์';
        $header = 'ตำแหน่งอื่นๆ';
        //$datasearch = 'ERROR';   
    }
    
}
?>




<html>
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <table  border="1"  style="width: 100%;">
            <thead>

                <?php
                if ($_GET['datasearch'] == 'OTHER') {
                ?>
                        <tr>
                            <th colspan="14" style="text-align: center;background-color: #dedede"><?=$companyheader?> </th>
                        </tr>
                        <tr>
                            <th colspan="14" style="text-align: center;background-color: #dedede">ค่าเที่ยว <?=$header?> </th>
                        </tr>
                        <tr>
                            <th colspan="14" style="text-align: center;background-color: #dedede">เดือน <b><?=$month?></b> วันที่ <b><?= $daymonthstart."/".($yearstartchk+543)." ".$timestartchk ?> ถึง <?= $daymonthend."/".($yearsendchk+543)." ".$timeendchk ?></b></th>
                        </tr>
                        <tr>   
                            <!-- <th rowspan="2" style="text-align:center;background-color: #dedede">แผน</th> -->
                            <th rowspan="2" style="text-align:center;background-color: #dedede">NO.</th>
                            <th rowspan="2" style="text-align:center;background-color: #dedede">รหัสพนักงาน</th>
                            <th rowspan="2" colspan="2" style="text-align:center;background-color: #dedede">รายชื่อพนักงาน</th>
                            <th rowspan="2" colspan="2" style="text-align:center;background-color: #dedede">ตำแหน่งพนักงาน</th>
                            <th colspan="3" style="text-align:center;background-color: #dedede">จำนวนเที่ยว</th>
                            <th colspan="3" style="text-align:center;background-color: #dedede">ค่าเที่ยว</th>
                            <th rowspan="2" colspan="2" style="text-align:center;background-color: #dedede">หมายเหตุ</th>
                        </tr>
                        <tr>
                            <!-- จำนวนเที่ยว -->
                            <th colspan="3" style="text-align:center;background-color: #dedede">Total</th>
                            <!-- ค่าเที่ยว -->
                            <th colspan="3" style="text-align:center;background-color: #dedede">Total</th>
                        </tr>
                <?php
                }else{
                ?>
                        <tr>
                            <th colspan="12" style="text-align: center;background-color: #dedede"><?=$companyheader?> </th>
                        </tr>
                        <tr>
                            <th colspan="12" style="text-align: center;background-color: #dedede">ค่าเที่ยว <?=$header?> </th>
                        </tr>
                        <tr>
                            <th colspan="12" style="text-align: center;background-color: #dedede">เดือน <b><?=$month?></b> วันที่ <b><?= $daymonthstart."/".($yearstartchk+543)." ".$timestartchk ?> ถึง <?= $daymonthend."/".($yearsendchk+543)." ".$timeendchk ?></b></th>
                        </tr>
                        <tr>   
                            <!-- <th rowspan="2" style="text-align:center;background-color: #dedede">แผน</th> -->
                            <th rowspan="2" style="text-align:center;background-color: #dedede">NO.</th>
                            <th rowspan="2" style="text-align:center;background-color: #dedede">รหัสพนักงาน</th>
                            <th rowspan="2" colspan="2" style="text-align:center;background-color: #dedede">รายชื่อพนักงาน</th>
                            <th colspan="3" style="text-align:center;background-color: #dedede">จำนวนเที่ยว</th>
                            <th colspan="3" style="text-align:center;background-color: #dedede">ค่าเที่ยว</th>
                            <th rowspan="2" colspan="2" style="text-align:center;background-color: #dedede">หมายเหตุ</th>
                        </tr>
                        <tr>
                            <!-- จำนวนเที่ยว -->
                            <th colspan="3" style="text-align:center;background-color: #dedede">Total</th>
                            <!-- ค่าเที่ยว -->
                            <th colspan="3" style="text-align:center;background-color: #dedede">Total</th>
                        </tr>
                <?php
                }
                ?>

                

               
                

            </thead>
            <tbody>
                <?php

                    // รายชื่อ PositionNameT  ที่จะไม่โชว์ในรายงาน
                    // พนักงานขับรถ/ปลอกเขียว
                    // พนักงานขับรถ/ปลอกเขียว/4 Load
                    // พนักงานขับรถ/ปลอกเขียว/8 Load RATC
                    // พนักงานขับรถ/ปลอกเขียว/8 Load RCC
                    // พนักงานขับรถ/ปลอกเหลือง
                    // พนักงานขับรถ/ปลอกเหลือง/4 Load
                    // พนักงานขับรถ/ปลอกเหลือง/8 Load RATC
                    // พนักงานขับรถ/ปลอกเหลือง/8 Load RCC

                    $i = 1;
    
                    if ($_GET['companycode'] == 'RCC'  &&  $_GET['datasearch'] == 'พนักงานขนส่งยานยนต์/RCC 8 LOAD') {

                        $sql_sePerson = "SELECT PersonCode, SUBSTRING(PersonCode, 4, 6) AS 'R_PERSONCODE',nameT,PositionNameT
                            FROM EMPLOYEEEHR2 
                            WHERE (Company_Code ='RCC')
                            AND PositionNameT IN('พนักงานขนส่งยานยนต์/RCC 8 LOAD')
                            --WHERE  PositionNameT ='พนักงานขนส่งยานยนต์/RCC 4 LOAD'
                            --AND PersonCode NOT IN ('040904','040902','040896','040874','040885','040886')
                            ORDER BY PersonCode ASC";
                        $params_sePerson = array();
                        $query_sePerson = sqlsrv_query($conn, $sql_sePerson, $params_sePerson);

                    }else if ($_GET['companycode'] == 'RATC'  &&  $_GET['datasearch'] == 'พนักงานขนส่งยานยนต์/RATC 8 LOAD'){

                        $sql_sePerson = "SELECT PersonCode, SUBSTRING(PersonCode, 4, 6) AS 'R_PERSONCODE',nameT,PositionNameT
                            FROM EMPLOYEEEHR2 
                            WHERE (Company_Code ='RATC')
                            AND PositionNameT IN('พนักงานขนส่งยานยนต์/RATC 8 LOAD')
                            --WHERE  PositionNameT ='พนักงานขนส่งยานยนต์/RCC 4 LOAD'
                            --AND PersonCode NOT IN ('090325','090334','090341','090342','090353','090356','090364',
                            --'090365','090366','090367','090368','090369','090370','090371')
                            ORDER BY PersonCode ASC";
                        $params_sePerson = array();
                        $query_sePerson = sqlsrv_query($conn, $sql_sePerson, $params_sePerson);

                    }else if ($_GET['companycode'] == 'RCC'  &&  $_GET['datasearch'] ==  'พนักงานขนส่งยานยนต์/RCC 4 LOAD'){

                        $sql_sePerson = "SELECT PersonCode, SUBSTRING(PersonCode, 4, 6) AS 'R_PERSONCODE',nameT,PositionNameT
                            FROM EMPLOYEEEHR2 
                            WHERE (Company_Code ='RCC')
                            AND PositionNameT IN('พนักงานขนส่งยานยนต์/RCC 4 LOAD')
                            --WHERE  PositionNameT ='พนักงานขนส่งยานยนต์/RCC 4 LOAD'
                            --AND PersonCode NOT IN ('040904','040902','040896','040874','040885','040886')
                            ORDER BY PersonCode ASC";
                        $params_sePerson = array();
                        $query_sePerson = sqlsrv_query($conn, $sql_sePerson, $params_sePerson);

                        // query ทดสอบ
                        // $sql_sePerson = "SELECT PersonCode, SUBSTRING(PersonCode, 4, 6) AS 'R_PERSONCODE',nameT,PositionNameT
                        // FROM EMPLOYEEEHR2 
                        // WHERE (Company_Code ='RCC' OR Company_Code ='RIT' )
                        // AND PositionNameT IN('พนักงานขนส่งยานยนต์/RCC 4 LOAD','เจ้าหน้าที่')
                        // --WHERE  PositionNameT ='พนักงานขนส่งยานยนต์/RCC 4 LOAD'
                        // AND PersonCode NOT IN ('040904','040902','040896','040874','040885','040886')
                        // --AND PersonCode IN('100007','100009')
                        // ORDER BY PersonCode ASC";
                        // $params_sePerson = array();
                        // $query_sePerson = sqlsrv_query($conn, $sql_sePerson, $params_sePerson);

                    }else if ($_GET['companycode'] == 'RATC'  &&  $_GET['datasearch'] == 'พนักงานขนส่งยานยนต์/RATC 4 LOAD'){

                        $sql_sePerson = "SELECT PersonCode, SUBSTRING(PersonCode, 4, 6) AS 'R_PERSONCODE',nameT,PositionNameT
                            FROM EMPLOYEEEHR2 
                            WHERE (Company_Code ='RATC')
                            AND PositionNameT IN('พนักงานขนส่งยานยนต์/RATC 4 LOAD')
                            --WHERE  PositionNameT ='พนักงานขนส่งยานยนต์/RCC 4 LOAD'
                            --AND PersonCode NOT IN ('090325','090334','090341','090342','090353','090356','090364',
                            --'090365','090366','090367','090368','090369','090370','090371')
                            ORDER BY PersonCode ASC";
                        $params_sePerson = array();
                        $query_sePerson = sqlsrv_query($conn, $sql_sePerson, $params_sePerson);

                    }else{

                        $sql_sePerson = "SELECT PersonCode, SUBSTRING(PersonCode, 4, 6) AS 'R_PERSONCODE',nameT,PositionNameT
                            FROM EMPLOYEEEHR2 
                            WHERE (Company_Code = '".$_GET['companycode']."')
                            AND (PositionNameT LIKE('%Controller%') OR  PositionNameT LIKE('%เจ้าหน้าที่ คปป.%') OR  PositionNameT LIKE('%เจ้าหน้าที่ฝึกอบรม%'))
                            --WHERE  PositionNameT ='พนักงานขนส่งยานยนต์/RCC 4 LOAD'
                            --AND PersonCode NOT IN ('040904','040902','040896','040874','040885','040886')
                            ORDER BY PersonCode,PositionNameT ASC";
                        $params_sePerson = array();
                        $query_sePerson = sqlsrv_query($conn, $sql_sePerson, $params_sePerson);

                    }
                        

                    while ($result_sePerson = sqlsrv_fetch_array($query_sePerson, SQLSRV_FETCH_ASSOC)) {

                            // //  นับจำนวนรอบ Extra และ ค่าเที่ยว Extra
                            // //  เงื่อนไข นับทุกเที่ยว ที่มีการเลือกOT1.5
                            // $sql_sePlanEX = "{call megCompensationReport_RCC_RATC_v2(?,?,?,?,?)}";
                            // $params_sePlanEX = array(
                            //     array('select_countandcompensationextra', SQLSRV_PARAM_IN),
                            //     array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                            //     array($_GET['companycode'], SQLSRV_PARAM_IN),
                            //     array($_GET['datestart'], SQLSRV_PARAM_IN),
                            //     array($_GET['dateend'], SQLSRV_PARAM_IN),
                            // );
                            // $query_sePlanEX = sqlsrv_query($conn, $sql_sePlanEX, $params_sePlanEX);
                            // $result_sePlanEX = sqlsrv_fetch_array($query_sePlanEX, SQLSRV_FETCH_ASSOC);
                            // // echo $result_sePlanEX['COUNTEXTRA'];
                            // // echo "<br>";
                            // // echo $result_sePlanEX['COMPENSATIONEXTRA'];


                            // // นับจำนวนเที่ยว Normal
                            // // เงื่อนไข นับทุกเที่ยว แต่ไม่รวมOT1.5 และ ไม่รวมงานรับกลับ
                            // $sql_sePlanTripNM = "{call megCompensationReport_RCC_RATC_v2(?,?,?,?,?)}";
                            // $params_sePlanTripNM = array(
                            //     array('select_trip_normal', SQLSRV_PARAM_IN),
                            //     array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                            //     array($_GET['companycode'], SQLSRV_PARAM_IN),
                            //     array($_GET['datestart'], SQLSRV_PARAM_IN),
                            //     array($_GET['dateend'], SQLSRV_PARAM_IN),
                            // );
                            // $query_sePlanTripNM = sqlsrv_query($conn, $sql_sePlanTripNM, $params_sePlanTripNM);
                            // $result_sePlanTripNM = sqlsrv_fetch_array($query_sePlanTripNM, SQLSRV_FETCH_ASSOC);
                            // // echo $result_sePlanTripNM['COUNTNORMAL'];
                            // // echo "<br>";

                            if ($_GET['datasearch'] == 'OTHER') {
                                // เฉพาะ คปป ,controller จะนับทุกบริษัทที่ไปวิ่งงาน
                                // นับค่าเที่ยว Normal
                                // เงื่อนไข นับทุกเที่ยว แต่ไม่รวมOT1.5 และ ไม่รวมงานรับกลับ
                                // Companycode ไม่ได้ส่งข้อมูล
                                $sql_sePlanCompenNM = "{call megCompensationReport_RCC_RATC_v2(?,?,?,?,?)}";
                                $params_sePlanCompenNM = array(
                                    array('select_compensation_normal_other', SQLSRV_PARAM_IN),
                                    array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                                    array($_GET['companycode'], SQLSRV_PARAM_IN),
                                    array($_GET['datestart'], SQLSRV_PARAM_IN),
                                    array($_GET['dateend'], SQLSRV_PARAM_IN),
                                );
                                $query_sePlanCompenNM = sqlsrv_query($conn, $sql_sePlanCompenNM, $params_sePlanCompenNM);
                                $result_sePlanCompenNM = sqlsrv_fetch_array($query_sePlanCompenNM, SQLSRV_FETCH_ASSOC);
                            }else{
                                // นับค่าเที่ยว Normal
                                // เงื่อนไข นับทุกเที่ยว แต่ไม่รวมOT1.5 และ ไม่รวมงานรับกลับ
                                // Companycode ไม่ได้ส่งข้อมูล
                                $sql_sePlanCompenNM = "{call megCompensationReport_RCC_RATC_v2(?,?,?,?,?)}";
                                $params_sePlanCompenNM = array(
                                    array('select_compensation_normal', SQLSRV_PARAM_IN),
                                    array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                                    array($_GET['companycode'], SQLSRV_PARAM_IN),
                                    array($_GET['datestart'], SQLSRV_PARAM_IN),
                                    array($_GET['dateend'], SQLSRV_PARAM_IN),
                                );
                                $query_sePlanCompenNM = sqlsrv_query($conn, $sql_sePlanCompenNM, $params_sePlanCompenNM);
                                $result_sePlanCompenNM = sqlsrv_fetch_array($query_sePlanCompenNM, SQLSRV_FETCH_ASSOC);
                            }

                            // echo $result_sePlanCompenNM['COUNTNORMAL'];
                            // echo "<br>";  

                            // echo $result_sePlanCompenNM['COMPENSATIONNORMAL'];
                            // echo "<br>";    
                            

                            //TOTAL TRIP
                            $TOTAL_TRIP   = ($result_sePlanCompenNM['COUNTNORMAL']);
                            //TOTAL COMPENSATION
                            $TOTAL_COMPENSATION   = ($result_sePlanCompenNM['COMPENSATIONNORMAL']);
                            
                           
                            ?>
                            
                            <tr>
                                <td style="text-align: left"><?= $i?></td>
                                <td style="text-align: center">&nbsp;<?=$result_sePerson['PersonCode']?></td>
                                <td colspan="2" style="text-align: left">นาย &nbsp;<?=$result_sePerson['nameT']?></td>
                                <?php
                                if ($_GET['datasearch'] == 'OTHER') {
                                ?>
                                <td colspan="2" style="text-align: left"><?=$result_sePerson['PositionNameT']?></td>
                                <?php
                                }else{
                                ?>

                                <?php
                                }
                                ?>
                                <!-- จำนวนเที่ยว -->
                                <td colspan="3" style="text-align: center;color:green;"><?= $TOTAL_TRIP == '' ? '-' : $TOTAL_TRIP ?></td>
                                
                                <!-- ค่าเที่ยว -->
                                <td colspan="3" style="text-align: center;color:green;"><?= $TOTAL_COMPENSATION == '' ? '-' : number_format($TOTAL_COMPENSATION) ?></td>
                                
                                <!-- หมายเหตุ -->
                                <td colspan="2" style="text-align: center"></td>
                            </tr>

                        <?php
                          //SUM TRIP
                          $SUMTRIP_TOTAL    = $SUMTRIP_TOTAL    + $TOTAL_TRIP;
                          
                          //SUM COMPENSATION
                          $SUMCOM_TOTAL    = $SUMCOM_TOTAL    + $TOTAL_COMPENSATION;



                        $i++;   
                    }
                    ?>
                <tr>
                    
                    <?php
                    if ($_GET['datasearch'] == 'OTHER') {
                    ?>
                        <td colspan="6" style="text-align: right;background-color: #dedede">รวม</td>
                        <td colspan="3" style="text-align: center;"><b><?=$SUMTRIP_TOTAL    == '0' ? '-' : $SUMTRIP_TOTAL?></b></td>
                        <td colspan="3" style="text-align: center;"><b><?=$SUMCOM_TOTAL     == '0' ? '-' : number_format($SUMCOM_TOTAL)?></b></td>
                        <td colspan="2" style="text-align: right;"></td>
                    <?php
                    }else{
                    ?>
                        <td colspan="4" style="text-align: right;background-color: #dedede">รวม</td>
                        <td colspan="3" style="text-align: center;"><b><?=$SUMTRIP_TOTAL    == '0' ? '-' : $SUMTRIP_TOTAL?></b></td>
                        <td colspan="3" style="text-align: center;"><b><?=$SUMCOM_TOTAL     == '0' ? '-' : number_format($SUMCOM_TOTAL)?></b></td>
                        <td colspan="2" style="text-align: right;"></td>
                    <?php
                    }
                    ?>
                    
                    
                </tr>
            </tbody>
        </table>
        <br><br>
        
        <table style="text-align: center;background-color: #ffffff;border-collapse: collapse;">
            
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: center;"></td>
                    <td colspan="3" style="text-align: center;background-color: #ffffff;border-collapse: collapse;border:1px solid #000">ISSUE BY</td>
                    <td colspan="3" style="text-align: center;background-color: #ffffff;border-collapse: collapse;border:1px solid #000">CHECK BY</td>
                    <td colspan="3" style="text-align: center;background-color: #ffffff;border-collapse: collapse;border:1px solid #000">APPROVE BY</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center;"></td>
                    <td colspan="3" style="text-align: center;border:1px solid #000"><br><br><br></td>
                    <td colspan="3" style="text-align: center;border:1px solid #000"><br><br><br></td>
                    <td colspan="3" style="text-align: center;border:1px solid #000"><br><br><br></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center;"></td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">(นางสาวรติกร เวศสุวรรณ)</td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">(นายวรวิทย์ คุณเจริญ)</td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">(นายบัญชา กงแก้ว)</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center;"></td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">เจ้าหน้าที่<br>ฝ่ายงานขนส่ง</td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">ผช.ผจก.แผนกปฏิบัติการ<br>ฝ่ายงานขนส่ง</td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">ผจก.แผนกปฏิบัติการ<br>ฝ่ายงานขนส่ง</td>
                </tr> 
                <tr>
                    <td colspan="3" style="text-align: center;"></td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">ลงวันที่ .......... /.......... /..........</td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">ลงวันที่ .......... /.......... /..........</td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">ลงวันที่ .......... /.......... /..........</td>
                </tr>  
            </tfoot>
        </table>
        
    </body>
</html>


