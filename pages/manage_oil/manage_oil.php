<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");

if ($_POST['txt_flg'] == "select_joboil") { 
    $conditionEHR = " AND a.PersonID ='" . $_SESSION["EMPLOYEEID"] . "'";
    $sql_seEHR = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEHR = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($conditionEHR, SQLSRV_PARAM_IN)
    );
    $query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
    $result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);
                                                 
    date_default_timezone_set('Asia/Bangkok');
    $datestartoil=$_POST['datestartoil'];
    $dateendoil=$_POST['dateendoil'];
    // echo $datestartoil;
    // ECHO "<br>";
    // echo $dateendoil;
    // ECHO "<br>";
    $DATESTART = str_replace('/', '-', $datestartoil);
    $CONVERTDATESTART = date("Y-m-d", strtotime($DATESTART) );
    // ECHO "<br>";
    $DATEEND = str_replace('/', '-', $dateendoil);
    $CONVERTDATEEND = date("Y-m-d", strtotime($DATEEND) );

    $EHR_PHC = $result_seEHR['PersonCode'];
        
    $stmt_chkjob = "SELECT 
        OILT.OILDATAID OILTID,
        CHKPLCAR.VEHICLETRANSPORTPLANID VHCTPPID,
        CHKPLCAR.JOBNO JOBNOPLAN,
        OILT.JOBNO OILTJN,
        OILT.VEHICLEREGISNUMBER VHCRGNB,
        CHKIFCAR.THAINAME,
        OILT.VEHICLETYPE OILTTE,
        CHKPLCAR.EMPLOYEECODE1,
        OILT.MILEAGESTART,
        OILT.MILEAGEEND,
        OILT.OIL_AMOUNT,
        OILT.OIL_BILLNUMBER,
        CONVERT (VARCHAR (10),OILT.REFUELINGDATE,20) OILTDWK,
        CONVERT (VARCHAR (16),OILT.REFUELINGDATE,29) RFD
    FROM RTMS.dbo.VEHICLETRANSPORTPLAN CHKPLCAR
    LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON (CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER1 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER2 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME2)
    LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE
    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OILT ON (CHKPLCAR.JOBNO = OILT.JOBNO COLLATE Thai_CI_AI)
    WHERE (CHKPLCAR.EMPLOYEECODE1 = '$EHR_PHC' OR CHKPLCAR.EMPLOYEECODE2 = '$EHR_PHC')
    AND CONVERT (VARCHAR (10),CHKPLCAR.DATEWORKING,20) BETWEEN '$CONVERTDATESTART' AND '$CONVERTDATEEND'
    AND OILT.JOBNO IS NOT NULL
    ORDER BY CHKPLCAR.JOBNO ASC";
    $query_chkjob = sqlsrv_query($conn, $stmt_chkjob);
    $result = sqlsrv_fetch_array($query_chkjob);
    $data1 = $result["JOBNOPLAN"];
    $data2 = $result["OILTJN"];
    // echo $data1;
    // echo "<br>";
    // echo $data2;

?>
    <table  style="height:70px;width:100px" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-oiltat" role="grid" aria-describedby="dataTables-example_info" >
        <thead>
            <tr role="row">
                <th style="text-align:center;width:100px">จัดการ</th>
                <th style="text-align:center;width:100px">สถานะข้อมูล</th>
                <th style="text-align:center;width:200px">เลข Job จากแผน</th>
                <th style="text-align:center;width:200px">คีย์เลข Job จากเติมน้ำมัน</th>
                <th style="text-align:center;width:100px">เลขใบกำกับน้ำมัน</th>
                <th style="text-align:center;width:100px">ทะเบียนรถ</th>
                <th style="text-align:center;width:100px">ชื่อรถ</th>
                <th style="text-align:center;width:100px">ประเภทรถ</th>
                <th style="text-align:center;width:100px">เลขไมล์ต้น</th>
                <th style="text-align:center;width:100px">เลขไมล์ปลาย</th>
                <th style="text-align:center;width:100px">ระยะทาง</th>
                <th style="text-align:center;width:100px">จำนวนน้ำมัน(ลิตร)</th>
                <th style="text-align:center;width:100px">วันที่เติมน้ำมัน</th>
            </tr>
        </thead>
        <tbody>
            <?php       
                $stmt_oildataresult = "SELECT 
                    OILT.OILDATAID OILTID,
                    CHKPLCAR.VEHICLETRANSPORTPLANID VHCTPPID,
                    CHKPLCAR.JOBNO JOBNOPLAN,
                    OILT.JOBNO OILTJN,
                    OILT.VEHICLEREGISNUMBER VHCRGNB,
                    CHKIFCAR.THAINAME,
                    OILT.VEHICLETYPE OILTTE,
                    CHKPLCAR.EMPLOYEECODE1,
                    OILT.MILEAGESTART,
                    OILT.MILEAGEEND,
                    OILT.OIL_AMOUNT,
                    OILT.OIL_BILLNUMBER,
                    CONVERT (VARCHAR (10),OILT.REFUELINGDATE,20) OILTDWK,
                    CONVERT (VARCHAR (16),OILT.REFUELINGDATE,29) RFD
                FROM RTMS.dbo.VEHICLETRANSPORTPLAN CHKPLCAR
                -- LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON (CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER1 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER2 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME2)
                -- LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE
                LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OILT ON (CHKPLCAR.JOBNO = OILT.JOBNO COLLATE Thai_CI_AI)
                LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON CHKIFCAR.VEHICLEREGISNUMBER = OILT.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE 
                WHERE (CHKPLCAR.EMPLOYEECODE1 = '$EHR_PHC' OR CHKPLCAR.EMPLOYEECODE2 = '$EHR_PHC')
                AND CONVERT (VARCHAR (10),CHKPLCAR.DATEWORKING,20) BETWEEN '$CONVERTDATESTART' AND '$CONVERTDATEEND'
                ORDER BY CHKPLCAR.JOBNO ASC";
                $query_oildataresult = sqlsrv_query($conn, $stmt_oildataresult);
                while($result_oildataresult = sqlsrv_fetch_array($query_oildataresult, SQLSRV_FETCH_ASSOC)) {
                    $OILTID = $result_oildataresult["OILTID"];
                    $JOBNOPLAN = $result_oildataresult["JOBNOPLAN"];
                    $OILTJN = $result_oildataresult["OILTJN"];
                    $VHCRGNB = $result_oildataresult["VHCRGNB"];
                    $THAINAME = $result_oildataresult["THAINAME"];
                    $OILTTE = $result_oildataresult["OILTTE"];
                    $MLST = $result_oildataresult["MILEAGESTART"];
                    $MLED = $result_oildataresult["MILEAGEEND"];
                    $DTE = $MLED-$MLST;
                    $OBNB = $result_oildataresult["OIL_BILLNUMBER"];
                    $OAM = $result_oildataresult["OIL_AMOUNT"];
                    $OILTATDWK = $result_oildataresult["OILTATDWK"];
                    $RFD = $result_oildataresult["RFD"];

                    $stmt_rsbill = "SELECT 
                        COUNT(OIL_BILLNUMBER) AS CHKCOUNT,
                        CHKPLCAR.JOBNO JOBNOPLAN,
                        OILT.JOBNO OILTJN,
                        OILT.OIL_BILLNUMBER
                    FROM RTMS.dbo.VEHICLETRANSPORTPLAN CHKPLCAR
                    -- LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON (CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER1 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER2 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME2)
                    -- LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OILT ON (CHKPLCAR.JOBNO = OILT.JOBNO COLLATE Thai_CI_AI)
                    LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON CHKIFCAR.VEHICLEREGISNUMBER = OILT.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE 
                    WHERE (CHKPLCAR.EMPLOYEECODE1 = '$EHR_PHC' OR CHKPLCAR.EMPLOYEECODE2 = '$EHR_PHC')
                    AND CONVERT (VARCHAR (10),CHKPLCAR.DATEWORKING,20) BETWEEN '$CONVERTDATESTART' AND '$CONVERTDATEEND'
                    AND OILT.JOBNO IS NOT NULL
                    GROUP BY
                        CHKPLCAR.JOBNO,
                        OILT.JOBNO,
                        OILT.OIL_BILLNUMBER
                    ORDER BY CHKPLCAR.JOBNO ASC";
                    $query_rsbill = sqlsrv_query($conn, $stmt_rsbill);
                    $result_rsbill = sqlsrv_fetch_array($query_rsbill);
                    $CHKCOUNT = $result_rsbill["CHKCOUNT"];
                    $RSBILL = $result_rsbill["OIL_BILLNUMBER"];
                    // echo $CHKCOUNT;

                    if($OILTID == ""){
                        $RSOILID="";
                    }else{
                        $RSOILID=$OILTID;
                    }
                    if($OILTJN == ""){
                        if($CHKCOUNT!=""){                                                                                                                    
                            // $CHKJN = '<b><font color="blue">ไม่มีข้อมูลการเติมน้ำมัน</font></b>';
                            // $RSJOBNO = "-";
                            // $RSJOBNO2= "";
                            $CHKJN = 'OK';
                            $RSJOBNO = '-';
                            $RSJOBNO2= "";
                            if($CHKJN=='OK'){
                                $bgcolor1='bgcolor="#D5F5E3"';
                                $bgcolor2='';
                                $bgcolor4='';
                            }
                        }else{
                            $RSJOBNO = '-';
                            $CHKJN = '<b><font color="blue">ไม่มีข้อมูลการเติมน้ำมัน</font></b>';
                        }
                    }else{
                        $CHKJN = 'OK';
                        $RSJOBNO = $OILTJN;
                        $RSJOBNO2=$OILTJN;
                        if($CHKJN=='OK'){
                            $bgcolor1='bgcolor="#D5F5E3"';
                        }
                    }
                    if($RSBILL!=""){
                        $bgcolor3='bgcolor="#D5F5E3"';
                    } 
                    if($JOBNOPLAN==$OILTJN){
                        $bgcolor2='bgcolor="#D5F5E3"';
                        $bgcolor4='bgcolor="#D5F5E3"';
                    }
                    if($VHCRGNB == ""){
                        $RSVHCRGNB="-";
                        $RSTHAINAME="-";
                        $RSOILTTE="-";
                    }else{
                        $RSVHCRGNB=$VHCRGNB;
                        $RSTHAINAME=$THAINAME;
                        $RSOILTTE=$OILTTE;
                    } 
                    if($MLST == ""){
                        $RSMLST="-";
                    }else{
                        $RSMLST=$MLST;
                    }
                    if($MLED == ""){
                        $RSMLED="-";
                    }else{
                        $RSMLED=$MLED;
                    }
                    if($DTE == "0"){
                        $RSDTE="-";
                    }else{
                        $RSDTE=$DTE;
                    }
                    if($OBNB == ""){
                        $RSOBNB=$RSBILL;
                    }else{
                        $RSOBNB=$OBNB;
                    }
                    if($OAM == ""){
                        $RSOAM="-";
                    }else{
                        $RSOAM=$OAM;
                    }
                    if($RFD == ""){
                        $RSRFD="-";
                    }else{
                        $RSRFD=$RFD;
                    }
            ?>       
            <tr class="gradeX odd" role="row">
                <td style="text-align: center;width: 100px;height: 55px">
                    <div class="btn-group">
                        <?php if($JOBNOPLAN==$RSJOBNO2){ ?>
                            <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-chevron-down"></i></button>
                            <ul class="dropdown-menu slidedown">
                                <li><a href="#" onclick="editdataoiltatsuno('<?=$RSOILID;?>','<?=$JOBNOPLAN;?>','<?=$RSJOBNO2;?>','<?=$OBNB;?>','<?=$MLST;?>','<?=$MLED;?>','<?=$OAM;?>','<?=$RFD;?>')" data-toggle="modal"  data-target="#modal_editdataoiltatsuno">แก้ไขข้อมูล</a></li>
                            </ul>                                                                                                                                   
                        <?php }else if(($JOBNOPLAN!=$RSJOBNO2) && ($OILTDWK!="")){   ?>        
                            <button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-chevron-down"></i></button>
                            <ul class="dropdown-menu slidedown">
                                <li><a href="#" onclick="editdataoiltatsuno('<?=$RSOILID;?>','<?=$JOBNOPLAN;?>','<?=$RSJOBNO2;?>','<?=$OBNB;?>','<?=$MLST;?>','<?=$MLED;?>','<?=$OAM;?>','<?=$RFD;?>')" data-toggle="modal"  data-target="#modal_editdataoiltatsuno">แก้ไขข้อมูล</a></li>
                            </ul>  
                        <?php }else{  
                                $JOBOIL = $RSJOBNO2;
                                $JOBPLAN  = $JOBNOPLAN;
                                $POS = strpos($JOBOIL, $JOBPLAN);
                                if ($POS === false) { 
                        ?>
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-chevron-down"></i></button>
                            <ul class="dropdown-menu slidedown">
                                <li><a href="#" onclick="fineandeditdataoiltatsuno('<?=$JOBNOPLAN;?>')" data-toggle="modal"  data-target="#modal_editdataoiltatsuno">แก้ไขข้อมูล</a></li>
                            </ul> 
                        <?php } else { ?>
                            <button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-chevron-down"></i></button>
                            <ul class="dropdown-menu slidedown">
                                <li><a href="#" onclick="editdataoiltatsuno('<?=$RSOILID;?>','<?=$JOBNOPLAN;?>','<?=$RSJOBNO2;?>','<?=$OBNB;?>','<?=$MLST;?>','<?=$MLED;?>','<?=$OAM;?>','<?=$RFD;?>')" data-toggle="modal"  data-target="#modal_editdataoiltatsuno">แก้ไขข้อมูล</a></li>
                            </ul>    
                        <?php } } ?>
                    </div>
                </td>
                <td style="text-align:center;width:100px" <?=$bgcolor1;?>><b><?=$CHKJN;?></b></td>
                <td style="text-align:center;width:200px" <?=$bgcolor4;?>><b><?=$JOBNOPLAN;?></b></td>
                <td style="text-align:center;width:200px" <?=$bgcolor2;?>><b><?=$RSJOBNO;?></b></td>
                <td style="text-align:center;width:100px" <?=$bgcolor3;?>><b><?=$RSOBNB;?></b></td>
                <td style="text-align:center;width:100px"><?=$RSVHCRGNB;?></td>
                <td style="text-align:center;width:100px"><?=$RSTHAINAME;?></td>
                <td style="text-align:center;width:100px"><?=$RSOILTTE;?></td>
                <td style="text-align:center;width:100px"><?=$RSMLST;?></td>
                <td style="text-align:center;width:100px"><?=$RSMLED;?></td>
                <td style="text-align:center;width:100px"><?=$RSDTE;?></td>
                <td style="text-align:center;width:100px"><?=$RSOAM;?></td>
                <td style="text-align:center;width:100px"><?=$RSRFD;?></td>
            </tr>       
            <?php } ?>
        </tbody>
    </table>
