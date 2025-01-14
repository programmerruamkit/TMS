<!DOCTYPE html>
<?php
ob_start();
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");
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
        <!--<link href="../dist/css/sb-admin-2.css" rel="stylesheet">-->
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        <style>



        </style>

    </head>
    <body>


        <!-- Navigation -->

        <div id="wrapper">
            <div class="modal fade" id="modal_addphone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="width: 40%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h5 class="modal-title" id="title_copydiagram"><b>เพิ่ม/แก้ไขข้อมูลเบอร์โทรศัพท์</b></h5>
                                </div>

                            </div>
                        </div>
                        <div id="dataupdate_sr"></div>

                    </div>


                </div>
            </div>
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

                    <div class="col-lg-6">
                        <font style="font-size: 16px">
                        <?php
                        if ($_GET['type'] == 'btc') {
                            ?>
                            พื้นที่หน่วยงาน สำนักงาน (BTC) / <a href='#' onclick="select_updatephone('')" data-toggle="modal" data-target="#modal_addphone"> เพิ่มข้อมูล   </a>
                            <?php
                        } else if ($_GET['type'] == 'ops') {
                            ?>
                            พื้นที่หน่วยงาน Transport (OPS) / <a href='#' onclick="select_updatephone('')" data-toggle="modal" data-target="#modal_addphone"> เพิ่มข้อมูล   </a>
                            <?php
                        } else if ($_GET['type'] == 'rtd') {
                            ?>
                            พื้นที่หน่วยงาน ซ่อมบำรุง (RTD) / <a href='#' onclick="select_updatephone('')" data-toggle="modal" data-target="#modal_addphone"> เพิ่มข้อมูล   </a>
                            <?php
                        } else if ($_GET['type'] == 'sg') {
                            ?>
                            พื้นที่หน่วยงาน รักษาความปลอดภัย (SG) / <a href='#' onclick="select_updatephone('')" data-toggle="modal" data-target="#modal_addphone"> เพิ่มข้อมูล   </a>
                            <?php
                        }
                        ?>


                        </font>




                    </div> 

                </div>
                <div class="row">
                    <div class="col-lg-12">
                        &nbsp;
                    </div>
                </div>

                <div class="row">
                    <div id="data_def">
                        <!-- /.row -->
                        <?php
                        $cond1 = " AND AREA = '" . $_GET['type'] . "'";
                        $sql_sePhone = "{call megPhone_v2(?,?,?,?)}";
                        $params_sePhone = array(
                            array('select_phone', SQLSRV_PARAM_IN),
                            array($cond1, SQLSRV_PARAM_IN),
                            array('', SQLSRV_PARAM_IN),
                            array('', SQLSRV_PARAM_IN)
                        );
                        $query_sePhone = sqlsrv_query($conn, $sql_sePhone, $params_sePhone);
                        while ($result_sePhone = sqlsrv_fetch_array($query_sePhone, SQLSRV_FETCH_ASSOC)) {

                            $sql_seEmp = "SELECT TOP 1 [PersonCode] AS 'EMPLOYEECODE' FROM [203.150.225.30].[TigerE-HR].[dbo].[PNT_Person] WHERE FnameT+' '+LnameT = '" . $result_sePhone['EMPLOYEENAME'] . "'";
                            $params_seEmp = array();
                            $query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
                            $result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC);
                            ?>


                            <div class="col-lg-2">

                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-lg-6 text-left"><i class="fa fa-phone"></i> <?= $result_sePhone['NUMBER'] ?></div>
                                            <div class="col-lg-6 text-right"><a href='#' style="color: white" onclick="select_updatephone('<?= $result_sePhone['PHONEID'] ?>')" data-toggle="modal" data-target="#modal_addphone">แก้ไข</a> / <a href='#' style="color: white" onclick="delete_phone('<?= $result_sePhone['PHONEID'] ?>')" >ลบ</a></div>
                                        </div>


                                    </div>
                                    <div class="panel-body">
                                        <div class="row" style="height: 150px">


                                            <div class="col-lg-8">
                                                <b>รหัสพนักงาน :</b> <?= $result_seEmp['EMPLOYEECODE'] ?><br>
                                                <b>ชื่อ-สกุล :</b> <?= $result_sePhone['EMPLOYEENAME'] ?><br>
                                                <b>ตำแหน่ง :</b> <?= $result_sePhone['PositionNameT'] ?><br>



                                            </div>

                                            <div class="col-lg-4 text-center">
                                                <img src="../images/employee/<?= $result_seEmp['EMPLOYEECODE'] ?>.JPG" style="width: 60%">
                                            </div>



                                        </div>






                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                        ?>
                    </div>
                    <div id="data_sr"></div>

                </div>
                <?php
                $job = '';
                if ($_GET['companycode'] == 'RRC' && $_GET['customercode'] == 'GMT') {
                    $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', '');
                }
                if ($_GET['companycode'] == 'RRC' && $_GET['customercode'] == 'BP') {
                    $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', '');
                }
                if ($_GET['companycode'] == 'RRC' && $_GET['customercode'] == 'TTAST') {
                    $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', '');
                }
                if ($_GET['companycode'] == 'RRC' && $_GET['customercode'] == 'TTTC') {
                    $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', '');
                } else if ($_GET['companycode'] == 'RCC' && $_GET['customercode'] == 'TTT') {
                    $job = select_jobautocomplatestarttttsh('megVehicletransportprice_v2', 'select_fromtttsh', '');
                } else if ($_GET['companycode'] == 'RATC' && $_GET['customercode'] == 'TTT') {
                    $job = select_jobautocomplatestarttttsh('megVehicletransportprice_v2', 'select_fromtttsh', '');
                }
                if ($_GET['companycode'] == 'RRC' || $_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RATC') {
                    $thainame = select_carautocomplate('megVehicleinfo_v2', 'selectcond_vehicleinfo', " AND a.THAINAME != '-' AND (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%'", " OR a.THAINAME LIKE '%ดินแดง%'  OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%'  ", " OR a.THAINAME LIKE '%RP-%' OR a.THAINAME  LIKE '%สวนผึ้ง%' OR a.THAINAME  LIKE '%ด่านช้าง%'", " OR a.ENGNAME LIKE '%Khao Chamao%' OR a.ENGNAME LIKE '%Kerry%' OR a.ENGNAME LIKE '%Chaloem Prakiat%' OR a.THAINAME LIKE '%แปลงยาว%' OR a.THAINAME LIKE '%สนามชัยเขต%')");
                } else {
                    $thainame = select_vehiclenumberautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', '');
                }
                $jobrccend = select_jobautocomplateendgetway('megVehicletransportprice_v2', 'select_to', '');


                $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employee', " ");
                $cluster = select_clusterautocomplate('megVehicletransportprice_v2', 'select_cluster', '');
                ?>
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

                                                var txt_employeename = [<?= $emp ?>];
                                                $("#txt_employeename").autocomplete({
                                                    source: [txt_employeename]
                                                });
                                                function save_phone(phoneid)
                                                {

                                                    $.ajax({
                                                        type: 'post',
                                                        url: 'meg_data.php',
                                                        data: {
                                                            txt_flg: "save_phone", phoneid: phoneid, area: '<?= $_GET['type'] ?>', number: document.getElementById('txt_number').value, employeename: document.getElementById('txt_employeename').value
                                                        },
                                                        success: function () {

                                                            select_phone();

                                                        }



                                                    });

                                                }
                                                function select_phone()
                                                {
                                                    $.ajax({
                                                        type: 'post',
                                                        url: 'meg_data.php',
                                                        data: {
                                                            txt_flg: "select_phone", type: '<?= $_GET['type'] ?>'
                                                        },
                                                        success: function (rs) {
                                                            document.getElementById("data_sr").innerHTML = rs;
                                                            document.getElementById("data_def").innerHTML = "";

                                                        }



                                                    });
                                                }

                                                function select_updatephone(phoneid)
                                                {
                                                    $.ajax({
                                                        type: 'post',
                                                        url: 'meg_data.php',
                                                        data: {
                                                            txt_flg: "select_updatephone", type: '<?= $_GET['type'] ?>', phoneid: phoneid
                                                        },
                                                        success: function (rs) {
                                                            document.getElementById("dataupdate_sr").innerHTML = rs;

                                                            var txt_employeename = [<?= $emp ?>];
                                                            $("#txt_employeename").autocomplete({
                                                                source: [txt_employeename]
                                                            });

                                                        }



                                                    });
                                                }
                                                function delete_phone(phoneid)
                                                {
                                                    var confirmation = confirm("ต้องการลบข้อมูล ?");
                                                    if (confirmation) {
                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "delete_phone", phoneid: phoneid
                                                            },
                                                            success: function () {
                                                                alert('ลบข้อมูลเรียบร้อยแล้ว');
                                                                select_phone();
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
