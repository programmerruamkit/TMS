<!DOCTYPE html>
<?php
    ob_start();
    session_start();
    date_default_timezone_set("Asia/Bangkok");
    require_once("../class/meg_function.php");
    ini_set('max_execution_time', 300); //300 seconds = 5 minutes
    $conn = connect("RTMS");

    if (!isset($_SESSION["USERNAME"]) || !isset($_SESSION["PASSWORD"])) {
        header("location:../pages/meg_login.php?data=3");
    }


    $sql_seSystime = "{call megGetdate_v2(?)}";
    $params_seSystime = array(
        array('select_getdate', SQLSRV_PARAM_IN)
    );
    $query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
    $result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);

    $EHR_PHC = $_GET['PSC'];
    $DATE = $_GET['DATE'];
    if($DATE!=''){
        $start = explode("/", $DATE);
        $startd = $start[0];
        $startm = $start[1];
        $starty = $start[2];
        $CHOOSEDATE = $DATE;
        $CHOOSEDATEQUERY = $starty.'-'.$startm.'-'.$startd;
        // echo $CHOOSEDATE;
    }else{
        $CHOOSEDATE = $result_seSystime['SYSDATE'];
        $CHOOSEDATEQUERY = CONVERT(DATE,GETDATE());
        // echo $CHOOSEDATE;
    }

    $conditionEHR = " AND a.PersonCode ='" . $EHR_PHC . "'";
    $sql_seEHR = "{call megEmployeeEHR_v2(?,?)}";
    $params_seEHR = array(
        array('select_employeeehr2', SQLSRV_PARAM_IN),
        array($conditionEHR, SQLSRV_PARAM_IN)
    );
    $query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
    $result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);
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
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
    <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
    <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
    <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
    <style>
        .navbar-default {
            border-color: #ffcb0b;
        }

        .popover-content {
            padding: 10px 10px;
            width: 100px;
        }

        .nav>li>a {
            position: relative;
            display: block;
            padding: 14px 30px;
        }

        .styled-select.slate select {
            border: 1px solid #ccc;
            font-size: 16px;
            height: 34px;
            width: 150px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">
                <font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport
                        Management System</strong></font>
            </a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li><a href="meg_logout.php"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</a>
        </ul>
    </nav>
    <div class="modal fade" id="modal_editdataoiltatsuno" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="static">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <h5 class="modal-title" id="title_copydiagram1"><b>แก้ไขข้อมูลการกรอกข้อมูลน้ำมัน</b></h5>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div id="editdataoiltatsunoresult"></div>
                </div>
            </div>
        </div>
    </div>
    <script>               
        function updateoiltatsuno_byadmin(){	    
            var oiltatid = $('#oiltatid').val();
            var jobnooil = $('#jobnooil').val();
            var mileagestart = $('#mileagestart').val();
            var mileageend = $('#mileageend').val();
            var oilamout = $('#oilamout').val();
            var oilremark = $('#oilremark').val();
            var oldjoboil = $('#oldjoboil').val();            
            var username = $('#username').val();
            var butupdate_byadmin = $('#butupdate_byadmin').val();  
            $.ajax({
                url: "meg_transportcompensation_saveoildetail.php",
                type: "POST",
                data: {
                    oiltatid: oiltatid,
                    jobnooil: jobnooil,
                    mileagestart: mileagestart,
                    mileageend: mileageend,
                    oilamout: oilamout,
                    oilremark: oilremark,
                    oldjoboil: oldjoboil,
                    username: username,
                    butupdate_byadmin: butupdate_byadmin			
                },                    
                cache: false,
                success: function(dataResult){
                        alert("แก้ไขข้อมูลเรียบร้อย");
                        location.assign('');
                    var dataResult = JSON.parse(dataResult);
                    if(dataResult.statusCode==200){	
                        $('#fupForm').find('input:text').val('');
                        $("#success").show();
                        $('#success').html('Data added successfully !');					
                    }
                    else if(dataResult.statusCode==201){
                        alert("Error occured !");
                    }                                
                }
            });
        }
        function copyjob() {
            document.getElementById("jobnooil").value = document.getElementById("jobnoplan").value;
        }
    </script>
    <div class="row">
        <div class="col-lg-12" style="text-align: right">
            <center>
                <h1><u>ข้อมูลน้ำมัน</u></h1>
            </center>
            <input class="btn btn-default" type="button" style="background-color: green;border:solid 2px white"> *
            หมายเลขงานตรงแผน
            <input class="btn btn-default" type="button" style="background-color: red;border:solid 2px white"> *
            หมายเลขงานไม่ตรงแผน
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #e7e7e7">
                    <div class="row">
                        <table style="width: 100%">
                            <tr>
                                <td style="width: 20%"><?= $result_seEHR['nameT'] ?></td>
                                <td style="width: 15%;text-align: center">
                                    <!-- <div class="styled-select slate">
                                        <select  class="form-control" id="sel_successoil" name="sel_successoil">
                                            <option  value="0">Unsuccess</option>
                                            <option  value="1">Success</option>
                                        </select>
                                    </div> -->
                                </td>
                                <td style="width: 15%;text-align: center"><input type="text" name="txt_datestartoil"
                                        readonly="" id="txt_datestartoil" onchange="datetodateoil();"
                                        class="form-control datedef" value="<?= $CHOOSEDATE ?>"></td>
                                <td style="width: 15%;text-align: center"><input type="text" name="txt_dateendoil"
                                        readonly="" id="txt_dateendoil" class="form-control datedef"
                                        value="<?= $CHOOSEDATE ?>"></td>
                                <td style="width: 10%;text-align: center"><button type="button" class="btn btn-default"
                                        onclick="select_joboil_admin();">ค้นหา <li class="fa fa-search"></li></button></td>
                            </tr>
                        </table>
                        <input type="hidden" id="personcode" value="<?=$EHR_PHC?>">
                    </div>
                </div>      
                <div id="overlay">
                    <div class="cv-spinner">
                        <span class="spinner"></span>
                    </div>
                    <style>
                        #overlay{
                            position: fixed;
                            top: 0;
                            z-index: 100;
                            width: 100%;
                            height:100%;
                            display: none;
                            background: rgba(0,0,0,0.6);
                        }
                        .cv-spinner {
                            height: 100%;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                        }
                        .spinner {
                            width: 40px;
                            height: 40px;
                            border: 4px #ddd solid;
                            border-top: 4px #2e93e6 solid;
                            border-radius: 50%;
                            animation: sp-anime 0.8s infinite linear;
                        }   
                        @keyframes sp-anime {100% {transform: rotate(360deg);}}
                        .is-hide{display:none;}
                    </style>
                </div>
                <div class="panel-body">
                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="data_oildef">
                                    <?php
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
                                        AND CONVERT (VARCHAR (10),CHKPLCAR.DATEWORKING,20) = '$CHOOSEDATEQUERY'
                                        AND OILT.JOBNO IS NOT NULL
                                        ORDER BY CHKPLCAR.JOBNO ASC";
                                        // AND CONVERT (VARCHAR (10),CHKPLCAR.DATEWORKING,20) = CONVERT(DATE,GETDATE())
                                        $query_chkjob = sqlsrv_query($conn, $stmt_chkjob);
                                        $result = sqlsrv_fetch_array($query_chkjob);
                                        $data1 = $result["JOBNOPLAN"];
                                        $data2 = $result["OILTJN"];
                                        // echo $data1;
                                        // echo "<br>";
                                        // echo $data2;
                                        
                                        // echo"<pre>";
                                        // print_r($result);
                                        // echo"</pre>";
                                    
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
                                                LEFT JOIN TEMP_TATSUNODATA.dbo.OIL_TATSUNO OILT ON (CHKPLCAR.JOBNO = OILT.JOBNO COLLATE Thai_CI_AI)
                                                LEFT JOIN RTMS.dbo.VEHICLEINFO CHKIFCAR ON CHKIFCAR.VEHICLEREGISNUMBER = OILT.VEHICLEREGISNUMBER COLLATE Thai_CI_AI
                                                LEFT JOIN RTMS.dbo.VEHICLETYPE CHKTYCAR ON CHKTYCAR.VEHICLETYPECODE = CHKIFCAR.VEHICLETYPECODE 
                                                WHERE (CHKPLCAR.EMPLOYEECODE1 = '$EHR_PHC' OR CHKPLCAR.EMPLOYEECODE2 = '$EHR_PHC')
                                                AND CONVERT (VARCHAR (10),CHKPLCAR.DATEWORKING,20) = '$CHOOSEDATEQUERY'
                                                ORDER BY CHKPLCAR.JOBNO ASC";
                                                // AND CONVERT (VARCHAR (10),CHKPLCAR.DATEWORKING,20) = CONVERT(DATE,GETDATE())
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
                                                    AND CONVERT (VARCHAR (10),CHKPLCAR.DATEWORKING,20) = CONVERT(DATE,GETDATE())
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
                                </div>
                                <div id="data_oilsr"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function editdataoiltatsuno(oiltatid, oiljobnoplan, oiljobnotat, oilbillno, mileagestart, mileageend, oilamount, oilremark, refueldate) {
            $.ajax({
                type: 'post',
                url: 'meg_data2.php',
                data: {
                    txt_flg: "select_editdataoiltatsuno_byadmin",
                    oiltatid: oiltatid,
                    oiljobnoplan: oiljobnoplan,
                    oiljobnotat: oiljobnotat,
                    oilbillno: oilbillno,
                    mileagestart: mileagestart,
                    mileageend: mileageend,
                    oilamount: oilamount,
                    oilremark: oilremark,
                    refueldate: refueldate
                },
                success: function (response) {
                    if (response) {
                        document.getElementById("editdataoiltatsunoresult").innerHTML = response;
                    }
                }
            });
        }
        function fineandeditdataoiltatsuno(oiljobnoplan) {
            $.ajax({
                type: 'post',
                url: 'meg_data2.php',
                data: {
                    txt_flg: "select_fineandeditdataoiltatsuno",
                    oiljobnoplan: oiljobnoplan
                },
                success: function (response) {
                    if (response) {
                        document.getElementById("editdataoiltatsunoresult").innerHTML = response;
                    }
                }
            });
        }
        function finedataoil(){
            var finebill = $('#finebill').val();
            // alert(finebill)
            $.ajax({
                type: 'post',
                url: 'meg_transportcompensation_saveoildetail.php',
                data: {
                    txt_flg: "select_finedataoil", 
                    finebill: finebill
                },
                success: function (response) {
                    // alert(response)
                    var split = response.split("|");
                    document.getElementById('jobnooil').value = split[0];
                    document.getElementById('oilbill').value = split[1];
                    document.getElementById('mileagestart').value = split[2];
                    document.getElementById('mileageend').value = split[3];
                    document.getElementById('oilamout').value = split[4];
                    document.getElementById('daterefuel').value = split[5];
                    document.getElementById('oiltatid').value = split[6];
                    document.getElementById('username').value = split[7];
                    document.getElementById('oldjoboil').value = split[8];
                }
            });
        }
    </script>
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../dist/js/sb-admin-2.js"></script>
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script src="../js/jquery.datetimepicker.full.js"></script>
    <script src="../dist/js/jszip.min.js"></script>
    <script src="../dist/js/dataTables.buttons.min.js"></script>
    <script src="../dist/js/buttons.html5.min.js"></script>
    <script src="../dist/js/buttons.print.min.js"></script>
    <script src="../dist/js/jquery.autocomplete.js"></script>
    <script src="../dist/js/bootstrap-select.js"></script>