<?php }
if ($_POST['txt_flg'] == "select_joboil_admin") { 
    
    $EHR_PHC=$_POST['personcode'];

    $conditionEHR = " AND a.PersonCode ='" . $EHR_PHC . "'";
    $sql_seEHR = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEHR = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($conditionEHR, SQLSRV_PARAM_IN)
    );
    $query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
    $result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);
                                                 
    date_default_timezone_set('Asia/Bangkok');
    $datestartoil=$_POST['datestartoil'];
    $dateendoil=$_POST['dateendoil'];
    // echo $datestartoil;
    // ECHO "<br>";
    // echo $dateendoil;
    // ECHO "<br>";
    $DATESTART = str_replace('/', '-', $datestartoil);
    $CONVERTDATESTART = date("Y-m-d", strtotime($DATESTART) );
    // ECHO "<br>";
    $DATEEND = str_replace('/', '-', $dateendoil);
    $CONVERTDATEEND = date("Y-m-d", strtotime($DATEEND) );
        
    $stmt_chkjob = "SELECT 
        OILT.OILDATAID OILTID,
        CHKPLCAR.VEHICLETRANSPORTPLANID VHCTPPID,
        CHKPLCAR.JOBNO JOBNOPLAN,
        OILT.JOBNO OILTJN,
        OILT.VEHICLEREGISNUMBER VHCRGNB,
        CHKIFCAR.THAINAME,
        OILT.VEHICLETYPE OILTTE,
        CHKPLCAR.EMPLOYEECODE1,
        OILT.MILEAGESTART,
        OILT.MILEAGEEND,
        OILT.OIL_AMOUNT,
        OILT.OIL_BILLNUMBER,
        CONVERT (VARCHAR (10),OILT.REFUELINGDATE,20) OILTDWK,
        CONVERT (VARCHAR (16),OILT.REFUELINGDATE,29) RFD
    FROM RTMS.dbo.VEHICLETRANSPORTPLAN CHKPLCAR
    LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON (CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER1 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER2 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME2)
    LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE
    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OILT ON (CHKPLCAR.JOBNO = OILT.JOBNO COLLATE Thai_CI_AI)
    WHERE (CHKPLCAR.EMPLOYEECODE1 = '$EHR_PHC' OR CHKPLCAR.EMPLOYEECODE2 = '$EHR_PHC')
    AND CONVERT (VARCHAR (10),CHKPLCAR.DATEWORKING,20) BETWEEN '$CONVERTDATESTART' AND '$CONVERTDATEEND'
    AND OILT.JOBNO IS NOT NULL
    ORDER BY CHKPLCAR.JOBNO ASC";
    $query_chkjob = sqlsrv_query($conn, $stmt_chkjob);
    $result = sqlsrv_fetch_array($query_chkjob);
    $data1 = $result["JOBNOPLAN"];
    $data2 = $result["OILTJN"];
    // echo $data1;
    // echo "<br>";
    // echo $data2;

