<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
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
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
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
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 80%">
                <div class="modal-content">
                    <div class="modal-header"  id="employee"></div>
                    <div class="modal-body">
                        <div class="row" >
                            <div class="col-lg-12">
                                <div id="datadef"></div>
                                <div id="datasr"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div id="datadeffooter"></div>
                        <div id="datasrfooter"></div>
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
            <div id="page-wrapper">
                <p>&nbsp;</p>
                <div class="row">

                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <form  name="searchform" id="searchform" method="post">
                                    <div class="row">
                                        <div class = "col-lg-4">
                                            <div class = "form-group">
                                                <br>
                                                <button type="button" id="btn_refresh" onclick="update_jobstatus()" name="btn_refresh" class="btn"  style="border-color: red;background-color:#fff;color: red "><li class="fa fa-refresh"></li></button>
                                                <font style="color: red">ตรวจสอบแผนงานเลยเวลารายงานตัว </font>                                        </div>
                                        </div>
                                        <div class = "col-lg-8 text-right">
                                            <div class = "form-group">
                                                <label>สถานะงาน</label>(ล่าสุด)<br>
                                                <button type="submit" id="btn_status0" name="btn_status0" class="btn"  style="border-color: black;background-color:#fff;color: black ">แผนงานยกเลิก</button>
                                                <button type="submit" id="btn_status1" name="btn_status1" class="btn"  style="border-color: blue;background-color:#fff;color:blue  ">แผนงานยังไม่ถึงเวลารายงาน</button>
                                                <button type="submit" id="btn_status2" name="btn_status2" class="btn"  style="border-color: red;background-color:#fff;color: red ">แผนงานเลยเวลารายงานตัว</button>
                                                <button type="submit" id="btn_status3" name="btn_status3" class="btn"  style="border-color: #ffcb0b;background-color:#fff;color:#ffcb0b ">รายงานตัวเปิด Job เริ่มงาน</button>
                                                <button type="submit" id="btn_status4" name="btn_status4" class="btn"  style="border-color: green;background-color:#fff;color:green  ">รายงานตัวกลับปิด Job งาน</button>
                                                <button type="submit" id="btn_status5" name="btn_status5" class="btn"  style="border-color: green;background-color:#fff;color:darkgray  ">บันทึกเลขที่เอกสาร</button>


                                            </div>
                                        </div>

                                    </div>
                                </form>

                            </div>
                            <div class="panel-body">
                                <?php
                                if (isset($_POST['btn_status0'])) {
                                    $condition = 0;
                                    $sql_seEmployee = "{call megEmployee3_v2(?,?)}";
                                    $params_seEmployee = array(
                                        array('select_employeesr', SQLSRV_PARAM_IN),
                                        array($condition, SQLSRV_PARAM_IN)
                                    );
                                } else if (isset($_POST['btn_status1'])) {
                                    $condition = 1;
                                    $sql_seEmployee = "{call megEmployee3_v2(?,?)}";
                                    $params_seEmployee = array(
                                        array('select_employeesr', SQLSRV_PARAM_IN),
                                        array($condition, SQLSRV_PARAM_IN)
                                    );
                                } else if (isset($_POST['btn_status2'])) {
                                    $condition = 2;
                                    $sql_seEmployee = "{call megEmployee3_v2(?,?)}";
                                    $params_seEmployee = array(
                                        array('select_employeesr', SQLSRV_PARAM_IN),
                                        array($condition, SQLSRV_PARAM_IN)
                                    );
                                } else if (isset($_POST['btn_status3'])) {
                                    $condition = 3;
                                    $sql_seEmployee = "{call megEmployee3_v2(?,?)}";
                                    $params_seEmployee = array(
                                        array('select_employeesr', SQLSRV_PARAM_IN),
                                        array($condition, SQLSRV_PARAM_IN)
                                    );
                                } else if (isset($_POST['btn_status4'])) {
                                    $condition = 4;
                                    $sql_seEmployee = "{call megEmployee3_v2(?,?)}";
                                    $params_seEmployee = array(
                                        array('select_employeesr', SQLSRV_PARAM_IN),
                                        array($condition, SQLSRV_PARAM_IN)
                                    );
                                } else if (isset($_POST['btn_status5'])) {
                                    $condition = 5;
                                    $sql_seEmployee = "{call megEmployee3_v2(?,?)}";
                                    $params_seEmployee = array(
                                        array('select_employeesr', SQLSRV_PARAM_IN),
                                        array($condition, SQLSRV_PARAM_IN)
                                    );
                                } else {
                                    $condition = '';
                                    $sql_seEmployee = "{call megEmployee3_v2(?,?)}";
                                    $params_seEmployee = array(
                                        array('select_employee', SQLSRV_PARAM_IN),
                                        array($condition, SQLSRV_PARAM_IN)
                                    );
                                }
                                ?>

                                <div class="row" id="loading"></div>
                                <div class="row" id="list-data">
                                    <?php
                                    $query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
                                    while ($result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC)) {
                                        ?>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="panel" style="background-color: #FFF;color: #337ab7;border-bottom-width: 5px;border-right-width: 5px;
                                            <?php
                                            switch ($result_seEmployee['STATUSNUMBER']) {
                                                case '0': {
                                                        ?>
                                                             border-color: black;
                                                             <?php
                                                         }
                                                         break;
                                                     case '1': {
                                                             ?>
                                                             border-color: blue;
                                                             <?php
                                                         }
                                                         break;
                                                     case '2': {
                                                             ?>
                                                             border-color: red;
                                                             <?php
                                                         }
                                                         break;
                                                     case '3': {
                                                             ?>
                                                             border-color: #ffcb0b;
                                                             <?php
                                                         }
                                                         break;
                                                     case '4': {
                                                             ?>
                                                             border-color: green;
                                                             <?php
                                                         }
                                                         break;
                                                     case '5': {
                                                             ?>
                                                             border-color: darkgray;
                                                             <?php
                                                         }
                                                         break;
                                                     default : {
                                                             ?>
                                                             border-color: blue;
                                                             <?php
                                                         }
                                                         break;
                                                 }
                                                 ?>
                                                 ">
                                                <div class="panel-heading">
                                                    <div class="row">

                                                        <div class="col-lg-12">
                                                            <h4>ทะเบียนรถ : <b><?= $result_seEmployee['VEHICLEREGISNUMBER1'] ?></b> เบอร์รถ : <b><?= $result_seEmployee['THAINAME'] ?></b></h4>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            &nbsp;
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3" style="text-align: center">

                                                            <img src="../images/<?= $result_seEmployee['VEHICLETYPEIMAGE'] ?>.jpg" style="width: 60px;height: 40px;"><br>
                                                        </div>
                                                        <div class="col-lg-9 ">
                                                            <div class="form-group">
                                                                <label>D1 : </label> <?= $result_seEmployee['EMPLOYEENAME1'] ?> (<?= $result_seEmployee['EMPLOYEECODE1'] ?>)
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            &nbsp;
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3" style="text-align: center">
                                                            &nbsp;
                                                        </div>
                                                        <div class="col-lg-9 ">
                                                            <div class="form-group">
                                                                <label>D2 : </label> <?= $result_seEmployee['EMPLOYEENAME2'] ?> (<?= $result_seEmployee['EMPLOYEECODE2'] ?>)
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-footer">
                                                    <span class="pull-left"><label>สถานะ </label>(ล่าสุด) <label>:</label> <?= $result_seEmployee['STATUS'] ?></span>
                                                    <span class="pull-right"> 
                                                        <button title="ยืนยันการทำงาน" onclick="select_employee('<?= $result_seEmployee['EMPLOYEECODE1'] ?>', '<?= $result_seEmployee['EMPLOYEECODE2'] ?>', '<?= $result_seEmployee['EMPLOYEENAME1'] ?>', '<?= $result_seEmployee['STATUSNUMBER'] ?>', '<?= $result_seEmployee['VEHICLEREGISNUMBER1'] ?>', '<?= $result_seEmployee['THAINAME'] ?>')" type="button" class="btn btn-default btn-circle" data-toggle="modal" data-target=".bd-example-modal-lg"><span class="glyphicon glyphicon-plus"></span></button>

                                                    </span>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
        </div>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../dist/js/sb-admin-2.js"></script>
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script src="../js/jquery.datetimepicker.full.js"></script>
    <script src="../dist/js/jszip.min.js"></script>
    <script src="../dist/js/dataTables.buttons.min.js"></script>
    <script src="../dist/js/buttons.html5.min.js"></script>
    <script src="../dist/js/buttons.print.min.js"></script>
    <script src="../dist/js/jquery.autocomplete.js"></script>
</body>

<script>

                                                        function save_mileage(editableObj, mileagetype, vehicleregisternumber1, jobno)
                                                        {

                                                            $.ajax({
                                                                url: 'meg_data.php',
                                                                type: 'POST',
                                                                data: {
                                                                    txt_flg: "save_mileage", mileageid: '', vehicleregisternumber1: vehicleregisternumber1, jobno: jobno, editableObj: editableObj.innerHTML, mileagetype: mileagetype
                                                                },

                                                                success: function () {
                                                                  
                                                                }
                                                            });


                                                        }
                                                        function edit_vehicletransportplan(editableObj, fieldname, ID)
                                                        {

                                                            $.ajax({
                                                                url: 'meg_data.php',
                                                                type: 'POST',
                                                                data: {
                                                                    txt_flg: "edit_vehicletransportplan", editableObj: editableObj.innerHTML, ID: ID, fieldname: fieldname
                                                                },

                                                                success: function () {

                                                                }
                                                            });


                                                        }

                                                        function update_jobstatus()
                                                        {

                                                            $.ajax({
                                                                type: 'post',
                                                                url: 'meg_data.php',
                                                                data: {
                                                                    txt_flg: "update_jobstatus"
                                                                },
                                                                success: function () {
                                                                    window.location.reload();
                                                                }
                                                            });
                                                        }




                                                        function closeWin() {
                                                            window.location.reload();
                                                        }
                                                        function check(jobno, rootno, status, statusnumber) {

                                                            $.ajax({
                                                                type: 'post',
                                                                url: 'meg_data.php',
                                                                data: {
                                                                    txt_flg: "select_vehicletransportplanid", jobno: jobno
                                                                },
                                                                success: function (vehicletransportplanid) {
                                                                    update_vehicletransportplanjob(rootno, statusnumber);
                                                                }

                                                            });
                                                        }
                                                        function uncheck(rootno, status, statusnumber) {
                                                            update_vehicletransportplanjob(rootno, statusnumber);
                                                        }



                                                        function update_vehicletransportplanjob(rootno, statusnumber)
                                                        {

                                                            $.ajax({
                                                                type: 'post',
                                                                url: 'meg_data.php',
                                                                data: {
                                                                    txt_flg: "edit_vehicletransportplanjob", rootno: rootno, statusnumber: statusnumber
                                                                },
                                                                success: function () {

                                                                    //window.location.reload();
                                                                }
                                                            });
                                                        }

                                                        function showdata_employee(employeecode1, employeecode2, employeename, statusnumber)
                                                        {

                                                            $.ajax({
                                                                type: 'post',
                                                                url: 'meg_data.php',
                                                                data: {
                                                                    txt_flg: "select_vehicletransportemployee", employeecode1: employeecode1, employeecode2: employeecode2, employeename: employeename, statusnumber: statusnumber
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
                                                                            order: [[0, "desc"]]
                                                                        });
                                                                        $("#txt_dateworking").datetimepicker({
                                                                            dateFormat: 'Y-m-d',
                                                                            timeFormat: "HH:mm"
                                                                        });
                                                                        $('[data-toggle="popover"]').popover({
                                                                            html: true,
                                                                            content: function () {
                                                                                return $('#popover-content').html();
                                                                            }
                                                                        });
                                                                    });
                                                                }
                                                            });
                                                        }
                                                        function showdata_employeefooter(employeecode1, employeecode2, companycode, customercode)
                                                        {

                                                            $.ajax({
                                                                type: 'post',
                                                                url: 'meg_data.php',
                                                                data: {
                                                                    txt_flg: "select_vehicletransportemployeefooter", companycode: companycode, customercode: customercode, employeecode1: employeecode1, employeecode2: employeecode2
                                                                },
                                                                success: function (response) {
                                                                    if (response)
                                                                    {
                                                                        document.getElementById("datasrfooter").innerHTML = response;
                                                                        document.getElementById("datadeffooter").innerHTML = "";
                                                                    }
                                                                }
                                                            });
                                                        }
                                                        function select_companycustomer(employeecode1, employeecode2, employeename, statusnumber)
                                                        {
                                                            $.ajax({
                                                                type: 'post',
                                                                url: 'meg_data.php',
                                                                data: {
                                                                    txt_flg: "select_companycustomer", employeename: employeename
                                                                },
                                                                success: function (response) {

                                                                    var result = response.split('|');
                                                                    showdata_employee(employeecode1, employeecode2, employeename, statusnumber);
                                                                    showdata_employeefooter(employeecode1, employeecode2, result[0], result[1]);
                                                                }
                                                            });
                                                        }

                                                        function select_employee(employeecode1, employeecode2, employeename, statusnumber, vehicleregisnumber, thainame) {

                                                            select_companycustomer(employeecode1, employeecode2, employeename, statusnumber);
                                                            $(document).ready(function () {
                                                                document.getElementById("employee").innerHTML = 'ทะเบียนรถ : ' + vehicleregisnumber + ' (' + thainame + ')';
                                                                /*document.getElementById("employeeimage").innerHTML = '';
                                                                 var img = document.createElement("img");
                                                                 img.src = src;
                                                                 img.width = 100;
                                                                 img.height = 60;
                                                                 document.getElementById("employeeimage").appendChild(img);
                                                                 */
                                                            });
                                                        }

</script>

<script>
    $(function () {
        $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
        // กรณีใช้แบบ input
        $(".dateen").datetimepicker({
            timepicker: false,
            format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
            lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


        }
        );
    });</script>
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

</html>
<?php
sqlsrv_close($conn);
?>