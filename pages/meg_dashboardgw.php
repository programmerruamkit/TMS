<!DOCTYPE html>
<?php
ob_start();
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");

$sql_seCntvehst1 = "SELECT COUNT(*) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = '1'
                    AND CONVERT(DATE,[DATERK]) = CONVERT(DATE,GETDATE()) AND COMPANYCODE IN ('RCC','RATC','RRC') ";
$query_seCntvehst1 = sqlsrv_query($conn, $sql_seCntvehst1, $params_seCntvehst1);
$result_seCntvehst1 = sqlsrv_fetch_array($query_seCntvehst1, SQLSRV_FETCH_ASSOC);

$sql_seCntvehst2 = "SELECT COUNT(*) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = '1' 
                    AND CONVERT(DATE,[DATERK]) = CONVERT(DATE,GETDATE())   
                    AND STATUSNUMBER = 'O' AND STATUSNUMBER != '0' AND COMPANYCODE IN ('RCC','RATC','RRC')      
                    ";
$query_seCntvehst2 = sqlsrv_query($conn, $sql_seCntvehst2, $params_seCntvehst2);
$result_seCntvehst2 = sqlsrv_fetch_array($query_seCntvehst2, SQLSRV_FETCH_ASSOC);

$sql_seCntvehst3 = "SELECT COUNT(*) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = '1' 
                    AND CONVERT(DATE,[DATERK]) = CONVERT(DATE,GETDATE())   
                    AND STATUSNUMBER = '1' AND STATUSNUMBER != '0' AND COMPANYCODE IN ('RCC','RATC','RRC')
                    ";
$query_seCntvehst3 = sqlsrv_query($conn, $sql_seCntvehst3, $params_seCntvehst3);
$result_seCntvehst3 = sqlsrv_fetch_array($query_seCntvehst3, SQLSRV_FETCH_ASSOC);

$sql_seCntvehst4 = "SELECT COUNT(*) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = '1' 
                    AND CONVERT(DATE,[DATERK]) = CONVERT(DATE,GETDATE())   
                    AND STATUSNUMBER = '2' AND STATUSNUMBER != '0' AND COMPANYCODE IN ('RCC','RATC','RRC')
                    ";