?>
    <table  style="height:70px;width:100px" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-oiltat" role="grid" aria-describedby="dataTables-example_info" >
        <thead>
            <tr role="row">
                <th style="text-align:center;width:100px">จัดการ</th>
                <th style="text-align:center;width:100px">สถานะข้อมูล</th>
                <th style="text-align:center;width:200px">เลข Job จากแผน</th>
                <th style="text-align:center;width:200px">คีย์เลข Job จากเติมน้ำมัน</th>
                <th style="text-align:center;width:100px">เลขใบกำกับน้ำมัน</th>
                <th style="text-align:center;width:100px">ทะเบียนรถ</th>
                <th style="text-align:center;width:100px">ชื่อรถ</th>
                <th style="text-align:center;width:100px">ประเภทรถ</th>
                <th style="text-align:center;width:100px">เลขไมล์ต้น</th>
                <th style="text-align:center;width:100px">เลขไมล์ปลาย</th>
                <th style="text-align:center;width:100px">ระยะทาง</th>
                <th style="text-align:center;width:100px">จำนวนน้ำมัน(ลิตร)</th>
                <th style="text-align:center;width:100px">วันที่เติมน้ำมัน</th>
            </tr>
        </thead>
        <tbody>
            <?php       
                $stmt_oildataresult = "SELECT 
                    OILT.OILDATAID OILTID,
                    CHKPLCAR.VEHICLETRANSPORTPLANID VHCTPPID,
                    CHKPLCAR.JOBNO JOBNOPLAN,
                    OILT.JOBNO OILTJN,
                    OILT.VEHICLEREGISNUMBER VHCRGNB,
                    CHKIFCAR.THAINAME,
                    OILT.VEHICLETYPE OILTTE,
                    CHKPLCAR.EMPLOYEECODE1,
                    OILT.MILEAGESTART,
                    OILT.MILEAGEEND,
                    OILT.OIL_AMOUNT,
                    OILT.OIL_BILLNUMBER,
                    CHKPLCAR.RS_OILREMARK,
                    CONVERT (VARCHAR (10),OILT.REFUELINGDATE,20) OILTDWK,
                    CONVERT (VARCHAR (16),OILT.REFUELINGDATE,29) RFD
                FROM RTMS.dbo.VEHICLETRANSPORTPLAN CHKPLCAR
                -- LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON (CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER1 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER2 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME2)
                -- LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE
                LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OILT ON (CHKPLCAR.JOBNO = OILT.JOBNO COLLATE Thai_CI_AI)
                LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON CHKIFCAR.VEHICLEREGISNUMBER = OILT.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE 
                WHERE (CHKPLCAR.EMPLOYEECODE1 = '$EHR_PHC' OR CHKPLCAR.EMPLOYEECODE2 = '$EHR_PHC')
                AND CONVERT (VARCHAR (10),CHKPLCAR.DATEWORKING,20) BETWEEN '$CONVERTDATESTART' AND '$CONVERTDATEEND'
                ORDER BY CHKPLCAR.JOBNO ASC";
                $query_oildataresult = sqlsrv_query($conn, $stmt_oildataresult);
                while($result_oildataresult = sqlsrv_fetch_array($query_oildataresult, SQLSRV_FETCH_ASSOC)) {
                    $OILTID = $result_oildataresult["OILTID"];
                    $JOBNOPLAN = $result_oildataresult["JOBNOPLAN"];
                    $OILTJN = $result_oildataresult["OILTJN"];
                    $VHCRGNB = $result_oildataresult["VHCRGNB"];
                    $THAINAME = $result_oildataresult["THAINAME"];
                    $OILTTE = $result_oildataresult["OILTTE"];
                    $MLST = $result_oildataresult["MILEAGESTART"];
                    $MLED = $result_oildataresult["MILEAGEEND"];
                    $DTE = $MLED-$MLST;
                    $OBNB = $result_oildataresult["OIL_BILLNUMBER"];
                    $OAM = $result_oildataresult["OIL_AMOUNT"];
                    $OILTATDWK = $result_oildataresult["OILTATDWK"];
                    $RFD = $result_oildataresult["RFD"];
                    $RS_OILREMARK = $result_oildataresult["RS_OILREMARK"];

                    $stmt_rsbill = "SELECT 
                        COUNT(OIL_BILLNUMBER) AS CHKCOUNT,
                        CHKPLCAR.JOBNO JOBNOPLAN,
                        OILT.JOBNO OILTJN,
                        OILT.OIL_BILLNUMBER
                    FROM RTMS.dbo.VEHICLETRANSPORTPLAN CHKPLCAR
                    -- LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON (CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER1 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.VEHICLEREGISNUMBER2 OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME OR CHKIFCAR.VEHICLEREGISNUMBER = CHKPLCAR.THAINAME2)
                    -- LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OILT ON (CHKPLCAR.JOBNO = OILT.JOBNO COLLATE Thai_CI_AI)
                    LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON CHKIFCAR.VEHICLEREGISNUMBER = OILT.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                    LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE 
                    WHERE (CHKPLCAR.EMPLOYEECODE1 = '$EHR_PHC' OR CHKPLCAR.EMPLOYEECODE2 = '$EHR_PHC')
                    AND CONVERT (VARCHAR (10),CHKPLCAR.DATEWORKING,20) BETWEEN '$CONVERTDATESTART' AND '$CONVERTDATEEND'
                    AND OILT.JOBNO IS NOT NULL
                    GROUP BY
                        CHKPLCAR.JOBNO,
                        OILT.JOBNO,
                        OILT.OIL_BILLNUMBER
                    ORDER BY CHKPLCAR.JOBNO ASC";
                    $query_rsbill = sqlsrv_query($conn, $stmt_rsbill);
                    $result_rsbill = sqlsrv_fetch_array($query_rsbill);
                    $CHKCOUNT = $result_rsbill["CHKCOUNT"];
                    $RSBILL = $result_rsbill["OIL_BILLNUMBER"];
                    // echo $CHKCOUNT;

                    if($OILTID == ""){
                        $RSOILID="";
                    }else{
                        $RSOILID=$OILTID;
                    }
                    if($OILTJN == ""){
                        if($CHKCOUNT!=""){                                                                                                                    
                            // $CHKJN = '<b><font color="blue">ไม่มีข้อมูลการเติมน้ำมัน</font></b>';
                            // $RSJOBNO = "-";
                            // $RSJOBNO2= "";
                            $CHKJN = 'OK';
                            $RSJOBNO = '-';
                            $RSJOBNO2= "";
                            if($CHKJN=='OK'){
                                $bgcolor1='bgcolor="#D5F5E3"';
                                $bgcolor2='';
                                $bgcolor4='';
                            }
                        }else{
                            $RSJOBNO = '-';
                            $CHKJN = '<b><font color="blue">ไม่มีข้อมูลการเติมน้ำมัน</font></b>';
                        }
                    }else{
                        $CHKJN = 'OK';
                        $RSJOBNO = $OILTJN;
                        $RSJOBNO2=$OILTJN;
                        if($CHKJN=='OK'){
                            $bgcolor1='bgcolor="#D5F5E3"';
                        }
                    }
                    if($RSBILL!=""){
                        $bgcolor3='bgcolor="#D5F5E3"';
                    } 
                    if($JOBNOPLAN==$OILTJN){
                        $bgcolor2='bgcolor="#D5F5E3"';
                        $bgcolor4='bgcolor="#D5F5E3"';
                    }
                    if($VHCRGNB == ""){
                        $RSVHCRGNB="-";
                        $RSTHAINAME="-";
                        $RSOILTTE="-";
                    }else{
                        $RSVHCRGNB=$VHCRGNB;
                        $RSTHAINAME=$THAINAME;
                        $RSOILTTE=$OILTTE;
                    } 
                    if($MLST == ""){
                        $RSMLST="-";
                    }else{
                        $RSMLST=$MLST;
                    }
                    if($MLED == ""){
                        $RSMLED="-";
                    }else{
                        $RSMLED=$MLED;
                    }
                    if($DTE == "0"){
                        $RSDTE="-";
                    }else{
                        $RSDTE=$DTE;
                    }
                    if($OBNB == ""){
                        $RSOBNB=$RSBILL;
                    }else{
                        $RSOBNB=$OBNB;
                    }
                    if($OAM == ""){
                        $RSOAM="-";
                    }else{
                        $RSOAM=$OAM;
                    }
                    if($RFD == ""){
                        $RSRFD="-";
                    }else{
                        $RSRFD=$RFD;
                    }
            ?>       
            <tr class="gradeX odd" role="row">
                <td style="text-align: center;width: 100px;height: 55px">
                    <div class="btn-group">
                        <?php if($JOBNOPLAN==$RSJOBNO2){ ?>
                            <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-chevron-down"></i></button>
                            <ul class="dropdown-menu slidedown">
                                <li><a href="#" onclick="editdataoiltatsuno('<?=$RSOILID;?>','<?=$JOBNOPLAN;?>','<?=$RSJOBNO2;?>','<?=$OBNB;?>','<?=$MLST;?>','<?=$MLED;?>','<?=$OAM;?>','<?=$RS_OILREMARK;?>','<?=$RFD;?>')" data-toggle="modal"  data-target="#modal_editdataoiltatsuno">แก้ไขข้อมูล</a></li>
                            </ul>                                                                                                                                   
                        <?php }else if(($JOBNOPLAN!=$RSJOBNO2) && ($OILTDWK!="")){   ?>        
                            <button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-chevron-down"></i></button>
                            <ul class="dropdown-menu slidedown">
                                <li><a href="#" onclick="editdataoiltatsuno('<?=$RSOILID;?>','<?=$JOBNOPLAN;?>','<?=$RSJOBNO2;?>','<?=$OBNB;?>','<?=$MLST;?>','<?=$MLED;?>','<?=$OAM;?>','<?=$RS_OILREMARK;?>','<?=$RFD;?>')" data-toggle="modal"  data-target="#modal_editdataoiltatsuno">แก้ไขข้อมูล</a></li>
                            </ul>  
                        <?php }else{  
                                $JOBOIL = $RSJOBNO2;
                                $JOBPLAN  = $JOBNOPLAN;
                                $POS = strpos($JOBOIL, $JOBPLAN);
                                if ($POS === false) { 
                        ?>
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-chevron-down"></i></button>
                            <ul class="dropdown-menu slidedown">
                                <li><a href="#" onclick="fineandeditdataoiltatsuno('<?=$JOBNOPLAN;?>')" data-toggle="modal"  data-target="#modal_editdataoiltatsuno">แก้ไขข้อมูล</a></li>
                            </ul> 
                        <?php } else { ?>
                            <button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-chevron-down"></i></button>
                            <ul class="dropdown-menu slidedown">
                                <li><a href="#" onclick="editdataoiltatsuno('<?=$RSOILID;?>','<?=$JOBNOPLAN;?>','<?=$RSJOBNO2;?>','<?=$OBNB;?>','<?=$MLST;?>','<?=$MLED;?>','<?=$OAM;?>','<?=$RS_OILREMARK;?>','<?=$RFD;?>')" data-toggle="modal"  data-target="#modal_editdataoiltatsuno">แก้ไขข้อมูล</a></li>
                            </ul>    
                        <?php } } ?>
                    </div>
                </td>
                <td style="text-align:center;width:100px" <?=$bgcolor1;?>><b><?=$CHKJN;?></b></td>
                <td style="text-align:center;width:200px" <?=$bgcolor4;?>><b><?=$JOBNOPLAN;?></b></td>
                <td style="text-align:center;width:200px" <?=$bgcolor2;?>><b><?=$RSJOBNO;?></b></td>
                <td style="text-align:center;width:100px" <?=$bgcolor3;?>><b><?=$RSOBNB;?></b></td>
                <td style="text-align:center;width:100px"><?=$RSVHCRGNB;?></td>
                <td style="text-align:center;width:100px"><?=$RSTHAINAME;?></td>
                <td style="text-align:center;width:100px"><?=$RSOILTTE;?></td>
                <td style="text-align:center;width:100px"><?=$RSMLST;?></td>
                <td style="text-align:center;width:100px"><?=$RSMLED;?></td>
                <td style="text-align:center;width:100px"><?=$RSDTE;?></td>
                <td style="text-align:center;width:100px"><?=$RSOAM;?></td>
                <td style="text-align:center;width:100px"><?=$RSRFD;?></td>
            </tr>       
            <?php } ?>
        </tbody>
    </table>
    <center>
        <button type="button" class="btn btn-default btn-md" data-dismiss="modal" onClick="javascript:location.reload();">อัพเดท</button>
        <a href="meg_transportcompensation.php" class="btn btn-danger btn-md">ย้อนกลับ</a>
    </center>
