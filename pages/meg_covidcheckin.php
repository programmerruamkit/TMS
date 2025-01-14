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
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
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
        <style>
            /* Set the size of the div element that contains the map */
            #map {
                height: 100%;  /* The height is 400 pixels */
                width: 100%;  /* The width is the width of the web page */
            }
        </style>

    </head>

    <body>
        <input type="text" id="txt_cnt" style="display: none">
        <input type="text" id="txt_let" style="display: none">
        <input type="text" id="txt_long" style="display: none">
        <input type="text" id="txt_address" style="display: none">
        <input type="text" id="txt_datetime" style="display: none">


        <div  class="modal fade text-center" id="modal_map" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 95%;height: 80%">
                <div class="modal-content" >
                    <div class="modal-header" >
                        <div class="row">

                            <div class="col-lg-12 text-left" id="msg2">

                            </div>


                        </div>
                    </div>
                    <div class="modal-body" >
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <!--<iframe id="ifrm" style="width: 100%;height: 100%;border:0"   allowfullscreen></iframe>-->
                                <div id="map"></div>



                            </div>

                        </div>

                    </div>
                    <div class="modal-footer" >
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-primary" onclick="initmap_data('', '')"><span class="fa fa-map"></span> แสดงข้อมูล Map</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                            </div>
                        </div>
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

                        <h2 class="page-header"><i class="fa fa-file-text-o"></i>
                            รายงานตัว Covid-19


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

                                        รายงานตัว Covid-19

                                    </div>
                                    <div class="col-lg-6 text-right"></div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-pills">
                                    <li class="active"><a href="#report-company" data-toggle="tab">รายงานทั้งหมด</a>
                                    </li>
                                    <li><a href="#report-persons" data-toggle="tab">รายงานรายบุคคล</a>
                                    </li>

                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="report-company">
                                        <div class="row" >&nbsp;</div>
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <div class="well">
                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <font style="color: red">* </font><label>วันที่</label>
                                                                <input class="form-control dateen" readonly="" style="background-color: #f080802e"  id="txt_datestart1" name="txt_datestart1" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <font style="color: red">* </font><label>พื้นที่</label>

                                                            <select id="select_area1"  name="select_area1" class="form-control" onchange="select_area(this.value)">

                                                                <option value="amata">อมตะ</option>
                                                                <option value="gateway">เกตุเวย์</option>

                                                            </select>



                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>ฝ่าย</label>

                                                            <select id="select_dep1" name="select_dep1" class="form-control" onchange="select_sec(this.value)">
                                                                <option value="">เลือกฝ่าย</option>
                                                                <option value="EX">Executive</option>
                                                                <?php
                                                                $sql_seDep = "SELECT DISTINCT DEPARTMENTCODE,DEPARTMENTNAME FROM [dbo].[DEPARTMENT_NEW] WHERE 1=1";

                                                                $query_seDep = sqlsrv_query($conn, $sql_seDep, $params_seDep);
                                                                while ($result_seDep = sqlsrv_fetch_array($query_seDep, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <option value="<?= $result_seDep['DEPARTMENTCODE'] ?>"><?= $result_seDep['DEPARTMENTNAME'] ?></option>

                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>



                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>แผนก</label>
                                                            <div id="sec_def">
                                                                <select id="select_sec1" name="select_sec1" class="form-control">
                                                                    <option value="">เลือกแผนก</option>


                                                                </select>
                                                            </div>
                                                            <div id="sec_sr"></div>


                                                        </div>




                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-default" onclick="select_covidcheckin();">ค้นหา <li class="fa fa-search"></li></button>
                                                            </div>

                                                        </div>


                                                        <div class="col-lg-2" style="text-align: center">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="excel_covidcheckin();" class="btn btn-default">รายงาน(EXCEL) <li class="fa fa-print"></li></a>

                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                        รายงานตัวปฎิบัติงาน
                                                    </div>
                                                    <!-- /.panel-heading -->

                                                    <div class="panel-body">

                                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                            <div id="datadef">
                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>

                                                                            <th >ลำดับ</th>
                                                                            <th>วันที่</th>
                                                                            <th>รหัสพนักงาน</th>
                                                                            <th>ชื่อ-นามสกุล</th>
                                                                            <th>เวลารายงานตัว</th>
                                                                            <th>พื้นที่</th>
                                                                            <th style="text-align: center">แผนที่</th>
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
                                    <div class="tab-pane fade" id="report-persons">
                                        <div class="row" >&nbsp;</div>
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <div class="well">
                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <font style="color: red">* </font><label>ช่วงวันที่</label>
                                                                <input class="form-control dateen" readonly="" style="background-color: #f080802e" onchange="datetodate()"  id="txt_datestart2" name="txt_datestart2" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>&nbsp;</label>
                                                                <input class="form-control dateen" readonly="" style="background-color: #f080802e"  id="txt_dateend2" name="txt_dateend2" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่สิ้นสุด">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <font style="color: red">* </font><label>พนักงาน</label>

                                                            <input type="text"  name="txt_employeecode2" id="txt_employeecode2" class="form-control">



                                                        </div>




                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-default" onclick="select_covidcheckin2();">ค้นหา <li class="fa fa-search"></li></button>
                                                            </div>

                                                        </div>


                                                        <div class="col-lg-4" style="text-align: right">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="excel_covidcheckin2();" class="btn btn-default">รายงาน(EXCEL) <li class="fa fa-print"></li></a>

                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                        รายงานตัวปฎิบัติงาน
                                                    </div>
                                                    <!-- /.panel-heading -->

                                                    <div class="panel-body">

                                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                            <div id="datadef2">
                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example2" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>

                                                                            <th >ลำดับ</th>
                                                                            <th>วันที่</th>
                                                                            <th>รหัสพนักงาน</th>
                                                                            <th>ชื่อ-นามสกุล</th>
                                                                            <th>เวลารายงานตัว</th>
                                                                            <th>พื้นที่</th>

                                                                        </tr>

                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div id="datasr2"></div>
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

                        </div>
                        <!-- /.panel -->
                    </div>
                </div>
                <!-- /.row -->

            </div>



            <?PHP
            $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeeehr2', " ");
            ?>
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


                                                                var txt_employeecode2 = [<?= $emp ?>];
                                                                $("#txt_employeecode2").autocomplete({
                                                                    source: [txt_employeecode2]
                                                                });

                                                                function select_sec(data)
                                                                {

                                                                    $.ajax({
                                                                        type: 'post',
                                                                        url: 'meg_data.php',
                                                                        data: {
                                                                            txt_flg: "select_sec1", data: data
                                                                        },
                                                                        success: function (response) {
                                                                            document.getElementById("sec_sr").innerHTML = response;
                                                                            document.getElementById("sec_def").innerHTML = "";



                                                                        }
                                                                    });
                                                                }



                                                                function select_covidcheckin()
                                                                {



                                                                    $.ajax({
                                                                        type: 'post',
                                                                        url: 'meg_data.php',
                                                                        data: {
                                                                            txt_flg: "select_covidcheckin"
                                                                            , area1: document.getElementById('select_area1').value
                                                                            , datestart1: document.getElementById('txt_datestart1').value
                                                                            , dep1: document.getElementById('select_dep1').value
                                                                            , sec1: document.getElementById('select_sec1').value
                                                                        },
                                                                        success: function (response) {
                                                                            document.getElementById("datasr").innerHTML = response;
                                                                            document.getElementById("datadef").innerHTML = "";


                                                                            $('#dataTables-example').DataTable({
                                                                                responsive: true,
                                                                            });


                                                                        }
                                                                    });

                                                                }
                                                                function select_covidcheckin2()
                                                                {


                                                                    if (document.getElementById('txt_employeecode2').value != '')
                                                                    {
                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_covidcheckin2"
                                                                                , employeecode2: document.getElementById('txt_employeecode2').value
                                                                                , datestart2: document.getElementById('txt_datestart2').value
                                                                                , dateend2: document.getElementById('txt_dateend2').value
                                                                            },
                                                                            success: function (response) {
                                                                                document.getElementById("datasr2").innerHTML = response;
                                                                                document.getElementById("datadef2").innerHTML = "";


                                                                                $('#dataTables-example2').DataTable({
                                                                                    responsive: true
                                                                                });


                                                                            }
                                                                        });
                                                                    } else
                                                                    {
                                                                        alert('กรุณาใส่ชื่อพนักงาน !');
                                                                    }

                                                                }

                                                                function excel_covidcheckin2()
                                                                {
                                                                    var datestart = document.getElementById('txt_datestart2').value;
                                                                    var dateend = document.getElementById('txt_dateend2').value;
                                                                    var employeecode = document.getElementById('txt_employeecode2').value;
                                                                    if (document.getElementById('txt_employeecode2').value != '')
                                                                    {
                                                                        window.open('excel_covidcheckin2.php?datestart=' + datestart + '&dateend=' + dateend + '&employeecode=' + employeecode, '_blank');
                                                                    } else
                                                                    {
                                                                        alert('กรุณาใส่ชื่อพนักงาน !');
                                                                    }

                                                                }
                                                                function excel_covidcheckin()
                                                                {
                                                                    var area1 = document.getElementById('select_area1').value;
                                                                    var datestart1 = document.getElementById('txt_datestart1').value;
                                                                    var dep1 = document.getElementById('select_dep1').value;
                                                                    var sec1 = document.getElementById('select_sec1').value;

                                                                    window.open('excel_covidcheckin1.php?area1=' + area1 + '&datestart1=' + datestart1 + '&dep1=' + dep1 + '&sec1=' + sec1, '_blank');


                                                                }


                                                                function datetodate()
                                                                {
                                                                    document.getElementById('txt_dateend2').value = document.getElementById('txt_datestart2').value;

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
                                                                $(document).ready(function () {
                                                                    $('#dataTables-example2').DataTable({
                                                                        responsive: true,
                                                                    });
                                                                });


            </script>


            <script>

                function initmap_data(employeecode, createdate)
                {
                    document.getElementById('msg2').innerHTML = "<b>พื้นที่รายงานตัวปฎิบัติงาน";
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "select_letcovid", employeecode: employeecode, createdate: createdate
                        },
                        success: function (rs) {


                            document.getElementById('txt_cnt').value = ((rs.split(",").length) - 1);
                            document.getElementById('txt_let').value = rs;



                        }
                    });

                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "select_longcovid", employeecode: employeecode, createdate: createdate
                        },
                        success: function (rs) {


                            document.getElementById('txt_long').value = rs;


                        }
                    });

                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "select_addresscovid", employeecode: employeecode, createdate: createdate
                        },
                        success: function (rs) {


                            document.getElementById('txt_address').value = rs;


                        }
                    });

                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "select_datetimecovid", employeecode: employeecode, createdate: createdate
                        },
                        success: function (rs) {


                            document.getElementById('txt_datetime').value = rs;


                        }
                    });


                    geocodeLatLng();
                }


                function geocodeLatLng() {

                    var arr_let = document.getElementById('txt_let').value.split(",");
                    var arr_long = document.getElementById('txt_long').value.split(",");
                    var arr_address = document.getElementById('txt_address').value.split("|");
                    var arr_datetime = document.getElementById('txt_datetime').value.split(",");
                    /*var latitude1 = '13.4687825';
                     var longitude1 = '100.9981879';
                     var latitude2 = '13.4635939';
                     var longitude2 = '101.0171241';
                     var latitude3 = '13.4635939';
                     var longitude3 = '100.9981879';*/
                    var latitude1 = arr_let[1];
                    var longitude1 = arr_long[1];

                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 15,

                        center: {lat: parseFloat(latitude1), lng: parseFloat(longitude1)}
                    });
                    var geocoder = new google.maps.Geocoder;
                    var infowindow = new google.maps.InfoWindow;

                    if (document.getElementById('txt_cnt').value == '1')
                    {
                        const line1 = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};

                    }
                    if (document.getElementById('txt_cnt').value == '2')
                    {

                        var latitude2 = arr_let[2];
                        var longitude2 = arr_long[2];

                        var infowindow2 = new google.maps.InfoWindow;
                        const line1 = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};
                        const line2 = {lat: parseFloat(latitude2), lng: parseFloat(longitude2)};
                        new google.maps.Polyline({path: [line1, line2], map: map});

                    }
                    if (document.getElementById('txt_cnt').value == '3')
                    {

                        var latitude2 = arr_let[2];
                        var longitude2 = arr_long[2];
                        var latitude3 = arr_let[3];
                        var longitude3 = arr_long[3];

                        var infowindow2 = new google.maps.InfoWindow;
                        var infowindow3 = new google.maps.InfoWindow;
                        const line1 = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};
                        const line2 = {lat: parseFloat(latitude2), lng: parseFloat(longitude2)};
                        const line3 = {lat: parseFloat(latitude3), lng: parseFloat(longitude3)};
                        new google.maps.Polyline({path: [line1, line2], map: map});
                        new google.maps.Polyline({path: [line2, line3], map: map});

                    }
                    if (document.getElementById('txt_cnt').value == '4')
                    {

                        var latitude2 = arr_let[2];
                        var longitude2 = arr_long[2];
                        var latitude3 = arr_let[3];
                        var longitude3 = arr_long[3];
                        var latitude4 = arr_let[4];
                        var longitude4 = arr_long[4];

                        var infowindow2 = new google.maps.InfoWindow;
                        var infowindow3 = new google.maps.InfoWindow;
                        var infowindow4 = new google.maps.InfoWindow;
                        const line1 = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};
                        const line2 = {lat: parseFloat(latitude2), lng: parseFloat(longitude2)};
                        const line3 = {lat: parseFloat(latitude3), lng: parseFloat(longitude3)};
                        const line4 = {lat: parseFloat(latitude4), lng: parseFloat(longitude4)};
                        new google.maps.Polyline({path: [line1, line2], map: map});
                        new google.maps.Polyline({path: [line2, line3], map: map});
                        new google.maps.Polyline({path: [line3, line4], map: map});

                    }
                    if (document.getElementById('txt_cnt').value == '5')
                    {

                        var latitude2 = arr_let[2];
                        var longitude2 = arr_long[2];
                        var latitude3 = arr_let[3];
                        var longitude3 = arr_long[3];
                        var latitude4 = arr_let[4];
                        var longitude4 = arr_long[4];
                        var latitude5 = arr_let[5];
                        var longitude5 = arr_long[5];

                        var infowindow2 = new google.maps.InfoWindow;
                        var infowindow3 = new google.maps.InfoWindow;
                        var infowindow4 = new google.maps.InfoWindow;
                        var infowindow5 = new google.maps.InfoWindow;
                        const line1 = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};
                        const line2 = {lat: parseFloat(latitude2), lng: parseFloat(longitude2)};
                        const line3 = {lat: parseFloat(latitude3), lng: parseFloat(longitude3)};
                        const line4 = {lat: parseFloat(latitude4), lng: parseFloat(longitude4)};
                        const line5 = {lat: parseFloat(latitude5), lng: parseFloat(longitude5)};
                        new google.maps.Polyline({path: [line1, line2], map: map});
                        new google.maps.Polyline({path: [line2, line3], map: map});
                        new google.maps.Polyline({path: [line3, line4], map: map});
                        new google.maps.Polyline({path: [line4, line5], map: map});

                    }
                    if (document.getElementById('txt_cnt').value == '6')
                    {

                        var latitude2 = arr_let[2];
                        var longitude2 = arr_long[2];
                        var latitude3 = arr_let[3];
                        var longitude3 = arr_long[3];
                        var latitude4 = arr_let[4];
                        var longitude4 = arr_long[4];
                        var latitude5 = arr_let[5];
                        var longitude5 = arr_long[5];
                        var latitude6 = arr_let[6];
                        var longitude6 = arr_long[6];

                        var infowindow2 = new google.maps.InfoWindow;
                        var infowindow3 = new google.maps.InfoWindow;
                        var infowindow4 = new google.maps.InfoWindow;
                        var infowindow5 = new google.maps.InfoWindow;
                        var infowindow6 = new google.maps.InfoWindow;
                        const line1 = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};
                        const line2 = {lat: parseFloat(latitude2), lng: parseFloat(longitude2)};
                        const line3 = {lat: parseFloat(latitude3), lng: parseFloat(longitude3)};
                        const line4 = {lat: parseFloat(latitude4), lng: parseFloat(longitude4)};
                        const line5 = {lat: parseFloat(latitude5), lng: parseFloat(longitude5)};
                        const line6 = {lat: parseFloat(latitude6), lng: parseFloat(longitude6)};
                        new google.maps.Polyline({path: [line1, line2], map: map});
                        new google.maps.Polyline({path: [line2, line3], map: map});
                        new google.maps.Polyline({path: [line3, line4], map: map});
                        new google.maps.Polyline({path: [line4, line5], map: map});
                        new google.maps.Polyline({path: [line5, line6], map: map});

                    }
                    if (document.getElementById('txt_cnt').value == '7')
                    {

                        var latitude2 = arr_let[2];
                        var longitude2 = arr_long[2];
                        var latitude3 = arr_let[3];
                        var longitude3 = arr_long[3];
                        var latitude4 = arr_let[4];
                        var longitude4 = arr_long[4];
                        var latitude5 = arr_let[5];
                        var longitude5 = arr_long[5];
                        var latitude6 = arr_let[6];
                        var longitude6 = arr_long[6];
                        var latitude7 = arr_let[7];
                        var longitude7 = arr_long[7];

                        var infowindow2 = new google.maps.InfoWindow;
                        var infowindow3 = new google.maps.InfoWindow;
                        var infowindow4 = new google.maps.InfoWindow;
                        var infowindow5 = new google.maps.InfoWindow;
                        var infowindow6 = new google.maps.InfoWindow;
                        var infowindow7 = new google.maps.InfoWindow;
                        const line1 = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};
                        const line2 = {lat: parseFloat(latitude2), lng: parseFloat(longitude2)};
                        const line3 = {lat: parseFloat(latitude3), lng: parseFloat(longitude3)};
                        const line4 = {lat: parseFloat(latitude4), lng: parseFloat(longitude4)};
                        const line5 = {lat: parseFloat(latitude5), lng: parseFloat(longitude5)};
                        const line6 = {lat: parseFloat(latitude6), lng: parseFloat(longitude6)};
                        const line7 = {lat: parseFloat(latitude7), lng: parseFloat(longitude7)};
                        new google.maps.Polyline({path: [line1, line2], map: map});
                        new google.maps.Polyline({path: [line2, line3], map: map});
                        new google.maps.Polyline({path: [line3, line4], map: map});
                        new google.maps.Polyline({path: [line4, line5], map: map});
                        new google.maps.Polyline({path: [line5, line6], map: map});
                        new google.maps.Polyline({path: [line6, line7], map: map});

                    }
                    if (document.getElementById('txt_cnt').value == '8')
                    {

                        var latitude2 = arr_let[2];
                        var longitude2 = arr_long[2];
                        var latitude3 = arr_let[3];
                        var longitude3 = arr_long[3];
                        var latitude4 = arr_let[4];
                        var longitude4 = arr_long[4];
                        var latitude5 = arr_let[5];
                        var longitude5 = arr_long[5];
                        var latitude6 = arr_let[6];
                        var longitude6 = arr_long[6];
                        var latitude7 = arr_let[7];
                        var longitude7 = arr_long[7];
                        var latitude8 = arr_let[8];
                        var longitude8 = arr_long[8];

                        var infowindow2 = new google.maps.InfoWindow;
                        var infowindow3 = new google.maps.InfoWindow;
                        var infowindow4 = new google.maps.InfoWindow;
                        var infowindow5 = new google.maps.InfoWindow;
                        var infowindow6 = new google.maps.InfoWindow;
                        var infowindow7 = new google.maps.InfoWindow;
                        var infowindow8 = new google.maps.InfoWindow;
                        const line1 = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};
                        const line2 = {lat: parseFloat(latitude2), lng: parseFloat(longitude2)};
                        const line3 = {lat: parseFloat(latitude3), lng: parseFloat(longitude3)};
                        const line4 = {lat: parseFloat(latitude4), lng: parseFloat(longitude4)};
                        const line5 = {lat: parseFloat(latitude5), lng: parseFloat(longitude5)};
                        const line6 = {lat: parseFloat(latitude6), lng: parseFloat(longitude6)};
                        const line7 = {lat: parseFloat(latitude7), lng: parseFloat(longitude7)};
                        const line8 = {lat: parseFloat(latitude8), lng: parseFloat(longitude8)};
                        new google.maps.Polyline({path: [line1, line2], map: map});
                        new google.maps.Polyline({path: [line2, line3], map: map});
                        new google.maps.Polyline({path: [line3, line4], map: map});
                        new google.maps.Polyline({path: [line4, line5], map: map});
                        new google.maps.Polyline({path: [line5, line6], map: map});
                        new google.maps.Polyline({path: [line6, line7], map: map});
                        new google.maps.Polyline({path: [line7, line8], map: map});

                    }
                    if (document.getElementById('txt_cnt').value == '9')
                    {

                        var latitude2 = arr_let[2];
                        var longitude2 = arr_long[2];
                        var latitude3 = arr_let[3];
                        var longitude3 = arr_long[3];
                        var latitude4 = arr_let[4];
                        var longitude4 = arr_long[4];
                        var latitude5 = arr_let[5];
                        var longitude5 = arr_long[5];
                        var latitude6 = arr_let[6];
                        var longitude6 = arr_long[6];
                        var latitude7 = arr_let[7];
                        var longitude7 = arr_long[7];
                        var latitude8 = arr_let[8];
                        var longitude8 = arr_long[8];
                        var latitude9 = arr_let[9];
                        var longitude9 = arr_long[9];

                        var infowindow2 = new google.maps.InfoWindow;
                        var infowindow3 = new google.maps.InfoWindow;
                        var infowindow4 = new google.maps.InfoWindow;
                        var infowindow5 = new google.maps.InfoWindow;
                        var infowindow6 = new google.maps.InfoWindow;
                        var infowindow7 = new google.maps.InfoWindow;
                        var infowindow8 = new google.maps.InfoWindow;
                        var infowindow9 = new google.maps.InfoWindow;
                        const line1 = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};
                        const line2 = {lat: parseFloat(latitude2), lng: parseFloat(longitude2)};
                        const line3 = {lat: parseFloat(latitude3), lng: parseFloat(longitude3)};
                        const line4 = {lat: parseFloat(latitude4), lng: parseFloat(longitude4)};
                        const line5 = {lat: parseFloat(latitude5), lng: parseFloat(longitude5)};
                        const line6 = {lat: parseFloat(latitude6), lng: parseFloat(longitude6)};
                        const line7 = {lat: parseFloat(latitude7), lng: parseFloat(longitude7)};
                        const line8 = {lat: parseFloat(latitude8), lng: parseFloat(longitude8)};
                        const line9 = {lat: parseFloat(latitude9), lng: parseFloat(longitude9)};
                        new google.maps.Polyline({path: [line1, line2], map: map});
                        new google.maps.Polyline({path: [line2, line3], map: map});
                        new google.maps.Polyline({path: [line3, line4], map: map});
                        new google.maps.Polyline({path: [line4, line5], map: map});
                        new google.maps.Polyline({path: [line5, line6], map: map});
                        new google.maps.Polyline({path: [line6, line7], map: map});
                        new google.maps.Polyline({path: [line7, line8], map: map});
                        new google.maps.Polyline({path: [line8, line9], map: map});

                    }
                    if (document.getElementById('txt_cnt').value == '10')
                    {

                        var latitude2 = arr_let[2];
                        var longitude2 = arr_long[2];
                        var latitude3 = arr_let[3];
                        var longitude3 = arr_long[3];
                        var latitude4 = arr_let[4];
                        var longitude4 = arr_long[4];
                        var latitude5 = arr_let[5];
                        var longitude5 = arr_long[5];
                        var latitude6 = arr_let[6];
                        var longitude6 = arr_long[6];
                        var latitude7 = arr_let[7];
                        var longitude7 = arr_long[7];
                        var latitude8 = arr_let[8];
                        var longitude8 = arr_long[8];
                        var latitude9 = arr_let[9];
                        var longitude9 = arr_long[9];
                        var latitude10 = arr_let[10];
                        var longitude10 = arr_long[10];

                        var infowindow2 = new google.maps.InfoWindow;
                        var infowindow3 = new google.maps.InfoWindow;
                        var infowindow4 = new google.maps.InfoWindow;
                        var infowindow5 = new google.maps.InfoWindow;
                        var infowindow6 = new google.maps.InfoWindow;
                        var infowindow7 = new google.maps.InfoWindow;
                        var infowindow8 = new google.maps.InfoWindow;
                        var infowindow9 = new google.maps.InfoWindow;
                        var infowindow10 = new google.maps.InfoWindow;
                        const line1 = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};
                        const line2 = {lat: parseFloat(latitude2), lng: parseFloat(longitude2)};
                        const line3 = {lat: parseFloat(latitude3), lng: parseFloat(longitude3)};
                        const line4 = {lat: parseFloat(latitude4), lng: parseFloat(longitude4)};
                        const line5 = {lat: parseFloat(latitude5), lng: parseFloat(longitude5)};
                        const line6 = {lat: parseFloat(latitude6), lng: parseFloat(longitude6)};
                        const line7 = {lat: parseFloat(latitude7), lng: parseFloat(longitude7)};
                        const line8 = {lat: parseFloat(latitude8), lng: parseFloat(longitude8)};
                        const line9 = {lat: parseFloat(latitude9), lng: parseFloat(longitude9)};
                        const line10 = {lat: parseFloat(latitude10), lng: parseFloat(longitude10)};
                        new google.maps.Polyline({path: [line1, line2], map: map});
                        new google.maps.Polyline({path: [line2, line3], map: map});
                        new google.maps.Polyline({path: [line3, line4], map: map});
                        new google.maps.Polyline({path: [line4, line5], map: map});
                        new google.maps.Polyline({path: [line5, line6], map: map});
                        new google.maps.Polyline({path: [line6, line7], map: map});
                        new google.maps.Polyline({path: [line7, line8], map: map});
                        new google.maps.Polyline({path: [line8, line9], map: map});
                        new google.maps.Polyline({path: [line9, line10], map: map});

                    }
                    if (document.getElementById('txt_cnt').value == '11')
                    {

                        var latitude2 = arr_let[2];
                        var longitude2 = arr_long[2];
                        var latitude3 = arr_let[3];
                        var longitude3 = arr_long[3];
                        var latitude4 = arr_let[4];
                        var longitude4 = arr_long[4];
                        var latitude5 = arr_let[5];
                        var longitude5 = arr_long[5];
                        var latitude6 = arr_let[6];
                        var longitude6 = arr_long[6];
                        var latitude7 = arr_let[7];
                        var longitude7 = arr_long[7];
                        var latitude8 = arr_let[8];
                        var longitude8 = arr_long[8];
                        var latitude9 = arr_let[9];
                        var longitude9 = arr_long[9];
                        var latitude10 = arr_let[10];
                        var longitude10 = arr_long[10];
                        var latitude11 = arr_let[11];
                        var longitude11 = arr_long[11];

                        var infowindow2 = new google.maps.InfoWindow;
                        var infowindow3 = new google.maps.InfoWindow;
                        var infowindow4 = new google.maps.InfoWindow;
                        var infowindow5 = new google.maps.InfoWindow;
                        var infowindow6 = new google.maps.InfoWindow;
                        var infowindow7 = new google.maps.InfoWindow;
                        var infowindow8 = new google.maps.InfoWindow;
                        var infowindow9 = new google.maps.InfoWindow;
                        var infowindow10 = new google.maps.InfoWindow;
                        var infowindow11 = new google.maps.InfoWindow;
                        const line1 = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};
                        const line2 = {lat: parseFloat(latitude2), lng: parseFloat(longitude2)};
                        const line3 = {lat: parseFloat(latitude3), lng: parseFloat(longitude3)};
                        const line4 = {lat: parseFloat(latitude4), lng: parseFloat(longitude4)};
                        const line5 = {lat: parseFloat(latitude5), lng: parseFloat(longitude5)};
                        const line6 = {lat: parseFloat(latitude6), lng: parseFloat(longitude6)};
                        const line7 = {lat: parseFloat(latitude7), lng: parseFloat(longitude7)};
                        const line8 = {lat: parseFloat(latitude8), lng: parseFloat(longitude8)};
                        const line9 = {lat: parseFloat(latitude9), lng: parseFloat(longitude9)};
                        const line10 = {lat: parseFloat(latitude10), lng: parseFloat(longitude10)};
                        const line11 = {lat: parseFloat(latitude11), lng: parseFloat(longitude11)};
                        new google.maps.Polyline({path: [line1, line2], map: map});
                        new google.maps.Polyline({path: [line2, line3], map: map});
                        new google.maps.Polyline({path: [line3, line4], map: map});
                        new google.maps.Polyline({path: [line4, line5], map: map});
                        new google.maps.Polyline({path: [line5, line6], map: map});
                        new google.maps.Polyline({path: [line6, line7], map: map});
                        new google.maps.Polyline({path: [line7, line8], map: map});
                        new google.maps.Polyline({path: [line8, line9], map: map});
                        new google.maps.Polyline({path: [line9, line10], map: map});
                        new google.maps.Polyline({path: [line10, line11], map: map});

                    }
                    if (document.getElementById('txt_cnt').value == '12')
                    {

                        var latitude2 = arr_let[2];
                        var longitude2 = arr_long[2];
                        var latitude3 = arr_let[3];
                        var longitude3 = arr_long[3];
                        var latitude4 = arr_let[4];
                        var longitude4 = arr_long[4];
                        var latitude5 = arr_let[5];
                        var longitude5 = arr_long[5];
                        var latitude6 = arr_let[6];
                        var longitude6 = arr_long[6];
                        var latitude7 = arr_let[7];
                        var longitude7 = arr_long[7];
                        var latitude8 = arr_let[8];
                        var longitude8 = arr_long[8];
                        var latitude9 = arr_let[9];
                        var longitude9 = arr_long[9];
                        var latitude10 = arr_let[10];
                        var longitude10 = arr_long[10];
                        var latitude11 = arr_let[11];
                        var longitude11 = arr_long[11];
                        var latitude12 = arr_let[12];
                        var longitude12 = arr_long[12];
                        var infowindow2 = new google.maps.InfoWindow;
                        var infowindow3 = new google.maps.InfoWindow;
                        var infowindow4 = new google.maps.InfoWindow;
                        var infowindow5 = new google.maps.InfoWindow;
                        var infowindow6 = new google.maps.InfoWindow;
                        var infowindow7 = new google.maps.InfoWindow;
                        var infowindow8 = new google.maps.InfoWindow;
                        var infowindow9 = new google.maps.InfoWindow;
                        var infowindow10 = new google.maps.InfoWindow;
                        var infowindow11 = new google.maps.InfoWindow;
                        var infowindow12 = new google.maps.InfoWindow;
                        const line1 = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};
                        const line2 = {lat: parseFloat(latitude2), lng: parseFloat(longitude2)};
                        const line3 = {lat: parseFloat(latitude3), lng: parseFloat(longitude3)};
                        const line4 = {lat: parseFloat(latitude4), lng: parseFloat(longitude4)};
                        const line5 = {lat: parseFloat(latitude5), lng: parseFloat(longitude5)};
                        const line6 = {lat: parseFloat(latitude6), lng: parseFloat(longitude6)};
                        const line7 = {lat: parseFloat(latitude7), lng: parseFloat(longitude7)};
                        const line8 = {lat: parseFloat(latitude8), lng: parseFloat(longitude8)};
                        const line9 = {lat: parseFloat(latitude9), lng: parseFloat(longitude9)};
                        const line10 = {lat: parseFloat(latitude10), lng: parseFloat(longitude10)};
                        const line11 = {lat: parseFloat(latitude11), lng: parseFloat(longitude11)};
                        const line12 = {lat: parseFloat(latitude12), lng: parseFloat(longitude12)};
                        new google.maps.Polyline({path: [line1, line2], map: map});
                        new google.maps.Polyline({path: [line2, line3], map: map});
                        new google.maps.Polyline({path: [line3, line4], map: map});
                        new google.maps.Polyline({path: [line4, line5], map: map});
                        new google.maps.Polyline({path: [line5, line6], map: map});
                        new google.maps.Polyline({path: [line6, line7], map: map});
                        new google.maps.Polyline({path: [line7, line8], map: map});
                        new google.maps.Polyline({path: [line8, line9], map: map});
                        new google.maps.Polyline({path: [line9, line10], map: map});
                        new google.maps.Polyline({path: [line10, line11], map: map});
                        new google.maps.Polyline({path: [line11, line12], map: map});

                    }
                    if (document.getElementById('txt_cnt').value == '13')
                    {

                        var latitude2 = arr_let[2];
                        var longitude2 = arr_long[2];
                        var latitude3 = arr_let[3];
                        var longitude3 = arr_long[3];
                        var latitude4 = arr_let[4];
                        var longitude4 = arr_long[4];
                        var latitude5 = arr_let[5];
                        var longitude5 = arr_long[5];
                        var latitude6 = arr_let[6];
                        var longitude6 = arr_long[6];
                        var latitude7 = arr_let[7];
                        var longitude7 = arr_long[7];
                        var latitude8 = arr_let[8];
                        var longitude8 = arr_long[8];
                        var latitude9 = arr_let[9];
                        var longitude9 = arr_long[9];
                        var latitude10 = arr_let[10];
                        var longitude10 = arr_long[10];
                        var latitude11 = arr_let[11];
                        var longitude11 = arr_long[11];
                        var latitude12 = arr_let[12];
                        var longitude12 = arr_long[12];
                        var latitude13 = arr_let[13];
                        var longitude13 = arr_long[13];

                        var infowindow2 = new google.maps.InfoWindow;
                        var infowindow3 = new google.maps.InfoWindow;
                        var infowindow4 = new google.maps.InfoWindow;
                        var infowindow5 = new google.maps.InfoWindow;
                        var infowindow6 = new google.maps.InfoWindow;
                        var infowindow7 = new google.maps.InfoWindow;
                        var infowindow8 = new google.maps.InfoWindow;
                        var infowindow9 = new google.maps.InfoWindow;
                        var infowindow10 = new google.maps.InfoWindow;
                        var infowindow11 = new google.maps.InfoWindow;
                        var infowindow12 = new google.maps.InfoWindow;
                        var infowindow13 = new google.maps.InfoWindow;
                        const line1 = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};
                        const line2 = {lat: parseFloat(latitude2), lng: parseFloat(longitude2)};
                        const line3 = {lat: parseFloat(latitude3), lng: parseFloat(longitude3)};
                        const line4 = {lat: parseFloat(latitude4), lng: parseFloat(longitude4)};
                        const line5 = {lat: parseFloat(latitude5), lng: parseFloat(longitude5)};
                        const line6 = {lat: parseFloat(latitude6), lng: parseFloat(longitude6)};
                        const line7 = {lat: parseFloat(latitude7), lng: parseFloat(longitude7)};
                        const line8 = {lat: parseFloat(latitude8), lng: parseFloat(longitude8)};
                        const line9 = {lat: parseFloat(latitude9), lng: parseFloat(longitude9)};
                        const line10 = {lat: parseFloat(latitude10), lng: parseFloat(longitude10)};
                        const line11 = {lat: parseFloat(latitude11), lng: parseFloat(longitude11)};
                        const line12 = {lat: parseFloat(latitude12), lng: parseFloat(longitude12)};
                        const line13 = {lat: parseFloat(latitude13), lng: parseFloat(longitude13)};
                        new google.maps.Polyline({path: [line1, line2], map: map});
                        new google.maps.Polyline({path: [line2, line3], map: map});
                        new google.maps.Polyline({path: [line3, line4], map: map});
                        new google.maps.Polyline({path: [line4, line5], map: map});
                        new google.maps.Polyline({path: [line5, line6], map: map});
                        new google.maps.Polyline({path: [line6, line7], map: map});
                        new google.maps.Polyline({path: [line7, line8], map: map});
                        new google.maps.Polyline({path: [line8, line9], map: map});
                        new google.maps.Polyline({path: [line9, line10], map: map});
                        new google.maps.Polyline({path: [line10, line11], map: map});
                        new google.maps.Polyline({path: [line11, line12], map: map});
                        new google.maps.Polyline({path: [line12, line13], map: map});

                    }
                    if (document.getElementById('txt_cnt').value == '14')
                    {

                        var latitude2 = arr_let[2];
                        var longitude2 = arr_long[2];
                        var latitude3 = arr_let[3];
                        var longitude3 = arr_long[3];
                        var latitude4 = arr_let[4];
                        var longitude4 = arr_long[4];
                        var latitude5 = arr_let[5];
                        var longitude5 = arr_long[5];
                        var latitude6 = arr_let[6];
                        var longitude6 = arr_long[6];
                        var latitude7 = arr_let[7];
                        var longitude7 = arr_long[7];
                        var latitude8 = arr_let[8];
                        var longitude8 = arr_long[8];
                        var latitude9 = arr_let[9];
                        var longitude9 = arr_long[9];
                        var latitude10 = arr_let[10];
                        var longitude10 = arr_long[10];
                        var latitude11 = arr_let[11];
                        var longitude11 = arr_long[11];
                        var latitude12 = arr_let[12];
                        var longitude12 = arr_long[12];
                        var latitude13 = arr_let[13];
                        var longitude13 = arr_long[13];
                        var latitude14 = arr_let[14];
                        var longitude14 = arr_long[14];

                        var infowindow2 = new google.maps.InfoWindow;
                        var infowindow3 = new google.maps.InfoWindow;
                        var infowindow4 = new google.maps.InfoWindow;
                        var infowindow5 = new google.maps.InfoWindow;
                        var infowindow6 = new google.maps.InfoWindow;
                        var infowindow7 = new google.maps.InfoWindow;
                        var infowindow8 = new google.maps.InfoWindow;
                        var infowindow9 = new google.maps.InfoWindow;
                        var infowindow10 = new google.maps.InfoWindow;
                        var infowindow11 = new google.maps.InfoWindow;
                        var infowindow12 = new google.maps.InfoWindow;
                        var infowindow13 = new google.maps.InfoWindow;
                        var infowindow14 = new google.maps.InfoWindow;
                        const line1 = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};
                        const line2 = {lat: parseFloat(latitude2), lng: parseFloat(longitude2)};
                        const line3 = {lat: parseFloat(latitude3), lng: parseFloat(longitude3)};
                        const line4 = {lat: parseFloat(latitude4), lng: parseFloat(longitude4)};
                        const line5 = {lat: parseFloat(latitude5), lng: parseFloat(longitude5)};
                        const line6 = {lat: parseFloat(latitude6), lng: parseFloat(longitude6)};
                        const line7 = {lat: parseFloat(latitude7), lng: parseFloat(longitude7)};
                        const line8 = {lat: parseFloat(latitude8), lng: parseFloat(longitude8)};
                        const line9 = {lat: parseFloat(latitude9), lng: parseFloat(longitude9)};
                        const line10 = {lat: parseFloat(latitude10), lng: parseFloat(longitude10)};
                        const line11 = {lat: parseFloat(latitude11), lng: parseFloat(longitude11)};
                        const line12 = {lat: parseFloat(latitude12), lng: parseFloat(longitude12)};
                        const line13 = {lat: parseFloat(latitude13), lng: parseFloat(longitude13)};
                        const line14 = {lat: parseFloat(latitude14), lng: parseFloat(longitude14)};
                        new google.maps.Polyline({path: [line1, line2], map: map});
                        new google.maps.Polyline({path: [line2, line3], map: map});
                        new google.maps.Polyline({path: [line3, line4], map: map});
                        new google.maps.Polyline({path: [line4, line5], map: map});
                        new google.maps.Polyline({path: [line5, line6], map: map});
                        new google.maps.Polyline({path: [line6, line7], map: map});
                        new google.maps.Polyline({path: [line7, line8], map: map});
                        new google.maps.Polyline({path: [line8, line9], map: map});
                        new google.maps.Polyline({path: [line9, line10], map: map});
                        new google.maps.Polyline({path: [line10, line11], map: map});
                        new google.maps.Polyline({path: [line11, line12], map: map});
                        new google.maps.Polyline({path: [line12, line13], map: map});
                        new google.maps.Polyline({path: [line13, line14], map: map});

                    }
                    if (document.getElementById('txt_cnt').value == '15')
                    {

                        var latitude2 = arr_let[2];
                        var longitude2 = arr_long[2];
                        var latitude3 = arr_let[3];
                        var longitude3 = arr_long[3];
                        var latitude4 = arr_let[4];
                        var longitude4 = arr_long[4];
                        var latitude5 = arr_let[5];
                        var longitude5 = arr_long[5];
                        var latitude6 = arr_let[6];
                        var longitude6 = arr_long[6];
                        var latitude7 = arr_let[7];
                        var longitude7 = arr_long[7];
                        var latitude8 = arr_let[8];
                        var longitude8 = arr_long[8];
                        var latitude9 = arr_let[9];
                        var longitude9 = arr_long[9];
                        var latitude10 = arr_let[10];
                        var longitude10 = arr_long[10];
                        var latitude11 = arr_let[11];
                        var longitude11 = arr_long[11];
                        var latitude12 = arr_let[12];
                        var longitude12 = arr_long[12];
                        var latitude13 = arr_let[13];
                        var longitude13 = arr_long[13];
                        var latitude14 = arr_let[14];
                        var longitude14 = arr_long[14];
                        var latitude15 = arr_let[15];
                        var longitude15 = arr_long[15];

                        var infowindow2 = new google.maps.InfoWindow;
                        var infowindow3 = new google.maps.InfoWindow;
                        var infowindow4 = new google.maps.InfoWindow;
                        var infowindow5 = new google.maps.InfoWindow;
                        var infowindow6 = new google.maps.InfoWindow;
                        var infowindow7 = new google.maps.InfoWindow;
                        var infowindow8 = new google.maps.InfoWindow;
                        var infowindow9 = new google.maps.InfoWindow;
                        var infowindow10 = new google.maps.InfoWindow;
                        var infowindow11 = new google.maps.InfoWindow;
                        var infowindow12 = new google.maps.InfoWindow;
                        var infowindow13 = new google.maps.InfoWindow;
                        var infowindow14 = new google.maps.InfoWindow;
                        var infowindow15 = new google.maps.InfoWindow;
                        const line1 = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};
                        const line2 = {lat: parseFloat(latitude2), lng: parseFloat(longitude2)};
                        const line3 = {lat: parseFloat(latitude3), lng: parseFloat(longitude3)};
                        const line4 = {lat: parseFloat(latitude4), lng: parseFloat(longitude4)};
                        const line5 = {lat: parseFloat(latitude5), lng: parseFloat(longitude5)};
                        const line6 = {lat: parseFloat(latitude6), lng: parseFloat(longitude6)};
                        const line7 = {lat: parseFloat(latitude7), lng: parseFloat(longitude7)};
                        const line8 = {lat: parseFloat(latitude8), lng: parseFloat(longitude8)};
                        const line9 = {lat: parseFloat(latitude9), lng: parseFloat(longitude9)};
                        const line10 = {lat: parseFloat(latitude10), lng: parseFloat(longitude10)};
                        const line11 = {lat: parseFloat(latitude11), lng: parseFloat(longitude11)};
                        const line12 = {lat: parseFloat(latitude12), lng: parseFloat(longitude12)};
                        const line13 = {lat: parseFloat(latitude13), lng: parseFloat(longitude13)};
                        const line14 = {lat: parseFloat(latitude14), lng: parseFloat(longitude14)};
                        const line15 = {lat: parseFloat(latitude15), lng: parseFloat(longitude15)};
                        new google.maps.Polyline({path: [line1, line2], map: map});
                        new google.maps.Polyline({path: [line2, line3], map: map});
                        new google.maps.Polyline({path: [line3, line4], map: map});
                        new google.maps.Polyline({path: [line4, line5], map: map});
                        new google.maps.Polyline({path: [line5, line6], map: map});
                        new google.maps.Polyline({path: [line6, line7], map: map});
                        new google.maps.Polyline({path: [line7, line8], map: map});
                        new google.maps.Polyline({path: [line8, line9], map: map});
                        new google.maps.Polyline({path: [line9, line10], map: map});
                        new google.maps.Polyline({path: [line10, line11], map: map});
                        new google.maps.Polyline({path: [line11, line12], map: map});
                        new google.maps.Polyline({path: [line12, line13], map: map});
                        new google.maps.Polyline({path: [line13, line14], map: map});
                        new google.maps.Polyline({path: [line14, line15], map: map});

                    }
                    if (document.getElementById('txt_cnt').value == '16')
                    {

                        var latitude2 = arr_let[2];
                        var longitude2 = arr_long[2];
                        var latitude3 = arr_let[3];
                        var longitude3 = arr_long[3];
                        var latitude4 = arr_let[4];
                        var longitude4 = arr_long[4];
                        var latitude5 = arr_let[5];
                        var longitude5 = arr_long[5];
                        var latitude6 = arr_let[6];
                        var longitude6 = arr_long[6];
                        var latitude7 = arr_let[7];
                        var longitude7 = arr_long[7];
                        var latitude8 = arr_let[8];
                        var longitude8 = arr_long[8];
                        var latitude9 = arr_let[9];
                        var longitude9 = arr_long[9];
                        var latitude10 = arr_let[10];
                        var longitude10 = arr_long[10];
                        var latitude11 = arr_let[11];
                        var longitude11 = arr_long[11];
                        var latitude12 = arr_let[12];
                        var longitude12 = arr_long[12];
                        var latitude13 = arr_let[13];
                        var longitude13 = arr_long[13];
                        var latitude14 = arr_let[14];
                        var longitude14 = arr_long[14];
                        var latitude15 = arr_let[15];
                        var longitude15 = arr_long[15];
                        var latitude16 = arr_let[16];
                        var longitude16 = arr_long[16];

                        var infowindow2 = new google.maps.InfoWindow;
                        var infowindow3 = new google.maps.InfoWindow;
                        var infowindow4 = new google.maps.InfoWindow;
                        var infowindow5 = new google.maps.InfoWindow;
                        var infowindow6 = new google.maps.InfoWindow;
                        var infowindow7 = new google.maps.InfoWindow;
                        var infowindow8 = new google.maps.InfoWindow;
                        var infowindow9 = new google.maps.InfoWindow;
                        var infowindow10 = new google.maps.InfoWindow;
                        var infowindow11 = new google.maps.InfoWindow;
                        var infowindow12 = new google.maps.InfoWindow;
                        var infowindow13 = new google.maps.InfoWindow;
                        var infowindow14 = new google.maps.InfoWindow;
                        var infowindow15 = new google.maps.InfoWindow;
                        var infowindow16 = new google.maps.InfoWindow;
                        const line1 = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};
                        const line2 = {lat: parseFloat(latitude2), lng: parseFloat(longitude2)};
                        const line3 = {lat: parseFloat(latitude3), lng: parseFloat(longitude3)};
                        const line4 = {lat: parseFloat(latitude4), lng: parseFloat(longitude4)};
                        const line5 = {lat: parseFloat(latitude5), lng: parseFloat(longitude5)};
                        const line6 = {lat: parseFloat(latitude6), lng: parseFloat(longitude6)};
                        const line7 = {lat: parseFloat(latitude7), lng: parseFloat(longitude7)};
                        const line8 = {lat: parseFloat(latitude8), lng: parseFloat(longitude8)};
                        const line9 = {lat: parseFloat(latitude9), lng: parseFloat(longitude9)};
                        const line10 = {lat: parseFloat(latitude10), lng: parseFloat(longitude10)};
                        const line11 = {lat: parseFloat(latitude11), lng: parseFloat(longitude11)};
                        const line12 = {lat: parseFloat(latitude12), lng: parseFloat(longitude12)};
                        const line13 = {lat: parseFloat(latitude13), lng: parseFloat(longitude13)};
                        const line14 = {lat: parseFloat(latitude14), lng: parseFloat(longitude14)};
                        const line15 = {lat: parseFloat(latitude15), lng: parseFloat(longitude15)};
                        const line16 = {lat: parseFloat(latitude16), lng: parseFloat(longitude16)};
                        new google.maps.Polyline({path: [line1, line2], map: map});
                        new google.maps.Polyline({path: [line2, line3], map: map});
                        new google.maps.Polyline({path: [line3, line4], map: map});
                        new google.maps.Polyline({path: [line4, line5], map: map});
                        new google.maps.Polyline({path: [line5, line6], map: map});
                        new google.maps.Polyline({path: [line6, line7], map: map});
                        new google.maps.Polyline({path: [line7, line8], map: map});
                        new google.maps.Polyline({path: [line8, line9], map: map});
                        new google.maps.Polyline({path: [line9, line10], map: map});
                        new google.maps.Polyline({path: [line10, line11], map: map});
                        new google.maps.Polyline({path: [line11, line12], map: map});
                        new google.maps.Polyline({path: [line12, line13], map: map});
                        new google.maps.Polyline({path: [line13, line14], map: map});
                        new google.maps.Polyline({path: [line14, line15], map: map});
                        new google.maps.Polyline({path: [line15, line16], map: map});

                    }
                    if (document.getElementById('txt_cnt').value == '17')
                    {

                        var latitude2 = arr_let[2];
                        var longitude2 = arr_long[2];
                        var latitude3 = arr_let[3];
                        var longitude3 = arr_long[3];
                        var latitude4 = arr_let[4];
                        var longitude4 = arr_long[4];
                        var latitude5 = arr_let[5];
                        var longitude5 = arr_long[5];
                        var latitude6 = arr_let[6];
                        var longitude6 = arr_long[6];
                        var latitude7 = arr_let[7];
                        var longitude7 = arr_long[7];
                        var latitude8 = arr_let[8];
                        var longitude8 = arr_long[8];
                        var latitude9 = arr_let[9];
                        var longitude9 = arr_long[9];
                        var latitude10 = arr_let[10];
                        var longitude10 = arr_long[10];
                        var latitude11 = arr_let[11];
                        var longitude11 = arr_long[11];
                        var latitude12 = arr_let[12];
                        var longitude12 = arr_long[12];
                        var latitude13 = arr_let[13];
                        var longitude13 = arr_long[13];
                        var latitude14 = arr_let[14];
                        var longitude14 = arr_long[14];
                        var latitude15 = arr_let[15];
                        var longitude15 = arr_long[15];
                        var latitude16 = arr_let[16];
                        var longitude16 = arr_long[16];
                        var latitude17 = arr_let[17];
                        var longitude17 = arr_long[17];

                        var infowindow2 = new google.maps.InfoWindow;
                        var infowindow3 = new google.maps.InfoWindow;
                        var infowindow4 = new google.maps.InfoWindow;
                        var infowindow5 = new google.maps.InfoWindow;
                        var infowindow6 = new google.maps.InfoWindow;
                        var infowindow7 = new google.maps.InfoWindow;
                        var infowindow8 = new google.maps.InfoWindow;
                        var infowindow9 = new google.maps.InfoWindow;
                        var infowindow10 = new google.maps.InfoWindow;
                        var infowindow11 = new google.maps.InfoWindow;
                        var infowindow12 = new google.maps.InfoWindow;
                        var infowindow13 = new google.maps.InfoWindow;
                        var infowindow14 = new google.maps.InfoWindow;
                        var infowindow15 = new google.maps.InfoWindow;
                        var infowindow16 = new google.maps.InfoWindow;
                        var infowindow17 = new google.maps.InfoWindow;
                        const line1 = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};
                        const line2 = {lat: parseFloat(latitude2), lng: parseFloat(longitude2)};
                        const line3 = {lat: parseFloat(latitude3), lng: parseFloat(longitude3)};
                        const line4 = {lat: parseFloat(latitude4), lng: parseFloat(longitude4)};
                        const line5 = {lat: parseFloat(latitude5), lng: parseFloat(longitude5)};
                        const line6 = {lat: parseFloat(latitude6), lng: parseFloat(longitude6)};
                        const line7 = {lat: parseFloat(latitude7), lng: parseFloat(longitude7)};
                        const line8 = {lat: parseFloat(latitude8), lng: parseFloat(longitude8)};
                        const line9 = {lat: parseFloat(latitude9), lng: parseFloat(longitude9)};
                        const line10 = {lat: parseFloat(latitude10), lng: parseFloat(longitude10)};
                        const line11 = {lat: parseFloat(latitude11), lng: parseFloat(longitude11)};
                        const line12 = {lat: parseFloat(latitude12), lng: parseFloat(longitude12)};
                        const line13 = {lat: parseFloat(latitude13), lng: parseFloat(longitude13)};
                        const line14 = {lat: parseFloat(latitude14), lng: parseFloat(longitude14)};
                        const line15 = {lat: parseFloat(latitude15), lng: parseFloat(longitude15)};
                        const line16 = {lat: parseFloat(latitude16), lng: parseFloat(longitude16)};
                        const line17 = {lat: parseFloat(latitude17), lng: parseFloat(longitude17)};
                        new google.maps.Polyline({path: [line1, line2], map: map});
                        new google.maps.Polyline({path: [line2, line3], map: map});
                        new google.maps.Polyline({path: [line3, line4], map: map});
                        new google.maps.Polyline({path: [line4, line5], map: map});
                        new google.maps.Polyline({path: [line5, line6], map: map});
                        new google.maps.Polyline({path: [line6, line7], map: map});
                        new google.maps.Polyline({path: [line7, line8], map: map});
                        new google.maps.Polyline({path: [line8, line9], map: map});
                        new google.maps.Polyline({path: [line9, line10], map: map});
                        new google.maps.Polyline({path: [line10, line11], map: map});
                        new google.maps.Polyline({path: [line11, line12], map: map});
                        new google.maps.Polyline({path: [line12, line13], map: map});
                        new google.maps.Polyline({path: [line13, line14], map: map});
                        new google.maps.Polyline({path: [line14, line15], map: map});
                        new google.maps.Polyline({path: [line15, line16], map: map});
                        new google.maps.Polyline({path: [line16, line17], map: map});

                    }
                    if (document.getElementById('txt_cnt').value == '18')
                    {

                        var latitude2 = arr_let[2];
                        var longitude2 = arr_long[2];
                        var latitude3 = arr_let[3];
                        var longitude3 = arr_long[3];
                        var latitude4 = arr_let[4];
                        var longitude4 = arr_long[4];
                        var latitude5 = arr_let[5];
                        var longitude5 = arr_long[5];
                        var latitude6 = arr_let[6];
                        var longitude6 = arr_long[6];
                        var latitude7 = arr_let[7];
                        var longitude7 = arr_long[7];
                        var latitude8 = arr_let[8];
                        var longitude8 = arr_long[8];
                        var latitude9 = arr_let[9];
                        var longitude9 = arr_long[9];
                        var latitude10 = arr_let[10];
                        var longitude10 = arr_long[10];
                        var latitude11 = arr_let[11];
                        var longitude11 = arr_long[11];
                        var latitude12 = arr_let[12];
                        var longitude12 = arr_long[12];
                        var latitude13 = arr_let[13];
                        var longitude13 = arr_long[13];
                        var latitude14 = arr_let[14];
                        var longitude14 = arr_long[14];
                        var latitude15 = arr_let[15];
                        var longitude15 = arr_long[15];
                        var latitude16 = arr_let[16];
                        var longitude16 = arr_long[16];
                        var latitude17 = arr_let[17];
                        var longitude17 = arr_long[17];
                        var latitude18 = arr_let[18];
                        var longitude18 = arr_long[18];

                        var infowindow2 = new google.maps.InfoWindow;
                        var infowindow3 = new google.maps.InfoWindow;
                        var infowindow4 = new google.maps.InfoWindow;
                        var infowindow5 = new google.maps.InfoWindow;
                        var infowindow6 = new google.maps.InfoWindow;
                        var infowindow7 = new google.maps.InfoWindow;
                        var infowindow8 = new google.maps.InfoWindow;
                        var infowindow9 = new google.maps.InfoWindow;
                        var infowindow10 = new google.maps.InfoWindow;
                        var infowindow11 = new google.maps.InfoWindow;
                        var infowindow12 = new google.maps.InfoWindow;
                        var infowindow13 = new google.maps.InfoWindow;
                        var infowindow14 = new google.maps.InfoWindow;
                        var infowindow15 = new google.maps.InfoWindow;
                        var infowindow16 = new google.maps.InfoWindow;
                        var infowindow17 = new google.maps.InfoWindow;
                        var infowindow18 = new google.maps.InfoWindow;
                        const line1 = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};
                        const line2 = {lat: parseFloat(latitude2), lng: parseFloat(longitude2)};
                        const line3 = {lat: parseFloat(latitude3), lng: parseFloat(longitude3)};
                        const line4 = {lat: parseFloat(latitude4), lng: parseFloat(longitude4)};
                        const line5 = {lat: parseFloat(latitude5), lng: parseFloat(longitude5)};
                        const line6 = {lat: parseFloat(latitude6), lng: parseFloat(longitude6)};
                        const line7 = {lat: parseFloat(latitude7), lng: parseFloat(longitude7)};
                        const line8 = {lat: parseFloat(latitude8), lng: parseFloat(longitude8)};
                        const line9 = {lat: parseFloat(latitude9), lng: parseFloat(longitude9)};
                        const line10 = {lat: parseFloat(latitude10), lng: parseFloat(longitude10)};
                        const line11 = {lat: parseFloat(latitude11), lng: parseFloat(longitude11)};
                        const line12 = {lat: parseFloat(latitude12), lng: parseFloat(longitude12)};
                        const line13 = {lat: parseFloat(latitude13), lng: parseFloat(longitude13)};
                        const line14 = {lat: parseFloat(latitude14), lng: parseFloat(longitude14)};
                        const line15 = {lat: parseFloat(latitude15), lng: parseFloat(longitude15)};
                        const line16 = {lat: parseFloat(latitude16), lng: parseFloat(longitude16)};
                        const line17 = {lat: parseFloat(latitude17), lng: parseFloat(longitude17)};
                        const line18 = {lat: parseFloat(latitude18), lng: parseFloat(longitude18)};
                        new google.maps.Polyline({path: [line1, line2], map: map});
                        new google.maps.Polyline({path: [line2, line3], map: map});
                        new google.maps.Polyline({path: [line3, line4], map: map});
                        new google.maps.Polyline({path: [line4, line5], map: map});
                        new google.maps.Polyline({path: [line5, line6], map: map});
                        new google.maps.Polyline({path: [line6, line7], map: map});
                        new google.maps.Polyline({path: [line7, line8], map: map});
                        new google.maps.Polyline({path: [line8, line9], map: map});
                        new google.maps.Polyline({path: [line9, line10], map: map});
                        new google.maps.Polyline({path: [line10, line11], map: map});
                        new google.maps.Polyline({path: [line11, line12], map: map});
                        new google.maps.Polyline({path: [line12, line13], map: map});
                        new google.maps.Polyline({path: [line13, line14], map: map});
                        new google.maps.Polyline({path: [line14, line15], map: map});
                        new google.maps.Polyline({path: [line15, line16], map: map});
                        new google.maps.Polyline({path: [line16, line17], map: map});
                        new google.maps.Polyline({path: [line17, line18], map: map});

                    }
                    if (document.getElementById('txt_cnt').value == '19')
                    {

                        var latitude2 = arr_let[2];
                        var longitude2 = arr_long[2];
                        var latitude3 = arr_let[3];
                        var longitude3 = arr_long[3];
                        var latitude4 = arr_let[4];
                        var longitude4 = arr_long[4];
                        var latitude5 = arr_let[5];
                        var longitude5 = arr_long[5];
                        var latitude6 = arr_let[6];
                        var longitude6 = arr_long[6];
                        var latitude7 = arr_let[7];
                        var longitude7 = arr_long[7];
                        var latitude8 = arr_let[8];
                        var longitude8 = arr_long[8];
                        var latitude9 = arr_let[9];
                        var longitude9 = arr_long[9];
                        var latitude10 = arr_let[10];
                        var longitude10 = arr_long[10];
                        var latitude11 = arr_let[11];
                        var longitude11 = arr_long[11];
                        var latitude12 = arr_let[12];
                        var longitude12 = arr_long[12];
                        var latitude13 = arr_let[13];
                        var longitude13 = arr_long[13];
                        var latitude14 = arr_let[14];
                        var longitude14 = arr_long[14];
                        var latitude15 = arr_let[15];
                        var longitude15 = arr_long[15];
                        var latitude16 = arr_let[16];
                        var longitude16 = arr_long[16];
                        var latitude17 = arr_let[17];
                        var longitude17 = arr_long[17];
                        var latitude18 = arr_let[18];
                        var longitude18 = arr_long[18];
                        var latitude19 = arr_let[19];
                        var longitude19 = arr_long[19];

                        var infowindow2 = new google.maps.InfoWindow;
                        var infowindow3 = new google.maps.InfoWindow;
                        var infowindow4 = new google.maps.InfoWindow;
                        var infowindow5 = new google.maps.InfoWindow;
                        var infowindow6 = new google.maps.InfoWindow;
                        var infowindow7 = new google.maps.InfoWindow;
                        var infowindow8 = new google.maps.InfoWindow;
                        var infowindow9 = new google.maps.InfoWindow;
                        var infowindow10 = new google.maps.InfoWindow;
                        var infowindow11 = new google.maps.InfoWindow;
                        var infowindow12 = new google.maps.InfoWindow;
                        var infowindow13 = new google.maps.InfoWindow;
                        var infowindow14 = new google.maps.InfoWindow;
                        var infowindow15 = new google.maps.InfoWindow;
                        var infowindow16 = new google.maps.InfoWindow;
                        var infowindow17 = new google.maps.InfoWindow;
                        var infowindow18 = new google.maps.InfoWindow;
                        var infowindow19 = new google.maps.InfoWindow;
                        const line1 = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};
                        const line2 = {lat: parseFloat(latitude2), lng: parseFloat(longitude2)};
                        const line3 = {lat: parseFloat(latitude3), lng: parseFloat(longitude3)};
                        const line4 = {lat: parseFloat(latitude4), lng: parseFloat(longitude4)};
                        const line5 = {lat: parseFloat(latitude5), lng: parseFloat(longitude5)};
                        const line6 = {lat: parseFloat(latitude6), lng: parseFloat(longitude6)};
                        const line7 = {lat: parseFloat(latitude7), lng: parseFloat(longitude7)};
                        const line8 = {lat: parseFloat(latitude8), lng: parseFloat(longitude8)};
                        const line9 = {lat: parseFloat(latitude9), lng: parseFloat(longitude9)};
                        const line10 = {lat: parseFloat(latitude10), lng: parseFloat(longitude10)};
                        const line11 = {lat: parseFloat(latitude11), lng: parseFloat(longitude11)};
                        const line12 = {lat: parseFloat(latitude12), lng: parseFloat(longitude12)};
                        const line13 = {lat: parseFloat(latitude13), lng: parseFloat(longitude13)};
                        const line14 = {lat: parseFloat(latitude14), lng: parseFloat(longitude14)};
                        const line15 = {lat: parseFloat(latitude15), lng: parseFloat(longitude15)};
                        const line16 = {lat: parseFloat(latitude16), lng: parseFloat(longitude16)};
                        const line17 = {lat: parseFloat(latitude17), lng: parseFloat(longitude17)};
                        const line18 = {lat: parseFloat(latitude18), lng: parseFloat(longitude18)};
                        const line19 = {lat: parseFloat(latitude19), lng: parseFloat(longitude19)};
                        new google.maps.Polyline({path: [line1, line2], map: map});
                        new google.maps.Polyline({path: [line2, line3], map: map});
                        new google.maps.Polyline({path: [line3, line4], map: map});
                        new google.maps.Polyline({path: [line4, line5], map: map});
                        new google.maps.Polyline({path: [line5, line6], map: map});
                        new google.maps.Polyline({path: [line6, line7], map: map});
                        new google.maps.Polyline({path: [line7, line8], map: map});
                        new google.maps.Polyline({path: [line8, line9], map: map});
                        new google.maps.Polyline({path: [line9, line10], map: map});
                        new google.maps.Polyline({path: [line10, line11], map: map});
                        new google.maps.Polyline({path: [line11, line12], map: map});
                        new google.maps.Polyline({path: [line12, line13], map: map});
                        new google.maps.Polyline({path: [line13, line14], map: map});
                        new google.maps.Polyline({path: [line14, line15], map: map});
                        new google.maps.Polyline({path: [line15, line16], map: map});
                        new google.maps.Polyline({path: [line16, line17], map: map});
                        new google.maps.Polyline({path: [line17, line18], map: map});
                        new google.maps.Polyline({path: [line18, line19], map: map});

                    }
                    if (document.getElementById('txt_cnt').value == '20')
                    {

                        var latitude2 = arr_let[2];
                        var longitude2 = arr_long[2];
                        var latitude3 = arr_let[3];
                        var longitude3 = arr_long[3];
                        var latitude4 = arr_let[4];
                        var longitude4 = arr_long[4];
                        var latitude5 = arr_let[5];
                        var longitude5 = arr_long[5];
                        var latitude6 = arr_let[6];
                        var longitude6 = arr_long[6];
                        var latitude7 = arr_let[7];
                        var longitude7 = arr_long[7];
                        var latitude8 = arr_let[8];
                        var longitude8 = arr_long[8];
                        var latitude9 = arr_let[9];
                        var longitude9 = arr_long[9];
                        var latitude10 = arr_let[10];
                        var longitude10 = arr_long[10];
                        var latitude11 = arr_let[11];
                        var longitude11 = arr_long[11];
                        var latitude12 = arr_let[12];
                        var longitude12 = arr_long[12];
                        var latitude13 = arr_let[13];
                        var longitude13 = arr_long[13];
                        var latitude14 = arr_let[14];
                        var longitude14 = arr_long[14];
                        var latitude15 = arr_let[15];
                        var longitude15 = arr_long[15];
                        var latitude16 = arr_let[16];
                        var longitude16 = arr_long[16];
                        var latitude17 = arr_let[17];
                        var longitude17 = arr_long[17];
                        var latitude18 = arr_let[18];
                        var longitude18 = arr_long[18];
                        var latitude19 = arr_let[19];
                        var longitude19 = arr_long[19];
                        var latitude20 = arr_let[20];
                        var longitude20 = arr_long[20];

                        var infowindow2 = new google.maps.InfoWindow;
                        var infowindow3 = new google.maps.InfoWindow;
                        var infowindow4 = new google.maps.InfoWindow;
                        var infowindow5 = new google.maps.InfoWindow;
                        var infowindow6 = new google.maps.InfoWindow;
                        var infowindow7 = new google.maps.InfoWindow;
                        var infowindow8 = new google.maps.InfoWindow;
                        var infowindow9 = new google.maps.InfoWindow;
                        var infowindow10 = new google.maps.InfoWindow;
                        var infowindow11 = new google.maps.InfoWindow;
                        var infowindow12 = new google.maps.InfoWindow;
                        var infowindow13 = new google.maps.InfoWindow;
                        var infowindow14 = new google.maps.InfoWindow;
                        var infowindow15 = new google.maps.InfoWindow;
                        var infowindow16 = new google.maps.InfoWindow;
                        var infowindow17 = new google.maps.InfoWindow;
                        var infowindow18 = new google.maps.InfoWindow;
                        var infowindow19 = new google.maps.InfoWindow;
                        var infowindow20 = new google.maps.InfoWindow;
                        const line1 = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};
                        const line2 = {lat: parseFloat(latitude2), lng: parseFloat(longitude2)};
                        const line3 = {lat: parseFloat(latitude3), lng: parseFloat(longitude3)};
                        const line4 = {lat: parseFloat(latitude4), lng: parseFloat(longitude4)};
                        const line5 = {lat: parseFloat(latitude5), lng: parseFloat(longitude5)};
                        const line6 = {lat: parseFloat(latitude6), lng: parseFloat(longitude6)};
                        const line7 = {lat: parseFloat(latitude7), lng: parseFloat(longitude7)};
                        const line8 = {lat: parseFloat(latitude8), lng: parseFloat(longitude8)};
                        const line9 = {lat: parseFloat(latitude9), lng: parseFloat(longitude9)};
                        const line10 = {lat: parseFloat(latitude10), lng: parseFloat(longitude10)};
                        const line11 = {lat: parseFloat(latitude11), lng: parseFloat(longitude11)};
                        const line12 = {lat: parseFloat(latitude12), lng: parseFloat(longitude12)};
                        const line13 = {lat: parseFloat(latitude13), lng: parseFloat(longitude13)};
                        const line14 = {lat: parseFloat(latitude14), lng: parseFloat(longitude14)};
                        const line15 = {lat: parseFloat(latitude15), lng: parseFloat(longitude15)};
                        const line16 = {lat: parseFloat(latitude16), lng: parseFloat(longitude16)};
                        const line17 = {lat: parseFloat(latitude17), lng: parseFloat(longitude17)};
                        const line18 = {lat: parseFloat(latitude18), lng: parseFloat(longitude18)};
                        const line19 = {lat: parseFloat(latitude19), lng: parseFloat(longitude19)};
                        const line20 = {lat: parseFloat(latitude20), lng: parseFloat(longitude20)};
                        new google.maps.Polyline({path: [line1, line2], map: map});
                        new google.maps.Polyline({path: [line2, line3], map: map});
                        new google.maps.Polyline({path: [line3, line4], map: map});
                        new google.maps.Polyline({path: [line4, line5], map: map});
                        new google.maps.Polyline({path: [line5, line6], map: map});
                        new google.maps.Polyline({path: [line6, line7], map: map});
                        new google.maps.Polyline({path: [line7, line8], map: map});
                        new google.maps.Polyline({path: [line8, line9], map: map});
                        new google.maps.Polyline({path: [line9, line10], map: map});
                        new google.maps.Polyline({path: [line10, line11], map: map});
                        new google.maps.Polyline({path: [line11, line12], map: map});
                        new google.maps.Polyline({path: [line12, line13], map: map});
                        new google.maps.Polyline({path: [line13, line14], map: map});
                        new google.maps.Polyline({path: [line14, line15], map: map});
                        new google.maps.Polyline({path: [line15, line16], map: map});
                        new google.maps.Polyline({path: [line16, line17], map: map});
                        new google.maps.Polyline({path: [line17, line18], map: map});
                        new google.maps.Polyline({path: [line18, line19], map: map});
                        new google.maps.Polyline({path: [line19, line20], map: map});

                    }


                    var latlng = {lat: parseFloat(latitude1), lng: parseFloat(longitude1)};
                    geocoder.geocode({'location': latlng}, function (results, status) {
                        if (status === 'OK') {
                            if (results[0]) {
                                map.setZoom(15);



                                if (document.getElementById('txt_cnt').value == '1')
                                {
                                    var marker1 = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });

                                    infowindow.setContent('<u><b>จุด 1 </b></u>  <b><font style="color: red">(' + arr_datetime[1] + ')</font></b> : ' + arr_address[1]);
                                    infowindow.open(map, marker1);
                                }
                                if (document.getElementById('txt_cnt').value == '2')
                                {
                                    var marker1 = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });

                                    var marker2 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude2), parseFloat(longitude2)),
                                        map: map
                                    });

                                    infowindow.setContent('<u><b>จุด 1 </b></u>  <b><font style="color: red">(' + arr_datetime[1] + ')</font></b> : ' + arr_address[1]);
                                    infowindow2.setContent('<u><b>จุด 2 </b></u>  <b><font style="color: red">(' + arr_datetime[2] + ')</font></b> : ' + arr_address[2]);
                                    infowindow.open(map, marker1);
                                    infowindow2.open(map, marker2);
                                }
                                if (document.getElementById('txt_cnt').value == '3')
                                {
                                    var marker1 = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });

                                    var marker2 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude2), parseFloat(longitude2)),
                                        map: map
                                    });

                                    var marker3 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude3), parseFloat(longitude3)),
                                        map: map
                                    });

                                    infowindow.setContent('<u><b>จุด 1 </b></u>  <b><font style="color: red">(' + arr_datetime[1] + ')</font></b> : ' + arr_address[1]);
                                    infowindow2.setContent('<u><b>จุด 2 </b></u>  <b><font style="color: red">(' + arr_datetime[2] + ')</font></b> : ' + arr_address[2]);
                                    infowindow3.setContent('<u><b>จุด 3 </b></u>  <b><font style="color: red">(' + arr_datetime[3] + ')</font></b> : ' + arr_address[3]);
                                    infowindow.open(map, marker1);
                                    infowindow2.open(map, marker2);
                                    infowindow3.open(map, marker3);
                                }
                                if (document.getElementById('txt_cnt').value == '4')
                                {
                                    var marker1 = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });

                                    var marker2 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude2), parseFloat(longitude2)),
                                        map: map
                                    });

                                    var marker3 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude3), parseFloat(longitude3)),
                                        map: map
                                    });

                                    var marker4 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude4), parseFloat(longitude4)),
                                        map: map
                                    });
                                    infowindow.setContent('<u><b>จุด 1 </b></u>  <b><font style="color: red">(' + arr_datetime[1] + ')</font></b> : ' + arr_address[1]);
                                    infowindow2.setContent('<u><b>จุด 2 </b></u>  <b><font style="color: red">(' + arr_datetime[2] + ')</font></b> : ' + arr_address[2]);
                                    infowindow3.setContent('<u><b>จุด 3 </b></u>  <b><font style="color: red">(' + arr_datetime[3] + ')</font></b> : ' + arr_address[3]);
                                    infowindow4.setContent('<u><b>จุด 4 </b></u>  <b><font style="color: red">(' + arr_datetime[4] + ')</font></b> : ' + arr_address[4]);
                                    infowindow.open(map, marker1);
                                    infowindow2.open(map, marker2);
                                    infowindow3.open(map, marker3);
                                    infowindow4.open(map, marker4);
                                }
                                if (document.getElementById('txt_cnt').value == '5')
                                {
                                    var marker1 = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });

                                    var marker2 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude2), parseFloat(longitude2)),
                                        map: map
                                    });

                                    var marker3 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude3), parseFloat(longitude3)),
                                        map: map
                                    });

                                    var marker4 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude4), parseFloat(longitude4)),
                                        map: map
                                    });
                                    var marker5 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude5), parseFloat(longitude5)),
                                        map: map
                                    });
                                    infowindow.setContent('<u><b>จุด 1 </b></u>  <b><font style="color: red">(' + arr_datetime[1] + ')</font></b> : ' + arr_address[1]);
                                    infowindow2.setContent('<u><b>จุด 2 </b></u>  <b><font style="color: red">(' + arr_datetime[2] + ')</font></b> : ' + arr_address[2]);
                                    infowindow3.setContent('<u><b>จุด 3 </b></u>  <b><font style="color: red">(' + arr_datetime[3] + ')</font></b> : ' + arr_address[3]);
                                    infowindow4.setContent('<u><b>จุด 4 </b></u>  <b><font style="color: red">(' + arr_datetime[4] + ')</font></b> : ' + arr_address[4]);
                                    infowindow5.setContent('<u><b>จุด 5 </b></u>  <b><font style="color: red">(' + arr_datetime[5] + ')</font></b> : ' + arr_address[5]);
                                    infowindow.open(map, marker1);
                                    infowindow2.open(map, marker2);
                                    infowindow3.open(map, marker3);
                                    infowindow4.open(map, marker4);
                                    infowindow5.open(map, marker5);
                                }
                                if (document.getElementById('txt_cnt').value == '6')
                                {
                                    var marker1 = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });

                                    var marker2 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude2), parseFloat(longitude2)),
                                        map: map
                                    });

                                    var marker3 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude3), parseFloat(longitude3)),
                                        map: map
                                    });

                                    var marker4 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude4), parseFloat(longitude4)),
                                        map: map
                                    });
                                    var marker5 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude5), parseFloat(longitude5)),
                                        map: map
                                    });
                                    var marker6 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude6), parseFloat(longitude6)),
                                        map: map
                                    });
                                    infowindow.setContent('<u><b>จุด 1 </b></u>  <b><font style="color: red">(' + arr_datetime[1] + ')</font></b> : ' + arr_address[1]);
                                    infowindow2.setContent('<u><b>จุด 2 </b></u>  <b><font style="color: red">(' + arr_datetime[2] + ')</font></b> : ' + arr_address[2]);
                                    infowindow3.setContent('<u><b>จุด 3 </b></u>  <b><font style="color: red">(' + arr_datetime[3] + ')</font></b> : ' + arr_address[3]);
                                    infowindow4.setContent('<u><b>จุด 4 </b></u>  <b><font style="color: red">(' + arr_datetime[4] + ')</font></b> : ' + arr_address[4]);
                                    infowindow5.setContent('<u><b>จุด 5 </b></u>  <b><font style="color: red">(' + arr_datetime[5] + ')</font></b> : ' + arr_address[5]);
                                    infowindow6.setContent('<u><b>จุด 6 </b></u>  <b><font style="color: red">(' + arr_datetime[6] + ')</font></b> : ' + arr_address[6]);
                                    infowindow.open(map, marker1);
                                    infowindow2.open(map, marker2);
                                    infowindow3.open(map, marker3);
                                    infowindow4.open(map, marker4);
                                    infowindow5.open(map, marker5);
                                    infowindow6.open(map, marker6);
                                }
                                if (document.getElementById('txt_cnt').value == '7')
                                {
                                    var marker1 = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });

                                    var marker2 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude2), parseFloat(longitude2)),
                                        map: map
                                    });

                                    var marker3 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude3), parseFloat(longitude3)),
                                        map: map
                                    });

                                    var marker4 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude4), parseFloat(longitude4)),
                                        map: map
                                    });
                                    var marker5 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude5), parseFloat(longitude5)),
                                        map: map
                                    });
                                    var marker6 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude6), parseFloat(longitude6)),
                                        map: map
                                    });
                                    var marker7 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude7), parseFloat(longitude7)),
                                        map: map
                                    });
                                    infowindow.setContent('<u><b>จุด 1 </b></u>  <b><font style="color: red">(' + arr_datetime[1] + ')</font></b> : ' + arr_address[1]);
                                    infowindow2.setContent('<u><b>จุด 2 </b></u>  <b><font style="color: red">(' + arr_datetime[2] + ')</font></b> : ' + arr_address[2]);
                                    infowindow3.setContent('<u><b>จุด 3 </b></u>  <b><font style="color: red">(' + arr_datetime[3] + ')</font></b> : ' + arr_address[3]);
                                    infowindow4.setContent('<u><b>จุด 4 </b></u>  <b><font style="color: red">(' + arr_datetime[4] + ')</font></b> : ' + arr_address[4]);
                                    infowindow5.setContent('<u><b>จุด 5 </b></u>  <b><font style="color: red">(' + arr_datetime[5] + ')</font></b> : ' + arr_address[5]);
                                    infowindow6.setContent('<u><b>จุด 6 </b></u>  <b><font style="color: red">(' + arr_datetime[6] + ')</font></b> : ' + arr_address[6]);
                                    infowindow7.setContent('<u><b>จุด 7 </b></u>  <b><font style="color: red">(' + arr_datetime[7] + ')</font></b> : ' + arr_address[7]);
                                    infowindow.open(map, marker1);
                                    infowindow2.open(map, marker2);
                                    infowindow3.open(map, marker3);
                                    infowindow4.open(map, marker4);
                                    infowindow5.open(map, marker5);
                                    infowindow6.open(map, marker6);
                                    infowindow7.open(map, marker7);
                                }
                                if (document.getElementById('txt_cnt').value == '8')
                                {
                                    var marker1 = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });

                                    var marker2 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude2), parseFloat(longitude2)),
                                        map: map
                                    });

                                    var marker3 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude3), parseFloat(longitude3)),
                                        map: map
                                    });

                                    var marker4 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude4), parseFloat(longitude4)),
                                        map: map
                                    });
                                    var marker5 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude5), parseFloat(longitude5)),
                                        map: map
                                    });
                                    var marker6 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude6), parseFloat(longitude6)),
                                        map: map
                                    });
                                    var marker7 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude7), parseFloat(longitude7)),
                                        map: map
                                    });
                                    var marker8 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude8), parseFloat(longitude8)),
                                        map: map
                                    });
                                    infowindow.setContent('<u><b>จุด 1 </b></u>  <b><font style="color: red">(' + arr_datetime[1] + ')</font></b> : ' + arr_address[1]);
                                    infowindow2.setContent('<u><b>จุด 2 </b></u>  <b><font style="color: red">(' + arr_datetime[2] + ')</font></b> : ' + arr_address[2]);
                                    infowindow3.setContent('<u><b>จุด 3 </b></u>  <b><font style="color: red">(' + arr_datetime[3] + ')</font></b> : ' + arr_address[3]);
                                    infowindow4.setContent('<u><b>จุด 4 </b></u>  <b><font style="color: red">(' + arr_datetime[4] + ')</font></b> : ' + arr_address[4]);
                                    infowindow5.setContent('<u><b>จุด 5 </b></u>  <b><font style="color: red">(' + arr_datetime[5] + ')</font></b> : ' + arr_address[5]);
                                    infowindow6.setContent('<u><b>จุด 6 </b></u>  <b><font style="color: red">(' + arr_datetime[6] + ')</font></b> : ' + arr_address[6]);
                                    infowindow7.setContent('<u><b>จุด 7 </b></u>  <b><font style="color: red">(' + arr_datetime[7] + ')</font></b> : ' + arr_address[7]);
                                    infowindow8.setContent('<u><b>จุด 8 </b></u>  <b><font style="color: red">(' + arr_datetime[8] + ')</font></b> : ' + arr_address[8]);
                                    infowindow.open(map, marker1);
                                    infowindow2.open(map, marker2);
                                    infowindow3.open(map, marker3);
                                    infowindow4.open(map, marker4);
                                    infowindow5.open(map, marker5);
                                    infowindow6.open(map, marker6);
                                    infowindow7.open(map, marker7);
                                    infowindow8.open(map, marker8);
                                }
                                if (document.getElementById('txt_cnt').value == '9')
                                {
                                    var marker1 = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });

                                    var marker2 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude2), parseFloat(longitude2)),
                                        map: map
                                    });

                                    var marker3 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude3), parseFloat(longitude3)),
                                        map: map
                                    });

                                    var marker4 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude4), parseFloat(longitude4)),
                                        map: map
                                    });
                                    var marker5 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude5), parseFloat(longitude5)),
                                        map: map
                                    });
                                    var marker6 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude6), parseFloat(longitude6)),
                                        map: map
                                    });
                                    var marker7 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude7), parseFloat(longitude7)),
                                        map: map
                                    });
                                    var marker8 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude8), parseFloat(longitude8)),
                                        map: map
                                    });
                                    var marker9 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude9), parseFloat(longitude9)),
                                        map: map
                                    });
                                    infowindow.setContent('<u><b>จุด 1 </b></u>  <b><font style="color: red">(' + arr_datetime[1] + ')</font></b> : ' + arr_address[1]);
                                    infowindow2.setContent('<u><b>จุด 2 </b></u>  <b><font style="color: red">(' + arr_datetime[2] + ')</font></b> : ' + arr_address[2]);
                                    infowindow3.setContent('<u><b>จุด 3 </b></u>  <b><font style="color: red">(' + arr_datetime[3] + ')</font></b> : ' + arr_address[3]);
                                    infowindow4.setContent('<u><b>จุด 4 </b></u>  <b><font style="color: red">(' + arr_datetime[4] + ')</font></b> : ' + arr_address[4]);
                                    infowindow5.setContent('<u><b>จุด 5 </b></u>  <b><font style="color: red">(' + arr_datetime[5] + ')</font></b> : ' + arr_address[5]);
                                    infowindow6.setContent('<u><b>จุด 6 </b></u>  <b><font style="color: red">(' + arr_datetime[6] + ')</font></b> : ' + arr_address[6]);
                                    infowindow7.setContent('<u><b>จุด 7 </b></u>  <b><font style="color: red">(' + arr_datetime[7] + ')</font></b> : ' + arr_address[7]);
                                    infowindow8.setContent('<u><b>จุด 8 </b></u>  <b><font style="color: red">(' + arr_datetime[8] + ')</font></b> : ' + arr_address[8]);
                                    infowindow9.setContent('<u><b>จุด 9 </b></u>  <b><font style="color: red">(' + arr_datetime[9] + ')</font></b> : ' + arr_address[9]);
                                    infowindow.open(map, marker1);
                                    infowindow2.open(map, marker2);
                                    infowindow3.open(map, marker3);
                                    infowindow4.open(map, marker4);
                                    infowindow5.open(map, marker5);
                                    infowindow6.open(map, marker6);
                                    infowindow7.open(map, marker7);
                                    infowindow8.open(map, marker8);
                                    infowindow9.open(map, marker9);
                                }
                                if (document.getElementById('txt_cnt').value == '10')
                                {
                                    var marker1 = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });

                                    var marker2 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude2), parseFloat(longitude2)),
                                        map: map
                                    });

                                    var marker3 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude3), parseFloat(longitude3)),
                                        map: map
                                    });

                                    var marker4 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude4), parseFloat(longitude4)),
                                        map: map
                                    });
                                    var marker5 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude5), parseFloat(longitude5)),
                                        map: map
                                    });
                                    var marker6 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude6), parseFloat(longitude6)),
                                        map: map
                                    });
                                    var marker7 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude7), parseFloat(longitude7)),
                                        map: map
                                    });
                                    var marker8 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude8), parseFloat(longitude8)),
                                        map: map
                                    });
                                    var marker9 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude9), parseFloat(longitude9)),
                                        map: map
                                    });
                                    var marker10 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude10), parseFloat(longitude10)),
                                        map: map
                                    });
                                    infowindow.setContent('<u><b>จุด 1 </b></u>  <b><font style="color: red">(' + arr_datetime[1] + ')</font></b> : ' + arr_address[1]);
                                    infowindow2.setContent('<u><b>จุด 2 </b></u>  <b><font style="color: red">(' + arr_datetime[2] + ')</font></b> : ' + arr_address[2]);
                                    infowindow3.setContent('<u><b>จุด 3 </b></u>  <b><font style="color: red">(' + arr_datetime[3] + ')</font></b> : ' + arr_address[3]);
                                    infowindow4.setContent('<u><b>จุด 4 </b></u>  <b><font style="color: red">(' + arr_datetime[4] + ')</font></b> : ' + arr_address[4]);
                                    infowindow5.setContent('<u><b>จุด 5 </b></u>  <b><font style="color: red">(' + arr_datetime[5] + ')</font></b> : ' + arr_address[5]);
                                    infowindow6.setContent('<u><b>จุด 6 </b></u>  <b><font style="color: red">(' + arr_datetime[6] + ')</font></b> : ' + arr_address[6]);
                                    infowindow7.setContent('<u><b>จุด 7 </b></u>  <b><font style="color: red">(' + arr_datetime[7] + ')</font></b> : ' + arr_address[7]);
                                    infowindow8.setContent('<u><b>จุด 8 </b></u>  <b><font style="color: red">(' + arr_datetime[8] + ')</font></b> : ' + arr_address[8]);
                                    infowindow9.setContent('<u><b>จุด 9 </b></u>  <b><font style="color: red">(' + arr_datetime[9] + ')</font></b> : ' + arr_address[9]);
                                    infowindow10.setContent('<u><b>จุด 10 </b></u>  <b><font style="color: red">(' + arr_datetime[10] + ')</font></b> : ' + arr_address[10]);
                                    infowindow.open(map, marker1);
                                    infowindow2.open(map, marker2);
                                    infowindow3.open(map, marker3);
                                    infowindow4.open(map, marker4);
                                    infowindow5.open(map, marker5);
                                    infowindow6.open(map, marker6);
                                    infowindow7.open(map, marker7);
                                    infowindow8.open(map, marker8);
                                    infowindow9.open(map, marker9);
                                    infowindow10.open(map, marker10);
                                }
                                if (document.getElementById('txt_cnt').value == '11')
                                {
                                    var marker1 = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });

                                    var marker2 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude2), parseFloat(longitude2)),
                                        map: map
                                    });

                                    var marker3 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude3), parseFloat(longitude3)),
                                        map: map
                                    });

                                    var marker4 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude4), parseFloat(longitude4)),
                                        map: map
                                    });
                                    var marker5 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude5), parseFloat(longitude5)),
                                        map: map
                                    });
                                    var marker6 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude6), parseFloat(longitude6)),
                                        map: map
                                    });
                                    var marker7 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude7), parseFloat(longitude7)),
                                        map: map
                                    });
                                    var marker8 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude8), parseFloat(longitude8)),
                                        map: map
                                    });
                                    var marker9 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude9), parseFloat(longitude9)),
                                        map: map
                                    });
                                    var marker10 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude10), parseFloat(longitude10)),
                                        map: map
                                    });
                                    var marker11 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude11), parseFloat(longitude11)),
                                        map: map
                                    });
                                    infowindow.setContent('<u><b>จุด 1 </b></u>  <b><font style="color: red">(' + arr_datetime[1] + ')</font></b> : ' + arr_address[1]);
                                    infowindow2.setContent('<u><b>จุด 2 </b></u>  <b><font style="color: red">(' + arr_datetime[2] + ')</font></b> : ' + arr_address[2]);
                                    infowindow3.setContent('<u><b>จุด 3 </b></u>  <b><font style="color: red">(' + arr_datetime[3] + ')</font></b> : ' + arr_address[3]);
                                    infowindow4.setContent('<u><b>จุด 4 </b></u>  <b><font style="color: red">(' + arr_datetime[4] + ')</font></b> : ' + arr_address[4]);
                                    infowindow5.setContent('<u><b>จุด 5 </b></u>  <b><font style="color: red">(' + arr_datetime[5] + ')</font></b> : ' + arr_address[5]);
                                    infowindow6.setContent('<u><b>จุด 6 </b></u>  <b><font style="color: red">(' + arr_datetime[6] + ')</font></b> : ' + arr_address[6]);
                                    infowindow7.setContent('<u><b>จุด 7 </b></u>  <b><font style="color: red">(' + arr_datetime[7] + ')</font></b> : ' + arr_address[7]);
                                    infowindow8.setContent('<u><b>จุด 8 </b></u>  <b><font style="color: red">(' + arr_datetime[8] + ')</font></b> : ' + arr_address[8]);
                                    infowindow9.setContent('<u><b>จุด 9 </b></u>  <b><font style="color: red">(' + arr_datetime[9] + ')</font></b> : ' + arr_address[9]);
                                    infowindow10.setContent('<u><b>จุด 10 </b></u>  <b><font style="color: red">(' + arr_datetime[10] + ')</font></b> : ' + arr_address[10]);
                                    infowindow11.setContent('<u><b>จุด 11 </b></u>  <b><font style="color: red">(' + arr_datetime[11] + ')</font></b> : ' + arr_address[11]);
                                    infowindow.open(map, marker1);
                                    infowindow2.open(map, marker2);
                                    infowindow3.open(map, marker3);
                                    infowindow4.open(map, marker4);
                                    infowindow5.open(map, marker5);
                                    infowindow6.open(map, marker6);
                                    infowindow7.open(map, marker7);
                                    infowindow8.open(map, marker8);
                                    infowindow9.open(map, marker9);
                                    infowindow10.open(map, marker10);
                                    infowindow11.open(map, marker11);
                                }
                                if (document.getElementById('txt_cnt').value == '12')
                                {
                                    var marker1 = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });

                                    var marker2 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude2), parseFloat(longitude2)),
                                        map: map
                                    });

                                    var marker3 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude3), parseFloat(longitude3)),
                                        map: map
                                    });

                                    var marker4 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude4), parseFloat(longitude4)),
                                        map: map
                                    });
                                    var marker5 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude5), parseFloat(longitude5)),
                                        map: map
                                    });
                                    var marker6 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude6), parseFloat(longitude6)),
                                        map: map
                                    });
                                    var marker7 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude7), parseFloat(longitude7)),
                                        map: map
                                    });
                                    var marker8 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude8), parseFloat(longitude8)),
                                        map: map
                                    });
                                    var marker9 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude9), parseFloat(longitude9)),
                                        map: map
                                    });
                                    var marker10 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude10), parseFloat(longitude10)),
                                        map: map
                                    });
                                    var marker11 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude11), parseFloat(longitude11)),
                                        map: map
                                    });
                                    var marker12 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude12), parseFloat(longitude12)),
                                        map: map
                                    });
                                    infowindow.setContent('<u><b>จุด 1 </b></u>  <b><font style="color: red">(' + arr_datetime[1] + ')</font></b> : ' + arr_address[1]);
                                    infowindow2.setContent('<u><b>จุด 2 </b></u>  <b><font style="color: red">(' + arr_datetime[2] + ')</font></b> : ' + arr_address[2]);
                                    infowindow3.setContent('<u><b>จุด 3 </b></u>  <b><font style="color: red">(' + arr_datetime[3] + ')</font></b> : ' + arr_address[3]);
                                    infowindow4.setContent('<u><b>จุด 4 </b></u>  <b><font style="color: red">(' + arr_datetime[4] + ')</font></b> : ' + arr_address[4]);
                                    infowindow5.setContent('<u><b>จุด 5 </b></u>  <b><font style="color: red">(' + arr_datetime[5] + ')</font></b> : ' + arr_address[5]);
                                    infowindow6.setContent('<u><b>จุด 6 </b></u>  <b><font style="color: red">(' + arr_datetime[6] + ')</font></b> : ' + arr_address[6]);
                                    infowindow7.setContent('<u><b>จุด 7 </b></u>  <b><font style="color: red">(' + arr_datetime[7] + ')</font></b> : ' + arr_address[7]);
                                    infowindow8.setContent('<u><b>จุด 8 </b></u>  <b><font style="color: red">(' + arr_datetime[8] + ')</font></b> : ' + arr_address[8]);
                                    infowindow9.setContent('<u><b>จุด 9 </b></u>  <b><font style="color: red">(' + arr_datetime[9] + ')</font></b> : ' + arr_address[9]);
                                    infowindow10.setContent('<u><b>จุด 10 </b></u>  <b><font style="color: red">(' + arr_datetime[10] + ')</font></b> : ' + arr_address[10]);
                                    infowindow11.setContent('<u><b>จุด 11 </b></u>  <b><font style="color: red">(' + arr_datetime[11] + ')</font></b> : ' + arr_address[11]);
                                    infowindow12.setContent('<u><b>จุด 12 </b></u>  <b><font style="color: red">(' + arr_datetime[12] + ')</font></b> : ' + arr_address[12]);
                                }
                                if (document.getElementById('txt_cnt').value == '13')
                                {
                                    var marker1 = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });

                                    var marker2 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude2), parseFloat(longitude2)),
                                        map: map
                                    });

                                    var marker3 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude3), parseFloat(longitude3)),
                                        map: map
                                    });

                                    var marker4 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude4), parseFloat(longitude4)),
                                        map: map
                                    });
                                    var marker5 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude5), parseFloat(longitude5)),
                                        map: map
                                    });
                                    var marker6 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude6), parseFloat(longitude6)),
                                        map: map
                                    });
                                    var marker7 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude7), parseFloat(longitude7)),
                                        map: map
                                    });
                                    var marker8 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude8), parseFloat(longitude8)),
                                        map: map
                                    });
                                    var marker9 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude9), parseFloat(longitude9)),
                                        map: map
                                    });
                                    var marker10 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude10), parseFloat(longitude10)),
                                        map: map
                                    });
                                    var marker11 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude11), parseFloat(longitude11)),
                                        map: map
                                    });
                                    var marker12 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude12), parseFloat(longitude12)),
                                        map: map
                                    });
                                    var marker13 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude13), parseFloat(longitude13)),
                                        map: map
                                    });
                                    infowindow.setContent('<u><b>จุด 1 </b></u>  <b><font style="color: red">(' + arr_datetime[1] + ')</font></b> : ' + arr_address[1]);
                                    infowindow2.setContent('<u><b>จุด 2 </b></u>  <b><font style="color: red">(' + arr_datetime[2] + ')</font></b> : ' + arr_address[2]);
                                    infowindow3.setContent('<u><b>จุด 3 </b></u>  <b><font style="color: red">(' + arr_datetime[3] + ')</font></b> : ' + arr_address[3]);
                                    infowindow4.setContent('<u><b>จุด 4 </b></u>  <b><font style="color: red">(' + arr_datetime[4] + ')</font></b> : ' + arr_address[4]);
                                    infowindow5.setContent('<u><b>จุด 5 </b></u>  <b><font style="color: red">(' + arr_datetime[5] + ')</font></b> : ' + arr_address[5]);
                                    infowindow6.setContent('<u><b>จุด 6 </b></u>  <b><font style="color: red">(' + arr_datetime[6] + ')</font></b> : ' + arr_address[6]);
                                    infowindow7.setContent('<u><b>จุด 7 </b></u>  <b><font style="color: red">(' + arr_datetime[7] + ')</font></b> : ' + arr_address[7]);
                                    infowindow8.setContent('<u><b>จุด 8 </b></u>  <b><font style="color: red">(' + arr_datetime[8] + ')</font></b> : ' + arr_address[8]);
                                    infowindow9.setContent('<u><b>จุด 9 </b></u>  <b><font style="color: red">(' + arr_datetime[9] + ')</font></b> : ' + arr_address[9]);
                                    infowindow10.setContent('<u><b>จุด 10 </b></u>  <b><font style="color: red">(' + arr_datetime[10] + ')</font></b> : ' + arr_address[10]);
                                    infowindow11.setContent('<u><b>จุด 11 </b></u>  <b><font style="color: red">(' + arr_datetime[11] + ')</font></b> : ' + arr_address[11]);
                                    infowindow12.setContent('<u><b>จุด 12 </b></u>  <b><font style="color: red">(' + arr_datetime[12] + ')</font></b> : ' + arr_address[12]);
                                    infowindow13.setContent('<u><b>จุด 13 </b></u>  <b><font style="color: red">(' + arr_datetime[13] + ')</font></b> : ' + arr_address[13]);
                                    infowindow.open(map, marker1);
                                    infowindow2.open(map, marker2);
                                    infowindow3.open(map, marker3);
                                    infowindow4.open(map, marker4);
                                    infowindow5.open(map, marker5);
                                    infowindow6.open(map, marker6);
                                    infowindow7.open(map, marker7);
                                    infowindow8.open(map, marker8);
                                    infowindow9.open(map, marker9);
                                    infowindow10.open(map, marker10);
                                    infowindow11.open(map, marker11);
                                    infowindow12.open(map, marker12);
                                    infowindow13.open(map, marker13);
                                }
                                if (document.getElementById('txt_cnt').value == '14')
                                {
                                    var marker1 = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });

                                    var marker2 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude2), parseFloat(longitude2)),
                                        map: map
                                    });

                                    var marker3 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude3), parseFloat(longitude3)),
                                        map: map
                                    });

                                    var marker4 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude4), parseFloat(longitude4)),
                                        map: map
                                    });
                                    var marker5 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude5), parseFloat(longitude5)),
                                        map: map
                                    });
                                    var marker6 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude6), parseFloat(longitude6)),
                                        map: map
                                    });
                                    var marker7 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude7), parseFloat(longitude7)),
                                        map: map
                                    });
                                    var marker8 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude8), parseFloat(longitude8)),
                                        map: map
                                    });
                                    var marker9 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude9), parseFloat(longitude9)),
                                        map: map
                                    });
                                    var marker10 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude10), parseFloat(longitude10)),
                                        map: map
                                    });
                                    var marker11 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude11), parseFloat(longitude11)),
                                        map: map
                                    });
                                    var marker12 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude12), parseFloat(longitude12)),
                                        map: map
                                    });
                                    var marker13 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude13), parseFloat(longitude13)),
                                        map: map
                                    });
                                    var marker14 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude14), parseFloat(longitude14)),
                                        map: map
                                    });
                                    infowindow.setContent('<u><b>จุด 1 </b></u>  <b><font style="color: red">(' + arr_datetime[1] + ')</font></b> : ' + arr_address[1]);
                                    infowindow2.setContent('<u><b>จุด 2 </b></u>  <b><font style="color: red">(' + arr_datetime[2] + ')</font></b> : ' + arr_address[2]);
                                    infowindow3.setContent('<u><b>จุด 3 </b></u>  <b><font style="color: red">(' + arr_datetime[3] + ')</font></b> : ' + arr_address[3]);
                                    infowindow4.setContent('<u><b>จุด 4 </b></u>  <b><font style="color: red">(' + arr_datetime[4] + ')</font></b> : ' + arr_address[4]);
                                    infowindow5.setContent('<u><b>จุด 5 </b></u>  <b><font style="color: red">(' + arr_datetime[5] + ')</font></b> : ' + arr_address[5]);
                                    infowindow6.setContent('<u><b>จุด 6 </b></u>  <b><font style="color: red">(' + arr_datetime[6] + ')</font></b> : ' + arr_address[6]);
                                    infowindow7.setContent('<u><b>จุด 7 </b></u>  <b><font style="color: red">(' + arr_datetime[7] + ')</font></b> : ' + arr_address[7]);
                                    infowindow8.setContent('<u><b>จุด 8 </b></u>  <b><font style="color: red">(' + arr_datetime[8] + ')</font></b> : ' + arr_address[8]);
                                    infowindow9.setContent('<u><b>จุด 9 </b></u>  <b><font style="color: red">(' + arr_datetime[9] + ')</font></b> : ' + arr_address[9]);
                                    infowindow10.setContent('<u><b>จุด 10 </b></u>  <b><font style="color: red">(' + arr_datetime[10] + ')</font></b> : ' + arr_address[10]);
                                    infowindow11.setContent('<u><b>จุด 11 </b></u>  <b><font style="color: red">(' + arr_datetime[11] + ')</font></b> : ' + arr_address[11]);
                                    infowindow12.setContent('<u><b>จุด 12 </b></u>  <b><font style="color: red">(' + arr_datetime[12] + ')</font></b> : ' + arr_address[12]);
                                    infowindow13.setContent('<u><b>จุด 13 </b></u>  <b><font style="color: red">(' + arr_datetime[13] + ')</font></b> : ' + arr_address[13]);
                                    infowindow14.setContent('<u><b>จุด 14 </b></u>  <b><font style="color: red">(' + arr_datetime[14] + ')</font></b> : ' + arr_address[14]);
                                    infowindow.open(map, marker1);
                                    infowindow2.open(map, marker2);
                                    infowindow3.open(map, marker3);
                                    infowindow4.open(map, marker4);
                                    infowindow5.open(map, marker5);
                                    infowindow6.open(map, marker6);
                                    infowindow7.open(map, marker7);
                                    infowindow8.open(map, marker8);
                                    infowindow9.open(map, marker9);
                                    infowindow10.open(map, marker10);
                                    infowindow11.open(map, marker11);
                                    infowindow12.open(map, marker12);
                                    infowindow13.open(map, marker13);
                                    infowindow14.open(map, marker14);
                                    infowindow20.open(map, marker20);
                                }
                                if (document.getElementById('txt_cnt').value == '15')
                                {
                                    var marker1 = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });

                                    var marker2 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude2), parseFloat(longitude2)),
                                        map: map
                                    });

                                    var marker3 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude3), parseFloat(longitude3)),
                                        map: map
                                    });

                                    var marker4 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude4), parseFloat(longitude4)),
                                        map: map
                                    });
                                    var marker5 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude5), parseFloat(longitude5)),
                                        map: map
                                    });
                                    var marker6 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude6), parseFloat(longitude6)),
                                        map: map
                                    });
                                    var marker7 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude7), parseFloat(longitude7)),
                                        map: map
                                    });
                                    var marker8 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude8), parseFloat(longitude8)),
                                        map: map
                                    });
                                    var marker9 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude9), parseFloat(longitude9)),
                                        map: map
                                    });
                                    var marker10 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude10), parseFloat(longitude10)),
                                        map: map
                                    });
                                    var marker11 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude11), parseFloat(longitude11)),
                                        map: map
                                    });
                                    var marker12 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude12), parseFloat(longitude12)),
                                        map: map
                                    });
                                    var marker13 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude13), parseFloat(longitude13)),
                                        map: map
                                    });
                                    var marker14 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude14), parseFloat(longitude14)),
                                        map: map
                                    });
                                    var marker15 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude15), parseFloat(longitude15)),
                                        map: map
                                    });
                                    infowindow.setContent('<u><b>จุด 1 </b></u>  <b><font style="color: red">(' + arr_datetime[1] + ')</font></b> : ' + arr_address[1]);
                                    infowindow2.setContent('<u><b>จุด 2 </b></u>  <b><font style="color: red">(' + arr_datetime[2] + ')</font></b> : ' + arr_address[2]);
                                    infowindow3.setContent('<u><b>จุด 3 </b></u>  <b><font style="color: red">(' + arr_datetime[3] + ')</font></b> : ' + arr_address[3]);
                                    infowindow4.setContent('<u><b>จุด 4 </b></u>  <b><font style="color: red">(' + arr_datetime[4] + ')</font></b> : ' + arr_address[4]);
                                    infowindow5.setContent('<u><b>จุด 5 </b></u>  <b><font style="color: red">(' + arr_datetime[5] + ')</font></b> : ' + arr_address[5]);
                                    infowindow6.setContent('<u><b>จุด 6 </b></u>  <b><font style="color: red">(' + arr_datetime[6] + ')</font></b> : ' + arr_address[6]);
                                    infowindow7.setContent('<u><b>จุด 7 </b></u>  <b><font style="color: red">(' + arr_datetime[7] + ')</font></b> : ' + arr_address[7]);
                                    infowindow8.setContent('<u><b>จุด 8 </b></u>  <b><font style="color: red">(' + arr_datetime[8] + ')</font></b> : ' + arr_address[8]);
                                    infowindow9.setContent('<u><b>จุด 9 </b></u>  <b><font style="color: red">(' + arr_datetime[9] + ')</font></b> : ' + arr_address[9]);
                                    infowindow10.setContent('<u><b>จุด 10 </b></u>  <b><font style="color: red">(' + arr_datetime[10] + ')</font></b> : ' + arr_address[10]);
                                    infowindow11.setContent('<u><b>จุด 11 </b></u>  <b><font style="color: red">(' + arr_datetime[11] + ')</font></b> : ' + arr_address[11]);
                                    infowindow12.setContent('<u><b>จุด 12 </b></u>  <b><font style="color: red">(' + arr_datetime[12] + ')</font></b> : ' + arr_address[12]);
                                    infowindow13.setContent('<u><b>จุด 13 </b></u>  <b><font style="color: red">(' + arr_datetime[13] + ')</font></b> : ' + arr_address[13]);
                                    infowindow14.setContent('<u><b>จุด 14 </b></u>  <b><font style="color: red">(' + arr_datetime[14] + ')</font></b> : ' + arr_address[14]);
                                    infowindow15.setContent('<u><b>จุด 15 </b></u>  <b><font style="color: red">(' + arr_datetime[15] + ')</font></b> : ' + arr_address[15]);
                                    infowindow.open(map, marker1);
                                    infowindow2.open(map, marker2);
                                    infowindow3.open(map, marker3);
                                    infowindow4.open(map, marker4);
                                    infowindow5.open(map, marker5);
                                    infowindow6.open(map, marker6);
                                    infowindow7.open(map, marker7);
                                    infowindow8.open(map, marker8);
                                    infowindow9.open(map, marker9);
                                    infowindow10.open(map, marker10);
                                    infowindow11.open(map, marker11);
                                    infowindow12.open(map, marker12);
                                    infowindow13.open(map, marker13);
                                    infowindow14.open(map, marker14);
                                    infowindow15.open(map, marker15);
                                }
                                if (document.getElementById('txt_cnt').value == '16')
                                {
                                    var marker1 = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });

                                    var marker2 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude2), parseFloat(longitude2)),
                                        map: map
                                    });

                                    var marker3 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude3), parseFloat(longitude3)),
                                        map: map
                                    });

                                    var marker4 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude4), parseFloat(longitude4)),
                                        map: map
                                    });
                                    var marker5 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude5), parseFloat(longitude5)),
                                        map: map
                                    });
                                    var marker6 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude6), parseFloat(longitude6)),
                                        map: map
                                    });
                                    var marker7 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude7), parseFloat(longitude7)),
                                        map: map
                                    });
                                    var marker8 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude8), parseFloat(longitude8)),
                                        map: map
                                    });
                                    var marker9 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude9), parseFloat(longitude9)),
                                        map: map
                                    });
                                    var marker10 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude10), parseFloat(longitude10)),
                                        map: map
                                    });
                                    var marker11 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude11), parseFloat(longitude11)),
                                        map: map
                                    });
                                    var marker12 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude12), parseFloat(longitude12)),
                                        map: map
                                    });
                                    var marker13 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude13), parseFloat(longitude13)),
                                        map: map
                                    });
                                    var marker14 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude14), parseFloat(longitude14)),
                                        map: map
                                    });
                                    var marker15 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude15), parseFloat(longitude15)),
                                        map: map
                                    });
                                    var marker16 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude16), parseFloat(longitude16)),
                                        map: map
                                    });
                                    infowindow.setContent('<u><b>จุด 1 </b></u>  <b><font style="color: red">(' + arr_datetime[1] + ')</font></b> : ' + arr_address[1]);
                                    infowindow2.setContent('<u><b>จุด 2 </b></u>  <b><font style="color: red">(' + arr_datetime[2] + ')</font></b> : ' + arr_address[2]);
                                    infowindow3.setContent('<u><b>จุด 3 </b></u>  <b><font style="color: red">(' + arr_datetime[3] + ')</font></b> : ' + arr_address[3]);
                                    infowindow4.setContent('<u><b>จุด 4 </b></u>  <b><font style="color: red">(' + arr_datetime[4] + ')</font></b> : ' + arr_address[4]);
                                    infowindow5.setContent('<u><b>จุด 5 </b></u>  <b><font style="color: red">(' + arr_datetime[5] + ')</font></b> : ' + arr_address[5]);
                                    infowindow6.setContent('<u><b>จุด 6 </b></u>  <b><font style="color: red">(' + arr_datetime[6] + ')</font></b> : ' + arr_address[6]);
                                    infowindow7.setContent('<u><b>จุด 7 </b></u>  <b><font style="color: red">(' + arr_datetime[7] + ')</font></b> : ' + arr_address[7]);
                                    infowindow8.setContent('<u><b>จุด 8 </b></u>  <b><font style="color: red">(' + arr_datetime[8] + ')</font></b> : ' + arr_address[8]);
                                    infowindow9.setContent('<u><b>จุด 9 </b></u>  <b><font style="color: red">(' + arr_datetime[9] + ')</font></b> : ' + arr_address[9]);
                                    infowindow10.setContent('<u><b>จุด 10 </b></u>  <b><font style="color: red">(' + arr_datetime[10] + ')</font></b> : ' + arr_address[10]);
                                    infowindow11.setContent('<u><b>จุด 11 </b></u>  <b><font style="color: red">(' + arr_datetime[11] + ')</font></b> : ' + arr_address[11]);
                                    infowindow12.setContent('<u><b>จุด 12 </b></u>  <b><font style="color: red">(' + arr_datetime[12] + ')</font></b> : ' + arr_address[12]);
                                    infowindow13.setContent('<u><b>จุด 13 </b></u>  <b><font style="color: red">(' + arr_datetime[13] + ')</font></b> : ' + arr_address[13]);
                                    infowindow14.setContent('<u><b>จุด 14 </b></u>  <b><font style="color: red">(' + arr_datetime[14] + ')</font></b> : ' + arr_address[14]);
                                    infowindow15.setContent('<u><b>จุด 15 </b></u>  <b><font style="color: red">(' + arr_datetime[15] + ')</font></b> : ' + arr_address[15]);
                                    infowindow16.setContent('<u><b>จุด 16 </b></u>  <b><font style="color: red">(' + arr_datetime[16] + ')</font></b> : ' + arr_address[16]);
                                    infowindow.open(map, marker1);
                                    infowindow2.open(map, marker2);
                                    infowindow3.open(map, marker3);
                                    infowindow4.open(map, marker4);
                                    infowindow5.open(map, marker5);
                                    infowindow6.open(map, marker6);
                                    infowindow7.open(map, marker7);
                                    infowindow8.open(map, marker8);
                                    infowindow9.open(map, marker9);
                                    infowindow10.open(map, marker10);
                                    infowindow11.open(map, marker11);
                                    infowindow12.open(map, marker12);
                                    infowindow13.open(map, marker13);
                                    infowindow14.open(map, marker14);
                                    infowindow15.open(map, marker15);
                                    infowindow16.open(map, marker16);
                                }
                                if (document.getElementById('txt_cnt').value == '17')
                                {
                                    var marker1 = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });

                                    var marker2 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude2), parseFloat(longitude2)),
                                        map: map
                                    });

                                    var marker3 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude3), parseFloat(longitude3)),
                                        map: map
                                    });

                                    var marker4 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude4), parseFloat(longitude4)),
                                        map: map
                                    });
                                    var marker5 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude5), parseFloat(longitude5)),
                                        map: map
                                    });
                                    var marker6 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude6), parseFloat(longitude6)),
                                        map: map
                                    });
                                    var marker7 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude7), parseFloat(longitude7)),
                                        map: map
                                    });
                                    var marker8 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude8), parseFloat(longitude8)),
                                        map: map
                                    });
                                    var marker9 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude9), parseFloat(longitude9)),
                                        map: map
                                    });
                                    var marker10 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude10), parseFloat(longitude10)),
                                        map: map
                                    });
                                    var marker11 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude11), parseFloat(longitude11)),
                                        map: map
                                    });
                                    var marker12 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude12), parseFloat(longitude12)),
                                        map: map
                                    });
                                    var marker13 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude13), parseFloat(longitude13)),
                                        map: map
                                    });
                                    var marker14 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude14), parseFloat(longitude14)),
                                        map: map
                                    });
                                    var marker15 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude15), parseFloat(longitude15)),
                                        map: map
                                    });
                                    var marker16 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude16), parseFloat(longitude16)),
                                        map: map
                                    });
                                    var marker17 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude17), parseFloat(longitude17)),
                                        map: map
                                    });
                                    infowindow.setContent('<u><b>จุด 1 </b></u>  <b><font style="color: red">(' + arr_datetime[1] + ')</font></b> : ' + arr_address[1]);
                                    infowindow2.setContent('<u><b>จุด 2 </b></u>  <b><font style="color: red">(' + arr_datetime[2] + ')</font></b> : ' + arr_address[2]);
                                    infowindow3.setContent('<u><b>จุด 3 </b></u>  <b><font style="color: red">(' + arr_datetime[3] + ')</font></b> : ' + arr_address[3]);
                                    infowindow4.setContent('<u><b>จุด 4 </b></u>  <b><font style="color: red">(' + arr_datetime[4] + ')</font></b> : ' + arr_address[4]);
                                    infowindow5.setContent('<u><b>จุด 5 </b></u>  <b><font style="color: red">(' + arr_datetime[5] + ')</font></b> : ' + arr_address[5]);
                                    infowindow6.setContent('<u><b>จุด 6 </b></u>  <b><font style="color: red">(' + arr_datetime[6] + ')</font></b> : ' + arr_address[6]);
                                    infowindow7.setContent('<u><b>จุด 7 </b></u>  <b><font style="color: red">(' + arr_datetime[7] + ')</font></b> : ' + arr_address[7]);
                                    infowindow8.setContent('<u><b>จุด 8 </b></u>  <b><font style="color: red">(' + arr_datetime[8] + ')</font></b> : ' + arr_address[8]);
                                    infowindow9.setContent('<u><b>จุด 9 </b></u>  <b><font style="color: red">(' + arr_datetime[9] + ')</font></b> : ' + arr_address[9]);
                                    infowindow10.setContent('<u><b>จุด 10 </b></u>  <b><font style="color: red">(' + arr_datetime[10] + ')</font></b> : ' + arr_address[10]);
                                    infowindow11.setContent('<u><b>จุด 11 </b></u>  <b><font style="color: red">(' + arr_datetime[11] + ')</font></b> : ' + arr_address[11]);
                                    infowindow12.setContent('<u><b>จุด 12 </b></u>  <b><font style="color: red">(' + arr_datetime[12] + ')</font></b> : ' + arr_address[12]);
                                    infowindow13.setContent('<u><b>จุด 13 </b></u>  <b><font style="color: red">(' + arr_datetime[13] + ')</font></b> : ' + arr_address[13]);
                                    infowindow14.setContent('<u><b>จุด 14 </b></u>  <b><font style="color: red">(' + arr_datetime[14] + ')</font></b> : ' + arr_address[14]);
                                    infowindow15.setContent('<u><b>จุด 15 </b></u>  <b><font style="color: red">(' + arr_datetime[15] + ')</font></b> : ' + arr_address[15]);
                                    infowindow16.setContent('<u><b>จุด 16 </b></u>  <b><font style="color: red">(' + arr_datetime[16] + ')</font></b> : ' + arr_address[16]);
                                    infowindow17.setContent('<u><b>จุด 17 </b></u>  <b><font style="color: red">(' + arr_datetime[17] + ')</font></b> : ' + arr_address[17]);
                                    infowindow.open(map, marker1);
                                    infowindow2.open(map, marker2);
                                    infowindow3.open(map, marker3);
                                    infowindow4.open(map, marker4);
                                    infowindow5.open(map, marker5);
                                    infowindow6.open(map, marker6);
                                    infowindow7.open(map, marker7);
                                    infowindow8.open(map, marker8);
                                    infowindow9.open(map, marker9);
                                    infowindow10.open(map, marker10);
                                    infowindow11.open(map, marker11);
                                    infowindow12.open(map, marker12);
                                    infowindow13.open(map, marker13);
                                    infowindow14.open(map, marker14);
                                    infowindow15.open(map, marker15);
                                    infowindow16.open(map, marker16);
                                    infowindow17.open(map, marker17);
                                }
                                if (document.getElementById('txt_cnt').value == '18')
                                {
                                    var marker1 = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });

                                    var marker2 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude2), parseFloat(longitude2)),
                                        map: map
                                    });

                                    var marker3 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude3), parseFloat(longitude3)),
                                        map: map
                                    });

                                    var marker4 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude4), parseFloat(longitude4)),
                                        map: map
                                    });
                                    var marker5 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude5), parseFloat(longitude5)),
                                        map: map
                                    });
                                    var marker6 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude6), parseFloat(longitude6)),
                                        map: map
                                    });
                                    var marker7 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude7), parseFloat(longitude7)),
                                        map: map
                                    });
                                    var marker8 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude8), parseFloat(longitude8)),
                                        map: map
                                    });
                                    var marker9 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude9), parseFloat(longitude9)),
                                        map: map
                                    });
                                    var marker10 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude10), parseFloat(longitude10)),
                                        map: map
                                    });
                                    var marker11 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude11), parseFloat(longitude11)),
                                        map: map
                                    });
                                    var marker12 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude12), parseFloat(longitude12)),
                                        map: map
                                    });
                                    var marker13 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude13), parseFloat(longitude13)),
                                        map: map
                                    });
                                    var marker14 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude14), parseFloat(longitude14)),
                                        map: map
                                    });
                                    var marker15 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude15), parseFloat(longitude15)),
                                        map: map
                                    });
                                    var marker16 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude16), parseFloat(longitude16)),
                                        map: map
                                    });
                                    var marker17 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude17), parseFloat(longitude17)),
                                        map: map
                                    });
                                    var marker18 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude18), parseFloat(longitude18)),
                                        map: map
                                    });
                                    infowindow.setContent('<u><b>จุด 1 </b></u>  <b><font style="color: red">(' + arr_datetime[1] + ')</font></b> : ' + arr_address[1]);
                                    infowindow2.setContent('<u><b>จุด 2 </b></u>  <b><font style="color: red">(' + arr_datetime[2] + ')</font></b> : ' + arr_address[2]);
                                    infowindow3.setContent('<u><b>จุด 3 </b></u>  <b><font style="color: red">(' + arr_datetime[3] + ')</font></b> : ' + arr_address[3]);
                                    infowindow4.setContent('<u><b>จุด 4 </b></u>  <b><font style="color: red">(' + arr_datetime[4] + ')</font></b> : ' + arr_address[4]);
                                    infowindow5.setContent('<u><b>จุด 5 </b></u>  <b><font style="color: red">(' + arr_datetime[5] + ')</font></b> : ' + arr_address[5]);
                                    infowindow6.setContent('<u><b>จุด 6 </b></u>  <b><font style="color: red">(' + arr_datetime[6] + ')</font></b> : ' + arr_address[6]);
                                    infowindow7.setContent('<u><b>จุด 7 </b></u>  <b><font style="color: red">(' + arr_datetime[7] + ')</font></b> : ' + arr_address[7]);
                                    infowindow8.setContent('<u><b>จุด 8 </b></u>  <b><font style="color: red">(' + arr_datetime[8] + ')</font></b> : ' + arr_address[8]);
                                    infowindow9.setContent('<u><b>จุด 9 </b></u>  <b><font style="color: red">(' + arr_datetime[9] + ')</font></b> : ' + arr_address[9]);
                                    infowindow10.setContent('<u><b>จุด 10 </b></u>  <b><font style="color: red">(' + arr_datetime[10] + ')</font></b> : ' + arr_address[10]);
                                    infowindow11.setContent('<u><b>จุด 11 </b></u>  <b><font style="color: red">(' + arr_datetime[11] + ')</font></b> : ' + arr_address[11]);
                                    infowindow12.setContent('<u><b>จุด 12 </b></u>  <b><font style="color: red">(' + arr_datetime[12] + ')</font></b> : ' + arr_address[12]);
                                    infowindow13.setContent('<u><b>จุด 13 </b></u>  <b><font style="color: red">(' + arr_datetime[13] + ')</font></b> : ' + arr_address[13]);
                                    infowindow14.setContent('<u><b>จุด 14 </b></u>  <b><font style="color: red">(' + arr_datetime[14] + ')</font></b> : ' + arr_address[14]);
                                    infowindow15.setContent('<u><b>จุด 15 </b></u>  <b><font style="color: red">(' + arr_datetime[15] + ')</font></b> : ' + arr_address[15]);
                                    infowindow16.setContent('<u><b>จุด 16 </b></u>  <b><font style="color: red">(' + arr_datetime[16] + ')</font></b> : ' + arr_address[16]);
                                    infowindow17.setContent('<u><b>จุด 17 </b></u>  <b><font style="color: red">(' + arr_datetime[17] + ')</font></b> : ' + arr_address[17]);
                                    infowindow18.setContent('<u><b>จุด 18 </b></u>  <b><font style="color: red">(' + arr_datetime[18] + ')</font></b> : ' + arr_address[18]);
                                    infowindow.open(map, marker1);
                                    infowindow2.open(map, marker2);
                                    infowindow3.open(map, marker3);
                                    infowindow4.open(map, marker4);
                                    infowindow5.open(map, marker5);
                                    infowindow6.open(map, marker6);
                                    infowindow7.open(map, marker7);
                                    infowindow8.open(map, marker8);
                                    infowindow9.open(map, marker9);
                                    infowindow10.open(map, marker10);
                                    infowindow11.open(map, marker11);
                                    infowindow12.open(map, marker12);
                                    infowindow13.open(map, marker13);
                                    infowindow14.open(map, marker14);
                                    infowindow15.open(map, marker15);
                                    infowindow16.open(map, marker16);
                                    infowindow17.open(map, marker17);
                                    infowindow18.open(map, marker18);
                                }
                                if (document.getElementById('txt_cnt').value == '19')
                                {
                                    var marker1 = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });

                                    var marker2 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude2), parseFloat(longitude2)),
                                        map: map
                                    });

                                    var marker3 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude3), parseFloat(longitude3)),
                                        map: map
                                    });

                                    var marker4 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude4), parseFloat(longitude4)),
                                        map: map
                                    });
                                    var marker5 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude5), parseFloat(longitude5)),
                                        map: map
                                    });
                                    var marker6 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude6), parseFloat(longitude6)),
                                        map: map
                                    });
                                    var marker7 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude7), parseFloat(longitude7)),
                                        map: map
                                    });
                                    var marker8 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude8), parseFloat(longitude8)),
                                        map: map
                                    });
                                    var marker9 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude9), parseFloat(longitude9)),
                                        map: map
                                    });
                                    var marker10 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude10), parseFloat(longitude10)),
                                        map: map
                                    });
                                    var marker11 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude11), parseFloat(longitude11)),
                                        map: map
                                    });
                                    var marker12 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude12), parseFloat(longitude12)),
                                        map: map
                                    });
                                    var marker13 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude13), parseFloat(longitude13)),
                                        map: map
                                    });
                                    var marker14 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude14), parseFloat(longitude14)),
                                        map: map
                                    });
                                    var marker15 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude15), parseFloat(longitude15)),
                                        map: map
                                    });
                                    var marker16 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude16), parseFloat(longitude16)),
                                        map: map
                                    });
                                    var marker17 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude17), parseFloat(longitude17)),
                                        map: map
                                    });
                                    var marker18 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude18), parseFloat(longitude18)),
                                        map: map
                                    });
                                    var marker19 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude19), parseFloat(longitude19)),
                                        map: map
                                    });
                                    infowindow.setContent('<u><b>จุด 1 </b></u>  <b><font style="color: red">(' + arr_datetime[1] + ')</font></b> : ' + arr_address[1]);
                                    infowindow2.setContent('<u><b>จุด 2 </b></u>  <b><font style="color: red">(' + arr_datetime[2] + ')</font></b> : ' + arr_address[2]);
                                    infowindow3.setContent('<u><b>จุด 3 </b></u>  <b><font style="color: red">(' + arr_datetime[3] + ')</font></b> : ' + arr_address[3]);
                                    infowindow4.setContent('<u><b>จุด 4 </b></u>  <b><font style="color: red">(' + arr_datetime[4] + ')</font></b> : ' + arr_address[4]);
                                    infowindow5.setContent('<u><b>จุด 5 </b></u>  <b><font style="color: red">(' + arr_datetime[5] + ')</font></b> : ' + arr_address[5]);
                                    infowindow6.setContent('<u><b>จุด 6 </b></u>  <b><font style="color: red">(' + arr_datetime[6] + ')</font></b> : ' + arr_address[6]);
                                    infowindow7.setContent('<u><b>จุด 7 </b></u>  <b><font style="color: red">(' + arr_datetime[7] + ')</font></b> : ' + arr_address[7]);
                                    infowindow8.setContent('<u><b>จุด 8 </b></u>  <b><font style="color: red">(' + arr_datetime[8] + ')</font></b> : ' + arr_address[8]);
                                    infowindow9.setContent('<u><b>จุด 9 </b></u>  <b><font style="color: red">(' + arr_datetime[9] + ')</font></b> : ' + arr_address[9]);
                                    infowindow10.setContent('<u><b>จุด 10 </b></u>  <b><font style="color: red">(' + arr_datetime[10] + ')</font></b> : ' + arr_address[10]);
                                    infowindow11.setContent('<u><b>จุด 11 </b></u>  <b><font style="color: red">(' + arr_datetime[11] + ')</font></b> : ' + arr_address[11]);
                                    infowindow12.setContent('<u><b>จุด 12 </b></u>  <b><font style="color: red">(' + arr_datetime[12] + ')</font></b> : ' + arr_address[12]);
                                    infowindow13.setContent('<u><b>จุด 13 </b></u>  <b><font style="color: red">(' + arr_datetime[13] + ')</font></b> : ' + arr_address[13]);
                                    infowindow14.setContent('<u><b>จุด 14 </b></u>  <b><font style="color: red">(' + arr_datetime[14] + ')</font></b> : ' + arr_address[14]);
                                    infowindow15.setContent('<u><b>จุด 15 </b></u>  <b><font style="color: red">(' + arr_datetime[15] + ')</font></b> : ' + arr_address[15]);
                                    infowindow16.setContent('<u><b>จุด 16 </b></u>  <b><font style="color: red">(' + arr_datetime[16] + ')</font></b> : ' + arr_address[16]);
                                    infowindow17.setContent('<u><b>จุด 17 </b></u>  <b><font style="color: red">(' + arr_datetime[17] + ')</font></b> : ' + arr_address[17]);
                                    infowindow18.setContent('<u><b>จุด 18 </b></u>  <b><font style="color: red">(' + arr_datetime[18] + ')</font></b> : ' + arr_address[18]);
                                    infowindow19.setContent('<u><b>จุด 19 </b></u>  <b><font style="color: red">(' + arr_datetime[19] + ')</font></b> : ' + arr_address[19]);
                                    infowindow.open(map, marker1);
                                    infowindow2.open(map, marker2);
                                    infowindow3.open(map, marker3);
                                    infowindow4.open(map, marker4);
                                    infowindow5.open(map, marker5);
                                    infowindow6.open(map, marker6);
                                    infowindow7.open(map, marker7);
                                    infowindow8.open(map, marker8);
                                    infowindow9.open(map, marker9);
                                    infowindow10.open(map, marker10);
                                    infowindow11.open(map, marker11);
                                    infowindow12.open(map, marker12);
                                    infowindow13.open(map, marker13);
                                    infowindow14.open(map, marker14);
                                    infowindow15.open(map, marker15);
                                    infowindow16.open(map, marker16);
                                    infowindow17.open(map, marker17);
                                    infowindow18.open(map, marker18);
                                    infowindow19.open(map, marker19);
                                }

                                if (document.getElementById('txt_cnt').value == '20')
                                {
                                    var marker1 = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });

                                    var marker2 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude2), parseFloat(longitude2)),
                                        map: map
                                    });

                                    var marker3 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude3), parseFloat(longitude3)),
                                        map: map
                                    });

                                    var marker4 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude4), parseFloat(longitude4)),
                                        map: map
                                    });
                                    var marker5 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude5), parseFloat(longitude5)),
                                        map: map
                                    });
                                    var marker6 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude6), parseFloat(longitude6)),
                                        map: map
                                    });
                                    var marker7 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude7), parseFloat(longitude7)),
                                        map: map
                                    });
                                    var marker8 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude8), parseFloat(longitude8)),
                                        map: map
                                    });
                                    var marker9 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude9), parseFloat(longitude9)),
                                        map: map
                                    });
                                    var marker10 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude10), parseFloat(longitude10)),
                                        map: map
                                    });
                                    var marker11 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude11), parseFloat(longitude11)),
                                        map: map
                                    });
                                    var marker12 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude12), parseFloat(longitude12)),
                                        map: map
                                    });
                                    var marker13 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude13), parseFloat(longitude13)),
                                        map: map
                                    });
                                    var marker14 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude14), parseFloat(longitude14)),
                                        map: map
                                    });
                                    var marker15 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude15), parseFloat(longitude15)),
                                        map: map
                                    });
                                    var marker16 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude16), parseFloat(longitude16)),
                                        map: map
                                    });
                                    var marker17 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude17), parseFloat(longitude17)),
                                        map: map
                                    });
                                    var marker18 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude18), parseFloat(longitude18)),
                                        map: map
                                    });
                                    var marker19 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude19), parseFloat(longitude19)),
                                        map: map
                                    });
                                    var marker20 = new google.maps.Marker({
                                        position: new google.maps.LatLng(parseFloat(latitude20), parseFloat(longitude20)),
                                        map: map
                                    });
                                    infowindow.setContent('<u><b>จุด 1 </b></u>  <b><font style="color: red">(' + arr_datetime[1] + ')</font></b> : ' + arr_address[1]);
                                    infowindow2.setContent('<u><b>จุด 2 </b></u>  <b><font style="color: red">(' + arr_datetime[2] + ')</font></b> : ' + arr_address[2]);
                                    infowindow3.setContent('<u><b>จุด 3 </b></u>  <b><font style="color: red">(' + arr_datetime[3] + ')</font></b> : ' + arr_address[3]);
                                    infowindow4.setContent('<u><b>จุด 4 </b></u>  <b><font style="color: red">(' + arr_datetime[4] + ')</font></b> : ' + arr_address[4]);
                                    infowindow5.setContent('<u><b>จุด 5 </b></u>  <b><font style="color: red">(' + arr_datetime[5] + ')</font></b> : ' + arr_address[5]);
                                    infowindow6.setContent('<u><b>จุด 6 </b></u>  <b><font style="color: red">(' + arr_datetime[6] + ')</font></b> : ' + arr_address[6]);
                                    infowindow7.setContent('<u><b>จุด 7 </b></u>  <b><font style="color: red">(' + arr_datetime[7] + ')</font></b> : ' + arr_address[7]);
                                    infowindow8.setContent('<u><b>จุด 8 </b></u>  <b><font style="color: red">(' + arr_datetime[8] + ')</font></b> : ' + arr_address[8]);
                                    infowindow9.setContent('<u><b>จุด 9 </b></u>  <b><font style="color: red">(' + arr_datetime[9] + ')</font></b> : ' + arr_address[9]);
                                    infowindow10.setContent('<u><b>จุด 10 </b></u>  <b><font style="color: red">(' + arr_datetime[10] + ')</font></b> : ' + arr_address[10]);
                                    infowindow11.setContent('<u><b>จุด 11 </b></u>  <b><font style="color: red">(' + arr_datetime[11] + ')</font></b> : ' + arr_address[11]);
                                    infowindow12.setContent('<u><b>จุด 12 </b></u>  <b><font style="color: red">(' + arr_datetime[12] + ')</font></b> : ' + arr_address[12]);
                                    infowindow13.setContent('<u><b>จุด 13 </b></u>  <b><font style="color: red">(' + arr_datetime[13] + ')</font></b> : ' + arr_address[13]);
                                    infowindow14.setContent('<u><b>จุด 14 </b></u>  <b><font style="color: red">(' + arr_datetime[14] + ')</font></b> : ' + arr_address[14]);
                                    infowindow15.setContent('<u><b>จุด 15 </b></u>  <b><font style="color: red">(' + arr_datetime[15] + ')</font></b> : ' + arr_address[15]);
                                    infowindow16.setContent('<u><b>จุด 16 </b></u>  <b><font style="color: red">(' + arr_datetime[16] + ')</font></b> : ' + arr_address[16]);
                                    infowindow17.setContent('<u><b>จุด 17 </b></u>  <b><font style="color: red">(' + arr_datetime[17] + ')</font></b> : ' + arr_address[17]);
                                    infowindow18.setContent('<u><b>จุด 18 </b></u>  <b><font style="color: red">(' + arr_datetime[18] + ')</font></b> : ' + arr_address[18]);
                                    infowindow19.setContent('<u><b>จุด 19 </b></u>  <b><font style="color: red">(' + arr_datetime[19] + ')</font></b> : ' + arr_address[19]);
                                    infowindow20.setContent('<u><b>จุด 20 </b></u>  <b><font style="color: red">(' + arr_datetime[20] + ')</font></b> : ' + arr_address[20]);
                                    infowindow.open(map, marker1);
                                    infowindow2.open(map, marker2);
                                    infowindow3.open(map, marker3);
                                    infowindow4.open(map, marker4);
                                    infowindow5.open(map, marker5);
                                    infowindow6.open(map, marker6);
                                    infowindow7.open(map, marker7);
                                    infowindow8.open(map, marker8);
                                    infowindow9.open(map, marker9);
                                    infowindow10.open(map, marker10);
                                    infowindow11.open(map, marker11);
                                    infowindow12.open(map, marker12);
                                    infowindow13.open(map, marker13);
                                    infowindow14.open(map, marker14);
                                    infowindow15.open(map, marker15);
                                    infowindow16.open(map, marker16);
                                    infowindow17.open(map, marker17);
                                    infowindow18.open(map, marker18);
                                    infowindow19.open(map, marker19);
                                    infowindow20.open(map, marker20);
                                }





                            } else {
                                window.alert('No results found');
                            }
                        } else {
                            //window.alert('Geocoder failed due to: ' + status);
                        }
                    });



                 
              

                }
                
            </script>

            <script async defer
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqQ-U8FVm22brVNb258ICuDQDCfL8ljm4">
            </script>




    </body>

    <?php
    sqlsrv_close($conn);
    ?>
