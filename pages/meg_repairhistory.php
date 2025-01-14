<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$sql_seSystime = "{call megGetdate_v2(?)}";
$params_seSystime = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
$result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);


$sql_seComp = "{call megCompanyEHR_v2(?,?)}";
$params_seComp = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condComp, SQLSRV_PARAM_IN)
);
$query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
$result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC);
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
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
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
            #page-wrapper {
                border-left: 1px solid #ffcb0b;
            }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?php
                include '../pages/meg_header.php';
                include '../pages/meg_leftmenu.php';
                ?>
            </nav>

            <div id="page-wrapper">
                <div class="row" >
                    <div class="col-lg-12">

                        <h2 class="page-header">
                            <i class="fa fa-truck"></i>
                            ประวัติการซ่อมบำรุง


                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">
                                <div class="row" >
                                    <div class="col-lg-6">
                                         <a href="index2.php">หน้าหลัก</a> / ประวัติการซ่อมบำรุง
                                        
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <?= $result_seComp['Company_NameT'] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">

                                <div class="row" >
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <font style="color: red">* </font><label>ทะเบียนรถ</label>
                                            <input type="text" name="" id="txt_vehiclenumber" value="" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <font style="color: red">* </font><label>ช่างซ่อม</label>
                                            <?php
                                            $emp = select_empautocomplateemprktc();
                                            ?>
                                            <input type="text"  name="txt_employeename1" id="txt_employeename1" class="form-control" autocomplete="off">

                                        </div>
                                    </div>


                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <font style="color: red">* </font><label>ชื่ออะไหล่</label>

                                            <?php
                                            $detail = select_empautocomplatedetailrktc();
                                            ?>
                                            <input type="text"  name="txt_desc1" id="txt_desc1" class="form-control" autocomplete="off">

                                        </div>
                                    </div>



                                    <div class="col-lg-1">

                                        <div class="form-group">
                                            <label>ค้นหาตามช่วงวันที่</label>
                                            <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e" id="txt_datestart" name="txt_datestart" value="<?= $result_seSystime['SYSDATE'] ?>" placeholder="วันที่เริ่มต้น">

                                        </div>

                                    </div>
                                    <div class="col-lg-1">
                                        <label>&nbsp;</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control dateen" readonly="" style="background-color: #f080802e" id="txt_dateend" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_seSystime['SYSDATE'] ?>">

                                        </div>
                                    </div>


                                    <div class="col-lg-1">
                                        <label>&nbsp;</label>
                                        <div class="form-group">
                                            <button class="btn btn-default" onclick="select_RepairData();">ค้นหา <li class="fa fa-search"></li></button>
                                        </div>

                                    </div>
                                    <div class="col-lg-1 text-right">
                                        <label>&nbsp;</label>
                                        <div class="form-group">
                                            <button class="btn btn-default" onclick="pdf_repair();">พิมพ์ (PDF) <li class="fa fa-print"></li></button>
                                        </div>

                                    </div>
                                    <div class="col-lg-1 text-right">
                                        <label>&nbsp;</label>
                                        <div class="form-group">
                                            <button class="btn btn-default" onclick="excel_repair();">พิมพ์ (EXCEL) <li class="fa fa-print"></li></button>
                                        </div>

                                    </div>

                                </div>


                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">     
                        <!-- /.panel-heading -->
                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">ลำดับ</th>
                                            <th style="text-align: center">บริษัท</th>
                                            <th style="text-align: center">วันที่</th>
                                            <th style="text-align: center">ทะเบียนรถ</th>
                                            <th style="text-align: center">ช่างซ่อม</th>
                                            <th style="text-align: center">เลข JOB</th>
                                            <th style="text-align: center">ชื่องานซ่อม</th>
                                            <th style="text-align: center">รายละเอียดงานซ่อม</th>
                                            <th style="text-align: center">ปริมาณ</th>
                                            <th style="text-align: center">ราคาต่อหน่วย</th>
                                            <th style="text-align: center">ราคาขาย</th>
                                            <th style="text-align: center">รวมเป็นเงิน</th>
                                        </tr>

                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>




                            </div>
                            <div id="datasr"></div>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>

        </div>
        <?php
        if ($_GET['companycode'] == 'RRC' || $_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RATC') {
            $thainame = select_carautocomplate('megVehicleinfo_v2', 'selectcond_vehicleinfo', " AND a.THAINAME != '-' AND (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%'", " OR a.THAINAME LIKE '%ดินแดง%'  OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%'  ", " OR a.THAINAME LIKE '%RP-%' OR a.THAINAME  LIKE '%สวนผึ้ง%' OR a.THAINAME  LIKE '%ด่านช้าง%'", " OR a.ENGNAME LIKE '%Khao Chamao%' OR a.ENGNAME LIKE '%Kerry%' OR a.ENGNAME LIKE '%Chaloem Prakiat%' OR a.THAINAME LIKE '%แปลงยาว%' OR a.THAINAME LIKE '%สนามชัยเขต%' OR a.THAINAME LIKE '%วานรนิวาส%' OR a.THAINAME LIKE '%เฉลิมพระเกียรติ%' OR a.THAINAME LIKE '%ชัยนาท%')");
        } else {
            $thainame = select_vehiclenumberautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', '');
        }
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
        <script type="text/javascript">

                                                var txt_employeename1 = [<?= $emp ?>];
                                                $("#txt_employeename1").autocomplete({
                                                    source: [txt_employeename1]
                                                });

                                                var txt_desc1 = [<?= $detail ?>];
                                                $("#txt_desc1").autocomplete({
                                                    source: [txt_desc1]
                                                });

                                                var txt_vehiclenumber = [<?= $thainame ?>];
                                                $("#txt_vehiclenumber").autocomplete({
                                                    source: [txt_vehiclenumber]
                                                });
                                                function pdf_repair() {
                                                    var name = document.getElementById('txt_employeename1').value;
                                                    var desc1 = document.getElementById('txt_desc1').value;
                                                    var vehiclenumber = document.getElementById('txt_vehiclenumber').value;
                                                    var datestart = document.getElementById('txt_datestart').value;
                                                    var dateend = document.getElementById('txt_dateend').value;

                                                    window.open('pdf_repairhistory.php?name=' + name + '&desc1=' + desc1 + '&vehiclenumber=' + vehiclenumber + '&datestart=' + datestart + '&dateend=' + dateend, '_blank');
                                                }

                                                function excel_repair() {
                                                    // alert('excel');

                                                    var name = document.getElementById('txt_employeename1').value;
                                                    var desc1 = document.getElementById('txt_desc1').value;
                                                    var vehiclenumber = document.getElementById('txt_vehiclenumber').value;
                                                    var datestart = document.getElementById('txt_datestart').value;
                                                    var dateend = document.getElementById('txt_dateend').value;

                                                    window.open('excel_repairhistory.php?name=' + name + '&desc1=' + desc1 + '&vehiclenumber=' + vehiclenumber + '&datestart=' + datestart + '&dateend=' + dateend, '_blank');
                                                }

                                                function select_RepairData()
                                                {
                                                    var name = document.getElementById('txt_employeename1').value;
                                                    var desc1 = document.getElementById('txt_desc1').value;
                                                    var vehiclenumber = document.getElementById('txt_vehiclenumber').value;
                                                    var datestart = document.getElementById('txt_datestart').value;
                                                    var dateend = document.getElementById('txt_dateend').value;

                                                    // alert(name);
                                                    // alert(desc1);
                                                    // alert(vehiclenumber);
                                                    // alert(datestart);
                                                    // alert(dateend);
                                                    $.ajax({
                                                        type: 'post',
                                                        url: 'meg_data.php',
                                                        data: {
                                                            txt_flg: "select_repairdata", name: name, desc1: desc1, vehiclenumber: vehiclenumber, datestart: datestart, dateend: dateend
                                                        },
                                                        success: function (response) {
                                                            if (response) {

                                                                document.getElementById("datasr").innerHTML = response;
                                                                document.getElementById("datadef").innerHTML = "";

                                                                $(document).ready(function () {
                                                                    $('#dataTables-example').DataTable({
                                                                        responsive: true
                                                                    });

                                                                });

                                                            }
                                                        }
                                                    });

                                                }


                                                $(function () {
                                                    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                    // กรณีใช้แบบ input
                                                    $(".dateen").datetimepicker({
                                                        timepicker: false,
                                                        format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                        lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                                                    });
                                                });

                                                $(document).ready(function () {
                                                    $('#dataTables-example').DataTable({
                                                        responsive: true
                                                    });

                                                });


                                                function datetodate()
                                                {
                                                    document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;
                                                }
        </script>


    </body>


</html>


<?php
sqlsrv_close($conn);
?>
