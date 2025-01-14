<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);


$sql_gettime = "SELECT CONVERT(VARCHAR(5),GETDATE(),114) AS 'TIME'";
$params_gettime  = array();
$query_gettime = sqlsrv_query($conn, $sql_gettime, $params_gettime);
$result_gettime  = sqlsrv_fetch_array($query_gettime, SQLSRV_FETCH_ASSOC);

?>

<html lang="en">

    <head>
        <link rel="shortcut icon" href="icon.png" />
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
        <script src="jquery-3.1.1.min.js"></script>
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">


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
        <style>
            .input-sm {
                height: 100px;
                padding: 5px 0%;
                font-size: 36px;
                line-height: 1.5;
                border-radius: 3px;


            }

            .form-control {
                border: 5px solid #337ab7;
            }

        </style>





    </head>

    <body >

        <input  type="text" id="txt_latitude" style="display: none">
        <input  type="text" id="txt_longitude" style="display: none">
        <input  type="text" id="txt_pathname" style="display: none">
        <div  class="modal fade text-center" id="modal_confrim" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 90%; ">
                <div class="modal-content" >
                    <div class="modal-header" style="font-size: 30px">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <font><b>ยืนยันข้อมูลพนักงาน</b></font>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <font><b><label id="lb_employeecode"></label> : <label id="lb_employeename"></label></b></font>
                            </div>
                        </div>

                    </div>
                    <div id="div_beforeactivity">
                        <div class="modal-body" style="font-size: 20px">

                            <div class="row">

                                <div class="col-lg-12 text-left">
                                    <label>สาเหตุที่รายงานตัวก่อนหรือเลยเวลา</label> <font style="color: red">*</font>
                                    <textarea type="text" id="txt_beforeactivity" name="txt_beforeactivity" onkeydown="chk_beforeactivity()" onkeyup="chk_beforeactivity()" onkeypress="chk_beforeactivity()" class="form-control" rows="4"></textarea>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer" style="font-size: 26px">
                        <div class="row">

                            <div class="col-lg-12 text-center">


                                <div id="shw_confrim1">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="btn_confrim1" name="btn_confrim1" onclick="take_snapshot()"> ยืนยัน</button>
                                </div>
                                <div id="shw_confrim2">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                                    <button type="button" class="btn btn-primary" onclick="take_snapshot()" id="btn_confrim2" name="btn_confrim2"> ยืนยัน</button>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div  class="modal fade text-center" id="modal_checkin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 90%;">
                <div class="modal-content" >
                    <div class="modal-header" style="font-size: 18px">
                        <div class="row">
                            <div class="col-lg-12 ">
                              <input style="display: none" id="txt_time" name="txt_time" type=button value="<?=$result_gettime['TIME']?>">
                                <font><b><p id="p_maxtime"></p></b></font>
                                <font><b><p>ขอบคุณที่รายงานตัว</p></b></font>
                            </div>


                        </div>
                    </div>
                    <div class="modal-body" style="font-size: 18px">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <div id="my_camera" style="display: none"></div>
                                <input style="display: none" type=button value="Configure" onClick="configure()">
                                <input style="display: none" type=button value="Take Snapshot" onClick="take_snapshot()">
                                <input style="display: none" type=button value="Save Snapshot" onClick="saveSnap()">

                                <div id="results"></div>


                            </div>
                        </div>

                    </div>
                    <div class="modal-footer" style="font-size: 18px">
                        <div class="row">
                            <div class="col-lg-12">

                                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="reload_page()"><span class="fa fa-close" ></span> ปิด</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>








        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="font-size: 36px;">

                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <b>รายงานตัวปฎิบัติงาน</b>
                            </div>



                        </div>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body" style="font-size: 36px;">

                        <div class="tab-content">

                            <div class="row">

                                <div class="col-md-12 text-center">
                                    <input type="text" onkeyup="if (isNaN(this.value)) {
                                                alert('กรุณากรอกตัวเลข');
                                                this.value = '';
                                            }" placeholder="รหัสพนักงาน..." id="txt_employeecode" autocomplete="off" name="txt_employeecode" class="form-control" style="font-size: 36px;height: 100%">
                                </div>

                            </div>




                        </div>
                    </div>
                    <div class="modal-footer" style="font-size: 36px;">
                        <div class="row">


                            <div class="col-md-12 text-center">
                                <a href="#" style="font-size: 36px" onc onclick="take_confrim()"  class="btn btn-default">คลิก</a>
                            </div>


                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>

        </div>

        <!-- /.panel -->




        <!--<script src="../vendor/jquery/jquery.min.js"></script>-->
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>

        <script src="../dist/js/jszip.min.js"></script>
        <script src="../dist/js/dataTables.buttons.min.js"></script>
        <script src="../dist/js/buttons.html5.min.js"></script>
        <script src="../dist/js/buttons.print.min.js"></script>
        <script src="../dist/js/bootstrap-select.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>
        <script type="text/javascript" src="webcamjs/webcam.min.js"></script>
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDScuWq88e4pBSyJmr2qsImi0ud1lP2ckA&callback=initMap">
        </script>
        <script language="JavaScript">
        //add this js script into the web page,
        //you want reload once after first load
        window.onload = function() {
            //considering there aren't any hashes in the urls already
            if(!window.location.hash) {
                //setting window location
                window.location = window.location + '#loaded';
                //using reload() method to reload web page
                window.location.reload();
            }
        }
            configure();
            function initMap(latitude, longitude) {
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 15,
                    center: {lat: parseFloat(latitude), lng: parseFloat(longitude)}
                });

            }
            function ret_geocodeLatLng(latitude, longitude) {

                var geocoder = new google.maps.Geocoder;
                var latlng = {lat: parseFloat(latitude), lng: parseFloat(longitude)};
                geocoder.geocode({'location': latlng}, function (results, status) {
                    if (status === 'OK') {
                        if (results[0]) {


                                $.ajax({
                                    type: 'post',
                                    url: '../pages/meg_data.php',
                                    data: {
                                        txt_flg: "update_mapaddress",
                                        employeecode : document.getElementById('txt_employeecode').value,
                                        mapaddress: results[0].formatted_address


                                    },
                                    success: function () {
                                    }
                                });





                        }
                    }
                });
            }
            // Configure a few settings and attach camera
            function chk_beforeactivity() {




                document.getElementById('btn_confrim2').disabled = true;
                $.ajax({
                    type: 'post',
                    url: '../pages/meg_data.php',
                    data: {
                        txt_flg: "select_workcheckintime"


                    },

                    success: function (rs) {
                        if (rs == 0)
                        {

                            if (document.getElementById('txt_beforeactivity').value != '')
                            {

                                document.getElementById('shw_confrim2').style.display = "none";
                                document.getElementById('shw_confrim1').style.display = "";
                                document.getElementById('btn_confrim2').disabled = false;
                            } else
                            {

                                document.getElementById('shw_confrim1').style.display = "none";
                                document.getElementById('shw_confrim2').style.display = "";
                                document.getElementById('btn_confrim2').disabled = true;
                            }

                        } else
                        {

                            document.getElementById('shw_confrim2').style.display = "none";
                            document.getElementById('shw_confrim1').style.display = "";
                            document.getElementById('btn_confrim2').disabled = false;
                        }
                    }
                });







            }
            function configure() {
                Webcam.set({
                    width: 320,
                    height: 240,
                    image_format: 'jpeg',
                    jpeg_quality: 90
                });
                Webcam.attach('#my_camera');

            }
            // A button for taking snaps


            // preload shutter audio clip
            var shutter = new Audio();
            shutter.autoplay = false;
            shutter.src = navigator.userAgent.match(/Firefox/) ? 'shutter.ogg' : 'shutter.mp3';


            function take_confrim() {

                $.ajax({
                    type: 'post',
                    url: '../pages/meg_data.php',
                    data: {
                        txt_flg: "select_workcheckintime"


                    },

                    success: function (rs) {

                        if (rs == 0)
                        {

                            document.getElementById('div_beforeactivity').style.display = "";

                        } else
                        {

                            document.getElementById('div_beforeactivity').style.display = "none";
                        }
                    }
                });
                chk_beforeactivity();
                if (document.getElementById('txt_employeecode').value != '')
                {
                    $.ajax({
                        type: 'post',
                        url: '../pages/meg_data.php',
                        data: {
                            txt_flg: "select_checkempname", employeecode: document.getElementById('txt_employeecode').value


                        },
                        success: function (rs) {

                            if (rs == '0')
                            {

                                alert('รหัสพนักงานไม่ถูกต้อง !');
                                document.getElementById('txt_employeecode').value = '';

                            } else
                            {
                                $.ajax({
                                    type: 'post',
                                    url: '../pages/meg_data.php',
                                    data: {
                                        txt_flg: "select_workcheckinemp", employeecode: document.getElementById('txt_employeecode').value


                                    },
                                    success: function (rs) {
                                        document.getElementById('lb_employeecode').innerHTML = document.getElementById('txt_employeecode').value
                                        document.getElementById('lb_employeename').innerHTML = rs;
                                    }
                                });
                                $("#modal_confrim").modal();
                            }

                        }
                    });
                    //window.location.reload();



                } else
                {
                    alert('รหัสพนักงานเป็นค่าว่าง !');
                }
            }

            function take_snapshot() {


                shutter.play();

                // take snapshot and get image data
                Webcam.snap(function (data_uri) {
                    // display results in page
                    document.getElementById('results').innerHTML =
                            '<img id="imageprev" style="width: 90%;height: 100%" src="' + data_uri + '"/>';
                    document.getElementById('txt_pathname').value = data_uri;
                });

                Webcam.reset();
                configure();
                saveSnap();
                getLocation();
                $("#modal_checkin").modal();
                // reload_page();

            }

            function reload_page(){
              // alert("sssss");
                  window.location.reload(true);
            }

            function select_maxworkcheckin()
            {

                $.ajax({
                    type: 'post',
                    url: '../pages/meg_data.php',
                    data: {
                        txt_flg: "select_maxworkcheckin", employeecode: document.getElementById('txt_employeecode').value


                    },
                    success: function (rs) {
                       var time = document.getElementById('txt_time').value;
                        if (document.getElementById('txt_employeecode').value != '')
                        {
                            document.getElementById('p_maxtime').innerHTML = 'รายงานตัวเวลา ' + time + ' เรียบร้อยแล้ว';

                        } else
                        {
                            document.getElementById('p_maxtime').innerHTML = 'รหัสพนักงานเป็นค่าว่าง !';

                        }

                        //window.location.reload();
                    }
                });
            }
            function save_workcheckin()
            {


                if (document.getElementById('txt_employeecode').value != '')
                {

                    $.ajax({
                        type: 'post',
                        url: '../pages/meg_data.php',
                        data: {
                            txt_flg: "save_workcheckin",
                            employeecode: document.getElementById('txt_employeecode').value,
                            latitude: document.getElementById('txt_latitude').value,
                            longitude: document.getElementById('txt_longitude').value,
                            pathname: document.getElementById('txt_pathname').value,
                            beforeactivity: document.getElementById('txt_beforeactivity').value

                        },
                        success: function () {



                            //window.location.reload();
                        }
                    });
                }
            }

            function saveSnap() {
                // Get base64 value from <img id='imageprev'> source
                var base64image = document.getElementById("imageprev").src;

                Webcam.upload(base64image, 'upload.php', function () {
                    console.log('Save successfully');
                    //console.log(text);


                });


            }



            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                }
            }

            function showPosition(position) {

                document.getElementById('txt_latitude').value = position.coords.latitude;
                document.getElementById('txt_longitude').value = position.coords.longitude;

                ret_geocodeLatLng(position.coords.latitude, position.coords.longitude);

                save_workcheckin();
                select_maxworkcheckin();

            }
            function send_lineworkcheckin()
            {

                $.ajax({
                    type: 'post',
                    url: '../pages/meg_data.php',
                    data: {
                        txt_flg: "send_lineworkcheckin",
                        employeecode: document.getElementById('txt_employeecode').value,
                        latitude: document.getElementById('txt_latitude').value,
                        longitude: document.getElementById('txt_longitude').value,
                        pathname: document.getElementById('txt_pathname').value

                    },
                    success: function () {


                        //window.location.reload();
                    }
                });

            }





        </script>

    </body>

</html>
<?php
sqlsrv_close($conn);
?>
