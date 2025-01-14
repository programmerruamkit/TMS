
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
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
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
                            รายงานข้อมูลจำนวนเครื่องยนต์ที่ขนส่งให้กับ บริษัท โตโยต้า มอเตอร์ ประเทศไทย(สำนักงานใหญ่)


                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">



                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <!-- Nav tabs -->


                                <!-- Tab panes -->
                                <div class="tab-content">
                                  <!-- ///////////////////////////////STM-TMT/////////////////////////////////////////// -->
                                    <div class="tab-pane fade in active" id="engine_tmt">
                                        <div class="row">&nbsp;</div>
                                          <div class="row" >
                                            <div class="col-lg-12">
                                              <div class="well">
                                                  <div class="row">

                                                      <div class="col-lg-2">

                                                          <div class="form-group">
                                                              <label>ค้นหาตามช่วงวันที่tmt</label>
                                                              <input class="form-control dateen" readonly="" onchange="datetodatetmt();" style="background-color: #f080802e"  id="txt_datestarttmt" name="txt_datestarttmt" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">

                                                          </div>

                                                      </div>
                                                      <div class="col-lg-2">
                                                          <label>&nbsp;</label>
                                                          <div class="form-group">
                                                              <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateendtmt" name="txt_dateendtmt" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">

                                                          </div>
                                                      </div>
                                                      <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <select id="select_cus" name="select_cus" class="form-control" onchange="select_thainame(this.value)">
                                                            <option value="">เลือกบริษัท</option>
                                                            <option value="TMT">STM-SR</option>
                                                            <option value="TAW">STM-TAW</option>
                                                            <option value="STM">STM-IP</option>
                                                        </select>

                                                      </div>
                                                      <!-- <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div id="datacompdef">
                                                          <select id="select_thainame" name="select_thainame" class="form-control">
                                                              <option value="">เลือกทะเบียนรถ</option>

                                                          </select>
                                                        </div>
                                                        <div id="datacompsr"></div>
                                                      </div> -->


                                                      <div class="col-lg-2">
                                                          <label>&nbsp;</label>
                                                          <div class="form-group">
                                                              <button type="button" class="btn btn-default" onclick="select_reportengine();">ค้นหา <li class="fa fa-search"></li></button>
                                                          </div>

                                                      </div>

                                                      <div class="col-lg-4" style="text-align: right">
                                                          <label>&nbsp;</label><br>
                                                          <a href="#" onclick="pdf_reportengine();" class="btn btn-default">พิมพ์ PDF <li class="fa fa-file-pdf-o"></li></a>
                                                          <a href="#" onclick="excel_reportengine();" class="btn btn-default">พิมพ์ EXCEL <li class="fa fa-file-excel-o"></li></a>

                                                      </div>

                                                  </div>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                        รายงาน Engine Delivery TMT
                                                    </div>
                                                    <!-- /.panel-heading -->

                                                    <div class="panel-body">

                                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                            <div id="data_def1">
                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                  <thead>
                                                                      <tr>
                                                                          <th style="text-align: center" rowspan="2">ลำดับTMT</th>
                                                                          <th style="text-align: center" rowspan="2">ทะเบียนรถ</th>
                                                                          <th style="text-align: center" colspan="3">PLANT (จำนวนเครื่องยนต์)</th>
                                                                          <th style="text-align: center" colspan="2" colspan="2">Total</th>

                                                                          </th>

                                                                      </tr>
                                                                      <tr>
                                                                          <th style="text-align: center">STM1-A</th>
                                                                          <th style="text-align: center">STM1-E</th>
                                                                          <th style="text-align: center">STM1-F</th>
                                                                          <th style="text-align: center"></th>
                                                                      </tr>
                                                                  </thead>
                                                                  <tbody>
                                                                          <tr>
                                                                              <td style="text-align: center"></td>
                                                                              <td></td>
                                                                              <td></td>
                                                                              <td></td>
                                                                              <td></td>
                                                                          </tr>
                                                                  </tbody>
                                                                </table>
                                                            </div>
                                                            <div id="data_sr1"></div>

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
            <script src="../dist/js/jquery.autocomplete.js"></script>
            <script src="../dist/js/bootstrap-select.js"></script>

            <script type="text/javascript">
                                                                                    function select_thainametmt()
                                                                                    {
                                                                                        $('.selectpicker').on('changed.bs.select', function () {
                                                                                            document.getElementById('txt_copydiagramthainametmt').value = $(this).val();
                                                                                          ;
                                                                                        });

                                                                                    }


                                                                                    function select_thainame(customercode)
                                                                                    {
                                                                                      // alert(customercode);
                                                                                        $.ajax({
                                                                                            type: 'post',
                                                                                            url: 'meg_data.php',
                                                                                            data: {
                                                                                                txt_flg: "select_thainame", customercode:customercode
                                                                                            },
                                                                                            success: function (response) {
                                                                                                if (response){

                                                                                                  document.getElementById("datacompsr").innerHTML = response;
                                                                                                  document.getElementById("datacompdef").innerHTML = "";


                                                                                                }
                                                                                            }
                                                                                        });

                                                                                    }

                                                                                    function pdf_reportengine()
                                                                                    {
                                                                                      var datestart = document.getElementById('txt_datestarttmt').value;
                                                                                      var dateend = document.getElementById('txt_dateendtmt').value;
                                                                                      var customercode = document.getElementById('select_cus').value;
                                                                                      // var thainame = document.getElementById('select_thainame').value;

                                                                                      // alert(datestart);
                                                                                      // alert(dateend);
                                                                                      // alert(customercode);
                                                                                      // alert(thainame);
                                                                                          window.open('pdf_reportengine.php?datestart=' + datestart + '&dateend=' + dateend + '&customercode=' + customercode, '_blank');

                                                                                    }

                                                                                    function excel_reportengine()
                                                                                    {
                                                                                      var datestart = document.getElementById('txt_datestarttmt').value;
                                                                                      var dateend = document.getElementById('txt_dateendtmt').value;
                                                                                      var customercode = document.getElementById('select_cus').value;
                                                                                      // var thainame = document.getElementById('select_thainame').value;

                                                                                      // alert(datestart);
                                                                                      // alert(dateend);
                                                                                      // alert(customercode);
                                                                                      // alert(thainame);
                                                                                          window.open('excel_reportengine.php?datestart=' + datestart + '&dateend=' + dateend + '&customercode=' + customercode, '_blank');

                                                                                    }




                                                                                    function select_reportengine(){

                                                                                      var datestart = document.getElementById('txt_datestarttmt').value;
                                                                                      var dateend = document.getElementById('txt_dateendtmt').value;
                                                                                      var customercode = document.getElementById('select_cus').value;
                                                                                      // var thainame = document.getElementById('select_thainame').value;

                                                                                      // alert(datestart);
                                                                                      // alert(dateend);
                                                                                      // alert(customercode);
                                                                                      // alert(thainame);


                                                                                        $.ajax({
                                                                                            type: 'post',
                                                                                            url: 'meg_data.php',
                                                                                            data: {
                                                                                                txt_flg: "select_reportengine", date_start: datestart, date_end: dateend,customercode: customercode
                                                                                            },
                                                                                            success: function (response) {

                                                                                                if (response)
                                                                                                {
                                                                                                    document.getElementById("data_sr1").innerHTML = response;
                                                                                                    document.getElementById("data_def1").innerHTML = "";

                                                                                                }
                                                                                                $(document).ready(function () {
                                                                                                    $('#dataTables-example1').DataTable({
                                                                                                        responsive: true,
                                                                                                        order: [[0, "desc"]]
                                                                                                    });
                                                                                                });

                                                                                            }
                                                                                        });
                                                                                    }


                function datetodatetmt()
                {
                    document.getElementById('txt_dateendtmt').value = document.getElementById('txt_datestarttmt').value;

                }
                function datetodatetaw()
                {
                    document.getElementById('txt_dateendtaw').value = document.getElementById('txt_datestarttaw').value;

                }
                function datetodatestm()
                {
                    document.getElementById('txt_dateendstm').value = document.getElementById('txt_datestartstm').value;
                    // select_reporttenko2();
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
                    $('#dataTables-example1').DataTable({
                        responsive: true,
                        order: [[0, "desc"]]
                    });
                });
                $(document).ready(function () {
                    $('#dataTables-example2').DataTable({
                        responsive: true,
                        order: [[0, "desc"]]
                    });
                });
                $(document).ready(function () {
                    $('#dataTables-example3').DataTable({
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
