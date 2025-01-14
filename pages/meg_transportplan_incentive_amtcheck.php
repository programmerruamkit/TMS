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
        <title>กลุ่มร่วมกิจรุ่งเรือง (<?=date("d/m/Y")?>)</title>
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">

        <!-- Sweet Alert -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap.min.css">
        
         <!-- data table css -->
        <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">

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
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">        
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
                <li>
                    <font style="color:#337ab7 "><?= $result_seEHR['nameT'] ?></font>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        
                        <li><a href="meg_logout.php"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

            <!-- <div id="page-wrapper" > -->
                <div class="row">&nbsp;</div>
                <div class="row" >
                    <div class="col-lg-12" style="text-align: center">
                        <h2 class="page-header">ตรวจสอบข้อมูลการวิ่งงาน</h2>
                    </div>
                    <!-- <div class="col-lg-4" style="text-align: center" >
                        <h2 class="page-header"> (<?=$_SESSION["USERNAME"]?>&nbsp;&nbsp;<?=$result_seEHR['nameT']?>)</h2>
                    </div> -->
                    <div class="col-lg-12" style="text-align: center">
                        <input style="display:none" type="" id="txt_dateapp" name="txt_dateapp" value ="<?=$result_seSystime['SYSDATE']?>">
                        <input style="display:none" type="" id="txt_officer" name="txt_officer" value ="<?=$_SESSION["USERNAME"]?>">
                    </div>
                    
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row" >
                    <div class="col-lg-12">
                    <input type="text" hidden id="txtCheckIn" placeholder="* Check-In Date (M/D/Y)" readonly>
                    <input type="text" hidden id="txtCheckOut" placeholder="* Check-Out Date (M/D/Y)" readonly>
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
                                                            <label>ค้นหาตามช่วงวันที่ </label>
                                                            <input class="form-control dateen" readonly="" onchange=datetodate(); style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateend" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                      <label>เลือกบริษัท</label>
                                                      <select id="select_com" name="select_com" class="form-control" onchange="select_customer(this.value)">
                                                          <option value="00" disabled selected >เลือกบริษัท</option>
                                                          <option value="RKS">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส</option>
                                                          <option value="RKR">บริษัท ร่วมกิจรุ่งเรือง (1993)</option>
                                                          <option value="RKL">บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์</option>
                                                      </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                      <label>เลือกลูกค้า</label>
                                                      <div id="datacompdef">
                                                        <select id="select_cus" name="select_cus" class="form-control" class="selectpicker form-control" data-container="body" data-live-search="true">
                                                            <option value="00">เลือกลูกค้า</option>

                                                        </select>
                                                      </div>
                                                      <div id="datacompsr"></div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                      <label>เลือกสถานะ</label>
                                                      <!-- สถานะ A คือ APPROVE , R คือ REJECT  -->
                                                      <select id="select_status" name="select_status" class="form-control">
                                                          <option value="ALL">ทั้งหมด</option>
                                                          <option value="A">อนุมัติ</option>
                                                          <option value="R">ไม่อนุมัติ</option>
                                                      </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" onclick="select_reportincentivecheck()">ค้นหา <li class="fa fa-search"></li></button>
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
                                                        <h4>ประวัติข้อมูลการวิ่งงาน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <!-- <a href="#" onclick="approve_clashadvall('<?= $_SESSION['USERNAME'] ?>');" class="btn btn-success">อนุมัติการเบิกทั้งหมด</a></h4> -->
                                                </div>
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                               
                                                                <thead>
                                                                    <tr style="border:1px solid #000;background-color: #ccc" >
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>ลำดับ</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>วันที่</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>หมายเลขงาน</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>พขร.1</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>พขร.2</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>ต้นทาง</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>โซน</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>ปลายทาง</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>รอบวิ่ง</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>ทะเบียนรถ</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>ไมล์ต้น</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>ไมล์ปลาย</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>รวมระยะทาง</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>จำนวนลิตร</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>ค่าเฉลี่ยน้ำมัน</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>ค่าน้ำมัน</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>จำนวน<br>พาเลท</be></b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>ค่า<br>พาเลท</be></b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>ค่า<br>ตีเปล่า</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>ค่า<br>เทรนนิ่ง</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>ค่า<br>โอเจที</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>ค่า<br>มัลติสกิล</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>ค่าเที่ยว พขร.1</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>ค่าเที่ยว พขร.2</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>รวม<br>รายได้</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>ผู้อนุมัติ</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>สถานะ</b>
                                                                        </td>
                                                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>หมาย <br>เหตุ</b>
                                                                        </td> 
                                                                        </td> <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                                                                            <b>จัดการข้อมูล</b>
                                                                        </td>  
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
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>     
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
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

            <!-- Sweet Alert -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

            <!-- Data Table Export File -->
            <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
            <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
            <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
            <!-- <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script> -->
            <script src="//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json"></script>

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
                        function select_reportincentivecheck()
                        {

                            var datestart = document.getElementById('txt_datestart').value;
                            var dateend = document.getElementById('txt_dateend').value;
                            var companycode  = document.getElementById('select_com').value;
                            var customercode = document.getElementById('select_cus').value;
                            var status = document.getElementById('select_status').value;

                            // alert(datestart);
                            // alert(dateend);
                            // alert(companycode);
                            // alert(customercode);
                            // alert(status);
                            // รูปแบบ เดือน/วัน/ปี

                            // วันที่เริ่มต้น
                            let textdatestart = datestart;
                            //วัน
                            let resultstart1 = textdatestart.substring(0,2);
                            // เดือน
                            let resultstart2 = textdatestart.substring(3,5);
                            // ปี
                            let resultstart3 = textdatestart.substring(6,10);

                            var date1 = new Date(resultstart2+"/"+resultstart1+"/"+resultstart3);

                            ///////////////////////////////////////
                            // รูปแบบ เดือน/วัน/ปี
                            // วันที่สิ้นสุด
                            let textdateend = dateend;
                            //วัน
                            let resultend1 = textdateend.substring(0,2);
                            // เดือน
                            let resultend2 = textdateend.substring(3,5);
                            // ปี
                            let resultend3 = textdateend.substring(6,10);

                            var date2 = new Date(resultend2+"/"+resultend1+"/"+resultend3);
                            ///////////////////////////////////////

                            // var date1 = new Date("01/21/2022");
                            // var date2 = new Date("01/31/2022");

                            var diffTime = date2.getTime() - date1.getTime();
                            var diffDay = diffTime / (1000 * 3600 * 24);


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

                            }else if (customercode == '00'){

                                swal.fire({
                                    title: "Warning !",
                                    text: "กรุณาเลือกลูกค้า",
                                    icon: "warning",
                                });

                            }else if (status == '00'){

                                swal.fire({
                                    title: "Warning !",
                                    text: "กรุณาเลือกสถานะ",
                                    icon: "warning",
                                });

                            }else if (diffDay > "2"){

                                swal.fire({
                                    title: "Warning !",
                                    text: "เลือกข้อมูลสูงสุดได้ 2 วันเท่านั้น",
                                    icon: "warning",
                                });

                            }else{

                                showLoading();
                                $.ajax({
                                    type: 'post',
                                    url: 'meg_data_transportplan_incentive_check.php',
                                    data: {
                                        txt_flg: "select_transportplan_incentive_check_amtdata", datestart: datestart, dateend: dateend,companycode: companycode,customercode: customercode,status: status
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
                                                order: [[1, 'desc']],
                                                // responsive: true,
                                                scrollX: true,
                                                // scrollY: '500px',
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
                                                    // { extend: 'csvHtml5', footer: true },
                                                    { extend: 'excelHtml5', footer: true,messageTop: 'ข้อมูลแผนการวิ่งงาน ข้อมูลวันที่'+' '+datestart+' '+'ถึง'+' '+dateend }
                                                    // 'pageLength','csv', 'excel'
                                                ]
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
                        // function delete_adv(ID)
                        // {
                              
                        //         Swal.fire({
                        //             title: 'ต้องการลบข้อมูล?',
                        //             text: "กรุณากด 'ตกลง' เพื่อยืนยันการลบข้อมูล!!!",
                        //             icon: 'warning',
                        //             showCancelButton: true,
                        //             confirmButtonColor: '#3085d6',
                        //             cancelButtonColor: '#d33',
                        //             confirmButtonText: 'ตกลง',
                        //             cancelButtonText: 'ยกเลิก'
                        //         }).then((result) => {
                                    
                        //             if (result.isConfirmed) {
                                        
                        //                 $.ajax({
                        //                     type: 'post',
                        //                     url: 'meg_data.php',
                        //                     data: {
                        //                         txt_flg: "delete_adv", ID: ID,employeecode: '',employeename: '',price: '',reason: '',datemoney: ''
                        //                     },
                        //                     success: function (rs) {
                        //                         // alert('ลบข้อมูลเรียบร้อย');
                        //                         // location.reload();

                        //                         swal.fire({
                        //                             title: "Good Job!",
                        //                             text: "ลบข้อมูลเรียบร้อย",
                        //                             showConfirmButton: false,
                        //                             icon: "success"
                        //                         });
                        //                         // alert(rs);   
                        //                         setTimeout(() => {
                        //                             document.location.reload();
                        //                         }, 1500);

                        //                     }
                        //                 });



                        //             }else{
                        //                 //else check การลบข้อมูล
                        //                 // window.location.reload();
                        //             }
                        //         })

                            

                        // }
                        function approve_plan(planid)
                        {
                            // alert('Approve');
                            // alert(officer);

                            
                            var approveby = document.getElementById('txt_officer').value;    
                            var status  = 'A';

                            // alert(planid);
                            // alert(approveby);

                            $.ajax({
                                type: 'post',
                                url: 'meg_data2.php',
                                data: {
                                    txt_flg: "approve_planamt", planid: planid,approveby:approveby,status:status
                                },
                                success: function () {
                                    // alert('ลบข้อมูลเรียบร้อย');
                                    // location.reload();

                                    swal.fire({
                                        title: "Good Job!",
                                        text: "อนุมัติแผนงานเรียบร้อย",
                                        showConfirmButton: true,
                                        icon: "success"
                                    });

                                }
                            });

                        }
                        function disapprove_adv(planid)
                        {
                            // alert('Dis Approve');
                            var disapproveby = document.getElementById('txt_officer').value;    
                            var status  = 'R';

                            // alert(planid);
                            // alert(status);

                            $.ajax({
                                type: 'post',
                                url: 'meg_data2.php',
                                data: {
                                    txt_flg: "disapprove_planamt", planid: planid,disapproveby:disapproveby,status:status
                                },
                                success: function () {
                                    // alert('ลบข้อมูลเรียบร้อย');
                                    // location.reload();

                                    swal.fire({
                                        title: "Good Job!",
                                        text: "ไม่อนุมัติแผนงานเรียบร้อย",
                                        showConfirmButton: true,
                                        icon: "success"
                                    });

                                }
                            });

                        }
                        // function approve_clashadvall(ID) {
                            
                        //     var datestart = document.getElementById('txt_datestart').value;
                        //     var dateend = document.getElementById('txt_dateend').value;
                        //     var companycode = document.getElementById('select_com').value;
                           
                        //     // alert("approve all");
                        //     // alert(datestart);
                        //     // alert(dateend);
                        //     // alert(companycode);
                        //     // alert(ID);
                        //     $.ajax({
                        //         type: 'post',
                        //         url: 'meg_data.php',
                        //         data: {
                        //             txt_flg: "approve_all", datestart: datestart, dateend: dateend,companycode: companycode,ID: ID
                        //         },
                        //         success: function (response) {
                        //             // alert('อนุมัติการเบิกทั้งหมดเรียบร้อย');
                        //             // location.reload();
                                    
                        //             swal.fire({
                        //                 title: "Good Job!",
                        //                 text: "อนุมัติการเบิกทั้งหมดเรียบร้อย",
                        //                 showConfirmButton: false,
                        //                 icon: "success"
                        //             });
                        //             // alert(rs);   
                        //             setTimeout(() => {
                        //                 document.location.reload();
                        //             }, 1500);

                                     
                        //         }
                        //     });
                        // } 
                        

                        function datetodate()
                        {
                            document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

                        }
                        
                    //    function showdate(date) {
                    //     //    alert("date"); 
                    //     var popup = document.getElementById("date_headmonth");
                    //     popup.classList.toggle("show");
                    //    }

                        $(function () {
                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                            // กรณีใช้แบบ input
                            $(".dateen").datetimepicker({
                                timepicker: false,
                                format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

                            });

                            // $('.datebilling').datepicker({
                            //     format: 'dd/mm/yyyy',
                            //     language: 'th',
                            //     multidate: true
                            // });

                            // $(".dateenweek").datepicker({
                            //     timepicker: false,
                            //     format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                            //     lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                            //     multidate: true,
                            //     daysOfWeekDisabled: "0,2,3,5,6",
                            //     daysOfWeekHighlighted: "1,4"

                            // });

                            // $(".datebillingmonth").datepicker({
                            //     timepicker: false,
                            //     format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                            //     lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                            //     multidate: true,
                            //     daysOfWeekDisabled: "0,6",
                            //     daysOfWeekHighlighted: "1,2,3,4,5"

                            // });

                        });

                        

                        $(document).ready(function () {
                            $('#dataTables-example').DataTable({
                                order: [[1, 'desc']],
                                responsive: true,
                                scrollX: true,
                                // scrollY: '500px',
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

                        

            </script>


    </body>

    




</html>
<?php
sqlsrv_close($conn);
?>