<?php }
if ($_POST['txt_flg'] == "select_editdataoiltatsuno") {
    $OILTID=$_POST['oiltatid'];
    $JOBNOPLAN=$_POST['oiljobnoplan'];
    $RSJOBNO2=$_POST['oiljobnotat'];
    $OILTOBNB=$_POST['oilbillno'];
    $OILTMLST=$_POST['mileagestart'];
    $OILTMLED=$_POST['mileageend'];
    $OILTOAM=$_POST['oilamount'];
    $OILTRFD=$_POST['refueldate'];
    $USERNAME=$_SESSION["USERNAME"];
?>
    <div class="row">
        <div class="col-lg-12">
            <div style="text-align: right">
                <input class="btn btn-default" type="button" style="background-color:#FFFFFF;border:solid 2px"> * ช่องสำหรับแก้ไข
                <input class="btn btn-default" type="button" style="background-color:#CCCCCC;border:solid 2px"> * ไม่สามารถแก้ไขได้
            </div>  <br>
            <!-- <form name="form1" id="fupForm" action="meg_transportcompensation_saveoildetail.php" method="post"> -->
            <form id="fupForm" name="form1" method="post">                            
                <table id="bg-table" width="100%" style="" border="1">
                    <thead>
                        <tr>
                            <th colspan="6" bgcolor="#CCCCCC" style="text-align: center"><b>ข้อมูลน้ำมัน</b></th>
                        </tr>                    
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลข Job จากแผน&nbsp;&nbsp;</th>
                            <th colspan="2" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%;font-weight:bold;" id="jobnoplan" name="jobnoplan" value="<?=$JOBNOPLAN;?>" disabled></th>
                            <th colspan="1" rowspan="2" bgcolor="#CCCCCC" style="text-align:center;"><button type="button" onclick="copyjob()">คัดลอก</button></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลข Job น้ำมัน&nbsp;&nbsp;</th>
                            <th colspan="2" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="jobnooil" name="jobnooil" value="<?=$RSJOBNO2;?>"></th>
                            <th colspan="1" rowspan="2" bgcolor="#CCCCCC" style="text-align:right;"></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขใบกำกับน้ำมัน&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="oilbill" name="oilbill" value="<?=$OILTOBNB;?>" disabled></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขไมล์ต้น&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="" name="" value="<?=$OILTMLST;?>" disabled></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขไมล์ปลาย&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="mileageend" name="mileageend" value="<?=$OILTMLED;?>" ></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">จำนวนน้ำมัน(ลิตร)&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="" name="" value="<?=$OILTOAM;?>" disabled></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">วันที่เติมน้ำมัน&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="daterefuel" name="daterefuel" value="<?=$OILTRFD;?>" disabled></th>
                        </tr>
                    </tbody>
                </table>
                <!-- <font color="red"><small>***ข้อมูลจะแสดงเมื่อเลข JOB ตรงกัน</small></font> -->
                <input type="hidden" name="oldjoboil" id="oldjoboil" value="<?=$RSJOBNO2;?>">
                <input type="hidden" name="mileagestart" id="mileagestart" value="<?=$OILTMLST;?>">
                <input type="hidden" name="oilamout" id="oilamout" value="<?=$OILTOAM;?>">
                <input type="hidden" name="oiltatid" id="oiltatid" value="<?=$OILTID;?>">
                <input type="hidden" name="username" id="username" value="<?=$USERNAME;?>">
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" name="updatejob" onclick="updateoiltatsuno()" value="updatejob" id="butupdate"><span class="fa fa-save"></span> บันทึกการแก้ไข</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="javascript:location.reload();"><span class="fa fa-close"></span> ปิด</button>
                </div>
            </form>
        </div>
    </div>
<?php }
if ($_POST['txt_flg'] == "select_editdataoiltatsuno_byadmin") { 
    $OILTID=$_POST['oiltatid'];
    $JOBNOPLAN=$_POST['oiljobnoplan'];
    $RSJOBNO2=$_POST['oiljobnotat'];
    $OILTOBNB=$_POST['oilbillno'];
    $OILTMLST=$_POST['mileagestart'];
    $OILTMLED=$_POST['mileageend'];
    $OILTOAM=$_POST['oilamount'];
    $RS_OILREMARK=$_POST['oilremark'];
    $OILTRFD=$_POST['refueldate'];
    $USERNAME=$_SESSION["USERNAME"];
?>
    <div class="row">
        <div class="col-lg-12">
            <div style="text-align: right">
                <input class="btn btn-default" type="button" style="background-color:#FFFFFF;border:solid 2px"> * ช่องสำหรับแก้ไข
                <input class="btn btn-default" type="button" style="background-color:#CCCCCC;border:solid 2px"> * ไม่สามารถแก้ไขได้
            </div>  <br>
            <form id="fupForm" name="form1" method="post">                            
                <table id="bg-table" width="100%" style="" border="1">
                    <thead>
                        <tr>
                            <th colspan="6" bgcolor="#CCCCCC" style="text-align: center"><b>ข้อมูลน้ำมัน</b></th>
                        </tr>                    
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลข Job จากแผน&nbsp;&nbsp;</th>
                            <th colspan="2" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%;font-weight:bold;" id="jobnoplan" name="jobnoplan" value="<?=$JOBNOPLAN;?>" disabled></th>
                            <th colspan="1" rowspan="2" bgcolor="#CCCCCC" style="text-align:center;"><button type="button" onclick="copyjob()">คัดลอก</button></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลข Job น้ำมัน&nbsp;&nbsp;</th>
                            <th colspan="2" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="jobnooil" name="jobnooil" value="<?=$RSJOBNO2;?>"></th>
                            <th colspan="1" rowspan="2" bgcolor="#CCCCCC" style="text-align:right;"></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขใบกำกับน้ำมัน&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="oilbill" name="oilbill" value="<?=$OILTOBNB;?>" disabled></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขไมล์ต้น&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="mileagestart" name="mileagestart" value="<?=$OILTMLST;?>" <?php if($_SESSION["ROLENAME"] != "ADMIN" && $_SESSION["ROLENAME"] != "PLANNING(AMT)" && $_SESSION["ROLENAME"] != "PLANNING(GW)"){ ?> disabled <?php } ?>></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขไมล์ปลาย&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="mileageend" name="mileageend" value="<?=$OILTMLED;?>" ></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">จำนวนน้ำมัน(ลิตร)&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="oilamout" name="oilamout" value="<?=$OILTOAM;?>" <?php if($_SESSION["ROLENAME"] != "ADMIN" && $_SESSION["ROLENAME"] != "PLANNING(AMT)" && $_SESSION["ROLENAME"] != "PLANNING(GW)"){ ?> disabled <?php } ?>></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">วันที่เติมน้ำมัน&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="daterefuel" name="daterefuel" value="<?=$OILTRFD;?>" disabled></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">หมายเหตุ&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="oilremark" name="oilremark" value="<?=$RS_OILREMARK;?>" <?php if($_SESSION["ROLENAME"] != "ADMIN" && $_SESSION["ROLENAME"] != "PLANNING(AMT)" && $_SESSION["ROLENAME"] != "PLANNING(GW)"){ ?> disabled <?php } ?>></th>
                        </tr>
                    </tbody>
                </table>
                <!-- <font color="red"><small>***ข้อมูลจะแสดงเมื่อเลข JOB ตรงกัน</small></font> -->
                <input type="hidden" name="oldjoboil" id="oldjoboil" value="<?=$RSJOBNO2;?>">
                <input type="hidden" name="oiltatid" id="oiltatid" value="<?=$OILTID;?>">
                <input type="hidden" name="username" id="username" value="<?=$USERNAME;?>">
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" name="updatejob" onclick="updateoiltatsuno_byadmin()" value="butupdate_byadmin" id="butupdate_byadmin"><span class="fa fa-save"></span> บันทึกการแก้ไข</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="javascript:location.reload();"><span class="fa fa-close"></span> ปิด</button>
                </div>
            </form>
        </div>
    </div>
<?php }
if ($_POST['txt_flg'] == "select_fineandeditdataoiltatsuno") {     
    $JOBNOPLAN=$_POST['oiljobnoplan'];
?>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-4">
                    <div style="text-align: left">
                        <label>ค้นหาเลขบิล</label>
                        <form id="fupForm" name="form1" method="post">  
                            <div class="row">
                                <div class="col-md-9">
                                    <input type="number" class="form-control" style="border-style:solid;border-width: 1px;" id="finebill" name="finebill" value="<?=$finebill;?>" require>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-primary btn-md" onclick="finedataoil()">ค้นหา</button>
                                </div>
                            </div>          
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div style="text-align: right">
                        <input class="btn btn-default" type="button" style="background-color:#FFFFFF;border:solid 2px"> * ช่องสำหรับแก้ไข
                        <input class="btn btn-default" type="button" style="background-color:#CCCCCC;border:solid 2px"> * ไม่สามารถแก้ไขได้
                    </div>
                </div>
            </div>
            <br>
            <form id="fupForm" name="form1" method="post">                            
                <table id="bg-table" width="100%" style="" border="1">
                    <thead>
                        <tr>
                            <th colspan="6" bgcolor="#CCCCCC" style="text-align: center"><b>ข้อมูลน้ำมัน</b></th>
                        </tr>                    
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลข Job จากแผน&nbsp;&nbsp;</th>
                            <th colspan="2" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%;font-weight:bold;" id="jobnoplan" name="jobnoplan" value="<?=$JOBNOPLAN;?>" disabled></th>
                            <th colspan="1" rowspan="2" bgcolor="#CCCCCC" style="text-align:center;"><button type="button" onclick="copyjob()">คัดลอก</button></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลข Job น้ำมัน&nbsp;&nbsp;</th>
                            <th colspan="2" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="jobnooil" name="jobnooil" value="<?=$RSJOBNO2;?>" autocomplete="off"></th>
                            <th colspan="1" rowspan="2" bgcolor="#CCCCCC" style="text-align:right;"></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขใบกำกับน้ำมัน&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="oilbill" name="oilbill" value="<?=$OILTOBNB;?>" disabled></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขไมล์ต้น&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="mileagestart" name="mileagestart" value="<?=$OILTMLST;?>" <?php if($_SESSION["ROLENAME"] != "ADMIN" && $_SESSION["ROLENAME"] != "PLANNING(AMT)" && $_SESSION["ROLENAME"] != "PLANNING(GW)"){ ?> disabled <?php } ?>></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขไมล์ปลาย&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="mileageend" name="mileageend" value="<?=$OILTMLED;?>" ></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">จำนวนน้ำมัน(ลิตร)&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="oilamout" name="oilamout" value="<?=$OILTOAM;?>" <?php if($_SESSION["ROLENAME"] != "ADMIN" && $_SESSION["ROLENAME"] != "PLANNING(AMT)" && $_SESSION["ROLENAME"] != "PLANNING(GW)"){ ?> disabled <?php } ?>></th>
                        </tr>
                        <tr>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">วันที่เติมน้ำมัน&nbsp;&nbsp;</th>
                            <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="daterefuel" name="daterefuel" value="<?=$OILTRFD;?>" disabled></th>
                        </tr>
                        <?php if($_SESSION['ROLENAME']=="ADMIN" || $_SESSION["ROLENAME"] == "PLANNING(AMT)" || $_SESSION["ROLENAME"] == "PLANNING(GW)"){ ?>
                            <tr>
                                <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">หมายเหตุ&nbsp;&nbsp;</th>
                                <th colspan="3" bgcolor="#CCCCCC" style="text-align:left;"><input type="text" style="border:0px;width:100%" id="oilremark" name="oilremark" value="<?=$RS_OILREMARK;?>" <?php if($_SESSION["ROLENAME"] != "ADMIN" && $_SESSION["ROLENAME"] != "PLANNING(AMT)" && $_SESSION["ROLENAME"] != "PLANNING(GW)"){ ?> disabled <?php } ?>></th>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <input type="hidden" name="oldjoboil" id="oldjoboil" value="<?=$RSJOBNO2;?>">
                <input type="hidden" name="oiltatid" id="oiltatid" value="<?=$OILTID;?>">
                <input type="hidden" name="username" id="username" value="<?=$USERNAME;?>">
                <div class="modal-footer">
                    <?php if($_SESSION['ROLENAME']=="ADMIN" || $_SESSION["ROLENAME"] == "PLANNING(AMT)" || $_SESSION["ROLENAME"] == "PLANNING(GW)"){ ?>
                        <button type="button" class="btn btn-primary" name="updatejob" onclick="updateoiltatsuno_byadmin()" value="butupdate_byadmin" id="butupdate_byadmin"><span class="fa fa-save"></span> บันทึกการแก้ไข</button>
                    <?php }else{ ?>
                        <button type="button" class="btn btn-primary" name="updatejob" onclick="updateoiltatsuno()" value="updatejob" id="butupdate"><span class="fa fa-save"></span> บันทึกการแก้ไข</button>
                    <?php } ?>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="javascript:location.reload();"><span class="fa fa-close"></span> ปิด</button>
                </div>
            </form>
        </div>
    </div>
<?php }
if ($_POST['txt_flg'] == "select_checkoil") {     
    $jobno=$_POST['jobno'];
    // echo $jobno.'<br>';
    $SQLCHKOIL = "SELECT *,
        CASE WHEN (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VEHICLETRANSPORTPLANID AND OSGS_TY IN(1,2,3)) > 0 THEN (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VEHICLETRANSPORTPLANID AND OSGS_TY IN(1,2,3))
            ELSE 0 END OSGS_OUT,
        CASE WHEN (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VEHICLETRANSPORTPLANID AND OSGS_TY = 4) > 0 THEN (SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = VEHICLETRANSPORTPLANID AND OSGS_TY = 4)
            ELSE 0 END OSGS_PM,
        CONVERT (VARCHAR (16),OILT.REFUELINGDATE,29) CONREFUELINGDATE FROM RTMS.dbo.VEHICLETRANSPORTPLAN VHCTPP
        LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OILT ON (VHCTPP.JOBNO = OILT.JOBNO COLLATE Thai_CI_AI)
        WHERE VHCTPP.JOBNO = '$jobno'";
    $QUERYOIL = sqlsrv_query($conn, $SQLCHKOIL );  
    $RESULTOIL = sqlsrv_fetch_array($QUERYOIL, SQLSRV_FETCH_ASSOC);
    $OAM=$RESULTOIL["OIL_AMOUNT"];
    $CHKOUT=$RESULTOIL["OSGS_OUT"];
    $CHKPM=$RESULTOIL["OSGS_PM"];
    if(($OAM > 0) && ($CHKOUT > 0) && ($CHKPM > 0)){
        $CALOAM=($OAM+$CHKOUT)-$CHKPM;
        $REMARK='(เติมใน+เติมนอก)-PM';
    }else if(($OAM > 0) && ($CHKOUT > 0) && ($CHKPM == '0')){
        $CALOAM=$OAM+$CHKOUT;
        $REMARK='เติมใน+เติมนอก';
    }else if(($OAM > 0) && ($CHKOUT == '0') && ($CHKPM > 0)){
        $CALOAM=$OAM-$CHKPM;
        $REMARK='เติมใน-PM';
    }else{        
        $REMARK='ลิตร';
        $CALOAM=$OAM;
    }
    if(isset($RESULTOIL["DISTANCE"])){
        $DISTANCE=$RESULTOIL["DISTANCE"];
        $CALAVG= $DISTANCE / $CALOAM;
        $RSCALAVG=number_format($CALAVG, 2);
    }else{
        $DISTANCE='';
        $CALAVG='';
        $RSCALAVG='';
    }

?>
    <div class="row">
        <div class="col-lg-12">                      
            <table id="bg-table" width="100%" style="" border="1">
                <thead>
                    <tr>
                        <th colspan="6" bgcolor="#CCCCCC" style="text-align: center"><b>ข้อมูลน้ำมัน</b></th>
                    </tr>                    
                </thead>
                <tbody>
                    <tr>
                        <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลข Job&nbsp;&nbsp;</th>
                        <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%;" value="<?=$jobno;?>" disabled></th>
                    </tr>
                    <tr>
                        <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขใบกำกับน้ำมัน&nbsp;&nbsp;</th>
                        <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" value="<?=$RESULTOIL["OIL_BILLNUMBER"];?>" disabled></th>
                    </tr>
                    <tr>
                        <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขไมล์ต้น&nbsp;&nbsp;</th>
                        <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" value="<?=$RESULTOIL["MILEAGESTART"];?>" disabled></th>
                    </tr>
                    <tr>
                        <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">เลขไมล์ปลาย&nbsp;&nbsp;</th>
                        <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" value="<?=$RESULTOIL["MILEAGEEND"];?>" disabled></th>
                    </tr>
                    <tr>
                        <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">ระยะทางรวม&nbsp;&nbsp;</th>
                        <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" value="<?=$RESULTOIL["DISTANCE"];?>" disabled></th>
                    </tr>
                    <tr>
                        <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">จำนวนน้ำมัน(<small><?=$REMARK;?></small>)&nbsp;&nbsp;</th>
                        <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" value="<?=$CALOAM;?>" disabled></th>
                    </tr>
                    <tr>
                        <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">วันที่เติมน้ำมัน&nbsp;&nbsp;</th>
                        <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" value="<?=$RESULTOIL["CONREFUELINGDATE"];?>" disabled></th>
                    </tr>
                    <tr>
                        <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">ค่าเฉลี่ยมาตรฐานที่กำหนด&nbsp;&nbsp;</th>
                        <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" value="<?=$RESULTOIL['RS_OILAVERAGE'];?>" disabled></th>
                    </tr>
                    <tr>
                        <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">ค่าเฉลี่ยน้ำมันที่ได้&nbsp;&nbsp;</th>
                        <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" value="<?=$RSCALAVG;?>" disabled></th>
                    </tr>
                    <tr>
                        <th colspan="3" bgcolor="#CCCCCC" style="text-align:right;">ยอดเงินที่ได้&nbsp;&nbsp;</th>
                        <th colspan="3" bgcolor="#FFFFFF" style="text-align:left;"><input type="text" style="border:0px;width:100%" value="<?=$RESULTOIL["C3"];?>" disabled></th>
                    </tr>
                </tbody>
            </table>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
            </div>
        </div>
    </div>
<?php }
if ($_POST['txt_flg'] == "select_cashoil") { 
    $conditionEHR = " AND a.PersonID ='" . $_SESSION["EMPLOYEEID"] . "'";
    $sql_seEHR = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEHR = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($conditionEHR, SQLSRV_PARAM_IN)
    );
    $query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
    $result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);
                                                 
    date_default_timezone_set('Asia/Bangkok');
    $datestartoil=$_POST['datestartoil'];
    $dateendoil=$_POST['dateendoil'];

    $date1 = $datestartoil;
    $start = explode("/", $date1);
    $startd = $start[0];
    $startif = $start[1];        
        if($startif=='01'){
            $selectmonth = "มกราคม";
            $selectmonthstart = "ม.ค.";
        }else if($startif=='02'){
            $selectmonth = "กุมภาพันธ์";
            $selectmonthstart = "ก.พ.";
        }else if($startif=='03'){
            $selectmonth = "มีนาคม";
            $selectmonthstart = "มี.ค.";
        }else if($startif=='04'){
            $selectmonth = "เมษายน";
            $selectmonthstart = "เม.ย.";
        }else if($startif=='05'){
            $selectmonth = "พฤษภาคม";
            $selectmonthstart = "พ.ค.";
        }else if($startif=='06'){
            $selectmonth = "มิถุนายน";
            $selectmonthstart = "มิ.ย.";
        }else if($startif=='07'){
            $selectmonth = "กรกฎาคม";
            $selectmonthstart = "ก.ค.";
        }else if($startif=='08'){
            $selectmonth = "สิงหาคม";
            $selectmonthstart = "ส.ค.";
        }else if($startif=='09'){
            $selectmonth = "กันยายน";
            $selectmonthstart = "ก.ย.";
        }else if($startif=='10'){
            $selectmonth = "ตุลาคม";
            $selectmonthstart = "ต.ค.";
        }else if($startif=='11'){
            $selectmonth = "พฤศจิกายน";
            $selectmonthstart = "พ.ย.";
        }else if($startif=='12'){
            $selectmonth = "ธันวาคม";
            $selectmonthstart = "ธ.ค.";
        }
    $start_yen = $start[2];
    $start_yth = $start[2]+543;
    $start_ymd = $start[2].'-'.$start[1].'-'.$start[0];

    $date2 = $dateendoil;
    $end = explode("/", $date2);
    $endd = $end[0];
    $endif = $end[1];            
        if($startif=='01'){
            $selectmonth = "มกราคม";
            $selectmonthend = "ม.ค.";
        }else if($startif=='02'){
            $selectmonth = "กุมภาพันธ์";
            $selectmonthend = "ก.พ.";
        }else if($startif=='03'){
            $selectmonth = "มีนาคม";
            $selectmonthend = "มี.ค.";
        }else if($startif=='04'){
            $selectmonth = "เมษายน";
            $selectmonthend = "เม.ย.";
        }else if($startif=='05'){
            $selectmonth = "พฤษภาคม";
            $selectmonthend = "พ.ค.";
        }else if($startif=='06'){
            $selectmonth = "มิถุนายน";
            $selectmonthend = "มิ.ย.";
        }else if($startif=='07'){
            $selectmonth = "กรกฎาคม";
            $selectmonthend = "ก.ค.";
        }else if($startif=='08'){
            $selectmonth = "สิงหาคม";
            $selectmonthend = "ส.ค.";
        }else if($startif=='09'){
            $selectmonth = "กันยายน";
            $selectmonthend = "ก.ย.";
        }else if($startif=='10'){
            $selectmonth = "ตุลาคม";
            $selectmonthend = "ต.ค.";
        }else if($startif=='11'){
            $selectmonth = "พฤศจิกายน";
            $selectmonthend = "พ.ย.";
        }else if($startif=='12'){
            $selectmonth = "ธันวาคม";
            $selectmonthend = "ธ.ค.";
        }
    $end_yen = $end[2];
    $end_yth = $end[2]+543;
    $end_ymd = $end[2].'-'.$end[1].'-'.$end[0];
    // echo $datestartoil;
    // echo "<br>";
    // echo $dateendoil;
    // echo "<br>";
    // echo"<pre>";
    // print_r($_POST);
    // echo"</pre>";
    // exit();
    $DATESTART = str_replace('/', '-', $datestartoil);
    $CONVERTDATESTART = date("Y-m-d", strtotime($DATESTART) );
    // ECHO "<br>";
    $DATEEND = str_replace('/', '-', $dateendoil);
    $CONVERTDATEEND = date("Y-m-d", strtotime($DATEEND) );

    $EHR_PHC = $result_seEHR['PersonCode'];