</body>
<script>
    function select_joboil_admin(){
        $(document).ajaxSend(function() {
            $("#overlay").fadeIn(300);　
        });
        $.ajax({
            type: 'post',
            url: 'meg_data2.php',
            data: {
                txt_flg: "select_joboil_admin", 
                personcode: document.getElementById('personcode').value, 
                datestartoil: document.getElementById('txt_datestartoil').value, 
                dateendoil: document.getElementById('txt_dateendoil').value
            },
            success: function (response) {
                // alert(document.getElementById('txt_datestartoil').value);
                // alert(document.getElementById('txt_dateendoil').value);
                if (response)
                {
                    document.getElementById("data_oilsr").innerHTML = response;
                    document.getElementById("data_oildef").innerHTML = "";
                    setTimeout(function(){$("#overlay").fadeOut(300);},500);
                };
                $(function () {
                    $('[data-toggle="popover"]').popover({
                        html: true,
                        content: function () {
                            return $('#popover-content').html();
                        }
                    });
                })
                $(document).ready(function () {
                    $('#dataTables-oiltat').DataTable({
                        order: [[2, "asc"]],
                        scrollX: true
                    });
                });
            }
        });
    }
    $(document).ready(function () {
        $('#dataTables-example').DataTable({
            order: [
                [0, "desc"]
            ],
            scrollX: true
        });
    });
    
    function datetodateoil() {
        document.getElementById('txt_dateendoil').value = document.getElementById('txt_datestartoil').value;
    }
    $(function () {
        $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
        // กรณีใช้แบบ input
        $(".datedef").datetimepicker({
            timepicker: false,
            format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
            lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
        });
    });

    $(document).ready(function () {
        $('#dataTables-oiltat').DataTable({
            order: [
                [2, "asc"]
            ],
            scrollX: true
        });
    });

</script>




</html>
<?php
sqlsrv_close($conn);
?>