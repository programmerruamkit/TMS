<!DOCTYPE html>
<?php
ob_start();
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");

// echo $_SESSION["USERNAME"];
if (!isset($_SESSION["USERNAME"]) || !isset($_SESSION["PASSWORD"])) {
    header("location:../pages/meg_login.php?data=3");
}

// $condition1 = " AND (a.USERNAME ='" . $_SESSION["USERNAME"] . "' AND a.PASSWORD = '" . $_SESSION["PASSWORD"] . "') AND a.ACTIVESTATUS = 1";
// $sql_seLogin = "{call megRoleaccount_v2(?,?)}";
// $params_seLogin = array(
//     array('select_roleaccount', SQLSRV_PARAM_IN),
//     array($condition1, SQLSRV_PARAM_IN)
// );
// $query_seLogin = sqlsrv_query($conn, $sql_seLogin, $params_seLogin);
// $result_seLogin = sqlsrv_fetch_array($query_seLogin, SQLSRV_FETCH_ASSOC);

$sql_seSystime = "{call megGetdate_v2(?)}";
$params_seSystime = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
$result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);


$conditionEHR = " AND a.PersonID ='" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEHR = "{call megEmployeeEHR_v2(?,?)}";
$params_seEHR = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($conditionEHR, SQLSRV_PARAM_IN)
);
$query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
$result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);

// $condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
// $sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
// $params_seEmployee = array(
//     array('select_employee', SQLSRV_PARAM_IN),
//     array($condition1, SQLSRV_PARAM_IN)
// );
// $query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
// $result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);


// $condition2_1 = " AND (CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103))";
// $condition2_2 = "";
// $condition2_3 = "";