?>
    <center><h3>ข้อมูลระหว่างวันที่ <?=$start[0].' '.$selectmonthstart.' '.$start_yth;?> -  <?=$end[0].' '.$selectmonthend.' '.$end_yth;?></h3></center>
    <table width="100%" class="table" >
        <thead>
            <tr>
                <?php
                $SQLPRICE = "SELECT DISTINCT OLP.PRICE, OLP.MONTH, OLP.YEAR FROM OILPEICE OLP WHERE OLP.COMPANYCODE IN('RCC','RATC','RRC') AND OLP.[YEAR] = '$start_yen' AND OLP.[MONTH] = '$selectmonth'";
                $QUERYPRICE = sqlsrv_query($conn, $SQLPRICE);
                $RSPRICE = sqlsrv_fetch_array($QUERYPRICE, SQLSRV_FETCH_ASSOC);   
                    $PRICE=$RSPRICE["PRICE"]; 
                ?>
                <th colspan="10" style="text-align: right">ราคาน้ำมันเดือน <?=$selectmonth?> = <?=$PRICE?> บาท</th>
                <th colspan="1" style="text-align: left"></th>
            </tr>
        </thead>
    </table>
    <table style="height: 100px;" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-tablecashoil" role="grid" aria-describedby="dataTables-example_info">
        <thead>
            <tr>
                <th style="text-align: center;width: 20px">ลำดับ</th>
                <!-- <th style="text-align: center;width: 120px">สถานะการจ่ายเงิน</th> -->
                <th style="text-align: center;width: 100px">วันที่เติมน้ำมัน</th>
                <th style="text-align: center;width: 80px">เลขบิลน้ำมัน</th>
                <th style="text-align: center;width: 70px">รหัสพนักงาน</th>
                <th style="text-align: center;width: 110px">ชื่อ-สกุล</th>
                <th style="text-align: center;width: 80px">ทะเบียนรถ</th>
                <th style="text-align: center;width: 80px">ชื่อรถ</th>
                <th style="text-align: center;width: 120px">ประเภทรถ</th>
                <th style="text-align: center;width: 150px">ต้นทาง</th>
                <th style="text-align: center;width: 150px">ปลายทาง</th>
                <th style="text-align: center;width: 70px">ไมล์ต้น</th>
                <th style="text-align: center;width: 70px">ไมล์ปลาย</th>
                <th style="text-align: center;width: 60px">ระยะทาง</th>
                <th style="text-align: center;width: 80px">น้ำมันที่ใช้</th>
                <th style="text-align: center;width: 100px">ค่าเฉลี่ยที่ได้</th>
                <th style="text-align: center;width: 120px">ค่าเฉลี่ยที่กำหนด</th>
                <th style="text-align: center;width: 100px">น้ำมันที่กำหนด</th>
                <th style="text-align: center;width: 100px">ส่วนต่างน้ำมัน</th>
                <th style="text-align: center;width: 100px">จำนวนเงินบาท</th>
                <th style="text-align: center;width: 200px">หมายเลขแผน</th>
                <th style="text-align: center;width: 70px">จำนวนเที่ยว</th>
                <th style="text-align: center;width: 70px">ประเภทงาน</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $stmm = "SELECT DISTINCT *
                FROM TEMP_CHAVGGW WHERE REFUEL BETWEEN '$CONVERTDATESTART' AND '$CONVERTDATEEND'                                                                         
                ORDER BY OBLNB ASC";
                $querystmm = sqlsrv_query($conn, $stmm );  
                $i = 1;
                $DTP = 0;
                while($objResult = sqlsrv_fetch_array($querystmm)) {       
                    $REFUEL=$objResult["REFUEL"];
                    $CONREFUEL = explode("-", $REFUEL);
                    $RSREFUEL = $CONREFUEL[2].'/'.$CONREFUEL[1].'/'.$CONREFUEL[0];
                    if($RSREFUEL!="//"){
                        $RSREFUEL=$RSREFUEL;
                    }else{
                        $RSCHKREFUEL="";
                    }
                    $OBLNB=$objResult["OBLNB"];
                    $EMP=$objResult["EMP"];
                    $EMPN=$objResult["EMPN"];
                    $VHCRG=$objResult["VHCRG"];
                    $VHCTN=$objResult["VHCTN"];
                    $VHCTPLAN=$objResult["VHCTPLAN"];
                    $JOBSTART=$objResult["JOBSTART"];
                    $JOBEND=$objResult["JOBEND"];
                    $MST=$objResult["MST"];
                    $MLE=$objResult["MLE"];
                    $DTE=$objResult["DTE"];
                    $CALDTE=$MLE-$MST;
                    $OAM=$objResult["OAM"];
                    $O4=$objResult["O4"];
                                                                
                    // $SQLC2IF="SELECT C2IF.EMPLOYEECODE1,STRING_AGG([C2],',') AS [C2] FROM VEHICLETRANSPORTPLAN C2IF  WHERE
                    // ( C2IF.EMPLOYEECODE1 = '$EMP' OR C2IF.EMPLOYEECODE2 = '$EMP' ) 
                    // AND CONVERT ( VARCHAR ( 10 ), C2IF.DATEWORKING, 20 ) = '$DWK' AND NOT STATUSNUMBER = 'X'      
                    // GROUP BY C2IF.EMPLOYEECODE1";
                    // $QUERYC2IF= sqlsrv_query($conn, $SQLC2IF );  
                    // $RESULTC2IF = sqlsrv_fetch_array($QUERYC2IF, SQLSRV_FETCH_ASSOC);
                    // $C2IF=$RESULTC2IF["C2"];

                    $C2IF=$objResult["C2"];
                    if($C2IF==','){
                        $C2='';
                    }else if($C2IF==''){
                        $C2='';
                    }else{
                        $C2='NOTNULL';
                    }
                    $C3=$objResult["C3"];
                    // $OAVG=$objResult["OAVG"];
                    $CALOAVG=$CALDTE/$OAM;
                    $OAVG=number_format($CALOAVG, 2);
                    
                    $DWK=$objResult["DWK"];   
                                                                                                
                    // $SQLCHKWORK="SELECT SCPT.EMPLOYEECODE1,STRING_AGG([WORKTYPE],',') AS [CHKWORK] FROM VEHICLETRANSPORTPLAN SCPT  WHERE
                    // ( SCPT.EMPLOYEECODE1 = '$EMP' OR SCPT.EMPLOYEECODE2 = '$EMP' ) 
                    // AND CONVERT ( VARCHAR ( 10 ), SCPT.DATEWORKING, 20 ) = '$DWK' AND NOT STATUSNUMBER = 'X' 
                    // GROUP BY SCPT.EMPLOYEECODE1";
                    // $QUERYCHKWORK= sqlsrv_query($conn, $SQLCHKWORK );  
                    // $RESULTCHKWORK = sqlsrv_fetch_array($QUERYCHKWORK, SQLSRV_FETCH_ASSOC);
                    // $CHKWORK=$RESULTCHKWORK["CHKWORK"]; 
                    $CHKWORK=$objResult["CHKWORK"]; 

                    if($CHKWORK==","){$CHKWORKIF="";}else if($CHKWORK==",,"){$CHKWORKIF="";}else if($CHKWORK==",,,"){$CHKWORKIF="";}else if($CHKWORK==",,,,"){$CHKWORKIF="";}else{$CHKWORKIF=$CHKWORK;}
                    
                    
                    $CHKW = explode(",", $CHKWORK);
                    $RSCHKW1 = $CHKW[0];
                    $RSCHKW2 = $CHKW[1];
                    $RSCHKW3 = $CHKW[2];
                    $RSCHKW4 = $CHKW[3];

                    $VHCTPPCOM=$objResult["VHCTPPCOM"];
                    $VHCTPPCUS=$objResult["VHCTPPCUS"];
                                                                
                    // $SQLCHKROUND="SELECT COUNT( VHCTPP.EMPLOYEECODE1 ) COUNTROUNDAMOUT FROM VEHICLETRANSPORTPLAN VHCTPP 
                    // WHERE (VHCTPP.EMPLOYEECODE1 = '$EMP' OR VHCTPP.EMPLOYEECODE2 = '$EMP') AND CONVERT ( VARCHAR ( 10 ), VHCTPP.DATEWORKING, 20 ) = '$DWK' AND NOT STATUSNUMBER = 'X'";
                    // $QUERYROUND = sqlsrv_query($conn, $SQLCHKROUND );  
                    // // while($objResult = sqlsrv_fetch_array($querystmm)) {
                    // $RESULTROUND = sqlsrv_fetch_array($QUERYROUND, SQLSRV_FETCH_ASSOC);
                    // $CALROUND=$RESULTROUND["COUNTROUNDAMOUT"];
                    $CALROUND=$objResult["COUNTROUNDAMOUT"];
                    
                    if(($VHCTN=='T-001')||($VHCTN=='T-002')||($VHCTN=='T-003')||($VHCTN=='T-004')){                             // ชื่อรถ T001 - T004
                        if($VHCTPPCUS=='GMT'){                                                                                      // ถ้าเป็นลูกค้า GMT
                            $RSCHKWORKAVG='4.25';                                                                                       // คิด 4.25
                        }else{                                                                                                      // ถ้าไม่ใช่ลูกค้า GMT
                            $RSCHKWORKAVG='5.00';                                                                                       // คิด 5.00
                        }                                                                                     
                    }else if(($VHCTN=='T-005')||($VHCTN=='T-006')||($VHCTN=='T-007')||($VHCTN=='T-008')||($VHCTN=='T-009')){    // ชื่อรถ T001 - T004
                        $RSCHKWORKAVG='4.75';                                                                                            // คิด 4.75
                    }else if(($VHCTN=='G-001')||($VHCTN=='G-002')||($VHCTN=='G-003')||($VHCTN=='G-004')||($VHCTN=='G-005')||
                            ($VHCTN=='G-006')||($VHCTN=='G-007')||($VHCTN=='G-008')||($VHCTN=='G-009')||($VHCTN=='G-010')||
                            ($VHCTN=='G-011')||($VHCTN=='G-012')||($VHCTN=='G-013')){                                           // ชื่อรถ G001 - G0013
                        if($VHCTPLAN=="10W(Dump)"){                                                                                 // ถ้าเป็นรถ 10W
                            $RSCHKWORKAVG='4.25';                                                                                       // คิด 4.25
                        }else if($VHCTPLAN=="22W(Dump)"){                                                                           // ถ้าเป็นรถ 22W
                            $RSCHKWORKAVG='3.00';                                                                                       // คิด 3.00
                        }                                                                                     
                    }else if($C2!=""){                                          // ถ้าเป็นงานรับกลับ
                        $RSCHKWORKAVG='3.75';                                       // 3.75
                    }else{
                        if(($CALROUND=='1')){                                   // 1 เที่ยว
                            if($RSCHKW1=='sh'){
                                $RSCHKWORKAVG='4.25';                               // sh = 3.75 // แก้เป็น 4.25 วันที่ 6/9/2023
                            }else if($RSCHKW1=='nm'){
                                $RSCHKWORKAVG='4.25';                               // nm = 4.25 
                            }else{
                                $RSCHKWORKAVG=$objResult["OTG"];                // เรทปกติจากระบบ 
                            }
                        }else if($CALROUND=='2'){                               // 2 เที่ยว                                                                   
                            if(($RSCHKW1=='sh')&&($RSCHKW2=='sh')){ 
                                $RSCHKWORKAVG='3.75';                               // sh-sh = 3.75
                            }else if(($RSCHKW1=='sh')&&($RSCHKW2=='nm')){
                                $RSCHKWORKAVG='4.25';                               // sh-nm = 4.25
                            }else if(($RSCHKW1=='nm')&&($RSCHKW2=='sh')){
                                $RSCHKWORKAVG='3.75';                               // nm-sh = 3.75  
                            }else if(($RSCHKW1=='nm')&&($RSCHKW2=='nm')){
                                $RSCHKWORKAVG='4.25';                               // nm-nm = 4.25                                                                        
                            }else{
                                $RSCHKWORKAVG=$objResult["OTG"]; // เรทปกติจากระบบ                                                                    
                            }
                        }else{
                            $RSCHKWORKAVG=$objResult["OTG"]; // เรทปกติจากระบบ                                                                    
                        }
                    }

                    $OTG=$objResult["OTG"];
                    $CALOTG=$CALDTE/$RSCHKWORKAVG;
                    $CALOTG2=number_format($CALOTG, 2);
                    $CALDO=$CALOTG-$OAM;
                    $DIFFOIL=round($CALDO);
                    $DIFFOIL2=number_format($DIFFOIL, 2);
                    
                    
                    $EMP=$objResult["EMP"];
                    $EMP222=$objResult["EMP222"];
                    // echo 'คนที่ 1 '.$EMP.'<br>';
                    // echo 'คนที่ 2 '.$EMP222.'<br>';
                    if($EMP222==$EMP){
                        $CALPRICE=$DIFFOIL2*$PRICE;
                        // echo 'รหัส 1 ตรงกับรหัส 2 = ส่วนต่าง*ราคา = '.$CALPRICE.'<br>';
                    }else if($EMP222!=$EMP){
                        if($EMP222!=""){
                            $CALPRICE=($DIFFOIL2*$PRICE)/2;
                            // echo 'รหัส 1 ไม่ตรงกับรหัส 2 = (ส่วนต่าง*ราคา)/2 = '.$CALPRICE.'<br>';
                        }else{
                            $CALPRICE=$DIFFOIL2*$PRICE;
                            // echo 'รหัส 1 ไม่ตรงกับรหัส 2 แต่ไปคนเดียว = ส่วนต่าง*ราคา = '.$CALPRICE.'<br>';
                        }
                    }

                    $CONFIRM=$objResult["CONFIRM"];
                    $WDOAVG_CREATE_DATE=$objResult["WDOAVG_CREATE_DATE"];
                    $WDOAVG_CAD = explode("-", $WDOAVG_CREATE_DATE);
                    if($CONFIRM!=""){
                        $RSCAD=$WDOAVG_CAD[2].'/'.$WDOAVG_CAD[1].'/'.$WDOAVG_CAD[0];
                    }else{
                        $RSCAD="";
                    }
                    
                    $OILID=$objResult["OILID"];
                    $VHCTPPID=$objResult["VHCTPPID"];
                    $CNB=$objResult["CNB"];
                    $VHCTOIL=$objResult["VHCTOIL"];
                    $ENGY=$objResult["ENGY"];
                    $WORKTYPE=$objResult["WORKTYPE"];
                    $JNOIL=$objResult["JNOIL"];
                    $JNPLAN=$objResult["JNPLAN"];
                    
                    $WDOAVG_ID=$objResult["WDOAVG_ID"];


                    if($WDOAVG_ID==""){
                        $RSWDOAVG_ID = 'style="text-align: center;background-color: #F79646"';
                    }else if($WDOAVG_ID!=""){
                        $RSWDOAVG_ID = 'style="text-align: center;background-color: #449D44"';
                    }
                    
            ?>
            <tr>
                <td style="text-align: center;"><?=$i?></td>
                <!-- <td <?=$RSWDOAVG_ID?>>
                    <?php if($WDOAVG_ID==""){ ?> 
                        <a href="javascript:;"
                            data-refuel="<?=$RSREFUEL;?>"
                            data-oblnb="<?=$OBLNB;?>"
                            data-empn="<?=$EMPN;?>"
                            data-vhcrg="<?=$VHCRG;?>"
                            data-jobend="<?=$JOBEND;?>"
                            data-vhcth="<?=$VHCTN;?>"
                            data-oam="<?=$OAM;?>"
                            data-calprice="<?=number_format($CALPRICE, 2);?>"
                            data-mst="<?=$MST;?>"
                            data-mle="<?=$MLE;?>"
                            data-caldte="<?=$CALDTE;?>"
                            data-emp="<?=$EMP;?>"
                            data-vhcttpid="<?=$VHCTPPID;?>"
                            data-oilid="<?=$OILID;?>"
                            data-oavg="<?=$OAVG;?>"
                            data-otg="<?=$OTG;?>"
                            data-calotg="<?=number_format($CALOTG, 2);?>"
                            data-diffoil="<?=number_format($DIFFOIL, 2);?>"
                            data-status="1"
                            data-session="<?=$_SESSION["USERNAME"];?>"
                            data-toggle="modal" data-target="#CONFIRM_APPROVE"><font color="black"><b> รอจ่าย</b></font>
                        </a>  
                    <?php }else if($WDOAVG_ID!=""){ ?> 
                        <a href="#" data-toggle="modal" data-target="#DETAILPLANTOTAL_<?=$DTP?>"><font color="black"><b> จ่ายแล้ว</b></font></a>  
                    <?php } ?>  
                </td> -->
                <td style="text-align: center;"><?=$RSREFUEL?></td>
                <td style="text-align: center;"><?=$OBLNB?></td>
                <td style="text-align: center;"><?=$EMP?></td>
                <td style="text-align: left;"><?=$EMPN?></td>
                <td style="text-align: center;"><?=$VHCRG?></td>
                <td style="text-align: center;"><?=$VHCTN?></td>
                <!-- <td style="text-align: center;">[<?=$CALDTE?>] [<?=$CALOTG2?>] [<?=$DIFFOIL2?>] [<?=$CALPRICE?>]</td> -->
                <td style="text-align: center;"><?=$VHCTPLAN?></td>
                <td style="text-align: center;"><?=$JOBSTART?></td>
                <td style="text-align: center;"><?=$JOBEND?></td>
                <td style="text-align: center;"><?=$MST?></td>
                <td style="text-align: center;"><?=$MLE?></td>
                <td style="text-align: center;"><?=$CALDTE?></td>
                <td style="text-align: center;"><?=$OAM?></td>
                <td style="text-align: center;"><?=$OAVG?></td>
                <td style="text-align: center;"><?=$RSCHKWORKAVG?></td>
                <td style="text-align: center;"><?=number_format($CALOTG, 2)?></td>
                <td style="text-align: center;"><?=number_format($DIFFOIL, 2)?></td>
                <td style="text-align: center;"><?=number_format($CALPRICE, 2)?></td>
                <td style="text-align: center;"><?=$JNPLAN?></td>
                <td style="text-align: center;"><?=$CALROUND?></td>
                <td style="text-align: center;"><?=$CHKWORKIF?></td>
            </tr>                                                                
            <div class="modal fade" id="DETAILPLANTOTAL_<?=$DTP?>"><!-- data-backdrop="static" -->
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">รายละเอียด : <small><?=$JNPLAN?></small></h4>
                        </div>
                        <div class="modal-body">                                                                                
                            <div class="row">
                                <!-- <form name="form1" action="meg_cashoilaverage_save.php" target="_blank" method="post"> -->
                                <form id="fupForm" name="form1" method="post">
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>วันที่เติมน้ำมัน : <?=$RSREFUEL?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>รหัสพนักงาน : <?=$EMP?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>เลขบิลน้ำมัน : <?=$OBLNB?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>ชื่อ-สกุล : <?=$EMPN?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>ทะเบียนรถ : <?=$VHCRG?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>งานที่ขนส่ง : <?=$JOBEND?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>ชื่อรถ : <?=$VHCTN?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>ระยะทาง : <?=$CALDTE?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>น้ำมันที่ใช้ : <?=$OAM?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>จำนวนเงิน : <?=number_format($CALPRICE, 2)?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>ผู้จ่ายเงิน : <?=$CONFIRM?></b></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="col-xl-6 text-muted"><b>วันที่จ่ายเงิน : <?=$RSCAD?></b></p>
                                    </div>
                                </div>                                                                                    
                                <input type="hidden" name="WDOAVG_OAM" id="WDOAVG_OAM" value="<?=$OAM;?>">
                                <input type="hidden" name="WDOAVG_PRICE" id="WDOAVG_PRICE" value="<?=number_format($CALPRICE, 2);?>">
                                <input type="hidden" name="WDOAVG_DISTANCE" id="WDOAVG_DISTANCE" value="<?=$CALDTE;?>">
                                <input type="hidden" name="WDOAVG_PERSONCODE" id="WDOAVG_PERSONCODE" value="<?=$EMP;?>">
                                <input type="hidden" name="WDOAVG_PLANID" id="WDOAVG_PLANID" value="<?=$VHCTPPID;?>">
                                <input type="hidden" name="WDOAVG_OILTATID" id="WDOAVG_OILTATID" value="<?=$OILID;?>">
                                <input type="hidden" name="WDOAVG_OAVG" id="WDOAVG_OAVG" value="<?=$OAVG;?>">
                                <input type="hidden" name="WDOAVG_OAVGTG" id="WDOAVG_OAVGTG" value="<?=$OTG;?>">
                                <input type="hidden" name="WDOAVG_OILTG" id="WDOAVG_OILTG" value="<?=number_format($CALOTG, 2);?>">
                                <input type="hidden" name="WDOAVG_DIFFOIL" id="WDOAVG_DIFFOIL" value="<?=number_format($DIFFOIL, 2);?>">
                                <input type="hidden" name="WDOAVG_STATUS" id="WDOAVG_STATUS" value="1">
                                <input type="hidden" name="username" id="username" value="<?=$_SESSION["USERNAME"];?>">
                                <center>                               
                                        <div class="col-12">
                                            <!-- <button type="submit" class="btn btn-success btn-md" name="updatejob" onclick="updateoiltatsuno()" value="updatejob" id="butupdate">ยืนยันการจ่ายเงิน</button>&nbsp;&nbsp;&nbsp;&nbsp; -->
                                            <button type="button" class="btn btn-danger btn-md" data-dismiss="modal" onClick="javascript:location.reload();">ยกเลิก</button><!-- onClick="javascript:location.reload();" -->
                                        </div>
                                </center>   
                            </form>                                                                             
                        </div>
                    </div>
                </div>
            </div>
            <?php $DTP++; $i++; } ?>
        </tbody>
    </table>
