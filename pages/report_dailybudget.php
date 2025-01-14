
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

$condition1 = " AND (a.USERNAME ='" . $_SESSION["USERNAME"] . "' AND a.PASSWORD = '" . $_SESSION["PASSWORD"] . "') AND a.ACTIVESTATUS = 1";
$sql_seLogin = "{call megRoleaccount_v2(?,?)}";
$params_seLogin = array(
    array('select_roleaccount', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seLogin = sqlsrv_query($conn, $sql_seLogin, $params_seLogin);
$result_seLogin = sqlsrv_fetch_array($query_seLogin, SQLSRV_FETCH_ASSOC);
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

        <!-- data table css -->
        <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">

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

            #loading {
                display:none; 
                opacity: 0.5;
                /* border-radius: 50%; */
                /* border-top: 12px ; */
                width: 10px;
                left: 10px;
                right: 800px;
                top:10px;
                bottom: 450px;
                height: 10px;
                
                /* animation: spin 1s linear infinite; */
            }
            
            .center {
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                margin: auto;
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
                            รายงานปิดงบประมาณรายวัน


                        </h2>
                    </div>

                    <!-- /.col-lg-12 -->
                </div>

                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">


                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <!-- Tab panes -->
                                <div class="tab-content">




                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #e7e7e7">
                                                    รายงานปิดงบประมาณรายวัน
                                                </div>
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">
                                                  <ul class="nav nav-pills">
                                                      <li class="active"><a href="#budget" data-toggle="tab">รายงานปิดงบประมาณรายวัน</a>
                                                      </li>
                                                      <li><a href="#budget_pallet" data-toggle="tab">รายงานปิดงบประมาณรายวัน(พาเลท)</a>
                                                      </li>

                                                  </ul>



                                                <div class="tab-content">
                                                    <div class="tab-pane fade in active" id="budget">
                                                      <div class="panel-heading" style="background-color: #e7e7e7">รายงานปิดงบประมาณรายวัน (SUMMARY)</div>
                                                        <div class="row" >
                                                            <div class="col-lg-12">
                                                                <div class="well">
                                                                    <div class="row">
                                                                        <div class="col-lg-2">
                                                                            <label>&nbsp;</label>
                                                                            <select id="select_com2" name="select_com2" class="form-control">
                                                                                <option value="RKR">ร่วมกิจรุ่งเรือง (1993)</option>
                                                                                <option value="RKS">ร่วมกิจรุ่งเรือง เซอร์วิส</option>
                                                                                <option value="RCC">ร่วมกิจรุ่งเรือง คาร์ แคริเออร์</option>
                                                                                <option value="RRC">ร่วมกิจรีไซเคิล แคริเออร์</option>
                                                                                <option value="RKL">ร่วมกิจรุ่งเรือง โลจิสติคส์</option>
                                                                                <option value="RATC">ร่วมกิจออโตโมทีฟ ทรานสปอร์ต</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-lg-2">

                                                                            <div class="form-group">
                                                                                <label>ค้นหาตามช่วงวันที่</label>
                                                                                <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestart2" name="txt_datestart2" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">

                                                                            </div>

                                                                        </div>
                                                                        <div class="col-lg-2">
                                                                            <label>&nbsp;</label>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateend2" name="txt_dateend2" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2">
                                                                            <label>&nbsp;</label>
                                                                            <div class="form-group">
                                                                                <button type="button" class="btn btn-default" onclick="report_dailybudgetsummary();">ค้นหา <li class="fa fa-search"></li></button>
                                                                            </div>

                                                                        </div>




                                                                        <!-- <div class="col-lg-4" style="text-align: right">
                                                                            <label>&nbsp;</label><br>
                                                                            <a href="#" onclick="excel_reportdailybudgetsummary();" class="btn btn-default">พิมพ์ <li class="fa fa-print"></li></a>

                                                                        </div> -->


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12" >
                                                              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                                <div id="datasumdef">
                                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-examplesummary2" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                        <thead>
                                                                            <tr>


                                                                                <th >COMPANY</th>
                                                                                <th >CUSTOMER</th>
                                                                                <th >TRIP</th>
                                                                                <th >TON</th>
                                                                                <th >SALE PRICE</th>
                                                                                <th >DROP</th>
                                                                                <th >FUEL(L)</th>
                                                                                <th >FUEL(Bth)</th>
                                                                                <th >TOLLFEE</th>
                                                                                <th >WORKING INCENTIVE</th>
                                                                                <th >FULE INCENTIVE</th>
                                                                                <th >REPAIR</th>
                                                                                <th >TOTAL</th>
                                                                                <th >DEP</th>
                                                                                <th >EVA</th>
                                                                                <th >PROFIT%</th>


                                                                            </tr>
                                                                        </thead>

                                                                    </table>
                                                                </div>
                                                                <div id="datasumsr"></div>
                                                            </div>
                                                            <!-- /.panel-body -->
                                                        </div>
                                                    </div>

                                                </div> <!--end tap panel-->
                                                <!-- รานงานปิดงบปนะมาณ PALLET -->
                                                <div class="tab-pane" id="budget_pallet">
                                                  <div class="panel-heading" style="background-color: #e7e7e7">รายงานปิดงบประมาณรายวันพาเลท (SUMMARY)</div>
                                                    <div class="row" >
                                                        <div class="col-lg-12">
                                                            <div class="well">
                                                                <div class="row">
                                                                    <div class="col-lg-2">
                                                                        <label>&nbsp;</label>
                                                                        <select id="select_compallet" name="select_compallet" class="form-control">
                                                                            <option value="RKR">ร่วมกิจรุ่งเรือง (1993)</option>
                                                                            <option value="RKL">ร่วมกิจรุ่งเรือง โลจิสติคส์</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-lg-2">

                                                                        <div class="form-group">
                                                                            <label>ค้นหาตามช่วงวันที่</label>
                                                                            <input class="form-control dateen" readonly="" onchange="datetodate2();" style="background-color: #f080802e"  id="txt_datestartpallet" name="txt_datestartpallet" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">

                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <label>&nbsp;</label>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateendpallet" name="txt_dateendpallet" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <label>&nbsp;</label>
                                                                        <div class="form-group">
                                                                            <button type="button" class="btn btn-default" onclick="report_dailybudgetsummarypallet();">ค้นหา <li class="fa fa-search"></li></button>
                                                                        </div>

                                                                    </div>




                                                                    <!-- <div class="col-lg-4" style="text-align: right">
                                                                        <label>&nbsp;</label><br>
                                                                        <a href="#" onclick="excel_reportdailybudgetsummary();" class="btn btn-default">พิมพ์ <li class="fa fa-print"></li></a>

                                                                    </div> -->


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12" >
                                                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                            <div id="datasumdefpallet">
                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-examplesummary" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th >COMPANY</th>
                                                                            <th >CUSTOMER</th>
                                                                            <th >AMOUNT</th>
                                                                            <th >SALEPRICE</th>
                                                                        </tr>
                                                                    </thead>

                                                                </table>
                                                            </div>
                                                            <div id="datasumsrpallet"></div>
                                                        </div>
                                                        <!-- /.panel-body -->
                                                    </div>
                                                </div>

                                            </div> <!--end tap panel budget_pallet-->
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


            <!-- this will show our spinner -->
            <div  id="loading" class="center" >
                <p><img style="" src="../images/truckload5.gif" /></p>
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

            <!-- Data Table Export File -->
            <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
            <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
            <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
            <!-- <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script> -->
            <script src="//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json"></script>


            <script>

                                                                function showLoading() {
                                                                    $("#loading").show();
                                                                    
                                                                }

                                                                function hideLoading() {
                                                                    $("#loading").hide();
                                                                }
                                                                function save_logprocess(category, process, employeecode)
                                                                {
                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "save_logprocess", category: category, process: process, employeecode: employeecode
                                                                        },
                                                                        success: function () {


                                                                        }
                                                                    });
                                                                }
                                                                                    function report_dailybudgetdetail(customercode)
                                                                                    {
                                                                                        var datestart = document.getElementById('txt_datestart2').value;
                                                                                        var dateend = document.getElementById('txt_dateend2').value;
                                                                                        var companycode = document.getElementById('select_com2').value;

                                                                                        window.open('report_dailybudgetdetail.php?datestart=' + datestart + '&dateend=' + dateend + '&companycode=' + companycode + '&customercode=' + customercode, '_blank');


                                                                                    }

                                                                                    function report_dailybudgetdetailpallet(customercode)
                                                                                    {
                                                                                        var datestart = document.getElementById('txt_datestartpallet').value;
                                                                                        var dateend = document.getElementById('txt_dateendpallet').value;
                                                                                        var companycode = document.getElementById('select_compallet').value;

                                                                                        window.open('report_dailybudgetdetailpallet.php?datestart=' + datestart + '&dateend=' + dateend + '&companycode=' + companycode + '&customercode=' + customercode, '_blank');


                                                                                    }

                                                                                    function select_customer(companycode)
                                                                                    {


                                                                                        $.ajax({
                                                                                            type: 'post',
                                                                                            url: 'meg_data.php',
                                                                                            data: {
                                                                                                txt_flg: "select_customercompensation", companycode: companycode
                                                                                            },
                                                                                            success: function (response) {
                                                                                                if (response) {

                                                                                                    document.getElementById("datacompsr").innerHTML = response;
                                                                                                    document.getElementById("datacompdef").innerHTML = "";

                                                                                                }




                                                                                            }
                                                                                        });



                                                                                    }

                                                                                    function report_dailybudgetsummary()
                                                                                    {
                                                                                        // loadData();
                                                                                        showLoading();

                                                                                        save_logprocess('Report', 'SELECT รายงานปิดงบประมาณรายวัน', '<?= $result_seLogin['PersonCode'] ?>');
                                                                                        var companycode = document.getElementById('select_com2').value;
                                                                                        var datestart = document.getElementById('txt_datestart2').value;
                                                                                        var dateend = document.getElementById('txt_dateend2').value;

                                                                                        $.ajax({
                                                                                            type: 'post',
                                                                                            url: 'meg_data_reportdailybudget.php',
                                                                                            data: {
                                                                                                txt_flg: "select_reportdailybudgetsummary", companycode: companycode, datestart: datestart, dateend: dateend
                                                                                            },
                                                                                            success: function (response) {
                                                                                                hideLoading();
                                                                                                if (response)
                                                                                                {
                                                                                                    document.getElementById("datasumsr").innerHTML = response;
                                                                                                    document.getElementById("datasumdef").innerHTML = "";
                                                                                                }
                                                                                                $(document).ready(function () {
                                                                                                    $('#dataTables-examplesummary2').DataTable({
                                                                                                        order: [[2, 'desc']],
                                                                                                        // responsive: true,
                                                                                                        scrollX: true,
                                                                                                        scrollY: '500px',
                                                                                                        charset: 'UTF-8',
                                                                                                        fieldSeparator: ';',
                                                                                                        bom: true,
                                                                                                        dom: 'Bfrtip',
                                                                                                        lengthMenu: [
                                                                                                            [ 10, 15, 20, -1 ],
                                                                                                            [ '10 rows', '15 rows', '20 rows', 'Show all' ]
                                                                                                        ],
                                                                                                        buttons: [
                                                                                                            { extend: 'pageLength'},
                                                                                                            { extend: 'csvHtml5', footer: true },
                                                                                                            { extend: 'excelHtml5', footer: true }
                                                                                                            // 'pageLength','csv', 'excel'
                                                                                                        ]
                                                                                                    });
                                                                                                });

                                                                                            }
                                                                                        });
                                                                                        //}

                                                                                    }

                                                                                    function report_dailybudgetsummarypallet()
                                                                                    {

                                                                                        // loadData();
                                                                                        showLoading();

                                                                                        save_logprocess('Report', 'SELECT รายงานปิดงบประมาณรายวัน(พาเลท)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                                        var companycode = document.getElementById('select_compallet').value;
                                                                                        var datestart = document.getElementById('txt_datestartpallet').value;
                                                                                        var dateend = document.getElementById('txt_dateendpallet').value;

                                                                                        // alert(companycode);
                                                                                        // alert(datestart);
                                                                                        // alert(dateend);
                                                                                        $.ajax({
                                                                                            type: 'post',
                                                                                            url: 'meg_data_reportdailybudget.php',
                                                                                            data: {
                                                                                                txt_flg: "select_reportdailybudgetsummarypallet", companycode: companycode, datestart: datestart, dateend: dateend
                                                                                            },
                                                                                            success: function (response) {
                                                                                                hideLoading();
                                                                                                if (response)
                                                                                                {
                                                                                                    document.getElementById("datasumsrpallet").innerHTML = response;
                                                                                                    document.getElementById("datasumdefpallet").innerHTML = "";
                                                                                                }
                                                                                                $(document).ready(function () {
                                                                                                    $('#dataTables-examplesummary').DataTable({
                                                                                                        order: [[2, 'desc']],
                                                                                                        // responsive: true,
                                                                                                        scrollX: true,
                                                                                                        scrollY: '500px',
                                                                                                        charset: 'UTF-8',
                                                                                                        fieldSeparator: ';',
                                                                                                        bom: true,
                                                                                                        dom: 'Bfrtip',
                                                                                                        lengthMenu: [
                                                                                                            [ 10, 15, 20, -1 ],
                                                                                                            [ '10 rows', '15 rows', '20 rows', 'Show all' ]
                                                                                                        ],
                                                                                                        buttons: [
                                                                                                            { extend: 'pageLength'},
                                                                                                            { extend: 'csvHtml5', footer: true },
                                                                                                            { extend: 'excelHtml5', footer: true }
                                                                                                            // 'pageLength','csv', 'excel'
                                                                                                        ]
                                                                                                    });
                                                                                                });



                                                                                            }
                                                                                        });


                                                                                    }

                                                                                    function excel_reportdailybudgetsummary()
                                                                                    {
                                                                                        save_logprocess('Report', 'Excel รายงานปิดงบประมาณรายวัน', '<?= $result_seLogin['PersonCode'] ?>');
                                                                                        var datestart = document.getElementById('txt_datestart2').value;
                                                                                        var dateend = document.getElementById('txt_dateend2').value;
                                                                                        var companycode = document.getElementById('select_com2').value;

                                                                                        // alert(datestart);
                                                                                        // alert(dateend);
                                                                                        // alert(companycode);
                                                                                        window.open('excel_reportdailybudgetsummary.php?datestart=' + datestart + '&dateend=' + dateend + '&companycode=' + companycode, '_blank');


                                                                                    }
                                                                                    function gdatetodate()
                                                                                    {
                                                                                        document.getElementById('txt_dateend2').value = document.getElementById('txt_datestart2').value;
                                                                                    }
                                                                                    function datetodate()
                                                                                    {
                                                                                        document.getElementById('txt_dateend2').value = document.getElementById('txt_datestart2').value;

                                                                                    }
                                                                                    function datetodate2()
                                                                                    {
                                                                                        document.getElementById('txt_dateendpallet').value = document.getElementById('txt_datestartpallet').value;

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
                                                                                            order: [[0, "desc"]],
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-examplesummary').DataTable({
                                                                                            responsive: true,
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-examplesummary2').DataTable({
                                                                                            responsive: true,
                                                                                        });
                                                                                    });

            </script>


    </body>

</html>

<?php
sqlsrv_close($conn);
?>
