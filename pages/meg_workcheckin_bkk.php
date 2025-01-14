
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
        <style>
            /* Set the size of the div element that contains the map */
            #map {
                height: 100%;  /* The height is 400 pixels */
                width: 100%;  /* The width is the width of the web page */
            }
        </style>

    </head>

    <body>

       <?php 


                    ?>
        <input type="text" id="txt_employeecode" name="txt_employeecode" style="display: none">
        <input type="text" id="txt_employeename" name="txt_employeename" style="display: none">
        <input type="text" id="txt_createdate" name="txt_createdate" style="display: none">
        <input type="text" id="txt_createtime" name="txt_createtime" style="display: none">
        <input type="text" id="txt_latiude" name="txt_latiude" style="display: none">
        <input type="text" id="txt_longitude" name="txt_longitude" style="display: none">
        <div class="modal fade" id="modal_selectline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 40%">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="title"><b>ส่งรายงานปฎิบัติงาน </b></h5>
                    </div>
                    <div class="modal-body">


                        <div class="row">
                            <div class="col-md-2" >สายงาน :</div>
                            <div class="col-md-10" ><select id="cb_token" name="cb_token" class="form-control"  title="เลือก พนักงาน/สายงาน..." >
                                    <option value="">เลือกพนักงาน/สายงาน</option>
                                    <?php
                                    $sql_seLinesendplan = "{call megLinesendplan_v2(?,?,?,?)}";
                                    $params_seLinesendplan = array(
                                        array('select_linesendplan', SQLSRV_PARAM_IN),
                                        array(" AND (NAME ='Ruamkit RIT')", SQLSRV_PARAM_IN),
                                        array('', SQLSRV_PARAM_IN),
                                        array('', SQLSRV_PARAM_IN)
                                    );
                                    $query_seLinesendplan = sqlsrv_query($conn, $sql_seLinesendplan, $params_seLinesendplan);
                                    while ($result_seLinesendplan = sqlsrv_fetch_array($query_seLinesendplan, SQLSRV_FETCH_ASSOC)) {
                                        ?>
                                        <option value="<?= $result_seLinesendplan['TOKEN'] ?>"><?= $result_seLinesendplan['NAME'] ?></option>
                                        <?php
                                    }
                                    ?>


                                </select>
                            </div>
                        </div>




                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-primary" onclick="send_workcheckin()" id="submit" name="submit" value="ส่ง">
                    </div>
                </div>

            </div>
        </div>

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
                            <div class="col-lg-8 text-center">
                                <!--<iframe id="ifrm" style="width: 100%;height: 100%;border:0"   allowfullscreen></iframe>-->
                                <div id="map"></div>



                            </div>
                            <div class="col-lg-4 text-center">
                                <div id="emp_image"></div>





                            </div>
                        </div>

                    </div>
                    <div class="modal-footer" >
                        <div class="row">
                            <div class="col-lg-12">
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
                            รายงานตัวปฎิบัติงาน


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

                                        รายงานตัวปฎิบัติงาน

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


                                                    <div class="col-lg-1">

                                                        <div class="form-group">
                                                            <label>ช่วงวันที่</label>
                                                            <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                        </div>

                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateend" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <font style="color: red">* </font><label>ฝ่าย</label>

                                                        <select id="select_dep" name="select_dep" class="form-control" onchange="select_sec(this.value)">
                                                            <option value="">เลือกฝ่าย</option>
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
                                                        <font style="color: red">* </font><label>แผนก</label>
                                                        <div id="sec_def">
                                                            <select id="select_sec" name="select_sec" class="form-control">
                                                                <option value="">เลือกแผนก</option>

                                                            </select>
                                                        </div>
                                                        <div id="sec_sr"></div>


                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>สายงาน</label>

                                                        <select id="select_cat" name="select_cat" class="form-control">
                                                            <option value="">เลือกสายงาน</option>
                                                            <?php
                                                            $sql_seCat = "SELECT DISTINCT PositionID,PositionNameT FROM [dbo].[POSITIONEHR]";

                                                            $query_seCat = sqlsrv_query($conn, $sql_seCat, $params_seCat);
                                                            while ($result_seCat = sqlsrv_fetch_array($query_seCat, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <option value="<?= $result_seCat['PositionID'] ?>"><?= $result_seCat['PositionNameT'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>



                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>ช่วงเวลา</label>
                                                        <div id="sec_def">
                                                            <select id="select_time" name="select_time" class="form-control">
                                                                <option value="">ช่วงเวลา</option>
                                                                <option value="เช้า">00.01 : 11.59 (เช้า)</option>
                                                                <option value="บ่าย">12.00 : 18.59 (บ่าย)</option>
                                                                <option value="เย็น">19.00 : 23.59 (เย็น)</option>

                                                            </select>
                                                        </div>
                                                        <div id="sec_sr"></div>


                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" onclick="select_workcheckin();">ค้นหา <li class="fa fa-search"></li></button>
                                                        </div>

                                                    </div>


                                                    <div class="col-lg-1" style="text-align: right">
                                                        <label>&nbsp;</label><br>
                                                        <a href="#" onclick="excel_workcheckin();" class="btn btn-default">พิมพ์ <li class="fa fa-print"></li></a>

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

                                                                        <th rowspan="2">ลำดับ</th>

                                                                        <th rowspan="2">รหัสพนักงาน</th>
                                                                        <th rowspan="2">ชื่อ-นามสกุล</th>
                                                                        <th rowspan="2">สาเหตุ</th>
                                                                        <th rowspan="2">วันที่</th>
                                                                        <th rowspan="2">เวลา (ช่วงเวลา)</th>
                                                                        <!--<th rowspan="2">ที่อยู่ (แผนที่)</th>-->
                                                                        <!--<th rowspan="2">ที่อยู่ (ปัจจุบัน)</th>-->
                                                                        <th style="text-align: center" colspan="3">ที่อยู่ (ปัจจุบัน)</th>
                                                                        <th style="text-align: center"><< ระยะห่าง (ก.ม) >></th>
                                                                        <th style="text-align: center" colspan="3">ที่อยู่ (ปัจจุบัน)</th>
                                                                        <th style="text-align: center" rowspan="2">แผนที่</th>
                                                                        <th style="text-align: center" rowspan="2">ลบ</th>

                                                                    </tr>
                                                                    <tr>


                                                                        <th style="text-align: center">ตำบล</th>
                                                                        <th style="text-align: center">อำเภอ</th>
                                                                        <th style="text-align: center">จังหวัด</th>
                                                                        <th style="text-align: center">&nbsp;</th>
                                                                        <th style="text-align: center">ตำบล</th>
                                                                        <th style="text-align: center">อำเภอ</th>
                                                                        <th style="text-align: center">จังหวัด</th>

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

                                                            function select_sec(data)
                                                            {

                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "select_sec", data: data
                                                                    },
                                                                    success: function (response) {
                                                                        document.getElementById("sec_sr").innerHTML = response;
                                                                        document.getElementById("sec_def").innerHTML = "";



                                                                    }
                                                                });
                                                            }
                                                            function send_data(data1, data2, data3, data4, data5, data6)
                                                            {
                                                                document.getElementById('txt_employeecode').value = data1;
                                                                document.getElementById('txt_employeename').value = data2;
                                                                document.getElementById('txt_createdate').value = data3;
                                                                document.getElementById('txt_createtime').value = data4;
                                                                document.getElementById('txt_latiude').value = data5;
                                                                document.getElementById('txt_longitude').value = data6;

                                                            }
                                                            function send_workcheckin()
                                                            {
                                                                var message = 'รหัสพนักงาน : ' + document.getElementById('txt_employeecode').value + ',ชื่อพนักงาน : ' + document.getElementById('txt_employeename').value + ',วันที่ : ' + document.getElementById('txt_createdate').value + ',เวลา : ' + document.getElementById('txt_createtime').value + ',แผนที่ : https://www.google.com/maps/?q=' + document.getElementById('txt_latiude').value + ',' + document.getElementById('txt_longitude').value;

                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "send_workcheckin", message: message, access_token: document.getElementById('cb_token').value
                                                                    },
                                                                    success: function () {




                                                                    }
                                                                });
                                                            }

                                                            function delete_workcheckin(workcheckinid)
                                                            {



                                                                var confirmation = confirm("ต้องการลบข้อมูล ?");
                                                                if (confirmation) {
                                                                    $.ajax({
                                                                        type: 'post',
                                                                        url: 'meg_data.php',
                                                                        data: {
                                                                            txt_flg: "delete_workcheckin", workcheckinid: workcheckinid
                                                                        },
                                                                        success: function () {

                                                                            select_workcheckin();



                                                                        }
                                                                    });
                                                                }




                                                            }

                                                            function select_workcheckin()
                                                            {


                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;
                                                                var department = document.getElementById('select_dep').value;
                                                                var section = document.getElementById('select_sec').value;
                                                                var category = document.getElementById('select_cat').value;
                                                                var time = document.getElementById('select_time').value;

                                                                // alert(datestart);
                                                                // alert(datestart);
                                                                // alert(companycode);
                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "select_workcheckin", datestart: datestart, dateend: dateend, department: department, section: section, category: category, time: time,area:'<?=$_GET['area']?>'
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

                                                            function excel_workcheckin()
                                                            {
                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;
                                                                var department = document.getElementById('select_dep').value;
                                                                var section = document.getElementById('select_sec').value;
                                                                var cattegory = document.getElementById('select_cat').value;

                                                                var time = document.getElementById('select_time').value;

                                                                window.open('excel_workcheckin.php?datestart=' + datestart + '&dateend=' + dateend + '&department=' + department + '&section=' + section + '&cattegory=' + cattegory + '&time=' + time+'&area='+'<?=$_GET['area']?>', '_blank');


                                                            }

                                                            function gdatetodate()
                                                            {
                                                                document.getElementById('txt_gdateend').value = document.getElementById('txt_gdatestart').value;
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


            <script>
                //function initMap2(latitude, longitude, data_uri)
                //{
                //    document.getElementById('emp_image').innerHTML =
                //           '<img style="width: 100%" id="img_showemployee" src="' + data_uri + '"/>';
                //    document.getElementById("ifrm").src = "https://www.google.com/maps/embed/v1/place?key=AIzaSyB0s5n1xxG59UvtfQZ1lovbc2ZdK52sLPc&q=" + latitude + "," + longitude;
                //}
               

                
                function initMap(latitude, longitude, data_uri, latitudemaster, longitudemaster, addressmaster) {
                    document.getElementById('emp_image').innerHTML =
                            '<img style="width: 100%;" id="img_showemployee" src="' + data_uri + '"/>';

                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 15,

                        center: {lat: parseFloat(latitude), lng: parseFloat(longitude)}
                    });


                    var geocoder = new google.maps.Geocoder;
                    var infowindow = new google.maps.InfoWindow;
                    var infowindow2 = new google.maps.InfoWindow;


                    geocodeLatLng(geocoder, map, infowindow, infowindow2, latitude, longitude, latitudemaster, longitudemaster, addressmaster);



                    const dakota = {lat: parseFloat(latitudemaster), lng: parseFloat(longitudemaster)};
                    const frick = {lat: parseFloat(latitude), lng: parseFloat(longitude)};
                    // The markers for The Dakota and The Frick Collection
                    var mk1 = new google.maps.Marker({position: dakota, map: map});
                    var mk2 = new google.maps.Marker({position: frick, map: map});


// Draw a line showing the straight distance between the markers
                    var line = new google.maps.Polyline({path: [dakota, frick], map: map});



                    // Calculate and display the distance between markers
                    var distance = haversine_distance(mk1, mk2);
                    document.getElementById('msg2').innerHTML = "<b>พื้นที่รายงานตัวปฎิบัติงาน (ระยะทาง : " + (distance.toFixed(2) * 1.60934).toFixed(2) + " km</b>)";
                }
                function haversine_distance(mk1, mk2) {
                    var R = 3958.8; // Radius of the Earth in miles
                    var rlat1 = mk1.position.lat() * (Math.PI / 180); // Convert degrees to radians
                    var rlat2 = mk2.position.lat() * (Math.PI / 180); // Convert degrees to radians
                    var difflat = rlat2 - rlat1; // Radian difference (latitudes)
                    var difflon = (mk2.position.lng() - mk1.position.lng()) * (Math.PI / 180); // Radian difference (longitudes)

                    var d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat / 2) * Math.sin(difflat / 2) + Math.cos(rlat1) * Math.cos(rlat2) * Math.sin(difflon / 2) * Math.sin(difflon / 2)));
                    return d;
                }
                function geocodeLatLng(geocoder, map, infowindow, infowindow2, latitude, longitude, latitudemaster, longitudemaster, addressmaster) {



                    var latlng = {lat: parseFloat(latitude), lng: parseFloat(longitude)};
                    geocoder.geocode({'location': latlng}, function (results, status) {
                        if (status === 'OK') {
                            if (results[0]) {
                                map.setZoom(15);



                                var marker1 = new google.maps.Marker({
                                    position: latlng,
                                    //position: new google.maps.LatLng(parseFloat(latitude), parseFloat(longitude)),
                                    map: map
                                });

                                var marker2 = new google.maps.Marker({
                                    //position: latlng,
                                    position: new google.maps.LatLng(parseFloat(latitudemaster), parseFloat(longitudemaster)),
                                    map: map
                                });
                                infowindow.setContent('<b>ที่อยู่รายงานตัว</b> : ' + results[0].formatted_address);
                                infowindow2.setContent('<b>ที่อยู่ปัจจุบัน</b> : ' + addressmaster);
                                infowindow.open(map, marker2);
                                infowindow2.open(map, marker1);



                            } else {
                                window.alert('No results found');
                            }
                        } else {
                            //window.alert('Geocoder failed due to: ' + status);
                        }
                    });


                }

            </script>



            <!--Load the API from the specified URL
            * The async attribute allows the browser to render the page while the API loads
            * The key parameter will contain your own API key (which is not needed for this tutorial)
            * The callback parameter executes the initMap() function
            -->
            <script async defer
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqQ-U8FVm22brVNb258ICuDQDCfL8ljm4&callback=initMap">
            </script>




    </body>

    <?php
    sqlsrv_close($conn);
    ?>