<?php }
if ($_POST['txt_flg'] == "select_oilmonthavarage") { 
    $conditionEHR = " AND a.PersonID ='" . $_SESSION["EMPLOYEEID"] . "'";
    $sql_seEHR = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEHR = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($conditionEHR, SQLSRV_PARAM_IN)
    );
    $query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
    $result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);
                                                 
    date_default_timezone_set('Asia/Bangkok');
    $datestartoil=$_POST['datestartoilmonthavarage'];
    $dateendoil=$_POST['dateendoilmonthavarage'];
    
    $LINEOFWORK=$_POST['lineofworkmonth'];
    if($LINEOFWORK!=""){
        if($LINEOFWORK == 'CS'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%CS%'";
        }else if($LINEOFWORK == 'TTKN'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%T-Tohken%'";
        }else if($LINEOFWORK == 'STM'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%STM%'";
        }else if($LINEOFWORK == 'KBT'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%KUBOTA%'";
        }else if($LINEOFWORK == 'TTDK'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%TGT%'";
        }else if($LINEOFWORK == 'SC10'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%พนักงานขับรถ%' AND EHR.Company_Code = 'RKR' AND NOT EHR.PositionNameT IN ('พนักงานขับรถ/CS','พนักงานขับรถ/RKL-STC')";
        }else if($LINEOFWORK == 'SCCL'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND EHR.PositionNameT LIKE '%พนักงานขับรถ/RKL-STC%' AND EHR.Company_Code = 'RKL' ";
        }else if($LINEOFWORK == 'OTHER'){
            $QUERYWHERE1="OTSN.JOBNO != '' AND NOT EHR.PositionNameT LIKE '%พนักงานขับรถ%' AND NOT EHR.PositionNameT LIKE '%KUBOTA%' ";
        }
    }else{
        $QUERYWHERE1="OTSN.JOBNO != ''";
    }

    $date1 = $datestartoil;
    $start = explode("/", $date1);
    $startd = $start[0];
    $startif = $start[1];        
        if($startif=='01'){
            $selectmonth = "มกราคม";
            $selectmonthstart = "ม.ค.";
        }else if($startif=='02'){
            $selectmonth = "กุมภาพันธ์";
            $selectmonthstart = "ก.พ.";
        }else if($startif=='03'){
            $selectmonth = "มีนาคม";
            $selectmonthstart = "มี.ค.";
        }else if($startif=='04'){
            $selectmonth = "เมษายน";
            $selectmonthstart = "เม.ย.";
        }else if($startif=='05'){
            $selectmonth = "พฤษภาคม";
            $selectmonthstart = "พ.ค.";
        }else if($startif=='06'){
            $selectmonth = "มิถุนายน";
            $selectmonthstart = "มิ.ย.";
        }else if($startif=='07'){
            $selectmonth = "กรกฎาคม";
            $selectmonthstart = "ก.ค.";
        }else if($startif=='08'){
            $selectmonth = "สิงหาคม";
            $selectmonthstart = "ส.ค.";
        }else if($startif=='09'){
            $selectmonth = "กันยายน";
            $selectmonthstart = "ก.ย.";
        }else if($startif=='10'){
            $selectmonth = "ตุลาคม";
            $selectmonthstart = "ต.ค.";
        }else if($startif=='11'){
            $selectmonth = "พฤศจิกายน";
            $selectmonthstart = "พ.ย.";
        }else if($startif=='12'){
            $selectmonth = "ธันวาคม";
            $selectmonthstart = "ธ.ค.";
        }
    $start_yen = $start[2];
    $start_yth = $start[2]+543;
    $start_ymd = $start[2].'-'.$start[1].'-'.$start[0];

    $date2 = $dateendoil;
    $end = explode("/", $date2);
    $endd = $end[0];
    $endif = $end[1];            
        if($startif=='01'){
            $selectmonth = "มกราคม";
            $selectmonthend = "ม.ค.";
        }else if($startif=='02'){
            $selectmonth = "กุมภาพันธ์";
            $selectmonthend = "ก.พ.";
        }else if($startif=='03'){
            $selectmonth = "มีนาคม";
            $selectmonthend = "มี.ค.";
        }else if($startif=='04'){
            $selectmonth = "เมษายน";
            $selectmonthend = "เม.ย.";
        }else if($startif=='05'){
            $selectmonth = "พฤษภาคม";
            $selectmonthend = "พ.ค.";
        }else if($startif=='06'){
            $selectmonth = "มิถุนายน";
            $selectmonthend = "มิ.ย.";
        }else if($startif=='07'){
            $selectmonth = "กรกฎาคม";
            $selectmonthend = "ก.ค.";
        }else if($startif=='08'){
            $selectmonth = "สิงหาคม";
            $selectmonthend = "ส.ค.";
        }else if($startif=='09'){
            $selectmonth = "กันยายน";
            $selectmonthend = "ก.ย.";
        }else if($startif=='10'){
            $selectmonth = "ตุลาคม";
            $selectmonthend = "ต.ค.";
        }else if($startif=='11'){
            $selectmonth = "พฤศจิกายน";
            $selectmonthend = "พ.ย.";
        }else if($startif=='12'){
            $selectmonth = "ธันวาคม";
            $selectmonthend = "ธ.ค.";
        }
    $end_yen = $end[2];
    $end_yth = $end[2]+543;
    $end_ymd = $end[2].'-'.$end[1].'-'.$end[0];
    // echo $datestartoil;
    // echo "<br>";
    // echo $dateendoil;
    // echo "<br>";
    // echo"<pre>";
    // print_r($_POST);
    // echo"</pre>";
    // exit();
    $DATESTART = str_replace('/', '-', $datestartoil);
    $CONVERTDATESTART = date("Y-m-d", strtotime($DATESTART) );
    // ECHO "<br>";
    $DATEEND = str_replace('/', '-', $dateendoil);
    $CONVERTDATEEND = date("Y-m-d", strtotime($DATEEND) );

    $EHR_PHC = $result_seEHR['PersonCode'];

