<?php
    // echo"<pre>";
    // print_r($_POST);
    // echo"</pre>";
    // exit();

    $EXCEL=$_POST['EXCEL'];
    $PDF=$_POST['PDF'];
    $SORTBY=$_POST["SORTBY"];    
    if($SORTBY=='DATEPLAN'){
        $SORTQUERY='VHCTPP.DATEWORKING';        
    }else if($SORTBY=='DATEREFUEL'){
        $SORTQUERY='OTSN.REFUELINGDATE';  
    }
    $LINEOFWORK=$_POST["lineofwork2"]; 
    if($LINEOFWORK!=""){
        if($LINEOFWORK == 'CS'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%CS%'";
        }else if($LINEOFWORK == 'TTKN'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%T-Tohken%'";
        }else if($LINEOFWORK == 'SMIP'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%STM-IP%'";
        }else if($LINEOFWORK == 'KBT'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%KUBOTA%'";
        }else if($LINEOFWORK == 'TTDK'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%TGT%'";
        }else if($LINEOFWORK == 'SRTW'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%STM-SR%'";
        }else if($LINEOFWORK == 'SC10'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%พนักงานขับรถ%' AND EHR.Company_Code = 'RKR' AND NOT EHR.PositionNameT IN ('พนักงานขับรถ/CS','พนักงานขับรถ/RKL-STC')";
        }else if($LINEOFWORK == 'SCCL'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%พนักงานขับรถ/RKL-STC%' AND EHR.Company_Code = 'RKL' ";
        }
    }else{
        $QUERYWHERE1="OTSN.JOBNO != ''";
    }

    // echo"<pre>";
    // print_r($_POST);
    // echo"<br>";
    // print_r($LINEOFWORK);
    // echo"<br>";
    // print_r($QUERYWHERE1);
    // echo"</pre>";
    // exit();

    $date1 = $_POST["txt_datestartoil"];
    $start = explode("/", $date1);
    $startd = $start[0];
    $startif = $start[1];
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
    $starty = $start[2]+543;
    $startymd = $start[2].'-'.$start[1].'-'.$start[0];

    $date2 = $_POST["txt_dateendoil"];
    $end = explode("/", $date2);
    $endd = $end[0];
    $endif = $end[1];
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
    $endy = $end[2]+543;
    $endymd = $end[2].'-'.$end[1].'-'.$end[0];

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
    
    if($date3 == "ALL"){
        $sql = "SELECT
            DISTINCT
            OTSN.OILDATAID OILID,
            CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
            OTSN.JOBNO JN1,
            VHCTPP.EMPLOYEECODE1 EMP1,
            VHCTPP.EMPLOYEENAME1 EMPN1,
            VHCTPP.EMPLOYEECODE2 EMP2,
            VHCTPP.EMPLOYEENAME2 EMPN2,
            EHR.PositionNameT,
            CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) WORK,
            OTSN.OIL_BILLNUMBER OBLNB,
            OTSN.CARDNUMBER CNB,
            OTSN.VEHICLEREGISNUMBER VHCRG,
            OTSN.VEHICLETYPE VHCT,
            VHCTPP.VEHICLETYPE VHCTPLAN,
            VHCIF.ENERGY ENGY,
            OTSN.OIL_AMOUNT,
            (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID) + OIL_AMOUNT AS OAM,
            OTSN.MILEAGESTART MST,
            OTSN.MILEAGEEND MLE,
            OTSN.DISTANCE DTE,
            OTSN.OIL_AVERAGE OAVG,
            OTSN.OIL_TARGET OTG,
            VHCTPP.C3,
            VHCTPP.E1
        FROM TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN
        LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
        LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
        LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
        LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
        LEFT JOIN EMPLOYEEEHR2 EHR ON EHR.nameT = VHCTPP.EMPLOYEENAME1
        WHERE OTSN.JOBNO IS NOT NULL
        AND VHCTPP.COMPANYCODE != 'RRC' AND VHCTPP.COMPANYCODE != 'RATC' AND VHCTPP.COMPANYCODE != 'RCC'
        AND $QUERYWHERE1
        AND CONVERT(VARCHAR (10),$SORTQUERY,20) BETWEEN '$startymd' AND '$endymd'
        ORDER BY VHCTPP.EMPLOYEECODE1 ASC";                                                
        $query = sqlsrv_query($conn, $sql );
        $resultid = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
        $result = sqlsrv_query($conn, $sql );        
    }else if(($date3 == "CENTER")&&($date3 != "ALL")&&($date4 == "ALL")){
        $sql = "SELECT  
        DISTINCT          
                OTSN.OILDATAID OILID,
                CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                OTSN.JOBNO JN1,
                OTSN.OIL_BILLNUMBER OBLNB,
                OTSN.CARDNUMBER CNB,
                OTSN.VEHICLEREGISNUMBER VHCRG,
                OTSN.VEHICLETYPE VHCT,
                VHCIF.ENERGY ENGY,
                OTSN.OIL_AMOUNT,
                (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID) + OIL_AMOUNT AS OAM,
                OTSN.MILEAGESTART MST,
                OTSN.MILEAGEEND MLE,
                OTSN.DISTANCE DTE,
                OTSN.OIL_AVERAGE OAVG,
                OTSN.OIL_TARGET OTG,
                VHCIF.AFFCOMPANY AFCP
            FROM TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN
            LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
            WHERE VHCIF.VEHICLEGROUPCODE = 'VG-1403-0755'
            AND VHCIF.AFFCOMPANY != 'RRC' AND VHCIF.AFFCOMPANY != 'RATC' AND VHCIF.AFFCOMPANY != 'RCC'
            -- AND VHCIF.AFFCOMPANY != 'RKR' AND VHCIF.AFFCOMPANY != 'RKS' AND VHCIF.AFFCOMPANY != 'RKL' AND VHCIF.AFFCOMPANY != 'RTD'
            AND CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) BETWEEN '$startymd' AND '$endymd'
            ORDER BY CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) ASC";                                                
        $query = sqlsrv_query($conn, $sql );
        $resultid = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
        $result = sqlsrv_query($conn, $sql );        
    }else if(($date3 != "ALL")&&($date4 == "ALL")){
        $sql = "SELECT
            DISTINCT
            OTSN.OILDATAID OILID,
            CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
            OTSN.JOBNO JN1,
            VHCTPP.EMPLOYEECODE1 EMP1,
            VHCTPP.EMPLOYEENAME1 EMPN1,
            VHCTPP.EMPLOYEECODE2 EMP2,
            VHCTPP.EMPLOYEENAME2 EMPN2,
            EHR.PositionNameT,
            CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) WORK,
            OTSN.OIL_BILLNUMBER OBLNB,
            OTSN.CARDNUMBER CNB,
            OTSN.VEHICLEREGISNUMBER VHCRG,
            OTSN.VEHICLETYPE VHCT,
            VHCTPP.VEHICLETYPE VHCTPLAN,
            VHCIF.ENERGY ENGY,
            OTSN.OIL_AMOUNT,
            (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID) + OIL_AMOUNT AS OAM,
            OTSN.MILEAGESTART MST,
            OTSN.MILEAGEEND MLE,
            OTSN.DISTANCE DTE,
            OTSN.OIL_AVERAGE OAVG,
            OTSN.OIL_TARGET OTG,
            VHCTPP.C3,
            VHCTPP.E1
        FROM TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN
        LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
        LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
        LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
        LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
        LEFT JOIN EMPLOYEEEHR2 EHR ON EHR.nameT = VHCTPP.EMPLOYEENAME1
        WHERE OTSN.JOBNO IS NOT NULL
        AND $QUERYWHERE1
        AND VHCTPP.COMPANYCODE = '$date3'
        AND CONVERT(VARCHAR (10),$SORTQUERY,20) BETWEEN '$startymd' AND '$endymd'
        ORDER BY VHCTPP.EMPLOYEECODE1 ASC";                                                
        $query = sqlsrv_query($conn, $sql );
        $resultid = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
        $result = sqlsrv_query($conn, $sql );          
    }else{
        $sql = "SELECT
            DISTINCT
            OTSN.OILDATAID OILID,
            CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
            OTSN.JOBNO JN1,
            VHCTPP.EMPLOYEECODE1 EMP1,
            VHCTPP.EMPLOYEENAME1 EMPN1,
            VHCTPP.EMPLOYEECODE2 EMP2,
            VHCTPP.EMPLOYEENAME2 EMPN2,
            EHR.PositionNameT,
            CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) WORK,
            OTSN.OIL_BILLNUMBER OBLNB,
            OTSN.CARDNUMBER CNB,
            OTSN.VEHICLEREGISNUMBER VHCRG,
            OTSN.VEHICLETYPE VHCT,
            VHCTPP.VEHICLETYPE VHCTPLAN,
            VHCIF.ENERGY ENGY,
            OTSN.OIL_AMOUNT,
            (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) AS OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VHCTPP.VEHICLETRANSPORTPLANID) + OIL_AMOUNT AS OAM,
            OTSN.MILEAGESTART MST,
            OTSN.MILEAGEEND MLE,
            OTSN.DISTANCE DTE,
            OTSN.OIL_AVERAGE OAVG,
            OTSN.OIL_TARGET OTG,
            VHCTPP.C3,
            VHCTPP.E1
        FROM TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN
        LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
        LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
        LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
        LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
        LEFT JOIN EMPLOYEEEHR2 EHR ON EHR.nameT = VHCTPP.EMPLOYEENAME1
        WHERE OTSN.JOBNO IS NOT NULL
        AND $QUERYWHERE1
        AND VHCTPP.COMPANYCODE = '$date3'
        AND VHCTPP.CUSTOMERCODE = '$date4'
        AND CONVERT(VARCHAR (10),$SORTQUERY,20) BETWEEN '$startymd' AND '$endymd'
        ORDER BY VHCTPP.EMPLOYEECODE1 ASC";                                                
        $query = sqlsrv_query($conn, $sql );
        $resultid = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
        $result = sqlsrv_query($conn, $sql );        
    }
    
