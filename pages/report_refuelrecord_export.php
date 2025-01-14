<?php
// echo"<pre>";
// print_r($_POST);
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
?>

<?php if ($_POST['EXCEL'] != "") { ?>
    <?php

        $RENAME= "รายงานรายละเอียดการเติมน้ำมัน";
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$RENAME.xls");
        header("Pragma: no-cache");
        header("Expires: ");

        session_start();
        date_default_timezone_set("Asia/Bangkok");
        ini_set('max_execution_time', 300);
        require_once("../class/meg_function.php");
        $conn = connect("RTMS");
        $sql_seSystime = "{call megGetdate_v2(?)}";
        $params_seSystime = array(array('select_getdate', SQLSRV_PARAM_IN));
        $query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
        $result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);

    ?>       
    
    <div class="wrapper">
        <section class="invoice">
            <h3><u><b>รายงานรายละเอียดการเติมน้ำมัน</b></u></h3><br>            
            <p>รายงาน ตั้งแต่วันที่ <b><?=$startd.' '.$startm.' '.$starty;?></b> ถึงวันที่ <b><?=$endd.' '.$endm.' '.$endy;?></b></p>

            <table id="NoExtention1" class="table table-bordered " style="font-size: 13px;" border="1" width="100%">
                <thead>
                    <tr>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">ลำดับ</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">วันที่เติมน้ำมัน</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">เลขบัตร</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">ทะเบียนรถ</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">ประเภทรถ</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">น้ำมัน</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">จำนวนลิตร</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">เลขไมล์ปลาย</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">ระยะทาง</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">อ้างอิง</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">หมายเลขบิลน้ำมัน</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">เส้นทาง</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">พขร.1</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">พขร.2</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">พขร.3</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">พขร.4</div></a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php                   
                        date_default_timezone_set('Asia/Bangkok');
                        $sql = "SELECT
                            -- DISTINCT
                            OTSN.OILDATAID OILID,
                            OTSN.JOBNO JN1,
                            VHCTPP.JOBNO JN2,
                            CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                            OTSN.CARDNUMBER CNB,
                            OTSN.VEHICLEREGISNUMBER VHCRG,
                            OTSN.VEHICLETYPE VHCT,
                            VHCIF.ENERGY ENGY,
                            OTSN.OIL_AMOUNT OAM,
                            OTSN.MILEAGEEND MLE,
                            OTSN.DISTANCE DTE,
                            OTSN.OIL_BILLNUMBER OBLNB,
                            VHCTPPDV.OILNUMBER ONB,
                            VHCTPP.JOBEND JE,
                            VHCTPP.EMPLOYEECODE1 EMP1,
                            VHCTPP.EMPLOYEECODE2 EMP2,
                            VHCTPP.EMPLOYEECODE3 EMP3,
                            VHCTPP.EMPLOYEECODE4 EMP4                        
                        FROM TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN
                        LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                        LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                        LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.OILNUMBER = OTSN.OIL_BILLNUMBER COLLATE Thai_CI_AI
                        LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.OILNUMBER = OTSN.OIL_BILLNUMBER COLLATE Thai_CI_AI
                        WHERE OTSN.JOBNO IS NOT NULL AND VHCTPP.JOBNO IS NOT NULL 
                        AND CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) BETWEEN '$startymd' AND '$endymd'
                        ORDER BY OTSN.OILDATAID ASC";                                                
                        $query = sqlsrv_query($conn, $sql );
                        $resultvalue = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
                        $result = sqlsrv_query($conn, $sql );
                        while($row = sqlsrv_fetch_array($result)) {                             
                            $OILID=$row["OILID"];                  
                            $JN1=$row["JN1"];                  
                            $JN2=$row["JN2"];                  
                            $REFUEL=$row["REFUEL"];                             
                            $CRF = explode("-", $REFUEL);
                            $DT1 = $CRF[0];
                            $DT2 = $CRF[1];
                            $DT3 = $CRF[2]; 
                            $CONREFUEL = $DT3.'/'.$DT2.'/'.$DT1;
                            $CNB=$row["CNB"];                  
                            $VHCRG=$row["VHCRG"];                  
                            $VHCT=$row["VHCT"];                  
                            $ENGY=$row["ENGY"];                  
                            $OAM=$row["OAM"];                  
                            $MLE=$row["MLE"];                  
                            $DTE=$row["DTE"];                 
                            $OBLNB=$row["OBLNB"];                 
                            $ONB=$row["ONB"];                 
                            $JE=$row["JE"];                 
                            $EMP1=$row["EMP1"];                 
                            $EMP2=$row["EMP2"];                 
                            $EMP3=$row["EMP3"];                 
                            $EMP4=$row["EMP4"]; 
                    ?>
                        <tr>
                            <td align="center"><?=++$REPORTEMPLOYEENAME;?></td>
                            <td align="center"><?=$CONREFUEL;?></td>
                            <td align="center"><?=$CNB;?></td>
                            <td align="center"><?=$VHCRG;?></td>
                            <td align="left"><?=$VHCT;?></td>
                            <td align="center"><?=$ENGY;?></td>
                            <td align="center"><?=$OAM;?></td>
                            <td align="left"><?=$MLE;?></td>
                            <td align="center"><?=$DTE;?></td>
                            <td align="center"></td>
                            <td align="center"><?=$OBLNB;?></td>
                            <td align="left"><?=$JE;?></td>
                            <td align="center"><?=$EMP1;?></td>
                            <td align="center"><?=$EMP2;?></td>
                            <td align="center"><?=$EMP3;?></td>
                            <td align="center"><?=$EMP4;?></td>
                        </tr>    
                    <?php } ?>                                                         
                </tbody>
            </table>          
        </section>
        <!-- /.content -->
    </div>
