
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
ini_set('max_execution_time', 300);
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$condition1 = " AND (a.USERNAME ='" . $_SESSION["USERNAME"] . "' AND a.PASSWORD = '" . $_SESSION["PASSWORD"] . "') AND a.ACTIVESTATUS = 1";
$sql_seLogin = "{call megRoleaccount_v2(?,?)}";
$params_seLogin = array(
    array('select_roleaccount', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seLogin = sqlsrv_query($conn, $sql_seLogin, $params_seLogin);
$result_seLogin = sqlsrv_fetch_array($query_seLogin, SQLSRV_FETCH_ASSOC);
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
        <script>
            $(function () {
                $('[data-toggle="popover"]').popover({
                    html: true,
                    content: function () {
                        return $('#popover-content').html();
                    }
                });
            })
        </script>
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
        <input type="text" class="form-control" id="txt_employeecode" name="txt_employeecode" style="display: none">

        <div class="modal fade" id="modal_datecompany3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 40%">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-5">
                                <h5 class="modal-title" id="title_copydiagram"><b>เลือก <u>เดือน/ปี</u> ในการแสดงข้อมูล</b></h5>
                            </div>

                        </div>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-6">
                                <label>เดือน/ปี :</label>
                                <input type="text" class="form-control dateen" id="txt_datestart" name="txt_datestart" autocomplete="off">
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="select_companycompensationexcel1()">EXCEL <i class="fa fa-print"></i></button>

                    </div>

                </div>
            </div>
        </div>
        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?php
                include '../pages/meg_header.php';
                include '../pages/meg_leftmenu.php';
                ?>
            </nav>

            <div id="page-wrapper" >
                <div class="row" >
                    <div class="col-lg-12">
                        <h2 class="page-header">

                            <i class="glyphicon glyphicon-user"></i> ข้อมูลพนักงาน



                        </h2>




                    </div>
                    <!-- /.panel-body -->
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="well">
                            <div class="row">

                                <div class="col-lg-2">

                                    <div class="form-group">
                                        <label>บริษัท</label>


                                        <select id="select_company" name="select_company" class="form-control">
                                            <option value="">เลือกบริษัท</option>
                                            <?php
                                            if ($_GET['area'] == 'gateway') {
                                                ?>
                                                <option value="RCC">บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์ จำกัด</option>
                                                <option value="RATC">บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต จำกัด</option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="RKR">บริษัท ร่วมกิจรุ่งเรือง (1993) จำกัด</option>
                                                <option value="RKS">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด</option>
                                                <option value="RTD">บริษัท ร่วมกิจรุ่งเรือง ทรัค ดีเทลส์ จำกัด</option>
                                                <option value="RKL">บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์ จำกัด</option>
                                                <option value="RTC">บริษัท ร่วมกิจรุ่งเรือง เทรนนิ่ง เซ็นเตอร์ จำกัด</option>
                                                <option value="RIT">บริษัท ร่วมกิจ ไอที จำกัด</option>
                                                <?php
                                            }
                                            ?>





                                        </select>


                                    </div>

                                </div>

                                <div class="col-lg-2">
                                    <label>&nbsp;</label>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-default" onclick="select_employee8();">ค้นหา <li class="fa fa-search"></li></button>
                                    </div>

                                </div>





                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">
                                <?php
                                $meg = 'ข้อมูลพนักงาน';
                                echo "<a href='report_company.php?area=gateway'>บริษัท</a> / " . $meg;
                                $link = "<a href='report_company.php?area=gateway'>บริษัท</a> / <a href='report_employee7.php'>ข้อมูลพนักงาน</a>";
                                $_SESSION["link"] = $link;
                                ?>

                            </div>
                            <!-- /.panel-heading -->
                            <div id="data_def">
                                <div class="panel-body">
                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>รหัสพนักงาน</th>
                                                    <th>ชื่อ-นามสกุล</th>
                                                    <th>เบอร์โทรศัพท์</th>
                                                    <th>อีเมลล์</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                            </div>
                            <div id="data_sr"></div>
                            <!-- /.panel -->
                        </div>
                    </div>
                </div>

                <!-- /.panel -->
            </div>
        </div>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script src="../dist/js/sb-admin-2.js"></script>
    <script src="../js/jquery.datetimepicker.full.js"></script>

    <script>
                                            function save_logprocess(category, process, employeecode)
                                            {
                                                $.ajax({
                                                    url: 'meg_data.php',
                                                    type: 'POST',
                                                    data: {
                                                        txt_flg: "save_logprocess", category: category, process: process, employeecode: employeecode
                                                    },
                                                    success: function () {


                                                    }
                                                });
                                            }
                                            $(function () {
                                                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                // กรณีใช้แบบ input
                                                $(".dateen").datetimepicker({
                                                    timepicker: false,
                                                    format: 'm/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                                                });
                                            });
                                            $(document).ready(function () {
                                                $('#dataTables-example').DataTable({
                                                    responsive: true,
                                                    order: [[0, "desc"]]
                                                });
                                            });

                                            function select_companycompensationexcel1()
                                            {
                                                save_logprocess('Report', 'Excel รายงานค่าเที่ยว (เบี้ยเลี้ยง/อาหาร)(RCC,RATC)', '<?= $result_seLogin['PersonCode'] ?>');
                                                var datestart = document.getElementById('txt_datestart').value;
                                                var companycode = document.getElementById('select_company').value;
                                                var employeecode = document.getElementById('txt_employeecode').value;


                                                window.open('excel_reportcompanycompensationgw1.php?companycode=' + companycode + '&datestart=' + datestart + '&employeecode=' + employeecode, '_blank');


                                            }
                                            function select_employeecode(employeecode)
                                            {
                                                document.getElementById('txt_employeecode').value = employeecode;
                                            }
                                            function select_employee8()
                                            {


                                                $.ajax({
                                                    type: 'post',
                                                    url: 'meg_data.php',
                                                    data: {
                                                        txt_flg: "show_employee8", companycode: document.getElementById("select_company").value




                                                    },
                                                    success: function (rs) {

                                                        save_logprocess('Report', 'Select รายงานค่าเที่ยว (เบี้ยเลี้ยง/อาหาร)(RCC,RATC)', '<?= $result_seLogin['PersonCode'] ?>');

                                                        document.getElementById("data_def").innerHTML = "";
                                                        document.getElementById("data_sr").innerHTML = rs;
                                                        $(document).ready(function () {
                                                            $('#dataTables-example').DataTable({
                                                                responsive: true,
                                                                order: [[0, "desc"]]
                                                            });
                                                        });

                                                        $(function () {
                                                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                            // กรณีใช้แบบ input
                                                            $(".dateen").datetimepicker({
                                                                timepicker: false,
                                                                format: 'm/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                                                            });
                                                        });
                                                    }
                                                });

                                            }
    </script>


</body>


</html>
<?php
sqlsrv_close($conn);
?>
