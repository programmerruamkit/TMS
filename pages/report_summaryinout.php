
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

$area = ($_GET['area'] == 'amata' ? 'พื้นที่อมตะนคร' : 'พื้นที่เกตุเวย์');
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
                            รายงานสรุปผลการเข้าออกของพนักงาน (<?= $area ?>)


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

                                        รายงานสรุปผลการเข้าออกของพนักงาน (<?= $area ?>)

                                    </div>
                                    <div class="col-lg-6 text-right"></div>
                                </div>
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">

                                <div class="tab-content">

                                    <div class="row">&nbsp;</div>
                                    <div class="row" >
                                        <div class="col-lg-12">
                                            <div class="well">
                                                <div class="row">


                                                    <div class="col-lg-2">

                                                        <div class="form-group">
                                                            <label>ค้นหาวันที่</label>
                                                            <input class="form-control dateen" readonly=""  style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                        </div>

                                                    </div>

                                                    
                                                    <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" onclick="select_summaryinout();">ค้นหา <li class="fa fa-search"></li></button>
                                                        </div>

                                                    </div>


                                                    <div class="col-lg-8" style="text-align: right">
                                                        <label>&nbsp;</label><br>
                                                        <a href="#" onclick="excel_summaryinout();" class="btn btn-default">พิมพ์ <li class="fa fa-print"></li></a>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #e7e7e7">

                                                    รายงานสรุปผลการเข้าออกของพนักงาน (<?= $area ?>)
                                                </div>
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="text-align: left" colspan="10">รายงานสรุปผลการเข้าออกของพนักงาน วันที่ <?= $result_getDate['SYSDATE'] ?></th>
                                                                    </tr>
                                                                    <tr>

                                                                        <th style="text-align: center" rowspan="2">ลำดับ</th>
                                                                        <th style="text-align: center" rowspan="2">แผนก</th>
                                                                        <th style="text-align: center" rowspan="2">พนักงานทั้งหมด</th>
                                                                        <th style="text-align: center" rowspan="2">พนักงานมาปฏิบัติงาน</th>
                                                                        <th style="text-align: center" rowspan="2">ขาด/ลา/ปฎิบัติงานนอกสถานที่</th>
                                                                        <th style="text-align: center" colspan="2"><font style="color: green"> ปกติ</font></th>
                                                                        <th style="text-align: center" colspan="2"><font style="color: red"> ผิดปกติ</font></th>
                                                                        <th style="text-align: center" rowspan="2">หมายเหตุ</th>



                                                                    </tr>
                                                                    <tr>

                                                                        <th style="text-align: center" >เข้าก่อน 08.00 น.</th>
                                                                        <th style="text-align: center" >ออกหลัง 17.00 น.</th>
                                                                        <th style="text-align: center" >เข้าหลัง 08.00 น.</th>
                                                                        <th style="text-align: center" >ออกก่อน 17.00 น.</th>



                                                                    </tr>

                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div id="datasr"></div>
                                                    </div>


                                                    <!-- /.panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
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
        <script>

                                                            function select_summaryinout()
                                                            {
                                                                var datestart = document.getElementById('txt_datestart').value;
                                                              

                                                                // alert(datestart);
                                                                // alert(datestart);
                                                                // alert(companycode);
                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "select_summaryinout", datestart: datestart
                                                                    },
                                                                    success: function (response) {
                                                                        if (response)
                                                                        {
                                                                            document.getElementById("datasr").innerHTML = response;
                                                                            document.getElementById("datadef").innerHTML = "";
                                                                        }
                                                                        $(document).ready(function () {
                                                                            $('#dataTables-example').DataTable({
                                                                                responsive: true,
                                                                            });
                                                                        });



                                                                    }
                                                                });
                                                                // }

                                                            }

                                                            function excel_summaryinout()
                                                            {
                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;
                                                                var companycode = document.getElementById('select_com').value;
                                                                var employeegroup = document.getElementById('select_employeegroup').value;

                                                                window.open('excel_summaryinout.php?datestart=' + datestart + '&dateend=' + dateend + '&companycode=' + companycode + '&employeegroup=' + employeegroup, '_blank');

                                                            }


                                                            function datetodate()
                                                            {
                                                                document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

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
                                                                    responsive: true,
                                                                });
                                                            });


        </script>


    </body>

</html>

<?php
sqlsrv_close($conn);
?>
