
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

$condiCompany = " AND Company_Code = '" . $_GET['companycode'] . "'";
$sql_seCompany = "{call megCompany_v2(?,?)}";
$params_seCompany = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condiCompany, SQLSRV_PARAM_IN)
);
$query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
$result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);

$condiCustomer = " AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'";
$sql_seCustomer = "{call megCustomer_v2(?,?)}";
$params_seCustomer = array(
    array('select_customer', SQLSRV_PARAM_IN),
    array($condiCustomer, SQLSRV_PARAM_IN)
);
$query_seCustomer = sqlsrv_query($conn, $sql_seCustomer, $params_seCustomer);
$result_seCustomer = sqlsrv_fetch_array($query_seCustomer, SQLSRV_FETCH_ASSOC);
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
                            รายงานใบปะหน้า


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

                                        รายงานใบปะหน้า

                                    </div>
                                    <div class="col-lg-6 text-right"></div>
                                </div>
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <!-- Tab panes -->
                                <div class="tab-content">

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
                                                      <select id="select_com" name="select_com" class="form-control" onchange="select_customer(this.value)">
                                                          <option value="">เลือกบริษัท</option>
                                                          <option value="RKR">บริษัท ร่วมกิจรุ่งเรือง (1993)</option>
                                                          <option value="RKS">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส</option>
                                                          <option value="RKL">บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์ </option>
                                                      </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                      <label>เลือกลูกค้า</label>
                                                      <div id="datacompdef">
                                                        <select id="select_cus" name="select_cus" class="form-control">
                                                            <option value="">เลือกลูกค้า</option>

                                                        </select>
                                                      </div>
                                                      <div id="datacompsr"></div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                      <label>เลือกชนิดงาน</label>
                                                      <div id="datacompdef">
                                                        <select id="select_carrytype" name="select_carrytype" class="form-control">
                                                            <option value="">เลือกชนิดงาน</option>
                                                            <option value="weight">weight</option>
                                                            <option value="trip">trip</option>
                                                        </select>
                                                      </div>
                                                      <div id="datacompsr"></div>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" onclick="select_reporttransportcoverstc();">ค้นหา <li class="fa fa-search"></li></button>
                                                        </div>

                                                    </div>


                                                    <!-- <div class="col-lg-2" style="text-align: left">
                                                        <label>&nbsp;</label><br>
                                                        <a href="#" onclick="excel_reporttransportcover();" class="btn btn-success  ">EXCEL <li class="fa fa-file-excel-o"></li></a>
                                                        <a href="#" onclick="pdf_reporttransportcover();" class="btn btn-danger">PDF <li class="fa fa-file-pdf-o"></li></a>

                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="well">
                                                <div class="row">
                                                    <div class="col-lg-6" style="text-align: left">
                                                        <label>ข้อมูลใบปะหน้า</label><br>
                                                        <a href="#" onclick="excel_reporttransportcover();" class="btn btn-success  ">EXCEL <li class="fa fa-file-excel-o"></li></a>
                                                        <a href="#" onclick="pdf_reporttransportcover();" class="btn btn-danger">PDF <li class="fa fa-file-pdf-o"></li></a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="well">
                                                <div class="row">
                                                    <div class="col-lg-6" style="text-align: left">
                                                        <label>ข้อมูลใบปะหน้าสำหรับตรวจสอบ</label><br>
                                                        <a href="#" onclick="excel_reporttransportcovercheck();" class="btn btn-success  ">EXCEL <li class="fa fa-file-excel-o"></li></a>
                                                        <!-- <a href="#" onclick="pdf_reporttransportcover();" class="btn btn-danger">PDF <li class="fa fa-file-pdf-o"></li></a> -->

                                                    </div>
                                                </div>
                                            </div>
                                        </div>    

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #e7e7e7">
                                                  รายงานใบปะหน้า
                                                </div>
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>NO</th>
                                                                        <th>JOBDATE</th>
                                                                        <th>DRIVER(1)</th>
                                                                        <th>TruckNo</th>
                                                                        <th>FROM</th>
                                                                        <th>TO</th>
                                                                        <th>WEIGHTIN</th>
                                                                        <th>WEIGHTOUT</th>
                                                                        <th>PRICE</th>
                                                                        <th>TOTAL</th>
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
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
            <script>
                                                            function select_customer(companycode)
                                                            {


                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data2.php',
                                                                    data: {
                                                                        txt_flg: "select_customercompensation", companycode:companycode
                                                                    },
                                                                    success: function (response) {
                                                                        if (response){

                                                                          document.getElementById("datacompsr").innerHTML = response;
                                                                          document.getElementById("datacompdef").innerHTML = "";

                                                                        }




                                                                    }
                                                                });



                                                            }
                                                            function select_reporttransportcoverstc()
                                                            {


                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;
                                                                var companycode = document.getElementById('select_com').value;
                                                                var customercode = document.getElementById('select_cus').value;
                                                                var carrytype = document.getElementById('select_carrytype').value;
                                                                //
                                                                // // alert(datestart);
                                                                // // alert(datestart);
                                                                // // alert(companycode);
                                                                // // alert(customercode);
                                                                
                                                                //
                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "select_reporttransportcoverstc", datestart: datestart, dateend: dateend,companycode: companycode,customercode: customercode,carrytype: carrytype
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


                                                            }



                                                            function excel_reporttransportcover()
                                                            {
                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;
                                                                var companycode = document.getElementById('select_com').value;
                                                                var customercode = document.getElementById('select_cus').value;
                                                                var carrytype = document.getElementById('select_carrytype').value;

                                                                if (companycode == '') {
                                                                    // alert("ยังไม่ได้เลือกบริษัท !!")
                                                                    swal({
                                                                        title: "Warning",
                                                                        text: "ยังไม่ได้เลือกบริษัท !!",
                                                                        icon: "warning",
                                                                    });
                                                                }else if(customercode == '' || customercode == 'ALL' ){
                                                                    // alert("ยังไม่ได้เลือกลูกค้า !!")
                                                                    swal({
                                                                        title: "Warning",
                                                                        text: "ยังไม่ได้เลือกลูกค้า !!",
                                                                        icon: "warning",
                                                                    });
                                                                }else if(carrytype == ''){
                                                                    // alert("ยังไม่ได้เลือกชนิดงาน !!")
                                                                    swal({
                                                                        title: "Warning",
                                                                        text: "ยังไม่ได้เลือกชนิดงาน !!",
                                                                        icon: "warning",
                                                                    });
                                                                }else{
                                                                    window.open('excel_reporttransportcover.php?datestart=' + datestart + '&dateend=' + dateend+ '&companycode=' + companycode+ '&customercode=' + customercode + '&carrytype=' + carrytype, '_blank');
                                                                }

                                                                

                                                            }

                                                            
                                                            function pdf_reporttransportcover()
                                                            {
                                                               
                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;
                                                                var companycode = document.getElementById('select_com').value;
                                                                var customercode = document.getElementById('select_cus').value;
                                                                var carrytype = document.getElementById('select_carrytype').value;
                                                                
                                                                if (companycode == '') {
                                                                    // alert("ยังไม่ได้เลือกบริษัท !!")
                                                                    swal({
                                                                        title: "Warning",
                                                                        text: "ยังไม่ได้เลือกบริษัท !!",
                                                                        icon: "warning",
                                                                    });
                                                                }else if(customercode == '' || customercode == 'ALL'){
                                                                    // alert("ยังไม่ได้เลือกลูกค้า !!")
                                                                    swal({
                                                                        title: "Warning",
                                                                        text: "ยังไม่ได้เลือกลูกค้า !!",
                                                                        icon: "warning",
                                                                    });
                                                                }else if(carrytype == ''){
                                                                    // alert("ยังไม่ได้เลือกชนิดงาน !!")
                                                                    swal({
                                                                        title: "Warning",
                                                                        text: "ยังไม่ได้เลือกชนิดงาน !!",
                                                                        icon: "warning",
                                                                    });
                                                                }else{
                                                                    window.open('pdf_reporttransportcover.php?datestart=' + datestart + '&dateend=' + dateend+ '&companycode=' + companycode+ '&customercode=' + customercode + '&carrytype=' + carrytype, '_blank');
                                                                }
                                                                

                                                            }
                                                            function excel_reporttransportcovercheck()
                                                            {
                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;
                                                                var companycode = document.getElementById('select_com').value;
                                                                var customercode = document.getElementById('select_cus').value;
                                                                var carrytype = document.getElementById('select_carrytype').value;

                                                                if (companycode == '') {
                                                                    // alert("ยังไม่ได้เลือกบริษัท !!")
                                                                    swal({
                                                                        title: "Warning",
                                                                        text: "ยังไม่ได้เลือกบริษัท !!",
                                                                        icon: "warning",
                                                                    });
                                                                }else if(customercode == '' || customercode == 'ALL'){
                                                                    // alert("ยังไม่ได้เลือกลูกค้า !!")
                                                                    swal({
                                                                        title: "Warning",
                                                                        text: "ยังไม่ได้เลือกลูกค้า !!",
                                                                        icon: "warning",
                                                                    });
                                                                }else if(carrytype == ''){
                                                                    // alert("ยังไม่ได้เลือกชนิดงาน !!")
                                                                    swal({
                                                                        title: "Warning",
                                                                        text: "ยังไม่ได้เลือกชนิดงาน !!",
                                                                        icon: "warning",
                                                                    });
                                                                }else{
                                                                    window.open('excel_reporttransportcover_check.php?datestart=' + datestart + '&dateend=' + dateend+ '&companycode=' + companycode+ '&customercode=' + customercode + '&carrytype=' + carrytype, '_blank');
                                                                }
                                                                

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


    </body>

</html>

<?php
sqlsrv_close($conn);
?>
