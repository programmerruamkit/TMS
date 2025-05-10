<?php
    ob_start();
    session_start();
    date_default_timezone_set("Asia/Bangkok");
    require_once("../class/meg_function.php");
    ini_set('max_execution_time', 300); //300 seconds = 5 minutes
    $conn = connect("RTMS");

    // echo "โหลดข้อมูลล่าสุด : ".date("Y-m-d H:i:s");

    $realEMPLOYEECODE = $_GET["EMP"];
    $realNEWDATE = $_GET["DATE"];
    $realVHCTPPID = $_GET["VHCTPPID"];
    $realCOMPANYCODE = $_GET["COMPANYCODE"];
    if($realCOMPANYCODE == "RRC"){
        $findfield = "SCPT.VEHICLETRANSPORTPLANID = '$realVHCTPPID' AND ";
        $findfield2 = "AND VHCTPP.VEHICLETRANSPORTPLANID = '$realVHCTPPID'";
    }else{
        $findfield = "1=1 AND ";
        $findfield2 = "AND 1=1";
    }
    // echo '<br>';
    // echo $realEMPLOYEECODE;

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

    $sql = "SELECT
        DISTINCT
        VHCTPP.COMPANYCODE CMPNC,
        VHCTPP.CUSTOMERCODE CTMC,
        VHCTPP.EMPLOYEECODE1 EMP1,
        VHCTPP.EMPLOYEECODE2 EMP2,
        CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) WORK,
        VHCTPP.JOBSTART JNST,
        VHCTPP.JOBEND JNED,
        VHCTPP.JOBNO JN2,
        OTSN.JOBNO JN1,
        OTSN.VEHICLEREGISNUMBER VHCRG,
        VHCTPP.VEHICLETYPE VHCTPLAN,
        VHCTPP.ROUNDAMOUNT,
        VHCTPP.C2,
        VHCTPP.C3,
        OTSN.DISTANCE DTE,
        OTSN.OIL_AMOUNT OAM,
        VHCTPP.THAINAME,
        STUFF((SELECT '+'+ CAST(SCPT.JOBSTART AS VARCHAR)+'->'+ CAST(SCPT.JOBEND AS VARCHAR) FROM VEHICLETRANSPORTPLAN SCPT WHERE ".$findfield." SCPT.COMPANYCODE = VHCTPP.COMPANYCODE AND SCPT.EMPLOYEECODE1 = VHCTPP.EMPLOYEECODE1 AND CONVERT(VARCHAR(10),SCPT.DATEWORKING,20) = CONVERT(VARCHAR(10),VHCTPP.DATEWORKING,20) ORDER BY SCPT.ROUNDAMOUNT ASC FOR XML PATH(''), TYPE).value('.','VARCHAR(max)'), 1, 1, '') AS CHKJOBSTARTEND
        FROM TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN
        LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
        LEFT JOIN EMPLOYEEEHR2 EHR ON EHR.PersonCode = VHCTPP.EMPLOYEECODE1
        LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
        LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
        LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.VEHICLETRANSPORTPLANID = VHCTPP.VEHICLETRANSPORTPLANID
        WHERE OTSN.JOBNO IS NOT NULL AND OTSN.JOBNO != '' 
        AND NOT VHCTPP.COMPANYCODE IN('RKL','RKR','RKS')
        AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$realNEWDATE' AND (VHCTPP.EMPLOYEECODE1 = '$realEMPLOYEECODE' OR VHCTPP.EMPLOYEECODE2 = '$realEMPLOYEECODE') ".$findfield2."";                                                
    $query = sqlsrv_query($conn, $sql );
    $resultid = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    $result = sqlsrv_query($conn, $sql );    
    while($row = sqlsrv_fetch_array($result)) {   
        $EMP1=$row["EMP1"];                   
        $EMP2=$row["EMP2"];       
        $WORK=$row["WORK"];        
        $JN1=$row["JN1"]; 
        $VHCRG=$row["VHCRG"]; 
        $VHCTPLAN=$row["VHCTPLAN"];  
        $C2=$row["C2"];                   
        $C3=$row["C3"];                   
        $ROUNDAMOUNT=$row["ROUNDAMOUNT"]; 
        $CHKJOBSTARTEND=$row["CHKJOBSTARTEND"]; 
        $VHCTHAINAME=$row["THAINAME"];   

            $JOBNOPLAN=$row["JN2"];  
            $CMPNC=$row["CMPNC"];    
            $CTMC=$row["CTMC"];           
            $JNST=$row["JNST"];       
            $JNED=$row["JNED"];      

            $SQLROUND="SELECT COUNT(VHCTPP.EMPLOYEECODE1) AS ROUND FROM VEHICLETRANSPORTPLAN VHCTPP 
                WHERE VHCTPP.COMPANYCODE = '$CMPNC' AND (VHCTPP.EMPLOYEECODE1 = '$EMP1' OR VHCTPP.EMPLOYEECODE2 = '$EMP1') 
                AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) = '$WORK' GROUP BY VHCTPP.EMPLOYEECODE1 ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
            $QUERYROUND = sqlsrv_query($conn, $SQLROUND ); 
            $RSROUND = sqlsrv_fetch_array($QUERYROUND, SQLSRV_FETCH_ASSOC);   
                $ROUND=$RSROUND["ROUND"];      
                           
            $SQLCHKOAVG="SELECT DISTINCT OILAVERAGE.OILAVERAGE OAVR
                FROM OILAVERAGE 
                WHERE OILAVERAGE.COMPANYCODE = '$CMPNC'
                AND OILAVERAGE.CUSTOMERCODE = '$CTMC'
                AND OILAVERAGE.VEHICLETYPE = '$VHCTPLAN'";
            $QUERYCHKOAVG = sqlsrv_query($conn, $SQLCHKOAVG );
            $RSCHKOAVG = sqlsrv_fetch_array($QUERYCHKOAVG, SQLSRV_FETCH_ASSOC);  
                if ($VHCRG =='61-4454'||$VHCRG =='61-4456'||$VHCRG =='61-3440'||$VHCRG =='61-3441'||$VHCRG =='61-4453'||$VHCRG =='61-4457'||$VHCRG =='61-4912'||$VHCRG =='61-4913'||$VHCRG =='61-4546'||$VHCRG =='61-4547'||$VHCRG =='64-3452'||$VHCRG =='61-3445'||$VHCRG =='61-3439'||$VHCRG =='61-3443'||$VHCRG =='61-3834'||$VHCRG =='61-3835'||$VHCRG =='61-3438'||$VHCRG =='61-3437'||$VHCRG =='62-9288'||$VHCRG =='61-3836'||$VHCRG =='61-4458'||$VHCRG =='61-3444'||$VHCRG =='60-3868'||$VHCRG =='60-3870'||$VHCRG =='61-3437'||$VHCRG =='61-3452') {
                    $OAVR = 4.0;    
                }else if($VHCRG =='60-3871'||$VHCRG =='61-3442'||$VHCRG =='60-2391'||$VHCRG =='61-3444'||$VHCRG =='76-8919'||$VHCRG =='61-4458'||$VHCRG =='79-2521'||$VHCRG =='79-2522'||$VHCRG =='79-2525'||$VHCRG =='74-5653'||$VHCRG =='74-5684'||$VHCRG =='74-5684'||$VHCRG =='74-5654') {
                    $OAVR = 3.5;  
                }else{
                    $OAVR = $RSCHKOAVG["OAVR"]; 
                }

                $RDTE=$row["DTE"];    $QRDTE=$QRDTE+$RDTE;       
                $ROAM=$row["OAM"];    $QROAM=$QROAM+$ROAM;     
                $ROTG=$RSCHKOAVG["OAVR"]; 
                $QCALOAM=(($RDTE/$ROAM)-$ROTG);     
                $QRCALOAM=$QRCALOAM+$QCALOAM;   
                
                $RC3=$row["C3"];  
                // if($EMP2 != ""){                                        
                //     if($EMP2==$EMP1){    
                //         $IFRC3=round($RC3); 
                //     }else if($EMP2!=$EMP1){
                //         $IFRC3=round($RC3 / 2);                         
                //     }
                // }else{    
                    $IFRC3=$RC3;  
                    // $IFRC3=round($RC3);  
                    // $IFRC3=round($RC3 / 2);    
                // } 

                
                $RSCONREFUEL=$CONREFUEL;
                $RSJOBOIL=$JN1;
                $RSCNB=$CNB;
                $RSVHCRG=$VHCRG;
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
                                }else if($VHCTHAINAME=='R-401'||$VHCTHAINAME=='R-801'||$VHCTHAINAME=='R-802'||$VHCTHAINAME=='R-801(4L)'||$VHCTHAINAME=='R-802(4L)'){
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
                                }else if($VHCTHAINAME=='R-401'||$VHCTHAINAME=='R-801'||$VHCTHAINAME=='R-802'||$VHCTHAINAME=='R-801(4L)'||$VHCTHAINAME=='R-802(4L)'){
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
                                }else if($VHCTHAINAME=='R-401'||$VHCTHAINAME=='R-801'||$VHCTHAINAME=='R-802'||$VHCTHAINAME=='R-801(4L)'||$VHCTHAINAME=='R-802(4L)'){
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
                                 $JOBONE=='GMT 2->KIRIU'    ||$JOBONE=='GMT 2->KIRIU กรณีตีเปล่า'  ||$JOBONE=='GMT 2->TSMT สระบุรี'  ||$JOBONE=='GMT 2->GJ กรณีตีเปล่า' ||$JOBONE=='GMT 2->ICP2 กรณีตีเปล่า'){
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
                        }else if($VHCTHAINAME=='R-401'||$VHCTHAINAME=='R-801'||$VHCTHAINAME=='R-802'||$VHCTHAINAME=='R-801(4L)'||$VHCTHAINAME=='R-802(4L)'){
                            $MONEYTOTAL='0';
                            $REMARK='ไม่คิดเรทน้ำมัน';
                        }else if(($JOBONE=='โลหะกิจ->GMT 2')){
                            $MONEYTOTAL='0';
                            $REMARK='ไม่คิดเรทน้ำมัน';
                        }else if(($JOBONE=='CH รับพาเลทเปล่า->TTAST')){
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

                // if($JN1==$JOBNOPLAN){
                    $RSMONEYTOTAL=$RSMONEYTOTAL+$MONEYTOTAL;
                    $RSREMARK=$REMARK;
                // }else{
                //     $RSMONEYTOTAL=$RSMONEYTOTAL+"0";
                //     $RSREMARK="";
                // }                         
            } 
    // $CALRSMONEYTOTAL=$MONEYTOTAL; 
    if($MONEYTOTAL!=''){
        $CHK_MONEYTOTAL=$MONEYTOTAL;
    }else{
        $CHK_MONEYTOTAL='0';
    }
    $CALRSMONEYTOTAL=$CHK_MONEYTOTAL;                         
    echo $CALRSMONEYTOTAL;             
    // echo number_format($CALRSMONEYTOTAL,2); 

sqlsrv_close($conn);
?>