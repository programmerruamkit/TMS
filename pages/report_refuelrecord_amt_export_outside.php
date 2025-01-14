<?php
    // echo"<pre>";
    // print_r($_POST);
    // echo"</pre>";
    // exit();

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
    
    $EXCEL=$_POST['EXCELOUTSIDE'];
    
    $date1 = $_POST["txt_datestartoiloutside"];
    $start = explode("/", $date1);
    $startd = $start[0];
    $startif = $start[1];        
        if($startif=='01'){
            $selectmonth = "มกราคม";
        }else if($startif=='02'){
            $selectmonth = "กุมภาพันธ์";
        }else if($startif=='03'){
            $selectmonth = "มีนาคม";
        }else if($startif=='04'){
            $selectmonth = "เมษายน";
        }else if($startif=='05'){
            $selectmonth = "พฤษภาคม";
        }else if($startif=='06'){
            $selectmonth = "มิถุนายน";
        }else if($startif=='07'){
            $selectmonth = "กรกฎาคม";
        }else if($startif=='08'){
            $selectmonth = "สิงหาคม";
        }else if($startif=='09'){
            $selectmonth = "กันยายน";
        }else if($startif=='10'){
            $selectmonth = "ตุลาคม";
        }else if($startif=='11'){
            $selectmonth = "พฤศจิกายน";
        }else if($startif=='12'){
            $selectmonth = "ธันวาคม";
        }
    $start_yen = $start[2];
    $start_yth = $start[2]+543;
    $startymd = $start[2].'-'.$start[1].'-'.$start[0];
    
    $date2 = $_POST["txt_dateendoiloutside"];
    $end = explode("/", $date2);
    $endd = $end[0];
    $endif = $end[1];
        if($endif=='01'){
            $selectmonth = "มกราคม";
        }else if($endif=='02'){
            $selectmonth = "กุมภาพันธ์";
        }else if($endif=='03'){
            $selectmonth = "มีนาคม";
        }else if($endif=='04'){
            $selectmonth = "เมษายน";
        }else if($endif=='05'){
            $selectmonth = "พฤษภาคม";
        }else if($endif=='06'){
            $selectmonth = "มิถุนายน";
        }else if($endif=='07'){
            $selectmonth = "กรกฎาคม";
        }else if($endif=='08'){
            $selectmonth = "สิงหาคม";
        }else if($endif=='09'){
            $selectmonth = "กันยายน";
        }else if($endif=='10'){
            $selectmonth = "ตุลาคม";
        }else if($endif=='11'){
            $selectmonth = "พฤศจิกายน";
        }else if($endif=='12'){
            $selectmonth = "ธันวาคม";
        }
    $end_yen = $end[2];    
    $end_yth = $end[2]+543;
    $endymd = $end[2].'-'.$end[1].'-'.$end[0];
    
    // $dateout = $_POST["txt_dateoiloutside"];
    // $start = explode("-", $dateout);
    // $startd = 01;
    // $starty = $start[0]+543;
    // $startif = $start[1];
    //     if($startif == "01"){
    //         $startm = "ม.ค.";
    //     }else if($startif == "02"){
    //         $startm = "ก.พ.";
    //     }else if($startif == "03"){
    //         $startm = "มี.ค.";
    //     }else if($startif == "04"){
    //         $startm = "เม.ย.";
    //     }else if($startif == "05"){
    //         $startm = "พ.ค.";
    //     }else if($startif == "06"){
    //         $startm = "มิ.ย.";
    //     }else if($startif == "07"){
    //         $startm = "ก.ค.";
    //     }else if($startif == "08"){
    //         $startm = "ส.ค.";
    //     }else if($startif == "09"){
    //         $startm = "ก.ย.";
    //     }else if($startif == "10"){
    //         $startm = "ต.ค.";
    //     }else if($startif == "11"){
    //         $startm = "พ.ย.";
    //     }else if($startif == "12"){
    //         $startm = "ธ.ค.";
    //     }
    // $startymd = $start[1].'-'.$start[0].'-'.$startd;
    
    // $first_day = mktime(0, 0, 0, $start[1], 1, $start[0]);
    // $last_day = mktime(23, 59, 59, $start[1], date('t', $first_day), date('Y', $first_day));
    // $caldayofmount=date('d', $last_day);    
    // $end1=date('d', $last_day);
    // $end2=date('m', $last_day);
    // $end3=date('Y', $last_day);

    // $dateout2 = $end3.'-'.$end2.'-'.$end1;
    // $endd = $end1;
    // $endif = $end2;
    //     if($endif == "01"){
    //         $endm = "ม.ค.";
    //     }else if($endif == "02"){
    //         $endm = "ก.พ.";
    //     }else if($endif == "03"){
    //         $endm = "มี.ค.";
    //     }else if($endif == "04"){
    //         $endm = "เม.ย.";
    //     }else if($endif == "05"){
    //         $endm = "พ.ค.";
    //     }else if($endif == "06"){
    //         $endm = "มิ.ย.";
    //     }else if($endif == "07"){
    //         $endm = "ก.ค.";
    //     }else if($endif == "08"){
    //         $endm = "ส.ค.";
    //     }else if($endif == "09"){
    //         $endm = "ก.ย.";
    //     }else if($endif == "10"){
    //         $endm = "ต.ค.";
    //     }else if($endif == "11"){
    //         $endm = "พ.ย.";
    //     }else if($endif == "12"){
    //         $endm = "ธ.ค.";
    //     }
    // $endy = $end3+543;
    // $endymd = $end3.'-'.$end2.'-'.$end1;


