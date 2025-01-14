<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if (!isset($_SESSION["USERNAME"]) || !isset($_SESSION["PASSWORD"])) {
    header("location:../pages/meg_login.php?data=3");
}
$sql_seSystime = "{call megGetdate_v2(?)}";
$params_seSystime = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
$result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);

$cus = '';
switch ($_GET['customer']) {
    case 'c-tenko': {
            $cus = 'ลูกค้า (TENKO)';
        }
        break;
    default : {
            $cus = '';
        }
}
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
        <!--<link href="../dist/css/sb-admin-2.css" rel="stylesheet">-->
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        <link href="../dist/css/select2.min.css" rel="stylesheet">





        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                var options1 = {
                    target: '#output1', // target element(s) to be updated with server response 
                    beforeSubmit1: beforeSubmit1, // pre-submit callback 
                    success: afterSuccess, // post-submit callback 
                    resetForm: true        // reset the form after successful submit 
                };





                $('#MyUploadForm1').submit(function () {
                    $(this).ajaxSubmit(options1);
                    // always return false to prevent standard browser submit and page navigation 
                    return false;
                });



            });

            function afterSuccess()
            {
                //$('#submit-btn').show(); //hide submit button
                $('#loading-img').hide(); //hide submit button

            }

            //function to check file size before uploading.
            function beforeSubmit1() {
                //check whether browser fully supports all File API
                if (window.File && window.FileReader && window.FileList && window.Blob)
                {

                    if (!$('#txt_editbefore1').val()) //check empty input filed
                    {
                        $("#output1").html("Are you kidding me?");
                        return false
                    }
                    var fsize = $('#txt_editbefore1')[0].files[0].size; //get file size
                    var ftype = $('#txt_editbefore1')[0].files[0].type; // get file type

                    //allow only valid image file types 
                    switch (ftype)
                    {
                        case 'image/png':
                        case 'image/gif':
                        case 'image/jpeg':
                        case 'image/pjpeg':
                            break;
                        default:
                            $("#output").html("<b>" + ftype + "</b> Unsupported file type!");
                            return false
                    }

                    //Allowed file size is less than 1 MB (1048576)
                    if (fsize > 1048576)
                    {
                        $("#output").html("<b>" + bytesToSize(fsize) + "</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
                        return false
                    }

                    $('#submit-btn').hide(); //hide submit button
                    $('#loading-img').show(); //hide submit button
                    $("#output").html("");
                } else
                {
                    //Output error to older browsers that do not support HTML5 File API
                    $("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
                    return false;
                }
            }


            //function to format bites bit.ly/19yoIPO
            function bytesToSize(bytes) {
                var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                if (bytes == 0)
                    return '0 Bytes';
                var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
            }

        </script>
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

            .fileUpload {
                position: relative;
                overflow: hidden;
                margin: 10px;
            }
            .fileUpload input.upload {
                position: absolute;
                top: 0;
                right: 0;
                margin: 0;
                padding: 0;
                font-size: 20px;
                cursor: pointer;
                opacity: 0;
                filter: alpha(opacity=0);
            }

        </style>
    </head>
    <body >

        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header" >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
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

        <div class="modal fade" id="modal_maintenanceplan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 80%">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-5">
                                <h5 class="modal-title" id="title_copydiagram"><b>วางแผนงานซ่อมบำรุง</b></h5>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <font style="color: red">* </font><label>ช่างซ่อมบำรุง :</label>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <i class="glyphicon glyphicon-user"></i> ช่างซ่อมบำรุง
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div id="select_employeemaintenance"></div>

                                            </div>

                                        </div>
                                        <div class="row">&nbsp;</div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <a href="#" data-toggle="modal" onclick="select_employeemaintenanceplan()" data-target="#modal_selectemployee" class="btn btn-default btn-block">เลือกช่างซ่อมบำรุง</a>
                                            </div>
                                        </div>


                                    </div>
                                    <!-- /.panel-body -->
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <font style="color: red">* </font><label>รูปภาพก่อนการวิ่งงาน :</label>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <i class="glyphicon glyphicon-picture"></i> รูปภาพก่อนการวิ่งงาน
                                    </div>
                                    <div class="panel-body">
                                        <div id="select_imagesmaintenance"></div>



                                        <div class="row">&nbsp;</div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <a href="#" data-toggle="modal" data-target="#modal_selectimages" class="btn btn-default btn-block">เลือกรูปภาพก่อนการวิ่งงาน</a>
                                            </div>
                                        </div>


                                    </div>
                                    <!-- /.panel-body -->
                                </div>

                            </div>


                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <font style="color: red">* </font><label>บริษัท :</label>
                                <select id="select_company" name="select_company" class="form-control">

                                    <?php
                                    $sql_seCompany = "{call megCompany_v2(?,?)}";
                                    $params_seCompany = array(
                                        array('select_company', SQLSRV_PARAM_IN),
                                        array('', SQLSRV_PARAM_IN)
                                    );
                                    $query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
                                    while ($result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC)) {
                                        ?>
                                        <option value="<?= $result_seCompany['Company_Code'] ?>"><?= $result_seCompany['Company_NameT'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>

                            </div>
                            <div class="col-lg-3">
                                <font style="color: red">* </font><label>ลูกค้า / สายงาน :</label>
                                <select id="select_customer" name="select_customer" class="form-control">
                                    <?php
                                    $sql_seCustomer = "SELECT DISTINCT [CUSTOMER]+' ('+[MODAL]+')' AS 'CUSTOMER' FROM [dbo].[REPAIRLIST]";
                                    $params_seCustomer = array();
                                    $query_seCustomer = sqlsrv_query($conn, $sql_seCustomer, $params_seCustomer);
                                    while ($result_seCustomer = sqlsrv_fetch_array($query_seCustomer, SQLSRV_FETCH_ASSOC)) {
                                        ?>
                                        <option value="<?= $result_seCustomer['CUSTOMER'] ?>"><?= $result_seCustomer['CUSTOMER'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>


                            </div>
                            <div class="col-lg-3">
                                <font style="color: red">* </font><label>ประเภทรถ :</label>
                                <select id="select_vehicletype" name="select_vehicletype" class="form-control">

                                    <option value="6W">6W</option>
                                    <option value="6W">10W</option>

                                </select>

                            </div>
                            <div class="col-lg-3">
                                <font style="color: red">* </font><label>ทะเบียนรถ :</label>
                                <input class="form-control" id="txt_vehiclenumber" name="txt_vehiclenumber" value="" >

                            </div>

                        </div>

                        <div class="row">&nbsp;</div>

                        <div class="row">

                            <div class="col-lg-6">
                                <font style="color: red">* </font><label>สินค้าบนรถ :</label>
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #f8f8f8;text-align: center">
                                        <label>สินค้าบนรถ</label>
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div class="col-lg-6 text-center">
                                            <div class="form-group">
                                                <label>มี</label>
                                                <input type="radio" checked="" class="form-control" id="ld_product1" name="ld_product">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 text-center">
                                            <div class="form-group">
                                                <label>ไม่มี</label>
                                                <input type="radio" class="form-control" id="ld_product2" name="ld_product">
                                            </div>
                                        </div>

                                    </div>
                                    <!-- .panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>
                            <div class="col-lg-6">
                                <font style="color: red">* </font><label>ลักษณะการวิ่งงาน :</label>
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #f8f8f8;text-align: center">
                                        <label>ลักษณะการวิ่งงาน</label>
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body text-center">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>ก่อนวิ่ง</label>
                                                <input type="radio" checked="" class="form-control" id="ld_runtype1" name="ld_runtype">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 text-center">
                                            <div class="form-group">
                                                <label>ขณะปฏิบัติ</label>
                                                <input type="radio" class="form-control" id="ld_runtype2" name="ld_runtype">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 text-center">
                                            <div class="form-group">
                                                <label>หลังวิ่ง</label>
                                                <input type="radio" class="form-control" id="ld_runtype3" name="ld_runtype">
                                            </div>
                                        </div>

                                    </div>
                                    <!-- .panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <font style="color: red">* </font><label>ลักษณะประเภทงานซ่อม :</label>
                                <select class="form-control" id="cb_maintenancetype" name="cb_maintenancetype">

                                    <option value="ระบบไฟ">ระบบไฟ</option>
                                    <option value="ยางช่วงล่าง">ยางช่วงล่าง</option>
                                    <option value="โครงสร้าง">โครงสร้าง</option>
                                    <option value="เครื่องยนต์">เครื่องยนต์</option>
                                    <option value="อุปกรณ์ประจำรถ">อุปกรณ์ประจำรถ</option>

                                </select>

                            </div>
                            <div class="col-lg-3">&nbsp;</div>

                            <div class="col-lg-3">
                                <font style="color: red">* </font><label>พื้นที่ซ่อม :</label>
                                <select id="select_maintenancearea" name="select_maintenancearea" class="form-control">

                                    <option value="S1 (AMT)">S1 (AMT)</option>
                                    <option value="S2 (AMT)">S2 (AMT)</option>
                                    <option value="S1 (GW)">S1 (GW)</option>
                                    <option value="S2 (GW)">S2 (GW)</option>
                                    <option value="ซ่อมนอก">ซ่อมนอก</option>

                                </select>

                            </div>
                            <div class="col-lg-3">&nbsp;</div>


                        </div>
                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label>ปัญหา :</label>
                                <textarea class="form-control" id="txt_analyzeissue" name="txt_analyzeissue" rows="3"></textarea>

                            </div>
                            <div class="col-lg-6">
                                <label>สถานที่ซ่อม (กรณีซ่อมนอก) :</label>
                                <textarea class="form-control" id="txt_maintenancearea" name="txt_maintenancearea" rows="3"></textarea>

                            </div>
                        </div>
                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="col-lg-4">
                                <font style="color: red">* </font><label>วันที่ต้องการใช้รถ :</label>
                                <input class="form-control dateen" id="txt_datecaruse" name="txt_datecaruse" value="<?= $result_seSystime['SYSDATE'] ?>" readonly="">

                            </div>
                            <div class="col-lg-4">
                                <font style="color: red">* </font><label>วันที่/เวลา เสร็จ : :</label>
                                <input class="form-control dateen" id="txt_datecompleted" name="txt_datecompleted" value="<?= $result_seSystime['SYSDATE'] ?>" readonly="">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                        <button type="button" class="btn btn-primary" onclick="save_maintenanceplan()">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_selectemployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-modal-parent="#modal_maintenanceplan" >
            <div class="modal-dialog" style="width: 40%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title">เลือกช่างซ่อมบำรุง</h5>
                    </div>
                    <div class="modal-body">
                        <div id="modal_selectemployeesr"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="select_employeemaintenance()" >เลือก</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_selectimages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-modal-parent="#modal_maintenanceplan" >
            <div class="modal-dialog" style="width: 40%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title">รูปภาพก่อนการวิ่งงาน</h5>
                    </div>
                    <div class="modal-body">
                        <form action="meg_imagemaintenancebefore.php" method="post" enctype="multipart/form-data" id="MyUploadForm1">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>รูปภาพก่อนการวิ่งงาน</label>
                                        <input name="image_editbefore1"  id="txt_editbefore1" type="file" class="form-control" onchange="upload_images()"/>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>&nbsp;</label><br>
                                        <input style="display: none" type="submit" id="submit-btn">

                                        <input type="button" id="" value="Upload" class="btn btn-default"  onclick="save_imagesmaintenanceplan()"/>

                                    </div>

                                </div>

                            </div>

                            <div id="select_imagesmaintenance2"></div>




                            <div style="display: none" class="col-lg-12" id="output1"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="row" >
            <div class="col-lg-12">
                &nbsp;
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-12" style="text-align: right">
                <input onclick="delete_employeemaintenanceplanall()"  style="margin-right: 15px" type="button"  data-toggle="modal"  data-target="#modal_maintenanceplan"  class=" btn btn-default" value="วางแผนงานซ่อมบำรุง">
            </div>
        </div>
        <div class="row" >
            <div class="col-lg-12">
                &nbsp;
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #e7e7e7">
                        <div class="row">
                            <div class="col-lg-6">
                                <?php
                                echo $link = "<a href='report_customerpm.php'>ลูกค้า</a> / วางแผนงานซ่อมบำรุง ";

                                $_SESSION["link"] = $link;
                                ?>
                            </div>
                            <div class="col-lg-6 text-right"><?= $cus ?></div>
                        </div>
                    </div>
                    <!-- /.panel-heading -->

                    <div class="panel-body">

                        <div class="row" >


                            <div class="col-lg-6">&nbsp;</div>
                            <div class="col-lg-2" >วันที่เริ่มต้น
                                <input type="text" value="<?= $result_seSystime['SYSDATE']; ?>" name="txt_datestartsr" readonly="" id="txt_datestartsr" onchange="datetodate()" class="form-control dateen" >
                            </div>

                            <div class="col-lg-2" >วันที่สิ้นสุด
                                <input type="text" value="<?= $result_seSystime['SYSDATE']; ?>" name="txt_dateendsr" readonly=""  id="txt_dateendsr" class="form-control dateen"  onchange="select_maintenanceplan()">
                            </div>
                            <div class="col-lg-2 " >สถานะ
                                <select  class="form-control" id="cb_status" name="cb_status" onchange="select_maintenanceplan()">

                                    <option   value ="แจ้งซ่อม">แจ้งซ่อม</option>
                                    <option   value ="ยกเลิกการแจ้งซ่อม">ยกเลิกการแจ้งซ่อม</option>
                                    <option   value ="กำลังซ่อม">กำลังซ่อม</option>
                                    <option   value ="ซ่อมเสร็จ">ซ่อมเสร็จ</option>
                                    <option   value ="ยกเลิกการซ่อม">ยกเลิกการซ่อม</option>



                                </select>
                            </div>


                        </div>
                        <div class="row" >&nbsp;</div>

                        <div id="showdatadef">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                        <div id="show_mondaydef">
                                            <table  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example" style="width: 100%;">
                                                <thead >
                                                    <tr>

                                                        <th style="text-align: center;"><label style="width: 50px">DELETE JOB</label></th>
                                                        <th style="text-align: center;"><label style="width: 50px">EDIT JOB</label></th>
                                                        <th style="text-align: center;"><label style="width: 200px">ชื่อ/ทะเบียน รถ</label></th>
                                                        <th style="text-align: center;"><label style="width: 200px">สินค้าบนรถ</label></th>
                                                        <th style="text-align: center;"><label style="width: 200px">ลักษณะการวิ่งงาน</label></th>
                                                        <th style="text-align: center;"><label style="width: 200px">ลักษณะประเภทงานซ่อม</label></th>
                                                        <th style="text-align: center;"><label style="width: 200px">ปัญหา</label></th>
                                                        <th style="text-align: center;"><label style="width: 200px">สถานะการซ่อม</label></th>

                                        <!--<th style="text-align: center;">สายงาน</th>-->


                                                    </tr>

                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $cond1 = " AND CONVERT(DATE,CREATEDATE)=CONVERT(DATE,GETDATE()) AND [REPAIRSTATUS]='แจ้งซ่อม'";
                                                    $sql_seRepairplan = "{call megRepairplan_v2(?,?)}";
                                                    $params_seRepairplan = array(
                                                        array('select_maintenanceplan', SQLSRV_PARAM_IN),
                                                        array($cond1, SQLSRV_PARAM_IN),
                                                    );



                                                    $i = 1;
                                                    $query_seRepairplan = sqlsrv_query($conn, $sql_seRepairplan, $params_seRepairplan);
                                                    while ($result_seRepairplan = sqlsrv_fetch_array($query_seRepairplan, SQLSRV_FETCH_ASSOC)) {
                                                        if ($result_seRepairplan['DRIVINGSTATUS'] == '1') {
                                                            $DRIVINGSTATUS = 'มี';
                                                        } else {
                                                            $DRIVINGSTATUS = 'ไม่มี';
                                                        }
                                                        if ($result_seRepairplan['REPAIRTYPE'] == '1') {
                                                            $REPAIRTYPE = 'ก่อนวิ่ง';
                                                        } else if ($result_seRepairplan['REPAIRTYPE'] == '2') {
                                                            $REPAIRTYPE = 'ขณะปฏิบัติ';
                                                        } else {
                                                            $REPAIRTYPE = 'หลังวิ่ง';
                                                        }
                                                        ?>
                                                        <tr>

                                                            <td style="text-align: center;" ><?= $i ?></td>
                                                            <td style="text-align: center;">
                                                                <button onclick="update_maintenanceplan('RKL', '78-6866', '2', '3', 'ระบบไฟ', 'ไฟส่องป้ายทะเบียนไม่ติด')"  data-toggle="modal"  data-target="#modal_maintenanceplan"  title="แก้ไขแผนงานซ่อมบำรุง" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></button>
                                                            </td>
                                                            <td><?= $result_seRepairplan['VEHICLEREGISNUMBER'] ?></td>
                                                            <td><?= $result_seRepairplan['CARPRODUCT'] ?></td>
                                                            <td><?= $DRIVINGSTATUS ?></td>
                                                            <td><?= $REPAIRTYPE ?></td>
                                                            <td><?= $result_seRepairplan['ANALYZEISSUE'] ?></td>
                                                            <td style="text-align: center"><?= $result_seRepairplan['REPAIRSTATUS'] ?></td>
                                                        </tr>

    <?php
    $i++;
}
?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id="showdatasr">
                        </div>
                    </div>

                </div>
            </div>
        </div>
<?php
if ($_GET['companycode'] == 'RRC' || $_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RATC') {
    $thainame = select_carautocomplate('megVehicleinfo_v2', 'selectcond_vehicleinfo', " AND a.THAINAME != '-' AND (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%'", " OR a.THAINAME LIKE '%ดินแดง%'  OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%'  ", " OR a.THAINAME LIKE '%RP-%' OR a.THAINAME  LIKE '%สวนผึ้ง%' OR a.THAINAME  LIKE '%ด่านช้าง%'", " OR a.ENGNAME LIKE '%Khao Chamao%' OR a.ENGNAME LIKE '%Kerry%' OR a.ENGNAME LIKE '%Chaloem Prakiat%' OR a.THAINAME LIKE '%แปลงยาว%' OR a.THAINAME LIKE '%สนามชัยเขต%' OR a.THAINAME LIKE '%วานรนิวาส%' OR a.THAINAME LIKE '%เฉลิมพระเกียรติ%')");
} else {
    $thainame = select_vehiclenumberautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', '');
}
?>
        <!--<script src="../vendor/jquery/jquery.min.js"></script>-->
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>
        <script src="../dist/js/bootstrap-select.js"></script>
        <script src="../dist/js/select2.js"></script>



        <script src="../vendor/raphael/raphael.min.js"></script>

        <script src="../dist/js/jszip.min.js"></script>
        <script src="../dist/js/dataTables.buttons.min.js"></script>
        <script src="../dist/js/buttons.html5.min.js"></script>
        <script src="../dist/js/buttons.print.min.js"></script>

    </body>

    <script>
                                                                    function update_maintenanceplan(company, vehiclenumber, carproduct, drivingstatus, repairtype, analyzeissue)
                                                                    {
                                                                        delete_employeemaintenanceplanall();

                                                                        document.getElementById('select_company').value = company;
                                                                        document.getElementById('txt_vehiclenumber').value = vehiclenumber;
                                                                        if (carproduct == '1')
                                                                        {
                                                                            document.getElementById("ld_product1").checked = true;
                                                                        } else
                                                                        {
                                                                            document.getElementById("ld_product2").checked = true;
                                                                        }
                                                                        if (drivingstatus == '1')
                                                                        {
                                                                            document.getElementById("ld_runtype1").checked = true;
                                                                        } else if (drivingstatus == '2')
                                                                        {
                                                                            document.getElementById("ld_runtype2").checked = true;
                                                                        } else
                                                                        {
                                                                            document.getElementById("ld_runtype3").checked = true;
                                                                        }
                                                                        document.getElementById('cb_maintenancetype').value = repairtype;
                                                                        document.getElementById('txt_analyzeissue').value = analyzeissue;
                                                                    }


                                                                    function upload_images()
                                                                    {

                                                                        document.getElementById("submit-btn").click()

                                                                    }
                                                                    function select_imagesmaintenance()
                                                                    {
                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_imagesmaintenance"
                                                                            },
                                                                            success: function (rs) {

                                                                                document.getElementById("select_imagesmaintenance").innerHTML = rs;
                                                                                document.getElementById("select_imagesmaintenance2").innerHTML = rs;


                                                                            }

                                                                        });

                                                                    }

                                                                    function select_maintenanceplan()
                                                                    {



                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_maintenanceplan",
                                                                                datestartsr: document.getElementById('txt_datestartsr').value,
                                                                                dateendsr: document.getElementById('txt_dateendsr').value,
                                                                                status: document.getElementById('cb_status').value
                                                                            },
                                                                            success: function (rs) {

                                                                                document.getElementById("showdatadef").innerHTML = "";
                                                                                document.getElementById("showdatasr").innerHTML = rs;

                                                                                $(document).ready(function () {
                                                                                    $('#dataTables-example').DataTable({

                                                                                        order: [[0, "desc"]],
                                                                                        scrollX: true,
                                                                                        scrollY: '500px',
                                                                                    });
                                                                                });


                                                                            }


                                                                        });

                                                                    }
                                                                    function select_employeemaintenance()
                                                                    {
                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_employeemaintenance"
                                                                            },
                                                                            success: function (rs) {

                                                                                document.getElementById("select_employeemaintenance").innerHTML = rs;

                                                                            }


                                                                        });

                                                                    }
                                                                    function delete_employeemaintenanceplan(employeecode, employeename)
                                                                    {


                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "delete_repairemployee", employeecode: employeecode, employeename: employeename
                                                                            },
                                                                            success: function () {
                                                                                select_employeemaintenance();
                                                                                select_imagesmaintenance();
                                                                            }
                                                                        });


                                                                    }
                                                                    function delete_employeemaintenanceplanall()
                                                                    {


                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "delete_repairemployeeall"
                                                                            },
                                                                            success: function () {
                                                                                select_employeemaintenance();
                                                                                select_imagesmaintenance();
                                                                            }
                                                                        });


                                                                    }

                                                                    function save_maintenanceplan()
                                                                    {
                                                                        var ldproduct = "";
                                                                        var ldruntype = "";
                                                                        if (ld_product1.checked == true)
                                                                        {
                                                                            ldproduct = '1';
                                                                        }
                                                                        if (ld_product2.checked == true)
                                                                        {
                                                                            ldproduct = '2';
                                                                        }
                                                                        if (ld_runtype1.checked == true)
                                                                        {
                                                                            ldruntype = '1'
                                                                        }
                                                                        if (ld_runtype2.checked == true)
                                                                        {
                                                                            ldruntype = '2'
                                                                        }
                                                                        if (ld_runtype3.checked == true)
                                                                        {
                                                                            ldruntype = '3'
                                                                        }
                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "save_maintenanceplan",
                                                                                CONDITION1: '',
                                                                                COMPANY: document.getElementById('select_company').value,
                                                                                CUSTOMER: document.getElementById('select_customer').value,
                                                                                VEHICLETYPE: document.getElementById('select_vehicletype').value,
                                                                                VEHICLEREGISNUMBER: document.getElementById('txt_vehiclenumber').value,
                                                                                REPAIRAREA: document.getElementById('select_maintenancearea').value,
                                                                                REPAIRAREADETAIL: document.getElementById('txt_maintenancearea').value,
                                                                                CARUSEDATE: document.getElementById('txt_datecaruse').value,
                                                                                REPAIRTYPE: document.getElementById('cb_maintenancetype').value,
                                                                                CARPRODUCT: ldproduct,
                                                                                DRIVINGSTATUS: ldruntype,
                                                                                ANALYZEISSUE: document.getElementById('txt_analyzeissue').value,
                                                                                REPAIRSTATUS: 'แจ้งซ่อม',
                                                                            },
                                                                            success: function (rs) {
                                                                                alert(rs);
                                                                                window.location.reload();
                                                                            }
                                                                        });
                                                                    }
                                                                    function save_employeemaintenanceplan(employeecode, employeename)
                                                                    {

                                                                        if (document.getElementById("chk_" + employeecode).checked == true)
                                                                        {
                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {
                                                                                    txt_flg: "save_repairemployee", employeecode: employeecode, employeename: employeename
                                                                                },
                                                                                success: function () {

                                                                                }
                                                                            });
                                                                        } else
                                                                        {
                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {
                                                                                    txt_flg: "delete_repairemployee", employeecode: employeecode, employeename: employeename
                                                                                },
                                                                                success: function () {

                                                                                }
                                                                            });
                                                                        }

                                                                    }
                                                                    function select_employeemaintenanceplan()
                                                                    {
                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_employeemaintenanceplan"
                                                                            },
                                                                            success: function (rs) {

                                                                                document.getElementById("modal_selectemployeesr").innerHTML = rs;
                                                                                $(document).ready(function () {
                                                                                    $('#dataTables-example2').DataTable();
                                                                                });
                                                                            }

                                                                        });

                                                                    }

                                                                    $(document).ready(function () {
                                                                        $('#dataTables-example').DataTable({

                                                                            order: [[0, "desc"]],
                                                                            scrollX: true,
                                                                            scrollY: '500px',
                                                                        });
                                                                    });


                                                                    $(function () {
                                                                        $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                        // กรณีใช้แบบ input
                                                                        $(".dateen").datetimepicker({
                                                                            timepicker: false,
                                                                            format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                                            lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

                                                                        });
                                                                    });
                                                                    var txt_vehiclenumber = [<?= $thainame ?>];
                                                                    $("#txt_vehiclenumber").autocomplete({
                                                                        source: [txt_vehiclenumber]
                                                                    });
                                                                    function datetodate()
                                                                    {
                                                                        document.getElementById('txt_dateendsr').value = document.getElementById('txt_datestartsr').value;
                                                                        select_maintenanceplan();
                                                                    }
                                                                    function save_imagesmaintenanceplan()
                                                                    {
                                                                        var beforeedit = document.getElementById('IMGBEFORE1').value;
                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "save_repairimages", type: 'BEFORE', path: beforeedit
                                                                            },
                                                                            success: function () {
                                                                                select_imagesmaintenance();
                                                                            }
                                                                        });
                                                                    }
    </script>
</html>
<?php
sqlsrv_close($conn);
?>
