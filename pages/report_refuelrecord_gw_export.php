<?php
    // echo"<pre>";
    // print_r($_POST);
    // echo"</pre>";
    // exit();
    $EXCEL=$_POST['EXCEL'];
    $PDF=$_POST['PDF'];

    $datestartoil = $_POST["txt_datestartoil"];
    $startdateoil = explode(" ", $datestartoil);
    $startdateoil1 = $startdateoil[0];
    $starttimeoil1 = $startdateoil[1];    
    $startdateoil2 = explode("/", $startdateoil1);
    $startd = $startdateoil2[0];
    $startif = $startdateoil2[1];
        if($startif == "01"){
            $startm = "ม.ค.";
        }else if($startif == "02"){
            $startm = "ก.พ.";
        }else if($startif == "03"){
            $startm = "มี.ค.";
        }else if($startif == "04"){
            $startm = "เม.ย.";
        }else if($startif == "05"){
            $startm = "พ.ค.";
        }else if($startif == "06"){
            $startm = "มิ.ย.";
        }else if($startif == "07"){
            $startm = "ก.ค.";
        }else if($startif == "08"){
            $startm = "ส.ค.";
        }else if($startif == "09"){
            $startm = "ก.ย.";
        }else if($startif == "10"){
            $startm = "ต.ค.";
        }else if($startif == "11"){
            $startm = "พ.ย.";
        }else if($startif == "12"){
            $startm = "ธ.ค.";
        }
    $starty = $startdateoil2[2]+543;
    $startymd = $startdateoil2[2].'-'.$startdateoil2[1].'-'.$startdateoil2[0].' '.$starttimeoil1;

    $dateendoil = $_POST["txt_dateendoil"];
    $enddateoil = explode(" ", $dateendoil);
    $enddateoil1 = $enddateoil[0];
    $endtimeoil1 = $enddateoil[1];
    $enddateoil2 = explode("/", $enddateoil1);
    $endd = $enddateoil2[0];
    $endif = $enddateoil2[1];
        if($endif == "01"){
            $endm = "ม.ค.";
        }else if($endif == "02"){
            $endm = "ก.พ.";
        }else if($endif == "03"){
            $endm = "มี.ค.";
        }else if($endif == "04"){
            $endm = "เม.ย.";
        }else if($endif == "05"){
            $endm = "พ.ค.";
        }else if($endif == "06"){
            $endm = "มิ.ย.";
        }else if($endif == "07"){
            $endm = "ก.ค.";
        }else if($endif == "08"){
            $endm = "ส.ค.";
        }else if($endif == "09"){
            $endm = "ก.ย.";
        }else if($endif == "10"){
            $endm = "ต.ค.";
        }else if($endif == "11"){
            $endm = "พ.ย.";
        }else if($endif == "12"){
            $endm = "ธ.ค.";
        }
    $endy = $enddateoil2[2]+543;
    $endymd = $enddateoil2[2].'-'.$enddateoil2[1].'-'.$enddateoil2[0].' '.$endtimeoil1;

    $date3 = $_POST["selcompany"];
    $date4 = $_POST["selcustomer"];

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

    if($date4 == "TTT4"){
        $selcustomer2="TTT";
        $findfeild="AND EHR.Company_Code = '$date3' AND EHR.PositionNameT LIKE '%4 LOAD%' ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
    }else if($date4 == "TTT8"){
        $selcustomer2="TTT";
        $findfeild="AND EHR.Company_Code = '$date3' AND EHR.PositionNameT LIKE '%8 LOAD%' ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
    }else{
        $findfeild="AND EHR.Company_Code = '$date3' AND EHR.PositionNameT LIKE '%$date4%' ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
    }
    
    if($date3 == "RRC"){
        $findfield = "SCPT.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID AND ";
    }else{
        $findfield = "1=1 AND ";
    }
        
    // echo"<pre>";
    // print_r($_POST);
    // echo"</pre>";
    // exit();
    
    $sql = "SELECT
        DISTINCT
        OTSN.OILDATAID OILID,
        CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,						
        -- SUBSTRING(CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20), 0, 11) AS REFUEL,
        SUBSTRING(CONVERT(VARCHAR (20),OTSN.REFUELINGDATE,20), 12, 5) AS TIME,
        OTSN.REFUELINGDATE REFUEL2,
        OTSN.JOBNO JN1,
        VHCTPP.EMPLOYEECODE1 EMP1,
        VHCTPP.EMPLOYEENAME1 EMPN1,
        VHCTPP.EMPLOYEECODE2 EMP2,
        VHCTPP.EMPLOYEENAME2 EMPN2,
        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) WORK,
        OTSN.OIL_BILLNUMBER OBLNB,
        OTSN.CARDNUMBER CNB,
        OTSN.VEHICLEREGISNUMBER VHCRG,
        VHCTPP.THAINAME,
        OTSN.VEHICLETYPE VHCT,
        VHCTPP.VEHICLETYPE VHCTPLAN,
        VHCTPP.WORKTYPE,
        VHCTPP.ROUNDAMOUNT,
        VHCIF.ENERGY ENGY,
        OTSN.OIL_AMOUNT OAM,
        OTSN.MILEAGESTART MST,
        OTSN.MILEAGEEND MLE,
        OTSN.DISTANCE DTE,
        OTSN.OIL_AVERAGE OAVG,
        OTSN.OIL_TARGET OTG,
        VHCTPP.C3,
        VHCTPP.E1,
        VHCTPP.RS_OILAVERAGE,
        STUFF((SELECT '+'+ CAST(SCPT.JOBSTART AS VARCHAR)+'->'+ CAST(SCPT.JOBEND AS VARCHAR) FROM VEHICLETRANSPORTPLAN SCPT WHERE ".$findfield." SCPT.COMPANYCODE = VHCTPP.COMPANYCODE AND SCPT.EMPLOYEENAME1 = VHCTPP.EMPLOYEENAME1 AND CONVERT(VARCHAR (10),SCPT.DATEWORKING,20) = CONVERT ( VARCHAR ( 10 ), VHCTPP.DATEWORKING, 20 ) FOR XML PATH(''), TYPE).value('.','VARCHAR(max)'), 1, 1, '') AS CHKJOBSTARTEND
    FROM TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN
    LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
    LEFT JOIN EMPLOYEEEHR2 EHR ON EHR.nameT = VHCTPP.EMPLOYEENAME1
    LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
    LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
    WHERE OTSN.JOBNO IS NOT NULL AND OTSN.JOBNO != ''
    AND NOT VHCTPP.COMPANYCODE IN('RKL','RKR','RKS')
    AND OTSN.REFUELINGDATE BETWEEN '$startymd' AND '$endymd' ".$findfeild." ";                                                
    $query = sqlsrv_query($conn, $sql );
    $resultid = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    $result = sqlsrv_query($conn, $sql );        