// $sql_seVehicletransportplan = "{call megVehicletransportplan_v2(?,?,?,?)}";
// $params_seVehicletransportplan = array(
//     array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
//     array($condition2_1, SQLSRV_PARAM_IN),
//     array($condition2_2, SQLSRV_PARAM_IN),
//     array($condition2_3, SQLSRV_PARAM_IN)
// );
// $query_seVehicletransportplan = sqlsrv_query($conn, $sql_seVehicletransportplan, $params_seVehicletransportplan);
// $result_seVehicletransportplan = sqlsrv_fetch_array($query_seVehicletransportplan, SQLSRV_FETCH_ASSOC);
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
        <!--<link href="../dist/css/sb-admin-2.css" rel="stylesheet">-->
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        <link href="../js/bootstrap-datepicker.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
        <style>
            .navbar-default {

                border-color: #ffcb0b;
            }

            .popover-content {
                padding: 10px 10px;
                width: 100px;
            }
            .nav>li>a {
                position: relative;
                display: block;
                padding: 14px 30px;

            }


            .styled-select.slate select {
                border: 1px solid #ccc;
                font-size: 16px;
                height: 34px;
                width: 150px;

            }

            .swal2-popup {
                font-size: 16px !important;
                padding: 17px;
                border: 1px solid #F0E1A1;
                display: block;
                margin: 22px;
                text-align: center;
                color: #61534e;
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

        <!-- <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0"> -->
            
        <div class="navbar-header" >
            <button type="button"  class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li><a href="meg_logout.php"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</a>
        </ul>
        </nav>

            <!-- <div id="page-wrapper" > -->
                <div class="row">&nbsp;</div>
                <div class="row" >
                    <div class="col-lg-4" style="text-align: center">
                        <h2 class="page-header">ตรวจสอบเบิกล่วงหน้า </h2>
                    </div>
                    <div class="col-lg-4" style="text-align: center" >
                        <h2 class="page-header"> (<?=$_SESSION["USERNAME"]?>&nbsp;&nbsp;<?=$result_seEHR['nameT']?>)</h2>
                    </div>
                    <input type="hidden" id="txt_dateapp" name="txt_dateapp" value ="<?=$result_seSystime['SYSDATE']?>">
                    <input type="hidden" id="txt_officer" name="txt_officer" value ="<?=$_SESSION["USERNAME"]?>">
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading">
                                <div class="row" >
                                    <div class="col-lg-6">

                                        รายงานแผนขนส่ง AMT

                                    </div>
                                    <div class="col-lg-6 text-right"></div>
                                </div>
                            </div> -->

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
                                                      <select id="select_com" name="select_com" class="form-control" >
                                                          <option value="00">เลือกบริษัท</option>
                                                          <option value="01">บริษัท ร่วมกิจรุ่งเรือง (1993)</option>
                                                          <option value="02">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส</option>
                                                          <option value="04">บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์</option>
                                                          <option value="05">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์</option>
                                                          <option value="06">บริษัท ร่วมกิจรุ่งเรือง ทรัค ดีเทลส์</option>
                                                          <option value="07">บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์</option>
                                                          <option value="08">บริษัท ร่วมกิจรุ่งเรือง เทรนนิ่ง เซ็นเตอร์</option>
                                                          <option value="09">บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต</option>
                                                          <option value="10">บริษัท ร่วมกิจ ไอที</option>
                                                      </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" onclick="select_reportclashadvance()">ค้นหา <li class="fa fa-search"></li></button>
                                                        </div>

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
                                                        <div class="form-group">
                                                            <label>เลือกข้อมูลรายสัปดาห์</label>
                                                            <input  type="text" class="form-control datebilling"  readonly=""   data-date-language="th" style="background-color: #f080802e" id="date_billing" name="date_billing" placeholder="วันที่ต้องการดูรายงาน" value="">
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>เหตุผลในการเบิก</label>
                                                            <input class="form-control "    id="txt_reason" name="txt_reason" value="" placeholder="เหตุผลในการเบิก" autocomplete ="off">
                                                        </div>
                                                    </div> -->
                                                    <div class="col-lg-2" style="text-align: left">
                                                        <label>&nbsp;</label><br>
                                                        <button type="button" class="btn btn-default" onclick="print_reportweek()">พิมพ์รายงาน(สัปดาห์) <li class="fa fa-file-excel-o"></li></button>
                                                        
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
                                                        <div class="form-group">
                                                            <label>หัวกระดาษรายเดือน</label>
                                                            <input  type="text" class="form-control datebillingmonth"  readonly=""   data-date-language="th" style="background-color: #f080802e" id="date_headmonth" name="date_headmonth" placeholder="วันที่ต้องการดูรายงาน" value="" onmouseover="showdate(this.value)">
                                                        </div>
                                                    </div>   
                                                    <div class="col-lg-1">
                                                        <div class="form-group">
                                                            <label>ข้อมูลสัปดาห์ที่1</label>
                                                            <input  type="text" class="form-control dateenweek"  readonly=""   data-date-language="th" style="background-color: #f080802e" id="date_week1" name="date_week1" placeholder="วันที่ต้องการดูรายงาน" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <div class="form-group">
                                                            <label>ข้อมูลสัปดาห์ที่2</label>
                                                            <input  type="text" class="form-control dateenweek"  readonly=""   data-date-language="th" style="background-color: #f080802e" id="date_week2" name="date_week2" placeholder="วันที่ต้องการดูรายงาน" value="">
                                                        </div>
                                                    </div> 
                                                    <div class="col-lg-1">
                                                        <div class="form-group">
                                                            <label>ข้อมูลสัปดาห์ที่3</label>
                                                            <input  type="text" class="form-control dateenweek"  readonly=""   data-date-language="th" style="background-color: #f080802e" id="date_week3" name="date_week3" placeholder="วันที่ต้องการดูรายงาน" value="">
                                                        </div>
                                                    </div> 
                                                    <div class="col-lg-1">
                                                        <div class="form-group">
                                                            <label>ข้อมูลสัปดาห์ที่4</label>
                                                            <input  type="text" class="form-control dateenweek"  readonly=""   data-date-language="th" style="background-color: #f080802e" id="date_week4" name="date_week4" placeholder="วันที่ต้องการดูรายงาน" value="">
                                                        </div>
                                                    </div> 
                                                    <div class="col-lg-1">
                                                        <div class="form-group">
                                                            <label>ข้อมูลสัปดาห์ที่5</label>
                                                            <input  type="text" class="form-control dateenweek"  readonly=""   data-date-language="th" style="background-color: #f080802e" id="date_week5" name="date_week5" placeholder="วันที่ต้องการดูรายงาน" value="">
                                                        </div>
                                                    </div>    
                                                    <div class="col-lg-1" style="text-align: left">
                                                        <label>&nbsp;</label><br>
                                                        <button type="button" class="btn btn-default" onclick="print_reportweekall()">พิมพ์รายงาน(เดือน) <li class="fa fa-file-excel-o"></li></button>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #e7e7e7">
                                                        <h4>ประวัติการเบิก&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="approve_clashadvall('<?= $_SESSION['USERNAME'] ?>');" class="btn btn-success">อนุมัติการเบิกทั้งหมด</a></h4>
                                                </div>
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>เลขที่</th>
                                                                        <th>วันที่</th>
                                                                        <th>รหัสพนักงาน</th>
                                                                        <th>ชื่อ-นามสกุล</th>
                                                                        <th>จำนวนเงิน</th>
                                                                        <th>เหตุผล</th>
                                                                        <th>สถานะ</th>
                                                                        <th>หมายเหตุ</th>
                                                                        <th>จัดการ</th>
                                                                        
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                           
                                                                <tr>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>     
                                                                    <td></td>
                                                                    <td></td>
                                                                    
                                                                </tr>    
                                                                
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

            <!-- </div> -->

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

            <!-- this will show our spinner -->
            <div  id="loading" class="center" >
                <p><img style="" src="../images/truckload5.gif" /></p>
            </div>

            <script src="../vendor/jquery/jquery.min.js"></script>
            <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
            <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
            <script src="../vendor/metisMenu/metisMenu.min.js"></script>
            <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
            <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
            <script src="../dist/js/sb-admin-2.js"></script>
            <script src="../js/jquery.datetimepicker.full.js"></script>
            <script src="../js/bootstrap-datepicker.min.js"></script>
            <script src="../js/bootstrap-datepicker.th.min.js"></script>
            <script src="../dist/js/bootstrap-select.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
            <script>
                        
                        
                        // function select_all() {
                        //     alert('ddd');
                        //     $(document).ready(function(){
                        //     $('#selectall').on('click',function(){
                        //         if(this.checked){
                        //             $('.checkbox').each(function(){
                        //                 this.checked = true;
                        //             });
                        //         }else{
                        //             $('.checkbox').each(function(){
                        //                 this.checked = false;
                        //             });
                        //         }
                        //     });
                        //     $('.checkbox').on('click',function(){
                        //         if($('.checkbox:checked').length == $('.checkbox').length){
                        //             $('#selectall').prop('checked',true);
                        //         }else{
                        //             $('#selectall').prop('checked',false);
                        //         }
                        //     });
                        // });
                        // }  
                        function showLoading() {
                            $("#loading").show();
                            
                        }

                        function hideLoading() {
                            $("#loading").hide();
                        }

                        function check()
                        {
                            var elem = document.getElementById('txt_money').value;
                            if(!elem.match(/^([0-9])+$/i))
                            {
                                // alert("กรอกได้เฉพาะตัวเลข");
                                swal.fire({
                                    title: "Warning !!",
                                    text: "กรอกได้เฉพาะตัวเลข",
                                    icon: "warning",
                                });
                                document.getElementById('txt_money').value = "";
                            }

                            if(elem > '1000'){
                                // alert("เกินจำนวนที่เบิกได้");
                                swal.fire({
                                    title: "Warning !!",
                                    text: "กรอกได้เฉพาะตัวเลข",
                                    icon: "warning",
                                });
                                document.getElementById('txt_money').value = "";
                            }
                        }

                        function select_reportclashadvance()
                        {

                            var datestart = document.getElementById('txt_datestart').value;
                            var dateend = document.getElementById('txt_dateend').value;
                            var companycode = document.getElementById('select_com').value;
                            
                            // alert(datestart);
                            // alert(dateend);
                            // alert(companycode);

                            if (datestart == '') {
                                
                                swal.fire({
                                    title: "Warning !",
                                    text: "กรุณาเลือกวันที่เริ่มต้น",
                                    icon: "warning",
                                });
                                        
                            }else if(dateend == ''){

                                swal.fire({
                                    title: "Warning !",
                                    text: "กรุณาเลือกวันที่สิ้นสุด",
                                    icon: "warning",
                                });

                            }else if (companycode == '00'){

                                swal.fire({
                                    title: "Warning !",
                                    text: "กรุณาเลือกบริษัท",
                                    icon: "warning",
                                });

                            }else{

                                showLoading();
                                $.ajax({
                                    type: 'post',
                                    url: 'meg_data.php',
                                    data: {
                                        txt_flg: "select_reportclashadvance_data", datestart: datestart, dateend: dateend,companycode: companycode
                                    },
                                    success: function (response) {
                                        
                                        hideLoading();
                                        // alert('โหลดข้อมูลเรียบร้อย');
                                        swal.fire({
                                            title: "Good Job!",
                                            text: "โหลดข้อมูลเรียบร้อย",
                                            icon: "success",
                                        });
                                        
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

                        }
                        // function add_clashadv(employeecode,employeename)
                        // {

                            
                        //     var price = document.getElementById('txt_money').value;
                        //     var reason = document.getElementById('txt_reason').value;
                        //     var datemoney = document.getElementById('txt_datemoney').value;

                        //     // alert(employeecode);
                        //     // alert(employeename);
                        //     // alert(price);
                        //     // alert(reason);
                        //     // alert(datemoney);

                        //     $.ajax({
                        //         type: 'post',
                        //         url: 'meg_data.php',
                        //         data: {
                        //             txt_flg: "add_adv", employeecode: employeecode,employeename: employeename,price: price,reason: reason,datemoney: datemoney
                        //         },
                        //         success: function (rs) {
                        //             alert('บันทึกข้อมูลเรียบร้อย');
                        //             location.reload();


                        //         }
                        //     });

                        // }
                        function editvar_remark(editableObj, fieldname, clashid) {

                            // alert(fieldname);
                            // alert(clashid);
                            
                            var dataedit = editableObj.innerHTML;
                                $.ajax({
                                url: 'meg_data.php',
                                type: 'POST',
                                data: {
                                    txt_flg: "edit_remark", editableObj: dataedit,fieldname: fieldname, ID: clashid
                                },
                                success: function () {

                                }
                            });

                        }
                        function delete_adv(ID)
                        {
                              
                                Swal.fire({
                                    title: 'ต้องการลบข้อมูล?',
                                    text: "กรุณากด 'ตกลง' เพื่อยืนยันการลบข้อมูล!!!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'ตกลง',
                                    cancelButtonText: 'ยกเลิก'
                                }).then((result) => {
                                    
                                    if (result.isConfirmed) {
                                        
                                        $.ajax({
                                            type: 'post',
                                            url: 'meg_data.php',
                                            data: {
                                                txt_flg: "delete_adv", ID: ID,employeecode: '',employeename: '',price: '',reason: '',datemoney: ''
                                            },
                                            success: function (rs) {
                                                // alert('ลบข้อมูลเรียบร้อย');
                                                // location.reload();

                                                swal.fire({
                                                    title: "Good Job!",
                                                    text: "ลบข้อมูลเรียบร้อย",
                                                    showConfirmButton: false,
                                                    icon: "success"
                                                });
                                                // alert(rs);   
                                                setTimeout(() => {
                                                    document.location.reload();
                                                }, 1500);

                                            }
                                        });



                                    }else{
                                        //else check การลบข้อมูล
                                        // window.location.reload();
                                    }
                                })

                            

                        }
                        function approve_adv(ID)
                        {
                            // alert('Approve');
                            // alert(officer);
                            var officer = document.getElementById('txt_officer').value;    
                            
                            $.ajax({
                                type: 'post',
                                url: 'meg_data.php',
                                data: {
                                    txt_flg: "approve_adv", ID: ID,employeecode: '',employeename: '',price: '',reason: '',datemoney: '',dateapp:'',officerapp:officer
                                },
                                success: function () {
                                    // alert('ลบข้อมูลเรียบร้อย');
                                    // location.reload();
                                    swal.fire({
                                        title: "Good Job!",
                                        text: "อนุมัติการเบิกเรียบร้อย",
                                        showConfirmButton: false,
                                        icon: "success"
                                    });

                                }
                            });

                        }
                        function approve_clashadvall(ID) {
                            
                            var datestart = document.getElementById('txt_datestart').value;
                            var dateend = document.getElementById('txt_dateend').value;
                            var companycode = document.getElementById('select_com').value;
                           
                            // alert("approve all");
                            // alert(datestart);
                            // alert(dateend);
                            // alert(companycode);
                            // alert(ID);
                            $.ajax({
                                type: 'post',
                                url: 'meg_data.php',
                                data: {
                                    txt_flg: "approve_all", datestart: datestart, dateend: dateend,companycode: companycode,ID: ID
                                },
                                success: function (response) {
                                    // alert('อนุมัติการเบิกทั้งหมดเรียบร้อย');
                                    // location.reload();
                                    
                                    swal.fire({
                                        title: "Good Job!",
                                        text: "อนุมัติการเบิกทั้งหมดเรียบร้อย",
                                        showConfirmButton: false,
                                        icon: "success"
                                    });
                                    // alert(rs);   
                                    setTimeout(() => {
                                        document.location.reload();
                                    }, 1500);

                                     
                                }
                            });
                        } 
                        function disapprove_adv(ID)
                        {
                            // alert('Dis Approve');
                            var officer = document.getElementById('txt_officer').value; 
                            
                            $.ajax({
                                type: 'post',
                                url: 'meg_data.php',
                                data: {
                                    txt_flg: "disapprove_adv", ID: ID,employeecode: '',employeename: '',price: '',reason: '',datemoney: '',dateapp:'',officerapp:'',datenoapp:'',officer:officer
                                },
                                success: function () {
                                    // alert('ลบข้อมูลเรียบร้อย');
                                    // location.reload();


                                }
                            });

                        }
                        
                        function print_reportweekall() {
                            
                            var dateheadmonth = document.getElementById('date_headmonth').value;
                            var dateweek1 = document.getElementById('date_week1').value;
                            var dateweek2 = document.getElementById('date_week2').value;
                            var dateweek3 = document.getElementById('date_week3').value;
                            var dateweek4 = document.getElementById('date_week4').value;
                            var dateweek5 = document.getElementById('date_week5').value;
                            var companycode = document.getElementById('select_com').value;
                            
                           
                            // alert(dateheadmonth);
                            // alert(dateweek1);
                            // alert(dateweek2);
                            // alert(dateweek3);
                            // alert(dateweek4);
                            // alert(companycode);

                            var str = dateheadmonth;
                            var arr = str.split(",");
                            var obj = {};

                            for (i = 0; i < arr.length; i++) {
                                if (arr[i] != '') {
                                    if (!obj[arr[i]]) {
                                        obj[arr[i]] = 0;
                                    }
                                    obj[arr[i]]++;

                                }
                               
                            }
                            // // alert(i);
                            
                            // if (i > 5) {
                            //         alert('เลือกวันที่ได้สูงสุด 5 วันเท่านั้น');
                            //     }else{
                            //         window.open('excel_reportclashadvall.php?dateheadmonth=' + dateheadmonth + '&companycode=' + companycode + '&dateweek1=' + dateweek1+ '&dateweek2=' + dateweek2+ '&dateweek3=' + dateweek3+ '&dateweek4=' + dateweek4+ '&dateweek5=' + dateweek5, '_blank');   
                            //     }

                            if (dateheadmonth == '') {
                                // alert('กรุณาระบุวันที่ในการดูรายงาน!!');
                                swal.fire({
                                    title: "Warning !!",
                                    text: "กรุณาระบุวันที่ในการดูรายงาน",
                                    icon: "warning",
                                });
                            }else if(dateweek1 == ''){
                                // alert('กรุณาระบุวันที่ "ข้อมูลสัปดาห์ที่1" !!');
                                swal.fire({
                                    title: "Warning !!",
                                    text: "กรุณาระบุวันที่ (ข้อมูลสัปดาห์ที่1) !!",
                                    icon: "warning",
                                });
                            }else if(dateweek2 == ''){
                                // alert('กรุณาระบุวันที่ "ข้อมูลสัปดาห์ที่2" !!');
                                swal.fire({
                                    title: "Warning !!",
                                    text: "กรุณาระบุวันที่ (ข้อมูลสัปดาห์ที่2) !!",
                                    icon: "warning",
                                });
                            }else if(dateweek3 == ''){
                                // alert('กรุณาระบุวันที่ "ข้อมูลสัปดาห์ที่3" !!');
                                swal.fire({
                                    title: "Warning !!",
                                    text: "กรุณาระบุวันที่ (ข้อมูลสัปดาห์ที่3) !!",
                                    icon: "warning",
                                });
                            }else if(dateweek4 == ''){
                                // alert('กรุณาระบุวันที่ "ข้อมูลสัปดาห์ที่4" !!');    
                                swal.fire({
                                    title: "Warning !!",
                                    text: "กรุณาระบุวันที่ (ข้อมูลสัปดาห์ที่4) !!",
                                    icon: "warning",
                                });
                            }else{
                                if (i > 5) {
                                    // alert('เลือกวันที่ได้สูงสุด 5 วันเท่านั้น');
                                    swal.fire({
                                        title: "Warning !!",
                                        text: "เลือกวันที่ได้สูงสุด 5 วันเท่านั้น",
                                        icon: "warning",
                                    });
                                }else{
                                    window.open('excel_reportclashadvall.php?dateheadmonth=' + dateheadmonth + '&companycode=' + companycode + '&dateweek1=' + dateweek1+ '&dateweek2=' + dateweek2+ '&dateweek3=' + dateweek3+ '&dateweek4=' + dateweek4+ '&dateweek5=' + dateweek5, '_blank');   
                                }
                                
                            }
                            
                        }
                        function print_reportweek() {
                            
                            var datebilling = document.getElementById('date_billing').value;
                            var companycode = document.getElementById('select_com').value;

                            // alert(datebilling);
                            var str = datebilling;
                            var arr = str.split(",");
                            var obj = {};

                            for (i = 0; i < arr.length; i++) {
                                if (arr[i] != '') {
                                    if (!obj[arr[i]]) {
                                        obj[arr[i]] = 0;
                                    }
                                    obj[arr[i]]++;

                                }
                               
                            }
                            // alert(i);
                            
                            
                            if (datebilling == '') {
                                // alert('กรุณาระบุวันที่ในการดูรายงาน!!');
                                swal.fire({
                                    title: "Warning !!",
                                    text: "กรุณาระบุวันที่ในการดูรายงาน!!",
                                    icon: "warning",
                                });
                            }else{
                                if (i > 4) {
                                    // alert('เลือกวันที่ได้สูงสุด 4 วันเท่านั้น');
                                    swal.fire({
                                        title: "Warning !!",
                                        text: "เลือกวันที่ได้สูงสุด 4 วันเท่านั้น",
                                        icon: "warning",
                                    });
                                }else{
                                    window.open('excel_reportclashadvweek.php?datebilling=' + datebilling + '&companycode=' + companycode, '_blank');   
                                }
                                
                            }
                            
                        }

                        function datetodate()
                        {
                            document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

                        }
                        
                       function showdate(date) {
                        //    alert("date"); 
                        var popup = document.getElementById("date_headmonth");
                        popup.classList.toggle("show");
                       }

                        $(function () {
                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                            // กรณีใช้แบบ input
                            $(".dateen").datetimepicker({
                                timepicker: false,
                                format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                            });

                            $('.datebilling').datepicker({
                                format: 'dd/mm/yyyy',
                                language: 'th',
                                multidate: true
                            });

                            $(".dateenweek").datepicker({
                                timepicker: false,
                                format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                multidate: true,
                                daysOfWeekDisabled: "0,2,3,5,6",
                                daysOfWeekHighlighted: "1,4"

                            });

                            $(".datebillingmonth").datepicker({
                                timepicker: false,
                                format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                multidate: true,
                                daysOfWeekDisabled: "0,6",
                                daysOfWeekHighlighted: "1,2,3,4,5"

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
