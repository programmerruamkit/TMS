
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
                            รายงานการพักผ่อน


                        </h2>
                    </div>

                    <!-- /.col-lg-12 -->
                </div>
                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row" >
                                    <div class="col-lg-6">
                                         <a href="index.html">หน้าหลัก</a> / รายงานการพักผ่อน
                                    </div>
                                    <div class="col-lg-6 text-right">

                                        <a href="pdf_RestReport.php" target="_blank" onclick="pdf_reporttenko()" class="btn btn-default">พิมพ์เอกสารการพักผ่อน <li class="fa fa-print"></li></a>
                                    </div>
                                </div>
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <!-- Tab panes -->
                                <div class="tab-content">

                                    <div class="row">&nbsp;</div>
                                    <div class="row" >
                                        <div class="col-lg-12">
                                            <div class="well">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        &nbsp;
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>บริษัท</label><br>

                                                        <select class="selectpicker" multiple="" data-actions-box="true" id="cb_comp" name="cb_comp">
                                                            <!--<option value = "">บริษัททั้งหมด</option>-->

                                                            <?php
                                                            $sql_seComp = "{call megCompanyEHR_v2(?,?)}";
                                                            $params_seComp = array(
                                                                array('select_company', SQLSRV_PARAM_IN),
                                                                array('', SQLSRV_PARAM_IN)
                                                            );
                                                            $query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
                                                            while ($result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <option value = "<?= $result_seComp['Company_Code'] ?>"><?= $result_seComp['Company_Code'] ?> <?= $result_seComp['Company_NameT'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <input class="form-control" style="display: none"  id="txt_comp" name="txt_comp" maxlength="500" value="" >

                                                    </div>
                                                    <div class="col-lg-2 ">
                                                        <div class="form-group">
                                                            <label>ค้นหาตามช่วงวันที่</label>
                                                            <input class="form-control dateen" id="txt_datestart" onchange="datetodate();" readonly="" style="background-color: #f080802e" name="txt_datestart" value="<?= $result_getDate['SYSDATE'] ?>" placeholder="วันที่เริ่มต้น">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control dateen" id="txt_dateend" readonly="" onchange="select_reporttenko()" style="background-color: #f080802e" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE'] ?>">

                                                            </div>
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
                                                    รายงานเอกสารเท็งโกะ
                                                </div>
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="data_def">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ลำดับ</th>
                                                                        <th>พนักงาน</th>
                                                                        <th>ชื่อรถ/ทะเบียน</th>
                                                                        <th>สายงาน</th>
                                                                        <th>วันที่</th>
                                                                        <th>เวลา</th>
                                                                        <th>พนักงาน</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                        <tr class="odd gradeX">
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>



                                                                        </tr>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div id="data_sr"></div>

                                                    </div>


                                                    <!-- /.panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                        </div>
                                    </div>
                                </div>




                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <script src="../vendor/jquery/jquery.min.js"></script>
            <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
            <script src="../vendor/metisMenu/metisMenu.min.js"></script>
            <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
            <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
            <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
            <script src="../dist/js/sb-admin-2.js"></script>
            <script src="../js/jquery.datetimepicker.full.js"></script>
            <script src="../dist/js/bootstrap-select.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>
            <script type="text/javascript">
                                                                    $('.selectpicker').on('changed.bs.select', function () {
                                                                        document.getElementById('txt_comp').value = $(this).val();

                                                                    });
            </script>
            <script type="text/javascript">

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
