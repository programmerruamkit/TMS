<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$buttonname = ($_GET['meg'] == 'edit') ? "แก้ไขข้อมูล" : "บันทึกข้อมูล";
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
                            <i class="glyphicon glyphicon-oil"></i>  
                            น้ำมัน


                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
           
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <?php
                                    echo $buttonname . ' : น้ำมัน';
                                    ?>
                                </div>
                                <div class="panel-body">

                                    <div class="row" >
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>พื้นที่</label>
                                                <select class="form-control" id="cb_activestatusrole" name="cb_activestatusrole">
                                                    <option value ="">เลือกพื้นที่</option>
                                                    <option value ="1">อมตะ</option>
                                                    <option value ="2">เกตเวย์</option>

                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>ปี</label>
                                                <select class="form-control" id="cb_activestatusrole" name="cb_activestatusrole">
                                                    <option value ="">เลือกปี</option>
                                                    <option value ="2019">2019</option>
                                                    <option value ="2020">2020</option>
                                                    <option value ="2021">2021</option>
                                                    <option value ="2022">2022</option>
                                                    <option value ="2023">2023</option>
                                                    <option value ="2024">2024</option>
                                                    <option value ="2025">2025</option>
                                                    <option value ="2026">2026</option>
                                                    <option value ="2027">2027</option>
                                                    <option value ="2028">2028</option>
                                                    <option value ="2029">2029</option>
                                                    <option value ="2030">2030</option>
                                                    <option value ="2031">2031</option>
                                                    <option value ="2032">2032</option>
                                                    <option value ="2033">2033</option>
                                                    <option value ="2034">2034</option>
                                                    <option value ="2035">2035</option>
                                                    <option value ="2036">2036</option>
                                                    <option value ="2037">2037</option>
                                                    <option value ="2038">2038</option>
                                                </select>

                                            </div>
                                        </div>

                                        <div class = "col-lg-3">
                                            <div class = "form-group">
                                                <font style="color: red">* </font><label>เดือน</label>
                                                <select class="form-control" id="cb_activestatusrole" name="cb_activestatusrole">
                                                    <option value ="">เลือกเดือน</option>
                                                    <option value ="1">มกราคม</option>
                                                    <option value ="2">กุมภาพันธ์ </option>
                                                    <option value ="3">มีนาคม </option>
                                                    <option value ="4">เมษายน</option>
                                                    <option value ="5">พฤษภาคม </option>
                                                    <option value ="6">มิถุนายน </option>
                                                    <option value ="7">กรกฎาคม </option>
                                                    <option value ="8">สิงหาคม </option>
                                                    <option value ="9">กันยายน </option>
                                                    <option value ="10">ตุลาคม </option>
                                                    <option value ="11">พฤศจิกายน </option>
                                                    <option value ="12">ธันวาคม </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>ราคา/ลิตร (บาท)</label>
                                                <input class="form-control" type="text"   id="txt_premissionsnamerole" name="txt_premissionsnamerole" value="<?= $result_seRole['ROLENAME'] ?>">

                                            </div>
                                        </div>

                                    </div>
                                    <div class="row" >
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>หมายเหตุ</label>
                                                <textarea class="form-control" autocomplete="off" rows="3" id="txt_remarkrole" name="txt_remarkrole" ><?= $result_seRole['REMARK'] ?></textarea>
                                                <input class="form-control" type="text" style="display: none"  id="txt_roleid" name="txt_roleid" value="<?= $_GET['roleid'] ?>">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">

                                            <input type="button"  name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">




                                        </div>
                                        <div class="col-lg-12">&nbsp;</div>
                                    </div>
                                    


                                </div>
                            </div>
                        </div>
                    </div>
                <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            รายการข้อมูล : น้ำมัน
                                                        </div>



                                                    </div>
                                                </div>
                                                <!-- /.panel-heading -->
                                                <div class="panel-body">
                                                    <!-- Nav tabs -->
                                                    <ul class="nav nav-pills">
                                                        <li class="active"><a href="#tap_amata" data-toggle="tab" aria-expanded="true">อมตะ</a>
                                                        </li>
                                                        <li><a href="#tap_getway" data-toggle="tab">เกตเวย์</a>
                                                        </li>
                                                        

                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="row">
                                                            <div class="col-md-12">&nbsp;</div>
                                                        </div>
                                                        <div class="tab-pane fade active in" id="tap_amata">
                                                            <div class="row">

                                                                <div class="col-md-12">
                                                                    
                                                                </div>

                                                                <!-- /.panel-body -->
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fad" id="tap_getway">
                                                            <div class="row">

                                                                <div class="col-md-12">
                                                                    
                                                                </div>

                                                                <!-- /.panel-body -->
                                                            </div>
                                                        </div>
                                                        


                                                    </div>
                                                </div>
                                                <!-- /.panel-body -->
                                            </div>
                                            <!-- /.panel -->
                                        </div>

                                    </div>
            </div>
            
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
                                                                                                        $('.selectpicker').on('changed.bs.select', function () {
                                                                                                            document.getElementById('txt_comp').value = $(this).val();

                                                                                                        });
                            </script>


                            </body>
                            <script>
                                $(function () {
                                    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                    // กรณีใช้แบบ input
                                    $(".dateen").datetimepicker({
                                        timepicker: false,
                                        format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                                        lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                                    });
                                });
                            </script>
                            <script>
                                $(document).ready(function () {
                                    $('#dataTables-example').DataTable({
                                        responsive: true
                                    });
                                });
                            </script>

                            </html>


                            <?php
                            sqlsrv_close($conn);
                            ?>