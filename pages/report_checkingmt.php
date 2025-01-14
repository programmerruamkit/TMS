
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
ini_set('max_execution_time', 300);
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

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
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
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

                        <h2 class="page-header"><i class="fa fa-file-text-o"></i>
                            รายงานตัววันหยุดนักขัตฤกษ์ (GMT)
                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel-body">

                            <div class="tab-content">
                                <!-- ///////////////////////////////////////////////////////////////////////// -->

                            </div> 
                        </div>

                        <div class="row" >
                            <div class="col-lg-12">
                                <div class="well">
                                    <div class="row">

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ค้นหาข้อมูลตามช่วงวันที</label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_datestart_month" name="txt_datestart_month" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">

                                            </div>

                                        </div>

                                        <!-- <div class="col-lg-2">
                                            <label>&nbsp;</label>
                                            <select id="select_department_month" name="select_department_month" class="form-control" >
                                                <option value="">เลือกแผนก(Department)</option>
                                                <option value="01">Administration</option>
                                                <option value="02">Accounting/Finance</option>
                                                <option value="03">Transportation</option>
                                                <option value="04">Affiliate Business</option>
                                            </select>
                                        </div> -->

                                        <!-- <div class="col-lg-2">
                                            <label>&nbsp;</label>
                                            <select id="select_section_month" name="select_section_month" class="form-control" >
                                                <option value="">เลือกฝ่าย(Section)</option>
                                                <option value="01">Accounting</option>
                                                <option value="02">Administration</option>
                                                <option value="01">Corporate Strategy</option>
                                                <option value="01">Customer Relation Managemet</option>
                                                <option value="02">Finance</option>
                                                <option value="02">Operation</option>
                                                <option value="02">Ruamkit Information Technology</option>
                                                <option value="03">Ruamkit Rungrueng Traning Center</option>
                                                <option value="01">Ruamkit Rungrueng Truck Details</option>
                                                <option value="03">Safety & Quality</option>
                                            </select>
                                        </div>  -->

                                        <!-- <div class="col-lg-2">
                                            <label>&nbsp;</label>
                                            <select id="select_area_section" name="select_area_section" class="form-control" >
                                                <option value="amata">AMT</option>
                                                <option value="gateway">GW</option>
                                            </select>
                                        </div>  -->

                                        <div class="col-lg-4 text-left" >
                                            <label>&nbsp;</label><br>
                                            <a href="#" onclick="select_dailytenkoofficer();" title="Excel" class="btn btn-default">รายงาน (Excel) <li class="fa fa-file-excel-o" ></li></a>
                                            <a href="#" onclick="select_pdfdailytenkoofficer();" title="PDF" class="btn btn-default">รายงาน (PDF) <li class="fa fa-file-pdf-o" ></li></a>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END 2 -->
                        </div>

                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
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
        <script src="../dist/js/jquery.autocomplete.js"></script>
        <script src="../dist/js/bootstrap-select.js"></script>

        <script type="text/javascript">
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
                                                        format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                        lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                                                    });
                                                });
                                                $(function () {
                                                    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                    // กรณีใช้แบบ input
                                                    $(".dateen1").datetimepicker({
                                                        timepicker: true,
                                                        format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                        lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                                                    });
                                                });




                                                function select_dailytenkoofficer()
                                                {
                                                    // var department = document.getElementById('select_department_month').value;
                                                    // var section = document.getElementById('select_section_month').value;
                                                    // var area = document.getElementById('select_area_section').value;

                                                    var datestart = document.getElementById('txt_datestart_month').value;
                                                    // if (department == '02' && (section == '01' || section == '02')) {
                                                    //     window.open('excel_reportcheckin_acc.php?datestart=' + datestart + '&department=' + department + '&section=' + section + '&area=' + area, '_blank');
                                                    // } else if (department == '03' && section == '03') {
                                                    //     window.open('excel_reportcheckin_sq.php?datestart=' + datestart + '&department=' + department + '&section=' + section + '&area=' + area, '_blank');
                                                    // } else {
                                                    //     window.open('excel_reportcheckin.php?datestart=' + datestart + '&department=' + department + '&section=' + section + '&area=' + area, '_blank');

                                                    // }

                                                    window.open('excel_reportcheckingmt.php?datestart=' + datestart , '_blank');
                                                }

                                                function select_pdfdailytenkoofficer()
                                                {
                                                    // var department = document.getElementById('select_department_month').value;
                                                    // var section = document.getElementById('select_section_month').value;
                                                    // var area = document.getElementById('select_area_section').value;

                                                    var datestart = document.getElementById('txt_datestart_month').value;

                                                    // if (department == '02' && (section == '01' || section == '02')) {
                                                    //     window.open('pdf_reportcheckin_acc.php?datestart=' + datestart + '&department=' + department + '&section=' + section + '&area=' + area, '_blank');
                                                    // } else if (department == '03' && section == '03') {
                                                    //     window.open('pdf_reportcheckin_sq.php?datestart=' + datestart + '&department=' + department + '&section=' + section + '&area=' + area, '_blank');
                                                    // } else {
                                                    //     window.open('pdf_reportcheckin.php?datestart=' + datestart + '&department=' + department + '&section=' + section + '&area=' + area, '_blank');

                                                    // }

                                                    window.open('pdf_reportcheckingmt.php?datestart=' + datestart, '_blank');

                                                }












                                                $(document).ready(function () {
                                                    $('#dataTables-example').DataTable({
                                                        responsive: true,
                                                    });
                                                });

                                                $(document).ready(function () {
                                                    $('#dataTables-example1').DataTable({
                                                        responsive: true,
                                                    });
                                                });



        </script>


    </body>

</html>
<?php
sqlsrv_close($conn);
?>
