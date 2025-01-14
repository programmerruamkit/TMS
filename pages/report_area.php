
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

if ($_GET['id1'] != "") {
$condition1 = " AND a.MENUID = " . $_GET['id1'];
$sql_getMenu = "{call megMenu_v2(?,?)}";
$params_getMenu = array(
array('select_menu', SQLSRV_PARAM_IN),
 array($condition1, SQLSRV_PARAM_IN)
);
$query_getMenu = sqlsrv_query($conn, $sql_getMenu, $params_getMenu);
$result_getMenu = sqlsrv_fetch_array($query_getMenu, SQLSRV_FETCH_ASSOC);
}
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
        <input type="text" class="form-control" id="txt_companycode" name="txt_companycode" style="display: none">
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

                        <h2 class="page-header"><i class="fa fa-check-circle"></i>  
                            พื้นที่

                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">

                                <?php
                                echo "พื้นที่";
                                $link = "<a href='report_area.php?area=".$_GET['area'].">พื้นที่</a>";
                                $_SESSION["link"] = $link;
                                ?>
                            </div>
                            <!-- /.panel-heading -->

                            <div class="panel-body">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <?php
                                    if($_GET['area'] == 'amata')
                                    {
                                    ?>
                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>พื้นที่</th>

                                                <th style="text-align: center">ข้อมูลย่อย</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr class="odd gradeX">
                                                <td>พื้นที่หน่วยงาน สำนักงาน (BTC)</td>
                                                <td style="text-align: center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                            <i class="fa fa-chevron-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu slidedown">
                                                            <li>
                                                                <a target="_bank" href="meg_tel.php?area=amata&type=btc">เลือกหน่วยงาน</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr class="odd gradeX">
                                                <td>พื้นที่หน่วยงาน Transport (OPS)</td>
                                                <td style="text-align: center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                            <i class="fa fa-chevron-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu slidedown">
                                                            <li>

                                                                <a target="_bank" href="meg_tel.php?area=amata&type=ops">เลือกหน่วยงาน</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr class="odd gradeX">
                                                <td>พื้นที่หน่วยงาน ซ่อมบำรุง (RTD)</td>
                                                <td style="text-align: center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                            <i class="fa fa-chevron-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu slidedown">
                                                            <li>

                                                                <a target="_bank" href="meg_tel.php?area=amata&type=rtd">เลือกหน่วยงาน</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr class="odd gradeX">
                                                <td>พื้นที่หน่วยงาน รักษาความปลอดภัย (SG)</td>
                                                <td style="text-align: center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                            <i class="fa fa-chevron-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu slidedown">
                                                            <li>

                                                                <a target="_bank" href="meg_tel.php?area=amata&type=sg">เลือกหน่วยงาน</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>

                                            </tr>

                                           
                                        </tbody>
                                    </table>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
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
        <script>
            $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".dateen").datetimepicker({
                    timepicker: false,
                    format: 'm/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                });
            });
            function select_companycompensation()
            {
                var datestart = document.getElementById('txt_datestart').value;

                var companycode = document.getElementById('txt_companycode').value;

                window.open('pdf_companycompensation.php?companycode=' + companycode + '&datestart=' + datestart, '_blank');
            }

            function modal_companycompensation(companycode)
            {
                document.getElementById('txt_companycode').value = companycode;
            }
            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true,
                    order: [[0, "desc"]]
                });
            });
        </script>


    </body>

</html>
<?php
sqlsrv_close($conn);
?>