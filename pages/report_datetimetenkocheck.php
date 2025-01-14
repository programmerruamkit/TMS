
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
                            รายงานวันที่และเวลา ตรวจร่างกาย


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

                                        รายงานวันที่และเวลา ตรวจร่างกาย

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
                                                            <label>ค้นหาตามช่วงวันที่</label><br>
                                                            <label>&nbsp;</label>
                                                            <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">

                                                        </div>

                                                    </div>
                                                    <!-- <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateend" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">

                                                        </div>
                                                    </div> -->
                                                    <div class="col-lg-3">
                                                      <label>&nbsp;</label><br>
                                                      <label>&nbsp;</label>
                                                      <select id="txt_companycode" name="txt_companycode" class="form-control" >
                                                          <option value="">เลือกบริษัท</option>
                                                          <option value="RKS">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส</option>
                                                          <option value="RKR">บริษัท ร่วมกิจรุ่งเรือง (1993)</option>
                                                          <option value="RKL">บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์</option>
                                                          <option value="RCC">บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์</option>
                                                          <option value="RRC">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์</option>
                                                          <option value="RATC">บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต</option>

                                                      </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>&nbsp;</label><br>
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" onclick="select_reporttransportplanamt();">ค้นหา <li class="fa fa-search"></li></button>
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-4" style="text-align: left">
                                                        <label><font color="red">*พิมพ์รายงานไม่ต้องกดต้นหาข้อมูล เลือกวันที่และบริษัท</font></label><br>
                                                        <label><font color="red">จากนั้นกดพิมพ์รายงานได้ทันที</font></label><br>
                                                        <a href="#" onclick="excel_reporttransportpalngw();" class="btn btn-default">พิมพ์รายงานขนส่ง <li class="fa fa-print"></li></a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" >
                                    <div class="col-lg-12">
                                            <div class="well">
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                      <label>แผนงานรวม</label>
                                                        <div class="form-group">
                                                              <input type="text" class="form-control"  readonly=""  style="background-color: #D6DBDF" name="txt_plan" id="txt_plan" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>จำนวนคน(พขรคนที่1)</label>
                                                        <div class="form-group">
                                                          <input type="text" class="form-control"  readonly=""  style="background-color: #D6DBDF" name="txt_driver1" id="txt_driver1" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>จำนวนคน(พขรคนที่2)</label>
                                                        <div class="form-group">
                                                          <input type="text" class="form-control"  readonly=""  style="background-color: #D6DBDF" name="txt_driver2" id="txt_driver2" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #e7e7e7">
                                                    รายงานวันที่และเวลา ตรวจร่างกาย
                                                </div>
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>NO</th>
                                                                        <th>JOBNO</th>
                                                                        <th>EMPLOYEECODE1</th>
                                                                        <th>EMPLOYEENAME1</th>
                                                                        <th>EMPLOYEECODE2</th>
                                                                        <th>EMPLOYEENAME2</th>
                                                                        <th>JOBSTART</th>
                                                                        <th>JOBEND</th>
                                                                        <th>VEHICLETYPE</th>
                                                                        <th>DATEPLAN</th>
                                                                        <th>TIMEPLAN</th>
                                                                        <th>DATEACTUAL</th>
                                                                        <th>TIMEACTUAL</th>
                                                                        <th>TIMEDIFF</th>
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

                                                            
                                                            // select_reporttransportplangw
                                                            function select_reporttransportplanamt()
                                                            {


                                                                // var startdate = document.getElementById('txt_datestart').value;
                                                                // var enddate = document.getElementById('txt_dateend').value;
                                                                var companycode = document.getElementById('txt_companycode').value;

                                                                var startdate = document.getElementById('txt_datestart').value;
                                                                // var enddate = document.getElementById('txt_dateend').value;
                                                                 // alert(datestart);
                                                                // alert(dateend);
                                                                // alert(companycode);
                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data2.php',
                                                                    data: {
                                                                        txt_flg: "select_reportdatetimetenkocheck", startdate: startdate,companycode: companycode
                                                                    },
                                                                    success: function (response) {

                                                                        if (response)
                                                                        {
                                                                            alert('โหลดข้อมูลเรียบร้อยแล้ว!!!');
                                                                            document.getElementById("datasr").innerHTML = response;
                                                                            document.getElementById("datadef").innerHTML = "";

                                                                            document.getElementById("txt_plan").value = document.getElementById("se_plan").value;
                                                                            document.getElementById("txt_driver1").value = document.getElementById("se_driver1").value;
                                                                            document.getElementById("txt_driver2").value = document.getElementById("se_driver2").value;
                                                                        }
                                                                        $(document).ready(function () {
                                                                            $('#dataTables-example1').DataTable({
                                                                                responsive: true,
                                                                            });
                                                                        });



                                                                    }
                                                                });


                                                            }
                                                            function excel_reporttransportpalngw()
                                                            {
                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                // var dateend = document.getElementById('txt_dateend').value;
                                                                var companycode = document.getElementById('txt_companycode').value;

                                                                if (datestart == '') {
                                                                    alert("ยังไม่ได้เลือกวันที่ !!!");
                                                                }else if (companycode == ''){
                                                                    alert("ยังไม่ได้เลือกบริษัท!!!");
                                                                }else{
                                                                    window.open('excel_reportdatetimetenko.php?datestart=' + datestart +  '&companycode=' + companycode, '_blank');
                                                                }
                                                               

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