if ($EXCEL != ""){ ?>
    <?php
        $RENAME= "ข้อมูลเติมน้ำมันปั๊มนอก (AMT) $startm $starty";
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$RENAME.xls");
        header("Pragma: no-cache");
        header("Expires: ");
    ?>       
    <div class="wrapper">
        <section class="invoice">
                <table class="table table-bordered " style="font-size: 20px;" border="0" width="100%">
                    <thead><tr><th colspan="12" style="background-color: #FFFFFF"><div align="center">รายงานข้อมูลเติมน้ำมันปั๊มนอก (AMT)</div></th></tr></thead>
                </table>  
                <table class="table table-bordered " style="font-size: 13px;" border="0" width="100%">
                    <thead><tr><th colspan="12" align="center" style="background-color: #FFFFFF">รายงาน ตั้งแต่วันที่ <b><?=$startd.' '.$selectmonth.' '.$start_yen;?></b> ถึงวันที่ <b><?=$endd.' '.$selectmonth.' '.$end_yen;?></b></th></tr></thead>
                </table>            
                <p></p>    
                <p></p>
                <table class="table table-bordered " style="font-size: 13px;" border="1" width="100%">
                    <thead>
                        <tr>
                            <th rowspan="2" style="background-color: #C6E0B4"><div align="center">NO</div></th>
                            <th rowspan="2" style="background-color: #C6E0B4"><div align="center">DATE REFUEL</div></th>
                            <th rowspan="2" style="background-color: #C6E0B4"><div align="center">TRUCK NO</div></th>
                            <th rowspan="2" style="background-color: #C6E0B4"><div align="center">SECTION</div></th>
                            <th rowspan="1" colspan="8" style="background-color: #C6E0B4"><div align="center">รายละเอียดการเติมน้ำมัน</div></th>
                        </tr>
                        <tr>
                                <th colspan="1" style="background-color: #C6E0B4"><div align="center">เลขที่เอกสาร</div></th>
                                <th colspan="1" style="background-color: #C6E0B4"><div align="center">ลิตร</div></th>
                                <th colspan="1" style="background-color: #C6E0B4"><div align="center">ราคา</div></th>
                                <th colspan="1" style="background-color: #C6E0B4"><div align="center">จำนวนเงิน</div></th>
                                <th colspan="1" style="background-color: #C6E0B4"><div align="center">ประเภทการเติม</div></th>
                                <th colspan="1" style="background-color: #C6E0B4"><div align="center">ชื่อ พขร.1</div></th>
                                <th colspan="1" style="background-color: #C6E0B4"><div align="center">ชื่อ พขร.2</div></th>
                                <th colspan="1" style="background-color: #C6E0B4"><div align="center">รูทงาน</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $i = 1;
                            // $SQL_CENTER = "SELECT OSGS_ID,OSGS_PLID,OSGS_TY,CONVERT (VARCHAR (10),OSGS_DRF,20) OSGS_DRF,OSGS_BL,OSGS_AM,OSGS_PAY,OSGS_RM,OSGS_VHCRG,
                            $SQL_CENTER = "SELECT OSGS_ID,OSGS_PLID,OSGS_TY,CONVERT (VARCHAR (10),OSGS_DRF,20) OSGS_DRF,OSGS_BL,OSGS_AM,OSGS_PAY,OSGS_RM,THAINAME OSGS_VHCRG,
                            EMPLOYEECODE1,EMPLOYEENAME1,EMPLOYEECODE2,EMPLOYEENAME2,COMPANYCODE,DATEWORKING,PositionNameT,CLUSTER,
                            ROW_NUMBER() OVER (PARTITION BY OSGS_PLID ORDER BY OSGS_ID ASC) AS 'ROWNUM'
                                FROM
                                    dbo.OUTSIDE_GAS_STATION
                                    LEFT JOIN VEHICLETRANSPORTPLAN ON VEHICLETRANSPORTPLAN.VEHICLETRANSPORTPLANID = OUTSIDE_GAS_STATION.OSGS_PLID
                                    LEFT JOIN EMPLOYEEEHR2 ON EMPLOYEEEHR2.PersonCode = VEHICLETRANSPORTPLAN.EMPLOYEECODE1
                                WHERE
                                OSGS_DRF BETWEEN '$startymd' AND '$endymd' AND NOT OSGS_TY IN('3','4') AND NOT OSGS_AM = '' 
                                AND COMPANYCODE != 'RRC' AND COMPANYCODE != 'RATC' AND COMPANYCODE != 'RCC'
                                ORDER BY OSGS_DRF,PositionNameT ASC";
                            $QUERY_CENTER = sqlsrv_query($conn, $SQL_CENTER );     
                            while($RS_CENTER = sqlsrv_fetch_array($QUERY_CENTER)) { 
                                $OSGS_VHCRG = $RS_CENTER["OSGS_VHCRG"];
                                $OSGS_ID = $RS_CENTER["OSGS_ID"];
                                $OSGS_PLID = $RS_CENTER["OSGS_PLID"];
                                $OSGS_TY = $RS_CENTER["OSGS_TY"];
                                $OSGS_DRF = $RS_CENTER["OSGS_DRF"];
                                $OSGS_BL = $RS_CENTER["OSGS_BL"];
                                $OSGS_AM = $RS_CENTER["OSGS_AM"];
                                $OSGS_PAY = $RS_CENTER["OSGS_PAY"];
                                $OSGS_RM = $RS_CENTER["OSGS_RM"];
                                $EMPLOYEECODE1 = $RS_CENTER["EMPLOYEECODE1"];
                                $EMPLOYEENAME1 = $RS_CENTER["EMPLOYEENAME1"];
                                $EMPLOYEECODE2 = $RS_CENTER["EMPLOYEECODE2"];
                                $EMPLOYEENAME2 = $RS_CENTER["EMPLOYEENAME2"];
                                $CLUSTER = $RS_CENTER["CLUSTER"];
                                $DATEWORKING = $RS_CENTER["DATEWORKING"];
                                $PositionNameT = $RS_CENTER["PositionNameT"];
                                $ROWNUM = $RS_CENTER["ROWNUM"];

                                if($OSGS_TY==1){
                                    $RSOSGS_TY="เงินสด";
                                }else if($OSGS_TY==2){
                                    $RSOSGS_TY="บัตร";
                                }else if($OSGS_TY==3){
                                    $RSOSGS_TY="บัตร+เงินสด";
                                }

                                $PSTN = explode("/", $PositionNameT);
                                $RSPSTN0 = $PSTN[0];
                                $RSPSTN1 = $PSTN[1];
                                
                                if($OSGS_ID==""){$CALPAY="";}else{$CALPAY=number_format($OSGS_PAY/$OSGS_AM, 2);}
                                if($ROWNUM>1){
                                    $i--;
                                    $NO = '';      
                                }else {
                                  $NO = $i;          
                                }

                        ?>
                            <tr>
                                <td align="center"><?=$NO;?></td>
                                <td align="center"><?=$OSGS_DRF;?></td>
                                <td align="center"><?=$OSGS_VHCRG;?></td>
                                <td align="center"><?=$RSPSTN1;?></td>
                                <?php                                
                                    $DRF = explode("-", $OSGS_DRF);
                                    $DRF0 = $DRF[0];
                                    $DRF1 = $DRF[1];
                                    $DRF2 = $DRF[2];
                                    if($DRF2 < 10){ $RSDRF2='0'.$DRF2; }else{ $RSDRF2=$DRF2; }
                                ?>
                                <td align="center" <?php if($OSGS_TY==1){echo 'style="background-color: #FFFF00"';}else if($OSGS_TY==2){echo 'style="background-color: #F79646"';}else if($OSGS_TY==3){echo 'style="background-color: #4BACC6"';} ?>><?=$OSGS_BL;?></td>
                                <td align="center" <?php if($OSGS_TY==1){echo 'style="background-color: #FFFF00"';}else if($OSGS_TY==2){echo 'style="background-color: #F79646"';}else if($OSGS_TY==3){echo 'style="background-color: #4BACC6"';} ?>><?=$OSGS_AM;?></td>
                                <td align="center" <?php if($OSGS_TY==1){echo 'style="background-color: #FFFF00"';}else if($OSGS_TY==2){echo 'style="background-color: #F79646"';}else if($OSGS_TY==3){echo 'style="background-color: #4BACC6"';} ?>><?=$CALPAY;?></td>
                                <td align="center" <?php if($OSGS_TY==1){echo 'style="background-color: #FFFF00"';}else if($OSGS_TY==2){echo 'style="background-color: #F79646"';}else if($OSGS_TY==3){echo 'style="background-color: #4BACC6"';} ?>><?=$OSGS_PAY;?></td>
                                <td align="center" <?php if($OSGS_TY==1){echo 'style="background-color: #FFFF00"';}else if($OSGS_TY==2){echo 'style="background-color: #F79646"';}else if($OSGS_TY==3){echo 'style="background-color: #4BACC6"';} ?>><?=$RSOSGS_TY;?></td>    
                                <td align="left"><?=$EMPLOYEENAME1;?></td>
                                <td align="left"><?=$EMPLOYEENAME2;?></td>
                                <td align="left"><?=$CLUSTER;?></td>
                                   <?php $QOSGS_AM=$QOSGS_AM+$OSGS_AM;$QOSGS_PAY=$QOSGS_PAY+$OSGS_PAY;eval('$QCALPAY=$QOSGS_PAY / $QOSGS_AM;'); ?>
                            </tr>  
                        <?php $i++; } ?>                                              
                    </tbody>
                    <tfoot>
                        <?php $TOTALQAMOUNT=$QOSGS_AM; $TOTALQPRICE=$QOSGS_PAY; $TOTALQPAY=$QCALPAY; ?>
                        <td colspan="5" style="background-color: #C6E0B4"><div align="right"><b>TOTAL </b></div></td>
                        <td align="center" style="background-color: #C6E0B4"><b><?=number_format($TOTALQAMOUNT, 2)?></b></td> 
                        <td align="center" style="background-color: #C6E0B4"><b><?=number_format($TOTALQPAY, 2)?></b></td> 
                        <td align="center" style="background-color: #C6E0B4"><b><?=number_format($TOTALQPRICE, 2)?></b></td> 
                        <td colspan="4" style="background-color: #C6E0B4"></td>     
                    </tfoot>
                </table>      
                <p></p>            
                <p></p>
                <table class="table table-bordered " style="font-size: 18px;" border="0" width="100%">
                    <thead><tr><th colspan="5" style="background-color: #FFFFFF"><div align="center">สรุปประจำวัน แยกตามหมายเลขทะเบียน</div></th></tr></thead>
                </table>   
                <table class="table table-bordered " style="font-size: 13px;" border="1" width="100%">
                    <thead>
                        <tr>
                            <th rowspan="1" style="background-color: #C6E0B4"><div align="center">DATE REFUEL</div></th>
                            <th rowspan="1" style="background-color: #C6E0B4"><div align="center">TRUCK NO</div></th>
                            <!-- <th rowspan="1" style="background-color: #C6E0B4"><div align="center">SECTION</div></th> -->
                            <th colspan="1" style="background-color: #C6E0B4"><div align="center">ลิตร</div></th>
                            <th colspan="1" style="background-color: #C6E0B4"><div align="center">ราคา</div></th>
                            <th colspan="1" style="background-color: #C6E0B4"><div align="center">จำนวนเงิน</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $SQLBOTTOM_CENTER = "SELECT
                            DISTINCT
                                CONVERT (VARCHAR (10),OSGS_DRF,20) OSGS_DRF,
                                THAINAME OSGS_VHCRG,
                                -- SUM(CAST(OSGS_AM as int)) OSGS_AM,
                                -- SUM(CAST(OSGS_PAY as int)) OSGS_PAY
                                SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) as OSGS_AM,
                                SUM(ISNULL(CAST(OSGS_PAY AS DECIMAL(6,2)),0)) as OSGS_PAY
                            FROM
                                dbo.OUTSIDE_GAS_STATION
                                LEFT JOIN VEHICLETRANSPORTPLAN ON VEHICLETRANSPORTPLAN.VEHICLETRANSPORTPLANID = OUTSIDE_GAS_STATION.OSGS_PLID
                                LEFT JOIN EMPLOYEEEHR2 ON EMPLOYEEEHR2.PersonCode = VEHICLETRANSPORTPLAN.EMPLOYEECODE1 
                            WHERE
                                OSGS_DRF BETWEEN '$startymd' AND '$endymd' AND NOT OSGS_TY IN('3','4') AND NOT OSGS_AM = '' 
                                AND COMPANYCODE != 'RRC' AND COMPANYCODE != 'RATC' AND COMPANYCODE != 'RCC'
                                GROUP BY                                
                                OSGS_DRF,
                                THAINAME,
                                DATEWORKING                               
                                ORDER BY OSGS_DRF ASC";
                            $QUERYBOTTOM_CENTER = sqlsrv_query($conn, $SQLBOTTOM_CENTER );     
                            while($RSBOTTOM_CENTER = sqlsrv_fetch_array($QUERYBOTTOM_CENTER)) { 
                                $OSGSBOTTOM_VHCRG = $RSBOTTOM_CENTER["OSGS_VHCRG"];
                                $OSGSBOTTOM_ID = $RSBOTTOM_CENTER["OSGS_ID"];
                                $OSGSBOTTOM_PLID = $RSBOTTOM_CENTER["OSGS_PLID"];
                                $OSGSBOTTOM_TY = $RSBOTTOM_CENTER["OSGS_TY"];
                                $OSGSBOTTOM_DRF = $RSBOTTOM_CENTER["OSGS_DRF"];
                                $OSGSBOTTOM_BL = $RSBOTTOM_CENTER["OSGS_BL"];
                                $OSGSBOTTOM_AM = $RSBOTTOM_CENTER["OSGS_AM"];
                                $OSGSBOTTOM_PAY = $RSBOTTOM_CENTER["OSGS_PAY"];
                                $OSGSBOTTOM_RM = $RSBOTTOM_CENTER["OSGS_RM"];
                                $EMPLOYEECODE1 = $RSBOTTOM_CENTER["EMPLOYEECODE1"];
                                $EMPLOYEENAME1 = $RSBOTTOM_CENTER["EMPLOYEENAME1"];
                                $DATEWORKING = $RSBOTTOM_CENTER["DATEWORKING"];
                                $PositionNameT = $RSBOTTOM_CENTER["PositionNameT"];

                                $PSTNBOTTOM_ = explode("/", $PositionNameT);
                                $RSPSTNBOTTOM_0 = $PSTNBOTTOM_[0];
                                $RSPSTNBOTTOM_1 = $PSTNBOTTOM_[1];
                                
                                $CALPAYBOTTOM_=number_format($OSGSBOTTOM_PAY/$OSGSBOTTOM_AM, 2);
                        ?>
                            <tr>
                                <td align="center"><?=$OSGSBOTTOM_DRF;?></td>
                                <td align="center"><?=$OSGSBOTTOM_VHCRG;?></td>
                                <!-- <td align="center"><?=$RSPSTNBOTTOM_1;?></td> -->
                                <td align="center"><?=$OSGSBOTTOM_AM;?></td>
                                <td align="center"><?=$CALPAYBOTTOM_;?></td>
                                <td align="center"><?=$OSGSBOTTOM_PAY;?></td> 
                                   <?php $QOSGSBOTTOM__AM=$QOSGSBOTTOM__AM+$OSGSBOTTOM_AM;$QOSGSBOTTOM__PAY=$QOSGSBOTTOM__PAY+$OSGSBOTTOM_PAY;eval('$QCALPAYBOTTOM_=$QOSGSBOTTOM__PAY / $QOSGSBOTTOM__AM;'); ?>
                            </tr>  
                        <?php } ?>                                              
                    </tbody>
                    <tfoot>
                        <?php $TOTALQBOTTOM_AMOUNT=$QOSGSBOTTOM__AM; $TOTALQBOTTOM_PRICE=$QOSGSBOTTOM__PAY; $TOTALQBOTTOM_PAY=$QCALPAYBOTTOM_; ?>
                        <td colspan="2" style="background-color: #C6E0B4"><div align="right"><b>TOTAL </b></div></td>
                        <td align="center" style="background-color: #C6E0B4"><b><?=number_format($TOTALQBOTTOM_AMOUNT, 2)?></b></td> 
                        <td align="center" style="background-color: #C6E0B4"><b><?=number_format($TOTALQBOTTOM_PAY, 2)?></b></td> 
                        <td align="center" style="background-color: #C6E0B4"><b><?=number_format($TOTALQBOTTOM_PRICE, 2)?></b></td> 
                    </tfoot>
                </table>    
                <p></p>            
                <p></p>
                <table class="table table-bordered " style="font-size: 18px;" border="0" width="100%">
                    <thead><tr><th colspan="6" style="background-color: #FFFFFF"><div align="center">สรุปจำนวนการเติม แยกตามประเภท</div></th></tr></thead>
                </table>  
                <table class="table table-bordered " style="font-size: 13px;" border="0" width="100%">
                    <tbody>
                            <tr>
                                <td align="center"></td>
                                <td align="center"><b>รายการ</b></td>
                                <td align="center"></td>
                                <td align="center"><b>จำนวนครั้ง</b></td>
                            </tr>  
                        <?php 
                            $SQLCHK1 = "SELECT COUNT(OSGS_TY) OSGS_TY FROM OUTSIDE_GAS_STATION 
                            LEFT JOIN VEHICLETRANSPORTPLAN ON VEHICLETRANSPORTPLAN.VEHICLETRANSPORTPLANID = OUTSIDE_GAS_STATION.OSGS_PLID
                            WHERE OSGS_DRF BETWEEN '$startymd' AND '$endymd' AND NOT OSGS_TY IN('3','4') AND NOT OSGS_AM = '' 
                            AND COMPANYCODE != 'RRC' AND COMPANYCODE != 'RATC' AND COMPANYCODE != 'RCC'";
                            $QUERYCHK1 = sqlsrv_query($conn, $SQLCHK1 );     
                            while($RSCHK1 = sqlsrv_fetch_array($QUERYCHK1)) { 
                                $RSCHK1_TY = $RSCHK1["OSGS_TY"];
                        ?>
                            <tr>
                                <td align="center"></td>
                                <td align="center">รวมทั้งหมด</td>
                                <td style="background-color: #C6E0B4;border: thin solid black;"></td>
                                <td align="center"><?=$RSCHK1_TY;?></td>
                            </tr>  
                        <?php } ?>   
                        <?php 
                            $SQLCHK2 = "SELECT COUNT(OSGS_TY) OSGS_TY FROM OUTSIDE_GAS_STATION 
                            LEFT JOIN VEHICLETRANSPORTPLAN ON VEHICLETRANSPORTPLAN.VEHICLETRANSPORTPLANID = OUTSIDE_GAS_STATION.OSGS_PLID
                            WHERE OSGS_DRF BETWEEN '$startymd' AND '$endymd' AND OSGS_TY = 1	AND NOT OSGS_TY IN('3','4') AND NOT OSGS_AM = '' 
                            AND COMPANYCODE != 'RRC' AND COMPANYCODE != 'RATC' AND COMPANYCODE != 'RCC'";
                            $QUERYCHK2 = sqlsrv_query($conn, $SQLCHK2 );     
                            while($RSCHK2 = sqlsrv_fetch_array($QUERYCHK2)) { 
                                $RSCHK2_TY = $RSCHK2["OSGS_TY"];
                        ?>
                            <tr>
                                <td align="center"></td>
                                <td align="center">เติมเงินสด</td>
                                <td style="background-color: #FFFF00;border: thin solid black;"></td>
                                <td align="center"><?=$RSCHK2_TY;?></td>
                            </tr>  
                        <?php } ?>   
                        <?php 
                            $SQLCHK3 = "SELECT COUNT(OSGS_TY) OSGS_TY FROM OUTSIDE_GAS_STATION 
                            LEFT JOIN VEHICLETRANSPORTPLAN ON VEHICLETRANSPORTPLAN.VEHICLETRANSPORTPLANID = OUTSIDE_GAS_STATION.OSGS_PLID
                            WHERE OSGS_DRF BETWEEN '$startymd' AND '$endymd' AND OSGS_TY = 2	AND NOT OSGS_TY IN('3','4') AND NOT OSGS_AM = '' 
                            AND COMPANYCODE != 'RRC' AND COMPANYCODE != 'RATC' AND COMPANYCODE != 'RCC'";
                            $QUERYCHK3 = sqlsrv_query($conn, $SQLCHK3 );     
                            while($RSCHK3 = sqlsrv_fetch_array($QUERYCHK3)) { 
                                $RSCHK3_TY = $RSCHK3["OSGS_TY"];
                        ?>
                            <tr>
                                <td align="center"></td>
                                <td align="center">เติมบัตร</td>
                                <td style="background-color: #F79646;border: thin solid black;"></td>
                                <td align="center"><?=$RSCHK3_TY;?></td>
                            </tr>  
                        <?php } ?>                                              
                    </tbody>
                </table>  
        </section>
        <!-- /.content -->
    </div>
<?php 
    }else{ echo "<h1>ไม่มีข้อมูล</h1>"; } 
sqlsrv_close($conn);
?>



<?php
    
    
?>