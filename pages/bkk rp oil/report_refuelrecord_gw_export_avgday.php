<?php

    $date1 = $_POST["txt_datestartoilmonthavarage"];
    $start = explode("/", $date1);
    $startd = $start[0];
    $startif = $start[1];
        if($startif == "01"){
            $startm = "มกราคม";
        }else if($startif == "02"){
            $startm = "กุมภาพันธ์";
        }else if($startif == "03"){
            $startm = "มีนาคม";
        }else if($startif == "04"){
            $startm = "เมษายน";
        }else if($startif == "05"){
            $startm = "พฤษภาคม";
        }else if($startif == "06"){
            $startm = "มิถุนายน";
        }else if($startif == "07"){
            $startm = "กรกฎาคม";
        }else if($startif == "08"){
            $startm = "สิงหาคม";
        }else if($startif == "09"){
            $startm = "กันยายน";
        }else if($startif == "10"){
            $startm = "ตุลาคม";
        }else if($startif == "11"){
            $startm = "พฤศจิกายน";
        }else if($startif == "12"){
            $startm = "ธันวาคม";
        }
    $starty = $start[2]+543;
    $startymd = $start[2].'-'.$start[1].'-'.$start[0];

    $date2 = $_POST["txt_dateendoilmonthavarage"];
    $end = explode("/", $date2);
    $endd = $end[0];
    $endif = $end[1];
        if($endif == "01"){
            $endm = "มกราคม";
        }else if($endif == "02"){
            $endm = "กุมภาพันธ์";
        }else if($endif == "03"){
            $endm = "มีนาคม";
        }else if($endif == "04"){
            $endm = "เมษายน";
        }else if($endif == "05"){
            $endm = "พฤษภาคม";
        }else if($endif == "06"){
            $endm = "มิถุนายน";
        }else if($endif == "07"){
            $endm = "กรกฎาคม";
        }else if($endif == "08"){
            $endm = "สิงหาคม";
        }else if($endif == "09"){
            $endm = "กันยายน";
        }else if($endif == "10"){
            $endm = "ตุลาคม";
        }else if($endif == "11"){
            $endm = "พฤศจิกายน";
        }else if($endif == "12"){
            $endm = "ธันวาคม";
        }
    $endy = $end[2]+543;
    $endymd = $end[2].'-'.$end[1].'-'.$end[0];

    session_start();
    date_default_timezone_set("Asia/Bangkok");
    ini_set('max_execution_time', 300);
    require_once("../mpdf/autoload.php");
    require_once("../class/meg_function.php");
    $conn = connect("RTMS");
    $sql_seSystime = "{call megGetdate_v2(?)}";
    $params_seSystime = array(array('select_getdate', SQLSRV_PARAM_IN));
    $query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
    $result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);
    
    $EXCELDAY=$_POST['EXCELDAY'];
    $EXCELMONTH=$_POST['EXCELMONTH'];
    $SORTBY=$_POST["SORTBY"];    
    if($SORTBY=='DATEPLAN'){
        $SORTQUERY='VHCTPP.DATEWORKING';        
    }else if($SORTBY=='DATEREFUEL'){
        $SORTQUERY='OTSN.REFUELINGDATE';  
    }

    $LINEOFWORK=$_POST["lineofworkmonth"]; 
    if($LINEOFWORK == 'RRC1'){
        $QUERYWHERE1="EHR.Company_Code = 'RRC' AND EHR.PositionNameT LIKE '%GMT%'";
        $QUERYWHERE2="VHCTPP.CUSTOMERCODE IN('GMT')";
        $FINECUSTOMER="NOT CUSTOMERCODE = 'TTAST'";
        // $FINECUSTOMER="CUSTOMERCODE IN('GMT')";
        $QUERYWHERE3="1=1 ORDER BY EHR.PersonCode ASC";
        $SHOW='GMT';
    }else if($LINEOFWORK == 'RRC2'){
        $QUERYWHERE1="EHR.Company_Code = 'RRC' AND EHR.PositionNameT LIKE '%TTAST%'";
        $QUERYWHERE2="VHCTPP.CUSTOMERCODE IN('TTAST')";
        $FINECUSTOMER="NOT CUSTOMERCODE = 'GMT'";
        $QUERYWHERE3="1=1 ORDER BY EHR.PersonCode ASC";
        $SHOW='TTAST';
    }else if($LINEOFWORK == 'RATC1'){
        $QUERYWHERE1="EHR.Company_Code = 'RATC' AND EHR.PositionNameT LIKE '%RATC 8 LOAD%'";
        $QUERYWHERE2="VHCTPP.CUSTOMERCODE IN('TTT')";
        $FINECUSTOMER="1=1";
        $QUERYWHERE3="EHR.Company_Code = 'RATC' AND NOT EHR.PositionNameT LIKE '%4 LOAD%' ORDER BY EHR.PersonCode ASC";
        $SHOW='TTT';
    }else if($LINEOFWORK == 'RCC1'){
        $QUERYWHERE1="EHR.Company_Code = 'RCC' AND EHR.PositionNameT LIKE '%RCC 4 LOAD%'";
        $QUERYWHERE2="VHCTPP.CUSTOMERCODE IN('TTT')";
        $FINECUSTOMER="1=1";
        $QUERYWHERE3="EHR.Company_Code = 'RCC' AND NOT EHR.PositionNameT LIKE '%8 LOAD%' ORDER BY EHR.PersonCode ASC";
        $SHOW='TTT';
    }else if($LINEOFWORK == 'RCC2'){
        $QUERYWHERE1="EHR.Company_Code = 'RCC' AND EHR.PositionNameT LIKE '%RCC 8 LOAD%'";
        $QUERYWHERE2="VHCTPP.CUSTOMERCODE IN('TTT')";
        $FINECUSTOMER="1=1";
        $QUERYWHERE3="EHR.Company_Code = 'RCC' AND NOT EHR.PositionNameT LIKE '%4 LOAD%' ORDER BY EHR.PersonCode ASC";
        $SHOW='TTT';
    }  
    
    // echo"<pre>";
    // print_r($_POST);
    // echo"<br>";
    // print_r($LINEOFWORK);
    // echo"<br>";
    // print_r($QUERYWHERE1);
    // echo"</pre>";
    // exit();
              
    
