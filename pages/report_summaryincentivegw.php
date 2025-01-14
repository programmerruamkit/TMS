
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

// $condiCompany = " AND Company_Code = '" . $_GET['companycode'] . "'";
// $sql_seCompany = "{call megCompany_v2(?,?)}";
// $params_seCompany = array(
//     array('select_company', SQLSRV_PARAM_IN),
//     array($condiCompany, SQLSRV_PARAM_IN)
// );
// $query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
// $result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);

// $condiCustomer = " AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'";
// $sql_seCustomer = "{call megCustomer_v2(?,?)}";
// $params_seCustomer = array(
//     array('select_customer', SQLSRV_PARAM_IN),
//     array($condiCustomer, SQLSRV_PARAM_IN)
// );
// $query_seCustomer = sqlsrv_query($conn, $sql_seCustomer, $params_seCustomer);
// $result_seCustomer = sqlsrv_fetch_array($query_seCustomer, SQLSRV_FETCH_ASSOC);
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
                            รายงานการคีย์ค่าตอบแทนของพนักงาน(GW)


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

                                        รายงานการคีย์ค่าตอบแทนของพนักงาน

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
                                                          <option value="RCC">บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์</option>
                                                          <option value="RATC">บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต</option>
                                                          <option value="RRC">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ </option>
                                                      </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                      <label>&nbsp;</label>
                                                      <div id="datacompdef">
                                                        <select id="select_cus" name="select_cus" class="form-control">
                                                            <option value="">เลือกลูกค้า</option>

                                                        </select>
                                                      </div>
                                                      <div id="datacompsr"></div>

                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" onclick="select_summaryincentive();" >ค้นหา <li class="fa fa-search"></li></button>
                                                        </div>

                                                    </div>


                                                    <div class="col-lg-2" style="text-align: right">
                                                        <label>&nbsp;</label><br>
                                                        <a href="#" onclick="excel_reportsummaryincentive();" class="btn btn-default">พิมพ์ <li class="fa fa-print"></li></a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ////////////////////////DIV แสดงข้อมูล//////////////////// -->

                                      <input type="text" name="txt_cus" id="txt_cus" value="" style="display:none">




                                      <div class="row" >
                                        <div class="col-lg-12">
                                            <div class="well">
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                      <label>จำนวนเที่ยววิ่งงาน</label>
                                                        <div class="form-group">
                                                              <input type="text" class="form-control"  readonly=""  style="background-color: #FFCE0A" name="txt_plan" id="txt_plan" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>จำนวนที่คีย์ค่าตอบแทน</label>
                                                        <div class="form-group">
                                                          <input type="text" class="form-control"  readonly=""  style="background-color: #2EC928" name="txt_success" id="txt_success" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>จำนวนที่ไม่คีย์ค่าตอบแทน</label>
                                                        <div class="form-group">
                                                          <input type="text" class="form-control"  readonly=""  style="background-color: #F06951" name="txt_unsuccess" id="txt_unsuccess" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>จำนวนที่ตัดงาน</label>
                                                        <div class="form-group">
                                                          <input type="text" class="form-control"  readonly=""  style="background-color: #F06951  " name="txt_cutjob" id="txt_cutjob" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /////////////////////////////////////////////////////////////////////////////// -->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #e7e7e7">
                                                  รายงานการคีย์ค่าตอบแทนของพนักงาน  &nbsp; &nbsp; &nbsp; <input class="btn btn-default" type="button" style="background-color: #F06951;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""> * แจ้งเตือนข้อมูล ไม่พบการคีย์ค่าตอบแทน  
                                                </div>
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>

                                                                        <th>NO</th>
                                                                        <th>TRUCKNO</th>
                                                                        <th>FIRST-DRIVER</th>
                                                                        <th>SECOND-DRIVER</th>
                                                                        <th>JOBSTART</th>
                                                                        <th>JOBEND</th>
                                                                        <th>REMARK</th>
                                                                        <th>VIEWDETAIL</th>
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

      <div class="container">


          <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><b>ข้อมูลการคีย์ค่าตอบแทนของพนักงาน </b></h4>
                </div>
                <div class="modal-body">
                  <div id="datacompdetailsr"></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>

            </div>
          </div>
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


                                                          function getPlanid(planid) {

                                                             select_customerdetail(planid);
                                                          }
                                                          function select_customerdetail(planid)
                                                          {


                                                              $.ajax({
                                                                  type: 'post',
                                                                  url: 'meg_data.php',
                                                                  data: {
                                                                      txt_flg: "select_customercompensationdetail", planid:planid
                                                                  },
                                                                  success: function (response) {
                                                                      if (response){

                                                                        document.getElementById("datacompdetailsr").innerHTML = response;
                                                                        document.getElementById("datacompdetaildef").innerHTML = "";

                                                                      }




                                                                  }
                                                              });



                                                          }
                                                            function select_summaryincentive()
                                                            {


                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;
                                                                var companycode = document.getElementById('select_com').value;
                                                                var customercode = document.getElementById('select_cus').value;

                                                                // alert(datestart);
                                                                // alert(datestart);
                                                                // alert(companycode);
                                                                // alert(customercode);
                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "select_summaryincentive", datestart: datestart, dateend: dateend,companycode: companycode,customercode: customercode
                                                                    },
                                                                    success: function (response) {
                                                                        if (response){
                                                                            document.getElementById("datasr").innerHTML = response;
                                                                            document.getElementById("datadef").innerHTML = "";

                                                                        }
                                                                        $(document).ready(function () {
                                                                            $('#dataTables-example').DataTable({
                                                                                responsive: true,
                                                                            });
                                                                        });

                                                                        select_summaryincentive2();

                                                                    }
                                                                });
                                                                // }



                                                            }
                                                            function select_customer(companycode)
                                                            {


                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
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
                                                            function select_summaryincentive2()
                                                            {


                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;
                                                                var companycode = document.getElementById('select_com').value;
                                                                var customercode = document.getElementById('select_cus').value;

                                                                // alert(datestart);
                                                                // alert(datestart);
                                                                // alert(companycode);
                                                                // alert(customercode);
                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "select_summaryincentive", datestart: datestart, dateend: dateend,companycode: companycode,customercode: customercode
                                                                    },
                                                                    success: function (response) {
                                                                        if (response){

                                                                          document.getElementById("txt_cus").value = document.getElementById("se_cus").value;
                                                                          document.getElementById("txt_plan").value = document.getElementById("se_plan").value;
                                                                          document.getElementById("txt_success").value = document.getElementById("se_success").value;
                                                                          document.getElementById("txt_unsuccess").value = document.getElementById("se_unsuccess").value;
                                                                          document.getElementById("txt_cutjob").value = document.getElementById("se_cutjob").value;

                                                                        }




                                                                    }
                                                                });



                                                            }


                                                            function excel_reportsummaryincentive()
                                                            {

                                                              // alert("ยังไม่พร้อมใช้งาน กำลังดำเนินการอัพเดทเข้าระบบ");
                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;
                                                                var companycode = document.getElementById('select_com').value;
                                                                var customercode = document.getElementById('select_cus').value;

                                                                window.open('excel_reportsummaryincentive.php?datestart=' + datestart + '&dateend=' + dateend+ '&companycode=' + companycode+ '&customercode=' + customercode, '_blank');

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