<?php }else if ($_POST['PDF'] != "") { ?>    
    <!DOCTYPE html>
    <?php
        session_start();
        date_default_timezone_set("Asia/Bangkok");
        ini_set('max_execution_time', 300);
        require_once("../class/meg_function.php");
        $conn = connect("RTMS");
        $sql_seSystime = "{call megGetdate_v2(?)}";
        $params_seSystime = array(array('select_getdate', SQLSRV_PARAM_IN));
        $query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
        $result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);
    ?>
    <html lang="en">
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>กลุ่มร่วมกิจรุ่งเรือง</title>
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        <style>
            .navbar-default {
                border-color: #ffcb0b;
            }
            #page-wrapper {
                border-left: 1px solid #ffcb0b;
            }
            .popover-content {
                padding: 10px 10px;
                width: 200px;
            }
        </style>
    </head>
    <body>

    <div class="wrapper">
        <section class="invoice">
            <h3><u><b>รายงานรายละเอียดการเติมน้ำมัน</b></u></h3><br>            
            <p>รายงาน ตั้งแต่วันที่ <b><?=$startd.' '.$startm.' '.$starty;?></b> ถึงวันที่ <b><?=$endd.' '.$endm.' '.$endy;?></b></p>

            <table style="font-size: 13px;" border="1" width="100%">
                <thead>
                    <tr>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">ลำดับ</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">วันที่เติมน้ำมัน</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">เลขบัตร</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">ทะเบียนรถ</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">ประเภทรถ</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">น้ำมัน</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">จำนวนลิตร</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">เลขไมล์ปลาย</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">ระยะทาง</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">อ้างอิง</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">หมายเลขบิลน้ำมัน</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">เส้นทาง</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">พขร.1</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">พขร.2</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">พขร.3</div></a></th>
                        <th style="background-color: #bfbfbf"><a data-toggle="tooltip" title=""><div align="center">พขร.4</div></a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php                   
                        date_default_timezone_set('Asia/Bangkok');
                        $sql = "SELECT
                            -- DISTINCT
                            OTSN.OILDATAID OILID,
                            OTSN.JOBNO JN1,
                            VHCTPP.JOBNO JN2,
                            CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) REFUEL,
                            OTSN.CARDNUMBER CNB,
                            OTSN.VEHICLEREGISNUMBER VHCRG,
                            OTSN.VEHICLETYPE VHCT,
                            VHCIF.ENERGY ENGY,
                            OTSN.OIL_AMOUNT OAM,
                            OTSN.MILEAGEEND MLE,
                            OTSN.DISTANCE DTE,
                            OTSN.OIL_BILLNUMBER OBLNB,
                            VHCTPPDV.OILNUMBER ONB,
                            VHCTPP.JOBEND JE,
                            VHCTPP.EMPLOYEECODE1 EMP1,
                            VHCTPP.EMPLOYEECODE2 EMP2,
                            VHCTPP.EMPLOYEECODE3 EMP3,
                            VHCTPP.EMPLOYEECODE4 EMP4                        
                        FROM TEMP_TATSUNODATA.dbo.OIL_TATSUNO OTSN
                        LEFT JOIN VEHICLETRANSPORTPLAN VHCTPP ON VHCTPP.JOBNO = OTSN.JOBNO COLLATE Thai_CI_AI
                        LEFT JOIN VEHICLEINFO VHCIF ON VHCIF.VEHICLEREGISNUMBER = OTSN.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                        LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVER VHCTPPDV ON VHCTPPDV.OILNUMBER = OTSN.OIL_BILLNUMBER COLLATE Thai_CI_AI
                        LEFT JOIN VEHICLETRANSPORTDOCUMENTDIRVERPALLET VHCTPPDVP ON VHCTPPDVP.OILNUMBER = OTSN.OIL_BILLNUMBER COLLATE Thai_CI_AI
                        WHERE OTSN.JOBNO IS NOT NULL AND VHCTPP.JOBNO IS NOT NULL 
                        AND CONVERT(VARCHAR (10),OTSN.REFUELINGDATE,20) BETWEEN '$startymd' AND '$endymd'
                        ORDER BY OTSN.OILDATAID ASC";                                                
                        $query = sqlsrv_query($conn, $sql );
                        $resultvalue = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
                        $result = sqlsrv_query($conn, $sql );
                        while($row = sqlsrv_fetch_array($result)) {                             
                            $OILID=$row["OILID"];                  
                            $JN1=$row["JN1"];                  
                            $JN2=$row["JN2"];                  
                            $REFUEL=$row["REFUEL"];                             
                            $CRF = explode("-", $REFUEL);
                            $DT1 = $CRF[0];
                            $DT2 = $CRF[1];
                            $DT3 = $CRF[2]; 
                            $CONREFUEL = $DT3.'/'.$DT2.'/'.$DT1;
                            $CNB=$row["CNB"];                  
                            $VHCRG=$row["VHCRG"];                  
                            $VHCT=$row["VHCT"];                  
                            $ENGY=$row["ENGY"];                  
                            $OAM=$row["OAM"];                  
                            $MLE=$row["MLE"];                  
                            $DTE=$row["DTE"];                 
                            $OBLNB=$row["OBLNB"];                 
                            $ONB=$row["ONB"];                 
                            $JE=$row["JE"];                 
                            $EMP1=$row["EMP1"];                 
                            $EMP2=$row["EMP2"];                 
                            $EMP3=$row["EMP3"];                 
                            $EMP4=$row["EMP4"]; 
                    ?>
                        <tr>
                            <td align="center"><?=++$REPORTEMPLOYEENAME;?></td>
                            <td align="center"><?=$CONREFUEL;?></td>
                            <td align="center"><?=$CNB;?></td>
                            <td align="center"><?=$VHCRG;?></td>
                            <td align="left"><?=$VHCT;?></td>
                            <td align="center"><?=$ENGY;?></td>
                            <td align="center"><?=$OAM;?></td>
                            <td align="left"><?=$MLE;?></td>
                            <td align="center"><?=$DTE;?></td>
                            <td align="center"></td>
                            <td align="center"><?=$OBLNB;?></td>
                            <td align="left"><?=$JE;?></td>
                            <td align="center"><?=$EMP1;?></td>
                            <td align="center"><?=$EMP2;?></td>
                            <td align="center"><?=$EMP3;?></td>
                            <td align="center"><?=$EMP4;?></td>
                        </tr>    
                    <?php } ?>                                                         
                </tbody>
            </table>          
        </section>
        <!-- /.content -->
    </div>
    </body>
    </html>
    <script>
    window.addEventListener("load", window.print());
    </script>
    <?php sqlsrv_close($conn); ?>
<?php } ?>