if ($EXCELDAY != "") { ?>
    <?php
        $RENAME= "สรุปค่าเฉลี่ยน้ำมันเดือน $startm $starty";
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$RENAME.xls");
        header("Pragma: no-cache");
        header("Expires: ");
    ?>       
    <div class="wrapper">
        <section class="invoice">
            <table>
                <thead>
                    <tr border="0">
                        <th colspan="71" style="background-color: #fff"><div align="left"><b>สรุปค่าเฉลี่ยน้ำมันเดือน <?=$startm.' '.$starty;?></b></div></th>
                        <th colspan="2" style="background-color: #fff"><div align="right"><b>สายงาน <?=$SHOW?></b> </div></th>
                    </tr>
                </thead>
            </table>       
            <table id="NoExtention1" class="table table-bordered " style="font-size: 13px;" border="1" width="100%">
                <thead>
                    <tr>
                        <th rowspan="2" style="background-color: #fff"><div align="center">ลำดับ</div></th>
                        <th rowspan="2" style="background-color: #fff"><div align="center">รหัส</div></th>
                        <th rowspan="2" style="background-color: #fff"><div align="center">ชื่อ-สกุล</div></th>
                        <th rowspan="2" style="background-color: #fff"><div align="center">จำนวนเที่ยว</div></th>
                        <th rowspan="2" style="background-color: #fff"><div align="center">กิโลเมตร</div></th>
                        <th rowspan="2" style="background-color: #fff"><div align="center">KM/Trip</div></th>
                        <th rowspan="2" style="background-color: #fff"><div align="center">สายงาน</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">1</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">2</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">3</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">4</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">5</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">6</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">7</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">8</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">9</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">10</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">11</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">12</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">13</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">14</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">15</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">16</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">17</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">18</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">19</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">20</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">21</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">22</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">23</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">24</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">25</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">26</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">27</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">28</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">29</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">30</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">31</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">รวมสุทธิ</div></th>
                        <th rowspan="2" style="background-color: #fff"><div align="center">ยอดที่จ่ายจริง</div></th>
                        <th rowspan="2" style="background-color: #fff"><div align="center">สาเหตุ</div></th>
                    </tr>
                    <tr>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                    </tr>
                </thead> 
                <tbody>
                    <?php             
                        // $SQLEMP = "SELECT DISTINCT EHR.PersonCode EMPC,EHR.Company_Code,EHR.Company_NameT,EHR.PositionNameT POS,EHR.FnameT,EHR.LnameT,EHR.nameT EMPN 
                        // FROM EMPLOYEEEHR2 EHR WHERE $QUERYWHERE1";  
                        // $QUERYEMP = sqlsrv_query($conn, $SQLEMP );
                        // $resultid = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
                        // $result = sqlsrv_query($conn, $SQLEMP ); 
                        $SQLEMP = "SELECT DISTINCT EHR.PersonCode EMPC,EHR.Company_Code,EHR.Company_NameT,EHR.PositionNameT POS,EHR.FnameT,EHR.LnameT,EHR.nameT EMPN 
                        FROM EMPLOYEEEHR2 EHR WHERE $QUERYWHERE1 
                        UNION
                        SELECT DISTINCT EHR.PersonCode EMPC,EHR.Company_Code,EHR.Company_NameT,EHR.PositionNameT POS,EHR.FnameT,EHR.LnameT,EHR.nameT EMPN 
                        FROM VEHICLETRANSPORTPLAN VHCTPP 
                        LEFT JOIN EMPLOYEEEHR2 EHR ON (VHCTPP.EMPLOYEECODE1 = EHR.PersonCode OR VHCTPP.EMPLOYEECODE2 = EHR.PersonCode)
                        WHERE NOT (EHR.PositionNameT LIKE '%ปลอกเขียว%' OR EHR.PositionNameT LIKE '%ปลอกเหลือง%') AND VHCTPP.O4 IS NOT NULL
                        AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) BETWEEN '$start[2]-$start[1]-01' AND '$end[2]-$end[1]-31' AND NOT EHR.Company_Code IN('RKR','RKL','RKS')
                        AND $QUERYWHERE2 
                        AND $QUERYWHERE3";  
                        $QUERYEMP = sqlsrv_query($conn, $SQLEMP );
                        $i = 1;
                        while($RESULTEMP = sqlsrv_fetch_array($QUERYEMP)) {    
                            $EMPC=$RESULTEMP["EMPC"];           
                            $EMPN=$RESULTEMP["EMPN"];  
                            $POS=$RESULTEMP["POS"];       
                        if($LINEOFWORK == 'OTHER'){ 
                            $RSPOS2 = $POS;     
                        }else{                  
                            $POSSPLIT = explode("/", $POS);
                            $RSPOS1 = $POSSPLIT[0];
                            $RSPOS2 = $POSSPLIT[1];
                        }

                        $SQLROUND="SELECT COUNT(VHCTPP.EMPLOYEECODE1) AS ROUND FROM VEHICLETRANSPORTPLAN VHCTPP 
                        WHERE (VHCTPP.EMPLOYEECODE1 = '$EMPC' OR VHCTPP.EMPLOYEECODE2 = '$EMPC') 
                        AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) BETWEEN '$start[2]-$start[1]-01' AND '$end[2]-$end[1]-31'";
                        $QUERYROUND = sqlsrv_query($conn, $SQLROUND ); 
                        $RESULTROUND = sqlsrv_fetch_array($QUERYROUND, SQLSRV_FETCH_ASSOC);
                        $ROUND=$RESULTROUND["ROUND"];

                        $SQLDTE="SELECT 
                        -- SUM	( ISNULL( CAST ( OTSNDTE.DISTANCE AS DECIMAL ( 6, 2 ) ), 0 ) ) AS RSDTE 
                        SUM(CAST(OTSNDTE.DISTANCE as DECIMAL)) AS RSDTE 
                        FROM VEHICLETRANSPORTPLAN VHCTPPDTE
                        LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSNDTE ON VHCTPPDTE.JOBNO = OTSNDTE.JOBNO COLLATE Thai_CI_AI
                        WHERE (VHCTPPDTE.EMPLOYEECODE1 = '$EMPC' OR VHCTPPDTE.EMPLOYEECODE2 = '$EMPC') 
                        -- AND VHCTPPDTE.C3 IS NOT NULL 
                        AND CONVERT ( VARCHAR ( 10 ), VHCTPPDTE.DATEWORKING, 20 ) BETWEEN '$start[2]-$start[1]-01' AND '$end[2]-$end[1]-31'";
                        $QUERYDTE = sqlsrv_query($conn, $SQLDTE ); 
                        $RESULTDTE = sqlsrv_fetch_array($QUERYDTE, SQLSRV_FETCH_ASSOC);
                        $RSDTE=$RESULTDTE["RSDTE"]; 
                        
                        $SQLRDAY="SELECT DISTINCT A.PersonCode, 		
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-01') AS C3DAY01PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-01') AS C3DAY01MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-02') AS C3DAY02PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-02') AS C3DAY02MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-03') AS C3DAY03PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-03') AS C3DAY03MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-04') AS C3DAY04PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-04') AS C3DAY04MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-05') AS C3DAY05PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-05') AS C3DAY05MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-06') AS C3DAY06PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-06') AS C3DAY06MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-07') AS C3DAY07PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-07') AS C3DAY07MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-08') AS C3DAY08PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-08') AS C3DAY08MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-09') AS C3DAY09PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-09') AS C3DAY09MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-10') AS C3DAY10PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-10') AS C3DAY10MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-11') AS C3DAY11PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-11') AS C3DAY11MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-12') AS C3DAY12PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-12') AS C3DAY12MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-13') AS C3DAY13PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-13') AS C3DAY13MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-14') AS C3DAY14PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-14') AS C3DAY14MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-15') AS C3DAY15PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-15') AS C3DAY15MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-16') AS C3DAY16PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-16') AS C3DAY16MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-17') AS C3DAY17PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-17') AS C3DAY17MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-18') AS C3DAY18PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-18') AS C3DAY18MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-19') AS C3DAY19PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-19') AS C3DAY19MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-20') AS C3DAY20PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-20') AS C3DAY20MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-21') AS C3DAY21PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-21') AS C3DAY21MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-22') AS C3DAY22PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-22') AS C3DAY22MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-23') AS C3DAY23PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-23') AS C3DAY23MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-24') AS C3DAY24PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-24') AS C3DAY24MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-25') AS C3DAY25PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-25') AS C3DAY25MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-26') AS C3DAY26PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-26') AS C3DAY26MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-27') AS C3DAY27PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-27') AS C3DAY27MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-28') AS C3DAY28PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-28') AS C3DAY28MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-29') AS C3DAY29PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-29') AS C3DAY29MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-30') AS C3DAY30PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-30') AS C3DAY30MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-31') AS C3DAY31PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-31') AS C3DAY31MINUS
                            FROM TEMP_RPAVGDAY_GW A WHERE A.PersonCode = '$EMPC'";
                        $QUERYRDAY = sqlsrv_query($conn, $SQLRDAY ); 
                        $RESULTRDAY = sqlsrv_fetch_array($QUERYRDAY, SQLSRV_FETCH_ASSOC);
                            $C3DAY01PLUS=$RESULTRDAY["C3DAY01PLUS"];  /** ------- **/ $C3DAY01MINUS=$RESULTRDAY["C3DAY01MINUS"]; 
                            $C3DAY02PLUS=$RESULTRDAY["C3DAY02PLUS"];  /** ------- **/ $C3DAY02MINUS=$RESULTRDAY["C3DAY02MINUS"]; 
                            $C3DAY03PLUS=$RESULTRDAY["C3DAY03PLUS"];  /** ------- **/ $C3DAY03MINUS=$RESULTRDAY["C3DAY03MINUS"]; 
                            $C3DAY04PLUS=$RESULTRDAY["C3DAY04PLUS"];  /** ------- **/ $C3DAY04MINUS=$RESULTRDAY["C3DAY04MINUS"]; 
                            $C3DAY05PLUS=$RESULTRDAY["C3DAY05PLUS"];  /** ------- **/ $C3DAY05MINUS=$RESULTRDAY["C3DAY05MINUS"]; 
                            $C3DAY06PLUS=$RESULTRDAY["C3DAY06PLUS"];  /** ------- **/ $C3DAY06MINUS=$RESULTRDAY["C3DAY06MINUS"]; 
                            $C3DAY07PLUS=$RESULTRDAY["C3DAY07PLUS"];  /** ------- **/ $C3DAY07MINUS=$RESULTRDAY["C3DAY07MINUS"]; 
                            $C3DAY08PLUS=$RESULTRDAY["C3DAY08PLUS"];  /** ------- **/ $C3DAY08MINUS=$RESULTRDAY["C3DAY08MINUS"]; 
                            $C3DAY09PLUS=$RESULTRDAY["C3DAY09PLUS"];  /** ------- **/ $C3DAY09MINUS=$RESULTRDAY["C3DAY09MINUS"]; 
                            $C3DAY10PLUS=$RESULTRDAY["C3DAY10PLUS"];  /** ------- **/ $C3DAY10MINUS=$RESULTRDAY["C3DAY10MINUS"]; 
                            $C3DAY11PLUS=$RESULTRDAY["C3DAY11PLUS"];  /** ------- **/ $C3DAY11MINUS=$RESULTRDAY["C3DAY11MINUS"]; 
                            $C3DAY12PLUS=$RESULTRDAY["C3DAY12PLUS"];  /** ------- **/ $C3DAY12MINUS=$RESULTRDAY["C3DAY12MINUS"]; 
                            $C3DAY13PLUS=$RESULTRDAY["C3DAY13PLUS"];  /** ------- **/ $C3DAY13MINUS=$RESULTRDAY["C3DAY13MINUS"]; 
                            $C3DAY14PLUS=$RESULTRDAY["C3DAY14PLUS"];  /** ------- **/ $C3DAY14MINUS=$RESULTRDAY["C3DAY14MINUS"]; 
                            $C3DAY15PLUS=$RESULTRDAY["C3DAY15PLUS"];  /** ------- **/ $C3DAY15MINUS=$RESULTRDAY["C3DAY15MINUS"]; 
                            $C3DAY16PLUS=$RESULTRDAY["C3DAY16PLUS"];  /** ------- **/ $C3DAY16MINUS=$RESULTRDAY["C3DAY16MINUS"]; 
                            $C3DAY17PLUS=$RESULTRDAY["C3DAY17PLUS"];  /** ------- **/ $C3DAY17MINUS=$RESULTRDAY["C3DAY17MINUS"]; 
                            $C3DAY18PLUS=$RESULTRDAY["C3DAY18PLUS"];  /** ------- **/ $C3DAY18MINUS=$RESULTRDAY["C3DAY18MINUS"]; 
                            $C3DAY19PLUS=$RESULTRDAY["C3DAY19PLUS"];  /** ------- **/ $C3DAY19MINUS=$RESULTRDAY["C3DAY19MINUS"]; 
                            $C3DAY20PLUS=$RESULTRDAY["C3DAY20PLUS"];  /** ------- **/ $C3DAY20MINUS=$RESULTRDAY["C3DAY20MINUS"]; 
                            $C3DAY21PLUS=$RESULTRDAY["C3DAY21PLUS"];  /** ------- **/ $C3DAY21MINUS=$RESULTRDAY["C3DAY21MINUS"]; 
                            $C3DAY22PLUS=$RESULTRDAY["C3DAY22PLUS"];  /** ------- **/ $C3DAY22MINUS=$RESULTRDAY["C3DAY22MINUS"]; 
                            $C3DAY23PLUS=$RESULTRDAY["C3DAY23PLUS"];  /** ------- **/ $C3DAY23MINUS=$RESULTRDAY["C3DAY23MINUS"]; 
                            $C3DAY24PLUS=$RESULTRDAY["C3DAY24PLUS"];  /** ------- **/ $C3DAY24MINUS=$RESULTRDAY["C3DAY24MINUS"]; 
                            $C3DAY25PLUS=$RESULTRDAY["C3DAY25PLUS"];  /** ------- **/ $C3DAY25MINUS=$RESULTRDAY["C3DAY25MINUS"]; 
                            $C3DAY26PLUS=$RESULTRDAY["C3DAY26PLUS"];  /** ------- **/ $C3DAY26MINUS=$RESULTRDAY["C3DAY26MINUS"]; 
                            $C3DAY27PLUS=$RESULTRDAY["C3DAY27PLUS"];  /** ------- **/ $C3DAY27MINUS=$RESULTRDAY["C3DAY27MINUS"];  
                            $C3DAY28PLUS=$RESULTRDAY["C3DAY28PLUS"];  /** ------- **/ $C3DAY28MINUS=$RESULTRDAY["C3DAY28MINUS"]; 
                            $C3DAY29PLUS=$RESULTRDAY["C3DAY29PLUS"];  /** ------- **/ $C3DAY29MINUS=$RESULTRDAY["C3DAY29MINUS"]; 
                            $C3DAY30PLUS=$RESULTRDAY["C3DAY30PLUS"];  /** ------- **/ $C3DAY30MINUS=$RESULTRDAY["C3DAY30MINUS"]; 
                            $C3DAY31PLUS=$RESULTRDAY["C3DAY31PLUS"];  /** ------- **/ $C3DAY31MINUS=$RESULTRDAY["C3DAY31MINUS"]; 
                    ?>
                        <tr>
                            <td align="center"><?=$i;?></td>
                            <td align="center"><?=$EMPC;?></td>
                            <td align="left"><?=$EMPN;?></td>
                            <td align="center"><?php if(($ROUND=="0")||($ROUND=="")){$RSROUND="0";echo "0";}else{echo number_format($ROUND, 0); };?></td>
                            <td align="center"><?php if(($RSDTE=="0")||($RSDTE=="")){$RSSUMDTE="0";echo "0";}else{echo number_format($RSDTE, 0); }; ?></td>
                            <td align="center"><?php if(($ROUND=="0")||($RSDTE=="0")){$KMTRIP="0";}else{$KMTRIP=$RSDTE/$ROUND;} ?><?php if(($KMTRIP=="0")||($KMTRIP=="")){echo "0";}else{echo number_format($KMTRIP, 0); };?></td>
                            <td align="center"><?=$RSPOS2;?></td>
                            <td align="right"><?php if($C3DAY01PLUS==""){echo "";}else{echo $C3DAY01PLUS;};?></td>
                            <td align="right"><?php if($C3DAY01MINUS==""){echo "";}else{echo $C3DAY01MINUS;};?></td>
                            <td align="right"><?php if($C3DAY02PLUS==""){echo "";}else{echo $C3DAY02PLUS;};?></td>
                            <td align="right"><?php if($C3DAY02MINUS==""){echo "";}else{echo $C3DAY02MINUS;};?></td>
                            <td align="right"><?php if($C3DAY03PLUS==""){echo "";}else{echo $C3DAY03PLUS;};?></td>
                            <td align="right"><?php if($C3DAY03MINUS==""){echo "";}else{echo $C3DAY03MINUS;};?></td>
                            <td align="right"><?php if($C3DAY04PLUS==""){echo "";}else{echo $C3DAY04PLUS;};?></td>
                            <td align="right"><?php if($C3DAY04MINUS==""){echo "";}else{echo $C3DAY04MINUS;};?></td>
                            <td align="right"><?php if($C3DAY05PLUS==""){echo "";}else{echo $C3DAY05PLUS;};?></td>
                            <td align="right"><?php if($C3DAY05MINUS==""){echo "";}else{echo $C3DAY05MINUS;};?></td>
                            <td align="right"><?php if($C3DAY06PLUS==""){echo "";}else{echo $C3DAY06PLUS;};?></td>
                            <td align="right"><?php if($C3DAY06MINUS==""){echo "";}else{echo $C3DAY06MINUS;};?></td>
                            <td align="right"><?php if($C3DAY07PLUS==""){echo "";}else{echo $C3DAY07PLUS;};?></td>
                            <td align="right"><?php if($C3DAY07MINUS==""){echo "";}else{echo $C3DAY07MINUS;};?></td>
                            <td align="right"><?php if($C3DAY08PLUS==""){echo "";}else{echo $C3DAY08PLUS;};?></td>
                            <td align="right"><?php if($C3DAY08MINUS==""){echo "";}else{echo $C3DAY08MINUS;};?></td>
                            <td align="right"><?php if($C3DAY09PLUS==""){echo "";}else{echo $C3DAY09PLUS;};?></td>
                            <td align="right"><?php if($C3DAY09MINUS==""){echo "";}else{echo $C3DAY09MINUS;};?></td>
                            <td align="right"><?php if($C3DAY10PLUS==""){echo "";}else{echo $C3DAY10PLUS;};?></td>
                            <td align="right"><?php if($C3DAY10MINUS==""){echo "";}else{echo $C3DAY10MINUS;};?></td>
                            <td align="right"><?php if($C3DAY11PLUS==""){echo "";}else{echo $C3DAY11PLUS;};?></td>
                            <td align="right"><?php if($C3DAY11MINUS==""){echo "";}else{echo $C3DAY11MINUS;};?></td>
                            <td align="right"><?php if($C3DAY12PLUS==""){echo "";}else{echo $C3DAY12PLUS;};?></td>
                            <td align="right"><?php if($C3DAY12MINUS==""){echo "";}else{echo $C3DAY12MINUS;};?></td>
                            <td align="right"><?php if($C3DAY13PLUS==""){echo "";}else{echo $C3DAY13PLUS;};?></td>
                            <td align="right"><?php if($C3DAY13MINUS==""){echo "";}else{echo $C3DAY13MINUS;};?></td>
                            <td align="right"><?php if($C3DAY14PLUS==""){echo "";}else{echo $C3DAY14PLUS;};?></td>
                            <td align="right"><?php if($C3DAY14MINUS==""){echo "";}else{echo $C3DAY14MINUS;};?></td>
                            <td align="right"><?php if($C3DAY15PLUS==""){echo "";}else{echo $C3DAY15PLUS;};?></td>
                            <td align="right"><?php if($C3DAY15MINUS==""){echo "";}else{echo $C3DAY15MINUS;};?></td>
                            <td align="right"><?php if($C3DAY16PLUS==""){echo "";}else{echo $C3DAY16PLUS;};?></td>
                            <td align="right"><?php if($C3DAY16MINUS==""){echo "";}else{echo $C3DAY16MINUS;};?></td>
                            <td align="right"><?php if($C3DAY17PLUS==""){echo "";}else{echo $C3DAY17PLUS;};?></td>
                            <td align="right"><?php if($C3DAY17MINUS==""){echo "";}else{echo $C3DAY17MINUS;};?></td>
                            <td align="right"><?php if($C3DAY18PLUS==""){echo "";}else{echo $C3DAY18PLUS;};?></td>
                            <td align="right"><?php if($C3DAY18MINUS==""){echo "";}else{echo $C3DAY18MINUS;};?></td>
                            <td align="right"><?php if($C3DAY19PLUS==""){echo "";}else{echo $C3DAY19PLUS;};?></td>
                            <td align="right"><?php if($C3DAY19MINUS==""){echo "";}else{echo $C3DAY19MINUS;};?></td>
                            <td align="right"><?php if($C3DAY20PLUS==""){echo "";}else{echo $C3DAY20PLUS;};?></td>
                            <td align="right"><?php if($C3DAY20MINUS==""){echo "";}else{echo $C3DAY20MINUS;};?></td>
                            <td align="right"><?php if($C3DAY21PLUS==""){echo "";}else{echo $C3DAY21PLUS;};?></td>
                            <td align="right"><?php if($C3DAY21MINUS==""){echo "";}else{echo $C3DAY21MINUS;};?></td>
                            <td align="right"><?php if($C3DAY22PLUS==""){echo "";}else{echo $C3DAY22PLUS;};?></td>
                            <td align="right"><?php if($C3DAY22MINUS==""){echo "";}else{echo $C3DAY22MINUS;};?></td>
                            <td align="right"><?php if($C3DAY23PLUS==""){echo "";}else{echo $C3DAY23PLUS;};?></td>
                            <td align="right"><?php if($C3DAY23MINUS==""){echo "";}else{echo $C3DAY23MINUS;};?></td>
                            <td align="right"><?php if($C3DAY24PLUS==""){echo "";}else{echo $C3DAY24PLUS;};?></td>
                            <td align="right"><?php if($C3DAY24MINUS==""){echo "";}else{echo $C3DAY24MINUS;};?></td>
                            <td align="right"><?php if($C3DAY25PLUS==""){echo "";}else{echo $C3DAY25PLUS;};?></td>
                            <td align="right"><?php if($C3DAY25MINUS==""){echo "";}else{echo $C3DAY25MINUS;};?></td>
                            <td align="right"><?php if($C3DAY26PLUS==""){echo "";}else{echo $C3DAY26PLUS;};?></td>
                            <td align="right"><?php if($C3DAY26MINUS==""){echo "";}else{echo $C3DAY26MINUS;};?></td>
                            <td align="right"><?php if($C3DAY27PLUS==""){echo "";}else{echo $C3DAY27PLUS;};?></td>
                            <td align="right"><?php if($C3DAY27MINUS==""){echo "";}else{echo $C3DAY27MINUS;};?></td>
                            <td align="right"><?php if($C3DAY28PLUS==""){echo "";}else{echo $C3DAY28PLUS;};?></td>
                            <td align="right"><?php if($C3DAY28MINUS==""){echo "";}else{echo $C3DAY28MINUS;};?></td>
                            <td align="right"><?php if($C3DAY29PLUS==""){echo "";}else{echo $C3DAY29PLUS;};?></td>
                            <td align="right"><?php if($C3DAY29MINUS==""){echo "";}else{echo $C3DAY29MINUS;};?></td>
                            <td align="right"><?php if($C3DAY30PLUS==""){echo "";}else{echo $C3DAY30PLUS;};?></td>
                            <td align="right"><?php if($C3DAY30MINUS==""){echo "";}else{echo $C3DAY30MINUS;};?></td>
                            <td align="right"><?php if($C3DAY31PLUS==""){echo "";}else{echo $C3DAY31PLUS;};?></td>
                            <td align="right"><?php if($C3DAY31MINUS==""){echo "";}else{echo $C3DAY31MINUS;};?></td>
                            <td align="right"><?php $SUMTOTALPLUS=$C3DAY01PLUS+$C3DAY02PLUS+$C3DAY03PLUS+$C3DAY04PLUS+$C3DAY05PLUS+$C3DAY06PLUS+$C3DAY07PLUS+$C3DAY08PLUS+$C3DAY09PLUS+$C3DAY10PLUS+
                                                $C3DAY11PLUS+$C3DAY12PLUS+$C3DAY13PLUS+$C3DAY14PLUS+$C3DAY15PLUS+$C3DAY16PLUS+$C3DAY17PLUS+$C3DAY18PLUS+$C3DAY19PLUS+$C3DAY20PLUS+$C3DAY21PLUS+
                                                $C3DAY22PLUS+$C3DAY23PLUS+$C3DAY24PLUS+$C3DAY25PLUS+$C3DAY26PLUS+$C3DAY27PLUS+$C3DAY28PLUS+$C3DAY29PLUS+$C3DAY30PLUS+$C3DAY31PLUS;?>
                                                <?php echo number_format($SUMTOTALPLUS, 0); ?></td>
                            <td align="right"><font color="red"><?php $SUMTOTALMINUS=$C3DAY01MINUS+$C3DAY02MINUS+$C3DAY03MINUS+$C3DAY04MINUS+$C3DAY05MINUS+$C3DAY06MINUS+$C3DAY07MINUS+$C3DAY08MINUS+$C3DAY09MINUS+$C3DAY10MINUS+
                                                $C3DAY11MINUS+$C3DAY12MINUS+$C3DAY13MINUS+$C3DAY14MINUS+$C3DAY15MINUS+$C3DAY16MINUS+$C3DAY17MINUS+$C3DAY18MINUS+$C3DAY19MINUS+$C3DAY20MINUS+$C3DAY21MINUS+
                                                $C3DAY22MINUS+$C3DAY23MINUS+$C3DAY24MINUS+$C3DAY25MINUS+$C3DAY26MINUS+$C3DAY27MINUS+$C3DAY28MINUS+$C3DAY29MINUS+$C3DAY30MINUS+$C3DAY31MINUS;?>
                                                <?php echo number_format($SUMTOTALMINUS, 0); ?></font></td>
                            <td align="right"><?php $CALPLUSMINUS=$SUMTOTALPLUS+$SUMTOTALMINUS; echo number_format($CALPLUSMINUS, 0); ?></td>
                            <td align="right"></td>
                        </tr>    
                    <?php $i++;    
                        // PLUS   
                            $CALC3DAY01PLUS=$CALC3DAY01PLUS+$C3DAY01PLUS; 
                            $CALC3DAY02PLUS=$CALC3DAY02PLUS+$C3DAY02PLUS; 
                            $CALC3DAY03PLUS=$CALC3DAY03PLUS+$C3DAY03PLUS; 
                            $CALC3DAY04PLUS=$CALC3DAY04PLUS+$C3DAY04PLUS; 
                            $CALC3DAY05PLUS=$CALC3DAY05PLUS+$C3DAY05PLUS; 
                            $CALC3DAY06PLUS=$CALC3DAY06PLUS+$C3DAY06PLUS; 
                            $CALC3DAY07PLUS=$CALC3DAY07PLUS+$C3DAY07PLUS; 
                            $CALC3DAY08PLUS=$CALC3DAY08PLUS+$C3DAY08PLUS; 
                            $CALC3DAY09PLUS=$CALC3DAY09PLUS+$C3DAY09PLUS; 
                            $CALC3DAY10PLUS=$CALC3DAY10PLUS+$C3DAY10PLUS; 
                            $CALC3DAY11PLUS=$CALC3DAY11PLUS+$C3DAY11PLUS; 
                            $CALC3DAY12PLUS=$CALC3DAY12PLUS+$C3DAY12PLUS; 
                            $CALC3DAY13PLUS=$CALC3DAY13PLUS+$C3DAY13PLUS; 
                            $CALC3DAY14PLUS=$CALC3DAY14PLUS+$C3DAY14PLUS; 
                            $CALC3DAY15PLUS=$CALC3DAY15PLUS+$C3DAY15PLUS; 
                            $CALC3DAY16PLUS=$CALC3DAY16PLUS+$C3DAY16PLUS; 
                            $CALC3DAY17PLUS=$CALC3DAY17PLUS+$C3DAY17PLUS; 
                            $CALC3DAY18PLUS=$CALC3DAY18PLUS+$C3DAY18PLUS; 
                            $CALC3DAY19PLUS=$CALC3DAY19PLUS+$C3DAY19PLUS; 
                            $CALC3DAY20PLUS=$CALC3DAY20PLUS+$C3DAY20PLUS; 
                            $CALC3DAY21PLUS=$CALC3DAY21PLUS+$C3DAY21PLUS; 
                            $CALC3DAY22PLUS=$CALC3DAY22PLUS+$C3DAY22PLUS; 
                            $CALC3DAY23PLUS=$CALC3DAY23PLUS+$C3DAY23PLUS; 
                            $CALC3DAY24PLUS=$CALC3DAY24PLUS+$C3DAY24PLUS; 
                            $CALC3DAY25PLUS=$CALC3DAY25PLUS+$C3DAY25PLUS; 
                            $CALC3DAY26PLUS=$CALC3DAY26PLUS+$C3DAY26PLUS; 
                            $CALC3DAY27PLUS=$CALC3DAY27PLUS+$C3DAY27PLUS; 
                            $CALC3DAY28PLUS=$CALC3DAY28PLUS+$C3DAY28PLUS; 
                            $CALC3DAY29PLUS=$CALC3DAY29PLUS+$C3DAY29PLUS; 
                            $CALC3DAY30PLUS=$CALC3DAY30PLUS+$C3DAY30PLUS; 
                            $CALC3DAY31PLUS=$CALC3DAY31PLUS+$C3DAY31PLUS;                              
                        // MINUS
                            $CALC3DAY01MINUS=$CALC3DAY01MINUS+$C3DAY01MINUS; 
                            $CALC3DAY02MINUS=$CALC3DAY02MINUS+$C3DAY02MINUS; 
                            $CALC3DAY03MINUS=$CALC3DAY03MINUS+$C3DAY03MINUS; 
                            $CALC3DAY04MINUS=$CALC3DAY04MINUS+$C3DAY04MINUS; 
                            $CALC3DAY05MINUS=$CALC3DAY05MINUS+$C3DAY05MINUS; 
                            $CALC3DAY06MINUS=$CALC3DAY06MINUS+$C3DAY06MINUS; 
                            $CALC3DAY07MINUS=$CALC3DAY07MINUS+$C3DAY07MINUS; 
                            $CALC3DAY08MINUS=$CALC3DAY08MINUS+$C3DAY08MINUS; 
                            $CALC3DAY09MINUS=$CALC3DAY09MINUS+$C3DAY09MINUS; 
                            $CALC3DAY10MINUS=$CALC3DAY10MINUS+$C3DAY10MINUS; 
                            $CALC3DAY11MINUS=$CALC3DAY11MINUS+$C3DAY11MINUS; 
                            $CALC3DAY12MINUS=$CALC3DAY12MINUS+$C3DAY12MINUS; 
                            $CALC3DAY13MINUS=$CALC3DAY13MINUS+$C3DAY13MINUS; 
                            $CALC3DAY14MINUS=$CALC3DAY14MINUS+$C3DAY14MINUS; 
                            $CALC3DAY15MINUS=$CALC3DAY15MINUS+$C3DAY15MINUS; 
                            $CALC3DAY16MINUS=$CALC3DAY16MINUS+$C3DAY16MINUS; 
                            $CALC3DAY17MINUS=$CALC3DAY17MINUS+$C3DAY17MINUS; 
                            $CALC3DAY18MINUS=$CALC3DAY18MINUS+$C3DAY18MINUS; 
                            $CALC3DAY19MINUS=$CALC3DAY19MINUS+$C3DAY19MINUS; 
                            $CALC3DAY20MINUS=$CALC3DAY20MINUS+$C3DAY20MINUS; 
                            $CALC3DAY21MINUS=$CALC3DAY21MINUS+$C3DAY21MINUS; 
                            $CALC3DAY22MINUS=$CALC3DAY22MINUS+$C3DAY22MINUS; 
                            $CALC3DAY23MINUS=$CALC3DAY23MINUS+$C3DAY23MINUS; 
                            $CALC3DAY24MINUS=$CALC3DAY24MINUS+$C3DAY24MINUS; 
                            $CALC3DAY25MINUS=$CALC3DAY25MINUS+$C3DAY25MINUS; 
                            $CALC3DAY26MINUS=$CALC3DAY26MINUS+$C3DAY26MINUS; 
                            $CALC3DAY27MINUS=$CALC3DAY27MINUS+$C3DAY27MINUS; 
                            $CALC3DAY28MINUS=$CALC3DAY28MINUS+$C3DAY28MINUS; 
                            $CALC3DAY29MINUS=$CALC3DAY29MINUS+$C3DAY29MINUS; 
                            $CALC3DAY30MINUS=$CALC3DAY30MINUS+$C3DAY30MINUS; 
                            $CALC3DAY31MINUS=$CALC3DAY31MINUS+$C3DAY31MINUS; 
                        // TOTAL
                            $CALSUMTOTALPLUS=$CALSUMTOTALPLUS+$SUMTOTALPLUS;
                            $CALSUMTOTALMINUS=$CALSUMTOTALMINUS+$SUMTOTALMINUS;
                            $CALSUMPLUSMINUS=$CALSUMPLUSMINUS+$CALPLUSMINUS;    
                        } 
                    ?> 
                    <?php
                        // BOTTOMPLUS
                            $TOTALDAY01PLUS=$CALC3DAY01PLUS;
                            $TOTALDAY02PLUS=$CALC3DAY02PLUS;
                            $TOTALDAY03PLUS=$CALC3DAY03PLUS;
                            $TOTALDAY04PLUS=$CALC3DAY04PLUS;
                            $TOTALDAY05PLUS=$CALC3DAY05PLUS;
                            $TOTALDAY06PLUS=$CALC3DAY06PLUS;
                            $TOTALDAY07PLUS=$CALC3DAY07PLUS;
                            $TOTALDAY08PLUS=$CALC3DAY08PLUS;
                            $TOTALDAY09PLUS=$CALC3DAY09PLUS;
                            $TOTALDAY10PLUS=$CALC3DAY10PLUS;
                            $TOTALDAY11PLUS=$CALC3DAY11PLUS;
                            $TOTALDAY12PLUS=$CALC3DAY12PLUS;
                            $TOTALDAY13PLUS=$CALC3DAY13PLUS;
                            $TOTALDAY14PLUS=$CALC3DAY14PLUS;
                            $TOTALDAY15PLUS=$CALC3DAY15PLUS;
                            $TOTALDAY16PLUS=$CALC3DAY16PLUS;
                            $TOTALDAY17PLUS=$CALC3DAY17PLUS;
                            $TOTALDAY18PLUS=$CALC3DAY18PLUS;
                            $TOTALDAY19PLUS=$CALC3DAY19PLUS;
                            $TOTALDAY20PLUS=$CALC3DAY20PLUS;
                            $TOTALDAY21PLUS=$CALC3DAY21PLUS;
                            $TOTALDAY22PLUS=$CALC3DAY22PLUS;
                            $TOTALDAY23PLUS=$CALC3DAY23PLUS;
                            $TOTALDAY24PLUS=$CALC3DAY24PLUS;
                            $TOTALDAY25PLUS=$CALC3DAY25PLUS;
                            $TOTALDAY26PLUS=$CALC3DAY26PLUS;
                            $TOTALDAY27PLUS=$CALC3DAY27PLUS;
                            $TOTALDAY28PLUS=$CALC3DAY28PLUS;
                            $TOTALDAY29PLUS=$CALC3DAY29PLUS;
                            $TOTALDAY30PLUS=$CALC3DAY30PLUS;
                            $TOTALDAY31PLUS=$CALC3DAY31PLUS;
                        // BOTTOMMINUS                        
                            $TOTALDAY01MINUS=$CALC3DAY01MINUS;
                            $TOTALDAY02MINUS=$CALC3DAY02MINUS;
                            $TOTALDAY03MINUS=$CALC3DAY03MINUS;
                            $TOTALDAY04MINUS=$CALC3DAY04MINUS;
                            $TOTALDAY05MINUS=$CALC3DAY05MINUS;
                            $TOTALDAY06MINUS=$CALC3DAY06MINUS;
                            $TOTALDAY07MINUS=$CALC3DAY07MINUS;
                            $TOTALDAY08MINUS=$CALC3DAY08MINUS;
                            $TOTALDAY09MINUS=$CALC3DAY09MINUS;
                            $TOTALDAY10MINUS=$CALC3DAY10MINUS;
                            $TOTALDAY11MINUS=$CALC3DAY11MINUS;
                            $TOTALDAY12MINUS=$CALC3DAY12MINUS;
                            $TOTALDAY13MINUS=$CALC3DAY13MINUS;
                            $TOTALDAY14MINUS=$CALC3DAY14MINUS;
                            $TOTALDAY15MINUS=$CALC3DAY15MINUS;
                            $TOTALDAY16MINUS=$CALC3DAY16MINUS;
                            $TOTALDAY17MINUS=$CALC3DAY17MINUS;
                            $TOTALDAY18MINUS=$CALC3DAY18MINUS;
                            $TOTALDAY19MINUS=$CALC3DAY19MINUS;
                            $TOTALDAY20MINUS=$CALC3DAY20MINUS;
                            $TOTALDAY21MINUS=$CALC3DAY21MINUS;
                            $TOTALDAY22MINUS=$CALC3DAY22MINUS;
                            $TOTALDAY23MINUS=$CALC3DAY23MINUS;
                            $TOTALDAY24MINUS=$CALC3DAY24MINUS;
                            $TOTALDAY25MINUS=$CALC3DAY25MINUS;
                            $TOTALDAY26MINUS=$CALC3DAY26MINUS;
                            $TOTALDAY27MINUS=$CALC3DAY27MINUS;
                            $TOTALDAY28MINUS=$CALC3DAY28MINUS;
                            $TOTALDAY29MINUS=$CALC3DAY29MINUS;
                            $TOTALDAY30MINUS=$CALC3DAY30MINUS;
                            $TOTALDAY31MINUS=$CALC3DAY31MINUS; 
                        // BOTTOMTOTAL             
                            $RESULTSUMTOTALPLUS=$CALSUMTOTALPLUS;
                            $RESULTSUMTOTALMINUS=$CALSUMTOTALMINUS;
                            $RESULTSUMPLUSMINUS=$CALSUMPLUSMINUS;  
                    ?>                                                     
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7" style="text-align:center;">รวม</td>
                        <td style="text-align:right;"><?php if($TOTALDAY01PLUS=="0"){echo "";}else{echo number_format($TOTALDAY01PLUS,0);};?></td>  
                        <td style="text-align:right;"><?php if($TOTALDAY01MINUS=="0"){echo "";}else{echo number_format($TOTALDAY01MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY02PLUS=="0"){echo "";}else{echo number_format($TOTALDAY02PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY02MINUS=="0"){echo "";}else{echo number_format($TOTALDAY02MINUS,0);};?></td>  
                        <td style="text-align:right;"><?php if($TOTALDAY03PLUS=="0"){echo "";}else{echo number_format($TOTALDAY03PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY03MINUS=="0"){echo "";}else{echo number_format($TOTALDAY03MINUS,0);};?></td>  
                        <td style="text-align:right;"><?php if($TOTALDAY04PLUS=="0"){echo "";}else{echo number_format($TOTALDAY04PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY04MINUS=="0"){echo "";}else{echo number_format($TOTALDAY04MINUS,0);};?></td>  
                        <td style="text-align:right;"><?php if($TOTALDAY05PLUS=="0"){echo "";}else{echo number_format($TOTALDAY05PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY05MINUS=="0"){echo "";}else{echo number_format($TOTALDAY05MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY06PLUS=="0"){echo "";}else{echo number_format($TOTALDAY06PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY06MINUS=="0"){echo "";}else{echo number_format($TOTALDAY06MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY07PLUS=="0"){echo "";}else{echo number_format($TOTALDAY07PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY07MINUS=="0"){echo "";}else{echo number_format($TOTALDAY07MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY08PLUS=="0"){echo "";}else{echo number_format($TOTALDAY08PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY08MINUS=="0"){echo "";}else{echo number_format($TOTALDAY08MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY09PLUS=="0"){echo "";}else{echo number_format($TOTALDAY09PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY09MINUS=="0"){echo "";}else{echo number_format($TOTALDAY09MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY10PLUS=="0"){echo "";}else{echo number_format($TOTALDAY10PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY10MINUS=="0"){echo "";}else{echo number_format($TOTALDAY10MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY11PLUS=="0"){echo "";}else{echo number_format($TOTALDAY11PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY11MINUS=="0"){echo "";}else{echo number_format($TOTALDAY11MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY12PLUS=="0"){echo "";}else{echo number_format($TOTALDAY12PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY12MINUS=="0"){echo "";}else{echo number_format($TOTALDAY12MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY13PLUS=="0"){echo "";}else{echo number_format($TOTALDAY13PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY13MINUS=="0"){echo "";}else{echo number_format($TOTALDAY13MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY14PLUS=="0"){echo "";}else{echo number_format($TOTALDAY14PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY14MINUS=="0"){echo "";}else{echo number_format($TOTALDAY14MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY15PLUS=="0"){echo "";}else{echo number_format($TOTALDAY15PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY15MINUS=="0"){echo "";}else{echo number_format($TOTALDAY15MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY16PLUS=="0"){echo "";}else{echo number_format($TOTALDAY16PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY16MINUS=="0"){echo "";}else{echo number_format($TOTALDAY16MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY17PLUS=="0"){echo "";}else{echo number_format($TOTALDAY17PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY17MINUS=="0"){echo "";}else{echo number_format($TOTALDAY17MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY18PLUS=="0"){echo "";}else{echo number_format($TOTALDAY18PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY18MINUS=="0"){echo "";}else{echo number_format($TOTALDAY18MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY19PLUS=="0"){echo "";}else{echo number_format($TOTALDAY19PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY19MINUS=="0"){echo "";}else{echo number_format($TOTALDAY19MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY20PLUS=="0"){echo "";}else{echo number_format($TOTALDAY20PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY20MINUS=="0"){echo "";}else{echo number_format($TOTALDAY20MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY21PLUS=="0"){echo "";}else{echo number_format($TOTALDAY21PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY21MINUS=="0"){echo "";}else{echo number_format($TOTALDAY21MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY22PLUS=="0"){echo "";}else{echo number_format($TOTALDAY22PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY22MINUS=="0"){echo "";}else{echo number_format($TOTALDAY22MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY23PLUS=="0"){echo "";}else{echo number_format($TOTALDAY23PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY23MINUS=="0"){echo "";}else{echo number_format($TOTALDAY23MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY24PLUS=="0"){echo "";}else{echo number_format($TOTALDAY24PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY24MINUS=="0"){echo "";}else{echo number_format($TOTALDAY24MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY25PLUS=="0"){echo "";}else{echo number_format($TOTALDAY25PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY25MINUS=="0"){echo "";}else{echo number_format($TOTALDAY25MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY26PLUS=="0"){echo "";}else{echo number_format($TOTALDAY26PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY26MINUS=="0"){echo "";}else{echo number_format($TOTALDAY26MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY27PLUS=="0"){echo "";}else{echo number_format($TOTALDAY27PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY27MINUS=="0"){echo "";}else{echo number_format($TOTALDAY27MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY28PLUS=="0"){echo "";}else{echo number_format($TOTALDAY28PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY28MINUS=="0"){echo "";}else{echo number_format($TOTALDAY28MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY29PLUS=="0"){echo "";}else{echo number_format($TOTALDAY29PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY29MINUS=="0"){echo "";}else{echo number_format($TOTALDAY29MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY30PLUS=="0"){echo "";}else{echo number_format($TOTALDAY30PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY30MINUS=="0"){echo "";}else{echo number_format($TOTALDAY30MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($TOTALDAY31PLUS=="0"){echo "";}else{echo number_format($TOTALDAY31PLUS,0);};?></td>   
                        <td style="text-align:right;"><?php if($TOTALDAY31MINUS=="0"){echo "";}else{echo number_format($TOTALDAY31MINUS,0);};?></td> 
                        <td style="text-align:right;"><?php if($RESULTSUMTOTALPLUS=="0"){echo "";}else{echo number_format($RESULTSUMTOTALPLUS,0);};?></td>  
                        <td style="text-align:right;"><font color="red"><?php if($RESULTSUMTOTALMINUS=="0"){echo "";}else{echo number_format($RESULTSUMTOTALMINUS,0);};?></font></td>   
                        <td style="text-align:right;"><?php if($RESULTSUMPLUSMINUS=="0"){echo "";}else{echo number_format($RESULTSUMPLUSMINUS,0);};?></td>  
                        <td style="text-align:right;"></td>  
                    </tr>    
                    <tr>
                        <td colspan="7" style="text-align:center;">ยอดรวมทั้งสิ้น</td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY01CALPLUSMINUS=$TOTALDAY01PLUS+$TOTALDAY01MINUS; if($CALTOTALDAY01CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY01CALPLUSMINUS, 0);};?></td>  
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY02CALPLUSMINUS=$TOTALDAY02PLUS+$TOTALDAY02MINUS; if($CALTOTALDAY02CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY02CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY03CALPLUSMINUS=$TOTALDAY03PLUS+$TOTALDAY03MINUS; if($CALTOTALDAY03CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY03CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY04CALPLUSMINUS=$TOTALDAY04PLUS+$TOTALDAY04MINUS; if($CALTOTALDAY04CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY04CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY05CALPLUSMINUS=$TOTALDAY05PLUS+$TOTALDAY05MINUS; if($CALTOTALDAY05CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY05CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY06CALPLUSMINUS=$TOTALDAY06PLUS+$TOTALDAY06MINUS; if($CALTOTALDAY06CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY06CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY07CALPLUSMINUS=$TOTALDAY07PLUS+$TOTALDAY07MINUS; if($CALTOTALDAY07CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY07CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY08CALPLUSMINUS=$TOTALDAY08PLUS+$TOTALDAY08MINUS; if($CALTOTALDAY08CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY08CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY09CALPLUSMINUS=$TOTALDAY09PLUS+$TOTALDAY09MINUS; if($CALTOTALDAY09CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY09CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY10CALPLUSMINUS=$TOTALDAY10PLUS+$TOTALDAY10MINUS; if($CALTOTALDAY10CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY10CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY11CALPLUSMINUS=$TOTALDAY11PLUS+$TOTALDAY11MINUS; if($CALTOTALDAY11CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY11CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY12CALPLUSMINUS=$TOTALDAY12PLUS+$TOTALDAY12MINUS; if($CALTOTALDAY12CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY12CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY13CALPLUSMINUS=$TOTALDAY13PLUS+$TOTALDAY13MINUS; if($CALTOTALDAY13CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY13CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY14CALPLUSMINUS=$TOTALDAY14PLUS+$TOTALDAY14MINUS; if($CALTOTALDAY14CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY14CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY15CALPLUSMINUS=$TOTALDAY15PLUS+$TOTALDAY15MINUS; if($CALTOTALDAY15CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY15CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY16CALPLUSMINUS=$TOTALDAY16PLUS+$TOTALDAY16MINUS; if($CALTOTALDAY16CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY16CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY17CALPLUSMINUS=$TOTALDAY17PLUS+$TOTALDAY17MINUS; if($CALTOTALDAY17CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY17CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY18CALPLUSMINUS=$TOTALDAY18PLUS+$TOTALDAY18MINUS; if($CALTOTALDAY18CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY18CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY19CALPLUSMINUS=$TOTALDAY19PLUS+$TOTALDAY19MINUS; if($CALTOTALDAY19CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY19CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY20CALPLUSMINUS=$TOTALDAY20PLUS+$TOTALDAY20MINUS; if($CALTOTALDAY20CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY20CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY21CALPLUSMINUS=$TOTALDAY21PLUS+$TOTALDAY21MINUS; if($CALTOTALDAY21CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY21CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY22CALPLUSMINUS=$TOTALDAY22PLUS+$TOTALDAY22MINUS; if($CALTOTALDAY22CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY22CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY23CALPLUSMINUS=$TOTALDAY23PLUS+$TOTALDAY23MINUS; if($CALTOTALDAY23CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY23CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY24CALPLUSMINUS=$TOTALDAY24PLUS+$TOTALDAY24MINUS; if($CALTOTALDAY24CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY24CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY25CALPLUSMINUS=$TOTALDAY25PLUS+$TOTALDAY25MINUS; if($CALTOTALDAY25CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY25CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY26CALPLUSMINUS=$TOTALDAY26PLUS+$TOTALDAY26MINUS; if($CALTOTALDAY26CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY26CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY27CALPLUSMINUS=$TOTALDAY27PLUS+$TOTALDAY27MINUS; if($CALTOTALDAY27CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY27CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY28CALPLUSMINUS=$TOTALDAY28PLUS+$TOTALDAY28MINUS; if($CALTOTALDAY28CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY28CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY29CALPLUSMINUS=$TOTALDAY29PLUS+$TOTALDAY29MINUS; if($CALTOTALDAY29CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY29CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY30CALPLUSMINUS=$TOTALDAY30PLUS+$TOTALDAY30MINUS; if($CALTOTALDAY30CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY30CALPLUSMINUS, 0);};?></td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALDAY31CALPLUSMINUS=$TOTALDAY31PLUS+$TOTALDAY31MINUS; if($CALTOTALDAY31CALPLUSMINUS=="0"){echo "";}else{echo number_format($CALTOTALDAY31CALPLUSMINUS, 0);};?></td> 
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALRESULTSUMTOTAL=$RESULTSUMTOTALPLUS+$RESULTSUMTOTALMINUS; if($CALTOTALRESULTSUMTOTAL=="0"){echo "";}else{echo number_format($CALTOTALRESULTSUMTOTAL, 0);};?></td> 
                        <td style="text-align:right;"><?php if($RESULTSUMPLUSMINUS=="0"){echo "";}else{echo number_format($RESULTSUMPLUSMINUS, 0);};?></td>  
                        <td style="text-align:right;"></td>  
                    </tr>            
                </tfoot>
            </table>     
        </section>
        <!-- /.content -->
    </div>
<?php }else if($EXCELMONTH != "") {  ?>
    <?php
        $RENAME= "สรุปค่าเฉลี่ยน้ำมันเดือน $startm $starty";
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$RENAME.xls");
        header("Pragma: no-cache");
        header("Expires: ");
    ?>       
    <div class="wrapper">
        <section class="invoice">
            <table>
                <thead>
                    <tr border="0">
                        <th colspan="9" style="background-color: #fff"><div align="left"><b>สรุปค่าเฉลี่ยน้ำมันเดือน <?=$startm.' '.$starty;?></b></div></th>
                        <th colspan="2" style="background-color: #fff"><div align="right"><b>สายงาน <?=$SHOW?></b> </div></th>
                    </tr>
                </thead>
            </table>                
            <table id="NoExtention1" class="table table-bordered " style="font-size: 13px;" border="1" width="100%">
                <thead>
                    <tr>
                        <th rowspan="2" style="background-color: #fff"><div align="center">ลำดับ</div></th>
                        <th rowspan="2" style="background-color: #fff"><div align="center">รหัส</div></th>
                        <th rowspan="2" style="background-color: #fff"><div align="center">ชื่อ-สกุล</div></th>
                        <th rowspan="2" style="background-color: #fff"><div align="center">จำนวนเที่ยว</div></th>
                        <th rowspan="2" style="background-color: #fff"><div align="center">กิโลเมตร</div></th>
                        <th rowspan="2" style="background-color: #fff"><div align="center">KM/Trip</div></th>
                        <th rowspan="2" style="background-color: #fff"><div align="center">สายงาน</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #fff"><div align="center">รวมสุทธิ</div></th>
                        <th rowspan="2" style="background-color: #fff"><div align="center">ยอดที่จ่ายจริง</div></th>
                        <th rowspan="2" style="background-color: #fff"><div align="center">สาเหตุ</div></th>
                    </tr>
                    <tr>
                        <th colspan="1" style="background-color: #fff"><div align="center">เงินบวก</div></th>
                        <th colspan="1" style="background-color: #fff"><div align="center"><font color="red">เงินลบ</font></div></th>
                    </tr>
                </thead>
                <tbody>
                    <?php                    
                        // $SQLEMP = "SELECT DISTINCT EHR.PersonCode EMPC,EHR.Company_Code,EHR.Company_NameT,EHR.PositionNameT POS,EHR.FnameT,EHR.LnameT,EHR.nameT EMPN 
                        // FROM EMPLOYEEEHR2 EHR WHERE $QUERYWHERE1";                                             
                        // $QUERYEMP = sqlsrv_query($conn, $SQLEMP );
                        // $resultid = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
                        // $result = sqlsrv_query($conn, $SQLEMP ); 
                        $SQLEMP = "SELECT DISTINCT EHR.PersonCode EMPC,EHR.Company_Code,EHR.Company_NameT,EHR.PositionNameT POS,EHR.FnameT,EHR.LnameT,EHR.nameT EMPN 
                        FROM EMPLOYEEEHR2 EHR WHERE $QUERYWHERE1 
                        UNION
                        SELECT DISTINCT EHR.PersonCode EMPC,EHR.Company_Code,EHR.Company_NameT,EHR.PositionNameT POS,EHR.FnameT,EHR.LnameT,EHR.nameT EMPN 
                        FROM VEHICLETRANSPORTPLAN VHCTPP 
                        LEFT JOIN EMPLOYEEEHR2 EHR ON (VHCTPP.EMPLOYEECODE1 = EHR.PersonCode OR VHCTPP.EMPLOYEECODE2 = EHR.PersonCode)
                        WHERE NOT (EHR.PositionNameT LIKE '%ปลอกเขียว%' OR EHR.PositionNameT LIKE '%ปลอกเหลือง%') AND VHCTPP.O4 IS NOT NULL
                        AND CONVERT (VARCHAR (10),VHCTPP.DATEWORKING,20) BETWEEN '$start[2]-$start[1]-01' AND '$end[2]-$end[1]-31' AND NOT EHR.Company_Code IN('RKR','RKL','RKS')
                        AND $QUERYWHERE2 
                        AND $QUERYWHERE3";  
                        $QUERYEMP = sqlsrv_query($conn, $SQLEMP );
                        $i = 1;
                        while($RESULTEMP = sqlsrv_fetch_array($QUERYEMP)) {    
                        $EMPC=$RESULTEMP["EMPC"];           
                        $EMPN=$RESULTEMP["EMPN"];  
                        $POS=$RESULTEMP["POS"];       
                            if($LINEOFWORK == 'OTHER'){ 
                                $RSPOS2 = $POS;     
                            }else{                  
                                $POSSPLIT = explode("/", $POS);
                                $RSPOS1 = $POSSPLIT[0];
                                $RSPOS2 = $POSSPLIT[1];
                            }

                        $SQLROUND="SELECT COUNT(VHCTPP.EMPLOYEECODE1) AS ROUND FROM VEHICLETRANSPORTPLAN VHCTPP 
                        WHERE (VHCTPP.EMPLOYEECODE1 = '$EMPC' OR VHCTPP.EMPLOYEECODE2 = '$EMPC') 
                        AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) BETWEEN '$start[2]-$start[1]-01' AND '$end[2]-$end[1]-31'";
                        $QUERYROUND = sqlsrv_query($conn, $SQLROUND ); 
                        $RESULTROUND = sqlsrv_fetch_array($QUERYROUND, SQLSRV_FETCH_ASSOC);
                        $ROUND=$RESULTROUND["ROUND"];

                        $SQLDTE="SELECT SUM	( ISNULL( CAST ( OTSNDTE.DISTANCE AS DECIMAL ( 6, 2 ) ), 0 ) ) AS RSDTE FROM VEHICLETRANSPORTPLAN VHCTPPDTE
                        LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSNDTE ON VHCTPPDTE.JOBNO = OTSNDTE.JOBNO COLLATE Thai_CI_AI
                        WHERE (VHCTPPDTE.EMPLOYEECODE1 = '$EMPC' OR VHCTPPDTE.EMPLOYEECODE2 = '$EMPC') AND VHCTPPDTE.C3 IS NOT NULL 
                        AND CONVERT ( VARCHAR ( 10 ), VHCTPPDTE.DATEWORKING, 20 ) BETWEEN '$start[2]-$start[1]-01' AND '$end[2]-$end[1]-31'";
                        $QUERYDTE = sqlsrv_query($conn, $SQLDTE ); 
                        $RESULTDTE = sqlsrv_fetch_array($QUERYDTE, SQLSRV_FETCH_ASSOC);
                        $RSDTE=$RESULTDTE["RSDTE"]; 
                        
                        $SQLRDAY="SELECT DISTINCT A.PersonCode, 		
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-01') AS C3DAY01PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-01') AS C3DAY01MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-02') AS C3DAY02PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-02') AS C3DAY02MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-03') AS C3DAY03PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-03') AS C3DAY03MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-04') AS C3DAY04PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-04') AS C3DAY04MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-05') AS C3DAY05PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-05') AS C3DAY05MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-06') AS C3DAY06PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-06') AS C3DAY06MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-07') AS C3DAY07PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-07') AS C3DAY07MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-08') AS C3DAY08PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-08') AS C3DAY08MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-09') AS C3DAY09PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-09') AS C3DAY09MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-10') AS C3DAY10PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-10') AS C3DAY10MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-11') AS C3DAY11PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-11') AS C3DAY11MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-12') AS C3DAY12PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-12') AS C3DAY12MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-13') AS C3DAY13PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-13') AS C3DAY13MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-14') AS C3DAY14PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-14') AS C3DAY14MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-15') AS C3DAY15PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-15') AS C3DAY15MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-16') AS C3DAY16PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-16') AS C3DAY16MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-17') AS C3DAY17PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-17') AS C3DAY17MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-18') AS C3DAY18PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-18') AS C3DAY18MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-19') AS C3DAY19PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-19') AS C3DAY19MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-20') AS C3DAY20PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-20') AS C3DAY20MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-21') AS C3DAY21PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-21') AS C3DAY21MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-22') AS C3DAY22PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-22') AS C3DAY22MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-23') AS C3DAY23PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-23') AS C3DAY23MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-24') AS C3DAY24PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-24') AS C3DAY24MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-25') AS C3DAY25PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-25') AS C3DAY25MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-26') AS C3DAY26PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-26') AS C3DAY26MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-27') AS C3DAY27PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-27') AS C3DAY27MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-28') AS C3DAY28PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-28') AS C3DAY28MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-29') AS C3DAY29PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-29') AS C3DAY29MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-30') AS C3DAY30PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-30') AS C3DAY30MINUS,
                            (SELECT SUM(ISNULL(CAST(C3PLUS AS DECIMAL(6,0)),0)) C3PLUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3PLUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-31') AS C3DAY31PLUS,
                            (SELECT SUM(ISNULL(CAST(C3MINUS AS DECIMAL(6,0)),0)) C3MINUS FROM TEMP_RPAVGDAY_GW WHERE PersonCode = A.PersonCode AND $FINECUSTOMER AND C3MINUS IS NOT NULL AND CONVERT ( VARCHAR ( 10 ), DATEWORKING, 20 ) = '$start[2]-$start[1]-31') AS C3DAY31MINUS
                            FROM TEMP_RPAVGDAY_GW A WHERE A.PersonCode = '$EMPC'";
                        $QUERYRDAY = sqlsrv_query($conn, $SQLRDAY ); 
                        $RESULTRDAY = sqlsrv_fetch_array($QUERYRDAY, SQLSRV_FETCH_ASSOC);
                            $C3DAY01PLUS=$RESULTRDAY["C3DAY01PLUS"];  /** ------- **/ $C3DAY01MINUS=$RESULTRDAY["C3DAY01MINUS"]; 
                            $C3DAY02PLUS=$RESULTRDAY["C3DAY02PLUS"];  /** ------- **/ $C3DAY02MINUS=$RESULTRDAY["C3DAY02MINUS"]; 
                            $C3DAY03PLUS=$RESULTRDAY["C3DAY03PLUS"];  /** ------- **/ $C3DAY03MINUS=$RESULTRDAY["C3DAY03MINUS"]; 
                            $C3DAY04PLUS=$RESULTRDAY["C3DAY04PLUS"];  /** ------- **/ $C3DAY04MINUS=$RESULTRDAY["C3DAY04MINUS"]; 
                            $C3DAY05PLUS=$RESULTRDAY["C3DAY05PLUS"];  /** ------- **/ $C3DAY05MINUS=$RESULTRDAY["C3DAY05MINUS"]; 
                            $C3DAY06PLUS=$RESULTRDAY["C3DAY06PLUS"];  /** ------- **/ $C3DAY06MINUS=$RESULTRDAY["C3DAY06MINUS"]; 
                            $C3DAY07PLUS=$RESULTRDAY["C3DAY07PLUS"];  /** ------- **/ $C3DAY07MINUS=$RESULTRDAY["C3DAY07MINUS"]; 
                            $C3DAY08PLUS=$RESULTRDAY["C3DAY08PLUS"];  /** ------- **/ $C3DAY08MINUS=$RESULTRDAY["C3DAY08MINUS"]; 
                            $C3DAY09PLUS=$RESULTRDAY["C3DAY09PLUS"];  /** ------- **/ $C3DAY09MINUS=$RESULTRDAY["C3DAY09MINUS"]; 
                            $C3DAY10PLUS=$RESULTRDAY["C3DAY10PLUS"];  /** ------- **/ $C3DAY10MINUS=$RESULTRDAY["C3DAY10MINUS"]; 
                            $C3DAY11PLUS=$RESULTRDAY["C3DAY11PLUS"];  /** ------- **/ $C3DAY11MINUS=$RESULTRDAY["C3DAY11MINUS"]; 
                            $C3DAY12PLUS=$RESULTRDAY["C3DAY12PLUS"];  /** ------- **/ $C3DAY12MINUS=$RESULTRDAY["C3DAY12MINUS"]; 
                            $C3DAY13PLUS=$RESULTRDAY["C3DAY13PLUS"];  /** ------- **/ $C3DAY13MINUS=$RESULTRDAY["C3DAY13MINUS"]; 
                            $C3DAY14PLUS=$RESULTRDAY["C3DAY14PLUS"];  /** ------- **/ $C3DAY14MINUS=$RESULTRDAY["C3DAY14MINUS"]; 
                            $C3DAY15PLUS=$RESULTRDAY["C3DAY15PLUS"];  /** ------- **/ $C3DAY15MINUS=$RESULTRDAY["C3DAY15MINUS"]; 
                            $C3DAY16PLUS=$RESULTRDAY["C3DAY16PLUS"];  /** ------- **/ $C3DAY16MINUS=$RESULTRDAY["C3DAY16MINUS"]; 
                            $C3DAY17PLUS=$RESULTRDAY["C3DAY17PLUS"];  /** ------- **/ $C3DAY17MINUS=$RESULTRDAY["C3DAY17MINUS"]; 
                            $C3DAY18PLUS=$RESULTRDAY["C3DAY18PLUS"];  /** ------- **/ $C3DAY18MINUS=$RESULTRDAY["C3DAY18MINUS"]; 
                            $C3DAY19PLUS=$RESULTRDAY["C3DAY19PLUS"];  /** ------- **/ $C3DAY19MINUS=$RESULTRDAY["C3DAY19MINUS"]; 
                            $C3DAY20PLUS=$RESULTRDAY["C3DAY20PLUS"];  /** ------- **/ $C3DAY20MINUS=$RESULTRDAY["C3DAY20MINUS"]; 
                            $C3DAY21PLUS=$RESULTRDAY["C3DAY21PLUS"];  /** ------- **/ $C3DAY21MINUS=$RESULTRDAY["C3DAY21MINUS"]; 
                            $C3DAY22PLUS=$RESULTRDAY["C3DAY22PLUS"];  /** ------- **/ $C3DAY22MINUS=$RESULTRDAY["C3DAY22MINUS"]; 
                            $C3DAY23PLUS=$RESULTRDAY["C3DAY23PLUS"];  /** ------- **/ $C3DAY23MINUS=$RESULTRDAY["C3DAY23MINUS"]; 
                            $C3DAY24PLUS=$RESULTRDAY["C3DAY24PLUS"];  /** ------- **/ $C3DAY24MINUS=$RESULTRDAY["C3DAY24MINUS"]; 
                            $C3DAY25PLUS=$RESULTRDAY["C3DAY25PLUS"];  /** ------- **/ $C3DAY25MINUS=$RESULTRDAY["C3DAY25MINUS"]; 
                            $C3DAY26PLUS=$RESULTRDAY["C3DAY26PLUS"];  /** ------- **/ $C3DAY26MINUS=$RESULTRDAY["C3DAY26MINUS"]; 
                            $C3DAY27PLUS=$RESULTRDAY["C3DAY27PLUS"];  /** ------- **/ $C3DAY27MINUS=$RESULTRDAY["C3DAY27MINUS"]; 
                            $C3DAY28PLUS=$RESULTRDAY["C3DAY28PLUS"];  /** ------- **/ $C3DAY28MINUS=$RESULTRDAY["C3DAY28MINUS"]; 
                            $C3DAY29PLUS=$RESULTRDAY["C3DAY29PLUS"];  /** ------- **/ $C3DAY29MINUS=$RESULTRDAY["C3DAY29MINUS"]; 
                            $C3DAY30PLUS=$RESULTRDAY["C3DAY30PLUS"];  /** ------- **/ $C3DAY30MINUS=$RESULTRDAY["C3DAY30MINUS"]; 
                            $C3DAY31PLUS=$RESULTRDAY["C3DAY31PLUS"];  /** ------- **/ $C3DAY31MINUS=$RESULTRDAY["C3DAY31MINUS"]; 
                        
                        
                    ?>
                        <tr>
                            <td align="center"><?=$i;?></td>
                            <td align="center"><?=$EMPC;?></td>
                            <td align="left"><?=$EMPN;?></td>
                            <td align="center"><?php if(($ROUND=="0")||($ROUND=="")){$RSROUND="0";echo "0";}else{echo number_format($ROUND, 0); };?></td>
                            <td align="center"><?php if(($RSDTE=="0")||($RSDTE=="")){$RSSUMDTE="0";echo "0";}else{echo number_format($RSDTE, 0); }; ?></td>
                            <td align="center"><?php if(($ROUND=="0")||($RSDTE=="0")){$KMTRIP="0";}else{$KMTRIP=$RSDTE/$ROUND;} ?><?php if(($KMTRIP=="0")||($KMTRIP=="")){echo "0";}else{echo number_format($KMTRIP, 0); };?></td>                             <td align="center"><?=$RSPOS2;?></td>
                            <td align="right"><?php $SUMTOTALPLUS=$C3DAY01PLUS+$C3DAY02PLUS+$C3DAY03PLUS+$C3DAY04PLUS+$C3DAY05PLUS+$C3DAY06PLUS+$C3DAY07PLUS+$C3DAY08PLUS+$C3DAY09PLUS+$C3DAY10PLUS+
                                                $C3DAY11PLUS+$C3DAY12PLUS+$C3DAY13PLUS+$C3DAY14PLUS+$C3DAY15PLUS+$C3DAY16PLUS+$C3DAY17PLUS+$C3DAY18PLUS+$C3DAY19PLUS+$C3DAY20PLUS+$C3DAY21PLUS+
                                                $C3DAY22PLUS+$C3DAY23PLUS+$C3DAY24PLUS+$C3DAY25PLUS+$C3DAY26PLUS+$C3DAY27PLUS+$C3DAY28PLUS+$C3DAY29PLUS+$C3DAY30PLUS+$C3DAY31PLUS;?>
                                                <?php echo number_format($SUMTOTALPLUS, 0); ?></td>
                            <td align="right"><font color="red"><?php $SUMTOTALMINUS=$C3DAY01MINUS+$C3DAY02MINUS+$C3DAY03MINUS+$C3DAY04MINUS+$C3DAY05MINUS+$C3DAY06MINUS+$C3DAY07MINUS+$C3DAY08MINUS+$C3DAY09MINUS+$C3DAY10MINUS+
                                                $C3DAY11MINUS+$C3DAY12MINUS+$C3DAY13MINUS+$C3DAY14MINUS+$C3DAY15MINUS+$C3DAY16MINUS+$C3DAY17MINUS+$C3DAY18MINUS+$C3DAY19MINUS+$C3DAY20MINUS+$C3DAY21MINUS+
                                                $C3DAY22MINUS+$C3DAY23MINUS+$C3DAY24MINUS+$C3DAY25MINUS+$C3DAY26MINUS+$C3DAY27MINUS+$C3DAY28MINUS+$C3DAY29MINUS+$C3DAY30MINUS+$C3DAY31MINUS;?>
                                                <?php echo number_format($SUMTOTALMINUS, 0); ?></font></td>
                            <td align="right"><?php $CALPLUSMINUS=$SUMTOTALPLUS+$SUMTOTALMINUS; echo number_format($CALPLUSMINUS, 0); ?></td>
                            <td align="right"></td>
                        </tr>    
                    <?php $i++;    
                        // PLUS   
                            $CALC3DAY01PLUS=$CALC3DAY01PLUS+$C3DAY01PLUS; 
                            $CALC3DAY02PLUS=$CALC3DAY02PLUS+$C3DAY02PLUS; 
                            $CALC3DAY03PLUS=$CALC3DAY03PLUS+$C3DAY03PLUS; 
                            $CALC3DAY04PLUS=$CALC3DAY04PLUS+$C3DAY04PLUS; 
                            $CALC3DAY05PLUS=$CALC3DAY05PLUS+$C3DAY05PLUS; 
                            $CALC3DAY06PLUS=$CALC3DAY06PLUS+$C3DAY06PLUS; 
                            $CALC3DAY07PLUS=$CALC3DAY07PLUS+$C3DAY07PLUS; 
                            $CALC3DAY08PLUS=$CALC3DAY08PLUS+$C3DAY08PLUS; 
                            $CALC3DAY09PLUS=$CALC3DAY09PLUS+$C3DAY09PLUS; 
                            $CALC3DAY10PLUS=$CALC3DAY10PLUS+$C3DAY10PLUS; 
                            $CALC3DAY11PLUS=$CALC3DAY11PLUS+$C3DAY11PLUS; 
                            $CALC3DAY12PLUS=$CALC3DAY12PLUS+$C3DAY12PLUS; 
                            $CALC3DAY13PLUS=$CALC3DAY13PLUS+$C3DAY13PLUS; 
                            $CALC3DAY14PLUS=$CALC3DAY14PLUS+$C3DAY14PLUS; 
                            $CALC3DAY15PLUS=$CALC3DAY15PLUS+$C3DAY15PLUS; 
                            $CALC3DAY16PLUS=$CALC3DAY16PLUS+$C3DAY16PLUS; 
                            $CALC3DAY17PLUS=$CALC3DAY17PLUS+$C3DAY17PLUS; 
                            $CALC3DAY18PLUS=$CALC3DAY18PLUS+$C3DAY18PLUS; 
                            $CALC3DAY19PLUS=$CALC3DAY19PLUS+$C3DAY19PLUS; 
                            $CALC3DAY20PLUS=$CALC3DAY20PLUS+$C3DAY20PLUS; 
                            $CALC3DAY21PLUS=$CALC3DAY21PLUS+$C3DAY21PLUS; 
                            $CALC3DAY22PLUS=$CALC3DAY22PLUS+$C3DAY22PLUS; 
                            $CALC3DAY23PLUS=$CALC3DAY23PLUS+$C3DAY23PLUS; 
                            $CALC3DAY24PLUS=$CALC3DAY24PLUS+$C3DAY24PLUS; 
                            $CALC3DAY25PLUS=$CALC3DAY25PLUS+$C3DAY25PLUS; 
                            $CALC3DAY26PLUS=$CALC3DAY26PLUS+$C3DAY26PLUS; 
                            $CALC3DAY27PLUS=$CALC3DAY27PLUS+$C3DAY27PLUS; 
                            $CALC3DAY28PLUS=$CALC3DAY28PLUS+$C3DAY28PLUS; 
                            $CALC3DAY29PLUS=$CALC3DAY29PLUS+$C3DAY29PLUS; 
                            $CALC3DAY30PLUS=$CALC3DAY30PLUS+$C3DAY30PLUS; 
                            $CALC3DAY31PLUS=$CALC3DAY31PLUS+$C3DAY31PLUS;                              
                        // MINUS
                            $CALC3DAY01MINUS=$CALC3DAY01MINUS+$C3DAY01MINUS; 
                            $CALC3DAY02MINUS=$CALC3DAY02MINUS+$C3DAY02MINUS; 
                            $CALC3DAY03MINUS=$CALC3DAY03MINUS+$C3DAY03MINUS; 
                            $CALC3DAY04MINUS=$CALC3DAY04MINUS+$C3DAY04MINUS; 
                            $CALC3DAY05MINUS=$CALC3DAY05MINUS+$C3DAY05MINUS; 
                            $CALC3DAY06MINUS=$CALC3DAY06MINUS+$C3DAY06MINUS; 
                            $CALC3DAY07MINUS=$CALC3DAY07MINUS+$C3DAY07MINUS; 
                            $CALC3DAY08MINUS=$CALC3DAY08MINUS+$C3DAY08MINUS; 
                            $CALC3DAY09MINUS=$CALC3DAY09MINUS+$C3DAY09MINUS; 
                            $CALC3DAY10MINUS=$CALC3DAY10MINUS+$C3DAY10MINUS; 
                            $CALC3DAY11MINUS=$CALC3DAY11MINUS+$C3DAY11MINUS; 
                            $CALC3DAY12MINUS=$CALC3DAY12MINUS+$C3DAY12MINUS; 
                            $CALC3DAY13MINUS=$CALC3DAY13MINUS+$C3DAY13MINUS; 
                            $CALC3DAY14MINUS=$CALC3DAY14MINUS+$C3DAY14MINUS; 
                            $CALC3DAY15MINUS=$CALC3DAY15MINUS+$C3DAY15MINUS; 
                            $CALC3DAY16MINUS=$CALC3DAY16MINUS+$C3DAY16MINUS; 
                            $CALC3DAY17MINUS=$CALC3DAY17MINUS+$C3DAY17MINUS; 
                            $CALC3DAY18MINUS=$CALC3DAY18MINUS+$C3DAY18MINUS; 
                            $CALC3DAY19MINUS=$CALC3DAY19MINUS+$C3DAY19MINUS; 
                            $CALC3DAY20MINUS=$CALC3DAY20MINUS+$C3DAY20MINUS; 
                            $CALC3DAY21MINUS=$CALC3DAY21MINUS+$C3DAY21MINUS; 
                            $CALC3DAY22MINUS=$CALC3DAY22MINUS+$C3DAY22MINUS; 
                            $CALC3DAY23MINUS=$CALC3DAY23MINUS+$C3DAY23MINUS; 
                            $CALC3DAY24MINUS=$CALC3DAY24MINUS+$C3DAY24MINUS; 
                            $CALC3DAY25MINUS=$CALC3DAY25MINUS+$C3DAY25MINUS; 
                            $CALC3DAY26MINUS=$CALC3DAY26MINUS+$C3DAY26MINUS; 
                            $CALC3DAY27MINUS=$CALC3DAY27MINUS+$C3DAY27MINUS; 
                            $CALC3DAY28MINUS=$CALC3DAY28MINUS+$C3DAY28MINUS; 
                            $CALC3DAY29MINUS=$CALC3DAY29MINUS+$C3DAY29MINUS; 
                            $CALC3DAY30MINUS=$CALC3DAY30MINUS+$C3DAY30MINUS; 
                            $CALC3DAY31MINUS=$CALC3DAY31MINUS+$C3DAY31MINUS; 
                        // TOTAL
                            $CALSUMTOTALPLUS=$CALSUMTOTALPLUS+$SUMTOTALPLUS;
                            $CALSUMTOTALMINUS=$CALSUMTOTALMINUS+$SUMTOTALMINUS;
                            $CALSUMPLUSMINUS=$CALSUMPLUSMINUS+$CALPLUSMINUS;    
                        } 
                    ?> 
                    <?php
                        // BOTTOMPLUS
                            $TOTALDAY01PLUS=$CALC3DAY01PLUS;
                            $TOTALDAY02PLUS=$CALC3DAY02PLUS;
                            $TOTALDAY03PLUS=$CALC3DAY03PLUS;
                            $TOTALDAY04PLUS=$CALC3DAY04PLUS;
                            $TOTALDAY05PLUS=$CALC3DAY05PLUS;
                            $TOTALDAY06PLUS=$CALC3DAY06PLUS;
                            $TOTALDAY07PLUS=$CALC3DAY07PLUS;
                            $TOTALDAY08PLUS=$CALC3DAY08PLUS;
                            $TOTALDAY09PLUS=$CALC3DAY09PLUS;
                            $TOTALDAY10PLUS=$CALC3DAY10PLUS;
                            $TOTALDAY11PLUS=$CALC3DAY11PLUS;
                            $TOTALDAY12PLUS=$CALC3DAY12PLUS;
                            $TOTALDAY13PLUS=$CALC3DAY13PLUS;
                            $TOTALDAY14PLUS=$CALC3DAY14PLUS;
                            $TOTALDAY15PLUS=$CALC3DAY15PLUS;
                            $TOTALDAY16PLUS=$CALC3DAY16PLUS;
                            $TOTALDAY17PLUS=$CALC3DAY17PLUS;
                            $TOTALDAY18PLUS=$CALC3DAY18PLUS;
                            $TOTALDAY19PLUS=$CALC3DAY19PLUS;
                            $TOTALDAY20PLUS=$CALC3DAY20PLUS;
                            $TOTALDAY21PLUS=$CALC3DAY21PLUS;
                            $TOTALDAY22PLUS=$CALC3DAY22PLUS;
                            $TOTALDAY23PLUS=$CALC3DAY23PLUS;
                            $TOTALDAY24PLUS=$CALC3DAY24PLUS;
                            $TOTALDAY25PLUS=$CALC3DAY25PLUS;
                            $TOTALDAY26PLUS=$CALC3DAY26PLUS;
                            $TOTALDAY27PLUS=$CALC3DAY27PLUS;
                            $TOTALDAY28PLUS=$CALC3DAY28PLUS;
                            $TOTALDAY29PLUS=$CALC3DAY29PLUS;
                            $TOTALDAY30PLUS=$CALC3DAY30PLUS;
                            $TOTALDAY31PLUS=$CALC3DAY31PLUS;
                        // BOTTOMMINUS                        
                            $TOTALDAY01MINUS=$CALC3DAY01MINUS;
                            $TOTALDAY02MINUS=$CALC3DAY02MINUS;
                            $TOTALDAY03MINUS=$CALC3DAY03MINUS;
                            $TOTALDAY04MINUS=$CALC3DAY04MINUS;
                            $TOTALDAY05MINUS=$CALC3DAY05MINUS;
                            $TOTALDAY06MINUS=$CALC3DAY06MINUS;
                            $TOTALDAY07MINUS=$CALC3DAY07MINUS;
                            $TOTALDAY08MINUS=$CALC3DAY08MINUS;
                            $TOTALDAY09MINUS=$CALC3DAY09MINUS;
                            $TOTALDAY10MINUS=$CALC3DAY10MINUS;
                            $TOTALDAY11MINUS=$CALC3DAY11MINUS;
                            $TOTALDAY12MINUS=$CALC3DAY12MINUS;
                            $TOTALDAY13MINUS=$CALC3DAY13MINUS;
                            $TOTALDAY14MINUS=$CALC3DAY14MINUS;
                            $TOTALDAY15MINUS=$CALC3DAY15MINUS;
                            $TOTALDAY16MINUS=$CALC3DAY16MINUS;
                            $TOTALDAY17MINUS=$CALC3DAY17MINUS;
                            $TOTALDAY18MINUS=$CALC3DAY18MINUS;
                            $TOTALDAY19MINUS=$CALC3DAY19MINUS;
                            $TOTALDAY20MINUS=$CALC3DAY20MINUS;
                            $TOTALDAY21MINUS=$CALC3DAY21MINUS;
                            $TOTALDAY22MINUS=$CALC3DAY22MINUS;
                            $TOTALDAY23MINUS=$CALC3DAY23MINUS;
                            $TOTALDAY24MINUS=$CALC3DAY24MINUS;
                            $TOTALDAY25MINUS=$CALC3DAY25MINUS;
                            $TOTALDAY26MINUS=$CALC3DAY26MINUS;
                            $TOTALDAY27MINUS=$CALC3DAY27MINUS;
                            $TOTALDAY28MINUS=$CALC3DAY28MINUS;
                            $TOTALDAY29MINUS=$CALC3DAY29MINUS;
                            $TOTALDAY30MINUS=$CALC3DAY30MINUS;
                            $TOTALDAY31MINUS=$CALC3DAY31MINUS; 
                        // BOTTOMTOTAL             
                            $RESULTSUMTOTALPLUS=$CALSUMTOTALPLUS;
                            $RESULTSUMTOTALMINUS=$CALSUMTOTALMINUS;
                            $RESULTSUMPLUSMINUS=$CALSUMPLUSMINUS;  
                    ?>                                                      
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7" style="text-align:center;">รวม</td>
                        <td style="text-align:right;"><?php if($RESULTSUMTOTALPLUS=="0"){echo "";}else{echo number_format($RESULTSUMTOTALPLUS,0);};?></td>  
                        <td style="text-align:right;"><font color="red"><?php if($RESULTSUMTOTALMINUS=="0"){echo "";}else{echo number_format($RESULTSUMTOTALMINUS,0);};?></font></td>   
                        <td style="text-align:right;"><?php if($RESULTSUMPLUSMINUS=="0"){echo "";}else{echo number_format($RESULTSUMPLUSMINUS,0);};?></td>  
                        <td style="text-align:right;"></td>  
                    </tr>    
                    <tr>
                        <td colspan="7" style="text-align:center;">ยอดรวมทั้งสิ้น</td>
                        <td colspan="2" style="text-align:right;"><?php $CALTOTALRESULTSUMTOTAL=$RESULTSUMTOTALPLUS+$RESULTSUMTOTALMINUS; if($CALTOTALRESULTSUMTOTAL=="0"){echo "";}else{echo number_format($CALTOTALRESULTSUMTOTAL, 0);};?></td> 
                        <td style="text-align:right;"><?php if($RESULTSUMPLUSMINUS=="0"){echo "";}else{echo number_format($RESULTSUMPLUSMINUS, 0);};?></td>  
                        <td style="text-align:right;"></td>  
                    </tr>            
                </tfoot>
            </table>     
        </section>
        <!-- /.content -->
    </div>     
<?php
}else{
    echo "<h1>ไม่มีข้อมูล</h1>";
} 
sqlsrv_close($conn);
?>



<?php
    
    
?>