if ($EXCEL != "" && $resultid["OILID"] != "") { ?>
    <?php
        $RENAME= "รายงานรายละเอียดการเติมน้ำมัน (GW)";
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$RENAME.xls");
        header("Pragma: no-cache");
        header("Expires: ");
    ?>       
    <div class="wrapper">
        <section class="invoice">
            <h3><u><b>รายงานรายละเอียดการเติมน้ำมัน (GW)</b></u></h3><br>            
            <p>รายงาน ตั้งแต่วันที่ <b><?=$startd.' '.$startm.' '.$starty;?></b> ถึงวันที่ <b><?=$endd.' '.$endm.' '.$endy;?></b></p>
            <table id="NoExtention1" class="table table-bordered " style="font-size: 13px;" border="1" width="100%">
                <thead>
                    <tr>
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">ลำดับ</div></th>
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">วันที่เติมน้ำมัน</div></th>
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">ลูกค้า</div></th>
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">ต้นทาง</div></th>
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">ปลายทาง</div></th>
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">Job No จากแผน</div></th>
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">Job No จากน้ำมัน</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #bfbfbf"><div align="center">พขร.1</div></th>
                        <th rowspan="1" colspan="2" style="background-color: #bfbfbf"><div align="center">พขร.2</div></th>
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">หมายเลขบิลน้ำมัน</div></th>
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">เลขบัตรเติมน้ำมัน</div></th>
                        <!-- <th rowspan="2" style="background-color: #bfbfbf"><div align="center">ทะเบียนรถ</div></th> -->
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">เบอร์รถ</div></th>
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">ประเภทรถ</div></th>
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">น้ำมัน</div></th>
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">เลขไมล์ต้น</div></th>
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">เลขไมล์ปลาย</div></th>
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">ระยะทาง</div></th>
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">จำนวนลิตร</div></th>
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">ค่าเฉลี่ยที่กำหนด</div></th>
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">ค่าเฉลี่ยที่ได้</div></th>
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">จำนวนน้ำมันเกินกว่ากำหนด</div></th>
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">จำนวนเงิน</div></th>
                        <th rowspan="2" style="background-color: #bfbfbf"><div align="center">หมายเหตุ</div></th>
                    </tr>
                    <tr> 
                        <th colspan="1" style="background-color: #bfbfbf"><div align="center">รหัส</div></th>
                        <th colspan="1" style="background-color: #bfbfbf"><div align="center">ชื่อ-สกุล</div></th>
                        <th colspan="1" style="background-color: #bfbfbf"><div align="center">รหัส</div></th>
                        <th colspan="1" style="background-color: #bfbfbf"><div align="center">ชื่อ-สกุล</div></th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                while($row = sqlsrv_fetch_array($result)) {                   
                        $OILID=$row["OILID"];         
                        $REFUEL=$row["REFUEL"];                             
                        $CRF = explode("-", $REFUEL);
                        $DT1 = $CRF[0];
                        $DT2 = $CRF[1];
                        $DT3 = $CRF[2]; 
                        $CONREFUEL = $DT3.'/'.$DT2.'/'.$DT1.' '.$row["TIME"]; 
                        $JN1=$row["JN1"];           
                        $EMP1=$row["EMP1"];        
                        $EMPN1=$row["EMPN1"];                 
                        $EMP2=$row["EMP2"];      
                        $EMPN2=$row["EMPN2"];   
                        $WORK=$row["WORK"];          
                        $OBLNB=$row["OBLNB"];   
                        $CNB=$row["CNB"]; 
                        $VHCRG=$row["VHCRG"];  
                        $VHCTHAINAME=$row["THAINAME"];                  
                        $VHCT=$row["VHCT"];     
                        $VHCTPLAN=$row["VHCTPLAN"];               
                        $ENGY=$row["ENGY"];                  
                        $OAM=$row["OAM"];                  
                        $MST=$row["MST"];                
                        $MLE=$row["MLE"];                  
                        $DTE=$row["DTE"];                       
                        $OAVG=$row["OAVG"];                     
                        $OTG=$row["OTG"];                 
                        $C3=$row["C3"];                   
                        $E1=$row["E1"];     
                        $WORKTYPE=$row["WORKTYPE"]; 
                        $ROUNDAMOUNT=$row["ROUNDAMOUNT"]; 
                        $CHKJOBSTARTEND=$row["CHKJOBSTARTEND"]; 
 
                        $stmm="SELECT
                            VHCTPPEMP.COMPANYCODE CMPNC,
                            VHCTPPEMP.CUSTOMERCODE CTMC,
                            VHCTPPEMP.JOBSTART JNST,
                            VHCTPPEMP.JOBEND JNED,
                            VHCTPPEMP.JOBNO JN2,
                            VHCTPPEMP.EMPLOYEECODE1 EMP1,
                            VHCTPPEMP.EMPLOYEENAME1 EMPN1,
                            VHCTPPEMP.EMPLOYEECODE2 EMP2,
                            VHCTPPEMP.EMPLOYEENAME2 EMPN2,
                            CONVERT (VARCHAR (10),VHCTPPEMP.DATEWORKING,20) WORK
                        FROM RTMS.dbo.VEHICLETRANSPORTPLAN VHCTPPEMP
                        WHERE VHCTPPEMP.EMPLOYEENAME1= '$EMPN1'
                        AND CONVERT(VARCHAR (10),VHCTPPEMP.DATEWORKING,20) = '$WORK'";
                        $querystmm = sqlsrv_query($conn, $stmm );
                        // $resultvalue = sqlsrv_fetch_array($querystmm, SQLSRV_FETCH_ASSOC);                         
                        while($resultvalue = sqlsrv_fetch_array($querystmm)) { 
                            $JOBNOPLAN=$resultvalue["JN2"];  
                            $CMPNC=$resultvalue["CMPNC"];    
                            $CTMC=$resultvalue["CTMC"];           
                            $JNST=$resultvalue["JNST"];       
                            $JNED=$resultvalue["JNED"];   
                        
                        $SQLROUND="SELECT COUNT(VHCTPP.EMPLOYEECODE1) AS ROUND FROM VEHICLETRANSPORTPLAN VHCTPP 
                        WHERE VHCTPP.COMPANYCODE = '$CMPNC' AND (VHCTPP.EMPLOYEECODE1 = '$EMP1' OR VHCTPP.EMPLOYEECODE2 = '$EMP1') 
                        AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$WORK' GROUP BY VHCTPP.EMPLOYEECODE1 ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                        $QUERYROUND = sqlsrv_query($conn, $SQLROUND ); 
                        $RSROUND = sqlsrv_fetch_array($QUERYROUND, SQLSRV_FETCH_ASSOC);   
                        // while($RSROUND = sqlsrv_fetch_array($QUERYROUND)) { 
                            $ROUND=$RSROUND["ROUND"];      
                        // }   
                    
                        
                        if(isset($row["RS_OILAVERAGE"])){
                            $OAVR=$row["RS_OILAVERAGE"];
                        }else{
                            if($selcustomer2=="TTT"){
                                $findfeildOIL="AND OILAVERAGE.REMARK = '$WORKTYPE'";
                            }else{
                                $findfeildOIL="";
                            } 
                            $SQLCHKOAVG="SELECT DISTINCT OILAVERAGE.OILAVERAGE OAVR
                            FROM OILAVERAGE 
                            WHERE OILAVERAGE.COMPANYCODE = '$CMPNC'
                            AND OILAVERAGE.CUSTOMERCODE = '$CTMC'
                            AND OILAVERAGE.VEHICLETYPE = '$VHCTPLAN' ".$findfeildOIL."";
                            $QUERYCHKOAVG = sqlsrv_query($conn, $SQLCHKOAVG );
                            $RSCHKOAVG = sqlsrv_fetch_array($QUERYCHKOAVG, SQLSRV_FETCH_ASSOC);  
                            // while($RSCHKOAVG = sqlsrv_fetch_array($QUERYCHKOAVG)) { 
                                if ($VHCRG =='61-4454'||$VHCRG =='61-4456'||$VHCRG =='61-3440'||$VHCRG =='61-3441'||$VHCRG =='61-4453'||$VHCRG =='61-4457'||$VHCRG =='61-4912'||$VHCRG =='61-4913'||$VHCRG =='61-4546'||$VHCRG =='61-4547'||$VHCRG =='64-3452'||$VHCRG =='61-3445'||$VHCRG =='61-3439'||$VHCRG =='61-3443'||$VHCRG =='61-3834'||$VHCRG =='61-3835'||$VHCRG =='61-3438'||$VHCRG =='61-3437'||$VHCRG =='62-9288'||$VHCRG =='61-3836'||$VHCRG =='61-4458'||$VHCRG =='61-3444'||$VHCRG =='60-3868'||$VHCRG =='60-3870'||$VHCRG =='61-3437'||$VHCRG =='61-3452') {
                                    $OAVR = '4.0';    
                                }else if($VHCRG =='60-3871'||$VHCRG =='61-3442'||$VHCRG =='60-2391'||$VHCRG =='61-3444'||$VHCRG =='76-8919'||$VHCRG =='61-4458'||$VHCRG =='79-2521'||$VHCRG =='79-2522'||$VHCRG =='79-2525'||$VHCRG =='74-5653'||$VHCRG =='74-5684'||$VHCRG =='74-5684'||$VHCRG =='74-5654') {
                                    $OAVR = '3.5';           
                                }else if(($VHCTHAINAME=='T-001')||($VHCTHAINAME=='T-002')||($VHCTHAINAME=='T-003')||($VHCTHAINAME=='T-004')){     // ชื่อรถ T001 - T004
                                    if($CUS=='GMT'){                                                              // ถ้าเป็นลูกค้า GMT
                                        $OAVR='4.25';                                                               // คิด 4.25
                                    }else{                                                                              // ถ้าไม่ใช่ลูกค้า GMT
                                        $OAVR='5.00';                                                               // คิด 5.00
                                    }                                                                                     
                                }else if(($VHCTHAINAME=='T-005')||($VHCTHAINAME=='T-006')||($VHCTHAINAME=='T-007')||($VHCTHAINAME=='T-008')||($VHCTHAINAME=='T-009')){    // ชื่อรถ T001 - T004
                                    $OAVR='4.75';                                                                                            // คิด 4.75
                                }else if(($VHCTHAINAME=='G-001')||($VHCTHAINAME=='G-002')||($VHCTHAINAME=='G-003')||($VHCTHAINAME=='G-004')||($VHCTHAINAME=='G-005')||
                                        ($VHCTHAINAME=='G-006')||($VHCTHAINAME=='G-007')||($VHCTHAINAME=='G-008')||($VHCTHAINAME=='G-009')||($VHCTHAINAME=='G-010')||
                                        ($VHCTHAINAME=='G-011')||($VHCTHAINAME=='G-012')||($VHCTHAINAME=='G-013')){                                           // ชื่อรถ G001 - G0013
                                    if($VHCTPLAN=="10W(Dump)"){                                                                                 // ถ้าเป็นรถ 10W
                                        $OAVR='4.25';                                                                                       // คิด 4.25
                                    }else if($VHCTPLAN=="22W(Dump)"){                                                                           // ถ้าเป็นรถ 22W
                                        $OAVR='3.00';                                                                                       // คิด 3.00
                                    } 
                                }else if($C2=="NOTNULL"){                                          // ถ้าเป็นงานรับกลับ
                                    $OAVR='3.75';                                       // คิด 3.75
                                }else{
                                    if(($ROUND=='1')){                                   // 1 เที่ยว
                                        if($RSCHKW1=='sh'){
                                            $OAVR='4.25';                               // sh = 3.75 // แก้เป็น 4.25 วันที่ 6/9/2023
                                        }else if($RSCHKW1=='nm'){
                                            $OAVR='4.25';                               // nm = 4.25 
                                        }else{
                                            $OAVR=$RSCHKOAVG["OAVR"];                // เรทปกติจากระบบ 
                                        }
                                    }else if($ROUND=='2'){                               // 2 เที่ยว                                                                   
                                        if(($RSCHKW1=='sh')&&($RSCHKW2=='sh')){ 
                                            $OAVR='3.75';                               // sh-sh = 3.75
                                        }else if(($RSCHKW1=='sh')&&($RSCHKW2=='nm')){
                                            $OAVR='4.25';                               // sh-nm = 4.25
                                        }else if(($RSCHKW1=='nm')&&($RSCHKW2=='sh')){
                                            $OAVR='3.75';                               // nm-sh = 3.75  
                                        }else if(($RSCHKW1=='nm')&&($RSCHKW2=='nm')){
                                            $OAVR='4.25';                               // nm-nm = 4.25                                                                        
                                        }else{
                                            $OAVR=$RSCHKOAVG["OAVR"]; // เรทปกติจากระบบ                                                                    
                                        }
                                    }else{
                                        $OAVR=$RSCHKOAVG["OAVR"];  // เรทปกติจากระบบ                                                                    
                                    }                                    
                                }
                            // }
                        }

                        $RDTE=$row["DTE"];    $QRDTE=$QRDTE+$RDTE;       
                        $ROAM=$row["OAM"];    $QROAM=$QROAM+$ROAM;     
                        $ROTG=$RSCHKOAVG["OAVR"]; 
                        $QCALOAM=(($RDTE/$ROAM)-$ROTG);     
                        $QRCALOAM=$QRCALOAM+$QCALOAM;   
                        $RC3=$row["C3"];  
                        
                        $EMPC1=$resultvalue["EMP1"];
                        $EMPC2=$resultvalue["EMP2"];
                        // echo 'คนที่ 1 '.$EMP.'<br>';
                        // echo 'คนที่ 2 '.$EMPC2.'<br>';
                        if($EMPC2==$EMPC1){
                            $IFRC3=round($RC3); 
                            // echo 'รหัส 1 ตรงกับรหัส 2 = ราคา = '.$CALPRICE.'<br>';
                        }else if($EMPC2!=$EMPC1){
                            if($EMPC2!=""){
                                $IFRC3=round($RC3 / 2); 
                                // echo 'รหัส 1 ไม่ตรงกับรหัส 2 = (ราคา)/2 = '.$CALPRICE.'<br>';
                            }else{
                                $IFRC3=round($RC3); 
                                // echo 'รหัส 1 ไม่ตรงกับรหัส 2 แต่ไปคนเดียว = ราคา = '.$CALPRICE.'<br>';
                            }
                        }
                        $QRC3=$QRC3+$IFRC3;   
                        $arr[] = $row["OAVG"];  

                        if($JN1==$JOBNOPLAN){
                            $RSCONREFUEL=$CONREFUEL;
                            $RSJOBOIL=$JN1;
                            $RSCNB=$CNB;
                            $RSVHCRG=$VHCRG;
                            $RSVHCTHAINAME=$VHCTHAINAME;
                            $RSVHCT=$VHCTPLAN;
                            // $RSVHCT=$VHCT;
                            // $RSENGY=$ENGY;
                            $RSENGY='ดีเซล';
                            $RSOAM=number_format($OAM, 2);
                            $RSMST=$MST;
                            $RSMLE=$MLE;
                            $RSDTE=number_format($DTE, 2);
                            $RSOAVG=number_format($OAVG, 2);
                            $RSOTG=number_format($OAVR, 2);    
                            $RSC3=round($IFRC3);                                                 
                            // $CALOAM=(($DTE/$OAM)-$OTG);
                            $CALOAM=(($DTE/$OAVR)-$OAM);
                            $RSCALOAM=round(number_format($CALOAM, 2)); 
                        }else{
                            $RSCONREFUEL="";
                            $RSJOBOIL="";
                            $RSCNB="";
                            $RSVHCRG="";
                            $RSVHCTHAINAME="";
                            $RSVHCT="";
                            $RSENGY="";
                            $RSOAM="";
                            $RSMST="";
                            $RSMLE="";
                            $RSDTE="";
                            $RSOAVG="";
                            $RSOTG="";
                            $RSC3="";
                            $RSCALOAM="";
                        } 

                        // ไม่คิดเรทน้ำมัน
                            $explodeJOB = explode("+", $CHKJOBSTARTEND);
                            $JOBONE = $explodeJOB[0];
                            $JOBTWO = $explodeJOB[1];                                       
                            
                            if(($CMPNC=='RCC')||($CMPNC=='RATC')){
                                if($VHCTPLAN=='4L'){
                                    $MONEYTOTAL='0';
                                    $REMARK='ไม่คิดเรทน้ำมัน';
                                }else if($VHCTPLAN=='8L'){
                                    if($ROUND=='1'){
                                        if(($JOBONE=='GW->BP')||($JOBONE=='BP->GW')||($JOBONE=='BP->TAC')||($JOBONE=='GW->GMT2')){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($JOBONE=='GW->E3,E3'||$JOBONE=='GW->E3,E8'||$JOBONE=='GW->E3,I1'||$JOBONE=='GW->E3,I15'||
                                                 $JOBONE=='GW->E8,E3'||$JOBONE=='GW->E8,E8'||$JOBONE=='GW->E8,I1'||$JOBONE=='GW->E8,I15'||
                                                 $JOBONE=='GW->I1,E3'||$JOBONE=='GW->I1,E8'||$JOBONE=='GW->I1,I1'||$JOBONE=='GW->I1,I15'||
                                                 $JOBONE=='GW->I15,E3'||$JOBONE=='GW->I15,E8'||$JOBONE=='GW->I15,I1'||$JOBONE=='GW->I15,I15'||
                                                 $JOBONE=='GW->E3'||$JOBONE=='GW->E8'||$JOBONE=='GW->I1'||$JOBONE=='GW->I15'){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($JOBONE=='GW->LCB 3 เที่ยว'){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($JOBONE=='BP->SW'){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($JNST=='กัมพูชา'||$JNED=='กัมพูชา'){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($VHCTHAINAME=='R-401'||$VHCTHAINAME=='R-801'||$VHCTHAINAME=='R-802'){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else{
                                            $MONEYTOTAL=$RSC3;
                                            $REMARK='';
                                        }
                                    }else if($ROUND=='2'){
                                        if($JOBONE=='GW->BP' && ($JOBTWO=='BP->SW'||$JOBTWO=='BP->GW'||$JOBTWO=='GW->BP'||$JOBTWO=='SP->BP'||$JOBTWO=='BP->SP'||$JOBTWO=='GW->I1'||$JOBTWO=='GW->I15')){
                                                $MONEYTOTAL='0';
                                                $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($JOBONE=='BP->GW' && $JOBTWO=='BP->GW'){
                                            $MONEYTOTAL='0';    
                                            $REMARK='ไม่คิดเรทน้ำมัน'; 
                                        }else if(($JOBONE=='BP->TAC')&&($JOBTWO=='TAC->BP')){
                                                $MONEYTOTAL='0';    
                                                $REMARK='ไม่คิดเรทน้ำมัน';  
                                        }else if($JOBONE=='GW->LCB' && ($JOBTWO=='GW->I1'||$JOBTWO=='GW->I15'||$JOBTWO=='GW->I1,I15'||$JOBTWO=='GW->E3')){
                                                $MONEYTOTAL='0';
                                                $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if(($JOBONE=='GW->LCB 3 เที่ยว')&&($JOBTWO=='GW->LCB 3 เที่ยว')){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($JNST=='กัมพูชา'||$JNED=='กัมพูชา'){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($VHCTHAINAME=='R-401'||$VHCTHAINAME=='R-801'||$VHCTHAINAME=='R-802'){
                                                $MONEYTOTAL='0';
                                                $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else{
                                            $MONEYTOTAL=$RSC3;
                                            $REMARK='';
                                        }
                                    }else{
                                        if($JOBONE=='GW->E3,E3'||$JOBONE=='GW->E3,E8'||$JOBONE=='GW->E3,I1'||$JOBONE=='GW->E3,I15'||
                                            $JOBONE=='GW->E8,E3'||$JOBONE=='GW->E8,E8'||$JOBONE=='GW->E8,I1'||$JOBONE=='GW->E8,I15'||
                                            $JOBONE=='GW->I1,E3'||$JOBONE=='GW->I1,E8'||$JOBONE=='GW->I1,I1'||$JOBONE=='GW->I1,I15'||
                                            $JOBONE=='GW->I15,E3'||$JOBONE=='GW->I15,E8'||$JOBONE=='GW->I15,I1'||$JOBONE=='GW->I15,I15'||
                                            $JOBONE=='GW->E3'||$JOBONE=='GW->E8'||$JOBONE=='GW->I1'||$JOBONE=='GW->I15'){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($JOBONE=='GW->LCB 3 เที่ยว'){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($JNST=='กัมพูชา'||$JNED=='กัมพูชา'){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else if($VHCTHAINAME=='R-401'||$VHCTHAINAME=='R-801'||$VHCTHAINAME=='R-802'){
                                            $MONEYTOTAL='0';
                                            $REMARK='ไม่คิดเรทน้ำมัน';
                                        }else{
                                            $MONEYTOTAL=$RSC3;
                                            $REMARK='';
                                        }
                                    }
                                }
                            }else if($CMPNC=='RRC'){
                                if($JOBONE=='GMT->ICP1,ICP2'||$JOBONE=='GMT->ICP1,NTS'||$JOBONE=='GMT->ICP1,GJ'||$JOBONE=='GMT->ICP1,KIRIU'||
                                   $JOBONE=='GMT->ICP2,ICP1'||$JOBONE=='GMT->ICP2,NTS'||$JOBONE=='GMT->ICP2,GJ'||$JOBONE=='GMT->ICP2,KIRIU'||
                                   $JOBONE=='GMT->NTS,ICP1' ||$JOBONE=='GMT->NTS,ICP2'||$JOBONE=='GMT->NTS,GJ' ||$JOBONE=='GMT->NTS,KIRIU' ||
                                   $JOBONE=='GMT->GJ,ICP1'  ||$JOBONE=='GMT->GJ,ICP2' ||$JOBONE=='GMT->GJ,NTS' ||$JOBONE=='GMT->GJ,KIRIU'  ||
                                   $JOBONE=='GMT->ICP1'     ||$JOBONE=='GMT->ICP2'    ||$JOBONE=='GMT->NTS'    ||$JOBONE=='GMT->GJ'        ||
                                   $JOBONE=='GMT->KIRIU'    ||$JOBONE=='GMT->TSB'     ||$JOBONE=='GMT->TSMT สระบุรี'){
                                    // if($JOBONE=='GMT->ICP1'||$JOBONE=='GMT->ICP2'||$JOBONE=='GMT->NTS'||$JOBONE=='GMT->GJ'||$JOBONE=='GMT->KIRIU'||
                                    //    $JOBTWO=='GMT->ICP1'||$JOBTWO=='GMT->ICP2'||$JOBTWO=='GMT->NTS'||$JOBTWO=='GMT->GJ'||$JOBTWO=='GMT->KIRIU'){
                                    $MONEYTOTAL='0';   
                                    $REMARK='ไม่คิดเรทน้ำมัน';
                                }else if($JOBONE=='GMT 2->ICP1,ICP2'||$JOBONE=='GMT 2->ICP1,NTS'||$JOBONE=='GMT 2->ICP1,GJ'||$JOBONE=='GMT 2->ICP1,KIRIU'||
                                         $JOBONE=='GMT 2->ICP2,ICP1'||$JOBONE=='GMT 2->ICP2,NTS'||$JOBONE=='GMT 2->ICP2,GJ'||$JOBONE=='GMT 2->ICP2,KIRIU'||
                                         $JOBONE=='GMT 2->NTS,ICP1' ||$JOBONE=='GMT 2->NTS,ICP2'||$JOBONE=='GMT 2->NTS,GJ' ||$JOBONE=='GMT 2->NTS,KIRIU' ||
                                         $JOBONE=='GMT 2->GJ,ICP1'  ||$JOBONE=='GMT 2->GJ,ICP2' ||$JOBONE=='GMT 2->GJ,NTS' ||$JOBONE=='GMT 2->GJ,KIRIU'  ||
                                         $JOBONE=='GMT 2->ICP1'     ||$JOBONE=='GMT 2->ICP2'    ||$JOBONE=='GMT 2->NTS'    ||$JOBONE=='GMT 2->GJ'        ||
                                         $JOBONE=='GMT 2->KIRIU'    ||$JOBONE=='GMT 2->KIRIU กรณีตีเปล่า'  ||$JOBONE=='GMT 2->TSMT สระบุรี'  ||$JOBONE=='GMT 2->GJ กรณีตีเปล่า'){
                                        // }else if($JOBONE=='GMT 2->ICP1'||$JOBONE=='GMT 2->ICP2'||$JOBONE=='GMT 2->NTS'||$JOBONE=='GMT 2->GJ'||$JOBONE=='GMT 2->KIRIU'||
                                        //          $JOBTWO=='GMT 2->ICP1'||$JOBTWO=='GMT 2->ICP2'||$JOBTWO=='GMT 2->NTS'||$JOBTWO=='GMT 2->GJ'||$JOBTWO=='GMT 2->KIRIU'){
                                    $MONEYTOTAL='0';   
                                    $REMARK='ไม่คิดเรทน้ำมัน';
                                }else if(($JOBONE=='TTAST->STT')||($JOBONE=='TTAST->NB WOOD')||($JOBONE=='TTAST->CH')){
                                    $MONEYTOTAL='0';   
                                    $REMARK='ไม่คิดเรทน้ำมัน';
                                }else if($CTMC=='GMT-IB' && ($VHCTPLAN=='10W(กระบะสไลด์) (1 Trips/Trailer/Day)'||$VHCTPLAN=='10W(กระบะสไลด์) (2 Trips/Trailer/Day(GMT2))'||$VHCTPLAN=='10W(กระบะสไลด์) (2 Trips/Trailer/Day)'||$VHCTPLAN=='10W(กระบะสไลด์) (3 Trips/Trailer/Day(GMT2))'||$VHCTPLAN=='10W(กระบะสไลด์) (3 Trips/Trailer/Day)')){
                                    $MONEYTOTAL='0';  
                                    $REMARK='ไม่คิดเรทน้ำมัน';          
                                }else if(($CTMC=='TTAST') && ($VHCTPLAN=='Semitrailer')){
                                    $MONEYTOTAL='0';
                                    $REMARK='ไม่คิดเรทน้ำมัน';
                                }else if(($CTMC=='TTAST') && ($VHCTPLAN=='10W (Van)') && ($JOBONE=='TTAST->G-TEC (Zanzai)')){
                                    $MONEYTOTAL='0';
                                    $REMARK='ไม่คิดเรทน้ำมัน';
                                }else if(($JOBONE=='TTAST->G-TEC (Zanzai)')){
                                    $MONEYTOTAL='0';
                                    $REMARK='ไม่คิดเรทน้ำมัน';
                                }else if($VHCTHAINAME=='R-401'||$VHCTHAINAME=='R-801'||$VHCTHAINAME=='R-802'){
                                    $MONEYTOTAL='0';
                                    $REMARK='ไม่คิดเรทน้ำมัน';
                                }else if(($JOBONE=='โลหะกิจ->GMT 2')){
                                    $MONEYTOTAL='0';
                                    $REMARK='ไม่คิดเรทน้ำมัน';
                                }else{
                                    $MONEYTOTAL=$RSC3;
                                    $REMARK='';
                                }
                            }else{
                                $MONEYTOTAL=$RSC3;
                                $REMARK='';
                            }
                        // echo 'ประเภทรถ: '.$VHCTPLAN.' งานที่ 1: '.$JOBONE.' รอบที่วิ่ง: '.$ROUNDAMOUNT;
                        // echo ' งานที่ 2: '.$JOBTWO.' รอบที่วิ่ง: '.$ROUNDAMOUNT.' จำนวนรอบวันนั้น: '.$ROUND.' ยอดเงินตามสูตรคำนวน: '.$MONEYTOTAL.'<br>';  
                        
                        if($JN1==$JOBNOPLAN){
                            $RSMONEYTOTAL=$MONEYTOTAL;
                            $RSREMARK=$REMARK;
                        }else{
                            $RSMONEYTOTAL="";
                            $RSREMARK="";
                        } 
                    ?>
                        <tr>
                            <td align="center"><?=$i;?></td>
                            <td align="left"><?=$RSCONREFUEL;?></td>
                            <td align="center"><?=$CTMC;?></td>
                            <td align="center"><?=$JNST;?></td>
                            <td align="center"><?=$JNED;?></td>
                            <td align="center"><?=$JOBNOPLAN;?></td>
                            <td align="center"><?=$RSJOBOIL;?></td>
                            <td align="center"><?=$EMP1;?></td>
                            <td align="left"><?=$EMPN1;?></td>
                            <td align="center"><?=$EMP2;?></td>
                            <td align="left"> <?=$EMPN2;?></td>
                            <td align="center"><?=$OBLNB;?></td>
                            <td align="center"><?=$RSCNB;?></td>
                            <td align="center"><?=$RSVHCTHAINAME;?></td>
                            <!-- <td align="center"><?=$RSVHCRG;?></td> -->
                            <td align="center"><?=$RSVHCT;?></td>
                            <td align="center"><?=$RSENGY;?></td>
                            <td align="right"><?=$RSMST;?></td>
                            <td align="right"><?=$RSMLE;?></td>
                            <td align="right"><?=$RSDTE;?></td>
                            <td align="right"><?=$RSOAM;?></td>
                            <td align="right"><?=$RSOTG;?></td>
                            <td align="right"><?=$RSOAVG;?></td>
                            <td align="right"><?=$RSCALOAM;?></td>
                            <td align="right"><?=$RSMONEYTOTAL;?></td>
                            <td align="right"><?=$RSREMARK;?></td>
                        </tr>    
                    <?php 
                        $i++; } }
                        $TOTALDTE=$QRDTE;
                        $TOTALOAM=$QROAM;  
                        $TOTALCALOAM=$QRCALOAM;  
                        $TOTALC3=$QRC3;   

                        function Average($arr) {
                            $array_size = count($arr);                
                            $total = 0;
                            for ($i = 0; $i < $array_size; $i++) {
                                $total += $arr[$i];
                            }                
                            $AVERAGETEST = (float)($total / $array_size);
                            return $AVERAGETEST;
                        }
                    ?>                                                         
                </tbody>
                <tfoot>
                    <td colspan="18" style="text-align:right;">รวม </td>
                    <td style="text-align:right;"><?=number_format($TOTALDTE, 2)?></td>
                    <td style="text-align:right;"><?=number_format($TOTALOAM, 2)?></td>
                    <td style="text-align:right;"></td>
                    <!-- <td style="text-align:right;"></td> -->
                    <td style="text-align:right;"><?=number_format(Average($arr), 2)?></td>
                    <td style="text-align:right;"><?=number_format($TOTALCALOAM, 2)?></td>
                    <td style="text-align:right;"><?=number_format($TOTALC3, 2)?></td>
                    <td style="text-align:right;"></td>                    
                </tfoot>
            </table>        
        </section>
        <!-- /.content -->
    </div>
<?php }else if ($PDF != "" && $resultid["OILID"] != "") {   
    // <td colspan="2" rowspan="4" style="text-align:center; "><img src="../images/logonew.png" width="70" height="70"></td>
    $mpdf = new mPDF('', 'A4-L', '', '', 15, 15,30);
    $style = '<style>body{font-family: "angsana";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย}</style>';

    $table_header3 = '<h3><u>รายงานรายละเอียดการเติมน้ำมัน (GW)</u></h3>           
    รายงาน ตั้งแต่วันที่ '.$startd.' '.$startm.' '.$starty.' ถึงวันที่ '.$endd.' '.$endm.' '.$endy.'<br>';
    if($date3 != "CENTER"){ 
        $table_begin3 = '<table style="border-collapse: collapse;font-size:13px" width="100%">';

        $thead3 = '<thead>
                        <tr>
                            <td rowspan="2" style="background-color: #bfbfbf;width:5%;border:1px solid #000;padding:3px;text-align:center">ลำดับ</td>
                            <td rowspan="2" style="background-color: #bfbfbf;width:10%;border:1px solid #000;padding:3px;text-align:center">วันที่เติมน้ำมัน</div></td>
                            <td rowspan="2" style="background-color: #bfbfbf;width:5%;border:1px solid #000;padding:3px;text-align:center">ลูกค้า</div></td>
                            <td rowspan="2" style="background-color: #bfbfbf;width:10%;border:1px solid #000;padding:3px;text-align:center">ต้นทาง</div></td>
                            <td rowspan="2" style="background-color: #bfbfbf;width:10%;border:1px solid #000;padding:3px;text-align:center">ปลายทาง</div></td>
                            <td rowspan="2" style="background-color: #bfbfbf;width:10%;border:1px solid #000;padding:3px;text-align:center">Job No จากแผน</div></td>
                            <td rowspan="2" style="background-color: #bfbfbf;width:10%;border:1px solid #000;padding:3px;text-align:center">Job No จากน้ำมัน</div></td>
                            <td rowspan="1" colspan="2" style="background-color: #bfbfbf;width:15%;border:1px solid #000;padding:3px;text-align:center">พขร.1</div></td>
                            <td rowspan="1" colspan="2" style="background-color: #bfbfbf;width:15%;border:1px solid #000;padding:3px;text-align:center">พขร.2</div></td>
                            <td rowspan="2" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">หมายเลขบิลน้ำมัน</div></td>
                            <td rowspan="2" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">เลขบัตรเติมน้ำมัน</div></td>
                            <td rowspan="2" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">ทะเบียนรถ</div></td>
                            <td rowspan="2" style="background-color: #bfbfbf;width: 10%;border:1px solid #000;padding:3px;text-align:center">ประเภทรถ</div></td>
                            <td rowspan="2" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">น้ำมัน</div></td>
                            <td rowspan="2" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">เลขไมล์ต้น</div></td>
                            <td rowspan="2" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">เลขไมล์ปลาย</div></td>
                            <td rowspan="2" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">ระยะทาง</div></td>
                            <td rowspan="2" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">จำนวนลิตร</div></td>
                            <td rowspan="2" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">ค่าเฉลี่ยที่กำหนด</div></td>
                            <td rowspan="2" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">ค่าเฉลี่ยที่ได้</div></td>
                            <td rowspan="2" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">จำนวนน้ำมันเกินกว่ากำหนด</div></td>
                            <td rowspan="2" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">จำนวนเงิน</div></td>
                            <td rowspan="2" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">หมายเหตุ</div></td>
                        </tr>
                        <tr>
                            <td colspan="1" style="background-color: #bfbfbf;width:5%;border:1px solid #000;padding:3px;text-align:center">รหัส</div></td>
                            <td colspan="1" style="background-color: #bfbfbf;width:10%;border:1px solid #000;padding:3px;text-align:center">ชื่อ-สกุล</div></td>
                            <td colspan="1" style="background-color: #bfbfbf;width:5%;border:1px solid #000;padding:3px;text-align:center">รหัส</div></td>
                            <td colspan="1" style="background-color: #bfbfbf;width:10%;border:1px solid #000;padding:3px;text-align:center">ชื่อ-สกุล</div></td>
                        </tr>
                    </thead><tbody>';

                    $i = 1;
                    while($row = sqlsrv_fetch_array($result)) {                             
                        $OILID=$row["OILID"];         
                        $REFUEL=$row["REFUEL"];                             
                        $CRF = explode("-", $REFUEL);
                        $DT1 = $CRF[0];
                        $DT2 = $CRF[1];
                        $DT3 = $CRF[2]; 
                        $CONREFUEL = $DT3.'/'.$DT2.'/'.$DT1; 
                        $JN1=$row["JN1"];           
                        $EMP1=$row["EMP1"];        
                        $EMPN1=$row["EMPN1"];                 
                        $EMP2=$row["EMP2"];      
                        $EMPN2=$row["EMPN2"];   
                        $WORK=$row["WORK"];          
                        $OBLNB=$row["OBLNB"];   
                        $CNB=$row["CNB"]; 
                        $VHCRG=$row["VHCRG"];                  
                        $VHCT=$row["VHCT"];               
                        $VHCTPLAN=$row["VHCTPLAN"];                 
                        $ENGY=$row["ENGY"];                  
                        $OAM=$row["OAM"];                  
                        $MST=$row["MST"];                
                        $MLE=$row["MLE"];                  
                        $DTE=$row["DTE"];                       
                        $OAVG=$row["OAVG"];                     
                        $OTG=$row["OTG"];     
                        $C3=$row["C3"];                   
                        $E1=$row["E1"];    
                        
                        $SQLCHKOAVG="SELECT DISTINCT OILAVERAGE.OILAVERAGE OAVR
                        FROM OILAVERAGE 
                        WHERE OILAVERAGE.COMPANYCODE = '$date3'
                        AND OILAVERAGE.CUSTOMERCODE = '$date4'
                        AND OILAVERAGE.VEHICLETYPE = '$VHCTPLAN'";
                        $QUERYCHKOAVG = sqlsrv_query($conn, $SQLCHKOAVG );
                        while($RSCHKOAVG = sqlsrv_fetch_array($QUERYCHKOAVG)) { 
                            $OAVR=$RSCHKOAVG["OAVR"]; 

                        $RDTE=$row["DTE"];    $QRDTE=$QRDTE+$RDTE;       
                        $ROAM=$row["OAM"];    $QROAM=$QROAM+$ROAM;     
                        $ROTG=$RSCHKOAVG["OAVR"]; 
                        $QCALOAM=(($RDTE/$ROAM)-$ROTG);     $QRCALOAM=$QRCALOAM+$QCALOAM;   
                        $RC3=$row["C3"];    $QRC3=$QRC3+$RC3;   
                        $arr[] = $row["OAVG"];          
                        
                        $stmm="SELECT
                            VHCTPPEMP.COMPANYCODE CMPNC,
                            VHCTPPEMP.CUSTOMERCODE CTMC,
                            VHCTPPEMP.JOBSTART JNST,
                            VHCTPPEMP.JOBEND JNED,
                            VHCTPPEMP.JOBNO JN2,
                            VHCTPPEMP.EMPLOYEECODE1 EMP1,
                            VHCTPPEMP.EMPLOYEENAME1 EMPN1,
                            VHCTPPEMP.EMPLOYEECODE2 EMP2,
                            VHCTPPEMP.EMPLOYEENAME2 EMPN2,
                            CONVERT (VARCHAR (10),VHCTPPEMP.DATEWORKING,20) WORK
                        FROM RTMS.dbo.VEHICLETRANSPORTPLAN VHCTPPEMP
                        WHERE VHCTPPEMP.EMPLOYEENAME1= '$EMPN1'
                        AND CONVERT(VARCHAR (10),VHCTPPEMP.DATEWORKING,20) = '$WORK'";
                        $querystmm = sqlsrv_query($conn, $stmm );
                        // $resultvalue = sqlsrv_fetch_array($querystmm, SQLSRV_FETCH_ASSOC);                         
                        while($resultvalue = sqlsrv_fetch_array($querystmm)) { 
                        $JOBNOPLAN=$resultvalue["JN2"];  
                        $CMPNC=$resultvalue["CMPNC"];    
                        $CTMC=$resultvalue["CTMC"];           
                        $JNST=$resultvalue["JNST"];       
                        $JNED=$resultvalue["JNED"];  

                        if($JN1==$JOBNOPLAN){
                            $RSCONREFUEL=$CONREFUEL;
                            $RSJOBOIL=$JN1;
                            $RSCNB=$CNB;
                            $RSVHCRG=$VHCRG;
                            $RSVHCT=$VHCT;
                            $RSENGY=$ENGY;
                            $RSOAM=number_format($OAM, 2);
                            $RSMST=$MST;
                            $RSMLE=$MLE;
                            $RSDTE=number_format($DTE, 2);
                            $RSOAVG=number_format($OAVG, 2);
                            $RSOTG=number_format($OAVR, 2);
                            $RSC3=number_format($C3, 2);
                            $CALOAM=(($DTE/$OAM)-$OTG);
                            $RSCALOAM=number_format($CALOAM, 2);
                        }else{
                            $RSCONREFUEL="";
                            $RSJOBOIL="";
                            $RSCNB="";
                            $RSVHCRG="";
                            $RSVHCT="";
                            $RSENGY="";
                            $RSOAM="";
                            $RSMST="";
                            $RSMLE="";
                            $RSDTE="";
                            $RSOAVG="";
                            $RSOTG="";
                            $RSC3="";
                            $RSCALOAM="";
                        }
                    
        $tbody3 .= '<tr>
                        <td align="center" style="border:1px solid #000;">'.$i.'</td>
                        <td align="center" style="border:1px solid #000;">'.$RSCONREFUEL.'</td>
                        <td align="center" style="border:1px solid #000;">'.$CTMC.'</td>
                        <td align="center" style="border:1px solid #000;">'.$JNST.'</td>
                        <td align="center" style="border:1px solid #000;">'.$JNED.'</td>
                        <td align="center" style="border:1px solid #000;">'.$JOBNOPLAN.'</td>
                        <td align="center" style="border:1px solid #000;">'.$RSJOBOIL.'</td>
                        <td align="center" style="border:1px solid #000;">'.$EMP1.'</td>
                        <td align="left" style="border:1px solid #000;">'.$EMPN1.'</td>
                        <td align="center" style="border:1px solid #000;">'.$EMP2.'</td>
                        <td align="left" style="border:1px solid #000;">'.$EMPN2.'</td>
                        <td align="center" style="border:1px solid #000;">'.$OBLNB.'</td>
                        <td align="center" style="border:1px solid #000;">'.$RSCNB.'</td>
                        <td align="center" style="border:1px solid #000;">'.$RSVHCRG.'</td>
                        <td align="center" style="border:1px solid #000;">'.$RSVHCT.'</td>
                        <td align="center" style="border:1px solid #000;">'.$RSENGY.'</td>
                        <td align="right" style="border:1px solid #000;">'.$RSMST.'</td>
                        <td align="right" style="border:1px solid #000;">'.$RSMLE.'</td>
                        <td align="right" style="border:1px solid #000;">'.$RSDTE.'</td>
                        <td align="right" style="border:1px solid #000;">'.$RSOAM.'</td>
                        <td align="right" style="border:1px solid #000;">'.$RSOTG.'</td>
                        <td align="right" style="border:1px solid #000;">'.$RSOAVG.'</td>
                        <td align="right" style="border:1px solid #000;">'.$RSCALOAM.'</td>
                        <td align="right" style="border:1px solid #000;">'.$RSC3.'</td>
                        <td align="right" style="border:1px solid #000;"></td>
                    </tr>';                 
                    $i++; } } }
                    $TOTALDTE=$QRDTE;
                    $TOTALOAM=$QROAM;  
                    $TOTALCALOAM=$QRCALOAM;  
                    $TOTALC3=$QRC3;
                    function Average($arr) {
                        $array_size = count($arr);                
                        $total = 0;
                        for ($i = 0; $i < $array_size; $i++) {
                            $total += $arr[$i];
                        }                
                        $AVERAGETEST = (float)($total / $array_size);
                        return $AVERAGETEST;
                    }
        $tfoot3 = '</tbody><tfoot>
            <tr>
                <td colspan="18" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE, 2).'</td>
                <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM, 2).'</td>
                <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average($arr), 2).'</td>
                <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM, 2).'</td>
                <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALC3, 2).'</td>
                <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
            </tr></tfoot>';

        $table_end3 = '</table>';

        $table_footer3 = '<table style="width: 100%;">
            <tbody>
            <tr>
            <td colspan="4">&nbsp;&nbsp;&nbsp; แก้ไขครั้งที่:01&nbsp;&nbsp;&nbsp;มีผลบังคับใช้:06-02-66</td>
            </tr>
            </tbody>
        </table>';
    }else {
        $table_begin3 = '<table style="border-collapse: collapse;font-size:13px" width="100%">';

        $thead3 = '<thead>
                        <tr>
                            <td rowspan="1" style="background-color: #bfbfbf;width:5%;border:1px solid #000;padding:3px;text-align:center">ลำดับ</td>
                            <td rowspan="1" style="background-color: #bfbfbf;width:10%;border:1px solid #000;padding:3px;text-align:center">วันที่เติมน้ำมัน</div></td>
                            <td rowspan="1" style="background-color: #bfbfbf;width:5%;border:1px solid #000;padding:3px;text-align:center">สังกัดบริษัท</div></td>
                            <td rowspan="1" style="background-color: #bfbfbf;width:10%;border:1px solid #000;padding:3px;text-align:center">Job No จากน้ำมัน</div></td>
                            <td rowspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">หมายเลขบิลน้ำมัน</div></td>
                            <td rowspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">เลขบัตรเติมน้ำมัน</div></td>
                            <td rowspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">ทะเบียนรถ</div></td>
                            <td rowspan="1" style="background-color: #bfbfbf;width: 10%;border:1px solid #000;padding:3px;text-align:center">ประเภทรถ</div></td>
                            <td rowspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">น้ำมัน</div></td>
                            <td rowspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">เลขไมล์ต้น</div></td>
                            <td rowspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">เลขไมล์ปลาย</div></td>
                            <td rowspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">ระยะทาง</div></td>
                            <td rowspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">จำนวนลิตร</div></td>
                            <td rowspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">ค่าเฉลี่ยที่กำหนด</div></td>
                            <td rowspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">ค่าเฉลี่ยที่ได้</div></td>
                            <td rowspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">จำนวนน้ำมันเกินกว่ากำหนด</div></td>
                            <td rowspan="1" style="background-color: #bfbfbf;width: 5%;border:1px solid #000;padding:3px;text-align:center">หมายเหตุ</div></td>
                        </tr>
                    </thead><tbody>';

                    $i = 1;
                    while($row = sqlsrv_fetch_array($result)) {                             
                        $OILID=$row["OILID"];         
                        $REFUEL=$row["REFUEL"];                             
                        $CRF = explode("-", $REFUEL);
                        $DT1 = $CRF[0];
                        $DT2 = $CRF[1];
                        $DT3 = $CRF[2]; 
                        $CONREFUEL = $DT3.'/'.$DT2.'/'.$DT1; 
                        $JN1=$row["JN1"];                     
                        $OBLNB=$row["OBLNB"];   
                        $CNB=$row["CNB"]; 
                        $VHCRG=$row["VHCRG"];                  
                        $VHCT=$row["VHCT"];                  
                        $ENGY=$row["ENGY"];                  
                        $OAM=$row["OAM"];                  
                        $MST=$row["MST"];                
                        $MLE=$row["MLE"];                  
                        $DTE=$row["DTE"];                       
                        $OAVG=$row["OAVG"];                     
                        $OTG=$row["OTG"];                 
                        $AFCP=$row["AFCP"];            
                        $CALOAM=(($DTE/$OAM)-$OTG);
                        $RSCALOAM=number_format($CALOAM, 2);
                            
                        $RDTE=$row["DTE"];    
                            $QRDTE=$QRDTE+$RDTE;       
                        $ROAM=$row["OAM"];    
                            $QROAM=$QROAM+$ROAM;     
                        $ROTG=$row["OTG"]; 
                        
                        $QCALOAM=(($RDTE/$ROAM)-$ROTG);     
                        $QRCALOAM=$QRCALOAM+$QCALOAM;   

                        $arr[] = $row["OAVG"];         
                        
                    
        $tbody3 .= '<tr>
                        <td align="center" style="border:1px solid #000;">'.$i.'</td>
                        <td align="center" style="border:1px solid #000;">'.$CONREFUEL.'</td>
                        <td align="center" style="border:1px solid #000;">'.$AFCP.'</td>
                        <td align="center" style="border:1px solid #000;">'.$JN1.'</td>
                        <td align="center" style="border:1px solid #000;">'.$OBLNB.'</td>
                        <td align="center" style="border:1px solid #000;">'.$CNB.'</td>
                        <td align="center" style="border:1px solid #000;">'.$VHCRG.'</td>
                        <td align="center" style="border:1px solid #000;">'.$VHCT.'</td>
                        <td align="center" style="border:1px solid #000;">'.$ENGY.'</td>
                        <td align="right" style="border:1px solid #000;">'.$MST.'</td>
                        <td align="right" style="border:1px solid #000;">'.$MLE.'</td>
                        <td align="right" style="border:1px solid #000;">'.$RDTE.'</td>
                        <td align="right" style="border:1px solid #000;">'.$ROAM.'</td>
                        <td align="right" style="border:1px solid #000;">'.$ROTG.'</td>
                        <td align="right" style="border:1px solid #000;">'.$OAVG.'</td>
                        <td align="right" style="border:1px solid #000;">'.$RSCALOAM.'</td>
                        <td align="right" style="border:1px solid #000;"></td>
                    </tr>';                 
                    $i++; } 
                    $TOTALDTE=$QRDTE;
                    $TOTALOAM=$QROAM;  
                    $TOTALCALOAM=$QRCALOAM;  
                    function Average($arr) {
                        $array_size = count($arr);                
                        $total = 0;
                        for ($i = 0; $i < $array_size; $i++) {
                            $total += $arr[$i];
                        }                
                        $AVERAGETEST = (float)($total / $array_size);
                        return $AVERAGETEST;
                    }
        $tfoot3 = '</tbody><tfoot>
            <tr>
                <td colspan="11" style="border:1px solid #000;text-align:right;font-size:13px;">รวม </td>
                <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALDTE, 2).'</td>
                <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALOAM, 2).'</td>
                <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
                <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format(Average($arr), 2).'</td>
                <td style="border:1px solid #000;text-align:right;font-size:13px;">'.number_format($TOTALCALOAM, 2).'</td>
                <td style="border:1px solid #000;text-align:right;font-size:13px;"></td>
            </tr></tfoot>';

        $table_end3 = '</table>';

        $table_footer3 = '<table style="width: 100%;">
            <tbody>
            <tr>
            <td colspan="4">&nbsp;&nbsp;&nbsp; แก้ไขครั้งที่:01&nbsp;&nbsp;&nbsp;มีผลบังคับใช้:06-02-66</td>
            </tr>
            </tbody>
        </table>';

    }
    $mpdf->WriteHTML($style);
    $mpdf->SetHTMLHeader($table_header3, 'O', true);
    $mpdf->WriteHTML($table_begin3);
    $mpdf->WriteHTML($thead3);
    $mpdf->WriteHTML($tbody3);
    $mpdf->WriteHTML($tfoot3);
    $mpdf->WriteHTML($table_end3);
    // $mpdf->WriteHTML($table_footer3);
    $mpdf->SetHTMLFooter($table_footer3);
    $mpdf->Output();

    sqlsrv_close($conn);
}else{
    echo "<h1>ไม่มีข้อมูล</h1>";
} ?>