<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
$condition1 = " AND a.EMPLOYEEID = " . $_GET['employeeid'];

$conditionEHR = " AND a.PersonCode ='" . $_GET['employeeid'] . "'";
$sql_seEHR = "{call megEmployeeEHR_v2(?,?)}";
$params_seEHR = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($conditionEHR, SQLSRV_PARAM_IN)
);
$query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
$result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);

$conditionEHR1 = " AND a.PersonID ='" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEHR1 = "{call megEmployeeEHR_v2(?,?)}";
$params_seEHR1 = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($conditionEHR1, SQLSRV_PARAM_IN)
);
$query_seEHR1 = sqlsrv_query($conn, $sql_seEHR1, $params_seEHR1);
$result_seEHR1 = sqlsrv_fetch_array($query_seEHR1, SQLSRV_FETCH_ASSOC);

$nameT = ($result_seEHR1['Company_Code'] == 'RTD') ? $result_seEHR1['nameT'] : '';

$readonly_rtd = ($result_seEHR1['Company_Code'] != 'RTD') ? " disabled readonly style='background-color: #f080802e'" : "";
$readonly_tenko = ($result_seEHR1['Company_Code'] == 'RTD') ? " disabled readonly style='background-color: #f080802e'" : "";
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
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
        <style>
            .navbar-default {

                border-color: #ffcb0b;
            }
            #page-wrapper {
                border-left: 1px solid #ffcb0b;
            }
        </style>


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

                var options2 = {
                    target: '#output2', // target element(s) to be updated with server response 
                    beforeSubmit2: beforeSubmit2, // pre-submit callback 
                    success: afterSuccess, // post-submit callback 
                    resetForm: true        // reset the form after successful submit 
                };
                var options3 = {
                    target: '#output3', // target element(s) to be updated with server response 
                    beforeSubmit3: beforeSubmit3, // pre-submit callback 
                    success: afterSuccess, // post-submit callback 
                    resetForm: true        // reset the form after successful submit 
                };
                var options4 = {
                    target: '#output4', // target element(s) to be updated with server response 
                    affterSubmit1: affterSubmit1, // pre-submit callback 
                    success: afterSuccess, // post-submit callback 
                    resetForm: true        // reset the form after successful submit 
                };
                var options5 = {
                    target: '#output5', // target element(s) to be updated with server response 
                    affterSubmit2: affterSubmit2, // pre-submit callback 
                    success: afterSuccess, // post-submit callback 
                    resetForm: true        // reset the form after successful submit 
                };
                var options6 = {
                    target: '#output6', // target element(s) to be updated with server response 
                    affterSubmit3: affterSubmit3, // pre-submit callback 
                    success: afterSuccess, // post-submit callback 
                    resetForm: true        // reset the form after successful submit 
                };



                $('#MyUploadForm1').submit(function () {
                    $(this).ajaxSubmit(options1);
                    // always return false to prevent standard browser submit and page navigation 
                    return false;
                });
                $('#MyUploadForm2').submit(function () {
                    $(this).ajaxSubmit(options2);
                    // always return false to prevent standard browser submit and page navigation 
                    return false;
                });
                $('#MyUploadForm3').submit(function () {
                    $(this).ajaxSubmit(options3);
                    // always return false to prevent standard browser submit and page navigation 
                    return false;
                });
                $('#MyUploadForm4').submit(function () {
                    $(this).ajaxSubmit(options4);
                    // always return false to prevent standard browser submit and page navigation 
                    return false;
                });
                $('#MyUploadForm5').submit(function () {
                    $(this).ajaxSubmit(options5);
                    // always return false to prevent standard browser submit and page navigation 
                    return false;
                });
                $('#MyUploadForm6').submit(function () {
                    $(this).ajaxSubmit(options6);
                    // always return false to prevent standard browser submit and page navigation 
                    return false;
                });


            });

            function afterSuccess()
            {
                $('#submit-btn').show(); //hide submit button
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
            function beforeSubmit2() {
                //check whether browser fully supports all File API
                if (window.File && window.FileReader && window.FileList && window.Blob)
                {


                    if (!$('#txt_editbefore2').val()) //check empty input filed
                    {
                        $("#output2").html("Are you kidding me?");
                        return false
                    }





                    var fsize = $('#txt_editbefore2')[0].files[0].size; //get file size
                    var ftype = $('#txt_editbefore2')[0].files[0].type; // get file type







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
            function beforeSubmit3() {
                //check whether browser fully supports all File API
                if (window.File && window.FileReader && window.FileList && window.Blob)
                {


                    if (!$('#txt_editbefore3').val()) //check empty input filed
                    {
                        $("#output2").html("Are you kidding me?");
                        return false
                    }





                    var fsize = $('#txt_editbefore3')[0].files[0].size; //get file size
                    var ftype = $('#txt_editbefore3')[0].files[0].type; // get file type







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
            function affterSubmit1() {
                //check whether browser fully supports all File API
                if (window.File && window.FileReader && window.FileList && window.Blob)
                {


                    if (!$('#txt_editaffter1').val()) //check empty input filed
                    {
                        $("#output4").html("Are you kidding me?");
                        return false
                    }





                    var fsize = $('#txt_editaffter1')[0].files[0].size; //get file size
                    var ftype = $('#txt_editaffter1')[0].files[0].type; // get file type







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
            function affterSubmit2() {
                //check whether browser fully supports all File API
                if (window.File && window.FileReader && window.FileList && window.Blob)
                {


                    if (!$('#txt_editaffter2').val()) //check empty input filed
                    {
                        $("#output5").html("Are you kidding me?");
                        return false
                    }





                    var fsize = $('#txt_editaffter2')[0].files[0].size; //get file size
                    var ftype = $('#txt_editaffter2')[0].files[0].type; // get file type







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
            function affterSubmit3() {
                //check whether browser fully supports all File API
                if (window.File && window.FileReader && window.FileList && window.Blob)
                {


                    if (!$('#txt_editaffter3').val()) //check empty input filed
                    {
                        $("#output6").html("Are you kidding me?");
                        return false
                    }





                    var fsize = $('#txt_editaffter3')[0].files[0].size; //get file size
                    var ftype = $('#txt_editaffter3')[0].files[0].type; // get file type







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
        <link href="style/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>

        <div class="modal fade" id="modal_image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div id="modalimage"></div>
            </div>
        </div>
        <div class="modal fade" id="modal_imgaffter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title_copyjob">COPY JOB</h5>

                    </div>
                    <div class="modal-body">
                        <div class="row" >
                            <div class="col-lg-6">
                                <div class="form-group">

                                    <label>จำนวน (JOB) : </label>

                                    <input class="form-control" id="txt_startdatejobcopy" name="txt_startdatejobcopy" style="display: none"> 
                                    <input class="form-control" id="txt_rowsamount" name="txt_rowsamount" > 

                                </div>
                            </div>
                        </div>
                        <div class="row">&nbsp;</div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="button" class="btn btn-primary" onclick="save_copyjob()">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

                <?php
                include '../pages/meg_header.php';
                include '../pages/meg_leftmenu.php';
                ?>
            </nav>


            <div id="page-wrapper">
                <p>&nbsp;</p>

                <div id="datade_edit">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    ข้อมูลการรับแจ้ง
                                </div>
                                <div id="datadef_edit">
                                    <div class="panel-body">
                                        <div class="row" >
                                            <div class="col-lg-6" >
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #f8f8f8;">
                                                        <label>เจ้าหน้าที่ Tenko : <?= ($result_seEHR1['Company_Code'] != 'RTD') ? $result_seEHR1['nameT'] : ''; ?></label>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">

                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                            <div class="row" >
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label>พนักงาน : <font style="color: red">*</font></label>
                                                                        <input <?= $readonly_tenko ?>  class="form-control" type="text" id="txt_employee1" name="txt_employee1" value="">
                                                                        
                                                                    </div>

                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label>ทะเบียนรถ : <font style="color: red">*</font></label>
                                                                        <input style="display: none"  name="txt_chkbefore1"  id="txt_chkbefore1" type="text" class="form-control"/>
                                                                        <input style="display: none"  name="txt_chkbefore2"  id="txt_chkbefore2" type="text" class="form-control"/>
                                                                        <input style="display: none"  name="txt_chkbefore3"  id="txt_chkbefore3" type="text" class="form-control"/>
                                                                        <input  style="display: none" name="txt_chkaffter1"  id="txt_chkaffter1" type="text" class="form-control"/>
                                                                        <input  style="display: none" name="txt_chkaffter2"  id="txt_chkaffter2" type="text" class="form-control"/>
                                                                        <input  style="display: none" name="txt_chkaffter3"  id="txt_chkaffter3" type="text" class="form-control"/>
                                                                        <input <?= $readonly_tenko ?> class="form-control" type="text" id="txt_carname" name="txt_carname"  value="" >

                                                                    </div>

                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>สถานะการซ่อม : <font style="color: red">*</font></label>
                                                                        <select class="form-control" onchange="change_repairstatus()" id="cb_repairstatus1" name="cb_repairstatus1" <?= $readonly_tenko ?>>
                                                                            <option   value ="">เลือกสถานะการซ่อม</option>
                                                                            <option   value ="แจ้งซ่อม">แจ้งซ่อม</option>
                                                                            <option   value ="ยกเลิกแจ้งซ่อม">ยกเลิกแจ้งซ่อม</option>
                                                                            <option   value ="กำลังซ่อม">กำลังซ่อม</option>
                                                                            <option   value ="ซ่อมเสร็จ">ซ่อมเสร็จ</option>
                                                                            <option   value ="ยกเลิกซ่อม">ยกเลิกซ่อม</option>

                                                                        </select>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="row" >

                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>ต้องการใช้รถ : <font style="color: red">*</font></label>
                                                                        <input type="text" class="form-control datetimeen" readonly="" style="background-color: #f080802e" id="txt_carusedate" name="txt_carusedate">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">




                                                                        <label>ลักษณะประเภทงานซ่อม : <font style="color: red">*</font></label>
                                                                        <select onchange="change_repairtype()" class="form-control" id="cb_repairtype" name="cb_repairtype" <?= $readonly_tenko ?>>
                                                                            <option   value ="">เลือกลักษณะประเภทงานซ่อม</option>
                                                                            <option   value ="ระบบไฟ">ระบบไฟ</option>
                                                                            <option   value ="ยางช่วงล่าง">ยางช่วงล่าง</option>
                                                                            <option   value ="โครงสร้าง">โครงสร้าง</option>
                                                                            <option   value ="เครื่องยนต์">เครื่องยนต์</option>
                                                                            <option   value ="อุปกรณ์ประจำรถ">อุปกรณ์ประจำรถ</option>

                                                                        </select>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                            <div class="row" >

                                                                <div class="col-lg-4">
                                                                    <div class="panel panel-default">
                                                                        <div class="panel-heading" style="background-color: #f8f8f8;text-align: center">
                                                                            <label>สินค้า</label>
                                                                        </div>
                                                                        <!-- /.panel-heading -->
                                                                        <div class="panel-body" >
                                                                            <div class="col-lg-6 text-center">
                                                                                <div class="form-group">
                                                                                    <label>มี</label>
                                                                                    <input type="radio" checked=""  class="form-control" id="ld_product1" name="ld_product" >
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6 text-center">
                                                                                <div class="form-group">
                                                                                    <label>ไม่มี</label>
                                                                                    <input type="radio"  class="form-control" id="ld_product2" name="ld_product">
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <!-- .panel-body -->
                                                                    </div>
                                                                    <!-- /.panel -->
                                                                </div>
                                                                <div class="col-lg-8">
                                                                    <div class="panel panel-default">
                                                                        <div class="panel-heading" style="background-color: #f8f8f8;text-align: center">
                                                                            <label>ลักษณะการวิ่งงาน</label>
                                                                        </div>
                                                                        <!-- /.panel-heading -->
                                                                        <div class="panel-body text-center" >
                                                                            <div class="col-lg-4" >
                                                                                <div class="form-group">
                                                                                    <label>ก่อนวิ่ง</label>
                                                                                    <input type="radio" checked="" class="form-control" id="ld_runtype1" name="ld_runtype">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4 text-center" >
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
                                                            <div class="row" >

                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label>ปัญหา :</label>
                                                                        <textarea <?= $readonly_tenko ?> class="form-control" autocomplete="off" rows="5" id="txt_issue" name="txt_issue" ></textarea>


                                                                    </div>

                                                                </div>

                                                            </div>




                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #f8f8f8;">
                                                        <label>เจ้าหน้าที่ ผู้รับแจ้งซ่อม : <?= $nameT ?></label>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body" >

                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                            <div class="row" >

                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>ผู้รับแจ้งซ่อม</label>
                                                                        <input  class="form-control"  style="background-color: #f080802e" disabled="" readonly="" <?= $readonly_rtd ?> id="txt_empinform2" name="txt_empinform2"  value="<?= $nameT ?>" >

                                                                    </div>

                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>ช่างผู้รับผิดชอบ</label>
                                                                        <input  class="form-control" <?= $readonly_rtd ?> id="txt_technician" name="txt_technician"  value="" >
                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="row" >
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>กำหนดเสร็จ :</label>
                                                                        <input  class="form-control datetimeen" <?= $readonly_rtd ?> readonly="" id="txt_completed" name="txt_completed"  value="" >

                                                                    </div>

                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>สาเหตุ :</label>
                                                                        <input class="form-control" <?= $readonly_rtd ?> id="txt_cause" name="txt_cause"  value="" >

                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="row" >


                                                            </div>
                                                            <div class="row" >
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>การแก้ไข :</label>
                                                                        <input class="form-control" <?= $readonly_rtd ?> id="txt_edit" name="txt_edit"  value="">

                                                                    </div>

                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>การป้องกัน :</label>
                                                                        <input class="form-control" <?= $readonly_rtd ?> id="txt_protect" name="txt_protect"  value="">

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="row" >
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>สถานะการซ่อม :</label>
                                                                        <select class="form-control" onchange="change_repairstatus2()" id="cb_repairstatus2" name="cb_repairstatus2" <?= $readonly_rtd ?>>
                                                                            <option   value ="">เลือกสถานะการซ่อม</option>
                                                                            <option   value ="แจ้งซ่อม">แจ้งซ่อม</option>
                                                                            <option   value ="ยกเลิกแจ้งซ่อม">ยกเลิกแจ้งซ่อม</option>
                                                                            <option   value ="กำลังซ่อม">กำลังซ่อม</option>
                                                                            <option   value ="ซ่อมเสร็จ">ซ่อมเสร็จ</option>
                                                                            <option   value ="ยกเลิกซ่อม">ยกเลิกซ่อม</option>

                                                                        </select>
                                                                    </div>

                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">




                                                                        <label>ลักษณะประเภทงานซ่อม :</label>
                                                                        <select onchange="change_repairtype2()" class="form-control" id="cb_repairtype2" name="cb_repairtype2" <?= $readonly_rtd ?>>
                                                                            <option   value ="">เลือกลักษณะประเภทงานซ่อม</option>
                                                                            <option   value ="ระบบไฟ">ระบบไฟ</option>
                                                                            <option   value ="ยางช่วงล่าง">ยางช่วงล่าง</option>
                                                                            <option   value ="โครงสร้าง">โครงสร้าง</option>
                                                                            <option   value ="เครื่องยนต์">เครื่องยนต์</option>
                                                                            <option   value ="อุปกรณ์ประจำรถ">อุปกรณ์ประจำรถ</option>

                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row" >
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>การวิเคาะห์การซ่อม :</label>
                                                                        <select class="form-control" id="cb_repairanalyze2" name="cb_repairanalyze2" <?= $readonly_rtd ?>>
                                                                            <option   value ="">เลือกการวิเคาะห์การซ่อม</option>
                                                                            <option   value ="อายุรถ">อายุรถ</option>
                                                                            <option   value ="อายุอะไหล่">อายุอะไหล่</option>
                                                                            <option   value ="การใช้งานผิดประเภท">การใช้งานผิดประเภท</option>
                                                                            <option   value ="การซ่อมบำรุงรักษาที่ไม่ได้ประสิทธิภาพ">การซ่อมบำรุงรักษาที่ไม่ได้ประสิทธิภาพ</option>

                                                                        </select>
                                                                    </div>

                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="panel panel-default">
                                                                        <div class="panel-heading" style="background-color: #f8f8f8;text-align: center">
                                                                            <label>สถานที่ซ่อม</label>
                                                                        </div>
                                                                        <!-- /.panel-heading -->
                                                                        <div class="panel-body" >
                                                                            <div class="row">
                                                                                <div class="col-lg-6 text-center">
                                                                                    <div class="form-group">
                                                                                        <label>ภายใน</label>
                                                                                        <input type="radio"  class="form-control" id="ld_repairarea1" name="ld_repairarea" <?= $readonly_rtd ?>>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-6 text-center">
                                                                                    <div class="form-group">
                                                                                        <label>ภานนอก</label>
                                                                                        <input type="radio"  class="form-control" id="ld_repairarea2" name="ld_repairarea" <?= $readonly_rtd ?>>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-12">
                                                                                    <div class="form-group">
                                                                                        <label>สถานที่ซ่อมนอก :</label>
                                                                                        <input type="text"  class="form-control" id="txt_repairarea" name="txt_repairarea" <?= $readonly_rtd ?>>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <!-- .panel-body -->
                                                                    </div>
                                                                    <!-- /.panel -->
                                                                </div>


                                                            </div>


                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #f8f8f8">
                                                        ก่อนแก้ไข
                                                    </div>
                                                    <div class="panel-body" style="background-color: #ffffff">

                                                        <div class="row" >


                                                            <form action="meg_imagebefore1.php" method="post" enctype="multipart/form-data" id="MyUploadForm1">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>(IMG 1)</label>
                                                                        <input  <?= $readonly_tenko ?> name="image_editbefore1"  id="txt_editbefore1" type="file" class="form-control"/>
                                                                    </div>

                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>&nbsp;</label><br>


                                                                        <input type="submit" <?= $readonly_tenko ?> id="submit-btn" value="Upload" onclick="chk_uploadbefore1()" class="btn btn-default"/>


                                                                    </div>

                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="row" >
                                                            <form action="meg_imagebefore2.php" method="post" enctype="multipart/form-data" id="MyUploadForm2">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>(IMG 2)</label>
                                                                        <input  <?= $readonly_tenko ?> name="image_editbefore2"  id="txt_editbefore2" type="file" class="form-control"/>
                                                                    </div>

                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>&nbsp;</label><br>


                                                                        <input type="submit" <?= $readonly_tenko ?> id="submit-btn" value="Upload" onclick="chk_uploadbefore2()" class="btn btn-default"/>


                                                                    </div>

                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="row" >
                                                            <form action="meg_imagebefore3.php" method="post" enctype="multipart/form-data" id="MyUploadForm3">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>(IMG 3)</label>
                                                                        <input  <?= $readonly_tenko ?> name="image_editbefore3"  id="txt_editbefore3" type="file" class="form-control"/>
                                                                    </div>

                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>&nbsp;</label><br>


                                                                        <input type="submit" <?= $readonly_tenko ?> id="submit-btn" value="Upload" onclick="chk_uploadbefore3()" class="btn btn-default"/>


                                                                    </div>

                                                                </div>
                                                            </form>



                                                        </div>
                                                        <div class="row">

                                                            <div class="col-lg-4" id="output1"></div>
                                                            <div class="col-lg-4" id="output2"></div>
                                                            <div class="col-lg-4" id="output3"></div>

                                                        </div>
                                                        <!-- /.row (nested) -->
                                                    </div>
                                                    <!-- /.panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #f8f8f8">
                                                        หลังแก้ไข
                                                    </div>
                                                    <div class="panel-body" style="background-color: #ffffff">
                                                        <?php
                                                        if ($result_seEHR1['Company_Code'] != 'RTD') {
                                                            ?>
                                                            <div class="col-lg-4"><label>หลังแก้ไข (IMG1)</label><br><img src="uploads/<?= $result_seImgafter1['IMAGESPATH'] ?>" width="200"></div>
                                                            <div class="col-lg-4"><label>หลังแก้ไข (IMG2)</label><br><img src="uploads/<?= $result_seImgafter2['IMAGESPATH'] ?>" width="200"></div>
                                                            <div class="col-lg-4"><label>หลังแก้ไข (IMG3)</label><br><img src="uploads/<?= $result_seImgafter3['IMAGESPATH'] ?>" width="200"></div>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <div class="row" >

                                                                <form action="meg_imageaffter1.php" method="post" enctype="multipart/form-data" id="MyUploadForm4">
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label>(IMG 1)</label><br>
                                                                            <input <?= $readonly_rtd ?> class="form-control"  type="file" name="image_editaffter1"  id="txt_editaffter1" >

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label>&nbsp;</label><br>


                                                                            <input type="submit" <?= $readonly_rtd ?> id="submit-btn" onclick="chk_uploadaffter1()" value="Upload" class="btn btn-default"/>


                                                                        </div>

                                                                    </div>
                                                                </form>

                                                            </div>
                                                            <div class="row" >


                                                                <form action="meg_imageaffter2.php" method="post" enctype="multipart/form-data" id="MyUploadForm5">
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label>(IMG 2)</label><br>
                                                                            <input <?= $readonly_rtd ?> class="form-control"  type="file" name="image_editaffter2"  id="txt_editaffter2" >

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label>&nbsp;</label><br>


                                                                            <input type="submit" <?= $readonly_rtd ?> id="submit-btn" onclick="chk_uploadaffter2()" value="Upload" class="btn btn-default"/>


                                                                        </div>

                                                                    </div>
                                                                </form>

                                                            </div>
                                                            <div class="row" >


                                                                <form action="meg_imageaffter3.php" method="post" enctype="multipart/form-data" id="MyUploadForm6">
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label>(IMG 3)</label><br>
                                                                            <input <?= $readonly_rtd ?> class="form-control"  type="file" name="image_editaffter3"  id="txt_editaffter3" >

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label>&nbsp;</label><br>


                                                                            <input type="submit" <?= $readonly_rtd ?> id="submit-btn" onclick="chk_uploadaffter3()" value="Upload" class="btn btn-default"/>


                                                                        </div>

                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="row" >

                                                                <div class="col-lg-4" id="output4"></div>
                                                                <div class="col-lg-5" id="output5"></div>
                                                                <div class="col-lg-6" id="output6"></div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>

                                                        <!-- /.row (nested) -->
                                                    </div>
                                                    <!-- /.panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                            <!-- /.col-lg-12 -->
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #f8f8f8">
                                                        ข้อมูลพนักงานขับรถ
                                                    </div>
                                                    <div class="panel-body" style="background-color: #ffffff">
                                                        <div class="row" >
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>ชื่อพนักงาน : </label>

                                                                </div>

                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>ตำแหน่ง : </label>

                                                                </div>

                                                            </div>

                                                        </div>
                                                        <div class="row" >

                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>สายงาน : -</label>

                                                                </div>

                                                            </div>

                                                        </div>
                                                        <!-- /.row (nested) -->
                                                    </div>
                                                    <!-- /.panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #f8f8f8">
                                                        ข้อมูลรถ
                                                    </div>
                                                    <div class="panel-body" style="background-color: #ffffff">
                                                        <div class="row" >
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>ชื่อรถ : </label>

                                                                </div>

                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>ทะเบียน : </label>

                                                                </div>

                                                            </div>

                                                        </div>
                                                        <div class="row" >


                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>สายงาน : -</label>

                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!-- /.row (nested) -->
                                                    </div>
                                                    <!-- /.panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                            <!-- /.col-lg-12 -->
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <input type="button" onclick="save_repair('', '1');" name="btnSend" id="btnSend" value="บันทึกข้อมูล" class="btn btn-primary">

                                            </div>
                                        </div>

                                        <!-- /.row (nested) -->
                                    </div>

                                </div>
                                <div id="datasr_edit"></div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>




                </div>
                <div id="datasr_edit">

                </div>
                <div class="row" >
                    <div class="col-lg-12">
                        &nbsp;

                    </div>
                </div>
                <div class="row">
                    <?php
                    $sql_getDate = "{call megStopwork_v2(?)}";
                    $params_getDate = array(
                        array('select_getdate', SQLSRV_PARAM_IN)
                    );
                    $query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
                    $result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);
                    ?>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>ค้นหาตามช่วงวันที่</label>
                            <input class="form-control dateen"  id="txt_datestart" onchange="datetodate();" readonly="" style="background-color: #f080802e" name="txt_datestart" value="<?= $result_getDate['SYSDATE'] ?>" placeholder="วันที่เริ่มต้น">

                        </div>

                    </div>
                    <div class="col-lg-2">
                        <label>&nbsp;</label>
                        <div class="form-group">
                            <input type="text" class="form-control dateen" id="txt_dateend" readonly="" style="background-color: #f080802e" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE'] ?>">

                        </div>
                    </div>
                    <div class="col-lg-2">
                        <label>&nbsp;</label>
                        <div class="form-group">
                            <button type="button" class="btn btn-default" onclick="select_repair();">ค้นหา <li class="fa fa-search"></li></button>
                        </div>

                    </div>
                    <div class="col-lg-6 text-right">
                        <label>&nbsp;</label>
                        <div class="form-group">

                            <!--<a href="#" onclick="pdf_repair1();" class="btn btn-default">พิมพ์ <li class="fa fa-print"></li></a>-->
                            <a href="#" onclick="excel_repair1();" class="btn btn-default">รายงาน <li class="fa fa-file-excel-o"></li></a>

                        </div>

                    </div>

                </div>   
                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">
                                <font style="font-size: 16px"><b>ประวัติการแจ้งซ่อมของพนักงาน</b></font>                            
                            </div>
                            <div class="panel-body">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                    <div class="row">


                                        <div class="col-sm-12">
                                            <div id="datadef">
                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example2" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2">ลำดับ</th>
                                                            <th rowspan="2">วันที่</th>
                                                            <th rowspan="2">DRIVER</th>
                                                            <th rowspan="2">SECTION</th>
                                                            <th rowspan="2">ISSUE</th>
                                                            <th rowspan="2">ต้องการใช้รถ</th>
                                                            <th rowspan="2">ลักษณะประเภทงานซ่อม</th>
                                                            <th rowspan="2">สินค้า</th>
                                                            <th rowspan="2">ลักษณะการวิ่งงาน</th>
                                                            <th rowspan="2">จนท.TENKO</th>
                                                            <th colspan="3">ก่อนแก้ไข</th>
                                                            <th colspan="3">หลังแก้ไข</th>
                                                            <th rowspan="2">สาเหตุ</th>
                                                            <th rowspan="2">การแก้ไข</th>
                                                            <th rowspan="2">การป้องกัน</th>
                                                            <th rowspan="2">ช่างผู้รับผิดชอบ</th>
                                                            <th rowspan="2">ผู้รับแจ้งซ่อม</th>
                                                            <th rowspan="2">กำหนดเสร็จ</th>
                                                            <th rowspan="2">สถานะแจ้งซ่อม</th>
                                                            <th rowspan="2">การวิเคาะห์การซ่อม</th>
                                                            <th rowspan="2">สถานที่ซ่อม</th>
                                                            <th rowspan="2">สถานที่ซ่อมนอก</th>
                                                            <th rowspan="2" style="text-align: center">จัดการ</th>
                                                        </tr>
                                                        <tr>
                                                            <th>IMGBEORE(1)</th>
                                                            <th>IMGBEORE(2)</th>
                                                            <th>IMGBEORE(3)</th>
                                                            <th>IMGAFTER(1)</th>
                                                            <th>IMGAFTER(2)</th>
                                                            <th>IMGAFTER(3)</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        $condRepair = " AND CONVERT(DATE,CREATEDATE,103) = CONVERT(DATE,GETDATE(),103)";
                                                        $sql_seRepair = "{call megRepair_v2(?,?)}";
                                                        $params_seRepair = array(
                                                            array('select_repair', SQLSRV_PARAM_IN),
                                                            array($condRepair, SQLSRV_PARAM_IN)
                                                        );


                                                        $query_seRepair = sqlsrv_query($conn, $sql_seRepair, $params_seRepair);
                                                        while ($result_seRepair = sqlsrv_fetch_array($query_seRepair, SQLSRV_FETCH_ASSOC)) {

                                                            if ($result_seRepair['TENKO_PRODUCT'] == '1') {
                                                                $TENKOPRODUCT = 'มีสินค้า';
                                                            } else if ($result_seRepair['TENKO_RUNTYPE'] == '2') {
                                                                $TENKOPRODUCT = 'ไม่มีสินค้า';
                                                            } else {
                                                                $TENKOPRODUCT = '';
                                                            }
                                                            if ($result_seRepair['TENKO_RUNTYPE'] == '1') {
                                                                $TENKORUNTYPE = 'ก่อนวิ่งงาน';
                                                            } else if ($result_seRepair['TENKO_RUNTYPE'] == '2') {
                                                                $TENKORUNTYPE = 'ขณะปฏิบัติงาน';
                                                            } else if ($result_seRepair['TENKO_RUNTYPE'] == '3') {
                                                                $TENKORUNTYPE = 'หลังวิ่งงาน';
                                                            } else {
                                                                $TENKORUNTYPE = '';
                                                            }

                                                            if ($result_seRepair['TEC_REPAIRAREA'] == '1') {
                                                                $REPAIRAREA = 'ภายใน';
                                                            } else if ($result_seRepair['TEC_REPAIRAREA'] == '2') {
                                                                $REPAIRAREA = 'ภานนอก';
                                                            } else {
                                                                $REPAIRAREA = '';
                                                            }

                                                            $sql_seImgbefore1 = "SELECT IMAGESPATH
                                                            FROM
                                                                (SELECT
                                                                        ROW_NUMBER () OVER (ORDER BY IMAGESREPAIRBEFOREID) AS RowNum,IMAGESPATH
                                                                  FROM
                                                                        [RTMS].[dbo].[IMAGESREPAIR_BEFORE] WHERE [EMPLOYEEREPAIRID] = '" . $result_seRepair['EMPLOYEEREPAIRID'] . "'
                                                                ) sub
                                                            WHERE
                                                            RowNum = 1";
                                                            $params_seImgbefore1 = array();
                                                            $query_seImgbefore1 = sqlsrv_query($conn, $sql_seImgbefore1, $params_seImgbefore1);
                                                            $result_seImgbefore1 = sqlsrv_fetch_array($query_seImgbefore1, SQLSRV_FETCH_ASSOC);

                                                            $sql_seImgbefore2 = "SELECT IMAGESPATH
                                                            FROM
                                                                (SELECT
                                                                        ROW_NUMBER () OVER (ORDER BY IMAGESREPAIRBEFOREID) AS RowNum,IMAGESPATH
                                                                  FROM
                                                                        [RTMS].[dbo].[IMAGESREPAIR_BEFORE] WHERE [EMPLOYEEREPAIRID] = '" . $result_seRepair['EMPLOYEEREPAIRID'] . "'
                                                                ) sub
                                                            WHERE
                                                            RowNum = 2";

                                                            $params_seImgbefore2 = array();
                                                            $query_seImgbefore2 = sqlsrv_query($conn, $sql_seImgbefore2, $params_seImgbefore2);
                                                            $result_seImgbefore2 = sqlsrv_fetch_array($query_seImgbefore2, SQLSRV_FETCH_ASSOC);



                                                            $sql_seImgbefore3 = "SELECT IMAGESPATH
                                                            FROM
                                                                (SELECT
                                                                        ROW_NUMBER () OVER (ORDER BY IMAGESREPAIRBEFOREID) AS RowNum,IMAGESPATH
                                                                  FROM
                                                                        [RTMS].[dbo].[IMAGESREPAIR_BEFORE] WHERE [EMPLOYEEREPAIRID] = '" . $result_seRepair['EMPLOYEEREPAIRID'] . "'
                                                                ) sub
                                                            WHERE
                                                            RowNum = 3";
                                                            $params_seImgbefore3 = array();
                                                            $query_seImgbefore3 = sqlsrv_query($conn, $sql_seImgbefore3, $params_seImgbefore3);
                                                            $result_seImgbefore3 = sqlsrv_fetch_array($query_seImgbefore3, SQLSRV_FETCH_ASSOC);




                                                            $sql_seImgaffter1 = "SELECT IMAGESPATH
                                                            FROM
                                                                (SELECT
                                                                        ROW_NUMBER () OVER (ORDER BY IMAGESREPAIRAFTERID) AS RowNum,IMAGESPATH
                                                                  FROM
                                                                        [RTMS].[dbo].[IMAGESREPAIR_AFTER] WHERE [EMPLOYEEREPAIRID] = '" . $result_seRepair['EMPLOYEEREPAIRID'] . "'
                                                                ) sub
                                                            WHERE
                                                            RowNum = 1";
                                                            $params_seImgaffter1 = array();
                                                            $query_seImgaffter1 = sqlsrv_query($conn, $sql_seImgaffter1, $params_seImgaffter1);
                                                            $result_seImgaffter1 = sqlsrv_fetch_array($query_seImgaffter1, SQLSRV_FETCH_ASSOC);

                                                            $sql_seImgaffter2 = "SELECT IMAGESPATH
                                                            FROM
                                                                (SELECT
                                                                        ROW_NUMBER () OVER (ORDER BY IMAGESREPAIRAFTERID) AS RowNum,IMAGESPATH
                                                                  FROM
                                                                        [RTMS].[dbo].[IMAGESREPAIR_AFTER] WHERE [EMPLOYEEREPAIRID] = '" . $result_seRepair['EMPLOYEEREPAIRID'] . "'
                                                                ) sub
                                                            WHERE
                                                            RowNum = 2";
                                                            $params_seImgaffter2 = array();
                                                            $query_seImgaffter2 = sqlsrv_query($conn, $sql_seImgaffter2, $params_seImgaffter2);
                                                            $result_seImgaffter2 = sqlsrv_fetch_array($query_seImgaffter2, SQLSRV_FETCH_ASSOC);

                                                            $sql_seImgaffter3 = "SELECT IMAGESPATH
                                                            FROM
                                                                (SELECT
                                                                        ROW_NUMBER () OVER (ORDER BY IMAGESREPAIRAFTERID) AS RowNum,IMAGESPATH
                                                                  FROM
                                                                        [RTMS].[dbo].[IMAGESREPAIR_AFTER] WHERE [EMPLOYEEREPAIRID] = '" . $result_seRepair['EMPLOYEEREPAIRID'] . "'
                                                                ) sub
                                                            WHERE
                                                            RowNum = 3";
                                                            $params_seImgaffter3 = array();
                                                            $query_seImgaffter3 = sqlsrv_query($conn, $sql_seImgaffter3, $params_seImgaffter3);
                                                            $result_seImgaffter3 = sqlsrv_fetch_array($query_seImgaffter3, SQLSRV_FETCH_ASSOC);
                                                            ?>
                                                            <tr class="odd gradeX">
                                                                <td style="text-align: center"><?= $i ?></td>
                                                                <td><?= $result_seRepair['CREATEDATE'] ?></td>
                                                                <td><?= $result_seRepair['DRIVERNAME'] ?></td>
                                                                <td>-</td>
                                                                <td><?= $result_seRepair['TENKO_ISSUE'] ?></td>
                                                                <td><?= $result_seRepair['TENKO_CARUSEDATE'] ?></td>
                                                                <td><?= $result_seRepair['TENKO_REPAIRTYPE'] ?></td>
                                                                <td><?= $TENKOPRODUCT ?></td>
                                                                <td><?= $TENKORUNTYPE ?></td>
                                                                <td><?= $result_seRepair['TENKO_INFROM'] ?></td>
                                                                <td><a href="#" data-toggle="modal"  data-target="#modal_image" onclick="modalimage('<?= $result_seImgbefore1['IMAGESPATH'] ?>')"><?= $result_seImgbefore1['IMAGESPATH'] ?></a></td>
                                                                <td><a href="#" data-toggle="modal"  data-target="#modal_image" onclick="modalimage('<?= $result_seImgbefore2['IMAGESPATH'] ?>')"><?= $result_seImgbefore2['IMAGESPATH'] ?></a></td>
                                                                <td><a href="#" data-toggle="modal"  data-target="#modal_image" onclick="modalimage('<?= $result_seImgbefore3['IMAGESPATH'] ?>')"><?= $result_seImgbefore3['IMAGESPATH'] ?></a></td>
                                                                <td><a href="#" data-toggle="modal"  data-target="#modal_image" onclick="modalimage('<?= $result_seImgaffter1['IMAGESPATH'] ?>')"><?= $result_seImgaffter1['IMAGESPATH'] ?></a></td>
                                                                <td><a href="#" data-toggle="modal"  data-target="#modal_image" onclick="modalimage('<?= $result_seImgaffter2['IMAGESPATH'] ?>')"><?= $result_seImgaffter2['IMAGESPATH'] ?></a></td>
                                                                <td><a href="#" data-toggle="modal"  data-target="#modal_image" onclick="modalimage('<?= $result_seImgaffter3['IMAGESPATH'] ?>')"><?= $result_seImgaffter3['IMAGESPATH'] ?></a></td>
                                                                <td><?= $result_seRepair['TEC_CAUSE'] ?></td>
                                                                <td><?= $result_seRepair['TEC_EDIT'] ?></td>
                                                                <td><?= $result_seRepair['TEC_PROTECT'] ?></td>
                                                                <td><?= $result_seRepair['TEC_TECHNICIAN'] ?></td>
                                                                <td><?= $result_seRepair['TEC_INFROM'] ?></td>
                                                                <td><?= $result_seRepair['TEC_COMPLETED'] ?></td>
                                                                <td><?= $result_seRepair['REPAIRSTATUS'] ?></td>
                                                                <td><?= $result_seRepair['TEC_ANALYZE'] ?></td>
                                                                <td><?= $REPAIRAREA ?></td>
                                                                <td><?= $result_seRepair['TEC_REPAIRAREADETAIL'] ?></td>

                                                                <td style="text-align: center">
                                                                    <button onclick="showupdate_repair('<?= $result_seRepair['EMPLOYEEREPAIRID'] ?>');" title="แก้ไขข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-search"></span></button>
                                                                    <button onclick="delete_repair('<?= $result_seRepair['EMPLOYEEREPAIRID'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                                                </td>

                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                        ?>



                                                    </tbody>

                                                </table>
                                            </div>
                                            <div id="datasr"></div>

                                        </div>

                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>

        </div>






        <!--<script src="../vendor/jquery/jquery.min.js"></script>-->
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/raphael/raphael.min.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>

        <script src="../dist/js/jszip.min.js"></script>
        <script src="../dist/js/dataTables.buttons.min.js"></script>
        <script src="../dist/js/buttons.html5.min.js"></script>
        <script src="../dist/js/buttons.print.min.js"></script>



        <script src="../dist/js/jquery.autocomplete.js"></script>

        <?php
        $job = '';
        if ($_GET['companycode'] == 'RRC' && $_GET['customercode'] == 'GMT') {
            $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', '');
        }
        if ($_GET['companycode'] == 'RRC' && $_GET['customercode'] == 'BP') {
            $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', '');
        }
        if ($_GET['companycode'] == 'RRC' && $_GET['customercode'] == 'TTAST') {
            $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', '');
        }
        if ($_GET['companycode'] == 'RRC' && $_GET['customercode'] == 'TTTC') {
            $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', '');
        } else if ($_GET['companycode'] == 'RCC' && $_GET['customercode'] == 'TTT') {
            $job = select_jobautocomplate('megVehicletransportprice_v2', 'select_beginjob', '');
        } else if ($_GET['companycode'] == 'RATC' && $_GET['customercode'] == 'TTT') {
            $job = select_jobautocomplate('megVehicletransportprice_v2', 'select_beginjob', '');
        }
        if ($_GET['companycode'] == 'RRC' || $_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RATC') {
            $thainame = select_carautocomplate('megVehicleinfo_v2', 'selectcond_vehicleinfo', " AND a.THAINAME != '-' AND (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%'", " OR a.THAINAME LIKE '%ดินแดง%'  OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%'  ", " OR a.THAINAME LIKE '%RP-%' OR a.THAINAME  LIKE '%สวนผึ้ง%' OR a.THAINAME  LIKE '%ด่านช้าง%'", " OR a.ENGNAME LIKE '%Khao Chamao%' OR a.ENGNAME LIKE '%Kerry%' OR a.ENGNAME LIKE '%Chaloem Prakiat%')");
        } else {
            $thainame = select_vehiclenumberautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', '');
        }
        $jobrccend = select_jobautocomplateendgetway('megVehicletransportprice_v2', 'select_to', '');

        $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeeehr2', "");
        $emp_rtd = select_empautocomplate('megEmployeeEHR_v2', 'select_employeeehr2', " AND a.Company_Code  IN ('RTD') ");
        $emp_rtdsuperamata = select_empautocomplate('megEmployeeEHR_v2', 'select_employeeehr2', " AND a.Company_Code  IN ('RTD') AND a.PersonCode IN ('060132','060065','060123') ");

        $cluster = select_clusterautocomplate('megVehicletransportprice_v2', 'select_cluster', '');
        ?>


        <?php
        $vehiclenumber = select_vehiclenumberautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', '');
        ?>

        <script type="text/javascript">
                                                                    function pdf_repair1()
                                                                    {

                                                                        var datestart = document.getElementById('txt_datestart').value;
                                                                        var dateend = document.getElementById('txt_dateend').value;

                                                                        window.open('pdf_repair1.php?datestart=' + datestart + '&dateend=' + dateend, '_blank');


                                                                    }
                                                                    function chk_uploadbefore1()
                                                                    {

                                                                        document.getElementById('txt_chkbefore1').value = '1';
                                                                    }
                                                                    function chk_uploadbefore2()
                                                                    {

                                                                        document.getElementById('txt_chkbefore2').value = '1';
                                                                    }
                                                                    function chk_uploadbefore3()
                                                                    {

                                                                        document.getElementById('txt_chkbefore3').value = '1';
                                                                    }
                                                                    function chk_uploadaffter1()
                                                                    {
                                                                        document.getElementById('txt_chkaffter1').value = '1';
                                                                    }
                                                                    function chk_uploadaffter2()
                                                                    {
                                                                        document.getElementById('txt_chkaffter2').value = '1';
                                                                    }
                                                                    function chk_uploadaffter3()
                                                                    {
                                                                        document.getElementById('txt_chkaffter3').value = '1';
                                                                    }
                                                                    $(document).ready(function () {
                                                                        $('#dataTables-example2').DataTable({
                                                                            responsive: true
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
                                                                    $(function () {
                                                                        $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                        // กรณีใช้แบบ input
                                                                        $(".datetimeen").datetimepicker({
                                                                            timepicker: true,
                                                                            dateformat: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                                                                            lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                            timeFormat: "HH:mm"

                                                                        }
                                                                        );
                                                                    });
                                                                    function gdatetodate()
                                                                    {
                                                                        document.getElementById('txt_gdateend').value = document.getElementById('txt_gdatestart').value;
                                                                    }
                                                                    function datetodate()
                                                                    {
                                                                        document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

                                                                    }
                                                                    function select_repair()
                                                                    {


                                                                        var datestart = document.getElementById('txt_datestart').value;
                                                                        var dateend = document.getElementById('txt_dateend').value;

                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_repair", datestart: datestart, dateend: dateend, employeeid: '<?= $_GET['employeeid'] ?>'
                                                                            },
                                                                            success: function (response) {
                                                                                if (response)
                                                                                {
                                                                                    document.getElementById("datasr").innerHTML = response;
                                                                                    document.getElementById("datadef").innerHTML = "";

                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-example2').DataTable({
                                                                                            responsive: true
                                                                                        });
                                                                                    });
                                                                                }




                                                                                var txt_carname = [<?= $vehiclenumber ?>];
                                                                                $(function () {
                                                                                    $("#txt_carname").autocomplete({
                                                                                        source: [txt_carname]
                                                                                    });


                                                                                });




                                                                            }
                                                                        });
                                                                        //}

                                                                    }

        </script>
        <script type="text/javascript">

            
            
            var txt_employee1 = [<?= $emp ?>];
            $(function () {
                $("#txt_employee1").autocomplete({
                    source: [txt_employee1]
                });


            });
            
            var txt_technician = [<?= $emp_rtd ?>];
            $(function () {
                $("#txt_technician").autocomplete({
                    source: [txt_technician]
                });


            });

            var txt_carname = [<?= $vehiclenumber ?>];

            $(function () {
                $("#txt_carname").autocomplete({
                    source: [txt_carname]
                });


            });
            function showupdate_repair(val)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "showupdate_repair", employeerepairid: val
                    },
                    success: function (response) {
                        if (response)
                        {
                            document.getElementById("datasr_edit").innerHTML = response;
                            document.getElementById("datadef_edit").innerHTML = "";

                        }


                        var txt_technician = [<?= $emp_rtd ?>];
                        $(function () {
                            $("#txt_technician").autocomplete({
                                source: [txt_technician]
                            });


                        });




                        var txt_carname = [<?= $vehiclenumber ?>];
                        $(function () {
                            $("#txt_carname").autocomplete({
                                source: [txt_carname]
                            });


                        });

                        $(function () {
                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                            // กรณีใช้แบบ input
                            $(".datetimeen").datetimepicker({
                                timepicker: true,
                                dateformat: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                timeFormat: "HH:mm"

                            }
                            );
                        });




                        $(document).ready(function () {
                            var options1 = {
                                target: '#output1', // target element(s) to be updated with server response 
                                beforeSubmit1: beforeSubmit1, // pre-submit callback 
                                success: afterSuccess, // post-submit callback 
                                resetForm: true        // reset the form after successful submit 
                            };

                            var options2 = {
                                target: '#output2', // target element(s) to be updated with server response 
                                beforeSubmit2: beforeSubmit2, // pre-submit callback 
                                success: afterSuccess, // post-submit callback 
                                resetForm: true        // reset the form after successful submit 
                            };
                            var options3 = {
                                target: '#output3', // target element(s) to be updated with server response 
                                beforeSubmit3: beforeSubmit3, // pre-submit callback 
                                success: afterSuccess, // post-submit callback 
                                resetForm: true        // reset the form after successful submit 
                            };

                            var options4 = {
                                target: '#output4', // target element(s) to be updated with server response 
                                affterSubmit1: affterSubmit1, // pre-submit callback 
                                success: afterSuccess, // post-submit callback 
                                resetForm: true        // reset the form after successful submit 
                            };

                            var options5 = {
                                target: '#output5', // target element(s) to be updated with server response 
                                affterSubmit2: affterSubmit2, // pre-submit callback 
                                success: afterSuccess, // post-submit callback 
                                resetForm: true        // reset the form after successful submit 
                            };
                            var options6 = {
                                target: '#output6', // target element(s) to be updated with server response 
                                affterSubmit3: affterSubmit3, // pre-submit callback 
                                success: afterSuccess, // post-submit callback 
                                resetForm: true        // reset the form after successful submit 
                            };



                            $('#MyUploadForm1').submit(function () {
                                $(this).ajaxSubmit(options1);
                                // always return false to prevent standard browser submit and page navigation 
                                return false;
                            });
                            $('#MyUploadForm2').submit(function () {
                                $(this).ajaxSubmit(options2);
                                // always return false to prevent standard browser submit and page navigation 
                                return false;
                            });
                            $('#MyUploadForm3').submit(function () {
                                $(this).ajaxSubmit(options3);
                                // always return false to prevent standard browser submit and page navigation 
                                return false;
                            });
                            $('#MyUploadForm4').submit(function () {
                                $(this).ajaxSubmit(options4);
                                // always return false to prevent standard browser submit and page navigation 
                                return false;
                            });
                            $('#MyUploadForm5').submit(function () {
                                $(this).ajaxSubmit(options5);
                                // always return false to prevent standard browser submit and page navigation 
                                return false;
                            });
                            $('#MyUploadForm6').submit(function () {
                                $(this).ajaxSubmit(options6);
                                // always return false to prevent standard browser submit and page navigation 
                                return false;
                            });


                        });

                        function afterSuccess()
                        {
                            $('#submit-btn').show(); //hide submit button
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
                        function beforeSubmit2() {
                            //check whether browser fully supports all File API
                            if (window.File && window.FileReader && window.FileList && window.Blob)
                            {


                                if (!$('#txt_editbefore2').val()) //check empty input filed
                                {
                                    $("#output2").html("Are you kidding me?");
                                    return false
                                }





                                var fsize = $('#txt_editbefore2')[0].files[0].size; //get file size
                                var ftype = $('#txt_editbefore2')[0].files[0].type; // get file type







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
                        function beforeSubmit3() {
                            //check whether browser fully supports all File API
                            if (window.File && window.FileReader && window.FileList && window.Blob)
                            {


                                if (!$('#txt_editbefore3').val()) //check empty input filed
                                {
                                    $("#output3").html("Are you kidding me?");
                                    return false
                                }





                                var fsize = $('#txt_editbefore3')[0].files[0].size; //get file size
                                var ftype = $('#txt_editbefore3')[0].files[0].type; // get file type







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
                        function affterSubmit1() {
                            //check whether browser fully supports all File API
                            if (window.File && window.FileReader && window.FileList && window.Blob)
                            {


                                if (!$('#txt_editaffter1').val()) //check empty input filed
                                {
                                    $("#output4").html("Are you kidding me?");
                                    return false
                                }





                                var fsize = $('#txt_editaffter1')[0].files[0].size; //get file size
                                var ftype = $('#txt_editaffter1')[0].files[0].type; // get file type







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
                        function affterSubmit2() {
                            //check whether browser fully supports all File API
                            if (window.File && window.FileReader && window.FileList && window.Blob)
                            {


                                if (!$('#txt_editaffter2').val()) //check empty input filed
                                {
                                    $("#output5").html("Are you kidding me?");
                                    return false
                                }





                                var fsize = $('#txt_editaffter2')[0].files[0].size; //get file size
                                var ftype = $('#txt_editaffter2')[0].files[0].type; // get file type







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
                        function affterSubmit3() {
                            //check whether browser fully supports all File API
                            if (window.File && window.FileReader && window.FileList && window.Blob)
                            {


                                if (!$('#txt_editaffter3').val()) //check empty input filed
                                {
                                    $("#output6").html("Are you kidding me?");
                                    return false
                                }





                                var fsize = $('#txt_editaffter3')[0].files[0].size; //get file size
                                var ftype = $('#txt_editaffter3')[0].files[0].type; // get file type







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


                        //function to check file size before uploading.





                        $(function () {
                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                            // กรณีใช้แบบ input
                            $(".dateen").datetimepicker({
                                timepicker: false,
                                format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                            });
                        });


                    }
                });
            }
            function modalimage(val)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_modalimage", modalimage: val
                    },
                    success: function (response) {

                        if (response)
                        {
                            document.getElementById("modalimage").innerHTML = response;


                        }




                    }
                });
            }
            function delete_repair(val)
            {
                var confirmation = confirm("ต้องการลบข้อมูล ?");

                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_repair", employeerepairid: val
                        },
                        success: function () {
                            alert('ลบข้อมูลเรียบร้อยแล้ว');
                            window.location.reload();


                        }
                    });

                }




            }
            function excel_repair1()
            {
                var datestart = document.getElementById('txt_datestart').value;
                var dateend = document.getElementById('txt_dateend').value;

                window.open('excel_repair1.php?datestart=' + datestart + '&dateend=' + dateend + '&employeecode=' +document.getElementById('txt_employee1').value, '_blank');
            }

            function change_repairtype()
            {
                document.getElementById('cb_repairtype2').value = document.getElementById('cb_repairtype').value;
            }
            function change_repairtype2()
            {
                document.getElementById('cb_repairtype').value = document.getElementById('cb_repairtype2').value;
            }
            function change_repairstatus()
            {
                document.getElementById('cb_repairstatus2').value = document.getElementById('cb_repairstatus1').value;
            }
            function change_repairstatus2()
            {
                document.getElementById('cb_repairstatus1').value = document.getElementById('cb_repairstatus2').value;
            }
            function save_repair(employeerepairid, type)
            {
                 if (document.getElementById('txt_employee1').value == "")
                {
                    alert("พนักงานเป็นค่าว่าง !");
                    document.getElementById('txt_employee1').focus();
                }
                else if (document.getElementById('txt_carname').value == "")
                {
                     alert("ทะเบียนรถเป็นค่าว่าง !");
                     document.getElementById('txt_carname').focus();
                    
                }
                else if (document.getElementById('cb_repairstatus1').value == "")
                {
                     alert("สถานะการซ่อมเป็นค่าว่าง !");
                     document.getElementById('cb_repairstatus1').focus();
                    
                }
                else if (document.getElementById('txt_carusedate').value == "")
                {
                     alert("ต้องการใช้รถเป็นค่าว่าง !");
                     document.getElementById('txt_carusedate').focus();
                    
                }
                else if (document.getElementById('cb_repairtype').value == "")
                {
                     alert("ลักษณะประเภทงานซ่อมเป็นค่าว่าง !");
                    document.getElementById('cb_repairtype').focus();
                }
               
                
                else
                {
                    var employeerepairid = employeerepairid;
                    var txtempinform2 = document.getElementById('txt_empinform2').value;
                    var txtcarname = document.getElementById('txt_carname').value;
                    var txtissue = document.getElementById('txt_issue').value;
                    var txtremark1 = '';
                    var txtcarname = document.getElementById('txt_carname').value;
                    var txtissue = document.getElementById('txt_issue').value;
                    var txtcarusedate = document.getElementById('txt_carusedate').value;
                    var txtrepairarea = document.getElementById('txt_repairarea').value;

                    var ldproduct = "";
                    var ldruntype = "";
                    var ldrepairarea = "";
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

                    if (ld_repairarea1.checked == true)
                    {
                        ldrepairarea = '1';
                    }
                    if (ld_repairarea2.checked == true)
                    {
                        ldrepairarea = '2';
                    }

                    var txttechnician = document.getElementById('txt_technician').value;
                    var txtcompleted = document.getElementById('txt_completed').value;
                    var txtcause = document.getElementById('txt_cause').value;
                    var txtedit = document.getElementById('txt_edit').value;
                    var txtprotect = document.getElementById('txt_protect').value;
                    var repairstatus1 = document.getElementById('cb_repairstatus1').value;
                    var repairstatus2 = document.getElementById('cb_repairstatus2').value;
                    var repairtype = document.getElementById('cb_repairtype').value;
                    var repairanalyze2 = document.getElementById('cb_repairanalyze2').value;

                    var txtremark2 = '';
                    if ('<?= $result_seEHR1['Company_Code'] ?>' != 'RTD')
                    {
                        if (document.getElementById('txt_chkbefore1').value == '1')
                        {
                            var tenkobeforeedit = document.getElementById('IMGBEFORE1').value;
                        } else
                        {
                            var tenkobeforeedit = '';
                        }
                        if (document.getElementById('txt_chkbefore2').value == '1')
                        {
                            var tenkobeforeedit2 = document.getElementById('IMGBEFORE2').value;
                        } else
                        {
                            var tenkobeforeedit2 = '';
                        }
                        if (document.getElementById('txt_chkbefore3').value == '1')
                        {
                            var tenkobeforeedit3 = document.getElementById('IMGBEFORE3').value;
                        } else
                        {
                            var tenkobeforeedit3 = '';
                        }

                        if (document.getElementById('txt_chkaffter1').value == '1')
                        {
                            var tecaffteredit = document.getElementById('IMGAFFTER1').value;
                        } else
                        {
                            var tecaffteredit = '';
                        }
                        if (document.getElementById('txt_chkaffter2').value == '1')
                        {
                            var tecaffteredit2 = document.getElementById('IMGAFFTER2').value;
                        } else
                        {
                            var tecaffteredit2 = '';
                        }
                        if (document.getElementById('txt_chkaffter3').value == '1')
                        {
                            var tecaffteredit3 = document.getElementById('IMGAFFTER3').value;
                        } else
                        {
                            var tecaffteredit3 = '';
                        }
                    }

                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            //txt_flg: "save_repair", employeerepairid: employeerepairid, drivername: '<?//= $result_seEHR['nameT'] ?>',
                            txt_flg: "save_repair", employeerepairid: employeerepairid, drivername:document.getElementById('txt_employee1').value,
                            vehiclename: txtcarname, tenko_infrom: '<?= ($result_seEHR1['Company_Code'] != 'RTD') ? $result_seEHR1['nameT'] : ''; ?>', tenko_issue: txtissue,
                            tenko_beforeedit: tenkobeforeedit,
                            tenko_beforeedit2: tenkobeforeedit2,
                            tenko_beforeedit3: tenkobeforeedit3,
                            tec_affteredit: tecaffteredit,
                            tec_affteredit2: tecaffteredit2,
                            tec_affteredit3: tecaffteredit3,
                            tenko_remark: txtremark1,
                            tec_infrom: txtempinform2, tec_technician: txttechnician, tec_completed: txtcompleted, tec_cause: txtcause,
                            tec_edit: txtedit, tec_protect: txtprotect, tec_remark: txtremark2, repairstatus1: repairstatus1, repairstatus2: repairstatus2,
                            remark: '', activestatus: '1', type: type, txtcarusedate: txtcarusedate, ldproduct: ldproduct, ldruntype: ldruntype,
                            repairtype: repairtype, repairanalyze2: repairanalyze2, ldrepairarea: ldrepairarea, txtrepairarea: txtrepairarea
                        },
                        success: function (response) {

                            alert(response);
                            window.location.reload();
                        }
                    });
                   
                }
            }

        </script>






    </body>

</html>
<?php
sqlsrv_close($conn);
?>