
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
                            รายงานค่าอาหาร


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

                                        รายงานค่าอาหาร

                                    </div>
                                    <div class="col-lg-6 text-right"></div>
                                </div>
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <ul class="nav nav-pills">
                                    <li class="active"><a href="#foodall" data-toggle="tab">รายงานค่าอาหาร (รายบริษัท)</a>
                                    </li>
                                    <li><a href="#foodemployee" data-toggle="tab">รายงานค่าอาหาร (รายบุคคล)</a>
                                    </li>


                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="foodall">
                                        <div class="row">&nbsp;</div>
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <div class="well">
                                                    <div class="row">


                                                        <div class="col-lg-2">

                                                            <div class="form-group">
                                                                <label>ค้นหาตามช่วงวันที่</label>
                                                                <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateend" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <select id="select_com" name="select_com" class="form-control">
                                                                
                                                                <?php
                                                                $cond = ($_GET['area'] == 'gateway') ? " AND Company_Code IN ('RRC','RATC','RCC')" : " AND Company_Code IN ('RKS','RKR','RKL','RIT','RTC','RTD')";
                                                                $sql_seCompany = "{call megCompany_v2(?,?)}";
                                                                $params_seCompany = array(
                                                                    array('select_company', SQLSRV_PARAM_IN),
                                                                    array($cond, SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
                                                                while ($result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <option value="<?= $result_seCompany['ID_Company'] ?>"><?= $result_seCompany['Company_NameT'] ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>


                                                        </div>
                                                       
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <!--<button type="button" class="btn btn-default" onclick="select_process();">Process <li class="fa fa-calculator"></li></button>-->
                                                                <button type="button" class="btn btn-default" onclick="select_foodcompensation();">ค้นหา <li class="fa fa-search"></li></button>
                                                            </div>

                                                        </div>
                                                       



                                                        <div class="col-lg-4" style="text-align: right">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="excel_foodcompensation();" class="btn btn-default">พิมพ์ <li class="fa fa-print"></li></a>

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

                                                                            <th style="width:  10%">ลำดับ</th>
                                                                            <th>วันที่/เวลา(ไป)</th>
                                                                                                            <th>วันที่/เวลา(กลับ)</th>
                                                                            
                                                                            <th>บริษัท</th>
                                                                            <th>รหัสพนักงาน</th>
                                                                            <th>ชื่อ-นามสกุล</th>
                                                                            <th>จำนวนเงิน</th>
                                                                            <th>หมายเหตุ</th>
                                                                            



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
                                    <div class="tab-pane fade" id="foodemployee">
                                        <div class="row">&nbsp;</div>
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <div class="well">
                                                    <div class="row">


                                                        <div class="col-lg-2">

                                                            <div class="form-group">
                                                                <label>ค้นหาตามช่วงวันที่</label>
                                                                <input class="form-control dateen" readonly="" onchange="datetodate2();" style="background-color: #f080802e"  id="txt_datestart2" name="txt_datestart2" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateend2" name="txt_dateend2" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <label>รหัสพนักงาน</label>
                                                            <input type="text" id="txt_employeecode2" name="txt_employeecode2" class="form-control">


                                                        </div>
                                                       
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <!--<button type="button" class="btn btn-default" onclick="select_process2();">Process <li class="fa fa-calculator"></li></button>-->
                                                                <button type="button" class="btn btn-default" onclick="select_foodcompensation2();">ค้นหา <li class="fa fa-search"></li></button>
                                                            </div>

                                                        </div>
                                                        


                                                        <div class="col-lg-4" style="text-align: right">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="excel_foodcompensation2();" class="btn btn-default">พิมพ์ <li class="fa fa-print"></li></a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                        รายงานค่าอาหาร (รายบุคคล)
                                                    </div>
                                                    <!-- /.panel-heading -->

                                                    <div class="panel-body">

                                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                            <div id="datadef2">
                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example2" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>

                                                                            <th style="width:  10%">ลำดับ</th>
                                                                            <th>วันที่/เวลา(ไป)</th>
                                                                                                            <th>วันที่/เวลา(กลับ)</th>
                                                                            
                                                                            <th>บริษัท</th>
                                                                            <th>รหัสพนักงาน</th>
                                                                            <th>ชื่อ-นามสกุล</th>
                                                                            <th>จำนวนเงิน</th>
                                                                            <th>หมายเหตุ</th>
                                                                            



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
                                                                
                                                                function select_foodcompensation()
                                                                {


                                                                    var datestart = document.getElementById('txt_datestart').value;
                                                                    var dateend = document.getElementById('txt_dateend').value;
                                                                    var companycode = document.getElementById('select_com').value;
                                                                    // alert(datestart);
                                                                    // alert(datestart);
                                                                    // alert(companycode);

                                                                   
                                                                    $.ajax({
                                                                        type: 'post',
                                                                        url: 'meg_data.php',
                                                                        data: {
                                                                            txt_flg: "select_foodcompensationnew", datestart: datestart, dateend: dateend, companycode: companycode
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
                                                                function select_foodcompensation2()
                                                                {


                                                                    var datestart = document.getElementById('txt_datestart2').value;
                                                                    var dateend = document.getElementById('txt_dateend2').value;
                                                                    var employeecode = document.getElementById('txt_employeecode2').value;
                                                                   
                                                                    if (employeecode != '')
                                                                    {
                                                                        // alert(datestart);
                                                                        // alert(datestart);
                                                                        // alert(companycode);
                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_foodcompensationnew2", datestart: datestart, dateend: dateend, employeecode: employeecode
                                                                            },
                                                                            success: function (response) {
                                                                                if (response)
                                                                                {
                                                                                    document.getElementById("datasr2").innerHTML = response;
                                                                                    document.getElementById("datadef2").innerHTML = "";
                                                                                }
                                                                                $(document).ready(function () {
                                                                                    $('#dataTables-example2').DataTable({
                                                                                        responsive: true
                                                                                    });
                                                                                });



                                                                            }
                                                                        });
                                                                    } else
                                                                    {
                                                                        alert('กรุณากรอกรหัสพนักงาน !');
                                                                        document.getElementById("txt_employeecode2").focus();
                                                                    }

                                                                }
                                                                function excel_foodcompensation2()
                                                                {
                                                                    var datestart = document.getElementById('txt_datestart2').value;
                                                                    var dateend = document.getElementById('txt_dateend2').value;
                                                                    var employeecode = document.getElementById('txt_employeecode2').value;
                                                                   

                                                                    window.open('excel_foodcompensationnew2.php?datestart=' + datestart + '&dateend=' + dateend + '&employeecode=' + employeecode, '_blank');

                                                                }
                                                                function excel_foodcompensation()
                                                                {
                                                                    var datestart = document.getElementById('txt_datestart').value;
                                                                    var dateend = document.getElementById('txt_dateend').value;
                                                                    var companycode = document.getElementById('select_com').value;
                                                                    

                                                                    window.open('excel_foodcompensationnew.php?datestart=' + datestart + '&dateend=' + dateend + '&companycode=' + companycode, '_blank');

                                                                }
                                                                
                                                                function gdatetodate()
                                                                {
                                                                    document.getElementById('txt_gdateend').value = document.getElementById('txt_gdatestart').value;
                                                                }
                                                                function datetodate()
                                                                {
                                                                    document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

                                                                }
                                                                function gdatetodate2()
                                                                {
                                                                    document.getElementById('txt_gdateend2').value = document.getElementById('txt_gdatestart2').value;
                                                                }
                                                                function datetodate2()
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


    </body>

</html>

<?php
sqlsrv_close($conn);
?>