$query_seCntvehst4 = sqlsrv_query($conn, $sql_seCntvehst4, $params_seCntvehst4);
$result_seCntvehst4 = sqlsrv_fetch_array($query_seCntvehst4, SQLSRV_FETCH_ASSOC);
?>
<html lang="en">
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="refresh" content="60">
        <title>กลุ่มร่วมกิจรุ่งเรือง</title>
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
        <!--<link href="../dist/css/sb-admin-2.css" rel="stylesheet">-->
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


        <!-- Navigation -->

        <div id="wrapper">

            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

                <div class="navbar-header" >
                    <button type="button"  class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a  class="navbar-brand" href="index.php"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a>

                </div>

            </nav>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        &nbsp;
                    </div>
                </div>
                <div class="row">
                    <!--<div class="col-lg-2">
                        <input class="form-control" type="text" name="txt_condi" id="txt_condi" placeholder="ทะเบียนรถ / ชื่อรถ"  value="" title="ทะเบียนรถ / ชื่อรถ" >
                    </div> 
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-default" onclick="show_dashboard('1')">ค้นหา <li class="fa fa-search"></li></button>
                    </div> 
                    -->
                    <div class="col-lg-6">
                        <!--ทั้งหมด (<?//= $result_seCntvehst1['CNT'] ?>)-->
                        <u>หมายเหตุ</u> : <i><font style="color: #fb9902">ใกล้ถึงเวลารายงานตัว</font> , <font style="color: red">เลยเวลารายงานตัว</font></i>

                    </div> 
                    <div class="col-lg-6 text-right">

                        <input class="btn btn-default" type="button" style="background-color: white;border:solid 2px #d9edf7;color: #000" id="btn_srquotation" name="btn_srquotation" value="รอวิ่งงาน (<?= $result_seCntvehst2['CNT'] ?>)" onclick="show_dashboard('2')"> 
                        <input class="btn btn-default" type="button" style="background-color: white;border:solid 2px #337ab7;color: #000" id="btn_srquotation" name="btn_srquotation" value="วิ่งงาน (<?= $result_seCntvehst3['CNT'] ?>)" onclick="show_dashboard('3')"> 
                        <input class="btn btn-default" type="button" style="background-color: white;border:solid 2px green;color: #000" id="btn_srquotation" name="btn_srquotation" value="ปิดงาน (<?= $result_seCntvehst4['CNT'] ?>)" onclick="show_dashboard('4')">
                    </div>   
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        &nbsp;
                    </div>
                </div>
                <div id="datadef">
                    <div class="row">
                        <!-- /.row -->
                        <?php
                        $sql_seVeh = "SELECT VEHICLETRANSPORTPLANID,JOBNO,THAINAME,JOBSTART,JOBEND,EMPLOYEENAME1,EMPLOYEECODE1,EMPLOYEENAME2,EMPLOYEECODE2,ROUNDAMOUNT,
CONVERT(VARCHAR(5),CONVERT(TIME,DATERK),120) AS 'TIMEPRESENT' FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = '1'
AND CONVERT(DATE,[DATERK]) = CONVERT(DATE,GETDATE())
AND STATUSNUMBER = 'O' AND STATUSNUMBER != '0' AND COMPANYCODE IN ('RCC','RATC','RRC')
GROUP BY VEHICLETRANSPORTPLANID,JOBNO,THAINAME,JOBSTART,JOBEND,EMPLOYEENAME1,EMPLOYEECODE1,EMPLOYEENAME2,EMPLOYEECODE2,ROUNDAMOUNT,DATERK
ORDER BY CONVERT(VARCHAR(5),CONVERT(TIME,DATERK),120) ASC";
                        $query_seVeh = sqlsrv_query($conn, $sql_seVeh, $params_seVeh);
                        while ($result_seVeh = sqlsrv_fetch_array($query_seVeh, SQLSRV_FETCH_ASSOC)) {


                            $sql_seChk1 = "SELECT VEHICLETRANSPORTPLANID FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = '1'
                            AND VEHICLETRANSPORTPLANID = '" . $result_seVeh['VEHICLETRANSPORTPLANID'] . "' AND COMPANYCODE IN ('RCC','RATC','RRC')
                            AND CONVERT(DATETIME,GETDATE()) BETWEEN CONVERT(DATETIME,DATEADD(MINUTE,-30,DATERK)) AND CONVERT(DATETIME,DATERK)";
                            $query_seChk1 = sqlsrv_query($conn, $sql_seChk1, $params_seChk1);
                            $result_seChk1 = sqlsrv_fetch_array($query_seChk1, SQLSRV_FETCH_ASSOC);

                            $sql_seChk2 = "SELECT VEHICLETRANSPORTPLANID FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = '1'
                            AND VEHICLETRANSPORTPLANID = '" . $result_seVeh['VEHICLETRANSPORTPLANID'] . "' AND COMPANYCODE IN ('RCC','RATC','RRC')
                            AND CONVERT(DATETIME,GETDATE()) > CONVERT(DATETIME,DATERK)";
                            $query_seChk2 = sqlsrv_query($conn, $sql_seChk2, $params_seChk2);
                            $result_seChk2 = sqlsrv_fetch_array($query_seChk2, SQLSRV_FETCH_ASSOC);
                            ?>
                            <?php
                            if ($result_seVeh['VEHICLETRANSPORTPLANID'] != "") {
                                ?>
                                <div class="col-lg-3">

                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <?php
                                            if ($result_seChk2['VEHICLETRANSPORTPLANID'] != "") {
                                                ?>
                                                <font style="color: red"><b><?= $result_seVeh['THAINAME'] ?> : <?= $result_seVeh['EMPLOYEENAME1'] ?></font></b>
                                                <?php
                                            } else {
                                                if ($result_seChk1['VEHICLETRANSPORTPLANID'] != "") {
                                                    ?>
                                                    <font style="color: #fb9902"><b><?= $result_seVeh['THAINAME'] ?> : <?= $result_seVeh['EMPLOYEENAME1'] ?></font></b>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <b><?= $result_seVeh['THAINAME'] ?> : <?= $result_seVeh['EMPLOYEENAME1'] ?></b>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row" style="height: 150px">


                                                <div class="col-lg-6">
                                                    <b>เลขที่งาน :</b> <?= $result_seVeh['JOBNO'] ?><br>
                                                    <b>เวลาวิ่งงาน :</b> <?= $result_seVeh['TIMEPRESENT'] ?><br>
                                                    <b>รอบ :</b> <?= $result_seVeh['ROUNDAMOUNT'] ?><br>
                                                    <b>ต้นทาง :</b> <?= $result_seVeh['JOBSTART'] ?><br>
                                                    <b>ปลายทาง :</b> <?= $result_seVeh['JOBEND'] ?><br>
                                                    
                                                </div>

                                                <?php
                                                if ($result_seVeh['EMPLOYEECODE2'] != "") {
                                                    ?>
                                                    <div class="col-lg-6 text-center">
                                                        <img src="../images/employee/<?= $result_seVeh['EMPLOYEECODE2'] ?>.JPG" style="width: 30%">
                                                    </div>
                                                    <?php
                                                } else {
                                                    if ($result_seVeh['EMPLOYEECODE1'] != "") {
                                                        ?>
                                                        <div class="col-lg-6 text-center">
                                                            <img src="../images/employee/<?= $result_seVeh['EMPLOYEECODE1'] ?>.JPG" style="width: 40%">
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>




                                            </div>






                                        </div>
                                    </div>
                                </div>

                                <?php
                            }
                        }
                        ?>

                    </div>
                </div>
                <div id="datasr"></div>
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
                <script>
                            function show_dashboard(chk)
                            {

                                /*if (chk == '1')
                                 {
                                 var condi = "";
                                 if (document.getElementById("txt_condi").value != "")
                                 {
                                 
                                 condi = " AND [THAINAME] = '" + document.getElementById("txt_condi").value + "'";
                                 
                                 } else
                                 {
                                 condi = "";
                                 }
                                 $.ajax({
                                 type: 'post',
                                 url: 'meg_data.php',
                                 data: {
                                 txt_flg: "show_dashboard", condi: condi
                                 },
                                 success: function (response) {
                                 if (response)
                                 {
                                 document.getElementById("datasr").innerHTML = response;
                                 document.getElementById("datadef").innerHTML = '';
                                 }
                                 }
                                 });
                                 } 
                                 */
                                if (chk == '2')
                                {

                                    $.ajax({
                                        type: 'post',
                                        url: 'meg_data.php',
                                        data: {
                                            txt_flg: "show_dashboardgw2"
                                        },
                                        success: function (response) {
                                            if (response)
                                            {
                                                document.getElementById("datasr").innerHTML = response;
                                                document.getElementById("datadef").innerHTML = '';
                                            }
                                        }
                                    });
                                } else if (chk == '3')
                                {

                                    $.ajax({
                                        type: 'post',
                                        url: 'meg_data.php',
                                        data: {
                                            txt_flg: "show_dashboardgw3"
                                        },
                                        success: function (response) {
                                            if (response)
                                            {
                                                document.getElementById("datasr").innerHTML = response;
                                                document.getElementById("datadef").innerHTML = '';
                                            }
                                        }
                                    });
                                } else if (chk == '4')
                                {

                                    $.ajax({
                                        type: 'post',
                                        url: 'meg_data.php',
                                        data: {
                                            txt_flg: "show_dashboardgw4"
                                        },
                                        success: function (response) {
                                            if (response)
                                            {
                                                document.getElementById("datasr").innerHTML = response;
                                                document.getElementById("datadef").innerHTML = '';
                                            }
                                        }
                                    });
                                }


                            }
                </script>
                </body>


                </html>
                <?php
                sqlsrv_close($conn);
                ?>
