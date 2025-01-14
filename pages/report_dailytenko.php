
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
                            รายงานข้อมูลการตรวจร่างกาย(เจ้าหน้าที่)
                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <!-- Nav tabs -->
                                <!-- <ul class="nav nav-pills">
                                    <li class="active"><a href="#tenko_day" data-toggle="tab">รายงานการตรวจร่างกาย</a>
                                    </li>
                                    <li><a href="#tenko_month" data-toggle="tab">รายงานการตรวจร่างกาย(รวม)</a>
                                    </li>

                                </ul> -->
                                    <!-- <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                        รายงานข้อมูลค่าเที่ยว(บริษัท)(AMT)
                                                    </div>
                                                </div>
                                            </div>
                                    </div>     -->
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <!-- ///////////////////////////////////////////////////////////////////////// -->
                                     <div class="tab-pane fade in active" id="tenko_day"> 
                                        <div class="row">&nbsp;</div>
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <div class="well">
                                                    <div class="row">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" style="background-color: #e7e7e7">
                                                                <h4><b>รายงานตรวจร่างกาย (เจ้าหน้าที่) (รวม) </b></h4>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>ค้นหาข้อมูลตามช่วงวันที่</label>
                                                                <input class="form-control dateen"  onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestartall" name="txt_datestartall" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control dateen"    style="background-color: #f080802e" id="txt_dateendall" name="txt_dateendall" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <select id="select_area" name="select_area" class="form-control" >
                                                                <option value="">เลือกพื้นที่(Area)</option>
                                                                <option value="amata">AMT</option>
                                                                <option value="gateway">GW</option>
                                                            </select>
                                                        </div>
                                                        <!-- <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <select id="select_department" name="select_com" class="form-control" onchange="select_customer(this.value)">
                                                                <option value="">เลือกบริษัท</option>
                                                                <option value="RKR">บริษัท ร่วมกิจรุ่งเรือง (1993)</option>
                                                                <option value="RKS">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส</option>
                                                                <option value="RKL">บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์ </option>
                                                            </select>
                                                        </div> -->

                                                        <!-- <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div id="datacompdef">
                                                                <select id="select_cus" name="select_cus" class="form-control">
                                                                    <option value="">เลือกลูกค้า</option>

                                                                </select>
                                                            </div>
                                                            <div id="datacompsr"></div>

                                                        </div> -->

                                                        <!-- <div class="col-lg-2">
                                                          <label>&nbsp;</label>
                                                          <div id="datacompdef">
                                                            <select id="select_thainame" name="select_thainame" class="form-control">
                                                                <option value="">เลือกทะเบียนรถ</option>
  
                                                            </select>
                                                          </div>
                                                          <div id="datacompsr"></div>
                                                        </div> -->


                                                        <!-- <div class="col-lg-1">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-default" onclick="select_compen_companyamt();">ค้นหา <li class="fa fa-search"></li></button>
                                                            </div>

                                                        </div> -->

                                                        <div class="col-lg-3" style="text-align: left">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="select_reporttenkoofficerall();" class="btn btn-default">รายงานการตรวจร่างกาย(เจ้าหน้าที่)(รวม)<li class="fa fa-file-excel-o" ></li></a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-12">
                                                <div class="well">
                                                    <div class="row">
                                                        <div class="col-lg-12" style="text-align: left">
                                                            <a href="#" onclick="select_companycompensationexcel1();" class="btn btn-default">รายงานค่าเที่ยว(รายเดือน)<li class="fa fa-file-excel-o" ></li></a>
                                                            <a href="#" onclick="select_companycompensationexcel();" class="btn btn-default">รายงานค่าเที่ยว(รายวัน)<li class="fa fa-file-excel-o"></li></a>
                                                            <a href="#" onclick="select_companycompensationexcel_pallet();" class="btn btn-default">รายงานค่าเที่ยวพาเลท(รายวัน)<li class="fa fa-file-excel-o" ></li></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- END 2 -->
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                        รายงานข้อมูลค่าเที่ยว(บริษัท)(AMT)
                                                    </div>
                                                    

                                                    <div class="panel-body">

                                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                            <div id="data_def1">
                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="text-align: center" rowspan="2">ลำดับ</th>
                                                                            <th style="text-align: center" rowspan="2">สายงาน</th>
                                                                            <th style="text-align: center" rowspan="2">รหัสพนักงาน</th>
                                                                            <th style="text-align: center" rowspan="2">ชื่อพนักงาน</th>
                                                                            <th style="text-align: center" colspan="6">TOTAL</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th style="text-align: center">TRIP</th>
                                                                            <th style="text-align: center">INCENTIVE(TRIP)</th>
                                                                            <th style="text-align: center">PALLET</th>
                                                                            <th style="text-align: center">INCENTIVE(PALLET)</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="text-align: center"></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="3" style="background-color: #e7e7e7;text-align: center"></td>
                                                                            <td ></td>
                                                                            <td ></td>
                                                                            <td ></td>
                                                                            <td ></td>
                                                                            <td ></td>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                            <div id="data_sr1"></div>

                                                        </div>


                                                        
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div> -->
                                <div class="row">
                                    </div> 
                                    </div>
                                       
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <div class="well">
                                                    <div class="row">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" style="background-color: #e7e7e7">
                                                            <h4><b>รายงานตรวจร่างกาย (เจ้าหน้าที่) (แยกแผนก) </b></h4>
                                                        </div>
                                                    </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>ค้นหาข้อมูลตามช่วงวันที1</label>
                                                                <input class="form-control dateen"  onchange="datetodate_month();" style="background-color: #f080802e"  id="txt_datestart_month" name="txt_datestart_month" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">

                                                            </div>

                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control dateen"    style="background-color: #f080802e" id="txt_dateend_month" name="txt_dateend_month" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <select id="select_department_month" name="select_department_month" class="form-control" >
                                                                <option value="">เลือกแผนก(Department)</option>
                                                                <option value="01">Administration</option>
                                                                <option value="02">Accounting/Finance</option>
                                                                <option value="03">Transportation</option>
                                                                <option value="04">Affiliate Business</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <select id="select_section_month" name="select_section_month" class="form-control" >
                                                                <option value="">เลือกฝ่าย(Section)</option>
                                                                <option value="01">Accounting</option>
                                                                <option value="02">Administration</option>
                                                                <option value="01">Corporate Strategy</option>
                                                                <option value="01">Customer Relation Managemet</option>
                                                                <option value="02">Finance</option>
                                                                <option value="02">Operation</option>
                                                                <option value="02">Ruamkit Information Technology</option>
                                                                <option value="03">Ruamkit Rungrueng Traning Center</option>
                                                                <option value="01">Ruamkit Rungrueng Truck Details</option>
                                                                <option value="03">Safety & Quality</option>
                                                            </select>
                                                        </div> 

                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <select id="select_area_section" name="select_area_section" class="form-control" >
                                                                <option value="">เลือกพื้นที่(Area)</option>
                                                                <option value="amata">AMT</option>
                                                                <option value="gateway">GW</option>
                                                            </select>
                                                        </div> 
                                                        <div class="col-lg-2" style="text-align: right">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="select_dailytenkoofficer();" class="btn btn-default">รานงานตรวจร่างกาย(แยกแผนก)<li class="fa fa-file-excel-o" ></li></a>
                                                           
                                                        </div>
                                                          
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END 2 -->
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
                                                                $(function () {
                                                                    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                    // กรณีใช้แบบ input
                                                                    $(".dateen").datetimepicker({
                                                                        timepicker: true,
                                                                        format: 'd/m/Y H:m', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                                        lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                                                                    });
                                                                });
                                                                $(function () {
                                                                    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                    // กรณีใช้แบบ input
                                                                    $(".dateen1").datetimepicker({
                                                                        timepicker: true,
                                                                        format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                                        lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                                                                    });
                                                                });

                                                                function select_compen_companyamt() {
                                                                    save_logprocess('Report', 'SELECT รายงานข้อมูลค่าเที่ยว(บริษัท)(AMT)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                    var datestart = document.getElementById('txt_datestart').value;
                                                                    var dateend = document.getElementById('txt_dateend').value;
                                                                    var companycode = document.getElementById('select_com').value;
                                                                    var customercode = document.getElementById('select_cus').value;
                                                                    // var thainame = document.getElementById('select_thainame').value;

                                                                    // alert(datestart);
                                                                    // alert(dateend);
                                                                    // alert(companycode);
                                                                    // alert(customercode);


                                                                    $.ajax({
                                                                        type: 'post',
                                                                        url: 'meg_data.php',
                                                                        data: {
                                                                            txt_flg: "select_reportcompen_companyamt", datestart: datestart, dateend: dateend, companycode: companycode, customercode: customercode
                                                                        },
                                                                        success: function (response) {

                                                                            if (response)
                                                                            {

                                                                                document.getElementById("data_sr1").innerHTML = response;
                                                                                document.getElementById("data_def1").innerHTML = "";

                                                                                $(document).ready(function () {
                                                                                    $('#dataTables-example').DataTable({
                                                                                        responsive: true,
                                                                                    });
                                                                                });
                                                                            }


                                                                        }
                                                                    });
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

                                                                function select_dailytenkoofficer()
                                                                {
                                                                    save_logprocess('Report', 'EXCEL รายงานตรวจร่างกาย(เจ้าหน้าที่)(แยกแผนก)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                    var department = document.getElementById('select_department_month').value;
                                                                    var section = document.getElementById('select_section_month').value;
                                                                    var area = document.getElementById('select_area_section').value;

                                                                    var datestart = document.getElementById('txt_datestart_month').value;
                                                                    var dateend = document.getElementById('txt_dateend_month').value;

                                                                    // alert(department);
                                                                    // alert(section);

                                                                    if (department =='02' && (section =='01' || section =='02') ) {
                                                                         window.open('excel_reportdailytenkoofficer_acc.php?datestart=' + datestart + '&dateend=' + dateend + '&department=' + department+ '&section=' + section+ '&area=' + area, '_blank');    
                                                                    }else if (department =='03' && section == '03') {
                                                                         window.open('excel_reportdailytenkoofficer_sq.php?datestart=' + datestart + '&dateend=' + dateend + '&department=' + department+ '&section=' + section+ '&area=' + area, '_blank');   
                                                                    }else{
                                                                        window.open('excel_reportdailytenkoofficer.php?datestart=' + datestart + '&dateend=' + dateend + '&department=' + department+ '&section=' + section+ '&area=' + area, '_blank');   
                                                                        
                                                                    }
                                                                    

                                                                    // window.open('excel_reportdailytenkoofficer_acc.php?datestart=' + datestart + '&dateend=' + dateend, '_blank');
                                                                }

                                                                

                                                                function select_reporttenkoofficerall()
                                                                {
                                                                    save_logprocess('Report', 'EXCEL รายงานตรวจร่างกาย(เจ้าหน้าที่)(รวม)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                    var datestart = document.getElementById('txt_datestartall').value;
                                                                    var dateend = document.getElementById('txt_dateendall').value;
                                                                    var area = document.getElementById('select_area').value;

                                                                    window.open('excel_reportdailytenkoofficerall.php?datestart=' + datestart + '&dateend=' + dateend+ '&area=' + area , '_blank');
                                                                }

                                                                function select_companycompensationexcel_month()
                                                                {
                                                                    save_logprocess('Report', 'EXCEL รายงานค่าเที่ยว2(รายเดือน)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                    var datestart = document.getElementById('txt_datestart_month').value;
                                                                    var dateend = document.getElementById('txt_dateend_month').value;

                                                                    var str1 = datestart;
                                                                    var res1 = str1.substring(3, 10);
                                                                    var str2 = dateend;
                                                                    var res2 = str2.substring(3, 10);

                                                                    var companycode = document.getElementById('select_company_month').value;
                                                                    var position = document.getElementById('select_position_month').value;

                                                                    window.open('excel_reportcompanycompensation_month.php?companycode=' + companycode + '&position=' + position + '&datestart=' + res1 + '&dateend=' + res2, '_blank');
                                                                }

                                                                function modal_companycompensation(companycode)
                                                                {
                                                                    document.getElementById('txt_companycode').value = companycode;
                                                                }


                                                                function datetodate()
                                                                {
                                                                    document.getElementById('txt_dateendall').value = document.getElementById('txt_datestartall').value;

                                                                }
                                                                function datetodate_month()
                                                                {
                                                                    document.getElementById('txt_dateend_month').value = document.getElementById('txt_datestart_month').value;

                                                                }
                                                                $(document).ready(function () {
                                                                    $('#dataTables-example').DataTable({
                                                                        responsive: true,
                                                                    });
                                                                });

                                                                $(document).ready(function () {
                                                                    $('#dataTables-example1').DataTable({
                                                                        responsive: true,
                                                                    });
                                                                });



            </script>


    </body>

</html>
<?php
sqlsrv_close($conn);
?>
