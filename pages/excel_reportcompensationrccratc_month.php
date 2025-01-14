<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
ini_set('max_execution_time', '300'); //300 seconds = 5 minutes


if ($_GET['companycode'] == 'RCC'       && $_GET['datasearch'] == 'พนักงานขนส่งยานยนต์/RCC 4 LOAD') {
    $filenamechk = 'RCC4L_MONTH_';
}else if($_GET['companycode'] == 'RCC'  && $_GET['datasearch'] == 'พนักงานขนส่งยานยนต์/RCC 8 LOAD'){
    $filenamechk = 'RCC8L_MONTH_';
}else if($_GET['companycode'] == 'RATC' && $_GET['datasearch'] == 'พนักงานขนส่งยานยนต์/RATC 4 LOAD'){
    $filenamechk = 'RATC4L_MONTH_';
}else if($_GET['companycode'] == 'RATC' && $_GET['datasearch'] == 'พนักงานขนส่งยานยนต์/RATC 8 LOAD'){
    $filenamechk = 'RATC8L_MONTH_';
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
// error_reporting(0);
// header('Cache-Control: max-age=0');


 $monthchk = substr($_GET['datestart'],3,2);

 $yearstartchk   = substr($_GET['datestart'],6,10);
 $yearsendchk    = substr($_GET['dateend'],6,10);

 $daymonthend    = substr($_GET['dateend'],0,5);
 $daymonthendshow    = substr($_GET['dateend'],0,10);

 $monthyearchk  = substr($_GET['datestart'],2,14);
 $monthyearstartchk  = substr($_GET['datestart'],2,14);
 $monthyearendchk    = substr($_GET['dateend'],2,14);
 $monthyearshow = substr($_GET['datestart'],2,8);
 
 $timestartchk   = substr($_GET['datestart'],10,18);
 $timeendchk     = substr($_GET['dateend'],10,18);

// echo  $monthyearstartchk;
// echo  "<br>";
// echo  $monthyearendchk;
// echo  "<br>";
// echo  $_GET['dateend'];

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
if ($_GET['companycode'] == 'RCC'       && $_GET['datasearch'] == 'พนักงานขนส่งยานยนต์/RCC 4 LOAD') {
    $header = '4 LOAD TTT';
}else if($_GET['companycode'] == 'RCC'  && $_GET['datasearch'] == 'พนักงานขนส่งยานยนต์/RCC 8 LOAD'){
    $header = '8 LOAD TTT';
}else if($_GET['companycode'] == 'RATC' && $_GET['datasearch'] == 'พนักงานขนส่งยานยนต์/RATC 4 LOAD'){
    $header = '4 LOAD TTT';
}else if($_GET['companycode'] == 'RATC' && $_GET['datasearch'] == 'พนักงานขนส่งยานยนต์/RATC 8 LOAD'){
    $header = '8 LOAD TTT';
}else {
    $header = 'ตำแหน่งอื่นๆ';
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
                        <th colspan="21" style="text-align: center;background-color: #dedede"><?=($_GET['companycode']  == 'RCC' ? 'บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์ จำกัด' : 'บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต จำกัด')?> </th>
                    </tr>
                    <tr>
                        <th colspan="21" style="text-align: center;background-color: #dedede">ค่าเที่ยว <?=$header?> </th>
                    </tr>
                    <tr>
                        <th colspan="21" style="text-align: center;background-color: #dedede">เดือน <b><?=$month?></b> วันที่ <b>01<?="/".$monthchk."/".($yearstartchk+543)." ".$timestartchk?> ถึง <?= $daymonthend."/".($yearsendchk+543)." ".$timeendchk ?></b></b></th>
                    </tr>
                    <tr>   
                        <!-- <th rowspan="2" style="text-align:center;background-color: #dedede">แผน</th> -->
                        <th rowspan="2" style="text-align:center;background-color: #dedede">NO.</th>
                        <th rowspan="2" style="text-align:center;background-color: #dedede">รหัสพนักงาน</th>
                        <th rowspan="2" style="text-align:center;background-color: #dedede">รายชื่อพนักงาน</th>
                        <th rowspan="2" style="text-align:center;background-color: #dedede">ตำแหน่งพนักงาน</th>
                        <th colspan="4" style="text-align:center;background-color: #dedede">1-10<?=$monthyearshow?></th>
                        <th colspan="4" style="text-align:center;background-color: #dedede">11-20<?=$monthyearshow?></th>
                        <th colspan="4" style="text-align:center;background-color: #dedede">21-<?=$daymonthendshow?></th>
                        <th colspan="4" style="text-align:center;background-color: #dedede">รวม</th>
                        <th rowspan="2" style="text-align:center;background-color: #dedede">หมายเหตุ</th>
                    </tr>
                    <tr>
                        <!-- ช่วงวันที่ 1-10 -->
                        <th colspan="2" style="text-align:center;background-color: #dedede">จำนวนเที่ยว</th>
                        <th colspan="2" style="text-align:center;background-color: #dedede">ค่าเที่ยว</th>

                        <!-- ช่วงวันที่ 11-20 -->
                        <th colspan="2" style="text-align:center;background-color: #dedede">จำนวนเที่ยว</th>
                        <th colspan="2" style="text-align:center;background-color: #dedede">ค่าเที่ยว</th>

                        <!-- ช่วงวันที่ 21-31 (วันที่สุดท้ายที่เลือกข้อมูล)--> 
                        <th colspan="2" style="text-align:center;background-color: #dedede">จำนวนเที่ยว</th>
                        <th colspan="2" style="text-align:center;background-color: #dedede">ค่าเที่ยว</th>

                        <!-- รวม-->
                        <th colspan="2" style="text-align:center;background-color: #dedede">จำนวนเที่ยว</th>
                        <th colspan="2" style="text-align:center;background-color: #dedede">ค่าเที่ยว</th>
                    </tr>

                <?php
                }else{
                ?>
                    <tr>
                        <th colspan="20" style="text-align: center;background-color: #dedede"><?=($_GET['companycode']  == 'RCC' ? 'บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์ จำกัด' : 'บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต จำกัด')?> </th>
                    </tr>
                    <tr>
                        <th colspan="20" style="text-align: center;background-color: #dedede">ค่าเที่ยว <?=$header?> </th>
                    </tr>
                    <tr>
                        <th colspan="20" style="text-align: center;background-color: #dedede">เดือน <b><?=$month?></b> วันที่ <b>01<?="/".$monthchk."/".($yearstartchk+543)." ".$timestartchk?> ถึง <?= $daymonthend."/".($yearsendchk+543)." ".$timeendchk ?></b></b></th>
                    </tr>
                    <tr>   
                        <!-- <th rowspan="2" style="text-align:center;background-color: #dedede">แผน</th> -->
                        <th rowspan="2" style="text-align:center;background-color: #dedede">NO.</th>
                        <th rowspan="2" style="text-align:center;background-color: #dedede">รหัสพนักงาน</th>
                        <th rowspan="2" style="text-align:center;background-color: #dedede">รายชื่อพนักงาน</th>
                        <th colspan="4" style="text-align:center;background-color: #dedede">1-10<?=$monthyearshow?></th>
                        <th colspan="4" style="text-align:center;background-color: #dedede">11-20<?=$monthyearshow?></th>
                        <th colspan="4" style="text-align:center;background-color: #dedede">21-<?=$daymonthendshow?></th>
                        <th colspan="4" style="text-align:center;background-color: #dedede">รวม</th>
                        <th rowspan="2" style="text-align:center;background-color: #dedede">หมายเหตุ</th>
                    </tr>
                    <tr>
                        <!-- ช่วงวันที่ 1-10 -->
                        <th colspan="2" style="text-align:center;background-color: #dedede">จำนวนเที่ยว</th>
                        <th colspan="2" style="text-align:center;background-color: #dedede">ค่าเที่ยว</th>

                        <!-- ช่วงวันที่ 11-20 -->
                        <th colspan="2" style="text-align:center;background-color: #dedede">จำนวนเที่ยว</th>
                        <th colspan="2" style="text-align:center;background-color: #dedede">ค่าเที่ยว</th>

                        <!-- ช่วงวันที่ 21-31 (วันที่สุดท้ายที่เลือกข้อมูล)--> 
                        <th colspan="2" style="text-align:center;background-color: #dedede">จำนวนเที่ยว</th>
                        <th colspan="2" style="text-align:center;background-color: #dedede">ค่าเที่ยว</th>

                        <!-- รวม-->
                        <th colspan="2" style="text-align:center;background-color: #dedede">จำนวนเที่ยว</th>
                        <th colspan="2" style="text-align:center;background-color: #dedede">ค่าเที่ยว</th>
                    </tr>
                <?php
                }
                ?>

                

               
                

            </thead>
            <tbody>
                <?php
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

                    }else if ($_GET['companycode'] == 'RCC'  &&  $_GET['datasearch'] == 'พนักงานขนส่งยานยนต์/RCC 4 LOAD'){

                        $sql_sePerson = "SELECT PersonCode, SUBSTRING(PersonCode, 4, 6) AS 'R_PERSONCODE',nameT,PositionNameT
                        FROM EMPLOYEEEHR2 
                        WHERE (Company_Code ='RCC')
                        AND PositionNameT IN('พนักงานขนส่งยานยนต์/RCC 4 LOAD')
                        --WHERE  PositionNameT ='พนักงานขนส่งยานยนต์/RCC 4 LOAD'
                        --AND PersonCode NOT IN ('040904','040902','040896','040874','040885','040886')
                        ORDER BY PersonCode ASC";
                        $params_sePerson = array();
                        $query_sePerson = sqlsrv_query($conn, $sql_sePerson, $params_sePerson);

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
                        AND (PositionNameT LIKE('%Controller%') OR  PositionNameT LIKE('%เจ้าหน้าที่ คปป.%') OR PositionNameT LIKE('%เจ้าหน้าที่ฝึกอบรม%'))
                        --WHERE  PositionNameT ='พนักงานขนส่งยานยนต์/RCC 4 LOAD'
                        --AND PersonCode NOT IN ('090325','090334','090341','090342','090353','090356','090364',
                        --'090365','090366','090367','090368','090369','090370','090371')
                        ORDER BY PersonCode ASC";
                        $params_sePerson = array();
                        $query_sePerson = sqlsrv_query($conn, $sql_sePerson, $params_sePerson);

                    }

                    while ($result_sePerson = sqlsrv_fetch_array($query_sePerson, SQLSRV_FETCH_ASSOC)) {

                            
                            // //  นับจำนวนเที่ยว เงื่อนไขการนับคือ นับทุกเที่ยวยกเว้นงานรับกลับ
                            // //  นับจำนวนเที่ยว วันที่ 01-10
                            // $sql_sePlanTripRange1 = "{call megCompensationReport_RCC_RATC_v2(?,?,?,?,?)}";
                            // $params_sePlanTripRange1 = array(
                            //     array('select_trip_month', SQLSRV_PARAM_IN),
                            //     array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                            //     array($_GET['companycode'], SQLSRV_PARAM_IN),
                            //     array('01'.$monthyearstartchk, SQLSRV_PARAM_IN),
                            //     array('10'.$monthyearendchk, SQLSRV_PARAM_IN),
                            // );
                            // $query_sePlanTripRange1 = sqlsrv_query($conn, $sql_sePlanTripRange1, $params_sePlanTripRange1);
                            // $result_sePlanTripRange1 = sqlsrv_fetch_array($query_sePlanTripRange1, SQLSRV_FETCH_ASSOC);

                            // // echo $result_sePlanTripRange1['COUNTTRIP_MONTH'];
                            // // echo "<br>";

                            
                            // //  นับจำนวนเที่ยว วันที่ 11-20
                            // $sql_sePlanTripRange2 = "{call megCompensationReport_RCC_RATC_v2(?,?,?,?,?)}";
                            // $params_sePlanTripRange2 = array(
                            //     array('select_trip_month', SQLSRV_PARAM_IN),
                            //     array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                            //     array($_GET['companycode'], SQLSRV_PARAM_IN),
                            //     array('11'.$monthyearstartchk, SQLSRV_PARAM_IN),
                            //     array('20'.$monthyearendchk, SQLSRV_PARAM_IN),
                            // );
                            // $query_sePlanTripRange2 = sqlsrv_query($conn, $sql_sePlanTripRange2, $params_sePlanTripRange2);
                            // $result_sePlanTripRange2 = sqlsrv_fetch_array($query_sePlanTripRange2, SQLSRV_FETCH_ASSOC);
                            // // echo $result_sePlanTripRange2['COUNTTRIP'];
                            // // echo "<br>";

                            //  //  นับจำนวนเที่ยว วันที่ 21-31 หรือวันสุดท้ายที่เลือกข้อมูล
                            //  $sql_sePlanTripRange3 = "{call megCompensationReport_RCC_RATC_v2(?,?,?,?,?)}";
                            //  $params_sePlanTripRange3 = array(
                            //      array('select_trip_month', SQLSRV_PARAM_IN),
                            //      array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                            //      array($_GET['companycode'], SQLSRV_PARAM_IN),
                            //      array('21'.$monthyearstartchk, SQLSRV_PARAM_IN),
                            //      array($_GET['dateend'], SQLSRV_PARAM_IN),
                            //  );
                            //  $query_sePlanTripRange3 = sqlsrv_query($conn, $sql_sePlanTripRange3, $params_sePlanTripRange3);
                            //  $result_sePlanTripRange3 = sqlsrv_fetch_array($query_sePlanTripRange3, SQLSRV_FETCH_ASSOC);
                            //  // echo $result_sePlanTripRange3['COUNTTRIP'];
                            //  // echo "<br>";
                                

                            if ($_GET['datasearch'] == 'OTHER') {
                                // เฉพาะ คปป ,controller จะนับทุกบริษัทที่ไปวิ่งงาน
                                // นับค่าเที่ยว เงื่อนไขการนับคือ นับทุกเที่ยวรวมงานรับกลับ และ นับจำนวนเที่ยวด้วย
                                // นับค่าเที่ยว วันที่ 01-10
                                // Companycode ไม่ได้ส่งข้อมูล
                                $sql_sePlanComRange1 = "{call megCompensationReport_RCC_RATC_v2(?,?,?,?,?)}";
                                $params_sePlanComRange1 = array(
                                    array('select_compensation_month_other', SQLSRV_PARAM_IN),
                                    array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                                    array($_GET['companycode'], SQLSRV_PARAM_IN),
                                    array('01'.$monthyearstartchk, SQLSRV_PARAM_IN),
                                    array('10'.$monthyearendchk, SQLSRV_PARAM_IN),
                                );
                                $query_sePlanComRange1 = sqlsrv_query($conn, $sql_sePlanComRange1, $params_sePlanComRange1);
                                $result_sePlanComRange1 = sqlsrv_fetch_array($query_sePlanComRange1, SQLSRV_FETCH_ASSOC);
                                
                                // echo $monthyearstartchk;
                                // echo $result_sePlanComRange1['COUNTTRIP_MONTH'];
                                // echo "<br>";
                                // echo $result_sePlanTripRange1['COMPENSATION_MONTH'];
                                // echo "<br>";

                                //  นับค่าเที่ยว วันที่ 11-20
                                $sql_sePlanComRange2 = "{call megCompensationReport_RCC_RATC_v2(?,?,?,?,?)}";
                                $params_sePlanComRange2 = array(
                                    array('select_compensation_month_other', SQLSRV_PARAM_IN),
                                    array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                                    array($_GET['companycode'], SQLSRV_PARAM_IN),
                                    array('11'.$monthyearstartchk, SQLSRV_PARAM_IN),
                                    array('20'.$monthyearendchk, SQLSRV_PARAM_IN),
                                );
                                $query_sePlanComRange2 = sqlsrv_query($conn, $sql_sePlanComRange2, $params_sePlanComRange2);
                                $result_sePlanComRange2 = sqlsrv_fetch_array($query_sePlanComRange2, SQLSRV_FETCH_ASSOC);
                                
                                // echo $result_sePlanComRange2['COUNTTRIP_MONTH'];
                                // echo "<br>";
                                // echo $result_sePlanComRange2['COMPENSATION_MONTH'];
                                // echo "<br>";


                                //  นับค่าเที่ยว วันที่ 21-31 หรือวันสุดท้ายที่เลือกข้อมูล
                                $sql_sePlanComRange3 = "{call megCompensationReport_RCC_RATC_v2(?,?,?,?,?)}";
                                $params_sePlanComRange3 = array(
                                    array('select_compensation_month_other', SQLSRV_PARAM_IN),
                                    array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                                    array($_GET['companycode'], SQLSRV_PARAM_IN),
                                    array('21'.$monthyearstartchk, SQLSRV_PARAM_IN),
                                    array($_GET['dateend'], SQLSRV_PARAM_IN),
                                );
                                $query_sePlanComRange3 = sqlsrv_query($conn, $sql_sePlanComRange3, $params_sePlanComRange3);
                                $result_sePlanComRange3 = sqlsrv_fetch_array($query_sePlanComRange3, SQLSRV_FETCH_ASSOC);
                                
                                // echo $result_sePlanComRange3['COUNTTRIP_MONTH'];
                                // echo "<br>";
                                // echo $result_sePlanComRange3['COMPENSATION_MONTH'];
                                // echo "<br>";


                            }else {
                                // เฉพาะพนักงานสายงานนั้นๆ
                                // นับค่าเที่ยว เงื่อนไขการนับคือ นับทุกเที่ยวรวมงานรับกลับ และ นับจำนวนเที่ยวด้วย
                                // นับค่าเที่ยว วันที่ 01-10
                                // Companycode ไม่ได้ส่งข้อมูล
                                $sql_sePlanComRange1 = "{call megCompensationReport_RCC_RATC_v2(?,?,?,?,?)}";
                                $params_sePlanComRange1 = array(
                                    array('select_compensation_month', SQLSRV_PARAM_IN),
                                    array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                                    array($_GET['companycode'], SQLSRV_PARAM_IN),
                                    array('01'.$monthyearstartchk, SQLSRV_PARAM_IN),
                                    array('10'.$monthyearendchk, SQLSRV_PARAM_IN),
                                );
                                $query_sePlanComRange1 = sqlsrv_query($conn, $sql_sePlanComRange1, $params_sePlanComRange1);
                                $result_sePlanComRange1 = sqlsrv_fetch_array($query_sePlanComRange1, SQLSRV_FETCH_ASSOC);
                                
                                // echo $monthyearstartchk;
                                // echo $result_sePlanComRange1['COUNTTRIP_MONTH'];
                                // echo "<br>";
                                // echo $result_sePlanTripRange1['COMPENSATION_MONTH'];
                                // echo "<br>";

                                //  นับค่าเที่ยว วันที่ 11-20
                                $sql_sePlanComRange2 = "{call megCompensationReport_RCC_RATC_v2(?,?,?,?,?)}";
                                $params_sePlanComRange2 = array(
                                    array('select_compensation_month', SQLSRV_PARAM_IN),
                                    array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                                    array($_GET['companycode'], SQLSRV_PARAM_IN),
                                    array('11'.$monthyearstartchk, SQLSRV_PARAM_IN),
                                    array('20'.$monthyearendchk, SQLSRV_PARAM_IN),
                                );
                                $query_sePlanComRange2 = sqlsrv_query($conn, $sql_sePlanComRange2, $params_sePlanComRange2);
                                $result_sePlanComRange2 = sqlsrv_fetch_array($query_sePlanComRange2, SQLSRV_FETCH_ASSOC);
                                
                                // echo $result_sePlanComRange2['COUNTTRIP_MONTH'];
                                // echo "<br>";
                                // echo $result_sePlanComRange2['COMPENSATION_MONTH'];
                                // echo "<br>";


                                //  นับค่าเที่ยว วันที่ 21-31 หรือวันสุดท้ายที่เลือกข้อมูล
                                $sql_sePlanComRange3 = "{call megCompensationReport_RCC_RATC_v2(?,?,?,?,?)}";
                                $params_sePlanComRange3 = array(
                                    array('select_compensation_month', SQLSRV_PARAM_IN),
                                    array($result_sePerson['PersonCode'], SQLSRV_PARAM_IN),
                                    array($_GET['companycode'], SQLSRV_PARAM_IN),
                                    array('21'.$monthyearstartchk, SQLSRV_PARAM_IN),
                                    array($_GET['dateend'], SQLSRV_PARAM_IN),
                                );
                                $query_sePlanComRange3 = sqlsrv_query($conn, $sql_sePlanComRange3, $params_sePlanComRange3);
                                $result_sePlanComRange3 = sqlsrv_fetch_array($query_sePlanComRange3, SQLSRV_FETCH_ASSOC);
                                
                                // echo $result_sePlanComRange3['COUNTTRIP_MONTH'];
                                // echo "<br>";
                                // echo $result_sePlanComRange3['COMPENSATION_MONTH'];
                                // echo "<br>";

                            }



                            // TRIP
                            $TOTAL_TRIP   = ($result_sePlanComRange1['COUNTTRIP_MONTH']     + $result_sePlanComRange2['COUNTTRIP_MONTH']    + $result_sePlanComRange3['COUNTTRIP_MONTH']);
                            $TOTAL_COMPEN = ($result_sePlanComRange1['COMPENSATION_MONTH']  + $result_sePlanComRange2['COMPENSATION_MONTH'] + $result_sePlanComRange3['COMPENSATION_MONTH']);
                            
                            ?>
                            
                            <tr>
                                <td style="text-align: left"><?= $i?></td>
                                <td style="text-align: center">&nbsp;<?=$result_sePerson['PersonCode']?></td>
                                <td style="text-align: left">นาย &nbsp;<?=$result_sePerson['nameT']?></td>
                                <?php
                                if ($_GET['datasearch'] == 'OTHER') {
                                ?>
                                <td style="text-align: left"><?=$result_sePerson['PositionNameT']?></td>  
                                <?php
                                }else{
                                ?>

                                <?php
                                }
                                ?>
                                <!-- ช่วงวันที่ 1-10 -->
                                <td colspan="2" style="text-align: center;color:blue;"><?= $result_sePlanComRange1['COUNTTRIP_MONTH']  == '' ? '-' : $result_sePlanComRange1['COUNTTRIP_MONTH'] ?></td>
                                <td colspan="2" style="text-align: center;color:green;"><?= $result_sePlanComRange1['COMPENSATION_MONTH'] == '' ? '-' : number_format($result_sePlanComRange1['COMPENSATION_MONTH']) ?></td>
                                
                                <!-- ช่วงวันที่ 11-20 -->
                                <td colspan="2" style="text-align: center;color:blue;"><?= $result_sePlanComRange2['COUNTTRIP_MONTH']  == '' ? '-' : $result_sePlanComRange2['COUNTTRIP_MONTH'] ?></td>
                                <td colspan="2" style="text-align: center;color:green;"><?= $result_sePlanComRange2['COMPENSATION_MONTH']  == '' ? '-' : number_format($result_sePlanComRange2['COMPENSATION_MONTH']) ?></td>
                               
                                <!-- ช่วงวันที่ 21-31 (วันที่สุดท้ายที่เลือกข้อมูล)--> 
                                <td colspan="2" style="text-align: center;color:blue;"><?= $result_sePlanComRange3['COUNTTRIP_MONTH']  == '' ? '-' : $result_sePlanComRange3['COUNTTRIP_MONTH'] ?></td>
                                <td colspan="2" style="text-align: center;color:green;"><?= $result_sePlanComRange3['COMPENSATION_MONTH']  == '' ? '-' : number_format($result_sePlanComRange3['COMPENSATION_MONTH']) ?></td>
                               

                                <!-- รวม -->
                                <td colspan="2" style="text-align: center;color:red;"><?=$TOTAL_TRIP      == '' ? '-' : $TOTAL_TRIP?></td>
                                <td colspan="2" style="text-align: center;color:red;"><?=$TOTAL_COMPEN   == '' ? '-' : number_format($TOTAL_COMPEN)?></td>
                                
                                <!-- หมายเหตุ -->
                                <td style="text-align: center"></td>
                            </tr>

                        <?php
                          //ผลรวมจำนวนเที่ยว และ ค่าเที่ยว วันที่ 01-10
                          $SUM_TRIP_RANGE1      =  $SUM_TRIP_RANGE1     +  $result_sePlanComRange1['COUNTTRIP_MONTH'];
                          $SUM_COMPEN_RANGE1    =  $SUM_COMPEN_RANGE1   +  $result_sePlanComRange1['COMPENSATION_MONTH'];
                          //ผลรวมจำนวนเที่ยว และ ค่าเที่ยว วันที่ 11-20
                          $SUM_TRIP_RANGE2      =  $SUM_TRIP_RANGE2     +  $result_sePlanComRange2['COUNTTRIP_MONTH'];
                          $SUM_COMPEN_RANGE2    =  $SUM_COMPEN_RANGE2   +  $result_sePlanComRange2['COMPENSATION_MONTH'];
                          //ผลรวมจำนวนเที่ยว และ ค่าเที่ยว วันที่ 21-31 หรือวันสุดท้ายที่เลือกข้อมูล
                          $SUM_TRIP_RANGE3      =  $SUM_TRIP_RANGE3     +  $result_sePlanComRange3['COUNTTRIP_MONTH'];
                          $SUM_COMPEN_RANGE3    =  $SUM_COMPEN_RANGE3   +  $result_sePlanComRange3['COMPENSATION_MONTH'];
                          //รวม
                          $SUM_TOTAL_TRIP      =  $SUM_TOTAL_TRIP     +  $TOTAL_TRIP;
                          $SUM_TOTAL_COMPEN    =  $SUM_TOTAL_COMPEN   +  $TOTAL_COMPEN;

                        $i++;   
                    }
                    ?>
                <tr>
                    <?php
                    if ($_GET['datasearch'] == 'OTHER') {
                    ?>
                    <td colspan="4" style="text-align: right;background-color: #dedede">รวม</ก>
                    <?php
                    }else {
                    ?>
                    <td colspan="3" style="text-align: right;background-color: #dedede">รวม</ก>
                    <?php
                    }
                    ?>
                    

                    <td colspan="2" style="text-align: center;"><b><?=$SUM_TRIP_RANGE1      == '0' ? '-' : $SUM_TRIP_RANGE1?></b></td>
                    <td colspan="2" style="text-align: center;"><b><?=$SUM_COMPEN_RANGE1    == '0' ? '-' : number_format($SUM_COMPEN_RANGE1)?></b></td>
                    
                    <td colspan="2" style="text-align: center;"><b><?=$SUM_TRIP_RANGE2      == '0' ? '-' : $SUM_TRIP_RANGE2?></b></td>
                    <td colspan="2" style="text-align: center;"><b><?=$SUM_COMPEN_RANGE2    == '0' ? '-' : number_format($SUM_COMPEN_RANGE2)?></b></td>
                    
                    <td colspan="2" style="text-align: center;"><b><?=$SUM_TRIP_RANGE3      == '0' ? '-' : $SUM_TRIP_RANGE3?></b></td>
                    <td colspan="2" style="text-align: center;"><b><?=$SUM_COMPEN_RANGE3    == '0' ? '-' : number_format($SUM_COMPEN_RANGE3)?></b></td>
                    
                    <td colspan="2" style="text-align: center;"><b><?=$SUM_TOTAL_TRIP       == '0' ? '-' : $SUM_TOTAL_TRIP?></b></td>
                    <td colspan="2" style="text-align: center;"><b><?=$SUM_TOTAL_COMPEN     == '0' ? '-' : number_format($SUM_TOTAL_COMPEN)?></b></td>
                    
                    <td style="text-align: center;"></td>
                   
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
                    <td colspan="3" style="text-align: center;border:1px solid #000">(นางสาวรติกร เวศสุวรรณ)</td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">(นายวรวิทย์ คุณเจริญ)</td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">(นายบัญชา กงแก้ว)</td>
                </tr>
                <tr>
                    <td colspan="11" style="text-align: center;"></td>
                    <td colspan="3" style="text-align: center;border:1px solid #000">เจ้าหน้าที่<br>ฝ่ายงานขนส่ง</td>
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


