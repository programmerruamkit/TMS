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
        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.min.js"></script>


        <link href="style/style.css" rel="stylesheet" type="text/css">

    </head>

    <body >
        <input  type="text" style="display: none" name="txt_employeecode" id="txt_employeecode" class="form-control" value="" >

        <div class="modal fade" id="modal_covid19" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 60%">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-5">
                                <h5 class="modal-title" id=""><b><span id="sp_employeecode"></span></b></h5>
                            </div>

                        </div>
                    </div>
                    <div id="modalcovid19sr"></div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_logincovid19" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 40%">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-5">
                                <h5 class="modal-title" id=""><b><span id="sp_employeecode"></span></b></h5>
                            </div>

                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-lg-12">
                                <label><font style="font-size: 28px">ชื่อ-สกุล (รปภ)</font></label>

                                <input autocomplete="off"  type="text" style="height: 100px;font-size: 50px"  name="txt_securityname" id="txt_securityname" class="form-control" value="" >

                            </div>






                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                        <button type="button" class="btn btn-primary" onclick="save_logincovid19()">บันทึก</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_reportcovid19" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 40%">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-5">
                                <h5 class="modal-title" id=""><b><span id="sp_employeecode"></span></b></h5>
                            </div>

                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-lg-6">
                                <label><font style="font-size: 28px">วันที่เริ่มต้น</font></label>

                                <input autocomplete="off" style="height: 100px;font-size: 50px" type="text" onchange="datetodate();"  name="txt_datestart" id="txt_datestart" class="form-control dateen" value="" >

                            </div>
                            <div class="col-lg-6">
                                <label><font style="font-size: 28px">วันที่สิ้นสุด</font></label>

                                <input autocomplete="off"  style="height: 100px;font-size: 50px" type="text"   name="txt_dateend" id="txt_dateend" class="form-control dateen" value="" >

                            </div>






                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                        <button type="button" class="btn btn-default" onclick="excel_covid19()">พิมพ์ <li class="fa fa-print"></li></button>
                    </div>

                </div>
            </div>
        </div>
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

            <div class="navbar-header" >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a>
            </div>

        </nav>





        <div class="row">

            <div class="col-lg-12">
                <div class="panel panel-default" >

                    <div class="panel-body">



                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <b>รายงานตัวตรวจร่างกาย Covid 19</b>
                                            </div>
                                            <div class="col-lg-6 text-right">
                                                <a href="#"  data-toggle="modal"  data-target="#modal_reportcovid19" class="btn btn-default">พิมพ์ <li class="fa fa-print"></li></a>
                                                <button onclick="claer_session()" type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ออกจากระบบ</button>
                                            </div>


                                        </div>
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">

                                        <div class="tab-content">

                                            <div class="row">







                                                <div class="col-md-12" >
                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                                        <div id="datadef">
                                                            <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;font-size: 36px">
                                                                <thead>
                                                                    <tr>

                                                                        <th>ชื่อ-สกุล</th>

                                                                        <th style="text-align: center"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $sql_seEmp = "{call megEmployeeEHR_v2(?,?)}";
                                                                    $params_seEmp = array(
                                                                        array('select_employee', SQLSRV_PARAM_IN),
                                                                        array("", SQLSRV_PARAM_IN)
                                                                    );


                                                                    $query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
                                                                    while ($result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC)) {
                                                                        ?>
                                                                        <tr class="odd gradeX">

                                                                            <td><?= $result_seEmp['PersonCode'] ?> : <?= $result_seEmp['nameT'] ?></td>

                                                                            <td style="text-align: center">
                                                                                <?php
                                                                                $sql_Createby = "SELECT CREATEBY FROM [dbo].[COVID19] WHERE CONVERT(DATE,CREATEDATE) = CONVERT(DATE,GETDATE())";
                                                                                $params_Createby = array();
                                                                                $query_Createby = sqlsrv_query($conn, $sql_Createby, $params_Createby);
                                                                                $result_Createby = sqlsrv_fetch_array($query_Createby, SQLSRV_FETCH_ASSOC);

                                                                                if ($_SESSION["securityname"] == '') {
                                                                                    ?>
                                                                                    <div class="btn-group">
                                                                                        <button type="button"  style="size: 50px;font-size: 36px" class="btn btn-primary"  data-toggle="modal"  data-target="#modal_logincovid19">เลือก</button>


                                                                                    </div>
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                    <div class="btn-group">
                                                                                        <button type="button"  style="size: 50px;font-size: 36px" class="btn btn-primary" onclick="modal_covid19('<?= $result_seEmp['PersonCode'] ?>', '<?= $result_seEmp['nameT'] ?>', '<?= $result_seEmp['Company_Code'] ?>')"  data-toggle="modal"  data-target="#modal_covid19">เลือก</button>


                                                                                    </div>
                                                                                    <?php
                                                                                }
                                                                                ?>

                                                                            </td>



                                                                        </tr>

                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div id="datasr"></div>

                                                    </div>
                                                </div>

                                                <!-- /.panel-body -->
                                            </div>



                                        </div>
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>

                        </div>

                        <!-- /.panel -->
                    </div>
                </div>
            </div>
        </div>



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

        <script type="text/javascript">

                                                                                            function claer_session()
                                                                                            {
                                                                                                $.ajax({
                                                                                                    url: 'meg_data.php',
                                                                                                    type: 'POST',
                                                                                                    data: {
                                                                                                        txt_flg: "claer_session"
                                                                                                    },
                                                                                                    success: function () {

                                                                                                        window.location.reload();


                                                                                                    }

                                                                                                });
                                                                                            }

                                                                                            function excel_covid19()
                                                                                            {
                                                                                                window.open('excel_covid19.php?datestart=' + document.getElementById('txt_datestart').value + '&dateend=' + document.getElementById('txt_dateend').value, '_blank');
                                                                                            }
                                                                                            function datetodate()
                                                                                            {
                                                                                                document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

                                                                                            }
                                                                                            function save_logincovid19()
                                                                                            {


                                                                                                var securityname = document.getElementById("txt_securityname").value;



                                                                                                if (securityname != '')
                                                                                                {
                                                                                                    $.ajax({
                                                                                                        url: 'meg_data.php',
                                                                                                        type: 'POST',
                                                                                                        data: {
                                                                                                            txt_flg: "save_covid19", covid19id: '', companycode: '', employeecode: securityname, temperature: '', alcohol: '',
                                                                                                            symptom1: '', symptom2: '', symptom3: '', symptom4: ''
                                                                                                        },
                                                                                                        success: function () {
                                                                                                            //alert('บันทึกข้อมูลเรียบร้อยแล้ว');
                                                                                                            window.location.reload();


                                                                                                        }

                                                                                                    });
                                                                                                }

                                                                                            }
                                                                                            function save_covid19(covid19id, companycode, employeecode)
                                                                                            {

                                                                                                var temperature = document.getElementById("txt_temperature").value;
                                                                                                var alcohol = '';
                                                                                                var symptom1 = '';
                                                                                                var symptom2 = '';
                                                                                                var symptom3 = '';
                                                                                                var symptom4 = '';


                                                                                                if (document.getElementById("chk_symptom1").checked == true) {

                                                                                                    symptom1 = '1';
                                                                                                } else
                                                                                                {
                                                                                                    symptom1 = '0';
                                                                                                }

                                                                                                if (document.getElementById("chk_symptom2").checked == true) {
                                                                                                    symptom2 = '1';
                                                                                                } else
                                                                                                {
                                                                                                    symptom2 = '0';
                                                                                                }
                                                                                                if (document.getElementById("chk_symptom3").checked == true) {
                                                                                                    symptom3 = '1';
                                                                                                } else
                                                                                                {
                                                                                                    symptom3 = '0';
                                                                                                }
                                                                                                if (document.getElementById("chk_symptom4").checked == true) {
                                                                                                    symptom4 = '1';
                                                                                                } else
                                                                                                {
                                                                                                    symptom4 = '0';
                                                                                                }

                                                                                                $.ajax({
                                                                                                    url: 'meg_data.php',
                                                                                                    type: 'POST',
                                                                                                    data: {
                                                                                                        txt_flg: "save_covid19", covid19id: covid19id, companycode: companycode, employeecode: employeecode, temperature: temperature, alcohol: alcohol,
                                                                                                        symptom1: symptom1, symptom2: symptom2, symptom3: symptom3, symptom4: symptom4
                                                                                                    },
                                                                                                    success: function () {

                                                                                                        //alert('ตรวจร่างกายเรียบร้อยแล้ว');
                                                                                                        window.location.reload();


                                                                                                    }

                                                                                                })



                                                                                            }
                                                                                            function modal_covid19(employeecode, employeename, companycode)
                                                                                            {
                                                                                                document.getElementById("sp_employeecode").innerHTML = employeecode + ' : ' + employeename;
                                                                                                $.ajax({
                                                                                                    url: 'meg_data.php',
                                                                                                    type: 'POST',
                                                                                                    data: {
                                                                                                        txt_flg: "modal_covid19", employeecode: employeecode, companycode: companycode
                                                                                                    },
                                                                                                    success: function (rs) {

                                                                                                        document.getElementById("modalcovid19sr").innerHTML = rs;


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



        </script>
        <script>

            $(document).ready(function () {
                $('#dataTables-example1').DataTable({
                    responsive: true,
                    "bLengthChange": false, //ปิด select box ที่ให้เลือก row per page

                    "oLanguage": {

                        "sSearch": "รหัสพนักงาน", // เปลี่ยน label คำว่า Search เป็น ค้นหา

                        "sInfo": "แสดงข้อมูลรายการที่ _START_ ถึง _END_ จากจำนวนข้อมูลทั้งหมด  _TOTAL_ รายการ ",

                        "oPaginate": {

                            "sPrevious": "รายการก่อนหน้า", // เปลี่ยน ในส่วนของการ control page

                            "sNext": "รายการถัดไป"

                        }

                    },

                });


            });
        </script>


    </body>

</html>
<?php
sqlsrv_close($conn);
?>