?>
<table style="height: 70px;" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables_oilmonthavarage" role="grid" aria-describedby="dataTables-example_info" >
    <thead>
        <tr>
            <th style="text-align: center;width: 20px">ลำดับ</th>
            <th style="text-align: center;width: 110px">รหัสพนักงาน</th>
            <th style="text-align: center;width: 110px">ชื่อ-สกุล</th>
            <th style="text-align: center;width: 110px">จำนวนเที่ยว</th>
            <th style="text-align: center;width: 110px">ทะเบียนรถ</th>
            <th style="text-align: center;width: 120px">ปลายทาง</th>
            <th style="text-align: center;width: 100px">งานที่ขนส่ง</th>
            <th style="text-align: center;width: 80px">ไมล์ต้น</th>
            <th style="text-align: center;width: 80px">ไมล์ปลาย</th>
            <th style="text-align: center;width: 80px">ระยะทาง</th>
            <th style="text-align: center;width: 80px">น้ำมันที่ใช้</th>
            <th style="text-align: center;width: 120px">ค่าเฉลี่ยที่กำหนด</th>
            <th style="text-align: center;width: 110px">ค่าเฉลี่ยที่ได้</th>
            <th style="text-align: center;width: 110px">รวมเงิน</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql="SELECT
                    DISTINCT
                    OTSN.OILDATAID OILID,
                    CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                    OTSN.JOBNO JN1,
                    VHCTPP.EMPLOYEECODE1 EMP1,
                    VHCTPP.EMPLOYEENAME1 EMPN1,
                    EHR.PositionNameT,
                    CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) WORK,
                    OTSN.OIL_BILLNUMBER OBLNB,
                    OTSN.CARDNUMBER CNB,
                    OTSN.VEHICLEREGISNUMBER VHCRG,
                    OTSN.VEHICLETYPE VHCT,
                    VHCTPP.VEHICLETYPE VHCTPLAN,
                    VHCIF.ENERGY ENGY,
                    OTSN.OIL_AMOUNT OAM,
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
                LEFT JOIN EMPLOYEEEHR2 EHR ON EHR.PersonCode = VHCTPP.EMPLOYEECODE1
                WHERE OTSN.JOBNO IS NOT NULL
                AND VHCTPP.COMPANYCODE != 'RRC' AND VHCTPP.COMPANYCODE != 'RATC' AND VHCTPP.COMPANYCODE != 'RCC'
                AND $QUERYWHERE1
                AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) BETWEEN '$CONVERTDATESTART' AND '$CONVERTDATEEND'  
                UNION
                SELECT
                    DISTINCT
                    OTSN.OILDATAID OILID,
                    CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                    OTSN.JOBNO JN1,
                    VHCTPP.EMPLOYEECODE2 EMP1,
                    VHCTPP.EMPLOYEENAME2 EMPN1,
                    EHR.PositionNameT,
                    CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) WORK,
                    OTSN.OIL_BILLNUMBER OBLNB,
                    OTSN.CARDNUMBER CNB,
                    OTSN.VEHICLEREGISNUMBER VHCRG,
                    OTSN.VEHICLETYPE VHCT,
                    VHCTPP.VEHICLETYPE VHCTPLAN,
                    VHCIF.ENERGY ENGY,
                    OTSN.OIL_AMOUNT OAM,
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
                LEFT JOIN EMPLOYEEEHR2 EHR ON EHR.PersonCode = VHCTPP.EMPLOYEECODE2
                WHERE OTSN.JOBNO IS NOT NULL
                AND VHCTPP.COMPANYCODE != 'RRC' AND VHCTPP.COMPANYCODE != 'RATC' AND VHCTPP.COMPANYCODE != 'RCC'
                AND $QUERYWHERE1
                AND CONVERT(VARCHAR (10),VHCTPP.DATEWORKING,20) BETWEEN '$CONVERTDATESTART' AND '$CONVERTDATEEND'  
                ORDER BY VHCTPP.EMPLOYEECODE1 ASC";
                $i = 1;
                $result = sqlsrv_query($conn, $sql );  
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
                    
                    $SQLCHKROUND="SELECT COUNT( VHCTPP.EMPLOYEECODE1 ) COUNTROUNDAMOUT FROM VEHICLETRANSPORTPLAN VHCTPP 
                    WHERE (VHCTPP.EMPLOYEECODE1 = '$EMP1' OR VHCTPP.EMPLOYEECODE2 = '$EMP1') AND CONVERT ( VARCHAR ( 10 ), VHCTPP.DATEWORKING, 20 ) = '$WORK' AND NOT STATUSNUMBER = 'X'";
                    $QUERYROUND = sqlsrv_query($conn, $SQLCHKROUND );  
                    // while($objResult = sqlsrv_fetch_array($querystmm)) {
                    $RESULTROUND = sqlsrv_fetch_array($QUERYROUND, SQLSRV_FETCH_ASSOC);
                    $CALROUND=$RESULTROUND["COUNTROUNDAMOUT"];

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
                    LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN ON VHCTPPEMP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                    WHERE OTSN.JOBNO IS NOT NULL
                    AND (VHCTPPEMP.EMPLOYEECODE1 = '$EMP1' OR VHCTPPEMP.EMPLOYEECODE2 = '$EMP1')
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
                        $RC3=$row["C3"];    $QRC3=$QRC3+$RC3;   
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
                            $RSC3=$C3;
                            $CALOAM=(($DTE/$OAM)-$OAVR);
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
        ?>
        <tr>
            <td align="center"><?=$i?></td>
            <td align="center"><?=$EMP1?></td>
            <td align="left"><?=$EMPN1?></td>
            <td align="center"><?=$CALROUND?></td>
            <td align="center"><?=$RSVHCRG;?></td>
            <td align="center"><?=$RSVHCT;?></td>
            <td align="center"><?=$JNED;?></td>
            <td align="right"><?=$RSMST;?></td>
            <td align="right"><?=$RSMLE;?></td>
            <td align="right"><?=$RSDTE;?></td>
            <td align="right"><?=$RSOAM;?></td>
            <td align="right"><?=$RSOTG;?></td>
            <td align="right"><?=$RSOAVG;?></td>
            <td align="right"><?=$RSC3;?></td>
        </tr>    
        <?php $i++; } } } ?>
    </tbody>