if ($EXCEL != "" && $resultid["OILID"] != "") { ?>
    <?php
        $RENAME= "รายงานรายละเอียดการเติมน้ำมัน (AMT)";
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$RENAME.xls");
        header("Pragma: no-cache");
        header("Expires: ");
    ?>       
    <div class="wrapper">
        <section class="invoice">
            <h3><u><b>รายงานรายละเอียดการเติมน้ำมัน (AMT)</b></u></h3><br>            
            <p>รายงาน ตั้งแต่วันที่ <b><?=$startd.' '.$startm.' '.$starty;?></b> ถึงวันที่ <b><?=$endd.' '.$endm.' '.$endy;?></b></p>
            <?php if($date3 != "CENTER"){ ?>
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
                            <th rowspan="2" style="background-color: #bfbfbf"><div align="center">ทะเบียนรถ</div></th>
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
                            $OAVG=$DTE/$OAM;                     
                            // $OAVG=$row["OAVG"];                     
                            $OTG=$row["OTG"];                 
                            $C3=$row["C3"];                   
                            $E1=$row["E1"];                   
                            
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
                        
                            $SQLCHKOAVG="SELECT DISTINCT OILAVERAGE.OILAVERAGE OAVR
                            FROM OILAVERAGE 
                            WHERE OILAVERAGE.COMPANYCODE = '$CMPNC'
                            AND OILAVERAGE.CUSTOMERCODE = '$CTMC'
                            AND OILAVERAGE.VEHICLETYPE = '$VHCTPLAN'";
                            $QUERYCHKOAVG = sqlsrv_query($conn, $SQLCHKOAVG );
                            while($RSCHKOAVG = sqlsrv_fetch_array($QUERYCHKOAVG)) { 
                                if ($VHCRG =='61-4454'||$VHCRG =='61-4456'||$VHCRG =='61-3440'||$VHCRG =='61-3441'||$VHCRG =='61-4453'||$VHCRG =='61-4457'||$VHCRG =='61-4912'||$VHCRG =='61-4913'||$VHCRG =='61-4546'||$VHCRG =='61-4547'||$VHCRG =='64-3452'||$VHCRG =='61-3445'||$VHCRG =='61-3439'||$VHCRG =='61-3443'||$VHCRG =='61-3834'||$VHCRG =='61-3835'||$VHCRG =='61-3438'||$VHCRG =='61-3437'||$VHCRG =='62-9288'||$VHCRG =='61-3836'||$VHCRG =='61-4458'||$VHCRG =='61-3444'||$VHCRG =='60-3868'||$VHCRG =='60-3870'||$VHCRG =='61-3437'||$VHCRG =='61-3452') {
                                    $OAVR = 4.0;    
                                }else if($VHCRG =='60-3871'||$VHCRG =='61-3442'||$VHCRG =='60-2391'||$VHCRG =='61-3444'||$VHCRG =='76-8919'||$VHCRG =='61-4458'||$VHCRG =='79-2521'||$VHCRG =='79-2522'||$VHCRG =='79-2525'||$VHCRG =='74-5653'||$VHCRG =='74-5684'||$VHCRG =='74-5684'||$VHCRG =='74-5654') {
                                    $OAVR = 3.5;  
                                }else{
                                    $OAVR = $RSCHKOAVG["OAVR"];
                                }
                                // $OAVR=$RSCHKOAVG["OAVR"];

                            $RDTE=$row["DTE"];    $QRDTE=$QRDTE+$RDTE;       
                            $ROAM=$row["OAM"];    $QROAM=$QROAM+$ROAM;     
                            $ROTG=$RSCHKOAVG["OAVR"]; 
                            $QCALOAM=(($RDTE/$ROAM)-$ROTG);     
                            $QRCALOAM=$QRCALOAM+$QCALOAM;   
                            $RC3=$row["C3"];  
                            if($EMP2 != ""){                                        
                                if($EMP2==$EMP1){    
                                    $IFRC3=round($RC3); 
                                }else if($EMP2!=$EMP1){
                                    if( ($CTMC == 'SKB') || (($JNED=="TAKANO")||($JNED=="KEIHIN")||($JNED=="KEIHIN,TAKANO")||($JNED=="INGY")||($JNED=="BJKC + INGY")) ){    
                                        $IFRC3=round($RC3 / 2); 
                                    }else{    
                                        $IFRC3=round($RC3); 
                                    }
                                }
                            }else{    
                                $IFRC3=round($RC3); 
                            }  
                            $QRC3=$QRC3+$IFRC3;   
                            $arr[] = $row["OAVG"]; 

                            if($JN1==$JOBNOPLAN){
                                $RSCONREFUEL=$CONREFUEL;
                                $RSJOBOIL=$JN1;
                                $RSCNB=$CNB;
                                $RSVHCRG=$VHCRG;
                                $RSVHCT=$VHCT;
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
                        ?>
                            <tr>
                                <td align="center"><?=$i;?></td>
                                <td align="center"><?=$RSCONREFUEL;?></td>
                                <td align="center"><?=$CTMC;?></td>
                                <td align="center"><?=$JNST;?></td>
                                <td align="center"><?=$JNED;?></td>
                                <td align="center"><?=$JOBNOPLAN;?></td>
                                <td align="center"><?=$RSJOBOIL;?></td>
                                <td align="center"> <?=$EMP1;?></td>
                                <td align="left"><?=$EMPN1;?></td>
                                <td align="center"><?=$EMP2;?></td>
                                <td align="left"> <?=$EMPN2;?></td>
                                <td align="center"><?=$OBLNB;?></td>
                                <td align="center"><?=$RSCNB;?></td>
                                <td align="center"><?=$RSVHCRG;?></td>
                                <td align="center"><?=$RSVHCT;?></td>
                                <td align="center"><?=$RSENGY;?></td>
                                <td align="right"><?=$RSMST;?></td>
                                <td align="right"><?=$RSMLE;?></td>
                                <td align="right"><?=$RSDTE;?></td>
                                <td align="right"><?=$RSOAM;?></td>
                                <td align="right"><?=$RSOTG;?></td>
                                <td align="right"><?=$RSOAVG;?></td>
                                <td align="right"><?=$RSCALOAM;?></td>
                                <td align="right"><?=$RSC3;?></td>
                                <td align="right"></td>
                            </tr>    
                        <?php 
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
                        ?>                                                         
                    </tbody>
                    <tfoot>
                        <td colspan="18" style="text-align:right;">รวม </td>
                        <td style="text-align:right;"><?=number_format($TOTALDTE, 2)?></td>
                        <td style="text-align:right;"><?=number_format($TOTALOAM, 2)?></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"><?=number_format(Average($arr), 2)?></td>
                        <td style="text-align:right;"><?=number_format($TOTALCALOAM, 2)?></td>
                        <td style="text-align:right;"><?=number_format($TOTALC3, 2)?></td>
                        <td style="text-align:right;"></td>                    
                    </tfoot>
                </table>   
            <?php }else { ?>
                <table id="NoExtention1" class="table table-bordered " style="font-size: 13px;" border="1" width="100%">
                    <thead>
                        <tr>
                            <th rowspan="1" style="background-color: #bfbfbf"><div align="center">ลำดับ</div></th>
                            <th rowspan="1" style="background-color: #bfbfbf"><div align="center">วันที่เติมน้ำมัน</div></th>
                            <th rowspan="1" style="background-color: #bfbfbf"><div align="center">สังกัดบริษัท</div></th>
                            <th rowspan="1" style="background-color: #bfbfbf"><div align="center">Job No จากน้ำมัน</div></th>
                            <th rowspan="1" style="background-color: #bfbfbf"><div align="center">หมายเลขบิลน้ำมัน</div></th>
                            <th rowspan="1" style="background-color: #bfbfbf"><div align="center">เลขบัตรเติมน้ำมัน</div></th>
                            <th rowspan="1" style="background-color: #bfbfbf"><div align="center">ทะเบียนรถ</div></th>
                            <th rowspan="1" style="background-color: #bfbfbf"><div align="center">ประเภทรถ</div></th>
                            <th rowspan="1" style="background-color: #bfbfbf"><div align="center">น้ำมัน</div></th>
                            <th rowspan="1" style="background-color: #bfbfbf"><div align="center">เลขไมล์ต้น</div></th>
                            <th rowspan="1" style="background-color: #bfbfbf"><div align="center">เลขไมล์ปลาย</div></th>
                            <th rowspan="1" style="background-color: #bfbfbf"><div align="center">ระยะทาง</div></th>
                            <th rowspan="1" style="background-color: #bfbfbf"><div align="center">จำนวนลิตร</div></th>
                            <th rowspan="1" style="background-color: #bfbfbf"><div align="center">ค่าเฉลี่ยที่กำหนด</div></th>
                            <th rowspan="1" style="background-color: #bfbfbf"><div align="center">ค่าเฉลี่ยที่ได้</div></th>
                            <th rowspan="1" style="background-color: #bfbfbf"><div align="center">จำนวนน้ำมันเกินกว่ากำหนด</div></th>
                            <th rowspan="1" style="background-color: #bfbfbf"><div align="center">หมายเหตุ</div></th>
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
                            $OAVG=$DTE/$OAM;                     
                            // $OAVG=$row["OAVG"];                     
                            $OTG=$row["OTG"];                 
                            $AFCP=$row["AFCP"];            
                            // $CALOAM=(($DTE/$OAM)-$OTG);
                            // $CALOAM=(($RSDTE/$ROTG)-$RSOAM);
                            // $RSCALOAM=round(number_format($CALOAM, 2)); 
                                
                            $RDTE=$row["DTE"];    
                                $QRDTE=$QRDTE+$RDTE;       
                            $ROAM=$row["OAM"];    
                                $QROAM=$QROAM+$ROAM;     
                            $ROTG=$row["OTG"]; 
                            
                            $QCALOAM=(($RDTE/$ROAM)-$ROTG);     
                            $QRCALOAM=$QRCALOAM+$QCALOAM;   

                            $arr[] = $row["OAVG"]; 
                        ?>
                            <tr>
                                <td align="center"><?=$i;?></td>
                                <td align="center"><?=$CONREFUEL;?></td>
                                <td align="center"><?=$AFCP;?></td>
                                <td align="center"><?=$JN1;?></td>
                                <td align="center"><?=$OBLNB;?></td>
                                <td align="center"><?=$CNB;?></td>
                                <td align="center"><?=$VHCRG;?></td>
                                <td align="center"><?=$VHCT;?></td>
                                <td align="center"><?=$ENGY;?></td>
                                <td align="right"><?=$MST;?></td>
                                <td align="right"><?=$MLE;?></td>
                                <td align="right"><?=$RDTE;?></td>
                                <td align="right"><?=$ROAM;?></td>
                                <td align="right"><?=$ROTG;?></td>
                                <td align="right"><?=$OAVG;?></td>
                                <td align="right"><?=$RSCALOAM;?></td>
                                <td align="right"></td>
                            </tr>    
                        <?php 
                        $i++;
                            } 
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
                        ?>                                                         
                    </tbody>
                    <tfoot>
                        <td colspan="11" style="text-align:right;">รวม </td>
                        <td style="text-align:right;"><?=number_format($TOTALDTE, 2)?></td>
                        <td style="text-align:right;"><?=number_format($TOTALOAM, 2)?></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:right;"><?=number_format(Average($arr), 2)?></td>
                        <td style="text-align:right;"><?=number_format($TOTALCALOAM, 2)?></td>
                        <td style="text-align:right;"></td>                     
                    </tfoot>
                </table>   
            <?php } ?>       
        </section>
        <!-- /.content -->
    </div>
<?php }else if($PDF != "" && $resultid["OILID"] != "") {   
    // <td colspan="2" rowspan="4" style="text-align:center; "><img src="../images/logonew.png" width="70" height="70"></td>
    $mpdf = new mPDF('', 'A4-L', '', '', 15, 15,30);
    $style = '<style>body{font-family: "angsana";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย}</style>';

    $table_header3 = '<h3><u>รายงานรายละเอียดการเติมน้ำมัน (AMT)</u></h3>           
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
                        $OAVG=$DTE/$OAM;                     
                        // $OAVG=$row["OAVG"];                     
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
                        $RC3=$row["C3"];
                        if($EMP2 != ""){                                        
                            if($EMP2==$EMP1){    
                                $IFRC3=round($RC3); 
                            }else if($EMP2!=$EMP1){
                                if( ($CTMC == 'SKB') || (($JNED=="TAKANO")||($JNED=="KEIHIN")||($JNED=="KEIHIN,TAKANO")||($JNED=="INGY")||($JNED=="BJKC + INGY")) ){    
                                    $IFRC3=round($RC3 / 2); 
                                }else{    
                                    $IFRC3=round($RC3); 
                                }
                            }
                        }else{    
                            $IFRC3=round($RC3); 
                        }  
                        $QRC3=$QRC3+$IFRC3;   
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
                            // $RSENGY=$ENGY;
                            $RSENGY='ดีเซล';
                            $RSOAM=number_format($OAM, 2);
                            $RSMST=$MST;
                            $RSMLE=$MLE;
                            $RSDTE=number_format($DTE, 2);
                            $RSOAVG=number_format($OAVG, 2);
                            $RSOTG=number_format($OAVR, 2);   
                            $RSC3=round(number_format($IFRC3, 2)); 
                            // $CALOAM=(($DTE/$OAM)-$OTG);
                            $CALOAM=(($RSDTE/$ROTG)-$RSOAM);
                            $RSCALOAM=round(number_format($CALOAM, 2)); 
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
                        $OAVG=$DTE/$OAM;                     
                        // $OAVG=$row["OAVG"];                     
                        $OTG=$row["OTG"];                 
                        $AFCP=$row["AFCP"];           
                        // $CALOAM=(($DTE/$OAM)-$OTG);
                        $CALOAM=(($RSDTE/$ROTG)-$RSOAM);
                        $RSCALOAM=round(number_format($CALOAM, 2)); 
                            
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

}else{
    echo "<h1>ไม่มีข้อมูล</h1>";
} 
sqlsrv_close($conn);
?>



<?php
    
    
?>