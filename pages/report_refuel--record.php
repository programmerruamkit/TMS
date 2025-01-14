
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
ini_set('max_execution_time', 300);
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$sql_seSystime = "{call megGetdate_v2(?)}";
$params_seSystime = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
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
                        รายงานรายละเอียดการเติมน้ำมัน
                    </h2>
                </div>
            </div>
            <div class="row" >
                <div class="col-lg-12">
                    <div class="panel-body">
                        <div class="tab-content"></div> 
                    </div>
                    <div class="row" >
                        <div class="col-lg-12">
                            <div class="well">
                                <div class="row">
                                    <form action="report_refuelrecord_export.php" method="post" target="_blank">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ช่วงวันที่เริ่มต้น</label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_datestartoil" name="txt_datestartoil" value="<?= $result_seSystime['SYSDATE'] ?>" onchange="datetodateoil();" placeholder="วันที่เริ่มต้น">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ช่วงวันที่สิ้นสุด</label>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_dateendoil" name="txt_dateendoil" value="<?= $result_seSystime['SYSDATE'] ?>" placeholder="วันที่สิ้นสุด">
                                            </div>
                                        </div>
                                        <!-- <div class="col-lg-3" >
                                            <label>&nbsp;</label><br>
                                            <a href="#" onclick="select_dailytenkoofficer();" title="Excel" class="btn btn-success"><b>Excel</b> <li class="fa fa-file-excel-o" ></li></a>
                                            &nbsp;&nbsp;
                                            <a href="#" onclick="select_pdfdailytenkoofficer();" title="PDF" class="btn btn-danger"><b>PDF</b> <li class="fa fa-file-pdf-o" ></li></a>
                                        </div> -->
                                        <div class="col-lg-3" >
                                            <label>&nbsp;</label><br>
                                            <button type="submit" class="btn btn-success btn-md" name="EXCEL" value="EXCEL"><b>Excel</b> <li class="fa fa-file-excel-o" ></button>
                                            <!-- <a href="report_refuelrecord_export.php" title="Excel" class="btn btn-success" target="_blank"><b>Excel</b> <li class="fa fa-file-excel-o" ></li></a> -->
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-danger btn-md" name="PDF" value="PDF"><b>PDF</b> <li class="fa fa-file-pdf-o" ></button>
                                            <!-- <a href="report_refuelrecord_pdf.php" title="PDF" class="btn btn-danger" target="_blank"><b>PDF</b> <li class="fa fa-file-pdf-o" ></li></a> -->
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script src="../dist/js/jquery.autocomplete.js"></script>
    <script src="../dist/js/bootstrap-select.js"></script>
    <script type="text/javascript">        
        function datetodateoil(){
            document.getElementById('txt_dateendoil').value = document.getElementById('txt_datestartoil').value;
        }
        $(document).ready(function () {
            $('#dataTables-oiltat').DataTable({
                order: [[2, "asc"]],
                scrollX: true
            });
        });
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
        function select_dailytenkoofficer(){
            var startdate = document.getElementById('txt_datestartoil').value;
            var enddate = document.getElementById('txt_dateendoil').value;
            window.open('report_refuelrecord_excel.php?startdate=' + startdate + '&enddate=' + enddate + area, '_blank');
        }

        function select_pdfdailytenkoofficer(){
            var department = document.getElementById('select_department_month').value;
            var section = document.getElementById('select_section_month').value;
            var area = document.getElementById('select_area_section').value;

            var datestart = document.getElementById('txt_datestart_month').value;

            if (department == '02' && (section == '01' || section == '02')) {
                window.open('pdf_reportcheckin_acc.php?datestart=' + datestart + '&department=' + department + '&section=' + section + '&area=' + area, '_blank');
            } else if (department == '03' && section == '03') {
                window.open('pdf_reportcheckin_sq.php?datestart=' + datestart + '&department=' + department + '&section=' + section + '&area=' + area, '_blank');
            } else {
                window.open('pdf_reportcheckin.php?datestart=' + datestart + '&department=' + department + '&section=' + section + '&area=' + area, '_blank');
            }
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