</table>
<?php }
if ($_POST['txt_flg'] == "notactioncaloavg") {     
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    $datestart = $_POST["datestart"];
    $dateend = $_POST["dateend"];    
?>
    <div class="row">
        <div class="col-lg-12">      
            <div class="row"> 
                <div class="col-lg-12">
                    <center><h3><b>ข้อมูลการ<font color='red'><u>ไม่กดคำนวณ</u></font>ค่าเฉลี่ยน้ำมัน ระหว่างวันที่ <?=$datestart?> - <?=$dateend?></b></h3></center>
                </div>
            </div>            
            <table style="height: 100px;" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-tablecashoil" role="grid" aria-describedby="dataTables-example_info">
                <thead>
                    <tr>
                        <th style="text-align: center;width: 1%">ลำดับ</th>
                        <th style="text-align: center;width: 8%">วันที่วิ่งงาน</th>
                        <th style="text-align: center;width: 10%">หมายเลขแผน</th>
                        <th style="text-align: center;width: 8%">เลขบิลน้ำมัน</th>
                        <!-- <th style="text-align: center;width: 8%">จำนวนน้ำมันที่บันทึก</th> -->
                        <!-- <th style="text-align: center;width: 8%">ยอดเงินค่าเฉลี่ยน้ำมัน</th> -->
                        <th style="text-align: center;width: 20%">พขร.1</th>
                        <th style="text-align: center;width: 20%">พขร.2</th>
                        <th style="text-align: center;width: 15%">สถานะปุ่มบันทึก</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i=0;
                        $notcaloavg="SELECT a.VEHICLETRANSPORTPLANID,b.OIL_BILLNUMBER OBLNB,a.EMPLOYEECODE1,a.EMPLOYEENAME1,a.EMPLOYEECODE2,a.EMPLOYEENAME2,b.OIL_AMOUNT OAM,a.O4,a.C3,a.JOBNO,a.SUBMITBUTTON SMBT,
                            CONVERT(VARCHAR(10),b.REFUELINGDATE,20) REFUEL20,
                            CONVERT(VARCHAR(10),b.REFUELINGDATE,103) REFUEL103,
                            CONVERT(VARCHAR(10),a.DATEWORKING,20) DWK20,
                            CONVERT(VARCHAR(10),a.DATEWORKING,103) DWK103,
                            CONVERT(CHAR(10),CONVERT(DATETIME,'$datestart',103),120) FIND,	
                            CASE WHEN a.SUBMITBUTTON = 1 THEN 'บันทึกค่าตอบแทนแล้ว' ELSE 'ยังไม่บันทึกค่าตอบแทน' END SUBMITBUTTON
                            FROM dbo.VEHICLETRANSPORTPLAN AS a
                            LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO AS b	ON b.JOBNO = a.JOBNO COLLATE Thai_CI_AI
                            WHERE a.SUBMITBUTTON = 1 AND a.O4 IS NULL AND b.JOBNO IS NOT NULL AND NOT a.JOBEND = 'คลังโคราช' AND NOT a.JOBSTART LIKE '%IP%'
                            AND CONVERT(VARCHAR(10),a.DATEWORKING,20) BETWEEN CONVERT(CHAR(10),CONVERT(DATETIME,'$datestart',103),120) AND CONVERT(CHAR(10),CONVERT(DATETIME,'$dateend',103),120)";
                        $querynotcaloavg = sqlsrv_query($conn, $notcaloavg);
                        while($resultnotcaloavg = sqlsrv_fetch_array($querynotcaloavg, SQLSRV_FETCH_ASSOC)) {
                            $i++;
                            if($resultnotcaloavg["SMBT"]==='1'){    $rscolorSMBT="Chartreuse"; }else{ $rscolorSMBT="Red";      }
                            if($resultnotcaloavg["O4"]===''){       $rscolorO4="Chartreuse"; }else{ $rscolorO4="Red";   }
                            if($resultnotcaloavg["C3"]===''){       $rscolorC3="Chartreuse"; }else{ $rscolorC3="Red";   }
                    ?>
                    <tr>
                        <td style="text-align: center;"><?=$i?></td>
                        <td style="text-align: center;"><?=$resultnotcaloavg["DWK103"]?></td>
                        <td style="text-align: center;"><?=$resultnotcaloavg["JOBNO"]?></td>
                        <td style="text-align: center;"><?=$resultnotcaloavg["OBLNB"]?></td>
                        <!-- <td style="text-align: center;" bgcolor="<?=$rscolorO4?>"><?=$resultnotcaloavg["O4"]?></td> -->
                        <!-- <td style="text-align: center;" bgcolor="<?=$rscolorC3?>"><?=$resultnotcaloavg["C3"]?></td> -->
                        <td style="text-align: left;"><?=$resultnotcaloavg["EMPLOYEECODE1"]?> - <?=$resultnotcaloavg["EMPLOYEENAME1"]?></td>
                        <td style="text-align: left;"><?=$resultnotcaloavg["EMPLOYEECODE2"]?> - <?=$resultnotcaloavg["EMPLOYEENAME2"]?></td>
                        <td style="text-align: center;" bgcolor="<?=$rscolorSMBT?>"><?=$resultnotcaloavg["SUBMITBUTTON"]?></td>
                    </tr>  
                    <?php } ?>    
					<?php if($i==0){ ?>
						<tr>
							<td colspan="7" align="center" bgcolor="#FFDDE2"><font color="#990000">- ไม่มีข้อมูล -</font></td>
						</tr>
					<?php } ?>
                </tbody>
            </table>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
            </div>
        </div>
    </div>
<?php }?>


<?php
sqlsrv_close($conn);
?>

