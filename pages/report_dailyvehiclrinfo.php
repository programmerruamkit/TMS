
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
                            รายงานตรวจรถประจำวัน


                        </h2>
                    </div>

                    <!-- /.col-lg-12 -->
                </div>
                <?php
                if ($_GET['area'] == 'amt') {
                    ?>
                    <div class="row" >
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row" >
                                        <div class="col-lg-6">

                                            รายงานตรวจรถประจำวันอมตะ

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
                                                                <label>ค้นหาตามช่วงวันที่</label>
                                                                <input class="form-control dateen" readonly="" style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                            </div>

                                                        </div>



                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <!--<button type="button" class="btn btn-default" onclick="select_process();">Process <li class="fa fa-calculator"></li></button>-->
                                                                <button type="button" class="btn btn-default" onclick="select_dailyvehiclrinfoamt();">ค้นหา <li class="fa fa-search"></li></button>
                                                            </div>

                                                        </div>




                                                        <div class="col-lg-8" style="text-align: right">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="excel_dailyvehiclrinfoamt();" class="btn btn-default">พิมพ์ <li class="fa fa-print"></li></a>

                                                        </div>
                                                        <!--
                                                        <div class="col-lg-1" style="text-align: right">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="excel_foodcompensation3();" class="btn btn-default">พิมพ์(รายละเอียด) <li class="fa fa-print"></li></a>

                                                        </div>
                                                        -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                        รายงานค่าอาหาร (รายบริษัท)
                                                    </div>
                                                    <!-- /.panel-heading -->

                                                    <div class="panel-body">

                                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                            <div id="datadef">
                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>

                                                                            <th style="text-align: center">ลำดับ</th>
                                                                            <th>วันที่</th>
                                                                            <th>ประเภทรถ</th>
                                                                            <th>ทะเบียน</th>
                                                                            <th>ชื่อรถ(ไทย)</th>
                                                                            <th>ชื่อรถ(ENG)</th>
                                                                            <th>เลขไมล์ต้น</th>
                                                                            <th>เลขไมล์ปลาย</th>




                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $i = 1;
                                                                        $sql_getCar = "SELECT DISTINCT a.VEHICLEREGISNUMBER,c.VEHICLETYPEDESC, a.THAINAME, a.ENGNAME,
                                                                        CONVERT(NVARCHAR(10),GETDATE(),103) AS 'SYSDATE'
                                                                        FROM VEHICLEINFO a
                                                                        LEFT JOIN dbo.VEHICLETYPE c ON a.VEHICLETYPECODE = c.VEHICLETYPECODE
                                                                        WHERE a.ACTIVESTATUS = 1
                                                                        AND (a.THAINAME NOT LIKE '%R-%' OR a.THAINAME NOT LIKE '%RA-%' OR a.THAINAME NOT LIKE '%RP-%'
                                                                        OR a.THAINAME NOT LIKE '%คลองเขื่อน%'  OR a.THAINAME NOT LIKE '%ด่านช้าง%'  OR a.THAINAME NOT LIKE '%สวนผึ้ง%'
                                                                        OR a.ENGNAME NOT LIKE '%ดินแดง%' OR a.ENGNAME NOT LIKE '%อุทัยธานี%' OR a.ENGNAME NOT LIKE '%Kerry%'
                                                                        OR a.THAINAME NOT LIKE '%เขาชะเมา%' OR a.THAINAME NOT LIKE '%เฉลิมพระเกียรติ%' OR a.THAINAME NOT LIKE '%P35%' )
                                                                        AND c.VEHICLETYPEDESC != 'เก๋งสองตอน'";
                                                                        $params_getCar = array();
                                                                        $query_getCar = sqlsrv_query($conn, $sql_getCar, $params_getCar);
                                                                        while ($result_getCar = sqlsrv_fetch_array($query_getCar, SQLSRV_FETCH_ASSOC)) {


                                                                            $sql_getMilestart = "SELECT MAX(MILEAGENUMBER) AS 'MILEAGENUMBER' FROM [dbo].[MILEAGE] WHERE CONVERT(NVARCHAR(10),CREATEDATE,103) = CONVERT(NVARCHAR(10),GETDATE(),103)
                                                                            AND MILEAGETYPE = 'MILEAGESTART' AND VEHICLEREGISNUMBER = '" . $result_getCar['VEHICLEREGISNUMBER'] . "'";
                                                                            $params_getMilestart = array();
                                                                            $query_getMilestart = sqlsrv_query($conn, $sql_getMilestart, $params_getMilestart);
                                                                            $result_getMilestart = sqlsrv_fetch_array($query_getMilestart, SQLSRV_FETCH_ASSOC);

                                                                            $sql_getMileend = "SELECT MAX(MILEAGENUMBER) AS 'MILEAGENUMBER' FROM [dbo].[MILEAGE] WHERE CONVERT(NVARCHAR(10),CREATEDATE,103) = CONVERT(NVARCHAR(10),GETDATE(),103)
                                                                            AND MILEAGETYPE = 'MILEAGEEND' AND VEHICLEREGISNUMBER = '" . $result_getCar['VEHICLEREGISNUMBER'] . "'";
                                                                            $params_getMileend = array();
                                                                            $query_getMileend = sqlsrv_query($conn, $sql_getMileend, $params_getMileend);
                                                                            $result_getMileend = sqlsrv_fetch_array($query_getMileend, SQLSRV_FETCH_ASSOC);
                                                                            ?>
                                                                            <tr>
                                                                                <td style="text-align: center"><?= $i ?></td>
                                                                                <td style="text-align: center"><?= $result_getCar['SYSDATE'] ?></td>
                                                                                <td style="text-align: center"><?= $result_getCar['VEHICLETYPEDESC'] ?></td>
                                                                                <td style="text-align: center"><?= $result_getCar['VEHICLEREGISNUMBER'] ?></td>
                                                                                <td style="text-align: center"><?= $result_getCar['THAINAME'] ?></td>
                                                                                <td style="text-align: center"><?= $result_getCar['ENGNAME'] ?></td>
                                                                                <td style="text-align: center"><?= number_format($result_getMilestart['MILEAGENUMBER']) ?></td>
                                                                                <td style="text-align: center"><?= number_format($result_getMileend['MILEAGENUMBER']) ?></td>
                                                                            </tr>
                                                                            <?php
                                                                            $i++;
                                                                        }
                                                                        ?>
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
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                    </div>
                    <?php
                }
                
                else if ($_GET['area'] == 'gw') {
                    ?>
                    <div class="row" >
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row" >
                                        <div class="col-lg-6">

                                            รายงานตรวจรถประจำวันอมตะ

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
                                                                <label>ค้นหาตามช่วงวันที่</label>
                                                                <input class="form-control dateen" readonly="" style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                            </div>

                                                        </div>



                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <!--<button type="button" class="btn btn-default" onclick="select_process();">Process <li class="fa fa-calculator"></li></button>-->
                                                                <button type="button" class="btn btn-default" onclick="select_dailyvehiclrinfoamt();">ค้นหา <li class="fa fa-search"></li></button>
                                                            </div>

                                                        </div>




                                                        <div class="col-lg-8" style="text-align: right">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="excel_dailyvehiclrinfoamt();" class="btn btn-default">พิมพ์ <li class="fa fa-print"></li></a>

                                                        </div>
                                                        <!--
                                                        <div class="col-lg-1" style="text-align: right">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="excel_foodcompensation3();" class="btn btn-default">พิมพ์(รายละเอียด) <li class="fa fa-print"></li></a>

                                                        </div>
                                                        -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                        รายงานค่าอาหาร (รายบริษัท)
                                                    </div>
                                                    <!-- /.panel-heading -->

                                                    <div class="panel-body">

                                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                            <div id="datadef">
                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>

                                                                            <th style="text-align: center">ลำดับ</th>
                                                                            <th>วันที่</th>
                                                                            <th>ประเภทรถ</th>
                                                                            <th>ทะเบียน</th>
                                                                            <th>ชื่อรถ(ไทย)</th>
                                                                            <th>ชื่อรถ(ENG)</th>
                                                                            <th>เลขไมล์ต้น</th>
                                                                            <th>เลขไมล์ปลาย</th>




                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $i = 1;
                                                                        $sql_getCar = "SELECT DISTINCT a.VEHICLEREGISNUMBER,c.VEHICLETYPEDESC, a.THAINAME, a.ENGNAME,
                                                                        CONVERT(NVARCHAR(10),GETDATE(),103) AS 'SYSDATE'
                                                                        FROM VEHICLEINFO a
                                                                        LEFT JOIN dbo.VEHICLETYPE c ON a.VEHICLETYPECODE = c.VEHICLETYPECODE
                                                                        WHERE a.ACTIVESTATUS = 1
                                                                        AND (a.THAINAME LIKE '%R-%' OR a.THAINAME LIKE '%RA-%' OR a.THAINAME LIKE '%RP-%'
                                                                        OR a.THAINAME LIKE '%คลองเขื่อน%'  OR a.THAINAME LIKE '%ด่านช้าง%'  OR a.THAINAME LIKE '%สวนผึ้ง%'
                                                                        OR a.ENGNAME LIKE '%ดินแดง%' OR a.ENGNAME LIKE '%อุทัยธานี%' OR a.ENGNAME LIKE '%Kerry%'
                                                                        OR a.THAINAME LIKE '%เขาชะเมา%' OR a.THAINAME LIKE '%เฉลิมพระเกียรติ%' OR a.THAINAME LIKE '%P35%' )
                                                                        ";
                                                                        $params_getCar = array();
                                                                        $query_getCar = sqlsrv_query($conn, $sql_getCar, $params_getCar);
                                                                        while ($result_getCar = sqlsrv_fetch_array($query_getCar, SQLSRV_FETCH_ASSOC)) {


                                                                            $sql_getMilestart = "SELECT MAX(MILEAGENUMBER) AS 'MILEAGENUMBER' FROM [dbo].[MILEAGE] WHERE CONVERT(NVARCHAR(10),CREATEDATE,103) = CONVERT(NVARCHAR(10),GETDATE(),103)
                                                                            AND MILEAGETYPE = 'MILEAGESTART' AND VEHICLEREGISNUMBER = '" . $result_getCar['VEHICLEREGISNUMBER'] . "'";
                                                                            $params_getMilestart = array();
                                                                            $query_getMilestart = sqlsrv_query($conn, $sql_getMilestart, $params_getMilestart);
                                                                            $result_getMilestart = sqlsrv_fetch_array($query_getMilestart, SQLSRV_FETCH_ASSOC);

                                                                            $sql_getMileend = "SELECT MAX(MILEAGENUMBER) AS 'MILEAGENUMBER' FROM [dbo].[MILEAGE] WHERE CONVERT(NVARCHAR(10),CREATEDATE,103) = CONVERT(NVARCHAR(10),GETDATE(),103)
                                                                            AND MILEAGETYPE = 'MILEAGEEND' AND VEHICLEREGISNUMBER = '" . $result_getCar['VEHICLEREGISNUMBER'] . "'";
                                                                            $params_getMileend = array();
                                                                            $query_getMileend = sqlsrv_query($conn, $sql_getMileend, $params_getMileend);
                                                                            $result_getMileend = sqlsrv_fetch_array($query_getMileend, SQLSRV_FETCH_ASSOC);
                                                                            ?>
                                                                            <tr>
                                                                                <td style="text-align: center"><?= $i ?></td>
                                                                                <td style="text-align: center"><?= $result_getCar['SYSDATE'] ?></td>
                                                                                <td style="text-align: center"><?= $result_getCar['VEHICLETYPEDESC'] ?></td>
                                                                                <td style="text-align: center"><?= $result_getCar['VEHICLEREGISNUMBER'] ?></td>
                                                                                <td style="text-align: center"><?= $result_getCar['THAINAME'] ?></td>
                                                                                <td style="text-align: center"><?= $result_getCar['ENGNAME'] ?></td>
                                                                                <td style="text-align: center"><?= number_format($result_getMilestart['MILEAGENUMBER']) ?></td>
                                                                                <td style="text-align: center"><?= number_format($result_getMileend['MILEAGENUMBER']) ?></td>
                                                                            </tr>
                                                                            <?php
                                                                            $i++;
                                                                        }
                                                                        ?>
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
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                    </div>
                    <?php
                }
                ?>
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
                                                                $(document).ready(function () {
                                                                    $('#dataTables-example').DataTable({
                                                                        responsive: true
                                                                    });
                                                                    $('#dataTables-example2').DataTable({
                                                                        responsive: true
                                                                    });
                                                                });
                                                                function select_dailyvehiclrinfoamt()
                                                                {


                                                                    var datestart = document.getElementById('txt_datestart').value;



                                                                    $.ajax({
                                                                        type: 'post',
                                                                        url: 'meg_data.php',
                                                                        data: {
                                                                            txt_flg: "select_dailyvehiclrinfoamt", datestart: datestart
                                                                        },
                                                                        success: function (response) {
                                                                            if (response)
                                                                            {

                                                                                document.getElementById("datasr").innerHTML = response;
                                                                                document.getElementById("datadef").innerHTML = "";
                                                                            }
                                                                            $(document).ready(function () {
                                                                                $('#dataTables-example').DataTable({
                                                                                    responsive: true
                                                                                });
                                                                            });



                                                                        }
                                                                    });
                                                                    // }

                                                                }
                                                                function select_dailyvehiclrinfogw()
                                                                {


                                                                    var datestart = document.getElementById('txt_datestart').value;



                                                                    $.ajax({
                                                                        type: 'post',
                                                                        url: 'meg_data.php',
                                                                        data: {
                                                                            txt_flg: "select_dailyvehiclrinfogw", datestart: datestart
                                                                        },
                                                                        success: function (response) {
                                                                            if (response)
                                                                            {

                                                                                document.getElementById("datasr").innerHTML = response;
                                                                                document.getElementById("datadef").innerHTML = "";
                                                                            }
                                                                            $(document).ready(function () {
                                                                                $('#dataTables-example2').DataTable({
                                                                                    responsive: true
                                                                                });
                                                                            });



                                                                        }
                                                                    });
                                                                    // }

                                                                }


                                                                function excel_dailyvehiclrinfoamt()
                                                                {
                                                                    var datestart = document.getElementById('txt_datestart').value;
                                                                  
                                                                    window.open('excel_reportdailyvehiclrinfoamt.php?datestart=' + datestart, '_blank');

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

            </script>


    </body>

</html>

<?php
sqlsrv_close($conn);
?>
